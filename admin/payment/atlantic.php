<?php 
require '../../connect.php';
require _DIR_('library/session/admin');

if(isset($_POST['submit'])) {
    $post_1 = filter($_POST['apiId']);
    $post_2 = filter($_POST['apiKey']);
    $post_3 = filter($_POST['mutationId']);
    $post_4 = filter($_POST['whatsappId']);
    $post_5 = ($_POST['proxyUse'] == 'true') ? 'true' : 'false';
    $post_6 = filter($_POST['proxyUrl']);
    $post_7 = filter($_POST['proxyAuth']);
    $post_8 = filter($_POST['notifTo']);
    
    $try = $curl->connectPost('https://atlantic-group.co.id/api/v1/validation', ['key' => $post_2,'sign' => md5($post_1.$post_2)]);
    if($result_csrf == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'System error, please try again later.'];
    } else if($data_user['level'] !== 'Admin') {
        $_SESSION['result'] = ['type' => false,'message' => 'You do not have permission to access this feature.'];
    } else if($sess_username == 'demo') {
        $_SESSION['result'] = ['type' => false,'message' => 'Demo accounts do not have permission to access this feature.'];
    } else if(!empty($post_1) && !empty($post_2) && $try['result'] == false) {
        $_SESSION['result'] = ['type' => false,'message' => $try['message']];
    } else {
        $up = $call->query("UPDATE conf SET c1 = '$post_1', c2 = '$post_2', c3 = '$post_3', c4 = '$post_4', c5 = '$post_5', c6 = '$post_6', c7 = '$post_7', c8 = '$post_8' WHERE code = 'atlantic-cfg'");
        if($up == TRUE) {
            $_SESSION['result'] = ['type' => true,'message' => 'Successfully set Atlantic Config.'];
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
                              <h4 class="card-title"><i class="fas fa-cogs text-primary mr-2"></i> Atlantic Group</h4>
                           </div>
                        </div>
                        <form method="POST">
                            <div class="iq-card-body">
                                <div id="sess-result-modal"></div>
                                <? require _DIR_('library/session/result'); ?>
                                <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
                                <div class="row">
                                    <div class="form-group col-md-4 col-12">
                                        <label>API Auth</label>
                                        <input type="text" class="form-control" name="apiId" value="<?= isset($_POST['apiId']) ? $_POST['apiId'] : conf('atlantic-cfg',1) ?>">
                                    </div>
                                    <div class="form-group col-md-8 col-12">
                                        <label>API Key</label>
                                        <input type="text" class="form-control" name="apiKey" value="<?= isset($_POST['apiKey']) ? $_POST['apiKey'] : conf('atlantic-cfg',2) ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 col-12">
                                        <label>Mutation ID</label>
                                        <input type="text" class="form-control" name="mutationId" value="<?= isset($_POST['mutationId']) ? $_POST['mutationId'] : conf('atlantic-cfg',3) ?>">
                                    </div>
                                    <div class="form-group col-md-6 col-12">
                                        <label>Whatsapp ID</label>
                                        <input type="text" class="form-control" name="whatsappId" value="<?= isset($_POST['whatsappId']) ? $_POST['whatsappId'] : conf('atlantic-cfg',4) ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Proxy Use</label>
                                    <select class="form-control" name="proxyUse">
                                        <option value="false"<?= (conf('atlantic-cfg',5) == 'false') ? ' selected' : '' ?>>FALSE <?= (conf('atlantic-cfg',5) == 'false') ? '(SELECTED)' : '' ?></option>
                                        <option value="true"<?= (conf('atlantic-cfg',5) == 'true') ? ' selected' : '' ?>>TRUE <?= (conf('atlantic-cfg',5) == 'true') ? '(SELECTED)' : '' ?></option>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label>Proxy URL</label>
                                    <input type="text" class="form-control" name="proxyUrl" value="<?= isset($_POST['proxyUrl']) ? $_POST['proxyUrl'] : conf('atlantic-cfg',6) ?>">
                                </div>
                                <div class="form-group">
                                    <label>Proxy Authentication</label>
                                    <input type="text" class="form-control" name="proxyAuth" value="<?= isset($_POST['proxyAuth']) ? $_POST['proxyAuth'] : conf('atlantic-cfg',7) ?>">
                                </div>
                                <div class="form-group">
                                    <label>Phone Number</label>
                                    <input type="text" class="form-control" name="notifTo" value="<?= isset($_POST['notifTo']) ? $_POST['notifTo'] : conf('atlantic-cfg',8) ?>">
                                    <small class="text-danger">Bisa diisi dengan nomor wa, nama / id grup wa untuk notifikasi deposit dan order manual.</small>
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