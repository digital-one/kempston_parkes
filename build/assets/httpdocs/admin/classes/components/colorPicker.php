<?php
require_once('./classes/component.php');

class colorPicker extends component
{
	function colorPicker($fieldName=null,$fieldValue=null,$params=null)
	{
		if($fieldName!=null)	$this->fieldName=$fieldName;
		if($fieldValue!=null)	$this->fieldValue=$fieldValue;
		$this->id='id_'.mt_rand();
		$this->css='defaultColorPicker';
		$this->generateHtml();
	}
	
  	function generateHtml()
	{
		$this->getData();	
		$this->html='<input type="hidden" name="'.$this->fieldName.'[fieldName]"  value="'.$this->fieldName.'" />';
		$this->html.='
		<table cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td>
					<input type="text" name="'.$this->fieldName.'[fieldValue]" value="'.$this->fieldValue.'" class="'.$this->css.'" id="'.$this->id.'" />
				</td>
				<td>
					<input type="text" name="'.$this->fieldName.'[preview]" value="" class="defaultColorPickerPreview" id="'.$this->id.'_preview" onclick="showColorPicker(\''.$this->id.'\')" maxlength="0" style="background:'.$this->fieldValue.'" />
				</td>
			</tr>
		</table>';
	}
	
	
}
?>