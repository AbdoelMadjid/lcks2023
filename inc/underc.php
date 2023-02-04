<?php
require_once("inc/init.php");
require_once("inc/config.ui.php");
$page_title = "Under Construction";
$page_css[] = "your_style.css";
//$page_css[] = "lockscreen.min.css";
$page_html_prop = array("id"=>"extr-page", "class"=>"animated fadeInDown");
$no_main_header = true;
include("inc/header.php");

$tahun=substr($TglUnCons, 0, 4); // memisahkan format tahun menggunakan substring
$bulan=substr($TglUnCons, 5, 2); // memisahkan format bulan menggunakan substring
$tanggal=substr($TglUnCons, 8, 2); // memisahkan format tanggal menggunakan substring
$TampilTglSelesai.=HariTglLengkap($TglUnCons); 

//==============================================[ Mengaktifkan Underconstruction ]==//
$HariIni=date('Y-m-d');
if($TglUnCons==$HariIni){mysql_query("update app_ident set underc='N' where id='1'");}
if(isset($_POST['btnaktif'])){
	$ngaktif=addslashes($_POST['ngaktif']);
	if($ngaktif=="kumahauing"){
		$sqlSave="update app_ident set underc='N' where id='1'";
		$qrySave=mysql_query($sqlSave);
		if($qrySave){echo "<script>parent.location='index.php';</script>";}
	}
	else{echo "<script>alert('Kata Kunci Salah');parent.location='index.php'</script>";}
}

//==============================================[ Tampilkan Data Informasi ]==//
	$QInfoU=mysql_query("select * from kur_informasi where aktif='Y' and thnajaran='$TahunAjarAktif'");
	$JInfoU=mysql_num_rows($QInfoU);
	while($HInfoU=mysql_fetch_array($QInfoU)){$TampilU.="<li>{$HInfoU['info']}</li>";}
	if($JInfoU==0){$InfoU.="<blockquote>Tidak ada Informasi</blockquote>";}else{$InfoU.="<ul>$TampilU</ul>";}
?>
<div class="demo">
	<span id="demo-setting"><i class="fa fa-cogs fa-spin txt-color-blueDark"></i></span> 
	<form method="post" action="#">
		<legend style="margin-top:-10px;">Under Construction</legend>
	<h3 class="text-danger" style="margin-top:-15px;margin-bottom:5px;"><i class="fa fa-microphone fa-1x"></i> Informasi</h3>
	<div style="margin-bottom:20px;"><?php echo $InfoU; ?></div>
	<h3 class="text-danger" style="margin-top:-15px;"><i class="fa fa-key fa-1x"></i> Buka Kunci</h3>
	<hr class="simple" style="margin-top:-10px;">
	<center><input type="password" name="ngaktif" placeholder="Masukan Kata Kunci"></center>
	<input class="btn btn-xs btn-info btn-block txt-color-black margin-top-10" type="submit" name="btnaktif"> 
</div>


<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main">
	<!-- MAIN CONTENT -->
	<div id="content" class="container">
		<div class="text-center error-box">
			<h2 class="error-text tada animated"><!-- <img src='img/perbaikan.webp'> --><i class="fa fa-refresh fa-spin fa-1x text-danger error-icon-shadow"></i></h2>
			<h2 class="font-xl"><strong>Under Construction!</strong></h2>
			<h2 class="font-xl text-danger"><strong><?php echo $LongNameApp; ?><br> <?php echo $NamaLembaga; ?></strong></h2>
			<p class="lead semi-bold">
				<strong>The application is in the process of being repaired. We are sorry.</strong><br><br>
				<small>
					You can access back on :<br> <strong class='text-danger'><?php echo $TampilTglSelesai; ?></strong>
				</small>
			</p>
		</div>	
	</div>
</div>
<!-- END MAIN PANEL -->
<!-- ==========================CONTENT ENDS HERE ========================== -->
<!-- PAGE FOOTER -->
<?php
	// include page footer
	//include("inc/footer.php");
?>
<!-- END PAGE FOOTER -->
<?php 
	//include required scripts
	include("inc/scripts.php"); 
?>
<!-- PAGE RELATED PLUGIN(S) 
<script src="..."></script>-->
<script>

	$(document).ready(function() {
		$("#smart-bgimages").fadeOut(), $("#demo-setting").click(function() {$(".demo").toggleClass("activate")});
	})

</script>