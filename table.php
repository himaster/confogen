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
		$cert 	= $_GET['cert'];
		$blogname = $_GET['blogname'];
		$comment = $_GET['comment'];
		if ($_GET['www'] == "true")
			$www	= 1;
		else
			$www	= 0;
		if ($_GET['http'] == "true")
			$http	= 1;
		else
			$http	= 0;
		if ($_GET['https'] == "true")
			$https	= 1;
		else
			$https	= 0;
		if ($_GET['test'] == "true")
			$test	= 1;
		else
			$test	= 0;
		if ($_GET['blog'] == "true")
			$blog	= 1;
		else
			$blog	= 0;
		if ($_GET['m'] == "true")
			$m		= 1;
		else
			$m		= 0;
		if ($_GET['mtest'] == "true")
			$mtest	= 1;
		else
			$mtest	= 0;
		$sql 	= "UPDATE `domains` SET name 	= '$name', 
									 	ip		= '$ip', 
									 	www		= '$www',
									 	http	= '$http', 
									 	https	= '$https', 
									 	cert	= '$cert', 
									 	test	= '$test', 
									 	blog	= '$blog', 
									 	blogname = '$blogname', 
									 	m		= '$m', 
									 	mtest	= '$mtest', 
									 	comment = '$comment' WHERE id = '$id'";
		$result = mysql_query($sql, $link)  or die(mysql_error());
	} elseif (!empty($_GET['name']) && !empty($_GET['ip'])) { #Adding
		$name	= $_GET['name'];
		$ip		= $_GET['ip'];
		$www	= $_GET['www'];
		$http	= $_GET['http'];
		$https	= $_GET['https'];
		$cert	= $_GET['cert'];
		$test	= $_GET['test'];
		$blog	= $_GET['blog'];
		$blogname = $_GET['blogname'];
		$m		= $_GET['m'];
		$mtest	= $_GET['mtest'];
		$comment = $_GET['comment'];
		$sql	= "INSERT INTO `domains` (name, ip, www, http, https, test, m, mtest, cert, blog, blogname, comment) 
					   			  VALUES (\"$name\", \"$ip\", $www, $http, $https, $test, $m, $mtest, \"$cert\", $blog, \"$blogname\", '$comment');";
		$result = mysql_query($sql, $link)  or die(mysql_error());
	}
	$sql    = "SHOW TABLE STATUS LIKE 'domains'";
	$result = mysql_query($sql, $link)  or die(mysql_error());
	$array  = mysql_fetch_array($result);
	$max_id = $array['Auto_increment'];
	$sql 	= "SELECT * FROM `domains`;";
    $result = mysql_query($sql, $link)  or die(mysql_error());
    include 'table_view.php';
