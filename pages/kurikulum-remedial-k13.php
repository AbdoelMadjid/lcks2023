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
		$Show.="
		<form action='?page=$page' method='post' name='frmPilih' class='form-inline' role='form'>
			<div class='row pull-right'>
				<div class='col-sm-12 col-md-12'>
					<div class='form-group'>Pililh Siswa &nbsp;&nbsp;</div>".
						FormCF("inline","Siswa","txtNIS","select siswa_biodata.nis,siswa_biodata.nm_siswa,ak_kelas.nama_kelas from ak_kelas,siswa_biodata,ak_perkelas where ak_kelas.nama_kelas=ak_perkelas.nm_kelas and ak_kelas.tahunajaran=ak_perkelas.tahunajaran and ak_perkelas.nis=siswa_biodata.nis and ak_kelas.nama_kelas=ak_perkelas.nm_kelas and ak_kelas.kode_kelas='$PilKKLSCR1' order by siswa_biodata.nis","nis",$PilNISCR,"nm_siswa","","onchange=\"document.location.href='?page=$page&sub=updatenis2&nis='+document.frmPilih.txtNIS.value\"")."						
				</div>
			</div>
		</form><br><br><hr>";

		$Q="
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
		INNER JOIN app_user_guru ON gmp_ngajar.kd_guru=app_user_guru.id_guru";

// SEMESTER 1

		for($x=1;$x<$jmlKDK+1;$x++){
			if($Hasil['kd_'.$x]>100 || $Hasil['kd_'.$x]==0){$Warna="style='background:#ffcccc;'";}else{$Warna="";}
			$ShowNKData.="
			<td><input size='3' type='text' class='form-control input-sm' $Warna maxlength='3' value='".$Hasil['kd_'.$x]."' name='txtKDK_".$x."[$i]'></td>";
		}
		$QKls1=mysql_query("select * from ak_kelas where id_kls='$PilKelasCR1'");
		$HKls1=mysql_fetch_array($QKls1);
		$TKKls1=$HKls1['tingkat'];

		$Q1="$Q 
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

			$JmlNKDP1=JmlDt("select * from gmp_kikd where kode_ranah='KDP' and kode_ngajar='{$Hasil1['kd_ngajar']}'");			
			$JmlNKDK1=JmlDt("select * from gmp_kikd where kode_ranah='KDK' and kode_ngajar='{$Hasil1['kd_ngajar']}'");


			$QKIKDP1=mysql_query("SELECT * FROM n_p_kikd where kd_ngajar='{$Hasil1['kd_ngajar']}' AND nis='$PilNISCR'");
			$HNKIKDP1=mysql_fetch_array($QKIKDP1);

			$QKIKDK1=mysql_query("SELECT * FROM n_k_kikd where kd_ngajar='{$Hasil1['kd_ngajar']}' AND nis='$PilNISCR'");
			$HNKIKDK1=mysql_fetch_array($QKIKDK1);

			$QKIKDUTSUAS1=mysql_query("SELECT * FROM n_utsuas WHERE kd_ngajar='{$Hasil1['kd_ngajar']}' AND nis='$PilNISCR'");
			$HKIKDUTSUAS1=mysql_fetch_array($QKIKDUTSUAS1);
			
			$NAP1=round(($HNKIKDP1['kikd_p']+$HKIKDUTSUAS1['uts']+$HKIKDUTSUAS1['uas'])/3,0);

			$NA1=round(((round(($HNKIKDP1['kikd_p']+$HKIKDUTSUAS1['uts']+$HKIKDUTSUAS1['uas'])/3,0)+$HNKIKDK1['kikd_k'])/2),0);

			if($NAP1<$Hasil1['kkmpeng']){$bgp1='#ff0000';$fcolp1='#ffffff';}else{$bgp1='';$fcolp1='';}
			if($HNKIKDK1['kikd_k']<$Hasil1['kkmpeng']){$bgk1='#ff0000';$fcolk1='#ffffff';}else{$bgk1='';$fcolk1='';}
			
			if($NAP1<$Hasil1['kkmpeng'] || $HNKIKDK1['kikd_k']<$Hasil1['kkmket']){
				$tmbcetak1="<a href='?page=$page&sub=nyetakperbaikan&kbm={$Hasil1['kd_ngajar']}&nis={$Hasil1['nis']}&thnajar=$TAj1&semester=$Smstr1&kls=$Klsna1' class='btn btn-warning btn-block'><i class='fa fa-print'></i> Cetak </a>";
				$tmbp1="
				<div class='dropdown'>
					<a id='dLabel' role='button' data-toggle='dropdown' class='btn btn-warning btn-block' data-target='#' href='javascript:void(0);'> Perbaikan <span class='caret'></span> </a>
					<ul class='dropdown-menu multi-level' role='menu'>
						<li><a href='javascript:void(0);'>{$Hasil1['nama_mapel']}</a></li>
						<li class='divider'></li>
						<li><a href='?page=$page&sub=perbaikan&tnil=k3&kbm={$Hasil1['kd_ngajar']}&nis=$PilNISCR'><i class='fa fa-edit'></i> K3</a></li>
						<li><a href='?page=$page&sub=perbaikan&tnil=utsuas&kbm={$Hasil1['kd_ngajar']}&nis=$PilNISCR'><i class='fa fa-edit'></i> UTS UAS</a></li>
						<li><a href='?page=$page&sub=perbaikan&tnil=k4&kbm={$Hasil1['kd_ngajar']}&nis=$PilNISCR'><i class='fa fa-edit'></i> K4</a></li>
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
						<li><a href='?page=$page&sub=perbaikan&tnil=k3&kbm={$Hasil1['kd_ngajar']}&nis=$PilNISCR'><i class='fa fa-edit'></i> K3</a></li>
						<li><a href='?page=$page&sub=perbaikan&tnil=utsuas&kbm={$Hasil1['kd_ngajar']}&nis=$PilNISCR'><i class='fa fa-edit'></i> UTS UAS</a></li>
						<li><a href='?page=$page&sub=perbaikan&tnil=k4&kbm={$Hasil1['kd_ngajar']}&nis=$PilNISCR'><i class='fa fa-edit'></i> K4</a></li>
					</ul>
				</div>";
				}
			$TampilData1.="
			<tr>
				<td>$no1.</td>
				<td>{$Hasil1['id_guru']} {$Hasil1['nama_lengkap']}<br><span class='text-danger'>{$Hasil1['nama_mapel']}</span></td>
				<td>{$Hasil1['kkmpeng']} -  {$Hasil1['kkmket']}</td>
				<td>$JmlNKDP1 -  $JmlNKDK1</td>
				<td>$tmbp1</td>
				<td bgcolor='$bgp1'><font size='' color='$fcolp1'>$NAP1</font></td>
				<td bgcolor='$bgk1'><font size='' color='$fcolk1'>{$HNKIKDK1['kikd_k']}</font></td>
				<td>$NA1</td>
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
							<th class='text-center' data-hide='phone'>KIKD</th>
							<th class='text-center' data-hide='phone'>Perbaikan</th>
							<th class='text-center' data-hide='phone'>NA K3</th>
							<th class='text-center' data-hide='phone'>NA K4</th>
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

// SEMESTER 2
		$QKls2=mysql_query("select * from ak_kelas where id_kls='$PilKelasCR1'");
		$HKls2=mysql_fetch_array($QKls2);
		$TKKls2=$HKls2['tingkat'];

		$Q2="$Q 
		WHERE ak_perkelas.tahunajaran='$PilTACR1' 
		and ak_perkelas.tk='$TKKls1' 
		AND ak_kelas.kode_kelas='$PilKKLSCR1' 
		AND ak_perkelas.nis='$PilNISCR'
		AND gmp_ngajar.thnajaran='$PilTACR1' 
		AND gmp_ngajar.semester='2'";
		$MassaKBM2="Tahun Ajaran $PilTACR1 Semester 2";
		$TAj2=$PilTACR1;
		$Smstr2='2';
		$Klsna2=$PilNKLSCR1;

		$no2=1;
		$Query2=mysql_query("$Q2 ORDER BY gmp_ngajar.kd_mapel");
		while($Hasil2=mysql_fetch_array($Query2)){
			$nmsiswa2=$Hasil2['nm_siswa'];

			//tampilkan nilai KETERAMPILAN ==========================================

			$JmlNKDP2=JmlDt("select * from gmp_kikd where kode_ranah='KDP' and kode_ngajar='{$Hasil2['kd_ngajar']}'");			
			$JmlNKDK2=JmlDt("select * from gmp_kikd where kode_ranah='KDK' and kode_ngajar='{$Hasil2['kd_ngajar']}'");


			$QKIKDP2=mysql_query("SELECT * FROM n_p_kikd where kd_ngajar='{$Hasil2['kd_ngajar']}' AND nis='$PilNISCR'");
			$HNKIKDP2=mysql_fetch_array($QKIKDP2);

			$QKIKDK2=mysql_query("SELECT * FROM n_k_kikd where kd_ngajar='{$Hasil2['kd_ngajar']}' AND nis='$PilNISCR'");
			$HNKIKDK2=mysql_fetch_array($QKIKDK2);

			$QKIKDUTSUAS2=mysql_query("SELECT * FROM n_utsuas WHERE kd_ngajar='{$Hasil2['kd_ngajar']}' AND nis='$PilNISCR'");
			$HKIKDUTSUAS2=mysql_fetch_array($QKIKDUTSUAS2);
			
			$NAP2=round(($HNKIKDP2['kikd_p']+$HKIKDUTSUAS2['uts']+$HKIKDUTSUAS2['uas'])/3,0);

			$NA2=round(((round(($HNKIKDP2['kikd_p']+$HKIKDUTSUAS2['uts']+$HKIKDUTSUAS2['uas'])/3,0)+$HNKIKDK2['kikd_k'])/2),0);

			if($NAP2<$Hasil2['kkmpeng']){$bgp2='#ff0000';$fcolp2='#ffffff';}else{$bgp2='';$fcolp2='';}
			if($HNKIKDK2['kikd_k']<$Hasil2['kkmpeng']){$bgk2='#ff0000';$fcolk2='#ffffff';}else{$bgk2='';$fcolk2='';}
			
			if($NAP2<$Hasil2['kkmpeng'] || $HNKIKDK2['kikd_k']<$Hasil2['kkmket']){
				$tmbcetak2="<a href='?page=$page&sub=nyetakperbaikan&kbm={$Hasil2['kd_ngajar']}&nis={$Hasil2['nis']}&thnajar=$TAj2&semester=$Smstr2&kls=$Klsna2' class='btn btn-warning btn-block'><i class='fa fa-print'></i> Cetak </a>";
				$tmbp2="
				<div class='dropdown'>
					<a id='dLabel' role='button' data-toggle='dropdown' class='btn btn-warning btn-block' data-target='#' href='javascript:void(0);'> Perbaikan <span class='caret'></span> </a>
					<ul class='dropdown-menu multi-level' role='menu'>
						<li><a href='javascript:void(0);'>{$Hasil2['nama_mapel']}</a></li>
						<li class='divider'></li>
						<li><a href='?page=$page&sub=perbaikan&tnil=k3&kbm={$Hasil2['kd_ngajar']}&nis=$PilNISCR'><i class='fa fa-edit'></i> K3</a></li>
						<li><a href='?page=$page&sub=perbaikan&tnil=utsuas&kbm={$Hasil2['kd_ngajar']}&nis=$PilNISCR'><i class='fa fa-edit'></i> UTS UAS</a></li>
						<li><a href='?page=$page&sub=perbaikan&tnil=k4&kbm={$Hasil2['kd_ngajar']}&nis=$PilNISCR'><i class='fa fa-edit'></i> K4</a></li>
					</ul>
				</div>";
			}
			else{
				$tmbcetak2="<a href='?page=$page&sub=nyetakperbaikan&kbm={$Hasil2['kd_ngajar']}&nis={$Hasil2['nis']}&thnajar=$TAj2&semester=$Smstr2&kls=$Klsna2' class='btn btn-default btn-block'><i class='fa fa-print'></i> Cetak </a>";
				$tmbp2="
				<div class='dropdown'>
					<a id='dLabel' role='button' data-toggle='dropdown' class='btn btn-default btn-block' data-target='#' href='javascript:void(0);'> Perbaikan <span class='caret'></span> </a>
					<ul class='dropdown-menu multi-level' role='menu'>
						<li><a href='javascript:void(0);'>{$Hasil2['nama_mapel']}</a></li>
						<li class='divider'></li>
						<li><a href='?page=$page&sub=perbaikan&tnil=k3&kbm={$Hasil2['kd_ngajar']}&nis=$PilNISCR'><i class='fa fa-edit'></i> K3</a></li>
						<li><a href='?page=$page&sub=perbaikan&tnil=utsuas&kbm={$Hasil2['kd_ngajar']}&nis=$PilNISCR'><i class='fa fa-edit'></i> UTS UAS</a></li>
						<li><a href='?page=$page&sub=perbaikan&tnil=k4&kbm={$Hasil2['kd_ngajar']}&nis=$PilNISCR'><i class='fa fa-edit'></i> K4</a></li>
					</ul>
				</div>";
				}
			$TampilData2.="
			<tr>
				<td>$no2.</td>
				<td>{$Hasil2['id_guru']} {$Hasil2['nama_lengkap']}<br><span class='text-danger'>{$Hasil2['nama_mapel']}</span></td>
				<td>{$Hasil2['kkmpeng']} -  {$Hasil2['kkmket']}</td>
				<td>$JmlNKDP2 -  $JmlNKDK2</td>
				<td>$tmbp2</td>
				<td bgcolor='$bgp2'><font size='' color='$fcolp2'>$NAP2</font></td>
				<td bgcolor='$bgk2'><font size='' color='$fcolk2'>{$HNKIKDK2['kikd_k']}</font></td>
				<td>$NA2</td>
				<td>$tmbcetak2</td>
			</tr>";
			$no2++;
		}
	
		$jmldata2=mysql_num_rows($Query2);
		if($jmldata2>0){
			$Show.="<hr>";
			$Show.="<p class='text-danger' style='margin-top:-10px;'>$MassaKBM2</p>";
			$Show.="
			<div class='well no-padding'>
				<table id='dt_basic' class='table table-striped table-bordered table-hover table-condensed' width='100%'>
					<thead>
						<tr>
							<th class='text-center' data-class='expand'>No.</th>
							<th class='text-center'>Nama Guru / Mapel</th>
							<th class='text-center' data-hide='phone'>KKM</th>
							<th class='text-center' data-hide='phone'>KIKD</th>
							<th class='text-center' data-hide='phone'>Perbaikan</th>
							<th class='text-center' data-hide='phone'>NA K3</th>
							<th class='text-center' data-hide='phone'>NA K4</th>
							<th class='text-center' data-hide='phone'>NA</th>
							<th class='text-center' data-hide='phone' width='25'>Cetak</th>
						</tr>
					</thead>
					<tbody>$TampilData2</tbody>
				</table>
			</div>";
		}
		else{
			$Show.="<hr>";
			$Show.="<p class='text-danger' style='margin-top:-10px;'>$MassaKBM2</p>";
			$Show.='			
			<div class="well"><p class="text-center"><img src="img/firda.png" width="200" height="220" border="0" alt=""></p><h1 class="text-center"><small class="text-danger slideInRight fast animated"><strong>Nilai <br>'.$MassaKBM2.' <br>belum tersedia!</strong></small></h1></div>';
		}

// SEMESTER 3
		$QKls3=mysql_query("select * from ak_kelas where id_kls='$PilKelasCR2'");
		$HKls3=mysql_fetch_array($QKls3);
		$TKKls3=$HKls3['tingkat'];


		$Q3="$Q 
		WHERE ak_perkelas.tahunajaran='$PilTACR2' 
		and ak_perkelas.tk='$TKKls3' 
		AND ak_kelas.kode_kelas='$PilKKLSCR2' 
		AND ak_perkelas.nis='$PilNISCR'
		AND gmp_ngajar.thnajaran='$PilTACR2' 
		AND gmp_ngajar.semester='3'";
		$MassaKBM3="Tahun Ajaran $PilTACR2 Semester 3";
		$TAj3=$PilTACR2;
		$Smstr3='3';
		$Klsna3=$PilNKLSCR2;

		$no3=1;
		$Query3=mysql_query("$Q3 ORDER BY gmp_ngajar.kd_mapel");
		while($Hasil3=mysql_fetch_array($Query3)){
			$nmsiswa3=$Hasil3['nm_siswa'];

			//tampilkan nilai KETERAMPILAN ==========================================

			$JmlNKDP3=JmlDt("select * from gmp_kikd where kode_ranah='KDP' and kode_ngajar='{$Hasil3['kd_ngajar']}'");			
			$JmlNKDK3=JmlDt("select * from gmp_kikd where kode_ranah='KDK' and kode_ngajar='{$Hasil3['kd_ngajar']}'");


			$QKIKDP3=mysql_query("SELECT * FROM n_p_kikd where kd_ngajar='{$Hasil3['kd_ngajar']}' AND nis='$PilNISCR'");
			$HNKIKDP3=mysql_fetch_array($QKIKDP3);

			$QKIKDK3=mysql_query("SELECT * FROM n_k_kikd where kd_ngajar='{$Hasil3['kd_ngajar']}' AND nis='$PilNISCR'");
			$HNKIKDK3=mysql_fetch_array($QKIKDK3);

			$QKIKDUTSUAS3=mysql_query("SELECT * FROM n_utsuas WHERE kd_ngajar='{$Hasil3['kd_ngajar']}' AND nis='$PilNISCR'");
			$HKIKDUTSUAS3=mysql_fetch_array($QKIKDUTSUAS3);
			
			$NAP3=round(($HNKIKDP3['kikd_p']+$HKIKDUTSUAS3['uts']+$HKIKDUTSUAS3['uas'])/3,0);

			$NA3=round(((round(($HNKIKDP3['kikd_p']+$HKIKDUTSUAS3['uts']+$HKIKDUTSUAS3['uas'])/3,0)+$HNKIKDK3['kikd_k'])/2),0);

			if($NAP3<$Hasil3['kkmpeng']){$bgp3='#ff0000';$fcolp3='#ffffff';}else{$bgp3='';$fcolp3='';}
			if($HNKIKDK3['kikd_k']<$Hasil3['kkmpeng']){$bgk3='#ff0000';$fcolk3='#ffffff';}else{$bgk3='';$fcolk3='';}
			
			if($NAP3<$Hasil3['kkmpeng'] || $HNKIKDK3['kikd_k']<$Hasil3['kkmket']){
				$tmbcetak3="<a href='?page=$page&sub=nyetakperbaikan&kbm={$Hasil3['kd_ngajar']}&nis={$Hasil3['nis']}&thnajar=$TAj3&semester=$Smstr3&kls=$Klsna3' class='btn btn-warning btn-block'><i class='fa fa-print'></i> Cetak </a>";
				$tmbp3="
				<div class='dropdown'>
					<a id='dLabel' role='button' data-toggle='dropdown' class='btn btn-warning btn-block' data-target='#' href='javascript:void(0);'> Perbaikan <span class='caret'></span> </a>
					<ul class='dropdown-menu multi-level' role='menu'>
						<li><a href='javascript:void(0);'>{$Hasil3['nama_mapel']}</a></li>
						<li class='divider'></li>
						<li><a href='?page=$page&sub=perbaikan&tnil=k3&kbm={$Hasil3['kd_ngajar']}&nis=$PilNISCR'><i class='fa fa-edit'></i> K3</a></li>
						<li><a href='?page=$page&sub=perbaikan&tnil=utsuas&kbm={$Hasil3['kd_ngajar']}&nis=$PilNISCR'><i class='fa fa-edit'></i> UTS UAS</a></li>
						<li><a href='?page=$page&sub=perbaikan&tnil=k4&kbm={$Hasil3['kd_ngajar']}&nis=$PilNISCR'><i class='fa fa-edit'></i> K4</a></li>
					</ul>
				</div>";
			}
			else{
				$tmbcetak3="<a href='?page=$page&sub=nyetakperbaikan&kbm={$Hasil3['kd_ngajar']}&nis={$Hasil3['nis']}&thnajar=$TAj3&semester=$Smstr3&kls=$Klsna3' class='btn btn-default btn-block'><i class='fa fa-print'></i> Cetak </a>";
				$tmbp3="
				<div class='dropdown'>
					<a id='dLabel' role='button' data-toggle='dropdown' class='btn btn-default btn-block' data-target='#' href='javascript:void(0);'> Perbaikan <span class='caret'></span> </a>
					<ul class='dropdown-menu multi-level' role='menu'>
						<li><a href='javascript:void(0);'>{$Hasil3['nama_mapel']}</a></li>
						<li class='divider'></li>
						<li><a href='?page=$page&sub=perbaikan&tnil=k3&kbm={$Hasil3['kd_ngajar']}&nis=$PilNISCR'><i class='fa fa-edit'></i> K3</a></li>
						<li><a href='?page=$page&sub=perbaikan&tnil=utsuas&kbm={$Hasil3['kd_ngajar']}&nis=$PilNISCR'><i class='fa fa-edit'></i> UTS UAS</a></li>
						<li><a href='?page=$page&sub=perbaikan&tnil=k4&kbm={$Hasil3['kd_ngajar']}&nis=$PilNISCR'><i class='fa fa-edit'></i> K4</a></li>
					</ul>
				</div>";
				}
			$TampilData3.="
			<tr>
				<td>$no3.</td>
				<td>{$Hasil3['id_guru']} {$Hasil3['nama_lengkap']}<br><span class='text-danger'>{$Hasil3['nama_mapel']}</span></td>
				<td>{$Hasil3['kkmpeng']} -  {$Hasil3['kkmket']}</td>
				<td>$JmlNKDP3 -  $JmlNKDK3</td>
				<td>$tmbp3</td>
				<td bgcolor='$bgp3'><font size='' color='$fcolp3'>$NAP3</font></td>
				<td bgcolor='$bgk3'><font size='' color='$fcolk3'>{$HNKIKDK3['kikd_k']}</font></td>
				<td>$NA3</td>
				<td>$tmbcetak3</td>
			</tr>";
			$no3++;
		}
	
		$jmldata3=mysql_num_rows($Query3);
		if($jmldata3>0){
			$Show.="<hr>";
			$Show.="<p class='text-danger' style='margin-top:-10px;'>$MassaKBM3</p>";
			$Show.="
			<div class='well no-padding'>
				<table id='dt_basic' class='table table-striped table-bordered table-hover table-condensed' width='100%'>
					<thead>
						<tr>
							<th class='text-center' data-class='expand'>No.</th>
							<th class='text-center'>Nama Guru / Mapel</th>
							<th class='text-center' data-hide='phone'>KKM</th>
							<th class='text-center' data-hide='phone'>KIKD</th>
							<th class='text-center' data-hide='phone'>Perbaikan</th>
							<th class='text-center' data-hide='phone'>NA K3</th>
							<th class='text-center' data-hide='phone'>NA K4</th>
							<th class='text-center' data-hide='phone'>NA</th>
							<th class='text-center' data-hide='phone' width='25'>Cetak</th>
						</tr>
					</thead>
					<tbody>$TampilData3</tbody>
				</table>
			</div>";
		}
		else{
			$Show.="<hr>";
			$Show.="<p class='text-danger' style='margin-top:-10px;'>$MassaKBM3</p>";
			$Show.='			
			<div class="well"><p class="text-center"><img src="img/firda.png" width="200" height="220" border="0" alt=""></p><h1 class="text-center"><small class="text-danger slideInRight fast animated"><strong>Nilai <br>'.$MassaKBM3.' <br>belum tersedia!</strong></small></h1></div>';
		}

// SEMESTER 4
		$QKls4=mysql_query("select * from ak_kelas where id_kls='$PilKelasCR2'");
		$HKls4=mysql_fetch_array($QKls4);
		$TKKls4=$HKls4['tingkat'];


		$Q4="$Q 
		WHERE ak_perkelas.tahunajaran='$PilTACR2' 
		and ak_perkelas.tk='$TKKls4' 
		AND ak_kelas.kode_kelas='$PilKKLSCR2' 
		AND ak_perkelas.nis='$PilNISCR'
		AND gmp_ngajar.thnajaran='$PilTACR2' 
		AND gmp_ngajar.semester='4'";
		$MassaKBM4="Tahun Ajaran $PilTACR2 Semester 4";
		$TAj4=$PilTACR2;
		$Smstr4='4';
		$Klsna4=$PilNKLSCR2;

		$no4=1;
		$Query4=mysql_query("$Q4 ORDER BY gmp_ngajar.kd_mapel");
		while($Hasil4=mysql_fetch_array($Query4)){
			$nmsiswa4=$Hasil4['nm_siswa'];

			//tampilkan nilai KETERAMPILAN ==========================================

			$JmlNKDP4=JmlDt("select * from gmp_kikd where kode_ranah='KDP' and kode_ngajar='{$Hasil4['kd_ngajar']}'");			
			$JmlNKDK4=JmlDt("select * from gmp_kikd where kode_ranah='KDK' and kode_ngajar='{$Hasil4['kd_ngajar']}'");


			$QKIKDP4=mysql_query("SELECT * FROM n_p_kikd where kd_ngajar='{$Hasil4['kd_ngajar']}' AND nis='$PilNISCR'");
			$HNKIKDP4=mysql_fetch_array($QKIKDP4);

			$QKIKDK4=mysql_query("SELECT * FROM n_k_kikd where kd_ngajar='{$Hasil4['kd_ngajar']}' AND nis='$PilNISCR'");
			$HNKIKDK4=mysql_fetch_array($QKIKDK4);

			$QKIKDUTSUAS4=mysql_query("SELECT * FROM n_utsuas WHERE kd_ngajar='{$Hasil4['kd_ngajar']}' AND nis='$PilNISCR'");
			$HKIKDUTSUAS4=mysql_fetch_array($QKIKDUTSUAS4);
			
			$NAP4=round(($HNKIKDP4['kikd_p']+$HKIKDUTSUAS4['uts']+$HKIKDUTSUAS4['uas'])/3,0);

			$NA4=round(((round(($HNKIKDP4['kikd_p']+$HKIKDUTSUAS4['uts']+$HKIKDUTSUAS4['uas'])/3,0)+$HNKIKDK4['kikd_k'])/2),0);

			if($NAP4<$Hasil4['kkmpeng']){$bgp4='#ff0000';$fcolp4='#ffffff';}else{$bgp4='';$fcolp4='';}
			if($HNKIKDK4['kikd_k']<$Hasil4['kkmpeng']){$bgk4='#ff0000';$fcolk4='#ffffff';}else{$bgk4='';$fcolk4='';}
			
			if($NAP4<$Hasil4['kkmpeng'] || $HNKIKDK4['kikd_k']<$Hasil4['kkmket']){
				$tmbcetak4="<a href='?page=$page&sub=nyetakperbaikan&kbm={$Hasil4['kd_ngajar']}&nis={$Hasil4['nis']}&thnajar=$TAj4&semester=$Smstr4&kls=$Klsna4' class='btn btn-warning btn-block'><i class='fa fa-print'></i> Cetak </a>";
				$tmbp4="
				<div class='dropdown'>
					<a id='dLabel' role='button' data-toggle='dropdown' class='btn btn-warning btn-block' data-target='#' href='javascript:void(0);'> Perbaikan <span class='caret'></span> </a>
					<ul class='dropdown-menu multi-level' role='menu'>
						<li><a href='javascript:void(0);'>{$Hasil4['nama_mapel']}</a></li>
						<li class='divider'></li>
						<li><a href='?page=$page&sub=perbaikan&tnil=k3&kbm={$Hasil4['kd_ngajar']}&nis=$PilNISCR'><i class='fa fa-edit'></i> K3</a></li>
						<li><a href='?page=$page&sub=perbaikan&tnil=utsuas&kbm={$Hasil4['kd_ngajar']}&nis=$PilNISCR'><i class='fa fa-edit'></i> UTS UAS</a></li>
						<li><a href='?page=$page&sub=perbaikan&tnil=k4&kbm={$Hasil4['kd_ngajar']}&nis=$PilNISCR'><i class='fa fa-edit'></i> K4</a></li>
					</ul>
				</div>";
			}
			else{
				$tmbcetak4="<a href='?page=$page&sub=nyetakperbaikan&kbm={$Hasil4['kd_ngajar']}&nis={$Hasil4['nis']}&thnajar=$TAj4&semester=$Smstr4&kls=$Klsna4' class='btn btn-default btn-block'><i class='fa fa-print'></i> Cetak </a>";
				$tmbp4="
				<div class='dropdown'>
					<a id='dLabel' role='button' data-toggle='dropdown' class='btn btn-default btn-block' data-target='#' href='javascript:void(0);'> Perbaikan <span class='caret'></span> </a>
					<ul class='dropdown-menu multi-level' role='menu'>
						<li><a href='javascript:void(0);'>{$Hasil4['nama_mapel']}</a></li>
						<li class='divider'></li>
						<li><a href='?page=$page&sub=perbaikan&tnil=k3&kbm={$Hasil4['kd_ngajar']}&nis=$PilNISCR'><i class='fa fa-edit'></i> K3</a></li>
						<li><a href='?page=$page&sub=perbaikan&tnil=utsuas&kbm={$Hasil4['kd_ngajar']}&nis=$PilNISCR'><i class='fa fa-edit'></i> UTS UAS</a></li>
						<li><a href='?page=$page&sub=perbaikan&tnil=k4&kbm={$Hasil4['kd_ngajar']}&nis=$PilNISCR'><i class='fa fa-edit'></i> K4</a></li>
					</ul>
				</div>";
				}
			$TampilData4.="
			<tr>
				<td>$no4.</td>
				<td>{$Hasil4['id_guru']} {$Hasil4['nama_lengkap']}<br><span class='text-danger'>{$Hasil4['nama_mapel']}</span></td>
				<td>{$Hasil4['kkmpeng']} -  {$Hasil4['kkmket']}</td>
				<td>$JmlNKDP4 -  $JmlNKDK4</td>
				<td>$tmbp4</td>
				<td bgcolor='$bgp4'><font size='' color='$fcolp4'>$NAP4</font></td>
				<td bgcolor='$bgk4'><font size='' color='$fcolk4'>{$HNKIKDK4['kikd_k']}</font></td>
				<td>$NA4</td>
				<td>$tmbcetak4</td>
			</tr>";
			$no4++;
		}
	
		$jmldata4=mysql_num_rows($Query4);
		if($jmldata4>0){
			$Show.="<hr>";
			$Show.="<p class='text-danger' style='margin-top:-10px;'>$MassaKBM4</p>";
			$Show.="
			<div class='well no-padding'>
				<table id='dt_basic' class='table table-striped table-bordered table-hover table-condensed' width='100%'>
					<thead>
						<tr>
							<th class='text-center' data-class='expand'>No.</th>
							<th class='text-center'>Nama Guru / Mapel</th>
							<th class='text-center' data-hide='phone'>KKM</th>
							<th class='text-center' data-hide='phone'>KIKD</th>
							<th class='text-center' data-hide='phone'>Perbaikan</th>
							<th class='text-center' data-hide='phone'>NA K3</th>
							<th class='text-center' data-hide='phone'>NA K4</th>
							<th class='text-center' data-hide='phone'>NA</th>
							<th class='text-center' data-hide='phone' width='25'>Cetak</th>
						</tr>
					</thead>
					<tbody>$TampilData4</tbody>
				</table>
			</div>";
		}
		else{
			$Show.="<hr>";
			$Show.="<p class='text-danger' style='margin-top:-10px;'>$MassaKBM4</p>";
			$Show.='			
			<div class="well"><p class="text-center"><img src="img/firda.png" width="200" height="220" border="0" alt=""></p><h1 class="text-center"><small class="text-danger slideInRight fast animated"><strong>Nilai <br>'.$MassaKBM4.' <br>belum tersedia!</strong></small></h1></div>';
		}
// SEMESTER 5
		$QKls5=mysql_query("select * from ak_kelas where id_kls='$PilKelasCR3'");
		$HKls5=mysql_fetch_array($QKls5);
		$TKKls5=$HKls5['tingkat'];


		$Q5="$Q 
		WHERE ak_perkelas.tahunajaran='$PilTACR3' 
		and ak_perkelas.tk='$TKKls5' 
		AND ak_kelas.kode_kelas='$PilKKLSCR3' 
		AND ak_perkelas.nis='$PilNISCR'
		AND gmp_ngajar.thnajaran='$PilTACR3' 
		AND gmp_ngajar.semester='5'";
		$MassaKBM5="Tahun Ajaran $PilTACR3 Semester 5";
		$TAj5=$PilTACR3;
		$Smstr5='5';
		$Klsna5=$PilNKLSCR3;

		$no5=1;
		$Query5=mysql_query("$Q5 ORDER BY gmp_ngajar.kd_mapel");
		while($Hasil5=mysql_fetch_array($Query5)){
			$nmsiswa5=$Hasil5['nm_siswa'];

			//tampilkan nilai KETERAMPILAN ==========================================

			$JmlNKDP5=JmlDt("select * from gmp_kikd where kode_ranah='KDP' and kode_ngajar='{$Hasil5['kd_ngajar']}'");			
			$JmlNKDK5=JmlDt("select * from gmp_kikd where kode_ranah='KDK' and kode_ngajar='{$Hasil5['kd_ngajar']}'");


			$QKIKDP5=mysql_query("SELECT * FROM n_p_kikd where kd_ngajar='{$Hasil5['kd_ngajar']}' AND nis='$PilNISCR'");
			$HNKIKDP5=mysql_fetch_array($QKIKDP5);

			$QKIKDK5=mysql_query("SELECT * FROM n_k_kikd where kd_ngajar='{$Hasil5['kd_ngajar']}' AND nis='$PilNISCR'");
			$HNKIKDK5=mysql_fetch_array($QKIKDK5);

			$QKIKDUTSUAS5=mysql_query("SELECT * FROM n_utsuas WHERE kd_ngajar='{$Hasil5['kd_ngajar']}' AND nis='$PilNISCR'");
			$HKIKDUTSUAS5=mysql_fetch_array($QKIKDUTSUAS5);
			
			$NAP5=round(($HNKIKDP5['kikd_p']+$HKIKDUTSUAS5['uts']+$HKIKDUTSUAS5['uas'])/3,0);

			$NA5=round(((round(($HNKIKDP5['kikd_p']+$HKIKDUTSUAS5['uts']+$HKIKDUTSUAS5['uas'])/3,0)+$HNKIKDK5['kikd_k'])/2),0);

			if($NAP5<$Hasil5['kkmpeng']){$bgp5='#ff0000';$fcolp5='#ffffff';}else{$bgp5='';$fcolp5='';}
			if($HNKIKDK5['kikd_k']<$Hasil5['kkmpeng']){$bgk5='#ff0000';$fcolk5='#ffffff';}else{$bgk5='';$fcolk5='';}
			
			if($NAP5<$Hasil5['kkmpeng'] || $HNKIKDK5['kikd_k']<$Hasil5['kkmket']){
				$tmbcetak5="<a href='?page=$page&sub=nyetakperbaikan&kbm={$Hasil5['kd_ngajar']}&nis={$Hasil5['nis']}&thnajar=$TAj5&semester=$Smstr5&kls=$Klsna5' class='btn btn-warning btn-block'><i class='fa fa-print'></i> Cetak </a>";
				$tmbp5="
				<div class='dropdown'>
					<a id='dLabel' role='button' data-toggle='dropdown' class='btn btn-warning btn-block' data-target='#' href='javascript:void(0);'> Perbaikan <span class='caret'></span> </a>
					<ul class='dropdown-menu multi-level' role='menu'>
						<li><a href='javascript:void(0);'>{$Hasil5['nama_mapel']}</a></li>
						<li class='divider'></li>
						<li><a href='?page=$page&sub=perbaikan&tnil=k3&kbm={$Hasil5['kd_ngajar']}&nis=$PilNISCR'><i class='fa fa-edit'></i> K3</a></li>
						<li><a href='?page=$page&sub=perbaikan&tnil=utsuas&kbm={$Hasil5['kd_ngajar']}&nis=$PilNISCR'><i class='fa fa-edit'></i> UTS UAS</a></li>
						<li><a href='?page=$page&sub=perbaikan&tnil=k4&kbm={$Hasil5['kd_ngajar']}&nis=$PilNISCR'><i class='fa fa-edit'></i> K4</a></li>
					</ul>
				</div>";
			}
			else{
				$tmbcetak5="<a href='?page=$page&sub=nyetakperbaikan&kbm={$Hasil5['kd_ngajar']}&nis={$Hasil5['nis']}&thnajar=$TAj5&semester=$Smstr5&kls=$Klsna5' class='btn btn-default btn-block'><i class='fa fa-print'></i> Cetak </a>";
				$tmbp5="
				<div class='dropdown'>
					<a id='dLabel' role='button' data-toggle='dropdown' class='btn btn-default btn-block' data-target='#' href='javascript:void(0);'> Perbaikan <span class='caret'></span> </a>
					<ul class='dropdown-menu multi-level' role='menu'>
						<li><a href='javascript:void(0);'>{$Hasil5['nama_mapel']}</a></li>
						<li class='divider'></li>
						<li><a href='?page=$page&sub=perbaikan&tnil=k3&kbm={$Hasil5['kd_ngajar']}&nis=$PilNISCR'><i class='fa fa-edit'></i> K3</a></li>
						<li><a href='?page=$page&sub=perbaikan&tnil=utsuas&kbm={$Hasil5['kd_ngajar']}&nis=$PilNISCR'><i class='fa fa-edit'></i> UTS UAS</a></li>
						<li><a href='?page=$page&sub=perbaikan&tnil=k4&kbm={$Hasil5['kd_ngajar']}&nis=$PilNISCR'><i class='fa fa-edit'></i> K4</a></li>
					</ul>
				</div>";
				}
			$TampilData5.="
			<tr>
				<td>$no5.</td>
				<td>{$Hasil5['id_guru']} {$Hasil5['nama_lengkap']}<br><span class='text-danger'>{$Hasil5['nama_mapel']}</span></td>
				<td>{$Hasil5['kkmpeng']} -  {$Hasil5['kkmket']}</td>
				<td>$JmlNKDP5 -  $JmlNKDK5</td>
				<td>$tmbp5</td>
				<td bgcolor='$bgp5'><font size='' color='$fcolp5'>$NAP5</font></td>
				<td bgcolor='$bgk5'><font size='' color='$fcolk5'>{$HNKIKDK5['kikd_k']}</font></td>
				<td>$NA5</td>
				<td>$tmbcetak5</td>
			</tr>";
			$no5++;
		}
	
		$jmldata5=mysql_num_rows($Query5);
		if($jmldata5>0){
			$Show.="<hr>";
			$Show.="<p class='text-danger' style='margin-top:-10px;'>$MassaKBM5</p>";
			$Show.="
			<div class='well no-padding'>
				<table id='dt_basic' class='table table-striped table-bordered table-hover table-condensed' width='100%'>
					<thead>
						<tr>
							<th class='text-center' data-class='expand'>No.</th>
							<th class='text-center'>Nama Guru / Mapel</th>
							<th class='text-center' data-hide='phone'>KKM</th>
							<th class='text-center' data-hide='phone'>KIKD</th>
							<th class='text-center' data-hide='phone'>Perbaikan</th>
							<th class='text-center' data-hide='phone'>NA K3</th>
							<th class='text-center' data-hide='phone'>NA K4</th>
							<th class='text-center' data-hide='phone'>NA</th>
							<th class='text-center' data-hide='phone' width='25'>Cetak</th>
						</tr>
					</thead>
					<tbody>$TampilData5</tbody>
				</table>
			</div>";
		}
		else{
			$Show.="<hr>";
			$Show.="<p class='text-danger' style='margin-top:-10px;'>$MassaKBM5</p>";
			$Show.='			
			<div class="well"><p class="text-center"><img src="img/firda.png" width="200" height="220" border="0" alt=""></p><h1 class="text-center"><small class="text-danger slideInRight fast animated"><strong>Nilai <br>'.$MassaKBM5.' <br>belum tersedia!</strong></small></h1></div>';
		}

// SEMESTER 6

		$QKls6=mysql_query("select * from ak_kelas where id_kls='$PilKelasCR3'");
		$HKls6=mysql_fetch_array($QKls6);
		$TKKls6=$HKls6['tingkat'];


		$Q6="$Q 
		WHERE ak_perkelas.tahunajaran='$PilTACR3' 
		and ak_perkelas.tk='$TKKls6' 
		AND ak_kelas.kode_kelas='$PilKKLSCR3' 
		AND ak_perkelas.nis='$PilNISCR'
		AND gmp_ngajar.thnajaran='$PilTACR3' 
		AND gmp_ngajar.semester='6'";
		$MassaKBM6="Tahun Ajaran $PilTACR3 Semester 6";
		$TAj6=$PilTACR3;
		$Smstr6='6';
		$Klsna6=$PilNKLSCR3;

		$no6=1;
		$Query6=mysql_query("$Q6 ORDER BY gmp_ngajar.kd_mapel");
		while($Hasil6=mysql_fetch_array($Query6)){
			$nmsiswa6=$Hasil6['nm_siswa'];

			//tampilkan nilai KETERAMPILAN ==========================================

			$JmlNKDP6=JmlDt("select * from gmp_kikd where kode_ranah='KDP' and kode_ngajar='{$Hasil6['kd_ngajar']}'");			
			$JmlNKDK6=JmlDt("select * from gmp_kikd where kode_ranah='KDK' and kode_ngajar='{$Hasil6['kd_ngajar']}'");


			$QKIKDP6=mysql_query("SELECT * FROM n_p_kikd where kd_ngajar='{$Hasil6['kd_ngajar']}' AND nis='$PilNISCR'");
			$HNKIKDP6=mysql_fetch_array($QKIKDP6);

			$QKIKDK6=mysql_query("SELECT * FROM n_k_kikd where kd_ngajar='{$Hasil6['kd_ngajar']}' AND nis='$PilNISCR'");
			$HNKIKDK6=mysql_fetch_array($QKIKDK6);

			$QKIKDUTSUAS6=mysql_query("SELECT * FROM n_utsuas WHERE kd_ngajar='{$Hasil6['kd_ngajar']}' AND nis='$PilNISCR'");
			$HKIKDUTSUAS6=mysql_fetch_array($QKIKDUTSUAS6);
			
			$NAP6=round(($HNKIKDP6['kikd_p']+$HKIKDUTSUAS6['uts']+$HKIKDUTSUAS6['uas'])/3,0);

			$NA6=round(((round(($HNKIKDP6['kikd_p']+$HKIKDUTSUAS6['uts']+$HKIKDUTSUAS6['uas'])/3,0)+$HNKIKDK6['kikd_k'])/2),0);

			if($NAP6<$Hasil6['kkmpeng']){$bgp6='#ff0000';$fcolp6='#ffffff';}else{$bgp6='';$fcolp6='';}
			if($HNKIKDK6['kikd_k']<$Hasil6['kkmpeng']){$bgk6='#ff0000';$fcolk6='#ffffff';}else{$bgk6='';$fcolk6='';}
			
			if($NAP6<$Hasil6['kkmpeng'] || $HNKIKDK6['kikd_k']<$Hasil6['kkmket']){
				$tmbcetak6="<a href='?page=$page&sub=nyetakperbaikan&kbm={$Hasil6['kd_ngajar']}&nis={$Hasil6['nis']}&thnajar=$TAj6&semester=$Smstr6&kls=$Klsna6' class='btn btn-warning btn-block'><i class='fa fa-print'></i> Cetak </a>";
				$tmbp6="
				<div class='dropdown'>
					<a id='dLabel' role='button' data-toggle='dropdown' class='btn btn-warning btn-block' data-target='#' href='javascript:void(0);'> Perbaikan <span class='caret'></span> </a>
					<ul class='dropdown-menu multi-level' role='menu'>
						<li><a href='javascript:void(0);'>{$Hasil6['nama_mapel']}</a></li>
						<li class='divider'></li>
						<li><a href='?page=$page&sub=perbaikan&tnil=k3&kbm={$Hasil6['kd_ngajar']}&nis=$PilNISCR'><i class='fa fa-edit'></i> K3</a></li>
						<li><a href='?page=$page&sub=perbaikan&tnil=utsuas&kbm={$Hasil6['kd_ngajar']}&nis=$PilNISCR'><i class='fa fa-edit'></i> UTS UAS</a></li>
						<li><a href='?page=$page&sub=perbaikan&tnil=k4&kbm={$Hasil6['kd_ngajar']}&nis=$PilNISCR'><i class='fa fa-edit'></i> K4</a></li>
					</ul>
				</div>";
			}
			else{
				$tmbcetak6="<a href='?page=$page&sub=nyetakperbaikan&kbm={$Hasil6['kd_ngajar']}&nis={$Hasil6['nis']}&thnajar=$TAj6&semester=$Smstr6&kls=$Klsna6' class='btn btn-default btn-block'><i class='fa fa-print'></i> Cetak </a>";
				$tmbp6="
				<div class='dropdown'>
					<a id='dLabel' role='button' data-toggle='dropdown' class='btn btn-default btn-block' data-target='#' href='javascript:void(0);'> Perbaikan <span class='caret'></span> </a>
					<ul class='dropdown-menu multi-level' role='menu'>
						<li><a href='javascript:void(0);'>{$Hasil6['nama_mapel']}</a></li>
						<li class='divider'></li>
						<li><a href='?page=$page&sub=perbaikan&tnil=k3&kbm={$Hasil6['kd_ngajar']}&nis=$PilNISCR'><i class='fa fa-edit'></i> K3</a></li>
						<li><a href='?page=$page&sub=perbaikan&tnil=utsuas&kbm={$Hasil6['kd_ngajar']}&nis=$PilNISCR'><i class='fa fa-edit'></i> UTS UAS</a></li>
						<li><a href='?page=$page&sub=perbaikan&tnil=k4&kbm={$Hasil6['kd_ngajar']}&nis=$PilNISCR'><i class='fa fa-edit'></i> K4</a></li>
					</ul>
				</div>";
				}
			$TampilData6.="
			<tr>
				<td>$no6.</td>
				<td>{$Hasil6['id_guru']} {$Hasil6['nama_lengkap']}<br><span class='text-danger'>{$Hasil6['nama_mapel']}</span></td>
				<td>{$Hasil6['kkmpeng']} -  {$Hasil6['kkmket']}</td>
				<td>$JmlNKDP6 -  $JmlNKDK6</td>
				<td>$tmbp6</td>
				<td bgcolor='$bgp6'><font size='' color='$fcolp6'>$NAP6</font></td>
				<td bgcolor='$bgk6'><font size='' color='$fcolk6'>{$HNKIKDK6['kikd_k']}</font></td>
				<td>$NA6</td>
				<td>$tmbcetak6</td>
			</tr>";
			$no6++;
		}
	
		$jmldata6=mysql_num_rows($Query6);
		if($jmldata6>0){
			$Show.="<hr>";
			$Show.="<p class='text-danger' style='margin-top:-10px;'>$MassaKBM6</p>";
			$Show.="
			<div class='well no-padding'>
				<table id='dt_basic' class='table table-striped table-bordered table-hover table-condensed' width='100%'>
					<thead>
						<tr>
							<th class='text-center' data-class='expand'>No.</th>
							<th class='text-center'>Nama Guru / Mapel</th>
							<th class='text-center' data-hide='phone'>KKM</th>
							<th class='text-center' data-hide='phone'>KIKD</th>
							<th class='text-center' data-hide='phone'>Perbaikan</th>
							<th class='text-center' data-hide='phone'>NA K3</th>
							<th class='text-center' data-hide='phone'>NA K4</th>
							<th class='text-center' data-hide='phone'>NA</th>
							<th class='text-center' data-hide='phone' width='25'>Cetak</th>
						</tr>
					</thead>
					<tbody>$TampilData6</tbody>
				</table>
			</div>";
		}
		else{
			$Show.="<hr>";
			$Show.="<p class='text-danger' style='margin-top:-10px;'>$MassaKBM6</p>";
			$Show.='			
			<div class="well"><p class="text-center"><img src="img/firda.png" width="200" height="220" border="0" alt=""></p><h1 class="text-center"><small class="text-danger slideInRight fast animated"><strong>Nilai <br>'.$MassaKBM6.' <br>belum tersedia!</strong></small></h1></div>';
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

		
		$TmblCetak.= "<a href='javascript:void(0);' class='btn btn-default btn-xs pull-right' style='margin-top:6px;' onclick=\"printContent('cetak')\"> <i class='fa fa-print'></i> <span class='hidden-xs'>Cetak</span></a>";

		
		$KDPna=JmlDt("select kode_ngajar,kode_ranah from gmp_kikd where kode_ngajar='$kbm' and kode_ranah='KDP'");
		$KDKna=JmlDt("select kode_ngajar,kode_ranah from gmp_kikd where kode_ngajar='$kbm' and kode_ranah='KDK'");

		$kkmna=mysql_query("SELECT kkmpeng,kkmket from gmp_ngajar WHERE id_ngajar='$kbm'");
		$HKKM=mysql_fetch_array($kkmna);
		$KKMP=$HKKM['kkmpeng'];
		$KKMK=$HKKM['kkmket'];

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
		<strong>Nilai Pengetahuan <br>KKM = $KKMP</strong><br><br>
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


		$QNK=mysql_query("SELECT * from n_k_kikd WHERE kd_ngajar='$kbm' AND nis='$nis'");
		$HasilK=mysql_fetch_array($QNK);

		for($x=1;$x<$KDKna+1;$x++){

			if($HasilK['kd_'.$x]<$KKMK){$fcolp='#ff0000';}else{$fcolp='';}

			$TNK.="
				<tr height='30'>
					<td align='center'>$x</td>
					<td align='center'><strong><font size='' color='$fcolp'>".$HasilK['kd_'.$x]."</font></strong></td>
					<td align='center'>&nbsp;</td>
				</tr>			
			";
		}

		$NilaiKet.="
		<strong>Nilai Keterampilan <br>KKM = $KKMK</strong><br><br>
		<table style='margin: 0 auto;width:100%;border-collapse:collapse;font:12px Times New Roman;' border='1'>
			<thead>
				<tr>
					<th width='20'>No. KIKD</th>
					<th width='55'>Nilai</th>
					<th width='55'>Perbaikan</th>
				</tr>
			</thead>
			<tbody>
				$TNK
				<tr height='30'>
					<td align='center'>NA</td>
					<td align='center'>".$HasilK['kikd_k']."</td>
					<td align='center'>&nbsp;</td>
				</tr>
			</tbody>
		</table>";

		$Nyetak.="
		<table style='margin: 0 auto;width:100%;border-collapse:collapse;font:12px Times New Roman;'>
		<tr>
			<td>$NilaiPeng</td>
			<td width='50'>&nbsp;</td>
			<td valign=top>$NilaiUTSUAS 
			<br><br><br><br>
			Tanggal Perbaikan :</td>
			<td width='50'>&nbsp;</td>
			<td>$NilaiKet</td>
		</tr>
		</table>";
		
		

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
		echo MyWidget('fa-print',"Cetak Ajuan Remedial",array(ButtonKembali("?page=$page&sub=cekremedial"),$TmblCetak),$Nyetak);
	break;

	case "perbaikan":
		$tnil=isset($_GET['tnil'])?$_GET['tnil']:""; 
		$kbm=isset($_GET['kbm'])?$_GET['kbm']:""; 
		$nis=isset($_GET['nis'])?$_GET['nis']:"";

		$QSiswa=mysql_query("select nm_siswa,nis from siswa_biodata where nis='$nis'");
		$HSiswa=mysql_fetch_array($QSiswa);

		$kkmna=mysql_query("SELECT kkmpeng,kkmket from gmp_ngajar WHERE id_ngajar='$kbm'");
		$HKKM=mysql_fetch_array($kkmna);

		//identifikasi nilai
		if($tnil=="k3"){
			$jmlKD=JmlDt("select * from gmp_kikd where kode_ngajar='$kbm' and kode_ranah='KDP'");
			$QN=mysql_query("SELECT * from n_p_kikd WHERE kd_ngajar='$kbm' AND nis='$nis'");
			$Hasil=mysql_fetch_array($QN);
			$iddb=$Hasil['kd_p_kikd'];
			$KKMnya=$HKKM['kkmpeng'];
			$Textnya="Pengetahuan (K3)";
			$FormNyimpan="<form action='?page=$page&sub=simpanedit&jnil=k3' method='post' name='FrmPerbaikan' id='FrmPerbaikan' role='form'>";
		}
		else if($tnil=="utsuas"){
			$jmlKD=JmlDt("select * from gmp_kikd where kode_ngajar='$kbm' and kode_ranah='KDP'");
			$QN=mysql_query("SELECT * from n_utsuas WHERE kd_ngajar='$kbm' AND nis='$nis'");
			$Hasil=mysql_fetch_array($QN);
			$iddb=$Hasil['kd_utsuas'];
			$KKMnya=$HKKM['kkmpeng'];
			$Textnya="UTS UAS";
			$FormNyimpan="<form action='?page=$page&sub=simpanedit&jnil=utsuas' method='post' name='FrmPerbaikan' id='FrmPerbaikan' role='form'>";
		}
		else if($tnil=="k4"){
			$jmlKD=JmlDt("select * from gmp_kikd where kode_ngajar='$kbm' and kode_ranah='KDK'");
			$QN=mysql_query("SELECT * from n_k_kikd WHERE kd_ngajar='$kbm' AND nis='$nis'");
			$Hasil=mysql_fetch_array($QN);
			$iddb=$Hasil['kd_k_kikd'];
			$KKMnya=$HKKM['kkmket'];
			$Textnya="Keterampilan (K4)";
			$FormNyimpan="<form action='?page=$page&sub=simpanedit&jnil=k4' method='post' name='FrmPerbaikan' id='FrmPerbaikan' role='form'>";
		}

		if($tnil=="k3" || $tnil=="k4"){
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
				<li><a href='?page=$page&sub=$sub&tnil=k3&kbm=$kbm&nis=$nis'>Pengetahuan</a>
				<li><a href='?page=$page&sub=$sub&tnil=utsuas&kbm=$kbm&nis=$nis'>UTS UAS</a>
				<li><a href='?page=$page&sub=$sub&tnil=k4&kbm=$kbm&nis=$nis'>Keterampilan</a>
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
		echo MyWidget('fa-edit',"Edit Nilai $Textnya",array(ButtonKembali("?page=$page&sub=cekremedial"),$PilihNilai),$Show);
	break;

	case "simpanedit":
		$jnil=isset($_GET['jnil'])?$_GET['jnil']:""; 
	
		if($jnil=="k3"){ 
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
			echo ns("Ngedit","parent.location='?page=$page&sub=cekremedial&sub=perbaikan&tnil=k3&kbm=$txtKBM&nis=$txtNIS'","Nilai Pengetahuan dengan Kode KBM <strong class='text-primary'>$txtKBM </strong>");
		}
		else if($jnil=="k4"){ 
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
			mysql_query("UPDATE n_k_kikd SET kd_ngajar='$txtKBM',nis='$txtNIS',kd_1='$txtKD_1',kd_2='$txtKD_2',kd_3='$txtKD_3',kd_4='$txtKD_4',kd_5='$txtKD_5',kd_6='$txtKD_6',kd_7='$txtKD_7',kd_8='$txtKD_8',kd_9='$txtKD_9',kd_10='$txtKD_10',kd_11='$txtKD_11',kd_12='$txtKD_12',kd_13='$txtKD_13',kd_14='$txtKD_14',kd_15='$txtKD_15',kikd_k='$NHP' WHERE kd_k_kikd='$txtIDDB'");
			echo ns("Ngedit","parent.location='?page=$page&sub=cekremedial&sub=perbaikan&tnil=k4&kbm=$txtKBM&nis=$txtNIS'","Nilai Keterampilan dengan Kode KBM <strong class='text-primary'>$txtKBM </strong>");
		}
		else {

			$txtIDDB=$_POST['txtIDDB'];
			$txtKBM=$_POST['txtKBM'];
			$txtNIS=$_POST['txtNIS'];
			$txtuts=$_POST['txtuts'];
			$txtuas=$_POST['txtuas'];

			mysql_query("UPDATE n_utsuas SET kd_ngajar='$txtKBM',nis='$txtNIS',uts='$txtuts',uas='$txtuas' WHERE kd_utsuas='$txtIDDB'");
			echo ns("Ngedit","parent.location='?page=$page&sub=cekremedial&sub=perbaikan&tnil=utsuas&kbm=$txtKBM&nis=$txtNIS'","Nilai UTS dan UAS dengan Kode KBM <strong class='text-primary'>$txtKBM </strong>");			

		}
	break;

	case "updatethnmasuk":
		$taunmasuk=isset($_GET['taunmasuk'])?$_GET['taunmasuk']:"";
		$TAKelasHiji=$taunmasuk."-".($taunmasuk+1);
		$TAKelasDua=($taunmasuk+1)."-".($taunmasuk+2);
		$TAKelasTilu=($taunmasuk+2)."-".($taunmasuk+3);
		$JmlData=JmlDt("select * from app_pilih_cekremedial where id_pil='$IDna'");

		if($JmlData==0){
			mysql_query("insert into app_pilih_cekremedial values ('$IDna','$taunmasuk','','$TAKelasHiji','','','','$TAKelasDua','','','','$TAKelasTilu','','','','')");
		}else {
			mysql_query("
			update app_pilih_cekremedial set 
			thnmasuk='$taunmasuk',
			kode_pk='',
			thn_tk1='$TAKelasHiji',
			kelas_tk1='',
			nm_kls_tk1='',
			kd_kls_tk1='',
			thn_tk2='$TAKelasDua',
			kelas_tk2='',
			nm_kls_tk2='',
			kd_kls_tk2='',
			thn_tk3='$TAKelasTilu',
			kelas_tk3='',
			nm_kls_tk3='',
			kd_kls_tk3='' 
			where id_pil='$IDna'");
		}
		echo ns("Milih","parent.location='?page=$page'","tahun masuk $taunmasuk");
	break;

	case "updatepk":
		$paket=isset($_GET['paket'])?$_GET['paket']:"";
		NgambilData("select * from ak_paketkeahlian where kode_pk='$paket'");
		mysql_query("update app_pilih_cekremedial set kode_pk='$paket' where id_pil='$IDna'");
		echo ns("Milih","parent.location='?page=$page'","paket keahlian $paket");
	break;

	case "updatekelasx":
		$klsx=isset($_GET['klsx'])?$_GET['klsx']:"";

		$QKls=mysql_query("select * from ak_kelas where id_kls='$klsx'");
		$HKls=mysql_fetch_array($QKls);
		$NmKelas=$HKls['nama_kelas'];
		$KdKelas=$HKls['kode_kelas'];


		mysql_query("update app_pilih_cekremedial set kelas_tk1='$klsx' where id_pil='$IDna'");
		mysql_query("update app_pilih_cekremedial set nm_kls_tk1='$NmKelas' where id_pil='$IDna'");
		mysql_query("update app_pilih_cekremedial set kd_kls_tk1='$KdKelas' where id_pil='$IDna'");
		echo ns("Milih","parent.location='?page=$page'","kelas $klsx");
	break;
	case "updatekelasxi":
		$klsxi=isset($_GET['klsxi'])?$_GET['klsxi']:"";
		$QKls=mysql_query("select * from ak_kelas where id_kls='$klsxi'");
		$HKls=mysql_fetch_array($QKls);
		$NmKelas=$HKls['nama_kelas'];
		$KdKelas=$HKls['kode_kelas'];

		mysql_query("update app_pilih_cekremedial set kelas_tk2='$klsxi' where id_pil='$IDna'");
		mysql_query("update app_pilih_cekremedial set nm_kls_tk2='$NmKelas' where id_pil='$IDna'");
		mysql_query("update app_pilih_cekremedial set kd_kls_tk2='$KdKelas' where id_pil='$IDna'");
		echo ns("Milih","parent.location='?page=$page'","kelas $klsxi");
	break;
	case "updatekelasxii":
		$klsxii=isset($_GET['klsxii'])?$_GET['klsxii']:"";
		$QKls=mysql_query("select * from ak_kelas where id_kls='$klsxii'");
		$HKls=mysql_fetch_array($QKls);
		$NmKelas=$HKls['nama_kelas'];
		$KdKelas=$HKls['kode_kelas'];

		mysql_query("update app_pilih_cekremedial set kelas_tk3='$klsxii' where id_pil='$IDna'");
		mysql_query("update app_pilih_cekremedial set nm_kls_tk3='$NmKelas' where id_pil='$IDna'");
		mysql_query("update app_pilih_cekremedial set kd_kls_tk3='$KdKelas' where id_pil='$IDna'");

		echo ns("Milih","parent.location='?page=$page'","kelas $klsxii");
	break;

	case "updatenis":
		$nis=isset($_GET['nis'])?$_GET['nis']:"";
		mysql_query("update app_pilih_cekremedial set nis='$nis' where id_pil='$IDna'");
		echo ns("Milih","parent.location='?page=$page'","siswa dengan $nis");
	break;

	case "updatenis2":
		$nis=isset($_GET['nis'])?$_GET['nis']:"";
		mysql_query("update app_pilih_cekremedial set nis='$nis' where id_pil='$IDna'");
		//echo '<div id="preloader"><div id="cssload"></div></div>';
		//echo ns("Milih","parent.location='?page=$page'","$nama_paket");
		if($PilTMasukCR=="2022"){
			echo "<meta http-equiv='refresh' content='0; url=?page=$page&sub=cekremedial2022'>";
		}else {
			echo "<meta http-equiv='refresh' content='0; url=?page=$page&sub=cekremedial'>";			
		}
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
