<?php 
/* 03/07/2017 
Design and Programming By. Abdul Madjid, S.Pd., M.Pd.
SMK Negeri 1 Kadipaten
Pin 520543F3 HP. 0812-3000-0420
https://twitter.com/AbdoelMadjid 
https://www.facebook.com/abdulmadjid.mpd
*/
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING | E_DEPRECATED));
require_once 'koneksi.php';

$kelas=(isset($_GET['kls']))?$_GET['kls']:"";
$thnajaran=(isset($_GET['thnajaran']))?$_GET['thnajaran']:"";
$gg=(isset($_GET['gg']))?$_GET['gg']:"";

$QProfil=mysql_query("select * from profil");
$HProfil=mysql_fetch_array($QProfil);

$Q=mysql_query("
SELECT 
gmp_ngajar.id_ngajar,
gmp_ngajar.thnajaran,
gmp_ngajar.jenismapel,
gmp_ngajar.semester,
gmp_ngajar.ganjilgenap,
gmp_ngajar.kkmpeng,
gmp_ngajar.kkmket,
app_user_guru.nama_lengkap,
ak_matapelajaran.kode_mapel,
ak_matapelajaran.nama_mapel,
ak_kelas.nama_kelas 
FROM 
gmp_ngajar,
app_user_guru,
ak_matapelajaran,
ak_kelas 
WHERE 
gmp_ngajar.kd_guru=app_user_guru.id_guru AND 
gmp_ngajar.kd_mapel=ak_matapelajaran.kode_mapel AND 
gmp_ngajar.kd_kelas=ak_kelas.kode_kelas and 
gmp_ngajar.kd_kelas='$kelas' and 
gmp_ngajar.thnajaran='$thnajaran' and
gmp_ngajar.ganjilgenap='$gg' 
order by gmp_ngajar.kd_kelas,gmp_ngajar.kd_mapel asc");
$JmlMP=mysql_num_rows($Q);
$HQ=mysql_fetch_array($Q);


require_once 'Classes/PHPExcel.php';
$objPHPExcel = new PHPExcel();

$objPHPExcel->getProperties()->setCreator("Abdul Madjid, SPd., M.Pd.")
							 ->setLastModifiedBy("Abdul Madjid, SPd., M.Pd.")
							 ->setTitle("LEGER NILAI KBM")
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

$objPHPExcel->getActiveSheet()->mergeCells('A1:G1');
$objPHPExcel->getActiveSheet()->setCellValue('A1', "LEGER NILAI KBM");
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setName('Arial');
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$objPHPExcel->getActiveSheet()->setCellValue('B3', "Tahun Pelajaran");
$objPHPExcel->getActiveSheet()->setCellValue('B4', "Semester");
$objPHPExcel->getActiveSheet()->setCellValue('B5', "Kelas");
$objPHPExcel->getActiveSheet()->setCellValue('B6', "Wali Kelas");

$QWK=mysql_query("select ak_kelas.id_guru,app_user_guru.nip,app_user_guru.nama_lengkap from ak_kelas,user_guru where ak_kelas.id_guru=app_user_guru.id_guru and ak_kelas.kode_kelas='$kelas' and ak_kelas.tahunajaran='$thnajaran'");
$HWK=mysql_fetch_array($QWK);
$WaliKelas=$HWK['nama_lengkap'];
$Semesterna=$HQ['ganjilgenap']." (".$HQ['semester'].")";

$objPHPExcel->getActiveSheet()->setCellValue('C3', ": ".$thnajaran);
$objPHPExcel->getActiveSheet()->setCellValue('C4', ": ".$Semesterna);
$objPHPExcel->getActiveSheet()->setCellValue('C5', ": ".$kelas);
$objPHPExcel->getActiveSheet()->setCellValue('C6', ": ".$WaliKelas);

$objPHPExcel->getActiveSheet()->setCellValue('A8', " NO. ");
$objPHPExcel->getActiveSheet()->setCellValue('B8', "NAMA GURU");
$objPHPExcel->getActiveSheet()->setCellValue('C8', "MATA PELAJARAN");
$objPHPExcel->getActiveSheet()->setCellValue('D8', "KKM P");
$objPHPExcel->getActiveSheet()->setCellValue('E8', "KKM K");
$objPHPExcel->getActiveSheet()->setCellValue('F8', "KIKD P");
$objPHPExcel->getActiveSheet()->setCellValue('G8', "KIKD K");
//$objPHPExcel->getActiveSheet()->getColumnDimension('A3')->setAutoSize(true);

$objPHPExcel->getActiveSheet()->getStyle('A8')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('B8')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('C8')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('D8')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('E8')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('F8')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('G8')->applyFromArray($style_col);

cellColor('A8:G8', 'cccccc');

$baris=9;  
$noKBM=1;
while($HNgajar=mysql_fetch_array($Q))
{
	$NamaKelas=$HNgajar['nama_kelas'];
	$KodeKelas=$HNgajar['kode_kelas'];
	$KodeNgajar=$HNgajar['id_ngajar'];
	$KodeMapel=$HNgajar['kode_mapel'];
	$thnajaran=$HNgajar['thnajaran'];
	$gg=$HNgajar['ganjilgenap'];
	$smstr=$HNgajar['semester'];

	$QDK="select 
	gmp_kikd.id_dk,
	ak_kikd.kode_ranah,
	ak_kikd.no_kikd,
	ak_kikd.isikikd,
	ak_matapelajaran.nama_mapel,
	ak_kelas.nama_kelas,
	app_user_guru.nama_lengkap
	from gmp_kikd
	inner join ak_kikd on gmp_kikd.kode_kikd=ak_kikd.id_kikd
	inner join gmp_ngajar on gmp_kikd.kode_ngajar=gmp_ngajar.id_ngajar 
	inner join ak_matapelajaran on gmp_ngajar.kd_mapel=ak_matapelajaran.kode_mapel
	inner join app_user_guru on gmp_ngajar.kd_guru=app_user_guru.id_guru
	inner join ak_kelas on gmp_ngajar.kd_kelas=ak_kelas.kode_kelas
	where gmp_kikd.kode_ngajar='$KodeNgajar'";
	$JDKS=mysql_num_rows(mysql_query("$QDK and ak_kikd.kode_ranah='KDS'"));
	$JDKP=mysql_num_rows(mysql_query("$QDK and ak_kikd.kode_ranah='KDP'"));
	$JDKK=mysql_num_rows(mysql_query("$QDK and ak_kikd.kode_ranah='KDK'"));

	$objPHPExcel->getActiveSheet()->setCellValue('A'.$baris, $noKBM);
	$objPHPExcel->getActiveSheet()->setCellValue('B'.$baris, $HNgajar['nama_lengkap']);
	$objPHPExcel->getActiveSheet()->setCellValue('C'.$baris, $HNgajar['nama_mapel']);
	$objPHPExcel->getActiveSheet()->setCellValue('D'.$baris, $HNgajar['kkmpeng']);
	$objPHPExcel->getActiveSheet()->setCellValue('E'.$baris, $HNgajar['kkmket']);
	$objPHPExcel->getActiveSheet()->setCellValue('F'.$baris, $JDKP);
	$objPHPExcel->getActiveSheet()->setCellValue('G'.$baris, $JDKK);

	$objPHPExcel->getActiveSheet()->getStyle('A'.$baris)->applyFromArray($style_row);
	$objPHPExcel->getActiveSheet()->getStyle('B'.$baris)->applyFromArray($style_row);
	$objPHPExcel->getActiveSheet()->getStyle('C'.$baris)->applyFromArray($style_row);
	$objPHPExcel->getActiveSheet()->getStyle('D'.$baris)->applyFromArray($style_row);
	$objPHPExcel->getActiveSheet()->getStyle('E'.$baris)->applyFromArray($style_row);
	$objPHPExcel->getActiveSheet()->getStyle('F'.$baris)->applyFromArray($style_row);
	$objPHPExcel->getActiveSheet()->getStyle('G'.$baris)->applyFromArray($style_row);

	$objPHPExcel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('D'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('E'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('F'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('G'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	$baris++;
	$noKBM++;
}

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5.00);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10.00);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10.00);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10.00);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10.00);


$NamaFile="LEGER NILAI KBM ".$thnajaran."-".$smstr."-".$kelas;
// Mencetak File Excel 
header('Content-Type: application/vnd.ms-excel'); 
header('Content-Disposition: attachment;filename="'.$NamaFile.'.xls"'); 
header('Cache-Control: max-age=0'); 
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
$objWriter->save('php://output');

?>