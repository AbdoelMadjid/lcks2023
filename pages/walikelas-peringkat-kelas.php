<?php
require_once("inc/init.php");
require_once("inc/config.ui.php");
$page_title = "Peringkat Kelas";
$page_css[] = "your_style.css";
include("inc/header.php");
$page_nav["walikelas"]["sub"]["peringkat"]["active"] = true;
include("inc/nav.php");
echo "<div id='main' role='main'>";
$breadcrumbs["Wali Kelas"] = "";
include("inc/ribbon.php");	
$sub=(isset($_GET['sub']))?$_GET['sub']:"";
switch($sub)
{
	case "tampil":default:
		$Kls="$IDKelsWK";
		$TA="$TahunAjarAktif";
		$Smstr="$SemesterAktif";

		$QProfil=mysql_query("select * from app_lembaga");
		$HProfil=mysql_fetch_array($QProfil);
		$QWK=mysql_query("
			select 
			ak_kelas.id_guru,
			app_user_guru.nip,
			app_user_guru.nama_lengkap,
			app_user_guru.gelardepan,
			app_user_guru.gelarbelakang,
			ak_kelas.nama_kelas 
			from 
			ak_kelas,app_user_guru 
			where 
			ak_kelas.id_guru=app_user_guru.id_guru and 
			ak_kelas.kode_kelas='$IDKelsWK' and 
			ak_kelas.tahunajaran='$TahunAjarAktif'");

		$HWK=mysql_fetch_array($QWK);
		if($HWK['gelarbelakang']==""){$koma="";}else{$koma=",";}
		$NIPWK="NIP. ".$HWK['nip'];
		$NamaWK=$HWK['gelardepan']." ".$HWK['nama_lengkap'].$koma." ".$HWK['gelarbelakang'];
		$Kalasname=$HWK['nama_kelas'];
		$Titimangsa=$HProfil['kecamatan'];
		$Tgl=TglLengkap($tglSekarang=date('Y-m-d'));
		$QKS=mysql_query("select * from ak_kepsek where thnajaran='$TahunAjarAktif' and smstr='$SemesterAktif'");
		$HKS=mysql_fetch_array($QKS);
		$NamaKepsek=$HKS['nama'];
		$NIPKepsek=$HKS['nip'];
		$IdentKelas="
		<table style='margin: 0 auto; width:100%;border-collapse:collapse;font:14px Arial;'>
		<tr>
			<td width='100'>Tahun Ajaran</td>
			<td width='5'>:</td>
			<td>$TahunAjarAktif</td>
		</tr>
		<tr>
			<td>Semester</td>
			<td>:</td>
			<td>$SemesterAktif</td>
		</tr>
		<tr>
			<td>Kelas</td>
			<td>:</td>
			<td>$Kalasname [$IDKelsWK]</td>
		</tr>
		</table>";
		$KepsekWaliKelas="
		<table style='margin: 0 auto;width:100%;border-collapse:collapse;font:14px Arial;'>
			<tr>
				<td width='50'>&nbsp;</td>
				<td width='300'><br><br>
					Mengetahui : <br>
					Kepala Sekolah, <br><br><br><br><br>
					<strong>$NamaKepsek</strong><br>
					NIP. $NIPKepsek</td>
				<td width='400'>&nbsp;</td>
				<td width='300'><br><br>
					$Titimangsa, $Tgl<br>
					Wali Kelas, <br><br><br><br><br>
					<strong>$NamaWK</strong><br>
					$NIPWK</td>
				<td width='40'>&nbsp;</td>
			</tr>
		</table>";
		$KepsekWaliKelas2="
		<table style='margin: 0 auto;width:100%;border-collapse:collapse;font:14px Arial;'>
			<tr>
				<td width='50'>&nbsp;</td>
				<td width='400'><br><br>
					Mengetahui : <br>
					Kepala Sekolah, <br><br><br><br><br>
					<strong>$NamaKepsek</strong><br>
					NIP. $NIPKepsek</td>
				<td width='300'>&nbsp;</td>
				<td width='600'><br><br>
					$Titimangsa, $Tgl<br>
					Wali Kelas, <br><br><br><br><br>
					<strong>$NamaWK</strong><br>
					$NIPWK</td>
				<td width='40'>&nbsp;</td>
			</tr>
		</table>";	
		$QRank=mysql_query("
			select n_rank.*,
			ak_kelas.id_kls,
			ak_kelas.kode_kelas,
			ak_kelas.nama_kelas 
			from 
			n_rank inner join ak_kelas on n_rank.id_kls=ak_kelas.kode_kelas 
			where 
			ak_kelas.kode_kelas='$IDKelsWK' and 
			n_rank.thnajaran='$TahunAjarAktif' and 
			n_rank.semester='$SemesterAktif' 
			order by na desc");
		$JmlDataRank=mysql_num_rows($QRank);
		$jmlDataKosong=JmlDt("select * from n_rank where na<'50,00' and id_kls='$IDKelsWK' and thnajaran='$TahunAjarAktif' and semester='$SemesterAktif'");
		$TotalJml=($JmlDataRank-$jmlDataKosong);
		$noRank=1;
		while($HasilRank=mysql_fetch_array($QRank)){
			$QSisRank=mysql_query("select nis,nm_siswa from siswa_biodata where nis='{$HasilRank['nis']}'");
			$HSisRank=mysql_fetch_array($QSisRank);
			$RNAP=$RNAP+$HasilRank['nap'];
			$RNAK=$RNAK+$HasilRank['nak'];
			$RNA=$RNA+$HasilRank['na'];
			$NamaKelasRank=$HasilRank['nama_kelas'];
			$DataRank.="
			<tr>
				<td align='center'>$noRank</td>
				<td align='center'>{$HasilRank['nis']}</td>
				<td style='padding-left:10px;'>{$HSisRank['nm_siswa']}</td>
				<td align='center'>{$HasilRank['nap']}</td>
				<td align='center'>{$HasilRank['nak']}</td>
				<td align='center'>{$HasilRank['na']}</td>
			</tr>";
			$noRank++;
		}
		$RNilKlsP=round(($RNAP/$TotalJml),2);
		$RNilKlsK=round(($RNAK/$TotalJml),2);
		$RNilKlsNA=round(($RNA/$TotalJml),2);

		if($JmlDataRank>0){
			$Rangking.="
			<script>
			function printContent(el){
				var restorepage=document.body.innerHTML;
				var printcontent=document.getElementById(el).innerHTML;
				document.body.innerHTML=printcontent;
				window.print();
				document.body.innerHTML=restorepage;
			}
			</script>
			<a href=\"javascript:;\" onClick=\"window.open('./pages/excel/excel-ranking-ak_kelas.php?&kls=$Kls&thnajaran=$TA&gg=$Smstr')\"><i class='fa fa-download fa-border fa-2x pull-right'></i></a> <a href='javascript:void(0);' title='Cetak Peringkat' onclick=\"printContent('cetakRanking')\"><i class='fa fa-print fa-border fa-2x pull-right'></i></a>
			<br>
			<div id='cetakRanking'>
				<table style='margin: 0 auto; width:100%;border-collapse:collapse;font:16px Arial;'>
					<tr><td align='center'><font size='4'><strong>PERINGKAT KELAS</strong></font></td></tr>
				</table><br>
				$IdentKelas<br>
				<table style='margin: 0 auto; width:100%;border-collapse:collapse;font:12px Arial;border-color:black;' border='1'>
				<thead>
					<tr bgcolor='#cccccc'>
						<th width='30' height='20'>No.</th>
						<th width='85'>NIS</th>
						<th>Nama Siswa</th>
						<th>NA K3</th>
						<th>NA K4</th>
						<th>R2</th>
					</tr>
				</thead>
				<tbody>
					$DataRank
					<tr bgcolor='#cccccc'>
						<td align='center' colspan=3>Rata-Rata Kelas $JmlDataRank - $jmlDataKosong = $TotalJml</td>
						<td align='center'>$RNilKlsP</td>
						<td align='center'>$RNilKlsK</td>
						<td align='center'>$RNilKlsNA</td>
					</tr>
				<tbody>
				</table>
				$KepsekWaliKelas2
			</div>";
		}
		else
		{
			$Rangking.="<p class='text-center'><img src='img/aa.png' width='100' height='231' border='0' alt=''></p><h1 class='text-center'><small class='text-danger slideInRight fast animated'><strong>Tahun Pelajaran $TA Semester $Smstr</strong> </small><br><small>Rangking belum di generate, silakan hubungi Administrator.</small> </h1>";
		}

		echo $WKRanking;
		$tandamodal="#WKRanking";
		echo IsiPanel($Rangking);
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
	$('.sort').click(function (e) {
		var $sort = this;
		var $table = $('#mytable');
		var $rows = $('tbody > tr', $table);
		$rows.sort(function (a, b) {
			var keyA = $('td', a).text();
			var keyB = $('td', b).text();
			if ($($sort).hasClass('asc')) {
				return (keyA > keyB) ? 1 : 0;
			} else {
				return (keyA > keyB) ? 0 : 1;
			}
		});
		$.each($rows, function (index, row) {
			$table.append(row);
		});
		e.preventDefault();
	});
	var kelasna=document.nmkelas.ak_kelas.value;
	var ThnAjaran=document.nmkelas.thnaj.value;
	var Semester=document.nmkelas.smstr.value;
	var responsiveHelper_dt_basic = undefined;
	var responsiveHelper_datatable_fixed_column = undefined;
	var responsiveHelper_datatable_col_reorder = undefined;
	var responsiveHelper_datatable_tabletools = undefined;
	
	var breakpointDefinition = {
		tablet : 1024,
		phone : 480
	};
	$('#datatable_tabletools').dataTable({
		"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-6 hidden-xs'T>r>"+
				"t"+
				"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>",
		"oTableTools": {
			 "aButtons": [
			 "xls",
				{
					"sExtends": "pdf",
					"sTitle": "Peringkat Kelas "+kelasna,
					"sPdfMessage": ThnAjaran+" Semester "+Semester,
					"sPdfSize": "letter"
				}
			 ],
			"sSwfPath": "js/plugin/datatables/swf/copy_csv_xls_pdf.swf"
		},
		"autoWidth" : true,
		"preDrawCallback" : function() {
			if (!responsiveHelper_datatable_tabletools) {
				responsiveHelper_datatable_tabletools = new ResponsiveDatatablesHelper($('#datatable_tabletools'), breakpointDefinition);
			}
		},
		"rowCallback" : function(nRow) {
			responsiveHelper_datatable_tabletools.createExpandIcon(nRow);
		},
		"drawCallback" : function(oSettings) {
			responsiveHelper_datatable_tabletools.respond();
		}
	});
})
</script>