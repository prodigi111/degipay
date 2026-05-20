<?php

if(!function_exists('alias')) {
    function alias($data) {
        $data = explode(' ', $data);
        return (count($data) == 1) ? substr($data[0], 0, 1) : substr($data[0], 0, 1).substr($data[1], 0, 1);
    }
}