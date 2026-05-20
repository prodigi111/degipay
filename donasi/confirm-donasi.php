<?php
require '../RGShenn.php';
require _DIR_('library/session/session');

$get_code = isset($_GET['code']) ? filter($_GET['code']) : '';
$get_data = isset($_GET['data']) ? filter($_GET['data']) : '';

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    if(!$_SESSION['user']) exit('No direct script access allowed!');
    if(!$get_code || !$get_data) exit('No direct script access allowed!');
    if($call->query("SELECT * FROM srv_donasi WHERE code = '$get_code' AND status = 'available'")->num_rows == false) exit('Layanan Tidak Ditemukan.');
    $row = $call->query("SELECT * FROM srv_donasi WHERE code = '$get_code' AND status = 'available'")->fetch_assoc();
    $search_cat = $call->query("SELECT * FROM category_donasi WHERE code = '".$row['brand']."'");
    $data_cat = $search_cat->fetch_assoc();
    $operator = strtolower($row['brand']);
    $tipe = $data_cat['type'];
    $label = $tipe == 'games' ? 'ID Game' : 'Tujuan Pengisian';
    $MustHaveZone = ['mobile legend', 'lifeafter credits', 'ragnarok m: eternal love', 'tom and jerry : chase', 'knights of valour', 'scroll of onmyoji'];
    $layanan = $row['name'];
    $get_data = str_replace('SHENN','',$get_data);
    $get_data = in_array($operator, $MustHaveZone) ? str_replace('=',' | ',$get_data) : str_replace('=', '', $get_data);
    $server = $row['provider'];
    $price = price($data_user['level'],$row['price'],$server);
?>
                        <div class="section d-invoice">
                            <div class="card">
                                <div class="card-body">
                                    <ul class="listview image-listview no-line no-space flush mb-1">
                                        <li>
                                            <div class="item">
                                                <img src="<?= assets('images/produk-icon/'.$row['type'].'.png') ?>" width="50px" height="50px" class="image" id="RGSLogo">
                                                <div class="in">
                                                    <div>
                                                        <span><?= strtoupper(str_replace('-', ' ', $row['type'])) ?></span>
                                                        <footer><?= $layanan ?></footer>
                                                        <footer class="text-gold"> + 50 Coin</footer>
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
                                                    <div class="text-muted">Nama Pelanggan</div>
                                                    <div class="rgs-text-rincian"><?= $get_data ?></div>
                                                </div>
                                                <div class="trans-id">
                                                    <div class="text-muted">Kategori</div>
                                                    <div class="rgs-text-rincian"><?= $row['category'] ?></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="more-info accordion pt-1" id="expandinfo">
                                        <div class="accordion-header">
                                            <button class="btn p-0 text-white" type="button" data-toggle="collapse" data-target="#show1" aria-expanded="false">
                                                INFORMASI DONASI
                                            </button>
                                        </div>
                                        <div id="show1" class="accordion-body collapse show" data-parent="#expandinfo">
                                            <div class="accordion-content">
                                                <div class="trans-id">
                                                    <div class="text-muted">Jumlah Donasi</div>
                                                    <div class="text-primary"><?= 'Rp '.$get_jumlah ?></div>
                                                </div>
                                                <hr>
                                                <div class="trans-id">
                                                    <div><b>Total Donasi</b></div>
                                                    <div><b><?= 'Rp '.$get_jumlah ?></b></div>
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
                                        <input type="hidden" id="web_token" name="web_token" value="<?= base64_encode($get_code) ?>">
                                        <input type="hidden" id="jumlah" name="jumlah" value="<?= $get_jumlah ?>">
                                        <input type="hidden" id="data" name="data" value="<?= $get_data ?>">
                                        <div class="row mt-2">
                                        <div class="col-12">
                                            <input type="password" class="form-control" maxlength="6" name="pin" pattern="[0-9]*" inputmode="numeric" placeholder="Masukkan PIN" style="font-size:0.75rem;">
                                        </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-block mt-1 mb-1" name="donasi" onclick="var e=this;setTimeout(function(){e.disabled=true;},0);return true;">Bayar Sekarang</button>
                                    </form>
                                </div>
                            </div>
                        </div>
<?
} else {
    exit('No direct script access allowed!');
}