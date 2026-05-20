<?php
require '../../RGShenn.php';
require _DIR_('library/session/user');
$page = 'Tournament Game';

if(!isset($_GET['id'])) {
    redirect(0,base_url('page/event.php'));
} else {
    $post_kode = filter($_GET['id']);

    $search = $call->query("SELECT * FROM events WHERE target = '$post_kode'")->fetch_assoc();
    $expired = $search['expired_at'];
    if($expired <= $date) redirect(0,base_url('page/event.php'));

    $search = $call->query("SELECT * FROM events_tournament_game WHERE id = '$post_kode'");
    if($search->num_rows == 0) redirect(0,base_url('page/event.php'));
    $data = $search->fetch_assoc();

    $search = $call->query("SELECT * FROM events_tournament_game_registered WHERE tg_id = '$post_kode'");
    $team_player_registered = (!empty($search->num_rows)) ? $search->num_rows : 0;
    $team_player_slot_available = $data['max_team_player'] - $team_player_registered;
    $percentase_team_player = $team_player_registered / $data['max_team_player'] * 100;
    $registration_fee = ($data['registration_fee'] != 0) ? currency($data['registration_fee']).' Saldo' : 'Gratis';
    $is_registered = $call->query("SELECT * FROM events_tournament_game_registered WHERE user_id = '".$data_user['id']."' AND tg_id = '$post_kode'");

    if(isset($_POST['accept_invite'])) {
        $name = filter($_POST['name']);
        $nohp = filter($_POST['nohp']);

        if($data_user['username'] == 'demo') {
            $_SESSION['result'] = ['type' => false,'message' => 'Akun Demo Tidak Memiliki Izin Untuk Mengakses Fitur Ini.'];
        } else if($data_user['status'] == 'locked') {
            $_SESSION['result'] = ['type' => false,'message' =>'Transaksi di Bekukan Silahkan Hubungi Admin.'];
        } else if(!$name || !$nohp) {
            $_SESSION['result'] = ['type' => false,'message' => 'Masih Ada Formulir Kosong.'];
        } else if($data_user['balance'] < $data['registration_fee']) {
            $_SESSION['result'] = ['type' => false,'message' => 'Saldo tidak cukup.'];
        } else if($call->query("SELECT * FROM events_tournament_game_registered WHERE user_id = '".$data_user['id']."' AND tg_id = '$post_kode'")->num_rows > 0) {
            $_SESSION['result'] = ['type' => false,'message' => 'Kamu sudah terdaftar di Acara ini'];
        } else {
            if($call->query("INSERT INTO events_tournament_game_registered (tg_id, user_id, name_team_player, contact_team_player) VALUES ('$post_kode', '".$data_user['id']."', '$name', '$nohp')") == true) {

                $price = $data['registration_fee'];
                $call->query("UPDATE users SET balance = balance-".$data['registration_fee']." WHERE username = '$sess_username'");
                $call->query("INSERT INTO mutation VALUES ('', '$sess_username', '-', '".$data['registration_fee']."', 'Register Tournament Game ".$data['name']."', '$date', '$time', 'Lainnya')");
                $fcm_token = $call->query("SELECT * FROM users_token WHERE user = '$sess_username'")->fetch_assoc()['token'];
                /*$WATL->sendMessage(conf, "Data Tourney *{$data['name']}*
---------------------
Nama : *$name*
Whatsapp : *$nohp*");
                */
                $WATL->sendMessage($nohp, "Hallo, *{$data_user['name']}*\nTerima kasih sudah bergabung di Tournament Game *{$data['name']}*, kami akan segera menghubungi kamu melalui No. Telepon yang terdaftar");
                $notification = [
                    'title' => 'Pantau Terus!!!',
                    'text' => 'Wah, kamu sudah terdaftar di Tournament Game '.$data['name'],
                    'click_action' =>  'Open_URI',
                ];
                
                $data = [
                    'picture' => '',
                    'uri' =>  base_url('page/event/tournament-game?id='.$post_kode),
                ];
                $FCM->sendNotif($fcm_token, $notification, $data);
                $_SESSION['success'] = ['type' => true, 'price' => $price];
                redirect(0,base_url($_SERVER['REQUEST_URI']));
            } else {
                $_SESSION['result'] = ['type' => false,'message' => 'An error has occurred in the database system, please contact the admin.'];
            }
        }
    }
require _DIR_('library/header/user');
?>

    <!-- App Capsule -->
    <style>
        .total-player {
            position: relative;
            bottom: 50px;
        }
        .total-player .progress {
            height: 9px;
        }
        .total-player .in {
            font-weight: 600;
            font-size: 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .total-player .slot-available {
            font-size: 12px;
            font-weight: 600;
            text-align: center;
        }
        .information .fab-button .fab {
            height: 38px;
            font-size: 15px;
            font-weight: 600;
        }
        .misc-info {
            position: relative;
            bottom: 60px;
        }
        .misc-info .label {
            font-size: 14px;
            font-weight: 700;
        }
        .misc-info .list {
            font-size: 13px;
            line-height: 0;
            padding-top: 8px;
            font-weight: 500;
        }
        .in {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .description {
            position: relative;
            bottom: 60px !important;
            border-top: 1px solid #e1e1e1;
            width: 90%;
            left: 16px;
            padding-bottom: 100px !important;
        }
        .description .title {
            text-align: center;
            font-size: 15px;
            font-weight: 700;
        }
    </style>
    <div id="appCapsule" class="information pb-0">
        <div class="section full bg-white">
            <img src="<?= assets('images/events/'.$data['banner']); ?>" alt="RGS-Banner" class="imaged img-fluid square" style="max-height: 145px;">
            <div class="card">
                <div class="card-body">
                    <div class="card-title text-center">Tournament Game <?= $data['name'] ?></div>
                    <div class="in">
                        <div>Game Started</div>
                        <div><?= format_date('id',$data['started_at']) ?> - <?= format_date('id',$data['finished_at']) ?></div>
                    </div>
                </div>
            </div>
            <? if(isset($_SESSION['success'])) :  ?>
                <div class="modal fade dialogbox" id="successResult" data-backdrop="static" tabindex="-1" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-icon text-success">
                                <ion-icon name="checkmark-circle" role="img" class="md hydrated" aria-label="checkmark circle"></ion-icon>
                            </div>
                            <div class="modal-header">
                                <h5 class="modal-title">Berhasil</h5>
                            </div>
                            <div class="modal-body">
                                Terima kasih sudah ikut meramaikan acara ini. Kami akan mencoba menghubungimu segera.
                            </div>
                            <div class="modal-footer">
                                <div class="btn-inline">
                                    <a href="#" class="btn" data-dismiss="modal">CLOSE</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <? unset($_SESSION['success']); endif; ?>
            <? if(isset($_SESSION['result'])) :  ?>
                <div class="modal fade dialogbox" id="errorResult" data-backdrop="static" tabindex="-1" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-icon text-danger">
                                <ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon>
                            </div>
                            <div class="modal-header">
                                <h5 class="modal-title">Error</h5>
                            </div>
                            <div class="modal-body">
                                <?= $_SESSION['result']['message']; ?>
                            </div>
                            <div class="modal-footer">
                                <div class="btn-inline">
                                    <a href="#" class="btn" data-dismiss="modal">CLOSE</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <? unset($_SESSION['result']); endif; ?>
            <div class="total-player p-2">
                <div class="in">
                    <div>Maks. <?= $data['mode'] === 'Team' ? 'Team' : 'Player'; ?></div>
                    <div><?= $data['max_team_player']; ?></div>
                </div>
                <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: <?= $percentase_team_player; ?>%;" aria-valuenow="$team_player_registered" aria-valuemin="0" aria-valuemax="<?= $data['max_team_player']; ?>"></div> 
                </div>
                <?php if($team_player_slot_available == 0): ?>
                <div class="slot-available text-muted">Slot Sudah Penuh</div>
                <?php else: ?>
                <div class="slot-available">Slot Tersisa <?= $team_player_slot_available; ?></div>
                <?php endif; ?>
            </div>
            <div class="misc-info p-2 mb-1">
                <div class="label">Informasi Tambahan:</div>
                <div class="list">
                    <div class="in pb-1 mb-1">
                        <div >Mode: </div>
                        <div ><?= $data['mode']; ?></div>
                    </div>
                    <div class="in">
                        <div >Biaya Registrasi: </div>
                        <div ><?= $registration_fee; ?></div>
                    </div>
                </div>
            </div>
            <div class="description p-0 pt-2 pb-2">
                <div class="title">Deskripsi</div>
                <div class="content">
                    <?= nl2br($data['description']); ?>
                </div>
            </div>
        </div>
        <?php if($team_player_slot_available == 0): ?>
        <div class="fab-button text bottom-center">
            <a href="#" class="fab bg-secondary">
                Slot Penuh
            </a>
        </div>
        <?php elseif($is_registered->num_rows > 0): ?>
        <div class="fab-button text bottom-center">
            <a href="#" class="fab bg-success">
                Sudah Terdaftar
            </a>
        </div>
        <?php else: ?>
        <div class="fab-button text bottom-center">
            <a href="#" class="fab" data-toggle="modal" data-target="#accept">
                Ikuti Tournament
            </a>
        </div>
        <form method="POST">
            <div class="modal fade action-sheet" id="accept" tabindex="-1" style="display: none;" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Ayo Ikut Tournament</h5>
                        </div>
                        <div class="modal-body">
                            <div class="action-sheet-content">
                                <input type="hidden" value="<?= $post_kode; ?>" name="id">
                                <div class="form-group basic">
                                    <div class="input-wrapper">
                                        <label class="label" for="name"><?= ($data['mode'] === 'Team') ? 'Nama Team' : 'Nama Kamu'; ?></label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="<?= ($data['mode'] === 'Team') ? 'Masukkan Nama Team' : 'Masukkan Nama kamu'; ?>" required>
                                        <i class="clear-input">
                                            <ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon>
                                        </i>
                                    </div>
                                    <div class="input-info">Masukkan nama <?= ($data['mode'] === 'Team') ? 'team kamu' : 'kamu (Nama Asli)'; ?></div>
                                </div>
                                <div class="form-group basic">
                                    <div class="input-wrapper">
                                        <label class="label" for="nohp">No. Telepon</label>
                                        <input type="telp" class="form-control" id="nohp" name="nohp" placeholder="Masukkan No. Telepon Kamu" required="">
                                        <i class="clear-input">
                                            <ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon>
                                        </i>
                                    </div>
                                    <div class="input-info" style="line-height: 14px; padding-top: 6px;">Masukkan No. Telepon Whatsapp kamu, agar kami bisa menghubungi kamu segera.</div>
                                </div>
                                <div class="form-group basic">
                                    <button type="submit" id="next-step" class="btn btn-primary btn-block" data-toggle="modal" data-target="#alertpay" data-dismiss="modal" disabled>Daftar Sekarang</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade dialogbox" id="alertpay" data-backdrop="static" tabindex="-1" style="display: none;" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-icon text-primary">
                            <ion-icon name="wallet" role="img" class="md hydrated" aria-label="checkmark circle"></ion-icon>
                        </div>
                        <div class="modal-header">
                            <h5 class="modal-title">Konfirmasi</h5>
                        </div>
                        <div class="modal-body">
                            Jika melanjutkan saldo kamu akan terpotong sebesar <?= $registration_fee; ?>.
                        </div>
                        <div class="modal-footer">
                            <div class="btn-inline">
                                <button type="button" class="btn btn-text-secondary" data-dismiss="modal">TUTUP</button>
                                <button type="submit" class="btn btn-text-primary" name="accept_invite">LANJUT</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <?php endif; ?>
    </div>
    <!-- * App Capsule -->

<?php require _DIR_('library/footer/user'); } ?>