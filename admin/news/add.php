<?php
require '../../connect.php';
require _DIR_('library/session/session');

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    if(!$_SESSION['user']) exit('No direct script access allowed!');
    if($data_user['level'] !== 'Admin') exit('No direct script access allowed!');
    ?>
<form method="POST" enctype="multipart/form-data">
    <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
    <div class="form-group">
        <label class="col-md-12 control-label">Type</label>
        <div class="col-md-12">
            <select name="type" class="form-control">
                <option value="info">Info</option>
                <option value="news">News</option>
                <option value="update">Update</option>
                <option value="maintenance">Maintenance</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-12 control-label">Title</label>
        <div class="col-md-12">
            <input type="text" name="title" class="form-control">
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-12 control-label">Content</label>
        <div class="col-md-12">
            <textarea name="content" class="form-control" rows="6"></textarea>
        </div>
    </div>
    <div class="form-group">
        <label>Gambar</label>
        <input type="file" class="form-control" name="image[]" accept="image/*" multiple>
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