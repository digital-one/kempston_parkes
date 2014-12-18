<?php
require_once("classes/menu.php");
require_once("classes/info.php");

class module
{
	var $moduleId = 0;
	var $dirName = "";
	var $menu;
	var $title;
	var $content;
	var $html;
	var $info;
	var $tableName;
	var $keyName="id";
	var $xml="config.xml";
	var $add;
	var $edit;
	var $modify;
		
	function __construct()
	{
		global $INFO;
		
		$this->title="CMS";
		
		$tmp=new menu();
		$this->menu=$tmp->html;
		$this->info=$INFO->getInfo();
	}
	
	function show()
	{
	}
	
   function generateHtml()
	{
		global $USER;
				
	
		$this->html='<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
     	<html>
     		<head>
				<title>'.$this->title.'</title>
     			<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-2" />
				<link href="css/style.css" rel="stylesheet" type="text/css" />
				<link rel="stylesheet" href="js/JSCookMenu/ThemeOffice/theme.css" type="text/css" />
  				
				<script type="text/javascript" src="js/ajax.js"></script>
				<script type="text/javascript" src="js/kalendarz.js"></script>
				<script type="text/javascript" src="js/functions.js"></script>
				<script type="text/javascript" src="js/listFilter.js"></script>
				<script type="text/javascript" src="js/JSCookMenu/JSCookMenu.js"></script>
				<script type="text/javascript" src="js/JSCookMenu/ThemeOffice/theme.js"></script>
				<script type="text/javascript">
					var myMenu =
					[
						'.($this->menu).'
					];
				</script>
  				<style>
body
{
	background: #ffffff url(images/bck.jpg) repeat-x top center;
}

</style>
     		</head>
     		<body>
				<div id="progressBar" style="position:absolute;visibility:hidden;">
			<img src="images/progressBar.gif" alt="please wait" />
			</div>
			
				<table cellpadding="10" cellspacing="0" border="0" style="width:100%;height:100%;">
				<tr bgcolor="#e0e0e0">
					<td valign="bottom" style="height:75px;">
						<div id="myMenuID"></div>
						<script type="text/javascript">
							<!--
							cmDraw (\'myMenuID\', myMenu, \'hbr\', cmThemeOffice);
							-->
						</script>
						<br />
				  </td>
					<td align="right" style="height:75px;">
						<img src="images/cms.jpg" alt="cms" />
					</td>
				</tr>
				<tr>
					<td class="defaultPageTitle">'.$this->name.'</td>
					<td class="defaultPageTitle" align="right">&nbsp;</td>
				</tr>

				<tr>
					<td colspan="2" valign="top" style="height:100%">'.$this->info.($this->content).'</td>
				</tr>

				<tr bgcolor="#cccccc">
					<td colspan="2" class="defaultBottom">
						<table width="100%">
							<tr>
								<td align="left" style="color:#7b7b7b;">logged user: <b>'.($USER->login).'</b> last login: <b>'.($USER->lastLogin).'</b> from IP: <b>'.($USER->ip).'</b></td>
								<td align="right" style="color:#7b7b7b;">CMS v 3.5</td>
							</tr>
						</table>
					</td>
				</tr>
</table>

				
			</body>
		</html>';
		print($this->html);
	}
	

}

?>