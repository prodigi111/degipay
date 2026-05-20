<?php
set_time_limit(240);
header('Content-Type: application/json');
require '../connect.php';
require 'formatter.php';

$search = $call->query("SELECT * FROM trx WHERE status = 'error' AND refund = '0'");
if($search->num_rows == 0) {
    $output = [0 => ['result' => false,'data' => 'Failed order not found']];
} else {
    while($row = $search->fetch_assoc()) {
        $wid = $row['wid'];
        $price = $row['price'];
        $user = $row['user'];
        $rpoint = $row['rpoint'];
        $spoint = $row['spoint'];
        $reff = $call->query("SELECT * FROM users WHERE username = '$user'")->fetch_assoc()['uplink'];

        $up = $call->query("UPDATE users SET balance = balance+$price WHERE username = '$user'");
        $up = $call->query("INSERT INTO mutation VALUES ('','$user','+','$price','Order #$wid | Refunds', '$date', '$time', 'Transaksi')");
        $up = $call->query("UPDATE trx SET refund = '1' WHERE wid = '$wid'");
        if($up == TRUE) {
            $output[] = ['result' => true,'data' => 'Refunded Rp '.currency($price).' to '.$user.' (TID: #'.$wid.')'];
            $notes = "ID Trx #{$wid} | ERROR SYSTEM";
            if($spoint == '1' && $call->query("SELECT * FROM users WHERE username = '$reff' AND level IN ('Premium', 'Admin')")->num_rows == 1) {
                $call->query("UPDATE users SET komisi = komisi-$rpoint WHERE username = '$reff'");
                $call->query("INSERT INTO mutation VALUES ('', '$reff', '-', '$rpoint', '$notes', '$date', '$time', 'Komisi Transaksi Kami Tarik')");
                $call->query("UPDATE trx SET spoint = '1', rpoint = '0' WHERE wid = '$wid'");
            }
        } else {
            $output = [0 => ['result' => false,'data' => 'System Error']];
        }
    }
}
print json_encode($output, JSON_PRETTY_PRINT);