<?php
require_once '../../app/config/core.php';
auth()->check();
if(isset($_SESSION['register'])) redirect(0, desktop_url('register'));
load_controller('auth');
set_title('Lupa Passcode');
open('auth');
?>
<div class="nk-block nk-block-middle nk-auth-body">
    <div class="brand-logo pb-5">
        <a href="<?= desktop_url(); ?>" class="logo-link">
            <img class="logo-light logo-img logo-img-lg" src="<?= desktop_assets('images/logo.png'); ?>" srcset="<?= desktop_assets('images/logo2x.png 2x'); ?>" alt="logo">
            <img class="logo-dark logo-img logo-img-lg" src="<?= desktop_assets('images/logo-dark.png'); ?>" srcset="<?= desktop_assets('images/logo-dark2x.png 2x'); ?>" alt="logo-dark">
        </a>
    </div>
    <div class="nk-block-head">
        <div class="nk-block-head-content">
            <h5 class="nk-block-title">Reset Passcode</h5>
            <?php if(isset($_SESSION['fp']['otp'])): ?>
                <?php if(isset($_SESSION['result'])): ?>
                <div class="nk-block-des text-<?= $_SESSION['result']['type']; ?>">
                    <p><?= $_SESSION['result']['message']; ?></p>
                </div>
                <?php else: ?>
                <div class="nk-block-des">
                    <p>Silahkan Verifikasi sebelum melanjutkan.</p>
                </div>
                <?php endif; ?>
                <?php unset($_SESSION['result']); ?>
            <?php elseif(isset($_SESSION['fp']['reset'])): ?>
                <?php if(isset($_SESSION['result'])): ?>
                <div class="nk-block-des text-<?= $_SESSION['result']['type']; ?>">
                    <p><?= $_SESSION['result']['message']; ?></p>
                </div>
                <?php else: ?>
                <div class="nk-block-des">
                    <p>Buat passcode atau pin kamu sesulit mungkin.</p>
                </div>
                <?php endif; ?>
                <?php unset($_SESSION['result']); ?>
            <?php else: ?>
            <div class="nk-block-des">
                <p>Jika kamu lupa passcode atau pin kamu, silahkan masukan data yg diperlukan di bawah ini.</p>
            </div>
            <?php endif; ?>
        </div>
    </div><!-- .nk-block-head -->
    <?php if(isset($_SESSION['fp']['otp'])): ?>
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
            <button class="btn btn-lg btn-primary btn-block" type="submit" name="fq_ver_otp">Verifikasi</button>
        </div>
        <div class="form-note-s2 pt-4">
            <button type="submit" style="background: transparent; border: none;" class="text-primary" name="fp_cancel"><strong>Batalkan Permintaan</strong></a>
        </div>
    </form><!-- form -->
    <?php elseif(isset($_SESSION['fp']['reset'])): ?>
    <form method="POST">
        <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
        <div class="form-group">
            <div class="form-label-group">
                <label class="form-label" for="pin">Passcode (PIN) Baru</label>
            </div>
            <div class="form-control-wrap">
                <a tabindex="-1" href="#" class="form-icon form-icon-right passcode-switch" data-target="pin">
                    <em class="passcode-icon icon-show icon ni ni-eye"></em>
                    <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                </a>
                <input type="password" maxlength="6" pattern="[0-9]*" inputmode="numeric" class="form-control form-control-lg" id="pin" name="pin" placeholder="Masukkan Passcode baru kamu">
            </div>
        </div>
        <div class="form-group">
            <div class="form-label-group">
                <label class="form-label" for="cpin">Konfirmasi Passcode (PIN) Baru</label>
            </div>
            <div class="form-control-wrap">
                <a tabindex="-1" href="#" class="form-icon form-icon-right passcode-switch" data-target="cpin">
                    <em class="passcode-icon icon-show icon ni ni-eye"></em>
                    <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                </a>
                <input type="password" maxlength="6" pattern="[0-9]*" inputmode="numeric" class="form-control form-control-lg" id="cpin" name="cpin" placeholder="Masukkan Konfirmasi Passcode baru kamu">
            </div>
            <span class="text-danger">Passcode Maksimal 6 angka, tidak boleh berisi karakter lain</span>
        </div>
        <div class="form-group">
            <button class="btn btn-lg btn-primary btn-block" type="submit" name="fp_reset">Reset</button>
        </div>
        <div class="form-note-s2 pt-4">
            <button type="submit" style="background: transparent; border: none;" class="text-primary" name="fp_cancel"><strong>Batalkan Permintaan</strong></a>
        </div>
    </form><!-- form -->
    <?php else: ?>
    <?php component('alerts'); ?>
    <form method="POST">
        <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
        <div class="form-group">
            <label class="form-label" for="account">Email atau No. Telepon</label>
            <input type="text" class="form-control form-control-lg" id="account" name="account" placeholder="Masukkan Email atau No. Telepon">
        </div>
        <div class="form-group">
            <button type="submit" name="fp_req" class="btn btn-lg btn-primary btn-block">Kirim Permintaan</button>
        </div>
    </form><!-- form -->
    <div class="form-note-s2 pt-5">
        <a href="<?= desktop_url('login'); ?>"><strong>Kembali ke Masuk</strong></a>
    </div>
    <?php endif; ?>
</div>
<?php close('auth'); ?>
