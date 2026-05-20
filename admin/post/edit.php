<?php
require '../../connect.php';
require _DIR_('library/session/session');

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    if(!$_SESSION['user']) exit('No direct script access allowed!');
    if($data_user['level'] !== 'Admin') exit('No direct script access allowed!');
    if($call->query("SELECT id FROM post WHERE id = '".$_GET['q']."'")->num_rows == false) exit('User not found.' . $_GET['q']);
    $row = $call->query("SELECT * FROM post WHERE id = '".$_GET['q']."'")->fetch_assoc();
    ?>
<form method="POST" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $row['id']; ?>">
    <input type="hidden" name="image_old" value="<?= $row['image']; ?>">
    <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
    <div class="form-group">
        <label>Judul</label>
        <input type="text" class="form-control" name="title" value="<?= $row['title']; ?>">
    </div>
    <div class="form-group">
        <label>Kategori</label>
        <input type="text" class="form-control" name="category" value="<?= $row['category']; ?>">
    </div>
    <div class="form-group">
        <label>Thumbnail</label>
        <img src="../../library/assets/images/post/<?= $row['image']; ?>" width="160" class="rounded d-block mb-2">
        <input type="file" class="form-control" name="image">
    </div>
    <div class="form-group">
        <label>Konten</label>
        <textarea name="content"><?= $row['content']; ?></textarea>
    </div>
    <div class="form-group">
        <button type="submit" name="edit" class="btn btn-primary btn-block">Add</button>
    </div>
</form>
<script>
    CKEDITOR.replace('content');
</script>
    <?
} else {
    exit('No direct script access allowed!');
}