<?php
/**
 * @Author: sahildua2305
 * @Date:   2016-03-10 01:01:24
 * @Last Modified by:   Sahil Dua
 * @Last Modified time: 2016-03-10 02:01:24
 */

require_once('abms.php');

$my_test = new abms('hyperlink text', 24*60*60, FALSE);

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
			if($index == -1){
				$text = "#ego";
			}
			else{
				$val = $my_test->access_variations($index);
				$text = $val['value'];
			}
			echo'<a href="success.php?variations='.$index.'">'.$text.'</a>';
		?>
	</body>
</html>
