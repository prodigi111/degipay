<?php
require '../../RGShenn.php';
require _DIR_('library/session/session');

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    if(!isset($_SESSION['user'])) exit('<div class="alert alert-danger text-left fade show" role="alert">No direct script access allowed!</div>');
    if(!isset($_POST['phone'])) exit('<div class="alert alert-danger text-left fade show" role="alert">No direct script access allowed!</div>');
    if(!isset($_POST['type']) || !in_array($_POST['type'],['pulsa-reguler','pulsa-gift','pulsa-transfer','masa-aktif','aktivasi-perdana','paket-internet','paket-telepon'])) exit('<div class="alert alert-danger text-left fade show" role="alert">No direct script access allowed!</div>');
    if(empty($_POST['phone'])) exit(json_encode(['service' => '', 'brand' => '','class' => '']));
    
    $post_type = $_POST['type'];
    $post_phone = filter_phone('0',$_POST['phone']);
    $kategori = isset($_POST['kategori']) ? filter($_POST['kategori']) : 'Umum';
    $brand = strtr(strtoupper($SimCard->operator($post_phone)),[
        'THREE' => 'TRI',
        //'SMARTFREN' => 'SMART'
    ]);
    $itype = $post_type == 'pulsa-reguler' ? 'pulsa-reguler' : ($post_type == 'pulsa-transfer' ? 'pulsa-transfer' : $post_type == 'masa-aktif' ? 'masa-aktif' : $post_type == 'aktivasi-perdana' ? 'aktivasi-perdana' : 'paket-internet');
    $image = strtr($brand,[
        'TELKOMSEL' => assets('images/operator-icon/telkomsel.png?'.time()),
        'BY.U' => assets('images/operator-icon/byu.png?'.time()),
        'INDOSAT' => assets('images/operator-icon/indosat.png?'.time()),
        'XL' => assets('images/operator-icon/xl.png?'.time()),
        'AXIS' => assets('images/operator-icon/axis.png?'.time()),
        'SMARTFREN' => assets('images/operator-icon/smartfren.png?'.time()),
        'TRI' => assets('images/operator-icon/tri.png?'.time()),
    ]);
    
    if(strtolower($brand) != 'unknown') {
        if($post_type == 'paket-internet') {
            $search = $call->query("SELECT * FROM srv WHERE brand = '$brand' AND type = '$post_type' AND kategori = '$kategori' ORDER BY price ASC");
        } else {
            $search = $call->query("SELECT * FROM srv WHERE brand = '$brand' AND type = '$post_type' ORDER BY price ASC");
        }
        $out_srv = '';
        if($search->num_rows == false) {
            $service = '<div class="alert alert-danger alert-dismissible text-left fade show" role="alert">
                            Layanan tidak ditemukan.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <ion-icon name="close-outline" role="img" class="md hydrated" aria-label="close outline"></ion-icon>
                            </button>
                        </div>';
            print json_encode(['service' => $service, 'brand' => null,'image' => $image]);
        } else {
error_reporting(0);
            if($post_type == 'pulsa-reguler') {
                $out_srv .= '<div class="row">';
                while($row = $search->fetch_assoc()) {
                    if($row['status'] == 'available') :
                    $out_srv .= '<div class="col-6 mb-2"><a href="javascript:;" onclick="modalKonfirmasi(\'Konfirmasi Pembayaran\',\''.base_url('confirm-prepaid/'.$row['code'].'/'.$post_phone).'\')">';
                    $out_srv .= '<div class="card">
                                    <div class="card-body p-0" align="right">
                                    <span class="badge badge-primary col-4" style="padding:0px 1.5px;border-radius:0px 11px 0px 11px;font-size:10px;">Tersedia</span>
                                    </div>
                                    <div class="card-body" style="padding:5px 15px 15px">
                                        <h4><b>'.$row['name'].'</b></h4>
                                        <div class="row">
                                            <div class="col-7 text-left">
                                                <h5 class="text text-primary mb-0"><b>Rp '.currency(price($data_user['level'],$row['price'],$row['provider'])).'</b></h5>
                                            </div>
                                            <div class="col-5 text-right">
                                                <h5 class="text text-gold mb-0"><b>' . currency(conf('referral', c3)) . ' +Poin</b></h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            </div>';
                    else:
                    $out_srv .= '<div class="col-6 mb-2">';
                    $out_srv .= '<div class="card">
                                    <div class="card-body p-0" align="right">
                                    <span class="badge badge-danger col-4" style="padding:0px 1.5px;border-radius:0px 11px 0px 11px;font-size:10px;">Gangguan</span>
                                    </div>
                                    <div class="card-body" style="padding:5px 15px 15px">
                                        <h4><b>'.$row['name'].'</b></h4>
                                        <div class="row">
                                            <div class="col-7 text-left">
                                                <h5 class="text text-primary mb-0"><b>Rp '.currency(price($data_user['level'],$row['price'],$row['provider'])).'</b></h5>
                                            </div>
                                            <div class="col-5 text-right">
                                                <h5 class="text text-gold mb-0"><b>' . currency(conf('referral', c3)) . ' +Poin</b></h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                    endif;
                }
                $out_srv .= '</div>';
            } else {
                $out_srv .= '<div class="row">';
                while($row = $search->fetch_assoc()) {
                    if($row['status'] == 'available') :
                    $out_srv .= '<div class="col-12 mb-2"><a href="javascript:;" onclick="modalKonfirmasi(\'Konfirmasi Pembayaran\',\''.base_url('confirm-prepaid/'.$row['code'].'/'.$post_phone).'\')">';
                    $out_srv .= '<div class="card">
                                    <div class="card-body p-0" align="right">
                                    <span class="badge badge-primary col-2" style="padding:0px 1.5px;border-radius:0px 11px 0px 11px;font-size:10px;">Tersedia</span>
                                    </div>
                                    <div class="card-body" style="padding:5px 15px 15px">
                                        <h4 style="margin:0px 0px 4px;"><b>'.$row['name'].'</b></h4>
                                        <h5 style="margin:0px 0px 4px;color:#909090;">'.$row['note'].'</h5>
                                        <div class="row">
                                            <div class="col-7 text-left">
                                                <h5 class="text text-primary mb-0"><b>Rp '.currency(price($data_user['level'],$row['price'],$row['provider'])).'</b></h5>
                                            </div> 
                                            <div class="col-5 text-right">
                                                <h5 class="text text-gold mb-0"><b>' . currency(conf('referral', c3)) . ' +Poin</b></h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            </div>';
                    else:
                    $out_srv .= '<div class="col-12 mb-2">';
                    $out_srv .= '<div class="card">
                                    <div class="card-body p-0" align="right">
                                    <span class="badge badge-warning col-2" style="padding:0px 1.5px;border-radius:0px 11px 0px 11px;font-size:10px;">Gangguan</span>
                                    </div>
                                    <div class="card-body" style="padding:5px 15px 15px">
                                        <h4 style="margin:0px 0px 4px;"><b>'.$row['name'].'</b></h4>
                                        <h5 style="margin:0px 0px 4px;color:#909090;">'.$row['note'].'</h5>
                                        <div class="row">
                                            <div class="col-12 text-left">
                                                <h5 class="text text-primary mb-0"><b>Rp '.currency(price($data_user['level'],$row['price'],$row['provider'])).'</b></h5>
                                            </div> 
                                            <div class="col-5 text-right">
                                                <h5 class="text text-gold mb-0"><b>' . currency(conf('referral', c2)) . ' +Points</b></h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                    endif;
                }
                $out_srv .= '</div>';
            }
        }
        print json_encode(['service' => $out_srv, 'brand' => $brand,'image' => $image]);
    } else {
    $service = '<div class="alert alert-danger alert-dismissible text-left fade show" role="alert">
                    Layanan Tidak Ditemukan.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <ion-icon name="close-outline" role="img" class="md hydrated" aria-label="close outline"></ion-icon>
                    </button>
                </div>';
        print json_encode(['service' => $service, 'brand' => null]);
    }
} else {
	exit('<div class="alert alert-danger text-left fade show" role="alert">No direct script access allowed!</div>');
}