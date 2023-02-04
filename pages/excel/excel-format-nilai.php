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

$DataKDS=mysql_query("select * from gmp_kikd where kode_ngajar='$kbm' and kode_ranah='KDS'");
$DataKDP=mysql_query("select * from gmp_kikd where kode_ngajar='$kbm' and kode_ranah='KDP'");
$DataKDK=mysql_query("select * from gmp_kikd where kode_ngajar='$kbm' and kode_ranah='KDK'");

$jmlKDS=mysql_num_rows($DataKDS);
$jmlKDP=mysql_num_rows($DataKDP);
$jmlKDK=mysql_num_rows($DataKDK);

$Q=mysql_query("
select 
ak_perkelas.nis,
siswa_biodata.nm_siswa,
gmp_ngajar.thnajaran,
gmp_ngajar.semester,
gmp_ngajar.ganjilgenap
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
gmp_ngajar.id_ngajar='$kbm' order by siswa_biodata.nm_siswa,ak_perkelas.nis");
//$H=mysql_fetch_array($Q);

require_once 'Classes/PHPExcel.php';
$objPHPExcel = new PHPExcel();

if($komp=="K3"){$TNil="PENGETAHUAN (K3)";}else
if($komp=="K4"){$TNil="KETERAMPILAN (K4)";}else
if($komp=="UTSUAS"){$TNil="UTS - UAS";}else
if($komp=="K1K2"){$TNil="SPRITUAL DAN SOSIAL (K1 DAN K2)";}

$ThnAjaran=$H['thnajaran'];
$Semstr=$H['semester']." (".$H['ganjilgenap'].")";

$objPHPExcel->getProperties()->setCreator("Abdul Madjid, SPd., M.Pd.")
							 ->setLastModifiedBy("Abdul Madjid, SPd., M.Pd.")
							 ->setTitle($TNil." ".$kls." ".$mapel)
							 ->setCompany("SMKN 1 Kadipaten - Majalengka")
							 ->setCategory("LCKS 2017 - Excel");

// Set page orientation and size
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0.75);
$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0.75);
$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0.75);
$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(0.75);
$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&LNILAI '.$TNil.' TA '.$ThnAjaran.' Semester '.$Semstr);
$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&LHal: &P / &N [ '.$kls.' - '.$mapel.' ]');

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

$objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($style_col);

cellColor('A1:D1', 'cccccc');

//Menentukan kolom awal  
$column = 'E';
//Mencetak header berdasarkan field tabel
if($komp=="K3"){
	for($x=1;$x<$jmlKDP+1;$x++){
		$objPHPExcel->getActiveSheet()->setCellValue($column.'1', "KIKD ".$x);
		$objPHPExcel->getActiveSheet()->getStyle($column.'1')->applyFromArray($style_col);
		cellColor($column.'1:'.$column.'1', 'cccccc');
		$column++;
	}
}
else if($komp=="K4") {
	for($x=1;$x<$jmlKDK+1;$x++){
		$objPHPExcel->getActiveSheet()->setCellValue($column.'1', "KIKD ".$x);
		$objPHPExcel->getActiveSheet()->getStyle($column.'1')->applyFromArray($style_col);
		cellColor($column.'1:'.$column.'1', 'cccccc');
		$column++;
	}
}
else if($komp=="UTSUAS") {
	$objPHPExcel->getActiveSheet()->setCellValue('E1', "UTS");
	$objPHPExcel->getActiveSheet()->setCellValue('F1', "UAS");
	$objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray($style_col);
	$objPHPExcel->getActiveSheet()->getStyle('F1')->applyFromArray($style_col);
	cellColor('E1:F1', 'cccccc');
}
else if($komp=="K1K2") {
	$objPHPExcel->getActiveSheet()->setCellValue('E1', "Spritual");
	$objPHPExcel->getActiveSheet()->setCellValue('F1', "Sosial");
	$objPHPExcel->getActiveSheet()->setCellValue('G1', "Desk Spritual");
	$objPHPExcel->getActiveSheet()->setCellValue('H1', "Desk Sosial");
	$objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray($style_col);
	$objPHPExcel->getActiveSheet()->getStyle('F1')->applyFromArray($style_col);
	$objPHPExcel->getActiveSheet()->getStyle('G1')->applyFromArray($style_col);
	$objPHPExcel->getActiveSheet()->getStyle('H1')->applyFromArray($style_col);
	cellColor('E1:H1', 'cccccc');
}

$baris=2;
$no=1;
while($Hasil=mysql_fetch_array($Q)){
	
	$objPHPExcel->getActiveSheet()->getRowDimension($baris)->setRowHeight(25);	

	$objPHPExcel->getActiveSheet()->setCellValue('A'.$baris, $no);
	$objPHPExcel->getActiveSheet()->setCellValue('B'.$baris, $kbm);
	$objPHPExcel->getActiveSheet()->setCellValue('C'.$baris, $Hasil['nis']);
	$objPHPExcel->getActiveSheet()->setCellValue('D'.$baris, $Hasil['nm_siswa']);

	$objPHPExcel->getActiveSheet()->getStyle('A'.$baris)->applyFromArray($style_row);
	$objPHPExcel->getActiveSheet()->getStyle('B'.$baris)->applyFromArray($style_row);
	$objPHPExcel->getActiveSheet()->getStyle('C'.$baris)->applyFromArray($style_row);
	$objPHPExcel->getActiveSheet()->getStyle('D'.$baris)->applyFromArray($style_row);

	$Kolom = 'E';
	
	if($komp=="K3"){
		for($x=1;$x<$jmlKDP+1;$x++){
			$objPHPExcel->getActiveSheet()->getStyle($Kolom.$baris)->applyFromArray($style_row);
			$Kolom++;
		}
	}
	else if($komp=="K4"){
		for($x=1;$x<$jmlKDK+1;$x++){
			$objPHPExcel->getActiveSheet()->getStyle($Kolom.$baris)->applyFromArray($style_row);
			$Kolom++;
		}
	}
	else if($komp=="UTSUAS"){
		$objPHPExcel->getActiveSheet()->getStyle('E'.$baris)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('F'.$baris)->applyFromArray($style_row);
	}
	else if($komp=="K1K2"){
		$objPHPExcel->getActiveSheet()->getStyle('E'.$baris)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('F'.$baris)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('G'.$baris)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('H'.$baris)->applyFromArray($style_row);
	}

	$objPHPExcel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('B'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('C'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	$baris++;
	$no++;
}

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5.00);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);

$objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 1);

$NamaFile=$kbm." - ".$kls." - ".$komp." - ".$mapel;
// Mencetak File Excel 
header('Content-Type: application/vnd.ms-excel'); 
header('Content-Disposition: attachment;filename="'.$NamaFile.'.xls"'); 
header('Cache-Control: max-age=0'); 
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
$objWriter->save('php://output');

?>
