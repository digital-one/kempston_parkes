<?php

require_once('./classes/component.php');

class imageMini extends component
{
	var $del=0;
	var $maxFileSize=1000000;
	var $maxWidth;
	var $maxHeight;
	var $miniWidth;
	var $miniHeight;
	var $miniDirName;
	
	function imageMini($fieldName=null,$fieldValue=null,$maxWidth=800,$maxHeight=600,$miniWidth=150,$miniHeight=100)
	{
		global $MODULE;
		global $ROOTDIR;
				
		if($fieldName!=null)			$this->fieldName=$fieldName;
		if($fieldValue!=null)			$this->fieldValue=$fieldValue;
		if(is_numeric($maxWidth))		$this->maxWidth=$maxWidth;
		if(is_numeric($maxHeight))		$this->maxHeight=$maxHeight;
		if(is_numeric($miniWidth))		$this->miniWidth=$miniWidth;
		if(is_numeric($miniHeight))		$this->miniHeight=$miniHeight;
		
		$this->css='defaultImage';
		
		// sprawdzamy czy sa odpowiednie katalogi
		if(!is_dir($ROOTDIR))									@mkdir($ROOTDIR);
		if(!is_dir($ROOTDIR.$MODULE->dirName))					@mkdir($ROOTDIR.$MODULE->dirName);
		if(!is_dir($ROOTDIR.$MODULE->dirName."/image/"))		@mkdir($ROOTDIR.$MODULE->dirName."/image/");
		if(!is_dir($ROOTDIR.$MODULE->dirName."/image/mini/"))	@mkdir($ROOTDIR.$MODULE->dirName."/image/mini/");
		
		$this->dirName=$ROOTDIR.$MODULE->dirName."/image/";
		$this->miniDirName=$this->dirName."mini/";
		$this->id=$this->fieldName;
		//$this->getData();
		$this->generateHtml();
	}
	
	function generateHtml()
	{
		$this->html.='<input type="hidden" 	name="'.$this->fieldName.'[maxWidth]" 		value="'.$this->maxWidth.'" />';
		$this->html.='<input type="hidden" 	name="'.$this->fieldName.'[maxHeight]" 		value="'.$this->maxHeight.'" />';
		$this->html.='<input type="hidden" 	name="'.$this->fieldName.'[miniWidth]" 		value="'.$this->miniWidth.'" />';
		$this->html.='<input type="hidden" 	name="'.$this->fieldName.'[miniHeight]" 	value="'.$this->miniHeight.'" />';
		$this->html.='<input type="hidden" 	name="'.$this->fieldName.'[fieldName]" 		value="'.$this->fieldName.'" />';
		$this->html.='<input type="hidden" 	name="'.$this->fieldName.'[fieldValue]" 	value="'.$this->fieldValue.'" />';
		$this->html.='<input type="file" 	name="'.$this->fieldName.'" class="'.$this->css.'" />';

		if((!empty($this->fieldValue)) && (file_exists($this->dirName.$this->fieldValue)) )
		{
			$size=@getimagesize($this->miniDirName.$this->fieldValue);
			$this->html.=' Delete:&nbsp;<input type="checkbox" name="'.$this->fieldName.'[del]" value="1" class="defaultCheckbox" /> [ <a href="javascript:otworz(\''.$this->miniDirName.$this->fieldValue.'\',\'foto\','.($size[0]+20).','.($size[1]+20).');" class="defaultLink">preview</a> ]<br />';
		}
	}
	
	function saveData()
	{
		global $DB;
		
		//usuwanie
		if( ( $this->del=="1") && (!empty($this->fieldValue)) && (file_exists($this->dirName.$this->fieldValue)) )
		{
			@unlink($this->dirName.$this->fieldValue);
			@unlink($this->miniDirName.$this->fieldValue);
			$this->fieldValue="";
		}
		
		//kopiowanie
		if( (!empty($_FILES[$this->fieldName]["name"])) && (file_exists($_FILES[$this->fieldName]["tmp_name"])) )
		{
			if((!empty($this->fieldValue)) && (file_exists($this->dirName.$this->fieldValue)))
			{
				@unlink($this->dirName.$this->fieldValue);
				@unlink($this->miniDirName.$this->fieldValue);
			}
			
			do
			{
				$this->fieldValue=mt_rand().".jpg";
			}
			while(file_exists($this->dirName.$this->fieldValue));
			
				
			$size=getImageSize($_FILES[$this->fieldName]["tmp_name"]);
			//zdjecie podstawowe
			if(($size[0]>$this->maxWidth) || ($size[1]>$this->maxHeight))
				imgCopyAndResize($_FILES[$this->fieldName]["tmp_name"],$this->dirName.$this->fieldValue,$this->maxWidth,$this->maxHeight);
			else 
				imgCopyAndResize($_FILES[$this->fieldName]["tmp_name"],$this->dirName.$this->fieldValue,$size[0],$size[1]);
			//miniaturka
			if(($size[0]>$this->miniWidth) || ($size[1]>$this->miniHeight))
				imgCopyAndResize($_FILES[$this->fieldName]["tmp_name"],$this->miniDirName.$this->fieldValue,$this->miniWidth,$this->miniHeight);
			else 
				imgCopyAndResize($_FILES[$this->fieldName]["tmp_name"],$this->miniDirName.$this->fieldValue,$size[0],$size[1]);
			
			
		}
		
		global $DB;
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
			@unlink($this->miniDirName.$this->fieldValue);
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