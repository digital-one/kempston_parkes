<?php
class filter
{
	var $options;
	var $size=0;
	var $html;
	
	function filter()
	{
		$this->generateHtml();
	}
	
	function generateHtml()
	{
		global $LINK;
		$this->html='<form action="'.$LINK->getLink().'" method="POST" id="filterForm1" class="defaultForm">
					<table>
						<tr>
							<td>';
		
		$this->html.='<select name="filter" class="defaultSelect">';
									
		for($i=0;$i<$this->size;$i++) 
		$this->html.=$this->options[$i];
									
		$this->html.='</select>
							</td>
							<td>
								<select name="filterOperator" class="defaultSelect">
		<option value="1"';
		if($_GET["filterOperator"]=="1") $this->html.=' selected';
		$this->html.='>=</option>
		<option value="2"';
		if($_GET["filterOperator"]=="2") $this->html.=' selected';
		$this->html.='>></option>
		<option value="3"';
		if($_GET["filterOperator"]=="3") $this->html.=' selected';
		$this->html.='><</option>
								</select>
							</td>
							<td>
								<input type="text" value="'.$_GET["filterValue"].'" name="filterValue"  class="defaultText" style="width:100px;" />
							<td>
							<td>
								<input type="button" value="clean" name="ok" onClick="window.location=\''.$LINK->getLink(null,"filter&filterOperator&filterValue&ok").'\';" class="defaultButton" />
							</td>
							<td>
								<input type="button" value="show" name="ok" onClick="window.location=\''.$LINK->getLink(null,"filter&filterOperator&filterValue&ok").'&amp;\'+getFormData(\'filterForm1\')+\'\';" class="defaultButton" />
							</td>
						</tr>
					</table>
					</form>';
	}
	
	function addFilter($filedName,$filterName)
	{
		if( (!empty($filedName)) && (!empty($filterName)) )
		{
			$selected="";
			if($filedName==$_GET["filter"]) $selected="selected";
			$this->options[$this->size]='<option value="'.$filedName.'" '.$selected.'>'.$filterName.'</option>';
			$this->size++;
			$this->generateHtml();
		}
	}
	
	function getComponent()
	{
		return $this->html;
	}
}

?>