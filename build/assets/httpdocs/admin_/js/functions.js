<!--
function otworz(co,name,x,y)
 {
    if(!name){name='nowe'};
    if(!x){x=570};
    if(!y){y=520};
    config='toolbar=no,location=no,directories=no,status=no,menubar=no,width='+x+',height='+y+',scrollbars=no,resizable=no';
    window.open(co,name,config);
 }
 
 
function getFormData(formID) 
	{	
		var ret="";
		var form=document.getElementById(formID);
		var size=form.elements.length;
		for(i=0;i<size;i++) 
		{
				ret+=form.elements[i].name+"="+form.elements[i].value;
				if((i+1)!=size) ret+="&";
		}
		
		return  ret;  
	}

	
function changeOption(optionId,selectId,id,label)
{
	var select=document.getElementById(selectId)

	if(!document.getElementById(optionId).checked) 
		{
			//usuwamy jesli istnieje
			//select.options.length=0;
			select.add(new Option(label,id));
		}
	else 
		{
			//dodajemy jesli istnieje
			select.add(new Option(label,id));
		}
}

 
 function showColorPicker(id)
 {
    var wp;
	
    config='toolbar=no,location=no,directories=no,status=no,menubar=no,width=330,height=320,scrollbars=no,resizable=no';
	content='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html><head><title>Color Picker</title><script src="js/colorPicker.js" type="text/javascript"></script></head><body style="margin:0px;"><input type="text" name="value" value="'+document.getElementById(id).value+'" id="value"></body></html>';
		
	wp=window.open('','colorPicker',config);
	wp.document.open();
	wp.document.write(content);
	wp.opener=self;
	wp.returnObjectId=id;
	wp.document.close(); 
	wp.focus();
 }
 
	
//-->

