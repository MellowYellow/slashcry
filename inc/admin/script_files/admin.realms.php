<?php
//========================//
if(INCLUDED!==true) {
	echo "Not Included!"; exit;
}
//=======================//

$getrealms = $DB->select("SELECT * FROM `realmlist`");

function showRealm($rlmid) {
	global $DB, $realm_type_def, $realm_timezone_def;
	$rlm = $DB->selectRow("SELECT * FROM `realmlist` WHERE `id`=?d",$rlmid);
	$db_info = explode( ';', $rlm['dbinfo'] ) ;
	$ra_info = explode( ';', $rlm['ra_info'] ) ;
	
	//DBinfo column:  username;password;port;host;WorldDBname;CharDBname
	$rlm_info = array( 'db_type' => 'mysql', 'db_host' => $db_info['3'],
		'db_port' => $db_info['2'], //port
		'db_username' => $db_info['0'], //world user
		'db_password' => $db_info['1'], //world password
		'db_name' => $db_info['4'], //world db name
		'db_char' => $db_info['5'], //character db name
		'ra_type' => $ra_info['0'],
		'ra_port' => $ra_info['1'],
		'ra_user' => $ra_info['2'],
		'ra_pass' => $ra_info['3'],
		) ;
	echo "
		<div class=\"content-head\">
			<div class=\"desc-title\">Manage Realm</div>
			<div class=\"description\">
				<i>Description:</i> Here you can modify your selected realm.
			</div>
		</div>
		<div class=\"content\" align=\"center\">
			<form method=\"POST\" action=\"index.php?p=admin&sub=realms&id=".$rlmid."\">
			<input type=\"hidden\" name=\"edit_realm\" value=".$rlmid.">
			<table width=\"95%\" border=\"0\" style=\"border: 2px solid #808080;\">
				<tr>
					<td colspan=\"3\" align=\"center\" class=\"header\"><b><font color='#0e84d9'>Managing Realm: </font><font color='#C77B00'>".$rlm['name']."</font></b></td>
				</tr>
			</table>
			<br />";
			if(isset($_POST['edit_realm'])) {
				$DB->query("UPDATE `realmlist` SET 
					`name`= '".$_POST['realm_name']."',
					`address`= '".$_POST['realm_address']."',
					`port`= '".$_POST['realm_port']."',
					`icon`= '".$_POST['icon']."',
					`timezone`= '".$_POST['timezone']."',
					`dbinfo`= '".$_POST['db_user'].";".$_POST['db_pass'].";".$_POST['db_host'].";".$_POST['db_port'].";".$_POST['db_name'].";".$_POST['db_char']."',
					`ra_info`= '".$_POST['ra_type'].";".$_POST['ra_port'].";".$_POST['ra_user'].";".$_POST['ra_pass']."',
					`site_enabled`='".$_POST['site_enabled']."'
				WHERE `id`=".$rlmid."");
				output_message('notice', 'Realm Successfully Updated!');
			}
			echo"
			<table width=\"95%\" border=\"0\" style=\"border: 2px solid #808080;\">
				<tr>
					<td colspan=\"3\" align=\"center\" class=\"form-section-head\"><u>Realm Details:</u></td>
				</tr>
				<tr>
					<td width=\"20%\" align=\"right\" valign=\"middle\" class=\"form-text\">Realm Name:</td>
					<td width=\"15%\" align=\"left\" valign=\"middle\">
					<input type=\"text\" name=\"realm_name\" size=\"30\" class=\"inputbox\" value=\"".$rlm['name']."\" /></td>
					<td align=\"left\" valign=\"top\" class=\"form-desc\">Name of your Realm.</td>
				</tr>
				<tr>
					<td width=\"20%\" align=\"right\" valign=\"middle\" class=\"form-text\">Realm Address:</td>
					<td width=\"15%\" align=\"left\" valign=\"middle\">
					<input type=\"text\" name=\"realm_address\" size=\"30\" class=\"inputbox\" value=\"".$rlm['address']."\" /></td>
					<td align=\"left\" valign=\"top\" class=\"form-desc\">IP address of you realm.</td>
				</tr>
				<tr>
					<td width=\"20%\" align=\"right\" valign=\"middle\" class=\"form-text\">Realm Port:</td>
					<td width=\"15%\" align=\"left\" valign=\"middle\">
					<input type=\"text\" name=\"realm_port\" size=\"5\" class=\"inputbox\" value=\"".$rlm['port']."\" /></td>
					<td align=\"left\" valign=\"top\" class=\"form-desc\">IP address of you realm.</td>
				</tr>
				<tr>
					<td width=\"20%\" align=\"right\" valign=\"middle\" class=\"form-text\">Realm Type:</td>
					<td width=\"15%\" align=\"left\" valign=\"middle\">
					<select name=\"icon\" class=\"inputbox\">";
					foreach($realm_type_def as $tmpr_id => $tmpr_name) {
						if($tmpr_id == $rlm['icon']) {
							$seltype = "selected=\"selected\"";
						}else{
							$seltype = "";
						}
						echo "<option value=\"".$tmpr_id."\" ".$seltype.">".$tmpr_name."</option>"; 
					} 
					echo "</select></td>
					<td align=\"left\" valign=\"top\" class=\"form-desc\">Realm Type.</td>
				</tr>
				<tr>
					<td width=\"20%\" align=\"right\" valign=\"middle\" class=\"form-text\">Realm Timezone:</td>
					<td width=\"15%\" align=\"left\" valign=\"middle\">
					<select name=\"timezone\" class=\"inputbox\">";
					foreach($realm_timezone_def as $tmptz_id => $tmptz_name) {
						if($tmptz_id == $rlm['timezone']) {
							$seldtype = "selected=\"selected\"";
						}else{
							$seldtype = "";
						}
						echo "<option value=\"".$tmptz_id."\" ".$seldtype.">".$tmptz_name."</option>"; 
					} 
					echo "</select></td>
					<td align=\"left\" valign=\"top\" class=\"form-desc\">Realm Timezone.</td>
				</tr>
				<tr>
					<td width=\"20%\" align=\"right\" valign=\"middle\" class=\"form-text\">Realm Site Status:</td>
					<td width=\"15%\" align=\"left\" valign=\"middle\">
					<select name=\"site_enabled\" class=\"inputbox\">"; 
						if($rlm['site_enabled'] == 0) { echo "<option value=\"0\">Disabled</option><option value=\"1\">Enabled</option>"; 
						}else{ echo "<option value=\"1\">Enabled</option><option value=\"0\">Disabled</option>"; }
					echo"</select></td>
					<td align=\"left\" valign=\"top\" class=\"form-desc\">Must be Enabled to have realm show in realmlist.</td>
				</tr>
				<tr>
					<td colspan=\"3\" align=\"center\" class=\"form-section-head\"><u>Realm Database Details:</u></td>
				</tr>
				<tr>
					<td width=\"20%\" align=\"right\" valign=\"middle\" class=\"form-text\">Character / World Host:</td>
					<td width=\"15%\" align=\"left\" valign=\"middle\">
					<input type=\"text\" name=\"db_host\" size=\"30\" class=\"inputbox\" value=\"".$rlm_info['db_host']."\" /></td>
					<td align=\"left\" valign=\"top\" class=\"form-desc\">IP address of your character and world databases.</td>
				</tr>
				<tr>
					<td width=\"20%\" align=\"right\" valign=\"middle\" class=\"form-text\">Character / World Port:</td>
					<td width=\"15%\" align=\"left\" valign=\"middle\">
					<input type=\"text\" name=\"db_port\" size=\"30\" class=\"inputbox\" value=\"".$rlm_info['db_port']."\" /></td>
					<td align=\"left\" valign=\"top\" class=\"form-desc\">Port of your character and world databases.</td>
				</tr>
				<tr>
					<td width=\"20%\" align=\"right\" valign=\"middle\" class=\"form-text\">Character / World User:</td>
					<td width=\"15%\" align=\"left\" valign=\"middle\">
					<input type=\"text\" name=\"db_user\" size=\"30\" class=\"inputbox\" value=\"".$rlm_info['db_username']."\" /></td>
					<td align=\"left\" valign=\"top\" class=\"form-desc\">Database username for character and world databases.</td>
				</tr>
				<tr>
					<td width=\"20%\" align=\"right\" valign=\"middle\" class=\"form-text\">Character / World Pass:</td>
					<td width=\"15%\" align=\"left\" valign=\"middle\">
					<input type=\"text\" name=\"db_pass\" size=\"30\" class=\"inputbox\" value=\"".$rlm_info['db_password']."\" /></td>
					<td align=\"left\" valign=\"top\" class=\"form-desc\">Database password for character and world databases.</td>
				</tr>
				<tr>
					<td width=\"20%\" align=\"right\" valign=\"middle\" class=\"form-text\">World DB Name:</td>
					<td width=\"15%\" align=\"left\" valign=\"middle\">
					<input type=\"text\" name=\"db_name\" size=\"30\" class=\"inputbox\" value=\"".$rlm_info['db_name']."\" /></td>
					<td align=\"left\" valign=\"top\" class=\"form-desc\">Name of your World Database for this realm</td>
				</tr>
				<tr>
					<td width=\"20%\" align=\"right\" valign=\"middle\" class=\"form-text\">Character DB Name:</td>
					<td width=\"15%\" align=\"left\" valign=\"middle\">
					<input type=\"text\" name=\"db_char\" size=\"30\" class=\"inputbox\" value=\"".$rlm_info['db_char']."\" /></td>
					<td align=\"left\" valign=\"top\" class=\"form-desc\">Name of your Character Database for this realm</td>
				</tr>
				<tr>
					<td colspan=\"3\" align=\"center\" class=\"form-section-head\"><u>Remote Access Config:</u></td>
				</tr>
				<tr>
					<td width=\"20%\" align=\"right\" valign=\"middle\" class=\"form-text\">Remote Access Type:</td>
					<td width=\"15%\" align=\"left\" valign=\"middle\">
					<select name=\"ra_type\" class=\"inputbox\">"; 
						if($rlm_info['ra_type'] == 0) { echo "<option value=\"0\">Telnet</option><option value=\"1\">SOAP</option>"; 
						}else{ echo "<option value=\"1\">SOAP</option><option value=\"0\">Telnet</option>"; }
					echo"</select></td>
					<td align=\"left\" valign=\"top\" class=\"form-desc\">Remote Access Type. This is set in your server config file.</td>
				</tr>
				<tr>
					<td width=\"20%\" align=\"right\" valign=\"middle\" class=\"form-text\">Remote Access Port:</td>
					<td width=\"15%\" align=\"left\" valign=\"middle\">
					<input type=\"text\" name=\"ra_port\" size=\"5\" class=\"inputbox\" value=\"".$rlm_info['ra_port']."\" /></td>
					<td align=\"left\" valign=\"top\" class=\"form-desc\">Port for your remote access. Telnet default: 3443. SOAP default: 7878</td>
				</tr>
				<tr>
					<td width=\"20%\" align=\"right\" valign=\"middle\" class=\"form-text\">Remote Access Account:</td>
					<td width=\"15%\" align=\"left\" valign=\"middle\">
					<input type=\"text\" name=\"ra_user\" size=\"20\" class=\"inputbox\" value=\"".$rlm_info['ra_user']."\" /></td>
					<td align=\"left\" valign=\"top\" class=\"form-desc\">Username, to an admin account for RA to use.</td>
				</tr>
				<tr>
					<td width=\"20%\" align=\"right\" valign=\"middle\" class=\"form-text\">Remote Access Pass:</td>
					<td width=\"15%\" align=\"left\" valign=\"middle\">
					<input type=\"text\" name=\"ra_pass\" size=\"20\" class=\"inputbox\" value=\"".$rlm_info['ra_pass']."\" /></td>
					<td align=\"left\" valign=\"top\" class=\"form-desc\">Password to the admin account listed above..</td>
				</tr>
				<tr>
					<td colspan=\"3\" align=\"center\" class=\"buttons\">
						<button name=\"process\" class=\"button\" type=\"submit\"><b>Update</b></button>&nbsp;&nbsp;
					</td>
				</tr>
			</table>
			</form>
		</div>";
}
?>