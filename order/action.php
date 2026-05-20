<?php
if(isset($_POST['buyprepaid'])) {
    $postPin = filter($_POST['pin']);

    $MustHaveZone = ['mobile legend', 'ragnarok m: eternal love', 'lifeafter credits', 'tom and jerry : chase', 'knights of valour', 'scroll of onmyoji'];
    
    $pip = client_ip();
    $pcode = filter(base64_decode($_POST['web_token']));
    if($call->query("SELECT * FROM srv WHERE code = '$pcode' AND status = 'available'")->num_rows == true) {
        $data_service = $call->query("SELECT * FROM srv WHERE code = '$pcode' AND status = 'available'")->fetch_assoc();
        $kategori = $data_service['brand'];
        $service = $data_service['name'];
        
        if($kategori == 'GARENA' && $call->query("SELECT * FROM kodeVoucher WHERE kategori = 'GARENA' AND idLayanan = '$pcode' AND status = 'Tersedia'")->num_rows == 1) :
            $server = 'X';
        else:
            $server = $data_service['provider'];
        endif;
        
        $target = filter($_POST['data']);
        $targez = isset($_POST['data2']) ? filter($_POST['data2']) : '';
        if(strtolower($kategori) == 'lifeafter credits') :
            $server = [
                '500001' => 'MiskaTown',
                '500002' => 'SandCastle',
                '500003' => 'MouthSwamp',
                '500004' => 'RedwoodTown',
                '500005' => 'Obelisk',
                '510001' => 'FallForest',
                '510002' => 'MountSnow',
                '520001' => 'NancyCity',
                '520002' => 'CharlesTown',
                '520003' => 'SnowHighlands',
                '520004' => 'Santopany',
                '520005' => 'LevinCity'
            ];
            $targez = array_search($target, $server);
         else:
            $targez = $targez;
        endif;

        if($server == 'X') :
            $target = (in_array(strtolower($kategori), $MustHaveZone)) ? $target.' ('.$targez.')' : $target;
            else:
                $target = in_array(strtolower($kategori), ['mobile legend', 'ragnarok m: eternal love']) ? $target.$targez : (in_array(strtolower($kategori), ['lifeafter credits', 'tom and jerry : chase', 'knights of valour', 'scroll of onmyoji']) ? $targetz.','.$target : $target);
                endif;
        
        if($data_user['level'] == 'Basic') {
            $rate = price($data_user['level'],$data_service['price'],$server);
            $price = conf('trxadmin', 3) + $rate;
        } else {
            $rate = price($data_user['level'],$data_service['price'],$server);
            $price = conf('trxadmin', 4) + $rate;
        }

        $profit = price($data_user['level'],$data_service['price'],$server,'profit');
        
        $order_tot = $call->query("SELECT * FROM trx WHERE data LIKE '%$target%' AND date_cr LIKE '$date%' AND code = '$pcode'")->num_rows;
        $order_target = ($order_tot > 0) ? ($order_tot + 1).'.'.$target : $target;
    }
    
    $DigiData = $DIGI->CheckBalance();
    if($DigiData['result'] == true) $call->query("UPDATE provider SET balance = '".$DigiData['data']['balance']."', sync = '$date $time' WHERE code = 'DIGI'");
    $prov = $call->query("SELECT * FROM provider WHERE code = '$server'")->fetch_assoc();
    $json = [];
    if($result_csrf == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'System error, please try again later.'];
    } else if(!$postPin) {
        $_SESSION['result'] = ['type' => false,'message' => 'Masukkan Pin Keamanan Telebih Dahulu!.'];
    } else if($call->query("SELECT * FROM users_blacklist WHERE username = '$sess_username'")->num_rows == 1) {
        $_SESSION['result'] = ['type' => false,'message' => 'Akun Telah Diblacklist!.'];
    } else if($_CONFIG['mt']['web'] == 'true') {
        $_SESSION['result'] = ['type' => false,'message' => 'Aplikasi Sedang Dalam Perbaikan.'];
    } else if($sess_username == 'demo') {
        $_SESSION['result'] = ['type' => false,'message' => 'Akun Demo Tidak Memiliki Izin Untuk Mengakses Fitur Ini.'];
    } else if($data_user['status'] == 'locked') {
        $_SESSION['result'] = ['type' => false,'message' =>'Transaksi di Bekukan Silahkan Hubungi Admin.'];
    } else if($call->query("SELECT * FROM srv WHERE code = '$pcode' AND status = 'available'")->num_rows == 0) {
        $_SESSION['result'] = ['type' => false,'message' => 'Layanan Tidak Ditemukan.'];
    } else if(in_array(strtolower($kategori), $MustHaveZone) && !$targez) {
        $_SESSION['result'] = ['type' => false,'message' => 'Form Zone ID masih kosong.'];
    } else if(!$pcode || !$target) {
        $_SESSION['result'] = ['type' => false,'message' => 'Masih Ada Formulir Kosong.'];
    } else if($call->query("SELECT * FROM trx WHERE data = '$target' AND code = '$pcode' AND status IN ('processing')")->num_rows == 1) {
        $_SESSION['result'] = ['type' => false,'message' => 'Ada Pesanan Dengan Data Yang Sama Dan Sedang Diproses.'];
    } else if($call->query("SELECT * FROM provider WHERE code = '$server'")->num_rows == 0) {
        $_SESSION['result'] = ['type' => false,'message' => 'Our server is in trouble, please try again later.'];
    } else if($data_user['balance'] < $price) {
        $_SESSION['result'] = ['type' => false,'message' => 'Saldo Anda Tidak Mencukupi Untuk Melakukan Pemesanan Ini.'];
    } else if($server !== 'X' && $prov['balance'] < $data_service['price']) {
        $_SESSION['result'] = ['type' => false,'message' => 'Tidak Dapat Melakukan Transaksi, Silahkan Coba Beberapa Saat Lagi.'];
    } else if((strtotime("$date $time") - strtotime($call->query("SELECT * FROM trx WHERE user = '$sess_username' ORDER BY id DESC LIMIT 1")->fetch_assoc()['date_cr'])) < 10) {
        $_SESSION['result'] = ['type' => false,'message' => 'Transaksi Terbatas, Ulangi Dalam 10 Detik.'];
    } else {
        $WebID = random_number(8);
        $TrxID = random(10);
        $phone = $data_user['phone'];
    if(check_bcrypt($postPin, $data_user['pin']) == true) {
        if($call->query("INSERT INTO trx VALUES ('', '$WebID', '$TrxID', '$sess_username', '$pcode', '$service', '$target', 'Transaksi Sedang Diproses', '$price', '$profit', 'processing', '0', '0', '0', 'WEB,$pip', 'prepaid', '$date $time', '$date $time', '$server')") == true) {
            $cut_user =  $call->query("UPDATE users SET balance = balance-$price WHERE username = '$sess_username'");
            
                if($server == 'DIGI') {
                    if($cut_user == TRUE) {
                        $json = $DIGI->Topup($pcode,$order_target,$TrxID);
                    }
                } else if($server == 'X') {
                    if($cut_user == TRUE) {
                        if($kategori == 'GARENA' && $server == 'X') {
                            $pesannya = "Order *MANUAL KODE GENERATE DATABASE*\nNomor HP : $phone ({$data_user['name']})\nID Trx : $WebID\nLayanan : $service [$kategori]\nHarga : ".currency($price)."\nTanggal : ".format_date('id', $datetime)."\n\nSaldo Awal : ".currency($data_user['balance'])."\nSaldo Sekarang : ".currency($data_user['balance']-$price)."";
                        } else {
                            $pesannya = "Order *MANUAL*\nNomor HP : $phone ({$data_user['name']})\nID Trx : $WebID\nLayanan : $service [$kategori]\nHarga : ".currency($price)."\nTarget Pengisian : $target\nTanggal : ".format_date('id', $datetime)."\n\nSaldo Awal : ".currency($data_user['balance'])."\nSaldo Sekarang : ".currency($data_user['balance']-$price)."";
                        }
                        $try = $WATL->sendMessage(conf('WhatsApp',4), $pesannya);
                        if(isset($try['result'])) {
                            if($try['result'] == 1) {
                                if($kategori == 'GARENA' && $server == 'X') {
                                    $mes = $call->query("SELECT * FROM kodeVoucher WHERE kategori = 'GARENA' AND idLayanan = '$pcode' AND status = 'Tersedia' LIMIT 1")->fetch_assoc()['kode'];
                                    $json = ['result' => true,'data' => ['trxid' => random(10),'status' => 'success','balance' => 0], 'message' => $mes];
                                } else {
                                    $json = ['result' => true,'data' => ['trxid' => random(10),'status' => 'processing','balance' => 0], 'message' => ''];
                                }
                            }
                        }
                    }
                } else { 
                    $json = ['result' => false,'message' => 'Server error.'];
                }
           
            ###############################
            $trx_result = false;
            if(isset($json['result'])) {
                if($json['result'] == true) {
                    $trx_id = $json['data']['trxid'];
                    $trx_st = $json['data']['status'];
                    $trx_note = $json['message'];
                    $trx_last = $json['data']['balance'];
                    $trx_result = true;
                } else {
                    $trx_result = false;
                    $trx_error = isset($json['message']) ? $json['message'] : 'Pemesanan Anda Tidak Dapat Diproses, Silahkan Coba Beberapa Saat Lagi.';
                }
            } else {
                $trx_result = false;
                $trx_error = 'Connection Failed!';
            }
            ###############################
            
            if($trx_result == true) {
                
                if($kategori == 'GARENA' && $server == 'X') {
                    $call->query("UPDATE kodeVoucher SET status = 'Tidak Tersedia', used = '$datetime' WHERE kode = '$trx_note'");
                }
                $call->query("INSERT INTO mutation VALUES ('', '$sess_username', '-', '$price', 'Order #$WebID | $target', '$date', '$time', 'Transaksi')");
                $call->query("INSERT INTO logs VALUES ('', '$sess_username', 'order', '$pip', '$date $time')");
                $call->query("UPDATE trx SET note = '$trx_note', status = '$trx_st' WHERE tid = '$TrxID'");
                $call->query("UPDATE provider SET balance = '$trx_last' WHERE code = '$server'");
                $WATL->sendMessage($phone, "Hallo, *{$data_user['name']}*\nID Pesanan *#{$WebID}* \nPesanan : *{$service}* \nStatus : *Pending* \nCatatan: *Transaksi Pending* \n----------------------------------------------\n*Terima kasih sudah memilih {$_CONFIG['title']}*");
            
                $fcm_token = $call->query("SELECT * FROM users_token WHERE user = '$sess_username'")->fetch_assoc()['token'];
                $notification = [
                    'title' => 'Pesanan '.$service,
                    'body' => 'Terima Kasih Telah Melakukan Transaksi, Pesanan Akan Segera Kami Proses.',
                    'click_action' =>  'Open_URI',
                ];
                
                $data = [
                    'picture' => '',
                    'uri' =>  base_url('order/detail/'.$WebID),
                ];
                $FCM->sendNotif($fcm_token, $notification, $data);
                
        

                       {     
                    $notification = [
                        'title' => 'Pesanan '.$service,
                        'body' => 'Status '.ucwords($status).' | Keterangan '.$trx_note,
                        'click_action' =>  'Open_URI',
                    ];
                    
                    $data = [
                        'picture' => '',
                        'uri' =>  base_url('order/detail/'.$WebID),
                    ];
                    $FCM->sendNotif($fcm_token, $notification, $data);
                
                
                    $reff = $data_user['uplink'];
                    $cust = $sess_username;
                    $point = conf('referral', 3);
                    $komisi = conf('referral', 1);
                    $notes = "ID Trx #{$WebID}";
                    
                    $call->query("UPDATE users SET point = point+$point WHERE username = '$cust'");
                    $call->query("INSERT INTO mutation VALUES ('', '$cust', '+', '$point', '$notes', '$date', '$time', 'Point Transaksi')");
                    $call->query("UPDATE trx SET profit = profit-$point, spoint = '1', rpoint = '$point' WHERE tid = '$TrxID'");
                    
                    if($call->query("SELECT * FROM users WHERE username = '$reff' AND level IN ('Premium', 'Admin')")->num_rows == 1) {
                        $call->query("UPDATE users SET komisi = komisi+$komisi WHERE username = '$reff'");
                        $call->query("INSERT INTO mutation VALUES ('', '$reff', '+', '$komisi', '$notes', '$date', '$time', 'Komisi Transaksi')");
                    } 
                
                    
                }
                
                $_SESSION['success'] = ['type' => true, 'price' => $price, 'trxid' => $WebID];
            } else {
                $call->query("INSERT INTO mutation VALUES ('', '$sess_username', '+', '$price', 'Order #$WebID | Refunds', '$date', '$time', 'Transaksi')");
                $call->query("UPDATE users SET balance = balance+$price WHERE username = '$sess_username'");
                
                file_put_contents(_DIR_('order/.report','none'), "[$date $time] [$server] [WEB] $trx_error\n", FILE_APPEND);
                $WATL->sendMessage(conf('WhatsApp',4), "Pesanan *{$service}* Gagal Diproses Disebabkan *{$trx_error}*");
                if(stristr(strtolower($trx_error),'saldo') || stristr(strtolower($trx_error),'balance')) {
                    $_SESSION['result'] = ['type' => false,'message' => 'Pemesanan Anda Tidak Dapat Diproses, Silahkan Hubungi Admin.'];
                } else {
                    $_SESSION['result'] = ['type' => false,'message' => $trx_error];
                }
                $call->query("DELETE FROM trx WHERE wid = '$WebID' AND tid = '$TrxID'");
            }
        } else {
            $_SESSION['result'] = ['type' => false,'message' => 'An error has occurred in the database system, please contact the admin.'];
        }
        } else {
            $_SESSION['result'] = ['type' => false,'message' => 'Pin Keamanan Tidak Valid.'];
        }
}
} else if(isset($_POST['buypostpaid'])) {
    $postPin = filter($_POST['pin']);
    $pip = client_ip();
    $pcode = filter(base64_decode($_POST['web_token1']));
    $pdata = filter(base64_decode($_POST['web_token2']));
    $WebID = random_number(8);
    $TrxID = random(10);
    
    if($call->query("SELECT * FROM srv WHERE code = '$pcode' AND type = 'pascabayar' AND status = 'available'")->num_rows == true) {
        $data_service = $call->query("SELECT * FROM srv WHERE code = '$pcode' AND status = 'available'")->fetch_assoc();
        $service = $data_service['name'];
        $server = $data_service['provider'];
        
        if($data_service['provider'] == 'DIGI') $try = $DIGI->CheckBill($pcode,$pdata,$TrxID);
        else $try = ['result' => false,'message' => 'Invalid Data.'];
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
    } else if(!$postPin) {
        $_SESSION['result'] = ['type' => false,'message' => 'Masukkan Pin Keamanan Telebih Dahulu!.'];
    } else if($call->query("SELECT * FROM users_blacklist WHERE username = '$sess_username'")->num_rows == 1) {
        $_SESSION['result'] = ['type' => false,'message' => 'Akun Telah Diblacklist!.'];
    } else if($_CONFIG['mt']['web'] == 'true') {
        $_SESSION['result'] = ['type' => false,'message' => 'Aplikasi Sedang Dalam Perbaikan.'];
    } else if($sess_username == 'demo') {
        $_SESSION['result'] = ['type' => false,'message' => 'Akun Demo Tidak Memiliki Izin Untuk Mengakses Fitur Ini.'];
    } else if($data_user['status'] == 'locked') {
        $_SESSION['result'] = ['type' => false,'message' =>'Transaksi di Bekukan Silahkan Hubungi Admin.'];
    } else if($call->query("SELECT * FROM srv WHERE code = '$pcode' AND type = 'pascabayar' AND status = 'available'")->num_rows == 0) {
        $_SESSION['result'] = ['type' => false,'message' => 'Layanan Tidak Ditemukan.'];
    } else if(!$pcode || !$pdata) {
        $_SESSION['result'] = ['type' => false,'message' => 'Masih Ada Formulir Kosong.'];
    } else if($call->query("SELECT * FROM trx WHERE data = '$target' AND code = '$pcode' AND status = 'processing'")->num_rows == 1) {
        $_SESSION['result'] = ['type' => false,'message' => 'Ada Pesanan Dengan Data Yang Sama Dan Sedang Diproses.'];
    } else if($call->query("SELECT * FROM provider WHERE code = '$server'")->num_rows == 0) {
        $_SESSION['result'] = ['type' => false,'message' => 'Our server is in trouble, please try again later.'];
    } else if($try['result'] == false) {
        $_SESSION['result'] = ['type' => false,'message' => $errMSG];
    } else if($data_user['balance'] < $price) {
        $_SESSION['result'] = ['type' => false,'message' => 'Saldo Anda Tidak Mencukupi Untuk Melakukan Pemesanan Ini.'];
    } else if($prov['balance'] < $price-$profit) {
        $_SESSION['result'] = ['type' => false,'message' => 'Tidak Dapat Melakukan Transaksi, Silahkan Coba Beberapa Saat Lagi.'];
    } else {
        
    if(check_bcrypt($postPin, $data_user['pin']) == true) {
        if($call->query("INSERT INTO trx VALUES ('','$WebID','$TrxID','$sess_username','$pcode','$service','$target','','$price','$profit','processing','0','0','0','WEB,$pip','postpaid','$date $time','$date $time','$server')") == true) {
            $cut_user =   $call->query("UPDATE users SET balance = balance-$price WHERE username = '$sess_username'");
            if($server == 'DIGI')  {
                if($cut_user == TRUE) {
                    $json = $DIGI->PayBill($pcode,$order_target,$TrxID);
                }
            } else { 
                $json = ['result' => false,'message' => 'Server error.'];
                
            }
            
            // proses order
            ###############################
            if($json['result'] == true) {
                $trx_id = $json['data']['trxid'];
                $trx_st = $json['data']['status'];
                $trx_note = $json['data']['customer_name'].', '.$json['data']['customer_no'].'.';
                $trx_last = $json['data']['balance'];
            } else {
                $trx_error = $json['message'];
            }
            ###############################
            
            if($json['result'] == true) {
              
                $call->query("INSERT INTO mutation VALUES ('', '$sess_username', '-', '$price', 'Order #$WebID | $target', '$date', '$time', 'Transaksi')");
                $call->query("INSERT INTO logs VALUES ('', '$sess_username', 'order', '$pip', '$date $time')");
                $call->query("UPDATE trx SET note = '$trx_note', status = '$trx_st' WHERE tid = '$TrxID'");
                $call->query("UPDATE provider SET balance = '$trx_last' WHERE code = '$server'");
                $phone = $data_user['phone'];
                $WATL->sendMessage($phone, "Hallo, *{$data_user['name']}*\nID Pesanan *#{$WebID}* \nPesanan : *{$service}* \nStatus : *Pending* \nCatatan: *Transaksi Pending* \n----------------------------------------------\n*Terima kasih sudah memilih {$_CONFIG['title']}*");
                
                $fcm_token = $call->query("SELECT * FROM users_token WHERE user = '$sess_username'")->fetch_assoc()['token'];
                $notification = [
                    'title' => 'Pesanan '.$service,
                    'body' => 'Terima Kasih Telah Melakukan Transaksi, Pesanan Akan Segera Kami Proses.',
                    'click_action' =>  'Open_URI',
                ];
                
                $data = [
                    'picture' => '',
                    'uri' =>  base_url('order/detail/'.$WebID),
                ];
                $FCM->sendNotif($fcm_token, $notification, $data);
                
            
                   {
                    $notification = [
                        'title' => 'Pesanan '.$service,
                        'body' => 'Status '.ucwords($status).' | Keterangan '.$trx_note,
                        'click_action' =>  'Open_URI',
                    ];
                    
                    $data = [
                        'picture' => '',
                        'uri' =>  base_url('order/detail/'.$WebID),
                    ];
                    $FCM->sendNotif($fcm_token, $notification, $data);
                
                
                    $reff = $data_user['uplink'];
                    $cust = $sess_username;
                    $point = conf('referral', 3);
                    $komisi = conf('referral', 1);
                    $notes = "ID Trx #{$WebID}";
                    
                    $call->query("UPDATE users SET point = point+$point WHERE username = '$cust'");
                    $call->query("INSERT INTO mutation VALUES ('', '$cust', '+', '$point', '$notes', '$date', '$time', 'Point Transaksi')");
                    $call->query("UPDATE trx SET profit = profit-$point, spoint = '1', rpoint = '$point' WHERE tid = '$TrxID'");
                    
                    if($call->query("SELECT * FROM users WHERE username = '$reff' AND level IN ('Premium', 'Admin')")->num_rows == 1) {
                        $call->query("UPDATE users SET komisi = komisi+$komisi WHERE username = '$reff'");
                        $call->query("INSERT INTO mutation VALUES ('', '$reff', '+', '$komisi', '$notes', '$date', '$time', 'Komisi Transaksi')");
                    }
            
                    
                }
                $_SESSION['success'] = ['type' => true, 'price' => $price, 'trxid' => $WebID];
            } else {
                file_put_contents(_DIR_('order/.report','none'), "[$date $time] [$server] [WEB] $trx_error\n", FILE_APPEND);
                $WATL->sendMessage(conf('WhatsApp',4), "Pesanan *{$service}* Gagal Diproses Disebabkan *{$trx_error}*");
                if(stristr(strtolower($trx_error),'saldo') || stristr(strtolower($trx_error),'balance')) {
                    $_SESSION['result'] = ['type' => false,'message' => 'Pemesanan Anda Tidak Dapat Diproses, Silahkan Hubungi Admin.'];
                } else {
                    $_SESSION['result'] = ['type' => false,'message' => $trx_error];
                }
                $call->query("DELETE FROM trx WHERE wid = '$WebID' AND tid = '$TrxID'");
            }
        } else {
            $_SESSION['result'] = ['type' => false,'message' => 'An error has occurred in the database system, please contact the admin.'];
        }
        } else {
            $_SESSION['result'] = ['type' => false,'message' => 'Pin Keamanan Tidak Valid.'];
        }
    }
} else if(isset($_POST['buymanual'])) {
    $postPin = filter($_POST['pin']);
    
    $pip = client_ip();
    $pcode = filter(base64_decode($_POST['web_token']));
    if($call->query("SELECT * FROM srv WHERE code = '$pcode' AND status = 'available'")->num_rows == true) {
        $data_service = $call->query("SELECT * FROM srv WHERE code = '$pcode' AND status = 'available'")->fetch_assoc();
        $kategori = $data_service['brand'];
        $service = $data_service['name'];
        $server = $data_service['provider'];
        
        $target = filter($_POST['data']);
        
        $price = price($data_user['level'],$data_service['price'],$server);
        $profit = price($data_user['level'],$data_service['price'],$server,'profit');
    }
    if($result_csrf == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'System error, please try again later.'];
    } else if(!$postPin) {
        $_SESSION['result'] = ['type' => false,'message' => 'Masukkan Pin Keamanan Telebih Dahulu!.'];
    } else if($_CONFIG['mt']['web'] == 'true') {
        $_SESSION['result'] = ['type' => false,'message' => 'Aplikasi Sedang Dalam Perbaikan.'];
    } else if($sess_username == 'demo') {
        $_SESSION['result'] = ['type' => false,'message' => 'Akun Demo Tidak Memiliki Izin Untuk Mengakses Fitur Ini.'];
    } else if($data_user['status'] == 'locked') {
        $_SESSION['result'] = ['type' => false,'message' =>'Transaksi di Bekukan Silahkan Hubungi Admin.'];
    } else if($call->query("SELECT * FROM srv WHERE code = '$pcode' AND status = 'available'")->num_rows == 0) {
        $_SESSION['result'] = ['type' => false,'message' => 'Layanan Tidak Ditemukan.'];
    } else if(!$pcode || !$target) {
        $_SESSION['result'] = ['type' => false,'message' => 'Masih Ada Formulir Kosong.'];
    } else if($call->query("SELECT * FROM trx WHERE data = '$target' AND code = '$pcode' AND status = 'processing'")->num_rows == 1) {
        $_SESSION['result'] = ['type' => false,'message' => 'Ada Pesanan Dengan Data Yang Sama Dan Sedang Diproses.'];
    } else if($call->query("SELECT * FROM provider WHERE code = '$server'")->num_rows == 0) {
        $_SESSION['result'] = ['type' => false,'message' => 'Our server is in trouble, please try again later.'];
    } else if($data_user['balance'] < $price) {
        $_SESSION['result'] = ['type' => false,'message' => 'Saldo Anda Tidak Mencukupi Untuk Melakukan Pemesanan Ini.'];
    } else if((strtotime("$date $time") - strtotime($call->query("SELECT * FROM trx WHERE user = '$sess_username' ORDER BY id DESC LIMIT 1")->fetch_assoc()['date_cr'])) < 30) {
        $_SESSION['result'] = ['type' => false,'message' => 'Transaksi Terbatas, Ulangi Dalam 30 Detik.'];
    } else {
        $WebID = random_number(8);
        $TrxID = random(10);
        $phone = $data_user['phone'];
    if(check_bcrypt($postPin, $data_user['pin']) == true) {
    
        $WATL->sendMessage($data_user['phone'], "Hallo, *{$data_user['name']}*\nID Pesanan *#{$WebID}* \nPesanan : *{$service}* \nStatus : *Proses* \nCatatan: *{Transaksi Sedang Diproses}* \n----------------------------------------------\n*Terima kasih sudah memilih {$_CONFIG['title']}*");
        
        $WATL->sendMessage(conf('WhatsApp',4), "Pesanan *{$service}* Membutuhkan Pengiriman Ke *{$post_data}*");
        if($call->query("INSERT INTO trx VALUES ('','$WebID','$TrxID','$sess_username','$pcode','$service','$target','Transaksi Sedang Diproses','$price','$profit','processing','0','0','0','WEB,$pip','manual','$date $time','$date $time','$server')") == true) {
            $cut_user =  $call->query("UPDATE users SET balance = balance-$price WHERE username = '$sess_username'");
            $call->query("INSERT INTO mutation VALUES ('', '$sess_username', '-', '$price', 'Order #$WebID | $post_data', '$date', '$time', 'Transaksi')");
            $call->query("INSERT INTO logs VALUES ('', '$sess_username', 'order', '$pip', '$date $time')");
        
        $_SESSION['success'] = ['type' => true, 'price' => $price, 'trxid' => $WebID];            
        } else {
            $_SESSION['result'] = ['type' => false,'message' => 'An error has occurred in the database system, please contact the admin.'];
        }
        } else {
            $_SESSION['result'] = ['type' => false,'message' => 'Pin Keamanan Tidak Valid.'];
        }
    }
}