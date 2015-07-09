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
	
	$db_selected = mysql_select_db($dbname, $link);
	if (!$db_selected) {
    	die ('Не удалось выбрать базу foo: ' . mysql_error());
	}

	$sql = "SELECT * FROM `domains`";
    $result = mysql_query($sql, $link)  or die(mysql_error());
?>

<!-- HTML -->

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
<?php
	while ($row = mysql_fetch_assoc($result)) {
		echo "<TR><TD>".$row['id']."</TD>";
		echo "<TD>".$row['name']."</TD>";
		echo "<TD>".$row['ip']."</TD>";
		echo "<TD><input type='checkbox' ";
		if ($row['http'] == 1) echo "checked";
		echo "></TD>";
		echo "<TD><input type='checkbox' ";
		if ($row['https'] == 1) echo "checked";
		echo "></TD>";
		echo "<TD><input type='checkbox' ";
		if ($row['test'] == 1) echo "checked";
		echo "></TD>";
		echo "<TD><input type='checkbox' ";
		if ($row['m'] == 1) echo "checked";
		echo "></TD>";
		echo "<TD><input type='checkbox' ";
		if ($row['mtest'] == 1) echo "checked";
		echo "></TD>";
		echo "</TR>";
	}
?>
		</TABLE>
	</BODY>
</HTML>
