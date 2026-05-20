<?php
require '../RGShenn.php';
require _DIR_('library/session/user');
$page = 'Menunggu Pembayaran';

$search = $call->query("SELECT * FROM deposit WHERE status = 'unpaid' AND user = '$sess_username' ORDER BY id DESC LIMIT 1");
if($search->num_rows == 0) redirect(0, base_url('deposit/'));
$rows = $search->fetch_assoc();
$metode = $call->query("SELECT * FROM deposit_method WHERE code = '".$rows['method']."'")->fetch_assoc();
if(isset($_POST['confirm'])) {
    $post_rid = filter($_POST['confirm']);
    $post_ip = client_ip();
    $search = $call->query("SELECT * FROM deposit WHERE user = '$sess_username' AND rid = '$post_rid' AND status = 'unpaid'");
    if($search->num_rows == 1) {
        $srow = $search->fetch_assoc();
        if($srow['method'] == 'gopay') $try = json_decode(file_get_contents(base_url('payment/gopay-message')), true);
        else if($srow['method'] == 'bni') $try = json_decode(file_get_contents(base_url('payment/bni-message')), true);
        else if($srow['method'] == 'ovo') $try = json_decode(file_get_contents(base_url('payment/ovo-message')), true);
        else $try = ['result' => false,'message' => 'Metode Pembayaran Ini Di Cek Manual, Silahkan Hubungi CS.'];
        
        $cfrm_amount = $srow['amount'];
        $cfrm_bank = strtoupper($srow['method']);
    }
    
    if($result_csrf == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'System error, please try again later.'];
    } else if($sess_username == 'demo') {
        $_SESSION['result'] = ['type' => false,'message' => 'Akun Demo Tidak Memiliki Izin Untuk Mengakses Fitur Ini.'];
    } else if($search->num_rows == 0) {
        $_SESSION['result'] = ['type' => false,'message' => 'Tidak Ada Permintaan Deposit Yang Bisa Dikonfirmasi.'];
    } else if($try['result'] == false) {
        $_SESSION['result'] = ['type' => false,'message' => $try['message']];
    } else if($call->query("SELECT * FROM deposit_bank WHERE bank = '$cfrm_bank' AND amount = '$cfrm_amount' AND DATE(date) = '$date' AND status = 'unread'")->num_rows !== 1) {
        $_SESSION['result'] = ['type' => false,'message' => 'Dana Belum Kami Terima, Jika Ada Kendala Silahkan Hubungi Admin.'];
    } else {
        $up = $call->query("UPDATE deposit_bank SET user = '$sess_username', rid = '$post_rid', status = 'read' WHERE bank = '$cfrm_bank' AND amount = '$cfrm_amount' AND status = 'unread'");
        $data_bank = mysqli_fetch_assoc($up);
        if($up == true) {
            $call->query("UPDATE users SET balance = balance+$cfrm_amount WHERE username = '$sess_username'");
            $call->query("UPDATE deposit SET status = 'paid', date_up = '$date $time', sender = '".$data_bank['sender']."' WHERE user = '$sess_username' AND rid = '$post_rid' AND status = 'unpaid'");
            $call->query("INSERT INTO logs VALUES ('','$sess_username','topup','$post_ip','$date $time')");
            $call->query("INSERT INTO mutation VALUES ('','$sess_username','+','$cfrm_amount','Topup #$post_rid','$date', '$time', 'Deposit')");
            
            $WATL->sendMessage($data_user['phone'], 'Hallo, *'.$data_user['name'].'*\nID Deposit : *#'.$post_rid.'* \nStatus : *Deposit Berhasil* \nCatatan: *Saldo Anda Telah Kami Tambahkan Sebesar*\nTotal : Rp *'.currency($cfrm_amount).'* \n----------------------------------------------\n*Terima kasih sudah memilih '.$_CONFIG['title'].'*.'); 
            $fcm_token = $call->query("SELECT * FROM users_token WHERE user = '$sess_username'")->fetch_assoc()['token'];
            $notification = [
                'title' => 'Saldo Masuk Rp '.currency($cfrm_amount),
                'text' => 'Permintaan Isi Saldo Berhasil Diterima, Saldo Anda Telah Kami Tambahkan.',
                'click_action' =>  'Open_URI',
            ];
            
            $data = [
                'picture' => '',
                'uri' =>  base_url('deposit/invoice/'.$post_rid),
            ];
            $FCM->sendNotif($fcm_token, $notification, $data);
            
            $_SESSION['result'] = ['type' => true,'message' => 'Permintaan Isi Saldo Berhasil Diterima, Saldo Anda Telah Kami Tambahkan.'];
            redirect(0, base_url('deposit/invoice/'.$post_rid));
        } else {
            $_SESSION['result'] = ['type' => false,'message' => 'Our server is in trouble, please try again later.'];
        }
    }
}

require _DIR_('library/header/user');
?>

    <!-- App Capsule -->
    <div id="appCapsule" class="rgs-pending-deposit">
        <div class="section">
            
            <div class="text-center mb-2">
                <button type="button" class="btn btn-icon btn-lg">
                    <ion-icon name="checkmark-done-outline"></ion-icon>
                </button>
                <h4 class="text-light">Permintaan Deposit Berhasil Dibuat</h4>
                <small>Segera Lakukan Pembayaran Sesuai Data Yang Tertera!</small>
            </div>
            <? require _DIR_('library/session/result-mobile') ?>
            <div class="card rgs-info-deposit mt-2 mb-<?= (in_array($metode['type'], ['emoney', 'bank']) && $rows['method'] !== 'qrisc') ? '2' : '5' ?>">
                <div class="card-body">
                    <h6>Total Pembayaran</h6>
                    <div class="row"> 
                       <? if($metode['type'] === 'emoney') : ?>
                        <div class="col-9">
                            <h4>Rp <?= currency($rows['amount']) ?></h4>
                            <small>Nominal Transfer Harus Sama Persis</small>
                        </div>  
                        <div class="col-3 text-right text-primary">
                            <button type="button" class="btn btn-icon text-primary" onclick="copyToClipboard('<?= $rows['amount'] ?>')">
                                <ion-icon name="copy-outline"></ion-icon>
                            </button>
                        </div>
                        <? elseif($metode['type'] === 'bank') : ?> 
                        <div class="col-9">
                            <h4>Rp <?= currency($rows['amount']) ?></h4>
                            <small>Nominal Transfer Harus Sama Persis</small>
                        </div>  
                        <div class="col-3 text-right text-primary">
                            <button type="button" class="btn btn-icon text-primary" onclick="copyToClipboard('<?= $rows['amount'] ?>')">
                                <ion-icon name="copy-outline"></ion-icon>
                            </button>
                        </div>
                        <? else: ?>
                        <div class="col-9">
                            <h4>Rp <?= currency($rows['quantity']) ?></h4>
                            <small>Nominal Transfer Harus Sama Persis</small>
                        </div>  
                        <div class="col-3 text-right text-primary">
                            <button type="button" class="btn btn-icon text-primary" onclick="copyToClipboard('<?= $rows['quantity'] ?>')">
                                <ion-icon name="copy-outline"></ion-icon>
                            </button>
                        </div>
                        <? endif; ?>
                    </div> 
                    <hr>
                    <? if($rows['method'] == ['qris2','qris']) : ?>
                    <small>Pembayaran dengan satu QR Code yang dapat digunakan di berbagai dompet digital</small>
                    <center>
                        <img src="<?= $rows['note'] ?>" class="imaged" width="80%">
                    </center> 
                    <? elseif(in_array($rows['method'], ['alfamart', 'alfamidi','indomaret'])) : ?>
                    <h6>Kode Pembayaran</h6>
                    <div class="row">
                        <div class="col-9">
                            <h4><b><?= $rows['note'] ?></b></h4>
                            <small>Silahkan Salin Dan Ikuti Instruksi Dibawah</small>
                        </div>
                        <div class="col-3 text-right text-primary">
                            <button type="button" class="btn btn-icon text-primary" onclick="copyToClipboard('<?= $rows['note'] ?>')">
                                <ion-icon name="copy-outline"></ion-icon>
                            </button>
                        </div>
                    </div>
                    <hr>
                    <img src="<?= assets('mobile/img/deposit/'.$rows['method'].'.png') ?>" alt="image" class="imaged w36 rgs-deposit-image">
                    <div class="row mt-1">
                        <div class="col-12">
                            <ul class="text-dark" style="margin-left: -2rem">
                                <li>Silahkan Datang ke <?= ucfirst($rows['method']) ?></li>
                                <li>Sampaikan ke kasir ingin melakukan pembayaran Plasamall</li>
                                <li>Berikan kode bayar (<b><?= $rows['note'] ?></b>) ke kasir</li>
                                <li>Bayar sesuai jumlah yang diinfokan oleh kasir</li>
                                <li>Simpan struk bukti pembayaran Anda</li>
                            </ul>
                        </div>
                    </div>
                    <? else: ?>
                    <img src="<?= assets('mobile/img/deposit/'.str_replace('-va','',$rows['method']).'.png') ?>" alt="image" class="imaged w36 rgs-deposit-image">
                    <div class="row mt-1">
                        <div class="col-9">
                            <? if(stristr($rows['method'],'-va')) : ?>
                            <h4><?= $rows['note'] ?></h4>
                            <? else: ?>
                            <h4><?= explode(' A/n ', $rows['note'])[0] ?></h4>
                            <small>
                                <?= 'A/n '.explode(' A/n ',$rows['note'])[1] ?>
                            </small>
                            <? endif; ?>
                        </div>
                        <div class="col-3 text-right">
                            <button type="button" class="btn btn-icon text-primary" onclick="copyToClipboard('<?= explode(' A/n ', $rows['note'])[0] ?>')">
                                <ion-icon name="copy-outline"></ion-icon>
                            </button>
                        </div>
                    </div>
                    <? endif ?>
                </div>
            </div>
            <? if((in_array($metode['type'], ['emoney', 'bank']) && $rows['method'] !== 'qrisc')) : ?>
            <div class="text-center">
                <a href="#" class="text-white" data-toggle="modal" data-target="#DialogKonfirmasiPembayaran"><u>Konfirmasi Pembayaran</u></a>
            </div>
            <? endif ?>

            <div class="form-button-group bg-primary">
                <a href="<?= base_url('index.php') ?>" class="btn rounded shadowed btn-block btn-lg">Selesai</a>
            </div>

        </div>
    </div>
    <!-- * App Capsule -->
    
    <!-- Dialog Konfirmasi Pembayaran -->
    <div class="modal fade dialogbox" id="DialogKonfirmasiPembayaran" data-backdrop="static" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Sudah Transfer?</h5>
                </div>
                <div class="modal-body">
                    Jika Sudah Transfer Sesuai Nominal Yang Disebutkan Silahkan Klik <b>OK</b>, Dan Tunggu Hingga Proses Selesai.
                </div>
                <div class="modal-footer">
                    <form method="POST">
                        <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
                        <div class="btn-inline">
                            <a href="#" class="btn btn-text-secondary" data-dismiss="modal">CLOSE</a>
                            <button type="submit" class="btn btn-text-primary" name="confirm" value="<?= $rows['rid'] ?>" onclick="var e=this;setTimeout(function(){e.disabled=true;},0);return true;">OK</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- * Dialog Konfirmasi Pembayaran -->
    
<?php require _DIR_('library/footer/user') ?>