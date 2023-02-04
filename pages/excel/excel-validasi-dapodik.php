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

$kelas=isset($_GET['kelas'])?$_GET['kelas']:""; 
$thnajar=isset($_GET['thnajar'])?$_GET['thnajar']:""; 
$pk=isset($_GET['pk'])?$_GET['pk']:""; 
$tk=isset($_GET['tk'])?$_GET['tk']:""; 

require_once 'Classes/PHPExcel.php';
$objPHPExcel = new PHPExcel();

$objPHPExcel->getProperties()->setCreator("Abdul Madjid, SPd., M.Pd.")
							 ->setLastModifiedBy("Abdul Madjid, SPd., M.Pd.")
							 ->setTitle("VALIDASI DAPODIK")
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
$objPHPExcel->getActiveSheet()->setCellValue('B1', "Kelas");
$objPHPExcel->getActiveSheet()->setCellValue('C1', "NIS");
$objPHPExcel->getActiveSheet()->setCellValue('D1', "Nama Siswa"); 
$objPHPExcel->getActiveSheet()->setCellValue('E1', "NIK"); 
$objPHPExcel->getActiveSheet()->setCellValue('F1', "IBU"); 
$objPHPExcel->getActiveSheet()->setCellValue('G1', "AYAH"); 
$objPHPExcel->getActiveSheet()->setCellValue('H1', "ASAL SEKOLAH"); 
$objPHPExcel->getActiveSheet()->setCellValue('I1', "NO. PESERTA UN"); 
$objPHPExcel->getActiveSheet()->setCellValue('J1', "SERI IJAZAH"); 
$objPHPExcel->getActiveSheet()->setCellValue('K1', "SERI SKHUN"); 

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

cellColor('A1:K1', 'cccccc');

$baris=2;
$No=1;
$Q=mysql_query("select 
		ak_kelas.id_kls,
		ak_kelas.tingkat,
		ak_kelas.nama_kelas,
		ak_kelas.kode_pk,
		ak_kelas.tahunajaran,
		ak_perkelas.nis,
		dapodik_siswa.nik,
		dapodik_siswa.nama_siswa,
		dapodik_ortu.nm_ibu, 
		dapodik_ortu.nm_ayah,
		dapodik_registrasi.sekolahasal,
		dapodik_registrasi.nomorpesertaun,
		dapodik_registrasi.noseriijazah,
		dapodik_registrasi.noskhun
		from ak_kelas
		inner join ak_perkelas on ak_kelas.nama_kelas=ak_perkelas.nm_kelas and ak_kelas.tahunajaran=ak_perkelas.tahunajaran
		inner join dapodik_siswa on ak_perkelas.nis=dapodik_siswa.nis
		inner join dapodik_ortu on ak_perkelas.nis=dapodik_ortu.nis
		inner join dapodik_registrasi on ak_perkelas.nis=dapodik_registrasi.nis 
		where 
		ak_kelas.tingkat='$tk' and ak_kelas.tahunajaran='$thnajar' order by ak_kelas.nama_kelas,dapodik_siswa.nama_siswa");

while($H=mysql_fetch_array($Q)){
	$Tk=$H['tingkat'];
	if($H['nomorpesertaun']=='0-00-00-00-000-000-0'){$NosertaUN="";}else{$NosertaUN=$H['nomorpesertaun'];}
	$objPHPExcel->getActiveSheet()->setCellValue('A'.$baris, $No);
	$objPHPExcel->getActiveSheet()->setCellValue('B'.$baris, $H['nama_kelas']);
	$objPHPExcel->getActiveSheet()->setCellValue('C'.$baris, $H['nis']);
	$objPHPExcel->getActiveSheet()->setCellValue('D'.$baris, $H['nama_siswa']);
	$objPHPExcel->getActiveSheet()->setCellValue('E'.$baris, $H['nik']);
	$objPHPExcel->getActiveSheet()->setCellValue('F'.$baris, $H['nm_ibu']);
	$objPHPExcel->getActiveSheet()->setCellValue('G'.$baris, $H['nm_ayah']);
	$objPHPExcel->getActiveSheet()->setCellValue('H'.$baris, $H['sekolahasal']);
	$objPHPExcel->getActiveSheet()->setCellValue('I'.$baris, $NosertaUN);
	$objPHPExcel->getActiveSheet()->setCellValue('J'.$baris, $H['noseriijazah']);
	$objPHPExcel->getActiveSheet()->setCellValue('K'.$baris, $H['noskhun']);

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

	$objPHPExcel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('B'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('C'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('E'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('I'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	$objPHPExcel->getActiveSheet()->setCellValueExplicit('E'.$baris,$H['nik'],  PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->setCellValueExplicit('J'.$baris,$H['noseriijazah'],  PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->setCellValueExplicit('K'.$baris,$H['noskhun'],  PHPExcel_Cell_DataType::TYPE_STRING);

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
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);


$NamaFile=$Tk." - VALIDASI DAPODIK";
// Mencetak File Excel 
header('Content-Type: application/vnd.ms-excel'); 
header('Content-Disposition: attachment;filename="'.$NamaFile.'.xls"'); 
header('Cache-Control: max-age=0'); 
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
$objWriter->save('php://output');

?>
