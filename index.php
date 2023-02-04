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
date_default_timezone_set('Asia/Jakarta');
session_start();
include("lib/config.php");

if($UnCons=="Y"){

	include("inc/underc.php");
}
else {
	if(empty($_SESSION['SMART_LOGIN'])){
		$SalahLogin="";
		$q=isset($_GET['q'])?$_GET['q']:null;
		$g=isset($_GET['g'])?$_GET['g']:null;
		$wk=isset($_GET['wk'])?$_GET['wk']:null;
		$w=isset($_GET['w'])?$_GET['w']:null;
		$siswa=isset($_GET['siswa'])?$_GET['siswa']:null;
		$k=-1;
		if($k<$q){
			$SalahLogin .= "<div class='alert alert-danger'><p class='small'><strong>Maaf,</strong> Username atau Password Salah !!</p></div>";
		}
		else if($k<$g){
			$SalahLogin .= "<div class='alert alert-danger'><p class='small'><strong>Maaf,</strong> Akses Guru sedang di tutup !!<br>Silakan hubungi Administrator</p></div>";		
		}
		else if($k<$wk){
			$SalahLogin .= "<div class='alert alert-danger'><p class='small'><strong>Maaf,</strong> Akses Wali Kelas sedang di tutup !!<br>Silakan hubungi Administrator</p></div>";		
		}
		else if($k<$w){
			$SalahLogin .= "<div class='alert alert-danger'><p class='small'><strong>Maaf,</strong> Anda bukan Wali Kelas tahun ajaran sekarang!!</p></div>";		
		}
		else if($k<$siswa){
			$SalahLogin .= "<div class='alert alert-danger'><p class='small'><strong>Maaf,</strong> Akses Siswa sedang di tutup!!</p></div>";		
		}
		else
		{ }
		include("inc/login.php");
	}
	else
	{
		//==============================================[ TAMPILKAN HALAMAN ]==//
		$page = (isset($_GET['page']))? $_GET['page'] : "";
		if(isset($_GET['page'])){
			if(file_exists("pages/".$page.".php")){
				include 'pages/'.$page.'.php';
			}else {
				include 'pages/temp/'.$page.'.php';
			}
		}else{
			include 'pages/home.php';
		}
	}
}
?>