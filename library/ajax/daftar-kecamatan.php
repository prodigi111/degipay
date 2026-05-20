<?php
require '../../connect.php';

if (isset($_POST['kota'])) {
	$post_kota = mysqli_real_escape_string($call, $_POST['kota']);
	$check_service = $call->query("SELECT * FROM daftar_kecamatan WHERE regency_id = '$post_kota' ORDER BY name ASC");
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