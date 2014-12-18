<?php

class query 
{
	var $sql;
	var $text;
	var $text2=" Page: ";
	var $html;
	var $amount;
	
	function query($query,$orderBy=1,$order="ASC",$ilosc_na_stronie=10,$text="Amount: ")
	{
		global $DB;
		global $LINK;
		
		$this->text = $text;
		$this->sql = $query;
		
		//filtrowanie 
		if((!empty($_GET['filter'])) && (!empty($_GET['filterOperator'])) && (!empty($_GET['filterValue'])) )
		{
			if		($_GET['filterOperator']=="1") $this->sql.=" AND LOWER(`".$_GET['filter']."`) LIKE LOWER('%".$_GET['filterValue']."%')";
			else if	($_GET['filterOperator']=="2") $this->sql.=" AND `".$_GET['filter']."` > '".$_GET['filterValue']."'";
			else if	($_GET['filterOperator']=="3") $this->sql.=" AND `".$_GET['filter']."` < '".$_GET['filterValue']."'";
		}
		
		// sortowanie, uwaga tu ustawiany jest sort domyslny
		if(empty($_GET['orderBy']))	$_GET['orderBy']=$orderBy;
		if(empty($_GET['order']))	$_GET['order']=$order;
		$this->sql.=" ORDER BY ".$_GET['orderBy']." ".$_GET['order'];
			  
		// limit
		if($ilosc_na_stronie>0)
		{
			$rs=$DB->query($this->sql);
			$ilosc=$DB->num_rows($rs); 
			$this->amount=$ilosc;
     
			$this->html='<div class="defaultQuery">'.$this->text.$ilosc;
			
			if($ilosc>0)
			{
				$this->html.=$this->text2;
			}
			
			if($ilosc>0)
			{
				$limit=$_GET["limit"];	 
	 
				if($limit<1) 
				{
					$limit=$ilosc_na_stronie;
				}
	 
				$n=ceil($ilosc/$ilosc_na_stronie);
				$x=round($limit/$ilosc_na_stronie);
     
				$prev=$limit-$ilosc_na_stronie;
				if($prev>0)
				{
					$this->html.=' <a class="defaultQuery" href="'.$LINK->getLink("limit=".$prev).'">&laquo;</a> ';
				}
	 
				for($i=1;$i<=$n;$i++)
				if($i==$x) 
				{
					$this->html.=' ['.$i.']';
					$this->sql.=" LIMIT ".(($i-1)*$ilosc_na_stronie).",".$ilosc_na_stronie;
				}
				else
				{				
					$this->html.=' <a class="defaultQuery" href="'.$LINK->getLink("limit=".($i*$ilosc_na_stronie)).'">'.$i.'</a> ';
				}
			}
	 
			$next=$limit+$ilosc_na_stronie;
			if($next<$ilosc+$ilosc_na_stronie) 
			{
				$this->html.=' <a class="defaultQueryObject" href="'.$LINK->getLink("limit=".$next).'">&raquo;</a> ';
			}
	 
			$this->html.='</div>';
		}
		
	}
	
	function getQuery()
	{
		return $this->sql;
	}
		
	function getComponent()
	{
		return $this->html;
	}
}
?>

