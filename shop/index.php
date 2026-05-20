<?php
require '../RGShenn.php';
require _DIR_('library/session/user');
$page = 'Shop';
require _DIR_('library/header/user');
?>

    <!-- App Capsule -->
    <div id="appCapsule" class="rgs-shop">
        
        <? $search = $call->query("SELECT * FROM produk WHERE status = 'READY' ORDER BY id DESC"); 
        if($search->num_rows == false) :
        ?>
        <div class="text-center mt-5">
            <img src="<?= assets('mobile/img/gif/notrx.gif') ?>" alt="alt" class="imaged square w200">
            <h4 class="mt-2">Produk Tidak Tersedia</h4>
        </div>
        <? else: ?>
        <div class="section mt-2">
            <div class="row">
                <?
                while($row = $search->fetch_assoc()) { ?>
                <div class="col-6 mb-2">
                    <div class="item">
                        <div class="card product-card">
                            <div class="card-body">
                                <a href="<?= base_url('shop/detail/').$row['kode'] ?>">
                                    <img src="<?= assets('images/produk/').json_decode($row['image'], TRUE)['data'][0]['image'] ?>" class="image" alt="<?= strtolower(str_replace(' ', '-', $row['nama'])) ?>">
                                    <h2 class="title"><?= substr($row['nama'], 0, +30).'....' ?></h2>
                                    <!--<p class="text"><?= nl2br(substr($row['keterangan'], 0, +30).'....') ?></p>-->
                                    <div class="price mt-1">Rp <?= currency($row['harga']) ?></div>
                                    <a href="<?= base_url('shop/detail/').$row['kode'] ?>" class="btn btn-sm btn-primary btn-block">DETAIL</a>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <? } ?>
            </div>
        </div>
        <? endif ?>
        
    </div>
    <!-- * App Capsule -->

<?php require _DIR_('library/footer/user') ?>