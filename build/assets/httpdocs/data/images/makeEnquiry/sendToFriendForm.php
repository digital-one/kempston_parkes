<?php

class sendToFriendForm extends templateEngine
{
	function sendToFriendForm()
	{
		$this->productId=$_GET["productId"];	
		$this->friends_name=$_SESSION["POST"]["friends_name"];		
		$this->friends_email=$_SESSION["POST"]["friends_email"];
		$this->your_name=$_SESSION["POST"]["your_name"];		
		$this->your_email=$_SESSION["POST"]["your_email"];
		$this->parseTemplate("templates/modules/shop/sendToFriend/sendToFriendForm.html");
	}
}

?>