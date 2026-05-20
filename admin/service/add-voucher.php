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
        <label class="col-md-12 control-label">Layanan</label>
        <div class="col-md-12">
            <select name="idLayanan" class="form-control">
                <option value="0">- Select One -</option>
                <?php
                $search = $call->query("SELECT code, name FROM srv WHERE brand = 'GARENA' ORDER BY name ASC");
                while($row = $search->fetch_assoc()) {
                    print '<option value="'.$row['code'].'">'.$row['name'].'</option>';
                }
                ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-12 control-label">Kode</label>
        <div class="col-md-12">
            <input type="text" name="code" class="form-control">
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-12 control-label">Status</label>
        <div class="col-md-12">
            <select name="status" class="form-control">
                <option value="Tersedia">Tersedia</option>
                <option value="Tidak Tersedia">Tidak Tersedia</option>
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