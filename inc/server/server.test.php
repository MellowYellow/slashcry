<?php
//========================//
if(INCLUDED!==true) {
	  echo "Not Included!"; exit;
}
//=======================//
if($user['account_level'] < 2) {
 echo "<center><br />You do not have permision to view this page! 
			<a href='javascript: history.go(-1)'>Click Here</a> to go back</center>";
}
?>