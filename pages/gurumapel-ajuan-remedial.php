<?php
require_once("inc/init.php");
require_once("inc/config.ui.php");
$page_title = "Ajuan Remedial";
$page_css[] = "your_style.css";
include("inc/header.php");
$page_nav["kbm"]["sub"]["ajuanremed"]["active"] = true;
include("inc/nav.php");
echo "<div id='main' role='main'>";
$breadcrumbs["Proses KBM"] = "";
include("inc/ribbon.php");	
$sub=(isset($_GET['sub']))? $_GET['sub'] : "";
switch ($sub)
{
//	==> TAMPILAN AWAL <==
	case "tampil":default:
		$Show.=JudulKolom("Daftar Ajuan Remedial","");

		$QRemedial="SELECT 
			gmp_ajuan_remed.*,
			gmp_ngajar.id_ngajar,
			gmp_ngajar.kd_guru,
			gmp_ngajar.kd_mapel,
			gmp_ngajar.kd_kelas,
			gmp_ngajar.kkmpeng,
			gmp_ngajar.kkmket,
			siswa_biodata.nm_siswa
			from gmp_ajuan_remed 
			INNER JOIN gmp_ngajar ON gmp_ajuan_remed.id_kbm=gmp_ngajar.id_ngajar
			INNER JOIN siswa_biodata ON gmp_ajuan_remed.nis=siswa_biodata.nis
			where gmp_ngajar.kd_guru='$IDna'";

		$no=1;
		$QueryR=mysql_query("$QRemedial ORDER BY gmp_ajuan_remed.nis");
		while($HasilR=mysql_fetch_array($QueryR)){
			$Tgl_Ajuann = TglLengkap("{$HasilR['tgl_ajuan']}");
			$Wkt_Ajuann = AmbilWaktu("{$HasilR['tgl_ajuan']}");

			$JmlNKDP2=JmlDt("select * from gmp_kikd where kode_ranah='KDP' and kode_ngajar='{$HasilR['id_ngajar']}'");			
			$JmlNKDK2=JmlDt("select * from gmp_kikd where kode_ranah='KDK' and kode_ngajar='{$HasilR['id_ngajar']}'");


			$QKIKDP2=mysql_query("SELECT * FROM n_p_kikd where kd_ngajar='{$HasilR['id_ngajar']}' AND nis='{$HasilR['nis']}'");
			$HNKIKDP2=mysql_fetch_array($QKIKDP2);

			$QKIKDK2=mysql_query("SELECT * FROM n_k_kikd where kd_ngajar='{$HasilR['id_ngajar']}' AND nis='{$HasilR['nis']}'");
			$HNKIKDK2=mysql_fetch_array($QKIKDK2);

			$QKIKDUTSUAS2=mysql_query("SELECT * FROM n_utsuas WHERE kd_ngajar='{$HasilR['id_ngajar']}' AND nis='{$HasilR['nis']}'");
			$HKIKDUTSUAS2=mysql_fetch_array($QKIKDUTSUAS2);
			
			$NAP2=round(($HNKIKDP2['kikd_p']+$HKIKDUTSUAS2['uts']+$HKIKDUTSUAS2['uas'])/3,0);

			$NA2=round(((round(($HNKIKDP2['kikd_p']+$HKIKDUTSUAS2['uts']+$HKIKDUTSUAS2['uas'])/3,0)+$HNKIKDK2['kikd_k'])/2),0);
	
			if($NAP2<$HasilR['kkmpeng'] || $HNKIKDK2['kikd_k']<$HasilR['kkmket']){
				$aksi="<a href='?page=$page&sub=perbaikan&tnil=k3&kbm={$HasilR['id_ngajar']}&nis={$HasilR['nis']}' class='btn btn-default btn-sm btn-block'> <small class='text-danger slideInRight fast animated'><i class='fa fa-edit'></i> Perbaiki</small></a>";
			}
			else{
				$aksi="<small class='text-info slideInRight fast animated'><i class='fa fa-check-square'></i> Sudah</small>";
			}

			
			$QMapel=mysql_query("SELECT * FROM ak_matapelajaran where kode_mapel='{$HasilR['kd_mapel']}'");
			$HMapel=mysql_fetch_array($QMapel);

			$QKls=mysql_query("SELECT * FROM ak_kelas where kode_kelas='{$HasilR['kd_kelas']}'");
			$HKls=mysql_fetch_array($QKls);

			$TmpAjuan.="
			<tr>
				<td>$no.</td>
				<td>{$HasilR['nm_siswa']}</td>
				<td>{$HasilR['nis']}</td>
				<td>{$HKls['nama_kelas']}</td>
				<td>{$HMapel['nama_mapel']}</td>
				<td>{$HasilR['thn_ajaran']}</td>
				<td>{$HasilR['smstr']}</td>
				<td>$Tgl_Ajuann</td>
				<td>$Wkt_Ajuann</td>
				<td>$aksi</td>
			</tr>";
			$no++;
		}

		$JmlPengajuan=JmlDt($QRemedial);			
		if($JmlPengajuan>0){
			$Show.="
			<div class='well no-padding'>
				<table id='dt_basic' class='table table-striped table-bordered table-hover table-condensed' width='100%'>
					<thead>
						<tr>
							<th class='text-center' data-class='expand'>No.</th>
							<th class='text-center'>Nama Siswa</th>
							<th class='text-center' data-hide='phone,tablet'>NIS</th>
							<th class='text-center' data-hide='phone,tablet'>Kelas</th>
							<th class='text-center' data-hide='phone,tablet'>Nama Mata Pelajaran</th>
							<th class='text-center' data-hide='phone,tablet'>Tahun Ajaran</th>
							<th class='text-center' data-hide='phone,tablet'>Semester</th>
							<th class='text-center' data-hide='phone,tablet'>Tanggal Ajuan</th>
							<th class='text-center' data-hide='phone,tablet'>Waktu Ajuan</th>
							<th class='text-center'>Status</th>
						</tr>
					</thead>
					<tbody>$TmpAjuan</tbody>
				</table>
			</div>";


		}
		else
		{
			$Show.="<div class='well'>Belum Ada Pengajuan Perubahan Nilai (Remedial)</div>";
		}

		echo IsiPanel($Show);

		echo FormModalDetail("myModal","Detail KBM","data_kbm");
	break;

	case "perbaikan":
		$tnil=isset($_GET['tnil'])?$_GET['tnil']:""; 
		$kbm=isset($_GET['kbm'])?$_GET['kbm']:""; 
		$nis=isset($_GET['nis'])?$_GET['nis']:"";

		$QSiswa=mysql_query("select nm_siswa,nis from siswa_biodata where nis='$nis'");
		$HSiswa=mysql_fetch_array($QSiswa);

		$kkmna=mysql_query("SELECT kkmpeng,kkmket from gmp_ngajar WHERE id_ngajar='$kbm'");
		$HKKM=mysql_fetch_array($kkmna);

		//identifikasi nilai
		if($tnil=="k3"){
			$jmlKD=JmlDt("select * from gmp_kikd where kode_ngajar='$kbm' and kode_ranah='KDP'");
			$QN=mysql_query("SELECT * from n_p_kikd WHERE kd_ngajar='$kbm' AND nis='$nis'");
			$Hasil=mysql_fetch_array($QN);
			$iddb=$Hasil['kd_p_kikd'];
			$KKMnya=$HKKM['kkmpeng'];
			$Textnya="Pengetahuan (K3)";
			$FormNyimpan="<form action='?page=$page&sub=simpanedit&jnil=k3' method='post' name='FrmPerbaikan' id='FrmPerbaikan' role='form'>";
		}
		else if($tnil=="utsuas"){
			$jmlKD=JmlDt("select * from gmp_kikd where kode_ngajar='$kbm' and kode_ranah='KDP'");
			$QN=mysql_query("SELECT * from n_utsuas WHERE kd_ngajar='$kbm' AND nis='$nis'");
			$Hasil=mysql_fetch_array($QN);
			$iddb=$Hasil['kd_utsuas'];
			$KKMnya=$HKKM['kkmpeng'];
			$Textnya="UTS UAS";
			$FormNyimpan="<form action='?page=$page&sub=simpanedit&jnil=utsuas' method='post' name='FrmPerbaikan' id='FrmPerbaikan' role='form'>";
		}
		else if($tnil=="k4"){
			$jmlKD=JmlDt("select * from gmp_kikd where kode_ngajar='$kbm' and kode_ranah='KDK'");
			$QN=mysql_query("SELECT * from n_k_kikd WHERE kd_ngajar='$kbm' AND nis='$nis'");
			$Hasil=mysql_fetch_array($QN);
			$iddb=$Hasil['kd_k_kikd'];
			$KKMnya=$HKKM['kkmket'];
			$Textnya="Keterampilan (K4)";
			$FormNyimpan="<form action='?page=$page&sub=simpanedit&jnil=k4' method='post' name='FrmPerbaikan' id='FrmPerbaikan' role='form'>";
		}

		if($tnil=="k3" || $tnil=="k4"){
			for($x=1;$x<$jmlKD+1;$x++){
				$TampilNilai.="
					<tr height='30'>
						<td align='center'>$x</td>
						<td align='center'><input size='3' type='text' class='form-control input-sm' maxlength='3' value='".$Hasil['kd_'.$x]."' name='txtKD_".$x."[$i]'></td>
					</tr>			
				";
			}
		}
		else {
			$TampilNilai.="
				<tr height='30'>
					<td align='center'>1</td>
					<td align='center'>UTS</td>
					<td align='center'><input size='3' type='text' class='form-control input-sm' maxlength='3' value='".$Hasil['uts']."' name='txtuts'></td>
				</tr>
				<tr height='30'>
					<td align='center'>2</td>
					<td align='center'>UAS</td>
					<td align='center'><input size='3' type='text' class='form-control input-sm' maxlength='3' value='".$Hasil['uas']."' name='txtuas'></td>
				</tr>
			";

		}

		$Show.=ButtonKembali2("?page=$page","style='margin-top:-10px;'");
		$Show.="
		<div class='btn-group pull-right'>
			<button class='btn btn-default dropdown-toggle' data-toggle='dropdown' style='margin-top:-10px;margin-right:10px;'>
				<span class='label label-primary'>$Textnya</span> <span class='hidden-xs'></span><span class='caret'></span>
			</button>
			<ul class='dropdown-menu'>
				<li><a href='?page=$page&sub=perbaikan&tnil=k3&kbm=$kbm&nis=$nis'>Pengetahuan</a>
				<li><a href='?page=$page&sub=perbaikan&tnil=utsuas&kbm=$kbm&nis=$nis'>UTS UAS</a>
				<li><a href='?page=$page&sub=perbaikan&tnil=k4&kbm=$kbm&nis=$nis'>Keterampilan</a>
			</ul>
		</div>";

		$Show.=JudulKolom("Edit Nilai ".$Textnya,"edit");
		$QPTK=mysql_query("
		SELECT gmp_ngajar.id_ngajar,app_user_guru.nip,app_user_guru.nama_lengkap,app_user_guru.gelardepan,app_user_guru.gelarbelakang
		from gmp_ngajar 
		INNER JOIN app_user_guru ON gmp_ngajar.kd_guru=app_user_guru.id_guru
		WHERE id_ngajar='$kbm'");
		$HPTK=mysql_fetch_array($QPTK);

		$QKBM=mysql_query("
		SELECT gmp_ngajar.id_ngajar,gmp_ngajar.thnajaran,gmp_ngajar.semester,gmp_ngajar.ganjilgenap,ak_kelas.nama_kelas, ak_matapelajaran.nama_mapel
		from gmp_ngajar 
		INNER JOIN ak_matapelajaran ON gmp_ngajar.kd_mapel=ak_matapelajaran.kode_mapel
		INNER JOIN ak_kelas ON gmp_ngajar.kd_kelas=ak_kelas.kode_kelas
		WHERE id_ngajar='$kbm'");
		$HKBM=mysql_fetch_array($QKBM);

		$Identitas.="
		<dl class='dl-horizontal' style='margin-bottom:0px;'>
		  <dt>Nomor DB : </dt><dd>$iddb</dd>
		  <dt>Nomor KBM : </dt><dd>$kbm</dd>
		</dl><br><br>";

		$Identitas.="
		<dl class='dl-horizontal' style='margin-bottom:0px;'>
		  <dt>Nama Pengajar : </dt><dd>{$HPTK['nama_lengkap']}</dd>
		  <dt>NIP : </dt><dd>{$HPTK['nip']}</dd>
		  <dt>Mata Pelajaran : </dt><dd>{$HKBM['nama_mapel']}</dd>
		  <dt>Tahun Pelajaran : </dt><dd>{$HKBM['thnajaran']}</dd>
		  <dt>Semester : </dt><dd>{$HKBM['semester']} ({$HKBM['ganjilgenap']})</dd>
		</dl><br><br>";

		$Identitas.="
		<dl class='dl-horizontal' style='margin-bottom:0px;'>
		  <dt>Nama Siswa : </dt><dd>{$HSiswa['nm_siswa']}</dd>
		  <dt>Nama Siswa : </dt><dd>$nis</dd>
		  <dt>Kelas : </dt><dd>{$HKBM['nama_kelas']}</dd>
		</dl>";
					
		$EditNilai.=JudulKolom("Nilai $Textnya","");
		$EditNilai.="
		$FormNyimpan
		<div class='well no-padding'>
		<input class='form-control input-sm' type='hidden' value='$iddb' name='txtIDDB'>
		<input class='form-control input-sm' type='hidden' value='".$Hasil['kd_k_kikd']."' name='txtKd[$i]'>
		<input class='form-control input-sm' type='hidden' value='".$kbm."' name='txtKBM'>
		<input class='form-control input-sm' type='hidden' value='".$nis."' name='txtNIS'>
		<input type='hidden'  value='".$jmlKD."' name='txtJKD'>
		<table class='table table-striped table-bordered table-hover table-condensed' width='100%'>
			<thead>
				<tr>
					<th class='text-center' data-class='expand'>No. KIKD</th>
					<th class='text-center' data-hide='phone'>Perbaikan</th>
				</tr>
			</thead>
			<tbody>$TampilNilai</tbody>
		</table>
		</div>";

		$EditNilai.="<div class='form-actions'>";
		$EditNilai.=bSubmit("SaveUpdate","Update");
		$EditNilai.="</div></form>";
		
		$Show.=DuaKolomD(8,$Identitas,4,$EditNilai);
		$tandamodal="#NgisiNilaiSiswa";
		echo $NgisiNilaiSiswa;
		echo IsiPanel($Show);
	break;


	case "simpanedit":
		$jnil=isset($_GET['jnil'])?$_GET['jnil']:""; 
	
		if($jnil=="k3"){ 
			$txtIDDB=$_POST['txtIDDB'];
			$txtKBM=$_POST['txtKBM'];
			$txtNIS=$_POST['txtNIS'];
			$txtJKD=$_POST['txtJKD'];

			foreach($_POST['txtKd'] as $i => $txtKd){
				$txtKD_1=$_POST['txtKD_1'][$i];
				$txtKD_2=$_POST['txtKD_2'][$i];
				$txtKD_3=$_POST['txtKD_3'][$i];
				$txtKD_4=$_POST['txtKD_4'][$i];
				$txtKD_5=$_POST['txtKD_5'][$i];
				$txtKD_6=$_POST['txtKD_6'][$i];
				$txtKD_7=$_POST['txtKD_7'][$i];
				$txtKD_8=$_POST['txtKD_8'][$i];
				$txtKD_9=$_POST['txtKD_9'][$i];
				$txtKD_10=$_POST['txtKD_10'][$i];
				$txtKD_11=$_POST['txtKD_11'][$i];
				$txtKD_12=$_POST['txtKD_12'][$i];
				$txtKD_13=$_POST['txtKD_13'][$i];
				$txtKD_14=$_POST['txtKD_14'][$i];
				$txtKD_15=$_POST['txtKD_15'][$i];
			}

			$NHP=round(($txtKD_1+$txtKD_2+$txtKD_3+$txtKD_4+$txtKD_5+$txtKD_6+$txtKD_7+$txtKD_8+$txtKD_9+$txtKD_10+$txtKD_11+$txtKD_12+$txtKD_13+$txtKD_14+$txtKD_15)/$txtJKD);
			mysql_query("UPDATE n_p_kikd SET kd_ngajar='$txtKBM',nis='$txtNIS',kd_1='$txtKD_1',kd_2='$txtKD_2',kd_3='$txtKD_3',kd_4='$txtKD_4',kd_5='$txtKD_5',kd_6='$txtKD_6',kd_7='$txtKD_7',kd_8='$txtKD_8',kd_9='$txtKD_9',kd_10='$txtKD_10',kd_11='$txtKD_11',kd_12='$txtKD_12',kd_13='$txtKD_13',kd_14='$txtKD_14',kd_15='$txtKD_15',kikd_p='$NHP' WHERE kd_p_kikd='$txtIDDB'");
			echo '<div id="preloader"><div id="cssload"></div></div>';
			echo ns("Ngedit","parent.location='?page=$page&sub=perbaikan&tnil=k3&kbm=$txtKBM&nis=$txtNIS'","Nilai Pengetahuan dengan Kode KBM <strong class='text-primary'>$txtKBM </strong>");
		}
		else if($jnil=="k4"){ 
			$txtIDDB=$_POST['txtIDDB'];
			$txtKBM=$_POST['txtKBM'];
			$txtNIS=$_POST['txtNIS'];
			$txtJKD=$_POST['txtJKD'];

			foreach($_POST['txtKd'] as $i => $txtKd){
				$txtKD_1=$_POST['txtKD_1'][$i];
				$txtKD_2=$_POST['txtKD_2'][$i];
				$txtKD_3=$_POST['txtKD_3'][$i];
				$txtKD_4=$_POST['txtKD_4'][$i];
				$txtKD_5=$_POST['txtKD_5'][$i];
				$txtKD_6=$_POST['txtKD_6'][$i];
				$txtKD_7=$_POST['txtKD_7'][$i];
				$txtKD_8=$_POST['txtKD_8'][$i];
				$txtKD_9=$_POST['txtKD_9'][$i];
				$txtKD_10=$_POST['txtKD_10'][$i];
				$txtKD_11=$_POST['txtKD_11'][$i];
				$txtKD_12=$_POST['txtKD_12'][$i];
				$txtKD_13=$_POST['txtKD_13'][$i];
				$txtKD_14=$_POST['txtKD_14'][$i];
				$txtKD_15=$_POST['txtKD_15'][$i];
			}

			$NHP=round(($txtKD_1+$txtKD_2+$txtKD_3+$txtKD_4+$txtKD_5+$txtKD_6+$txtKD_7+$txtKD_8+$txtKD_9+$txtKD_10+$txtKD_11+$txtKD_12+$txtKD_13+$txtKD_14+$txtKD_15)/$txtJKD);
			mysql_query("UPDATE n_k_kikd SET kd_ngajar='$txtKBM',nis='$txtNIS',kd_1='$txtKD_1',kd_2='$txtKD_2',kd_3='$txtKD_3',kd_4='$txtKD_4',kd_5='$txtKD_5',kd_6='$txtKD_6',kd_7='$txtKD_7',kd_8='$txtKD_8',kd_9='$txtKD_9',kd_10='$txtKD_10',kd_11='$txtKD_11',kd_12='$txtKD_12',kd_13='$txtKD_13',kd_14='$txtKD_14',kd_15='$txtKD_15',kikd_k='$NHP' WHERE kd_k_kikd='$txtIDDB'");
			echo ns("Ngedit","parent.location='?page=$page&sub=perbaikan&tnil=k4&kbm=$txtKBM&nis=$txtNIS'","Nilai Keterampilan dengan Kode KBM <strong class='text-primary'>$txtKBM </strong>");
		}
		else {

			$txtIDDB=$_POST['txtIDDB'];
			$txtKBM=$_POST['txtKBM'];
			$txtNIS=$_POST['txtNIS'];
			$txtuts=$_POST['txtuts'];
			$txtuas=$_POST['txtuas'];

			mysql_query("UPDATE n_utsuas SET kd_ngajar='$txtKBM',nis='$txtNIS',uts='$txtuts',uas='$txtuas' WHERE kd_utsuas='$txtIDDB'");
			echo ns("Ngedit","parent.location='?page=$page&sub=perbaikan&tnil=utsuas&kbm=$txtKBM&nis=$txtNIS'","Nilai UTS dan UAS dengan Kode KBM <strong class='text-primary'>$txtKBM </strong>");
		}
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
})
</script>
