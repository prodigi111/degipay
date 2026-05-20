<?php
require '../RGShenn.php';
require _DIR_('library/session/user');
$page = 'Voucher Digital';
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
                $search = $call->query("SELECT * FROM category WHERE type = 'voucher-digital' ORDER BY name ASC");
                if($search->num_rows == FALSE) { 
                        print '<div class="alert alert-danger text-left fade show mr-2 ml-2 mt-2" role="alert">Tidak ada layanan yang tersedia!</div>';
                }
                while($row = $search->fetch_assoc()) { 
                //$code = str_replace(' ','-',strtolower($row['code']));
                $code = str_replace('.', '=', str_replace(' ', '-', strtolower($row['code'])));
                $codes = strtr($row['code'], [
                            'ALFAMART VOUCHER' => 'Alfamart Voucher',
                            'CARREFOUR DAN TRANSMART' => 'Carrefour dan Transmart',
                            'INDOMARET' => 'Indomaret',
                            'SPOTIFY' => 'Spotify',
                            'VIDIO' => 'Vidio'
                        ]);
                ?>
                <li>
                    <a href="<?= base_url('order/voucher-digitals/'.$code) ?>"class="item">
                        <img src="<?= assets('images/produk-icon/voucher-digital/'.$code.'.png').'?'.time() ?>" alt="<?= $code ?>" class="image">
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