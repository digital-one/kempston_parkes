<?php
class changePass extends module
{

   function __construct()
	{ 
 		parent::__construct();
		$this->tableName = '_admin';
	}
	
	function show()
	{
		if ($_GET['action']=="change")	$this->changePassAction();
		else $this->changePassForm();		
  	}
	
	function changePassForm() //1
	{
		require_once('./modules/changePass/changePassForm.php');
		$this->title="Change pass";
		$tmp=new changePassForm();
		$this->content=$tmp->html;
		$this->generateHtml();
	}
	
	function changePassAction() //2
	{
		global $DB;
		global $USER;
		global $INFO;
			
		$rs=$DB->query("SELECT * FROM _user WHERE id='".$USER->id."' AND pass='".$_POST["oldPass"]["value"]."'");
		if($DB->num_rows($rs)!=1)	
		{
			$INFO->setInfo("incorect old pass.<br />","error");
		}
		if(strlen($_POST["newPass1"]["value"])<5)	
		{
			$INFO->setInfo("Password length should be 5 stamps minimum.<br />","error");
		}
		if($_POST["newPass1"]["value"]!=$_POST["newPass2"]["value"])	
		{
			$INFO->setInfo("Incorect new  passes.<br />","error");
		}
		
		if(!$INFO->display)
		{
			$DB->query("UPDATE _user SET pass='".$_POST["newPass1"]["value"]."' WHERE id=".$USER->id);
			$INFO->setInfo("Password changed.<br />","info");
		}

		header("Location: index.php?moduleId=".$this->moduleId."");
	}
	
}

?>