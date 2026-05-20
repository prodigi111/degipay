<?php
require '../../connect.php';
require _DIR_('library/session/session');

$get_code = isset($_GET['q']) ? filter(base64_decode($_GET['q'])) : '';
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    if(!$_SESSION['user']) exit('No direct script access allowed!');
    if($data_user['level'] !== 'Admin') exit('No direct script access allowed!');
    if(!$get_code) exit('No direct script access allowed!');
    if($call->query("SELECT id FROM srv_donasi WHERE id = '$get_code'")->num_rows == false) exit('Service not found.');
    $row = $call->query("SELECT * FROM srv_donasi WHERE id = '$get_code'")->fetch_assoc();
    ?>
<form method="POST">
    <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
    <input type="hidden" id="web_token" name="web_token" value="<?= base64_encode($get_code) ?>">
    <div class="form-group">
        <label class="col-md-12 control-label">Type</label>
        <div class="col-md-12">
            <select name="type" id="type" class="form-control">
                <?php
                $search = $call->query("SELECT * FROM category_donasi GROUP BY type ORDER BY type ASC");
                while($row_query = $search->fetch_assoc()) {
                    print select_opt($row['type'],$row_query['type'], ucwords(str_replace('-', ' ', $row_query['type'])));
                }
                ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-12 control-label">Code</label>
        <div class="col-md-12">
            <input type="text" name="code" class="form-control" value="<?= $row['code'] ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-12 control-label">Name</label>
        <div class="col-md-12">
            <input type="text" name="name" class="form-control" value="<?= $row['service'] ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-12 control-label">Note</label>
        <div class="col-md-12">
            <textarea name="note" class="form-control"><?= $row['note'] ?></textarea>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-12 control-label">Note2</label>
        <div class="col-md-12">
            <textarea name="note2" class="form-control"><?= $row['note2'] ?></textarea>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-12 control-label">Total Donasi</label>
        <div class="col-md-12">
            <input type="number" name="price" class="form-control" value="<?= $row['total_donasi'] ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-12 control-label">Status</label>
        <div class="col-md-12">
            <select name="status" class="form-control">
                <?= select_opt($row['status'],'empty','Empty') ?>
                <?= select_opt($row['status'],'available','Available') ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-12 control-label">Kategori</label>
        <div class="col-md-12">
            <select name="kategori" id="kategori" class="form-control">
                <?php
                $search = $call->query("SELECT * FROM category_donasi WHERE type = '".$row['type']."' GROUP BY name ORDER BY name ASC");
                while($rowBrand = $search->fetch_assoc()) {
                    print select_opt($row['kategori'],$rowBrand['name'], $rowBrand['name']);
                }
                ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-12 control-label">Provider</label>
        <div class="col-md-12">
            <select name="provider" class="form-control">
                <?php
                $s = $call->query("SELECT * FROM provider ORDER BY name ASC");
                while($r = $s->fetch_assoc()) { print select_opt($row['provider'],$r['code'],$r['name']); }
                ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-12">
            <button type="submit" name="edit" class="btn btn-primary btn-block">Edit</button>
        </div>
    </div>
</form>
    <?
} else {
    exit('No direct script access allowed!');
}