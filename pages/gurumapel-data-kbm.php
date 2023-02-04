<?php
require_once("inc/init.php");
require_once("inc/config.ui.php");
$page_title = "Data KBM";
$page_css[] = "your_style.css";
include("inc/header.php");
$page_nav["kbm"]["sub"]["datakbm"]["active"] = true;
include("inc/nav.php");
echo "<div id='main' role='main'>";
$breadcrumbs["Proses KBM"] = "";
include("inc/ribbon.php");

$sub=(isset($_GET['sub']))? $_GET['sub'] : "";
switch ($sub)
{
//	==> TAMPILAN AWAL <==
	case "tampil":default:
		$Q="
		select 
		gmp_ngajar.id_ngajar,
		gmp_ngajar.thnajaran,
		app_user_guru.nama_lengkap,
		ak_matapelajaran.nama_mapel,
		ak_kelas.nama_kelas,
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
		$MassaKBM="Tahun Ajaran $TahunAjarAktif Semester $SemesterAktif";
		$TAj=$TahunAjarAktif;
		$Smstr=$SemesterAktif;
		$NamaID="$NamaPengguna";

		$no=1;
		$Query=mysql_query("$Q order by gmp_ngajar.kd_kelas,gmp_ngajar.kd_mapel asc");
		while($Hasil=mysql_fetch_array($Query)){
			
			$NamaKelas=$Hasil['nama_kelas'];
			$NamaGuru=$Hasil['nama_lengkap'];
			$IDNGajar=$Hasil['id_ngajar'];

			$QJSiswa=mysql_query("select * from ak_perkelas where tahunajaran='".$TAj."' and nm_kelas='$NamaKelas'");
			$HJSiswa=mysql_num_rows($QJSiswa);
			
			$CekKBMK3=JmlDt("select kd_ngajar from n_p_kikd where kd_ngajar='{$Hasil['id_ngajar']}'");
			$CekKBMK4=JmlDt("select kd_ngajar from n_k_kikd where kd_ngajar='{$Hasil['id_ngajar']}'");
			$CekKBMUTSUAS=JmlDt("select kd_ngajar from n_utsuas where kd_ngajar='{$Hasil['id_ngajar']}'");

			if($CekKBMK3==0 || $CekKBMK4==0  || $CekKBMUTSUAS==0){
				$LaporanNilai="<button class='btn btn-default btn-sm btn-block'> <i class='fa fa-times font-lg text-danger'></i></button>";
			}
			else{
				$LaporanNilai="
				<div class='dropdown'>
					<a id='dLabel' role='button' data-toggle='dropdown' class='btn btn-default btn-block' data-target='#' href='javascript:void(0);'> {$Hasil['nama_kelas']} <span class='caret'></span> </a>
					<ul class='dropdown-menu multi-level' role='menu'>
						<li><a href='javascript:void(0);'>{$Hasil['nama_mapel']}</a></li>
						<li class='divider'></li>
						<li>
							<a href='javascript:void(0);' onClick=\"window.open('./pages/excel/ekspor-nilai.php?eksporex=laporan-nilai&kbm={$Hasil['id_ngajar']}&mapel={$Hasil['nama_mapel']}&kls={$Hasil['nama_kelas']}&thnajar=$TahunAjarAktif&semester=$SemesterAktif')\"><i class='fa fa-download'></i> Download</a>
						</li>
						<li>
							<a href='?page=$page&sub=nyetaklaporan&kbm={$Hasil['id_ngajar']}&mapel={$Hasil['nama_mapel']}&kls={$Hasil['nama_kelas']}&thnajar=$TahunAjarAktif&semester=$SemesterAktif'><i class='fa fa-print'></i> Cetak Laporan</a>
						</li>
					</ul>
				</div>";
			}

			$TampilData.="
			<tr>
				<td>$no.</td>
				<td>{$Hasil['id_guru']} {$Hasil['nama_lengkap']}<br><span class='text-danger'>{$Hasil['nama_mapel']}</span></td>
				<td>{$Hasil['nama_kelas']}</td>
				<td>{$HJSiswa}</td>
				<td>{$Hasil['kkmpeng']}</td>
				<td>{$Hasil['kkmket']}</td>
				<td>
					<a href='?page=$page&sub=edit&idngajar={$Hasil['id_ngajar']}' class='btn btn-default btn-sm btn-block' rel='tooltip' data-placement='top' data-original-title='Edit KBM {$Hasil['nama_mapel']}'><span class='hidden-xs'><i class='fa fa-pencil font-lg'></i></span><span class='hidden-lg'>Edit KBM {$Hasil['nama_mapel']}</span></a>
				</td>
				<td>
					<button type='button' class='viewDetailKBM btn btn-default btn-sm btn-block' data-toggle='modal' id='".$Hasil["id_ngajar"]."' data-target='#myModal' rel='tooltip' data-placement='top' data-original-title='Detail KBM {$Hasil['nama_mapel']}'><span class='hidden-xs'><i class='fa fa-th font-lg'></i></span><span class='hidden-lg'>Detail KBM dan Hasil Input Nilai</span></button>
				</td>
				<td width='100'>$LaporanNilai</td>
				$Aksikbm
			</tr>";
			$no++;
		}
	
		$jmldata=mysql_num_rows($Query);
		if($jmldata>0){
			$DataKBM.=Label($MassaKBM);
			$DataKBM.="
			<div class='well no-padding'>
				<table id='dt_basic' class='table table-striped table-bordered table-hover table-condensed' width='100%'>
					<thead>
						<tr>
							<th class='text-center' data-class='expand'>No.</th>
							<th class='text-center'>Nama Guru / Mapel</th>
							<th class='text-center' width='75'>Kelas</th>
							<th class='text-center' data-hide='phone,tablet'>JML SISWA</th>
							<th class='text-center' data-hide='phone,tablet'>KKM K3</th>
							<th class='text-center' data-hide='phone,tablet'>KKM K4</th>
							<th class='text-center' data-hide='phone,tablet'>Edit</th>
							<th class='text-center' data-hide='phone,tablet'>Detail</th>
							<th class='text-center' data-hide='phone,tablet'>Laporan</th>
							$KalimatAksi
						</tr>
					</thead>
					<tbody>$TampilData</tbody>
				</table>
			</div>";
		}
		else{
			$DataKBM.='<div class="well"><p class="text-center"><img src="img/aa.png" width="100" height="231" border="0" alt=""></p><h1 class="text-center"><small class="text-danger slideInRight fast animated"><strong>Data KBM Belum Ditambahkan!</strong></small></h1></div>';
		}
		echo FormModalDetail("myModal","Detail KBM","data_kbm");
		echo $DataKBMGuru;
		$tandamodal="#DataKBMGuru";
		echo MyWidget('fa-briefcase',"Data KBM <b><em>$NamaID</em></b>","",$DataKBM);		
	break;

//	==> EDIT NGAJAR <==
	case "edit":
		$KBMEdit=isset($_GET['idngajar'])?$_GET['idngajar']:""; 

		NgambilData("
		select 
		gmp_ngajar.id_ngajar,
		gmp_ngajar.thnajaran,
		gmp_ngajar.kd_mapel,
		gmp_ngajar.kd_guru,
		gmp_ngajar.kd_kelas,
		app_user_guru.id_guru,
		app_user_guru.nama_lengkap,
		ak_paketkeahlian.kode_pk,
		ak_paketkeahlian.nama_paket,
		ak_matapelajaran.kode_mapel,
		ak_matapelajaran.nama_mapel,
		ak_matapelajaran.jenismapel,
		ak_kelas.kode_kelas,
		ak_kelas.nama_kelas,
		gmp_ngajar.semester,
		gmp_ngajar.ganjilgenap,
		gmp_ngajar.kkmpeng,
		gmp_ngajar.kkmket
		from gmp_ngajar
		inner join ak_kelas on gmp_ngajar.kd_kelas=ak_kelas.kode_kelas
		inner join app_user_guru on gmp_ngajar.kd_guru=app_user_guru.id_guru
		inner join ak_paketkeahlian on gmp_ngajar.kd_pk=ak_paketkeahlian.kode_pk
		inner join ak_matapelajaran on gmp_ngajar.kd_mapel=ak_matapelajaran.kode_mapel
		where gmp_ngajar.id_ngajar='$KBMEdit'");
		
		if($_SESSION['SMART_GURU']=="Guru"){
			$Protek="readonly='readonly'";
		}
		else{
			$Protek="readonly='readonly'";
		}

		$Show.=ButtonKembali2("?page=$page","style='margin-top:-8px;'");
		$Show.=JudulKolom("Edit <span class='text-danger'>Data KBM</span>","pencil-square-o");
		$Show.="<form action='?page=$page&sub=simpanedit' method='post' name='frmEdit' class='form-horizontal' role='form'>";
		$Show.='<fieldset>';

		$Show.=FormIF("horizontal","Id Ngajar","txtKBM",$KBMEdit,"2","readonly=readonly");
		
		$Show.=FormCF("horizontal","Tahun Ajaran","txtThnAjar","select * from ak_tahunajaran","tahunajaran",$thnajaran,"tahunajaran","2",$Protek);
		
		$Show.=FormCF("horizontal","Nama Pengajar","txtIDGuru","select * from app_user_guru order by nama_lengkap","id_guru",$id_guru,"nama_lengkap","4",$Protek);
		
		$Show.=FormCF("horizontal","Paket Keahlian","txtKodePK","select * from ak_paketkeahlian","kode_pk",$kode_pk,"nama_paket","4",$Protek);
		
		$Show.=FormCF("horizontal","Mata Pelajaran","txtKodeMapel","select * from ak_matapelajaran where kode_pk='$kode_pk'","kode_mapel",$kode_mapel,"nama_mapel","4",$Protek);
				
		$Show.=FormIF("horizontal","Jenis Mapel","txtJenisMapel",$jenismapel,'2',$Protek);

		$Show.=FormCF("horizontal","Kelas","txtKodeKls","select * from ak_kelas where kode_pk='$kode_pk' and tahunajaran='$thnajaran'","kode_kelas",$kode_kelas,"nama_kelas","2",$Protek);

		$Show.=FormCR("horizontal","Semester","txtSmster",$semester,$Ref->Semester,"2",$Protek);

		$Show.=FormIF("horizontal","Ganjil Genap","TxtGG",$ganjilgenap,'2',$Protek);
		$Show.=FormIF("horizontal","KKM Pengetahuan","TxtKKMP",$kkmpeng,'2',"");
		$Show.=FormIF("horizontal","KKM Keterampilan","TxtKKMK",$kkmket,'2',"");
		$Show.='</fieldset>';
		$Show.='<div class="form-actions">'.bSubmit("BtnEdit","Simpan").'</div>';
		$Show.='</form>';

		echo $GMPDataKBMEdit;
		$tandamodal="#GMPDataKBMEdit";

		echo IsiPanel($Show);
	break;

//	==> SIMPAN EDIT NGAJAR<==
	case "simpanedit":
		$txtKBM=addslashes($_POST['txtKBM']);
		$txtThnAjar=addslashes($_POST['txtThnAjar']);
		$txtIDGuru=addslashes($_POST['txtIDGuru']);
		$txtKodePK=addslashes($_POST['txtKodePK']);
		$txtKodeMapel=addslashes($_POST['txtKodeMapel']);
		$txtJenisMapel=addslashes($_POST['txtJenisMapel']);
		$txtKodeKls=addslashes($_POST['txtKodeKls']);
		$txtSmster=addslashes($_POST['txtSmster']);
		$TxtGG=addslashes($_POST['TxtGG']);
		$TxtKKMP=addslashes($_POST['TxtKKMP']);
		$TxtKKMK=addslashes($_POST['TxtKKMK']);
		mysql_query("UPDATE gmp_ngajar SET thnajaran='$txtThnAjar', kd_guru='$txtIDGuru', kd_pk='$txtKodePK', kd_mapel='$txtKodeMapel', jenismapel='$txtJenisMapel',  kd_kelas='$txtKodeKls', semester='$txtSmster',ganjilgenap='$TxtGG',kkmpeng='$TxtKKMP',kkmket='$TxtKKMK' WHERE id_ngajar='$txtKBM'");
		echo '<div id="preloader"><div id="cssload"></div></div>';
		echo ns("Ngedit","parent.location='?page=$page'","dengan Kode KBM <strong class='text-warning'>$txtKBM</strong>");
	break;

//	==> NYETAK LAPORAN <==

	case "nyetaklaporan":
		$kbm=isset($_GET['kbm'])?$_GET['kbm']:""; 
		$mapel=isset($_GET['mapel'])?$_GET['mapel']:""; 
		$kls=isset($_GET['kls'])?$_GET['kls']:""; 
		$thnajar=isset($_GET['thnajar'])?$_GET['thnajar']:""; 
		$semester=isset($_GET['semester'])?$_GET['semester']:""; 

		$QProfil=mysql_query("select * from app_lembaga");
		$HProfil=mysql_fetch_array($QProfil);

		$Nyetak.="
		<script>
		function printContent(el){
			var restorepage=document.body.innerHTML;
			var printcontent=document.getElementById(el).innerHTML;
			document.body.innerHTML=printcontent;
			window.print();
			document.body.innerHTML=restorepage;
		}
		</script>";

		$Nyetak.=ButtonKembali2("?page=$page","style='margin-top:-10px;'");
		$Nyetak.= "<a href='javascript:void(0);' class='btn btn-default btn-sm pull-right' style='margin-top:-10px;margin-right:10px;' onclick=\"printContent('cetak')\"> <i class='fa fa-print'></i> <span class='hidden-xs'>Cetak</span></a>";

		$Nyetak.=JudulKolom("Cetak Laporan Nilai","print");
		$Nyetak.="
		<div id='cetak'>
		<table style='margin: 0 auto;width:100%;border-collapse:collapse;font:12px Times New Roman;'>
		<tr>
			<td colspan='11' align='center'><font size='4'><strong>LAPORAN NILAI SEMESTER</strong></font></td>
		</tr>
		<tr>
			<td colspan='11'>&nbsp;</td>
		</tr>
		<tr>
			<td width='100'>Tahun Ajaran</td>
			<td>: $thnajar</td>
		</tr>
		<tr>
			<td>Semester</td>
			<td>: $semester</td>
		</tr>
		<tr>
			<td>Kelas</td>
			<td>: $kls</td>
		</tr>
		<tr>
			<td>Mata Pelajaran</td>
			<td>: $mapel</td>
		</tr>
		<tr>
			<td colspan=14>&nbsp;<td>
		</tr>
		</table>
		<table style='margin: 0 auto;width:100%;border-collapse:collapse;font:12px Times New Roman;' border='1'>
			<thead>
				<tr>
					<th rowspan='2' width='20'>No.</th>
					<th rowspan='2' width='75'>NIS</th>
					<th rowspan='2'>Nama Siswa</th>
					<th colspan='2'>NK1K2</th>
					<th colspan='2'>NK3</th>
					<th colspan='2'>NK4</th>
					<th rowspan='2' width='50'>R2</th>
					<th rowspan='2' width='50'>PS</th>
				</tr>
				<tr>
					<th width='50'>SP</th>
					<th width='50'>SO</th>
					<th width='50'>NA</th>
					<th width='50'>P</th>
					<th width='50'>NA</th>
					<th width='50'>P</th>
				</tr>
			</thead>
			<tbody>";

			$Q=mysql_query("
			select 
			gmp_ngajar.id_ngajar,
			gmp_ngajar.thnajaran,
			gmp_ngajar.semester,
			gmp_ngajar.ganjilgenap,
			gmp_ngajar.kkmpeng, 
			gmp_ngajar.kkmket,
			ak_kelas.nama_kelas,
			gmp_ngajar.kd_mapel,
			ak_matapelajaran.nama_mapel,
			app_user_guru.nama_lengkap,
			app_user_guru.nip,
			ak_perkelas.nis,
			siswa_biodata.nm_siswa 
			from 
			gmp_ngajar,
			app_user_guru,
			ak_matapelajaran,
			ak_kelas,
			ak_perkelas,
			siswa_biodata 
			where 
			gmp_ngajar.thnajaran=ak_perkelas.tahunajaran and 
			gmp_ngajar.kd_kelas=ak_kelas.kode_kelas and 
			gmp_ngajar.kd_guru=app_user_guru.id_guru and 
			gmp_ngajar.kd_mapel=ak_matapelajaran.kode_mapel and 
			ak_kelas.nama_kelas=ak_perkelas.nm_kelas and 
			ak_perkelas.nis=siswa_biodata.nis and 
			gmp_ngajar.id_ngajar='$kbm' order by siswa_biodata.nm_siswa,siswa_biodata.nis");

			$jmlSiswa=mysql_num_rows($Q);

			$no=1;

			while($Hasil=mysql_fetch_array($Q)){
				$Matapel=$Hasil['nama_mapel'];
				$Kls=$Hasil['nama_kelas'];
				$GuruNgajar=$Hasil['nama_lengkap'];
				$GuruNgajarNIP=$Hasil['nip'];
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
				
				$Nyetak.="
				<tr>
					<td align='center'>$no</td>
					<td align='center'>{$Hasil['nis']}</td>
					<td width='350'>&nbsp;&nbsp;{$Hasil['nm_siswa']}</td>
					<td align='center'>$NSpritual</td>
					<td align='center'>$NSosial</td>
					<td align='center'>$NAP</td>
					<td align='center'>$PredP</td>
					<td align='center'>{$NKDK['kikd_k']}</td>
					<td align='center'>$PredK</td>
					<td align='center' width='50'>$R2</td>
					<td align='center'>$PredSw</td>
				</tr>";
				$no++;
			}
			$jmldata=mysql_num_rows($Q);
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

			$tglSekarang=date('Y-m-d');
		
		$Nyetak.="
			<tr>
				<th colspan='3'>Rata-rata Kelas</th>
				<th>$RNilSpr</th>
				<th>$RNilSos</th>
				<th>$RNAD</th>
				<th>$PredikatP</th>
				<th>$RNilKDK</th>
				<th>$PredikatK</th>
				<th>$RNR</th>
				<th>$Deskripsi</th>
			</tr>
			</tbody>
		</table>
		<table style='margin: 0 auto;width:100%;border-collapse:collapse;font:12px Times New Roman;'>
		<tr>
			<td>&nbsp;<td>
			<td>&nbsp;<td>
			<td>&nbsp;<td>
			<td>&nbsp;<td>
			<td>&nbsp;<td>
			<td>&nbsp;<td>
			<td>&nbsp;<td>
			<td>&nbsp;<td>
			<td>&nbsp;<td>
			<td>&nbsp;<td>
			<td>&nbsp;<td>
		</tr>
		<tr>
			<td colspan='3'>Mengetahui : <td>
			<td colspan='3' width='200'>&nbsp;<td>
			<td colspan='5'>{$HProfil['kecamatan']}, ".TglLengkap($tglSekarang)."<td>
		</tr>
		<tr>
			<td colspan='3'>Kepala Sekolah<td>
			<td colspan='3'>&nbsp;<td>
			<td colspan='5'>Guru Mata Pelajaran<td>
		</tr>
		<tr>
			<td colspan='3'>&nbsp;<td>
			<td colspan='3'>&nbsp;<td>
			<td colspan='5'>&nbsp;<td>
		</tr>
		<tr>
			<td colspan='3'>&nbsp;<td>
			<td colspan='3'>&nbsp;<td>
			<td colspan='5'>&nbsp;<td>
		</tr>
		<tr>
			<td colspan='3'>&nbsp;<td>
			<td colspan='3'>&nbsp;<td>
			<td colspan='5'>&nbsp;<td>
		</tr>
		<tr>
			<td colspan='3'><u><strong>{$NamaKepsek}</strong></u><td>
			<td colspan='3'>&nbsp;<td>
			<td colspan='5'><u><strong>$GuruNgajar</strong></u><td>
		</tr>
		<tr>
			<td colspan='3'>NIP. {$NIPKepsek}<td>
			<td colspan='3'>&nbsp;<td>
			<td colspan='5'>NIP. $GuruNgajarNIP<td>
		</tr>
		</table>
		</div>";
		echo IsiPanel($Nyetak);
	break;

//	==> PROSES PILIHAN DATA KBM MASTER <==
	case "updatepilihan":
		$milih=isset($_GET['milih'])?$_GET['milih']:"";
		mysql_query("update app_pilh_data set duapilihan='$milih',tahunajaran='',semester='',tingkat='',idna='' where id_pil='$IDna'");
		echo "<meta http-equiv='refresh' content='0; url=?page=gmp-data-kbm'>";
	break;

	case "updatepilta":
		$pilthaj=isset($_GET['pilthaj'])?$_GET['pilthaj']:"";
		mysql_query("update app_pilh_data set tahunajaran='$pilthaj' where id_pil='$IDna'");
		echo "<meta http-equiv='refresh' content='0; url=?page=gmp-data-kbm'>";
	break;

	case "updatepilsmstr":
		$pilsmstr=isset($_GET['pilsmstr'])?$_GET['pilsmstr']:"";
		mysql_query("update app_pilh_data set semester='$pilsmstr' where id_pil='$IDna'");
		echo "<meta http-equiv='refresh' content='0; url=?page=gmp-data-kbm'>";
	break;

	case "updatepilkelas":
		$pilkelas=isset($_GET['pilkelas'])?$_GET['pilkelas']:"";
		NgambilData("select * from ak_kelas where kode_kelas='$pilkelas'");
		mysql_query("update app_pilh_data set idna='$pilkelas' where id_pil='$IDna'");
		//echo '<div id="preloader"><div id="cssload"></div></div>';
		//echo ns("Milih","parent.location='?page=$page'","Kelas $nama_kelas");
		echo "<meta http-equiv='refresh' content='0; url=?page=gmp-data-kbm'>";
	break;

	case "updatepilguru":
		$pilguru=isset($_GET['pilguru'])?$_GET['pilguru']:"";
		mysql_query("update app_pilh_data set idna='$pilguru' where id_pil='$IDna'");
		//echo '<div id="preloader"><div id="cssload"></div></div>';
		//echo ns("Milih","parent.location='?page=$page'");
		echo "<meta http-equiv='refresh' content='0; url=?page=gmp-data-kbm'>";
	break;

	case "updatepiltingkat":
		$piltingkat=isset($_GET['piltingkat'])?$_GET['piltingkat']:"";
		mysql_query("update app_pilh_data set tingkat='$piltingkat' where id_pil='$IDna'");
		echo '<div id="preloader"><div id="cssload"></div></div>';
		echo "<meta http-equiv='refresh' content='0; url=?page=gmp-data-kbm'>";
	break;

}
echo '</div>';
include("inc/footer.php");
include("inc/scripts.php");
//"))
?>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/datatables/dataTables.colVis.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/datatables/dataTables.tableTools.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/datatables/dataTables.bootstrap.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/datatable-responsive/datatables.responsive.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	var a={
		"hapuskbm":function(a){
			function b(){
				window.location=a.attr("href")
			}
			$.SmartMessageBox(
				{
					"title":"<h1 style='margin-top:-5px;'><i class='fa fa-fw fa-question-circle bounce animated text-primary'></i><small class='text-primary'><strong> Konfirmasi</strong></small></h1>",
					"content":a.data("hapuskbm-msg"),
					"buttons":"[No][Yes]"
				},function(a){
					"Yes"==a&&($.root_.addClass("animated fadeOutUp"),setTimeout(b,1e3))
					}
		)}
	}
	$.root_.on("click",'[data-action="hapuskbm"]',function(b){var c=$(this);a.hapuskbm(c),b.preventDefault(),c=null});


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

		$('.viewDetailKBM').click(function(){
			var id = $(this).attr("id");
			$.ajax({
				url: 'lib/app_modal.php?md=DataKBM',
				method: 'post',
				data: {id:id},
				success:function(data){	
					$('#data_kbm').html(data);
					$('#myModal').modal("show");
				}
			});
		});
})
</script>
