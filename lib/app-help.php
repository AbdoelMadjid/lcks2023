<?php
/*
 07/07/2017 
Design and Programming By. Abdul Madjid, S.Pd., M.Pd.
SMK Negeri 1 Kadipaten
Pin 520543F3 HP. 0812-3000-0420
https://twitter.com/AbdoelMadjid 
https://www.facebook.com/abdulmadjid.mpd
*/
//eval(base64_decode("
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING | E_DEPRECATED));

//=================================================================[MASTER PENJELASAN]
		$ConstructionApp='<br><div class="text-center"><a href="javascript:void(0);" class="btn btn-default btn-circle btn-xl"><i class="fa fa-cog fa-spin fa-2x text-danger"></i></a><br><h1><h1><small class="text-danger slideInRight fast animated"><strong>Mohon Maaf !!!<br>Masih dalam proses SCRIPTING</strong></small></h1></div><br>';
	//--------[Label Modal]
		$LabelLCKS2013="
		<div class='row'>
			<div class='col-sm-12'>
			<div>
			<h1 style='padding-left:20px;'><span class='semi-bold'>LCKS</span> <i class='ultra-light'>SMK</i> <span class='hidden-mobile'>(Kurikulum 2013)</span> <sup class='badge bg-color-red bounceIn animated'>".$VersiApp."</sup> <br> <small class='text-danger slideInRight fast animated'><strong><span class='hidden-mobile'>Aplikasi</span> Laporan Capaian Kompetensi Siswa</strong></small></h1><hr class='simple'>
			</div>
			</div>
		</div>";
	//--------[Belum Ada Penjelasan]
		$BelumAdaPenjelasan='<br><div class="text-center"><a href="javascript:void(0);" class="btn btn-default btn-circle btn-xl"><i class="fa fa-cog fa-spin fa-2x text-danger"></i></a><br><h1><h1><small class="text-danger slideInRight fast animated"><strong><span class="hidden-mobile">Penjelasan.</span> Masih dalam proses Update</strong></small></h1></div><br>';
	//--------[Cukup Jelas]
		$CukupJelas.=FormModal("CukupJelas","LCKS-SMK K13",$LabelLCKS2013.'<br><div class="text-center"><a href="javascript:void(0);" class="btn btn-default btn-square btn-lg"><i class="fa fa-check-square-o fa-2x text-danger"></i></a><br><h1><h1><small class="text-danger slideInRight fast animated"><strong><span class="hidden-mobile">Penjelasan.</span> Cukup jelas.</strong></small></h1></div><br>');

//=================================================================[PROFIL]
	//--------[Profil Admin]
		$EditProfilAdmin.=FormModal("EditProfilAdmin","Profil Admin",$LabelLCKS2013."
		<br><br>
		<center>
		<img src='img/contactbg-student.png' width='200' height='223' border='0' alt=''><br><br><h1>CUKUP JELAS.</h1><br><br></center>");
		$SemuaAdmin.=FormModal("SemuaAdmin","Data Semua Administrator",$LabelLCKS2013.'
		<br><br>
		<center>
		<img src="img/contactbg-student.png" width="200" height="223" border="0" alt=""><br><br><h1>CUKUP JELAS.</h1><br><br></center>');
		$TambahAdmin.=FormModal("TambahAdmin","Tambah User Administrator",$LabelLCKS2013."
		<div style='padding:20px'>
			<table class='table'>
			<tr>
				<td>Nama Lengkap</td>
				<td>:</td>
				<td>Isi dengan nama lengkap</td>
			</tr>
			<tr>
				<td>Jenis Kelamin</td>
				<td>:</td>
				<td>Isi dengan Laki-laki atau Perempuan</td>
			</tr>
			<tr>
				<td>User ID</td>
				<td>:</td>
				<td>Tuliskan User ID</td>
			</tr>
			<tr>
				<td>Password</td>
				<td>:</td>
				<td>Tuliskan kata kunci</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			</table>
		</div>");
		$EditAdmin.=FormModal("EditAdmin","Edit User Administrator",$LabelLCKS2013."
		<div style='padding:20px'>
			<table class='table'>
			<tr>
				<td>Nama Lengkap</td>
				<td>:</td>
				<td>Isi dengan nama lengkap</td>
			</tr>
			<tr>
				<td>Jenis Kelamin</td>
				<td>:</td>
				<td>Isi dengan Laki-laki atau Perempuan</td>
			</tr>
			<tr>
				<td>User ID</td>
				<td>:</td>
				<td>Tuliskan User ID</td>
			</tr>
			<tr>
				<td>Password</td>
				<td>:</td>
				<td>Tuliskan kata kunci</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			</table>
		</div>");
	//--------[Profil Wali Kelas]
		$DataProfilWaliKelas.=FormModal("DataProfilWaliKelas","Profil Wali Kelas",$LabelLCKS2013."
		<div style='padding:20px'>
			<ul style='margin-left:-25px;text-align:justify;'>
			<li>Silakan ganti password wali kelas dengan tombol Edit Profil
			<li>Untuk perbaikan Nama Wali kelas Silakan hubungi Administrator
			</ul>
		</div>");
		$EditProfilWaliKelas.=FormModal("EditProfilWaliKelas","Edit Profil Wali Kelas",$LabelLCKS2013."
		<div style='padding:20px'>
			<ul style='margin-left:-25px;text-align:justify;'>
			<li>Untuk memperbaiki Nama dan Identitas Lain silakan masuk ke akun Guru/Tenaga Pendidik
			<li>Edit hanya di buka untuk mengganti Password Wali Kelas 
			<li>Sebaiknya silakan untuk mengganti password wali kelas
			</ul>
		</div>");

//=================================================================[TOOLS]
	//--------[opsi aplikasi]
		$OpsiAplikasi.=FormModal("OpsiAplikasi","Opsi Aplikasi",$LabelLCKS2013.'
		<div style="padding:20px">
			<h1><small class="text-danger slideInRight fast animated"><i class="fa fa-check-square fa-1x"></i> <strong>Under Construction</strong></small></h1>
			<hr class="simple">
			<div class="row">
				<div class="col-sm-6">
					<ul>
						<li>Silakan isi tanggal pada tanggal selesai, tanggal beberapa hari ke depan</li>
						<li>Pilih button aktif, agar Underconstruction ini aktif</li>
					</ul>
				</div>
				<div class="col-sm-6">
					Tampilan Aplikasi sedang perbaikan
					<img src="img/imgpenjelasan/countdown.jpg" width="200" height="223" border="0" alt="">
					<br><br>
				</div>
			</div>
			<hr class="simple">
			<h1><small class="text-danger slideInRight fast animated"><i class="fa fa-check-square fa-1x"></i> <strong>Jenis Nilai</strong></small></h1>
			<hr class="simple">
			<div class="row">
				<div class="col-sm-12">
					<div class="who clearfix">
						Fitur ini bisa di manfaatkan untuk proses cetak rapor dengan type pilihan penilaian yaitu SATUAN (1-4) atau PULUHAN (0-100)<br><br>
					</div>
				</div>
			</div>
			<hr class="simple">
			<h1><small class="text-danger slideInRight fast animated"><i class="fa fa-check-square fa-1x"></i> <strong>Belum Beres</strong></small></h1>
			<hr class="simple">
			<div class="row">
				<div class="col-sm-12">
					<div class="who clearfix">
						Fitur ini bisa di manfaatkan untuk tidak bisa di akses oleh GURU untuk GMP dan walikelas untuk WK, Ketika Fitur ini di buat non aktif, maka yang muncul hanya ada keterangan fitur ini tidak bisa diakses. <br><hr class="simple">
						Untuk menonaktifkan fitur silakan lakukan hal berikut<br>
						Klik di bagian <i class="fa fa-fw fa-square-o txt-color-blue"></i> untuk menonaktifkan fitur sehingga menjadi <i class="fa fa-fw fa-check-square-o txt-color-blue"></i>
						<br><br>
					</div>
				</div>
			</div>
			<hr class="simple">
			<h1><small class="text-danger slideInRight fast animated"><i class="fa fa-check-square fa-1x"></i> <strong>Informasi Aplikasi</strong></small></h1>
			<hr class="simple">
			<div class="row">
				<div style="padding:20px">
					<p>Fitur informasi ini untuk memberikan sebuah informasi atau ajakan yang akan muncul di bagian beranda dan di bagian informasi ketika aplikasi sedang proses off. </p>
					<p>Silakan untuk mengetik informasi di bagian Tambah Informasi kemudian simpan.</p> 
					<p><i class="fa fa-fw fa-check-square-o txt-color-blue"></i> Informasi di tampilkan</p> 
					<p><i class="fa fa-fw fa-square-o txt-color-blue"></i> Informasi tidak di tampilkan </p>
					<p>Silakan klik tombol tersebut untuk menampilkan atau tidak menampilkan informasi</p>	
					<p><i class="fa fa-fw fa-times-circle txt-color-red"></i> Untuk menghapus informasi</p>
					<p>Klik isi informasi untuk edit informasi.</p> 
				</div>	
			</div>
		</div>');
	//--------[backup database]
		$InfoBackupDB.=FormModal("InfoBackupDB","Backup DataBase",$LabelLCKS2013.'
		<div style="padding:20px">
			<p align="justify">Fitur backup database ini untuk menyimpan database dengan type file sql, file db ini akan tersimpan di folder root</p>
			<p align="justify">Silakan pilih salah satu atau beberapa tabel untuk di backup, atau pilih semua tabel untuk di backup
			Kemudian klik proses</p>
		</div>');
	//--------[upload data master]
		$UploadDataMaster.=FormModal("UploadDataMaster","Upload Data Master Dengan EXCEL",$LabelLCKS2013.'
		<div style="padding:20px">
			<ol style="margin-left:-25px;text-align:justify;">
				<li>Silakan download terlebih dahulu file excel master</li>
				<li>Isikan sesuai dengan contoh</li>
				<li>Silakan upload data dengan syarat data tidak boleh lebih dari 1000 baris dan type file Excel 2003-2007</li>
				<li>Beri checklist pada bagian hapus SQL, untuk menghapus seluruh data yang ada di database</li>
			</ol>
		</div>');
	//--------[download data master]
		$DownloadDataMaster.=FormModal("DownloadDataMaster","Download Data Master",$LabelLCKS2013.'
		<div style="padding:20px">
			<p style="text-indent:25px;text-align:justify;">Fitur ini untuk mendownload seluruh data master, dengan hasil format file excel. Setelah di download silakan save as dengan type file xls atau xlsx, karena hasil download masih bertype web</p>
		</div>');
	//--------[Versi Kurikulum]
		$KetVersiKurikulum.=FormModal("KetVersiKurikulum","Versi Kurikulum",$LabelLCKS2013."
		<div style='padding:20px'>
			<table class='table'>
			<tr>
				<td width='30%'>Tambah Data</td>
				<td>:</td>
				<td>Menambah versi kurikulum</td>
			</tr>
			<tr>
				<td>Aksi Edit</td>
				<td>:</td>
				<td><i class='fa fa-pencil-square-o txt-color-blue fa-2x'></i> Merubah data versi kurikulum</td>
			</tr>
			<tr>
				<td>Aksi Hapus</td>
				<td>:</td>
				<td><i class='fa fa-trash-o txt-color-red fa-2x'></i> Menghapus data versi kurikulum</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			</table>
		</div>");
	//--------[Informasi]
		$KetInformasi.=FormModal("KetInformasi","Informasi/Pengumuman",$LabelLCKS2013."
		<div style='padding:20px'>
			<table class='table'>
			<tr>
				<td></td>
				<td width='30%'><i class='fa fa-plus txt-color-red'></i> Tambah Informasi </td>
				<td>:</td>
				<td>Menambah Informasi</td>
			</tr>
			<tr>
				<td><i class='fa fa-square-o txt-color-red fa-2x'></i> </td>
				<td>Aktifkan</td>
				<td>:</td>
				<td>Aktifkan data Informasi</td>
			</tr>
			<tr>
				<td><i class='fa fa-check-square-o txt-color-red fa-2x'></i> </td>
				<td>Non Aktifkan</td>
				<td>:</td>
				<td>Non Aktifkan data Informasi</td>
			</tr>
			<tr>
				<td><i class='fa fa-pencil-square-o txt-color-blue fa-2x'></i></td>
				<td>Aksi Edit</td>
				<td>:</td>
				<td>Merubah data Informasi</td>
			</tr>
			<tr>
				<td><i class='fa fa-trash-o txt-color-red fa-2x'></i></td>
				<td>Aksi Hapus</td>
				<td>:</td>
				<td>Menghapus data Informasi</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			</table>
		</div>");
//=================================================================[KURIKULUM]
	//--------[download data master]
		$NgunciDataNilai.=FormModal("NgunciDataNilai","Kunci Data Nilai KBM",$LabelLCKS2013."
		<div style='padding:20px'>
			<p style='text-indent:25px;text-align:justify;'>Fitur ini untuk mengunci Nilai yang sudah di input oleh Guru, Agar tidak ada perubahan ketika rapor sudah naik cetak, Perubahan hanya bisa di lakukan oleh Pihak Administrator atau Kurikulum</p>
			<p style='text-indent:25px;text-align:justify;'>Untuk mengunci KBM atau merubahnya menjadi terbuka atau terkunci, silakan pilih tahun ajaran dan semester, maka akan muncul tombol sesuai dengan kebutuhan</p>
			<ul style='margin-left:-25px;text-align:justify;'>
			<li>Pertama kali membuat kuncian terhadap kbm, muncul tombol <strong>simpan</strong></li> 
			<li>Untuk membuka kuncian, muncul tombol <strong>buka kunci</strong></li>
			<li>Untuk mengunci kembali, muncul tombol <strong>kunci</strong></li>
			</ul>
		</div>");
		$CheckDataKBM.=FormModal("CheckDataKBM","Cek Data KBM",$LabelLCKS2013.'
		<div style="padding:20px">
			<table class="table">
			<tr>
				<td width="150">Pilih Data</td>
				<td>:</td>
				<td>Silakan pilih data, data pilihan ada 2 jenis yaitu Data Guru dan Data Kelas</td>
			</tr>
			<tr>
				<td width="150">Data Terpilih</td>
				<td>:</td>
				<td>Jika sudah terpilih, silakan klik tombol <button class="btn btn-default text-color-blue btn-md"><i class="fa fa-question"></i></button> untuk penjelasan masing-masing</td>
			</tr>
			<tr>
				<td width="150">Tombol Input KBM</td>
				<td>:</td>
				<td>Untuk menambahkan seluruh KBM Per Kelas</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			</table>
		</div>');
		$KBMPerKelas.=FormModal("KBMPerKelas","KBM Per Kelas",$LabelLCKS2013.'
		<div style="padding:20px">
			<table class="table">
			<tr>
				<td width="125">Kelas</td>
				<td>:</td>
				<td>Klik nama kelas untuk melihat data KBM</td>
			</tr>
			<tr>
				<td width="125">Jumlah</td>
				<td>:</td>
				<td>Jumlah Mata Pelajaran yang sudah masuk KBM</td>
			</tr>
			<tr>
				<td width="125">Leger</td>
				<td>:</td>
				<td>
					<ul style="margin-left:-25px;text-align:justify;">
					<li><i class="fa fa-external-link fa-border"></i> Generate Leger <span class="txt-color-red">(Hilang setelah generate di proses)</span></li> 
					<li><i class="fa fa-download fa-border"></i> Download Leger Nilai</li> 
					<li><i class="fa fa-eye fa-border"></i> Review Leger Nilai</li> 
					</ul>
				</td>
			</tr>
			<tr>
				<td width="125">Absensi</td>
				<td>:</td>
				<td>
					<ul style="margin-left:-25px;text-align:justify;">
					<li><i class="fa fa-download fa-border"></i> Download Absensi</li> 
					<li><i class="fa fa-print fa-border"></i> Cetak Absensi</li> 
					</ul>
				</td>
			</tr>
			<tr>
				<td width="125">Peringkat</td>
				<td>:</td>
				<td>
					<ul style="margin-left:-25px;text-align:justify;">
					<li><i class="fa fa-external-link fa-border"></i> Generate Peringkat <span class="txt-color-red">(Lakukan generate ulang jika ada perubahan Nilai dari Guru)</span></li> 
					<li><i class="fa fa-download fa-border"></i> Download peringkat</li> 
					<li><i class="fa fa-print fa-border"></i> Cetak Peringkat</li> 
					</ul>
				</td>
			</tr>
			<tr>
				<td width="125">R2P R2K R2N</td>
				<td>:</td>
				<td>Nilai akan muncul jika sudah melakukan Generate Peringkat</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			</table>
		</div>');
		$KBMPerGuru.=FormModal("KBMPerGuru","KBM Per Guru",$LabelLCKS2013.'
		<div style="padding:20px">
			<table class="table">
			<tr>
				<td width="125">Nama Pengajar</td>
				<td>:</td>
				<td>Klik nama pengajar untuk melihat data KBM</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			</table>
		</div>');
		$DetailKBMPerKelas.=FormModal("DetailKBMPerKelas","Detail KBM Per Kelas",$LabelLCKS2013.'
		<div style="padding:20px">
		<h4>Tombol</h4>
			<table class="table">
			<tr>
				<td width="125"><button class="btn btn-warning btn-xs"> Upload </button></td>
				<td>:</td>
				<td>Uload Nilai sesuai dengan jenis Penilaian pada tahun ajaran dan semester terpilih</td>
			</tr>
			<tr>
				<td width="125"><button class="btn btn-danger btn-xs"> Hapus </button></td>
				<td>:</td>
				<td>Menghapus Data Nilai sesuai dengan jenis Penilaian pada tahun ajaran dan semester terpilih</td>
			</tr>
			<!-- <tr>
				<td width="125"><button class="btn btn-success btn-xs"> Leger </button></td>
				<td>:</td>
				<td>Generate leger per kelas</td>
			</tr> -->
			<tr>
				<td width="125"><button class="btn btn-info btn-xs"> Download </button></td>
				<td>:</td>
				<td>Download Data Nilai sesuai dengan jenis Penilaian pada tahun ajaran dan semester terpilih</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			</table>
			<h4>Keterangan Tabel</h4>
			<table class="table">
			<tr>
				<td width="125">A. Guru Mata Pelajaran</td>
				<td>:</td>
				<td>Seluruh data Pengajar pada Kelas Terpilih pada Tahun Ajaran dan Semester terpilih</td>
			</tr>
			<tr>
				<td width="125">B. Perolehan Nilai</td>
				<td>:</td>
				<td>Nilai yang telah di input oleh Guru Mata Pelajaran di sesuaikan dengan perolehan nilai siswa</td>
			</tr>
			<tr>
				<td width="125">C. Absensi Siswa</td>
				<td>:</td>
				<td>Total Absensi Siswa yang di input oleh Guru Mata Pelajaran pada Tahun Ajaran dan Semester terpilih</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			</table>
		</div>');

//=================================================================[AKADEMIK]
	//--------[Tahun Ajaran]
		$DataTA.=FormModal("DataTA","Tahun Ajaran dan Semester",$LabelLCKS2013."
		<div style='padding:20px'>
			<ul style='margin-left:-25px;text-align:justify;'>
			<li>Klik tahun ajaran dan semester yang sedang berlangsung
			<li>Tambahkan tahun ajaran jika belum ada di list tahun ajaran 
			</ul>
		</div>");
	//--------[Paket Keahlian]
		$DataPK.=FormModal("DataPK","Daftar Paket Keahlian",$LabelLCKS2013."
		<div style='padding:20px'>
			<ul style='margin-left:-25px;text-align:justify;'>
			<li>Daftar Paket Keahlian yang ada di sekolah
			<li>Silakan tambahkan paket keahlian jika belum ada di list Paket Keahlian, dengan menekan tombol di bagian kanan atas
			<li>Untuk edit paket keahlian silakan klik nama paket keahlian
			</ul>
		</div>");
		$TambahPK.=FormModal("TambahPK","Tambah Paket Keahlian",$LabelLCKS2013."
		<div style='padding:20px'>
			<table class='table'>
			<tr>
				<td width='125'>Kode Paket</td>
				<td>:</td>
				<td>Harus angka sebanyak 4 angka</td>
			</tr>
			<tr>
				<td>Bidang Keahlian</td>
				<td>:</td>
				<td>Pilih Bidang Keahlian sesuai yang ada di sekolah, kemudian akan muncul Pilihan Program Keahlian sesuai dengan pilihan Bidang Keahlian</td>
			</tr>
			<tr>
				<td>Program Keahlian</td>
				<td>:</td>
				<td>Pilih Program Keahlian sesuai dengan pilihan Bidang Keahlian</td>
			</tr>
			<tr>
				<td>Paket Keahlian</td>
				<td>:</td>
				<td>Tuliskan Paket Keahlian Lengkap</td>
			</tr>
			<tr>
				<td>Singkatan</td>
				<td>:</td>
				<td>Singkatan ini akan di gunakan untuk penamaan kelas</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			</table>
		</div>");
		$EditPK.=FormModal("EditPK","Edit Paket Keahlian",$LabelLCKS2013."
		<br><br>
		<center>
		<img src='img/contactbg-student.png' width='200' height='223' border='0' alt=''><br><br><h1>CUKUP JELAS.</h1>SILAKAN CEK PENJELASAN TAMBAH PAKET KEAHLIAN<br><br></center>");
	//--------[Tenaga Pendidik]
		$DataPTK.=FormModal("DataPTK","Daftar Tenaga Pendidik",$LabelLCKS2013."
		<div style='padding:20px'>
			<ul style='margin-left:-25px;text-align:justify;'>
			<li>Silakan tambahkan tenaga pendidik dengan menekan tombol di sebelah kanan atas
			<li>Jika ingin upload seluruh data tenaga pendidik, silakan ke menu <code>Tools -> Impor -> Tenaga Pendidik</code>
			<li>Silakan pilih jenis guru Umum, Produktif atau BP/BK
			<li>Kombinasikan dengan pilihan jenis kelamin, maka akan terfilter sesuai dengan pilihan Jenis Guru dan Jenis Kelamin 
			<li>Untuk edit data guru silakan klik Nama Guru 
			</ul>
		</div>");
		$TambahPTK.=FormModal("TambahPTK","Tambah Tenaga Pendidik",$LabelLCKS2013."
		<div style='padding:20px'>
			<table class='table'>
			<tr>
				<td width='20%'>NIP</td>
				<td>:</td>
				<td>Isi dengan Nomor Induk Pegawai, jika honor beri tanda - (minus)</td>
			</tr>
			<tr>
				<td>Nama Lengkap</td>
				<td>:</td>
				<td>Sertakan Gelar Depan dan Belakang, disarankan Nama meggunakan huruf KAPITAL</td>
			</tr>
			<tr>
				<td>User ID</td>
				<td>:</td>
				<td>Identitas Username untuk mengakses Data KBM guru bersangkutan</td>
			</tr>
			<tr>
				<td>Password</td>
				<td>:</td>
				<td>Kata kunci untuk mengakses Data KBM guru bersangkutan</td>
			</tr>
			<tr>
				<td>Level User</td>
				<td>:</td>
				<td>Memiliki pilihan level user Kepala Sekolah dan Guru</td>
			</tr>
			<tr>
				<td>Jenis Kelamin</td>
				<td>:</td>
				<td>Pilih Laki-laki atau Perempuan</td>
			</tr>
			<tr>
				<td>Jenis Guru</td>
				<td>:</td>
				<td>Pilih Jenis Guru Umum, Produktif, atau BP/BK</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			</table>
		</div>");
		
		$EditPTK.=FormModal("EditPTK","Edit Tenaga Pendidik",$LabelLCKS2013."
		<br><br>
		<center>
		<img src='img/contactbg-student.png' width='200' height='223' border='0' alt=''><br><br><h1>CUKUP JELAS.</h1>SILAKAN CEK PENJELASAN TAMBAH TENAGA PENDIDIK<br><br></center>");
	//--------[Mata Pelajaran]
		$DataMP.=FormModal("DataMP","Daftar Mata Pelajaran",$LabelLCKS2013."
		<div style='padding:20px'>
			<ul style='margin-left:-25px;text-align:justify;'>
			<li>Buatlah Mata Pelajaran di setiap Paket Keahlian walau Mata Pelajaran tersebut sama, seperti Mata Pelajaran Pendidikan Agama dan Budi Pekerti harus ada di setiap Paket Keahlian, di karenakan kode mapelnya akan berbeda
			<li>Silakan tambahkan mata pelajaran untuk setiap Paket Keahlian di tombol Tambah Mata Pelajaran
			<li>Untuk edit mata pelajaran silakan klik nama mata pelajaran
			<li>Untuk memfilter mata pelajaran silakan pilih pilihan Paket Keahlian dan Kelompok Mapel (A, B, C1, C2, C3 dan M)
			</ul>
			<table class='table'>
			<tr>
				<td width='40%'>Semester 1 - 6</td>
				<td>:</td>
				<td>Tanda <i class='ace-icon blue fa fa-circle bigger-150'></i> artinya mata pelajaran tersebut TIDAK ADA pada semester tersebut, dan tanda <i class='ace-icon blue fa fa-check-circle bigger-150'></i> artinya mata pelajaran tersebut ADA pada semester tersebut</td>
			</tr>
			<tr>
				<td>Merubah Ada/Tidak Ada<br> Mata Pelajaran</td>
				<td>:</td>
				<td>Klik <i class='ace-icon blue fa fa-circle bigger-150'></i> untuk memberi tanda bahwa mata pelajaran itu ADA pada semester tersebut, dan klik <i class='ace-icon blue fa fa-check-circle bigger-150'></i> untuk membatalkan</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			</table>
		</div>");
		
		$TambahMP.=FormModal("TambahMP","Tambah Mata Pelajaran",$LabelLCKS2013.
		"<div style='padding:20px'>
			<h1><small class='text-danger slideInRight fast animated'><i class='fa fa-check-square fa-1x'></i> <strong>Identitas Mata Pelajaran</strong></small></h1>
			<table class='table'>
			<tr>
				<td width='40%'>Kode Mata Pelajaran</td>
				<td>:</td>
				<td>Otomatis menggabungkan dari Pilihan Paket Keahlian, Kelompok Mapel, dan Nomor Urut Kelompok Mata Pelajaran</td>
			</tr>
			<tr>
				<td>Paket Keahlian</td>
				<td>:</td>
				<td>Pilih Paket Keahlian yang sudah di input pada menu Paket Keahlian</td>
			</tr>
			<tr>
				<td>Kelompok</td>
				<td>:</td>
				<td>Pilih Kelompok Mata Pelajaran A, B, C1, C2, C3, C4 dan M (Mulok)</td>
			</tr>
			<tr>
				<td>No. Urut Mapel dalam Kelompok</td>
				<td>:</td>
				<td>Isi urutan Mapel sesuai dengan Pilihan Kelompok</td>
			</tr>
			<tr>
				<td>Kelompok Mata Pelajaran</td>
				<td>:</td>
				<td>Otomatis terisi sesuai dengan pilihan Kelompok dan No. Urut Mapel dalam Kelompok</td>
			</tr>
			<tr>
				<td>Mata Pelajaran</td>
				<td>:</td>
				<td>Isi Nama Mata Pelajaran di sesuaikan dengan Struktur Kurikulum</td>
			</tr>
			<tr>
				<td>Jenis Mata Pelajaran</td>
				<td>:</td>
				<td>Isi dengan MPU untuk mata pelajaran yang termasuk pada kelompok A dan B, untuk kelompok C1 dan C2 namai sesuai dengan Bidang Keahlian sedangkan untuk mata pelajaran kelompok C3 dan C4 isi dengan nama singkatan Paket Keahlian</td>
			</tr>
			</table>
			<h1><small class='text-danger slideInRight fast animated'><i class='fa fa-check-square fa-1x'></i> <strong>Ada Tidaknya Mata Pelajaran</strong></small></h1>
			<table class='table'>
			<tr>
				<td width='20%'>Semester 1 - 6</td>
				<td>:</td>
				<td>Pilih ADA atau TIDAK ada pada masing-masing Semester</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			</table>
		</div>");
		
		$EditMP.=FormModal("EditMP","Edit Mata Pelajaran",$LabelLCKS2013."
		<br><br>
		<center>
		<img src='img/contactbg-student.png' width='200' height='223' border='0' alt=''><br><br><h1>CUKUP JELAS.</h1>SILAKAN CEK PENJELASAN TAMBAH MATA PELAJARAN<br><br></center>");
	//--------[KIKD]
		$DataKIKD.=FormModal("DataKIKD","Daftar KIKD",$LabelLCKS2013."
		<div style='padding:20px'>
			<table class='table'>
			<tr>
				<td width='30%'>Jenis Mata Pelajaran</td>
				<td>:</td>
				<td>Pilih jenis mata pelajaran sesuai dengan jenis mata pelajaran yang di inputkan pada menu Mata Pelajaran</td>
			</tr>
			<tr>
				<td>Mata Pelajaran</td>
				<td>:</td>
				<td>Pilihan Nama Mata Pelajaran</td>
			</tr>
			<tr>
				<td>Tingkat</td>
				<td>:</td>
				<td>Pilihan Tingkat KIKD Mata Pelajaran</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			</table>
		</div>");
		$TambahKIKD.=FormModal("TambahKIKD","Tambah KIKD",$LabelLCKS2013."
		<div style='padding:20px'>
			<table class='table'>
			<tr>
				<td width='30%'>Paket Keahlian</td>
				<td>:</td>
				<td>Pilih Paket Keahlian sesuai dengan KIKD, maka akan muncul Mata Pelajaran sesuai pilihan Paket Keahlian</td>
			</tr>
			<tr>
				<td>Mata Pelajaran</td>
				<td>:</td>
				<td>Pilihan Mata Pelajaran, maka akan muncul keterangan Jenis Mapel dan Kelompok Mapel</td>
			</tr>
			<tr>
				<td>Tingkat</td>
				<td>:</td>
				<td>Pilihan Tingkat Kelas</td>
			</tr>
			<tr>
				<td>Kode Ranah</td>
				<td>:</td>
				<td>Pilihan Kode Ranah KIKD : <br> KDS : Kompetensi Dasar Sikap, <br> KDP : Kompetensi Dasar Pengetahuan dan <br> KDK : Kompetensi Dasar Keterampilan</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			</table>
		</div>");
		$EditKIKD.=FormModal("EditKIKD","Edit KIKD",$LabelLCKS2013."
		<br><br>
		<center>
		<img src='img/contactbg-student.png' width='200' height='223' border='0' alt=''><br><br><h1>CUKUP JELAS.</h1>SILAKAN CEK PENJELASAN TAMBAH KIKD<br><br></center>");
	//--------[Kelas]
		$DataKelas.=FormModal("DataKelas","Daftar Kelas",$LabelLCKS2013."
		<div style='padding:20px'>
			<table class='table'>
			<tr>
				<td width='30%'>Pilihan Tahun Ajaran</td>
				<td>:</td>
				<td>Daftar Kelas pertama kali muncul adalah data kelas Tahun Ajaran yang sedang berlangsung. <br>Silakan Pilih Tahun Ajaran untuk melihat data kelas per Tahun Ajaran</td>
			</tr>
			<tr>
				<td>Edit Kelas</td>
				<td>:</td>
				<td>Klik Kode Kelas untk Edit Kelas dan Wali Kelas</td>
			</tr>
			<tr>
				<td>Tambah Kelas</td>
				<td>:</td>
				<td>Klik Tambah Kelas untuk menambah Kelas dan Nama Wali Kelas</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			</table>
		</div>");
		$TambahKelas.=FormModal("TambahKelas","Tambah Kelas",$LabelLCKS2013."
		<div style='padding:20px'>
			<table class='table'>
			<tr>
				<td width='35%'>Kode Kelas</td>
				<td>:</td>
				<td>Otomatis Terisi jika memilih tahun masuk, paket keahlian, tingkat dan pararel</td>
			</tr>
			<tr>
				<td>Kelas</td>
				<td>:</td>
				<td>Otomatis terisi jika memilih paket keahlian, tingkat dan pararel</td>
			</tr>
			<tr>
				<td>Tahun Ajaran</td>
				<td>:</td>
				<td>Pilih tahun ajaran sesuai kelas yang akan di buat</td>
			</tr>
			<tr>
				<td>Paket Keahlian</td>
				<td>:</td>
				<td>Pilih paket keahlian sesuai dengan kelas yang akan di buat</td>
			</tr>
			<tr>
				<td>Tahun Masuk</td>
				<td>:</td>
				<td>Pilih tahun masuk untuk kelas sesuai dengan siswa berdasarkan tahun masuk</td>
			</tr>
			<tr>
				<td>Tingkat</td>
				<td>:</td>
				<td>Pilih tingkat sesuai dengan kelas yang akan di buat</td>
			</tr>
			<tr>
				<td>Pararel</td>
				<td>:</td>
				<td>Pilih pararel sesuai dengan kelas yang akan di buat</td>
			</tr>
			<tr>
				<td>Wali Kelas</td>
				<td>:</td>
				<td>Pilih nama guru untuk wali kelas</td>
			</tr>
			<tr>
				<td>User WK dan Password WK</td>
				<td>:</td>
				<td>Otomatis terisi untuk Usernam dan Password Wali Kelas</td>
			</tr>
			<tr>
				<td>Singkatan</td>
				<td>:</td>
				<td>Otomatis muncul jika memilih paket keahlian</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			</table>
		</div>");
		$EditKelas.=FormModal("EditKelas","Edit Kelas dan Wali Kelas",$LabelLCKS2013."
		<br><br>
		<center>
		<img src='img/contactbg-student.png' width='200' height='223' border='0' alt=''><br><br><h1>CUKUP JELAS.</h1>SILAKAN CEK PENJELASAN TAMBAH KELAS<br><br></center>");
	//--------[User Wali kelas]
		$DataUserWK.=FormModal("DataUserWK","Daftar Kelas",$LabelLCKS2013."
		<div style='padding:20px'>
			<table class='table'>
			<tr>
				<td width='30%'>Pilihan Tahun Ajaran</td>
				<td>:</td>
				<td>Daftar Kelas pertama kali muncul adalah data Username dan Password Wali kelas Tahun Ajaran yang sedang berlangsung. <br>Silakan Pilih Tahun Ajaran untuk melihat data username dan passwrod wali kelas kelas per Tahun Ajaran</td>
			</tr>
			<tr>
				<td>Edit Kelas</td>
				<td>:</td>
				<td>Klik Kode Kelas untk Edit Password Wali Kelas</td>
			</tr>
			<tr>
				<td>Informasi</td>
				<td>:</td>
				<td>Data username dan passwrod wali kelas ini muncul sesuai dengan penambahan kelas di Menu Kelas, jika kelas di hapus maka secara otomatis data username dan password wali kelas akan terhapus</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			</table>
		</div>");
		$EditUserWK.=FormModal("EditUserWK","Edit Password Wali Kelas",$LabelLCKS2013."
		<div style='padding:20px'>
			<table class='table'>
			<tr>
				<td width='30%'>Informasi</td>
				<td>:</td>
				<td>Pada fitur ini hanya di beri kesempatan untuk merubah password Wali kelas</td>
			</tr>
			<tr>
				<td>Ganti Nama Wali Kelas</td>
				<td>:</td>
				<td>Untuk mengganti nama wali kelas, silakan ke menu kelas</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			</table>
		</div>");
	//--------[Peserta Didik]
		$DataPD.=FormModal("DataPD","Daftar Peserta Didik",$LabelLCKS2013."
		<div style='padding:20px'>
			<table class='table'>
			<tr>
				<td width='30%'>Pilihan Tahun Masuk</td>
				<td>:</td>
				<td>Pilih tahun masuk, maka akan muncul semua siswa sesuai dengan tahun masuk</td>
			</tr>
			<tr>
				<td>Pilih Paket Keahlian</td>
				<td>:</td>
				<td>Pilih paket keahlian akan muncul semua siswa sesuai dengan paket keahlian</td>
			</tr>
			<tr>
				<td>Informasi</td>
				<td>:</td>
				<td>Kombinasi pilihan, jika kedua pilihan yaitu tahun masuk dan paket keahlian, maka akan muncul data siswa sesuai dengan pilihan tahun masuk dan paket keahlian, jika salah satu baik tahun masuk maupun paket keahlian, maka muncul data siswa sesuai dengan pilihan tahun masuk ATAU paket keahlian</td>
			</tr>
			<tr>
				<td>Edit Biodata Siswa</td>
				<td>:</td>
				<td>Klik nama siswa untuk edit biodata siswa</td>
			</tr>
			<tr>
				<td>Hapus Biodata Siswa</td>
				<td>:</td>
				<td>Klik tombol <i class='txt-color-red fa fa-trash-o'></i> untuk menghapus biodata siswa</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			</table>
		</div>");
		$TambahPD.=FormModal("TambahPD","Tambah Peserta Didik",$LabelLCKS2013."
		<div style='padding:20px'>
			<h1><small class='text-danger slideInRight fast animated'><i class='fa fa-check-square fa-1x'></i> <strong>Biodata Siswa</strong></small></h1>
			<table class='table'>
			<tr>
				<td width='30%'>NIS</td>
				<td>:</td>
				<td>Isi dengan Nomor Induk Siswa (tidak boleh pakai spasi atau simbol)</td>
			</tr>
			<tr>
				<td>NISN</td>
				<td>:</td>
				<td>Isi dengan Nomor Indus Siswa Nasional, jika belum ada silakan isi dengan tanda minus (-)</td>
			</tr>
			<tr>
				<td>Tahun Masuk</td>
				<td>:</td>
				<td>Pilih tahun masuk siswa</td>
			</tr>
			<tr>
				<td>Paket Keahlian</td>
				<td>:</td>
				<td>Pilih Paket Keahlian</td>
			</tr>
			<tr>
				<td>Nama</td>
				<td>:</td>
				<td>Isi nama dengan nama lengkap siswa, jika ada tanda kutip satu maka tambahkan slash di belakang tanda kutip satu. Contoh RENI NUR/'ASIH</td>
			</tr>
			<tr>
				<td>Tempat Lahir</td>
				<td>:</td>
				<td>Isi dengan tempat lahir sesuai dengan Ijazah SMP/MTs atau Akta Lahir</td>
			</tr>
			<tr>
				<td>Tanggal Lahir</td>
				<td>:</td>
				<td>Isi dengan tanggal lahir sesuai dengan ijazah SMP</td>
			</tr>
			<tr>
				<td>Jenis Kelamin</td>
				<td>:</td>
				<td>Pilih jenis kelamin siswa</td>
			</tr>
			<tr>
				<td>Agama</td>
				<td>:</td>
				<td>Pilih Agama Islam, Katolik, Protestan, Advent, Hindu, Budha, Konghucu</td>
			</tr>
			<tr>
				<td>Status dalam Keluarga</td>
				<td>:</td>
				<td>Pilih status dalam keluarga siswa, Anak Kandung, Anak Tiri, Anak Angkat</td>
			</tr>
			<tr>
				<td>Anak Ke</td>
				<td>:</td>
				<td>Pilih urutan anak ke siswa</td>
			</tr>
			<tr>
				<td>Telepon</td>
				<td>:</td>
				<td>Isi dengan Telepon/HP Aktif Siswa</td>
			</tr>
			<tr>
				<td>Sekolah Asal SMP/MTS</td>
				<td>:</td>
				<td>Isi dengan nama sekolah asal siswa</td>
			</tr>
			<tr>
				<td>Di Terima di kelas</td>
				<td>:</td>
				<td>Isi di terima di kelas X, XI atau XII sesuai dengan masuknya siswa ke sekolah</td>
			</tr>
			<tr>
				<td>Tanggal Diterima</td>
				<td>:</td>
				<td>Isi dengan tanggal penerimaan Siswa</td>
			</tr>
			<tr>
				<td>Asal Siswa</td>
				<td>:</td>
				<td>Pilih Siswa Baru atau Pindahan</td>
			</tr>
			<tr>
				<td>Alasan Pindahan</td>
				<td>:</td>
				<td>Jika asal siswa Pindahan tuliskan alasan kepindahan</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			</table>
			<h1><small class='text-danger slideInRight fast animated'><i class='fa fa-check-square fa-1x'></i> <strong>Alamat Siswa</strong></small></h1>
			<table class='table'>
			<tr>
				<td width='30%'>Blok/Dusun</td>
				<td>:</td>
				<td>Isi dengan Blok/Dusun atau Jalan</td>
			</tr>
			<tr>
				<td>Nomor</td>
				<td>:</td>
				<td>Isi dengan nomor rumah siswa</td>
			</tr>
			<tr>
				<td>RT</td>
				<td>:</td>
				<td>Isi dengan RT alamat rumah siswa</td>
			</tr>
			<tr>
				<td>RW</td>
				<td>:</td>
				<td>Isi dengan RW alamat rumah siswa</td>
			</tr>
			<tr>
				<td>Desa</td>
				<td>:</td>
				<td>Isi nama desa alamat rumah siswa</td>
			</tr>
			<tr>
				<td>Kecamatan</td>
				<td>:</td>
				<td>Isi nama kecamatan alamat rumah siswa</td>
			</tr>
			<tr>
				<td>Kabupaten</td>
				<td>:</td>
				<td>Isi nama kabupaten alamat rumah siswa</td>
			</tr>
			<tr>
				<td>Kode Pos</td>
				<td>:</td>
				<td>Isi dengan kode pos alamat rumah siswa</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			</table>
			<h1><small class='text-danger slideInRight fast animated'><i class='fa fa-check-square fa-1x'></i> <strong>Biodata Orang Tua</strong></small></h1>
			<table class='table'>
			<tr>
				<td width='30%'>Nama Ayah</td>
				<td>:</td>
				<td>Isi nama ayah sesuai dengan Akta Lahir atau Kartu Keluarga</td>
			</tr>
			<tr>
				<td>Nama Ibu</td>
				<td>:</td>
				<td>Isi nama ibu sesuai dengan Akta Lahir atau Kartu Keluarga</td>
			</tr>
			<tr>
				<td>Pekerjaan Ayah</td>
				<td>:</td>
				<td>Pilih pekerjaan ayah, jika tidak ada di pilihan silakan pilih Lainnya</td>
			</tr>
			<tr>
				<td>Pekerjaan Ibu</td>
				<td>:</td>
				<td>Pilih pekerjaan ibu, jika tidak ada di pilihan silakan pilih Lainnya</td>
			</tr>
			<tr>
				<td>Telepon</td>
				<td>:</td>
				<td>Isi dengan nomor telepon ayah atau yang aktif atau nomor telp rumah</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			</table>
			<h1><small class='text-danger slideInRight fast animated'><i class='fa fa-check-square fa-1x'></i> <strong>Alamat Orang Tua</strong></small></h1>
			<table class='table'>
			<tr>
				<td width='30%'>Informasi</td>
				<td>:</td>
				<td>Jika alamat orang tua sama dengan alamat siswa silakan klik tombol YA<br>Jika beda alamatnya silakan isi alamat orang tua, keterangan cek pada keterangan alamat siswa</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			</table>
			<h1><small class='text-danger slideInRight fast animated'><i class='fa fa-check-square fa-1x'></i> <strong>Biodata Wali Siswa</strong></small></h1>
			<table class='table'>
			<tr>
				<td width='30%'>Informasi</td>
				<td>:</td>
				<td>Jika siswa memiliki Wali silakan lengkapi biodata wali siswa<br>Keterangan biodata wali siswa silakan baca keterangan Biodata Orang Tua</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			</table>
			<h1><small class='text-danger slideInRight fast animated'><i class='fa fa-check-square fa-1x'></i> <strong>Alamat Wali Siswa</strong></small></h1>
			<table class='table'>
			<tr>
				<td width='30%'>Informasi</td>
				<td>:</td>
				<td>Jika alamat orang tua sama dengan alamat siswa silakan klik tombol YA<br>Jika beda alamatnya silakan isi alamat wali siswa, keterangan cek pada keterangan alamat siswa</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			</table>
		</div>");
		$EditPD.=FormModal("EditPD","Edit Biodata Peserta Didik",$LabelLCKS2013."
		<br><br>
		<center>
		<img src='img/contactbg-student.png' width='200' height='223' border='0' alt=''><br><br><h1>CUKUP JELAS.</h1>SILAKAN CEK PENJELASAN TAMBAH PESERTA DIDIK<br><br></center>");
	//--------[Per Kelas]
		$DtPKelas.=FormModal("DtPKelas","Data Siswa Per Kelas",$LabelLCKS2013."
		<div style='padding:20px'>
			<ul style='margin-left:-25px;text-align:justify;'>
				<li>Pilih Tahun Pelajaran untuk melihat data siswa per kelas
				<li>Silakan klik MENU PILIHAN di bagian pojok kanan atas untuk proses kenaikan kelas dan memberi kelas baru untuk siswa baru 
				<li>Untuk melihat daftar siswa perkelas, silakan untuk klik nama kelas
				<li>Untuk melihat daftar siswa pertingkat, silakan untuk klik Total Kelas	
			</ul>
		</div>");
		$KelasBaruUntukSiswaBaru.=FormModal("KelasBaruUntukSiswaBaru","Masukan Siswa Baru ke Kelas",$LabelLCKS2013."
		<div style='padding:20px'>
		<h4><span class='txt-color-red'><strong>PENJELASAN</strong> </span><strong><em>Belum Ada</em> !!!</strong></h4>
		</div>");
		$SimpanKelasBaru.=FormModal("SimpanKelasBaru","Simpan Kelas Baru Untuk Siswa Baru",$LabelLCKS2013."
		<div style='padding:20px'>
		<h4><span class='txt-color-red'><strong>PENJELASAN</strong> </span><strong><em>Belum Ada</em> !!!</strong></h4>
		</div>");
		$NaikKelasSiswaLama.=FormModal("NaikKelasSiswaLama","Naik Kelas Siswa Lama",$LabelLCKS2013."
		<div style='padding:20px'>
		<h4><span class='txt-color-red'><strong>PENJELASAN</strong> </span><strong><em>Belum Ada</em> !!!</strong></h4>
		</div>");
		$SiswaPindahKelas.=FormModal("SiswaPindahKelas","Pindah Kelas",$LabelLCKS2013."
		<div style='padding:20px'>
		<h4><span class='txt-color-red'><strong>PENJELASAN</strong> </span><strong><em>Belum Ada</em> !!!</strong></h4>
		</div>");

//=================================================================[GURU]
	//--------[Pilih Data] - ADMINISTRATOR
		$GMPPilihData.=FormModal("GMPPilihData","Pilih Data KBM",$LabelLCKS2013."
		<div style='padding:20px'>
			<table class='table'>
			<tr>
				<td width='30%'>Pilih Data</td>
				<td>:</td>
				<td>Pilihan data ada 2 pilihan yang Guru atau Kelas. Jika memilih data Guru akan muncul Pilihan Nama Tenaga Pendidik. Jika memilih Kelas akan muncul data Kelas sesuai dengan tahun ajaran yang terpilih.</td>
			</tr>
			<tr>
				<td>Tombol Simpan</td>
				<td>:</td>
				<td>Tombol Simpan akan muncul sesuai dengan pilihan data</td>
			</tr>
			<tr>
				<td>Data Terpilih</td>
				<td>:</td>
				<td>Data akan tersimpan sesuai dengan data pilihan. Nama Guru atau Nama kelas bisa di ganti dan langsung tersimpan</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			</table>
		</div>");
	//--------[data kbm]
		$DataKBMAdmin.=FormModal("DataKBMAdmin","Data KBM",$LabelLCKS2013."
		<div style='padding:20px'>
			<table class='table'>
			<tr>
				<td width='30%'>Merubah Data KKM</td>
				<td>:</td>
				<td>Silakan klik tombol untuk merubah KKM</td>
			</tr>
			<tr>
				<td>Prosentase</td>
				<td>:</td>
				<td>Pada kolom % K1, K2, K3, K4, UTS dan UAS, terdapat keterangan prosentase pengisian data nilai untuk setiap kelas, angka di dalam kurung kotak [ ] menunjukan jumlah siswa yang sudah di input nilainya. Angka akan tertera kurang dari atau sama dengan Jumlah Siswa yang tertera pada kolom JML</td>
			</tr>
			<tr>
				<td>Salin KBM ke Kelas Lain</td>
				<td>:</td>
				<td>Untuk memudahkan menyalin KBM dari kelas lain dengan SYARAT : TINGKAT dan JURUSAN yang SAMA</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			</table>
		</div>");
		$DataKBMGuru.=FormModal("DataKBMGuru","Data KBM",$LabelLCKS2013."
		<div style='padding:20px'>
			<table class='table'>
			<tr>
				<td width='20%'><button class='btn btn-info btn-xs'><i class='fa fa-plus'></i> Tambah KBM</button></td>
				<td width=5>:</td>
				<td>Menambah data KBM</td>
			</tr>
			<tr>
				<td><button class='btn btn-info btn-xs'><i class='fa fa-pencil'></i> Edit </button></td>
				<td>:</td>
				<td>Untuk merubah KKM</td>
			</tr>
			<tr>
				<td><button class='btn btn-info btn-xs'><i class='fa fa-th'></i> Detail </button></td>
				<td>:</td>
				<td>Melihat prosentase input data nilai</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			</table>
		</div>");
		$GMPDataKBMEdit.=FormModal("GMPDataKBMEdit","Edit Data KBM",$LabelLCKS2013."
		<div style='padding:20px'>
			<table class='table'>
			<tr>
				<td>Periksa Data</td>
				<td>:</td>
				<td>Silakan periksa data KBM dengan teliti</td>
			</tr>
			<tr>
				<td width='30%'>Kesalahan Data</td>
				<td>:</td>
				<td>Jika data KBM terdapat kesalahan silakan untuk menghubungi Administrator / Waka Kurikulum, untuk di hapus terlebih dahulu</td>
			</tr>
			<tr>
				<td>Edit KKM</td>
				<td>:</td>
				<td>Ubah KKM dengan angka KKM terbaru</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			</table>
		</div>");
		$TambahKBM.=FormModal("TambahKBM","Tambah KBM",$LabelLCKS2013."
		<div style='padding:20px'>
			<table class='table'>
			<tr>
				<td width='30%'>Tahun Ajaran</td>
				<td>:</td>
				<td>Menyesuaikan dengan tahun ajaran yang sedang berlangsung</td>
			</tr>
			<tr>
				<td>Pengajar</td>
				<td>:</td>
				<td>Nama Guru sesuai dengan akses guru bersangkutan</td>
			</tr>
			<tr>
				<td>Paket Keahlian</td>
				<td>:</td>
				<td>Jika Paket Keahlian dipilih maka akan muncul inputan Mata Pelajaran dan Kelas</td>
			</tr>
			<tr>
				<td>Mata Pelajaran</td>
				<td>:</td>
				<td>Pilih mata pelajaran sesuai dengan mata pelajaran yang bapak/ibu ampu. Mohon di perhatikan jika bapak/ibu memilih mata pelajaran maka akan muncul keterangan jenis mata pelajaran di bawah paket keahlian</td>
			</tr>
			<tr>
				<td>Kelas</td>
				<td>:</td>
				<td>Pilih kelas sesuai dengan bapak/ibu mengajar. Jika sudah di pilih akan muncul keterangan semester yang sedang berlangsung, serta KKM untuk Pengetahuan dan Keterampilan</td>
			</tr>
			<tr>
				<td>KKM Pengetahuan</td>
				<td>:</td>
				<td>Isi dengan KKM Pengetahuan mata pelajaran bapak/ibu</td>
			</tr>
			<tr>
				<td>KKM Keterampilan</td>
				<td>:</td>
				<td>Isi dengan KKM Keterampilan mata pelajaran bapak/ibu</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			</table>
		</div>");
		$SalinKBMMapel.=FormModal("SalinKBMMapel","Salin Data KBM",$LabelLCKS2013."
		<div style='padding:20px'>
			<table class='table'>
			<tr>
				<td width='30%'>Pilih Kelas</td>
				<td>:</td>
				<td>Silakan pilih kelas yang akan di salin</td>
			</tr>
			<tr>
				<td>Merubah Kelas</td>
				<td>:</td>
				<td>Agar tidak ada masalah silakan untuk merubah HANYA kelas yang TINGKAT DAN JURUSAN YANG SAMA</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			</table>
		</div>");
	//--------[kompetensi dasar]
		$DataKIKDMapel.=FormModal("DataKIKDMapel","Kompetensi Dasar",$LabelLCKS2013."
		<div style='padding:20px'>
			<table class='table'>
			<tr>
				<td width='30%'>Tombol KIKD</td>
				<td>:</td>
				<td>
					<i class='fa fa-plus font-sm fa-border txt-color-red'></i> Tanda belum memilih KIKD
					<hr class='simple'> 
					<i class='fa fa-search font-sm fa-border txt-color-blue'></i> Tanda sudah memilih KIKD
					<hr class='simple'> 
					<i class='fa fa-trash-o font-sm fa-border txt-color-red'></i> Tombol untuk menghapus jika ada salah satu KIKD baik Sikap, Pengetahuan maupun Keterampilan yang masih KOSONG
				</td>
			</tr>
			<tr>
				<td>Salin KIKD</td>
				<td>:</td>
				<td>Silakan klik tombol Salin KIKD di pojok kanan atas. Jika Mata Pelajaran Sama dan mengajar di beberapa Kelas, silakan untuk melakukan Salin KIKD. Dengan syarat mengisi terlebih dahulu salah satu kelas.</td>
			</tr>
			<tr>
				<td>Total KIKD</td>
				<td>:</td>
				<td>Kolom K1-K2, K3 dan K3 merupakan jumlah KIKD yang di pilih untuk tiap Kompetensi</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			</table>
		</div>");
		$CekKIKDMapel.=FormModal("CekKIKDMapel","Cek Pilihan Kompetensi Dasar",$LabelLCKS2013."
		<div style='padding:20px'>
			<ul style='margin-left:-25px;text-align:justify;'>
			<li>Silakan cek KIKD yang sudah dipilih
			<li>Jika KIKD belum memiliki nilai baik Pengetahuan maupun Keterampilan, maka untuk merubah KIKD, silakan memilih tombol hapus di bagian bawah
			<li>Jika KIKD sudah memiliki nilai baik Pengetahuan maupun Keterampilan, maka untuk merubah KIKD, silakan memilih tombol hapus di bagian bawah KIKD Pengetahuan maupun KIKD Keterampilan. Hal ini akan menghapus NILAI baik pengetahuan maupun keterampilan yang sudah di input di bagian proses penilaian. Karena yang muncul di proses penilaian kolom Nilai KIKD sesuai dengan pilihan KIKD 
			<li><span class='txt-color-red'>Jika hanya ingin menghapus KIKD dan menggantinya <strong>SILAKAN HUBUNGI BAGIAN ADMINISTRATOR</strong> </span>
			</ul>
		</div>");
		$PilihKIKDMapel.=FormModal("PilihKIKDMapel","Pilih Kompetensi Dasar",$LabelLCKS2013."
		<div style='padding:20px'>
			<ul style='margin-left:-25px;text-align:justify;'>
			<li>KIKD yang tercantum pada pilihan adalah KIKD selama 1 Tahun Pembelajaran
			<li>KIKD SIKAP, silakan untuk memilih semua KIKD
			<li>KIKD Keterampilan dan KIKD Pengetahuan, silakan pilih KIKD yang akan di ajarkan pada Semester yang sedang berlangsung 
			<li>Jumlah KIKD yang di pilih untuk KIKD Pengetahuan dan Keterampilan, akan menentukan jumlah KOLOM pada proses penilaian. Jika Anda memilih 5 KIKD baik pengetahuan maupuan keterampilan, maka Anda harus mengisi nilai sebanyak 5 kolom sesuai dengan Nilai KIKD masing-masing
			</ul>
		</div>");
		$SalinKIKDMapel.=FormModal("SalinKIKDMapel","Salin Kompetensi Dasar Mata Pelajaran",$LabelLCKS2013."
		<div style='padding:20px'>
			<table class='table'>
			<tr>
				<td width='30%'>Pilih Kelas</td>
				<td>:</td>
				<td>Silakan pilih kelas yang tertera kalimat [ADA], yang menandakan bahwa KIKD sudah ada</td>
			</tr>
			<tr>
				<td>Salin ke Kelas</td>
				<td>:</td>
				<td>Silakan pilih kelas yang tertera kalimat [BELUM], yang menandakan bahwa KIKD belum ada</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			</table>
		</div>");
	//--------[Proses Penilaian]
		$GMPPenilaia.=FormModal("GMPPenilaia","Proses Penilaian",$LabelLCKS2013."
		<div style='padding:20px'>
			<table class='table'>
			<tr>
				<td width='30%'>Download</td>
				<td>:</td>
				<td>Master File Excel untuk upload nilai, terdiri dari Nilai K1 K2 (Sikap Spritual dan Sosial), K3 (Pengetahuan), K4 (Keterampilan) dan UTS UAS<br> Silakan klik salah satu Format Nilai dan Anda akan mendapatkan file Excel sesuai dengan data Mata Pelajaran dan Kelas</td>
			</tr>
			<tr>
				<td>Pengisian Nilai Awal Sikap, Pengetahuan, Keterampilan, UTS/UAS</td>
				<td>:</td>
				<td>Silakan klik di bagian tombol yang berwarna merah, untuk pengisian awal Nilai</td>
			</tr>
			<tr>
				<td>Update Nilai Sikap, Pengetahuan, Keterampilan, UTS/UAS</td>
				<td>:</td>
				<td>Silakan klik di bagian tombol selain warna merah, untuk proses edit Nilai</td>
			</tr>
			<tr>
				<td>Review</td>
				<td>:</td>
				<td>Melihat hasil Nilai secara keseluruhan Sikap, Pengetahuan, Keterampilan dan UTS UAS. Serta Deskripsi hasil dari penilaian per KIKD</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			</table>
		</div>");
		$AturanNilai.="<h1><small class='text-danger slideInRight fast animated'><i class='fa fa-check-square fa-1x'></i> <strong>Rentang Penilaian</strong></small></h1><strong>PENILAIAN K1 DAN K2</strong>
		<table class='table table-bordered'>
			<tr class='text-center' bgcolor='#f5f5f5'>
				<td widht='15%'><strong>Angka</strong></td>
				<td><strong>Predikat</strong></td>
			</tr>
			<tr class='text-center'>
				<td>4</td>
				<td>Sangat Baik</td>
			</tr>
			<tr class='text-center'>
				<td>3</td>
				<td>Baik</td>
			</tr>
			<tr class='text-center'>
				<td>2</td>
				<td>Cukup</td>
			</tr>
			<tr class='text-center'>
				<td>1</td>
				<td>Kurang</td>
			</tr>
		</table>
		<strong>PENILAIAN K3 DAN K4</strong>
		<table class='table table-bordered'>
			<tr class='text-center' bgcolor='#f5f5f5'>
				<td width='35%'><strong>Nilai</strong></td>
				<td widht='25%'><strong>Huruf</strong></td>
				<td width='35%'><strong>Predikat</strong></td>
			</tr>
			<tr class='text-center'>
				<td>86 - 100</td>
				<td>A</td>
				<td>Sangat Baik</td>
			</tr>
			<tr class='text-center'>
				<td>71 - 85</td>
				<td>B</td>
				<td>Baik</td>
			</tr>
			<tr class='text-center'>
				<td>56 - 70</td>
				<td>C</td>
				<td>Cukup</td>
			</tr>
			<tr class='text-center'>
				<td>1 - 55</td>
				<td>D</td>
				<td>Kurang</td>
			</tr>
		</table>";
		$CaraIsiNKet.="<h1><small class='text-danger slideInRight fast animated'><i class='fa fa-check-square fa-1x'></i> <strong>Penilaian K1 dan K2</strong></small></h1>
		<ul style='margin-left:-25px;text-align:justify;'>
		<li>Nilai Sikap Spritual maupun Sikap Sosial antara 1 - 4
		<li>Deskripsi pada Nilai K1 dan K 2, silakan isi sesuai dengan temuan yang paling menonjol pada siswa, tidak semua siswa di isi deskripsinya
		</ul>
		<hr class='simple'>
		<strong>Contoh Sikap Spritual</strong><br>
		<em>Sanagt Baik dalam melakukan Ibadah</em><br>
		<em>Sangat Kurang dalam melakukan doa sebelum belajar</em><br>
		<strong>Contoh Sikap Sosial</strong><br>
		<em>Bertanggung jawab dalam kegiatan pembelajaran</em><br>
		<em>Kurang menghargai hasil karya orang lain</em>";
		$CaraUpload.="<h1><small class='text-danger slideInRight fast animated'><i class='fa fa-check-square fa-1x'></i> <strong>Upload dan Download Nilai</strong></small></h1>
		<ul style='margin-left:-25px;text-align:justify;'>
		<li>Tombol Upload Nilai akan muncul jika nilai belum terisi 
		<li>Silakan download format nilai di Data KBM, 
		<li>Isi nilai tiap KIKD sesuai dengan jumlah KIKD yang di pilih pada menu Kompensi Dasar
		<li>Format file excel harus format excel versi 2003-2007
		<li>Tombol Download Nilai akan muncul jika nilai sudah terisi 
		</ul>";
		$NgisiNilai.=FormModal("NgisiNilaiSiswa","Cara Input Nilai Siswa",$LabelLCKS2013."<div style='padding:20px'>".$CaraUpload.$CaraIsiNKet.$AturanNilai."</div>");
	//--------[Absensi]
		$Ngabsen.=FormModal("Ngabsen","Isi Absensi Siswa",$LabelLCKS2013."
		<div style='padding:20px'>
		<ul style='margin-left:-25px;text-align:justify;'>
		<li>Klik tombol <i class='fa fa-calendar-plus-o txt-color-blue'></i> untuk mengisi absensi per siswa
		<li>Isi absensi ini sesuai dengan waktu ketika siswa tersebut tidak mengikuti KBM
		</ul>
		</div>");
		$NgabsenMapel.=FormModal("NgabsenMapel","Isi Absensi Siswa",$LabelLCKS2013."
		<div style='padding:20px'>
		<ul style='margin-left:-25px;text-align:justify;'>
		<li>Klik tombol <i class='fa fa-pencil-square txt-color-blue'></i> untuk mengisi absensi per siswa
		<li>Isi absensi ini sesuai dengan waktu ketika siswa tersebut tidak mengikuti KBM
		</ul>
		</div>");
		$IsiAbsenMapel.=FormModal("IsiAbsenMapel","Proses Isi Absensi Siswa",$LabelLCKS2013."
		<div style='padding:20px'>
			<table class='table'>
			<tr>
				<td width='30%'>Absensi</td>
				<td>:</td>
				<td>Pilih Absensi Sakit, Izin, Alfa</td>
			</tr>
			<tr>
				<td>Alasan</td>
				<td>:</td>
				<td>Beri deskrisi alasan kenapa siswa IZIN</td>
			</tr>
			<tr>
				<td>Tanggal Absensi</td>
				<td>:</td>
				<td>Isi tanggal sesuai dengan absensi siswa</td>
			</tr>
			<tr>
				<td>Hapus Absensi</td>
				<td>:</td>
				<td>Klik tombol <i class='fa fa-times-circle'></i> untuk megnhapus absensi siswa pada bagian LIST ABSENSI'</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			</table>
		</div>");
	//--------[Laporan Nilai]
		$LaporanNilaiGMP.=FormModal("LaporanNilaiGMP","Laporan Nilai Guru Mata Pelajaran",$LabelLCKS2013."
		<div style='padding:20px'>
		<p style='text-indent:25px;text-align:justify;'>Fitur laporan nilai ini dipergunakan untuk download seluruh nilai per kelas per mata pelajaran yang di ajarkannya sebagai laporan penilaian untuk di berikan ke Kepala Sekolah atau Bagian Kurikulum</p>
		<p style='text-indent:25px;text-align:justify;'>Laporan Nilai setelah di download berupa file excel versi web, untuk itu silakan save as dengan mengganti type file xls atau xlsx</p>
		<p style='text-indent:25px;text-align:justify;'>Laporan Nilai dapat di cetak dengan cara klik tombol cetak laporan di kolom aksi</p>
		</div>");
	//--------[Arsip Nilai]
		$ArsipDataKBM.=FormModal("ArsipDataKBM","Arsip Nilai Guru Mata Pelajaran",$LabelLCKS2013."
		<div style='padding:20px'>
			<table class='table'>
			<tr>
				<td width='30%'>Pilih Data</td>
				<td>:</td>
				<td>Silakan pilih tahun ajaran dan semester</td>
			</tr>
			<tr>
				<td>Arsip</td>
				<td>:</td>
				<td>Klik <i class='fa fa-folder-open-o fa-border txt-color-red'></i> Data KBM melihat detail kbm<br>Klik <i class='fa fa-graduation-cap fa-border txt-color-red'></i> Data Nilai melihat detail nilai</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			</table>
		</div>");

//=================================================================[WALI KELAS]
	//--------[Data Kelas]
		$WKDataKelas.=FormModal("WKDataKelas","Pengisian Data Pembagian Rapor",$LabelLCKS2013."
		<div style='padding:20px'>
			<table class='table'>
			<tr>
				<td width='30%'>Tempat</td>
				<td>:</td>
				<td>Isi dengan tempat pembagian rapor, sesuaikan dengan alamat titimangsa surat</td>
			</tr>
			<tr>
				<td>Tanggal bagi rapor</td>
				<td>:</td>
				<td>Pilih tanggal, bulan dan tahun pembagian rapor</td>
			</tr>
			<tr>
				<td>Tombol</td>
				<td>:</td>
				<td>Jika belum diisi, muncul tombol Simpan, jika sudah diisi dan ada perbaikan muncul tombol Update</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			</table>
		</div>");
	//--------[Guru Mata Pelajaran]
		$WKGuruMapel.=FormModal("WKGuruMapel","Guru Mata Pelajaran",$LabelLCKS2013."
		<div style='padding:20px'>
			<ul style='margin-left:-25px;text-align:justify;'>
			<li>Angka-angka yang tertera di bagian penilaian baik K1 (Sikap Spritual), K2 (Sikap Sosial), K3 (Pengetahuan), K4 (Keterampilan), UTS dan UAS merupakan jumlah siswa yang sudah memiliki nilai
			<li>Jika ada siswa yang keluar di Kelas Bapak/ibu, maka jumlah angka akan sesuai dengan jumlah siswa yang ada di Kelas Bapak/Ibu, karena sistem belum menghapus siswa yang keluar. Silakan hubungi bagian Administrator / Kurikulum
			<li>Untuk cek data Mata Pelajaran yang di ajarkan pada semester aktif, silakan klik tombol Lihat Mata Pelajaran di pojok kanan atas
			<li>Untuk melihat Detail Data Pengajar, klik Nama Mata Pelajaran
			</ul>
		</div>");
		$DetailMataPelajaran.=FormModal("DetailMataPelajaran","Detail Mata Pelajaran Per Semester",$LabelLCKS2013."
		<div style='padding:20px'>
			<ul style='margin-left:-25px;text-align:justify;'>
			<li><i class='fa fa-check-square-o fa-border txt-color-red'></i> Mata Pelajaran yang sedang di ampu oleh siswa
			<li><i class='fa fa-check fa-border'></i> Mata Pelajaran di semester yang lain yang di ajarkan selama 6 semester
			</ul>
		</div>");
	//--------[Identitas Peserta Didik]
		$WKIdentSiswa.=FormModal("WKIdentSiswa","Identitas Peserta Didik",$LabelLCKS2013."
		<div style='padding:20px'>
			<ul style='margin-left:-25px;text-align:justify;'>
			<li>Untuk edit data peserta didik silakan klik nama siswa
			</ul>
		</div>");
		$WKEditIdentSiswa.=FormModal("WKEditIdentSiswa","Edit Identitas Peserta Didik",$LabelLCKS2013."
		<div style='padding:20px'>
			<h1><small class='text-danger slideInRight fast animated'><i class='fa fa-check-square fa-1x'></i> <strong>Biodata Siswa</strong></small></h1>
			<table class='table'>
			<tr>
				<td width='30%'>NIS</td>
				<td>:</td>
				<td>Isi dengan Nomor Induk Siswa (tidak boleh pakai spasi atau simbol)</td>
			</tr>
			<tr>
				<td>NISN</td>
				<td>:</td>
				<td>Isi dengan Nomor Indus Siswa Nasional, jika belum ada silakan isi dengan tanda minus (-)</td>
			</tr>
			<tr>
				<td>Tahun Masuk</td>
				<td>:</td>
				<td>Pilih tahun masuk siswa</td>
			</tr>
			<tr>
				<td>Paket Keahlian</td>
				<td>:</td>
				<td>Pilih Paket Keahlian</td>
			</tr>
			<tr>
				<td>Nama</td>
				<td>:</td>
				<td>Isi nama dengan nama lengkap siswa, jika ada tanda kutip satu maka tambahkan slash di belakang tanda kutip satu. Contoh RENI NUR/'ASIH</td>
			</tr>
			<tr>
				<td>Tempat Lahir</td>
				<td>:</td>
				<td>Isi dengan tempat lahir sesuai dengan Ijazah SMP/MTs atau Akta Lahir</td>
			</tr>
			<tr>
				<td>Tanggal Lahir</td>
				<td>:</td>
				<td>Isi dengan tanggal lahir sesuai dengan ijazah SMP</td>
			</tr>
			<tr>
				<td>Jenis Kelamin</td>
				<td>:</td>
				<td>Pilih jenis kelamin siswa</td>
			</tr>
			<tr>
				<td>Agama</td>
				<td>:</td>
				<td>Pilih Agama Islam, Katolik, Protestan, Advent, Hindu, Budha, Konghucu</td>
			</tr>
			<tr>
				<td>Status dalam Keluarga</td>
				<td>:</td>
				<td>Pilih status dalam keluarga siswa, Anak Kandung, Anak Tiri, Anak Angkat</td>
			</tr>
			<tr>
				<td>Anak Ke</td>
				<td>:</td>
				<td>Pilih urutan anak ke siswa</td>
			</tr>
			<tr>
				<td>Telepon</td>
				<td>:</td>
				<td>Isi dengan Telepon/HP Aktif Siswa</td>
			</tr>
			<tr>
				<td>Sekolah Asal SMP/MTS</td>
				<td>:</td>
				<td>Isi dengan nama sekolah asal siswa</td>
			</tr>
			<tr>
				<td>Di Terima di kelas</td>
				<td>:</td>
				<td>Isi di terima di kelas X, XI atau XII sesuai dengan masuknya siswa ke sekolah</td>
			</tr>
			<tr>
				<td>Tanggal Diterima</td>
				<td>:</td>
				<td>Isi dengan tanggal penerimaan Siswa</td>
			</tr>
			<tr>
				<td>Asal Siswa</td>
				<td>:</td>
				<td>Pilih Siswa Baru atau Pindahan</td>
			</tr>
			<tr>
				<td>Alasan Pindahan</td>
				<td>:</td>
				<td>Jika asal siswa Pindahan tuliskan alasan kepindahan</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			</table>
			<h1><small class='text-danger slideInRight fast animated'><i class='fa fa-check-square fa-1x'></i> <strong>Alamat Siswa</strong></small></h1>
			<table class='table'>
			<tr>
				<td width='30%'>Blok/Dusun</td>
				<td>:</td>
				<td>Isi dengan Blok/Dusun atau Jalan</td>
			</tr>
			<tr>
				<td>Nomor</td>
				<td>:</td>
				<td>Isi dengan nomor rumah siswa</td>
			</tr>
			<tr>
				<td>RT</td>
				<td>:</td>
				<td>Isi dengan RT alamat rumah siswa</td>
			</tr>
			<tr>
				<td>RW</td>
				<td>:</td>
				<td>Isi dengan RW alamat rumah siswa</td>
			</tr>
			<tr>
				<td>Desa</td>
				<td>:</td>
				<td>Isi nama desa alamat rumah siswa</td>
			</tr>
			<tr>
				<td>Kecamatan</td>
				<td>:</td>
				<td>Isi nama kecamatan alamat rumah siswa</td>
			</tr>
			<tr>
				<td>Kabupaten</td>
				<td>:</td>
				<td>Isi nama kabupaten alamat rumah siswa</td>
			</tr>
			<tr>
				<td>Kode Pos</td>
				<td>:</td>
				<td>Isi dengan kode pos alamat rumah siswa</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			</table>
			<h1><small class='text-danger slideInRight fast animated'><i class='fa fa-check-square fa-1x'></i> <strong>Biodata Orang Tua</strong></small></h1>
			<table class='table'>
			<tr>
				<td width='30%'>Nama Ayah</td>
				<td>:</td>
				<td>Isi nama ayah sesuai dengan Akta Lahir atau Kartu Keluarga</td>
			</tr>
			<tr>
				<td>Nama Ibu</td>
				<td>:</td>
				<td>Isi nama ibu sesuai dengan Akta Lahir atau Kartu Keluarga</td>
			</tr>
			<tr>
				<td>Pekerjaan Ayah</td>
				<td>:</td>
				<td>Pilih pekerjaan ayah, jika tidak ada di pilihan silakan pilih Lainnya</td>
			</tr>
			<tr>
				<td>Pekerjaan Ibu</td>
				<td>:</td>
				<td>Pilih pekerjaan ibu, jika tidak ada di pilihan silakan pilih Lainnya</td>
			</tr>
			<tr>
				<td>Telepon</td>
				<td>:</td>
				<td>Isi dengan nomor telepon ayah atau yang aktif atau nomor telp rumah</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			</table>
			<h1><small class='text-danger slideInRight fast animated'><i class='fa fa-check-square fa-1x'></i> <strong>Alamat Orang Tua</strong></small></h1>
			<table class='table'>
			<tr>
				<td width='30%'>Informasi</td>
				<td>:</td>
				<td>Jika alamat orang tua sama dengan alamat siswa silakan klik tombol YA<br>Jika beda alamatnya silakan isi alamat orang tua, keterangan cek pada keterangan alamat siswa</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			</table>
			<h1><small class='text-danger slideInRight fast animated'><i class='fa fa-check-square fa-1x'></i> <strong>Biodata Wali Siswa</strong></small></h1>
			<table class='table'>
			<tr>
				<td width='30%'>Informasi</td>
				<td>:</td>
				<td>Jika siswa memiliki Wali silakan lengkapi biodata wali siswa<br>Keterangan biodata wali siswa silakan baca keterangan Biodata Orang Tua</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			</table>
			<h1><small class='text-danger slideInRight fast animated'><i class='fa fa-check-square fa-1x'></i> <strong>Alamat Wali Siswa</strong></small></h1>
			<table class='table'>
			<tr>
				<td width='30%'>Informasi</td>
				<td>:</td>
				<td>Jika alamat orang tua sama dengan alamat siswa silakan klik tombol YA<br>Jika beda alamatnya silakan isi alamat wali siswa, keterangan cek pada keterangan alamat siswa</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			</table>
		</div>");
	//--------[Absensi Siswa]
		$WKAbsensiSiswa.=FormModal("WKAbsensiSiswa","Absensi Siswa",$LabelLCKS2013."
		<div style='padding:20px'>
			<ul style='margin-left:-25px;text-align:justify;'>
			<li>Klik tombol ISI ABSENSI Untuk proses menambah absensi siswa
			<li>Klik tombol REVIEW ABSENSI <span class='txt-color-red'> (muncul jika absensi sudah diisi)</span> Untuk proses edit absensi siswa
			</ul>
		</div>");
		$WKReviewAbsensiSiswa.=FormModal("WKReviewAbsensiSiswa","Absensi Siswa",$LabelLCKS2013."
		<div style='padding:20px'>
			<ul style='margin-left:-25px;text-align:justify;'>
			<!-- <li>Klik tombol <i class='fa fa-calendar-plus-o txt-color-teal'></i> Untuk menambah absensi siswa -->
			<li>Klik tombol <i class='fa fa-pencil-square-o txt-color-red'></i> Untuk edit absensi siswa
			</ul>
		</div>");
		$WKIsiAbsensiSiswa.=FormModal("WKIsiAbsensiSiswa","Proses Isi Absensi Siswa",$LabelLCKS2013."
		<div style='padding:20px'>
			<ul style='margin-left:-25px;text-align:justify;'>
			<li>Isi jumlah absensi siswa baik Sakit, Izin maupuan Alfa <span class='txt-color-red'>(Jumlah absensi di dapat dari Tata Usaha)</span>
			<li>Jika kosong biarkan tidak diisi
			<li>Setelah selesai klik tombol simpan
			</ul>
		</div>");
		$WKEditAbsen.=FormModal("WKEditAbsen","Proses Isi Absensi Siswa",$LabelLCKS2013."
		<div style='padding:20px'>
			<ul style='margin-left:-25px;text-align:justify;'>
			<li>Klik pilihan angka jumlah absensi siswa baik Sakit, Izin maupuan Alfa
			<li>Jika kosong pilih angka nol
			<li>Setelah selesai klik tombol simpan
			</ul>
		</div>");
	//--------[Kegiatan Eskul]
		$WKEskulSiswa.=FormModal("WKEskulSiswa","Ekstrakurikuler Siswa",$LabelLCKS2013."
		<div style='padding:20px'>
			<ul style='margin-left:-25px;text-align:justify;'>
			<li>Klik tombol <i class='fa fa-pencil-square-o txt-color-red'></i> Untuk menambah eskul siswa
			<li>Klik tombol <i class='fa fa-pencil-square txt-color-blue'></i> Untuk edit eskul siswa
			<li>Jika pilihan Eskul belum ada silakan tambahkan dengan cara klik Tombol Jenis Eskul di Pojok Kanan Atas
			</ul>
		</div>");
		$WKProsesIsiEskul.=FormModal("WKProsesIsiEskul","Proses Isi Ekstrakurikuler Siswa",$LabelLCKS2013."
		<div style='padding:20px'>
			<ul style='margin-left:-25px;text-align:justify;'>
			<li>Kriteria predikat penilaian Eskul terdiri dari Sangat Baik, Baik, Cukup Baik, Kurang Baik, Sangat Kurang
			<li>Jika kosong biarkan pilihan tertera tulisan Pilih
			<li>Jika membatalkan pengisian data eskul ubah pilihan dengan kata Pilih
			<li>Eskul Pramuka wajib diisi predikat penilaian eskulnya
			<li>Jika siswa mengikut eskul selain Pramuka silakan isi pada Pilihan 1 dan pilih eskul yang diikuti siswa
			<li>Jika siswa mengikut eskul lebih dari satu silakan isi pada Pilihan 2 dan pilih eskul yang diikuti siswa, seterusnya di sesuaikan dengan eskul yang diikuti siswa
			</ul>
		</div>");
		$WKDataEskul.=FormModal("WKDataEskul","Data Ekstrakurikuler",$LabelLCKS2013."
		<div style='padding:20px'>
			<ul style='margin-left:-25px;text-align:justify;'>
			<li>Pada halaman ini tertera seluruh jenis ekstrakurikuler yang ada di sekolah baik Wajib maupun Pilihan
			<li>Jika masih belum ada jenis ekstrakurikuler, silakan untuk menambahkan sendiri dengan cara klik tombol Tambah Data Eskul
			</ul>
		</div>");
		$WKTambahDataEskul.=FormModal("WKTambahDataEskul","Tambah Data Ekstrakurikuler",$LabelLCKS2013."
		<div style='padding:20px'>
			<table class='table'>
			<tr>
				<td width='30%'>Nama Eskul</td>
				<td>:</td>
				<td>Isi dengan nama eskul, disarankan menuliskan kepanjangan di tambah dengan singkatan di dalam kurung</td>
			</tr>
			<tr>
				<td>Jenis Eskul</td>
				<td>:</td>
				<td>Pilih Eskul Wajib dan Eskul Pilihan</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			</table>
		</div>");
	//--------[Prestasi Siswa]
		$WKPrestasiSiswa.=FormModal("WKPrestasiSiswa","Prestasi Siswa",$LabelLCKS2013."
		<div style='padding:20px'>
			<ul style='margin-left:-25px;text-align:justify;'>
			<li>Klik tombol <i class='fa fa-pencil-square-o txt-color-blue'></i> Untuk pertama kali menambah prestasi siswa
			<li>Klik tombol <i class='fa fa-pencil-square-o txt-color-red'></i> Untuk menambah prestasi jika siswa memiliki lebih dari 1 prestasi
			<li>Klik tombol <i class='fa fa-list-alt txt-color-red'></i> Untuk melihat prestasi siswa pada semester aktif
			</ul>
		</div>");
		$WKTambahDataPrestasi.=FormModal("WKTambahDataPrestasi","Tambah Data Prestasi Siswa",$LabelLCKS2013."
		<div style='padding:20px'>
			<table class='table'>
			<tr>
				<td width='20%'>Jenis</td>
				<td>:</td>
				<td>Pilih jenis prestasi, Intrakuruikuler atau Ekstrakurikuler</td>
			</tr>
			<tr>
				<td>Tingkat</td>
				<td>:</td>
				<td>Pilih Tingkat Juara, Sekolah, Kabupaten, Propinsi, Nasional</td>
			</tr>
			<tr>
				<td>Juara Ke-</td>
				<td>:</td>
				<td>Pilih Perolehan Juara, Umum, I, II, III, Harapan I, Harapan II, dan Harapan III</td>
			</tr>
			<tr>
				<td>Nama Lomba</td>
				<td>:</td>
				<td>Tuliskan dengan lengkap Nama Kejuaraan atau Nama Lomba</td>
			</tr>
			<tr>
				<td>Tanggal Lomba</td>
				<td>:</td>
				<td>Isi tanggal, bulan dan tahun ketika di umumkan atau mendapat piala kejuaraan</td>
			</tr>
			<tr>
				<td>Tempat Lomba</td>
				<td>:</td>
				<td>Tuliskan tempat berlangsungnya perlombaan</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			</table>
		</div>");
		$WKTampilPrestasiSiswa.=FormModal("WKTampilPrestasiSiswa","Tampil Prestasi Siswa",$LabelLCKS2013."
		<div style='padding:20px'>
			<ul style='margin-left:-25px;text-align:justify;'>
			<li>Halaman ini memperlihatkan semua prestasi siswa pada semester yang sedang berlangsung
			<li>Klik nama lomba jika akan melakukan edit atau hapus prestasi siswa
			</ul>
		</div>");
		$WKEditPrestasiSiswa.=FormModal("WKEditPrestasiSiswa","Edit Prestasi Siswa",$LabelLCKS2013."
		<br><br>
		<center>
		<img src='img/contactbg-student.png' width='200' height='223' border='0' alt=''><br><br><h1>CUKUP JELAS.</h1>SILAKAN CEK PENJELASAN TAMBAH PRESTASI SISWA<br><br></center>");
	//--------[Praktek Kerja]
		$WKPrakerinSiswa.=FormModal("WKPrakerinSiswa","Prakerin Siswa",$LabelLCKS2013."
		<div style='padding:20px'>
			<ul style='margin-left:-25px;text-align:justify;'>
			<li>Klik tombol <i class='fa fa-pencil-square-o txt-color-blue'></i> Untuk menambah prakerin siswa
			<li>Klik tombol <i class='fa fa-pencil-square txt-color-red'></i> Untuk merubah dan menghapus data prakerin siswa
			</ul>
		</div>");
		$WKProsesPrakerinSiswa.=FormModal("WKProsesPrakerinSiswa","Tambah/Edit Prakerin Siswa",$LabelLCKS2013."
		<div style='padding:20px'>
			<table class='table'>
			<tr>
				<td width='30%'>Nama Perusahaan</td>
				<td>:</td>
				<td>Isi dengan nama LENGKAP perusahaan </td>
			</tr>
			<tr>
				<td>Alamat Perusahaan</td>
				<td>:</td>
				<td>Isi dengan alamat LENGKAP Perusahaan</td>
			</tr>
			<tr>
				<td>Mulai</td>
				<td>:</td>
				<td>Isi dengan Bulan mulai prakerin</td>
			</tr>
			<tr>
				<td>Akhir</td>
				<td>:</td>
				<td>Isi dengan Bulan Akhir prakerin</td>
			</tr>
			<tr>
				<td>Tahun Pelajaran</td>
				<td>:</td>
				<td>Isi dengan tahun ajaran pelaksanaan prakerin</td>
			</tr>
			<tr>
				<td>Semester</td>
				<td>:</td>
				<td>Isi dengan semester pelaksanaan prakerin</td>
			</tr>
			<tr>
				<td>Nilai</td>
				<td>:</td>
				<td>Isi Nilai hasil Prakerin dengan NILAI PULUHAN</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			</table>
		</div>");
	//--------[Catatan Wali Kelas]
		$WKCatWK.=FormModal("WKCatWK","Catatan Wali Kelas",$LabelLCKS2013."
		<div style='padding:20px'>
			<ul style='margin-left:-25px;text-align:justify;'>
			<li>Klik tombol <i class='fa fa-pencil-square-o txt-color-blue'></i> Untuk menambah catatan wali kelas
			<li>Klik tombol <i class='fa fa-pencil-square txt-color-red'></i> Untuk merubah dan menghapus catatan wali kelas
			</ul>
		</div>");
		$WKProsesCatWK.=FormModal("WKProsesCatWK","Tambah/Edit Catatan Wali Kelas",$LabelLCKS2013."
		<div style='padding:20px'>
			<table class='table'>
			<tr>
				<td width='20%'>Catatan</td>
				<td>:</td>
				<td>Isi dengan catatan wali kelas terhadap prose KBM yang di ikuti siswa</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			</table>
		</div>");
	//--------[Cetak Rapor]
		$WKCetakRapor.=FormModal("WKCetakRapor","Cek Kelengkapan Halaman Rapor",$LabelLCKS2013."
		<div style='padding:20px'>
			<table class='table'>
			<tr>
				<td width='20%'>Pilih Nama Siswa</td>
				<td>:</td>
				<td>Sebelum melanjutkan silakan pilih nama siswa terlebih dahulu, karena jika tidak memilih siswa, proses cetak tidak bisa di lanjutkan</td>
			</tr>
			<tr>
				<td>Tab Proses Cetak</td>
				<td>:</td>
				<td>Di bagian samping tab Cetak, terdapat tab Cover, Rapor, Pindah dan Prestasi. Fitur ini untuk mengecek kelengkapan data rapor sebelum proses cetak di lanjutkan</td>
			</tr>
			<tr>
				<td>Tab Cover</td>
				<td>:</td>
				<td>Di bagian tab Cover ini terdiri dari sub tab Cover, Profil Sekolah, Profil Siswa dan Petunjuk</td>
			</tr>
			<tr>
				<td>Tab Rapor</td>
				<td>:</td>
				<td>
					Di bagian tab Rapor ini terdiri dari sub tab :
					<ol style='margin-left:-25px;text-align:justify;'>
					<li>Deskripsi K1 dan K2, memperlihatkan halaman deskripsi penilaian sikap sosial dan sikap spritual
					<li>Nilai K3 dan K4, memperlihatkan halaman kumpulan nilai K3 dan K4 setiap mata pelajaran yang di peroleh siswa
					<li>Deskripsi K3 dan K4, memperlihatkan halaman Deskripsi Penilaian KIKD untuk ranah Pengetahuan dan Ketermapilan
					<li>Lain-lain, memperlihatkan data Praktek Kerja Lapangan, Ekstrakurikuler, Prestasi Siswa dan Absensi Siswa
					<li>Catatan, memperlihatkan catatan wali kelas
					</ol>
				</td>
			</tr>
			<tr>
				<td>Tab Pindah</td>
				<td>:</td>
				<td>
					Di bagian tab Rapor ini terdiri dari sub tab Keluar dan tab Masuk <br>
					Catatan Siswa yang masuk bukan sebagai Siswa Baru, dan catatan siswa keluar
				</td>
			</tr>
			<tr>
				<td>Tab Prestasi</td>
				<td>:</td>
				<td>
					Tab ini menunjukan halaman seluruh prestasi siswa yang pernah di dapatkan oleh siswa selama 3 tahun belajar
				</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			</table>
			Silakan klik satu persatu untuk melihat kelengkapan setiap halaman
		</div>");
		$WKProsesCetakRapor.=FormModal("WKProsesCetakRapor","Proses Cetak Rapor",$LabelLCKS2013."
		<div style='padding:20px'>
			<table class='table'>
			<tr>
				<td width='30%'>Pilih Halaman</td>
				<td>:</td>
				<td>Silakan pilih halaman yang akan di cetak dengan menandai kotak cheklist disamping nama halaman</td>
			</tr>
			<tr>
				<td>Pilih Semua</td>
				<td>:</td>
				<td>Memilih semua halaman untuk di cetak</td>
			</tr>
			<tr>
				<td>Tombol Cetak Rapor</td>
				<td>:</td>
				<td>Dengan klik tombol Cetak Rapor ini, proses cetak akan muncul dengan proses cetak per Halaman</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			</table>
			<span class='txt-color-red'>Catatan : <strong>SEBAIKNYA PROSES CETAK MENGGUNAKAN BROWSER GOOGLE CHROME</strong></span>
		</div>");
		$WKLegerNilai.=FormModal("WKLegerNilai","Leger Nilai",$LabelLCKS2013."
		<div style='padding:20px'>
			<table class='table'>
			<tr>
				<td width='30%'>Tombol Leger Nilai</td>
				<td>:</td>
				<td>Untuk pertama kali silakan pilih sub menu generate, jika sudah bisa di lihat leger nilai dan download leger nilai</td>
			</tr>
			<tr>
				<td>A. Guru Mata Pelajaran</td>
				<td>:</td>
				<td>Seluruh data Pengajar yang mengajar di kelas </td>
			</tr>
			<tr>
				<td>B. Perolehan Nilai</td>
				<td>:</td>
				<td>Nilai yang telah di input oleh Guru Mata Pelajaran di sesuaikan dengan perolehan nilai siswa</td>
			</tr>
			<tr>
				<td>C. Absensi Siswa</td>
				<td>:</td>
				<td>Total Absensi Siswa yang di input oleh Guru Mata Pelajaran</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			</table>
		</div>");
	//--------[Peringkat Kelas]
		$WKRanking.=FormModal("WKRanking","Peringkat Kelas",$LabelLCKS2013."
		<div style='padding:20px'>
			<table class='table'>
			<tr>
				<td width='30%'>Tombol</td>
				<td>:</td>
				<td>
					<i class='fa fa-print txt-color-blue fa-2x fa-border' ></i> Cetak Peringkat Kelas<br>
					<i class='fa fa-download txt-color-blue fa-2x fa-border' ></i> Download Peringkat Kelas
					</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			</table>
		</div>");
	//--------[Siswa Tidak Naik]
		$WKTidakNaik.=FormModal("WKTidakNaik","Proses Tidak Naik Siswa",$LabelLCKS2013."
		<div style='padding:20px'>
			<table class='table'>
			<tr>
				<td>Aksi Edit</td>
				<td>:</td>
				<td><i class='fa fa-pencil-square-o txt-color-red'></i> Menambah/memproses data siswa tidak naik kelas</td>
			</tr>
			<tr>
				<td>Aksi Hapus</td>
				<td>:</td>
				<td><i class='fa fa-trash-o txt-color-red'></i> Membatalkan siswa tidak naik kelas</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			</table>
		</div>");

//=================================================================[TEUING KE HEULA]
	//--------[BP-BK]
		$SikapSiswa.=FormModal("SikapSiswa","Pengisian Data Nilai Sikap",$LabelLCKS2013."
		<div style='padding:20px'>".$BelumAdaPenjelasan."</div>");
	//--------[Leger Nilai]
		$KetLegerNilai.=FormModal("KetLegerNilai","Leger Nilai",$LabelLCKS2013."
		<div style='padding:20px'>
			<table class='table'>
			<tr>
				<td width='30%'>Pilih Data</td>
				<td>:</td>
				<td>Silakan pilih data tahun ajaran dan semester kemudian akan muncul data kelas sesuai data pilihan</td>
			</tr>
			<tr>
				<td>Download Nilai</td>
				<td>:</td>
				<td>Setelah muncul silakan untuk download leger nilai per kelas</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			</table>
		</div>");
//=================================================================[TEUING KE HEULA]

	//--------[Data Transkrip]
		$DataTrans.=FormModal("DataTrans","Data Transkrip Nilai",$LabelLCKS2013."
		<div style='padding:20px'>
			<h1><small class='text-danger slideInRight fast animated'><i class='fa fa-check-square fa-1x'></i> <strong>Identitas Transkrip</strong></small></h1>
			<table class='table'>
			<tr>
				<td>Aksi Edit</td>
				<td>:</td>
				<td><i class='fa fa-pencil fa-border'></i> Edit data titimangsa transkrip nilai</td>
			</tr>
			<tr>
				<td>Panel Tambah <i class='fa fa-plus'></i></td>
				<td>:</td>
				<td>Menambahkan data titi mangsa transkrip nilai</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			</table>
			<h1><small class='text-danger slideInRight fast animated'><i class='fa fa-check-square fa-1x'></i> <strong>Tambah Identitas Transkrip</strong></small></h1>
			<table class='table'>
			<tr>
				<td width='25%'>Tahun Ajaran</td>
				<td>:</td>
				<td>Pilih tahun ajaran siswa Kelas XII yang akan di buatkan transkrip nilai (tahun terakhir belajar)</td>
			</tr>
			<tr>
				<td width='25%'>Tahun Masuk</td>
				<td>:</td>
				<td>Pilih tahun masuk siswa yang akan di buatkan transkrip nilai (tahun terakhir belajar)</td>
			</tr>
			<tr>
				<td>Tempat</td>
				<td>:</td>
				<td>Isi dengan tempat atau alamat titi mangsa transkrip nilai</td>
			</tr>
			<tr>
				<td>Tgl Terbit</td>
				<td>:</td>
				<td>Isi dengan tanggal terbit atau dikeluarkan transkrip nilai untuk siswa yang telah lulus</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			</table>
		</div>	
		");







	//--------[Nilai UNUS]
		$NilUNUS.=FormModal("NilUNUS","Nilai UN dan US",$LabelLCKS2013."
		<div style='padding:20px'>".$BelumAdaPenjelasan."</div>");


	//--------[Biodata Akun Siswa]
		$QOPR=mysql_query("select * from user_login");
		while($HOPR=mysql_fetch_array($QOPR)){$TampilOPR.="<li>{$HOPR['nama_lengkap']}</li>";}
		$IdentSiswa.=FormModal("IdentSiswa","Identitas Peserta Didik",$LabelLCKS2013."
		<div style='padding:20px'>
			<ul style='margin-left:-25px;text-align:justify;'>
			<li>Jika ada data yang SALAH atau KURANG silakan hubungi Adminitrator</li>
			<li>Administrator yang bisa di Hubungi 
				<ul style='margin-left:-25px;text-align:justify;'>
					$TampilOPR
				</ul>
			</li>
			</ul>
		</div>");


//"))
?>