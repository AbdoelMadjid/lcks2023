<?php
/* 12/6/2016 --> Sabtu, 28 Januari 2017 13.10.40 --> 07/01/2023 18:42
Design and Programming By. Abdul Madjid, S.Pd., M.Pd.
SMK Negeri 1 Kadipaten
Pin 520543F3 HP. 0812-3000-0420
https://twitter.com/AbdoelMadjid 
https://www.facebook.com/abdulmadjid.mpd
*/
//eval(base64_decode("
require_once("inc/init.php");
require_once("inc/config.ui.php");
$page_title = "Beranda";
$page_css[] = "your_style.css";
include("inc/header.php");
$page_nav["beranda"]["active"] = true;
include("inc/nav.php");
echo '<div id="main" role="main">';
include("inc/ribbon.php");

$sub=(isset($_GET['sub']))?$_GET['sub']:"";
switch($sub)
{
	case "tampil":default:
		$Show.="
		<div class='row'>
			<span class='hidden-mobile hidden-sm hidden-xs'>
				<div class='col-xs-12 col-sm-7 col-md-7 col-lg-4'>
					<img src='".ASSETS_URL."/img/$Gambar1' width='150'>
				</div>
			</span>
			<div class='col-xs-12 col-sm-5 col-md-5 col-lg-8'>
				<ul id='sparks' class=''>
					<li class='sparks-info'>
						<span class='hidden-mobile'><h6> Nama Sekolah <span class='txt-color-red'>".strtoupper($NamaLembaga)."</span></h6></span>
					</li>
					<li class='sparks-info'>
						<h6> Tahun Ajaran <span class='txt-color-blue'>".$TahunAjarAktif."</span></h6>
					</li>
					<li class='sparks-info'>
						<h6> Semester <span class='txt-color-purple'>".strtoupper($SemesterAktif)."</span></h6>
					</li>
				</ul><br>
			</div>
		</div>
		<div class='row'>
			<div class='col-sm-12'>
				<div class='well well-sm'>
				<div class='row'>
					<div class='col-sm-12 col-md-6 col-lg-6'>
						<div class='who clearfix'>
							<h1><span class='semi-bold'>LCKS</span> <i class='ultra-light'>SMK</i> <span class='hidden-mobile'>(Kurikulum 2013)</span> <sup class='badge bg-color-red bounceIn animated'>$VersiApp</sup> <br> <small class='text-danger slideInRight fast animated'><strong><span class='hidden-mobile'>Aplikasi</span> Laporan Capaian Kompetensi Siswa</strong></small></h1>
						</div>
					</div>
					<div class='col-sm-12 col-md-6 col-lg-6'>
						<div class='who clearfix'>
							<span class='hidden-lg'><hr class='simple'></span>
							<h4><span class='txt-color-red'><strong>".nyapadulur().",</strong> </span><span class='hidden-lg'><br></span><strong><em>$NamaPengguna</em></strong></h4>
							Anda sebagai <span class='text-danger'>$LevelUser</span><br>Waktu Login : ".TglLengkap($WaktuLogin)." [".AmbilWaktu($WaktuLogin)."]
						</div>
					</div>
				</div>
				</div>
			</div>
		</div>";
/*
		if(isset($_POST['btnSave'])){
			$txtThnAjar=addslashes($_POST['txtThnAjar']);
			$txtGG=addslashes($_POST['txtGG']);
			mysql_query("INSERT INTO app_pilih_data VALUES ('$IDna','','$txtThnAjar','$txtGG','','','','','','','','','','','','')");
			echo ns("Nambah","parent.location='index.php'","Identitas Pilihan");
		}

		$IsiIDAdmin.="<form action='' method='post' name='frmadd' class='form-horizontal' role='form'>";
		$IsiIDAdmin.='<fieldset>';
		$IsiIDAdmin.=FormCF("horizontal","Tahun Ajaran","txtThnAjar","select * from ak_tahunajaran order by id_thnajar asc","tahunajaran",$txtThnAjar,"tahunajaran","4","");
		$IsiIDAdmin.=FormCF("horizontal","Semester","txtGG","select * from ak_semester","ganjilgenap",$txtGG,"ganjilgenap","4","");
		$IsiIDAdmin.='</fieldset>';

		if ($_SESSION['SMART_MASTER'] || $_SESSION['SMART_ADMIN']){
			if($JDataAppPilih==0){
				$Show.=FormModalAksi("NgisiPilihan","Pilih TA dan Semester".$NamaPengguna,$IsiIDAdmin,"btnSave","Simpan");
			}
			else {}
		}
*/		
		echo IsiPanel($Show);
	break;
}

echo '</div>';
include("inc/footer.php");
include("inc/scripts.php"); 
?>
<script>
 $(document).ready(function(){
	$("#NgisiPilihan").modal('show');
 });
 </script>
<?php 
	include("inc/google-analytics.php"); 
?>