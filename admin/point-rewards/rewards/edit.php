<?php
require '../../../connect.php';
require _DIR_('library/session/session');

$get_id = isset($_GET['id']) ? filter($_GET['id']) : '';
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    if(!$_SESSION['user']) exit('No direct script access allowed!');
    if($data_user['level'] !== 'Admin') exit('No direct script access allowed!');
    $data_rewards = $call->query("SELECT * FROM modules_point_rewards WHERE id = '$get_id'")->fetch_assoc();
    ?>
<form method="POST" role="form" enctype="multipart/form-data">
    <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
    <input type="hidden" id="id" name="id" value="<?= $get_id ?>">
    <div class="form-group">
        <label>Nama</label>
        <input type="text" class="form-control" name="name" value="<?= $data_rewards['name']; ?>">
    </div>
    <div class="form-group">
        <label>Poin</label>
        <input type="number" class="form-control" name="point" value="<?= $data_rewards['point']; ?>">
    </div>
    <div class="form-group">
        <label>Saldo Yang Di Dapat</label>
        <input type="number" class="form-control" name="getsaldo" value="<?= $data_rewards['getsaldo']; ?>">
    </div>
    <div class="form-group">
        <label>Stock</label>
        <input type="number" class="form-control" name="stok" value="<?= $data_rewards['stock']; ?>">
    </div>
    <div class="form-group">
        <label>Tipe</label>
        <select class="form-control" name="type">
            <?= select_opt($data_rewards['type'], 'Saldo', 'Saldo'); ?>
            <?= select_opt($data_rewards['type'], 'Physical', 'Barang Fisik'); ?>
        </select>
    </div>
     <div class="form-group">
         <label for="image">Gambar</label>
         <input type="file" class="form-control-file" name="image" id="image">
         <span class="text-danger">Extensi (jpg, jpeg). Ukuran max. 2MB, (1000 x 700 )</span>
    </div>
    </div>
    <div class="form-group">
        <label>Tersedia</label>
        <select class="form-control" name="available">
            <?= select_opt($data_rewards['available'], '1', 'Ya'); ?>
            <?= select_opt($data_rewards['available'], '0', 'Tidak'); ?>
        </select>
    </div>
    <div class="form-group">
        <button type="submit" name="edit" class="btn btn-primary btn-block">Update</button>
    </div>
</form>
    <?
} else {
    exit('No direct script access allowed!');
}