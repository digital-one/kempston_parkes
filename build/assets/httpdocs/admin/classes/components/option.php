<?php
require_once('./classes/component.php');

class option extends component
{
	var $selected;

	function option($name=null,$value=null,$selectedValue=null)
	{
		$this->css="defaultSelectOption";	
		$this->name=substr(strip_tags(stripslashes($name)),0,99);
		$this->value=$value;
		if(is_array($selectedValue))
		{
			foreach($selectedValue AS $k=>$v) if($this->value==$v) $this->selected='selected="selected"';
		}
		else if($selectedValue==$this->value)  $this->selected='selected="selected"';

		$this->generateHtml();
	}
	
	function generateHtml()
	{
		$this->html='<option '.$this->id.' class="'.$this->css.'" value="'.$this->value.'" '.$this->selected.'>'.$this->name.'</option>';
	}
	
	
	
}

?>