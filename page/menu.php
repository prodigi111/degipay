<?php
require '../RGShenn.php';
require _DIR_('library/session/user');
$page = 'Daftar Layanan';
require _DIR_('library/header/user');
?>
<style>
    .app-menu .item strong {
        margin-top: 8px
    }
    a {
        color:#4F5050;
    }
    .title-bills {
        font-size:13.5px;
        font-weight:600;
    }
    .sub-bills {
        font-size:9px;
    }
    .plus-bills {
        font-size:20px;
        font-weight:600;
    }
    .title {
        font-size:14px;
        font-weight:bold;
    }
    .image-listview > li .item .in {
        display: block;
        align-items: normal;
        width: 100%;
        color:#4F5050;
    }
</style>
    <!-- App Capsule -->
        <div id="appCapsule" class="pb-0">
        <div class="section service" style="background-color:#000957;border-color:#000957">
        <div class="wide-block-service">
            <!--<div class="p-2 pb-2">
                <div class="title">Isi Ulang</div>
                <div style="font-size: 12px; opacity: .576">Dengan <?= $_CONFIG['title']; ?> isi ulang menjadi lebih mudah</div>
            </div>
            <div class="app-menu mt-0">
                <a href="<?= base_url('order/pulsa-reguler') ?>" class="item">
                    <div class="col">
                        <img src="<?= assets('mobile/icon/png/pulsa-reg.png') ?>" width="55px" height="55px">
                        <strong>PULSA REGULER</strong>
                    </div>
                </a>
                <a href="<?= base_url('order/pulsa-transfer') ?>" class="item">
                    <div class="col">
                        <img src="<?= assets('mobile/icon/png/pulsa-transfer.png') ?>" width="55px" height="55px">
                        <strong>PULSA TRANSFER</strong>
                    </div>
                </a>
                <a href="<?= base_url('order/paket-internet') ?>" class="item">
                    <div class="col">
                        <img src="<?= assets('mobile/icon/png/paket-data.png') ?>" width="55px" height="55px">
                        <strong>PAKET DATA</strong>
                    </div>
                </a>
                <a href="<?= base_url('order/paket-telp') ?>" class="item">
                    <div class="col">
                        <img src="<?= assets('mobile/icon/png/telpon-sms.png') ?>" width="55px" height="55px">
                        <strong>PAKET SMS&TELPON</strong>
                    </div>
                </a>
            </div>
            <div class="app-menu mt-3">
                <a href="<?= base_url('order/token-pln') ?>" class="item">
                    <div class="col">
                        <img src="<?= assets('mobile/icon/png/token-pln.png') ?>" width="55px" height="55px">
                        <strong>TOKEN PLN</strong>
                    </div>
                </a>
                <a href="<?= base_url('order/pulsa-international') ?>" class="item">
                    <div class="col">
                        <img src="<?= assets('mobile/icon/png/pulsa-internasional.png') ?>" width="55px" height="55px">
                        <strong>PULSA INTERNASIONAL</strong>
                    </div>
                </a> 
                <a href="<?= base_url('order/e-money') ?>" class="item">
                    <div class="col">
                        <img src="<?= assets('mobile/icon/png/money.png') ?>" width="58px" height="58px">
                        <strong>E-MONEY</strong>
                    </div>
                </a>
                <a href="#" class="item"></a>
            </div>
        </div>
            </div>
        <div class="section full bg-white pl-1 pr-1 pb-3 mb-1"> 
        </div>
        -->
          
        </div>
        <div class="section full bg-white pl-1 pr-1 pb-3 mb-1">
            <div class="p-2 pb-2">
                <div class="title">Dompet Digital</div>
                <div style="font-size: 12px; opacity: .576">Solusi semua pembayaran Elektronik, hanya di <?= $_CONFIG['title']; ?></div>
            </div>
            <div class="app-menu mt-0">
                <?php 
                    $search = $call->query("SELECT * FROM srv WHERE type = 'e-money' AND brand IN ('SHOPEE PAY') AND kategori = 'Umum' GROUP BY brand ORDER BY name ASC");
                    if($search->num_rows == FALSE) { 
                        print '<div class="alert alert-danger text-left fade show mr-2 ml-2 mt-2" role="alert">Tidak Ada Layanan Yang Tersedia!</div>';
                    }
                    while($row = $search->fetch_assoc()) { 
                    $code = str_replace('.', '=', str_replace(' ', '-', strtolower($row['brand'])));
                    ?>
                <a href="<?= base_url('order/e-money-detail?s='.$code) ?>" class="item">
                    <div class="col">
                        <img src="<?= assets('images/emoney-icon/'.$code.'.jpg').'?'.time() ?>" alt="<?= $code ?>" width="50px">
                        <strong><?= $row['brand'] ?></strong>
                    </div>
                </a>
                    <?php } ?>
                <?php 
                    $search = $call->query("SELECT * FROM srv WHERE type = 'e-money' AND brand IN ('GO PAY') AND kategori = 'Umum' GROUP BY brand ORDER BY name ASC");
                    if($search->num_rows == FALSE) { 
                        print '<div class="alert alert-danger text-left fade show mr-2 ml-2 mt-2" role="alert">Tidak Ada Layanan Yang Tersedia!</div>';
                    }
                    while($row = $search->fetch_assoc()) { 
                    $code = str_replace('.', '=', str_replace(' ', '-', strtolower($row['brand'])));
                    ?>
                <a href="<?= base_url('order/e-money-detail?s='.$code) ?>" class="item">
                    <div class="col">
                        <img src="<?= assets('images/emoney-icon/'.$code.'.jpg').'?'.time() ?>" alt="<?= $code ?>" width="50px">
                        <strong><?= $row['brand'] ?></strong>
                    </div>
                </a>
                    <?php } ?>
                </div>
                <div class="app-menu mt-3">
                <?php 
                    $search = $call->query("SELECT * FROM srv WHERE type = 'e-money' AND brand IN ('OVO') AND kategori = 'Umum' GROUP BY brand ORDER BY name ASC");
                    if($search->num_rows == FALSE) { 
                        print '<div class="alert alert-danger text-left fade show mr-2 ml-2 mt-2" role="alert">Tidak Ada Layanan Yang Tersedia!</div>';
                    }
                    while($row = $search->fetch_assoc()) { 
                    $code = str_replace('.', '=', str_replace(' ', '-', strtolower($row['brand'])));
                    ?>
                <a href="<?= base_url('order/e-money-detail?s='.$code) ?>" class="item">
                    <div class="col">
                        <img src="<?= assets('images/emoney-icon/'.$code.'.jpg').'?'.time() ?>" alt="<?= $code ?>" width="50px">
                        <strong><?= $row['brand'] ?></strong>
                    </div>
                </a>
                    <?php } ?>
                <?php 
                    $search = $call->query("SELECT * FROM srv WHERE type = 'e-money' AND brand IN ('DANA') AND kategori = 'Umum' GROUP BY brand ORDER BY name ASC");
                    if($search->num_rows == FALSE) { 
                        print '<div class="alert alert-danger text-left fade show mr-2 ml-2 mt-2" role="alert">Tidak Ada Layanan Yang Tersedia!</div>';
                    }
                    while($row = $search->fetch_assoc()) { 
                    $code = str_replace('.', '=', str_replace(' ', '-', strtolower($row['brand'])));
                    ?>
                <a href="<?= base_url('order/e-money-detail?s='.$code) ?>" class="item">
                    <div class="col">
                        <img src="<?= assets('images/emoney-icon/'.$code.'.jpg').'?'.time() ?>" alt="<?= $code ?>" width="50px">
                        <strong><?= $row['brand'] ?></strong>
                    </div>
                </a>
                    <?php } ?>
            </div>
        </div>
        <!--
        <div class="section full bg-white pl-1 pr-1 pb-3 mb-1">
            <div class="p-2 pb-2">
                <div class="title">Tagihan</div>
                <div style="font-size: 12px; opacity: .576">Solusi semua pembayaran Tagihan, hanya di <?= $_CONFIG['title']; ?></div>
            </div>
            <div class="app-menu mt-0">
                <?php 
                    $search = $call->query("SELECT * FROM srv WHERE type = 'pascabayar' AND brand IN ('PLN PASCABAYAR') AND kategori = 'Umum' GROUP BY brand ORDER BY name ASC");
                    if($search->num_rows == FALSE) { 
                        print '<div class="alert alert-danger text-left fade show mr-2 ml-2 mt-2" role="alert">Tidak Ada Layanan Yang Tersedia!</div>';
                    }
                    while($row = $search->fetch_assoc()) { 
                    $code = str_replace('.', '=', str_replace(' ', '-', strtolower($row['brand'])));
                    ?>
                <a href="<?= base_url('order/pasca-bayar-detail?s='.$code) ?>" class="item">
                    <div class="col">
                        <img src="<?= assets('images/pascabayar/'.$code.'.png').'?'.time() ?>" alt="<?= $code ?>" width="55px" height="55px">
                        <strong><?= $row['brand'] ?></strong>
                    </div>
                </a>
                <?php } ?>
                <?php 
                    $search = $call->query("SELECT * FROM srv WHERE type = 'pascabayar' AND brand IN ('PDAM') AND kategori = 'Umum' GROUP BY brand ORDER BY name ASC");
                    if($search->num_rows == FALSE) { 
                        print '<div class="alert alert-danger text-left fade show mr-2 ml-2 mt-2" role="alert">Tidak Ada Layanan Yang Tersedia!</div>';
                    }
                    while($row = $search->fetch_assoc()) { 
                    $code = str_replace('.', '=', str_replace(' ', '-', strtolower($row['brand'])));
                    ?>
                <a href="<?= base_url('order/pasca-bayar-detail?s='.$code) ?>" class="item">
                    <div class="col">
                        <img src="<?= assets('images/pascabayar/'.$code.'.png').'?'.time() ?>" alt="<?= $code ?>" width="55px" height="55px">
                        <strong><?= $row['brand'] ?></strong>
                    </div>
                </a>
                <?php } ?>
                <?php 
                    $search = $call->query("SELECT * FROM srv WHERE type = 'pascabayar' AND brand IN ('GAS NEGARA') AND kategori = 'Umum' GROUP BY brand ORDER BY name ASC");
                    if($search->num_rows == FALSE) { 
                        print '<div class="alert alert-danger text-left fade show mr-2 ml-2 mt-2" role="alert">Tidak Ada Layanan Yang Tersedia!</div>';
                    }
                    while($row = $search->fetch_assoc()) { 
                    $code = str_replace('.', '=', str_replace(' ', '-', strtolower($row['brand'])));
                    ?>
                <a href="<?= base_url('order/pasca-bayar-detail?s='.$code) ?>" class="item">
                    <div class="col">
                        <img src="<?= assets('images/pascabayar/'.$code.'.png').'?'.time() ?>" alt="<?= $code ?>" width="55px" height="55px">
                        <strong><?= $row['brand'] ?></strong>
                    </div>
                </a>
                <?php } ?>
                <?php 
                    $search = $call->query("SELECT * FROM srv WHERE type = 'pascabayar' AND brand IN ('PBB') AND kategori = 'Umum' GROUP BY brand ORDER BY name ASC");
                    if($search->num_rows == FALSE) { 
                        print '<div class="alert alert-danger text-left fade show mr-2 ml-2 mt-2" role="alert">Tidak Ada Layanan Yang Tersedia!</div>';
                    }
                    while($row = $search->fetch_assoc()) { 
                    $code = str_replace('.', '=', str_replace(' ', '-', strtolower($row['brand'])));
                    ?>
                <a href="<?= base_url('order/pasca-bayar-detail?s='.$code) ?>" class="item">
                    <div class="col">
                        <img src="<?= assets('images/pascabayar/'.$code.'.png').'?'.time() ?>" alt="<?= $code ?>" width="55px" height="55px">
                        <strong><?= $row['brand'] ?></strong>
                    </div>
                </a>
                <?php } ?>
            </div>
            <div class="app-menu mt-3">
                <?php 
                    $search = $call->query("SELECT * FROM srv WHERE type = 'pascabayar' AND brand IN ('BPJS KESEHATAN') AND kategori = 'Umum' GROUP BY brand ORDER BY name ASC");
                    if($search->num_rows == FALSE) { 
                        print '<div class="alert alert-danger text-left fade show mr-2 ml-2 mt-2" role="alert">Tidak Ada Layanan Yang Tersedia!</div>';
                    }
                    while($row = $search->fetch_assoc()) { 
                    $code = str_replace('.', '=', str_replace(' ', '-', strtolower($row['brand'])));
                    ?>
                <a href="<?= base_url('order/pasca-bayar-detail?s='.$code) ?>" class="item">
                    <div class="col">
                        <img src="<?= assets('images/pascabayar/'.$code.'.png').'?'.time() ?>" alt="<?= $code ?>" width="55px" height="55px">
                        <strong><?= $row['brand'] ?></strong>
                    </div>
                </a>
                <?php } ?>
                <?php 
                    $search = $call->query("SELECT * FROM srv WHERE type = 'pascabayar' AND brand IN ('INTERNET PASCABAYAR') AND kategori = 'Umum' GROUP BY brand ORDER BY name ASC");
                    if($search->num_rows == FALSE) { 
                        print '<div class="alert alert-danger text-left fade show mr-2 ml-2 mt-2" role="alert">Tidak Ada Layanan Yang Tersedia!</div>';
                    }
                    while($row = $search->fetch_assoc()) { 
                    $code = str_replace('.', '=', str_replace(' ', '-', strtolower($row['brand'])));
                    ?>
                <a href="<?= base_url('order/pasca-bayar-detail?s='.$code) ?>" class="item">
                    <div class="col">
                        <img src="<?= assets('images/pascabayar/'.$code.'.png').'?'.time() ?>" alt="<?= $code ?>" width="55px" height="55px">
                        <strong><?= $row['brand'] ?></strong>
                    </div>
                </a>
                <?php } ?>
                <?php 
                    $search = $call->query("SELECT * FROM srv WHERE type = 'pascabayar' AND brand IN ('MULTIFINANCE') AND kategori = 'Umum' GROUP BY brand ORDER BY name ASC");
                    if($search->num_rows == FALSE) { 
                        print '<div class="alert alert-danger text-left fade show mr-2 ml-2 mt-2" role="alert">Tidak Ada Layanan Yang Tersedia!</div>';
                    }
                    while($row = $search->fetch_assoc()) { 
                    $code = str_replace('.', '=', str_replace(' ', '-', strtolower($row['brand'])));
                    ?>
                <a href="<?= base_url('order/pasca-bayar-detail?s='.$code) ?>" class="item">
                    <div class="col">
                        <img src="<?= assets('images/pascabayar/'.$code.'.png').'?'.time() ?>" alt="<?= $code ?>" width="55px" height="55px">
                        <strong><?= $row['brand'] ?></strong>
                    </div>
                </a>
                <?php } ?>
                <?php 
                    $search = $call->query("SELECT * FROM srv WHERE type = 'pascabayar' AND brand IN ('HP PASCABAYAR') AND kategori = 'Umum' GROUP BY brand ORDER BY name ASC");
                    if($search->num_rows == FALSE) { 
                        print '<div class="alert alert-danger text-left fade show mr-2 ml-2 mt-2" role="alert">Tidak Ada Layanan Yang Tersedia!</div>';
                    }
                    while($row = $search->fetch_assoc()) { 
                    $code = str_replace('.', '=', str_replace(' ', '-', strtolower($row['brand'])));
                    ?>
                <a href="<?= base_url('order/pasca-bayar-detail?s='.$code) ?>" class="item">
                    <div class="col">
                        <img src="<?= assets('images/pascabayar/'.$code.'.png').'?'.time() ?>" alt="<?= $code ?>" width="55px" height="55px">
                        <strong><?= $row['brand'] ?></strong>
                    </div>
                </a>
                <?php } ?>
            </div>
        </div>
        <div class="section full bg-white pl-1 pr-1 pb-3 mb-1">
            <div class="p-2 pb-2">
                <div class="title">Voucher</div>
                <div style="font-size: 12px; opacity: .576">Beli voucher terlengkap, hanya di <?= $_CONFIG['title']; ?></div>
            </div>
            <div class="app-menu mt-0">
                
                <a href="<?= base_url('order/games') ?>" class="item">
                    <div class="col">
                        <img src="<?= assets('mobile/icon/png/voucher-game.png') ?>" width="55px" height="55px">
                        <strong>Voucher Games</strong>
                    </div>
                </a>
                
                <a href="<?= base_url('order/voucher') ?>" class="item">
                    <div class="col">
                        <img src="<?= assets('mobile/icon/png/voucher-digital.png') ?>" width="55px" height="55px">
                        <strong>Voucher Lainnya</strong>
                    </div>
                </a>
                <a href="#" onclick="toastbox('toastComingSoon', 2500)" class="item">
                    <div class="col">
                        <img src="<?= assets('mobile/icon/png/voucher-data.png') ?>" width="55px" height="55px">
                        <strong>Inject Voucher</strong>
                    </div>
                </a>
                <a href="#" class="item"></a>
            </div>
        </div>
        <div class="section full bg-white pl-1 pr-1 pb-3 mb-1">
            <div class="p-2 pb-2">
                <div class="title">Layanan Lainnya</div>
                <div style="font-size: 12px; opacity: .576">Lihat layanan lainnya dari <?= $_CONFIG['title']; ?></div>
            </div>
            <div class="app-menu mt-0">
                <a href="#" class="item">
                    <div class="col">
                        <img src="<?= assets('mobile/icon/png/voucher-tv.png') ?>" width="55px" height="55px">
                        <strong>Voucher Tv</strong>
                    </div>
                </a>
                 <a href="/donasi" class="item">
                    <div class="col">
                        <img src="<?= assets('mobile/icon/png/donasi.png') ?>" width="55px" height="55px">
                        <strong>Donasi</strong>
                    </div>
                </a>
                <a href="#" class="item"></a>
                <a href="#" class="item"></a>
            </div>
        </div>
        
        <div class="section full bg-white pl-1 pr-1 pb-3 mb-1">
            <div class="p-2 pb-2">
                <div class="title">Keagenan</div>
                <div style="font-size: 12px; opacity: .576">Kelola data keagenan anda di <?= $_CONFIG['title']; ?></div>
            </div>
            <div class="app-menu mt-0">
                <a href="<?= base_url('deposit/transfer') ?>" class="item">
                    <div class="col">
                        <img src="<?= assets('mobile/img/home/transfer-saldo.png') ?>" width="50px">
                        <strong>Transfer Saldo</strong>
                    </div>
                </a>
                <a href="<?= base_url('premium') ?>" class="item">
                    <div class="col">
                        <img src="<?= assets('mobile/img/home/tarik-komisi.png') ?>" width="50px">
                        <strong>Tarik Komisi</strong>
                    </div>
                </a>
                <a href="<?= base_url('premium/tukar-poin') ?>" class="item">
                    <div class="col">
                        <img src="<?= assets('mobile/img/home/tukar-poin.png') ?>" width="50px">
                        <strong>Tukar Poin</strong>
                    </div>
                </a>
                <a href="<?= base_url('referral') ?>" class="item">
                    <div class="col">
                        <img src="<?= assets('mobile/img/home/referral-1.png') ?>" width="50px">
                        <strong>Kode Referral</strong>
                    </div>
                </a>
            </div>
        </div>
        
        <div class="section full bg-white pl-1 pr-1 pb-3 mb-1">
            <div class="p-2 pb-2">
                <div class="title">Bantuan</div>
                <div style="font-size: 12px; opacity: .576">Layanan Bantuan <?= $_CONFIG['title']; ?></div>
            </div>
            <div class="app-menu mt-0">
                <a href="<?= base_url('page/about-us.php') ?>" class="item">
                    <div class="col">
                        <img src="<?= assets('mobile/img/home/help.png') ?>" width="50px">
                        <strong>Hubungi CS</strong>
                    </div>
                </a>
                <a href="<?= base_url('page/price-list.php') ?>" class="item">
                    <div class="col">
                        <img src="<?= assets('mobile/img/home/daftar-harga.png') ?>" width="50px">
                        <strong>Daftar Harga</strong>
                    </div>
                </a>
                <a href="<?= base_url('page/terms-conditions.php') ?>" class="item">
                    <div class="col">
                        <img src="<?= assets('mobile/img/home/s-k.png') ?>" width="50px">
                        <strong>S&K</strong>
                    </div>
                </a>
                <a href="<?= base_url('page/help-center.php') ?>" class="item">
                    <div class="col">
                        <img src="<?= assets('mobile/img/home/pusat-bantuan.png') ?>" width="50px">
                        <strong>Pusat Bantuan</strong>
                    </div>
                </a>
            </div>
        </div>
    </div>
    
    <!-- * App Capsule -->

<?php require _DIR_('library/footer/user') ?>
