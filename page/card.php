<?php
require '../RGShenn.php';
require _DIR_('library/session/user');
$page = 'My Card';
require _DIR_('library/header/user');
?>
<style>
    img {
        margin-bottom: 15px;
    }
    .app-list {
        margin-bottom: 25px;
    }
    .card {
        background-image: url(/library/assets/images/texture-full.jpg) !important;
        margin: 30px;
    }
    .card .card-body {
        padding: 20px;
        line-height: 2.0em;
    }
    .text-left {
        color: #FFFFFF !important;
    }
</style>
    <!-- App Capsule -->
    <div id="appCapsule">
        
        <div class="section full">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="app-list">
                                <img src="<?= $_CONFIG['icon'] ?>" width="40px">
                                <div class="text-left"><b>
                                    <?php 
                                    $card = $data_user['card'];
                                    $card1 = substr($card, -16, '4');
                                    $card2 = substr($card, -12, '4');
                                    $card3 = substr($card, -8, '4');
                                    $card4 = substr($card, -4);
                                        echo $card1." - ".$card2." - ".$card3." - ".$card4;
                                    ?>
                                </b>
                                </div>
                                <div class="text-left"><b><?= $data_user['name'] ?></b></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    <!-- * App Capsule -->
<?php require _DIR_('library/footer/user') ?>