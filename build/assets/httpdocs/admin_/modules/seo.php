<?php
class seo extends module
{
	function __construct()
	{
		parent::__construct();
	}
	
	function show()
	{
		if ($_GET['action']=="generate")		$this->generate(); 
		else 									$this->form();
	}
	
	function form() //1
	{
		require_once('./modules/seo/stats.php');
		$this->title=$this->name;
		$tmp=new stats();
		$this->content=$tmp->html;
		$this->generateHtml();
	}

	
	
	/*
	function generateHtaccess() //2
	{
		global $LINK;
		global $INFO;
		global $DB;
		
		$buf=true;
		$htaccess="../.htaccess";
		
		if($_GET["active"]) $active=" AND active=1";
		
		$rs=$DB->query("SELECT id,seo_link FROM page WHERE seo=1".$active);
		while($tab=$DB->fetch_array($rs))
		{
			$links.="RewriteCond %{QUERY_STRING} ^(.*)\nRewriteRule ^".$tab["seo_link"]."$ index.php?module=page&pageId=".$tab["id"]."&%1\n";
		}
		
		$rs=$DB->query("SELECT id,seo_link FROM form WHERE seo=1".$active);
		while($tab=$DB->fetch_array($rs))
		{
			$links.="RewriteCond %{QUERY_STRING} ^(.*)\nRewriteRule ^".$tab["seo_link"]."$ index.php?module=form&formId=".$tab["id"]."&%1\n";
		}
		
		if(!is_file($htaccess))
		{
			$INFO->setInfo("No <b>.htaccess</b> file found","error");
		}
		else
		{
			$fp=fopen($htaccess,"r");
			
			while(!feof($fp))
			{
				$line=fgets($fp);
				
				if(trim($line)=="######DO-NOT-REMOVE-OR-MODIFY######") 
				{
					if($buf) $buf=false;
					else $buf=true;
					continue;
				}
				
				if($buf) $tmpfile[]=$line;
			}
			
			fclose($fp);
			
			$fp=fopen($htaccess,"w");
			
			$file=implode("",$tmpfile);
			fwrite($fp,$file."\n######DO-NOT-REMOVE-OR-MODIFY######\n".$links."\n######DO-NOT-REMOVE-OR-MODIFY######\n");
			
			fclose($fp);

		
			$INFO->setInfo("SEO Links generated successfully.","info");
		}
		
		header("Location: ".($LINK->getLink("","action")));
	}
	*/
	
	
	
}

?>
