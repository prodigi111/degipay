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
        <label>Judul</label>
        <input type="text" class="form-control" name="title">
    </div>
    <div class="form-group">
        <label>Kategori</label>
        <input type="text" class="form-control" name="category">
    </div>
    <div class="form-group">
        <label>Thumbnail</label>
        <input type="file" class="form-control" name="image">
    </div>
    <div class="form-group">
        <label>Konten</label>
        <textarea name="content"></textarea>
    </div>
    <div class="form-group">
        <button type="submit" name="add" class="btn btn-primary btn-block">Add</button>
    </div>
</form>
<script>
    CKEDITOR.replace('content');
</script>
    <?
} else {
    exit('No direct script access allowed!');
}