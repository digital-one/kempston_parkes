<?php
require_once('./classes/component.php');
require_once('./classes/components/option.php');

class listbox extends component
{
	var $options;
	
	function listbox($name=null,$value=null,$options=null,$multiple=false,$separator=";")
	{
		if($name!=null)			$this->fieldName=$name;
		if($value!=null)		$this->fieldValue=$value;
		if($options!=null)		$this->options=$options;
		
		$this->separator=$separator;
		$this->multiple=$multiple;
		
		if($this->multiple) $this->css='defaultMultiSelect';
		else $this->css='defaultSelect';
		
		$this->getData();
		$this->generateHtml();
	}
	
	function generateHtml()
	{
		
		$this->html='<input type="hidden" name="'.$this->fieldName.'[fieldName]"  value="'.$this->fieldName.'" />';
		$this->html.='<input type="hidden" name="'.$this->fieldName.'[separator]" value="'.$this->separator.'" />';
		$this->html.='<input type="hidden" name="'.$this->fieldName.'[multiple]"   value="'.$this->multiple.'" />';
		
		if($this->multiple) $this->html.='<select name="'.$this->fieldName.'[fieldValue][]" class="'.$this->css.'" multiple="multiple">';
		else $this->html.='<select name="'.$this->fieldName.'[fieldValue]" class="'.$this->css.'" >';
		
		if(!empty($this->multiple)) $this->fieldValue=explode($this->separator,$this->fieldValue);		
		
		$size=sizeof($this->options);
		for($i=0;$i<$size;$i++) 
		{
			$tmp=new option($this->options[$i]["name"],$this->options[$i]["value"],$this->fieldValue);
			$this->html.=$tmp->getComponent();
		}
			
		$this->html.='</select> ';
	}
	
	function saveData()
	{
		global $DB;
		
		if($this->multiple) $this->fieldValue=implode($this->separator,$this->fieldValue);
		
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
}

?>