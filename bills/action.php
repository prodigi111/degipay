<?php
if(isset($_POST['buypostpaid'])) {
    $pip = client_ip();
    $pcode = filter($_POST['service']);
    $pdata = filter($_POST['data']);
    $data2 = filter($_POST['data2']);
    $tanggal = date("Y-m-d", strtotime($data2));
    $WebID = random_number(8);
    $TrxID = random(10);
    if($call->query("SELECT * FROM srv WHERE code = '$pcode' AND type = 'pascabayar' AND status = 'available'")->num_rows == true) {
        $data_service = $call->query("SELECT * FROM srv WHERE code = '$pcode' AND status = 'available'")->fetch_assoc();
        $service = $data_service['name'];
        $server = $data_service['provider'];
        
        if($data_service['provider'] == 'DIGI') $try = $DIGI->CheckBillTEST($pcode,$pdata,$TrxID);
        else $try = ['result' => false,'message' => $try['message']];
        $errMSG = (stristr(strtolower($try['message']),'saldo') || stristr(strtolower($try['message']),'balance')) ? 'System Error.' : $try['message'];
        
       $bill = ($try['result'] == true) ? $try['data']['price'] : 0;
        if($data_user['level'] == 'Basic') {
            $admin = conf('trxadmin', 3);
        } else {
            $admin = conf('trxadmin', 4);
        }
        
        $price = $bill+$admin;
        $profit = price($data_user['level'],$data_service['price'],$data_service['provider'],'profit');
        
        $order_tot = $call->query("SELECT * FROM trx WHERE data LIKE '%$pdata%' AND date_cr LIKE '%$date%' AND code = '$pcode'")->num_rows;
        $order_target = ($order_tot > 0) ? ($order_tot + 1).'.'.$pdata : $pdata;
    }
        $json = [];
    $DigiData = $DIGI->CheckBalance();
    if($DigiData['result'] == true) $call->query("UPDATE provider SET balance = '".$DigiData['data']['balance']."', sync = '$date $time' WHERE code = 'DIGI'");
    $prov = $call->query("SELECT * FROM provider WHERE code = '$server'")->fetch_assoc();
    
    if($result_csrf == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'System error, please try again later.'];
    } else if($_CONFIG['mt']['web'] == 'true') {
        $_SESSION['result'] = ['type' => false,'message' => 'Aplikasi sedang dalam perbaikan.'];
    } else if($sess_username == 'demo') {
        $_SESSION['result'] = ['type' => false,'message' => 'Akun demo tidak memiliki izin untuk mengakses fitur ini.'];
    } else if($data_user['status'] == 'locked') {
        $_SESSION['result'] = ['type' => false,'message' =>'Transaksi di bekukan, silahkan hubungi Admin.'];
    } else if($call->query("SELECT * FROM srv WHERE code = '$pcode' AND type = 'pascabayar' AND status = 'available'")->num_rows == 0) {
        $_SESSION['result'] = ['type' => false,'message' => 'Layanan tidak ditemukan.'];
    } else if(!$pcode || !$pdata) {
        $_SESSION['result'] = ['type' => false,'message' => 'Masih ada formulir kosong.'];
    } else if($call->query("SELECT * FROM trx WHERE data = '$pdata' AND code = '$pcode' AND status = 'processing'")->num_rows == 1) {
        $_SESSION['result'] = ['type' => false,'message' => 'Ada pesanan dengan data yang sama dan sedang diproses.'];
    } else if($call->query("SELECT * FROM provider WHERE code = '$server'")->num_rows == 0) {
        $_SESSION['result'] = ['type' => false,'message' => 'Our server is in trouble, please try again later.'];
    } else if($try['result'] == false) {
        $_SESSION['result'] = ['type' => false,'message' => $errMSG];
    } else if($data_user['balance'] < $price) {
        $_SESSION['result'] = ['type' => false,'message' => 'Saldo anda tidak mencukupi untuk melakukan pemesanan ini.'];
    } else if($prov['balance'] < $price-$profit) {
        $_SESSION['result'] = ['type' => false,'message' => 'Tidak dapat melakukan transaksi, silahkan coba beberapa saat lagi.'];
    } else {
        if($call->query("INSERT INTO trx VALUES ('','$WebID','$TrxID','$sess_username','$pcode','$service','-','$pdata','','$price','$profit','processing','0','0','0','WEB,$pip','postpaid','YES','$tanggal $time','$tanggal $time','$server')") == true) {
            $cut_user =   $call->query("UPDATE users SET balance = balance-$price WHERE username = '$sess_username'");
            if($server == 'DIGI')  {
                if($cut_user == TRUE) {
                    $json = $DIGI->PayBillTEST($pcode,$order_target,$TrxID);
                }
            } else { 
                $json = ['result' => false,'message' => 'Server error.'];
                
            }
            
            // proses order
            ###############################
            if($json['result'] == true) {
                $trx_id = $json['data']['trxid'];
                $trx_st = $json['data']['status'];
                $trx_note = $json['data']['note'];
                $trx_customer_name = $json['data']['customer_name'];
                $trx_last = $json['data']['balance'];
            } else {
                $trx_error = $json['message'];
            }
            ###############################
            
            if($json['result'] == true) {
              
                $call->query("INSERT INTO mutation VALUES ('', '$sess_username', '-', '$price', 'Order #$WebID | $pdata', '$date', '$time', 'Transaksi')");
                $call->query("INSERT INTO logs VALUES ('', '$sess_username', 'order', '$pip', '$date $time')");
                $call->query("UPDATE trx SET note = '$trx_note', costumer_name = '$trx_customer_name', status = '$trx_st' WHERE tid = '$TrxID'");
                $call->query("UPDATE provider SET balance = '$trx_last' WHERE code = '$server'");
                $phone = $data_user['phone'];
                $WATL->sendMessage($phone, "Hallo, *{$data_user['name']}*\nID Pesanan *#{$WebID}* \nPesanan : *{$service}* \nStatus : *Pending* \nCatatan: *Transaksi Pending* \n----------------------------------------------\n*Terimakasih sudah memilih {$_CONFIG['title']}*");
                
                $fcm_token = $call->query("SELECT * FROM users_token WHERE user = '$sess_username'")->fetch_assoc()['token'];
                $notification = [
                    'title' => 'Pesanan '.$service,
                    'body' => 'Terimakasih telah melakukan transaksi, pesanan akan segera kami proses.',
                    'click_action' =>  'Open_URI',
                ];
                
                $data = [
                    'picture' => '',
                    'uri' =>  base_url('order/rincian?code='.$WebID),
                ];
                $FCM->sendNotif($fcm_token, $notification, $data);
                
                if($trx_st == 'success') {
                    
                    $WATL->sendMessage($phone, "Hallo, *{$data_user['name']}*\nID Pesanan *#{$WebID}* \nPesanan : *{$service}* \nStatus : *Success* \nCatatan: *{$trx_note}* \n----------------------------------------------\n*Terimakasih sudah memilih {$_CONFIG['title']}*");
                    $notification = [
                        'title' => 'Pesanan '.$service,
                        'body' => 'Status '.ucwords($status).' | Keterangan '.$trx_note,
                        'click_action' =>  'Open_URI',
                    ];
                    
                    $data = [
                        'picture' => '',
                        'uri' =>  base_url('order/rincian?code='.$WebID),
                    ];
                    $FCM->sendNotif($fcm_token, $notification, $data);
                    
                    $reff = $data_user['uplink'];
                    $cust = $sess_username;
                    $cashback = conf('member', 1);
                    $coinpra = conf('trxpra', 4);
                    $coinbas = conf('trxpra', 5);
                    $notes = "ID Trx #{$WebID}";
                    
                    if($call->query("SELECT * FROM users WHERE username = '$cust' AND level IN ('Premium', 'Admin')")->num_rows == 1) {
                    $call->query("UPDATE users SET coin = coin+$cashbackpra WHERE username = '$cust'");
                    $call->query("INSERT INTO mutation VALUES ('', '$cust', '+', '$cashbackpra', '$notes', '$date', '$time', 'Cashback Coin')");
                    $call->query("UPDATE trx SET profit = profit-$coinpra-$cashback, scoin = '1', rcoin = '$cashbackpra' WHERE tid = '$TrxID'");
                    
                    } else if ($call->query("SELECT * FROM users WHERE username = '$cust' AND level IN ('Basic')")->num_rows == 1) {
                    $call->query("UPDATE users SET coin = coin+$cashbackbas WHERE username = '$cust'");
                    $call->query("INSERT INTO mutation VALUES ('', '$cust', '+', '$cashbackbas', '$notes', '$date', '$time', 'Cashback Coin')");
                    $call->query("UPDATE trx SET profit = profit-$coinbas-$cashback, scoin = '1', rcoin = '$cashbackbas' WHERE tid = '$TrxID'");
                    }
                    
                    if($call->query("SELECT * FROM users WHERE username = '$reff' AND level IN ('Premium', 'Admin','Basic')")->num_rows == 1) {
                        $call->query("UPDATE users SET coin = coin+$cashback WHERE username = '$reff'");
                        $call->query("INSERT INTO mutation VALUES ('', '$reff', '+', '$cashback', '$notes', '$date', '$time', 'Coin Downline')");
                    }
                    
                }
                $_SESSION['success'] = ['type' => true, 'price' => $price, 'trxid' => $WebID];
            } else {
                file_put_contents(_DIR_('order/.report','none'), "[$date $time] [$server] [WEB] $trx_error\n", FILE_APPEND);
                $WATL->sendMessage(conf('Whatsapp-Admin', 8), "Pesanan *{$service}* gagal diproses disebabkan *{$trx_error}*");
                if(stristr(strtolower($trx_error),'saldo') || stristr(strtolower($trx_error),'balance')) {
                    $_SESSION['result'] = ['type' => false,'message' => 'Pemesanan anda tidak dapat diproses, silahkan hubungi Admin.'];
                } else {
                    $_SESSION['result'] = ['type' => false,'message' => $trx_error];
                }
                $call->query("DELETE FROM trx WHERE wid = '$WebID' AND tid = '$TrxID'");
            }
        } else {
            $_SESSION['result'] = ['type' => false,'message' => 'An error has occurred in the database system, please contact the admin.'];
        }
    }
}