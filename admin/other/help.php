<?php 
require '../../connect.php';
if(!isset($_SESSION['user']) && !isset($_COOKIE['token']) && !isset($_COOKIE['ssid'])) {
        $ShennID = $_COOKIE['ssid'];
        $ShennUID = str_replace(['SHENN-A','AIY'],'',$ShennID) + 0;
        $ShennKey = $_COOKIE['token'];
        $ShennUser = $call->query("SELECT * FROM users WHERE id = '$ShennUID'")->fetch_assoc();

        $ShennCheck = $call->query("SELECT * FROM users_cookie WHERE cookie = '$ShennKey' AND username = '".$ShennUser['username']."'");
        if($ShennCheck->num_rows == 1) {
            $_SESSION['user'] = $ShennUser;
            redirect(0,visited());
            $call->query("UPDATE users_cookie SET active = '$date $time' WHERE cookie = '$ShennKey'");
        } else {
            redirect(0,base_url('auth/login'));
        }
} else {
require _DIR_('library/session/admin');
}

if(isset($_POST['submit'])) {
    $post_wa= filter($_POST['wa']);
    $post_telegram = filter($_POST['telegram']);
    $post_email = filter($_POST['email']);
    $post_ig = filter($_POST['ig']);
    $post_play = filter($_POST['play']);
    
    if($result_csrf == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'System error, please try again later.'];
    } else if($data_user['level'] !== 'Admin') {
        $_SESSION['result'] = ['type' => false,'message' => 'You do not have permission to access this feature.'];
    } else if($sess_username == 'demo') {
        $_SESSION['result'] = ['type' => false,'message' => 'Demo accounts do not have permission to access this feature.'];
    } else {
        $up = $call->query("UPDATE conf SET c1 = '$post_wa', c2 = '$post_telegram', c3 = '$post_email', c4 = '$post_ig', c5 = '$post_play' WHERE code = 'bantuan-cfg'");
        if($up == TRUE) {
            $_SESSION['result'] = ['type' => true,'message' => ' Customer Service Berhasil Di update.'];
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
                              <h4 class="card-title"><i class="fas fa-envelope text-primary mr-2"></i>INFO CUSTOMER SERVICE</h4>
                           </div>
                        </div>
                        <form method="POST">
                            <div class="iq-card-body">
                                <? require _DIR_('library/session/result'); ?>
                                <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">Nomor Whatsapp</label>
                                    <div class="col-lg-9 col-xl-9">
                                        <input type="text" class="form-control" name="wa" value="<?= conf('bantuan-cfg',1) ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">Nomor Telegram</label>
                                    <div class="col-lg-9 col-xl-9">
                                        <input type="text" class="form-control" name="telegram" value="<?= conf('bantuan-cfg',2) ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">Alamat Email</label>
                                    <div class="col-lg-9 col-xl-9">
                                        <input type="text" class="form-control" name="email" value="<?= conf('bantuan-cfg',3) ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label"> Instagram</label>
                                    <div class="col-lg-9 col-xl-9">
                                        <input type="text" class="form-control" name="ig" value="<?= conf('bantuan-cfg',4) ?>">
                                    </div>
                                </div>
                            
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">Google Play Store</label>
                                    <div class="col-lg-9 col-xl-9">
                                        <input type="text" class="form-control" name="play" value="<?= conf('bantuan-cfg',5) ?>">
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