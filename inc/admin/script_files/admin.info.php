<?php
//========================//
if(INCLUDED!==true) {
	echo "Not Included!"; exit;
}
//=======================//

$get_db_date = $DB->selectCell("SELECT `dbdate`	FROM keyscms_version");
$db_date = date("Y-m-d, g:i a", $get_db_date);
?>