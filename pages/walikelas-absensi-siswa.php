<?php
require_once("inc/init.php");
require_once("inc/config.ui.php");
$page_title = "Absensi Siswa";
$page_css[] = "your_style.css";
include("inc/header.php");
$page_nav["walikelas"]["sub"]["absensisiswa"]["active"] = true;
include("inc/nav.php");
echo "<div id='main' role='main'>";
$breadcrumbs["Wali Kelas"] = "";
include("inc/ribbon.php");	
$sub=(isset($_GET['sub']))?$_GET['sub']:"";
switch($sub)
{
	case "tampil":default:
		$aksi=isset($_GET['aksi'])?$_GET['aksi']:"";

		$Sis=" and ak_kelas.id_kls='$IDna' ";
		$Sis2=" and tahunajaran='$TahunAjarAktif' and semester='$SemesterAktif' ";
		$MassaKBM="Tahun Pelajaran $TahunAjarAktif Semester $SemesterAktif";
		$P1="$TahunAjarAktif";
		$P2="$SemesterAktif";
		$P3="$IDna";
		$SisA1=" where ak_kelas.id_kls='$IDna' and ak_kelas.tahunajaran='$TahunAjarAktif'";
		$SisA2=" and tahunajaran='$TahunAjarAktif' and semester='$SemesterAktif' ";

		$Q=mysql_query("select 
		ak_kelas.id_kls,
		ak_kelas.nama_kelas,
		ak_kelas.tahunajaran,
		siswa_biodata.nis,
		siswa_biodata.nm_siswa,
		siswa_biodata.jenis_kelamin 
		from 
		ak_kelas,
		siswa_biodata,
		ak_perkelas,
		ak_paketkeahlian where 
		ak_kelas.nama_kelas=ak_perkelas.nm_kelas and 
		ak_kelas.tahunajaran=ak_perkelas.tahunajaran and 
		ak_perkelas.nis=siswa_biodata.nis and 
		siswa_biodata.kode_paket=ak_paketkeahlian.kode_pk $Sis order by siswa_biodata.nm_siswa,siswa_biodata.nis");
		$no=1;
		$noisi=1;
		while($Hasil=mysql_fetch_array($Q))
		{
		// data absensi
			$NamaKelas=$Hasil['nama_kelas'];
			$QABs=mysql_query("select * from wk_absensi where nis='{$Hasil['nis']}' $Sis2");
			$DAbsensi=mysql_fetch_array($QABs);
			$JAbsensi=mysql_num_rows($QABs);
			if($JAbsensi>0){
				if($aksi=="reviewabsen"){
					$TmblIsi="<a href='?page=$page' class='btn btn-sm btn-danger'>Kembali</a>";
				}
				else{
					$TmblIsi="<a href='?page=$page&aksi=reviewabsen' class='btn btn-sm btn-info'>REVIEW / EDIT ABSENSI</a>";
				}
			}
			else{
				if($aksi=="isiabsen"){
					$TmblIsi="<a href='?page=$page' class='btn btn-sm btn-danger'>Kembali</a>";
				}
				else{
					$TmblIsi="<a href='?page=$page&aksi=isiabsen' class='btn btn-sm btn-info'>ISI ABSENSI</a>";
				}
				
			}
			
			$TotalSakit=$TotalSakit+$DAbsensi['sakit'];
			$TotalIzin=$TotalIzin+$DAbsensi['izin'];
			$TotalAlfa=$TotalAlfa+$DAbsensi['alfa'];
			$TotalJml=$TotalJml+$DAbsensi['jmlabsen'];
			
		// review absensi
			$TampilDataSiswaReview.="
			<tr>
				<td class='text-center'>$no.</td>
				<td>{$Hasil['nis']}<br>{$Hasil['nm_siswa']}</td>
				<td>{$DAbsensi['sakit']}</td>
				<td>{$DAbsensi['izin']}</td>
				<td>{$DAbsensi['alfa']}</td>
				<td>{$DAbsensi['jmlabsen']}</td>
				<td class='text-center'>
					<a data-toggle='modal' href='#EditAbsensi' id='{$DAbsensi['id_absensi']}' class='tmpleditabsen'><i class='fa fa-pencil-square-o fa-2x txt-color-red'></i></a>
				</td>
			</tr>";
			$no++;
		// ngisi absen satu ak_kelas
			$TampilDataSiswaNgisiAbsen.="
			<tr>
				<td class='text-center'>$noisi.</td>
				<td>{$Hasil['nis']}</td>
				<td>{$Hasil['nm_siswa']}
					<input type='hidden' class='form-control input-sm' name='txtIdKelas[$i]' value='".$P3."'>
					<input type='hidden' class='form-control input-sm' name='txtNIS[$i]' value='".$Hasil['nis']."'>
					<input type='hidden' class='form-control input-sm' name='txtThnAjaran[$i]' value='".$P1."'>
					<input type='hidden' class='form-control input-sm' name='txtSmstr[$i]' value='".$P2."'>
				</td>
				<td><input size='3' type='text' class='form-control input-sm' maxlength='2' name='txtSakit[$i]'></td>
				<td><input size='3' type='text' class='form-control input-sm' maxlength='3' name='txtIzin[$i]'></td>
				<td><input size='3' type='text' class='form-control input-sm' maxlength='3' name='txtAlfa[$i]'></td>
			</tr>";
			$noisi++;
		
		}
		$jmldata=mysql_num_rows($Q);
		
		if($jmldata>0){
		// Tampilan data statistik absensi
			$StatistikAbsensi="
			<p class='text-danger' style='margin-top:-15px;'>$MassaKBM</p>
			<div class='well no-padding'>
			<table class='table'>
				<tr bgcolor='#f2f2f2'>
					<td>No</td>
					<td>Absensi</td>
					<td>Jumlah</td>
					<td>Terbilang</td>
				</tr>
				<tr>
					<td>1.</td>
					<td>Sakit</td>
					<td>$TotalSakit</td>
					<td>".terbilang($TotalSakit)."</td>
				</tr>
				<tr>
					<td>2.</td>
					<td>Izin</td>
					<td>$TotalIzin</td>
					<td>".terbilang($TotalIzin)."</td>
				</tr>
				<tr>
					<td>3.</td>
					<td>Alfa</td>
					<td>$TotalAlfa</td>
					<td>".terbilang($TotalAlfa)."</td>
				</tr>
				<tr bgcolor='#f2f2f2'>
					<td colspan='2' align='center'><strong>Total</strong></td>
					<td>$TotalJml</td>
					<td>".terbilang($TotalJml)."</td>
				</tr>
			</table>
			</div>
			<div class='btn-group btn-group-justified'>$TmblIsi</div>";
		// Tampilan grafik
		
			$Gr.="		
			<table class='highchart' data-graph-container-before='1' data-graph-type='area' style='display:none' data-graph-legend-disabled='1' data-graph-height='225' data-graph-datalabels-enabled='1' data-graph-datalabels-align='top' data-graph-datalabels-color='red'>
				<thead>
					<tr>                                  
						<th>Absensi</th>
						<th>Jumlah</th>
					</tr>
				 </thead>
				 <tbody>
					<tr>
						<td>Sakit</td>
						<td>$TotalSakit</td>
					</tr>
					<tr>
						<td>Izin</td>
						<td>$TotalIzin</td>
					</tr>
					<tr>
						<td>Alfa</td>
						<td>$TotalAlfa</td>
					</tr>
				</tbody>
			</table>";
		// bagian kanan awal grafik absen
			if($aksi==""){
				$BagKanan.=JudulKolom("Grafik Absensi $NamaKelas","bar-chart");
				$BagKanan.=$Gr;
			}
		// bagian kanan review absen
			else if($aksi=="reviewabsen"){
				$jmldata=mysql_num_rows($Q);		
				if($jmldata>0){	
					$BagKanan.=JudulKolom("Absensi Kelas $NamaKelas","calendar");
					$BagKanan.="
					<div class='well no-padding'>
					<table id='dt_basic' class='table table-striped table-bordered table-hover table-condensed' width='100%'>
						<thead>
							<tr>
								<th class='text-center' data-class='expand'>NO.</th>
								<th class='text-center'>NIS - Nama Siswa</th>
								<th class='text-center' data-hide='phone,tablet'>Sakit</th>
								<th class='text-center' data-hide='phone,tablet'>Izin</th>
								<th class='text-center' data-hide='phone,tablet'>Alfa</th>
								<th class='text-center'>Total</th>
								<th class='text-center'>Aksi</th>
							</tr>
						</thead>
						<tbody>
							$TampilDataSiswaReview
						</tbody>
					</table>
					</div>";
				}
				else{
					$BagKanan.=nt("perhatian","Data Siswa Belum Ada, Silakan Hubungi Administrator");
				}
			}
		// bagian kanan ngisi absen
			else if($aksi=="isiabsen"){
				$jmldata=mysql_num_rows($Q);		
				if($jmldata>0){
					$BagKanan.=JudulKolom("Mengisi Absensi $NamaKelas","pencil-square-o");
					$BagKanan.="
					<form action='?page=$page&sub=simpantambahabsen' method='post' name='FrmAbsenWK' id='FrmAbsenWK' role='form'>
					<div class='well no-padding'>
					<table id='dt_basic' class='table table-striped table-bordered table-hover table-condensed' width='100%'>
						<thead>
							<tr>
								<th class='text-center' data-class='expand'>NO.</th>
								<th class='text-center' width='100' data-hide='phone'>NIS</th>
								<th class='text-center'>NAMA SISWA</th>
								<th class='text-center' data-hide='phone'>SAKIT</th>
								<th class='text-center' data-hide='phone'>IZIN</th>
								<th class='text-center' data-hide='phone'>ALFA</th>
							</tr>
						</thead>
						<tbody>
							$TampilDataSiswaNgisiAbsen
						</tbody>
					</table>
					</div>";
					$BagKanan.="<div class='form-actions'>";
					$BagKanan.=ButtonSimpanName("SaveTambah","Simpan");
					$BagKanan.="</div></form>";
				}
				else{
					$BagKanan.=nt("perhatian","Data Siswa Belum Ada, Silakan Hubungi Administrator");
				}			
			}
		// tampilkan di browser
			$Tmpl.=DuaKolomD(4,KolomPanel(JudulKolom("Rekapitulasi Absensi $NamaKelas","list").$StatistikAbsensi.''),8,KolomPanel($BagKanan));	
		}
		else{
			$Tmpl.="<p class='text-center'><img src='img/aa.png' width='100' height='231' border='0' alt=''></p><h1 class='text-center'><small class='text-danger slideInRight fast animated'><strong>$MassaKBM</strong> </small><br><small>Data Siswa belum ada, silakan hubungi Administrator.</small> </h1>";
		}
		
		
		$tandamodal="#WKAbsensiSiswa";
		echo $WKAbsensiSiswa;
		echo FormModalEdit(
		"sedang",
		"EditAbsensi", 
		"Edit Absensi Siswa",
		"?page=$page&sub=simpanedit",
		"form-horizontal",
		"bodyeditabsen",
		"ngeditabsen",
		"Simpan");

		echo IsiPanel($Tmpl);
	break;
	
	case "simpantambahabsen":
		foreach($_POST['txtNIS'] as $i => $txtNIS){
			$txtIdKelas=$_POST['txtIdKelas'][$i];
			$txtThnAjaran=$_POST['txtThnAjaran'][$i];
			$txtSmstr=$_POST['txtSmstr'][$i];
			$txtSakit=$_POST['txtSakit'][$i];
			$txtIzin=$_POST['txtIzin'][$i];
			$txtAlfa=$_POST['txtAlfa'][$i];
			//$kd_ngabsen=buatKode("wk_absensi","awk_");
			$jmlabsen=$txtSakit+$txtIzin+$txtAlfa;
			mysql_query("INSERT INTO wk_absensi VALUES ('','$txtIdKelas','$txtNIS','$txtThnAjaran','$txtSmstr','$txtSakit', '$txtIzin','$txtAlfa','$jmlabsen')");
			echo ns("Nambah","parent.location='?page=$page&aksi=reviewabsen'","Absensi Siswa");
		}
	break;
	
	case "simpanedit":
		$txtKDA=addslashes($_POST['txtKDA']);
		$txtIdKelas=addslashes($_POST['txtIdKelas']);
		$txtNIS=addslashes($_POST['txtNIS']);
		$txtThnAjaran=addslashes($_POST['txtThnAjaran']);
		$txtSmstr=addslashes($_POST['txtSmstr']);
		$txtSakit=addslashes($_POST['txtSakit']);
		$txtIzin=addslashes($_POST['txtIzin']);
		$txtAlfa=addslashes($_POST['txtAlfa']);
		$txtTa=addslashes($_POST['txtTa']);
		$jmlabsen=$txtSakit+$txtIzin+$txtAlfa;
		mysql_query("UPDATE wk_absensi Set id_kelas='$txtIdKelas',nis='$txtNIS',tahunajaran='$txtThnAjaran',semester='$txtSmstr',sakit='$txtSakit',izin='$txtIzin', alfa='$txtAlfa',jmlabsen='$jmlabsen' where id_absensi='$txtKDA'");
		echo ns("Ngedit","parent.location='?page=$page&aksi=reviewabsen'","Absensi Siswa");
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
<script src="<?php echo ASSETS_URL; ?>/js/plugin/highchartTable/highcharts.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/highchartTable/jquery.highchartTable.min.js"></script>
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
	$('table.highchart').highchartTable();
	$('.tmpleditabsen').click(function(){
		var id = $(this).attr("id");
		$.ajax({
			url: 'lib/app_modal.php?md=AbsenEdit',
			method: 'post',
			data: {id:id},
			success:function(data){
				$('#bodyeditabsen').html(data);
				$('#EditAbsensi').modal("show");
			}
		});
	});
})
</script>