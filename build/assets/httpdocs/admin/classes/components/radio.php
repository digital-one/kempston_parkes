<?php
require_once('./classes/component.php');
class radio extends component
{
	function radio($fieldName=null,$fieldValue=null)
	{
		global $LINK;
  
		if($fieldName!=null)	$this->fieldName=$fieldName;
		if($fieldValue!=null)	$this->fieldValue=$fieldValue;
		$this->css='defaultRadio';
		$this->generateHtml();
 }
 
	function generateHtml()
	{
		if($this->fieldValue=="1")	$this->checked='checked="checked"';
	
		$this->html.='<input type="hidden" 	name="'.$this->fieldName.'[fieldName]" 	value="'.$this->fieldName.'" />';
		$this->html.='<div class="'.$this->css.'"><input type="radio" name="'.$this->fieldName.'[fieldValue]" value="1"  class="'.$this->css.'" '.$this->checked.' '.$this->params.' /></div>';
	}
	
}

?>