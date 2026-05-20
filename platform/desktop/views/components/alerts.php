<?php if(isset($_SESSION['result'])): ?>
<div class="pb-3 alert alert-fill alert-<?= $_SESSION['result']['type']; ?> alert-dismissible">
    <strong><?= $_SESSION['result']['info']; ?></strong><br /> <?= $_SESSION['result']['message']; ?>
    <button class="close" data-dismiss="alert"></button>
</div>
<?php unset($_SESSION['result']); endif; ?>