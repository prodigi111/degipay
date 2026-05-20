<?php
set_time_limit(240);
header('Content-Type: application/json');
require '../connect.php';
require 'formatter.php';

$showpw = isset($_SESSION['user']['level']) ? $_SESSION['user']['level'] : 'invalid';
$stdate = date('Y-m-d', strtotime('-3 Months', strtotime($date)));
$search = $call->query("SELECT * FROM trx WHERE status IN ('','processing') AND provider != 'X' AND DATE(date_cr) BETWEEN '$stdate' AND '$date' ORDER BY rand() LIMIT 20");
if($search->num_rows == 0) {
    exit(json_encode(['result' => false,'message' => 'Order Pending and Processing not found','Total' => 0,'data' => []], JSON_PRETTY_PRINT));
} else {
    $AID = 0;
    while($row = $search->fetch_assoc()) {
        $tid = $row['tid'];
        $WebID = $row['wid'];
        $code = $row['code'];
        $cust = $row['user'];
        $target = $row['data'];
        $server = $row['provider'];
        $service = $row['name'];
        $trx_note = $row['note'];
        $price = $row['price'];
        $profit = $row['profit'];
        $place = explode(',',$row['trxfrom']);
        $user = $call->query("SELECT * FROM users WHERE username = '$cust'")->fetch_assoc();
        $namelu = $user['name'];
        $reff = $user['uplink'];
        $prov = $call->query("SELECT * FROM provider WHERE code = '$server'")->fetch_assoc();
        $call->query("UPDATE provider SET sync = '$date $time' WHERE code = '$server'");
        
        if($server == 'DIGI') {
            $try = $DIGI->CheckTopup($code,$target,$tid);
            $data = [
                'success' => isset($try['result']) ? $try['result'] : false,
                'status' => $try['result'] == true ? $try['data']['status'] : 'processing',
                'note' => $try['result'] == true ? $try['message'] : '',
                'errors' => !isset($try['result']) ? 'Connection Failed!' : $try['message'],
            ];
        } else {
            $data = [
                'success' => false,
                'status' => 'error',
                'note' => '',
                'errors' => 'Provider not supported / still in the making stage.',
            ];
        }
        
        if($data['success'] == true) {
            $status = $BFormat->check($data['status']);
            $note = $data['note'];
            if($status == 'error' && $note == '' || !$note) {
                $note = 'Transaksi Gagal';
                // $call->query("UPDATE users SET balance = balance+$price WHERE username = '$cust'");
            } else {
                $note = $note;
            }
            
            if($call->query("UPDATE trx SET status = '$status', note = '$note', date_up = '$date $time' WHERE tid = '$tid' AND provider = '$server'") == true) {
                $out[$AID] = ['id' => $row['id'],'tid' => $tid,'date' => $row['date_cr'],'user' => $cust,'note' => $note,'status' => $status];
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
                'uri' =>  base_url('order/rincian?code='.$WebID),
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
            } else {
                $out[$AID] = ['id' => $row['id'],'tid' => $tid,'date' => $row['date_cr'],'user' => $cust,'error' => 'Update Failed!'];
            }
        } else {
            $out[$AID] = ['id' => $row['id'],'tid' => $tid,'date' => $row['date_cr'],'user' => $cust,'error' => $data['errors']];
        }
        if($showpw == 'Admin') $out[$AID]['provider'] = $prov['name'];
        $AID++;
    }
}

print json_encode($out, JSON_PRETTY_PRINT);