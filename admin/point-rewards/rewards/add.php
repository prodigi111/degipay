<?php
require '../../../connect.php';
require _DIR_('library/session/session');

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    if(!$_SESSION['user']) exit('No direct script access allowed!');
    if($data_user['level'] !== 'Admin') exit('No direct script access allowed!');
    ?>
<form method="POST" role="form" enctype="multipart/form-data">
    <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
    <div class="form-group">
        <label>Nama</label>
        <input type="text" class="form-control" name="name">
    </div>
    <div class="form-group">
        <label>Poin</label>
        <input type="number" class="form-control" name="point">
    </div>
    <div class="form-group">
        <label>Saldo Yang Di Dapat</label>
        <input type="number" class="form-control" name="getsaldo">
    </div>
    <div class="form-group">
        <label>Stock</label>
        <input type="number" class="form-control" name="stok">
    </div>
    <div class="form-group">
        <label>Tipe</label>
        <select class="form-control" name="type">
            <option value="">- Pilih Salah satu -</option>
            <option value="Saldo">Saldo</option>
            <option value="Physical">Barang Fisik</option>
        </select>
    </div>
     <div class="form-group">
         <label for="image">Gambar</label>
         <input type="file" class="form-control-file" name="image" id="image" required>
         <span class="text-danger">Extensi (jpg, jpeg). Ukuran max. 2MB, (1000 x 700 )</span>
    </div>
    </div>
    <div class="form-group">
        <label>Tersedia</label>
        <select class="form-control" name="available">
            <option value="">- Pilih Salah satu -</option>
            <option value="1">Ya</option>
            <option value="0">Tidak</option>
        </select>
    </div>
    <div class="form-group">
        <button type="submit" name="add" class="btn btn-primary btn-block">Add</button>
    </div>
</form>
    <?
} else {
    exit('No direct script access allowed!');
}