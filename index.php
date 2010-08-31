<?php
/****************************************************************************/
/*  < KeysCMS is a Web-Fonted for all WoW Emulators (http://keyswow.com) >  */
/*            	     Copyright (C) <2010>  <Wilson212>                      */
/*																			*/
/*                                                                          */
/*    This program is free software: you can redistribute it and/or modify  */
/*    it under the terms of the GNU General Public License as published by  */
/*    the Free Software Foundation, either version 2 of the License, or     */
/*    (at your option) any later version.                                   */
/*                                                                          */
/*    This program is distributed in the hope that it will be useful,       */
/*    but WITHOUT ANY WARRANTY; without even the implied warranty of        */
/*    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the         */
/*    GNU General Public License for more details.                          */
/*                                                                          */
/*    You should have received a copy of the GNU General Public License     */
/*    along with this program.  If not, see <http://www.gnu.org/licenses/>. */
/*                                                                          */
/****************************************************************************/

// Set error reporting to everything for now
ini_set('error_reporting', E_ERROR ^ E_NOTICE ^ E_WARNING);
error_reporting(E_ERROR ^ E_NOTICE ^ E_WARNING);
ini_set('log_errors',TRUE);
ini_set('html_errors',FALSE);
ini_set('error_log','core/logs/error_log.txt');
ini_set('display_errors',TRUE);

// First we check to see if the site is installed, if not, then define it
if(file_exists('config/config-protected.php')) {
	define( 'INSTALLED', TRUE );
}else{
	define( 'INSTALLED', FALSE );
	header('Location: install/index.php');
}

// Define INCLUDED so that we can check other pages if they are included by this file
define( 'INCLUDED', true ) ;

// Start a variable that shows how fast page loaded.
$time_start = microtime( 1 ) ;
$_SERVER['REQUEST_TIME'] = time() ;

// Load the config class
include('core/class.config.php');
$cfg = new Config;

// Fill in the config with the proper directory info if the directory info is wrong
$getbasehref = 'http://'.$_SERVER["HTTP_HOST"].''.dirname( $_SERVER["SCRIPT_NAME"] ).'/';
$getsitehref = ''.dirname( $_SERVER["SCRIPT_NAME"] ).'/';
if($cfg->get('base_href') != $getbasehref) {
	$cfg->set('base_href',''.$getbasehref.'');
	$cfg->set('site_href',''.$getsitehref.'');
	$cfg->Save();
}

// Site functions & classes ...
include ( 'core/core.php' ) ;					// Holds site version info's
include ( 'core/common.php' ) ; 				// Holds most of the sites functions
require_once ( 'core/dbsimple/Generic.php' ) ; 	// sets up DB simple
include ( 'core/class.auth.php' ) ; 			// contains account related scripts and functions

// Initialize Variables
global $cfg;

// Super-Global variables.
$GLOBALS['users_online'] = array() ;
$GLOBALS['guests_online'] = 0 ;
$GLOBALS['messages'] = '' ;		// For server messages
$GLOBALS['redirect'] = '' ;		// For the redirect function, uses <meta> tags

// Finds out what realm we are viewing. Sets cookie if need be.
if ( ( int )$cfg->get('default_realm_id') && isset( $_REQUEST['changerealm_to'] ) )
{
	setcookie( "cur_selected_realmd", intval( $_REQUEST['changerealm_to'] ), time() +
		( 3600 * 24 ) ) ; // expire in 24 hour
	$user['cur_selected_realmd'] = intval( $_REQUEST['changerealm_to'] ) ;
} elseif ( ( int )$cfg->get('multi_realm') && isset( $_COOKIE['cur_selected_realmd'] ) )
{
	$user['cur_selected_realmd'] = intval( $_COOKIE['cur_selected_realmd'] ) ;
} else
{
	$user['cur_selected_realmd'] = ( int )$cfg->get('default_realm_id') ;
	setcookie( "cur_selected_realmd", $user['cur_selected_realmd'], time() + ( 3600 *
		24 ) ) ;
}

// Setup the connections to other DB's - Holds DB connector classes
require ( 'core/class.database.php' );			

// Load auth system //
$auth = new AUTH($DB, $cfg);
$user = $auth->user;

// Sets up the template system.
if ( $user['id'] == -1 ) {
	$currtmp = "templates/".( string ) $cfg->get('default_template');
}else{
	$currtmp = $DB->selectCell( "SELECT theme FROM `account_extend` WHERE account_id=?d",
		$user['id'] ) ;
	$getalltmps = explode(",", $cfg->get('templates'));
	foreach ( $getalltmps as $template ) {
		$currtmp2[] = $template ;
	}
	$currtmp = "templates/" . $currtmp2[$currtmp] ;
	
	// If persons current template is no longer available, this resets his template to default
	if($currtmp == "templates/"){ 
		$currtmp = "templates/".( string ) $cfg->get('default_template');
		$DB->query( "UPDATE `account_extend` SET `theme`='0' WHERE `account_id`=?d",$user['id'] );
	}
}

// Start of page loading
$ext = ( isset( $_REQUEST['p'] ) ? $_REQUEST['p'] : ( string )$cfg->get('default_component') ) ;
if ( strpos( $ext, '/' ) !== false ) {
	list( $ext, $sub ) = explode( '/', $ext ) ;
}else{
	$sub = ( isset( $_REQUEST['sub'] ) ? $_REQUEST['sub'] : 'index' ) ;
}
	$script_file = 'inc/' . $ext . '/' . $ext . '.' . $sub . '.php' ;
	$template_file = '' . $currtmp . '/' . $ext . '/' . $ext . '.' . $sub . '.php' ;

// Start Loading of Template Files

	// If the requested page is the admin Panel
	if( $ext == 'admin') {
		if(file_exists('inc/admin/body_functions.php')) {
			include ('inc/admin/body_functions.php');
		}
		@include('inc/admin/script_files/admin.' . $sub .'.php');
		ob_start();
			include('inc/admin/body_header.php');
		ob_end_flush();
		ob_start();
			include('inc/admin/template_files/admin.' . $sub .'.php');
		ob_end_flush();
		
		// Set our time end, so we can see how fast the page loaded.
		$time_end = microtime( 1 ) ;
		$exec_time = $time_end - $time_start ;
		include('inc/admin/body_footer.php');
	}else{
	// Else, it requested page isnt the admin panel		
	// Start Loading Of Script Files
		@include ( $script_file ) ;
	
		// If a body functions file exists, include it.
		if(file_exists(''. $currtmp . '/body_functions.php')) {
			include ( ''. $currtmp . '/body_functions.php' );
		}
		ob_start() ;
			include ( '' . $currtmp . '/body_header.php' );
		ob_end_flush() ;
		ob_start() ;
			include ( $template_file ) ;
		ob_end_flush() ;
	
		// Set our time end, so we can see how fast the page loaded.
		$time_end = microtime( 1 ) ;
		$exec_time = $time_end - $time_start ;
		include ( '' . $currtmp . '/body_footer.php' ) ;
	}
?>