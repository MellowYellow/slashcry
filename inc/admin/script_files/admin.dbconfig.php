<?php
//========================//
if(INCLUDED!==true) {
	echo "Not Included!"; exit;
}
//=======================//
function saveConfig($dbtype,$dbip,$dbport,$dbuser,$dbpass,$dbname) {
		$conffile = "config/config-protected.php";
        $build = '';
        $build .= "<?php\n";
        $build .= "\$db = array(\n";
        $build .= "'db_type'         => '".$dbtype."',\n";
        $build .= "'db_host'         => '".$dbip."',\n";
        $build .= "'db_port'         => '".$dbport."',\n";
        $build .= "'db_username'     => '".$dbuser."',\n";
        $build .= "'db_password'     => '".$dbpass."',\n";
        $build .= "'db_name'         => '".$dbname."',\n";
        $build .= "'db_encoding'     => 'utf8',\n";
        $build .= ");\n";
		$build .= "?>";
		
	if (is_writeable($conffile)){
        $openconf = fopen($conffile, 'w+');
        fwrite($openconf, $build);
        fclose($openconf);
		output_message('notice','Success! Config successfully updated.');
	}else{ 
		output_message('alert','Couldn\'t open main-config.php for editing, it must be writable by webserver! <br /><a href="javascript: history.go(-1)">Go back, and try again.</a>');
	}
}
?>