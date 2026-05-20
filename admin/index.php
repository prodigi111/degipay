<?php 
require '../connect.php';
if(!isset($_SESSION['user']) && !isset($_COOKIE['token']) && !isset($_COOKIE['ssid'])) {
        $ShennID = $_COOKIE['ssid'];
        $ShennUID = str_replace(['SHENN-A','AIY'],'',$ShennID) + 0;
        $ShennKey = $_COOKIE['token'];
        $ShennUser = $call->query("SELECT * FROM users WHERE id = '$ShennUID'")->fetch_assoc();

        $ShennCheck = $call->query("SELECT * FROM users_cookie WHERE cookie = '$ShennKey' AND username = '".$ShennUser['username']."'");
        if($ShennCheck->num_rows == 1) {
            $_SESSION['user'] = $ShennUser;
            redirect(0,visited());
            $call->query("UPDATE users_cookie SET active = '$date $time' WHERE cookie = '$ShennKey'");
        } else {
            redirect(0,base_url('auth/login'));
        }
} else {
require _DIR_('library/session/admin');
require _DIR_('library/header/admin');
function WidgetsBOX($file,$img,$name,$title) {
        return '
                  <div class="col-lg-6">
                     <div class="iq-card text-white bg-primary iq-mb-3" >
                        <div class="iq-card-body">
                            <a href="'.base_url($file).'">
                               <div class="row">
                                   <div class="col-md-4 col-12 text-center">
                                       <img src="'.assets($img).'" width="60px">
                                   </div>
                                   <div class="col-md-8 col-12 text-center">
                                       <h5 class="text-white">'.$name.'</h5>
                                       <small class="text-white">'.$title.'</small>
                                   </div>
                               </div>
                            </a>   
                        </div>
                     </div>
                  </div>
';
    }
?>
            <a href="#">
                <div class="alert alert-outline-primary p-2 mt-4 mr-2 ml-2 pb-1 text-white" role="alert" style="border-radius: 50px; text-decoration: none; background: #006400;">
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

<?= WidgetsBOX('admin/users/','images/icon/user.svg','Rp '.currency($call->query("SELECT SUM(balance) AS x FROM users WHERE level != 'Admin'")->fetch_assoc()['x']).'(From '.currency($call->query("SELECT id FROM users WHERE level != 'Admin'")->num_rows).' Pengguna)','Total Saldo Member') ?>
<?= WidgetsBOX('admin/service/provider','images/icon/user.svg','Rp '.currency($call->query("SELECT SUM(balance) AS x FROM provider")->fetch_assoc()['x']).'(From '.currency($call->query("SELECT code FROM provider")->num_rows).' Provider)','Total Saldo Pusat') ?>
<?= WidgetsBOX('admin/order/','images/icon/smartphone.svg','Rp '.currency($call->query("SELECT SUM(price) AS x FROM trx WHERE status = 'success'")->fetch_assoc()['x']).'(From '.currency($call->query("SELECT id FROM trx WHERE status = 'success'")->num_rows).' Trx)','Total Transaksi') ?>
<?= WidgetsBOX('admin/deposit/','images/icon/bank-deposit.svg','Rp '.currency($call->query("SELECT SUM(amount) AS x FROM deposit WHERE status = 'paid'")->fetch_assoc()['x']).'(From '.currency($call->query("SELECT id FROM deposit WHERE status = 'paid'")->num_rows).' Req)','Total Deposit') ?>
                <div class="col-lg-6">
                    <div class="iq-card">
                        <div class="iq-card-header d-flex justify-content-between">
                           <div class="iq-header-title">
                              <h4 class="card-title"><i class="fa fa-book text-primary mr-2"></i> Profit Perhari</h4>
                           </div>
                        </div>
                        <div class="iq-card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover table-checkable">
                                    <thead>
                                        <tr>
                                            <th>Order Total</th>
                                            <th>Profit Kotor</th>
                                            <th>Profit Bersih</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr> 
                                            <td>
                                                <span class="badge badge-primary">
                                                    <?= currency($call->query("SELECT id FROM trx WHERE date_cr LIKE '$date%' AND status = 'success'")->num_rows) ?> Trx
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge badge-success">
                                                    Rp <?= currency($call->query("SELECT SUM(price) AS x FROM trx WHERE date_cr LIKE '$date%' AND status = 'success'")->fetch_assoc()['x']) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge badge-warning">
                                                    Rp <?= currency($call->query("SELECT SUM(profit) AS x FROM trx WHERE date_cr LIKE '$date%' AND status = 'success'")->fetch_assoc()['x']) ?>
                                                </span>
                                            </td>
                                        </tr>  
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="iq-card">
                        <div class="iq-card-header d-flex justify-content-between">
                           <div class="iq-header-title">
                              <h4 class="card-title"><i class="fa fa-book text-primary mr-2"></i> Profit Perbulan</h4>
                           </div>
                        </div>
                        <div class="iq-card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover table-checkable">
                                    <thead>
                                        <tr>
                                            <th>Order Total</th>
                                            <th>Profit Kotor</th>
                                            <th>Profit Bersih</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr> 
                                            <td>
                                                <span class="badge badge-primary">
                                                    <?= currency($call->query("SELECT id FROM trx WHERE MONTH(date_cr) = '".date('m')."' AND YEAR(date_cr) = '".date('Y')."' AND status = 'success'")->num_rows) ?> Trx
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge badge-success">
                                                    Rp <?= currency($call->query("SELECT SUM(price) AS x FROM trx WHERE MONTH(date_cr) = '".date('m')."' AND YEAR(date_cr) = '".date('Y')."' AND status = 'success'")->fetch_assoc()['x']) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge badge-warning">
                                                    Rp <?= currency($call->query("SELECT SUM(profit) AS x FROM trx WHERE MONTH(date_cr) = '".date('m')."' AND YEAR(date_cr) = '".date('Y')."' AND status = 'success'")->fetch_assoc()['x']) ?>
                                                </span>
                                            </td>
                                        </tr>  
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-lg-12">
                    <div class="iq-card">
                        <div class="iq-card-header d-flex justify-content-between">
                           <div class="iq-header-title">
                              <h4 class="card-title">Grafik Transaksi 7 Hari</h4>
                           </div>
                        </div>
                        <div class="iq-card-body">
                            <div id="line-chart" style="height: 300px;"></div>
                            <script>
                                $(function () {
                                    "use strict";
                                    var line = new Morris.Line({
                                        element: 'line-chart',
                                        resize: true,
                                        data: [<? for($i = 0; $i < 7; $i++) { print '{w: \''.date('Y-m-d', strtotime("-$i days", strtotime($date))).'\', y: '.$call->query("SELECT id FROM trx WHERE trxtype = 'prepaid' AND status = 'success' AND date_cr LIKE '".date('Y-m-d', strtotime("-$i days", strtotime($date)))."%'")->num_rows.', z: '.$call->query("SELECT id FROM trx WHERE trxtype = 'postpaid' AND status = 'success' AND date_cr LIKE '".date('Y-m-d', strtotime("-$i days", strtotime($date)))."%'")->num_rows.'},'; } ?>],
                                        xkey: 'w',
                                        ykeys: ['y','z'],
                                        labels: ['Prepaid','Postpaid'],
                                        lineColors: ['#1576c2','FFFF00'],
                                        hideHover: 'auto'
                                    });
                                });
                            </script>
                        </div>
                    </div>
                </div>
<? } require _DIR_('library/footer/admin'); ?>