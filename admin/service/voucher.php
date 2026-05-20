<?php 
require '../../connect.php';
require _DIR_('library/session/admin');

if(isset($_POST['add'])) {
    $post_code = filter($_POST['code']);
    $post_idLayanan = filter($_POST['idLayanan']);
    $post_status = filter($_POST['status']);
    
    if($result_csrf == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'System error, please try again later.'];
    } else if($data_user['level'] !== 'Admin') {
        $_SESSION['result'] = ['type' => false,'message' => 'You do not have permission to access this feature.'];
    } else if($sess_username == 'demo') {
        $_SESSION['result'] = ['type' => false,'message' => 'Demo accounts do not have permission to access this feature.'];
    } else if(!$post_code || !$post_idLayanan || !$post_status) {
        $_SESSION['result'] = ['type' => false,'message' => 'There are still empty columns.'];
    } else if($call->query("SELECT kode FROM kodeVoucher WHERE kode = '$post_code'")->num_rows == true) {
        $_SESSION['result'] = ['type' => false,'message' => 'Kode Voucher already exists.'];
    } else {
        $up = $call->query("INSERT INTO kodeVoucher VALUES ('','GARENA','$post_idLayanan','$post_code','$post_status','-')");
        if($up == TRUE) {
            $_SESSION['result'] = ['type' => true,'message' => 'Kode Voucher added successfully.'];
            unset($_SESSION['csrf']);
        } else {
            $_SESSION['result'] = ['type' => false,'message' => 'Our server is in trouble, please try again later.'];
        }
    }
} if(isset($_POST['edit'])) {
    $post_token = filter(base64_decode($_POST['web_token']));
    $post_code = filter($_POST['code']);
    $post_status = filter($_POST['status']);
    
    if($result_csrf == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'System error, please try again later.'];
    } else if($data_user['level'] !== 'Admin') {
        $_SESSION['result'] = ['type' => false,'message' => 'You do not have permission to access this feature.'];
    } else if($sess_username == 'demo') {
        $_SESSION['result'] = ['type' => false,'message' => 'Demo accounts do not have permission to access this feature.'];
    } else if(!$post_code || !$post_status) {
        $_SESSION['result'] = ['type' => false,'message' => 'There are still empty columns.'];
    } else if($call->query("SELECT id FROM kodeVoucher WHERE id = '$post_token'")->num_rows == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'Kode Voucher not found.'];
    } else {
        $up = $call->query("UPDATE kodeVoucher SET kode = '$post_code', status = '$post_status' WHERE id = '$post_token'");
        if($up == TRUE) {
            $_SESSION['result'] = ['type' => true,'message' => 'Kode Voucher updated successfully.'];
            unset($_SESSION['csrf']);
        } else {
            $_SESSION['result'] = ['type' => false,'message' => 'Our server is in trouble, please try again later.'];
        }
    }
} if(isset($_POST['delete'])) {
    $post_token = filter(base64_decode($_POST['web_token']));
    if($result_csrf == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'System error, please try again later.'];
    } else if($data_user['level'] !== 'Admin') {
        $_SESSION['result'] = ['type' => false,'message' => 'You do not have permission to access this feature.'];
    } else if($sess_username == 'demo') {
        $_SESSION['result'] = ['type' => false,'message' => 'Demo accounts do not have permission to access this feature.'];
    } else if($call->query("SELECT id FROM kodeVoucher WHERE id = '$post_token'")->num_rows == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'Kode Voucher not found.'];
    } else {
        $up = $call->query("DELETE FROM kodeVoucher WHERE id = '$post_token'");
        if($up == TRUE) {
            $_SESSION['result'] = ['type' => true,'message' => 'Kode Voucher deleted successfully.'];
            unset($_SESSION['csrf']);
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
                              <h4 class="card-title" title="Click to Add" onclick="modal('New Data','<?= base_url('admin/service/add-voucher') ?>','','lg')"><i class="fas fa-plus-circle mr-2"></i> Kode Voucher </h4>
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
                                        <label>Keyword</label>
                                        <input type="text" class="form-control" name="search">
                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label>Submit</label>
                                        <button type="submit" class="btn btn-block btn-primary">Filter</button>
                                    </div>
                                </div>
                           </form>
                           <div class="table-responsive">
                              <table id="datatable" class="table table-striped table-bordered" >
                                 <thead>
                                    <tr>
                                        <th>Kategori</th>
                                        <th>Layanan</th>
                                        <th>Kode</th>
                                        <th>Status</th>
                                        <th>Digunakan</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
<?php 
$no = 1;
if(isset($_GET['show'])) {
    $pt_show = filter_entities($_GET['show']);
    $pt_search = filter($_GET['search']);
    $search = "SELECT * FROM kodeVoucher WHERE kategori LIKE '%$pt_search%' OR code LIKE '%$pt_search%' OR idLayanan LIKE '%$pt_search%' ORDER BY id DESC";
} else {
    $search = "SELECT * FROM kodeVoucher ORDER BY id DESC";
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
                                            <input type="hidden" id="web_token" name="web_token" value="<?= base64_encode($row_query['id']) ?>">
                                            <td><input type="text" class="form-control" value="<?= $row_query['kategori'] ?>" readonly></td>
                                            <td><input type="text" class="form-control" name="idLayanan" value="<?= $call->query("SELECT code, name FROM srv WHERE code = '".$row_query['idLayanan']."'")->fetch_assoc()['name'] ?>" readonly></td>
                                            <td><input type="text" class="form-control" name="code" value="<?= $row_query['kode'] ?>"></td>
                                            <td>
                                                <select class="form-control" name="status">
                                                    <?= select_opt($row_query['status'],'Tersedia','Tersedia') ?>
                                                    <?= select_opt($row_query['status'],'Tidak Tersedia','Tidak Tersedia') ?>
                                                </select>
                                            </td>
                                            <td><input type="text" class="form-control" value="<?= $row_query['used'] ?>" readonly></td>
                                            <td align="center">
                                                <button title="Edit kodeVoucher" type="submit" name="edit" class="btn btn-info">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </button>
                                                <button title="Delete kodeVoucher" type="submit" name="delete" class="btn btn-danger">
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