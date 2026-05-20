<?php
require '../RGShenn.php';
require _DIR_('library/session/user');
$page = 'Akun Saya';
$pengeluaran = $call->query("SELECT SUM(mutation.amount) AS total FROM mutation WHERE type = '-' AND user = '$sess_username' AND kategori IN ('Transaksi', 'Deposit', 'Lainnya', 'Tarik Komisi')")->fetch_assoc()['total'];
$pemasukkan  = $call->query("SELECT SUM(mutation.amount) AS total FROM mutation WHERE type = '+' AND user = '$sess_username' AND kategori IN ('Transaksi', 'Deposit', 'Lainnya', 'Tarik Komisi')")->fetch_assoc()['total'];
require _DIR_('library/header/user');
?>
    <style>
        .section.home {
            /*background-image: url("/library/assets/images/background/texture-full-purple.jpg") !important;*/
            /*background-repeat: no-repeat !important;*/
            /*background-size: cover !important;*/
            background-color : #000957;
            padding:-50px 0px 30px;
            margin-bottom:-10px; 
        }
        
        .section.profile {
            padding-top: 30px;
            padding-bottom: 17px;
        }

        .section.profile .profile-head {
            display: block;
            text-align: center;
        }
    </style>
    <!-- App Capsule -->
    <div class="" id="appCapsule" class="rgs-pembayaran">
      <div class="section home profile">
            <div class="profile-head">
                <? if( $data_user['status_photo'] == 'Yes' ): ?>
                <div class="avatar mr-0">
                    <img src="<?= assets('images/user/'.$data_user['photo'].'').'?'.time() ?>" class="imaged w64 rounded">
                </div>
                <? else: ?>
                <div class="avatar mr-0">
                    <img src="<?= assets('images/user/default.jpg').'?'.time() ?>" class="imaged w64 rounded">
                </div> 
                <? endif ?>
                <div class="section pb-10">
                    <? if($data_user['level'] == 'Basic') : ?>
                    <h3 class="name text-light m-0 bold"><?= $data_user['name'] ?></h3>
                    <? endif; ?>
                    <? if($data_user['level'] == 'Admin') : ?> 
                    <h3 class="name text-light m-0 bold"><?= $data_user['name'] ?> <img src="<?= assets('images/user/pre.svg').'?'.time() ?> "width="10px" height="10px"></h3>
                    <? endif; ?>
                    <? if($data_user['level'] == 'Premium') : ?> 
                    <h3 class="name text-light m-0 bold"><?= $data_user['name'] ?> <img src="<?= assets('images/user/pre.svg').'?'.time() ?> "width="10px" height="10px"></h3>
                    <? endif; ?>
                    
                    <h5 class="subtext text-light"><?= explode(substr($data_user['phone'], '4', '4'), $data_user['phone'])['0'].'&bull;&bull;&bull;&bull;'.explode(substr($data_user['phone'], '4', '4'), $data_user['phone'])['1'] ?></h5>
                    <!--
                    <? if($data_user['level'] == 'Basic') : ?>
                    <a href="<?= base_url('account/upgrade.php') ?>" class="btn btn-success btn-sm mt-1">
                        <ion-icon name="rocket"></ion-icon>
                        Upgrade Ke Premium
                    </a>
                    <? endif; ?>
                    -->
                </div>
            </div>
      </div>  
        <div class="section mt-0 mb-0">
        <ul class="listview image-listview" style="border-radius: 10px">
            <li class="profile-menu">
                <div class="money-info" >
                    <a href="#" class="item">
                        <div class="icon-box bg-success">
                            <ion-icon name="arrow-up-outline"></ion-icon>
                        </div>
                        <div class="in">
                            <div class="title">Pemasukan</div>
                            <div class="subtitle text-blue">Rp <?= currency($pemasukkan) ?></div>
                        </div>
                    </a>
                    <a href="#" class="item">
                        <div class="icon-box bg-warning">
                            <ion-icon name="arrow-down-outline"></ion-icon>
                        </div>
                        <div class="in">
                            <div class="title">Pengeluaran</div>
                            <div class="subtitle text-blue">Rp <?= currency($pengeluaran) ?></div>
                        </div>
                    </a>
                </div>
            </li>
            <li class="profile-menu">
                <a href="<?= base_url('deposit/') ?>" class="item">
                    <div class="icon-box bg-transparent">
                        <ion-icon name="cash-outline" class="text-primary"></ion-icon>
                    </div>
                    <div class="in">
                        <div>Saldo</div>
                        <span class="text-primary">Rp <?= currency($data_user['balance']) ?></span>
                    </div>
                </a>
            </li>
            <li>
                <!--
                <a href="<?= base_url('premium/') ?>" class="item">
                    <div class="icon-box bg-transparent">
                        <ion-icon name="ribbon-outline" class="text-success"></ion-icon>
                    </div>
                    <div class="in">
                        <div>Level</div>
                        <span class="text-success"><?= $data_user['level'] ?></span>
                    </div>
                </a>
            </li>
            -->
            <li class="profile-menu">
                <a href="<?= base_url('account/card') ?>" class="item">
                    <div class="icon-box bg-transparent">
                        <ion-icon name="card" class="text-warning"></ion-icon>
                    </div>
                    <div class="in">
                        <div>Kartu Saya</div>
                    </div>
                </a>
            </li>
        </ul>
        </div>
     
        <div class="listview-title "></div>
        <div class="section mt-0 mb-0">
        <ul class="listview image-listview" style="border-radius: 10px">
            <?php if($data_user['level'] === 'Basic'): ?>
            <li class="profile-menu">
                <a href="#" data-toggle="modal" data-target="#premium" class="item">
                    <div class="icon-box bg-transparent">
                        <ion-icon name="archive" class="text-success"></ion-icon>
                    </div>
                    <div class="in">
                        <div>Transfer</div>
                    </div>
                </a>
            </li> 
            <?php endif; ?>
            <?php if($data_user['level'] === 'Premium'): ?>
            <li class="profile-menu">
                <a href="<?= base_url('deposit/transfer') ?>" class="item">
                    <div class="icon-box bg-transparent">
                        <ion-icon name="archive" class="text-success"></ion-icon>
                    </div>
                    <div class="in">
                        <div>Transfer</div>
                    </div>
                </a>
            </li>
            <?php endif; ?>
            <?php if($data_user['level'] === 'Admin'): ?>
            <li class="profile-menu">
                <a href="<?= base_url('deposit/transfer') ?>" class="item">
                    <div class="icon-box bg-transparent">
                        <ion-icon name="archive" class="text-success"></ion-icon>
                    </div>
                    <div class="in">
                        <div>Transfer</div>
                    </div>
                </a>
            </li>
            <?php endif; ?>
            <!--
            <li class="profile-menu">
                <a href="<?= base_url('deposit/voucher') ?>" class="item">
                    <div class="icon-box bg-transparent">
                        <ion-icon name="ticket" class="text-primary"></ion-icon>
                    </div>
                    <div class="in">
                        <div>Voucher</div>
                    </div>
                </a>
            </li>
            -->
            <?php if($data_user['level'] === 'Basic'): ?>
            <li class="profile-menu">
                <a href="#" data-toggle="modal" data-target="#premium" class="item">
                    <div class="icon-box bg-transparent">
                        <ion-icon name="gift" class="text-warning"></ion-icon>
                    </div>
                    <div class="in">
                        <div>Referral</div>
                    </div>
                </a>
            </li>
            <?php endif; ?>
            <?php if($data_user['level'] === 'Premium'): ?>
            <li class="profile-menu">
                <a href="<?= base_url('/referral') ?>" class="item">
                    <div class="icon-box bg-transparent">
                        <ion-icon name="gift" class="text-warning"></ion-icon>
                    </div>
                    <div class="in">
                        <div>Referral</div>
                    </div>
                </a>
            </li>
            <?php endif; ?>
            <?php if($data_user['level'] === 'Admin'): ?>
            <li class="profile-menu">
                <a href="<?= base_url('/referral') ?>" class="item">
                    <div class="icon-box bg-transparent">
                        <ion-icon name="gift" class="text-warning"></ion-icon>
                    </div>
                    <div class="in">
                        <div>Referral</div>
                    </div>
                </a>
            </li>
            <?php endif; ?>
            <li class="profile-menu">
                <a href="<?= base_url('page/riwayat') ?>" class="item">
                    <div class="icon-box bg-transparent">
                        <ion-icon name="receipt" class="text-success"></ion-icon>
                    </div>
                    <div class="in">
                        <div>Riwayat</div>
                    </div>
                </a>
            </li> 
            <!--
            <li class="profile-menu">
                <a href="<?= base_url('page/banner') ?>" class="item">
                    <div class="icon-box bg-transparent">
                        <ion-icon name="tv" class="text-danger"></ion-icon>
                    </div>
                    <div class="in">
                        <div>Spanduk</div>
                    </div>
                </a>
            </li> 
            -->
        </ul>
        </div>
        <div class="listview-title pb-0"></div>
        <div class="section mt-0 mb-0">
        <ul class="listview image-listview" style="border-radius: 10px">
            <li class="profile-menu">
               <a href="<?= base_url('account/settings') ?>" class="item">
                    <div class="in">
                        <div>Pengaturan Profil</div>
                    </div>
                </a>
            </li>
            <li class="profile-menu">
                <div class="item">
                    <div class="in">
                        <div>Versi App</div>
                        <span class="text-muted fs-normal">7.2.4</span>
                    </div>
                </div>
            </li>
        </ul>
        </div>
         <div class="listview-title pb-0"></div>
         <div class="section mt-0 mb-0">
         <ul class="listview image-listview" style="border-radius: 10px">
            <li class="profile-menu">
                <a href="<?= base_url('page/help-center.php') ?>" class="item">
                    <div class="in">
                        <div>Pusat Bantuan</div>
                    </div>
                </a>
            </li>
            <!--
            <li>
                <a href="<?= base_url('page/about-us.php') ?>" class="item">
                    <div class="in">
                        <div>Tentang Kami</div>
                    </div>
                </a>
            </li>
            -->
            <li class="profile-menu">
                <a href="<?= base_url('page/terms-conditions.php') ?>" class="item">
                    <div class="in">
                        <div>Syarat & Ketentuan</div>
                    </div>
                </a>
            </li>
            <li class="profile-menu">
                <a href="<?= base_url('page/privacy-policy.php') ?>" class="item">
                    <div class="in">
                        <div>Kebijakan Privasi</div>
                    </div>
                </a>
            </li>
            <li class="profile-menu">
                <a href="<?= base_url('page/contact.php') ?>" class="item">
                    <div class="in">
                        <div>Hubungi Kami</div>
                    </div>
                </a>
            </li>
            <? if( $data_user['level'] == 'Admin' ): ?>
            <li class="profile-menu">
                <a href="<?= base_url('admin/') ?>" class="item">
                    <div class="in">
                        <div>Halaman Admin</div>
                    </div>
                </a>
            </li>
            <? endif ?>
        </ul>
        </div>
        <div class="m-2 mb-3">
            <div class="form-group">
                <a href="<?= base_url('auth/logout.php') ?>" class="btn rounded btn-primary btn-rounded btn-block btn-lg">Sign Out</a>
            </div>
        </div>
    </div>
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
                            <!--
                            <div class="d-flex justify-content-between">
                                <a href="#" class="btn rounded btn-list btn-block btn-lg text-primary m-1 mb-1" data-dismiss="modal" style="border:1px solid #5f33ba;">Batal</a>
                                <a href="#" class="btn rounded btn-primary btn-block btn-lg m-1 mb-1" >Verifikasi</a>
                            </div>
                            -->
                            <a href="<?= base_url('account/premium') ?>" class="btn rounded btn-primary btn-block btn-lg"> Verfikasi Sekarang </a>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php require _DIR_('library/footer/user') ?>