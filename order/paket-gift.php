<?php
require '../RGShenn.php';
require _DIR_('library/session/user');
require 'action.php';
$page = isset($_SESSION['success']) ? 'Pembayaran Berhasil' : 'Pulsa Transfer';
require _DIR_('library/header/user');
?>

<? if(isset($_SESSION['success'])) :  ?>

    <? require _DIR_('order/result') ?>

<? unset($_SESSION['success']); else: ?>

    <!-- App Capsule -->
    <div id="appCapsule" class="rgs-order">
        <div class="section full mb-2">
            <div class="wide-block pb-1 pt-1">

                <ul class="listview image-listview no-line no-space flush">
                    <li>
                        <div class="item">
                            <img src="<?= assets('mobile/img/home/indosat.png') ?>" width="44px" class="image" id="RGSLogo">
                            <div class="in">
                                <div class="form-group basic">
                                    <div class="input-wrapper">
                                        <label class="label">Nomor Tujuan</label>
                                        <input type="number" class="form-control" placeholder="085610110328" name="data" id="data">
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
        </div>

        <div class="section rgs-list-layanan" id="service">
            <? require _DIR_('library/session/result-mobile') ?>
        </div>
    </div>
    <!-- * App Capsule -->
<? endif ?>   
<?php require _DIR_('library/footer/user') ?>
<script type="text/javascript">
$(document).ready(function() {
    $("#data").keyup(function() {
        var target = $("#data").val();
        $.ajax({
            type: 'POST',
            data: 'phone=' + target + '&type=pulsa-gift&csrf_token=<?= $csrf_string ?>',
            url: '<?= ajaxlib('service-simcard.php') ?>',
            dataType: 'json',
            success: function(msg) {
                $("#service").html(msg.service);
                $("#RGSLogo").attr('src', msg.image);
            }
        });
    });
});
</script>