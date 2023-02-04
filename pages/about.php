<?php
require_once("inc/init.php");
require_once("inc/config.ui.php");
$page_title = "About";
$page_css[] = "your_style.css";
include("inc/header.php");
$page_nav["about"]["active"] = true;
include("inc/nav.php");
echo "<div id='main' role='main'>";
//$breadcrumbs["About"] = "";
include("inc/ribbon.php");	
echo '
	<div id="content">
		<div class="row">
			<div class="col-sm-12">
				<div class="well well-sm">
					<div class="well well-sm">
						<h1 class="text-center"><span class="semi-bold">LCKS</span> <i class="ultra-light">SMK</i> <span class="hidden-mobile">(Kurikulum 2013)</span> <sup class="badge bg-color-red bounceIn animated">'.$VersiApp.'</sup> <br> <small class="text-danger slideInRight fast animated"><strong><span class="hidden-mobile">Aplikasi </span>Laporan Capaian Kompetensi Siswa</strong></small></h1>
					</div>
					<div class="row">
						<div class="col-sm-6 col-lg-6">
							<div class="panel panel-default">
								<div class="panel-body status">
									<div class="who clearfix">
										<h4><span class="txt-color-red"><i class="fa fa-fw fa-circle-o-notch fa-spin txt-color-blue"></i> <strong>About</strong> </span><strong><em>LCKS-SMK</em></strong></h4>
									</div>
									<div class="text"> 
										<span class="timeline-seperator text-center"> <span><small class="text-danger slideInRight fast animated"><strong class="font-lg"> BUKAN SEBUAH KESOMBONGAN </strong></small></span></span><br>
										<p class="text-justify">
											Seperti judul diatas, ini bukan ingin memamerkan diri ataupun ingin menunjukan diri bahwa ini adalah aplikasi terbaik. karena yang punya sombong hanyaklah Allah SWT.
										</p>
										<p class="text-justify">
											Aplikasi ini di buat hanya semata-mata untuk mempermudah pekerjaan rekan-rekan guru di <strong>SMK Negeri 1 kadipaten</strong> yang cukup kereptan dalam menangani penilaian di Kurikulum 2013. Aplikasi ini dibuat dengan fitur-fitur yang dinamis agar bisa di gunakan oleh semua sekolah SMK.
										</p>
											Terima kasih saya ucappkan kepada :<br>
											<ul style="margin-left:-25px;text-align:justify;">
											<li>Allah SWT, yang sudah memberikan kepahaman</li>
											<li>Orang Tua yang selalu melimpahkan kasih sayangnya</li>
											<li>Purwani Wahyuningsih dan Reni Nur\'Asih, Istri dan anaku yang selalu mendukung dan memberikan semangat untuk  berkarya, serta Azzam Ikbara Al-Madjid Bayi mungil yang bikin semangat, Semoga Allah memberi kesehatan dan keselamatan pada saatnya. Yang selalu memberi semangat dalam menjalankan aktifitas berkarya.</li>
											<li>Teman-teman Programmer di Forum FB, Twitter, maupun di Milis-milis, terima kasih atas bantuan beberapa masukan dan scriptnya. </li>
											<li>Teman-teman seperjuangan di RPL dan TKJ, yang sudah memberikan dukungan untuk menciptakan aplikasi ini. </li>
											<li>Dan rekan-rekan Guru di SMK Negeri 1 Kadipaten yang mau dengan semangat melakukan uji coba dari mulai aplikasi berbasis EXCEL sampai pada akhirnya Aplikasi Berbasis WEB dan akan dikembangkan menjadi aplikasi berbasis ANDROID.</li>
											</UL>
									</div>
									<div class="myprofil">
										<div class="logo">
											<h1><i class="fa fa-user-circle text-muted"></i> <small>DESIGN & PROGRAMMING</small> </h1><hr>
										</div>
										<div>
											<img src="'.ASSETS_URL.'/img/avatars/almadjid.jpg" style="max-height:120px;">
											<div><span class="hidden-lg"><br></span>
												<h4 class="text-muted"><strong>ABDUL MADJID, M.Pd.</strong></h4> 
												<i class="fa fa-fw fa-chain txt-color-blue"></i>Pin 520543F3    <i class="fa fa-phone txt-color-blue"></i><i class="fa fa-fw fa-telegram txt-color-blue"></i><i class="fa fa-fw fa-whatsapp txt-color-blue"></i> 0812-3000-0420
												<p class="text-muted">
													<br>
													<a title="Facebook" href="https://www.facebook.com/abdulmadjid.mpd" target="_blank"><span class="fa-stack fa-lg"><i class="fa fa-square-o fa-stack-2x"></i><i class="fa fa-facebook fa-stack-1x"></i></span></a>
													<a title="Twitter" href="https://twitter.com/AbdoelMadjid" target="_blank"><span class="fa-stack fa-lg"><i class="fa fa-square-o fa-stack-2x"></i><i class="fa fa-twitter fa-stack-1x"></i></span></a>
													<a title="Google+" href="https://plus.google.com/+AbdulMadjidMPd" target="_blank"><span class="fa-stack fa-lg"><i class="fa fa-square-o fa-stack-2x"></i><i class="fa fa-google-plus fa-stack-1x"></i></span></a>
													<a title="Linkedin" href="https://id.linkedin.com/in/abdoelmadjid" target="_blank"><span class="fa-stack fa-lg"><i class="fa fa-square-o fa-stack-2x"></i><i class="fa fa-linkedin fa-stack-1x"></i></span></a>
													<a title="GitHub" href="https://github.com/AbdoelMadjid" target="_blank"><span class="fa-stack fa-lg"><i class="fa fa-square-o fa-stack-2x"></i><i class="fa fa-github fa-stack-1x"></i></span></a>
													<a title="Forsquare" href="https://id.foursquare.com/abdoelmadjid" target="_blank"><span class="fa-stack fa-lg"><i class="fa fa-square-o fa-stack-2x"></i><i class="fa fa-foursquare fa-stack-1x"></i></span></a>
													<a title="Instagram" href="https://www.instagram.com/abdoelmadjid/" target="_blank"><span class="fa-stack fa-lg"><i class="fa fa-square-o fa-stack-2x"></i><i class="fa fa-instagram fa-stack-1x"></i></span></a>
													<br><a title="Pinterest" href="https://id.pinterest.com/abdulmadjidmpd" target="_blank"><span class="fa-stack fa-lg"><i class="fa fa-square-o fa-stack-2x"></i><i class="fa fa-pinterest fa-stack-1x"></i></span></a>
													<a title="GetPocket" href="https://getpocket.com/@abdulmadjid" target="_blank"><span class="fa-stack fa-lg"><i class="fa fa-square-o fa-stack-2x"></i><i class="fa fa-get-pocket fa-stack-1x"></i></span></a>
													<a title="JSFiddle" href="https://jsfiddle.net/user/abdoelmadjid/fiddles/" target="_blank"><span class="fa-stack fa-lg"><i class="fa fa-square-o fa-stack-2x"></i><i class="fa fa-jsfiddle fa-stack-1x"></i></span></a>
													<a title="CodePen" href="http://codepen.io/mahaguru/" target="_blank"><span class="fa-stack fa-lg"><i class="fa fa-square-o fa-stack-2x"></i><i class="fa fa-codepen fa-stack-1x"></i></span></a>
													<a title="Flickr" href="https://www.flickr.com/people/127481125@N04/" target="_blank"><span class="fa-stack fa-lg"><i class="fa fa-square-o fa-stack-2x"></i><i class="fa fa-flickr fa-stack-1x"></i></span></a>
													<a title="Stumbleupon" href="http://www.stumbleupon.com/stumbler/AbdoelMadjid" target="_blank"><span class="fa-stack fa-lg"><i class="fa fa-square-o fa-stack-2x"></i><i class="fa fa-stumbleupon fa-stack-1x"></i></span></a>
													<a title="Stack OverFlow" href="http://stackoverflow.com/users/7070680/abdul-madjid" target="_blank"><span class="fa-stack fa-lg"><i class="fa fa-square-o fa-stack-2x"></i><i class="fa fa-stack-overflow fa-stack-1x"></i></span></a>
												</p>
											</div>
										</div>											
									</div>
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-lg-6">
							<div class="panel panel-default">
								<div class="panel-body status">
									<div class="who clearfix">
										<h4><span class="txt-color-red"><strong>Team IT</strong> </span><strong><em>LCKS-SMK</em><span class="hidden-lg"><br></span> SMK Negeri 1 Kadipaten</strong></h4>
									</div>
									<div class="row">
										<div class="text">
											<div class="col-sm-12 col-md-6 col-lg-6">
												<div class="well text-center">
													<img src="'.ASSETS_URL.'/img/team/madjid.jpg" class="img-circle"  style="max-height:100px;max-width:100px;border:1px solid #000033;">
													<br>
													<span class="txt-color-red"><b>Abdul Madjid, M.Pd.</b></span><br><span class="txt-color-blue"><small><em>Programming & Scripting</em></small></span>
												</div>
											</div>
											<div class="col-sm-12 col-md-6 col-lg-6">
												<div class="well text-center">
													<img src="'.ASSETS_URL.'/img/team/aryono.png" class="img-circle"  style="max-height:100px;max-width:100px;border:1px solid #000033;">
													<br>
													<span class="txt-color-red"><b>Aryono, ST</b></span><br><span class="txt-color-blue"><small><em>Database Management</em></small></span>
												</div>
											</div>
											<div class="col-sm-12 col-md-6 col-lg-6">
												<div class="well text-center">
													<img src="'.ASSETS_URL.'/img/team/redy.png" class="img-circle"  style="max-height:100px;max-width:100px;border:1px solid #000033;">
													<br>
													<span class="txt-color-red"><b>Redy Firmansyah, S.Kom</b></span><br><span class="txt-color-blue"><small><em>End-User Management</em></small></span>
												</div>
											</div>
											<div class="col-sm-12 col-md-6 col-lg-6">
												<div class="well text-center">
													<img src="'.ASSETS_URL.'/img/team/deny2.png"class="img-circle"  style="max-height:100px;max-width:100px;border:1px solid #000033;">
													<br>
													<span class="txt-color-red"><b>Deni Krisdianto, M.T</b></span><br><span class="txt-color-blue"><small><em>Style Management</em></small></span>
												</div>
											</div>
											<div class="col-sm-12 col-md-6 col-lg-6">
												<div class="well text-center">
													<img src="'.ASSETS_URL.'/img/team/ramdani.png" class="img-circle"  style="max-height:100px;max-width:100px;border:1px solid #000033;">
													<br>
													<span class="txt-color-red"><b>Ramdani TS, S.T</b></span><br><span class="txt-color-blue"><small><em>Review & Feed-back Management</em></small></span>
												</div>
											</div>
											<div class="col-sm-12 col-md-6 col-lg-6">
												<div class="well text-center">
													<img src="'.ASSETS_URL.'/img/team/otong.png" class="img-circle" style="max-height:100px;max-width:100px;border:1px solid #000033;">
													<br>
													<span class="txt-color-red"><b>Otong Sunahdi, S.T</b></span><br><span class="txt-color-blue"><small><em>Nettworking Management</em></small></span>
												</div>
											</div>
											<div class="col-sm-12 col-md-6 col-lg-6">
												<div class="well text-center">
													<img src="'.ASSETS_URL.'/img/team/zaenal.png" class="img-circle" style="max-height:100px;max-width:100px;border:1px solid #000033;">
													<br>
													<span class="txt-color-red"><b>M. Zaenal Iskandar S., S.Kom</b></span><br><span class="txt-color-blue"><small><em>Nettworking Management</em></small></span>
												</div>
											</div>
											<div class="col-sm-12 col-md-6 col-lg-6">
												<div class="well text-center">
													<img src="'.ASSETS_URL.'/img/team/endik.png" class="img-circle" style="max-height:100px;max-width:100px;border:1px solid #000033;">
													<br>
													<span class="txt-color-red"><b>Endik Casdi, S.Kom</b></span><br><span class="txt-color-blue"><small><em>Database Management</em></small></span>
												</div>
											</div>
											<div class="col-sm-12 col-md-6 col-lg-6">
												<div class="well text-center">
													<img src="'.ASSETS_URL.'/img/team/dedenita.png" class="img-circle" style="max-height:100px;max-width:100px;border:1px solid #000033;">
													<br>
													<span class="txt-color-red"><b>Dede Nita, ST</b></span><br><span class="txt-color-blue"><small><em>End-User Management</em></small></span>
												</div>
											</div>
											<div class="col-sm-12 col-md-6 col-lg-6">
												<div class="well text-center">
													<img src="'.ASSETS_URL.'/img/team/ridwan.png" class="img-circle" style="max-height:100px;max-width:100px;border:1px solid #000033;">
													<br>
													<span class="txt-color-red"><b>Endang Ridwan, S.Kom.</b></span><br><span class="txt-color-blue"><small><em>Style Management</em></small></span>
												</div>
											</div>
											<div class="col-sm-12 col-md-6 col-lg-6">
												<div class="well text-center">
													<img src="'.ASSETS_URL.'/img/team/feby.png" class="img-circle" style="max-height:100px;max-width:100px;border:1px solid #000033;">
													<br>
													<span class="txt-color-red"><b>Febby Muchamad Darmadi, ST</b></span><br><span class="txt-color-blue"><small><em>Review & Feed-back Management</em></small></span>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="panel panel-default">
								<div class="panel-body status">
									<div class="who clearfix">
										<h4><span class="txt-color-red"><strong>Deteksi</strong> </span><strong>Mesin</strong></h4>
									</div>
									<div class="row">
										<div class="text">
											<p id="d1"></p>

											<script>
											document.getElementById("d1").innerHTML = "<strong>The appVersion property returns version information about the browser</strong><br>" + navigator.appVersion;
											</script>

											<p id="d2"></p>

											<script>
											document.getElementById("d2").innerHTML = "<strong>The userAgent property returns the user-agent header sent by the browser to the server<br></strong>" +
											navigator.userAgent;
											</script>
										</div>
									</div>
								</div>
							</div>
';
					if($_SESSION['SES_MASTER']=="Master"){
						echo '
							<div class="panel panel-default">
								<div class="panel-body status">
									<div class="who clearfix">
										<h4><span class="txt-color-red"><strong>Fitur</strong> </span><strong>Pendukung</strong></h4>
									</div>
									<div class="row">
										<div class="text">
											<a href="?page=other-fitur" target="_new" class="btn btn-default">Fitur</a>
										</div>
									</div>
								</div>
							</div>
';
					}
						echo'
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>';
include("inc/footer.php");
include("inc/scripts.php");
?>