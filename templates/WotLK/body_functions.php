<?php
function displayPathwayInfo() {
	global $ext, $sub;
	if(isset($_GET['sub'])) {
		echo "<a href=\"index.php\" />Home</a> :: <a href=\"index.php?p=".$ext."\" />".$ext."</a> :: <a href=\"index.php?p=".$ext."&sub=".$sub."\" />".$sub."</a><br />";
	}elseif(isset($_GET['p'])) {
		echo "<a href=\"index.php\" />Home</a> :: <a href=\"index.php?p=".$ext."\" />".$ext."</a><br />";
	}else{ }
}
?>