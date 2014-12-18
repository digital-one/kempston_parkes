<?php
require_once("modules/defaultController.php");
class newsletter extends defaultController
{
	function __construct()
	{ 
		parent::__construct();
	}
	
	function show()
	{
		if ($_GET['action']=="add")							$this->add(); 
  		else if ($_GET['action']=="edit")					$this->edit(); 
  		else if ($_GET['action']=="save")					$this->save();
		else if ($_GET['action']=="del")					$this->del(); 
		else if ($_GET['action']=="send")					$this->newsletterSend();
		else if ($_GET['action']=="newsletterSendForm")		$this->newsletterSendForm();
		else $this->rowsList();
	}
		
	function newsletterSendForm()
	{
		require_once('./modules/newsletter_send/newsletterSendForm.php');
		$this->title="Send Newsletter";
		$tmp=new newsletterSendForm();
		$this->content=$tmp->html;
		$this->generateHtml();
	}
	
	function newsletterSend()
	{
		global $DB;
		global $LINK;
		global $INFO;
		global $CONF;
		
		require_once('classes/email.php');
		
		$rs=$DB->query("SELECT * FROM newsletter WHERE id=".$_GET["id"]);
		$tab=$DB->fetch_array($rs);
		
		$mail = new email();
		$mail->From     = stripslashes($tab["fromEmail"]);
		$mail->FromName = stripslashes($tab["fromName"]);
		$mail->Subject  = stripslashes($tab["title"]);
		$mail->Priority = stripslashes($tab["priority"]);
		$content=stripslashes($tab["content"]);
		
		
		$file="../data/newsletter/file/".$tab["attachment"];
		
		if(is_file($file))
		{	
			$mail->AddStringAttachment(@file_get_contents($file),$tab["attachment"]);
		}
			
	
		$query="SELECT DISTINCT email FROM newsletter_email WHERE active=1 AND groupId IN (SELECT groupId FROM newsletter_group_send WHERE newsletterId=".$tab["id"].")";
		
		
		$i=0;
		$rs=$DB->query($query);
		while($tab=$DB->fetch_array($rs)) 
		{
			$mail->ClearAllRecipients();
			
			$mail->Body='<html>
           	<head>
				<title>'.$mail->Subject.'</title>
				<meta http-equiv="content-type" content="text/html; charset=utf-8" />
			</head>
			<body>'.$content.'
			<hr />
			If You don\'t want to receive our newsletter please click 
			<a href="'.$CONF->get("/configuration/address").'index.php?module=newsletter&action=unsubscribe&email='.md5($tab["email"]).'">unsubscribe</a>.
			</body>
			</html>';
			
			$mail->AddAddress($tab["email"],$tab["email"]);
			@$mail->send();
			$i++;
		}

		
		$INFO->setInfo('Newlsetter sent to '.$i.' person(s).<br />',"info");
		
		header("Location: ".($LINK->getLink("","action")));
	}
	
	
	
	
	
	
}

?>