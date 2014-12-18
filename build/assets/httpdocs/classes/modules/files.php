<?php
require_once("classes/limit.php"); 

class files extends module
{
	function __construct()
	{
		global $DB;
		global $LINK;
		
		parent::__construct();

		$content=new templateEngine();

		$query="SELECT * FROM files WHERE active=1 AND langId=".LANGID;
				
		$displayOptions[0]["name"]="5";
		$displayOptions[0]["value"]="5";
		$displayOptions[1]["name"]="10";
		$displayOptions[1]["value"]="10";
		$displayOptions[2]["name"]="20";
		$displayOptions[2]["value"]="20";
		
		$tmp=new limit($query,100,"name,id","ASC",$displayOptions);
		$content->limit=$tmp->getHtml();
		
		$rs=$DB->query($tmp->getQuery());
		$i=0;
		while($tab=$DB->fetch_array($rs)) 
		{
			$content->items[$i]["name"]=stripslashes($tab["name"]);
			$content->items[$i]["description"]=stripslashes($tab["description"]);
			$tmp=array_reverse(explode(".",$tab["filename"]));
			$content->items[$i]["ico_name"]=strtolower($tmp[0]);
			$content->items[$i]["ico"]="data/files/ico/".$content->items[$i]["ico_name"].".gif";
			
			if(!is_file($content->items[$i]["ico"])) $content->items[$i]["ico"]="data/files/ico/noIco.gif";
			
			$content->items[$i]["link"]="data/files/file/".$tab["filename"];
			
			$i++;
		}
		$content->parseTemplate("templates/".PREFIX."modules/files.html");
		
		$this->content=$content->getHtml();
		$this->generateHtml();
	}
}

?>