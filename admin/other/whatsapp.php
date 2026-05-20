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
    $post_url = filter($_POST['url']);
    $post_apikey = filter($_POST['apikey']);
    $post_sender = filter($_POST['sender']); 
    $post_admin = filter($_POST['admin']);
    
    
    if($result_csrf == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'System error, please try again later.'];
    } else if($data_user['level'] !== 'Admin') {
        $_SESSION['result'] = ['type' => false,'message' => 'You do not have permission to access this feature.'];
    } else if($sess_username == 'demo') {
        $_SESSION['result'] = ['type' => false,'message' => 'Demo accounts do not have permission to access this feature.'];
    } else {
        $up = $call->query("UPDATE conf SET c1 = '$post_url', c2 = '$post_apikey', c3 = '$post_sender' , c4 = '$post_admin' WHERE code = 'WhatsApp'");
        if($up == TRUE) {
            $_SESSION['result'] = ['type' => true,'message' => 'WhatsApp successfully changed.'];
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
                              <h4 class="card-title"><i class="fas fa-whatsapp text-primary mr-2"></i> WhatsApp</h4>
                           </div>
                        </div>
                        <form method="POST">
                            <div class="iq-card-body">
                                <? require _DIR_('library/session/result'); ?>
                                <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">Url</label>
                                    <div class="col-lg-9 col-xl-9">
                                        <input type="text" class="form-control" name="url" value="<?= conf('WhatsApp',1) ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">Api Key</label>
                                    <div class="col-lg-9 col-xl-9">
                                        <input type="text" class="form-control" name="apikey" value="<?= conf('WhatsApp',2) ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">Sender</label>
                                    <div class="col-lg-9 col-xl-9">
                                        <input type="text" class="form-control" name="sender" value="<?= conf('WhatsApp',3) ?>">
                                    </div>
                                </div> 
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">Wa Admin</label>
                                    <div class="col-lg-9 col-xl-9">
                                        <input type="text" class="form-control" name="admin" value="<?= conf('WhatsApp',4) ?>">
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