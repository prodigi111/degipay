<?php
require '../../connect.php';
require _DIR_('library/session/session');

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    if(!isset($_SESSION['user'])) exit("No direct script access allowed!");
    if(!isset($_POST['data'])) exit("No direct script access allowed!");
    if(empty($_POST['data']) || $_POST['data'] == '0' || $_POST['data'] == '08') die;
    $tipe = filter($_POST['type']);
?>
                            <div class="item">
                                <div class="icon-box bg-primary">
                                    <ion-icon name="grid-outline"></ion-icon>
                                </div>
                                <div class="in">
                                    <div class="form-group basic">
                                        <div class="input-wrapper">
                                            <label class="label">Kategori</label>
                                            <select class="form-control custom-select" name="category" id="category" required>
                                                <option value="0">- Select One -</option>
                                            <?php
                                            $search = $call->query("SELECT * FROM category WHERE type = '".$tipe."' ORDER BY name ASC");
                                            while($row = $search->fetch_assoc()) {
                                                print '<option value="'.$row['code'].'">'.$row['name'].'</option>';
                                            }
                                            ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
<script type="text/javascript">
$(document).ready(function() {
    $("#category").change(function() {
        var category = $("#category").val();
        var data = $("#data").val();
        $(".rgs-list-layanan").show();
        $.ajax({
            type: 'POST',
            data: 'category=' + category + '&data=' + data + '&type=<?= $tipe ?>&csrf_token=<?= $csrf_string ?>',
            url: '<?= ajaxlib('service-prepaid.php') ?>',
            dataType: 'html',
            beforeSend: () => {
                $('#service').html( '<div class="col-md-6 offset-md-3 text-center text-primary mt-4"><div class="spinner-border avatar-md" role="status"></div></div>' );
            }, 
            success: (msg) => {
                setTimeout( () => {
                    $("#service").html(msg);
                }, 500);
            }
        });
    });
});
</script>
<?
} else {
	exit("No direct script access allowed!");
}