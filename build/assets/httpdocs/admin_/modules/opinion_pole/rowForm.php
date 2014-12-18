<?php
require_once('./classes/components/form.php');
require_once('./classes/components/table.php');
require_once('./classes/components/label.php');
require_once('./classes/components/text.php');
require_once('./classes/components/textArea.php');
require_once('./classes/components/formattedTextArea.php');
require_once('./classes/components/button/save.php');
require_once('./classes/components/button/back.php');
require_once('./classes/components/checkbox.php');
require_once('./classes/components/select.php');
require_once('./classes/components/tabbedPane.php');



class rowForm
{
	var $html;
	
	function rowForm($data=null)
	{
		global $LINK;
		global $DB;
		
		$tp=new tabbedPane();
		
		$table=new table();
		$table->addComponent(new label('Language:'));
		$table->addComponent(new select('langId',$data['langId'],'_lang','name'));
		$table->addComponent(new label('Multiselection:'));
		$table->addComponent(new checkbox('multiselection',$data['multiselection']));
		$table->addComponent(new label('Title:'));
		$table->addComponent(new text('title',$data['title']));
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
		
		$tp->addComponent($table,"Basic");
		
		$table=new table();
		$table->addComponent(new label('Answer'));
		$table->addComponent(new label('Votes'));
		if(is_numeric($data["id"]))
		{
			$rs=$DB->query("SELECT * FROM opinion_pole_answers WHERE opinionId=".$data["id"].' order by position ASC');
			while($tab=$DB->fetch_array($rs))
			{
				$table->addComponent(new label(stripslashes($tab['answer'])));
				$table->addComponent(new label($tab['votes']));
			}
		}
		
		$table->addComponent(new back());
		$table->addComponent(new save(),"right");
		
			
		$tp->addComponent($table,"Results");
		
		$form=new form($LINK->getLink("action=save"));
		$form->addComponent($tp);
		
		$this->html=$form->getComponent();
	}
}

?>