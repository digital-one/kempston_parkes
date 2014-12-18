<?php

	function cutString($data,$len=210)
	{
		$ret="";
		$data=trim($data);
		
			if(strlen($data)>$len)
			{
				$pos=strpos($data," ",$len);
				$ret=substr($data,0,$pos)." ...";
			}
			else $ret=$data;

		
		return $ret;
	}
	
	function replace_chrs($ret)
	{
		$ret=trim($ret);
		$input=array("ą","Ą","ś","Ś","ć","Ć","ł","Ł","ź","Ź","ż","Ż","ń","Ń","ó","Ó","ę","Ę"," ","&","-");
		//$input=array("Ä…","Ä„","Å›","Åš","Ä‡","Ä†","Å‚","Å","Åº","Å¹","Å¼","Å»","Å„","Åƒ","Ã³","Ã“","Ä™","Ä˜");
		//$input=array("Ä","Ä","Ĺ","Ĺ","Ä","Ä","Ĺ","Ĺ","Ĺş","Ĺš","Ĺź","Ĺť","Ĺ","Ĺ","Ăł","Ă","Ä","Ä"," ");
		$output=array("a","A","s","S","c","C","l","L","z","Z","z","Z","n","N","o","O","e","E","_","_","_");
			
		$ret=str_replace($input,$output,$ret);
		$ret=strtolower($ret);
		$ret=str_replace("_____","_",$ret);		
		$ret=str_replace("____","_",$ret);
		$ret=str_replace("___","_",$ret);
		$ret=str_replace("__","_",$ret);
		
		return $ret;
	}
	
?>