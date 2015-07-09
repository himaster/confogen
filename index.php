<?php

	#Variables
	$dbuser = 'confogen';
	$dbpassword = 'Bie0gaen';
	$dbname = 'confogen';

	#DB
	$link = mysql_connect('localhost', $dbuser, $dbpassword);
	if (!$link) {
    	die('Ошибка соединения: ' . mysql_error());
	}

	#HTML
	?>
	<HTML>
		<HEAD>
			<TITLE>ConfoGen</TITLE>
		</HEAD>
		<BODY>
			<TABLE align='center'>
				<TR>
					<TD>No</TD>
					<TD>Name</TD>