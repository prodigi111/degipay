<?php
require '../RGShenn.php';
require _DIR_('library/session/session');

$get_code = isset($_GET['rgs']) ? filter($_GET['rgs']) : '';

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    if(!$_SESSION['user']) exit('No direct script access allowed!');
    if(!$get_code) exit('No direct script access allowed!');
    $search = $call->query("SELECT * FROM produk WHERE kode = '$get_code' AND status = 'READY'");
    if($search->num_rows == false) exit('Layanan Tidak Ditemukan.');
    $row = $search->fetch_assoc();
    
?>
                        <div class="section d-invoice pb-5">
                            <div class="card">
                                <div class="card-body">
                                    <ul class="listview image-listview no-line no-space flush mb-1">
                                        <li>
                                            <div class="item">
                                                <div class="icon-box bg-primary">
                                                    <ion-icon name="storefront-outline"></ion-icon>
                                                </div>
                                                <div class="in">
                                                    <div>
                                                        <span><?= $row['kategori'] ?></span>
                                                        <footer><?= $row['nama'] ?></footer>
                                                        <footer class="text-warning">+5 Point</footer>
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
                                                    <div class="text-muted">Harga</div>
                                                    <div class="rgs-text-rincian"><?= 'Rp '.currency($row['harga']) ?></div>
                                                </div>
                                                <div class="trans-id">
                                                    <div class="text-muted">Biaya Transaksi</div>
                                                    <div class="text-warning">GRATIS</div>
                                                </div>
                                                <hr>
                                                <div class="trans-id">
                                                    <div><b>Total Pembayaran</b></div>
                                                    <div><b><?= 'Rp '.currency($row['harga']) ?></b></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
<!--                                    <div class="more-info accordion pt-1" id="expandSK">-->
<!--                                        <div class="accordion-header">-->
<!--                                            <button class="btn p-0 text-white" type="button" data-toggle="collapse" data-target="#show2" aria-expanded="false">-->
<!--                                                SYARAT DAN KETENTUAN-->
<!--                                            </button>-->
<!--                                        </div>-->
<!--                                        <div id="show2" class="accordion-body collapse show" data-parent="#expandSK">-->
<!--                                            <div class="accordion-content">-->
<!--                                                <span style="white-space: pre-line;">- Sebelum Membeli Silahkan Baca Kembali Detail Layanan-->
<!--- Maksimal Pengerjaan 1X24 Jam-->
<!--- Kirimkan Detail yang diminta ke Whatssapp Admin dengan menyertakan ID Transaksi-->
<!--- Akun/File Akan Dikirimkan Langsung Ke Whatsapp Anda-->
<!--- Setelah File/Akun di kirim dan di terima silahkan cek kembali File/Akunnya, Apabila sudah cocok/ada masalah Silahkan konfirmasi Admin-->
<!--- Setelah File/Akun di kirim dan di terima Selama 1x24 Jam, Tetapi tidak ada konfirmasi dari Pembeli maka kami anggap SELESAI-->
<!--- Setelah 1x24 Jam File/Akun di terima, kami tidak menerima KOMPLAIN APAPUN-->
<!--                                                </span>-->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                    </div>-->
                                    
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
                                        <input type="hidden" id="web_token" name="web_token" value="<?= base64_encode($get_code) ?>">
                                        <button type="submit" class="btn btn-primary btn-block mt-1 mb-1" name="buyShop" onclick="var e=this;setTimeout(function(){e.disabled=true;},0);return true;">Bayar Sekarang</button>
                                    </form>
                                </div>
                            </div>
                        </div>
<?
} else {
    exit('No direct script access allowed!');
}