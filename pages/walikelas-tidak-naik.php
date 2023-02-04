<?php
require_once("inc/init.php");
require_once("inc/config.ui.php");
$page_title = "Tidak Naik Kelas";
$page_css[] = "your_style.css";
include("inc/header.php");
$page_nav["walikelas"]["sub"]["tidaknaik"]["active"] = true;
include("inc/nav.php");
echo "<div id='main' role='main'>";
$breadcrumbs["Wali Kelas"] = "";
include("inc/ribbon.php");	
$sub=(isset($_GET['sub']))?$_GET['sub']:"";
switch($sub)
{
	case "tampil":default:

		$TAna=$TahunAjarAktif;
		$Smstrna=$SemesterAktif;
		$MassaKBM="Tahun Pelajaran $TahunAjarAktif Semester $SemesterAktif";

		$Q=mysql_query("select 
		ak_kelas.id_kls,
		ak_kelas.nama_kelas,
		ak_kelas.tahunajaran,
		siswa_biodata.nis,
		siswa_biodata.nm_siswa,
		siswa_biodata.jenis_kelamin, 
		siswa_biodata.tanggal_lahir,
		siswa_biodata.tempat_lahir		
		from 
		ak_kelas,
		siswa_biodata,
		ak_perkelas,
		ak_paketkeahlian where 
		ak_kelas.nama_kelas=ak_perkelas.nm_kelas and 
		ak_kelas.tahunajaran=ak_perkelas.tahunajaran and 
		ak_perkelas.nis=siswa_biodata.nis and 
		siswa_biodata.kode_paket=ak_paketkeahlian.kode_pk and ak_kelas.id_kls='$IDna' order by siswa_biodata.nis");
		$no=1;	
		while($Hasil=mysql_fetch_array($Q))
		{
			$NisTidakNaik=JmlDt("select * from wk_tidaknaik where id_kls='{$Hasil['id_kls']}' and nis='{$Hasil['nis']}' and thnajaran='$TahunAjarAktif' and semester='$SemesterAktif'");
			if($NisTidakNaik==0){$NaikTidak="Naik Kelas";$Warna='';$aksi="<a href='?page=$page&sub=teunaek&idkls={$Hasil['id_kls']}&thnajaran=$TAna&Semester=$Smstrna&nisboedak={$Hasil['nis']}' class='blue' title='Proses Tidak Naik Kelas'><i class='fa fa-pencil-square-o fa-border txt-color-red'></i></a>";}else{$NaikTidak="Tidak Naik";$Warna='#cccccc';$aksi="<a href='?page=$page&sub=hapus&idkls={$Hasil['id_kls']}&thnajaran=$TAna&Semester=$Smstrna&nisboedak={$Hasil['nis']}' class='blue' title='Batalkan Tidak Naik Kelas'><i class='fa fa-trash-o fa-border txt-color-red'></i></a>";}
			$NamaKelas=$Hasil['nama_kelas'];
			$TampilDataSiswa.="
			<tr>
				<td class='text-center' bgcolor='$Warna'>$no.</td>
				<td bgcolor='$Warna'>{$Hasil['nis']}</td>
				<td bgcolor='$Warna'>{$Hasil['nm_siswa']}</td>
				<td bgcolor='$Warna'>{$Hasil['jenis_kelamin']}</td>
				<td bgcolor='$Warna'>{$Hasil['tempat_lahir']}, ".TglLengkap($Hasil['tanggal_lahir'])."</td>
				<td bgcolor='$Warna'>$NaikTidak</td>
				<td class='text-center' bgcolor='$Warna'>$aksi</td>
			</tr>";
			$no++;
		}
		$jmldata=mysql_num_rows($Q);		
		if($jmldata>0){
			$Show.=JudulKolom("Tidak Naik Kelas $NamaKelas","arrow-circle-down");
			$Show.="<p class='text-danger' style='margin-top:-15px;'>$MassaKBM</p>
			<table id='dt_basic' class='table table-striped table-bordered table-hover table-condensed' width='100%'>
				<thead>
					<tr>
						<th class='text-center' data-class='expand'>No.</th>
						<th class='text-center' data-hide='phone'>NIS</th>
						<th class='text-center'>Nama Siswa</th>
						<th class='text-center' data-hide='phone'>Jenis Kelamin</th>
						<th class='text-center' data-hide='phone'>Tempat Tgl Lahir</th>
						<th class='text-center' data-hide='phone'>Naik Kelas</th>
						<th class='text-center'>Aksi</th>
					</tr>
				</thead>
				<tbody>
					$TampilDataSiswa
				</tbody>
			</table>";
		}
		else{
			$Show.="<p class='text-center'><img src='img/aa.png' width='100' height='231' border='0' alt=''></p><h1 class='text-center'><small class='text-danger slideInRight fast animated'><strong>Tahun Pelajaran $TahunAjarAktif Semester $SemesterAktif</strong> </small><br><small>Data Siswa belum ada, silakan hubungi Administrator.</small> </h1>";
		}
		echo $WKTidakNaik;
		$tandamodal="#WKTidakNaik";
		echo IsiPanel($Show);
	break;
	case "teunaek":
		$idkls=(isset($_GET['idkls']))?$_GET['idkls']:"";
		$thnajaran=(isset($_GET['thnajaran']))?$_GET['thnajaran']:"";
		$Semester=(isset($_GET['Semester']))?$_GET['Semester']:"";
		$nisboedak=(isset($_GET['nisboedak']))?$_GET['nisboedak']:"";
		mysql_query("INSERT INTO wk_tidaknaik VALUES ('','$idkls','$thnajaran','$Semester','$nisboedak')");
		echo ns("Nambah","parent.location='?page=$page'","Siswa tidak naik kelas");
	break;
	case "hapus":
		$idkls=(isset($_GET['idkls']))?$_GET['idkls']:"";
		$thnajaran=(isset($_GET['thnajaran']))?$_GET['thnajaran']:"";
		$Semester=(isset($_GET['Semester']))?$_GET['Semester']:"";
		$nisboedak=(isset($_GET['nisboedak']))?$_GET['nisboedak']:"";
		mysql_query("DELETE FROM wk_tidaknaik where id_kls='$idkls' and thnajaran='$thnajaran' and semester='$Semester' and nis='$nisboedak'");
		echo ns("Hapus","parent.location='?page=$page'","Siswa tidak naik kelas");
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
<script src="<?php echo ASSETS_URL; ?>/js/plugin/morris/raphael.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/morris/morris.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
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
})
</script>