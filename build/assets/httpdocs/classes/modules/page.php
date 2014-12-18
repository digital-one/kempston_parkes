<?php
require_once("classes/modules/page/parts.php");

class page extends module
{
	function __construct()
	{
		parent::__construct();

		global $DB;
		
		if(!is_numeric($_GET["pageId"])) $_GET["pageId"]=1;
		if(!is_numeric($_GET["part"])) $_GET["part"]=0;
			
		$query="SELECT * FROM page WHERE active=1 AND id=".$_GET["pageId"];
			
		$rs=$DB->query($query);
		$tab=$DB->fetch_array($rs);
		if(!empty($tab["title"])) 	 	$this->title=stripslashes($tab["title"]);
		if(!empty($tab["keywords"])) 	$this->keywords=stripslashes($tab["keywords"]);
		if(!empty($tab["description"])) $this->description=stripslashes($tab["description"]);
			
		$content=preg_split('!<div style="page-break-after: always;?"><span style="display: none;?">&nbsp;</span></div>!i',stripslashes($tab["content"]));
		$parts=new parts(sizeof($content),$_GET["part"]);
				
		$tmp=new templateEngine();
		$tmp->name=stripslashes($tab["name"]);
		$tmp->content=$content[$_GET["part"]];
		$tmp->parts=$parts->getHtml();
		$tmp->parseTemplate("templates/modules/page.html");
		
		$this->content=$tmp->getHtml();
		
		$this->generateHtml();
	}
}

?>