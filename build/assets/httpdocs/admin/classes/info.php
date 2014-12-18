<?php

class info
{
	var $text="";
	var $type="";
	var $display=false;
	
	function info()
	{
		$info=unserialize($_SESSION["info"]);
		if($info!=null)
		{
			$this->display=$info->display;
			$this->text=$info->text;
			$this->type=$info->type;
		}
	}
	
	function setInfo($text,$type='information')
	{
		$this->display=true;
		$this->text.=$text;
		$this->type=$type;
		$this->save();
	}
	
	function getInfo()
	{
		if($this->display)
		{
			$html.='
			<table width="100%" class="'.$this->type.'" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td valign="top" align="left" width="30"><img src="images/'.$this->type.'.jpg" alt="'.$this->type.'"/></td><td align="left" valign="middle" width="100%" style="padding-left:20px;">'.$this->text.'</td>
				</tr>
			</table>
			';
			$this->display=false;
			$this->text="";
			$this->type="";
		}
		return $html;
	}
	
	function save()
	{
		$_SESSION["info"]=serialize($this); 
	}
	
}

?>