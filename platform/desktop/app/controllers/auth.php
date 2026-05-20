<?php
if(isset($_POST['login'])) {
    $account = filter($_POST['account']);
    $passcode = filter($_POST['password']);

    $ip = client_ip();
    $cookie_time = time() + (86400 * 90);
    $ShennCookie = random(86);

    if($result_csrf == false) {
        message(['type' => 'danger', 'info' => 'System Error', 'message' => 'Silahkan coba beberapa saat lagi.']);
    } else if(!$account || !$passcode) {
        message(['type' => 'warning', 'info' => 'Terjadi Kesalahan!', 'message' => 'Harap isi semua form.']);
    } else {
        if($call->query("SELECT * FROM users WHERE phone = '$account' OR email = '$account'")->num_rows == 0) {
            message(['type' => 'danger', 'info' => 'Tidak Terdaftar', 'message' => 'Akun belum terdaftar.']);
        } else {
            $data_user = $call->query("SELECT * FROM users WHERE phone = '$account' OR email = '$account'")->fetch_assoc();
            if($data_user['status'] == 'suspend') {
                message(['type' => 'danger', 'info' => 'Gagal Masuk!!!', 'message' => 'Akun Ditangguhkan, Harap Hubungi Admin.']);
            } else if($data_user['status'] !== 'active' && $data_user['status'] !== 'locked') {
                message(['type' => 'warning', 'info' => 'Gagal Masuk!!!', 'message' => 'Akun Belum Diverifikasi.']);
            } else {
                if(check_bcrypt($passcode, $data_user['pin']) == true) {
                    setcookie('ssid', 'SHENN-A'.$data_user['id'].'AIY', $cookie_time, '/', $_SERVER['HTTP_HOST']);
                    setcookie('token', $ShennCookie, $cookie_time, '/', $_SERVER['HTTP_HOST']);
                    $call->query("INSERT INTO users_cookie VALUES ('$ShennCookie', '".$data_user['username']."', '$datetime')");
                    if(isset($_COOKIE['FCM_TOKEN'])) {
                        $userFcm = $_COOKIE['FCM_TOKEN'];
                        if($call->query("SELECT * FROM users_token WHERE user = '".$data_user['username']."' AND token = '$userFcm'")->num_rows == TRUE) {
                            $call->query("UPDATE users_token SET date = '$datetime' WHERE user = '".$data_user['username']."'");
                        } else {
                            $call->query("INSERT INTO users_token VALUES ('','".$data_user['username']."','$userFcm','$datetime')");
                        }
                    }
                    $_SESSION['user'] = $data_user;
                    
                    $notification = [
                        'title' => 'Selamat Datang',
                        'body' => 'Hallo '.$data_user['name'].' Selamat Datang Kembali Di '.$_CONFIG['title'],
                        'click_action' =>  'Open_URI'
                    ];
                    
                    $data = [
                        'picture' => '',
                        'uri' =>  base_url(),
                    ];
                    $FCM->sendNotif(isset($_COOKIE['FCM_TOKEN']) ? $_COOKIE['FCM_TOKEN'] : '', $notification, $data);
                    
                    $call->query("INSERT INTO logs VALUES ('', '".$data_user['username']."', 'login', '$ip', '$datetime')");
                    redirect(0, desktop_url());
                } else {
                    message(['type' => 'danger', 'info' => 'Gagal Masuk!!!', 'message' => 'Passcode tidak valid.']);
                }
            }
        }
    }
}
if(isset($_POST['register'])) {
    $post_name = isset($_POST['name']) ? ucwords(strtolower(filter($_POST['name']))) : '';
    $post_email = isset($_POST['email']) ? filter($_POST['email']) : '';
    $post_phone = isset($_POST['nohp']) ? filter($_POST['nohp']) : '';
    $post_pin = isset($_POST['pin']) ? filter($_POST['pin']) : '';
    $post_referral = isset($_POST['reff']) ? filter($_POST['reff']) : '';
    $post_referral = !$post_referral ? 'RGS-SYSTEM' : filter($_POST['reff']);
    $post_AcceptMail = ['gmail.com','yahoo.com','outlook.com','icloud.com'];
    
    if($result_csrf == false) {
        message(['type' => 'danger', 'info' => 'System Error', 'message' => 'Silahkan coba beberapa saat lagi.']);
    } else if($_CONFIG['mt']['web'] == 'true') {
        message(['type' => 'info', 'info' => 'Ada Perbaikan!!!', 'message' => 'Aplikasi Sedang Dalam Perbaikan.']);
    } else if(!$post_email || !$post_phone || !$post_name) {
        message(['type' => 'warning', 'info' => 'Terjadi Kesalahan!', 'message' => 'Masih Ada Formulir Kosong.']);
    } else if(!in_array(explode('@',$post_email)[1],$post_AcceptMail)) {
        message(['type' => 'warning', 'info' => 'Pendaftaran Gagal!', 'message' => 'Email Tidak Didukung.']);
    } else if($call->query("SELECT * FROM users WHERE phone = '$post_phone'")->num_rows == true) {
        message(['type' => 'warning', 'info' => 'Coba Lagi!', 'message' => 'Nomor HP Sudah Terdaftar, Silahkan Coba Dengan Yang Lain.']);
    } else if($call->query("SELECT * FROM users WHERE email = '$post_email'")->num_rows == true) {
        message(['type' => 'warning', 'info' => 'Coba Lagi!', 'message' => 'Email Sudah Terdaftar, Silahkan Coba Dengan Yang Lain.']);
    } else if(is_numeric($post_pin) == FALSE) {
        message(['type' => 'warning', 'info' => 'Terjadi Kesalahan!', 'message' => 'Pin Keamanan Hanya Boleh Diisi Angka']);
    } else if(strlen($post_pin) < 6) {
        message(['type' => 'warning', 'info' => 'Terjadi Kesalahan!', 'message' => 'Pin Keamanan Tidak Boleh Kurang Dari 6']);
    } else if(strlen($post_pin) > 6) {
        message(['type' => 'warning', 'info' => 'Terjadi Kesalahan!', 'message' => 'Pin Keamanan Tidak Boleh Lebih Dari 6']);
    } else if(strtolower($post_referral) !== 'rgs-system' && $call->query("SELECT * FROM users WHERE referral = '$post_referral'")->num_rows == false) {
        message(['type' => 'warning', 'info' => 'Invalid Code!', 'message' => 'Kode Referral Tidak Valid.']);
    } else {
        $OTP = rand(111111,999999);
        $post_invited = (strtolower($post_referral) == 'rgs-system') ? 'RGS-SYSTEM' : $call->query("SELECT * FROM users WHERE referral = '$post_referral'")->fetch_assoc()['username'];
        $post_invitid = (strtolower($post_referral) == 'rgs-system') ? 'RGS-SYSTEM' : $call->query("SELECT * FROM users WHERE referral = '$post_referral'")->fetch_assoc()['name'];
        
        $result_wa = $WATL->sendMessage($post_phone, "Hallo $post_name, Kode OTP anda untuk aktifasi Akun adalah $OTP, Terimakasih Telah Bergabung bersama {$_CONFIG['title']}");
        $result_mail = mailer($_MAILER, [
            'dest' => $post_email,
            'name' => $post_name,
            'subject' => 'OTP Untuk '.$_CONFIG['title'].' Akun',
            'message' => base64_encode(mailplate('otp',[
                'name' => $post_name,
                'otp' => $OTP
            ])),
            'is_template' => 'yes'
        ]);
        
        $username = 'RGS-'.strtoupper(random(7));
        if($call->query("SELECT * FROM users WHERE username = '$username'")->num_rows == true) {
            $username = 'RGS-'.strtoupper(random(8));
        } else {
            $username = $username;
        }
        
        file_put_contents('.notifier', json_encode($result_wa, JSON_PRETTY_PRINT));
        if($result_mail == true || $result_wa['result'] == true) {
            $_SESSION['register'] = ['otp' => $OTP, 'data' => [
                'user' => $username,
                'email' => $post_email,
                'phone' => $post_phone,
                'name' => $post_name,
                'pin' => $post_pin,
                'reff' => $post_invited,
                'invt' => $post_invitid
            ]];
            message(['type' => 'success', 'info' => 'Verifikasi Akun Kamu', 'message' => 'Kami Telah Mengirimkan Kode OTP Ke Email Anda, Silakan Periksa. Dan Lengkapi Formulir Di Bawah Ini.']);
        } else {
            message(['type' => 'danger', 'info' => 'OTP Failed', 'message' => 'Gagal Kirim Kode OTP.']);
        }
    }
}
if(isset($_POST['resend_otp'])) {
    $data = ($_SESSION['register']['data']) ? $_SESSION['register']['data'] : $_SESSION['fp']['otp']['data'];
    $otp = ($_SESSION['register']['otp']) ? $_SESSION['register']['otp'] : $_SESSION['fp']['otp']['otp'];
    if($result_csrf == false) {
        message(['type' => 'danger', 'info' => 'System Error', 'message' => 'Silahkan coba beberapa saat lagi.']);
    } else if(!$data['name'] || !$otp || !$data['email']) {
        message(['type' => 'warning', 'info' => 'Terjadi Kesalahan!', 'message' => 'Masih Ada Formulir Kosong.']);
    } else {
        $result_wa = $WATL->sendMessage($data['phone'],"Hallo ".$data['name'].", Kode OTP anda untuk validasi Akun adalah ".$otp.", Terimakasih Telah Bergabung bersama {$_CONFIG['title']}");
        $result_mail = mailer($_MAILER,[
            'dest' => $data['email'],
            'name' => $data['name'],
            'subject' => 'OTP Untuk '.$_CONFIG['title'].' Akun',
            'message' => base64_encode(mailplate('otp',[
                'name' => $data['name'],
                'otp' => $otp
            ])),
            'is_template' => 'yes'
        ]);
        
        file_put_contents('.notifier',json_encode($result_wa, JSON_PRETTY_PRINT));
        if($result_mail == true || $result_wa['result'] == true) {
            message(['type' => 'success', 'info' => 'OTP Terkirim', 'message' => 'Kami Telah Mengirim Ulang Kode OTP Ke Email & Whatsapp Anda, Silakan Periksa.']);
        } else {
            message(['type' => 'danger', 'info' => 'OTP Failed!', 'message' => 'Gagal Kirim Kode OTP.']);
        }
    }
}
if(isset($_POST['otpreg'])) {
    $post_otp = filter($_POST['otp']);
    $data = $_SESSION['register']['data'];
    $reff = $_SESSION['register']['data']['reff'];
    $post_name = ucwords(strtolower($data['name']));
    $post_phone = filter_phone('0', filter($data['phone']));
    
    $ip = client_ip();
    $cookie_time = time() + (86400 * 90);
    $ShennCookie = random(86);
    
    if($result_csrf == false) {
        message(['type' => 'danger', 'info' => 'System Error', 'message' => 'Silahkan coba beberapa saat lagi.']);
    } else if(!$post_otp || !is_array($data)) {
        message(['type' => 'warning', 'info' => 'Terjadi Kesalahan!', 'message' => 'Masih Ada Formulir Kosong.']);
    } else if($post_otp <> $_SESSION['register']['otp']){
        message(['type' => 'warning', 'info' => 'Terjadi Kesalahan!', 'message' => 'Kode Otp Yang Anda Masukkan Salah, Harap Periksa Kembali.']);
    } else {
        $in = $call->query("INSERT INTO users VALUES (NULL,'$post_name','".$data['email']."','$post_phone','".$data['user']."','0','0','0','Basic','".strtoupper(random(6))."','$reff','active','$datetime', '".bcrypt($data['pin'],10)."')");
        if($in == true){
            $call->query("INSERT INTO users_api VALUES ('".$data['user']."','".random(8)."','".random(64)."','','development')");
            $kepo = $call->query("SELECT * FROM users WHERE username = '".$data['user']."'")->fetch_assoc();
            setcookie('ssid', 'SHENN-A'.$kepo['id'].'AIY', $cookie_time, '/', $_SERVER['HTTP_HOST']);
            setcookie('token', $ShennCookie, $cookie_time, '/', $_SERVER['HTTP_HOST']);
            $call->query("INSERT INTO users_cookie VALUES ('$ShennCookie', '".$data['user']."', '$datetime')");
            $_SESSION['user'] = $kepo;
            $call->query("INSERT INTO logs VALUES (NULL,'".$kepo['username']."','login','$ip','$datetime')");
            if(isset($_COOKIE['FCM_TOKEN'])) {
                $userFcm = $_COOKIE['FCM_TOKEN'];
                $call->query("INSERT INTO users_token VALUES (NULL,'".$kepo['username']."','$userFcm','$datetime')");
            }
            mailer($_MAILER, [
                'dest' => $data['email'],
                'name' => $data['name'],
                'subject' => 'Detail Untuk '.$_CONFIG['title'].' Akun',
                'message' => base64_encode(mailplate('detail', ['user' => $data])),
                'is_template' => 'yes'
            ]);
            unset($_SESSION['register']);
            message(['type' => 'success', 'info' => 'Pendaftaran Berhasil', 'message' => 'Terima Kasih Telah Mendaftar.']);
        } else {
            message(['type' => 'danger', 'info' => 'System Error', 'message' => 'An error occurred, please try again.'.$call->error]);
        }
    }
}
if(isset($_POST['fp_req'])) {
    $account = filter($_POST['account']);
    $OTP = rand(111111,999999);

    if($result_csrf == false) {
        message(['type' => 'danger', 'info' => 'System Error!', 'message' => 'Silahkan coba beberapa saat lagi.']);
    } else if(!$account) {
        message(['type' => 'warning', 'info' => 'Terjadi Kesalahan!', 'message' => 'Harap isi semua from.']);
    } else if($call->query("SELECT * FROM users WHERE email = '$account' OR phone = '$account'")->num_rows == 0) {
        message(['type' => 'warning', 'info' => 'Akun Invalid', 'message' => 'Pengguna tidak terdaftar']);
    } else {
        $data = $call->query("SELECT * FROM users WHERE email = '$account' OR phone = '$account'")->fetch_assoc();
        $result_wa = $WATL->sendMessage($data['phone'],"Hallo ".$data['name'].", Kode Verifikasi anda untuk Reset Passcode adalah {$OTP}, Terimakasih Telah Bergabung bersama {$_CONFIG['title']}");
        $result_mail = mailer($_MAILER,[
            'dest' => $data['email'],
            'name' => $data['name'],
            'subject' => 'OTP Untuk '.$_CONFIG['title'].' Akun',
            'message' => base64_encode(mailplate('otp',[
                'name' => $data['name'],
                'otp' => $OTP
            ])),
            'is_template' => 'yes'
        ]);
        file_put_contents('.notifier',json_encode($result_wa, JSON_PRETTY_PRINT));
        if($result_mail == true || $result_wa['result'] == true) {
            $_SESSION['fp']['otp'] = ['otp' => $OTP, 'data' => $data];
            message(['type' => 'success', 'info' => 'Permintaan Terkirim', 'message' => 'Kami Telah Mengirim Ulang Kode Verifikasi Ke Email & Whatsapp Anda, Silakan Periksa.']);
        } else {
            message(['type' => 'danger', 'info' => 'Kode Verifkasi Failed!', 'message' => 'Gagal Kirim Kode Verifikasi.']);
        }
    }
}
if(isset($_POST['fq_ver_otp'])) {
    $otp = filter($_POST['otp']);
    $data = $_SESSION['fp']['otp']['data'];
    var_dump($data);

    if($result_csrf == false) {
        message(['type' => 'danger', 'info' => 'System Error!', 'message' => 'Silahkan coba beberapa saat lagi.']);
    } else if(!$otp || !is_array($data)) {
        message(['type' => 'warning', 'info' => 'Terjadi Kesalahan!', 'message' => 'Harap isi semua from.']);
    } else if($otp <> $_SESSION['fp']['otp']['otp']){
        message(['type' => 'warning', 'info' => 'Terjadi Kesalahan!', 'message' => 'Kode Otp Yang Anda Masukkan Salah, Harap Periksa Kembali.']);
    } else {
        $_SESSION['fp']['reset'] = $data['id'];
        unset($_SESSION['fp']['otp']);
        message(['type' => 'success', 'info' => 'Verifikasi Berhasil', 'message' => 'Silahkan lanjut isi form dibawah ini.']);
    }
}
if(isset($_POST['fp_reset'])) {
    $pin = filter($_POST['pin']);
    $cpin = filter($_POST['cpin']);
    $id = $_SESSION['fp']['reset'];

    if($result_csrf == false) {
        message(['type' => 'danger', 'info' => 'System Error!', 'message' => 'Silahkan coba beberapa saat lagi.']);
    } else if(!$pin || !$cpin || !$id) {
        message(['type' => 'warning', 'info' => 'Terjadi Kesalahan!', 'message' => 'Harap isi semua from.']);
    } else if(is_numeric($pin) == FALSE || is_numeric($cpin) == FALSE) {
        message(['type' => 'warning', 'info' => 'Terjadi Kesalahan!', 'message' => 'Pin Keamanan Hanya Boleh Diisi Angka']);
    } else if(strlen($pin) < 6 || strlen($cpin) < 6) {
        message(['type' => 'warning', 'info' => 'Terjadi Kesalahan!', 'message' => 'Pin Keamanan Tidak Boleh Kurang Dari 6']);
    } else if(strlen($pin) > 6 || strlen($cpin) > 6) {
        message(['type' => 'warning', 'info' => 'Terjadi Kesalahan!', 'message' => 'Pin Keamanan Tidak Boleh Lebih Dari 6']);
    } else if($pin <> $cpin) {
        message(['type' => 'warning', 'info' => 'Terjadi Kesalahan!', 'message' => 'Passcode & Konfirmasi Passcode tidak sama']);
    } else if($call->query("SELECT * FROM users WHERE id = '$id'")->num_rows == 0) {
        message(['type' => 'warning', 'info' => 'Akun Invalid', 'message' => 'Pengguna tidak terdaftar']);
    } else {
        $pin = bcrypt($pin, 10);
        $db = $call->query("UPDATE users SET pin = '$pin' WHERE id = '$id'");
        if($db == true) {
            $data = $call->query("SELECT * FROM users WHERE id = '$id'")->fetch_assoc();
            $result_wa = $WATL->sendMessage($data['phone'], "Hallo {$data['name']}, Reset Passcode berhasil, PIN baru kamu sekarang {$cpin}, Terimakasih Telah Bergabung bersama {$_CONFIG['title']}");
            file_put_contents('.notifier', json_encode($result_wa, JSON_PRETTY_PRINT));
            unset($_SESSION['fp']);
            $_SESSION['result'] = ['type' => 'success', 'info' => 'Reset Passcode Berhasil', 'message' => 'Silahkan masuk untuk melanjutkan.'];
            redirect(0, desktop_url('login'));
        } else {
            message(['type' => 'danger', 'info' => 'System Error', 'message' => 'System sedang Error']);
        }
    }
}
if(isset($_POST['fp_cancel'])) {
    unset($_SESSION['fp']);
    redirect(0, desktop_url('forgot-passcode'));
}
if(isset($_POST['cancel'])) {
    unset($_SESSION['register']);
    redirect(0, desktop_url('register'));
}