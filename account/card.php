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
        margin-bottom: 30px;
    }
    .card {
        /*background-image: url(/library/assets/images/background/texture-purple-rev.jpg) !important;*/
        background-color: #000957;
        margin: 30px;
    }
    .card .card-body {
        padding: 30px;
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
                                <img src="<?= $_CONFIG['icon'] ?>" width="80px">
                                <div class="text-left"><b>
                                    <h3 class="text-white"><?= $data_user['card']
                                    ?></h3>
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