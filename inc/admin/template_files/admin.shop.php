<div class="content-head">
	<div class="desc-title">Manage Shop Items</div>
	<div class="description">
		<i>Description:</i> Add / Remove / Edit shop items for your server.
	</div>
</div>
<?php
if(isset($_GET['id'])) {
	showItem($_GET['id']);
}elseif(isset($_GET['action'])) {
	if($_GET['action'] == 'add') {
		showAddForm();
	}
}else{
?>
<div class="content" align="center">
	<table width="95%" border="0" style="border: 2px solid #808080;">
		<tr>
			<td colspan="7" class="form-head">Shop Item List</td>
		</tr>
		<tr>
			<td align="center" colspan="7"><a href="index.php?p=admin&sub=shop&action=add" /><b>.:Add Items:.</b></a></td>
		</tr>
		<tr>
			<td width="5%" align="center" class="header"><b>Id</b></td>
			<td width="35%" align="center" class="header"><b>Item Name / Itemset</b></td>
			<td width="10%" align="center" class="header"><b>Qty.</b></td>
			<td width="10%" align="center" class="header"><b>WP's</b></td>
			<td width="16%" align="center" class="header"><b>Donation</b></td>
			<td width="10%" align="center" class="header"><b>Realms</b></td>
			<td width="12%" align="center" class="header"><b>Action</b></td>
		</tr>
		<?php foreach($getitems as $row) { ?>
			<tr class="content">
				<td align="center"><?php echo $row['id']; ?></td>
				<?php if($row['item_number'] == 0) { ?>
				<td align="center">
				<?php 
					if($row['itemset'] != 0) { echo "<a href='http://www.wowhead.com/?itemset=".$row['itemset']."' target='_blank'>ItemSet # ".$row['itemset']."</a>"; }
					if($row['gold'] != 0) { echo "<br />Gold: "; print_gold($row['gold']); }
				?>
				</td>
				<?php }else{ ?>
				<td align="center"><a href="index.php?p=admin&sub=shop&id=<?php echo $row['id']; ?>">
				<?php $item_name = $WDB->selectCell("SELECT `name` FROM `item_template` WHERE entry=?d", $row['item_number']);
					  if(!$item_name) { echo "<font color='red'> INVALID ITEM ID!</font>"; 
					  }else{ echo "<a href='http://www.wowhead.com/?item=".$row['item_number']."' target='_blank'>".$item_name."</a>"; }
					  if($row['itemset'] != 0) { echo "<br /><a href='http://www.wowhead.com/?itemset=".$row['itemset']."' target='_blank'>ItemSet # ".$row['itemset']."</a>"; }
					  if($row['gold'] != 0) { echo "<br />Gold: "; print_gold($row['gold']); }
				?>
				</a></td>
				<?php } ?>
				<td align="center"><?php echo $row['quanity']; ?></td>
				<td align="center"><?php echo $row['wp_cost']; ?></td>
				<td align="center">$<?php echo $row['donation_cost']; ?></td>
				<td align="center"><?php if ($row['realms'] == 0) { echo "All"; }else{ echo $row['realms']; } ?></td>
				<td align="center"><a href="index.php?p=admin&sub=shop&id=<?php echo $row['id']; ?>">Edit / Del</a></td>
			</tr>
		<?php } ?>		
		<tr>
			<td colspan="7" align="right" class="form-pagenav">
			<?php
			// Display Page Links (Not written by me! :p )
			if($page != 1) { 
			       $pageprev = $page-1;
				echo("<a href=\"index.php?p=admin&sub=shop&page=".$pageprev."\">&lt;&lt; PREV</a> ");  
			}else{
				echo("&lt;&lt;PREV ");
			}
			$numofpages = $totalrows / $limit; 
			for($j = 1; $j <= $numofpages; $j++){
				if($j == $page){
					echo($j." ");
				}else{
					echo("<a href=\"index.php?p=admin&sub=shop&page=".$j."\">$j</a> "); 
				}
			}
			if(($totalrows % $limit) != 0){
		        if($j == $page){
					echo($j." ");
				}else{
					echo("<a href=\"index.php?p=admin&sub=shop&page=".$j."\">$j</a> ");
				}
			}	
			if(($totalrows - ($limit * $page)) > 0){
				$pagenext   = $page + 1;
			    echo("<a href=\"index.php?p=admin&sub=shop&page=".$pagenext."\">NEXT &gt;&gt;</a>");
			}else{
				echo("NEXT &gt;&gt;"); 
			} ?>
			</td>
		</tr>
	</table>
</div>
<?php } ?>