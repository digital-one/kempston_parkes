<?php

require_once('./classes/components/button.php');

class edit extends button
{
	function edit($id,$active=1)
	{
		global $LINK;
		global $MODULE;
		global $CONF;
		global $LINK;
		
		$this->name="edit";
		$this->value="Edit";
		
		if(($MODULE->rights["edit"]) && ($active))
			$this->params="onClick=\"window.location='".($LINK->getLink("action=edit&id=".$id))."'\"";
		else 
			$this->params='disabled="disabled"';
		
		$this->generateHtml();
	}

}
?>

