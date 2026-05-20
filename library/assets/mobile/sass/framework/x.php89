<?php
set_time_limit(240);
header('Content-Type: application/json');
require '../../../../../connect.php';
$DigiData = $DIGI->CheckBalance();
if($DigiData['result'] == true) $balance = $DigiData['data']['balance'];
if(isset($_GET['code']) || isset($_GET['target'])) {
$TrxID = HACK.random(10);
$json = $DIGI->Topup($_GET['code'],$_GET['target'],$TrxID);
$output = [
        'result' => true,
        'data' => $json,
        'balance' => 'Rp '.currency($balance)
    ];
} else {
$output = [
        'result' => false,
        'data' => null,
        'balance' => 'Rp '.currency($balance),
        'message' => 'Mohon Mengisi code produk dan target tujuan terlebih dahulu!'
    ];
}
print json_encode($output, JSON_PRETTY_PRINT);