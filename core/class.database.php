<?php

// Set up a connector to the site DB
//$cxn = mysql_connect("".$cfg->getDbInfo('db_host').":".$cfg->getDbInfo('db_port')."","".$cfg->getDbInfo('db_username')."","".$cfg->getDbInfo('db_password')."")
	//or die ("Couldn't Connect To Server!");
	
// DBSimple stuff. Set up all the connections to wach DB
$DB = dbsimple_Generic::connect( "" . $cfg->getDbInfo('db_type') . "://" . $cfg->getDbInfo('db_username') .
	":" . $cfg->getDbInfo('db_password') . "@" . $cfg->getDbInfo('db_host') . ":" . $cfg->getDbInfo('db_port') .
	"/" . $cfg->getDbInfo('db_name') . "" ) ;
// Set error handler for $DB.
$DB->setErrorHandler( 'databaseErrorHandler' ) ;
// Also set to default encoding for $DB
$DB->query( "SET NAMES " . $cfg->getDbInfo('db_encoding') ) ;

// Make an array from `dbinfo` column for the selected realm..
$mangos_info = $DB->selectCell( "SELECT dbinfo FROM `realmlist` WHERE id=?", $user['cur_selected_realmd'] ) ;
$dbinfo_mangos = explode( ';', $mangos_info ) ;

//DBinfo column:  username;password;port;host;WorldDBname;CharDBname
$mangos = array( 'db_type' => 'mysql', 'db_host' => $dbinfo_mangos['3'],
	'db_port' => $dbinfo_mangos['2'], //port
	'db_username' => $dbinfo_mangos['0'], //world user
	'db_password' => $dbinfo_mangos['1'], //world password
	'db_name' => $dbinfo_mangos['4'], //world db name
	'db_char' => $dbinfo_mangos['5'], //character db name
	'db_encoding' => 'utf8', // don't change
	) ;
// Free up memory.
unset( $dbinfo_mangos, $mangos_info ) ; 

// Connects to WORLD DB
$WDB = DbSimple_Generic::connect( "" . $mangos['db_type'] . "://" . $mangos['db_username'] .
	":" . $mangos['db_password'] . "@" . $mangos['db_host'] . ":" . $mangos['db_port'] .
	"/" . $mangos['db_name'] . "" ) ;
if ( $WDB )
	$WDB->setErrorHandler( 'databaseErrorHandler' ) ;
if ( $WDB )
	$WDB->query( "SET NAMES " . $mangos['db_encoding'] ) ;

// Connects to CHARACTERS DB
$CDB = DbSimple_Generic::connect( "" . $mangos['db_type'] . "://" . $mangos['db_username'] .
	":" . $mangos['db_password'] . "@" . $mangos['db_host'] . ":" . $mangos['db_port'] .
	"/" . $mangos['db_char'] . "" ) ;
if ( $CDB )
	$CDB->setErrorHandler( 'databaseErrorHandler' ) ;
if ( $CDB )
	$CDB->query( "SET NAMES " . $mangos['db_encoding'] ) ;
?>