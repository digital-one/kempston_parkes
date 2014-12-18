<?php
require_once("classes/limit.php"); 

class galleryList extends templateEngine
{
	var $limit;
	var $gallery;
	var $imgDir='data/gallery/image/350x200/';
	
	function galleryList()
	{
		global $DB;
		GLOBAL $LINK;
		
		$query="SELECT * FROM gallery WHERE active=1 AND langId=".LANGID;
	
		$displayOptions[0]["name"]="4";
		$displayOptions[0]["value"]="4";
		$displayOptions[1]["name"]="8";
		$displayOptions[1]["value"]="8";
		$displayOptions[2]["name"]="16";
		$displayOptions[2]["value"]="16";
		
		$tmp=new limit($query,$displayOptions[0]["name"],"position,title","ASC",$displayOptions);
		
		$this->limit=$tmp->getHtml();
		$rs=$DB->query($tmp->getQuery());
			
		while($tab=$DB->fetch_array($rs)) 
		{
			$tab["photo"]=$this->imgDir.$tab["photo"];
			$tab["name"]=stripslashes($tab["name"]);
			$tab["description"]=stripslashes($tab["description"]);
			$tab["link"]=$LINK->getLink("galleryId=".$tab["id"]);
			$this->items[]=$tab;
		}
		
		$this->parseTemplate("templates/modules/gallery/galleryList.html");
	}
}
?>