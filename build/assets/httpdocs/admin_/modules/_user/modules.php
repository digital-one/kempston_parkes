<?php
require_once('./classes/component.php');


class modules extends component
{
	var $options;
	var $num=0;
	var $main;
	var $level=0;
	var $mainOptions;
	
	function modules($fieldName=null,$key=null)
	{
		if($fieldName!=null) 	$this->fieldName=$fieldName;
		if($key!=null) 			$this->key=$key;
		$this->generateHtml();
	}
	
	function generateHtml()
	{	
		global $DB;
		$this->html.='
		<script language="JavaScript" type="text/JavaScript">
		<!--
		function changeOptions(checkbox,name,value)
		{
			var select=document.getElementById(\''.$this->fieldName.'Main\');
			if(!checkbox.checked) 
			{
				
				var n=0;
				var tmp=new Array(); 				
				for(i=0;i<select.length;i++) 
				{
					if(select.options[i].value!=value) 
					{ 
						tmp[n]=new Option(select.options[i].text,select.options[i].value);
						n++;
					}
				}
				select.length=n;
				for(i=0;i<n;i++) select.options[i]=new Option(tmp[i].text,tmp[i].value);
				
				
			}
			else 
			{
				var found=false;
				for(i=0;i<select.length;i++) 
				{
					if(select.options[i].value==value) found=true;
				}
				if(!found) select.options[select.length]=new Option(name,value);
			}
		

		}
		//-->
		</script>';
		$this->html.='<input type="hidden" 	name="'.$this->fieldName.'[fieldName]" 	value="'.$this->fieldName.'" />';
		$this->html.='<table width="400"><tr><td>';
		$this->html.='<table>';
		
		$this->branch();
		
		$this->html.='</table>';
		$this->html.='</td></tr><tr><td>';
		$this->html.='<hr class="defaultHr" />Start module: <select name="'.$this->fieldName.'[main]" id="'.$this->fieldName.'Main">'.$this->mainOptions.'</select>';
		$this->html.='</td></tr></table>';
		$this->html.='<input type="hidden" 	name="'.$this->fieldName.'[num]" 	value="'.$this->num.'" />';
	}
	
	function branch($parentId=0)
	{
		global $DB;
		
		$this->level++;
		
		if(is_numeric($this->key))
			$query="SELECT 
						m.id,
						m.name,
						m.label,
						m.dirName,
						m.xml,
						(SELECT x.rights FROM _user_module AS x WHERE x.userId=".$this->key." AND x.moduleId=m.id LIMIT 1) AS rights,
						(SELECT count(*) FROM _user_module WHERE userId=".$this->key." AND moduleId=m.id AND main=1 LIMIT 1) AS main,
						(SELECT count(*) FROM _user_module WHERE userId=".$this->key." AND moduleId=m.id LIMIT 1) AS checked 
					FROM 
						_module AS m 
					WHERE 
						m.active=1 AND
						m.parentId=".$parentId."
					ORDER BY m.position ASC";
		else 
			$query="SELECT m.id,m.name,m.label FROM _module AS m WHERE active=1 AND m.parentId=".$parentId;
	
		for($i=1;$i<$this->level;$i++) 
		{
			if(($i+1)==$this->level) $padding.="&nbsp;&nbsp;|&ndash;";
			else $padding.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		}
		
		$rs=$DB->query($query);
		while($tab=$DB->fetch_array($rs))
		{
			if(!$tab["label"]) $onClick='onClick="changeOptions(this,\''.$tab["name"].'\',\''.$tab["id"].'\');"';
			else $onClick='';
			
			$this->html.='<tr>';
			$this->html.='<td><table cellpadding="2" cellspacing="0" border="0"><tr><td>'.$padding.'</td><td><input class="defaultCheckbox" type="checkbox" '.$onClick.' name="'.$this->fieldName.'[fieldValue]['.$this->num.'][id]" value="'.$tab["id"].'"';
			if($tab["checked"]) 
			{
				$this->html.=' checked="checked"';
				
				if(!$tab["label"])
				{
					$this->mainOptions.='<option value="'.$tab["id"].'"';
					if($tab["main"]) $this->mainOptions.=' selected="selected"';
					$this->mainOptions.='>'.$tab["name"].'</option>';
				}
			}
			$this->html.=' /></td><td style="padding-right:20px;" nowrap>'.$tab["name"].'</td></tr></table></td>';
			
			
			$this->html.='<td>';	
			
			
			// rights
			
			$xml="./modules/".$tab["dirName"]."/".$tab["xml"];
			if(is_file($xml))
			{
				$rights=@unserialize($tab["rights"]);
				$xml=@simplexml_load_file($xml);
				foreach(@$xml->xpath('/module/right') as $right)
				{
					$rightName=(string)$right["name"];
					$this->html.=(string)$right["label"].'&nbsp;<input class="defaultCheckbox" type="checkbox" name="'.$this->fieldName.'[fieldValue]['.$this->num.']['.$rightName.']" value="1"';
					if($rights[$rightName]) $this->html.=' checked="checked" ';
					$this->html.='/>';
				}
			}
		
			$this->html.='</td>';			
			$this->html.='</tr>';
			$this->num++;
			
			$this->branch($tab["id"]);
			
		}
		
		$this->level--;
		
	}
	
	function saveData()
	{
		global $DB;
		if(is_numeric($this->key))
		{
			$DB->query("DELETE FROM _user_module WHERE userId=".$this->key);
			for($i=0;$i<$this->num;$i++)
			{
				if(is_numeric($this->fieldValue[$i]['id']))
				{
					$rs=$DB->query("SELECT position,parentId,dirName,xml FROM _module WHERE id=".$this->fieldValue[$i]['id']);
					$tab=$DB->fetch_array($rs);
					
					unset($rights);
					$xml="./modules/".$tab["dirName"]."/".$tab["xml"];
					if(is_file($xml))
					{
						$xml=@simplexml_load_file($xml);
						foreach(@$xml->xpath('/module/right') as $right)
						{
							$rightName=(string)$right["name"];
							if($this->fieldValue[$i][$rightName]) $rights[$rightName]=1;
							else $rights[$rightName]=0;
						}
					}
										
					$DB->query("INSERT INTO _user_module (`userId`,`moduleId`,`position`,`parentId`,`rights`) VALUES (".$this->key.",".$this->fieldValue[$i]['id'].",".$tab["position"].",".$tab["parentId"].",'".serialize($rights)."')");
				}
			}
			
			if(is_numeric($this->main))
			$DB->query("UPDATE _user_module SET main=1 WHERE userId=".$this->key." AND moduleId=".$this->main);
		}
		
		return true;
	}
	
	function delData()
	{
		global $DB;
		if(is_numeric($this->key))
		$DB->query("DELETE FROM _user_module WHERE userId=".$this->key);
		
		return true;
	}

}

?>