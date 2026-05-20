<?php
require_once '../../app/config/core.php';
auth()->check();
if(isset($_SESSION['register'])) redirect(0, desktop_url('register'));
load_controller('auth');
set_title('Masuk');
open('auth');
?>
<div class="nk-block nk-block-middle nk-auth-body text-center">
    <div class="brand-logo pb-5">
        <a href="<?= desktop_url(); ?>" class="logo-link">
            <img class="logo-light logo-img logo-img-lg " src="<?= $_CONFIG['icon'] ?>" srcset="<?= $_CONFIG['icon'] ?>" alt="logo">
            <img class="logo-dark logo-img logo-img-lg" src="<?= $_CONFIG['icon'] ?>" srcset="<?= $_CONFIG['icon'] ?>" alt="logo-dark">
        </a>
    </div>
    <div class="nk-block-head">
        <div class="nk-block-head-content">
            <h5 class="nk-block-title text-center">Masuk</h5>
            <div class="nk-block-des text-center">
                <p>Akses Control Panel  Admin <?= $_CONFIG['title']; ?> menggunakan akun yang valid.</p>
            </div>
        </div>
    </div>
    <?php component('alerts'); ?>
    <form method="POST">
        <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
        <div class="form-group">
            <div class="form-label-group">
                <label class="form-label" for="account">Email atau No. Telepon</label>
            </div>
            <input type="text" class="form-control form-control-lg" id="account" name="account" placeholder="Masukkan Email atau No. Telepon kamu">
        </div>
        <div class="form-group">
            <div class="form-label-group">
                <label class="form-label" for="password">Passcode (PIN)</label>
                <a class="link link-primary link-sm" tabindex="-1" href="<?= desktop_url('forgot-passcode'); ?>">Lupa Passcode?</a>
            </div>
            <div class="form-control-wrap">
                <a tabindex="-1" href="#" class="form-icon form-icon-right passcode-switch" data-target="password">
                    <em class="passcode-icon icon-show icon ni ni-eye"></em>
                    <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                </a>
                <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="Masukkan Passcode kamu">
            </div>
        </div>
        <div class="form-group">
            <button type="submit" name="login" class="btn btn-lg btn-primary btn-block">Masuk</button>
        </div>
    </form> 
    <!--
    <div class="text-center mt-5">
        <span class="fw-500">Belum punya akun? <a href="<?= desktop_url('register'); ?>">Daftar Sekarang</a></span>
    </div> 
    -->
</div>
<?php close('auth'); ?>
