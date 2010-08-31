<div class="content-head">
		<div class="desc-title">Site Configuration</div>
		<div class="description">
		<i>Description:</i> This area allows you to alter the configuration of KeysCMS suite.
		</div>
	</div>
	<div class="content">
	<?php if(isset($_POST['task'])) {
		if($_POST['task'] == 'saveconfig') {
			saveConfig();
		}
	} ?>
		<form method="POST" action="index.php?p=admin&sub=siteconfig" onSubmit="return configvalidation(this);" name="adminform">
		<input type="hidden" name="task" value="saveconfig">
		
		<table border="0" width="95%" style="border: 2px solid #808080;">
			<tr>
				<td colspan="3" class="form-head">Site Configuration</td>
			</tr>
			<tr>
				<td colspan="3" align="center" class="form-section-head"><u>Basic Site Config:</u></td>
			</tr>
			<tr>
				<td width="20%" align="right" valign="middle" class="form-text">Site Title:</td>
				<td width="15%" align="left" valign="middle">
				<input type="text" name="cfg__site_title" size="20" class="inputbox" value="<?php echo $cfg->get('site_title'); ?>" /></td>
				<td align="left" valign="top" class="form-desc">Name of your Website.</td>
			</tr>
			<tr>
				<td align="right" valign="middle" class="form-text">Site Cookie:</td>
				<td width="15%" align="left" valign="middle">
				<input type="text" name="cfg__site_cookie" size="20" class="inputbox" value="<?php echo $cfg->get('site_cookie'); ?>" /></td>
				<td align="left" valign="top" class="form-desc">Site Cookie (Channing can cause login problems! Erase old cookies)</td>
			</tr>
			<tr>
				<td align="right" valign="middle" class="form-text">Site Href:</td>
				<td width="15%" align="left" valign="middle">
				<input type="text" name="cfg__site_href" size="20" class="inputbox" value="<?php echo dirname( $_SERVER['SCRIPT_NAME'] )."/" ; ?>" /></td>
				<td align="left" valign="top" class="form-desc">Filled Automatically, shouldnt need to touch this!</td>
			</tr>
			<tr>
				<td align="right" valign="middle" class="form-text">Site Base Href:</td>
				<td width="15%" align="left" valign="middle">
				<input type="text" name="cfg__base_href" size="30" class="inputbox" value="<?php echo "http://".$_SERVER['HTTP_HOST']."".dirname( $_SERVER['SCRIPT_NAME'] )."/" ; ?>" /></td>
				<td align="left" valign="top" class="form-desc">Filled Automatically, shouldnt need to touch this!</td>
			</tr>
			<tr>
				<td align="right" valign="middle" class="form-text">Site Armory Path:</td>
				<td width="15%" align="left" valign="middle">
				<input type="text" name="cfg__site_armory" size="30" class="inputbox" value="<?php echo $cfg->get('site_armory'); ?>" /></td>
				<td align="left" valign="top" class="form-desc">Path to your armory. Full http if outside KeysCMS root. (0 = disable)</td>
			</tr>
			<tr>
				<td align="right" valign="middle" class="form-text">Site Forum Path:</td>
				<td width="15%" align="left" valign="middle">
				<input type="text" name="cfg__site_forums" size="30" class="inputbox" value="<?php echo $cfg->get('site_forums'); ?>" /></td>
				<td align="left" valign="top" class="form-desc">Path to your Forums. Full http if outside KeysCMS root. (0 = disable)</td>
			</tr>
			<tr>
				<td align="right" valign="middle" class="form-text">Site Email:</td>
				<td width="15%" align="left" valign="middle">
				<input type="text" name="cfg__site_email" size="30" class="inputbox" value="<?php echo $cfg->get('site_email'); ?>" /></td>
				<td align="left" valign="top" class="form-desc">Email for account activations, and send emails from.</td>
			</tr>
			<tr>
				<td align="right" valign="middle" class="form-text">Site Copyright:</td>
				<td width="15%" align="left" valign="middle">
				<input type="text" name="cfg__copyright" size="30" class="inputbox" value="<?php echo $cfg->get('copyright'); ?>" /></td>
				<td align="left" valign="top" class="form-desc">Site Copyright</td>
			</tr>
		<!-- Site Settings -->
			<tr>
				<td colspan="3" align="center" class="form-section-head"><u>Site Settings:</u></td>
			</tr>
			<tr>
				<td align="right" valign="middle" class="form-text">Emulator:</td>
				<td width="15%" align="left" valign="middle">
				<select name="cfg__emulator" class="inputbox">
				<?php if($cfg->get('emulator') == 'trinity') { ?>
				<option value="trinity">Trinity</option><option value="mangos">Mangos</option></select></td>
				<?php }else{ ?>
				<option value="mangos">Mangos</option><option value="trinity">Trinity</option></select></td>
				<?php } ?>
				<td align="left" valign="top" class="form-desc">What Emulator you running?</td>
			</tr>
			<tr>
				<td align="right" valign="middle" class="form-text">Default Template:</td>
				<td width="15%" align="left" valign="middle">
				<input type="text" name="cfg__default_template" size="20" class="inputbox" value="<?php echo $cfg->get('default_template'); ?>" /></td>
				<td align="left" valign="top" class="form-desc">Site Default Template</td>
			</tr>
			<tr>
				<td align="right" valign="middle" class="form-text">Default Component:</td>
				<td width="15%" align="left" valign="middle">
				<input type="text" name="cfg__default_component" size="20" class="inputbox" value="<?php echo $cfg->get('default_component'); ?>" /></td>
				<td align="left" valign="top" class="form-desc">Site Default Index Page</td>
			</tr>
			<tr>
				<td align="right" valign="middle" class="form-text">Site Templates:</td>
				<td width="15%" align="left" valign="middle">
				<input type="text" name="cfg__templates" size="30" class="inputbox" value="<?php echo $cfg->get('templates'); ?>" /></td>
				<td align="left" valign="top" class="form-desc">Site Templates, sepreate each template with ","</td>
			</tr>
			<tr>
				<td align="right" valign="middle" class="form-text">Default Realm ID:</td>
				<td width="15%" align="left" valign="middle">
				<input type="text" name="cfg__default_realm_id" size="1" class="inputbox" value="<?php echo $cfg->get('default_realm_id'); ?>" /></td>
				<td align="left" valign="top" class="form-desc">Site Default Realmd</td>
			</tr>
			<tr>
				<td align="right" valign="middle" class="form-text">Multiple Realms?:</td>
				<td width="15%" align="left" valign="middle">
				<?php if($cfg->get('multi_realms') == '0') { ?>
				<select name="cfg__multi_realm" class="inputbox"><option value="0">No</option><option value="1">Yes</option></td>
				<?php }else{ ?>
				<select name="cfg__multi_realm" class="inputbox"><option value="1">Yes</option><option value="0">No</option></td>
				<?php } ?>
				<td align="left" valign="top" class="form-desc">Do you host multiple realms?</td>
			</tr>
			<tr>
				<td align="right" valign="middle" class="form-text">Require Account Activation:</td>
				<td width="15%" align="left" valign="middle">
				<?php if($cfg->get('req_reg_act') == '0') { ?>
				<select name="cfg__req_reg_act" class="inputbox"><option value="0">No</option><option value="1">Yes</option></td>
				<?php }else{ ?>
				<select name="cfg__req_reg_act" class="inputbox"><option value="1">Yes</option><option value="0">No</option></td>
				<?php } ?>
				<td align="left" valign="top" class="form-desc">Email activation.</td>
			</tr>
		<!-- Module Settings -->
			<tr>
				<td colspan="3" align="center" class="form-section-head"><u>Module Settings:</u></td>
			</tr>
			<tr>
				<td align="right" valign="middle" class="form-text">News Module:</td>
				<td width="15%" align="left" valign="middle">
				<select name="cfg__module_news" class="inputbox">
				<?php if($cfg->get('module_news') == '0') { ?>
				<option value="0" selected="selected">Disabled</option><option value="1">Enabled</option></select></td>
				<?php }else{ ?>
				<option value="1" selected="selected">Enabled</option><option value="0">Disabled</option></select></td>
				<?php } ?>
				<td align="left" valign="top" class="form-desc">Display frontpage news via news module.</td>
			</tr>
			<tr>
				<td align="right" valign="middle" class="form-text">Welcome Mess. Module:</td>
				<td width="15%" align="left" valign="middle">
				<select name="cfg__module_welcome" class="inputbox">
				<?php if($cfg->get('module_welcome') == '0') { ?>
				<option value="0" selected="selected">Disabled</option><option value="1">Enabled</option></select></td>
				<?php }else{ ?>
				<option value="1" selected="selected">Enabled</option><option value="0">Disabled</option></select></td>
				<?php } ?>
				<td align="left" valign="top" class="form-desc">Display welcome message to guests above news.</td>
			</tr>
			<tr>
				<td align="right" valign="middle" class="form-text">Welcome Messsage:</td>
				<td width="15%" align="left" valign="middle">
				<input type="text" name="cfg__module_welcome_message" size="30" class="inputbox" value="<?php echo $cfg->get('module_welcome_message'); ?>" /></td>
				<td align="left" valign="top" class="form-desc">Welcome message displayed to guests. Requires Welcome message module enabled. Leave empty for generic.</td>
			</tr>
			<tr>
				<td align="right" valign="middle" class="form-text">Web Points Module:</td>
				<td width="15%" align="left" valign="middle">
				<select name="cfg__module_wp" class="inputbox">
				<?php if($cfg->get('module_wp') == '0') { ?>
				<option value="0" selected="selected">Disabled</option><option value="1">Enabled</option></select></td>
				<?php }else{ ?>
				<option value="1" selected="selected">Enabled</option><option value="0">Disabled</option></select></td>
				<?php } ?>
				<td align="left" valign="top" class="form-desc">Enabled Web Points system (<a href="http://keyswow.com/wiki/" />Learn More</a>).</td>
			</tr>
			<tr>
				<td align="right" valign="middle" class="form-text">Shop System:</td>
				<td width="15%" align="left" valign="middle">
				<select name="cfg__module_shop" class="inputbox">
				<?php if($cfg->get('module_shop') == '0') { ?>
				<option value="0" selected="selected">Disabled</option><option value="1">Enabled</option></select></td>
				<?php }else{ ?>
				<option value="1" selected="selected">Enabled</option><option value="0">Disabled</option></select></td>
				<?php } ?>
				<td align="left" valign="top" class="form-desc">Shop system for users to buy items via donations / Web points.</td>
			</tr>
			<tr>
				<td align="right" valign="middle" class="form-text">Character Rename:</td>
				<td width="15%" align="left" valign="middle">
				<select name="cfg__module_charrename" class="inputbox">
				<?php if($cfg->get('module_charrename') == '0') { ?>
				<option value="0" selected="selected">Disabled</option><option value="1">Enabled</option></select></td>
				<?php }else{ ?>
				<option value="1" selected="selected">Enabled</option><option value="0">Disabled</option></select></td>
				<?php } ?>
				<td align="left" valign="top" class="form-desc">Character rename module for users.</td>
			</tr>
			<tr>
				<td align="right" valign="middle" class="form-text">Char. Rename WP Cost:</td>
				<td width="15%" align="left" valign="middle">
				<input type="text" name="cfg__module_charrename_pts" size="2" class="inputbox" value="<?php echo $cfg->get('module_charrename_pts'); ?>" /></td>
				<td align="left" valign="top" class="form-desc">Cost in Web Points for users to rename their characters.</td>
			</tr>
			<tr>
				<td align="right" valign="middle" class="form-text">Char. Faction Change:</td>
				<td width="15%" align="left" valign="middle">
				<select name="cfg__module_charfactionchange" class="inputbox">
				<?php if($cfg->get('module_charfactionchange') == '0') { ?>
				<option value="0" selected="selected">Disabled</option><option value="1">Enabled</option></select></td>
				<?php }else{ ?>
				<option value="1" selected="selected">Enabled</option><option value="0">Disabled</option></select></td>
				<?php } ?>
				<td align="left" valign="top" class="form-desc">Character faction change module for users.</td>
			</tr>
			<tr>
				<td align="right" valign="middle" class="form-text">Char. Faction WP Cost:</td>
				<td width="15%" align="left" valign="middle">
				<input type="text" name="cfg__module_charfactionchange_pts" size="2" class="inputbox" value="<?php echo $cfg->get('module_charfactionchange_pts'); ?>" /></td>
				<td align="left" valign="top" class="form-desc">Cost in Web Points for users to change their characters factions.</td>
			</tr>
			<tr>
				<td align="right" valign="middle" class="form-text">Char. Race Change:</td>
				<td width="15%" align="left" valign="middle">
				<select name="cfg__module_charracechange" class="inputbox">
				<?php if($cfg->get('module_charracechange') == '0') { ?>
				<option value="0" selected="selected">Disabled</option><option value="1">Enabled</option></select></td>
				<?php }else{ ?>
				<option value="1" selected="selected">Enabled</option><option value="0">Disabled</option></select></td>
				<?php } ?>
				<td align="left" valign="top" class="form-desc">Character race change module for users.</td>
			</tr>
			<tr>
				<td align="right" valign="middle" class="form-text">Char. Race WP Cost:</td>
				<td width="15%" align="left" valign="middle">
				<input type="text" name="cfg__module_charracechange_pts" size="2" class="inputbox" value="<?php echo $cfg->get('module_charracechange_pts'); ?>" /></td>
				<td align="left" valign="top" class="form-desc">Cost in Web Points for users to change their characters race.</td>
			</tr>
		<!-- Email setting -->
			<tr>
				<td colspan="3" align="center" class="form-section-head"><u>Site Email Settings:</u></td>
			</tr>
			<tr>
				<td align="right" valign="middle" class="form-text">Email Type:</td>
				<td width="15%" align="left" valign="middle">
				<select name="cfg__email_type" class="inputbox">
				<?php if($cfg->get('email_type') == 0) { ?>
				<option value="0"  selected="selected">SMTP</option><option value="1">MIME</option><option value="2">MTA</option></select></td>
				<?php }elseif($cfg->get('email_type') == 1) { ?>
				<option value="0">SMTP</option><option value="1" selected="selected">MIME</option><option value="2">MTA</option></select></td>
				<?php }else{ ?>
				<option value="0">MIME</option><option value="1" selected="selected">SMTP</option><option value="2" selected="selected">MTA</option></select></td>
				<?php } ?>
				<td align="left" valign="top" class="form-desc">How do you want to relay your emails? (<a href="http://keyswow.com/wiki/" />Learn More</a>)</td>
			</tr>
			<tr>
				<td align="right" valign="middle" class="form-text">MTA - SMTP Host:</td>
				<td width="15%" align="left" valign="middle">
				<input type="text" name="cfg__email_smtp_host" size="30" class="inputbox" value="<?php echo $cfg->get('email_smtp_host'); ?>" /></td>
				<td align="left" valign="top" class="form-desc">SMTP host. ONLY IF USING MTA AS EMAIL TYPE.</td>
			</tr>
			<tr>
				<td align="right" valign="middle" class="form-text">MTA - SMTP Port:</td>
				<td width="15%" align="left" valign="middle">
				<input type="text" name="cfg__email_smtp_port" size="3" class="inputbox" value="<?php echo $cfg->get('email_smtp_port'); ?>" /></td>
				<td align="left" valign="top" class="form-desc">SMTP Port. ONLY IF USING MTA AS EMAIL TYPE.</td>
			</tr>
			<tr>
				<td align="right" valign="middle" class="form-text">MTA - Secure:</td>
				<td width="15%" align="left" valign="middle">
				<select name="cfg__email_use_secure" class="inputbox">
				<?php if($cfg->get('email_use_secure') == 0) { ?>
				<option value="0"  selected="selected">No</option><option value="1">Yes</option></select></td>
				<?php }elseif($cfg->get('email_use_secure') == 1) { ?>
				<option value="1" selected="selected">Yes</option><option value="0">No</option></select></td>
				<?php } ?>
				<td align="left" valign="top" class="form-desc">Use Secure Connection?</td>
			</tr>
			<tr>
				<td align="right" valign="middle" class="form-text">MTA - Secure Type:</td>
				<td width="15%" align="left" valign="middle">
				<select name="cfg__email_smtp_secure" class="inputbox">
				<?php if($cfg->get('email_smtp_secure') == '') { ?>
				<option value=""  selected="selected">None</option><option value="ssl">SSL</option><option value="tls">TLS</option></select></td>
				<?php }elseif($cfg->get('email_smtp_secure') == 'ssl') { ?>
				<option value="ssl" selected="selected">SSL</option><option value="tls">TLS</option><option value="">None</option></select></td>
				<?php }elseif($cfg->get('email_smtp_secure') == 'tls') { ?>
				<option value="ssl">SSL</option><option value="tls" selected="selected">TLS</option><option value="">None</option></select></td>
				<?php } ?>
				<td align="left" valign="top" class="form-desc">Secure connection type.</td>
			</tr>
			<tr>
				<td align="right" valign="middle" class="form-text">MTA - SMTP Username:</td>
				<td width="15%" align="left" valign="middle">
				<input type="text" name="cfg__email_smtp_user" size="30" class="inputbox" value="<?php echo $cfg->get('email_smtp_user'); ?>" /></td>
				<td align="left" valign="top" class="form-desc">SMTP Username. ONLY IF USING MTA AS EMAIL TYPE.</td>
			</tr>
			<tr>
				<td align="right" valign="middle" class="form-text">MTA - SMTP Pass:</td>
				<td width="15%" align="left" valign="middle">
				<input type="text" name="cfg__email_smtp_pass" size="30" class="inputbox" value="<?php echo $cfg->get('email_smtp_pass'); ?>" /></td>
				<td align="left" valign="top" class="form-desc">SMTP Password. ONLY IF USING MTA AS EMAIL TYPE.</td>
			</tr>
		<!-- Log Settings -->
			<tr>
				<td colspan="3" align="center" class="form-section-head"><u>Log Settings:</u></td>
			</tr>
			<tr>
				<td align="right" valign="middle" class="form-text">Log Admin Actions:</td>
				<td width="15%" align="left" valign="middle">
				<?php if($cfg->get('admin_log') == '0') { ?>
				<select name="cfg__admin_log" class="inputbox"><option value="0">No</option><option value="1">Yes</option></td>
				<?php }else{ ?>
				<select name="cfg__admin_log" class="inputbox"><option value="1">Yes</option><option value="0">No</option></td>
				<?php } ?>
				<td align="left" valign="top" class="form-desc">This will log all admin actions.</td>
			</tr>
			<tr>
				<td align="right" valign="middle" class="form-text">Admin Log Path:</td>
				<td width="15%" align="left" valign="middle">
				<input type="text" name="cfg__admin_log_path" size="30" class="inputbox" value="<?php echo $cfg->get('admin_log_path'); ?>" /></td>
				<td align="left" valign="top" class="form-desc">Where the admin log is saved</td>
			</tr>
			<tr>
				<td colspan="3" align="right" class="buttons">
					Confirm Process:&nbsp;<input type="checkbox" name="confirm" />&nbsp;&nbsp;
					<button name="process" class="button" type="submit"><b>Update</b></button>&nbsp;&nbsp;
					<button name="reset" class="button" type="reset">Cancel</button>
				</td>
			</tr>
		</table>
	</div>