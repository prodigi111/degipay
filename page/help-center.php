<?php 
require '../RGShenn.php';
require _DIR_('library/session/user');
$page = 'Pusat Bantuan';
require _DIR_('library/header/user');

function card($i, $title, $konten) {
    return '<div class="item">
                <div class="accordion-header">
                    <button class="btn collapsed" type="button" data-toggle="collapse" data-target="#faq'.$i.'">
                        '.$title.'
                    </button>
                </div>
                <div id="faq'.$i.'" class="accordion-body collapse" data-parent="#general">
                    <div class="accordion-content">
                        '.$konten.'
                    </div>
                </div>
            </div>';
}
?>

    <!-- App Capsule -->
    <div id="appCapsule" class="rgs-other">
        <div class="section text-center">
            <img src="<?= assets('mobile/img/svg/question.svg'); ?>" alt="image" class="imaged w200">
        </div>

        <div class="section full">
            <div class="section-title">Selamat datang di Pusat Bantuan</div>
            <div class="wide-block pt-2 pb-2">
                Kamu dapat menemukan jawaban atas pertanyaan Kamu di sini.
            </div>
        </div>

        <div class="section full mt-2">
            <div class="section-title">Informasi Umum</div>

            <div class="accordion" id="general">
                <?= card('1', 'Cara melakukan order ?', 'Untuk melakukan order Anda harus memiliki saldo yang cukup. Masuk ke halaman Dashboard, Silahkan pilih layanan sesuai kebutuhan anda') ?>
                <?= card('2', 'Cara melakukan Deposit / Isi Saldo ?', 'Untuk melalukan deposit saldo anda pergi ke halaman Dashboard Silahkan klik Isi Saldo, Jika anda ingin melakukan deposit manual bisa hubungi admin.') ?>
                <?= card('3', 'Jika Orderan saya Error ?', 'Jika orderan kalian status nya Error maka otomatis saldo kalian akan dikembalikan (Reffund) dengan estimasi waktu 1-5 menit dari status Error tersebut') ?>
                <?= card('4', 'Jika orderan saya bermasalah ?', 'Mohon menunggu selama 1x24 jam, orderan stuck kemungkinan dikarenakan server yang sedang Overload. Harap bersabar dan jika lebih dari 1x24 jam orderan tetap stuck, segera komplain ke Kontak Admin') ?>
                <?= card('5', 'Apa Cut OFF ?', 'Batas waktu untuk melakukan transaksi, Beberapa layanan kami melakukan Cut OFF pada pukul 23.30 s/d 00.30 Silahkan alihkan ke layanan atau produk lain') ?>
            </div>
        </div>
        <div class="section full mt-2">
            <div class="section-title">Voucher dan Token</div>

            <div class="accordion" id="general">
                <?= card('6', 'Dimana melihat Kode Voucher ?', 'Setelah transaksi berhasil silahkan buka Riwayat -> Klik Riwayat Voucher -> Kode Voucher berada di KETERANGAN') ?>
                <?= card('7', 'Dimana melihat Nomer Token ?', 'Setelah transaksi berhasil silahkan buka Riwayat -> Klik Riwayat Pembelian Token -> Kode Token berada di KETERANGAN') ?>
            </div>
        </div>
    </div>
    <!-- * App Capsule -->

<?php require _DIR_('library/footer/user') ?>