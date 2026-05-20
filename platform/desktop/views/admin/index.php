<?php
require_once '../../app/config/core.php';
auth()->isAdmin();
set_title('Admin Dashboard');
open('admin');
?>
<?php close('admin'); ?>