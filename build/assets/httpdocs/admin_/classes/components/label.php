<?php

require_once('./classes/component.php');

class label extends component
{
	function label($value=null)
	{
		$this->css='defaultLabel';		
		if(is_object($value)) $this->value=$value->getComponent();
		else $this->value=$value;
		$this->generateHtml();
	}
	
	function generateHtml()
	{
		$this->html='<div class="'.$this->css.'" '.$this->id.'>'.$this->value.'</div>';
	}
}
?>
