<?php

class info extends templateEngine
{
	var $message="";
	var $type="";
	var $display=false;
	
	function __construct() 
	{
		$info=unserialize($_SESSION["INFO"]);
		if($info!=null)
		{
			$this->display=$info->display;
			$this->message=$info->message;
			$this->type=$info->type;
		}
	}
	
	function setInfo($msg,$type='info')
	{
		$this->display=true;
		$this->message.=$msg;
		$this->type=$type;
	}
	
	function getInfo()
	{
		if($this->display)
		{
			$this->parseTemplate("templates/info.html");
			$this->display=false;
			$this->message="";
			$this->type="";
			
		}
		return $this->getHtml();
	}
	
	function __destruct() 
	{
       $_SESSION["INFO"]=serialize($this);
	}
	
}

?>