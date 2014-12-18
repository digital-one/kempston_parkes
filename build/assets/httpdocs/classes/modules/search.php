<?php

require_once("classes/limit.php"); 

class search extends module
{
	function __construct()
	{
		global $DB;
		
		parent::__construct();

		
		$tmp=new templateEngine();
		
		$query="
		SELECT * FROM 
		(
			SELECT name, concat('index.php?module=page&pageId=',id) AS link,description AS description FROM page WHERE langId=".LANGID." AND (active=1 AND name LIKE '%".$_GET["text"]."%' OR content LIKE '%".$_GET["text"]."%') 
			UNION
			SELECT title AS name, concat('index.php?module=news&newsId=',id) AS link, shortDescription AS description FROM news WHERE langId=".LANGID." AND (active=1 AND title LIKE '%".$_GET["text"]."%' OR description LIKE '%".$_GET["text"]."%') 
		) AS t ";

		
		$displayOptions[0]["name"]="5";
		$displayOptions[0]["value"]="5";
		$displayOptions[1]["name"]="10";
		$displayOptions[1]["value"]="10";
		$displayOptions[2]["name"]="20";
		$displayOptions[2]["value"]="20";
		
		$tmp=new limit($query,10,"name","ASC",$displayOptions);
		$tmp->limit=$tmp->getHtml();
		
		$rs=$DB->query($tmp->getQuery());
			
		$i=0;
		while($tab=$DB->fetch_array($rs)) 
		{
			$tab['description']=stripslashes($tab['description']);
			$tmp->items[$i]=$tab;
			$i++;
		}
		
		$tmp->parseTemplate("templates/".PREFIX."modules/search.html");
		
		$this->content=$tmp->getHtml();
		
		$this->generateHtml();
	}
}

?>