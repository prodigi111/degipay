<?php 
require '../../connect.php';
if(!isset($_SESSION['user']) && !isset($_COOKIE['token']) && !isset($_COOKIE['ssid'])) {
        $ShennID = $_COOKIE['ssid'];
        $ShennUID = str_replace(['SHENN-A','AIY'],'',$ShennID) + 0;
        $ShennKey = $_COOKIE['token'];
        $ShennUser = $call->query("SELECT * FROM users WHERE id = '$ShennUID'")->fetch_assoc();

        $ShennCheck = $call->query("SELECT * FROM users_cookie WHERE cookie = '$ShennKey' AND username = '".$ShennUser['username']."'");
        if($ShennCheck->num_rows == 1) {
            $_SESSION['user'] = $ShennUser;
            redirect(0,visited());
            $call->query("UPDATE users_cookie SET active = '$date $time' WHERE cookie = '$ShennKey'");
        } else {
            redirect(0,base_url('auth/login'));
        }
} else {
require _DIR_('library/session/admin');
}

if(isset($_POST['submit'])) {
    $post_1 = filter($_POST['title']);
    $post_2 = filter($_POST['desc']);
    $post_3 = filter($_POST['keyword']);
    $post_4 = filter($_POST['banner']);
    $post_5 = filter($_POST['icon']);
    
    if($result_csrf == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'System error, please try again later.'];
    } else if($data_user['level'] !== 'Admin') {
        $_SESSION['result'] = ['type' => false,'message' => 'You do not have permission to access this feature.'];
    } else if($sess_username == 'demo') {
        $_SESSION['result'] = ['type' => false,'message' => 'Demo accounts do not have permission to access this feature.'];
    } else if(!$post_1 || !$post_5) {
        $_SESSION['result'] = ['type' => false,'message' => 'There are still empty columns.'];
    } else {
        $up = $call->query("UPDATE conf SET c1 = '$post_1', c2 = '$post_2', c3 = '$post_3', c4 = '$post_4', c5 = '$post_5' WHERE code = 'webcfg'");
        if($up == TRUE) {
            $_SESSION['result'] = ['type' => true,'message' => 'Website successfully changed.'];
        } else {
            $_SESSION['result'] = ['type' => false,'message' => 'Our server is in trouble, please try again later.'];
        }
    }
} else if($_POST) {
    $maintenance = filter($_POST['maintenance']);
    if($result_csrf == false) {
        print sessResult('false','System Error, please try again later.');
    } else if($data_user['level'] !== 'Admin') {
        print sessResult('false','You do not have permission to access this feature.');
    } else if($sess_username == 'demo') {
        print sessResult('false','Demo accounts do not have permission to access this feature.');
    } else {
        $mt['db'] = strtr($maintenance,['mt_web' => 'c1','mt_api' => 'c2','mt_bot' => 'c3',]);
        $mt['name'] = strtr($maintenance,['mt_web' => 'WEB','mt_api' => 'API','mt_bot' => 'BOT',]);
        $mt['value'] = conf('webmt',$mt['db']);
        
        if($mt['value'] == 'true') $y = $call->query("UPDATE conf SET ".$mt['db']." = 'false' WHERE code = 'webmt'");
        if($mt['value'] == 'false') $y = $call->query("UPDATE conf SET ".$mt['db']." = 'true' WHERE code = 'webmt'");
        
        
        if($y == true) { 
            $url = conf('WhatsApp',1);
                $Message = "Hallo, *{$row_query['name']}*\n saat ini website kami sedang maintence website\n untuk transaksi belum bisa di lakukan pada saat ini.   \n----------------------------------------------\n*Kami Pihak {$_CONFIG['title']}* Mengucapkan Terima Kasih";
                $data = [
                    'api_key' => conf('WhatsApp',2),
                    'sender' => conf('WhatsApp',3),
                    'number' => $row_query['phone'],
                    'message' => $Message
                    ];
                    $curl = curl_init();
                    curl_setopt_array($curl, array(
                       CURLOPT_URL => "$url/app/api/send-message",
                       CURLOPT_RETURNTRANSFER => true,
                       CURLOPT_ENCODING => "",
                       CURLOPT_MAXREDIRS => 10,
                       CURLOPT_TIMEOUT => 0,
                       CURLOPT_FOLLOWLOCATION => true,
                       CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                       CURLOPT_CUSTOMREQUEST => "POST",
                       CURLOPT_POSTFIELDS => json_encode($data))
                    );

                        $response = curl_exec($curl);
                        curl_close($curl);
            print sessResult('true','['.$mt['name'].'] Updated successfully, reload the page to see the results.');
        } else {
            print sessResult('false','The system is in trouble, please try again later.');
        }
    }
    die;
}

require _DIR_('library/header/admin');
?>
                  <div class="col-lg-8 offset-lg-2">
                     <div class="iq-card">
                        <div class="iq-card-header d-flex justify-content-between">
                           <div class="iq-header-title">
                              <h4 class="card-title"><i class="fas fa-cogs text-primary mr-2"></i> Website</h4>
                           </div>
                        </div>
                        <form method="POST">
                            <div class="iq-card-body">
                                <div id="sess-result-modal"></div>
                                <? require _DIR_('library/session/result'); ?>
                                <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
                                <div class="form-group">
                                    <label>Title</label>
                                    <input type="text" class="form-control" name="title" value="<?= conf('webcfg',1) ?>">
                                </div>
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea class="form-control" name="desc" rows="6"><?= conf('webcfg',2) ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Keyword</label>
                                    <textarea class="form-control" name="keyword" rows="4"><?= conf('webcfg',3) ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label>OG Banner</label>
                                    <input type="text" class="form-control" name="banner" value="<?= conf('webcfg',4) ?>">
                                </div>
                                <div class="form-group">
                                    <label>Icon / Logo</label>
                                    <input type="text" class="form-control" name="icon" value="<?= conf('webcfg',5) ?>">
                                </div>
                                <div class="form-group">
                                    <label class="d-block">Maintenance</label>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="mt_web" id="mt_web" value="true"<?= ($_CONFIG['mt']['web'] == 'true') ? ' checked' : ''; ?>>
                                        <label class="custom-control-label" for="mt_web">Website</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="mt_api" id="mt_api" value="true"<?= ($_CONFIG['mt']['api'] == 'true') ? ' checked' : ''; ?>>
                                        <label class="custom-control-label" for="mt_api">API</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="mt_bot" id="mt_bot" value="true"<?= ($_CONFIG['mt']['bot'] == 'true') ? ' checked' : ''; ?>>
                                        <label class="custom-control-label" for="mt_bot">BOT</label>
                                    </div>
                                </div>
                            </div>
                            <ul class="list-group list-group-flush">
                               <li class="list-group-item"></li>
                            </ul>
                            <div class="iq-card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <button type="submit" name="submit" class="btn btn-block btn-primary">Submit</button>
                                    </div>
                                    <div class="col-6">
                                        <button type="submit" name="shenn_reset" class="btn btn-block btn-danger">Reset</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                     </div>
                  </div>
<? require _DIR_('library/footer/admin'); ?>
<script type="text/javascript">
$(function() {
    var errRes = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>There is an error!</div>';
    $(document).on('change', '[name="mt_web"]' , function(){
        $.ajax({
            type: 'POST',
            data: 'maintenance=mt_web&csrf_token=<?= $csrf_string ?>',
            url: '<?= base_url('admin/other/website') ?>',
            dataType: 'html',
            beforeSend: function() { $("#sess-result-modal").html(); },
            success: function(msg) { $("#sess-result-modal").html(msg); },
            error: function() { $("#sess-result-modal").html(errRes); }
        });
    });
    $(document).on('change', '[name="mt_api"]' , function(){
        $.ajax({
            type: 'POST',
            data: 'maintenance=mt_api&csrf_token=<?= $csrf_string ?>',
            url: '<?= base_url('admin/other/website') ?>',
            dataType: 'html',
            beforeSend: function() { $("#sess-result-modal").html(); },
            success: function(msg) { $("#sess-result-modal").html(msg); },
            error: function() { $("#sess-result-modal").html(errRes); }
        });
    });
    $(document).on('change', '[name="mt_bot"]' , function(){
        $.ajax({
            type: 'POST',
            data: 'maintenance=mt_bot&csrf_token=<?= $csrf_string ?>',
            url: '<?= base_url('admin/other/website') ?>',
            dataType: 'html',
            beforeSend: function() { $("#sess-result-modal").html(); },
            success: function(msg) { $("#sess-result-modal").html(msg); },
            error: function() { $("#sess-result-modal").html(errRes); }
        });
    });
});
</script>