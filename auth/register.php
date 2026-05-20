<?php
require '../RGShenn.php';
require _DIR_('library/session/auth');
require 'action.php';
if(isset($_SESSION['register']['otp'])) {
    $page = 'Verifikasi OTP';
    $action = 'otpreg';
    $text = 'Kami telah mengirim kode OTP ke email & whatsapp Anda';
} else {
    $page = 'Daftar';
    $action = 'reg';
    $text = 'Masukkan data dengan benar!';
}
require _DIR_('library/header/user');
?>

    <!-- App Capsule -->
    <div id="appCapsule" class="rgs-auth-login">

        <div class="login-form">
            <div class="section mt-1">
                <h4 class="text-light"><?= $text ?></h4>
                <? require _DIR_('library/session/result-mobile'); ?>
            </div>
            <div class="section mt-1 mb-5">
                <form method="POST">
                    <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
                    <?php if(isset($_SESSION['register']['otp'])): ?>
                    
                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <input type="number" class="form-control verify-input" name="otpcode" id="smscode" placeholder="••••••" maxlength="6">
                        </div>
                    </div>

                    <div class="form-links mt-1">
                        <div>
                            <button type="submit" class="btn btn-sm text-light" name="resend_otp" onclick="var e=this;setTimeout(function(){e.disabled=true;},0);return true;"> Kirim Ulang </button>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-sm text-light" name="cancel" onclick="var e=this;setTimeout(function(){e.disabled=true;},0);return true;"> Batalkan </button>
                        </div>
                    </div>
                    
                    <?php else: ?>
                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <input type="text" class="form-control" placeholder="Nama Lengkap" name="name">
                            <i class="clear-input">
                                <ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon>
                            </i>
                        </div>
                    </div>

                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <input type="number" class="form-control" placeholder="Nomor Whatsapp" name="phone">
                            <i class="clear-input">
                                <ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon>
                            </i>
                        </div>
                    </div>

                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <input type="email" class="form-control" placeholder="Email" name="email">
                            <i class="clear-input">
                                <ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon>
                            </i>
                        </div>
                    </div>

                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <input type="password" class="form-control" placeholder="Pin Keamanan" maxlength="6" name="pin" pattern="[0-9]*" inputmode="numeric" required>
                            <i class="clear-input">
                                <ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon>
                            </i>
                        </div>
                    </div>

                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <input type="password" class="form-control" placeholder="Konfirmasi Pin Keamanan" maxlength="6" name="cpin" pattern="[0-9]*" inputmode="numeric">
                            <i class="clear-input">
                                <ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon>
                            </i>
                        </div>
                    </div>

                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <input type="text" class="form-control" placeholder="Kode Referral (Opsional)" name="reff">
                            <i class="clear-input">
                                <ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon>
                            </i>
                        </div>
                    </div>

                    <div class="mt-1 text-left">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="accepttos" value="true" id="customChecka1" required/>
                            <label class="custom-control-label text-light" for="customChecka1">I Agree <a href="javascript:;" class="text-light">Terms &amp; Conditions</a></label>
                        </div>
                    </div>
                    
                    <?php endif; ?>

                    <div class="form-button-group bg-primary">
                        <button type="submit" name="<?= $action ?>" onclick="var e=this;setTimeout(function(){e.disabled=true;},0);return true;" class="btn rounded btn-text-primary btn-block btn-lg">Submit</a>
                    </div>

                </form>
            </div>
        </div>

    </div>
    <!-- * App Capsule -->

<?php require _DIR_('library/footer/user') ?>