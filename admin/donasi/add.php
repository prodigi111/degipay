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
        <label class="col-md-12 control-label">Type</label>
        <div class="col-md-12">
            <select name="type" class="form-control">
                <option value="">- Select One -</option>
                <?php
                $search = $call->query("SELECT * FROM category_donasi GROUP BY type ORDER BY type ASC");
                while($row = $search->fetch_assoc()) {
                    print '<option value="'.$row['type'].'">'.ucwords(str_replace('-', ' ', $row['type'])).'</option>';
                }
                ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-12 control-label">Code</label>
        <div class="col-md-12">
            <input type="text" name="code" class="form-control">
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-12 control-label">Service</label>
        <div class="col-md-12">
            <input type="text" name="name" class="form-control">
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-12 control-label">Note</label>
        <div class="col-md-12">
            <textarea name="note" class="form-control"></textarea>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-12 control-label">Note2</label>
        <div class="col-md-12">
            <textarea name="note2" class="form-control"></textarea>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-12 control-label">Status</label>
        <div class="col-md-12">
            <select name="status" class="form-control">
                <option value="empty">Empty</option>
                <option value="available">Available</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-12 control-label">Kategori</label>
        <div class="col-md-12">
            <select name="kategori" class="form-control">
                <?php
                $search = $call->query("SELECT * FROM category_donasi ORDER BY id ASC");
                while($row = $search->fetch_assoc()) {
                    print '<option value="'.$row['name'].'">'.ucwords($row['name']).'</option>';
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
                while($r = $s->fetch_assoc()) { print '<option value="'.$r['code'].'">'.$r['name'].'</option>'; }
                ?>
            </select>
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