<?php
require_once("inc/init.php");
require_once("inc/config.ui.php");
$page_title = "Impor";
$page_css[] = "your_style.css";
include("inc/header.php");
$page_nav["tools"]["sub"]["ngimpordata"]["active"] = true;
include("inc/nav.php");
echo "<div id='main' role='main'>";
$breadcrumbs["Tools"] = "";
include("inc/ribbon.php");	

	if($_GET['aksi']=="ptk"){$bnt0="info";}else{$bnt0="default";}
	if($_GET['aksi']=="mapel"){$bnt1="info";}else{$bnt1="default";}
	if($_GET['aksi']=="kikd"){$bnt2="info";}else{$bnt2="default";}
	if($_GET['aksi']=="siswa"){$bnt3="info";}else{$bnt3="default";}
	if($_GET['aksi']=="perkelas"){$bnt4="info";}else{$bnt4="default";}
	if($_GET['aksi']=="dapo_siswa"){$bnt5="info";}else{$bnt5="default";}
	if($_GET['aksi']=="absensi_ptk"){$bnt6="info";}else{$bnt6="default";}
	if($_GET['aksi']=="data_ijazah"){$bnt7="info";}else{$bnt7="default";}
	if($_GET['aksi']=="prakerin"){$bnt8="info";}else{$bnt8="default";}

	$Menu.=JudulKolom("Menu Pilihan","th");
	$Menu.="	
	<a href='?page=$page&sub=ngapload&aksi=ptk' class='btn btn-$bnt0 btn-sm btn-block'>Tenaga Pendidik</a> 
	<a href='?page=$page&sub=ngapload&aksi=mapel' class='btn btn-$bnt1 btn-sm btn-block'>Mata Pelajaran</a>
	<a href='?page=$page&sub=ngapload&aksi=kikd' class='btn btn-$bnt2 btn-sm btn-block'>KIKD</a>
	<a href='?page=$page&sub=ngapload&aksi=siswa' class='btn btn-$bnt3 btn-sm btn-block'>Peserta Didik</a>
	<a href='?page=$page&sub=ngapload&aksi=perkelas' class='btn btn-$bnt4 btn-sm btn-block'>Per Kelas</a>
	<a href='?page=$page&sub=ngapload&aksi=dapo_siswa' class='btn btn-$bnt5 btn-sm btn-block'>Dapo Siswa</a>
	<a href='?page=$page&sub=ngapload&aksi=absensi_ptk' class='btn btn-$bnt6 btn-sm btn-block'>Absensi PTK</a>
	<a href='?page=$page&sub=ngapload&aksi=data_ijazah' class='btn btn-$bnt7 btn-sm btn-block'>Data Ijazah</a>
	<a href='?page=$page&sub=ngapload&aksi=prakerin' class='btn btn-$bnt8 btn-sm btn-block'>PKL Siswa</a>
	
	";
	if($_GET['sub']==""){
		$Menu.="";
	}
	else{
		$Menu.="<a href='?page=$page' class='btn btn-default btn-sm btn-block'>Kembali</a>";	
	}


$sub=(isset($_GET['sub']))?$_GET['sub']:"";
switch($sub)
{

	case "tampil":default:

		$HalKanan.=KolomPanel("
		<br><br>
			<div class='text-center'>
				<a href='' class='btn btn-danger btn-circle btn-xl'><i class='fa fa-upload fa-2x'></i></a>
				<br><br>
				<h1>
					<span class='text-danger slideInRight fast animated'>
						<strong> IMPOR DATA MASTER </strong>
					</span>
				</h1>
				<h1>
					<span class='semi-bold'>LCKS</span> <i class='ultra-light'>SMK</i> <span class='hidden-mobile'>(Kurikulum 2013)</span> <sup class='badge bg-color-red bounceIn animated'>$VersiApp</sup> 
					<br> 
					<small class='text-danger slideInRight fast animated'>
						<strong><span class='hidden-mobile'>Aplikasi</span> Laporan Capaian Kompetensi Siswa</strong>
					</small>
				</h1>
			</div>
			<br><br><br>
		");
		$Show.=DuaKolomD(2,KolomPanel($Menu),10,$HalKanan);
		echo MyWidget('fa-upload',$page_title." Data Master",$Tombolna,$Show);
	break;

	case "ngapload":
		$aksi=isset($_GET['aksi'])?$_GET['aksi']:"";

//======upload ptk
		if($aksi=="ptk"){
			$JumlahData=JmlDt("select * from app_user_guru")." orang";
			$JenisUpload="Tenaga Pendidik";
			$Tombol.="<button type='button' class='btn btn-sm btn-info pull-right' onClick=\"window.open('./pages/formatexcel/format-tenaga-pendidik.xls')\" style='margin-top:-10px;'> Contoh </button>";
			$Tombol.="<button type='button' class='btn btn-sm btn-info pull-right' onClick=\"window.open('./pages/excel/download-format-upload.php?formatuploadex=format-guru')\" style='margin-top:-10px;margin-right:10px;'> Format </button>";
			$TabelCaraDownload=
			"<tr>
				<td>NIP</td>
				<td>Isi dengan nip contoh : 19800101 201001 1 002 untuk guru honor beri tanda minus (-)</td>
			</tr>
			<tr>
				<td>GELAR DEPAN</td>
				<td>Isi dengan gelar depan</td>
			</tr>
			<tr>
				<td>NAMA</td>
				<td>Isi dengan nama lengkap</td>
			</tr>
			<tr>
				<td>GELAR BELAKANG</td>
				<td>Isi dengan gelar belakang</td>
			</tr>
			<tr>
				<td>USERID</td>
				<td>Isi dengan username</td>
			</tr>
			<tr>
				<td>PASSWORD</td>
				<td>Isi dengan password</td>
			</tr>
			<tr>
				<td>HAK</td>
				<td>Isi dengan Guru atau Kepala Sekolah</td>
			</tr>
			<tr>
				<td>JENIS KELAMIN</td>
				<td>isi dengan Laki-laki atau Perempuan</td>
			</tr>
			<tr>
				<td>JENIS GURU</td>
				<td>isi dengan Umum, Produktif, BP/BK</td>
			</tr>";
		}
//======upload mapel
		else if($aksi=="mapel"){
			$JumlahData=JmlDt("select * from ak_matapelajaran")."";
			$JenisUpload="Mata Pelajaran";
			$Tombol.="<button type='button' class='btn btn-sm btn-info pull-right' onClick=\"window.open('./pages/formatexcel/format-mata-pelajaran.xls')\" style='margin-top:-10px;'> Contoh </button>";
			$Tombol.="<button type='button' class='btn btn-sm btn-info pull-right' onClick=\"window.open('./pages/excel/download-format-upload.php?formatuploadex=format-mapel')\" style='margin-top:-10px;margin-right:10px;'> Format </button>";
			$TabelCaraDownload=
			"
			<tr>
				<td>NOMOR</td>
				<td>Isi dengan nomor urut semua mata pelajaran</td>
			</tr>
			<tr>
				<td>KODE-PK</td>
				<td>Isi dengan kode paket keahlian sesuai dengan input paket keahlian di menu Akademik</td>
			</tr>
			<tr>
				<td>KELOMPOK</td>
				<td>Isi dengan kelompok mapel contoh A, B, C1, C2, C3 dan M untuk Mulok</td>
			</tr>
			<tr>
				<td>NO URUT MP</td>
				<td>Isi dengan nomor urut mata pelajaran di setiap KELOMPOK mapel</td>
			</tr>
			<tr>
				<td>NAMA MAPEL</td>
				<td>Isi dengan nama mapel tanpa tanda baca atau simbol</td>
			</tr>
			<tr>
				<td>JENIS MAPEL</td>
				<td>isi dengan jenis mapel yang di sesuaikan dengan jenis mapel, contoh TI untuk C1 Teknik Informatika, RPL untuk C2 dan C3</td>
			</tr>
			<tr>
				<td>SEMESTER 1 - 6</td>
				<td>ini dengan angka 1 jika mata pelajaran di ajarkan pada tiap semester 1 - 6 dan isi dengan 0 jika tidak diajarakan</td>
			</tr>";
		}
//======upload kikd
		else if($aksi=="kikd"){
			$JumlahData=JmlDt("select * from ak_kikd")."";
			$JenisUpload="KIKD";
			$Tombol.="<button type='button' class='btn btn-sm btn-info pull-right' onClick=\"window.open('./pages/formatexcel/format-kikd.xls')\" style='margin-top:-10px;'> Contoh </button>";
			$Tombol.="<button type='button' class='btn btn-sm btn-info pull-right' onClick=\"window.open('./pages/excel/download-format-upload.php?formatuploadex=format-kikd')\" style='margin-top:-10px;margin-right:10px;'> Format </button>";
			$TabelCaraDownload=
			"
			<tr>
				<td>JENIS MAPEL</th>
				<td>isi dengan jenis mapel yang di sesuaikan dengan jenis mapel, contoh TI untuk C1 Teknik Informatika, RPL untuk C2 dan C3</td>
			</tr>
			<tr>
				<td>KELOMPOK</td>
				<td>Isi dengan kelompok mapel contoh A, B, C1, C2, C3 dan M untuk Mulok</td>
			</tr>
			<tr>
				<td>NAMA MATA PELAJARAN</td>
				<td>Isi dengan nama mata pelajaran sesuai dengan isian mata pelajaran di menu mata pelajaran</td>
			</tr>
			<tr>
				<td>TINGKAT</td>
				<td>Isi dengan tingkat X, XI atau XII</td>
			</tr>
			<tr>
				<td>KODE RANAH</td>
				<td>Isi dengan isi dengan KDS untuk ranah Sikap, KDP untuk ranah Pengetahuan dan KDK untuk ranah Keterampilan</td>
			</tr>
			<tr>
				<td>NO KIKD</td>
				<td>isi dengan nomor urut untuk setiap ranah contoh 1.01 untuk nomor 1 kikd sikap K1, 2.01 untuk nomor 1 kikd sikap K2, 3.01 untuk nomor 1 kikd K3, dan 4.01 untuk nomor 1 kikd K4</td>
			</tr>
			<tr>
				<td>ISI KIKD</td>
				<td>isi dengan kikd</td>
			</tr>";
		}
//======upload siswa
		else if($aksi=="siswa"){
			$JumlahData=JmlDt("select * from siswa_biodata")." orang";
			$JenisUpload="Peserta Didik";
			$Tombol.="<button type='button' class='btn btn-sm btn-info pull-right' onClick=\"window.open('./pages/formatexcel/format-siswa.xls')\" style='margin-top:-10px;'> Contoh </button>";
			$Tombol.="<button type='button' class='btn btn-sm btn-info pull-right' onClick=\"window.open('./pages/excel/download-format-upload.php?formatuploadex=format-siswa')\" style='margin-top:-10px;margin-right:10px;'> Format </button>";
			$TabelCaraDownload=
			"
			<tr>
				<td>NIS</td>
				<td>isi dengan NIS dengan tidak boleh ada tanda baca, spasi</td>
			</tr>
			<tr>
				<td>NISN</td>
				<td>Isi dengan NISN jika tidak ada beri tanda minus (-)</td>
			</tr>
			<tr>
				<td>TAHUN MASUK</td>
				<td>Isi dengan tahun masuk siswa</td>
			</tr>
			<tr>
				<td>KODE PK</td>
				<td>isi dengan kode paket keahlian</td>
			</tr>
			<tr>
				<td>NAMA LENGKAP</td>
				<td>isi dengan nama lengkap siswa, jika nama siswa ada tanda kutif satu maka beri tanda \ (back slash) sebelum tanda kutif satu</td>
			</tr>";
		}
//======upload perkelas
		else if($aksi=="perkelas"){
			$JumlahData=JmlDt("select * from ak_perkelas")." orang";
			$JenisUpload="Siswa Per Kelas";
			$Tombol.="<button type='button' class='btn btn-sm btn-info pull-right' onClick=\"window.open('./pages/formatexcel/format-perkelas.xls')\" style='margin-top:-10px;'> Contoh </button>";
			$Tombol.="<button type='button' class='btn btn-sm btn-info pull-right' onClick=\"window.open('./pages/excel/download-format-upload.php?formatuploadex=format-perkelas')\" style='margin-top:-10px;margin-right:10px;'> Format </button>";
			$TabelCaraDownload=
			"
			<tr>
				<td>TAHUN AJARAN</td>
				<td>isi dengan TAHUN AJARAN untuk kelas yang aktif</td>
			</tr>
			<tr>
				<td>TINGKAT</td>
				<td>Isi dengan X, XI atau XII</td>
			</tr>
			<tr>
				<td>NAMA KELAS</td>
				<td>Isi dengan nama kelas sesuai dengan nama di menu Kelas</td>
			</tr>
			<tr>
				<td>KODE PK</td>
				<td>isi dengan kode paket keahlian</td>
			</tr>
			<tr>
				<td>NIS</td>
				<td>isi dengan nis siswa</td>
			</tr>
			<tr>
				<td>NAMA SISWA</td>												
				<td>isi dengan nama siswa</td>
			</tr>";
		}
//======upload pkl siswa
		else if($aksi=="prakerin"){
			$JumlahData=JmlDt("select * from wk_prakerin")."";
			$JenisUpload="PKL Siswa";
			$Tombol.="<button type='button' class='btn btn-sm btn-info pull-right' onClick=\"window.open('./pages/formatexcel/format-pkl-siswa.xls')\" style='margin-top:-10px;'> Contoh </button>";
			$Tombol.="<button type='button' class='btn btn-sm btn-info pull-right' onClick=\"window.open('./pages/excel/download-format-upload.php?formatuploadex=format-pkl-siswa')\" style='margin-top:-10px;margin-right:10px;'> Format </button>";
			$TabelCaraDownload=
			"
			<tr>
				<td>NOMOR</td>
				<td>Isi dengan nomor urut</td>
			</tr>
			";
		}
//======upload daposiswa
		else if($aksi=="dapo_siswa"){
			$JumlahData=JmlDt("select * from dapodik")."";
			$JenisUpload="Profil Dapodik Siswa";
			$Tombol.="<button type='button' class='btn btn-sm btn-info pull-right' onClick=\"window.open('./pages/formatexcel/format-daposiswa.xls')\" style='margin-top:-10px;'> Format </button>";
			$TabelCaraDownload="";
		}
//======upload daposiswa
		else if($aksi=="absensi_ptk"){
			$JumlahData=JmlDt("select * from web_absensi_kode")."";
			$JenisUpload="Data Abseni PTK";
			$Tombol.="<button type='button' class='btn btn-sm btn-info pull-right' onClick=\"window.open('./pages/formatexcel/format-absensi-ptk.xls')\" style='margin-top:-10px;'> Format </button>";
			$TabelCaraDownload="";
		}
		//======upload daposiswa
		else if($aksi=="data_ijazah"){
			$JumlahData=JmlDt("select * from ujian_usukk")."";
			$JenisUpload="Data Ijazah";
			$Tombol.="<button type='button' class='btn btn-sm btn-info pull-right' onClick=\"window.open('./pages/formatexcel/format-data-izajah.xls')\" style='margin-top:-10px;'> Format </button>";
			$TabelCaraDownload="";
		}

		if($JumlahData==0){  
			$DataUpload.=nt("peringatan","Data Masih Kosong");
		}
		else{
			$DataUpload.=nt("informasi","<strong>$JumlahData</strong> $JenisUpload","Jumlah Data");
		}

		$ExportKeSQL.=JudulKolom("Upload $JenisUpload","upload");
		$ExportKeSQL.="
		<script type=\"text/javascript\">
			function validateForm()
			{
				function hasExtension(inputID, exts) {
					var fileName = document.getElementById(inputID).value;
					return (new RegExp('(' + exts.join('|').replace(/\./g, '\\.') + ')$')).test(fileName);
				}
		 
				if(!hasExtension('filepegawaiall', ['.xls'])){
					alert(\"Hanya file XLS (Excel 2003) yang diijinkan.\");
					return false;
				}
			}
		</script>

		$DataUpload
		
		<form name='myForm' id='myForm' onSubmit='return validateForm()' action='?page=$page&sub=$aksi' method='post' enctype='multipart/form-data' class='smart-form'>
			<section>
				<label class='label'>File input</label>
				<div class='input input-file'>
					<span class='button'>
					<input type='file' id='id-input-file-2' name='userfile' onchange='this.parentNode.nextSibling.value = this.value'>Browse</span><input type='text' placeholder='Include some files' readonly=''>
				</div>
			</section>
			<ul style='margin-left:15px;'>
			<li><code>Baris Data Excel <em><strong>harus</strong></em> kurang atau sama dengan 1000 baris</code></li>
			<li><code>file yang bisa di import adalah .xls (Excel 2003-2007).</code></li>
			<li><code>Silakan cecklist kotak di bawah ini untuk menghapus seluruh data sebelum data di upload. Gunakan jika benar-benar data mau di hapus!</code></li>
			</ul><br>
			<span class='pull-right'>
				<label class='checkbox'>
					<input type='checkbox' name='drop' value='1'>
					<i></i>Hapus semua data $JenisUpload</label>
			</span><br><br>
			<div class='form-actions center'><button type='button submit' name='submit' class='btn btn-sm btn-success'>Upload</button></div>
		</form>";

		$CaraDownload.=$Tombol;
		$CaraDownload.=JudulKolom('Cara Pengisian',"");
		$CaraDownload.="
		<table class='table table-bordered'>
			<thead>
				<tr>
					<th class='text-center' width='150'>NAMA KOLOM</th>
					<th class='text-center'>KETERANGAN</th>
				</tr>
			</thead>
			<tbody>$TabelCaraDownload</tbody>
		</table>";

		$Show.=DuaKolomD(2,KolomPanel($Menu),10,DuaKolomSama($CaraDownload,$ExportKeSQL));

		echo $UploadDataMaster;
		$tandamodal="#UploadDataMaster";
		echo MyWidget('fa-upload',$page_title." Data Master",$Tombolna,$Show);
	break;


	case "siswa":
		if(isset($_POST['submit'])){
			//menggunakan class phpExcelReader
			include "pages/excel_reader.php"; 
						
			//membaca file excel yang diupload
			 $data = new Spreadsheet_Excel_Reader($_FILES['userfile']['tmp_name']);
			 //membaca jumlah baris dari data excel
			 $baris = $data->rowcount($sheet_index=0);

			//jika kosongkan data dicentang jalankan kode berikut
				if($_POST['drop']==1){
			//kosongkan tabel 
					 $truncatea ="TRUNCATE TABLE siswa_biodata";
					 mysql_query($truncatea);
					 $truncateb ="TRUNCATE TABLE user_siswa";
					 mysql_query($truncateb);

				}
				
			//nilai awal counter jumlah data yang sukses dan yang gagal diimport
			 $sukses = 0;
			 $gagal = 0;

			//import data excel dari baris kedua, karena baris pertama adalah nama kolom
			 for ($i=2; $i<=$baris; $i++) {
			 $txtNIS = $data->val($i,1);
			 $txtNISN = $data->val($i,2);
			 $txtTahunMasuk = $data->val($i,3);
			 $txtKodePK = $data->val($i,4);
			 $txtNama = $data->val($i,5);
			 $txtTmpLahir = $data->val($i,6);
			 $txtTglLahir = $data->val($i,7);
			 $txtJenKel = $data->val($i,8);
			 $txtAgama = $data->val($i,9);
			 $txtStatKel = $data->val($i,10);
			 $txtAnakKe = $data->val($i,11);
			 $txtTelp = $data->val($i,12);
			 $txtSekolAsal = $data->val($i,13);
			 $txtDiterimaKls = $data->val($i,14);
			 $txtTglDiterima = $data->val($i,15);
			 $txtAsalSiswa = $data->val($i,16);
			 $txtKetPindah = $data->val($i,17);
			 $txtPhoto = $data->val($i,18);
				
			//setelah data dibaca, sisipkan ke dalam tabel barang
			 $query = "INSERT INTO siswa_biodata values ('$txtNIS','$txtNISN','$txtTahunMasuk','$txtKodePK','$txtNama','$txtTmpLahir','$txtTglLahir','$txtJenKel','$txtAgama','$txtStatKel','$txtAnakKe','$txtTelp','$txtSekolAsal','$txtDiterimaKls','$txtTglDiterima','$txtAsalSiswa','$txtKetPindah','$txtPhoto')";
			 $hasil = mysql_query($query);
			 //TAMBAH USER_SISWA
			 $query2 = "INSERT INTO user_siswa values ('$txtNIS','$txtKodePK','$txtTahunMasuk','$txtNIS',md5('$txtNIS'),'Siswa','$txtNIS','','','')";
			 $hasil1 = mysql_query($query2);			 
			//menambah counter jika berhasil atau gagal
			 if($hasil) $sukses++;
			 else $gagal++;
			}
			 //tampilkan report hasil import
			echo '<div id="preloader"><div id="cssload"></div></div>';
			echo ns("Ngimpor","parent.location='?page=$page&sub=ngapload&aksi=siswa'","Peserta Didik");		

			//echo InfoSimpan("Biodata Siswa sukses di IMPOR!","parent.location='?page=$page'");
		}

	break;

	case "perkelas":
		if(isset($_POST['submit'])){
			//menggunakan class phpExcelReader
			include "pages/excel_reader.php"; 

			//membaca file excel yang diupload
			 $data = new Spreadsheet_Excel_Reader($_FILES['userfile']['tmp_name']);
			 //membaca jumlah baris dari data excel
			 $baris = $data->rowcount($sheet_index=0);

			//jika kosongkan data dicentang jalankan kode berikut
				if($_POST['drop']==1){
			//kosongkan tabel perkelas
					 $truncate ="TRUNCATE TABLE perkelas";
					 mysql_query($truncate);
				}
				
			//nilai awal counter jumlah data yang sukses dan yang gagal diimport
			$sukses = 0;
			$gagal = 0;

			//import data excel dari baris kedua, karena baris pertama adalah nama kolom
			for ($i=2; $i<=$baris; $i++) {
			 //$kd_perkelas = buatKode("perkelas","kls_");
			 $txtThnAjaran = $data->val($i,1);
			 $txtTKKelas = $data->val($i,2);
			 $txtKelas = $data->val($i,3);
			 $txKDPaket = $data->val($i,4);
			 $txtNIS = $data->val($i,5);
				
			//setelah data dibaca, sisipkan ke dalam tabel barang
			 $query = "INSERT INTO perkelas VALUES ('','$txtThnAjaran','$txtTKKelas','$txtKelas','$txKDPaket','$txtNIS')";
			 $hasil = mysql_query($query);
			 
			//menambah counter jika berhasil atau gagal
			 if($hasil) $sukses++;
			 else $gagal++;			 
			}
			 //tampilkan report hasil import
			echo '<div id="preloader"><div id="cssload"></div></div>';
			echo ns("Ngimpor","parent.location='?page=$page&sub=ngapload&aksi=perkelas'","Siswa Per Kelas");		

			//echo InfoSimpan("Siswa Per Kelas sukses di IMPOR!","parent.location='?page=$page'");
		}
	break;

	case "kikd":
		if(isset($_POST['submit'])){

			$time = microtime();
			$time = explode(' ', $time);
			$time = $time[1] + $time[0];
			$start = $time;

			//menggunakan class phpExcelReader
			include "pages/excel_reader.php"; 
					
			//membaca file excel yang diupload
			$data = new Spreadsheet_Excel_Reader($_FILES['userfile']['tmp_name']);

			//membaca jumlah baris dari data excel
			$baris = $data->rowcount($sheet_index=0);

			//jika kosongkan data dicentang jalankan kode berikut
			if($_POST['drop']==1){
				
				//kosongkan tabel kikd
				 $truncate ="TRUNCATE TABLE kikd";
				 mysql_query($truncate);
			}

			//nilai awal counter jumlah data yang sukses dan yang gagal diimport
			$sukses = 0;
			$gagal = 0;

			//import data excel dari baris kedua, karena baris pertama adalah nama kolom
			for ($i=2; $i<=$baris; $i++) {
				$kd_kompetensi = buatKode("kikd","kikd_");
				$jenismapel = $data->val($i,1);
				$kelompok = $data->val($i,2);
				$nama_mapel = $data->val($i,3);
				$tingkat = $data->val($i,4);
				$kode_ranah = $data->val($i,5);
				$no_kikd = $data->val($i,6);
				$kikd = $data->val($i,7);

				//setelah data dibaca, sisipkan ke dalam tabel barang
				$query = "INSERT INTO kikd values ('$kd_kompetensi','$jenismapel','$kelompok','$nama_mapel','$tingkat','$kode_ranah','$no_kikd','$kikd')";
				$hasil = mysql_query($query);

				//menambah counter jika berhasil atau gagal
				if($hasil) $sukses++;
				else $gagal++;
			}
			//tampilkan report hasil import
			echo '<div id="preloader"><div id="cssload"></div></div>';
			echo ns("Ngimpor","parent.location='?page=$page&sub=ngapload&aksi=kikd'","KIKD");		

			//echo InfoSimpan("KIKD sukses di IMPOR!","parent.location='?page=$page'");
		}
	break;

	case "mapel":
		if(isset($_POST['submit'])){
			//menggunakan class phpExcelReader
			include "pages/excel_reader.php"; 
						
			//membaca file excel yang diupload
			 $data = new Spreadsheet_Excel_Reader($_FILES['userfile']['tmp_name']);
			 //membaca jumlah baris dari data excel
			 $baris = $data->rowcount($sheet_index=0);

			//jika kosongkan data dicentang jalankan kode berikut
				if($_POST['drop']==1){
			//kosongkan tabel user_guru
					 $truncate ="TRUNCATE TABLE matapelajaran";
					 mysql_query($truncate);
				}
				
			//nilai awal counter jumlah data yang sukses dan yang gagal diimport
			 $sukses = 0;
			 $gagal = 0;

			//import data excel dari baris kedua, karena baris pertama adalah nama kolom
			 for ($i=2; $i<=$baris; $i++) {
			 $txtNo = $data->val($i,1);
			 $txtKDPK = $data->val($i,2);
			 $txtKel = $data->val($i,3);
			 $txtNoMP = $data->val($i,4);
			 $txtNamaMP = $data->val($i,5);
			 $txtJMP = $data->val($i,6);
			 $txtS1 = $data->val($i,7);
			 $txtS2 = $data->val($i,8);
			 $txtS3 = $data->val($i,9);
			 $txtS4 = $data->val($i,10);
			 $txtS5 = $data->val($i,11);
			 $txtS6 = $data->val($i,12);
			
			 $kode_mapel=$txtKDPK."-".$txtKel.$txtNoMP;
			 $kelmapel=$txtKel.$txtNoMP;
			//setelah data dibaca, sisipkan ke dalam tabel barang
			 $query = "INSERT INTO matapelajaran values ('$txtNo','$kode_mapel','$txtKDPK','$txtKel','$txtNoMP','$kelmapel','$txtNamaMP','$txtJMP','$txtS1','$txtS2','$txtS3','$txtS4','$txtS5','$txtS6')";
			 $hasil = mysql_query($query);
			 
			//menambah counter jika berhasil atau gagal
			 if($hasil) $sukses++;
			 else $gagal++;
			}
			 //tampilkan report hasil import
			echo '<div id="preloader"><div id="cssload"></div></div>';
			echo ns("Ngimpor","parent.location='?page=$page&sub=ngapload&aksi=mapel'","Mata Pelajaran");		

			//echo InfoSimpan("Data Mata Pelajaran sukses di IMPOR!","parent.location='?page=$page'");
		}	
	break;

	case "ptk":
		if(isset($_POST['submit'])){
			//menggunakan class phpExcelReader
			include "pages/excel_reader.php"; 
						
			//membaca file excel yang diupload
			 $data = new Spreadsheet_Excel_Reader($_FILES['userfile']['tmp_name']);
			 //membaca jumlah baris dari data excel
			 $baris = $data->rowcount($sheet_index=0);

			//jika kosongkan data dicentang jalankan kode berikut
				if($_POST['drop']==1){
			//kosongkan tabel user_guru
					 $truncate ="TRUNCATE TABLE user_guru";
					 mysql_query($truncate);
				}
				
			//nilai awal counter jumlah data yang sukses dan yang gagal diimport
			 $sukses = 0;
			 $gagal = 0;

			//import data excel dari baris kedua, karena baris pertama adalah nama kolom
			 for ($i=2; $i<=$baris; $i++) {
			 $kd_guru = buatKode("user_guru","gmp_");			 
			 $txtNIP = $data->val($i,1);
			 $txtNAMA = $data->val($i,2);
			 $txtUserID = $data->val($i,3);
			 $txtKataKunci = $data->val($i,4);
			 $txtHAK = $data->val($i,5);
			 $txtJK = $data->val($i,6);
			 $txtJenGur = $data->val($i,7);
				
			//setelah data dibaca, sisipkan ke dalam tabel barang
			 $query = "INSERT INTO user_guru values ('$kd_guru','$txtNIP','$txtNAMA','$txtUserID',md5('$txtKataKunci'),'$txtHAK','$txtJK','$txtJenGur','$txtKataKunci','0000-00-00 00:00:00','0000-00-00 00:00:00','0','')";
			 $hasil = mysql_query($query);
			 
			//menambah counter jika berhasil atau gagal
			 if($hasil) $sukses++;
			 else $gagal++;
			}
			 //tampilkan report hasil import
			echo '<div id="preloader"><div id="cssload"></div></div>';
			echo ns("Ngimpor","parent.location='?page=$page&sub=ngapload&aksi=ptk'","Tenaga Pendidik");		

			//echo InfoSimpan("Data Guru sukses di IMPOR!","parent.location='?page=$page'");
		}	

	break;

	case "prakerin":
		if(isset($_POST['submit'])){
			//menggunakan class phpExcelReader
			include "pages/excel_reader.php"; 
						
			//membaca file excel yang diupload
			 $data = new Spreadsheet_Excel_Reader($_FILES['userfile']['tmp_name']);
			 //membaca jumlah baris dari data excel
			 $baris = $data->rowcount($sheet_index=0);

			//jika kosongkan data dicentang jalankan kode berikut
				if($_POST['drop']==1){
			//kosongkan tabel user_guru
					 $truncate ="TRUNCATE TABLE prakerin";
					 mysql_query($truncate);
				}
				
			//nilai awal counter jumlah data yang sukses dan yang gagal diimport
			 $sukses = 0;
			 $gagal = 0;

			//import data excel dari baris kedua, karena baris pertama adalah nama kolom
			 for ($i=2; $i<=$baris; $i++) {
			 $kd_pkl=buatKode("prakerin","pkl_");
			 $txtNIS = $data->val($i,1);
			 $txtPrsh = $data->val($i,2);
			 $txtLokasi = $data->val($i,3);
			 $txtBlnAwal = $data->val($i,4);
			 $txtBlnAkhir = $data->val($i,5);
			 $txtTA = $data->val($i,6);
			 $txtS = $data->val($i,7);
			 $txtPredikat = $data->val($i,8);
			 $txtNilai = $data->val($i,9);
			
			 $IsiKet = $txtPredikat." dalam mengikuti prakerin";

			//setelah data dibaca, sisipkan ke dalam tabel barang
			 $query = "INSERT INTO prakerin values ('$kd_pkl','$txtNIS','$txtPrsh','$txtLokasi','$txtBlnAwal','$txtBlnAkhir','$txtTA','$txtS','$txtPredikat','$txtNilai','$IsiKet')";
			 $hasil = mysql_query($query);
			 
			//menambah counter jika berhasil atau gagal
			 if($hasil) $sukses++;
			 else $gagal++;
			}
			 //tampilkan report hasil import
			echo '<div id="preloader"><div id="cssload"></div></div>';
			echo ns("Ngimpor","parent.location='?page=$page&sub=ngapload&aksi=prakerin'","PKL Siswa");		

			//echo InfoSimpan("Data Mata Pelajaran sukses di IMPOR!","parent.location='?page=$page'");
		}	
	break;

	case "dapo_siswa":
		if(isset($_POST['submit'])){
			//menggunakan class phpExcelReader
			include "pages/excel_reader.php"; 
						
			//membaca file excel yang diupload
			 $data = new Spreadsheet_Excel_Reader($_FILES['userfile']['tmp_name']);
			 //membaca jumlah baris dari data excel
			 $baris = $data->rowcount($sheet_index=0);

			//jika kosongkan data dicentang jalankan kode berikut
				if($_POST['drop']==1){
			//kosongkan tabel 
					 $truncatea ="TRUNCATE TABLE dapodik";
					 mysql_query($truncatea);
				}
				
			//nilai awal counter jumlah data yang sukses dan yang gagal diimport
			 $sukses = 0;
			 $gagal = 0;

			//import data excel dari baris kedua, karena baris pertama adalah nama kolom
			for ($i=2; $i<=$baris; $i++) {
				$txt_nis = $data->val($i,2);
				$txt_nama_siswa = $data->val($i,3);
				$txt_jenis_kelamin = $data->val($i,4);
				$txt_nisn = $data->val($i,5);
				$txt_tmp_lahir = $data->val($i,6);
				$txt_tgl_lahir = $data->val($i,7);
				$txt_nik = $data->val($i,8);
				$txt_agama = $data->val($i,9);
				$txt_alamat = $data->val($i,10);
				$txt_rt = $data->val($i,11);
				$txt_rw = $data->val($i,12);
				$txt_dusun = $data->val($i,13);
				$txt_desa = $data->val($i,14);
				$txt_kec = $data->val($i,15);
				$txt_kode_pos = $data->val($i,16);
				$txt_jenis_tinggal = $data->val($i,17);
				$txt_alat_transportasi = $data->val($i,18);
				$txt_telepon = $data->val($i,19);
				$txt_hp = $data->val($i,20);
				$txt_email = $data->val($i,21);
				$txt_no_seri_skhun = $data->val($i,22);
				$txt_penerima_kps = $data->val($i,23);
				$txt_nomor_kps = $data->val($i,24);
				$txt_ayah_nama = $data->val($i,25);
				$txt_ayah_tahun_lahir = $data->val($i,26);
				$txt_ayah_jenjang_pendidikan = $data->val($i,27);
				$txt_ayah_pekerjaan = $data->val($i,28);
				$txt_ayah_penghasilan = $data->val($i,29);
				$txt_ayah_nik = $data->val($i,30);
				$txt_ibu_nama = $data->val($i,31);
				$txt_ibu_tahun_lahir = $data->val($i,32);
				$txt_ibu_jenjang_pendidikan = $data->val($i,33);
				$txt_ibu_pekerjaan = $data->val($i,34);
				$txt_ibu_penghasilan = $data->val($i,35);
				$txt_ibu_nik = $data->val($i,36);
				$txt_wali_nama = $data->val($i,37);
				$txt_wali_tahun_lahir = $data->val($i,38);
				$txt_wali_jenjang_pendidikan = $data->val($i,39);
				$txt_wali_pekerjaan = $data->val($i,40);
				$txt_wali_penghasilan = $data->val($i,41);
				$txt_wali_nik = $data->val($i,42);
				$txt_kelas = $data->val($i,43);
				$txt_no_peserta_un = $data->val($i,44);
				$txt_no_seri_ijazah = $data->val($i,45);
				$txt_penerima_kip = $data->val($i,46);
				$txt_nomor_kip = $data->val($i,47);
				$txt_nama_di_kip = $data->val($i,48);
				$txt_nomor_kks = $data->val($i,49);
				$txt_no_reg_akta_lahir = $data->val($i,50);
				$txt_bank = $data->val($i,51);
				$txt_no_rek_bank = $data->val($i,52);
				$txt_rek_atas_nama = $data->val($i,53);
				$txt_layak_pip = $data->val($i,54);
				$txt_alasan_layak_pip = $data->val($i,55);
				$txt_kebutuhan_khusus = $data->val($i,56);
				$txt_sekolah_asal = $data->val($i,57);
				$txt_anakkeberapa = $data->val($i,58);
				$txt_lintang = $data->val($i,59);
				$txt_bujur = $data->val($i,60);
				$txt_no_rumah = $data->val($i,61);
				$txt_warganegara = $data->val($i,62);
				$txt_kab = $data->val($i,63);

			 $query = "INSERT INTO dapodik values (
				'$txt_nis',
				'$txt_nama_siswa',
				'$txt_jenis_kelamin',
				'$txt_nisn',
				'$txt_tmp_lahir',
				'$txt_tgl_lahir',
				'$txt_nik',
				'$txt_agama',
				'$txt_alamat',
				'$txt_rt',
				'$txt_rw',
				'$txt_dusun',
				'$txt_desa',
				'$txt_kec',
				'$txt_kode_pos',
				'$txt_jenis_tinggal',
				'$txt_alat_transportasi',
				'$txt_telepon',
				'$txt_hp',
				'$txt_email',
				'$txt_no_seri_skhun',
				'$txt_penerima_kps',
				'$txt_nomor_kps',
				'$txt_ayah_nama',
				'$txt_ayah_tahun_lahir',
				'$txt_ayah_jenjang_pendidikan',
				'$txt_ayah_pekerjaan',
				'$txt_ayah_penghasilan',
				'$txt_ayah_nik',
				'$txt_ibu_nama',
				'$txt_ibu_tahun_lahir',
				'$txt_ibu_jenjang_pendidikan',
				'$txt_ibu_pekerjaan',
				'$txt_ibu_penghasilan',
				'$txt_ibu_nik',
				'$txt_wali_nama',
				'$txt_wali_tahun_lahir',
				'$txt_wali_jenjang_pendidikan',
				'$txt_wali_pekerjaan',
				'$txt_wali_penghasilan',
				'$txt_wali_nik',
				'$txt_kelas',
				'$txt_no_peserta_un',
				'$txt_no_seri_ijazah',
				'$txt_penerima_kip',
				'$txt_nomor_kip',
				'$txt_nama_di_kip',
				'$txt_nomor_kks',
				'$txt_no_reg_akta_lahir',
				'$txt_bank',
				'$txt_no_rek_bank',
				'$txt_rek_atas_nama',
				'$txt_layak_pip',
				'$txt_alasan_layak_pip',
				'$txt_kebutuhan_khusus',
				'$txt_sekolah_asal',
				'$txt_anakkeberapa',
				'$txt_lintang',
				'$txt_bujur',
				'$txt_no_rumah',
				'$txt_warganegara',
				'$txt_kab')";

			 $hasil = mysql_query($query);
			//menambah counter jika berhasil atau gagal
			 if($hasil) $sukses++;
			 else $gagal++;
			}
			 //tampilkan report hasil import
			echo '<div id="preloader"><div id="cssload"></div></div>';
			echo ns("Ngimpor","parent.location='?page=$page&sub=ngapload&aksi=dapo_siswa'","Dapodik Peserta Didik");		

			//echo InfoSimpan("Biodata Siswa sukses di IMPOR!","parent.location='?page=$page'");
		}

	break;

	case "absensi_ptk":
		if(isset($_POST['submit'])){
			//menggunakan class phpExcelReader
			include "pages/excel_reader.php"; 
						
			//membaca file excel yang diupload
			 $data = new Spreadsheet_Excel_Reader($_FILES['userfile']['tmp_name']);
			 //membaca jumlah baris dari data excel
			 $baris = $data->rowcount($sheet_index=0);

			//jika kosongkan data dicentang jalankan kode berikut
				if($_POST['drop']==1){
			//kosongkan tabel user_guru
					 $truncate ="TRUNCATE TABLE web_absensi_kode";
					 mysql_query($truncate);
				}
				
			//nilai awal counter jumlah data yang sukses dan yang gagal diimport
			 $sukses = 0;
			 $gagal = 0;

			//import data excel dari baris kedua, karena baris pertama adalah nama kolom
			 for ($i=2; $i<=$baris; $i++) {
			 $txtKode = $data->val($i,2);
			 $txtNIP = $data->val($i,3);
			 $txtNIK = $data->val($i,4);
			 $txtNUPTK = $data->val($i,5);
			 $txtNama = $data->val($i,6);
			 $txtJK = $data->val($i,7);
			 $txtTmpLahir = $data->val($i,8);
			 $txtTglLahir = $data->val($i,9);
			 $txtStatus = $data->val($i,10);
			 $txtJenisPTK = $data->val($i,11);
			 $txtTgsTambah = $data->val($i,12);
			 $txtEmail = $data->val($i,13);
			 $txtHp = $data->val($i,14);
				
			//setelah data dibaca, sisipkan ke dalam tabel barang
			 $query = "INSERT INTO web_absensi_kode values ('','$txtKode','$txtNIP','$txtNIK','$txtNUPTK','$txtNama','$txtJK','$txtTmpLahir','$txtTglLahir','$txtStatus','$txtJenisPTK','$txtTgsTambah','$txtEmail','$txtHp')";
			 $hasil = mysql_query($query);
			 
			//menambah counter jika berhasil atau gagal
			 if($hasil) $sukses++;
			 else $gagal++;
			}
			 //tampilkan report hasil import
			echo '<div id="preloader"><div id="cssload"></div></div>';
			echo ns("Ngimpor","parent.location='?page=$page&sub=ngapload&aksi=absensi_ptk'","Absensi Tenaga Pendidik");		

			//echo InfoSimpan("Data Guru sukses di IMPOR!","parent.location='?page=$page'");
		}	

	break;

	case "data_ijazah":
		if(isset($_POST['submit'])){
			//menggunakan class phpExcelReader
			include "pages/excel_reader.php"; 
						
			//membaca file excel yang diupload
			 $data = new Spreadsheet_Excel_Reader($_FILES['userfile']['tmp_name']);
			 //membaca jumlah baris dari data excel
			 $baris = $data->rowcount($sheet_index=0);

			//jika kosongkan data dicentang jalankan kode berikut
				if($_POST['drop']==1){
			//kosongkan tabel user_guru
					 $truncate ="TRUNCATE TABLE ujian_usukk";
					 mysql_query($truncate);
				}
				
			//nilai awal counter jumlah data yang sukses dan yang gagal diimport
			 $sukses = 0;
			 $gagal = 0;

			//import data excel dari baris kedua, karena baris pertama adalah nama kolom
			 for ($i=2; $i<=$baris; $i++) {
			 $txt1 = $data->val($i,2);
			 $txt2 = $data->val($i,3);
			 $txt3 = $data->val($i,4);
			 $txt4 = addslashes($data->val($i,5));
			 $txt5 = $data->val($i,6);
			 $txt6 = $data->val($i,7);
			 $txt7 = $data->val($i,8);
			 $txt8 = $data->val($i,9);
			 $txt9 = $data->val($i,10);
			 $txt10 = $data->val($i,11);
			 $txt11 = $data->val($i,12);
			 $txt12 = $data->val($i,13);
			 $txt13 = $data->val($i,14);
			 $txt14 = $data->val($i,15);
			 $txt15 = $data->val($i,16);
				
			//setelah data dibaca, sisipkan ke dalam tabel barang
			 $query = "INSERT INTO ujian_usukk values ('','$txt1','$txt2','$txt3','$txt4','$txt5','$txt6','$txt7','$txt8','$txt9','$txt10','$txt11','$txt12','$txt13','$txt14','$txt15')";
			 $hasil = mysql_query($query);
			 
			//menambah counter jika berhasil atau gagal
			 if($hasil) $sukses++;
			 else $gagal++;
			}
			 //tampilkan report hasil import
			echo '<div id="preloader"><div id="cssload"></div></div>';
			echo ns("Ngimpor","parent.location='?page=$page&sub=ngapload&aksi=data_ijazah'","Data Ijazah");		

			//echo InfoSimpan("Data Guru sukses di IMPOR!","parent.location='?page=$page'");
		}	

	break;	
}
echo '</div>';
include("inc/footer.php");
include("inc/scripts.php");
?>