<?php
require_once("classes/email.php");
require_once("classes/validator.php");

class form extends module
{
	function __construct()
	{
		parent::__construct();
		
		global $DB;
		global $INFO;
		global $CONF;
		
		if(!is_numeric($_GET["formId"])) exit();
		$query="SELECT * FROM form WHERE id=".$_GET["formId"]." AND langId=".LANGID;
		$rs=$DB->query($query);
		$tab=$DB->fetch_array($rs);
		
					
		if($_GET["action"]=="send")
		{
			$val=new validator();
			
			$sendLimit=$CONF->get("/configuration/form/sendLimit");
			$expire=time()-(3600*24*30*3); //$CONF->get("/configuration/form/expire");
			$rs=$DB->query("SELECT ip FROM form_history WHERE ip='".$_SERVER["REMOTE_ADDR"]."' AND sendDate>'".date("Y-m-d H:i:s",$expire)."'");
			if($DB->num_rows($rs)>=$sendLimit)	$val->verifyText("",1,$CONF->get("/configuration/form/sendLimitInfo"));
			
			if(($tab["token"]) && ($_POST["token_code"]!=$_SESSION["token_code"])) $val->verifyText("",1,$CONF->get("/configuration/form/incorrectImageToken"));
			
			foreach($_POST AS $k=>$v) 
			{
				$_POST[$k]=addslashes(strip_tags($v));
				
				if(!empty($_POST[$k."_"]))
				{
					if(!is_array($v))
					$val->verifyText($_POST[$k],1,$_POST[$k."_"]);
				}
				else if(!empty($_POST[$k."_email"]))  
				{
					$val->verifyEmail($_POST[$k],$_POST[$k."_email"]);
				}
				else if(!empty($_POST[$k."_text"]))  
				{
					$val->verifyText($_POST[$k],1,$_POST[$k."_text"]);
				}
				
				if( (!preg_match('!_$!',$k)) && (!preg_match('!_text$!',$k)) && (!preg_match('!_email$!',$k)) && (!preg_match('|!$|',$k)) && (!preg_match('!_x$!',$k)) && (!preg_match('!_y$!',$k)))
				if(!is_array($v))
					$msg.='<tr><td class="name">'.$k.'</td><td>'.$v.'</td></tr>';
				else
				{
					$msg.='<tr><td class="name">'.$k.'</td><td>';
					
					foreach($v AS $item)
					$msg.=$item."<br />";
					
					$msg.='</td></tr>';
				}
				
			}
			
			if($val->validate())
			{
				require_once("classes/modules/form/mailBody.php");
				$mail = new email();
				$mail->Subject=stripslashes($tab["name"]);
				$tmp=new mailBody($msg);
				$mail->Body=$tmp->getHtml();
				
				$emls=explode(";",$tab["email"]);
				foreach($emls as $eml)
				{
					$eml=trim($eml);
					$mail->AddAddress($eml,$eml);
				}
				
				$date=date("Y-m-d H:i:s");
				$DB->query("INSERT INTO form_history (formId,sendDate,email,msg,created,createdBy,ip) VALUES ('".$_GET["formId"]."','".$date."','".$tab["email"]."','".addslashes($tmp->getHtml())."','".$date."','form processing system','".$_SERVER["REMOTE_ADDR"]."') ");
				
				if(!$mail->Send())
				{ 
					$tmp=$CONF->get("/configuration/form/error");
					if($tmp) $INFO->setInfo($tmp,"error");
				}
				else 
				{
					$tmp=stripslashes($tab["sendInfo"]);
					if($tmp) $INFO->setInfo($tmp);
				}
								
				unset($_SESSION["FORM_POSTED_DATA"]);
			}
			else 
			{
				$_SESSION["FORM_POSTED_DATA"]=$_POST;
				$INFO->setInfo($val->error(),"error");

			}
			
			//header("Location: index.php?module=form&formId=".$_GET["formId"]);
			header("Location: ".$_SERVER["HTTP_REFERER"]);
		}
		else
		{
			if(!empty($tab["title"])) 	 	$this->title=stripslashes($tab["title"]);
			if(!empty($tab["keywords"])) 	$this->keywords=stripslashes($tab["keywords"]);
			if(!empty($tab["description"])) $this->description=stripslashes($tab["description"]);
			
			$tmp=new templateEngine();			
			$tmp->name=stripslashes($tab["name"]);
			$tmp->content='<form action="index.php?module=form&amp;formId='.$tab["id"].'&amp;action=send" method="post">';
			
			$form=stripslashes($tab["content"]);
			
			if(is_array($_SESSION["FORM_POSTED_DATA"]))
			foreach($_SESSION["FORM_POSTED_DATA"] AS $k=>$v)
			{
				if(empty($v)) continue;
				if(preg_match('|<input[^>]*name="'.$k.'"[^>]*/>|is',$form,$regs))
				{
					$regs[0]=preg_replace('|value="[^"]*"|','',$regs[0]);
					$regs[0]=preg_replace('|/>|','value="'.$v.'" />',$regs[0]);
					$form=preg_replace('|<input[^>]*name="'.$k.'"[^>]*/>|is',$regs[0],$form);
				}
				else if(preg_match('|<input[^>]*name="'.$k.'"[^>]*/>|is',$form,$regs))
				{
					$regs[0]=preg_replace('|value="[^"]*"|','',$regs[0]);
					$regs[0]=preg_replace('|/>|','value="'.$v.'" />',$regs[0]);
					$form=preg_replace('|<input[^>]*name="'.$k.'"[^>]*/>|is',$regs[0],$form);
				}
				else if(preg_match('|<textarea[^>]*name="?'.$k.'"?[^>]*></textarea>|is',$form,$regs))
				{
					$tmp2=preg_replace('|><|','>'.$v.'<',$regs[0]);
					$form=preg_replace('|<textarea[^>]*name="?'.$k.'"?[^>]*></textarea>|is',$tmp2,$form);
				}
				else if(preg_match('|<select[^>]*name="?'.$k.'"?[^>]*>[^{</select>}]*</select>|is',$form,$regs))
				{
					//$tmp=preg_replace('|selected="?selected"?|','',$regs[0]);
					//$form=preg_replace('|<select[^>]*name="?'.$k.'"?[^>]*>[^{</select>}]*</select>|is',$tmp,$form);
				}
			}	

			unset($_SESSION["FORM_POSTED_DATA"]);
			
			$tmp->content.=$form;
			$tmp->content.='</form>';
			$tmp->parseTemplate("templates/modules/form.html");
			
			$this->content=$tmp->getHtml();
			$this->generateHtml();
		}
	}
}

?>