<?php 
require '../../connect.php';
require _DIR_('library/session/admin');
$force_result = false;

if(isset($_GET['reset'])) {
    $token = filter(base64_decode($_GET['reset']));
    if($data_user['level'] !== 'Admin') {
        $_SESSION['result'] = ['type' => false,'message' => 'You do not have permission to access this feature.'];
    } else if($sess_username == 'demo') {
        $_SESSION['result'] = ['type' => false,'message' => 'Demo accounts do not have permission to access this feature.'];
    } else if($call->query("SELECT code FROM provider WHERE code = '$token'")->num_rows == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'Provider not found.'];
    } else {
        $up = $call->query("UPDATE provider SET uid = '', ukey = '', sync = '$date $time', balance = '0', info = '' WHERE code = '$token'");
        if($up == TRUE) {
            $_SESSION['result'] = ['type' => true,'message' => 'Provider successfully reset.'];
        } else {
            $_SESSION['result'] = ['type' => false,'message' => 'Our server is in trouble, please try again later.'];
        }
    }
    $force_result = true;
    redirect(0,base_url('admin/service/provider'));
} if(isset($_POST['change'])) {
    $post_code = filter(base64_decode($_POST['web_token']));
    $post_uid = filter($_POST['uid']);
    $post_key = filter($_POST['key']);
    $post_info = filter($_POST['info']);
    
    if($result_csrf == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'System error, please try again later.'];
    } else if($data_user['level'] !== 'Admin') {
        $_SESSION['result'] = ['type' => false,'message' => 'You do not have permission to access this feature.'];
    } else if($sess_username == 'demo') {
        $_SESSION['result'] = ['type' => false,'message' => 'Demo accounts do not have permission to access this feature.'];
    } else if(!$post_key) {
        $_SESSION['result'] = ['type' => false,'message' => 'There are still empty columns.'];
    } else if($call->query("SELECT code FROM provider WHERE code = '$post_code'")->num_rows == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'Provider not found.'];
    } else {
        $up = $call->query("UPDATE provider SET uid = '$post_uid', ukey = '$post_key', sync = '$date $time', balance = '0', info = '$post_info' WHERE code = '$post_code'");
        if($up == TRUE) {
            $_SESSION['result'] = ['type' => true,'message' => 'Provider successfully changed.'];
        } else {
            $_SESSION['result'] = ['type' => false,'message' => 'Our server is in trouble, please try again later.'];
        }
    }
}

require _DIR_('library/header/admin');
?>
                <div class="col-lg-12">
                    <div class="iq-card">
                        <div class="iq-card-header d-flex justify-content-between">
                           <div class="iq-header-title">
                              <h4 class="card-title"><i class="fas fa-credit-card text-primary mr-2"></i> Provider</h4>
                           </div>
                        </div>
                        <div class="iq-card-body">
                            <? if($force_result == false) require _DIR_('library/session/result'); ?>
                            <div class="table-responsive">
                                <table id="datatable-responsive" class="table table-striped table-bordered nowrap">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Sync</th>
                                            <th>Saldo</th>
                                            <th>Informasi</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
            <?php
            $search = $call->query("SELECT * FROM provider ORDER BY name ASC");
            while($row = $search->fetch_assoc()) {
            ?>
                                        <tr>
                                            <td><?= $row['name'] ?><br>Code: <?= $row['code'] ?></td>
                                            <td><?= format_date('en',$row['sync']) ?></td>
                                            <td><?= 'Rp '.currency($row['balance']) ?></td>
                                            <td><?= $row['info'] ?></td>
                                            <td align="center">
                                                <a href="javascript:;" onclick="modal('Edit Provider','<?= base_url('admin/service/provider-detail?q='.base64_encode($row['code'])) ?>','','md')" class="btn btn-sm btn-warning text-white">
                                                    <i class="fas fa-pencil-alt" title="Edit Provider"></i>
                                                </a>
                                                <a href="<?= base_url('admin/service/provider?reset='.base64_encode($row['code'])) ?>" class="btn btn-sm btn-danger text-white">
                                                    <i class="fas fa-trash" title="Reset Provider"></i>
                                                </a>
                                            </td>
                                        </tr>
            <? } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
<? require _DIR_('library/footer/admin'); ?>