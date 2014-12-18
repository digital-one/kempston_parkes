<?php
require_once('./classes/components/form.php');
require_once('./classes/components/table.php');
require_once('./classes/components/label.php');
require_once('./classes/components/button/back.php');

class rowForm
{
	var $html;
	
	function rowForm($data=null)
	{
		global $LINK;
		
	
		$table=new table();
		$table->addComponent(new label('To:'));
		$table->addComponent(new label($data['email']));
		$table->addComponent(new label('Send Date:'));
		$table->addComponent(new label($data['sendDate']));
		$table->addComponent(new label('MSG:'));
		
		eregi("<body[^>]*>(.*)</body>",$data['msg'],$body);
		
		$table->addComponent(new label($body[0]));
		$table->addComponent(null);
		$table->addComponent(new back(),"right");
		
		$form=new form($LINK->getLink("action=save"));
		$form->addComponent($table);
		
	
		$this->html=$form->getComponent();
	}
}

?>