<?php
require_once('./classes/component.php');

class text extends component
{
	function text($fieldName=null,$fieldValue=null,$params=null)
	{
		if($fieldName!=null)	$this->fieldName=$fieldName;
		if($fieldValue!=null)	$this->fieldValue=$fieldValue;
		if($params!=null)		$this->params=$params;
		$this->css='defaultText';
		$this->getData();
		$this->generateHtml();
	}
	
	function generateHtml()
	{
		$this->html.='<input type="hidden" 	name="'.$this->fieldName.'[fieldName]" 	value="'.$this->fieldName.'" />';
		$this->html.='<input type="text"   	name="'.$this->fieldName.'[fieldValue]" value="'.$this->fieldValue.'" class="'.$this->css.'" '.$this->params.' />';
	}
	
}

?>