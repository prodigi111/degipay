<?php
require '../RGShenn.php';
require _DIR_('library/session/user');
$page = 'Rekomendasi Pilihan';
require _DIR_('library/header/user'); 

$post_kode = filter($_GET['id']);
$search = $call->query("SELECT * FROM post WHERE id = '$post_kode'");
if($search->num_rows == 0) redirect(0,base_url(''));
$row_query = $search->fetch_assoc();
?>
        <!-- App Capsule -->
    <div id="appCapsule" class="information pb-0">
        <div class="section full">
            <img src="<?= assets('images/post/'.$row_query['image']); ?>" alt="RGS-Banner" class="imaged img-fluid square">
            <div class="card">
                <div class="card-body">
                    <div class="card-title text-center"><?= $row_query['title'] ?></div>
                    <div class="in" style="justify-content: center">
                        <div class="">Tidak Ada Batasan Waktu</div>
                    </div>
                </div>
            </div>
            <div class="description">
                <p><?= nl2br($row_query['content']) ?></p>
            </div>
        </div>
    </div>
    <!-- * App Capsule -->
    </div>
    <!-- * App Capsule -->

<?php require _DIR_('library/footer/user') ?>