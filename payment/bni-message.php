<?php
header('Content-Type: application/json');
require '../connect.php';
require _DIR_('library/session/session');

$trxmove = $call->query("SELECT * FROM conf WHERE code = 'account-bank' AND c3 = 'bni'")->fetch_assoc();
$BNI = new BNI();
$BNI->login($trxmove['c1'],$trxmove['c2']);
$balance = $BNI->get_balance($trxmove['c5']);
$account = $BNI->get_nama($trxmove['c5']);
$json = $BNI->get_transactions($trxmove['c5'],date('Y-m-d', strtotime("-3 days", strtotime($date))),$date);
$BNI->logout();
if($json['result'] == true && count($json['data']) > 0) {
    for($i = 0; $i <= count($json['data'])-1; $i++) {
        $data = $json['data'][$i];
        $invoice = 'BNI/TRF-'.md5($data['keterangan'].'&'.$data['kredit']);
        $amount = $data['kredit'];
        $desc = $data['keterangan'];
        $sender = '?';
        $datetime = $data['tanggal']." $time";
        $akunnya = $account.' | '.$trxmove['c5'];
        
    	$call->query("UPDATE conf SET c6 = '$balance' WHERE c3 = 'bni' AND code = 'account-bank'");
    	if($data['type'] == 'Cr') {
            $cari = $call->query("SELECT * FROM deposit_bank WHERE invoice = '$invoice' AND amount = '$amount' AND account = '$akunnya' AND bank = 'BNI'")->num_rows;
            if($cari == 0) {
                $call->query("INSERT INTO deposit_bank VALUES ('','','','$invoice','BNI','$amount','$desc','$sender','$datetime','$akunnya','unread')");
            }
        }
    }
}

if(isset($data_user['level'])) {
    if($data_user['level'] == 'Admin') {
        print json_encode($json, JSON_PRETTY_PRINT);
    } else {
        print json_encode(['result' => $json['result'],'data' => $json['data'],'message' => $json['message']], JSON_PRETTY_PRINT);
    }
} else {
    print json_encode(['result' => $json['result'],'data' => $json['data'],'message' => $json['message']], JSON_PRETTY_PRINT);
}