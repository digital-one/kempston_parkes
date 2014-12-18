<?php

class linkManager
{
	var $link;
	var $amp;
	
	function linkManager()
	{
	}
	
	function getLink($addParams=null,$delParams=null,$amp=true)
	{
		$_SERVER["REQUEST_URI"]=str_replace("&amp;","&",$_SERVER["REQUEST_URI"]);
		$link=parse_url($_SERVER["REQUEST_URI"]);
		$this->link=$link["path"];
		$this->amp=$amp;
		if(!empty($link["query"])) $this->link.="?".$link["query"];
		
		//usuwanie
		
		if($delParams!=null)
		{
			if(strpos($this->link,"?")>0)
			{
				list($script,$params)=explode("?",$this->link);
				$this->link=$script;
				$tmp=explode("&",$params);
				
				$j=0;
				foreach($tmp as $row)
				{
					list($p[$j],$v[$j])=explode("=",$row);
					$j++;
				}
				
				
				$tab=explode("&",$delParams);
				$size=sizeof($tab);
				
				for($i=0;$i<$j;$i++)
				{
					$found=false;
					for($n=0;$n<$size;$n++)
					if($p[$i]==$tab[$n]) 
						{
							$found=true; 
							break;
						}
						
					if(!$found)
					{
						if(strpos($this->link,"?")>0) $this->link.="&".$p[$i]."=".$v[$i];
						else $this->link.="?".$p[$i]."=".$v[$i];
					}
				}
				
			}
		}
		
	
		//dodawanie
		if($addParams!=null)
		{
			unset($param);
			unset($value);
			list($script,$params)=explode("?",$this->link);
			$this->link=$script;
			$tab=explode("&",$params);
			foreach($tab as $val) list($param[],$value[])=explode("=",$val);
			
			
			//co mamy dodac
			$size=sizeof($param);
			$tab=explode("&",$addParams);
			
			foreach($tab as $val) 
			{
				list($p,$v)=explode("=",$val);
				
				$found=false;
				for($i=0;$i<$size;$i++)
				{
					if($param[$i]==$p)
					{
						$value[$i]=$v;
						$found=true;
						break;
					}
				}				
				if(!$found)
				{
					$param[$size]=$p; 
					$value[$size]=$v;
					$size++;
				}
				
			}
			
			for($i=0;$i<$size;$i++)
			{
				if(!empty($param[$i]))
				{
					if(strpos($this->link,"?")>0) $this->link.="&".$param[$i]."=".$value[$i];
					else $this->link.="?".$param[$i]."=".$value[$i];
				}
			}
			
			
		}
		
		//return $this->link;
		if($this->amp)
			return str_replace("&","&amp;",$this->link);
		else
			return $this->link;
	}
	
	function getReferer($amp=true)
	{
		$ret=$_SERVER["HTTP_REFERER"];
		return $ret;
		
		if($amp)
			return str_replace("&","&amp;",$ret);
		else
			return $ret;
	}
}

?>