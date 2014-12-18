<?php
require_once('./classes/component.php');

class tableHeader extends component
{
	var $cols = 0;
	var $tab;

	function tableHeader()
	{
		$this->generateHtml();
	}
	
	function addComponent($component)
	{
		$this->tab[$this->cols]="";
		if($component!=null) $this->tab[$this->cols]=$component->getComponent();	
		$this->cols++;	
		$this->generateHtml();
	}
		
	function generateHtml()
	{	
		$this->html='<tr>';
		
		for($i=0;$i<$this->cols;$i++)
		{
			$this->html.='<th class="defaultTh">';
			$this->html.=$this->tab[$i];
			$this->html.='</th>';
		}
		
		$this->html.='</tr>';
	}

 
}
