<?php
//========================//
if(INCLUDED!==true) {
	echo "Not Included!"; exit;
}
//=======================//
if($_REQUEST['action']=='login'){
  $login = $_REQUEST['login'];
  $pass = sha_password($login,$_REQUEST['pass']);
  if($auth->login(array('username'=>$login,'sha_pass_hash'=>$pass)))
  {
    redirect($_SERVER['HTTP_REFERER'],1);
  }
}elseif($_REQUEST['action']=='logout'){
  $auth->logout();
  redirect($_SERVER['HTTP_REFERER'],1);
}
?>