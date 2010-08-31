<?php
// Config Handling class
class Config {
	
	var $data = array();
	var $configFile = 'config/config.php';	//Default Config File
	var $path_protectedconf = "config/config-protected.php";
	
	function Config() {
		$this->Load();
	}
	function Load() {
		if ( file_exists($this->configFile ) ) {
			include ( $this->configFile );
			$vars = get_defined_vars();
			foreach ( $vars as $key => $val ) {
				if ($key != 'this' && $key != 'data') {
					$this->data[$key] = $val;
				}
			}
			return true;
		} else {
			return false;
		}
	}
	function get( $key ) {
		if (isset($this->data[ $key ])) {
			return $this->data[ $key ];
		}
	}
	function getDbInfo( $key ) {
		include($this->path_protectedconf);
		return $db[ $key ];
	}
	function set( $key, $val ) {
		$this->data[ $key ] = $val;
	}
	function Save() {
		$cfg  = "<?php\n";
		foreach ( $this->data as $key => $val ) {
			if (is_numeric($val)) {
				$cfg .= "\$$key = " . $val . ";\n";
			} else {
				$cfg .= "\$$key = '" . addslashes( $val ) . "';\n";
			}
		}
		$cfg .= "?>";
		
		@copy( $this->configFile, $this->configFile.'.bak' );
		if (phpversion() < 5) {
			$file = @fopen($this->configFile, 'w');
			if ($file === false) {
				return false;
			} else {
				@fwrite($file, $cfg);
				@fclose($file);
				return true;
			}
		} else {
			if (@file_put_contents( $this->configFile, $cfg )) {
				return true;
			} else {
				return false;
			}
		}
	}
}
?>