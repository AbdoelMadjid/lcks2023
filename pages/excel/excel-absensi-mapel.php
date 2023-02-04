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

$Q=mysql_query("select 
	siswa_biodata.nm_siswa, 
	app_user_guru.nama_lengkap,
	ak_matapelajaran.nama_mapel,
	gmp_absensi.*
	from gmp_absensi
	inner join siswa_biodata on gmp_absensi.nis=siswa_biodata.nis 
	inner join gmp_ngajar on gmp_absensi.kd_ngajar=gmp_ngajar.id_ngajar
	inner join app_user_guru on gmp_ngajar.kd_guru=app_user_guru.id_guru
	inner join ak_matapelajaran on gmp_ngajar.kd_mapel=ak_matapelajaran.kode_mapel
	where gmp_absensi.kd_ngajar='$kbm' order by siswa_biodata.nm_siswa,siswa_biodata.nis");

require_once 'Classes/PHPExcel.php';
$objPHPExcel = new PHPExcel();

$objPHPExcel->getProperties()->setCreator("Abdul Madjid, SPd., M.Pd.")
							 ->setLastModifiedBy("Abdul Madjid, SPd., M.Pd.")
							 ->setTitle("ABSENSI MATA PELAJARAN")
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
$objPHPExcel->getActiveSheet()->setCellValue('E1', "Absensi"); 
$objPHPExcel->getActiveSheet()->setCellValue('F1', "Tanggal"); 
$objPHPExcel->getActiveSheet()->setCellValue('G1', "Tanggal Lengkap"); 
$objPHPExcel->getActiveSheet()->setCellValue('H1', "Keterangan"); 

$objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('F1')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('G1')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('H1')->applyFromArray($style_col);

cellColor('A1:H1', 'cccccc');

$baris=2;
$No=1;


while($H=mysql_fetch_array($Q)){
	$objPHPExcel->getActiveSheet()->setCellValue('A'.$baris, $No);
	$objPHPExcel->getActiveSheet()->setCellValue('B'.$baris, $H['kd_ngajar']);
	$objPHPExcel->getActiveSheet()->setCellValue('C'.$baris, $H['nis']);
	$objPHPExcel->getActiveSheet()->setCellValue('D'.$baris, $H['nm_siswa']);
	$objPHPExcel->getActiveSheet()->setCellValue('E'.$baris, $H['absensi']);
	$objPHPExcel->getActiveSheet()->setCellValue('F'.$baris, $H['tgl']);
	$objPHPExcel->getActiveSheet()->setCellValue('G'.$baris, TglLengkap($H['tgl']));
	$objPHPExcel->getActiveSheet()->setCellValue('H'.$baris, $H['keterangan']);

	$objPHPExcel->getActiveSheet()->getStyle('A'.$baris)->applyFromArray($style_row);
	$objPHPExcel->getActiveSheet()->getStyle('B'.$baris)->applyFromArray($style_row);
	$objPHPExcel->getActiveSheet()->getStyle('C'.$baris)->applyFromArray($style_row);
	$objPHPExcel->getActiveSheet()->getStyle('D'.$baris)->applyFromArray($style_row);
	$objPHPExcel->getActiveSheet()->getStyle('E'.$baris)->applyFromArray($style_row);
	$objPHPExcel->getActiveSheet()->getStyle('F'.$baris)->applyFromArray($style_row);
	$objPHPExcel->getActiveSheet()->getStyle('G'.$baris)->applyFromArray($style_row);
	$objPHPExcel->getActiveSheet()->getStyle('H'.$baris)->applyFromArray($style_row);

	$objPHPExcel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('B'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('C'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	$baris++;
	$No++;
}

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5.00);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);

$NamaFile=$kbm." - ".$kls." - ".$mapel." - ".$komp;
// Mencetak File Excel 
header('Content-Type: application/vnd.ms-excel'); 
header('Content-Disposition: attachment;filename="'.$NamaFile.'.xls"'); 
header('Cache-Control: max-age=0'); 
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
$objWriter->save('php://output');

?>
