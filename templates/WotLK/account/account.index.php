<div id="Contenthdr">Account Home</div>
<div id="Content"> 
	<table width="95%" border="0" align="center" class="info-table">
		<tr>
			<td class="info-table-head" colspan="2" align="left"><b>Account Summary <font color="#C77B00">
				<small><?php echo $myprofile['username']; ?></small></font></b>
			</td>
		</tr>
		<tr>
			<td width="30%" align="left" valign="middle">Account Status:</td>
			<td align="left"><?php echo $stat; ?></td>
			<!--
			<td width="30%" rowspan="6" valign="center" align="center" style="border-left: 1px dotted #666666; padding: 5px 5px 5px 5px; color: #1668cb;">
				<a href="index.php?p=account&sub=changepass">Change Password</a><br />
				<a href="index.php?p=account&sub=changeemail">Change Email Address</a><br />
			</td>
			-->
		</tr>
		<tr>
			<td width="30%" align="left" valign="middle">Site Account Level:</td>
			<td  align="left"><?php echo $myprofile['title']; ?></td>
		</tr>
		<tr>
			<td width="30%" align="left" valign="middle">GM Level:</td>
			<?php if($cfg->get('emulator') == 'mangos') { ?>
			<td  align="left"><?php echo $myprofile['gmlevel']; ?></td>
			<?php }elseif($cfg->get('emulator') == 'trinity') { ?>
			<td  align="left"><?php echo $gmlevel; ?></td>
			<?php } ?>
		</tr>
		<tr>
			<td width="30%" align="left" valign="middle">Registration Date:</td>
			<td align="left"><?php echo $myprofile['joindate']; ?></td>
		</tr>
		<tr>
			<td width="30%" align="left" valign="middle">Last Login (Game):</td>
			<td  align="left"><?php echo $myprofile['last_login']; ?></td>
		</tr>
		<tr>
			<td width="30%" align="left" valign="middle">Web Points Balance:</td>
			<td align="left"><?php echo $myprofile['web_points']; ?></td>
		</tr>
		<tr>
			<td width="30%" align="left" valign="middle">Times Voted:</td>
			<td align="left"><?php echo $myprofile['total_votes']; ?></td>
		</tr>
	</table>
	<br /><br />
	<table width="95%" border="0" align="center" class="info-table">
		<tr>
			<td class="info-table-head" colspan="2" align="left"><b>Account Options</td>
		</tr>
		<tr>
			<td align="center"><font color="red">DISABLED</font></td>
		</tr>
	</table>
</div>