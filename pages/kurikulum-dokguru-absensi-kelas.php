<?php
require_once("inc/init.php");
require_once("inc/config.ui.php");
$page_title = "Absensi Kelas";
$page_css[] = "your_style.css";
include("inc/header.php");
$page_nav["kurikulum"]["sub"]["dokumenguru"]["sub"]["absensikelas"]["active"] = true;
include("inc/nav.php");
echo "<div id='main' role='main'>";
$breadcrumbs["Kurikulum / Dokumen Guru"] = "";
include("inc/ribbon.php");	
$sub = (isset($_GET['sub']))? $_GET['sub'] : "";
switch ($sub)
{
	case "tampil":default:
		$pilthaj=(isset($_GET['pilthaj']))?$_GET['pilthaj']:"";
		$piltk=(isset($_GET['piltk']))?$_GET['piltk']:"";
		$pilkls=(isset($_GET['pilkls']))?$_GET['pilkls']:"";
		$Show.="
		<script>
		function printContent(el){
			var restorepage=document.body.innerHTML;
			var printcontent=document.getElementById(el).innerHTML;
			document.body.innerHTML=printcontent;
			window.print();
			document.body.innerHTML=restorepage;
		}
		</script>";
		//$Show.="<button class='btn btn-primary btn-sm pull-right' onclick=\"printContent('Nyetak')\" style='margin-top:-10px;margin-right:10px'>Cetak</button>";
		//$Show.=JudulKolom("<strong>Cetak</strong> <i class='text-danger'>Absensi Siswa</i> ","print");
		$FormPilih.="
		<form action='?page=$page' method='post' name='frmPilih' class='form-inline' role='form'>
			<div class='row'>
				<div class='col-sm-6 col-md-6'>
					<div class='form-group'>Pililh Data &nbsp;&nbsp;</div>".
					FormCF("inline","Tahun Ajaran","txtTa","select * from ak_tahunajaran order by id_thnajar asc","tahunajaran",$pilthaj,"tahunajaran","","onchange=\"document.location.href='?page=$page&pilthaj='+document.frmPilih.txtTa.value\"").
					FormCF("inline","Tingkat","txtTingkat","select * from ak_kelas where tahunajaran='$pilthaj' group by tingkat","tingkat",$piltk,"tingkat","","onchange=\"document.location.href='?page=$page&pilthaj='+document.frmPilih.txtTa.value+'&piltk='+document.frmPilih.txtTingkat.value\"").
				"</div>
				<div class='col-sm-6 col-md-6'>$infopilih</div>
			</div>
		</form>";
		$Show.=KolomPanel($FormPilih);
		$QKls=mysql_query("select ak_kelas.id_kls,ak_kelas.kode_pk,ak_kelas.pararel,ak_kelas.tahunajaran,ak_kelas.tingkat,ak_kelas.nama_kelas from ak_kelas inner join ak_perkelas on ak_kelas.tahunajaran=ak_perkelas.tahunajaran and ak_kelas.tingkat=ak_perkelas.tk and ak_kelas.nama_kelas=ak_perkelas.nm_kelas where ak_kelas.tahunajaran='$pilthaj' and ak_kelas.tingkat='$piltk' group by ak_perkelas.nm_kelas order by ak_kelas.kode_pk,pararel");
		
		$JmlKls=mysql_num_rows($QKls);
		if($JmlKls>0){
			while($HKls=mysql_fetch_array($QKls)){
				$Cetak.="<button class='btn btn-default btn-sm btn-block' onclick=\"printContent('Nyetak{$HKls['id_kls']}')\" style='margin-top:-10px;'>{$HKls['nama_kelas']}</button><br>";
				
				$TmplSiswa.="
				<div class='panel panel-default'>
				<div class='panel-body'>
					<h6 style='margin-top:0px;margin-bottom:5px;'><i class='fa fa-$i text-danger'></i> <span class='text-primary'><strong>Review  Cetak <span class='text-danger'>{$HKls['nama_kelas']}</span></strong></span></h6>
					<hr style='margin-left:-15px;margin-right:-15px;margin-top:10px;margin-bottom:25px;'>
					<div id='Nyetak{$HKls['id_kls']}'>
						<table style='margin: 0 auto;width:100%;border-collapse:collapse;font:9px Arial;'>
							<tr>
								<td colspan='2' align='center'><img src='img/kossurat2.jpg' width='811' height='174' border='0' alt=''></td>
							</tr>
							<tr>
								<td colspan='2' align='center'><font size='2'><br><strong>ABSENSI SISWA</strong></font></td>
							</tr>
							<tr>
								<td colspan='2' align='center'><font size='2'>TAHUN PELAJARAN $pilthaj</font></td>
							</tr>
							<tr>
								<td colspan=2>&nbsp;<td>
							</tr>
						</table>
						<table style='margin: 0 auto;width:100%;border-collapse:collapse;font:12px Arial;'>
						<tr>
						<td>Kelas : <strong>{$HKls['nama_kelas']}</strong></td>
						<td align='right'>Bulan : ................................................</td>
						</tr>
						</table>
						<table style='margin: 0 auto;width:100%;border-collapse:collapse;font:10px Arial;background: transparent;color-border:black;' border='1'>
						<thead>
						<tr style='border-color:#000000;'>
							<th rowspan='2' align='center'>No.</th>
							<th rowspan='2' align='center'>NIS</th>
							<th rowspan='2' align='center'>Nama Lengkap</th>
							<th rowspan='2' align='center'>L/P</th>
							<th colspan='31' align='center'>Tanggal Tatap Muka</th>
							<th colspan='3' align='center'>Absensi</th>
							<th rowspan='2' align='center'>Jml</th>
						</tr>
						<tr style='border-color:#000000;'>";
							for($a=1;$a<=31;$a++)
							{
								$TmplSiswa.="<td align='center' width='10'>$a</td>";
							}
						$TmplSiswa.="
							<th width='10' align='center'>S</th>
							<th width='10' align='center'>I</th>
							<th width='10' align='center'>A</th>
						</tr>
						</thead>
						<tbody>";
					$QSis=mysql_query("select ak_perkelas.tahunajaran,ak_perkelas.tk,ak_perkelas.nm_kelas,siswa_biodata.nis,siswa_biodata.nm_siswa,IF(siswa_biodata.jenis_kelamin='Laki-laki','L',IF(siswa_biodata.jenis_kelamin='Perempuan','P',''))jenis_kelamin from ak_perkelas inner join siswa_biodata on ak_perkelas.nis=siswa_biodata.nis where ak_perkelas.tahunajaran='$pilthaj' and ak_perkelas.nm_kelas='{$HKls['nama_kelas']}'");
					$JmlData=mysql_num_rows($QSis);
					$JmlLelaki=JmlDt("select ak_perkelas.tahunajaran,ak_perkelas.tk,ak_perkelas.nm_kelas,siswa_biodata.nis,siswa_biodata.nm_siswa,IF(siswa_biodata.jenis_kelamin='Laki-laki','L',IF(siswa_biodata.jenis_kelamin='Perempuan','P',''))jenis_kelamin from ak_perkelas inner join siswa_biodata on ak_perkelas.nis=siswa_biodata.nis where ak_perkelas.tahunajaran='$pilthaj' and ak_perkelas.nm_kelas='{$HKls['nama_kelas']}' and siswa_biodata.jenis_kelamin='Laki-laki'");
					$JmlPerempuan=JmlDt("select ak_perkelas.tahunajaran,ak_perkelas.tk,ak_perkelas.nm_kelas,siswa_biodata.nis,siswa_biodata.nm_siswa,IF(siswa_biodata.jenis_kelamin='Laki-laki','L',IF(siswa_biodata.jenis_kelamin='Perempuan','P',''))jenis_kelamin from ak_perkelas inner join siswa_biodata on ak_perkelas.nis=siswa_biodata.nis where ak_perkelas.tahunajaran='$pilthaj' and ak_perkelas.nm_kelas='{$HKls['nama_kelas']}' and siswa_biodata.jenis_kelamin='Perempuan'");
					$JumlahJK=$JmlLelaki+$JmlPerempuan;
					$NoSis=1;
					while($HSis=mysql_fetch_array($QSis)){
						$TmplSiswa.="
						<tr style='border-color:#000000;'>
							<td align='center'>$NoSis.</td>
							<td align='center'>{$HSis['nis']}</td>
							<td style='padding-left:5px;'>{$HSis['nm_siswa']}</td>
							<td align='center'>{$HSis['jenis_kelamin']}</td>";
							for($a=1;$a<=31;$a++)
							{
								$TmplSiswa.="<td></td>";
							}
						$TmplSiswa.="
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>";
						$NoSis++;
					}
					$QWK=mysql_query("select ak_kelas.id_kls,ak_kelas.id_guru,app_user_guru.gelardepan,app_user_guru.nama_lengkap, app_user_guru.gelarbelakang,app_user_guru.nip from ak_kelas inner join app_user_guru on ak_kelas.id_guru=app_user_guru.id_guru where ak_kelas.id_kls='{$HKls['id_kls']}'");
					$HWK=mysql_fetch_array($QWK);
					if($HWK['gelarbelakang']==""){$koma="";}else{$koma=",";}
					$NamaWK=$HWK['gelardepan']." ".ucwords(strtolower($HWK['nama_lengkap'])).$koma." ".$HWK['gelarbelakang'];
					$NIPWK=$HWK['nip'];

					$QKSA=mysql_query("select * from ak_kepsek where thnajaran='$pilthaj'");
					$HKSA=mysql_fetch_array($QKSA);
					$NamaKepsekA=$HKSA['nama'];
					$NIPKepsekA=$HKSA['nip'];				
			$TmplSiswa.="
					</tbody>
				</table>
					<p></p>
					<table style='margin: 0 auto;width:100%;border-collapse:collapse;font:12px Arial;'>
					<tr>
						<td width='150' valign='top'>
						<strong>Keterangan :</strong>
							<table>
							<tr>
								<td>Laki-laki</td>
								<td>: $JmlLelaki</td>
							</tr>
							<tr>
								<td>Perempuan&nbsp;&nbsp;</td>
								<td>: $JmlPerempuan</td>
							</tr>
							<tr>
								<td>Jumlah</td>
								<td>: $JmlData</td>
							</tr>
							</table>
						</td>
						<td width='50%'>
						Mengetahui : <br>
						Kepala Sekolah, 
						<br><br><br><br><br>
						<strong>$NamaKepsekA</strong><br>
						NIP. $NIPKepsekA
						</td>
						<td>
							Kadipaten, <br>
							Wali Kelas, 
							<br><br><br><br><br>
							<strong>$NamaWK</strong><br>
							NIP. $NIPWK
						</td>
					</tr>
					</table>
				</div>
				</div>
				</div>
				";
			}
			$PilihCetak.=Label("Pilih Kelas");
			$PilihCetak.=$Cetak;
			$Show.=DuaKolomD(2,KolomPanel($PilihCetak),10,$TmplSiswa);
		}
		else if(empty($pilthaj)){
			$Show.=nt("informasi","Silakan pilih tahun ajaran");
		}
		else if(empty($piltk)){
			$Show.=nt("informasi","Silakan pilih tingkat");
		}
		else {
			$Show.=nt("informasi","Data Siswa Belum Ada");
		}
		echo MyWidget('fa-calendar',"Dokumen Guru Absensi Kelas","",$Show);
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
		$('.view_data').click(function(){
			var id = $(this).attr("id");
			$.ajax({
				url: 'pages/modal.php?md=DaftarSiswa',
				method: 'post',
				data: {id:id},
				success:function(data){	
					$('#data_siswa212').html(data);
					$('#myModal').modal("show");
				}
			});
		});
})
</script>
