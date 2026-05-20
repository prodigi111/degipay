<?php
require '../connect.php';
require _DIR_('library/session/user');
$page = 'Langganan Pembayaran';
require _DIR_('library/header/user');
?>
<style>
    .image-listview > li a.item {
        padding-right: 30px;
    }
    .image-listview > li .item .image {
        min-width: 40px;
        max-width: 40px;
    }
</style>
    <!-- App Capsule -->
    <div id="appCapsule">
        <div class="tab-content mt-0">
                <ul class="listview image-listview">
                    <?php 
                    $search = $call->query("SELECT * FROM category WHERE type = 'pascabayar' ORDER BY name ASC");
                    if($search->num_rows == FALSE) { 
                        print '<div class="alert alert-danger text-left fade show mr-2 ml-2 mt-2" role="alert">Tidak Ada Layanan Yang Tersedia!</div>';
                    }
                    while($row = $search->fetch_assoc()) { 
                    $code = str_replace('.', '=', str_replace(' ', '-', strtolower($row['code'])));
                    ?>
                    <li>
                        <a href="<?= base_url('bills/detail/'.$code) ?>"class="item">
                            <img src="<?= assets('images/produk-icon/'.$code.'.png').'?'.time() ?>" alt="<?= $row['name'] ?>" class="image">
                            <div class="in">
                                <div><?= $row['name'] ?></div>
                            </div>
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
    <!-- * App Capsule -->
    
<?php require _DIR_('library/footer/user') ?>