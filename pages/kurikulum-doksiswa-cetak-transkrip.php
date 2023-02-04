<?php
require_once("inc/init.php");
require_once("inc/config.ui.php");
$page_title = "Transkrip Nilai";
$page_css[] = "your_style.css";
include("inc/header.php");
$page_nav["kurikulum"]["sub"]["dokumensiswa"]["sub"]["transkrip"]["active"] = true;
include("inc/nav.php");
echo "<div id='main' role='main'>";
$breadcrumbs["Penilaian "] = "";
include("inc/ribbon.php");	
$sub=(isset($_GET['sub']))? $_GET['sub'] : "";
switch ($sub)
{
	case "tampil":default:

		$Memilih.=JudulKolom("Pilih Data","search");
		$Memilih.="
		<form action='?page=$page' method='post' name='frmPilih' class='smart-form' role='form'>
			<div class='row'>
				<label class='label col col-3'>Tahun Lulus</label>
				";
				$Memilih.=FormCF("smart2","Tahun Lulus","txtThnLulus","select * from siswa_biodata where tahunmasuk group by tahunmasuk","tahunmasuk",$PilLulusTR,"tahunmasuk","3","onchange=\"document.location.href='?page=$page&sub=updatethnlulus&taunlulus='+document.frmPilih.txtThnLulus.value\"");
				if(!empty($PilLulusTR)){
					$Memilih.=FormCF("smart2","PK","txtPK","SELECT ak_perkelas.kode_pk,siswa_biodata.kode_paket,ak_paketkeahlian.nama_paket FROM ak_perkelas INNER JOIN siswa_biodata ON ak_perkelas.nis=siswa_biodata.nis INNER JOIN ak_paketkeahlian ON ak_perkelas.kode_pk=ak_paketkeahlian.kode_pk where siswa_biodata.tahunmasuk='$ThnMasukTR' GROUP BY ak_perkelas.kode_pk","kode_pk",$PilPKCetakTR,"nama_paket","4","onchange=\"document.location.href='?page=$page&sub=updatepk&paket='+document.frmPilih.txtPK.value\"");					
				}
				if(!empty($PilPKCetakTR)){
					$Memilih.=FormCF("smart2","Pararel","txtPararel","select * from ak_kelas where tahunmasuk='$ThnMasukTR' and kode_pk='$PilPKCetakTR' GROUP BY pararel","pararel",$PilParTR,"pararel","2","onchange=\"document.location.href='?page=$page&sub=updatepararel&pral='+document.frmPilih.txtPararel.value\"");					
				}

				$Memilih.="
			</div>
			<div class='row'>
				<label class='label col col-3'>Tingkat X</label>";
				$Memilih.=FormIF("smart2","TA 10","txtTAtkX",$PilTATR1,"3","disabled='disabled'");
				$Memilih.=FormIF("smart2","Kelas 10","txtKlsX","$PilKelasTR1 - $PilNKLSTR1","6","disabled='disabled'");
				$Memilih.="
			</div>
			<div class='row'>
				<label class='label col col-3'>Tingkat XI</label>";
				$Memilih.=FormIF("smart2","TA 11","txtTAtkXI",$PilTATR2,"3","disabled='disabled'");
				$Memilih.=FormIF("smart2","Kelas 11","txtKlsXI","$PilKelasTR2 - $PilNKLSTR2","6","disabled='disabled'");
				$Memilih.="
			</div>
			<div class='row'>
				<label class='label col col-3'>Tingkat XII</label>";
				$Memilih.=FormIF("smart2","TA 12","txtTAtkXII",$PilTATR3,"3","disabled='disabled'");
				$Memilih.=FormIF("smart2","Kelas 12","txtKlsXII","$PilKelasTR3 - $PilNKLSTR3","6","disabled='disabled'");
				$Memilih.="				
			</div>
			<div class='row'>";
			if(!empty($PilPKCetakTR)){
					$Memilih.="<label class='label col col-3'>Nama Siswa</label>";
					$Memilih.=FormCF("smart2","Siswa","txtNIS","SELECT ak_perkelas.*,siswa_biodata.nm_siswa from ak_perkelas INNER JOIN siswa_biodata ON ak_perkelas.nis=siswa_biodata.nis WHERE ak_perkelas.tahunajaran='$PilTATR1' AND ak_perkelas.nm_kelas='$PilNKLSTR1'","nis",$PilNISTR,"nm_siswa","6","onchange=\"document.location.href='?page=$page&sub=updatenis&nis='+document.frmPilih.txtNIS.value\"");
				}
				$Memilih.="
			</div>
		</form>";


		if($PilLulusTR=="") {
			$Memilih.=nt("peringatan","Silakan Pilih Tahun Lulus");
		}		
		else if($PilPKCetakTR=="") {
			$Memilih.=nt("peringatan","Silakan Pilih Paket Keahlian");
		}
		else if($PilKelasTR1=="") {
			$Memilih.=nt("peringatan","Silakan Pilih Kelas Pararel");
		}
		else {		
			if($PilLulusTR=="2022"){
				$Memilih.="<a href='?page=kurikulum-doksiswa-cetak-transkrip-2022' class='btn btn-default btn-sm pull-right'>Cetak Transkrip</a>";
			}else if($PilLulusTR=="2021"){
				$Memilih.="<a href='?page=kurikulum-doksiswa-cetak-transkrip-2021' class='btn btn-default btn-sm pull-right'>Cetak Transkrip</a>";
			}else if($PilLulusTR=="2020"){
				$Memilih.="<a href='?page=kurikulum-doksiswa-cetak-transkrip-2020' class='btn btn-default btn-sm pull-right'>Cetak Transkrip</a>";
			}else {
				$Memilih.="<a href='?page=kurikulum-doksiswa-cetak-transkrip-old' class='btn btn-default btn-sm pull-right'>Cetak Transkrip</a>";
			} 
		}

		
		$Query=mysql_query("select ak_kelas.*,app_user_guru.nama_lengkap from ak_kelas inner JOIN app_user_guru ON ak_kelas.id_guru=app_user_guru.id_guru where tahunmasuk='$ThnMasukTR' and kode_pk='$PilPKCetakTR' and pararel='$PilParTR'");
		
		while($HasilWK=mysql_fetch_array($Query)){
			$TmpWk.="
				<tr>
					<td>{$HasilWK['tingkat']}</td>
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

		$QKelasTTM=mysql_query("select ak_kelas.kode_kelas, wk_kelas_ttm.semester, wk_kelas_ttm.alamat, wk_kelas_ttm.ttm from ak_kelas inner join wk_kelas_ttm on ak_kelas.kode_kelas=wk_kelas_ttm.kd_kls where tahunmasuk='$ThnMasukTR' and kode_pk='$PilPKCetakTR' and pararel='$PilParTR'");
		
		while($HasilTTM=mysql_fetch_array($QKelasTTM)){
			$TmpTTM.="
				<tr>
					<td>{$HasilTTM['semester']}</td>
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
		echo MyWidget('fa-print',"Cetak Transkip Nilai","",$Show);
	break;
	
	case "updatethnlulus":
		$taunlulus=isset($_GET['taunlulus'])?$_GET['taunlulus']:"";
		$TAKelasHiji=($taunlulus-3)."-".($taunlulus-2);
		$TAKelasDua=($taunlulus-2)."-".($taunlulus-1);
		$TAKelasTilu=($taunlulus-1)."-".($taunlulus);

		$JmlData=JmlDt("select * from app_pilih_cetak_trans where id_pil='$IDna'");

		if($JmlData==0){
			mysql_query("insert into app_pilih_cetak_trans values ('$IDna','$taunlulus','','$TAKelasHiji','','','','$TAKelasDua','','','','$TAKelasTilu','','','','','')");
		}else {
			mysql_query("
			update app_pilih_cetak_trans set 
			thnlulus='$taunlulus',
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
		echo ns("Milih","parent.location='?page=$page'","tahun lulus $taunlulus");
	break;

	case "updatepk":
		$paket=isset($_GET['paket'])?$_GET['paket']:"";
		NgambilData("select * from ak_paketkeahlian where kode_pk='$paket'");
		mysql_query("update app_pilih_cetak_trans set kode_pk='$paket',kelas_tk1='',nm_kls_tk1='',kd_kls_tk1='',kelas_tk2='',nm_kls_tk2='',kd_kls_tk2='',kelas_tk3='',nm_kls_tk3='',kd_kls_tk3='',pararel='' where id_pil='$IDna'");
		echo ns("Milih","parent.location='?page=$page'","paket keahlian $nama_paket");
	break;

	case "updatepararel":
		$pral=isset($_GET['pral'])?$_GET['pral']:"";

		$QKlsX=mysql_query("select * from ak_kelas where tahunmasuk='$ThnMasukTR' and kode_pk='$PilPKCetakTR' AND pararel='$pral' and tingkat='X'");
		$HKlsX=mysql_fetch_array($QKlsX);

		$IDKelasX=$HKlsX['id_kls'];
		$NmKelasX=$HKlsX['nama_kelas'];
		$KdKelasX=$HKlsX['kode_kelas'];

		$QKlsXI=mysql_query("select * from ak_kelas where tahunmasuk='$ThnMasukTR' and kode_pk='$PilPKCetakTR' AND pararel='$pral' and tingkat='XI'");
		$HKlsXI=mysql_fetch_array($QKlsXI);

		$IDKelasXI=$HKlsXI['id_kls'];
		$NmKelasXI=$HKlsXI['nama_kelas'];
		$KdKelasXI=$HKlsXI['kode_kelas'];

		$QKlsXII=mysql_query("select * from ak_kelas where tahunmasuk='$ThnMasukTR' and kode_pk='$PilPKCetakTR' AND pararel='$pral' and tingkat='XII'");
		$HKlsXII=mysql_fetch_array($QKlsXII);

		$IDKelasXII=$HKlsXII['id_kls'];
		$NmKelasXII=$HKlsXII['nama_kelas'];
		$KdKelasXII=$HKlsXII['kode_kelas'];

		mysql_query("update app_pilih_cetak_trans set pararel='$pral' where id_pil='$IDna'");
		mysql_query("update app_pilih_cetak_trans set kelas_tk1='$IDKelasX',nm_kls_tk1='$NmKelasX',kd_kls_tk1='$KdKelasX' where id_pil='$IDna'");
		mysql_query("update app_pilih_cetak_trans set kelas_tk2='$IDKelasXI',nm_kls_tk2='$NmKelasXI',kd_kls_tk2='$KdKelasXI' where id_pil='$IDna'");
		mysql_query("update app_pilih_cetak_trans set kelas_tk3='$IDKelasXII',nm_kls_tk3='$NmKelasXII',kd_kls_tk3='$KdKelasXII' where id_pil='$IDna'");

		echo ns("Milih","parent.location='?page=$page'","pararel $pral");
	break;

	case "updatenis":
		$nis=isset($_GET['nis'])?$_GET['nis']:"";
		mysql_query("update app_pilih_cetak_trans set nis='$nis' where id_pil='$IDna'");
		echo ns("Milih","parent.location='?page=$page'","siswa dengan $nis");
	break;

	case "updatepilsiswa2":
	$kbm=isset($_GET['kbm'])?$_GET['kbm']:""; 
	$nis=isset($_GET['nis'])?$_GET['nis']:""; 
	$kls=isset($_GET['kls'])?$_GET['kls']:""; 
	$thnajar=isset($_GET['thnajar'])?$_GET['thnajar']:""; 
	$semester=isset($_GET['semester'])?$_GET['semester']:"";
	mysql_query("update app_pilih_cetak_trans set nis='$nis' where id_pil='$IDna'");
	echo "<meta http-equiv='refresh' content='0; url=?page=$page&sub=nyetakperbaikan&kbm=$kbm&nis=$nis&thnajar=$thnajar&semester=$semester&kls=$kls'>";
	break;	
}
echo '</div>';
include("inc/footer.php");
include("inc/scripts.php");
//"))
?>