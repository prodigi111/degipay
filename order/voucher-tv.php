<?php
require '../RGShenn.php';
require _DIR_('library/session/user');
$page = 'Voucher TV';
require _DIR_('library/header/user');
?>
<style>
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
                $search = $call->query("SELECT * FROM category WHERE type = 'voucher-tv' ORDER BY name ASC");
                if($search->num_rows == FALSE) { 
                        print '<div class="alert alert-danger text-left fade show mr-2 ml-2 mt-2" role="alert">Tidak ada layanan yang tersedia!</div>';
                }
                while($row = $search->fetch_assoc()) { 
                //$code = str_replace(' ','-',strtolower($row['code']));
                $code = str_replace('.', '=', str_replace(' ', '-', strtolower($row['code'])));
                $codes = strtr($row['code'], [
                            'DECODER GOL' => 'Decoder GOL',
                            'K VISION DAN GOL' => 'K-VISION dan GOL',
                            'NEX GARUDA' => 'Nex & Garuda',
                            'TRANSVISION' => 'Transvision'
                        ]);
                ?>
                <li>
                    <a href="<?= base_url('order/voucher-tvs/'.$code) ?>"class="item">
                        <img src="<?= assets('images/voucher-tv/'.$code.'.png').'?'.time() ?>" alt="<?= $code ?>" class="image">
                        <div class="in">
                            <div><?= $codes ?></div>
                        </div>
                    </a>
                </li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <!-- * App Capsule -->
    
<?php require _DIR_('library/footer/user') ?>