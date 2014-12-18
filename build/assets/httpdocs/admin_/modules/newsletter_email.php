<?php
require_once("modules/defaultController.php");
class newsletter_email extends defaultController
{
	function __construct()
	{ 
		parent::__construct();
	}
	
	function show()
	{
		if ($_GET['action']=="add")							$this->add(); 
  		else if ($_GET['action']=="edit")					$this->edit(); 
  		else if ($_GET['action']=="save")					$this->save();
		else if ($_GET['action']=="del")					$this->del(); 
		else if ($_GET['action']=="import")					$this->import();
		else if ($_GET['action']=="export")					$this->export();
		else $this->rowsList();
	}
	
	function export()
	{
		global $DB;
		
		$rs=$DB->query("SELECT ne.*,(SELECT name FROM newsletter_group WHERE id=ne.groupId) AS 'group' FROM newsletter_email AS ne");
		
		if($_POST["type"]["fieldValue"]=="csv")
		{
			$buf="Id,";
			$buf.="Group,";
			$buf.="Active,";
			$buf.="Email\r\n";
			
			while($tab=$DB->fetch_array($rs))
			{
				if($tab['active']) $tab['active']="Yes";
				else $tab['active']="No";
				
				$buf.=$tab["id"].",";
				$buf.=$tab["group"].",";
				$buf.=$tab["active"].",";
				$buf.=stripslashes($tab["email"])."\r\n";
			}
		
			header("Content-type: application/octet-stream"); 
			header("Content-Disposition: attachment; filename=newsletter_emails_export.csv"); 
			header("Pragma: no-cache"); 
			header("Expires: 0"); 
			print($buf);
		}
		else
		{
			require_once 'Spreadsheet/Excel/Writer.php';
			$workbook=new Spreadsheet_Excel_Writer();
			$worksheet =& $workbook->addWorksheet('Emails');
			$worksheet->setInputEncoding('UTF-8');
	
			$worksheet->write(0,0,"Id");
			$worksheet->write(0,1,"Active");
			$worksheet->write(0,2,"Email");
		
			$i=1;
			while($tab=$DB->fetch_array($rs))
			{
				if($tab['active']) $tab['active']="Yes";
				else $tab['active']="No";
				$worksheet->write($i,0,$tab['id']);
				$worksheet->write($i,1,$tab['active']);
				$worksheet->write($i,2,stripslashes($tab['email']));
				$i++;
			}
			
			$workbook->close();
			$workbook->send("newsletter_emails_export.xls");
		}
			
	}
		
	function import()
	{
		global $DB;
		global $USER;
		global $INFO;
		global $LINK;
		
		if(is_file($_FILES['importFile']['tmp_name']))
		{
			if($_POST["type"]["fieldValue"]=="csv")
			{
				$fp=@fopen($_FILES['importFile']['tmp_name'],"r");
				if(is_numeric($_POST["offset"]["fieldValue"]))	
				for($i=0;$i<$_POST["offset"]["fieldValue"];$i++) $data=fgetcsv($fp,1000,',','"'); //omijamy zadane linie
				while(($line=fgetcsv($fp,1000,',','"'))!==FALSE) $lines[]=$line;
			}
			else
			{
				require_once('classes/Excel/reader.php');
				$data = new Spreadsheet_Excel_Reader();
				$data->setRowColOffset(0);
				$data->read($_FILES['importFile']['tmp_name']);
			
				if(is_numeric($_POST["offset"]["fieldValue"])) $lines=array_slice($data->sheets[0]['cells'],$_POST["offset"]["fieldValue"]);
				else $lines=$data->sheets[0]['cells'];
			}
		
			$DB->query("BEGIN");
			if(is_array($lines))
			foreach($lines AS $line)
			{
				if(is_numeric($line[0]))
				{
					$query="UPDATE newsletter_email SET groupId='".$this->groupId($line[1])."', active='".$this->yesNo($line[2])."', email='".$line[3]."', modified='".date("Y-m-d H:i:s")."', modifiedBy='Import process: ".$USER->login."' WHERE id='".$line[0]."' LIMIT 1";
				}
				else
				{
					$query="INSERT INTO newsletter_email (groupId,active,email,created,createdBy) VALUES ('".$this->groupId($line[1])."','".$this->yesNo($line[2])."','".$line[3]."','".date("Y-m-d H:i:s")."','Import process: ".$USER->login."')";
				}
				$DB->query($query);
			}
			$DB->query("COMMIT");
			$INFO->setInfo("Data imported");
			
		}
		else
		{		
			$INFO->setInfo("no import file specified","error");
		}
		header("Location: ".$LINK->getLink("action=list","",false));
	}
	
	
	function yesNo($str)
	{
		$ret=0;
		$str=trim($str);
		$str=strtoupper($str);
		if(($str=="YES") || ($str=="1")) $ret=1;
		
		return $ret;
	}
	
	private function groupId($name)
	{
		global $DB;
		global $USER;
		
		
		$ret=0;
		$name=trim($name);
		$rs=$DB->query("SELECT id FROM newsletter_group WHERE name LIKE '".addslashes($name)."' LIMIT 1");
		if($DB->num_rows($rs)!=1)
		{
			$DB->query("INSERT INTO newsletter_group (name,created,createdBy) VALUES ('".addslashes($name)."','".date("Y-m-d H:i:s")."','Import Process - ".$USER->login."')");
			$ret=$DB->insert_id();
		}
		else
		{
			$tab=$DB->fetch_array($rs);
			$ret=$tab["id"];
		}
		
		return $ret;
	}
	
	
	
}

?>