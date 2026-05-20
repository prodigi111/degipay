<?php
require '../RGShenn.php';
require _DIR_('library/session/user');

$get_s = isset($_GET['s']) ? str_replace('=', '.', str_replace('-',' ',filter($_GET['s']))) : '';
$search_cat = $call->query("SELECT * FROM category WHERE name = '$get_s' AND type = 'pulsa-internasional'");
if($search_cat->num_rows == 0) exit(redirect(0,base_url('order/pulsa-international')));
$data_cat = $search_cat->fetch_assoc();
$operator = strtolower($data_cat['name']);
        
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
                <ul class="listview image-listview no-line no-space flush">
                    <li>
                        <div class="item">
                            <div class="icon-box bg-primary">
                                <ion-icon name="create-outline"></ion-icon>
                            </div>
                            <div class="in">
                                <div class="form-group basic">
                                    <div class="input-wrapper">
                                        <label class="label">Nomor HP</label>
                                        <input type="number" class="form-control" placeholder="Masukkan Nomor HP" name="data" id="data" required>
                                        <i class="clear-input">
                                            <ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon>
                                        </i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
                <? if($call->query("SELECT * FROM srv WHERE provider = 'X' AND brand = '".$data_cat['code']."'")->num_rows == TRUE) : ?>
                <ul class="nav nav-tabs style1 mt-1" role="tablist" id="tabpanel">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#Server1" role="tab">
                            Server 1
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#Server2" role="tab">
                            Server 2
                        </a>
                    </li>
                </ul>
                <? endif; ?>
            </div>
        </div>
        
        <div class="section mb-1">
            <? require _DIR_('library/session/result-mobile') ?>
        </div>
        
        <? if($call->query("SELECT * FROM srv WHERE provider = 'X' AND brand = '".$data_cat['code']."'")->num_rows == TRUE) : ?>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="Server1" role="tabpanel">
                <div class="section rgs-list-layanan">
                    <?php
                    $search = $call->query("SELECT * FROM srv WHERE type = 'pulsa-internasional' AND brand = '$operator' AND provider = 'DIGI' ORDER BY price ASC");
                    if($search->num_rows == FALSE) { ?>
                    <div class="alert alert-danger text-left fade show" role="alert">
                        Tidak Ada Layanan Yang Tersedia!
                    </div>
                    <? } ?>
                    <div class="row rgs-show">
                <? 
                while($row = $search->fetch_assoc()) {
                ?>
                <div class="col-12 mb-2">
                    <? if($row['status'] == 'available') : ?>
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
                <? endif ?>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="Server2" role="tabpanel">
                <div class="section rgs-list-layanan">
                    <?php
                    $search = $call->query("SELECT * FROM srv WHERE type = 'pulsa-internasional' AND brand = '$operator' AND provider = 'X' ORDER BY price ASC");
                    if($search->num_rows == FALSE) { ?>
                    <div class="alert alert-danger text-left fade show" role="alert">
                        Tidak Ada Layanan Yang Tersedia!
                    </div>
                    <? } ?>
                    <div class="row rgs-show">
                <? 
                while($row = $search->fetch_assoc()) {
                ?>
                <div class="col-12 mb-2">
                    <? if($row['status'] == 'available') : ?>
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
                <? endif ?>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <? else: ?>
        <div class="section rgs-list-layanan">
            <?php
            $search = $call->query("SELECT * FROM srv WHERE type = 'pulsa-internasional' AND brand = '$operator' ORDER BY price ASC");
            if($search->num_rows == FALSE) { ?>
            <div class="alert alert-danger text-left fade show" role="alert">
                Tidak ada layanan yang tersedia!
            </div>
            <? } ?>
            <div class="row rgs-show">
                <? 
                while($row = $search->fetch_assoc()) {
                ?>
                <div class="col-12 mb-2">
                    <? if($row['status'] == 'available') : ?>
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
                <? endif ?>
            <?php } ?>
        </div>
    </div>
    <? endif ?>
</div>
<!-- * App Capsule -->
<? endif ?>   
<?php require _DIR_('library/footer/user') ?>

<script type="text/javascript">
$(document).ready(function() {
    
    <? if($call->query("SELECT * FROM srv WHERE provider = 'X' AND brand = '".$data_cat['code']."'")->num_rows == TRUE) : ?>
        $("#tabpanel").hide();
    <? endif ?>
    
    $(".rgs-show").hide();
    $('input[name="data"]').keyup(function(){
        var target = $("#data").val();
        
        if(target.length < 4) {
            $(".rgs-show").hide();
            <? if($call->query("SELECT * FROM srv WHERE provider = 'X' AND brand = '".$data_cat['code']."'")->num_rows == TRUE) : ?>
                $("#tabpanel").hide();
            <? endif ?>
        } else {
            $(".rgs-show").show();
            <? if($call->query("SELECT * FROM srv WHERE provider = 'X' AND brand = '".$data_cat['code']."'")->num_rows == TRUE) : ?>
                $("#tabpanel").show();
            <? endif ?>
        }
    });
});

function ConfirmModal(link) {
    var target = $("#data").val();
    var target2 = $("#data2").val();
    target2 == '' || !target2 ? modalKonfirmasi('Konfirmasi Transaksi', link + target) : modalKonfirmasi('Konfirmasi Transaksi', link + target + '=' + target2);
}
</script>