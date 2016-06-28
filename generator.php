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
    	$www = $row['www'];
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
    		$prefix = "";
    		if ($www) $server_name = "www.";
    		$server_name .= $name;
    		if ($m) $server_name .= " m.".$name;
	    	fwrite($handle, "## Add/remove www\n");
	    	fwrite($handle, "server {\n");
	    	fwrite($handle, "	listen ".$ip.":80;\n");
	    	if ($www) {
	    		fwrite($handle, "	server_name ".$name.";\n\n");

		    	fwrite($handle, "	rewrite  ^/(.*)$  http://www.".$name."/$1  permanent;\n");
		    } else {
	    		fwrite($handle, "	server_name www.".$name.";\n\n");

		    	fwrite($handle, "	rewrite  ^/(.*)$  http://".$name."/$1  permanent;\n");
		    }
	    	fwrite($handle, "}\n\n");

	    	fwrite($handle, "## HTTP\n");
	    	fwrite($handle, "server {\n");
    		fwrite($handle, "	listen ".$ip.":80;\n");
    		fwrite($handle, "	server_name ".$server_name.";\n");
    		fwrite($handle, "	index				index.php index.html;\n");
    		fwrite($handle, "	root				/home/developer/www/fuel.prod/www;\n\n");

            fwrite($handle, "   if (\$request_uri ~* \"^(.*/)index\.(php|html)$\") {\n");
            fwrite($handle, "       return 301 $1;\n");
            fwrite($handle, "   }\n\n");

	    	fwrite($handle, "	location / {\n");
	    	fwrite($handle, "		try_files		\$uri \$uri/ /index.php?\$query_string;\n");
	    	fwrite($handle, "	}\n\n");

	    	if ($blog) {
	    		fwrite($handle, "	location /".$blogname."/ {\n");
            	fwrite($handle, "		rewrite ^/?".$blogname."$ /".$blogname."/ redirect;\n");
            	fwrite($handle, "		proxy_pass http://78.47.178.8;\n");
            	fwrite($handle, "		proxy_set_header Host \$host;\n");
            	fwrite($handle, "		proxy_set_header X-Real-IP \$remote_addr;\n");
            	fwrite($handle, "		proxy_set_header X-Forwarded-For \$proxy_add_x_forwarded_for;\n");
            	fwrite($handle, "		location ~* \.(jpg|jpeg|gif|png|bmp|swf|cur|gz|pdf|txt|js|css|php)$ {\n");
            	fwrite($handle, "			expires 7d;\n");
            	fwrite($handle, "			proxy_pass http://78.47.178.8;\n");
            	fwrite($handle, "			add_header Cache-Control public;\n");
            	fwrite($handle, "		}\n");
            	fwrite($handle, "	}\n\n");
            }

            fwrite($handle, "	location = /img/ec.png {\n");
        	fwrite($handle, "		proxy_pass		http://www.pkwteile.de/etracking;\n");
    		fwrite($handle, "	}\n\n");

            fwrite($handle, "	location ~* \.php$ {\n");
        	fwrite($handle, "		try_files               \$uri = 404;\n");
        	fwrite($handle, "		fastcgi_pass            backend_fpm;\n");
        	fwrite($handle, "		include                 fastcgi_params;\n");
        	fwrite($handle, "	}\n\n");

            fwrite($handle, "	location ~* \.(jpg|jpeg|gif|png|bmp|swf|css|js|cur|gz|pdf|img)$ {\n");
	    	fwrite($handle, "		access_log              off;\n");
	    	fwrite($handle, "		expires                 360d;\n");
	    	fwrite($handle, "		add_header              Cache-Control public;\n");
	    	fwrite($handle, "	}\n\n");

	    	fwrite($handle, "}\n\n");

	    }

    	if ($test) {
    		$server_name = "";
    		if ($www) $server_name = "test.";
    		$server_name .= $name;
    		if ($mtest) $server_name .= " mtest.".$name;
	    	fwrite($handle, "## Test\n");
	    	fwrite($handle, "server {\n");
    		fwrite($handle, "	listen ".$ip.":80;\n");
    		fwrite($handle, "	server_name ".$server_name.";\n");
    		fwrite($handle, "	index				index.php index.html;\n");
    		fwrite($handle, "	root				/home/developer/www/fuel.dev/www;\n\n");

            fwrite($handle, "   if (\$request_uri ~* \"^(.*/)index\.(php|html)$\") {\n");
            fwrite($handle, "       return 301 $1;\n");
            fwrite($handle, "   }\n\n");

	    	fwrite($handle, "	location / {\n");
	    	fwrite($handle, "		satisfy			any;\n");
			fwrite($handle, "		allow			188.138.234.131;\n");
			fwrite($handle, "		allow			217.89.150.114;\n");
			fwrite($handle, "		allow			178.93.126.106;\n");
	    	fwrite($handle, "		auth_basic		\"Restricted Area\";\n");
        	fwrite($handle, "		auth_basic_user_file	/etc/nginx/passwd;\n");
	    	fwrite($handle, "		try_files		\$uri \$uri/ /index.php?\$query_string;\n");
	    	fwrite($handle, "	}\n\n");

			fwrite($handle, "	location = /img/ec.png {\n");
        	fwrite($handle, "		proxy_pass		http://test.pkwteile.de/etracking;\n");
    		fwrite($handle, "	}\n\n");

            fwrite($handle, "	location ~* \.php$ {\n");
        	fwrite($handle, "		try_files               \$uri = 404;\n");
        	fwrite($handle, "		fastcgi_pass            backend_fpm;\n");
        	fwrite($handle, "		include                 fastcgi_params;\n");
        	fwrite($handle, "	}\n\n");


/*            fwrite($handle, "   location ~* \.php$ {\n");
            fwrite($handle, "       try_files               \$uri = 404;\n");
            fwrite($handle, "       set $bot    0;\n");
            fwrite($handle, "       if ($http_user_agent ~* \"googlebot|yahoo|bingbot|baiduspider|yandex|yeti|yodaobot|gigabot|ia_archiver|facebookexternalhit|twitterbot|developers\.google\.com\") {\n");
            fwrite($handle, "       set $bot    1;\n}\n");
            fwrite($handle, "       if ($bot = 1) {\n");
            fwrite($handle, "           fastcgi_pass            backend_fpm_bot;\n}\n");
            fwrite($handle, "       if ($bot = 0) {\n");
            fwrite($handle, "           fastcgi_pass            backend_fpm;\n}\n");
            fwrite($handle, "       include                 fastcgi_params;\n");
            fwrite($handle, "   }\n\n"); */

            fwrite($handle, "	location ~* \.(jpg|jpeg|gif|png|bmp|swf|css|js|cur|gz|pdf|img)$ {\n");
	    	fwrite($handle, "		access_log              off;\n");
	    	fwrite($handle, "		expires                 360d;\n");
	    	fwrite($handle, "		add_header              Cache-Control public;\n");
	    	fwrite($handle, "	}\n\n");

	    	fwrite($handle, "}\n\n");
	    }

	    if ($https) {
		    fwrite($handle, "## Add/remove www to HTTPS\n");
	    	fwrite($handle, "server {\n");
	    	fwrite($handle, "	listen ".$ip.":443 ssl;\n");
	    	if ($www) {
	    		fwrite($handle, "	server_name ".$name.";\n\n");

	    		fwrite($handle, "	rewrite	^/(.*)$  https://www.".$name."/$1  permanent;\n\n");
	    	} else {
	    		fwrite($handle, "	server_name www.".$name.";\n\n");

	    		fwrite($handle, "	rewrite	^/(.*)$  https://".$name."/$1  permanent;\n\n");
		    }
	    	fwrite($handle, "	ssl				on;\n");
			fwrite($handle, "	ssl_certificate			".$certfile.".crt;\n");
			fwrite($handle, "	ssl_certificate_key		".$certfile.".key;\n");
			fwrite($handle, "}\n\n");

	    	fwrite($handle, "## HTTPS\n");
	    	fwrite($handle, "server {\n");
    		fwrite($handle, "	listen ".$ip.":443 ssl;\n");
    		if ($www) {
    			fwrite($handle, "	server_name www.".$name.";\n");
    		} else {
    			fwrite($handle, "	server_name ".$name.";\n");
    		}
    		fwrite($handle, "	index 				index.php index.html;\n");
    		fwrite($handle, "	root 				/home/developer/www/fuel.prod/www;\n\n");

    		fwrite($handle, "	ssl				on;\n");
			fwrite($handle, "	ssl_certificate			".$certfile.".crt;\n");
			fwrite($handle, "	ssl_certificate_key		".$certfile.".key;\n\n");
			fwrite($handle, "	ssl_session_timeout		5m;\n");
    		fwrite($handle, "	ssl_protocols			TLSv1 TLSv1.1 TLSv1.2;\n");
    		fwrite($handle, "	ssl_ciphers			ALL:!ADH:!EXPORT56:RC4+RSA:+HIGH:+MEDIUM:+LOW:-SSLv2:+SSLv3::+EXP;\n");
    		fwrite($handle, "	ssl_session_cache		shared:SSL:1m;\n");
    		fwrite($handle, "	ssl_prefer_server_ciphers	on;\n\n");

            fwrite($handle, "   if (\$request_uri ~* \"^(.*/)index\.(php|html)$\") {\n");
            fwrite($handle, "       return 301 $1;\n");
            fwrite($handle, "   }\n\n");

	    	fwrite($handle, "	location / {\n");
	    	fwrite($handle, "		try_files		\$uri \$uri/ /index.php?\$query_string;\n");
	    	fwrite($handle, "	}\n\n");

            fwrite($handle, "	location ~* \.php$ {\n");
        	fwrite($handle, "		try_files               \$uri = 404;\n");
        	fwrite($handle, "		fastcgi_pass            backend_fpm;\n");
        	fwrite($handle, "		include                 fastcgi_params;\n");
        	fwrite($handle, "	}\n\n");

            fwrite($handle, "	location ~* \.(jpg|jpeg|gif|png|bmp|swf|css|js|cur|gz|pdf|img)$ {\n");
	    	fwrite($handle, "		access_log              off;\n");
	    	fwrite($handle, "		expires                 360d;\n");
	    	fwrite($handle, "		add_header              Cache-Control public;\n");
	    	fwrite($handle, "	}\n\n");

	    	fwrite($handle, "}\n\n");
    	}

    	fclose($handle);
    }
?>
