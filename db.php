<?php

	$dbuser = 'confogen';
	$dbpassword = 'Bie0gaen';
	$dbname = 'confogen';
<<<<<<< HEAD
	$dbhost = '127.0.0.1';
=======
    $dbhost = 'netbox.co';
>>>>>>> f735aab7fc8d4f43717abc540098fe3b2077d5ad

	#DB
	$link = mysql_connect($dbhost, $dbuser, $dbpassword);
	if (!$link) {
    	die('Ошибка соединения: ' . mysql_error());
	}

	$db_selected = mysql_select_db($dbname, $link);
	if (!$db_selected) {
    	die ('Не удалось выбрать базу foo: ' . mysql_error());
	}
