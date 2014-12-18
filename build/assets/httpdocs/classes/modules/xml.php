<?php 
class xml
{
	var $xml;
		
	function xml()
	{
		$this->xml='<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
		$this->xml.='<items>';
		
		$modules[0]="news";
		$modules[1]="page";
		$modules[2]="gallery";
		$modules[3]="files";

	
		if(!in_array($_GET["action"],$modules)) 
		{
			foreach($modules AS $module) $this->$module();
		}
		else $this->$_GET["action"]();
		
		$this->xml.='</items>';
		
		header("Content-type: text/xml; charset=UTF-8");
		print($this->xml);
		
	}
	
	function news()
	{
		global $DB;
		$query="SELECT * FROM news WHERE active=1";
		$rs=$DB->query($query);
		$this->xml.="<news>";
		while($tab=$DB->fetch_array($rs))
		{
			$this->xml.="<item>";
			$this->xml.="<date>".$tab["newsDate"]."</date>";
			$this->xml.="<title><![CDATA[".stripslashes($tab["title"])."]]></title>";
			$this->xml.="<shortDescription><![CDATA[".stripslashes($tab["shortDescription"])."]]></shortDescription>";
			$this->xml.="<description><![CDATA[".stripslashes($tab["description"])."]]></description>";
			$this->xml.="<img>";
			$this->xml.="<big>data/news/image/".$tab["photo"]."</big>";		
			$this->xml.="<small>data/news/image/100x75/".$tab["photo"]."</small>";			
			$this->xml.="</img>";
			$this->xml.="</item>";			
		}
		$this->xml.="</news>";
	}
	
	function gallery()
	{
		global $DB;
		$query="SELECT * FROM gallery WHERE active=1";
		$rs=$DB->query($query);
		$this->xml.="<galleries>";
		while($tab=$DB->fetch_array($rs))
		{
			$this->xml.="<item>";
			$this->xml.="<title><![CDATA[".stripslashes($tab["title"])."]]></title>";
			$this->xml.="<description><![CDATA[".stripslashes($tab["description"])."]]></description>";
			$this->xml.="<img>";
				$this->xml.="<big>data/gallery/image/".$tab["photo"]."</big>";		
				$this->xml.="<small>data/gallery/image/100x75/".$tab["photo"]."</small>";			
			$this->xml.="</img>";
			$this->xml.="<images>";
				$q2="SELECT * FROM gallery_photo WHERE active=1 AND galleryId=".$tab["id"];
				$rs2=$DB->query($q2);
				while($tab2=$DB->fetch_array($rs2))
				{
					$this->xml.="<img>";
					$this->xml.="<title><![CDATA[".stripslashes($tab2["title"])."]]></title>";
					$this->xml.="<big>data/gallery_photo/image/".$tab2["photo"]."</big>";		
					$this->xml.="<small>data/gallery_photo/image/100x75/".$tab2["photo"]."</small>";			
					$this->xml.="</img>";					
				}
			$this->xml.="</images>";
			$this->xml.="</item>";
		}
		$this->xml.="</galleries>";
	}
	
	function files()
	{
		global $DB;
		$query="SELECT * FROM files WHERE active=1";
		$rs=$DB->query($query);
		$this->xml.="<files>";
		while($tab=$DB->fetch_array($rs))
		{
			$this->xml.="<item>";
			$this->xml.="<name><![CDATA[".stripslashes($tab["name"])."]]></name>";
			$this->xml.="<path>data/files/file/".$tab["filename"]."</path>";
			$this->xml.="</item>";	
		}
		$this->xml.="</files>";
	}
	

	function page()
	{
		global $DB;
		$query="SELECT * FROM page WHERE active=1";
		$rs=$DB->query($query);
		$this->xml.="<pages>";
		while($tab=$DB->fetch_array($rs))
		{
			$this->xml.="<item>";
				$this->xml.="<title><![CDATA[".stripslashes($tab["title"])."]]></title>";
				$this->xml.="<keywords><![CDATA[".stripslashes($tab["keywords"])."]]></keywords>";
				$this->xml.="<description><![CDATA[".stripslashes($tab["description"])."]]></description>";
				$this->xml.="<content><![CDATA[".stripslashes($tab["content"])."]]></content>";
				$this->xml.="<name><![CDATA[".stripslashes($tab["name"])."]]></name>";
			$this->xml.="</item>";			
		}
		$this->xml.="</pages>";
	}
	
}

	
?>