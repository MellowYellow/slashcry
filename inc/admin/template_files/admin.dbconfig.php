<div class="content-head">
		<div class="desc-title">Database Configuration</div>
		<div class="description">
		<i>Description:</i> This area allows you to alter the configuration of KeysCMS suite.
		</div>
</div>
<div class="content">
	<?php if(isset($_POST['task'])) {
	saveConfig($_POST['db_type'],$_POST['db_host'],$_POST['db_port'],$_POST['db_username'],$_POST['db_password'],$_POST['db_name']);
	} ?>
	<form method="POST" action="index.php?p=admin&sub=dbconfig" onSubmit="return configvalidation(this);" name="adminform">
	<input type="hidden" name="task" value="saveconfig">
		
	<table border="0" width="95%" style="border: 2px solid #808080;">
		<tr>
			<td colspan="3" class="form-head">Database Configuration</td>
		</tr>
		<tr>
		<td width="20%" align="right" valign="middle" class="form-text">Database Type:</td>
			<td width="15%" align="left" valign="middle">
			<input type="text" name="db_type" size="20" class="inputbox" value="<?php echo $cfg->getDbInfo('db_type'); ?>" /></td>
			<td align="left" valign="top" class="form-desc">Database type (ie: mysql).</td>
		</tr>
		<td width="20%" align="right" valign="middle" class="form-text">Database Host:</td>
			<td width="15%" align="left" valign="middle">
			<input type="text" name="db_host" size="20" class="inputbox" value="<?php echo $cfg->getDbInfo('db_host'); ?>" /></td>
			<td align="left" valign="top" class="form-desc">Enter IP address here.</td>
		</tr>
		<td width="20%" align="right" valign="middle" class="form-text">Database Port:</td>
			<td width="15%" align="left" valign="middle">
			<input type="text" name="db_port" size="20" class="inputbox" value="<?php echo $cfg->getDbInfo('db_port'); ?>" /></td>
			<td align="left" valign="top" class="form-desc">Database port. (Default 3306)</td>
		</tr>
		<td width="20%" align="right" valign="middle" class="form-text">Database Username:</td>
			<td width="15%" align="left" valign="middle">
			<input type="text" name="db_username" size="20" class="inputbox" value="<?php echo $cfg->getDbInfo('db_username'); ?>" /></td>
			<td align="left" valign="top" class="form-desc">Database Username.</td>
		</tr>
		<td width="20%" align="right" valign="middle" class="form-text">Database Password:</td>
			<td width="15%" align="left" valign="middle">
			<input type="text" name="db_password" size="20" class="inputbox" value="<?php echo $cfg->getDbInfo('db_password'); ?>" /></td>
			<td align="left" valign="top" class="form-desc">Database Password.</td>
		</tr>
		<td width="20%" align="right" valign="middle" class="form-text">Database Name:</td>
			<td width="15%" align="left" valign="middle">
			<input type="text" name="db_name" size="20" class="inputbox" value="<?php echo $cfg->getDbInfo('db_name'); ?>" /></td>
			<td align="left" valign="top" class="form-desc">Realmd Database Name.</td>
		</tr>
		<tr>
			<td colspan="3" align="right" class="buttons">
				Confirm Process:&nbsp;<input type="checkbox" name="confirm" />&nbsp;&nbsp;
				<button name="process" class="button" type="submit"><b>Update</b></button>&nbsp;&nbsp;
				<button name="reset" class="button" type="reset">Cancel</button>
			</td>
		</tr>
	</table>
</div>