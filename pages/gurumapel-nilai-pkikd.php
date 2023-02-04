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
			$Show.=JudulKolom("Proses Nilai Pengetahuan","edit");
			$Show.=nt("peringatan","<strong>Kompetensi Dasar </strong> belum di pilih","silakan isi dulu <a href='?page=gmp-ki-kd'>Kompetensi Dasar Mata Pelajaran</a>.");
		}
		else{
			$QPKIKD=mysql_query("select * from n_p_kikd where kd_ngajar='$kbm'");
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
				$Q=mysql_query("select n_p_kikd.*,siswa_biodata.nm_siswa from n_p_kikd,siswa_biodata where n_p_kikd.nis=siswa_biodata.nis and kd_ngajar='$kbm' order by siswa_biodata.nm_siswa,siswa_biodata.nis");	
				$i=1;
				while($Hasil=mysql_fetch_array($Q)){
					$ShowNPData.="<tr>
						<td class='text-center'>$i.</td>
						<td>{$Hasil['nis']}</td>
						<td>{$Hasil['nm_siswa']}
							<input class='form-control input-sm' type='hidden' value='".$Hasil['kd_p_kikd']."' name='txtKd[$i]'>
							<input class='form-control input-sm' type='hidden' value='".$kbm."' name='txtKBM[$i]'>
							<input class='form-control input-sm' type='hidden' value='".$Hasil['nis']."' name='txtNIS[$i]'>
							<input type='hidden' value='".$jmlKDP."' name='txtTKDP[$i]'>						
						</td>";
					for($x=1;$x<$jmlKDP+1;$x++){
						if($Hasil['kd_'.$x]>100 || $Hasil['kd_'.$x]==0){$Warna="style='background:#ffcccc;'";}else{$Warna="";}
						$ShowNPData.="
						<td><input size='3' type='text' class='form-control input-sm' $Warna maxlength='3' value='".$Hasil['kd_'.$x]."' name='txtKDP_".$x."[$i]'></td>";
					}						
					$ShowNPData.="</tr>";
					$i++;
				}
				$Show.=ButtonKembali2("?page=gurumapel-data-penilaian","style='margin-top:-10px;'");
				$Show.="<a href=\"javascript:;\" onClick=\"window.open('./pages/excel/ekspor-nilai.php?eksporex=nilai-mapel&kbm=$kbm&mapel={$HDT['nama_mapel']}&kls={$HDT['nama_kelas']}&komp=pengetahuan')\" class='btn btn-default btn-sm pull-right' style='margin-top:-10px;margin-right:10px;' title='Download Nilai'><i class='fa fa-download'></i> <span class='hidden-xs'>Download Nilai</span></a>";
				$Show.="
				<div class='btn-group pull-right'>
					<button class='btn btn-default dropdown-toggle' data-toggle='dropdown' style='margin-top:-10px;margin-right:10px;'>
						<span class='label label-primary'>K3</span> <span class='hidden-xs'> Pengetahuan </span><span class='caret'></span>
					</button>
					<ul class='dropdown-menu'>
						<li><a href='?page=gurumapel-nilai-sikap&kbm=$kbm'>Sikap</a>
						<li><a href='?page=gurumapel-nilai-pkikd&kbm=$kbm'>Pengetahuan <i class='fa fa-check'></i></a>
						<li><a href='?page=gurumapel-nilai-utsuas&kbm=$kbm'>UTS UAS</a>
						<li><a href='?page=gurumapel-nilai-kkikd&kbm=$kbm'>Keterampilan</a>
					</ul>
				</div>";
				$Show.=JudulKolom("Edit Nilai Pengetahuan","edit");
				$Show.=KotakWell("
				<dl class='dl-horizontal' style='margin-bottom:0px;'>
				  <dt>Tahun Pelajaran : </dt><dd>{$HDT['thnajaran']}</dd>
				  <dt>Semester : </dt><dd>{$HDT['semester']} ({$HDT['ganjilgenap']})</dd>
				  <dt>Mata Pelajaran : </dt><dd>{$HDT['nama_mapel']}</dd>
				  <dt>Kelas : </dt><dd>{$HDT['nama_kelas']}</dd>
				</dl>","");

				for($x=1;$x<$jmlKDP+1;$x++){
					$NKIKDP.="<th class='text-center' data-hide='phone'>KIKD $x</th>";
				}						

				$Show.="
				$Ulangi
				<form action='?page=$page&sub=simpanedit' method='post' name='FrmK3' id='FrmK3' role='form'>
				<div class='well no-padding'>
				<table id='dt_basic' class='table table-striped table-bordered table-hover table-condensed' width='100%'>
					<thead>
						<tr>
							<th class='text-center' data-class='expand'>No.</th>
							<th class='text-center'>NIS</th>
							<th class='text-center'>Nama Siswa</th>
							$NKIKDP
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
					$Show.="<a href='?page=$page&sub=HapusNilai&kbm=$kbm' data-action='hapusnilaip' data-hapusnilaip-msg=\"Apakah Anda yakin akan mengapus nilai Pengetahuan kbm <strong class='txt-color-orangeDark'>$kbm</strong>.\" class='btn btn-danger btn-sm'>Hapus Nilai</a> ".bSubmit("SaveUpdate","Update");
				}
				$Show.="</div></form>";
			}
			else if($JmlhData>$JDT){
//============================================================================[ PROSES HAPUS DOUBLE DATA NILAI ]
				$Q=mysql_query("select n_p_kikd.*,siswa_biodata.nm_siswa from n_p_kikd,siswa_biodata where n_p_kikd.nis=siswa_biodata.nis and kd_ngajar='$kbm' order by siswa_biodata.nm_siswa,siswa_biodata.nis");	
				$i=1;
				while($Hasil=mysql_fetch_array($Q)){
					$ShowNPData.="<tr>
						<td class='text-center'>$i.</td>
						<td>{$Hasil['nis']}</td>
						<td>{$Hasil['nm_siswa']}
							<input class='form-control input-sm' type='hidden' value='".$Hasil['kd_p_kikd']."' name='txtKd[$i]'>
							<input class='form-control input-sm' type='hidden' value='".$kbm."' name='txtKBM[$i]'>
							<input class='form-control input-sm' type='hidden' value='".$Hasil['nis']."' name='txtNIS[$i]'>
							<input type='hidden' value='".$jmlKDP."' name='txtTKDP[$i]'>						
						</td>";
					for($x=1;$x<$jmlKDP+1;$x++){
						if($Hasil['kd_'.$x]>100 || $Hasil['kd_'.$x]==0){$Warna="style='background:#ffcccc;'";}else{$Warna="";}
						$ShowNPData.="
						<td>".$Hasil['kd_'.$x]."</td>";
					}						
					$ShowNPData.="<td><label class='checkbox'><input type='checkbox' id='cekbox' name='cekbox[]' value='{$Hasil['kd_p_kikd']}'><i></i></label></td>
					</tr>";
					$i++;
				}
				$Show.=ButtonKembali2("?page=gurumapel-data-penilaian","style='margin-top:-10px;'");
				$Show.="
				<div class='btn-group pull-right'>
					<button class='btn btn-default dropdown-toggle' data-toggle='dropdown' style='margin-top:-10px;margin-right:10px;'>
						<span class='label label-primary'>K3</span> <span class='hidden-xs'> Pengetahuan </span><span class='caret'></span>
					</button>
					<ul class='dropdown-menu'>
						<li><a href='?page=gurumapel-nilai-sikap&kbm=$kbm'>Sikap</a>
						<li><a href='?page=gurumapel-nilai-pkikd&kbm=$kbm'>Pengetahuan <i class='fa fa-check'></i></a>
						<li><a href='?page=gurumapel-nilai-utsuas&kbm=$kbm'>UTS UAS</a>
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

				for($x=1;$x<$jmlKDP+1;$x++){
					$NKIKDP.="<th class='text-center' data-hide='phone'>KIKD $x</th>";
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
							$NKIKDP
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

					$ShowNPData.="<tr>
						<td class='text-center'>$i.</td>
						<td>{$Hasil['nis']}</td>
						<td>{$Hasil['nm_siswa']}
							<input class='form-control input-sm' type='hidden' value='".$kbm."' name='txtKBM[$i]'>
							<input class='form-control input-sm' type='hidden' value='".$Hasil['nis']."' name='txtNIS[$i]'>
							<input type='hidden' name='txtTKDP[$i]' value='".$jmlKDP."'>					
						</td>";
					for($x=1;$x<$jmlKDP+1;$x++){
						$ShowNPData.="
						<td><input size='3' type='text' class='form-control input-sm' maxlength='3' name='txtKDP_".$x."[$i]'></td>";
					}						
					$ShowNPData.="</tr>";
					$i++;
				}
				$Show.=ButtonKembali2("?page=gurumapel-data-penilaian","style='margin-top:-10px;'");
				$Show.="<a href='?page=$page&sub=upload_nilai&guru=$kdguru&thnajaran=$thajar&gg=$smester&kbm=$kbm' class='btn btn-default btn-sm pull-right' style='margin-top:-10px;margin-right:10px;' tittle='Upload Nilai Pengetahuan'> <i class='fa fa-upload'></i> <span class='hidden-xs'>Upload Nilai Pengetahuan</span></a>";
				$Show.="
				<div class='btn-group pull-right'>
					<button class='btn btn-default dropdown-toggle' data-toggle='dropdown' style='margin-top:-10px;margin-right:10px;'>
						<span class='label label-primary'>K3</span> <span class='hidden-xs'> Pengetahuan </span><span class='caret'></span>
					</button>
					<ul class='dropdown-menu'>
						<li><a href='?page=gurumapel-nilai-sikap&kbm=$kbm'>Sikap</a>
						<li><a href='?page=gurumapel-nilai-pkikd&kbm=$kbm'>Pengetahuan <i class='fa fa-check'></i></a>
						<li><a href='?page=gurumapel-nilai-utsuas&kbm=$kbm'>UTS UAS</a>
						<li><a href='?page=gurumapel-nilai-kkikd&kbm=$kbm'>Keterampilan</a>
					</ul>
				</div>";
				$Show.=JudulKolom("Tambah Nilai Pengetahuan","plus");
				$Show.=KotakWell("
				<dl class='dl-horizontal' style='margin-bottom:0px;'>
				  <dt>Tahun Pelajaran : </dt><dd>{$HDT['thnajaran']}</dd>
				  <dt>Semester : </dt><dd>{$HDT['semester']} ({$HDT['ganjilgenap']})</dd>
				  <dt>Mata Pelajaran : </dt><dd>{$HDT['nama_mapel']}</dd>
				  <dt>Kelas : </dt><dd>{$HDT['nama_kelas']}</dd>
				</dl>","");

				for($x=1;$x<$jmlKDP+1;$x++){
					$NKIKDP.="<th class='text-center' data-hide='phone'>KIKD $x</th>";
				}	

				$Show.="
				<form action='?page=$page&sub=simpantambah' method='post' name='FrmPeng' id='FrmPeng' role='form'>
				<div class='well no-padding'>
				<table id='dt_basic' class='table table-striped table-bordered table-hover table-condensed' width='100%'>
					<thead>
						<tr>
							<th class='text-center' data-class='expand'>No.</th>
							<th class='text-center'>NIS</th>
							<th class='text-center'>Nama Siswa</th>
							$NKIKDP
						</tr>
					</thead>
					<tbody>$ShowNPData</tbody>
				</table>
				</div>";
				$Show.="<div class='form-actions'>".bSubmit("SaveTambah","Simpan")."</div></form>";
			}
		}
		echo IsiPanel($Show);
		$tandamodal="#NgisiNilaiSiswa";
		echo $NgisiNilaiSiswa;
	break;

	case "simpantambah":
		foreach($_POST['txtKBM'] as $i => $txtKBM){
			$txtNIS=$_POST['txtNIS'][$i];
			$txtKDP_1=$_POST['txtKDP_1'][$i];
			$txtKDP_2=$_POST['txtKDP_2'][$i];
			$txtKDP_3=$_POST['txtKDP_3'][$i];
			$txtKDP_4=$_POST['txtKDP_4'][$i];
			$txtKDP_5=$_POST['txtKDP_5'][$i];
			$txtKDP_6=$_POST['txtKDP_6'][$i];
			$txtKDP_7=$_POST['txtKDP_7'][$i];
			$txtKDP_8=$_POST['txtKDP_8'][$i];
			$txtKDP_9=$_POST['txtKDP_9'][$i];
			$txtKDP_10=$_POST['txtKDP_10'][$i];
			$txtKDP_11=$_POST['txtKDP_11'][$i];
			$txtKDP_12=$_POST['txtKDP_12'][$i];
			$txtKDP_13=$_POST['txtKDP_13'][$i];
			$txtKDP_14=$_POST['txtKDP_14'][$i];
			$txtKDP_15=$_POST['txtKDP_15'][$i];
			$txtTKDP=$_POST['txtTKDP'][$i];
			//$kd_nPeng=buatKode("n_p_kikd","np_");
			$NHP=round(($txtKDP_1+$txtKDP_2+$txtKDP_3+$txtKDP_4+$txtKDP_5+$txtKDP_6+$txtKDP_7+$txtKDP_8+$txtKDP_9+$txtKDP_10+$txtKDP_11+$txtKDP_12+$txtKDP_13+$txtKDP_14+$txtKDP_15)/$txtTKDP);
			mysql_query("INSERT INTO n_p_kikd VALUES ('','$txtKBM','$txtNIS','$txtKDP_1','$txtKDP_2','$txtKDP_3','$txtKDP_4','$txtKDP_5','$txtKDP_6','$txtKDP_7','$txtKDP_8','$txtKDP_9','$txtKDP_10','$txtKDP_11','$txtKDP_12','$txtKDP_13','$txtKDP_14','$txtKDP_15','$NHP')");
			echo ns("Nambah","parent.location='?page=$page&kbm=$txtKBM'","Nilai Pengetahuan dengan Kode KBM <strong class='text-primary'>$txtKBM</strong>");
		}
	break;

	case "simpanedit":
		foreach($_POST['txtKd'] as $i => $txtKd){
			$txtKBM=$_POST['txtKBM'][$i];
			$txtNIS=$_POST['txtNIS'][$i];
			$txtKDP_1=$_POST['txtKDP_1'][$i];
			$txtKDP_2=$_POST['txtKDP_2'][$i];
			$txtKDP_3=$_POST['txtKDP_3'][$i];
			$txtKDP_4=$_POST['txtKDP_4'][$i];
			$txtKDP_5=$_POST['txtKDP_5'][$i];
			$txtKDP_6=$_POST['txtKDP_6'][$i];
			$txtKDP_7=$_POST['txtKDP_7'][$i];
			$txtKDP_8=$_POST['txtKDP_8'][$i];
			$txtKDP_9=$_POST['txtKDP_9'][$i];
			$txtKDP_10=$_POST['txtKDP_10'][$i];
			$txtKDP_11=$_POST['txtKDP_11'][$i];
			$txtKDP_12=$_POST['txtKDP_12'][$i];
			$txtKDP_13=$_POST['txtKDP_13'][$i];
			$txtKDP_14=$_POST['txtKDP_14'][$i];
			$txtKDP_15=$_POST['txtKDP_15'][$i];
			$txtTKDP=$_POST['txtTKDP'][$i];		
			$NHP=round(($txtKDP_1+$txtKDP_2+$txtKDP_3+$txtKDP_4+$txtKDP_5+$txtKDP_6+$txtKDP_7+$txtKDP_8+$txtKDP_9+$txtKDP_10+$txtKDP_11+$txtKDP_12+$txtKDP_13+$txtKDP_14+$txtKDP_15)/$txtTKDP);		
			mysql_query("UPDATE n_p_kikd SET kd_ngajar='$txtKBM',nis='$txtNIS',kd_1='$txtKDP_1',kd_2='$txtKDP_2',kd_3='$txtKDP_3',kd_4='$txtKDP_4',kd_5='$txtKDP_5',kd_6='$txtKDP_6',kd_7='$txtKDP_7',kd_8='$txtKDP_8',kd_9='$txtKDP_9',kd_10='$txtKDP_10',kd_11='$txtKDP_11',kd_12='$txtKDP_12',kd_13='$txtKDP_13',kd_14='$txtKDP_14',kd_15='$txtKDP_15',kikd_p='$NHP' WHERE kd_p_kikd='$txtKd'");
			echo ns("Ngedit","parent.location='?page=$page&kbm=$txtKBM'","Nilai Pengetahuan dengan Kode KBM <strong class='text-primary'>$txtKBM</strong>");
		}
	break;

	case "HapusNilai":
		$kbm=isset($_GET['kbm'])?$_GET['kbm']:"";
		mysql_query("DELETE FROM n_p_kikd WHERE kd_ngajar='$kbm'");
		echo ns("Hapus","parent.location='?page=$page&kbm=$kbm'","Nilai Pengetahuan dengan Kode KBM <strong class='text-primary'>$kbm</strong>");
	break;

	case "hapusbanyak":
		$kbm=isset($_GET['kbm'])?$_GET['kbm']:"";
		$cekbox = $_POST['cekbox'];
		if ($cekbox) {
			foreach ($cekbox as $value) {
				mysql_query("DELETE FROM n_p_kikd WHERE kd_p_kikd='$value'");
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
	
		$UloadPerNilai.=JudulDalam("Nilai K3 - Pengetahuan","");
		$UloadPerNilai.="
		<form name='myForm' id='myForm' onSubmit='return validateForm()' action='?page=$page&sub=simpanupload&guru=$guru&thnajaran=$thnajaran&gg=$gg&kbm=$kbm' method='post' enctype='multipart/form-data' class='smart-form'>
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
		"hapusnilaip":function(a){
			function b(){
				window.location=a.attr("href")
			}
			$.SmartMessageBox(
				{
					"title":"<h1 style='margin-top:-5px;'><i class='fa fa-fw fa-question-circle bounce animated text-primary'></i><small class='text-primary'><strong> Konfirmasi</strong></small></h1>",
					"content":a.data("hapusnilaip-msg"),
					"buttons":"[No][Yes]"
				},function(a){
					"Yes"==a&&($.root_.addClass("animated fadeOutUp"),setTimeout(b,1e3))
					}
		)}
	}
	$.root_.on("click",'[data-action="hapusnilaip"]',function(b){var c=$(this);a.hapusnilaip(c),b.preventDefault(),c=null});


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
