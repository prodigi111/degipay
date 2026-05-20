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

if(isset($_POST['edit'])) {
    $post_rid = filter($_POST['web_token']);
    $post_status = filter($_POST['status']);
    
    $search = $call->query("SELECT * FROM deposit WHERE rid = '$post_rid'");
    if($search->num_rows == true) $row = $search->fetch_assoc();
    
    if($result_csrf == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'System error, please try again later.'];
    } else if($data_user['level'] !== 'Admin') {
        $_SESSION['result'] = ['type' => false,'message' => 'You do not have permission to access this feature.'];
    } else if($sess_username == 'demo') {
        $_SESSION['result'] = ['type' => false,'message' => 'Demo accounts do not have permission to access this feature.'];
    } else if($search->num_rows == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'Deposit request with id '.$post_rid.' not found.'];
    } else if(!in_array($post_status,['cancel','paid'])) {
        $_SESSION['result'] = ['type' => false,'message' => 'The status you entered is not allowed.'];
    } else if($row['status'] !== 'unpaid') {
        $_SESSION['result'] = ['type' => false,'message' => 'Deposit requests have been received or canceled.'];
    } else {
        $user = $row['user'];
        $amount = $row['amount'];
        $ip_addr = client_ip();
        $rowUser = $call->query("SELECT * FROM users WHERE username = '$user'")->fetch_assoc();
        
        if($post_status == 'paid') {
            $up = $call->query("UPDATE users SET balance = balance+$amount WHERE username = '$user'");
            if($up == true) {
                $call->query("UPDATE deposit SET status = 'paid', date_up = '$date $time' WHERE rid = '$post_rid' AND status = 'unpaid'");
                $call->query("INSERT INTO logs VALUES ('','$user','topup','$ip_addr','$date $time')");
                $call->query("INSERT INTO mutation VALUES ('','$user','+','$amount','Topup $amount','$date', '$time', 'Deposit')");
                
                $WATL->sendMessage($rowUser['phone'], 'Hallo '.$rowUser['name'].' Permintaan Isi Saldo Berhasil Diterima Dengan Menggunakan Metode Deposit '.strtoupper($row['method']).', Saldo Anda Telah Kami Tambahkan Sebesar '.currency($amount).'.');
                $fcm_token = $call->query("SELECT * FROM users_token WHERE user = '$user'")->fetch_assoc()['token'];
                $notification = [
                    'title' => 'Saldo Masuk Rp '.currency($amount),
                    'text' => 'Permintaan Isi Saldo Berhasil Diterima, Saldo Anda Telah Kami Tambahkan.',
                    'click_action' =>  'Open_URI',
                ];
                
                $data = [
                    'picture' => '',
                    'uri' =>  base_url('deposit/invoice/'.$post_rid),
                ];
                $FCM->sendNotif($fcm_token, $notification, $data);
            
                $_SESSION['result'] = ['type' => true,'message' => 'Deposit request for '.$rowUser['name'].' was successfully received.'];
            } else {
                $_SESSION['result'] = ['type' => false,'message' => 'Our server is in trouble, please try again later.'];
            }
        } else if($post_status == 'cancel') {
            if($call->query("UPDATE deposit SET status = 'cancel', date_up = '$date $time' WHERE rid = '$post_rid' AND status = 'unpaid'") == true) {
                
                $WATL->sendMessage($rowUser['phone'], 'Hallo '.$rowUser['name'].' Permintaan Isi Saldo Dengan Menggunakan Metode Deposit '.strtoupper($row['method']).' Dibatalkan.');
                $fcm_token = $call->query("SELECT * FROM users_token WHERE user = '$user'")->fetch_assoc()['token'];
                $notification = [
                    'title' => 'Deposit '.strtoupper($row['method']),
                    'text' => 'Permintaan Isi Saldo Dibatalkan',
                    'click_action' =>  'Open_URI',
                ];
                
                $data = [
                    'picture' => '',
                    'uri' =>  base_url('deposit/invoice/'.$post_rid),
                ];
                $FCM->sendNotif($fcm_token, $notification, $data);
                
                $_SESSION['result'] = ['type' => true,'message' => 'Deposit request for '.$rowUser['name'].' was successfully canceled.'];
            } else {
                $_SESSION['result'] = ['type' => false,'message' => 'Our server is in trouble, please try again later.'];
            }
        } else {
            $_SESSION['result'] = ['type' => false,'message' => 'System error.'];
        }
    }
}

require _DIR_('library/header/admin');
?>
                  <div class="col-lg-12">
                     <div class="iq-card">
                        <div class="iq-card-header d-flex justify-content-between">
                           <div class="iq-header-title">
                              <h4 class="card-title"><i class="fas fa-credit-card text-primary mr-2"></i>Deposit Request</h4>
                           </div>
                        </div>
                        <div class="iq-card-body">
                            <? require _DIR_('library/session/result'); ?>
                           <form class="form-horizontal" method="GET">
                                <div class="row">
                                    <div class="form-group col-lg-3">
                                        <label>Show</label>
                                        <select class="form-control" name="show">
                                            <option value="10">Default</option>
                                            <option value="50">50</option>
                                            <option value="100">100</option>
                                            <option value="250">250</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-3">
                                        <label>Status</label>
                                        <select class="form-control" name="search">
                                            <option value="">All</option>
                                            <option value="unpaid">Unpaid</option>
                                            <option value="paid">Paid</option>
                                            <option value="cancel">Cancelled</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-3">
                                        <label>Req ID</label>
                                        <input type="number" class="form-control" name="search2">
                                    </div>
                                    <div class="form-group col-lg-3">
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
                                            <th>Date</th>
                                            <th>User</th>
                                            <th>Method</th>
                                            <th>Sender</th>
                                            <th>Note</th>
                                            <th>Quantity</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php 
$no = 1;
if(isset($_GET['show'])) {
    $pt_show = filter_entities($_GET['show']);
    $pt_search = filter($_GET['search']);
    $pt_search2 = filter($_GET['search2']);
    $search = "SELECT * FROM deposit WHERE status LIKE '%$pt_search%' AND rid LIKE '%$pt_search2%' AND method != 'transfer' ORDER BY id DESC";
} else {
    $search = "SELECT * FROM deposit WHERE method != 'transfer' ORDER BY id DESC";
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
                                                <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
                                                <input type="hidden" id="web_token" name="web_token" value="<?= $row_query['rid'] ?>">
                                                <td><span class="badge badge-primary"><?= $row_query['rid'] ?></span></td>
                                                <td><?= format_date('en',$row_query['date_cr']) ?></td>
                                                <td><span class="badge badge-success"><?= $call->query("SELECT name FROM users WHERE username = '".$row_query['user']."'")->fetch_assoc()['name'] ?></span></td>
                                                <td>
                                                    <span class="badge badge-info">
                                                        <?= $call->query("SELECT * FROM deposit_method WHERE code = '".$row_query['method']."'")->fetch_assoc()['name'] ?>
                                                    </span>
                                                </td>
                                                <td><?= $row_query['sender'] ?></td>
                                                <td><?= $row_query['note'] ?></td>
                                                <td><span class="badge badge-dark"><?= 'Rp '.currency($row_query['quantity']) ?></span></td>
                                                <td><span class="badge badge-dark"><?= 'Rp '.currency($row_query['amount']) ?></span></td>
                                                <td>
                                                    <select class="form-control" style="width:150px;" name="status">
                                                        <? if(in_array($row_query['status'],['cancel','paid'])) { ?>
                                                        <option value="<?= $row_query['status'] ?>" selected disabled><?= ucfirst($row_query['status']) ?></option>
                                                        <? } else { ?>
                                                        <option value="unpaid" selected disabled>Unpaid</option>
                                                        <option value="paid">Paid</option>
                                                        <option value="cancel">Cancel</option>
                                                        <? } ?>
                                                    </select>
                                                </td>
                                                <td align="text-center">
                                                    <button title="Edit Data" type="submit" name="edit" class="btn btn-sm btn-<?= ($row_query['status'] == 'unpaid') ? 'primary' : 'danger' ?>"<?= ($row_query['status'] == 'unpaid') ? '' : ' disabled' ?>>
                                                        <i class="fas fa-pencil-alt"></i>
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