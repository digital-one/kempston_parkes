<?php

class parts extends templateEngine
{
	public $num=0;
	public $pervious;
	public $next;
	public $parts;
	
	function __construct($num,$current)
	{
		global $LINK;
		if(is_numeric($num)) $this->num=$num;
		
		if($this->num>1) 
		{
			if($current-1>=0) $this->previous=$LINK->getLink("part=".($current-1));
			
			if($current+1<($this->num)) $this->next=$LINK->getLink("part=".($current+1));
			
			for($i=0;$i<$this->num;$i++) 
			{
				if($current==$i) $this->parts.=' ['.($i+1).'] ';
				else $this->parts.=' <a href="'.$LINK->getLink("part=".$i).'">'.($i+1).'</a> ';
			}
			
			$this->parseTemplate("templetes/modules/page/parts.html");
		}
	}
}

?>