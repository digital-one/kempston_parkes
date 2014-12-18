<?php
require_once("classes/opinionPole.php");

class mainPage extends module
{
	function __construct()
	{
		global $DB;
		global $LINK;
		
		parent::__construct();
		
		if(!is_numeric($_GET["pageId"])) $_GET["pageId"]=1;
		$query="SELECT * FROM page WHERE active=1 AND id=".$_GET["pageId"];
			
		$rs=$DB->query($query);
		$tab=$DB->fetch_array($rs);
						
		if(!empty($tab["title"])) 	 	$this->title=stripslashes($tab["title"]);
		if(!empty($tab["keywords"])) 	$this->keywords=stripslashes($tab["keywords"]);
		if(!empty($tab["description"])) $this->description=stripslashes($tab["description"]);
				
		$tmp=new templateEngine();
		$tmp->name=stripslashes($tab["name"]);
		$tmp->content=stripslashes($tab["content"]);
								
		$rs=$DB->query("SELECT * FROM news WHERE active=1 AND main=1 AND langId=".LANGID." ORDER BY newsDate DESC");
		$i=0;
		while($tab=$DB->fetch_array($rs)) 
		{
			$tmp->items[$i]["title"]=stripslashes($tab["title"]);
			$tmp->items[$i]["newsDate"]=implode("-",array_reverse(explode("-",$tab["newsDate"])));
			$tmp->items[$i]["shortDescription"]=stripslashes($tab["shortDescription"]);
			$tmp->items[$i]["link"]="news.html?newsId=".$tab["id"];
		
			$tmp->items[$i]["image"]='data/news/image/100x75/'.$tab["photo"];
			if(!is_file($tmp->items[$i]["image"])) $tmp->items[$i]["image"]="";
			
			$i++;
		}
		
		$opinionPole=new opinionPole();
		$tmp->opinionPole=$opinionPole->getHtml();

		
		$tmp->parseTemplate("templates/".PREFIX."modules/mainPage.html");
		
		$this->content=$tmp->getHtml();
		$this->generateHtml();
	}
}

?>