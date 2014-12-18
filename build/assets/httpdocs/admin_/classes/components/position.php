<?php
require_once('./classes/component.php');

class position extends component
{
	var $up;
	var $down;

	function position($fieldName=null,$fieldValue=null,$key=null)
	{
		global $LINK;
		 
		if($fieldName!=null)	$this->fieldName=$fieldName;
		if($fieldValue!=null)	$this->fieldValue=$fieldValue;
		if($key!=null)			$this->key=$key;
		$this->css='defaultPosition';
		
		$ajax="ajaxRequest('".$this->fieldName."[fieldName]=".$this->fieldName."&amp;".$this->fieldName."[fieldValue]='+this.value,'".$LINK->getLink("action=save&id=".$this->key)."','POST');";
		$this->params='onChange="'.$ajax.'"';		
		
		$this->generateHtml();
	}
	
	function generateHtml()
	{
		$this->html='<input type="text" name="'.$this->fieldName.'" value="'.$this->fieldValue.'" class="'.$this->css.'" '.$this->params.' />';
	}
	
 }
?>