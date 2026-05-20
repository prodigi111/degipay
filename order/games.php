<?php
require '../RGShenn.php';
require _DIR_('library/session/user');
$page = 'Games';
require _DIR_('library/header/user');
?>

    <!-- App Capsule -->
    <div id="appCapsule" class="rgs-game extra-header-active">
        <div class="tab-content mt-2">
            <div class="tab-pane fade show active" id="Semua" role="tabpanel">
                <div class="row">
                    <?php 
                    $search = $call->query("SELECT * FROM category WHERE type IN ('games', 'voucher-game') ORDER BY name ASC");
                    if($search->num_rows == FALSE) { 
                        print '<div class="alert alert-danger text-left fade show" role="alert">Tidak Ada Layanan Yang Tersedia!</div>';
                    }
                    while($row = $search->fetch_assoc()) { 
                    $code = str_replace(' ','-',strtolower($row['code']));
                    ?>
                    <div class="col-3 mt-1 text-center">
                         <a href="<?= base_url('order/game-detail?s='.$code) ?>">
                            <img src="<?= assets('images/games-icon/'.$code.'.jpg').'?'.time() ?>" alt="<?= $code ?>" class="imaged w-100 image-game-list">
                            <h6><?= $row['code'] ?></h6>
                        </a>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <div class="tab-pane fade" id="Topup" role="tabpanel">
                <div class="row">
                    <?php 
                    $search = $call->query("SELECT * FROM category WHERE type = 'games' ORDER BY name ASC");
                    if($search->num_rows == FALSE) { 
                        print '<div class="alert alert-danger text-left fade show" role="alert">Tidak Ada Layanan Yang Tersedia!</div>';
                    }
                    while($row = $search->fetch_assoc()) { 
                    $code = str_replace(' ','-',strtolower($row['code']));
                    ?>
                    <div class="col-3 mt-1 text-center">
                         <a href="<?= base_url('order/game-detail?s='.$code) ?>">
                            <img src="<?= assets('images/games-icon/'.$code.'.jpg').'?'.time() ?>" alt="<?= $code ?>" class="imaged w-100 image-game-list">
                            <h6><?= $row['code'] ?></h6>
                        </a>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <div class="tab-pane fade" id="Voucher" role="tabpanel">
                <div class="row">
                    <?php 
                    $search = $call->query("SELECT * FROM category WHERE type = 'voucher-game' ORDER BY name ASC");
                    if($search->num_rows == FALSE) { 
                        print '<div class="alert alert-danger text-left fade show" role="alert">Tidak Ada Layanan Yang Tersedia!</div>';
                    }
                    while($row = $search->fetch_assoc()) { 
                    $code = str_replace(' ','-',strtolower($row['code']));
                    ?>
                    <div class="col-3 mt-1 text-center">
                        <a href="<?= base_url('order/game-detail?s='.$code) ?>">
                            <img src="<?= assets('images/games-icon/'.$code.'.jpg').'?'.time() ?>" alt="<?= $code ?>" class="imaged w-100 image-game-list">
                            <h6><?= $row['code'] ?></h6>
                        </a>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <!-- * App Capsule -->
    
<?php require _DIR_('library/footer/user') ?>-