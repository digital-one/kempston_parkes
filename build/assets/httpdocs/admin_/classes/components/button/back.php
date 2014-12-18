<?php

require_once('./classes/components/button.php');

class back extends button
{
	function back()
	{
		global $LINK;
		
		$this->name="back";
		$this->value='&laquo;&nbsp;Back';
		$this->params='onClick="window.location=\''.($LINK->getLink("action=list","id")).'\';"';
		$this->generateHtml();
	}

}
?>

