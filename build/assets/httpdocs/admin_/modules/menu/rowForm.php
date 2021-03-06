<?php
require_once('./classes/components/form.php');
require_once('./classes/components/table.php');
require_once('./classes/components/label.php');
require_once('./classes/components/text.php');
require_once('./classes/components/textArea.php');
require_once('./classes/components/formattedTextArea.php');
require_once('./classes/components/button/save.php');
require_once('./classes/components/button/back.php');
require_once('./classes/components/select.php');
require_once('./classes/components/tabbedPane.php');
require_once('./classes/components/checkbox.php');
require_once('./classes/components/image.php');
require_once('./classes/components/treeSelect.php');

class rowForm
{
	var $html;
	
	function rowForm($data=null)
	{
		global $LINK;
		
		$tp=new tabbedPane();
		
		$form=new form($LINK->getLink("action=save"));
		$table=new table();
		$table->addComponent(new label('Language:'));
		$table->addComponent(new select('langId',$data['langId'],'_lang','name'));
		$table->addComponent(new label('Menu position:'));
		$table->addComponent(new treeSelect("parentId",$_GET['parentId'],"menu","name"));
		$table->addComponent(new label('Name:'));
		$table->addComponent(new text('name',$data['name']));
		
		$table->addComponent(new label('URL:'));
		$table->addComponent(new text('url',$data['url']));

		
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
		$form->addComponent($table);
		
		$tp->addComponent($form,"Basic");
		
	
		
		$this->html=$tp->getComponent();
	}
}

?>