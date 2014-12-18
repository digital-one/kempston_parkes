<?php
require_once('./classes/components/radio.php');
class activeRadio extends radio
{
	function activeRadio($fieldName=null,$fieldValue=null,$key=null)
	{
		global $LINK;
  
		if($fieldName!=null)	$this->fieldName=$fieldName;
		if($fieldValue!=null)	$this->fieldValue=$fieldValue;
		if($key!=null)			$this->key=$key;
		$this->css='defaultRadio';
  
		$ajax="ajaxRequest('".$this->fieldName."[fieldName]=".$this->fieldName."&amp;".$this->fieldName."[fieldValue]=1','".$LINK->getLink("action=save&id=".$this->key)."','POST');"; 
     
		$this->params='onClick="'.$ajax.'"';
		$this->generateHtml();
	}
 
	function saveData()
	{
		global $DB;
		$DB->query("UPDATE ".$this->tableName." SET ".$this->fieldName."='0' WHERE 1");
		$DB->query("UPDATE ".$this->tableName." SET ".$this->fieldName."='1' WHERE 1 AND ".$this->keyName."=".$this->key);
		
		return true;
	}
}

?>