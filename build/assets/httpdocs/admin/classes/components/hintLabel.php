<?php

require_once('./classes/component.php');

class hintLabel extends component
{
	var $hint;
	
	function hintlabel($value=null,$hint=null)
	{
		$this->css='defaultHint';
		$this->hint=$hint;
		if(is_object($value)) $this->value=$value->getComponent();
		else $this->value=$value;
		$this->generateHtml();
	}
	
	function generateHtml()
	{
		$id=mt_rand();
		$this->html.=$this->value.' <a href="#" '.$this->id.' onmouseover="document.getElementById(\'hint'.$id.'\').style.visibility=\'visible\';" onmouseout="document.getElementById(\'hint'.$id.'\').style.visibility=\'hidden\';"><img src="images/lupa.gif" border="0" alt="more" /></a>';
		$this->html.='<div id="hint'.$id.'" class="'.$this->css.'" onmouseover="document.getElementById(\'hint'.$id.'\').style.visibility=\'visible\';" onmouseout="document.getElementById(\'hint'.$id.'\').style.visibility=\'hidden\';">'.$this->hint.'</div>';
	}
}
?>
