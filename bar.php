<?php

 
include("lib/inc/chartphp_dist.php");

$p = new chartphp();

$p->data = array(array(array("A",48.25),array("B",286.80)));
$p->chart_type = "bar";

// Common Options
$p->title = "Bar Chart";
$p->xlabel = "My X Axis";
$p->ylabel = "My Y Axis";
$p->export = false;
$p->options["legend"]["show"] = true;
$p->series_label = array('Q1','Q2'); 

$out = $p->render('c1');
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


