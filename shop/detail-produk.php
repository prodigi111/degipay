<?php
require '../RGShenn.php';
require _DIR_('library/session/user');

$get = isset($_GET['rgs']) ? filter($_GET['rgs']) : '';
$search = $call->query("SELECT * FROM produk WHERE kode = '$get' AND status = 'READY'");
if($search->num_rows == 0) exit(redirect(0,base_url('shop/')));
$data = $search->fetch_assoc();

$image = json_decode($data['image'], TRUE);

require 'action.php';
$page = isset($_SESSION['success']) ? 'Pembayaran Berhasil' : 'Detail Produk';
require _DIR_('library/header/user');
?>

<? if(isset($_SESSION['success'])) :  ?>

    <? require _DIR_('order/result') ?>

<? unset($_SESSION['success']); else: ?>

    <!-- App Capsule -->
    <div id="appCapsule" class="rgs-shop">
        
        <!-- carousel -->
        <div class="carousel-full owl-carousel owl-theme">
            <? for($i = 0; $i <= count($image['data'])-1; $i++) { ?>
            <div class="item">
                <img src="<?= assets('images/produk/').$image['data'][$i]['image'] ?>" alt="alt" class="imaged w-100 square">
            </div>
            <? } ?>
        </div>
        <!-- * carousel -->
        
        <div class="section full">
            <div class="wide-block pt-2 pb-2 product-detail-header">
                <h1 class="title"><?= $data['nama'] ?></h1>
                <div class="detail-footer">
                    <div class="price">
                        <div class="current-price">Rp <?= currency($data['harga']) ?></div>
                    </div>
                </div>
                <a href="javascript:;" onclick="modalKonfirmasi('Konfirmasi Transaksi', '<?= base_url('shop/konfirmasi/').$data['kode'] ?>')" class="btn btn-primary btn-lg btn-block">
                    <ion-icon name="cart-outline"></ion-icon>
                    Beli
                </a>
            </div>
        </div>
        
        <div class="section mt-1">
            <? require _DIR_('library/session/result-mobile') ?>
        </div>

        <div class="section full mt-1">
            <div class="section-title">Keterangan</div>
            <div class="wide-block pt-2 pb-2">
                <?= nl2br($data['keterangan']) ?>
                <hr>
                Dengan Klik <b>BELI</b> Berarti Anda Sudah Menyetujui Syarat Dan Ketentuan Dibawah.
            </div>
        </div>

        <div class="section full mt-1">
            <div class="section-title">Syarat Dan Ketentuan</div>
            <div class="wide-block pt-2 pb-2">
                <span style="white-space: pre-line;">- Sebelum Membeli Silahkan Baca Kembali Detail Layanan
- Maksimal Pengerjaan 1X24 Jam
- Kirimkan Detail yang diminta ke Whatssapp Admin dengan menyertakan ID Transaksi
- Akun/File Akan Dikirimkan Langsung Ke Whatsapp Anda
- Setelah File/Akun di kirim dan di terima silahkan cek kembali File/Akunnya, Apabila sudah cocok/ada masalah Silahkan konfirmasi Admin
- Setelah File/Akun di kirim dan di terima Selama 1x24 Jam, Tetapi tidak ada konfirmasi dari Pembeli maka kami anggap SELESAI
- Setelah 1x24 Jam File/Akun di terima, kami tidak menerima KOMPLAIN APAPUN
                </span>
            </div>
        </div>
        
    </div>
    <!-- * App Capsule -->

<? endif ?>   
<?php require _DIR_('library/footer/user') ?>