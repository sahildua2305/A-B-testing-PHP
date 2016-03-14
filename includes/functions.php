<?php

	function increment_success_count ($connection, $curr_variation, $test_id) {
		$query = mysqli_query($connection, "SELECT success_count FROM variation WHERE test_id='$test_id' AND variation_index='$curr_variation'") or die("error in getting");
		$count = 0;
		while($row = mysqli_fetch_array($query)){
			$count = $row['success_count'];
		}
		$count += 1;
		// echo $count;
		mysqli_query($connection, "UPDATE variation SET success_count='$count' WHERE  test_id='$test_id' AND variation_index='$curr_variation'") or die("error in updating");
	}

	function connect($mysql_host, $mysql_user, $mysql_pass, $mysql_data){
		$connection = mysqli_connect($mysql_host , $mysql_user , $mysql_pass, $mysql_data);
		return $connection;
	}
