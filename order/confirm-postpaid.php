<?php
require '../RGShenn.php';
require _DIR_('library/session/session');

$get_code = isset($_GET['code']) ? filter($_GET['code']) : '';
$get_data = isset($_GET['data']) ? filter($_GET['data']) : '';

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    if(!$_SESSION['user']) exit('No direct script access allowed!');
    if(!$get_code || !$get_data) exit('No direct script access allowed!');
    if($call->query("SELECT * FROM srv WHERE code = '$get_code' AND type = 'pascabayar' AND status = 'available'")->num_rows == false) exit('Layanan Tidak Ditemukan.');
    $row = $call->query("SELECT * FROM srv WHERE code = '$get_code' AND status = 'available'")->fetch_assoc();
    //146802199352
    $WebID = random_number(8);
    $TrxID = random(10);
    if($row['provider'] == 'DIGI') $try = $DIGI->CheckBill($get_code,$get_data,$TrxID);
    else $try = ['result' => false,'message' => 'Invalid Data.'];
    
    $errMSG = (stristr(strtolower($try['message']),'saldo') || stristr(strtolower($try['message']),'balance')) ? 'System Error.' : $try['message'];
    if($try['result'] == false) exit('<div class="alert alert-danger text-left fade show mt-2 mr-1 ml-1" role="alert">'.$errMSG.'</div>');
    
    if ($data_user['level'] == 'Basic') {
        $admin = conf('trxadmin', 3);
    } else {
        $admin = conf('trxadmin', 4);
    }
    $price = $try['data']['price'] + $admin;
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
                <li>
                    <div class="item">
                        <div class="in">
                            <div class="text-muted">ID Pelanggan</div>
                            <div class="rgs-text-rincian col-9"><?= $try['data']['customer_no'] ?></div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="item">
                        <div class="in">
                            <div class="text-muted">Nama Pelanggan</div>
                            <div class="rgs-text-rincian col-9"><?= $try['data']['customer_name'] ?></div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="item">
                        <div class="in">
                            <div class="text-muted">Pembayaran</div>
                            <div class="rgs-text-rincian col-9"><?= $row['name'] ?></div>
                        </div>
                    </div>
                </li>
            </ul>
            
        <div class="listview-title mt-1">Detail Pembayaran</div>
            <ul class="listview rgs-listview-custom image-listview">
                <li>
                    <div class="item">
                        <div class="in">
                            <div class="text-muted">Tagihan</div>
                            <div class="rgs-text-rincian"><?= 'Rp '.currency($try['data']['price']) ?></div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="item">
                        <div class="in">
                            <div class="text-muted">Biaya Admin</div>
                            <div class="rgs-text-rincian"><?= 'Rp '.currency($admin) ?></div>
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
            
            <ul class="listview rgs-listview-custom image-listview">
                <li>
                    <div class="item">
                        <div class="in">
                            <div class="text-muted">Koin yang akan didapatkan</div>
                            <div class="rgs-text-rincian text-gold"><?= ''.currency($cashback) ?></div>
                        </div>
                    </div>
                </li>
            </ul>
            
            <form method="POST">
                <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
                <input type="hidden" id="web_token1" name="web_token1" value="<?= base64_encode($get_code) ?>">
                <input type="hidden" id="web_token2" name="web_token2" value="<?= base64_encode($get_data) ?>">
            <div class="form-button-group">
                <a href="#" data-toggle="modal" data-target="#TransaksiPIN" class="btn btn-primary btn-block btn-lg">Bayar Sekarang</a>
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
                                <button type="submit" class="btn rounded btn-primary btn-block btn-lg m-1 mb-0" name="buypostpaid" onclick="var e=this;setTimeout(function(){e.disabled=true;},0);return true;">Konfirmasi</button>
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