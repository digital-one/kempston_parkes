<?php
require_once('./classes/component.php');

class number extends component
{
	function number($fieldName=null,$fieldValue=null,$params=null)
	{
		if($fieldName!=null)	$this->fieldName=$fieldName;
		if($fieldValue!=null)	$this->fieldValue=$fieldValue;
		if($params!=null)		$this->params=$params;
		$this->css='defaultNumber';
	
		$this->getData();
		$this->generateHtml();
	}
	
	function generateHtml()
	{
		$this->html.='<input type="hidden" 	name="'.$this->fieldName.'[fieldName]" 	value="'.$this->fieldName.'" />';
		$this->html.='<input type="text"   	name="'.$this->fieldName.'[fieldValue]" value="'.$this->fieldValue.'" class="'.$this->css.'" '.$this->params.' />';
	}
	
	function saveData()
	{
		global $DB;
		$this->fieldValue=round($this->fieldValue);
		$this->fieldValue=number_format($this->fieldValue,0,'','');
		
		if( (!empty($this->tableName)) && (!empty($this->fieldName)) && (!empty($this->keyName)) && (!empty($this->key)) )
		{
			$DB->query("UPDATE ".$this->tableName." SET ".$this->fieldName."='".$this->fieldValue."' WHERE ".$this->keyName."=".$this->key);	
		}
		
		return true;
	}
	
}

?>