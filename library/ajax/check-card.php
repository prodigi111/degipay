<?php 
require '../../RGShenn.php';
require _DIR_('library/session/session');

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    if(!isset($_SESSION['user'])) exit('<div class="alert alert-danger text-left fade show" role="alert">No direct script access allowed!</div>');
    if(!isset($_POST['card'])) exit('<div class="alert alert-danger text-left fade show" role="alert">No direct script access allowed!</div>');

if(!empty($_POST["card"])) {
  $search = $call->query("SELECT * FROM users WHERE card='" . $_POST["card"] . "'");
  $data_user = $call->query("SELECT * FROM users WHERE card='" . $_POST["card"] . "'")->fetch_assoc();
  if($search->num_rows == false) {
    echo "<div class='alert alert-danger text-center fade show mr-2 ml-2 mt-2' role='alert'>Nomor Kartu Tidak Ditemukan</div>";
  } else if ($search->num_rows == true){
    echo "<span class='btn btn-primary rounded shadowed btn-block mt-1'><b>".$data_user['name']."<b></span>";
  }
}
} else {
	exit('<div class="alert alert-danger text-left fade show" role="alert">No direct script access allowed!</div>');
}