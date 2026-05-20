<?php
require '../../../connect.php';
require _DIR_('library/session/session');

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    if(!$_SESSION['user']) exit('No direct script access allowed!');
    if($data_user['level'] !== 'Admin') exit('No direct script access allowed!');
    $data_tour = $call->query("SELECT * FROM events_tournament_game WHERE status = 'Open' AND finished_at >= '$date' ORDER BY id DESC");
    ?>
<form method="POST" role="form" enctype="multipart/form-data">
    <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
    <div class="form-group">
        <label>Title</label>
        <input type="text" class="form-control" name="title">
    </div>
    <div class="form-group">
        <label>Description</label>
        <textarea name="description" class="form-control" rows="6"></textarea>
    </div>
     <div class="form-group">
         <label for="image">Banner</label>
         <input type="file" class="form-control-file" name="image" id="image" required>
         <span class="text-danger">Extensi (jpg, jpeg). Ukuran max. 2MB, (800 x 400 )</span>
    </div>
    <div class="form-group">
        <label>Tournament Game</label>
        <select class="form-control" name="target">
            <option value="">- Pilih Salah satu -</option>
            <?php while($data = $data_tour->fetch_assoc()): ?>
            <?php 
                $is_publish = $call->query("SELECT * FROM events WHERE target = '".$data['id']."'")->num_rows;
            ?>
            <option value="<?= $data['id']; ?>"><?= $data['name']; ?> [<?= $data['started_at']; ?>] <?= ($is_publish > 0) ? '[Pernah Di Publish]' : ''; ?></option>
            <?php endwhile; ?>
        </select>
    </div>
    <div class="form-group">
        <label>Event Berakhir</label>
        <input type="text" class="form-control" name="expired_at">
        <span class="text-danger">YYYY-MM-DD (Misal. <?= $date; ?>)</span>
    </div>
    <div class="form-group">
        <button type="submit" name="publish" class="btn btn-primary btn-block">Publish</button>
    </div>
</form>
    <?
} else {
    exit('No direct script access allowed!');
}