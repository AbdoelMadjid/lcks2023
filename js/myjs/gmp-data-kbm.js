	function TampilMapeldanKelas(str)
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
	xmlhttp.open('GET','pages/gmp-data-kbm-cari.php?mapkel='+str,true);
	xmlhttp.send();
	}

	function TampilSemester(str1)
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
	xmlhttp.open('GET','pages/gmp-data-kbm-cari.php?smst='+str1,true);
	xmlhttp.send();
	}


	function JenisMapel(str3)
	{
	if (str3=='')
	  {
	  document.getElementById('txtHint3').innerHTML='';
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
		document.getElementById('txtHint3').innerHTML=xmlhttp.responseText;
		}
	  }
	xmlhttp.open('GET','pages/gmp-data-kbm-cari.php?jenmapel='+str3,true);
	xmlhttp.send();
	}