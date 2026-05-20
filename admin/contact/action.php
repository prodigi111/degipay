<?php
if(isset($_POST['add'])) {
    $post_1 = filter(ucwords(strtolower($_POST['name'])));
    $post_2 = filter($_POST['level']);
    $post_3 = filter($_POST['facebook']);
    $post_4 = filter_phone('62',$_POST['phone']);
    $post_5 = filter($_POST['line']);
    $post_6 = filter($_POST['instagram']);
    $post_7 = filter($_POST['email']);
    $post_8 = filter($_POST['url_foto']);
    
    if($result_csrf == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'System error, please try again later.'];
    } else if($data_user['level'] !== 'Admin') {
        $_SESSION['result'] = ['type' => false,'message' => 'You do not have permission to access this feature.'];
    } else if($sess_username == 'demo') {
        $_SESSION['result'] = ['type' => false,'message' => 'Demo accounts do not have permission to access this feature.'];
    } else if(!$post_1 || !in_array($post_2,['developer','admin','staff'])) {
        $_SESSION['result'] = ['type' => false,'message' => 'There are still empty columns.'];
    } else {
        $in = $call->query("INSERT INTO contact VALUES ('','$post_1','$post_2','$post_3','$post_8','$post_4','$post_5','$post_6','$post_7')");
        if($in == true){
            $_SESSION['result'] = ['type' => true,'message' => 'Contact successfully added.'];
        } else {
            $_SESSION['result'] = ['type' => false,'message' => 'An error occurred, please try again.'];
        }
    }
}

if(isset($_POST['edit'])) {
    $postwt = filter(base64_decode($_POST['web_token']));
    $post_1 = filter(ucwords(strtolower($_POST['name'])));
    $post_2 = $_POST['level'];
    $post_3 = filter($_POST['facebook']);
    $post_4 = filter_phone('62',$_POST['phone']);
    $post_5 = filter($_POST['line']);
    $post_6 = filter($_POST['instagram']);
    $post_7 = filter($_POST['email']);
    $post_8 = filter($_POST['url_foto']);
    
    if($result_csrf == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'System error, please try again later.'];
    } else if($data_user['level'] !== 'Admin') {
        $_SESSION['result'] = ['type' => false,'message' => 'You do not have permission to access this feature.'];
    } else if($sess_username == 'demo') {
        $_SESSION['result'] = ['type' => false,'message' => 'Demo accounts do not have permission to access this feature.'];
    } else if(!$post_1 || !in_array($post_2,['ceo & founder','developer','admin','staff'])) {
        $_SESSION['result'] = ['type' => false,'message' => 'There are still empty columns.'];
    } else if($call->query("SELECT id FROM contact WHERE id = '$postwt'")->num_rows == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'Contact not found.'];
    } else {
        $up = $call->query("UPDATE contact SET name = '$post_1', level = '$post_2', facebook = '$post_3', url_foto = '$post_8', whatsapp = '$post_4', line = '$post_5', instagram = '$post_6', email = '$post_7' WHERE id = '$postwt'");
        if($up == true){
            $_SESSION['result'] = ['type' => true,'message' => 'Contact successfully edited.'];
        } else {
            $_SESSION['result'] = ['type' => false,'message' => 'An error occurred, please try again.'];
        }
    }
}

if(isset($_POST['delete'])) {
    $postwt = filter(base64_decode($_POST['web_token']));
    $search = $call->query("SELECT * FROM contact WHERE id = '$postwt'");
    if($search->num_rows == 1) $row = $search->fetch_assoc();
    if($result_csrf == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'System error, please try again later.'];
    } else if($data_user['level'] !== 'Admin') {
        $_SESSION['result'] = ['type' => false,'message' => 'You do not have permission to access this feature.'];
    } else if($sess_username == 'demo') {
        $_SESSION['result'] = ['type' => false,'message' => 'Demo accounts do not have permission to access this feature.'];
    } else if($call->query("SELECT id FROM contact WHERE id = '$postwt'")->num_rows == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'Contact not found.'];
    } else if($row['level'] == 'ceo & founder') {
        $_SESSION['result'] = ['type' => false,'message' => 'Can\'t delete CEO & Founder.'];
    } else {
        $up = $call->query("DELETE FROM contact WHERE id = '$postwt'");
        if($up == true){
            $_SESSION['result'] = ['type' => true,'message' => 'Contact successfully deleted.'];
        } else {
            $_SESSION['result'] = ['type' => false,'message' => 'An error occurred, please try again.'];
        }
    }
}