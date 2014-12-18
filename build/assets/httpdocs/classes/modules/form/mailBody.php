<?php
class mailBody extends templateEngine
{
	public $body;
	
	function __construct($msg)
	{
		$this->body=$msg;
		$this->parseTemplate("templates/modules/form/mailBody.html");
	}
}

?>
