<?php
require '../connect.php';
require _DIR_('library/session/user');

$_GET['q'] = (isset($_GET['q'])) ? $_GET['q'] : '';
if ($_GET['q'] === 'user') {
    $page = 'Username';
} else if ($_GET['q'] === 'photo') {
    $page = 'Profil';
} else if ($_GET['q'] === 'phone') {
    $page = 'Ganti Nomor HP';
} else if ($_GET['q'] === 'email') {
    $page = 'Ganti Alamat Email';
} else if ($_GET['q'] === 'pin') {
    $page = 'Ganti PIN';
} else {
    $page = 'Pengaturan Profil';
}

if (isset($_POST['updateUser'])) {
    $post_user = (!$_POST['username']) ? $data_user['username'] : filter($_POST['username']);
    $post_user = strtolower($post_user);
    $post_user = strtr($post_user, [' ' => '']);
    $post_pin = filter($_POST['pin']);

    if ($result_csrf == false) {
        $_SESSION['result'] = ['type' => false, 'message' => 'System Error, please try again later.'];
        redirect(0, base_url('account/settings'));
        unset($_SESSION['csrf']);
    } else if ($sess_username == 'demo') {
        $_SESSION['result'] = ['type' => false, 'message' => 'Akun demo tidak memiliki izin untuk mengakses fitur ini.'];
        redirect(0, base_url('account/settings'));
        unset($_SESSION['csrf']);
    } else if (!$post_pin) {
        $_SESSION['result'] = ['type' => false, 'message' => 'Masukkan konfirmasi pin keamanan telebih dahulu!.'];
        redirect(0, base_url('account/settings'));
        unset($_SESSION['csrf']);
    } else if (!$post_user) {
        $_SESSION['result'] = ['type' => false, 'message' => 'Formulir tidak boleh kosong.'];
        redirect(0, base_url('account/settings'));
        unset($_SESSION['csrf']);
    } else if ($call->query("SELECT * FROM users WHERE phone = '$post_user'")->num_rows == 1) {
        $_SESSION['result'] = ['type' => false, 'message' => 'Username sudah terdaftar, gunakan username yang lain.'];
        redirect(0, base_url('account/settings'));
        unset($_SESSION['csrf']);
    } else {
        if (check_bcrypt($post_pin, $data_user['pin']) == true) {
            $call->query("UPDATE users SET user = '$post_user' WHERE username = '$sess_username'");
            $_SESSION['result'] = ['type' => true, 'message' => 'Username Berhasil Diubah.'];
            redirect(0, base_url('account/settings'));
            unset($_SESSION['csrf']);
        }
    }
}if (isset($_POST['updatePhoto'])) {
    $ekstensi = array('png', 'jpg', 'jpeg');
    $rand = rand();
    // Upload Foto Pernyataan + KTP + Nomor WhatsApp
    $filename = $_FILES['photo']['name'];
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    if ($result_csrf == false) {
        $_SESSION['result'] = ['type' => false, 'message' => 'System Error, please try again later.'];
        redirect(0, base_url('account/settings'));
        unset($_SESSION['csrf']);
    } else if ($sess_username == 'demo') {
        $_SESSION['result'] = ['type' => false, 'message' => 'Akun demo tidak memiliki izin untuk mengakses fitur ini.'];
        redirect(0, base_url('account/settings'));
        unset($_SESSION['csrf']);
    } else if (!in_array($ext, $ekstensi)) {
        $_SESSION['result'] = ['type' => false, 'message' => 'Ekstensi Gambar tidak valid.'];
        redirect(0, base_url('account/settings'));
        unset($_SESSION['csrf']);
    } else {
        $xx = $rand . '_' . $filename;
        if (move_uploaded_file($_FILES['photo']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/library/assets/images/user/' . $rand . '_' . $filename)) {
            $up = $call->query("UPDATE users SET photo = '$xx', status_photo = 'Yes'  WHERE username = '$sess_username'");
            if ($up == TRUE) {
                $_SESSION['result'] = ['type' => true, 'message' => 'Profil Berhasil Diupload'];
                redirect(0, base_url('account/settings'));
                unset($_SESSION['csrf']);
            } else {
                $_SESSION['result'] = ['type' => false, 'message' => 'Our server is in trouble, please try again later.'];
            }
        } else {
            $_SESSION['result'] = ['type' => false, 'message' => 'Gagal Upload Foto Profil.'];
            redirect(0, base_url('account/settings'));
            unset($_SESSION['csrf']);
        }
    }
} else if (isset($_POST['deletePhoto'])) {
    $post_photo = filter($_POST['photo']);
    if ($result_csrf == false) {
        $_SESSION['result'] = ['type' => false, 'message' => 'System Error, please try again later.'];
        redirect(0, base_url('account/settings'));
        unset($_SESSION['csrf']);
    } else if ($sess_username == 'demo') {
        $_SESSION['result'] = ['type' => false, 'message' => 'Akun demo tidak memiliki izin untuk mengakses fitur ini.'];
        redirect(0, base_url('account/settings'));
        unset($_SESSION['csrf']);
    } else if ($call->query("SELECT photo FROM users WHERE photo = '$post_photo'")->num_rows == false) {
        $_SESSION['result'] = ['type' => false, 'message' => 'Data not found.'];
        redirect(0, base_url('account/settings'));
        unset($_SESSION['csrf']);
    } else {
        $up = $call->query("UPDATE users SET photo = 'default.png', status_photo = 'No' WHERE username = '$sess_username'");
        if ($up == TRUE) {
            $_SESSION['result'] = ['type' => true, 'message' => 'Profil Berhasil Dihapus.'];
            redirect(0, base_url('account/settings'));
            unset($_SESSION['csrf']);
        }
    }
}if (isset($_POST['updatePhone'])) {
    $post_phone = filter($_POST['phone']);
    $post_pin = filter($_POST['pin']);

    if ($result_csrf == false) {
        $_SESSION['result'] = ['type' => false, 'message' => 'System Error, please try again later.'];
    } else if ($sess_username == 'demo') {
        $_SESSION['result'] = ['type' => false, 'message' => 'Akun demo tidak memiliki izin untuk mengakses fitur ini.'];
    } else if (!$post_pin) {
        $_SESSION['result'] = ['type' => false, 'message' => 'Masukkan konfirmasi pin keamanan telebih dahulu!.'];
        redirect(0, base_url('account/settings'));
        unset($_SESSION['csrf']);
    } else if (!$post_phone) {
        $_SESSION['result'] = ['type' => false, 'message' => 'Formulir tidak boleh kosong.'];
        redirect(0, base_url('account/settings'));
        unset($_SESSION['csrf']);
    } else if ($call->query("SELECT * FROM users WHERE phone = '$post_phone'")->num_rows == 1) {
        $_SESSION['result'] = ['type' => false, 'message' => 'Nomor HP sudah terdaftar, gunakan nomor yang lain.'];
        redirect(0, base_url('account/settings'));
        unset($_SESSION['csrf']);
    } else {
        if (check_bcrypt($post_pin, $data_user['pin']) == true) {
            $call->query("UPDATE users SET phone = '$post_phone' WHERE username = '$sess_username'");
            $_SESSION['result'] = ['type' => true, 'message' => 'Nomor HP Berhasil Diubah.'];
            redirect(0, base_url('account/settings'));
            unset($_SESSION['csrf']);
        } else {
            $_SESSION['result'] = ['type' => false, 'message' => 'Pin keamanan tidak valid.'];
            redirect(0, base_url('account/settings'));
            unset($_SESSION['csrf']);
        }
    }
}if (isset($_POST['updateEmail'])) {
    $post_email = filter($_POST['email']);
    $post_AcceptMail = ['gmail.com', 'yahoo.com', 'outlook.com', 'icloud.com'];
    $post_email = strtr($post_email, [' ' => '']);
    $post_pin = filter($_POST['pin']);

    if ($result_csrf == false) {
        $_SESSION['result'] = ['type' => false, 'message' => 'System Error, please try again later.'];
        redirect(0, base_url('account/settings'));
        unset($_SESSION['csrf']);
    } else if ($sess_username == 'demo') {
        $_SESSION['result'] = ['type' => false, 'message' => 'Akun demo tidak memiliki izin untuk mengakses fitur ini.'];
        redirect(0, base_url('account/settings'));
        unset($_SESSION['csrf']);
    } else if (!in_array(explode('@', $post_email)[1], $post_AcceptMail)) {
        $_SESSION['result'] = ['type' => false, 'message' => 'Email tidak didukung.'];
        redirect(0, base_url('account/settings'));
        unset($_SESSION['csrf']);
    } else if (!$post_pin) {
        $_SESSION['result'] = ['type' => false, 'message' => 'Masukkan konfirmasi pin keamanan telebih dahulu!.'];
        redirect(0, base_url('account/settings'));
        unset($_SESSION['csrf']);
    } else if (!$post_email) {
        $_SESSION['result'] = ['type' => false, 'message' => 'Formulir tidak boleh kosong.'];
        redirect(0, base_url('account/settings'));
        unset($_SESSION['csrf']);
    } else if ($call->query("SELECT * FROM users WHERE email = '$post_email'")->num_rows == 1) {
        $_SESSION['result'] = ['type' => false, 'message' => 'Email sudah terdaftar, gunakan email yang lain.'];
        redirect(0, base_url('account/settings'));
        unset($_SESSION['csrf']);
    } else {
        if (check_bcrypt($post_pin, $data_user['pin']) == true) {
            $call->query("UPDATE users SET email = '$post_email' WHERE username = '$sess_username'");
            $_SESSION['result'] = ['type' => true, 'message' => 'Email Berhasil Diubah.'];
            redirect(0, base_url('account/settings'));
            unset($_SESSION['csrf']);
        } else {
            $_SESSION['result'] = ['type' => false, 'message' => 'Pin keamanan tidak valid.'];
            redirect(0, base_url('account/settings'));
            unset($_SESSION['csrf']);
        }
    }
}if (isset($_POST['updatePIN'])) {
    $post_pin1 = filter($_POST['pin']);
    $post_pin2 = filter($_POST['newpin']);
    $post_pin3 = filter($_POST['cnewpin']);

    if ($result_csrf == false) {
        $_SESSION['result'] = ['type' => false, 'message' => 'System Error, please try again later.'];
        redirect(0, base_url('account/settings'));
        unset($_SESSION['csrf']);
    } else if ($sess_username == 'demo') {
        $_SESSION['result'] = ['type' => false, 'message' => 'Akun Demo Tidak Memiliki Izin Untuk Mengakses Fitur Ini.'];
        redirect(0, base_url('account/settings'));
        unset($_SESSION['csrf']);
    } else if (!$post_pin1 || !$post_pin2 || !$post_pin3) {
        $_SESSION['result'] = ['type' => false, 'message' => 'Masih Ada Formulir Kosong.'];
        redirect(0, base_url('account/settings'));
        unset($_SESSION['csrf']);
    } else if (check_bcrypt($post_pin1, $data_user['pin']) == false) {
        $_SESSION['result'] = ['type' => false, 'message' => 'PIN Keamanan Lama Anda Salah.'];
        redirect(0, base_url('account/settings'));
        unset($_SESSION['csrf']);
    } else if (is_numeric($post_pin2) == FALSE || is_numeric($post_pin3) == FALSE) {
        $_SESSION['result'] = ['type' => false, 'message' => 'Pin Keamanan Hanya Boleh Diisi Angka'];
        redirect(0, base_url('account/settings'));
        unset($_SESSION['csrf']);
    } else if (strlen($post_pin2) < 6 || strlen($post_pin3) < 6) {
        $_SESSION['result'] = ['type' => false, 'message' => 'Pin Keamanan Tidak Boleh Kurang Dari 6'];
        redirect(0, base_url('account/settings'));
        unset($_SESSION['csrf']);
    } else if (strlen($post_pin2) > 6 || strlen($post_pin3) > 6) {
        $_SESSION['result'] = ['type' => false, 'message' => 'Pin Keamanan Tidak Boleh Lebih Dari 6'];
        redirect(0, base_url('account/settings'));
        unset($_SESSION['csrf']);
    } else if ($post_pin2 <> $post_pin3) {
        $_SESSION['result'] = ['type' => false, 'message' => 'PIN Keamanan Baru Tidak Sesuai.'];
        redirect(0, base_url('account/settings'));
        unset($_SESSION['csrf']);
    } else {
        $in = $call->query("UPDATE users SET pin = '" . bcrypt($post_pin2) . "' WHERE username = '$sess_username'");
        if ($in == true) {
            $_SESSION['result'] = ['type' => true, 'message' => 'PIN Keamanan Berhasil Diubah.'];
            redirect(0, base_url('account/settings'));
            unset($_SESSION['csrf']);
        } else {
            $_SESSION['result'] = ['type' => false, 'message' => 'Our server is in trouble, please try again later.'];
            redirect(0, base_url('account/settings'));
            unset($_SESSION['csrf']);
        }
    }
}

require _DIR_('library/header/user');
?>
<style>
    .form-group .clear-input {
        padding-right:16px !important;
        padding-top:6px !important;
    }
</style>

<?php if ($_GET['q'] === 'user'): ?>
    <style>
        form {
            padding:24px;
        }
        .form-group.basic {
            padding:0px;
        }
        .label.label {
            font-size:15px;
        }
    </style>
    <!-- App Capsule -->
    <div id="appCapsule" class="information">
        <div class="section full">
            <img src="<?= assets('/library/assets/images/background/texture-orange-full-mosque.jpg'); ?>" alt="RGS-Banner" class="imaged img-fluid square">
            <form method="POST" role="form" enctype="form-data">
                <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
                <div class="form-group basic">
                    <div class="input-wrapper">
                        <label class="label">Tambahkan Username</label>
                        <input type="text" class="form-control" value="<?= $data_user['username'] ?>" name="username" placeholder="Nama apa yang cocok untukmu?">
                        <i class="clear-input">
                            <ion-icon name="close-circle"></ion-icon>
                        </i>
                    </div>
                </div>
                <div class="mt-2 form-bottom-fixed">
                    <a href="#"data-toggle="modal" data-target="#openPINUsername" class="btn bg-primary rounded shadowed btn-block mt-1 mb-1">Submit</a>
                </div>
        </div>
    </div>
    <!-- * App Capsule -->
    <div class="modal fade action-sheet" id="openPINUsername" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="form" enctype="form-data">
            <div class="modal-content">
                <div class="modal-body">
                    <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
                    <div class="mt-2 form-bottom-fixed">
                        <div class="form-group col-lg-6">
                            <div class="input-wrapper">
                                <input type="password" class="form-control" placeholder="Masukkan PIN Keamanan Anda" name="pin" pattern="[0-9]*" inputmode="numeric" style="font-size:0.75rem;">
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                            </div>
                        </div>
                        <button class="btn bg-primary rounded shadowed btn-block mt-1 mb-1" type="submit" name="updateUser">Submit</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php elseif ($_GET['q'] === 'photo'): ?>
    <style>
        .imaged.w76 {
            width:76px!important;
            height:76px!important;
        }
    </style>
    <div id="appCapsule">
        <div class="section bg-white pt-2">
            <form method="POST" role="form" enctype="multipart/form-data">
                <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
                <div class="card">
                    <div class="card-body">
                        <? if( $data_user['status_photo'] == 'Yes' ): ?>
                        <center>
                            <div class="avatar" style="margin:40px 0px">
                                <img src="<?= assets('images/user/' . $data_user['photo'] . '') . '?' . time() ?>" alt="avatar" class="imaged w76 rounded">
                            </div>
                        </center>
                        <div class="mt-2 form-bottom-fixed">
                            <button class="btn bg-danger rounded shadowed btn-block mt-1 mb-1" type="submit" name="deletePhoto">Hapus profil</button>
                        </div>
                        <? else: ?>
                        <center>
                            <div class="avatar" style="margin:40px 0px">
                                <img src="<?= assets('images/user/default.png') . '?' . time() ?>" alt="avatar" class="imaged w76 rounded">
                            </div>
                        </center>
                        <div class="form-group basic col-lg-6">
                            <div class="input-wrapper" style="font-size:13px;">
                                <input type="file" class="form-control-file" name="photo" required hidden>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-2 form-bottom-fixed">
                    <button class="btn bg-primary rounded shadowed btn-block mt-1 mb-1" type="submit" name="updatePhoto">Submit</button>
                </div>
                <? endif ?>
            </form>
        </div>
    </div>
<?php elseif ($_GET['q'] === 'phone'): ?>
    <div id="appCapsule">
        <div class="section bg-white pt-2">
            <form method="POST">
                <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
                <div class="form-group col-lg-6">
                    <div class="input-wrapper">
                        <label class="label mb-1">Nomor HP</label>
                        <input type="number" class="form-control" value="<?= $data_user['phone'] ?>" name="phone" style="font-size:0.75rem;">
                        <i class="clear-input">
                            <ion-icon name="close-circle"></ion-icon>
                        </i>
                    </div>
                </div>
                <div class="form-group col-lg-6">
                    <div class="input-wrapper">
                        <label class="label mb-1">Konfirmasi PIN Keamanan</label>
                        <input type="password" class="form-control" placeholder="Masukkan PIN Keamanan Anda" name="pin" pattern="[0-9]*" inputmode="numeric" style="font-size:0.75rem;">
                        <i class="clear-input">
                            <ion-icon name="close-circle"></ion-icon>
                        </i>
                    </div>
                </div>
                <div class="mt-2 form-bottom-fixed">
                    <button class="btn bg-primary rounded shadowed btn-block mt-1 mb-1" type="submit" name="updatePhone">Submit</button>
                </div>
            </form>
        </div>
    </div>
<?php elseif ($_GET['q'] === 'email'): ?>
    <div id="appCapsule">
        <div class="section bg-white pt-2">
            <form method="POST">
                <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
                <div class="form-group col-lg-6">
                    <div class="input-wrapper">
                        <label class="label mb-1">Email</label>
                        <input type="email" class="form-control" value="<?= $data_user['email'] ?>" name="email" style="font-size:0.75rem;">
                        <i class="clear-input">
                            <ion-icon name="close-circle"></ion-icon>
                        </i>
                    </div>
                </div>
                <div class="form-group col-lg-6">
                    <div class="input-wrapper">
                        <label class="label mb-1">Konfirmasi PIN Keamanan</label>
                        <input type="password" class="form-control" placeholder="Masukkan PIN Keamanan Anda" name="pin" pattern="[0-9]*" inputmode="numeric" style="font-size:0.75rem;">
                        <i class="clear-input">
                            <ion-icon name="close-circle"></ion-icon>
                        </i>
                    </div>
                </div>
                <div class="mt-2 form-bottom-fixed">
                    <button class="btn bg-primary rounded shadowed btn-block mt-1 mb-1" type="submit" name="updateEmail">Submit</button>
                </div>
            </form>
        </div>
    </div>
<?php elseif ($_GET['q'] === 'pin'): ?>
    <div id="appCapsule">
        <div class="section bg-white pt-2">
            <form method="POST">
                <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
                <div class="form-group col-lg-6">
                    <div class="input-wrapper">
                        <label class="label mb-1">PIN Sekarang</label>
                        <input type="password" class="form-control" placeholder="Masukkan PIN Sekarang" name="pin" pattern="[0-9]*" inputmode="numeric" style="font-size:0.75rem;">
                        <i class="clear-input">
                            <ion-icon name="close-circle"></ion-icon>
                        </i>
                    </div>
                </div>
                <div class="form-group col-lg-6">
                    <div class="input-wrapper">
                        <label class="label mb-1">PIN Baru</label>
                        <input type="password" class="form-control" placeholder="Masukkan PIN Baru" name="newpin" pattern="[0-9]*" inputmode="numeric" style="font-size:0.75rem;">
                        <i class="clear-input">
                            <ion-icon name="close-circle"></ion-icon>
                        </i>
                    </div>
                </div>
                <div class="form-group col-lg-6">
                    <div class="input-wrapper">
                        <label class="label mb-1">Konfirmasi PIN Baru</label>
                        <input type="password" class="form-control" placeholder="Konfirmasi PIN Baru" name="cnewpin" pattern="[0-9]*" inputmode="numeric" style="font-size:0.75rem;">
                        <i class="clear-input">
                            <ion-icon name="close-circle"></ion-icon>
                        </i>
                    </div>
                </div>
                <div class="mt-2 form-bottom-fixed">
                    <button class="btn bg-primary rounded shadowed btn-block mt-1 mb-1" type="submit" name="updatePIN">Submit</button>
                </div>
            </form>
        </div>
    </div>
<?php else: ?>
    <style>
        .imaged.w40 {
            width:40px!important;
            height:40px!important;
        }
    </style>
    <div id="appCapsule">

        <? require _DIR_('library/session/result-mobile') ?>

        <div class="listview-title pb-0">Pengaturan Profil</div>
        <ul class="listview image-listview">
            <? if( $data_user['level'] == 'Basic' ): ?>
            <li class="profile-menu">
                <a href="<?= base_url('account/upgrade'); ?>" class="item">
                    <div class="in">
                        <div>Tipe Akun</div>
                        <div class="text-primary">
                            <?= $data_user['level'] ?>
                        </div>
                    </div>
                </a>
            </li>
            <? else: ?>
            <li class="profile-menu">
                <div class="item">
                    <div class="in">
                        <div>Tipe Akun</div>
                        <div class="text-primary">
                            <?= $data_user['level'] ?>
                        </div>
                    </div>
                </div>
            </li>
            <? endif ?>
            <li class="profile-menu">
                <a href="#" data-toggle="modal" data-target="#openMenuPhoto" class="item" style="padding:5px 36px 5px 16px;">
                    <div class="in">
                        <div>Ganti Gambar Profil</div>
                        <? if( $data_user['status_photo'] == 'Yes' ): ?>
                        <img src="<?= assets('images/user/' . $data_user['photo'] . '') . '?' . time() ?>" class="imaged w40 rounded">
                        <? else: ?>
                        <img src="<?= assets('images/user/default.jpg') . '?' . time() ?>" class="imaged w40 rounded">
                        <? endif ?>
                    </div>
                </a>
            </li>
            <?php
            $data_nama = $data_user['name'];
            $nama = strtoupper($data_nama);
            ?>
            <? if( $data_user['level'] == 'Basic' ): ?>
            <li class="profile-menu">
                <div class="item">
                    <div class="in">
                        <div>Nama</div>
                        <div style="color:#909090;">
                            <?= $nama ?>
                        </div>
                    </div>
                </div>
            </li>
            <? else: ?>
            <li class="profile-menu">
                <div class="item">
                    <div class="in">
                        <div>Nama Asli</div>
                        <div style="color:#909090;">
                            <?= $nama ?>
                        </div>
                    </div>
                </div>
            </li>
            <? endif ?>
            <li class="profile-menu">
                <a href="<?= base_url('account/settings?q=user'); ?>" class="item">
                    <div class="in">
                        <div>Username</div>
                        <div class="text-primary">
                            <?= $data_user['username'] ?>
                        </div>
                    </div>
                </a>
            </li>
        </ul>
        <div class="listview-title pb-0">Pengaturan Keamanan</div>
        <ul class="listview image-listview">
            <li class="profile-menu">
                <a href="<?= base_url('account/settings?q=phone'); ?>" class="item">
                    <div class="in">
                        <div>Ubah Nomor Ponsel</div>
                        <div class="text-primary">
                            <?= explode(substr($data_user['phone'], '2'), $data_user['phone'])['0'] . ' &bull;&bull;&bull; ' . explode(substr($data_user['phone'], '2'), $data_user['phone'])['1'] ?>
                            <?php
                            $phone = $data_user['phone'];
                            echo substr($phone, -4);
                            ?>
                        </div>
                    </div>
                </a>
            </li>
            <li class="profile-menu">
                <a href="<?= base_url('account/settings?q=email'); ?>" class="item">
                    <div class="in">
                        <div>Alamat Email</div>
                        <div class="text-primary">
                            <?= explode(substr($data_user['email'], '1'), $data_user['email'])['0'] . ' &bull;&bull;&bull; ' . explode(substr($data_user['email'], '1'), $data_user['email'])['1'] ?>
                            <?php
                            $email = $data_user['email'];
                            preg_match('/(\S+)(@(\S+))/', $email, $match);
                            echo $match[2];
                            ?>
                        </div>
                    </div>
                </a>
            </li>
            <li class="profile-menu">
                <a href="<?= base_url('account/settings?q=pin'); ?>" class="item">
                    <div class="in">
                        <div>Ganti PIN</div>
                    </div>
                </a>
            </li>
        </ul>
    </div>
    <!-- * App Capsule -->
    <style>
        .form-group .input-wrapper {
            position: relative;
            padding: 0px 24px 80px;
        }
    </style>
    <div class="modal fade action-sheet" id="openMenuPhoto" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <form method="POST" role="form" enctype="multipart/form-data">
                        <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
                        <div class="mt-2 form-bottom-fixed">
                            <? if( $data_user['status_photo'] == 'Yes' ): ?>
                            <button class="btn bg-danger rounded shadowed btn-block mt-1 mb-1" type="submit" name="deletePhoto">Delete Profil</button>
                            <? else: ?>
                            <div class="input-wrapper">
                                <input type="file" id="actual-btn" class="form-control-file" name="photo" required hidden>
                                <!-- name of file chosen -->
                                <span id="file-chosen"></span>
                                <!-- our custom upload button -->
                                <label class="btn bg-primary rounded shadowed btn-block mt-1 mb-1" for="actual-btn"> Upload File <span id="file-chosen"></span></label>
                            </div>
                            <button class="btn bg-primary rounded shadowed btn-block mt-1 mb-1" type="submit" name="updatePhoto">Submit</button>
                            <? endif ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php require _DIR_('library/footer/user') ?>