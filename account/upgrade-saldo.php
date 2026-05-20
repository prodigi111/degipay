<?php
require '../RGShenn.php';
require _DIR_('library/session/user');

if(in_array($data_user['level'],['Premium','Admin'])) {
    $_SESSION['result'] = ['type' => false,'message' => 'Kamu Sudah Level Premium!'];
    redirect(0, base_url());
}

$harga = conf('referral', 4);
if(isset($_POST['upgrade'])) {
    $post_ip = client_ip();
    
    if($result_csrf == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'System Error, please try again later.'];
    } else if($sess_username == 'demo') {
        $_SESSION['result'] = ['type' => false,'message' => 'Akun Demo Tidak Memiliki Izin Untuk Mengakses Fitur Ini.'];
    } else if(in_array($data_user['level'],['Premium','Admin'])) {
        $_SESSION['result'] = ['type' => false,'message' => 'Kamu Sudah Level Premium!'];
    } else if($data_user['balance'] < $harga) {
        $_SESSION['result'] = ['type' => false,'message' => 'Saldo Anda Tidak Mencukupi Untuk Upgrade Level.'];
    } else {
        
        if($call->query("UPDATE users SET balance = balance-$harga WHERE username = '$sess_username'") == true) {
            $call->query("INSERT INTO mutation VALUES ('', '$sess_username', '-', '$harga', 'Upgrade Ke Level Premium', '$date', '$time', 'Lainnya')");
            
            $call->query("UPDATE users SET level = 'Premium' WHERE username = '$sess_username'");
            $call->query("INSERT INTO logs VALUES ('','$sess_username','upgrade','$post_ip','$datetime')");

            $reff = $call->query("SELECT * FROM users WHERE username = '$sess_username'")->fetch_assoc()['uplink'];
            $komisi = conf('referral', 2);
            $note = "@{$sess_username} - Level Premium";
            if($call->query("SELECT * FROM users WHERE username = '$reff' AND level IN ('Premium', 'Admin')")->num_rows == 1) {
                $call->query("UPDATE users SET komisi = komisi+$komisi WHERE username = '$reff'");
                $call->query("INSERT INTO mutation VALUES ('', '$reff', '+', '$komisi', '$note', '$date', '$time', 'Komisi Upgrade')");
            }
            
            $_SESSION['success'] = ['type' => true, 'message' => 'Selamat Ya, Kamu Saat Ini Sudah Menjadi Agen Premium'];
        } else {
            $_SESSION['result'] = ['type' => false,'message' => 'Our server is in trouble, please try again later.'];
        }
    }
}

function Li($x) {
    $out = '';
    $no = 1; 
    $i = 0;
    foreach($x as $key => $value) {
        $out .= '<li>
                    <div class="item">
                        <div class="icon-box bg-warning">
                            0'.$no.'
                        </div>
                        <div class="in">
                            <div class="rgs-text-custom">'.$value.'</div>
                        </div>
                    </div>
                </li>';
        $i++; $no++;
    } 
    return $out;
}

$page = isset($_SESSION['success']) ? 'Pembayaran Berhasil' : 'Upgrade Level';
require _DIR_('library/header/user');
?>
<? if(isset($_SESSION['success'])) :  ?>

    <!-- App Capsule -->
    <div id="appCapsule" class="rgs-pending-deposit mt-5">
        <div class="section">

            <div class="text-center">
                <button type="button" class="btn btn-icon btn-lg">
                    <ion-icon name="checkmark-done-outline"></ion-icon>
                </button>
                <h3 class="text-light">Upgrade Berhasil</h3>
                <small><?= $_SESSION['success']['message'] ?></small>
            </div>

            <div class="form-button-group bg-primary text-center">
                <a href="<?= base_url() ?>" class="btn rounded shadowed btn-block btn-lg">Selesai</a>
            </div>

        </div>
    </div>
    <!-- * App Capsule -->
<? unset($_SESSION['success']); else: ?>
    <!-- App Capsule -->
    <div id="appCapsule" class="mt-5">
        <div class="section">
            <? require _DIR_('library/session/result-mobile') ?>
            <ul class="listview rgs-listview-custom image-listview mt-1 mb-5">
                <?= 
                    Li([
                        'Biaya Upgrade Langsung Dipotong Saldo',
                        'Akses Semua Fitur Layanan Premium',
                        'Mendapatkan Harga Layanan Lebih Murah',
                        'Bebas Biaya Transaksi',
                        'Mendapatkan '.currency(conf('referral', 3)).' Poin Dari Setiap Transaksi Sukses',
                        'Mendapatkan Komisi Dari Referral Rp'.currency(conf('referral', 1)).' Per Trx Sukses Member Referral',
                        'Mendapatkan Komisi Dari Referral Rp'.currency(conf('referral', 2)).' Per Member Referral Upgrade Ke Premium',
                    ])
                ?>
                <div class="rgs-info-upgrade">
                    <h4>Biaya Upgrade Hanya</h4>
                    <h2 class="text-danger">Rp <?= currency($harga) ?></h2>
                </div>
                
            </ul>

            <div class="form-button-group bg-primary text-center">
                <button type="button" data-toggle="modal" data-target="#DialogKonfirmasi" class="btn bg-warning rounded shadowed btn-block btn-lg mt-2 mb-2">UPGRADE SEKARANG</button>
            </div>
        
        </div>
    </div>
    <!-- * App Capsule -->

    <!-- Dialog Konfirmasi -->
    <div class="modal fade dialogbox" id="DialogKonfirmasi" data-backdrop="static" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Upgrade Premium</h5>
                </div>
                <div class="modal-body">
                    Saldo Akan Dipotong Sebesar Rp <?= currency($harga) ?>
                </div>
                <div class="modal-footer">
                    <form method="POST">
                        <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
                        <div class="btn-inline">
                            <a href="#" class="btn btn-text-secondary" data-dismiss="modal">CLOSE</a>
                            <button type="submit" class="btn btn-text-primary" name="upgrade" onclick="var e=this;setTimeout(function(){e.disabled=true;},0);return true;">OK</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- * Dialog Konfirmasi -->
<? endif ?>   
<?php require _DIR_('library/footer/user') ?>