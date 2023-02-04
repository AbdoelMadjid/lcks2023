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

$kbm=isset($_GET['kbm'])?$_GET['kbm']:""; 
$mapel=isset($_GET['mapel'])?$_GET['mapel']:""; 
$kls=isset($_GET['kls'])?$_GET['kls']:""; 
$thnajar=isset($_GET['thnajar'])?$_GET['thnajar']:""; 
$semester=isset($_GET['semester'])?$_GET['semester']:""; 

$QProfil=mysql_query("select * from profil");
$HProfil=mysql_fetch_array($QProfil);

$Q=mysql_query("
select 
gmp_ngajar.id_ngajar,
gmp_ngajar.thnajaran,
gmp_ngajar.semester,
gmp_ngajar.ganjilgenap,
gmp_ngajar.kkmpeng, 
gmp_ngajar.kkmket,
ak_kelas.nama_kelas,
gmp_ngajar.kd_mapel,
ak_matapelajaran.nama_mapel,
app_user_guru.nama_lengkap,
app_user_guru.nip,
ak_perkelas.nis,
siswa_biodata.nm_siswa 
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
gmp_ngajar.id_ngajar='$kbm' order by siswa_biodata.nm_siswa,siswa_biodata.nis");

$jmlSiswa=mysql_num_rows($Q);

require_once 'Classes/PHPExcel.php';
$objPHPExcel = new PHPExcel();

$objPHPExcel->getProperties()->setCreator("Abdul Madjid, SPd., M.Pd.")
							 ->setLastModifiedBy("Abdul Madjid, SPd., M.Pd.")
							 ->setTitle("LAPORAN NILAI")
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

$objPHPExcel->getActiveSheet()->mergeCells('A1:N1');
$objPHPExcel->getActiveSheet()->setCellValue('A1', "LAPORAN NILAI SEMESTER");
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setName('Arial');
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$objPHPExcel->getActiveSheet()->mergeCells('A3:B3');
$objPHPExcel->getActiveSheet()->setCellValue('A3', "Tahun Pelajaran");
$objPHPExcel->getActiveSheet()->mergeCells('A4:B4');
$objPHPExcel->getActiveSheet()->setCellValue('A4', "Semester");
$objPHPExcel->getActiveSheet()->mergeCells('A5:B5');
$objPHPExcel->getActiveSheet()->setCellValue('A5', "Kelas");
$objPHPExcel->getActiveSheet()->mergeCells('A6:B6');
$objPHPExcel->getActiveSheet()->setCellValue('A6', "Mata Pelajaran");

$objPHPExcel->getActiveSheet()->mergeCells('C3:N3');
$objPHPExcel->getActiveSheet()->setCellValue('C3', ": ".$thnajar);
$objPHPExcel->getActiveSheet()->mergeCells('C4:N4');
$objPHPExcel->getActiveSheet()->setCellValue('C4', ": ".$semester);
$objPHPExcel->getActiveSheet()->mergeCells('C5:N5');
$objPHPExcel->getActiveSheet()->setCellValue('C5', ": ".$kls);
$objPHPExcel->getActiveSheet()->mergeCells('C6:N6');
$objPHPExcel->getActiveSheet()->setCellValue('C6', ": ".$mapel);

$objPHPExcel->getActiveSheet()->mergeCells('A8:A9');
$objPHPExcel->getActiveSheet()->setCellValue('A8', " NO. ");
$objPHPExcel->getActiveSheet()->mergeCells('B8:B9');
$objPHPExcel->getActiveSheet()->setCellValue('B8', "NIS");
$objPHPExcel->getActiveSheet()->mergeCells('C8:C9');
$objPHPExcel->getActiveSheet()->setCellValue('C8', "NAMA SISWA");
$objPHPExcel->getActiveSheet()->mergeCells('D8:E8');
$objPHPExcel->getActiveSheet()->setCellValue('D8', "NK1K2");
$objPHPExcel->getActiveSheet()->setCellValue('D9', " SP ");
$objPHPExcel->getActiveSheet()->setCellValue('E9', " SO ");
$objPHPExcel->getActiveSheet()->mergeCells('F8:J8');
$objPHPExcel->getActiveSheet()->setCellValue('F8', "NK3");
$objPHPExcel->getActiveSheet()->setCellValue('F9', "NHP");
$objPHPExcel->getActiveSheet()->setCellValue('G9', "UTS");
$objPHPExcel->getActiveSheet()->setCellValue('H9', "UAS");
$objPHPExcel->getActiveSheet()->setCellValue('I9', " NA ");
$objPHPExcel->getActiveSheet()->setCellValue('J9', " P ");
$objPHPExcel->getActiveSheet()->mergeCells('K8:L8');
$objPHPExcel->getActiveSheet()->setCellValue('K8', "NK4");
$objPHPExcel->getActiveSheet()->setCellValue('K9', " NA ");
$objPHPExcel->getActiveSheet()->setCellValue('L9', " P ");
$objPHPExcel->getActiveSheet()->mergeCells('M8:M9');
$objPHPExcel->getActiveSheet()->setCellValue('M8', " R2 ");
$objPHPExcel->getActiveSheet()->mergeCells('N8:N9');
$objPHPExcel->getActiveSheet()->setCellValue('N8', " PS ");
//$objPHPExcel->getActiveSheet()->getColumnDimension('A3')->setAutoSize(true);

$objPHPExcel->getActiveSheet()->getStyle('A8:A9')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('B8:B9')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('C8:C9')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('D8:E8')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('D9')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('E9')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('F8:J8')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('F9')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('G9')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('H9')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('I9')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('J9')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('K8:L9')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('K9')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('L9')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('M8:M9')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('N8:N9')->applyFromArray($style_col);

cellColor('A8:N9', 'cccccc');

$baris=10;  
$no=1;
while($Hasil=mysql_fetch_array($Q)){ 
	$Matapel=$Hasil['nama_mapel'];
	$Kls=$Hasil['nama_kelas'];
	$GuruNgajar=$Hasil['nama_lengkap'];
	$GuruNgajarNIP=$Hasil['nip'];
	$ThnAjaran=$Hasil['thnajaran'];
	$Smstr=$Hasil['semester']." (".$Hasil['ganjilgenap'].")";
	$NISna=$Hasil['nis'];
	$NilaiKKMP=$Hasil['kkmpeng'];
	$NilaiKKMK=$Hasil['kkmket'];
	
	//tampilkan nilai PENGETAHUAN ==========================================

	$QNKDP=mysql_query("select * from n_p_kikd where kd_ngajar='$kbm' and nis='$NISna'");
	$JmlNKDP=mysql_num_rows($QNKDP);
	$NKDP=mysql_fetch_array($QNKDP);

	$QNUTSUAS=mysql_query("select * from n_utsuas where kd_ngajar='$kbm' and nis='$NISna'");
	$JmlNUTSUAS=mysql_num_rows($QNUTSUAS);
	$NKUTSUAS=mysql_fetch_array($QNUTSUAS);
	
	//tampilkan nilai KETERAMPILAN ==========================================

	$QNKDK=mysql_query("select * from n_k_kikd where kd_ngajar='$kbm' and nis='$NISna'");
	$JmlNKDK=mysql_num_rows($QNKDK);
	$NKDK=mysql_fetch_array($QNKDK);
	
	//====================================================================================[tampilkan nilai SOSIAL]

	$QNKDS=mysql_query("select * from n_sikap where kd_ngajar='$kbm' and nis='$NISna'");
	$NKDS=mysql_fetch_array($QNKDS);
	$NSpritual=$NKDS['spritual'];
	$NSosial=$NKDS['sosial'];
	
	//tampilkan nilai RATA-RATA ==========================================

	$QR=mysql_query("select * from n_transkrip where kd_ngajar='$kbm' and nis='$NISna'");
	$NR=mysql_fetch_array($QR);
	
	/*
	$QRank2=mysql_query("SELECT kd_ngajar,nis,rerata AS rata_var,(SELECT COUNT(rerata) + 1 FROM n_transkrip WHERE (rerata > rata_var) AND kd_ngajar='$kbm') AS rank FROM n_transkrip where kd_ngajar='$kbm'");
	
	while($NRank2=mysql_fetch_array($QRank2)){
		if($NRank2['nis']==$NISna){
			$TampilRanking=$NRank2['rank'];
		}
	}
	*/

	$NAP=round(($NKDP['kikd_p']+$NKUTSUAS['uts']+$NKUTSUAS['uas'])/3);
	$PredP=predikat($NAP);
	$PredK=predikat($NKDK['kikd_k']);
	$R2=round(($NAP+$NKDK['kikd_k'])/2);
	$PredSw=predikat($R2);

	$TNilSpr=$TNilSpr+$NSpritual;
	$TNilSos=$TNilSos+$NSosial;
	$TNilKDP=$TNilKDP+$NKDP['kikd_p'];
	$TUTS=$TUTS+$NKUTSUAS['uts'];
	$TUAS=$TUAS+$NKUTSUAS['uas'];
	$TNAD=$TNAD+$NAP;				
	$TNilKDK=$TNilKDK+$NKDK['kikd_k'];
	$TNR=$TNR+$R2;

	$objPHPExcel->getActiveSheet()->setCellValue('A'.$baris, $no);
	$objPHPExcel->getActiveSheet()->setCellValue('B'.$baris, $Hasil['nis']);
	$objPHPExcel->getActiveSheet()->setCellValue('C'.$baris, $Hasil['nm_siswa']);
	$objPHPExcel->getActiveSheet()->setCellValue('D'.$baris, $NSpritual);
	$objPHPExcel->getActiveSheet()->setCellValue('E'.$baris, $NSosial);
	$objPHPExcel->getActiveSheet()->setCellValue('F'.$baris, $NKDP['kikd_p']);
	$objPHPExcel->getActiveSheet()->setCellValue('G'.$baris, $NKUTSUAS['uts']);
	$objPHPExcel->getActiveSheet()->setCellValue('H'.$baris, $NKUTSUAS['uas']);
	$objPHPExcel->getActiveSheet()->setCellValue('I'.$baris, $NAP);
	$objPHPExcel->getActiveSheet()->setCellValue('J'.$baris, $PredP);
	$objPHPExcel->getActiveSheet()->setCellValue('K'.$baris, $NKDK['kikd_k']);
	$objPHPExcel->getActiveSheet()->setCellValue('L'.$baris, $PredK);
	$objPHPExcel->getActiveSheet()->setCellValue('M'.$baris, $R2);
	$objPHPExcel->getActiveSheet()->setCellValue('N'.$baris, $PredSw);

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
	$objPHPExcel->getActiveSheet()->getStyle('N'.$baris)->applyFromArray($style_row);

	$objPHPExcel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('B'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('D'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('E'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('F'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('G'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('H'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('I'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('J'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('K'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('L'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('M'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('N'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	$baris++;
	$no++;
}

$jmldata=mysql_num_rows($Q);
$RNilSpr=round(($TNilSpr/$jmldata),2);
$RNilSos=round(($TNilSos/$jmldata),2);
$RNilKDP=round($TNilKDP/$jmldata);
$RUTS=round($TUTS/$jmldata);
$RUAS=round($TUAS/$jmldata);
$RNAD=round($TNAD/$jmldata);
$PredikatP=predikat($RNAD);
$RNilKDK=round($TNilKDK/$jmldata);
$RNR=round($TNR/$jmldata);
$PredikatK=predikat($RNR);
$Deskripsi=predikat($RNR);

$tglSekarang=date('Y-m-d');

$BariR2=$jmlSiswa+10;

$objPHPExcel->getActiveSheet()->mergeCells('A'.$BariR2.':C'.$BariR2);
$objPHPExcel->getActiveSheet()->setCellValue('A'.$BariR2, "Rata-Rata Kelas");
$objPHPExcel->getActiveSheet()->setCellValue('D'.$BariR2, $RNilSpr);
$objPHPExcel->getActiveSheet()->setCellValue('E'.$BariR2, $RNilSos);
$objPHPExcel->getActiveSheet()->setCellValue('F'.$BariR2, $RNilKDP);
$objPHPExcel->getActiveSheet()->setCellValue('G'.$BariR2, $RUTS);
$objPHPExcel->getActiveSheet()->setCellValue('H'.$BariR2, $RUAS);
$objPHPExcel->getActiveSheet()->setCellValue('I'.$BariR2, $RNAD);
$objPHPExcel->getActiveSheet()->setCellValue('J'.$BariR2, $PredikatP);
$objPHPExcel->getActiveSheet()->setCellValue('K'.$BariR2, $RNilKDK);
$objPHPExcel->getActiveSheet()->setCellValue('L'.$BariR2, $PredikatK);
$objPHPExcel->getActiveSheet()->setCellValue('M'.$BariR2, $RNR);
$objPHPExcel->getActiveSheet()->setCellValue('N'.$BariR2, $Deskripsi);

$objPHPExcel->getActiveSheet()->getStyle('A'.$BariR2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('D'.$BariR2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('E'.$BariR2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('F'.$BariR2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('G'.$BariR2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('H'.$BariR2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('I'.$BariR2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('J'.$BariR2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('K'.$BariR2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('L'.$BariR2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('M'.$BariR2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('N'.$BariR2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$objPHPExcel->getActiveSheet()->getStyle('A'.$BariR2)->applyFromArray($style_row);
$objPHPExcel->getActiveSheet()->getStyle('B'.$BariR2)->applyFromArray($style_row);
$objPHPExcel->getActiveSheet()->getStyle('C'.$BariR2)->applyFromArray($style_row);
$objPHPExcel->getActiveSheet()->getStyle('D'.$BariR2)->applyFromArray($style_row);
$objPHPExcel->getActiveSheet()->getStyle('E'.$BariR2)->applyFromArray($style_row);
$objPHPExcel->getActiveSheet()->getStyle('F'.$BariR2)->applyFromArray($style_row);
$objPHPExcel->getActiveSheet()->getStyle('G'.$BariR2)->applyFromArray($style_row);
$objPHPExcel->getActiveSheet()->getStyle('H'.$BariR2)->applyFromArray($style_row);
$objPHPExcel->getActiveSheet()->getStyle('I'.$BariR2)->applyFromArray($style_row);
$objPHPExcel->getActiveSheet()->getStyle('J'.$BariR2)->applyFromArray($style_row);
$objPHPExcel->getActiveSheet()->getStyle('K'.$BariR2)->applyFromArray($style_row);
$objPHPExcel->getActiveSheet()->getStyle('L'.$BariR2)->applyFromArray($style_row);
$objPHPExcel->getActiveSheet()->getStyle('M'.$BariR2)->applyFromArray($style_row);
$objPHPExcel->getActiveSheet()->getStyle('N'.$BariR2)->applyFromArray($style_row);

cellColor('A'.$BariR2.':N'.$BariR2, 'cccccc');

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
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(4.43);
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(4.43);

$BarisKe=$jmlSiswa+12;
$BarisKe1=$BarisKe+1;

$objPHPExcel->getActiveSheet()->mergeCells('A'.$BarisKe.':C'.$BarisKe);
$objPHPExcel->getActiveSheet()->setCellValue('A'.$BarisKe, "Mengetahui :");
$objPHPExcel->getActiveSheet()->mergeCells('A'.$BarisKe1.':C'.$BarisKe1);
$objPHPExcel->getActiveSheet()->setCellValue('A'.$BarisKe1, "Kepala Sekolah,");

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

$objPHPExcel->getActiveSheet()->mergeCells('A'.$BarisKe2.':C'.$BarisKe2);
$objPHPExcel->getActiveSheet()->setCellValue('A'.$BarisKe2, $HProfil['nm_kepsek']);
$objPHPExcel->getActiveSheet()->mergeCells('A'.$BarisKe3.':C'.$BarisKe3);
$objPHPExcel->getActiveSheet()->setCellValue('A'.$BarisKe3, $NIPKepsek);

$objPHPExcel->getActiveSheet()->mergeCells('G'.$BarisKe2.':N'.$BarisKe2);
$objPHPExcel->getActiveSheet()->setCellValue('G'.$BarisKe2, $GuruNgajar);
$objPHPExcel->getActiveSheet()->mergeCells('G'.$BarisKe3.':N'.$BarisKe3);
$objPHPExcel->getActiveSheet()->setCellValue('G'.$BarisKe3, $NIPGuru);

$objPHPExcel->getActiveSheet()->getStyle('A'.$BarisKe2)->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('G'.$BarisKe2)->getFont()->setBold(true);

$NamaFile=$thnajar."-".$semester."-".$kbm."-".$kls."-".$mapel;
// Mencetak File Excel 
header('Content-Type: application/vnd.ms-excel'); 
header('Content-Disposition: attachment;filename="'.$NamaFile.'.xls"'); 
header('Cache-Control: max-age=0'); 
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
$objWriter->save('php://output');

?>