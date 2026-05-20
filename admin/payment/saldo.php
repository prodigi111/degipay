<?php 
require '../../connect.php';
require _DIR_('library/session/admin');

if(isset($_POST['submit'])) {
    $post_nominal = filter($_POST['nominal']);
    $post_keterangan = filter($_POST['keterangan']);
    $User = $call->query("SELECT * FROM users WHERE level = 'Premium'")->fetch_assoc();
    $search = $call->query("SELECT * FROM users WHERE level = 'Premium'")->num_rows == (0);
    $post_user = $User['username'];
    $post_level = $level['level'];
    
    
    
    if($result_csrf == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'System error, please try again later.'];
    } else if($data_user['level'] !== 'Admin') {
        $_SESSION['result'] = ['type' => false,'message' => 'You do not have permission to access this feature.'];
    } else if($sess_username == 'demo') {
        $_SESSION['result'] = ['type' => false,'message' => 'Demo accounts do not have permission to access this feature.'];
    } else {
      //  if($call->query("SELECT * FROM users WHERE level = 'Premium'")->num_rows == 0) {
            if($call->query("UPDATE users SET balance = balance+$post_nominal WHERE username = '$post_user'") == true ){
            $call->query("INSERT INTO logs VALUES ('','$post_user','$post_keterangan','$post_ip','$datetime')");
            $call->query("INSERT INTO mutation VALUES ('','$post_user','+','$post_nominal','$post_keterangan', '$date', '$time', 'Deposit')");
    
            $_SESSION['result'] = ['type' => true,'message' => 'Saldo Berhasil Di transfer.'];
        } else {
            $_SESSION['result'] = ['type' => false,'message' => 'Our server is in trouble, please try again later.'];
        }
    }
}

require _DIR_('library/header/admin');
?>
                  <div class="col-lg-8 offset-lg-2">
                     <div class="iq-card">
                        <div class="iq-card-header d-flex justify-content-between">
                           <div class="iq-header-title">
                              <h4 class="card-title"><i class="fas fa-envelope text-primary mr-2"></i> PAYMENT GATEWAY</h4>
                           </div>
                        </div>
                        <form method="POST">
                            <div class="iq-card-body">
                                <? require _DIR_('library/session/result'); ?>
                                <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">Jumlah</label>
                                    <div class="col-lg-9 col-xl-9">
                                        <input type="text" class="form-control" name="nominal" value="1000">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">keterangan</label>
                                    <div class="col-lg-9 col-xl-9">
                                        <input type="text" class="form-control" name="keterangan" value="keterangan">
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