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
			$Show.=JudulKolom("Proses Nilai Keterampilan","edit");
			$Show.=nt("peringatan","<strong>Kompetensi Dasar </strong> belum di pilih","silakan isi dulu <a href='?page=gmp-ki-kd'>Kompetensi Dasar Mata Pelajaran</a>.");
		}
		else{
			$QPKIKD=mysql_query("select * from n_k_kikd where kd_ngajar='$kbm'");
			$JmlhData=mysql_num_rows($QPKIKD);
			$HSKIKD=mysql_fetch_array($QPKIKD);

			if($JDT==$JmlhData){$Ulangi.="";}
			else if($JmlhData>$JDT)
			{
				$Ulangi.=nt("kesalahan","
				MOHON DI PERHATIKAN Data Siswa DOUBLE !!<br> 
				Jumlah Siswa Seharusnya $JDT orang, data double $JmlhData orang <br>Silakan pilih data yang double. Kemudian klik tombol hapus data terpilih di bagian bawah tabel.");
			}
			else
			{
				$Ulangi.=nt("kesalahan","MOHON DI PERHATIKAN Data Siswa belum lengkap !!!<br> 
				Jumlah Siswa Seharusnya $JDT orang, baru di input $JmlhData orang <br>Silakan Ulangi Input Data dengan menghapus data terlebih dahulu dengan klik tombol hapus di bawah ini");
				$Ulangi.="<div class='form-actions'><a href='?page=$page&sub=HapusNilai&kbm=$kbm' class='btn btn-info btn-sm'>Hapus</a></div></div><hr>";

			}

			if($JmlhData==$JDT){
//============================================================================[ PROSES EDIT DATA NILAI ]
				$Q=mysql_query("select n_k_kikd.*,siswa_biodata.nm_siswa from n_k_kikd,siswa_biodata where n_k_kikd.nis=siswa_biodata.nis and kd_ngajar='$kbm' order by siswa_biodata.nm_siswa,siswa_biodata.nis");	
				$i=1;
				while($Hasil=mysql_fetch_array($Q)){
					$ShowNKData.="<tr>
						<td class='text-center'>$i.</td>
						<td>{$Hasil['nis']}</td>
						<td>{$Hasil['nm_siswa']}
							<input class='form-control input-sm' type='hidden' value='".$Hasil['kd_k_kikd']."' name='txtKd[$i]'>
							<input class='form-control input-sm' type='hidden' value='".$kbm."' name='txtKBM[$i]'>
							<input class='form-control input-sm' type='hidden' value='".$Hasil['nis']."' name='txtNIS[$i]'>
							<input type='hidden'  value='".$jmlKDK."' name='txtTKDK[$i]'>						
						</td>";
					for($x=1;$x<$jmlKDK+1;$x++){
						if($Hasil['kd_'.$x]>100 || $Hasil['kd_'.$x]==0){$Warna="style='background:#ffcccc;'";}else{$Warna="";}
						$ShowNKData.="
						<td><input size='3' type='text' class='form-control input-sm' $Warna maxlength='3' value='".$Hasil['kd_'.$x]."' name='txtKDK_".$x."[$i]'></td>";
					}
					$ShowNKData.="</tr>";
					$i++;
				}
				$Show.=ButtonKembali2("?page=gurumapel-data-penilaian","style='margin-top:-10px;'");
				$Show.="<a href=\"javascript:;\" onClick=\"window.open('./pages/excel/ekspor-nilai.php?eksporex=nilai-mapel&kbm=$kbm&mapel={$HDT['nama_mapel']}&kls={$HDT['nama_kelas']}&komp=keterampilan')\" class='btn btn-default btn-sm pull-right' style='margin-top:-10px;margin-right:10px;' title='Download Nilai'><i class='fa fa-download'></i> <span class='hidden-xs'>Download Nilai</span></a>";
				$Show.="
				<div class='btn-group pull-right'>
					<button class='btn btn-default dropdown-toggle' data-toggle='dropdown' style='margin-top:-10px;margin-right:10px;'>
						<span class='label label-primary'>K4</span> <span class='hidden-xs'> Keterampilan </span><span class='caret'></span>
					</button>
					<ul class='dropdown-menu'>
						<li><a href='?page=gurumapel-nilai-sikap&kbm=$kbm'>Sikap</a>
						<li><a href='?page=gurumapel-nilai-pkikd&kbm=$kbm'>Pengetahuan</a>
						<li><a href='?page=gurumapel-nilai-utsuas&kbm=$kbm'>UTS UAS</a>
						<li><a href='?page=gurumapel-nilai-kkikd&kbm=$kbm'>Keterampilan <i class='fa fa-check'></i></a>
					</ul>
				</div>";
				$Show.=JudulKolom("Edit Nilai Keterampilan","edit");
				$Show.=KotakWell("
				<dl class='dl-horizontal' style='margin-bottom:0px;'>
				  <dt>Tahun Pelajaran : </dt><dd>{$HDT['thnajaran']}</dd>
				  <dt>Semester : </dt><dd>{$HDT['semester']} ({$HDT['ganjilgenap']})</dd>
				  <dt>Mata Pelajaran : </dt><dd>{$HDT['nama_mapel']}</dd>
				  <dt>Kelas : </dt><dd>{$HDT['nama_kelas']}</dd>
				</dl>","");

				for($x=1;$x<$jmlKDK+1;$x++){
					$NKIKDK.="<th class='text-center' data-hide='phone'>KIKD $x</th>";
				}						

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
							$NKIKDK
						</tr>
					</thead>
					<tbody>$ShowNKData</tbody>
				</table>
				</div>";
				$Show.="<div class='form-actions'>";
				if($NgunciKBM=="Y"){
					$Show.="<span class='txt-color-red'><strong>Data Nilai Sudah Di Kunci!!</strong> <br><em>Silakan Hubungi Admin/Kurikulum</em></span>";
				}
				else
				{
					$Show.="<a href='?page=$page&sub=HapusNilai&kbm=$kbm' data-action='hapusnilaik' data-hapusnilaik-msg=\"Apakah Anda yakin akan mengapus nilai Keterampilan kbm <strong class='txt-color-orangeDark'>$kbm</strong>.\" class='btn btn-danger btn-sm'>Hapus Nilai</a>
					".bSubmit("SaveUpdate","Update");
				}
				$Show.="</div></form>";
			}
			else if($JmlhData>$JDT){
//============================================================================[ PROSES HAPUS DOUBLE DATA NILAI ]
				$Q=mysql_query("select n_k_kikd.*,siswa_biodata.nm_siswa from n_k_kikd,siswa_biodata where n_k_kikd.nis=siswa_biodata.nis and kd_ngajar='$kbm' order by siswa_biodata.nm_siswa,siswa_biodata.nis");	
				$i=1;
				while($Hasil=mysql_fetch_array($Q)){
					$ShowNKData.="<tr>
						<td class='text-center'>$i.</td>
						<td>{$Hasil['nis']}</td>
						<td>{$Hasil['nm_siswa']}
							<input class='form-control input-sm' type='hidden' value='".$Hasil['kd_k_kikd']."' name='txtKd[$i]'>
							<input class='form-control input-sm' type='hidden' value='".$kbm."' name='txtKBM[$i]'>
							<input class='form-control input-sm' type='hidden' value='".$Hasil['nis']."' name='txtNIS[$i]'>
							<input type='hidden'  value='".$jmlKDK."' name='txtTKDK[$i]'>						
						</td>";
					for($x=1;$x<$jmlKDK+1;$x++){
						if($Hasil['kd_'.$x]>100 || $Hasil['kd_'.$x]==0){$Warna="style='background:#ffcccc;'";}else{$Warna="";}
						$ShowNKData.="
						<td>".$Hasil['kd_'.$x]."</td>";
					}
					$ShowNKData.="<td><label class='checkbox'><input type='checkbox' id='cekbox' name='cekbox[]' value='{$Hasil['kd_k_kikd']}'><i></i></label></td></tr>";
					$i++;
				}

				$Show.=ButtonKembali2("?page=gurumapel-data-penilaian","style='margin-top:-10px;'");
				$Show.="
				<div class='btn-group pull-right'>
					<button class='btn btn-default dropdown-toggle' data-toggle='dropdown' style='margin-top:-10px;margin-right:10px;'>
						<span class='label label-primary'>K4</span> <span class='hidden-xs'> Keterampilan </span><span class='caret'></span>
					</button>
					<ul class='dropdown-menu'>
						<li><a href='?page=gurumapel-nilai-sikap&kbm=$kbm'>Sikap</a>
						<li><a href='?page=gurumapel-nilai-pkikd&kbm=$kbm'>Pengetahuan</a>
						<li><a href='?page=gurumapel-nilai-utsuas&kbm=$kbm'>UTS UAS</a>
						<li><a href='?page=gurumapel-nilai-kkikd&kbm=$kbm'>Keterampilan <i class='fa fa-check'></i></a>
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

				for($x=1;$x<$jmlKDK+1;$x++){
					$NKIKDK.="<th class='text-center' data-hide='phone'>KIKD $x</th>";
				}						

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
							$NKIKDK
							<th class='text-center'>Pilih</th>
						</tr>
					</thead>
					<tbody>$ShowNKData</tbody>
				</table>
				</div>
				".FormCB("Pilih Semua","checkbox",'onclick="checkUncheckAll(this)";')."	";
				$Show.="<div class='form-actions'>";
				$Show.=bSubmit("SaveUpdate","Hapus Data Terpilih");
				$Show.="</div></form>";
			}
			else{
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

					$ShowNKData.="<tr>
						<td class='text-center'>$i.</td>
						<td>{$Hasil['nis']}</td>
						<td>{$Hasil['nm_siswa']}
							<input class='form-control input-sm' type='hidden' value='".$kbm."' name='txtKBM[$i]'>
							<input class='form-control input-sm' type='hidden' value='".$Hasil['nis']."' name='txtNIS[$i]'>
							<input type='hidden' name='txtTKDK[$i]' value='".$jmlKDK."'>					
						</td>";
					for($x=1;$x<$jmlKDK+1;$x++){
						$ShowNKData.="
						<td><input size='3' type='text' class='form-control input-sm' maxlength='3' name='txtKDK_".$x."[$i]'></td>";
					}						
					$ShowNKData.="</tr>";
					$i++;
				}

				$Show.=ButtonKembali2("?page=gurumapel-data-penilaian","style='margin-top:-10px;'");
				$Show.="<a href='?page=$page&sub=upload_nilai&guru=$kdguru&thnajaran=$thajar&gg=$smester&kbm=$kbm' class='btn btn-default btn-sm pull-right' style='margin-top:-10px;margin-right:10px;' title='Upload Nilai Keterampilan'> <i class='fa fa-upload'></i> <span class='hidden-xs'>Upload Nilai Keterampilan</span></a>";
				$Show.="
				<div class='btn-group pull-right'>
					<button class='btn btn-default dropdown-toggle' data-toggle='dropdown' style='margin-top:-10px;margin-right:10px;'>
						<span class='label label-primary'>K4</span> <span class='hidden-xs'> Keterampilan </span><span class='caret'></span>
					</button>
					<ul class='dropdown-menu'>
						<li><a href='?page=gurumapel-nilai-sikap&kbm=$kbm'>Sikap</a>
						<li><a href='?page=gurumapel-nilai-pkikd&kbm=$kbm'>Pengetahuan</a>
						<li><a href='?page=gurumapel-nilai-utsuas&kbm=$kbm'>UTS UAS</a>
						<li><a href='?page=gurumapel-nilai-kkikd&kbm=$kbm'>Keterampilan <i class='fa fa-check'></i></a>
					</ul>
				</div>";
				$Show.=JudulKolom("Tambah Nilai Keterampilan","plus");
				$Show.=KotakWell("
				<dl class='dl-horizontal' style='margin-bottom:0px;'>
				  <dt>Tahun Pelajaran : </dt><dd>{$HDT['thnajaran']}</dd>
				  <dt>Semester : </dt><dd>{$HDT['semester']} ({$HDT['ganjilgenap']})</dd>
				  <dt>Mata Pelajaran : </dt><dd>{$HDT['nama_mapel']}</dd>
				  <dt>Kelas : </dt><dd>{$HDT['nama_kelas']}</dd>
				</dl>","");

				for($x=1;$x<$jmlKDK+1;$x++){
					$NKIKDK.="<th class='text-center' data-hide='phone'>KIKD $x</th>";
				}						

				$Show.="
				<form action='?page=$page&sub=simpantambah' method='post' name='FrmKet' id='FrmKet' role='form'>
				<div class='well no-padding'>
				<table id='dt_basic' class='table table-striped table-bordered table-hover table-condensed' width='100%'>
					<thead>
						<tr>
							<th class='text-center' data-class='expand'>No.</th>
							<th class='text-center'>NIS</th>
							<th class='text-center'>Nama Siswa</th>
							$NKIKDK
						</tr>
					</thead>
					<tbody>$ShowNKData</tbody>
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
			$txtKDK_1=$_POST['txtKDK_1'][$i];
			$txtKDK_2=$_POST['txtKDK_2'][$i];
			$txtKDK_3=$_POST['txtKDK_3'][$i];
			$txtKDK_4=$_POST['txtKDK_4'][$i];
			$txtKDK_5=$_POST['txtKDK_5'][$i];
			$txtKDK_6=$_POST['txtKDK_6'][$i];
			$txtKDK_7=$_POST['txtKDK_7'][$i];
			$txtKDK_8=$_POST['txtKDK_8'][$i];
			$txtKDK_9=$_POST['txtKDK_9'][$i];
			$txtKDK_10=$_POST['txtKDK_10'][$i];
			$txtKDK_11=$_POST['txtKDK_11'][$i];
			$txtKDK_12=$_POST['txtKDK_12'][$i];
			$txtKDK_13=$_POST['txtKDK_13'][$i];
			$txtKDK_14=$_POST['txtKDK_14'][$i];
			$txtKDK_15=$_POST['txtKDK_15'][$i];
			$txtTKDK=$_POST['txtTKDK'][$i];
			$NHP=round(($txtKDK_1+$txtKDK_2+$txtKDK_3+$txtKDK_4+$txtKDK_5+$txtKDK_6+$txtKDK_7+$txtKDK_8+$txtKDK_9+$txtKDK_10+$txtKDK_11+$txtKDK_12+$txtKDK_13+$txtKDK_14+$txtKDK_15)/$txtTKDK);
			mysql_query("UPDATE n_k_kikd SET kd_ngajar='$txtKBM',nis='$txtNIS',kd_1='$txtKDK_1',kd_2='$txtKDK_2',kd_3='$txtKDK_3',kd_4='$txtKDK_4',kd_5='$txtKDK_5',kd_6='$txtKDK_6',kd_7='$txtKDK_7',kd_8='$txtKDK_8',kd_9='$txtKDK_9',kd_10='$txtKDK_10',kd_11='$txtKDK_11',kd_12='$txtKDK_12',kd_13='$txtKDK_13',kd_14='$txtKDK_14',kd_15='$txtKDK_15',kikd_k='$NHP' WHERE kd_k_kikd='$txtKd'");
			echo ns("Ngedit","parent.location='?page=$page&kbm=$txtKBM'","Nilai Keterampilan dengan Kode KBM <strong class='text-primary'>$txtKBM </strong>");
		}
	break;

	case "simpantambah":
		foreach($_POST['txtNIS'] as $i => $txtNIS){
			$txtKBM=$_POST['txtKBM'][$i];
			$txtKDK_1=$_POST['txtKDK_1'][$i];
			$txtKDK_2=$_POST['txtKDK_2'][$i];
			$txtKDK_3=$_POST['txtKDK_3'][$i];
			$txtKDK_4=$_POST['txtKDK_4'][$i];
			$txtKDK_5=$_POST['txtKDK_5'][$i];
			$txtKDK_6=$_POST['txtKDK_6'][$i];
			$txtKDK_7=$_POST['txtKDK_7'][$i];
			$txtKDK_8=$_POST['txtKDK_8'][$i];
			$txtKDK_9=$_POST['txtKDK_9'][$i];
			$txtKDK_10=$_POST['txtKDK_10'][$i];
			$txtKDK_11=$_POST['txtKDK_11'][$i];
			$txtKDK_12=$_POST['txtKDK_12'][$i];
			$txtKDK_13=$_POST['txtKDK_13'][$i];
			$txtKDK_14=$_POST['txtKDK_14'][$i];
			$txtKDK_15=$_POST['txtKDK_15'][$i];
			$txtTKDK=$_POST['txtTKDK'][$i];
			//$kd_nKet=buatKode("n_k_kikd","nk_");
			$NHP=round(($txtKDK_1+$txtKDK_2+$txtKDK_3+$txtKDK_4+$txtKDK_5+$txtKDK_6+$txtKDK_7+$txtKDK_8+$txtKDK_9+$txtKDK_10+$txtKDK_11+$txtKDK_12+$txtKDK_13+$txtKDK_14+$txtKDK_15)/$txtTKDK);
			mysql_query("INSERT INTO n_k_kikd VALUES ('','$txtKBM','$txtNIS','$txtKDK_1','$txtKDK_2','$txtKDK_3','$txtKDK_4','$txtKDK_5','$txtKDK_6','$txtKDK_7','$txtKDK_8','$txtKDK_9','$txtKDK_10','$txtKDK_11','$txtKDK_12','$txtKDK_13','$txtKDK_14','$txtKDK_15','$NHP')");
			echo ns("Nambah","parent.location='?page=$page&kbm=$txtKBM'","Nilai Keterampilan dengan Kode KBM <strong class='text-primary'>$txtKBM</strong>");
		}
	break;
	
	case "HapusNilai":
		$kbm=isset($_GET['kbm'])?$_GET['kbm']:"";		
		mysql_query("DELETE FROM n_k_kikd WHERE kd_ngajar='$kbm'");
		echo ns("Hapus","parent.location='?page=$page&kbm=$kbm'","Nilai Keterampilan dengan Kode KBM <strong class='text-primary'>$kbm</strong>");
	break;

	case "hapusbanyak":
		$kbm=isset($_GET['kbm'])?$_GET['kbm']:"";
		$cekbox = $_POST['cekbox'];
		if ($cekbox) {
			foreach ($cekbox as $value) {
				mysql_query("DELETE FROM n_k_kikd WHERE kd_k_kikd='$value'");
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
	
		$UloadPerNilai.=JudulDalam("Nilai Keterampilan","");
		$UloadPerNilai.="
		<form name='myForm' id='myForm' onSubmit='return validateForm()' action='?page=$page&sub=simpanupload&guru=$guru&thnajaran=$thnajaran&gg=$gg&kbm=$kbm' method='post' enctype='multipart/form-data' class='smart-form'>
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
<script src="<?php echo ASSETS_URL; ?>/js/plugin/jquery-form/jquery-form.min.js"></script>

<script type="text/javascript">
$(document).ready(function() {
	var a={
		"hapusnilaik":function(a){
			function b(){
				window.location=a.attr("href")
			}
			$.SmartMessageBox(
				{
					"title":"<h1 style='margin-top:-5px;'><i class='fa fa-fw fa-question-circle bounce animated text-primary'></i><small class='text-primary'><strong> Konfirmasi</strong></small></h1>",
					"content":a.data("hapusnilaik-msg"),
					"buttons":"[No][Yes]"
				},function(a){
					"Yes"==a&&($.root_.addClass("animated fadeOutUp"),setTimeout(b,1e3))
					}
		)}
	}
	$.root_.on("click",'[data-action="hapusnilaik"]',function(b){var c=$(this);a.hapusnilaik(c),b.preventDefault(),c=null});

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
