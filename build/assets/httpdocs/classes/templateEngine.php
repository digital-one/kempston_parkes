<?php

class templateEngine
{
	private $__html;
	
	function __construct()
	{
		
	}
	
	function parseTemplate($templateName)
	{	
		global $DB;	
		
		$this->__html=file_get_contents($templateName);
		$this->__html=$this->changeTags($this->__html);
		$this->__html=$this->removeVarCode($this->__html);
		$this->__html=$this->removeTags($this->__html);
		$this->__html=$this->evalCode($this->__html);
		return $this->__html;
	}
	
	private function changeTags($code)
	{
		foreach($this AS $k => $v)
		{
			if(!is_array($v)) $v=trim($v);
			if(!empty($v)) $code=str_replace('{'.$k.'}',$v,$code);
		}
		return $code;
	}
	
	private function removeVarCode($code)
	{
		$code=preg_replace('|{\?}.*{[a-z0-9]*}.*{/\?}|i','',$code);
		return $code;
	}
	
	private function removeTags($code)
	{
		$code=preg_replace('|{/?[a-z0-9_]*}|ismU','',$code);
		return $code;
	}
	
	private function evalCode($__code)
	{
		
		
		foreach($this AS $__k => $__v)
		{
			$$__k=$__v;
		}
		
		if(preg_match_all('|<\?.*?\?>|is',$__code,$__regs))
		{
			foreach($__regs[0] AS $__reg) 
			{
				$__php=substr($__reg,2,strlen($__reg)-4);
				ob_clean();
				eval($__php);
				$__code=str_replace($__reg,ob_get_contents(),$__code);
				ob_clean();
			}
		}
		
		return $__code;
	}
	
	public function getHtml()
	{
		return $this->__html;
	}
	

}

?>