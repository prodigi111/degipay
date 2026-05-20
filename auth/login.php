<?php
require '../RGShenn.php';
require _DIR_('library/session/auth');
require 'action.php';
if(isset($_SESSION['login']['otp'])) {
    $page = 'Verifikasi OTP';
    $action = 'otpLogin';
    $text = 'Kami telah mengirim kode OTP ke email & whatsapp Anda';
} elseif(isset($_SESSION['pin'])) {
    $page = 'Verifikasi PIN';
    $action = 'verifPin';
    $text = 'Silahkan masukkan pin keamanan Anda';
} elseif(isset($_SESSION['register']['otp'])) {
    $page = 'Verifikasi OTP';
    $action = 'otpreg';
    $text = 'Kami telah mengirim kode OTP ke email & whatsapp Anda';
} else {
    $page = 'Login';
    $action = 'login';
    $text = 'Masukkan Nomor HP kamu untuk lanjut';
}
require _DIR_('library/header/user');
?>
<? include_once './style.php'; ?>
    <div id="appCapsule">
        <div class="rgs-auth-login">
        <?php if(isset($_SESSION['login']['otp']) || isset($_SESSION['register']['otp'])): ?>
        <? include_once 'otp.php'; ?>
        <?php elseif(isset($_SESSION['pin'])): ?>
        <? include_once 'pin.php'; ?>
        <?php else: ?>
        <? include_once 'nohp.php'; ?>
        <form method="POST">
        <div class="modal fade action-sheet" id="register" tabindex="-1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Ayo Daftar Sekarang</h5>
                    </div>
                    <div class="modal-body">
                        <div class="action-sheet-content">
                            <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label" for="nameR">Nama Lengkap</label>
                                    <input type="text" class="form-control" id="nameR" name="name" placeholder="Masukkan Nama Lengkap">
                                    <i class="clear-input">
                                        <ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon>
                                    </i>
                                </div>
                            </div>
                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label" for="phoneR">Nomor HP (Whatsapp)</label>
                                    <input type="telp" class="form-control" id="phoneR" name="phone" placeholder="Masukkan Nomor HP">
                                    <i class="clear-input">
                                        <ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon>
                                    </i>
                                </div>
                            </div>
                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label" for="emailR">Email</label>
                                    <input type="email" class="form-control" id="emailR" name="email" placeholder="Masukkan Email">
                                    <i class="clear-input">
                                        <ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon>
                                    </i>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <a href="javascript:;" class="btn rounded btn-list btn-block btn-lg text-primary m-1 mb-0" data-toggle="modal" data-target="#register" data-dismiss="modal" style="border:1px solid #5f33ba;">Batal</a>
                                <button type="button" id="regNext" data-toggle="modal" data-target="#registerNext" data-dismiss="modal" class="btn rounded btn-primary btn-block btn-lg m-1 mb-0" data-dismiss="modal" disabled>Lanjutkan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade action-sheet" id="registerNext" tabindex="-1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="pr-5"></div>
                        <h5 class="modal-title">Ayo Daftar Sekararang</h5>
                    </div>
                    <div class="modal-body">
                        <div class="action-sheet-content">
                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label" for="pinR">PIN Keamanan</label>
                                    <input type="password" class="form-control" id="pinR" maxlength="6" name="pin" pattern="[0-9]*" inputmode="numeric" placeholder="Buat PIN Keamanan">
                                    <i class="clear-input">
                                        <ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon>
                                    </i>
                                </div>
                            </div>
                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label" for="cpinR">Konfirmasi PIN Keamanan</label>
                                    <input type="password" class="form-control" id="cpinR" maxlength="6" name="cpin" pattern="[0-9]*" inputmode="numeric" placeholder="Konfirmasi PIN Keamanan">
                                    <i class="clear-input">
                                        <ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon>
                                    </i>
                                </div>
                            </div>
                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label" for="reff">Kode Referral (Opsional)</label>
                                    <input type="text" class="form-control" id="reff" name="reff" placeholder="Masukkan Kode Refferal kamu">
                                    <i class="clear-input">
                                        <ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon>
                                    </i>
                                </div>
                            </div>
                            <div class="mt-1 text-left">
                                 <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="accepttos" value="true" id="customChecka1">
                                    <label class="custom-control-label text-warning" for="customChecka1"> Saya Setuju <a href="javascript:;" class="text-dark text-center">Dengan mendaftar saya menyetujui Syarat & Ketentuan serta Kebijakan Privasi kami</a></label>
                                 </div>
                            </div>
                            
                           <!-- <p class="text-center text-muted text-success">Dengan mendaftar kamu menyetujui Syarat & Ketentuan serta Kebijakan Privasi kami.</p>-->
                            <div class="d-flex justify-content-between">
                                <a href="javascript:;" class="btn rounded btn-list btn-block btn-lg text-primary m-1 mb-0" data-toggle="modal" data-target="#register" data-dismiss="modal" style="border:1px solid #5f33ba;">Kembali</a>
                                <button type="submit" name="reg" class="btn rounded btn-primary btn-block btn-lg m-1 mb-0" id="reg" disabled>Daftar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </form>
        <?php endif; ?>
        <?php if(isset($_SESSION['result'])): 
            $type = strtolower($_SESSION['result']['type']);
        ?>
            <div class="modal fade dialogbox" id="errorBruh" data-backdrop="static" tabindex="-1" style="display: none;" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-icon text-<?= ($type == true) ? 'success' : 'danger' ?>">
                            <ion-icon name="<?= ($type == true) ? 'checkmark' : 'close' ?>-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon>
                        </div>
                        <div class="modal-header">
                            <h5 class="modal-title"><?= ($type == true) ? 'Success' : 'Error' ?></h5>
                        </div>
                        <div class="modal-body">
                            <?= $_SESSION['result']['message']; ?>
                        </div>
                        <div class="modal-footer">
                            <div class="btn-inline">
                                <a href="#" class="btn" data-dismiss="modal">TUTUP</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                $('#errorBruh').modal('show');
            </script>
            <?php 
            unset($_SESSION['result']);
            endif;
            ?>
            </div>
    </div>
    <!-- * App Capsule -->
    </script>
    <script>
        $(document).ready(function() {
            $('#pinR, #cpinR').keyup(function() {
                var pin = $('#pinR').val().length;
                var cpin = $('#cpinR').val().length;

                if(pin > 5 && cpin > 5) {
                    $('#reg').attr('disabled', false);
                } else {
                    $('#reg').attr('disabled', true);
                }
            });
            $('#nameR, #emailR, #phoneR').keyup(function() {
                var name = $('#nameR').val().length;
                var phone = $('#phoneR').val().length;
                var email = $('#emailR').val().length;

                if(name > 4 && phone > 9 && email > 5) {
                    $('#regNext').attr('disabled', false);
                } else {
                    $('#regNext').attr('disabled', true);
                }
            });
        });
    </script>

<?php require _DIR_('library/footer/user') ?>