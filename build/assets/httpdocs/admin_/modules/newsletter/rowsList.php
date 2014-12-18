<?php
require_once('./classes/components/form.php');
require_once('./classes/components/table.php');
require_once('./classes/components/tableHeader.php');
require_once('./classes/components/tableHeaderField.php');
require_once('./classes/components/button/add.php');
require_once('./classes/components/button/edit.php');
require_once('./classes/components/button/delete.php');
require_once('./classes/components/button.php');
require_once('./classes/components/label.php');
require_once('./classes/components/checkbox/activeCheckbox.php');
require_once('./classes/components/hintLabel.php');
require_once('./classes/query.php');
require_once('./classes/filter.php');

class rowsList
{
	var $html;
	
	function rowsList()
	{
		global $DB;
		global $LINK;
		global $MODULE;
		global $USER;
		
		$query='SELECT t.* FROM '.$MODULE->tableName.' AS t WHERE 1';
		
		if($MODULE->rights['add'])
		{
			$tmp=new button('add','Add',"onClick=\"window.location='".($LINK->getLink("action=add"))."'\"");
			$this->html.=$tmp->getComponent()."<br /><br />";
		}
		
		$filter=new filter();
		$filter->addFilter("t.title","Title");
		$this->html.=$filter->getComponent();
		
		$query = new query($query,"t.created","DESC","25");
		$this->html.=$query->getComponent();
		
		$th=new tableHeader();
		$th->addComponent(new tableHeaderField("Lp"));
		$th->addComponent(new tableHeaderField("Archive","archive"));
		$th->addComponent(new tableHeaderField("Date","created"));
		$th->addComponent(new tableHeaderField("Title","title"));
		$th->addComponent(new tableHeaderField("Edit"));
		$th->addComponent(new tableHeaderField("Delete"));
		$th->addComponent(new tableHeaderField("Send"));
		
		$table=new table($th,true);
		
		$rs=$DB->query($query->getQuery());
		$lp=1;
		while($tab=$DB->fetch_array($rs))
		{
			$table->addComponent(new label($lp));
			$table->addComponent(new activeCheckbox('archive',$tab['archive'],$tab['id']));
			$table->addComponent(new label($tab['created']));
			$table->addComponent(new label($tab['title']));
			$table->addComponent(new edit($tab['id']));
			$table->addComponent(new delete($tab['id']));
			$table->addComponent(new button('send','Send',"onClick=\"if(window.confirm('Are you sure you want to send newsletter?')) { window.location='".($LINK->getLink("action=send&id=".$tab['id']))."';}\""));
			
			$lp++;
		}
		
		$form=new form();
		$form->addComponent($table);
				
		$this->html.=$form->getComponent();
	
	}
}

?>