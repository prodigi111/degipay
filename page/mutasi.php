<?php
require '../RGShenn.php';
require _DIR_('library/session/user');
$page = 'Mutasi';
require _DIR_('library/header/user');
?>
    <!-- App Capsule -->
    <div id="appCapsule" class="extra-header-active rgs-mutasi">
            <!-- Mutasi tab -->
            
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
            <!-- * Mutasi tab -->
    </div>
    <!-- * App Capsule -->

<?php require _DIR_('library/footer/user') ?>