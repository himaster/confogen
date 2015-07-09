<?php
	$sql = "SELECT * FROM `domains`";
    $result = mysql_query($sql, $link)  or die(mysql_error());

    

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