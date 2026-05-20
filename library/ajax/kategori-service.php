<?php
require '../../connect.php';
require _DIR_('library/session/session');

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    if(!$_POST['type']) exit("No direct script access allowed!");
    $search = $call->query("SELECT * FROM category WHERE type = '".$_POST['type']."' ORDER BY name ASC");
    if($search->num_rows == false) {
        print '<option value="" selected disabled>Kategori Tidak Ditemukan...</option>';
    } else {
        print '<option value="">- Select One -</option>';
        while($row = $search->fetch_assoc()) {
            print '<option value="'.$row['code'].'">'.$row['name'].'</option>';
        }
    }
} else {
    exit("No direct script access allowed!");
}