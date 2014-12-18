<?php
require_once('./classes/component.php');
class form extends component
{
	var $action;
	var $method;
	var $enctype;
	
	var $rows = 0;
	var $tab;
		
	function form($action='index.php',$method='post',$enctype='multipart/form-data',$id="formId")  
	{
		$this->css='defaultForm';
		$this->action  = $action;
		$this->method  = $method;
		$this->enctype = $enctype;
		$this->name  = $name;
		$this->id = $id;
		$this->generateHtml();
						
	}
	
	function addComponent($component)
	{
		$this->tab[$this->rows]=$component->getComponent();
		$this->rows++;
		$this->generateHtml();
	}
	
	function generateHtml()
	{
		$this->html='<form action="'.$this->action.'" method="'.$this->method.'" enctype="'.$this->enctype.'"  class="'.$this->css.'" id="'.$this->id.'" >';
		for($i=0;$i<$this->rows;$i++)
		{
			$this->html.=$this->tab[$i];
		}
		$this->html.='</form>';
	}
	


}
?>