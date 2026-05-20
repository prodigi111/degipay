<?php
header('Content-Type: application/json');
require '../connect.php';
require _DIR_('library/session/session');

$trxmove = $call->query("SELECT * FROM conf WHERE code = 'account-ovo'")->fetch_assoc();
$ovo = new OVO($trxmove['c1'],$trxmove['c2']);
$json = $ovo->seeMutation($trxmove['c5']);
$get = $ovo->cekProfile($trxmove['c5']);
if($json['result'] == true) {
    for($i = 0; $i <= count($json['data'])-1; $i++) {
        $data = $json['data'][$i];
        $invoice = $data['merchant_invoice'];
        $amount = $data['transaction_amount'];
        $desc = $data['desc1'];
        $sender = $data['desc3'];
        $datetime = $data['transaction_date'].' '.$data['transaction_time'];
        $akunnya = $data['name'].' | '.$data['card_no'];
        $u_status = $data['status'];
        
        if ($u_status == "SUCCESS") {
            $status = "read";
        } else {
            $status = "unread";
        }
        $call->query("UPDATE conf SET c6 = '".$get['data']['001']['card_balance']."' WHERE c8 = 'OVO' AND code = 'account-ovo'");
        //if($data['desc2'] == 'Top Up') {
            if($status == "read") {
                $cari = $call->query("SELECT * FROM deposit_bank WHERE invoice = '$invoice' AND date = '$datetime' AND amount = '$amount' AND account = '$akunnya' AND bank = 'OVO'")->num_rows;
                if($cari == 0) {
                    $call->query("INSERT INTO deposit_bank VALUES ('','','','$invoice','OVO','$amount','$desc','$sender','$datetime','$akunnya','unread')");
                }
            }
        }
    }
//}

if(isset($data_user['level'])) {
    if($data_user['level'] == 'Admin') {
        print json_encode($json, JSON_PRETTY_PRINT);
    } else {
        print json_encode(['result' => $json['result'],'message' => $json['data']], JSON_PRETTY_PRINT);
    }
} else {
    print json_encode(['result' => $json['result'],'message' => $json['data']], JSON_PRETTY_PRINT);
}