<?php

class opinionPole extends templateEngine
{
	
	function __construct() 
	{
		global $DB;
		global $PORTALID;
		
		if(!is_numeric($_GET["opinionPoleId"]))
		{
			$query="SELECT o.id,o.title,o.multiselection FROM opinion_pole AS o WHERE o.active=1 AND langId=".LANGID." ORDER BY rand() LIMIT 1";
		}
		else 
		{
			$query="SELECT o.id,o.title,o.multiselection FROM opinion_pole AS o WHERE o.active=1 AND o.id=".$_GET["opinionPoleId"]." LIMIT 1";
		}
		
		$rs=$DB->query($query);
		$tab=$DB->fetch_array($rs);
		$this->query=stripslashes($tab["title"]);
		
		if($_GET["action"]=="vote") 
		{
			$this->vote($tab["id"]);
		}
		
		if(($_GET["action"]=="results") || ($this->voted($tab["id"]))) 
		{
			$tmp=$this->results($tab["id"]);
		}
		else 
		{
			$tmp=$this->answers($tab["id"],$tab["multiselection"]);
		}
		$this->content=$tmp;
				
		$this->parseTemplate("templates/".PREFIX."opinionPole.html");
	
	}
	
	function voted($id=0)
	{
		$ret=false;
		
		if(is_array($_COOKIE["opinionPoleVoted"]))
		{
			foreach($_COOKIE["opinionPoleVoted"] as $poleId) 
			if($id==$poleId) 
			{
				$ret=true; 
				break;
			}
		}
		
		
		return $ret;
	}
	
	function answers($id=0,$multiselection=true)
	{
		global $DB;
		global $LINK;
		
		
		$tmp=new templateEngine();
		
		if($multiselection) $tmp->type="checkbox";
		else $tmp->type="radio";
		if(is_numeric($id))
		$rs=$DB->query("SELECT * FROM opinion_pole_answers WHERE opinionId=".$id." ORDER BY position ASC");
		$i=0;
		while($tab=$DB->fetch_array($rs)) 
		{
			$tmp->items[$i]['id']=$tab["id"];
			$tmp->items[$i]['answer']=stripslashes($tab["answer"]);
			$i++;
		}
		$tmp->action=$LINK->getLink("action=vote&opinionPoleId=".$id);
		$tmp->results=$LINK->getLink("action=results&opinionPoleId=".$id);
		$tmp->parseTemplate("templates/".PREFIX."opinionPole/answers.html");
		
		return $tmp->getHtml();
	}
	
	function results($id=0)
	{
		global $DB;
		
		$tmp=new templateEngine();
		$rs=$DB->query("SELECT sum(votes) AS votes FROM opinion_pole_answers WHERE opinionId=".$id);
		$tab=$DB->fetch_array($rs);
		$tmp->votes=$tab["votes"];
		$percent=100/$tmp->votes;
		$pixel=2;
		
		$rs=$DB->query("SELECT * FROM opinion_pole_answers WHERE opinionId=".$id." ORDER BY position ASC");
		$i=0;
		while($tab=$DB->fetch_array($rs)) 
		{
			$tmp->items[$i]['votes']=$tab["votes"];
			$tmp->items[$i]['percent']=round($percent*$tab["votes"]);
			$tmp->items[$i]['width']=$tmp->items[$i]['percent']*$pixel;
			$tmp->items[$i]['answer']=stripslashes($tab["answer"]);
			$i++;
		}
		$tmp->parseTemplate("templates/opinionPole/results.html");
		
		return $tmp->getHtml();
		
	}
	
	function vote($poleId)
	{
		global $DB;
		global $LINK;
		
		if(is_array($_POST["answers"]))
		{
			foreach($_POST["answers"] as $id)
			$DB->query("UPDATE opinion_pole_answers SET votes=votes+1 WHERE id=".$id);
		}
		$i=0;	
		foreach($_COOKIE["opinionPoleVoted"] as $id) 
		{
			setcookie("opinionPoleVoted[".$i."]",$id,time()+3600*24*30*3);	
			$i++;
		}
		setcookie("opinionPoleVoted[".$i."]",$poleId,time()+3600*24*30*3);
		
		header("Location: ".$LINK->getLink("action=results","",false));
	}
		
}

?>