<?php

if(!function_exists('message')) {
    function message(Array $response) {
        $_SESSION['result'] = $response;
        exit(header("Location: ".base_url(ltrim($_SERVER['REDIRECT_URL'], '/'))));
    }
}