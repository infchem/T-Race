gplinks.refresh_content = function(rel,evt){
	var pw=document.getElementById('pw').value;
	var text;
	if (this.href.indexOf('cmd=refreshd')==-1)
		text=document.getElementById('srct').value;
	else
		text=document.getElementById('tgtt').value;
	if (text=='')
		return false;
	evt.preventDefault();
	var href = jPrep(this.href)+'&pw='+pw+'&text='+text;
	$.getJSON(href,ajaxResponse2);
	//$.getJSON(href,ajaxResponse);
}

function ajaxResponse2(a)
{
	//alert(a->toSource()); // a>0>SELECTOR,CONTENT,DO
	var area = $(a[0]['SELECTOR'])[0];
	area.value = a[0]['CONTENT'];
	//thanks for fix http://stackoverflow.com/questions/1927593/cant-update-textarea-with-javascript-after-writing-to-it-manualy#answer-7576728
}

