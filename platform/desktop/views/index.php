<?php
require_once 'app/config/core.php';
if(isset($_SESSION['user'])) {
    redirect(0, desktop_url('dashboard'));
} else {
    redirect(0, desktop_url('login'));
}