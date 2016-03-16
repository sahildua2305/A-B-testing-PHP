<?php

	include 'includes/connection.inc.php'; 
	include("lib/inc/chartphp_dist.php");

	
	$output = array();

	$sql="SELECT * FROM test WHERE ongoing=1";
	$test_query = $connection->prepare($sql);
	$test_query->execute();

	$j = 0;

	$row = array();
	while($row = $test_query->fetch()){
		$test_id = $row['test_id'];

		$p = new chartphp();

		$p->data = array(array());
		$p->chart_type = "bar";

		$sql="SELECT * FROM variation WHERE test_id='$test_id'";
		$query = $connection->prepare($sql);
		$query->execute();

		$i = 0;
		$r = array();
		while($r = $query->fetch()){
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
