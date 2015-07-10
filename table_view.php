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
		<TR><TD width='20'><?php $row['id'] ?></TD>
		<TD width='140'><?php $row['name'] ?></TD>
		<TD width='165'><?php $row['ip'] ?></TD>
		<TD width='40'><input type='checkbox' <?php if ($row['http'] == 1) echo "checked"; ?> ></TD>
		<TD width='50'><input type='checkbox' <?php if ($row['https'] == 1) echo "checked"; ?> ></TD>
		<TD width='45'><input type='checkbox' <?php if ($row['test'] == 1) echo "checked"; ?> ></TD>
		<TD width='50'><input type='checkbox' <?php if ($row['m'] == 1) echo "checked"; ?> ></TD>
		<TD width='60'><input type='checkbox' <?php if ($row['mtest'] == 1) echo "checked"; ?> ></TD>
		<TD width='60'><A href='javascript:rem_el(<?php $row['id'] ?>)'>x</A></TD></TR>
<?php } ?>