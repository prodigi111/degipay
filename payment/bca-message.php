<?php
header('Content-Type: application/json');
require '../connect.php';
require _DIR_('library/session/session');
$account = $call->query("SELECT * FROM conf WHERE c3 = 'bca'")->fetch_assoc();
$json = $BCA->mutasiTrx();
if($json['result'] == true && count($json['data']) > 0) {
    for($i = 0; $i <= count($json['data'])-1; $i++) {
        $data = $json['data'][$i];
        $invoice = 'BCA/TRF-'.md5($data['detail'].'&'.$data['amount']);
        $amount = $data['amount'];
        $desc = $data['detail'];
        if(preg_match('/SWITCHING CR TANGGAL :(\d+)\/(\d+) /',$desc)) $sender = preg_replace('/SWITCHING CR TANGGAL :(\d+)\/(\d+) TRANSFER DR (.*?) /','',$desc);
        if(preg_match('/SWITCHING CR TRANSFER DR (\d+) /',$desc)) $sender = preg_replace('/SWITCHING CR TRANSFER DR (\d+) /','',$desc);
        if(preg_match('/TRSF E-BANKING CR (\d+)\/(\d+) (.*?) /',$desc)) $sender = preg_replace('/TRSF E-BANKING CR (\d+)\/(\d+) (.*?) /','',$desc);
        if(preg_match('/TRSF E-BANKING CR (\d+)\/(.*?)\/(.*?) /',$desc)) $sender = preg_replace('/TRSF E-BANKING CR (\d+)\/(.*?)\/(.*?) (\d+).00/','',$desc);
        if(preg_match('/TRSF E-BANKING DB (\d+)\/(\d+) (.*?) /',$desc)) $sender = preg_replace('/TRSF E-BANKING DB (\d+)\/(\d+) (.*?) /','',$desc);
        if(preg_match('/TRSF E-BANKING DB (\d+)\/FTSCY\/(.*?) /',$desc)) $sender = preg_replace('/TRSF E-BANKING DB (\d+)\/FTSCY\/(.*?) (\d+).00/','',$desc);
        if(preg_match('/TRSF E-BANKING DB (\d+)\/FTFVA\/(.*?)\//',$desc)) $sender = preg_replace('/TRSF E-BANKING DB (\d+)\/FTFVA\/(.*?)\/(.*?) - - /','',$desc);
        $sender = SpaceGhost(str_replace(['DEPOSIT','SALDO','PANEL','PULSA','MEMBER','TOPUP','ISI'],'',strtoupper($sender)));
        $datetime = $date." $time";
        $akunnya = $account['c5'];
    	
        if($data['transaction_type'] == 'credit') {
            $cari = $call->query("SELECT * FROM deposit_bank WHERE invoice = '$invoice' AND amount = '$amount' AND account = '$akunnya' AND bank = 'BCA'")->num_rows;
            if($cari == 0) {
                $call->query("INSERT INTO deposit_bank VALUES ('','','','$invoice','BCA','$amount','$desc','$sender','$datetime','$akunnya','unread')");
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