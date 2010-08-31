<?php
@mysql_connect($_POST['dbip'].":".$_POST['dbPort'], $_POST['dbUsername'], $_POST['dbPassword']) 
	or die ('<center>Error!<br /><br />Couldn\'t connect to the MySql server, most likely the given information is wrong. Please <a href="javascript: history.go(-1)">go back</a> and correct it.<br /><br />MySql error log:<br /></center>'.mysql_error());
?>
<form method="POST" action="index.php?step=4">
<input type="hidden"  name="stage" value="4">
<input type="hidden"  name="dbType" value="<?php echo $_POST['dbType']; ?>">
<input type="hidden"  name="dbip" value="<?php echo $_POST['dbip']; ?>">
<input type="hidden"  name="dbPort" value="<?php echo $_POST['dbPort']; ?>">
<input type="hidden"  name="dbUsername" value="<?php echo $_POST['dbUsername']; ?>">
<input type="hidden"  name="dbPassword" value="<?php echo $_POST['dbPassword']; ?>">
<input type="hidden"  name="realmdb" value="<?php echo $_POST['realmdb']; ?>">

<table align="center" border="0" width="260px" style="border: 2px solid #808080;">
			<tr>
				<td colspan="2" class="form-head">Create Admin Account</td>
			</tr>
			<tr>
			<td colspan="2" class="form-text">Create a new accout or use a pre existing account on your server.</td>
			</tr>
			<tr>
				<td width="70" align="right" valign="middle" class="form-text">Username:</td>
				<td align="center" valign="middle"><input type="text" name="formUser" size="20" tabindex="1" class="inputbox"></td>
			</tr>
			<tr>
				<td width="70" align="right" valign="middle" class="form-text">Password:</td>
				<td align="center" valign="middle" height="28"><input type="password" name="formPass" size="20" tabindex="2" class="inputbox"></td>
			</tr>
			<tr>
				<td width="70" align="right" valign="middle" class="form-text"><center>Re-type </center>Password:</td>
				<td align="center" valign="middle" height="28"><input type="password" name="formPass2" size="20" tabindex="2" class="inputbox"></td>
			</tr>
			<tr>
				<td align="center" colspan="2"><button name="create" class="button" type="submit">Create</button>&nbsp;&nbsp;
				<button name="reset" class="button" type="reset">Cancel</button></td>
			</tr>
		</table>
</form>