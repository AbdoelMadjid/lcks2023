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
	case "cekremedial":default:
		$Show.=nt("informasi","Masih perlu scripting untuk semester-semester berikutnya");
		$Show.="
		<form action='?page=$page' method='post' name='frmPilih' class='form-inline' role='form'>
			<div class='row pull-right'>
				<div class='col-sm-12 col-md-12'>
					<div class='form-group'>Pililh Siswa &nbsp;&nbsp;</div>".
						FormCF("inline","Siswa","txtNIS","select siswa_biodata.nis,siswa_biodata.nm_siswa,ak_kelas.nama_kelas from ak_kelas,siswa_biodata,ak_perkelas where ak_kelas.nama_kelas=ak_perkelas.nm_kelas and ak_kelas.tahunajaran=ak_perkelas.tahunajaran and ak_perkelas.nis=siswa_biodata.nis and ak_kelas.nama_kelas=ak_perkelas.nm_kelas and ak_kelas.kode_kelas='$PilKKLSCR1' order by siswa_biodata.nis","nis",$PilNISCR,"nm_siswa","","onchange=\"document.location.href='?page=$page&sub=updatenis2&nis='+document.frmPilih.txtNIS.value\"")."						
				</div>
			</div>
		</form><br><br><hr>";

// SEMESTER 1
		$QKls1=mysql_query("select * from ak_kelas where id_kls='$PilKelasCR1'");
		$HKls1=mysql_fetch_array($QKls1);
		$TKKls1=$HKls1['tingkat'];


		$Q1="
		SELECT 
		ak_kelas.kode_kelas,
		ak_perkelas.nis,
		siswa_biodata.nm_siswa, 
		ak_perkelas.nm_kelas,
		n_p_kikd.kd_ngajar,
		ak_kelas.tingkat,
		gmp_ngajar.semester,
		gmp_ngajar.kkmpeng,
		gmp_ngajar.kkmket,
		gmp_ngajar.kd_mapel,
		ak_matapelajaran.nama_mapel,
		app_user_guru.nama_lengkap
		FROM ak_kelas 
		INNER JOIN ak_perkelas ON ak_perkelas.nm_kelas=ak_kelas.nama_kelas
		INNER JOIN siswa_biodata ON ak_perkelas.nis=siswa_biodata.nis
		INNER JOIN n_p_kikd ON ak_perkelas.nis=n_p_kikd.nis
		INNER JOIN gmp_ngajar ON n_p_kikd.kd_ngajar=gmp_ngajar.id_ngajar
		INNER JOIN ak_matapelajaran ON gmp_ngajar.kd_mapel=ak_matapelajaran.kode_mapel
		INNER JOIN app_user_guru ON gmp_ngajar.kd_guru=app_user_guru.id_guru
		WHERE ak_perkelas.tahunajaran='$PilTACR1' 
		and ak_perkelas.tk='$TKKls1' 
		AND ak_kelas.kode_kelas='$PilKKLSCR1' 
		AND ak_perkelas.nis='$PilNISCR'
		AND gmp_ngajar.thnajaran='$PilTACR1' 
		AND gmp_ngajar.semester='1'";
		$MassaKBM1="Tahun Ajaran $PilTACR1 Semester 1";
		$TAj1=$PilTACR1;
		$Smstr1='1';
		$Klsna1=$PilNKLSCR1;

		$no1=1;
		$Query1=mysql_query("$Q1 ORDER BY gmp_ngajar.kd_mapel");
		while($Hasil1=mysql_fetch_array($Query1)){
			$nmsiswa1=$Hasil1['nm_siswa'];

			//tampilkan nilai KETERAMPILAN ==========================================

			$JmlNKDP1=JmlDt("select * from gmp_km_tp where kode_ngajar='{$Hasil1['kd_ngajar']}'");			
			//$JmlNKDK1=JmlDt("select * from gmp_kikd where kode_ranah='KDK' and kode_ngajar='{$Hasil1['kd_ngajar']}'");


			$QKIKDP1=mysql_query("SELECT * FROM n_p_kikd where kd_ngajar='{$Hasil1['kd_ngajar']}' AND nis='$PilNISCR'");
			$HNKIKDP1=mysql_fetch_array($QKIKDP1);

			//$QKIKDK1=mysql_query("SELECT * FROM n_k_kikd where kd_ngajar='{$Hasil1['kd_ngajar']}' AND nis='$PilNISCR'");
			//$HNKIKDK1=mysql_fetch_array($QKIKDK1);

			$QKIKDUTSUAS1=mysql_query("SELECT * FROM n_utsuas WHERE kd_ngajar='{$Hasil1['kd_ngajar']}' AND nis='$PilNISCR'");
			$HKIKDUTSUAS1=mysql_fetch_array($QKIKDUTSUAS1);
			
			$NAP1=round(($HNKIKDP1['kikd_p']+$HKIKDUTSUAS1['uts']+$HKIKDUTSUAS1['uas'])/3,0);

			//$NA1=round(((round(($HNKIKDP1['kikd_p']+$HKIKDUTSUAS1['uts']+$HKIKDUTSUAS1['uas'])/3,0)+$HNKIKDK1['kikd_k'])/2),0);

			if($NAP1<$Hasil1['kkmpeng']){$bgp1='#ff0000';$fcolp1='#ffffff';}else{$bgp1='';$fcolp1='';}
			//if($HNKIKDK1['kikd_k']<$Hasil1['kkmpeng']){$bgk1='#ff0000';$fcolk1='#ffffff';}else{$bgk1='';$fcolk1='';}
			
			if($NAP1<$Hasil1['kkmpeng']){
				$tmbcetak1="<a href='?page=$page&sub=nyetakperbaikan&kbm={$Hasil1['kd_ngajar']}&nis={$Hasil1['nis']}&thnajar=$TAj1&semester=$Smstr1&kls=$Klsna1' class='btn btn-warning btn-block'><i class='fa fa-print'></i> Cetak </a>";
				$tmbp1="
				<div class='dropdown'>
					<a id='dLabel' role='button' data-toggle='dropdown' class='btn btn-warning btn-block' data-target='#' href='javascript:void(0);'> Perbaikan <span class='caret'></span> </a>
					<ul class='dropdown-menu multi-level' role='menu'>
						<li><a href='javascript:void(0);'>{$Hasil1['nama_mapel']}</a></li>
						<li class='divider'></li>
						<li><a href='?page=$page&sub=perbaikan&tnil=TP&kbm={$Hasil1['kd_ngajar']}&nis=$PilNISCR'><i class='fa fa-edit'></i> TP</a></li>
						<li><a href='?page=$page&sub=perbaikan&tnil=utsuas&kbm={$Hasil1['kd_ngajar']}&nis=$PilNISCR'><i class='fa fa-edit'></i> UTS UAS</a></li>
					</ul>
				</div>";
			}
			else{
				$tmbcetak1="<a href='?page=$page&sub=nyetakperbaikan&kbm={$Hasil1['kd_ngajar']}&nis={$Hasil1['nis']}&thnajar=$TAj1&semester=$Smstr1&kls=$Klsna1' class='btn btn-default btn-block'><i class='fa fa-print'></i> Cetak </a>";
				$tmbp1="
				<div class='dropdown'>
					<a id='dLabel' role='button' data-toggle='dropdown' class='btn btn-default btn-block' data-target='#' href='javascript:void(0);'> Perbaikan <span class='caret'></span> </a>
					<ul class='dropdown-menu multi-level' role='menu'>
						<li><a href='javascript:void(0);'>{$Hasil1['nama_mapel']}</a></li>
						<li class='divider'></li>
						<li><a href='?page=$page&sub=perbaikan&tnil=TP&kbm={$Hasil1['kd_ngajar']}&nis=$PilNISCR'><i class='fa fa-edit'></i> TP</a></li>
						<li><a href='?page=$page&sub=perbaikan&tnil=utsuas&kbm={$Hasil1['kd_ngajar']}&nis=$PilNISCR'><i class='fa fa-edit'></i> UTS UAS</a></li>
					</ul>
				</div>";
				}
			$TampilData1.="
			<tr>
				<td>$no1.</td>
				<td>{$Hasil1['id_guru']} {$Hasil1['nama_lengkap']}<br><span class='text-danger'>{$Hasil1['nama_mapel']}</span></td>
				<td>{$Hasil1['kkmpeng']}</td>
				<td>$JmlNKDP1</td>
				<td>$tmbp1</td>
				<td bgcolor='$bgp1'><font size='' color='$fcolp1'>$NAP1</font></td>
				<td>$tmbcetak1</td>
			</tr>";
			$no1++;
		}
	
		$jmldata1=mysql_num_rows($Query1);
		if($jmldata1>0){
			$Show.="<p class='text-danger' style='margin-top:-10px;'>$MassaKBM1</p>";
			$Show.="
			<div class='well no-padding'>
				<table id='dt_basic' class='table table-striped table-bordered table-hover table-condensed' width='100%'>
					<thead>
						<tr>
							<th class='text-center' data-class='expand'>No.</th>
							<th class='text-center'>Nama Guru / Mapel</th>
							<th class='text-center' data-hide='phone'>KKM</th>
							<th class='text-center' data-hide='phone'>TP</th>
							<th class='text-center' data-hide='phone'>Perbaikan</th>
							<th class='text-center' data-hide='phone'>NA</th>
							<th class='text-center' data-hide='phone' width='25'>Cetak</th>
						</tr>
					</thead>
					<tbody>$TampilData1</tbody>
				</table>
			</div>";
		}
		else{
			$Show.="<p class='text-danger' style='margin-top:-10px;'>$MassaKBM1</p>";
			$Show.='			
			<div class="well"><p class="text-center"><img src="img/firda.png" width="200" height="220" border="0" alt=""></p><h1 class="text-center"><small class="text-danger slideInRight fast animated"><strong>Nilai <br>'.$MassaKBM1.' <br>belum tersedia!</strong></small></h1></div>';
		}

		//echo IsiPanel($Show);
		echo MyWidget('fa-vcard-o',"Daftar Nilai <span class='txt-primary'><em><b>".$nmsiswa1."</em></b></span>",array(ButtonKembali("?page=kurikulum-remedial")),$Show);
	break;


//	==> NYETAK LAPORAN <==
	case "nyetakperbaikan":
		$kbm=isset($_GET['kbm'])?$_GET['kbm']:""; 
		$nis=isset($_GET['nis'])?$_GET['nis']:""; 
		$kls=isset($_GET['kls'])?$_GET['kls']:""; 
		$thnajar=isset($_GET['thnajar'])?$_GET['thnajar']:""; 
		$semester=isset($_GET['semester'])?$_GET['semester']:""; 

		$QProfil=mysql_query("select * from app_lembaga");
		$HProfil=mysql_fetch_array($QProfil);

		$QPTK=mysql_query("SELECT 
			gmp_ngajar.id_ngajar,
			ak_matapelajaran.nama_mapel,
			app_user_guru.nama_lengkap,
			app_user_guru.gelardepan,
			app_user_guru.gelarbelakang,
			app_user_guru.nip 
			from gmp_ngajar 
			INNER JOIN app_user_guru ON gmp_ngajar.kd_guru=app_user_guru.id_guru
			INNER JOIN ak_matapelajaran ON gmp_ngajar.kd_mapel=ak_matapelajaran.kode_mapel 
			WHERE id_ngajar='$kbm'");
		$HPTK=mysql_fetch_array($QPTK);
		$Mapel=$HPTK['nama_mapel'];

		if($HPTK['gelarbelakang']==""){$koma="";}else{$koma=",";}
		$GuruNgajarNIP="NIP. ".$HPTK['nip'];
		$GuruNgajar=$HPTK['gelardepan']." ".$HPTK['nama_lengkap'].$koma." ".$HPTK['gelarbelakang'];


		$QSiswa=mysql_query("select * from siswa_biodata where nis='$nis'");
		$HSiswa=mysql_fetch_array($QSiswa);
		$NMsiswa=$HSiswa['nm_siswa'];


		$Nyetak.="
		<script>
		function printContent(el){
			var restorepage=document.body.innerHTML;
			var printcontent=document.getElementById(el).innerHTML;
			document.body.innerHTML=printcontent;
			window.print();
			document.body.innerHTML=restorepage;
		}
		</script>";


		$TmblCetak.= "<a href='javascript:void(0);' class='btn btn-default btn-ts pull-right' style='margin-top:6px;' onclick=\"printContent('cetak')\"> <i class='fa fa-print'></i> <span class='hidden-xs'>Cetak</span></a>";

		
		$KDPna=JmlDt("select kode_ngajar from gmp_km_tp where kode_ngajar='$kbm'");

		$kkmna=mysql_query("SELECT kkmpeng from gmp_ngajar WHERE id_ngajar='$kbm'");
		$HKKM=mysql_fetch_array($kkmna);
		$KKMP=$HKKM['kkmpeng'];


		$tglSekarang=date('Y-m-d');
	

		if($semester=="1" || $semester=="2"){$Nmklsna=$PilKKLSCR1;}else
		if($semester=="3" || $semester=="4"){$Nmklsna=$PilKKLSCR2;}else
		if($semester=="5" || $semester=="6"){$Nmklsna=$PilKKLSCR3;}
		/*
		$Nyetak.="
		<form action='?page=$page' method='post' name='frmPilih' class='form-inline' role='form'>
			<div class='row pull-right'>
				<div class='col-sm-12 col-md-12'>
					<div class='form-group'>Pililh Siswa &nbsp;&nbsp;</div>".
						FormCF("inline","Siswa","txtNIS","select siswa_biodata.nis,siswa_biodata.nm_siswa,kelas.nama_kelas from kelas,siswa_biodata,perkelas where kelas.nama_kelas=perkelas.nm_kelas and kelas.tahunajaran=perkelas.tahunajaran and perkelas.nis=siswa_biodata.nis and kelas.nama_kelas=perkelas.nm_kelas and kelas.kode_kelas='$Nmklsna' order by siswa_biodata.nis","nis",$PilNISCR,"nm_siswa","onchange=\"document.location.href='?page=$page&sub=updatepilsiswa2&kbm=$kbm&thnajar=$thnajar&semester=$semester&kls=$kls&nis='+document.frmPilih.txtNIS.value\"")."						
				</div>
			</div>
		</form><br><br><hr>";
		*/
		$Nyetak.="
		<div id='cetak'>
		<table style='margin: 0 auto;width:100%;border-collapse:collapse;font:12px Times New Roman;'>
		<tr>
			<td colspan='11' align='center'><font size='4'><strong>PERBAIKAN NILAI SEMESTER</strong></font></td>
		</tr>
		<tr>
			<td colspan='11'>&nbsp;</td>
		</tr>
		<tr>
			<td width='100'>Tahun Ajaran</td>
			<td>: $thnajar</td>
		</tr>
		<tr>
			<td>Semester</td>
			<td>: $semester</td>
		</tr>
		<tr>
			<td>Kelas</td>
			<td>: $kls</td>
		</tr>
		<tr>
			<td>Mata Pelajaran</td>
			<td>: $Mapel ($kbm)</td>
		</tr>
		<tr>
			<td>Nama Siswa</td>
			<td>: $NMsiswa</td>
		</tr>
		<tr>
			<td colspan=14>&nbsp;<td>
		</tr>
		</table>";


		$QNP=mysql_query("SELECT * from n_p_kikd WHERE kd_ngajar='$kbm' AND nis='$nis'");
		$HasilP=mysql_fetch_array($QNP);

		for($x=1;$x<$KDPna+1;$x++){
			
			if($HasilP['kd_'.$x]<$KKMP){$fcolp='#ff0000';}else{$fcolp='';}

			$TNP.="
				<tr height='30'>
					<td align='center'>$x</td>
					<td align='center'><strong><font size='' color='$fcolp'>".$HasilP['kd_'.$x]."</font></strong></td>
					<td align='center'>&nbsp;</td>
				</tr>			
			";
		}

		$NilaiPeng.="
		<strong>Nilai Target Pembelajaran <br>KKM = $KKMP</strong><br><br>
		<table style='margin: 0 auto;width:100%;border-collapse:collapse;font:12px Times New Roman;' border='1'>
			<thead>
				<tr>
					<th width='20'>No. KIKD</th>
					<th width='55'>Nilai</th>
					<th width='55'>Perbaikan</th>
				</tr>
			</thead>
			<tbody>
				$TNP
				<tr height='30'>
					<td align='center'>NA</td>
					<td align='center'>".$HasilP['kikd_p']."</td>
					<td align='center'>&nbsp;</td>
				</tr>				
			</tbody>
		</table>";


		$QNU=mysql_query("SELECT * from n_utsuas WHERE kd_ngajar='$kbm' AND nis='$nis'");
		$HasilU=mysql_fetch_array($QNU);
		$NUTS=$HasilU['uts'];
		$NUAS=$HasilU['uas'];
		$NAUTSUAS=round(($NUTS+$NUAS)/2,0);

		if($NUTS<$KKMP){$fcolt='#ff0000';}else{$fcolt='';}
		if($NUAS<$KKMP){$fcolt='#ff0000';}else{$fcolt='';}

		$NilaiUTSUAS.="
		<strong>Nilai UTS UAS <br>KKM = $KKMP</strong><br><br>
		<table style='margin: 0 auto;width:100%;border-collapse:collapse;font:12px Times New Roman;' border='1'>
			<thead>
				<tr>
					<th width='20'>No.</th>
					<th width='55'>Jenis</th>
					<th width='55'>Nilai</th>
					<th width='55'>Perbaikan</th>
				</tr>
			</thead>
			<tbody>
				<tr height='30'>
					<td align='center'>1</td>
					<td align='center'>UTS</td>
					<td align='center'><strong><font size='' color='$fcolt'>$NUTS</font></strong></td>
					<td align='center'>&nbsp;</td>
				</tr>
				<tr height='30'>
					<td align='center'>2</td>
					<td align='center'>UAS</td>
					<td align='center'><strong><font size='' color='$fcolt'>$NUAS</font></strong></td>
					<td align='center'>&nbsp;</td>
				</tr>
				<tr height='30'>
					<td align='center'>2</td>
					<td align='center'>NA</td>
					<td align='center'>$NAUTSUAS</td>
					<td align='center'>&nbsp;</td>
				</tr>				
			</tbody>
		</table>";
		
		$Nyetak.="
		<table style='margin: 0 auto;width:100%;border-collapse:collapse;font:12px Times New Roman;'>
		<tr>
			<td>$NilaiPeng</td>
			<td width='50'>&nbsp;</td>
			<td valign=top>$NilaiUTSUAS</td>
		</tr>
		</table><br><br>
		Tanggal Perbaikan : ________________ 
		";
		
		$Nyetak.="<br><br><br>
		<strong>Catatan Guru Mata Pelajaran :</strong>
		<table style='margin: 0 auto;width:100%;border-collapse:collapse;font:12px Times New Roman;' border=1>
		<tr>
			<td height='100'>&nbsp;</td>
		</tr>
		</table><br><br>

		<table style='margin: 0 auto;width:100%;border-collapse:collapse;font:12px Times New Roman;'>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td colspan='3'>Tanggal Input :<td>
			<td colspan='3' width='200'>&nbsp;<td>
			<td colspan='5'>{$HProfil['kecamatan']}, ".TglLengkap($tglSekarang)."<td>
		</tr>
		<tr>
			<td colspan='3'>Operator/Petugas Input<td>
			<td colspan='3'>&nbsp;<td>
			<td colspan='5'>Guru Mata Pelajaran<td>
		</tr>
		<tr>
			<td colspan='3'>&nbsp;<td>
			<td colspan='3'>&nbsp;<td>
			<td colspan='5'>&nbsp;<td>
		</tr>
		<tr>
			<td colspan='3'>&nbsp;<td>
			<td colspan='3'>&nbsp;<td>
			<td colspan='5'>&nbsp;<td>
		</tr>
		<tr>
			<td colspan='3'>&nbsp;<td>
			<td colspan='3'>&nbsp;<td>
			<td colspan='5'>&nbsp;<td>
		</tr>
		<tr>
			<td colspan='3'>___________________________<td>
			<td colspan='3'>&nbsp;<td>
			<td colspan='5'><u><strong>$GuruNgajar</strong></u><td>
		</tr>
		<tr>
			<td colspan='3'>NIP.  <td>
			<td colspan='3'>&nbsp;<td>
			<td colspan='5'>$GuruNgajarNIP<td>
		</tr>
		</table>
		</div>";
		echo MyWidget('fa-print',"Cetak Ajuan Remedial",array(ButtonKembali("?page=$page"),$TmblCetak),$Nyetak);
	break;

	case "perbaikan":
		$tnil=isset($_GET['tnil'])?$_GET['tnil']:""; 
		$kbm=isset($_GET['kbm'])?$_GET['kbm']:""; 
		$nis=isset($_GET['nis'])?$_GET['nis']:"";

		$QSiswa=mysql_query("select nm_siswa,nis from siswa_biodata where nis='$nis'");
		$HSiswa=mysql_fetch_array($QSiswa);

		$kkmna=mysql_query("SELECT kkmpeng from gmp_ngajar WHERE id_ngajar='$kbm'");
		$HKKM=mysql_fetch_array($kkmna);

		//identifikasi nilai
		if($tnil=="TP"){
			$jmlKD=JmlDt("select * from gmp_km_tp where kode_ngajar='$kbm'");
			$QN=mysql_query("SELECT * from n_p_kikd WHERE kd_ngajar='$kbm' AND nis='$nis'");
			$Hasil=mysql_fetch_array($QN);
			$iddb=$Hasil['kd_p_kikd'];
			$KKMnya=$HKKM['kkmpeng'];
			$Textnya="Target Pembelajaran";
			$FormNyimpan="<form action='?page=$page&sub=simpanedit&jnil=TP' method='post' name='FrmPerbaikan' id='FrmPerbaikan' role='form'>";
		}
		else if($tnil=="utsuas"){
			$jmlKD=JmlDt("select * from gmp_km_tp where kode_ngajar='$kbm'");
			$QN=mysql_query("SELECT * from n_utsuas WHERE kd_ngajar='$kbm' AND nis='$nis'");
			$Hasil=mysql_fetch_array($QN);
			$iddb=$Hasil['kd_utsuas'];
			$KKMnya=$HKKM['kkmpeng'];
			$Textnya="UTS UAS";
			$FormNyimpan="<form action='?page=$page&sub=simpanedit&jnil=utsuas' method='post' name='FrmPerbaikan' id='FrmPerbaikan' role='form'>";
		}

		if($tnil=="TP"){
			for($x=1;$x<$jmlKD+1;$x++){
				$TampilNilai.="
					<tr height='30'>
						<td align='center'>$x</td>
						<td align='center'><input size='3' type='text' class='form-control input-sm' maxlength='3' value='".$Hasil['kd_'.$x]."' name='txtKD_".$x."[$i]'></td>
					</tr>			
				";
			}
		}
		else {
			$TampilNilai.="
				<tr height='30'>
					<td align='center'>1</td>
					<td align='center'>UTS</td>
					<td align='center'><input size='3' type='text' class='form-control input-sm' maxlength='3' value='".$Hasil['uts']."' name='txtuts'></td>
				</tr>
				<tr height='30'>
					<td align='center'>2</td>
					<td align='center'>UAS</td>
					<td align='center'><input size='3' type='text' class='form-control input-sm' maxlength='3' value='".$Hasil['uas']."' name='txtuas'></td>
				</tr>
			";

		}


		$PilihNilai.="
		<div class='btn-group pull-right'>
			<button class='btn btn-default btn-xs dropdown-toggle' data-toggle='dropdown' style='margin-top:8px;'>
				$Textnya <span class='hidden-xs'></span><span class='caret'></span>
			</button>
			<ul class='dropdown-menu'>
				<li><a href='?page=$page&sub=$sub&tnil=TP&kbm=$kbm&nis=$nis'>Target Pembelajaran</a>
				<li><a href='?page=$page&sub=$sub&tnil=utsuas&kbm=$kbm&nis=$nis'>UTS UAS</a>
			</ul>
		</div>";

		$QPTK=mysql_query("
		SELECT gmp_ngajar.id_ngajar,app_user_guru.nip,app_user_guru.nama_lengkap,app_user_guru.gelardepan,app_user_guru.gelarbelakang
		from gmp_ngajar 
		INNER JOIN app_user_guru ON gmp_ngajar.kd_guru=app_user_guru.id_guru
		WHERE gmp_ngajar.id_ngajar='$kbm'");
		$HPTK=mysql_fetch_array($QPTK);

		$QKBM=mysql_query("
		SELECT gmp_ngajar.id_ngajar,gmp_ngajar.thnajaran,gmp_ngajar.semester,gmp_ngajar.ganjilgenap,ak_kelas.nama_kelas, ak_matapelajaran.nama_mapel
		from gmp_ngajar 
		INNER JOIN ak_matapelajaran ON gmp_ngajar.kd_mapel=ak_matapelajaran.kode_mapel
		INNER JOIN ak_kelas ON gmp_ngajar.kd_kelas=ak_kelas.kode_kelas
		WHERE gmp_ngajar.id_ngajar='$kbm'");
		$HKBM=mysql_fetch_array($QKBM);


		$Identitas.="
		<dl class='dl-horizontal' style='margin-bottom:0px;'>
		  <dt>Nomor DB : </dt><dd>$iddb</dd>
		  <dt>Nomor KBM : </dt><dd>$kbm</dd>
		</dl><br><br>";

		$Identitas.="
		<dl class='dl-horizontal' style='margin-bottom:0px;'>
		  <dt>Nama Pengajar : </dt><dd>{$HPTK['nama_lengkap']}</dd>
		  <dt>NIP : </dt><dd>{$HPTK['nip']}</dd>
		  <dt>Mata Pelajaran : </dt><dd>{$HKBM['nama_mapel']}</dd>
		  <dt>Tahun Pelajaran : </dt><dd>{$HKBM['thnajaran']}</dd>
		  <dt>Semester : </dt><dd>{$HKBM['semester']} ({$HKBM['ganjilgenap']})</dd>
		</dl><br><br>";

		$Identitas.="
		<dl class='dl-horizontal' style='margin-bottom:0px;'>
		  <dt>Nama Siswa : </dt><dd>{$HSiswa['nm_siswa']}</dd>
		  <dt>Nama Siswa : </dt><dd>$nis</dd>
		  <dt>Kelas : </dt><dd>{$HKBM['nama_kelas']}</dd>
		</dl>";
					

		$EditNilai.="
		$FormNyimpan
		<div class='well no-padding'>
		<input class='form-control input-sm' type='hidden' value='$iddb' name='txtIDDB'>
		<input class='form-control input-sm' type='hidden' value='".$Hasil['kd_k_kikd']."' name='txtKd[$i]'>
		<input class='form-control input-sm' type='hidden' value='".$kbm."' name='txtKBM'>
		<input class='form-control input-sm' type='hidden' value='".$nis."' name='txtNIS'>
		<input type='hidden'  value='".$jmlKD."' name='txtJKD'>
		<table class='table table-striped table-bordered table-hover table-condensed' width='100%'>
			<thead>
				<tr>
					<th class='text-center' data-class='expand'>No. KIKD</th>
					<th class='text-center' data-hide='phone'>Perbaikan</th>
				</tr>
			</thead>
			<tbody>$TampilNilai</tbody>
		</table>
		</div>";

		$EditNilai.="<div class='form-actions'>";
		$EditNilai.=bSubmit("SaveUpdate","Update");
		$EditNilai.="</div></form>";
		
		$Show.=DuaKolomD(8,KolomPanel($Identitas),4,KolomPanel($EditNilai));
		$tandamodal="#NgisiNilaiSiswa";
		echo $NgisiNilaiSiswa;
		echo MyWidget('fa-edit',"Edit Nilai $Textnya",array(ButtonKembali("?page=$page"),$PilihNilai),$Show);
	break;

	case "simpanedit":
		$jnil=isset($_GET['jnil'])?$_GET['jnil']:""; 
	
		if($jnil=="TP"){ 
			$txtIDDB=$_POST['txtIDDB'];
			$txtKBM=$_POST['txtKBM'];
			$txtNIS=$_POST['txtNIS'];
			$txtJKD=$_POST['txtJKD'];

			foreach($_POST['txtKd'] as $i => $txtKd){
				$txtKD_1=$_POST['txtKD_1'][$i];
				$txtKD_2=$_POST['txtKD_2'][$i];
				$txtKD_3=$_POST['txtKD_3'][$i];
				$txtKD_4=$_POST['txtKD_4'][$i];
				$txtKD_5=$_POST['txtKD_5'][$i];
				$txtKD_6=$_POST['txtKD_6'][$i];
				$txtKD_7=$_POST['txtKD_7'][$i];
				$txtKD_8=$_POST['txtKD_8'][$i];
				$txtKD_9=$_POST['txtKD_9'][$i];
				$txtKD_10=$_POST['txtKD_10'][$i];
				$txtKD_11=$_POST['txtKD_11'][$i];
				$txtKD_12=$_POST['txtKD_12'][$i];
				$txtKD_13=$_POST['txtKD_13'][$i];
				$txtKD_14=$_POST['txtKD_14'][$i];
				$txtKD_15=$_POST['txtKD_15'][$i];
			}

			$NHP=round(($txtKD_1+$txtKD_2+$txtKD_3+$txtKD_4+$txtKD_5+$txtKD_6+$txtKD_7+$txtKD_8+$txtKD_9+$txtKD_10+$txtKD_11+$txtKD_12+$txtKD_13+$txtKD_14+$txtKD_15)/$txtJKD);
			mysql_query("UPDATE n_p_kikd SET kd_ngajar='$txtKBM',nis='$txtNIS',kd_1='$txtKD_1',kd_2='$txtKD_2',kd_3='$txtKD_3',kd_4='$txtKD_4',kd_5='$txtKD_5',kd_6='$txtKD_6',kd_7='$txtKD_7',kd_8='$txtKD_8',kd_9='$txtKD_9',kd_10='$txtKD_10',kd_11='$txtKD_11',kd_12='$txtKD_12',kd_13='$txtKD_13',kd_14='$txtKD_14',kd_15='$txtKD_15',kikd_p='$NHP' WHERE kd_p_kikd='$txtIDDB'");
			echo ns("Ngedit","parent.location='?page=$page&sub=perbaikan&tnil=TP&kbm=$txtKBM&nis=$txtNIS'","Nilai Pengetahuan dengan Kode KBM <strong class='text-primary'>$txtKBM </strong>");
		}
		else {

			$txtIDDB=$_POST['txtIDDB'];
			$txtKBM=$_POST['txtKBM'];
			$txtNIS=$_POST['txtNIS'];
			$txtuts=$_POST['txtuts'];
			$txtuas=$_POST['txtuas'];

			mysql_query("UPDATE n_utsuas SET kd_ngajar='$txtKBM',nis='$txtNIS',uts='$txtuts',uas='$txtuas' WHERE kd_utsuas='$txtIDDB'");
			echo ns("Ngedit","parent.location='?page=$page&sub=perbaikan&tnil=utsuas&kbm=$txtKBM&nis=$txtNIS'","Nilai UTS dan UAS dengan Kode KBM <strong class='text-primary'>$txtKBM </strong>");			

		}
	break;

	case "updatenis2":
		$nis=isset($_GET['nis'])?$_GET['nis']:"";
		mysql_query("update app_pilih_cekremedial set nis='$nis' where id_pil='$IDna'");
		echo ns("Milih","parent.location='?page=$page&sub=cekremedial'","siswa dengan $nis");
	break;
}
echo '</div>';
include("inc/footer.php");
include("inc/scripts.php");
//"))
?>
