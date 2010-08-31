<?php
//========================//
if(INCLUDED!==true) {
	echo "Not Included!"; exit;
}
//=======================//
$gettopics = $DB->select("SELECT `title`,`id`,`posted_by`,`post_time` FROM `site_news`");

// If posting a new News post
function addNews($subj,$message,$un) {
	global $DB;
    if(!$subj | !$message){
		echo "<center><font color='darkred'>You left a field empty!!</font></center><br />";
	}else{
		$post_time = time();
		$sql =  "INSERT INTO site_news(title, message, posted_by, post_time) VALUES('".$subj."','".$message."','".$un."','".$post_time."')";
        $tabs = $DB->query($sql);
		echo "<center><font color='blue'>Sucessfully Added News To Database!</font></center><br /><br />";
    }
}
function editNews($idz,$mess) {
	global $DB;
	if(!$mess){
		echo "<center><font color='darkred'>You left a field empty!!</font></center><br />";
	}else{
		$DB->query("UPDATE `site_news` SET `message`='$mess' WHERE `id`='$idz'");
		echo "<center><font color='blue'>Sucessfully Editted News In Database!</font></center><br /><br />";
	}
}
function delNews($idzz) {
	global $DB;
	$DB->query("DELETE FROM `site_news` WHERE `id`='$idzz'");
	echo "<center><font color='blue'>Sucessfully Deleted News!</font></center><br /><br />";
}
?>