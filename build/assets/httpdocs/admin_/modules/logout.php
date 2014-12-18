<?php
require_once('./modules/logout/logoutForm.php');
		
class logout extends module
{
	
	function __construct()
	{
		parent::__construct();
	}
	
	function show()
	{
		if ($_GET['action']=="logout") 		$this->logoutAction(); 
		else $this->logoutForm(); 
	}
	
	function logoutForm() //3
	{
		$this->title.=" - ".$this->name="Logout";
		$tmp=new logoutForm();
		$this->content=$tmp->html;
		$this->generateHtml();
	}
	
	
	function logoutAction() //4
	{
		global $USER;
		unset($USER);
		session_destroy();
		header('Location: index.php');
	}
	
	
	
}

?>
