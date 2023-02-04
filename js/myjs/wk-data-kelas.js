	function TampilSemester(str1)
	{
	if (str1=='')
	  {
	  document.getElementById('txtTampilSmstr').innerHTML='';
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
		document.getElementById('txtTampilSmstr').innerHTML=xmlhttp.responseText;
		}
	  }
	xmlhttp.open('GET','pages/wk-data-kelas-cari.php?smst='+str1,true);
	xmlhttp.send();
	}

	