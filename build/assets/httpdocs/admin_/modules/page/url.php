<?php
require_once('./classes/component.php');
require_once('./classes/components/table.php');
require_once('./classes/components/text.php');
require_once('./classes/components/checkbox.php');

class url extends component
{
	var $htaccess="../.htaccess";
	function url($fieldName=null,$url=null,$revrite=null,$replace=null,$params=null)
	{
		if($fieldName!=null)	$this->fieldName=$fieldName;
		if($url!=null)			$this->url=$url;
		if($revrite!=null)		$this->revrite=$revrite;
		if($replace!=null)		$this->replace=$replace;
		if($params!=null)		$this->params=$params;
		$this->css='defaultText';
		$this->generateHtml();
	}
	
	function generateHtml()
	{
		$this->html.='<input type="hidden" name="'.$this->fieldName.'[fieldName]" value="'.$this->fieldName.'" />';
		$this->html.='<input type="text"   name="'.$this->fieldName.'[url]" value="'.$this->url.'" class="'.$this->css.'" '.$this->params.' />';
		$this->html.='<input type="hidden" name="'.$this->fieldName.'[revrite]" value="'.$this->revrite.'" />';
		$this->html.='<input type="hidden" name="'.$this->fieldName.'[replace]" value="'.$this->replace.'" />';
		$this->html.='<input type="hidden" name="'.$this->fieldName.'[oldUrl]" value="'.$this->url.'" />';
		
	}
	
	function saveData()
	{
		global $DB;
		global $INFO;
		
		$input=array("ą","Ą","ś","Ś","ć","Ć","ł","Ł","ź","Ź","ż","Ż","ń","Ń","ó","Ó","ę","Ę");
		$output=array("a","A","s","S","c","C","l","L","z","Z","z","Z","n","N","o","O","e","E");
		$this->url=str_replace($input,$output,$this->url);
		$this->url=eregi_replace("[^0-9a-z_\.]","_",$this->url);
		$this->url=strtolower($this->url);
		
		if( (!empty($this->tableName)) && (!empty($this->fieldName)) && (!empty($this->keyName)) && (is_numeric($this->key)) )
		{
			$DB->query("UPDATE ".$this->tableName." SET ".$this->fieldName."='".$this->url."' WHERE ".$this->keyName."=".$this->key);
			$this->modifyHtaccess();			
		}
		else $ret=false;
		
		
	
		return true;
	}
	
	


	
	function delData()
	{
		global $DB;
				
		$rs=$DB->query("SELECT ".$this->fieldName." FROM ".$this->tableName." WHERE ".$this->keyName."=".$this->key);
		$tab=$DB->fetch_array($rs);
		$this->oldUrl=$tab[$this->fieldName];
		
		$this->modifyHtaccess("del");			
			
		return true;
	}
	
	function modifyHtaccess($action="add")
	{
		$lines=@file($this->htaccess);
		$num=sizeof($lines);
		$len=strlen("RewriteRule ^".$this->oldUrl."$");
		$found=false;
		$pos=0;
		$start=false;
			
		//old entry
		for($i=0;$i<$num;$i++) 
		{
			$lines[$i]=trim($lines[$i]);
			
			if($lines[$i]=="######DO-NOT-REMOVE-OR-MODIFY######") 
			{
				$start=true; 
				continue;
			}
			
			if(($start) && (!empty($this->oldUrl)))
			if((substr($lines[$i],0,$len)=="RewriteRule ^".$this->oldUrl."$")) 
			{
				$found=true; 
				$pos=$i;
			}
		}
		
		if($start)
		if(($action=="add") && (!empty($this->url)))
		{
			if(!empty($this->url)) 
			{
				if(!empty($this->replace))
				{
					$tmp=$this->replace;
					$this->revrite=str_replace('{key}',$this->$tmp,$this->revrite);
				}
				
				$tmp="RewriteRule ^".$this->url."$ ".$this->revrite;
				if($found) $lines[$pos]=$tmp;
				else $lines[]=$tmp;
			}

		}
		else 
		{
			unset($tmp);
			for($i=0;$i<$num;$i++) 
			{
				if(($pos>0) && ($i==$pos)) continue;
				$tmp[]=$lines[$i];
			}
			$lines=$tmp;
		}
			
		@file_put_contents($this->htaccess,implode("\r\n",$lines));
	}
	
	
}

?>