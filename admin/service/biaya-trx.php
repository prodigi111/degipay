<?php 
require '../../connect.php';
require _DIR_('library/session/admin');

if(isset($_POST['submit'])) {
    $post1 = filter($_POST['biaya_basic']);
    $post2 = filter($_POST['biaya_premium']);
    
    if($result_csrf == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'System error, please try again later.'];
    } else if($data_user['level'] !== 'Admin') {
        $_SESSION['result'] = ['type' => false,'message' => 'You do not have permission to access this feature.'];
    } else if($sess_username == 'demo') {
        $_SESSION['result'] = ['type' => false,'message' => 'Demo accounts do not have permission to access this feature.'];
    } else {
        $up = $call->query("UPDATE conf SET c3 = '$post1', c4 = '$post2' WHERE code = 'trxadmin'");
        if($up == TRUE) {
            $_SESSION['result'] = ['type' => true,'message' => 'Pengaturan Biaya Admin Diubah.'];
        } else {
            $_SESSION['result'] = ['type' => false,'message' => 'Our server is in trouble, please try again later.'];
        }
    }
}

require _DIR_('library/header/admin');
?>
                    <div class="col-lg-8 offset-lg-2">
                    <? require _DIR_('library/session/result'); ?>
                    </div>
                  <div class="col-lg-8 offset-lg-2">
                     <div class="iq-card">
                        <div class="iq-card-header d-flex justify-content-between">
                           <div class="iq-header-title">
                              <h4 class="card-title">Biaya Admin Premium & Basic</h4>
                           </div>
                        </div>
                        <form method="POST">
                            <div class="iq-card-body">
                                <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">Biaya Transaksi Basic</label>
                                    <div class="col-lg-9 col-xl-9">
                                        <input type="text" class="form-control" name="biaya_basic" value="<?= conf('trxadmin', 3) ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">Biaya Transaksi Premium</label>
                                    <div class="col-lg-9 col-xl-9">
                                        <input type="text" class="form-control" name="biaya_premium" value="<?= conf('trxadmin', 4) ?>">
                                    </div>
                                </div>
                            </div>
                            <ul class="list-group list-group-flush">
                               <li class="list-group-item"></li>
                            </ul>
                            <div class="iq-card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <button type="submit" name="submit" class="btn btn-block btn-primary">Submit</button>
                                    </div>
                                    <div class="col-6">
                                        <button type="submit" name="shenn_reset" class="btn btn-block btn-danger">Reset</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                     </div>
                  </div>
                  
<? require _DIR_('library/footer/admin'); ?>