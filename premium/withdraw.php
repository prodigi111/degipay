<?php
require '../RGShenn.php';
require _DIR_('library/session/premium');

$_POSTNominal = filter($_POST['nominal']);

if(!isset($_POSTNominal)) {
    redirect(0, base_url('premium/tarik-komisi'));
} else {
    
    if(!$_POSTNominal) {
        $_SESSION['result'] = ['type' => false, 'message' => 'Masukkan Nominal Terlebih Dahulu!.'];
        redirect(0, base_url('premium/tarik-komisi'));
    } else if($sess_username == 'demo') {
        $_SESSION['result'] = ['type' => false,'message' => 'Akun Demo Tidak Memiliki Izin Untuk Mengakses Fitur Ini.'];
        redirect(0, base_url('premium/tarik-komisi'));
    } else if($_POSTNominal < 10000) {
        $_SESSION['result'] = ['type' => false,'message' => 'Minimal Cairkan Komisi Adalah Rp '.currency(10000).'.'];
        redirect(0, base_url('premium/tarik-komisi'));
    } else if($data_user['komisi'] < $_POSTNominal) {
        $_SESSION['result'] = ['type' => false,'message' => 'Saldo Komisi Anda Tidak Mencukupi Untuk Dicairkan.'];
        redirect(0, base_url('premium/tarik-komisi'));
    } 
    
    if(isset($_POST['withdraw'])) {
        $post_ip = client_ip();
        $post_rid = strtoupper(random(9));
        $post_amnt = filter($_POST['nominal']);
        
        if($result_csrf == false) {
            $_SESSION['result'] = ['type' => false,'message' => 'System Error, please try again later.'];
            redirect(0, base_url('premium/tarik-komisi'));
        } else if($sess_username == 'demo') {
            $_SESSION['result'] = ['type' => false,'message' => 'Akun Demo Tidak Memiliki Izin Untuk Mengakses Fitur Ini.'];
            redirect(0, base_url('premium/tarik-komisi'));
        } else if(!$post_amnt) {
            $_SESSION['result'] = ['type' => false,'message' => 'System Error Silahkan Hubungi Admin (003)'];
            redirect(0, base_url('premium/tarik-komisi'));
        } else if($_POSTNominal < 10000) {
            $_SESSION['result'] = ['type' => false,'message' => 'Minimal Cairkan Komisi Adalah Rp '.currency(10000).'.'];
            redirect(0, base_url('premium/tarik-komisi'));
        } else if($data_user['komisi'] < $_POSTNominal) {
            $_SESSION['result'] = ['type' => false,'message' => 'Saldo Komisi Anda Tidak Mencukupi Untuk Dicairkan.'];
            redirect(0, base_url('premium/tarik-komisi'));
        }  else {
            
            $in = $call->query("INSERT INTO mutation VALUES ('', '$sess_username', '+', '$post_amnt', 'Penarikan Komisi Berhasil', '$date', '$time', 'Tarik Komisi')");
            if($in == true) {
                $call->query("UPDATE users SET komisi = komisi-$post_amnt WHERE username = '$sess_username'");
                $call->query("UPDATE users SET balance = balance+$post_amnt WHERE username = '$sess_username'");
                $call->query("INSERT INTO logs VALUES ('','$sess_username','withdraw komisi','$post_ip','$datetime')");
    
                $_SESSION['success'] = ['type' => true,'message' => "Anda Berhasil Tarik Komisi Sebesar Rp ".currency($post_amnt).""];
                unset($_SESSION['csrf']);
            } else {
                $_SESSION['result'] = ['type' => false,'message' => 'Our server is in trouble, please try again later.'];
                redirect(0, base_url('premium/tarik-komisi'));
            }
        }
    }

$page = isset($_SESSION['success']) ? 'Pembayaran Berhasil' : 'Konfirmasi Penarikan';
require _DIR_('library/header/user');
?>
<?php if(isset($_SESSION['success'])) :  ?>

    <!-- App Capsule -->
    <div id="appCapsule" class="rgs-pending-deposit mt-5">
        <div class="section">

            <div class="text-center">
                <button type="button" class="btn btn-icon btn-lg">
                    <ion-icon name="checkmark-done-outline"></ion-icon>
                </button>
                <h3 class="text-light">Tarik Komisi Berhasil</h3>
                <small><?= $_SESSION['success']['message'] ?></small>
                <hr class="bg-light">
                <small>TOTAL SALDO YANG DIDAPATKAN</small>
                <h3 class="text-light">Rp <?= currency($post_amnt) ?></h3>
            </div>

            <div class="form-button-group bg-primary text-center">
                <a href="<?= base_url('premium/') ?>" class="btn rounded shadowed btn-block btn-lg">Selesai</a>
            </div>

        </div>
    </div>
    <!-- * App Capsule -->

<?php unset($_SESSION['success']); else: ?>

    <!-- App Capsule -->
    <div id="appCapsule" class="rgs-konfirmasi">
        <div class="section d-invoice">
            <div class="card">
                <div class="card-body">
                    <ul class="listview image-listview no-line no-space flush mb-1">
                        <li>
                            <div class="item">
                                <img src="<?= assets('mobile/img/home/withdraw-komisi-blue.svg') ?>" width="23px" class="mr-2" id="RGSLogo">
                                <div class="in">
                                    <div>
                                        <span>Tarik Komisi</span>
                                        <footer><?= $data_user['name'] ?></footer>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                    
                    <div class="more-info accordion pt-1" id="expandinfo">
                        <div class="accordion-header">
                            <button class="btn p-0 text-white" type="button" data-toggle="collapse" data-target="#show1" aria-expanded="false">
                                INFORMASI TAGIHAN
                            </button>
                        </div>
                        <div id="show1" class="accordion-body collapse show" data-parent="#expandinfo">
                            <div class="accordion-content">
                                <div class="trans-id">
                                    <div class="text-muted">Nominal Komisi</div>
                                    <div class="rgs-text-rincian">Rp <?= currency($_POSTNominal) ?></div>
                                </div>
                                <div class="trans-id">
                                    <div class="text-muted">Biaya Transaksi</div>
                                    <div class="rgs-text-rincian text-warning">GRATIS</div>
                                </div>
                                <hr>
                                <div class="trans-id">
                                    <div><b>Total Saldo Didapatkan</b></div>
                                    <div><b>Rp <?= currency($_POSTNominal) ?></b></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-1">
                            <ion-icon name="shield-checkmark-outline"></ion-icon>
                        </div>
                        <div class="col-11">
                            Transaksi Mudah, Cepat & Aman. Dengan Melanjutkan Proses Ini, Kamu Sudah Menyetujui <a href="#">Syarat Dan Ketentuan</a>
                        </div>
                    </div>
                    <form method="POST">
                        <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
                        <input type="hidden" name="nominal" value="<?= $_POSTNominal ?>">
                        <button type="submit" class="btn btn-primary btn-block mt-1 mb-1" name="withdraw" onclick="var e=this;setTimeout(function(){e.disabled=true;},0);return true;">Cairkan Sekarang</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- * App Capsule -->
<? endif; ?>    
<?php require _DIR_('library/footer/user'); } ?>