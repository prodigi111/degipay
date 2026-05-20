<?php
require '../../connect.php';
require _DIR_('library/session/session');

$get_code = isset($_GET['q']) ? filter(base64_decode($_GET['q'])) : '';
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    if(!$_SESSION['user']) exit('No direct script access allowed!');
    if($data_user['level'] !== 'Admin') exit('No direct script access allowed!');
    if(!$get_code) exit('No direct script access allowed!');
    if($call->query("SELECT id FROM users WHERE id = '$get_code'")->num_rows == false) exit('User not found.');
    $row = $call->query("SELECT * FROM users WHERE id = '$get_code'")->fetch_assoc();
    $row_api = $call->query("SELECT * FROM users_api WHERE user = '".$row['username']."'")->fetch_assoc();
    ?>
<form method="POST">
    <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
    <input type="hidden" id="web_token" name="web_token" value="<?= base64_encode($row['id']) ?>">
    <div class="form-group">
        <label>Nama Lengkap</label>
        <input type="text" class="form-control" name="name" value="<?= $row['name'] ?>">
    </div>
    <div class="form-group">
        <label>Nomor HP</label>
        <input type="number" class="form-control" name="phone" value="<?= $row['phone'] ?>">
    </div>
    <div class="form-group">
        <label>Saldo</label>
        <input type="number" class="form-control" name="balance" value="<?= $row['balance'] ?>">
    </div>
    <div class="form-group">
        <label>Komisi</label>
        <input type="number" class="form-control" name="komisi" value="<?= $row['komisi'] ?>">
    </div>
    <div class="form-group">
        <label>Poin</label>
        <input type="number" class="form-control" name="point" value="<?= $row['point'] ?>">
    </div>
    <div class="form-group">
        <label>Level</label>
        <select class="form-control" name="level">
            <?= select_opt($row['level'],'Basic','Basic') ?>
            <?= select_opt($row['level'],'Premium','Premium') ?>
            <?= select_opt($row['level'],'Admin','Admin') ?>
        </select>
    </div>
    <div class="form-group">
        <label>Status</label>
        <select class="form-control" name="status">
            <?= select_opt($row['status'],'suspend','Suspend') ?>
            <?= select_opt($row['status'],'active','Active') ?>
            <?= select_opt($row['status'],'locked','Locked') ?>
        </select>
    </div>
    <div class="form-group">
        <button type="submit" name="edit" class="btn btn-primary btn-block">Edit</button>
    </div>
</form>
    <?
} else {
    exit('No direct script access allowed!');
}