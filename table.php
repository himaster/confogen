<?php
	echo $_POST['text'];
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

    echo "<TABLE align='center'>";
	echo "<TR><TD>#</TD>";
	echo "<TD>Name</TD>";
	echo "<TD>IP</TD>";
	echo "<TD>HTTP</TD>";
	echo "<TD>HTTPS</TD>";
	echo "<TD>TEST</TD>";
	echo "<TD>Mobile</TD>";
	echo "<TD>M.test</TD></TR>";

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