<?php
class gallery extends module
{
	function __construct()
	{
		parent::__construct();
		
		global $DB;
		global $LINK;
		
		$content=new templateEngine();
		
		if(is_numeric($_GET["galleryId"]))
		{
			require_once("classes/modules/gallery/galleryFullView.php"); 
			$tmp=new galleryFullView($_GET["galleryId"]); 
			
			if(!empty($tmp->title)) 		$this->title=$tmp->title;
			if(!empty($tab["keywords"]))  	$this->keywords=$tmp->keywords;
			if(!empty($tab["description"])) $this->description=$tmp->description;
		}
		else 
		{	
			require_once("classes/modules/gallery/galleryList.php"); 
			$tmp=new galleryList();
		}
		
		$content->content=$tmp->getHtml();
		$content->parseTemplate("templates/".PREFIX."modules/gallery.html");
		
		$this->content=$content->getHtml();
		$this->generateHtml();
	}
}

?>