<?php 
	ob_start();
	session_start();
	
	require_once("classes/templateEngine.php"); 
	require_once("classes/db.php");
	require_once("classes/module.php");
	require_once("classes/linkManager.php");
	require_once("classes/info.php");
	require_once("classes/config.php");
	require_once("classes/functions.php");

	
	$CONF=new config();
	$LINK=new linkManager();
	$INFO=new info();
	$DB= new db();
	
	//putenv($CONF->get("/configuration/timezone"));
	date_default_timezone_set($CONF->get("/configuration/timezone"));
	
	
	if(is_numeric($_GET["langId"])) $_SESSION['langId']=$_GET["langId"];
	
	if(!is_numeric($_SESSION['langId']))
	{
		$query="SELECT id AS LANGID,prefix AS PREFIX FROM _lang WHERE main=1 LIMIT 1";
	}
	else 
	{
		$query="SELECT id AS LANGID,prefix AS PREFIX FROM _lang WHERE id=".$_SESSION['langId'];
	}
	
	
	$rs=$DB->query($query);
	$tab=$DB->fetch_array($rs);
	$_SESSION['langId']=$tab["LANGID"];
	foreach($tab AS $k=>$v) 
	{
		define($k,$v);
	}
	
	
	if(!is_file("classes/modules/".$_GET["module"].".php")) $_GET["module"]='page';	

	require_once("classes/modules/".$_GET["module"].".php");
	$PAGE=new $_GET["module"]();
	
	ob_end_flush();
?>