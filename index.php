<?php
require 'RGShenn.php';
if(!isset($_SESSION['user']) && !isset($_COOKIE['token']) && !isset($_COOKIE['ssid'])) {
        $ShennID = $_COOKIE['ssid'];
        $ShennUID = str_replace(['SHENN-A','AIY'],'',$ShennID) + 0;
        $ShennKey = $_COOKIE['token'];
        $ShennUser = $call->query("SELECT * FROM users WHERE id = '$ShennUID'")->fetch_assoc();

        $ShennCheck = $call->query("SELECT * FROM users_cookie WHERE cookie = '$ShennKey' AND username = '".$ShennUser['username']."'");
        if($ShennCheck->num_rows == 1) {
            $_SESSION['user'] = $ShennUser;
            redirect(0,visited());
            $call->query("UPDATE users_cookie SET active = '$date $time' WHERE cookie = '$ShennKey'");
        } else {
            redirect(0,base_url('auth/login'));
        }
} else {
    if((time() - $_SESSION['last_login_time']) > 3600000000000000000000007656755353429008898989543345678) {
        redirect(0,base_url('auth/logout'));
    } else {
    $_SESSION['last_login_time'] = time();
    require _DIR_('library/session/user');
    $page = 'Dashboard';
    require _DIR_('library/header/user');
?>
    <!-- App Capsule -->
    <style>
        .marquee {
          width: 100%;
          overflow: hidden;
        }
        .urgent-alert .marquee {
            font-size: 13px;
        }
        .urgent-alert .marquee span:not(:last-child) {
            padding-right: 18px 
        }
        .infinite-menu .card:not(:last-child) {
            padding-right: 12px
        }
        .infinite-menu .card:last-child {
            padding-right: 1rem
        }
        .inifite-menu {
            margin-left: 16px;
        }
        .card.reward-poin {
            display: inline-flex;
        }
        .app-list {
            display: block;
            align-items: center;
            width: 100%;
            padding: 0 20px;
        }
        .app-list .sort-menu .menu {
            display: flex;
            padding-right: 5px;
        }
        .app-list > .menu {
            border-right: 2px solid #e1e1e1;
            padding-right: 5px
        }
        .app-list .btn {
            padding: 8px;
            font-size: 10px;
            height: 24px;
            font-weight: 600;
            width: 70px;
        }
        .app-list .sort-menu .menu:not(:first-child) {
            border-left: 2px solid #e1e1e1;
        }
        .app-list .sort-menu .menu .in {
            line-height: 16px;
        }
        .app-list .sort-menu .menu img {
            max-height: 20px;
            margin: 0 5px;
        }
        .app-list .sort-menu .menu .in .title {
            font-size: 12px;
            font-weight: 600;
        }
        .app-list .sort-menu .menu .in .subtitle {
            font-size: 11px;
            color: #909090;
        }
        .app-list .sort-menu {
            display: inline-flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
        }
        .app-menu .item .col {
            max-height: 56px
        }
        .rewards-bg {
            /*background-image: url("https://app.plisspa.id/library/assets/images/background/ramadhan.jpg");*/
            background-color: #000957;
            background-repeat: no-repeat !important;
            background-size: cover !important;
        }
        .section.home {
            /*background-image: url("https://app.plisspa.id/library/assets/images/background/texture-full-vilan.jpg");*/
            background-color: #000957;
            background-repeat: no-repeat !important;
            background-size: cover !important;
            padding: 115px 0px 0px;
            margin-bottom: 10px;
        }
        .section-home, .top-left {
            position: absolute;
            top: 50px;
            left: 16px;
            font-size: 11px;
        }
        .section-home, .top-oke {
            position: absolute;
            top: 72px;
            left: 27px;
            font-size: 11px;
        }
        .section-home, .top-right {
            position: absolute;
            top: 68px;
            right: 16px;
            font-size: 11px;
            font-weight: bold;
        }
        .section-home, .top-balance {
            position: absolute;
            top: 90px;
            left: 16px;
            font-size: 17px;
            font-weight: bold;
        } 
        .section-home, .top-coin {
            position: absolute;
            top: 105px;
            right: 16px;
            font-size: 10px;
            font-weight: bold;
        }
        .section-home, span {
            position: absolute;
            top: 7px;
            left: 15px;
            font-size: 18px;
            font-weight: bold;
        
        }
        .container {
            position: relative;
            text-align: center;
            color: white;
        }
        .listview {
            border:0px;
        }
        .card .listview > li:last-child .item {
            border-radius:0px;
        }
        .head-main {
            background-color: #000957;
            width: 100%;
            background-size: cover;
            background-repeat: no-repeat;
            padding-top: 80px;
            margin-top: -55px;
            /*margin-left: 14px;*/
            margin-right: 14px;
            /*padding-bottom: 10px;*/
            /*border-radius: 20px;*/
        }
        .section-home, .top-left, .section-home, .top-balance {
            left: 28px;
        }
        .section-home, .top-right, .section-home, .top-coin {
            right: 28px;
        }
        .item.rp p {
            font-weight: 500;
            color: darkgrey;
            font-family: Arial;
            font-size: 12px;
            margin-bottom: 0;
            margin-top: 6px;
        }
        .item.rp b {
            letter-spacing: 0;
            color: #333;
        }
        
    </style> 
    <div class="section home">
             <div class="head-main pb-0">
                 <div class="top-left text-muted text-light mt-2">
                  <font style="font-size: 10px; color: #fff;">Cash</font>
                </div>
                <div class="top-oke text-muted text-light mt-2">
                    <font style="font-size: 10px; color: #fff;">Total saldo</font>
                </div>
                <div class="top-balance text-muted text-light mt-2">
                   <font style="font-size: 13px; color: #fff;">Rp</font> <font style="font-size: 20px; color: #fff;"><b><?= currency($data_user['balance']) ?></b></font>
                </div>
                
                <div class="top-right text-muted text-light">
                </div>
                <div class="top-coin text-muted text-light mt-1">
                   <a style="background: #FFFFFF; border-radius: 15px; margin: 0px 0px 0px 0px; padding: 6px; height: 25px;" href="/premium/tukar-poin" class="headerButton">
                       <img src="<?= assets('images/icon/poin.png') ?>" width="20px" height="19px">&nbsp;<font style="color : #3E00A3;">DEGIPAY</font></a>
                 </div>
                <div class="card" style="background : transparent; border-radius: 25px; margin: 15px; box-shadow: none">
                    <div class="menu-list" style="border-top: 0; ; color: white;">
                        <div class="app-menu mt-0">
                            <a href="/deposit" class="item">
                              <div class="col mb-1" style="font-size:10px">
                                <img src="/library/assets/images/header-new/isisaldo.png" style="width: 26px;height: 26px;"><strong style="color : white;">Top Up</strong>
                              </div>
                            </a>
                            <?php if($data_user['level'] === 'Premium'): ?>
                            <a href="#" class="item" data-toggle="modal" data-target="#transfer">
                               <div class="col mt-1" style="font-size:10px">
                                <img src="/library/assets/images/header-new/kirim.png" style="width: 24px;height: 24px;"><strong style="color : white;">Transfer</strong>
                               </div>
                            </a>
                            <?php endif; ?>
                            <?php if($data_user['level'] === 'Admin'): ?>
                            <a href="#" class="item" data-toggle="modal" data-target="#transfer">
                               <div class="col mb-1" style="font-size:10px">
                                <img src="/library/assets/images/header-new/kirim.png" style="width: 24px;height: 24px;"><strong style="color : white;">Transfer</strong>
                               </div>
                            </a>
                            <?php endif; ?>
                            <?php if($data_user['level'] === 'Basic'): ?>
                            <a href="#" class="item" data-toggle="modal" data-target="#premium">
                               <div class="col mb-1" style="font-size:10px">
                                <img src="/library/assets/images/header-new/kirim.png" style="width: 24px;height: 24px;"><strong style="color : white;">Transfer</strong>
                               </div>
                           <?php endif; ?>
                          </a>
                            <?php if($data_user['level'] === 'Premium'): ?>
                            <a href="/premium" class="item">
                               <div class="col mb-1" style="font-size:10px">
                                <img src="/library/assets/images/header-new/komisi.png" style="width: 22px;height: 22px;"><strong style="color : white;">Komisi</strong>
                               </div>
                            </a>
                            <?php endif; ?>
                            <?php if($data_user['level'] === 'Admin'): ?>
                            <a href="/premium" class="item">
                               <div class="col mb-1" style="font-size:10px">
                                <img src="/library/assets/images/header-new/komisi.png" style="width: 22px;height: 22px;"><strong style="color : white;">Komisi</strong>
                               </div>
                            </a>
                            <?php endif; ?>
                            <?php if($data_user['level'] === 'Basic'): ?>
                            <a href="#" class="item" data-toggle="modal" data-target="#premium">
                               <div class="col mb-1" style="font-size:10px">
                                <img src="/library/assets/images/header-new/komisi.png" style="width: 22px;height: 22px;"><strong style="color : white;">Komisi</strong>
                               </div>
                           <?php endif; ?>
                            <a href="<?= base_url('page/riwayat'); ?>" class="item">
                               <div class="col mb-1" style="font-size:10px">
                                <img src="/library/assets/images/header-new/riwayat.png" style="width: 23px;height: 23px;"><strong style="color : white;">History</strong>
                            </div>
                            </a>
                        </div>
                    </div>
                </div>
             </div>
             
        

        <?php if($data_user['level'] === 'Basic'): ?>
            <a href="<?= base_url('account/premium') ?>">
                <div class="alert mt-2 mr-2 ml-2 mb-2" role="alert" style="background: #E0E5F8; border-radius: 8px; text-decoration: none;">
                    <div style="display: inline-flex; justify-content: space-between; align-items: center; width: 100%;">
                        <div style="display: inline-flex; justify-content: space-between; align-items: center;">
                            <ion-icon name="rocket-outline" style="font-size: 26px; padding-right: 12px;"></ion-icon>
                            <div class="in">
                                <div style="font-size: 14px; font-weight: 600;">Upgrade ke Akun Premium</div>
                                <div>Dapatkan keuntungan lebih banyak!</div>
                            </div>
                        </div>
                        <div style="position: absolute; right: 6px; font-size: 26px;"><ion-icon name="chevron-forward-outline"></ion-icon></div>
                    </div>
                </div>
                </a>
                <?php endif; ?>
            
            
        <?php if($data_verikasi_user['status'] === 'process'): ?>
            <a href="<?= base_url('account/premium') ?>">
                <div class="alert mt-2 mr-2 ml-2 mb-2" role="alert" style="background: #C2AFE9; border-radius: 8px; text-decoration: none;">
                    <div style="display: inline-flex; justify-content: space-between; align-items: center; width: 100%;">
                        <div style="display: inline-flex; justify-content: space-between; align-items: center;">
                            <ion-icon name="rocket-outline" style="font-size: 26px; padding-right: 12px;"></ion-icon>
                            <div class="in">
                                <div style="font-size: 14px; font-weight: 600;">Upgrade ke Akun Premium</div>
                                <div>Dapatkan keuntungan lebih banyak!</div>
                            </div>
                        </div>
                        <div style="position: absolute; right: 6px; font-size: 26px;"><ion-icon name="chevron-forward-outline"></ion-icon></div>
                    </div>
                </div>
                </a>
                <?php endif; ?>

        <div id="appCapsule" class="bg-white" style="border-radius: 20px 20px 0px 0px; padding:1px 10px 24px 10px;">
            <div class="section mb-2 mt-1">
                <? require _DIR_('library/session/result-mobile') ?>
            </div>
            
            <a href="#">
                <div class="alert alert-outline p-1 mt-2 mr-2 ml-2 pb-1 text-white" role="alert" style="border-radius: 50px; text-decoration: none;">
                    <div style="display: inline-flex; justify-content: space-between; align-items: center; width: 100%; backgroud: white;">
                        <div style="display: inline-flex; justify-content: space-between; align-items: center;">
                            <div class="icon">
                                <ion-icon name="notifications" style="font-size: 26px; padding-right: 12px; color: #3E00A3;"></ion-icon>
                            </div>
                            <div class="in">
                                <marquee scrollamount="10">
                             <font style = " font-size: 15px; color: #3E00A3;"> <?= conf('text-marquee',c1) ?>  </font> 
	                            </marquee>
                            </div>
                        </div>
                    </div>
                </div>
            </a>

            <div class="menu-list pb-0" style="border-top: 0 !important; border-radius: 20px;">
                <div class="app-menu">
                    <a href="<?= base_url('order/pulsa-reguler') ?>" class="item">
                        <div class="col">
                            <img src="<?= assets('mobile/icon/png/new/pulsa-reguler.png') ?>" width="64px" height="64px">
                            <strong style="color: #444444">Pulsa Reguler</strong>
                        </div>
                    </a>

                    <a href="<?= base_url('order/paket-telp') ?>" class="item">
                        <div class="col">
                            <img src="<?= assets('mobile/icon/png/new/sms.png') ?>" width="64px" height="64px">
                            <strong>Telpon&Sms</strong>
                        </div>
                    </a>
                    <a href="<?= base_url('order/paket-internet') ?>" class="item">
                        <div class="col">
                            <img src="<?= assets('mobile/icon/png/new/paket-data.png') ?>" width="64px" height="64px">
                            <strong> Paket Data</strong>
                        </div>
                    </a>
                
                    <a href="<?= base_url('order/games') ?>" class="item">
                        <div class="col">
                            <img src="<?= assets('mobile/icon/png/new/games.png') ?>" width="64px" height="64px">
                            <strong>Games</strong>
                        </div>
                    </a>
                    
                </div>
                <div class="app-menu mt-4 mb-2">
                    <a href="<?= base_url('page/menu') ?>" class="item">
                    <div class="col">
                        <img src="<?= assets('mobile/icon/png/new/wallet.png') ?>" width="64px" height="64px">
                        <strong>E-Money</strong>
                    </div>
                    </a>
                    <a href="<?= base_url('order/aktivasi-perdana.php') ?>" class="item">
                        <div class="col">
                            <img src="<?= assets('mobile/icon/png/new/voucher.png') ?>" width="64px" height="64px">
                            <strong>Aktivasi Perdana</strong>
                        </div>
                    </a>
                    <a href="<?= base_url('order/token-pln') ?>" class="item">
                        <div class="col">
                            <img src="<?= assets('mobile/icon/png/new/listrik.png') ?>" width="64px" height="64px">
                            <strong>Token PLN</strong>
                        </div>
                    </a> 
                    <div class="item"  data-toggle="modal" data-target="#menu">
                        <div class="col">
                            <img src="<?= assets('mobile/icon/png/new/menu.png') ?>" width="64px" height="64px">
                            <strong>Lainnya</strong>
                        </div>
                    </a>
                   </div>
                </div>
            </div>
        </div>
    </div>
        <!-- Menu Class -->
        <div class="modal fade action-sheet" id="menu" tabindex="-1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="pr-5"></div>
                        <h5 class="modal-title">Pilih Produk</h5>
                    </div>
                    <div class="modal-body">
                                <div class="menu-list mt-1" style="border-top: 0 !important; border-radius: 20px !important;">
                <div class="app-menu">
                    <a href="<?= base_url('order/pulsa-reguler') ?>" class="item">
                        <div class="col"> 
                        <span class="btn btn-danger btn-status rounde">Promo</span>
                            <img src="<?= assets('mobile/icon/png/new/pulsa-reguler.png') ?>" width="60px" height="60px">
                            <strong style="color: #444444">Pulsa Reguler</strong>
                        </div>
                    </a>
                    <a href="<?= base_url('order/paket-internet') ?>" class="item">
                        <div class="col"> 
                            <span class="btn btn-danger btn-status rounde">Promo</span>
                            <img src="<?= assets('mobile/icon/png/new/paket-data.png') ?>" width="60px" height="60px">
                            <strong style="color: #444444;">Paket Data</strong>
                        </div>
                    </a> 
                    <a href="<?= base_url('order/pulsa-transfer') ?>" class="item">
                        <div class="col"> 
                        <span class="btn btn-danger btn-status rounde text-center">Promo</span>
                            <img src="<?= assets('mobile/icon/png/new/pulsa-transfer.png') ?>" width="60px" height="60px">
                            <strong>Pulsa Transfer</strong>
                        </div>
                    </a>
                
                 <a href="<?= base_url('order/paket-telp') ?>" class="item">
                        <div class="col">
                            <img src="<?= assets('mobile/icon/png/new/sms.png') ?>" width="60px" height="60px">
                            <strong>Sms & Telp</strong>
                        </div>
                    </a>
                    
                </div>
                <div class="app-menu mt-4 mb-2">
                    <a href="<?= base_url('order/token-pln') ?>" class="item">
                    <div class="col">
                        <img src="<?= assets('mobile/icon/png/new/listrik.png') ?>" width="60px" height="60px">
                        <strong>Token Pln</strong>
                    </div>
                    </a>
                       <a href="<?= base_url('page/menu') ?>" class="item">
                        <div class="col">
                            <img src="<?= assets('mobile/icon/png/new/wallet.png') ?>" width="60px" height="60px">
                            <strong>E-Money</strong>
                        </div>
                    </a> 
                    <a href="<?= base_url('order/voucher') ?>" class="item">
                        <div class="col">
                            <img src="<?= assets('mobile/icon/png/new/voucher.png') ?>" width="60px" height="60px">
                            <strong>Voucher Data</strong>
                        </div>
                    </a> 
                    <a href="<?= base_url('order/games') ?>" class="item">
                        <div class="col">
                            <img src="<?= assets('mobile/icon/png/new/games.png') ?>" width="60px" height="60px">
                            <strong>Game</strong>
                        </div>
                    </a>
                    
                </div>
                <div class="app-menu mt-4 mb-2"> 
                <?php 
                    $search = $call->query("SELECT * FROM srv WHERE type = 'pascabayar' AND brand IN ('PLN PASCABAYAR') AND kategori = 'Umum' GROUP BY brand ORDER BY name ASC");
                    while($row = $search->fetch_assoc()) { 
                    $code = str_replace('.', '=', str_replace(' ', '-', strtolower($row['brand'])));
                ?>
                    <a href="<?= base_url('order/pascabayars/'.$code) ?>" class="item">
                    <div class="col">
                        <img src="<?= assets('images/pascabayar/'.$code.'.png').'?'.time() ?>" width="60px" height="60px">
                        <strong>Pln Pascabayar</strong>
                    </div>
                    </a> 
                <?php } ?>
                <?php 
                    $search = $call->query("SELECT * FROM srv WHERE type = 'pascabayar' AND brand IN ('PDAM') AND kategori = 'Umum' GROUP BY brand ORDER BY name ASC");
                    while($row = $search->fetch_assoc()) { 
                    $code = str_replace('.', '=', str_replace(' ', '-', strtolower($row['brand'])));
                ?>    
                       <a href="<?= base_url('order/pascabayars/'.$code) ?>" class="item">
                        <div class="col">
                            <img src="<?= assets('images/pascabayar/'.$code.'.png').'?'.time() ?>" width="60px" height="60px">
                            <strong>Pdam</strong>
                        </div>
                    </a>  
                <?php } ?>
                <?php 
                    $search = $call->query("SELECT * FROM srv WHERE type = 'pascabayar' AND brand IN ('GAS NEGARA') AND kategori = 'Umum' GROUP BY brand ORDER BY name ASC");
                    while($row = $search->fetch_assoc()) { 
                    $code = str_replace('.', '=', str_replace(' ', '-', strtolower($row['brand'])));
                ?>    
                    <a href="<?= base_url('order/pascabayars/'.$code) ?>" class="item">
                        <div class="col">
                            <img src="<?= assets('images/pascabayar/'.$code.'.png').'?'.time() ?>" width="60px" height="60px">
                            <strong>Gas</strong>
                        </div>
                    </a> 
                <?php } ?>
                <?php 
                    $search = $call->query("SELECT * FROM srv WHERE type = 'pascabayar' AND brand IN ('PBB') AND kategori = 'Umum' GROUP BY brand ORDER BY name ASC");
                    while($row = $search->fetch_assoc()) { 
                    $code = str_replace('.', '=', str_replace(' ', '-', strtolower($row['brand'])));
                ?>    
                    <a href="<?= base_url('order/pascabayars/'.$code) ?>" class="item">
                        <div class="col">
                            <img src="<?= assets('images/pascabayar/'.$code.'.png').'?'.time() ?>" width="60px" height="60px">
                            <strong>PBB</strong>
                        </div>
                    </a>
                <?php } ?>    
                </div>
                <div class="app-menu mt-4 mb-2"> 
                <?php 
                    $search = $call->query("SELECT * FROM srv WHERE type = 'pascabayar' AND brand IN ('BPJS KESEHATAN') AND kategori = 'Umum' GROUP BY brand ORDER BY name ASC");
                    while($row = $search->fetch_assoc()) { 
                    $code = str_replace('.', '=', str_replace(' ', '-', strtolower($row['brand'])));
                ?>
                    <a href="<?= base_url('order/pascabayars/'.$code) ?>" class="item">
                    <div class="col">
                        <img src="<?= assets('images/pascabayar/'.$code.'.png').'?'.time() ?>" width="60px" height="60px">
                        <strong>Bpjs Kesehatan</strong>
                    </div>
                    </a> 
                <?php } ?>
                <?php 
                    $search = $call->query("SELECT * FROM srv WHERE type = 'pascabayar' AND brand IN ('INTERNET PASCABAYAR') AND kategori = 'Umum' GROUP BY brand ORDER BY name ASC");
                    while($row = $search->fetch_assoc()) { 
                    $code = str_replace('.', '=', str_replace(' ', '-', strtolower($row['brand'])));
                ?>    
                       <a href="<?= base_url('order/pascabayars/'.$code) ?>" class="item">
                        <div class="col">
                            <img src="<?= assets('images/pascabayar/'.$code.'.png').'?'.time() ?>" width="60px" height="60px">
                            <strong>Internet Pascabayar</strong>
                        </div>
                    </a> 
                <?php } ?>
                <?php 
                    $search = $call->query("SELECT * FROM srv WHERE type = 'pascabayar' AND brand IN ('MULTIFINANCE') AND kategori = 'Umum' GROUP BY brand ORDER BY name ASC");
                    while($row = $search->fetch_assoc()) { 
                    $code = str_replace('.', '=', str_replace(' ', '-', strtolower($row['brand'])));
                ?>    
                    <a href="<?= base_url('order/pascabayars/'.$code) ?>" class="item">
                        <div class="col">
                            <img src="<?= assets('images/pascabayar/'.$code.'.png').'?'.time() ?>" width="60px" height="60px">
                            <strong>Multifinance</strong>
                        </div>
                    </a>  
                <?php } ?>
                <?php 
                    $search = $call->query("SELECT * FROM srv WHERE type = 'pascabayar' AND brand IN ('HP PASCABAYAR') AND kategori = 'Umum' GROUP BY brand ORDER BY name ASC");
                    while($row = $search->fetch_assoc()) { 
                    $code = str_replace('.', '=', str_replace(' ', '-', strtolower($row['brand'])));
                ?>    
                    <a href="<?= base_url('order/pascabayars/'.$code) ?>" class="item">
                        <div class="col">
                            <img src="<?= assets('images/pascabayar/'.$code.'.png').'?'.time() ?>" width="60px" height="60px">
                            <strong>Hp Pascabayar</strong>
                        </div>
                    </a>
                <?php } ?>    
                </div>
                <div class="app-menu mt-4 mb-2">
                    <a href="<?= base_url('order/voucher') ?>" class="item">
                    <div class="col">
                        <img src="<?= assets('mobile/icon/png/new/voucher.png') ?>" width="60px" height="60px">
                        <strong>Voucher Lainnya</strong>
                    </div>
                    </a> 
                    <a href="<?= base_url('order/inject-voucher') ?>" class="item">
                    <div class="col">
                        <img src="<?= assets('mobile/icon/png/new/voucher.png') ?>" width="60px" height="60px">
                        <strong>Inject Voucher</strong>
                    </div>
                    </a>
                    <a href="<?= base_url('order/voucher-tv') ?>" class="item">
                    <div class="col">
                        <img src="<?= assets('mobile/icon/png/new/v-tv.png') ?>" width="60px" height="60px">
                        <strong>Voucher Tv</strong>
                    </div>
                    </a> 
                    <a href="<?= base_url('order/masa-aktif') ?>" class="item">
                    <div class="col">
                        <img src="<?= assets('mobile/icon/png/new/sim-card.png') ?>" width="60px" height="60px">
                        <strong>Masa Aktif</strong>
                    </div>
                    </a>
                </div>
            </div>
            </div><br>
                  </br>  </div>
                </div>
            </div>
        </div>
    
   <!-- end -->
    
        <div class="section full mb-1 bg-white mt-1 pt-1 pb-2" style="padding-left: 10px;padding-right: 10px;">
        <?php 
        $slider = $call->query("SELECT * FROM news_promo ORDER BY id ASC LIMIT 5");
        if($slider->num_rows !== 0):
        ?>
            <div class="carousel-full owl-carousel owl-theme">
                <?php while($slide = $slider->fetch_assoc()): ?>
                <div class="item" style="margin-left: 6px;margin-right: 6px;">
                    <a href="<?= base_url('page/promo'); ?>">
                    <img src="<?= assets('images/news/'.$slide['banner']) ?>" alt="Mauaja Image" class="imaged w-70">
                    </a>
                </div>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>
        </div>
        
        <div class="section bg-white mt-1 pt-1" style="padding-bottom: 1px;">
            <div class="section-title">Rekomendasi Pilihan</div>
            <div class="owl-carousel owl-theme mb-2" id="rp">
                <?php 
                $qpost = mysqli_query($call, "SELECT * FROM post ORDER BY id DESC");
                while($fpost = mysqli_fetch_assoc($qpost)):
                ?>
                <div class="item rp">
                    <a href="/page/post?id=<?= $fpost['id']; ?>" class="text-decoration-none">
                        <img src="library/assets/images/post/<?= $fpost['image']; ?>" class="w-100 rounded-2">
                        <p><?= $fpost['category']; ?></p>
                        <b><?= $fpost['title']; ?></b>
                    </a>
                </div>
                <?php endwhile; ?>
            </div>
        </div>

        <div class="section full mb-1 bg-white mt-1 pt-1 pb-2" style="padding-left: 10px;padding-right: 10px; border-radius: 10px">
            <div class="section-title"><h4>Hanya Untukmu<b></b></h4> <a href="/referral" class="text-primary" style="font-weight:600;padding:6px;">Lihat</a></div>
            <p class="text-dark" style="font-size: 12px; position: absolute; left: 23px; margin-top: -20px;">Masih butuh lebih? Cari aja di sini!</p>
                <div class="row" style="margin-top: 20px;">
                    <div class="col-12">
                        <a class="text-decoration-none" href="/referral">
                        <div class="table-responsive" style="height: 100%; border-radius: 10px;">
                            <table class="table table-borderless bg-primary">
                                <tr>
                                    <th style="max-width: 115px;"><img src="<?= assets('mobile/img/svg/had.png') ?>" style="width:110px;"></th>
                                    <td>
                                        <p style="font-size:16px; font-weight:bold;margin-top: 10px;margin-bottom:3px;color:white;">Kode Referral</p>
                                        <p style="font-size:14px; color:white;">Bagikan kode referral supaya untung bareng teman-temanmu!</p>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        </a>
                    </div>
                </div>
            </div>
        
        <div class="section full mb-1 bg-white mt-1" style="border-radius: 10px">
        <div class="section-title"style="font-size: 14px;">Kenali Keunggulan <?= $_CONFIG['title'] ?> Lebih Dekat</div>
        <?php 
        $slider = $call->query("SELECT * FROM slider WHERE status = '1' AND type = 'Vertical' ORDER BY id ASC LIMIT 10");
        if($slider->num_rows !== 0):
        ?>
            <div class="carousel-multiple owl-carousel owl-theme">
                <?php while($slide = $slider->fetch_assoc()): ?>
                <div class="item">
                    <img src="<?= assets('images/slider/'.$slide['img']) ?>" alt="Plisspa Banner" class="imaged w-100" style="width: 105px;height: 161px;">
                </div>
                <?php endwhile; ?>
            </div>

        <?php endif; ?>
        </div>

        <div class="section full rgs-info bg-white" style="padding-bottom: 80px; margin-top: 29px"></div>
            
    <!-- * App Capsule -->

    <div class="modal fade action-sheet" id="premium" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content" style="background-color: #00000080;">
                <div class="modal-body">
                    <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
                        <div class="form-bottom-fixed pb-2">
                            <div class="form-group basic pb-0">
                                <div class="input-wrapper"> 
                                    <img src="<?= assets('mobile/icon/premium.svg') ?>" style="height: 11rem" >
                                </div>
                                <div class="section center mt-1">
                                    <p style="font-weight: 400; font-size: 15px" class="text-dark text-center text-bold">Upgrade Premium Dulu Yah!</p>
                                   <!-- <p style="font-weight: 400; font-size: 12px" class="text-dark text-center">Lengkapi data diri dengan benar dan pastikan valid</p> -->
                                </div>
                            </div>
                            <a href="<?= base_url('account/premium') ?>" class="btn rounded btn-primary btn-block btn-lg"> Verfikasi Sekarang </a>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
   <!-- VALUE TRANSFER --> 
   <div class="modal fade action-sheet" id="transfer" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content" style="background-color: #00000080;">
                <div class="modal-body">
                    <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
                        <div class="form-bottom-fixed">
                            <div class="form-group basic pb-0">
                                <div class="input-wrapper"> 
                                    <img src="<?= assets('mobile/icon/payment.svg') ?>" style="height: 11rem" >
                                </div>
                                <div class="section center mt-1">
                                    <p style="font-weight: 400; font-size: 15px" class="text-dark text-center text-bold">Transfer Kemana  nihh?</p>
                                   <!-- <p style="font-weight: 400; font-size: 12px" class="text-dark text-center">Lengkapi data diri dengan benar dan pastikan valid</p> -->
                                </div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <a href="<?= base_url('deposit/transfer') ?>" class="btn rounded btn-primary btn-block btn-lg m-1 mb-0">Member</a>
                                <a href="<?= base_url('transfer') ?>" class="btn rounded btn-primary btn-block btn-lg m-1 mb-0">Bank</a>
                                <!--<button type="submit" class="btn rounded btn-primary btn-block btn-lg m-1 mb-0" name="buypostpaid" onclick="var e=this;setTimeout(function(){e.disabled=true;},0); -->
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--  PENGUMUMAN  
<div class="modal fade" id="modal-alert" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
          <img src="<?= assets('images/popup/banner.jpg') ?>" class="imaged w-100"  style="width: 150px; height: 350px;">
  </div>
</div>
    
<script>
        $(document).ready(function() {
            $('.urgent-alert').addClass('show');
        });
        $("#modal-alert").modal('show');
    </script> -->
<?php } } require _DIR_('library/footer/user') ?>

 
   