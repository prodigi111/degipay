<?php
require '../../connect.php';
require _DIR_('library/session/session');

$get_id = isset($_GET['id']) ? filter($_GET['id']) : '';
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    if(!$_SESSION['user']) exit('No direct script access allowed!');
    if($data_user['level'] !== 'Admin') exit('No direct script access allowed!');
    $data_event = $call->query("SELECT * FROM modules_urgent_alert WHERE id = '$get_id'")->fetch_assoc();
    ?>
<form method="POST" role="form">
    <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
    <input type="hidden" id="id" name="id" value="<?= $get_id ?>">
    <div class="form-group">
        <label>Title</label>
        <input type="text" class="form-control" name="info" value="<?= $data_event['info']; ?>">
    </div>
    <div class="form-group">
        <label>Tampilkan</label>
        <select class="form-control" name="is_show">
            <?= select_opt($data_event['is_show'], '1', 'Ya'); ?>
            <?= select_opt($data_event['is_show'], '0', 'Tidak'); ?>
        </select>
    </div>
    <div class="form-group">
        <label>Urutan</label>
        <input type="text" class="form-control" name="order_id" value="<?= $data_event['order_id']; ?>">
    </div>
    <div class="form-group">
        <button type="submit" name="edit" class="btn btn-primary btn-block">Update</button>
    </div>
</form>
    <?
} else {
    exit('No direct script access allowed!');
}