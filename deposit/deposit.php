<?php
require '../RGShenn.php';
require _DIR_('library/session/user');
$page = 'Isi Saldo';

$search = $call->query("SELECT * FROM deposit WHERE status = 'unpaid' AND user = '$sess_username'");
$rowDepo = $search->fetch_assoc();
if($search->num_rows == 1) redirect(1,base_url('deposit/invoice/'.$rowDepo['rid']));

if(isset($_POST['claim-voucher'])) {
    $post_klaim = $_POST['klaim'];
    $post_tid = strtoupper(random(7));
    $post_jumlah = '1';
    $data_voucher = $call->query("SELECT * FROM deposit_voucher WHERE code = '$post_klaim'")->fetch_assoc();
    $post_nominal = $data_voucher['nominal'];
    $stock = $data_voucher['stock'];
    
    if($result_csrf == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'System Error, please try again later.'];
    } else if($sess_username == 'demo') {
        $_SESSION['result'] = ['type' => false,'message' => 'Akun Demo Tidak Memiliki Izin Untuk Mengakses Fitur Ini.'];
    } else if(!$post_klaim) {
        $_SESSION['result'] = ['type' => false,'message' => 'Masukkan Voucher Terlebih Dahulu!.'];
    } else if($stock < $post_jumlah) {
        $_SESSION['result'] = ['type' => false,'message' => 'Mohon maaf stock voucher habis!.'];
    } else {
        if($call->query("INSERT INTO deposit (rid, user, method, note, sender, quantity, amount, status, date_cr, date_up) VALUES ('$post_tid', '$sess_username', 'voucher', 'Klaim Voucher SeruPay', 'unknown', '$post_nominal', '$post_nominal', 'paid', '$date $time', '$date $time')") == true) {
            $call->query("UPDATE deposit_voucher SET stock = stock-$post_jumlah, user = '$sess_username' WHERE code = '$post_klaim'");
            $call->query("UPDATE users SET balance = balance+$post_nominal WHERE username = '$sess_username'");
            $_SESSION['result'] = ['type' => true,'message' => 'Sukses Voucher telah diklaim.'];
            unset($_SESSION['csrf']);
        } else {
            $_SESSION['result'] = ['type' => false,'message' => 'Our server is in trouble, please try again later.'];
        }
    }
}

require _DIR_('library/header/user');
?>

    <!-- App Capsule -->
    <div id="appCapsule" class="rgs-deposit extra-header-active">
        <div class="tab-content">
        <div class="tab-pane fade active show" id="topup" role="tabpanel">
        <form method="POST" action="pembayaran">
            <? require _DIR_('library/session/result-mobile') ?>
            <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>"> 
                <div class="section service">
             <div class="wide-block-service">
                <ul class="listview image-listview no-line no-space flush">
                    <li>
                        <div class="item">
                            <div class="in">
                                <div class="form-group basic">
                                    <div class="input-wrapper">
                                        <label class="label text-center">Isi Saldo Mulai Dari Rp 10.000</label>
                                        <input type="number" class="form-control" placeholder="10.000" name="nominal" required>
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
        <div class="m-2">
            <h4 class="text-center mt-2">Pilih Nominal Cepat</h4>
            <div class="row text-center">
                <div class="col-4 mb-2">
                    <a href="javascript:;" onclick="depositNominal('10000')">
                        <div class="card">
                            <div class="card-body">
                                <h6>Rp 10.000</h6>
                            </div>
                        </div>
                    </a>    
                </div>
                <div class="col-4 mb-2">
                    <a href="javascript:;" onclick="depositNominal('25000')">
                        <div class="card">
                            <div class="card-body">
                                <h6>Rp 25.000</h6>
                            </div>
                        </div>
                    </a>    
                </div>
                <div class="col-4 mb-2">
                    <a href="javascript:;" onclick="depositNominal('50000')">
                        <div class="card">
                            <div class="card-body">
                                <h6>Rp 50.000</h6>
                            </div>
                        </div>
                    </a>    
                </div>
                <div class="col-4 mb-2">
                    <a href="javascript:;" onclick="depositNominal('100000')">
                        <div class="card">
                            <div class="card-body">
                                <h6>Rp 100.000</h6>
                            </div>
                        </div>
                    </a>    
                </div>
                <div class="col-4 mb-2">
                    <a href="javascript:;" onclick="depositNominal('250000')">
                        <div class="card">
                            <div class="card-body">
                                <h6>Rp 250.000</h6>
                            </div>
                        </div>
                    </a>    
                </div>
                <div class="col-4 mb-2">
                    <a href="javascript:;" onclick="depositNominal('500000')">
                        <div class="card">
                            <div class="card-body">
                                <h6>Rp 500.000</h6>
                            </div>
                        </div>
                    </a>    
                </div>
            </div>
        </div>
            <div class="form-button-group">
                <button type="submit" class="btn btn-primary btn-block btn-lg">Lanjutkan</a>
            </div>
        </form>
        </div>
        <div class="tab-pane fade" id="voucher" role="tabpanel">
            <ul class="listview image-listview"> 
        <form method="POST">
            <? require _DIR_('library/session/result-mobile') ?>
            <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
            <div class="section service">
             <div class="wide-block-service">
                <ul class="listview image-listview no-line no-space flush">
                    <li>
                        <div class="item">
                            <div class="in">
                                <div class="form-group basic">
                                    <div class="input-wrapper">
                                        <label class="label">Klaim Voucher Anda</label>
                                        <input type="text" class="form-control" placeholder="" name="klaim" required>
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

            <div class="form-button-group">
                <button type="submit" name="claim-voucher" class="btn btn-primary btn-block btn-lg">Lanjutkan</a>
            </div>
        </form>
        </ul>
        </div> 
        </div>
      </div>
    </div>
    <!-- * App Capsule -->

<?php require _DIR_('library/footer/user') ?>