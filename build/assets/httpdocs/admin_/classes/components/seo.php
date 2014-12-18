<?php
require_once('./classes/component.php');
require_once('./classes/components/table.php');
require_once('./classes/components/text.php');
require_once('./classes/components/checkbox.php');

class seo extends component
{
	var $htaccess="../.htaccess";
	function seo($fieldName=null,$seo=null,$seo_link=null,$rule=null)
	{
		if($fieldName!=null) 	$this->fieldName=$fieldName;
		if($seo!=null) 			$this->seo=$seo;
		if($seo_link!=null) 	$this->seo_link=$seo_link;
		if($rule!=null) 		$this->rule=$rule;
		$this->generateHtml();
	}
	
	function generateHtml()
	{
		if($this->seo) $selected='checked="checked"';
		$this->html.='<input type="hidden" name="'.$this->fieldName.'[fieldName]" value="'.$this->fieldName.'" />';
		$this->html.='<input type="hidden" name="'.$this->fieldName.'[rule]" value="'.$this->rule.'" />';
		$this->html.='<input type="hidden" name="'.$this->fieldName.'[seo_old_link]" value="'.$this->seo_link.'" />';
		$this->html.='<table><tr>';
		$this->html.='<td><input type="checkbox" name="'.$this->fieldName.'[seo]" value="1" class="defaultCheckbox" '.$selected.' /></td>';
		$this->html.='<td><input type="text" name="'.$this->fieldName.'[seo_link]" value="'.$this->seo_link.'" class="defaultText"  style="width:373px;"/></td>';
		$this->html.='</tr></table>';
	}
	
	function saveData()
	{
		global $DB;
		global $INFO;
		
		$input=array("ą","Ą","ś","Ś","ć","Ć","ł","Ł","ź","Ź","ż","Ż","ń","Ń","ó","Ó","ę","Ę");
		$output=array("a","A","s","S","c","C","l","L","z","Z","z","Z","n","N","o","O","e","E");
		$this->seo_link=str_replace($input,$output,$this->seo_link);
		$this->seo_link=eregi_replace("[^0-9a-z_\.]","_",$this->seo_link);
		$this->seo_link=strtolower($this->seo_link);
		
		if($this->seo!=1)$this->seo=0;
		$DB->query("UPDATE ".$this->tableName." SET seo='".$this->seo."' WHERE ".$this->keyName."=".$this->key);
		if(!empty($this->seo_link))
		{		
			$DB->query("UPDATE ".$this->tableName." SET seo_link='".$this->seo_link."' WHERE ".$this->keyName."=".$this->key);
			$this->htaccess();
		}
		
		return true;
	}
	
	function htaccess()
	{
		$added=false;
		$lines=@file($this->htaccess);
		$num=sizeof($lines);
		for($i=0;$i<$num;$i++) 
		{
			$lines[$i]=trim($lines[$i]);
			$lines[$i+1]=trim($lines[$i+1]);
			if(($lines[$i]=="RewriteCond %{QUERY_STRING} ^(.*)") && ($lines[$i+1]=="RewriteRule ^".$this->seo_old_link."$ ".$this->rule.$this->key."&%1"))
			{
				$lines[$i+1]="RewriteRule ^".$this->seo_link."$ ".$this->rule.$this->key."&%1";
				$added=true;
			}
		}
		if(!$added) 
		{
			$lines[]="RewriteCond %{QUERY_STRING} ^(.*)";
			$lines[]="RewriteRule ^".$this->seo_link."$ ".$this->rule.$this->key."&%1";
		}
			
		@file_put_contents($this->htaccess,implode("\r\n",$lines));
	
	}
	
	function delData()
	{
		global $DB;
		
		$rs=$DB->query("SELECT seo_link FROM ".$this->tableName." WHERE ".$this->keyName."=".$this->key);
		$tab=$DB->fetch_array($rs);
		
		$lines=@file($this->htaccess);
		$num=sizeof($lines);
		for($i=0;$i<$num;$i++) 
		{
			$lines[$i]=trim($lines[$i]);
			$lines[$i+1]=trim($lines[$i+1]);
			if(($lines[$i]=="RewriteCond %{QUERY_STRING} ^(.*)") && ($lines[$i+1]=="RewriteRule ^".$tab["seo_link"]."$ ".$this->rule.$this->key."&%1"))
			{
				$i++;
			}
			else
			{
				$tmp[]=$lines[$i];
			}
		}
			
		@file_put_contents($this->htaccess,implode("\r\n",$tmp));
		
		return true;
	}
	
	
}

?>