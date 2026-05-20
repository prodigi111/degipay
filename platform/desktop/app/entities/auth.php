<?php

class Auth {
    public function isLoggin() {
        return ($this->checkLogin('isLoggin')) ? redirect(0, desktop_url('login')) : '';
    }

    public function check() {
        return ($this->checkLogin('check')) ? redirect(0, desktop_url()) : '';
    }

    public function isAdmin() {
        return ($this->user()->level !== 'Admin') ? redirect(0, desktop_url()) : '';
    }

    public function user() {
        global $call;
        return $call->query("SELECT * FROM users WHERE username = '".$_SESSION['user']['username']."'")->fetch_object();
    }

    private function checkLogin(String $action) {
        switch ($action) {
            case 'check':
                if(isset($_SESSION['user'])) {
                    return true;
                } else {
                    $this->haveCookie();
                }
            break;
            case 'isLoggin':
                if(!isset($_SESSION['user'])) {
                    if(isset($_COOKIE['token']) && isset($_COOKIE['ssid'])) {
                        $ShennID = $_COOKIE['ssid'];
                        $ShennUID = str_replace(['SHENN-A','AIY'],'',$ShennID) + 0;
                        $ShennKey = $_COOKIE['token'];
                        $ShennUser = $call->query("SELECT * FROM users WHERE id = '$ShennUID'")->fetch_assoc();
                        
                        $ShennCheck = $call->query("SELECT * FROM users_cookie WHERE cookie = '$ShennKey' AND username = '".$ShennUser['username']."'");
                        if($ShennCheck->num_rows == 1) {
                            $_SESSION['user'] = $ShennUser;
                            return false;
                            $call->query("UPDATE users_cookie SET active = '$date $time' WHERE cookie = '$ShennKey'");
                        } else {
                            return true;
                        }
                    }
                    return true; 
                }
            break;
        }
    }

    private function haveCookie() {
        if(isset($_COOKIE['token']) && isset($_COOKIE['ssid'])) {
            $ShennID = $_COOKIE['ssid'];
            $ShennUID = str_replace(['SHENN-A','AIY'],'',$ShennID) + 0;
            $ShennKey = $_COOKIE['token'];
            $ShennUser = $call->query("SELECT * FROM users WHERE id = '$ShennUID'")->fetch_assoc();
            $sess_username = $ShennUser['username'];
            
            $ShennCheck = $call->query("SELECT * FROM users_cookie WHERE cookie = '$ShennKey' AND username = '$sess_username'");
            if($ShennCheck->num_rows == 1) {
                $_SESSION['user'] = $ShennUser;
                return true;
                $call->query("UPDATE users_cookie SET active = '$date $time' WHERE cookie = '$ShennKey'");
            } else {
                unset($_COOKIE['ssid']);
                unset($_COOKIE['token']);
                setcookie('ssid', null, -1, '/', $_SERVER['HTTP_HOST']);
                setcookie('token', null, -1, '/', $_SERVER['HTTP_HOST']);
            }
        }
    }
}