<?php
require_once('./classes/components/form.php');
require_once('./classes/components/table.php');
require_once('./classes/components/label.php');
require_once('./classes/components/text.php');
require_once('./classes/components/textArea.php');
require_once('./classes/components/formattedTextArea.php');
require_once('./classes/components/button/save.php');
require_once('./classes/components/button/back.php');
require_once('./classes/components/file.php');
require_once('./classes/components/listbox.php');
require_once('./classes/components/multiCheckbox.php');

class rowForm
{
	var $html;
	
	function rowForm($data=null)
	{
		global $LINK;
		
		$table=new table();
		$table->addComponent(new label('Destination Groups'));
		$table->addComponent(new multiCheckbox('group',$data['id'],"newsletter_group","name","id","newsletter_group_send","newsletterId","groupId"));
		$table->addComponent(new label('Title:'));
		$table->addComponent(new text('title',$data['title']));
		$table->addComponent(new label('From name:'));
		$table->addComponent(new text('fromName',$data['fromName']));
		$table->addComponent(new label('From email:'));
		$table->addComponent(new text('fromEmail',$data['fromEmail']));
		$table->addComponent(new label('Description:'));
		$table->addComponent(new textArea('description',$data['description']));
		$table->addComponent(new label('Content:'));
		$table->addComponent(new formattedTextArea('content',$data['content']));
		$table->addComponent(new label('Attachment:'));
		$table->addComponent(new file('attachment',$data['attachment'],false));
		$table->addComponent(new label('Priority:'));
		
		$opts[0]["name"]="Normal";
		$opts[0]["value"]="3";
		$opts[1]["name"]="High";
		$opts[1]["value"]="1";
		$opts[2]["name"]="Low";
		$opts[2]["value"]="5";
						
		$table->addComponent(new listbox('priority',$data['priority'],$opts));

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