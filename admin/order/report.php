<?php 
require '../../connect.php';
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
}

$cnt = $call->query("SELECT * FROM trx WHERE status = 'success'")->num_rows;
$tot = $call->query("SELECT SUM(price) AS x FROM trx WHERE status = 'success'")->fetch_assoc()['x'];
$prf = $call->query("SELECT SUM(profit) AS x FROM trx WHERE status = 'success'")->fetch_assoc()['x'];

if(isset($_GET['start_date']) && isset($_GET['end_date'])) {
    $filter_date1 = filter($_GET['start_date']);
    $filter_date2 = filter($_GET['end_date']);
    
	if(validate_date($filter_date1) == false || validate_date($filter_date2) == false) {
		$_SESSION['result'] = ['type' => false,'message' => 'Input does not match.'];
	} else if(strtotime($filter_date2) < strtotime($filter_date1)) {
        $_SESSION['result'] = ['type' => false,'message' => 'The period starts beyond the end period.'];
	} else {
        $cnt = $call->query("SELECT * FROM trx WHERE status = 'success' AND DATE(date_cr) BETWEEN '$filter_date1' AND '$filter_date2'")->num_rows;
        $tot = $call->query("SELECT SUM(price) AS x FROM trx WHERE status = 'success' AND DATE(date_cr) BETWEEN '$filter_date1' AND '$filter_date2'")->fetch_assoc()['x'];
        $prf = $call->query("SELECT SUM(profit) AS x FROM trx WHERE status = 'success' AND DATE(date_cr) BETWEEN '$filter_date1' AND '$filter_date2'")->fetch_assoc()['x'];
	}
} else {
    $filter_date1 = date('Y-m-d', strtotime("-6 days", strtotime($date)));
    $filter_date2 = $date;
}

require _DIR_('library/header/admin');
?>
                  <div class="col-lg-12">
                     <div class="iq-card">
                        <div class="iq-card-header d-flex justify-content-between">
                           <div class="iq-header-title">
                              <h4 class="card-title"><i class="fas fa-chart-bar text-primary mr-2"></i> Order Report Chart</h4>
                           </div>
                        </div>
                        <div class="iq-card-body">
                            <form method="GET">
                                <div class="row">
                                    <div class="form-group col-lg-4">
                                        <label>From</label>
                                        <input type="date" class="form-control" name="start_date" value="<?= $filter_date1 ?>">
                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label>To</label>
                                        <input type="date" class="form-control" name="end_date" value="<?= $filter_date2 ?>">
                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label>Submit</label>
                                        <button type="submit" class="btn btn-block btn-primary">Filter</button>
                                    </div>
                                </div>
                            </form>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" style="border:1px solid #dee2e6;">
                                    <thead>
                                        <tr>
                                            <th>Order Total</th>
                                            <th>Gross Income</th>
                                            <th>Net income</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><?= currency($cnt) ?></td>
                                            <td><?= 'Rp '.currency($tot) ?></td>
                                            <td><?= 'Rp '.currency($prf) ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div id="line-chart" style="height: 300px;"></div>
                            <script>
                                $(function () {
                                    "use strict";
                                    var line = new Morris.Line({
                                        element: 'line-chart',
                                        resize: true,
                                        data: [<? for($i = 0; $i <= countDay($filter_date1,$filter_date2); $i++) { print '{w: \''.date('Y-m-d', strtotime("-$i days", strtotime($date))).'\', y: '.$call->query("SELECT id FROM trx WHERE trxtype = 'prepaid' AND status = 'success' AND date_cr LIKE '".date('Y-m-d', strtotime("-$i days", strtotime($date)))."%'")->num_rows.', z: '.$call->query("SELECT id FROM trx WHERE trxtype = 'postpaid' AND status = 'success' AND date_cr LIKE '".date('Y-m-d', strtotime("-$i days", strtotime($date)))."%'")->num_rows.'},'; } ?>],
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
<? require _DIR_('library/footer/admin'); ?>