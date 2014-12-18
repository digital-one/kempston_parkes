<?php
require_once("classes/phpMailer/class.phpmailer.php");
class email extends phpmailer
{
	function email()
	{
		global $CONF;
		$this->From     = $CONF->get("/configuration/email/from");
		$this->FromName = $CONF->get("/configuration/email/fromName");
		$this->Host     = $CONF->get("/configuration/email/host");
		$this->Mailer   = $CONF->get("/configuration/email/mailer");
		$this->CharSet 	= $CONF->get("/configuration/email/charset");
		$this->SMTPAuth = $CONF->get("/configuration/email/auth");
		$this->Username = $CONF->get("/configuration/email/login");
		$this->Password = $CONF->get("/configuration/email/pass");
		$this->AltBody 	= $CONF->get("/configuration/email/altBody");
	}
	
	function __destruct()
	{
		$this->ClearAddresses();
	}
	
}

?>