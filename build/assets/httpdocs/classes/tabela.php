<?php

class tabela
{
 private $ilosc_kolumn;
 public $html;
 
 function __construct($tab,$object,$cols=1)
  {
    $this->ilosc_kolumn=$cols;
	
	$procent=round(100/$this->ilosc_kolumn);
	
	$this->html='<table border="0" width="100%" cellpadding="0" cellspacing="0"><tr>';
	
	$i=1;
	$size=sizeof($tab);
	for($x=0;$x<$size;$x++)
	{
	  $this->html.='<td align="left" valign="top" width="'.$procent.'%">';

	  $tmp=new $object($tab[$x]);
	  $this->html.=$tmp->getHtml();

	  $this->html.='</td>';
      
	  if(($i==$this->ilosc_kolumn) && ($x!=($size-1)))
	  {
		$i=1;
		$this->html.='</tr><tr>';
	  }
	  else $i++;
	
	}
   //uzupelniamy do ilosci
   for($j=0;$j<$this->ilosc_kolumn-$i;$j++)   $this->html.='<td valign="top" width="'.$procent.'%"></td>';
   $this->html.='</tr></table>';
   
  }
  
  function getHtml()
  {
	return $this->html;
  }
}

?>