<?php
require_once '../../app/config/core.php';
$call->query("DELETE FROM users_cookie WHERE cookie = '".$_COOKIE['token']."'");
unset($_COOKIE['token']);
unset($_COOKIE['ssid']);
unset($_SESSION['user']);
setcookie('ssid', null, -1, '/', $_SERVER['HTTP_HOST']);
setcookie('token', null, -1, '/', $_SERVER['HTTP_HOST']);
redirect(0,desktop_url());