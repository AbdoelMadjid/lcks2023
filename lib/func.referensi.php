<?php
/* 12/6/2016 --> Sabtu, 28 Januari 2017 13.10.40 --> 07/01/2023 18:42
Design and Programming By. Abdul Madjid, S.Pd., M.Pd.
SMK Negeri 1 Kadipaten
Pin 520543F3 HP. 0812-3000-0420
https://twitter.com/AbdoelMadjid 
https://www.facebook.com/abdulmadjid.mpd
*/
//eval(base64_decode("

$hari_sekarang=date("Y-m-d H:i:s", time() + $GMT);
$NamaBulan  = array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
$Ref->KelMapel		= array("A","B","C1","C2","C3","C4","M");
$Ref->TingkatKls	= array("X","XI","XII");
$Ref->YesOrNo		= array("Y","N");
$Ref->Semester		= array("1","2","3","4","5","6");
$Ref->JenisGuru		= array("Produktif","Umum","BP/BK");
$Ref->LevelUserGuru	= array("Kepala Sekolah","Guru");
$Ref->LevelUserSiswa= array("Siswa","Alumni");
$Ref->Gender		= array("Laki-laki","Perempuan");
$Ref->StatusSekolah	= array("Negeri","Swasta");
$Ref->Angka			= array("1","2","3","4","5","6","7","8","9","10","11","12");
$Ref->TahunMasuk	= array("2013","2014","2015","2016","2017","2018","2019","2020","2021","2022","2023","2024","2025","2026","2027");
$Ref->NamaHari		= array("Minggu","Senin","Selasa","Rabu","Kamis","Jum'at","Sabtu");
$Ref->NamaBulan		= array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
$Ref->AngkaBulan	= array("01","02","03","04","05","06","07","08","09","10","11","12");
$Ref->Agama			= array("Islam","Katolik","Protestan","Advent","Hindu","Budha","Kong Hu Cu");
$Ref->StatKel		= array("Anak Kandung","Anak Tiri","Anak Angkat");
$Ref->AsalSiswa		= array("Siswa Baru","Pindahan");
$Ref->Pekerjaan		= array("PNS","TNI","POLRI","Pegawai BUMN","Pegawai BUMD","Pegawai Swasta","Wiraswasta","Buruh","Buruh Tani","Buruh Pabrik","Ibu Rumah Tangga","Lainnya");
$Ref->JenisEskul	= array("Pilihan","Wajib");
$Ref->NilaiEskul	= array("Sangat Baik","Baik","Cukup Baik","Kurang Baik","Sangat Kurang");
$Ref->TkPrestasi	= array("Sekolah","Kabupaten","Provinsi","Nasional");
$Ref->JuaraKe		= array("Umum","I","II","III","Harapan I","Harapan II","Harapan III");
$Ref->JenisPrestasi	= array("Intrakurikuler","Ekstrakurikuler");
$Ref->NilaiSikap	= array("1","2","3","4");
$Ref->Absensi		= array("Sakit","Izin","Alfa");
$Ref->NilaiPKL		= array("Sangat Baik","Baik","Cukup","Kurang");
$Ref->SmstX			= array("1","2");
$Ref->SmstXI		= array("3","4");
$Ref->SmstXII		= array("5","6");
$Ref->KodeRanah		= array("KDS","KDP","KDK","CP1","CP2","CP3");
$Ref->JmlAbsen		= array("0","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30");
$Ref->DataPilihan	= array("Guru","Kelas");
$Ref->GG			= array("Ganjil","Genap");
$Ref->TypeNilai		= array("UN","UNPK","US","US-DPK","US-PK","UJIKOM","NL");
$Ref->YaTidak		= array("Ya","Tidak");
$Ref->Kilometer		= array("Kurang dari 1 KM","Lebih Dari 1 KM");
$Ref->Jenkel	    = array("L","P");
$Ref->PilDataDapo   = array("Kelengkapan Data","Data Dapodik");
$Ref->JenisDtDapo   = array("Vervalpd","Data Inti","Alamat","Transportasi","Kontak dan Kordinat","Kartu","Registrasi","Periodik","Ayah Kandung","Ibu Kandung","Wali Siswa");
$Ref->LengkapData   = array("Validasi Dapodik","Alamat","Orang Tua Siswa","Registrasi dan Periodik","Dokumen");
$Ref->Aktif			= array("Aktif","Non Aktif");
$Ref->AktifGuru		= array("Semua","Aktif","Non Aktif");
$Ref->LevelAdmin	= array("Master","Admin","BpBk","TimPKG","OSIS");

$Ref->CalonMPKOSIS	= array("MPK","OSIS");
$Ref->JabMPKOSIS	= array("KETUA","WAKIL KETUA");
$Ref->NoCalonMPKOSIS = array("01","02","03");
$Ref->TinggiCetak	= array("21","22","23","24","25","26","27","28","29","30","31","32","33","34","35","36","37","38","39","40");

$Ref->JenisGuruPKG = array("Kepala Sekolah","Guru Mata Pelajaran","Guru BP/BK");
$Ref->PendidikanPKG = array("S1","S2","S3");
$Ref->PKPKG = array("Rekayasa Perangkat Lunak","Teknik Komputer dan Jaringan","Bisnis Daring dan Pemasaran",'Otomatisasi dan Tata Kelola Perkantoran','Akuntansi dan Keuangan Lembaga','Perbankan Syariah');




?>