<?php
if(isset($_POST['add'])) {
    
    $title = $_POST['title'];
    $category = $_POST['category'];
    $content = $_POST['content'];
    
    if($result_csrf == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'System error, please try again later.'];
    } else if($data_user['level'] !== 'Admin') {
        $_SESSION['result'] = ['type' => false,'message' => 'You do not have permission to access this feature.'];
    } else if($sess_username == 'demo') {
        $_SESSION['result'] = ['type' => false,'message' => 'Demo accounts do not have permission to access this feature.'];
    } else if (!$title OR !$category OR !$content) {
        $_SESSION['result'] = ['type' => false,'message' => 'Masih ada data yang kosong'];
    } else {
        
        if ($_FILES['image']['error'] == 0) {
            
            $image = uniqid() . $_FILES['image']['name'];
            
            $upload = move_uploaded_file($_FILES['image']['tmp_name'], '../../library/assets/images/post/' . $image);
            
            if ($upload) {
                
                $call->query("INSERT INTO post VALUES ('','$title','$category','$image','$content','".date('Y-m-d G:i:s')."')");
                
                $_SESSION['result'] = ['type' => true,'message' => 'Data rekomendasi pilihan berhasil ditambahkan'];
            }
        } else {
            $_SESSION['result'] = ['type' => false,'message' => 'Thumbnail tidak boleh kosong'];
        }
    }
}

if(isset($_POST['edit'])) {
    
    $id = $_POST['id'];
    $title = $_POST['title'];
    $category = $_POST['category'];
    $content = $_POST['content'];
    $image_old = $_POST['image_old'];
    
    if($result_csrf == false) {
        $_SESSION['result'] = ['type' => false,'message' => 'System error, please try again later.'];
    } else if($data_user['level'] !== 'Admin') {
        $_SESSION['result'] = ['type' => false,'message' => 'You do not have permission to access this feature.'];
    } else if($sess_username == 'demo') {
        $_SESSION['result'] = ['type' => false,'message' => 'Demo accounts do not have permission to access this feature.'];
    } else if (!$title OR !$category OR !$content) {
        $_SESSION['result'] = ['type' => false,'message' => 'Masih ada data yang kosong'];
    } else {
        
        if ($_FILES['image']['error'] == 0) {
            
            $image = uniqid() . $_FILES['image']['name'];
            
            $upload = move_uploaded_file($_FILES['image']['tmp_name'], '../../library/assets/images/post/' . $image);
            
            if ($upload == false) {
                $image = $image_old;
            }
        } else {
            $image = $image_old;
        }
        
        $call->query("UPDATE post SET title = '$title', category = '$category', content = '$content', image = '$image' WHERE id = '$id'");
                
        $_SESSION['result'] = ['type' => true,'message' => 'Data rekomendasi pilihan berhasil disimpan'];
    }
}

if (isset($_GET['hapus'])) {
    
    mysqli_query($call, "DELETE FROM post WHERE id = '".$_GET['hapus']."'");
    
    $_SESSION['result'] = ['type' => true,'message' => 'Data rekomendasi pilihan berhasil dihapus'];
}