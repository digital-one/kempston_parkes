<?php

class newsPreview extends templateEngine
{
	var $title;
	var $shortDescription;
	var $newsDate;
	var $image;
	var $imageMini;
	var $link;
	
	function newsPreview($tab)
	{
		global $LINK;
		
		$this->title=stripslashes($tab["title"]);
		$this->newsDate=implode("-",array_reverse(explode("-",$tab["newsDate"])));
		$this->shortDescription=stripslashes($tab["shortDescription"]);
		$this->link=$LINK->getLink("newsId=".$tab["id"]);
		
		$this->image='data/news/image/100x75/'.$tab["photo"];
		if(!is_file($this->image)) $this->image="";
		
		$this->parseTemplate("templates/".PREFIX."modules/news/newsPreView.html");
	}
}

?>