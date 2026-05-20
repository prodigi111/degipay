<?php
require '../../RGShenn.php';
require _DIR_('library/session/session');

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    if(!isset($_SESSION['user'])) exit("No direct script access allowed!");
    if(!isset($_POST['data'])) exit("No direct script access allowed!");
    if(empty($_POST['data']) || $_POST['data'] == '0' || $_POST['data'] == '08') die;
    $post_phone = filter_phone('0',$_POST['data']);
    $tipe = filter($_POST['type']);
    $brand = strtr(strtoupper($SimCard->operator($post_phone)),[
        'THREE' => 'TRI',
    //    'SMARTFREN' => 'SMART'
    ]);
?>
                            <div class="item">
                                <div class="in">
                                    <div class="form-group basic">
                                        <div class="input-wrapper">
                                            <label class="label">Produk</label>
                                            <select class="form-control custom-select" name="category" id="category" required>
                                                <option value="Umum">Umum</option>
                                            <?php
                                            $search = $call->query("SELECT * FROM srv WHERE brand = '$brand' AND type = '$tipe' AND kategori NOT IN ('Umum') GROUP BY kategori ORDER BY kategori ASC");
                                            while($row = $search->fetch_assoc()) {
                                                print '<option value="'.$row['kategori'].'">'.$row['kategori'].'</option>';
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
        $.ajax({
            type: 'POST',
            data: 'phone=' + data + '&kategori=' + category + '&type=paket-internet&csrf_token=<?= $csrf_string ?>',
            url: '<?= ajaxlib('service-simcard.php') ?>',
            dataType: 'json',
            beforeSend: () => {
                $('#service').html( '<div class="col-md-6 offset-md-3 text-center text-primary mt-4"><div class="spinner-border avatar-md" role="status"></div></div>' );
            }, 
            success: (msg) => {
                setTimeout( () => {
                    $("#service").html(msg.service);
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