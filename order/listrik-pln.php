<?php
require '../RGShenn.php';
require _DIR_('library/session/user');

$operator = strtolower('LISTRIK PLN');
$kategori = 'Umum';
require 'action.php';
$page = isset($_SESSION['success']) ? 'Pembayaran Berhasil' : ucwords($operator);
$page = strtr($page, [
            'Listrik Pln' => 'Listrik PLN'
        ]);
require _DIR_('library/header/user');
?>

<? if(isset($_SESSION['success'])) :  ?>

    <? require _DIR_('order/result') ?>

<? unset($_SESSION['success']); else: ?>
<? 
if ($data_user['level'] == 'Basic') $cashback = $row['price_basic'];
else $cashback = $row['price_premium']; 
?>
    <!-- App Capsule -->
    <div id="appCapsule" class="rgs-order">
        <div class="section service" style="background-color: #000957;border-color:#000957;
">
            <div class="wide-block-service">
                <form id="myForm">
                <ul class="listview image-listview no-line no-space flush">
                    <li>
                        <div class="item">
                            <img src="<?= assets('images/produk-icon/listrik-pln.png').'?'.time() ?>" class="image" height="50px" width="50px">
                            <div class="in">
                                <div class="form-group basic">
                                    <div class="input-wrapper">
                                        <label class="label">Nomor Pelanggan</label>
                                <input type="number" class="form-control" placeholder="Masukkan Nomor Pelanggan" name="data" id="data" required>
                                        <i class="clear-input">
                                            <ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon>
                                        </i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        
        <div class="section mb-1">
            <? require _DIR_('library/session/result-mobile') ?>
        </div>
        
        <div class="section rgs-list-layanan">
            <?php
            $search = $call->query("SELECT * FROM srv WHERE type = 'pascabayar' AND brand = '$operator' AND kategori = '$kategori' ORDER BY price ASC");
            if($search->num_rows == FALSE) { ?>
            <div class="alert alert-danger text-left fade show" role="alert">
                Tidak ada layanan yang tersedia!
            </div>
            <? } ?>
            <div class="row rgs-show">
                <? 
                while($row = $search->fetch_assoc()) {
                    if($row['status'] == 'available') :
                ?>
                <div class="col-12 mb-2">
                    <a href="javascript:;" onclick="ConfirmModal('<?= base_url('confirm-postpaid/'.$row['code'].'/') ?>')">
                        <div class="card">
                            <div class="card-body p-0" align="right">
                                <span class="badge badge-primary col-2" style="padding:0px 1.5px;border-radius:0px 11px 0px 11px;font-size:10px;">Tersedia</span>
                            </div>
                            <div class="card-body" style="padding:5px 15px 15px">
                                <h4 style="margin:0px 0px 4px;"><b><?= $row['name'] ?></b></h4>
                                <h5 style="margin:0px 0px 4px;color:#909090;"><?= $row['note'] ?></h5>
                                <div class="row">
                                    <div class="col-7 text-left">
                                        <h5 class="text text-primary mb-0"><b>Rp <?= currency($row['price']) ?></b></h5>
                                    </div>
                                <div class="col-5 text-right">
                                <? if($data_user['level'] === 'Basic') : ?>
                                    <h5 class="text text-gold mb-0"><b><?= currency($row['price_basic']) ?> Koin</b></h5>
                                <? elseif($data_user['level'] === 'Admin' AND 'Premium') : ?>
                                    <h5 class="text text-gold mb-0"><b><?= currency($row['price_premium']) ?> Koin</b></h5>
                                <? endif ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    </a>
                </div>
                <? else: ?>
                <div class="col-12 mb-2">
                        <div class="card">
                            <div class="card-body p-0" align="right">
                                <span class="badge badge-danger col-2" style="padding:0px 1.5px;border-radius:0px 11px 0px 11px;font-size:10px;">Gangguan</span>
                            </div>
                            <div class="card-body" style="padding:5px 15px 15px">
                                <h4 style="margin:0px 0px 4px;"><b><?= $row['name'] ?></b></h4>
                                <h5 style="margin:0px 0px 4px;color:#909090;"><?= $row['note'] ?></h5>
                                <div class="row">
                                    <div class="col-7 text-left">
                                        <h5 class="text text-primary mb-0"><b>Rp <?= currency($row['price']) ?></b></h5>
                                    </div>
                                <div class="col-5 text-right">
                                    <h5 class="text text-gold mb-0"><b><?= currency($row['price_basic']) ?> Koin</b></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; } ?>
            </div>
        </div>

    </div>
    <!-- * App Capsule -->
<? endif ?>   
<?php require _DIR_('library/footer/user') ?>

<script type="text/javascript">
$(document).ready(function() {
    
    $(".rgs-show").hide();
    $('input[name="data"]').keyup(function(){
        var target = $("#data").val();
        
        if(target.length <= 4) {
            $(".rgs-show").hide();
        } else {
            $(".rgs-show").show();
        }
        
    });
});

function ConfirmModal(link) {
    var target = $("#data").val();
    var target2 = $("#data2").val();
    target2 == '' || !target2 ? modalKonfirmasi('Konfirmasi Transaksi', link + target) : modalKonfirmasi('Konfirmasi Transaksi', link + target + '=' + target2);
}
</script>