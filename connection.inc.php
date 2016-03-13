<?php

	$mysql_host = 'localhost';
	$mysql_user = 'root';
	$mysql_pass = '';
	$mysql_data = 'ab_testing';

	global $connection;

	if(!$connection = mysqli_connect($mysql_host , $mysql_user , $mysql_pass, $mysql_data))
		die(mysqli_error($connection));
