<?php

if(!function_exists('desktop_url')) {
    function desktop_url($path = '') {
        return base_url('web/'.$path);
    }
}

if(!function_exists('desktop_assets')) {
    function desktop_assets($asset) {
        return base_url('platform/desktop/resources/'.$asset);
    }
}