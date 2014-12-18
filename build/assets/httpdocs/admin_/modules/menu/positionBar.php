<?php
require_once('./classes/component.php');
class positionBar extends component
{
	function positionBar($id=0)
	{
		global $DB;
		global $LINK;
		
		$first=1;
		if(!is_numeric($id)) $id=0;
		if($id>0)
		{
			do
			{ 
				$rs=$DB->query("SELECT * FROM menu WHERE id=".$id);
				while($tab=$DB->fetch_array($rs)) break;
				$tmp=$menu;
				$menu='<a class="defaultLink" href="'.$LINK->getLink("parentId=".$this->parentId($tab["id"])).'">'.$tab["name"].'</a>';
		 
				if($first!=1) $menu.='&nbsp;&nbsp;&raquo;&nbsp;&nbsp;';
				else 
				{
					$menu.=' : ';
					$first=0;
				}
				$menu.=$tmp;
  			  
				$id=$this->parentId($id);
			}
			while($id!=0); 
		}
					  
		if(!empty($menu)) $this->html.='<div class="defaultLink">'.$menu.'</div><br />';
	}
 
	function parentId($id)
	{
		global $DB;
		global $MODULE;
		$rs=$DB->query("SELECT parentId FROM menu WHERE id=".$id);
		while($tab=$DB->fetch_array($rs)) break;
		return $tab["parentId"];
	} 
	
}

?>