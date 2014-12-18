<!--

function openPopup(co,name,x,y)
 {
    if(!name){name='nowe'};
    if(!x){x=570};
    if(!y){y=520};
    config='toolbar=no,location=no,directories=no,status=no,menubar=no,width='+x+',height='+y+',scrollbars=no,resizable=no';
    window.open(co,name,config);
 }

function openImage(img,title,windowName,x,y)
 {
    var wp;
    config='toolbar=no,location=no,directories=no,status=no,menubar=no,width='+x+',height='+y+',scrollbars=no,resizable=no';
	content='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html><head><title>'+title+'</title></head><body style="margin:0px;"><img src="'+img+'" alt="'+title+'" onclick="window.close();" /></body></html>';
		
	wp=window.open('',windowName,config);
	wp.document.open();
	wp.document.write(content);
	wp.document.close(); 
	wp.focus();
 }
 
 function showBox()
  {  
    var width = document.documentElement.clientWidth + document.documentElement.scrollLeft; 

    var layer = document.createElement('div');
    layer.style.zIndex = 2;
    layer.id = 'infoLayer';
    layer.style.position = 'absolute';
    layer.style.top = '0px';
    layer.style.left = '0px';
    layer.style.height = document.documentElement.scrollHeight + 'px';
    layer.style.width = width + 'px';
    layer.style.backgroundColor = '#053249';
    layer.style.opacity = '.6';
    layer.style.filter += ("progid:DXImageTransform.Microsoft.Alpha(opacity=60)");
    document.body.appendChild(layer);  
    
    var div = document.createElement('div');
    div.style.zIndex = 3;
    div.id = 'infoBox';
    div.style.position = (navigator.userAgent.indexOf('MSIE 6') > -1) ? 'absolute' : 'fixed';
    div.style.top = '200px';
    div.style.left = (width / 2) - (400 / 2) + 'px'; 
    //div.style.height = '150px';
    div.style.width = '400px';
    div.style.backgroundColor = '#8cbbd5';
    div.style.border = '5px solid #053249';
    div.style.padding = '20px';
    document.body.appendChild(div);  
    
	div.appendChild(document.getElementById('info'));
	
    
  }
  
  function hideBox()
  {
		document.body.removeChild(document.getElementById('infoLayer'));
		document.body.removeChild(document.getElementById('infoBox'));
  }
 
 
 
//-->