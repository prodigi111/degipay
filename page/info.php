<?php
require '../RGShenn.php';
$page = 'Pemberitahuan';
$news_promo = $call->query("SELECT * FROM news_promo ORDER BY id ASC LIMIT 5");

require _DIR_('library/header/user');
?>

    <!-- App Capsule -->
    <div id="appCapsule" class="extra-header-active rgs-info">
        
        <div class="tab-content mt-1">

            <!-- Informasi tab -->
            <div class="tab-pane fade active show" id="Informasi" role="tabpanel">
<?php
$search = $call->query("SELECT * FROM information ORDER BY id DESC LIMIT 20");
if($search->num_rows == false) {
    print '<div class="alert alert-primary text-left fade show mt-2 mb-2 mr-2 ml-2" role="alert">Belum Ada Informasi Terbaru</div>';
} else {
while($row = $search->fetch_assoc()) {
?>
                <div class="card">
                    <div class="card-body">
                        <ion-icon name="megaphone-outline" class="text-warning"></ion-icon>
                        <span class="title"><?= $row['title'] ?></span>
                        <span class="date"><?= format_date('en',$row['date']) ?></span>
                        <span class="content"><?= nl2br(substr($row['content'],0,+100).'.') ?> <a href="<?= base_url('page/news-detail/'.$row['id']) ?>">Selengkapnya.</a> </span>
                    </div>
                </div>
<? } } ?>

            </div>
            <!-- * Informasi tab -->

            <!-- Berita tab -->
            <div class="tab-pane fade" id="Berita" role="tabpanel">
                <style>
                    .card-title {
                        font-size: 19px !important;
                    }
                    .card-body {
                        padding: 16px !important;
                        color: #4F5050 !important;
                    }
                    .card-text {
                        font-size: 14px;
                        margin-bottom: 6px
                    }

                </style>
                    <?php if($news_promo->num_rows > 0): ?>
                    <?php while($dat = $news_promo->fetch_assoc()): ?>
                        <a href="<?= base_url('page/news-promo?id='.$dat['id']); ?>">
                            <div class="section pr-0 pl-0 mt-3 pb-3">
                                <div class="card">
                                    <img src="<?= assets('images/news/'.$dat['banner']); ?>" class="card-img-top" alt="image" style="max-height: 120px; border-bottom-left-radius: 0 !important">
                                    <div class="card-body" style="padding-top: 4px !important">
                                        <div class="pb-1">
                                            <h5 class="card-title"><?= $dat['title']; ?></h5>
                                            <?php if($dat['expired_at'] == $date) : ?>
                                            <p class="card-text mb-0"><small>Berlaku sampai hari ini</small></p>
                                            <?php else: ?>
                                                <?php if(!empty($dat['expired_at']) || $dat['expired_at'] != null): ?>
                                            <p class="card-text mb-0"><small>Berlaku sampai <?= format_date(0, $dat['expired_at']); ?></small></p>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    <?php endwhile; ?>
                    <?php else: ?>
                        <div class="text-center mt-5">
                            <img src="<?= assets('mobile/img/svg/riwayat.svg') ?>" alt="alt" class="imaged square w200">
                            <h4 class="mt-2">Tidak ada berita ataupun promo</h4>
                        </div>
                    <?php endif; ?>
            </div>
    </div>
    </div>
    <!-- * App Capsule -->

<?php require _DIR_('library/footer/user') ?>