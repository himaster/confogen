<?php
	$sql = "SELECT * FROM `domains`;";
    $result = mysql_query($sql, $link)  or die(mysql_error());
?>

<TABLE align='center'>
<TR><TD width='20'>#</TD>
<TD width='140'>Name</TD>
<TD width='165'>IP</TD>
<TD width='40'>HTTP</TD>
<TD width='50'>HTTPS</TD>
<TD width='45'>TEST</TD>
<TD width='50'>Mobile</TD>
<TD width='60'>M.test</TD>
<TD width='60'><FONT size='2'>Remove</FONT></TD></TR>

<?php while ($row = mysql_fetch_assoc($result)) { ?>
		<TR><TD width='20'><?php echo $row['id'] ?></TD>
		<TD width='140'><?php echo $row['name'] ?></TD>
		<TD width='165'><?php echo $row['ip'] ?></TD>
		<TD width='40'><input type='checkbox' <?php if ($row['http'] == 1) echo "checked"; ?> ></TD>
		<TD width='50'><input type='checkbox' <?php if ($row['https'] == 1) echo "checked"; ?> ></TD>
		<TD width='45'><input type='checkbox' <?php if ($row['test'] == 1) echo "checked"; ?> ></TD>
		<TD width='50'><input type='checkbox' <?php if ($row['m'] == 1) echo "checked"; ?> ></TD>
		<TD width='60'><input type='checkbox' <?php if ($row['mtest'] == 1) echo "checked"; ?> ></TD>
		<TD width='60'><A href='javascript:rem_el(<?php echo $row['id'] ?>)'>x</A></TD></TR>
<?php } ?>