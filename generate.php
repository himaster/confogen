<?php
	include 'db.php';
	$workdir = '/etc/nginx/fpm-conf.d/balancer/';
	$sql = "SELECT * FROM `domains`;";
    $result = mysql_query($sql, $link)  or die(mysql_error());
    while ($row = mysql_fetch_assoc($result)) {
    	$id = $row['id'];
    	$name = $row['name'];
    	$ip = $row['ip'];
    	$http = $row['http'];
    	$https = $row['https'];
    	$test = $row['test'];
    	$m = $row['m'];
    	$mtest = $row['mtest'];
    	$file = $workdir.$name.'.conf';
    	echo $file;
    	#file_put_contents($file, $current);
    }
?>