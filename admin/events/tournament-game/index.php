<?php 
require '../../../connect.php';
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
if(isset($_POST['publish'])) {
    $title = filter($_POST['title']);
    $description = filter($_POST['description']);
    $target = filter($_POST['target']);
    $expired_at = filter($_POST['expired_at']);

    $rand = rand();
    $ekstensi =  array('jpg','jpeg');
    $filename = $_FILES['image']['name'];
    $ukuran = $_FILES['image']['size'];
    $ext = pathinfo($filename, PATHINFO_EXTENSION);

    if($result_csrf == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'System error, please try again later.'];
    } else if(!in_array($ext,$ekstensi)) {
        $_SESSION['result'] = ['type' => false,'message' => 'Ekstensi Gambar tidak valid.'];
    } else if($data_user['level'] !== 'Admin') {
        $_SESSION['result'] = ['type' => false,'message' => 'You do not have permission to access this feature.'];
    } else if($sess_username == 'demo') {
        $_SESSION['result'] = ['type' => false,'message' => 'Demo accounts do not have permission to access this feature.'];
    } else if(!$title || !$description || !$target || !$expired_at) {
        $_SESSION['result'] = ['type' => false,'message' => 'Ada From yang kosong.'];
    } else if($call->query("SELECT * FROM events_tournament_game WHERE id = '$target'")->num_rows == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'Tournament Game Not Found.'];
    } else if($call->query("SELECT * FROM events WHERE target = '$target'")->num_rows > 0) {
        $_SESSION['result'] = ['type' => false,'message' => 'Tournament Game Sudah Pernah Di Publish.'];
    } else {
        if($ukuran < 2044070){      
            $xx = $rand.'_'.$filename;
            if(move_uploaded_file($_FILES['image']['tmp_name'], $_SERVER['DOCUMENT_ROOT'].'/library/assets/images/events/'.$rand.'_'.$filename)) {
                $up = $call->query("INSERT INTO events (title, description, type, banner, target, expired_at) VALUES ('$title', '$description', 'Tournament Game', '$xx', '$target', '$expired_at')");
                if($up == TRUE) {
                    $_SESSION['result'] = ['type' => true,'message' => 'Event Published.'];
                    unset($_SESSION['csrf']);
                     exit(header("Location: ".$_SERVER['PHP_SELF']));
                } else {
                    $_SESSION['result'] = ['type' => false,'message' => 'Our server is in trouble, please try again later.'];
                }
            } else {
                $_SESSION['result'] = ['type' => false,'message' => 'Gagal Upload.'];
            }
        }else{
            $_SESSION['result'] = ['type' => false,'message' => 'Size Terlalu besar, maks 2 MB.'];
        }
    }
} else if(isset($_POST['edit'])) {
    $id = filter($_POST['id']);
    $title = filter($_POST['title']);
    $description = filter($_POST['description']);
    $target = filter($_POST['target']);
    $expired_at = filter($_POST['expired_at']);

    if($_FILES['image']['name'] != '') {
        $rand = rand();
        $ekstensi =  array('jpg','jpeg');
        $filename = $_FILES['image']['name'];
        $ukuran = $_FILES['image']['size'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
    }

    if($result_csrf == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'System error, please try again later.'];
    } else if($data_user['level'] !== 'Admin') {
        $_SESSION['result'] = ['type' => false,'message' => 'You do not have permission to access this feature.'];
    } else if($sess_username == 'demo') {
        $_SESSION['result'] = ['type' => false,'message' => 'Demo accounts do not have permission to access this feature.'];
    } else if(!$title || !$description || !$target || !$expired_at) {
        $_SESSION['result'] = ['type' => false,'message' => 'Ada From yang kosong.'];
    } else if($call->query("SELECT * FROM events_tournament_game WHERE id = '$target'")->num_rows == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'Tournament Game Not Found.'];
    } else {
        if($_FILES['image']['name'] != '') {
            if(!in_array($ext,$ekstensi)) {
                $_SESSION['result'] = ['type' => false,'message' => 'Ekstensi Gambar tidak valid.'];
            } else {
                if($ukuran < 2044070){      
                    $xx = $rand.'_'.$filename;
                    if(move_uploaded_file($_FILES['image']['tmp_name'], $_SERVER['DOCUMENT_ROOT'].'/library/assets/images/events/'.$rand.'_'.$filename)) {
                        $up = $call->query("UPDATE events SET title = '$title', description = '$description', target = '$target', expired_at = '$expired_at', banner = '$xx' WHERE id = '$id'");
                        if($up == TRUE) {
                            $_SESSION['result'] = ['type' => true,'message' => 'Event Updated.'];
                            unset($_SESSION['csrf']);
                             exit(header("Location: ".$_SERVER['PHP_SELF']));
                        } else {
                            $_SESSION['result'] = ['type' => false,'message' => 'Our server is in trouble, please try again later.'];
                        }
                    } else {
                        $_SESSION['result'] = ['type' => false,'message' => 'Gagal Upload.'];
                    }
                }else{
                    $_SESSION['result'] = ['type' => false,'message' => 'Size Terlalu besar, maks 2 MB.'];
                }
            }
        } else {
            $up = $call->query("UPDATE events SET title = '$title', description = '$description', target = '$target', expired_at = '$expired_at'  WHERE id = '$id'");
            if($up == TRUE) {
                $_SESSION['result'] = ['type' => true,'message' => 'Event Updated.'];
                unset($_SESSION['csrf']);
                 exit(header("Location: ".$_SERVER['PHP_SELF']));
            } else {
                $_SESSION['result'] = ['type' => false,'message' => 'Our server is in trouble, please try again later.'];
            }
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
    } else if($call->query("SELECT id FROM events WHERE id = '$id'")->num_rows == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'Event not found.'];
    } else {
        $up = $call->query("DELETE FROM events WHERE id = '$id'");
        if($up == TRUE) {
            $_SESSION['result'] = ['type' => true,'message' => 'Events deleted successfully.'];
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
                              <h4 class="card-title" title="Click to Add" onclick="modal('Publish Event','<?= base_url('admin/events/tournament-game/add_publish') ?>','','lg')"><i class="fas fa-plus-circle mr-2"></i> Publish Event </h4>
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
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Tournament Game</th>
                                        <th>Banner</th>
                                        <th>Expired</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
<?php 
$no = 1;
if(isset($_GET['show'])) {
    $pt_show = filter_entities($_GET['show']);
    $pt_search = filter($_GET['search']);
    $search = "SELECT * FROM events WHERE type = 'Tournament Game' AND title LIKE '%$pt_search%' OR description LIKE '%$pt_search%' ORDER BY id DESC";
} else {
    $search = "SELECT * FROM events WHERE type = 'Tournament Game' ORDER BY id DESC";
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
    $game_name = $call->query("SELECT * FROM events_tournament_game WHERE id = '".$row_query['target']."'")->fetch_assoc()['name'];
?>
                                    <tr>
                                        <form method="POST" class="form-inline" role="form">
                                            <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
                                            <input type="hidden" id="id" name="id" value="<?= $row_query['id'] ?>">
                                            <td><?= $no; ?></td>
                                            <td><?= $row_query['title'] ?></td>
                                            <td><?= nl2br($row_query['description']) ?></td>
                                            <td><?= $game_name ?></td>
                                            <td><?= $row_query['banner'] ?></td>
                                            <td><?= format_date('', $row_query['expired_at']) ?></td>
                                            <td align="center">
                                                <a href="javascript:;" onclick="modal('Edit Event','<?= base_url('admin/events/tournament-game/edit_published?id='.$row_query['id']) ?>','','md')" class="btn btn-sm btn-warning text-white">
                                                    <i class="fas fa-pencil-alt" title="Edit Event"></i>
                                                </a>
                                                <button title="Delete Event" type="submit" name="delete" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></button>

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