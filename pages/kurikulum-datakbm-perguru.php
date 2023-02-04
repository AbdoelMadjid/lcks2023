<?php
require_once("inc/init.php");
require_once("inc/config.ui.php");
$page_title = "Perguru";
$page_css[] = "your_style.css";
include("inc/header.php");
$page_nav["kurikulum"]["sub"]["datakbm"]["sub"]["perguru"]["active"] = true;
include("inc/nav.php");
echo "<div id='main' role='main'>";
$breadcrumbs["Kurikulum / Proses KBM"] = "";
include("inc/ribbon.php");	
$sub = (isset($_GET['sub']))? $_GET['sub'] : "";
switch ($sub)
{
	case "tampil":default:

	//=============================================================[ NYARI DATA ]

		$Rekap.=JudulKolom("Rekap KBM","graduation-cap");
		$Rekap.="<a href='?page=$page&sub=rekapguru' class='btn btn-default btn-sm btn-block'>Rekapitulasi Upload Per Guru</a>";
		$Rekap.="<a href='?page=$page&sub=cekkikd' class='btn btn-default btn-sm btn-block'>Cek Data KIKD Per Guru</a>";
		$NyariData.=JudulKolom("Pilih Data","search");

		$NyariData.="<form action='?page=$page' method='post' name='frmaing' class='form-horizontal' role='form'>";
		$NyariData.=FormCF("horizontal","Tahun Ajaran","txtThnAjar","select * from ak_tahunajaran order by id_thnajar asc","tahunajaran",$PilTA,"tahunajaran","3","onchange=\"document.location.href='?page=$page&amp;sub=updateta&thnajar='+document.frmaing.txtThnAjar.value\"");
		$NyariData.=FormCF("horizontal","Semester","txtGG","select * from ak_semester","ganjilgenap",$PilSmstr,"ganjilgenap","3","onchange=\"document.location.href='?page=$page&amp;sub=updategg&gg='+document.frmaing.txtGG.value\"");
		$NyariData.=FormCF("horizontal","Tenaga Pendidik","txtGr","select gmp_ngajar.kd_guru,app_user_guru.id_guru,app_user_guru.nama_lengkap from gmp_ngajar inner join app_user_guru on gmp_ngajar.kd_guru=app_user_guru.id_guru where gmp_ngajar.thnajaran='".$PilTA."' and gmp_ngajar.ganjilgenap='".$PilSmstr."' group by app_user_guru.id_guru order by app_user_guru.nama_lengkap","id_guru",$PilGr,"nama_lengkap","6","onchange=\"document.location.href='?page=$page&amp;sub=updategr&gr='+document.frmaing.txtGr.value\"");
		$NyariData.="</form>";
		
	//=============================================================[ CEK KBM PER GURU ]

		$QNgajar=mysql_query("
		SELECT 
		gmp_ngajar.id_ngajar,
		gmp_ngajar.thnajaran,
		gmp_ngajar.jenismapel,
		gmp_ngajar.semester,
		gmp_ngajar.kkmpeng,
		gmp_ngajar.kkmket,
		app_user_guru.nama_lengkap,
		ak_matapelajaran.kode_mapel,
		ak_matapelajaran.nama_mapel,
		ak_kelas.nama_kelas,
		ak_kelas.id_kls
		FROM 
		gmp_ngajar,
		app_user_guru,
		ak_matapelajaran,
		ak_kelas 
		WHERE 
		gmp_ngajar.kd_guru=app_user_guru.id_guru AND 
		gmp_ngajar.kd_mapel=ak_matapelajaran.kode_mapel AND 
		gmp_ngajar.kd_kelas=ak_kelas.kode_kelas and 
		gmp_ngajar.kd_guru='$PilGr' and 
		gmp_ngajar.thnajaran='$PilTA' and
		gmp_ngajar.ganjilgenap='$PilSmstr' 
		order by gmp_ngajar.semester,gmp_ngajar.kd_kelas,gmp_ngajar.kd_mapel asc");
		$no=1;
		while($HNgajar=mysql_fetch_array($QNgajar))
		{
			$NamaGuru=$HNgajar['nama_lengkap']; 
			$kmapel=$HNgajar['id_ngajar'];

			$JNk1k2=JmlDt("select * from n_sikap where kd_ngajar='$kmapel'");
			if($JNk1k2>0){
				$Tk1k2="<a href=\"javascript:void(0);\" onClick=\"window.open('./pages/excel/ekspor-nilai.php?eksporex=nilai-sikap&kbm=$kmapel&mapel={$HNgajar['nama_mapel']}&kls={$HNgajar['nama_kelas']}&komp=sikap')\"><i class='fa fa-check txt-color-red'></i> K1 K2 - Sosial dan Spritual</a>";
				$Hpk1k2="<a href='?page=$page&sub=HapusNilaiK1K2&kbm=$kmapel'><span class='label label-danger'>Del</span> K1K2</a>";
			}
			else
			{
				$Tk1k2="<a href=\"javascript:void(0);\"><i class='fa fa-remove txt-color-red'></i> K1 K2 - Sosial dan Spritual</a>";
				$Hpk1k2="<a href='?page=$page&sub=upload_nilai&guru=$PilGr&thnajaran=$PilTA&gg=$PilSmstr&kbm=$kmapel&up=k1k2'><span class='label label-info'>Up</span> K1K2</a>";
			}

			$JNk3=JmlDt("select * from n_p_kikd where kd_ngajar='$kmapel'");
			if($JNk3>0){
				$Tk3="<a href=\"javascript:void(0);\" onClick=\"window.open('./pages/excel/ekspor-nilai.php?eksporex=nilai-mapel&kbm=$kmapel&mapel={$HNgajar['nama_mapel']}&kls={$HNgajar['nama_kelas']}&komp=pengetahuan')\"><i class='fa fa-check txt-color-red'></i> K3 - Pengetahuan</a>";
				$Hpk3="<a href='?page=$page&sub=HapusNilaiK3&kbm=$kmapel'><span class='label label-danger'>Del</span> K3</a>";
			}
			else
			{
				$Tk3="<a href=\"javascript:void(0);\"><i class='fa fa-remove txt-color-red'></i> K3 - Pengetahuan</a>";
				$Hpk3="<a href='?page=$page&sub=upload_nilai&guru=$PilGr&thnajaran=$PilTA&gg=$PilSmstr&kbm=$kmapel&up=k3'><span class='label label-info'>Up</span> K3</a>";
			}

			$JNutsuas=JmlDt("select * from n_utsuas where kd_ngajar='$kmapel'");
			if($JNutsuas>0){
				$Tutsuas="<a href=\"javascript:void(0);\" onClick=\"window.open('./pages/excel/ekspor-nilai.php?eksporex=nilai-utsuas&kbm=$kmapel&mapel={$HNgajar['nama_mapel']}&kls={$HNgajar['nama_kelas']}&komp=utsuas')\"><i class='fa fa-check txt-color-red'></i> UTS dan UAS</a>";
				$Hputsuas="<a href='?page=$page&sub=HapusNilaiUTSUAS&kbm=$kmapel'><span class='label label-danger'>Del</span> UTS UAS</a>";
			}
			else
			{
				$Tutsuas="<a href=\"javascript:void(0);\"><i class='fa fa-remove txt-color-red'></i> UTS dan UAS</a>";
				$Hputsuas="<a href='?page=$page&sub=upload_nilai&guru=$PilGr&thnajaran=$PilTA&gg=$PilSmstr&kbm=$kmapel&up=utsuas'><span class='label label-info'>Up</span> UTS UAS</a>";
			}

			$JNk4=JmlDt("select * from n_k_kikd where kd_ngajar='$kmapel'");
			if($JNk4>0){
				$Tk4="<a href=\"javascript:void(0);\" onClick=\"window.open('./pages/excel/ekspor-nilai.php?eksporex=nilai-mapel&kbm=$kmapel&mapel={$HNgajar['nama_mapel']}&kls={$HNgajar['nama_kelas']}&komp=keterampilan')\"><i class='fa fa-check txt-color-red'></i> K4 - Keterampilan</a>";
				$Hpk4="<a href='?page=$page&sub=HapusNilaiK4&kbm=$kmapel'><span class='label label-danger'>Del</span> K4</a>";
			}
			else
			{
				$Tk4="<a href=\"javascript:void(0);\"><i class='fa fa-remove txt-color-red'></i> K4 - Keterampilan</a>";
				$Hpk4="<a href='?page=$page&sub=upload_nilai&guru=$PilGr&thnajaran=$PilTA&gg=$PilSmstr&kbm=$kmapel&up=k4'><span class='label label-info'>Up</span> K4</a>";
			}

			$JAbsen=JmlDt("select * from gmp_absensi where kd_ngajar='$kmapel'");
			if($JAbsen>0){
				$TAbsen="<a href=\"javascript:void(0);\" onClick=\"window.open('./pages/excel/ekspor-data-master.php?eksporex=absensi-mapel&kbm=$kmapel&mapel={$HNgajar['nama_mapel']}&kls={$HNgajar['nama_kelas']}&komp=Absensi')\"><i class='fa fa-check txt-color-red'></i> Absensi</a>";
				$HpAbsen="<a href='?page=$page&sub=HapusAbsensi&kbm=$kmapel'><span class='label label-danger'>Del</span> ABSENSI</a>";
			}
			else
			{
				$TAbsen="<a href=\"javascript:void(0);\"><i class='fa fa-remove txt-color-red'></i> Absensi</a>";
				$HpAbsen="<a href='?page=$page&sub=upload_nilai&guru=$PilGr&thnajaran=$PilTA&gg=$PilSmstr&kbm=$kmapel&up=ab'><span class='label label-info'>Up</span> ABSENSI </a>";
			}
			
			// hapus dan upload semua data

			if($JNk1k2>0 || $JNk3>0 || $JNutsuas>0 || $JNk4 || $JAbsen>0){
				$PilihHapusSemua="<li><a href='?page=$page&sub=HapusAll&kbm=$kmapel'><span class='label label-info'>Del</span> Semua</a></li>";
				$PilihUpload="";

			}else{
				$PilihHapusSemua="";
				$PilihUpload="<li><a href='?page=$page&sub=upload_nilai&guru=$PilGr&thnajaran=$PilTA&gg=$PilSmstr&kbm=$kmapel&up=all'><span class='label label-warning'>Up</span> Semua Data</a></li>";
			}


			$jmlkd12=JmlDt("select * from gmp_kikd where kode_ranah='KDS' and kode_ngajar='$kmapel' and thnajar='$PilTA' and smstr='{$HNgajar['semester']}'");			
			$jmlkd3=JmlDt("select * from gmp_kikd where kode_ranah='KDP' and kode_ngajar='$kmapel' and thnajar='$PilTA' and smstr='{$HNgajar['semester']}'");
			$jmlkd4=JmlDt("select * from gmp_kikd where kode_ranah='KDK' and kode_ngajar='$kmapel' and thnajar='$PilTA' and smstr='{$HNgajar['semester']}'");

			$TmbDownload="
			<div class='btn-group'>
				<button class='btn btn-default btn-sm btn-block dropdown-toggle' data-toggle='dropdown'>
					Download Nilai <span class='caret'></span>
				</button>
				<ul class='dropdown-menu'>
					<li>$Tk1k2</li>
					<li>$Tk3</li>
					<li>$Tutsuas</li>
					<li>$Tk4</li>
					<li>$TAbsen</li>
				</ul>
			</div>";
			$TampilData.="
			<tr>
				<td class='text-center'>$no.</td>
				<td><strong>{$HNgajar['id_ngajar']}</strong> <br><font color='#cc0000'>{$HNgajar['nama_mapel']}</font></td>
				<td>{$HNgajar['nama_kelas']}</td>
				<td>{$HNgajar['semester']}</td>
				<td>$jmlkd12</td>
				<td>$jmlkd3</td>
				<td>$jmlkd4</td>
				<td>{$HNgajar['kkmpeng']}</td>
				<td>{$HNgajar['kkmket']}</td>
				<td width=100>$TmbDownload</td>
				<td width=75>
					<div class='btn-group'>
						<button class='btn btn-default btn-sm btn-block dropdown-toggle' data-toggle='dropdown'>
							&nbsp;&nbsp;&nbsp;Proses <span class='caret'></span>&nbsp;&nbsp;&nbsp;
						</button>
						<ul class='dropdown-menu'>
							<li>$Hpk1k2</li>
							<li>$Hpk3</li>
							<li>$Hputsuas</li>
							<li>$Hpk4</li>
							<li>$HpAbsen</li>
							$PilihHapusSemua
							$PilihUpload
						</ul>
					</div>				
				</td>
				<td><a href=\"javascript:void(0);\" onClick=\"window.open('./pages/excel/ekspor-data-master.php?eksporex=format-nilai-gurumapel&guru=$PilGuru&kbm=$kmapel&mapel={$HNgajar['nama_mapel']}&kls={$HNgajar['nama_kelas']}&thnajaran=$PilTA&gg={$HNgajar['semester']}')\" class='btn btn-default btn-block btn-sm'><i class='fa fa-download'></i></a></td>
			</tr>";
			$no++;
		}
		$DtKBMGuru.="
		<div class='well no-padding'>
			<table id='dt_basic' class='table table-striped table-bordered table-hover table-condensed' width='100%'>
				<thead>
					<tr>
						<th class='text-center' data-class='expand'>No.</th>
						<th class='text-center' data-hide='phone'>Mata Pelajaran</th>
						<th class='text-center'>Kelas</th>
						<th class='text-center' data-hide='phone'>Smstr</th>
						<th class='text-center' data-hide='phone'>KD S</th>
						<th class='text-center' data-hide='phone'>KD P</th>
						<th class='text-center' data-hide='phone'>KD K</th>
						<th class='text-center' data-hide='phone'>KKM P</th>
						<th class='text-center' data-hide='phone'>KKM K</th>
						<th class='text-center' data-hide='phone'>Download</th>
						<th class='text-center'>Up/Del</th>
						<th class='text-center'>Format</th>
					</tr>
				</thead>
				<tbody>$TampilData</tbody>
			</table>
		</div>";

		//===============================================Tampilkan di browser

		$Show.=DuaKolomSama($NyariData,$Rekap);
		$Show.=$DtKBMGuru;
		
		$tandamodal="#CheckDataKBM";
		echo $CheckDataKBM;
		echo MyWidget('fa-book',"Per Guru","",$Show);
	break;

	case "rekapguru":

		$semesterna=isset($_GET['semesterna'])?$_GET['semesterna']:"";
		$Milih1.=$_GET['semesterna']=="1"?"selected":"";
		$Milih2.=$_GET['semesterna']=="2"?"selected":"";
		$Milih3.=$_GET['semesterna']=="3"?"selected":"";
		$Milih4.=$_GET['semesterna']=="4"?"selected":"";
		$Milih5.=$_GET['semesterna']=="5"?"selected":"";
		$Milih6.=$_GET['semesterna']=="6"?"selected":"";

		if($semesterna=='1'){$dtsmst="and semester=1";}
		else if($semesterna=='2'){$dtsmst="and semester=2";}
		else if($semesterna=='3'){$dtsmst="and semester=3";}
		else if($semesterna=='4'){$dtsmst="and semester=4";}
		else if($semesterna=='5'){$dtsmst="and semester=5";}
		else if($semesterna=='6'){$dtsmst="and semester=6";}

		$FormPilih.="
		<form action='?page=$page&amp;sub=tampil' method='post' name='FrmNyariData' class='form-horizontal' role='form'>
			<div class='form-group'>
				<label class='col-sm-4 control-label'>Semester</label>
				<div class='col-sm-4'>
					<select name=\"txtGG\" class='input-sm form-control' onchange=\"document.location.href='?page=$page&sub=rekapguru&semesterna='+document.FrmNyariData.txtGG.value\">
						<option value=''>Pilih Semester</option>
						<option $Milih1 value='1'>Semester I</option>
						<option $Milih2 value='2'>Semester II</option>
						<option $Milih3 value='3'>Semester III</option>
						<option $Milih4 value='4'>Semester IV</option>
						<option $Milih5 value='5'>Semester V</option>
						<option $Milih6 value='6'>Semester VI</option>
					</select>
				</div>
			</div>
		</form>";
	
		$TampilGuru.="
		$FormPilih<br><br>
		<div class='well no-padding'>
		<table id='dt_basic' class='table table-striped table-bordered table-hover table-condensed' width='100%'>
		<thead>
		<tr>
			<th class='text-center' data-class='expand'>No.</th>
			<th class='text-center' data-hide='phone'>Kode Guru</th>
			<th class='text-center'>Nama Pengajar</th>
			<th class='text-center' data-hide='phone'>Jumlah KBM</th>
			<th class='text-center'>Upload Nilai</th>
			<th class='text-center'>Sudah / Belum</th>
		</tr>
		</thead>
		<body>";

		//$QGuru=mysql_query("select kd_guru,count(*) as jml from ngajar where thnajaran='$PilTA' and ganjilgenap='$PilSemester' $dtsmst group by kd_guru");

		$QGuru=mysql_query("select kd_guru,count(*) as jml from gmp_ngajar where thnajaran='$PilTA' and ganjilgenap='$PilSmstr' $dtsmst group by kd_guru");

		$noGuru=0;
		$JmlGuru=0;
		while($HGuru=mysql_fetch_array($QGuru))
		{
			ngambildata("select * from app_user_guru where id_guru='{$HGuru['kd_guru']}'");
			$noGuru=$noGuru+1;
			$JmlData02=$HGuru["jml"];

			$QNilaiK4=JmlDt("select gmp_ngajar.id_ngajar, gmp_ngajar.kd_guru, n_k_kikd.kd_ngajar from gmp_ngajar,n_k_kikd where gmp_ngajar.id_ngajar=n_k_kikd.kd_ngajar and gmp_ngajar.thnajaran='$PilTA' and gmp_ngajar.ganjilgenap='$PilSemester' and gmp_ngajar.kd_guru='{$HGuru['kd_guru']}' group by gmp_ngajar.id_ngajar");

			$SisaBelumUpload=$HGuru["jml"]-$QNilaiK4;
			if($HGuru["jml"]==$QNilaiK4){$SudahBelum="<i class='fa fa-check fa-lg'></i>";}else{$SudahBelum="(".$SisaBelumUpload.")";}

			$TampilGuru.="
			<tr>
				<td class='text-center'>$noGuru.</td>
				<td class='text-center'>".$id_guru."</a></td>
				<td>".$nama_lengkap."</td>
				<td class='text-center'>".$HGuru["jml"]."</td>
				<td class='text-center'>".$QNilaiK4."</td>
				<td class='text-center'>".$SudahBelum."</td>
			</tr>";
			$JmlGuru=$JmlGuru+$HGuru["jml"];
		}
		$TampilGuru.="
		</tbody>
		</table></div>";

		if($JmlData02==0){
			$Show.="$FormPilih<br><br>";
			$Show.=nt("informasi","Data KBM belum ada");
		}else{
			$Show.="$TampilGuru";
		}

		$tandamodal="#RekapUploagPerGuru";
		echo $RekapUploagPerGuru;
		echo MyWidget('fa-upload',"Rekap Upload Nilai Per Guru",array(ButtonKembali("?page=$page")),$Show);
	break;

	case "upload_nilai":
		$kbm=isset($_GET['kbm'])?$_GET['kbm']:"";
		$guru=isset($_GET['guru'])?$_GET['guru']:"";
		$thnajaran=isset($_GET['thnajaran'])?$_GET['thnajaran']:"";
		$gg=isset($_GET['gg'])?$_GET['gg']:"";
		$pilihan=isset($_GET['up'])?$_GET['up']:"";

		$Q=mysql_query("select 
		gmp_ngajar.id_ngajar,
		gmp_ngajar.thnajaran,
		gmp_ngajar.semester,
		ak_kelas.nama_kelas,
		ak_matapelajaran.nama_mapel,
		app_user_guru.nama_lengkap
		from gmp_ngajar
		inner join ak_kelas on gmp_ngajar.kd_kelas=ak_kelas.kode_kelas
		inner join app_user_guru on gmp_ngajar.kd_guru=app_user_guru.id_guru
		inner join ak_matapelajaran on gmp_ngajar.kd_mapel=ak_matapelajaran.kode_mapel
		where gmp_ngajar.id_ngajar='$kbm'");
		$H=mysql_fetch_array($Q);
		$id_guru=$H['id_guru'];
		$Show.="
		<script type=\"text/javascript\">
			function validateForm()
			{
				function hasExtension(inputID, exts) {
					var fileName = document.getElementById(inputID).value;
					return (new RegExp('(' + exts.join('|').replace(/\./g, '\\.') + ')$')).test(fileName);
				}
		 
				if(!hasExtension('filepegawaiall', ['.xls'])){
					alert(\"Hanya file XLS (Excel 2003) yang diijinkan.\");
					return false;
				}
			}
		</script>";

		$Keterangan.=nt("informasi","ID KBM <strong>{$H['id_ngajar']}</strong><br>Tahun Ajaran <strong>{$H['thnajaran']}</strong><br>Semester <strong>{$H['semester']}</strong><br>Kelas <strong>{$H['nama_kelas']}</strong><br>Mata Pelajaran <strong>{$H['nama_mapel']}</strong>");
		
		if($pilihan=="k1k2"){
			$UloadPerNilai.=JudulDalam("Nilai K1K2 - Spritual dan Sosial","");
			$UloadPerNilai.="
			<form name='myForm' id='myForm' onSubmit='return validateForm()' action='?page=$page&sub=uploadk1k2&guru=$guru&thnajaran=$thnajaran&gg=$gg&kbm=$kbm' method='post' enctype='multipart/form-data' class='smart-form'>
				<fieldset>
					<section>
						<label class='label'>Pilih File</label>
						<div class='input input-file'>
							<span class='button'>
							<input type='file' id='id-input-file-k1k2' name='k1k2' onchange='this.parentNode.nextSibling.value = this.value'>Browse</span><input type='text' placeholder='Include some files' readonly=''>
						</div>
					</section>
					<span class='help-block'>* file yang bisa di import adalah .xls (Excel 2003-2007).</span>
				</fieldset>
				<div class='form-actions center'>
					<button type='button submit' name='submit' class='btn btn-sm btn-success'>
						Submit
						<i class='ace-icon fa fa-arrow-right icon-on-right bigger-110'></i>
					</button>
				</div>
			</form>";
		}
		else if($pilihan=="k3")
		{
			$UloadPerNilai.=JudulDalam("Nilai K3 - Pengetahuan","");
			$UloadPerNilai.="
			<form name='myForm' id='myForm' onSubmit='return validateForm()' action='?page=$page&sub=uploadk3&guru=$guru&thnajaran=$thnajaran&gg=$gg&kbm=$kbm' method='post' enctype='multipart/form-data' class='smart-form'>
				<fieldset>
					<section>
						<label class='label'>Pilih File</label>
						<div class='input input-file'>
							<span class='button'>
							<input type='file' id='id-input-file-k3' name='k3' onchange='this.parentNode.nextSibling.value = this.value'>Browse</span><input type='text' placeholder='Include some files' readonly=''>
						</div>
					</section>
					<span class='help-block'>* file yang bisa di import adalah .xls (Excel 2003-2007).</span>
				</fieldset>
				<div class='form-actions center'>
					<button type='button submit' name='submit' class='btn btn-sm btn-success'>
						Submit
						<i class='ace-icon fa fa-arrow-right icon-on-right bigger-110'></i>
					</button>
				</div>
			</form>";
		}
		else if($pilihan=="utsuas")
		{
			$UloadPerNilai.=JudulDalam("Nilai UTS UAS","");
			$UloadPerNilai.="
			<form name='myForm' id='myForm' onSubmit='return validateForm()' action='?page=$page&sub=uploadutsuas&guru=$guru&thnajaran=$thnajaran&gg=$gg&kbm=$kbm' method='post' enctype='multipart/form-data' class='smart-form'>
				<fieldset>
					<section>
						<label class='label'>Pilih File</label>
						<div class='input input-file'>
							<span class='button'>
							<input type='file' id='id-input-file-utsuas' name='utsuas' onchange='this.parentNode.nextSibling.value = this.value'>Browse</span><input type='text' placeholder='Include some files' readonly=''>
						</div>
					</section>
					<span class='help-block'>* file yang bisa di import adalah .xls (Excel 2003-2007).</span>
				</fieldset>
				<div class='form-actions center'>
					<button type='button submit' name='submit' class='btn btn-sm btn-success'>
						Submit
						<i class='ace-icon fa fa-arrow-right icon-on-right bigger-110'></i>
					</button>
				</div>
			</form>";
		}
		else if($pilihan=="k4")
		{
			$UloadPerNilai.=JudulDalam("Nilai K4 - Keterampilan","");
			$UloadPerNilai.="
			<form name='myForm' id='myForm' onSubmit='return validateForm()' action='?page=$page&sub=uploadk4&guru=$guru&thnajaran=$thnajaran&gg=$gg&kbm=$kbm' method='post' enctype='multipart/form-data' class='smart-form'>
				<fieldset>
					<section>
						<label class='label'>Pilih File</label>
						<div class='input input-file'>
							<span class='button'>
							<input type='file' id='id-input-file-k4' name='k4' onchange='this.parentNode.nextSibling.value = this.value'>Browse</span><input type='text' placeholder='Include some files' readonly=''>
						</div>
					</section>
					<span class='help-block'>* file yang bisa di import adalah .xls (Excel 2003-2007).</span>
				</fieldset>
				<div class='form-actions center'>
					<button type='button submit' name='submit' class='btn btn-sm btn-success'>
						Submit
						<i class='ace-icon fa fa-arrow-right icon-on-right bigger-110'></i>
					</button>
				</div>
			</form>";
		}
		else if($pilihan=="ab")
		{
			$UloadPerNilai.=JudulDalam("Absensi Guru Mata Pelajaran","");
			$UloadPerNilai.="
			<form name='myForm' id='myForm' onSubmit='return validateForm()' action='?page=$page&sub=uploadabsen&guru=$guru&thnajaran=$thnajaran&gg=$gg&kbm=$kbm' method='post' enctype='multipart/form-data' class='smart-form'>
				<fieldset>
					<section>
						<label class='label'>Pilih File</label>
						<div class='input input-file'>
							<span class='button'>
							<input type='file' id='id-input-file-absen' name='absen' onchange='this.parentNode.nextSibling.value = this.value'>Browse</span><input type='text' placeholder='Include some files' readonly=''>
						</div>
					</section>
					<span class='help-block'>* file yang bisa di import adalah .xls (Excel 2003-2007).</span>
				</fieldset>
				<div class='form-actions center'>
					<button type='button submit' name='submit' class='btn btn-sm btn-success'>
						Submit
						<i class='ace-icon fa fa-arrow-right icon-on-right bigger-110'></i>
					</button>
				</div>
			</form>";
		}
		else if($pilihan=="all")
		{
			$UloadPerNilai.=JudulDalam("Seluruh Nilai & Absensi","");
			$UloadPerNilai.="
			<form name='myForm' id='myForm' onSubmit='return validateForm()' action='?page=$page&sub=nyimpenkabeh&guru=$guru&thnajaran=$thnajaran&gg=$gg&kbm=$kbm' method='post' enctype='multipart/form-data' class='smart-form'>
				<fieldset>
					<section>
						<label class='label'>Pilih File</label>
						<div class='input input-file'>
							<span class='button'>
							<input type='file' id='id-input-file-semua' name='semua' onchange='this.parentNode.nextSibling.value = this.value'>Browse</span><input type='text' placeholder='Include some files' readonly=''>
						</div>
					</section>
					<span class='help-block'>* file yang bisa di import adalah .xls (Excel 2003-2007).</span>
				</fieldset>
				<div class='form-actions center'>
					<button type='button submit' name='submit' class='btn btn-sm btn-success'>
						Submit
						<i class='ace-icon fa fa-arrow-right icon-on-right bigger-110'></i>
					</button>
				</div>
			</form>";
		}

		$Show.=DuaKolomD(6,$Keterangan,6,KolomPanel($UloadPerNilai));

		echo $UploadNilaiMapel;
		echo MyWidget('fa-upload',"Upload Nilai",array(ButtonKembali("?page=$page")),$Show);
	break;

	case "nyimpenkabeh":
		$kbm=isset($_GET['kbm'])?$_GET['kbm']:"";
		$guru=isset($_GET['guru'])?$_GET['guru']:"";
		$thnajaran=isset($_GET['thnajaran'])?$_GET['thnajaran']:"";
		$gg=isset($_GET['gg'])?$_GET['gg']:"";

		require_once "pages/excel_reader.php"; 

		$data = new Spreadsheet_Excel_Reader($_FILES['semua']['tmp_name']);
		
		$NK1K2 = $data->rowcount($sheet_index=0);

		for ($i=2; $i<=$NK1K2; $i++) {
			$txtNo = $data->val($i,1,0);
			$txtKBM = $data->val($i,2,0);
			$txtNIS = $data->val($i,3,0);
			$txtNSis = $data->val($i,4,0);
			$txtSpritual = $data->val($i,5,0);
			$txtSosial = $data->val($i,6,0);
			$txtDescSSpr = $data->val($i,7,0);
			$txtDescSSos = $data->val($i,8,0);
			//$kd_nSikap=buatKode("n_sikap","ns_");
			mysql_query("INSERT INTO n_sikap VALUES ('','$txtKBM','$txtNIS','$txtSpritual','$txtSosial','$txtDescSSpr','$txtDescSSos')");
		}
		
		$NK3 = $data->rowcount($sheet_index=1);

		for ($i=2; $i<=$NK3; $i++) { 
			$txtNo = $data->val($i,1,1);
			$txtKBM = $data->val($i,2,1);
			$txtNIS = $data->val($i,3,1);
			$txtNSis = $data->val($i,4,1);
			$txtKDP_1 = $data->val($i,5,1);
			$txtKDP_2 = $data->val($i,6,1);
			$txtKDP_3 = $data->val($i,7,1);
			$txtKDP_4 = $data->val($i,8,1);
			$txtKDP_5 = $data->val($i,9,1);
			$txtKDP_6 = $data->val($i,10,1);
			$txtKDP_7 = $data->val($i,11,1);
			$txtKDP_8 = $data->val($i,12,1);
			$txtKDP_9 = $data->val($i,13,1);
			$txtKDP_10 = $data->val($i,14,1);
			$txtKDP_11 = $data->val($i,15,1);
			$txtKDP_12 = $data->val($i,16,1);
			$txtKDP_13 = $data->val($i,17,1);
			$txtKDP_14 = $data->val($i,18,1);
			$txtKDP_15 = $data->val($i,19,1);

			$jmlKDP=JmlDt("select * from gmp_kikd where kode_ngajar='$kbm' and kode_ranah='KDP'");	
			$NHP=round(($txtKDP_1+$txtKDP_2+$txtKDP_3+$txtKDP_4+$txtKDP_5+$txtKDP_6+$txtKDP_7+$txtKDP_8+$txtKDP_9+$txtKDP_10+$txtKDP_11+$txtKDP_12+$txtKDP_13+$txtKDP_14+$txtKDP_15)/$jmlKDP);

			mysql_query("insert into n_p_kikd values ('','$txtKBM','$txtNIS','$txtKDP_1','$txtKDP_2','$txtKDP_3','$txtKDP_4','$txtKDP_5','$txtKDP_6','$txtKDP_7','$txtKDP_8','$txtKDP_9','$txtKDP_10','$txtKDP_11','$txtKDP_12','$txtKDP_13','$txtKDP_14','$txtKDP_15','$NHP')");
		}


		$NUTSUAS = $data->rowcount($sheet_index=2);

		for ($i=2; $i<=$NUTSUAS; $i++) {
			$txtNo = $data->val($i,1,2);
			$txtKBM = $data->val($i,2,2);
			$txtNIS = $data->val($i,3,2);
			$txtNSis = $data->val($i,4,2);
			$txtUTS = $data->val($i,5,2);
			$txtUAS = $data->val($i,6,2);
			
			mysql_query("insert into n_utsuas values ('','$txtKBM','$txtNIS','$txtUTS','$txtUAS')");

		}

		$NK4 = $data->rowcount($sheet_index=3);

		for ($i=2; $i<=$NK4; $i++) {
			$txtNo = $data->val($i,1,3);
			$txtKBM = $data->val($i,2,3);
			$txtNIS = $data->val($i,3,3);
			$txtNSis = $data->val($i,4,3);
			$txtKDK_1 = $data->val($i,5,3);
			$txtKDK_2 = $data->val($i,6,3);
			$txtKDK_3 = $data->val($i,7,3);
			$txtKDK_4 = $data->val($i,8,3);
			$txtKDK_5 = $data->val($i,9,3);
			$txtKDK_6 = $data->val($i,10,3);
			$txtKDK_7 = $data->val($i,11,3);
			$txtKDK_8 = $data->val($i,12,3);
			$txtKDK_9 = $data->val($i,13,3);
			$txtKDK_10 = $data->val($i,14,3);
			$txtKDK_11 = $data->val($i,15,3);
			$txtKDK_12 = $data->val($i,16,3);
			$txtKDK_13 = $data->val($i,17,3);
			$txtKDK_14 = $data->val($i,18,3);
			$txtKDK_15 = $data->val($i,19,3);

			$jmlKDK=JmlDt("select * from gmp_kikd where kode_ngajar='$kbm' and kode_ranah='KDK'");	
			$NHK=round(($txtKDK_1+$txtKDK_2+$txtKDK_3+$txtKDK_4+$txtKDK_5+$txtKDK_6+$txtKDK_7+$txtKDK_8+$txtKDK_9+$txtKDK_10+$txtKDK_11+$txtKDK_12+$txtKDK_13+$txtKDK_14+$txtKDK_15)/$jmlKDK);

			mysql_query("INSERT INTO n_k_kikd VALUES ('','$txtKBM','$txtNIS','$txtKDK_1','$txtKDK_2','$txtKDK_3','$txtKDK_4','$txtKDK_5','$txtKDK_6','$txtKDK_7','$txtKDK_8','$txtKDK_9','$txtKDK_10','$txtKDK_11','$txtKDK_12','$txtKDK_13','$txtKDK_14','$txtKDK_15','$NHK')");
		}

		$Absen = $data->rowcount($sheet_index=4);

		for ($i=3; $i<=$Absen; $i++) {
			$txtNo = $data->val($i,1,4);
			$txtNIS = $data->val($i,2,4);
			$txtNSis = $data->val($i,3,4);
			$txtNsi = $data->val($i,4,4);
			$txtNTgl = $data->val($i,5,4);
			$txtNBln = $data->val($i,6,4);
			$txtNThn = $data->val($i,7,4);
			$txtNKet = $data->val($i,8,4);

			if($txtNTgl<10){$TglA="0".$txtNTgl;}else{$TglA=$txtNTgl;}
			if($txtNBln<10){$BlnA="0".$txtNBln;}else{$BlnA=$txtNBln;}
			$IsiTgl=$txtNThn."-".$BlnA."-".$TglA;
			
			$kd_absensi=buatKode("gmp_absensi","id_absen","abs_");
			if($txtNIS==""){}else{
			mysql_query("INSERT INTO gmp_absensi VALUES ('$kd_absensi','$kbm','$txtNIS','$txtNsi','$IsiTgl','$txtNKet')");
			}
		}

		//echo '<div id="preloader"><div id="cssload"></div></div>';
		echo ns("Ngimpor","parent.location='?page=$page'","$kbm");
	break;

	case "uploadk1k2":
		$kbm=isset($_GET['kbm'])?$_GET['kbm']:"";
		$guru=isset($_GET['guru'])?$_GET['guru']:"";
		$thnajaran=isset($_GET['thnajaran'])?$_GET['thnajaran']:"";
		$gg=isset($_GET['gg'])?$_GET['gg']:"";

		require_once "pages/excel_reader.php"; 

		$data = new Spreadsheet_Excel_Reader($_FILES['k1k2']['tmp_name']);
		
		$NK1K2 = $data->rowcount($sheet_index=0);

		for ($i=2; $i<=$NK1K2; $i++) {
			$txtNo = $data->val($i,1,0);
			$txtKBM = $data->val($i,2,0);
			$txtNIS = $data->val($i,3,0);
			$txtNSis = $data->val($i,4,0);
			$txtSpritual = $data->val($i,5,0);
			$txtSosial = $data->val($i,6,0);
			$txtDescSSpr = $data->val($i,7,0);
			$txtDescSSos = $data->val($i,8,0);
			//$kd_nSikap=buatKode("n_sikap","ns_");
			mysql_query("INSERT INTO n_sikap VALUES ('','$txtKBM','$txtNIS','$txtSpritual','$txtSosial','$txtDescSSpr','$txtDescSSos')");
		}

		//echo '<div id="preloader"><div id="cssload"></div></div>';
		echo ns("Ngimpor","parent.location='?page=$page'","$kbm");
	break;

	case "uploadk3":
		$kbm=isset($_GET['kbm'])?$_GET['kbm']:"";
		$guru=isset($_GET['guru'])?$_GET['guru']:"";
		$thnajaran=isset($_GET['thnajaran'])?$_GET['thnajaran']:"";
		$gg=isset($_GET['gg'])?$_GET['gg']:"";

		require_once "pages/excel_reader.php"; 
		
		// K3

		$data = new Spreadsheet_Excel_Reader($_FILES['k3']['tmp_name']);

		$NK3 = $data->rowcount($sheet_index=1);

		for ($i=2; $i<=$NK3; $i++) { 
			$txtNo = $data->val($i,1,1);
			$txtKBM = $data->val($i,2,1);
			$txtNIS = $data->val($i,3,1);
			$txtNSis = $data->val($i,4,1);
			$txtKDP_1 = $data->val($i,5,1);
			$txtKDP_2 = $data->val($i,6,1);
			$txtKDP_3 = $data->val($i,7,1);
			$txtKDP_4 = $data->val($i,8,1);
			$txtKDP_5 = $data->val($i,9,1);
			$txtKDP_6 = $data->val($i,10,1);
			$txtKDP_7 = $data->val($i,11,1);
			$txtKDP_8 = $data->val($i,12,1);
			$txtKDP_9 = $data->val($i,13,1);
			$txtKDP_10 = $data->val($i,14,1);
			$txtKDP_11 = $data->val($i,15,1);
			$txtKDP_12 = $data->val($i,16,1);
			$txtKDP_13 = $data->val($i,17,1);
			$txtKDP_14 = $data->val($i,18,1);
			$txtKDP_15 = $data->val($i,19,1);

			$jmlKDP=JmlDt("select * from gmp_kikd where kode_ngajar='$kbm' and kode_ranah='KDP'");	
			$NHP=round(($txtKDP_1+$txtKDP_2+$txtKDP_3+$txtKDP_4+$txtKDP_5+$txtKDP_6+$txtKDP_7+$txtKDP_8+$txtKDP_9+$txtKDP_10+$txtKDP_11+$txtKDP_12+$txtKDP_13+$txtKDP_14+$txtKDP_15)/$jmlKDP);

			mysql_query("insert into n_p_kikd values ('','$txtKBM','$txtNIS','$txtKDP_1','$txtKDP_2','$txtKDP_3','$txtKDP_4','$txtKDP_5','$txtKDP_6','$txtKDP_7','$txtKDP_8','$txtKDP_9','$txtKDP_10','$txtKDP_11','$txtKDP_12','$txtKDP_13','$txtKDP_14','$txtKDP_15','$NHP')");
		}

		//echo '<div id="preloader"><div id="cssload"></div></div>';
		echo ns("Ngimpor","parent.location='?page=$page'","$kbm");
	break;

	case "uploadutsuas":
		$kbm=isset($_GET['kbm'])?$_GET['kbm']:"";
		$guru=isset($_GET['guru'])?$_GET['guru']:"";
		$thnajaran=isset($_GET['thnajaran'])?$_GET['thnajaran']:"";
		$gg=isset($_GET['gg'])?$_GET['gg']:"";

		require_once "pages/excel_reader.php"; 
				
		// UTS UAS

		$data = new Spreadsheet_Excel_Reader($_FILES['utsuas']['tmp_name']);

		$NUTSUAS = $data->rowcount($sheet_index=2);

		for ($i=2; $i<=$NUTSUAS; $i++) {
			$txtNo = $data->val($i,1,2);
			$txtKBM = $data->val($i,2,2);
			$txtNIS = $data->val($i,3,2);
			$txtNSis = $data->val($i,4,2);
			$txtUTS = $data->val($i,5,2);
			$txtUAS = $data->val($i,6,2);
			
			mysql_query("insert into n_utsuas values ('','$txtKBM','$txtNIS','$txtUTS','$txtUAS')");

		}

		//echo '<div id="preloader"><div id="cssload"></div></div>';
		echo ns("Ngimpor","parent.location='?page=$page'","$kbm");
	break;

	case "uploadk4":
		$kbm=isset($_GET['kbm'])?$_GET['kbm']:"";
		$guru=isset($_GET['guru'])?$_GET['guru']:"";
		$thnajaran=isset($_GET['thnajaran'])?$_GET['thnajaran']:"";
		$gg=isset($_GET['gg'])?$_GET['gg']:"";

		require_once "pages/excel_reader.php"; 

		// K4

		$data = new Spreadsheet_Excel_Reader($_FILES['k4']['tmp_name']);

		$NK4 = $data->rowcount($sheet_index=3);

		for ($i=2; $i<=$NK4; $i++) {
			$txtNo = $data->val($i,1,3);
			$txtKBM = $data->val($i,2,3);
			$txtNIS = $data->val($i,3,3);
			$txtNSis = $data->val($i,4,3);
			$txtKDK_1 = $data->val($i,5,3);
			$txtKDK_2 = $data->val($i,6,3);
			$txtKDK_3 = $data->val($i,7,3);
			$txtKDK_4 = $data->val($i,8,3);
			$txtKDK_5 = $data->val($i,9,3);
			$txtKDK_6 = $data->val($i,10,3);
			$txtKDK_7 = $data->val($i,11,3);
			$txtKDK_8 = $data->val($i,12,3);
			$txtKDK_9 = $data->val($i,13,3);
			$txtKDK_10 = $data->val($i,14,3);
			$txtKDK_11 = $data->val($i,15,3);
			$txtKDK_12 = $data->val($i,16,3);
			$txtKDK_13 = $data->val($i,17,3);
			$txtKDK_14 = $data->val($i,18,3);
			$txtKDK_15 = $data->val($i,19,3);

			$jmlKDK=JmlDt("select * from gmp_kikd where kode_ngajar='$kbm' and kode_ranah='KDK'");	
			$NHK=round(($txtKDK_1+$txtKDK_2+$txtKDK_3+$txtKDK_4+$txtKDK_5+$txtKDK_6+$txtKDK_7+$txtKDK_8+$txtKDK_9+$txtKDK_10+$txtKDK_11+$txtKDK_12+$txtKDK_13+$txtKDK_14+$txtKDK_15)/$jmlKDK);

			mysql_query("INSERT INTO n_k_kikd VALUES ('','$txtKBM','$txtNIS','$txtKDK_1','$txtKDK_2','$txtKDK_3','$txtKDK_4','$txtKDK_5','$txtKDK_6','$txtKDK_7','$txtKDK_8','$txtKDK_9','$txtKDK_10','$txtKDK_11','$txtKDK_12','$txtKDK_13','$txtKDK_14','$txtKDK_15','$NHK')");
		}

		//echo '<div id="preloader"><div id="cssload"></div></div>';
		echo ns("Ngimpor","parent.location='?page=$page'","$kbm");
	break;

	case "uploadabsen":
		$kbm=isset($_GET['kbm'])?$_GET['kbm']:"";
		$guru=isset($_GET['guru'])?$_GET['guru']:"";
		$thnajaran=isset($_GET['thnajaran'])?$_GET['thnajaran']:"";
		$gg=isset($_GET['gg'])?$_GET['gg']:"";

		require_once "pages/excel_reader.php"; 

		$data = new Spreadsheet_Excel_Reader($_FILES['absen']['tmp_name']);

		$Absen = $data->rowcount($sheet_index=4);

		for ($i=3; $i<=$Absen; $i++) {
			$txtNo = $data->val($i,1,4);
			$txtNIS = $data->val($i,2,4);
			$txtNSis = $data->val($i,3,4);
			$txtNsi = $data->val($i,4,4);
			$txtNTgl = $data->val($i,5,4);
			$txtNBln = $data->val($i,6,4);
			$txtNThn = $data->val($i,7,4);
			$txtNKet = $data->val($i,8,4);

			if($txtNTgl<10){$TglA="0".$txtNTgl;}else{$TglA=$txtNTgl;}
			if($txtNBln<10){$BlnA="0".$txtNBln;}else{$BlnA=$txtNBln;}
			$IsiTgl=$txtNThn."-".$BlnA."-".$TglA;
			
			$kd_absensi=buatKode("gmp_absensi","id_absen","abs_");
			if($txtNIS==""){}else{
			mysql_query("INSERT INTO gmp_absensi VALUES ('$kd_absensi','$kbm','$txtNIS','$txtNsi','$IsiTgl','$txtNKet')");
			}
		}
		echo ns("Ngimpor","parent.location='?page=$page'","$kbm");
	break;

	case "HapusNilaiK1K2":
		$kbm=isset($_GET['kbm'])?$_GET['kbm']:"";	
		mysql_query("DELETE FROM n_sikap WHERE kd_ngajar='$kbm'");
		echo ns("Hapus","parent.location='?page=$page'","$kbm");
	break;

	case "HapusNilaiK3":
		$kbm=isset($_GET['kbm'])?$_GET['kbm']:"";	
		mysql_query("DELETE FROM n_p_kikd WHERE kd_ngajar='$kbm'");			
		echo ns("Hapus","parent.location='?page=$page'","$kbm");
	break;

	case "HapusNilaiK4":
		$kbm=isset($_GET['kbm'])?$_GET['kbm']:"";	
		mysql_query("DELETE FROM n_k_kikd WHERE kd_ngajar='$kbm'");
		echo ns("Hapus","parent.location='?page=$page'","$kbm");
	break;

	case "HapusNilaiUTSUAS":
		$kbm=isset($_GET['kbm'])?$_GET['kbm']:"";	
		mysql_query("DELETE FROM n_utsuas WHERE kd_ngajar='$kbm'");
		echo ns("Hapus","parent.location='?page=$page'","$kbm");
	break;

	case "HapusAbsensi":
		$kbm=isset($_GET['kbm'])?$_GET['kbm']:"";	
		mysql_query("DELETE FROM gmp_absensi WHERE kd_ngajar='$kbm'");
		echo ns("Hapus","parent.location='?page=$page'","$kbm");
	break;

	case "HapusAll":
		$kbm=isset($_GET['kbm'])?$_GET['kbm']:"";	
		mysql_query("DELETE FROM n_utsuas WHERE kd_ngajar='$kbm'");
		mysql_query("DELETE FROM n_p_kikd WHERE kd_ngajar='$kbm'");
		mysql_query("DELETE FROM n_k_kikd WHERE kd_ngajar='$kbm'");
		mysql_query("DELETE FROM n_sikap WHERE kd_ngajar='$kbm'");
		mysql_query("DELETE FROM gmp_absensi WHERE kd_ngajar='$kbm'");

		echo ns("Hapus","parent.location='?page=$page'","$kbm");
	break;

	case "updateta":
		$thnajar=isset($_GET['thnajar'])?$_GET['thnajar']:"";
		mysql_query("update app_pilih_data set tahunajaran='$thnajar' where id_pil='$IDna'");
		echo ns("Milih","parent.location='?page=$page'","tahun ajaran $thnajar");
	break;

	case "updategg":
		$gg=isset($_GET['gg'])?$_GET['gg']:"";
		mysql_query("update app_pilih_data set semester='$gg' where id_pil='$IDna'");
		echo ns("Milih","parent.location='?page=$page'","Semester $gg");
	break;

	case "updategr":
		$gr=isset($_GET['gr'])?$_GET['gr']:"";
		NgambilData("select * from app_user_guru where id_guru='$gr'");
		mysql_query("update app_pilih_data set idguru='$gr' where id_pil='$IDna'");
		echo ns("Milih","parent.location='?page=$page'","$nama_lengkap");
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
<script type="text/javascript">
$(document).ready(function() {

	/* BASIC ;*/
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

	/* END BASIC */


})

</script>