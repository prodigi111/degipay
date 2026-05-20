 <style>
    .close-pin {
        text-align: right!important;
        font-size: xx-large;
        color: #4F5050;
        opacity: 0.5;
    }
    a {
        color: #4F5050;
    }
    a:hover, a:active, a:focus {
        color: #4F5050;
    }
    .bg-primary-new{
        background-color: #000957 !important;
    }
    .login-p {
        color : white !important;
    }
</style>  
    <div class="carousel-slider owl-carousel owl-theme pt-5 mt-5">
    <div class="item login-item">
        <div class="iconedbox imaged w-75 login">
            <img src="<?= assets('mobile/icon/store.svg').'?'.time() ?>" style="height: 11rem">
        </div>
        <h3 class="text-light">Transaksi Lebih Mudah</h3>
        <p class="login-p">Belanja kebutuhan kamu dimana saja dan kapan saja</p>
    </div>
    <div class="item login-item">
        <div class="iconedbox imaged w-75 login">
            <img src="<?= assets('mobile/icon/payment.svg').'?'.time() ?>" style="height: 11rem">
        </div>
        <h3 class="text-light">Pembayaran Cepat Dan Aman</h3>
        <p class="login-p">Proteksi langsung secara Real-Time pembayaran dan semua transaksi kamu</p>
    </div>
    <div class="item login-item">
        <div class="iconedbox imaged w-75 login">
            <img src="<?= assets('mobile/icon/keuntungan.svg').'?'.time() ?>" style="height: 11rem">
        </div>
        <h3 class="text-light">Keuntungan Melimpah</h3>
        <p class="login-p">Banyak layanan murah dan bagus yang membuat dompet kamu tetap aman</p>
    </div>
</div>
<div class="login-form-bottom">
    <div class="section center mt-1 text-light">
        <h3 style="font-weight: 400; font-size: 15px;" class="text-light">Masukkan <span class="bold">Nomor HP</span> kamu untuk lanjut.</h3>
    </div>
    <div class="section-login">
        <div class="form-group">
            <div class="form-control-wrap">
                <div class="form-icon form-icon-left ml-1">
                    <img src="<?= assets('mobile/icon/indonesia.svg').'?'.time() ?>" class="imaged w24" style="border: 1px solid #e1e1e1; border-radius: 4px;">
                    <span class="bold text-dark pl-1">+62</span>
                </div>
                <a href="#" data-toggle="modal" data-target="#inputNumberPhone" class="form-control" style="color: #6c757d; padding-left: 4.25rem; border-radius: 15px">812-3456-7890</a>
            </div>
        </div>
    </div>
</div>
<div class="modal fade modalbox" id="inputNumberPhone" data-backdrop="static" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content bg-primary-new">
            <div class="modal-header bg-primary-new" style="border-bottom: 0; font-size: 26px;padding:0px 16px;">
                <div class="appHeader no-border transparent position-absolute text-light bold">
                    <div class="pageTitle d-flex justify-content-center align-items-center">
                    <div class="left">
                        <a href="javascript:;" class="text-light" data-dismiss="modal"><ion-icon name="chevron-back-outline"></ion-icon></a>
                    </div>
                           <h3 class="text-center text-white">Verifikasi No Hp</h3>
                        <!--<img src="<?= assets('mobile/img/Logo/logo.png').'?'.time() ?>" alt="logo" class="logo" style="max-height: 70px;">-->
                    </div>
                </div>
                <span> </span>
            </div>
            <div class="modal-body-login">
                <div class="login-form">
                    <div class="section mb-3">
                        <form id="FormCheckPhone" method="POST">
                            <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
                                <h4 style="font-weight:400;margin-bottom:24px" class="text-light">Masukkan <span class="bold">Nomor HP</span> kamu untuk lanjut.</h4>
                            <div class="form-group">
                                <div class="form-control-wrap">
                                    <div class="form-icon form-icon-left ml-1">
                                        <img src="<?= assets('mobile/icon/indonesia.svg').'?'.time() ?>" class="imaged w24" style="border: 1px solid #e1e1e1; border-radius: 4px;">
                                        <span class="bold text-dark pl-1">+62</span>
                                    </div>
                                    <input type="tel" data-inputmask="'mask': '999[-9999][-99999]', 'placeholder': ''" onkeyup="CheckNumber();" class="form-control" id="phone" name="user" style="color: #6c757d; padding-left: 5.10rem; border-radius: 15px" placeholder="812-3456-7890">
                                </div>
                            </div>
                            <div class="form-button-group bg-primary-new" style="min-height: 55px !important">
                                <a href="#" data-toggle="modal" data-target="#OTPLogin" class="btn btn-block btn-lg  text-white" style="font-weight: bold; background: transparent !important; font-size: 15px;">Lanjut</a>
                                <!-- <a href="#" data-toggle="modal" data-target="#OTPLogin">
                                    <button class="btn btn-block btn-lg  text-white" style="font-weight: bold; background: transparent !important; font-size: 15px;" id="SubmitNumber" disabled="">
                                </a>Lanjut</button>
                                <button type="submit" id="SubmitNumber" name="login" class="btn btn-block btn-lg  text-white" style="font-weight: bold; background: transparent !important; font-size: 15px;" disabled=""  onclick="var e=this;setTimeout(function(){e.disabled=true;},0);return true;">Lanjut</button> -->
                            </div>
    
    <div class="modal fade action-sheet" id="OTPLogin" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content" style="background-color: #00000080;">
                <div class="modal-body">
                    <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
                        <div class="form-bottom-fixed pb-0">
                            <div class="close-pin">
                                <a href="#" data-dismiss="modal">
                                    <ion-icon name="close-circle"></ion-icon>
                                </a>
                            </div>
                            <div class="form-group basic pb-0">
                                <div class="input-wrapper"> 
                                    <img src="<?= assets('mobile/icon/otp.svg') ?>" style="height: 11rem" >
                                </div>
                            </div>
                            <!--<button type="submit" id="SubmitNumber" class="btn rounded btn-primary btn-block btn-lg" name="loginWhatsApp" disabled="" onclick="var e=this;setTimeout(function(){e.disabled=true;},0);return true;">Kirim Kode ke WhatsApp-->
                            <!--</button>-->
                            <button type="submit" id="SubmitNumber2" name="loginEmail" class="btn rounded btn-primary btn-block btn-lg" disabled="" onclick="var e=this;setTimeout(function(){e.disabled=true;},0);return true;">Kirim ke email
                                    </button>
                            <center>
                                <!--<h6>Nomor gak terhubung WhatsApp?-->
                                <!--    <button type="submit" id="SubmitNumber2" name="loginEmail" class="btn text-primary p-0" style="font-weight: bold; background: transparent !important; font-size: 11px;" disabled="" onclick="var e=this;setTimeout(function(){e.disabled=true;},0);return true;">Kirim ke email-->
                                <!--    </button>-->
                                <!--</h6>-->
                            </center>
                        </div>
                    </form>
                    </div>
                    <div class="section center mt-1 text-light">
                        <p style="font-weight: 400; font-size: 13px" class="text-light">Dengan melanjutkan, kamu setuju dengan <span class="bold">Syarat & Ketentuan</span> dan <span class="bold">Kebijakan Privasi</span> kami</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php if(isset($_SESSION['phoneError'])): ?>
<div class="modal fade dialogbox" id="msgDialog" data-backdrop="static" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="border-radius: 8px">
            <div class="modal-header"></div>
            <div class="modal-body text-dark"> 
            <img src="<?= assets('mobile/icon/daftar.svg') ?>" style="height: 5rem" >
                <div class="form-group" style="margin-bottom: 4px;">
                    <div class="input-wrapper">
                        <input type="text" class="form-control text-center" id="phone_1" name="phone" value="<?= $_SESSION['phoneError']['phone']; ?>" style="letter-spacing: 3px; font-size: 20px; background-color: #fff" readonly="">
                    </div>
                </div>
                <p class="text-danger" style="margin-bottom: .45rem;">Nomor ini tidak terdaftar</p>
                <p style="text-align: left; line-height: 20px" class="mb-0">Silahkan daftar terlebih dahulu. Klik Lanjut untuk Daftar</p>
            </div>
            <div class="modal-footer" style="border-top: 0">
                <div class="d-flex justify-content-between pl-2 pr-2 pb-2">
                    <a href="#" class="btn btn-sm btn-link text-dark" style="border-right: 0 !important; width: 42%; font-size: 13px" data-dismiss="modal">Tutup</a>
                    <a href="javascript:;" data-toggle="modal" data-target="#register" data-dismiss="modal" class="btn btn-sm btn-primary" style="width: 42%; font-size: 13px">Lanjut</a>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('#msgDialog').modal('show');
</script>
<?php 
unset($_SESSION['phoneError']);
endif;
?>
<script>
    function CheckNumber() {
        var phone = document.getElementById('phone').value;
        if(phone.length > 9) {
            $('#SubmitNumber').prop('disabled', false);
        } else {
            $('#SubmitNumber').prop('disabled', true);
        }
        if(phone.length > 9) {
            $('#SubmitNumber2').prop('disabled', false);
        } else {
            $('#SubmitNumber2').prop('disabled', true);
        }
    }
</script>