<?php
require_once('./classes/components/form.php');
require_once('./classes/components/table.php');
require_once('./classes/components/label.php');
require_once('./classes/components/text.php');
require_once('./classes/components/textArea.php');
require_once('./classes/components/formattedTextArea.php');
require_once('./classes/components/button/back.php');
require_once('./classes/components/button/save.php');
require_once('./classes/components/tabbedPane.php');
require_once('./classes/components/checkbox.php');
require_once('./classes/components/select.php');

class rowForm
{
	var $html;
	
	function rowForm($data=null)
	{
		global $LINK;
		
		$tp=new tabbedPane();
		
		$table=new table();
		$table->addComponent(new label('Language:'));
		$table->addComponent(new select('langId',$data['langId'],'_lang','name','id',true));
		$table->addComponent(new label('Name:'));
		$table->addComponent(new text('name',$data['name']));
		$table->addComponent(new label('Email:'));
		$table->addComponent(new text('email',$data['email']));
		$table->addComponent(new label('Content:'));
		$table->addComponent(new formattedTextArea('content',$data['content'],800,600,"Form"));
		$table->addComponent(new label('Send Info:'));
		$table->addComponent(new textArea('sendInfo',$data['sendInfo']));
		$table->addComponent(new label('Captcha:'));
		$table->addComponent(new checkbox('token',$data['token']));
		//$table->addComponent(new back());
		//$table->addComponent(new save(),"right");
		
		//$form=new form($LINK->getLink("action=save"));
		//$form->addComponent($table);
		
		//$tp->addComponent($form,"Basic");
		
		//$table=new table();
		//$table->addComponent(new label('SEO Link:'));
		//$table2=new table();
		//$table2->addComponent(new checkbox('seo',$data['seo']));
		//$table2->addComponent(new text('seo_link',$data['seo_link']));
		//$table->addComponent($table2);
		$table->addComponent(new label('Title:'));
		$table->addComponent(new text('title',$data['title']));
		$table->addComponent(new label('Keywords:'));
		$table->addComponent(new text('keywords',$data['keywords']));
		$table->addComponent(new label('Description:'));
		$table->addComponent(new textArea('description',$data['description']));
		$table->addComponent(new back());
		$table->addComponent(new save(),"right");
		
		$form=new form($LINK->getLink("action=save"));
		$form->addComponent($table);
		
		//$tp->addComponent($form,"SEO");
		
		$this->html=$form->getComponent();
	}
}

?>