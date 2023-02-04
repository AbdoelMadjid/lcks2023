<?php
require_once("inc/init.php");
require_once("inc/config.ui.php");
$page_title = "Eskul Siswa";
$page_css[] = "your_style.css";
include("inc/header.php");
$page_nav["walikelas"]["sub"]["eskul"]["active"] = true;
include("inc/nav.php");
echo "<div id='main' role='main'>";
$breadcrumbs["Wali Kelas"] = "";
include("inc/ribbon.php");	
$sub=(isset($_GET['sub']))?$_GET['sub']:"";
switch($sub)
{
	case "tampil":default:
		$Sis2=" and tahunajaran='$TahunAjarAktif' and semester='$SemesterAktif' ";
		$MassaKBM="Tahun Pelajaran $TahunAjarAktif Semester $SemesterAktif";

		$Q="select ak_kelas.id_kls,ak_kelas.nama_kelas,ak_kelas.tahunajaran,siswa_biodata.nis,siswa_biodata.nm_siswa, siswa_biodata.tempat_lahir,siswa_biodata.tanggal_lahir,siswa_biodata.jenis_kelamin from ak_kelas,siswa_biodata,ak_perkelas,ak_paketkeahlian where ak_kelas.nama_kelas=ak_perkelas.nm_kelas and ak_kelas.tahunajaran=ak_perkelas.tahunajaran and ak_perkelas.nis=siswa_biodata.nis and siswa_biodata.kode_paket=ak_paketkeahlian.kode_pk and ak_kelas.id_kls='$IDna' ";
		$no=1;
		$Query=mysql_query("$Q order by siswa_biodata.nis");
		while($Hasil=mysql_fetch_array($Query)){
			$NamaKelas=$Hasil['nama_kelas'];
			$QEskulSiswa=mysql_query("select * from wk_eskul_siswa where nis='{$Hasil['nis']}' and tahunajaran='$TahunAjarAktif' and semester='$SemesterAktif'");
			$DtEskul=mysql_fetch_array($QEskulSiswa);
			if($DtEskul['pil1_desk']==""){$TmplEskul1="";}else{$TmplEskul1="<tr><td width='100'>{$DtEskul['pil1']}</td><td> <strong class='text-danger'>{$DtEskul['pil1_n']}</strong></td></tr>";}
			if($DtEskul['pil2_desk']==""){$TmplEskul2="";}else{$TmplEskul2="<tr><td width='100'>{$DtEskul['pil2']}</td><td> <strong class='text-danger'>{$DtEskul['pil2_n']}</strong></td></tr>";}
			if($DtEskul['pil3_desk']==""){$TmplEskul3="";}else{$TmplEskul3="<tr><td width='100'>{$DtEskul['pil3']}</td><td> <strong class='text-danger'>{$DtEskul['pil3_n']}</strong></td></tr>";}
			if($DtEskul['pil4_desk']==""){$TmplEskul4="";}else{$TmplEskul4="<tr><td width='100'>{$DtEskul['pil4']}</td><td> <strong class='text-danger'>{$DtEskul['pil4_n']}</strong></td></tr>";}
			
			$ShowEskul="
				<table>
					$TmplEskul1 $TmplEskul2 $TmplEskul3 $TmplEskul4 
				</table>";
			if(mysql_num_rows($QEskulSiswa)>=1){
				$TampilEskulSiswa="
				<a data-toggle='modal' href='#EskulEdit' id='{$DtEskul['id_ekstra']}' class='tmplediteskul'><i class='fa fa-pencil-square fa-2x text-info'></i></a>";
				
				echo FormModalEdit(
				"lebar",
				"EskulEdit", 
				"<i class='fa fa-edit'></i> Edit Eskul Siswa",
				"?page=$page&sub=SimpanEditEskul",
				"form-horizontal",
				"bodyediteskul",
				"ngediteskul",
				"Simpan");
				
			}
			else{
				$TampilEskulSiswa="
				<a data-toggle='modal' href='#EskulTambah' id='{$Hasil['nis']}' class='tmpltambaheskul'><i class='fa fa-pencil-square-o fa-2x text-danger'></i></a>";
				echo FormModalEdit(
				"lebar",
				"EskulTambah", 
				"<i class='fa fa-plus'></i> Tambah Eskul Siswa",
				"?page=$page&sub=SimpanTambahEskul",
				"form-horizontal",
				"bodytambaheskul",
				"nambaheskul",
				"Simpan");
			}
			$TampilDataSiswa.="
			<tr>
				<td class='text-center'>$no.</td>
				<td>{$Hasil['nis']}</td>
				<td>{$Hasil['nm_siswa']}</td>
				<td><strong class='text-danger'>{$DtEskul['wajib_n']}</strong></td>
				<td>$ShowEskul</td>
				<td>$TampilEskulSiswa</td>
				<td> 
					<div class='checkbox'>
						<label>
						  <input type='checkbox' class='checkbox style-0'  id='cekbox' name='cekbox[]' value='{$DtEskul['id_ekstra']}'>
						  <span></span>
						</label>
					</div>
				</td>
			</tr>";
			$no++;
		}
		$jmldata=mysql_num_rows($Query);	
		if($jmldata>0) {
			$Show.=JudulKolom("Eskul Kelas $NamaKelas","futbol-o");
			$Show.="<p class='text-danger' style='margin-top:-15px;'>$MassaKBM</p>
			<form action='?page=$page&sub=hapusbanyak' method='post' class='form-horizontal'>
			<div class='well no-padding'>
				<table id='dt_basic' class='table table-striped table-bordered table-hover table-condensed' width='100%'>
					<thead>
						<tr>
							<th class='text-center' data-class='expand'>No.</th>
							<th class='text-center'>NIS</th>
							<th class='text-center'>Nama Siswa</th>
							<th class='text-center' data-hide='phone,tablet'>Eskul Wajib Prmuka</th>
							<th class='text-center' data-hide='phone,tablet'>Eskul Pilihan</th>
							<th class='text-center' data-hide='phone'>Aksi</th>
							<th class='text-center' data-hide='phone'>Pilih</th>
						</tr>
					</thead>
					<tbody>
					$TampilDataSiswa
					</tbody>
				</table>
			</div>
			";
			$Show.="<div class='form-actions'>".ButtonSimpanName("SaveUpdate","Hapus Data Terpilih")."</div>";
			$Show.="</form>";
		}
		else 
		{
			$Show.="<p class='text-center'><img src='img/aa.png' width='100' height='231' border='0' alt=''></p><h1 class='text-center'><small class='text-danger slideInRight fast animated'><strong>Tahun Pelajaran $TahunAjarAktif Semester $SemesterAktif</strong> </small><br><small>Data Siswa belum ada, silakan hubungi Administrator.</small> </h1>";
		}

		$tandamodal="#WKEskulSiswa";
		echo $WKEskulSiswa;
		echo IsiPanel($Show);
	break;
	case "hapusbanyak":
		$cekbox = $_POST['cekbox'];
		if ($cekbox) {
			foreach ($cekbox as $value) {
				mysql_query("DELETE FROM wk_eskul_siswa WHERE id_ekstra='$value'");
				echo $value;
				echo ",";
			}
			echo ns("Hapus","parent.location='?page=$page'","Eskul");
		}  else {
			echo ns("BelumMilih","parent.location='?page=$page'","Eskul");
		}
	break;
	case "SimpanEditEskul":
		$txtIdEkstra=addslashes($_POST['txtIdEkstra']);
		$txtNIS=addslashes($_POST['txtNIS']);
		$txtThnAjaran=addslashes($_POST['txtThnAjaran']);
		$txtSmstr=addslashes($_POST['txtSmstr']);
		$txtWajib=addslashes($_POST['txtWajib']);
		$txtPWajib=addslashes($_POST['txtPWajib']);
		$txtPil1=addslashes($_POST['txtPil1']);
		$txtPPil1=addslashes($_POST['txtPPil1']);
		$txtPil2=addslashes($_POST['txtPil2']);
		$txtPPil2=addslashes($_POST['txtPPil2']);
		$txtPil3=addslashes($_POST['txtPil3']);
		$txtPPil3=addslashes($_POST['txtPPil3']);
		$txtPil4=addslashes($_POST['txtPil4']);
		$txtPPil4=addslashes($_POST['txtPPil4']);
		$WajibDesk=trim($_POST['txtPWajib'])." dalam mengikuti kegiatan ".trim($_POST['txtWajib']);
		if(trim($_POST['txtPil1'])==""){$Pil1Desk="";}
		else{
			$Pil1Desk=trim($_POST['txtPPil1'])." dalam mengikuti kegiatan ".trim($_POST['txtPil1']);
		}
		if(trim($_POST['txtPil2'])==""){$Pil2Desk="";}
		else{
			$Pil2Desk=trim($_POST['txtPPil2'])." dalam mengikuti kegiatan ".trim($_POST['txtPil2']);
		}
		if(trim($_POST['txtPil3'])==""){$Pil3Desk="";}
		else{
			$Pil3Desk=trim($_POST['txtPPil3'])." dalam mengikuti kegiatan ".trim($_POST['txtPil3']);
		}
		if(trim($_POST['txtPil4'])==""){$Pil4Desk="";}
		else{
			$Pil4Desk=trim($_POST['txtPPil4'])." dalam mengikuti kegiatan ".trim($_POST['txtPil4']);
		}
		mysql_query("
		UPDATE wk_eskul_siswa SET nis='$txtNIS',tahunajaran='$txtThnAjaran',semester='$txtSmstr',
		wajib='$txtWajib',wajib_n='$txtPWajib',wajib_desk='$WajibDesk',pil1='$txtPil1',
		pil1_n='$txtPPil1',pil1_desk='$Pil1Desk',pil2='$txtPil2',pil2_n='$txtPPil2',
		pil2_desk='$Pil2Desk',pil3='$txtPil3',pil3_n='$txtPPil3',pil3_desk='$Pil3Desk',
		pil4='$txtPil4',pil4_n='$txtPPil4',pil4_desk='$Pil4Desk' where id_ekstra='".trim($_POST['txtIdEkstra'])."'");
		echo ns("Ngedit","parent.location='?page=$page'","Eskul");
	break;
	
	case "SimpanTambahEskul":
		$kd_eskul=buatKode("wk_eskul_siswa","esk_");
		$txtNIS=addslashes($_POST['txtNIS']);
		$txtThnAjaran=addslashes($_POST['txtThnAjaran']);
		$txtSmstr=addslashes($_POST['txtSmstr']);
		$txtWajib=addslashes($_POST['txtWajib']);
		$txtPWajib=addslashes($_POST['txtPWajib']);
		$txtPil1=addslashes($_POST['txtPil1']);
		$txtPPil1=addslashes($_POST['txtPPil1']);
		$txtPil2=addslashes($_POST['txtPil2']);
		$txtPPil2=addslashes($_POST['txtPPil2']);
		$txtPil3=addslashes($_POST['txtPil3']);
		$txtPPil3=addslashes($_POST['txtPPil3']);
		$txtPil4=addslashes($_POST['txtPil4']);
		$txtPPil4=addslashes($_POST['txtPPil4']);
		$WajibDesk=trim($_POST['txtPWajib'])." dalam mengikuti kegiatan ".trim($_POST['txtWajib']);
		if(trim($_POST['txtPil1'])==""){$Pil1Desk="";}
		else{
			$Pil1Desk=trim($_POST['txtPPil1'])." dalam mengikuti kegiatan ".trim($_POST['txtPil1']);
		}
		if(trim($_POST['txtPil2'])==""){$Pil2Desk="";}
		else{
			$Pil2Desk=trim($_POST['txtPPil2'])." dalam mengikuti kegiatan ".trim($_POST['txtPil2']);
		}
		if(trim($_POST['txtPil3'])==""){$Pil3Desk="";}
		else{
			$Pil3Desk=trim($_POST['txtPPil3'])." dalam mengikuti kegiatan ".trim($_POST['txtPil3']);
		}
		if(trim($_POST['txtPil4'])==""){$Pil4Desk="";}
		else{
			$Pil4Desk=trim($_POST['txtPPil4'])." dalam mengikuti kegiatan ".trim($_POST['txtPil4']);
		}	
		mysql_query("INSERT INTO wk_eskul_siswa VALUES ('$kd_eskul','$txtNIS','$txtThnAjaran','$txtSmstr','$txtWajib','$txtPWajib','$WajibDesk', '$txtPil1','$txtPPil1','$Pil1Desk','$txtPil2','$txtPPil2','$Pil2Desk','$txtPil3','$txtPPil3','$Pil3Desk','$txtPil4','$txtPPil4','$Pil4Desk')");
		echo ns("Nambah","parent.location='?page=$page'","Eskul");
	break;
	case "hapus":
		mysql_query("DELETE FROM wk_eskul_siswa WHERE id_ekstra='".$_GET['ideskul']."'");
		echo '<div id="preloader"><div id="cssload"></div></div>';
		echo ns("Hapus","parent.location='?page=$page'","Eskul");
	break;
}
echo '</div>';
include("inc/footer.php");
include("inc/scripts.php");
//"))
?>
<!-- PAGE RELATED PLUGIN(S) -->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/datatables/dataTables.colVis.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/datatables/dataTables.tableTools.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/datatables/dataTables.bootstrap.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/datatable-responsive/datatables.responsive.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/jquery-form/jquery-form.min.js"></script>
<script type="text/javascript">
// DO NOT REMOVE : GLOBAL FUNCTIONS!
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
	$('.tmplediteskul').click(function(){
		var id = $(this).attr("id");
		$.ajax({
			url: 'lib/app_modal.php?md=EskulEdit',
			method: 'post',
			data: {id:id},
			success:function(data){
				$('#bodyediteskul').html(data);
				$('#EskulEdit').modal("show");
			}
		});
	});
	$('.tmpltambaheskul').click(function(){
		var id = $(this).attr("id");
		$.ajax({
			url: 'lib/app_modal.php?md=EskulTambah',
			method: 'post',
			data: {id:id},
			success:function(data){
				$('#bodytambaheskul').html(data);
				$('#EskulTambah').modal("show");
			}
		});
	});
})
</script>
