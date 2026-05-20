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
        <label>Title</label>
        <input type="text" class="form-control" name="title">
    </div>
    <div class="form-group">
        <label>Description</label>
        <textarea name="description" class="form-control" rows="6"></textarea>
    </div>
     <div class="form-group">
         <label for="image">Banner</label>
         <input type="file" class="form-control-file" name="image" id="image" required>
         <span class="text-danger">Extensi (jpg, jpeg). Ukuran max. 2MB, (800 x 400 )</span>
    </div>
    </div>
    <div class="form-group">
        <label>Promo Berakhir</label>
        <input type="text" class="form-control" name="expired_at">
        <span class="text-danger">YYYY-MM-DD (Misal. <?= $date; ?>) atau Kosongkan untuk aktif selamanya</span>
    </div>
    <div class="form-group">
        <button type="submit" name="publish" class="btn btn-primary btn-block">Add</button>
    </div>
</form>
    <?
} else {
    exit('No direct script access allowed!');
}