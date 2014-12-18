<?php
require_once('./classes/component.php');

class hidden extends component
{
	function hidden($fieldName=null,$fieldValue=null)
	{
		if($fieldName!=null)	$this->fieldName=$fieldName;
		if($fieldValue!=null)	$this->fieldValue=$fieldValue;
		$this->genarateHtml();
	}
	
	function genarateHtml()
	{
		$this->html='<input type="hidden" 	name="'.$this->fieldName.'[fieldName]" 	value="'.$this->fieldName.'" />';
		$this->html.='<input type="hidden"  name="'.$this->fieldName.'[fieldValue]" value="'.$this->fieldValue.'" 	class="'.$this->css.'" 	'.$this->params.' />';
	}
	
}
?>