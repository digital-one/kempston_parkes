<?php
ob_start();
session_start();
header('Content-Type: text/html; charset=UTF-8'); 

require_once('./classes/functions.php');
require_once('./classes/db.php');
require_once('./classes/module.php');
require_once('./classes/user.php');
require_once('./classes/info.php');
require_once('./classes/linkManager.php');
require_once("../classes/config.php");

$CONF		=	new config("../classes/config.xml");
$USER		=	new user(unserialize($_SESSION["user"]));
$INFO		=	new info();
$LINK		=	new linkManager();
$DB			=	new db();
$ROOTDIR	=	"../data/";

if($USER->loggedIn())
{
	if(is_numeric($_GET['moduleId']))
		$query="SELECT m.*,um.rights AS rights FROM _module AS m, _user_module AS um WHERE m.id=um.moduleId AND um.userId=".$USER->id." AND um.moduleId=".$_GET['moduleId']." LIMIT 1";
	else
		$query="SELECT m.*,um.rights AS rights FROM _module AS m, _user_module AS um WHERE m.id=um.moduleId AND um.userId=".$USER->id." AND um.main=1 LIMIT 1";
	
	$rs=$DB->query($query);
	if($DB->num_rows($rs)==0) 
	{
		session_destroy();
		header("Location: index.php");
	}
	else
	{
		while($tab=$DB->fetch_array($rs))
		{
			require_once("./modules/".$tab["classFileName"]);
			$MODULE = new $tab["className"]();
			$MODULE->moduleId=$tab["id"];
			$MODULE->tableName=$tab["tableName"];
			$MODULE->name=$tab["name"];
			$MODULE->dirName=$tab["dirName"];
			$MODULE->xml=$tab["xml"];
			
			$rights=@unserialize($tab["rights"]);
			if(is_array($rights)) 
			foreach($rights AS $k=>$v) $MODULE->rights[$k]=$v;
			
			$MODULE->show();
			break;
		}
	}
}
else 
{
	if($_GET["action"]=="login")
	{
		foreach($_POST as $key => $val) $_POST[$key]=addslashes(ereg_replace("[^a-z0-9]","",strip_tags($val)));
		$query = "SELECT * FROM _user WHERE active=1 AND login='".$_POST["login"]."' AND pass='".$_POST['pass']."' LIMIT 1";
		$rs=$DB->query($query);
		if ($DB->num_rows($rs)==1)
		{
			$tab = $DB->fetch_array($rs);
			$USER->id 			= $tab['id'];
			$USER->sessionId  	= session_id(); 
			$USER->login        = $tab['login'];
			$USER->lastLogin  	= $tab['lastLogin'];
			$USER->ip 			= $_SERVER["REMOTE_ADDR"];
			$USER->site         = $_SERVER["SERVER_NAME"].dirname($_SERVER["SCRIPT_NAME"]);
			$query="UPDATE _user SET lastLogin='".date('Y.m.d H:i:s')."', ip='".$_SERVER["REMOTE_ADDR"]."' WHERE id=".$tab['id'];
			$DB->query($query);
		}
		header("Location: index.php");
		
	}
	else
	{
		require_once('./classes/loginForm.php');
		$tmp=new loginForm();
		print($tmp->html);
	}
}




$_SESSION["user"]=serialize($USER); 
$_SESSION["info"]=serialize($INFO); 
ob_end_flush();

?>