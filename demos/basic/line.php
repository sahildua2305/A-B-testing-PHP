<?php
/**
 * Charts 4 PHP
 *
 * @author Shani <support@chartphp.com> - http://www.chartphp.com
 * @version 1.2.3
 * @license: see license.txt included in package
 */
 
include("../../lib/inc/chartphp_dist.php");

$p = new chartphp();

$p->data = array(array(array("Jan",48.25),array("Feb",238.75),array("Mar",95.50),array("Apr",300.50),array("May",286.80),array("Jun",400)),array(array("Jan",300.25),array("Feb",225.75),array("Mar",44.50),array("Apr",259.50),array("May",250.80),array("Jun",300)));

$p->chart_type = "line";

// Common Options
$p->title = "Sales - 2014 vs 2015";
$p->ylabel = "Sales";
$p->series_label = array("2014","2015");

$p->options["axes"]["yaxis"]["tickOptions"]["prefix"] = '$';

$out = $p->render('c1');
?>
<!DOCTYPE html>
<html>
	<head>
		<script src="../../lib/js/jquery.min.js"></script>
		<script src="../../lib/js/chartphp.js"></script>
		<link rel="stylesheet" href="../../lib/js/chartphp.css">
	</head>
	<body>
		<div style="width:40%; min-width:450px;">
			<?php echo $out; ?>
		</div>
	</body>
</html>