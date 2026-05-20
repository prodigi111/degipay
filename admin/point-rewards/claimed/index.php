<?php 
require '../../../connect.php';
require _DIR_('library/session/admin');
if(isset($_POST['edit'])) {
    $id = filter($_POST['id']);
    $name = filter($_POST['name']);
    $phone = filter($_POST['phone']);
    $address = filter($_POST['address']);
    $receipt = filter($_POST['receipt']);
    $status = filter($_POST['status']);
    $physical_address = json_encode([
        "name" => $name,
        "phone" => $phone,
        "address" => $address,
    ]);

    if($result_csrf == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'System error, please try again later.'];
    } else if($data_user['level'] !== 'Admin') {
        $_SESSION['result'] = ['type' => false,'message' => 'You do not have permission to access this feature.'];
    } else if($sess_username == 'demo') {
        $_SESSION['result'] = ['type' => false,'message' => 'Demo accounts do not have permission to access this feature.'];
    } else if(!$name || !$phone || !$address || !$status) {
        $_SESSION['result'] = ['type' => false,'message' => 'Ada From yang kosong.'];
    } else if($call->query("SELECT * FROM modules_point_rewards_data WHERE id = '$id'")->num_rows == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'Data Not Found.'];
    } else {
        if($receipt !== '' || $receipt != null) {
            $up = $call->query("UPDATE modules_point_rewards_data SET physical_address = '$physical_address', physical_receipt = '$receipt', status = '$status', updated_at = '$datetime' WHERE id = '$id'");
        } else {
            $up = $call->query("UPDATE modules_point_rewards_data SET physical_address = '$physical_address', physical_receipt = NULL, status = '$status', updated_at = '$datetime' WHERE id = '$id'");
        }
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
    } else if($call->query("SELECT id FROM modules_point_rewards_data WHERE id = '$id'")->num_rows == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'Data not found.'];
    } else {
        $up = $call->query("DELETE FROM modules_point_rewards_data WHERE id = '$id'");
        if($up == TRUE) {
            $_SESSION['result'] = ['type' => true,'message' => 'Data deleted successfully.'];
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
                              <h4 class="card-title"> Data Klaim </h4>
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
                                        <th>ID</th>
                                        <th>User</th>
                                        <th>Hadiah</th>
                                        <th>Alamat</th>
                                        <th>Resi</th>
                                        <th>Status</th>
                                        <th>Tanggal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
<?php 
$no = 1;
if(isset($_GET['show'])) {
    $pt_show = filter_entities($_GET['show']);
    $pt_search = filter($_GET['search']);
    $search = "SELECT * FROM modules_point_rewards_data WHERE user_id LIKE '%$pt_search%' OR reward_id LIKE '%$pt_search%' ORDER BY id DESC";
} else {
    $search = "SELECT * FROM modules_point_rewards_data ORDER BY id DESC";
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
$data_rewards = $call->query("SELECT * FROM modules_point_rewards WHERE id = '".$row_query['reward_id']."'")->fetch_assoc();
$data_users = $call->query("SELECT username FROM users WHERE id = '".$row_query['user_id']."'")->fetch_assoc();

$data_target = json_decode($row_query['physical_address']);
if($row_query['status'] === 'Make a Request') {
    $status = 'Mengajukan Permintaan';
    $color = 'warning';
} else if($row_query['status'] === 'Request Accepted') {
    $status = 'Permintaan Diterima';
    $color = 'info';
} else if($row_query['status'] === 'Processing') {
    $status = 'Sedang Di Proses';
    $color = 'primary';
} else if($row_query['status'] === 'Success') {
    $status = 'Berhasil';
    $color = 'success';
} else if($row_query['status'] === 'Failed') {
    $status = 'Permintaan Ditolak';
    $color = 'danger';
} else {
    $status = 'Tidak Diketahui';
    $color = 'secondary';
}
?>
                                    <tr>
                                        <form method="POST" class="form-inline" role="form">
                                            <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
                                            <input type="hidden" id="id" name="id" value="<?= $row_query['id'] ?>">
                                            <td><?= $no; ?></td>
                                            <td><?= $data_users['username'] ?></td>
                                            <td><?= $data_rewards['name'] ?></td>
                                            <td><?= (isset($row_query['physical_address'])) ? $data_target->name.', '.$data_target->phone.', '.$data_target->address : '-'; ?></td>
                                            <td><?= (isset($row_query['physical_receipt'])) ? $row_query['physical_receipt'] : '-' ?></td>
                                            <td class="text-<?= $color; ?>"><?= $status; ?></td>
                                            <td><?= format_date('', $row_query['created_at']) ?></td>
                                            <td>
                                                <?php if($data_rewards['type'] === 'Physical'): ?>
                                                <a href="javascript:;" onclick="modal('Edit Data','<?= base_url('admin/point-rewards/claimed/edit?id='.$row_query['id']) ?>','','md')" class="btn btn-sm btn-warning text-white">
                                                    <i class="fas fa-pencil-alt" title="Edit Event"></i>
                                                </a>
                                                <?php endif; ?>
                                                <button title="Delete Data" type="submit" name="delete" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></button>

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