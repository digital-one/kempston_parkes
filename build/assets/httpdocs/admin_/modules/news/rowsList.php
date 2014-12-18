<?php
require_once('./classes/components/form.php');
require_once('./classes/components/table.php');
require_once('./classes/components/tableHeader.php');
require_once('./classes/components/tableHeaderField.php');
require_once('./classes/components/button/add.php');
require_once('./classes/components/button/edit.php');
require_once('./classes/components/button/delete.php');
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
		
		$query='SELECT * FROM (SELECT n.*,(SELECT name FROM _lang WHERE id=n.langId) AS lang  FROM news AS n) AS n WHERE 1';
		
		$tmp=new add();
		$this->html.=$tmp->getComponent()."<br /><br />";
				
		$filter=new filter();
		$filter->addFilter("title","Title");
		$filter->addFilter("lang","Lang");
		$this->html.=$filter->getComponent();
		
		$query = new query($query,"newsDate","DESC","25");
		$this->html.=$query->getComponent();
		
		$th=new tableHeader();
		$th->addComponent(new tableHeaderField("Lp"));
		$th->addComponent(new tableHeaderField("Active","active"));
		$th->addComponent(new tableHeaderField("Main","main"));
		$th->addComponent(new tableHeaderField("Lang","lang"));
		$th->addComponent(new tableHeaderField("Date","newsDate"));
		$th->addComponent(new tableHeaderField("Title","title"));
		$th->addComponent(new tableHeaderField("Edit"));
		$th->addComponent(new tableHeaderField("Delete"));
		
		$table=new table($th,true);
		
		$rs=$DB->query($query->getQuery());
		$lp=1;
		while($tab=$DB->fetch_array($rs))
		{
			$table->addComponent(new label($lp));
			$table->addComponent(new activeCheckbox('active',$tab['active'],$tab['id']));
			$table->addComponent(new activeCheckbox('main',$tab['main'],$tab['id']));
			$table->addComponent(new label($tab['lang']));
			$table->addComponent(new label($tab['newsDate']));
			$table->addComponent(new label($tab['title']));
			$table->addComponent(new edit($tab['id']));
			$table->addComponent(new delete($tab['id']));
			$lp++;
		}
		
		$form=new form();
		$form->addComponent($table);
				
		$this->html.=$form->getComponent();
	
	}
}

?>