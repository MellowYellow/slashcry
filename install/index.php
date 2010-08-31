<?php
/***************************************
* MangosWeb Enhanced Installer         *
* Author:	Wilson212                  *
* Email:	wilson.steven10@yahoo.com  *
*                                      *
***************************************/
include('../core/core.php');
$task = $_GET['step'];
if(!isset($_GET['step'])) {
	$task = 1;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
	<title>KeysCMS Installer</title>
	<link rel="stylesheet" href="main.css" type="text/css"/>
</head>

<body>
<table border="0" width="100%" height="100%" id="maintable">
	<tr>
		<td width="130" height="80" style="border-bottom: 1px dotted #666666;"><a href=""><img border="0" src=""></a></td>
		<td align="center" valign="top" style="border-bottom: 1px dotted #666666;">
			<div class="title">KeysCMS Installer</div>
			<div class="dbver">Site Version: <?php echo $site_rev ?> || Installer Version: 1.0 </div>
		</td>
	</tr>
	<tr>
		<td align="left" valign="top" style="border-right: 1px dotted #666666;" >
		<?php include("install.menu.php"); ?>
		</td>
		<td align="left" valign="top">
		<div class="content-head">
			<div class="desc-title">Welcome</div>
			<div class="description">
			<i>Description:</i> Welcome to the KeysCMS installer. Please follow the steps below to get your site all setup.
			</div>
		</div>
			<?php
			include('stage' . $task . '.php');
			?>
		</td>
	</tr>
</table>
</body>