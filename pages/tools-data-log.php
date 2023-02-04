<?php
require_once("inc/init.php");
require_once("inc/config.ui.php");
$page_title = "Data Login";
$page_css[] = "your_style.css";
include("inc/header.php");
$page_nav["tools"]["sub"]["datalog"]["active"] = true;
include("inc/nav.php");
echo "<div id='main' role='main'>";
$breadcrumbs["Tools"] = "";
include("inc/ribbon.php");	
$sub=(isset($_GET['sub']))?$_GET['sub']:"";
switch($sub)
{

	case "tampil":default:
		$pilihdata=isset($_GET['pilihdata'])?$_GET['pilihdata']:""; 
		if($pilihdata=='walikelas'){$JDLatas="Wali Kelas";}
		else if($pilihdata=='guru'){$JDLatas="Guru Mata Pelajaran";}
		else if($pilihdata=='siswa'){$JDLatas="Peserta Didik";}

		if($pilihdata=='walikelas'){
			$Q=mysql_query("select * from app_user_walikelas where tahunajaran='$TahunAjarAktif' order by waktu_login,kode_kelas asc");
			$no=1;
			while($isi=mysql_fetch_array($Q)){
				$QKls=mysql_query("select * from ak_kelas where kode_kelas='{$isi['kode_kelas']}'");
				$HKls=mysql_fetch_array($QKls);
				$TampilWK.="
				<tr>
					<td class='text-center'>$no.</td>
					<td>".$isi["nama_wk"]."</a></td>
					<td>".$HKls["nama_kelas"]."</a></td>
					<td>".TglLengkap($isi["waktu_login"])."</td>
					<td>".AmbilWaktu($isi["waktu_login"])."</td>
					<td>".$isi["kunjung"]."</td>
				</tr>";
				$no++;
			}
			$Show.="
				<table id='dt_basic' class='table table-striped table-bordered table-hover table-condensed' width='100%'>
					<thead>
						<tr>
							<th class='text-center' data-class='expand'>No.</th>
							<th class='text-center'>Nama Wali Kelas</th>
							<th class='text-center' data-hide='phone'>Kelas</th>
							<th class='text-center' data-hide='phone'>Tanggal Login</th>
							<th class='text-center' data-hide='phone'>Waktu Login</th>
							<th class='text-center' data-hide='phone'>Jumlah Login</th>
						</tr>
					</thead>
					<tbody>
						$TampilWK
					</tbody>
				</table>";
		}else if($pilihdata=='guru'){
			$QGTK=mysql_query("select * from app_user_guru where aktif='Aktif' and hak!='Kepala Sekolah' and jenisguru!='BP/BK' order by waktu_login,nama_lengkap");
			$no=1;
			while($isi=mysql_fetch_array($QGTK)){
				$TampilPTK.="
				<tr>
					<td class='text-center'>$no.</td>
					<td>".$isi["nama_lengkap"]."</a></td>
					<td>".TglLengkap($isi["waktu_login"])."</td>
					<td>".AmbilWaktu($isi["waktu_login"])."</td>
					<td>".$isi["kunjung"]."</td>
				</tr>";
				$no++;
			}
			$Show.="
			<div class='well no-padding'>
				<table id='dt_basic' class='table table-striped table-bordered table-hover table-condensed' width='100%'>
					<thead>
						<tr>
							<th class='text-center' data-class='expand'>No.</th>
							<th class='text-center'>Nama PTK</th>
							<th class='text-center' data-hide='phone'>Tanggal Login</th>
							<th class='text-center' data-hide='phone'>Waktu Login</th>
							<th class='text-center' data-hide='phone'>Jumlah Login</th>
						</tr>
					</thead>
					<tbody>
						$TampilPTK
					</tbody>
				</table>
			</div>";

		}else if($pilihdata=="siswa"){
			$piltingkat=isset($_GET['piltingkat'])?$_GET['piltingkat']:"";
			$pilihpk=isset($_GET['pilihpk'])?$_GET['pilihpk']:"";
			$pilkelas=isset($_GET['pilkelas'])?$_GET['pilkelas']:"";

			$FormPilih.="
			<form action='?page=$page' method='post' name='frmPilih' class='form-inline' role='form'>
				<div class='row'>
					<div class='col-sm-12 col-md-12'>
						<div class='form-group'>Pililh Data &nbsp;&nbsp;</div>".
						FormCF("inline","Tingkat","txtTingkat","select tingkat from ak_kelas where ak_kelas.tahunajaran='$TahunAjarAktif' group by tingkat","tingkat",$piltingkat,"tingkat","","onchange=\"document.location.href='?page=$page&pilihdata=siswa&piltingkat='+document.frmPilih.txtTingkat.value\"").
						FormCF("inline","Paket Keahlian","txtPK","select ak_paketkeahlian.kode_pk,ak_paketkeahlian.nama_paket from ak_kelas inner join ak_paketkeahlian on ak_kelas.kode_pk=ak_paketkeahlian.kode_pk where tahunajaran='$TahunAjarAktif' and tingkat='$piltingkat' group by ak_paketkeahlian.kode_pk","kode_pk",$pilihpk,"nama_paket","","onchange=\"document.location.href='?page=$page&pilihdata=siswa&piltingkat='+document.frmPilih.txtTingkat.value+'&pilihpk='+document.frmPilih.txtPK.value\"").
						FormCF("inline","Kelas","txtKelas","select * from ak_kelas where tahunajaran='$TahunAjarAktif' and tingkat='$piltingkat' and kode_pk='$pilihpk' order by kode_kelas,tingkat,kode_pk desc","id_kls",$pilkelas,"nama_kelas","","onchange=\"document.location.href='?page=$page&pilihdata=siswa&piltingkat='+document.frmPilih.txtTingkat.value+'&pilihpk='+document.frmPilih.txtPK.value+'&pilkelas='+document.frmPilih.txtKelas.value\"")."
					</div>
				</div>
			</form>";

			if($_GET['pilihpk']=="" && $_GET['pilkelas']==""){
				$TmplData="WHERE ak_kelas.tahunajaran='$TahunAjarAktif' AND ak_kelas.tingkat='$piltingkat'";
				$TmplJudul="Tingkat $PilTingkatDapo";
			}
			else if($_GET['pilkelas']==""){
				$TmplData="WHERE ak_kelas.tahunajaran='$TahunAjarAktif' AND ak_kelas.tingkat='$piltingkat' AND ak_kelas.kode_pk='$pilihpk'";
				$TmplJudul="Paket Keahlian $PilTingkatDapo";
			}
			else{
				$TmplData="where ak_kelas.tahunajaran='$TahunAjarAktif' and ak_kelas.tingkat='$piltingkat' and ak_kelas.kode_pk='$pilihpk' and ak_kelas.id_kls='$pilkelas'";
				$TmplJudul="Kelas $NamaPilKelasDapo";

				$QKlss=mysql_query("SELECT ak_kelas.id_kls,ak_kelas.nama_kelas,siswa_biodata.nm_siswa,siswa_biodata.nis,app_user_siswa.ket FROM ak_kelas 
					inner join ak_perkelas on ak_perkelas.nm_kelas=ak_kelas.nama_kelas 
					INNER JOIN app_user_siswa ON app_user_siswa.nis=ak_perkelas.nis
					INNER JOIN siswa_biodata ON siswa_biodata.nis=ak_perkelas.nis 
					WHERE id_kls='{$_GET['pilkelas']}' AND ak_perkelas.tahunajaran='$TahunAjarAktif'");
				$HKlss=mysql_fetch_array($QKlss);
				$IdKelasNa=$HKlss['id_kls'];
				$NMKls=$HKlss['nama_kelas'];

				$TombolDownload="<a href=\"javascript:;\" onClick=\"window.open('./pages/excel/excel-siswa-uname.php?thnajar=$TahunAjarAktif&idkelas=$IdKelasNa&nmkelas=$NMKls')\" class='btn btn-danger full-right btn-xs'>Download Data Login $NMKls</a>";
			}
		
			$Q=mysql_query("SELECT 
				ak_kelas.id_kls, 
				ak_kelas.nama_kelas,
				ak_kelas.kode_pk,
				ak_perkelas.nis,
				siswa_biodata.nm_siswa,
				siswa_biodata.jenis_kelamin,
				app_user_siswa.ket,
				app_user_siswa.waktu_login,
				app_user_siswa.kunjung
				FROM ak_kelas 
				INNER JOIN ak_perkelas ON ak_perkelas.nm_kelas=ak_kelas.nama_kelas AND ak_perkelas.tahunajaran=ak_kelas.tahunajaran
				INNER JOIN siswa_biodata ON ak_perkelas.nis=siswa_biodata.nis
				INNER JOIN app_user_siswa ON ak_perkelas.nis=app_user_siswa.nis 
				$TmplData
				order by app_user_siswa.waktu_login desc");

				///  WHERE kelas.tahunajaran='$TahunAjarAktif' AND kelas.tingkat='$piltingkat' AND kelas.kode_pk='$pilihpk' AND kelas.id_kls='$pilkelas' 

			$no=1;
			while($isi=mysql_fetch_array($Q)){
				$QFSiswa=mysql_query("SELECT * from siswa_biodata where nis='".$isi['nis']."'");
				$HFSiswa=mysql_fetch_array($QFSiswa);

				if($HFSiswa["foto"]==""){
					if($isi['jenis_kelamin']=="Perempuan"){
						$Photona="<img src='img/avatars/perempuan.jpg' style='max-width:50px;'>";
					}else{
						$Photona="<img src='img/avatars/laki-laki.jpg' style='max-width:50px;'>";
					}
				}
				else{
					$Photona="<a href='img/photo_siswa/{$HFSiswa['foto']}' target='_blank'><img src='img/photo_siswa/resized_{$HFSiswa['foto']}' style='max-width:50px;'></a>";
				}
				
				$TampilSiswa.="
				<tr>
					<td class='text-center'>$no.</td>
					<td><center>$Photona</center></td>
					<td>".$isi["nm_siswa"]."</a></td>
					<td>".$isi["jenis_kelamin"]."</a></td>
					<td>".$isi["nama_kelas"]."</a></td>
					<td>".$isi["nis"]."</a></td>
					<td>".$isi["ket"]."</a></td>
					<td>".TgldanWaktu($isi["waktu_login"])."</td>
					<td>".$isi["kunjung"]."</td>
				</tr>";
				$no++;

			}

			$Show.=KolomPanel($FormPilih);
			$Show.=$TombolDownload."<br><br>";
			$Show.="
			<table id='dt_basic' class='table table-striped table-bordered table-hover table-condensed' width='100%'>
				<thead>
					<tr>
						<th class='text-center' data-class='expand'>No.</th>
						<th class='text-center' data-hide='phone'>Foto</th>
						<th class='text-center'>Nama Siswa</th>
						<th class='text-center' data-hide='phone,tablet'>JK</th>
						<th class='text-center' data-hide='phone,tablet'>Kelas</th>
						<th class='text-center' data-hide='phone,tablet'>Username</th>
						<th class='text-center' data-hide='phone,tablet'>Password</th>
						<th class='text-center' data-hide='phone,tablet'>Login</th>
						<th class='text-center' data-hide='phone,tablet'>Jumlah Login</th>
					</tr>
				</thead>
				<tbody>
					$TampilSiswa
				</tbody>
			</table>";
		}else
		{
			$Show.="<br><br><div class='text-center'><a href='' class='btn btn-danger btn-circle btn-xl' title='Perangkat Ujian'><i class='fa fa-key fa-2x'></i></a><br><br><h1><span class='text-danger slideInRight fast animated'><strong>LOGIN USER</strong></span></h1><h1><span class='semi-bold'>LCKS</span> <i class='ultra-light'>SMK</i> <span class='hidden-mobile'>(Kurikulum 2013)</span> <sup class='badge bg-color-red bounceIn animated'>$VersiApp</sup> <br> <small class='text-danger slideInRight fast animated'><strong><span class='hidden-mobile'>Aplikasi</span> Laporan Capaian Kompetensi Siswa</strong></small></h1></div><br>
		        <div class='col-md-4 col-md-offset-4'>			
					<div class='btn-group btn-group-justified'>
						<a href='?page=$page&pilihdata=walikelas' class='btn btn-default'>Wali Kelas</a>
						<a href='?page=$page&pilihdata=guru' class='btn btn-default'>Guru</a>
					<a href='?page=$page&pilihdata=siswa' class='btn btn-default'>Siswa</a>
					</div> 
				</div>
			<br><br><br>

			";
		}
		
		if($pilihdata==""){$jdl="Pengguna";$Tombolna="";}
		else if($pilihdata=="walikelas"){$jdl="Wali Kelas";}
		else if($pilihdata=="guru"){$jdl="Guru Mata Pelajaran";}
		else if($pilihdata=="siswa"){$jdl="Siswa";}

		echo MyWidget('fa-sign-in',$page_title." <i class='ultra-light'>$jdl</i>",array(ButtonKembali("?page=$page")),$Show);	
	break;

	case "hapusdokumen":
		
		$nis=isset($_GET['nis'])?$_GET['nis']:"";
		
		$folgambar1="img/photo_siswa/$nis.jpg";
		if(file_exists($folgambar1)){unlink($folgambar1);}
		$folgambar2="img/photo_siswa/resized_$nis.jpg";
		if(file_exists($folgambar2)){unlink($folgambar2);}
		$folgambar3="img/photo_siswa/thumb_$nis.jpg";
		if(file_exists($folgambar3)){unlink($folgambar3);}

		echo "<meta http-equiv='refresh' content='0; url=?page=$page'>";
		
	break;

}

echo '</div>';
include("inc/footer.php");
include("inc/scripts.php");
//"));
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