<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $cfg->get('site_title'); if(isset( $_GET['p'] )) { echo " :: ".$_GET['p']; } ?></title>
<link href="<?php echo $currtmp ."/css/main.css" ?>" rel="stylesheet" type="text/css" />
<!--[if IE]>
<style type="text/css"> 
button.form-button span { 
 padding-bottom: 2px;
}
</style>
<![endif]-->
</head>

<body class="twoColElsLtHdr">
  <!-- Start Of Header. Coded from Molten-WoW.com -->
<div style="position: relative; width: 100%; height: 200px; z-index: 0; margin-top: -12px;">
	<div class="nav">
		<div class="nav_holder">
			<div class="nav_container"></div>
				<div style="width:1115px; height:200px; position:absolute; left:-557px;">
					<div class="nav_int">
					<a class="logo" href="index.php"></a>
					<div class="menu">
                        <a class="account" href="index.php?p=account"></a>
                        <a class="forum" href="<?php echo $cfg->get('site_forums'); ?>"></a>
						<a class="armory" href="<?php echo $cfg->get('site_armory'); ?>"></a>
						<a class="shop" href="index.php?p=shop"></a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- end #header --></div>
  
<div id="container">
	<div id="sidebar1">
	<div id="navtitle">Navigation</div>
	<div class="sdmenu">
		<ul>
			<li><a class="button3" href="index.php"><b><span>Home</span></b></a></li>
			<li><a class="button3" href="<?php echo $cfg->get('site_forums'); ?>"><b><span>Forum</span></b></a></li>	
			<li><a class="button3" href="<?php echo $cfg->get('site_armory'); ?>"><b><span>Armory</span></b></a></li>
			<li><a class="button3" href="#"><b><span>Realm Status</span></b></a></li>			
			<li><a class="button3" href="index.php?p=vote"><b><span>Vote</span></b></a></li>
			<li><a class="button3" href="index.php?p=shop"><b><span>Shop</span></b></a></li>
		</ul>
	</div>
  
  <!-- end #sidebar1 --></div>
  <div id="sidebar2">
  <div id="sidebartitle">Account Info</div>
  <?php if($user['id'] == "-1") {
	  echo "<center><br />Welcome Guest";
	?>
	<br /><br />
	<form action="index.php?p=account&sub=login" method="post">
		<center><button name="Login" type="submit" class="form-button" value="Login" ><span>Login</span></button></center>
	</form>
	<form action="index.php?p=account&sub=register" method="post">
		<center><button name="register" type="submit" class="form-button" value="Register"><span>Register</span></button></center>
	</form>
	</center>
  <?php
  }else{
	  echo "<center><br />Welcome Back!<br /> <b>".$user['username'] ."</b>";
	  $myprofile = $auth->getprofile($user['id']);
	  $date_f = date("m/j/Y, g:i a", $myprofile['last_visit']);
	  echo "<br /><br />Account Level:<br />".$myprofile['title'];
	  echo "<br /><br />Web Points:<font color='#C77B00'> <u>".$myprofile['web_points']."</u></font></center><br />";
	if($user['account_level'] >= 3) {
	?>
	<form action="index.php?p=admin" method="post">
		<center><button name="Admin Panel" type="submit" class="form-button" value="Admin Panel" ><span>Admin Panel</span></button></center>
	</form>
	<?php } ?>
	<form action="index.php?p=account" method="post">
		<center><button name="Account Manage" type="submit" class="form-button" value="Manage Account" ><span>Manage Account</span></button></center>
	</form>
	<form action="index.php?p=account&sub=login" method="post">
		<input type="hidden" name="action" value="logout" >
		<center><button type="submit" name="Logout" class="form-button"><span>Logout</span></button></center>
	</form>
	<?php
  }
  ?>
  <!-- end Sidebar2 --></div>
  <!-- Start Of Main Content -->
  <div id="mainContent">
  <br />
  <!-- Begin scripts and templates -->