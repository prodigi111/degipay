<?php
if(isset($_POST['add'])) {
    $post_1 = filter(ucwords(strtolower($_POST['name'])));
    $post_2 = filter($_POST['email']);
    $post_3 = filter_phone('0',$_POST['phone']);
    $post_4 = 'RGS-'.strtoupper(random(7));
    $post_5 = rand(111111,999999);
    $post_6 = filter($_POST['level']);
    $post_7 = $data_user['username'];
    $post_AcceptMail = ['gmail.com','yahoo.com','outlook.com','icloud.com','shenn.id'];
    $referral = strtoupper(random(6));
    
    if($result_csrf == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'System error, please try again later.'];
    } else if($data_user['level'] !== 'Admin') {
        $_SESSION['result'] = ['type' => false,'message' => 'You do not have permission to access this feature.'];
    } else if($sess_username == 'demo') {
        $_SESSION['result'] = ['type' => false,'message' => 'Demo accounts do not have permission to access this feature.'];
    } else if(!in_array($post_6,['Basic','Premium','Admin']) || !$post_5 || !$post_4 || !$post_3 || !$post_2 || !$post_1) {
        $_SESSION['result'] = ['type' => false,'message' => 'Masih Ada Formulir Kosong.'];
    } else if(!in_array(explode('@',$post_2)[1],$post_AcceptMail)) {
        $_SESSION['result'] = ['type' => false,'message' => 'Email is not supported.'];
    } else if($call->query("SELECT * FROM users WHERE phone = '$post_3'")->num_rows == true) {
        $_SESSION['result'] = ['type' => false,'message' => 'Nomor HP Sudah Terdaftar, Silahkan Coba Dengan Yang Lain.'];
    } else if($call->query("SELECT * FROM users WHERE email = '$post_2'")->num_rows == true) {
        $_SESSION['result'] = ['type' => false,'message' => 'Email Sudah Terdaftar, Silahkan Coba Dengan Yang Lain.'];
    } else {
        
        if($call->query("SELECT * FROM users WHERE username = '$post_4'")->num_rows == true) {
            $post_4 = 'RGS-'.strtoupper(random(8));
        } else {
            $post_4 = $post_4;
        }
        
        $result_mail = mailer($_MAILER,[
            'dest' => $post_2,
            'name' => $post_1,
            'subject' => 'Detail Untuk '.$_CONFIG['title'].' Akun',
            'message' => base64_encode(mailplate('detail',[
                'user' => [
                    'user' => $post_4,
                    'email' => $post_2,
                    'phone' => $post_3,
                    'name' => $post_1,
                    'pin' => $post_5,
                    'referral' => $referral,
                    'level' => $post_6,
                    'joined' => $date.' '.$time
                ]
            ])),
            'is_template' => 'yes'
        ]);
        
        $result_notif = $result_mail;
        if($result_notif == true) {
            $in = $call->query("INSERT INTO users VALUES ('','$post_1','$post_2','$post_3','$post_4','0','0','0','$post_6','$referral','$post_7','active','$date $time', '".bcrypt($post_5,10)."')");
            if($in == true){
                $call->query("INSERT INTO users_api VALUES ('$post_4','".random(8)."','".random(64)."','','development')");
                $_SESSION['result'] = ['type' => true,'message' => 'Registration was successful.'];
            } else {
                $_SESSION['result'] = ['type' => false,'message' => 'An error occurred, please try again.'];
            }
        } else {
            $_SESSION['result'] = ['type' => false,'message' => 'Failed Send Mailer.'];
        }
    }
}

if(isset($_POST['edit'])) {
    $postwt = filter(base64_decode($_POST['web_token']));
    $post_1 = filter(ucwords(strtolower($_POST['name'])));
    $post_2 = filter_phone('0',$_POST['phone']);
    $post_3 = filter($_POST['level']);
    $post_4 = filter($_POST['status']);
    $post_5 = filter($_POST['balance']);    
    $post_6 = filter($_POST['komisi']);
    $post_7 = filter($_POST['point']);
    
    if($result_csrf == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'System error, please try again later.'];
    } else if($data_user['level'] !== 'Admin') {
        $_SESSION['result'] = ['type' => false,'message' => 'You do not have permission to access this feature.'];
    } else if($sess_username == 'demo') {
        $_SESSION['result'] = ['type' => false,'message' => 'Demo accounts do not have permission to access this feature.'];
    } else if(!in_array($post_4,['suspend','active','locked']) || !in_array($post_3,['Admin','Premium','Basic'])) {
        $_SESSION['result'] = ['type' => false,'message' => 'Masih Ada Formulir Kosong.'];
    } else if($call->query("SELECT id FROM users WHERE id = '$postwt'")->num_rows == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'User not found.'];
    } else {
        $tkn_usr = $call->query("SELECT * FROM users WHERE id = '$postwt'")->fetch_assoc();
        
        $up = $call->query("UPDATE users SET name = '$post_1', phone = '$post_2', level = '$post_3', status = '$post_4', balance = '$post_5', komisi = '$post_6', point = '$post_7' WHERE id = '$postwt'");
        if($up == true){
            $_SESSION['result'] = ['type' => true,'message' => $tkn_usr['name'].' account successfully edited.'];
        } else {
            $_SESSION['result'] = ['type' => false,'message' => 'An error occurred, please try again.'];
        }
    }
}