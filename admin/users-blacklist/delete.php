<?php
require '../../connect.php';
require _DIR_('library/session/session');

$get_code = isset($_GET['q']) ? filter(base64_decode($_GET['q'])) : '';
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    if(!$_SESSION['user']) exit('No direct script access allowed!');
    if($data_user['level'] !== 'Admin') exit('No direct script access allowed!');
    if(!$get_code) exit('No direct script access allowed!');
    if($call->query("SELECT username FROM users_blacklist WHERE username = '$get_code'")->num_rows == false) exit('User not found.');
    $row = $call->query("SELECT * FROM users_blacklist WHERE username = '$get_code'")->fetch_assoc();
    $row_users = $call->query("SELECT * FROM users WHERE username = '".$row['username']."'")->fetch_assoc();
    ?>
<form method="POST">
    <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
    <input type="hidden" id="web_token" name="web_token" value="<?= base64_encode($row_users['username']) ?>">
    <div class="form-group">
        <label>Nama Lengkap</label>
        <input type="text" class="form-control" name="name" value="<?= $row_users['name'] ?>">
    </div>
    <div class="form-group">
        <label>Nomor HP</label>
        <input type="number" class="form-control" name="phone" value="<?= $row_users['phone'] ?>">
    </div>
    <div class="form-group">
        <label>Saldo</label>
        <input type="number" class="form-control" name="balance" value="<?= $row_users['balance'] ?>">
    </div>
    <div class="form-group">
        <label>Komisi</label>
        <input type="number" class="form-control" name="komisi" value="<?= $row_users['komisi'] ?>">
    </div>
    <div class="form-group">
        <label>Poin</label>
        <input type="number" class="form-control" name="point" value="<?= $row_users['point'] ?>">
    </div>
    <div class="form-group">
        <label>Level</label>
        <input type="text" class="form-control" name="level" value="<?= $row_users['level'] ?>">
    </div>
    <div class="form-group">
        <label>Status</label>
        <input type="text" class="form-control" name="status" value="<?= $row_users['status'] ?>">
    </div>
    <div class="form-group">
        <button type="submit" name="delete" class="btn btn-primary btn-block">Delete</button>
    </div>
</form>
    <?
} else {
    exit('No direct script access allowed!');
}