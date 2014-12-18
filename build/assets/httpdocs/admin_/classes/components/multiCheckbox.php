<?php
require_once('./classes/component.php');


class multiCheckbox extends component
{
	var $sourceTableName;	
	var $sourceFieldValue;	
	var $sourceFieldName;
	var $destinationTableName;
	var $destinationKey1;
	var $destinationKey2;
	
	function multiCheckbox($fieldName=null,$key=null,$sourceTableName=null,$sourceFieldName=null,$sourceFieldValue=null,$destinationTableName=null,$destinationKey1=null,$destinationKey2=null)
	{
		if($fieldName!=null) 			$this->fieldName=$fieldName;
		if($key!=null) 					$this->key=$key;
		if($sourceTableName!=null) 		$this->sourceTableName=$sourceTableName;
		if($sourceFieldValue!=null) 	$this->sourceFieldValue=$sourceFieldValue;
		if($sourceFieldName!=null) 		$this->sourceFieldName=$sourceFieldName;
		if($destinationTableName!=null) $this->destinationTableName=$destinationTableName;
		if($destinationKey1!=null) 		$this->destinationKey1=$destinationKey1;
		if($destinationKey2!=null) 		$this->destinationKey2=$destinationKey2;
		
		$this->generateHtml();
	}
	
	function generateHtml()
	{	
		global $DB;
		
		if( (!empty($this->sourceFieldValue)) && (!empty($this->sourceFieldName)) && (!empty($this->sourceTableName)) )
		{
			$this->html.='<input type="hidden" 	name="'.$this->fieldName.'[fieldName]" 				value="'.$this->fieldName.'" />';
			$this->html.='<input type="hidden" 	name="'.$this->fieldName.'[sourceTableName]" 		value="'.$this->sourceTableName.'" />';
			$this->html.='<input type="hidden" 	name="'.$this->fieldName.'[sourceFieldName]" 		value="'.$this->sourcefieldName.'" />';
			$this->html.='<input type="hidden" 	name="'.$this->fieldName.'[sourceFieldValue]" 		value="'.$this->sourceFieldValue.'" />';
			$this->html.='<input type="hidden" 	name="'.$this->fieldName.'[destinationTableName]" 	value="'.$this->destinationTableName.'" />';
			$this->html.='<input type="hidden" 	name="'.$this->fieldName.'[destinationKey1]" 		value="'.$this->destinationKey1.'" />';
			$this->html.='<input type="hidden" 	name="'.$this->fieldName.'[destinationKey2]" 		value="'.$this->destinationKey2.'" />';
			
			
			if(is_numeric($this->key))
				$query="SELECT s.".$this->sourceFieldValue.",s.".$this->sourceFieldName.",(SELECT count(*) FROM ".$this->destinationTableName." WHERE ".$this->destinationKey1."=".$this->key." AND ".$this->destinationKey2."=s.".$this->sourceFieldValue." LIMIT 1) AS checked FROM ".$this->sourceTableName." AS s";
			else  
				$query="SELECT s.".$this->sourceFieldValue.",s.".$this->sourceFieldName.",0 AS checked FROM ".$this->sourceTableName." AS s";
				
			$rs=$DB->query($query);
			while($tab=$DB->fetch_array($rs))
			{
				$this->html.='<input class="defaultCheckbox" type="checkbox" name="'.$this->fieldName.'[fieldValue][]" value="'.$tab[$this->sourceFieldValue].'"';
				if($tab["checked"]) 
					{
						$this->html.=' checked="checked"';
					}
				$this->html.=' />&nbsp;'.$tab[$this->sourceFieldName].'<br />';
			}
		
		}
		
	}
	
	function saveData()
	{
		global $DB;
		if(is_numeric($this->key))
		{
			$DB->query("DELETE FROM ".$this->destinationTableName." WHERE ".$this->destinationKey1."=".$this->key);
			for($i=0;$i<sizeOf($this->fieldValue);$i++)
			if(is_numeric($this->fieldValue[$i]))
			$DB->query("INSERT INTO ".$this->destinationTableName." (".$this->destinationKey1.",".$this->destinationKey2.") VALUES(".$this->key.",".$this->fieldValue[$i].")");
		}
		
		return true;
	}
	
	function delData()
	{
		global $DB;
		if((is_numeric($this->key)) && (!empty($this->destinationTableName)) && (!empty($this->destinationKey1)) )
		$DB->query("DELETE FROM ".$this->destinationTableName." WHERE ".$this->destinationKey1."=".$this->key);
		
		return true;
	}

}

?>