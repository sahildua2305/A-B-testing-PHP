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

$p->data = array(array(266));
$p->intervals = array(200,300,400,600);
$p->chart_type = "meter";

// Common Options
$p->title = "Meter Gauge Chart";

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


