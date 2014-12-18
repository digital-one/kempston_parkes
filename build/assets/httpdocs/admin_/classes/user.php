<?php
class user
{   
    var $id;
	var $sessionId;
	var $login;
	var $lastLogin;
	var $ip;
	var $site;

	function user($user=null)
	{
	 	if($user!=null)
		{
			$this->id			=$user->id;
			$this->sessionId	=$user->sessionId;
		    $this->login		=$user->login;
            $this->lastLogin	=$user->lastLogin;
			$this->ip			=$user->ip;
			$this->site			=$user->site;
		}
	}
	
	function loggedIn()
	{
		$ret = false;
 		if
		( 
			($this->sessionId==session_id()) && 
			($this->ip==$_SERVER["REMOTE_ADDR"]) &&
			($this->site==$_SERVER["SERVER_NAME"].dirname($_SERVER["SCRIPT_NAME"])) &&
			(!empty($this->login)) 
		)	
		$ret=true; 
 		
		return $ret;		
	}
	
}
?>