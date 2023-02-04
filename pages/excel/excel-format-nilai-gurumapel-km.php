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
$mapel=isset($_GET['mapel'])?$_GET['mapel']:""; 
$kls=isset($_GET['kls'])?$_GET['kls']:""; 
$thnajaran=isset($_GET['thnajaran'])?$_GET['thnajaran']:""; 
$gg=isset($_GET['gg'])?$_GET['gg']:""; 
$ptk=isset($_GET['ptk'])?$_GET['ptk']:""; 

$QProfil=mysql_query("select * from app_lembaga");
$HProfil=mysql_fetch_array($QProfil);

$QKelas=mysql_query("select * from ak_kelas where nama_kelas='$kls'");
$HKelas=mysql_fetch_array($QKelas);

$NamaKelas=$HKelas['nama_kelas']." [".$HKelas['kode_kelas']."]";

$QNgajar=mysql_query("select * from gmp_ngajar where id_ngajar='$kbm'");
$HNgajar=mysql_fetch_array($QKelas);

$QGuru=mysql_query("select nama_lengkap from app_user_guru where id_guru='$ptk'");
$HGuru=mysql_fetch_array($QGuru);
$NamaGuru=$HGuru['nama_lengkap'];

$DataCP1=mysql_query("select * from gmp_km_tp where kode_ngajar='$kbm'");
//$DataKDP=mysql_query("select * from dasarkompetensi where kode_ngajar='$kbm' and kode_ranah='CP2'");
//$DataKDK=mysql_query("select * from dasarkompetensi where kode_ngajar='$kbm' and kode_ranah='CP3'");

$jmlCP1=mysql_num_rows($DataCP1);
//$jmlKDP=mysql_num_rows($DataKDP);
//$jmlKDK=mysql_num_rows($DataKDK);

require_once 'Classes/PHPExcel.php';
$objPHPExcel = new PHPExcel();

$objPHPExcel->getProperties()->setCreator("Abdul Madjid, SPd., M.Pd.")
							 ->setLastModifiedBy("Abdul Madjid, SPd., M.Pd.")
							 ->setTitle("Format Nilai Guru ".$NamaKelas." - ".$thnajaran." - ".$gg)
							 ->setCompany("SMKN 1 Kadipaten - Majalengka")
							 ->setCategory("LCKS KURIKULUM 2013 - Excel");

$objPHPExcel->getDefaultStyle()->getFont()->setName('Arial')
                                          ->setSize(10);

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

// SHEET K3

	//$myWorkSheet = new PHPExcel_Worksheet($objPHPExcel, 'K3');
	//$objPHPExcel->addSheet($myWorkSheet, 1);
	//$objPHPExcel->setActiveSheetIndex(1);

	$objPHPExcel->getSheet(0)->setTitle('CP');
	// Setting Worsheet yang aktif 
	$objPHPExcel->setActiveSheetIndex(0);  

	$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
	$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
	$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0.75);
	$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0.75);
	$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0.75);
	$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(0.75);
	$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&LNILAI CAPAIAN PEMBELAJARAN (CP) TA '.$thnajaran.' Semester '.$gg);
	$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&LHal: &P / &N [ '.$kls.' - '.$mapel.' ]');


	//Mencetak header berdasarkan field tabel
	$objPHPExcel->getActiveSheet()->setCellValue('A1', "NILAI CAPAIAN PEMBELAJARAN (CP)");
	$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
	$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);

	$objPHPExcel->getActiveSheet()->setCellValue('A2', "No.");
	$objPHPExcel->getActiveSheet()->setCellValue('B2', "Kode KBM");
	$objPHPExcel->getActiveSheet()->setCellValue('C2', "NIS");
	$objPHPExcel->getActiveSheet()->setCellValue('D2', "Nama Siswa"); 

	$objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray($style_col);
	$objPHPExcel->getActiveSheet()->getStyle('B2')->applyFromArray($style_col);
	$objPHPExcel->getActiveSheet()->getStyle('C2')->applyFromArray($style_col);
	$objPHPExcel->getActiveSheet()->getStyle('D2')->applyFromArray($style_col);

	cellColor('A2:D2', 'cccccc');

	//Menentukan kolom awal  
	$column = 'E';
	//Mencetak header berdasarkan field tabel
	for($x=1;$x<$jmlCP1+1;$x++){
		$objPHPExcel->getActiveSheet()->setCellValue($column.'2', "CP ".$x);
		$objPHPExcel->getActiveSheet()->getStyle($column.'2')->applyFromArray($style_col);
		cellColor($column.'2:'.$column.'2', 'cccccc');
		$column++;
	}

	$baris=3;
	$QPerkelas=mysql_query("select ak_perkelas.nis,siswa_biodata.nm_siswa from ak_perkelas inner join siswa_biodata on ak_perkelas.nis=siswa_biodata.nis where ak_perkelas.nm_kelas='".$kls."' and ak_perkelas.tahunajaran='".$thnajaran."' order by siswa_biodata.nm_siswa");
	$JmlPerKelas=mysql_num_rows($QPerkelas);

	$no=1;
	while($Hasil=mysql_fetch_array($QPerkelas)){
		
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
		
		for($x=1;$x<$jmlCP1+1;$x++){
			$objPHPExcel->getActiveSheet()->getStyle($Kolom.$baris)->applyFromArray($style_row);
			$objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
			$objPHPExcel->getActiveSheet()
				->getStyle($Kolom.$baris)
				->getProtection()->setLocked(
					PHPExcel_Style_Protection::PROTECTION_UNPROTECTED
				);
			$objPHPExcel->getActiveSheet()->getColumnDimension($Kolom)->setAutoSize(true);
			$Kolom++;
		}

		$objPHPExcel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('B'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('C'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$baris++;
		$no++;
	}

	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5.00);
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20.00);
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15.00);
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(40.00);


	$objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 1);


// SHEET UTSUAS

	$myWorkSheet = new PHPExcel_Worksheet($objPHPExcel, 'UTSUAS');
	$objPHPExcel->addSheet($myWorkSheet, 1);
	$objPHPExcel->setActiveSheetIndex(1);

	$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
	$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
	$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0.75);
	$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0.75);
	$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0.75);
	$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(0.75);
	$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&LNILAI UTS UAS TA '.$thnajaran.' Semester '.$gg);
	$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&LHal: &P / &N [ '.$kls.' - '.$mapel.' ]');

	//Mencetak header berdasarkan field tabel
	$objPHPExcel->getActiveSheet()->setCellValue('A1', "NILAI UTS UAS");
	$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
	$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);

	$objPHPExcel->getActiveSheet()->setCellValue('A2', "No.");
	$objPHPExcel->getActiveSheet()->setCellValue('B2', "Kode KBM");
	$objPHPExcel->getActiveSheet()->setCellValue('C2', "NIS");
	$objPHPExcel->getActiveSheet()->setCellValue('D2', "Nama Siswa"); 

	$objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray($style_col);
	$objPHPExcel->getActiveSheet()->getStyle('B2')->applyFromArray($style_col);
	$objPHPExcel->getActiveSheet()->getStyle('C2')->applyFromArray($style_col);
	$objPHPExcel->getActiveSheet()->getStyle('D2')->applyFromArray($style_col);

	cellColor('A2:D2', 'cccccc');

	//Menentukan kolom awal  
	$column = 'E';
	//Mencetak header berdasarkan field tabel
	$objPHPExcel->getActiveSheet()->setCellValue('E2', "UTS");
	$objPHPExcel->getActiveSheet()->setCellValue('F2', "UAS");
	$objPHPExcel->getActiveSheet()->getStyle('E2')->applyFromArray($style_col);
	$objPHPExcel->getActiveSheet()->getStyle('F2')->applyFromArray($style_col);
	cellColor('E2:F2', 'cccccc');

	$baris=3;
	$QPerkelas=mysql_query("select ak_perkelas.nis,siswa_biodata.nm_siswa from ak_perkelas inner join siswa_biodata on ak_perkelas.nis=siswa_biodata.nis where ak_perkelas.nm_kelas='".$kls."' and ak_perkelas.tahunajaran='".$thnajaran."' order by siswa_biodata.nm_siswa");
	$JmlPerKelas=mysql_num_rows($QPerkelas);

	$no=1;
	while($Hasil=mysql_fetch_array($QPerkelas)){
		
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
		
		$objPHPExcel->getActiveSheet()->getStyle('E'.$baris)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('F'.$baris)->applyFromArray($style_row);

		$objPHPExcel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('B'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('C'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
		$objPHPExcel->getActiveSheet()
			->getStyle('E'.$baris.':F'.$baris)
			->getProtection()->setLocked(
				PHPExcel_Style_Protection::PROTECTION_UNPROTECTED
			);

		$baris++;
		$no++;
	}

	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5.00);
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20.00);
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15.00);
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(40.00);
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(5.00);
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(5.00);

	$objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 1);

	$objPHPExcel->setActiveSheetIndex(0);  


$thnsingkat = substr($thnajaran,-7,2).substr($thnajaran,-2,2);

$NamaFile=$NamaGuru."-".$kbm."-".$thnsingkat."-".$gg."-".$kls."-".$mapel;
// Mencetak File Excel 
header('Content-Type: application/vnd.ms-excel'); 
header('Content-Disposition: attachment;filename="'.$NamaFile.'.xls"'); 
header('Cache-Control: max-age=0'); 
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
$objWriter->save('php://output');

?>