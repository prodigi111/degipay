<?php
require '../RGShenn.php';
require _DIR_('library/session/user');
$page = 'Rincian Transaksi';
if(isset($_GET['code'])) {
    $post_kode = filter($_GET['code']);
    $search = $call->query("SELECT * FROM trx WHERE wid = '$post_kode' AND user = '$sess_username'");
    if($search->num_rows == 0) redirect(1,base_url('page/riwayat'));
    $rows = $search->fetch_assoc();
    if($data_user['level'] == 'Basic' AND $rows['provider'] == 'X') {
        $price = $rows['price']+conf('trxmanual', 3);
    } else if($data_user['level'] == 'Premium' AND $rows['provider'] == 'X') {
        $price = $rows['price']+conf('trxmanual', 4);  
    } else if($data_user['level'] == 'Basic' AND $rows['provider'] == 'DIGI') {
        $price = $rows['price'];
    } else if($data_user['level'] == 'Basic' AND $rows['provider'] == 'DIGI') {
        $price = $rows['price'];
    } else if($data_user['level'] == 'Admin' AND $rows['provider'] == 'DIGI') {
        $price = $rows['price'];
    } else if($data_user['level'] == 'Admin' AND $rows['provider'] == 'X') {
        $price = $rows['price']+conf('trxmanual', 4); 
    }
   
    if ($data_user['level'] == 'Basic') {
        $admin = conf('trxadmin', 5);
    } else {
        $admin = conf('trxadmin', 6);
    }

    if($rows['status'] == 'error') :
        $label = 'danger';
        $class= '';
        $icon = 'close-circle-outline';
        $status = 'Transaksi Gagal';
    elseif($rows['status'] == 'success'):
        $label = 'success';
        $class= '';
        $icon = 'checkmark-done-outline';
        $status = 'Transaksi Berhasil';
    else:
        $label = 'warning';
        $class= 'rgs-r90';
        $icon = 'hourglass-outline';
        $status = 'Transaksi Sedang Di Proses';
    endif;
    
    if($rows['trxtype'] == 'shop') :
        $table = 'produk';
        $column = 'kode';
        $value = 'kategori';
        $type = 'SHOP';
    elseif($rows['trxtype'] == 'donasi'):
        $table = 'srv_donasi';
        $column = 'code';
        $value = 'category';
        $type = str_replace('-', ' ', strtoupper($call->query("SELECT * FROM srv_donasi WHERE code = '".$rows['code']."'")->fetch_assoc()['type']));
    elseif($rows['trxtype'] == 'manual'):
        $table = 'trx';
        $column = 'code';
        $value = 'name';
        $type = 'Manual Transaksi';
    elseif($rows['trxtype'] == 'bank'):
        $table = 'trx';
        $column = 'code';
        $value = 'name';
        $type = 'Bank Transfer';
    else:
        $table = 'srv';
        $column = 'code';
        $value = 'brand';
        $type = str_replace('-', ' ', strtoupper($call->query("SELECT * FROM srv WHERE code = '".$rows['code']."'")->fetch_assoc()['type']));
    endif;
    
    $stat = $rows['status'] == 'error' && $rows['refund'] == '1' ? 'Refund' : $rows['status'];
} else {
    redirect(0, base_url('page/riwayat'));
}

require _DIR_('library/header/user');
?>

    <!-- App Capsule -->
    <div id="appCapsule" class="rgs-konfirmasi">
        <div class="section rgs-rincian-deposit">

            <div class="text-center">
                <button type="button" class="btn btn-icon btn-lg">
                    <ion-icon name="<?= $icon ?>" class="<?= $class ?>"></ion-icon>
                </button>
                <h4 class="text-white"><?= $status ?></h4>
            </div>

            <div class="card mt-2">
                <div class="card-body">
                    <ul class="listview image-listview no-line no-space flush mb-1">
                        <li>
                            <div class="item">
                                <? if($rows['trxtype'] == 'shop') : ?>
                                    <div class="icon-box bg-primary">
                                        <ion-icon name="storefront-outline"></ion-icon>
                                    </div>
                                <? elseif($rows['trxtype'] == 'manual'): ?>
                                    <div class="icon-box bg-primary">
                                        <ion-icon name="storefront-outline"></ion-icon>
                                    </div>
                                <? elseif($rows['trxtype'] == 'bank'): ?>
                                    <div class="icon-box bg-primary">
                                        <ion-icon name="paper-plane-outline"></ion-icon>
                                    </div>
                                <? else: ?>
                                    <img src="<?= assets('mobile/img/home/'.$call->query("SELECT * FROM srv WHERE code = '".$rows['code']."'")->fetch_assoc()['type'].'.svg') ?>" width="44px" class="image" id="RGSLogo">
                                <? endif ?>
                                <div class="in">
                                    <div>
                                        <span><?= $type ?></span>
                                        <footer><?= $rows['name'] ?></footer>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                    
                    <div class="more-info accordion pt-1" id="expandPembayaran">
                        <div class="accordion-header">
                            <button class="btn p-0 text-white" type="button" data-toggle="collapse" data-target="#show" aria-expanded="false">
                                INFORMASI TRANSAKSI
                            </button>
                        </div>
                        <div id="show" class="accordion-body collapse show" data-parent="#expandPembayaran">
                            <div class="accordion-content">
                                <? if($rows['trxtype'] === 'shop') : ?>
                                <div class="trans-id">
                                    <div class="text-muted">Tujuan Pengisian</div>
                                    <div class="rgs-text-rincian"><?= $rows['data'] ?></div>
                                </div>
                                <? elseif($rows['trxtype'] === 'bank') : ?>
                                <div class="trans-id">
                                    <div class="text-muted">Rekening Tujuan</div>
                                    <div class="rgs-text-rincian"><?= $rows['data'] ?></div>
                                </div>
                                <? endif ?> 
                                <div class="trans-id">
                                    <div class="text-muted">Tujuan Pengisian</div>
                                    <div class="rgs-text-rincian"><?= $rows['data'] ?></div>
                                </div>
                                <div class="trans-id">
                                    <div class="text-muted">Kategori</div>
                                    <div class="rgs-text-rincian"><?= strtoupper($call->query("SELECT * FROM $table WHERE $column = '".$rows['code']."'")->fetch_assoc()[$value]) ?></div>
                                </div>
                                <div class="trans-id">
                                    <div class="text-muted">ID Transaksi</div>
                                    <div class="rgs-text-rincian"><?= $post_kode ?></div>
                                </div>
                                <div class="trans-id">
                                    <div class="text-muted">Waktu Transaksi</div>
                                    <div class="rgs-text-rincian"><?= format_date('id', $rows['date_cr']) ?></div>
                                </div>
                                <div class="trans-id">
                                    <div class="text-muted">Poin</div>
                                    <div class="rgs-text-rincian">+5</div>
                                </div>
                                <div class="trans-id">
                                    <div class="text-muted">Status Transaksi</div>
                                    <div class="rgs-text-rincian text-<?= $label ?>"><?= ucwords($stat) ?></div>
                                </div>
                                <? if($rows['status'] <> 'processing') : ?>
                                <div class="text-muted mt-1">Keterangan</div>
                                <div class="rgs-rincian-keterangan">
                                    <div class="rgs-text-rincian"><?= nl2br($rows['note']) ?></div>
                                </div>
                                <? endif; ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="more-info accordion pt-2" id="expandinfo">
                        <div class="accordion-header">
                            <button class="btn p-0 text-white" type="button" data-toggle="collapse" data-target="#show1" aria-expanded="false">
                                INFORMASI TAGIHAN
                            </button>
                        </div>
                        <div id="show1" class="accordion-body collapse show" data-parent="#expandinfo">
                            <div class="accordion-content">
                                <? if($rows['trxtype'] === 'donasi') : ?>
                                <div class="trans-id">
                                    <div class="text-muted">Harga</div>
                                    <div class="rgs-text-rincian">Rp <?= currency($rows['price']) ?></div>
                                </div>
                                <? elseif($rows['trxtype'] === 'bank') : ?>
                                <div class="trans-id">
                                    <div class="text-muted">Nominal Transfer</div>
                                    <div class="rgs-text-rincian">Rp <?= currency($rows['price']) ?></div>
                                </div>
                                <? else: ?>
                                <div class="trans-id">
                                    <div class="text-muted">Harga</div>
                                    <div class="rgs-text-rincian">Rp <?= currency($price) ?></div>
                                </div>
                                <? endif; ?>
                                <? if($rows['trxtype'] === 'bank') : ?>
                                <div class="trans-id">
                                     <div class="text-muted">Biaya Transfer</div>
                                     <div class="rgs-text-rincian text-warning">Rp <?= currency($admin) ?></div>
                                </div>
                                <? else: ?> 
                                <div class="trans-id">
                                    <div class="text-muted">Biaya Transaksi</div>
                                    <? if($data_user['level'] == 'Basic' AND $rows['provider'] == 'X') : ?>
                                    <div class="rgs-text-rincian text-warning"><?= conf('trxadmin', 3) ?></div>
                                    <? elseif($data_user['level'] == 'Premium' AND $rows['provider'] == 'X'): ?>
                                    <div class="rgs-text-rincian text-warning">Rp <?= currency(conf('trxadmin', 4)) ?></div>
                                    <? elseif($data_user['level'] == 'Basic' AND $rows['provider'] == 'DIGI'): ?>
                                    <div class="rgs-text-rincian text-warning">Rp <?= currency(conf('trxadmin', 3)) ?></div>
                                    <? elseif($data_user['level'] == 'Premium' AND $rows['provider'] == 'DIGI'): ?>
                                    <div class="rgs-text-rincian text-warning">Rp <?= currency(conf('trxadmin', 4)) ?></div>
                                    <? elseif($data_user['level'] == 'Admin' AND $rows['provider'] == 'X'): ?>
                                    <div class="rgs-text-rincian text-warning">Rp <?= currency(conf('trxadmin', 4)) ?></div>
                                    <? elseif($data_user['level'] == 'Admin' AND $rows['provider'] == 'DIGI'): ?>
                                    <div class="rgs-text-rincian text-warning">Rp <?= currency(conf('trxadmin', 4)) ?></div>
                                    <? endif ?>
                                </div>
                                <? endif; ?>
                            </div>
                        </div>
                    </div>
                    <? if($rows['trxtype'] === 'donasi') : ?>
                    <div class="trans-id rgs-bg-rincian text-dark mt-2">
                        <div>Total Donasi</div>
                        <div>Rp <?= currency($rows['price']) ?></div>
                    </div>
                    <? else: ?>
                    <div class="trans-id rgs-bg-rincian text-dark mt-2">
                        <div>Total Pembayaran</div>
                        <div>Rp <?= currency($rows['price']) ?></div>
                    </div>
                    <? endif; ?>
                    <div class="text-dark rgs-rincian text-center mt-2">
                        <div><b>HALAMAN INI DAPAT DIJADIKAN SEBAGAI BUKTI</b></div>
                        <div><b>PEMBAYARAN YANG SAH</b></div>
                    </div>
                </div>
            </div>
            <div class="form-button rgs-detail-transfer bg-primary text-center">
            <div class="row">
                    <div class="col-6">
                        <!--<a href="my.bluetoothprint.scheme://https://server.app.gocapay.com/order/invoice.php?code=<?= $post_kode ?>" class="text-white ">-->
                        <a onclick="$('#modal-change-print').modal('show');" class="text-white ">
                            
                            <div class="menu-item" onmousedown="click_menu(this)" onmouseup="clear_menu(this)">
                                <ion-icon name="print-outline"></ion-icon>
                                <span>Cetak Struk </span>
                            </div>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="<?= base_url('page/contact') ?>" class="text-white">
                            <div class="menu-item" onmousedown="click_menu(this)" onmouseup="clear_menu(this)">
                                <ion-icon name="headset-outline"></ion-icon>
                                <span>Hubungi CS</span>
                            </div>
                        </a>
                    </div>
                </div>
                <a href="<?= base_url('index.php') ?>" class="btn rounded shadowed btn-block btn-lg mt-3 mb-2 text-primary" style="background: #f7fbfc;">Selesai</a>
            </div>

        </div>
    </div>
    <!-- * App Capsule -->
    
    
<!-- Modal -->
<div class="modal fade" id="modal-change-print" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-body">
          <h5>Custom print value</h5>
          
          <form action="my.bluetoothprint.scheme://https://degipay.id/order/invoice.php" method="get">
            <input type="hidden" name="code" value="<?= $post_kode ?>">

            <div class="form-group">
                <label for="price" class="text-secondary">Harga Jual</label>
                <input type="number" name="price" id="price" class="form-control" value="<?= ($rows['trxtype'] === 'donasi')? $rows['price']: $price; ?>">
            </div>
            <div class="form-group">
                <label for="price" class="text-secondary">Header/Nama Toko</label>
                <textarea name="header" id="header" rows="3" class="form-control">TOKO DEGIPAY.ID</textarea>
            </div>
            <div class="form-group">
                <label for="price" class="text-secondary">Footer</label>
                <textarea name="footer" id="footer" rows="3" class="form-control">TERIMA KASIH TELAH BERTRANSAKSI DITOKO KAMI</textarea>
            </div>
          </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" onclick="$('#panduan').modal('show');" class="btn btn-warning" >Panduan</button>
        <button type="button" onclick="$('#modal-change-print form').submit()" class="btn btn-success">Print Now</button>
      </div>
    </div>
  </div>
</div>
<!-- panduan -->
<div class="modal fade action-sheet" id="panduan" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Deskripsi</h5>
                </div>
                <div class="modal-body p-2">
                    <h6>
                        Panduan Cetak Struk
                    </h6>
                    <h6>
                        Silahkan dowload aplikasi bluetooth di playstore agar bisa dapat melakukan cetak struk dan sebelum print silahkan ubah harga jual ataupun
                        nama toko anda di bagian print value.
                    </h6>
                </div>
            </div>
        </div>
    </div>

<?php require _DIR_('library/footer/user') ?>