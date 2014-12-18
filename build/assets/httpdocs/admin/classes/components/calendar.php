<?php
require_once('./classes/component.php');

class calendar extends component
{
	function calendar($fieldName=null,$fieldValue=null,$params=null)
	{
		if($fieldName!=null)	$this->fieldName=$fieldName;
		if($fieldValue!=null)	$this->fieldValue=$fieldValue;
		else $this->fieldValue=date("Y-m-d");
		$this->id='id_'.mt_rand();
		$this->css='defaultCalendar';
		$this->getData();
		$this->generateHtml();
	}
	
  	function generateHtml()
	{
		$this->getData();	
		$this->html='<input type="hidden" name="'.$this->fieldName.'[fieldName]"  value="'.$this->fieldName.'" />';
		$this->html.='<input type="text"  name="'.$this->fieldName.'[fieldValue]" value="'.$this->fieldValue.'" class="'.$this->css.'" id="'.$this->id.'" onClick="showKal('.$this->id.');" />';
	}
	
	function getData()
	{
		$date=explode("-",$this->fieldValue);
		if(!checkdate($date[1],$date[2],$date[0])) $this->fieldValue=date("Y-m-d");
	}
	
}
?>