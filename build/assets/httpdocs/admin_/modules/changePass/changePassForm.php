<?php
require_once('./classes/components/form.php');
require_once('./classes/components/table.php');
require_once('./classes/components/label.php');
require_once('./classes/components/password.php');
require_once('./classes/components/button.php');

class changePassForm
{
	var $html;
	
	function changePassForm()
	{
		global $MODULE;
     
		$table=new table();
		$table->addComponent(new label('Old password:'));
		$table->addComponent(new password('oldPass'));
		$table->addComponent(new label('New password:'));
		$table->addComponent(new password('newPass1'));
		$table->addComponent(new label('Retype new password:'));
		$table->addComponent(new password('newPass2'));
		$table->addComponent(null);
		$table->addComponent(new button('save','save&nbsp;&raquo;','onClick="submit();"'),"right");
		
		$form=new form('index.php?moduleId='.$MODULE->moduleId.'&amp;action=change');
		$form->addComponent($table);
		
		$this->html=$form->getComponent();
	}
}
?>