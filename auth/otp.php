<div class="login-form">
    <div class="section mt-3">
        <h5 class="text-light">Kami mengirimkan kode verfikasi ke email & nomor whatsapp Anda.</h5>
    </div>
    <div class="section mb-5">
        <form id="FormCheckOTP" method="POST">
        <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
            <div class="form-group boxed">
                <div class="input-wrapper d-flex justify-content-between">
                    <input type="hidden" id="otpcode" name="otpcode">
                    <input id="codeBox1" type="tel" maxlength="1" onkeyup="onKeyUpEvent(1, event)" onfocus="onFocusEvent(1)" class="form-control verify-input" data-inputmask="'placeholder': ''" placeholder="_" style="color: #495057 !important; height: 45px !important; width: 45px;">
                    <input id="codeBox2" type="tel" maxlength="1" onkeyup="onKeyUpEvent(2, event)" onfocus="onFocusEvent(2)" class="form-control verify-input" data-inputmask="'placeholder': ''" placeholder="_" style="color: #495057 !important; height: 45px !important; width: 45px;">
                    <input id="codeBox3" type="tel" maxlength="1" onkeyup="onKeyUpEvent(3, event)" onfocus="onFocusEvent(3)" class="form-control verify-input" data-inputmask="'placeholder': ''" placeholder="_" style="color: #495057 !important; height: 45px !important; width: 45px;">
                    <input id="codeBox4" type="tel" maxlength="1" onkeyup="onKeyUpEvent(4, event)" onfocus="onFocusEvent(4)" class="form-control verify-input" data-inputmask="'placeholder': ''" placeholder="_" style="color: #495057 !important; height: 45px !important; width: 45px;">
                    <input id="codeBox5" type="tel" maxlength="1" onkeyup="onKeyUpEvent(5, event)" onfocus="onFocusEvent(5)" class="form-control verify-input" data-inputmask="'placeholder': ''" placeholder="_" style="color: #495057 !important; height: 45px !important; width: 45px;">
                    <input id="codeBox6" type="tel" maxlength="1" onkeyup="onKeyUpEvent(6, event)" onfocus="onFocusEvent(6)" class="form-control verify-input" data-inputmask="'placeholder': ''" placeholder="_" style="color: #495057 !important; height: 45px !important; width: 45px;">
					<!-- <input type="text" class="form-control" name="otpcode" placeholder="Masukkan Kode Verifikasi"> -->
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
            <div class="form-button-group bg-primary-new">
                <button type="submit" name="<?= $action; ?>" class="btn rounded btn-text-primary btn-block btn-lg">Konfirmasi</a>
            </div>
        </form>
    </div>
</div>
<script>
function getCodeBoxElement(index) {
    return document.getElementById('codeBox' + index);
}

function onKeyUpEvent(index, event) {
    var types = [];
    const eventCode = event.which || event.keyCode;
    if (getCodeBoxElement(index).value.length === 1) {
        if (index !== 6) {
            getCodeBoxElement(index + 1).focus();
        } else {
            getCodeBoxElement(index).blur();
        }
    }
    if (eventCode === 8 && index !== 1) {
        getCodeBoxElement(index - 1).focus();
    }
    $("input[type='tel']").each(function() {
        types.push($(this).val());
    });
    $('input[id="otpcode"]').val(types.join(''));
}

function onFocusEvent(index) {
    for (item = 1; item < index; item++) {
        const currentElement = getCodeBoxElement(item);
        if (!currentElement.value) {
            currentElement.focus();
            break;
        }
    }
}
</script>