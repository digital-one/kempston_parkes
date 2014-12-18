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
require_once('./modules/menu/positionBar.php');
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
		
		if(!is_numeric($_GET["parentId"])) $_GET["parentId"]=0;
		//$query='SELECT t.*,() FROM '.$MODULE->tableName.' AS t WHERE parentId='.$_GET["parentId"];
		
		$query='SELECT * FROM (SELECT n.*,(SELECT name FROM _lang WHERE id=n.langId) AS lang  FROM '.$MODULE->tableName.' AS n WHERE parentId='.$_GET["parentId"].') AS n WHERE 1';
		
		$tmp=new add();
		$this->html.=$tmp->getComponent()."<br /><br />";
		
		$tmp=new positionBar($_GET["parentId"]);
		$this->html.=$tmp->getComponent();
		
		$tmp=new filter();
		$tmp->addFilter("name","Name");
		$tmp->addFilter("lang","Name");
		$this->html.=$tmp->getComponent();
		
		$query = new query($query,"position","ASC","25");
		$this->html.=$query->getComponent();
		
		$th=new tableHeader();
		$th->addComponent(new tableHeaderField("Lp"));
		$th->addComponent(new tableHeaderField("Position","t.position"));
		$th->addComponent(new tableHeaderField("Active","t.active"));
		$th->addComponent(new tableHeaderField("Display"));
		$th->addComponent(new tableHeaderField("Lang","lang"));
		$th->addComponent(new tableHeaderField("Name","name"));
		$th->addComponent(new tableHeaderField("Edit"));
		$th->addComponent(new tableHeaderField("Delete"));
		
		$table=new table($th,true);
		
		$rs=$DB->query($query->getQuery());
		$lp=1;
		while($tab=$DB->fetch_array($rs))
		{
			$table->addComponent(new label($lp));
			$table->addComponent(new position('position',$tab['position'],$tab['id']));
			$table->addComponent(new activeCheckbox('active',$tab['active'],$tab['id']));
			$table->addComponent(new activeCheckbox('display',$tab['display'],$tab['id']));
			$table->addComponent(new label($tab['lang']));
			$table->addComponent(new link($tab['name'],$LINK->getLink("parentId=".$tab["id"])));
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