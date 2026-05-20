<?php
require_once '../../app/config/core.php';
auth()->check();
load_controller('auth');
set_title('Daftar');
open('auth');
?>
<div class="nk-block nk-block-middle nk-auth-body">
    <div class="brand-logo pb-5">
        <a href="<?= desktop_url(); ?>" class="logo-link">
            <img class="logo-light logo-img logo-img-lg" src="<?= desktop_assets('images/logo.png'); ?>" srcset="<?= desktop_assets('images/logo2x.png 2x'); ?>" alt="logo">
            <img class="logo-dark logo-img logo-img-lg" src="<?= desktop_assets('images/logo-dark.png'); ?>" srcset="<?= desktop_assets('images/logo-dark2x.png 2x'); ?>" alt="logo-dark">
        </a>
    </div>
<?php if(!isset($_SESSION['register']['otp'])): ?>
    <div class="nk-block-head">
        <div class="nk-block-head-content">
            <h5 class="nk-block-title">Daftar</h5>
            <div class="nk-block-des">
                <p>Daftar <?= $_CONFIG['title']; ?> sekarang juga gratis.</p>
            </div>
        </div>
    </div>
    <?php component('alerts'); ?>
    <form method="POST">
        <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
        <div class="form-group">
            <div class="form-label-group">
                <label class="form-label" for="name">Nama Lengkap</label>
            </div>
            <input type="text" class="form-control form-control-lg" id="name" name="name" placeholder="Masukkan Nama Lengkap kamu">
        </div>
        <div class="form-group">
            <div class="form-label-group">
                <label class="form-label" for="email">E-mail</label>
            </div>
            <input type="email" class="form-control form-control-lg" id="email" name="email" placeholder="Masukkan E-mail kamu">
        </div>
        <div class="form-group">
            <div class="form-label-group">
                <label class="form-label" for="nohp">No. Telepon (Whatsapp)</label>
            </div>
            <input type="nohp" class="form-control form-control-lg" id="nohp" name="nohp" placeholder="Masukkan No. Telepon kamu">
        </div>
        <div class="form-group">
            <div class="form-label-group">
                <label class="form-label" for="pin">Passcode (PIN)</label>
            </div>
            <div class="form-control-wrap">
                <a tabindex="-1" href="#" class="form-icon form-icon-right passcode-switch" data-target="pin">
                    <em class="passcode-icon icon-show icon ni ni-eye"></em>
                    <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                </a>
                <input type="password" maxlength="6" pattern="[0-9]*" inputmode="numeric" class="form-control form-control-lg" id="pin" name="pin" placeholder="Masukkan Passcode kamu">
            </div>
            <span class="text-danger">Passcode Maksimal 6 angka, tidak boleh berisi karakter lain</span>
        </div>
        <div class="form-group">
            <div class="form-label-group">
                <label class="form-label" for="reff">Kode Undangan (Optional)</label>
            </div>
            <input type="text" class="form-control form-control-lg" id="reff" name="reff" placeholder="Masukkan Kode Undangan">
        </div>
        <div class="form-group">
            <span class="text-center">
                Dengan mendaftar kamu menyetujui <a tabindex="-1" href="#">Syarat & Ketentuan</a> serta <a tabindex="-1" href="#">Kebijakan Privasi</a> kami.
            </span>
        </div>
        <div class="form-group">
            <button type="submit" name="register" class="btn btn-lg btn-primary btn-block">Daftar</button>
        </div>
    </form>
    <div class="text-center mt-5">
        <span class="fw-500">Sudah punya akun? <a href="<?= desktop_url('login'); ?>">Masuk Disini</a></span>
    </div>
<?php else: ?>
    <div class="nk-block-head">
        <div class="nk-block-head-content">
            <h5 class="nk-block-title">Verifikasi Akun</h5>
            <?php if(isset($_SESSION['result'])): ?>
            <div class="nk-block-des text-<?= $_SESSION['result']['type']; ?>">
                <p><?= $_SESSION['result']['message']; ?></p>
            </div>
            <?php else: ?>
            <div class="nk-block-des">
                <p>Ayo selesaikan pendaftaranmu.</p>
            </div>
            <?php endif; ?>
            <?php unset($_SESSION['result']); ?>
        </div>
    </div><!-- .nk-block-head -->
    <form method="POST">
        <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
        <div class="form-group">
            <div class="form-label-group">
                <label class="form-label" for="otp">Kode Verifikasi (OTP)</label>
                <button type="submit" name="resend_otp" class="link link-primary link-sm" onclick="var e=this;setTimeout(function(){e.disabled=true;},0);return true;">Kirim Ulang?</button>
            </div>
            <input type="telp" class="form-control form-control-lg" id="otp" name="otp" placeholder="Masukkan Kode Verifikasi">
        </div>
        <div class="form-group">
            <button class="btn btn-lg btn-primary btn-block" type="submit" name="otpreg">Selesaikan Pendaftaran</button>
        </div>
    </form><!-- form -->
    <div class="form-note-s2 pt-4">
        <form method="POST">
            <button type="submit" style="background: transparent; border: none;" class="text-primary" name="cancel"><strong>Batalkan Pendaftaran</strong></a>
        </form>
    </div>
<?php endif; ?>
</div>
<?php close('auth'); ?>
