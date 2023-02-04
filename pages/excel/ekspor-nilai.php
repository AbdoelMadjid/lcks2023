<?php 
/* 12/6/2016
Design and Programming By. Abdul Madjid, S.Pd., M.Pd.
SMK Negeri 1 Kadipaten
Pin 520543F3 HP. 0812-3000-0420
https://twitter.com/AbdoelMadjid 
https://www.facebook.com/abdulmadjid.mpd

DAFTAR EXEPORT EXCEL
- reviewnilai (kurikulum-dokguru-arsip-nilai)
- leger-nilai-kurikulum (kurikulum-datakbm-perkelas)
- rangking-kelas (kurikulum-datakbm-perkelas)
- absensi-kelas (kurikulum-datakbm-perkelas)
- laporan-nilai (gurumapel-data-kbm)
- nilai-mapel (gurumapel-nilai-kkikd, gurumapel-nilai-pkikd)
- nilai-utsas (gurumapel-nilai-utsuas)
- nilai-sikap (gurumapel-nilai-sikap)
*/
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING | E_DEPRECATED));
require_once 'koneksi.php';

$eksporex=(isset($_GET['eksporex']))?$_GET['eksporex']:"";
switch($eksporex)
{
	case "review":
		$kbm=isset($_GET['kbm'])?$_GET['kbm']:""; 
		$mapel=isset($_GET['mapel'])?$_GET['mapel']:""; 
		$kls=isset($_GET['kls'])?$_GET['kls']:""; 
		$thnajar=isset($_GET['thnajar'])?$_GET['thnajar']:""; 
		$semester=isset($_GET['semester'])?$_GET['semester']:""; 
		$nomorna=isset($_GET['nomorna'])?$_GET['nomorna']:""; 

		header("Content-type: application/vnd-ms-excel");
		header("Content-Disposition: attachment; filename=".$nomorna." ".$thnajar."-".$semester."-".$kbm."-".$kls."-".$mapel.".xls");

		echo "
		<table>
				<tr>
					<td colspan='2'>Mata Pelajaran</td>
					<td colspan='12'>$mapel</td>
				</tr>
				<tr>
					<td colspan='2'>Kelas</td>
					<td colspan='12'>$kls</td>
				</tr>
				<tr>
					<td colspan='2'>Tahun Ajaran / Semester</td>
					<td colspan='12'>$thnajar / $semester</td>
				</tr>
				<tr>
					<td colspan='2'></td>
					<td colspan='12'></td>
				</tr>
		</table>
		<table border='1'>
			<thead>
				<tr>
					<th rowspan='2'>No.</th>
					<th rowspan='2'>Nama Siswa</th>
					<th rowspan='2'>NIS</th>
					<th colspan='2'>Sikap</th>
					<th colspan='5'>Pengetahuan</th>
					<th colspan='2'>Keterampilan</th>
					<th rowspan='2' width='100'>Rata2 Nilai</th>
					<th rowspan='2' width='100'>Predikat Kelas</th>
				</tr>
				<tr>
					<th width='50'>SP</th>
					<th width='50'>SO</th>
					<th width='50'>NHP</th>
					<th width='50'>UTS</th>
					<th width='50'>UAS</th>
					<th width='50'>NA</th>
					<th width='50'>P</th>
					<th width='50'>NA</th>
					<th width='50'>P</th>
				</tr>
			</thead>
			<tbody>";

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
		gmp_ngajar.id_ngajar='$kbm' order by siswa_biodata.nis");

		$jmlSiswa=mysql_num_rows($Q);

		$no=1;

		while($Hasil=mysql_fetch_array($Q)){
			$Matapel=$Hasil['nama_mapel'];
			$Kls=$Hasil['nama_kelas'];
			$GuruNgajar=$Hasil['nama_lengkap'];
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
			
			echo "
			<tr>
				<td>$no</td>
				<td>{$Hasil['nm_siswa']}</td>
				<td>{$Hasil['nis']}</td>
				<td align='center'>$NSpritual</td>
				<td align='center'>$NSosial</td>
				<td align='center'>{$NKDP['kikd_p']}</td>
				<td align='center'>{$NKUTSUAS['uts']}</td>
				<td align='center'>{$NKUTSUAS['uas']}</td>
				<td bgcolor='#fffff4' align='center'>$NAP</td>
				<td align='center'>$PredP</td>
				<td bgcolor='#fffff4' align='center'>{$NKDK['kikd_k']}</td>
				<td align='center'>$PredK</td>
				<td align='center'>$R2</td>
				<td align='center'>$PredSw</td>
			</tr>";
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
			$Deskripsi=deskripsi($RNR);
		echo "
			<tr>
				<th colspan='3'>Rata-rata Kelas</th>
				<th>$RNilSpr</th>
				<th>$RNilSos</th>
				<th>$RNilKDP</th>
				<th>$RUTS</th>
				<th>$RUAS</th>
				<th>$RNAD</th>
				<th>$PredikatP</th>
				<th>$RNilKDK</th>
				<th>$PredikatK</th>
				<th>$RNR</th>
				<th>$Deskripsi</th>
			</tr>
			</tbody>
		</table>";
	break;

	case "leger-nilai-kurikulum":
		$judulna = "LEGER NILAI ";
		
		$kelas=(isset($_GET['kls']))?$_GET['kls']:"";
		$thnajaran=(isset($_GET['thnajaran']))?$_GET['thnajaran']:"";
		$gg=(isset($_GET['gg']))?$_GET['gg']:"";
		$tingkat=(isset($_GET['tk']))?$_GET['tk']:"";

		$QProfil=mysql_query("select * from app_lembaga");
		$HProfil=mysql_fetch_array($QProfil);

		$QKS=mysql_query("select * from ak_kepsek where thnajaran='$thnajaran' and smstr='$gg'");
		$HKS=mysql_fetch_array($QKS);
		$NamaKepsek=$HKS['nama'];
		$NIPKepsek="NIP. ".$HKS['nip'];

		$QWK=mysql_query("select 
		ak_kelas.id_guru,
		app_user_guru.nip,
		app_user_guru.nama_lengkap 
		from 
		ak_kelas,
		app_user_guru 
		where ak_kelas.id_guru=app_user_guru.id_guru and 
		ak_kelas.kode_kelas='$kelas' and 
		ak_kelas.tahunajaran='$thnajaran'");
		$HWK=mysql_fetch_array($QWK);


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

		$objPHPExcel->getProperties()->setCreator("Abdul Madjid, SPd., M.Pd.")
									 ->setLastModifiedBy("Abdul Madjid, SPd., M.Pd.")
									 ->setTitle($judulna)
									 ->setCompany("SMKN 1 Kadipaten - Majalengka")
									 ->setCategory("LCKS 2017 - Excel");

		// ====================================================================== SHEET K3 PENGETAHUAN

			$objPHPExcel->getSheet(0)->setTitle('K3 - Pengetahuan');
			// Setting Worsheet yang aktif 
			$objPHPExcel->setActiveSheetIndex(0);  

			// Set page orientation and size
			$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
			$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LEGAL);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0.50);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(1.20);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0.55);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(0.50);
			$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&LHal: &P/&N - '.$objPHPExcel->getProperties()->getTitle().' '.$kelas.' '.$thnajaran.' '.$gg);

			$objPHPExcel->getActiveSheet()->mergeCells('A1:C1');
			$objPHPExcel->getActiveSheet()->setCellValue('A1', "LEGER PENGETAHUAN");
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

			$QLgr=mysql_query("select 
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

				$QNSP=mysql_query("select * from leger_nilai_k3 where id_kls='$kelas' and thnajaran='$thnajaran' and ganjilgenap='$gg' and nis='".$HLN['nis']."'");
				$HNSP=mysql_fetch_array($QNSP);

				$NilaiP=array(
				$HNSP['nilai1'],
				$HNSP['nilai2'],
				$HNSP['nilai3'],
				$HNSP['nilai4'],
				$HNSP['nilai5'],
				$HNSP['nilai6'],
				$HNSP['nilai7'],
				$HNSP['nilai8'],
				$HNSP['nilai9'],
				$HNSP['nilai10'],
				$HNSP['nilai11'],
				$HNSP['nilai12'],
				$HNSP['nilai13'],
				$HNSP['nilai14'],
				$HNSP['nilai15'],
				$HNSP['nilai16'],
				$HNSP['nilai17'],
				$HNSP['nilai18'],
				$HNSP['nilai19'],
				$HNSP['nilai20'],
				$HNSP['nilai21']);

				$kolomEusi='D';

				for ($i=0; $i<$JmlMP; $i++)
				{	

					$objPHPExcel->getActiveSheet()->setCellValue($kolomEusi.$baris, $NilaiP[$i]);

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

			$NIPGuru="NIP. ".$GuruNgajarNIP;

			$objPHPExcel->getActiveSheet()->mergeCells('B'.$BarisKe2.':C'.$BarisKe2);
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$BarisKe2, $NamaKepsek);
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

		// ====================================================================== SHEET K4 KETERAMPILAN

			$myWorkSheet = new PHPExcel_Worksheet($objPHPExcel, 'K4 - Keterampilan');
			$objPHPExcel->addSheet($myWorkSheet, 1);

			// mengeset sheet 2 yang aktif
			$objPHPExcel->setActiveSheetIndex(1);

			// Set page orientation and size
			$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
			$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LEGAL);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0.50);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(1.20);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0.55);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(0.50);
			$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&LHal: &P/&N - '.$objPHPExcel->getProperties()->getTitle().' '.$kelas.' '.$thnajaran.' '.$gg);

			$objPHPExcel->getActiveSheet()->mergeCells('A1:C1');
			$objPHPExcel->getActiveSheet()->setCellValue('A1', "LEGER KETERAMPILAN");
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

			$QLgr=mysql_query("select 
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

				$QNSK=mysql_query("select * from leger_nilai_k4 where id_kls='$kelas' and thnajaran='$thnajaran' and ganjilgenap='$gg' and nis='".$HLN['nis']."'");
				$HNSK=mysql_fetch_array($QNSK);

				$NilaiK=array(
				$HNSK['nilai1'],
				$HNSK['nilai2'],
				$HNSK['nilai3'],
				$HNSK['nilai4'],
				$HNSK['nilai5'],
				$HNSK['nilai6'],
				$HNSK['nilai7'],
				$HNSK['nilai8'],
				$HNSK['nilai9'],
				$HNSK['nilai10'],
				$HNSK['nilai11'],
				$HNSK['nilai12'],
				$HNSK['nilai13'],
				$HNSK['nilai14'],
				$HNSK['nilai15'],
				$HNSK['nilai16'],
				$HNSK['nilai17'],
				$HNSK['nilai18'],
				$HNSK['nilai19'],
				$HNSK['nilai20'],
				$HNSK['nilai21']);


				$kolomEusi='D';

				for ($i=0; $i<$JmlMP; $i++)
				{	

					$objPHPExcel->getActiveSheet()->setCellValue($kolomEusi.$baris, $NilaiK[$i]);

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

			$NIPGuru="NIP. ".$GuruNgajarNIP;

			$objPHPExcel->getActiveSheet()->mergeCells('B'.$BarisKe2.':C'.$BarisKe2);
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$BarisKe2, $NamaKepsek);
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

			$objPHPExcel->setActiveSheetIndex(1);

		// ====================================================================== SHEET NILAI AKHIR

			$myWorkSheet = new PHPExcel_Worksheet($objPHPExcel, 'Nilai Akhir');
			$objPHPExcel->addSheet($myWorkSheet, 2);

			// mengeset sheet 2 yang aktif
			$objPHPExcel->setActiveSheetIndex(2);

			// Set page orientation and size
			$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
			$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LEGAL);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0.50);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(1.20);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0.55);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(0.50);
			$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&LHal: &P/&N - '.$objPHPExcel->getProperties()->getTitle().' '.$kelas.' '.$thnajaran.' '.$gg);

			$objPHPExcel->getActiveSheet()->mergeCells('A1:C1');
			$objPHPExcel->getActiveSheet()->setCellValue('A1', "LEGER NILAI AKHIR");
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

			$QLgr=mysql_query("select 
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

				$QNSP1=mysql_query("select * from leger_nilai_k3 where id_kls='$kelas' and thnajaran='$thnajaran' and ganjilgenap='$gg' and nis='".$HLN['nis']."'");
				$HNSP1=mysql_fetch_array($QNSP1);

				$NilaiP1=array(
				$HNSP1['nilai1'],
				$HNSP1['nilai2'],
				$HNSP1['nilai3'],
				$HNSP1['nilai4'],
				$HNSP1['nilai5'],
				$HNSP1['nilai6'],
				$HNSP1['nilai7'],
				$HNSP1['nilai8'],
				$HNSP1['nilai9'],
				$HNSP1['nilai10'],
				$HNSP1['nilai11'],
				$HNSP1['nilai12'],
				$HNSP1['nilai13'],
				$HNSP1['nilai14'],
				$HNSP1['nilai15'],
				$HNSP1['nilai16'],
				$HNSP1['nilai17'],
				$HNSP1['nilai18'],
				$HNSP1['nilai19'],
				$HNSP1['nilai20'],
				$HNSP1['nilai21']);

				$QNSK1=mysql_query("select * from leger_nilai_k4 where id_kls='$kelas' and thnajaran='$thnajaran' and ganjilgenap='$gg' and nis='".$HLN['nis']."'");
				$HNSK1=mysql_fetch_array($QNSK1);

				$NilaiK1=array(
				$HNSK1['nilai1'],
				$HNSK1['nilai2'],
				$HNSK1['nilai3'],
				$HNSK1['nilai4'],
				$HNSK1['nilai5'],
				$HNSK1['nilai6'],
				$HNSK1['nilai7'],
				$HNSK1['nilai8'],
				$HNSK1['nilai9'],
				$HNSK1['nilai10'],
				$HNSK1['nilai11'],
				$HNSK1['nilai12'],
				$HNSK1['nilai13'],
				$HNSK1['nilai14'],
				$HNSK1['nilai15'],
				$HNSK1['nilai16'],
				$HNSK1['nilai17'],
				$HNSK1['nilai18'],
				$HNSK1['nilai19'],
				$HNSK1['nilai20'],
				$HNSK1['nilai21']);
				
				$kolomEusi='D';

				for ($i=0; $i<$JmlMP; $i++)
				{	

					$NAna=round(($NilaiP1[$i]+$NilaiK1[$i])/2,0);

					$objPHPExcel->getActiveSheet()->setCellValue($kolomEusi.$baris, $NAna);

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

			$NIPGuru="NIP. ".$GuruNgajarNIP;

			$objPHPExcel->getActiveSheet()->mergeCells('B'.$BarisKe2.':C'.$BarisKe2);
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$BarisKe2, $NamaKepsek);
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

			$objPHPExcel->setActiveSheetIndex(2);

		// ====================================================================== SHEET KBM

			$myWorkSheet = new PHPExcel_Worksheet($objPHPExcel, 'KBM');
			$objPHPExcel->addSheet($myWorkSheet, 3);

			// mengeset sheet 2 yang aktif
			$objPHPExcel->setActiveSheetIndex(3);

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

			$WaliKelas=$HWK['nama_lengkap'];

			$objPHPExcel->getActiveSheet()->setCellValue('C3', ": ".$thnajaran);
			$objPHPExcel->getActiveSheet()->setCellValue('C4', ": ".$gg);
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
				$ganjilgenap=$HNgajar['ganjilgenap'];
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

			$objPHPExcel->setActiveSheetIndex(3);


		$NamaFile=$judulna." ".$thnajaran."-".$gg."-".$kelas;
		// Mencetak File Excel 
		header('Content-Type: application/vnd.ms-excel'); 
		header('Content-Disposition: attachment;filename="'.$NamaFile.'.xls"'); 
		header('Cache-Control: max-age=0'); 
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
		$objWriter->save('php://output');
	break;

	case "leger-nilai-kurikulum-km":
		$judulna = "LEGER NILAI ";
		
		$kelas=(isset($_GET['kls']))?$_GET['kls']:"";
		$thnajaran=(isset($_GET['thnajaran']))?$_GET['thnajaran']:"";
		$gg=(isset($_GET['gg']))?$_GET['gg']:"";
		$tingkat=(isset($_GET['tk']))?$_GET['tk']:"";

		$QProfil=mysql_query("select * from app_lembaga");
		$HProfil=mysql_fetch_array($QProfil);

		$QKS=mysql_query("select * from ak_kepsek where thnajaran='$thnajaran' and smstr='$gg'");
		$HKS=mysql_fetch_array($QKS);
		$NamaKepsek=$HKS['nama'];
		$NIPKepsek="NIP. ".$HKS['nip'];

		$QWK=mysql_query("select 
		ak_kelas.id_guru,
		app_user_guru.nip,
		app_user_guru.nama_lengkap 
		from 
		ak_kelas,
		app_user_guru 
		where ak_kelas.id_guru=app_user_guru.id_guru and 
		ak_kelas.kode_kelas='$kelas' and 
		ak_kelas.tahunajaran='$thnajaran'");
		$HWK=mysql_fetch_array($QWK);


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

		$objPHPExcel->getProperties()->setCreator("Abdul Madjid, SPd., M.Pd.")
									 ->setLastModifiedBy("Abdul Madjid, SPd., M.Pd.")
									 ->setTitle($judulna)
									 ->setCompany("SMKN 1 Kadipaten - Majalengka")
									 ->setCategory("LCKS 2017 - Excel");

		// ====================================================================== SHEET K3 PENGETAHUAN

			$objPHPExcel->getSheet(0)->setTitle('TP - Target Pembelajaran');
			// Setting Worsheet yang aktif 
			$objPHPExcel->setActiveSheetIndex(0);  

			// Set page orientation and size
			$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
			$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LEGAL);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0.50);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(1.20);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0.55);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(0.50);
			$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&LHal: &P/&N - '.$objPHPExcel->getProperties()->getTitle().' '.$kelas.' '.$thnajaran.' '.$gg);

			$objPHPExcel->getActiveSheet()->mergeCells('A1:C1');
			$objPHPExcel->getActiveSheet()->setCellValue('A1', "LEGER TARGET PEMBELAJARAN");
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

			$QLgr=mysql_query("select 
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

				$QNSP=mysql_query("select * from leger_nilai_k3 where id_kls='$kelas' and thnajaran='$thnajaran' and ganjilgenap='$gg' and nis='".$HLN['nis']."'");
				$HNSP=mysql_fetch_array($QNSP);

				$NilaiP=array(
				$HNSP['nilai1'],
				$HNSP['nilai2'],
				$HNSP['nilai3'],
				$HNSP['nilai4'],
				$HNSP['nilai5'],
				$HNSP['nilai6'],
				$HNSP['nilai7'],
				$HNSP['nilai8'],
				$HNSP['nilai9'],
				$HNSP['nilai10'],
				$HNSP['nilai11'],
				$HNSP['nilai12'],
				$HNSP['nilai13'],
				$HNSP['nilai14'],
				$HNSP['nilai15'],
				$HNSP['nilai16'],
				$HNSP['nilai17'],
				$HNSP['nilai18'],
				$HNSP['nilai19'],
				$HNSP['nilai20'],
				$HNSP['nilai21']);

				$kolomEusi='D';

				for ($i=0; $i<$JmlMP; $i++)
				{	

					$objPHPExcel->getActiveSheet()->setCellValue($kolomEusi.$baris, $NilaiP[$i]);

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

			$NIPGuru="NIP. ".$GuruNgajarNIP;

			$objPHPExcel->getActiveSheet()->mergeCells('B'.$BarisKe2.':C'.$BarisKe2);
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$BarisKe2, $NamaKepsek);
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

		// ====================================================================== SHEET UTS UAS

			$myWorkSheet = new PHPExcel_Worksheet($objPHPExcel, 'UTS-UAS');
			$objPHPExcel->addSheet($myWorkSheet, 1);

			// mengeset sheet 2 yang aktif
			$objPHPExcel->setActiveSheetIndex(1);

			// Set page orientation and size
			$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
			$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LEGAL);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0.50);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(1.20);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0.55);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(0.50);
			$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&LHal: &P/&N - '.$objPHPExcel->getProperties()->getTitle().' '.$kelas.' '.$thnajaran.' '.$gg);

			$objPHPExcel->getActiveSheet()->mergeCells('A1:C1');
			$objPHPExcel->getActiveSheet()->setCellValue('A1', "LEGER UTS-UAS");
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

			$QLgr=mysql_query("select 
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

				$QNSK=mysql_query("select * from leger_nilai_uts,leger_nilai_uas where id_kls='$kelas' and thnajaran='$thnajaran' and ganjilgenap='$gg' and nis='".$HLN['nis']."'");
				$HNSK=mysql_fetch_array($QNSK);

				$NilaiK=array(
				$HNSK['nilai1'],
				$HNSK['nilai2'],
				$HNSK['nilai3'],
				$HNSK['nilai4'],
				$HNSK['nilai5'],
				$HNSK['nilai6'],
				$HNSK['nilai7'],
				$HNSK['nilai8'],
				$HNSK['nilai9'],
				$HNSK['nilai10'],
				$HNSK['nilai11'],
				$HNSK['nilai12'],
				$HNSK['nilai13'],
				$HNSK['nilai14'],
				$HNSK['nilai15'],
				$HNSK['nilai16'],
				$HNSK['nilai17'],
				$HNSK['nilai18'],
				$HNSK['nilai19'],
				$HNSK['nilai20'],
				$HNSK['nilai21']);


				$kolomEusi='D';

				for ($i=0; $i<$JmlMP; $i++)
				{	

					$objPHPExcel->getActiveSheet()->setCellValue($kolomEusi.$baris, $NilaiK[$i]);

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

			$NIPGuru="NIP. ".$GuruNgajarNIP;

			$objPHPExcel->getActiveSheet()->mergeCells('B'.$BarisKe2.':C'.$BarisKe2);
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$BarisKe2, $NamaKepsek);
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

			$objPHPExcel->setActiveSheetIndex(1);

		// ====================================================================== SHEET NILAI AKHIR

			$myWorkSheet = new PHPExcel_Worksheet($objPHPExcel, 'Nilai Akhir');
			$objPHPExcel->addSheet($myWorkSheet, 2);

			// mengeset sheet 2 yang aktif
			$objPHPExcel->setActiveSheetIndex(2);

			// Set page orientation and size
			$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
			$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LEGAL);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0.50);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(1.20);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0.55);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(0.50);
			$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&LHal: &P/&N - '.$objPHPExcel->getProperties()->getTitle().' '.$kelas.' '.$thnajaran.' '.$gg);

			$objPHPExcel->getActiveSheet()->mergeCells('A1:C1');
			$objPHPExcel->getActiveSheet()->setCellValue('A1', "LEGER NILAI AKHIR");
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

			$QLgr=mysql_query("select 
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

				$QNSP1=mysql_query("select * from leger_nilai_k3 where id_kls='$kelas' and thnajaran='$thnajaran' and ganjilgenap='$gg' and nis='".$HLN['nis']."'");
				$HNSP1=mysql_fetch_array($QNSP1);

				$NilaiP1=array(
				$HNSP1['nilai1'],
				$HNSP1['nilai2'],
				$HNSP1['nilai3'],
				$HNSP1['nilai4'],
				$HNSP1['nilai5'],
				$HNSP1['nilai6'],
				$HNSP1['nilai7'],
				$HNSP1['nilai8'],
				$HNSP1['nilai9'],
				$HNSP1['nilai10'],
				$HNSP1['nilai11'],
				$HNSP1['nilai12'],
				$HNSP1['nilai13'],
				$HNSP1['nilai14'],
				$HNSP1['nilai15'],
				$HNSP1['nilai16'],
				$HNSP1['nilai17'],
				$HNSP1['nilai18'],
				$HNSP1['nilai19'],
				$HNSP1['nilai20'],
				$HNSP1['nilai21']);

				$QNSK1=mysql_query("select * from leger_nilai_k4 where id_kls='$kelas' and thnajaran='$thnajaran' and ganjilgenap='$gg' and nis='".$HLN['nis']."'");
				$HNSK1=mysql_fetch_array($QNSK1);

				$NilaiK1=array(
				$HNSK1['nilai1'],
				$HNSK1['nilai2'],
				$HNSK1['nilai3'],
				$HNSK1['nilai4'],
				$HNSK1['nilai5'],
				$HNSK1['nilai6'],
				$HNSK1['nilai7'],
				$HNSK1['nilai8'],
				$HNSK1['nilai9'],
				$HNSK1['nilai10'],
				$HNSK1['nilai11'],
				$HNSK1['nilai12'],
				$HNSK1['nilai13'],
				$HNSK1['nilai14'],
				$HNSK1['nilai15'],
				$HNSK1['nilai16'],
				$HNSK1['nilai17'],
				$HNSK1['nilai18'],
				$HNSK1['nilai19'],
				$HNSK1['nilai20'],
				$HNSK1['nilai21']);
				
				$kolomEusi='D';

				for ($i=0; $i<$JmlMP; $i++)
				{	

					$NAna=round(($NilaiP1[$i]+$NilaiK1[$i])/2,0);

					$objPHPExcel->getActiveSheet()->setCellValue($kolomEusi.$baris, $NAna);

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

			$NIPGuru="NIP. ".$GuruNgajarNIP;

			$objPHPExcel->getActiveSheet()->mergeCells('B'.$BarisKe2.':C'.$BarisKe2);
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$BarisKe2, $NamaKepsek);
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

			$objPHPExcel->setActiveSheetIndex(2);

		// ====================================================================== SHEET KBM

			$myWorkSheet = new PHPExcel_Worksheet($objPHPExcel, 'KBM');
			$objPHPExcel->addSheet($myWorkSheet, 3);

			// mengeset sheet 2 yang aktif
			$objPHPExcel->setActiveSheetIndex(3);

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

			$WaliKelas=$HWK['nama_lengkap'];

			$objPHPExcel->getActiveSheet()->setCellValue('C3', ": ".$thnajaran);
			$objPHPExcel->getActiveSheet()->setCellValue('C4', ": ".$gg);
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
				$ganjilgenap=$HNgajar['ganjilgenap'];
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

			$objPHPExcel->setActiveSheetIndex(3);


		$NamaFile=$judulna." ".$thnajaran."-".$gg."-".$kelas;
		// Mencetak File Excel 
		header('Content-Type: application/vnd.ms-excel'); 
		header('Content-Disposition: attachment;filename="'.$NamaFile.'.xls"'); 
		header('Cache-Control: max-age=0'); 
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
		$objWriter->save('php://output');
	break;

	case "rangking-kelas":
		$kls=isset($_GET['kls'])?$_GET['kls']:""; 
		$thnajaran=isset($_GET['thnajaran'])?$_GET['thnajaran']:""; 
		$gg=isset($_GET['gg'])?$_GET['gg']:""; 
		$JmlMP=isset($_GET['jmlmp'])?$_GET['jmlmp']:""; 


		$QProfil=mysql_query("select * from app_lembaga");
		$HProfil=mysql_fetch_array($QProfil);

		require_once 'Classes/PHPExcel.php';
		$objPHPExcel = new PHPExcel();

		$objPHPExcel->getProperties()->setCreator("Abdul Madjid, SPd., M.Pd.")
									 ->setLastModifiedBy("Abdul Madjid, SPd., M.Pd.")
									 ->setTitle("RANGKING KELAS")
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

		$objPHPExcel->getSheet(0)->setTitle('Peringkat');
		// Setting Worsheet yang aktif 
		$objPHPExcel->setActiveSheetIndex(0);  

		$objPHPExcel->getActiveSheet()->mergeCells('A1:F1');
		$objPHPExcel->getActiveSheet()->setCellValue('A1', "PERINGKAT KELAS");
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

		$objPHPExcel->getActiveSheet()->mergeCells('C3:F3');
		$objPHPExcel->getActiveSheet()->setCellValue('C3', ": ".$thnajaran);
		$objPHPExcel->getActiveSheet()->mergeCells('C4:F4');
		$objPHPExcel->getActiveSheet()->setCellValue('C4', ": ".$gg);
		$objPHPExcel->getActiveSheet()->mergeCells('C5:F5');
		$objPHPExcel->getActiveSheet()->setCellValue('C5', ": ".$kls);


		//Mencetak header berdasarkan field tabel
		$objPHPExcel->getActiveSheet()->setCellValue('A7', "NO.");
		$objPHPExcel->getActiveSheet()->setCellValue('B7', "NIS");
		$objPHPExcel->getActiveSheet()->setCellValue('C7', "NAMA SISWA");
		$objPHPExcel->getActiveSheet()->setCellValue('D7', "NK3"); 
		$objPHPExcel->getActiveSheet()->setCellValue('E7', "NK4"); 
		$objPHPExcel->getActiveSheet()->setCellValue('F7', "NA"); 

		$objPHPExcel->getActiveSheet()->getStyle('A7')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('B7')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('C7')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('D7')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('E7')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('F7')->applyFromArray($style_col);

		cellColor('A7:F7', 'cccccc');

		$baris=8;
		$QRangking=mysql_query("select * from n_rank where id_kls='$kls' and thnajaran='$thnajaran' and semester='$gg' order by na desc");
		$JmlData=mysql_num_rows($QRangking);

		$QjmlDataKosong=mysql_query("select * from n_rank where na<'50,00' and id_kls='$kls' and thnajaran='$thnajaran' and semester='$gg'");
		$JmlDataKosong=mysql_num_rows($QjmlDataKosong);

		$TotalJml=($JmlData-$JmlDataKosong);

		$no=1;
		while($Hasil=mysql_fetch_array($QRangking)){
			$QSis=mysql_query("select nis,nm_siswa from siswa_biodata where nis='{$Hasil['nis']}'");
			$HSis=mysql_fetch_array($QSis);
			$RNAP=$RNAP+$Hasil['nap'];
			$RNAK=$RNAK+$Hasil['nak'];
			$RNA=$RNA+$Hasil['na'];

			$NK3=round($Hasil['nap'],2);
			$NK4=round($Hasil['nak'],2);
			$NA=round($Hasil['na'],2);

			$objPHPExcel->getActiveSheet()->setCellValue('A'.$baris, $no);
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$baris, $Hasil['nis']);
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$baris, $HSis['nm_siswa']);
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$baris, $NK3);
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$baris, $NK4);
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$baris, $NA);

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

		$RNilKlsP=round(($RNAP/$TotalJml),2);
		$RNilKlsK=round(($RNAK/$TotalJml),2);
		$RNilKlsNA=round(($RNA/$TotalJml),2);

		$QWK=mysql_query("select 
		ak_kelas.id_guru,
		app_user_guru.nip,
		app_user_guru.nama_lengkap 
		from 
		ak_kelas,
		app_user_guru 
		where 
		ak_kelas.id_guru=app_user_guru.id_guru and 
		ak_kelas.kode_kelas='$kls' and 
		ak_kelas.tahunajaran='$thnajaran'");
		$HWK=mysql_fetch_array($QWK);

		$BariR2=$JmlData+8;

		$objPHPExcel->getActiveSheet()->mergeCells('A'.$BariR2.':C'.$BariR2);
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$BariR2, "Rata-Rata Kelas ($JmlData - $JmlDataKosong = $TotalJml) ");
		$objPHPExcel->getActiveSheet()->setCellValue('D'.$BariR2, $RNilKlsP);
		$objPHPExcel->getActiveSheet()->setCellValue('E'.$BariR2, $RNilKlsK);
		$objPHPExcel->getActiveSheet()->setCellValue('F'.$BariR2, $RNilKlsNA);

		$objPHPExcel->getActiveSheet()->getStyle('A'.$BariR2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('D'.$BariR2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('E'.$BariR2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('F'.$BariR2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$objPHPExcel->getActiveSheet()->getStyle('A'.$BariR2)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('B'.$BariR2)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('C'.$BariR2)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('D'.$BariR2)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('E'.$BariR2)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('F'.$BariR2)->applyFromArray($style_row);

		cellColor('A'.$BariR2.':F'.$BariR2, 'cccccc');

		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5.00);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(13.00);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(13.00);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(13.00);

		$BarisKe=$JmlData+10;
		$BarisKe1=$BarisKe+1;

		$Titimangsa=$HProfil['kecamatan'];

		$Tgl=TglLengkap(date('Y-m-d'));

		$objPHPExcel->getActiveSheet()->mergeCells('D'.$BarisKe.':F'.$BarisKe);
		$objPHPExcel->getActiveSheet()->setCellValue('D'.$BarisKe, $Titimangsa.", ".$Tgl);
		$objPHPExcel->getActiveSheet()->mergeCells('D'.$BarisKe1.':F'.$BarisKe1);
		$objPHPExcel->getActiveSheet()->setCellValue('D'.$BarisKe1, "Wali Kelas,");

		$BarisKe2=$BarisKe1+4;
		$BarisKe3=$BarisKe2+1;

		$NIPWK="NIP. ".$HWK['nip'];

		$objPHPExcel->getActiveSheet()->mergeCells('D'.$BarisKe2.':F'.$BarisKe2);
		$objPHPExcel->getActiveSheet()->setCellValue('D'.$BarisKe2, $HWK['nama_lengkap']);
		$objPHPExcel->getActiveSheet()->mergeCells('D'.$BarisKe3.':F'.$BarisKe3);
		$objPHPExcel->getActiveSheet()->setCellValue('D'.$BarisKe3, $NIPWK);

		$objPHPExcel->getActiveSheet()->getStyle('D'.$BarisKe2)->getFont()->setBold(true);

		$NamaFile="PERINGKAT ".$kls."-".$thnajaran."-".$gg;
		// Mencetak File Excel 
		header('Content-Type: application/vnd.ms-excel'); 
		header('Content-Disposition: attachment;filename="'.$NamaFile.'.xls"'); 
		header('Cache-Control: max-age=0'); 
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
		$objWriter->save('php://output');
	break;

	case "absensi-kelas":
		$kls=isset($_GET['kls'])?$_GET['kls']:""; 
		$thnajaran=isset($_GET['thnajaran'])?$_GET['thnajaran']:""; 
		$gg=isset($_GET['gg'])?$_GET['gg']:""; 

		$QProfil=mysql_query("select * from app_lembaga");
		$HProfil=mysql_fetch_array($QProfil);

		$QKelas=mysql_query("select * from ak_kelas where kode_kelas='$kls'");
		$HKelas=mysql_fetch_array($QKelas);

		$NamaKelas=$HKelas['nama_kelas']." [".$HKelas['kode_kelas']."]";

		require_once 'Classes/PHPExcel.php';
		$objPHPExcel = new PHPExcel();

		$objPHPExcel->getProperties()->setCreator("Abdul Madjid, SPd., M.Pd.")
									 ->setLastModifiedBy("Abdul Madjid, SPd., M.Pd.")
									 ->setTitle("Absensi Kelas ".$NamaKelas." - ".$thnajaran." - ".$gg)
									 ->setCompany("SMKN 1 Kadipaten - Majalengka")
									 ->setCategory("LCKS 2017 - Excel");

		// Set page orientation and size
		//$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LEGAL);
		$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0.50);
		$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0.50);
		$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(1.00);
		$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(1.50);
		//$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&LHal: &P/&N - '.$objPHPExcel->getProperties()->getTitle());

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
		$objPHPExcel->getActiveSheet()->setCellValue('A1', "ABSENSI KELAS");
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

		$objPHPExcel->getActiveSheet()->mergeCells('C3:G3');
		$objPHPExcel->getActiveSheet()->setCellValue('C3', ": ".$thnajaran);
		$objPHPExcel->getActiveSheet()->mergeCells('C4:G4');
		$objPHPExcel->getActiveSheet()->setCellValue('C4', ": ".$gg);
		$objPHPExcel->getActiveSheet()->mergeCells('C5:G5');
		$objPHPExcel->getActiveSheet()->setCellValue('C5', ": ".$NamaKelas);

		//Mencetak header berdasarkan field tabel
		$objPHPExcel->getActiveSheet()->setCellValue('A7', "NO.");
		$objPHPExcel->getActiveSheet()->setCellValue('B7', "NIS");
		$objPHPExcel->getActiveSheet()->setCellValue('C7', "NAMA SISWA");
		$objPHPExcel->getActiveSheet()->setCellValue('D7', "SAKIT"); 
		$objPHPExcel->getActiveSheet()->setCellValue('E7', "IZIN"); 
		$objPHPExcel->getActiveSheet()->setCellValue('F7', "ALFA"); 
		$objPHPExcel->getActiveSheet()->setCellValue('G7', "TOTAL"); 

		$objPHPExcel->getActiveSheet()->getStyle('A7')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('B7')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('C7')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('D7')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('E7')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('F7')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('G7')->applyFromArray($style_col);

		cellColor('A7:G7', 'cccccc');

		$baris=8;
		$QAbsensiKelas=mysql_query("select 
			wk_absensi.*,
			ak_kelas.id_kls,
			ak_kelas.kode_kelas,
			ak_kelas.nama_kelas 
			from 
			wk_absensi 
			inner join ak_kelas on wk_absensi.id_kelas=ak_kelas.id_kls 
			where 
			ak_kelas.kode_kelas='$kls' and 
			wk_absensi.tahunajaran='$thnajaran' and 
			wk_absensi.semester='$gg' order by wk_absensi.jmlabsen desc");
		$JmlData=mysql_num_rows($QAbsensiKelas);
		$no=1;
		while($HAbKel=mysql_fetch_array($QAbsensiKelas)){
			$QSis=mysql_query("select nis,nm_siswa from siswa_biodata where nis='{$HAbKel['nis']}'");
			$HSis=mysql_fetch_array($QSis);
			$JSakit=$JSakit+$HAbKel['sakit'];
			$JIzin=$JIzin+$HAbKel['izin'];
			$JAlfa=$JAlfa+$HAbKel['alfa'];
			$JTotal=$JTotal+$HAbKel['jmlabsen'];

			$objPHPExcel->getActiveSheet()->setCellValue('A'.$baris, $no);
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$baris, $HAbKel['nis']);
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$baris, $HSis['nm_siswa']);
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$baris, $HAbKel['sakit']);
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$baris, $HAbKel['izin']);
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$baris, $HAbKel['alfa']);
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$baris, $HAbKel['jmlabsen']);

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
			$objPHPExcel->getActiveSheet()->getStyle('E'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('F'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('G'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$baris++;
			$no++;
		}

		$QWK=mysql_query("select ak_kelas.id_guru,app_user_guru.nip,app_user_guru.nama_lengkap from ak_kelas,app_user_guru where ak_kelas.id_guru=app_user_guru.id_guru and ak_kelas.kode_kelas='$kls' and ak_kelas.tahunajaran='$thnajaran'");
		$HWK=mysql_fetch_array($QWK);

		$BariR2=$JmlData+8;

		$objPHPExcel->getActiveSheet()->mergeCells('A'.$BariR2.':C'.$BariR2);
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$BariR2, "TOTAL");
		$objPHPExcel->getActiveSheet()->setCellValue('D'.$BariR2, $JSakit);
		$objPHPExcel->getActiveSheet()->setCellValue('E'.$BariR2, $JIzin);
		$objPHPExcel->getActiveSheet()->setCellValue('F'.$BariR2, $JAlfa);
		$objPHPExcel->getActiveSheet()->setCellValue('G'.$BariR2, $JTotal);

		$objPHPExcel->getActiveSheet()->getStyle('A'.$BariR2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('D'.$BariR2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('E'.$BariR2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('F'.$BariR2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('G'.$BariR2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$objPHPExcel->getActiveSheet()->getStyle('A'.$BariR2)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('B'.$BariR2)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('C'.$BariR2)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('D'.$BariR2)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('E'.$BariR2)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('F'.$BariR2)->applyFromArray($style_row);
		$objPHPExcel->getActiveSheet()->getStyle('G'.$BariR2)->applyFromArray($style_row);

		cellColor('A'.$BariR2.':G'.$BariR2, 'cccccc');

		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5.00);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10.00);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10.00);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10.00);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10.00);

		$BarisKe=$JmlData+10;
		$BarisKe1=$BarisKe+1;

		$Titimangsa=$HProfil['kecamatan'];

		$Tgl=TglLengkap($tglSekarang=date('Y-m-d'));

		$objPHPExcel->getActiveSheet()->mergeCells('D'.$BarisKe.':G'.$BarisKe);
		$objPHPExcel->getActiveSheet()->setCellValue('D'.$BarisKe, $Titimangsa.", ".$Tgl);
		$objPHPExcel->getActiveSheet()->mergeCells('D'.$BarisKe1.':G'.$BarisKe1);
		$objPHPExcel->getActiveSheet()->setCellValue('D'.$BarisKe1, "Wali Kelas,");

		$BarisKe2=$BarisKe1+4;
		$BarisKe3=$BarisKe2+1;

		$NIPWK="NIP. ".$HWK['nip'];

		$objPHPExcel->getActiveSheet()->mergeCells('D'.$BarisKe2.':G'.$BarisKe2);
		$objPHPExcel->getActiveSheet()->setCellValue('D'.$BarisKe2, $HWK['nama_lengkap']);
		$objPHPExcel->getActiveSheet()->mergeCells('D'.$BarisKe3.':G'.$BarisKe3);
		$objPHPExcel->getActiveSheet()->setCellValue('D'.$BarisKe3, $NIPWK);

		$objPHPExcel->getActiveSheet()->getStyle('D'.$BarisKe2)->getFont()->setBold(true);

		$NamaFile="ABSENSI-".$HKelas['kode_kelas']."-".$thnajaran."-".$gg;
		// Mencetak File Excel 
		header('Content-Type: application/vnd.ms-excel'); 
		header('Content-Disposition: attachment;filename="'.$NamaFile.'.xls"'); 
		header('Cache-Control: max-age=0'); 
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
		$objWriter->save('php://output');
	break;

	case "laporan-nilai":
		$kbm=isset($_GET['kbm'])?$_GET['kbm']:""; 
		$mapel=isset($_GET['mapel'])?$_GET['mapel']:""; 
		$kls=isset($_GET['kls'])?$_GET['kls']:""; 
		$thnajar=isset($_GET['thnajar'])?$_GET['thnajar']:""; 
		$semester=isset($_GET['semester'])?$_GET['semester']:""; 
		
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

		$NIPGuru="NIP. ".$GuruNgajarNIP;

		$QKS=mysql_query("select * from ak_kepsek where thnajaran='$thnajar' and smstr='$semester'");
		$HKS=mysql_fetch_array($QKS);
		$NamaKepsek=$HKS['nama'];
		$NIPKepsek="NIP. ".$HKS['nip'];

		$objPHPExcel->getActiveSheet()->mergeCells('A'.$BarisKe2.':C'.$BarisKe2);
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$BarisKe2, $NamaKepsek);
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
	break;

	case "nilai-mapel":
		$kbm=isset($_GET['kbm'])?$_GET['kbm']:""; 
		$komp=isset($_GET['komp'])?$_GET['komp']:""; 
		$mapel=isset($_GET['mapel'])?$_GET['mapel']:""; 
		$kls=isset($_GET['kls'])?$_GET['kls']:""; 
		
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
		
		//Mencetak header berdasarkan field tabel
		$objPHPExcel->getActiveSheet()->setCellValue('A1', "No.");
		$objPHPExcel->getActiveSheet()->setCellValue('B1', "Kode KBM");
		$objPHPExcel->getActiveSheet()->setCellValue('C1', "NIS");
		$objPHPExcel->getActiveSheet()->setCellValue('D1', "Nama Siswa"); 
		$objPHPExcel->getActiveSheet()->setCellValue('E1', "KD1"); 
		$objPHPExcel->getActiveSheet()->setCellValue('F1', "KD2"); 
		$objPHPExcel->getActiveSheet()->setCellValue('G1', "KD3"); 
		$objPHPExcel->getActiveSheet()->setCellValue('H1', "KD4"); 
		$objPHPExcel->getActiveSheet()->setCellValue('I1', "KD5"); 
		$objPHPExcel->getActiveSheet()->setCellValue('J1', "KD6"); 
		$objPHPExcel->getActiveSheet()->setCellValue('K1', "KD7"); 
		$objPHPExcel->getActiveSheet()->setCellValue('L1', "KD8"); 
		$objPHPExcel->getActiveSheet()->setCellValue('M1', "KD9"); 
		$objPHPExcel->getActiveSheet()->setCellValue('N1', "KD10"); 
		$objPHPExcel->getActiveSheet()->setCellValue('O1', "KD11"); 
		$objPHPExcel->getActiveSheet()->setCellValue('P1', "KD12"); 
		$objPHPExcel->getActiveSheet()->setCellValue('Q1', "KD13"); 
		$objPHPExcel->getActiveSheet()->setCellValue('R1', "KD14"); 
		$objPHPExcel->getActiveSheet()->setCellValue('S1', "KD15"); 
		$objPHPExcel->getActiveSheet()->setCellValue('T1', "NA"); 
		$objPHPExcel->getActiveSheet()->setCellValue('U1', "Nama Pengajar"); 
		$objPHPExcel->getActiveSheet()->setCellValue('V1', "Mata Pelajaran"); 
		
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
		$objPHPExcel->getActiveSheet()->getStyle('N1')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('O1')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('P1')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('Q1')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('R1')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('S1')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('T1')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('U1')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('V1')->applyFromArray($style_col);
		
		cellColor('A1:V1', 'cccccc');
		
		if($komp=="keterampilan"){
			$baris=2;
			$No=1;
			$Q=mysql_query("select 
				siswa_biodata.nm_siswa, 
				app_user_guru.nama_lengkap,
				ak_matapelajaran.nama_mapel,
				n_k_kikd.*
				from n_k_kikd
				inner join siswa_biodata on n_k_kikd.nis=siswa_biodata.nis 
				inner join gmp_ngajar on n_k_kikd.kd_ngajar=gmp_ngajar.id_ngajar
				inner join app_user_guru on gmp_ngajar.kd_guru=app_user_guru.id_guru
				inner join ak_matapelajaran on gmp_ngajar.kd_mapel=ak_matapelajaran.kode_mapel
				where n_k_kikd.kd_ngajar='$kbm' order by siswa_biodata.nm_siswa,siswa_biodata.nis");
			while($H=mysql_fetch_array($Q)){
				$objPHPExcel->getActiveSheet()->setCellValue('A'.$baris, $No);
				$objPHPExcel->getActiveSheet()->setCellValue('B'.$baris, $H['kd_ngajar']);
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$baris, $H['nis']);
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$baris, $H['nm_siswa']);
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$baris, $H['kd_1']);
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$baris, $H['kd_2']);
				$objPHPExcel->getActiveSheet()->setCellValue('G'.$baris, $H['kd_3']);
				$objPHPExcel->getActiveSheet()->setCellValue('H'.$baris, $H['kd_4']);
				$objPHPExcel->getActiveSheet()->setCellValue('I'.$baris, $H['kd_5']);
				$objPHPExcel->getActiveSheet()->setCellValue('J'.$baris, $H['kd_6']);
				$objPHPExcel->getActiveSheet()->setCellValue('K'.$baris, $H['kd_7']);
				$objPHPExcel->getActiveSheet()->setCellValue('L'.$baris, $H['kd_8']);
				$objPHPExcel->getActiveSheet()->setCellValue('M'.$baris, $H['kd_9']);
				$objPHPExcel->getActiveSheet()->setCellValue('N'.$baris, $H['kd_10']);
				$objPHPExcel->getActiveSheet()->setCellValue('O'.$baris, $H['kd_11']);
				$objPHPExcel->getActiveSheet()->setCellValue('P'.$baris, $H['kd_12']);
				$objPHPExcel->getActiveSheet()->setCellValue('Q'.$baris, $H['kd_13']);
				$objPHPExcel->getActiveSheet()->setCellValue('R'.$baris, $H['kd_14']);
				$objPHPExcel->getActiveSheet()->setCellValue('S'.$baris, $H['kd_15']);
				$objPHPExcel->getActiveSheet()->setCellValue('T'.$baris, $H['kikd_k']);
				$objPHPExcel->getActiveSheet()->setCellValue('U'.$baris, $H['nama_lengkap']);
				$objPHPExcel->getActiveSheet()->setCellValue('V'.$baris, $H['nama_mapel']);
		
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
				$objPHPExcel->getActiveSheet()->getStyle('O'.$baris)->applyFromArray($style_row);
				$objPHPExcel->getActiveSheet()->getStyle('P'.$baris)->applyFromArray($style_row);
				$objPHPExcel->getActiveSheet()->getStyle('Q'.$baris)->applyFromArray($style_row);
				$objPHPExcel->getActiveSheet()->getStyle('R'.$baris)->applyFromArray($style_row);
				$objPHPExcel->getActiveSheet()->getStyle('S'.$baris)->applyFromArray($style_row);
				$objPHPExcel->getActiveSheet()->getStyle('T'.$baris)->applyFromArray($style_row);
				$objPHPExcel->getActiveSheet()->getStyle('U'.$baris)->applyFromArray($style_row);
				$objPHPExcel->getActiveSheet()->getStyle('V'.$baris)->applyFromArray($style_row);
		
				$objPHPExcel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('B'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('C'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
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
				$objPHPExcel->getActiveSheet()->getStyle('O'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('P'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('Q'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('R'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('S'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('T'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
				$baris++;
				$No++;
			}
		}
		else 
		if($komp=="pengetahuan"){
			$baris=2;
			$No=1;
			$Q=mysql_query("select 
				siswa_biodata.nm_siswa, 
				app_user_guru.nama_lengkap,
				ak_matapelajaran.nama_mapel,
				n_p_kikd.*
				from n_p_kikd
				inner join siswa_biodata on n_p_kikd.nis=siswa_biodata.nis 
				inner join gmp_ngajar on n_p_kikd.kd_ngajar=gmp_ngajar.id_ngajar
				inner join app_user_guru on gmp_ngajar.kd_guru=app_user_guru.id_guru
				inner join ak_matapelajaran on gmp_ngajar.kd_mapel=ak_matapelajaran.kode_mapel
				where n_p_kikd.kd_ngajar='$kbm' order by siswa_biodata.nm_siswa,siswa_biodata.nis");
			while($H=mysql_fetch_array($Q)){
				$objPHPExcel->getActiveSheet()->setCellValue('A'.$baris, $No);
				$objPHPExcel->getActiveSheet()->setCellValue('B'.$baris, $H['kd_ngajar']);
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$baris, $H['nis']);
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$baris, $H['nm_siswa']);
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$baris, $H['kd_1']);
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$baris, $H['kd_2']);
				$objPHPExcel->getActiveSheet()->setCellValue('G'.$baris, $H['kd_3']);
				$objPHPExcel->getActiveSheet()->setCellValue('H'.$baris, $H['kd_4']);
				$objPHPExcel->getActiveSheet()->setCellValue('I'.$baris, $H['kd_5']);
				$objPHPExcel->getActiveSheet()->setCellValue('J'.$baris, $H['kd_6']);
				$objPHPExcel->getActiveSheet()->setCellValue('K'.$baris, $H['kd_7']);
				$objPHPExcel->getActiveSheet()->setCellValue('L'.$baris, $H['kd_8']);
				$objPHPExcel->getActiveSheet()->setCellValue('M'.$baris, $H['kd_9']);
				$objPHPExcel->getActiveSheet()->setCellValue('N'.$baris, $H['kd_10']);
				$objPHPExcel->getActiveSheet()->setCellValue('O'.$baris, $H['kd_11']);
				$objPHPExcel->getActiveSheet()->setCellValue('P'.$baris, $H['kd_12']);
				$objPHPExcel->getActiveSheet()->setCellValue('Q'.$baris, $H['kd_13']);
				$objPHPExcel->getActiveSheet()->setCellValue('R'.$baris, $H['kd_14']);
				$objPHPExcel->getActiveSheet()->setCellValue('S'.$baris, $H['kd_15']);
				$objPHPExcel->getActiveSheet()->setCellValue('T'.$baris, $H['kikd_p']);
				$objPHPExcel->getActiveSheet()->setCellValue('U'.$baris, $H['nama_lengkap']);
				$objPHPExcel->getActiveSheet()->setCellValue('V'.$baris, $H['nama_mapel']);
		
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
				$objPHPExcel->getActiveSheet()->getStyle('O'.$baris)->applyFromArray($style_row);
				$objPHPExcel->getActiveSheet()->getStyle('P'.$baris)->applyFromArray($style_row);
				$objPHPExcel->getActiveSheet()->getStyle('Q'.$baris)->applyFromArray($style_row);
				$objPHPExcel->getActiveSheet()->getStyle('R'.$baris)->applyFromArray($style_row);
				$objPHPExcel->getActiveSheet()->getStyle('S'.$baris)->applyFromArray($style_row);
				$objPHPExcel->getActiveSheet()->getStyle('T'.$baris)->applyFromArray($style_row);
				$objPHPExcel->getActiveSheet()->getStyle('U'.$baris)->applyFromArray($style_row);
				$objPHPExcel->getActiveSheet()->getStyle('V'.$baris)->applyFromArray($style_row);
		
				$objPHPExcel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('B'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('C'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
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
				$objPHPExcel->getActiveSheet()->getStyle('O'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('P'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('Q'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('R'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('S'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('T'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
				$baris++;
				$No++;
			}
		}
		else 
		if($komp=="cp"){
			$baris=2;
			$No=1;
			$Q=mysql_query("select 
				siswa_biodata.nm_siswa, 
				app_user_guru.nama_lengkap,
				ak_matapelajaran.nama_mapel,
				n_p_kikd.*
				from n_p_kikd
				inner join siswa_biodata on n_p_kikd.nis=siswa_biodata.nis 
				inner join gmp_ngajar on n_p_kikd.kd_ngajar=gmp_ngajar.id_ngajar
				inner join app_user_guru on gmp_ngajar.kd_guru=app_user_guru.id_guru
				inner join ak_matapelajaran on gmp_ngajar.kd_mapel=ak_matapelajaran.kode_mapel
				where n_p_kikd.kd_ngajar='$kbm' order by siswa_biodata.nm_siswa,siswa_biodata.nis");
			while($H=mysql_fetch_array($Q)){
				$objPHPExcel->getActiveSheet()->setCellValue('A'.$baris, $No);
				$objPHPExcel->getActiveSheet()->setCellValue('B'.$baris, $H['kd_ngajar']);
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$baris, $H['nis']);
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$baris, $H['nm_siswa']);
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$baris, $H['kd_1']);
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$baris, $H['kd_2']);
				$objPHPExcel->getActiveSheet()->setCellValue('G'.$baris, $H['kd_3']);
				$objPHPExcel->getActiveSheet()->setCellValue('H'.$baris, $H['kd_4']);
				$objPHPExcel->getActiveSheet()->setCellValue('I'.$baris, $H['kd_5']);
				$objPHPExcel->getActiveSheet()->setCellValue('J'.$baris, $H['kd_6']);
				$objPHPExcel->getActiveSheet()->setCellValue('K'.$baris, $H['kd_7']);
				$objPHPExcel->getActiveSheet()->setCellValue('L'.$baris, $H['kd_8']);
				$objPHPExcel->getActiveSheet()->setCellValue('M'.$baris, $H['kd_9']);
				$objPHPExcel->getActiveSheet()->setCellValue('N'.$baris, $H['kd_10']);
				$objPHPExcel->getActiveSheet()->setCellValue('O'.$baris, $H['kd_11']);
				$objPHPExcel->getActiveSheet()->setCellValue('P'.$baris, $H['kd_12']);
				$objPHPExcel->getActiveSheet()->setCellValue('Q'.$baris, $H['kd_13']);
				$objPHPExcel->getActiveSheet()->setCellValue('R'.$baris, $H['kd_14']);
				$objPHPExcel->getActiveSheet()->setCellValue('S'.$baris, $H['kd_15']);
				$objPHPExcel->getActiveSheet()->setCellValue('T'.$baris, $H['kikd_p']);
				$objPHPExcel->getActiveSheet()->setCellValue('U'.$baris, $H['nama_lengkap']);
				$objPHPExcel->getActiveSheet()->setCellValue('V'.$baris, $H['nama_mapel']);
		
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
				$objPHPExcel->getActiveSheet()->getStyle('O'.$baris)->applyFromArray($style_row);
				$objPHPExcel->getActiveSheet()->getStyle('P'.$baris)->applyFromArray($style_row);
				$objPHPExcel->getActiveSheet()->getStyle('Q'.$baris)->applyFromArray($style_row);
				$objPHPExcel->getActiveSheet()->getStyle('R'.$baris)->applyFromArray($style_row);
				$objPHPExcel->getActiveSheet()->getStyle('S'.$baris)->applyFromArray($style_row);
				$objPHPExcel->getActiveSheet()->getStyle('T'.$baris)->applyFromArray($style_row);
				$objPHPExcel->getActiveSheet()->getStyle('U'.$baris)->applyFromArray($style_row);
				$objPHPExcel->getActiveSheet()->getStyle('V'.$baris)->applyFromArray($style_row);
		
				$objPHPExcel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('B'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('C'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
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
				$objPHPExcel->getActiveSheet()->getStyle('O'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('P'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('Q'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('R'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('S'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('T'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
				$baris++;
				$No++;
			}
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
		
		$NamaFile=$kbm." - ".$kls." - ".$mapel." - ".$komp;
		// Mencetak File Excel 
		header('Content-Type: application/vnd.ms-excel'); 
		header('Content-Disposition: attachment;filename="'.$NamaFile.'.xls"'); 
		header('Cache-Control: max-age=0'); 
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
		$objWriter->save('php://output');
	break;

	case "nilai-utsuas":
		$kbm=isset($_GET['kbm'])?$_GET['kbm']:""; 
		$komp=isset($_GET['komp'])?$_GET['komp']:""; 
		$mapel=isset($_GET['mapel'])?$_GET['mapel']:""; 
		$kls=isset($_GET['kls'])?$_GET['kls']:""; 
		
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
		$objPHPExcel->getActiveSheet()->setCellValue('A1', "No.");
		$objPHPExcel->getActiveSheet()->setCellValue('B1', "Kode KBM");
		$objPHPExcel->getActiveSheet()->setCellValue('C1', "NIS");
		$objPHPExcel->getActiveSheet()->setCellValue('D1', "Nama Siswa"); 
		$objPHPExcel->getActiveSheet()->setCellValue('E1', "UTS"); 
		$objPHPExcel->getActiveSheet()->setCellValue('F1', "UAS"); 
		$objPHPExcel->getActiveSheet()->setCellValue('G1', "Nama Pengajar"); 
		$objPHPExcel->getActiveSheet()->setCellValue('H1', "Mata Pelajaran"); 
		
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
		$Q=mysql_query("select 
			siswa_biodata.nm_siswa, 
			app_user_guru.nama_lengkap,
			ak_matapelajaran.nama_mapel,
			n_utsuas.*
			from n_utsuas
			inner join siswa_biodata on n_utsuas.nis=siswa_biodata.nis 
			inner join gmp_ngajar on n_utsuas.kd_ngajar=gmp_ngajar.id_ngajar
			inner join app_user_guru on gmp_ngajar.kd_guru=app_user_guru.id_guru
			inner join ak_matapelajaran on gmp_ngajar.kd_mapel=ak_matapelajaran.kode_mapel
			where n_utsuas.kd_ngajar='$kbm' order by siswa_biodata.nm_siswa,siswa_biodata.nis");
		while($H=mysql_fetch_array($Q)){
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$baris, $No);
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$baris, $H['kd_ngajar']);
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$baris, $H['nis']);
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$baris, $H['nm_siswa']);
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$baris, $H['uts']);
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$baris, $H['uas']);
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$baris, $H['nama_lengkap']);
			$objPHPExcel->getActiveSheet()->setCellValue('H'.$baris, $H['nama_mapel']);
		
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

	case "nilai-sikap":
		$kbm=isset($_GET['kbm'])?$_GET['kbm']:""; 
		$komp=isset($_GET['komp'])?$_GET['komp']:""; 
		$mapel=isset($_GET['mapel'])?$_GET['mapel']:""; 
		$kls=isset($_GET['kls'])?$_GET['kls']:""; 
		
		$Q=mysql_query("select 
			siswa_biodata.nm_siswa, 
			app_user_guru.nama_lengkap,
			ak_matapelajaran.nama_mapel,
			n_sikap.*
			from n_sikap
			inner join siswa_biodata on n_sikap.nis=siswa_biodata.nis 
			inner join gmp_ngajar on n_sikap.kd_ngajar=gmp_ngajar.id_ngajar
			inner join app_user_guru on gmp_ngajar.kd_guru=app_user_guru.id_guru
			inner join ak_matapelajaran on gmp_ngajar.kd_mapel=ak_matapelajaran.kode_mapel
			where n_sikap.kd_ngajar='$kbm' order by siswa_biodata.nm_siswa,siswa_biodata.nis");
		
		require_once 'Classes/PHPExcel.php';
		$objPHPExcel = new PHPExcel();
		
		$objPHPExcel->getProperties()->setCreator("Abdul Madjid, SPd., M.Pd.")
									 ->setLastModifiedBy("Abdul Madjid, SPd., M.Pd.")
									 ->setTitle("NILAI SIKAP")
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
		$objPHPExcel->getActiveSheet()->setCellValue('E1', "K1"); 
		$objPHPExcel->getActiveSheet()->setCellValue('F1', "K2"); 
		$objPHPExcel->getActiveSheet()->setCellValue('G1', "Desk K1"); 
		$objPHPExcel->getActiveSheet()->setCellValue('H1', "Desk K2"); 
		$objPHPExcel->getActiveSheet()->setCellValue('I1', "Nama Pengajar"); 
		$objPHPExcel->getActiveSheet()->setCellValue('J1', "Mata Pelajaran"); 
		
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
		$No=1;
		
		while($H=mysql_fetch_array($Q)){
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$baris, $No);
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$baris, $H['kd_ngajar']);
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$baris, $H['nis']);
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$baris, $H['nm_siswa']);
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$baris, $H['spritual']);
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$baris, $H['sosial']);
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$baris, $H['desk_spritual']);
			$objPHPExcel->getActiveSheet()->setCellValue('H'.$baris, $H['desk_sosial']);
			$objPHPExcel->getActiveSheet()->setCellValue('I'.$baris, $H['nama_lengkap']);
			$objPHPExcel->getActiveSheet()->setCellValue('J'.$baris, $H['nama_mapel']);
		
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
			$objPHPExcel->getActiveSheet()->getStyle('C'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('E'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('F'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
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
		
		$NamaFile=$kbm." - ".$kls." - ".$mapel." - ".$komp;
		// Mencetak File Excel 
		header('Content-Type: application/vnd.ms-excel'); 
		header('Content-Disposition: attachment;filename="'.$NamaFile.'.xls"'); 
		header('Cache-Control: max-age=0'); 
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
		$objWriter->save('php://output');	
	break;
}
