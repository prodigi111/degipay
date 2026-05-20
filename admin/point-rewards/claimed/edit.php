<?php
require '../../../connect.php';
require _DIR_('library/session/session');

$get_id = isset($_GET['id']) ? filter($_GET['id']) : '';
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    if(!$_SESSION['user']) exit('No direct script access allowed!');
    if($data_user['level'] !== 'Admin') exit('No direct script access allowed!');
    $data_history = $call->query("SELECT * FROM modules_point_rewards_data WHERE id = '$get_id'")->fetch_assoc();
    $data_target = json_decode($data_history['physical_address']);
    ?>
<form method="POST" role="form" enctype="multipart/form-data">
    <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
    <input type="hidden" id="id" name="id" value="<?= $get_id ?>">
    <div class="form-group">
        <label>Nama</label>
        <input type="text" class="form-control" name="name" value="<?= $data_target->name; ?>">
    </div>
    <div class="form-group">
        <label>No. Telepon</label>
        <input type="telp" class="form-control" name="phone" value="<?= $data_target->phone; ?>">
    </div>
    <div class="form-group">
        <label>Alamat</label>
        <div class="col-md-12">
            <textarea name="address" class="form-control" rows="6"><?= $data_target->address; ?></textarea>
        </div>
    </div>
    <div class="form-group">
        <label>Resi</label>
        <input type="text" class="form-control" name="receipt" value="<?= $data_history['physical_receipt']; ?>">
    </div>
    <div class="form-group">
        <label>Status</label>
        <select class="form-control" name="status">
            <?= select_opt($data_history['status'], 'Make a Request', 'Mengajukan Permintaan'); ?>
            <?= select_opt($data_history['status'], 'Request Accepted', 'Permintaan Diterima'); ?>
            <?= select_opt($data_history['status'], 'Processing', 'Sedang Di Proses'); ?>
            <?= select_opt($data_history['status'], 'Success', 'Berhasil'); ?>
            <?= select_opt($data_history['status'], 'Failed', 'Permintaan Di Tolak'); ?>
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