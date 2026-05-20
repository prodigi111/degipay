<?php
require '../RGShenn.php';
$ip = client_ip();
$insert_user = $call->query("INSERT INTO logs VALUES ('', '".$_SESSION['user']['username']."', 'logout', '$ip', '$datetime')");
$Message = "Akun anda telah keluar di {$_CONFIG['title']} dengan\n\n*IP ==> {$ip}\nWaktu ==>$time\nTanggal ==>$date*\n\nJika bukan anda, silahkan amankan akun anda dipengaturan akun {$_CONFIG['title']}" ; 
$data = [
    'api_key' => 'WmUTvvaNVEChctor1rVRra3nAdLhuA',
    'sender' => '6282397700028',
    'number' => $_SESSION['user']['phone'],
    'message' => $Message
    ];
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://wa.mhpedia.my.id/app/api/send-message",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode($data))
    );

        $response = curl_exec($curl);
        curl_close($curl);
        
if ($insert_user == TRUE) {
    $call->query("DELETE FROM users_cookie WHERE cookie = '".$_COOKIE['token']."'");
    unset($_COOKIE['token']);
    unset($_COOKIE['ssid']);
    unset($_SESSION['user']);
    setcookie('ssid', null, -1, '/', $_SERVER['HTTP_HOST']);
    setcookie('token', null, -1, '/', $_SERVER['HTTP_HOST']);
    redirect(0,base_url('auth/login'));
}