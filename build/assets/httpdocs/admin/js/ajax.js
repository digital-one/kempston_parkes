var http_request = false;
function ajaxRequest(dane,target,method,refresh,charset) 
	{
		refresh = refresh 	|| false;
		charset = charset 	|| "iso-8859-2";
		method  = method 	|| "GET";
		
		if (window.XMLHttpRequest) 
		{ // Mozilla, 
            http_request = new XMLHttpRequest();
            if (http_request.overrideMimeType) 
			{
                http_request.overrideMimeType('text/xml');
            }
        } 
		else if (window.ActiveXObject) 
		{ // IE
			try 
			{
                http_request = new ActiveXObject("Microsoft.XMLHTTP");
            } 
			catch (e) {}
        }

        if (!http_request) 
		{
            alert('Nie mogê stworzyæ instancji obiektu XMLHTTP');
            return false;
        }
		
		if(refresh)	http_request.onreadystatechange=callback;
        http_request.open(method, target, true);
		http_request.setRequestHeader('Content-Type','application/x-www-form-urlencoded; charset=iso-8859-2');
		http_request.send(dane);
	}
	
	function callback()
	{
		
		if (http_request.readyState ==4) 
		{
			if (http_request.status == 200) 
			{
				document.write(http_request.responseText);
			} 
			else
			{
				alert('Wyst¹pi³ problem z zapytaniem.');
			}
			
		}
	}