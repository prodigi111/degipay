<?php 
require '../../RGShenn.php';
require _DIR_('library/session/session');

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    if(!isset($_SESSION['user'])) exit('<div class="alert alert-danger text-left fade show" role="alert">No direct script access allowed!</div>');
    if(!isset($_POST['data'])) exit('<div class="alert alert-danger text-left fade show" role="alerta">No direct script access allowed!</div>');

if(!empty($_POST["data"])) {
    $pln = $_POST['data'];
                    
    $data = json_encode(array(
        'commands' => 'pln-subscribe',
        'customer_no' => $pln,
        ));
    $header = array(
        'Content-Type: application/json',
        );
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://api.digiflazz.com/v1/transaction');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $result = curl_exec($ch);
                    
    $data = json_decode($result);
    $data = $data->data;
    $name = $data->name;
    $customer_no = $data->customer_no;
    $subscriber_id = $data->subscriber_id;
    $meter_no = $data->meter_no;
    $daya = $data->segment_power;
    
  if($name !== "" && $customer_no <> $subscriber_id) {
    echo "  <div class='card'>
                <div class='card-body p-2'>
                    <h5>Nama Pelanggan</h5>
                    <h3><b>$name</b></h3>
                    <h5>Nomor Meteran : <b>$subscriber_id</b></h5>
                    <h5>ID Pelanggan : <b>$customer_no</b></h5>
                    <h5 class='m-0'>Daya : <b>$daya VA</b></h5>
                </div>
            </div>";
  } else if ($name !== "" && $customer_no === $subscriber_id){
    echo "  <div class='card'>
                <div class='card-body p-2'>
                    <h5>Nama Pelanggan</h5>
                    <h3><b>$name</b></h3>
                    <h5>Nomor Meteran : <b>$meter_no</b></h5>
                    <h5>ID Pelanggan : <b>$customer_no</b></h5>
                    <h5 class='m-0'>Daya : <b>$daya VA</b></h5>
                </div>
            </div>";
  } else if ($name == ""){
    echo "<div class='alert alert-danger text-center fade show mr-2 ml-2 mt-2' role='alert'>Nomor Meter Tidak Ditemukan</div>";
  }
  } else {
    echo "<span></span>";
  }
} else {
	exit('<div class="alert alert-danger text-left fade show" role="alert">No direct script access allowed!</div>');
}