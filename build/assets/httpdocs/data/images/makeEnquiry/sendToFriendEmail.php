<?php
class sendToFriendEmail extends templateEngine
{
	function __construct($friends_name,$friends_email,$your_name,$your_email,$productId)
	{
		global $CONF;
		
		$this->friends_name=$friends_name;
		$this->your_name=$your_name;
		$this->your_email=$your_email;
		$this->productId=$productId;
		$this->recipient_email=$friends_email;
		$this->title=$CONF->get("/configuration/shop/productFullView/sendToFriend/emailSubject");
		$this->address=$CONF->get("/configuration/address");
			
		$this->parseTemplate("templates/modules/shop/sendToFriend/sendToFriendEmail.html");
	}
	
}

?>