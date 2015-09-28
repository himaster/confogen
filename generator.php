<?php
	sleep(3);
	include 'db.php';
	$workdir = '/var/www/balancer/';
	$certdir = '/etc/nginx/certs/';
	$id = $_GET['id'];
	if ($id == "undefined") {
		$files = glob($workdir.'*'); // get all file names
		foreach($files as $file){ // iterate files
  			if(is_file($file)) unlink($file); // delete file
		}
		$sql = "SELECT * FROM `domains`;";
	} 
	elseif ($id == "") {
		exit("You can't call this script directly.");
	} 
	else {
		$sql = "SELECT * FROM `domains` WHERE id=".$id.";";
		echo("id= ".$id);
	}
    $result = mysql_query($sql, $link) or die(mysql_error());
    while ($row = mysql_fetch_assoc($result)) {
    	$id = $row['id'];
    	$name = $row['name'];
    	$ip = $row['ip'];
    	$http = $row['http'];
    	$https = $row['https'];
    	$blog = $row['blog'];
    	$test = $row['test'];
    	$m = $row['m'];
    	$mtest = $row['mtest'];
    	$cert = $row['cert'];
    	$blogname = $row['blogname'];
    	$comment = $row['comment'];
    	
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
	    	fwrite($handle, "		proxy_pass					http://backend;\n	}\n\n");
	    	if ($blog) {
	    		fwrite($handle, "	location /".$blogname."/ {\n");
            	fwrite($handle, "		rewrite ^/?".$blogname."$ /".$blogname."/ redirect;\n");
            	fwrite($handle, "		proxy_pass http://78.47.178.8;\n");
            	fwrite($handle, "		proxy_set_header Host \$host;\n");
            	fwrite($handle, "		proxy_set_header X-Real-IP \$remote_addr;\n");
            	fwrite($handle, "		proxy_set_header X-Forwarded-For \$proxy_add_x_forwarded_for;\n");
            	fwrite($handle, "		location ~* \.(jpg|jpeg|gif|png|bmp|swf|cur|gz|pdf|txt|php)$ {\n");
            	fwrite($handle, "			expires 7d;\n");
            	fwrite($handle, "			proxy_pass http://78.47.178.8;\n");
            	fwrite($handle, "			add_header Cache-Control public;\n		}\n}\n");
            }
            fwrite($handle, "	location ~* \.(jpg|jpeg|gif|png|bmp|swf|cur)$ {\n");
	    	fwrite($handle, "		access_log              off;\n");
	    	fwrite($handle, "		expires                 360d;\n");
	    	fwrite($handle, "		add_header              Cache-Control public;\n\n");
	    	fwrite($handle, "		proxy_pass              http://backend;\n	}\n");
	    	fwrite($handle, "}\n\n");
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
    		fwrite($handle, "	ssl							on;\n");
			fwrite($handle, "	ssl_certificate				".$certfile.".crt;\n");
			fwrite($handle, "	ssl_certificate_key			".$certfile.".key;\n\n");
			fwrite($handle, "	ssl_session_timeout			5m;\n");
    		fwrite($handle, "	ssl_protocols				TLSv1 TLSv1.1 TLSv1.2;\n");
    		fwrite($handle, "	ssl_ciphers					ALL:!ADH:!EXPORT56:RC4+RSA:+HIGH:+MEDIUM:+LOW:-SSLv2:+SSLv3::+EXP;\n");
    		fwrite($handle, "	ssl_session_cache			shared:SSL:1m;\n");
    		fwrite($handle, "	ssl_prefer_server_ciphers	on;\n");
	    	fwrite($handle, "	location / {\n");
	    	fwrite($handle, "		proxy_set_header		Host			\$http_host;\n");
	    	fwrite($handle, "		proxy_set_header		X-Real-IP		\$remote_addr;\n");
	    	fwrite($handle, "		proxy_set_header		X-Forwarded-For	\$proxy_add_x_forwarded_for;\n\n");
	    	fwrite($handle, "		proxy_pass				http://backend_ssl;\n	}\n");
	    	fwrite($handle, "	location ~* \.(jpg|jpeg|gif|png|bmp|swf|cur)$ {\n");
	    	fwrite($handle, "		access_log              off;\n");
	    	fwrite($handle, "		expires                 360d;\n");
	    	fwrite($handle, "		add_header              Cache-Control public;\n\n");
	    	fwrite($handle, "		proxy_pass              http://backend_ssl;\n	}\n");
	    	fwrite($handle, "}\n\n");
    	}
    	if ($test) {
	    	fwrite($handle, "## Test\n");
	    	fwrite($handle, "server {\n");
    		fwrite($handle, "	listen ".$ip.":80;\n");
    		fwrite($handle, "	server_name test.".$name.";\n\n");
	    	fwrite($handle, "	location / {\n");
	    	fwrite($handle, "		satisfy					any;\n");
			fwrite($handle, "		allow					188.138.234.131;\n");
			fwrite($handle, "		allow					217.89.150.114;\n");
	    	fwrite($handle, "		auth_basic				\"Restricted Area\";\n");
        	fwrite($handle, "		auth_basic_user_file	/etc/nginx/passwd;\n");
	    	fwrite($handle, "		proxy_set_header		Host			\$http_host;\n");
	    	fwrite($handle, "		proxy_set_header		X-Real-IP		\$remote_addr;\n");
	    	fwrite($handle, "		proxy_set_header		X-Forwarded-For	\$proxy_add_x_forwarded_for;\n\n");
	    	fwrite($handle, "		proxy_pass				http://backend;\n	}\n\n");
	    	fwrite($handle, "	location ~* \.(jpg|jpeg|gif|png|bmp|swf|cur)$ {\n");
	    	fwrite($handle, "		access_log              off;\n");
	    	fwrite($handle, "		expires                 360d;\n");
	    	fwrite($handle, "		add_header              Cache-Control public;\n\n");
	    	fwrite($handle, "		proxy_pass              http://backend;\n	}\n");	
	    	fwrite($handle, "}\n\n");
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
	    	fwrite($handle, "		proxy_pass					http://backend;\n	}\n");
	    	fwrite($handle, "	location ~* \.(jpg|jpeg|gif|png|bmp|swf|cur)$ {\n");
	    	fwrite($handle, "		access_log              off;\n");
	    	fwrite($handle, "		expires                 360d;\n");
	    	fwrite($handle, "		add_header              Cache-Control public;\n\n");
	    	fwrite($handle, "		proxy_pass              http://backend;\n	}\n");
	    	fwrite($handle, "}\n\n");
	    }
	    if ($mtest) {
	    	fwrite($handle, "## Mtest\n");
	    	fwrite($handle, "server {\n");
    		fwrite($handle, "	listen ".$ip.":80;\n");
    		fwrite($handle, "	server_name mtest.".$name.";\n\n");
	    	fwrite($handle, "	location / {\n");
	    	fwrite($handle, "		auth_basic				\"Restricted Area\";\n");
        	fwrite($handle, "		auth_basic_user_file	/etc/nginx/passwd;\n");
	    	fwrite($handle, "		proxy_set_header		Host			\$http_host;\n");
	    	fwrite($handle, "		proxy_set_header		X-Real-IP		\$remote_addr;\n");
	    	fwrite($handle, "		proxy_set_header		X-Forwarded-For	\$proxy_add_x_forwarded_for;\n\n");
	    	fwrite($handle, "		proxy_pass				http://backend;\n	}\n");
	    	fwrite($handle, "	location ~* \.(jpg|jpeg|gif|png|bmp|swf|cur)$ {\n");
	    	fwrite($handle, "		access_log              off;\n");
	    	fwrite($handle, "		expires                 360d;\n");
	    	fwrite($handle, "		add_header              Cache-Control public;\n\n");
	    	fwrite($handle, "		proxy_pass              http://backend;\n	}\n");
	    	fwrite($handle, "}\n\n");
	    }

    	fclose($handle);
    }
?>