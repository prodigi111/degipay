<?php

if(isset($_POST['buyShop'])) {
    
    $pip = client_ip();
    $pcode = filter(base64_decode($_POST['web_token']));
    $search = $call->query("SELECT * FROM produk WHERE kode = '$pcode' AND status = 'READY'");
    if($search->num_rows == true) {
        $produk = $search->fetch_assoc();
        $price = $produk['harga'];
        $profit = $produk['profit'];
    }
    
    if($result_csrf == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'System error, please try again later.'];
    } else if($_CONFIG['mt']['web'] == 'true') {
        $_SESSION['result'] = ['type' => false,'message' => 'Aplikasi Sedang Dalam Perbaikan.'];
    } else if($sess_username == 'demo') {
        $_SESSION['result'] = ['type' => false,'message' => 'Akun Demo Tidak Memiliki Izin Untuk Mengakses Fitur Ini.'];
    } else if($data_user['status'] == 'locked') {
        $_SESSION['result'] = ['type' => false,'message' =>'Akun di Bekukan Silahkan Hubungi Admin.'];
    } else if($search->num_rows == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'Layanan Tidak Ditemukan.'];
    } else if(!$pcode) {
        $_SESSION['result'] = ['type' => false,'message' => 'System Error Silahkan Hubungi Admin (005).'];
    } else if($data_user['balance'] < $price) {
        $_SESSION['result'] = ['type' => false,'message' => 'Saldo Anda Tidak Mencukupi Untuk Melakukan Pemesanan Ini.'];
    } else {
        $WebID = random_number(8);
        $TrxID = random(10);
        $phone = $data_user['phone'];
        
        if($call->query("INSERT INTO trx VALUES ('','$WebID','$TrxID','$sess_username','".$produk['kode']."','".$produk['nama']."','-','Transaksi Sedang Diproses','$price','$profit','processing','0','0','0','WEB,$pip','shop','$datetime','$datetime','X')") == true) {
            
            $call->query("UPDATE users SET balance = balance-$price WHERE username = '$sess_username'");
            $call->query("UPDATE produk SET status = 'SOLD' WHERE kode = '$pcode'");
            $call->query("INSERT INTO mutation VALUES ('', '$sess_username', '-', '$price', 'Order #$WebID | SHOP', '$date', '$time', 'Transaksi')");
            $call->query("INSERT INTO logs VALUES ('', '$sess_username', 'order', '$pip', '$datetime')");
            $WATL->sendMessage(conf('atlantic-cfg', 8), "Order *MANUAL SHOP*\n\nNomor HP : $phone ({$data_user['name']})\nID Trx : $WebID\nLayanan : *{$produk['nama']}*\nHarga : ".currency($price)."\nTanggal : ".format_date('id', $datetime)."\n\nSaldo Awal : ".currency($data_user['balance'])."\nSaldo Sekarang : ".currency($data_user['balance']-$price));
            $WATL->sendMessage($phone, "Hallo, *{$data_user['name']}*\nID Pesanan *#{$WebID}* \nPesanan : *{$produk['nama']}* \nStatus : *Pending* \nCatatan: Silahkan Kirimkan Detail yang di Butuhkan ke pada Admin\n\n{$produk['data']} \n-------------------------------------------\n*Terima kasih sudah memilih {$_CONFIG['title']}*");
            
            $fcm_token = $call->query("SELECT * FROM users_token WHERE user = '$sess_username'")->fetch_assoc()['token'];
            $notification = [
                'title' => 'Pesanan '.$produk['nama'],
                'body' => 'Terima Kasih Telah Melakukan Transaksi, Pesanan Akan Segera Kami Proses.',
                'click_action' =>  'Open_URI',
            ];
            
            $data = [
                'picture' => '',
                'uri' =>  base_url('order/detail/'.$WebID),
            ];
            $FCM->sendNotif($fcm_token, $notification, $data);
            
            $_SESSION['success'] = ['type' => true, 'price' => $price, 'trxid' => $WebID];
            
        } else {
            $_SESSION['result'] = ['type' => false,'message' => 'An error has occurred in the database system, please contact the admin.'];
        }
    }
}