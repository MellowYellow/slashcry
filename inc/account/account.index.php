<?php
//========================//
if(INCLUDED!==true) {
	echo "Not Included!"; exit;
}
//=======================//
if($user['id'] == -1) {
  redirect('index.php?p=account&sub=login',1);
}
$pid = $myprofile['id'];
$trin_gm = @$DB->selectCell("SELECT gmlevel FROM account_access WHERE id=?d",$pid);
if(!$trin_gm) {
	$gmlevel = '0 (Member)';
}else{
	$gmlevel = $trin_gm;
}
$seebanned = $DB->select("SELECT * FROM account_banned WHERE id=?d AND `active`=1",$user['id']);
if(count($seebanned) > 0 || $myprofile['locked'] == 1) {
	$stat = '<font color="red">Frozen</font>';
}else{
	$stat = '<font color="green">Active</font>';
}
?>