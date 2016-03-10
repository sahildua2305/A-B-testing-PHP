<?php
	
	include 'connection.inc.php';

	if(isset($_GET['variation'])){
		$curr_variation = htmlspecialchars($_GET['variation']);
		$test_id = htmlspecialchars($_GET['test_id']);

		$connection = mysqli_connect($mysql_host , $mysql_user , $mysql_pass, $mysql_data);
		if(!($connection)){
			die(mysqli_error($connection));
		}

		$query = mysqli_query($connection, "SELECT success_count FROM variation WHERE test_id='$test_id' AND variation_index='$curr_variation'") or die("error in getting");
		$count = 0;
		while($row = mysqli_fetch_array($query)){
			$count = $row['success_count'];
		}
		$count += 1;
		echo $count;
		mysqli_query($connection, "UPDATE variation SET success_count='$count' WHERE  test_id='$test_id' AND variation_index='$curr_variation'") or die("error in updating");
	}

?>