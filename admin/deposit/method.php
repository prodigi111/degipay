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
    } else if($call->query("SELECT code FROM deposit_method WHERE code = '$token'")->num_rows == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'Deposit method not found.'];
    } else {
        $up = $call->query("UPDATE deposit_method SET data = '', min = '0', fee = '0', keterangan = '' WHERE code = '$token'");
        if($up == TRUE) {
            $_SESSION['result'] = ['type' => true,'message' => 'Deposit method successfully reset.'];
        } else {
            $_SESSION['result'] = ['type' => false,'message' => 'Our server is in trouble, please try again later.'];
        }
    }
    $force_result = true;
    redirect(0,base_url('admin/deposit/method'));
} if(isset($_POST['change'])) {
    $post_code = filter(base64_decode($_POST['web_token']));
    $post_name = filter(ucwords(str_replace('a/n','',strtolower($_POST['name']))));
    $post_number = filter(str_replace('a/n','',strtolower($_POST['number'])));
    $post_minimal = filter($_POST['minimal']); 
    $post_fee = filter($_POST['fee']);
    $post_account = "$post_number A/n $post_name";
    $post_note = filter(ucwords($_POST['keterangan']));
    
    if($result_csrf == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'System error, please try again later.'];
    } else if($data_user['level'] !== 'Admin') {
        $_SESSION['result'] = ['type' => false,'message' => 'You do not have permission to access this feature.'];
    } else if($sess_username == 'demo') {
        $_SESSION['result'] = ['type' => false,'message' => 'Demo accounts do not have permission to access this feature.'];
    } else if(!$post_name || !$post_number || !is_numeric($post_minimal) || !$post_note) {
        $_SESSION['result'] = ['type' => false,'message' => 'There are still empty columns.'];
    } else if($call->query("SELECT code FROM deposit_method WHERE code = '$post_code'")->num_rows == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'Deposit method not found.'];
    } else {
        $up = $call->query("UPDATE deposit_method SET data = '$post_account', min = '$post_minimal', fee = '$post_fee', keterangan = '$post_note' WHERE code = '$post_code'");
        if($up == TRUE) {
            $_SESSION['result'] = ['type' => true,'message' => 'Deposit method successfully changed.'];
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
                              <h4 class="card-title"><i class="fas fa-credit-card text-primary mr-2"></i> Deposit Method</h4>
                           </div>
                        </div>
                        <div class="iq-card-body">
                            <? if($force_result == false) require _DIR_('library/session/result'); ?>
                            <div class="table-responsive">
                                <table id="datatable-responsive" class="table table-striped table-bordered nowrap">
                                    <thead>
                                        <tr>
                                            <th>Type</th>
                                            <th>Method</th>
                                            <th>Name</th>
                                            <th>Number</th>
                                            <th>Min.</th> 
                                            <th>Fee</th>
                                            <th>Keterangan</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
            <?php
            $search = $call->query("SELECT * FROM deposit_method ORDER BY name ASC");
            while($row = $search->fetch_assoc()) {
            ?>
                                        <tr>
                                            <td><span class="badge badge-primary"><?= strtoupper($row['type']) ?></span></td>
                                            <td><span class="badge badge-success"><?= $row['name'] ?></span></td>
                                            <td><span class="badge badge-warning"><?= (!$row['data']) ? '' : explode(' A/n ',$row['data'])[1] ?></span></td>
                                            <td><span class="badge badge-info"><?= (!$row['data']) ? '' : explode(' A/n ',$row['data'])[0] ?></span></td>
                                            <td><span class="badge badge-danger"><?= 'Rp '.currency($row['min']) ?></span></td> 
                                            <td><span class="badge badge-success"><?= 'Rp '.currency($row['fee']) ?></span></td>
                                            <td><span class="badge badge-info"><?= $row['keterangan'] ?></span></td>
                                            <td align="center">
                                                <a href="javascript:;" onclick="modal('Edit Method','<?= base_url('admin/deposit/detail?q='.base64_encode($row['code'])) ?>','','md')" class="btn btn-sm btn-warning text-white">
                                                    <i class="fas fa-pencil-alt" title="Edit Method"></i>
                                                </a>
                                                <a href="<?= base_url('admin/deposit/method?reset='.base64_encode($row['code'])) ?>" class="btn btn-sm btn-danger text-white">
                                                    <i class="fas fa-trash" title="Reset Method"></i>
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