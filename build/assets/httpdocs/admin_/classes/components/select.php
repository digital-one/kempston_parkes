<?php
require_once('./classes/component.php');
require_once('./classes/components/option.php');
class select extends component
{
	var $options;
	var $size=0;
	var $sourceTableName;
	var $sourceFieldName;
	var $sourceFieldValue;
	
	function select($fieldName=null,$fieldValue=null,$sourceTableName=null,$sourceFieldName=null,$sourceFieldValue='id',$disabled=false,$params=null)
	{
		if($fieldName!=null)		$this->fieldName=$fieldName;
		if($fieldValue!=null)		$this->fieldValue=$fieldValue;
		if($sourceTableName!=null)	$this->sourceTableName=$sourceTableName;
		if($sourceFieldName!=null)	$this->sourceFieldName=$sourceFieldName;
		if($sourceFieldValue!=null)	$this->sourceFieldValue=$sourceFieldValue;
		if($params!=null)			$this->params=$params;
		if($disabled)				$this->disabled='disabled="disabled"';
		$this->css='defaultSelect';	
		$this->getData();
		$this->generateHtml();
	}
	
	function addComponent($component=null)
	{
		if($component!=null)
		{
			$this->options[$this->size]=$component->getComponent();
			$this->size++;
			$this->generateHtml();
		}
	}	
	
	function generateHtml()
	{
		$this->html='<input type="hidden" name="'.$this->fieldName.'[fieldName]" value="'.$this->fieldName.'" '.$this->disabled.' />';
		$this->html.='<select 			   name="'.$this->fieldName.'[fieldValue]" class="'.$this->css.'" '.$this->params.' '.$this->disabled.'>';
			for($i=0;$i<$this->size;$i++) $this->html.=$this->options[$i];
		$this->html.='</select> ';
	}
	
	function getData()
	{
		global $DB;
		
		if( (!empty($this->sourceTableName)) && (!empty($this->sourceFieldValue)) && (!empty($this->sourceFieldName)) )
		{
			$query="SELECT ".$this->sourceFieldName.",".$this->sourceFieldValue." FROM ".$this->sourceTableName." ORDER BY ".$this->sourceFieldName;
			$rs=$DB->query($query);
			while($tab=$DB->fetch_array($rs)) 
			$this->addComponent(new option($tab[$this->sourceFieldName],$tab[$this->sourceFieldValue],$this->fieldValue));
		}
	}
	
}
?>