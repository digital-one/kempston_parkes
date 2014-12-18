<?php
require_once('./classes/component.php');

class tableHeaderField extends component
{
	var $label;
	var $dbColumnName;
	
	function tableHeaderField($label,$dbColumnName=null)
	{
		$this->css='defaultTableHeaderField';
		$this->label 		= $label;
		$this->dbColumnName = $dbColumnName;
		$this->generateHtml();
	}
	
	function generateHtml()
	{
		global $LINK;
		$this->html='<div class="'.$this->css.'" '.$this->id.'>';
		$_GET['order']=strtoupper($_GET['order']);	
		
		if(!empty($this->dbColumnName)) 
		{
			
			$this->html.='<a class="'.$this->css.'" href="';
			
			if(($this->dbColumnName==$_GET['orderBy']) && ($_GET['order']=='ASC'))	
				$this->html.=$LINK->getLink("orderBy=".$this->dbColumnName."&order=DESC");
			else 
				$this->html.=$LINK->getLink("orderBy=".$this->dbColumnName."&order=ASC");
			
			$this->html.='">';
		}
			
		$this->html.=$this->label;
		
		if($this->dbColumnName==$_GET['orderBy'])
		{
			if($_GET['order']=='DESC')		$this->html.='<img src="images/sortDown.gif" alt="up" border="0" />';
			else if($_GET['order']=='ASC')	$this->html.='<img src="images/sortUp.gif" alt="up" border="0" />';
			else $this->html.='<img src="images/sortNone.gif" alt="up" border="0" />';
		}
		else $this->html.='<img src="images/sortNone.gif" alt="up" border="0" />';
		
		if(!empty($this->dbColumnName)) $this->html.='</a>';
		
		
		$this->html.='</div>';
		
	}

}
?>


