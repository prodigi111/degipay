<?php
require '../../connect.php';
require _DIR_('library/session/session');

$get_code = isset($_GET['q']) ? filter(base64_decode($_GET['q'])) : '';
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    if(!$_SESSION['user']) exit('No direct script access allowed!');
    if($data_user['level'] !== 'Admin') exit('No direct script access allowed!');
    if(!$get_code) exit('No direct script access allowed!');
    if($call->query("SELECT id FROM contact WHERE id = '$get_code'")->num_rows == false) exit('Contact not found.');
    $row = $call->query("SELECT * FROM contact WHERE id = '$get_code'")->fetch_assoc();
    ?>
<form method="POST">
    <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
    <input type="hidden" id="web_token" name="web_token" value="<?= base64_encode($row['id']) ?>">
    <div class="form-group">
        <label>Name</label>
        <input type="text" class="form-control" name="name" value="<?= $row['name'] ?>">
    </div>
    <? if($row['level'] == 'ceo & founder') { ?>
    <input type="hidden" name="level" value="ceo & founder">
    <? } else { ?>
    <div class="form-group">
        <label>Level</label>
        <select class="form-control" name="level">
            <?= select_opt($row['level'],'developer','Developer') ?>
            <?= select_opt($row['level'],'admin','Admin') ?>
            <?= select_opt($row['level'],'staff','Staff') ?>
        </select>
    </div>
    <? } ?>
    <div class="form-group">
        <label>URL Fotor</label>
        <input type="text" class="form-control" name="url_foto" value="<?= $row['url_foto'] ?>">
    </div>
    <div class="form-group">
        <label>Facebook</label>
        <input type="text" class="form-control" name="facebook" value="<?= $row['facebook'] ?>">
    </div>
    <div class="form-group">
        <label>Whatsapp Number</label>
        <input type="number" class="form-control" name="phone" value="<?= $row['whatsapp'] ?>">
    </div>
    <div class="form-group">
        <label>LINE</label>
        <input type="text" class="form-control" name="line" value="<?= $row['line'] ?>">
    </div>
    <div class="form-group">
        <label>Instagram</label>
        <input type="text" class="form-control" name="instagram" value="<?= $row['instagram'] ?>">
    </div>
    <div class="form-group">
        <label>Email address</label>
        <input type="email" class="form-control" name="email" value="<?= $row['email'] ?>">
    </div>
    <div class="form-group">
        <button type="submit" name="edit" class="btn btn-primary btn-block">Edit</button>
    </div>
</form>
    <?
} else {
    exit('No direct script access allowed!');
}