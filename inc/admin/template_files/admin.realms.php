<?php
if(isset($_GET['id'])) {
	showRealm($_GET['id']);
}else{
?>
<div class="content-head">
	<div class="desc-title">Manage Realms</div>
	<div class="description">
		<i>Description:</i> Add / Remove / Edit realms for your server.
	</div>
</div>
<div class="content" align="center">
	<table width="95%" border="0" style="border: 2px solid #808080;">
		<tr>
			<td colspan="6" class="form-head">Realm List</td>
		</tr>
		<tr>
			<td width="5%" align="center" class="header"><b>Id</b></td>
			<td width="30%" align="center" class="header"><b>Name</b></td>
			<td width="20%" align="center" class="header"><b>Address</b></td>
			<td width="10%" align="center" class="header"><b>Port</b></td>
			<td width="15%" align="center" class="header"><b>Type</b></td>
			<td width="20%" align="center" class="header"><b>Timezone</b></td>
		</tr>
		<?php foreach($getrealms as $row) { ?>
		<tr class="content">
			<td align="center"><?php echo $row['id']; ?></td>
			<td align="center"><a href="index.php?p=admin&sub=realms&id=<?php echo $row['id']; ?>"><?php echo $row['name']; ?></a></td>
			<td align="center"><?php echo $row['address']; ?></td>
			<td align="center"><?php echo $row['port']; ?></td>
			<td align="center"><?php echo $realm_type_def[$row['icon']]; ?></td>
			<td align="center"><?php echo $realm_timezone_def[$row['timezone']]; ?></td>
		</tr>
		<?php } ?>
	</table>
</div>
<?php } ?>