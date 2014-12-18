<?php
require_once('./classes/components/checkbox.php');

class activeCheckbox extends checkbox
{
	function activeCheckbox($fieldName=null,$fieldValue=null,$key=null)
	{
		global $LINK;
  
		if($fieldName!=null)	$this->fieldName=$fieldName;
		if($fieldValue!=null)	$this->fieldValue=$fieldValue;
		if($key!=null)			$this->key=$key;
		$this->css='defaultCheckbox';

		$ajax="if(this.checked) 
		{
			//alert('unchecked');
			ajaxRequest('".$this->fieldName."[fieldName]=".$this->fieldName."&amp;".$this->fieldName."[fieldValue]=1','".$LINK->getLink("action=save&id=".$this->key)."','POST');
		}
		else 
		{
			//alert('checked');
			ajaxRequest('".$this->fieldName."[fieldName]=".$this->fieldName."&amp;".$this->fieldName."[fieldValue]=0','".$LINK->getLink("action=save&id=".$this->key)."','POST');
		}"; 
    
 
		$this->params='onClick="'.$ajax.'"';
		$this->generateHtml();
	}
}
?>