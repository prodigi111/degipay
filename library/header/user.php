<!doctype html>
<html lang="id">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#000000">
    <title><?= $_CONFIG['title'] ?></title>
    <meta name="description" content="<?= $_CONFIG['description'] ?>">
    <meta name="keywords" content="<?= $_CONFIG['keyword'] ?>">
    <meta name="author" content="">
    <link rel="icon" type="image/png" href="<?= $_CONFIG['icon'] ?>" sizes="32x32">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= $_CONFIG['icon'] ?>"> 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css?v=<?= time() ?>"> 
    <link rel="stylesheet" href="<?= assets('mobile/') ?>css/style.css?v=<?= time() ?>"> 
    <link rel="stylesheet" href="<?= assets('mobile/') ?>css/theme.css?v=<?= time() ?>"> 
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="https://site-assets.fontawesome.com/releases/v6.1.1/css/all.css">
    <link rel="manifest" href="__manifest.json">
    <script src="<?= assets('mobile/') ?>js/lib/jquery-3.4.1.min.js"></script>
    <script src="<?= assets('mobile/') ?>js/lib/popper.min.js"></script>
    <script src="<?= assets('mobile/') ?>js/lib/bootstrap.min.js"></script>
    
    <style>
        .appHeader .scrolled .is_active{
            background-color : #000957 !important;
        }
        
        .bg-primary-new{
        background-color: #000957 !important;
        }
    </style>
</head>

<body
   
    <?= in_array($page, ['Menunggu Pembayaran', 'Pembayaran Berhasil', 'Rincian Transaksi', 'Rincian Top Up', 'Login', 'Verifikasi OTP', 'Verifikasi PIN', 'Daftar', 'Lupa Password']) ? ' class="bg-primary-new"' : ( $page == 'Dashboard' ? ' class="rgs-home bg-grey"' : 
    ( in_array($page, ['Saldo', 'Isi Saldo', 'Metode Pembayaran', 'Catatan Keuangan', 'Informasi dan Layanan', 'Coin', 'Tarik Coin', 'Notifikasi', 'Konfirmasi Penarikan', 'Daftar Layanan', 'Akun Saya', 'Referral', 'Daftar Harga', 'Konfirmasi Transfer', 'Pengaturan Akun', 'Pusat Bantuan']) ? ' class="bg-grey"' : '' ) )?>>

    <!-- loader -->
    <div id="loader">
     <img src="/library/assets/images/icon/load-1.gif" width="100">
    </div>

    <!-- App Header -->
<? if($page === 'Dashboard'): ?>
    <div class="appHeader no-border scrolled bg-white text-light">
        <div class="left"> 
        <a style=" border-radius: 9px; padding: 6px; height: 25px;" href="#" class="headerButton"><img src="<?= assets('images/degipay.png') ?>" width="100px" height="100px">&nbsp;<font style="font-size:18px; color : #3E00A3;"></font></a>
            <!--
            <a href="<?= base_url() ?>" class="headerButton">
                <img src="<?= $_CONFIG['icon'] ?>" width="90px">
            </a>
            
            <div class="pageTitle rgs-head-home bold">
                <?= $data_user['name'] ?><br>
                <span><?= strtoupper($data_user['level']) ?></span>
            </div> 
            -->
        </div>
        <div class="right">
            <!--
            <a href="<?= base_url('shop/') ?>" class="headerButton">
                <ion-icon name="bag-handle" class="text-light"></ion-icon>
            </a>
            <a href="<?= base_url('page/info.php') ?>" class="headerButton">
                <ion-icon name="notifications" class="text-light"></ion-icon>
            </a>-->
            <a style="background: #E0E5F8; border-radius: 15px; margin: 0px 0px 0px 0px; padding: 6px; height: 25px;" href="<?= base_url('page/promo'); ?>" class="headerButton"><img src="<?= base_url('library/assets/images/icon/promo.svg'); ?>" width="20px" height="20px">&nbsp;<font style="color : #3E00A3;">Promo</font></a>
        </div>
    </div>
<? elseif($page === 'Login'): ?>
    <div class="appHeader no-border transparent position-absolute text-light bold bg-primary-new">
    </div>
<? elseif($page === 'Akun Saya'): ?>
    <div class="appHeader no-border bg-primary-new text-light">
        <div class="left"></div>
        <div class="pageTitle bold"><?= $page ?></div>
        <div class="right"></div>
    </div>
<? elseif($page === 'Verifikasi Identitas' || $page === 'Profil' || $page === 'Ganti Nomor HP' || $page === 'Ganti Alamat Email' || $page === 'Ganti PIN'): ?>
    <div class="appHeader no-border bg-primary-new text-light">
        <div class="left">
            <a onclick="goBack()">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle bold"><?= $page ?></div>
        <div class="right"></div>
    </div>
<? elseif($page === 'Catatan Keuangan'): ?>
    <div class="appHeader no-border bg-primary-new text-light">
        <div class="left">
            <a onclick="goBack()">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
    <div class="pageTitle bold"><?= $page ?></div>
    <div class="right"></div>
    </div> 
<? elseif($page === 'Informasi dan Layanan'): ?>
    <div class="appHeader no-border bg-primary-new text-light">
        <div class="left">
            <a onclick="goBack()">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
    <div class="pageTitle bold"><?= $page ?></div>
    <div class="right"></div>
    </div>
<? elseif($page === 'Verifikasi OTP' || $page === 'Verifikasi PIN' || $page === 'Daftar'): ?>
    <div class="appHeader no-border bg-primary-new text-light">
        <div class="left">
            <form method="POST">
                <button type="submit" name="cancel" class="btn btn-icon btn-md pt-2 mr-1 mb-1 bg-primary-new">
                    <ion-icon name="chevron-back-outline"></ion-icon>
                </button>
            </form>
        </div>
        <div class="pageTitle bold"><?= $page ?></div>i
        <div class="right"></div>
    </div>
<? elseif($page === 'Menunggu Pembayaran' || $page === 'Pembayaran Berhasil'): ?>
    <div class="appHeader no-border bg-primary-new text-light">
        <div class="left"></div>
        <div class="right"></div>
    </div>
<? elseif($page === 'Upgrade Level'): ?>
    <div class="appHeader no-border bg-primary-new text-light">
        <div class="left"></div>
        <div class="pageTitle bold">
            <?= strtoupper($page) ?>
        </div>
        <div class="right">
            <a href="<?= base_url() ?>" class="headerButton">
                <ion-icon name="close-outline" class="text-light"></ion-icon>
            </a>
        </div>
    </div>
    <div class="extraHeader rgs-upgrade-level-header no-border bg-primary-new">
        <h1>Premium</h1>
    </div>
    <? elseif($page === 'Bongkar Koin'): ?>
    <div class="appHeader no-border bg-primary-new text-light">
        <div class="left"></div>
        <div class="pageTitle bold">
            <?= strtoupper($page) ?>
        </div>
        <div class="right">
            <a href="<?= base_url() ?>" class="headerButton">
                <ion-icon name="close-outline" class="text-light"></ion-icon>
            </a>
        </div>
    </div>
<? elseif($page === 'Upgrade Premium'): ?>
    <div class="appHeader no-border transparent">
        <div class="left">
            <a href="<?= base_url() ?>" class="headerButton">
                <ion-icon name="close-outline" class="text-light"></ion-icon>
            </a>
        </div>
        <div class="pageTitle bold">
        </div>
        <div class="right"></div>
    </div>
<? elseif($page === 'Coming Soon'): ?>
    <div class="appHeader no-border transparent position-absolute">
        <div class="left">
            <a href="<?= base_url() ?>" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle bold"><?= $page ?></div>
        <div class="right">
            <a href="#"data-toggle="modal" data-target="#openMenu" class="headerButton">
                <ion-icon name="ellipsis-vertical-outline"></ion-icon>
            </a>
        </div>
    </div>
<? else: ?>
    <div class="appHeader no-border<?= in_array($page, ['Detail Berita & Promosi', 'Detail Notifikasi', 'Detail Fitur', 'Upgrade Premium', 'Coin', 'Kembali']) ? ' scrolled' : '' ?> bg-primary-new text-light">
        <div class="left">
            <a onclick="goBack()">
                <ion-icon name="chevron-back-outline"<?= in_array($page, ['Detail Berita & Promosi', 'Detail Notifikasi', 'Detail Fitur', 'Kembali']) ? ' class="text-light"' : '' ?>></ion-icon>
            </a>
        </div>
        <div class="pageTitle bold">
            <?= $page ?>
        </div>
        <div class="right">
        </div>
    </div> 
    <? if($page === 'Pemberitahuan'): ?>
    <div class="extraHeader no-border bg-primary-new">
        <ul class="nav nav-tabs style1" role="tablist">
            
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#Informasi" role="tab" aria-selected="true">
                    Informasi Terbaru
                </a>
            </li>
            <!--
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#Berita" role="tab" aria-selected="true">
                Promo Terbaru
                </a>
            </li>
            -->
        </ul>
    </div>
    <? elseif($page === 'Promo'): ?>
    <div class="extraHeader no-border bg-primary-new">
        <ul class="nav nav-tabs style1" role="tablist">
            <!--
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#Informasi" role="tab" aria-selected="true">
                    Informasi
                </a>
            </li>
            -->
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#Berita" role="tab" aria-selected="true">
                Promo Terbaru
                </a>
            </li>
        </ul>
    </div>
    <? elseif($page === 'Daftar Harga') : ?>
    <div class="extraHeader p-0">
        <ul class="nav nav-tabs lined" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#Praba" role="tab" aria-selected="true">
                    Prabayar
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#pasca" role="tab" aria-selected="false">
                    Pascabayar
                </a>
            </li>
        </ul>
    </div>
    <? elseif($page === 'Riwayat') : ?>
    <div class="extraHeader no-border bg-primary-new">
        <ul class="nav nav-tabs style1" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#Transaksi" role="tab" aria-selected="true">
                    Transaksi
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#Topup" role="tab" aria-selected="false">
                    Isi Saldo
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#Mutasi" role="tab" aria-selected="false">
                    Mutasi Saldo
                </a>
            </li>
        </ul>
    </div> 
    <? elseif($page === 'Mutasi') : ?>
     <div class="appHeader no-border bg-primary-new">
        <div class="left"></div>
        <div class="pageTitle bold"><?= $page ?></div>
        <div class="right"></div>
    </div>
    <? elseif($page === 'Isi Saldo') : ?>
    <div class="extraHeader no-border bg-primary-new">
        <ul class="nav nav-tabs style1" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#topup" role="tab" aria-selected="true">
                    Topup
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#voucher" role="tab" aria-selected="false">
                    Klaim Voucher
                </a>
            </li>
        </ul>
    </div>
    <? elseif($page === 'Klaim Voucher') : ?>
    <div class="extraHeader no-border bg-primary-new">
        <ul class="nav nav-tabs style1" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#voucher" role="tab" aria-selected="true">
                    VOUCHER <?= $_CONFIG['title'] ?>
                </a>
            </li>
        </ul>
    </div>
    <? elseif($page === 'Ranking') : ?>
    <div class="extraHeader no-border bg-primary-new">
        <ul class="nav nav-tabs style1" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#topup" role="tab">
                    Top Up
                </a>
            </li>
            <!--
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#order" role="tab">
                    Order
                </a>
            </li>
            -->
        </ul>
    </div>
    <? elseif($page === 'Games') : ?>
    <div class="extraHeader no-border bg-primary-new">
        <ul class="nav nav-tabs style1" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#Semua" role="tab">
                    Semua
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#Topup" role="tab">
                    Topup
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#Voucher" role="tab">
                    Voucher
                </a>
            </li>
        </ul>
    </div>
    <? elseif($page === 'Voucher') : ?>
    <div class="extraHeader no-border bg-primary-new">
        <ul class="nav nav-tabs style1" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#Semua" role="tab">
                    Semua
                </a>
            </li>
            <!--
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#Data" role="tab">
                    Data
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#Digital" role="tab">
                    Digital
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#TV" role="tab">
                    TV
                </a>
            </li>
            -->
        </ul>
    </div>
    <? elseif($page === 'Voucher Domino') : ?>
    <div class="extraHeader no-border bg-primary-new">
        <ul class="nav nav-tabs style1" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#Semua" role="tab">
                    Semua
                </a>
            </li>
        </ul>
    </div>
    <? elseif($page === 'E-Money') : ?>
    <div class="extraHeader no-border bg-primary-new">
        <ul class="nav nav-tabs style1" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#Semua" role="tab">
                    Semua
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#EMoney" role="tab">
                    E-Money
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#Driver" role="tab">
                    Driver
                </a>
            </li>
        </ul>
    </div>
    <? elseif($page === 'Fitur Premium') : ?>
    <div class="extraHeader no-border bg-primary-new">
        <ul class="nav nav-tabs style1" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#Penarikan" role="tab" aria-selected="true">
                    Riwayat Penarikan
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#Komisi" role="tab" aria-selected="false">
                    Riwayat Komisi
                </a>
            </li>
        </ul>
    </div>
    <? elseif($page === 'Tukar Poin') : ?>
    <div class="extraHeader no-border bg-primary-new">
        <ul class="nav nav-tabs style1" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#rewards" role="tab">
                    Hadiah
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#history" role="tab">
                     Riwayat
                </a>
            </li>
        </ul>
    </div>
    <? endif ?>
<? endif ?>
    <!-- * App Header -->
     
    <!-- openMenu Action Sheet -->
    <div class="modal fade action-sheet" id="openMenu" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Menu</h5>
                </div>
                <div class="modal-body">
                    <ul class="action-button-list">
                        <li>
                            <a href="<?= base_url() ?>" class="btn btn-list text-primary" style="justify-content: center">
                                <span class="text-center">Kembali Ke Beranda</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url('page/about-us') ?>" class="btn btn-list text-primary" style="justify-content: center">
                                <span>Hubungi Kami</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url('page/terms-conditions') ?>" class="btn btn-list text-primary" style="justify-content: center">
                                <span>Syarat Dan Ketentuan</span>
                            </a>
                        </li>
                        <li class="action-divider"></li>
                        <li>
                            <a href="#" class="btn btn-list text-primary" data-dismiss="modal" style="justify-content: center">
                                <span>Close</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- * openMenu Action Sheet -->