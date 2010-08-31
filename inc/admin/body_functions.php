<?php
/*
function apacheversion() {
    $ver = split("[/ ]",$_SERVER['SERVER_SOFTWARE']);
    $apver = "$ver[1] $ver[2]";
    return $apver;
}
function modsslversion() {
    $ver = split("[/ ]",$_SERVER['SERVER_SOFTWARE']);
    $msver = "$ver[6]";
    return $msver;
}
function opensslversion() {
    $ver = split("[/ ]",$_SERVER['SERVER_SOFTWARE']);
    $openssl = "$ver[8]";
    return $openssl;
}
*/
function server_display_info()
{
	global $cfg;
	if(ini_get('allow_url_fopen') == '1') { $allowfopen = "<font color='green'>Yes</font>"; }else{ $allowfopen = "<font color='red'>No!</red>"; }
?>
<div class="main-menu">
<center><b><u>Server Info</u></b></center></div><br />
	<ul class="sub-menu">
		<li>
		<?php 
			//Echo "<b>Apache Version</b><br />".apacheversion()."<br /><br />\n";
			Echo "<b>PHP Version</b> <br />".phpversion()."<br /><br />\n";
			//Echo "<b>mod_ssl Version</b> <br />".modsslversion()."<br /><br />\n";
			//Echo "<b>OpenSSL Version</b> <br />".opensslversion()."<br /><br />\n";
			Echo "<b>MySQL Server Version</b> <br />". mysql_get_server_info() ."</pre></font>";
			Echo "<br /><br /><b>Allow Fopen</b><br />". $allowfopen;
		?>
		</li>
	</ul>
<?php } 
// Write Log Message to File
function writeLog($msg) {
	global $cfg;
	$outmsg = date('Y-m-d H:i:s')." : ".$msg."<br />\n";
	
	if ($cfg->get('admin_log') == '1') {
		$file = @fopen($cfg->get('admin_log_path'), 'a');
		@fwrite($file, $outmsg);
		@fclose($file);
	}
	
	flush();
	if (ini_get('zlib.output_compression') != 0) { ob_flush(); }
}
?>