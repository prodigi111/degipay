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

if(isset($_POST['submitProfit'])) {
    $post_1 = filter($_POST['provider']);
    $post_2 = ($_POST['proftype'] == '%') ? '%' : '+';
    $post_3 = filter($_POST['profbas']);
    $post_4 = filter($_POST['profpre']);
    
    if($result_csrf == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'System error, please try again later.'];
    } else if($data_user['level'] !== 'Admin') {
        $_SESSION['result'] = ['type' => false,'message' => 'You do not have permission to access this feature.'];
    } else if($sess_username == 'demo') {
        $_SESSION['result'] = ['type' => false,'message' => 'Demo accounts do not have permission to access this feature.'];
    } else if($call->query("SELECT code FROM provider WHERE code = '$post_1'")->num_rows == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'Provider not found.'];
    } else if(!is_numeric($post_3) || !is_numeric($post_4)) {
        $_SESSION['result'] = ['type' => false,'message' => 'Profit or Points must be numeric.'];
    } else if($post_2 == '%' && $post_3 > 1) {
        $_SESSION['result'] = ['type' => false,'message' => 'If using percent, profit cannot be more than 1.'];
    } else if($post_2 == '%' && $post_4 > 1) {
        $_SESSION['result'] = ['type' => false,'message' => 'If using percent, profit cannot be more than 1.'];
    } else if($post_2 == '+' && $post_3 < 0) {
        $_SESSION['result'] = ['type' => false,'message' => 'If using plus, profit cannot be less than 0.'];
    } else if($post_2 == '+' && $post_4 < 0) {
        $_SESSION['result'] = ['type' => false,'message' => 'If using plus, profit cannot be less than 0.'];
    } else {
        $up = $call->query("UPDATE conf SET c1 = '$post_1', c2 = '$post_2', c3 = '$post_3', c4 = '$post_4' WHERE code = 'trxmove'");
        if($up == TRUE) {
            $_SESSION['result'] = ['type' => true,'message' => 'Successfully set profit.'];
        } else {
            $_SESSION['result'] = ['type' => false,'message' => 'Our server is in trouble, please try again later.'];
        }
    }
} else if(isset($_POST['submitProfitSosmed'])) {
    $post_1 = filter($_POST['provider']);
    $post_2 = ($_POST['proftype'] == '%') ? '%' : '+';
    $post_3 = filter($_POST['profbas']);
    $post_4 = filter($_POST['profpre']);
    
    if($result_csrf == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'System error, please try again later.'];
    } else if($data_user['level'] !== 'Admin') {
        $_SESSION['result'] = ['type' => false,'message' => 'You do not have permission to access this feature.'];
    } else if($sess_username == 'demo') {
        $_SESSION['result'] = ['type' => false,'message' => 'Demo accounts do not have permission to access this feature.'];
    } else if($call->query("SELECT code FROM provider WHERE code = '$post_1'")->num_rows == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'Provider not found.'];
    } else if(!is_numeric($post_3) || !is_numeric($post_4)) {
        $_SESSION['result'] = ['type' => false,'message' => 'Profit or Points must be numeric.'];
    } else if($post_2 == '%' && $post_3 > 1) {
        $_SESSION['result'] = ['type' => false,'message' => 'If using percent, profit cannot be more than 1.'];
    } else if($post_2 == '%' && $post_4 > 1) {
        $_SESSION['result'] = ['type' => false,'message' => 'If using percent, profit cannot be more than 1.'];
    } else if($post_2 == '+' && $post_3 < 0) {
        $_SESSION['result'] = ['type' => false,'message' => 'If using plus, profit cannot be less than 0.'];
    } else if($post_2 == '+' && $post_4 < 0) {
        $_SESSION['result'] = ['type' => false,'message' => 'If using plus, profit cannot be less than 0.'];
    } else {
        $up = $call->query("UPDATE conf SET c1 = '$post_1', c2 = '$post_2', c3 = '$post_3', c4 = '$post_4' WHERE code = 'trxsosmed'");
        if($up == TRUE) {
            $_SESSION['result'] = ['type' => true,'message' => 'Successfully set profit.'];
        } else {
            $_SESSION['result'] = ['type' => false,'message' => 'Our server is in trouble, please try again later.'];
        }
    }
} else if(isset($_POST['submitProfitManual'])) {
    $post_1 = filter($_POST['provider']);
    $post_2 = ($_POST['proftype'] == '%') ? '%' : '+';
    $post_3 = filter($_POST['profbas']);
    $post_4 = filter($_POST['profpre']);
    $post_5 = filter($_POST['rate_paypal']);
    
    if($result_csrf == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'System error, please try again later.'];
    } else if($data_user['level'] !== 'Admin') {
        $_SESSION['result'] = ['type' => false,'message' => 'You do not have permission to access this feature.'];
    } else if($sess_username == 'demo') {
        $_SESSION['result'] = ['type' => false,'message' => 'Demo accounts do not have permission to access this feature.'];
    } else if($call->query("SELECT code FROM provider WHERE code = '$post_1'")->num_rows == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'Provider not found.'];
    } else if(!is_numeric($post_3) || !is_numeric($post_4) || !is_numeric($post_5)) {
        $_SESSION['result'] = ['type' => false,'message' => 'Profit or Points must be numeric.'];
    } else if($post_2 == '%' && $post_3 > 1) {
        $_SESSION['result'] = ['type' => false,'message' => 'If using percent, profit cannot be more than 1.'];
    } else if($post_2 == '%' && $post_4 > 1) {
        $_SESSION['result'] = ['type' => false,'message' => 'If using percent, profit cannot be more than 1.'];
    } else if($post_2 == '+' && $post_3 < 0) {
        $_SESSION['result'] = ['type' => false,'message' => 'If using plus, profit cannot be less than 0.'];
    } else if($post_2 == '+' && $post_4 < 0) {
        $_SESSION['result'] = ['type' => false,'message' => 'If using plus, profit cannot be less than 0.'];
    } else {
        $up = $call->query("UPDATE conf SET c1 = '$post_1', c2 = '$post_2', c3 = '$post_3', c4 = '$post_4', c5 = '$post_5' WHERE code = 'trxmanual'");
        if($up == TRUE) {
            $_SESSION['result'] = ['type' => true,'message' => 'Successfully set profit.'];
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
                              <h4 class="card-title"><i class="fas fa-cogs text-primary mr-2"></i> Server, Profit & Point</h4>
                           </div>
                        </div>
                        <form method="POST">
                            <div class="iq-card-body">
                                <div id="sess-result-modal"></div>
                                <? require _DIR_('library/session/result'); ?>
                                <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
                                <div class="form-group">
                                    <label>Provider</label>
                                    <select class="form-control" name="provider">
                                        <?php
                                        $s = $call->query("SELECT * FROM provider WHERE code NOT IN ('X','MP') ORDER BY name ASC");
                                        while($r = $s->fetch_assoc()) { print select_opt(conf('trxmove',1),$r['code'],$r['name']); }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Profit Type</label>
                                    <select class="form-control" name="proftype">
                                        <?= select_opt(conf('trxmove',2),'%','(%) Percent') ?>
                                        <?= select_opt(conf('trxmove',2),'+','(+) Plus') ?>
                                    </select>
                                </div>
                                <div class="row">
                                    <div class="form-group col-6">
                                        <label>Profit Basic</label>
                                        <input type="text" class="form-control" name="profbas" value="<?= conf('trxmove',3) ?>">
                                    </div>
                                    <div class="form-group col-6">
                                        <label>Profit Premium</label>
                                        <input type="text" class="form-control" name="profpre" value="<?= conf('trxmove',4) ?>">
                                    </div>
                                </div>
                            </div>
                            <ul class="list-group list-group-flush">
                               <li class="list-group-item"></li>
                            </ul>
                            <div class="iq-card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <button type="submit" name="submitProfit" class="btn btn-block btn-primary">Submit</button>
                                    </div>
                                    <div class="col-6">
                                        <button type="submit" name="shenn_reset" class="btn btn-block btn-danger">Reset</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                     </div>
                  </div>
                  <div class="col-lg-8 offset-lg-2">
                     <div class="iq-card">
                        <div class="iq-card-header d-flex justify-content-between">
                           <div class="iq-header-title">
                              <h4 class="card-title"><i class="fas fa-cogs text-primary mr-2"></i> Server, Profit & Point Sosmed</h4>
                           </div>
                        </div>
                        <form method="POST">
                            <div class="iq-card-body">
                                <div id="sess-result-modal"></div>
                                <? require _DIR_('library/session/result'); ?>
                                <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
                                <div class="form-group">
                                    <label>Provider</label>
                                    <select class="form-control" name="provider">
                                        <?php
                                        $s = $call->query("SELECT * FROM provider WHERE code NOT IN ('X','DIGI') ORDER BY name ASC");
                                        while($r = $s->fetch_assoc()) { print select_opt(conf('trxsosmed',1),$r['code'],$r['name']); }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Profit Type</label>
                                    <select class="form-control" name="proftype">
                                        <?= select_opt(conf('trxsosmed',2),'%','(%) Percent') ?>
                                        <?= select_opt(conf('trxsosmed',2),'+','(+) Plus') ?>
                                    </select>
                                </div>
                                <div class="row">
                                    <div class="form-group col-6">
                                        <label>Profit Basic</label>
                                        <input type="text" class="form-control" name="profbas" value="<?= conf('trxsosmed',3) ?>">
                                    </div>
                                    <div class="form-group col-6">
                                        <label>Profit Premium</label>
                                        <input type="text" class="form-control" name="profpre" value="<?= conf('trxsosmed',4) ?>">
                                    </div>
                                </div>
                            </div>
                            <ul class="list-group list-group-flush">
                               <li class="list-group-item"></li>
                            </ul>
                            <div class="iq-card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <button type="submit" name="submitProfitSosmed" class="btn btn-block btn-primary">Submit</button>
                                    </div>
                                    <div class="col-6">
                                        <button type="submit" name="shenn_reset" class="btn btn-block btn-danger">Reset</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                     </div>
                  </div>
                  <div class="col-lg-8 offset-lg-2">
                     <div class="iq-card">
                        <div class="iq-card-header d-flex justify-content-between">
                           <div class="iq-header-title">
                              <h4 class="card-title"><i class="fas fa-cogs text-primary mr-2"></i> Server, Profit & Point Manual</h4>
                           </div>
                        </div>
                        <form method="POST">
                            <div class="iq-card-body">
                                <div id="sess-result-modal"></div>
                                <? require _DIR_('library/session/result'); ?>
                                <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
                                <div class="form-group">
                                    <label>Provider</label>
                                    <select class="form-control" name="provider">
                                        <?php
                                        $s = $call->query("SELECT * FROM provider WHERE code IN ('X') ORDER BY name ASC");
                                        while($r = $s->fetch_assoc()) { print select_opt(conf('trxmanual',1),$r['code'],$r['name']); }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Profit Type</label>
                                    <select class="form-control" name="proftype">
                                        <?= select_opt(conf('trxmanual',2),'%','(%) Percent') ?>
                                        <?= select_opt(conf('trxmanual',2),'+','(+) Plus') ?>
                                    </select>
                                </div>
                                <div class="row">
                                    <div class="form-group col-6">
                                        <label>Profit Basic</label>
                                        <input type="text" class="form-control" name="profbas" value="<?= conf('trxmanual',3) ?>">
                                    </div>
                                    <div class="form-group col-6">
                                        <label>Profit Premium</label>
                                        <input type="text" class="form-control" name="profpre" value="<?= conf('trxmanual',4) ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Rate Paypal</label>
                                    <input type="text" class="form-control" name="rate_paypal" value="<?= conf('trxmanual', 5) ?>">
                                </div>
                            </div>
                            <ul class="list-group list-group-flush">
                               <li class="list-group-item"></li>
                            </ul>
                            <div class="iq-card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <button type="submit" name="submitProfitManual" class="btn btn-block btn-primary">Submit</button>
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