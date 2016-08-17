		<TABLE class="table table-striped table-condensed" id="toptable">
			<TR class="active">
				<TD><B>#</B></TD>
				<TD><B>Name</B></TD>
				<TD><B>IP</B></TD>
				<TD><B>Project</B></TD>

				<TD><B><FONT size="1">HTTP</FONT></B></TD>
				<TD><B><FONT size="1">HTTPS</FONT></B></TD>
				<TD><B>Cert</B></TD>
				<TD><B><FONT size="1">Test</FONT></B></TD>
				<TD><B>Comment</B></TD>
				<TD><B><FONT size='1'>Ed.</FONT></B></TD>
				<TD><B><FONT size='1'>Re.</FONT></B></TD>
			</TR>
		</TABLE>
		<TABLE class="table table-striped table-condensed" id="newtable">
			<TR class="active">
				<TD><DIV id="id"><FONT size="1">New</FONT></DIV></TD>
				<TD><INPUT type="text" id="name" value=""></TD>
				<TD><INPUT type="text" id="ip" value=""></TD>
				<TD><INPUT type="text" id="project" value="cdn" readonly class="project"></TD>
				<TD><INPUT type="checkbox" id="http"></TD>
				<TD><INPUT type="checkbox" id="https" onchange="fade();"></TD>
				<TD><INPUT type="text" id="cert" value="" readonly="true"></TD>
				<TD><INPUT type="checkbox" id="test"></TD>
				<TD><TEXTAREA id="comment" rows="1"></TEXTAREA></TD>
				<TD>E</TD>
				<TD>X</TD>
			</TR>
			<TR class="active">
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
				<TD></TD>
				<TD></TD>
			</TR>
		</TABLE>
		<TABLE class="table table-striped table-condensed" class="maintable" id="maintable">
	<?php 	$i = 1;
			while ($project = mysql_fetch_array($projects)) {
				echo "<TR><TD colspan='15'><b>".$project[0]."</b></TD></TR>";
				$sql 	  = "SELECT * FROM `confogen`.`domains` WHERE `project`='".$project[0]."' ORDER BY `ip`;";
    			$result   = mysql_query($sql, $link)  or die(mysql_error());
				while ($row = mysql_fetch_assoc($result)) { ?>
					<TR>
						<TD><A class='delete' href="http://www.<?php echo $row['name']; ?>" target="_blank"><?php echo $i++ ?></A></TD>
						<TD><INPUT id="name_<?php echo $row['id']; ?>" type='text' ondblclick="textSelector( this ); return false;" readonly value="<?php echo $row['name']; ?>"></TD>
						<TD><INPUT id="ip_<?php echo $row['id']; ?>" type='text' ondblclick="textSelector( this ); return false;" readonly value="<?php echo $row['ip']; ?>"></TD>
						<TD><INPUT id="project_<?php echo $row['id']; ?>" type='text' readonly value="cdn" class="project"></TD>
						<TD><INPUT id="http_<?php echo $row['id']; ?>" type='checkbox' disabled <?php if ($row['http'] == 1) echo "checked";?> ></TD>
						<TD><INPUT id="https_<?php echo $row['id']; ?>" type='checkbox' disabled <?php if ($row['https'] == 1) echo "checked";?> ></TD>
						<TD><INPUT id="cert_<?php echo $row['id']; ?>" type='text' readonly value="<?php echo $row['cert']; ?>"></TD>
						<TD><INPUT id="test_<?php echo $row['id']; ?>" type='checkbox' disabled <?php if ($row['test'] == 1) echo "checked"; ?> ></TD>
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
		<?php	}
			} ?>
		</TABLE>