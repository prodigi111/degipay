<?php 
require '../../connect.php';
require _DIR_('library/session/admin');

if(isset($_POST['submit'])) {
    $post_1 = filter($_POST['username']);
    $post_2 = filter($_POST['password']);
    $post_3 = filter($_POST['provider-bank']);
    $post_4 = filter($_POST['no_rek']);

    if($result_csrf == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'System error, please try again later.'];
    } else if($data_user['level'] !== 'Admin') {
        $_SESSION['result'] = ['type' => false,'message' => 'You do not have permission to access this feature.'];
    } else if($sess_username == 'demo') {
        $_SESSION['result'] = ['type' => false,'message' => 'Demo accounts do not have permission to access this feature.'];
    } else if($post_3 != "bni" AND $post_3 != "bca") {
        $_SESSION['result'] = ['type' => false,'message' => 'Please Input the provider correctly.'];
    } else {
        /*
        if ($get_bca['status'] = true) {
		    $saldo = $get_bca['saldo_akhir'];
		*/
        $up = $call->query("INSERT INTO conf VALUES ('account-bank', '1:Username || 2:Password || 3:Provider-Bank || 4:Nomor-Rekening', '$post_1', '$post_2', '$post_3', '0', '$post_4', '-', '-', '-')");
        if($up == TRUE) {
            $_SESSION['result'] = ['type' => true,'message' => 'Successfully set Account Bank Config.'];
        } else {
            $_SESSION['result'] = ['type' => false,'message' => 'Our server is in trouble, please try again later.'];
        }
    }
} else if(isset($_POST['delete'])) {
    $post_username = filter(base64_decode($_POST['username']));
    if($result_csrf == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'System error, please try again later.'];
    } else if($data_user['level'] !== 'Admin') {
        $_SESSION['result'] = ['type' => false,'message' => 'You do not have permission to access this feature.'];
    } else if($sess_username == 'demo') {
        $_SESSION['result'] = ['type' => false,'message' => 'Demo accounts do not have permission to access this feature.'];
    } else if($call->query("SELECT * FROM conf WHERE c1 = '$post_username' AND code = 'account-bank'")->num_rows == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'Username account bank not found.'];
    } else {
        $up = $call->query("DELETE FROM conf WHERE c1 = '$post_username' AND code IN ('account-bank','account-ovo')");
        if($up == TRUE) {
            $_SESSION['result'] = ['type' => true,'message' => 'Account bank deleted successfully.'];
            unset($_SESSION['csrf']);
        } else {
            $_SESSION['result'] = ['type' => false,'message' => 'Our server is in trouble, please try again later.'];
        }
    }
}

if(isset($_POST['send'])) {
    $post_phone = filter($_POST['phone']);
    $device = rand(111,999).'ff'.rand(111,999).'-b7fc-3b'.rand(11,99).'-b'.rand(11,99).'d-'.rand(1111,9999).'d2fea8e5';
    $OVO = new OVO($post_phone,$device);
    $login = $OVO->sendRequest2FA();
    if($result_csrf == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'System error, please try again later.'];
    } else if($data_user['level'] !== 'Admin') {
        $_SESSION['result'] = ['type' => false,'message' => 'You do not have permission to access this feature.'];
    } else if($sess_username == 'demo') {
        $_SESSION['result'] = ['type' => false,'message' => 'Demo accounts do not have permission to access this feature.'];
    } else if($login['result'] == false) {
        $_SESSION['result'] = ['type' => false,'message' => $login['message']];
    } else {
        $up = $call->query("UPDATE conf SET c1 = '$post_phone', c2 = '$device' WHERE code = 'account-ovo'");
        if($up == TRUE) {
            $_SESSION['result'] = ['type' => true,'message' => $login['message']];
            unset($_SESSION['csrf']);
        } else {
            $_SESSION['result'] = ['type' => false,'message' => 'Our server is in trouble, please try again later.'];
        }
    }
} else if(isset($_POST['confirm'])) {
    $post_otp = filter($_POST['otp']);
    $data_ovo = $call->query("SELECT * FROM conf WHERE code = 'account-ovo'")->fetch_assoc();
    $OVO = new OVO($data_ovo['c1'],$data_ovo['c2']);
    $otp = $OVO->konfirmasiCode($post_otp);
    if($result_csrf == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'System error, please try again later.'];
    } else if($data_user['level'] !== 'Admin') {
        $_SESSION['result'] = ['type' => false,'message' => 'You do not have permission to access this feature.'];
    } else if($sess_username == 'demo') {
        $_SESSION['result'] = ['type' => false,'message' => 'Demo accounts do not have permission to access this feature.'];
    } else if($otp['result'] == false) {
        $_SESSION['result'] = ['type' => false,'message' => $otp['message']];
    } else {
        $up = $call->query("UPDATE conf SET c3 = '$post_otp' WHERE code = 'account-ovo'");
        if($up == TRUE) {
            $_SESSION['result'] = ['type' => true,'message' => $otp['message']];
            unset($_SESSION['csrf']);
        } else {
            $_SESSION['result'] = ['type' => false,'message' => 'Our server is in trouble, please try again later.'];
        }
    }
} else if(isset($_POST['auth'])) {
    $post_pin = filter($_POST['pin']);
    $data_ovo = $call->query("SELECT * FROM conf WHERE code = 'account-ovo'")->fetch_assoc();
    $OVO = new OVO($data_ovo['c1'],$data_ovo['c2']);
    $auth = $OVO->konfirmasiSecurityCode($post_pin);
    if($result_csrf == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'System error, please try again later.'];
    } else if($data_user['level'] !== 'Admin') {
        $_SESSION['result'] = ['type' => false,'message' => 'You do not have permission to access this feature.'];
    } else if($sess_username == 'demo') {
        $_SESSION['result'] = ['type' => false,'message' => 'Demo accounts do not have permission to access this feature.'];
    } else if($auth['result'] == false) {
        $_SESSION['result'] = ['type' => false,'message' => $auth['message']];
    } else {
        if ($auth['result'] == true) {
            $token = $auth['data'];
        }
        $up = $call->query("UPDATE conf SET c4 = '$post_pin', c5 = '$token' WHERE code = 'account-ovo'");
        if($up == TRUE) {
            $_SESSION['result'] = ['type' => true,'message' => $auth['message']];
            unset($_SESSION['csrf']);
        } else {
            $_SESSION['result'] = ['type' => false,'message' => 'Our server is in trouble, please try again later.'];
        }
    }
} else if(isset($_POST['reset'])) {
    $data_ovo = $call->query("SELECT * FROM conf WHERE code = 'account-ovo'")->fetch_assoc();
    $OVO = new OVO($data_ovo['c1'],$data_ovo['c2']);
    $auth = $OVO->Logout($data_ovo['c5']);
    if($result_csrf == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'System error, please try again later.'];
    } else if($data_user['level'] !== 'Admin') {
        $_SESSION['result'] = ['type' => false,'message' => 'You do not have permission to access this feature.'];
    } else if($sess_username == 'demo') {
        $_SESSION['result'] = ['type' => false,'message' => 'Demo accounts do not have permission to access this feature.'];
    } else {
        $up = $call->query("UPDATE conf SET c5 = '' WHERE code = 'account-ovo'");
        if($up == TRUE) {
            $_SESSION['result'] = ['type' => true,'message' => $auth['message']];
            unset($_SESSION['csrf']);
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
                              <h4 class="card-title"><i class="fas fa-cogs text-primary mr-2"></i> Account Bank</h4>
                           </div>
                        </div>
                        <form method="POST">
                            <div class="iq-card-body">
                                <div id="sess-result-modal"></div>
                                <? require _DIR_('library/session/result'); ?>
                                <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
                                <div class="row">
                                    <div class="form-group col-md-4 col-12">
                                        <label>Username</label>
                                        <input type="text" class="form-control" name="username">
                                    </div>
                                    <div class="form-group col-md-8 col-12">
                                        <label>Password</label>
                                        <input type="text" class="form-control" name="password">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Provider Bank</label>
                                    <select class="form-control" name="provider-bank">
                                       <option value="bni">BNI </option>
                                       <!-- <option value="bca">BCA </option> -->
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label>Nomor Rekening</label>
                                    <input type="text" class="form-control" name="no_rek">
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
                  <div class="col-lg-8 offset-lg-2">
                     <div class="iq-card">
                        <div class="iq-card-header d-flex justify-content-between">
                           <div class="iq-header-title">
                              <h4 class="card-title"><i class="fas fa-cogs text-primary mr-2"></i> Account OVO</h4>
                           </div>
                        </div>
                        <form method="POST">
                            <div class="iq-card-body">
                                <div id="sess-result-modal"></div>
                                <? require _DIR_('library/session/result'); ?>
                                <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
                                <div class="row">
                                <div class="form-group col-md-8 col-12">
									<input type="number" class="form-control" placeholder="Phone Number" name="phone" minlength="6" maxlength="15">
								</div>
                                <div class="col-4">
                                    <button type="submit" style="padding: 11px 10px" class="btn btn-block btn-outline-primary" name="send">
                                        <span class="d-none d-sm-inline">Send OTP</span>
                                        <i class="fas fa-mobile-alt"></i>
                                    </button>
                                </div>
                                </div>
                                <div class="row">
                                <div class="form-group col-md-8 col-12">
									<input type="number" class="form-control" placeholder="OTP Code" name="otp" minlength="4" maxlength="4">
								</div>
                                <div class="col-4">
                                    <button type="submit" style="padding: 11px 10px" class="btn btn-block btn-outline-primary" name="confirm">
                                        <span class="d-none d-sm-inline">Confirm OTP</span>
                                        <i class="fas fa-code"></i>
                                    </button>
                                </div>
                                </div>
                                <div class="row">
                                <div class="form-group col-md-8 col-12">
									<input type="number" class="form-control" placeholder="Security PIN" name="pin" minlength="6" maxlength="6">
								</div>
                                <div class="col-4">
                                    <button type="submit" style="padding: 11px 10px" class="btn btn-block btn-outline-primary" name="auth">
                                        <span class="d-none d-sm-inline">Auth</span>
                                        <i class="fas fa-sign-in-alt"></i>
                                    </button>
                                </div>
                                </div>
                            </div>
                            <ul class="list-group list-group-flush">
                               <li class="list-group-item"></li>
                            </ul>
                            <div class="iq-card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <button type="submit" name="reset" class="btn btn-block btn-danger">Reset Authentication</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                     </div>
                  </div>
                <div class="col-lg-12">
                     <div class="iq-card">
                        <div class="iq-card-header d-flex justify-content-between">
                           <div class="iq-header-title">
                              <h4 class="card-title"><i class="fas fa-credit-card mr-2"></i> List of Account Bank </h4>
                           </div>
                        </div>
                        <div class="iq-card-body">
                            <? require _DIR_('library/session/result'); ?>
                           <form class="form-horizontal" method="GET">
                                <div class="row">
                                    <div class="form-group col-lg-4">
                                        <label>Show</label>
                                        <select class="form-control" name="show">
                                            <option value="10">Default</option>
                                            <option value="50">50</option>
                                            <option value="100">100</option>
                                            <option value="250">250</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label>Search</label>
                                        <input type="number" class="form-control" name="search">
                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label>Submit</label>
                                        <button type="submit" class="btn btn-block btn-primary">Filter</button>
                                    </div>
                                </div>
                            </form>
                            <div class="table-responsive">
                                <table id="datatable-responsive" class="table table-striped table-bordered nowrap">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Username / NomorHP</th>
                                            <th>Password / Device</th>
                                            <th>Balance</th>
                                            <th>Provider Bank / PIN</th>
                                            <th>No. Rekening / Token</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php 
$no = 1;
if(isset($_GET['show'])) {
    $pt_show = filter_entities($_GET['show']);
    $pt_search = filter($_GET['search']);
    $search = "SELECT * FROM conf WHERE c1 LIKE '%$pt_search%' AND code IN ('account-bank','account-ovo') ORDER BY code DESC";
} else {
    $search = "SELECT * FROM conf WHERE code IN ('account-bank','account-ovo') ORDER BY code DESC";
}

if(isset($_GET['show'])) {
    $pt_show = filter_entities($_GET['show']);
    $records_per_page = $pt_show;
} else {
    $records_per_page = 10;
}
$starting_position = (isset($_GET['page'])) ? ((filter_entities($_GET['page'])-1) * $records_per_page) : 0;

$new_query = $call->query("$search LIMIT $starting_position, $records_per_page");
$no = $starting_position+1;

while ($row_query = $new_query->fetch_assoc()) {
?>
                                        <tr>
                                            <form method="POST" class="form-inline" role="form">
                                            <input type="hidden" id="username" name="username" value="<?= base64_encode($row_query['c1']) ?>">
                                            <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
                                            <td><span class="badge badge-dark"><?= $no ?></span></td>
                                            <td><span class="badge badge-primary"><?= $row_query['c1'] ?></span></td>
                                            <td><span class="badge badge-danger"><?= $row_query['c2'] ?></span></td>
                                            <td><span class="badge badge-warning"><?= $row_query['c6'] ?></span></td>
                                            <td><span class="badge badge-success"><?= $row_query['c3'] ?></span></td>
                                            <td><span class="badge badge-dark"><?= $row_query['c5'] ?></td>
                                            <td align="center">
                                                <a href="javascript:;" onclick="modal('Edit Service','<?= base_url('admin/payment/account/edit?q='.base64_encode($row_query['id'])) ?>','','md')" class="btn btn-sm btn-warning text-white">
                                                    <i class="fas fa-pencil-alt" title="Edit Service"></i>
                                                </a>
                                                <button title="Delete Account" type="submit" name="delete" class="btn btn-sm btn-danger text-white">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </td>
                                            </form>
                                        </tr>
<? } ?>
                                </tbody>
                              </table>
                           </div>
                           <nav aria-label="Page navigation example">
                              <ul class="pagination mb-0">
<?php
$pt_show = (isset($_GET['show'])) ? filter_entities($_GET['show']) : 10;
if(isset($_GET['show'])) {
    $pt_search = filter($_GET['search']);
    $pt_show = filter_entities($_GET['show']);
} else {
    $self = $_SERVER['PHP_SELF'];
}

$search = $call->query($search);
$total_records = $search->num_rows;
print '<li class="page-item disabled"><a class="page-link" href="#" tabindex="-1" aria-disabled="true">Data : '.$total_records.'</a></li>';
if($total_records > 0) {
    $total_pages = ceil($total_records/$records_per_page);
    $current_page = 1;
    
    if(isset($_GET['page'])) {
        $current_page = filter_entities($_GET['page']);
        if($current_page < 1) $current_page = 1;
    }
    
    if($current_page > 1) {
        $previous = $current_page-1;
        
        if(isset($_GET['show'])) {
            $pt_search = filter($_GET['search']);
            $pt_show = filter_entities($_GET['show']);
            
            print '<li class="page-item"><a class="page-link" href="'.$self.'?page=1&show='.$pt_show.'&search='.$pt_search.'" aria-label="Previous"><span aria-hidden="true"><i class="fa fa-angle-double-left"></i></span></a></li>';
        } else {
            print '<li class="page-item"><a class="page-link" href="'.$self.'?page=1" aria-label="Previous"><span aria-hidden="true"><i class="fa fa-angle-double-left"></i></span></a></li>';
        }
    }
    
    $limit_page = $current_page+1;
    $limit_show_link = $total_pages-$limit_page;
    if($limit_show_link < 0) {
        $limit_show_link2 = $limit_show_link*2;
        $limit_link = $limit_show_link - $limit_show_link2;
        $limit_link = 1 - $limit_link;
    } else {
        $limit_link = 1;
    }
    $limit_page = $current_page+$limit_link;
    
    if($current_page == 1) {
        $start_page = 1;
    } else if($current_page > 1) {
        if($current_page < 2) {
            $min_page  = $current_page-1;
        } else {
            $min_page  = 1;
        }
        $start_page = $current_page-$min_page;
    } else {
        $start_page = $current_page;
    }
    
    for($i = $start_page; $i <= $limit_page; $i++) {
        if(isset($_GET['show'])) {
            $pt_search = filter($_GET['search']);
            $pt_show = filter_entities($_GET['show']);
            if($i == $current_page)  print '<li class="page-item"><a class="page-link" href="#">'.$i.'</a></li>';
            else print '<li class="page-item"><a class="page-link" href="'.$self.'?page='.$i.'&show='.$pt_show.'&search='.$pt_search.'">'.$i.'</a></li>';
        } else {
            if($i == $current_page) print '<li class="page-item active"><a class="page-link" href="#">'.$i.'</a></li>';
            else print '<li class="page-item"><a class="page-link" href="'.$self.'?page='.$i.'">'.$i.'</a></li>';
        }
    }
    
    if($current_page != $total_pages) {
        $next = $current_page+1;
        if(isset($_GET['show'])) {
            $pt_search = filter($_GET['search']);
            $pt_show = filter_entities($_GET['show']);
            
            print '<li class="page-item"><a class="page-link" href="'.$self.'?page='.$total_pages.'&show='.$pt_show.'&search='.$pt_search.'"><i class="fa fa-angle-double-right"></i></a></li>';
        } else {
            print '<li class="page-item"><a class="page-link" href="'.$self.'?page='.$total_pages.'"><i class="fa fa-angle-double-right"></i></a></li>';
        }
    }
}
?>                                    
                              </ul>
                           </nav>
                        </div>
                     </div>
                  </div>
<? require _DIR_('library/footer/admin'); ?>