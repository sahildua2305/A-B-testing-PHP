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

$p->data = array(array(array(60, 123, 1067, "Acura"), array(11, 92, 1236, "Alfa Romeo"), array(30, 200, 610, "AM General"), array(50, 23, 800, "Aston"), array(18, 17, 539, "Audi"), array(50, 89, 1026, "BMW"), array(99, 13, 864, "Bugatti")));
$p->chart_type = "bubble";

// Common Options
$p->title = "Bubble Chart";
$p->xlabel = "My X Axis";
$p->ylabel = "My Y Axis";

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


