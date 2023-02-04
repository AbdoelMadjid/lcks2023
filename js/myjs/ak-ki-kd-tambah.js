	function LihatMapel(str)
	{
	if (str=='')
	  {
	  document.getElementById('txtHint').innerHTML='';
	  return;
	  }
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject('Microsoft.XMLHTTP');
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
		document.getElementById('txtHint').innerHTML=xmlhttp.responseText;
		}
	  }
	xmlhttp.open('GET','pages/akademik-ki-kd-tambah.php?jmp='+str,true);
	xmlhttp.send();
	}

	function LihatJenis(str1)
	{
	if (str1=='')
	  {
	  document.getElementById('txtHint1').innerHTML='';
	  return;
	  }
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject('Microsoft.XMLHTTP');
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
		document.getElementById('txtHint1').innerHTML=xmlhttp.responseText;
		}
	  }
	xmlhttp.open('GET','pages/akademik-ki-kd-tambah.php?mpnya='+str1,true);
	xmlhttp.send();
	}