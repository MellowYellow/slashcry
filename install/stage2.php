<?php
if (!$_POST['dbType'] | !$_POST['dbip'] | !$_POST['dbPort'] | !$_POST['dbUsername'] | !$_POST['dbPassword'] | !$_POST['dbname'] | !$_POST['chardb'] | !$_POST['worlddb']) {
	die('<center>Error!<br /><br />One or more fileds were left empty. Please <a href="javascript: history.go(-1)">go back</a> and correct it.</center>');
	}
	@mysql_connect($_POST['dbip'].":".$_POST['dbPort'], $_POST['dbUsername'], $_POST['dbPassword']) 
	or die ('<center>Error!<br /><br />Couldn\'t connect to the MySql server, most likely the given information is wrong. Please <a href="javascript: history.go(-1)">go back</a> and correct it.<br /><br />MySql error log:<br /></center>'.mysql_error());
	
	@mysql_select_db($_POST['worlddb']) or die('<center>Error!<br /><br />Couldn\'t select World db, most likely the given name is wrong. Please <a href="javascript: history.go(-1)">go back</a> and correct it.<br /><br />MySql error log:<br /></center>'.mysql_error());
	@mysql_select_db($_POST['chardb']) or die('<center>Error!<br /><br />Couldn\'t select Characters db, most likely the given name is wrong. Please <a href="javascript: history.go(-1)">go back</a> and correct it.<br /><br />MySql error log:<br /></center>'.mysql_error());
	@mysql_select_db($_POST['dbname']) or die('<center>Error!<br /><br />Couldn\'t select Website db, most likely the given name is wrong. Please <a href="javascript: history.go(-1)">go back</a> and correct it.<br /><br />MySql error log:<br /></center>'.mysql_error());
	// Check if "account" table exsists, so we make (almost) sure mangos is actually installed (which is necesarry for this whole thing to work)
	@mysql_query("SELECT * FROM `account` LIMIT 1") or die('Error!<br /><br />Account table not found, seems like a WoW Emulator isn\'t installed.<br /><br />MySql error log:<br />'.mysql_error());
	
	// Everthing should be fine, so first insert info into protected config file
		$conffile = "../config/config-protected.php";
		$handle = fopen("../config/config-protected.php", "a+");
        $build = '';
        $build .= "<?php\n";
        $build .= "\$db = array(\n";
        $build .= "'db_type'         => '".$_POST['dbType']."',\n";
        $build .= "'db_host'         => '".$_POST['dbip']."',\n";
        $build .= "'db_port'         => '".$_POST['dbPort']."',\n";
        $build .= "'db_username'     => '".$_POST['dbUsername']."',\n";
        $build .= "'db_password'     => '".$_POST['dbPassword']."',\n";
        $build .= "'db_name'         => '".$_POST['dbname']."',\n";
        $build .= "'db_encoding'     => 'utf8',\n";
        $build .= ");\n";
		$build .= "?>";
		
	if (is_writeable($conffile)){
        $openconf = fopen($conffile, 'wb');
        fwrite($openconf, $build);
        fclose($openconf);
	}else{ 
		die('Error!<br /><br />Couldn\'t open main-config.php for editing, it must be writable by webserver! <br /><a href="javascript: history.go(-1)">Go back, and try again.</a>');
	}
// Dealing with the full install sql file

// Check to see if one of the sites tables exist
$check = @mysql_query("SELECT * FROM `account_extend` LIMIT 1");
if(!$check) {
	$sqlopen = @fopen("sql/full_install.sql", "r");
	if ($sqlopen) {
		while (!feof($sqlopen)) {
			$queries[] = fgets($sqlopen);
		}
		fclose($sqlopen);
			}else {
				echo "Error!<br /><br />Couldn\'t open file full_install.sql. Check if it\'s presented in wwwroot/sql/ and if it\'s readable by webserver!";
				$errmsg = error_get_last();
				echo "<br /><br />PHP error log:<br />".$errmsg['message'];
				exit();}
		foreach ($queries as $key => $aquery) {
			if (trim($aquery) == "" || strpos ($aquery, "--") === 0 || strpos ($aquery, "#") === 0) {unset($queries[$key]);}
		}
		unset($key, $aquery);

		foreach ($queries as $key => $aquery) {
		$aquery = rtrim($aquery);
		$compare = rtrim($aquery, ";");
	if ($compare != $aquery) {$queries[$key] = $compare . "|br3ak|";}
	}
	unset($key, $aquery);

	$queries = implode($queries);
	$queries = explode("|br3ak|", $queries);

	// Sql injection
	foreach ($queries as $query) {
	mysql_query($query);
	}
	// Extra sql query with db settings
	$dbinfo = $_POST['db_username'].";".$_POST['db_password'].";".$_POST['db_port'].";".$_POST['db_host'].";".$_POST['world_db_name'].";".$_POST['character_db_name'];
	mysql_query("UPDATE `realmlist` SET `dbinfo` = '".$dbinfo."' WHERE `id` = 1 LIMIT 1") or die(mysql_error());
	echo "<center>Config file successfully created! Press \"Proceed to setp 3\" to continue</center><br /><br />";
}else{
echo "<center>You already have your database installed, Press \"Proceed to setp 3\" to continue</center><br /><br />";
}
?>
<form method="POST" action="index.php?step=3">
<input type="hidden"  name="stage" value="3">
<input type="hidden"  name="dbType" value="<?php echo $_POST['dbType']; ?>">
<input type="hidden"  name="dbip" value="<?php echo $_POST['dbip']; ?>">
<input type="hidden"  name="dbPort" value="<?php echo $_POST['dbPort']; ?>">
<input type="hidden"  name="dbUsername" value="<?php echo $_POST['dbUsername']; ?>">
<input type="hidden"  name="dbPassword" value="<?php echo $_POST['dbPassword']; ?>">
<input type="hidden"  name="realmdb" value="<?php echo $_POST['dbname']; ?>">
<table align="center" border="0" width="500px" style="border: 2px solid #808080;">
<tr>
	<td align="center"><button name="reset" class="button" type="reset">Cancel</button>&nbsp;&nbsp;
	<button name="step3" class="button" type="submit">Proceed to Step 3</button>
	</td>
</tr>
</table>
</form>