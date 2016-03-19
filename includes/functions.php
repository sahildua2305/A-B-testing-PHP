<?php
	$connect = new Database();

	function increment_success_count ($connection, $curr_variation, $test_id) {
		$query = $connect->select('variation',array('success_count'),"test_id='$test_id' AND variation_index='$curr_variation'"); 
		$count = 0;
		
		foreach ($query as $row) {
			$count = $row->success_count;
		}
		$count += 1;
		// echo $count;
		$connect->update('variation',array('success_count'),array($count),"test_id='$test_id' AND variation_index='$curr_variation'"); 
		}

	function connect($mysql_host, $mysql_user, $mysql_pass, $mysql_data){
		$connect->DB();
	}
