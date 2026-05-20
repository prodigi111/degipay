<?php

if(!function_exists('auth')) {
    function auth() {
        global $call, $_SESSION, $_COOKIE;
        $auth = new Auth;
        return $auth;
    }
}

if(!function_exists('user')) {
    function user($data) {
        global $call, $_SESSION, $_COOKIE;
        $auth = new Auth;
        return $auth->user()->$data;
    }
}