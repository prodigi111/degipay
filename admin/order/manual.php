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
    $post_wid = filter($_POST['web_token']);
    $post_note = filter($_POST['note']);
    $post_status = filter($_POST['status']);
    
    if($post_status == 'error' && (!$post_note || $post_note == 'Transaksi Sedang Diproses')) {
        $post_note == 'Transaksi Gagal';
    }
    
    $search = $call->query("SELECT * FROM trx WHERE wid = '$post_wid'");
    if($search->num_rows == true) $row = $search->fetch_assoc();
    $rowUser = $call->query("SELECT * FROM users WHERE username = '".$row['user']."'")->fetch_assoc();
    
    $server = $row['provider'];
    $price = $row['price'];
    $profit = $row['profit'];
    $point = conf('referral', 3);
    $komisi = conf('referral', 1);
    $notes = "ID Trx #{$post_wid}";
    $cust = $row['user'];
    $reff = $call->query("SELECT * FROM users WHERE username = '$cust'")->fetch_assoc()['uplink'];
    
    if($result_csrf == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'System error, please try again later.'];
    } else if($data_user['level'] !== 'Admin') {
        $_SESSION['result'] = ['type' => false,'message' => 'You do not have permission to access this feature.'];
    } else if($sess_username == 'demo') {
        $_SESSION['result'] = ['type' => false,'message' => 'Demo accounts do not have permission to access this feature.'];
    } else if($search->num_rows == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'Transaction with id '.$post_wid.' not found.'];
    } else if(!in_array($post_status,['error','success'])) {
        $_SESSION['result'] = ['type' => false,'message' => 'The status you entered is not allowed.'];
    } else {
        $up = $call->query("UPDATE trx SET status = '$post_status', note = '$post_note' WHERE wid = '$post_wid'");
        if($up == true) {
            if($post_status == 'success'){
                $WATL->sendMessage($rowUser['phone'], "Hallo, *{$rowUser['name']}*\nID Pesanan *#{$post_wid}* \nPesanan : *{$row['name']}* \nStatus : *".ucwords($post_status)."* \nCatatan: *{$post_note}* \n----------------------------------------------\n*Terima kasih sudah memilih {$_CONFIG['title']}*");
            }
            if($post_status == 'success' && $row['spoint'] == '1') {
                
                $fcm_token = $call->query("SELECT * FROM users_token WHERE user = '".$rowUser['username']."'")->fetch_assoc()['token'];
                
                $notification = [
                    'title' => 'Pesanan '.$row['name'],
                    'body' => 'Status '.ucwords($post_status).' | Keterangan '.$post_note,
                    'click_action' =>  'Open_URI',
                ];
                
                $data = [
                    'picture' => '',
                    'uri' =>  base_url('order/detail/'.$post_wid),
                ];
                $FCM->sendNotif($fcm_token, $notification, $data);
            }
            
            if($post_status == 'success' && $row['spoint'] == '0') {
                
                $call->query("UPDATE users SET point = point+$point WHERE username = '$cust'");
                $call->query("INSERT INTO mutation VALUES ('', '$cust', '+', '$point', '$notes', '$date', '$time', 'Point Transaksi')");
                $call->query("UPDATE trx SET profit = profit-$point, spoint = '1', rpoint = '$point' WHERE wid = '$post_wid'");
                
                if($call->query("SELECT * FROM users WHERE username = '$reff' AND level IN ('Premium', 'Admin')")->num_rows == 1) {
                    $call->query("UPDATE users SET komisi = komisi+$komisi WHERE username = '$reff'");
                    $call->query("INSERT INTO mutation VALUES ('', '$reff', '+', '$komisi', '$notes', '$date', '$time', 'Komisi Transaksi')");
                }
            }
            
            $_SESSION['result'] = ['type' => true,'message' => 'Transaction with id '.$post_wid.' was successfully updated.'];
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
                              <h4 class="card-title"><i class="fas fa-shopping-cart mr-2"></i> Transaction </h4>
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
                                            <option value="processing">Processing</option>
                                            <option value="success">Success</option>
                                            <option value="error">Error</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-3">
                                        <label>Trx ID</label>
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
                                            <th>Service</th>
                                            <th>Data</th>
                                            <th>Note</th>
                                            <th>Price</th>
                                            <th>Status</th>
                                            <th>Provider</th>
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
    $search = "SELECT * FROM trx WHERE trxtype IN ('manual') AND status LIKE '%$pt_search%' AND wid LIKE '%$pt_search2%' ORDER BY id DESC";
} else {
    $search = "SELECT * FROM trx WHERE trxtype IN ('manual') ORDER BY id DESC";
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
    $tab_icon = '<i class="fas fa-globe-asia mr-2"></i>';
    if(explode(',',$row_query['trxfrom'])[0] == 'API')  $tab_icon = '<i class="fas fa-rss mr-2"></i>';
    if(explode(',',$row_query['trxfrom'])[0] == 'LINE')  $tab_icon = '<i class="fab fa-line mr-2"></i>';
    if(explode(',',$row_query['trxfrom'])[0] == 'WHATSAPP')  $tab_icon = '<i class="fab fa-whatsapp mr-2"></i>';
    if(explode(',',$row_query['trxfrom'])[0] == 'TELEGRAM')  $tab_icon = '<i class="fab fa-telegram-plane mr-2"></i>';
?>
                                        <tr>
                                            <form method="POST" class="form-inline" role="form">
                                                <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
                                                <input type="hidden" id="web_token" name="web_token" value="<?= $row_query['wid'] ?>">
                                                <td><span class="badge badge-primary"><?= $tab_icon.$row_query['wid'].' - '.$row_query['tid'] ?></span></td>
                                                <td align="center" style="min-width:120px;"><?= str_replace(' (','<br>(',format_date('en',$row_query['date_cr'])) ?></td>
                                                <td><span class="badge badge-warning"><?= $call->query("SELECT name FROM users WHERE username = '".$row_query['user']."'")->fetch_assoc()['name'] ?></span></td>
                                                <td><?= $row_query['name'] ?></td>
                                                <td style="min-width:160px;">
                                                    <input type="text" class="form-control form-control-sm" value="<?= $row_query['data'] ?>" id="target-<?= $row_query['wid'] ?>" disabled>
                                                </td>
                                                <td style="min-width:250px;">
                                                    <textarea class="form-control" name="note"><?= $row_query['note'] ?></textarea>
                                                </td>
                                                <td><span class="badge badge-danger"><?= 'Rp '.currency($row_query['price']) ?></span></td>
                                                <td>
                                                    <select class="form-control form-control-sm" style="width:150px;" name="status">
                                                        <?= select_opt($row_query['status'],'processing','Processing') ?>
                                                        <?= select_opt($row_query['status'],'success','Success') ?>
                                                        <?= select_opt($row_query['status'],'error','Error') ?>
                                                    </select>
                                                </td>
                                                <td><span class="badge badge-dark"><?= $row_query['provider'] ?></span></td>
                                                <td align="center" style="min-width:120px;">
                                                    <button title="Detail Data" type="button" onclick="modal('Order Details','<?= base_url('order/detail/'.$row_query['wid']) ?>','','md')" class="btn btn-sm btn-info">
                                                        <i class="fas fa-receipt"></i>
                                                    </button>
                                                    <button title="Edit Data" type="submit" name="edit" class="btn btn-sm btn-primary">
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