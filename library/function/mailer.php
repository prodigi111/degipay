<?php
function mailer($config,$data) {
	include 'class.phpmailer.php';
    /* Formar $config = [
    	'host' => 'domainesia.com',
    	'user' => 'dari@domain.com',
    	'pass' => 'pass',
    	'from' => 'Dari',
    ];
    */

    /* Formar $data = [
    	'dest' => 'ramdoni14@gmail.com',
    	'name' => 'Faisal Ramdoni',
    	'subject' => 'SeruPay Register',
    	'message' => 'Terima kasih telah mendaftar',
    	'is_template' => 'no', // jika yes, base64_encode terlebih dahulu message nya
    ];
    */

    if(!$config['host'] || !$config['user'] || !$config['pass'] || !$config['from']) {
    	return false;
    } else if(!$data['dest'] || !$data['name'] || !$data['subject'] || !$data['message'] || !in_array($data['is_template'], ['yes','no'])) {
    	return false;
    } else {
    	$mail = new PHPMailer;
    	$mail->IsSMTP();
    	$mail->SMTPSecure = 'ssl';
    	$mail->Host = $config['host'];
    	$mail->SMTPDebug = 0;
    	$mail->Port = 587;
    	$mail->SMTPAuth = true;
    	$mail->Username = $config['user'];
    	$mail->Password = $config['pass'];
    	$mail->SetFrom($config['user'],$config['from']);
    	$mail->Subject = $data['subject'];
    	$mail->AddEmbeddedImage = $data['image'];
    	$mail->AddEmbeddedImage($data['image'],"spanduk","spanduk.jpg");
    	$mail->AddAddress($data['dest'],$data['name']);
    	if($data['is_template'] == 'yes') $mail->MsgHTML(base64_decode($data['message']));
    	else $mail->MsgHTML($data['message']);
    	return ($mail->Send()) ? true : false;
    }
}

function mailplate($type,$data) {
    global $_CONFIG;global $call;$out = '<style>
    @import url(https://fonts.googleapis.com/css2?family=Nunito&display=swap);.shenn{font-family:Nunito,sans-serif;font-weight:500;margin:auto;width:80%;border:3px solid #222;border-radius:15px;padding:10px}.shenn a{text-decoration:none;font-weight:700;color:#222}
</style>
<div class="shenn">
';
    if($type == 'otp') {
        $out .= '<p>Halo '.$data['name'].'.</p>
    <p>Silahkan Masukan Kode Verifikasi dibawah ini untuk memvalidasi dan mendaftarkan akun anda:</p>
    <pre style="font-size:21px;letter-spacing:6px;">'.$data['otp'].'</pre>
    <p>Hormat Kami,</p>
    <p><a href="javascript:;">'.$_CONFIG['title'].'</a> - Layanan Pulsa Online</p>
';
    } else if($type == 'repin') {
        $out .= '<p>Halo '.$data['name'].'.</p>
    <p>Masukan PIN baru dibawah ini dan jaga kerahasian pin anda :</p>
    <pre style="font-size:21px;letter-spacing:6px;">'.$data['pin'].'</pre>
    <p>Hormat Kami, <a href="javascript:;">'.$_CONFIG['title'].'</a></p>
';
    } else if($type == 'detail') {
        $out .= '<p>Halo '.$data['user']['name'].', terimakasih telah mendaftar di '.$_CONFIG['title'].'. Dibawah ini adalah detail akun anda:</p>
    <table>
        <tbody align="left">
            <tr><th>Nama</th><td>:</td><td>'.$data['user']['name'].'</td></tr>
            <tr><th>Email</th><td>:</td><td>'.$data['user']['email'].'</td></tr>
            <tr><th>Nomor HP</th><td>:</td><td>'.$data['user']['phone'].'</td></tr>
            <tr><th>Kode Referral</th><td>:</td><td>'.$data['user']['referral'].'</td></tr>
            <tr><th>Pin Keamanan</th><td>:</td><td>'.$data['user']['pin'].'</td></tr>
            <tr><th>Mendaftar</th><td>:</td><td>'.format_date('id',$data['user']['joined']).'</td></tr>
        </tbody>
    </table>
    <p>Hormat Kami, <a href="javascript:;">'.$_CONFIG['title'].'</a></p>
';
    }
    $out .= '</div>';
    return $out;
}