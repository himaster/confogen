<?php
	include 'db.php';
	$workdir	= '/etc/nginx/fpm-conf.d/balancer/';
	if ($_GET['act'] == "remove") { #Deleting
		$id 	= $_GET['id'];
		$sql    = "SELECT `name` FROM `domains` WHERE `id`=$id";
		$result = mysql_query($sql, $link)  or die(mysql_error());
		$array  = mysql_fetch_array($result);
		$name   = $array['name'];
		unlink($workdir.$name.".conf");
		$sql 	= "DELETE FROM `domains` WHERE id=$id;";
		$result = mysql_query($sql, $link)  or die(mysql_error());
	} elseif ($_GET['act'] == "edit") { #Editing
		$id 	= $_GET['id'];
		$sql    = "SELECT `name` FROM `domains` WHERE `id`=$id";
		$result = mysql_query($sql, $link)  or die(mysql_error());
		$array  = mysql_fetch_array($result);
		$name   = $array['name'];
		unlink($workdir.$name.".conf");
		$name 	= $_GET['name'];
		$ip 	= $_GET['ip'];
		$project = $_GET['project'];
		$cert 	= $_GET['cert'];
		$comment = $_GET['comment'];
		if ($_GET['http'] == "true") $http	= 1;
		else $http	= 0;
		if ($_GET['https'] == "true") $https	= 1;
		else $https	= 0;
		if ($_GET['test'] == "true") $test	= 1;
		else $test	= 0;
		$sql 	= "UPDATE `domains` SET name 	 = '$name',
									 	ip		 = '$ip',
									 	project  = '$project',
									 	http	 = '$http',
									 	https	 = '$https',
									 	cert	 = '$cert',
									 	test	 = '$test',
									 	comment  = '$comment' WHERE id = '$id'";
		$result = mysql_query($sql, $link)  or die(mysql_error());
	} elseif (!empty($_GET['name']) && !empty($_GET['ip'])) { #Adding
		$name	= $_GET['name'];
		$ip		= $_GET['ip'];
		$project = $_GET['project'];
		$http	= $_GET['http'];
		$https	= $_GET['https'];
		$cert	= $_GET['cert'];
		$test	= $_GET['test'];
		$comment = $_GET['comment'];
		$sql	= "INSERT INTO `domains` (name, ip, project, http, https, test, cert, comment)
					   			  VALUES (\"$name\", \"$ip\", \"$project\", $http, $https, $test, \"$cert\", \"$comment\");";
		$result = mysql_query($sql, $link)  or die(mysql_error());
	}
	$sql      = "SHOW TABLE STATUS LIKE 'domains'";
	$result   = mysql_query($sql, $link)  or die(mysql_error());
	$array    = mysql_fetch_array($result);
	$max_id   = $array['Auto_increment'];
    $sql      = "SELECT DISTINCT(project) FROM `confogen`.`domains`;";
    $projects = mysql_query($sql, $link) or die(mysql_error());

    include 'table_view.php';
