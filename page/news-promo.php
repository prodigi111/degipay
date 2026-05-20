<?php
require '../RGShenn.php';
$page = 'Detail Berita';

if(!isset($_GET['id'])) {
    redirect(0,base_url('page/info'));
} else {
    $post_kode = filter($_GET['id']);
    $search = $call->query("SELECT * FROM news_promo WHERE id = '$post_kode'");
    if($search->num_rows == 0) redirect(0,base_url('page/info'));
    $row_query = $search->fetch_assoc();
    
require _DIR_('library/header/user');
?>

    <!-- App Capsule -->
    <div id="appCapsule" class="information pb-0">
        <div class="section full">
            <img src="<?= assets('images/news/'.$row_query['banner']); ?>" alt="RGS-Banner" class="imaged img-fluid square">
            <div class="card">
                <div class="card-body">
                    <div class="card-title text-center"><?= $row_query['title'] ?></div>
                    <div class="in" style="justify-content: center">
                        <div class=""><?= (!empty($row_query['expired_at'])) ? format_date('id',$row_query['expired_at']) : 'Tidak ada batas waktu' ?></div>
                    </div>
                </div>
            </div>
            <div class="description">
                <p><?= nl2br($row_query['description']) ?></p>
            </div>
        </div>
    </div>
    <!-- * App Capsule -->

<?php require _DIR_('library/footer/user'); } ?>