<?php
require '../RGShenn.php';
require _DIR_('library/session/user');
$page = 'Acara';
require _DIR_('library/header/user');
$data_events = $call->query('SELECT * FROM events WHERE expired_at >= "'.$date.'" ORDER BY id DESC');
$check_event = $data_events->num_rows;
?>
    <!-- App Capsule -->
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
    <div id="appCapsule">
    <?php if($check_event > 0): ?>
    <?php while($event = $data_events->fetch_assoc()): ?>
        <a href="<?= base_url('page/event/'.preg_replace('/[^a-z0-9]+/i', '-', strtolower($event['type'])).'?id='.$event['target']); ?>">
            <div class="section mt-2">
                <div class="card">
                    <img src="<?= assets('images/events/'.$event['banner']); ?>" class="card-img-top" alt="image" style="    max-height: 145px;">
                    <div class="card-body">
                        <h5 class="card-title"><?= $event['title']; ?></h5>
                        <p class="card-text"><?= nl2br($event['description']) ?></p>
                        <?php if($event['expired_at'] == $date) : ?>
                        <p class="card-text mb-0"><small>Berlaku sampai hari ini</small></p>
                        <?php else: ?>
                        <p class="card-text mb-0"><small>Berlaku sampai <?= format_date(0, $event['expired_at']); ?></small></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </a>
    <?php endwhile; ?>
    <?php else: ?>
        <div class="text-center mt-5">
            <img src="<?= assets('mobile/img/svg/riwayat.svg') ?>" alt="alt" class="imaged square w200">
            <h4 class="mt-2">Tidak ada acara</h4>
        </div>
    <?php endif; ?>
    </div>
    <!-- * App Capsule -->

<?php require _DIR_('library/footer/user') ?>