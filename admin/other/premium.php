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
    $post1 = filter($_POST['komisiTrx']);
    $post2 = filter($_POST['komisiUpgrade']);
    $post3 = filter($_POST['pointTrx']);
    $post4 = filter($_POST['biayaUpgrade']);
    
    if($result_csrf == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'System error, please try again later.'];
    } else if($data_user['level'] !== 'Admin') {
        $_SESSION['result'] = ['type' => false,'message' => 'You do not have permission to access this feature.'];
    } else if($sess_username == 'demo') {
        $_SESSION['result'] = ['type' => false,'message' => 'Demo accounts do not have permission to access this feature.'];
    } else {
        $up = $call->query("UPDATE conf SET c1 = '$post1', c2 = '$post2', c3 = '$post3', c4 = '$post4' WHERE code = 'referral'");
        if($up == TRUE) {
            $_SESSION['result'] = ['type' => true,'message' => 'Pengaturan Biaya Refferal Diubah.'];
        } else {
            $_SESSION['result'] = ['type' => false,'message' => 'Our server is in trouble, please try again later.'];
        }
    }
} else if(isset($_POST['move'])) {
    $post1 = filter($_POST['biaya_basic']);
    $post2 = filter($_POST['biaya_premium']);
    
    if($result_csrf == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'System error, please try again later.'];
    } else if($data_user['level'] !== 'Admin') {
        $_SESSION['result'] = ['type' => false,'message' => 'You do not have permission to access this feature.'];
    } else if($sess_username == 'demo') {
        $_SESSION['result'] = ['type' => false,'message' => 'Demo accounts do not have permission to access this feature.'];
    } else {
        $up = $call->query("UPDATE conf SET c3 = '$post1', c4 = '$post2' WHERE code = 'trxmove'");
        if($up == TRUE) {
            $_SESSION['result'] = ['type' => true,'message' => 'Pengaturan Biaya Produk Digi Diubah.'];
        } else {
            $_SESSION['result'] = ['type' => false,'message' => 'Our server is in trouble, please try again later.'];
        }
    }
} else if(isset($_POST['manual'])) {
    $post1 = filter($_POST['biaya_basic']);
    $post2 = filter($_POST['biaya_premium']);
    $post3 = filter($_POST['rate_paypal']);
    
    if($result_csrf == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'System error, please try again later.'];
    } else if($data_user['level'] !== 'Admin') {
        $_SESSION['result'] = ['type' => false,'message' => 'You do not have permission to access this feature.'];
    } else if($sess_username == 'demo') {
        $_SESSION['result'] = ['type' => false,'message' => 'Demo accounts do not have permission to access this feature.'];
    } else {
        $up = $call->query("UPDATE conf SET c3 = '$post1', c4 = '$post2', c5 = '$post3' WHERE code = 'trxmanual'");
        if($up == TRUE) {
            $_SESSION['result'] = ['type' => true,'message' => 'Pengaturan Biaya Produk Manual Diubah.'];
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
                              <h4 class="card-title">Biaya Refferal Premium & Point</h4>
                           </div>
                        </div>
                        <form method="POST">
                            <div class="iq-card-body">
                                <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">Komisi Transaksi</label>
                                    <div class="col-lg-9 col-xl-9">
                                        <input type="text" class="form-control" name="komisiTrx" value="<?= conf('referral', 1) ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">Point Transaksi</label>
                                    <div class="col-lg-9 col-xl-9">
                                        <input type="text" class="form-control" name="pointTrx" value="<?= conf('referral', 3) ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">Komisi Upgrade</label>
                                    <div class="col-lg-9 col-xl-9">
                                        <input type="text" class="form-control" name="komisiUpgrade" value="<?= conf('referral', 2) ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">Biaya Upgrade Premium</label>
                                    <div class="col-lg-9 col-xl-9">
                                        <input type="text" class="form-control" name="biayaUpgrade" value="<?= conf('referral', 4) ?>">
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