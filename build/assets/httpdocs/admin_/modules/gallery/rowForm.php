<?php
require_once('./classes/components/form.php');
require_once('./classes/components/table.php');
require_once('./classes/components/label.php');
require_once('./classes/components/text.php');
require_once('./classes/components/textArea.php');
require_once('./classes/components/formattedTextArea.php');
require_once('./classes/components/button/save.php');
require_once('./classes/components/button/back.php');
require_once('./classes/components/image.php');
require_once('./classes/components/calendar.php');
require_once('./classes/components/select.php');


class rowForm
{
	var $html;
	
	function rowForm($data=null)
	{
		global $LINK;
		
		$table=new table();
		$table->addComponent(new label('Language:'));
		$table->addComponent(new select('langId',$data['langId'],'_lang','name'));
		$table->addComponent(new label('Name:'));
		$table->addComponent(new text('name',$data['name']));
		
		
		$table->addComponent(new label('Gallery Photo:'));
		$table->addComponent(new image('photo',$data['photo'],"350x200"));
		
		$table->addComponent(new label('Full Description:'));
		$table->addComponent(new formattedTextArea('fullDescription',$data['fullDescription'],800,600,"Default"));
		
		$table->addComponent(new label('Title:'));
		$table->addComponent(new text('title',$data['title']));
		$table->addComponent(new label('Keywords:'));
		$table->addComponent(new text('keywords',$data['keywords']));
		$table->addComponent(new label('Description:'));
		$table->addComponent(new textArea('description',$data['description']));


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