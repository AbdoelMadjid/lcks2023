<?php
require_once("inc/init.php");
require_once("inc/config.ui.php");
$page_title = "Catatan Wali Kelas";
$page_css[] = "your_style.css";
include("inc/header.php");
$page_nav["walikelas"]["sub"]["catatan"]["active"] = true;
include("inc/nav.php");
echo "<div id='main' role='main'>";
$breadcrumbs["Wali Kelas"] = "";
include("inc/ribbon.php");	
$sub=(isset($_GET['sub']))? $_GET['sub'] : "";
switch ($sub)
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
		siswa_biodata.kode_paket=ak_paketkeahlian.kode_pk and ak_kelas.id_kls='$IDna'";
		
		$no=1;
		$Query=mysql_query("$Q order by siswa_biodata.nis");
		while($Hasil=mysql_fetch_array($Query))
		{
			$NamaKelas=$Hasil['nama_kelas'];
			$nm_siswa=$Hasil['nm_siswa'];
			$QCatWK=mysql_query("select * from wk_catatan where nis='{$Hasil['nis']}' and tahunajaran='$TahunAjarAktif' and semester='$SemesterAktif'");
			$DCatWK=mysql_fetch_array($QCatWK);
			$TmplCatatan=$DCatWK['catatan'];
			$IDCatWK=$DCatWK['id_cat'];
			if(mysql_num_rows($QCatWK)>=1){
				$AksiCatatan="
				<a data-toggle='modal' href='#CatatanWkEdit' id='{$DCatWK['id_cat']}' class='tmpleditcatatanwk'><i class='fa fa-pencil-square fa-2x text-info'></i></a>&nbsp;&nbsp;				
				<a href='?page=$page&sub=hapus&id_cat={$DCatWK['id_cat']}' data-action='hapus' data-hapus-msg=\"Apakah Anda yakin akan mengapus data catatan wali kelas untuk siswa <strong class='text-primary'>$nm_siswa</strong>\"><i class='fa fa-trash-o fa-2x text-danger'></i></a>";

				echo FormModalEdit(
				"sedang",
				"CatatanWkEdit", 
				"<i class='fa fa-edit'></i> Edit Catatan Wali Kelas",
				"?page=$page&sub=simpaneditcatatanwk",
				"form-horizontal",
				"bodyeditcatatanwk",
				"ngeditcatatanwk",
				"Simpan");

			}
			else{
				$AksiCatatan="	
				<a data-toggle='modal' href='#CatatanWkTambah' id='{$Hasil['nis']}' class='tmpltambahcatatanwk'><i class='fa fa-pencil-square-o fa-2x text-danger'></i></a>";

				echo FormModalEdit(
				"sedang",
				"CatatanWkTambah", 
				"<i class='fa fa-plus'></i> Tambah Catatan Wali Kelas",
				"?page=$page&sub=simpantambahcatatanwk",
				"form-horizontal",
				"bodytambahcatatanwk",
				"nambahcatatanwk",
				"Simpan");
			}
			$TampilDataSiswa.="
			<tr>
				<td class='text-center'>$no.</td>
				<td>{$Hasil['nis']}</td>
				<td>{$Hasil['nm_siswa']}</td>
				<td>$TmplCatatan</td>
				<td class='text-center'>$AksiCatatan</td>
			</tr>";
			$no++;
		}
		$jmldata=mysql_num_rows($Query);
		if($jmldata>0){
			$Show.=JudulKolom("Catatan Kelas $NamaKelas","commenting");
			$Show.="<p class='text-danger' style='margin-top:-15px;'>$MassaKBM</p>
			<table id='dt_basic' class='table table-striped table-bordered table-hover table-condensed' width='100%'>
				<thead>
					<tr>
						<th class='text-center' data-class='expand'>No.</th>
						<th class='text-center' width='100'>NIS</th>
						<th class='text-center'>Nama Siswa</th>
						<th class='text-center' data-hide='phone,tablet'>Catatan</th>
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
			$Show.="<p class='text-center'><img src='img/aa.png' width='100' height='231' border='0' alt=''></p><h1 class='text-center'><small class='text-danger slideInRight fast animated'><strong>Tahun Pelajaran $TahunAjarAKtif Semester $SemesterAktif</strong> </small><br><small>Data Siswa belum ada, silakan hubungi Administrator.</small> </h1>";
		}

		echo $WKCatWK;
		$tandamodal="#WKCatWK";
		echo IsiPanel($Show);
	break;
	
	case "simpantambahcatatanwk":
		$kd_catwk=buatKode("wk_catatan","catwk_");
		$txtNIS=addslashes($_POST['txtNIS']);
		$txtThnAjaran=addslashes($_POST['txtThnAjaran']);
		$txtSmstr=addslashes($_POST['txtSmstr']);
		$txtCatatan=addslashes($_POST['txtCatatan']);
		mysql_query("INSERT INTO wk_catatan VALUES ('$kd_catwk','$txtNIS','$txtThnAjaran','$txtSmstr','$txtCatatan')");
		echo ns("Nambah","parent.location='?page=$page'","Catatan Wali Kelas");
	break;

	case "simpaneditcatatanwk":
		$txtIDCat=addslashes($_POST['txtIDCat']);
		$txtNIS=addslashes($_POST['txtNIS']);
		$txtThnAjaran=addslashes($_POST['txtThnAjaran']);
		$txtSmstr=addslashes($_POST['txtSmstr']);
		$txtCatatan=addslashes($_POST['txtCatatan']);
		$TglPelLomba=trim($_POST['txtThnLomba'])."-".trim($_POST['txtBlnLomba'])."-".trim($_POST['txtTglLomba']);
		mysql_query("UPDATE wk_catatan SET nis='$txtNIS',tahunajaran='$txtThnAjaran',semester='$txtSmstr',catatan='$txtCatatan' where id_cat='".trim($_POST['txtIDCat'])."'");
		echo ns("Ngedit","parent.location='?page=$page'","Catatan Wali Kelas");
	break;

	case "hapus":
		mysql_query("DELETE FROM wk_catatan WHERE id_cat='".$_GET['id_cat']."'");
		echo ns("Hapus","parent.location='?page=$page'","Catatan Wali Kelas");
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

	$('.tmpleditcatatanwk').click(function(){
		var id = $(this).attr("id");
		$.ajax({
			url: 'lib/app_modal.php?md=CatatanWkEdit',
			method: 'post',
			data: {id:id},
			success:function(data){
				$('#bodyeditcatatanwk').html(data);
				$('#CatatanWkEdit').modal("show");
			}
		});
	});

	$('.tmpltambahcatatanwk').click(function(){
		var id = $(this).attr("id");
		$.ajax({
			url: 'lib/app_modal.php?md=CatatanWkTambah',
			method: 'post',
			data: {id:id},
			success:function(data){
				$('#bodytambahcatatanwk').html(data);
				$('#CatatanWkTambah').modal("show");
			}
		});
	});
})
</script>