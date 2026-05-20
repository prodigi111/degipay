<?php 
require '../../RGShenn.php';
require _DIR_('library/session/session');

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    if(!isset($_SESSION['user'])) exit('<div class="alert alert-danger text-left fade show" role="alert">No direct script access allowed!</div>');
    if(!isset($_POST['rek'])) exit('<div class="alert alert-danger text-left fade show" role="alert"> Terjadi Kesalahan Pada No Rek</div>'); 
   /* if(!isset($_POST['bank']) || !in_array($_POST['bank'],['014','bni','mandiri','bri','cimb','muamalat','permata'])) exit('<div class="alert alert-danger text-left fade show" role="alert"> Terjadi Kesalahan Pada Script</div>');*/

if(!empty($_POST["rek"])) { 
    $bank = 014;
    $rek = $_POST['accountnumber'];
    
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,"https://api-rekening.lfourr.com/getBankAccount?bankCode=$bank&accountNumber=$rek");
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
    
    $result = curl_exec($ch);
    curl_close($ch);
    $res = json_decode($result, true);
    // Mengecek apakah data ditemukan
    if($res["status"] === true) {
        $data = $res["data"];
    }

    $bank = $data["bankname"];
    $number = $data["accountname"];
    $name = $data["accountname"];; 
    
   if($res["status"] === false) {
    echo "<div class='alert alert-danger text-center fade show mr-2 ml-2 mt-2' role='alert'>Nomor Kartu Tidak Ditemukan</div>";
   } else if($res["status"] === true){
    echo "<span class='btn btn-primary rounded shadowed btn-block mt-1'><b>".$name."<b></span>";
   }
   }
   } else {
	exit('<div class="alert alert-danger text-left fade show" role="alert">No direct script access allowed!</div>');
   }