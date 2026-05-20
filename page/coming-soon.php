<?php
require '../RGShenn.php';
require _DIR_('library/session/user');
$page = 'Coming Soon';
require _DIR_('library/header/user');
?>

    <!-- App Capsule -->
    <div id="appCapsule">

        <div class="error-page">
            <div class="mb-2">
                <img src="<?= assets('mobile/img/sample/photo/vector3.png') ?>" alt="alt" class="imaged square w200">
            </div>
            <h1 class="title">Coming Soon!</h1>
            <div class="text mb-3">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
            </div>
            <div id="countDown" class="mb-5"></div>

            <div class="fixed-footer">
                <div class="row">
                    <div class="col-12">
                        <a href="<?= base_url() ?>" class="btn btn-primary btn-lg btn-block">Go Back</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- * App Capsule -->

<?php require _DIR_('library/footer/user') ?>