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

$thnajaran=(isset($_GET['thnajaran']))?$_GET['thnajaran']:"";
$gg=isset($_GET['gg'])?$_GET['gg']:""; 
$tingkat=isset($_GET['tingkat'])?$_GET['tingkat']:""; 
$id_kls=isset($_GET['id_kls'])?$_GET['id_kls']:""; 

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

$Judul="DATA KBM TAHUN AJARAN $thnajaran SEMESTER ".strtoupper($gg);

$objPHPExcel->getActiveSheet()->mergeCells('A1:G1');
$objPHPExcel->getActiveSheet()->setCellValue('A1', $judul);
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setName('Arial');
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

//Mencetak header berdasarkan field tabel
$objPHPExcel->getActiveSheet()->setCellValue('A3', "No.");
$objPHPExcel->getActiveSheet()->setCellValue('B3', "Kode KBM");
$objPHPExcel->getActiveSheet()->setCellValue('C3', "Nama Guru");
$objPHPExcel->getActiveSheet()->setCellValue('D3', "Kelas"); 
$objPHPExcel->getActiveSheet()->setCellValue('E3', "Mata Pelajaran"); 
$objPHPExcel->getActiveSheet()->setCellValue('F3', "KIKD P"); 
$objPHPExcel->getActiveSheet()->setCellValue('G3', "KIKD K"); 

$objPHPExcel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('F3')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('G3')->applyFromArray($style_col);

cellColor('A3:G3', 'cccccc');

$sql = mysql_query("select 
gmp_ngajar.id_ngajar,
app_user_guru.nama_lengkap,
ak_matapelajaran.nama_mapel,
ak_kelas.nama_kelas
from gmp_ngajar 
inner join app_user_guru on gmp_ngajar.kd_guru=app_user_guru.id_guru
inner join ak_matapelajaran on gmp_ngajar.kd_mapel=ak_matapelajaran.kode_mapel
inner join ak_kelas on gmp_ngajar.kd_kelas = ak_kelas.kode_kelas
where gmp_ngajar.thnajaran='$thnajaran' and gmp_ngajar.ganjilgenap='$gg' order by kd_kelas,kd_mapel");

$baris=2;
$no = 1;
while($data = mysql_fetch_array($sql)){
	$IDNgajarna=$data['id_ngajar'];
	$QDK="select 
	gmp_kikd.id_dk,
	ak_kikd.kode_ranah,
	ak_kikd.no_kikd,
	ak_kikd.isikikd,
	ak_matapelajaran.nama_mapel,
	ak_kelas.nama_kelas,
	app_user_guru.nama_lengkap
	from gmp_kikd
	inner join ak_kikd on gmp_kikd.kode_kikd=kikd.id_kikd
	inner join gmp_ngajar on gmp_kikd.kode_ngajar=gmp_ngajar.id_ngajar 
	inner join ak_matapelajaran on gmp_ngajar.kd_mapel=ak_matapelajaran.kode_mapel
	inner join app_user_guru on gmp_ngajar.kd_guru=app_user_guru.id_guru
	inner join ak_kelas on gmp_ngajar.kd_kelas=ak_kelas.kode_kelas
	where gmp_kikd.kode_ngajar='$IDNgajarna'";

	$JDKS=mysql_num_rows(mysql_query("$QDK and kikd.kode_ranah='KDS'"));
	$JDKP=mysql_num_rows(mysql_query("$QDK and kikd.kode_ranah='KDP'"));
	$JDKK=mysql_num_rows(mysql_query("$QDK and kikd.kode_ranah='KDK'"));

	$objPHPExcel->getActiveSheet()->setCellValue('A'.$baris, $no);
	$objPHPExcel->getActiveSheet()->setCellValue('B'.$baris, $data['id_ngajar']);
	$objPHPExcel->getActiveSheet()->setCellValue('C'.$baris, $data['nama_lengkap']);
	$objPHPExcel->getActiveSheet()->setCellValue('D'.$baris, $data['nama_kelas']);
	$objPHPExcel->getActiveSheet()->setCellValue('E'.$baris, $data['nama_mapel']);
	$objPHPExcel->getActiveSheet()->setCellValue('F'.$baris, $JDKP);
	$objPHPExcel->getActiveSheet()->setCellValue('G'.$baris, $JDKK);

	$objPHPExcel->getActiveSheet()->getStyle('A'.$baris)->applyFromArray($style_row);
	$objPHPExcel->getActiveSheet()->getStyle('B'.$baris)->applyFromArray($style_row);
	$objPHPExcel->getActiveSheet()->getStyle('C'.$baris)->applyFromArray($style_row);
	$objPHPExcel->getActiveSheet()->getStyle('D'.$baris)->applyFromArray($style_row);
	$objPHPExcel->getActiveSheet()->getStyle('E'.$baris)->applyFromArray($style_row);
	$objPHPExcel->getActiveSheet()->getStyle('F'.$baris)->applyFromArray($style_row);

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

$NamaFile="KBM Thn ".$thnajaran." Smstr ".$gg;
// Mencetak File Excel 
header('Content-Type: application/vnd.ms-excel'); 
header('Content-Disposition: attachment;filename="'.$NamaFile.'.xls"'); 
header('Cache-Control: max-age=0'); 
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
$objWriter->save('php://output');

?>