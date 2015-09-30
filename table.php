<?php
	include 'db.php';
	$workdir = '/etc/nginx/fpm-conf.d/balancer/';

	#element deleting
	if ($_GET['act'] == "remove") {
		$id = $_GET['id'];
		
		$sql    = "SELECT `name` FROM `domains` WHERE `id`=$id";
		$result = mysql_query($sql, $link)  or die(mysql_error());
		$array  = mysql_fetch_array($result);
		$name   = $array['name'];
		unlink($workdir.$name.".conf");

		$sql = "DELETE FROM `domains` WHERE id=$id;";
		$result = mysql_query($sql, $link)  or die(mysql_error());

	} elseif ($_GET['act'] == "edit") { #Editing
		$id = $_GET['id'];

		$sql    = "SELECT `name` FROM `domains` WHERE `id`=$id";
		$result = mysql_query($sql, $link)  or die(mysql_error());
		$array  = mysql_fetch_array($result);
		$name   = $array['name'];
		unlink($workdir.$name.".conf");

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
		if ($_GET['blog'] == "true")
			$blog = 1;
		else
			$blog = 0;
		$blogname = $_GET['blogname'];
		if ($_GET['m'] == "true")
			$m = 1;
		else
			$m = 0;
		if ($_GET['mtest'] == "true")
			$mtest = 1;
		else
			$mtest = 0;
		#$comment = $_GET['comment'];
		$comment = iconv('UTF-8', 'windows-1251', $_GET['comment']);
		$sql = "UPDATE `domains` SET name = '$name', ip = '$ip', http = '$http', https = '$https', cert = '$cert', test = '$test', blog = '$blog', blogname = '$blogname', m = '$m', mtest = '$mtest', comment = '$comment' WHERE id = '$id'";
		$result = mysql_query($sql, $link)  or die(mysql_error());
	}
	#Adding
	else if (!empty($_GET['name']) && !empty($_GET['ip'])) {
		$name = $_GET['name'];
		$ip = $_GET['ip'];
		$http = $_GET['http'];
		$https = $_GET['https'];
		$cert = $_GET['cert'];
		$test = $_GET['test'];
		$blog = $_GET['blog'];
		$blogname = $_GET['blogname'];
		$m = $_GET['m'];
		$mtest = $_GET['mtest'];
		$comment = $_GET['comment'];
		$sql = "INSERT INTO `domains` (name, ip, http, https, test, m, mtest, cert, blog, blogname, comment) VALUES (\"$name\", \"$ip\", $http, $https, $test, $m, $mtest, \"$cert\", $blog, \"$blogname\", '$comment');";
		$result = mysql_query($sql, $link)  or die(mysql_error());
	}

	$sql    = "SHOW TABLE STATUS LIKE 'domains'";
	$result = mysql_query($sql, $link)  or die(mysql_error());
	$array  = mysql_fetch_array($result);
	$max_id = $array['Auto_increment'];

	$sql = "SELECT * FROM `domains`;";
    $result = mysql_query($sql, $link)  or die(mysql_error());

    include 'table_view.html';
