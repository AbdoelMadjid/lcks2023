<?php 
/* 04/07/2017 
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

require_once 'Classes/PHPExcel.php';
$objPHPExcel = new PHPExcel();

$objPHPExcel->getProperties()->setCreator("Abdul Madjid, SPd., M.Pd.")
							 ->setLastModifiedBy("Abdul Madjid, SPd., M.Pd.")
							 ->setTitle("NILAI")
							 ->setCompany("SMKN 1 Kadipaten - Majalengka")
							 ->setCategory("LCKS 2017 - Excel");

// Set page orientation and size
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
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
$objPHPExcel->getActiveSheet()->mergeCells('A1:A2');
$objPHPExcel->getActiveSheet()->setCellValue('A1', "No.");
$objPHPExcel->getActiveSheet()->mergeCells('B1:B2');
$objPHPExcel->getActiveSheet()->setCellValue('B1', "Kelas");
$objPHPExcel->getActiveSheet()->mergeCells('C1:C2');
$objPHPExcel->getActiveSheet()->setCellValue('C1', "TA");
$objPHPExcel->getActiveSheet()->mergeCells('D1:D2');
$objPHPExcel->getActiveSheet()->setCellValue('D1', "Semester"); 
$objPHPExcel->getActiveSheet()->mergeCells('E1:E2');
$objPHPExcel->getActiveSheet()->setCellValue('E1', "Kode KBM"); 
$objPHPExcel->getActiveSheet()->mergeCells('F1:F2');
$objPHPExcel->getActiveSheet()->setCellValue('F1', "NIS"); 
$objPHPExcel->getActiveSheet()->mergeCells('G1:G2');
$objPHPExcel->getActiveSheet()->setCellValue('G1', "Nama Siswa"); 
$objPHPExcel->getActiveSheet()->mergeCells('H1:L1');
$objPHPExcel->getActiveSheet()->setCellValue('H1', "NILAI SIKAP"); 
$objPHPExcel->getActiveSheet()->setCellValue('H2', "K1"); 
$objPHPExcel->getActiveSheet()->setCellValue('I2', "K2"); 
$objPHPExcel->getActiveSheet()->setCellValue('j2', "DK1"); 
$objPHPExcel->getActiveSheet()->setCellValue('K2', "DK2"); 
$objPHPExcel->getActiveSheet()->setCellValue('L2', "KIKD"); 
$objPHPExcel->getActiveSheet()->mergeCells('M1:AE1');
$objPHPExcel->getActiveSheet()->setCellValue('M1', "NILAI PENGETAHUAN"); 
$kolomk3='M';
for($x=1;$x<=15+1;$x++){
	$objPHPExcel->getActiveSheet()->setCellValue($kolomk3.'2', "K3_".$x);
	$objPHPExcel->getActiveSheet()->getStyle($kolomk3.'2')->applyFromArray($style_col);
	cellColor($kolomk3.'2:'.$kolomk3.'2', 'cccccc');
	$kolomk3++;
}
$objPHPExcel->getActiveSheet()->setCellValue('AA2', "UTS"); 
$objPHPExcel->getActiveSheet()->setCellValue('AB2', "UAS"); 
$objPHPExcel->getActiveSheet()->setCellValue('AC2', "R2"); 
$objPHPExcel->getActiveSheet()->setCellValue('AD2', "KIKD"); 
$objPHPExcel->getActiveSheet()->setCellValue('AE2', "NA"); 
$objPHPExcel->getActiveSheet()->mergeCells('AF1:AW1');
$objPHPExcel->getActiveSheet()->setCellValue('AF1', "NILAI KETERAMPILAN"); 
$kolomk4='AF';
for($x=1;$x<=15+1;$x++){
	$objPHPExcel->getActiveSheet()->setCellValue($kolomk4.'2', "K4_".$x);
	$objPHPExcel->getActiveSheet()->getStyle($kolomk4.'2')->applyFromArray($style_col);
	cellColor($kolomk4.'2:'.$kolomk4.'2', 'cccccc');
	$kolomk4++;
}
$objPHPExcel->getActiveSheet()->setCellValue('AU2', "R2"); 
$objPHPExcel->getActiveSheet()->setCellValue('AV2', "KIKD"); 
$objPHPExcel->getActiveSheet()->setCellValue('AW2', "NA");
$objPHPExcel->getActiveSheet()->mergeCells('AX1:AX2');
$objPHPExcel->getActiveSheet()->setCellValue('AX1', "Mata Pelajaran"); 
$objPHPExcel->getActiveSheet()->mergeCells('AY1:AY2');
$objPHPExcel->getActiveSheet()->setCellValue('AY1', "Guru Pengajar"); 


$objPHPExcel->getActiveSheet()->getStyle('A1:A2')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('B1:B2')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('C1:C2')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('D1:D2')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('E1:E2')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('F1:F2')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('G1:G2')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('H1:L2')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('H2')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('I2')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('J2')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('K2')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('L2')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('M1:AE2')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('AA2')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('AB2')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('AC2')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('AD2')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('AE2')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('AF1:AW2')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('AU2')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('AV2')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('AW2')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('AX1:AX2')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('AY1:AY2')->applyFromArray($style_col);


cellColor('A1:AY2', 'cccccc');


$Q=mysql_query("select  
gmp_ngajar.id_ngajar,
gmp_ngajar.thnajaran,
app_user_guru.nama_lengkap,
ak_matapelajaran.nama_mapel,
ak_kelas.nama_kelas,
gmp_ngajar.semester,
ak_perkelas.nis,
siswa_biodata.nm_siswa
from gmp_ngajar 
inner join app_user_guru on gmp_ngajar.kd_guru=app_user_guru.id_guru
inner join ak_matapelajaran on gmp_ngajar.kd_mapel=ak_matapelajaran.kode_mapel
inner join ak_kelas on gmp_ngajar.kd_kelas = ak_kelas.kode_kelas 
inner join ak_perkelas on ak_kelas.nama_kelas=ak_perkelas.nm_kelas and gmp_ngajar.thnajaran=ak_perkelas.tahunajaran
inner join siswa_biodata on ak_perkelas.nis=siswa_biodata.nis
where ak_ngajar.thnajaran='$thnajaran' and gmp_ngajar.ganjilgenap='$gg' and ak_kelas.kode_kelas='$kelas'
order by ak_kelas.nama_kelas,ak_matapelajaran.kode_mapel,siswa_biodata.nis");
$baris=3;
$No=1;
while($HNilai=mysql_fetch_array($Q))
{
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
	where gmp_kikd.kode_ngajar='".$HNilai['id_ngajar']."'";

	$JDKS=mysql_num_rows(mysql_query("$QDK and ak_kikd.kode_ranah='KDS'"));
	$JDKP=mysql_num_rows(mysql_query("$QDK and ak_kikd.kode_ranah='KDP'"));
	$JDKK=mysql_num_rows(mysql_query("$QDK and ak_kikd.kode_ranah='KDK'"));

	$QNSS=mysql_query("select * from n_sikap where kd_ngajar='".$HNilai['id_ngajar']."' and nis='".$HNilai['nis']."'");
	$HNSS=mysql_fetch_array($QNSS);

	$objPHPExcel->getActiveSheet()->setCellValue('A'.$baris, $No);
	$objPHPExcel->getActiveSheet()->setCellValue('B'.$baris, $HNilai['nama_kelas']);
	$objPHPExcel->getActiveSheet()->setCellValue('C'.$baris, $HNilai['thnajaran']);
	$objPHPExcel->getActiveSheet()->setCellValue('D'.$baris, $HNilai['semester']);
	$objPHPExcel->getActiveSheet()->setCellValue('E'.$baris, $HNilai['id_ngajar']);
	$objPHPExcel->getActiveSheet()->setCellValue('F'.$baris, $HNilai['nis']);
	$objPHPExcel->getActiveSheet()->setCellValue('G'.$baris, $HNilai['nm_siswa']);
	$objPHPExcel->getActiveSheet()->setCellValue('H'.$baris, $HNSS['spritual']);
	$objPHPExcel->getActiveSheet()->setCellValue('I'.$baris, $HNSS['sosial']);
	$objPHPExcel->getActiveSheet()->setCellValue('J'.$baris, $HNSS['desk_spritual']);
	$objPHPExcel->getActiveSheet()->setCellValue('K'.$baris, $HNSS['desk_sosial']);
	$objPHPExcel->getActiveSheet()->setCellValue('L'.$baris, $JDKS);

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


	$QNSP=mysql_query("select * from n_p_kikd where kd_ngajar='".$HNilai['id_ngajar']."' and nis='".$HNilai['nis']."'");
	$HNSP=mysql_fetch_array($QNSP);

	$kolomK3='M';
	for($x=1;$x<=15+1;$x++){
		$objPHPExcel->getActiveSheet()->setCellValue($kolomK3.$baris, $HNSP['kd_'.$x]);
		$objPHPExcel->getActiveSheet()->getStyle($kolomK3.$baris)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getColumnDimension($kolomK3)->setAutoSize(true);
		$kolomK3++;
	}

	$QNSU=mysql_query("select * from n_utsuas where kd_ngajar='".$HNilai['id_ngajar']."' and nis='".$HNilai['nis']."'");
	$HNSU=mysql_fetch_array($QNSU);
	$NAP=round(($HNSU['uts']+$HNSU['uas']+$HNSP['kikd_p'])/3,2);

	$objPHPExcel->getActiveSheet()->setCellValue('AA'.$baris, $HNSU['uts']);
	$objPHPExcel->getActiveSheet()->setCellValue('AB'.$baris, $HNSU['uas']);
	$objPHPExcel->getActiveSheet()->setCellValue('AC'.$baris, $HNSP['kikd_p']);
	$objPHPExcel->getActiveSheet()->setCellValue('AD'.$baris, $JDKP);
	$objPHPExcel->getActiveSheet()->setCellValue('AE'.$baris, $NAP);

	$objPHPExcel->getActiveSheet()->getStyle('AA'.$baris)->applyFromArray($style_row);
	$objPHPExcel->getActiveSheet()->getStyle('AB'.$baris)->applyFromArray($style_row);
	$objPHPExcel->getActiveSheet()->getStyle('AC'.$baris)->applyFromArray($style_row);
	$objPHPExcel->getActiveSheet()->getStyle('AD'.$baris)->applyFromArray($style_row);
	$objPHPExcel->getActiveSheet()->getStyle('AE'.$baris)->applyFromArray($style_row);

	$QNSK=mysql_query("select * from n_k_kikd where kd_ngajar='".$HNilai['id_ngajar']."' and nis='".$HNilai['nis']."'");
	$HNSK=mysql_fetch_array($QNSK);
	$NK=round($HNSK['kikd_k'],2);
	$NA=round(($HNSK['kikd_k']+$NAP)/2,2);

	$kolomK4='AF';
	for($x=1;$x<=15+1;$x++){
		$objPHPExcel->getActiveSheet()->setCellValue($kolomK4.$baris, $HNSK['kd_'.$x]);
		$objPHPExcel->getActiveSheet()->getStyle($kolomK4.$baris)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getColumnDimension($kolomK4)->setAutoSize(true);
		$kolomK4++;
	}

	$objPHPExcel->getActiveSheet()->setCellValue('AU'.$baris, $NK);
	$objPHPExcel->getActiveSheet()->setCellValue('AV'.$baris, $JDKK);
	$objPHPExcel->getActiveSheet()->setCellValue('AW'.$baris, $NA);
	$objPHPExcel->getActiveSheet()->setCellValue('AX'.$baris, $HNilai['nama_mapel']);
	$objPHPExcel->getActiveSheet()->setCellValue('AY'.$baris, $HNilai['nama_lengkap']);

	$objPHPExcel->getActiveSheet()->getStyle('AU'.$baris)->applyFromArray($style_row);
	$objPHPExcel->getActiveSheet()->getStyle('AV'.$baris)->applyFromArray($style_row);
	$objPHPExcel->getActiveSheet()->getStyle('AW'.$baris)->applyFromArray($style_row);
	$objPHPExcel->getActiveSheet()->getStyle('AX'.$baris)->applyFromArray($style_row);
	$objPHPExcel->getActiveSheet()->getStyle('AY'.$baris)->applyFromArray($style_row);

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
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('U')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('V')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('W')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('AA')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('AB')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('AC')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('AD')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('AE')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('AF')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('AG')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('AH')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('AI')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('AJ')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('AK')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('AL')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('AM')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('AN')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('AO')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('AP')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('AQ')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('AR')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('AS')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('AT')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('AU')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('AV')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('AW')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('AQ')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('AY')->setAutoSize(true);

$NamaFile=$thnajaran." ".strtoupper($gg)." ".$kelas;

// Mencetak File Excel 
header('Content-Type: application/vnd.ms-excel'); 
header('Content-Disposition: attachment;filename="'.$NamaFile.'.xls"'); 
header('Cache-Control: max-age=0'); 
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
$objWriter->save('php://output');

?>