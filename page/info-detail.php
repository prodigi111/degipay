<?php
require '../RGShenn.php';
$page = 'Detail Berita';

if(!isset($_GET['shenn'])) {
    redirect(0,base_url('page/info'));
} else {
    $post_kode = filter($_GET['shenn']);
    $search = $call->query("SELECT * FROM information WHERE id = '$post_kode'");
    if($search->num_rows == 0) redirect(0,base_url('page/info'));
    $row_query = $search->fetch_assoc();
    
require _DIR_('library/header/user');
?>

    <!-- App Capsule -->
    <div id="appCapsule" class="information pb-0">
        <div class="section full">
            <img src="<?= assets('mobile/img/banner/news-banner.png'); ?>" alt="RGS-Banner" class="imaged img-fluid square">
            <div class="card">
                <div class="card-body">
                    <div class="card-title"><?= $row_query['title'] ?></div>
                    <div class="in">
                        <div><?= format_date('id',$row_query['date']) ?></div>
                    </div>
                </div>
            </div>
            <div class="description">
                <p><?= nl2br($row_query['content']) ?></p>
            </div>
        </div>
    </div>
    <!-- * App Capsule -->

<?php require _DIR_('library/footer/user'); } ?>