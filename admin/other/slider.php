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

if(isset($_POST['show'])) {
    $id = filter($_POST['web_token']);
    if($result_csrf == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'System error, please try again later.'];
    } else if($data_user['level'] !== 'Admin') {
        $_SESSION['result'] = ['type' => false,'message' => 'You do not have permission to access this feature.'];
    } else if($sess_username == 'demo') {
        $_SESSION['result'] = ['type' => false,'message' => 'Demo accounts do not have permission to access this feature.'];
    } else if($call->query("SELECT id FROM slider WHERE id = '$id'")->num_rows == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'Information not found.'];
    } else {
        $up = $call->query("UPDATE slider SET status = '1' WHERE id = '$id'");
        if($up == TRUE) {
            $_SESSION['result'] = ['type' => true,'message' => 'Show Slider successfully.'];
            unset($_SESSION['csrf']);
            exit(header("Location: ".$_SERVER['PHP_SELF']));
        } else {
            $_SESSION['result'] = ['type' => false,'message' => 'Our server is in trouble, please try again later.'];
        }
    }
} else if(isset($_POST['hide'])) {
    $id = filter($_POST['web_token']);
    if($result_csrf == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'System error, please try again later.'];
    } else if($data_user['level'] !== 'Admin') {
        $_SESSION['result'] = ['type' => false,'message' => 'You do not have permission to access this feature.'];
    } else if($sess_username == 'demo') {
        $_SESSION['result'] = ['type' => false,'message' => 'Demo accounts do not have permission to access this feature.'];
    } else if($call->query("SELECT id FROM slider WHERE id = '$id'")->num_rows == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'Information not found.'];
    } else {
        $up = $call->query("UPDATE slider SET status = '0' WHERE id = '$id'");
        if($up == TRUE) {
            $_SESSION['result'] = ['type' => true,'message' => 'Hide Slider successfully.'];
            unset($_SESSION['csrf']);
            exit(header("Location: ".$_SERVER['PHP_SELF']));
        } else {
            $_SESSION['result'] = ['type' => false,'message' => 'Our server is in trouble, please try again later.'];
        }
    }
} else if(isset($_POST['edit'])) {
    $id = filter($_POST['web_token']);
    $type = filter($_POST['type']);
    $rand = rand();
    $ekstensi =  array('png','jpg','jpeg');
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
    } else if($call->query("SELECT id FROM slider WHERE id = '$id'")->num_rows == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'Information not found.'];
    } else {
        if($ukuran < 1044070){      
            $xx = $rand.'_'.$filename;
            if(move_uploaded_file($_FILES['image']['tmp_name'], $_SERVER['DOCUMENT_ROOT'].'/library/assets/images/slider/'.$rand.'_'.$filename)) {
                $up = $call->query("UPDATE slider SET img = '$xx', type = '$type' WHERE id = '$id'");
                if($up == TRUE) {
                    $_SESSION['result'] = ['type' => true,'message' => 'Slider Changes successfully.'];
                    unset($_SESSION['csrf']);
                    exit(header("Location: ".$_SERVER['PHP_SELF']));
                } else {
                    $_SESSION['result'] = ['type' => false,'message' => 'Our server is in trouble, please try again later.'];
                }
            } else {
                $_SESSION['result'] = ['type' => false,'message' => 'Gagal Upload.'];
            }
        }else{
            $_SESSION['result'] = ['type' => false,'message' => 'Size Terlalu besar, maks 1 MB.'];
        }
    }
}

require _DIR_('library/header/admin');
?>
                  <div class="col-lg-12">
                     <div class="iq-card">
                        <div class="iq-card-header d-flex justify-content-between">
                           <div class="iq-header-title">
                              <h4 class="card-title">Slider </h4>
                           </div>
                        </div>
                        <div class="iq-card-body">
                            <? require _DIR_('library/session/result'); ?>
                            <div class="table-responsive">
                                <table id="datatable-responsive" class="table table-striped table-bordered nowrap">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Image</th>
                                            <th>Status</th>
                                            <th>Type</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php 
$no = 1;
$new_query = $call->query("SELECT * FROM slider ORDER BY id ASC");

while ($row_query = $new_query->fetch_assoc()) {
?>
                                        <tr>
                                            <form method="POST" class="form-inline" role="form">
                                                <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
                                                <input type="hidden" id="web_token" name="web_token" value="<?= $row_query['id'] ?>">
                                                <td><span class="badge badge-dark"><?= $row_query['id'] ?></span></td>
                                                <td><?= $row_query['img'] ?></td>
                                                <td><?= $row_query['status'] == 1 ? 'Show' : 'Hide' ?></td>
                                                <td><?= $row_query['type'] ?></td>
                                                <td align="text-center">
                                                <?php if($row_query['status'] == 1): ;?>
                                                    <button title="Hide" type="submit" name="hide" class="btn iq-bg-danger btn-rounded btn-sm my-0">Hide</button>
                                                <?php else: ?>
                                                    <button title="Show" type="submit" name="show" class="btn iq-bg-success btn-rounded btn-sm my-0">Show</button>
                                                <?php endif; ?>
                                                    <a href="#" title="Edit" data-toggle="modal" data-target="#modalid<?= $row_query['id'] ;?>" class="btn iq-bg-info btn-rounded btn-sm my-0">Edit</a>
                                                </td>
                                            </form>
                                        </tr>
                                        <div class="modal fade" id="modalid<?= $row_query['id'] ;?>" tabindex="-1" role="dialog" aria-labelledby="modalID" style="display: none;" aria-hidden="true">
                                          <div class="modal-dialog modal-dialog-centered" role="document">
                                             <div class="modal-content">
                                                <div class="modal-header">
                                                   <h5 class="modal-title">Slider #<?= $row_query['id'] ;?></h5>
                                                   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                   <span aria-hidden="true">×</span>
                                                   </button>
                                                </div>
                                                <form method="POST" class="form-inline" role="form" enctype="multipart/form-data">
                                                    <div class="modal-body">
                                                    <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
                                                    <input type="hidden" id="web_token" name="web_token" value="<?= $row_query['id'] ?>">
                                                    <div class="form-group">
                                                         <label for="image">Image Slider</label>
                                                         <input type="file" class="form-control-file" name="image" id="image" required>
                                                         <span class="text-danger">Extensi (png, jpg, jpeg). Ukuran max. 1MB, (800 x 400 )</span>
                                                    </div>
                                                    <div class="form-group">
                                                         <label for="image">Type</label>
                                                         <select class="form-control" name="type">
                                                             <?= select_opt($row_query['type'],'Vertical','Vertical') ?>
                                                             <?= select_opt($row_query['type'],'Horizontal','Horizontal') ?>
                                                         </select>
                                                    </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                       <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                                       <button type="submit" name="edit" class="btn btn-primary">Simpan</button>
                                                    </div>
                                                </form>
                                             </div>
                                          </div>
                                       </div>
<? } ?>
                                </tbody>
                              </table>
                           </div>
                        </div>
                     </div>
                  </div>
<? require _DIR_('library/footer/admin'); ?>
