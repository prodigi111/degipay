<?php
header('Content-Type: application/json');
require '../connect.php';
require _DIR_('library/session/session');

$json = $AtlMutasi->gopay(12);
if($json['result'] == true) {
    for($i = 0; $i <= count($json['data'])-1; $i++) {
        $data = $json['data'][$i];
        $desc = $data['description'];
        $invoice = md5($desc.'&'.$data['transaction_date'].'&'.$data['transaction_time'].'&'.$data['transaction_amount']);
        $amount = $data['transaction_amount'];
        $sender = str_replace('+','',explode("\n",$desc)[1]);
        $datetime = $data['transaction_date'].' '.$data['transaction_time'];
        $akunnya = $data['account_name'].' | '.$data['account_number'];
        
        if($data['transaction_type'] == 'credit') {
            if(stristr(strtolower($desc),'go-pay transfer from')) {
                $cari = $call->query("SELECT * FROM deposit_bank WHERE invoice = '$invoice' AND date = '$datetime' AND amount = '$amount' AND account = '$akunnya' AND bank = 'GOPAY'")->num_rows;
                if($cari == 0) {
                    $call->query("INSERT INTO deposit_bank VALUES ('','','','$invoice','GOPAY','$amount','$desc','$sender','$datetime','$akunnya','unread')");
                }
            }
        }
    }
}

if(isset($data_user['level'])) {
    if($data_user['level'] == 'Admin') {
        print json_encode($json, JSON_PRETTY_PRINT);
    } else {
        print json_encode(['result' => $json['result'],'message' => $json['message']], JSON_PRETTY_PRINT);
    }
} else {
    print json_encode(['result' => $json['result'],'message' => $json['message']], JSON_PRETTY_PRINT);
}