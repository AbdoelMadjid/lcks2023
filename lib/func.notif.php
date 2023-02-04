<?php
/* 12/6/2016 --> Sabtu, 28 Januari 2017 13.10.40 --> 07/01/2023 18:42
Design and Programming By. Abdul Madjid, S.Pd., M.Pd.
SMK Negeri 1 Kadipaten
Pin 520543F3 HP. 0812-3000-0420
https://twitter.com/AbdoelMadjid 
https://www.facebook.com/abdulmadjid.mpd
*/
//eval(base64_decode("
	
//===== notifikasi kesalahan TAMBAH DATA jika kosong
function Peringatan($I,$GoTo) {
	$Tampil="
		 <script type='text/javascript'>
			setTimeout(function (e){
					$.SmartMessageBox({
						title : \"<h1 class='text-danger'><i class='fa fa-fw fa-warning fa-lg bounce animated text-danger'></i><strong>Peringatan!!</strong></h1>\",
						content : \"$I\",
						buttons : '[Tutup]'
					}, function(ButtonPress) {
						$GoTo;
				});
				}, 10); 
			window.setTimeout(function(e){ 
			   $GoTo;
			  } ,8000)
			e.preventDefault();
		 </script>";
	return $Tampil;
}

//====== notifikasi proses CRUD dengan smart messagebox
function ns($P,$GoTo,$a) {
	if($P=="Nambah"){$icon="plus";$t="sukses di <strong>tambahkan</strong>";}
	if($P=="Ngedit"){$icon="edit";$t="sukses di <strong>update</strong>";}
	if($P=="Hapus"){$icon="trash";$t="sukses di <strong>hapus</strong>";}

	if($P=="Aktif"){$icon="check-square-o";$t="sukses di <strong>aktifkan</strong>";}
	if($P=="NonAktif"){$icon="remove";$t="sukses di <strong>non aktifkan</strong>";}
	
	if($P=="Ngimpor"){$icon="cloud-upload";$t="sukses di <strong>upload ke database</strong>";}
	if($P=="Ngunduh"){$icon="cloud-download";$t="sukses di <strong>sukses di download</strong>";}
	if($P=="Ngapload"){$icon="upload";$t="sukses di <strong>upload</strong>";}
	if($P=="GagalUpload"){$icon="close";$t="gagal di <strong>upload</strong>";}	
	
	if($P=="Ngonci"){$icon="lock";$t="sukses di <strong>kunci</strong>";}
	if($P=="MukaKonci"){$icon="unlock";$t="sukses di <strong>buka</strong>";}
	
	if($P=="Milih"){$icon="check-square-o";$t="sukses di <strong>pilih</strong>";}
	if($P=="BelumMilih"){$icon="check";$t="belum di <strong>pilih</strong>";}

	if($P=="Enkoder"){$icon="check-square-o";$t="sukses di <strong>encoder</strong>";}
	if($P=="Decoder"){$icon="check-square-o";$t="sukses di <strong>decoder</strong>";}

	if($P=="Tampilkan"){$icon="eye";$t="sukses di <strong>tampilkan</strong>";}
	if($P=="Sembunyikan"){$icon="eye-slash";$t="sukses di <strong>tampilkan</strong>";}

	if($P=="Salin"){$icon="clone";$t="sukses di <strong>salin</strong>";}
	if($P=="Kirim"){$icon="reply";$t="sukses di <strong>kirim</strong>";}
	if($P=="Salah"){$icon="close";$t="";}

	return "
	 <script type='text/javascript'>
		setTimeout(function (e){
				$.SmartMessageBox({
					title : \"<table><tr><td><i class='fa fa-fw fa-$icon fa-2x bounce animated text-primary'></i></td><td><h1 ><small class='text-warning'>Data <strong>$a</strong> $t</small></h1></td></tr></table>\",
					buttons : '[OK]'
				}, function(ButtonPress) {
					$GoTo;
			});
			}, 10); 
		window.setTimeout(function(e){ 
		   $GoTo;
		  } ,6000)
		e.preventDefault();
	 </script>";
}

// notifikasi alert
function nt($Jenis,$isi) {
	If($Jenis=="peringatan"){$jn="warning";$Judul="Peringatan!";$iconna="warning";}
	If($Jenis=="informasi"){$jn="info";$Judul="Informasi!";$iconna="info-circle";}
	If($Jenis=="kesalahan"){$jn="danger";$Judul="Kesalahan!";$iconna="window-close";}
	If($Jenis=="sukses"){$jn="success";$Judul="Sukses!";$iconna="check-square-o";}
	If($Jenis=="catatan"){$jn="info";$Judul="Catatan!";$iconna="edit";}
	return "
	<div class='alert alert-block alert-$jn'>
		<table>
		<tr>
			<td valign='top' width='50' align='center'><i class='fa fa-$iconna fa-3x'></i></td>
			<td  style='padding-left:5px;'>
				<h4 class='alert-heading'> <em>$Judul</em></h4>
				<span>$isi</span>
			</td>
		</tr>
		</table>
	</div>";
}

// notifikasi menghilang
function Alert($Jenis,$isi) {
	If($Jenis=="peringatan"){$jn="warning";$Judul="Peringatan!";$iconna="warning";}
	If($Jenis=="informasi"){$jn="info";$Judul="Informasi!";$iconna="microphone";}
	If($Jenis=="kesalahan"){$jn="danger";$Judul="Kesalahan!";$iconna="window-close";}
	If($Jenis=="sukses"){$jn="success";$Judul="Sukses!";$iconna="check";}

	return "
	<script>
	window.setTimeout(function() {
		$(\"#hilang\").fadeTo(500, 0).slideUp(500, function(){
			$(this).remove(); 
		});
	}, 6000);	
	</script>
	<div id='hilang' class='alert alert-block alert-$jn'>
		<table>
		<tr>
			<td valign='top'><i class='fa fa-$iconna fa-3x'></i></td>
			<td  style='padding-left:5px;'>
				<h4 class='alert-heading'> $Judul </h4>
				<span>$isi</span>
			</td>
		</tr>
		</table>
	</div>";
}

//=============================== perlu di modifikasi dengna modul
function TampilPesan($Pengirim="",$Konten="",$GoTo) { 
	return"
		 <script type='text/javascript'>
			setTimeout(function (e){
					$.SmartMessageBox({
						title : \"<i class='fa fa-envelope txt-color-orangeDark'></i> <span class='txt-color-orangeDark'><strong>$Pengirim</strong></span>\",
						content : \"$Konten\",
						buttons : '[Tutup]'
					}, function(ButtonPress) {
						$GoTo;
				});
				}, 10); 
			window.setTimeout(function(e){ 
			   $GoTo;
			  } ,12000)
			e.preventDefault();
		 </script>";
}

function ErrorInput($i=""){
	$Tampil="
		 <script type='text/javascript'>
			 setTimeout(function (e){
				$.smallBox({
				title : \"Peringatan!!\",
				content : \"$i\",
				color : \"#296191\",
				iconSmall : \"fa fa-thumbs-up bounce animated\",
				timeout : 4000
			}); 
			});
		 </script>";
	return $Tampil;
}

function InfoSimpan($Konten="",$GoTo){
	$Tampil="
		 <script type='text/javascript'>
			setTimeout(function (e){
					$.SmartMessageBox({
						title : \"<h1 style='margin-top:-5px;'><i class='fa fa-fw fa-check-square-o animated txt-color-orange'></i><small class='txt-color-yellow'><strong> Data sukses di Simpan</strong></small></h1>\",
						//content : \"<p>$Konten</p>\",
						buttons : '[OK]'
					}, function(ButtonPress) {
						$GoTo;
				});
				}, 10); 
			window.setTimeout(function(e){ 
			   $GoTo;
			  } ,8000)
			e.preventDefault();
		 </script>";
	return $Tampil;
}

?>