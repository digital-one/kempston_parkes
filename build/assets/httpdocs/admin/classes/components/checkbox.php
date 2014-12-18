<?php
require_once('./classes/component.php');

class checkbox extends component
{
	function checkbox($fieldName=null,$fieldValue=null,$params=null)
	{
		if($fieldName!=null)	$this->fieldName=$fieldName;
		if($fieldValue!=null)	$this->fieldValue=$fieldValue;
		if($params!=null)		$this->params=$params;
		$this->css='defaultCheckbox';
		$this->getData();
		$this->generateHtml();
	}
	
	function generateHtml()
	{
		if($this->fieldValue=="1")	$this->checked='checked="checked"';
		
		$this->html.='<input type="hidden" 	name="'.$this->fieldName.'[fieldName]" 	value="'.$this->fieldName.'" />';
		$this->html.='<div class="'.$this->css.'"><input type="checkbox" name="'.$this->fieldName.'[fieldValue]" value="1"  class="'.$this->css.'" '.$this->params.' '.$this->checked.' /></div>';
	}
	
	function saveData()
	{
		global $DB;
		if( (!empty($this->tableName)) && (!empty($this->fieldName)) && (!empty($this->keyName)) && (is_numeric($this->key)) )
		{
			if($this->fieldValue!=1)$this->fieldValue=0;
			$DB->query("UPDATE ".$this->tableName." SET ".$this->fieldName."='".$this->fieldValue."' WHERE ".$this->keyName."=".$this->key);	

		}
		return true;
	}
	
}
?>