<?php
require '../connect.php';

$json = file_get_contents("php://input");
$callbackSignature = isset($_SERVER['HTTP_X_CALLBACK_SIGNATURE']) ? $_SERVER['HTTP_X_CALLBACK_SIGNATURE'] : '';
$signature = hash_hmac('sha256', $json, conf('tripay-cfg', 2));
if($callbackSignature !== $signature) exit('Invalid Signature');

$data = json_decode($json);
$event = $_SERVER['HTTP_X_CALLBACK_EVENT'];
file_put_contents('tripay-result', $json);
if($event == 'payment_status') {
    if($data->status == 'PAID') {
        $merchantRef = $call->real_escape_string($data->merchant_ref);
        
        $search = $call->query("SELECT * FROM deposit WHERE rid = '$merchantRef' AND status = 'unpaid'");
        if($search->num_rows == 1) {
            $rows = $search->fetch_assoc();
            $psld = $rows['amount'];
            $data_user = $call->query("SELECT * FROM users WHERE username = '".$rows['user']."'")->fetch_assoc();
            $call->query("UPDATE deposit SET status = 'paid' WHERE rid = '$merchantRef'");
            $call->query("UPDATE users SET balance = balance+$psld WHERE username = '".$rows['user']."'");
            $call->query("INSERT INTO mutation VALUES (null,'".$rows['user']."','+','$psld','Topup #$merchantRef','$date', '$time', 'Deposit')");
            
            $WATL->sendMessage($data_user['phone'], 'Hallo '.$data_user['name'].' Permintaan Isi Saldo Berhasil Diterima Dengan Menggunakan Metode Deposit '.strtoupper($rows['method']).', Saldo Anda Telah Kami Tambahkan Sebesar '.currency($psld).'.');
            $fcm_token = $call->query("SELECT * FROM users_token WHERE user = '".$rows['user']."'")->fetch_assoc()['token'];
            $notification = [
                'title' => 'Saldo Masuk Rp '.currency($psld),
                'text' => 'Permintaan Isi Saldo Berhasil Diterima, Saldo Anda Telah Kami Tambahkan.',
                'click_action' =>  'Open_URI',
            ];
            
            $data = [
                'picture' => '',
                'uri' =>  base_url('deposit/invoice/'.$merchantRef),
            ];
            $FCM->sendNotif($fcm_token, $notification, $data);
            
            die(json_encode(['success' => true]));
        } else {
            die('Invoice not found!');
        }
    }
}

die("No action was taken");