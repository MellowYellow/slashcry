<?php
//========================//
if(INCLUDED!==true) {
	echo "Not Included!";
	exit;
}
//=======================//

function displayNews() {
	global $DB;
	$getnews = $DB->select("SELECT * FROM site_news WHERE id > 0 ORDER BY id DESC");
	foreach($getnews as $news) {
		$dte = date("m/j/Y, g:i a", $news['post_time']);
		echo "<div id=\"news\">
				<div id=\"newshdr\"><b>".$news['title']."</b></div>
				<div id=\"newsdate\"><small>".$dte." by ".$news['posted_by']."</small></div>
				<div id=\"newsdesc\">".$news['message']."</div>
			</div>";
	}
}
?>