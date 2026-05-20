<?php
require '../connect.php';
require _DIR_('library/session/user');

$get_s = isset($_GET['s']) ? str_replace('=', '.', str_replace('-',' ',filter($_GET['s']))) : '';
$search_cat = $call->query("SELECT * FROM category WHERE name = '$get_s' AND type = 'pascabayar'");
if($search_cat->num_rows == 0) exit(redirect(0,base_url('order/pascabayar')));
$data_cat = $search_cat->fetch_assoc();
$operator = strtolower($data_cat['name']);
$code = str_replace('.', '=', str_replace(' ', '-', strtolower($data_cat['code'])));
$service = strtr($operator, [
            'angsuran kredit' => 'Angsuran Kredit',
            'bpjs kesehatan' => 'BPJS Kesehatan',
            'gas negara' => 'Gas Negara',
            'hp pascabayar' => 'HP Pascabayar',
            'internet tv kabel' => 'Internet & TV Kabel',
            'pln pascabayar' => 'Pln Pascabayar',
            'pbb' => 'PBB',
            'pdam' => 'PDAM'
        ]);
if(in_array($data_cat['name'], ['PDAM', 'INTERNET TV KABEL', 'PLN PASCABAYAR', 'HP PASCABAYAR', 'BPJS KESEHATAN', 'ANGSURAN KREDIT', 'PBB', 'GAS NEGARA'])) :
    $kategori = 'Umum';
        endif;
        
require 'action.php';
$page = isset($_SESSION['success']) ? 'Pembayaran Berhasil' : ucwords($operator);
require _DIR_('library/header/user');
$note = $call->query("SELECT * FROM srv WHERE brand = '".$operator."'")->fetch_assoc()['note'];
$note2 = $call->query("SELECT * FROM srv WHERE brand = '".$operator."'")->fetch_assoc()['note2'];
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
                            <img src="<?= assets('images/produk-icon/'.$code.'.png').'?'.time() ?>" class="image">
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
                                        <label class="label">Layanan</label>
                                        <select class="form-control custom-select" name="service" id="service" required>
                                            <option value="" disabled selected hidden> Select One</option>
                                            <?php
                                            $search = $call->query("SELECT * FROM srv WHERE type = 'pascabayar' AND brand = '$operator' AND kategori = '$kategori' ORDER BY price ASC");
                                            while($row = $search->fetch_assoc()) {
                                                print '<option value="'.$row['code'].'">'.$row['name'].'</option>';
                                            }
                                            ?>
                                        </select>
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
                                        <label class="label">ID Pelanggan</label>
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
                                        <label class="label">Tanggal</label>
                                        <input type="date" class="form-control" name="data2" id="data2" required>
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
                    <button type="submit" class="btn btn-primary btn-block mt-1 mb-1" name="buypostpaid" onclick="var e=this;setTimeout(function(){e.disabled=true;},0);return true;">Bayar Sekarang</button>
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