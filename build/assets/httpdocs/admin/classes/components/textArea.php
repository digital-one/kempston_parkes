<?php
require_once('./classes/component.php');

class textArea extends component
{
	function textArea($fieldName=null,$fieldValue=null)
	{
		if($fieldName!=null)	$this->fieldName=$fieldName;
		if($fieldValue!=null)	$this->fieldValue=$fieldValue;
		$this->css='defaultTextArea';
	
		$this->getData();
		$this->generateHtml();
	}
	
	function generateHtml()
	{
		$this->html.='<input type="hidden" 	name="'.$this->fieldName.'[fieldName]" 	value="'.$this->fieldName.'" />';
		$this->html.='<textarea 			name="'.$this->fieldName.'[fieldValue]" class="'.$this->css.'" rows="10" cols="10">'.$this->fieldValue.'</textarea>';
	}
	
	function saveData()
	{
		global $DB;
		
		$this->fieldValue=strip_tags($this->fieldValue);
		$this->fieldValue=nl2br($this->fieldValue);
		$this->fieldValue=addslashes($this->fieldValue);
				
		if( (!empty($this->tableName)) && (!empty($this->fieldName)) && (!empty($this->keyName)) && (!empty($this->key)) )
		{
			$DB->query("UPDATE ".$this->tableName." SET ".$this->fieldName."='".$this->fieldValue."' WHERE ".$this->keyName."=".$this->key);	
		}
		
		return true;
	}
	
	function getData()
	{
		$this->fieldValue=strip_tags($this->fieldValue);
		$this->fieldValue=stripslashes($this->fieldValue);
	}

	
}

?>