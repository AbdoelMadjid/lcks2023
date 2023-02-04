<?php
require_once("inc/init.php");
require_once("inc/config.ui.php");
$page_title = "Penilaian";
$page_css[] = "your_style.css";
include("inc/header.php");
$page_nav["kbm"]["sub"]["penilaian"]["active"] = true;
include("inc/nav.php");
echo "<div id='main' role='main'>";
$breadcrumbs["Proses KBM"] = "";
include("inc/ribbon.php");

$sub=(isset($_GET['sub']))?$_GET['sub']:"";
switch($sub)
{
	case "tampil":default:
		$kbm=isset($_GET['kbm'])?$_GET['kbm']:""; 
		$QD=mysql_query("
		select 
		gmp_ngajar.id_ngajar,
		gmp_ngajar.thnajaran,
		gmp_ngajar.semester,
		gmp_ngajar.ganjilgenap,
		ak_kelas.nama_kelas,
		ak_matapelajaran.nama_mapel,
		ak_perkelas.nis,
		siswa_biodata.nm_siswa 
		from gmp_ngajar
		inner join ak_perkelas on gmp_ngajar.thnajaran=ak_perkelas.tahunajaran
		inner join ak_kelas on gmp_ngajar.kd_kelas=ak_kelas.kode_kelas and ak_kelas.nama_kelas=ak_perkelas.nm_kelas
		inner join app_user_guru on gmp_ngajar.kd_guru=app_user_guru.id_guru
		inner join ak_matapelajaran on gmp_ngajar.kd_mapel=ak_matapelajaran.kode_mapel
		inner join siswa_biodata on ak_perkelas.nis=siswa_biodata.nis
		where gmp_ngajar.id_ngajar='$kbm' order by siswa_biodata.nm_siswa,ak_perkelas.nis");

		$HDT=mysql_fetch_array($QD);
		$JDT=mysql_num_rows($QD);

		$DataKDS=mysql_query("select * from gmp_kikd where kode_ngajar='$kbm' and kode_ranah='KDS'");
		$DataKDP=mysql_query("select * from gmp_kikd where kode_ngajar='$kbm' and kode_ranah='KDP'");
		$DataKDK=mysql_query("select * from gmp_kikd where kode_ngajar='$kbm' and kode_ranah='KDK'");

		$jmlKDS=mysql_num_rows($DataKDS);
		$jmlKDP=mysql_num_rows($DataKDP);
		$jmlKDK=mysql_num_rows($DataKDK);

		if($jmlKDS==0 && $jmlKDP==0 && $jmlKDK==0){
			$Show.=ButtonKembali2("?page=gurumapel-data-penilaian","style='margin-top:-10px;'");
			$Show.=JudulKolom("Proses Nilai UTS UAS","edit");
			$Show.=nt("peringatan","<strong>Kompetensi Dasar </strong> belum di pilih silakan isi dulu <a href='?page=gmp-ki-kd'>Kompetensi Dasar Mata Pelajaran</a>.");
		}
		else
		{
			$QUTSUAS=mysql_query("select * from n_utsuas where kd_ngajar='$kbm'");
			$JmlhData=mysql_num_rows($QUTSUAS);
			if($JDT==$JmlhData){$Ulangi.="";}
			else if($JmlhData>$JDT)
			{
				$Ulangi.=nt("kesalahan","
				MOHON DI PERHATIKAN Data Siswa DOUBLE !!<br> 
				Jumlah Siswa Seharusnya $JDT orang, data double $JmlhData orang <br>Silakan pilih data yang double. Kemudian klik tombol hapus data terpilih di bagian bawah tabel.");
			}
			else{
				$Ulangi.=nt("kesalahan","MOHON DI PERHATIKAN Data Siswa belum lengkap !!!<br> 
				Jumlah Siswa Seharusnya $JDT orang, baru di input $JmlhData orang <br>Silakan Ulangi Input Data dengan menghapus data terlebih dahulu dengan klik tombol hapus di bawah ini");
				$Ulangi.="<div class='form-actions'><a href='?page=$page&sub=HapusNilai&kbm=$kbm' class='btn btn-info btn-sm'>Hapus</a></div></div><hr>";

			}
			
			if($JmlhData==$JDT){
//============================================================================[ PROSES EDIT DATA NILAI ]
				$Q=mysql_query("select n_utsuas.*,siswa_biodata.nm_siswa from n_utsuas,siswa_biodata where n_utsuas.nis=siswa_biodata.nis and kd_ngajar='$kbm' order by siswa_biodata.nm_siswa,siswa_biodata.nis");	

				$i=1;
				while($Hasil=mysql_fetch_array($Q)){
					if($Hasil['uts']>100 || $Hasil['uts']==0){$Warna1="style='background:#ffcccc;'";}else{$Warna1="";}
					if($Hasil['uas']>100 || $Hasil['uas']==0){$Warna2="style='background:#ffcccc;'";}else{$Warna2="";}

					$ShowNPData.="
					<tr>
						<td class='text-center'>$i.</td>
						<td>{$Hasil['nis']}</td>
						<td>{$Hasil['nm_siswa']}</td>
						<td class='text-center'>
							<input class='form-control input-sm' type='hidden' value='".$Hasil['kd_utsuas']."' name='txtKd[$i]'>
							<input class='form-control input-sm' type='hidden' value='".$kbm."' name='txtKBM[$i]'>
							<input class='form-control input-sm' type='hidden' value='".$Hasil['nis']."' name='txtNIS[$i]'>
							<input size='3' type='text' class='form-control input-sm' id='spinner-decimal[]' $Warna1 maxlength='3' value='".$Hasil['uts']."' name='txtUTS[$i]'>
						</td>
						<td class='text-center'>
							<input size='3' type='text' class='form-control input-sm' $Warna2 maxlength='3' value='".$Hasil['uas']."' name='txtUAS[$i]'>
						</td>
					</tr>";
					$i++;
				}
				$Show.=ButtonKembali2("?page=gurumapel-data-penilaian","style='margin-top:-10px;'");
				$Show.="<a href=\"javascript:;\" onClick=\"window.open('./pages/excel/ekspor-nilai.php?eksporex=nilai-utsuas&kbm=$kbm&mapel={$HDT['nama_mapel']}&kls={$HDT['nama_kelas']}&komp=utsuas')\" class='btn btn-default btn-sm pull-right' style='margin-top:-10px;margin-right:10px;' title='Download Nilai'><i class='fa fa-download'></i> <span class='hidden-xs'>Download Nilai</span></a>";
				$Show.="
				<div class='btn-group pull-right'>
					<button class='btn btn-default dropdown-toggle' data-toggle='dropdown' style='margin-top:-10px;margin-right:10px;'>
						<span class='label label-primary'>UTSUAS</span> <span class='hidden-xs'> UTS UAS </span><span class='caret'></span>
					</button>
					<ul class='dropdown-menu'>
						<li><a href='?page=gurumapel-nilai-sikap&kbm=$kbm'>Sikap</a>
						<li><a href='?page=gurumapel-nilai-pkikd&kbm=$kbm'>Pengetahuan</a>
						<li><a href='?page=gurumapel-nilai-utsuas&kbm=$kbm'>UTS UAS <i class='fa fa-check'></i></a>
						<li><a href='?page=gurumapel-nilai-kkikd&kbm=$kbm'>Keterampilan</a>
					</ul>
				</div>";
				$Show.=JudulKolom("Edit Nilai UTS UAS","edit");
				$Show.=KotakWell("
				<dl class='dl-horizontal' style='margin-bottom:0px;'>
				  <dt>Tahun Pelajaran : </dt><dd>{$HDT['thnajaran']}</dd>
				  <dt>Semester : </dt><dd>{$HDT['semester']} ({$HDT['ganjilgenap']})</dd>
				  <dt>Mata Pelajaran : </dt><dd>{$HDT['nama_mapel']}</dd>
				  <dt>Kelas : </dt><dd>{$HDT['nama_kelas']}</dd>
				</dl>","");

				$Show.="
				$Ulangi
				<form action='?page=$page&sub=simpanedit' method='post' name='FrmUTSUAS' id='FrmUTSUAS' role='form'>
				<div class='well no-padding'>
				<table id='dt_basic' class='table table-striped table-bordered table-hover table-condensed' width='100%'>
					<thead>
						<tr>
							<th class='text-center' data-class='expand'>No.</th>
							<th class='text-center'>NIS</th>
							<th class='text-center'>Nama Siswa</th>
							<th class='text-center' data-hide='phone'>UTS</th>
							<th class='text-center' data-hide='phone'>UAS</th>
						</tr>
					</thead>
					<tbody>$ShowNPData</tbody>
				</table>
				</div>";

				$Show.="<div class='form-actions'>";
				if($NgunciKBM=="Y"){
					$Show.="<span class='txt-color-red'><strong>Data Nilai Sudah Di Kunci!!</strong> <br><em>Silakan Hubungi Admin/Kurikulum</em></span>";
				}
				else
				{
					$Show.="<a href='?page=$page&sub=HapusNilai&kbm=$kbm' data-action='hapusnilaiutsuas' data-hapusnilaiutsuas-msg=\"Apakah Anda yakin akan mengapus nilai UTS UAS kbm <strong class='txt-color-orangeDark'>$kbm</strong>.\" class='btn btn-danger btn-sm'>Hapus Nilai</a> ".bSubmit("SaveUpdate","Update");
				}
				$Show.="</div></form>";
			}
			else if($JmlhData>$JDT)
			{
//============================================================================[ PROSES HAPUS DOUBLE NILAI]

				$Q=mysql_query("select n_utsuas.*,siswa_biodata.nm_siswa from n_utsuas,siswa_biodata where n_utsuas.nis=siswa_biodata.nis and kd_ngajar='$kbm' order by siswa_biodata.nis");	
				$i=1;
				while($Hasil=mysql_fetch_array($Q)){
					if($Hasil['uts']>100 || $Hasil['uts']==0){$Warna1="style='background:#ffcccc;'";}else{$Warna1="";}
					if($Hasil['uas']>100 || $Hasil['uas']==0){$Warna2="style='background:#ffcccc;'";}else{$Warna2="";}

					$ShowNPData.="
					<tr>
						<td class='text-center'>$i.</td>
						<td>{$Hasil['nis']}</td>
						<td>{$Hasil['nm_siswa']}</td>
						<td class='text-center'>".$Hasil['uts']."</td>
						<td class='text-center'>".$Hasil['uas']."</td>
						<td><label class='checkbox'><input type='checkbox' id='cekbox' name='cekbox[]' value='{$Hasil['kd_utsuas']}'><i></i></label></td>
					</tr>";
					$i++;
				}
				$Show.=ButtonKembali2("?page=gurumapel-data-penilaian","style='margin-top:-10px;'");
				$Show.="
				<div class='btn-group pull-right'>
					<button class='btn btn-default dropdown-toggle' data-toggle='dropdown' style='margin-top:-10px;margin-right:10px;'>
						<span class='label label-primary'>UTSUAS</span> <span class='hidden-xs'> UTS UAS </span><span class='caret'></span>
					</button>
					<ul class='dropdown-menu'>
						<li><a href='?page=gurumapel-nilai-sikap&kbm=$kbm'>Sikap</a>
						<li><a href='?page=gurumapel-nilai-pkikd&kbm=$kbm'>Pengetahuan</a>
						<li><a href='?page=gurumapel-nilai-utsuas&kbm=$kbm'>UTS UAS <i class='fa fa-check'></i></a>
						<li><a href='?page=gurumapel-nilai-kkikd&kbm=$kbm'>Keterampilan</a>
					</ul>
				</div>";
				$Show.=JudulKolom("Data Double","window-restore");
				$Show.=KotakWell("
				<dl class='dl-horizontal' style='margin-bottom:0px;'>
				  <dt>Tahun Pelajaran : </dt><dd>{$HDT['thnajaran']}</dd>
				  <dt>Semester : </dt><dd>{$HDT['semester']} ({$HDT['ganjilgenap']})</dd>
				  <dt>Mata Pelajaran : </dt><dd>{$HDT['nama_mapel']}</dd>
				  <dt>Kelas : </dt><dd>{$HDT['nama_kelas']}</dd>
				</dl>","");

				$Show.="
				<script> 
				function checkUncheckAll(theElement) 
				{
					var theForm=theElement.form, z=0;
					for(z=0; z<theForm.length;z++)
					{
						if(theForm[z].type == 'checkbox' && theForm[z].name != 'checkall')
						{
							theForm[z].checked=theElement.checked;
						}
					}
				}
				</script>

				$Ulangi
				<form action='?page=$page&sub=hapusbanyak&kbm=$kbm' method='post' class='smart-form'>
				<div class='well no-padding'>
				<table id='dt_basic' class='table table-striped table-bordered table-hover table-condensed' width='100%'>
					<thead>
						<tr>
							<th class='text-center' data-class='expand'>No.</th>
							<th class='text-center'>NIS</th>
							<th class='text-center'>Nama Siswa</th>
							<th class='text-center' data-hide='phone'>UTS</th>
							<th class='text-center' data-hide='phone'>UAS</th>
							<th class='text-center'>Pilih</th>
						</tr>
					</thead>
					<tbody>$ShowNPData</tbody>
				</table>
				</div>
				".FormCB("Pilih Semua","checkbox",'onclick="checkUncheckAll(this)";')."	";
				$Show.="<div class='form-actions'>";
				$Show.=bSubmit("SaveUpdate","Hapus Data Terpilih");
				$Show.="</div></form>";
			}
			else
			{
//============================================================================[ PROSES TAMBAH DATA NILAI ]
				$Q=mysql_query("
				select 
				gmp_ngajar.id_ngajar,
				gmp_ngajar.kd_guru,
				gmp_ngajar.semester,
				gmp_ngajar.thnajaran,
				ak_kelas.nama_kelas,
				ak_matapelajaran.nama_mapel,
				ak_perkelas.nis,
				siswa_biodata.nm_siswa 
				from gmp_ngajar
				inner join ak_perkelas on gmp_ngajar.thnajaran=ak_perkelas.tahunajaran
				inner join ak_kelas on gmp_ngajar.kd_kelas=ak_kelas.kode_kelas and ak_kelas.nama_kelas=ak_perkelas.nm_kelas
				inner join app_user_guru on gmp_ngajar.kd_guru=app_user_guru.id_guru
				inner join ak_matapelajaran on gmp_ngajar.kd_mapel=ak_matapelajaran.kode_mapel
				inner join siswa_biodata on ak_perkelas.nis=siswa_biodata.nis
				where gmp_ngajar.id_ngajar='$kbm' order by siswa_biodata.nm_siswa,ak_perkelas.nis");
				$i=1;
				while($Hasil=mysql_fetch_array($Q)){
					$kdguru=$Hasil['kd_guru'];
					$thajar=$Hasil['thnajaran'];
					$smester=$Hasil['semester'];

					$ShowNPData.="
					<tr>
						<td class='text-center'>$i.</td>
						<td>{$Hasil['nis']}</td>
						<td>{$Hasil['nm_siswa']}</td>
						<td class='text-center'>
							<input class='form-control input-sm' type='hidden' value='".$kbm."' name='txtKBM[$i]'>
							<input class='form-control input-sm' type='hidden' value='".$Hasil['nis']."' name='txtNIS[$i]'>
							<input size='3' type='text' class='form-control input-sm' maxlength='3' value='".$Hasil['uts']."' name='txtUTS[$i]'>
						</td>
						<td class='text-center'>
							<input size='3' type='text' class='form-control input-sm' maxlength='3' value='".$Hasil['uas']."' name='txtUAS[$i]'>
						</td>
					</tr>";
					$i++;
				}

				$Show.=ButtonKembali2("?page=gurumapel-data-penilaian","style='margin-top:-10px;'");
				$Show.="<a href='?page=$page&sub=upload_nilai&guru=$kdguru&thnajaran=$thajar&gg=$smester&kbm=$kbm' class='btn btn-default btn-sm pull-right' style='margin-top:-10px;margin-right:10px;' title='Upload Nilai UTS UAS'> <i class='fa fa-upload'></i> <span class='hidden-xs'>Upload Nilai UTS UAS</span></a>";
				$Show.="
				<div class='btn-group pull-right'>
					<button class='btn btn-default dropdown-toggle' data-toggle='dropdown' style='margin-top:-10px;margin-right:10px;'>
						<span class='label label-primary'>UTSUAS</span> <span class='hidden-xs'> UTS UAS </span><span class='caret'></span>
					</button>
					<ul class='dropdown-menu'>
						<li><a href='?page=gurumapel-nilai-sikap&kbm=$kbm'>Sikap</a>
						<li><a href='?page=gurumapel-nilai-pkikd&kbm=$kbm'>Pengetahuan</a>
						<li><a href='?page=gurumapel-nilai-utsuas&kbm=$kbm'>UTS UAS <i class='fa fa-check'></i></a>
						<li><a href='?page=gurumapel-nilai-kkikd&kbm=$kbm'>Keterampilan</a>
					</ul>
				</div>";
				$Show.=JudulKolom("Tambah Nilai UTS UAS","plus");
				$Show.=KotakWell("
				<dl class='dl-horizontal' style='margin-bottom:0px;'>
				  <dt>Tahun Pelajaran : </dt><dd>{$HDT['thnajaran']}</dd>
				  <dt>Semester : </dt><dd>{$HDT['semester']} ({$HDT['ganjilgenap']})</dd>
				  <dt>Mata Pelajaran : </dt><dd>{$HDT['nama_mapel']}</dd>
				  <dt>Kelas : </dt><dd>{$HDT['nama_kelas']}</dd>
				</dl>","");

				$Show.="
				<form action='?page=$page&sub=simpantambah' method='post' name='FrmUTSUAS' id='FrmUTSUAS' role='form'>
				<div class='well no-padding'>
				<table id='dt_basic' class='table table-striped table-bordered table-hover table-condensed' width='100%'>
					<thead>
						<tr>
							<th class='text-center' data-class='expand'>No.</th>
							<th class='text-center'>NIS</th>
							<th class='text-center'>Nama Siswa</th>
							<th class='text-center' data-hide='phone'>UTS</th>
							<th class='text-center' data-hide='phone'>UAS</th>
						</tr>
					</thead>
					<tbody>$ShowNPData</tbody>
				</table>
				</div>";
				$Show.="<div class='form-actions'>".bSubmit("SaveTambah","Simpan")."</div></form>";
			}
		}
		$tandamodal="#NgisiNilaiSiswa";
		echo $NgisiNilaiSiswa;
		echo IsiPanel($Show);
	break;

	case "simpanedit":
		foreach($_POST['txtKd'] as $i => $txtKd){
			$txtKBM=$_POST['txtKBM'][$i];
			$txtNIS=$_POST['txtNIS'][$i];
			$txtUTS=$_POST['txtUTS'][$i];
			$txtUAS=$_POST['txtUAS'][$i];
			mysql_query("UPDATE n_utsuas SET kd_ngajar='$txtKBM',nis='$txtNIS',uts='$txtUTS',uas='$txtUAS' WHERE kd_utsuas='$txtKd'");
			echo ns("Ngedit","parent.location='?page=$page&kbm=$txtKBM'","Nilai UTS dan UAS dengan Kode KBM <strong class='text-primary'>$txtKBM</strong>");
		}
	break;
	
	case "simpantambah":
		foreach($_POST['txtKBM'] as $i => $txtKBM){
			$txtNIS=$_POST['txtNIS'][$i];
			$txtUTS=$_POST['txtUTS'][$i];
			$txtUAS=$_POST['txtUAS'][$i];
			//$kd_nUTSUAS=buatKode("n_utsuas","ta_");
			mysql_query("INSERT INTO n_utsuas VALUES ('','$txtKBM','$txtNIS','$txtUTS','$txtUAS')");
			echo ns("Nambah","parent.location='?page=$page&kbm=$txtKBM'","Nilai UTS dan UAS dengan Kode KBM <strong class='text-primary'>$txtKBM</strong>");
		}
	break;

	case "HapusNilai":
		$kbm=isset($_GET['kbm'])?$_GET['kbm']:"";
		mysql_query("DELETE FROM n_utsuas WHERE kd_ngajar='$kbm'");
		echo ns("Hapus","parent.location='?page=$page&kbm=$kbm'","Nilai UTS dan UAS dengan Kode KBM <strong class='text-primary'>$kbm</strong>");
	break;

	case "hapusbanyak":
		$kbm=isset($_GET['kbm'])?$_GET['kbm']:"";
		$cekbox = $_POST['cekbox'];
		if ($cekbox) {
			foreach ($cekbox as $value) {
				mysql_query("DELETE FROM n_utsuas WHERE kd_utsuas='$value'");
				echo $value;
				echo ",";
			}
			echo ns("Hapus","parent.location='?page=$page&kbm=$kbm'","Nilai Double");
		}  else {
			echo ns("BelumMilih","parent.location='?page=$page&kbm=$kbm'","Nilai Double");
		}
	break;

	case "upload_nilai":
		$kbm=isset($_GET['kbm'])?$_GET['kbm']:"";
		$guru=isset($_GET['guru'])?$_GET['guru']:"";
		$thnajaran=isset($_GET['thnajaran'])?$_GET['thnajaran']:"";
		$gg=isset($_GET['gg'])?$_GET['gg']:"";

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
		
		$Keterangan.=nt("informasi","
		ID KBM <strong>{$H['id_ngajar']}</strong><br>Tahun Ajaran <strong>{$H['thnajaran']}</strong><br>Semester <strong>{$H['semester']}</strong><br>Kelas <strong>{$H['nama_kelas']}</strong><br>Mata Pelajaran <strong>{$H['nama_mapel']}</strong>","KBM");
	
		$UloadPerNilai.=JudulDalam("Nilai UTS UAS","");
		$UloadPerNilai.="
		<form name='myForm' id='myForm' onSubmit='return validateForm()' action='?page=$page&sub=simpanupload&guru=$guru&thnajaran=$thnajaran&gg=$gg&kbm=$kbm' method='post' enctype='multipart/form-data' class='smart-form'>
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
		
		$Show.=ButtonKembali2("?page=$page&kbm=$kbm","style='margin-top:-10px;'");
		$Show.=JudulKolom("Proses Upload Nilai","");
		$Show.=DuaKolomD(6,$Keterangan,6,KolomPanel($UloadPerNilai));

		echo $UploadNilaiMapel;
		echo IsiPanel($Show);
	break;

	case "simpanupload":
		$kbm=isset($_GET['kbm'])?$_GET['kbm']:"";
		$guru=isset($_GET['guru'])?$_GET['guru']:"";
		$thnajaran=isset($_GET['thnajaran'])?$_GET['thnajaran']:"";
		$gg=isset($_GET['gg'])?$_GET['gg']:"";

		require_once "pages/excel_reader.php"; 

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
		echo ns("Ngimpor","parent.location='?page=$page&kbm=$kbm'","$kbm");
	break;

}
echo '</div>';
include ("inc/footer.php");
include ("inc/scripts.php");
//"))
?>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/datatables/dataTables.colVis.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/datatables/dataTables.tableTools.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/datatables/dataTables.bootstrap.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/datatable-responsive/datatables.responsive.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	var a={
		"hapusnilaiutsuas":function(a){
			function b(){
				window.location=a.attr("href")
			}
			$.SmartMessageBox(
				{
					"title":"<h1 style='margin-top:-5px;'><i class='fa fa-fw fa-question-circle bounce animated text-primary'></i><small class='text-primary'><strong> Konfirmasi</strong></small></h1>",
					"content":a.data("hapusnilaiutsuas-msg"),
					"buttons":"[No][Yes]"
				},function(a){
					"Yes"==a&&($.root_.addClass("animated fadeOutUp"),setTimeout(b,1e3))
					}
		)}
	}
	$.root_.on("click",'[data-action="hapusnilaiutsuas"]',function(b){var c=$(this);a.hapusnilaiutsuas(c),b.preventDefault(),c=null});

	var d={
		"delnilsisutsuas":function(d){
			function e(){
				window.location=d.attr("href")
			}
			$.SmartMessageBox(
				{
					"title":"<h1 style='margin-top:-5px;'><i class='fa fa-fw fa-question-circle bounce animated text-primary'></i><small class='text-primary'><strong> Konfirmasi</strong></small></h1>",
					"content":d.data("delnilsisutsuas-msg"),
					"buttons":"[No][Yes]"
				},function(d){
					"Yes"==d&&($.root_.addClass("animated fadeOutUp"),setTimeout(e,1e3))
					}
		)}
	}
	$.root_.on("click",'[data-action="delnilsisutsuas"]',function(e){var f=$(this);d.delnilsisutsuas(f),e.preventDefault(),f=null});

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