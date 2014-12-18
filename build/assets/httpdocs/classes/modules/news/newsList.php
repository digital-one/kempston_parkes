<?php
require_once("classes/modules/news/newsPreview.php"); 
require_once("classes/tabela.php"); 
require_once("classes/limit.php"); 

class newsList extends templateEngine
{
	var $limit;
	var $newsy;
	
	function newsList()
	{
		global $DB;
		
		$query="SELECT * FROM news WHERE active=1 AND langId=".LANGID;
		
		$displayOptions[0]["name"]="5";
		$displayOptions[0]["value"]="5";
		$displayOptions[1]["name"]="10";
		$displayOptions[1]["value"]="10";
		$displayOptions[2]["name"]="20";
		$displayOptions[2]["value"]="20";
		
		$tmp=new limit($query,10,"newsDate DESC,id","DESC",$displayOptions);
		//$tmp=new limit($query);
		$this->limit=$tmp->getHtml();
		$rs=$DB->query($tmp->getQuery());
			
		while($tab=$DB->fetch_array($rs)) $t[]=$tab;
		$tmp=new tabela($t,"newsPreview",3);
		$this->newsy=$tmp->getHtml();
		
		$this->parseTemplate("templates/".PREFIX."modules/news/newsList.html");
	}
}
?>