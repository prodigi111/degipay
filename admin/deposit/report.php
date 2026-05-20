<?php 
require '../../connect.php';
require _DIR_('library/session/admin');

$cnt = $call->query("SELECT * FROM deposit WHERE status = 'paid'")->num_rows;
$tot = $call->query("SELECT SUM(amount) AS x FROM deposit WHERE status = 'paid'")->fetch_assoc()['x'];

if(isset($_GET['start_date']) && isset($_GET['end_date'])) {
    $filter_date1 = filter($_GET['start_date']);
    $filter_date2 = filter($_GET['end_date']);
    
	if(validate_date($filter_date1) == false || validate_date($filter_date2) == false) {
		$_SESSION['result'] = ['type' => false,'message' => 'Input does not match.'];
	} else if(strtotime($filter_date2) < strtotime($filter_date1)) {
        $_SESSION['result'] = ['type' => false,'message' => 'The period starts beyond the end period.'];
	} else {
        $cnt = $call->query("SELECT * FROM deposit WHERE status = 'paid' AND DATE(date_cr) BETWEEN '$filter_date1' AND '$filter_date2'")->num_rows;
        $tot = $call->query("SELECT SUM(amount) AS x FROM deposit WHERE status = 'paid' AND DATE(date_cr) BETWEEN '$filter_date1' AND '$filter_date2'")->fetch_assoc()['x'];
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
                              <h4 class="card-title"><i class="fas fa-chart-bar text-primary mr-2"></i> Deposit Report Chart</h4>
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
                                            <th>Deposit Total</th>
                                            <th>Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><?= currency($cnt) ?></td>
                                            <td><?= 'Rp '.currency($tot) ?></td>
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
                                        data: [<? for($i = 0; $i <= countDay($filter_date1,$filter_date2); $i++) { print '{w: \''.date('Y-m-d', strtotime("-$i days", strtotime($date))).'\', y: '.$call->query("SELECT id FROM deposit WHERE status = 'paid' AND date_cr LIKE '".date('Y-m-d', strtotime("-$i days", strtotime($date)))."%'")->num_rows.'},'; } ?>],
                                        xkey: 'w',
                                        ykeys: ['y'],
                                        labels: ['Deposit'],
                                        lineColors: ['#1576c2'],
                                        hideHover: 'auto'
                                    });
                                });
                            </script>
                        </div>
                    </div>
                </div>
<? require _DIR_('library/footer/admin'); ?>