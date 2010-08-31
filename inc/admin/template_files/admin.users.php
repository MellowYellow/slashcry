<?php 
if(isset($_GET['id'])){
	if($_GET['id'] > 0) {
		$gid = $_GET['id'];
		if(isset($_GET['action'])) 	{
			if($_GET['action'] == 'ban') {
				showBanForm($gid);
			}elseif($_GET['action'] == 'unban') {
				unBan($gid);
			}elseif($_GET['action'] == 'delete') {
				deleteUser($gid);
			}else{
				echo "Invalid Action";
			}
		}else{
			showUser($gid);
		}
	}else{
		echo "Invalid Request";
	}
}else{ ?>
<div class="content-head">
		<div class="desc-title">Manage Users</div>
		<div class="description">
		<i>Description:</i> This option displays this list of User accounts on your server.
		</div>
	</div>
	<div class="content" align="center">
		<form method="POST" action="index.php?p=admin&sub=users" name="adminform">
		<table width="95%" border="0" style="border: 2px solid #808080;">
			<tr>
				<td colspan="4" class="form-head">User List</td>
			</tr>
			<tr>
				<td colspan="4" align="right">
					<small>
					<a href="index.php?p=admin&sub=users">All</a> | 
					<a href="index.php?p=admin&sub=users&char=1">#</a> 
					<a href="index.php?p=admin&sub=users&char=a">A</a> 
					<a href="index.php?p=admin&sub=users&char=b">B</a> 
					<a href="index.php?p=admin&sub=users&char=c">C</a> 
					<a href="index.php?p=admin&sub=users&char=d">D</a> 
					<a href="index.php?p=admin&sub=users&char=e">E</a> 
					<a href="index.php?p=admin&sub=users&char=f">F</a> 
					<a href="index.php?p=admin&sub=users&char=g">G</a> 
					<a href="index.php?p=admin&sub=users&char=h">H</a> 
					<a href="index.php?p=admin&sub=users&char=i">I</a> 
					<a href="index.php?p=admin&sub=users&char=j">J</a> 
					<a href="index.php?p=admin&sub=users&char=k">K</a> 
					<a href="index.php?p=admin&sub=users&char=l">L</a> 
					<a href="index.php?p=admin&sub=users&char=m">M</a> 
					<a href="index.php?p=admin&sub=users&char=n">N</a> 
					<a href="index.php?p=admin&sub=users&char=o">O</a> 
					<a href="index.php?p=admin&sub=users&char=p">P</a> 
					<a href="index.php?p=admin&sub=users&char=q">Q</a> 
					<a href="index.php?p=admin&sub=users&char=r">R</a> 
					<a href="index.php?p=admin&sub=users&char=s">S</a> 
					<a href="index.php?p=admin&sub=users&char=t">T</a> 
					<a href="index.php?p=admin&sub=users&char=u">U</a> 
					<a href="index.php?p=admin&sub=users&char=v">V</a> 
					<a href="index.php?p=admin&sub=users&char=w">W</a> 
					<a href="index.php?p=admin&sub=users&char=x">X</a> 
					<a href="index.php?p=admin&sub=users&char=y">Y</a> 
					<a href="index.php?p=admin&sub=users&char=z">Z</a>              
					</small>           
				</td>
			</tr>
			<tr>
				<td width="120" align="center" class="header"><b>UserName</b></td>
				<td width="140" align="center" class="header"><b>Email</b></td>
				<td width="120" align="center" class="header"><b>Registration Date</b></td>
				<td width="40" align="center" class="header"><b>Active/Ban</b></td>
			</tr>
			<?php
			foreach($getusers as $row) { 
			?>
			<tr class="content">
				<td align="center"><a href="index.php?p=admin&sub=users&id=<?php echo $row['id']; ?>"><?php echo $row['username']; ?></a></td>
				<td align="center"><?php echo $row['email']; ?></td>
				<td align="center"><?php echo $row['joindate']; ?></td>
				<td align="center"><?php echo $row['locked']; ?></td>
			</tr><?php } ?>
		<tr>
				<td colspan="4" align="right" class="form-pagenav">
				<?php
				// Display Page Links (Not written by me! :p )
				if($page != 1) { 
			        $pageprev = $page-1;
					echo("<a href=\"index.php?p=admin&sub=users&page=".$pageprev."\">&lt;&lt; PREV</a> ");  
				}else{
					echo("&lt;&lt;PREV ");
				}
				$numofpages = $totalrows / $limit; 
				for($j = 1; $j <= $numofpages; $j++){
					if($j == $page){
						echo($j." ");
					}else{
						echo("<a href=\"index.php?p=admin&sub=users&page=".$j."\">$j</a> "); 
					}
				}
				if(($totalrows % $limit) != 0){
		            if($j == $page){
						echo($j." ");
					}else{
						echo("<a href=\"index.php?p=admin&sub=users&page=".$j."\">$j</a> ");
					}
				}	
				if(($totalrows - ($limit * $page)) > 0){
					$pagenext   = $page + 1;
			        echo("<a href=\"index.php?p=admin&sub=users&page=".$pagenext."\">NEXT &gt;&gt;</a>");
				}else{
					echo("NEXT &gt;&gt;"); 
				} ?>
				</td>
			</tr>
		</table>
		</form>
	</div>
<?php } ?>