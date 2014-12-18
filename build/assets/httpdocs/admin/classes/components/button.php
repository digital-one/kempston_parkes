<?php

require_once('./classes/component.php');

class button extends component
{
	var $additional;
	var $css='defaultButton';
	
	function button($name=null,$value=null,$params=null)
	{
		if($name!=null)$this->name=$name;
		if($value!=null)$this->value=$value;
		if($params!=null)$this->params=$params;
		$this->generateHtml();
		
	}
	
	function generateHtml()
	{
		$this->html='<input type="button"  name="'.$this->name.'" value="'.$this->value.'" class="'.$this->css.'" '.$this->id.' '.$this->params.' />';
	}

}
?>

