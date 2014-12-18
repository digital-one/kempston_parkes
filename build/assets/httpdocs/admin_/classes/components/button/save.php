<?php

require_once('./classes/components/button.php');

class save extends button
{
	
	function save()
	{
		$this->name="save";
		$this->value='Save&nbsp;&raquo;';
		$this->generateHtml();
	}
	
	function generateHtml()
	{
		$this->html='<input type="submit"  name="'.$this->name.'" value="'.$this->value.'" class="'.$this->css.'" '.$this->id.' '.$this->params.' />';
	}
}
?>

