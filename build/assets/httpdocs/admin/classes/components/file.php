<?php

require_once('./classes/component.php');

class file extends component
{
	var $del=0;
	var $changeName;
	
	function file($fieldName=null,$fieldValue=null,$changeName=true)
	{
		global $MODULE;
		global $ROOTDIR;
				
		if($fieldName!=null)			$this->fieldName=$fieldName;
		if($fieldValue!=null)			$this->fieldValue=$fieldValue;
		$this->changeName=$changeName;
		$this->css='defaultFile';
		
		// sprawdzamy czy sa odpowiednie katalogi
		if(!is_dir($ROOTDIR))									@mkdir($ROOTDIR);
		if(!is_dir($ROOTDIR.$MODULE->dirName))					@mkdir($ROOTDIR.$MODULE->dirName);
		if(!is_dir($ROOTDIR.$MODULE->dirName."/file/"))			@mkdir($ROOTDIR.$MODULE->dirName."/file/");
		
		$this->dirName=$ROOTDIR.$MODULE->dirName."/file/";
		$this->id=$this->fieldName;
		//$this->getData();
		$this->generateHtml();
	}
	
	function generateHtml()
	{
		$this->html.='<input type="hidden" 	name="'.$this->fieldName.'[fieldName]" 		value="'.$this->fieldName.'" />';
		$this->html.='<input type="hidden" 	name="'.$this->fieldName.'[fieldValue]" 	value="'.$this->fieldValue.'" />';
		$this->html.='<input type="hidden" 	name="'.$this->fieldName.'[changeName]" 	value="'.$this->changeName.'" />';
		$this->html.='<input type="file" name="'.$this->fieldName.'" id="'.$this->id.'" class="'.$this->css.'" />';

		if((!empty($this->fieldValue)) && (file_exists($this->dirName.$this->fieldValue)) )
		{
			$this->html.=' Delete:&nbsp;<input type="checkbox" name="'.$this->fieldName.'[del]" value="1" class="defaultCheckbox" /> [ <a href="'.$this->dirName.$this->fieldValue.'" class="defaultLink" target="_blank">preview</a> ]<br />';
		}
	}
	
	function saveData()
	{
		global $DB;
		
		//usuwanie
		if( ( $this->del=="1") && (!empty($this->fieldValue)) && (file_exists($this->dirName.$this->fieldValue)) )
		{
			@unlink($this->dirName.$this->fieldValue);
			$this->fieldValue="";
		}
		
		//kopiowanie
		if( (!empty($_FILES[$this->fieldName]["name"])) && (file_exists($_FILES[$this->fieldName]["tmp_name"])) )
		{
			if((!empty($this->fieldValue)) && (file_exists($this->dirName.$this->fieldValue)))
			{
				@unlink($this->dirName.$this->fieldValue);
			}
			
			if($this->changeName)
			{
				$tmp=explode(".",$_FILES[$this->fieldName]["name"]);
				$ext=$tmp[(sizeof($tmp)-1)];
			
				do
				{
					$this->fieldValue=mt_rand().".".$ext;
				}
				while(file_exists($this->dirName.$this->fieldValue));
			}
			else $this->fieldValue=preg_replace('![^a-zA-Z0-9_\.]!','_',$_FILES[$this->fieldName]["name"]);
			
				
			copy($_FILES[$this->fieldName]["tmp_name"],$this->dirName.$this->fieldValue);
		}
		
		
		if( (!empty($this->tableName)) && (!empty($this->fieldName)) && (!empty($this->keyName)) && (!empty($this->key)) )
		{
			$DB->query("UPDATE ".$this->tableName." SET ".$this->fieldName."='".$this->fieldValue."' WHERE ".$this->keyName."=".$this->key);	
		}
		
		return true;
		
	}
	
	function delData()
	{
		$this->getData();
		if(is_file($this->dirName.$this->fieldValue))
		{
			@unlink($this->dirName.$this->fieldValue);
		}
		
		return true;
	}
	
	function getData()
	{
		global $DB;
		if((!empty($this->fieldName)) && (!empty($this->tableName)) && (!empty($this->keyName)) && (is_numeric($this->key)) )
		{
			$rs=$DB->query("SELECT ".$this->fieldName." FROM ".$this->tableName." WHERE ".$this->keyName."=".$this->key." LIMIT 1");
			$tab=$DB->fetch_array($rs);
			$this->fieldValue=$tab[$this->fieldName];
		}
	}
	
		
}


?>