<?php
	$dbuser = 'confogen';
	$dbpassword = 'Bie0gaen';
	$dbname = 'confogen';

	#DB
	$link = mysql_connect('localhost', $dbuser, $dbpassword);
	if (!$link) {
    	die('Ошибка соединения: ' . mysql_error());
	}
	
	$db_selected = mysql_select_db($dbname, $link);
	if (!$db_selected) {
    	die ('Не удалось выбрать базу foo: ' . mysql_error());
	}

	#element delete
	if (isset($_GET['remove'])) {
		$id = $_GET['id'];
		$sql = "DELETE FROM `domains` WHERE id=$id;";
		$result = mysql_query($sql, $link)  or die(mysql_error());
	}

	#Form submit
	else if (!empty($_GET['name']) && !empty($_GET['ip'])) {
		$name = $_GET['name'];
		$ip = $_GET['ip'];
		$http = $_GET['http'];
		$https = $_GET['https'];
		$test = $_GET['test'];
		$m = $_GET['m'];
		$mtest = $_GET['mtest'];

		$sql = "INSERT INTO `domains` (name, ip, http, https, test, m, mtest) VALUES (\"$name\", \"$ip\", $http, $https, $test, $m, $mtest);";
		$result = mysql_query($sql, $link)  or die(mysql_error());
	}


    include 'table_view.php';
