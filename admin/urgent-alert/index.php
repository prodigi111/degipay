<?php 
require '../../connect.php';
require _DIR_('library/session/admin');
if(isset($_POST['publish'])) {
    $info = filter($_POST['info']);
    $is_show = filter($_POST['is_show']);
    $order_id = filter($_POST['order_id']);

    if($result_csrf == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'System error, please try again later.'];
    } else if($data_user['level'] !== 'Admin') {
        $_SESSION['result'] = ['type' => false,'message' => 'You do not have permission to access this feature.'];
    } else if($sess_username == 'demo') {
        $_SESSION['result'] = ['type' => false,'message' => 'Demo accounts do not have permission to access this feature.'];
    } else if(!$info || !$order_id) {
        $_SESSION['result'] = ['type' => false,'message' => 'Ada From yang kosong.'];
    } else {
        $up = $call->query("INSERT INTO modules_urgent_alert (info, is_show, order_id) VALUES ('$info', '$is_show', '$order_id')");
        if($up == TRUE) {
            $_SESSION['result'] = ['type' => true,'message' => 'Notifikasi Published.'];
            unset($_SESSION['csrf']);
             exit(header("Location: ".$_SERVER['PHP_SELF']));
        } else {
            $_SESSION['result'] = ['type' => false,'message' => 'Our server is in trouble, please try again later.'];
        }
    }
} else if(isset($_POST['edit'])) {
    $id = filter($_POST['id']);
    $info = filter($_POST['info']);
    $is_show = filter($_POST['is_show']);
    $order_id = filter($_POST['order_id']);
    if($result_csrf == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'System error, please try again later.'];
    } else if($data_user['level'] !== 'Admin') {
        $_SESSION['result'] = ['type' => false,'message' => 'You do not have permission to access this feature.'];
    } else if($sess_username == 'demo') {
        $_SESSION['result'] = ['type' => false,'message' => 'Demo accounts do not have permission to access this feature.'];
    } else if(!$info || !$order_id) {
        $_SESSION['result'] = ['type' => false,'message' => 'Ada From yang kosong.'];
    } else if($call->query("SELECT * FROM modules_urgent_alert WHERE id = '$id'")->num_rows == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'Data Not Found.'];
    } else {
        $up = $call->query("UPDATE modules_urgent_alert SET info = '$info', is_show = '$is_show', order_id = '$order_id' WHERE id = '$id'");
        if($up == TRUE) {
            $_SESSION['result'] = ['type' => true,'message' => 'Data Updated.'];
            unset($_SESSION['csrf']);
             exit(header("Location: ".$_SERVER['PHP_SELF']));
        } else {
            $_SESSION['result'] = ['type' => false,'message' => 'Our server is in trouble, please try again later.'];
        }
    }
} else if(isset($_POST['delete'])) {
    $id = filter($_POST['id']);
    if($result_csrf == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'System error, please try again later.'];
    } else if($data_user['level'] !== 'Admin') {
        $_SESSION['result'] = ['type' => false,'message' => 'You do not have permission to access this feature.'];
    } else if($sess_username == 'demo') {
        $_SESSION['result'] = ['type' => false,'message' => 'Demo accounts do not have permission to access this feature.'];
    } else if($call->query("SELECT id FROM modules_urgent_alert WHERE id = '$id'")->num_rows == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'Data not found.'];
    } else {
        $up = $call->query("DELETE FROM modules_urgent_alert WHERE id = '$id'");
        if($up == TRUE) {
            $_SESSION['result'] = ['type' => true,'message' => 'Data deleted successfully.'];
            unset($_SESSION['csrf']);
            exit(header("Location: ".$_SERVER['PHP_SELF']));
        } else {
            $_SESSION['result'] = ['type' => false,'message' => 'Our server is in trouble, please try again later.'];
        }
    }

} else if(isset($_POST['unshow_all'])) {
    if($result_csrf == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'System error, please try again later.'];
    } else if($data_user['level'] !== 'Admin') {
        $_SESSION['result'] = ['type' => false,'message' => 'You do not have permission to access this feature.'];
    } else if($sess_username == 'demo') {
        $_SESSION['result'] = ['type' => false,'message' => 'Demo accounts do not have permission to access this feature.'];
    } else {
        $up = $call->query("UPDATE modules_urgent_alert set is_show = '0'");
        if($up == TRUE) {
            $_SESSION['result'] = ['type' => true,'message' => 'Notifikasi Dimatikan.'];
            unset($_SESSION['csrf']);
            exit(header("Location: ".$_SERVER['PHP_SELF']));
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
                              <h4 class="card-title" title="Click to Add" onclick="modal('Publish Notifikasi','<?= base_url('admin/urgent-alert/add') ?>','','lg')"><i class="fas fa-plus-circle mr-2"></i> Notifikasi Berjalan </h4>
                           </div>
                           <?php if($call->query("SELECT * FROM modules_urgent_alert WHERE is_show = 1")->num_rows > 0): ?>
                           <form method="POST">
                                <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
                                <button type="submit" name="unshow_all" class="btn btn-primary btn-block">Matikan</button>
                           </form>
                            <?php endif; ?>
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
                                        <th>ID</th>
                                        <th>Isi</th>
                                        <th>Tampilkan</th>
                                        <th>Urutan</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
<?php 
$no = 1;
if(isset($_GET['show'])) {
    $pt_show = filter_entities($_GET['show']);
    $pt_search = filter($_GET['search']);
    $search = "SELECT * FROM modules_urgent_alert WHERE info LIKE '%$pt_search%' ORDER BY id DESC";
} else {
    $search = "SELECT * FROM modules_urgent_alert ORDER BY id DESC";
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
                                            <input type="hidden" id="id" name="id" value="<?= $row_query['id'] ?>">
                                            <td><?= $no; ?></td>
                                            <td><?= $row_query['info'] ?></td>
                                            <td><?= ($row_query['is_show']) ? 'Ya' : 'Tidak'; ?></td>
                                            <td><?= $row_query['order_id'] ?></td>
                                            <td align="center">
                                                <a href="javascript:;" onclick="modal('Edit Notifikasi','<?= base_url('admin/urgent-alert/edit?id='.$row_query['id']) ?>','','md')" class="btn btn-sm btn-warning text-white">
                                                    <i class="fas fa-pencil-alt" title="Edit Notifikasi"></i>
                                                </a>
                                                <button title="Delete Notifikasi" type="submit" name="delete" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></button>

                                            </td>
                                        </form> 
                                    </tr>
<? $no++; } ?>
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