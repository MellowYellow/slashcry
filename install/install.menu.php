<div class="main-menu">
		<b>Server Info:</b></div>
	<ul class="sub-menu">
		<li>
		<?php
		$ar = split("[/ ]",$_SERVER['SERVER_SOFTWARE']);
		for ($i=0;$i<(count($ar));$i++)
		{
		switch(strtoupper($ar[$i]))
		{
		case 'APACHE':
		$i++;
		$Apache_Version = $ar[$i];
		break;
		case 'PHP':
		$i++;
		$PHP_Version = $ar[$i];
		break;
		case 'MOD_SSL':
		$i++;
		$MOD_SSL_Version = $ar[$i];
		break;
		case 'OPENSSL':
		$i++;
		$OPENSSL_Version = $ar[$i];
		break;
		}
		}

		Echo "Apache Version:<br /> $Apache_Version<br /><br />\n";
		Echo "PHP Version: <br />$PHP_Version<br /><br />\n";
		Echo "mod_ssl Version: <br /> $MOD_SSL_Version<br /><br />\n";
		Echo "OpenSSL Version: <br />$OPENSSL_Version<br /><br />\n";
		?>
		</li>
		</ul>