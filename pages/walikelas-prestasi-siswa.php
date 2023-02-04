<?php
require_once("inc/init.php");
require_once("inc/config.ui.php");
$page_title = "Prestasi Siswa";
$page_css[] = "your_style.css";
include("inc/header.php");
$page_nav["walikelas"]["sub"]["prestasi"]["active"] = true;
include("inc/nav.php");
echo "<div id='main' role='main'>";
$breadcrumbs["Wali Kelas"] = "";
include("inc/ribbon.php");	
$sub=(isset($_GET['sub']))?$_GET['sub']:"";
switch($sub)
{
	case "tampil":default:

		$MassaKBM="Tahun Pelajaran $TahunAjarAktif Semester $SemesterAktif";

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
		ak_kelas.id_kls='$IDna'";
		$no=1;
		$Query=mysql_query("$Q order by siswa_biodata.nis");
		while($Hasil=mysql_fetch_array($Query))
		{
			$NamaKelas=$Hasil['nama_kelas'];
			$nm_siswa=$Hasil['nm_siswa'];
			
			$QPresSiswa=mysql_query("
				select 
				wk_prestasi_siswa.*, 
				siswa_biodata.nis,
				siswa_biodata.nm_siswa 
				from 
				wk_prestasi_siswa,
				siswa_biodata 
				where 
				wk_prestasi_siswa.nis=siswa_biodata.nis and 
				wk_prestasi_siswa.tahunajaran='$TahunAjarAktif' and 
				wk_prestasi_siswa.semester='$SemesterAktif' and 
				wk_prestasi_siswa.nis='{$Hasil['nis']}' 
				order by siswa_biodata.nis asc");		
			
			$JmlPresSiswa=mysql_num_rows($QPresSiswa);
			$TampilDataSiswa.="
			<tr>
				<td class='text-center'>$no.</td>
				<td>{$Hasil['nis']}</td>
				<td>{$Hasil['nm_siswa']}</td>
				<td width='50%'>";
					if($JmlPresSiswa>0)
					{
						$no2=1;
						while($HPresSiswa=mysql_fetch_array($QPresSiswa)){
							$TampilDataSiswa.=
								"
							<table>
							<tr>
								<td valign='top' width='50'><img src='img/$no2.png' width='35' height='35' ></td>
								<td width='400'>
									Nama Lomba : <strong>{$HPresSiswa['nama_lomba']} tingkat {$HPresSiswa['tingkat']}</strong><br>
									Jenis <strong>{$HPresSiswa['jenis']}</strong> Pada tanggal <strong>".TglLengkap($HPresSiswa['tanggal'])."</strong> sebagai <strong>Juara {$HPresSiswa['juarake']}</strong> di <strong>{$HPresSiswa['tempat']}</strong><hr>
								</td>
								<td width='100' align='center' valign='top'>
									<a data-toggle='modal' href='#PrestasiEdit' id='{$HPresSiswa['id_pres']}' class='tmpleditprestasi'> <i class='fa fa-edit fa-2x text-primary'></i> </a> 
									<a href='?page=$page&sub=hapus&idpres={$HPresSiswa['id_pres']}' data-action='hapus' data-hapus-msg=\"Apakah Anda yakin akan mengapus prestasi untuk siswa <strong class='text-primary'>$nm_siswa</strong>\"><i class='fa fa-trash-o fa-2x text-danger'></i></a>
								</td>
							</tr>
							</table>";
							$no2++;
							echo FormModalEdit(
							"sedang",
							"PrestasiEdit", 
							"<i class='fa fa-edit'></i> Edit Prestasi Siswa",
							"?page=$page&sub=SimpanEditPrestasi",
							"form-horizontal",
							"bodyeditprestasi",
							"ngeditprestasi",
							"Simpan");
						}
					}
					else
					{
						$TampilDataSiswa.="";
					}					
				
				$TampilDataSiswa.="
				</td>
				<td class='text-center'><a data-toggle='modal' href='#PrestasiTambah' id='{$Hasil['nis']}' class='tmpltambahprestasi'><i class='txt-color-red fa fa-pencil-square-o fa-2x'></i></a></td>
			</tr>";
			$no++;
			echo FormModalEdit(
			"sedang",
			"PrestasiTambah", 
			"<i class='fa fa-plus'></i> Tambah Prestasi Siswa",
			"?page=$page&sub=simpantambahprestasi",
			"form-horizontal",
			"bodytambahprestasi",
			"nambahprestasi",
			"Simpan");
		}
		$jmldata=mysql_num_rows($Query);
		if($jmldata>0){
			$Show.=JudulKolom("Prestasi Kelas $NamaKelas","trophy");
			$Show.="<p class='text-danger' style='margin-top:-15px;'>$MassaKBM</p>
			<table id='dt_basic' class='table table-striped table-bordered table-hover table-condensed' width='100%'>
				<thead>
					<tr>
						<th class='text-center' data-class='expand'>No.</th>
						<th class='text-center'>NIS</th>
						<th class='text-center'>Nama Siswa</th>
						<th class='text-center' data-hide='phone,tablet'>Prestasi</th>
						<th class='text-center'>Aksi</th>
					</tr>
				</thead>
				<tbody>
					$TampilDataSiswa
				</tbody>
			</table>";		
		}
		else 
		{
			$Show.="<p class='text-center'><img src='img/aa.png' width='100' height='231' border='0' alt=''></p><h1 class='text-center'><small class='text-danger slideInRight fast animated'><strong>Tahun Pelajaran $TahunAjarAktif Semester $SemesterAktif</strong> </small><br><small>Data Siswa belum ada, silakan hubungi Administrator.</small> </h1>";		
		}
		
		$tandamodal="#WKPrestasiSiswa";
		echo $WKPrestasiSiswa;
		echo IsiPanel($Show);
	break;
	case "simpantambahprestasi":
		$kd_prest=buatKode("wk_prestasi_siswa","pres_");
		$txtNIS=addslashes($_POST['txtNIS']);
		$txtThnAjaran=addslashes($_POST['txtThnAjaran']);
		$txtSmstr=addslashes($_POST['txtSmstr']);
		$txtJenis=addslashes($_POST['txtJenis']);
		$txtTingkat=addslashes($_POST['txtTingkat']);
		$txtJuaraKe=addslashes($_POST['txtJuaraKe']);
		$txtNamaLomba=addslashes($_POST['txtNamaLomba']);
		$txtTglLomba=addslashes($_POST['txtTglLomba']);
		$txtBlnLomba=addslashes($_POST['txtBlnLomba']);
		$txtThnLomba=addslashes($_POST['txtThnLomba']);
		$txtTmptLomba=addslashes($_POST['txtTmptLomba']);
		$TglPelLomba=trim($_POST['txtThnLomba'])."-".trim($_POST['txtBlnLomba'])."-".trim($_POST['txtTglLomba']);
		mysql_query("INSERT INTO wk_prestasi_siswa VALUES ('$kd_prest','$txtNIS','$txtThnAjaran','$txtSmstr','$txtJenis','$txtTingkat','$txtJuaraKe','$txtNamaLomba','$TglPelLomba','$txtTmptLomba')");
		echo ns("Nambah","parent.location='?page=$page'","Prestasi Siswa");
	break;
	case "SimpanEditPrestasi":
		$txtIDPres=addslashes($_POST['txtIDPres']);
		$txtNIS=addslashes($_POST['txtNIS']);
		$txtThnAjaran=addslashes($_POST['txtThnAjaran']);
		$txtSmstr=addslashes($_POST['txtSmstr']);
		$txtJenis=addslashes($_POST['txtJenis']);
		$txtTingkat=addslashes($_POST['txtTingkat']);
		$txtJuaraKe=addslashes($_POST['txtJuaraKe']);
		$txtNamaLomba=addslashes($_POST['txtNamaLomba']);
		$txtTglLomba=addslashes($_POST['txtTglLomba']);
		$txtBlnLomba=addslashes($_POST['txtBlnLomba']);
		$txtThnLomba=addslashes($_POST['txtThnLomba']);
		$txtTmptLomba=addslashes($_POST['txtTmptLomba']);
		$TglPelLomba=trim($_POST['txtThnLomba'])."-".trim($_POST['txtBlnLomba'])."-".trim($_POST['txtTglLomba']);	
		mysql_query("UPDATE wk_prestasi_siswa SET nis='$txtNIS',tahunajaran='$txtThnAjaran',semester='$txtSmstr',jenis='$txtJenis', tingkat='$txtTingkat',juarake='$txtJuaraKe',nama_lomba='$txtNamaLomba',tanggal='$TglPelLomba',tempat='$txtTmptLomba' where id_pres='".trim($_POST['txtIDPres'])."'");
		echo ns("Ngedit","parent.location='?page=$page'","Prestasi Siswa");
	break;
	case "hapus":
		$idpres=isset($_GET['idpres'])?$_GET['idpres']:"";
		mysql_query("DELETE FROM wk_prestasi_siswa WHERE id_pres='".$_GET['idpres']."'");
		echo ns("Hapus","parent.location='?page=$page'","Prestasi Siswa");
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
	$('.tmpleditprestasi').click(function(){
		var id = $(this).attr("id");
		$.ajax({
			url: 'lib/app_modal.php?md=PrestasiEdit',
			method: 'post',
			data: {id:id},
			success:function(data){
				$('#bodyeditprestasi').html(data);
				$('#PrestasilEdit').modal("show");
			}
		});
	});
	$('.tmpltambahprestasi').click(function(){
		var id = $(this).attr("id");
		$.ajax({
			url: 'lib/app_modal.php?md=PrestasiTambah',
			method: 'post',
			data: {id:id},
			success:function(data){
				$('#bodytambahprestasi').html(data);
				$('#PrestasiTambah').modal("show");
			}
		});
	});
})
</script>