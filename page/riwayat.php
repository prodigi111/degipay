<?php
require '../RGShenn.php';
require _DIR_('library/session/user');
$page = 'Riwayat';
require _DIR_('library/header/user');
?>
    <!-- App Capsule -->
    <div id="appCapsule" class="extra-header-active rgs-riwayat">
        <div class="tab-content mt-0">

            <!-- Transaksi tab -->
            <div class="tab-pane fade show active" id="Transaksi" role="tabpanel">
                <a href="#">
                <div class="alert alert-outline-primary p-1 mt-2 mr-2 ml-2 pb-1 text-white" role="alert" style="border-radius: 50px; text-decoration: none; background: #5A24A8;">
                    <div style="display: inline-flex; justify-content: space-between; align-items: center; width: 100%;">
                        <div style="display: inline-flex; justify-content: space-between; align-items: center;">
                            <div class="icon">
                                <ion-icon name="notifications" style="font-size: 26px; padding-right: 12px;"></ion-icon>
                            </div>
                            <div class="in">
                                <marquee scrollamount="10">
                  <?php
                   $i=0;

                   $qslider = mysqli_query($call, "SELECT * FROM trx WHERE DATE(date_cr) = '$date' ORDER BY id DESC LIMIT 20");

                     if (mysqli_num_rows($qslider) == 0) {
                    echo "<i class='text-white' style='margin-right: 30px;'><b>[".$date."]</b> System tidak menemukan orderan...</i>";
                    } else {


                     while($slider = mysqli_fetch_assoc($qslider))
                      {
		               $slider_userstr = "-".strlen($slider['user']);
	                   $slider_usersensor = substr($slider['user'],$slider_userstr,-4);
                       $i++;
 
                       echo "<i class='text-white' style='margin-right: 100px;'>[".$date."] <b>".$slider_usersensor."****</b> telah melakukan pembelian ".$slider['name']."</i>";
                               }
                               }
                               	?>
	                            </marquee>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
                
                 <?
			    if(isset($_GET['type']) && isset($_GET['tanggal_awal']) && isset($_GET['tanggal_akhir']) && isset($_GET['search'])){
			        $tgl_awal = date('Y-m-d',strtotime($_GET['tanggal_awal']));
			        $tgl_akhir = date('Y-m-d',strtotime($_GET['tanggal_akhir']));
				    $searchTrx = $call->query("SELECT * FROM trx WHERE user = '$sess_username' AND DATE(date_cr) BETWEEN '$tgl_awal' AND '$tgl_akhir' AND data = '".$_GET['search']."' AND trxtype = '".$_GET['type']."' ORDER BY rand() LIMIT 20");
			    }else{
				    $searchTrx = $call->query("SELECT * FROM trx WHERE user = '$sess_username' ORDER BY date_cr DESC");
			    }
                if($searchTrx->num_rows == FALSE) {
                ?>
                    <div class="text-center mt-5">
                        <img src="<?= assets('mobile/img/svg/riwayat.svg') ?>" alt="alt" class="imaged square w200">
                        <h4 class="mt-2">Anda Belum Memiliki Riwayat Transaksi</h4>
                    </div>
                <?
                } else {
                while ($rowTrx = $searchTrx->fetch_assoc()) {
                    
                    if($rowTrx['status'] == 'error') :
                        $note = 'error';
                        $btn = 'btn-danger';
                    elseif($rowTrx['status'] == 'success'):
                        $note = 'success';
                        $btn = 'btn-success';
                    else:
                        $note = 'pending';
                        $btn = 'rgs-btn-pending';
                    endif;
                    
                    if($rowTrx['trxtype'] == 'shop') :
                        $table = 'produk';
                        $column = 'kode';
                        $value = 'kategori';
                        
                    else:
                        $table = 'srv';
                        $column = 'code';
                        $value = 'brand';
                    endif;
                    
                    if($rowTrx['trxtype'] == 'donasi') :
                        $table = 'produk';
                        $column = 'kode';
                        $value = 'kategori';
                        
                    else:
                        $table = 'srv_donasi';
                        $column = 'code';
                        $value = 'brand';
                        
                    endif;
                    
                    
                ?>
                <a href="<?= base_url('order/rincian?code='.$rowTrx['wid']) ?>">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-8">
                                    <span class="tipe"><?= format_date('en',$rowTrx['date_cr']) ?></span>
                                    <span class="layanan text-dark"><?= $rowTrx['name'] ?></span>
                                    <span class="tujuan text-dark"><?= $rowTrx['data'] ?></span>
                                    <span class="date"><?= $rowMutasi['user'] ?></span>
                                </div>
                                <div class="col-4 text-right">
                                    <span class="btn <?= $btn ?> btn-status rounded"><?= $note ?></span>
                                    <span class="layanan text-white"> tes</span>
                                    <span class="harga text-danger"><strong>Rp <?= currency($rowTrx['price']) ?></strong></span>
                                    <span class="kode">#<?= $rowTrx['wid'] ?></span>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                <? } } ?>
                
            </div>
            <!-- * Transaksi tab -->

            <!-- Topup tab -->
            <div class="tab-pane fade" id="Topup" role="tabpanel">
            
                <?
                $searchDepo = $call->query("SELECT * FROM deposit WHERE user = '$sess_username' AND method != 'transfer' ORDER BY id DESC LIMIT 40");
                if($searchDepo->num_rows == FALSE) {
                ?>
                    <div class="text-center mt-5">
                        <img src="<?= assets('mobile/img/svg/riwayat.svg') ?>" alt="alt" class="imaged square w200">
                        <h4 class="mt-2">Anda Belum Memiliki Riwayat Isi Saldo</h4>
                    </div>
                <?
                } else {
                    print '<ul class="listview image-listview">';
                while ($rowDepo = $searchDepo->fetch_assoc()) {
                    $btn = 'rgs-btn-pending';
                    $note = 'pending';
                    if($rowDepo['status'] == 'cancel') :
                        $btn = 'btn-danger';
                        $note = 'cancel';
                    elseif($rowDepo['status'] == 'paid'):
                        $note = 'success';
                        $btn = 'btn-success';
                    else:
                        $btn = 'rgs-btn-pending';
                        $table = 'srv';
                        $column = 'code';
                        $value = 'brand';
                    endif;
                ?>
                    <a href="<?= base_url('deposit/invoice/'.$rowDepo['rid']) ?>">
                     <div class="card">
                        <div class="card-body">
                            <div class="row">
                              <div class="col-8">
                                <span class="date"><?= format_date('en',$rowDepo['date_cr']) ?></span>
                                <span class="layanan text-dark">Deposit #<?= $rowDepo['rid'] ?></span>
                                <span class="metod text-dark">Metode : <?= $call->query("SELECT * FROM deposit_method WHERE code = '".$rowDepo['method']."'")->fetch_assoc()['name'] ?></span>
                              </div>
                              <div class="col-4 text-right">
                                <span class="btn <?= $btn ?> btn-status rounded"><?= $note ?></span>
                                <span class="layanan text-white"> tes</span>
                                <span class="harga text-dark"><strong><?= 'Rp '.currency($rowDepo['amount']) ?> </span></strong>
                              </div>
                            </div>
                        </div>
                     </div>
                    </a>
                <? } } ?>
            </ul>

            </div>
            <!-- * Topup tab -->

            <!-- Mutasi tab -->
            <div class="tab-pane fade" id="Mutasi" role="tabpanel">
            
                <?
                $searchMutasi = $call->query("SELECT * FROM mutation WHERE user = '$sess_username' AND kategori IN ('Transaksi', 'Deposit', 'Lainnya', 'Tarik Komisi') ORDER BY id DESC LIMIT 50");
                if($searchMutasi->num_rows == FALSE) {
                ?>
                    <div class="text-center mt-5">
                        <img src="<?= assets('mobile/img/svg/riwayat.svg') ?>" alt="alt" class="imaged square w200">
                        <h4 class="mt-2">Anda Belum Memiliki Riwayat Mutasi</h4>
                    </div>
                <?
                } else {
                    print '<ul class="listview image-listview">';
                while ($rowMutasi = $searchMutasi->fetch_assoc()) {
                    if($rowMutasi['type'] == '-') :
                        $btn = 'btn-danger';
                        $note = 'kurang';
                    elseif($rowMutasi['type'] == '+'):
                        $btn = 'btn-success';
                        $note = "tambah";
                    endif;
                ?>
                    <a href="#">
                        <div class="card">
                          <div class="card-body">
                            <div class="row">
                               <div class="col-8">
                                 <span class="date"><?= format_date('en', $rowMutasi['date'].' '.$rowMutasi['time']) ?></span>
                                 <span class="layanan text-dark"><?= $rowMutasi['note'] ?></span>
                                 <span class="kategori text-dark"><?= $rowMutasi['user'] ?></span>                                 
                               </div>
                               <div class="col-4 text-right">
                                 <span class="btn <?= $btn ?> btn-status rounded"><?= $note ?></span>
                                 <span class="layanan text-white"> tes</span>
                                 <span class="harga text-dark"><strong><?= $rowMutasi['type'].'Rp '.currency($rowMutasi['amount']) ?></span></strong>
                               </div>
                            </div>   
                          </div>
                        </div>
                    </a>
                <? } } ?>
            </ul>

            </div>
            <!-- * Mutasi tab -->

        </div>
    </div>
    <!-- * App Capsule -->

<?php require _DIR_('library/footer/user') ?>