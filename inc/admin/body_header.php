<?php
	// Block out all users who arent admins
	if($user['account_level'] == 5) {
		echo "You Are Banned";
		exit;
	}
	if($user['account_level'] <= 2) {
		redirect('index.php',1);
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
	<title>KeysCMS Admin Panel</title>
	<link rel="stylesheet" href="inc/admin/css/main.css" type="text/css"/>
	<!-- OF COURSE YOU NEED TO ADAPT NEXT LINE TO YOUR tiny_mce.js PATH -->
	<script type="text/javascript" src="inc/tiny_mce/tiny_mce.js"></script>
	<script src="http://static.wowhead.com/widgets/power.js"></script>

<script type="text/javascript">
	tinyMCE.init({
		// General options
		mode : "textareas",
		theme : "advanced",
		plugins : "style,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist",

		// Theme options
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,image,|,insertdate,inserttime,preview,|,forecolor",
		theme_advanced_buttons3 : "hr,|,charmap,emotions,iespell,|,fullscreen",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Example content CSS (should be your site CSS)
		content_css : "css/content.css",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",

		// Style formats
		style_formats : [
			{title : 'Bold text', inline : 'b'},
			{title : 'Red text', inline : 'span', styles : {color : '#ff0000'}},
			{title : 'Red header', block : 'h1', styles : {color : '#ff0000'}},
			{title : 'Example 1', inline : 'span', classes : 'example1'},
			{title : 'Example 2', inline : 'span', classes : 'example2'},
			{title : 'Table styles'},
			{title : 'Table row 1', selector : 'tr', classes : 'tablerow1'}
		],

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
	});
</script>

</head>

<body>
<table border="0" width="960px" height="100%" align="center" id="maintable" class="maintable">
	<tr>
		<td align="center" colspan="2" height="80px" valign="top" style="border-bottom: 1px dotted #666666;">
			<div class="title">KeysCMS Admin Panel</div>
			<div class="dbver">Core Version: <?php echo $site_rev; ?> || Expected Database Version: 
			<?php 
			$db_act_ver = $DB->selectCell("SELECT dbver FROM keyscms_version");
			if($db_act_ver < $site_db) { echo "<font color='red'>".$site_db." (<a href=\"index.php?p=admin&sub=updates\" /><small>Needs Updated</small></a>)</font>";
			}elseif($db_act_ver > $site_db) { echo "<font color='red'>".$site_db." (<a href=\"index.php?p=admin&sub=updates\" /><small>Database outdates the core!</small></a>)</font>";
			}else{ echo $site_db; } 
			?>
			<br /><br /><a href="index.php">Site Index</a> | <a href="index.php?p=admin">Admin Index</a></div>
		</td>
	</tr>
	<tr>
		<td width="150px" align="left" valign="top" style="border-right: 1px dotted #666666;" >
		<?php server_display_info(); ?>
		</td>
		<td align="left" valign="top">