<?php
require '../RGShenn.php';
require _DIR_('library/session/premium');

$komisiSuccess = $call->query("SELECT SUM(mutation.amount) AS total FROM mutation WHERE type = '+' AND kategori = 'Tarik Komisi' AND user = '$sess_username'")->fetch_assoc()['total'];

$page = 'Fitur Premium';
require _DIR_('library/header/user');
if(in_array($data_user['level'],['Basic'])) {
    $_SESSION['result'] = ['type' => false,'message' => 'Maaf Fitur Ini Khusus Level Premium!'];
    redirect(1, base_url());
}
?>

    <!-- App Capsule -->
    <div id="appCapsule" class="extra-header-active rgs-referral">
        <div class="section full text-center pt-2">
            <h4 class="text-green">Komisi Yang Sudah Dibayarkan</h4>
            <h1 class="text-green">Rp <?= currency($komisiSuccess) ?></h1>
            <div class="row pt-3 pb-1 pl-2 pr-2">
                <div class="col-6 text-left">
                    <p class="text-green">Sisa Komisi Saat Ini</p>
                    <h3 class="text-green">Rp <?= currency($data_user['komisi']) ?></h3>
                </div>
                <div class="col-6">
                    <a href="<?= base_url('premium/tarik-komisi.php') ?>" class="btn btn-warning">
                        TARIK KOMISI<ion-icon name="arrow-down-circle-outline"></ion-icon>
                    </a>
                </div>
            </div>
        </div>
        <div class="divider mt-3"></div>
        
        <div class="tab-content mt-1">

            <!-- Penarikan tab -->
            <div class="tab-pane fade active show" id="Penarikan" role="tabpanel">
                
            <?php
            $searchDate = $call->query("SELECT date FROM mutation WHERE user = '$sess_username' AND kategori IN ('Tarik Komisi') GROUP BY date ORDER BY date DESC");
            if($searchDate->num_rows == FALSE) {
                print '<div class="alert alert-danger text-left fade show mt-2 mb-2 mr-1 ml-1" role="alert">Anda Belum Memiliki Riwayat Penarikan</div>';
            } else {
            while($rowDate = $searchDate->fetch_assoc()) {
                $komisiDate = $call->query("SELECT SUM(mutation.amount) AS total FROM mutation WHERE kategori IN ('Tarik Komisi') AND date = '".$rowDate['date']."' AND user = '$sess_username'")->fetch_assoc()['total'];
            ?>
            <div class="row">
                <div class="col-6">
                    <div class="listview-title"><?= format_date('id', $rowDate['date']) ?></div>
                </div>
                <div class="col-6 text-right pr-2" style="padding-top: 6px !important;">
                    <span class="badge badge-success">+Rp <?= currency($komisiDate) ?></span>
                </div>
            </div>
            
            <ul class="listview image-listview rgs-komisi">
                <?
                $searchKomisi = $call->query("SELECT * FROM mutation WHERE user = '$sess_username' AND kategori IN ('Tarik Komisi') AND date = '".$rowDate['date']."' ORDER BY id DESC");
                while ($rowKomisi = $searchKomisi->fetch_assoc()) {
                    $note = $rowKomisi['note'];
                ?>
                <li>
                    <div class="item">
                        <div class="icon-box bg-transparent text-secondary">
                            <ion-icon name="cash-outline"></ion-icon>
                        </div>
                        <div class="in">
                            <div>
                                <header><?= $rowKomisi['kategori'] ?></header>
                                <small><?= $note ?></small>
                            </div>
                            <div>
                                <span class="text-muted text-right"><?= explode(' - ', format_date('id', $rowKomisi['date'].' '.$rowKomisi['time']))['1'] ?></span>
                                <span class="text-success text-right">+Rp <?= currency($rowKomisi['amount']) ?></span>
                            </div>
                        </div>
                    </div>
                </li>
                <? } ?>
            </ul>
            <? } } ?>
                
            </div>
            <!-- * Penarikan tab -->
    
            <!-- Komisi tab -->
            <div class="tab-pane fade" id="Komisi" role="tabpanel">
            
            <?php
            $searchDate = $call->query("SELECT date FROM mutation WHERE user = '$sess_username' AND kategori IN ('Komisi Transaksi', 'Komisi Upgrade', 'Komisi Transaksi Kami Tarik') GROUP BY date ORDER BY date DESC");
            if($searchDate->num_rows == FALSE) {
                print '<div class="alert alert-danger text-left fade show mt-2 mb-2 mr-1 ml-1" role="alert">Anda Belum Memiliki Riwayat Komisi</div>';
            } else {
            while($rowDate = $searchDate->fetch_assoc()) {
                $komisiDate = $call->query("SELECT SUM(mutation.amount) AS total FROM mutation WHERE kategori IN ('Komisi Transaksi', 'Komisi Upgrade') AND date = '".$rowDate['date']."' AND user = '$sess_username'")->fetch_assoc()['total'];
            ?>
            <div class="row">
                <div class="col-6">
                    <div class="listview-title"><?= format_date('id', $rowDate['date']) ?></div>
                </div>
                <div class="col-6 text-right pr-2" style="padding-top: 6px !important;">
                    <span class="badge badge-success">+Rp <?= currency($komisiDate) ?></span>
                </div>
            </div>
            
            <ul class="listview image-listview rgs-komisi">
                <?
                $searchKomisi = $call->query("SELECT * FROM mutation WHERE user = '$sess_username' AND kategori IN ('Komisi Transaksi', 'Komisi Upgrade', 'Komisi Transaksi Kami Tarik') AND date = '".$rowDate['date']."' ORDER BY id DESC");
                while ($rowKomisi = $searchKomisi->fetch_assoc()) {
                    $username = isset(explode('@', explode(' -', $rowKomisi['note'])['0'])['1']) ? explode('@', explode(' -', $rowKomisi['note'])['0'])['1'] : '';
                    $name = $call->query("SELECT username, name FROM users WHERE username = '$username'")->fetch_assoc()['name'];
                    $note = isset(explode(' - ', $rowKomisi['note'])['1']) == 'Level Premium' ? '@'.$name.' - '.explode(' -', $rowKomisi['note'])['1']  : $rowKomisi['note'].' | Referral';
                ?>
                <li>
                    <div class="item">
                        <div class="icon-box bg-transparent text-secondary">
                            <ion-icon name="cash-outline"></ion-icon>
                        </div>
                        <div class="in">
                            <div>
                                <header><?= $rowKomisi['kategori'] ?></header>
                                <small><?= $note ?></small>
                            </div>
                            <div>
                                <span class="text-muted text-right"><?= explode(' - ', format_date('id', $rowKomisi['date'].' '.$rowKomisi['time']))['1'] ?></span>
                                <span class="text-success text-right"><?= $rowKomisi['type'] ?>Rp <?= currency($rowKomisi['amount']) ?></span>
                            </div>
                        </div>
                    </div>
                </li>
                <? } ?>
            </ul>
            <? } } ?>
    
            </div>
            <!-- * Komisi tab -->

        </div>
        
    </div>
    <!-- * App Capsule -->

<?php require _DIR_('library/footer/user') ?>