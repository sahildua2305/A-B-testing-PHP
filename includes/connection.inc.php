<?php

	global $mysql_host = 'localhost';
	global $mysql_user = 'root';
	global $mysql_pass = '';
	global $mysql_data = 'ab_testing';

	global $connection;

	$options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING);
	$connection = new PDO("mysql: host = $mysql_host; dbname = $mysql_data",$mysql_user,$mysql_pass,$options);
