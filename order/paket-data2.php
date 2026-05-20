<?php
require '../RGShenn.php';
require _DIR_('library/session/session');
if(isset($_POST['buypaypal'])) {
    $postPin = filter($_POST['pin']);
    $post_data = filter($_POST['data']);
    $post_quantity = filter($_POST['quantity']);
    $post_total = filter($_POST['total']);
    $pip = client_ip();
    
    $service = 'Paypal $'.$post_quantity;
    $server = 'X';
    $code = 'P$'.$post_quantity;
    if ($data_user['level'] == 'Basic') {
        $price = $post_total + conf('trxmanual',3);
        $profit = price($data_user['level'],$post_total,$server,'profit');
    } else {
        $price = $post_total + conf('trxmanual',4);
        $profit = price($data_user['level'],$post_total,$server,'profit');
    }
    $WebID = random_number(8);
    $TrxID = random(10);
    
    if($result_csrf == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'System error, please try again later.'];
    } else if(!$postPin) {
        $_SESSION['result'] = ['type' => false,'message' => 'Masukkan Pin Keamanan Telebih Dahulu!.'];
    } else if($_CONFIG['mt']['web'] == 'true') {
        $_SESSION['result'] = ['type' => false,'message' => 'Aplikasi Sedang Dalam Perbaikan.'];
    } else if($sess_username == 'demo') {
        $_SESSION['result'] = ['type' => false,'message' => 'Akun Demo Tidak Memiliki Izin Untuk Mengakses Fitur Ini.'];
    } else if($data_user['status'] == 'locked') {
        $_SESSION['result'] = ['type' => false,'message' =>'Transaksi di Bekukan Silahkan Hubungi Admin.'];
    } else if(!$post_quantity || !$post_data) {
        $_SESSION['result'] = ['type' => false,'message' => 'Masih Ada Formulir Kosong.'];
    } else if($call->query("SELECT * FROM trx WHERE data = '$post_data' AND status = 'processing'")->num_rows == 1) {
        $_SESSION['result'] = ['type' => false,'message' => 'Ada Pesanan Dengan Data Yang Sama Dan Sedang Diproses.'];
    } else if($call->query("SELECT * FROM provider WHERE code = '$server'")->num_rows == 0) {
        $_SESSION['result'] = ['type' => false,'message' => 'Our server is in trouble, please try again later.'];
    } else if($data_user['balance'] < $price) {
        $_SESSION['result'] = ['type' => false,'message' => 'Saldo Anda Tidak Mencukupi Untuk Melakukan Pemesanan Ini.'];
    } else if((strtotime("$date $time") - strtotime($call->query("SELECT * FROM trx WHERE user = '$sess_username' ORDER BY id DESC LIMIT 1")->fetch_assoc()['date_cr'])) < 30) {
        $_SESSION['result'] = ['type' => false,'message' => 'Transaksi Terbatas, Ulangi Dalam 30 Detik.'];
    } else {
    if(check_bcrypt($postPin, $data_user['pin']) == true) {
        
        $WATL->sendMessage($data_user['phone'], "Hallo, *{$data_user['name']}*\nID Pesanan *#{$WebID}* \nPesanan : *{$service}* \nStatus : *Proses* \nCatatan: *{Transaksi Sedang Diproses}* \n----------------------------------------------\n*Terima kasih sudah memilih {$_CONFIG['title']}*");
        
        $WATL->sendMessage(conf('Whatsapp-Admin', 8), "Pesanan *{$service}* Membutuhkan Pengiriman Ke *{$post_data}*");
        
        if($call->query("INSERT INTO trx VALUES ('','$WebID','$TrxID','$sess_username','$code','$service','$post_data','Transaksi Sedang Diproses','$price','$profit','processing','0','0','0','WEB,$pip','manual','$date $time','$date $time','$server')") == true) {
            $call->query("UPDATE users SET balance = balance-$price WHERE username = '$sess_username'");
            $call->query("INSERT INTO mutation VALUES ('', '$sess_username', '-', '$price', 'Order #$WebID | $post_data', '$date', '$time', 'Transaksi')");
            $call->query("INSERT INTO logs VALUES ('', '$sess_username', 'order', '$pip', '$date $time')");
            
            $_SESSION['success'] = ['type' => true, 'price' => $price, 'trxid' => $WebID];
        } else {
            $_SESSION['result'] = ['type' => false,'message' => 'Our server is in trouble, please try again later.'];
        }
        } else {
            $_SESSION['result'] = ['type' => false,'message' => 'Pin Keamanan Tidak Valid.'];
        }
    }
}
$page = isset($_SESSION['success']) ? 'Pembayaran Berhasil' : 'Paypal';
require _DIR_('library/header/user');
?>
<? if(isset($_SESSION['success'])) :  ?>

    <? require _DIR_('order/result') ?>

<? unset($_SESSION['success']); else: ?>
    <!-- App Capsule -->
    <div id="appCapsule" class="rgs-order">
        <div class="section full mb-2">
            
        <form method="POST">
            <? require _DIR_('library/session/result-mobile') ?>
            <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
            <div class="wide-block pb-1 pt-1 mt-1">
                
                <ul class="listview image-listview no-line no-space flush">
                    <li>
                        <div class="item">
                            <img src="<?= assets('mobile/img/home/paypal.png') ?>" width="36px" class="image" id="RGSLogo">
                            <div class="in">
                                <div class="form-group basic">
                                    <div class="input-wrapper">
                                        <label class="label">Email Paypal</label>
                                        <input type="text" class="form-control" placeholder="" name="data" required>
                                        <i class="clear-input">
                                            <ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon>
                                        </i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <div class="item">
                        <div class="in">
                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label">Jumlah Pembelian ($)</label>
                                    <input type="number" class="form-control" name="quantity" placeholder="" onkeyup="get_total(this.value).value;" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="in">
                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label">Total Harga</label>
                                    <input type="number" class="form-control" id="total" name="total" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="in">
                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label">Pin Keamanan</label>
                                    <input type="password" class="form-control" maxlength="6" name="pin" pattern="[0-9]*" inputmode="numeric" placeholder="Silahkan masukkan PIN untuk melanjutkan transaksi">
                                </div>
                            </div>
                        </div>
                    </div>
                </ul>
            </div>
            <div class="section full rgs-info bg-white">
             <div class="card">
                <div class="app-menu">
                Informasi:<br>
                1. Minimal Transaksi Sebesar $10.<br>
                2. Setiap Transaksi akan divalidasi terlebih dahulu.<br>
                3. Jam Operasional 09.00 - 18.00 WIB.<br>
                4. Untuk Paypal Indonesia transaksi bebas fee.<br>
            </div>
              </div>
                </div>      

            <div class="form-button-group">
                <button type="submit" name="buypaypal" class="btn btn-primary btn-block btn-lg">Lanjutkan</a>
            </div>
        </form>

        </div>

    </div>
    <!-- * App Capsule -->
<? endif ?> 
<?php require _DIR_('library/footer/user') ?>
<script type="text/javascript">
function get_total(quantity) {
	var rate = <?= conf('trxmanual', 5) ?>;
	var result = eval(quantity) * rate;
	$('#total').val(result);
}
</script>