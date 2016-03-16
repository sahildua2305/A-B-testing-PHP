<?php

	function increment_success_count ($connection, $curr_variation, $test_id) {
		$query = mysqli_query($connection, "SELECT success_count FROM variation WHERE test_id='$test_id' AND variation_index='$curr_variation'") or die("error in getting");
		$count = 0;
		$row = array();
		while(array_push($row, $query->fetch())){
			$count = $row['success_count'];
		}
		$count += 1;
		// echo $count;
		$sql="UPDATE variation SET success_count='$count' WHERE  test_id='$test_id' AND variation_index='$curr_variation'";
		$query=$connection->prepare($sql); 
		$query->execute();	}

	function connect($mysql_host, $mysql_user, $mysql_pass, $mysql_data){
		$options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING);
		$connection = new PDO("mysql: host=$mysql_host;dbname=$mysql_data" , $mysql_user , $mysql_pass, $options );		return $connection;
	}
