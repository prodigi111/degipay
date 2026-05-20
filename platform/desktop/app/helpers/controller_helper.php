<?php

if(!function_exists('load_controller')) {
    function load_controller($controller) {
        global $_SESSION, $_CONFIG, $_SERVER, $result_csrf, $call, $_COOKIE, $datetime, $date, $time, $WATL, $_MAILER, $FCM, $device, $user_agent;
        if($controller !== '') {
            if(file_exists(APP_DESKTOPPATH.'controllers/'.$controller.'.php')) {
                require APP_DESKTOPPATH.'controllers/'.$controller.'.php';
            } else {
                die('Controller ['.$controller.'] doesnt exists');
            }
        }
    }
}