<?php

class stats
{
	var $html;
	
	function __construct()
	{
		global $MODULE;
		global $CONF;
		
		
		
		$this->html='
			<iframe width="100%" height="100%" src="'.$CONF->get("/configuration/seo/statsUrl").'" frameborder="0">
					
			</iframe>';
	}
}

?>