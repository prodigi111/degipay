<?php
require '../RGShenn.php';
require _DIR_('library/session/premium');
$page = 'Transfer Saldo';
require _DIR_('library/header/user');
if(in_array($data_user['level'],['Basic'])) {
    $_SESSION['result'] = ['type' => false,'message' => 'Maaf Fitur Ini Khusus Level Premium!'];
    redirect(1, base_url());
}
?>

    <!-- App Capsule -->
    <div id="appCapsule" class="rgs-deposit">

        <div class="section service">

        <form method="POST" action="konfirmasi-transfer">
            <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
            <div class="wide-block-service">
                
            <? require _DIR_('library/session/result-mobile') ?>

                <ul class="listview image-listview no-line no-space flush">
                    <li>
                        <div class="item"> 
                        <div class="icon-box bg-primary">
                                <ion-icon name="create-outline"></ion-icon>
                            </div>
                            <div class="in">
                                <div class="form-group basic">
                                    <div class="input-wrapper">
                                        <label class="label">Nomor Rekening</label>
                                        <input type="number" class="form-control" placeholder="123456781213" name="card" id="card" onInput="checkUsername()"/>
                                        <i class="clear-input">
                                            <ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon>
                                        </i>
                                    </div>
                                    <span id="check-card"></span>
                                </div>
                            </div>
                        </div>
                    </li> 
                    <li>
                        <div class="item"> 
                        <div class="icon-box bg-primary">
                                <ion-icon name="create-outline"></ion-icon>
                            </div>
                            <div class="in">
                                <div class="form-group basic">
                                    <div class="input-wrapper">
                                        <label class="label">Bank Tujuan</label>
                                        <input type="number" class="form-control" placeholder="Mandiri" name="bank-tujuan" required>
                                        <i class="clear-input">
                                            <ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon>
                                        </i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="item"> 
                        <div class="icon-box bg-primary">
                                <ion-icon name="create-outline"></ion-icon>
                            </div>
                            <div class="in">
                                <div class="form-group basic">
                                    <div class="input-wrapper">
                                        <label class="label">Nominal</label>
                                        <input type="number" class="form-control" placeholder="10.000" name="nominal" required>
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
        
    
        
        <div class="m-2">
            <h4 class="text-center mt-2">Pilih Nominal Cepat</h4>
            <div class="row text-center">
                <div class="col-4 mb-2">
                    <a href="javascript:;" onclick="depositNominal('10000')">
                        <div class="card">
                            <div class="card-body">
                                <h6>Rp 10.000</h6>
                            </div>
                        </div>
                    </a>    
                </div>
                <div class="col-4 mb-2">
                    <a href="javascript:;" onclick="depositNominal('25000')">
                        <div class="card">
                            <div class="card-body">
                                <h6>Rp 25.000</h6>
                            </div>
                        </div>
                    </a>    
                </div>
                <div class="col-4 mb-2">
                    <a href="javascript:;" onclick="depositNominal('50000')">
                        <div class="card">
                            <div class="card-body">
                                <h6>Rp 50.000</h6>
                            </div>
                        </div>
                    </a>    
                </div>
                <div class="col-4 mb-2">
                    <a href="javascript:;" onclick="depositNominal('100000')">
                        <div class="card">
                            <div class="card-body">
                                <h6>Rp 100.000</h6>
                            </div>
                        </div>
                    </a>    
                </div>
                <div class="col-4 mb-2">
                    <a href="javascript:;" onclick="depositNominal('250000')">
                        <div class="card">
                            <div class="card-body">
                                <h6>Rp 250.000</h6>
                            </div>
                        </div>
                    </a>    
                </div>
                <div class="col-4 mb-2">
                    <a href="javascript:;" onclick="depositNominal('500000')">
                        <div class="card">
                            <div class="card-body">
                                <h6>Rp 500.000</h6>
                            </div>
                        </div>
                    </a>    
                </div>
        

            <div class="form-button-group">
                <button type="submit" class="btn btn-primary btn-block btn-lg">Lanjutkan</a>
            </div>
        </form>
       </div>
        </div>
    </div>
    <!-- * App Capsule -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script>
        function checkUsername() {
            
            $.ajax({
            url: "<?= ajaxlib('check-card.php') ?>",
            data:'card='+$("#card").val(),
            type: "POST",
            success:function(data){
                $("#check-card").html(data);
            },
            error:function (){}
            });
        }
    </script>

<?php require _DIR_('library/footer/user') ?>