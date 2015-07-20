<?php
	include 'db.php';
	$workdir = '/etc/nginx/fpm-conf.d/balancer/';

	#element delete
	if ($_GET['act'] == "remove") {
		$id = $_GET['id'];
		
		$sql    = "SELECT `name` FROM `domains` WHERE `id`=$id";
		$result = mysql_query($sql, $link)  or die(mysql_error());
		$array  = mysql_fetch_array($result);
		$name   = $array['name'];
		unlink($workdir.$name.".conf");

		$sql = "DELETE FROM `domains` WHERE id=$id;";
		$result = mysql_query($sql, $link)  or die(mysql_error());

	} elseif ($_GET['act'] == "edit") {
		$id = $_GET['id'];
		$name = $_GET['name'];
		$ip = $_GET['ip'];
		if ($_GET['http'] == "true")
			$http = 1;
		else
			$http = 0;
		if ($_GET['https'] == "true")
			$https = 1;
		else
			$https = 0;
		$cert = $_GET['cert'];
		if ($_GET['test'] == "true")
			$test = 1;
		else
			$test = 0;
		if ($_GET['m'] == "true")
			$m = 1;
		else
			$m = 0;
		if ($_GET['mtest'] == "true")
			$mtest = 1;
		else
			$mtest = 0;
		$sql = "UPDATE `domains` SET name = '$name', ip = '$ip', http = '$http', https = '$https', cert = '$cert', test = '$test', m = '$m', mtest = '$mtest' WHERE id = '$id'";
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

	$sql    = "SHOW TABLE STATUS LIKE 'domains'";
	$result = mysql_query($sql, $link)  or die(mysql_error());
	$array  = mysql_fetch_array($result);
	$max_id = $array['Auto_increment'];

	$sql = "SELECT * FROM `domains`;";
    $result = mysql_query($sql, $link)  or die(mysql_error());

    include 'table_view.html';
