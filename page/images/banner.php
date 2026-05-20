<?php 
require '../RGShenn.php';
require _DIR_('library/session/user');
$page = 'Banner Generator';
require _DIR_('library/header/user');

$filename = "images/".$data_user['card']."_".$data_user['username'].".jpg";
$filename2 = "images/".$data_user['card']."_".$data_user['username']."_tumb.jpg";
$filename3 = "/home/oeagityw/app.plisspa.id/page/images/".$data_user['card']."_".$data_user['username'].".jpg";
$filelink = "https://app.plisspa.id/page/images/".$data_user['card']."_".$data_user['username']."_tumb.jpg";
if(isset($_POST['generate'])){
$img = imagecreatefromjpeg("images/banner.jpg");
$txt = filter(strtoupper($_POST['namakonter']));

$fontFile = "/home/oeagityw/app.plisspa.id/page/ariblk.ttf"; 
$fontSize = 350;
$fontColor = imagecolorallocate($img, 255, 255, 225);
$posX = 2200;
$posY = 1000;
$angle = 0;

$iWidth = imagesx($img);
$iHeight = imagesy($img);

$tSize = imagettfbbox($fontSize, $angle, $fontFile, $txt);
$tWidth = max([$tSize[2], $tSize[4]]) - min([$tSize[0], $tSize[6]]);
$tHeight = max([$tSize[5], $tSize[7]]) - min([$tSize[1], $tSize[3]]);

$centerX = ceil(($iWidth - $tWidth) / 2);
$centerX = $centerX<0 ? 0 : $centerX;
$centerY = ceil(($iHeight - $tHeight) / 6);
$centerY = $centerY<0 ? 0 : $centerY;

imagettftext($img, $fontSize, $angle, $centerX, $posY, $fontColor, $fontFile, $txt);

// header("Content-type: image/jpeg");
// imagejpeg($img);

$quality = 100; // 0 to 100
$percent = 0.07;
imagejpeg($img, $filename, $quality);
imagedestroy($img);

list($width, $height) = getimagesize($filename);
$newwidth = $width * $percent;
$newheight = $height * $percent;
$thumb = imagecreatetruecolor($newwidth, $newheight);
$source = imagecreatefromjpeg($filename);
imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
imagejpeg($thumb, $filename2, $quality);
imagedestroy($thumb);
}

if(isset($_POST['email'])){
                
                $result_mail = mailer($_MAILER,[
                    'dest' => $data_user['email'],
                    'name' => $data_user['name'],
                    'subject' => 'Banner '.$_CONFIG['title'].'',
                    'message' => 'Langsung download Gann...',
                    'attach' => $filename3,
                    'image' => $filename2,
                    'is_template' => 'no'
                ]);
                
                if($result_mail == true) {
                    $_SESSION['result'] = ['type' => true,'message' => 'Banner telah dikirim, silahkan cek inbox/folder spam email Anda'];
                } else {
                    $_SESSION['result'] = ['type' => false,'message' => 'Gagal kirim Banner.'];
                } 
    
} else if(isset($_POST['wa'])) {
                $url = conf('WhatsApp',1);
                $Message = "BANNER {$_CONFIG['title']}";
                $data = [
                    'api_key' => conf('WhatsApp',2),
                    'sender' => conf('WhatsApp',3),
                    'number' => $data_user['phone'],
                    'media_type' => 'image',
                    'caption' => $Message,
                    'url' => $filelink
                    ];
                    $curl = curl_init();
                    curl_setopt_array($curl, array(
                       CURLOPT_URL => "$url/send-media",
                       CURLOPT_RETURNTRANSFER => true,
                       CURLOPT_FOLLOWLOCATION => true,
                       CURLOPT_CUSTOMREQUEST => 'POST',
                       CURLOPT_POSTFIELDS => json_encode($data),
                       CURLOPT_HTTPHEADER => array(
                       'Content-Type: application/json'
                        ))
                    );

                        $response = curl_exec($curl);
                        curl_close($curl);
                
                file_put_contents('.notifier', json_encode($response, JSON_PRETTY_PRINT));
                if($response['status'] == true) {
                    $_SESSION['result'] = ['type' => true,'message' => 'Banner Telah Dikirim, Silahkan Cek WhatsApp Anda'];
                } else {
                    $_SESSION['result'] = ['type' => false,'message' => 'Gagal Kirim Banner.'];
                }
            
}
?>

    <!-- App Capsule -->
    <div id="appCapsule" class="rgs-other pl-2 pr-2">
        <div class="section text-center">
    <?php
    if (file_exists($filename)) { ?>
            <img src="<?php echo "$filename2?".time(); ?>" width="100%" alt="spanduk" class="mt-3 mb-3">
        </div>
    <?php }else{?>
    <br>Yuk Buat Sekarang...<br> Masukkan Nama Toko Mu(Maksimal 17 karakter) Yang Akan Tercetak di Banner Lalu Tekan Tombol Generate.
    <?php }?>
    <form method="POST">
        <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>"> 
        <input type="text" name="namakonter" maxlength="17" class="form-control mt-3 mb-3" placeholder="Nama Konter" required>
            <div>
                <button type="submit" name="generate" class="btn rounded btn-primary btn-rounded btn-block btn-lg">Generate</a>
            </div>
    </form>
    <?php
    if (file_exists($filename)) { ?>
    <form method="POST">
            <div class="form-button-group">
                <button type="submit" name="email" class="btn rounded btn-primary btn-block btn-lg"><i class="fa fa-mail"></i>&nbsp;&nbsp;Kirim Ke Email</button>
                <button type="submit" name="wa" class="btn rounded btn-primary btn-block btn-lg"><i class="fa fa-logo-whatsapp"></i>&nbsp;&nbsp;Kirim Ke Wa</button>
    </form>
    <?php }else{}?>
            </div>
        <div class="section rgs-list-layanan mt-2" id="service">
            <? require _DIR_('library/session/result-mobile') ?>
        </div>
    </div>
    <!-- * App Capsule -->

<?php require _DIR_('library/footer/user') ?>