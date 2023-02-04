<?php
require_once("inc/init.php");
require_once("inc/config.ui.php");
$page_title = "Data Kelas";
$page_css[] = "your_style.css";
include("inc/header.php");
$page_nav["walikelas"]["sub"]["datakelas"]["active"] = true;
include("inc/nav.php");
echo "<div id='main' role='main'>";
$breadcrumbs["Wali Kelas"] = "";
include("inc/ribbon.php");	
$sub=(isset($_GET['sub']))? $_GET['sub'] : "";
switch ($sub)
{
	case "tampil":default:
//=====================================================[ PEMBEDA ADMIN DAN WALI KELAS ]
		$qt=" id_kls='$IDna' ";
		$mp=" where wk_kelas_ttm.ganjilgenap='$SemesterAktif' and ak_kelas.id_kls='$IDna' ";
		$ttm=" and ganjilgenap='$SemesterAktif'";
		$nwk=$NamaLengkapWk;

		NgambilData("Select * from ak_kelas where $qt");
		$JmlData=JmlDt("Select * from ak_kelas where $qt");
	
	// TAMPILAN DATA TITIMANGSA RAPOR

		if(isset($_POST['btnTambah'])){
			$message=array();
			if(trim($_POST['txtTempat'])==""){$message[]="Tempat tidak boleh kosong!";}
			if(trim($_POST['txtTgl'])=="" || trim($_POST['txtBln'])=="" || trim($_POST['txtThn'])==""){$message[]="Tanggal tidak boleh kosong!";}

			if(!count($message)==0){
				$Num=0;
				foreach($message as $indeks=>$pesan_tampil){
					$Num++;
					$Pesannya.="$Num. $pesan_tampil<br>";
				}
				$PesanError.=Alert("kesalahan",$Pesannya);
			}
			else{
				$kd_ttm=buatKode("wk_kelas_ttm","ttm_");
				$txtIDTTM=addslashes($_POST['txtIDTTM']);
				$txtKDKelas=addslashes($_POST['txtKDKelas']);
				$txtSmstr=addslashes($_POST['txtSmstr']);
				$txtTempat=addslashes($_POST['txtTempat']);
				$txtTgl=addslashes($_POST['txtTgl']);
				$txtBln=addslashes($_POST['txtBln']);
				$txtThn=addslashes($_POST['txtThn']);
				$TglTTM=$txtThn."-".$txtBln."-".$txtTgl;
				if($txtSmstr==1 || $txtSmstr==3 || $txtSmstr==5){$GG="Ganjil";}else{$GG="Genap";}
				mysql_query("INSERT INTO wk_kelas_ttm VALUES ('$kd_ttm','$txtKDKelas','$txtSmstr','$GG','$txtTempat','$TglTTM')");
				echo ns("Nambah","parent.location='?page=$page'","Titimangsa");
			}
		}

		if(isset($_POST['btnEdit'])){
			$message=array();
			if(trim($_POST['txtTempat'])==""){$message[]="Tempat tidak boleh kosong!";}
			if(trim($_POST['txtTgl'])=="" || trim($_POST['txtBln'])=="" || trim($_POST['txtThn'])==""){$message[]="Tanggal tidak boleh kosong!";}
			if(!count($message)==0){
				$Num=0;
				foreach($message as $indeks=>$pesan_tampil){
					$Num++;
					$Pesannya.="$Num. $pesan_tampil<br>";
				}
				$PesanError.=nt("kesalahan",$Pesannya);
			}
			else{
				$txtIDTTM=addslashes($_POST['txtIDTTM']);
				$txtKDKelas=addslashes($_POST['txtKDKelas']);
				$txtSmstr=addslashes($_POST['txtSmstr']);
				$txtTempat=addslashes($_POST['txtTempat']);
				$txtTgl=addslashes($_POST['txtTgl']);
				$txtBln=addslashes($_POST['txtBln']);
				$txtThn=addslashes($_POST['txtThn']);
				$TglTTM=$txtThn."-".$txtBln."-".$txtTgl;
				if($txtSmstr==1 || $txtSmstr==3 || $txtSmstr==5){$GG="Ganjil";}else{$GG="Genap";}
				mysql_query("update wk_kelas_ttm set kd_kls='$txtKDKelas',semester='$txtSmstr',ganjilgenap='$GG',alamat='$txtTempat',ttm='$TglTTM' where kd_ttm='$txtIDTTM'");
				echo ns("Ngedit","parent.location='?page=$page'","Titimangsa");
			}
		}

		$QTTM=mysql_query("select * from wk_kelas_ttm where kd_kls='".$kode_kelas."' ".$ttm);
		$HTTM=mysql_fetch_array($QTTM);
		$JHTM=mysql_num_rows($QTTM);
		$DtTTMRapor.=JudulKolom("Data Pembagian Raport","folder");
		if($JHTM==1){
			$DtTTMRaporForm.='<fieldset>';
			$DtTTMRaporForm.="<input type='hidden' name='txtIDTTM' value='".$HTTM['kd_ttm']."'>";		
			$DtTTMRaporForm.="<input type='hidden' name='txtKDKelas' value='".$kode_kelas."'>";
			$DtTTMRaporForm.=FormIF("horizontal","Semester", "txtSmstr",$HTTM['semester'],'2','readonly=readonly');
			$DtTTMRaporForm.=FormIF("horizontal","Tempat", "txtTempat",$HTTM['alamat'],'8',"");
			$DtTTMRaporForm.=IsiTgl('Tanggal Bagi Rapor','txtTgl','txtBln','txtThn',$HTTM['ttm'],2013);
			$DtTTMRaporForm.='</fieldset>';
			$DtTTMRaporForm.='<div class="form-actions">'.iSubmit("btnEdit","Update").'</div>';
			$DtTTMRapor.=FormAing($DtTTMRaporForm,"?page=$page","frminputttm","");
		}
		else{
			$DtTTMRaporForm.=$PesanError;
			$DtTTMRaporForm.="<input type='hidden' name='txtKDKelas' value='".$kode_kelas."'>";
			if($SemesterAktif=="Ganjil"){
				$SmstrnaX=1;
				$SmstrnaXI=3;
				$SmstrnaXII=5;
			}
			else{
				$SmstrnaX=2;
				$SmstrnaXI=4;
				$SmstrnaXII=6;
			}

			$DtTTMRaporForm.='<fieldset>';
			if($tingkat=="X"){
				$DtTTMRaporForm.=FormIF("horizontal","Semester","txtSmstr",$SmstrnaX,'2','readonly=readonly');
			}
			else if($tingkat=="XI"){
				$DtTTMRaporForm.=FormIF("horizontal","Semester","txtSmstr",$SmstrnaXI,'2','readonly=readonly');
			}
			else if($tingkat=="XII"){
				$DtTTMRaporForm.=FormIF("horizontal","Semester","txtSmstr",$SmstrnaXII,'2','readonly=readonly');
			}
			$DtTTMRaporForm.=FormIF("horizontal","Tempat","txtTempat","",'8',"");
			$DtTTMRaporForm.=IsiTgl('Tanggal Bagi Rapor','txtTgl','txtBln','txtThn',"",2013);
			$DtTTMRaporForm.='</fieldset>';
			$DtTTMRaporForm.='<div class="form-actions">'.iSubmit("btnTambah","Simpan").'</div>';
			$DtTTMRapor.=FormAing($DtTTMRaporForm,"?page=$page","frminputttm","");
		}
		
	// TAMPILAN DATA GURU PENGAJAR

		$QMP=mysql_query("
		select 
		ak_kelas.id_kls,
		ak_kelas.nama_kelas,
		ak_kelas.tahunajaran,
		wk_kelas_ttm.semester,
		ak_matapelajaran.kode_mapel,
		ak_matapelajaran.nama_mapel,
		ak_matapelajaran.kelmapel,
		app_user_guru.nama_lengkap,
		gmp_ngajar.id_ngajar,
		gmp_ngajar.kkmpeng,
		gmp_ngajar.kkmket 
		from gmp_ngajar 
		inner join ak_kelas on gmp_ngajar.kd_kelas=ak_kelas.kode_kelas
		inner join wk_kelas_ttm on gmp_ngajar.kd_kelas=wk_kelas_ttm.kd_kls and gmp_ngajar.ganjilgenap=wk_kelas_ttm.ganjilgenap
		inner join ak_matapelajaran on gmp_ngajar.kd_mapel=ak_matapelajaran.kode_mapel
		inner join app_user_guru on gmp_ngajar.kd_guru=app_user_guru.id_guru $mp 
		order by ak_matapelajaran.kelmapel asc");

		$no=1;
		while($HasilMP=mysql_fetch_array($QMP)){
			$NamaKelas=$HasilMP['nama_kelas'];
			$IDNGajar=$HasilMP['id_ngajar'];
			$ThAjaran=$HasilMP['tahunajaran'];
			$Smstr=$HasilMP['semester'];
			
			$TampilDataMP.="
			<tr>
				<td class='text-center'>$no.</td>
				<td>{$HasilMP['nama_lengkap']}</td>
				<td><span class='text-info'>{$HasilMP['kode_mapel']}</span><br><span class='text-danger'>{$HasilMP['nama_mapel']}</span></td>
				<td><button type='button' class='view_data btn btn-default btn-xs btn-block' data-toggle='modal' id='".$HasilMP["id_ngajar"]."' data-target='#myModal'>Show</button></td>
			</tr>";
			$no++;
		}

		$jmldataMP=mysql_num_rows($QMP);
		if($jmldataMP>0){
			$DtPengajar.="<a href='?page=$page&sub=mapel' class='btn btn-default btn-sm pull-right' style='margin-top:-10px;'><i class='fa fa-book'></i> <span class='hidden-xs'>Mata Pelajaran</span></a>";
			$DtPengajar.=Label("Daftar Guru Mata Palajaran","users");
			if($Smstr==1 || $Smstr==3 ||$Smstr==5){$gg="Ganjil";}else{$gg="Genap";}
			$DtPengajar.="<p class='text-danger' style='margin-top:-10px;'>Tahun Pelajaran : $ThAjaran Semester : $Smstr ($gg)</p>";
			$DtPengajar.="
			<div class='well no-padding'>
				<table id='dt_basic' class='table table-striped table-bordered table-hover table-condensed' width='100%'>
					<thead>
						<tr>
							<th class='text-center' data-class='expand'>No.</th>
							<th class='text-center' data-hide='phone'>Pengajar</th>
							<th class='text-center'>Kode Mapel - Mata Pelajaran</th>
							<th class='text-center'>Detail</th>
						</tr>
					</thead>
					<tbody>
					$TampilDataMP
					</tbody>
				</table>
			</div>";
		}
		else{
			$DtPengajar.=KolomPanel("
			<p class='text-center'><img src='img/aa.png' width='65' height='131' border='0' alt=''></p>
			<h1 class='text-center'><small class='text-danger'><strong>Data Masih Kosong!!</strong> </small></h1>
			<p class='text-center'>Guru Mata Pelajaran belum menambahkan KBM <br>dan/atau Data Pembagian Rapor belum di lengkapi</p>");

		}


		$Show.="<a href=\"javascript:;\" onClick=\"window.open('./pages/excel/ekspor-data-master.php?eksporex=format-walikelas&kls=$IDna&thnajaran=$TahunAjarAktif&gg=$SemesterAktif')\" title='Download Format Kelas' class='btn btn btn-default btn-sm pull-right' style='margin-top:-10px;'><i class='fa fa-download'></i> Download Format Wali Kelas</a>";
		$Show.=JudulKolom("Kelas ".$nama_kelas,"building-o");
		
		$TampilDataKelas.=DuaKolomD(5,KolomPanel($DtTTMRapor),7,$DtPengajar);
			
		$Show.=$TampilDataKelas;
		
		
		echo FormModalDetail("myModal","Detail KBM","data_siswa212");
		$tandamodal="#WKDataKelas";
		echo $WKDataKelas;
		echo IsiPanel($Show);
	break;


	case "mapel" :

		$QMP=mysql_query("
		select 
		ak_kelas.id_kls,
		ak_kelas.kode_kelas,
		ak_kelas.tahunajaran,
		ak_kelas.nama_kelas,
		wk_kelas_ttm.semester,
		ak_matapelajaran.kode_mapel,
		ak_matapelajaran.nama_mapel,
		ak_matapelajaran.semester1,
		ak_matapelajaran.semester2,
		ak_matapelajaran.semester3,
		ak_matapelajaran.semester4,
		ak_matapelajaran.semester5,
		ak_matapelajaran.semester6 
		from 
		ak_kelas,
		wk_kelas_ttm,
		ak_matapelajaran 
		where 
		ak_kelas.kode_pk=ak_matapelajaran.kode_pk and 
		ak_kelas.kode_kelas=wk_kelas_ttm.kd_kls and wk_kelas_ttm.ganjilgenap='$SemesterAktif' and ak_kelas.id_kls='$IDna' 
		order by ak_matapelajaran.kode_mapel");

		$no=1;
		while($HasilMP=mysql_fetch_array($QMP))
		{
			if($HasilMP['semester']==1){$icon1="check-square-o fa-border txt-color-red";}else{$icon1="check fa-border txt-color-blue";}
			if($HasilMP['semester']==2){$icon2="check-square-o fa-border txt-color-red";}else{$icon2="check fa-border txt-color-blue";}
			if($HasilMP['semester']==3){$icon3="check-square-o fa-border txt-color-red";}else{$icon3="check fa-border txt-color-blue";}
			if($HasilMP['semester']==4){$icon4="check-square-o fa-border txt-color-red";}else{$icon4="check fa-border txt-color-blue";}
			if($HasilMP['semester']==5){$icon5="check-square-o fa-border txt-color-red";}else{$icon5="check fa-border txt-color-blue";}
			if($HasilMP['semester']==6){$icon6="check-square-o fa-border txt-color-red";}else{$icon6="check fa-border txt-color-blue";}
			if($HasilMP['semester1']==1){$Check1="<i class='fa fa-$icon1'></i>";}else{$Check1="";}
			if($HasilMP['semester2']==1){$Check2="<i class='fa fa-$icon2'></i>";}else{$Check2="";}
			if($HasilMP['semester3']==1){$Check3="<i class='fa fa-$icon3'></i>";}else{$Check3="";}
			if($HasilMP['semester4']==1){$Check4="<i class='fa fa-$icon4'></i>";}else{$Check4="";}
			if($HasilMP['semester5']==1){$Check5="<i class='fa fa-$icon5'></i>";}else{$Check5="";}
			if($HasilMP['semester6']==1){$Check6="<i class='fa fa-$icon6'></i>";}else{$Check6="";}
			$JmlMP1=$JmlMP1+$HasilMP['semester1'];
			$JmlMP2=$JmlMP2+$HasilMP['semester2'];
			$JmlMP3=$JmlMP3+$HasilMP['semester3'];
			$JmlMP4=$JmlMP4+$HasilMP['semester4'];
			$JmlMP5=$JmlMP5+$HasilMP['semester5'];
			$JmlMP6=$JmlMP6+$HasilMP['semester6'];
			$TampilDataMP.="
			<tr>
				<td>$no.</td>
				<td>{$HasilMP['kode_mapel']}</td>
				<td>{$HasilMP['nama_mapel']}</td>
				<td>$Check1</td>
				<td>$Check2</td>
				<td>$Check3</td>
				<td>$Check4</td>
				<td>$Check5</td>
				<td>$Check6</td>
			</tr>";
			$no++;
		}

		$jmldataMapel=mysql_num_rows($QMP);

		if($jmldataMapel>0){
			$ShowMP.=ButtonKembali2("?page=$page","style='margin-top:-10px'");
			$ShowMP.=JudulKolom("Daftar Mata Pelajaran","th");
			$ShowMP.="
			<div class='well no-padding'>
				<table id='dt_basic' class='table table-striped table-bordered table-condensed' width='100%'>
				<thead>
					<tr>
						<th class='text-center' data-class='expand'>No.</th>
						<th class='text-center' data-hide='phone,tablet'>Kode Mapel</th>
						<th class='text-center'>Nama Mata Pelajaran</th>
						<th class='text-center' data-hide='phone,tablet'>1</th>
						<th class='text-center' data-hide='phone,tablet'>2</th>
						<th class='text-center' data-hide='phone,tablet'>3</th>
						<th class='text-center' data-hide='phone,tablet'>4</th>
						<th class='text-center' data-hide='phone,tablet'>5</th>
						<th class='text-center' data-hide='phone,tablet'>6</th>
					</tr>
				</thead>
				<tbody>$TampilDataMP</tbody>
				</table>
			</div>";
		}
		else{
			$ShowMP.=nt("peringatan","Anda belum mengisi secara lengkap DATA KELAS. Silakan isi di <a href='?page=walikelas-data-kelas' class='btn btn-xs btn-default'>Isi Data Kelas</a>");
		}
		$tandamodal="#DetailMataPelajaran";
		echo $DetailMataPelajaran;
		echo IsiPanel($ShowMP);
	break;

	case "usersiswa":
		$idna=isset($_GET['idna'])?$_GET['idna']:""; 

		$Q=mysql_query("
		select ak_kelas.id_kls,
		ak_kelas.nama_kelas,
		ak_kelas.tahunajaran,
		siswa_biodata.nis,
		siswa_biodata.nisn,
		siswa_biodata.nm_siswa 
		from ak_kelas,siswa_biodata,ak_perkelas,ak_paketkeahlian 
		where 
		ak_kelas.nama_kelas=ak_perkelas.nm_kelas and 
		ak_kelas.tahunajaran=ak_perkelas.tahunajaran and 
		ak_perkelas.nis=siswa_biodata.nis and 
		siswa_biodata.kode_paket=ak_paketkeahlian.kode_pk and 
		ak_kelas.id_kls='$idna' 
		order by siswa_biodata.nis");
		
		$no=1;	
		while($Hasil=mysql_fetch_array($Q)){
			$NamaKelas=$Hasil['nama_kelas'];

			$QPass=mysql_query("Select * from app_user_siswa where nis='{$Hasil['nis']}'");
			$HPass=mysql_fetch_array($QPass);

			$TampilData.="
			<tr style='border-color:black;'>
				<td align='center'>$no.</td>
				<td align='center'>{$Hasil['nisn']}</td>
				<td align='center'>{$Hasil['nis']}</td>
				<td style='padding-left:15px;'>{$HPass['ket']}</td>
				<td style='padding-left:15px;'>{$Hasil['nm_siswa']}</td>
			</tr>";
			$no++;
		}

		$jmldata=mysql_num_rows($Q);	
		if($jmldata>0){
			$Show.=ButtonKembali("?page=$page");
			$Show.="<a href='javascript:void(0);' class='btn btn-primary btn-sm pull-right' onclick=\"printContent('Cetak')\" style='margin-top:-10px;margin-right:10px;'>Cetak</a>";
			$Show.=JudulKolom("Siswa Kelas $NamaKelas","user-circle");
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
			$Show.="
			<div id='Cetak' style='@page {size: A4;}'>
				DAFTAR USERNAME SISWA <BR>
				KELAS $NamaKelas<br><br>
				<table style='margin: 0 auto;width:100%;border-collapse:collapse;font:12px Times New Roman;background: transparent;'border='1'>
					<tr style='border-color:black;'>
						<td align='center'>No.</td>
						<td align='center'>NISN</td>
						<td align='center'>Username</td>
						<td align='center'>Password</td>
						<td align='center'>Nama Siswa</td>
					</tr>
					$TampilData
				</table>
				<br>
				<em><strong>Keterangan :</strong></em>
				<br>
				1. Silakan untuk mengganti password setelah masuk pertama kali<br>
				2. Mohon untuk tidak memberikan password kepada orang lain. 
			</div>
			";
		}
		else 
		{
			$Show.="<p class='text-center'><img src='img/aa.png' width='100' height='231' border='0' alt=''></p><h1 class='text-center'><small class='text-danger slideInRight fast animated'><strong>$MassaKBM</strong> </small><br><small>Data Siswa belum ada, silakan hubungi Administrator.</small> </h1>";
		}
		
			echo IsiPanel($Show);
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
				url: 'lib/app_modal.php?md=DetailKBM',
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