		<TABLE class="maintable" id="toptable">
			<TR>
				<TD><B>#</B></TD>
				<TD><b>Name</b></TD>
				<TD><b>IP</b></TD>
				<TD><b><FONT size="1">WWW</FONT></b></TD>
				<TD><b><FONT size="1">HTTP</FONT></b></TD>
				<TD><b><FONT size="1">HTTPS</FONT></b></TD>
				<TD><b>Cert</b></TD>
				<TD><b><FONT size="1">Test</FONT></b></TD>
				<TD><b><FONT size="1">Blog</FONT></b></TD>
				<TD><b>Blog Name</b></TD>
				<TD><b><FONT size="1">Mobile</FONT></b></TD>
				<TD><b><FONT size="1">M.test</FONT></b></TD>
				<TD><b>Comment</b></TD>
				<TD><b><FONT size='1'>Ed.</FONT></b></TD>
				<TD><b><FONT size='1'>Re.</FONT></b></TD>
			</TR>
		</TABLE>
		<TABLE class="maintable" id="newtable">
			<TR>
				<TD><DIV id="id">New</DIV></TD>
				<TD><INPUT type="text" id="name" value=""></TD>
				<TD><INPUT type="text" id="ip" Value=""></TD>
				<TD><INPUT type="checkbox" id="www"></TD>
				<TD><INPUT type="checkbox" id="http"></TD>
				<TD><INPUT type="checkbox" id="https" onchange="fade();"></TD>
				<TD><INPUT type="text" id="cert" value="" readonly="true"></TD>
				<TD><INPUT type="checkbox" id="test"></TD>
				<TD><INPUT type="checkbox" id="blog" onchange="fadeblog();"></TD>
				<TD><INPUT type="text" id="blogname" value="" readonly="true"></TD>
				<TD><INPUT type="checkbox" id="m"></TD>
				<TD><INPUT type="checkbox" id="mtest"></TD>
				<TD><TEXTAREA id="comment" rows="1"></TEXTAREA></TD>
				<TD></TD>
				<TD></TD>
			</TR>
			<TR>
				<TD></TD>
				<TD>
					<INPUT type="button" onclick="submit(); generate(<?php echo $max_id; ?>); " value="Submit">
				</TD>
				<TD>
					<INPUT type="button" onclick="generate(); " value="generate" >
				</TD>
				<TD></TD>
				<TD></TD>
				<TD></TD>
				<TD></TD>
				<TD></TD>
				<TD></TD>
				<TD></TD>
				<TD></TD>
				<TD></TD>
				<TD></TD>
				<TD></TD>
				<TD></TD>
			</TR>
		</TABLE>
		<TABLE class="maintable" id="maintable">
	<?php 	$i = 1;
			while ($row = mysql_fetch_assoc($result)) { ?>
				<TR>
					<TD><A class='delete' href="http://www.<?php echo $row['name']; ?>" target="_blank"><?php echo $i++ ?></A></TD>
					<TD><INPUT id="name_<?php echo $row['id']; ?>" type='text' ondblclick="textSelector( this ); return false;" readonly value="<?php echo $row['name']; ?>"></TD>
					<TD><INPUT id="ip_<?php echo $row['id']; ?>" type='text' ondblclick="textSelector( this ); return false;" readonly value="<?php echo $row['ip']; ?>"></TD>
					<TD><INPUT id="www_<?php echo $row['id']; ?>" type='checkbox' disabled <?php if ($row['www'] == 1) echo "checked";?> ></TD>
					<TD><INPUT id="http_<?php echo $row['id']; ?>" type='checkbox' disabled <?php if ($row['http'] == 1) echo "checked";?> ></TD>
					<TD><INPUT id="https_<?php echo $row['id']; ?>" type='checkbox' disabled <?php if ($row['https'] == 1) echo "checked";?> ></TD>
					<TD><INPUT id="cert_<?php echo $row['id']; ?>" type='text' readonly value="<?php echo $row['cert']; ?>"></TD>
					<TD><INPUT id="test_<?php echo $row['id']; ?>" type='checkbox' disabled <?php if ($row['test'] == 1) echo "checked"; ?> ></TD>
					<TD><INPUT id="blog_<?php echo $row['id']; ?>" type='checkbox' disabled <?php if ($row['blog'] == 1) echo "checked";?> ></TD>
					<TD><INPUT id="blogname_<?php echo $row['id']; ?>" type='text' readonly value="<?php echo $row['blogname']; ?>"></TD>
					<TD><INPUT id="m_<?php echo $row['id']; ?>" type='checkbox' disabled <?php if ($row['m'] == 1) echo "checked"; ?> ></TD>
					<TD><INPUT id="mtest_<?php echo $row['id']; ?>" type='checkbox' disabled <?php if ($row['mtest'] == 1) echo "checked"; ?> ></TD>
					<TD><TEXTAREA id="comment_<?php echo $row['id']; ?>" 
											  readonly
											  rows="1"
											  maxlength="2000"><?php echo $row['comment']; ?></TEXTAREA></TD>
					<TD>
						<DIV id="edit_<?php echo $row['id']; ?>">
							<A id="edit_<?php echo $row['id']; ?>" class='delete' href="javascript:edit(<?php echo $row['id']; ?>); ">E</A>&nbsp;
						</DIV>
						<DIV id="save_<?php echo $row['id']; ?>" style="display:none">
							<A class='delete' href="javascript:save(<?php echo $row['id']; ?>); setTimeout(generate(<?php echo $row['id']; ?>), 1000) ">S</A>&nbsp;
						</DIV>
					</TD>
					<TD><A class='delete' href='javascript:rem_el(<?php echo $row['id'] ?>)'>X</A></TD>
				</TR>
	<?php	} ?>
		</TABLE>
