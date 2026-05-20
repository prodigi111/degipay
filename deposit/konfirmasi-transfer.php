<?php
require '../RGShenn.php';
require _DIR_('library/session/premium');

$_POSTNominal = isset($_POST['nominal']) ? filter($_POST['nominal']) : '';
$_POSTUser = isset($_POST['card']) ? filter($_POST['card']) : '';

if(!$_POSTNominal || !$_POSTUser) {
    $_SESSION['result'] = ['type' => false, 'message' => 'Masukkan Nominal atau Card Member Terlebih Dahulu!.'];
    redirect(0, base_url('deposit/transfer'));
} else {
    
    if(!$_POSTNominal || !$_POSTUser) {
        $_SESSION['result'] = ['type' => false, 'message' => 'Masukkan Nominal Atau Nomor Tujuan Terlebih Dahulu!.'];
        redirect(0, base_url('deposit/transfer'));
    } else if($_CONFIG['mt']['web'] == 'true') {
        $_SESSION['result'] = ['type' => false,'message' => 'Aplikasi Sedang Dalam Perbaikan.'];
        redirect(0, base_url('deposit/transfer'));
    } else if($sess_username == 'demo') {
        $_SESSION['result'] = ['type' => false,'message' => 'Akun Demo Tidak Memiliki Izin Untuk Mengakses Fitur Ini.'];
        redirect(0, base_url('deposit/transfer'));
    } else if(!in_array($data_user['level'], ['Premium','Admin'])) {
        $_SESSION['result'] = ['type' => false,'message' => 'Anda Tidak Memiliki Izin Untuk Mengakses Fitur Ini.'];
        redirect(0, base_url('deposit/transfer'));
    } else if($_POSTNominal < 10000) {
        $_SESSION['result'] = ['type' => false,'message' => 'Minimal Kirim Saldo Adalah Rp '.currency(10000).'.'];
        redirect(0, base_url('deposit/transfer'));
    } else if($_POSTUser == $data_user['card']) {
        $_SESSION['result'] = ['type' => false,'message' => 'Anda Tidak Dapat Kirim Saldo Ke Akun Anda Sendiri.'];
        redirect(0, base_url('deposit/transfer'));
    } else if($call->query("SELECT * FROM users WHERE card = '$_POSTUser'")->num_rows == 0) {
        $_SESSION['result'] = ['type' => false,'message' => 'Card Member tidak ditemukan.'];
        redirect(0, base_url('deposit/transfer'));
    } else if($data_user['balance'] < $_POSTNominal) {
        $_SESSION['result'] = ['type' => false,'message' => 'Saldo Anda Tidak Mencukupi Untuk Kirim Saldo.'];
        redirect(0, base_url('deposit/transfer'));
    } 
    
    if(isset($_POST['transfer'])) {
        $post_ip = client_ip();
        $post_rid = strtoupper(random(9));
        $post_card = filter($_POST['card']);
        $searcUser = $call->query("SELECT * FROM users WHERE card = '$post_card'")->fetch_assoc();
        $post_user = $searcUser['username'];
        $post_amnt = filter($_POST['nominal']);
        $postPin = filter($_POST['pin']);
        
        if($result_csrf == false) {
            $_SESSION['result'] = ['type' => false,'message' => 'System Error, please try again later.'];
            redirect(0, base_url('deposit/transfer'));
        } else if(!$postPin) {
            $_SESSION['result'] = ['type' => false,'message' => 'Masukkan Pin Keamanan Telebih Dahulu!.'];
        } else if($_CONFIG['mt']['web'] == 'true') {
            $_SESSION['result'] = ['type' => false,'message' => 'Aplikasi Sedang Dalam Perbaikan.'];
            redirect(0, base_url('deposit/transfer'));
        } else if($sess_username == 'demo') {
            $_SESSION['result'] = ['type' => false,'message' => 'Akun Demo Tidak Memiliki Izin Untuk Mengakses Fitur Ini.'];
            redirect(0, base_url('deposit/transfer'));
        } else if(!in_array($data_user['level'],['Premium','Admin'])) {
            $_SESSION['result'] = ['type' => false,'message' => 'Anda Tidak Memiliki Izin Untuk Mengakses Fitur Ini.'];
            redirect(0, base_url('deposit/transfer'));
        } else if($post_card == $data_user['card']) {
            $_SESSION['result'] = ['type' => false,'message' => 'Anda Tidak Dapat Kirim Saldo Ke Akun Anda Sendiri.'];
            redirect(0, base_url('deposit/transfer'));
        } else if($post_amnt < 10000) {
            $_SESSION['result'] = ['type' => false,'message' => 'Minimal Kirim Saldo Rp '.currency(10000).'.'];
            redirect(0, base_url('deposit/transfer'));
        } else if($data_user['balance'] < $post_amnt) {
            $_SESSION['result'] = ['type' => false,'message' => 'Saldo Anda Tidak Mencukupi Untuk Kirim Saldo.'];
            redirect(0, base_url('deposit/transfer'));
        } else {
            $post_note_snd = "Transfer Ke ".$call->query("SELECT * FROM users WHERE card = '$_POSTUser'")->fetch_assoc()['name']."";
            $post_note_rcv = "Transfer Dari {$data_user['name']}";
            $in = $call->query("INSERT INTO deposit VALUES ('', '$post_rid', '$post_user', 'transfer', '-', '$sess_username', '$post_amnt', '$post_amnt', 'paid', '$datetime', '$datetime')");
            if(check_bcrypt($postPin, $data_user['pin']) == true) {
            if($in == true) {
                $call->query("UPDATE users SET balance = balance-$post_amnt WHERE username = '$sess_username'");
                $call->query("INSERT INTO mutation VALUES ('','$sess_username','-','$post_amnt','$post_note_snd', '$date', '$time', 'Deposit')");
                
                $call->query("UPDATE users SET balance = balance+$post_amnt WHERE username = '$post_user'");
                $call->query("INSERT INTO logs VALUES ('','$post_user','transfer','$post_ip','$datetime')");
                $call->query("INSERT INTO mutation VALUES ('','$post_user','+','$post_amnt','$post_note_rcv', '$date', '$time', 'Deposit')");
                
                $WATL->sendMessage($data_user['phone'], "Hallo, *{$data_user['name']}* \n\n*ANDA MENGIRIM SALDO {$_CONFIG['title']}* \n\nID TRANSFER : *#{$post_rid}* \nTUJUAN : *{$post_note_snd}* \nSTATUS : *BERHASIL* \nNOMINAL : Rp *{$post_amnt}* \n----------------------------------------------\n*Terima kasih sudah memilih {$_CONFIG['title']}*");
                $fcm_token = $call->query("SELECT * FROM users_token WHERE user = '$sess_username'")->fetch_assoc()['token'];
                $notification = [
                    'title' => 'Transfer Berhasil',
                    'text' => 'Terima Kasih, '.$post_note_snd.' Sebesar Rp '.currency($post_amnt).' Berhasil!',
                    'click_action' =>  'Open_URI',
                ];
                
                $data = [
                    'picture' => '',
                    'uri' =>  base_url('page/riwayat'),
                ];
                $FCM->sendNotif($fcm_token, $notification, $data);
             /*   
                $WATL->sendMessage($post_nomor, 'Hallo '.$searcUser['name'].' Anda Mendapatkan Saldo Sebesar Rp '.currency($post_amnt).' Dari '.$data_user['name']);
                $fcm_token = $call->query("SELECT * FROM users_token WHERE user = '$post_user'")->fetch_assoc()['token'];
                $notification = [
                    'title' => 'Yeayy!!',
                    'text' => 'Anda Mendapatkan Saldo Sebesar Rp '.currency($post_amnt).' Dari '.$data_user['name'],
                    'click_action' =>  'Open_URI',
                ];
                
                $data = [
                    'picture' => '',
                    'uri' =>  base_url('page/riwayat'),
                ];
                $FCM->sendNotif($fcm_token, $notification, $data);
    */
                $_SESSION['success'] = ['type' => true,'message' => "Anda Berhasil Mengirim Saldo Rp ".currency($post_amnt)." ke ".$call->query("SELECT * FROM users WHERE card = '$_POSTUser'")->fetch_assoc()['name'].""];
                unset($_SESSION['csrf']);
            } else {
                $_SESSION['result'] = ['type' => false,'message' => 'Our server is in trouble, please try again later.'];
                redirect(0, base_url('deposit/transfer'));
            } 
            } else {
            $_SESSION['result'] = ['type' => false,'message' => 'Pin Keamanan Tidak Valid.'];
            }
        }
    }

$page = isset($_SESSION['success']) ? 'Pembayaran Berhasil' : 'Konfirmasi Transfer';
require _DIR_('library/header/user');
?>
<?php if(isset($_SESSION['success'])) :  ?>

    <!-- App Capsule -->
    <div id="appCapsule" class="rgs-pending-deposit mt-5">
        <div class="section">

            <div class="text-center">
                <button type="button" class="btn btn-icon btn-lg">
                    <ion-icon name="checkmark-done-outline"></ion-icon>
                    <audio src="<?= assets('images/jcz.mp3') ?>" autoplay></audio>
                </button>
                <h3 class="text-light">Transfer Berhasil</h3>
                <small><?= $_SESSION['success']['message'] ?></small>
                <hr class="bg-light">
                <small>TOTAL TRANSFER</small>
                <h3 class="text-light">Rp <?= currency($post_amnt) ?></h3>
            </div>

            <div class="form-button-group bg-primary text-center">
                <a href="<?= base_url() ?>" class="btn rounded shadowed btn-block btn-lg">Selesai</a>
            </div>

        </div>
    </div>
    <!-- * App Capsule -->

<?php unset($_SESSION['success']); else: ?>

    <!-- App Capsule -->
    
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

    <div id="appCapsule" class="rgs-konfirmasi">
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
        
        <? require _DIR_('library/session/result-mobile') ?>
        
            <ul class="listview rgs-listview-custom image-listview">
                <li>
                    <div class="item">
                        <div class="in">
                            <div class="text-muted">Card Number</div>
                            <div class="rgs-text-rincian col-8"><?= $_POSTUser ?></div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="item">
                        <div class="in">
                            <div class="text-muted">Nama</div>
                            <div class="rgs-text-rincian col-8"><?= $call->query("SELECT * FROM users WHERE card = '$_POSTUser'")->fetch_assoc()['name'] ?></div>
                        </div>
                    </div>
                </li>
            </ul>
            
        <div class="listview-title mt-1">Detail Transaksi</div>
            <ul class="listview rgs-listview-custom image-listview">
                <li>
                    <div class="item">
                        <div class="in">
                            <div class="text-muted">Nominal</div>
                            <div class="rgs-text-rincian">Rp <?= currency($_POSTNominal) ?></div>
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
                            <div class="rgs-text-rincian"><b>Rp <?= currency($_POSTNominal) ?></b></div>
                        </div>
                    </div>
                </li>
            </ul>
            <form method="POST">
                <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
                <input type="hidden" name="card" value="<?= $_POSTUser ?>">
                <input type="hidden" name="nominal" value="<?= $_POSTNominal ?>">
        <div class="form-button-group">
            <a href="#" data-toggle="modal" data-target="#TransaksiPIN" class="btn btn-primary btn-block btn-lg">Lanjut</a>
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
                                <a href="#" class="btn btn-list btn-block btn-lg text-primary m-1 mb-0" data-dismiss="modal" style="border:1px solid #5f33ba;">Batal</a>
                                <button type="submit" class="btn btn-primary btn-block btn-lg m-1 mb-0" name="transfer" onclick="var e=this;setTimeout(function(){e.disabled=true;},0);return true;">Konfirmasi</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- * App Capsule -->
<? endif; ?>    
<?php require _DIR_('library/footer/user'); } ?>