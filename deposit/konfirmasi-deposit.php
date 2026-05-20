<?php
require '../RGShenn.php';
require _DIR_('library/session/session');

$get_code = isset($_GET['code']) ? filter($_GET['code']) : '';
$get_data = isset($_GET['data']) ? filter($_GET['data']) : '';

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    if(!$_SESSION['user']) exit('No direct script access allowed!');
    if(!$get_code || !$get_data) exit('No direct script access allowed!');
    $get_code = explode('RGS', $get_code);
    $search = $call->query("SELECT * FROM deposit_method WHERE code = '".$get_code['0']."' AND data != ''");
    $row = $search->fetch_assoc();
    
    $feeTransaksi = (!$row['fee']) ? 'GRATIS' : 'Rp '.currency($row['fee']);
    $kodeUnik = (!$row['fee']) ? 'Akan Ditampilkan Setelah Klik Lanjutkan' : 'Rp 0';
    $totalBayar = (!$row['fee']) ? 'Rp '.currency($get_data).' + Kode Unik' : 'Rp '.currency($get_data+$row['fee']);
?>
                        <div class="section d-invoice">
                            <div class="card">
                                <div class="card-body">
                                    <ul class="listview image-listview no-line no-space flush mb-1">
                                        <li>
                                            <div class="item">
                                                <img src="<?= assets('mobile/img/home/deposit-rounded.png') ?>" width="36px" class="mr-2" id="RGSLogo">
                                                <div class="in">
                                                    <div>
                                                        <span>Deposit</span>
                                                        <footer>Isi Saldo Rp <?= currency($get_data) ?></footer>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                    
                                    <div class="more-info accordion pt-1" id="expandPembayaran">
                                        <div class="accordion-header">
                                            <button class="btn p-0 text-white" type="button" data-toggle="collapse" data-target="#show" aria-expanded="false">
                                                INFORMASI PELANGGAN
                                            </button>
                                        </div>
                                        <div id="show" class="accordion-body collapse show" data-parent="#expandPembayaran">
                                            <div class="accordion-content">
                                                <div class="trans-id">
                                                    <div class="text-muted">Metode Pembayaran</div>
                                                    <div class="rgs-text-rincian"><?= $row['name'] ?></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="more-info accordion pt-1" id="expandinfo">
                                        <div class="accordion-header">
                                            <button class="btn p-0 text-white" type="button" data-toggle="collapse" data-target="#show1" aria-expanded="false">
                                                INFORMASI TAGIHAN
                                            </button>
                                        </div>
                                        <div id="show1" class="accordion-body collapse show" data-parent="#expandinfo">
                                            <div class="accordion-content">
                                                <div class="trans-id">
                                                    <div class="text-muted">Nominal Deposit</div>
                                                    <div class="rgs-text-rincian">Rp <?= currency($get_data) ?></div>
                                                </div>
                                                <div class="trans-id">
                                                    <div class="text-muted">Biaya Transaksi</div>
                                                    <div class="rgs-text-rincian text-warning"><?= $feeTransaksi ?></div>
                                                </div>
                                                <div class="trans-id">
                                                    <div class="text-muted">Kode Unik</div>
                                                    <div class="rgs-text-rincian"><?= $kodeUnik ?></div>
                                                </div>
                                                <hr>
                                                <div class="trans-id">
                                                    <div><b>Total Pembayaran</b></div>
                                                    <div><b><?= $totalBayar ?></b></div>
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
                                        <input type="hidden" name="kode" value="<?= $get_code['0'] ?>">
                                        <input type="hidden" name="nominal" value="<?= $get_data ?>">
                                        <input type="hidden" name="unik" value="<?= $get_code['1'] ?>">
                                        <button type="submit" class="btn btn-primary btn-block mt-1 mb-1" name="deposit" onclick="var e=this;setTimeout(function(){e.disabled=true;},0);return true;">Lanjutkan Deposit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
<?
} else {
    exit('No direct script access allowed!');
}