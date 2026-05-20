<?php
require '../RGShenn.php';
require _DIR_('library/session/user');

if(isset($_POST["query"]))
{	

	$data = array();

	$condition = preg_replace('/[^A-Za-z0-9\- ]/', '', $_POST["query"]);

	$query = "SELECT data FROM trx WHERE user = '$sess_username' AND data LIKE '%".$condition."%' GROUP BY data ORDER BY id DESC";

	$result = $call->query($query);

	$replace_string = '<b>'.$condition.'</b>';

	foreach($result as $row)
	{
		$data[] = array(
			'data'		=>	str_ireplace($condition, $replace_string, $row["data"])
		);
	}

	echo json_encode($data);
}

$post_data = json_decode(file_get_contents('php://input'), true);

if(isset($post_data['search_query']))
{

	$data = array(
		':search_query'		=>	$post_data['search_query']
	);

	$query = "SELECT data FROM trx WHERE data = :search_query
	";

	$statement = $call->prepare($query);

	$statement->execute($data);
	if($statement->rowCount() == 0)
	{
		$query = "SELECT data FROM trx WHERE user = '$sess_username'";

		$statement = $connect->prepare($query);

		$statement->execute($data);
	}

	$output = array(
		'success'	=>	true
	);

	echo json_encode($output);

}

if(isset($post_data['action']))
{
	if($post_data['action'] == 'fetch')
	{
		$query = "SELECT data, COUNT(data) as sering FROM trx WHERE user = '$sess_username' GROUP BY data ORDER BY sering DESC LIMIT 10";

		$result = $call->query($query);

		$data = array();

		foreach($result as $row)
		{

			$data[] = array(
				'id'				=>	$row['id'],
				'search_query'		=>	$row["data"]
			);
		}

		echo json_encode($data);
	}

}
?>