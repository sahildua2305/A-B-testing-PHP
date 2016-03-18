<?php
	
	require_once('Database.php');
	include 'includes/functions.php';

	if(isset($_GET['variation'])){
		$curr_variation = htmlspecialchars($_GET['variation']);
		$test_id = htmlspecialchars($_GET['test_id']);
		$connection = connect($mysql_host, $mysql_user, $mysql_pass, $mysql_data);

		increment_success_count($connection, $curr_variation, $test_id);
	}

?>
