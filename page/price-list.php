<?php
require '../RGShenn.php';
require _DIR_('library/session/user');
$page = 'Daftar Harga';
require _DIR_('library/header/user');
?>
    <!-- App Capsule -->
    <div id="appCapsule" class="extra-header-active rgs-price-list">
        <div class="tab-content">
            <!-- Prabayar tab -->
            <div class="tab-pane fade active show" id="Praba" role="tabpanel">
                <div class="section pl-1 pr-1 inset mt-2">
                    <div class="wide-block mb-2">
                        <div class="form-group basic p-0">
                            <div class="input-wrapper">
                                <select class="form-control custom-select" id="type">
                                    <option value="0" selected disabled>-> Pilih Kategori <-</option>
                                <?php
                                $search = $call->query("SELECT * FROM category WHERE type != 'shop' AND type != 'pascabayar' GROUP BY type ORDER BY type ASC");
                                while($row = $search->fetch_assoc()) {
                                    print '<option value="'.$row['type'].'">'.ucwords(str_replace('-', ' ', $row['type'])).'</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            
                <div id="service">
                
                </div>
            
                <div id="services">
                
                </div>
            
                </div>
            </div>
            <!-- * Prabayar tab -->

            <!-- Pascabayar tab -->
            <div class="tab-pane fade" id="pasca" role="tabpanel">
                <div class="section pl-1 pr-1 inset mt-2">
                    <div class="wide-block mb-2">
                        <div class="form-group basic p-0">
                            <div class="input-wrapper">
                            <select class="form-control custom-select" id="types">
                                <option value="0" selected disabled>-> Pilih Kategori <-</option>
                                <?php
                                $search = $call->query("SELECT * FROM category WHERE type = 'pascabayar' GROUP BY type ORDER BY type ASC");
                                while($row = $search->fetch_assoc()) {
                                    print '<option value="'.$row['type'].'">'.ucwords(str_replace('-', ' ', $row['type'])).'</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            
                <div id="servicep">
                
                </div>
            
                <div id="services">
                
                </div>
            
                </div>
            </div>
            <!-- * Topup tab -->
        </div>
    </div>
    <!-- * App Capsule -->

<?php require _DIR_('library/footer/user') ?>
<script type="text/javascript">
$(document).ready(function() {
    $("#type").change(function() {
        var type = $("#type").val();
        $.ajax({
            url: '<?= ajaxlib('product-list') ?>',
            data: 'type=' + type + '&csrf_token=<?= $csrf_string ?>',
            type: 'POST',
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
    $("#types").change(function() {
        var types = $("#types").val();
        $.ajax({
            url: '<?= ajaxlib('product-list-pasca') ?>',
            data: 'type=' + types + '&csrf_token=<?= $csrf_string ?>',
            type: 'POST',
            dataType: 'html',
            beforeSend: () => {
                $('#servicep').html( '<div class="col-md-6 offset-md-3 text-center text-primary mt-4"><div class="spinner-border avatar-md" role="status"></div></div>' );
            }, 
            success: (msg) => {
                setTimeout( () => {
                    $("#servicep").html(msg);
                }, 500);
            }
        });
    });
});
</script>