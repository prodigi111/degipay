<?php
require '../../connect.php';
require _DIR_('library/session/session');

$get_code = isset($_GET['q']) ? filter(base64_decode($_GET['q'])) : '';
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    if(!$_SESSION['user']) exit('No direct script access allowed!');
    if($data_user['level'] !== 'Admin') exit('No direct script access allowed!');
    if(!$get_code) exit('No direct script access allowed!');
    if($call->query("SELECT id FROM contact WHERE id = '$get_code'")->num_rows == false) exit('Contact not found.');
    $row = $call->query("SELECT * FROM contact WHERE id = '$get_code'")->fetch_assoc();
    ?>
<form method="POST">
    <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
    <input type="hidden" id="web_token" name="web_token" value="<?= base64_encode($get_code) ?>">
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-box">
            <tbody>
                <tr>
                    <th class="table-detail">Name</th>
                    <td class="table-detail"><?= $row['name'] ?></td>
                </tr>
                <tr>
                    <th class="table-detail">Level</th>
                    <td class="table-detail"><?= str_replace('Ceo & Founder','CEO & Founder',ucwords(strtolower($row['level']))) ?></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="form-group">
        <div class="col-md-12">
            <button type="submit" name="delete" class="btn btn-primary btn-block">Delete</button>
        </div>
    </div>
</form>
    <?
} else {
    exit('No direct script access allowed!');
}