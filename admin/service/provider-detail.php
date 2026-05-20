<?php
require '../../connect.php';
require _DIR_('library/session/session');

$get_code = isset($_GET['q']) ? filter(base64_decode($_GET['q'])) : '';
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    if(!$_SESSION['user']) exit('No direct script access allowed!');
    if($data_user['level'] !== 'Admin') exit('No direct script access allowed!');
    if(!$get_code) exit('No direct script access allowed!');
    if($call->query("SELECT code FROM provider WHERE code = '$get_code'")->num_rows == false) exit('Provider not found.');
    $row = $call->query("SELECT * FROM provider WHERE code = '$get_code'")->fetch_assoc();
    ?>
<form method="POST">
    <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
    <input type="hidden" id="web_token" name="web_token" value="<?= base64_encode($get_code) ?>">
    <div class="form-group">
        <label class="col-md-12 control-label">ID</label>
        <div class="col-md-12">
            <textarea name="uid" class="form-control"><?= $row['uid'] ?></textarea>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-12 control-label">Key</label>
        <div class="col-md-12">
            <textarea name="key" class="form-control"><?= $row['ukey'] ?></textarea>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-12 control-label">Key</label>
        <div class="col-md-12">
            <textarea name="info" class="form-control"><?= $row['info'] ?></textarea>
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