<?php
if(!isset($call)) die();
if(isset($explodeTagar[0]) && isset($explodeTagar[1]) && isset($explodeTagar[2])) {
    $post_status    = filter($explodeTagar[0]);
    $post_wid       = filter($explodeTagar[1]);
    $post_note      = filter($explodeTagar[2]);
    
    $search = $call->query("SELECT * FROM trx WHERE wid = '$post_wid' AND provider = 'X'");
    $row = $search->fetch_assoc();
    
    $server = $row['provider'];
    $price = $row['price'];
    $profit = $row['profit'];
    $point = point($price,$profit,$server);
    $cust = $row['user'];
    $reff = $call->query("SELECT * FROM users WHERE username = '$cust'")->fetch_assoc()['uplink'];
    
    if($search->num_rows == false) {
        $output[] = ['type' => 'message','data' => ['mode' => 'chat','pesan' => 'ID Transaksi *'.$post_wid.'* Tidak Ditemukan!!.']];
    } else if(!in_array($post_status,['S','F'])) {
        $output[] = ['type' => 'message','data' => ['mode' => 'chat','pesan' => 'Status Hanya Bisa Diisi S atau F']];
    } else if($call->query("SELECT * FROM trx WHERE wid = '$post_wid' AND status = 'processing' AND provider = 'X'")->num_rows == false) {
        $output[] = ['type' => 'message','data' => ['mode' => 'chat','pesan' => 'Status Transaksi Tersebut Tidak Dapat Di Ubah!']];
    } else {
        $post_status = $post_status == 'S' ? 'success' : 'error';
        $rowUser = $call->query("SELECT * FROM users WHERE username = '".$row['user']."'")->fetch_assoc();
        if($call->query("UPDATE trx SET status = '$post_status', note = '$post_note' WHERE wid = '$post_wid'") == true) {
            if($post_status == 'success' && $row['spoint'] == '0' && $call->query("SELECT * FROM users WHERE referral = '$reff'")->num_rows == 1) {
                $call->query("UPDATE users SET point = point+$point WHERE referral = '$reff'");
                $call->query("UPDATE trx SET profit = profit-$point, spoint = '1', rpoint = '$point' WHERE wid = '$post_wid'");
            }
            $WATL->sendMessage($rowUser['phone'], "Hai, *{$rowUser['name']}*\nID Pesanan *#{$post_wid}* \nPesanan : *{$row['name']}* \nStatus : *".ucfirst($post_status)."* \nCatatan: *{$post_note}* \n----------------------------------------------\n*Terima kasih sudah memilih {$_CONFIG['title']}*");
            $output[] = ['type' => 'message','data' => ['mode' => 'chat','pesan' => "*UPDATE SUCCESS*\nID Transaksi *{$post_wid}*\nStatus : *".ucfirst($post_status)."*\nCatatan: *{$post_note}*."]];
        } else {
            $output[] = ['type' => 'message','data' => ['mode' => 'chat','pesan' => 'Terjadi Kesalahan, Silahkan Hubungi https://wa.me/62895772972011']];
        }
    }
}