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

$p->data = array(array(array('a',6), array('b',8), array('c',14), array('d',20)));
$p->chart_type = "donut";

// Common Options
$p->title = "Donut Chart";

$out = $p->render('c1');
?>
<!DOCTYPE html>
<html>
	<head>
		<script src="../../lib/js/jquery.min.js"></script>
		<script src="../../lib/js/chartphp.js"></script>
		<link rel="stylesheet" href="../../lib/js/chartphp.css">
	</head>

	<style>
	/* white color data labels */
	.jqplot-data-label{color:white;}
	</style>
	
	<body>
		<div style="width:40%; min-width:450px;">
			<?php echo $out; ?>
		</div>
	</body>
</html>


