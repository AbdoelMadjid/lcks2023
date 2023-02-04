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

$thnajar=isset($_GET['thnajar'])?$_GET['thnajar']:"";
$nkls=isset($_GET['nmkelas'])?$_GET['nmkelas']:"";
require_once 'Classes/PHPExcel.php';
$objPHPExcel = new PHPExcel();

$objPHPExcel->getProperties()->setCreator("Abdul Madjid, SPd., M.Pd.")
							 ->setLastModifiedBy("Abdul Madjid, SPd., M.Pd.")
							 ->setTitle("SISWA PER KELAS")
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
$objPHPExcel->getActiveSheet()->setCellValue('B1', "NIS");
$objPHPExcel->getActiveSheet()->setCellValue('C1', "Nama Siswa");
$objPHPExcel->getActiveSheet()->setCellValue('D1', "Cek Nama"); 
$objPHPExcel->getActiveSheet()->setCellValue('E1', "Alamat"); 

$objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray($style_col);

$sql = mysql_query("
SELECT * FROM 
ak_perkelas,
siswa_biodata 
where 
ak_perkelas.tahunajaran='$thnajar' and 
nm_kelas='$nkls' and 
ak_perkelas.nis=siswa_biodata.nis 
order by 
siswa_biodata.nm_siswa");
$baris=2;
$no = 1;
while($data = mysql_fetch_assoc($sql)){
	$sqlalamat = mysql_query("SELECT * FROM siswa_alamat where nis='".$data['nis']."'");
	$dalamat = mysql_fetch_assoc($sqlalamat);
	$alamat='RT '.$dalamat['rt'].' RW '.$dalamat['rw'].' Desa '.$dalamat['desa'].' Kecamatan '.$dalamat['kec'].' Kabupaten '.$dalamat['kab'];

	$objPHPExcel->getActiveSheet()->setCellValue('A'.$baris, $no);
	$objPHPExcel->getActiveSheet()->setCellValue('B'.$baris, $data['nis']);
	$objPHPExcel->getActiveSheet()->setCellValue('C'.$baris, $data['nm_siswa']);
	$objPHPExcel->getActiveSheet()->setCellValue('E'.$baris, $alamat);

	$objPHPExcel->getActiveSheet()->getStyle('A'.$baris)->applyFromArray($style_row);
	$objPHPExcel->getActiveSheet()->getStyle('B'.$baris)->applyFromArray($style_row);
	$objPHPExcel->getActiveSheet()->getStyle('C'.$baris)->applyFromArray($style_row);
	$objPHPExcel->getActiveSheet()->getStyle('D'.$baris)->applyFromArray($style_row);
	$objPHPExcel->getActiveSheet()->getStyle('E'.$baris)->applyFromArray($style_row);
	$baris++;
	$no++;
 }

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5.00);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);

$NamaFile="Siswa ".$thnajar." ".$nkls;
// Mencetak File Excel 
header('Content-Type: application/vnd.ms-excel'); 
header('Content-Disposition: attachment;filename="'.$NamaFile.'.xls"'); 
header('Cache-Control: max-age=0'); 
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
$objWriter->save('php://output');

?>