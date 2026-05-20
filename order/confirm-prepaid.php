<?php
require '../RGShenn.php';
require _DIR_('library/session/session');

$get_code = isset($_GET['code']) ? filter($_GET['code']) : '';
$get_data = isset($_GET['data']) ? filter($_GET['data']) : '';

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    if(!$_SESSION['user']) exit('No direct script access allowed!');
    if(!$get_code || !$get_data) exit('No direct script access allowed!');
    if($call->query("SELECT * FROM srv WHERE code = '$get_code' AND status = 'available'")->num_rows == false) exit('Layanan Tidak Ditemukan.');
    $row = $call->query("SELECT * FROM srv WHERE code = '$get_code' AND status = 'available'")->fetch_assoc();
    $search_cat = $call->query("SELECT * FROM category WHERE code = '".$row['brand']."'");
    $data_cat = $search_cat->fetch_assoc();
    $operator = strtolower($row['brand']);
    $tipe = $data_cat['type'];
    $label = $tipe == 'games' ? 'ID Game' : 'Nomor Tujuan';
    $MustHaveZone = ['mobile legend', 'lifeafter credits', 'ragnarok m: eternal love', 'tom and jerry : chase', 'knights of valour', 'scroll of onmyoji'];
    $produk = $row['name'];
    $keterangan = $row['note'];
    $keterangan = strtr($keterangan, [
            '.com' => '.com '
        ]);
    $get_data = str_replace('SHENN','',$get_data);
    $get_data = in_array($operator, $MustHaveZone) ? str_replace('=',' | ',$get_data) : str_replace('=', '', $get_data);
    if($row['brand'] == 'GARENA' && $call->query("SELECT * FROM kodeVoucher WHERE kategori = 'GARENA' AND idLayanan = '$get_code' AND status = 'Tersedia'")->num_rows == 1) {
        $server = 'X';
    } else {
        $server = $row['provider'];
    }
    $price = price($data_user['level'],$row['price'],$server);
    
if($row['provider'] == 'X') :
    $actionPOST = 'buymanual';
    else :
        $actionPOST = 'buyprepaid';
        endif;
?>
<style>
    .in-balance {
        font-size: 12px;
        margin-bottom: 8px;
    }
    .balance {
        color: #4F5050;
        font-size: 15px;
        font-weight: bold;
    }
    .listview-title {
        padding: 7px 0px;
    }
    form {
        padding:24px;
    }
    .form-group.basic {
        padding:0px;
    }
    .close-pin {
        text-align: right!important;
        font-size: xx-large;
        color: #4F5050;
        opacity: 0.5;
    }
    a {
        color: #4F5050;
    }
    a:hover, a:active, a:focus {
        color: #4F5050;
    }
    .rgs-text-rincian {
        padding: 5px 0px;
    }
    .btn-primary-new{
        background-color: #000957 !important;
    }
</style>
    <div class="section s-invoice">
        <ul class="card listview rgs-listview image-listview">
            <li>
                <div class="item-balance">
                    <div class="in">
                        <div class="in-balance">Saldo Anda</div>
                        <div class="balance">Rp <?= $data_user['balance'] ?></div>
                    </div>
                </div>
            </li>
        </ul>
        
            <ul class="listview rgs-listview-custom image-listview">
                <? if(in_array(strtolower($row['brand']), $MustHaveZone)) : ?>
                <li>
                    <div class="item">
                        <div class="in">
                            <div class="text-muted"><?= $label ?></div>
                            <div class="rgs-text-rincian col-8"><?= explode(' | ', filter($get_data))['0'] ?></div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="item">
                        <div class="in">
                            <div class="text-muted">Server</div>
                            <div class="rgs-text-rincian col-8"><?= explode(' | ', filter($get_data))['1'] ?></div>
                        </div>
                    </div>
                </li>
                <? else: ?>
                <li>
                    <div class="item">
                        <div class="in">
                            <div class="text-muted"><?= $label ?></div>
                            <div class="rgs-text-rincian col-8"><?= $get_data ?></div>
                        </div>
                    </div>
                </li>
                <? endif ?>
                <li>
                    <div class="item">
                        <div class="in">
                            <div class="text-muted">Produk</div>
                            <div class="rgs-text-rincian col-9"><?= $produk ?></div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="item">
                        <div class="in">
                            <div class="text-muted">Keterangan</div>
                            <div class="rgs-text-rincian col-9"><?= $keterangan ?></div>
                        </div>
                    </div>
                </li>
            </ul>
            
        <div class="listview-title mt-1">Detail Pembayaran</div>
            <ul class="listview rgs-listview-custom image-listview">
                <li>
                    <div class="item">
                        <div class="in">
                            <div class="text-muted">Harga</div>
                            <div class="rgs-text-rincian"><?= 'Rp '.currency($price) ?></div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="item">
                        <div class="in">
                            <div class="text-muted">Biaya Admin</div>
                            <div class="rgs-text-rincian">Rp 0</div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="item">
                        <div class="in">
                            <div class="text-muted">Total Pembayaran</div>
                            <div class="rgs-text-rincian"><b><?= 'Rp '.currency($price) ?></b></div>
                        </div>
                    </div>
                </li>
            </ul>
            <form method="POST">
                <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
                <input type="hidden" id="web_token" name="web_token" value="<?= base64_encode($get_code) ?>">
                <? if(in_array(strtolower($row['brand']), $MustHaveZone)) : ?>
                <input type="hidden" id="data" name="data" value="<?= explode(' | ', filter($get_data))['0'] ?>">
                <input type="hidden" id="data2" name="data2" value="<?= explode(' | ', filter($get_data))['1'] ?>">
                <? else: ?>
                <input type="hidden" id="data" name="data" value="<?= $get_data ?>">
                <? endif ?>
            <div class="form-button-group">
                <a href="#" data-toggle="modal" data-target="#TransaksiPIN" class="btn btn-primary-new btn-block btn-lg" style="color:white !important;">Bayar Sekarang</a>
            </div>
                
    <div class="modal fade action-sheet" id="TransaksiPIN" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content" style="background-color: #00000080;">
                <div class="modal-body">
                    <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
                        <div class="form-bottom-fixed">
                            <div class="close-pin">
                                <a href="#" data-dismiss="modal">
                                    <ion-icon name="close-circle"></ion-icon>
                                </a>
                            </div>
                            <div class="form-group basic pb-1">
                                <div class="input-wrapper">
                                    <label class="label">Masukkan PIN Anda</label>
                                    <input type="password" class="form-control" placeholder="Masukkan PIN Anda" maxlength="6" name="pin" pattern="[0-9]*" inputmode="numeric">
                                    <i class="clear-input">
                                        <ion-icon name="close-circle"></ion-icon>
                                    </i>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <a href="#" class="btn rounded btn-list btn-block btn-lg text-primary m-1 mb-0" data-dismiss="modal" style="border:1px solid #5f33ba;">Batal</a>
                                <button type="submit" class="btn rounded btn-primary btn-block btn-lg m-1 mb-0 btn-loading" name="buyprepaid" onclick="var e=this;setTimeout(function(){e.disabled=true;},0);return true;">Konfirmasi</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    </div>
<?
} else {
    exit('No direct script access allowed!');
}