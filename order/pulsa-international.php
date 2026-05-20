<?php
require '../RGShenn.php';
require _DIR_('library/session/user');
$page = 'Pulsa International';
require _DIR_('library/header/user');
?>

    <!-- App Capsule -->
    <div id="appCapsule">
        <div class="tab-content mt-0">
            <ul class="listview image-listview">
                <?php 
                $search = $call->query("SELECT * FROM category WHERE type = 'pulsa-internasional' ORDER BY name ASC");
                if($search->num_rows == FALSE) { 
                        print '<div class="alert alert-danger text-left fade show mr-2 ml-2 mt-2" role="alert">Tidak ada layanan yang tersedia!</div>';
                }
                while($row = $search->fetch_assoc()) { 
                //$code = str_replace(' ','-',strtolower($row['code']));
                $code = str_replace('.', '=', str_replace(' ', '-', strtolower($row['code'])));
                ?>
                <li>
                    <a href="<?= base_url('order/pulsa-internationals/'.$code) ?>"class="item">
                        <img src="<?= assets('images/pulsa-international/'.$code.'.png').'?'.time() ?>" alt="<?= $code ?>" class="image">
                        <div class="in">
                            <div><?= $row['code'] ?></div>
                        </div>
                    </a>
                </li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <!-- * App Capsule -->
    
<?php require _DIR_('library/footer/user') ?>