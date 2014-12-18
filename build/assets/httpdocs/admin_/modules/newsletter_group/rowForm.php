<?php
require_once('./classes/components/form.php');
require_once('./classes/components/table.php');
require_once('./classes/components/label.php');
require_once('./classes/components/checkbox.php');
require_once('./classes/components/button/save.php');
require_once('./classes/components/button/back.php');
require_once('./classes/components/text.php');

class rowForm
{
	var $html;
	
	function rowForm($data=null)
	{
		global $LINK;
		
		$table=new table();

		$table->addComponent(new label('Name:'));
		$table->addComponent(new text('name',$data['name']));
		
		$table->addComponent(new label('Created'));
		$table->addComponent(new label($data["created"]));
		$table->addComponent(new label('Created by'));
		$table->addComponent(new label($data["createdBy"]));
		$table->addComponent(new label('Modified'));
		$table->addComponent(new label($data["modified"]));
		$table->addComponent(new label('Modified by'));
		$table->addComponent(new label($data["modifiedBy"]));
		$table->addComponent(new back());
		$table->addComponent(new save(),"right");
		
		$form=new form($LINK->getLink("action=save"));
		$form->addComponent($table);
		
		$this->html=$form->getComponent();
	}
}

?>