<?php
require_once('./classes/component.php');

class password extends component
{
	function password($name,$value='',$css='defaultPassword',$id=null)
	{
		if($id!=null)  $this->id='id="'.$id.'"';
		$this->css=$css;	
		$this->name=$name;
		$this->value=$value;
		$this->className="password";
		$this->classFileName="classes/pasword.php";
		$this->generateHtml();
	}
	
	function generateHtml()
	{
		$this->html='<input type="hidden" 	name="'.$this->name.'[className]" 		value="'.$this->className.'" />';
		$this->html.='<input type="hidden" 	name="'.$this->name.'[classFileName]" 	value="'.$this->classFileName.'" />';
		$this->html.='<input type="hidden" 	name="'.$this->name.'[name]" 			value="'.$this->name.'" />';
		$this->html.='<input type="password"   	name="'.$this->name.'[value]" 			value="'.$this->value.'" 	class="'.$this->css.'" 	'.$this->id.' />';
	}
	
	
	
}

?>