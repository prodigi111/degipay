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

$get = isset($_GET['q']) ? filter(base64_decode($_GET['q'])) : '';
$search = $call->query("SELECT * FROM produk WHERE kode = '$get'");
if($search->num_rows == 0) exit(redirect(0,base_url('admin/shop/')));
$data = $search->fetch_assoc();

$image = json_decode($data['image'], TRUE);

if(isset($_POST['edit'])) {
    $post_token = $get;
    $post1 = filter($_POST['nama']);
    $post2 = filter($_POST['kategori']);
    $post3 = filter($_POST['harga']);
    $post4 = filter($_POST['profit']);
    $post5 = filter($_POST['keterangan']);
    $post6 = filter($_POST['status']);
    $post7 = filter($_POST['data']);
    
    if($result_csrf == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'System error, please try again later.'];
    } else if($data_user['level'] !== 'Admin') {
        $_SESSION['result'] = ['type' => false,'message' => 'You do not have permission to access this feature.'];
    } else if($sess_username == 'demo') {
        $_SESSION['result'] = ['type' => false,'message' => 'Demo accounts do not have permission to access this feature.'];
    } else if(!$post1 || !$post2 || !$post3 || !$post4 || !$post5 || !in_array($post6,['READY','SOLD']) || !$post7) {
        $_SESSION['result'] = ['type' => false,'message' => 'There are still empty columns.'];
    } else if($call->query("SELECT code FROM category WHERE code = '$post2'")->num_rows == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'Kategori Tidak Ditemukan.'];
    } else if($call->query("SELECT kode FROM produk WHERE kode = '$post_token'")->num_rows == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'Produk Tidak Ditemukan.'];
    } else {
        
        $ekstensi =  array('png', 'jpg', 'jpeg');
    	$jumlah = count($_FILES['image']['name']);
    	$path = $_SERVER['DOCUMENT_ROOT'].'/library/assets/images/produk/';
    	
		if ($jumlah > 0) {
        	for ($i = 0; $i < $jumlah; $i++) {
        	    $filename = $_FILES['image']['name'][$i];
        	    $ukuran = $_FILES['image']['size'][$i];
                if($filename[$i] == null) {
                    $file_name[] = ['image' => $image['data'][$i]['image']];
                } else {
            	    $rand = rand();
                    $ext = pathinfo($filename, PATHINFO_EXTENSION);
            	    if(in_array($ext, $ekstensi)) {
                		if($ukuran < 2044070) {      
                            $fileName = $rand.'_'.$filename;
                            if(move_uploaded_file($_FILES['image']['tmp_name'][$i], $path.$fileName)) {
                                file_exists($path.$image['data'][$i]['image']) ? unlink($path.$image['data'][$i]['image']) : '';
                                $file_name[] = ['image' => $fileName];
                            } else {
                                $_SESSION['result'] = ['type' => false,'message' => 'Gagal Upload.'];
                                exit();
                            }
                        } else {
                            $_SESSION['result'] = ['type' => false,'message' => 'Size Terlalu besar, maks 2 MB.'];
                            exit();
                        }
            	    } else {
            	        $_SESSION['result'] = ['type' => false,'message' => 'Ekstensi Gambar Yang Dibolehkan PNG, JPG, JPEG.'];
                        exit();
            	    }
            	}
        	}
            $result = ['data' => $file_name];
        } else {
            $result = ['data' => null];
        }

	    $image = json_encode($result); 
        $up = $call->query("UPDATE produk SET nama = '$post1', kategori = '$post2', harga = '$post3', profit = '$post4', keterangan = '$post5', status = '$post6', data = '$post7', image = '$image' WHERE kode = '$post_token'");
        if($up == TRUE) {
            $_SESSION['result'] = ['type' => true,'message' => 'Kode Produk '.$post_token.' Berhasil Di Update.'];
            redirect(0, base_url('admin/shop/index'));
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
                              <h4 class="card-title"><i class="fas fa-cogs text-primary mr-2"></i> Tambah Produk </h4>
                           </div>
                        </div>
                        <form method="POST" enctype="multipart/form-data">
                            <div class="iq-card-body">
                                <? require _DIR_('library/session/result'); ?>
                                <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" class="form-control" name="nama" placeholder="Mobile Legend Full Skin" value="<?= $data['nama'] ?>">
                                </div>
                                <div class="form-group">
                                    <label>Kategori</label>
                                    <select name="kategori" class="form-control">
                                        <option value="<?= $data['kategori'] ?>" selected><?= $data['kategori'] ?></option>
                                        <?php
                                        $search = $call->query("SELECT * FROM category WHERE type = 'shop' AND code != '".$data['kategori']."' ORDER BY code ASC");
                                        while($row = $search->fetch_assoc()) {
                                            print '<option value="'.$row['code'].'">'.ucwords(str_replace('-', ' ', $row['name'])).'</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Harga</label>
                                    <input type="text" class="form-control" name="harga" placeholder="10000" value="<?= $data['harga'] ?>">
                                </div>
                                <div class="form-group">
                                    <label>Profit</label>
                                    <input type="text" class="form-control" name="profit" placeholder="10000" value="<?= $data['profit'] ?>">
                                </div>
                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="status" class="form-control">
                                        <?= select_opt($data['status'],'READY','READY') ?>
                                        <?= select_opt($data['status'],'SOLD','SOLD') ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Keterangan</label>
                                    <textarea class="form-control" name="keterangan" placeholder="Akun Sultan 100 Skin blablabla..."><?= $data['keterangan'] ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Data</label>
                                    <textarea class="form-control" name="data" placeholder="Isi Data Akun"><?= $data['data'] ?></textarea>
                                </div>
                                <div class="form-row">
                                <? for($i = 0; $i <= count($image['data'])-1; $i++) { ?>
                                <div class="col-sm-6">
                                    <img src="<?= assets('images/produk/').$image['data'][$i]['image'] ?>" alt="alt" width="100%" class="mt-2">
                                    <input type="file" class="form-control" name="image[]" accept="image/*" multiple>
                                </div>
                                <? } ?>
                                </div>
                            </div>
                            <ul class="list-group list-group-flush">
                               <li class="list-group-item"></li>
                            </ul>
                            <div class="iq-card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <button type="submit" name="edit" class="btn btn-block btn-primary">Submit</button>
                                    </div>
                                    <div class="col-6">
                                        <button type="submit" name="shenn_reset" class="btn btn-block btn-danger">Reset</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                     </div>
                  </div>
<? require _DIR_('library/footer/admin'); ?>