<?php
require_once('./classes/component.php');


class table extends component
{
	var $rows=0;
	var $cols=2;
	var $tab;
	var $tableHeader;
	var $border=0;
	var $cellpadding=5;
	var $cellspacing=1;
	var $css="defaultTable";
	var $enlighting=false;
	var $colorFill=true;
	var $color1="#f6f6f6";
	var $color2="#fcfcfc";
	
	function table($tableHeader=null,$enlighting=null)
	{
		if($enlighting!=null)  $this->enlighting=$enlighting;
		if($tableHeader!=null) $this->addTableHeader($tableHeader);
		$this->createTable();
	}
	
	function addComponent($component,$align="left")
	{
		$col=sizeof($this->tab[$this->rows]);
		if($col==$this->cols) 
		{
			$this->rows++; 
			$col=0;
		}
		$this->tab[$this->rows][$col]="";
		if($component!=null) 
		{
			$this->tab[$this->rows][$col]["content"]=$component->getComponent();
		}
		$this->tab[$this->rows][$col]["align"]=$align;
		$this->createTable();
				
	}

	function createTable()
	{
		$this->html= '<table class="'.$this->css.'" '.$this->id.' cellpadding="'.$this->cellpadding.'" cellspacing="'.$this->cellspacing.'" border="'.$this->border.'"><tbody>';
		$this->html.=$this->tableHeader;
		
		for ($i=0; $i<= $this->rows; $i++)
		{
			if($this->colorFill)
			{
				if($i%2) 	$color=$this->color1;
				else 		$color=$this->color2;
			}
			else $color="inherit";
			
			if($this->enlighting)
				$this->html.= '<tr style="background-color:'.$color.';" onmouseover="this.style.background=\'#cccccc\';" onmouseout="this.style.background=\''.$color.'\';">';		
			else 
				$this->html.= '<tr style="background-color:'.$color.';">';	
				
			for ($j=0; $j< $this->cols; $j++)
			{
				//if(empty($this->tab[$i][$j]["align"])) $this->tab[$i][$j]["align"]="left";
				$this->html.= '<td align="'.$this->tab[$i][$j]["align"].'">';		
				$this->html.=$this->tab[$i][$j]["content"]; 	
				$this->html.= '</td>';
	  		}
			$this->html.= "</tr>";
		}
		
		$this->html.= '</tbody></table>';
	}
	
	function addTableHeader($tableHeader)
	{
	 	$this->cols=$tableHeader->cols;
	 	$this->tableHeader=$tableHeader->getComponent();		
	} 
}

