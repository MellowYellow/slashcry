<div class="content-head">
	<div class="desc-title">Page Creater</div>
	<div class="description">
		<i>Description:</i> The page creater is a tool that you can use to easily setup new pages. Once the page is created, you will have to use the file manager 
		/ text editor to edit the page and add content to it.
	</div>
</div>
<div class="content" align="center">
<?php 
if(isset($_POST['add_page'])) {
	buildPage($_POST['page_title'], $_POST['page_ext'], $_POST['page_sub'], $_POST['page_level']);
} ?>
	<form method="POST" action="index.php?p=admin&sub=createpage" > 
	<input type="hidden" name="add_page" value="add" >
	<table width="95%" border="0" style="border: 2px solid #808080;">
		<tr>
			<td colspan="3" class="form-head">Create A New Page</td>
		</tr>
		<tr>
			<td width="20%" align="right" valign="middle" class="form-text">Page Title:</td>
			<td width="25%" align="left" valign="middle">
			<input type="text" name="page_title" size="30" class="inputbox" /></td>
			<td align="left" valign="top" class="form-desc">The title of your page.</td>
		</tr>
		<tr>
			<td width="20%" align="right" valign="middle" class="form-text">Page Extension:</td>
			<td width="25%" align="left" valign="middle">
			<input type="text" name="page_ext" size="30" class="inputbox" /></td>
			<td align="left" valign="top" class="form-desc">Extension (ie: "server", "vote", "account").</td>
		</tr>
		<tr>
			<td width="20%" align="right" valign="middle" class="form-text">Page Sub Extension:</td>
			<td width="25%" align="left" valign="top">
			<input type="text" name="page_sub" size="30" class="inputbox" value="index" /></td>
			<td align="left" valign="top" class="form-desc">The sub-ext is the "sub" you see in the address bar. It basically a sub catagory for the main extension.</td>
		</tr>
		<tr>
			<td width="20%" align="right" valign="middle" class="form-text">Viewing Level:</td>
			<td width="25%" align="left" valign="middle">
			<select name="page_level" class="inputbox" />
				<option value="1">Guest</option>
				<option value="2">Members</option>
				<option value="3">Admins</option>
				<option value="4">Super Admins</option>
			</select></td>
			<td align="left" valign="top" class="form-desc">What min. account level does the user need to view this page?</td>
		</tr>
		<tr>
			<td colspan="3" align="right" class="buttons">
				Confirm Process:&nbsp;<input type="checkbox" name="confirm" />&nbsp;&nbsp;
				<button name="process" class="button" type="submit"><b>Create Page</b></button>&nbsp;&nbsp;
			</td>
		</tr>
	</table>
	</form>
</div>