<?php
require_once('./classes/component.php');
require_once('./classes/components/formattedTextArea/fckeditor/fckeditor.php');

class formattedTextArea extends component
{
	var $toolBar='Basic';
	var $width=400;
	var $height=200;
	
	function formattedTextArea($fieldName=null,$fieldValue=null,$width=null,$height=null,$toolBar=null)
	{
		global $MODULE;
		if($fieldName!=null)	$this->fieldName=$fieldName;
		if($fieldValue!=null)	$this->fieldValue=$fieldValue;
		if($width!=null)		$this->width=$width;
		if($height!=null)		$this->height=$height;
		if($toolBar!=null)		$this->toolBar=$toolBar;
		
		$this->css='defaultFormatedTextarea';
		$this->dirName=$MODULE->dirName."/fck/";
		
		$this->getData();
		$this->generateHtml();
	}
	
	function generateHtml()
	{
		$oFCKeditor = new FCKeditor($this->fieldName.'[fieldValue]') ;
		$oFCKeditor->BasePath = "classes/components/formattedTextArea/fckeditor/" ;
		$oFCKeditor->ToolbarSet = $this->toolBar;
		$oFCKeditor->Width  = $this->width;
		$oFCKeditor->Height = $this->height;
		$oFCKeditor->Value  = $this->fieldValue;
		
		$_SESSION["fckCurrentDir"]=$this->dirName;
		
		$this->html='<input type="hidden" name="'.$this->fieldName.'[fieldName]" value="'.$this->fieldName.'" />';
		$this->html.=$oFCKeditor->CreateHtml();
	}
	
	
	function rmdirr($dirname)
	{
		if (!file_exists($dirname)) return false;
		if (is_file($dirname)) return unlink($dirname);
		$dir = dir($dirname);
		while (false !== $entry = $dir->read()) 
		{
			if ($entry == '.' || $entry == '..') continue;
			$this->rmdirr($dirname."/".$entry);
		}
		$dir->close();
		return rmdir($dirname);
	}
	
	
}

?>