<?php
//Password hash generator
function sha_password($user,$pass){
    $user = strtoupper($user);
    $pass = strtoupper($pass);
    return SHA1($user.':'.$pass);
}
mysql_connect($_POST['dbip'].":".$_POST['dbPort'], $_POST['dbUsername'], $_POST['dbPassword']);
mysql_select_db($_POST['reamdb']);
$accountid = mysql_query("SELECT `id` FROM `account` WHERE `username`=".$_POST['formUser']."");
$checkacc = mysql_num_rows($accountid);
if ($checkacc >= "1") {
echo "<center>Congratulations, your KeysCMS is now installed!<br /><br />Installation finished successfully, now you can login with your administrator account,  ".$_POST['formUser'].", on the <a href=\"../index.php\">site index</a> and do the further configurations!</center>";
}else{
// Account DOESNT exsist
// No such account, creating one, in this case pwd is needed, so checking whether it's provided...
if (!$_POST['formPass'] || !$_POST['formPass2']) {die('<center>Error!<br /><br />One or more fileds were left empty. Please <a href="javascript: history.go(-1)">go back</a> and correct it.</center>');
}
if ($_POST['passw'] != $_POST['passw2']) {die('<center>Error!<br /><br />Passwords didn\'t match. Please <a href="javascript: history.go(-1)">go back</a> and correct it.</center>');
}
$pass = sha_password($_POST['formUser'], $_POST['formPass']);
mysql_query("INSERT INTO `account` (`username`, `sha_pass_hash`) VALUES ('".$_POST['formUser']."', '$pass' );");
$accountid = mysql_query("SELECT `id` FROM `account` WHERE `username` LIKE '".$_POST['formUser']."'");
// $accountid = mysql_fetch_row($accountid);
echo "<center>Congratulations, your KeysCMS is now installed!<br /><br />Installation finished successfully, now you can login with your administrator account,  ".$_POST['formUser'].", on the <a href=\"../index.php\">site index</a> and do the further configurations!</center>";
}
