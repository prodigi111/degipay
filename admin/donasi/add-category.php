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
        <label class="col-md-12 control-label">Name</label>
        <div class="col-md-12">
            <input type="text" name="name" class="form-control">
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-12 control-label">Type</label>
        <div class="col-md-12">
            <select name="type" class="form-control">
                <option value="">- Select One -</option>
                <option value="donasi">Donasi</option>
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