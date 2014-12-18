<?php

class logoutForm
{
	var $html;
	
	function logoutForm()
	{
		global $MODULE;
		$this->html='
			<table cellspacing="10">
					<tr>
						<td colspan="2">Do you want to log out?</td>
					</tr>
					<tr>
						<td align="left"><input class="defaultButton" type="button" name="logout" value="logout" onClick="window.location=\'index.php?moduleId='.$MODULE->moduleId.'&amp;action=logout\'" /></td>
						<td align="right"><input class="defaultButton" type="button" name="cancel" value="cancel" onClick="window.location=\''.$_SERVER["HTTP_REFERER"].'\'" /></td>
					</tr>
			</table>';
	}
}

?>