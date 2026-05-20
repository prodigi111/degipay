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
    $post_status = filter($_POST['status']);
    
    $search = $call->query("SELECT * FROM verifikasi_user WHERE id = '$post_wid'")->fetch_assoc();
    
    if($result_csrf == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'System error, please try again later.'];
    } else if($data_user['level'] !== 'Admin') {
        $_SESSION['result'] = ['type' => false,'message' => 'You do not have permission to access this feature.'];
    } else if($sess_username == 'demo') {
        $_SESSION['result'] = ['type' => false,'message' => 'Demo accounts do not have permission to access this feature.'];
    } else if($call->query("SELECT * FROM verifikasi_user WHERE id = '$post_wid'")->num_rows == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'Daftar verifikasi '.$post_wid.' tidak ditemukan.'];
    } else if(!in_array($post_status,['process', 'verified', 'not verified'])) {
        $_SESSION['result'] = ['type' => false,'message' => 'The status you entered is not allowed.'];
    } else {
        $up = $call->query("UPDATE verifikasi_user SET status = '$post_status' WHERE id = '$post_wid'");
        if($up == true) {
            if($post_status == 'verified') {
                $reff = $call->query("SELECT * FROM users WHERE username = '$sess_username'")->fetch_assoc()['uplink'];
                $komisi = conf('referral', 2);
                $note = "@{$sess_username} - Level Premium";
            if($call->query("SELECT * FROM users WHERE username = '$reff' AND level IN ('Premium', 'Admin')")->num_rows == 1) {
                $call->query("UPDATE users SET komisi = komisi+$komisi WHERE username = '$reff'");
                $call->query("INSERT INTO mutation VALUES ('', '$reff', '+', '$komisi', '$note', '$date', '$time', 'Komisi Upgrade')");
            }
                $call->query("UPDATE users SET name = '".$search['nama']."', level = 'Premium' WHERE username = '".$search['user']."'");
                $WATL->sendMessage($search['nowhatsapp'], "Hallo, *{$search['nama']}*\n Verifikasi data diri telah berhasil \n----------------------------------------------\n*Terima kasih sudah memilih {$_CONFIG['title']}*");
            } else if($post_status == 'not verified') {
                $WATL->sendMessage($search['nowhatsapp'], "Hallo, *{$search['nama']}*\n Verifikasi data diri ditolak \n----------------------------------------------\n*Terima kasih sudah memilih {$_CONFIG['title']}*");
            }
            
            $_SESSION['result'] = ['type' => true,'message' => 'Daftar verifikasi '.$post_wid.' was successfully updated.'];
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
                              <h4 class="card-title"><i class="fas fa-shopping-cart mr-2"></i> Verify Upgrade </h4>
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
                                            <option value="process">Process</option>
                                            <option value="verified">Verified</option>
                                            <option value="not verified">Not Verified</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-3">
                                        <label>Nomor Identitas</label>
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
                                            <th>Tanggal</th>
                                            <th>Nama</th>
                                            <th>Nomor Identitas</th>
                                            <th>Kelamin</th>
                                            <th>Provinsi</th>
                                            <th>Kota</th>
                                            <th>Kecamatan</th>
                                            <th>Alamat</th>
                                            <th>Kode Pos</th>
                                            <th>Nomor Whatsapp</th>
                                            <th>Foto Identitas</th>
                                            <th>Foto Selfie</th>
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
    $search = "SELECT * FROM verifikasi_user WHERE status LIKE '%$pt_search%' AND noiden LIKE '%$pt_search2%' ORDER BY id DESC";
} else {
    $search = "SELECT * FROM verifikasi_user ORDER BY id DESC";
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
                                                <input type="hidden" id="web_token" name="web_token" value="<?= $row_query['id'] ?>">
                                                <td><span class="badge badge-primary"><?= $row_query['id'] ?></span></td>
                                                <td align="center" style="min-width:120px;"><?= str_replace(' (','<br>(',format_date('en',$row_query['tanggal'])) ?></td>
                                                <td><span class="badge badge-warning"><?= $row_query['nama'] ?></span></td>
                                                <td><?= $row_query['noiden'] ?></td>
                                                <td><?= $row_query['kelamin'] ?></td>
                                                <td><?= $row_query['provinsi'] ?></td>
                                                <td><?= $row_query['kota'] ?></td>
                                                <td><?= $row_query['kecamatan'] ?></td>
                                                <td style="min-width:250px;">
                                                    <textarea class="form-control"><?= $row_query['alamat'] ?></textarea>
                                                </td>
                                                <td><?= $row_query['kodepost'] ?></td>
                                                <td><?= $row_query['nowhatsapp'] ?></td>
                                                <td><a href="<?= base_url('library/assets/images/verifikasi_user/'.$row_query['foto_identitas']) ?>" target="_blank"><img src="<?= assets('images/verifikasi_user/'.$row_query['foto_identitas']).'?'.time() ?>" alt="<?= $row_query['foto_identitas'] ?>" width="65px" height="65px"></a></td>
                                                <td><a href="<?= base_url('library/assets/images/verifikasi_user/'.$row_query['foto_selfie']) ?>" target="_blank"><img src="<?= assets('images/verifikasi_user/'.$row_query['foto_selfie']).'?'.time() ?>" alt="<?= $row_query['foto_selfie'] ?>" width="65px" height="65px"></a></td>
                                                <td>
                                                    <select class="form-control form-control-sm" style="width:150px;" name="status">
                                                        <?= select_opt($row_query['status'],'process','process') ?>
                                                        <?= select_opt($row_query['status'],'verified','verified') ?>
                                                        <?= select_opt($row_query['status'],'not verified','not verified') ?>
                                                    </select>
                                                </td>
                                                <td align="center" style="min-width:120px;">
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