<?php
require '../RGShenn.php';
require _DIR_('library/session/user');

$get_s = isset($_GET['s']) ? str_replace('=', '#', str_replace('-',' ',filter($_GET['s']))) : '';
$code = strtr($get_s, [
            ' ' => '-',
            '#' => '='
        ]);
$search_cat = $call->query("SELECT * FROM category_donasi WHERE name = '$get_s'");
if($search_cat->num_rows == 0) exit(redirect(0,base_url('donasi/')));
$data_cat = $search_cat->fetch_assoc();
$operator = strtolower($data_cat['name']);
        
require 'action.php';
$page = 'Donasi';
$service = isset($_SESSION['success']) ? 'Pembayaran Berhasil' : ucwords($operator);
$service = strtr($service, [
            'Baznas' => 'BAZNAS',
            'Benihbaik' => 'BenihBaik',
            'Global Zakat Act' => 'Global Zakat ACT',
            'Laz Al Azhar' => 'LAZ Al-Azhar',
            'Laz Rydha' => 'LAZ RYDHA',
            'Nu Care Lazisnu' => 'NU Care-LAZISNU',
            'Pppa Darul Quran' => 'PPPA Darul Quran',
            'Yayasan Wwf Indonesia' => 'Yayasan WWF Indonesia'
        ]);
require _DIR_('library/header/user');
$search = $call->query("SELECT * FROM srv_donasi WHERE type IN ('donasi') AND category = '$operator' ORDER BY id ASC")->fetch_assoc();
$note = $call->query("SELECT * FROM srv_donasi WHERE service = '".$operator."'")->fetch_assoc()['note'];
$note2 = $call->query("SELECT * FROM srv_donasi WHERE service = '".$operator."'")->fetch_assoc()['note2'];
?>

<? if(isset($_SESSION['success'])) :  ?>

    <? require _DIR_('order/result') ?>

<? unset($_SESSION['success']); else: ?>
<style>
    .image-listview > li .item .icon-box.bg-primary {
        margin:0px 15px 0px 5px;
    }
    .image-listview > li .item .image {
        min-width: 40px;
        max-width: 40px;
    }
    .wide-block-service {
        border-bottom: 10px solid #FFF;
    }
</style>
    <!-- App Capsule -->
    <div id="appCapsule" class="rgs-order">

        <div class="section service">
            <div class="wide-block-service">
                <form method="POST">
                    <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
                    <input type="hidden" id="web_token" name="web_token" value="<?= base64_encode($search['code']) ?>">
                <ul class="listview image-listview no-line no-space flush">
                    <li>
                        <div class="item">
                            <img src="<?= assets('images/donasi/'.$code.'.png').'?'.time() ?>" class="image">
                            <div class="in">
                                <div><?= $service ?></div>
                                <a href="#"data-toggle="modal" data-target="#openMenuDeskripsi" class="headerButton">
                                <ion-icon name="help-circle-outline" style="font-size:20px;color:#141515;"></ion-icon>
                                </a>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="item">
                            <div class="icon-box bg-primary">
                                <ion-icon name="create-outline"></ion-icon>
                            </div>
                            <div class="in">
                                <div class="form-group basic">
                                    <div class="input-wrapper">
                                        <label class="label">Nama Pelanggan</label>
                                        <input type="text" class="form-control" placeholder="Optional - Masukkan Nama" name="data" id="data" required>
                                        <i class="clear-input">
                                            <ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon>
                                        </i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="item">
                            <div class="icon-box bg-primary">
                                <ion-icon name="create-outline"></ion-icon>
                            </div>
                            <div class="in">
                                <div class="form-group basic">
                                    <div class="input-wrapper">
                                        <label class="label">Jumlah Donasi</label>
                                        <input type="number" class="form-control" placeholder="Masukkan Jumlah Donasi" name="data2" id="data2" required>
                                        <i class="clear-input">
                                            <ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon>
                                        </i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
                <div class="form-bottom-fixed">
                    <button type="submit" class="btn btn-primary btn-block mt-1 mb-1" name="donasi" onclick="var e=this;setTimeout(function(){e.disabled=true;},0);return true;">Bayar Sekarang</button>
                </div>
                </form>
            </div>
        </div>
        
        <div class="section mb-1">
            <? require _DIR_('library/session/result-mobile') ?>
        </div>
        
    </div>
    <!-- * App Capsule -->
<? endif ?>
<div class="modal fade action-sheet" id="openMenuDeskripsi" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Deskripsi</h5>
                </div>
                <div class="modal-body p-2">
                    <h6>
                        <?= $note ?>
                    </h6>
                    <h6>
                        <?= $note2 ?>
                    </h6>
                </div>
            </div>
        </div>
    </div>
<?php require _DIR_('library/footer/user') ?>