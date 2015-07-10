<?php
	include 'db.php';
	$workdir = '/etc/nginx/fpm-conf.d/balancer/';
	$certdir = '/etc/nginx/certs/';
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
    	$cert = $row['cert'];
    	
    	$file = $workdir.$name.'.conf';
    	$certfile = $certdir.$cert;

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
    		fwrite($handle, "	ssl				on;\n");
			fwrite($handle, "	ssl_certificate			".$certfile.".crt;\n");
			fwrite($handle, "	ssl_certificate_key		".$certfile.".key;\n\n");
	    	fwrite($handle, "	rewrite	^/(.*)$  https://www.".$name."/$1  permanent;\n}\n\n");
	    	fwrite($handle, "## HTTPS\n");
	    	fwrite($handle, "server {\n");
    		fwrite($handle, "	listen ".$ip.":443 ssl;\n");
    		fwrite($handle, "	server_name www.".$name.";\n\n");
    		fwrite($handle, "	ssl				on;\n");
			fwrite($handle, "	ssl_certificate			".$certfile.".crt;\n");
			fwrite($handle, "	ssl_certificate_key		".$certfile.".key;\n\n");
	    	fwrite($handle, "	location / {\n");
	    	fwrite($handle, "		proxy_set_header	Host			\$http_host;\n");
	    	fwrite($handle, "		proxy_set_header	X-Real-IP		\$remote_addr;\n");
	    	fwrite($handle, "		proxy_set_header	X-Forwarded-For	\$proxy_add_x_forwarded_for;\n\n");
	    	fwrite($handle, "		proxy_pass					backend_ssl;\n}\n\n");
    	}
    	if ($test) {
	    	fwrite($handle, "## Test\n");
	    	fwrite($handle, "server {\n");
    		fwrite($handle, "	listen ".$ip.":80;\n");
    		fwrite($handle, "	server_name test.".$name.";\n\n");
	    	fwrite($handle, "	location / {\n");
	    	fwrite($handle, "		proxy_set_header	Host			\$http_host;\n");
	    	fwrite($handle, "		proxy_set_header	X-Real-IP		\$remote_addr;\n");
	    	fwrite($handle, "		proxy_set_header	X-Forwarded-For	\$proxy_add_x_forwarded_for;\n\n");
	    	fwrite($handle, "		proxy_pass					backend;\n}\n\n");
	    }
	    if ($m) {
	    	fwrite($handle, "## M\n");
	    	fwrite($handle, "server {\n");
    		fwrite($handle, "	listen ".$ip.":80;\n");
    		fwrite($handle, "	server_name m.".$name.";\n\n");
	    	fwrite($handle, "	location / {\n");
	    	fwrite($handle, "		proxy_set_header	Host			\$http_host;\n");
	    	fwrite($handle, "		proxy_set_header	X-Real-IP		\$remote_addr;\n");
	    	fwrite($handle, "		proxy_set_header	X-Forwarded-For	\$proxy_add_x_forwarded_for;\n\n");
	    	fwrite($handle, "		proxy_pass					backend;\n}\n\n");
	    }
	    if ($mtest) {
	    	fwrite($handle, "## Mtest\n");
	    	fwrite($handle, "server {\n");
    		fwrite($handle, "	listen ".$ip.":80;\n");
    		fwrite($handle, "	server_name mtest.".$name.";\n\n");
	    	fwrite($handle, "	location / {\n");
	    	fwrite($handle, "		proxy_set_header	Host			\$http_host;\n");
	    	fwrite($handle, "		proxy_set_header	X-Real-IP		\$remote_addr;\n");
	    	fwrite($handle, "		proxy_set_header	X-Forwarded-For	\$proxy_add_x_forwarded_for;\n\n");
	    	fwrite($handle, "		proxy_pass					backend;\n}\n\n");
	    }

    	fclose($handle);
    }
?>