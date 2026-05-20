<?php
require '../../connect.php';

if (isset($_POST['provinsi'])) {
	$post_provinsi = mysqli_real_escape_string($call, $_POST['provinsi']);
	$check_service = $call->query("SELECT * FROM daftar_kota WHERE province_id = '$post_provinsi' ORDER BY name ASC");
	?>
	<option value="0">- Select One -</option>
	<?php
	while ($data_service = mysqli_fetch_assoc($check_service)) {
	?>
	<option value="<?php echo $data_service['code'];?>"><?php echo $data_service['name'];?></option>
	<?php
	}
} else {
?>
<option value="0">Error.</option>
<?php
}