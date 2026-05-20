<?php
require '../../RGShenn.php';
require _DIR_('library/session/session');

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    if(!isset($_SESSION['user'])) exit("No direct script access allowed!");
    if(!isset($_POST['request']) || !in_array($_POST['request'],['service','price'])) exit("No direct script access allowed!");
    
    if($_POST['request'] == 'service') {
        if(!isset($_POST['category'])) exit("No direct script access allowed!");
        if(empty($_POST['category'])) exit("<option value='0' disabled selected>- Select One -</option>");
        
        $search = $call->query("SELECT * FROM srv WHERE brand = '".filter($_POST['category'])."' AND type = 'pascabayar' AND status = 'available' ORDER BY price ASC");
        print '<option value="0" disabled selected>- Select One -</option>';
        while($row = $search->fetch_assoc()) { print('<option value="'.$row['code'].'">'.$row['name'].'</option>'); }
    } else if($_POST['request'] == 'price') {
        if(!isset($_POST['service'])) exit("No direct script access allowed!");
        if(empty($_POST['service'])) exit(json_encode(['price' => 'Rp 0','note' => '']));
        
        $search = $call->query("SELECT * FROM srv WHERE code = '".filter($_POST['service'])."' AND status = 'available'");
        if($search->num_rows == 0) {
            print json_encode(['price' => 'Rp 0','note' => '']);
        } else {
            $row = $search->fetch_assoc();
            print json_encode(['price' => 'Rp '.currency(price($data_user['level'],$row['price'])),'note' => $row['note']]);
        }
    } else {
        exit("No direct script access allowed!");
    }
} else {
	exit("No direct script access allowed!");
}