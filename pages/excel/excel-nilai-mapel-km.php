<?php 
/* 02/07/2017 
Design and Programming By. Abdul Madjid, S.Pd., M.Pd.
SMK Negeri 1 Kadipaten
Pin 520543F3 HP. 0812-3000-0420
https://twitter.com/AbdoelMadjid 
https://www.facebook.com/abdulmadjid.mpd
*/
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING | E_DEPRECATED));
require_once 'koneksi.php';

$kbm=isset($_GET['kbm'])?$_GET['kbm']:""; 
$komp=isset($_GET['komp'])?$_GET['komp']:""; 
$mapel=isset($_GET['mapel'])?$_GET['mapel']:""; 
$kls=isset($_GET['kls'])?$_GET['kls']:""; 

require_once 'Classes/PHPExcel.php';
$objPHPExcel = new PHPExcel();

$objPHPExcel->getProperties()->setCreator("Abdul Madjid, SPd., M.Pd.")
							 ->setLastModifiedBy("Abdul Madjid, SPd., M.Pd.")
							 ->setTitle("NILAI MAPEL")
							 ->setCompany("SMKN 1 Kadipaten - Majalengka")
							 ->setCategory("LCKS 2017 - Excel");

// Set page orientation and size
//$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LEGAL);
$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0.75);
$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0.75);
$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0.75);
$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(0.75);
//$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' . $objPHPExcel->getProperties()->getTitle() . '&RPage &P of &N');

// Buat sebuah variabel untuk menampung pengaturan style dari header tabel
$style_col = array(
  'font' => array('bold' => true), // Set font nya jadi bold
  'alignment' => array(
	'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 
	'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER 
  ),
  'borders' => array(
	'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
	'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  
	'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
	'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
  )
);

// Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
$style_row = array(
  'alignment' => array(
	'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER 
  ),
  'borders' => array(
	'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
	'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  
	'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
	'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
  )
);
// Setting Worsheet yang aktif 
$objPHPExcel->setActiveSheetIndex(0);  

//Mencetak header berdasarkan field tabel
$objPHPExcel->getActiveSheet()->setCellValue('A1', "No.");
$objPHPExcel->getActiveSheet()->setCellValue('B1', "Kode KBM");
$objPHPExcel->getActiveSheet()->setCellValue('C1', "NIS");
$objPHPExcel->getActiveSheet()->setCellValue('D1', "Nama Siswa"); 
$objPHPExcel->getActiveSheet()->setCellValue('E1', "KD1"); 
$objPHPExcel->getActiveSheet()->setCellValue('F1', "KD2"); 
$objPHPExcel->getActiveSheet()->setCellValue('G1', "KD3"); 
$objPHPExcel->getActiveSheet()->setCellValue('H1', "KD4"); 
$objPHPExcel->getActiveSheet()->setCellValue('I1', "KD5"); 
$objPHPExcel->getActiveSheet()->setCellValue('J1', "KD6"); 
$objPHPExcel->getActiveSheet()->setCellValue('K1', "KD7"); 
$objPHPExcel->getActiveSheet()->setCellValue('L1', "KD8"); 
$objPHPExcel->getActiveSheet()->setCellValue('M1', "KD9"); 
$objPHPExcel->getActiveSheet()->setCellValue('N1', "KD10"); 
$objPHPExcel->getActiveSheet()->setCellValue('O1', "KD11"); 
$objPHPExcel->getActiveSheet()->setCellValue('P1', "KD12"); 
$objPHPExcel->getActiveSheet()->setCellValue('Q1', "KD13"); 
$objPHPExcel->getActiveSheet()->setCellValue('R1', "KD14"); 
$objPHPExcel->getActiveSheet()->setCellValue('S1', "KD15"); 
$objPHPExcel->getActiveSheet()->setCellValue('T1', "NA"); 
$objPHPExcel->getActiveSheet()->setCellValue('U1', "Nama Pengajar"); 
$objPHPExcel->getActiveSheet()->setCellValue('V1', "Mata Pelajaran"); 

$objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('F1')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('G1')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('H1')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('I1')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('J1')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('K1')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('L1')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('M1')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('N1')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('O1')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('P1')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('Q1')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('R1')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('S1')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('T1')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('U1')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('V1')->applyFromArray($style_col);

cellColor('A1:V1', 'cccccc');

if($komp=="keterampilan"){
	$baris=2;
	$No=1;
	$Q=mysql_query("select 
		siswa_biodata.nm_siswa, 
		app_user_guru.nama_lengkap,
		ak_matapelajaran.nama_mapel,
		n_k_kikd.*
		from n_k_kikd
		inner join siswa_biodata on n_k_kikd.nis=siswa_biodata.nis 
		inner join gmp_ngajar on n_k_kikd.kd_ngajar=gmp_ngajar.id_ngajar
		inner join app_user_guru on gmp_ngajar.kd_guru=app_user_guru.id_guru
		inner join ak_matapelajaran on gmp_ngajar.kd_mapel=ak_matapelajaran.kode_mapel
		where n_k_kikd.kd_ngajar='$kbm' order by siswa_biodata.nm_siswa,siswa_biodata.nis");
	while($H=mysql_fetch_array($Q)){
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$baris, $No);
		$objPHPExcel->getActiveSheet()->setCellValue('B'.$baris, $H['kd_ngajar']);
		$objPHPExcel->getActiveSheet()->setCellValue('C'.$baris, $H['nis']);
		$objPHPExcel->getActiveSheet()->setCellValue('D'.$baris, $H['nm_siswa']);
		$objPHPExcel->getActiveSheet()->setCellValue('E'.$baris, $H['kd_1']);
		$objPHPExcel->getActiveSheet()->setCellValue('F'.$baris, $H['kd_2']);
		$objPHPExcel->getActiveSheet()->setCellValue('G'.$baris, $H['kd_3']);
		$objPHPExcel->getActiveSheet()->setCellValue('H'.$baris, $H['kd_4']);
		$objPHPExcel->getActiveSheet()->setCellValue('I'.$baris, $H['kd_5']);
		$objPHPExcel->getActiveSheet()->setCellValue('J'.$baris, $H['kd_6']);
		$objPHPExcel->getActiveSheet()->setCellValue('K'.$baris, $H['kd_7']);
		$objPHPExcel->getActiveSheet()->setCellValue('L'.$baris, $H['kd_8']);
		$objPHPExcel->getActiveSheet()->setCellValue('M'.$baris, $H['kd_9']);
		$objPHPExcel->getActiveSheet()->setCellValue('N'.$baris, $H['kd_10']);
		$objPHPExcel->getActiveSheet()->setCellValue('O'.$baris, $H['kd_11']);
		$objPHPExcel->getActiveSheet()->setCellValue('P'.$baris, $H['kd_12']);
		$objPHPExcel->getActiveSheet()->setCellValue('Q'.$baris, $H['kd_13']);
		$objPHPExcel->getActiveSheet()->setCellValue('R'.$baris, $H['kd_14']);
		$objPHPExcel->getActiveSheet()->setCellValue('S'.$baris, $H['kd_15']);
		$objPHPExcel->getActiveSheet()->setCellValue('T'.$baris, $H['kikd_k']);
		$objPHPExcel->getActiveSheet()->setCellValue('U'.$baris, $H['nama_lengkap']);
		$objPHPExcel->getActiveSheet()->setCellValue('V'.$baris, $H['nama_mapel']);

		$objPHPExcel->getActiveSheet()->getStyle('A'.$baris)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('B'.$baris)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('C'.$baris)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('D'.$baris)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('E'.$baris)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('F'.$baris)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('G'.$baris)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('H'.$baris)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('I'.$baris)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('J'.$baris)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('K'.$baris)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('L'.$baris)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('M'.$baris)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('N'.$baris)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('O'.$baris)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('P'.$baris)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('Q'.$baris)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('R'.$baris)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('S'.$baris)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('T'.$baris)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('U'.$baris)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('V'.$baris)->applyFromArray($style_row);

		$objPHPExcel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('B'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('C'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('E'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('F'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('G'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('H'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('I'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('J'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('K'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('L'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('M'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('N'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('O'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('P'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('Q'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('R'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('S'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('T'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$baris++;
		$No++;
	}
}
else 
if($komp=="pengetahuan"){
	$baris=2;
	$No=1;
	$Q=mysql_query("select 
		siswa_biodata.nm_siswa, 
		app_user_guru.nama_lengkap,
		ak_matapelajaran.nama_mapel,
		n_p_kikd.*
		from n_p_kikd
		inner join siswa_biodata on n_p_kikd.nis=siswa_biodata.nis 
		inner join gmp_ngajar on n_p_kikd.kd_ngajar=gmp_ngajar.id_ngajar
		inner join app_user_guru on gmp_ngajar.kd_guru=app_user_guru.id_guru
		inner join ak_matapelajaran on gmp_ngajar.kd_mapel=ak_matapelajaran.kode_mapel
		where n_p_kikd.kd_ngajar='$kbm' order by siswa_biodata.nm_siswa,siswa_biodata.nis");
	while($H=mysql_fetch_array($Q)){
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$baris, $No);
		$objPHPExcel->getActiveSheet()->setCellValue('B'.$baris, $H['kd_ngajar']);
		$objPHPExcel->getActiveSheet()->setCellValue('C'.$baris, $H['nis']);
		$objPHPExcel->getActiveSheet()->setCellValue('D'.$baris, $H['nm_siswa']);
		$objPHPExcel->getActiveSheet()->setCellValue('E'.$baris, $H['kd_1']);
		$objPHPExcel->getActiveSheet()->setCellValue('F'.$baris, $H['kd_2']);
		$objPHPExcel->getActiveSheet()->setCellValue('G'.$baris, $H['kd_3']);
		$objPHPExcel->getActiveSheet()->setCellValue('H'.$baris, $H['kd_4']);
		$objPHPExcel->getActiveSheet()->setCellValue('I'.$baris, $H['kd_5']);
		$objPHPExcel->getActiveSheet()->setCellValue('J'.$baris, $H['kd_6']);
		$objPHPExcel->getActiveSheet()->setCellValue('K'.$baris, $H['kd_7']);
		$objPHPExcel->getActiveSheet()->setCellValue('L'.$baris, $H['kd_8']);
		$objPHPExcel->getActiveSheet()->setCellValue('M'.$baris, $H['kd_9']);
		$objPHPExcel->getActiveSheet()->setCellValue('N'.$baris, $H['kd_10']);
		$objPHPExcel->getActiveSheet()->setCellValue('O'.$baris, $H['kd_11']);
		$objPHPExcel->getActiveSheet()->setCellValue('P'.$baris, $H['kd_12']);
		$objPHPExcel->getActiveSheet()->setCellValue('Q'.$baris, $H['kd_13']);
		$objPHPExcel->getActiveSheet()->setCellValue('R'.$baris, $H['kd_14']);
		$objPHPExcel->getActiveSheet()->setCellValue('S'.$baris, $H['kd_15']);
		$objPHPExcel->getActiveSheet()->setCellValue('T'.$baris, $H['kikd_p']);
		$objPHPExcel->getActiveSheet()->setCellValue('U'.$baris, $H['nama_lengkap']);
		$objPHPExcel->getActiveSheet()->setCellValue('V'.$baris, $H['nama_mapel']);

		$objPHPExcel->getActiveSheet()->getStyle('A'.$baris)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('B'.$baris)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('C'.$baris)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('D'.$baris)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('E'.$baris)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('F'.$baris)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('G'.$baris)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('H'.$baris)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('I'.$baris)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('J'.$baris)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('K'.$baris)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('L'.$baris)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('M'.$baris)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('N'.$baris)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('O'.$baris)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('P'.$baris)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('Q'.$baris)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('R'.$baris)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('S'.$baris)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('T'.$baris)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('U'.$baris)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('V'.$baris)->applyFromArray($style_row);

		$objPHPExcel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('B'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('C'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('E'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('F'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('G'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('H'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('I'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('J'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('K'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('L'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('M'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('N'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('O'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('P'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('Q'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('R'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('S'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('T'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$baris++;
		$No++;
	}
}
else 
if($komp=="cp"){
	$baris=2;
	$No=1;
	$Q=mysql_query("select 
		siswa_biodata.nm_siswa, 
		app_user_guru.nama_lengkap,
		ak_matapelajaran.nama_mapel,
		n_p_kikd.*
		from n_p_kikd
		inner join siswa_biodata on n_p_kikd.nis=siswa_biodata.nis 
		inner join gmp_ngajar on n_p_kikd.kd_ngajar=gmp_ngajar.id_ngajar
		inner join app_user_guru on gmp_ngajar.kd_guru=app_user_guru.id_guru
		inner join ak_matapelajaran on gmp_ngajar.kd_mapel=ak_matapelajaran.kode_mapel
		where n_p_kikd.kd_ngajar='$kbm' order by siswa_biodata.nm_siswa,siswa_biodata.nis");
	while($H=mysql_fetch_array($Q)){
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$baris, $No);
		$objPHPExcel->getActiveSheet()->setCellValue('B'.$baris, $H['kd_ngajar']);
		$objPHPExcel->getActiveSheet()->setCellValue('C'.$baris, $H['nis']);
		$objPHPExcel->getActiveSheet()->setCellValue('D'.$baris, $H['nm_siswa']);
		$objPHPExcel->getActiveSheet()->setCellValue('E'.$baris, $H['kd_1']);
		$objPHPExcel->getActiveSheet()->setCellValue('F'.$baris, $H['kd_2']);
		$objPHPExcel->getActiveSheet()->setCellValue('G'.$baris, $H['kd_3']);
		$objPHPExcel->getActiveSheet()->setCellValue('H'.$baris, $H['kd_4']);
		$objPHPExcel->getActiveSheet()->setCellValue('I'.$baris, $H['kd_5']);
		$objPHPExcel->getActiveSheet()->setCellValue('J'.$baris, $H['kd_6']);
		$objPHPExcel->getActiveSheet()->setCellValue('K'.$baris, $H['kd_7']);
		$objPHPExcel->getActiveSheet()->setCellValue('L'.$baris, $H['kd_8']);
		$objPHPExcel->getActiveSheet()->setCellValue('M'.$baris, $H['kd_9']);
		$objPHPExcel->getActiveSheet()->setCellValue('N'.$baris, $H['kd_10']);
		$objPHPExcel->getActiveSheet()->setCellValue('O'.$baris, $H['kd_11']);
		$objPHPExcel->getActiveSheet()->setCellValue('P'.$baris, $H['kd_12']);
		$objPHPExcel->getActiveSheet()->setCellValue('Q'.$baris, $H['kd_13']);
		$objPHPExcel->getActiveSheet()->setCellValue('R'.$baris, $H['kd_14']);
		$objPHPExcel->getActiveSheet()->setCellValue('S'.$baris, $H['kd_15']);
		$objPHPExcel->getActiveSheet()->setCellValue('T'.$baris, $H['kikd_p']);
		$objPHPExcel->getActiveSheet()->setCellValue('U'.$baris, $H['nama_lengkap']);
		$objPHPExcel->getActiveSheet()->setCellValue('V'.$baris, $H['nama_mapel']);

		$objPHPExcel->getActiveSheet()->getStyle('A'.$baris)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('B'.$baris)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('C'.$baris)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('D'.$baris)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('E'.$baris)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('F'.$baris)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('G'.$baris)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('H'.$baris)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('I'.$baris)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('J'.$baris)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('K'.$baris)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('L'.$baris)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('M'.$baris)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('N'.$baris)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('O'.$baris)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('P'.$baris)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('Q'.$baris)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('R'.$baris)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('S'.$baris)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('T'.$baris)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('U'.$baris)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('V'.$baris)->applyFromArray($style_row);

		$objPHPExcel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('B'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('C'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('E'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('F'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('G'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('H'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('I'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('J'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('K'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('L'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('M'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('N'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('O'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('P'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('Q'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('R'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('S'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('T'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$baris++;
		$No++;
	}
}

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5.00);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('U')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('V')->setAutoSize(true);

$NamaFile=$kbm." - ".$kls." - ".$mapel." - ".$komp;
// Mencetak File Excel 
header('Content-Type: application/vnd.ms-excel'); 
header('Content-Disposition: attachment;filename="'.$NamaFile.'.xls"'); 
header('Cache-Control: max-age=0'); 
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
$objWriter->save('php://output');

?>
