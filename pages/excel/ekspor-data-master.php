<?php 
/* 02/07/2017 
Design and Programming By. Abdul Madjid, S.Pd., M.Pd.
SMK Negeri 1 Kadipaten
Pin 520543F3 HP. 0812-3000-0420
https://twitter.com/AbdoelMadjid 
https://www.facebook.com/abdulmadjid.mpd

DATA EXCEL =================
- DATAMAPEL
- GURUMAPEL
- GURUMAPEL-SEMESTER
- DATAKIKD
- SISWABIODATA
- USERGURU
- USERWALIKELAS

- format-walikelas (kuriulum-datakbm-perkelas)
- format-nilai-gurumapel (gurumapel-data-penilaian)
- format-absen (gurumapel-data-absensi)
- absensi-mapel (kurikulum-datakbm-perguru)
*/
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING | E_DEPRECATED));
require_once 'koneksi.php';

$eksporex=(isset($_GET['eksporex']))?$_GET['eksporex']:"";
switch($eksporex)
{
	case "datamapel":
		$kd_pk=isset($_GET['kd_pk'])?$_GET['kd_pk']:""; 

		$QPK=mysql_query("select * from ak_paketkeahlian where kode_pk='$kd_pk'");
		$HPK=mysql_fetch_array($QPK);
		$NamaPK=$HPK['nama_paket']." (".$HPK['singkatan'].")";

		require_once 'Classes/PHPExcel.php';
		$objPHPExcel = new PHPExcel();

		$objPHPExcel->getProperties()->setCreator("Abdul Madjid, SPd., M.Pd.")
									 ->setLastModifiedBy("Abdul Madjid, SPd., M.Pd.")
									 ->setTitle("Data Mata Pelajaran ".$NamaPK)
									 ->setCompany("SMKN 1 Kadipaten - Majalengka")
									 ->setCategory("LCKS 2017 - Excel");

		// Set page orientation and size
		$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LEGAL);
		$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0.75);
		$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(1.25);
		$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0.75);
		$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(0.75);
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
		$objPHPExcel->setActiveSheetIndex(0);  

		$objPHPExcel->getActiveSheet()->mergeCells('A1:N1');
		if($kd_pk=="Semua"){
			$objPHPExcel->getActiveSheet()->setCellValue('A1', "DAFTAR MATA PELAJARAN");
			$objPHPExcel->getActiveSheet()->mergeCells('A2:N2');
			$objPHPExcel->getActiveSheet()->setCellValue('A2', "SEMUA PAKET KEAHLIAN");
		}else{
			$objPHPExcel->getActiveSheet()->setCellValue('A1', "DAFTAR MATA PELAJARAN");
			$objPHPExcel->getActiveSheet()->mergeCells('A2:N2');
			$objPHPExcel->getActiveSheet()->setCellValue('A2', $NamaPK);
		}

		$objPHPExcel->getActiveSheet()->getStyle('A1:A2')->getFont()->setName('Arial');
		$objPHPExcel->getActiveSheet()->getStyle('A1:A2')->getFont()->setSize(14);
		$objPHPExcel->getActiveSheet()->getStyle('A1:A2')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A1:A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		//Mencetak header berdasarkan field tabel
		$objPHPExcel->getActiveSheet()->mergeCells('A4:A5');
		$objPHPExcel->getActiveSheet()->setCellValue('A4', "NO.");
		$objPHPExcel->getActiveSheet()->mergeCells('B4:B5');
		$objPHPExcel->getActiveSheet()->setCellValue('B4', "KODE MAPEL");
		$objPHPExcel->getActiveSheet()->mergeCells('C4:C5');
		$objPHPExcel->getActiveSheet()->setCellValue('C4', "KODE PK");
		$objPHPExcel->getActiveSheet()->mergeCells('D4:D5');
		$objPHPExcel->getActiveSheet()->setCellValue('D4', "KEL"); 
		$objPHPExcel->getActiveSheet()->mergeCells('E4:E5');
		$objPHPExcel->getActiveSheet()->setCellValue('E4', "URUT MP"); 
		$objPHPExcel->getActiveSheet()->mergeCells('F4:F5');
		$objPHPExcel->getActiveSheet()->setCellValue('F4', "KEL MP"); 
		$objPHPExcel->getActiveSheet()->mergeCells('G4:G5');
		$objPHPExcel->getActiveSheet()->setCellValue('G4', "NAMA MATA PELAJARAN"); 
		$objPHPExcel->getActiveSheet()->mergeCells('H4:H5');
		$objPHPExcel->getActiveSheet()->setCellValue('H4', "JENIS MAPEL"); 
		$objPHPExcel->getActiveSheet()->mergeCells('I4:N4');
		$objPHPExcel->getActiveSheet()->setCellValue('I4', "SEMESTER"); 
		$objPHPExcel->getActiveSheet()->setCellValue('I5', "1"); 
		$objPHPExcel->getActiveSheet()->setCellValue('J5', "2"); 
		$objPHPExcel->getActiveSheet()->setCellValue('K5', "3"); 
		$objPHPExcel->getActiveSheet()->setCellValue('L5', "4"); 
		$objPHPExcel->getActiveSheet()->setCellValue('M5', "5"); 
		$objPHPExcel->getActiveSheet()->setCellValue('N5', "6"); 

		$objPHPExcel->getActiveSheet()->getStyle('A4:A5')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('B4:B5')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('C4:C5')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('D4:D5')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('E4:E5')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('F4:F5')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('G4:G5')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('H4:H5')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('I4:N4')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('I5')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('J5')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('K5')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('L5')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('M5')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('N5')->applyFromArray($style_col);

		cellColor('A4:N5', 'cccccc');

		if($kd_pk=="Semua")
		{
			$sql = mysql_query("SELECT * FROM ak_matapelajaran");
			$baris=6;
			$no = 1;
			while($data = mysql_fetch_assoc($sql)){

				$objPHPExcel->getActiveSheet()->setCellValue('A'.$baris, $no);
				$objPHPExcel->getActiveSheet()->setCellValue('B'.$baris, $data['kode_mapel']);
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$baris, $data['kode_pk']);
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$baris, $data['kelompok']);
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$baris, $data['urut_mp']);
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$baris, $data['kelmapel']);
				$objPHPExcel->getActiveSheet()->setCellValue('G'.$baris, $data['nama_mapel']);
				$objPHPExcel->getActiveSheet()->setCellValue('H'.$baris, $data['jenismapel']);
				$objPHPExcel->getActiveSheet()->setCellValue('I'.$baris, $data['semester1']);
				$objPHPExcel->getActiveSheet()->setCellValue('J'.$baris, $data['semester2']);
				$objPHPExcel->getActiveSheet()->setCellValue('K'.$baris, $data['semester3']);
				$objPHPExcel->getActiveSheet()->setCellValue('L'.$baris, $data['semester4']);
				$objPHPExcel->getActiveSheet()->setCellValue('M'.$baris, $data['semester5']);
				$objPHPExcel->getActiveSheet()->setCellValue('N'.$baris, $data['semester6']);

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
				$objPHPExcel->getActiveSheet()->getStyle('C'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('E'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
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
		}
		else
		{
			$sql = mysql_query("SELECT * FROM ak_matapelajaran where kode_pk='$kd_pk'");
			$baris=6;
			$no = 1;
			while($data = mysql_fetch_assoc($sql)){

				$objPHPExcel->getActiveSheet()->setCellValue('A'.$baris, $no);
				$objPHPExcel->getActiveSheet()->setCellValue('B'.$baris, $data['kode_mapel']);
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$baris, $data['kode_pk']);
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$baris, $data['kelompok']);
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$baris, $data['urut_mp']);
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$baris, $data['kelmapel']);
				$objPHPExcel->getActiveSheet()->setCellValue('G'.$baris, $data['nama_mapel']);
				$objPHPExcel->getActiveSheet()->setCellValue('H'.$baris, $data['jenismapel']);
				$objPHPExcel->getActiveSheet()->setCellValue('I'.$baris, $data['semester1']);
				$objPHPExcel->getActiveSheet()->setCellValue('J'.$baris, $data['semester2']);
				$objPHPExcel->getActiveSheet()->setCellValue('K'.$baris, $data['semester3']);
				$objPHPExcel->getActiveSheet()->setCellValue('L'.$baris, $data['semester4']);
				$objPHPExcel->getActiveSheet()->setCellValue('M'.$baris, $data['semester5']);
				$objPHPExcel->getActiveSheet()->setCellValue('N'.$baris, $data['semester6']);

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
				$objPHPExcel->getActiveSheet()->getStyle('C'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('E'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('I'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('J'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('K'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('L'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('M'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('N'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$baris++;
				$no++;
			}
		}


		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5.00);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(14.00);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10.00);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(9.00);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10.00);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(9.00);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(14.00);;
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);

		if($kd_pk=="Semua"){
			$NamaFile="DAFTAR MATA PELAJARAN";
		}
		else
		{
			$NamaFile="MATA PELAJARAN - ".$NamaPK;
		}
		// Mencetak File Excel 
		header('Content-Type: application/vnd.ms-excel'); 
		header('Content-Disposition: attachment;filename="'.$NamaFile.'.xls"'); 
		header('Cache-Control: max-age=0'); 
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
		$objWriter->save('php://output');
	break;

	case "gurumapel":
		$thnajaran=(isset($_GET['thnajaran']))?$_GET['thnajaran']:"";
		$gg=isset($_GET['gg'])?$_GET['gg']:""; 
		$tingkat=isset($_GET['tingkat'])?$_GET['tingkat']:""; 
		$id_kls=isset($_GET['id_kls'])?$_GET['id_kls']:""; 

		require_once 'Classes/PHPExcel.php';
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator("Abdul Madjid, SPd., M.Pd.")
									 ->setLastModifiedBy("Abdul Madjid, SPd., M.Pd.")
									 ->setTitle("DATA KBM ".$thnajaran." ".$gg." ".$id_kls)
									 ->setCompany("SMKN 1 Kadipaten - Majalengka")
									 ->setCategory("LCKS 2017 - Excel");
		// Set page orientation and size
		$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LEGAL);
		$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0.50);
		$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(1.50);
		$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0.75);
		$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(0.50);
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
		$objPHPExcel->getActiveSheet()->mergeCells('A2:G2');
		$Judul1="DATA KBM TAHUN AJARAN $thnajaran SEMESTER ".strtoupper($gg);
		$Judul2="KELAS $id_kls";

		$objPHPExcel->getActiveSheet()->setCellValue('A1', $Judul1);
		$objPHPExcel->getActiveSheet()->setCellValue('A2', $Judul2);

		$objPHPExcel->getActiveSheet()->getStyle('A1:A2')->getFont()->setName('Arial');
		$objPHPExcel->getActiveSheet()->getStyle('A1:A2')->getFont()->setSize(12);
		$objPHPExcel->getActiveSheet()->getStyle('A1:A2')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A1:A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$objPHPExcel->getActiveSheet()->setCellValue('A4', "NO.");
		$objPHPExcel->getActiveSheet()->setCellValue('B4', "ID NGAJAR");
		$objPHPExcel->getActiveSheet()->setCellValue('C4', "NAMA TENAGA PENDIDIK");
		$objPHPExcel->getActiveSheet()->setCellValue('D4', "KODE MAPEL");
		$objPHPExcel->getActiveSheet()->setCellValue('E4', "MATA PELAJARAN");
		$objPHPExcel->getActiveSheet()->setCellValue('F4', "KIKD P");
		$objPHPExcel->getActiveSheet()->setCellValue('G4', "KIKD K");

		$objPHPExcel->getActiveSheet()->getStyle('A4')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('B4')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('C4')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('D4')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('E4')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('F4')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('G4')->applyFromArray($style_col);

		$sql = mysql_query("select 
			gmp_ngajar.id_ngajar,
			gmp_ngajar.thnajaran,
			app_user_guru.nama_lengkap,
			ak_matapelajaran.nama_mapel,
			ak_matapelajaran.kode_mapel,
			ak_kelas.nama_kelas,
			gmp_ngajar.jenismapel,
			gmp_ngajar.kd_kelas
			from gmp_ngajar 
			inner join app_user_guru on gmp_ngajar.kd_guru=app_user_guru.id_guru
			inner join ak_matapelajaran on gmp_ngajar.kd_mapel=ak_matapelajaran.kode_mapel
			inner join ak_kelas on gmp_ngajar.kd_kelas = ak_kelas.kode_kelas
			where gmp_ngajar.thnajaran='$thnajaran' and gmp_ngajar.ganjilgenap='$gg' and gmp_ngajar.kd_kelas='$id_kls' order by gmp_ngajar.kd_mapel");

		$baris=5;
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
			inner join ak_kikd on gmp_kikd.kode_kikd=ak_kikd.id_kikd
			inner join gmp_ngajar on gmp_kikd.kode_ngajar=gmp_ngajar.id_ngajar 
			inner join ak_matapelajaran on gmp_ngajar.kd_mapel=ak_matapelajaran.kode_mapel
			inner join app_user_guru on gmp_ngajar.kd_guru=app_user_guru.id_guru
			inner join ak_kelas on gmp_ngajar.kd_kelas=ak_kelas.kode_kelas
			where gmp_kikd.kode_ngajar='$IDNgajarna'";

			$JDKS=mysql_num_rows(mysql_query("$QDK and ak_kikd.kode_ranah='KDS'"));
			$JDKP=mysql_num_rows(mysql_query("$QDK and ak_kikd.kode_ranah='KDP'"));
			$JDKK=mysql_num_rows(mysql_query("$QDK and ak_kikd.kode_ranah='KDK'"));

			$objPHPExcel->getActiveSheet()->setCellValue('A'.$baris, $no);
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$baris, $data['id_ngajar']);
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$baris, $data['nama_lengkap']);
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$baris, $data['kode_mapel']);
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$baris, $data['nama_mapel']);
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
			$objPHPExcel->getActiveSheet()->getStyle('B'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('D'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('F'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('G'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

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

		$NamaFile="GURU MAPEL-".$thnajaran."-".$gg."-".$tingkat."-".$id_kls;
		// Mencetak File Excel 
		header('Content-Type: application/vnd.ms-excel'); 
		header('Content-Disposition: attachment;filename="'.$NamaFile.'.xls"'); 
		header('Cache-Control: max-age=0'); 
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
		$objWriter->save('php://output');
	break;

	case "gurumapel-semester":
		$thnajaran=(isset($_GET['thnajaran']))?$_GET['thnajaran']:"";
		$gg=isset($_GET['gg'])?$_GET['gg']:""; 
		$tingkat=isset($_GET['tingkat'])?$_GET['tingkat']:""; 
		$id_kls=isset($_GET['id_kls'])?$_GET['id_kls']:""; 

		require_once 'Classes/PHPExcel.php';
		$objPHPExcel = new PHPExcel();

		$objPHPExcel->getProperties()->setCreator("Abdul Madjid, SPd., M.Pd.")
									 ->setLastModifiedBy("Abdul Madjid, SPd., M.Pd.")
									 ->setTitle("DATA KBM ".$thnajaran." ".$gg)
									 ->setCompany("SMKN 1 Kadipaten - Majalengka")
									 ->setCategory("LCKS 2017 - Excel");
		// Set page orientation and size
		$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LEGAL);
		$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0.50);
		$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(1.50);
		$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0.75);
		$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(0.50);
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
		$objPHPExcel->setActiveSheetIndex(0);  

		$objPHPExcel->getActiveSheet()->mergeCells('A1:G1');
		$objPHPExcel->getActiveSheet()->mergeCells('A2:G2');
		$Judul1="DATA KBM TAHUN AJARAN $thnajaran SEMESTER ".strtoupper($gg);

		$objPHPExcel->getActiveSheet()->setCellValue('A1', $Judul1);

		$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setName('Arial');
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$objPHPExcel->getActiveSheet()->setCellValue('A3', "NO.");
		$objPHPExcel->getActiveSheet()->setCellValue('B3', "ID NGAJAR");
		$objPHPExcel->getActiveSheet()->setCellValue('C3', "NAMA TENAGA PENDIDIK");
		$objPHPExcel->getActiveSheet()->setCellValue('D3', "KELAS");
		$objPHPExcel->getActiveSheet()->setCellValue('E3', "MATA PELAJARAN");
		$objPHPExcel->getActiveSheet()->setCellValue('F3', "KIKD P");
		$objPHPExcel->getActiveSheet()->setCellValue('G3', "KIKD K");

		$objPHPExcel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('F3')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('G3')->applyFromArray($style_col);

		$sql = mysql_query("select 
			gmp_ngajar.id_ngajar,
			app_user_guru.nama_lengkap,
			ak_matapelajaran.nama_mapel,
			ak_kelas.nama_kelas
			from gmp_ngajar 
			inner join app_user_guru on gmp_ngajar.kd_guru = app_user_guru.id_guru
			inner join ak_matapelajaran on gmp_ngajar.kd_mapel = ak_matapelajaran.kode_mapel
			inner join ak_kelas on gmp_ngajar.kd_kelas = ak_kelas.kode_kelas
			where gmp_ngajar.thnajaran='$thnajaran' and gmp_ngajar.ganjilgenap='$gg' order by kd_kelas,kd_mapel");

		$baris=4;
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
			inner join ak_kikd on gmp_kikd.kode_kikd=ak_kikd.id_kikd
			inner join gmp_ngajar on gmp_kikd.kode_ngajar=gmp_ngajar.id_ngajar 
			inner join ak_matapelajaran on gmp_ngajar.kd_mapel=ak_matapelajaran.kode_mapel
			inner join app_user_guru on gmp_ngajar.kd_guru=app_user_guru.id_guru
			inner join ak_kelas on gmp_ngajar.kd_kelas=ak_kelas.kode_kelas
			where gmp_kikd.kode_ngajar='$IDNgajarna'";

			$JDKS=mysql_num_rows(mysql_query("$QDK and ak_kikd.kode_ranah='KDS'"));
			$JDKP=mysql_num_rows(mysql_query("$QDK and ak_kikd.kode_ranah='KDP'"));
			$JDKK=mysql_num_rows(mysql_query("$QDK and ak_kikd.kode_ranah='KDK'"));

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
			$objPHPExcel->getActiveSheet()->getStyle('G'.$baris)->applyFromArray($style_row);

			$objPHPExcel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('B'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('D'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('F'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('G'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

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

		$objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 3);

		$NamaFile="KBM TAHUN ".$thnajaran." SEMESTER ".$gg;
		// Mencetak File Excel 
		header('Content-Type: application/vnd.ms-excel'); 
		header('Content-Disposition: attachment;filename="'.$NamaFile.'.xls"'); 
		header('Cache-Control: max-age=0'); 
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
		$objWriter->save('php://output');
	break;

	case "datakikd":
		$jenismapel=(isset($_GET['jenismapel']))?$_GET['jenismapel']:"";
		$mapel=(isset($_GET['mapel']))?$_GET['mapel']:"";
		$tingkat=(isset($_GET['tingkat']))?$_GET['tingkat']:"";

		require_once 'Classes/PHPExcel.php';
		$objPHPExcel = new PHPExcel();

		$objPHPExcel->getProperties()->setCreator("Abdul Madjid, SPd., M.Pd.")
									 ->setLastModifiedBy("Abdul Madjid, SPd., M.Pd.")
									 ->setTitle("KIKD ".$mapel." ".$tingkat)
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

		$objPHPExcel->getActiveSheet()->setCellValue('A1', "NO.");
		$objPHPExcel->getActiveSheet()->setCellValue('B1', "JENIS MAPEL");
		$objPHPExcel->getActiveSheet()->setCellValue('C1', "KELOMPOK");
		$objPHPExcel->getActiveSheet()->setCellValue('D1', "NAMA MAPEL");
		$objPHPExcel->getActiveSheet()->setCellValue('E1', "TINGKAT");
		$objPHPExcel->getActiveSheet()->setCellValue('F1', "KODE RANAH");
		$objPHPExcel->getActiveSheet()->setCellValue('G1', "NO. KIKD");
		$objPHPExcel->getActiveSheet()->setCellValue('H1', "ISI KIKD");

		$objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('F1')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('G1')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('H1')->applyFromArray($style_col);

		cellColor('A1:H1', 'cccccc');

		$sql = mysql_query("select * from ak_kikd where jenismapel='".$jenismapel."' and kelompok='".$mapel."' and tingkat='".$tingkat."'");
		$baris=2;
		$no = 1;
		while($data = mysql_fetch_assoc($sql)){
			$NamaMapel=$data['nama_mapel'];
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$baris, $no);
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$baris, $data['jenismapel']);
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$baris, $data['kelompok']);
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$baris, $data['nama_mapel']);
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$baris, $data['tingkat']);
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$baris, $data['kode_ranah']);
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$baris, $data['no_kikd']);
			$objPHPExcel->getActiveSheet()->setCellValue('H'.$baris, $data['isikikd']);

			$objPHPExcel->getActiveSheet()->getStyle('A'.$baris)->applyFromArray($style_row);
			$objPHPExcel->getActiveSheet()->getStyle('B'.$baris)->applyFromArray($style_row);
			$objPHPExcel->getActiveSheet()->getStyle('C'.$baris)->applyFromArray($style_row);
			$objPHPExcel->getActiveSheet()->getStyle('D'.$baris)->applyFromArray($style_row);
			$objPHPExcel->getActiveSheet()->getStyle('E'.$baris)->applyFromArray($style_row);
			$objPHPExcel->getActiveSheet()->getStyle('F'.$baris)->applyFromArray($style_row);
			$objPHPExcel->getActiveSheet()->getStyle('G'.$baris)->applyFromArray($style_row);
			$objPHPExcel->getActiveSheet()->getStyle('H'.$baris)->applyFromArray($style_row);

			$objPHPExcel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('B'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('C'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('E'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('F'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('G'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

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

		$NamaFile="KIKD-".$jenismapel."-".$tingkat." - ".$NamaMapel;

		// Mencetak File Excel 
		header('Content-Type: application/vnd.ms-excel'); 
		header('Content-Disposition: attachment;filename="'.$NamaFile.'.xls"'); 
		header('Cache-Control: max-age=0'); 
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
		$objWriter->save('php://output');
	break;

	case "datakikd-semua":
		require_once 'Classes/PHPExcel.php';
		$objPHPExcel = new PHPExcel();

		$objPHPExcel->getProperties()->setCreator("Abdul Madjid, SPd., M.Pd.")
									 ->setLastModifiedBy("Abdul Madjid, SPd., M.Pd.")
									 ->setTitle("KIKD ".$mapel." ".$tingkat)
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

		$objPHPExcel->getActiveSheet()->setCellValue('A1', "NO.");
		$objPHPExcel->getActiveSheet()->setCellValue('B1', "JENIS MAPEL");
		$objPHPExcel->getActiveSheet()->setCellValue('C1', "KELOMPOK");
		$objPHPExcel->getActiveSheet()->setCellValue('D1', "NAMA MAPEL");
		$objPHPExcel->getActiveSheet()->setCellValue('E1', "TINGKAT");
		$objPHPExcel->getActiveSheet()->setCellValue('F1', "KODE RANAH");
		$objPHPExcel->getActiveSheet()->setCellValue('G1', "NO. KIKD");
		$objPHPExcel->getActiveSheet()->setCellValue('H1', "ISI KIKD");

		$objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('F1')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('G1')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('H1')->applyFromArray($style_col);

		cellColor('A1:H1', 'cccccc');

		$sql = mysql_query("select * from ak_kikd");
		$baris=2;
		$no = 1;
		while($data = mysql_fetch_assoc($sql)){
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$baris, $no);
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$baris, $data['jenismapel']);
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$baris, $data['kelompok']);
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$baris, $data['nama_mapel']);
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$baris, $data['tingkat']);
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$baris, $data['kode_ranah']);
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$baris, $data['no_kikd']);
			$objPHPExcel->getActiveSheet()->setCellValue('H'.$baris, $data['isikikd']);

			$objPHPExcel->getActiveSheet()->getStyle('A'.$baris)->applyFromArray($style_row);
			$objPHPExcel->getActiveSheet()->getStyle('B'.$baris)->applyFromArray($style_row);
			$objPHPExcel->getActiveSheet()->getStyle('C'.$baris)->applyFromArray($style_row);
			$objPHPExcel->getActiveSheet()->getStyle('D'.$baris)->applyFromArray($style_row);
			$objPHPExcel->getActiveSheet()->getStyle('E'.$baris)->applyFromArray($style_row);
			$objPHPExcel->getActiveSheet()->getStyle('F'.$baris)->applyFromArray($style_row);
			$objPHPExcel->getActiveSheet()->getStyle('G'.$baris)->applyFromArray($style_row);
			$objPHPExcel->getActiveSheet()->getStyle('H'.$baris)->applyFromArray($style_row);

			$objPHPExcel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('B'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('C'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('E'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('F'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('G'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

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

		$NamaFile="KIKD SEMUA MATA PELAJARAN";

		// Mencetak File Excel 
		header('Content-Type: application/vnd.ms-excel'); 
		header('Content-Disposition: attachment;filename="'.$NamaFile.'.xls"'); 
		header('Cache-Control: max-age=0'); 
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
		$objWriter->save('php://output');
	break;

	case "siswabiodata":
		$tamasuk=isset($_GET['tamasuk'])?$_GET['tamasuk']:"";
		$kd_pk=isset($_GET['kd_pk'])?$_GET['kd_pk']:"";

		$qpk=mysql_query("SELECT * FROM ak_paketkeahlian where kode_pk='$kd_pk'");
		$hpk=mysql_fetch_assoc($qpk);
		$Nm_PK=$hpk['nama_paket'];

		require_once 'Classes/PHPExcel.php';
		$objPHPExcel = new PHPExcel();

		$judul="Tahun Masuk ".$tamasuk." ".$Nm_PK;

		$objPHPExcel->getProperties()->setCreator("Abdul Madjid, SPd., M.Pd.")
									 ->setLastModifiedBy("Abdul Madjid, SPd., M.Pd.")
									 ->setTitle("BIODATA SISWA ".$tamasuk." - ".$Nm_PK)
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


		$sql=mysql_query("SELECT * FROM siswa_biodata where tahunmasuk='$tamasuk' and kode_paket='$kd_pk'");
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

			$alamatsis='RT '.$dalamat['rt'].' RW '.$dalamat['rw'].' Desa '.$dalamat['desa'].' Kecamatan '.$dalamat['kec'].' Kabupaten '.$dalamat['kab'];
			$telp_siswa=" ".$data['telepon_siswa'];

			$NISN=" ".$data['nisn'];

			$objPHPExcel->getActiveSheet()->setCellValue('A'.$baris, $no);
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$baris, $data['nis']);
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$baris, $NISN);
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$baris, $data['nm_siswa']);
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$baris, $data['tempat_lahir']);
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$baris, $data['tanggal_lahir']);
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

		$NamaFile="BIODATA SISWA ".$tamasuk." ".$Nm_PK;
		// Mencetak File Excel 
		header('Content-Type: application/vnd.ms-excel'); 
		header('Content-Disposition: attachment;filename="'.$NamaFile.'.xls"'); 
		header('Cache-Control: max-age=0'); 
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
		$objWriter->save('php://output');
	break;

	case "userguru":
		require_once 'Classes/PHPExcel.php';
		$objPHPExcel = new PHPExcel();

		$objPHPExcel->getProperties()->setCreator("Abdul Madjid, SPd., M.Pd.")
									 ->setLastModifiedBy("Abdul Madjid, SPd., M.Pd.")
									 ->setTitle("USER GURU")
									 ->setCompany("SMKN 1 Kadipaten - Majalengka")
									 ->setCategory("LCKS 2017 - Excel");

		// Set page orientation and size
		$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LEGAL);
		$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0.50);
		$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(1.20);
		$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0.55);
		$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(0.50);
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
		$objPHPExcel->setActiveSheetIndex(0);  

		$objPHPExcel->getActiveSheet()->mergeCells('A1:H1');
		$objPHPExcel->getActiveSheet()->setCellValue('A1', "DAFTAR USER TENAGA PENDIDIK");
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setName('Arial');
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		//Mencetak header berdasarkan field tabel
		$objPHPExcel->getActiveSheet()->setCellValue('A3', "NO.");
		$objPHPExcel->getActiveSheet()->setCellValue('B3', "ID GURU");
		$objPHPExcel->getActiveSheet()->setCellValue('C3', "NIP");
		$objPHPExcel->getActiveSheet()->setCellValue('D3', "GELAR DEPAN");
		$objPHPExcel->getActiveSheet()->setCellValue('E3', "NAMA TENAGA PENDIDIK");
		$objPHPExcel->getActiveSheet()->setCellValue('F3', "GELAR BELAKANG");
		$objPHPExcel->getActiveSheet()->setCellValue('G3', "USER ID"); 
		$objPHPExcel->getActiveSheet()->setCellValue('H3', "KATA KUNCI"); 

		$objPHPExcel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('F3')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('G3')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('H3')->applyFromArray($style_col);

		cellColor('A3:H3', 'cccccc');

		$sql = mysql_query("SELECT * FROM app_user_guru order by nama_lengkap");

		$baris=4;
		$no = 1;
		while($data = mysql_fetch_assoc($sql)){
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$baris, $no);
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$baris, $data['id_guru']);
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$baris, $data['nip']);
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$baris, $data['gelardepan']);
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$baris, $data['nama_lengkap']);
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$baris, $data['gelarbelakang']);
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$baris, $data['userid']);
			$objPHPExcel->getActiveSheet()->setCellValue('H'.$baris, $data['ket']);

			$objPHPExcel->getActiveSheet()->getStyle('A'.$baris)->applyFromArray($style_row);
			$objPHPExcel->getActiveSheet()->getStyle('B'.$baris)->applyFromArray($style_row);
			$objPHPExcel->getActiveSheet()->getStyle('C'.$baris)->applyFromArray($style_row);
			$objPHPExcel->getActiveSheet()->getStyle('D'.$baris)->applyFromArray($style_row);
			$objPHPExcel->getActiveSheet()->getStyle('E'.$baris)->applyFromArray($style_row);
			$objPHPExcel->getActiveSheet()->getStyle('F'.$baris)->applyFromArray($style_row);
			$objPHPExcel->getActiveSheet()->getStyle('G'.$baris)->applyFromArray($style_row);
			$objPHPExcel->getActiveSheet()->getStyle('H'.$baris)->applyFromArray($style_row);

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

		$objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 3);

		// Mencetak File Excel 
		header('Content-Type: application/vnd.ms-excel'); 
		header('Content-Disposition: attachment;filename="Daftar User Tenaga Pendidik.xls"'); 
		header('Cache-Control: max-age=0'); 
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
		$objWriter->save('php://output');
	break;

	case "userwalikelas":
		$thnajaran=isset($_GET['thnajaran'])?$_GET['thnajaran']:""; 

		require_once 'Classes/PHPExcel.php';
		$objPHPExcel = new PHPExcel();

		$objPHPExcel->getProperties()->setCreator("Abdul Madjid, SPd., M.Pd.")
									 ->setLastModifiedBy("Abdul Madjid, SPd., M.Pd.")
									 ->setTitle("USER WALI KELAS")
									 ->setCompany("SMKN 1 Kadipaten - Majalengka")
									 ->setCategory("LCKS 2017 - Excel");

		// Set page orientation and size
		$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LEGAL);
		$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0.50);
		$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(1.20);
		$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0.55);
		$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(0.50);
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
		$objPHPExcel->setActiveSheetIndex(0);  

		$objPHPExcel->getActiveSheet()->mergeCells('A1:F1');
		$objPHPExcel->getActiveSheet()->setCellValue('A1', "DAFTAR USER WALI KELAS");
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setName('Arial');
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		//Mencetak header berdasarkan field tabel
		$objPHPExcel->getActiveSheet()->setCellValue('A3', "NO.");
		$objPHPExcel->getActiveSheet()->setCellValue('B3', "TAHUN AJARAN");
		$objPHPExcel->getActiveSheet()->setCellValue('C3', "KODE KELAS");
		$objPHPExcel->getActiveSheet()->setCellValue('D3', "NAMA GURU"); 
		$objPHPExcel->getActiveSheet()->setCellValue('E3', "USER ID"); 
		$objPHPExcel->getActiveSheet()->setCellValue('F3', "KATA KUNCI"); 

		$objPHPExcel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('F3')->applyFromArray($style_col);

		cellColor('A3:F3', 'cccccc');


		if($thnajaran=="Semua")
		{
			$sql = mysql_query("SELECT * FROM app_user_walikelas order by kode_kelas,tahunajaran");
			$baris=4;
			$no = 1;
			while($data = mysql_fetch_assoc($sql)){
				
				$objPHPExcel->getActiveSheet()->setCellValue('A'.$baris, $no);
				$objPHPExcel->getActiveSheet()->setCellValue('B'.$baris, $data['tahunajaran']);
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$baris, $data['kode_kelas']);
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$baris, $data['nama_wk']);
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$baris, $data['userid']);
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$baris, $data['kuncina']);

				$objPHPExcel->getActiveSheet()->getStyle('A'.$baris)->applyFromArray($style_row);
				$objPHPExcel->getActiveSheet()->getStyle('B'.$baris)->applyFromArray($style_row);
				$objPHPExcel->getActiveSheet()->getStyle('C'.$baris)->applyFromArray($style_row);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$baris)->applyFromArray($style_row);
				$objPHPExcel->getActiveSheet()->getStyle('E'.$baris)->applyFromArray($style_row);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$baris)->applyFromArray($style_row);

				$objPHPExcel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('B'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$baris++;
				$no++;
			}
		}
		else
		{
			$sql = mysql_query("SELECT * FROM app_user_walikelas where tahunajaran='$thnajaran'");
			$baris=4;
			$no = 1;
			while($data = mysql_fetch_assoc($sql)){
				$objPHPExcel->getActiveSheet()->setCellValue('A'.$baris, $no);
				$objPHPExcel->getActiveSheet()->setCellValue('B'.$baris, $data['tahunajaran']);
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$baris, $data['kode_kelas']);
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$baris, $data['nama_wk']);
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$baris, $data['userid']);
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$baris, $data['kuncina']);

				$objPHPExcel->getActiveSheet()->getStyle('A'.$baris)->applyFromArray($style_row);
				$objPHPExcel->getActiveSheet()->getStyle('B'.$baris)->applyFromArray($style_row);
				$objPHPExcel->getActiveSheet()->getStyle('C'.$baris)->applyFromArray($style_row);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$baris)->applyFromArray($style_row);
				$objPHPExcel->getActiveSheet()->getStyle('E'.$baris)->applyFromArray($style_row);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$baris)->applyFromArray($style_row);

				$objPHPExcel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('B'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$baris++;
				$no++;
			}
		}


		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5.00);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);

		$objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 3);

		$NamaFile="DAFTAR USER WALI KELAS ".$thnajaran;
		// Mencetak File Excel 
		header('Content-Type: application/vnd.ms-excel'); 
		header('Content-Disposition: attachment;filename="'.$NamaFile.'.xls"'); 
		header('Cache-Control: max-age=0'); 
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
		$objWriter->save('php://output');
	break;

	case "format-walikelas":
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
									 ->setTitle("Format Isian Wali Kelas ".$NamaKelas." - ".$thnajaran." - ".$gg)
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

		// SHEET ABSENSI

			$objPHPExcel->getSheet(0)->setTitle('ABSENSI');
			// Setting Worsheet yang aktif 
			$objPHPExcel->setActiveSheetIndex(0);  

			// Set page orientation and size
			$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
			$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0.75);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0.75);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0.75);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(0.75);
			$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&LABSENSI TA '.$thnajaran.' Semester '.$gg);
			$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&LHal: &P / &N '.$NamaKelas);

			//Mencetak header berdasarkan field tabel
			$objPHPExcel->getActiveSheet()->setCellValue('A1', "NO.");
			$objPHPExcel->getActiveSheet()->setCellValue('B1', "NIS");
			$objPHPExcel->getActiveSheet()->setCellValue('C1', "NAMA SISWA");
			$objPHPExcel->getActiveSheet()->setCellValue('D1', "SAKIT"); 
			$objPHPExcel->getActiveSheet()->setCellValue('E1', "IZIN"); 
			$objPHPExcel->getActiveSheet()->setCellValue('F1', "ALFA"); 

			$objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($style_col);
			$objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($style_col);
			$objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($style_col);
			$objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($style_col);
			$objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray($style_col);
			$objPHPExcel->getActiveSheet()->getStyle('F1')->applyFromArray($style_col);

			cellColor('A1:F1', 'cccccc');

			$baris=2;
			$QAbsensi=mysql_query("select ak_perkelas.nis,siswa_biodata.nm_siswa 
			from ak_perkelas inner join siswa_biodata on ak_perkelas.nis=siswa_biodata.nis 
			where ak_perkelas.nm_kelas='".$HKelas['nama_kelas']."' and ak_perkelas.tahunajaran='$thnajaran' order by siswa_biodata.nm_siswa");
			$JmlData=mysql_num_rows($QAbsensi);
			$no=1;
			while($Hasil=mysql_fetch_array($QAbsensi)){

				$objPHPExcel->getActiveSheet()->getRowDimension($baris)->setRowHeight(25);	

				$objPHPExcel->getActiveSheet()->setCellValue('A'.$baris, $no);
				$objPHPExcel->getActiveSheet()->setCellValue('B'.$baris, $Hasil['nis']);
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$baris, $Hasil['nm_siswa']);


				$objPHPExcel->getActiveSheet()->getStyle('A'.$baris)->applyFromArray($style_row);
				$objPHPExcel->getActiveSheet()->getStyle('B'.$baris)->applyFromArray($style_row);
				$objPHPExcel->getActiveSheet()->getStyle('C'.$baris)->applyFromArray($style_row);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$baris)->applyFromArray($style_row);
				$objPHPExcel->getActiveSheet()->getStyle('E'.$baris)->applyFromArray($style_row);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$baris)->applyFromArray($style_row);

				$objPHPExcel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('B'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('E'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$baris++;
				$no++;
			}

			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5.00);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40.00);
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10.00);
			$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10.00);
			$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10.00);

			$objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
			$objPHPExcel->getActiveSheet()
				->getStyle('D2:F'.($JmlData+1))
				->getProtection()->setLocked(
					PHPExcel_Style_Protection::PROTECTION_UNPROTECTED
				);

			$objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 1);

		// SHEET ESKUL

			$myWorkSheet = new PHPExcel_Worksheet($objPHPExcel, 'ESKUL');
			$objPHPExcel->addSheet($myWorkSheet, 1);
			$objPHPExcel->setActiveSheetIndex(1);

			// Set page orientation and size
			$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
			$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0.75);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0.75);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0.75);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(0.75);
			$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&LESKUL TA '.$thnajaran.' Semester '.$gg);
			$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&LHal: &P / &N '.$NamaKelas);

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
			$QEskul=mysql_query("select ak_perkelas.nis,siswa_biodata.nm_siswa 
			from ak_perkelas inner join siswa_biodata on ak_perkelas.nis=siswa_biodata.nis 
			where ak_perkelas.nm_kelas='".$HKelas['nama_kelas']."' and ak_perkelas.tahunajaran='$thnajaran' order by siswa_biodata.nm_siswa");
			$JmlData=mysql_num_rows($QEskul);
			$no=1;
			while($Hasil=mysql_fetch_array($QEskul)){

				$objPHPExcel->getActiveSheet()->getRowDimension($baris)->setRowHeight(25);	

				$objPHPExcel->getActiveSheet()->setCellValue('A'.$baris, $no);
				$objPHPExcel->getActiveSheet()->setCellValue('B'.$baris, $Hasil['nis']);
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$baris, $Hasil['nm_siswa']);
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
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40.00);
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

			$objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
			$objPHPExcel->getActiveSheet()
				->getStyle('E2:M'.($JmlData+1))
				->getProtection()->setLocked(
					PHPExcel_Style_Protection::PROTECTION_UNPROTECTED
				);

			$objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 1);

		// SHEET PRESTASI

			$myWorkSheet = new PHPExcel_Worksheet($objPHPExcel, 'PRESTASI');
			$objPHPExcel->addSheet($myWorkSheet, 2);
			$objPHPExcel->setActiveSheetIndex(2);

			// Set page orientation and size
			$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
			$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0.75);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0.75);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0.75);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(0.75);
			$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&LPRESTASI TA '.$thnajaran.' Semester '.$gg);
			$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&LHal: &P / &N '.$NamaKelas);

			//Mencetak header berdasarkan field tabel
			$objPHPExcel->getActiveSheet()->setCellValue('A1', "NO.");
			$objPHPExcel->getActiveSheet()->setCellValue('B1', "NIS");
			$objPHPExcel->getActiveSheet()->setCellValue('C1', "NAMA SISWA");
			$objPHPExcel->getActiveSheet()->setCellValue('D1', "JENIS ESKUL"); 
			$objPHPExcel->getActiveSheet()->setCellValue('E1', "TINGKAT"); 
			$objPHPExcel->getActiveSheet()->setCellValue('F1', "JUARA KE"); 
			$objPHPExcel->getActiveSheet()->setCellValue('G1', "NAMA PERLOMBAAN"); 
			$objPHPExcel->getActiveSheet()->setCellValue('H1', "TGL"); 
			$objPHPExcel->getActiveSheet()->setCellValue('I1', "BULAN"); 
			$objPHPExcel->getActiveSheet()->setCellValue('J1', "TAHUN"); 
			$objPHPExcel->getActiveSheet()->setCellValue('K1', "TEMPAT PELAKSANAAN LOMBA"); 

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

			cellColor('A1:K1', 'cccccc');

			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5.00);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15.00);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40.00);
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15.00);
			$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25.00);
			$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25.00);
			$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(35.00);
			$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10.00);
			$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(10.00);;
			$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10.00);
			$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(35.00);

			for($x=1;$x<51;$x++){
				$objPHPExcel->getActiveSheet()->getRowDimension($x)->setRowHeight(25);	
			}

			$objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 1);

		// SHEET PRAKERIN

			$myWorkSheet = new PHPExcel_Worksheet($objPHPExcel, 'PRAKERIN');
			$objPHPExcel->addSheet($myWorkSheet, 3);
			$objPHPExcel->setActiveSheetIndex(3);

			// Set page orientation and size
			$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
			$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0.75);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0.75);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0.75);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(0.75);
			$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&LPRAKERIN TA '.$thnajaran.' Semester '.$gg);
			$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&LHal: &P / &N '.$NamaKelas);

			//Mencetak header berdasarkan field tabel
			$objPHPExcel->getActiveSheet()->setCellValue('A1', "NO.");
			$objPHPExcel->getActiveSheet()->setCellValue('B1', "NIS");
			$objPHPExcel->getActiveSheet()->setCellValue('C1', "NAMA SISWA");
			$objPHPExcel->getActiveSheet()->setCellValue('D1', "NAMA PERUSAHAAN"); 
			$objPHPExcel->getActiveSheet()->setCellValue('E1', "ALAMAT PERUSAHAAN"); 
			$objPHPExcel->getActiveSheet()->setCellValue('F1', "BULAN AWAL"); 
			$objPHPExcel->getActiveSheet()->setCellValue('G1', "BULAN AKHIR"); 
			$objPHPExcel->getActiveSheet()->setCellValue('H1', "TAHUN AJARAN"); 
			$objPHPExcel->getActiveSheet()->setCellValue('I1', "SEMESTER"); 
			$objPHPExcel->getActiveSheet()->setCellValue('J1', "NILAI"); 

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

			cellColor('A1:J1', 'cccccc');

			$baris=2;
			$QPrakerin=mysql_query("select ak_perkelas.nis,siswa_biodata.nm_siswa 
			from ak_perkelas inner join siswa_biodata on ak_perkelas.nis=siswa_biodata.nis 
			where ak_perkelas.nm_kelas='".$HKelas['nama_kelas']."' and ak_perkelas.tahunajaran='$thnajaran' order by siswa_biodata.nm_siswa");
			$JmlData=mysql_num_rows($QPrakerin);
			$no=1;
			while($Hasil=mysql_fetch_array($QPrakerin)){

				$objPHPExcel->getActiveSheet()->getRowDimension($baris)->setRowHeight(25);	

				$objPHPExcel->getActiveSheet()->setCellValue('A'.$baris, $no);
				$objPHPExcel->getActiveSheet()->setCellValue('B'.$baris, $Hasil['nis']);
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$baris, $Hasil['nm_siswa']);

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

				$objPHPExcel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('B'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$baris++;
				$no++;
			}

			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5.00);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40.00);
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25.00);
			$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25.00);
			$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15.00);
			$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15.00);
			$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20.00);
			$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15.00);
			$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15.00);

			$objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
			$objPHPExcel->getActiveSheet()
				->getStyle('D2:J'.($JmlData+1))
				->getProtection()->setLocked(
					PHPExcel_Style_Protection::PROTECTION_UNPROTECTED
				);

			$objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 1);

		// SHEET CATATAN

			$myWorkSheet = new PHPExcel_Worksheet($objPHPExcel, 'CATATAN');
			$objPHPExcel->addSheet($myWorkSheet, 4);
			$objPHPExcel->setActiveSheetIndex(4);

			// Set page orientation and size
			$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
			$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0.75);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0.75);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0.75);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(0.75);
			$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&LCATATAN TA '.$thnajaran.' Semester '.$gg);
			$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&LHal: &P / &N '.$NamaKelas);

			//Mencetak header berdasarkan field tabel
			$objPHPExcel->getActiveSheet()->setCellValue('A1', "NO.");
			$objPHPExcel->getActiveSheet()->setCellValue('B1', "NIS");
			$objPHPExcel->getActiveSheet()->setCellValue('C1', "NAMA SISWA");
			$objPHPExcel->getActiveSheet()->setCellValue('D1', "CATATAN"); 

			$objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($style_col);
			$objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($style_col);
			$objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($style_col);
			$objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($style_col);

			cellColor('A1:D1', 'cccccc');

			$baris=2;
			$QCatatan=mysql_query("select ak_perkelas.nis,siswa_biodata.nm_siswa 
			from ak_perkelas inner join siswa_biodata on ak_perkelas.nis=siswa_biodata.nis 
			where ak_perkelas.nm_kelas='".$HKelas['nama_kelas']."' and ak_perkelas.tahunajaran='$thnajaran' order by siswa_biodata.nm_siswa");
			$JmlData=mysql_num_rows($QCatatan);
			$no=1;
			while($Hasil=mysql_fetch_array($QCatatan)){
				
				$objPHPExcel->getActiveSheet()->getRowDimension($baris)->setRowHeight(25);	

				$objPHPExcel->getActiveSheet()->setCellValue('A'.$baris, $no);
				$objPHPExcel->getActiveSheet()->setCellValue('B'.$baris, $Hasil['nis']);
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$baris, $Hasil['nm_siswa']);

				$objPHPExcel->getActiveSheet()->getStyle('A'.$baris)->applyFromArray($style_row);
				$objPHPExcel->getActiveSheet()->getStyle('B'.$baris)->applyFromArray($style_row);
				$objPHPExcel->getActiveSheet()->getStyle('C'.$baris)->applyFromArray($style_row);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$baris)->applyFromArray($style_row);

				$objPHPExcel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('B'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$baris++;
				$no++;
			}

			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5.00);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40.00);
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(70.00);

			$objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
			$objPHPExcel->getActiveSheet()
				->getStyle('D2:D'.($JmlData+1))
				->getProtection()->setLocked(
					PHPExcel_Style_Protection::PROTECTION_UNPROTECTED
				);

			$objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 1);

		// SHEET DATA ISIAN

			$myWorkSheet = new PHPExcel_Worksheet($objPHPExcel, 'DATA');
			$objPHPExcel->addSheet($myWorkSheet, 5);
			$objPHPExcel->setActiveSheetIndex(5);

			// Set page orientation and size
			$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
			$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0.75);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0.75);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0.75);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(0.75);
			$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&LDATA ISIAN TA '.$thnajaran.' Semester '.$gg);
			$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&LHal: &P / &N '.$NamaKelas);

			//Mencetak header berdasarkan field tabel
			$objPHPExcel->getActiveSheet()->mergeCells('A1:E1');
			$objPHPExcel->getActiveSheet()->setCellValue('A1', "DATA PENGISIAN ESKUL");
			$objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
			$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);

			$objPHPExcel->getActiveSheet()->mergeCells('A3:B3');
			$objPHPExcel->getActiveSheet()->setCellValue('A3', "NAMA ESKUL PILIHAN");
			$objPHPExcel->getActiveSheet()->getStyle('A3:B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);

			
			$objPHPExcel->getActiveSheet()->setCellValue('A4', "1");
			$objPHPExcel->getActiveSheet()->setCellValue('A5', "2");
			$objPHPExcel->getActiveSheet()->setCellValue('A6', "3"); 
			$objPHPExcel->getActiveSheet()->setCellValue('A7', "4"); 
			$objPHPExcel->getActiveSheet()->setCellValue('A8', "5"); 
			$objPHPExcel->getActiveSheet()->setCellValue('A9', "6"); 
			$objPHPExcel->getActiveSheet()->setCellValue('A10', "7"); 
			$objPHPExcel->getActiveSheet()->setCellValue('A11', "8"); 
			$objPHPExcel->getActiveSheet()->setCellValue('A12', "9"); 
			$objPHPExcel->getActiveSheet()->setCellValue('A13', "10"); 
			$objPHPExcel->getActiveSheet()->setCellValue('A14', "11"); 
			$objPHPExcel->getActiveSheet()->setCellValue('A15', "12"); 
			$objPHPExcel->getActiveSheet()->setCellValue('A16', "13"); 
			$objPHPExcel->getActiveSheet()->setCellValue('A17', "14"); 
			$objPHPExcel->getActiveSheet()->setCellValue('A18', "15"); 
			$objPHPExcel->getActiveSheet()->setCellValue('A19', "16"); 
			$objPHPExcel->getActiveSheet()->setCellValue('A20', "17"); 

			$objPHPExcel->getActiveSheet()->setCellValue('B4', 'PMR');
			$objPHPExcel->getActiveSheet()->setCellValue('B5', 'Pasbraka');
			$objPHPExcel->getActiveSheet()->setCellValue('B6', 'Marching Band');
			$objPHPExcel->getActiveSheet()->setCellValue('B7', 'Bola Voli');
			$objPHPExcel->getActiveSheet()->setCellValue('B8', 'Bola Basket');
			$objPHPExcel->getActiveSheet()->setCellValue('B9', 'PKS');
			$objPHPExcel->getActiveSheet()->setCellValue('B10', 'Karate');
			$objPHPExcel->getActiveSheet()->setCellValue('B11', 'Futsal');
			$objPHPExcel->getActiveSheet()->setCellValue('B12', 'Padus');
			$objPHPExcel->getActiveSheet()->setCellValue('B13', 'Karya Ilmiah');
			$objPHPExcel->getActiveSheet()->setCellValue('B14', 'Jurnalistik');
			$objPHPExcel->getActiveSheet()->setCellValue('B15', 'Majalah Dinding (Mading)');
			$objPHPExcel->getActiveSheet()->setCellValue('B16', 'Kerohanian Bidang Dak\'wah');
			$objPHPExcel->getActiveSheet()->setCellValue('B17', 'Nasyid');
			$objPHPExcel->getActiveSheet()->setCellValue('B18', 'Kaligrafi');
			$objPHPExcel->getActiveSheet()->setCellValue('B19', 'Pasukan Pramuka');
			$objPHPExcel->getActiveSheet()->setCellValue('B20', 'Baca Tulis Qur\'an');

			cellColor('A3:B3', 'cccccc');
			cellColor('A4:A20', 'cccccc');

			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(4);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);


			for($x=3;$x<21;$x++){
				$objPHPExcel->getActiveSheet()->getStyle('A'.$x)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$x)->applyFromArray($style_row);
				$objPHPExcel->getActiveSheet()->getStyle('B'.$x)->applyFromArray($style_row);
			}

			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(2);

			$objPHPExcel->getActiveSheet()->mergeCells('D3:E3');
			$objPHPExcel->getActiveSheet()->setCellValue('D3', 'KRITERIA PENILAIAN');
			$objPHPExcel->getActiveSheet()->getStyle('D3:E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('D3')->getFont()->setBold(true);

			$objPHPExcel->getActiveSheet()->setCellValue('D4', '1');
			$objPHPExcel->getActiveSheet()->setCellValue('D5', '2');
			$objPHPExcel->getActiveSheet()->setCellValue('D6', '3');
			$objPHPExcel->getActiveSheet()->setCellValue('D7', '4');
			$objPHPExcel->getActiveSheet()->setCellValue('D8', '5');
			$objPHPExcel->getActiveSheet()->setCellValue('E4', 'Sangat Baik');
			$objPHPExcel->getActiveSheet()->setCellValue('E5', 'Baik');
			$objPHPExcel->getActiveSheet()->setCellValue('E6', 'Cukup Baik');
			$objPHPExcel->getActiveSheet()->setCellValue('E7', 'Kurang Baik');
			$objPHPExcel->getActiveSheet()->setCellValue('E8', 'Sangat Kurang');


			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(4);
			$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);

			cellColor('D3:E3', 'cccccc');
			cellColor('D4:D8', 'cccccc');


			for($Y=3;$Y<9;$Y++){
				$objPHPExcel->getActiveSheet()->getStyle('D'.$Y)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$Y)->applyFromArray($style_row);
				$objPHPExcel->getActiveSheet()->getStyle('E'.$Y)->applyFromArray($style_row);
			}

			$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(2);

			$objPHPExcel->getActiveSheet()->mergeCells('G1:N1');
			$objPHPExcel->getActiveSheet()->setCellValue('G1', 'DATA PENGISIAN PRESTASI SISWA');
			$objPHPExcel->getActiveSheet()->getStyle('G1:N1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('G1')->getFont()->setSize(14);
			$objPHPExcel->getActiveSheet()->getStyle('G1')->getFont()->setBold(true);

			$objPHPExcel->getActiveSheet()->mergeCells('G3:H3');
			$objPHPExcel->getActiveSheet()->setCellValue('G3', 'JENIS PRESTASI');
			$objPHPExcel->getActiveSheet()->getStyle('G3:H3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('G3')->getFont()->setBold(true);

			$objPHPExcel->getActiveSheet()->setCellValue('G4', '1');
			$objPHPExcel->getActiveSheet()->setCellValue('G5', '2');
			$objPHPExcel->getActiveSheet()->setCellValue('H4', 'Intrakurikuler');
			$objPHPExcel->getActiveSheet()->setCellValue('H5', 'Ekstrakurikuler');

			$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(4);
			$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(25);

			cellColor('G3:H3', 'cccccc');
			cellColor('G4:G5', 'cccccc');

			for($Y=3;$Y<6;$Y++){
				$objPHPExcel->getActiveSheet()->getStyle('G'.$Y)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('G'.$Y)->applyFromArray($style_row);
				$objPHPExcel->getActiveSheet()->getStyle('H'.$Y)->applyFromArray($style_row);
			}

			$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(2);

			$objPHPExcel->getActiveSheet()->mergeCells('J3:K3');
			$objPHPExcel->getActiveSheet()->setCellValue('J3', 'TINGKAT');
			$objPHPExcel->getActiveSheet()->getStyle('J3:J3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('J3')->getFont()->setBold(true);

			$objPHPExcel->getActiveSheet()->setCellValue('J4', '1');
			$objPHPExcel->getActiveSheet()->setCellValue('J5', '2');
			$objPHPExcel->getActiveSheet()->setCellValue('J6', '3');
			$objPHPExcel->getActiveSheet()->setCellValue('J7', '4');
			$objPHPExcel->getActiveSheet()->setCellValue('K4', 'Sekolah');
			$objPHPExcel->getActiveSheet()->setCellValue('K5', 'Kabupaten');
			$objPHPExcel->getActiveSheet()->setCellValue('K6', 'Provinsi');
			$objPHPExcel->getActiveSheet()->setCellValue('K7', 'Nasional');

			$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(4);
			$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(25);

			cellColor('J3:J3', 'cccccc');
			cellColor('J4:J7', 'cccccc');

			for($Y=3;$Y<8;$Y++){
				$objPHPExcel->getActiveSheet()->getStyle('J'.$Y)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('J'.$Y)->applyFromArray($style_row);
				$objPHPExcel->getActiveSheet()->getStyle('K'.$Y)->applyFromArray($style_row);
			}

			$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(2);

			$objPHPExcel->getActiveSheet()->mergeCells('M3:N3');
			$objPHPExcel->getActiveSheet()->setCellValue('M3', 'JUARA KE');
			$objPHPExcel->getActiveSheet()->getStyle('M3:M3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('M3')->getFont()->setBold(true);

			$objPHPExcel->getActiveSheet()->setCellValue('M4', '1');
			$objPHPExcel->getActiveSheet()->setCellValue('M5', '2');
			$objPHPExcel->getActiveSheet()->setCellValue('M6', '3');
			$objPHPExcel->getActiveSheet()->setCellValue('M7', '4');
			$objPHPExcel->getActiveSheet()->setCellValue('M8', '5');
			$objPHPExcel->getActiveSheet()->setCellValue('M9', '6');
			$objPHPExcel->getActiveSheet()->setCellValue('M10', '7');
			$objPHPExcel->getActiveSheet()->setCellValue('N4', 'Umum');
			$objPHPExcel->getActiveSheet()->setCellValue('N5', 'I');
			$objPHPExcel->getActiveSheet()->setCellValue('N6', 'II');
			$objPHPExcel->getActiveSheet()->setCellValue('N7', 'III');
			$objPHPExcel->getActiveSheet()->setCellValue('N8', 'Harapan I');
			$objPHPExcel->getActiveSheet()->setCellValue('N9', 'Harpaan II');
			$objPHPExcel->getActiveSheet()->setCellValue('N10', 'Harapan III');

			$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(4);
			$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(25);

			cellColor('M3:M3', 'cccccc');
			cellColor('M4:M10', 'cccccc');

			for($Y=3;$Y<11;$Y++){
				$objPHPExcel->getActiveSheet()->getStyle('M'.$Y)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('M'.$Y)->applyFromArray($style_row);
				$objPHPExcel->getActiveSheet()->getStyle('N'.$Y)->applyFromArray($style_row);
			}

			$objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);

			$objPHPExcel->setActiveSheetIndex(0);

		$NamaFile="WALI KELAS -".$HKelas['nama_kelas']."-".$thnajaran."-".$gg;
		// Mencetak File Excel 
		header('Content-Type: application/vnd.ms-excel'); 
		header('Content-Disposition: attachment;filename="'.$NamaFile.'.xls"'); 
		header('Cache-Control: max-age=0'); 
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
		$objWriter->save('php://output');
	break;

	case "format-nilai-gurumapel":
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
		
		$DataKDS=mysql_query("select * from gmp_kikd where kode_ngajar='$kbm' and kode_ranah='KDS'");
		$DataKDP=mysql_query("select * from gmp_kikd where kode_ngajar='$kbm' and kode_ranah='KDP'");
		$DataKDK=mysql_query("select * from gmp_kikd where kode_ngajar='$kbm' and kode_ranah='KDK'");
		
		$jmlKDS=mysql_num_rows($DataKDS);
		$jmlKDP=mysql_num_rows($DataKDP);
		$jmlKDK=mysql_num_rows($DataKDK);
		
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
		
		// SHEET K1K2
		
			$objPHPExcel->getSheet(0)->setTitle('K1K2');
			// Setting Worsheet yang aktif 
			$objPHPExcel->setActiveSheetIndex(0);  
		
			$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
			$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0.75);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0.75);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0.75);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(0.75);
			$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&LNILAI SPRITUAL DAN SOSIAL (K1 DAN K2) TA '.$thnajaran.' Semester '.$gg);
			$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&LHal: &P / &N [ '.$kls.' - '.$mapel.' ]');
		
			//Mencetak header berdasarkan field tabel
			$objPHPExcel->getActiveSheet()->setCellValue('A1', "NILAI SPRITUAL DAN SOSIAL (K1 DAN K2)");
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
			$objPHPExcel->getActiveSheet()->setCellValue('E2', "Spritual");
			$objPHPExcel->getActiveSheet()->setCellValue('F2', "Sosial");
			$objPHPExcel->getActiveSheet()->setCellValue('G2', "Desk Spritual");
			$objPHPExcel->getActiveSheet()->setCellValue('H2', "Desk Sosial");
			$objPHPExcel->getActiveSheet()->getStyle('E2')->applyFromArray($style_col);
			$objPHPExcel->getActiveSheet()->getStyle('F2')->applyFromArray($style_col);
			$objPHPExcel->getActiveSheet()->getStyle('G2')->applyFromArray($style_col);
			$objPHPExcel->getActiveSheet()->getStyle('H2')->applyFromArray($style_col);
			cellColor('E2:H2', 'cccccc');
		
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
				$objPHPExcel->getActiveSheet()->getStyle('G'.$baris)->applyFromArray($style_row);
				$objPHPExcel->getActiveSheet()->getStyle('H'.$baris)->applyFromArray($style_row);
		
				$objPHPExcel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('B'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('C'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
				$objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
				$objPHPExcel->getActiveSheet()
					->getStyle('E'.$baris.':H'.$baris)
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
			$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(40.00);
			$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(40.00);
		
			$objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 1);
		
		// SHEET K3
		
			$myWorkSheet = new PHPExcel_Worksheet($objPHPExcel, 'K3');
			$objPHPExcel->addSheet($myWorkSheet, 1);
			$objPHPExcel->setActiveSheetIndex(1);
		
			$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
			$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0.75);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0.75);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0.75);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(0.75);
			$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&LNILAI PENGETAHUAN (K3) TA '.$thnajaran.' Semester '.$gg);
			$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&LHal: &P / &N [ '.$kls.' - '.$mapel.' ]');
		
		
			//Mencetak header berdasarkan field tabel
			$objPHPExcel->getActiveSheet()->setCellValue('A1', "NILAI PENGETAHUAN (K3)");
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
			for($x=1;$x<$jmlKDP+1;$x++){
				$objPHPExcel->getActiveSheet()->setCellValue($column.'2', "KIKD ".$x);
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
				
				for($x=1;$x<$jmlKDP+1;$x++){
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
			$objPHPExcel->addSheet($myWorkSheet, 2);
			$objPHPExcel->setActiveSheetIndex(2);
		
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
		
		
		// SHEET K4
		
			$myWorkSheet = new PHPExcel_Worksheet($objPHPExcel, 'K4');
			$objPHPExcel->addSheet($myWorkSheet, 3);
			$objPHPExcel->setActiveSheetIndex(3);
		
			$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
			$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0.75);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0.75);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0.75);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(0.75);
			$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&LNILAI KETERAMPILAN (K4) TA '.$thnajaran.' Semester '.$gg);
			$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&LHal: &P / &N [ '.$kls.' - '.$mapel.' ]');
		
			//Mencetak header berdasarkan field tabel
			$objPHPExcel->getActiveSheet()->setCellValue('A1', "NILAI KETERAMPILAN (K4)");
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
			for($x=1;$x<$jmlKDK+1;$x++){
				$objPHPExcel->getActiveSheet()->setCellValue($column.'2', "KIKD ".$x);
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
				
				for($x=1;$x<$jmlKDK+1;$x++){
					$objPHPExcel->getActiveSheet()->getStyle($Kolom.$baris)->applyFromArray($style_row);
					$objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
					$objPHPExcel->getActiveSheet()
						->getStyle($Kolom.$baris)
						->getProtection()->setLocked(
							PHPExcel_Style_Protection::PROTECTION_UNPROTECTED
						);
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
			$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
		
			$objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 1);
		
		// SHEET ABSENSI
		
			$myWorkSheet = new PHPExcel_Worksheet($objPHPExcel, 'ABSENSI');
			$objPHPExcel->addSheet($myWorkSheet, 4);
			$objPHPExcel->setActiveSheetIndex(4);
		
			// Set page orientation and size
			$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
			$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0.75);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0.75);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0.75);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(0.75);
			$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&LABSENSI GURU MAPEL TA '.$thnajaran.' Semester '.$gg);
			$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&LHal: &P / &N [ '.$kls.' - '.$mapel.' ]');
		
		
			//Mencetak header berdasarkan field tabel
			$objPHPExcel->getActiveSheet()->setCellValue('A1', "ABSENSI MATA PELAJARAN");
			$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
			$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		
			$objPHPExcel->getActiveSheet()->setCellValue('A2', "NO.");
			$objPHPExcel->getActiveSheet()->setCellValue('B2', "NIS");
			$objPHPExcel->getActiveSheet()->setCellValue('C2', "NAMA SISWA");
			$objPHPExcel->getActiveSheet()->setCellValue('D2', "ABSENSI"); 
			$objPHPExcel->getActiveSheet()->setCellValue('E2', "TGL"); 
			$objPHPExcel->getActiveSheet()->setCellValue('F2', "BULAN"); 
			$objPHPExcel->getActiveSheet()->setCellValue('G2', "TAHUN"); 
			$objPHPExcel->getActiveSheet()->setCellValue('H2', "KETERANGAN"); 
		
			$objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray($style_col);
			$objPHPExcel->getActiveSheet()->getStyle('B2')->applyFromArray($style_col);
			$objPHPExcel->getActiveSheet()->getStyle('C2')->applyFromArray($style_col);
			$objPHPExcel->getActiveSheet()->getStyle('D2')->applyFromArray($style_col);
			$objPHPExcel->getActiveSheet()->getStyle('E2')->applyFromArray($style_col);
			$objPHPExcel->getActiveSheet()->getStyle('F2')->applyFromArray($style_col);
			$objPHPExcel->getActiveSheet()->getStyle('G2')->applyFromArray($style_col);
			$objPHPExcel->getActiveSheet()->getStyle('H2')->applyFromArray($style_col);
		
			cellColor('A2:H2', 'cccccc');
		
			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5.00);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15.00);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40.00);
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15.00);
			$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10.00);
			$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10.00);
			$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10.00);
			$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(35.00);
		
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
	break;

	case "format-absen":
		$kbm=isset($_GET['kbm'])?$_GET['kbm']:""; 

		$QProfil=mysql_query("select * from app_lembaga");
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
		from gmp_ngajar
		inner join ak_perkelas on gmp_ngajar.thnajaran=ak_perkelas.tahunajaran 
		inner join ak_kelas on gmp_ngajar.kd_kelas=ak_kelas.kode_kelas and ak_kelas.nama_kelas=ak_perkelas.nm_kelas
		inner join app_user_guru on gmp_ngajar.kd_guru=app_user_guru.id_guru
		inner join ak_matapelajaran on gmp_ngajar.kd_mapel=ak_matapelajaran.kode_mapel
		inner join siswa_biodata on ak_perkelas.nis=siswa_biodata.nis
		where gmp_ngajar.id_ngajar='$kbm' order by siswa_biodata.nm_siswa,siswa_biodata.nis");
		$H=mysql_fetch_array($Q);
		
		$jmlSiswa=mysql_num_rows($Q);
		
		require_once 'Classes/PHPExcel.php';
		$objPHPExcel = new PHPExcel();
		
		$judul="TAHUN AJARAN ".$H['thnajaran']." SEMESTER ".$H['semester']." (".strtoupper($H['ganjilgenap']).")";
		$MaPelna=$H['nama_mapel'];
		$Kelasna=$H['nama_kelas'];
		$NamaGuru=$H['nama_lengkap'];
		$NIPGuru="NIP. ".$H['nip'];
		
		$QKS=mysql_query("select * from ak_kepsek where thnajaran='".$H['thnajaran']."' and smstr='".$H['ganjilgenap']."'");
		$HKS=mysql_fetch_array($QKS);
		$NamaKepsek=$HKS['nama'];
		$NIPKepsek="NIP. ".$HKS['nip'];

		$objPHPExcel->getProperties()->setCreator("Abdul Madjid, SPd., M.Pd.")
									 ->setLastModifiedBy("Abdul Madjid, SPd., M.Pd.")
									 ->setTitle($Kelasna."-".$MaPelna)
									 ->setCompany("SMKN 1 Kadipaten - Majalengka")
									 ->setCategory("LCKS 2017 - Excel");
		
		// Set page orientation and size
		//$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LEGAL);
		$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0.50);
		$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(1.50);
		$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0.55);
		$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(0.50);
		//$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L&G&L&H');
		$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&LHal: &P / &N -'.$objPHPExcel->getProperties()->getTitle());
		
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
		
		$objPHPExcel->getActiveSheet()->mergeCells('A1:AL1');
		$objPHPExcel->getActiveSheet()->setCellValue('A1', "ABSENSI GURU MATA PELAJARAN");
		$objPHPExcel->getActiveSheet()->mergeCells('A2:AL2');
		$objPHPExcel->getActiveSheet()->setCellValue('A2', $judul);
		
		$objPHPExcel->getActiveSheet()->getStyle('A1:A2')->getFont()->setName('Arial');
		$objPHPExcel->getActiveSheet()->getStyle('A1:A2')->getFont()->setSize(12);
		$objPHPExcel->getActiveSheet()->getStyle('A1:A2')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A1:A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$objPHPExcel->getActiveSheet()->mergeCells('A4:B4');
		$objPHPExcel->getActiveSheet()->setCellValue('A4', "Mata Pelajaran");
		$objPHPExcel->getActiveSheet()->mergeCells('A5:B5');
		$objPHPExcel->getActiveSheet()->setCellValue('A5', "Kelas");
		$objPHPExcel->getActiveSheet()->mergeCells('A6:B6');
		$objPHPExcel->getActiveSheet()->setCellValue('A6', "Nama Guru");
		
		$objPHPExcel->getActiveSheet()->mergeCells('C4:H4');
		$objPHPExcel->getActiveSheet()->setCellValue('C4', ": ".$MaPelna);
		$objPHPExcel->getActiveSheet()->mergeCells('C5:H5');
		$objPHPExcel->getActiveSheet()->setCellValue('C5', ": ".$Kelasna);
		$objPHPExcel->getActiveSheet()->mergeCells('C6:H6');
		$objPHPExcel->getActiveSheet()->setCellValue('C6', ": ".$NamaGuru);
		
		$objPHPExcel->getActiveSheet()->mergeCells('V4:Z4');
		$objPHPExcel->getActiveSheet()->setCellValue('V4', "BULAN");
		$objPHPExcel->getActiveSheet()->mergeCells('V5:Z5');
		$objPHPExcel->getActiveSheet()->setCellValue('V5', "TAHUN");
		$objPHPExcel->getActiveSheet()->setCellValue('AA4', ": ");
		$objPHPExcel->getActiveSheet()->setCellValue('AA5', ": ");
		
		
		$objPHPExcel->getActiveSheet()->mergeCells('A8:A9');
		$objPHPExcel->getActiveSheet()->setCellValue('A8', " NO. ");
		$objPHPExcel->getActiveSheet()->mergeCells('B8:B9');
		$objPHPExcel->getActiveSheet()->setCellValue('B8', "NIS");
		$objPHPExcel->getActiveSheet()->mergeCells('C8:C9');
		$objPHPExcel->getActiveSheet()->setCellValue('C8', "NAMA SISWA");
		$objPHPExcel->getActiveSheet()->mergeCells('D8:AH8');
		$objPHPExcel->getActiveSheet()->setCellValue('D8', "T A N G G A L");
		
		$kolomJ = 'D';
		//Mencetak header berdasarkan field tabel
		for($x=1;$x<=31;$x++){
			$objPHPExcel->getActiveSheet()->setCellValue($kolomJ.'9', $x);
			$objPHPExcel->getActiveSheet()->getStyle($kolomJ.'9')->applyFromArray($style_col);
			$objPHPExcel->getActiveSheet()->getColumnDimension($kolomJ)->setWidth(3.00);
			cellColor($kolomJ.'9:'.$kolomJ.'9', 'cccccc');
			$kolomJ++;
		}
		$objPHPExcel->getActiveSheet()->mergeCells('AI8:AK8');
		$objPHPExcel->getActiveSheet()->setCellValue('AI8', "JUMLAH");
		$objPHPExcel->getActiveSheet()->setCellValue('AI9', "S");
		$objPHPExcel->getActiveSheet()->setCellValue('AJ9', "I");
		$objPHPExcel->getActiveSheet()->setCellValue('AK9', "A");
		$objPHPExcel->getActiveSheet()->mergeCells('AL8:AL9');
		$objPHPExcel->getActiveSheet()->setCellValue('AL8', "TOTAL");
		
		
		//$objPHPExcel->getActiveSheet()->getColumnDimension('A3')->setAutoSize(true);
		
		$objPHPExcel->getActiveSheet()->getStyle('A8:A9')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('B8:B9')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('C8:C9')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('D8:AH8')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('AI8:AK8')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('AI9')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('AJ9')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('AK9')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('AL8:AL9')->applyFromArray($style_col);
		
		cellColor('A8:AL9', 'cccccc');
		
		$Q2=mysql_query("
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
		from gmp_ngajar
		inner join ak_perkelas on gmp_ngajar.thnajaran=ak_perkelas.tahunajaran 
		inner join ak_kelas on gmp_ngajar.kd_kelas=ak_kelas.kode_kelas and ak_kelas.nama_kelas=ak_perkelas.nm_kelas
		inner join app_user_guru on gmp_ngajar.kd_guru=app_user_guru.id_guru
		inner join ak_matapelajaran on gmp_ngajar.kd_mapel=ak_matapelajaran.kode_mapel
		inner join siswa_biodata on ak_perkelas.nis=siswa_biodata.nis
		where gmp_ngajar.id_ngajar='$kbm' order by siswa_biodata.nm_siswa,siswa_biodata.nis");
		
		$baris=10;  
		$no=1;
		while($Hasil=mysql_fetch_array($Q2)){ 
		
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$baris, $no);
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$baris, $Hasil['nis']);
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$baris, $Hasil['nm_siswa']);
		
			$kolom = 'D';
			//Mencetak header berdasarkan field tabel
			for($x=1;$x<=31;$x++){
				$objPHPExcel->getActiveSheet()->getStyle($kolom.$baris)->applyFromArray($style_row);
				$objPHPExcel->getActiveSheet()->getStyle($kolom.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$kolom++;
			}
		
			$objPHPExcel->getActiveSheet()->getStyle('A'.$baris)->applyFromArray($style_row);
			$objPHPExcel->getActiveSheet()->getStyle('B'.$baris)->applyFromArray($style_row);
			$objPHPExcel->getActiveSheet()->getStyle('C'.$baris)->applyFromArray($style_row);
			$objPHPExcel->getActiveSheet()->getStyle('AI'.$baris)->applyFromArray($style_row);
			$objPHPExcel->getActiveSheet()->getStyle('AJ'.$baris)->applyFromArray($style_row);
			$objPHPExcel->getActiveSheet()->getStyle('AK'.$baris)->applyFromArray($style_row);
			$objPHPExcel->getActiveSheet()->getStyle('AL'.$baris)->applyFromArray($style_row);
		
			$objPHPExcel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('B'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			
			$baris++;
			$no++;
		}
		
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5.00);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15.00);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40.00);
		$objPHPExcel->getActiveSheet()->getColumnDimension('AI')->setWidth(3.50);
		$objPHPExcel->getActiveSheet()->getColumnDimension('AJ')->setWidth(3.50);
		$objPHPExcel->getActiveSheet()->getColumnDimension('AK')->setWidth(3.50);
		$objPHPExcel->getActiveSheet()->getColumnDimension('AL')->setWidth(7.50);
		
		$BarisKe=$jmlSiswa+10;
		$BarisKe1=$BarisKe+1;
		
		$objPHPExcel->getActiveSheet()->mergeCells('B'.$BarisKe.':C'.$BarisKe);
		$objPHPExcel->getActiveSheet()->setCellValue('B'.$BarisKe, "Mengetahui :");
		$objPHPExcel->getActiveSheet()->mergeCells('B'.$BarisKe1.':C'.$BarisKe1);
		$objPHPExcel->getActiveSheet()->setCellValue('B'.$BarisKe1, "Kepala Sekolah,");
		
		$Titimangsa=$HProfil['kecamatan'];
		
		//$Tgl=TglLengkap($tglSekarang=date('Y-m-d'));
		
		$objPHPExcel->getActiveSheet()->mergeCells('AA'.$BarisKe.':AL'.$BarisKe);
		$objPHPExcel->getActiveSheet()->setCellValue('AA'.$BarisKe, $Titimangsa.", .....................");
		$objPHPExcel->getActiveSheet()->mergeCells('AA'.$BarisKe1.':AL'.$BarisKe1);
		$objPHPExcel->getActiveSheet()->setCellValue('AA'.$BarisKe1, "Guru Mata Pelajaran,");
		
		$BarisKe2=$BarisKe1+5;
		$BarisKe3=$BarisKe2+1;
		
		$objPHPExcel->getActiveSheet()->mergeCells('B'.$BarisKe2.':C'.$BarisKe2);
		$objPHPExcel->getActiveSheet()->setCellValue('B'.$BarisKe2, $NamaKepsek);
		$objPHPExcel->getActiveSheet()->mergeCells('B'.$BarisKe3.':C'.$BarisKe3);
		$objPHPExcel->getActiveSheet()->setCellValue('B'.$BarisKe3, $NIPKepsek);
		
		$objPHPExcel->getActiveSheet()->mergeCells('AA'.$BarisKe2.':AL'.$BarisKe2);
		$objPHPExcel->getActiveSheet()->setCellValue('AA'.$BarisKe2, $NamaGuru);
		$objPHPExcel->getActiveSheet()->mergeCells('AA'.$BarisKe3.':AL'.$BarisKe3);
		$objPHPExcel->getActiveSheet()->setCellValue('AA'.$BarisKe3, $NIPGuru);
		
		$objPHPExcel->getActiveSheet()->getStyle('B'.$BarisKe2)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('AA'.$BarisKe2)->getFont()->setBold(true);
		
		
		$objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(8, 9);
		
		$objPHPExcel->setActiveSheetIndex(0);  
		
		$NamaFile="ABSENSI ".$H['thnajaran']." ".$H['semester']." ".$Kelasna." ".$MaPelna;
		// Mencetak File Excel 
		header('Content-Type: application/vnd.ms-excel'); 
		header('Content-Disposition: attachment;filename="'.$NamaFile.'.xls"'); 
		header('Cache-Control: max-age=0'); 
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
		$objWriter->save('php://output');
	break;

	case "absensi-mapel":
		$kbm=isset($_GET['kbm'])?$_GET['kbm']:""; 
		$komp=isset($_GET['komp'])?$_GET['komp']:""; 
		$mapel=isset($_GET['mapel'])?$_GET['mapel']:""; 
		$kls=isset($_GET['kls'])?$_GET['kls']:""; 
		
		$Q=mysql_query("select 
			siswa_biodata.nm_siswa, 
			app_user_guru.nama_lengkap,
			ak_matapelajaran.nama_mapel,
			gmp_absensi.*
			from gmp_absensi
			inner join siswa_biodata on gmp_absensi.nis=siswa_biodata.nis 
			inner join gmp_ngajar on gmp_absensi.kd_ngajar=gmp_ngajar.id_ngajar
			inner join app_user_guru on gmp_ngajar.kd_guru=app_user_guru.id_guru
			inner join ak_matapelajaran on gmp_ngajar.kd_mapel=ak_matapelajaran.kode_mapel
			where gmp_absensi.kd_ngajar='$kbm' order by siswa_biodata.nm_siswa,siswa_biodata.nis");
		
		require_once 'Classes/PHPExcel.php';
		$objPHPExcel = new PHPExcel();
		
		$objPHPExcel->getProperties()->setCreator("Abdul Madjid, SPd., M.Pd.")
									 ->setLastModifiedBy("Abdul Madjid, SPd., M.Pd.")
									 ->setTitle("ABSENSI MATA PELAJARAN")
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
		$objPHPExcel->getActiveSheet()->setCellValue('A1', "No.");
		$objPHPExcel->getActiveSheet()->setCellValue('B1', "Kode KBM");
		$objPHPExcel->getActiveSheet()->setCellValue('C1', "NIS");
		$objPHPExcel->getActiveSheet()->setCellValue('D1', "Nama Siswa"); 
		$objPHPExcel->getActiveSheet()->setCellValue('E1', "Absensi"); 
		$objPHPExcel->getActiveSheet()->setCellValue('F1', "Tanggal"); 
		$objPHPExcel->getActiveSheet()->setCellValue('G1', "Tanggal Lengkap"); 
		$objPHPExcel->getActiveSheet()->setCellValue('H1', "Keterangan"); 
		
		$objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('F1')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('G1')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('H1')->applyFromArray($style_col);
		
		cellColor('A1:H1', 'cccccc');
		
		$baris=2;
		$No=1;
		
		
		while($H=mysql_fetch_array($Q)){
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$baris, $No);
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$baris, $H['kd_ngajar']);
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$baris, $H['nis']);
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$baris, $H['nm_siswa']);
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$baris, $H['absensi']);
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$baris, $H['tgl']);
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$baris, TglLengkap($H['tgl']));
			$objPHPExcel->getActiveSheet()->setCellValue('H'.$baris, $H['keterangan']);
		
			$objPHPExcel->getActiveSheet()->getStyle('A'.$baris)->applyFromArray($style_row);
			$objPHPExcel->getActiveSheet()->getStyle('B'.$baris)->applyFromArray($style_row);
			$objPHPExcel->getActiveSheet()->getStyle('C'.$baris)->applyFromArray($style_row);
			$objPHPExcel->getActiveSheet()->getStyle('D'.$baris)->applyFromArray($style_row);
			$objPHPExcel->getActiveSheet()->getStyle('E'.$baris)->applyFromArray($style_row);
			$objPHPExcel->getActiveSheet()->getStyle('F'.$baris)->applyFromArray($style_row);
			$objPHPExcel->getActiveSheet()->getStyle('G'.$baris)->applyFromArray($style_row);
			$objPHPExcel->getActiveSheet()->getStyle('H'.$baris)->applyFromArray($style_row);
		
			$objPHPExcel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('B'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('C'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
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
		
		$NamaFile=$kbm." - ".$kls." - ".$mapel." - ".$komp;
		// Mencetak File Excel 
		header('Content-Type: application/vnd.ms-excel'); 
		header('Content-Disposition: attachment;filename="'.$NamaFile.'.xls"'); 
		header('Cache-Control: max-age=0'); 
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
		$objWriter->save('php://output');		
	break;

	case "siswa-biodata-walikelas":
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
	break;
}

?>