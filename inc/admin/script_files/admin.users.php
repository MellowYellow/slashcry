<?php
//========================//
if(INCLUDED!==true) {
	echo "Not Included!"; exit;
}
//=======================//

//====== Pagination Code ======/
$limit = 50; //$cfg->get('admin_page_size');		// Sets how many results shown per page	
if(!isset($_GET['page']) || (!is_numeric($_GET['page']))){
        $page = 1;
	} else {
		$page = $_GET['page'];
    }
$limitvalue = $page * $limit - ($limit);	// Ex: (2 * 25) - 25 = 25 <- data starts at 25

//===== Filter ==========// (Taken from MangosWeb :p )
    if($_GET['char'] && preg_match("/[a-z]/", $_GET['char'])){
        $filter = "WHERE `username` LIKE '" . $_GET['char'] . "%'";
    }elseif($_GET['char'] == 1){
        $filter = "WHERE `username` REGEXP '^[^A-Za-z]'";
    }else{
        $filter = '';
    }
	
// Get all users
$getusers = $DB->select("SELECT * FROM account $filter ORDER BY `username` ASC LIMIT $limitvalue, $limit;");
$getcnt = $DB->select("SELECT username FROM account");
$totalrows = count($getcnt);

//===== Start of functions =====/

// Change password admin style :p
function adminChangePass($id, $newp) {
	global $DB;
	$newpd = trim($newp);
    if(strlen($newpd) > 3){
        $uname = $DB->selectCell("SELECT username FROM account WHERE id=?d",$id);
        $DB->query("UPDATE account SET sessionkey = NULL WHERE id=?d",$id);
        $sha_pass = sha_password($uname,$newpd);
        $DB->query("UPDATE account SET sha_pass_hash='$sha_pass' WHERE id='$id'");
        output_message('notice', '<b>Success!</b> '.$uname.'\'s password sucessfully changed to '.$newpd.'.');
    }else{
        output_message('alert', '<b>Failed!</b> Password too short.');
    }
}

// Unban user
function unBan($unbanid) {
	global $DB;
	$DB->query("UPDATE account_banned SET active=0 WHERE id=?d ", $unbanid);
    $ipd = $DB->selectCell("SELECT last_ip FROM account WHERE id=?d",$unbanid);
    $DB->query("DELETE FROM ip_banned WHERE ip=?d",$ipd);
	$DB->query("UPDATE account_extend SET `account_level`=2 WHERE account_id=?d",$unbanid);
	output_message('notice','Success, User unbanned!<br />
	Click <a href="index.php?p=admin&sub=users&id='.$unbanid.'" />Here</a> to return to users profile');
}

// Delete user's account
function deleteUser($did) {
}

// Ban user
function banUser($bannid,$banreason) {
	global $DB, $user;
	if(!$banreason) {
		$banreason = "Not Specified";
	}
	$DB->query("INSERT into account_banned (id, bandate, unbandate, bannedby, banreason, active) 
		values (?d, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()-10, ?d, ?d, 1)", $bannid, $user['username'], $banreason);
    $getipadd = $DB->selectCell("SELECT last_ip FROM account WHERE id=?d",$bannid);
    $DB->query("INSERT into ip_banned (ip, bandate, unbandate, bannedby, banreason) values (?d, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()-10, ?d, ?d)",$getipadd, $user['username'], $banreason);
	$DB->query("UPDATE account_extend SET `account_level`=5 WHERE account_id=?",$bannid);
	output_message('notice','Success. Account #'.$bannid.' Successfully banned. Reason: '.$banreason.'.<br />
	Click <a href="index.php?p=admin&sub=users&id='.$bannid.'" />Here</a> to return to users profile');
}

//===== Show Form Functions =====/

// Show user form function. Returns users profile with admin options
function showUser($pid) {
	global $auth, $cfg, $DB;
	$profile = $auth->getprofile($pid);
	$allgroups = $DB->select("SELECT * FROM account_groups");
	$seebanned = $DB->select("SELECT * FROM account_banned WHERE id=?d AND `active`=1",$pid);
		if(count($seebanned) > 0) {
			$bann = 1;
		}else{
			$bann = 0;
		}
	$lastvisit = date("Y-m-d, g:i a", $profile['last_visit']);
	echo "<div class=\"content-head\">
			<div class=\"desc-title\">Manage User</div>
			<div class=\"description\">
				<i>Description:</i> Here you can modify ".$profile['username']."'s Profile.
			</div>
		</div>";
	// Establish all the posts that deal with functions
	if(isset($_POST['edit_password'])) {
		echo $_POST['profile_change_pass'];
		adminChangePass($_GET['id'], $_POST['profile_change_pass']);
	}elseif(isset($_POST['edit_details'])) {
		$DB->query("UPDATE `account` SET `email`='". $_POST['set_profile_email']."', `locked`=".$_POST['set_profile_locked'].", `expansion`=".$_POST['set_profile_expansion']." WHERE id=".$_GET['id']."");
		output_message('notice', 'Account details changed successfully!');
	}elseif(isset($_POST['edit_user'])) {
		$DB->query("UPDATE `account_extend` SET `account_level`='". $_POST['profile_level']."', `theme`=".$_POST['profile_theme'].", `hide_email`=".$_POST['profile_hide']." WHERE account_id=".$_GET['id']."");
		output_message('notice', 'Account details changed successfully!');
	}elseif(isset($_POST['delete_acc'])) {
		deleteUser($_GET['id']);
	}	
	echo "
		<div class=\"content\" align=\"center\">
			<form method=\"POST\" action=\"index.php?p=admin&sub=users&id=".$_GET['id']."\" name=\"adminform\">
			<input type=\"hidden\" name=\"edit_details\" value=".$pid.">
			<table width=\"95%\" border=\"0\" style=\"border: 2px solid #808080;\">
				<tr>
					<td colspan=\"3\" align=\"center\" class=\"header\"><b><font color='#0e84d9'>Managing User: </font><font color='#C77B00'>".$profile['username']."</font></b></td>
				</tr>
			</table>
			<br />
			<table width=\"95%\" border=\"0\" style=\"border: 2px solid #808080;\">
				<tr>
					<td colspan=\"4\" align=\"center\" class=\"form-head\"><b>Account Information</b></td>
				</tr>
				<tr>
					<td width=\"15%\" align=\"right\" valign=\"middle\" class=\"form-text\">Registration Date:</td>
					<td align=\"left\" class=\"form-text\">".$profile['joindate']."</td>
					<td width=\"25%\" align=\"right\" valign=\"middle\" class=\"form-text\">Times Voted: </td>
					<td align=\"left\" class=\"form-text\">".$profile['total_votes']."</td>
				</tr>
				<tr>
					<td width=\"15%\" align=\"right\" valign=\"middle\" class=\"form-text\">Registration IP:</td>
					<td  align=\"left\" class=\"form-text\">".$profile['registration_ip']."</td>
					<td width=\"25%\" align=\"right\" valign=\"middle\" class=\"form-text\">Web Points Balance: </td>
					<td align=\"left\" class=\"form-text\">".$profile['web_points']."</td>
				</tr>
				<tr>
					<td width=\"15%\" align=\"right\" valign=\"middle\" class=\"form-text\">Last Login (Game):</td>
					<td  align=\"left\" class=\"form-text\">".$profile['last_login']."</td>
					<td width=\"25%\" align=\"right\" valign=\"middle\" class=\"form-text\">Web Points Earned/Spent: </td>
					<td align=\"left\" class=\"form-text\">".$profile['points_earned']." / ".$profile['points_spent']."</td>
				</tr>
				<tr>
					<td width=\"15%\" align=\"right\" valign=\"middle\" class=\"form-text\">Last Activity (Site):</td>
					<td align=\"left\" class=\"form-text\">".$lastvisit."</td>
					<td width=\"25%\" align=\"right\" valign=\"middle\" class=\"form-text\">Total Donations: </td>
					<td align=\"left\" class=\"form-text\">$".$profile['total_donations']."</td>
				</tr>
				<tr>
					<td colspan=\"4\" align=\"center\" class\"form-text\" style=\"border-top: 1px dotted #808080; padding: 5px 5px 5px 5px;\">
					<a href=\"index.php?p=admin&sub=users&id=".$_GET['id']."&action=delete\"><b><font color=\"red\">Delete Account</font></b></a> || ";
					if($bann == 1) {
						echo "<a href=\"index.php?p=admin&sub=users&id=".$_GET['id']."&action=unban\"><b><font color=\"red\">Unban</font></b></a>";
					}elseif($bann == 0) { 
						echo "<a href=\"index.php?p=admin&sub=users&id=".$_GET['id']."&action=ban\"><b><font color=\"red\">Ban Account</font></b></a>";
					} 
					echo "
					</td>
				</tr>
			</table>
			<br />
			<table border=\"0\" width=\"95%\" style=\"border: 2px solid #808080;\">
				<tr>
					<td colspan=\"3\" class=\"form-head\">Edit Account Details</td>
				</tr>
				<tr>
					<td width=\"20%\" align=\"right\" valign=\"middle\" class=\"form-text\">User Name:</td>
					<td width=\"15%\" align=\"left\" valign=\"middle\">
					<input type=\"text\" name=\"profile_user\" size=\"20\" class=\"inputbox\" value=".$profile['username']." disabled=\"disabled\"></td>
					<td align=\"left\" valign=\"top\" class=\"form-desc\">Login.</td>
				</tr>
				<tr>
					<td width=\"20%\" align=\"right\" valign=\"middle\" class=\"form-text\">Email:</td>
					<td width=\"15%\" align=\"left\" valign=\"middle\">
					<input type=\"text\" name=\"set_profile_email\" size=\"30\" class=\"inputbox\" value=".$profile['email']."></td>
					<td align=\"left\" valign=\"top\" class=\"form-desc\">Users Email Address.</td>
				</tr>
				<tr>
					<td width=\"20%\" align=\"right\" valign=\"middle\" class=\"form-text\">Locked:</td>
					<td width=\"15%\" align=\"left\" valign=\"middle\">
					<select name=\"set_profile_locked\" class=\"inputbox\">";
						echo '<option value="0"';
						if ($profile['locked'] == 0) {echo ' selected="selected"';}
							echo '>No</option>';
						echo '<option value="1"';
						if ($profile['locked'] == 1) {echo ' selected="selected"';}
							echo '>Yes</option>';
						echo "</td>
					<td align=\"left\" valign=\"top\" class=\"form-desc\">Is users account locked?</td>
				</tr>
				<tr>
					<td width=\"20%\" align=\"right\" valign=\"middle\" class=\"form-text\">Account Expansion:</td>
					<td width=\"15%\" align=\"left\" valign=\"middle\">
						<select name=\"set_profile_expansion\" class=\"inputbox\">";
						echo '<option value="0"';
						if ($profile['expansion'] == 0) {echo ' selected="selected"';}
							echo '>Classic</option>';
							echo '<option value="1"';
						if ($profile['expansion'] == 1) {echo ' selected="selected"';}
							echo '>TBC</option>';
							echo '<option value="2"';
						if ($profile['expansion'] == 2) {echo ' selected="selected"';}
							echo '>WotLK</option>';
							echo "</select></td>
					<td align=\"left\" valign=\"top\" class=\"form-desc\">Account Expansion.</td>
				</tr>
				<tr>
					<td colspan=\"3\" align=\"center\" class=\"buttons\">
						<button name=\"process\" class=\"button\" type=\"submit\"><b>Update</b></button>&nbsp;&nbsp;
					</td>
				</tr>
			</table>
			</form>
			<br />
			<form method=\"POST\" action=\"index.php?p=admin&sub=users&id=".$pid."\" name=\"adminform\">
			<input type=\"hidden\" name=\"edit_password\" value=".$pid.">
			<table border=\"0\" width=\"95%\" style=\"border: 2px solid #808080;\">
			<tr>
				<td colspan=\"3\" class=\"form-head\">Change Account Password</td>
			</tr>
			<tr>
				<td width=\"20%\" align=\"right\" valign=\"middle\" class=\"form-text\">New Password:</td>
				<td width=\"15%\" align=\"left\" valign=\"middle\">
				<input type=\"text\" name=\"profile_change_pass\" size=\"20\" class=\"inputbox\"></td>
				<td align=\"left\" valign=\"top\" class=\"form-desc\">Enter New Password.</td>
			</tr>
			<tr>
				<td colspan=\"3\" align=\"center\" class=\"buttons\">
					<button name=\"process\" class=\"button\" type=\"submit\"><b>Change</b></button>&nbsp;&nbsp;
				</td>
			</tr>
			</table>
			</form>
			<br />
			<form method=\"POST\" action=\"index.php?p=admin&sub=users&id=".$pid."\" name=\"adminform\">
			<input type=\"hidden\" name=\"edit_user\" value=".$pid.">
			<table border=\"0\" width=\"95%\" style=\"border: 2px solid #808080;\">
			<tr>
				<td colspan=\"3\" class=\"form-head\">Edit User Site Details</td>
			</tr>
			<tr>
				<td width=\"20%\" align=\"right\" valign=\"middle\" class=\"form-text\">Account Level (site):</td>
				<td width=\"15%\" align=\"left\" valign=\"middle\">
				<select name=\"profile_level\" style=\"margin:1px;\" class=\"inputbox\">";
				echo '<option value="1"';
				if ($profile['account_level'] == 1) {echo ' selected="selected"';}
				echo '>Guest</option>';
				echo '<option value="2"';
				if ($profile['account_level'] == 2) {echo ' selected="selected"';}
				echo '>Member</option>';
				echo '<option value="3"';
				if ($profile['account_level'] == 3) {echo ' selected="selected"';}
				echo '>Admin</option>';
				echo '<option value="4"';
				if ($profile['account_level'] == 4) {echo ' selected="selected"';}
				echo '>Super Admin</option>';
				echo '<option value="5"';
				if ($profile['account_level'] == 5) {echo ' selected="selected"';}
				echo '>Banned</option>';
				echo "
            </select>
				<td align=\"left\" valign=\"top\" class=\"form-desc\">Website Account Level.</td>
			</tr>
			<tr>
				<td width=\"20%\" align=\"right\" valign=\"middle\" class=\"form-text\">Selected Theme:</td>
				<td width=\"15%\" align=\"left\" valign=\"middle\">
				<select name=\"profile_theme\" style=\"margin:1px;\" class=\"inputbox\">";
				$alltmpl = explode(",", $cfg->get('templates'));
				$key = 0;
				foreach($alltmpl as $tmpls) {
					echo '<option value="'.$key.'"';
					if ($profile['theme'] == $key) {echo ' selected="selected"';}
						echo '>'.$tmpls.'</option>';
					$key++;
				}
				echo "</td>
				<td align=\"left\" valign=\"top\" class=\"form-desc\">Users selected website theme.</td>
			</tr>
			<tr>
				<td width=\"20%\" align=\"right\" valign=\"middle\" class=\"form-text\">Hide Email:</td>
				<td width=\"15%\" align=\"left\" valign=\"middle\">
				<select name=\"profile_hide\" style=\"margin:1px;\" class=\"inputbox\">";
				if($profile['hide_email'] == 0) { 
					echo "<option value=\"0\">No</option><option value=\"1\">Yes</option>";
				}else{
					echo "<option value=\"1\">Yes</option><option value=\"0\">No</option>";
				}
				echo "</select></td>
				<td align=\"left\" valign=\"top\" class=\"form-desc\">Hide users email in view profile?</td>
			</tr>
			<tr>
				<td colspan=\"3\" align=\"center\" class=\"buttons\">
					<button name=\"process\" class=\"button\" type=\"submit\"><b>Change</b></button>&nbsp;&nbsp;
				</td>
			</tr>
			</table>
			</form>
        </div>
	";
}

// Show ban form is used to input a Ban reason, before acutally banning
function showBanForm($banid) {
	global $DB, $cfg;
	$unme = $DB->selectCell("SELECT username FROM account WHERE id=?d",$banid);
	echo "
	<div class=\"content-head\">
		<div class=\"desc-title\">Ban User Form</div>
		<div class=\"description\">
		<i>Description:</i> Ban users here.
		</div>
	</div>
	<div class=\"content\" align=\"center\">";
	if(isset($_POST['ban_user'])) {
		banUser($_POST['ban_user'],$_POST['ban_reason']);
	}
	echo "
		<form method=\"POST\" action=\"index.php?p=admin&sub=users&id=".$banid."&action=ban\" name=\"adminform\">
		<table border=\"0\" width=\"95%\" style=\"border: 2px solid #808080;\">
			<tr>
				<td colspan=\"3\" class=\"form-head\">Ban Account #".$banid." (".$unme.")</td>
			</tr>
			<tr>
				<td width=\"20%\" align=\"right\" valign=\"middle\" class=\"form-text\">Ban Reason:</td>
				<td width=\"15%\" align=\"left\" valign=\"middle\">
				<input type=\"text\" name=\"ban_reason\" size=\"60\" class=\"inputbox\" /></td>
				<input type=\"hidden\" name=\"ban_user\" value=\"".$banid."\" />
				<td align=\"left\" valign=\"top\" class=\"form-desc\"></td>
			</tr>
			<tr>
				<td colspan=\"3\" align=\"center\" class=\"form-text2\">
					<button name=\"process\" class=\"button\" type=\"submit\"><b>Ban User</b></button>&nbsp;&nbsp;
				</td>
			</tr>
		</table>
		</form>
	</div>
	";
}
?>