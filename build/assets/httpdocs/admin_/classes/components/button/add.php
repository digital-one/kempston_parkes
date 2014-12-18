<?php

require_once('./classes/components/button.php');

class add extends button
{
	function add()
	{
		global $LINK;
		global $MODULE;
		global $CONF;
		global $LINK;
		
		$this->name="add";
		$this->value="Add";
		
		if($MODULE->rights["add"])
			$this->params="onClick=\"window.location='".($LINK->getLink("action=add"))."'\"";
		else 
			$this->params='disabled="disabled"';
		
		$this->generateHtml();
	}

}
?>

