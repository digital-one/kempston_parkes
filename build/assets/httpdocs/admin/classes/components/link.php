<?php

require_once('./classes/component.php');

class link extends component
{
	function link($fieldName=null,$fieldValue=null,$params=null)
	{
		if($fieldName!=null)		$this->fieldName=$fieldName;
		if($fieldValue!=null)		$this->fieldValue=$fieldValue;
		if($params!=null)			$this->params=$params;		
		if(is_object($fieldName)) 	$this->fieldName=$fieldName->getComponent();
		else $this->fieldName=$fieldName;
		$this->css='defaultLink';
		$this->generateHtml();
	}
	
	function generateHtml()
	{
		$this->html='<a href="'.$this->fieldValue.'" class="'.$this->css.'" '.$this->params.'>'.$this->fieldName.'</a>';
	}
}
?>
