<?php
require_once("inc/init.php");
require_once("inc/config.ui.php");
$page_title = "Opsi Aplikasi";
$page_css[] = "your_style.css";
include("inc/header.php");
$page_nav["tools"]["sub"]["opsiaplikasi"]["active"] = true;
include("inc/nav.php");
echo "<div id='main' role='main'>";
$breadcrumbs["Tools"] = "";
include("inc/ribbon.php");	
$sub=(isset($_GET['sub']))?$_GET['sub']:"";
switch($sub)
{
	case "tampil":default:
	//================================================================[akses login]
		$QAksesUser=mysql_query("select * from app_login_off order by id");
		$NoAksesUser=1;
		while($HAksesUser=mysql_fetch_array($QAksesUser)){
			if($HAksesUser['onoff']=="Y"){
				$tandanaAksesUser="<a href='?page=$page&sub=simpanakses&nonaktif={$HAksesUser['id']}' target='_self' alt='Nonaktifkan Akses'><i class='fa fa-unlock font-lg'></i></a>";
			}
			else{
				$tandanaAksesUser="<a href='?page=$page&sub=simpanakses&aktifkan={$HAksesUser['id']}' target='_self' alt='Aktifkan Akses'><i class='fa fa-lock font-lg text-danger'></i></a>";
			}
			$TampilAksesUser.="
			<tr>
				<td>$NoAksesUser.</td>
				<td>{$HAksesUser['hak']}</td>
				<td>{$tandanaAksesUser}</td>
			</tr>";
			$NoAksesUser++;
		}
		$AksesUser.=JudulKolom('Akses User','user-o');
		$AksesUser.="
		<!-- <div class='table-responsive no-margin custom-scroll' style='height:335px; overflow-y: scroll;'> --> 
		<div class='widget-body no-padding'>
			<table class='table'>
				<tr bgcolor='#f5f5f5'>
					<td><strong>No.</strong></td>
					<td><strong>Hak Akses</strong></td>
					<td><strong>Aksi</strong></td>
				</tr>
				$TampilAksesUser
			</table>
		</div>
		<!-- </div> -->";

	// tampilkan fitur
		$QFitur=mysql_query("select * from app_fitur order by id_fitur");
		$NoFitur=1;
		while($HFitur=mysql_fetch_array($QFitur)){
			if($HFitur['tampilkan']=="Y"){
				$tandaFitur="<a href='?page=$page&sub=simpanfitur&nonaktif={$HFitur['id_fitur']}' target='_self' alt='Nonaktifkan Fitur'><i class='ace-icon fa fa-eye font-lg'></i></a>";
			}
			else{
				$tandaFitur="<a href='?page=$page&sub=simpanfitur&aktifkan={$HFitur['id_fitur']}' target='_self' alt='Aktifkan Fitur'><i class='ace-icon fa fa-eye-slash font-lg'></i></a>";
			}
			$TampilFitur.="
			<tr>
				<td>$NoFitur.</td>
				<td>{$HFitur['nama_fitur']}</td>
				<td>{$tandaFitur}</td>
			</tr>";
			$NoFitur++;
		}
		$Fitur.=JudulKolom('Aktifkan Fitur','bookmark');
		$Fitur.="
		<!-- <div class='table-responsive no-margin custom-scroll' style='height:335px; overflow-y: scroll;'> --> 
		<div class='widget-body no-padding'>
			<table class='table'>
				<tr bgcolor='#f5f5f5'>
					<td><strong>No.</strong></td>
					<td><strong>Nama Fitur</strong></td>
					<td><strong>Aksi</strong></td>
				</tr>
				$TampilFitur
			</table>
		</div>
		<!-- </div> -->";

//=============================================================[under construction]
		$QUC=mysql_query("select * from app_ident");
		$HUC=mysql_fetch_array($QUC);
		$IsiForm.="";
		$IsiForm.='<fieldset>';
		$IsiForm.=IsiTgl('Tgl Selesai','txtTgl','txtBln','txtThn',$HUC['tgl_underc'],2017);
		$IsiForm.=FormRBDBNY("Aktif","txtAktif",$HUC['underc'],"radio1","radio2");
		$IsiForm.='</fieldset>';
		$IsiForm.='<div class="form-actions">';
		$IsiForm.=ButtonSimpan();
		$IsiForm.='</div>';
		$UnderCons.=JudulKolom('Under Construstion','gears');
		$UnderCons.="<br>".FormAing($IsiForm,"?page=$page&sub=simpanunderc","FrmTambahTA","");		

		$Show=DuaKolom(DuaKolomSama($AksesUser,$Fitur),KolomPanel($UnderCons));
		echo $OpsiAplikasi;
		$tandamodal="#OpsiAplikasi";
		//echo IsiPanel(DuaKolom(DuaKolomSama($AksesUser,$Fitur),KolomPanel($UnderCons)));
		echo MyWidget('fa-fire',$page_title,$Tombolna,$Show);		
	break;
	case "simpanakses":
		if(isset($_GET['nonaktif'])) {
			$BeresTeuAcan=isset($_GET['nonaktif'])?$_GET['nonaktif']:""; 
			NgambilData("select * from app_login_off where id='$BeresTeuAcan'");
			$sqlSave="UPDATE app_login_off SET onoff='N' WHERE id='$BeresTeuAcan'";
			$qrySave=mysql_query($sqlSave);
			if($qrySave){
				echo ns("NonAktif","parent.location='?page=$page'","$hak");
			}
		}
		if(isset($_GET['aktifkan'])) {
			$BeresTeuAcan=isset($_GET['aktifkan'])?$_GET['aktifkan']:""; 
			NgambilData("select * from app_login_off where id='$BeresTeuAcan'");
			$sqlSave="UPDATE app_login_off SET onoff='Y' WHERE id='$BeresTeuAcan'";
			$qrySave=mysql_query($sqlSave);
			if($qrySave){
				echo ns("Aktif","parent.location='?page=$page'","$hak");
			}
		}
	break;
	case "simpanfitur":
		if(isset($_GET['nonaktif'])) {
			$BeresTeuAcan=isset($_GET['nonaktif'])?$_GET['nonaktif']:""; 
			NgambilData("select * from app_fitur where id_fitur='$BeresTeuAcan'");
			$sqlSave="UPDATE app_fitur SET tampilkan='N' WHERE id_fitur='$BeresTeuAcan'";
			$qrySave=mysql_query($sqlSave);
			if($qrySave){
				echo ns("Sembunyikan","parent.location='?page=$page'","$nama_fitur");
			}
		}
		if(isset($_GET['aktifkan'])) {
			$BeresTeuAcan=isset($_GET['aktifkan'])?$_GET['aktifkan']:""; 
			NgambilData("select * from app_fitur where id_fitur='$BeresTeuAcan'");
			$sqlSave="UPDATE app_fitur SET tampilkan='Y' WHERE id_fitur='$BeresTeuAcan'";
			$qrySave=mysql_query($sqlSave);
			if($qrySave){
				echo ns("Tampilkan","parent.location='?page=$page'","$nama_fitur");
			}
		}
	break;

	case "simpanunderc":
		$txtTgl=addslashes($_POST['txtTgl']);
		$txtBln=addslashes($_POST['txtBln']);
		$txtThn=addslashes($_POST['txtThn']);
		$txtAktif=addslashes($_POST['txtAktif']);
		$TglAkhirUC=trim($_POST['txtThn'])."-".trim($_POST['txtBln'])."-".trim($_POST['txtTgl']);
		$sqlSave="update app_ident set tgl_underc='$TglAkhirUC',underc='$txtAktif' where id='1'";
		$qrySave=mysql_query($sqlSave);
		if($qrySave){
			session_start();
			session_unset();
			session_destroy();					
			echo ns("Ngedit","parent.location='index.php'","underconstruction");
		}
	break;
}
echo "</div>";
include("inc/footer.php");
include("inc/scripts.php"); 
?>
<script type="text/javascript">
	$(document).ready(function() {
		var a={
			"hapusinfo":function(a){
				function b(){
					window.location=a.attr("href")
				}
				$.SmartMessageBox(
					{
						"title":"<h1 style='margin-top:-5px;'><i class='fa fa-fw fa-question-circle bounce animated text-primary'></i><small class='text-primary'><strong> Konfirmasi</strong></small></h1>",
						"content":a.data("hapusinfo-msg"),
						"buttons":"[No][Yes]"
					},function(a){
						"Yes"==a&&($.root_.addClass("animated fadeOutUp"),setTimeout(b,1e3))
						}
			)}
		}

		$.root_.on("click",'[data-action="hapusinfo"]',function(b){var c=$(this);a.hapusinfo(c),b.preventDefault(),c=null});
	})
</script>