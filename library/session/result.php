<?php 
if(isset($_SESSION['result'])) { 
    $type = strtolower($_SESSION['result']['type']);
    $session_alert = ($type == true) ? 'success' : 'danger';
?>
<div class="alert text-white bg-<?= $session_alert ?>" role="alert">
    <div class="iq-alert-text">
        <?= $_SESSION['result']['message'] ?>
    </div>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <i class="ri-close-line"></i>
    </button>
</div>

<?php unset($_SESSION['result']); } ?>