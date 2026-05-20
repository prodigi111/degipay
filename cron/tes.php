<?php
set_time_limit(240);
header('Content-Type: application/json');
require '../../../connect.php';
$querys = mysqli_query($call, "SELECT * FROM srv ORDER BY id ASC");
while($row = mysqli_fetch_array($querys)){
    $array = "-";
	$datas[] = array('code' => $row['code'], 'service' => $row['name'], 'category' => $row['brand'], 'price' => $row['price'], 'status' => $row['status']);
}
$array = array("result" => $datas);
print json_encode($array, JSON_PRETTY_PRINT);