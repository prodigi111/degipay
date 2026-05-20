<?php
require '../RGShenn.php';
$page = 'Detail Fitur';

if(!isset($_GET['id'])) {
    redirect(0,base_url());
} else {
    $post_kode = filter($_GET['id']);
    $search = $call->query("SELECT * FROM feature WHERE id = '$post_kode'");
    if($search->num_rows == 0) redirect(0,base_url());
    $row_query = $search->fetch_assoc();
    
require _DIR_('library/header/user');
?>

    <!-- App Capsule -->
    <div id="appCapsule" class="information pb-0">
        <div class="section full">
            <img src="<?= assets('images/feature/'.$row_query['banner']); ?>" alt="RGS-Banner" class="imaged img-fluid square">
            <div class="card">
                <div class="card-body">
                    <div class="card-title text-center"><?= $row_query['title'] ?></div>
                    <div class="in" style="justify-content: center">
                        <div class=""><?= $row_query['created_at'] ?></div>
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