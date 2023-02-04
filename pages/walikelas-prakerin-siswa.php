<?php
require_once("inc/init.php");
require_once("inc/config.ui.php");
$page_title = "Prakerin Siswa";
$page_css[] = "your_style.css";
include("inc/header.php");
$page_nav["walikelas"]["sub"]["prakerin"]["active"] = true;
include("inc/nav.php");
echo "<div id='main' role='main'>";
$breadcrumbs["Wali Kelas"] = "";
include("inc/ribbon.php");	
$sub=(isset($_GET['sub']))?$_GET['sub']:"";
switch($sub)
{
	case "tampil":default:

		$MassaKBM="Tahun Pelajaran $TahunAjarAKtif Semester $SemesterAktif";
		
		$Q="
		select 
		ak_kelas.id_kls,
		ak_kelas.nama_kelas,
		ak_kelas.tahunajaran,
		siswa_biodata.nis,
		siswa_biodata.nm_siswa,
		siswa_biodata.tempat_lahir,
		siswa_biodata.tanggal_lahir,
		siswa_biodata.jenis_kelamin 
		from 
		ak_kelas,
		siswa_biodata,
		ak_perkelas,
		ak_paketkeahlian 
		where 
		ak_kelas.nama_kelas=ak_perkelas.nm_kelas and 
		ak_kelas.tahunajaran=ak_perkelas.tahunajaran and 
		ak_perkelas.nis=siswa_biodata.nis and 
		siswa_biodata.kode_paket=ak_paketkeahlian.kode_pk and 
		ak_kelas.id_kls='$IDna' ";
		
		$no=1;
		$Query=mysql_query("$Q order by siswa_biodata.nis");
		while($Hasil=mysql_fetch_array($Query))
		{
			$NamaKelas=$Hasil['nama_kelas'];
			$QpklSiswa=mysql_query("select * from wk_prakerin where nis={$Hasil['nis']}");
			$DPKL=mysql_fetch_array($QpklSiswa);
			$Perusahaan=$DPKL['perusahaan'];
			$Nilai=$DPKL['nilai'];
			if(mysql_num_rows($QpklSiswa)>=1){
				$AksipklSiswa="
				<a data-toggle='modal' href='#PrakerinEdit' id='{$DPKL['id_pkl']}' class='tmpleditprakerin'><i class='fa fa-pencil-square fa-2x text-info'></i></a>&nbsp;&nbsp;
				
				<a href='?page=$page&sub=hapus&pkl={$DPKL['id_pkl']}' data-action='hapus' data-hapus-msg=\"Apakah Anda yakin akan mengapus data prekerin siswa <strong class='text-primary'>$nm_siswa</strong>.\"><i class='fa fa-trash-o text-danger fa-2x'></i></a>
				";
				
				echo FormModalEdit(
				"sedang",
				"PrakerinEdit", 
				"<i class='fa fa-edit'></i> Edit Prakerin Siswa",
				"?page=$page&sub=simpaneditprakerin",
				"form-horizontal",
				"bodyeditprakerin",
				"ngeditprakerin",
				"Simpan");
			}
			else{
				$AksipklSiswa ="
				<a data-toggle='modal' href='#PrakerinTambah' id='{$Hasil['nis']}' class='tmpltambahprakerin'><i class='fa fa-pencil-square-o fa-2x text-danger'></i></a>";
				echo FormModalEdit(
				"sedang",
				"PrakerinTambah", 
				"<i class='fa fa-plus'></i> Tambah Prakerin Siswa",
				"?page=$page&sub=simpantambahprakerin",
				"form-horizontal",
				"bodytambahprakerin",
				"nambahprakerin",
				"Simpan");
			}
			$TampilDataSiswa.="
			<tr>
				<td class='text-center'>$no.</td>
				<td>{$Hasil['tahunajaran']}</td>
				<td>{$Hasil['nis']}</td>
				<td>{$Hasil['nm_siswa']}</td>
				<td>$Perusahaan</td>
				<td>$Nilai</td>
				<td class='text-center'>$AksipklSiswa</td>
			</tr>";
			$no++;
		}
		$jmldata=mysql_num_rows($Query);
		if($jmldata>0) 
		{
			$Show.=JudulKolom("Prakerin Kelas $NamaKelas","institution");
			$Show.="<p class='text-danger' style='margin-top:-15px;'>$MassaKBM</p>
			<table id='dt_basic' class='table table-striped table-bordered table-hover table-condensed' width='100%'>
				<thead>
					<tr>
						<th class='text-center' data-class='expand'>No.</th>
						<th class='text-center' width='100' data-hide='phone,tablet'>Thn Ajaran</th>
						<th class='text-center' width='100'>NIS</th>
						<th class='text-center' width='250'>Nama Siswa</th>
						<th class='text-center' data-hide='phone,tablet'>DU/DI</th>
						<th class='text-center' data-hide='phone,tablet'>Nilai</th>
						<th class='text-center' width='100'>Aksi</th>
					</tr>
				</thead>
				<tbody>
					$TampilDataSiswa
				</tbody>
			</table>";			
		}
		else 
		{
			$Show.="<p class='text-center'><img src='img/aa.png' width='100' height='231' border='0' alt=''></p><h1 class='text-center'><small class='text-danger slideInRight fast animated'><strong>Tahun Pelajaran $TahunAjarAKtif Semester $SemesterAktif</strong> </small><br><small>Data Siswa belum ada, silakan hubungi Administrator.</small> </h1>";
		}

		$tandamodal="#WKPrakerinSiswa";
		echo $WKPrakerinSiswa;
		echo IsiPanel($Show);		
	break;
	case "simpantambahprakerin":
		$kd_pkl=buatKode("wk_prakerin","pkl_");
		$txtNIS=addslashes($_POST['txtNIS']);
		$txtNmPerus=addslashes($_POST['txtNmPerus']);
		$txtAlPerus=addslashes($_POST['txtAlPerus']);
		$txtBlnMulai=addslashes($_POST['txtBlnMulai']);
		$txtBlnAkhir=addslashes($_POST['txtBlnAkhir']);
		$txtThnAjar=addslashes($_POST['txtThnAjar']);
		$txtSemester=addslashes($_POST['txtSemester']);
		$txtNilpkl=addslashes($_POST['txtNilpkl']);
		$predikat=deskripsi($txtNilpkl);
		$ket=$predikat." dalam mengikuti wk_prakerin";
		mysql_query("INSERT INTO wk_prakerin VALUES ('$kd_pkl','$txtNIS','$txtNmPerus','$txtAlPerus','$txtBlnMulai', '$txtBlnAkhir','$txtThnAjar','$txtSemester','$predikat','$txtNilpkl','$ket')");
		echo ns("Nambah","parent.location='?page=$page'","Prakerin");
	break;
	
	case "simpaneditprakerin":
		$txtKodPKL=addslashes($_POST['txtKodPKL']);
		$txtNIS=addslashes($_POST['txtNIS']);
		$txtNmPerus=addslashes($_POST['txtNmPerus']);
		$txtAlPerus=addslashes($_POST['txtAlPerus']);
		$txtBlnMulai=addslashes($_POST['txtBlnMulai']);
		$txtBlnAkhir=addslashes($_POST['txtBlnAkhir']);
		$txtThnAjar=addslashes($_POST['txtThnAjar']);
		$txtSemester=addslashes($_POST['txtSemester']);
		$txtNilpkl=addslashes($_POST['txtNilpkl']);
		$predikat=deskripsi($txtNilpkl);
		$ket=$predikat." dalam mengikuti wk_prakerin";
		mysql_query("update wk_prakerin set nis='$txtNIS',perusahaan='$txtNmPerus',lokasi='$txtAlPerus',bln_awal='$txtBlnMulai',bln_akhir='$txtBlnAkhir',tahunajaran='$txtThnAjar',semester='$txtSemester',predikat='$predikat',nilai='$txtNilpkl',ket='$ket' where id_pkl='$txtKodPKL'");
		echo ns("Ngedit","parent.location='?page=$page'","Prakerin");
	break;
	case "hapus":
		mysql_query("DELETE FROM wk_prakerin WHERE id_pkl='".$_GET['pkl']."'");
		echo ns("Hapus","parent.location='?page=$page'","Prakerin");
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
					"title":"<h1 style='margin-top:-5px;'><i class='fa fa-fw fa-question-circle bounce animated text-primary'></i><small class='text-primary'><strong> Konfirmasi</strong></small></h1>",
					"content":a.data("hapus-msg"),
					"buttons":"[No][Yes]"
				},function(a){
					"Yes"==a&&($.root_.addClass("animated fadeOutUp"),setTimeout(b,1e3))
					}
		)}
	}
	$.root_.on("click",'[data-action="hapus"]',function(b){var c=$(this);a.hapus(c),b.preventDefault(),c=null});
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
	$('.tmpleditprakerin').click(function(){
		var id = $(this).attr("id");
		$.ajax({
			url: 'lib/app_modal.php?md=PrakerinEdit',
			method: 'post',
			data: {id:id},
			success:function(data){
				$('#bodyeditprakerin').html(data);
				$('#PrakerinEdit').modal("show");
			}
		});
	});
	$('.tmpltambahprakerin').click(function(){
		var id = $(this).attr("id");
		$.ajax({
			url: 'lib/app_modal.php?md=PrakerinTambah',
			method: 'post',
			data: {id:id},
			success:function(data){
				$('#bodytambahprakerin').html(data);
				$('#PrakerinTambah').modal("show");
			}
		});
	});
})
</script>