<?php 
$upd = getContents();
$listup = explode(",", $upd);
foreach($listup as $list) {
	if($list > $site_rev) {
	$uplist = "<option value=".$list.">".$list."</option>";
	}
}
?>
<?php if(ini_get('allow_url_fopen') !== '1') { echo "ERROR!"; } ?>