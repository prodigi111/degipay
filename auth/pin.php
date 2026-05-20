<div class="login-form">
    <div class="section mt-5 mb-5">
        <h4 class="text-light">Silahkan masukkan PIN untuk melanjutkan.</h4>
    </div>
    <div class="section mb-5">
        <div class="form-group boxed" style="padding-left: 12px; padding-right: 12px">
            <div class="input-wrapper d-flex justify-content-between" style="font-size: 35px; color: #FFF">
                <ion-icon name="radio-button-off-outline" class="bulb-2"></ion-icon>
                <ion-icon name="radio-button-off-outline" class="bulb-2"></ion-icon>
                <ion-icon name="radio-button-off-outline" class="bulb-2"></ion-icon>
                <ion-icon name="radio-button-off-outline" class="bulb-2"></ion-icon>
                <ion-icon name="radio-button-off-outline" class="bulb-2"></ion-icon>
                <ion-icon name="radio-button-off-outline" class="bulb-2"></ion-icon>
            </div>
        </div>
        <a href="#" class="text-white bold" data-toggle="modal" data-target="#lupa-pin">LUPA PIN?</a>
    </div>
    <div class="section full mt-2" style="position: absolute; bottom: 0; left: 0; right: 0; padding-bottom: 2rem;">
        <div class="d-flex justify-content-around">
            <button type="button" onclick="NumberButton(this.value)" value="1" class="number-box">1</button>
            <button type="button" onclick="NumberButton(this.value)" value="2" class="number-box">2</button>
            <button type="button" onclick="NumberButton(this.value)" value="3" class="number-box">3</button>
        </div>
        <div class="d-flex justify-content-around pt-2">
            <button type="button" onclick="NumberButton(this.value)" value="4" class="number-box">4</button>
            <button type="button" onclick="NumberButton(this.value)" value="5" class="number-box">5</button>
            <button type="button" onclick="NumberButton(this.value)" value="6" class="number-box">6</button>
        </div>
        <div class="d-flex justify-content-around pt-2">
            <button type="button" onclick="NumberButton(this.value)" value="7" class="number-box">7</button>
            <button type="button" onclick="NumberButton(this.value)" value="8" class="number-box">8</button>
            <button type="button" onclick="NumberButton(this.value)" value="9" class="number-box">9</button>
        </div>
        <div class="d-flex justify-content-around pt-2">
            <div class="p-4"></div>
            <button type="button" onclick="NumberButton(this.value)" value="0" class="number-box">0</button>
            <button type="button" onclick="NumberButton(this.value)" value="backspace" class="number-box"><ion-icon name="close"></ion-icon></button>
        </div>
    </div>
</div>
<div class="modal fade modalbox" id="lupa-pin" data-backdrop="static" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content bg-primary">
            <div class="modal-header bg-primary" style="border-bottom: 0; font-size: 26px">
                <a href="javascript:;" class="text-light" data-dismiss="modal">
                    <ion-icon name="chevron-back-outline"></ion-icon>
                </a>
                <h3 class="text-center text-white">Lupa Pin</h3>
              <!--  <img src="<?= assets('mobile/img/Logo/logo.png'); ?>" alt="logo" class="logo" style="max-height:115px;padding:20px 22.5px 10px 10px;"> -->
                <span> </span>
            </div>
            <div class="modal-body">
                <div class="login-form">
                    <div class="section center mt-3 pb-3 text-light">
                        <h4 style="font-weight: 400" class="text-light">Masukkan <span class="bold">Nomor HP</span> kamu untuk lanjut.</h4>
                    </div>
                    <div class="section mb-3">
                        <form id="FormCheckPhone" method="POST">
                            <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
                            <div class="form-group">
                                <div class="form-control-wrap">
                                    <div class="form-icon form-icon-left ml-1">
                                        <img src="<?= assets('mobile/icon/indonesia.svg').'?'.time() ?>" class="imaged w24" style="border: 1px solid #e1e1e1; border-radius: 4px;">
                                        <span class="bold text-dark pl-1">+62</span>
                                    </div>
                                    <input type="tel" data-inputmask="'mask': '999[-9999][-99999]', 'placeholder': ''" onkeyup="CheckNumber();" class="form-control" id="phone" name="user" style="color: #6c757d; padding-left: 5.10rem; border-radius: 15px" placeholder="812-3456-7890">
                                </div>
                            </div>
                            <div class="form-button-group bg-primary" style="min-height: 55px !important">
                                <button type="submit" id="SubmitNumber" name="repin" class="btn btn-block btn-lg  text-white" style="font-weight: bold; background: transparent !important; font-size: 15px;">Lanjut</button>
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
<div class="modal fade dialogbox" id="confirmDialog" data-backdrop="static" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="border-radius: 8px">
            <form method="POST">
                <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
                <input type="hidden" id="pin" name="pin">
                <div class="modal-header"></div>
                <div class="modal-body text-dark">
                    <p style="margin-bottom: .45rem; font-weight: bold">Konfirmasi PIN</p>
                    <p style="line-height: 20px" class="mb-0">Klik Lanjutkan untuk konfirmasi PIN.</p>
                </div>
                <div class="modal-footer" style="border-top: 0">
                    <div class="d-flex justify-content-between pl-2 pr-2 pb-2">
                        <a href="#" class="btn btn-sm btn-link text-dark goCancel" style="border-right: 0 !important; width: 42%; font-size: 13px">Tutup</a>
                        <button type="submit" class="btn btn-sm btn-primary" name="verifPin" style="width: 42%; font-size: 13px">Lanjut</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('.goCancel').click(function(e) {
            e.preventDefault();
            $('#pin').val('');
            $('#confirmDialog').modal('hide');
            $('.bulb-2').attr('name', 'radio-button-off-outline');
        })
    });
    function NumberButton(key) {
        let input = document.querySelector('#pin'),
            bulb = document.querySelectorAll('.bulb-2');
        if(key != "backspace"){
            for (i = 0; i < key.length; i++) {
                input.value = input.value + event.currentTarget.value;
            }
        } else {
            for (i=input.value.length-1; i>=0;  i--) {
                 bulb[i].setAttribute("name", "radio-button-off-outline");
            }
            input.value = input.value.substring(0, input.value.length -1);
        }
        let pin = input.value.replace(/[^0-9]/g, '');
        for (i = 0; i < pin.length;  i++) {
            bulb[i].setAttribute("name", "radio-button-on-outline");
        }
        if(pin.length === 6) {
            $('#confirmDialog').modal('show');
        }
    }
</script>