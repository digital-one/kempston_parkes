<?php
class defaultController extends module
{
	
	function __construct()
	{
		parent::__construct();
	}
	
	function show()
	{
		if ($_GET['action']=="add")	$this->add(); 
  		else if ($_GET['action']=="edit")	$this->edit(); 
  		else if ($_GET['action']=="save")	$this->save();
		else if ($_GET['action']=="del")	$this->del(); 
		else $this->rowsList(); 
	}
		
	function rowsList()
	{
		require_once("modules/".$this->dirName."/rowsList.php");
		$this->title.=" - ".$this->name;
		$tmp=new rowsList();
		$this->content.=$tmp->html;
		$this->generateHtml();
	}
	
function add()
{
	global $MODULE;
	if($MODULE->rights['add'])
	{
	
		require_once("modules/".$this->dirName."/rowForm.php");
		$this->title.=" - ".$this->name;
		$tmp=new rowForm();
		$this->content.=$tmp->html;
		$this->generateHtml();
	}
	else header("Location: index.php");
}
	
function edit()
{
	global $MODULE;
	if($MODULE->rights['edit'])
	{
		global $DB;
		require_once("modules/".$this->dirName."/rowForm.php");
		$this->title.=" - ".$this->name;
		if(is_numeric($_GET["id"]))
		$rs=$DB->query("SELECT t.* FROM ".$this->tableName." AS t WHERE t.".$this->keyName."=".$_GET["id"]." LIMIT 1");
		$tmp=new rowForm($DB->fetch_array($rs));
		$this->content.=$tmp->html;
		$this->generateHtml();
	}
	else header("Location: index.php");
}
	
function save()
{
	global $MODULE;
	$save=true;
	
	if(($MODULE->rights['edit']) || ($MODULE->rights['add'])) 
	{
		
		global $DB;
		global $USER;
		global $LINK;
				
		$DB->query("BEGIN");
		
		if(!is_numeric($_GET["id"])) 
		{
			$DB->query("INSERT INTO ".$this->tableName." (created,createdBy) VALUES ('".date("Y-m-d H:i:s")."','".$USER->login."')");
			$_GET["id"]=$DB->insert_id();
		}
		else 
		{
			$DB->query("UPDATE ".$this->tableName." SET modified='".date("Y-m-d H:i:s")."', modifiedBy='".$USER->login."' WHERE ".$this->keyName."=".$_GET["id"]);
		}
		
		//-- -----------------XML ------------------
		$xml = @simplexml_load_file("./modules/".$this->dirName."/".$this->xml);
		foreach($xml->xpath('/module/component') as $cmp)
		{
			try
			{
				$classFileName	=(string)$cmp["classFileName"];
				$className		=(string)$cmp["className"];
				$fieldName		=(string)$cmp["fieldName"];
				
				if(($_POST[$fieldName]['fieldName']==$fieldName) && (file_exists($classFileName)) && (!empty($classFileName)))
				{				
					require_once($classFileName);
					$tmp=new $className();
					$tmp->tableName=$this->tableName;
					$tmp->keyName=$this->keyName;
					$tmp->key=$_GET['id'];
					foreach($cmp->attributes() AS $k=>$v) $tmp->$k=(string)$v;
					foreach($_POST[$fieldName] as $key => $val) $tmp->$key=$val;
					$save=$tmp->saveData();
					if(!$save) break;
					
					//print('<pre>');
					//print_r($tmp);
					//print('</pre>');
					unset($tmp);
				}
			}
			catch (Exception $e) { print($e); }
		}
		//-- -----------------XML ------------------
		
		if($save)	
		{
			$DB->query("COMMIT");
			//$DB->query("ROLLBACK");
		}
		else 
		{			
			$DB->query("ROLLBACK");
		}
		header("Location: ".$LINK->getLink("action=list","id",false));
		
		//print('<pre>');
		//print_r($_POST);
//print('</pre>');
		
	}
	else header("Location: index.php");
		
		
}
	
function del()
{
	global $MODULE;
	if($MODULE->rights['delete'])
	{
		global $DB;
		global $LINK;
		
		$save=true;
		
		if(is_numeric($_GET["id"])) 
		{
			$DB->query("BEGIN");
			
			//-- -----------------XML ------------------
			$xml = @simplexml_load_file("./modules/".$this->dirName."/".$this->xml);
			foreach($xml->xpath('/module/component') as $cmp)
			{
				try
				{
					$classFileName	=(string)$cmp["classFileName"];
					$className		=(string)$cmp["className"];
					$fieldName		=(string)$cmp["fieldName"];
				
					require_once($classFileName);
					$tmp=new $className();
					$tmp->fieldName=$fieldName;
					$tmp->tableName=$this->tableName;
					$tmp->keyName=$this->keyName;
					$tmp->key=$_GET["id"];
					
					foreach($cmp->attributes() AS $k=>$v) $tmp->$k=(string)$v;
					$save=$tmp->delData();
					if(!$save) break;
					unset($tmp);
					//print('<pre>');
					//print_r($tmp);
					//print('</pre>');
				}
				catch (Exception $e) { print($e); }
			}
			//-- -----------------XML ------------------
						
			if($save)	
			{
				$DB->query("DELETE FROM ".$this->tableName." WHERE ".$this->keyName."=".$_GET["id"]);
				$DB->query("COMMIT");
			}
			else 
			{			
				$DB->query("ROLLBACK");
			}
		}
		
		
		
		header("Location: ".$LINK->getLink("action=list","id",false));
	}
	else header("Location: index.php");
		
}
	
		

		
	
	
}

?>
