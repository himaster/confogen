<?php
	include 'db.php';

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
		$cert = $_GET['cert'];
		$test = $_GET['test'];
		$m = $_GET['m'];
		$mtest = $_GET['mtest'];
		$sql = "INSERT INTO `domains` (name, ip, http, https, test, m, mtest, cert) VALUES (\"$name\", \"$ip\", $http, $https, $test, $m, $mtest, \"$cert\");";
		$result = mysql_query($sql, $link)  or die(mysql_error());
	}

	$sql = "SELECT MAX(id) AS `max_id` FROM `domains`;";
	$result = mysql_query($sql, $link)  or die(mysql_error());
	$row = mysql_fetch_assoc($result);
	print_r($row);
	print_r($result);
	$sql = "SELECT * FROM `domains`;";
    $result = mysql_query($sql, $link)  or die(mysql_error());

    include 'table_view.html';
