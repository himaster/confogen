<?php
	if (($_SERVER['HTTP_HOST'] == "confogen1.pkwteile.de") or ($_SERVER['HTTP_HOST'] == "confogen2.pkwteile.de")) $env="master";
	elseif ($_SERVER['HTTP_HOST'] == "confogen.cdn.pkwteile.de") $env="cdn";
	elseif ($_SERVER['HTTP_HOST'] == "confogen.loc") $env="dev";
	else header("Location: https://confogen1.pkwteile.de/");

	$dbuser = 'confogen';
	$dbpassword = 'Bie0gaen';
	$dbname = 'confogen';

	if ($env == "master") $dbhost = 'balancer1';
	elseif ($env == "cdn") $dbhost = 'cdn';
	else $dbhost = '88.198.182.148';

	$dbhost = 'netbox.co';

	#DB
	$link = mysql_connect($dbhost, $dbuser, $dbpassword);
	if (!$link) {
    	die('Ошибка соединения: ' . mysql_error());
	}

	$db_selected = mysql_select_db($dbname, $link);
	if (!$db_selected) {
    	die ('Не удалось выбрать базу foo: ' . mysql_error());
	}
