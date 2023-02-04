<?php
require_once("inc/init.php");
require_once("inc/config.ui.php");
$page_title = "Ajuan Remedial";
$page_css[] = "your_style.css";
include("inc/header.php");
$page_nav["kurikulum"]["sub"]["datakbm"]["sub"]["remedial"]["active"] = true;
include("inc/nav.php");
echo "<div id='main' role='main'>";
$breadcrumbs["Kurikulum / Proses KBM"] = "";
include("inc/ribbon.php");	
$sub=(isset($_GET['sub']))? $_GET['sub'] : "";
switch ($sub)
{
	case "tampil":default:	

		$Memilih.=JudulKolom("Pilih Data","search");
		$Memilih.="
		<form action='?page=$page' method='post' name='frmPilih' class='smart-form' role='form'>
			<div class='row'>
				<label class='label col col-3'>TM, PK, Pararel</label>
				";
				$Memilih.=FormCF("smart2","TM","txtThnMasuk","select * from siswa_biodata where tahunmasuk group by tahunmasuk","tahunmasuk",$PilTMasukCR,"tahunmasuk","3","onchange=\"document.location.href='?page=$page&sub=updatethnmasuk&taunmasuk='+document.frmPilih.txtThnMasuk.value\"");
				if(!empty($PilTMasukCR)){
					$Memilih.=FormCF("smart2","PK","txtPK","SELECT ak_perkelas.kode_pk,siswa_biodata.kode_paket,ak_paketkeahlian.nama_paket FROM ak_perkelas INNER JOIN siswa_biodata ON ak_perkelas.nis=siswa_biodata.nis INNER JOIN ak_paketkeahlian ON ak_perkelas.kode_pk=ak_paketkeahlian.kode_pk where siswa_biodata.tahunmasuk='$PilTMasukCR' GROUP BY ak_perkelas.kode_pk","kode_pk",$PilPKCetakCR,"nama_paket","4","onchange=\"document.location.href='?page=$page&sub=updatepk&paket='+document.frmPilih.txtPK.value\"");					
				}
				if(!empty($PilPKCetakCR)){
					$Memilih.=FormCF("smart2","Pararel","txtPararel","select * from ak_kelas where tahunmasuk='$PilTMasukCR' and kode_pk='$PilPKCetakCR' GROUP BY pararel","pararel",$PilParCR,"pararel","2","onchange=\"document.location.href='?page=$page&sub=updatepararel&pral='+document.frmPilih.txtPararel.value\"");					
				}

				$Memilih.="
			</div>
			<div class='row'>
				<label class='label col col-3'>Tingkat X</label>";
				$Memilih.=FormIF("smart2","TA 10","txtTAtkX",$PilTACR1,"3","disabled='disabled'");
				$Memilih.=FormIF("smart2","Kelas 10","txtKlsX","$PilKelasCR1 - $NamaPilKelasCR1","6","disabled='disabled'");
				$Memilih.="
			</div>
			<div class='row'>
				<label class='label col col-3'>Tingkat XI</label>";
				$Memilih.=FormIF("smart2","TA 11","txtTAtkXI",$PilTACR2,"3","disabled='disabled'");
				$Memilih.=FormIF("smart2","Kelas 11","txtKlsXI","$PilKelasCR2 - $NamaPilKelasCR2","6","disabled='disabled'");
				$Memilih.="
			</div>
			<div class='row'>
				<label class='label col col-3'>Tingkat XII</label>";
				$Memilih.=FormIF("smart2","TA 12","txtTAtkXII",$PilTACR3,"3","disabled='disabled'");
				$Memilih.=FormIF("smart2","Kelas 12","txtKlsXII","$PilKelasCR3 - $NamaPilKelasCR3","6","disabled='disabled'");
				$Memilih.="				
			</div>
			<div class='row'>";
			if(!empty($PilParCR)){
					$Memilih.="<label class='label col col-3'>Nama Siswa</label>";
					$Memilih.=FormCF("smart2","Siswa","txtNIS","SELECT ak_perkelas.*,siswa_biodata.nm_siswa from ak_perkelas INNER JOIN siswa_biodata ON ak_perkelas.nis=siswa_biodata.nis WHERE ak_perkelas.tahunajaran='$PilTACR1' AND ak_perkelas.nm_kelas='$PilNKLSCR1'","nis",$PilNISCR,"nm_siswa","6","onchange=\"document.location.href='?page=$page&sub=updatenis&nis='+document.frmPilih.txtNIS.value\"");
				}
				$Memilih.="
			</div>			
		</form>";

		if($PilTMasukCR=="") {
			$Memilih.=nt("peringatan","Silakan Pilih Tahun Masuk");
		}		
		else if($PilPKCetakCR=="") {
			$Memilih.=nt("peringatan","Silakan Pilih Paket Keahlian");
		}
		else if($PilParCR=="") {
			$Memilih.=nt("peringatan","Silakan Pilih Kelas Pararel");
		}
		else {		
			if($PilTMasukCR=="2022"){
				$Memilih.="<a href='?page=kurikulum-remedial-km' class='btn btn-default btn-sm pull-right'>Cek Remedial</a>";
			}else {
				$Memilih.="<a href='?page=kurikulum-remedial-k13' class='btn btn-default btn-sm pull-right'>Cek Remedial</a>";
			}
		}

		
		$Query=mysql_query("select ak_kelas.*,app_user_guru.nama_lengkap from ak_kelas inner JOIN app_user_guru ON ak_kelas.id_guru=app_user_guru.id_guru where tahunmasuk='$PilTMasukCR' and kode_pk='$PilPKCetakCR' and pararel='$PilParCR'");
		
		while($HasilWK=mysql_fetch_array($Query)){
			$TmpWk.="
				<tr>
					<td class='text-center'>{$HasilWK['tingkat']}</td>
					<td>{$HasilWK['nama_kelas']}</td>
					<td>{$HasilWK['kode_kelas']}</td>
					<td>{$HasilWK['nama_lengkap']}</td>
				</tr>";
		}
	
		$WaliKelas.=JudulKolom("Wali Kelas","graduation-cap");
		$WaliKelas.="
		<div class='well no-padding'>
			<table class='table'>
				<tr bgcolor='#f5f5f5'>
					<td class='text-center'>Tingkat</td>
					<td class='text-center'>Kelas</td>
					<td class='text-center'>Kode Kelas</td>
					<td class='text-center'>Wali Kelas</td>
				</tr>
				$TmpWk
			</table>
		</div>";

		$Show.=DuaKolomSama($Memilih,$WaliKelas);

		$QDPil=mysql_query("select * from ak_kelas where tahunmasuk='$PilTMasukCR' and kode_pk='$PilPKCetakCR' and pararel='$PilParCR'");
		while($HDPil=mysql_fetch_array($QDPil)){
			$TDPilih.="
				<tr>
					<td class='text-center'>{$HDPil['tingkat']}</td>
					<td class='text-center'>{$HDPil['tahunajaran']}</td>
					<td class='text-center'>{$HDPil['id_kls']}</td>
					<td class='text-center'>{$HDPil['nama_kelas']}</td>
				</tr>";
		}
		$Pilihan="
		<div class='well no-padding'>
			<table class='table'>
				<tr bgcolor='#f5f5f5'>
					<td class='text-center'>Tingkat</td>
					<td class='text-center'>Tahun Ajaran</td>
					<td class='text-center'>Id Kelas</td>
					<td class='text-center'>Kelas</td>
				</tr>
				$TDPilih
			</table>
		</div>";

		$QKelasTTM=mysql_query("select ak_kelas.kode_kelas, wk_kelas_ttm.semester, wk_kelas_ttm.alamat, wk_kelas_ttm.ttm from ak_kelas inner join wk_kelas_ttm on ak_kelas.kode_kelas=wk_kelas_ttm.kd_kls where tahunmasuk='$PilTMasukCR' and kode_pk='$PilPKCetakCR' and pararel='$PilParCR'");
		
		while($HasilTTM=mysql_fetch_array($QKelasTTM)){
			$TmpTTM.="
				<tr>
					<td class='text-center'>{$HasilTTM['semester']}</td>
					<td>{$HasilTTM['kode_kelas']}</td>
					<td>{$HasilTTM['alamat']}, ".TglLengkap($HasilTTM['ttm'])."</td>
				</tr>";
		}
		$TTM="
		<div class='well no-padding'>
			<table class='table'>
				<tr bgcolor='#f5f5f5'>
					<td class='text-center'>Semester</td>
					<td class='text-center'>Kode Kelas</td>
					<td class='text-center'>TTM</td>
				</tr>
				$TmpTTM
			</table>
		</div>";
		
		
		$Show.=DuaKolomSama(JudulKolom("Data Terpilih","list").$Pilihan,JudulKolom("Titimangsa Rapor","calendar").$TTM);

		$tandamodal="#CukupJelas";		
		echo $CukupJelas;
		echo MyWidget('fa-retweet',"Pengajuan Remedial","",$Show);
	break;
	
	case "updatethnmasuk":
		$taunmasuk=isset($_GET['taunmasuk'])?$_GET['taunmasuk']:"";
		$TAKelasHiji=$taunmasuk."-".($taunmasuk+1);
		$TAKelasDua=($taunmasuk+1)."-".($taunmasuk+2);
		$TAKelasTilu=($taunmasuk+2)."-".($taunmasuk+3);
		$JmlData=JmlDt("select * from app_pilih_cekremedial where id_pil='$IDna'");

		if($JmlData==0){
			mysql_query("insert into app_pilih_cekremedial values ('$IDna','$taunmasuk','','$TAKelasHiji','','','','$TAKelasDua','','','','$TAKelasTilu','','','','','')");
		}else {
			mysql_query("
			update app_pilih_cekremedial set 
			thnmasuk='$taunmasuk',
			kode_pk='',
			thn_tk1='$TAKelasHiji',
			kelas_tk1='',nm_kls_tk1='',kd_kls_tk1='',
			thn_tk2='$TAKelasDua',
			kelas_tk2='',nm_kls_tk2='',kd_kls_tk2='',
			thn_tk3='$TAKelasTilu',
			kelas_tk3='',nm_kls_tk3='',kd_kls_tk3='',
			pararel=''
			where id_pil='$IDna'");
		}
		echo ns("Milih","parent.location='?page=$page'","tahun masuk $taunmasuk");
	break;

	case "updatepk":
		$paket=isset($_GET['paket'])?$_GET['paket']:"";
		NgambilData("select * from ak_paketkeahlian where kode_pk='$paket'");
		mysql_query("update app_pilih_cekremedial set kode_pk='$paket',kelas_tk1='',nm_kls_tk1='',kd_kls_tk1='',kelas_tk2='',nm_kls_tk2='',kd_kls_tk2='',kelas_tk3='',nm_kls_tk3='',kd_kls_tk3='',pararel='' where id_pil='$IDna'");
		echo ns("Milih","parent.location='?page=$page'","paket keahlian $nama_paket");
	break;

	case "updatepararel":
		$pral=isset($_GET['pral'])?$_GET['pral']:"";

		$QKlsX=mysql_query("select * from ak_kelas where tahunmasuk='$PilTMasukCR' and kode_pk='$PilPKCetakCR' AND pararel='$pral' and tingkat='X'");
		$HKlsX=mysql_fetch_array($QKlsX);

		$IDKelasX=$HKlsX['id_kls'];
		$NmKelasX=$HKlsX['nama_kelas'];
		$KdKelasX=$HKlsX['kode_kelas'];

		$QKlsXI=mysql_query("select * from ak_kelas where tahunmasuk='$PilTMasukCR' and kode_pk='$PilPKCetakCR' AND pararel='$pral' and tingkat='XI'");
		$HKlsXI=mysql_fetch_array($QKlsXI);

		$IDKelasXI=$HKlsXI['id_kls'];
		$NmKelasXI=$HKlsXI['nama_kelas'];
		$KdKelasXI=$HKlsXI['kode_kelas'];

		$QKlsXII=mysql_query("select * from ak_kelas where tahunmasuk='$PilTMasukCR' and kode_pk='$PilPKCetakCR' AND pararel='$pral' and tingkat='XII'");
		$HKlsXII=mysql_fetch_array($QKlsXII);

		$IDKelasXII=$HKlsXII['id_kls'];
		$NmKelasXII=$HKlsXII['nama_kelas'];
		$KdKelasXII=$HKlsXII['kode_kelas'];

		mysql_query("update app_pilih_cekremedial set pararel='$pral' where id_pil='$IDna'");
		mysql_query("update app_pilih_cekremedial set kelas_tk1='$IDKelasX',nm_kls_tk1='$NmKelasX',kd_kls_tk1='$KdKelasX' where id_pil='$IDna'");
		mysql_query("update app_pilih_cekremedial set kelas_tk2='$IDKelasXI',nm_kls_tk2='$NmKelasXI',kd_kls_tk2='$KdKelasXI' where id_pil='$IDna'");
		mysql_query("update app_pilih_cekremedial set kelas_tk3='$IDKelasXII',nm_kls_tk3='$NmKelasXII',kd_kls_tk3='$KdKelasXII' where id_pil='$IDna'");

		echo ns("Milih","parent.location='?page=$page'","pararel $pral");
	break;

	case "updatenis":
		$nis=isset($_GET['nis'])?$_GET['nis']:"";
		mysql_query("update app_pilih_cekremedial set nis='$nis' where id_pil='$IDna'");
		echo ns("Milih","parent.location='?page=$page'","siswa dengan $nis");
	break;

	case "updatepilsiswa2":
	$kbm=isset($_GET['kbm'])?$_GET['kbm']:""; 
	$nis=isset($_GET['nis'])?$_GET['nis']:""; 
	$kls=isset($_GET['kls'])?$_GET['kls']:""; 
	$thnajar=isset($_GET['thnajar'])?$_GET['thnajar']:""; 
	$semester=isset($_GET['semester'])?$_GET['semester']:"";
	mysql_query("update app_pilih_cekremedial set nis='$nis' where id_pil='$IDna'");
	echo "<meta http-equiv='refresh' content='0; url=?page=$page&sub=nyetakperbaikan&kbm=$kbm&nis=$nis&thnajar=$thnajar&semester=$semester&kls=$kls'>";
	break;
}
echo '</div>';
include("inc/footer.php");
include("inc/scripts.php");
//"))
?>
