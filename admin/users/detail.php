<?php
require '../../connect.php';
require _DIR_('library/session/session');

$get_code = isset($_GET['q']) ? filter(base64_decode($_GET['q'])) : '';
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    if(!$_SESSION['user']) exit('No direct script access allowed!');
    if($data_user['level'] !== 'Admin') exit('No direct script access allowed!');
    if(!$get_code) exit('No direct script access allowed!');
    if($call->query("SELECT id FROM users WHERE id = '$get_code'")->num_rows == false) exit('User not found.');
    $row = $call->query("SELECT * FROM users WHERE id = '$get_code'")->fetch_assoc();
    $row_api = $call->query("SELECT * FROM users_api WHERE user = '".$row['username']."'")->fetch_assoc();
    
    $pengeluaran = $call->query("SELECT SUM(mutation.amount) AS total FROM mutation WHERE type = '-' AND user = '".$row['username']."' AND kategori IN ('Transaksi', 'Deposit', 'Lainnya', 'Tarik Komisi')")->fetch_assoc()['total'];
    $pemasukkan  = $call->query("SELECT SUM(mutation.amount) AS total FROM mutation WHERE type = '+' AND user = '".$row['username']."' AND kategori IN ('Transaksi', 'Deposit', 'Lainnya', 'Tarik Komisi')")->fetch_assoc()['total'];

    $uplink = (strtoupper($row['uplink']) == 'RGS-SYSTEM') ? 'RGS SYSTEM' : $call->query("SELECT * FROM users WHERE username = '".$row['uplink']."'")->fetch_assoc()['name'];
    ?>
<div class="table-responsive">
    <table class="table table-striped table-bordered table-box">
        <tbody>
            <tr>
                <th class="table-detail">Nama Lengkap</th>
                <td class="table-detail"><?= $row['name'] ?></td>
            </tr> 
            <tr>
                <th class="table-detail">No Card</th>
                <td class="table-detail"><?= $row['card'] ?></td>
            </tr>
            <tr>
                <th class="table-detail">Email</th>
                <td class="table-detail"><?= $row['email'] ?></td>
            </tr>
            <tr>
                <th class="table-detail">Nomor HP</th>
                <td class="table-detail"><?= $row['phone'] ?></td>
            </tr>
            <tr>
                <th class="table-detail">Username</th>
                <td class="table-detail"><?= $row['username'] ?></td>
            </tr>
            <tr>
                <th class="table-detail">Saldo</th>
                <td class="table-detail">
                    <li>Saldo : Rp <?= currency($row['balance']) ?></li>
                    <li>Pemasukkan : Rp <?= currency($pemasukkan) ?></li>
                    <li>Pengeluaran : Rp <?= currency($pengeluaran) ?></li>
                    <li>Komisi : <?= currency($row['komisi']) ?></li>
                    <li>Poin : <?= currency($row['point']) ?></li>
                </td>
            </tr>
            <tr>
                <th class="table-detail">Level</th>
                <td class="table-detail"><?= $row['level'] ?></td>
            </tr>
            <tr>
                <th class="table-detail">Referral</th>
                <td class="table-detail">
                    <li>Kode:  <?= $row['referral'] ?></li>
                    <li>Uplink : <?= $uplink ?></li>
                </td>
            </tr>
            <tr>
                <th class="table-detail">Status</th>
                <td class="table-detail"><?= ($row['status'] == 'active') ? 'Active' : 'Suspended' ?></td>
            </tr>
            <tr>
                <th class="table-detail">Bergabung</th>
                <td class="table-detail"><?= format_date('en',$row['joined']) ?></td>
            </tr>
        </tbody>
    </table>
</div>
    <?
} else {
    exit('No direct script access allowed!');
}