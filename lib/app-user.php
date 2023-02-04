<?php
/* 12/6/2016 --> 28/01/2017 --> 07/01/2023
Design and Programming By. Abdul Madjid, S.Pd., M.Pd.
SMK Negeri 1 Kadipaten
Pin 520543F3 HP. 0812-3000-0420
https://twitter.com/AbdoelMadjid 
https://www.facebook.com/abdulmadjid.mpd
*/
//eval(base64_decode("
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING | E_DEPRECATED));	
$pengguna="";
$pengguna.=$_SESSION['SMART_LOGIN'];
if($_SESSION['SMART_MASTER']=="Master"){
	$loginQry=mysql_query("SELECT * FROM app_users WHERE userid='".$_SESSION['SMART_LOGIN']."' and hak='".$_SESSION['SMART_MASTER']."'");
	$loginRow=mysql_fetch_array($loginQry);
	$nomor=0;
	$NamaPengguna.=$loginRow['nama_lengkap'];
	$IdUser.=$loginRow['userid'];
	$LevelUser.="Master";
	$IDna.=$loginRow['id_user'];
	$linkna.="<a href='?page=profil-master'>Akademik</a>";
	$linkprofilpengguna="index.php?page=profil-master";
	$link_home="pages/home-master.php";
	$linkphoto=$loginRow['jk'];
	$WaktuLogin.=$loginRow['waktu_login'];
	$WaktuLogout.=$loginRow['waktu_logout'];
	$JmlLogin.=$loginRow['kunjung'];
}
else if($_SESSION['SMART_ADMIN']=="Admin"){
	$loginQryAdmin = mysql_query("SELECT * FROM app_users WHERE userid='".$_SESSION['SMART_LOGIN']."' and hak='".$_SESSION['SMART_ADMIN']."'");
	$loginRowAdmin = mysql_fetch_array($loginQryAdmin);
	$nomorAdmin=0; 
	$NamaPengguna.=$loginRowAdmin['nama_lengkap'];
	$IdUser.=$loginRowAdmin['userid'];
	$LevelUser.="Administrator";
	$IDna.=$loginRowAdmin['id_user'];
	$linkphoto=$loginRowAdmin['jk'];
	$WaktuLogin.=$loginRowAdmin['waktu_login'];
	$WaktuLogout.=$loginRowAdmin['waktu_logout'];
	$JmlLogin.=$loginRowAdmin['kunjung'];
} 
else if($_SESSION['SMART_BPBK']=="BpBK"){
	$loginQryBpBk = mysql_query("SELECT * FROM app_users WHERE userid='".$_SESSION['SMART_LOGIN']."' and hak='".$_SESSION['SMART_BPBK']."'");
	$loginRowBpBk = mysql_fetch_array($loginQryBpBk);
	$nomorBpBk=0; 
	$NamaPengguna.=$loginRowBpBk['nama_lengkap'];
	$IdUser.=$loginRowBpBk['userid'];
	$LevelUser.="BP/BK";
	$IDna.=$loginRowBpBk['id_user'];
	$linkphoto=$loginRowBpBk['jk'];
	$WaktuLogin.=$loginRowBpBk['waktu_login'];
	$WaktuLogout.=$loginRowBpBk['waktu_logout'];
	$JmlLogin.=$loginRowBpBk['kunjung'];
}
else if($_SESSION['SMART_GURU']=="Guru"){
	$loginQryGuru = mysql_query("SELECT * FROM app_user_guru WHERE userid='".$_SESSION['SMART_LOGIN']."' and hak='".$_SESSION['SMART_GURU']."'");
	$loginGuruRow = mysql_fetch_array($loginQryGuru);
	$nomorGuru=0;
	if($loginGuruRow['gelarbelakang']==""){$koma="";}else{$koma=",";}
	if($loginGuruRow['gelardepan']==""){$sp="";}else{$sp=$loginGuruRow['gelardepan']." ";}
	$NamaPengguna.=$sp." ".$loginGuruRow['nama_lengkap'].$koma." ".$loginGuruRow['gelarbelakang'];	
	$IdUser.=$loginGuruRow['userid'];
	$NIP.=$loginGuruRow['nip'];
	$LevelUser.="Guru";
	$IDna.=$loginGuruRow['id_guru'];
	$jenkel.=$loginGuruRow['jk'];
	$linkphoto=$loginGuruRow['photo'];
	$WaktuLogin.=$loginGuruRow['waktu_login'];
	$WaktuLogout.=$loginGuruRow['waktu_logout'];
	$JmlLogin.=$loginGuruRow['kunjung'];
} 
else if($_SESSION['SMART_WALIKELAS']=="Wali Kelas"){
	$loginQryWaliKelas = mysql_query("SELECT * FROM app_user_walikelas WHERE userid='".$_SESSION['SMART_LOGIN']."' and hak='".$_SESSION['SMART_WALIKELAS']."'");
	$loginWaliKelasRow = mysql_fetch_array($loginQryWaliKelas);
	$nomorWaliKelas=0; 
	$IDGuru=$loginWaliKelasRow['id_guru'];
	$QGuru = mysql_query("SELECT * FROM app_user_guru WHERE id_guru='".$IDGuru."'");
	$HGuru = mysql_fetch_array($QGuru);
	if($HGuru['gelarbelakang']==""){$koma="";}else{$koma=",";}
	if($HGuru['gelardepan']==""){$sp="";}else{$sp=$HGuru['gelardepan']." ";}
	$NamaPengguna.=$sp." ".$HGuru['nama_lengkap'].$koma." ".$HGuru['gelarbelakang'];	
	$linkphoto=$HGuru['jk'];
	$IdUser.=$loginWaliKelasRow['userid'];
	$LevelUser.="Wali Kelas";
	$IDna.=$loginWaliKelasRow['id_walikelas'];
	$IDKelsWK.=$loginWaliKelasRow['kode_kelas'];
	$WaktuLogin.=$loginWaliKelasRow['waktu_login'];
	$WaktuLogout.=$loginWaliKelasRow['waktu_logout'];
	$JmlLogin.=$loginWaliKelasRow['kunjung'];
} 
else if($_SESSION['SMART_SISWA']=="Siswa"){
	$loginSiswaSql= mysql_query("SELECT * FROM app_user_siswa WHERE userid='".$_SESSION['SMART_LOGIN']."' and hak='".$_SESSION['SMART_SISWA']."'");
	$nomorSiswa=0; 
	$loginSiswaRow=mysql_fetch_array($loginSiswaSql);
	$IdUser.=$loginSiswaRow['userid'];
	$LevelUser.="Peserta Didik";
	$IDna.=$loginSiswaRow['nis'];
	NgambilData("select nm_siswa from siswa_biodata where nis='{$IDna}'");
	$NamaPengguna.=$nm_siswa;
	$WaktuLogin.=$loginSiswaRow['waktu_login'];
	$WaktuLogout.=$loginSiswaRow['waktu_logout'];
	$JmlLogin.=$loginSiswaRow['kunjung'];
}

// data terpilih 
	$QPilihDataApp= mysql_query("select * from app_pilih_data where id_pil='$IDna'");
	$JDataAppPilih=JmlDt("select * from app_pilih_data where id_pil='$IDna'");
	$HPilihDataApp=mysql_fetch_array($QPilihDataApp);

	$PilTA.=$HPilihDataApp['tahunajaran'];
	$PilSmstr.=$HPilihDataApp['semester'];
	$PilPK.=$HPilihDataApp['id_pk'];
	$PilTK.=$HPilihDataApp['tingkat'];
	$PilKls.=$HPilihDataApp['id_kelas'];
	$PilKdKls.=$HPilihDataApp['kd_kelas'];
	$PilNIS.=$HPilihDataApp['id_nis'];
	$PilGr.=$HPilihDataApp['id_guru'];
	$PilWK.=$HPilihDataApp['id_wk'];
	$PilTingC.=$HPilihDataApp['tinggi'];

//pilih cetak rapor
	$QAdminPilCetak=mysql_query("select * from app_pilih_cetak_rapor where id_pil='$IDna'");
	$HAdminPilCetak=mysql_fetch_array($QAdminPilCetak);

	$PilTMasuk=$HAdminPilCetak['thnmasuk'];
	$PilPKCetak=$HAdminPilCetak['kode_pk'];

	$PilPrCetak=$HAdminPilCetak['pararel'];

	$PilTA1=$HAdminPilCetak['thn_tk1'];
	$PilKelas1=$HAdminPilCetak['kelas_tk1'];
	$PilTA2=$HAdminPilCetak['thn_tk2'];
	$PilKelas2=$HAdminPilCetak['kelas_tk2'];
	$PilTA3=$HAdminPilCetak['thn_tk3'];
	$PilKelas3=$HAdminPilCetak['kelas_tk3'];

	$PilJarakDes=$HAdminPilCetak['spasi'];

	$QKlsPil1=mysql_query("select * from ak_kelas where id_kls='".$PilKelas1."'");
	$HKlsPil1=mysql_fetch_array($QKlsPil1);
	$NamaPilKelas1=$HKlsPil1['nama_kelas'];
	$QKlsPil2=mysql_query("select * from ak_kelas where id_kls='".$PilKelas2."'");
	$HKlsPil2=mysql_fetch_array($QKlsPil2);
	$NamaPilKelas2=$HKlsPil2['nama_kelas'];
	$QKlsPil3=mysql_query("select * from ak_kelas where id_kls='".$PilKelas3."'");
	$HKlsPil3=mysql_fetch_array($QKlsPil3);
	$NamaPilKelas3=$HKlsPil3['nama_kelas'];


//pilih proses remedial

	$QAdminPilCR=mysql_query("select * from app_pilih_cekremedial where id_pil='$IDna'");
	$HAdminPilCR=mysql_fetch_array($QAdminPilCR);

	$PilTMasukCR=$HAdminPilCR['thnmasuk'];
	$PilPKCetakCR=$HAdminPilCR['kode_pk'];

	$PilParCR=$HAdminPilCR['pararel'];

	$PilTACR1=$HAdminPilCR['thn_tk1'];
	$PilKelasCR1=$HAdminPilCR['kelas_tk1'];
	$PilNKLSCR1=$HAdminPilCR['nm_kls_tk1'];
	$PilKKLSCR1=$HAdminPilCR['kd_kls_tk1'];

	$PilTACR2=$HAdminPilCR['thn_tk2'];
	$PilKelasCR2=$HAdminPilCR['kelas_tk2'];
	$PilNKLSCR2=$HAdminPilCR['nm_kls_tk2'];
	$PilKKLSCR2=$HAdminPilCR['kd_kls_tk2'];

	$PilTACR3=$HAdminPilCR['thn_tk3'];
	$PilKelasCR3=$HAdminPilCR['kelas_tk3'];
	$PilNKLSCR3=$HAdminPilCR['nm_kls_tk3'];
	$PilKKLSCR3=$HAdminPilCR['kd_kls_tk3'];

	$PilNISCR=$HAdminPilCR['nis'];

	$QKlsPilCR1=mysql_query("select * from ak_kelas where id_kls='".$PilKelasCR1."'");
	$HKlsPilCR1=mysql_fetch_array($QKlsPilCR1);
	$NamaPilKelasCR1=$HKlsPilCR1['nama_kelas'];
	$QKlsPilCR2=mysql_query("select * from ak_kelas where id_kls='".$PilKelasCR2."'");
	$HKlsPilCR2=mysql_fetch_array($QKlsPilCR2);
	$NamaPilKelasCR2=$HKlsPilCR2['nama_kelas'];
	$QKlsPilCR3=mysql_query("select * from ak_kelas where id_kls='".$PilKelasCR3."'");
	$HKlsPilCR3=mysql_fetch_array($QKlsPilCR3);
	$NamaPilKelasCR3=$HKlsPilCR3['nama_kelas'];

//pilih proses transkrip nilai

	$QAdminPilTR=mysql_query("select * from app_pilih_cetak_trans where id_pil='$IDna'");
	$HAdminPilTR=mysql_fetch_array($QAdminPilTR);

	$PilLulusTR=$HAdminPilTR['thnlulus'];
	$ThnMasukTR=($PilLulusTR-3);
	$PilPKCetakTR=$HAdminPilTR['kode_pk'];

	$PilParTR=$HAdminPilTR['pararel'];

	$PilTATR1=$HAdminPilTR['thn_tk1'];
	$PilKelasTR1=$HAdminPilTR['kelas_tk1'];
	$PilNKLSTR1=$HAdminPilTR['nm_kls_tk1'];
	$PilKKLSTR1=$HAdminPilTR['kd_kls_tk1'];

	$PilTATR2=$HAdminPilTR['thn_tk2'];
	$PilKelasTR2=$HAdminPilTR['kelas_tk2'];
	$PilNKLSTR2=$HAdminPilTR['nm_kls_tk2'];
	$PilKKLSTR2=$HAdminPilTR['kd_kls_tk2'];

	$PilTATR3=$HAdminPilTR['thn_tk3'];
	$PilKelasTR3=$HAdminPilTR['kelas_tk3'];
	$PilNKLSTR3=$HAdminPilTR['nm_kls_tk3'];
	$PilKKLSTR3=$HAdminPilTR['kd_kls_tk3'];

	$PilNISTR=$HAdminPilTR['nis'];

	$QKlsPilTR1=mysql_query("select * from ak_kelas where id_kls='".$PilKelasTR1."'");
	$HKlsPilTR1=mysql_fetch_array($QKlsPilTR1);
	$NamaPilKelasTR1=$HKlsPilTR1['nama_kelas'];
	$QKlsPilTR2=mysql_query("select * from ak_kelas where id_kls='".$PilKelasTR2."'");
	$HKlsPilTR2=mysql_fetch_array($QKlsPilTR2);
	$NamaPilKelasTR2=$HKlsPilTR2['nama_kelas'];
	$QKlsPilTR3=mysql_query("select * from ak_kelas where id_kls='".$PilKelasTR3."'");
	$HKlsPilTR3=mysql_fetch_array($QKlsPilTR3);
	$NamaPilKelasTR3=$HKlsPilTR3['nama_kelas'];


//"))
?>