<?php

if(!function_exists('open')) {
    function open($layout) {
        global $_CONFIG;
        return require DESKTOPPATH.'views/layouts/'.$layout.'/open.php';
    }
}

if(!function_exists('close')) {
    function close($layout) {
        global $_CONFIG;
        return require DESKTOPPATH.'views/layouts/'.$layout.'/close.php';
    }
}

if(!function_exists('component')) {
    function component($component) {
        return require DESKTOPPATH.'views/components/'.$component.'.php';
    }
}

if(!function_exists('set_title')) {
    function set_title($title) {
        global $_CONFIG;
        return $_CONFIG['page'] = $title;
    }
}

if(!function_exists('get_title')) {
    function get_title() {
        global $_CONFIG;
        return $_CONFIG['page'];
    }
}