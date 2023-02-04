<?php
$QApp = mysql_query("SELECT * FROM app_ident");  
$DApp = mysql_fetch_array($QApp);

$VersiApp=$DApp['versi'];
$TglUpdateApp=$DApp['tgl_update'];
$ShortNameApp=$DApp['nama_singkat'];
$LongNameApp=$DApp['nama_panjang'];
$LembagaApp=$DApp['nama_lembaga'];
$DeskApp=$DApp['deskripsi_app'];
$LogoApp=$DApp['logo'];
$Gambar1=$DApp['gambar1'];
$Gambar2=$DApp['gambar2'];
$Gambar3=$DApp['gambar3'];

$UnCons=$DApp['underc'];
$TglUnCons=$DApp['tgl_underc'];

$QLmbg = mysql_query("SELECT * FROM app_lembaga");  
$DLmbg = mysql_fetch_array($QLmbg);
$NamaLembaga=$DLmbg['nm_sekolah'];

$QThnA = mysql_query("SELECT * FROM ak_tahunajaran where aktif='Y'");  
$DThnA = mysql_fetch_array($QThnA);

$TahunAjarAktif = $DThnA['tahunajaran'];

$QSmstr = mysql_query("SELECT * FROM ak_semester where aktif='Y'");  
$DSmstr = mysql_fetch_array($QSmstr);
$SemesterAktif = $DSmstr['ganjilgenap'];

$QKS=mysql_query("select * from ak_kepsek where thnajaran='$TahunAjarAktif' and smstr='$SemesterAktif'");
$HKS=mysql_fetch_array($QKS);
$NamaKepsek=$HKS['nama'];
$NIPKepsek=$HKS['nip'];

$QKey=mysql_query("select * from kur_kunci_kbm where tahunajaran='$TahunAjarAktif' and semester='$SemesterAktif'");
$HKey=mysql_fetch_array($QKey);
$NgunciKBM=$HKey['kunci'];
?>