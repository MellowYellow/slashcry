<div class="content" align="center">
		<form method="POST" action="index.php?step=2">
		<input type="hidden"  name="step" value="2">
		
		<table border="0" width="500px" style="border: 2px solid #808080;">
			<tr>
				<td colspan="2" class="form-head">Database Info</td>
			</tr>
			<tr>
				<td width="150" align="left" valign="middle" class="form-text">Database Type:</td>
				<td align="left" valign="left" class="form-text"><input type="text" name="dbType" size="20" tabindex="1" class="inputbox"> // Enter your database type.</td>
			</tr>
			<tr>
				<td width="150" align="left" valign="middle" class="form-text">Database Address:</td>
				<td align="left" valign="left" height="28" class="form-text"><input type="text" name="dbip" size="20" tabindex="2" class="inputbox"> // IP address of your Database</td>
			</tr>
			<tr>
				<td width="150" align="left" valign="middle" class="form-text">Database Port:</td>
				<td align="left" valign="left" height="28" class="form-text"><input type="text" name="dbPort" size="20" tabindex="2" class="inputbox"> // Database port</td>
			</tr>
			<tr>
				<td width="150" align="left" valign="middle" class="form-text">Database Username:</td>
				<td align="left" valign="left" height="28" class="form-text"><input type="text" name="dbUsername" size="20" tabindex="2" class="inputbox"> // Database Username</td>
			</tr>
			<tr>
				<td width="150" align="left" valign="middle" class="form-text">Database Password:</td>
				<td align="left" valign="left" height="28" class="form-text"><input type="password" name="dbPassword" size="20" tabindex="2" class="inputbox"> // Database Password</td>
			</tr>
			<tr>
				<td colspan="2" class="form-head">Database Names</td>
			</tr>
			<tr>
				<td width="150" align="left" valign="middle" class="form-text">Realm Database:</td>
				<td align="left" valign="left" height="28" class="form-text"><input type="text" name="dbname" size="20" tabindex="2" class="inputbox"> // Website Database Name</td>
			</tr>
			<tr>
				<td width="150" align="left" valign="middle" class="form-text">Character Database:</td>
				<td align="left" valign="left" height="28" class="form-text"><input type="text" name="chardb" size="20" tabindex="2" class="inputbox"> // Character Database Name</td>
			</tr>
			<tr>
				<td width="150" align="left" valign="middle" class="form-text">World Database:</td>
				<td align="left" valign="left" height="28" class="form-text"><input type="text" name="worlddb" size="20" tabindex="2" class="inputbox"> // World Database Name</td>
			</tr>
			<tr>
				<td align="center" colspan="2" ><button name="reset" class="button" type="reset">Cancel</button>&nbsp;&nbsp;
				<button name="step2" class="button" type="submit">Proceed to Step 2</button>
				</td>
			</tr>
		</table>
		
		</form>
	</div>