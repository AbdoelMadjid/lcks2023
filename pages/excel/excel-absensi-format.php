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

$kls=isset($_GET['kls'])?$_GET['kls']:""; 
$thnajaran=isset($_GET['thnajaran'])?$_GET['thnajaran']:""; 
$gg=isset($_GET['gg'])?$_GET['gg']:""; 

$QProfil=mysql_query("select * from app_lembaga");
$HProfil=mysql_fetch_array($QProfil);

$QKelas=mysql_query("select * from ak_kelas where id_kls='$kls'");
$HKelas=mysql_fetch_array($QKelas);

$NamaKelas=$HKelas['nama_kelas']." [".$HKelas['kode_kelas']."]";

require_once 'Classes/PHPExcel.php';
$objPHPExcel = new PHPExcel();

$objPHPExcel->getProperties()->setCreator("Abdul Madjid, SPd., M.Pd.")
							 ->setLastModifiedBy("Abdul Madjid, SPd., M.Pd.")
							 ->setTitle("Absensi Kelas ".$NamaKelas." - ".$thnajaran." - ".$gg)
							 ->setCompany("SMKN 1 Kadipaten - Majalengka")
							 ->setCategory("LCKS 2017 - Excel");

// Set page orientation and size
//$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LEGAL);
$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0.50);
$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0.50);
$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(1.00);
$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(1.50);
//$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&LHal: &P/&N - '.$objPHPExcel->getProperties()->getTitle());

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
$objPHPExcel->getActiveSheet()->setCellValue('A1', "NO.");
$objPHPExcel->getActiveSheet()->setCellValue('B1', "NIS");
$objPHPExcel->getActiveSheet()->setCellValue('C1', "NAMA SISWA");
$objPHPExcel->getActiveSheet()->setCellValue('D1', "SAKIT"); 
$objPHPExcel->getActiveSheet()->setCellValue('E1', "IZIN"); 
$objPHPExcel->getActiveSheet()->setCellValue('F1', "ALFA"); 

$objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('F1')->applyFromArray($style_col);

cellColor('A1:F1', 'cccccc');

$baris=2;
$QRangking=mysql_query("select * from ak_perkelas where nm_kelas='".$HKelas['nama_kelas']."' and tahunajaran='$thnajaran'");
$JmlData=mysql_num_rows($QRangking);
$no=1;
while($Hasil=mysql_fetch_array($QRangking)){
	$QSis=mysql_query("select nis,nm_siswa from siswa_biodata where nis='{$Hasil['nis']}'");
	$HSis=mysql_fetch_array($QSis);

	$objPHPExcel->getActiveSheet()->setCellValue('A'.$baris, $no);
	$objPHPExcel->getActiveSheet()->setCellValue('B'.$baris, $Hasil['nis']);
	$objPHPExcel->getActiveSheet()->setCellValue('C'.$baris, $HSis['nm_siswa']);


	$objPHPExcel->getActiveSheet()->getStyle('A'.$baris)->applyFromArray($style_row);
	$objPHPExcel->getActiveSheet()->getStyle('B'.$baris)->applyFromArray($style_row);
	$objPHPExcel->getActiveSheet()->getStyle('C'.$baris)->applyFromArray($style_row);
	$objPHPExcel->getActiveSheet()->getStyle('D'.$baris)->applyFromArray($style_row);
	$objPHPExcel->getActiveSheet()->getStyle('E'.$baris)->applyFromArray($style_row);
	$objPHPExcel->getActiveSheet()->getStyle('F'.$baris)->applyFromArray($style_row);

	$objPHPExcel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('B'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('D'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('E'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('F'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	$baris++;
	$no++;
}


$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5.00);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10.00);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10.00);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10.00);

$NamaFile="ABSENSI-".$HKelas['nama_kelas']."-".$thnajaran."-".$gg;
// Mencetak File Excel 
header('Content-Type: application/vnd.ms-excel'); 
header('Content-Disposition: attachment;filename="'.$NamaFile.'.xls"'); 
header('Cache-Control: max-age=0'); 
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
$objWriter->save('php://output');

?>