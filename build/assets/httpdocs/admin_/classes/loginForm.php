<?php

class loginForm
{
	function loginForm()
	{
		$this->html='<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
		<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=ISO-8859-2" />
<TITLE>CMS </TITLE>
<link href="css/style.css" rel="stylesheet" type="text/css">
<style>
body
{
	background: #ffffff url(images/bck.jpg) repeat-x top center;
}

</style>
</head>
<body>

<form action="index.php?action=login" method="post">
<table style="width:100%;height:100%;">
	<tr>
		<td valign="middle" align="center">

<fieldset style="width:180px;border:none;">

<table width="100%"  border="0" cellspacing="0" cellpadding="10" style="background-color:#f6f6f6;width:400px;height:200px;background:url(images/bck_login.gif) no-repeat top left;">
  <tr>
    <td align="center" valign="middle"><br/><br/><table cellpadding="3" cellspacing="3">
<tr>
<td>Login:</td> <td width="200"><input type="text" name="login" class="defaultText" style="width:300px;color:#434343;" /></td>
</tr>
<tr>
<td>Pass:</td> <td><input type="password" name="pass" class="defaultText" style="width:300px;color:#434343;" /></td>
</tr>
<tr>
<td colspan="2" align="right">
<input style="border:none;" type="image" src="images/send.gif" name="send!" />

</td>
</tr>
</table></td>
  </tr>
</table>
</fieldset>

		</td>
	</tr>
</table>
</form>



</body>
</html>';

	}
	
}

?>