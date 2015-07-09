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
	$sql = "SELECT * FROM 'confogen'.'domens'";
    $result = mysql_query($sql)  or die(mysql_error());

	#HTML
	?>
	<HTML>
		<HEAD>
			<TITLE>ConfoGen</TITLE>
		</HEAD>
		<BODY>
			<TABLE align='center'>
				<TR>
					<TD>#</TD>
					<TD>Name</TD>
					<TD>IP</TD>
					<TD>HTTP</TD>
					<TD>HTTPS</TD>
					<TD>TEST</TD>
					<TD>Mobile</TD>
					<TD>M.test</TD>
				</TR>
