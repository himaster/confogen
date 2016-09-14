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
        $project = $row['project'];
    	$http = $row['http'];
    	$https = $row['https'];
    	$test = $row['test'];
    	$cert = $row['cert'];
    	$comment = $row['comment'];
    	$file = $workdir.$name.'.conf';
    	$certfile = $certdir.$cert;

    	$handle = fopen($file, "w+");

    	if ($http) {
    		$prefix = "";
    		$server_name = $name;

	    	fwrite($handle, "## HTTP\n");
	    	fwrite($handle, "server {\n");
    		fwrite($handle, "   listen ".$ip.":80;\n");
    		fwrite($handle, "   server_name ".$server_name.";\n");
    		fwrite($handle, "   index               index.php index.html;\n");
    		fwrite($handle, "   root                /home/developer/www/cdn/www;\n\n");

            fwrite($handle, "   set \$cdn \"\";\n\n");
            fwrite($handle, "   if (\$request_uri !~ /makers/.*) {\n");
            fwrite($handle, "      set \$cdn 1\$cdn;\n");
            fwrite($handle, "   }\n");
            fwrite($handle, "   if (\$request_uri !~ .*.thumb?.*) {\n");
            fwrite($handle, "      set \$cdn 2\$cdn;\n");
            fwrite($handle, "   }\n");
            fwrite($handle, "   if (\$request_uri !~ /groups/.*) {\n");
            fwrite($handle, "      set \$cdn 3\$cdn;\n");
            fwrite($handle, "   }\n");
            fwrite($handle, "   if (\$request_uri !~ /uploads/.*) {\n");
            fwrite($handle, "      set \$cdn 4\$cdn;\n");
            fwrite($handle, "   }\n");
            fwrite($handle, "   if (\$request_uri !~ /brands/.*) {\n");
            fwrite($handle, "      set \$cdn 5\$cdn;\n");
            fwrite($handle, "   }\n");
            fwrite($handle, "   if (\$request_uri !~ /favicon.ico) {\n");
            fwrite($handle, "      set \$cdn 6\$cdn;\n");
            fwrite($handle, "   }\n");
            fwrite($handle, "   if (\$request_uri !~ /robots.txt) {\n");
            fwrite($handle, "      set \$cdn 7\$cdn;\n");
            fwrite($handle, "   }\n");
            fwrite($handle, "   if (\$request_uri !~ /timer/.*) {\n");
            fwrite($handle, "      set \$cdn 8\$cdn;\n");
            fwrite($handle, "   }\n");
            fwrite($handle, "   if (\$cdn = \"87654321\") {\n");
            fwrite($handle, "      return 444;\n");
            fwrite($handle, "   }\n\n");

	    	fwrite($handle, "   location / {\n");
	    	fwrite($handle, "      try_files               \$uri \$uri/ /thumb/index.php?\$query_string;\n");
	    	fwrite($handle, "   }\n\n");

            fwrite($handle, "   location /timer/ {\n");
            fwrite($handle, "      location ~* \.gif$ {\n");
            fwrite($handle, "         try_files               \$uri \$uri/ /timer/index.php?uri=\$uri;\n");
            fwrite($handle, "      }\n\n");
            fwrite($handle, "      location ~* \.php$ {\n");
            fwrite($handle, "          try_files               \$uri = 404;\n");
            fwrite($handle, "          fastcgi_pass            backend_fpm;\n");
            fwrite($handle, "          include                 fastcgi_params;\n");
            fwrite($handle, "      }\n");
            fwrite($handle, "   }\n\n");

            fwrite($handle, "   location ~* \.php$ {\n");
        	fwrite($handle, "      try_files               \$uri = 404;\n");
        	fwrite($handle, "      fastcgi_pass            backend_fpm;\n");
        	fwrite($handle, "      include                 fastcgi_params;\n");
            fwrite($handle, "      expires                 360d;\n");
            fwrite($handle, "      add_header              Cache-Control public;\n");
        	fwrite($handle, "   }\n\n");

            fwrite($handle, "   location ~* \.(jpg|jpeg|gif|png|bmp|swf|css|js|cur|gz|pdf|img)$ {\n");
	    	fwrite($handle, "      access_log              off;\n");
	    	fwrite($handle, "      expires                 360d;\n");
	    	fwrite($handle, "      add_header              Cache-Control public;\n");
	    	fwrite($handle, "   }\n\n");

	    	fwrite($handle, "}\n\n");

	    }

    	if ($test) {
    		$server_name = "t".$name;

	    	fwrite($handle, "## Test\n");
	    	fwrite($handle, "server {\n");
    		fwrite($handle, "   listen ".$ip.":80;\n");
    		fwrite($handle, "   server_name ".$server_name.";\n");
    		fwrite($handle, "   index				index.php index.html;\n");
    		fwrite($handle, "   root				/home/developer/www/tcdn/www;\n\n");
            fwrite($handle, "   set \$cdn \"\";\n\n");
            fwrite($handle, "   if (\$request_uri !~ /makers/.*) {\n");
            fwrite($handle, "      set \$cdn 1\$cdn;\n");
            fwrite($handle, "   }\n");
            fwrite($handle, "   if (\$request_uri !~ .*.thumb?.*) {\n");
            fwrite($handle, "      set \$cdn 2\$cdn;\n");
            fwrite($handle, "   }\n");
            fwrite($handle, "   if (\$request_uri !~ /groups/.*) {\n");
            fwrite($handle, "      set \$cdn 3\$cdn;\n");
            fwrite($handle, "   }\n");
            fwrite($handle, "   if (\$request_uri !~ /uploads/.*) {\n");
            fwrite($handle, "      set \$cdn 4\$cdn;\n");
            fwrite($handle, "   }\n");
            fwrite($handle, "   if (\$request_uri !~ /brands/.*) {\n");
            fwrite($handle, "      set \$cdn 5\$cdn;\n");
            fwrite($handle, "   }\n");
            fwrite($handle, "   if (\$request_uri !~ /favicon.ico) {\n");
            fwrite($handle, "      set \$cdn 6\$cdn;\n");
            fwrite($handle, "   }\n");
            fwrite($handle, "   if (\$request_uri !~ /robots.txt) {\n");
            fwrite($handle, "      set \$cdn 7\$cdn;\n");
            fwrite($handle, "   }\n");
            fwrite($handle, "   if (\$request_uri !~ /timer/.*) {\n");
            fwrite($handle, "      set \$cdn 8\$cdn;\n");
            fwrite($handle, "   }\n");
            fwrite($handle, "   if (\$cdn = \"87654321\") {\n");
            fwrite($handle, "      return 444;\n");
            fwrite($handle, "   }\n\n");

	    	fwrite($handle, "   location / {\n");
	    	fwrite($handle, "	   satisfy              any;\n");
			fwrite($handle, "      allow                188.138.234.131;\n");
			fwrite($handle, "      allow                217.89.150.114;\n");
			fwrite($handle, "      allow                178.93.126.106;\n");
	    	fwrite($handle, "      auth_basic		    \"Restricted Area\";\n");
        	fwrite($handle, "      auth_basic_user_file	/etc/nginx/passwd;\n");
	    	fwrite($handle, "      try_files            \$uri \$uri/ /thumb/index.php?\$query_string;\n");
	    	fwrite($handle, "	}\n\n");

            fwrite($handle, "   location /timer/ {\n");
            fwrite($handle, "      location ~* \.gif$ {\n");
            fwrite($handle, "         try_files               \$uri \$uri/ /timer/index.php?uri=\$uri;\n");
            fwrite($handle, "      }\n\n");
            fwrite($handle, "      location ~* \.php$ {\n");
            fwrite($handle, "          try_files               \$uri = 404;\n");
            fwrite($handle, "          fastcgi_pass            backend_fpm;\n");
            fwrite($handle, "          include                 fastcgi_params;\n");
            fwrite($handle, "      }\n");
            fwrite($handle, "   }\n\n");

            fwrite($handle, "   location ~* \.php$ {\n");
            fwrite($handle, "      try_files               \$uri = 404;\n");
            fwrite($handle, "      fastcgi_pass            backend_fpm;\n");
            fwrite($handle, "      include                 fastcgi_params;\n");
            fwrite($handle, "      expires                 360d;\n");
            fwrite($handle, "      add_header              Cache-Control public;\n");
            fwrite($handle, "   }\n\n");

            fwrite($handle, "   location ~* \.(jpg|jpeg|gif|png|bmp|swf|css|js|cur|gz|pdf|img)$ {\n");
            fwrite($handle, "      access_log              off;\n");
            fwrite($handle, "      expires                 360d;\n");
            fwrite($handle, "      add_header              Cache-Control public;\n");
            fwrite($handle, "   }\n\n");

            fwrite($handle, "}\n\n");
	    }

	    if ($https) {
	    	fwrite($handle, "## HTTPS\n");
	    	fwrite($handle, "server {\n");
    		fwrite($handle, "	listen ".$ip.":443 ssl;\n");
    		fwrite($handle, "	server_name ".$name.";\n");

    		fwrite($handle, "	index 				index.php index.html;\n");
    		fwrite($handle, "	root 				/home/developer/www/cdn/www;\n\n");

    		fwrite($handle, "	ssl				on;\n");
			fwrite($handle, "	ssl_certificate			".$certfile.".crt;\n");
			fwrite($handle, "	ssl_certificate_key		".$certfile.".key;\n\n");
			fwrite($handle, "	ssl_session_timeout		5m;\n");
    		fwrite($handle, "	ssl_protocols			TLSv1 TLSv1.1 TLSv1.2;\n");
    		fwrite($handle, "	ssl_ciphers			ALL:!ADH:!EXPORT56:RC4+RSA:+HIGH:+MEDIUM:+LOW:-SSLv2:+SSLv3::+EXP;\n");
    		fwrite($handle, "	ssl_session_cache		shared:SSL:1m;\n");
    		fwrite($handle, "	ssl_prefer_server_ciphers	on;\n\n");


            fwrite($handle, "   set \$cdn \"\";\n\n");
            fwrite($handle, "   if (\$request_uri !~ /makers/.*) {\n");
            fwrite($handle, "      set \$cdn 1\$cdn;\n");
            fwrite($handle, "   }\n");
            fwrite($handle, "   if (\$request_uri !~ .*.thumb?.*) {\n");
            fwrite($handle, "      set \$cdn 2\$cdn;\n");
            fwrite($handle, "   }\n");
            fwrite($handle, "   if (\$request_uri !~ /groups/.*) {\n");
            fwrite($handle, "      set \$cdn 3\$cdn;\n");
            fwrite($handle, "   }\n");
            fwrite($handle, "   if (\$request_uri !~ /uploads/.*) {\n");
            fwrite($handle, "      set \$cdn 4\$cdn;\n");
            fwrite($handle, "   }\n");
            fwrite($handle, "   if (\$request_uri !~ /brands/.*) {\n");
            fwrite($handle, "      set \$cdn 5\$cdn;\n");
            fwrite($handle, "   }\n");
            fwrite($handle, "   if (\$request_uri !~ /favicon.ico) {\n");
            fwrite($handle, "      set \$cdn 6\$cdn;\n");
            fwrite($handle, "   }\n");
            fwrite($handle, "   if (\$request_uri !~ /robots.txt) {\n");
            fwrite($handle, "      set \$cdn 7\$cdn;\n");
            fwrite($handle, "   }\n");
            fwrite($handle, "   if (\$request_uri !~ /timer/.*) {\n");
            fwrite($handle, "      set \$cdn 8\$cdn;\n");
            fwrite($handle, "   }\n");
            fwrite($handle, "   if (\$cdn = \"87654321\") {\n");
            fwrite($handle, "      return 444;\n");
            fwrite($handle, "   }\n\n");

            fwrite($handle, "   location / {\n");
            fwrite($handle, "      try_files               \$uri \$uri/ /thumb/index.php?\$query_string;\n");
            fwrite($handle, "   }\n\n");

            fwrite($handle, "   location /timer/ {\n");
            fwrite($handle, "      location ~* \.gif$ {\n");
            fwrite($handle, "         try_files               \$uri \$uri/ /timer/index.php?uri=\$uri;\n");
            fwrite($handle, "      }\n\n");
            fwrite($handle, "      location ~* \.php$ {\n");
            fwrite($handle, "          try_files               \$uri = 404;\n");
            fwrite($handle, "          fastcgi_pass            backend_fpm;\n");
            fwrite($handle, "          include                 fastcgi_params;\n");
            fwrite($handle, "      }\n");
            fwrite($handle, "   }\n\n");

            fwrite($handle, "   location ~* \.php$ {\n");
            fwrite($handle, "      try_files               \$uri = 404;\n");
            fwrite($handle, "      fastcgi_pass            backend_fpm;\n");
            fwrite($handle, "      include                 fastcgi_params;\n");
            fwrite($handle, "      expires                 360d;\n");
            fwrite($handle, "      add_header              Cache-Control public;\n");
            fwrite($handle, "   }\n\n");

            fwrite($handle, "   location ~* \.(jpg|jpeg|gif|png|bmp|swf|css|js|cur|gz|pdf|img)$ {\n");
            fwrite($handle, "      access_log              off;\n");
            fwrite($handle, "      expires                 360d;\n");
            fwrite($handle, "      add_header              Cache-Control public;\n");
            fwrite($handle, "   }\n\n");

            fwrite($handle, "}\n\n");
    	}

    	fclose($handle);
    }
?>
