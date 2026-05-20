<?php 
require '../RGShenn.php';
require _DIR_('library/session/user');
$page = 'Syarat & Ketentuan';
require _DIR_('library/header/user');

function UlLi($x) {
    $out = ''; $no = 1; foreach($x as $key => $value) {
        $out .= '<p><button type="button" class="btn btn-primary">'.$no.'. '.ucwords(strtolower($key)).'</button>';
        for($i = 0; $i <= count($value)-1; $i++) $out .= '<p><b>'.($i+1).'.</b> '.$value[$i].'</p>';
        $out .= '</p>'; $no++;
    } return $out;
}
?>

    <!-- App Capsule -->
    <div id="appCapsule">
        <div class="section full">
            <div class="wide-block pt-2 pb-1">
            <p><b>Syarat & Ketentuan</b> yang ditetapkan di bawah ini mengatur pemakaian atau penggunaan aplikasi <?= $_CONFIG['title'] ?>. Pengguna disarankan membaca dengan seksama sebelum melakukan transaksi dan/atau menggunakan aplikasi <?= $_CONFIG['title'] ?>.</p>
            <p>Dengan mendaftar dan/atau menggunakan Aplikasi <?= $_CONFIG['title'] ?>, maka pengguna dianggap telah membaca, mengerti, memahami dan menyetujui semua isi dalam syarat & ketentuan yang berlaku.</p>
            <p>Jika pengguna tidak menyetujui salah satu, sebagian, atau seluruh isi syarat & ketentuan yang berlaku saat ini, maka pengguna tidak diperkenankan menggunakan layanan Aplikasi / Layanan yang diberikan <?= $_CONFIG['title'] ?>.</p><br>

	<div class="terms-box">
		<h3>DEFINISI</h3>	
			<ul class="simple-list">
				<p class="p-lg">1. <?= $_CONFIG['title'] ?> adalah suatu bisnis rintisan usaha Penyedia Layanan/Distributor & Agen Pulsa All Operator.</p>
				<p class="p-lg">2. Syarat & ketentuan adalah perjanjian antara Pengguna dan <?= $_CONFIG['title'] ?> yang berisikan seperangkat peraturan yang mengatur hak, kewajiban, tanggung jawab pengguna dan <?= $_CONFIG['title'] ?>, serta tata cara penggunaan sistem layanan <?= $_CONFIG['title'] ?>.</p>
				<p class="p-lg">3. Pengguna adalah pihak yang menggunakan atau terdaftar menjadi member dari layanan <?= $_CONFIG['title'] ?>, termasuk namun tidak terbatas pada pembeli, penjual ataupun pihak lain yang sekedar berkunjung ke aplikasi <?= $_CONFIG['title'] ?>.</p>
			    <p class="p-lg">4. Member adalah Pengguna terdaftar yang melakukan Deposit Saldo, Transaksi Produk yang dijual di aplikasi <?= $_CONFIG['title'] ?>.</p>
                <p class="p-lg">5. Produk adalah berupa Pulsa, Voucher Game, Token Listrik, Dll yang di beli oleh member di aplikasi <?= $_CONFIG['title'] ?></p>
			</ul>
	</div>
<br>
<div class="terms-box">
		<h3>AKUN, SALDO DAN KEAMANAN</h3>	
			<ul class="simple-list">
<p class="p-lg">1.	Anda dengan ini menyatakan bahwa Anda adalah orang yang cakap / pintar dalam menggunakan Aplikasi <?= $_CONFIG['title'] ?>.</p>
<p class="p-lg">2.	<?= $_CONFIG['title'] ?> tidak memungut biaya pendaftaran kepada pengguna / member satu rupiah pun.</p>
<p class="p-lg">3.	Pengguna yang telah mendaftar dan memverifikasi akun, berhak melakukan Deposit Saldo ataupun Transaksi di aplikasi <?= $_CONFIG['title'] ?>.</p>
<p class="p-lg">4.	Pengguna harus memahami bahwa semua data yang diperlukan oleh aplikasi <?= $_CONFIG['title'] ?> adalah data yang valid, jika tidak demikian maka sistem kami akan menghapus data anda secara permanen.</p>
<p class="p-lg">5.	<b>Saldo tidak dapat dicairkan atau diuangkan</b>, saldo hanya dapat digunakan untuk melakukan transaksi.</p>
<p class="p-lg">6.	<?= $_CONFIG['title'] ?> dengan atau tanpa pemberitahuan terlebih dahulu kepada Pengguna, memiliki kewenangan untuk melakukan tindakan yang perlu atas setiap dugaan pelanggaran atau pelanggaran Syarat & ketentuan dan/atau hukum yang berlaku, yakni melakukan deposit atau pengisian saldo melalui cara yang terindikasi ilegal, melakukan tindakan hacking di aplikasi <?= $_CONFIG['title'] ?>, serta tindakan lain yang dapat menimbulkan kerusakan dan/atau kerugian pada layanan <?= $_CONFIG['title'] ?>.</p>
<p class="p-lg">7.	<b><?= $_CONFIG['title'] ?> memiliki kewenangan untuk menutup akun Pengguna baik sementara maupun permanen</b> apabila didapati adanya tindakan kecurangan dalam bertransaksi dan/atau pelanggaran terhadap syarat dan ketentuan <?= $_CONFIG['title'] ?>.</p>
<p class="p-lg">8.	Pengguna dilarang untuk menciptakan dan/atau menggunakan perangkat, software, fitur dan/atau alat lainnya yang bertujuan untuk melakukan manipulasi pada sistem <?= $_CONFIG['title'] ?>, termasuk namun tidak terbatas pada : (i) manipulasi data Sistem; (ii) kegiatan perambanan (crawling/scraping); (iii) kegiatan otomatisasi dalam transaksi, jual beli, promosi, dsb; dan/atau (v) aktivitas lain yang secara wajar dapat dinilai sebagai tindakan manipulasi sistem.</p>
<p class="p-lg">9.	<b><?= $_CONFIG['title'] ?> memiliki kewenangan untuk melakukan pembekuan/pengurangan saldo <?= $_CONFIG['title'] ?> dengan/tanpa pemberitahuan sebelumnya</b>, apabila ditemukan / diduga adanya tindak kecurangan dalam bertransaksi dan/atau pelanggaran terhadap syarat dan ketentuan <?= $_CONFIG['title'] ?>.</p>
<p class="p-lg">10.	Pengguna memiliki hak untuk mengubah Alamat Email Akun, karena email merupakan identitas setiap dan harus merupakan email aktif.</p>
<p class="p-lg">11.	Pengguna bertanggung jawab secara pribadi untuk menjaga kerahasiaan akun dan pin untuk semua aktivitas yang terjadi dalam akun Pengguna.</p>
<p class="p-lg">12.	<?= $_CONFIG['title'] ?> tidak akan meminta pin maupun kode OTP milik akun Pengguna untuk alasan apapun, oleh karena itu <?= $_CONFIG['title'] ?> menghimbau Pengguna agar tidak memberikan data tersebut maupun data penting lainnya kepada pihak yang mengatasnamakan <?= $_CONFIG['title'] ?> atau pihak lain yang tidak dapat dijamin keamanannya.</p>
<p class="p-lg">13.	Pengguna dengan ini menyatakan bahwa <?= $_CONFIG['title'] ?> tidak bertanggung jawab atas kerugian atau kerusakan yang timbul dari penyalahgunaan akun Pengguna.</p>
</ul>
	</div>
<br>
<div class="terms-box">
		<h3>DEPOSIT SALDO</h3>	
			<ul class="simple-list">
<p class="p-lg">1.	Deposit adalah suatu proses pengisian saldo akun <?= $_CONFIG['title'] ?> yang dilakukan oleh Member melalui metode pembayaran yang disediakan oleh <?= $_CONFIG['title'] ?>.</p>
<p class="p-lg">2.	Saldo <?= $_CONFIG['title'] ?> adalah pembayaran utama dalam melakukan transaksi pembelian produk di aplikasi <?= $_CONFIG['title'] ?>.</p>
<p class="p-lg">3.	Saldo <?= $_CONFIG['title'] ?> dapat ditambahkan melalui transfer bank kepada rekening <?= $_CONFIG['title'] ?> maupun metode pembayaran lain yang tersedia sejumlah yang ingin ditambahkan.</p>
<p class="p-lg">4.	<b><?= $_CONFIG['title'] ?> berhak melakukan pembekuan/pengurangan saldo dengan/tanpa pemberitahuan sebelumnya</b> jika pengguna terbukti melakukan pelanggaran sesuai yang di atur dalam Syarat & Ketentuan serta Kebijakan Privasi <?= $_CONFIG['title'] ?>.</p>
<p class="p-lg">5.	<?= $_CONFIG['title'] ?> akan membantu melalui CS kami jika mendapatkan masalah dalam melakukan Deposit Saldo.</p>
<p class="p-lg">6.	Deposit yang telah terproses dan masuk ke saldo akun <?= $_CONFIG['title'] ?> bersifat <b>non-refundable atau tidak dapat dikembalikan</b>.</p>
</ul>
	</div>
<br>
<div class="terms-box">
		<h3>TRANSAKSI PEMBELIAN</h3>	
			<ul class="simple-list">
<p class="p-lg">1.	Member wajib bertransaksi melalui prosedur transaksi yang telah ditetapkan oleh <?= $_CONFIG['title'] ?>. Member melakukan pembayaran dengan menggunakan Saldo <?= $_CONFIG['title'] ?> milik member.</p>
<p class="p-lg">2.	Saat melakukan Transaksi Pembelian, Member menyetujui bahwa:</p>
								<ul class="simple-list">
									<li class="list-item">
										<p class="p-lg">Member bertanggung jawab untuk membaca, memahami dan menyetujui informasi/deskripsi keseluruhan Produk sebelum melakukan transaksi pulsa.
										</p>
									</li>
									<li class="list-item">
										<p class="p-lg">Pengguna masuk ke dalam kontrak yang mengikat secara hukum untuk Transaksi Pembelian ketika Pengguna melakukan transaksi pembelian produk.
										</p>
									</li>
								</ul>
<p class="p-lg">3.	Member/Pengguna memahami dan menyetujui bahwa ketersediaan Produk merupakan tanggung jawab <?= $_CONFIG['title'] ?>. Terkait ketersediaan Produk dapat berubah sewaktu-waktu, sehingga dalam keadaan stok Produk kosong, maka Sistem akan menolak Transaksi pembelian dan pembayaran atas produk yang bersangkutan.</p>
<p class="p-lg">4.	Member memahami sepenuhnya dan menyetujui bahwa segala transaksi yang dilakukan antar Member dan <?= $_CONFIG['title'] ?> melalui Saldo <?= $_CONFIG['title'] ?>.</p>
<p class="p-lg">5.	Member memahami bahwa transaksi pembelian akan melakukan pemotongan saldo jika status transaksi <b>PROSES & BERHASIL</b>, Saldo akan di kembalikan jika status transaksi <b>ERROR Atau GAGAL</b>.</p>
<p class="p-lg">6.	Dalam hal terjadinya kendala pada transaksi, termasuk tetapi tidak terbatas pada: transaksi berstatus berhasil namun produk belum diterima oleh Member atau transaksi berstatus gagal namun saldo berkurang atau sebab-sebab lainnya, Member dapat memberitahuan kepada <?= $_CONFIG['title'] ?> melalui layanan pelanggan yang tersedia selambat-lambatnya 1x24 jam sejak tanggal transaksi dilakukan.</p>
<p class="p-lg">7.	Detail dari Transaksi Pembelian dapat dilihat di halaman <b>"Riwayat Transaksi"</b>.</p>
<p class="p-lg">8.	Member tidak mempunyai hak untuk membatalkan/menghapus transaksi dan riwayat transaksi yang dilakukan.</p>
<p class="p-lg">9.	Member memahami bahwa dalam melakukan transaksi yang mengakibatkan berkurangnya saldo dilakukan secara sadar oleh member.</p>
</ul>
	</div>
<br>
<div class="terms-box">
		<h3>HARGA PRODUK</h3>	
			<ul class="simple-list">
<p class="p-lg">1.	<?= $_CONFIG['title'] ?> berupaya menyediakan produk dengan harga semurah mungkin.</p>
<p class="p-lg">2.	Pengguna memahami bahwa Harga Produk <?= $_CONFIG['title'] ?> dapat berubah sewaktu - waktu tanpa pemberitahuan sebelumnya.</p>
<p class="p-lg">3.	Harga Produk yang tertera di situs <?= $_CONFIG['title'] ?> merupakan harga produk final yang nantinya akan di bayarkan oleh member saat transaksi produk.</p>
<p class="p-lg">4.	Dengan melakukan transaksi pembelian melalui <?= $_CONFIG['title'] ?>, Pengguna menyetujui untuk membayar sejumlah harga produk yang di tentukan yang nantinya akan di potong dari saldo <?= $_CONFIG['title'] ?>.</p>
</ul>
	</div>
<br>
<div class="terms-box">
		<h3>PENGEMBALIAN DANA</h3>	
			<ul class="simple-list">
<p class="p-lg">1.	Program Pengembalian Dana atau disebut <b>REFUND</b> merupakan fitur perlindungan kepada member dalam bertransaksi jika dalam transaksi mengalami pemotongan saldo tetapi produk yang di beli tidak sampai kepada pembeli.</p>
<p class="p-lg">2.	<b>REFUND</b> Transaksi dapat dilakukan jika transaksi mendapatkan status sukses tetapi Produk yang di beli tidak masuk kepada pembeli.</p>
<p class="p-lg">3.	<b>REFUND</b> Transaksi dapat dilakukan dengan menghubungi layanan pelanggan <?= $_CONFIG['title'] ?> dengan menyebutkan ID Transaksi yang tertera pada Riwayat Transaksi maksimal 7x24 jam sejak tanggal transaksi dilakukan.</p>
<p class="p-lg">4.	<b>REFUND</b> Transkasi dapat diberikan jika CS kami sudah melakukan pengecekan dan telah di pastikan produk tidak masuk kepada pembeli.</p>
<p class="p-lg">5.	Jika dalam REFUND Transaksi member telah melakukan komplain kepada CS dan CS telah memastikan bahwa Produk masuk kepada pembeli tetapi pembeli merasa belum menerima produk yang di beli, disarankan untuk menghubungi Call Center dari Operator/Provider produk.</p>
<p class="p-lg">6.	<b>REFUND</b> Transaksi tidak dapat dilakukan jika kami memastikan Produk telah VALID Terkirim kepada pembeli.</p>
</ul>
	</div>
<br>
<div class="terms-box">
		<h3>TRANSFER SALDO</h3>	
			<ul class="simple-list">
<p class="p-lg">1.	Fitur Transfer Saldo adalah fitur yang digunakan untuk mengirim/berbagi saldo dengan member/downline anda yang berfungsi untuk membantu member/downline anda yang tidak dapat melakukan deposit saldo melalui transfer bank, anda dapat menggunakan fitur ini untuk menambahkan saldo Member/Downline anda.</p>
<p class="p-lg">2.	Anda tidak dapat melakukan transfer saldo ke akun anda sendiri.</p>
<p class="p-lg">3.	Anda harus memiliki saldo minimal Rp 100.000 untuk melakukan transfer saldo.</p>
<p class="p-lg">4.	Minimal Saldo yang anda transfer adalah Rp 25.000.</p>
<p class="p-lg">5.	Lakukan pengecekan nomor tujuan transfer terlebih dahulu untuk memeriksa tujuan transfer anda apakah sudah benar atau belum.</p>
<p class="p-lg">6.	Demi keamanan dalam fitur ini, anda di wajibkan untuk memasukkan pin akun anda agar transfer saldo di pastikan dilakukan oleh anda.</p>
<p class="p-lg">7.	Kami tidak bertanggung jawab jika anda salah dalam transfer saldo ke member/downline anda.</p>
<p class="p-lg">8.	Layanan ini hanya tersedia untuk <b>Member Premium</b>.</p>
</ul>
	</div>
<br>
<div class="terms-box">
		<h3>REFERRAL</h3>	
			<ul class="simple-list">
<p class="p-lg">1.	Referral merupakan program untuk mengajak orang bergabung di <?= $_CONFIG['title'] ?>.</p>
<p class="p-lg">2.	Setiap orang yang diajak dan melakukan transaksi di <?= $_CONFIG['title'] ?> maka anda mendapatkan komisi Rp.10 tiap transaksi sukses.</p>
<p class="p-lg">3.	Bonus referal berupa komisi yang bersifat tidak terbatas & bisa ditukar dengan saldo <?= $_CONFIG['title'] ?>.</p>
</ul>
	</div>
<br>
<div class="terms-box">
		<h3>LAIN-LAIN</h3>	
			<ul class="simple-list">
<p class="p-lg">1.	Syarat & Ketentuan ini berlaku efektif terhitung sejak Anda pertama kali mengakses Aplikasi dan berlaku seterusnya.</p>
<p class="p-lg">2.	Kami berhak untuk sewaktu-waktu mengubah Syarat & Ketentuan ini. Anda dapat mengakses setiap perubahan Syarat & Ketentuan ini melalui Aplikasi. Anda dianggap menyetujui dan tunduk pada perubahan Syarat & Ketentuan ini dengan tetap menggunakan Aplikasi. Anda bebas untuk tidak menggunakan Aplikasi dalam hal Anda tidak menyetujui perubahan Syarat & Ketentuan tersebut.</p>
</ul>
	</div>
<br>
<br>
<h3>Diperbaharui: 26 Mei 2022</h3>
            </div>
        </div>
    </div>
    <!-- * App Capsule -->

<?php require _DIR_('library/footer/user') ?>