<?php
class menu
{
	var $html;
	var $level=0;
	
	function __construct()
	{
		 $this->branch();
	}
	
	function branch($parentId=0)
	{
		global $DB;
		global $USER;
		$first=true;
		
		$query="SELECT m.* FROM _module AS m,_user_module AS um WHERE m.active=1 AND m.id=um.moduleId AND um.userId=".$USER->id." AND m.parentId=".$parentId." ORDER BY m.position ASC";
		 
		$this->level++;
		
		$rs = $DB->query($query);
		while($tab=$DB->fetch_array($rs))
		{
			if(!$first) $this->html.=",\n_cmSplit,\n";
			else 
			{
				$first=false;
				if($this->level>1) $this->html.=",";
			}
				
			if($tab["label"]) $link="null";
			else $link="'index.php?moduleId=".$tab["id"]."'";
				
			$this->html.="['', '".$tab["name"]."', ".$link.", '_self', '".$tab["name"]."'";
			$this->branch($tab["id"]);
			$this->html.="]";
			
		}
		
		$this->level--;
	}
	
}
?>