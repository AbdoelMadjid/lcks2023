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

$idna=isset($_GET['idna'])?$_GET['idna']:"";

$qkls=mysql_query("SELECT nama_kelas FROM ak_kelas where id_kls='$idna'");
$hkls=mysql_fetch_assoc($qkls);
$Nm_Kls=$hkls['nama_kelas'];

require_once 'Classes/PHPExcel.php';
$objPHPExcel = new PHPExcel();

$judul="Kelas ".$Nm_Kls;

$objPHPExcel->getProperties()->setCreator("Abdul Madjid, SPd., M.Pd.")
							 ->setLastModifiedBy("Abdul Madjid, SPd., M.Pd.")
							 ->setTitle("BIODATA SISWA ".$Nm_Kls)
							 ->setCompany("SMKN 1 Kadipaten - Majalengka")
							 ->setCategory("LCKS 2017 - Excel");

// Set page orientation and size
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LEGAL);
$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0.50);
$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(1.50);
$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0.55);
$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(0.50);
//$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L&G&L&H');
$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&LHal: &P/&N - '.$objPHPExcel->getProperties()->getTitle());

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

$objPHPExcel->getActiveSheet()->mergeCells('A1:L1');
$objPHPExcel->getActiveSheet()->setCellValue('A1', "BIODATA SISWA");
$objPHPExcel->getActiveSheet()->mergeCells('A2:L2');
$objPHPExcel->getActiveSheet()->setCellValue('A2', $judul);

$objPHPExcel->getActiveSheet()->getStyle('A1:A2')->getFont()->setName('Arial');
$objPHPExcel->getActiveSheet()->getStyle('A1:A2')->getFont()->setSize(12);
$objPHPExcel->getActiveSheet()->getStyle('A1:A2')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A1:A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$objPHPExcel->getActiveSheet()->setCellValue('A4', "NO.");
$objPHPExcel->getActiveSheet()->setCellValue('B4', "NIS");
$objPHPExcel->getActiveSheet()->setCellValue('C4', "NISN");
$objPHPExcel->getActiveSheet()->setCellValue('D4', "NAMA SISWA");
$objPHPExcel->getActiveSheet()->setCellValue('E4', "TEMPAT LAHIR");
$objPHPExcel->getActiveSheet()->setCellValue('F4', "TGL LAHIR");
$objPHPExcel->getActiveSheet()->setCellValue('G4', "TGL LAHIR LENGKAP");
$objPHPExcel->getActiveSheet()->setCellValue('H4', "JENIS KELAMIN");
$objPHPExcel->getActiveSheet()->setCellValue('I4', "AGAMA");
$objPHPExcel->getActiveSheet()->setCellValue('J4', "TELEPON SISWA");
$objPHPExcel->getActiveSheet()->setCellValue('K4', "NAMA ORTU");
$objPHPExcel->getActiveSheet()->setCellValue('L4', "ALAMAT");

$objPHPExcel->getActiveSheet()->getStyle('A4')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('B4')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('C4')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('D4')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('E4')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('F4')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('G4')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('H4')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('I4')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('J4')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('K4')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('L4')->applyFromArray($style_col);


$sql=mysql_query("
select 
ak_kelas.id_kls,
ak_kelas.nama_kelas,
ak_kelas.tahunajaran,
siswa_biodata.nis,
siswa_biodata.nm_siswa,
siswa_biodata.tempat_lahir, 
siswa_biodata.tanggal_lahir,
siswa_biodata.jenis_kelamin 
from 
ak_kelas,
siswa_biodata,
ak_perkelas,
ak_paketkeahlian 
where 
ak_kelas.nama_kelas=ak_perkelas.nm_kelas and 
ak_kelas.tahunajaran=ak_perkelas.tahunajaran and 
ak_perkelas.nis=siswa_biodata.nis and 
siswa_biodata.kode_paket=ak_paketkeahlian.kode_pk and 
ak_kelas.id_kls='$idna' 
order by siswa_biodata.nis");
$baris=5;
$no=1;
while($data = mysql_fetch_assoc($sql)){
	$sqlalamat = mysql_query("SELECT * FROM siswa_alamat where nis='".$data['nis']."'");
	$dalamat = mysql_fetch_assoc($sqlalamat);
	$sqlpk = mysql_query("SELECT * FROM ak_paketkeahlian where kode_pk='".$data['kode_paket']."'");
	$sqlortu = mysql_query("SELECT * FROM siswa_ortu where nis='".$data['nis']."'");
	$dortu = mysql_fetch_assoc($sqlortu);

	$dpk = mysql_fetch_assoc($sqlpk);
	$tgllahir=" ".TglLengkap($data['tanggal_lahir']);
	if($dalamat['rt']=="" || $dalamat['rw']=="" || $dalamat['desa']=="" || $dalamat['kec']==""){
		$alamatsis='';
	}
	else{
		$alamatsis='RT '.$dalamat['rt'].' RW '.$dalamat['rw'].' Desa '.$dalamat['desa'].' Kecamatan '.$dalamat['kec'].' Kabupaten '.$dalamat['kab'];
	}

	$telp_siswa=" ".$data['telepon_siswa'];

	$NISN=" ".$data['nisn'];
	if($data['tanggal_lahir']=="0000-00-00")
	{
		$IsiTglLahir="";
	}
	else{
		$IsiTglLahir=$data['tanggal_lahir'];
	}
	$objPHPExcel->getActiveSheet()->setCellValue('A'.$baris, $no);
	$objPHPExcel->getActiveSheet()->setCellValue('B'.$baris, $data['nis']);
	$objPHPExcel->getActiveSheet()->setCellValue('C'.$baris, $NISN);
	$objPHPExcel->getActiveSheet()->setCellValue('D'.$baris, $data['nm_siswa']);
	$objPHPExcel->getActiveSheet()->setCellValue('E'.$baris, $data['tempat_lahir']);
	$objPHPExcel->getActiveSheet()->setCellValue('F'.$baris, $IsiTglLahir);
	$objPHPExcel->getActiveSheet()->setCellValue('G'.$baris, $tgllahir);
	$objPHPExcel->getActiveSheet()->setCellValue('H'.$baris, $data['jenis_kelamin']);
	$objPHPExcel->getActiveSheet()->setCellValue('I'.$baris, $data['agama']);
	$objPHPExcel->getActiveSheet()->setCellValue('J'.$baris, $telp_siswa);
	$objPHPExcel->getActiveSheet()->setCellValue('k'.$baris, $dortu['nm_ayah']);
	$objPHPExcel->getActiveSheet()->setCellValue('L'.$baris, $alamatsis);

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
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(10.00);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);

$objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(4, 4);

$NamaFile="BIODATA SISWA ".$Nm_Kls;
// Mencetak File Excel 
header('Content-Type: application/vnd.ms-excel'); 
header('Content-Disposition: attachment;filename="'.$NamaFile.'.xls"'); 
header('Cache-Control: max-age=0'); 
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
$objWriter->save('php://output');

?>