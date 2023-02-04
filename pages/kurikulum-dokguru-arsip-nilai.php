<?php
require_once("inc/init.php");
require_once("inc/config.ui.php");
$page_title = "Arsip Nilai";
$page_css[] = "your_style.css";
include("inc/header.php");
$page_nav["kurikulum"]["sub"]["dokumenguru"]["sub"]["arsipnilai"]["active"] = true;
include("inc/nav.php");
echo "<div id='main' role='main'>";
$breadcrumbs["Kurikulum / Dokumen Guru"] = "";
include("inc/ribbon.php");	
$sub = (isset($_GET['sub']))? $_GET['sub'] : "";
switch ($sub)
{
	case "tampil":default:
		$thnajaran=(isset($_GET['thnajaran']))?$_GET['thnajaran']:"";
		$gg=isset($_GET['gg'])?$_GET['gg']:""; 
		$id_pk=isset($_GET['id_pk'])?$_GET['id_pk']:"";

//===========================================================================================================[FORM ADMIN NYARI DATA]
		
		$NyariData.="
		<form action='?page=$page' method='post' name='frmaing' class='form-inline' role='form'>
		<div class='row'>
				<div class='col-sm-12 col-md-8'>
					<div class='form-group'>Pililh Data &nbsp;&nbsp;</div>";
		$NyariData.=FormCF("inline","Tahun Pelajaran","txtThnAjar","select * from ak_tahunajaran order by id_thnajar asc","tahunajaran",$_GET['thnajaran'],"tahunajaran","4","onchange=\"document.location.href='?page=$page&thnajaran='+document.frmaing.txtThnAjar.value\"");
		if(!empty($_GET['thnajaran'])){
			$NyariData.=FormCF("inline","Semester","txtGG","select * from ak_semester","ganjilgenap",$_GET['gg'],"ganjilgenap","4","onchange=\"document.location.href='?page=$page&thnajaran='+document.frmaing.txtThnAjar.value+'&gg='+document.frmaing.txtGG.value\"");
		}
		if(!empty($_GET['gg'])){
			$NyariData.=FormCF("inline","Paket Keahlian","txtPK","SELECT ak_kelas.tahunajaran,ak_kelas.kode_pk,ak_paketkeahlian.nama_paket FROM ak_kelas inner join ak_paketkeahlian ON ak_kelas.kode_pk=ak_paketkeahlian.kode_pk where ak_kelas.tahunajaran='".$_GET['thnajaran']."' GROUP BY tahunajaran,kode_pk","kode_pk",$_GET['id_pk'],"nama_paket","4","onchange=\"document.location.href='?page=$page&thnajaran='+document.frmaing.txtThnAjar.value+'&gg='+document.frmaing.txtGG.value+'&id_pk='+document.frmaing.txtPK.value\"");
		}
		$NyariData.="</div></div></div>
		</form>";
		
//=============================================================[CEK KBM PER GURU]
		if(!empty($id_pk)){$wh="and gmp_ngajar.kd_pk='$id_pk' ";}
		$QNgajar=mysql_query("
		SELECT 
		gmp_ngajar.id_ngajar,
		gmp_ngajar.thnajaran,
		gmp_ngajar.jenismapel,
		gmp_ngajar.semester,
		gmp_ngajar.kkmpeng,
		gmp_ngajar.kkmket,
		app_user_guru.nama_lengkap,
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
		gmp_ngajar.thnajaran='$thnajaran' and
		gmp_ngajar.ganjilgenap='$gg' 
		$wh
		order by gmp_ngajar.kd_kelas,gmp_ngajar.kd_mapel asc");
		
		$no=1;
		
		while($HNgajar=mysql_fetch_array($QNgajar))
		{
			 
			$TampilData.="
			<tr>
				<td class='text-center'>$no.</td>
				<td>{$HNgajar['nama_lengkap']}</td>
				<td>{$HNgajar['nama_mapel']}</td>
				<td>{$HNgajar['nama_kelas']}</td>
				<td>
					<a href='?page=$page&amp;sub=cekkikd&amp;Kode={$HNgajar['id_ngajar']}&thnajaran=$thnajaran&gg=$gg' title='Arsip KBM'><i class='fa fa-folder-open-o fa-border txt-color-red'></i> <span class='hidden-xs'>Data KBM</span></a>  
					<a href='?page=$page&amp;sub=arsipnilai&amp;kbm={$HNgajar['id_ngajar']}&thnajaran=$thnajaran&gg=$gg' title='Arsip Nilai'><i class='fa fa-graduation-cap fa-border txt-color-red'></i> <span class='hidden-xs'>Data Nilai</a></span></td>
			</tr>";
			$no++;
		}
		if(empty($thnajaran)) {
			$ShowArsip.=nt("informasi","Silakan pilih tahun ajaran");
		}
		else if(empty($gg)){
			$ShowArsip.=nt("informasi","Silakan pilih semester");
		}
		else {
			$ShowArsip.=JudulKolom("KBM $thnajaran Semester $gg","book");
			$ShowArsip.="
				
				<table id='dt_basic' class='table table-striped table-bordered table-hover table-condensed' width='100%'>
					<thead>
						<tr>
							<th class='text-center' data-class='expand'>No.</th>
							<th class='text-center'>Nama Pengajar</th>
							<th class='text-center'>Mata Pelajaran</th>
							<th class='text-center' data-hide='phone,tablet'>Kelas</th>
							<th class='text-center'>Arsip</th>
						</tr>
					</thead>
					<tbody>$TampilData</tbody>
				</table>
			
			";
		}
		$Show.=KolomPanel($NyariData);
		$Show.=$ShowArsip;
		$tandamodal="#ArsipDataKBM";
		echo $ArsipDataKBM;
		echo MyWidget('fa-map-o',"Arsip KBM dan Nilai","",$Show);
	break;

	case "cekkikd":
		$KodeEdit= isset($_GET['Kode'])?$_GET['Kode']:""; 
		$thnajaran=(isset($_GET['thnajaran']))?$_GET['thnajaran']:"";
		$gg=isset($_GET['gg'])?$_GET['gg']:""; 
		$Show.=ButtonKembali2("?page=$page&thnajaran=$thnajaran&gg=$gg","style='margin-top:-10px;'");
		$Show.=JudulKolom("KIKD KBM TA $thnajaran Semester $gg","");
		$Q="select 
		gmp_kikd.id_dk,
		ak_kikd.kode_ranah,
		ak_kikd.no_kikd,
		ak_kikd.isikikd,
		ak_matapelajaran.nama_mapel,
		ak_kelas.nama_kelas,
		app_user_guru.nama_lengkap,
		gmp_ngajar.thnajaran,
		gmp_ngajar.semester
		from gmp_kikd
		inner join ak_kikd on gmp_kikd.kode_kikd=ak_kikd.id_kikd
		inner join gmp_ngajar on gmp_kikd.kode_ngajar=gmp_ngajar.id_ngajar 
		inner join ak_matapelajaran on gmp_ngajar.kd_mapel=ak_matapelajaran.kode_mapel
		inner join app_user_guru on gmp_ngajar.kd_guru=app_user_guru.id_guru
		inner join ak_kelas on gmp_ngajar.kd_kelas=ak_kelas.kode_kelas
		where gmp_kikd.kode_ngajar='$KodeEdit'";
		$QueryData=mysql_query($Q);
		$HasilData=mysql_fetch_array($QueryData);
		if(mysql_num_rows($QueryData)>=1){
			$NamaMapel=$HasilData['nama_mapel'];
			$Kelasna=$HasilData['nama_kelas'];
			$NamaGuru=$HasilData['nama_lengkap'];
			$TA=$HasilData['thnajaran'];
			$SMST=$HasilData['semester']." (".terbilang($HasilData['semester']).")";	
			$ShowInfoKD.=FormInfoTabel("Tahun Ajaran",$TA,"2px");
			$ShowInfoKD.=FormInfoTabel("Semester", $SMST,"2px");
			$ShowInfoKD.=FormInfoTabel("Nama Guru", $NamaGuru,"2px");
			$ShowInfoKD.=FormInfoTabel("Kelas", $Kelasna,"2px");
			$ShowInfoKD.=FormInfoTabel("Mata Pelajaran", $NamaMapel,"2px");
			$ShowData.="<div class='well no-margin'><table>$ShowInfoKD</table></div>";
			$ShowData.="<br>";
		}
	//KD SIKAP ============================================================================
		$noS=1;
		$QueryKDS=mysql_query("$Q and gmp_kikd.kode_ranah='KDS' order by ak_kikd.kode_ranah,ak_kikd.no_kikd asc");
		while($HasilKDS=mysql_fetch_array($QueryKDS)){
			$TampilDataKDS.="
			<tr>
				<td width='75' valign='top'>{$HasilKDS['no_kikd']}</td>
				<td>{$HasilKDS['isikikd']}</td>
			</tr>";
			$noS++;
		}
		$JmlDataS=mysql_num_rows($QueryKDS);		
		if($JmlDataS>0){$ShowSikap.="<table class='table'>$TampilDataKDS</table>";}
		else{$ShowSikap.=errorKD("SIKAP");}	
	//KD PENGETAHUAN =============================================================================
		$noP=1;
		$QueryKDP=mysql_query("$Q and gmp_kikd.kode_ranah='KDP' order by gmp_kikd.kode_kikd asc");
		while($HasilKDP=mysql_fetch_array($QueryKDP)){
			$TampilDataKDP.="
			<tr>
				<td width='75' valign='top'>{$HasilKDP['no_kikd']}</td>
				<td>{$HasilKDP['isikikd']}</td>
			</tr>";
			$no++;
		}
		$JmlDataP=mysql_num_rows($QueryKDP);		
		if($JmlDataP>0){$ShowPengetahuan.="<table class='table'>$TampilDataKDP</table>";}
		else{$ShowPengetahuan.=errorKD("PENGETAHUAN");}
	//KD KETERAMPILAN =============================================================================
		$noK=1;
		$QueryKDK=mysql_query("$Q and gmp_kikd.kode_ranah='KDK' order by gmp_kikd.kode_kikd asc");
		while($HasilKDK=mysql_fetch_array($QueryKDK)){
			$TampilDataKDK.="
			<tr>
				<td width='75' valign='top'>{$HasilKDK['no_kikd']}</td>
				<td>{$HasilKDK['isikikd']}</td>
			</tr>";
			$no++;
		}
		$JmlDataK=mysql_num_rows($QueryKDK);
		if($JmlDataK>0){$ShowKet.="<table class='table'>$TampilDataKDK</table>";}
		else{$ShowKet.=errorKD("KETERAMPILAN");}
		$DataNP=mysql_query("select * from n_p_kikd where kd_ngajar='$KodeEdit'");
		$DataNK=mysql_query("select * from n_k_kikd where kd_ngajar='$KodeEdit'");
		$Show.=$ShowData;
		//$Show.=Alert("danger","exclamation-triangle","Perhatian!",$Infona);
		$Show.="
		<div class='row'>
			<div class='col-sm-6 col-lg-4'>
				<div class='panel panel-default'>
					<div class='panel-body status'>
						<div class='who clearfix padding-10'><h4 class='txt-color-blue'>KIKD <em><strong>Sikap</strong></em></h4></div>
						<div class='text'>".$ShowSikap."</div>
						<ul class='links'>
							<li>Total <b>$JmlDataS (".terbilang($JmlDataS).")</b></li>
						</ul>
					</div>
				</div>
			</div>
			<div class='col-sm-6 col-lg-4'>
				<div class='panel panel-default'>
					<div class='panel-body status'>
						<div class='who clearfix padding-10'><h4 class='txt-color-blue'>KIKD <em><strong>Pengetahuan</strong></em></h4></div>
						<div class='text'>".$ShowPengetahuan."</div>
						<ul class='links'>
							<li>Total <b>$JmlDataP (".terbilang($JmlDataP).")</b></li>
							
						</ul>
					</div>
				</div>
			</div>
			<div class='col-sm-6 col-lg-4'>
				<div class='panel panel-default'>
					<div class='panel-body status'>
						<div class='who clearfix padding-10'><h4 class='txt-color-blue'>KIKD <em><strong>Keterampilan</strong></em></h4></div>
						<div class='text'>".$ShowKet."</div>
						<ul class='links'>
							<li>Total <b>$JmlDataK (".terbilang($JmlDataK).")</b></li>
							
						</ul>
					</div>
				</div>
			</div>
		</div>";
		$Show.=$ActionKIKD;
		$Show.=$CekKIKDMapel;
		echo IsiPanel($Show,"reorder","KIKD $Kelasna - $thnajaran - $gg","?page=$page&thnajaran=$thnajaran&gg=$gg","share","Kembali","#CekKIKDMapel");
	break;
	case "arsipnilai":
		$kbm=isset($_GET['kbm'])?$_GET['kbm']:""; 
		$thnajaran=(isset($_GET['thnajaran']))?$_GET['thnajaran']:"";
		$gg=isset($_GET['gg'])?$_GET['gg']:""; 
		
		$Show.=ButtonKembali2("?page=$page&thnajaran=$thnajaran&gg=$gg","style='margin-top:-10px;'");
		$Show.=JudulKolom("KBM TA $thnajaran Semester $gg","");
		$DataKDS=mysql_query("select * from gmp_kikd where kode_ngajar='$kbm' and kode_ranah='KDS'");
		$DataKDP=mysql_query("select * from gmp_kikd where kode_ngajar='$kbm' and kode_ranah='KDP'");
		$DataKDK=mysql_query("select * from gmp_kikd where kode_ngajar='$kbm' and kode_ranah='KDK'");
		$jmlKDS=mysql_num_rows($DataKDS);
		$jmlKDP=mysql_num_rows($DataKDP);
		$jmlKDK=mysql_num_rows($DataKDK);
		if($jmlKDS==0 && $jmlKDP==0 && $jmlKDK==0){
			$Show.=nt("informasi","<strong>Kompetensi Dasar </strong> belum di pilih, silakan isi dulu <a href='?page=gmp-ki-kd'>Kompetensi Dasar Mata Pelajaran</a>.");
		}
		else{
			$Q=mysql_query("
			select 
			gmp_ngajar.id_ngajar,
			gmp_ngajar.thnajaran,
			gmp_ngajar.semester,
			gmp_ngajar.ganjilgenap,
			gmp_ngajar.kkmpeng, 
			gmp_ngajar.kkmket,
			gmp_ngajar.kd_mapel,
			ak_kelas.nama_kelas,
			ak_matapelajaran.nama_mapel,
			app_user_guru.nama_lengkap,
			ak_perkelas.nis,
			siswa_biodata.nm_siswa 
			from gmp_ngajar
			inner join ak_perkelas on gmp_ngajar.thnajaran=ak_perkelas.tahunajaran
			inner join ak_kelas on gmp_ngajar.kd_kelas=ak_kelas.kode_kelas and ak_kelas.nama_kelas=ak_perkelas.nm_kelas
			inner join app_user_guru on gmp_ngajar.kd_guru=app_user_guru.id_guru
			inner join ak_matapelajaran on gmp_ngajar.kd_mapel=ak_matapelajaran.kode_mapel
			inner join siswa_biodata on ak_perkelas.nis=siswa_biodata.nis
			where gmp_ngajar.id_ngajar='$kbm' order by siswa_biodata.nis");
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
				if($NKDP['kikd_p']>100){$warna0="#ffff66";}else{$warna0="#fffff4";}
				if($NAP<$NilaiKKMP){$warna1="#ffcccc";}else if($NAP>100){$warna1="#ffff66";}else{$warna1="#fffff4";}
				if($NKDK['kikd_k']<$NilaiKKMK){$warna2="#ffcccc";}else if($NKDK['kikd_k']>100){$warna2="#ffff66";}else{$warna2="#fffff4";}
				$TampilData.="
				<tr>
					<td class='hidden-480 text-center'>$no</td>
					<td>{$Hasil['nm_siswa']}</td>
					<td class='text-center'>{$Hasil['nis']}</td>
					<td class='hidden-480 text-center'>$NSpritual</td>
					<td class='hidden-480 text-center'>$NSosial</td>
					<td class='hidden-480 text-center' bgcolor='$warna0'>{$NKDP['kikd_p']}</td>
					<td class='hidden-480 text-center'>{$NKUTSUAS['uts']}</td>
					<td class='hidden-480 text-center'>{$NKUTSUAS['uas']}</td>
					<td class='hidden-480 text-center' bgcolor='$warna1'>$NAP</td>
					<td class='hidden-480 text-center'>$PredP</td>
					<td class='hidden-480 text-center' bgcolor='$warna2'>{$NKDK['kikd_k']}</td>
					<td class='hidden-480 text-center'>$PredK</td>
					<td class='text-center'>$R2</td>
					<td class='text-center'>$PredSw</td>
				</tr>";
				$no++;
			}
			$jmldata=mysql_num_rows($Q);
			if($jmldata>0){
				$ProfilKBM.="
				<h4 class='txt-color-red no-padding no-margin'><strong>Profil</strong> KBM</h4><hr>
				<div class='row'>
					<div class='col-xs-5 col-lg-3'><span class='txt-color-red'><em>Tahun Ajaran</em></span></div>
					<div class='col-xs-6 col-lg-9'><span class='txt-color-blue'><strong>".$ThnAjaran."</strong></span></div>
				</div>
				<div class='row'>
					<div class='col-xs-5 col-lg-3'><span class='txt-color-red'><em>Semester</em></span></div>
					<div class='col-xs-6 col-lg-6'><span class='txt-color-blue'><strong>".$Smstr."</strong></span></div>
				</div>
				<div class='row'>
					<div class='col-xs-5 col-lg-3'><span class='txt-color-red'><em>Mata Pelajaran</em></span></div>
					<div class='col-xs-6 col-lg-6'><span class='txt-color-blue'><strong>".$Matapel."</strong></span></div>
				</div>
				<div class='row'>
					<div class='col-xs-5 col-lg-3'><span class='txt-color-red'><em>Kelas</em></span></div>
					<div class='col-xs-6 col-lg-6'><span class='txt-color-blue'><strong>".$Kls."</strong></span></div>
				</div>
				<div class='row'>
					<div class='col-xs-5 col-lg-3'><span class='txt-color-red'><em>Nama Guru</em></span></div>
					<div class='col-xs-6 col-lg-6'><span class='txt-color-blue'><strong>".$GuruNgajar."</strong></span></div>
				</div>
				<div class='row'>
					<div class='col-xs-5 col-lg-3'><span class='txt-color-red'><em>Jumlah KD K3</em></span></div>
					<div class='col-xs-6 col-lg-6'><span class='txt-color-blue'><strong>".$jmlKDP." (".terbilang($jmlKDP).")"."</strong></span></div>
				</div>
				<div class='row'>
					<div class='col-xs-5 col-lg-3'><span class='txt-color-red'><em>Jumlah KD K4</em></span></div>
					<div class='col-xs-6 col-lg-6'><span class='txt-color-blue'><strong>".$jmlKDK." (".terbilang($jmlKDK).")"."</strong></span></div>
				</div>
				<div class='row'>
					<div class='col-xs-5 col-lg-3'><span class='txt-color-red'><em>KKM K3</em></span></div>
					<div class='col-xs-6 col-lg-6'><span class='txt-color-blue'><strong>".$NilaiKKMP." (".terbilang($NilaiKKMP).")"."</strong></span></div>
				</div>
				<div class='row'>
					<div class='col-xs-5 col-lg-3'><span class='txt-color-red'><em>KKM K4</em></span></div>
					<div class='col-xs-6 col-lg-6'><span class='txt-color-blue'><strong>".$NilaiKKMK." (".terbilang($NilaiKKMK).")"."</strong></span></div>
				</div>
				<div class='row'>
					<div class='col-xs-5 col-lg-3'><span class='txt-color-red'><em>Jumlah Siswa</em></span></div>
					<div class='col-xs-6 col-lg-6'><span class='txt-color-blue'><strong>".$jmldata." (".terbilang($jmldata).")"."</strong></span></div>
				</div>";
				$Keterangan.="<h4 class='txt-color-red'><strong>Keterangan</strong> <em>Singkatan</em></h4><hr>";
				$Keterangan.=
				"<div class='row'>
					<div class='col-xs-2 col-lg-2'><span class='txt-color-red'><em>SP</em></span></div>
					<div class='col-xs-8 col-lg-8'><span class='txt-color-blue'><strong>Nilai Sikap Spritual</strong></span></div>
				</div>
				<div class='row'>
					<div class='col-xs-2 col-lg-2'><span class='txt-color-red'><em>SO</em></span></div>
					<div class='col-xs-8 col-lg-8'><span class='txt-color-blue'><strong>Nilai Sikap Sosial</strong></span></div>
				</div>
				<div class='row'>
					<div class='col-xs-2 col-lg-2'><span class='txt-color-red'><em>NHP</em></span></div>
					<div class='col-xs-8 col-lg-8'><span class='txt-color-blue'><strong>Nilai Harian Pengetahuan di ambil dari nilai rata-rata per KD</strong></span></div>
				</div>
				<div class='row'>
					<div class='col-xs-2 col-lg-2'><span class='txt-color-red'><em>UTS</em></span></div>
					<div class='col-xs-8 col-lg-8'><span class='txt-color-blue'><strong>Nilai Tengah Semester</strong></span></div>
				</div>
				<div class='row'>
					<div class='col-xs-2 col-lg-2'><span class='txt-color-red'><em>UAS</em></span></div>
					<div class='col-xs-8 col-lg-8'><span class='txt-color-blue'><strong>Nilai Akhir Semester</strong></span></div>
				</div>
				<div class='row'>
					<div class='col-xs-2 col-lg-2'><span class='txt-color-red'><em>NA</em></span></div>
					<div class='col-xs-8 col-lg-8'><span class='txt-color-blue'><strong>Nilai Akhir</strong></span></div>
				</div>
				<div class='row'>
					<div class='col-xs-2 col-lg-2'><span class='txt-color-red'><em>P</em></span></div>
					<div class='col-xs-8 col-lg-8'><span class='txt-color-blue'><strong>Predikat</strong></span></div>
				</div>";
				$ShowTmbl.="<a href=\"javascript:;\" onClick=\"window.open('./pages/excel/ekspor-nilai.php?eksporex=review&kbm=$kbm&mapel=$Matapel&kls=$Kls&thnajar=$ThnAjaran&semester=$Smstr')\" class='btn btn-danger btn-sm pull-right'>Download Nilai</a> <br><br>";
				$Show.=DuaKolomSama("<table>$ProfilKBM</table>","<table>$Keterangan</table>$ShowTmbl");			
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
				$Show.="
				<hr class='simple'>
				<div class='table-responsive'>
				<table id='simple-table' class='table table-striped table-bordered table-hover'>
					<thead>
						<tr>
							<th class='hidden-480 text-center' rowspan='2'>No.</th>
							<th class='text-center' rowspan='2'>Nama Siswa</th>
							<th class='text-center' rowspan='2'>NIS</th>
							<th class='hidden-480 text-center' colspan='2'>Sikap</th>
							<th class='hidden-480 text-center' colspan='5'>Pengetahuan</th>
							<th class='hidden-480 text-center' colspan='2'>Keterampilan</th>
							<th class='text-center' rowspan='2' width='25'>Rata2 Nilai</th>
							<th class='text-center' rowspan='2' width='25'>Predikat Kelas</th>
						</tr>
						<tr>
							<th class='hidden-480 text-center' width='50'>SP</th>
							<th class='hidden-480 text-center' width='50'>SO</th>
							<th class='hidden-480 text-center' width='50'>NHP</th>
							<th class='hidden-480 text-center' width='50'>UTS</th>
							<th class='hidden-480 text-center' width='50'>UAS</th>
							<th class='hidden-480 text-center' width='50'>NA</th>
							<th class='hidden-480 text-center' width='50'>P</th>
							<th class='hidden-480 text-center' width='50'>NA</th>
							<th class='hidden-480 text-center' width='50'>P</th>
						</tr>
					</thead>
					<tbody>
					<tr>
						<th colspan='3' class='hidden-480 text-center'>Rata-rata Kelas</th>
						<th class='hidden-480 text-center'>$RNilSpr</th>
						<th class='hidden-480 text-center'>$RNilSos</th>
						<th class='hidden-480 text-center'>$RNilKDP</th>
						<th class='hidden-480 text-center'>$RUTS</th>
						<th class='hidden-480 text-center'>$RUAS</th>
						<th class='hidden-480 text-center'>$RNAD</th>
						<th class='hidden-480 text-center'>$PredikatP</th>
						<th class='hidden-480 text-center'>$RNilKDK</th>
						<th class='hidden-480 text-center'>$PredikatK</th>
						<th class='hidden-480 text-center'>$RNR</th>
						<th class='hidden-480 text-center'>$Deskripsi</th>
					</tr>
					$TampilData
					<tr>
						<th colspan='3' class='hidden-480 text-center'>Rata-rata Kelas</th>
						<th class='hidden-480 text-center'>$RNilSpr</th>
						<th class='hidden-480 text-center'>$RNilSos</th>
						<th class='hidden-480 text-center'>$RNilKDP</th>
						<th class='hidden-480 text-center'>$RUTS</th>
						<th class='hidden-480 text-center'>$RUAS</th>
						<th class='hidden-480 text-center'>$RNAD</th>
						<th class='hidden-480 text-center'>$PredikatP</th>
						<th class='hidden-480 text-center'>$RNilKDK</th>
						<th class='hidden-480 text-center'>$PredikatK</th>
						<th class='hidden-480 text-center'>$RNR</th>
						<th class='hidden-480 text-center'>$Deskripsi</th>
					</tr>
					</tbody>
				</table>
				</div>";
			}
			else{
				$Show.=nt("informasi","Data Siswa belum ada, silakan hubungi administrator");
			}
		}
		$Show.=$ReviewNilai;
		echo IsiPanel($Show);
	break;
}
echo '</div>';
include("inc/footer.php");
include("inc/scripts.php");
//"))
?>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/datatables/dataTables.colVis.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/datatables/dataTables.tableTools.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/datatables/dataTables.bootstrap.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/datatable-responsive/datatables.responsive.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	/* BASIC ;*/
		var responsiveHelper_dt_basic = undefined;
		var responsiveHelper_datatable_fixed_column = undefined;
		var responsiveHelper_datatable_col_reorder = undefined;
		var responsiveHelper_datatable_tabletools = undefined;
		
		var breakpointDefinition = {
			tablet : 1024,
			phone : 480
		};
		$('#dt_basic').dataTable({
			"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+
				"t"+
				"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
			"autoWidth" : true,
			"preDrawCallback" : function() {
				// Initialize the responsive datatables helper once.
				if (!responsiveHelper_dt_basic) {
					responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_basic'), breakpointDefinition);
				}
			},
			"rowCallback" : function(nRow) {
				responsiveHelper_dt_basic.createExpandIcon(nRow);
			},
			"drawCallback" : function(oSettings) {
				responsiveHelper_dt_basic.respond();
			}
		});
	/* END BASIC */
})
</script>
