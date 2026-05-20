<?php
require '../../connect.php';
require _DIR_('library/session/session');

$get_code = isset($_GET['q']) ? filter(base64_decode($_GET['q'])) : '';
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    if(!$_SESSION['user']) exit('No direct script access allowed!');
    if($data_user['level'] !== 'Admin') exit('No direct script access allowed!');
    if(!$get_code) exit('No direct script access allowed!');
    if($call->query("SELECT code FROM deposit_method WHERE code = '$get_code'")->num_rows == false) exit('Deposit Method not found.');
    $row = $call->query("SELECT * FROM deposit_method WHERE code = '$get_code'")->fetch_assoc();
    ?>
<form method="POST">
    <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
    <input type="hidden" id="web_token" name="web_token" value="<?= base64_encode($get_code) ?>">
    <div class="form-group">
        <label class="col-md-12 control-label">Name</label>
        <div class="col-md-12">
            <input type="text" name="name" class="form-control" value="<?= (!$row['data']) ? '' : explode(' A/n ',$row['data'])[1] ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-12 control-label">Number</label>
        <div class="col-md-12">
            <input type="text" name="number" class="form-control" value="<?= (!$row['data']) ? '' : explode(' A/n ',$row['data'])[0] ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-12 control-label">Minimal</label>
        <div class="col-md-12">
            <input type="number" name="minimal" class="form-control" value="<?= $row['min'] ?>">
        </div>
    </div> 
    <div class="form-group">
        <label class="col-md-12 control-label">Biaya Admin</label>
        <div class="col-md-12">
            <input type="number" name="fee" class="form-control" value="<?= $row['fee'] ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-12 control-label">Keterangan</label>
        <div class="col-md-12">
            <input type="text" name="keterangan" class="form-control" value="<?= $row['keterangan'] ?>">
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-12">
            <button type="submit" name="change" class="btn btn-primary btn-block">Change</button>
        </div>
    </div>
</form>
    <?
} else {
    exit('No direct script access allowed!');
}