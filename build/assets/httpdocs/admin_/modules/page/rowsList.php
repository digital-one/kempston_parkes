<?php
require_once('./classes/components/form.php');
require_once('./classes/components/table.php');
require_once('./classes/components/tableHeader.php');
require_once('./classes/components/tableHeaderField.php');
require_once('./classes/components/button/add.php');
require_once('./classes/components/button/edit.php');
require_once('./classes/components/button/delete.php');
require_once('./classes/components/position.php');
require_once('./classes/components/label.php');
require_once('./classes/components/link.php');
require_once('./classes/components/checkbox/activeCheckbox.php');
require_once('./classes/components/radio/activeRadio.php');
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
		
		$query='select * FROM (SELECT p.*,(SELECT name FROM _lang WHERE id=p.langId) AS lang FROM page AS p ) AS p WHERE  1';
		
		$tmp=new add();
		$this->html.=$tmp->getComponent()."<br /><br />";
		
		$tmp=new filter();
		$tmp->addFilter("name","Name");
		$tmp->addFilter("lang","Lang");
		$this->html.=$tmp->getComponent();
		
		$query = new query($query,"langId, id, name","ASC","25");
		$this->html.=$query->getComponent();
		
		$th=new tableHeader();
		$th->addComponent(new tableHeaderField("Lp"));
		$th->addComponent(new tableHeaderField("Active","p.active"));
		$th->addComponent(new tableHeaderField("Lang","lang"));
		$th->addComponent(new tableHeaderField("Name","p.name"));
		$th->addComponent(new tableHeaderField("Edit"));
		$th->addComponent(new tableHeaderField("Delete"));
		
		$table=new table($th,true);
		
		$rs=$DB->query($query->getQuery());
		$lp=1;
		while($tab=$DB->fetch_array($rs))
		{
			$table->addComponent(new label($lp));
			$table->addComponent(new activeCheckbox('active',$tab['active'],$tab['id']));
			$table->addComponent(new label($tab['lang']));
			$table->addComponent(new label($tab['name']));
			$table->addComponent(new edit($tab['id'],$tab['edit']));
			$table->addComponent(new delete($tab['id'],$tab['del']));
			$lp++;
		}
		
		$form=new form();
		$form->addComponent($table);
				
		$this->html.=$form->getComponent();
	
	}
}

?>