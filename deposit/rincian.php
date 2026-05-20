<?php
require '../RGShenn.php';
require _DIR_('library/session/user');
$page = 'Rincian Transaksi';

if(isset($_GET['code'])) {
    $post_kode = filter($_GET['code']);
    $search = $call->query("SELECT * FROM deposit WHERE rid = '$post_kode' AND user = '$sess_username'");
    if($search->num_rows == 0) redirect(1,base_url('page/riwayat'));
    $rows = $search->fetch_assoc();
    
    if($rows['status'] == 'cancel') :
        $class= '';
        $icon = 'close-circle-outline';
        $status = 'Permintaan Deposit Dibatalkan';
    elseif($rows['status'] == 'paid'):
        $class= '';
        $icon = 'checkmark-done-outline';
        $status = 'Pembayaran Berhasil Diterima';
    else:
        $class= 'rgs-r90';
        $icon = 'hourglass-outline';
        $status = 'Menunggu Pembayaran';
    endif;
    
} else {
    redirect(0, base_url('page/riwayat'));
}

if(isset($_POST['cancel'])) {
    $post_rid = filter($_POST['cancel']);
    $search = $call->query("SELECT * FROM deposit WHERE user = '$sess_username' AND rid = '$post_rid' AND status = 'unpaid'");
    $srow = $search->fetch_assoc();
    
    if($result_csrf == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'System error, please try again later.'];
    } else if($sess_username == 'demo') {
        $_SESSION['result'] = ['type' => false,'message' => 'Akun Demo Tidak Memiliki Izin Untuk Mengakses Fitur Ini.'];
    } else if($call->query("SELECT * FROM deposit WHERE user = '$sess_username' AND rid = '$post_rid' AND status = 'unpaid'")->num_rows == 0) {
        $_SESSION['result'] = ['type' => false,'message' => 'Tidak Ada Permintaan Deposit Yang Bisa Dibatalkan.'];
    } else {
        if($call->query("UPDATE deposit SET status = 'cancel', date_up = '$date $time' WHERE user = '$sess_username' AND rid = '$post_rid' AND status = 'unpaid'") == true) {

            $WATL->sendMessage($data_user['phone'], 'Hallo '.$data_user['name'].' Permintaan Isi Saldo Dengan Menggunakan Metode Deposit '.strtoupper($srow['method']).' Dibatalkan.');
            $fcm_token = $call->query("SELECT * FROM users_token WHERE user = '$sess_username'")->fetch_assoc()['token'];
            $notification = [
                'title' => 'Deposit '.strtoupper($srow['method']),
                'text' => 'Permintaan Isi Saldo Berhasil Dibatalkan',
                'click_action' =>  'Open_URI',
            ];
            
            $data = [
                'picture' => '',
                'uri' =>  base_url('deposit/invoice/').$post_rid,
            ];
            $FCM->sendNotif($fcm_token, $notification, $data);
            
            redirect(0, base_url('deposit/invoice/'.$post_rid));
        } else {
            $_SESSION['result'] = ['type' => false,'message' => 'Our server is in trouble, please try again later.'];
        }
    }
}

require _DIR_('library/header/user');
?>

    <!-- App Capsule -->
    <div id="appCapsule" class="rgs-konfirmasi">
        <div class="section rgs-rincian-deposit">

            <div class="text-center">
                <button type="button" class="btn btn-icon btn-lg">
                    <ion-icon name="<?= $icon ?>" class="<?= $class ?>"></ion-icon>
                </button>
                <h4 class="text-white"><?= $status ?></h4>
            </div>
            <? require _DIR_('library/session/result-mobile') ?>
            <div class="card mt-2">
                <div class="card-body">
                    <ul class="listview image-listview no-line no-space flush mb-1">
                        <li>
                            <div class="item">
                                <img src="<?= assets('mobile/img/home/deposit-rounded.png') ?>" width="36px" class="image" id="RGSLogo">
                                <div class="in">
                                    <div>
                                        <span>Deposit</span>
                                        <footer>Isi Saldo Rp <?= currency($rows['amount']) ?></footer>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                    
                    <div class="more-info accordion pt-1" id="expandPembayaran">
                        <div class="accordion-header">
                            <button class="btn p-0 text-white" type="button" data-toggle="collapse" data-target="#show" aria-expanded="false">
                                INFORMASI TRANSAKSI
                            </button>
                        </div>
                        <div id="show" class="accordion-body collapse show" data-parent="#expandPembayaran">
                            <div class="accordion-content">
                                <div class="trans-id">
                                    <div class="text-muted">ID Transaksi</div>
                                    <div class="rgs-text-rincian"><?= $rows['rid']; ?></div>
                                </div>
                                <div class="trans-id">
                                    <div class="text-muted">Tanggal Transaksi</div>
                                    <div class="rgs-text-rincian"><?= explode(' - ',format_date('id',$rows['date_cr']))[0]; ?></div>
                                </div>
                                <div class="trans-id">
                                    <div class="text-muted">Waktu Transaksi</div>
                                    <div class="rgs-text-rincian"><?= explode(' - ',format_date('id',$rows['date_cr']))[1]; ?></div>
                                </div>
                                <div class="trans-id">
                                    <div class="text-muted">Status Transaksi</div>
                                    <div class="rgs-text-rincian text-warning"><?= ucwords($rows['status']) ?></div>
                                </div>
                                <div class="trans-id">
                                    <div class="text-muted">Metode Pembayaran</div>
                                    <div class="rgs-text-rincian"><?= $call->query("SELECT * FROM deposit_method WHERE code = '".$rows['method']."'")->fetch_assoc()['name'] ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="more-info accordion pt-2" id="expandinfo">
                        <div class="accordion-header">
                            <button class="btn p-0 text-white" type="button" data-toggle="collapse" data-target="#show1" aria-expanded="false">
                                INFORMASI TAGIHAN
                            </button>
                        </div>
                        <div id="show1" class="accordion-body collapse show" data-parent="#expandinfo">
                            <div class="accordion-content">
                                <div class="trans-id">
                                    <div class="text-muted">Nominal Deposit</div>
                                    <div class="rgs-text-rincian">Rp <?= currency($rows['amount']) ?></div>
                                </div>
                                <div class="trans-id">
                                    <div class="text-muted">Biaya Transaksi</div>
                                    <div class="rgs-text-rincian text-warning"> Rp <?= (currency($rows['quantity'] == 0) ? 'GRATIS' : currency($rows['quantity']-$rows['amount']) == 0) ? 'GRATIS' : ($rows['quantity']-$rows['amount']) ?></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="trans-id rgs-bg-rincian text-dark mt-2">
                        <div>Total Pembayaran</div>
                        <div><?= (currency($rows['quantity']) == 0) ? currency($rows[amount]) : currency($rows['quantity']) ?></div>
                    </div>
                    
                </div>
            </div>

            <div class="form-button rgs-detail-transfer bg-primary text-center">
                <div class="row">
                    <? if($rows['status'] == 'unpaid') : ?>
                    <div class="col-6">
                        <a href="#" class="text-white" data-toggle="modal" data-target="#DialogKonfirmasiPembatalan">
                            <ion-icon name="close-circle-outline"></ion-icon>
                            <span>Ajukan Pembatalan</span>
                        </a>
                    </div>
                    <? endif ?>
                    <div class="<?= $rows['status'] == 'unpaid' ? 'col-6' : 'col-12' ?>">
                        <a href="<?= base_url('page/contact') ?>" class="text-white">
                            <ion-icon name="headset-outline"></ion-icon>
                            <span>Hubungi CS</span>
                        </a>
                    </div>
                </div>
                <? if($rows['status'] == 'unpaid') : ?>
                <a href="<?= base_url('deposit/konfirmasi') ?>" class="btn rounded shadowed btn-block btn-lg mt-3 mb-2 text-primary" style="background: #f7fbfc;">Lihat Rincian Pembayaran</a>
                <? endif ?>
                <a href="<?= base_url() ?>" class="btn rounded shadowed btn-block btn-lg mt-3 mb-2 text-primary" style="background: #f7fbfc;">Selesai</a>
            </div>

        </div>
    </div>
    <!-- * App Capsule -->

    <!-- Dialog Konfirmasi Pembatalan -->
    <div class="modal fade dialogbox" id="DialogKonfirmasiPembatalan" data-backdrop="static" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Anda Yakin?</h5>
                </div>
                <div class="modal-body">
                    Status Deposit Saldo Akan Dibatalkan
                </div>
                <div class="modal-footer">
                    <form method="POST">
                        <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
                        <div class="btn-inline">
                            <a href="#" class="btn btn-text-secondary" data-dismiss="modal">CLOSE</a>
                            <button type="submit" class="btn btn-text-primary" name="cancel" value="<?= $rows['rid'] ?>" onclick="var e=this;setTimeout(function(){e.disabled=true;},0);return true;">OK</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- * Dialog Konfirmasi Pembatalan -->
    
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