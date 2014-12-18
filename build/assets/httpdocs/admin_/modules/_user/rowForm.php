<?php
require_once('./classes/components/form.php');
require_once('./classes/components/table.php');
require_once('./classes/components/label.php');
require_once('./classes/components/text.php');
require_once('./classes/components/textArea.php');
require_once('./classes/components/button/save.php');
require_once('./classes/components/button/back.php');
require_once('./classes/components/select.php');
require_once('./classes/components/checkbox.php');
require_once('./classes/components/imageMini.php');
require_once('./modules/_user/modules.php');

class rowForm
{
	var $html;
	
	function rowForm($data=null)
	{
		global $LINK;
		
		$postCode=new table();
		$postCode->addComponent(new text('postCode1',$data['postCode1'],'style="width:100px;"'));
		$postCode->addComponent(new text('postCode2',$data['postCode2'],'style="width:100px;"'));

		$table=new table();
		$table->addComponent(new label('Active:'));
		$table->addComponent(new checkbox('active',$data['active']));
		$table->addComponent(new label('Login:'));
		$table->addComponent(new text('login',$data['login']));
		$table->addComponent(new label('Pass:'));
		$table->addComponent(new text('pass',$data['pass']));
		$table->addComponent(new label('Last login'));
		$table->addComponent(new label($data["lastLogin"]));
		$table->addComponent(new label('IP address'));
		$table->addComponent(new label($data["ip"]));
		
		$table->addComponent(new label('Name:'));
		$table->addComponent(new text('name',$data['name']));
		$table->addComponent(new label('Description:'));
		$table->addComponent(new textArea('description',$data['description']));
		
		$table->addComponent(new label('Modules:'));
		$table->addComponent(new modules('modules',$data["id"]));
		
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