<?php
require '../../RGShenn.php';
require _DIR_('library/session/session');

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $AcceptType = ['0','sosmed link','sosmed custome','sosmed other','pulsa-gift','pulsa-reguler','pulsa-internasional','paket-internet','masa-aktif','aktivasi-voucher','paket-telepon','token-pln','e-money','voucher-game','voucher-data','games','pascabayar','voucher', 'pulsa-transfer'];

    if(!in_array($_POST['type'], $AcceptType)) exit('<div class="alert alert-danger text-left fade show" role="alert">No direct script access allowed!</div>');
    $search = $call->query("SELECT * FROM category WHERE type = '".$_POST['type']."' ORDER BY code ASC");
    if($search->num_rows == false) {
        print '<div class="alert alert-danger text-left fade show" role="alert">
                    Maaf Layanan Tidak Ditemukan.
                </div>';
    } else {
?>
            
            <?php
            $searchBrand = $call->query("SELECT code, id FROM category WHERE type = '".$_POST['type']."' GROUP BY code ORDER BY code ASC");
            while($rowBrand = $searchBrand->fetch_assoc()) {
            ?>
            <div class="accordion mb-1" id="accordionExample<?= $rowBrand['id'] ?>">
                <div class="item">
                    <div class="accordion-header">
                        <button class="btn text-white p-0" type="button" data-toggle="collapse" data-target="#accordion0<?= $rowBrand['id'] ?>" aria-expanded="true">
                            <?= strtoupper($rowBrand['code']) ?>
                        </button>
                    </div>
                    <div id="accordion0<?= $rowBrand['id'] ?>" class="accordion-body collapse show" data-parent="#accordionExample<?= $rowBrand['id'] ?>" style="">
                        <div class="accordion-content p-0">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th style="width: 25%;">PRODUCT LAYANAN</th>
                                            <th style="width: 55%;"> NOTE</th>
                                            <th class="rgs-pr-custom">HARGA BASIC</th>
                                            <th>PREMIUM</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $search = $call->query("SELECT * FROM srv WHERE brand = '".$rowBrand['code']."' AND type = '".$_POST['type']."' ORDER BY price ASC");
                                        if($search->num_rows == FALSE) {
                                        ?>
                                        <tr class="text-center">
                                            <td colspan="4">- Layanan Sedang Tidak Tersedia -</td>
                                        </tr>
                                        <?php    
                                        } else {
                                        while($row = $search->fetch_assoc()) {
                                        ?>
                                        <tr>
                                            <td><?= $row['name'] ?></td>
                                            <td><?= $row['note'] ?></td>
                                            <td>Rp<?= currency(price('basic',$row['price'],$row['provider'])) ?></td>
                                            <td>Rp<?= currency(price('premium',$row['price'],$row['provider'])) ?></td>
                                        </tr>
                                        <?php } } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
<?php
    }
} else {
    exit('<div class="alert alert-danger text-left fade show" role="alert">No direct script access allowed!</div>');
}