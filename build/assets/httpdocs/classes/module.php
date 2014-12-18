<?php

require_once("classes/menu.php");

class module extends templateEngine
{
	var $title;
	var $name;
	var $keywords;
	var $description;
	var $content;
	var $info;
	
	function __construct()
	{
		global $INFO;
		global $LINK;
		global $CONF;
		global $DB;
		
		$this->title=$CONF->get("/configuration/".PREFIX."title");
		$this->keywords=$CONF->get("/configuration/".PREFIX."keywords");
		$this->description=$CONF->get("/configuration/".PREFIX."description");
		$this->info=$INFO->getInfo();
		
		$tmp=new menu();		
		$this->menu=$tmp->getHtml();
	
	}
	
	function generateHtml()
	{
		$this->parseTemplate("templates/".PREFIX."main.html");
		print($this->getHtml());
	}
}

?>