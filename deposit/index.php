<?php
require '../RGShenn.php';
require _DIR_('library/session/user');
$page = 'Saldo';
require _DIR_('library/header/user');
?>

    <!-- App Capsule -->
    <div id="appCapsule" class="rgs-riwayat">
        
        <div class="section full bg-primary text-center pl-2 pr-2" style="margin-bottom:-55px;">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="app-list">
                                <div class="text-left text-dark">Saldo Anda</div>
                                <div class="text-right"><a href="<?= base_url('deposit/deposit') ?>" class="btn btn-primary menu rounded">+</a></div>
                                <div class="text-dark text-left"><b>Rp <?= currency($data_user['balance']) ?></b></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        
        <ul class="nav nav-tabs lined bg-white pt-5" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#isi-saldo" role="tab" aria-selected="true">
                    Isi Saldo
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#mutasi-saldo" role="tab" aria-selected="false">
                    Mutasi Saldo
                </a>
            </li>
        </ul>
        
        <div class="tab-content">
            <!-- isi-saldo tab -->
            <div class="tab-pane fade active show" id="isi-saldo" role="tabpanel">
                <?
                $searchDepo = $call->query("SELECT * FROM deposit WHERE user = '$sess_username' AND method != 'transfer' ORDER BY id DESC LIMIT 40");
                if($searchDepo->num_rows == FALSE) {
                ?>
                    <div class="text-center" style="margin-top:125px;">
                        <img src="<?= assets('mobile/img/gif/notrx.gif') ?>" alt="alt" class="imaged square w200">
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
                                <span class="harga text-dark"><strong><?= 'Rp '.currency($rowDepo['amount']) ?> </span></strong>
                                <span class="spasi"></span>
                                <span class="btn <?= $btn ?> btn-status rounded"><?= $note ?></span>
                              </div>
                            </div>
                        </div>
                     </div>
                    </a>
                <? } } ?>
            </ul>

          </div>
            <!-- * sukses tab -->
        <!-- Mutasi tab -->
            <div class="tab-pane fade" id="mutasi-saldo" role="tabpanel">
            
                <?
                $searchMutasi = $call->query("SELECT * FROM mutation WHERE user = '$sess_username' AND kategori IN ('Transaksi', 'Deposit', 'Lainnya', 'Tarik Komisi') ORDER BY id DESC LIMIT 50");
                if($searchMutasi->num_rows == FALSE) {
                ?>
                    <div class="text-center mt-5">
                        <img src="<?= assets('mobile/img/gif/notrx.gif') ?>" alt="alt" class="imaged square w200">
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

            <!-- pending tab 
            <div class="tab-pane fade" id="mutasi-saldo" role="tabpanel">
                <?
                $searchMutasi = $call->query("SELECT * FROM mutation WHERE user = '$sess_username' AND kategori IN ('Transaksi', 'Deposit', 'Lainnya', 'Tarik Coin') ORDER BY id DESC LIMIT 50");
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
                                 <span class="harga text-dark"><strong><?= $rowMutasi['type'].'Rp '.currency($rowMutasi['amount']) ?></span></strong>
                                 <span class="spasi"> </span>
                                 <span class="btn <?= $btn ?> btn-status rounded"><?= $note ?></span>
                               </div>
                            </div>   
                          </div>
                        </div>
                    </a>
                <? } } ?>
            </ul>

            </div>
            <!-- * pending tab -->
            
        </div>
    </div>
    <!-- * App Capsule -->
<?php require _DIR_('library/footer/user') ?>