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
        <label class="col-md-12 control-label">Kode</label>
        <div class="col-md-12">
            <input type="text" name="code" class="form-control" placeholder="Jika kosong, kode akan random">
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-12 control-label">Nominal Saldo</label>
        <div class="col-md-12">
            <input type="number" name="nominal" class="form-control" placeholder="">
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-12 control-label">Stock Voucher</label>
        <div class="col-md-12">
            <input type="number" name="stock" class="form-control" placeholder="">
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-12 control-label">Exp Voucher</label>
        <div class="col-md-12">
            <input type="number" name="exp" class="form-control" placeholder="Expired untuk voucher">
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-12">
            <button type="submit" name="add" class="btn btn-primary btn-block">Add</button>
        </div>
    </div>
</form>
    <?
} else {
    exit('No direct script access allowed!');
}