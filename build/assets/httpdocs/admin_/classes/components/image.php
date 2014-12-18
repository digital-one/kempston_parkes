<?php

require_once('./classes/component.php');

class image extends component
{
	var $del=0;
	var $maxFileSize=1000000;
	var $css='defaultImage';
	var $maxWidth="800";
	var $maxHeight="600";
	var $sizes=null;

	
	function __construct($fieldName=null,$fieldValue=null,$sizes=null)
	{
		global $MODULE;
		global $ROOTDIR;
				
		if($fieldName!=null)			$this->fieldName=$fieldName;
		if($fieldValue!=null)			$this->fieldValue=$fieldValue;
		
		if(!is_dir($ROOTDIR))									@mkdir($ROOTDIR);
		if(!is_dir($ROOTDIR.$MODULE->dirName))					@mkdir($ROOTDIR.$MODULE->dirName);
		if(!is_dir($ROOTDIR.$MODULE->dirName."/image/"))		@mkdir($ROOTDIR.$MODULE->dirName."/image/");
		
		if($sizes!=null) 			
		{
			$this->sizes=$sizes;
		}

		$this->dirName=$ROOTDIR.$MODULE->dirName."/image/";
		$this->id=$this->fieldName;

		$this->generateHtml();
	}
	
	function generateHtml()
	{
		if($this->sizes!=null) 
		{
			$this->html.='<input type="hidden" 	name="'.$this->fieldName.'[sizes]" 	value="'.$this->sizes.'" />';
		}
		$this->html.='<input type="hidden" 	name="'.$this->fieldName.'[fieldName]" 		value="'.$this->fieldName.'" />';
		$this->html.='<input type="hidden" 	name="'.$this->fieldName.'[fieldValue]" 	value="'.$this->fieldValue.'" />';
		$this->html.='<input type="file" 	name="'.$this->fieldName.'" class="'.$this->css.'" />';

		if(is_file($this->dirName.$this->fieldValue))
		{
			$this->html.='<br />Delete:&nbsp;<input type="checkbox" name="'.$this->fieldName.'[del]" value="1" class="defaultCheckbox" />';
			list($x,$y)=getImageSize($this->dirName.$this->fieldValue);
			$this->html.=' Preview: [ <a href="javascript:otworz(\''.$this->dirName.$this->fieldValue.'\',\'foto\','.($x+20).','.($y+20).');" class="defaultLink">original</a> ]';
			
			if($this->sizes!=null)
			{
				$tmp=explode(";",$this->sizes);
				foreach($tmp AS $size)
				{
					$size=trim($size);
					if(is_file($this->dirName.$size."/".$this->fieldValue)) 
					list($x,$y)=explode("x",$size);
					$this->html.=' [ <a href="javascript:otworz(\''.$this->dirName.$size."/".$this->fieldValue.'\',\'foto\','.($x+20).','.($y+20).');" class="defaultLink">'.$size.'</a> ]';
				}
			}
		}
	}
	
	function saveData()
	{
		global $DB;
		
		//usuwanie
		if(($this->del=="1") || ( (!empty($_FILES[$this->fieldName]["name"])) && (file_exists($_FILES[$this->fieldName]["tmp_name"])) ))
		{
			if(is_file($this->dirName.$this->fieldValue)) @unlink($this->dirName.$this->fieldValue);
			
			if($this->sizes!=null)
			{
				$tmp=explode(";",$this->sizes);
				foreach($tmp AS $size)
				{
					$size=trim($size);
					if(is_file($this->dirName.$size."/".$this->fieldValue)) 
					@unlink($this->dirName.$size."/".$this->fieldValue);
				}
			}
			
			$this->fieldValue="";
		}
		
		//kopiowanie
		if( (!empty($_FILES[$this->fieldName]["name"])) && (file_exists($_FILES[$this->fieldName]["tmp_name"])) )
		{
		
			//generowanie nazwy zdjecia
			do
			{
				$this->fieldValue=mt_rand().".jpg";
			}
			while(file_exists($this->dirName.$this->fieldValue));
						
			//zdjecie podstawowe
			$size=getImageSize($_FILES[$this->fieldName]["tmp_name"]);
			if(($size[0]>$this->maxWidth) || ($size[1]>$this->maxHeight))
				imgCopyAndResize($_FILES[$this->fieldName]["tmp_name"],$this->dirName.$this->fieldValue,$this->maxWidth,$this->maxHeight);
			else 
				imgCopyAndResize($_FILES[$this->fieldName]["tmp_name"],$this->dirName.$this->fieldValue,$size[0],$size[1]);
			
			//miniaturki
			if($this->sizes!=null)
			{
				$tmp=explode(";",$this->sizes);
				foreach($tmp AS $size)
				{
					$size=trim($size);
					if(!is_dir($this->dirName.$size."/")) @mkdir($this->dirName.$size."/");
					
					list($x,$y)=explode("x",$size);
					imgCopyAndResize($_FILES[$this->fieldName]["tmp_name"],$this->dirName.$size."/".$this->fieldValue,$x,$y);
				}
			}
			
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
		
		if($this->sizes!=null)
		{
			$tmp=explode(";",$this->sizes);
			foreach($tmp AS $size)
			{
				$size=trim($size);
				if(is_file($this->dirName.$size."/".$this->fieldValue)) 
				@unlink($this->dirName.$size."/".$this->fieldValue);
			}
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