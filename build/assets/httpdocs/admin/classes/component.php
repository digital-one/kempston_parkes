<?php

class component
{
	var $params; // css id
	var $css; // css style
	var $fieldName;
	var $fieldValue;
	var $dirName;
	var $tableName;
	var $key;
	var $keyName='id';
	var $html;
	
	function component()
	{
	
	}
	
	function show()
	{
		print($this->getComponent());
	}
	
	function getComponent()
	{
		 return $this->html;
	}
	
	function addComponent()
	{
	}
	
	function getData()
	{
		/* not implemented 
		global $DB;
		if( (!empty($this->tableName)) && (!empty($this->fieldName)) && (!empty($this->keyName)) && (is_numeric($this->key)) )
		{
			$rs=$DB->query("SELECT ".$this->name." FROM ".$this->tableName." WHERE ".$this->keyName."=".$this->key." LIMIT 1");	
			$tab=$DB->fetch_array($rs);
			$this->value=stripslashes($tab[$this->fieldName]);
		}
		*/
	}
	
	function saveData()
	{
		global $DB;
		$ret=true;
		if( (!empty($this->tableName)) && (!empty($this->fieldName)) && (!empty($this->keyName)) && (is_numeric($this->key)) )
		{
			if(get_magic_quotes_gpc()) 
			{
				$DB->query("UPDATE ".$this->tableName." SET ".$this->fieldName."='".$this->fieldValue."' WHERE ".$this->keyName."=".$this->key);
			}
			else
			{
				$DB->query("UPDATE ".$this->tableName." SET ".$this->fieldName."='".addslashes($this->fieldValue)."' WHERE ".$this->keyName."=".$this->key);
			}
		}
		else $ret=false;
		
		return $ret;
	}
	
	function delData()
	{
		return true;
	}
}
?>