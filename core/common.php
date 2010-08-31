<?php
/*********************************************************************************/
/*	   KeysCMS Common site functions and variables Some taken from MangosWeb     */
/*********************************************************************************/

//======= SITE VARIABLES =======//

// Define realm types
$realm_type_def = array(
    0 => 'Normal',
    1 => 'PVP',
    4 => 'Normal',
    6 => 'RP',
    8 => 'RPPVP',
    16 => 'FFA_PVP'
);

// Define realm timezones
$realm_timezone_def = array(
     0 => 'Unknown',
     1 => 'Development',
     2 => 'United States',
     3 => 'Oceanic',
     4 => 'Latin America',
     5 => 'Tournament',
     6 => 'Korea',
     7 => 'Tournament',
     8 => 'English',
     9 => 'German',
    10 => 'French',
    11 => 'Spanish',
    12 => 'Russian',
    13 => 'Tournament',
    14 => 'Taiwan',
    15 => 'Tournament',
    16 => 'China',
    17 => 'CN1',
    18 => 'CN2',
    19 => 'CN3',
    20 => 'CN4',
    21 => 'CN5',
    22 => 'CN6',
    23 => 'CN7',
    24 => 'CN8',
    25 => 'Tournament',
    26 => 'Test Server',
    27 => 'Tournament',
    28 => 'QA Server',
    29 => 'CN9',
);

//======= SITE FUNCTIONS =======//

// Global Ouput Message For Errors And success Messages, taken from Mangosweb as this is a good function imo.
function output_message($type,$text,$file='',$line=''){
    if($file)$text .= "\n<br>in file: $file";
    if($line)$text .= "\n<br>on line: $line";
    echo "<div class=\"".$type."_box\">$text</div>";
}

// Sets up the Database Handler
function databaseErrorHandler($message, $info)
{
    if (!error_reporting()) return;
    echo "SQL Error: $message<br><pre>"; print_r($info); echo "</pre>";
    exit();
}

function sha_password($user,$pass){
    $user = strtoupper($user);
    $pass = strtoupper($pass);
    return SHA1($user.':'.$pass);
}

// ======== Print Gold Functions (Borrowed from MangosWeb) ======== //
function parse_gold($varnumber) {

	$gold = array();
	$gold['gold'] = intval($varnumber/10000);
	$gold['silver'] = intval(($varnumber % 10000)/100);
	$gold['copper'] = (($varnumber % 10000) % 100);

	return $gold;
}
function get_print_gold($gold_array) {
	if($gold_array['gold'] > 0) {
		echo $gold_array['gold'];
		echo "<img src='inc/admin/images/gold.GIF' border='0'>";
	}
	if($gold_array['silver'] > 0) {
		echo $gold_array['silver'];
		echo "<img src='inc/admin/images/silver.GIF' border='0'>";
	}
	if($gold_array['copper'] > 0) {
		echo $gold_array['copper'];
		echo "<img src='inc/admin/images/copper.GIF' border='0'>";
	}
}

function print_gold($gvar) {
	if($gvar == '---') {
		echo $gvar;
	}
	else {
		get_print_gold(parse_gold($gvar));
	}
}

//===== MAIL FUNCTIONS =====//

// Send Mail
function send_email($goingto,$toname,$sbj,$messg) {
	global $cfg;
	define('DISPLAY_XPM4_ERRORS', true); // display XPM4 errors
	$core_em = $cfg->get('site_email');
		
	// If email type "0" (SMTP)
	if($cfg->get('email_type') == 0) { 
		require_once 'core/mail/SMTP.php'; // path to 'SMTP.php' file from XPM4 package

		$f = ''.$core_em.''; // from mail address
		$t = ''.$goingto.''; // to mail address

		// standard mail message RFC2822
		$m = 'From: '.$f."\r\n".
			'To: '.$t."\r\n".
			'Subject: '.$sbj."\r\n".
			'Content-Type: text/plain'."\r\n\r\n".
			''.$messg.'';

		$h = explode('@', $t); // get client hostname
		$c = SMTP::MXconnect($h[1]); // connect to SMTP server (direct) from MX hosts list
		$s = SMTP::Send($c, array($t), $m, $f); // send mail
		// print result
		if ($s) output_message('notice', 'Mail Sent!');
		else output_message('alert', print_r($_RESULT));
		SMTP::Disconnect($c); // disconnect
	
	// If email type "1" (MIME)
	}elseif($cfg->get('email_type') == 1) {
		require_once 'core/mail/MIME.php'; // path to 'MIME.php' file from XPM4 package

		// compose message in MIME format
		$mess = MIME::compose($messg);
		// send mail
		$send = mail($goingto, $sbj, $mess['content'], 'From: '.$core_em.''."\n".$mess['header']);
		// print result
		echo $send ? output_message('notice', 'Mail Sent!') : output_message('alert', 'Error!');
	
	// If email type "2" (MTA Relay)
	}elseif($cfg->get('email_type') == 2) {
		require_once 'core/mail/MAIL.php'; // path to 'MAIL.php' file from XPM4 package

		$m = new MAIL; // initialize MAIL class
		$m->From($core_em); // set from address
		$m->AddTo($goingto); // add to address
		$m->Subject($sbj); // set subject 
		$m->Html($messg); // set html message

		// connect to MTA server 'smtp.hostname.net' port '25' with authentication: 'username'/'password'
		if($cfg->get('email_use_secure') == 1) {
			$c = $m->Connect($cfg->get('email_smtp_host'), $cfg->get('email_smtp_port'), $cfg->get('email_smtp_user'), $cfg->get('email_smtp_pass'), $cfg->get('email_smtp_secure')) 
				or die(print_r($m->Result));
		}else{
			$c = $m->Connect($cfg->get('email_smtp_host'), $cfg->get('email_smtp_port'), $cfg->get('email_smtp_user'), $cfg->get('email_smtp_pass')) 
				or die(print_r($m->Result));
		}

		// send mail relay using the '$c' resource connection
		echo $m->Send($c) ? output_message('notice', 'Mail Sent!') : output_message('alert', 'Error! Please check your config and make sure you inserted your MTA info correctly.');

		$m->Disconnect(); // disconnect from server
		// print_r($m->History); // optional, for debugging
	}
}


// Gets Banned IP's. Mainly Used in the Auth.class.php
function get_banned($account_id,$returncont)
{
    global $DB;

    $get_last_ip = $DB->selectCell("SELECT last_ip FROM account WHERE id='".$account_id."'");
    $db_IP = $get_last_ip;

    $ip_check = $DB->selectCell("SELECT ip FROM `ip_banned` WHERE ip='".$db_IP."'");
    if ($ip_check == FALSE){
        if ($returncont == "1"){
            return FALSE;
        }
    }else{
        if ($returncont == "1"){
            return TRUE;
        }
        else{
            return $db_IP;
        }
    }
}

// ACCOUNT KEY FUNCTIONS //
function matchAccountKey($id, $key) 
{
    clearOldAccountKeys();
    global $DB;
    $count = $DB->selectcell("SELECT count(*) FROM `account_keys` where id = ?", $id);
    if($count == 0) {
        return false;
    }
    $account_key = $DB->selectcell("SELECT `key` FROM `account_keys` where id = ?", $id);
    if($key == $account_key) {
        return true;
    }
    else {
        return false;
    }
}

function clearOldAccountKeys() 
{
    global $DB;
    global $cfg;

    $cookie_expire_time = (int)$cfg->get('account_key_retain_length');
    if(!$cookie_expire_time) {
        $cookie_expire_time = (60*60*24*365);   //default is 1 year
    }

    $expire_time = time() - $cookie_expire_time;

    $DB->query("DELETE FROM `account_keys` WHERE `assign_time` < ?", $expire_time);
}

function addOrUpdateAccountKeys($id, $key) 
{
    global $DB;

    $current_time = time();

    $count = $DB->selectcell("SELECT count(*) FROM account_keys where id = ?", $id);
    if($count == 0) {   //need to INSERT
        $DB->query("INSERT INTO `account_keys` SET `id` = ?, `key` = ?, `assign_time` = ?", $id, $key, $current_time);
    }
    else {              //need to UPDATE
        $DB->query("UPDATE `account_keys` SET `key` = ?, `assign_time` = ? WHERE `id` = ?", $key, $current_time, $id);
    }
}

function removeAccountKeyForUser($id) 
{
    global $DB;

    $count = $DB->selectcell("SELECT count(*) FROM account_keys where id = ?", $id);
    if($count == 0) {
        //do nothing
    }
    else {
        $DB->query("DELETE FROM `account_keys` WHERE `id` = ?", $id);
    }
}

// Nice redirect function from MangosWeb
function redirect($linkto,$type=0,$wait_sec=0){
    if($linkto){
        if($type==0){
            $GLOBALS['redirect'] = '<meta http-equiv=refresh content="'.$wait_sec.';url='.$linkto.'">';
        }else{
            // Header not works for some(?) computers. Add hax to it.
            header("Location: ".$linkto);
        }
    }
}
?>