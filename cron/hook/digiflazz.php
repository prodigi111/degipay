<?php
set_time_limit(240);
require '../../connect.php';
require _DIR_('cron/formatter');

$get = file_get_contents('php://input');
$header = getallheaders();
$FromIP = client_ip();

function DFStatus($x) {
    if($x == 'Transaksi Pending') $str = 'processing';
    if($x == 'Transaksi Gagal') $str = 'error';
    if($x == 'Transaksi Sukses') $str = 'success';
    return (!$str) ? 'processing' : $str;
}
if(isset($header['x-digiflazz-event']) && isset($header['x-digiflazz-delivery']) && isset($header['x-hub-signature']) && in_array($header['User-Agent'],['Digiflazz-Hookshot','DigiFlazz-Pasca-Hookshot'])) {
    $array = json_decode($get, true)['data'];
    $json = json_encode($array);
    
    $status = DFStatus($array['message']);
    $trxid = $array['trx_id']; // ID Transaksi DigiFlazz
    $refid = $array['ref_id']; // ID Transaksi dari Panel
    $note = $array['sn'];
    $last = $array['buyer_last_saldo'];
    if($status == 'error' && $note == '' || !$note) {
        $note = 'Transaksi Gagal';
    } else {
        $note = $note;
    }
    
    $format = $refid.' -> '.$array['message'].'<br>'.$note;
    print $format;
    
    $search = $call->query("SELECT * FROM trx WHERE tid = '$refid' AND provider = 'DIGI'");
    if($search->num_rows == true) {
        $row = $search->fetch_assoc();
        $cust = $row['user'];
        $WebID = $row['wid'];
        $service = $row['name'];
        $price = $row['price'];
        $profit = $row['profit'];
        $user = $call->query("SELECT * FROM users WHERE username = '$cust'")->fetch_assoc();
        $reff = $user['uplink'];
        $place = explode(',',$row['trxfrom']);
        $point = point($price,$profit,$row['provider']);
        
        $call->query("UPDATE trx SET status = '$status', note = '$note', date_up = '$date $time' WHERE tid = '$refid' AND provider = 'DIGI'");
        
        if(in_array($status, ['success', 'error'])) {
            $WATL->sendMessage($user['phone'], "Hallo, *{$user['name']}*\nID Pesanan *#{$WebID}* \nPesanan : *{$service}* \nStatus : *".ucwords($status)."* \nCatatan: *{$note}* \n----------------------------------------------\n*Terima kasih sudah memilih {$_CONFIG['title']}*");
            $fcm_token = $call->query("SELECT * FROM users_token WHERE user = '$cust'")->fetch_assoc()['token'];
            
            $notification = [
                'title' => 'Pesanan '.$service,
                'body' => 'Status '.ucwords($status).' | Keterangan '.$note,
                'click_action' =>  'Open_URI',
            ];
            
            $data = [
                'picture' => '',
                'uri' =>  base_url('order/rincian?=code'.$WebID),
            ];
            $FCM->sendNotif($fcm_token, $notification, $data);
            
        }
        
        if($status == 'success' && $row['spoint'] == '0') {
                    
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
    }
} else {
    print 'Access Denied!';
}