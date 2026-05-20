<?php 
require '../RGShenn.php';
require _DIR_('library/session/user');

$order = $call->query("SELECT SUM(trx.price) AS tamount, count(trx.id) AS tcount, trx.user, users.name FROM trx JOIN users ON trx.user = users.username WHERE MONTH(trx.date_cr) = '".date('m')."' AND YEAR(trx.date_cr) = '".date('Y')."' AND trx.status IN ('proccessing','success') GROUP BY trx.user ORDER BY tamount DESC LIMIT 10");
$depos = $call->query("SELECT SUM(deposit.amount) AS tamount, count(deposit.id) AS tcount, deposit.user, users.name FROM deposit JOIN users ON deposit.user = users.username WHERE MONTH(deposit.date_cr) = '".date('m')."' AND YEAR(deposit.date_cr) = '".date('Y')."' AND deposit.status = 'paid' GROUP BY deposit.user ORDER BY tamount DESC LIMIT 10");

$count_order = $order->num_rows;
$count_depo = $depos->num_rows;
$page = 'Ranking';
require _DIR_('library/header/user');
?>

    <!-- App Capsule -->
    <div id="appCapsule" class="extra-header-active">
        <div class="tab-content mt-0">
            <div class="tab-pane fade show active" id="topup" role="tabpanel">
                <ul class="listview image-listview">
                    <? $rank = 1; while($row = $depos->fetch_assoc()) { ?>
                    <li>
                        <div class="item">
                            <div>
                                <div class="icon-box bg-warning">
                                    <ion-icon name="trophy-outline"></ion-icon>
                                </div>
                                <span class="badge badge-dark ranking"><?= $rank ?></span>
                            </div>
                            <div class="in">
                                <div><?= explode(substr($row['name'], '2', '2'), $row['name'])['0'].'&bull;&bull;&bull;&bull;&bull;&bull;'.explode(substr($row['name'], '2', '2'), $row['name'])['1'] ?></div>
                                <span class="text-muted">Rp <?= currency($row['tamount']) ?> (<?= currency($row['tcount']) ?>)</span>
                            </div>
                        </div>
                    </li>
					<? $rank++; } ?>
                    <? for($i = $count_depo+1; $i <= 10; $i++) { ?>
                    <li>
                        <div class="item">
                            <div>
                                <div class="icon-box bg-secondary">
                                    <ion-icon name="trophy-outline"></ion-icon>
                                </div>
                                <span class="badge badge-dark ranking"><?= $i ?></span>
                            </div>
                            <div class="in">
                                <div>-</div>
                                <span class="text-muted">-</span>
                            </div>
                        </div>
                    </li>
					<? $rank++; } ?>
                </ul>
            </div>
            <!--
            <div class="tab-pane fade" id="order" role="tabpanel">
                <ul class="listview image-listview">
                    <? $rank = 1; while($row = $order->fetch_assoc()) { ?>
                    <li>
                        <div class="item">
                            <div>
                                <div class="icon-box bg-warning">
                                    <ion-icon name="trophy-outline"></ion-icon>
                                </div>
                                <span class="badge badge-dark ranking"><?= $rank ?></span>
                            </div>
                            <div class="in">
                                <div><?= $row['name'] ?></div>
                                <span class="text-muted">Rp <?= currency($row['tamount']) ?> (<?= currency($row['tcount']) ?>)</span>
                            </div>
                        </div>
                    </li>
					<? $rank++; } ?>
					<? for($i = $count_order+1; $i <= 10; $i++) { ?>
                    <li>
                        <div class="item">
                            <div>
                                <div class="icon-box bg-secondary">
                                    <ion-icon name="trophy-outline"></ion-icon>
                                </div>
                                <span class="badge badge-dark ranking"><?= $i ?></span>
                            </div>
                            <div class="in">
                                <div>-</div>
                                <span class="text-muted">-</span>
                            </div>
                        </div>
                    </li>
					<? $rank++; } ?>
                </ul>
            </div>
            -->
        </div>
    </div>
    <!-- * App Capsule -->

<?php require _DIR_('library/footer/user') ?>