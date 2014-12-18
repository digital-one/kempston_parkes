<?php

class newsFullView extends templateEngine
{
	var $title;
	var $shortDescription;
	var $description;
	var $newsDate;
	var $img;
	var $imgMini;
	var $back;
	
	function newsFullView($id)
	{
		global $LINK;
		global $DB;;
		
		$rs=$DB->query("SELECT * FROM news WHERE active=1 AND id=".$id);
		
		$tab=$DB->fetch_array($rs);
			
		
		$this->title=stripslashes($tab["title"]);
		$this->newsDate=implode("-",array_reverse(explode("-",$tab["newsDate"])));
		$this->shortDescription=stripslashes($tab["shortDescription"]);
		$this->description=stripslashes($tab["description"]);
		$this->back=$LINK->getLink("","newsId");
		
		if(is_file('data/news/image/100x75/'.$tab["photo"])) 
		{
			
			$this->imgBig='data/news/image/'.$tab["photo"];
			$this->imgMini='data/news/image/100x75/'.$tab["photo"];
		}
		$this->parseTemplate("templates/".PREFIX."modules/news/newsFullView.html");
	
		
	}
}

?>