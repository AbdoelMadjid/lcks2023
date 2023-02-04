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

$kelas=(isset($_GET['kls']))?$_GET['kls']:"";
$thnajaran=(isset($_GET['thnajaran']))?$_GET['thnajaran']:"";
$gg=(isset($_GET['gg']))?$_GET['gg']:"";
$jn=(isset($_GET['jn']))?$_GET['jn']:"";

$QProfil=mysql_query("select * from profil");
$HProfil=mysql_fetch_array($QProfil);

$Q=mysql_query("
SELECT 
gmp_ngajar.id_ngajar,
gmp_ngajar.thnajaran,
gmp_ngajar.jenismapel,
gmp_ngajar.semester,
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

$JmlKolom=round(($JmMP*3)+3,0);
$JmlIdentitas=round(($JmlKolom-2),0);

require_once 'Classes/PHPExcel.php';
$objPHPExcel = new PHPExcel();

// Setting Worsheet yang aktif 
$objPHPExcel->setActiveSheetIndex(0);  

if($jn=="k3"){$judulna="LEGER NILAI PENGETAHUAN";}else if($jn=="k4"){$judulna="LEGER NILAI KETERAMPILAN";}else if($jn=="na"){$judulna="LEGER NILAI AKHIR";}

$objPHPExcel->getProperties()->setCreator("Abdul Madjid, SPd., M.Pd.")
							 ->setLastModifiedBy("Abdul Madjid, SPd., M.Pd.")
							 ->setTitle($judulna)
							 ->setCompany("SMKN 1 Kadipaten - Majalengka")
							 ->setCategory("LCKS 2017 - Excel");

// Set page orientation and size
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LEGAL);
$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0.50);
$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(1.20);
$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0.55);
$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(0.50);
$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&LHal: &P/&N - '.$objPHPExcel->getProperties()->getTitle().' '.$kelas.' '.$thnajaran.' '.$gg);

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


$objPHPExcel->getActiveSheet()->mergeCells('A1:C1');
$objPHPExcel->getActiveSheet()->setCellValue('A1', $judulna);
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setName('Arial');
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$objPHPExcel->getActiveSheet()->mergeCells('A3:B3');
$objPHPExcel->getActiveSheet()->setCellValue('A3', "Tahun Pelajaran");
$objPHPExcel->getActiveSheet()->mergeCells('A4:B4');
$objPHPExcel->getActiveSheet()->setCellValue('A4', "Semester");
$objPHPExcel->getActiveSheet()->mergeCells('A5:B5');
$objPHPExcel->getActiveSheet()->setCellValue('A5', "Kelas");

$objPHPExcel->getActiveSheet()->setCellValue('C3', " : ".$thnajaran);
$objPHPExcel->getActiveSheet()->setCellValue('C4', " : ".$gg);
$objPHPExcel->getActiveSheet()->setCellValue('C5', " : ".$kelas);

$objPHPExcel->getActiveSheet()->setCellValue('A7', " NO. ");
$objPHPExcel->getActiveSheet()->setCellValue('B7', "NIS");
$objPHPExcel->getActiveSheet()->setCellValue('C7', "NAMA SISWA");

$objPHPExcel->getActiveSheet()->getStyle('A7')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('B7')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('C7')->applyFromArray($style_col);

cellColor('A7:C7', 'cccccc');

$kolom='D';
for($x=1;$x<($JmlMP+1);$x++){
	$objPHPExcel->getActiveSheet()->setCellValue($kolom.'7', $x);
	$objPHPExcel->getActiveSheet()->getStyle($kolom.'7')->applyFromArray($style_col);
	$objPHPExcel->getActiveSheet()->getColumnDimension($kolom)->setWidth(5.00);
	cellColor($kolom.'7:'.$kolom.'7', 'cccccc');
	$kolom++;
}

$QLgr=mysql_query("
select 
ak_kelas.kode_kelas,
ak_kelas.tahunajaran,
ak_perkelas.nis,
siswa_biodata.nm_siswa, 
ak_kelas.nama_kelas
from ak_kelas
inner join ak_perkelas on ak_kelas.nama_kelas=ak_perkelas.nm_kelas and ak_kelas.tahunajaran=ak_perkelas.tahunajaran
inner join siswa_biodata on ak_perkelas.nis=siswa_biodata.nis
where ak_kelas.kode_kelas='$kelas' order by ak_perkelas.nis");

$JmlSiswa=mysql_num_rows($QLgr);

$baris=8;
$NoNL=1;
while($HLN=mysql_fetch_array($QLgr))
{

	$objPHPExcel->getActiveSheet()->setCellValue('A'.$baris, $NoNL);
	$objPHPExcel->getActiveSheet()->setCellValue('B'.$baris, $HLN['nis']);
	$objPHPExcel->getActiveSheet()->setCellValue('C'.$baris, $HLN['nm_siswa']);

	$QDL=mysql_query("select * from leger_nilai where id_kls='$kelas' and thnajaran='$thnajaran' and semester='$gg'");
	$HDL=mysql_fetch_array($QDL);

	$kbm=array(
	$HDL['kd_ngajar1'],
	$HDL['kd_ngajar2'],
	$HDL['kd_ngajar3'],
	$HDL['kd_ngajar4'],
	$HDL['kd_ngajar5'],
	$HDL['kd_ngajar6'],
	$HDL['kd_ngajar7'],
	$HDL['kd_ngajar8'],
	$HDL['kd_ngajar9'],
	$HDL['kd_ngajar10'],
	$HDL['kd_ngajar11'],
	$HDL['kd_ngajar12'],
	$HDL['kd_ngajar13'],
	$HDL['kd_ngajar14'],
	$HDL['kd_ngajar15'],
	$HDL['kd_ngajar16'],
	$HDL['kd_ngajar17'],
	$HDL['kd_ngajar18'],
	$HDL['kd_ngajar19'],
	$HDL['kd_ngajar20'],
	$HDL['kd_ngajar21']);

	$kolomEusi='D';

	for ($i=0; $i<$JmlMP; $i++)
	{	

		$QNSP=mysql_query("select * from n_p_kikd where kd_ngajar='".$kbm[$i]."' and nis='".$HLN['nis']."'");
		$HNSP=mysql_fetch_array($QNSP);

		$QNSU=mysql_query("select * from n_utsuas where kd_ngajar='".$kbm[$i]."' and nis='".$HLN['nis']."'");
		$HNSU=mysql_fetch_array($QNSU);
		
		$NilK3=round(($HNSP['kikd_p']+$HNSU['uts']+$HNSU['uas'])/3,0);

		$QNSK=mysql_query("select * from n_k_kikd where kd_ngajar='".$kbm[$i]."' and nis='".$HLN['nis']."'");
		$HNSK=mysql_fetch_array($QNSK);

		$NAna=round(($NilK3+$HNSK['kikd_k'])/2,0);

		if($jn=="k3"){
			$objPHPExcel->getActiveSheet()->setCellValue($kolomEusi.$baris, $NilK3);
		}
		else if($jn=="k4"){
			$objPHPExcel->getActiveSheet()->setCellValue($kolomEusi.$baris, $HNSK['kikd_k']);
		} 
		else if($jn=="na"){
			$objPHPExcel->getActiveSheet()->setCellValue($kolomEusi.$baris, $NAna);
		}

		$objPHPExcel->getActiveSheet()->getStyle($kolomEusi.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$objPHPExcel->getActiveSheet()->getStyle($kolomEusi.$baris)->applyFromArray($style_row);

		$kolomEusi++;
	}


	$objPHPExcel->getActiveSheet()->getStyle('A'.$baris)->applyFromArray($style_row);
	$objPHPExcel->getActiveSheet()->getStyle('B'.$baris)->applyFromArray($style_row);
	$objPHPExcel->getActiveSheet()->getStyle('C'.$baris)->applyFromArray($style_row);

	$objPHPExcel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('B'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	$baris++;
	$NoNL++;
}


$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5.00);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15.00);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(45.00);

$QWK=mysql_query("select ak_kelas.id_guru,app_user_guru.nip,app_user_guru.nama_lengkap from ak_kelas,app_user_guru where ak_kelas.id_guru=app_user_guru.id_guru and ak_kelas.kode_kelas='$kelas' and ak_kelas.tahunajaran='$thnajaran'");
$HWK=mysql_fetch_array($QWK);


$BarisKe=$JmlSiswa+9;
$BarisKe1=$BarisKe+1;

$objPHPExcel->getActiveSheet()->mergeCells('B'.$BarisKe.':C'.$BarisKe);
$objPHPExcel->getActiveSheet()->setCellValue('B'.$BarisKe, "Mengetahui :");
$objPHPExcel->getActiveSheet()->mergeCells('B'.$BarisKe1.':C'.$BarisKe1);
$objPHPExcel->getActiveSheet()->setCellValue('B'.$BarisKe1, "Kepala Sekolah,");

$Titimangsa=$HProfil['kecamatan'];

$Tgl=TglLengkap($tglSekarang=date('Y-m-d'));

$objPHPExcel->getActiveSheet()->mergeCells('G'.$BarisKe.':N'.$BarisKe);
$objPHPExcel->getActiveSheet()->setCellValue('G'.$BarisKe, $Titimangsa.", ".$Tgl);
$objPHPExcel->getActiveSheet()->mergeCells('G'.$BarisKe1.':N'.$BarisKe1);
$objPHPExcel->getActiveSheet()->setCellValue('G'.$BarisKe1, "Guru Mata Pelajaran,");

$BarisKe2=$BarisKe1+5;
$BarisKe3=$BarisKe2+1;

$NIPKepsek="NIP. ".$HProfil['nip_kepsek'];
$NIPGuru="NIP. ".$GuruNgajarNIP;

$objPHPExcel->getActiveSheet()->mergeCells('B'.$BarisKe2.':C'.$BarisKe2);
$objPHPExcel->getActiveSheet()->setCellValue('B'.$BarisKe2, $HProfil['nm_kepsek']);
$objPHPExcel->getActiveSheet()->mergeCells('B'.$BarisKe3.':C'.$BarisKe3);
$objPHPExcel->getActiveSheet()->setCellValue('B'.$BarisKe3, $NIPKepsek);

$NIPWK="NIP. ".$HWK['nip'];

$objPHPExcel->getActiveSheet()->mergeCells('G'.$BarisKe2.':N'.$BarisKe2);
$objPHPExcel->getActiveSheet()->setCellValue('G'.$BarisKe2, $HWK['nama_lengkap']);
$objPHPExcel->getActiveSheet()->mergeCells('G'.$BarisKe3.':N'.$BarisKe3);
$objPHPExcel->getActiveSheet()->setCellValue('G'.$BarisKe3, $NIPWK);

$objPHPExcel->getActiveSheet()->getStyle('B'.$BarisKe2)->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('G'.$BarisKe2)->getFont()->setBold(true);

$objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(7, 7);

$objPHPExcel->setActiveSheetIndex(0); 

$NamaFile=$judulna." ".$thnajaran."-".$gg."-".$kelas;
// Mencetak File Excel 
header('Content-Type: application/vnd.ms-excel'); 
header('Content-Disposition: attachment;filename="'.$NamaFile.'.xls"'); 
header('Cache-Control: max-age=0'); 
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
$objWriter->save('php://output');

?>