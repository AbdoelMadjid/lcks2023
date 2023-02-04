<?php 
/* 12/6/2016
Design and Programming By. Abdul Madjid, S.Pd., M.Pd.
SMK Negeri 1 Kadipaten
Pin 520543F3 HP. 0812-3000-0420
https://twitter.com/AbdoelMadjid 
https://www.facebook.com/abdulmadjid.mpd
*/
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING | E_DEPRECATED));
require_once 'koneksi.php';

$pk=isset($_GET['pk'])?$_GET['pk']:""; 
$thnajaran=isset($_GET['thnajaran'])?$_GET['thnajaran']:""; 
$mp=isset($_GET['mp'])?$_GET['mp']:""; 
$kls=isset($_GET['kls'])?$_GET['kls']:""; 
$jn=isset($_GET['jn'])?$_GET['jn']:""; 

$DMP=mysql_query("select * from ak_matapelajaran where kode_mapel='$mp'");
$HMP=mysql_fetch_array($DMP);
$NamaMapel=$HMP['nama_mapel'];

$DKelas=mysql_query("select * from ak_kelas where tahunajaran='$thnajaran' and kode_pk='$pk' and kode_kelas='$kls'");
$HKelas=mysql_fetch_array($DKelas);
$NamaKelas=$HKelas['nama_kelas'];

if($jn=='UNPK' || $jn=='US-DPK' || $jn=='US-PK' || $jn=='UJIKOM' || $jn=='NL'){
	$result=mysql_query("
	SELECT 
	ujian_usukk.nis,
	ujian_usukk.nm_siswa,
	ak_kelas.kode_kelas 
	FROM 
	ujian_usukk 
	INNER JOIN 
	ak_kelas ON ujian_usukk.kelas=ak_kelas.nama_kelas and 
	ujian_usukk.thajaran=ak_kelas.tahunajaran 
	WHERE 
	ak_kelas.tahunajaran='$thnajaran' 
	ORDER BY  
	ak_kelas.kode_kelas,ujian_usukk.nm_siswa");
}
else if($jn=='UN'){
	$result=mysql_query("
		SELECT 
		ujian_usukk.nis,
		ujian_usukk.nm_siswa,
		ak_kelas.kode_kelas,
		ak_matapelajaran.kode_mapel,
		ak_matapelajaran.nama_mapel 
		FROM 
		ujian_usukk,
		ak_kelas,
		ak_matapelajaran 
		WHERE 
		ujian_usukk.kelas=ak_kelas.nama_kelas AND 
		kelas.kode_pk=ak_matapelajaran.kode_pk and 
		ak_kelas.tahunajaran='$thnajaran' AND 
		ujian_usukk.thajaran='$thnajaran' AND 
		ak_matapelajaran.nama_mapel='$NamaMapel' 
		ORDER BY  
		ak_kelas.kode_kelas,ak_matapelajaran.kode_mapel,ujian_usukk.nm_siswa");
}
else
{
	$result=mysql_query("
	SELECT 
	ujian_usukk.thajaran,
	ujian_usukk.nis,
	ujian_usukk.nm_siswa,
	ak_kelas.kode_kelas,
	ak_kelas.kode_pk,
	ak_matapelajaran.kode_mapel,
	ak_matapelajaran.nama_mapel 
	FROM ujian_usukk,ak_kelas,ak_matapelajaran
	WHERE ujian_usukk.kelas=ak_kelas.nama_kelas
	AND ak_kelas.kode_pk=ak_matapelajaran.kode_pk 
	AND ak_kelas.tahunajaran='$thnajaran'
	AND ujian_usukk.thajaran='$thnajaran'
	AND ak_kelas.kode_kelas='$kls'
	ORDER BY ak_kelas.kode_kelas,ak_matapelajaran.kode_mapel,ujian_usukk.nm_siswa");
}


require_once 'Classes/PHPExcel.php';
$objPHPExcel = new PHPExcel();

$objPHPExcel->getProperties()->setCreator("Abdul Madjid, SPd., M.Pd.")
							 ->setLastModifiedBy("Abdul Madjid, SPd., M.Pd.")
							 ->setTitle("NILAI TRANSKIP")
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

	$objPHPExcel->getActiveSheet()->setCellValue('A1', "NO.");
	$objPHPExcel->getActiveSheet()->setCellValue('B1', "TA");
	$objPHPExcel->getActiveSheet()->setCellValue('C1', "KELAS");

if($jn=="UN"){
	$objPHPExcel->getActiveSheet()->setCellValue('D1', "KODEMAPEL");
	$objPHPExcel->getActiveSheet()->setCellValue('E1', "NIS");
	$objPHPExcel->getActiveSheet()->setCellValue('F1', "NAMA SISWA");
	$objPHPExcel->getActiveSheet()->setCellValue('G1', "NILAI UN");
}
else if($jn=="UNPK" || $jn=="US-DPK" || $jn=="US-PK" || $jn=="UJIKOM"){
	$objPHPExcel->getActiveSheet()->setCellValue('D1', "NIS");
	$objPHPExcel->getActiveSheet()->setCellValue('E1', "NAMA SISWA");
	$objPHPExcel->getActiveSheet()->setCellValue('F1', "NILAI");
}
else if($jn=="US"){
	$objPHPExcel->getActiveSheet()->setCellValue('D1', "KODEMAPEL");
	$objPHPExcel->getActiveSheet()->setCellValue('E1', "NIS");
	$objPHPExcel->getActiveSheet()->setCellValue('F1', "NAMA SISWA");
	$objPHPExcel->getActiveSheet()->setCellValue('G1', "NILAI TEORI");
	$objPHPExcel->getActiveSheet()->setCellValue('H1', "NILAI PRAKTEK");
	$objPHPExcel->getActiveSheet()->setCellValue('I1', "NAMA MAPEL");
}
else if($jn=="NL"){
	$objPHPExcel->getActiveSheet()->setCellValue('D1', "NIS");
	$objPHPExcel->getActiveSheet()->setCellValue('E1', "NAMA SISWA");
	$objPHPExcel->getActiveSheet()->setCellValue('F1', "NILAI 1");
	$objPHPExcel->getActiveSheet()->setCellValue('G1', "NILAI 2");
	$objPHPExcel->getActiveSheet()->setCellValue('H1', "NILAI 3");
	$objPHPExcel->getActiveSheet()->setCellValue('I1', "NILAI 4");
}

// STYLE COLOUM
	$objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($style_col);
	$objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($style_col);
	$objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($style_col);
	$objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($style_col);
	$objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray($style_col);
	$objPHPExcel->getActiveSheet()->getStyle('F1')->applyFromArray($style_col);
if($jn=="UN"){
	$objPHPExcel->getActiveSheet()->getStyle('G1')->applyFromArray($style_col);
}
else if($jn=="US" || $jn=="NL"){
	$objPHPExcel->getActiveSheet()->getStyle('G1')->applyFromArray($style_col);
	$objPHPExcel->getActiveSheet()->getStyle('H1')->applyFromArray($style_col);
	$objPHPExcel->getActiveSheet()->getStyle('I1')->applyFromArray($style_col);
}


// ISI DATA

$kolomna=2;  
$No=1;
while($row=mysql_fetch_array($result)) {  

	$objPHPExcel->getActiveSheet()->setCellValue('A'.$kolomna, $No);
	$objPHPExcel->getActiveSheet()->setCellValue('B'.$kolomna, $thnajaran);
	
	if($jn=="UN" || $jn=="UNPK" || $jn=="US-DPK" || $jn=="US-PK" || $jn=="UJIKOM" || $jn=="NL"){
		$objPHPExcel->getActiveSheet()->setCellValue('C'.$kolomna, $row['kode_kelas']);
	}else{
		$objPHPExcel->getActiveSheet()->setCellValue('C'.$kolomna, $kls);
	}

	if($jn=="UN"){
		$objPHPExcel->getActiveSheet()->setCellValue('D'.$kolomna, $row['kode_mapel']);
		$objPHPExcel->getActiveSheet()->setCellValue('E'.$kolomna, $row['nis']);
		$objPHPExcel->getActiveSheet()->setCellValue('F'.$kolomna, $row['nm_siswa']);  
	}
	else if($jn=="US"){
		$objPHPExcel->getActiveSheet()->setCellValue('D'.$kolomna, $row['kode_mapel']);
		$objPHPExcel->getActiveSheet()->setCellValue('E'.$kolomna, $row['nis']);
		$objPHPExcel->getActiveSheet()->setCellValue('F'.$kolomna, $row['nm_siswa']);  
		$objPHPExcel->getActiveSheet()->setCellValue('I'.$kolomna, $row['nama_mapel']);  
	}
	else if($jn=="UNPK" || $jn=="US-DPK" || $jn=="US-PK" || $jn=="UJIKOM" || $jn=="NL"){
		$objPHPExcel->getActiveSheet()->setCellValue('D'.$kolomna, $row['nis']);
		$objPHPExcel->getActiveSheet()->setCellValue('E'.$kolomna, $row['nm_siswa']); 
	}


		$objPHPExcel->getActiveSheet()->getStyle('A'.$kolomna)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('B'.$kolomna)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('C'.$kolomna)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('D'.$kolomna)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('E'.$kolomna)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('F'.$kolomna)->applyFromArray($style_row);
	
	if($jn=="UN"){
		$objPHPExcel->getActiveSheet()->getStyle('G'.$kolomna)->applyFromArray($style_row);
	}
	else if($jn=="US" || $jn=="NL"){
		$objPHPExcel->getActiveSheet()->getStyle('G'.$kolomna)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('H'.$kolomna)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('I'.$kolomna)->applyFromArray($style_row);
	}

	// JUDUL MENENGAH
	$objPHPExcel->getActiveSheet()->getStyle('A'.$kolomna)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	if($jn=="UN" || $jn=="US"){		
		$objPHPExcel->getActiveSheet()->getStyle('B'.$kolomna)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('D'.$kolomna)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('E'.$kolomna)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	}
	else if($jn=="UNPK" || $jn=="US-DPK" || $jn=="US-PK" || $jn=="UJIKOM" || $jn=="NL"){
		$objPHPExcel->getActiveSheet()->getStyle('B'.$kolomna)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('D'.$kolomna)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	}

/*
	if($jn=="NL"){
		$objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
		$objPHPExcel->getActiveSheet()
			->getStyle('F'.$kolomna.':I'.$kolomna)
			->getProtection()->setLocked(
				PHPExcel_Style_Protection::PROTECTION_UNPROTECTED
			);
	} else if($jn=="UN" || $jn=="US" ){
		$objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
		$objPHPExcel->getActiveSheet()
			->getStyle('G'.$kolomna.':H'.$kolomna)
			->getProtection()->setLocked(
				PHPExcel_Style_Protection::PROTECTION_UNPROTECTED
			);
	} else if($jn=="UNPK"){
		$objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
		$objPHPExcel->getActiveSheet()
			->getStyle('F'.$kolomna.':G'.$kolomna)
			->getProtection()->setLocked(
				PHPExcel_Style_Protection::PROTECTION_UNPROTECTED
			);
	} else if($jn=="UK" || $jn=="DPK" || $jn=="PK"){
		$objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
		$objPHPExcel->getActiveSheet()
			->getStyle('F'.$kolomna)
			->getProtection()->setLocked(
				PHPExcel_Style_Protection::PROTECTION_UNPROTECTED
			);
	}
*/
	$kolomna++;
	$No++;
} 

// BERI WARNA JUDUL KOLOM

if($jn=="UN"){
	cellColor('A1:G1', 'cccccc');
}
else if($jn=="UNPK" || $jn=="US-DPK" || $jn=="US-PK" || $jn=="UJIKOM"){
	cellColor('A1:F1', 'cccccc');
}
else if($jn=="US" || $jn=="NL"){
	cellColor('A1:I1', 'cccccc');
}


$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
if($jn=="UN"){
	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
}
else if($jn=="US" || $jn=="NL"){
	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
}

// FORMAT / TYPE KERTAS

$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

// JUDUL FILE

if($jn=="US"){
	$NamaFile=$jn." ".$NamaKelas;
}
else if($jn=="UJIKOM"){
	$NamaFile="UJIKOM";
}
else if($jn=="NL"){
	$NamaFile="NILAI LAIN-LAIN";
}
else if($jn=="UN"){
	$NamaFile="UN ".$NamaMapel;
}
else if($jn=="UNPK"){
	$NamaFile="UN PAKET KEAHLIAN";
}
else if($jn=="US-DPK"){
	$NamaFile="US DASAR PAKET KEAHLIAN";
}
else if($jn=="US-PK"){
	$NamaFile="US PAKET KEAHLIAN";
}
else {
	$NamaFile=$jn." ".$pk." ".$NamaKelas." ".$NamaMapel;
}

// Mencetak File Excel 
header('Content-Type: application/vnd.ms-excel'); 
header('Content-Disposition: attachment;filename="'.$NamaFile.'.xls"'); 
header('Cache-Control: max-age=0'); 
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
$objWriter->save('php://output');