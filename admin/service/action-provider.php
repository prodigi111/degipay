<?php 
require '../../connect.php';
require _DIR_('library/session/admin');
require _DIR_('library/header/admin');
if(isset($_POST['delete'])) {

    if($result_csrf == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'System error, please try again later.'];
    } else if($data_user['level'] !== 'Admin') {
        $_SESSION['result'] = ['type' => false,'message' => 'You do not have permission to access this feature.'];
    } else if($sess_username == 'demo') {
        $_SESSION['result'] = ['type' => false,'message' => 'Demo accounts do not have permission to access this feature.'];
    } else {
        $up = $call->query("DELETE FROM srv");
        $up = $call->query("DELETE FROM category");
        if($up == TRUE) {
            $_SESSION['result'] = ['type' => true,'message' => 'Semua Layanan dan Category dihapus. '];
        } else {
            $_SESSION['result'] = ['type' => false,'message' => 'Our server is in trouble, please try again later.'];
        }
    }
}
?>
    <div class="col-12">
        <? require _DIR_('library/session/result'); ?>
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
               <div class="iq-header-title">
                  <h4 class="card-title"><i class="fas fa-credit-card text-primary mr-2"></i> Update Service</h4>
               </div>
            </div>
            <div class="iq-card-body">
                <center><!--
                    <b> Bospanel</b>
                    <div class="center">
                        <a class="btn btn-info waves-effect w-md waves-light" href="#">Social Media</a>
                    </div><br/> -->
                    <b> Digiflazz</b>
                    <div class="center">
                        <a href="<?= base_url('cron/service') ?>" class="btn btn-info waves-effect w-md waves-light">Layanan</a>
                        <a href="<?= base_url('cron/refund') ?>" class="btn btn-info waves-effect w-md waves-light">Refund</a>
                    </div>
                </center>                 
                </div>
            </div>
            
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
               <div class="iq-header-title">
                  <h4 class="card-title"><i class="fas fa-credit-card text-primary mr-2"></i> Delete All Service</h4>
               </div>
            </div>
            <div class="iq-card-body">
                <center>
                    <div class="center">
                        <a href="#" title="Delete" data-toggle="modal" data-target="#delete" class="btn btn-danger waves-effect w-md waves-light">Delete</a>
                    </div>
                </center>                 
                </div>
            </div>
        </div>
    </div>
        </div>
    </div>
                                    <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="modalID" style="display: none;" aria-hidden="true">
                                          <div class="modal-dialog modal-dialog-centered" role="document">
                                             <div class="modal-content">
                                                <div class="modal-header">
                                                   <h5 class="modal-title">Delete Layanan & Category NeuPay</h5>
                                                   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                   <span aria-hidden="true">×</span>
                                                   </button>
                                                </div>
                                                <form method="POST" class="form-inline" role="form" enctype="multipart/form-data">
                                                    <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $csrf_string ?>">
                                                    <p>Ini Akan Menghapus semua layanan dan category <?= $_CONFIG['title'] ?> ( Termasuk Manual )</p>
                                                    <div class="modal-footer">
                                                       <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                                       <button type="submit" name="delete" class="btn btn-primary">Submit</button>
                                                    </div>
                                                </form>
                                             </div>
                                          </div>
                                       </div>
<? require _DIR_('library/footer/admin'); ?>