<?php
require '../../RGShenn.php';
require _DIR_('library/session/session');

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    if(!isset($_SESSION['user'])) exit("No direct script access allowed!");
    if(!isset($_POST['category'])) exit("No direct script access allowed!");
    if(!isset($_POST['data'])) exit("No direct script access allowed!");
    if(!isset($_POST['type']) || !in_array($_POST['type'],['pulsa-internasional','token-pln','e-money','voucher-game','voucher-game','voucher','pascabayar'])) exit("No direct script access allowed!");
    if(empty($_POST['category'])) die;
    if(empty($_POST['data']) || $_POST['data'] == '0' || $_POST['data'] == '08') die;
    
    $modal = $_POST['type'] == 'pascabayar' ? 'postpaid' : 'prepaid' ;
    $post_phone = filter($_POST['data']);
    $search = $call->query("SELECT * FROM srv WHERE brand = '".filter($_POST['category'])."' AND type = '".$_POST['type']."' AND status = 'available' ORDER BY price ASC");
    if($search->num_rows == 0) {
        $service = '<div class="alert alert-danger alert-dismissible text-left fade show" role="alert">
                        Layanan Tidak Ditemukan.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <ion-icon name="close-outline" role="img" class="md hydrated" aria-label="close outline"></ion-icon>
                        </button>
                    </div>';
            print $service;
            } else {
            error_reporting(0);
                $out_srv .= '<div class="row">';
                while($row = $search->fetch_assoc()) {
                    if($row['status'] == 'available') :
                    $out_srv .= '<div class="col-6 mb-2"><a href="javascript:;" onclick="modalKonfirmasi(\'Konfirmasi Pembayaran\',\''.base_url('confirm-'.$modal.'/'.$row['code'].'/'.$post_phone).'\')">';
                    $out_srv .= '<div class="card">
                                    <div class="card-body p-0" align="right">
                                    <span class="badge badge-primary col-4" style="padding:0px 1.5px;border-radius:0px 11px 0px 11px;font-size:10px;">Tersedia</span>
                                    </div>
                                    <div class="card-body" style="padding:5px 15px 15px">
                                        <h4 style="margin:0px 0px 4px;"><b>'.$row['name'].'</b></h4>
                                        <h5 style="color:#909090;">'.$row['note'].'</h5>
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
                                    <span class="badge badge-warning col-4" style="padding:0px 1.5px;border-radius:0px 11px 0px 11px;font-size:10px;">Gangguan</span>
                                    </div>
                                    <div class="card-body" style="padding:5px 15px 15px">
                                        <h4 style="margin:0px 0px 4px;"><b>'.$row['name'].'</b></h4>
                                        <h5 style="margin:0px 0px 4px;color:#909090;">'.$row['note'].'</h5>
                                        <div class="row">
                                            <div class="col-12 text-left">
                                                <h5 class="text text-primary mb-0"><b>Rp '.currency(price($data_user['level'],$row['price'],$row['provider'])).'</b></h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                    endif;
                    }
                    $out_srv .= '</div>';
        
        print $out_srv;
    }
} else {
	exit("No direct script access allowed!");
}