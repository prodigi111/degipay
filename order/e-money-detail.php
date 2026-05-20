<?php
require '../RGShenn.php';
require _DIR_('library/session/user');

$get_s = isset($_GET['s']) ? str_replace('=', '.', str_replace('-',' ',filter($_GET['s']))) : '';
$search_cat = $call->query("SELECT * FROM category WHERE name = '$get_s' AND type = 'e-money'");
if($search_cat->num_rows == 0) exit(redirect(0,base_url('order/e-money')));
$data_cat = $search_cat->fetch_assoc();
$operator = strtolower($data_cat['name']);

if(in_array($data_cat['name'], ['GO PAY DRIVER', 'GRAB DRIVER', 'MAXIM DRIVER'])) :
    $kategori = 'Driver';
    else:
        $kategori = 'Umum';
        endif;
$srv = $call->query("SELECT * FROM srv WHERE type = 'e-money' AND brand = '$operator' AND kategori = '$kategori' ORDER BY price ASC")->fetch_assoc();

if($srv['provider'] == 'X') :
    $label = 'Nama Akun Paypal';
    $placeholder = 'Masukkan Nama Terlebih Dahulu';
    $tipe = 'text';
    else :
        $label = 'Nomor HP';
        $placeholder = 'Masukkan Nomor HP Terlebih Dahulu';
        $tipe = 'number';
        endif;
        
require 'action.php';
$page = isset($_SESSION['success']) ? 'Pembayaran Berhasil' : ucwords($operator);
require _DIR_('library/header/user');
?>

<? if(isset($_SESSION['success'])) :  ?>

    <? require _DIR_('order/result') ?>

<? unset($_SESSION['success']); else: ?>

    <!-- App Capsule -->
    <div id="appCapsule" class="rgs-order">
        <div class="section service" style="background-color: #000957;border-color:#000957;
">
            <div class="wide-block-service">
                <form id="myForm">
                <ul class="listview image-listview no-line no-space flush">
                    <li>
                        <div class="item">
                            <div class="icon-box bg-primary">
                                <ion-icon name="create-outline"></ion-icon>
                            </div>
                            <div class="in">
                                <div class="form-group basic">
                                    <div class="input-wrapper">
                                        <label class="label"><?= $label ?></label>
                                        <input type="<?= $tipe ?>" class="form-control" placeholder="<?= $placeholder ?>" name="data" id="data" required>
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
            $search = $call->query("SELECT * FROM srv WHERE type = 'e-money' AND brand = '$operator' AND kategori = '$kategori' ORDER BY price ASC");
            if($search->num_rows == FALSE) { ?>
            <div class="alert alert-danger text-left fade show" role="alert">
                Tidak Ada Layanan Yang Tersedia!
            </div>
            <? } ?>
            <div class="row rgs-show">
                <? 
                while($row = $search->fetch_assoc()) {
                    if($row['status'] == 'available') :
                ?>
                <div class="col-12 mb-2">
                    <a href="javascript:;" onclick="ConfirmModal('<?= base_url('confirm-prepaid/'.$row['code'].'/') ?>')">
                        <div class="card">
                            <div class="card-body p-0" align="right">
                                <span class="badge badge-primary col-2" style="padding:0px 1.5px;border-radius:0px 11px 0px 11px;font-size:10px;">Tersedia</span>
                            </div>
                            <div class="card-body" style="padding:5px 15px 15px">
                                <h4 style="margin:0px 0px 4px;"><b><?= $row['name'] ?></b></h4>
                                <h5 style="margin:0px 0px 4px;color:#909090;"><?= $row['note'] ?></h5>
                                <div class="row">
                                    <div class="col-12 text-left">
                                        <h5 class="text text-primary mb-0"><b>Rp <?= currency(price($data_user['level'], $row['price'], $row['provider'])) ?></b></h5>
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
                                <span class="badge badge-warning col-2" style="padding:0px 1.5px;border-radius:0px 11px 0px 11px;font-size:10px;">Gangguan</span>
                            </div>
                            <div class="card-body" style="padding:5px 15px 15px">
                                <h4 style="margin:0px 0px 4px;"><b><?= $row['name'] ?></b></h4>
                                <h5 style="margin:0px 0px 4px;color:#909090;"><?= $row['note'] ?></h5>
                                <div class="row">
                                    <div class="col-12 text-left">
                                        <h5 class="text text-primary mb-0"><b>Rp <?= currency(price($data_user['level'], $row['price'], $row['provider'])) ?></b></h5>
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