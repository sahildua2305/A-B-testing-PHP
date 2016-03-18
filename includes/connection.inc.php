<?php
<<<<<<< HEAD
	
	 $mysql_host = 'localhost';
	 $mysql_user = 'root';
	 $mysql_pass = '';
	 $mysql_data = 'ab_testing';
	
?>
=======

	global $mysql_host = 'localhost';
	global $mysql_user = 'root';
	global $mysql_pass = '';
	global $mysql_data = 'ab_testing';

	global $connection;

	$options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING);
	$connection = new PDO("mysql: host = $mysql_host; dbname = $mysql_data",$mysql_user,$mysql_pass,$options);
>>>>>>> 120dee9f73b3debc4a2baca2a77794805c823a3d
