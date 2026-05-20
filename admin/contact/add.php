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
        <label>Name</label>
        <input type="text" class="form-control" name="name">
    </div>
    <div class="form-group">
        <label>Level</label>
        <select class="form-control" name="level">
            <option value="developer">Developer</option>
            <option value="admin">Admin</option>
            <option value="staff">Staff</option>
        </select>
    </div>
    <div class="form-group">
        <label>Facebook</label>
        <input type="text" class="form-control" name="facebook">
    </div>
    <div class="form-group">
        <label>URL Foto</label>
        <input type="text" class="form-control" name="url_foto">
    </div>
    <div class="form-group">
        <label>Whatsapp Number</label>
        <input type="number" class="form-control" name="phone">
    </div>
    <div class="form-group">
        <label>LINE</label>
        <input type="text" class="form-control" name="line">
    </div>
    <div class="form-group">
        <label>Instagram</label>
        <input type="text" class="form-control" name="instagram">
    </div>
    <div class="form-group">
        <label>Email address</label>
        <input type="email" class="form-control" name="email">
    </div>
    <div class="form-group">
        <button type="submit" name="add" class="btn btn-primary btn-block">Add</button>
    </div>
</form>
    <?
} else {
    exit('No direct script access allowed!');
}