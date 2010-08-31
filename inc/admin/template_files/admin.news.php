<div class="content-head">
	<div class="desc-title">Manage Frontpage News</div>
	<div class="description">
	<i>Description:</i> Add / Edit / Delete the news that displays on the frontpage.
	</div>
</div>
<div class="content">
<?php
if(isset($_GET['action'])) {
	if($_GET['action'] == 'add'){ 
		if(isset($_POST['subject'])) {
			addNews($_POST['subject'],$_POST['message'],$user['username']);
		}
?>
		<form method="POST" action="index.php?p=admin&sub=news&action=add" onSubmit="return configvalidation(this);">
		<input type="hidden" name="task" value="addnews">
		
		<table align="center" border="0" width="65%" style="border: 2px solid #808080;">
			<tr>
				<td colspan="3" class="form-head">Add News</td>
			</tr>
			<tr>
				<td width="10%" align="right" valign="middle" class="form-text">Subject:</td>
				<td width="20%" align="left" valign="middle">
				<input type="text" name="subject" size="40" class="inputbox" /></td>
				<td align="left" valign="top" class="form-desc">// News title.</td>
			</tr>
			<tr>
				<td colspan="3" align="center" valign="top">
				<textarea name="message" rows="15" cols="85" class="inputbox"></textarea>
				</td>
			</tr>
			<tr>
				<td colspan="3" align="right" class="form-text2">
					Confirm Process:&nbsp;<input type="checkbox" name="confirm" />&nbsp;&nbsp;
					<button name="process" class="button" type="submit"><b>Submit</b></button>&nbsp;&nbsp;
					<button name="reset" class="button" type="reset">Cancel</button>
				</td>
			</tr>
		</table>
		</form>

<?php 
	// Otherwise, editing
	}elseif($_GET['action'] == 'edit'){ 
		if(isset($_GET['id'])) {
			$loading = $DB->select("SELECT * FROM `site_news` WHERE `id`=?d",$_GET['id']);
			foreach($loading as $content) {
			}
		if(isset($_POST['delete'])) {
			delNews($_POST['id']);
		}elseif(isset($_POST['editmessage'])) {
			editNews($_POST['id'],$_POST['editmessage']);
		}
?>
		<form method="POST" action="index.php?p=admin&sub=news&action=edit&id=<?php echo $_GET['id']; ?>" onSubmit="return configvalidation(this);">
		<input type="hidden" name="task" value="editnews">
		<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
		
		<table align="center" border="0" width="65%" style="border: 2px solid #808080;">
			<tr>
				<td colspan="3" class="form-head">Edit News</td>
			</tr>
			<tr>
				<td width="10%" align="right" valign="middle" class="form-text">Subject:</td>
				<td width="20%" align="left" valign="middle">
				<input type="text" name="subject" size="40" class="inputbox" disabled="disabled" value="<?php echo $content['title']; ?>" /></td>
				<td align="left" valign="top" class="form-desc">// News title.</td>
			</tr>
			<tr>
				<td colspan="3" align="center" valign="top">
				<textarea name="editmessage" rows="15" cols="85" class="inputbox"><?php echo $content['message']; ?></textarea>
				</td>
			</tr>
			<tr>
				<td colspan="3" align="right" class="form-text2">
					<button name="process" class="button" type="submit"><b>Submit</b></button>&nbsp;&nbsp;
					<button name="reset" class="button" type="reset">Cancel</button>&nbsp;&nbsp;
					<button name="delete" type="submit" value="DELETE THIS NEWS TOPIC" class="button"><b>DELETE This News Topic</b></button>
				</td>
			</tr>
		</table>
		</form>
<?php 
		}else{ ?>		
			<b><u><center>No Id Specified!</center></u></b><br /><br />

	<?php	}
	}else{ ?>
You arent suppossed to be here :p
<?php 
	} 
}else{
?>
	<div class="content" align="center">
		<table width="90%" align="center" border="0" style="border: 2px solid #808080;">
			<tr>
				<td colspan="3" class="form-head">News List</td>
			</tr>
			<tr>
				<td align="center" colspan="3"><a href="index.php?p=admin&sub=news&action=add" /><b>.:Add News:.</b></a></td>
			</tr>
			<tr>
				<td width="160" align="center" class="header"><b>News Title</b></td>
				<td width="100" align="center" class="header"><b>Posted By</b></td>
				<td width="100" align="center" class="header"><b>Posted Date</b></td>
			</tr>
			<?php
			foreach($gettopics as $row) {
				$date_n = date("Y-m-d, g:i a", $row['post_time']);
			?>
			<tr class="content"'>
				<td align="center"><a href="index.php?p=admin&sub=news&action=edit&id=<?php echo $row['id']; ?>"><?php echo $row['title']; ?></a></td>
				<td align="center"><?php echo $row['posted_by']; ?></td>
				<td align="center"><?php echo $date_n; ?></td>
			</tr><?php } ?>
		</table>
	</div>
<?php }
?>
</div>