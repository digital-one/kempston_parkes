<?php

class menu extends templateEngine
{
	var $items;
	var $num=0;
	var $root=0;
	
	function __construct($root=0)
	{
		global $CONF;
		$this->root=$root;
		$this->content=$this->branch($this->root);
		$this->parseTemplate("templates/menu.html");
	}
		
	function branch($id=0)
	{
		global $DB;
		$tmp=new  templateEngine();
		
		$rs=$DB->query("SELECT * FROM menu WHERE langId=".$_SESSION['langId']." AND display=1 AND parentId=".$id." ORDER BY position ASC , id DESC");
		
		while($tab=$DB->fetch_array($rs))
		{
			$tab["name"]=stripslashes($tab["name"]);
						
			if($tmp->selectedId==$tab["id"]) $tab["selected"]='id="selectedMenuItem"';
			
			$tab["active"]=$tab["active"];
			$tab["url"]=stripslashes($tab["url"]);
			
			$tab["sublevel"]=$this->branch($tab["id"]);
			
			$tmp->items[]=$tab;
			
		}

		return $tmp->parseTemplate("templates/menu/level.html");
	}
	

	
	
}
	
?>