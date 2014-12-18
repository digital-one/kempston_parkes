<?php
require_once('./classes/components/form.php');
require_once('./classes/components/table.php');
require_once('./classes/components/tableHeader.php');
require_once('./classes/components/tableHeaderField.php');
require_once('./classes/components/button/add.php');
require_once('./classes/components/button/edit.php');
require_once('./classes/components/button/delete.php');
require_once('./classes/components/button/back.php');
require_once('./classes/components/button.php');
require_once('./classes/components/label.php');
require_once('./classes/components/checkbox/activeCheckbox.php');
require_once('./classes/components/file.php');
require_once('./classes/components/number.php');
require_once('./classes/query.php');
require_once('./classes/filter.php');
require_once('./classes/components/tabbedPane.php');
require_once('./classes/components/listbox.php');

class rowsList
{
	var $html;
	
	function rowsList()
	{
		global $DB;
		global $LINK;
		global $MODULE;
		global $USER;
		
		$tp=new tabbedPane();
		
	
		$t1=new table();
		$t1->cols=1;
		$t1->addComponent(new add());
		
		$filter=new filter();
		$filter->addFilter("t.email","Email");
		$t1->addComponent($filter);
		
		$query='SELECT * FROM (SELECT ne.*,(SELECT name FROM newsletter_group AS ng WHERE ng.id=ne.groupId) AS groupName FROM newsletter_email AS ne) AS t WHERE 1';
		$query = new query($query,"t.email","asc","25");
		$t1->addComponent($query);
		
		$th=new tableHeader();
		$th->addComponent(new tableHeaderField("Lp"));
		$th->addComponent(new tableHeaderField("Active","active"));
		$th->addComponent(new tableHeaderField("Group","groupName"));
		$th->addComponent(new tableHeaderField("Email","email"));
		$th->addComponent(new tableHeaderField("Edit"));
		$th->addComponent(new tableHeaderField("Delete"));
		
		$table=new table($th,true);
		
		$rs=$DB->query($query->getQuery());
		$lp=1;
		while($tab=$DB->fetch_array($rs))
		{
			$table->addComponent(new label($lp));
			$table->addComponent(new activeCheckbox('active',$tab['active'],$tab['id']));
			$table->addComponent(new label($tab['groupName']));
			$table->addComponent(new label($tab['email']));
			$table->addComponent(new edit($tab['id']));
			$table->addComponent(new delete($tab['id']));
			$lp++;
		}
		
		$form=new form();
		$form->addComponent($table);
		$t1->addComponent($form);
		$tp->addComponent($t1,"Emails");
		
		if($MODULE->rights["import"])
		{
			$t2=new table();
			$t2->addComponent(new label("Type"));
			
			$opts[0]["name"]="CSV";
			$opts[0]["value"]="csv";
			//$opts[1]["name"]="Excel";
			//$opts[1]["value"]="excel";

						
			$t2->addComponent(new listbox('type',null,$opts));
			
			$t2->addComponent(new label("Skip first"));
			$t2->addComponent(new number("offset","1"));
			$t2->addComponent(new label("File"));
			$t2->addComponent(new file("importFile",null));
			$t2->addComponent(null);
			$t2->addComponent(new button('import','Import&nbsp;&raquo;','onClick="submit();"'),"right");
			$form=new form($LINK->getLink("action=import"));
			$form->addComponent($t2);
		
			$tp->addComponent($form,"Import");
		}
		
		if($MODULE->rights["export"])
		{
			$t3=new table();
			$t3->cols=3;
			$t3->addComponent(new label("Type"));
			
			$opts[0]["name"]="CSV";
			$opts[0]["value"]="csv";
			//$opts[1]["name"]="Excel";
			//$opts[1]["value"]="excel";

						
			$t3->addComponent(new listbox('type',null,$opts));
			$t3->addComponent(new button('export','Export&nbsp;&raquo;','onClick="submit();"'),"right");
			$form=new form($LINK->getLink("action=export"));
			$form->addComponent($t3);
		
			$tp->addComponent($form,"Export");
		}	
				
		$this->html.=$tp->getComponent();
	
	}
}

?>