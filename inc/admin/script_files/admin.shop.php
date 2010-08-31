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

// Get all items
$getitems = $DB->select("SELECT * FROM shop_items ORDER BY `id` ASC LIMIT $limitvalue, $limit;");
$getcnt = $DB->select("SELECT item_number FROM shop_items");
$totalrows = count($getcnt);

function showItem($iid) {
	global $DB;
	$items = $DB->selectRow("SELECT * FROM `shop_items` WHERE `id`=?d", $iid);
	$realmz = $DB->select("SELECT id,name FROM realmlist ORDER BY name");
	foreach($realmz as $aaa) {
	$realmzlist = "<option value='".$aaa['id']."'>".$aaa['name']."</option>";
	}
	echo"
	<div class=\"content\ align=\"center\">
		<form method=\"POST\" action=\"index.php?p=admin&sub=shop&id=".$iid."\">
		<input type=\"hidden\" name=\"edit_item\" value=".$iid.">
		<table width=\"95%\" border=\"0\" style=\"border: 2px solid #808080;\" align=\"center\">
			<tr>
				<td colspan=\"3\" align=\"center\" class=\"header\"><b><font color='#0e84d9'>Managing Shop Item ID: </font><font color='#C77B00'>".$iid."</font></b></td>
			</tr>
		</table>
		<br />";
		if(isset($_POST['delete'])) {
			$DB->query("DELETE FROM `shop_items` WHERE id=?d", $iid);
			output_message('notice', 'Item successfully deleted! Please redirect to avoid an error.');
		}elseif(isset($_POST['edit_item'])) {
		$DB->query("UPDATE `shop_items` SET 
			`item_number`= '".$_POST['item_number']."',
			`itemset`= '".$_POST['itemset']."',
			`gold`= '".$_POST['gold']."',
			`quanity`= '".$_POST['quanity']."',
			`desc`= '".$_POST['desc']."',
			`wp_cost`= '".$_POST['wp_cost']."',
			`donation_cost`= '".$_POST['dc']."',
			`realms`='".$_POST['realms']."'
			WHERE `id`=".$iid."");
		output_message('notice', 'Shop Item Successfully Updated!');
		}
		echo"
		<table width=\"95%\" border=\"0\" style=\"border: 2px solid #808080;\" align=\"center\">
			<tr>
				<td colspan=\"3\" align=\"center\" class=\"form-head\"><u>Shop Item Details:</u></td>
			</tr>
			<tr>
				<td width=\"15%\" align=\"right\" valign=\"middle\" class=\"form-text\">Item Number:</td>
				<td width=\"15%\" align=\"left\" valign=\"middle\">
				<input type=\"text\" name=\"item_number\" size=\"20\" class=\"inputbox\" value=\"".$items['item_number']."\" /></td>
				<td align=\"left\" valign=\"top\" class=\"form-desc\">Item Number for reward. Seperate multiple items with a comma \",\" (0 = No Item)</td>
			</tr>
			<tr>
				<td width=\"15%\" align=\"right\" valign=\"middle\" class=\"form-text\">Itemset Number:</td>
				<td width=\"15%\" align=\"left\" valign=\"middle\">
				<input type=\"text\" name=\"itemset\" size=\"10\" class=\"inputbox\" value=\"".$items['itemset']."\" /></td>
				<td align=\"left\" valign=\"top\" class=\"form-desc\">Itemset Number for reward. Limit 1. (0 = No Itemset)</td>
			</tr>
			<tr>
				<td width=\"15%\" align=\"right\" valign=\"middle\" class=\"form-text\">Gold:</td>
				<td width=\"15%\" align=\"left\" valign=\"middle\">
				<input type=\"text\" name=\"gold\" size=\"10\" class=\"inputbox\" value=\"".$items['gold']."\" /></td>
				<td align=\"left\" valign=\"top\" class=\"form-desc\">Enter amount of gold to be sent in copper.(ie: 10000 = 1g)</td>
			</tr>
			<tr>
				<td width=\"15%\" align=\"right\" valign=\"middle\" class=\"form-text\">Quanity:</td>
				<td width=\"15%\" align=\"left\" valign=\"middle\">
				<input type=\"text\" name=\"quanity\" size=\"1\" class=\"inputbox\" value=\"".$items['quanity']."\" /></td>
				<td align=\"left\" valign=\"top\" class=\"form-desc\">Quanity (amount) of items recieving. Does not affect gold or itemsets!</td>
			</tr>
			<tr>
				<td width=\"15%\" align=\"right\" valign=\"middle\" class=\"form-text\">Web Point Cost:</td>
				<td width=\"15%\" align=\"left\" valign=\"middle\">
				<input type=\"text\" name=\"wp_cost\" size=\"4\" class=\"inputbox\" value=\"".$items['wp_cost']."\" /></td>
				<td align=\"left\" valign=\"top\" class=\"form-desc\">Cost via WP. Leave 0 to disable.</td>
			</tr>
			<tr>
				<td width=\"15%\" align=\"right\" valign=\"middle\" class=\"form-text\">Donation Cost:</td>
				<td width=\"15%\" align=\"left\" valign=\"middle\">
				<input type=\"text\" name=\"dc\" size=\"4\" class=\"inputbox\" value=\"".$items['donation_cost']."\" /></td>
				<td align=\"left\" valign=\"top\" class=\"form-desc\">Cost via Donation. NO '$'! Leave 0 to disable.</td>
			</tr>
			<tr>
				<td width=\"15%\" align=\"right\" valign=\"middle\" class=\"form-text\">Reward Desc: </td>
				<td width=\"15%\" align=\"left\" valign=\"middle\">
				<input type=\"text\" name=\"desc\" size=\"30\" class=\"inputbox\" value=\"".$items['desc']."\" /></td>
				<td align=\"left\" valign=\"top\" class=\"form-desc\">The item description shown to users when viewing award.</td>
			</tr>
			<tr>
				<td width=\"15%\" align=\"right\" valign=\"middle\" class=\"form-text\">Realms: </td>
				<td width=\"15%\" align=\"left\" valign=\"middle\">
				<select name=\"realms\" class=\"inputbox\">
					<option value=\"0\">All Realms</option>".$realmzlist."
				</select>
				</td>
				<td align=\"left\" valign=\"top\" class=\"form-desc\">Which Realm is this award available to?</td>
			</tr>
			<tr>
				<td colspan=\"3\" align=\"center\" class=\"buttons\">
					<button name=\"process\" class=\"button\" type=\"submit\"><b>Update</b></button>&nbsp;&nbsp;
					<button name=\"delete\" class=\"button\" type=\"submit\"><b>DELETE</b></button>&nbsp;&nbsp;
				</td>
			</tr>
		</table>
	</form>
</div>
";
}

function showAddForm() {
	global $DB;
	$realmz = $DB->select("SELECT id,name FROM realmlist ORDER BY name");
	foreach($realmz as $aaa) {
	$realmzlist = "<option value='".$aaa['id']."'>".$aaa['name']."</option>";
	}
	echo"
	<div class=\"content\ align=\"center\">
		<form method=\"POST\" action=\"index.php?p=admin&sub=shop&action=add\">
		<input type=\"hidden\" name=\"add_item\" value=\"add\">
		<br />";
		if(isset($_POST['add_item'])) {
		$DB->query("INSERT INTO shop_items(`item_number`, `itemset`, `gold`, `quanity`, `desc`, `wp_cost`, `donation_cost`, `realms`) 
			VALUES('".$_POST['item_number']."','".$_POST['itemset']."','".$_POST['gold']."','".$_POST['quanity']."','".$_POST['desc']."',
				'".$_POST['wp_cost']."','".$_POST['dc']."','".$_POST['realms']."')");
		output_message('notice', 'Shop Item Successfully Added!');
	}
		echo"
		<table width=\"95%\" border=\"0\" style=\"border: 2px solid #808080;\" align=\"center\">
			<tr>
				<td colspan=\"3\" align=\"center\" class=\"form-head\"><u>Shop Item Details:</u></td>
			</tr>
			<tr>
				<td width=\"15%\" align=\"right\" valign=\"middle\" class=\"form-text\">Item Number:</td>
				<td width=\"15%\" align=\"left\" valign=\"middle\">
				<input type=\"text\" name=\"item_number\" size=\"20\" class=\"inputbox\" value=\"0\" /></td>
				<td align=\"left\" valign=\"top\" class=\"form-desc\">Item Number for reward. Seperate multiple items with a comma \",\" (0 = No Item)</td>
			</tr>
			<tr>
				<td width=\"15%\" align=\"right\" valign=\"middle\" class=\"form-text\">Itemset Number:</td>
				<td width=\"15%\" align=\"left\" valign=\"middle\">
				<input type=\"text\" name=\"itemset\" size=\"10\" class=\"inputbox\" value=\"0\" /></td>
				<td align=\"left\" valign=\"top\" class=\"form-desc\">Itemset Number for reward. Limit 1. (0 = No Itemset)</td>
			</tr>
			<tr>
				<td width=\"15%\" align=\"right\" valign=\"middle\" class=\"form-text\">Gold:</td>
				<td width=\"15%\" align=\"left\" valign=\"middle\">
				<input type=\"text\" name=\"gold\" size=\"10\" class=\"inputbox\" value=\"0\" /></td>
				<td align=\"left\" valign=\"top\" class=\"form-desc\">Enter amount of gold to be sent in copper.(ie: 10000 = 1g)</td>
			</tr>
			<tr>
				<td width=\"15%\" align=\"right\" valign=\"middle\" class=\"form-text\">Quanity:</td>
				<td width=\"15%\" align=\"left\" valign=\"middle\">
				<input type=\"text\" name=\"quanity\" size=\"1\" class=\"inputbox\" value=\"1\" /></td>
				<td align=\"left\" valign=\"top\" class=\"form-desc\">Quanity (amount) of items recieving. Does not affect gold or itemsets!</td>
			</tr>
			<tr>
				<td width=\"15%\" align=\"right\" valign=\"middle\" class=\"form-text\">Web Point Cost:</td>
				<td width=\"15%\" align=\"left\" valign=\"middle\">
				<input type=\"text\" name=\"wp_cost\" size=\"4\" class=\"inputbox\" value=\"0\" /></td>
				<td align=\"left\" valign=\"top\" class=\"form-desc\">Cost via WP. Leave 0 to disable.</td>
			</tr>
			<tr>
				<td width=\"15%\" align=\"right\" valign=\"middle\" class=\"form-text\">Donation Cost:</td>
				<td width=\"15%\" align=\"left\" valign=\"middle\">
				<input type=\"text\" name=\"dc\" size=\"4\" class=\"inputbox\" value=\"0.00\" /></td>
				<td align=\"left\" valign=\"top\" class=\"form-desc\">Cost via Donation (USD). NO '$'! Leave 0.00 to disable.</td>
			</tr>
			<tr>
				<td width=\"15%\" align=\"right\" valign=\"middle\" class=\"form-text\">Reward Desc: </td>
				<td width=\"15%\" align=\"left\" valign=\"middle\">
				<input type=\"text\" name=\"desc\" size=\"30\" class=\"inputbox\" /></td>
				<td align=\"left\" valign=\"top\" class=\"form-desc\">The item description shown to users when viewing award.</td>
			</tr>
			<tr>
				<td width=\"15%\" align=\"right\" valign=\"middle\" class=\"form-text\">Realms: </td>
				<td width=\"15%\" align=\"left\" valign=\"middle\">
				<select name=\"realms\" class=\"inputbox\">
					<option value=\"0\">All Realms</option>".$realmzlist."
				</select>
				</td>
				<td align=\"left\" valign=\"top\" class=\"form-desc\">Which Realm is this award available to?</td>
			</tr>
			<tr>
				<td colspan=\"3\" align=\"center\" class=\"buttons\">
					<button name=\"process\" class=\"button\" type=\"submit\"><b>Submit</b></button>&nbsp;&nbsp;
				</td>
			</tr>
		</table>
	</form>
</div>
";
}
?>