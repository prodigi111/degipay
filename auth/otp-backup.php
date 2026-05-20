<div class="login-form">
    <div class="section mt-3">
        <h5 class="text-light">Kami mengirimkan kode verfikasi ke email & whatsapp Anda.</h5>
    </div>
    <div class="section mb-5">
        <form id="FormCheckOTP" method="POST">
            <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
            <div class="form-group boxed">
                <div class="input-wrapper d-flex justify-content-between">
                    <input type="hidden" id="otpcode" name="otpcode">
                    <input type="tel" onkeyup="MoveOn(this.form.smscode1)" data-inputmask="'mask': '9', 'placeholder': ''" class="form-control verify-input" id="smscode" name="smscode1" placeholder="_" style="color: #495057 !important; height: 45px !important; width: 45px;">
                    <input type="tel" onkeyup="MoveOn(this.form.smscode2)" data-inputmask="'mask': '9', 'placeholder': ''" class="form-control verify-input" id="smscode" name="smscode2" placeholder="_" style="color: #495057 !important; height: 45px !important; width: 45px;">
                    <input type="tel" onkeyup="MoveOn(this.form.smscode3)" data-inputmask="'mask': '9', 'placeholder': ''" class="form-control verify-input" id="smscode" name="smscode3" placeholder="_" style="color: #495057 !important; height: 45px !important; width: 45px;">
                    <input type="tel" onkeyup="MoveOn(this.form.smscode4)" data-inputmask="'mask': '9', 'placeholder': ''" class="form-control verify-input" id="smscode" name="smscode4" placeholder="_" style="color: #495057 !important; height: 45px !important; width: 45px;">
                    <input type="tel" onkeyup="MoveOn(this.form.smscode5)" data-inputmask="'mask': '9', 'placeholder': ''" class="form-control verify-input" id="smscode" name="smscode5" placeholder="_" style="color: #495057 !important; height: 45px !important; width: 45px;">
                    <input type="tel" onkeyup="MoveOn(this.form.smscode6)" data-inputmask="'mask': '9', 'placeholder': ''" class="form-control verify-input" id="smscode" name="smscode6" placeholder="_" style="color: #495057 !important; height: 45px !important; width: 45px;">
                </div>
                <div class="form-links mt-1">
                    <div>
                        <button type="submit" class="btn btn-sm text-light" name="resend_otp" onclick="var e=this;setTimeout(function(){e.disabled=true;},0);return true;"> Kirim Ulang </button>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-sm text-light" name="cancel" onclick="var e=this;setTimeout(function(){e.disabled=true;},0);return true;"> Batalkan </button>
                    </div>
                </div>
            </div>
            <div class="form-button-group bg-primary">
                <button type="submit" name="<?= $action; ?>" onclick="var e=this;setTimeout(function(){e.disabled=true;},0);return true;" class="btn btn-text-primary btn-block btn-lg">Konfirmasi</a>
            </div>
        </form>
    </div>
</div>
<script>
    function MoveOn(field) {
        var types = [];
        if(field.value.length >= 1) {
            $(field).next().focus();
            $("input[id='smscode']").each(function() {
                types.push($(this).val());
            });
        } else {
            $(field).prev().focus();
            $("input[id='smscode']").each(function() {
                types.push($(this).val());
            });
        }
        $('input[id="otpcode"]').val(types.join(''));
    }
</script>