<div class="content-head">
	<div class="desc-title">Site Email System</div>
	<div class="description">
	<i>Description:</i> Here you can send emails to specific users, or all of them :)
	</div>
</div>
<?php if(isset($_POST['send_email'])) {
		send_email($_POST['reciever'],'wilson212',$_POST['subject'],$_POST['message']);
	}
?>
<div class="content">
<form method="POST" action="index.php?p=admin&sub=email">
		<input type="hidden" name="send_email">
		
		<table align="center" border="0" width="65%" style="border: 2px solid #808080;">
			<tr>
				<td colspan="3" class="form-head">Send Email</td>
			</tr>
			<tr>
				<td width="10%" align="right" valign="middle" class="form-text">Send to:</td>
				<td width="20%" align="left" valign="middle">
				<input type="text" name="reciever" size="40" class="inputbox" /></td>
				<td align="left" valign="top" class="form-desc">// Recieveing Email. Seperate multiple emails with a comma (",")</td>
			</tr>
			<tr>
				<td width="10%" align="right" valign="middle" class="form-text">Subject:</td>
				<td width="20%" align="left" valign="middle">
				<input type="text" name="subject" size="40" class="inputbox" /></td>
				<td align="left" valign="top" class="form-desc">// Email's Subject</td>
			</tr>
			<tr>
				<td colspan="3" align="center" valign="top">
				<textarea name="message" rows="15" cols="85" class="inputbox"></textarea>
				</td>
			</tr>
			<tr>
				<td colspan="3" align="right" class="form-text2">
					<button name="process" class="button" type="submit"><b>Send Email</b></button>&nbsp;&nbsp;
					<button name="reset" class="button" type="reset">Cancel</button>
				</td>
			</tr>
		</table>
	</form>
</div>