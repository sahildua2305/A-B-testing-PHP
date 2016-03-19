<?php
/**
 * @Author: sahildua2305
 * @Date:   2016-03-10 01:01:24
 * @Last Modified by:   Sahil Dua
 * @Last Modified time: 2016-03-19 23:42:09
 */
// require_once('includes/connection.inc.php');
require_once('Database.php');
require_once('abms.php');

$my_test = new abms('hyperlink text 2', 6*70707070, TRUE);

$my_test->add_variation(0, 'Sahil Dua');
$my_test->add_variation(1, 'Mansimar Kaur');

// $index = $my_test->get_user_segment();
// echo $my_test->variations[$index];

?>

<!DOCTYPE html>
<html>
	<head>

	</head>

	<body>
		<?php

			$index = $my_test->get_user_segment();

			if($my_test->is_test_over()){

				$val = $my_test->access_variations($index);
				$text = $val['value'];
				echo'<a href="success.php">' . $text . '</a>';

			}
			else{
				if($index == -1){
					$text = "#ego";
				}
				else{
					$val = $my_test->access_variations($index);
					$text = $val['value'];
				}

				echo'<a href="success.php?variation=' . $index . '&test_id=' . $my_test->get_test_id() . '">' . $text . '</a>';
			}

		?>
	</body>
</html>
