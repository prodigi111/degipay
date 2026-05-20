<?php
require '../../connect.php';
require _DIR_('library/session/session');

$get_code = isset($_GET['q']) ? filter(base64_decode($_GET['q'])) : '';
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    if(!$_SESSION['user']) exit('No direct script access allowed!');
    if($data_user['level'] !== 'Admin') exit('No direct script access allowed!');
    if(!$get_code) exit('No direct script access allowed!');
    if($call->query("SELECT id FROM srv WHERE id = '$get_code'")->num_rows == false) exit('Service not found.');
    $row = $call->query("SELECT * FROM srv WHERE id = '$get_code'")->fetch_assoc();
    ?>
<div class="table-responsive">
    <table class="table table-striped table-bordered table-box">
        <tbody>
            <tr>
                <th class="table-detail">Code</th>
                <td class="table-detail"><?= $row['code'] ?></td>
            </tr>
            <tr>
                <th class="table-detail">Name</th>
                <td class="table-detail"><?= $row['name'] ?></td>
            </tr>
            <tr>
                <th class="table-detail">Note</th>
                <td class="table-detail"><?= nl2br($row['note']) ?></td>
            </tr>
            <tr>
                <th class="table-detail">Info</th>
                <td class="table-detail">
                    <li>Type: <?= ucfirst(str_replace('-', ' ', $row['type'])) ?></li>
                    <li>Brand: <?= $row['brand'] ?></li>
                    <li>Kategori: <?= $row['kategori'] ?></li>
                    <li>Provider: <?= $row['provider'] ?></li>
                </td>
            </tr>
            <tr>
                <th class="table-detail">Price</th>
                <td class="table-detail"><?= 'Rp '.currency($row['price']) ?></td>
            </tr>
            <tr>
                <th class="table-detail">Status</th>
                <td class="table-detail"><?= ucfirst($row['status']) ?></td>
            </tr>
        </tbody>
    </table>
</div>

    <form method="POST">
        <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
        <input type="hidden" id="web_token" name="web_token" value="<?= base64_encode($get_code) ?>">
        <div class="form-group">
            <div class="col-md-12">
                <button type="submit" name="delete" class="btn btn-primary btn-block">Hapus Layanan Ini</button>
            </div>
        </div>
    </form>
    <?
} else {
    exit('No direct script access allowed!');
}