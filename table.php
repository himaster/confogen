<?php
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

	#element delete
	if (isset($_GET['remove'])) {
		$id = $_GET['id'];
		$sql = "DELETE FROM `domains` WHERE id=$id;";
		$result = mysql_query($sql, $link)  or die(mysql_error());
	}

	#Form submit
	else if (!empty($_GET['name']) && !empty($_GET['ip'])) {
		$name = $_GET['name'];
		$ip = $_GET['ip'];
		$http = $_GET['http'];
		$https = $_GET['https'];
		$test = $_GET['test'];
		$m = $_GET['m'];
		$mtest = $_GET['mtest'];

		$sql = "INSERT INTO `domains` (name, ip, http, https, test, m, mtest) VALUES (\"$name\", \"$ip\", $http, $https, $test, $m, $mtest);";
		$result = mysql_query($sql, $link)  or die(mysql_error());
	}

	$sql = "SELECT * FROM `domains`;";
    $result = mysql_query($sql, $link)  or die(mysql_error());

    echo "<TABLE align='center'>";
	echo "<TR><TD width='20'>#</TD>";
	echo "<TD width='140'>Name</TD>";
	echo "<TD width='165'>IP</TD>";
	echo "<TD width='40'>HTTP</TD>";
	echo "<TD width='50'>HTTPS</TD>";
	echo "<TD width='45'>TEST</TD>";
	echo "<TD width='50'>Mobile</TD>";
	echo "<TD width='60'>M.test</TD>";
	echo "<TD width='60'>Remove</TD></TR>";

	while ($row = mysql_fetch_assoc($result)) {
		echo "<TR><TD width='20'>".$row['id']."</TD>";
		echo "<TD width='140'>".$row['name']."</TD>";
		echo "<TD width='165'>".$row['ip']."</TD>";
		echo "<TD width='40'><input type='checkbox' ";
		if ($row['http'] == 1) echo "checked";
		echo "></TD>";
		echo "<TD width='50'><input type='checkbox' ";
		if ($row['https'] == 1) echo "checked";
		echo "></TD>";
		echo "<TD width='45'><input type='checkbox' ";
		if ($row['test'] == 1) echo "checked";
		echo "></TD>";
		echo "<TD width='50'><input type='checkbox' ";
		if ($row['m'] == 1) echo "checked";
		echo "></TD>";
		echo "<TD width='60'><input type='checkbox' ";
		if ($row['mtest'] == 1) echo "checked";
		echo "></TD>";
		echo "<TD width='60'><A href='javascript:rem_el(".$row['id'].")'>x</A></TD></TR>";
	}