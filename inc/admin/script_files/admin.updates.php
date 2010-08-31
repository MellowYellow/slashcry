<?php
//========================//
if(INCLUDED!==true) {
	echo "Not Included!"; exit;
}
//=======================//

function getContents() {
	$updates = file_get_contents('http://www.keyswow.com/downloads/updates/keyscms.txt');
	if(!$updates) {
		output_message('alert', 'Error connecting to update server!');
	}else{
		return $updates;
	}
}

// Thanks to Nerix for helping my out and see his update scripts!
function runUpdates($up) {
	$getzip = file_get_contents('http://www.keyswow.com/downloads/updates/update_'.$up.'.zip');
	if(!$getzip) { 
		output_message('alert', 'Failed to get update!'); 
	}else{
		$createzip = fopen('update_tmp.zip', 'w+');
		$save = fwrite($createzip,$getzip);
		$zip = new ZipArchive;
		if ($zip->open('update_tmp.zip') === TRUE) {
			$zip->extractTo('');
			$zip->close();
			@unlink('update_tmp.zip');
			output_message('notice', 'Update Successful!');
		}else{
			output_message('alert', 'Failed to update site!');
			@unlink('update_tmp.zip');
		}
	}
}
?>