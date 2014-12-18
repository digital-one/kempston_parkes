<?php
class news extends module
{
	function __construct()
	{
		parent::__construct();
		
		global $DB;
		
		$content=new templateEngine();
		
		if(is_numeric($_GET["newsId"]))
		{
			require_once("classes/modules/news/newsFullView.php"); 
			
			$tmp=new newsFullView($_GET["newsId"]);
			if(!empty($tmp->title)) 		$this->title=$tmp->title;
			if(!empty($tab["keywords"]))  	$this->keywords=$tmp->title;
			if(!empty($tab["description"])) $this->description=$tmp->shortDescription;
		}
		else 
		{	
			require_once("classes/modules/news/newsList.php"); 
			$tmp=new newsList();
		}
		
		$content->content=$tmp->getHtml();
		$content->parseTemplate("templates/".PREFIX."modules/news.html");
		
		$this->content=$content->getHtml();
		$this->generateHtml();
	}
}

?>