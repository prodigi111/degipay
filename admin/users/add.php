<?php
require '../../connect.php';
require _DIR_('library/session/session');

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    if(!$_SESSION['user']) exit('No direct script access allowed!');
    if($data_user['level'] !== 'Admin') exit('No direct script access allowed!');
    ?>
<form method="POST">
    <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
    <div class="form-group">
        <label>Nama Lengkap</label>
        <input type="text" class="form-control" name="name">
    </div>
    <div class="form-group">
        <label>Email</label>
        <input type="email" class="form-control" name="email">
    </div>
    <div class="form-group">
        <label>Nomor HP</label>
        <input type="number" class="form-control" name="phone">
    </div>
    <div class="form-group">
        <label>Level</label>
        <select class="form-control" name="level">
            <option value="Basic">Basic</option>
            <option value="Premium">Premium</option>
            <option value="Admin">Admin</option>
        </select>
    </div>
    <div class="form-group">
        <button type="submit" name="add" class="btn btn-primary btn-block">Add</button>
    </div>
</form>
    <?
} else {
    exit('No direct script access allowed!');
}