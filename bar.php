<?php

	include 'connection.inc.php'; 
	include("lib/inc/chartphp_dist.php");

	
	$test_query = mysqli_query($connection,"SELECT * FROM test WHERE ongoing=1") or die("error in getting");
	while($row = mysqli_fetch_array($test_query)){
		$test_id = $row['test_id'];

		$p = new chartphp();

		$p->data = array(array());
		$p->chart_type = "bar";

		$query = mysqli_query($connection, "SELECT * FROM variation WHERE test_id='$test_id'");
		$i = 0;
		while($r = mysqli_fetch_array($query)){
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

		$out = $p->render('c1');

		break;
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
		<div style="width:40%; min-width:450px;">
			<?php echo $out; ?>
		</div> 
	</body>
</html>


