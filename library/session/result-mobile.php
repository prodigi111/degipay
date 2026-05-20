<?php 
if(isset($_SESSION['result'])) { 
    $type = strtolower($_SESSION['result']['type']);
    $session_alert = ($type == true) ? 'success' : 'warning';
?>
<div class="alert alert-<?= $session_alert ?> alert-dismissible text-left fade show" role="alert">
    <?= $_SESSION['result']['message'] ?>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <ion-icon name="close-outline" role="img" class="md hydrated" aria-label="close outline"></ion-icon>
    </button>
</div>
<?php unset($_SESSION['result']); } ?>