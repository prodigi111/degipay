<?php
require '../../connect.php';
require _DIR_('library/session/session');

$get_code = isset($_GET['q']) ? filter(base64_decode($_GET['q'])) : '';
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    if(!$_SESSION['user']) exit('No direct script access allowed!');
    if($data_user['level'] !== 'Admin') exit('No direct script access allowed!');
    if(!$get_code) exit('No direct script access allowed!');
    if($call->query("SELECT id FROM srv WHERE id = '$get_code'")->num_rows == false) exit('Service not found.');
    $row = $call->query("SELECT * FROM srv WHERE id = '$get_code'")->fetch_assoc();
    ?>
<form method="POST">
    <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
    <input type="hidden" id="web_token" name="web_token" value="<?= base64_encode($get_code) ?>">
    <div class="form-group">
        <label class="col-md-12 control-label">Type</label>
        <div class="col-md-12">
            <select name="type" id="type" class="form-control">
                <?php
                $search = $call->query("SELECT * FROM category GROUP BY type ORDER BY type ASC");
                while($row_query = $search->fetch_assoc()) {
                    print select_opt($row['type'],$row_query['type'], ucwords(str_replace('-', ' ', $row_query['type'])));
                }
                ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-12 control-label">Code</label>
        <div class="col-md-12">
            <input type="text" name="code" class="form-control" value="<?= $row['code'] ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-12 control-label">Name</label>
        <div class="col-md-12">
            <input type="text" name="name" class="form-control" value="<?= $row['name'] ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-12 control-label">Note</label>
        <div class="col-md-12">
            <textarea name="note" class="form-control"><?= $row['note'] ?></textarea>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-12 control-label">Price</label>
        <div class="col-md-12">
            <input type="number" name="price" class="form-control" value="<?= $row['price'] ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-12 control-label">Status</label>
        <div class="col-md-12">
            <select name="status" class="form-control">
                <?= select_opt($row['status'],'empty','empty') ?>
                <?= select_opt($row['status'],'available','available') ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-12 control-label">Brand</label>
        <div class="col-md-12">
            <select name="brand" id="brand" class="form-control">
                <?php
                $search = $call->query("SELECT * FROM category WHERE type = '".$row['type']."' GROUP BY code ORDER BY code ASC");
                while($rowBrand = $search->fetch_assoc()) {
                    print select_opt($row['brand'],$rowBrand['code'], $rowBrand['code']);
                }
                ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-12 control-label">Provider</label>
        <div class="col-md-12">
            <select name="provider" class="form-control">
                <?php
                $s = $call->query("SELECT * FROM provider ORDER BY name ASC");
                while($r = $s->fetch_assoc()) { print select_opt($row['provider'],$r['code'],$r['name']); }
                ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-12">
            <button type="submit" name="edit" class="btn btn-primary btn-block">Edit</button>
        </div>
    </div>
</form>
<script type="text/javascript">
$(document).ready(function() {
    $("#type").change(function() {
        var type = $("#type").val();
        $.ajax({
            url: '<?= ajaxlib('kategori-service') ?>',
            data: 'type=' + type + '&csrf_token=<?= $csrf_string ?>',
            type: 'POST',
            dataType: 'html',
            success: function(msg) {
                $("#brand").html(msg);
            }
        });
    });
});
</script>
    <?
} else {
    exit('No direct script access allowed!');
}