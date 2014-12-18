<?php

require_once('./classes/components/button.php');

class delete extends button
{
	function delete($id,$active=1)
	{
		global $LINK;
		global $MODULE;
		global $CONF;
		global $LINK;
		
		$this->name="delete";
		$this->value="Delete";
		
		if(($MODULE->rights["delete"]) && ($active))
			$this->params="onClick=\"if(window.confirm('Are you sure you want to delete?')) { window.location='".($LINK->getLink("action=del&id=".$id))."';}\"";
		else 
			$this->params='disabled="disabled"';
		
		$this->generateHtml();
	}

}
?>

