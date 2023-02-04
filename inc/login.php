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
$page_title = "Login";
$page_css[] = "your_style.css";
$no_main_header = true;
$page_html_prop = array("id"=>"extr-page", "class"=>"animated fadeInDown");
include("inc/header.php");
?>
<header id="header">
	<div id="logo-group">
		<img src='<?php echo ASSETS_URL; ?>/img/<?php echo $LogoApp; ?>' width='170' style='padding-top:15px;'>
	</div>
	<span id="extr-page-header-space"><h1><small class='text-danger slideInRight fast animated'><strong><?php echo $NamaLembaga; ?></strong></small></h1></span>
	<!-- <span id="extr-page-header-space"> <span class="hidden-mobile hidden-xs">Need an account?</span> <a href="<?php echo APP_URL; ?>/?page=register" class="btn btn-danger">Create account</a> </span> -->
</header>

<div id="main" role="main">

	<!-- MAIN CONTENT -->
	<div id="content" class="container">
		<br>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-7 col-lg-8 hidden-xs hidden-sm">
				<div class='row'>
					<div class='col-sm-2'>
						<img src="<?php echo ASSETS_URL; ?>/img/<?php echo $Gambar3; ?>" class="display-image" alt="" style="width:75px; margin-top:10px;margin-left:30px">
					</div>
					<div class='col-sm-10'>
					<h1 style='padding-left:-10px;'><span class='semi-bold'>LCKS</span> <i class='ultra-light'>SMK</i> <span class='hidden-mobile'>(Kurikulum 2013)</span> <sup class='badge bg-color-red bounceIn animated'><?PHP echo $VersiApp; ?></sup> <br> <small class='text-danger slideInRight fast animated'><strong><span class='hidden-mobile'>Aplikasi</span> Laporan Capaian Kompetensi Siswa <br>Tahun Ajar <?php echo $TahunAjarAktif; ?> Semester <?php echo $SemesterAktif; ?></strong></small></h1>
					</div>
					<div>
						<div class="pull-left">
							<hr class='simple'>
							<h2><blockquote>It's Okay to be Smart. Experience the simplicity of LCKS, everywhere you go! <br>(Tidak apa-apa untuk menjadi Cerdas. Rasakan kesederhanaan LCKS, ke mana pun Anda pergi!)</blockquote><h2>
							<!-- <div class="login-app-icons">
								<a href="javascript:void(0);" class="btn btn-danger btn-sm">Frontend Template</a>
								<a href="javascript:void(0);" class="btn btn-danger btn-sm">Find out more</a>
							</div> -->
						</div>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-5 col-lg-4">
				<div class="well no-padding">
					<form action="<?php echo ASSETS_URL; ?>/lib/app-login.php" method='post' id="login-form" class="smart-form client-form">
						<header>
							Sign In
						</header>

						<fieldset>
							<section>
								<label class="label">User ID</label>
								<label class="input"> <i class="icon-append fa fa-user"></i>
									<input type="text" name="txtUser">
									<!--<b class="tooltip tooltip-top-left"><i class="fa fa-user txt-color-teal"></i> Please enter email address/username</b> --></label>
							</section>

							<section>
								<label class="label">Kata Kunci</label>
								<label class="input"> <!-- <i class="icon-append fa fa-lock"></i> -->
									<span id="mybutton" onclick="change()"><i class="icon-append fa fa-eye-slash"></i></span>
									<input type="password" name="txtPassword" id="inputPassword">
									<!--<b class="tooltip tooltip-top-left"><i class="fa fa-lock txt-color-teal"></i> Enter your password</b>--> </label>
								<div class="note"></div>
							</section>

							<section>
								<div style="padding:10px 10px 0px 10px;"><?php echo $SalahLogin; ?></div>
							</section>
						</fieldset>
						<footer>
							<button type="submit" class="btn btn-primary">
								Sign in
							</button>
						</footer>
					</form>
				</div>
			</div>
		</div>
	</div>

</div>
<!-- END MAIN PANEL -->
<!-- ==========================CONTENT ENDS HERE ========================== -->

<?php 
//"))
//include required scripts
include("inc/scripts.php"); 
?>
<script type="text/javascript">
	function change() {
		// membuat variabel berisi tipe input dari id='pass', id='pass' adalah form input password 
		var x = document.getElementById('inputPassword').type;
		//membuat if kondisi, jika tipe x adalah password maka jalankan perintah di bawahnya
		if (x == 'password') {
			//ubah form input password menjadi text
			document.getElementById('inputPassword').type = 'text';		
			//ubah icon mata terbuka menjadi tertutup
			document.getElementById('mybutton').innerHTML = '<i class="icon-append fa fa-eye"></i>';
		}
		else {
			//ubah form input password menjadi text
			document.getElementById('inputPassword').type = 'password';
			//ubah icon mata terbuka menjadi tertutup
			document.getElementById('mybutton').innerHTML = '<i class="icon-append fa fa-eye-slash"></i>';
		}
	}
</script>

<?php 
	//include footer
	include("inc/google-analytics.php"); 
?>