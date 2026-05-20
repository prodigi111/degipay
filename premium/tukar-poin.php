<?php
require '../RGShenn.php';
require _DIR_('library/session/user');
$page = 'Tukar Poin';
$rewards = $call->query("SELECT * FROM modules_point_rewards WHERE available = '1' ORDER by point ASC");
$history = $call->query("SELECT * FROM modules_point_rewards_data WHERE user_id = '".$data_user['id']."' ORDER by id DESC");
require _DIR_('library/header/user');
if(isset($_POST['exchangeBalance'])) {
    $rid = filter($_POST['rid']);
    $pin = filter($_POST['pin']);
    $uid = $data_user['id'];
    $jumlah = filter($_POST['jumlah']);

    $rewardss = $call->query("SELECT * FROM modules_point_rewards WHERE available = '1' AND id = '$rid' ORDER by point ASC");
    if($rewardss->num_rows > 0) {
        $data_rewards = $rewardss->fetch_assoc();
        $point_decrase = $data_rewards['point'];
        $get_reward =  $data_rewards['getsaldo'];
        $stock = $data_rewards['stock'];
        $sisa = $stock-$jumlah;
    }
    if($result_csrf == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'System Error, please try again later.'];
    } else if(!$rid) {
        $_SESSION['result'] = ['type' => false, 'message' => 'Terjadi kesalahan, hubungi admin segera'];
    } else if(!password_verify($pin, $data_user['pin'])) {
        $_SESSION['result'] = ['type' => false, 'message' => 'Pin salah'];
    } else if($rewardss->num_rows == 0) {
        $_SESSION['result'] = ['type' => false, 'message' => 'Hadiah dengan id tersebut tidak ada'];
    } else if($stock < $jumlah) {
        $_SESSION['result'] = ['type' => false, 'message' => 'Mohon maaf stock habis.'];
    } else if($sess_username == 'demo') {
        $_SESSION['result'] = ['type' => false,'message' => 'Akun Demo Tidak Memiliki Izin Untuk Mengakses Fitur Ini.'];
    } else if($data_user['point'] <= $data_rewards['point']) {
        $_SESSION['result'] = ['type' => false,'message' => 'Point tidak cukup!'];
    } else {
        if($call->query("INSERT INTO modules_point_rewards_data (user_id, reward_id, point_decrase, status) VALUES ('$uid', '$rid', '$point_decrase', 'Success')") == true) {
            $call->query("UPDATE modules_point_rewards SET stock = stock-$jumlah WHERE id = '$rid'");
            $call->query("UPDATE users SET point = point-$point_decrase WHERE id = '$uid'");
            $call->query("UPDATE users SET balance = balance+$get_reward WHERE id = '$uid'");
            $call->query("INSERT INTO mutation VALUES ('', '$sess_username', '+', '$get_reward', 'Exchange Rewards', '$date', '$time', 'Lainnya')");
            $fcm_token = $call->query("SELECT * FROM users_token WHERE user = '$sess_username'")->fetch_assoc()['token'];
            $WATL->sendMessage($data_user['phone'], "Hallo, *{$data_user['name']}*\nKamu sudah menukarkan pointmu dengan {$data_rewards['name']}, Terima kasih sudah ikut bergabung dalam event ini");
            $notification = [
                'title' => 'Yeey Berhasil.',
                'text' => 'Kamu sudah menukarkan poinmu dengan '.$data_rewards['name'],
                'click_action' =>  'Open_URI',
            ];
            $data = [
                'picture' => '',
                'uri' =>  base_url('premium/tukar-poin'),
            ];
            $FCM->sendNotif($fcm_token, $notification, $data);
            $_SESSION['result'] = ['type' => true,'message' => 'Berhasil, kamu sudah menukarkan poinmu dengan '.$data_rewards['name'].    '.'];
            
        } else {
            $_SESSION['result'] = ['type' => false,'message' => 'System Error, please try again later.'];
        }
    }
} else if(isset($_POST['exchangePhysical'])) {
    $rid = filter($_POST['rid']);
    $name = filter($_POST['name']);
    $pin = filter($_POST['pin']);
    $phone = filter($_POST['phone']);
    $jumlah = filter($_POST['jumlah']);
    $address = filter($_POST['address']);

    $physical_address = json_encode([
        "name" => $name,
        "phone" => $phone,
        "address" => $address,
    ]);

    $uid = $data_user['id'];
    $rewardss = $call->query("SELECT * FROM modules_point_rewards WHERE available = '1' AND id = '$rid' ORDER by point ASC");
    if($rewardss->num_rows > 0) {
        $data_rewards = $rewardss->fetch_assoc();
        $point_decrase = $data_rewards['point'];
        $stock = $data_rewards['stock'];
        $sisa = $stock-$jumlah;
    }
    if($result_csrf == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'System Error, please try again later.'];
    } else if(!$rid || !$name || !$phone || !$address || !$pin) {
        $_SESSION['result'] = ['type' => false, 'message' => 'Isi Semua Form'];
    } else if(!password_verify($pin, $data_user['pin'])) {
        $_SESSION['result'] = ['type' => false, 'message' => 'Pin salah'];
    } else if($rewardss->num_rows == 0) {
        $_SESSION['result'] = ['type' => false, 'message' => 'Hadiah tersebut tidak ada'];
    } else if($stock < $jumlah) {
        $_SESSION['result'] = ['type' => false, 'message' => 'Mohon maaf stock habis.'];
    } else if($sess_username == 'demo') {
        $_SESSION['result'] = ['type' => false,'message' => 'Akun Demo Tidak Memiliki Izin Untuk Mengakses Fitur Ini.'];
    } else if($data_user['point'] <= $data_rewards['point']) {
        $_SESSION['result'] = ['type' => false,'message' => 'Point tidak cukup!'];
    } else {
        if($call->query("INSERT INTO modules_point_rewards_data (user_id, reward_id, point_decrase, physical_address, status) VALUES ('$uid', '$rid', '$point_decrase', '$physical_address', 'Make a Request')") == true) {
            $call->query("UPDATE users SET point = point-$point_decrase WHERE id = '$uid'");
            $fcm_token = $call->query("SELECT * FROM users_token WHERE user = '$sess_username'")->fetch_assoc()['token'];
            $WATL->sendMessage($data_user['phone'], "Hallo, *{$data_user['name']}*\nKamu sudah menukarkan pointmu dengan {$data_rewards['name']}.\nBerikut data pengirimianmu:\n\n*Nama: {$name}*\n*No. Telepon: {$phone}*\n*Alamat: {$address}*\n\nKami akan mengirimkan hadiah tersebut berdasarkan data diatas, jika terdapat data yang salah, segera hubungi admin.\n\nTerima kasih sudah ikut bergabung dalam event ini.");
            $notification = [
                'title' => 'Yeey Berhasil.',
                'text' => 'Kamu sudah menukarkan poinmu dengan '.$data_rewards['name'],
                'click_action' =>  'Open_URI',
            ];
            $data = [
                'picture' => '',
                'uri' =>  base_url('premium/tukar-poin'),
            ];
            $FCM->sendNotif($fcm_token, $notification, $data);
            $_SESSION['result'] = ['type' => true,'message' => 'Berhasil, kamu sudah menukarkan poinmu dengan '.$data_rewards['name'].    '.'];
            
        } else {
            $_SESSION['result'] = ['type' => false,'message' => 'System Error, please try again later.'];
        }
    }
}
?>
<style>
    .image-listview.rewards > li a.item::after {
        content: none;
    }
</style>

    <!-- App Capsule -->
    <div id="appCapsule" class="extra-header-active rgs-referral">
        <div class="section full bg-white">
        <div class="section full text-center pb-2 pt-2">
            <h4 class="text-green">Poin Saat Ini</h4>
            <h1 class="text-green"><?= currency($data_user['point']) ?></h1>
            <p class="text-green">Segera Tukarkan Poin Mu Dan Dapatkan Keuntungannya</p>
        </div>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="rewards" role="tabpanel">
                    <?php if($rewards->num_rows > 0): ?>
                    <ul class="listview image-listview rewards media mb-2">
                        <?php while($data_rewards = $rewards->fetch_assoc()): ?>
                        <li>
                            <div class="item pr-2">
                                <div class="imageWrapper">
                                    <img src="<?= assets('images/rewards-icon/'.$data_rewards['photo']); ?>" alt="image" class="imaged w64">
                                </div>
                                <div class="in" style="width: 74%;">
                                    <div style="width: 75%;">
                                        <div style="font-weight: 500; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><?= $data_rewards['name']; ?></div>
                                        <div class="text-danger" style="font-weight: 500; font-size: 12px;">Stok <?= ($data_rewards['stock']) ? $data_rewards['stock'] : 'Habis'; ?></div>
                                        <div class="text-warning" style="font-weight: 500; font-size: 12px;"><?= currency($data_rewards['point']) ?> Poin</div>
                                    </div>
                                    <?php if($data_user['point'] >= $data_rewards['point']): ?>
                                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#rewardsID<?= $data_rewards['id']; ?>" style="height: 24px; padding: 0px 9px;">Tukar</button>
                                    <?php else: ?>
                                    <button class="btn btn-primary btn-sm" disabled style="height: 24px; padding: 0px 9px;">Tukar</button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </li>
                        <?php if($data_user['point'] >= $data_rewards['point']): ?>
                        <div class="modal fade action-sheet" id="rewardsID<?= $data_rewards['id']; ?>" tabindex="-1" style="display: none;" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header d-flex justify-content-between align-items-center">
                                        <h5 class="modal-title">Tukar Poin - <?= $data_rewards['name']; ?></h5>
                                        <a href="javascript:;" data-dismiss="modal"><h5 class="modal-title">Batal</h5></a>
                                    </div>
                                    <div class="modal-body">
                                        <div class="action-sheet-content pt-1">
                                            <form method="POST">
                                                <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
                                                <input type="hidden" name="rid" id="rid" value="<?= $data_rewards['id']; ?>">
                                                <?php if($data_rewards['type'] !== 'Saldo'): ?>
                                                <div class="form-group basic">
                                                    <div class="input-wrapper">
                                                        <label class="form-label" for="name">Nama Lengkap</label>
                                                        <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan Nama Lengkap" required>
                                                        <i class="clear-input">
                                                            <ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon>
                                                        </i>
                                                    </div>
                                                </div>
                                                <div class="form-group basic">
                                                    <div class="input-wrapper">
                                                        <label class="form-label" for="phone">No. Telepon</label>
                                                        <input type="text" class="form-control" id="phone" name="phone" placeholder="Masukkan No. Telepon" required>
                                                        <i class="clear-input">
                                                            <ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon>
                                                        </i>
                                                    </div>
                                                </div>
                                                <div class="form-group basic">
                                                    <div class="input-wrapper">
                                                        <label class="form-label" for="address">Alamat Lengkap</label>
                                                        <textarea id="address" name="address" rows="2" class="form-control" required></textarea>
                                                        <i class="clear-input">
                                                            <ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon>
                                                        </i>
                                                    </div>
                                                    <div class="input-info">Pastikan alamat yang kamu masukan sudah benar.</div>
                                                </div>
                                                <?php endif; ?>
                                                <!--
                                                <div class="form-group basic">
                                                    <div class="input-wrapper">
                                                        <label class="form-label" for="jumlah">Jumlah</label>
                                                        <input type="number" class="form-control" name="jumlah" placeholder="Jumlah Penukaran" required>
                                                        <i class="clear-input">
                                                            <ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon>
                                                        </i>
                                                    </div>
                                                </div>
                                                -->
                                                <div class="form-group basic">
                                                    <div class="input-wrapper">
                                                        <label class="form-label" for="pin">PIN</label>
                                                        <input type="password" class="form-control" id="pin" maxlength="6" name="pin" pattern="[0-9]*" inputmode="numeric" autocomplete="off" placeholder="Masukkan PIN Kamu" required>
                                                        <i class="clear-input">
                                                            <ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon>
                                                        </i>
                                                    </div>
                                                </div>
                                                <div class="form-group basic">
                                                    <button type="submit" class="btn btn-primary btn-block" <?= ($data_rewards['type'] === 'Saldo') ? 'name="exchangeBalance"' : 'name="exchangePhysical"' ; ?>>Tukarkan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php endwhile; ?>
                    </ul>
                    <?php else: ?>
                    <div class="listview-title mt-5 pt-5" style="justify-content: center !important;">Tidak ada Hadiah</div>
                    <?php endif; ?>
                </div>
                <div class="tab-pane fade" id="history" role="tabpanel">
                    <?php if($history->num_rows > 0): ?>
                    <ul class="listview image-listview media mb-2">
                        <?php while($data_history = $history->fetch_assoc()): ?>
                        <?php
                        $data_rewards = $call->query("SELECT * FROM modules_point_rewards WHERE id = '".$data_history['reward_id']."'")->fetch_assoc();
                       $get_reward = (strpos('Saldo', $data_rewards['name']) !== 'false') ? str_replace(['Saldo ', 'saldo ', 'k', 'K', '.'], ['', '', '000', '000', ''], $data_rewards['name']) : '';
                        if($data_history['status'] === 'Make a Request') {
                            $status = 'Mengajukan Permintaan';
                            $color = 'warning';
                        } else if($data_history['status'] === 'Request Accepted') {
                            $status = 'Permintaan Diterima';
                            $color = 'info';
                        } else if($data_history['status'] === 'Processing') {
                            $status = 'Sedang Di Proses';
                            $color = 'primary';
                        } else if($data_history['status'] === 'Success') {
                            $status = 'Berhasil';
                            $color = 'success';
                        } else if($data_history['status'] === 'Failed') {
                            $status = 'Permintaan Ditolak';
                            $color = 'danger';
                        } else {
                            $status = 'Tidak Diketahui';
                            $color = 'secondary';
                        }
                        $data_target = json_decode($data_history['physical_address']);
                        ?> 
                        <li>
                            <a class="item pr-2" <?php if(isset($data_history['physical_address'])): ?> data-toggle="modal" data-target="#historyID<?= $data_history['id']; ?>" <?php endif; ?>>
                                <div class="imageWrapper">
                                    <img src="<?= assets('images/rewards-icon/'.$data_rewards['photo']); ?>" alt="image" class="imaged w64">
                                </div>
                                <div class="in" style="width: 74%;">
                                    <div style="width: 75%;">
                                        <header class="text-<?= $color; ?>"><?= $status; ?></header>
                                        <div style="font-weight: 500; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><?= $data_rewards['name']; ?></div>
                                        <footer class="text-warning" style="font-weight: 500; font-size: 12px;">- <?= currency($data_rewards['point']) ?> Poin</footer>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <?php if(isset($data_history['physical_address'])): ?>
                        <div class="modal fade modalbox" id="historyID<?= $data_history['id']; ?>" data-backdrop="static" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">History #<?= $data_history['id']; ?></h5>
                                        <a href="javascript:;" data-dismiss="modal">Tutup</a>
                                    </div>
                                    <div class="modal-body p-0">
                                        <div class="section full">
                                            <div class="invoice m-0 pt-2" style="box-shadow: none; border: 0">
                                                <div class="invoice-page-header justify-content-center">
                                                    <div class="text-center">
                                                        <div style="font-size: 13px; font-weight: 600;">Hadiah <?= $data_rewards['name']; ?></div>
                                                        <div class="invoice-id">#HISTORY<?= $data_history['id']; ?></div>
                                                    </div>
                                                </div>
                                                <div class="text-center" style="padding-top: 2rem;">
                                                    <img src="<?= assets('images/rewards-icon/'.$data_rewards['photo']); ?>" alt="Rewards Photo" style="max-height: 150px; border-radius: 6px">
                                                </div>
                                                <div class="invoice-person" style="padding-top: 3rem">
                                                    <div class="invoice-to">
                                                        <h4>Alamat Penerima</h4>
                                                        <p><?= $data_target->name; ?></p>
                                                        <p><?= $data_target->phone; ?></p>
                                                        <p><?= $data_target->address; ?></p>
                                                    </div>
                                                    <div class="invoice-from">
                                                        <h4>No. Resi</h4>
                                                        <p><?= (isset($data_history['physical_receipt'])) ? $data_history['physical_receipt'] : 'Tidak ada'; ?></p>
                                                    </div>
                                                </div>

                                                <div class="invoice-total" style="position: fixed; bottom: 0; left: 0; right: 0; padding: 16px;">
                                                    <ul class="listview transparent simple-listview">
                                                        <li>Point <span class="hightext">-<?= currency($data_history['point_decrase']); ?></span></li>
                                                        <li>Saldo<span class="hightext">0</span></li>
                                                        <li>Status<span class="totaltext text-<?= $color; ?>"><?= $status; ?></span></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php endwhile; ?>
                    </ul>
                    <?php else: ?>
                    <div class="listview-title mt-5 pt-5" style="justify-content: center !important;">Tidak ada Hadiah</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php if(isset($_SESSION['result'])): 
            $type = strtolower($_SESSION['result']['type']);
        ?>
    <div class="modal fade dialogbox" id="errorBruh" data-backdrop="static" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-icon text-<?= ($type == true) ? 'success' : 'danger' ?>">
                    <ion-icon name="<?= ($type == true) ? 'checkmark' : 'close' ?>-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon>
                </div>
                <div class="modal-header">
                    <h5 class="modal-title"><?= ($type == true) ? 'Success' : 'Error' ?></h5>
                </div>
                <div class="modal-body">
                    <?= $_SESSION['result']['message']; ?>
                </div>
                <div class="modal-footer">
                    <div class="btn-inline">
                        <a href="#" class="btn" data-dismiss="modal">TUTUP</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $('#errorBruh').modal('show');
    </script>
    <?php 
    unset($_SESSION['result']);
    endif;
    ?>
    <!-- * App Capsule -->

<?php require _DIR_('library/footer/user') ?>