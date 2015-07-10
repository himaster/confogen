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

    	$handle = fopen($file, "w+");
    	if ($http) {
    		fwrite($handle, "## Add www\n");
    		fwrite($handle, "server {\n");
    		fwrite($handle, "    listen ".$ip.":80;\n");
    		fwrite($handle, "    server_name ".$name.";\n\n");
	    	fwrite($handle, "    rewrite  ^/(.*)$  http://www.".$name."/$1  permanent;\n}\n");
	    	fwrite($handle, "## HTTP");
	    	
    	}

    	fclose($handle);

    }
?>