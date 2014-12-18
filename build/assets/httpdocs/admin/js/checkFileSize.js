function checkFileSize(id,maxFileSize)
{
	var fileName=document.getElementById(id).value;
		
	if (window.ActiveXObject) 
	{
		var fso = new ActiveXObject('Scripting.FileSystemObject');
		var file = fso.GetFile(fileName);
		if(maxFileSize<file.Size) 
		{
			alert('Przekroczono maxymalny rozmiar pliku.\nMaxymalny rozmiar pliku to: '+maxFileSize);
			document.getElementById(id).value='';
		}
	}
	else if(window.XMLHttpRequest)
	{
	}
}
	

