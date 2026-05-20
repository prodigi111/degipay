<?php
require '../connect.php';
require _DIR_('library/session/user');
$page = 'Upgrade Premium';
require _DIR_('library/header/user'); 
if(in_array($data_user['level'],['Premium','Admin'])) {
    $_SESSION['result'] = ['type' => false,'message' => 'Kamu Sudah Level Premium!'];
    redirect(0, base_url());
}
?>
<style>
    .listview > li:after {
        height :0px;
    }
    .image-listview > li .item .icon-box {
        min-width:50px;
        max-width:50px;
        width:50px;
        height:50px;
    }
    .listview {
        border:0px;
    }
</style>

    <!-- App Capsule -->
    <div id="appCapsule" class="information pb-0">
        <div class="section full">
            <? if( $data_user['level'] == 'Basic' ): ?>
            <img src="<?= assets('/images/background/upgrade.jpg'); ?>" alt="RGS-Banner" class="imaged img-fluid square">
            <center class="pt-5">
                <h3>Upgrade ke Akun Premium, yuk!</h3>
                <p>Nikmati akses lengkap keseluruh layanannya</p>
            </center>
            <ul class="listview image-listview">
                <li>
                    <div class="item">
                        <div class="icon-box bg-upgrade-primary">
                            <ion-icon name="archive-outline" class="text-primary" style="font-size:25px;"</ion-icon>
                        </div>
                        <div class="in" style="display:block">
                            <h4 class="mb-0">
                                <b>Kirim uang dengan mudah</b>
                            </h4>
                            <p class="mb-0" style="font-size:13px;color:#4F5050">Transfer sesama member <?= $_CONFIG['title'] ?></p>
                        </div>
                    </div>
                </li>
                <li height="0px">
                    <div class="item">
                        <div class="icon-box bg-upgrade-gold">
                            <ion-icon name="ribbon-outline" class="text-gold" style="font-size:25px;"</ion-icon>
                        </div>
                        <div class="in" style="display:block">
                            <h4 class="mb-0">
                                <b>Cashback Lebih</b>
                            </h4>
                            <p class="mb-0" style="font-size:13px;color:#4F5050">Keuntungan tambahan hanya untukmu.</p>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="item">
                        <div class="icon-box bg-upgrade-success">
                            <ion-icon name="cash-outline" class="text-success" style="font-size:25px;"</ion-icon>
                        </div>
                        <div class="in" style="display:block">
                            <h4 class="mb-0">
                                <b>Saldo Maksimal</b>
                            </h4>
                            <p class="mb-0" style="font-size:13px;color:#4F5050">Batas maksimal saldo hingga Rp 10 juta.</p>
                        </div>
                    </div>
                </li>
            </ul>
            <div class="pt-1 pb-1 form-bottom-fixed">
                <a href="<?= base_url('account/upgrade') ?>" class="btn bg-primary rounded shadowed btn-block mt-1 mb-1">Daftar Sekarang</a>
            </div>
            <? endif ?>
        </div>
    </div>
    <!-- * App Capsule -->
<?php require _DIR_('library/footer/user') ?>