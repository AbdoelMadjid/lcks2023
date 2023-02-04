<?php
require_once("inc/init.php");
require_once("inc/config.ui.php");
$page_title = "Ekspor";
$page_css[] = "your_style.css";
include("inc/header.php");
$page_nav["tools"]["sub"]["ekspordata"]["active"] = true;
include("inc/nav.php");
echo "<div id='main' role='main'>";
$breadcrumbs["Tools"] = "";
include("inc/ribbon.php");	
$JenisData.=JudulKolom("Pilih Jenis Data","database");
$JenisData.='
<div class="row">
	<div class="text">
		<div class="col-sm-12 col-md-6 col-lg-4 padding-5">
			<div class="well text-center">
				<a href="?page=tools-ekspor-datamaster&sub=guru" class="btn btn-primary btn-circle btn-xl" title="Tenaga Pendidik"><i class="fa fa-user fa-3x"></i></a><br> Tenaga Pendidik
			</div>
		</div>
		<div class="col-sm-12 col-md-6 col-lg-4 padding-5">
			<div class="well text-center">
				<a href="?page=tools-ekspor-datamaster&sub=siswa" class="btn btn-primary btn-circle btn-xl" title="Biodata Siswa"><i class="fa fa-vcard-o fa-3x"></i></a><br> Biodata Siswa
			</div>
		</div>
		<div class="col-sm-12 col-md-6 col-lg-4 padding-5">
			<div class="well text-center">
				<a href="?page=tools-ekspor-datamaster&sub=walikelas" class="btn btn-primary btn-circle btn-xl" title="Username dan Password Wali Kelas"><i class="fa fa-user-o fa-3x"></i></a><br> Wali Kelas
			</div>
		</div>
		<div class="col-sm-12 col-md-6 col-lg-4 padding-5">
			<div class="well text-center">
				<a href="?page=tools-ekspor-datamaster&sub=mapel" class="btn btn-primary btn-circle btn-xl" title="Mata Pelajaran"><i class="fa fa-graduation-cap fa-3x"></i></a><br> Mata Pelajaran
			</div>
		</div>
		<div class="col-sm-12 col-md-6 col-lg-4 padding-5">
			<div class="well text-center">
				<a href="?page=tools-ekspor-datamaster&sub=kikd" class="btn btn-primary btn-circle btn-xl" title="Kumpulan KI KD"><i class="fa fa-language fa-3x"></i></a><br> KIKD
			</div>
		</div>
		<div class="col-sm-12 col-md-6 col-lg-4 padding-5">
			<div class="well text-center">
				<a href="?page=tools-ekspor-datamaster&sub=gurumapel" class="btn btn-primary btn-circle btn-xl" title="Guru Mata Pelajaran"><i class="fa fa-users fa-3x"></i></a><br> Data Mengajar
			</div>
		</div>
	</div>
</div>';

$sub=(isset($_GET['sub']))?$_GET['sub']:"";
switch($sub)
{
	case "tampil":default:
		$Show.=DuaKolomSama($JenisData,JudulKolom("Download Data Master","download").'<h1 class="text-center text-danger"><strong><i class="fa fa-exclamation-triangle fa-lg"></i></h1><h4 class="text-center text-info">Silakan pilih data master yang akan di download</strong></h4>');
		
		echo $DownloadDataMaster;
		$tandamodal="#DownloadDataMaster";
		echo MyWidget('fa-download',$page_title." Data Master",$Tombolna,$Show);
	break;

	case "guru":

		$Show.=nt("catatan","ada pilihan lebih spesifik ke guru sudah non aktif dan jenis guru");

		$QPTK=mysql_query("select * from app_user_guru order by nama_lengkap");
		$CPTK=mysql_num_rows($QPTK);
		if($CPTK==0){
			$DownloadDataPTK="<i class='fa fa-window-close-o txt-color-red font-xl'></i> <br>Data Kosong";}
		else{
			$TampilJumlah="<br>Total Data : ".$CPTK." tenaga pendidik";
			$DownloadDataPTK="<a href=\"javascript:;\" onClick=\"window.open('./pages/excel/ekspor-data-master.php?eksporex=userguru')\" class='btn btn-info  pull-right'>Download</a>";
		}
		$NoPTK=1;
		while($DPTK=mysql_fetch_array($QPTK)){
			if($DPTK['gelarbelakang']==""){$koma="";}else{$koma=",";}
			$TampilPTK.="
			<tr>
				<td>$NoPTK.</td>
				<td>{$DPTK['gelardepan']} {$DPTK['nama_lengkap']}$koma {$DPTK['gelarbelakang']}</td>
				<td>{$DPTK['jk']}</td>
				<td>{$DPTK['hak']}</td>
			</tr>";
			$NoPTK++;
		}
		$TabelPTK.=KolomPanel(JudulKolom("Daftar User Tanaga Pendidik","user")."
		<div class='widget-body no-padding'>
			<table id='dt_basic' class='table table-striped table-bordered table-condensed' width='100%'>
				<thead>
					<tr>
						<th data-class='expand'>No.</th>
						<th>Nama Lengkap</th>
						<th data-hide='phone'>JK</th>
						<th data-hide='phone'>Jabatan</th>
					</tr>
				</thead>
				<tbody>					
						$TampilPTK
				</tbody>
			</table>
		</div>");
		$ExData.=JudulKolom("Download User Tanaga Pendidik","download");
		$ExData.="Data Username dan Password Tenaga Pendidik $TampilJumlah<br>$DownloadDataPTK";
		$Show.=DuaKolomSama($JenisData,$ExData);
		$Show.=$TabelPTK;
		echo $DownloadDataMaster;
		$tandamodal="#DownloadDataMaster";
		echo MyWidget('fa-download',$page_title." Tenaga Pendidik",$Tombolna,$Show);
	break;

	case "siswa":
		$NyariData.=JudulKolom("Download Peserta Didik","download");
		$NyariData.="
		<form action='?page=$page' method='post' name='FrmNyari' class='form-horizontal' role='form'>";
		$NyariData.=FormCF("horizontal","Tahun Masuk","txtTM","select * from siswa_biodata where tahunmasuk group by tahunmasuk","tahunmasuk",$_GET['tamasuk'],"tahunmasuk","4","onchange=\"document.location.href='?page=$page&sub=siswa&tamasuk='+document.FrmNyari.txtTM.value\"");
		$NyariData.=FormCF("horizontal","Paket Keahlian","txtKdPK","SELECT ak_perkelas.kode_pk,siswa_biodata.kode_paket,ak_paketkeahlian.nama_paket FROM ak_perkelas INNER JOIN siswa_biodata ON ak_perkelas.nis=siswa_biodata.nis INNER JOIN ak_paketkeahlian ON ak_perkelas.kode_pk=ak_paketkeahlian.kode_pk where siswa_biodata.tahunmasuk='".$_GET['tamasuk']."' GROUP BY ak_perkelas.kode_pk","kode_pk",$_GET['kd_pk'],"nama_paket","4","onchange=\"document.location.href='?page=$page&sub=siswa&tamasuk='+document.FrmNyari.txtTM.value+'&kd_pk='+document.FrmNyari.txtKdPK.value\"");
		$NyariData.="</form>";
		
		$tamasuk=isset($_GET['tamasuk'])?$_GET['tamasuk']:"";
		$kd_pk=isset($_GET['kd_pk'])?$_GET['kd_pk']:"";
		if($tamasuk==""){
			$DownloadDataSW="<span class='text-danger pull-right'><i class='fa fa-check-square-o text-danger'></i> Pilih Tahun Masuk</span>";
		}
		else
		if($kd_pk==""){
			$DownloadDataSW="<span class='text-danger pull-right'><i class='fa fa-check-square-o text-danger'></i> Pilih Paket Keahlian</span>";
		}
		else
		{
			$QSW=mysql_query("select siswa_biodata.nis,siswa_biodata.nisn,siswa_biodata.nm_siswa,siswa_biodata.tahunmasuk,siswa_biodata.kode_paket,siswa_biodata.jenis_kelamin,siswa_biodata.sekolah_asal,siswa_biodata.tempat_lahir,siswa_biodata.tanggal_lahir,ak_paketkeahlian.nama_paket from siswa_biodata, ak_paketkeahlian where siswa_biodata.kode_paket=ak_paketkeahlian.kode_pk and siswa_biodata.tahunmasuk='$tamasuk' and siswa_biodata.kode_paket='$kd_pk'");
			$CSW=mysql_num_rows($QSW);
			if($CSW==0){
				$DownloadDataSW="<span class='text-danger pull-right'><i class='fa fa-exclamation-triangle text-danger'></i> Data Kosong</span>";}
			else{
				$TampilJumlah="Total Data : ".$CSW." Siswa";
				$DownloadDataSW="<a href=\"javascript:;\" onClick=\"window.open('./pages/excel/ekspor-data-master.php?eksporex=siswabiodata&tamasuk=$tamasuk&kd_pk=$kd_pk')\" class='btn btn-info  pull-right'>Download</a>";}
		}
		$NoSW=1;
		while($DSW=mysql_fetch_array($QSW)){
			$PK="{$DSW['nama_paket']}";
			$TampilSW.="
			<tr>
				<td>$NoSW.</td>
				<td>{$DSW['nis']}</td>
				<td>{$DSW['nisn']}</td>
				<td>{$DSW['nm_siswa']}</td>
				<td>{$DSW['jenis_kelamin']}</td>
				<td>{$DSW['tempat_lahir']},".TglLengkap($DSW['tanggal_lahir'])."</td>
				<td>{$DSW['sekolah_asal']}</td>
			</tr>
			";
			$NoSW++;
		}
		if($CSW==0){}else{
			$TabelSW.=KolomPanel(JudulKolom("Data Siswa","user-circle")."
			<p class='info' style='margin-top:-15px;margin-bottom:25px;'><span class='label bg-color-darken txt-color-white'>Info !</span> <span class='hidden-lg'><br></span><code>Paket Keahlian <strong>$PK</strong> Tahun Masuk <strong>$tamasuk</strong></code></p>
			<div class='widget-body no-padding'>
				<table id='dt_basic' class='table table-striped table-bordered table-condensed' width='100%'>
					<thead>
						<tr>
							<th data-class='expand'>No.</th>
							<th data-hide='phone'>NIS</th>
							<th data-hide='phone'>NISN</th>
							<th>Nama Lengkap</th>
							<th data-hide='phone'>Jenis Kelamin</th>
							<th data-hide='phone'>Tempat Tgl Lahir</th>
							<th data-hide='phone'>Sekolah Asal</th>
						</tr>
					</thead>
					<tbody>
						$TampilSW
					</tbody>
				</table>
			</div>");
		}
		$ExData.=DuaKolomD(8,$TampilJumlah,4,$DownloadDataSW);
		$Show.=DuaKolomSama($JenisData,$NyariData.'<hr>'.$ExData);
		$Show.=$TabelSW;
		echo $DownloadDataMaster;
		$tandamodal="#DownloadDataMaster";
		echo MyWidget('fa-download',$page_title." Biodata Siswa",$Tombolna,$Show);
	break;

	case "walikelas":
		$NyariData.=JudulKolom("Download Wali Kelas","download");
		$NyariData.="
		<form action='?page=$page' method='post' name='frmaing' class='form-horizontal' role='form'>";
		$NyariData.=FormCF("horizontal","Tahun Pelajaran","txtThnAjar","select * from ak_tahunajaran order by id_thnajar asc","tahunajaran",$_GET['thnajaran'],"tahunajaran","4","onchange=\"document.location.href='?page=tools-ekspor-datamaster&sub=walikelas&thnajaran='+document.frmaing.txtThnAjar.value\"");
		$NyariData.="</form><hr>";
		$thnajaran=isset($_GET['thnajaran'])?$_GET['thnajaran']:""; 
		if($thnajaran==""){
			$DownloadDataWK="<span class='text-danger pull-right'><i class='fa fa-check-square-o text-danger'></i> Pilih Tahun Ajaran</span>";
		}
		else if($thnajaran=="Semua"){
			$QWK=mysql_query("select * from app_user_walikelas");
			$CWK=mysql_num_rows($QWK);
			if($CWK==0){
				$DownloadDataWK="<span class='text-danger pull-right'><i class='fa fa-exclamation-triangle text-danger'></i> Data Kosong</span>";
			}
			else{
				$TampilJumlah="Total Semua : <strong>".$CWK."</strong> walikelas";
				$DownloadDataWK="<a href=\"javascript:;\" onClick=\"window.open('./pages/excel/ekspor-user-walikelas.php?thnajaran=Semua')\" class='btn btn-info  pull-right'>Download</a>";
			}
		}
		else {
			$QWK=mysql_query("select * from app_user_walikelas where tahunajaran='$thnajaran'");
			$CWK=mysql_num_rows($QWK);
			if($CWK==0){
				$DownloadDataWK="<span class='text-danger pull-right'><i class='fa fa-exclamation-triangle text-danger'></i> Data Kosong</span>";}
			else{
				$TampilJumlah="Total Data : <strong>".$CWK."</strong> wali kelas";
				$DownloadDataWK="<a href=\"javascript:;\" onClick=\"window.open('./pages/excel/ekspor-data-master.php?eksporex=userwalikelas&thnajaran=$thnajaran')\" class='btn btn-info  pull-right'>Download</a>";
			}
		}
		$NoWK=1;
		while($DWK=mysql_fetch_array($QWK)){
			$TampilWK.="
			<tr>
				<td>$NoWK.</td>
				<td>{$DWK['kode_kelas']}</td>
				<td>{$DWK['nama_wk']}</td>
				<td>{$DWK['userid']}</td>
				<td>{$DWK['kuncina']}</td>
			</tr>
			";
			$NoWK++;
		}
		if($CWK==0){}else{
			$TabelWK.=KolomPanel(JudulKolom("Wali Kelas $thnajaran","user-circle")."
			<div class='widget-body no-padding'>
				<table id='dt_basic' class='table table-striped table-bordered table-condensed' width='100%'>
					<thead>
						<tr>
							<th data-class='expand'>No.</th>
							<th>Kode Kelas</th>
							<th data-hide='phone'>Nama Wali Kelas</th>
							<th data-hide='phone'>User ID</th>
							<th data-hide='phone'>Password</th>
						</tr>
					</thead>
					<tbody>
						$TampilWK
					</tbody>
				</table>
			</div>");
		}
		$ExData.=DuaKolomD(8,$TampilJumlah,4,$DownloadDataWK);
		$Show.=DuaKolomSama($JenisData,$NyariData.$ExData);
		$Show.=$TabelWK;
		echo $DownloadDataMaster;
		$tandamodal="#DownloadDataMaster";
		echo MyWidget('fa-download',$page_title." <i class='ultra-light'>Wali Kelas</i>",$Tombolna,$Show);
	break;

	case "mapel":
		
		$NyariData.=JudulKolom("Download Mata Pelajaran","download");
		$NyariData.="
		<form action='?page=$page&sub=mapel' method='post' name='FrmNyari' class='form-horizontal' role='form'><fieldset>";
		$NyariData.=FormCF("horizontal","Tahun Pelajaran","txtThnAjar","select * from ak_tahunajaran order by id_thnajar asc","tahunajaran",$_GET['thnajaran'],"tahunajaran","4","onchange=\"document.location.href='?page=tools-ekspor-datamaster&sub=mapel&thnajaran='+document.FrmNyari.txtThnAjar.value\"");
		$NyariData.=FormCF("horizontal","Paket Keahlian","txtKodePk","SELECT ak_kelas.tahunajaran,ak_kelas.kode_pk,ak_paketkeahlian.nama_paket FROM ak_kelas inner join ak_paketkeahlian ON ak_kelas.kode_pk=ak_paketkeahlian.kode_pk where ak_kelas.tahunajaran='".$_GET['thnajaran']."' GROUP BY tahunajaran,kode_pk","kode_pk",$_GET['kd_pk'],"nama_paket","4","onchange=\"document.location.href='?page=tools-ekspor-datamaster&sub=mapel&thnajaran='+document.FrmNyari.txtThnAjar.value+'&kd_pk='+document.FrmNyari.txtKodePk.value\"");
		$NyariData.="</fieldset></form>";

		$kd_pk=isset($_GET['kd_pk'])?$_GET['kd_pk']:""; 
		if($kd_pk==""){
			$QS=mysql_query("select * from ak_matapelajaran");
			$CS=mysql_num_rows($QS);
			if($CS==0){
				$DownloadDataMP="<span class='text-danger pull-right'><i class='fa fa-exclamation-triangle text-danger'></i> Data Kosong</span>";
			}
			else{
				$TampilJumlah="Total Data : ".$CS." mata pelajaran<hr><h5 class='txt-color-red'><strong>Seluruh Mata Pelajaran</strong></h5>";
				$DownloadDataMP="<a href=\"javascript:;\" onClick=\"window.open('./pages/excel/ekspor-data-master.php?eksporex=datamapel&kd_pk=Semua')\" class='btn btn-info  pull-right'>Download</a>";
			}
		}
		else {
			$QS=mysql_query("select * from ak_matapelajaran,ak_paketkeahlian where ak_matapelajaran.kode_pk=ak_paketkeahlian.kode_pk and ak_matapelajaran.kode_pk='$kd_pk'");
			$DataMP=mysql_fetch_array($QS);
			$CS=mysql_num_rows($QS);
			if($CS==0){
				$DownloadDataMP="<span class='text-danger pull-right'><i class='fa fa-exclamation-triangle text-danger'></i> Data Kosong</span>";
			}
			else{
				$TampilJumlah="Total Data : ".$CS." mata pelajaran";
				$DownloadDataMP="<a href=\"javascript:;\" onClick=\"window.open('./pages/excel/ekspor-data-master.php?eksporex=datamapel&kd_pk=$kd_pk')\" class='btn btn-info  pull-right'>Download</a>";
			}
		}
		$NoMP=1;
		while($DMP=mysql_fetch_array($QS)){
			if($DMP['semester1']==1){$Semester1="<i class='fa fa-check fa-border'></i>";}else{$Semester1="<i class='fa fa-window-close fa-border txt-color-red'></i>";};
			if($DMP['semester2']==1){$Semester2="<i class='fa fa-check fa-border'></i>";}else{$Semester2="<i class='fa fa-window-close fa-border txt-color-red'></i>";};
			if($DMP['semester3']==1){$Semester3="<i class='fa fa-check fa-border'></i>";}else{$Semester3="<i class='fa fa-window-close fa-border txt-color-red'></i>";};
			if($DMP['semester4']==1){$Semester4="<i class='fa fa-check fa-border'></i>";}else{$Semester4="<i class='fa fa-window-close fa-border txt-color-red'></i>";};
			if($DMP['semester5']==1){$Semester5="<i class='fa fa-check fa-border'></i>";}else{$Semester5="<i class='fa fa-window-close fa-border txt-color-red'></i>";};
			if($DMP['semester6']==1){$Semester6="<i class='fa fa-check fa-border'></i>";}else{$Semester6="<i class='fa fa-window-close fa-border txt-color-red'></i>";};
			$TampilkanMP.="
			<tr>
				<td>$NoMP.</td>
				<td>{$DMP['kode_mapel']}</td>
				<td>{$DMP['kelmapel']}</td>
				<td>{$DMP['nama_mapel']}</td>
				<td>{$DMP['jenismapel']}</td>
				<td>$Semester1</td>
				<td>$Semester2</td>
				<td>$Semester3</td>
				<td>$Semester4</td>
				<td>$Semester5</td>
				<td>$Semester6</td>
			</tr>
			";
			$NoMP++;
		}
		if($CS==0){}else{
			$TabelnaMP.=KolomPanel(JudulKolom("Mata Pelajaran","folder")."
			<p class='info' style='margin-top:-15px;margin-bottom:25px;'><span class='label bg-color-darken txt-color-white'>Info !</span> <span class='hidden-lg'><br></span><code>Paket Keahlian <strong>{$DataMP['nama_paket']}</strong></code></p>
			<div class='widget-body no-padding'>
				<table id='dt_basic' class='table table-striped table-bordered table-condensed' width='100%'>
					<thead>
						<tr>
							<th data-class='expand'>No.</th>
							<th data-hide='phone'>Kode</th>
							<th data-hide='phone'>Kelompok</th>
							<th>Nama Mapel</th>
							<th data-hide='phone'>Jenis Mapel</th>
							<th data-hide='phone'>1</th>
							<th data-hide='phone'>2</th>
							<th data-hide='phone'>3</th>
							<th data-hide='phone'>4</th>
							<th data-hide='phone'>5</th>
							<th data-hide='phone'>6</th>
						</tr>
					</thead>
					<tbody>
						$TampilkanMP
					</tbody>
				</table>
			</div>");
		}
		$ExData.=DuaKolomD(8,$TampilJumlah,4,$DownloadDataMP);
		$Show.=DuaKolomSama($JenisData,$NyariData.'<hr>'.$ExData);
		$Show.=$TabelnaMP;
		echo $DownloadDataMaster;
		$tandamodal="#DownloadDataMaster";
		echo MyWidget('fa-download',$page_title." Mata Pelajaran",$Tombolna,$Show);
	break;

	case "kikd":
		$NyariData.=JudulKolom("Download KIKD","download");
		$NyariData.="
		<form action='?page=$page&sub=kikd' method='post' name='frmaing' class='form-horizontal' role='form'>
		<fieldset>";
		$NyariData.=FormCF("horizontal","Jenis Mata Pelajaran","txtJenisMapel","select * from ak_matapelajaran group by jenismapel","jenismapel",$_GET['jenismapel'],"jenismapel","4","onchange=\"document.location.href='?page=tools-ekspor-datamaster&sub=kikd&jenismapel='+document.frmaing.txtJenisMapel.value+'&mapel='+document.frmaing.txtKelompok.value+'&tingkat='+document.frmaing.txtTingkat.value\"");
		$NyariData.=FormCF("horizontal","Mata Pelajaran","txtKelompok","select * from ak_kikd where jenismapel='".$_GET['jenismapel']."' group by nama_mapel","kelompok",$_GET['mapel'],"nama_mapel","4","onchange=\"document.location.href='?page=tools-ekspor-datamaster&sub=kikd&jenismapel='+document.frmaing.txtJenisMapel.value+'&mapel='+document.frmaing.txtKelompok.value+'&tingkat='+document.frmaing.txtTingkat.value\"");
		$NyariData.=FormCF("horizontal","Tingkat","txtTingkat","select * from ak_kikd where kelompok='".$_GET['mapel']."' group by tingkat","tingkat",$_GET['tingkat'],"tingkat","4","onchange=\"document.location.href='?page=tools-ekspor-datamaster&sub=kikd&jenismapel='+document.frmaing.txtJenisMapel.value+'&mapel='+document.frmaing.txtKelompok.value+'&tingkat='+document.frmaing.txtTingkat.value\"");
		$NyariData.="</fieldset></form>";

		$jenismapel=(isset($_GET['jenismapel']))?$_GET['jenismapel']:"";
		$mapel=(isset($_GET['mapel']))?$_GET['mapel']:"";
		$tingkat=(isset($_GET['tingkat']))?$_GET['tingkat']:"";
		if($jenismapel==""){
			$DownloadDataKIKD="<span class='text-danger pull-right'><i class='fa fa-check-square-o text-danger'></i> Pilih Jenis Mapel</span>";
		}
		else
		if($mapel==""){
			$DownloadDataKIKD="<span class='text-danger pull-right'><i class='fa fa-check-square-o text-danger'></i> Pilih Mata Pelajaran</span>";
		}
		else
		if($tingkat==""){
			$DownloadDataKIKD="<span class='text-danger pull-right'><i class='fa fa-check-square-o text-danger'></i> Pilih Tingkat</span>";
		}
		else
		{
			$QKIKD=mysql_query("select * from ak_kikd where jenismapel='".$_GET['jenismapel']."' and kelompok='".$_GET['mapel']."' and tingkat='".$_GET['tingkat']."'");
			$CKIKD=mysql_num_rows($QKIKD);
			if($CKIKD==0){
				$DownloadDataKIKD="<span class='text-danger pull-right'><i class='fa fa-exclamation-triangle text-danger'></i> Data Kosong</span>";}
			else{
				$TampilJumlah="Total Data : ".$CKIKD." KIKD";
				$DownloadDataKIKD="<a href=\"javascript:;\" onClick=\"window.open('./pages/excel/ekspor-data-master.php?eksporex=datakikd&jenismapel=$jenismapel&mapel=$mapel&tingkat=$tingkat')\" class='btn btn-info  pull-right'>Download</a>";}
		}
		$NoKIKD=1;
		while($DKIKD=mysql_fetch_array($QKIKD)){
			$NMMapel="{$DKIKD['nama_mapel']}";
			$TampilKIKD.="
			<tr>
				<td>$NoKIKD.</td>
				<td>{$DKIKD['kode_ranah']}</td>
				<td>{$DKIKD['no_kikd']}</td>
				<td>{$DKIKD['isikikd']}</td>
			</tr>
			";
			$NoKIKD++;
		}
		if($CKIKD==0){}else{
			$TabelKIKD.=KolomPanel(JudulKolom("KIKD","book")."
			<p class='info' style='margin-top:-15px;margin-bottom:25px;'><span class='label bg-color-darken txt-color-white'>Info !</span> <span class='hidden-lg'><br></span><code>Mata Pelajaran <strong>$NMMapel ($mapel)</strong> tingkat <strong>$tingkat</strong> </code></p>			
			<div class='widget-body no-padding'>
				<table id='dt_basic' class='table table-striped table-bordered table-condensed' width='100%'>
					<thead>
						<tr>
							<th width='10%' data-class='expand'>No.</th>
							<th width='10%'>Kode Ranah</th>
							<th width='10%'>No KIKD</th>
							<th data-hide='phone'>Isi KIKD</th>
						</tr>
					</thead>
					<tbody>
						$TampilKIKD
					</tbody>
				</table>
			</div>");
		}

		$ExData.=DuaKolomD(8,$TampilJumlah,4,$DownloadDataKIKD);
		$Show.=DuaKolomSama($JenisData,$NyariData.'<hr>'.$ExData);
		$Show.=$TabelKIKD;
		echo $DownloadDataMaster;
		$tandamodal="#DownloadDataMaster";
		echo MyWidget('fa-download',$page_title." KI KD",$Tombolna,$Show);
	break;

	case "gurumapel":

		$Show.=nt("catatan","tambahan jika sudah memilih semester, muncul data pengajar di tahun yang dipilih dan di semester yang di pilih. dan juga tampilkan semua data pengajar sesuai dengan pilihan tingkat");

		$thnajaran=(isset($_GET['thnajaran']))?$_GET['thnajaran']:"";
		$gg=isset($_GET['gg'])?$_GET['gg']:""; 
		$tingkat=isset($_GET['tingkat'])?$_GET['tingkat']:""; 
		$id_kls=isset($_GET['id_kls'])?$_GET['id_kls']:""; 

		$NyariData.=JudulKolom("Download Guru Pengajar","download");	
		$NyariData.="
		<form action='?page=$page' method='post' name='frmaing' class='form-horizontal' role='form'>
		";
		$NyariData.=FormCF("horizontal","Tahun Pelajaran","txtThnAjar","select * from ak_tahunajaran order by id_thnajar asc","tahunajaran",$_GET['thnajaran'],"tahunajaran","4","onchange=\"document.location.href='?page=tools-ekspor-datamaster&sub=gurumapel&thnajaran='+document.frmaing.txtThnAjar.value\"");
		
		$NyariData.=FormCF("horizontal","Semester","txtSemester","select * from ak_semester","ganjilgenap",$_GET['gg'],"ganjilgenap","4","onchange=\"document.location.href='?page=tools-ekspor-datamaster&sub=gurumapel&thnajaran='+document.frmaing.txtThnAjar.value+'&gg='+document.frmaing.txtSemester.value\"");

		$NyariData.=FormCF("horizontal","Tingkat","txtTingkat","select * from ak_kelas where tahunajaran='$thnajaran' group by tingkat","tingkat",$_GET['tingkat'],"tingkat","4","onchange=\"document.location.href='?page=tools-ekspor-datamaster&sub=gurumapel&thnajaran='+document.frmaing.txtThnAjar.value+'&gg='+document.frmaing.txtSemester.value+'&tingkat='+document.frmaing.txtTingkat.value\"");

		$NyariData.=FormCF("horizontal","Kelas","txtIdKls","select * from ak_kelas where tahunajaran='$thnajaran' and tingkat='$tingkat' order by kode_kelas,tingkat,kode_pk desc","kode_kelas",$_GET['id_kls'],"nama_kelas","4","onchange=\"document.location.href='?page=tools-ekspor-datamaster&sub=gurumapel&thnajaran='+document.frmaing.txtThnAjar.value+'&gg='+document.frmaing.txtSemester.value+'&tingkat='+document.frmaing.txtTingkat.value+'&id_kls='+document.frmaing.txtIdKls.value\"");

		$NyariData.="
		</form>";


		if($thnajaran==""){
			$DownloadDataGMP="<span class='text-danger pull-right'><i class='fa fa-check-square-o text-danger'></i> Pilih Tahun Ajaran</span>";
		}
		else
		if($gg==""){
			$DownloadDataGMP="<span class='text-danger pull-right'><i class='fa fa-check-square-o text-danger'></i> Pilih Semester</span>";
		}
		else
		if($tingkat==""){
			$DownloadDataGMP="<span class='text-danger pull-right'><i class='fa fa-check-square-o text-danger'></i> Pilih Tingkat</span>";
		}
		else
		if($id_kls==""){
			$DownloadDataGMP="<span class='text-danger pull-right'><i class='fa fa-check-square-o text-danger'></i> Pilih Kelas</span>";
		}
		else
		{
			$QGMP=mysql_query("select 
			gmp_ngajar.id_ngajar,
			gmp_ngajar.thnajaran,
			app_user_guru.nama_lengkap,
			ak_matapelajaran.kode_mapel,
			ak_matapelajaran.nama_mapel,
			ak_kelas.nama_kelas,
			gmp_ngajar.jenismapel,
			gmp_ngajar.kd_kelas
			from gmp_ngajar 
			inner join app_user_guru on gmp_ngajar.kd_guru=app_user_guru.id_guru
			inner join ak_matapelajaran on gmp_ngajar.kd_mapel=ak_matapelajaran.kode_mapel
			inner join ak_kelas on gmp_ngajar.kd_kelas = ak_kelas.kode_kelas 
			where gmp_ngajar.thnajaran='$thnajaran' and gmp_ngajar.ganjilgenap='$gg' and gmp_ngajar.kd_kelas='$id_kls' order by gmp_ngajar.kd_mapel");
			$CGMP=mysql_num_rows($QGMP);
			if($CGMP==0){
				$DownloadDataGMP="<i class='fa fa-window-close-o txt-color-red font-xl'></i> <br>Data Kosong";}
			else{
				$TampilJumlah="Total Data : ".$CGMP." Pengajar";
				$DownloadDataGMP="<a href=\"javascript:;\" onClick=\"window.open('./pages/excel/ekspor-data-master.php?eksporex=gurumapel&thnajaran=$thnajaran&gg=$gg&tingkat=$tingkat&id_kls=$id_kls')\" class='btn btn-info  pull-right'>Download</a>";
				$DownloadDataGMP2="<a href=\"javascript:;\" onClick=\"window.open('./pages/excel/ekspor-data-master.php?eksporex=gurumapel-semester&thnajaran=$thnajaran&gg=$gg')\" class='btn btn-info  pull-right'>Download</a>";			
			}
		}
		$NoGMP=1;
		while($DGMP=mysql_fetch_array($QGMP)){
			$Kelas=$DGMP['nama_kelas'];
			$TampilGMP.="
			<tr>
				<td>$NoGMP.</td>
				<td>{$DGMP['id_ngajar']}</td>
				<td>{$DGMP['nama_lengkap']}</td>
				<td>{$DGMP['kode_mapel']}</td>
				<td>{$DGMP['nama_mapel']}</td>
			</tr>";
			$NoGMP++;
		}
		if($CGMP==0){}else{
			$TabelGMP=KolomPanel(JudulKolom("Data Pengajar","book")."
			<p class='info' style='margin-top:-15px;margin-bottom:25px;'><span class='label bg-color-darken txt-color-white'>Info !</span> <span class='hidden-lg'><br></span><code>Kelas <strong>$Kelas </strong> Tahun Ajaran $thnajaran Semester $gg </code></p>			
			<div class='widget-body no-padding'>
				<table id='dt_basic' class='table table-striped table-bordered table-condensed' width='100%'>
					<thead>
						<tr>
							<th data-class='expand'>No.</th>
							<th data-hide='phone'>ID Ngajar</th>
							<th data-hide='phone'>Nama Lengkap</th>
							<th data-hide='phone'>Kode Mapel</th>
							<th>Nama Mapel</th>
						</tr>
					</thead>
					<tbody>
						$TampilGMP
					</tbody>
				</table>
			</div>");
		}

		$ExData.=DuaKolomD(8,$TampilJumlah,4,$DownloadDataGMP);
		$Show.=DuaKolomSama($JenisData,$NyariData.'<hr>'.$ExData);
		$Show.=$TabelGMP;
		echo $DownloadDataMaster;
		$tandamodal="#DownloadDataMaster";
		echo MyWidget('fa-download',$page_title." Data Mengajar",$Tombolna,$Show);
	break;
}
echo '</div>';
include("inc/footer.php");
include("inc/scripts.php");
//"))
?>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/datatables/dataTables.colVis.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/datatables/dataTables.tableTools.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/datatables/dataTables.bootstrap.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/datatable-responsive/datatables.responsive.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/jquery-form/jquery-form.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	var a={
		"hapus":function(a){
			function b(){
				window.location=a.attr("href")
			}
			$.SmartMessageBox(
				{
					"title":"<i class='fa fa-question-circle txt-color-orangeDark'></i> <span class='txt-color-red'><strong>Konfirmasi Hapus.</strong></span>",
					"content":a.data("hapus-msg"),
					"buttons":"[No][Yes]"
				},function(a){
					"Yes"==a&&($.root_.addClass("animated fadeOutUp"),setTimeout(b,1e3))
					}
		)}
	}
	$.root_.on("click",'[data-action="hapus"]',function(b){var c=$(this);a.hapus(c),b.preventDefault(),c=null});
	var responsiveHelper_dt_basic = undefined;
	var responsiveHelper_datatable_fixed_column = undefined;
	var responsiveHelper_datatable_col_reorder = undefined;
	var responsiveHelper_datatable_tabletools = undefined;
	
	var breakpointDefinition = {
		tablet : 1024,
		phone : 480
	};
	$('#dt_basic').dataTable({
		"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+
			"t"+
			"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
		"autoWidth" : true,
		"preDrawCallback" : function() {
			// Initialize the responsive datatables helper once.
			if (!responsiveHelper_dt_basic) {
				responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_basic'), breakpointDefinition);
			}
		},
		"rowCallback" : function(nRow) {
			responsiveHelper_dt_basic.createExpandIcon(nRow);
		},
		"drawCallback" : function(oSettings) {
			responsiveHelper_dt_basic.respond();
		}
	});
	$('#datatable_tabletools').dataTable({
		
		// Tabletools options: 
		//   https://datatables.net/extensions/tabletools/button_options
		"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-6 hidden-xs'T>r>"+
				"t"+
				"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>",
        "oTableTools": {
        	 "aButtons": [
             "copy",
             "csv",
             "xls",
                {
                    "sExtends": "pdf",
                    "sTitle": "SmartAdmin_PDF",
                    "sPdfMessage": "SmartAdmin PDF Export",
                    "sPdfSize": "letter"
                },
             	{
                	"sExtends": "print",
                	"sMessage": "Generated by SmartAdmin <i>(press Esc to close)</i>"
            	}
             ],
            "sSwfPath": "js/plugin/datatables/swf/copy_csv_xls_pdf.swf"
        },
		"autoWidth" : true,
		"preDrawCallback" : function() {
			// Initialize the responsive datatables helper once.
			if (!responsiveHelper_datatable_tabletools) {
				responsiveHelper_datatable_tabletools = new ResponsiveDatatablesHelper($('#datatable_tabletools'), breakpointDefinition);
			}
		},
		"rowCallback" : function(nRow) {
			responsiveHelper_datatable_tabletools.createExpandIcon(nRow);
		},
		"drawCallback" : function(oSettings) {
			responsiveHelper_datatable_tabletools.respond();
		}
	});
})
</script>