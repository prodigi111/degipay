<?php
require '../../../connect.php';
require _DIR_('library/session/session');

$get_id = isset($_GET['id']) ? filter($_GET['id']) : '';
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    if(!$_SESSION['user']) exit('No direct script access allowed!');
    if($data_user['level'] !== 'Admin') exit('No direct script access allowed!');
    $data_game = $call->query("SELECT * FROM events_tournament_game WHERE id = '$get_id'")->fetch_assoc();
    ?>
<form method="POST" role="form" enctype="multipart/form-data">
    <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
    <input type="hidden" id="id" name="id" value="<?= $get_id ?>">
    <div class="form-group">
        <label>Name</label>
        <input type="text" class="form-control" name="name" value="<?= $data_game['name']; ?>">
    </div>
    <div class="form-group">
        <label>Description</label>
        <textarea name="description" class="form-control" rows="6"><?= $data_game['description']; ?></textarea>
    </div>
    <div class="form-group">
        <label>Min/Max Player/Team</label>
        <input type="text" class="form-control" name="min_max" value="<?= $data_game['min_team_player']; ?>-<?= $data_game['max_team_player']; ?>">
        <span class="text-danger">Misal. 1-50, artinya Min. 1 sampai Maks. 50 Player/team</span>
    </div>
    <div class="form-group">
        <label>Mode</label>
        <select class="form-control" name="mode">
            <option value="">- Pilih Salah satu -</option>
            <?= select_opt($data_game['mode'], 'Solo', 'Solo'); ?>
            <?= select_opt($data_game['mode'], 'Team', 'Team'); ?>
        </select>
    </div>
    <div class="form-group">
        <label>Registration Fee</label>
        <input type="number" class="form-control" name="registration_fee" value='<?= $data_game['registration_fee']; ?>'>
        <span class="text-danger">0 = Gratis</span>
    </div>
     <div class="form-group">
         <label for="image">Banner</label>
         <input type="file" class="form-control-file" name="image" id="image">
         <span class="text-danger">Extensi (jpg, jpeg). Ukuran max. 2MB, (800 x 400 )</span>
    </div>
    <div class="form-group">
        <label>Status</label>
        <select class="form-control" name="status">
            <option value="">- Pilih Salah satu -</option>
            <?= select_opt($data_game['status'], 'Open', 'Open'); ?>
            <?= select_opt($data_game['status'], 'Close', 'Close'); ?>
        </select>
    </div>
    <div class="form-group">
        <label>Game Mulai/Selesai</label>
        <input type="text" class="form-control" name="start_finish" value="<?= $data_game['started_at']; ?>_<?= $data_game['finished_at']; ?>">
        <span class="text-danger">Misal. 2021-05-23_2021-06-29 artinya Mulai_Selesai</span>
    </div>
    <div class="form-group">
        <button type="submit" name="edit" class="btn btn-primary btn-block">Update</button>
    </div>
</form>
    <?
} else {
    exit('No direct script access allowed!');
}