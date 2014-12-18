<!--

// funkcja pokazujaca kalendarz pod kursorem myszy
function showKal2(fp)
{
	data = new Date(arok, amies, 1);
	mies = data.getMonth();
	rok = data.getFullYear();
	dzien = data.getDate();
	dzientyg = data.getDay();
	
	dniMies();

	frmpole = fp;
	pozx = x;
	pozy = y;

	rysujKal2();		
	
	if(ns6 || ie)
	{
		document.getElementById('kalendarz').style.left = pozx+'px';
		document.getElementById('kalendarz').style.top = (pozy+10)+'px';
		document.getElementById('kalendarz').style.visibility = 'visible';
	}
}

function hideKal2()
{
	if(ns6 || ie)
		document.getElementById('kalendarz').style.visibility = 'hidden';

	// tutaj ustawia siê format daty 		 
	// np:
  	//	format = selectday + ' ' + miesiac[mies] + ' ' + rok;
	
	// inny format daty - z zerami poprzedzaj±cymi
	mies++;
	if(mies < 10)
		mies = '0' + mies;
	if(selectday < 10)
		selectday = '0' + selectday;

	format = rok+'-'+mies+'-'+selectday	
	//format = selectday+'.'+mies+'.'+rok;
			
	frmpole.value = frmpole.value + format + "; ";
}

// rysowanie kalendarza
function rysujKal2()
{
	kaltxt = '<form name="sdata" onSubmit="return false;">';
	kaltxt += '<table border=0 cellpadding=0 cellspacing=2 style="border:'+kol[5]+' 1px solid;background-color:'+kol[0]+';">';
	kaltxt += '<tr class=dzien><td colspan=6 height=25><select name="month" class="lista" onChange="setData()">';		
	for(i=0;i<12;i++)
	{
		if(i==mies)
			kaltxt += '<option value="'+i+'" selected>'+miesiac[i]+'</option>';
		else
			kaltxt += '<option value="'+i+'">'+miesiac[i]+'</option>';
	}
	kaltxt += '</select>&nbsp;<select name="year" class="lista" onChange="setData()">';
	for(i=(rok-wstecz);i<=(rok+wprzod);i++)
	{
		if(i==rok)
			kaltxt += '<option value="'+i+'" selected>'+i+'</option>';
		else
			kaltxt += '<option value="'+i+'">'+i+'</option>';	
	}
	kaltxt += '</select>';
	kaltxt += '</td><td><a href="javascript:exitKal()"><span class="aktday">&nbsp;X&nbsp;</span></a></td></tr>';
	kaltxt += '<tr class=dnityg><td width=30>Nd</td><td width=30>Pn</td><td width=30>Wt</td><td width=30>¦r</td>';
	kaltxt += '<td width=30>Czw</td><td width=30>Pt</td><td width=30>So</td></tr><tr class=dzien>';

	j = 1;

	for(i=0;i<dzientyg+dni[mies];i++)
	{
		if(i>=dzientyg)
		{
			if(j==adzien && rok==arok && mies==amies)
				kaltxt += '<td class=aktday><a class=aktday href="javascript:selectday='+j+';hideKal2();" >'+j+'</a></td>';
			else if(i%7==0)
				kaltxt += '<td class=niedz><a class=niedz href="javascript:selectday='+j+';hideKal2();" >'+j+'</a></td>';
			else
				kaltxt += '<td><a class=dzien href="javascript:selectday='+j+';hideKal2();" >'+j+'</a></td>';
			j++;
			if(i%7==6)
				kaltxt += '</tr><tr class=dzien>';
		}
		else
			kaltxt += '<td></td>';
	}

	kaltxt += '</tr></table></form>';
	
	document.getElementById("kalendarz").innerHTML = kaltxt;
}




