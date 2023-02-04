<?php
require_once("inc/init.php");
require_once("inc/config.ui.php");
$page_title = "Penilaian";
$page_css[] = "your_style.css";
include("inc/header.php");
$page_nav["kbm"]["sub"]["penilaian"]["active"] = true;
include("inc/nav.php");
echo "<div id='main' role='main'>";
$breadcrumbs["Proses KBM"] = "";
include("inc/ribbon.php");

$sub=(isset($_GET['sub']))?$_GET['sub']:"";
switch($sub)
{
	case "tampil":default:
		$Q="select 
			gmp_ngajar.id_ngajar,
			gmp_ngajar.thnajaran,
			app_user_guru.nama_lengkap,
			ak_matapelajaran.nama_mapel,
			ak_kelas.nama_kelas,
			ak_kelas.tingkat,
			gmp_ngajar.kd_guru,
			gmp_ngajar.jenismapel,
			gmp_ngajar.semester,
			gmp_ngajar.kkmpeng,
			gmp_ngajar.kkmket
			from gmp_ngajar 
			inner join app_user_guru on gmp_ngajar.kd_guru=app_user_guru.id_guru
			inner join ak_matapelajaran on gmp_ngajar.kd_mapel=ak_matapelajaran.kode_mapel
			inner join ak_kelas on gmp_ngajar.kd_kelas = ak_kelas.kode_kelas
			where gmp_ngajar.kd_guru='$IDna' and 
			gmp_ngajar.thnajaran='$TahunAjarAktif' and 
			gmp_ngajar.ganjilgenap='$SemesterAktif'";
			$ThnAjar="$TahunAjarAktif";
			$Smstr="$SemesterAktif";

		$no=1;
		$Query=mysql_query("$Q order by gmp_ngajar.kd_kelas,gmp_ngajar.kd_mapel asc");

		while($Hasil=mysql_fetch_array($Query)){
			$NamaGuru=$Hasil['nama_lengkap'];
			$NamaKelas=$Hasil['nama_kelas'];
			$IdNa=$Hasil['id_ngajar'];

		//======= [ cek jumlah nilai Sikap ]
			$QSKIKD=mysql_query("select * from n_sikap where kd_ngajar='".$IdNa."'");
			$JSKIKD=mysql_num_rows($QSKIKD);
			if($JSKIKD>0){
				$TmpS="<i class='fa fa-search text-danger'></i>";
			}
			else{
				$TmpS="<i class='fa fa-pencil-square-o text-danger' ></i>";
			}

		//======= [ cek jumlah nilai Pengetahuan ]
			$QPKIKD=mysql_query("select * from n_p_kikd where kd_ngajar='".$IdNa."'");
			$JPKIKD=mysql_num_rows($QPKIKD);
			if($JPKIKD>0){
				$TmpP="<i class='fa fa-search text-danger'></i>";
			}
			else{
				$TmpP="<i class='fa fa-pencil-square-o text-danger'></i>";
			}

		//======= [ cek jumlah nilai Keterampilan ]
			$QKKIKD=mysql_query("select * from n_k_kikd where kd_ngajar='".$IdNa."'");
			$JKKIKD=mysql_num_rows($QKKIKD);
			if($JKKIKD>0){
				$TmpK="<i class='fa fa-search text-danger'></i>";
			}else{
				$TmpK="<i class='fa fa-pencil-square-o text-danger'></i>";
			}

		//======= [ cek jumlah nilai UTS UAS ]
			$QUTSUAS=mysql_query("select * from n_utsuas where kd_ngajar='".$IdNa."'");
			$JUTSUAS=mysql_num_rows($QUTSUAS);
			if($JUTSUAS>0){
				$TUTSUAS="<i class='fa fa-search text-danger'></i>";
			}
			else{
				$TUTSUAS="<i class='fa fa-pencil-square-o text-danger'></i>";
			}

			
			if($JPKIKD>0 || $JKKIKD>0){
				$tombolupload="";
				$tombolreview="<a href='?page=$page&sub=reviewnilai&kbm={$Hasil['id_ngajar']}' class='btn btn-default btn-sm btn-block'><i class='fa fa-search text-danger'></i> Review</a>";
			}
			else{
				if($NgunciKBM=="Y"){}else{
					$tombolupload="<a href='?page=$page&sub=upload_nilai&guru={$Hasil['kd_guru']}&thnajaran={$Hasil['thnajaran']}&gg={$Hasil['semester']}&kbm={$Hasil['id_ngajar']}'class='btn btn-default btn-sm btn-block'> <i class='fa fa-upload text-danger'></i> Upload</a>";
				}
				$tombolreview="";
			}
			
			$NgesiNilai="
			<ul class='dropdown-menu'>
				<li><a href='javascript:void(0);'>{$Hasil['nama_mapel']}<br>{$Hasil['nama_kelas']}</a></li>
				<li class='divider'></li>
				<li><a href='?page=gurumapel-nilai-sikap&kbm={$Hasil['id_ngajar']}'>$TmpS Nilai Sikap [K1 K2]</a></li>
				<li><a href='?page=gurumapel-nilai-pkikd&kbm={$Hasil['id_ngajar']}'>$TmpP Nilai Pengetahuan [K3]</a></li>
				<li><a href='?page=gurumapel-nilai-utsuas&kbm={$Hasil['id_ngajar']}'>$TUTSUAS Nilai UTS-UAS</a></li>
				<li><a href='?page=gurumapel-nilai-kkikd&kbm={$Hasil['id_ngajar']}'>$TmpK Nilai Keterampilan [K4]</a></li>
			</ul>";
			$TmblDownload="<a href=\"javascript:void(0);\" onClick=\"window.open('./pages/excel/ekspor-data-master.php?eksporex=format-nilai-gurumapel&kbm={$Hasil['id_ngajar']}&mapel={$Hasil['nama_mapel']}&kls={$Hasil['nama_kelas']}&thnajaran={$Hasil['thnajaran']}&gg={$Hasil['semester']}&ptk={$Hasil['kd_guru']}')\" class='btn btn-default btn-sm btn-block'><i class='fa fa-download text-danger'></i> Download</a>";
			$TampilData.="
			<tr>
				<td class='text-center' width='30'>$no.</td>
				<td width='50'><code>$IdNa</code></td>
				<td><span class='text-danger'>{$Hasil['nama_lengkap']} </span><br>{$Hasil['nama_mapel']}</td>
				<td width='85'>{$Hasil['nama_kelas']}</td>
				<td width='100'>
					<div class='btn-group'>
						<button class='btn btn-default btn-sm btn-block dropdown-toggle' data-toggle='dropdown'>
							<i class='fa fa-edit text-danger'></i> &nbsp;Isi Nilai &nbsp;<span class='caret'></span>
						</button>
						$NgesiNilai
					</div>				
				</td>
				<td width='50'>$tombolreview</td>
				<td width='50'>$TmblDownload</td>
				<td width='75'>$tombolupload</td>
			</tr>";
			$no++;
		}

		$jmldata=mysql_num_rows($Query);

		if($jmldata>0){
			$Show.=Label("Tahun Ajaran ".$ThnAjar." Semester ".$Smstr);
			$Show.="
			<div class='well no-padding'>
			<table id='dt_basic' class='table table-striped table-bordered table-hover table-condensed' width='100%'>
				<thead>
					<tr>
						<th class='text-center' data-class='expand'>NO. </th>
						<th class='text-center' data-hide='phone'>Kode Ngajar</th>
						<th class='text-center'>Guru / Mata Pelajaran</th>
						<th class='text-center'>Kelas</th>
						<th class='text-center' data-hide='phone,tablet'>Nilai</th>
						<th class='text-center' data-hide='phone,tablet'>Review</th>
						<th class='text-center' data-hide='phone,tablet'>Format Nilai</th>
						<th class='text-center' data-hide='phone,tablet'>Upload Nilai</th>
					</tr>
				</thead>
				<tbody>$TampilData</tbody>
			</table>
			</div>";
		}
		else{
			$Show.='
			<p class="text-center"><img src="img/aa.png" width="100" height="231" border="0" alt=""></p><h1 class="text-center"><small class="text-danger slideInRight fast animated"><strong>Data KBM Belum Ditambahkan, Penialain Masih Kosong!</strong></small></h1>';
		}

		$tandamodal="#GMPPenilaia";
		echo $GMPPenilaia;
		echo MyWidget('fa-edit',"Penilaian $NamaGuru","",$Show);		
	break;

	case "reviewnilai":
		$kbm=isset($_GET['kbm'])?$_GET['kbm']:"";

		$DataKDS=mysql_query("select * from gmp_kikd where kode_ngajar='$kbm' and kode_ranah='KDS'");
		$DataKDP=mysql_query("select * from gmp_kikd where kode_ngajar='$kbm' and kode_ranah='KDP'");
		$DataKDK=mysql_query("select * from gmp_kikd where kode_ngajar='$kbm' and kode_ranah='KDK'");

		$jmlKDS=mysql_num_rows($DataKDS);
		$jmlKDP=mysql_num_rows($DataKDP);
		$jmlKDK=mysql_num_rows($DataKDK);

		if($jmlKDS==0 && $jmlKDP==0 && $jmlKDK==0){
			$Show.=ButtonKembali2("?page=$page","style='margin-top:-10px;'");
			$Show.=JudulKolom("Detail Nilai KBM","clone");
			$Show.=nt("peringatan","<strong>Kompetensi Dasar </strong> belum di pilih","silakan isi dulu <a href='?page=gmp-ki-kd'>Kompetensi Dasar Mata Pelajaran</a>.");
		}
		else{
			$Q=mysql_query("
			select 
			gmp_ngajar.id_ngajar,
			gmp_ngajar.thnajaran,
			gmp_ngajar.semester,
			gmp_ngajar.ganjilgenap,
			gmp_ngajar.kkmpeng, 
			gmp_ngajar.kkmket,
			gmp_ngajar.kd_mapel,
			ak_kelas.nama_kelas,
			ak_matapelajaran.nama_mapel,
			app_user_guru.nama_lengkap,
			ak_perkelas.nis,
			siswa_biodata.nm_siswa 
			from gmp_ngajar
			inner join ak_perkelas on gmp_ngajar.thnajaran=ak_perkelas.tahunajaran
			inner join ak_kelas on gmp_ngajar.kd_kelas=ak_kelas.kode_kelas and ak_kelas.nama_kelas=ak_perkelas.nm_kelas
			inner join app_user_guru on gmp_ngajar.kd_guru=app_user_guru.id_guru
			inner join ak_matapelajaran on gmp_ngajar.kd_mapel=ak_matapelajaran.kode_mapel
			inner join siswa_biodata on ak_perkelas.nis=siswa_biodata.nis
			where gmp_ngajar.id_ngajar='$kbm' order by siswa_biodata.nm_siswa,siswa_biodata.nis");

			$jmlSiswa=mysql_num_rows($Q);

			$no=1;
			while($Hasil=mysql_fetch_array($Q)){
				$Matapel=$Hasil['nama_mapel'];
				$Kls=$Hasil['nama_kelas'];
				$GuruNgajar=$Hasil['nama_lengkap'];
				$ThnAjaran=$Hasil['thnajaran'];
				$Smstr=$Hasil['semester']." (".$Hasil['ganjilgenap'].")";
				$NISna=$Hasil['nis'];
				$NilaiKKMP=$Hasil['kkmpeng'];
				$NilaiKKMK=$Hasil['kkmket'];

				//tampilkan nilai PENGETAHUAN ==========================================
				$QNKDP=mysql_query("select * from n_p_kikd where kd_ngajar='$kbm' and nis='$NISna'");
				$JmlNKDP=mysql_num_rows($QNKDP);
				$NKDP=mysql_fetch_array($QNKDP);
				$QNUTSUAS=mysql_query("select * from n_utsuas where kd_ngajar='$kbm' and nis='$NISna'");
				$JmlNUTSUAS=mysql_num_rows($QNUTSUAS);
				$NKUTSUAS=mysql_fetch_array($QNUTSUAS);

				//tampilkan nilai KETERAMPILAN ==========================================
				$QNKDK=mysql_query("select * from n_k_kikd where kd_ngajar='$kbm' and nis='$NISna'");
				$JmlNKDK=mysql_num_rows($QNKDK);
				$NKDK=mysql_fetch_array($QNKDK);

				//====================================================================================[tampilkan nilai SOSIAL]
				$QNKDS=mysql_query("select * from n_sikap where kd_ngajar='$kbm' and nis='$NISna'");
				$NKDS=mysql_fetch_array($QNKDS);
				$NSpritual=$NKDS['spritual'];
				$NSosial=$NKDS['sosial'];

				//tampilkan nilai RATA-RATA ==========================================
				$QR=mysql_query("select * from n_transkrip where kd_ngajar='$kbm' and nis='$NISna'");
				$NR=mysql_fetch_array($QR);

				/*
				$QRank2=mysql_query("SELECT kd_ngajar,nis,rerata AS rata_var,(SELECT COUNT(rerata) + 1 FROM n_transkrip WHERE (rerata > rata_var) AND kd_ngajar='$kbm') AS rank FROM n_transkrip where kd_ngajar='$kbm'");
				
				while($NRank2=mysql_fetch_array($QRank2)){
					if($NRank2['nis']==$NISna){
						$TampilRanking=$NRank2['rank'];
					}
				}
				*/

				$NAP=round(($NKDP['kikd_p']+$NKUTSUAS['uts']+$NKUTSUAS['uas'])/3);
				$PredP=predikat($NAP);
				$PredK=predikat($NKDK['kikd_k']);
				$R2=round(($NAP+$NKDK['kikd_k'])/2);
				$PredSw=predikat($R2);
				$TNilSpr=$TNilSpr+$NSpritual;
				$TNilSos=$TNilSos+$NSosial;
				$TNilKDP=$TNilKDP+$NKDP['kikd_p'];
				$TUTS=$TUTS+$NKUTSUAS['uts'];
				$TUAS=$TUAS+$NKUTSUAS['uas'];
				$TNAD=$TNAD+$NAP;				
				$TNilKDK=$TNilKDK+$NKDK['kikd_k'];
				$TNR=$TNR+$R2;

				if($NKDP['kikd_p']>100){
					$warna0="#ffff66";
				}else{
					$warna0="#fffff4";
				}

				if($NAP<$NilaiKKMP){
					$warna1="#ffcccc";
				}
				else if($NAP>100){
					$warna1="#ffff66";
				}
				else{
					$warna1="#fffff4";
				}

				if($NKDK['kikd_k']<$NilaiKKMK){
					$warna2="#ffcccc";
				}
				else if($NKDK['kikd_k']>100){
					$warna2="#ffff66";
				}
				else{
					$warna2="#fffff4";
				}


				$nmsiswa=$Hasil['nm_siswa'];

				//tampilkan nilai KETERAMPILAN ==========================================

				$JmlNKDP=JmlDt("select * from gmp_kikd where kode_ranah='KDP' and kode_ngajar='$kbm'");			
				$JmlNKDK=JmlDt("select * from gmp_kikd where kode_ranah='KDK' and kode_ngajar='$kbm'");


				$QKIKDP=mysql_query("SELECT * FROM n_p_kikd where kd_ngajar='$kbm' AND nis='$NISna'");
				$HNKIKDP=mysql_fetch_array($QKIKDP);

				$QKIKDK=mysql_query("SELECT * FROM n_k_kikd where kd_ngajar='$kbm' AND nis='$NISna'");
				$HNKIKDK=mysql_fetch_array($QKIKDK);

				$QKIKDUTSUAS=mysql_query("SELECT * FROM n_utsuas WHERE kd_ngajar='$kbm' AND nis='$NISna'");
				$HKIKDUTSUAS=mysql_fetch_array($QKIKDUTSUAS);
				
				$NAP=round(($HNKIKDP['kikd_p']+$HKIKDUTSUAS['uts']+$HKIKDUTSUAS['uas'])/3,0);

				$NA=round(((round(($HNKIKDP['kikd_p']+$HKIKDUTSUAS['uts']+$HKIKDUTSUAS['uas'])/3,0)+$HNKIKDK['kikd_k'])/2),0);

				if($NAP<$Hasil['kkmpeng']){$bgp='#ff0000';$fcolp='#ffffff';}else{$bgp='';$fcolp='';}
				if($HNKIKDK['kikd_k']<$Hasil['kkmpeng']){$bgk='#ff0000';$fcolk='#ffffff';}else{$bgk='';$fcolk='';}

				$TampilData.="
				<tr>
					<td class='hidden-480 text-center'>$no</td>
					<td>{$Hasil['nm_siswa']}</td>
					<td class='text-center'>{$Hasil['nis']}</td>
					<td class='hidden-480 text-center'>$NSpritual</td>
					<td class='hidden-480 text-center'>$NSosial</td>
					<td class='hidden-480 text-center' bgcolor='$warna0'>{$NKDP['kikd_p']}</td>
					<td class='hidden-480 text-center'>{$NKUTSUAS['uts']}</td>
					<td class='hidden-480 text-center'>{$NKUTSUAS['uas']}</td>
					<td class='hidden-480 text-center' bgcolor='$warna1'>$NAP</td>
					<td class='hidden-480 text-center'>$PredP</td>
					<td class='hidden-480 text-center' bgcolor='$warna2'>{$NKDK['kikd_k']}</td>
					<td class='hidden-480 text-center'>$PredK</td>
					<td class='text-center'>$R2</td>
					<td class='text-center'>$PredSw</td>
				</tr>";
				$no++;
			}

			$jmldata=mysql_num_rows($Q);
			if($jmldata>0){
				$ProfilKBM.=JudulKolom("Profil <em class='text-danger'>Kegiatan Belajar Mengajar</em>","");
				$ProfilKBM.="
				<dl class='dl-horizontal'>
				  <dt>Tahun Ajaran</dt><dd>$ThnAjaran</dd>
				  <dt>Semester</dt><dd>$Smstr</dd>
				  <dt>Mata Pelajaran</dt><dd>$Matapel</dd>
				  <dt>Kelas</dt><dd>$Kls</dd>
				  <dt>Nama Guru</dt><dd>$GuruNgajar</dd>
				  <dt>Jumlah KD K3</dt><dd>$jmlKDP (".Terbilang($jmlKDP).")</dd>
				  <dt>Jumlah KD K4</dt><dd>$jmlKDK (".Terbilang($jmlKDK).")</dd>
				  <dt>KKM K3</dt><dd>$NilaiKKMP (".Terbilang($NilaiKKMP).")</dd>
				  <dt>KKM K4</dt><dd>$NilaiKKMK (".Terbilang($NilaiKKMK).")</dd>
				  <dt>Jumlah Siswa</dt><dd>$jmldata (".Terbilang($jmldata).")</dd>
				</dl>";
				
				$Keterangan.=JudulKolom("Keterangan <em class='text-danger'>Singkatan</em>","");
				$Keterangan.="
				<dl class='dl-horizontal'>
				  <dt>SP</dt><dd>Nilai Sikap Spritual</dd>
				  <dt>SO</dt><dd>Nilai Sikap Sosial</dd>
				  <dt>NHP</dt><dd>Nilai Harian Pengetahuan di ambil dari nilai rata-rata per KD</dd>
				  <dt>UTS</dt><dd>Ujian Tengah Semester</dd>
				  <dt>UAS</dt><dd>Ujian Akhir Semester</dd>
				  <dt>NA</dt><dd>Nilai Akhir</dd>
				  <dt>P</dt><dd>Predikat</dd>
				</dl>";
									
				$Show.=ButtonKembali2("?page=$page","style='margin-top:-10px;'");
				$Show.="<a href='?page=$page&sub=deskripsi&kbm=$kbm' class='btn btn-default btn-sm pull-right' style='margin-top:-10px;margin-right:10px'>Deskripsi Penilaian</a>";
				$Show.=JudulKolom("Detail Nilai KBM","clone");
				$Show.=DuaKolomSama($ProfilKBM,$Keterangan);			

				$RNilSpr=round(($TNilSpr/$jmldata),2);
				$RNilSos=round(($TNilSos/$jmldata),2);
				$RNilKDP=round($TNilKDP/$jmldata);
				$RUTS=round($TUTS/$jmldata);
				$RUAS=round($TUAS/$jmldata);
				$RNAD=round($TNAD/$jmldata);
				$PredikatP=predikat($RNAD);
				$RNilKDK=round($TNilKDK/$jmldata);
				$RNR=round($TNR/$jmldata);
				$PredikatK=predikat($RNR);
				$Deskripsi=deskripsi($RNR);

				$Show.=Label("<span class='text-danger'>REVIEW</span> <em>Nilai</em>");
				$Show.="
				<div class='table-responsive'>
				<table id='simple-table' class='table table-striped table-bordered table-hover'>
					<thead>
						<tr>
							<th class='hidden-480 text-center' rowspan='2'>No.</th>
							<th class='text-center' rowspan='2'>Nama Siswa</th>
							<th class='text-center' rowspan='2'>NIS</th>
							<th class='hidden-480 text-center' colspan='2'>Sikap</th>
							<th class='hidden-480 text-center' colspan='5'>Pengetahuan</th>
							<th class='hidden-480 text-center' colspan='2'>Keterampilan</th>
							<th class='text-center' rowspan='2' width='25'>Rata2 Nilai</th>
							<th class='text-center' rowspan='2' width='25'>Predikat Kelas</th>
						</tr>
						<tr>
							<th class='hidden-480 text-center' width='50'>SP</th>
							<th class='hidden-480 text-center' width='50'>SO</th>
							<th class='hidden-480 text-center' width='50'>NHP</th>
							<th class='hidden-480 text-center' width='50'>UTS</th>
							<th class='hidden-480 text-center' width='50'>UAS</th>
							<th class='hidden-480 text-center' width='50'>NA</th>
							<th class='hidden-480 text-center' width='50'>P</th>
							<th class='hidden-480 text-center' width='50'>NA</th>
							<th class='hidden-480 text-center' width='50'>P</th>
						</tr>
					</thead>
					<tbody>
					<tr>
						<th colspan='3' class='hidden-480 text-center'>Rata-rata Kelas</th>
						<th class='hidden-480 text-center'>$RNilSpr</th>
						<th class='hidden-480 text-center'>$RNilSos</th>
						<th class='hidden-480 text-center'>$RNilKDP</th>
						<th class='hidden-480 text-center'>$RUTS</th>
						<th class='hidden-480 text-center'>$RUAS</th>
						<th class='hidden-480 text-center'>$RNAD</th>
						<th class='hidden-480 text-center'>$PredikatP</th>
						<th class='hidden-480 text-center'>$RNilKDK</th>
						<th class='hidden-480 text-center'>$PredikatK</th>
						<th class='hidden-480 text-center'>$RNR</th>
						<th class='hidden-480 text-center'>$Deskripsi</th>
					</tr>
					$TampilData
					<tr>
						<th colspan='3' class='hidden-480 text-center'>Rata-rata Kelas</th>
						<th class='hidden-480 text-center'>$RNilSpr</th>
						<th class='hidden-480 text-center'>$RNilSos</th>
						<th class='hidden-480 text-center'>$RNilKDP</th>
						<th class='hidden-480 text-center'>$RUTS</th>
						<th class='hidden-480 text-center'>$RUAS</th>
						<th class='hidden-480 text-center'>$RNAD</th>
						<th class='hidden-480 text-center'>$PredikatP</th>
						<th class='hidden-480 text-center'>$RNilKDK</th>
						<th class='hidden-480 text-center'>$PredikatK</th>
						<th class='hidden-480 text-center'>$RNR</th>
						<th class='hidden-480 text-center'>$Deskripsi</th>
					</tr>
					</tbody>
				</table>
				</div>";
			}
			else{
				$Show.=nt("informasi","Data Siswa belum ada, silakan hubungi administrator");
			}
		}
		$tandamodal="#ReviewNilai";
		echo $ReviewNilai;
		echo IsiPanel($Show);
	break;

	case "deskripsi":
		$kbm=isset($_GET['kbm'])?$_GET['kbm']:""; 

 		$DataKDS=mysql_query("select * from gmp_kikd where kode_ngajar='$kbm' and kode_ranah='KDS'");
		$DataKDP=mysql_query("select * from gmp_kikd where kode_ngajar='$kbm' and kode_ranah='KDP'");
		$DataKDK=mysql_query("select * from gmp_kikd where kode_ngajar='$kbm' and kode_ranah='KDK'");

		$jmlKDS=mysql_num_rows($DataKDS);
		$jmlKDP=mysql_num_rows($DataKDP);
		$jmlKDK=mysql_num_rows($DataKDK);
		
		if($jmlKDS==0 && $jmlKDP==0 && $jmlKDK==0){
			$Show.=nt("informasi","<strong>Kompetensi Dasar </strong> belum di pilih, silakan isi dulu <a href='?page=gurumapel-data-kikd'>Kompetensi Dasar Mata Pelajaran</a>");
		}
		else{
			$Q=mysql_query("
			select 
			gmp_ngajar.id_ngajar,
			gmp_ngajar.thnajaran,
			gmp_ngajar.semester,
			gmp_ngajar.ganjilgenap,
			gmp_ngajar.kkmpeng, 
			gmp_ngajar.kkmket,
			gmp_ngajar.kd_mapel,
			ak_kelas.nama_kelas,
			ak_matapelajaran.nama_mapel,
			app_user_guru.nama_lengkap,
			ak_perkelas.nis,
			siswa_biodata.nm_siswa 
			from gmp_ngajar
			inner join ak_perkelas on gmp_ngajar.thnajaran=ak_perkelas.tahunajaran
			inner join ak_kelas on gmp_ngajar.kd_kelas=ak_kelas.kode_kelas and ak_kelas.nama_kelas=ak_perkelas.nm_kelas
			inner join app_user_guru on gmp_ngajar.kd_guru=app_user_guru.id_guru
			inner join ak_matapelajaran on gmp_ngajar.kd_mapel=ak_matapelajaran.kode_mapel
			inner join siswa_biodata on ak_perkelas.nis=siswa_biodata.nis
			where gmp_ngajar.id_ngajar='$kbm' order by siswa_biodata.nis");

			$jmlSiswa=mysql_num_rows($Q);
			$no=1;
			while($Hasil=mysql_fetch_array($Q)){
				$Matapel=$Hasil['nama_mapel'];
				$Kls=$Hasil['nama_kelas'];
				$GuruNgajar=$Hasil['nama_lengkap'];
				$ThnAjaran=$Hasil['thnajaran'];
				$Smstr=$Hasil['semester']." (".$Hasil['ganjilgenap'].")";
				$NISna=$Hasil['nis'];
				$NilaiKKMP=$Hasil['kkmpeng'];
				$NilaiKKMK=$Hasil['kkmket'];

				$DeskripsiKDP=LieurMeutakeunDeskripsi("select * from n_p_kikd where kd_ngajar='$kbm' and nis='$NISna'","select * from gmp_kikd,ak_kikd where gmp_kikd.kode_kikd=ak_kikd.id_kikd and gmp_kikd.kode_ngajar='$kbm' and gmp_kikd.kode_ranah='KDP' order by ak_kikd.no_kikd");

				$DeskripsiKDK=LieurMeutakeunDeskripsi("select * from n_k_kikd where kd_ngajar='$kbm' and nis='$NISna'","select * from gmp_kikd,ak_kikd where gmp_kikd.kode_kikd=ak_kikd.id_kikd and gmp_kikd.kode_ngajar='$kbm' and gmp_kikd.kode_ranah='KDK' order by ak_kikd.no_kikd");

				$TampilDesk.="
				<tr>
					<td class='hidden-480 text-center'>$no</td>
					<td>{$Hasil['nm_siswa']}</td>
					<td class='text-center'>{$Hasil['nis']}</td>
					<td class='hidden-480'>$DeskripsiKDP</td>
					<td class='hidden-480'>$DeskripsiKDK</td>
				</tr>";
				$no++;
			}

			$jmldata=mysql_num_rows($Q);
			if($jmldata>0){
				$ProfilKBM.=JudulKolom("Profil <em class='text-danger'>Kegiatan Belajar Mengajar</em>","");
				$ProfilKBM.="
				<dl class='dl-horizontal'>
				  <dt>Tahun Ajaran</dt><dd>$ThnAjaran</dd>
				  <dt>Semester</dt><dd>$Smstr</dd>
				  <dt>Mata Pelajaran</dt><dd>$Matapel</dd>
				  <dt>Kelas</dt><dd>$Kls</dd>
				  <dt>Nama Guru</dt><dd>$GuruNgajar</dd>
				  <dt>Jumlah KD K3</dt><dd>$jmlKDP (".Terbilang($jmlKDP).")</dd>
				  <dt>Jumlah KD K4</dt><dd>$jmlKDK (".Terbilang($jmlKDK).")</dd>
				  <dt>KKM K3</dt><dd>$NilaiKKMP (".Terbilang($NilaiKKMP).")</dd>
				  <dt>KKM K4</dt><dd>$NilaiKKMK (".Terbilang($NilaiKKMK).")</dd>
				  <dt>Jumlah Siswa</dt><dd>$jmldata (".Terbilang($jmldata).")</dd>
				</dl>";
				
				$Keterangan.=JudulKolom("Keterangan <em class='text-danger'>Singkatan</em>","");
				$Keterangan.="
				<dl class='dl-horizontal'>
				  <dt>SP</dt><dd>Nilai Sikap Spritual</dd>
				  <dt>SO</dt><dd>Nilai Sikap Sosial</dd>
				  <dt>NHP</dt><dd>Nilai Harian Pengetahuan di ambil dari nilai rata-rata per KD</dd>
				  <dt>UTS</dt><dd>Ujian Tengah Semester</dd>
				  <dt>UAS</dt><dd>Ujian Akhir Semester</dd>
				  <dt>NA</dt><dd>Nilai Akhir</dd>
				  <dt>P</dt><dd>Predikat</dd>
				</dl>";

				$Show.=ButtonKembali2("?page=$page","style='margin-top:-10px;'");
				$Show.="<a href='?page=$page&sub=reviewnilai&kbm=$kbm' class='btn btn-default btn-sm pull-right' style='margin-top:-10px;margin-right:10px'>Review Nilai</a>";
				$Show.=JudulKolom("Detail Deskripsi","clone");
				$Show.=DuaKolomSama($ProfilKBM,$Keterangan);	
				
				$Show.=Label("<span class='text-danger'>DESKRIPSI</span> <em>Nilai</em>");
				$Show.="
				<div class='table-responsive'>
				<table id='simple-table' class='table table-striped table-bordered table-hover'>
					<thead>
						<tr>
							<th class='hidden-480 text-center'>No.</th>
							<th class='text-center'>Nama Siswa</th>
							<th class='text-center'>NIS</th>
							<th class='hidden-480 text-center'>Deskripsi Pengetahuan</th>
							<th class='hidden-480 text-center'>Deskripsi Keterampilan</th>
						</tr>
					</thead>
					<tbody>
					$TampilDesk					
					</tbody>
				</table>
				</div>";
			}
			else{
				$Show.=InfoHal("Data Siswa belum ada, silakan hubungi administrator");
			}
		}

		$tandamodal="#DeskripsiNilai";
		echo $DeskripsiNilai;
		echo IsiPanel($Show);
	break;


	case "upload_nilai":
		$kbm=isset($_GET['kbm'])?$_GET['kbm']:"";
		$guru=isset($_GET['guru'])?$_GET['guru']:"";
		$thnajaran=isset($_GET['thnajaran'])?$_GET['thnajaran']:"";
		$gg=isset($_GET['gg'])?$_GET['gg']:"";

		$Q=mysql_query("select 
		gmp_ngajar.id_ngajar,
		gmp_ngajar.thnajaran,
		gmp_ngajar.semester,
		ak_kelas.nama_kelas,
		ak_matapelajaran.nama_mapel,
		app_user_guru.nama_lengkap
		from gmp_ngajar
		inner join ak_kelas on gmp_ngajar.kd_kelas=ak_kelas.kode_kelas
		inner join app_user_guru on gmp_ngajar.kd_guru=app_user_guru.id_guru
		inner join ak_matapelajaran on gmp_ngajar.kd_mapel=ak_matapelajaran.kode_mapel
		where gmp_ngajar.id_ngajar='$kbm'");
		$H=mysql_fetch_array($Q);
		$id_guru=$H['id_guru'];
		$Show.="
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
		</script>";
		
		$Keterangan.=nt("informasi","
		ID KBM <strong>{$H['id_ngajar']}</strong><br>Tahun Ajaran <strong>{$H['thnajaran']}</strong><br>Semester <strong>{$H['semester']}</strong><br>Kelas <strong>{$H['nama_kelas']}</strong><br>Mata Pelajaran <strong>{$H['nama_mapel']}</strong>","KBM");
	
		$UloadPerNilai.="
		<form name='myForm' id='myForm' onSubmit='return validateForm()' action='?page=$page&sub=nyimpenkabeh&guru=$guru&thnajaran=$thnajaran&gg=$gg&kbm=$kbm' method='post' enctype='multipart/form-data' class='smart-form'>
			<fieldset>
				<section>
					<label class='label'>Pilih File</label>
					<div class='input input-file'>
						<span class='button'>
						<input type='file' id='id-input-file-semua' name='semua' onchange='this.parentNode.nextSibling.value = this.value'>Browse</span><input type='text' placeholder='Include some files' readonly=''>
					</div>
				</section>
				<span class='help-block'>* file yang bisa di import adalah .xls (Excel 2003-2007).</span>
			</fieldset>
			<div class='form-actions center'>
				<button type='button submit' name='submit' class='btn btn-sm btn-success'>
					Submit
					<i class='ace-icon fa fa-arrow-right icon-on-right bigger-110'></i>
				</button>
			</div>
		</form>";
		
		$Show.=ButtonKembali2("?page=$page","style='margin-top:-10px;'");
		$Show.=JudulKolom("Proses Upload Seluruh Nilai","");
		$Show.=DuaKolomD(6,$Keterangan,6,KolomPanel($UloadPerNilai));

		echo $UploadNilaiMapel;
		echo IsiPanel($Show);
	break;

	case "nyimpenkabeh":
		$kbm=isset($_GET['kbm'])?$_GET['kbm']:"";
		$guru=isset($_GET['guru'])?$_GET['guru']:"";
		$thnajaran=isset($_GET['thnajaran'])?$_GET['thnajaran']:"";
		$gg=isset($_GET['gg'])?$_GET['gg']:"";

		require_once "pages/excel_reader.php"; 

		$data = new Spreadsheet_Excel_Reader($_FILES['semua']['tmp_name']);
		
		$NK1K2 = $data->rowcount($sheet_index=0);

		for ($i=2; $i<=$NK1K2; $i++) {
			$txtNo = $data->val($i,1,0);
			$txtKBM = $data->val($i,2,0);
			$txtNIS = $data->val($i,3,0);
			$txtNSis = $data->val($i,4,0);
			$txtSpritual = $data->val($i,5,0);
			$txtSosial = $data->val($i,6,0);
			$txtDescSSpr = $data->val($i,7,0);
			$txtDescSSos = $data->val($i,8,0);
			//$kd_nSikap=buatKode("n_sikap","ns_");
			mysql_query("INSERT INTO n_sikap VALUES ('','$txtKBM','$txtNIS','$txtSpritual','$txtSosial','$txtDescSSpr','$txtDescSSos')");
		}
		
		$NK3 = $data->rowcount($sheet_index=1);

		for ($i=2; $i<=$NK3; $i++) { 
			$txtNo = $data->val($i,1,1);
			$txtKBM = $data->val($i,2,1);
			$txtNIS = $data->val($i,3,1);
			$txtNSis = $data->val($i,4,1);
			$txtKDP_1 = $data->val($i,5,1);
			$txtKDP_2 = $data->val($i,6,1);
			$txtKDP_3 = $data->val($i,7,1);
			$txtKDP_4 = $data->val($i,8,1);
			$txtKDP_5 = $data->val($i,9,1);
			$txtKDP_6 = $data->val($i,10,1);
			$txtKDP_7 = $data->val($i,11,1);
			$txtKDP_8 = $data->val($i,12,1);
			$txtKDP_9 = $data->val($i,13,1);
			$txtKDP_10 = $data->val($i,14,1);
			$txtKDP_11 = $data->val($i,15,1);
			$txtKDP_12 = $data->val($i,16,1);
			$txtKDP_13 = $data->val($i,17,1);
			$txtKDP_14 = $data->val($i,18,1);
			$txtKDP_15 = $data->val($i,19,1);

			$jmlKDP=JmlDt("select * from gmp_kikd where kode_ngajar='$kbm' and kode_ranah='KDP'");	
			$NHP=round(($txtKDP_1+$txtKDP_2+$txtKDP_3+$txtKDP_4+$txtKDP_5+$txtKDP_6+$txtKDP_7+$txtKDP_8+$txtKDP_9+$txtKDP_10+$txtKDP_11+$txtKDP_12+$txtKDP_13+$txtKDP_14+$txtKDP_15)/$jmlKDP);

			mysql_query("insert into n_p_kikd values ('','$txtKBM','$txtNIS','$txtKDP_1','$txtKDP_2','$txtKDP_3','$txtKDP_4','$txtKDP_5','$txtKDP_6','$txtKDP_7','$txtKDP_8','$txtKDP_9','$txtKDP_10','$txtKDP_11','$txtKDP_12','$txtKDP_13','$txtKDP_14','$txtKDP_15','$NHP')");
		}


		$NUTSUAS = $data->rowcount($sheet_index=2);

		for ($i=2; $i<=$NUTSUAS; $i++) {
			$txtNo = $data->val($i,1,2);
			$txtKBM = $data->val($i,2,2);
			$txtNIS = $data->val($i,3,2);
			$txtNSis = $data->val($i,4,2);
			$txtUTS = $data->val($i,5,2);
			$txtUAS = $data->val($i,6,2);
			
			mysql_query("insert into n_utsuas values ('','$txtKBM','$txtNIS','$txtUTS','$txtUAS')");

		}

		$NK4 = $data->rowcount($sheet_index=3);

		for ($i=2; $i<=$NK4; $i++) {
			$txtNo = $data->val($i,1,3);
			$txtKBM = $data->val($i,2,3);
			$txtNIS = $data->val($i,3,3);
			$txtNSis = $data->val($i,4,3);
			$txtKDK_1 = $data->val($i,5,3);
			$txtKDK_2 = $data->val($i,6,3);
			$txtKDK_3 = $data->val($i,7,3);
			$txtKDK_4 = $data->val($i,8,3);
			$txtKDK_5 = $data->val($i,9,3);
			$txtKDK_6 = $data->val($i,10,3);
			$txtKDK_7 = $data->val($i,11,3);
			$txtKDK_8 = $data->val($i,12,3);
			$txtKDK_9 = $data->val($i,13,3);
			$txtKDK_10 = $data->val($i,14,3);
			$txtKDK_11 = $data->val($i,15,3);
			$txtKDK_12 = $data->val($i,16,3);
			$txtKDK_13 = $data->val($i,17,3);
			$txtKDK_14 = $data->val($i,18,3);
			$txtKDK_15 = $data->val($i,19,3);

			$jmlKDK=JmlDt("select * from gmp_kikd where kode_ngajar='$kbm' and kode_ranah='KDK'");	
			$NHK=round(($txtKDK_1+$txtKDK_2+$txtKDK_3+$txtKDK_4+$txtKDK_5+$txtKDK_6+$txtKDK_7+$txtKDK_8+$txtKDK_9+$txtKDK_10+$txtKDK_11+$txtKDK_12+$txtKDK_13+$txtKDK_14+$txtKDK_15)/$jmlKDK);

			mysql_query("INSERT INTO n_k_kikd VALUES ('','$txtKBM','$txtNIS','$txtKDK_1','$txtKDK_2','$txtKDK_3','$txtKDK_4','$txtKDK_5','$txtKDK_6','$txtKDK_7','$txtKDK_8','$txtKDK_9','$txtKDK_10','$txtKDK_11','$txtKDK_12','$txtKDK_13','$txtKDK_14','$txtKDK_15','$NHK')");
		}

		$Absen = $data->rowcount($sheet_index=4);

		for ($i=3; $i<=$Absen; $i++) {
			$txtNo = $data->val($i,1,4);
			$txtNIS = $data->val($i,2,4);
			$txtNSis = $data->val($i,3,4);
			$txtNsi = $data->val($i,4,4);
			$txtNTgl = $data->val($i,5,4);
			$txtNBln = $data->val($i,6,4);
			$txtNThn = $data->val($i,7,4);
			$txtNKet = $data->val($i,8,4);

			if($txtNTgl<10){$TglA="0".$txtNTgl;}else{$TglA=$txtNTgl;}
			if($txtNBln<10){$BlnA="0".$txtNBln;}else{$BlnA=$txtNBln;}
			$IsiTgl=$txtNThn."-".$BlnA."-".$TglA;
			
			$kd_absensi=buatKode("absensi_mapel","abs_");
			if($txtNIS==""){}else{
			mysql_query("INSERT INTO absensi_mapel VALUES ('$kd_absensi','$kbm','$txtNIS','$txtNsi','$IsiTgl','$txtNKet')");
			}
		}

		//echo '<div id="preloader"><div id="cssload"></div></div>';
		echo ns("Ngimpor","parent.location='?page=$page'","$kbm");
	break;

	case "perbaikan":
		$tnil=isset($_GET['tnil'])?$_GET['tnil']:""; 
		$kbm=isset($_GET['kbm'])?$_GET['kbm']:""; 
		$nis=isset($_GET['nis'])?$_GET['nis']:"";

		$QSiswa=mysql_query("select nm_siswa,nis from siswa_biodata where nis='$nis'");
		$HSiswa=mysql_fetch_array($QSiswa);

		$kkmna=mysql_query("SELECT kkmpeng,kkmket from gmp_ngajar WHERE id_ngajar='$kbm'");
		$HKKM=mysql_fetch_array($kkmna);

		//identifikasi nilai
		if($tnil=="k3"){
			$jmlKD=JmlDt("select * from gmp_kikd where kode_ngajar='$kbm' and kode_ranah='KDP'");
			$QN=mysql_query("SELECT * from n_p_kikd WHERE kd_ngajar='$kbm' AND nis='$nis'");
			$Hasil=mysql_fetch_array($QN);
			$iddb=$Hasil['kd_p_kikd'];
			$KKMnya=$HKKM['kkmpeng'];
			$Textnya="Pengetahuan (K3)";
			$FormNyimpan="<form action='?page=$page&sub=simpanedit&jnil=k3' method='post' name='FrmPerbaikan' id='FrmPerbaikan' role='form'>";
		}
		else if($tnil=="utsuas"){
			$jmlKD=JmlDt("select * from gmp_kikd where kode_ngajar='$kbm' and kode_ranah='KDP'");
			$QN=mysql_query("SELECT * from n_utsuas WHERE kd_ngajar='$kbm' AND nis='$nis'");
			$Hasil=mysql_fetch_array($QN);
			$iddb=$Hasil['kd_utsuas'];
			$KKMnya=$HKKM['kkmpeng'];
			$Textnya="UTS UAS";
			$FormNyimpan="<form action='?page=$page&sub=simpanedit&jnil=utsuas' method='post' name='FrmPerbaikan' id='FrmPerbaikan' role='form'>";
		}
		else if($tnil=="k4"){
			$jmlKD=JmlDt("select * from gmp_kikd where kode_ngajar='$kbm' and kode_ranah='KDK'");
			$QN=mysql_query("SELECT * from n_k_kikd WHERE kd_ngajar='$kbm' AND nis='$nis'");
			$Hasil=mysql_fetch_array($QN);
			$iddb=$Hasil['kd_k_kikd'];
			$KKMnya=$HKKM['kkmket'];
			$Textnya="Keterampilan (K4)";
			$FormNyimpan="<form action='?page=$page&sub=simpanedit&jnil=k4' method='post' name='FrmPerbaikan' id='FrmPerbaikan' role='form'>";
		}

		if($tnil=="k3" || $tnil=="k4"){
			for($x=1;$x<$jmlKD+1;$x++){
				$TampilNilai.="
					<tr height='30'>
						<td align='center'>$x</td>
						<td align='center'><input size='3' type='text' class='form-control input-sm' maxlength='3' value='".$Hasil['kd_'.$x]."' name='txtKD_".$x."[$i]'></td>
					</tr>			
				";
			}
		}
		else {
			$TampilNilai.="
				<tr height='30'>
					<td align='center'>1</td>
					<td align='center'>UTS</td>
					<td align='center'><input size='3' type='text' class='form-control input-sm' maxlength='3' value='".$Hasil['uts']."' name='txtuts'></td>
				</tr>
				<tr height='30'>
					<td align='center'>2</td>
					<td align='center'>UAS</td>
					<td align='center'><input size='3' type='text' class='form-control input-sm' maxlength='3' value='".$Hasil['uas']."' name='txtuas'></td>
				</tr>
			";

		}

		$Show.=ButtonKembali("?page=gmp-proses-penilaian&sub=reviewnilai&kbm=$kbm");
		$Show.="
		<div class='btn-group pull-right'>
			<button class='btn btn-default dropdown-toggle' data-toggle='dropdown' style='margin-top:-10px;margin-right:10px;'>
				<span class='label label-primary'>$Textnya</span> <span class='hidden-xs'></span><span class='caret'></span>
			</button>
			<ul class='dropdown-menu'>
				<li><a href='?page=gmp-proses-penilaian&sub=perbaikan&tnil=k3&kbm=$kbm&nis=$nis'>Pengetahuan</a>
				<li><a href='?page=gmp-proses-penilaian&sub=perbaikan&tnil=utsuas&kbm=$kbm&nis=$nis'>UTS UAS</a>
				<li><a href='?page=gmp-proses-penilaian&sub=perbaikan&tnil=k4&kbm=$kbm&nis=$nis'>Keterampilan</a>
			</ul>
		</div>";
		$Show.=JudulKolom("Edit Nilai ".$Textnya,"edit");
		$QPTK=mysql_query("
		SELECT gmp_ngajar.id_ngajar,app_user_guru.nip,app_user_guru.nama_lengkap,app_user_guru.gelardepan,app_user_guru.gelarbelakang
		from gmp_ngajar 
		INNER JOIN app_user_guru ON gmp_ngajar.kd_guru=app_user_guru.id_guru
		WHERE id_ngajar='$kbm'");
		$HPTK=mysql_fetch_array($QPTK);

		$QKBM=mysql_query("
		SELECT gmp_ngajar.id_ngajar,gmp_ngajar.thnajaran,gmp_ngajar.semester,gmp_ngajar.ganjilgenap,ak_kelas.nama_kelas, ak_matapelajaran.nama_mapel
		from gmp_ngajar 
		INNER JOIN ak_matapelajaran ON gmp_ngajar.kd_mapel=ak_matapelajaran.kode_mapel
		INNER JOIN ak_kelas ON gmp_ngajar.kd_kelas=ak_kelas.kode_kelas
		WHERE id_ngajar='$kbm'");
		$HKBM=mysql_fetch_array($QKBM);


		$Identitas.="
		<dl class='dl-horizontal' style='margin-bottom:0px;'>
		  <dt>Nomor DB : </dt><dd>$iddb</dd>
		  <dt>Nomor KBM : </dt><dd>$kbm</dd>
		</dl><br><br>";

		$Identitas.="
		<dl class='dl-horizontal' style='margin-bottom:0px;'>
		  <dt>Nama Pengajar : </dt><dd>{$HPTK['nama_lengkap']}</dd>
		  <dt>NIP : </dt><dd>{$HPTK['nip']}</dd>
		  <dt>Mata Pelajaran : </dt><dd>{$HKBM['nama_mapel']}</dd>
		  <dt>Tahun Pelajaran : </dt><dd>{$HKBM['thnajaran']}</dd>
		  <dt>Semester : </dt><dd>{$HKBM['semester']} ({$HKBM['ganjilgenap']})</dd>
		</dl><br><br>";

		$Identitas.="
		<dl class='dl-horizontal' style='margin-bottom:0px;'>
		  <dt>Nama Siswa : </dt><dd>{$HSiswa['nm_siswa']}</dd>
		  <dt>Nama Siswa : </dt><dd>$nis</dd>
		  <dt>Kelas : </dt><dd>{$HKBM['nama_kelas']}</dd>
		</dl>";
					
		$EditNilai.=JudulKolom("Nilai $Textnya","");
		$EditNilai.="
		$FormNyimpan
		<div class='well no-padding'>
		<input class='form-control input-sm' type='hidden' value='$iddb' name='txtIDDB'>
		<input class='form-control input-sm' type='hidden' value='".$Hasil['kd_k_kikd']."' name='txtKd[$i]'>
		<input class='form-control input-sm' type='hidden' value='".$kbm."' name='txtKBM'>
		<input class='form-control input-sm' type='hidden' value='".$nis."' name='txtNIS'>
		<input type='hidden'  value='".$jmlKD."' name='txtJKD'>
		<table class='table table-striped table-bordered table-hover table-condensed' width='100%'>
			<thead>
				<tr>
					<th class='text-center' data-class='expand'>No. KIKD</th>
					<th class='text-center' data-hide='phone'>Perbaikan</th>
				</tr>
			</thead>
			<tbody>$TampilNilai</tbody>
		</table>
		</div>";

		$EditNilai.="<div class='form-actions'>";
		$EditNilai.=bSubmit("SaveUpdate","Update");
		$EditNilai.="</div></form>";
		
		$Show.=DuaKolomD(8,$Identitas,4,$EditNilai);
		$tandamodal="#NgisiNilaiSiswa";
		echo $NgisiNilaiSiswa;
		echo IsiPanel($Show);
	break;

	case "simpanedit":
		$jnil=isset($_GET['jnil'])?$_GET['jnil']:""; 
	
		if($jnil=="k3"){ 
			$txtIDDB=$_POST['txtIDDB'];
			$txtKBM=$_POST['txtKBM'];
			$txtNIS=$_POST['txtNIS'];
			$txtJKD=$_POST['txtJKD'];

			foreach($_POST['txtKd'] as $i => $txtKd){
				$txtKD_1=$_POST['txtKD_1'][$i];
				$txtKD_2=$_POST['txtKD_2'][$i];
				$txtKD_3=$_POST['txtKD_3'][$i];
				$txtKD_4=$_POST['txtKD_4'][$i];
				$txtKD_5=$_POST['txtKD_5'][$i];
				$txtKD_6=$_POST['txtKD_6'][$i];
				$txtKD_7=$_POST['txtKD_7'][$i];
				$txtKD_8=$_POST['txtKD_8'][$i];
				$txtKD_9=$_POST['txtKD_9'][$i];
				$txtKD_10=$_POST['txtKD_10'][$i];
				$txtKD_11=$_POST['txtKD_11'][$i];
				$txtKD_12=$_POST['txtKD_12'][$i];
				$txtKD_13=$_POST['txtKD_13'][$i];
				$txtKD_14=$_POST['txtKD_14'][$i];
				$txtKD_15=$_POST['txtKD_15'][$i];
			}

			$NHP=round(($txtKD_1+$txtKD_2+$txtKD_3+$txtKD_4+$txtKD_5+$txtKD_6+$txtKD_7+$txtKD_8+$txtKD_9+$txtKD_10+$txtKD_11+$txtKD_12+$txtKD_13+$txtKD_14+$txtKD_15)/$txtJKD);
			mysql_query("UPDATE n_p_kikd SET kd_ngajar='$txtKBM',nis='$txtNIS',kd_1='$txtKD_1',kd_2='$txtKD_2',kd_3='$txtKD_3',kd_4='$txtKD_4',kd_5='$txtKD_5',kd_6='$txtKD_6',kd_7='$txtKD_7',kd_8='$txtKD_8',kd_9='$txtKD_9',kd_10='$txtKD_10',kd_11='$txtKD_11',kd_12='$txtKD_12',kd_13='$txtKD_13',kd_14='$txtKD_14',kd_15='$txtKD_15',kikd_p='$NHP' WHERE kd_p_kikd='$txtIDDB'");
			echo '<div id="preloader"><div id="cssload"></div></div>';
			echo ns("Ngedit","parent.location='?page=gmp-proses-penilaian&sub=perbaikan&tnil=k3&kbm=$txtKBM&nis=$txtNIS'","Nilai Pengetahuan dengan Kode KBM <strong class='text-primary'>$txtKBM </strong>");
		}
		else if($jnil=="k4"){ 
			$txtIDDB=$_POST['txtIDDB'];
			$txtKBM=$_POST['txtKBM'];
			$txtNIS=$_POST['txtNIS'];
			$txtJKD=$_POST['txtJKD'];

			foreach($_POST['txtKd'] as $i => $txtKd){
				$txtKD_1=$_POST['txtKD_1'][$i];
				$txtKD_2=$_POST['txtKD_2'][$i];
				$txtKD_3=$_POST['txtKD_3'][$i];
				$txtKD_4=$_POST['txtKD_4'][$i];
				$txtKD_5=$_POST['txtKD_5'][$i];
				$txtKD_6=$_POST['txtKD_6'][$i];
				$txtKD_7=$_POST['txtKD_7'][$i];
				$txtKD_8=$_POST['txtKD_8'][$i];
				$txtKD_9=$_POST['txtKD_9'][$i];
				$txtKD_10=$_POST['txtKD_10'][$i];
				$txtKD_11=$_POST['txtKD_11'][$i];
				$txtKD_12=$_POST['txtKD_12'][$i];
				$txtKD_13=$_POST['txtKD_13'][$i];
				$txtKD_14=$_POST['txtKD_14'][$i];
				$txtKD_15=$_POST['txtKD_15'][$i];
			}

			$NHP=round(($txtKD_1+$txtKD_2+$txtKD_3+$txtKD_4+$txtKD_5+$txtKD_6+$txtKD_7+$txtKD_8+$txtKD_9+$txtKD_10+$txtKD_11+$txtKD_12+$txtKD_13+$txtKD_14+$txtKD_15)/$txtJKD);
			mysql_query("UPDATE n_k_kikd SET kd_ngajar='$txtKBM',nis='$txtNIS',kd_1='$txtKD_1',kd_2='$txtKD_2',kd_3='$txtKD_3',kd_4='$txtKD_4',kd_5='$txtKD_5',kd_6='$txtKD_6',kd_7='$txtKD_7',kd_8='$txtKD_8',kd_9='$txtKD_9',kd_10='$txtKD_10',kd_11='$txtKD_11',kd_12='$txtKD_12',kd_13='$txtKD_13',kd_14='$txtKD_14',kd_15='$txtKD_15',kikd_k='$NHP' WHERE kd_k_kikd='$txtIDDB'");
			echo '<div id="preloader"><div id="cssload"></div></div>';
			echo ns("Ngedit","parent.location='?page=gmp-proses-penilaian&sub=perbaikan&tnil=k4&kbm=$txtKBM&nis=$txtNIS'","Nilai Keterampilan dengan Kode KBM <strong class='text-primary'>$txtKBM </strong>");
		}
		else {

			$txtIDDB=$_POST['txtIDDB'];
			$txtKBM=$_POST['txtKBM'];
			$txtNIS=$_POST['txtNIS'];
			$txtuts=$_POST['txtuts'];
			$txtuas=$_POST['txtuas'];

			mysql_query("UPDATE n_utsuas SET kd_ngajar='$txtKBM',nis='$txtNIS',uts='$txtuts',uas='$txtuas' WHERE kd_utsuas='$txtIDDB'");
			echo '<div id="preloader"><div id="cssload"></div></div>';
			echo ns("Ngedit","parent.location='?page=gmp-proses-penilaian&sub=perbaikan&tnil=utsuas&kbm=$txtKBM&nis=$txtNIS'","Nilai UTS dan UAS dengan Kode KBM <strong class='text-primary'>$txtKBM </strong>");			

		}
	break;

	case "HapusNilaiK1K2":
		$kbm=isset($_GET['kbm'])?$_GET['kbm']:"";
		mysql_query("DELETE FROM n_sikap WHERE kd_ngajar='$kbm'");
		echo ns("Hapus","parent.location='?page=$page'","Nilai K1 dan K2 dengan Kode KBM <strong class='text-primary'>$kbm</strong>");
	break;	
	case "HapusNilaiK3":
		$kbm=isset($_GET['kbm'])?$_GET['kbm']:"";
		mysql_query("DELETE FROM n_p_kikd WHERE kd_ngajar='$kbm'");
		echo ns("Hapus","parent.location='?page=$page'","Nilai K1 dan K2 dengan Kode KBM <strong class='text-primary'>$kbm</strong>");
	break;	
	case "HapusNilaiUTSUAS":
		$kbm=isset($_GET['kbm'])?$_GET['kbm']:"";
		mysql_query("DELETE FROM n_utsuas WHERE kd_ngajar='$kbm'");
		echo ns("Hapus","parent.location='?page=$page'","Nilai UTS dan UAS dengan Kode KBM <strong class='text-primary'>$kbm</strong>");
	break;	
	case "HapusNilaiK4":
		$kbm=isset($_GET['kbm'])?$_GET['kbm']:"";
		mysql_query("DELETE FROM n_k_kikd WHERE kd_ngajar='$kbm'");
		echo ns("Hapus","parent.location='?page=$page'","Nilai K1 dan K2 dengan Kode KBM <strong class='text-primary'>$kbm</strong>");
	break;	

}
echo '</div>';
include ("inc/footer.php");
include ("inc/scripts.php");
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


})

</script>