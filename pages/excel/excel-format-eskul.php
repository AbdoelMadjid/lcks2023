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
$objPHPExcel->getActiveSheet()->setCellValue('D1', "WAJIB"); 
$objPHPExcel->getActiveSheet()->setCellValue('E1', "NILAI"); 
$objPHPExcel->getActiveSheet()->setCellValue('F1', "PILIHAN 1"); 
$objPHPExcel->getActiveSheet()->setCellValue('G1', "NILAI"); 
$objPHPExcel->getActiveSheet()->setCellValue('H1', "PILIHAN 2"); 
$objPHPExcel->getActiveSheet()->setCellValue('I1', "NILAI"); 
$objPHPExcel->getActiveSheet()->setCellValue('J1', "PILIHAN 3"); 
$objPHPExcel->getActiveSheet()->setCellValue('K1', "NILAI"); 
$objPHPExcel->getActiveSheet()->setCellValue('L1', "PILIHAN 4"); 
$objPHPExcel->getActiveSheet()->setCellValue('M1', "NILAI"); 

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

cellColor('A1:M1', 'cccccc');

$baris=2;
$QRangking=mysql_query("select * from ak_perkelas where nm_kelas='".$HKelas['nama_kelas']."' and tahunajaran='$thnajaran'");
$JmlData=mysql_num_rows($QRangking);
$no=1;
while($Hasil=mysql_fetch_array($QRangking)){
	$QSis=mysql_query("select nis,nm_siswa from siswa_biodata where nis='{$Hasil['nis']}' order by nm_siswa");
	$HSis=mysql_fetch_array($QSis);

	$objPHPExcel->getActiveSheet()->setCellValue('A'.$baris, $no);
	$objPHPExcel->getActiveSheet()->setCellValue('B'.$baris, $Hasil['nis']);
	$objPHPExcel->getActiveSheet()->setCellValue('C'.$baris, $HSis['nm_siswa']);
	$objPHPExcel->getActiveSheet()->setCellValue('D'.$baris, "Pramuka");


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

	$objPHPExcel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('B'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

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
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);

$objPHPExcel->getActiveSheet()->setCellValue('O1', 'NAMA ESKUL PILIHAN');
$objPHPExcel->getActiveSheet()->setCellValue('O2', '1');
$objPHPExcel->getActiveSheet()->setCellValue('O3', '2');
$objPHPExcel->getActiveSheet()->setCellValue('O4', '3');
$objPHPExcel->getActiveSheet()->setCellValue('O5', '4');
$objPHPExcel->getActiveSheet()->setCellValue('O6', '5');
$objPHPExcel->getActiveSheet()->setCellValue('O7', '6');
$objPHPExcel->getActiveSheet()->setCellValue('O8', '7');
$objPHPExcel->getActiveSheet()->setCellValue('O9', '8');
$objPHPExcel->getActiveSheet()->setCellValue('O10', '9');
$objPHPExcel->getActiveSheet()->setCellValue('O11', '10');
$objPHPExcel->getActiveSheet()->setCellValue('O12', '11');
$objPHPExcel->getActiveSheet()->setCellValue('O13', '12');
$objPHPExcel->getActiveSheet()->setCellValue('O14', '13');
$objPHPExcel->getActiveSheet()->setCellValue('O15', '14');
$objPHPExcel->getActiveSheet()->setCellValue('O16', '15');
$objPHPExcel->getActiveSheet()->setCellValue('O17', '16');
$objPHPExcel->getActiveSheet()->setCellValue('O18', '17');

$objPHPExcel->getActiveSheet()->setCellValue('P2', 'PMR');
$objPHPExcel->getActiveSheet()->setCellValue('P3', 'Pasbraka');
$objPHPExcel->getActiveSheet()->setCellValue('P4', 'Marching Band');
$objPHPExcel->getActiveSheet()->setCellValue('P5', 'Bola Voli');
$objPHPExcel->getActiveSheet()->setCellValue('P6', 'Bola Basket');
$objPHPExcel->getActiveSheet()->setCellValue('P7', 'PKS');
$objPHPExcel->getActiveSheet()->setCellValue('P8', 'Karate');
$objPHPExcel->getActiveSheet()->setCellValue('P9', 'Futsal');
$objPHPExcel->getActiveSheet()->setCellValue('P10', 'Padus');
$objPHPExcel->getActiveSheet()->setCellValue('P11', 'Karya Ilmiah');
$objPHPExcel->getActiveSheet()->setCellValue('P12', 'Jurnalistik');
$objPHPExcel->getActiveSheet()->setCellValue('P13', 'Majalah Dinding (Mading)');
$objPHPExcel->getActiveSheet()->setCellValue('P14', 'Kerohanian Bidang Dak\'wah');
$objPHPExcel->getActiveSheet()->setCellValue('P15', 'Nasyid');
$objPHPExcel->getActiveSheet()->setCellValue('P16', 'Kaligrafi');
$objPHPExcel->getActiveSheet()->setCellValue('P17', 'Pasukan Pramuka');
$objPHPExcel->getActiveSheet()->setCellValue('P18', 'Baca Tulis Qur\'an');

$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);

$baris2=2;

for($x=1;$x<18;$x++){
	$objPHPExcel->getActiveSheet()->getStyle('O'.$baris2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('O'.$baris2)->applyFromArray($style_row);
	$objPHPExcel->getActiveSheet()->getStyle('P'.$baris2)->applyFromArray($style_row);
	$baris2++;
}

$objPHPExcel->getActiveSheet()->setCellValue('O20', 'KRITERIA PENILAIAN');
$objPHPExcel->getActiveSheet()->setCellValue('O21', '1');
$objPHPExcel->getActiveSheet()->setCellValue('O22', '2');
$objPHPExcel->getActiveSheet()->setCellValue('O23', '3');
$objPHPExcel->getActiveSheet()->setCellValue('O24', '4');
$objPHPExcel->getActiveSheet()->setCellValue('O25', '5');
$objPHPExcel->getActiveSheet()->setCellValue('P21', 'Sangat Baik');
$objPHPExcel->getActiveSheet()->setCellValue('P22', 'Baik');
$objPHPExcel->getActiveSheet()->setCellValue('P23', 'Cukup Baik');
$objPHPExcel->getActiveSheet()->setCellValue('P24', 'Kurang Baik');
$objPHPExcel->getActiveSheet()->setCellValue('P25', 'Sangat Kurang');

$baris3=21;

for($x=21;$x<26;$x++){
	$objPHPExcel->getActiveSheet()->getStyle('O'.$baris3)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('O'.$baris3)->applyFromArray($style_row);
	$objPHPExcel->getActiveSheet()->getStyle('P'.$baris3)->applyFromArray($style_row);
	$baris3++;
}

cellColor('O2:O18', 'cccccc');
cellColor('O21:O25', 'cccccc');
$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(4);
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(2);


$NamaFile="ESKUL-".$HKelas['nama_kelas']."-".$thnajaran."-".$gg;
// Mencetak File Excel 
header('Content-Type: application/vnd.ms-excel'); 
header('Content-Disposition: attachment;filename="'.$NamaFile.'.xls"'); 
header('Cache-Control: max-age=0'); 
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
$objWriter->save('php://output');

?>