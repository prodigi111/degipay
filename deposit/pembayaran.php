<?php
require '../RGShenn.php';
require _DIR_('library/session/user');
$page = 'Pilih Metode Pembayaran';

$_POSTNominal = isset($_POST['nominal']) ? filter($_POST['nominal']) : '';
$_POSTUnik    = rand(9, 500);

if(!$_POSTNominal) {
    redirect(0, base_url('deposit/'));
} else {
    $search = $call->query("SELECT * FROM deposit WHERE status = 'unpaid' AND user = '$sess_username'");
    $rowDepo = $search->fetch_assoc();
    if($search->num_rows == 1) redirect(0,base_url('deposit/invoice/'.$rowDepo['rid']));
    
    if(!$_POSTNominal) {
        $_SESSION['result'] = ['type' => false, 'message' => 'Masukkan Nominal Pengisian Deposit Terlebih Dahulu!.'];
        redirect(0, base_url('deposit/'));
    } else if($_POSTNominal < 10000) {
        $_SESSION['result'] = ['type' => false, 'message' => 'Minimal Pengisian Adalah 10.000.'];
        redirect(0, base_url('deposit/'));
    }
    
    if(isset($_POST['deposit'])) {
        $post_sender = 'unknown';
        $post_method = filter($_POST['kode']);
        $post_quantity = filter_entities($_POST['nominal']);
        $post_uniq = filter_entities($_POST['unik']);
        $post_amount = $post_quantity + $post_uniq;
        $post_tid = strtoupper(random(7));
        
        if($call->query("SELECT * FROM deposit WHERE amount = '$post_amount' AND method = '$post_method' AND DATE(date_cr) = '$date'")->num_rows == TRUE) {
            $post_amount = $post_amount + rand(9,99);
        }
        
        $search_method = $call->query("SELECT * FROM deposit_method WHERE code = '$post_method' AND data != ''");
        if($search_method->num_rows == true) $data_method = $search_method->fetch_assoc();
        if($result_csrf == false) {
            $_SESSION['result'] = ['type' => false,'message' => 'System error, please try again later.'];
        } else if($_CONFIG['mt']['web'] == 'true') {
            $_SESSION['result'] = ['type' => false,'message' => 'Aplikasi Sedang Dalam Perbaikan.'];
        } else if($sess_username == 'demo') {
            $_SESSION['result'] = ['type' => false,'message' => 'Akun Demo Tidak Memiliki Izin Untuk Mengakses Fitur Ini.'];
        } else if(!$post_sender || !$post_method || !$post_quantity) {
            $_SESSION['result'] = ['type' => false,'message' => 'System Error Silahkan Hubungi Admin (001).'];
        } else if($search_method->num_rows == 0) {
            $_SESSION['result'] = ['type' => false,'message' => 'Metode Pembayaran Tidak Ditemukan.'];
        } else if($post_quantity < $data_method['min']) {
            $_SESSION['result'] = ['type' => false,'message' => 'Minimum Isi Saldo Rp '.currency($data_method['min'])];
        } else if($call->query("SELECT * FROM deposit WHERE user = '$sess_username' AND status = 'unpaid'")->num_rows > 0) {
            $_SESSION['result'] = ['type' => false,'message' => 'Anda Masih Memiliki Permintaan Isi Saldo Yang Belum Di Bayar.'];
        } else {
            $berhasil = false;
            if(stristr($post_method,'-va') || in_array($post_method, ['qris2', 'qris', 'alfamart', 'alfamidi'])) {
                $post_amount = $post_quantity;
                $post_total = $post_amount; 
                $post_jumlah = $post_amount+$data_method['fee'];
                $try = $curl->connectHeaderPost('https://tripay.co.id/api/transaction/create',['Authorization: Bearer '.conf('tripay-cfg', 1)],http_build_query([
                    'method'            => strtoupper(str_replace('-','',$post_method)),
                    'merchant_ref'      => $post_tid,
                    'amount'            => $post_total,
                    'customer_name'     => $data_user['name'],
                    'customer_email'    => $data_user['email'],
                    'customer_phone'    => filter_phone('0',$data_user['phone']),
                    'order_items'       => [[
                        'name'      => 'Saldo '.currency($post_amount),
                        'price'     => $post_total,
                        'quantity'  => 1
                    ]],
                    'callback_url'      => base_url('payment/tripay-gateway'),
                    'return_url'        => base_url('deposit/invoice/'.$post_tid),
                    'expired_time'      => (time()+(24*60*60)),
                    'signature'         => hash_hmac('sha256', conf('tripay-cfg', 3).$post_tid.$post_total, conf('tripay-cfg', 2))
                ]));
                
                if(isset($try['success'])) {
                    if($try['success'] == true) {
                        $berhasil = true;
                        $post_note =  $post_method == ['qris2','qris'] ? $try['data']['qr_url'] : $try['data']['pay_code'];
                        $post_note2 = $try['data']['pay_code'];
                        $post_note3 = (strlen(explode('-',$post_method)[0]) > 3) ? 'Virtual Account '.ucfirst(explode('-',$post_method)[0]) : 'Virtual Account '.strtoupper(explode('-',$post_method)[0]);
                    } else {
                        $pesan_error = $try['message'];
                    }
                }
            } else {
                $berhasil = true;
                $post_note = $data_method['data'];
                $post_note2 = $post_note;
                $post_note3 = strtoupper($post_method);
                $post_total = $post_amount;
            }
            
            if($berhasil == false) {
                $_SESSION['result'] = ['type' => false,'message' => isset($pesan_error) ? $pesan_error : 'Our payment server is in trouble, please try again later.'];
            } else {
                $ins = $call->query("INSERT INTO deposit VALUES ('', '$post_tid', '$sess_username', '$post_method', '$post_note', '$post_sender', '$post_jumlah', '$post_amount', 'unpaid', '$date $time', '$date $time')");
                if($ins == true) {
                    if($post_method == ['qris2', 'qris']) :
                        $textWa = 'Terima Kasih Telah Melakukan Deposit Menggunakan QRIS, Silahkan SCAN/Pindai QR Kode Ini Melalui Dompet Digital Favorit Anda.';
                        $textFC = 'Silahkan SCAN/Pindai QR Melalui Dompet Digital Favorit Anda.';
                    elseif(in_array($post_method, ['alfamart', 'alfamidi'])) : 
                        $textWa = 'Terima Kasih Telah Melakukan Deposit Menggunakan '.ucfirst($post_method).' Silahkan Datang ke '.ucfirst($post_method).'
1. Sampaikan ke kasir ingin melakukan pembayaran Plasamall
2. Berikan kode bayar ('.$post_note2.') ke kasir
3. Bayar sesuai jumlah yang diinfokan oleh kasir
4. Simpan struk bukti pembayaran Anda';
                        $textFC = 'Terima Kasih Telah Melakukan Deposit Menggunakan '.ucfirst($post_method).' Silahkan Datang ke '.ucfirst($post_method);
                    else :
                        $textWa = 'Hallo '.$data_user['name'].', Mohon Segera Lakukan Pembayaran Ke '.$post_note2.' ('.$post_note3.') Sebesar Rp '.currency($post_total).'.

Jika Sudah Silahkan Klik Tombol Konfirmasi Di Halaman Rincian Pembayaran Maka Saldo Mu Akan Masuk
*NB* : Jika Tidak Ada Tombol Konfirmasi Silahkan Tunggu Sampai Saldo Mu Masuk.';
                        $textFC = 'Terima Kasih, Mohon Segera Lakukan Pembayaran Ke '.$post_note2.' ('.$post_note3.') Sebesar Rp '.currency($post_total);
                    endif;
                    
                    $post_method == 'qris2' ? $WATL->sendPicture($data_user['phone'], $textWa, $post_note, 'png') : $WATL->sendMessage($data_user['phone'], $textWa);
                    $FCM->sendNotif($call->query("SELECT * FROM users_token WHERE user = '$sess_username'")->fetch_assoc()['token'], [
                        'title' => 'Deposit '.strtoupper($post_method).' - Rp '.currency($post_amount),
                        'text' => $textFC,
                        'click_action' =>  'Open_URI',
                    ], ['picture' => '','uri' =>  base_url('deposit/konfirmasi')]);
                    redirect(0,base_url('deposit/konfirmasi'));
                } else {
                    $_SESSION['result'] = ['type' => false,'message' => 'Our server is in trouble, please try again later.'];
                }
            }
        }
    }
require _DIR_('library/header/user');
?>

    <!-- App Capsule -->
    <div id="appCapsule" class="rgs-pembayaran">
        <div class="section mt-2 mb-2">
            <? require _DIR_('library/session/result-mobile') ?>
            <ul class="listview rgs-listview image-listview mt-1">
                <li>
                    <div class="item">
                        <img src="<?= assets('mobile/img/home/deposit-rounded.png') ?>" width="36px" class="image" id="RGSLogo">
                        <div class="in">
                            <div>
                                Rp <?= currency($_POSTNominal) ?>
                                <footer>Top up Saldo <?= $_CONFIG['title'] ?></footer>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
            
            <?php
            $searchTipe = $call->query("SELECT type FROM deposit_method WHERE data != '' GROUP BY type ORDER BY name ASC");
            while($rowTipe = $searchTipe->fetch_assoc()) {
            ?>
            <div class="listview-title mt-2"><?= ucwords($rowTipe['type']) ?></div>
            <ul class="listview rgs-listview-custom image-listview">
                <?php
                $search = $call->query("SELECT * FROM deposit_method WHERE type = '".$rowTipe['type']."' AND data != '' ORDER BY name ASC");
                while($row = $search->fetch_assoc()) {
                    if($_POSTNominal < $row['min']) {
                        $class = ' rgs-disabled';
                        $text = 'Minimum Rp '.currency($row['min']);
                    } else {
                        $class = '';
                        if(!$row['keterangan']) {
                            $text = ($row['fee'] == 0) ? 'Gratis Biaya Admin' : 'Fee '.currency($row['fee']);
                        } else {
                            $text = ($row['fee'] == 0) ? $row['keterangan'] : $row['keterangan'].' - Fee '.currency($row['fee']);
                        }
                    }
                ?>
                <li>
                    <a href="javascript:;" onclick="modalKonfirmasi('Konfirmasi Deposit', '<?= base_url('konfirmasi-deposit/'.$row['code'].'RGS'.$_POSTUnik.'/'.$_POSTNominal) ?>')" class="item<?= $class ?>">
                        <img src="<?= assets('mobile/img/deposit/'.str_replace('-va','',$row['code']).'.png') ?>" alt="image" class="image rgs-deposit-image">
                        <div class="in">
                            <div></div>
                            <span class="text-muted"><?= $text ?></span>
                        </div>
                    </a>
                </li>
                <?php } ?>
            </ul>
            <?php } ?>
            
        </div>

    </div>
    <!-- * App Capsule -->

<?php require _DIR_('library/footer/user'); } ?>