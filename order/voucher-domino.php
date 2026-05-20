<?php
require '../RGShenn.php';
require _DIR_('library/session/user');
$page = 'Voucher Domino';
require _DIR_('library/header/user');
?>

    <!-- App Capsule -->
    <div id="appCapsule" class="rgs-game extra-header-active">
        <div class="tab-content">
            <div class="tab-pane fade show active" id="Semua" role="tabpanel">
                <ul class="listview image-listview">
                    <?php 
                    $search = $call->query("SELECT * FROM category WHERE type IN ('voucher') ORDER BY name ASC");
                    if($search->num_rows == FALSE) { 
                        print '<div class="alert alert-danger text-left fade show mr-2 ml-2 mt-2" role="alert">Tidak Ada Layanan Yang Tersedia!</div>';
                    }
                    while($row = $search->fetch_assoc()) { 
                    $code = str_replace(' ','-',strtolower($row['code']));
                    ?>
                    <li>
                        <a href="<?= base_url('order/voucher-domino/'.$code) ?>"class="item">
                            <img src="<?= assets('images/voucher-icon/'.$code.'.jpg').'?'.time() ?>" alt="<?= $code ?>" class="image">
                            <div class="in">
                                <div><?= $row['code'] ?></div>
                            </div>
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </div>
            <div class="tab-pane fade" id="Data" role="tabpanel">
                <ul class="listview image-listview">
                    <?php 
                    $search = $call->query("SELECT * FROM category WHERE type = 'voucher-data' ORDER BY name ASC");
                    if($search->num_rows == FALSE) { 
                        print '<div class="alert alert-danger text-left fade show mr-2 ml-2 mt-2" role="alert">Tidak Ada Layanan Yang Tersedia!</div>';
                    }
                    while($row = $search->fetch_assoc()) { 
                    $code = str_replace(' ','-',strtolower($row['code']));
                    ?>
                    <li>
                        <a href="<?= base_url('order/vouchers/'.$code) ?>"class="item">
                            <img src="<?= assets('images/voucher-icon/'.$code.'.jpg').'?'.time() ?>" alt="image" class="image">
                            <div class="in">
                                <div><?= $row['code'] ?></div>
                            </div>
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </div>
            <div class="tab-pane fade" id="Digital" role="tabpanel">
                <ul class="listview image-listview">
                    <?php 
                    $search = $call->query("SELECT * FROM category WHERE type = 'voucher' ORDER BY name ASC");
                    if($search->num_rows == FALSE) { 
                        print '<div class="alert alert-danger text-left fade show mr-2 ml-2 mt-2" role="alert">Tidak Ada Layanan Yang Tersedia!</div>';
                    }
                    while($row = $search->fetch_assoc()) { 
                    $code = str_replace(' ','-',strtolower($row['code']));
                    ?>
                    <li>
                        <a href="<?= base_url('order/vouchers/'.$code) ?>"class="item">
                            <img src="<?= assets('images/voucher-icon/'.$code.'.jpg').'?'.time() ?>" alt="image" class="image">
                            <div class="in">
                                <div><?= $row['code'] ?></div>
                            </div>
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </div>
            <div class="tab-pane fade" id="TV" role="tabpanel">
                <ul class="listview image-listview">
                    <?php 
                    $search = $call->query("SELECT * FROM category WHERE type = 'tv' ORDER BY name ASC");
                    if($search->num_rows == FALSE) { 
                        print '<div class="alert alert-danger text-left fade show mr-2 ml-2 mt-2" role="alert">Tidak Ada Layanan Yang Tersedia!</div>';
                    }
                    while($row = $search->fetch_assoc()) { 
                    $code = str_replace(' ','-',strtolower($row['code']));
                    ?>
                    <li>
                        <a href="<?= base_url('order/vouchers/'.$code) ?>"class="item">
                            <img src="<?= assets('images/voucher-icon/'.$code.'.jpg').'?'.time() ?>" alt="image" class="image">
                            <div class="in">
                                <div><?= $row['code'] ?></div>
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