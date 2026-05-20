<?php 
require '../connect.php';
require _DIR_('library/session/user');
if(in_array($data_user['level'],['Premium'])) {
    $_SESSION['result'] = ['type' => false,'message' => 'Kamu sudah level premium!'];
    redirect(0, base_url());
}
$page = 'Verifikasi Identitas';
if(isset($_POST['submit'])) {
    $phone = $data_user['phone'];
    $post_nama =  filter($_POST['nama']);
    $post_noiden =  filter($_POST['noiden']);
    $post_kelamin =  filter($_POST['kelamin']);
    $post_provinsi =  filter($_POST['provinsi']);
    $post_kota =  filter($_POST['kota']);
    $post_kecamatan =  filter($_POST['kecamatan']);
    $post_alamat =  filter($_POST['alamat']);
    $post_kodepost =  filter($_POST['kodepost']);
    $post_nowhatsapp =  filter($_POST['nowhatsapp']);
    
    $ekstensi =  array('png','jpg','jpeg');
    $rand = rand();
    // Upload Foto KTP
    $filenamef = $_FILES['foto_identitas']['name'];
    $extf = pathinfo($filenamef, PATHINFO_EXTENSION);
    
    // Upload Foto Selfie Memegang KTP
    $filenamep = $_FILES['foto_selfie']['name'];
    $extp = pathinfo($filenamep, PATHINFO_EXTENSION);
    $provinsi = $call->query("SELECT * FROM daftar_provinsi WHERE code = '$post_provinsi'")->fetch_assoc()['name'];
    $kota = $call->query("SELECT * FROM daftar_kota WHERE code = '$post_kota'")->fetch_assoc()['name'];
    $kecamatan = $call->query("SELECT * FROM daftar_kecamatan WHERE code = '$post_kecamatan'")->fetch_assoc()['name'];
    if($result_csrf == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'System Error, please try again later.'];
    } else if($sess_username == 'demo') {
        $_SESSION['result'] = ['type' => false,'message' => 'Akun demo tidak memiliki izin untuk mengakses fitur ini.'];
    } else if(in_array($data_user['level'],['Premium'])) {
        $_SESSION['result'] = ['type' => false,'message' => 'Kamu sudah level premium!'];
    } else if(!$post_nama || !$post_noiden) {
        $_SESSION['result'] = ['type' => false, 'message' => 'Masukkan nama & nomor identitas telebih dahulu!.'];
    } else if(!in_array($post_kelamin,['pria','wanita'])) {
        $_SESSION['result'] = ['type' => false, 'message' => 'Pilih jenis kelamin telebih dahulu!.'];
    } else if(!$post_provinsi || !$post_kota) {
        $_SESSION['result'] = ['type' => false, 'message' => 'Pilih provinsi & kota/kabupaten telebih dahulu!.'];
    } else if(!$post_alamat || !$post_kodepost) {
        $_SESSION['result'] = ['type' => false, 'message' => 'Masukkan alamat & kode pos telebih dahulu!.'];
    #} else if(!$post_nowhatsapp <> $data_user['phone']) {
    } else if($post_nowhatsapp <> $data_user['phone']) {
       $_SESSION['result'] = ['type' => false, 'message' => 'Nomor whatsapp tidak sesuai dengan yang didaftarkan.']; 
    } else if(!$post_nowhatsapp) {
        $_SESSION['result'] = ['type' => false, 'message' => 'Masukkan nomor whatsapp telebih dahulu!.'];
    } else if($call->query("SELECT * FROM daftar_provinsi WHERE code = '$post_provinsi'")->num_rows == 0 && $call->query("SELECT * FROM daftar_kota WHERE code = '$post_kota'")->num_rows == 0 && $call->query("SELECT * FROM daftar_kecamatan WHERE code = '$post_kecamatan'")->num_rows == 0) {
        $_SESSION['result'] = ['type' => false, 'message' => 'Provinsi, Kota / Kabupaten & Kecamatan tidak ditemukan!.'];
    } else if(!in_array($extf,$ekstensi) || !in_array($extp,$ekstensi)) {
        $_SESSION['result'] = ['type' => false,'message' => 'Ekstensi Gambar tidak valid.'];
    } else {
        $xxf = $rand.'_'.$filenamef;
        $xxp = $rand.'_'.$filenamep;
        if(move_uploaded_file($_FILES['foto_identitas']['tmp_name'], $_SERVER['DOCUMENT_ROOT'].'/library/assets/images/verifikasi_user/'.$rand.'_'.$filenamef)) {
            if(move_uploaded_file($_FILES['foto_selfie']['tmp_name'], $_SERVER['DOCUMENT_ROOT'].'/library/assets/images/verifikasi_user/'.$rand.'_'.$filenamep)) {
            $up = $call->query("INSERT INTO verifikasi_user VALUES ('','$sess_username','$post_nama', '$post_noiden', '$post_kelamin','$provinsi','$kota','$kecamatan','$post_alamat','$post_kodepost','$post_nowhatsapp','$xxf','$xxp','$date $time','Process')");
            if($up == TRUE) {
                $_SESSION['result'] = ['type' => true,'message' => 'Berhasil verifikasi user, silahkan menunggu persetujuan admin.'];
                unset($_SESSION['csrf']);
                exit(header("Location: ".$_SERVER['PHP_SELF']));
            } else {
                $_SESSION['result'] = ['type' => false,'message' => 'Our server is in trouble, please try again later.'];
            }
            } else {
            $_SESSION['result'] = ['type' => false,'message' => 'Gagal Upload Foto Pernyataan.'];
            }
        } else {
            $_SESSION['result'] = ['type' => false,'message' => 'Gagal Upload Foto Selfie.'];
        }
    }
}
require _DIR_('library/header/user');
?>

<div id="appCapsule">
    <div class="section bg-white pt-2 pb-5">
        <form method="POST" role="form" enctype="multipart/form-data">
            <? require _DIR_('library/session/result-mobile') ?>
            <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
            <div class="form-group basic">
                <div class="input-wrapper">
                    <h5>Nama Sesuai Identitas (KTP/SIM)</h5>
                    <input type="text" class="form-control" placeholder="Masukkan Nama Sesuai Identitas (KTP/SIM)" name="nama" required>
                </div>
            </div>
            <div class="form-group basic">
                <div class="input-wrapper">
                    <h5>Nomor Identitas (KTP/SIM)</h5>
                    <input type="number" class="form-control" placeholder="Masukkan Nomor Identitas (KTP/SIM)" name="noiden" required>
                </div>
            </div>
            <div class="form-group basic">
                <div class="input-wrapper">
                    <h5>Jenis Kelamin</h5>
                    <select name="kelamin" class="form-control">
                        <option value="" disabled selected hidden>Jenis Kelamin</option>
                        <option value="pria">Laki-laki</option>
                        <option value="wanita">Perempuan</option>
                    </select>
                </div>
            </div>
            <div class="form-group basic">
                <div class="input-wrapper">
                    <h5>Provinsi</h5>
                    <select name="provinsi" id="provinsi" class="form-control">
                        <option class="default" value="">Pilih Provinsi</option>
                                <?php
                                $search = $call->query("SELECT * FROM daftar_provinsi GROUP BY name ORDER BY name ASC");
                                while($row = $search->fetch_assoc()) {
                                    print '<option value="'.$row['code'].'">'.ucwords(str_replace('-', ' ', $row['name'])).'</option>';
                                }
                                ?>
                    </select>
                </div>
            </div>
            <div class="form-group basic">
                <div class="input-wrapper">
                    <h5>Kota/Kabupaten</h5>
                    <select name="kota" id="kota" class="form-control">
                        <option class="default" value="">Pilih Kota/Kabupaten</option>
                    </select>
                </div>
            </div>
            <div class="form-group basic">
                <div class="input-wrapper">
                    <h5>Kecamatan</h5>
                    <select name="kecamatan" id="kecamatan" class="form-control">
                        <option class="default" value="">Pilih Kecamatan</option>
                    </select>
                </div>
            </div>
            <div class="form-group basic">
                <div class="input-wrapper">
                    <h5>Alamat Sesuai Identitas (KTP/SIM)</h5>
                    <input type="text" class="form-control" placeholder="Alamat Sesuai Identitas (KTP/SIM)" name="alamat" required>
                </div>
            </div>
            <div class="form-group basic">
                <div class="input-wrapper">
                    <h5>Kode POS</h5>
                    <input type="text" class="form-control" placeholder="Masukkan Kode POS" name="kodepost" required>
                </div>
            </div>
            <div class="form-group basic">
                <div class="input-wrapper">
                    <h5>Email</h5>
                    <input type="text" class="form-control" placeholder="Masukkan Email" name="email" required>
                </div>
            </div>
            <div class="form-group basic">
                <div class="input-wrapper">
                    <h5>Nomor WhatsApp</h5>
                    <input type="text" class="form-control" placeholder="Masukkan Nomor WhatsApp" name="nowhatsapp" required>
                </div>
            </div>
            <div class="form-group basic">
                <div class="input-wrapper" style="font-size:13px;">
                    <h5>Upload Foto KTP</h5>
                        <input type="file" class="form-control-file" name="foto_identitas" required>
                        <span class="text-danger">Extensi (png, jpg, jpeg).</span>
                        <i class="clear-input">
                        <ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon>
                    </i>
                    <h5 class="text-center">Contoh</h5>
                    <center style="border:2.5px dashed #CCC">
                    <img src="<?= assets('images/icon/icon-ktp.jpg').'?'.time() ?>" class="imaged" width="125px" height="375px">
                    </center>
                </div>
            </div>
            <div class="form-group basic">
                <div class="input-wrapper" style="font-size:13px;">
                    <h5>Upload Foto Selfie + Memegang KTP</h5>
                        <input type="file" class="form-control-file" name="foto_selfie" required>
                        <span class="text-danger">Extensi (png, jpg, jpeg).</span>
                        <i class="clear-input">
                        <ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon>
                    </i>
                    <h5 class="text-center">Contoh</h5>
                    <center style="border:2.5px dashed #CCC">
                    <img src="<?= assets('images/icon/icon-selfie-ktp.jpg').'?'.time() ?>" class="imaged" width="125px" height="375px">
                    </center>
                </div>
            </div>
            <div class="pt-1 pb-1 form-bottom-fixed">
                <button type="submit" name="submit" class="btn bg-primary rounded shadowed btn-block mt-1 mb-1 onclick="var e=this;setTimeout(function(){e.disabled=true;},0);return true;">Submit</button>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function() {
    $("#provinsi").change(function() {
		var provinsi = $("#provinsi").val();
		$.ajax({
			url: '<?= ajaxlib('daftar-kota.php') ?>',
			data: 'provinsi=' + provinsi,
			type: 'POST',
			dataType: 'html',
			success: function(msg) {
				$("#kota").html(msg);
			}
		});
	});
    $("#kota").change(function() {
		var kota = $("#kota").val();
		$.ajax({
			url: '<?= ajaxlib('daftar-kecamatan.php') ?>',
			data: 'kota=' + kota,
			type: 'POST',
			dataType: 'html',
			success: function(msg) {
				$("#kecamatan").html(msg);
			}
		});
	});
});
</script>
    <!-- * App Capsule -->
<?php require _DIR_('library/footer/user') ?>