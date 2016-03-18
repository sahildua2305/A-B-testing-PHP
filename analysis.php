<?php

	include("lib/inc/chartphp_dist.php");
<<<<<<< HEAD
	require_once('includes/connection.inc.php');
=======
>>>>>>> 120dee9f73b3debc4a2baca2a77794805c823a3d
	require_once('Database.php');

	
	$output = array();
	$connect = new Database();
	$query = $connect->select('test','*','ongoing=1');
	
	$j = 0;

	$row = array();
	foreach ($query as $row) {
		$test_id = $row['test_id'];

		$p = new chartphp();

		$p->data = array(array());
		$p->chart_type = "bar";

		$q = $connect->select('variation','*',"test_id='$test_id'");

		$i = 0;
		//$r = $query;
		//while(array_push($r,$query)
		foreach ($q as $r) {
			if($r['show_count'] != 0)
				$ratio = $r['success_count'] / $r['show_count'];
			else
				$ratio = 0.0;
			echo " . ";
			if($i == 0)
				array_push(($p->data)[0], array('A', $ratio));
			else if($i == 1)
				array_push(($p->data)[0], array('B', $ratio));
			$i += 1;
		}

		$p->title = "Performance analysis for - " . $row['test_name'];
		$p->ylabel = "Success rate";
		$p->export = true;
		$p->options["legend"]["show"] = true;

		$output[$j] = $p->render('c' . $j);

		$j += 1;
	}

?>
<!DOCTYPE html>
<html>
	<head>
		<script src="lib/js/jquery.min.js"></script>
		<script src="lib/js/chartphp.js"></script>
		<link rel="stylesheet" href="lib/js/chartphp.css">
	</head>
	<body>

		<?php

			foreach ($output as $key => $value) {
				echo '<div style="width:40%; min-width:450px;">' . $value . '</div><br><br><br>';		
			}

		?>
	</body>
</html>
