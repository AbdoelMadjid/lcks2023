<?php
/* 12/6/2016 --> Sabtu, 28 Januari 2017 13.10.40 --> 07/01/2023 18:42
Design and Programming By. Abdul Madjid, S.Pd., M.Pd.
SMK Negeri 1 Kadipaten
Pin 520543F3 HP. 0812-3000-0420
https://twitter.com/AbdoelMadjid 
https://www.facebook.com/abdulmadjid.mpd
*/
//eval(base64_decode("
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING | E_DEPRECATED));	
session_start();
require 'config.php';


function antiinjection($data){
	$filter_sql = stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES)));
  	return $filter_sql;
}

$txtUser=antiinjection($_POST['txtUser']);
$txtPassword=antiinjection($_POST['txtPassword']);

if(count($message)==0){

	$loginQry = mysql_query("select * from app_users where concat(userid,katakunci)=concat('$txtUser',md5('$txtPassword'))")  or die ("Query Periksa katakunci Administrator Salah : ".mysql_error());
	$loginGuruQry = mysql_query("select * from app_user_guru where concat(userid,katakunci)=concat('$txtUser',md5('$txtPassword'))")  or die ("Query Periksa katakunci Guru Salah : ".mysql_error());
	$loginWaliKelasQry = mysql_query("select * from app_user_walikelas where concat(userid,katakunci)=concat('$txtUser',md5('$txtPassword'))")  or die ("Query Periksa katakunci Wali Kelas Salah : ".mysql_error());
	$loginSiswaQry = mysql_query("select * from app_user_siswa where concat(userid,katakunci)=concat('$txtUser',md5('$txtPassword'))")  or die ("Query Periksa katakunci Admin Salah : ".mysql_error());

	if(mysql_num_rows($loginQry)>=1)
	{
		$loginData = mysql_fetch_array($loginQry);
		if($loginData['hak']=="Master") {
			$_SESSION['SMART_MASTER'] = "Master";
			$_SESSION['SMART_LOGIN'] = $loginData['userid'];
			$LogIDUser=$loginData['id_user'];
			$LogWaktuLogin=$loginData['waktu_login'];
			$TglLogin=substr($LogWaktuLogin,0,4)."-".substr($LogWaktuLogin,5,2)."-".substr($LogWaktuLogin,8,2);
			$TglSekarang=date('Y-m-d');			
			if ($TglLogin==$TglSekarang)
			{	
				mysql_query("update app_users set waktu_logout='$LogWaktuLogin' where id_user='$LogIDUser'");
				mysql_query("update app_users set waktu_login=now() where id_user='$LogIDUser'");				
			}
			else
			{
				mysql_query("update app_users set waktu_logout='$LogWaktuLogin' where id_user='$LogIDUser'");
				mysql_query("update app_users set kunjung=kunjung+1 where id_user='$LogIDUser'");
				mysql_query("update app_users set waktu_login=now() where id_user='$LogIDUser'");
			}
			echo"<script>document.location='../index.php'</script>"; 

		} else if($loginData['hak']=="Admin") {
			$_SESSION['SMART_ADMIN'] = "Admin";
			$_SESSION['SMART_LOGIN'] = $loginData['userid'];
			$LogIDUserAdmin=$loginData['id_user'];
			$LogWaktuLoginAdmin=$loginData['waktu_login'];
			$TglLoginAdmin=substr($LogWaktuLoginAdmin,0,4)."-". substr($LogWaktuLoginAdmin,5,2)."-".substr($LogWaktuLoginAdmin,8,2);
			$TglSekarang=date('Y-m-d');			
			if ($TglLoginAdmin==$TglSekarang)
			{			
				mysql_query("update app_users set waktu_logout='$LogWaktuLoginAdmin' where id_user='$LogIDUserAdmin'");
				mysql_query("update app_users set waktu_login=now() where id_user='$LogIDUserAdmin'");
			}
			else
			{
				mysql_query("update app_users set waktu_logout='$LogWaktuLoginAdmin' where id_user='$LogIDUserAdmin'");
				mysql_query("update app_users set kunjung=kunjung+1 where id_user='$LogIDUserAdmin'");
				mysql_query("update app_users set waktu_login=now() where id_user='$LogIDUserAdmin'");
			}
			echo"<script>document.location='../index.php'</script>";

		} else if($loginData['hak']=="BpBk") {
			$_SESSION['SMART_BPBK'] = "BpBK";
			$_SESSION['SMART_LOGIN'] = $loginData['userid'];
			$LogIDUserBpBk=$loginData['id_user'];
			$LogWaktuLoginBpBk=$loginData['waktu_login'];
			$TglLoginBpBk=substr($LogWaktuLoginBpBk,0,4)."-". substr($LogWaktuLoginBpBk,5,2)."-".substr($LogWaktuLoginBpBk,8,2);
			$TglSekarang=date('Y-m-d');			
			if ($TglLoginBpBk==$TglSekarang)
			{			
				mysql_query("update app_users set waktu_logout='$LogWaktuLoginBpBk' where id_user='$LogIDUserBpBk'");
				mysql_query("update app_users set waktu_login=now() where id_user='$LogIDUserBpBk'");
			}
			else
			{
				mysql_query("update app_users set waktu_logout='$LogWaktuLoginBpBk' where id_user='$LogIDUserBpBk'");
				mysql_query("update app_users set kunjung=kunjung+1 where id_user='$LogIDUserBpBk'");
				mysql_query("update app_users set waktu_login=now() where id_user='$LogIDUserBpBk'");
			}
			echo"<script>document.location='../index.php'</script>";
		}
	}
	else if (mysql_num_rows($loginGuruQry)>=1) {
		$loginDataGuru = mysql_fetch_array($loginGuruQry);
		$QLogAktifGuru = JmlDt("select * from app_login_off where hak='Guru' and onoff='N'");
		if($QLogAktifGuru==0){
			if($loginDataGuru['hak']=="Guru") {
				$_SESSION['SMART_GURU'] = "Guru";
				$_SESSION['SMART_LOGIN'] = $loginDataGuru['userid'];
				$LogIDUserGuru=$loginDataGuru['id_guru'];
				$LogWaktuLoginGuru=$loginDataGuru['waktu_login'];
				$TglLoginGuru=substr($LogWaktuLoginGuru,0,4)."-".substr($LogWaktuLoginGuru,5,2)."-".substr($LogWaktuLoginGuru,8,2);
				$TglSekarangGuru=date('Y-m-d');			
				if ($TglLoginGuru==$TglSekarangGuru)
				{	
					mysql_query("update app_user_guru set waktu_logout='$LogWaktuLoginGuru' where id_guru='$LogIDUserGuru'");
					mysql_query("update app_user_guru set waktu_login=now() where id_guru='$LogIDUserGuru'");				
				}
				else
				{
					mysql_query("update app_user_guru set waktu_logout='$LogWaktuLoginGuru' where id_guru='$LogIDUserGuru'");
					mysql_query("update app_user_guru set kunjung=kunjung+1 where id_guru='$LogIDUserGuru'");
					mysql_query("update app_user_guru set waktu_login=now() where id_guru='$LogIDUserGuru'");
				}
				echo"<script>document.location='../index.php'</script>"; 

			}
		}
		else {echo"<script>document.location='../index.php?halkoe=login&g=0'</script>";}
	}	
	else if (mysql_num_rows($loginWaliKelasQry)>=1) {
		$loginDataWaliKelas = mysql_fetch_array($loginWaliKelasQry);
		$QLogAktifWK = JmlDt("select * from app_login_off where hak='Wali Kelas' and onoff='N'");
		if($QLogAktifWK==0){
			if($loginDataWaliKelas['hak']=="Wali Kelas") {
				$_SESSION['SMART_WALIKELAS'] = "Wali Kelas";
				$_SESSION['SMART_LOGIN'] = $loginDataWaliKelas['userid'];
				$LogIDUserWaliKelas=$loginDataWaliKelas['id_walikelas'];
				$LogWaktuLoginWaliKelas=$loginDataWaliKelas['waktu_login'];
				$TglLoginWaliKelas=substr($LogWaktuLoginWaliKelas,0,4)."-".substr($LogWaktuLoginWaliKelas,5,2)."-".substr($LogWaktuLoginWaliKelas,8,2);
				$TglSekarangWaliKelas=date('Y-m-d');			
				if ($TglLoginWaliKelas==$TglSekarangWaliKelas)
				{	
					mysql_query("update app_user_walikelas set waktu_logout='$LogWaktuLoginWaliKelas' where id_walikelas='$LogIDUserWaliKelas'");
					mysql_query("update app_user_walikelas set waktu_login=now() where id_walikelas='$LogIDUserWaliKelas'");				
				}
				else
				{
					mysql_query("update app_user_walikelas set waktu_logout='$LogWaktuLoginWaliKelas' where id_walikelas='$LogIDUserWaliKelas'");
					mysql_query("update app_user_walikelas set kunjung=kunjung+1 where id_walikelas='$LogIDUserWaliKelas'");
					mysql_query("update app_user_walikelas set waktu_login=now() where id_walikelas='$LogIDUserWaliKelas'");
				}
				echo"<script>document.location='../index.php'</script>"; 
			}
		}
		else {echo"<script>document.location='../index.php?halkoe=login&wk=0'</script>";}
	}
	else if (mysql_num_rows($loginSiswaQry)>=1) {
		$loginDataSiswa = mysql_fetch_array($loginSiswaQry);
		$QLogAktifWK = JmlDt("select * from app_login_off where hak='Siswa' and onoff='N'");
		if($QLogAktifWK==0){
			if($loginDataSiswa['hak']=="Siswa") {
				$_SESSION['SMART_SISWA'] = "Wali Kelas";
				$_SESSION['SMART_LOGIN'] = $loginDataSiswa['userid'];
				$LogIDUserSiswa=$loginDataSiswa['nis'];
				$LogWaktuLoginSiswa=$loginDataSiswa['waktu_login'];
				$TglLoginSiswa=substr($LogWaktuLoginSiswa,0,4)."-".substr($LogWaktuLoginSiswa,5,2)."-".substr($LogWaktuLoginSiswa,8,2);
				$TglSekarangSiswa=date('Y-m-d');			
				if ($TglLoginSiswa==$TglSekarangSiswa)
				{	
					mysql_query("update app_user_siswa set waktu_logout='$LogWaktuLoginSiswa' where nis='$LogIDUserSiswa'");
					mysql_query("update app_user_siswa set waktu_login=now() where nis='$LogIDUserSiswa'");				
				}
				else
				{
					mysql_query("update app_user_siswa set waktu_logout='$LogWaktuLoginSiswa' where nis='$LogIDUserSiswa'");
					mysql_query("update app_user_siswa set kunjung=kunjung+1 where nis='$LogIDUserSiswa'");
					mysql_query("update app_user_siswa set waktu_login=now() where nis='$LogIDUserSiswa'");
				}
				echo"<script>document.location='../index.php'</script>"; 
			}
		}
		else {echo"<script>document.location='../index.php?halkoe=login&siswa=0'</script>";}
	}
	else{
		echo"<script>document.location='../index.php?halkoe=login&q=0'</script>";
	}
}
//"))
?>
 
