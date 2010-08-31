<div id="Contenthdr">Account Login</div>
<div id="Content">
<?php
if($user['id']<=0){
?>
      <table align="center" width="100%"><tr><td align="center" width="100%">
      <form method="post" action="index.php?p=account&sub=login">
            <input type="hidden" name="action" value="login">
        <div style="border:background:none;margin:1px;padding:6px 9px 6px 9px;text-align:center;width:70%;">
          <b>Username: </b> <input type="text" size="26" style="font-size:11px;" name="login">
        </div>
        <div style="border:background:none;margin:1px;padding:6px 9px 6px 9px;text-align:center;width:70%;">
          <b>Password: </b> <input type="password" size="26" style="font-size:11px;" name="pass">
        </div>
        <div style="background:none;margin:1px;padding:6px 9px 0px 9px;text-align:center;width:70%;">
          <button type="submit" class="form-button" value="Login"><span>Login</span></button>
        </div>
      </form>
        </td></tr></table>
<?php
}else{
    echo "<br /><br /><center><b>Welcome ".$user['username']."</b><br />You are now logged in.</center><br /><br />";
}
?>
</div>