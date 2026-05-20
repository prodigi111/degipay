<?php
require '../RGShenn.php';
require _DIR_('library/session/premium');
$page = 'Tarik Komisi';
require _DIR_('library/header/user');
?>

    <!-- App Capsule -->
    <div id="appCapsule" class="rgs-referral rgs-deposit">
        
        <div class="section full rgs-bg-texture text-center pb-2 pt-2">
            <h4 class="text-white">Komisi Yang Dapat Dicairkan</h4>
            <h1 class="text-white">Rp <?= currency($data_user['komisi']) ?></h1>
        </div>
        
        <div class="section mt-2 mb-2">
            
        <form method="POST" action="withdraw">
            <? require _DIR_('library/session/result-mobile') ?>
            <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
            <input type="hidden" name="RGS" value="<?= rand(9,500) ?>">
            <div class="wide-block pb-1 pt-1 mt-1">

                <ul class="listview image-listview no-line no-space flush">
                    <li>
                        <div class="item">
                            <img src="<?= assets('mobile/img/home/withdraw-komisi-blue.svg') ?>" width="36px" class="image" id="RGSLogo">
                            <div class="in">
                                <div class="form-group basic">
                                    <div class="input-wrapper">
                                        <label class="label">Minimal Cairkan Rp 10.000</label>
                                        <input type="number" class="form-control" placeholder="10.000" name="nominal" required>
                                        <i class="clear-input">
                                            <ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon>
                                        </i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>

            </div>

            <h4 class="text-center mt-2">Pilih Nominal Cepat</h4>
            <div class="row text-center">
                <div class="col-4 mb-2">
                    <a href="javascript:;" onclick="depositNominal('10000')">
                        <div class="card">
                            <div class="card-body">
                                <h6>Rp 10.000</h6>
                            </div>
                        </div>
                    </a>    
                </div>
                <div class="col-4 mb-2">
                    <a href="javascript:;" onclick="depositNominal('25000')">
                        <div class="card">
                            <div class="card-body">
                                <h6>Rp 25.000</h6>
                            </div>
                        </div>
                    </a>    
                </div>
                <div class="col-4 mb-2">
                    <a href="javascript:;" onclick="depositNominal('50000')">
                        <div class="card">
                            <div class="card-body">
                                <h6>Rp 50.000</h6>
                            </div>
                        </div>
                    </a>    
                </div>
                <div class="col-4 mb-2">
                    <a href="javascript:;" onclick="depositNominal('100000')">
                        <div class="card">
                            <div class="card-body">
                                <h6>Rp 100.000</h6>
                            </div>
                        </div>
                    </a>    
                </div>
                <div class="col-4 mb-2">
                    <a href="javascript:;" onclick="depositNominal('250000')">
                        <div class="card">
                            <div class="card-body">
                                <h6>Rp 250.000</h6>
                            </div>
                        </div>
                    </a>    
                </div>
                <div class="col-4 mb-2">
                    <a href="javascript:;" onclick="depositNominal('500000')">
                        <div class="card">
                            <div class="card-body">
                                <h6>Rp 500.000</h6>
                            </div>
                        </div>
                    </a>    
                </div>
            </div>

            <div class="form-button-group">
                <button type="submit" class="btn btn-primary btn-block btn-lg">Lanjutkan</a>
            </div>
        </form>

        </div>
        
    </div>
    <!-- * App Capsule -->

<?php require _DIR_('library/footer/user') ?>