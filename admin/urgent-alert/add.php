<?php
require '../../connect.php';
require _DIR_('library/session/session');

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    if(!$_SESSION['user']) exit('No direct script access allowed!');
    if($data_user['level'] !== 'Admin') exit('No direct script access allowed!');
    ?>
<form method="POST" role="form" enctype="multipart/form-data">
    <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
    <div class="form-group">
        <label>Isi</label>
        <input type="text" class="form-control" name="info">
    </div>
    <div class="form-group">
        <label>Tampilkan</label>
        <select name="is_show" class="form-control">
            <option value="1">Ya</option>
            <option value="0">Tidak</option>
        </select>
    </div>
     <div class="form-group">
        <label>Urutan</label>
        <input type="number" class="form-control" name="order_id">
    </div>
    <div class="form-group">
        <button type="submit" name="publish" class="btn btn-primary btn-block">Add</button>
    </div>
</form>
    <?
} else {
    exit('No direct script access allowed!');
}