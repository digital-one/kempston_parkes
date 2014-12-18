<?php

class config
{
	private $con_file="classes/config.xml";
	private $xml;
	
	function __construct($con_file=null)
	{
		if($con_file!=null) $this->con_file=$con_file;
		$this->configuration();
	}
	
	function configuration()
	{
		$this->xml=simplexml_load_file($this->con_file);
	}
	
	function get($xpath)
	{
		$ret=false;
		
		foreach($this->xml->xpath($xpath) AS $tmp)
		{
			//$value=iconv("UTF-8","ISO-8859-2",(string)$tmp["value"]);
			$value=(string)$tmp["value"];
			break;
		}
		
		if(!empty($value)) $ret=$value;
		else $ret=(string)$tmp;
				
		return $ret;
	}

}

?>