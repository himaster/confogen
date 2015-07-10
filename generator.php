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
    		fwrite($handle, "	listen ".$ip.":80;\n");
    		fwrite($handle, "	server_name ".$name.";\n\n");
	    	fwrite($handle, "	rewrite  ^/(.*)$  http://www.".$name."/$1  permanent;\n}\n\n");
	    	fwrite($handle, "## HTTP\n");
	    	fwrite($handle, "server {\n");
    		fwrite($handle, "	listen ".$ip.":80;\n");
    		fwrite($handle, "	server_name www.".$name.";\n\n");
	    	fwrite($handle, "	location / {\n");
	    	fwrite($handle, "		proxy_set_header	Host			\$http_host;\n");
	    	fwrite($handle, "		proxy_set_header	X-Real-IP		\$remote_addr;\n");
	    	fwrite($handle, "		proxy_set_header	X-Forwarded-For	\$proxy_add_x_forwarded_for;\n\n");
	    	fwrite($handle, "		proxy_pass					backend;\n}\n\n");
	    }
	    if ($https) {
	    	fwrite($handle, "## Add www to HTTPS\n");
    		fwrite($handle, "server {\n");
    		fwrite($handle, "	listen ".$ip.":443 ssl;\n");
    		fwrite($handle, "	server_name ".$name.";\n\n");
	    	fwrite($handle, "	rewrite  ^/(.*)$  https://www.".$name."/$1  permanent;\n}\n\n");
	    	fwrite($handle, "## HTTPS\n");
	    	fwrite($handle, "server {\n");
    		fwrite($handle, "	listen ".$ip.":443 ssl;\n");
    		fwrite($handle, "	server_name www.".$name.";\n\n");
	    	fwrite($handle, "	location / {\n");
	    	fwrite($handle, "		proxy_set_header	Host			\$http_host;\n");
	    	fwrite($handle, "		proxy_set_header	X-Real-IP		\$remote_addr;\n");
	    	fwrite($handle, "		proxy_set_header	X-Forwarded-For	\$proxy_add_x_forwarded_for;\n\n");
	    	fwrite($handle, "		proxy_pass					backend;\n}\n\n");
    	}

    	fclose($handle);

    }
?>