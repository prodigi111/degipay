<?php

function helpers($init) {
    if($init !== '' || count($init) != 0) {
        foreach ($init as $helper => $status) {
            if($status == true) {
                if(file_exists(HELPER_DESKTOPPATH.$helper.'_helper.php')) {
                    require HELPER_DESKTOPPATH.$helper.'_helper.php';
                }
            }
        }
    }
}

helpers([
    'uri'        => true,
    'controller' => true,
    'layout'     => true,
    'message'    => true,
    'auth'       => true,
    'misc'       => true,
]);