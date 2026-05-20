<?php 
require '../../connect.php';
require _DIR_('library/session/admin');

if(isset($_POST['submit'])) {
    $kode       = 'RGS-'.strtoupper(random(4)).'-PRDK';
    $nama       = filter($_POST['nama']);
    $kategori   = filter($_POST['kategori']);
    $harga      = filter($_POST['harga']);
    $profit     = filter($_POST['profit']);
    $keterangan = filter($_POST['keterangan']);
    $data       = filter($_POST['data']);
    $status     = 'READY';
    
    if($result_csrf == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'System error, please try again later.'];
    } else if($data_user['level'] !== 'Admin') {
        $_SESSION['result'] = ['type' => false,'message' => 'You do not have permission to access this feature.'];
    } else if($sess_username == 'demo') {
        $_SESSION['result'] = ['type' => false,'message' => 'Demo accounts do not have permission to access this feature.'];
    } else if(!$nama || !$kategori || !$harga || !$keterangan || !$data) {
        $_SESSION['result'] = ['type' => false,'message' => 'Masih Ada Form yang kosong.'];
    } else {
        $ekstensi =  array('png', 'jpg', 'jpeg');
    	$jumlah = count($_FILES['image']['name']);
    	
		if ($jumlah > 0) {
        	for ($i = 0; $i < $jumlah; $i++) { 
        	    $rand = rand();
        	    $filename = $_FILES['image']['name'][$i];
        	    $ukuran = $_FILES['image']['size'][$i];
                $ext = pathinfo($filename, PATHINFO_EXTENSION);
        	    if(in_array($ext, $ekstensi)) {
            		if($ukuran < 2044070) {      
                        $fileName = $rand.'_'.$filename;
                        if(move_uploaded_file($_FILES['image']['tmp_name'][$i], $_SERVER['DOCUMENT_ROOT'].'/library/assets/images/produk/'.$fileName)) {
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
            $result = ['data' => $file_name];
        } else {
            $result = ['data' => null];
        }

	    $image = json_encode($result); 
        if($result['data'] !== null) {
            if($call->query("INSERT INTO produk VALUES ('', '$kode', '$nama', '$harga', '$profit', '$keterangan', '$kategori', '$data', '$status', '$image')") == TRUE) {
                $_SESSION['result'] = ['type' => true,'message' => 'Produk Berhasil Ditambahkan'];
            } else {
                $_SESSION['result'] = ['type' => false,'message' => 'Our server is in trouble, please try again later.'];
            }
        } else {
            $_SESSION['result'] = ['type' => false,'message' => 'Tidak Ada Satupun Gambar Yang Di Upload!'];
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
                                    <input type="text" class="form-control" name="nama" placeholder="Mobile Legend Full Skin">
                                </div>
                                <div class="form-group">
                                    <label>Kategori</label>
                                    <select name="kategori" class="form-control">
                                        <option value="">- Select One -</option>
                                        <?php
                                        $search = $call->query("SELECT * FROM category WHERE type = 'shop' ORDER BY code ASC");
                                        while($row = $search->fetch_assoc()) {
                                            print '<option value="'.$row['code'].'">'.ucwords(str_replace('-', ' ', $row['name'])).'</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Harga</label>
                                    <input type="text" class="form-control" name="harga" placeholder="10000">
                                </div>
                                <div class="form-group">
                                    <label>Profit</label>
                                    <input type="text" class="form-control" name="profit" placeholder="10000">
                                </div>
                                <div class="form-group">
                                    <label>Keterangan</label>
                                    <textarea class="form-control" name="keterangan" placeholder="Akun Sultan 100 Skin blablabla..."></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Data</label>
                                    <textarea class="form-control" name="data" placeholder="Isi Data Akun"></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Gambar</label>
                                    <input type="file" class="form-control" name="image[]" accept="image/*" multiple>
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
<? require _DIR_('library/footer/admin'); ?>