<?php
/*******************************************************************************************/
/* Auth Class. Written by ??, Re-written for KeysCMS by Wilson212. Borrowed from MangosWeb */
/* 			This script conatians all the login, register, and logout scripts 			   */
/*******************************************************************************************/

class AUTH {
    var $DB;
    var $user = array(
     'id'    => -1,
     'username'  => 'Guest',
     'account_level' => 1
    );

    function AUTH($DB)
    {
        global $cfg;
        $this->DB = $DB;
        $this->check();
        $this->user['ip'] = $_SERVER['REMOTE_ADDR'];
        $this->lastvisit_update($this->user);
    }

    function check()
    {
        global $cfg;
        if(isset($_COOKIE[((string)$cfg->get('site_cookie'))])){
            list($cookie['user_id'], $cookie['account_key']) = @unserialize(stripslashes($_COOKIE[((string)$cfg->get('site_cookie'))]));
            if($cookie['user_id'] < 1)return false;
            $res = $this->DB->selectRow("
                SELECT * FROM account
                LEFT JOIN account_extend ON account.id=account_extend.account_id
                LEFT JOIN account_groups ON account_extend.account_level=account_groups.account_level
                WHERE id = ?d", $cookie['user_id']);
            if(get_banned($res['id'], 1)== TRUE){
                $this->setgroup();
                $this->logout();
                output_message('alert','Your account is currently banned');
                return false;
            }
            if($res['activation_code'] != null){
                $this->setgroup();
                output_message('alert','Your account is not active');
                return false;
            }
            if(matchAccountKey($cookie['user_id'], $cookie['account_key'])){
                unset($res['sha_pass_hash']);
                $this->user = $res;
                return true;
            }else{
                $this->setgroup();
                return false;
            }
        }else{
            $this->setgroup();
            return false;
        }
    }

    function setgroup($gid=1) // 1 - guest, 5- banned
    {
        $guest_g = $this->getgroup($gid);
        $this->user = array_merge($this->user,$guest_g);
    }

    function login($params)
    {
        global $cfg;
        $success = 1;
        if (empty($params)) return false;
        if (empty($params['username'])){
            output_message('alert','You did not provide your username');
            $success = 0;
        }
        if (empty($params['sha_pass_hash'])){
            output_message('alert','You did not provide your password');
            $success = 0;
        }
        $res = $this->DB->selectRow("
            SELECT `id`,`username`,`sha_pass_hash`,`locked` FROM `account`
            WHERE `username` = ?", $params['username']);
        if($res['id'] < 1){$success = 0;output_message('alert','Bad username');}
        if(get_banned($res[id], 1)== TRUE){
            output_message('alert','Your account is currently banned');
            $success = 0;
        }
        if($res['activation_code'] != null){
            output_message('alert','Your account is not active');
            $success = 0;
        }
        if($success!=1) return false;
        if( strtoupper($res['sha_pass_hash']) == strtoupper($params['sha_pass_hash'])){
            $this->user['id'] = $res['id'];
            $this->user['name'] = $res['username'];
            $generated_key = $this->generate_key();
            addOrUpdateAccountKeys($res['id'],$generated_key);
            $uservars_hash = serialize(array($res['id'], $generated_key));
            $cookie_expire_time = intval($cfg->get('account_key_retain_length'));
            if(!$cookie_expire_time) {
                $cookie_expire_time = (60*60*24*365);   //default is 1 year
            }
            (string)$cookie_name = $cfg->get('site_cookie');
            (string)$cookie_href = $cfg->get('site_href');
            (int)$cookie_delay = (time()+$cookie_expire_time);
            setcookie($cookie_name, $uservars_hash, $cookie_delay,$cookie_href);
            return true;
        }else{
            output_message('alert','Your password is incorrect');
            return false;
        }
    }

    function logout()
    {
        global $cfg;
        setcookie((string)$cfg->get('site_cookie'), '', time()-3600,(string)$cfg->get('site_href'));
        removeAccountKeyForUser($this->user['id']);
    }

    function lastvisit_update($uservars)
    {
        if($uservars['id']>0){
            if(time() - $uservars['last_visit'] > 60*10){
                $this->DB->query("UPDATE `account_extend` SET last_visit=?d WHERE account_id=?d LIMIT 1",time(),$uservars['id']);
            }
        }
    }
    function register($params, $account_extend = false)
    {
        global $cfg;
        $success = 1;
        if(empty($params)) return false;
        if(empty($params['username'])){
            output_message('alert','You did not provide your username');
            $success = 0;
        }
        if(empty($params['sha_pass_hash']) || $params['sha_pass_hash']!=$params['sha_pass_hash2']){
            output_message('alert','You did not provide your password or confirm pass');
            $success = 0;
        }
        if(empty($params['email'])){
            output_message('alert','You did not provide your email');
            $success = 0;
        }

        if($success!=1) return false;
        unset($params['sha_pass_hash2']);
        $password = $params['password'];
        unset($params['password']);
        if((int)$cfg->get('req_reg_act')){
            $tmp_act_key = $this->generate_key();
            $params['locked'] = 1;
            if($acc_id = $this->DB->query("INSERT INTO account SET ?a",$params)){
                // If we dont want to insert special stuff in account_extend...
                if ($account_extend == NULL){
                    $this->DB->query("INSERT INTO account_extend SET account_id=?d, registration_ip=?, activation_code=?",$acc_id,$_SERVER['REMOTE_ADDR'],$tmp_act_key);
                }
                else {
                    $this->DB->query("INSERT INTO account_extend SET account_id=?d, registration_ip=?, activation_code=?, secret_q1=?s, secret_a1=?s, secret_q2=?s, secret_a2=?s",$acc_id,$_SERVER['REMOTE_ADDR'],$tmp_act_key,$account_extend['secretq1'], $account_extend['secreta1'], $account_extend['secretq2'], $account_extend['secreta2']);
                }
                $act_link = (string)$cfg->get('base_href').'index.php?p=account&sub=activate&id='.$acc_id.'&key='.$tmp_act_key;
                $email_text  = '== Account activation =='."\n\n";
                $email_text .= 'Username: '.$params['username']."\n";
                $email_text .= 'Password: '.$password."\n";
                $email_text .= 'This is your activation key: '.$tmp_act_key."\n";
                $email_text .= 'CLICK HERE : '.$act_link."\n";
                send_email($params['email'],$params['username'],'== '.(string)$cfg->get('site_title').' account activation ==',$email_text);
                return true;
            }else{
                return false;
            }
        }else{
            if($acc_id = $this->DB->query("INSERT INTO account SET ?a",$params)){
                if ($account_extend == false){
                    $this->DB->query("INSERT INTO account_extend SET account_id=?d, registration_ip=?, activation_code=?",$acc_id,$_SERVER['REMOTE_ADDR'],$tmp_act_key);
                }else{
                    $this->DB->query("INSERT INTO account_extend SET account_id=?d, registration_ip=?, activation_code=?, secret_q1=?s, secret_a1=?s, secret_q2=?s, secret_a2=?s",$acc_id,$_SERVER['REMOTE_ADDR'],$tmp_act_key,$account_extend['secretq1'], $account_extend['secreta1'], $account_extend['secretq2'], $account_extend['secreta2']);
                }
                return true;
            }
            else{
                return false;
            }
        }
    }
	
	function changePass($id,$usern,$newpass) {
		global $DB;
	}
	
    function isavailableusername($username){
        $res = $this->DB->selectCell("SELECT count(*) FROM account WHERE username=?",$username);
        if($res < 1) return true; // username is available
        return false; // username is not available
    }

    function isavailableemail($email){
        $res = $this->DB->selectCell("SELECT count(*) FROM account WHERE email=?",$email);
        if($res < 1) return true; // email is available
        return false; // email is not available
    }
    function isvalidemail($email){
        if(preg_match('#^.{1,}@.{2,}\..{2,}$#', $email)==1){
            return true; // email is valid
        }else{
            return false; // email is not valid
        }
    }
    function isvalidregkey($key){
        $res = $this->DB->selectCell("SELECT count(*) FROM site_regkeys WHERE `key`=?",$key);
        if($res > 0) return true; // key is valid
        return false; // key is not valid
    }
    function isvalidactkey($key){
        $res = $this->DB->selectCell("SELECT account_id FROM account_extend WHERE activation_code=?",$key);
        if($res > 0) return $res; // key is valid
        return false; // key is not valid
    }
    function generate_key()
    {
        $str = microtime(1);
        return sha1(base64_encode(pack("H*", md5(utf8_encode($str)))));
    }
    function generate_keys($n)
    {
        set_time_limit(600);
        for($i=1;$i<=$n;$i++)
        {
            if($i>1000)exit;
            $keys[] = $this->generate_key();
            $slt = rand(15000, 500000);
            usleep($slt);
            //sleep(1);
        }
        return $keys;
    }
    function delete_key($key){
        $this->DB->query("DELETE FROM site_regkeys WHERE `key`=?",$key);
    }
	function getprofile($acct_id=false){
		global $cfg;
		if($cfg->get('emulator') == 'trinity') {
			$res = $this->DB->selectRow("
				SELECT * FROM account
				LEFT JOIN account_extend ON account.id=account_extend.account_id
				LEFT JOIN account_groups ON account_extend.account_level=account_groups.account_level
				WHERE id=?d",$acct_id);
		}else{
			$res = $this->DB->selectRow("
				SELECT * FROM account
				LEFT JOIN account_extend ON account.id=account_extend.account_id
				LEFT JOIN account_groups ON account_extend.account_level=account_groups.account_level
				WHERE id=?d",$acct_id);
		}
        return $res;
    }
    function getgroup($g_id=false){
        $res = $this->DB->selectRow("SELECT * FROM account_groups WHERE account_level=?d",$g_id);
        return $res;
    }
    function getlogin($acct_id=false){
        $res = $this->DB->selectCell("SELECT username FROM account WHERE id=?d",$acct_id);
        if($res == null) return false;  // no such account
        return $res;
    }
    function getid($acct_name=false){
        $res = $this->DB->selectCell("SELECT id FROM account WHERE username=?",$acct_name);
        if($res == null) return false;  // no such account
        return $res;
    }
    function gethash($str=false){
        if($str)return sha1(base64_encode(md5(utf8_encode($str)))); // Returns 40 char hash.
        else return false;
    }
}
    // ONLINE FUNCTIONS //
?>