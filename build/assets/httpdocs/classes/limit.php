<?php

class limit extends templateEngine
{
	var $query;
	
	var $amountHtml;
	var $pagesHtml;
	var $displayHtml;
	var $orderByHtml;
	var $orderHtml;
	
	var $orderBy;
	var $order;
	var $display;
	var $displayPage=5; // 5 w prawo 5 w lewo lacznie 11
	
	var $orderByOptions;
	var $orderOptions;
	var $displayOptions;
	
	var $template;
	
	
	function limit($query,$display=10,$orderBy="position",$order="ASC",$displayOptions=null,$orderByOptions=null,$orderOptions=null)
	{
		$this->template="templates/".PREFIX."limit.html";
		
		$this->query = $query;
		$this->display=$display;
		$this->orderBy=$orderBy;
		$this->order=$order;
		
		$this->orderByOptions=$orderByOptions;
		$this->orderOptions=$orderOptions;
		$this->displayOptions=$displayOptions;
		
		if($this->inarray($_GET["orderBy"],$this->orderByOptions)) 	$this->orderBy=$_GET["orderBy"];
		if($this->inarray($_GET["order"],$this->orderOptions)) 		$this->order=$_GET["order"];
		if($this->inarray($_GET["display"],$this->displayOptions))	$this->display=$_GET["display"];
				
		$this->generate();
		$this->parseTemplate($this->template);		
	}
	
	function generate()
	{
		global $DB;
		global $LINK;
		
		$this->query.=' ORDER BY '.$this->orderBy.' '.$this->order;
					  
		// limit
		if($this->display>0)
		{
			$rs=$DB->query($this->query);
			$this->amount=$DB->num_rows($rs); 
	 
			if($this->amount>0)
			{
				$limit=$_GET["limit"];	 
	 
				if($limit<1) $limit=$this->display;
	 
				$n=ceil($this->amount/$this->display);
				$x=round($limit/$this->display);
     
				$prev=$limit-$this->display;
				if($prev>0)
				$this->pagesHtml='&nbsp;<a href="'.$LINK->getLink("limit=".$prev).'">&laquo;</a>&nbsp;';
	 
				for($i=1;$i<=$n;$i++)
				{
					if((($x-$this->displayPage)<$i) && ($i<($x+$this->displayPage)))
					if($i==$x) 
					{
						$this->pagesHtml.='&nbsp;['.$i.']';
						$this->query.=" LIMIT ".(($i-1)*$this->display).",".$this->display;
					}
					else $this->pagesHtml.='&nbsp;<a href="'.$LINK->getLink("limit=".($i*$this->display)).'">'.$i.'</a>';
				}
			}
	 
			$next=$limit+$this->display;
			if($next<$this->amount+$this->display) $this->pagesHtml.='&nbsp;<a href="'.$LINK->getLink("limit=".$next).'">&raquo;</a>';
	 
			
			/*------------------------ tempalte ---------------------*/
			$this->amountHtml=$this->amount;
						
			if($this->displayOptions!=null)
			{
				$this->displayHtml='<form action="#" style="display:inline;margin:0px;padding:0px;">';
				$this->displayHtml.='<select name="display" onchange="tmp=\''.$LINK->getLink("display=").'\'+this.value;window.location=tmp">';
			
				foreach($this->displayOptions AS $t)
				{
					$this->displayHtml.='<option value="'.$t["value"].'"';
					if($this->display==$t["value"]) $this->displayHtml.=' selected="selected"';
					$this->displayHtml.='>'.$t["name"].'</option>';
				}
			
				$this->displayHtml.='</select>';
				$this->displayHtml.='</form>';
			}
						
			if($this->orderByOptions!=null)
			{
				$this->orderByHtml='<form action="#" style="display:inline;margin:0px;padding:0px;">';
				$this->orderByHtml.='<select name="orderBy" onchange="tmp=\''.$LINK->getLink("orderBy=").'\'+this.value;window.location=tmp" >';
			
				foreach($this->orderByOptions AS $t)
				{
					$this->orderByHtml.='<option value="'.$t["value"].'"';
					if($this->orderBy==$t["value"]) $this->orderByHtml.=' selected="selected"';
					$this->orderByHtml.='>'.$t["name"].'</option>';
				}
			
				$this->orderByHtml.='</select>';
				$this->orderByHtml.='</form>';
			}
			
			if($this->orderOptions!=null)
			{
				$this->orderHtml='<form action="#" style="display:inline;margin:0px;padding:0px;">';
				$this->orderHtml.='<select name="order" onchange="tmp=\''.$LINK->getLink("order=").'\'+this.value;window.location=tmp" >';
			
				foreach($this->orderOptions AS $t)
				{
					$this->orderHtml.='<option value="'.$t["value"].'"';
					if($this->order==$t["value"]) $this->orderHtml.=' selected="selected"';
					$this->orderHtml.='>'.$t["name"].'</option>';
				}
			
				$this->orderHtml.='</select>';
				$this->orderHtml.='</form>';
			}
					
		}
	}
	
	function getQuery()
	{
		return $this->query;
	}
	
	function inarray( $p_needle, $p_haystack )
	{
		if(!is_array($p_haystack)) 			return false;
        if(in_array($p_needle,$p_haystack))	return true;
       
		foreach($p_haystack as $row)
		if($this->inarray($p_needle,$row)) return true;
		         
		return false;
	}
	
}
?>

