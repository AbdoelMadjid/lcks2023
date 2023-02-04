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

$kelas=(isset($_GET['kls']))?$_GET['kls']:"";
$thnajaran=(isset($_GET['thnajaran']))?$_GET['thnajaran']:"";
$gg=(isset($_GET['gg']))?$_GET['gg']:"";
$jn=(isset($_GET['jn']))?$_GET['jn']:"";
if($jn=="k3"){$jnil="PENGETAHUAN";}else if($jn=="k4"){$jnil="KETERAMPILAN";}else if($jn=="kutsuas"){$jnil="UTS UAS";}else if($jn=="sikap"){$jnil="SIKAP";}

require_once 'Classes/PHPExcel.php';
$objPHPExcel = new PHPExcel();

$objPHPExcel->getProperties()->setCreator("Abdul Madjid, SPd., M.Pd.")
							 ->setLastModifiedBy("Abdul Madjid, SPd., M.Pd.")
							 ->setTitle("NILAI MAPEL")
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
$objPHPExcel->getActiveSheet()->setCellValue('A1', "No.");
$objPHPExcel->getActiveSheet()->setCellValue('B1', "Kode KBM");
$objPHPExcel->getActiveSheet()->setCellValue('C1', "NIS");
$objPHPExcel->getActiveSheet()->setCellValue('D1', "Nama Siswa"); 

$objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($style_col);

cellColor('A1:D1', 'cccccc');

if($jn=="k3" || $jn=="k4"){
	$kolom='E';
	for($x=1;$x<=15+1;$x++){
		$objPHPExcel->getActiveSheet()->setCellValue($kolom.'1', $x);
		$objPHPExcel->getActiveSheet()->getStyle($kolom.'1')->applyFromArray($style_col);
		cellColor($kolom.'1:'.$kolom.'1', 'cccccc');
		$kolom++;
	}
	$objPHPExcel->getActiveSheet()->setCellValue('T1', "R2"); 
	$objPHPExcel->getActiveSheet()->setCellValue('U1', "KIKD"); 
	$objPHPExcel->getActiveSheet()->setCellValue('V1', "Mata Pelajaran"); 
	$objPHPExcel->getActiveSheet()->setCellValue('W1', "Guru Pengajar"); 
	
	$objPHPExcel->getActiveSheet()->getStyle('T1')->applyFromArray($style_col);
	$objPHPExcel->getActiveSheet()->getStyle('U1')->applyFromArray($style_col);
	$objPHPExcel->getActiveSheet()->getStyle('V1')->applyFromArray($style_col);
	$objPHPExcel->getActiveSheet()->getStyle('W1')->applyFromArray($style_col);
	
	cellColor('T1:W1', 'cccccc');
}
else if($jn=="kutsuas"){
	$objPHPExcel->getActiveSheet()->setCellValue('E1', "UTS"); 
	$objPHPExcel->getActiveSheet()->setCellValue('F1', "UAS"); 
	$objPHPExcel->getActiveSheet()->setCellValue('G1', "Mata Pelajaran"); 
	$objPHPExcel->getActiveSheet()->setCellValue('H1', "Guru Pengajar"); 

	$objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray($style_col);
	$objPHPExcel->getActiveSheet()->getStyle('F1')->applyFromArray($style_col);
	$objPHPExcel->getActiveSheet()->getStyle('G1')->applyFromArray($style_col);
	$objPHPExcel->getActiveSheet()->getStyle('H1')->applyFromArray($style_col);
	
	cellColor('E1:H1', 'cccccc');

}
else if($jn=="sikap"){
	$objPHPExcel->getActiveSheet()->setCellValue('E1', "K1"); 
	$objPHPExcel->getActiveSheet()->setCellValue('F1', "K2"); 
	$objPHPExcel->getActiveSheet()->setCellValue('G1', "DK1"); 
	$objPHPExcel->getActiveSheet()->setCellValue('H1', "DK2"); 
	$objPHPExcel->getActiveSheet()->setCellValue('I1', "KIKD"); 
	$objPHPExcel->getActiveSheet()->setCellValue('J1', "Mata Pelajaran"); 
	$objPHPExcel->getActiveSheet()->setCellValue('K1', "Guru Pengajar"); 

	$objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray($style_col);
	$objPHPExcel->getActiveSheet()->getStyle('F1')->applyFromArray($style_col);
	$objPHPExcel->getActiveSheet()->getStyle('G1')->applyFromArray($style_col);
	$objPHPExcel->getActiveSheet()->getStyle('H1')->applyFromArray($style_col);
	$objPHPExcel->getActiveSheet()->getStyle('I1')->applyFromArray($style_col);
	$objPHPExcel->getActiveSheet()->getStyle('J1')->applyFromArray($style_col);
	$objPHPExcel->getActiveSheet()->getStyle('K1')->applyFromArray($style_col);

	cellColor('E1:K1', 'cccccc');
}

$Q=mysql_query("
select 
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
where gmp_ngajar.thnajaran='$thnajaran' and gmp_ngajar.ganjilgenap='$gg' and ak_kelas.kode_kelas='$kelas'
order by ak_kelas.nama_kelas,ak_matapelajaran.kode_mapel,siswa_biodata.nis
");

$baris=2;
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

	$objPHPExcel->getActiveSheet()->setCellValue('A'.$baris, $No);
	$objPHPExcel->getActiveSheet()->setCellValue('B'.$baris, $HNilai['id_ngajar']);
	$objPHPExcel->getActiveSheet()->setCellValue('C'.$baris, $HNilai['nis']);
	$objPHPExcel->getActiveSheet()->setCellValue('D'.$baris, $HNilai['nm_siswa']);

	$objPHPExcel->getActiveSheet()->getStyle('A'.$baris)->applyFromArray($style_row);
	$objPHPExcel->getActiveSheet()->getStyle('B'.$baris)->applyFromArray($style_row);
	$objPHPExcel->getActiveSheet()->getStyle('C'.$baris)->applyFromArray($style_row);
	$objPHPExcel->getActiveSheet()->getStyle('D'.$baris)->applyFromArray($style_row);

	if($jn=="k3"){
		$QNS=mysql_query("select * from n_p_kikd where kd_ngajar='".$HNilai['id_ngajar']."' and nis='".$HNilai['nis']."'");
		$HNS=mysql_fetch_array($QNS);
		
		$kolomK3='E';
		for($x=1;$x<=15+1;$x++){
			$objPHPExcel->getActiveSheet()->setCellValue($kolomK3.$baris, $HNS['kd_'.$x]);
			$objPHPExcel->getActiveSheet()->getStyle($kolomK3.$baris)->applyFromArray($style_row);
			$objPHPExcel->getActiveSheet()->getColumnDimension($kolomK3)->setAutoSize(true);
			$kolomK3++;
		}
		$objPHPExcel->getActiveSheet()->setCellValue('T'.$baris, $HNS['kikd_p']);
		$objPHPExcel->getActiveSheet()->setCellValue('U'.$baris, $JDKP);
		$objPHPExcel->getActiveSheet()->setCellValue('V'.$baris, $HNilai['nama_mapel']);
		$objPHPExcel->getActiveSheet()->setCellValue('W'.$baris, $HNilai['nama_lengkap']);

		$objPHPExcel->getActiveSheet()->getStyle('T'.$baris)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('U'.$baris)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('V'.$baris)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('W'.$baris)->applyFromArray($style_row);

		$baris++;
		$No++;
	}
	else if($jn=="k4"){
		$QNS=mysql_query("select * from n_k_kikd where kd_ngajar='".$HNilai['id_ngajar']."' and nis='".$HNilai['nis']."'");
		$HNS=mysql_fetch_array($QNS);
		
		$kolomK4='E';
		for($x=1;$x<=15+1;$x++){
			$objPHPExcel->getActiveSheet()->setCellValue($kolomK4.$baris, $HNS['kd_'.$x]);
			$objPHPExcel->getActiveSheet()->getStyle($kolomK4.$baris)->applyFromArray($style_row);
			$objPHPExcel->getActiveSheet()->getColumnDimension($kolomK4)->setAutoSize(true);
			$kolomK4++;
		}
		$objPHPExcel->getActiveSheet()->setCellValue('T'.$baris, $HNS['kikd_K']);
		$objPHPExcel->getActiveSheet()->setCellValue('U'.$baris, $JDKK);
		$objPHPExcel->getActiveSheet()->setCellValue('V'.$baris, $HNilai['nama_mapel']);
		$objPHPExcel->getActiveSheet()->setCellValue('W'.$baris, $HNilai['nama_lengkap']);

		$objPHPExcel->getActiveSheet()->getStyle('T'.$baris)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('U'.$baris)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('V'.$baris)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('W'.$baris)->applyFromArray($style_row);

		$baris++;
		$No++;
	}
	else if($jn=="kutsuas"){
		$QNS=mysql_query("select * from n_utsuas where kd_ngajar='".$HNilai['id_ngajar']."' and nis='".$HNilai['nis']."'");
		$HNS=mysql_fetch_array($QNS);

		$objPHPExcel->getActiveSheet()->setCellValue('E'.$baris, $HNS['uts']);
		$objPHPExcel->getActiveSheet()->setCellValue('F'.$baris, $HNS['uas']);
		$objPHPExcel->getActiveSheet()->setCellValue('G'.$baris, $HNilai['nama_mapel']);
		$objPHPExcel->getActiveSheet()->setCellValue('H'.$baris, $HNilai['nama_lengkap']);

		$objPHPExcel->getActiveSheet()->getStyle('E'.$baris)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('F'.$baris)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('G'.$baris)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('H'.$baris)->applyFromArray($style_row);

		$baris++;
		$No++;
	}
	else if($jn=="sikap"){
		$QNS=mysql_query("select * from n_sikap where kd_ngajar='".$HNilai['id_ngajar']."' and nis='".$HNilai['nis']."'");
		$HNS=mysql_fetch_array($QNS);

		$objPHPExcel->getActiveSheet()->setCellValue('E'.$baris, $HNS['spritual']);
		$objPHPExcel->getActiveSheet()->setCellValue('F'.$baris, $HNS['sosial']);
		$objPHPExcel->getActiveSheet()->setCellValue('G'.$baris, $HNS['desk_spritual']);
		$objPHPExcel->getActiveSheet()->setCellValue('H'.$baris, $HNS['desk_sosial']);
		$objPHPExcel->getActiveSheet()->setCellValue('I'.$baris, $JDKS);
		$objPHPExcel->getActiveSheet()->setCellValue('J'.$baris, $HNilai['nama_mapel']);
		$objPHPExcel->getActiveSheet()->setCellValue('K'.$baris, $HNilai['nama_lengkap']);

		$objPHPExcel->getActiveSheet()->getStyle('E'.$baris)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('F'.$baris)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('G'.$baris)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('H'.$baris)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('I'.$baris)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('J'.$baris)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('K'.$baris)->applyFromArray($style_row);
		$baris++;

		$No++;
	}
}

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5.00);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);

if($jn=="kutsuas"){
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
}
else if($jn=="sikap"){
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
}else
{
	$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('U')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('V')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('W')->setAutoSize(true);
}


$NamaFile=$thnajaran." ".strtoupper($gg)." ".$kelas." ".$jnil;

// Mencetak File Excel 
header('Content-Type: application/vnd.ms-excel'); 
header('Content-Disposition: attachment;filename="'.$NamaFile.'.xls"'); 
header('Cache-Control: max-age=0'); 
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
$objWriter->save('php://output');

?>