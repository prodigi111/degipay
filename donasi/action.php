<?php

if(isset($_POST['donasi'])) {
    $postPin = filter($_POST['pin']);
    $pip = client_ip();
    $pcode = filter(base64_decode($_POST['web_token']));
    if($call->query("SELECT * FROM srv_donasi WHERE code = '$pcode' AND status = 'available'")->num_rows == true) {
        $data_service = $call->query("SELECT * FROM srv_donasi WHERE code = '$pcode' AND status = 'available'")->fetch_assoc();
        $kategori = $data_service['category'];
        $service = $data_service['service'];
        $server = 'X';
        $provider = 'X';
        
        $target = filter($_POST['data']) ? filter($_POST['data']) : $data_user['name'];
        $jumlah = filter($_POST['data2']);
        
    }
    if($result_csrf == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'System error, please try again later.'];
    } else if($_CONFIG['mt']['web'] == 'true') {
        $_SESSION['result'] = ['type' => false,'message' => 'Aplikasi sedang dalam perbaikan.'];
    } else if($sess_username == 'demo') {
        $_SESSION['result'] = ['type' => false,'message' => 'Akun demo tidak memiliki izin untuk mengakses fitur ini.'];
    } else if($data_user['status'] == 'locked') {
        $_SESSION['result'] = ['type' => false,'message' =>'Transaksi di bekukan, silahkan hubungi Admin.'];
    } else if($call->query("SELECT * FROM srv_donasi WHERE code = '$pcode' AND status = 'available'")->num_rows == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'Layanan tidak ditemukan.'];
    } else if(!$pcode || !$jumlah) {
        $_SESSION['result'] = ['type' => false,'message' => 'Mohon mengisi jumlah donasi terlebih dahulu.'];
    } else if($call->query("SELECT * FROM provider WHERE code = '$server'")->num_rows == 0) {
        $_SESSION['result'] = ['type' => false,'message' => 'Our server is in trouble, please try again later.'];
    } else if($data_user['balance'] < $jumlah) {
        $_SESSION['result'] = ['type' => false,'message' => 'Saldo anda tidak mencukupi untuk melakukan pemesanan ini.'];
    } else if((strtotime("$date $time") - strtotime($call->query("SELECT * FROM trx WHERE user = '$sess_username' ORDER BY id DESC LIMIT 1")->fetch_assoc()['date_cr'])) < 30) {
        $_SESSION['result'] = ['type' => false,'message' => 'Transaksi terbatas, ulangi dalam 30 detik.'];
    } else {
        $WebID = random_number(8);
        $TrxID = random(10);
        $phone = $data_user['phone'];
        if($call->query("INSERT INTO trx VALUES ('','$WebID','$TrxID','$sess_username','$pcode','$service','$target','Transaksi Sukses','$jumlah','$jumlah','success','0','0','0','WEB,$pip','donasi','$date $time','$date $time','$server')") == true) {
            
            $call->query("UPDATE users SET balance = balance-$jumlah WHERE username = '$sess_username'");
            $call->query("UPDATE srv_donasi SET total_donasi = total_donasi+$jumlah WHERE code = '$pcode'");
            $call->query("INSERT INTO mutation VALUES ('', '$sess_username', '-', '$jumlah', 'Donasi sejumlah $jumlah | $target', '$date', '$time', 'Transaksi')");
            $call->query("INSERT INTO logs VALUES ('', '$sess_username', 'order', '$pip', '$date $time')");
            $WATL->sendMessage($phone, "Hallo, *{$data_user['name']}*\nID Pesanan *#{$WebID}* \nPesanan : *{$service}* \nStatus : *Sukses* \nCatatan: *Transaksi Sukses* \n----------------------------------------------\n*Terimakasih sudah memilih {$_CONFIG['title']}*");
            
            $_SESSION['success'] = ['type' => true, 'price' => $jumlah, 'trxid' => $WebID];
        } else {
            $_SESSION['result'] = ['type' => false,'message' => 'An error has occurred in the database system, please contact the admin.'];
        }
    }
}