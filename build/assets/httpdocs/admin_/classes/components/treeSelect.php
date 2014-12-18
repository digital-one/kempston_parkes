<?php
require_once('./classes/component.php');
require_once('./classes/components/option.php');
class treeSelect extends component
{
	var $options;
	var $size=0;
	var $sourceTableName;
	var $sourceFieldName;
	var $sourceFieldValue;
	var $level=0;
	
	function treeSelect($fieldName=null,$fieldValue=null,$sourceTableName=null,$sourceFieldName=null,$sourceFieldValue='id')
	{
		if($fieldName!=null)		$this->fieldName=$fieldName;
		if($fieldValue!=null)		$this->fieldValue=$fieldValue;
		if($sourceTableName!=null)	$this->sourceTableName=$sourceTableName;
		if($sourceFieldName!=null)	$this->sourceFieldName=$sourceFieldName;
		if($sourceFieldValue!=null)	$this->sourceFieldValue=$sourceFieldValue;
		$this->css='defaultSelect';	
		$this->addComponent(new option("Main",0,$_GET['parentId']));
		$this->getData(0);
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
		$this->html='<input type="hidden" name="'.$this->fieldName.'[fieldName]" value="'.$this->fieldName.'" />';
		$this->html.='<select 			   name="'.$this->fieldName.'[fieldValue]" class="'.$this->css.'" '.$this->params.'>';
			for($i=0;$i<$this->size;$i++) $this->html.=$this->options[$i];
		$this->html.='</select> ';
	}
	
	function getData($id)
	{
		global $DB;
		
		if( (!empty($this->sourceTableName)) && (!empty($this->sourceFieldValue)) && (!empty($this->sourceFieldName)) )
		{
			$query="SELECT ".$this->sourceFieldName.",".$this->sourceFieldValue." FROM ".$this->sourceTableName." WHERE parentId=".$id." ORDER BY position ASC, id ASC";
			$rs=$DB->query($query);
			$this->level++;
			while($tab=$DB->fetch_array($rs))
			{			
				if($tab["id"]!=$_GET["id"])
				{
					$padding="";
					for($i=0;$i<$this->level;$i++) $padding.="|&nbsp;&nbsp;";
					$this->addComponent(new option($padding.$tab[$this->sourceFieldName],$tab[$this->sourceFieldValue],$this->fieldValue));
					$this->getData($tab["id"]);
				}
			}
			$this->level--;
		}
	}
	
	function delData()
	{
		global $DB;
		global $MODULE;
		global $INFO;
		global $LINK;
		$ret=true;
		
		if( (!empty($this->sourceTableName)) && (!empty($this->sourceFieldValue)) && (!empty($this->sourceFieldName)) )
		{
			$query="SELECT ".$this->sourceFieldName.",".$this->sourceFieldValue." FROM ".$this->sourceTableName." WHERE parentId=".$this->key;
			$rs=$DB->query($query);
			
			if($DB->num_rows($rs)>0) 
			{
				if(!$_GET["cascade"]) 
				{
					$INFO->setInfo('This element has subelements, <a href="javascript:window.location=window.location">cancel</a> | <a href="'.$LINK->getLink("cascade=true").'">remove all</a>.','error');
					$ret=false;
				}
				else
				{
					$tempid=$_GET["id"];
					while($tab=$DB->fetch_array($rs))
					{			
						$_GET["id"]=$tab["id"];
						$MODULE->del();
					}
					$_GET["id"]=$tempid;
				}
			}
			
			
		}
		
		return $ret;
	}
	
}
?>