<?php 
require_once("classes/modules/imageToken/token.php");

class imageToken 
{
	function __construct()
	{
		$tmp=new token();
		$tmp->showImage();

		$_SESSION["token_code"]=$tmp->code;
	}
}



?>
