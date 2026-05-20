<?php
if(!isset($_SESSION['user'])) {
    if(isset($_COOKIE['token']) && isset($_COOKIE['ssid'])) {
        $ShennID = $_COOKIE['ssid'];
        $ShennUID = str_replace(['SHENN-A','AIY'],'',$ShennID) + 0;
        $ShennKey = $_COOKIE['token'];
        $ShennUser = $call->query("SELECT * FROM users WHERE id = '$ShennUID'")->fetch_assoc();
        $sess_username = $ShennUser['username'];
        
        $ShennCheck = $call->query("SELECT * FROM users_cookie WHERE cookie = '$ShennKey' AND username = '$sess_username'");
        if($ShennCheck->num_rows == 1) {
            $_SESSION['user'] = $ShennUser;
            redirect(0,visited());
            $call->query("UPDATE users_cookie SET active = '$date $time' WHERE cookie = '$ShennKey'");
        } else {
            unset($_COOKIE['ssid']);
            unset($_COOKIE['token']);
            setcookie('ssid', null, -1, '/', $_SERVER['HTTP_HOST']);
            setcookie('token', null, -1, '/', $_SERVER['HTTP_HOST']);
        }
    }
}

if(isset($_SESSION['user'])) {
    $sess_username = $_SESSION['user']['username'];
    $data_user = $call->query("SELECT * FROM users WHERE username = '$sess_username'")->fetch_assoc();
    if($call->query("SELECT * FROM users WHERE username = '$sess_username'")->num_rows == 0) {
        $_SESSION['result'] = ['type' => false,'message' => 'No Access Allowed.'];
        redirect(0,base_url('auth/logout'));
    }
}