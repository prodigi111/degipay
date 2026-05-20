 <?php
if(isset($_POST['add-blacklist'])) {
    $post_1 = filter_phone('0',$_POST['phone']);
    
    if($result_csrf == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'System error, please try again later.'];
    } else if($data_user['level'] !== 'Admin') {
        $_SESSION['result'] = ['type' => false,'message' => 'You do not have permission to access this feature.'];
    } else if($sess_username == 'demo') {
        $_SESSION['result'] = ['type' => false,'message' => 'Demo accounts do not have permission to access this feature.'];
    } else if(!$post_1) {
        $_SESSION['result'] = ['type' => false,'message' => 'Masih Ada Formulir Kosong.'];
    } else if($call->query("SELECT * FROM users WHERE phone = '$post_1'")->num_rows == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'Nomor HP Belum Terdaftar, Silahkan Coba Dengan Yang Lain.'];
    } else {
        $_users = $call->query("SELECT * FROM users WHERE phone = '$post_1'")->fetch_assoc();
        
            $in = $call->query("INSERT INTO users_blacklist (username, phone) VALUES ('".$_users['username']."','$post_1')");
            if($in == true){
                $_SESSION['result'] = ['type' => true,'message' => 'Add Blacklist was successful.'];
            } else {
                $_SESSION['result'] = ['type' => false,'message' => 'An error occurred, please try again.'];
            }
    }
}
if(isset($_POST['delete'])) {
    $post_token = filter(base64_decode($_POST['web_token']));
    if($result_csrf == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'System error, please try again later.'];
    } else if($data_user['level'] !== 'Admin') {
        $_SESSION['result'] = ['type' => false,'message' => 'You do not have permission to access this feature.'];
    } else if($sess_username == 'demo') {
        $_SESSION['result'] = ['type' => false,'message' => 'Demo accounts do not have permission to access this feature.'];
    } else if($call->query("SELECT username FROM users_blacklist WHERE username = '$post_token'")->num_rows == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'Users not found.'];
    } else {
        $up = $call->query("DELETE FROM users_blacklist WHERE username = '$post_token'");
        if($up == TRUE) {
            $_SESSION['result'] = ['type' => true,'message' => 'Users Blacklist deleted successfully.'];
        } else {
            $_SESSION['result'] = ['type' => false,'message' => 'Our server is in trouble, please try again later.'];
        }
    }
}