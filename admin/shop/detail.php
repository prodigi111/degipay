<?php
require '../../connect.php';
require _DIR_('library/session/session');

$get_code = isset($_GET['q']) ? filter(base64_decode($_GET['q'])) : '';
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    if(!$_SESSION['user']) exit('No direct script access allowed!');
    if($data_user['level'] !== 'Admin') exit('No direct script access allowed!');
    if(!$get_code) exit('No direct script access allowed!');
    $search = $call->query("SELECT * FROM produk WHERE kode = '$get_code'");
    if($search->num_rows == false) exit('Service not found.');
    $row = $search->fetch_assoc();
    $image = json_decode($row['image'], TRUE);
    ?>
<div class="table-responsive">
    <table class="table table-striped table-bordered table-box">
        <tbody>
            <tr>
                <th class="table-detail">Kode</th>
                <td class="table-detail"><?= $row['kode'] ?></td>
            </tr>
            <tr>
                <th class="table-detail">Nama</th>
                <td class="table-detail"><?= $row['nama'] ?></td>
            </tr>
            <tr>
                <th class="table-detail">Kategori</th>
                <td class="table-detail"><?= $row['kategori'] ?></td>
            </tr>
            <tr>
                <th class="table-detail">Keterangan</th>
                <td class="table-detail"><?= nl2br($row['keterangan']) ?></td>
            </tr>
            <tr>
                <th class="table-detail">Data Akun</th>
                <td class="table-detail"><?= nl2br($row['data']) ?></td>
            </tr>
            <tr>
                <th class="table-detail">Harga</th>
                <td class="table-detail">
                    <li>Harga : <?= 'Rp '.currency($row['harga']) ?></li>
                    <li>Profit : <?= 'Rp '.currency($row['profit']) ?></li>
                </td>
            </tr>
            <tr>
                <th class="table-detail">Status</th>
                <td class="table-detail"><?= ucfirst($row['status']) ?></td>
            </tr>
        </tbody>
    </table>
</div>

<? for($i = 0; $i <= count($image['data'])-1; $i++) { ?>
    <img src="<?= assets('images/produk/').$image['data'][$i]['image'] ?>" alt="alt" width="100%" class="mt-2">
<? } ?>

    <form method="POST">
        <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
        <input type="hidden" id="web_token" name="web_token" value="<?= base64_encode($get_code) ?>">
        <div class="form-group mt-3">
            <div class="col-md-12">
                <button type="submit" name="delete" class="btn btn-primary btn-block">Hapus Produk Ini</button>
            </div>
        </div>
    </form>

    <?
} else {
    exit('No direct script access allowed!');
}