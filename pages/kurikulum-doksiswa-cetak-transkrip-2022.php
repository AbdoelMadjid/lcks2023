<?php
require_once("inc/init.php");
require_once("inc/config.ui.php");
$page_title = "Transkrip Nilai";
$page_css[] = "your_style.css";
include("inc/header.php");
$page_nav["kurikulum"]["sub"]["dokumensiswa"]["sub"]["transkrip"]["active"] = true;
include("inc/nav.php");
echo "<div id='main' role='main'>";
$breadcrumbs["Penilaian "] = "";
include("inc/ribbon.php");	
$sub=(isset($_GET['sub']))?$_GET['sub']:"";
switch($sub)
{
	case "tampil":default:

		$TahunLulus=substr($PilTATR3,5);

		$a=isset($_GET['a'])?$_GET['a']:"";
		if($PilNISTR==""){$Show.="";}else{
			$Show.=ButtonKembali2("?page=kurikulum-doksiswa-cetak-transkrip","style='margin-top:-10px;margin-left:10px';");
			$Show.="<a href='javascript:void(0);' class='btn btn-primary btn-sm pull-right' onclick=\"printContent('Cetak')\" style='margin-top:-10px;'><i class='fa fa-print'></i> <span class='hidden-xs'>Cetak</span></a>";
			$Show.="<button class='btn btn-primary btn-sm pull-right' onclick='test()' style='margin-top:-10px;margin-right:10px'><i class='fa fa-download'></i> <span class='hidden-xs'>Download PDF</span></button>";
			if($a==""){
				$Show.="<a href='?page=$page&a=adatt' class='btn btn-primary btn-sm pull-right' style='margin-top:-10px;margin-right:10px'><i class='fa fa-print'></i> <span class='hidden-xs'>Tanpa TT Kepsek</span></a>";
			}else{
				$Show.="<a href='?page=$page' class='btn btn-primary btn-sm pull-right' style='margin-top:-10px;margin-right:10px'><i class='fa fa-print'></i> <span class='hidden-xs'>TT Kepsek</span></a>";
			}
		}
		
		$Show.=JudulKolom("Cetak Transkrip Nilai","print");
		
		$CariData.="<div class='form-group'><div class='col-md-12'>";
		$CariData.=FormCF("inline","Pilih TA","txtThnAjaran","select * from ak_tahunajaran order by id_thnajar asc","tahunajaran",$PilTATR3,"tahunajaran","","disabled='disabled'");
		$CariData.=FormCF("inline","Pilih PK","txtPK","select * from ak_paketkeahlian","kode_pk",$PilPKCetakTR,"nama_paket","","disabled='disabled'");
		$CariData.=FormCF("inline","Pilih Kelas","txtKls","select * from ak_kelas where tahunajaran='$PilTATR3' and kode_pk='$PilPKCetakTR' and tingkat='XII' order by kode_pk,nama_kelas","kode_kelas",$PilKKLSTR3,"nama_kelas","","disabled='disabled'");
		$CariData.=FormCF("inline","Pilih Siswa","txtNIS","select siswa_biodata.nis,siswa_biodata.nm_siswa,ak_kelas.nama_kelas from ak_kelas,siswa_biodata,ak_perkelas where ak_kelas.nama_kelas=ak_perkelas.nm_kelas and ak_kelas.tahunajaran=ak_perkelas.tahunajaran and ak_perkelas.nis=siswa_biodata.nis and ak_kelas.nama_kelas=ak_perkelas.nm_kelas and ak_kelas.kode_kelas='$PilKKLSTR3' order by siswa_biodata.nis","nis",$PilNISTR,"nm_siswa","","onchange=\"document.location.href='?page=$page&sub=updatenis&nis='+document.frmaing.txtNIS.value\"");
		$CariData.="</div></div>";

		$Show.=KolomPanel("<form action='?page=$page&sub=$sub' method='post' name='frmaing' class='form-inline' role='form'>$CariData</form>");
		
	//== TAMPIL TRANSKRIP

		//NgambilData("select * from siswa_biodata where nis='$PilNISTR'");	
		
		$DProfil=mysql_query("select * from app_lembaga");
		$HProfil=mysql_fetch_array($DProfil);

		$DPK=mysql_query("select * from ak_paketkeahlian where kode_pk='$PilPKCetakTR'");
		$HPK=mysql_fetch_array($DPK);

		$DProgK=mysql_query("select * from ak_programkeahlian where kode_program='{$HPK['kode_program']}'");
		$HProgK=mysql_fetch_array($DProgK);

		$DBidA=mysql_query("select * from ak_bidangkeahlian where kode_bidang='{$HPK['kode_bidang']}'");
		$HBidA=mysql_fetch_array($DBidA);


	//== NILAI KELOMPOK A

		$Q="
		select 
		gmp_ngajar.id_ngajar,
		gmp_ngajar.kd_pk,
		gmp_ngajar.kd_mapel,
		n_p_kikd.nis,
		n_p_kikd.kikd_p,
		n_utsuas.nis,
		n_utsuas.uts,
		n_utsuas.uas,
		n_k_kikd.nis,
		n_k_kikd.kikd_k,
		round((n_p_kikd.kikd_p+n_utsuas.uts+n_utsuas.uas)/3) as rata_p,
		round((((n_p_kikd.kikd_p+n_utsuas.uts+n_utsuas.uas)/3)+n_k_kikd.kikd_k)/2) as na
		from gmp_ngajar
		inner join n_p_kikd on gmp_ngajar.id_ngajar=n_p_kikd.kd_ngajar 
		inner join n_k_kikd on gmp_ngajar.id_ngajar=n_k_kikd.kd_ngajar 
		inner join n_utsuas on gmp_ngajar.id_ngajar=n_utsuas.kd_ngajar";

		$DMapelA=mysql_query("select * from ak_matapelajaran where kode_pk='$PilPKCetakTR' and kelompok='A'");
		$MapelA.="<tr><td colspan='13'>&nbsp;&nbsp;<strong>Kelompok A (Wajib)</strong></td></tr>";

		$NoMapelA=1;
		while($HMapelA=mysql_fetch_array($DMapelA)){
			$DN1=mysql_query($Q." where n_p_kikd.nis='$PilNISTR' and n_k_kikd.nis='$PilNISTR' and n_utsuas.nis='$PilNISTR' and gmp_ngajar.semester='1' and gmp_ngajar.kd_mapel='{$HMapelA['kode_mapel']}'");
			$HN1=mysql_fetch_array($DN1);
			$DN2=mysql_query($Q." where n_p_kikd.nis='$PilNISTR' and n_k_kikd.nis='$PilNISTR' and n_utsuas.nis='$PilNISTR' and gmp_ngajar.semester='2' and gmp_ngajar.kd_mapel='{$HMapelA['kode_mapel']}'");
			$HN2=mysql_fetch_array($DN2);
			$DN3=mysql_query($Q." where n_p_kikd.nis='$PilNISTR' and n_k_kikd.nis='$PilNISTR' and n_utsuas.nis='$PilNISTR' and gmp_ngajar.semester='3' and gmp_ngajar.kd_mapel='{$HMapelA['kode_mapel']}'");
			$HN3=mysql_fetch_array($DN3);
			$DN4=mysql_query($Q." where n_p_kikd.nis='$PilNISTR' and n_k_kikd.nis='$PilNISTR' and n_utsuas.nis='$PilNISTR' and gmp_ngajar.semester='4' and gmp_ngajar.kd_mapel='{$HMapelA['kode_mapel']}'");
			$HN4=mysql_fetch_array($DN4);
			$DN5=mysql_query($Q." where n_p_kikd.nis='$PilNISTR' and n_k_kikd.nis='$PilNISTR' and n_utsuas.nis='$PilNISTR' and gmp_ngajar.semester='5' and gmp_ngajar.kd_mapel='{$HMapelA['kode_mapel']}'");
			$HN5=mysql_fetch_array($DN5);
			$DN6=mysql_query($Q." where n_p_kikd.nis='$PilNISTR' and n_k_kikd.nis='$PilNISTR' and n_utsuas.nis='$PilNISTR' and gmp_ngajar.semester='6' and gmp_ngajar.kd_mapel='{$HMapelA['kode_mapel']}'");
			$HN6=mysql_fetch_array($DN6);

			$jmlSmstrMapel=($HMapelA['semester1']+$HMapelA['semester2']+$HMapelA['semester3']+$HMapelA['semester4']+$HMapelA['semester5']+$HMapelA['semester6']);
			
			$R2A=round(($HN1['na']+$HN2['na']+$HN3['na']+$HN4['na']+$HN5['na']+$HN6['na'])/$jmlSmstrMapel);

			$RTMA=$RTMA+$R2A;
			
			$JmlA1=$JmlA1+$HN1['na'];
			$JmlA2=$JmlA2+$HN2['na'];
			$JmlA3=$JmlA3+$HN3['na'];
			$JmlA4=$JmlA4+$HN4['na'];
			$JmlA5=$JmlA5+$HN5['na'];
			$JmlA6=$JmlA6+$HN6['na'];
			
			$DNUN=mysql_query("select * from n_t_un where nis='$PilNISTR' and kode_mapel='{$HMapelA['kode_mapel']}'");
			$HNUN=mysql_fetch_array($DNUN);
			if($HNUN['nun']==0){$NilUN="";}else{$NilUN=$HNUN['nun'];}

			$DNUS=mysql_query("select * from n_t_us where nis='$PilNISTR' and kode_mapel='{$HMapelA['kode_mapel']}'");
			$HNUS=mysql_fetch_array($DNUS);
			if($HNUS['nust']==0){$NilUST="";}else{$NilUST=$HNUS['nust'];}

			/// NILAI PRAKTEK

			$QNUSPS1=mysql_query("
			select 
			gmp_ngajar.id_ngajar,
			gmp_ngajar.kd_pk,
			gmp_ngajar.kd_mapel,
			n_k_kikd.nis,
			n_k_kikd.kikd_k
			from gmp_ngajar
			inner join n_k_kikd on gmp_ngajar.id_ngajar=n_k_kikd.kd_ngajar 
			where n_k_kikd.nis='$PilNISTR' 
			and gmp_ngajar.semester='1'
			and gmp_ngajar.kd_mapel='{$HMapelA['kode_mapel']}'");
			$HNUSPS1=mysql_fetch_array($QNUSPS1);

			$QNUSPS2=mysql_query("
			select 
			gmp_ngajar.id_ngajar,
			gmp_ngajar.kd_pk,
			gmp_ngajar.kd_mapel,
			n_k_kikd.nis,
			n_k_kikd.kikd_k
			from gmp_ngajar
			inner join n_k_kikd on gmp_ngajar.id_ngajar=n_k_kikd.kd_ngajar 
			where n_k_kikd.nis='$PilNISTR' 
			and gmp_ngajar.semester='2'
			and gmp_ngajar.kd_mapel='{$HMapelA['kode_mapel']}'");
			$HNUSPS2=mysql_fetch_array($QNUSPS2);
			
			if($HNUS['nust']==0){$NilUSP="";}else{$NilUSP=round(($HNUSPS1['kikd_k']+$HNUSPS2['kikd_k'])/2);}
			

			/// NILAI PORTOFOLIO
			$QNUSFS1=mysql_query("
			select 
			gmp_ngajar.id_ngajar,
			gmp_ngajar.kd_pk,
			gmp_ngajar.kd_mapel,
			n_p_kikd.nis,
			n_p_kikd.kikd_p
			from gmp_ngajar
			inner join n_p_kikd on gmp_ngajar.id_ngajar=n_p_kikd.kd_ngajar 
			where n_p_kikd.nis='$PilNISTR' 
			and gmp_ngajar.semester='5'
			and gmp_ngajar.kd_mapel='{$HMapelA['kode_mapel']}'");
			$HNUSFS1=mysql_fetch_array($QNUSFS1);

			$QNUSFS2=mysql_query("
			select 
			gmp_ngajar.id_ngajar,
			gmp_ngajar.kd_pk,
			gmp_ngajar.kd_mapel,
			n_p_kikd.nis,
			n_p_kikd.kikd_p
			from gmp_ngajar
			inner join n_p_kikd on gmp_ngajar.id_ngajar=n_p_kikd.kd_ngajar 
			where n_p_kikd.nis='$PilNISTR' 
			and gmp_ngajar.semester='6'
			and gmp_ngajar.kd_mapel='{$HMapelA['kode_mapel']}'");
			$HNUSFS2=mysql_fetch_array($QNUSFS2);

			if($HNUS['nust']==0){$NilUSF="";}else{$NilUSF=round(($HNUSFS1['kikd_p']+$HNUSFS2['kikd_p'])/2);}

			//if($HNUS['nusp']==0){$NilUSP="";}else{$NilUSP=$HNUS['nusp'];}
			
			if($HNUS['nusp']=="" && $HNUS['nust']=="")
			{	
				$NUSA="";
			}
			else
			{
				$NUSA=round((round($NilUST)+round($NilUSP)+round($NilUSF))/3);
			}
			
			$JNUSA=$JNUSA+$NUSA;

			$NilUNA=$NilUNA+$NilUN;

			$NUSTeoriA=$NUSTeoriA+$HNUS['nust'];
			$NUSPrakA=$NUSPrakA+$NilUSP;
			$NUSFortoA=$NUSFortoA+$NilUSF;
			//$NUSPrakA=$NUSPrakA+$HNUS['nusp'];


			//// BUAT NILAI LAIN-LAIN
			// Nilai Agama dan Akhlak
			$QNLain="select 
			gmp_ngajar.id_ngajar,
			gmp_ngajar.kd_pk,
			gmp_ngajar.kd_mapel,
			n_k_kikd.nis,
			n_k_kikd.kikd_k,
			ak_matapelajaran.nama_mapel 
			from gmp_ngajar
			inner join n_k_kikd on gmp_ngajar.id_ngajar=n_k_kikd.kd_ngajar 
			INNER JOIN ak_matapelajaran ON gmp_ngajar.kd_mapel=ak_matapelajaran.kode_mapel ";

			$QNilAkhlak2=mysql_query($QNLain." where n_k_kikd.nis='$PilNISTR' and gmp_ngajar.semester='2' and ak_matapelajaran.nama_mapel='Pendidikan Agama dan Budi Pekerti'");
			$HNilAkhlak2=mysql_fetch_array($QNilAkhlak2);
			$QNilAkhlak4=mysql_query($QNLain." where n_k_kikd.nis='$PilNISTR' and gmp_ngajar.semester='4' and ak_matapelajaran.nama_mapel='Pendidikan Agama dan Budi Pekerti'");
			$HNilAkhlak4=mysql_fetch_array($QNilAkhlak4);
			$QNilAkhlak6=mysql_query($QNLain." where n_k_kikd.nis='$PilNISTR' and gmp_ngajar.semester='6' and ak_matapelajaran.nama_mapel='Pendidikan Agama dan Budi Pekerti'");
			$HNilAkhlak6=mysql_fetch_array($QNilAkhlak6);

			$NilAkhlak=round(($HNilAkhlak2['kikd_k']+$HNilAkhlak4['kikd_k']+$HNilAkhlak6['kikd_k'])/3);

			$QNilEstetika2=mysql_query($QNLain." where n_k_kikd.nis='$PilNISTR' and gmp_ngajar.semester='2' and ak_matapelajaran.nama_mapel='Bahasa Indonesia'");
			$HNilEstetika2=mysql_fetch_array($QNilEstetika2);
			$QNilEstetika4=mysql_query($QNLain." where n_k_kikd.nis='$PilNISTR' and gmp_ngajar.semester='4' and ak_matapelajaran.nama_mapel='Bahasa Indonesia'");
			$HNilEstetika4=mysql_fetch_array($QNilEstetika4);
			$QNilEstetika6=mysql_query($QNLain." where n_k_kikd.nis='$PilNISTR' and gmp_ngajar.semester='6' and ak_matapelajaran.nama_mapel='Bahasa Indonesia'");
			$HNilEstetika6=mysql_fetch_array($QNilEstetika6);

			$NilEstetika=round(($HNilEstetika2['kikd_k']+$HNilEstetika4['kikd_k']+$HNilEstetika6['kikd_k'])/3);

	
			$QNilKewarganegaraan2=mysql_query($QNLain." where n_k_kikd.nis='$PilNISTR' and gmp_ngajar.semester='2' and ak_matapelajaran.nama_mapel='Pendidikan Pancasila dan Kewarganegaraan'");
			$HNilKewarganegaraan2=mysql_fetch_array($QNilKewarganegaraan2);
			$QNilKewarganegaraan4=mysql_query($QNLain." where n_k_kikd.nis='$PilNISTR' and gmp_ngajar.semester='4' and ak_matapelajaran.nama_mapel='Pendidikan Pancasila dan Kewarganegaraan'");
			$HNilKewarganegaraan4=mysql_fetch_array($QNilKewarganegaraan4);
			$QNilKewarganegaraan6=mysql_query($QNLain." where n_k_kikd.nis='$PilNISTR' and gmp_ngajar.semester='6' and ak_matapelajaran.nama_mapel='Pendidikan Pancasila dan Kewarganegaraan'");
			$HNilKewarganegaraan6=mysql_fetch_array($QNilKewarganegaraan6);

			$NilKewarganegaraan=round(($HNilKewarganegaraan2['kikd_k']+$HNilKewarganegaraan4['kikd_k']+$HNilKewarganegaraan6['kikd_k'])/3);

			$QNilJasmaniDanKesehatan2=mysql_query($QNLain." where n_k_kikd.nis='$PilNISTR' and gmp_ngajar.semester='2' and ak_matapelajaran.nama_mapel='Pendidikan Pancasila dan Kewarganegaraan'");
			$HNilJasmaniDanKesehatan2=mysql_fetch_array($QNilJasmaniDanKesehatan2);
			$QNilJasmaniDanKesehatan4=mysql_query($QNLain." where n_k_kikd.nis='$PilNISTR' and gmp_ngajar.semester='4' and ak_matapelajaran.nama_mapel='Pendidikan Pancasila dan Kewarganegaraan'");
			$HNilJasmaniDanKesehatan4=mysql_fetch_array($QNilJasmaniDanKesehatan4);
			$QNilJasmaniDanKesehatan6=mysql_query($QNLain." where n_k_kikd.nis='$PilNISTR' and gmp_ngajar.semester='6' and ak_matapelajaran.nama_mapel='Pendidikan Pancasila dan Kewarganegaraan'");
			$HNilJasmaniDanKesehatan6=mysql_fetch_array($QNilJasmaniDanKesehatan6);

			$NilJasmaniDanKesehatan=round(($HNilJasmaniDanKesehatan2['kikd_k']+$HNilJasmaniDanKesehatan4['kikd_k']+$HNilJasmaniDanKesehatan6['kikd_k'])/3);

			$MapelA.="
			<tr>
				<td align='center'>$NoMapelA</td>
				<td>&nbsp;{$HMapelA['nama_mapel']}</td>
				<td align='center'>{$HN1['na']}</td>
				<td align='center'>{$HN2['na']}</td>
				<td align='center'>{$HN3['na']}</td>
				<td align='center'>{$HN4['na']}</td>
				<td align='center'>{$HN5['na']}</td>
				<td align='center'>{$HN6['na']}</td>
				<td align='center'>$R2A</td>
				<td align='center'>$NilUSF</td>
				<td align='center'>$NilUSP</td>
				<td align='center'>$NilUST</td>
				<td align='center'>$NUSA</td>
			</tr>";
			$NoMapelA++;
		}

	//== NILAI KELOMPOK B
		$DMapelB=mysql_query("select * from ak_matapelajaran where kode_pk='$PilPKCetakTR' and kelompok='B'");
		$MapelB.="<tr><td colspan='13'>&nbsp;&nbsp;<strong>Kelompok B (Wajib)</strong></td></tr>";

		$NoMapelB=($NoMapelA+1)-1;
		while($HMapelB=mysql_fetch_array($DMapelB)){
			$DN1=mysql_query($Q." where n_p_kikd.nis='$PilNISTR' and n_k_kikd.nis='$PilNISTR' and n_utsuas.nis='$PilNISTR' and gmp_ngajar.semester='1' and gmp_ngajar.kd_mapel='{$HMapelB['kode_mapel']}'");
			$HN1=mysql_fetch_array($DN1);
			$DN2=mysql_query($Q." where n_p_kikd.nis='$PilNISTR' and n_k_kikd.nis='$PilNISTR' and n_utsuas.nis='$PilNISTR' and gmp_ngajar.semester='2' and gmp_ngajar.kd_mapel='{$HMapelB['kode_mapel']}'");
			$HN2=mysql_fetch_array($DN2);
			$DN3=mysql_query($Q." where n_p_kikd.nis='$PilNISTR' and n_k_kikd.nis='$PilNISTR' and n_utsuas.nis='$PilNISTR' and gmp_ngajar.semester='3' and gmp_ngajar.kd_mapel='{$HMapelB['kode_mapel']}'");
			$HN3=mysql_fetch_array($DN3);
			$DN4=mysql_query($Q." where n_p_kikd.nis='$PilNISTR' and n_k_kikd.nis='$PilNISTR' and n_utsuas.nis='$PilNISTR' and gmp_ngajar.semester='4' and gmp_ngajar.kd_mapel='{$HMapelB['kode_mapel']}'");
			$HN4=mysql_fetch_array($DN4);
			$DN5=mysql_query($Q." where n_p_kikd.nis='$PilNISTR' and n_k_kikd.nis='$PilNISTR' and n_utsuas.nis='$PilNISTR' and gmp_ngajar.semester='5' and gmp_ngajar.kd_mapel='{$HMapelB['kode_mapel']}'");
			$HN5=mysql_fetch_array($DN5);
			$DN6=mysql_query($Q." where n_p_kikd.nis='$PilNISTR' and n_k_kikd.nis='$PilNISTR' and n_utsuas.nis='$PilNISTR' and gmp_ngajar.semester='6' and gmp_ngajar.kd_mapel='{$HMapelB['kode_mapel']}'");
			$HN6=mysql_fetch_array($DN6);

			$jmlSmstrMapel=($HMapelB['semester1']+$HMapelB['semester2']+$HMapelB['semester3']+$HMapelB['semester4']+$HMapelB['semester5']+$HMapelB['semester6']);
			
			$R2B=round(($HN1['na']+$HN2['na']+$HN3['na']+$HN4['na']+$HN5['na']+$HN6['na'])/$jmlSmstrMapel);

			$RTMB=$RTMB+$R2B;

			$JmlA1=$JmlA1+$HN1['na'];
			$JmlA2=$JmlA2+$HN2['na'];
			$JmlA3=$JmlA3+$HN3['na'];
			$JmlA4=$JmlA4+$HN4['na'];
			$JmlA5=$JmlA5+$HN5['na'];
			$JmlA6=$JmlA6+$HN6['na'];

			$DNUNB=mysql_query("select * from n_t_un where nis='$PilNISTR' and kode_mapel='{$HMapelB['kode_mapel']}'");
			$HNUNB=mysql_fetch_array($DNUNB);
			if($HNUNB['nun']==0){$NilUNB="";}else{$NilUNB=$HNUNB['nun'];}

			$DNUSB=mysql_query("select * from n_t_us where nis='$PilNISTR' and kode_mapel='{$HMapelB['kode_mapel']}'");
			$HNUSB=mysql_fetch_array($DNUSB);
			if($HNUSB['nust']==0){$NilUSTB="";}else{$NilUSTB=$HNUSB['nust'];}
			if($HNUSB['nusp']==0){$NilUSPB="";}else{$NilUSPB=$HNUSB['nusp'];}

			if($HNUSB['nusp']=="" && $HNUSB['nust']=="")
			{	
				$NUSB="";
			}
			else if($HNUSB['nusp']==0){
				$NUSB=round(($R2B*70)/100)+round(($HNUSB['nust']*30)/100);
			}else
			{
				$NUSB=round(($R2B*70)/100)+round(((($HNUSB['nust']+$HNUSB['nusp'])/2)*30)/100);
			}

			$JNUSB=$JNUSB+$NUSB;

			$NUSTeoriB=$NUSTeoriB+$HNUSB['nust'];
			$NUSPrakB=$NUSPrakB+$HNUSB['nusp'];

			$MapelB.="
			<tr>
				<td align='center'>$NoMapelB</td>
				<td>&nbsp;{$HMapelB['nama_mapel']}</td>
				<td align='center'>{$HN1['na']}</td>
				<td align='center'>{$HN2['na']}</td>
				<td align='center'>{$HN3['na']}</td>
				<td align='center'>{$HN4['na']}</td>
				<td align='center'>{$HN5['na']}</td>
				<td align='center'>{$HN6['na']}</td>
				<td align='center'>$R2B</td>
				<td align='center'></td>
				<td align='center'>$NilUSPB</td>
				<td align='center'>$NilUSTB</td>
				<td align='center'>$NUSB</td>
			</tr>";
			$NoMapelB++;
		}

	//== NILAI KELOMPOK C1
		$DMapelC1=mysql_query("select * from ak_matapelajaran where kode_pk='$PilPKCetakTR' and kelompok='C1'");
		$MapelC1.="<tr><td colspan='13'>&nbsp;&nbsp;<strong>Kelompok C (Peminatan)</strong></td></tr>";
		$MapelC1.="<tr><td colspan='13'>&nbsp;&nbsp;<strong>C1 Dasar Bidang Keahlian {$HBidA['nama_bidang']}</strong></td></tr>";

		$NoMapelC1=($NoMapelB+1)-1;
		while($HMapelC1=mysql_fetch_array($DMapelC1)){
			
			$DN1=mysql_query($Q." where n_p_kikd.nis='$PilNISTR' and n_k_kikd.nis='$PilNISTR' and n_utsuas.nis='$PilNISTR' and gmp_ngajar.semester='1' and gmp_ngajar.kd_mapel='{$HMapelC1['kode_mapel']}'");
			$HN1=mysql_fetch_array($DN1);
			$DN2=mysql_query($Q." where n_p_kikd.nis='$PilNISTR' and n_k_kikd.nis='$PilNISTR' and n_utsuas.nis='$PilNISTR' and gmp_ngajar.semester='2' and gmp_ngajar.kd_mapel='{$HMapelC1['kode_mapel']}'");
			$HN2=mysql_fetch_array($DN2);
			$DN3=mysql_query($Q." where n_p_kikd.nis='$PilNISTR' and n_k_kikd.nis='$PilNISTR' and n_utsuas.nis='$PilNISTR' and gmp_ngajar.semester='3' and gmp_ngajar.kd_mapel='{$HMapelC1['kode_mapel']}'");
			$HN3=mysql_fetch_array($DN3);
			$DN4=mysql_query($Q." where n_p_kikd.nis='$PilNISTR' and n_k_kikd.nis='$PilNISTR' and n_utsuas.nis='$PilNISTR' and gmp_ngajar.semester='4' and gmp_ngajar.kd_mapel='{$HMapelC1['kode_mapel']}'");
			$HN4=mysql_fetch_array($DN4);
			$DN5=mysql_query($Q." where n_p_kikd.nis='$PilNISTR' and n_k_kikd.nis='$PilNISTR' and n_utsuas.nis='$PilNISTR' and gmp_ngajar.semester='5' and gmp_ngajar.kd_mapel='{$HMapelC1['kode_mapel']}'");
			$HN5=mysql_fetch_array($DN5);
			$DN6=mysql_query($Q." where n_p_kikd.nis='$PilNISTR' and n_k_kikd.nis='$PilNISTR' and n_utsuas.nis='$PilNISTR' and gmp_ngajar.semester='6' and gmp_ngajar.kd_mapel='{$HMapelC1['kode_mapel']}'");
			$HN6=mysql_fetch_array($DN6);

			$jmlSmstrMapel=($HMapelC1['semester1']+$HMapelC1['semester2']+$HMapelC1['semester3']+$HMapelC1['semester4']+$HMapelC1['semester5']+$HMapelC1['semester6']);
			$R2C1=round(($HN1['na']+$HN2['na']+$HN3['na']+$HN4['na']+$HN5['na']+$HN6['na'])/$jmlSmstrMapel);

			$RTMC1=$RTMC1+$R2C1;
			
			$JmlC1=JmlDt("SELECT * FROM ak_matapelajaran WHERE kode_pk='17733' AND kelompok='C1'");
			$NSDKomp=round($RTMC1/$JmlC1);

			$JmlA1=$JmlA1+$HN1['na'];
			$JmlA2=$JmlA2+$HN2['na'];
			$JmlA3=$JmlA3+$HN3['na'];
			$JmlA4=$JmlA4+$HN4['na'];
			$JmlA5=$JmlA5+$HN5['na'];
			$JmlA6=$JmlA6+$HN6['na'];

			$DNUSC1=mysql_query("select * from n_t_us where nis='$PilNISTR' and kode_mapel='{$HMapelC1['kode_mapel']}'");
			$HNUSC1=mysql_fetch_array($DNUSC1);
			if($HNUSC1['nust']==0){$NilUSTC1="";}else{$NilUSTC1=$HNUSC1['nust'];}
			if($HNUSC1['nusp']==0){$NilUSPC1="";}else{$NilUSPC1=$HNUSC1['nusp'];}

			if($HNUSC1['nusp']=="" && $HNUSC1['nust']=="")
			{	
				$NUSC1="";
			}
			else if($HNUSC1['nusp']==0){
				$NUSC1=round(($R2C1*70)/100)+round(($HNUSC1['nust']*30)/100);
			}else
			{
				$NUSC1=round(($R2C1*70)/100)+round(((($HNUSC1['nust']+$HNUSC1['nusp'])/2)*30)/100);
			}

			$JNUSC1=$JNUSC1+$NUSC1;
			
			$NUSTeoriC=$NUSTeoriC+$HNUSC1['nust'];
			$NUSPrakC=$NUSPrakC+$HNUSC1['nusp'];

			$MapelC1.="
			<tr>
				<td align='center'>$NoMapelC1</td>
				<td>&nbsp;{$HMapelC1['nama_mapel']}</td>
				<td align='center'>{$HN1['na']}</td>
				<td align='center'>{$HN2['na']}</td>
				<td align='center'>{$HN3['na']}</td>
				<td align='center'>{$HN4['na']}</td>
				<td align='center'>{$HN5['na']}</td>
				<td align='center'>{$HN6['na']}</td>
				<td align='center'>$R2C1</td>
				<td align='center'></td>
				<td align='center'>$NilUSPC1</td>
				<td align='center'>$NilUSTC1</td>
				<td align='center'>$NUSC1</td>
			</tr>";
			$NoMapelC1++;
		}

	//== NILAI KELOMPOK C2
		$DMapelC2=mysql_query("select * from ak_matapelajaran where kode_pk='$PilPKCetakTR' and kelompok='C2'");
		$MapelC2.="<tr><td colspan='13'>&nbsp;&nbsp;<strong>C2 Dasar Program Keahlian {$HProgK['nama_program']}</strong></td></tr>";
		$JmlMapelDPK=JmlDt("select * from ak_matapelajaran where kode_pk='$PilPKCetakTR' and kelompok='C2'");

		$NoMapelC2=($NoMapelC1+1)-1;
		while($HMapelC2=mysql_fetch_array($DMapelC2)){
			
			$DN1=mysql_query($Q." where n_p_kikd.nis='$PilNISTR' and n_k_kikd.nis='$PilNISTR' and n_utsuas.nis='$PilNISTR' and gmp_ngajar.semester='1' and gmp_ngajar.kd_mapel='{$HMapelC2['kode_mapel']}'");
			$HN1=mysql_fetch_array($DN1);
			$DN2=mysql_query($Q." where n_p_kikd.nis='$PilNISTR' and n_k_kikd.nis='$PilNISTR' and n_utsuas.nis='$PilNISTR' and gmp_ngajar.semester='2' and gmp_ngajar.kd_mapel='{$HMapelC2['kode_mapel']}'");
			$HN2=mysql_fetch_array($DN2);
			$DN3=mysql_query($Q." where n_p_kikd.nis='$PilNISTR' and n_k_kikd.nis='$PilNISTR' and n_utsuas.nis='$PilNISTR' and gmp_ngajar.semester='3' and gmp_ngajar.kd_mapel='{$HMapelC2['kode_mapel']}'");
			$HN3=mysql_fetch_array($DN3);
			$DN4=mysql_query($Q." where n_p_kikd.nis='$PilNISTR' and n_k_kikd.nis='$PilNISTR' and n_utsuas.nis='$PilNISTR' and gmp_ngajar.semester='4' and gmp_ngajar.kd_mapel='{$HMapelC2['kode_mapel']}'");
			$HN4=mysql_fetch_array($DN4);
			$DN5=mysql_query($Q." where n_p_kikd.nis='$PilNISTR' and n_k_kikd.nis='$PilNISTR' and n_utsuas.nis='$PilNISTR' and gmp_ngajar.semester='5' and gmp_ngajar.kd_mapel='{$HMapelC2['kode_mapel']}'");
			$HN5=mysql_fetch_array($DN5);
			$DN6=mysql_query($Q." where n_p_kikd.nis='$PilNISTR' and n_k_kikd.nis='$PilNISTR' and n_utsuas.nis='$PilNISTR' and gmp_ngajar.semester='6' and gmp_ngajar.kd_mapel='{$HMapelC2['kode_mapel']}'");
			$HN6=mysql_fetch_array($DN6);

			$jmlSmstrMapel=($HMapelC2['semester1']+$HMapelC2['semester2']+$HMapelC2['semester3']+$HMapelC2['semester4']+$HMapelC2['semester5']+$HMapelC2['semester6']);
			
			$R2C2=round(($HN1['na']+$HN2['na']+$HN3['na']+$HN4['na']+$HN5['na']+$HN6['na'])/$jmlSmstrMapel);

			$RTMC2=$RTMC2+$R2C2;

			$JmlA1=$JmlA1+$HN1['na'];
			$JmlA2=$JmlA2+$HN2['na'];
			$JmlA3=$JmlA3+$HN3['na'];
			$JmlA4=$JmlA4+$HN4['na'];
			$JmlA5=$JmlA5+$HN5['na'];
			$JmlA6=$JmlA6+$HN6['na'];

			$NRDPK=$NRDPK+$R2C2;
			$RDPK=round($NRDPK/$JmlMapelDPK);

			$NDPK=mysql_query("select * from n_t_dpk where nis='$PilNISTR'");
			$HNDPK=mysql_fetch_array($NDPK);
			$US_DPK=$HNDPK['ndpk'];
			$SDPK=round((($RDPK*70)/100)+(($US_DPK*30)/100));
					
			$MapelC2.="
			<tr>
				<td align='center'>$NoMapelC2</td>
				<td>&nbsp;{$HMapelC2['nama_mapel']}</td>
				<td align='center'>{$HN1['na']}</td>
				<td align='center'>{$HN2['na']}</td>
				<td align='center'>{$HN3['na']}</td>
				<td align='center'>{$HN4['na']}</td>
				<td align='center'>{$HN5['na']}</td>
				<td align='center'>{$HN6['na']}</td>
				<td align='center'>$R2C2</td>
				<td align='center'></td>
				<td align='center'></td>
				<td align='center'></td>
				<td align='center'></td>
			</tr>";
			$NoMapelC2++;
		}

	//== NILAI KELOMPOK C3
		$DMapelC3=mysql_query("select * from ak_matapelajaran where kode_pk='$PilPKCetakTR' and kelompok='C3'");
		$MapelC3.="<tr><td colspan='13'>&nbsp;&nbsp;<strong>C3 Kompetensi Keahlian {$HPK['nama_paket']}</strong></td></tr>";
		$JmlMapelPK=JmlDt("select * from ak_matapelajaran where kode_pk='$PilPKCetakTR' and kelompok='C3'");

		$NoMapelC3=($NoMapelC2+1)-1;
		while($HMapelC3=mysql_fetch_array($DMapelC3)){

			$DN1=mysql_query($Q." where n_p_kikd.nis='$PilNISTR' and n_k_kikd.nis='$PilNISTR' and n_utsuas.nis='$PilNISTR' and gmp_ngajar.semester='1' and gmp_ngajar.kd_mapel='{$HMapelC3['kode_mapel']}'");
			$HN1=mysql_fetch_array($DN1);
			$DN2=mysql_query($Q." where n_p_kikd.nis='$PilNISTR' and n_k_kikd.nis='$PilNISTR' and n_utsuas.nis='$PilNISTR' and gmp_ngajar.semester='2' and gmp_ngajar.kd_mapel='{$HMapelC3['kode_mapel']}'");
			$HN2=mysql_fetch_array($DN2);
			$DN3=mysql_query($Q." where n_p_kikd.nis='$PilNISTR' and n_k_kikd.nis='$PilNISTR' and n_utsuas.nis='$PilNISTR' and gmp_ngajar.semester='3' and gmp_ngajar.kd_mapel='{$HMapelC3['kode_mapel']}'");
			$HN3=mysql_fetch_array($DN3);
			$DN4=mysql_query($Q." where n_p_kikd.nis='$PilNISTR' and n_k_kikd.nis='$PilNISTR' and n_utsuas.nis='$PilNISTR' and gmp_ngajar.semester='4' and gmp_ngajar.kd_mapel='{$HMapelC3['kode_mapel']}'");
			$HN4=mysql_fetch_array($DN4);
			$DN5=mysql_query($Q." where n_p_kikd.nis='$PilNISTR' and n_k_kikd.nis='$PilNISTR' and n_utsuas.nis='$PilNISTR' and gmp_ngajar.semester='5' and gmp_ngajar.kd_mapel='{$HMapelC3['kode_mapel']}'");
			$HN5=mysql_fetch_array($DN5);
			$DN6=mysql_query($Q." where n_p_kikd.nis='$PilNISTR' and n_k_kikd.nis='$PilNISTR' and n_utsuas.nis='$PilNISTR' and gmp_ngajar.semester='6' and gmp_ngajar.kd_mapel='{$HMapelC3['kode_mapel']}'");
			$HN6=mysql_fetch_array($DN6);

			$jmlSmstrMapel=($HMapelC3['semester1']+$HMapelC3['semester2']+$HMapelC3['semester3']+$HMapelC3['semester4']+$HMapelC3['semester5']+$HMapelC3['semester6']);
			
			$R2C3=round(($HN1['na']+$HN2['na']+$HN3['na']+$HN4['na']+$HN5['na']+$HN6['na'])/$jmlSmstrMapel);

			$RTMC3=$RTMC3+$R2C3;

			$JmlA1=$JmlA1+$HN1['na'];
			$JmlA2=$JmlA2+$HN2['na'];
			$JmlA3=$JmlA3+$HN3['na'];
			$JmlA4=$JmlA4+$HN4['na'];
			$JmlA5=$JmlA5+$HN5['na'];
			$JmlA6=$JmlA6+$HN6['na'];
					
			$NRPK=$NRPK+$R2C3;

			$RPK=round($NRPK/$JmlMapelPK);

			$NPK=mysql_query("select * from n_t_pk where nis='$PilNISTR'");
			$HNPK=mysql_fetch_array($NPK);
			$US_PK=$HNPK['npk'];
			
			$SPK=round((($RPK*70)/100)+(($US_PK*30)/100));

			$MapelC3.="
			<tr>
				<td align='center'>$NoMapelC3</td>
				<td>&nbsp;{$HMapelC3['nama_mapel']}</td>
				<td align='center'>{$HN1['na']}</td>
				<td align='center'>{$HN2['na']}</td>
				<td align='center'>{$HN3['na']}</td>
				<td align='center'>{$HN4['na']}</td>
				<td align='center'>{$HN5['na']}</td>
				<td align='center'>{$HN6['na']}</td>
				<td align='center'>$R2C3</td>
				<td align='center'></td>
				<td align='center'></td>
				<td align='center'></td>
				<td align='center'></td>
			</tr>";
			$NoMapelC3++;
		}

	//== NILAI KELOMPOK MUATAN LOKAL
		$DMapelM=mysql_query("select * from ak_matapelajaran where kode_pk='$PilPKCetakTR' and kelompok='M' and kelmapel!='M2'");
		$MapelM.="<tr><td colspan='13'>&nbsp;&nbsp;<strong>Mata Pelajaran Muatan Lokal</strong></td></tr>";

		$NoMapelM=($NoMapelC3+1)-1;
		while($HMapelM=mysql_fetch_array($DMapelM)){

			$DN1=mysql_query($Q." where n_p_kikd.nis='$PilNISTR' and n_k_kikd.nis='$PilNISTR' and n_utsuas.nis='$PilNISTR' and gmp_ngajar.semester='1' and gmp_ngajar.kd_mapel='{$HMapelM['kode_mapel']}'");
			$HN1=mysql_fetch_array($DN1);
			$DN2=mysql_query($Q." where n_p_kikd.nis='$PilNISTR' and n_k_kikd.nis='$PilNISTR' and n_utsuas.nis='$PilNISTR' and gmp_ngajar.semester='2' and gmp_ngajar.kd_mapel='{$HMapelM['kode_mapel']}'");
			$HN2=mysql_fetch_array($DN2);
			$DN3=mysql_query($Q." where n_p_kikd.nis='$PilNISTR' and n_k_kikd.nis='$PilNISTR' and n_utsuas.nis='$PilNISTR' and gmp_ngajar.semester='3' and gmp_ngajar.kd_mapel='{$HMapelM['kode_mapel']}'");
			$HN3=mysql_fetch_array($DN3);
			$DN4=mysql_query($Q." where n_p_kikd.nis='$PilNISTR' and n_k_kikd.nis='$PilNISTR' and n_utsuas.nis='$PilNISTR' and gmp_ngajar.semester='4' and gmp_ngajar.kd_mapel='{$HMapelM['kode_mapel']}'");
			$HN4=mysql_fetch_array($DN4);
			$DN5=mysql_query($Q." where n_p_kikd.nis='$PilNISTR' and n_k_kikd.nis='$PilNISTR' and n_utsuas.nis='$PilNISTR' and gmp_ngajar.semester='5' and gmp_ngajar.kd_mapel='{$HMapelM['kode_mapel']}'");
			$HN5=mysql_fetch_array($DN5);
			$DN6=mysql_query($Q." where n_p_kikd.nis='$PilNISTR' and n_k_kikd.nis='$PilNISTR' and n_utsuas.nis='$PilNISTR' and gmp_ngajar.semester='6' and gmp_ngajar.kd_mapel='{$HMapelM['kode_mapel']}'");
			$HN6=mysql_fetch_array($DN6);

			$jmlSmstrMapel=($HMapelM['semester1']+$HMapelM['semester2']+$HMapelM['semester3']+$HMapelM['semester4']+$HMapelM['semester5']+$HMapelM['semester6']);
			
			$R2M=round(($HN1['na']+$HN2['na']+$HN3['na']+$HN4['na']+$HN5['na']+$HN6['na'])/$jmlSmstrMapel);

			$RTMM=$RTMM+$R2M;

			$JmlA1=$JmlA1+$HN1['na'];
			$JmlA2=$JmlA2+$HN2['na'];
			$JmlA3=$JmlA3+$HN3['na'];
			$JmlA4=$JmlA4+$HN4['na'];
			$JmlA5=$JmlA5+$HN5['na'];
			$JmlA6=$JmlA6+$HN6['na'];

			$DNUSM=mysql_query("select * from n_t_us where nis='$PilNISTR' and kode_mapel='{$HMapelM['kode_mapel']}'");
			$HNUSM=mysql_fetch_array($DNUSM);
			if($HNUSM['nust']==0){$NilUSTM="";}else{$NilUSTM=$HNUSM['nust'];}
			if($HNUSM['nusp']==0){$NilUSPM="";}else{$NilUSPM=$HNUSM['nusp'];}
			
			if($HNUSM['nusp']=="" && $HNUSM['nust']=="")
			{	
				$NSM="";
			}
			else if($HNUSM['nusp']==0){
				$NSM=round(($R2M*70)/100)+round(($HNUSM['nust']*30)/100);
			}
			else
			{
				$NSM=round(($R2M*70)/100)+round(((($HNUSM['nust']+$HNUSM['nusp'])/2)*30)/100);
			}

			$NUSTeoriM=$NUSTeoriM+$HNUSM['nust'];
			$NUSPrakM=$NUSPrakM+$HNUSM['nusp'];
			
			$MapelM.="
			<tr>
				<td align='center'>$NoMapelM</td>
				<td>&nbsp;{$HMapelM['nama_mapel']}</td>
				<td align='center'>{$HN1['na']}</td>
				<td align='center'>{$HN2['na']}</td>
				<td align='center'>{$HN3['na']}</td>
				<td align='center'>{$HN4['na']}</td>
				<td align='center'>{$HN5['na']}</td>
				<td align='center'>{$HN6['na']}</td>
				<td align='center'>$R2M</td>
				<td align='center'></td>
				<td align='center'>$NilUSPM</td>
				<td align='center'>$NilUSTM</td>
				<td align='center'></td>
			</tr>";
			$NoMapelM++;
		}

	//== NILAI GABUNGAN NILAI


		$QDPK=mysql_query("select * from n_t_dpk where thnajaran='$PilTATR3' and kls='$PilKKLSTR3' and nis='$PilNISTR'");
		$HDPK=mysql_fetch_array($QDPK);

		$QUPK=mysql_query("select * from n_t_pk where thnajaran='$PilTATR3' and kls='$PilKKLSTR3' and nis='$PilNISTR'");
		$HUPK=mysql_fetch_array($QUPK);

		$QNPK=mysql_query("select * from n_t_un_pk where thnajaran='$PilTATR3' and kls='$PilKKLSTR3' and nis='$PilNISTR'");
		$HNPK=mysql_fetch_array($QNPK);

		$QNUK=mysql_query("select * from n_t_uk where thnajaran='$PilTATR3' and kls='$PilKKLSTR3' and nis='$PilNISTR'");
		$HNUK=mysql_fetch_array($QNUK);

		$MapelG.="<tr><td colspan='13'>&nbsp;&nbsp;<strong>Ujian Gabungan Mata Pelajaran</strong></td></tr>";

		$NoMapelG=($NoMapelM+1)-1;
		$NoMapelG1=($NoMapelG+1);
		$NoMapelG2=($NoMapelG1+1);
					
		$NSekDPK=round((($RDPK*70)/100)+(($NSDKomp*30)/100));


		$JmlMapelPKSemuanya=JmlDt("select * from ak_matapelajaran where kode_pk='$PilPKCetakTR'");
		$RTR222=round(($RTMA+$RTMB+$RTMC1+$RTMC2+$RTMC3+$RTMM)/($JmlMapelPKSemuanya-1));

		$SPK22=round((($RPK*70)/100)+(($RTR222*30)/100));

		$MapelG.="
		<tr>
			<td align='center'>$NoMapelG</td>
			<td>&nbsp;Dasar Paket Keahlian</td>
			<td align='center'></td>
			<td align='center'></td>
			<td align='center'></td>
			<td align='center'></td>
			<td align='center'></td>
			<td align='center'></td>
			<td align='center'>$RDPK</td>
			<td align='center'></td>
			<td align='center'></td>
			<td align='center'></td>
			<td align='center'>$NSekDPK</td>
		</tr>
		<tr>
			<td align='center'>$NoMapelG1</td>
			<td>&nbsp;Paket Keahlian</td>
			<td align='center'></td>
			<td align='center'></td>
			<td align='center'></td>
			<td align='center'></td>
			<td align='center'></td>
			<td align='center'></td>
			<td align='center'>$RPK</td>
			<td align='center'></td>
			<td align='center'></td>
			<td align='center'></td>
			<td align='center'>$SPK22</td>
		</tr>
		<tr>
			<td align='center'>$NoMapelG2</td>
			<td>&nbsp;Uji Kompetensi Keahlian (Passport Skill)</td>
			<td align='center'></td>
			<td align='center'></td>
			<td align='center'></td>
			<td align='center'></td>
			<td align='center'></td>
			<td align='center'></td>
			<td align='center'></td>
			<td align='center'></td>
			<td align='center'></td>
			<td align='center'></td>
			<td align='center'>".round($HNUK['nuk'])."</td>
		</tr>		
		";

	//== RATA-RATA HANDAP

		$JmlMapel1=JmlDt("select * from ak_matapelajaran where kode_pk='$PilPKCetakTR' and semester1='1'");
		$JmlMapel2=JmlDt("select * from ak_matapelajaran where kode_pk='$PilPKCetakTR' and semester2='1'");
		$JmlMapel3=JmlDt("select * from ak_matapelajaran where kode_pk='$PilPKCetakTR' and semester3='1'");
		$JmlMapel4=JmlDt("select * from ak_matapelajaran where kode_pk='$PilPKCetakTR' and semester4='1'");
		$JmlMapel5=JmlDt("select * from ak_matapelajaran where kode_pk='$PilPKCetakTR' and semester5='1'");
		$JmlMapel6=JmlDt("select * from ak_matapelajaran where kode_pk='$PilPKCetakTR' and semester6='1'");
		
		$JmlMapelS=JmlDt("select * from ak_matapelajaran where kode_pk='$PilPKCetakTR'");

		$R21=round(($JmlA1+$JmlB1+$JmlC11+$JmlC21+$JmlC31+$JmlM1)/$JmlMapel1);
		$R22=round(($JmlA2+$JmlB2+$JmlC12+$JmlC22+$JmlC32+$JmlM2)/$JmlMapel2);
		$R23=round(($JmlA3+$JmlB3+$JmlC13+$JmlC23+$JmlC33+$JmlM3)/$JmlMapel3);
		$R24=round(($JmlA4+$JmlB4+$JmlC14+$JmlC24+$JmlC34+$JmlM4)/$JmlMapel4);
		$R25=round(($JmlA5+$JmlB5+$JmlC15+$JmlC25+$JmlC35+$JmlM5)/$JmlMapel5);
		$R26=round(($JmlA6+$JmlB6+$JmlC16+$JmlC26+$JmlC36+$JmlM6)/$JmlMapel6);

		$RR2=round(($R21+$R22+$R23+$R24+$R25+$R26)/6);
		
		$RTR2=round(($RTMA+$RTMB+$RTMC1+$RTMC2+$RTMC3+$RTMM)/($JmlMapelS-1));
		
		$RTR23=round(($RTR2+$RDPK+$RPK)/3);

		$RNSKLH=round(($JNUSA+$JNUSB+$JNUSC1+$NSM+$NSekDPK+$SPK22+round($HNUK['nuk']))/8);

		//$RtUN=round((($NilUNA+$HNPK['nunpk']+$HNUK['nuk'])/5),2);

		$RtUSTeori=round((($NUSTeoriA+$NUSTeoriB+$NUSTeoriC+$NUSTeoriM+round($HUPK['npk'],0)+$HDPK['ndpk'])/5),0);
		$RtUSPraktek=round((($NUSPrakA+$NUSPrakB+$NUSPrakC+$NUSPrakM)/5),0);
		$RtUSFortofolio=round((($NUSFortoA)/5),0);


	//== DATA KEPSEK
		$QKS=mysql_query("select * from ak_kepsek where thnajaran='$PilTATR3' and smstr='Genap'");
		$HKS=mysql_fetch_array($QKS);
		$NamaKepsek=$HKS['nama'];
		$NIPKepsek=$HKS['nip'];

		$QDtT=mysql_query("select * from kur_dt_trans where thnajaran='$PilTATR3'");
		$HDtT=mysql_fetch_array($QDtT);

		$QPKL=mysql_query("select * from wk_prakerin where nis='$PilNISTR'");
		$HPKL=mysql_fetch_array($QPKL);
		if($HPKL['nis']==0){}else{
			$DtPrakerin="<br>Praktek Kerja Lapangan : <br>{$HPKL['perusahaan']} ({$HPKL['nilai']})<br>";}

	//== NILAI LAINNYA

		$QNL=mysql_query("select * from n_t_lainnya where nis='$PilNISTR'");
		$HNL=mysql_fetch_array($QNL);

		$QDNT=mysql_query("select * from ujian_usukk where nis='$PilNISTR'");
		$HDNT=mysql_fetch_array($QDNT);



	//== TAMPILKAN DI BROWSER
		$Show.='<script src="js/dist/html2pdf.bundle.js"></script>';		
		$Show.="<form name='formdtsis'>
			<input type='hidden' name='nisnasiswa' value='{$HDNT['nis']} {$HDNT['nm_siswa']}'>
			</form>";
		$Show.="
		<script>
		  function test() {
			// Get the element.
			var element = document.getElementById('Cetak');
			var noinsis=document.formdtsis.nisnasiswa.value;

			// Generate the PDF.
			html2pdf().from(element).set({
			  margin: 1,
			  filename: 'Trans '+noinsis+'.pdf',
			  html2canvas: { scale: 2 },
			  jsPDF: {orientation: 'portrait', unit: 'mm', format: 'a4', putOnlyUsedFonts:true, floatPrecision: 16, compressPDF: true}
			}).save();
		  }
		</script>";	
	
		$JsBarcode .="<form name='formtgl'>
		<input type='hidden' name='thn' value='$TahunLulus'>
		<input type='hidden' name='bln' value='{$PilNISTR}'>
		<input type='hidden' name='tgl' value='{$HDNT['nm_siswa']}'>
		</form>
		<img id=\"barcode3\"/>
		<script>
		var thnnya=document.formtgl.thn.value;
		var blnnya=document.formtgl.bln.value;
		var tglnya=document.formtgl.tgl.value;
		var tmpltgl=blnnya+'/'+tglnya+'/'+thnnya;

		JsBarcode(\"#barcode3\",tmpltgl, {
			format:\"code128\",
			displayValue:false,
			width:0.8,
			height:20,
			fontSize:20
		});
		</script>";

		$Show.="
		<script>
		function printContent(el){
			var restorepage=document.body.innerHTML;
			var printcontent=document.getElementById(el).innerHTML;
			document.body.innerHTML=printcontent;
			window.print();
			document.body.innerHTML=restorepage;
		}
		</script>";
		$Show.='
		<script src="js/plugin/jsbarcode/JsBarcode.all.min.js"></script>
		<script>
			Number.prototype.zeroPadding = function(){
				var ret = "" + this.valueOf();
				return ret.length == 1 ? "0" + ret : ret;
			};
		</script>';
	
		$IsiQrCode.="SMK Negeri 1 Kadipaten; Tahun Lulus : $TahunLulus; NIS : {$PilNISTR}; Nama : {$HDNT['nm_siswa']}";
		$QRCODE.="
		<input id='text212' type='hidden' value='$IsiQrCode' />
		<div id='qrcode212' style='width:100px; height:100px;'></div>

		<script type=\"text/javascript\">
		var qrcode = new QRCode(document.getElementById(\"qrcode212\"), {
			width : 100,
			height : 100
		});

		function makeCode () {		
			var elText = document.getElementById(\"text212\");
			
			if (!elText.value) {
				alert(\"Input a text\");
				elText.focus();
				return;
			}
			
			qrcode.makeCode(elText.value);
		}

		makeCode();

		$(\"#text212\").
			on(\"blur\", function () {
				makeCode();
			}).
			on(\"keydown\", function (e) {
				if (e.keyCode == 13) {
					makeCode();
				}
			});
		</script>";

		if($PilNISTR==""){ }
		else{
			$a=isset($_GET['a'])?$_GET['a']:""; 
			if($_GET['a']==""){
				if(file_exists("img/siswa2122/$PilNISTR.jpg")){
					$Photsis="<img src='img/siswa2122/$PilNISTR.jpg' class='img-miracle'  style='max-height:150px;max-width:150px;'>";
				}else{
					if($HFSiswa2['jenis_kelamin']=="Perempuan"){
						$Photsis="<img src='img/siswa2122/Perempuan.jpg' class='img-miracle'  style='max-height:150px;max-width:150px;'>";
					}else
					{
						$Photsis="<img src='img/siswa2122/Laki-laki.jpg' class='img-miracle'  style='max-height:150px;max-width:150px;'>";
					}
				}
				$Titimangsana="
					<td width='15' valign='top'><p>&nbsp;</p></td>
					<td width='100' valign='top' align='center'>$QRCODE</td>
					<td width='155' valign='top'>
						<table style='margin: 0 auto;width:75px;height:100px;border-collapse:collapse;font:12px Times New Roman;'>
						<tr>
							<td align='center'>$Photsis</td>
						</tr>
						</table>
					</td>
					<td width='15' valign='top'><p>&nbsp;</p></td>
					<td valign='top'><font size='3'>{$HDtT['alamat']}, ".TglLengkap($HDtT['tgl_terbit'])."<br>Kepala Sekolah, <br>
						<div><img src='img/ttdkepsek/nanabaru.png' border='0' height='95' width='225' style=' position: absolute; padding: 0px 2px 15px -250px; margin-left: -10px;margin-top:-15px;'></div>
						<div><img src='img/stempel.png' border='0' height='180' width='184' style=' position: absolute; padding: 0px 2px 15px -650px; margin-left: -75px;margin-top:-50px;'></div>
						<br><br><br><br> <strong>$NamaKepsek</strong><br>NIP. $NIPKepsek</font>
					</td>				
				";
	
			}else{
				$Titimangsana="
					<td width='15' valign='top'><p>&nbsp;</p></td>
					<td width='100' valign='top' align='center'>$QRCODE</td>
					<td width='155' valign='top'>
						<table style='margin: 0 auto;width:75px;height:100px;border-collapse:collapse;font:12px Times New Roman;'>
						<tr>
							<td align='center'> </td>
						</tr>
						</table>
					</td>
					<td width='15' valign='top'><p>&nbsp;</p></td>
					<td valign='top'><font size='3'>{$HDtT['alamat']}, ".TglLengkap($HDtT['tgl_terbit'])."<br>Kepala Sekolah, <br>
						 
						<br><br><br><br> <strong>$NamaKepsek</strong><br>NIP. $NIPKepsek</font>
					</td>				
				";					
			}

			$SisTmpLahir=strtolower($HDNT['tmplahir']);
			$SisTmpLahir2=ucfirst($SisTmpLahir);
			if($HDNT['jk']=='L'){$jksis="Laki-laki";}else {$jksis="Perempuan";}

			$Show.=KolomPanel("
			<table>
			<tr>
				<td width='250'>&nbsp;</td>
				<td>
					<div id='Cetak'>
						<img style=' position: absolute; padding: 250px 2px 15px -250px; margin-left: 250px;margin-top:415px;' src='img/logosmktrans.png' border='0' alt=''>
						<!-- KOP SURAT -->
						<table style='margin: 0 auto;width:100%;border-collapse:collapse;font:12px Times New Roman;'>
							<tr>
								<td colspan='2' align='center'><img src='img/kossurat2.jpg' width='811' height='174' border='0' alt=''></td>
							</tr>
							<tr>
								<td colspan='2' align='center'><font size='4'><br><strong>TRANSKRIP NILAI</strong></font></td>
							</tr>
							<tr>
								<td colspan=2>&nbsp;<td>
							</tr>
						</table>			
						<table style='margin: 0 auto;width:100%;border-collapse:collapse;font:12px Times New Roman;'>
							<tr>
								<td width='25'>&nbsp;</td>
								<td>
									<table style='margin: 0 auto;width:100%;border-collapse:collapse;font:12px Times New Roman;'>
										<tr>
											<td>NIS/NISN</td>
											<td>:</td>
											<td>$PilNISTR / {$HDNT['nisn']}</td>
											<td width='25'>&nbsp;</td>
											<td>Bidang Keahlian</td>
											<td>:</td>
											<td>{$HBidA['nama_bidang']}</td>
										</tr>
										<tr>
											<td>Nama Siswa</td>
											<td>:</td>
											<td>{$HDNT['nm_siswa']}</td>
											<td width='25'>&nbsp;</td>
											<td>Program Keahlian</td>
											<td>:</td>
											<td>{$HProgK['nama_program']}</td>
										</tr>
										<tr>
											<td>Tempat, Tanggal Lahir</td>
											<td>:</td>
											<td>{$SisTmpLahir2}, ".$HDNT['tgllahir']."</td>
											<td width='25'>&nbsp;</td>
											<td>Kompetensi Keahlian</td>
											<td>:</td>
											<td>{$HPK['nama_paket']}</td>
										</tr>
										<tr>
											<td>Jenis Kelamin</td>
											<td>:</td>
											<td>{$jksis}</td>
											<td width='25'>&nbsp;</td>
											<td>Tahun Lulus</td>
											<td>:</td>
											<td>{$TahunLulus}</td>
										</tr>
										<tr><td colspan='6'>&nbsp;</td></tr>
									</table>						
									<!-- TABEL TRANSKRIP -->
									<table style='margin: 0 auto;width:100%;border-collapse:collapse;font:12px Times New Roman;background: transparent;'border='1'>
										<tr>
											<td rowspan='2' align='center' width='15'><strong>NO.</strong></td>
											<td rowspan='2' width='45%' align='center'><strong>MATA PELAJARAN</strong></td>
											<td colspan='7' align='center'><strong>NILAI RAPORT PER SEMESTER</strong></td>
											<td colspan='4' align='center'><strong>UJIAN SEKOLAH</strong></td>
										</tr>
										<tr>
											<td width='25' align='center'><strong>1</strong></td>
											<td width='25' align='center'><strong>2</strong></td>
											<td width='25' align='center'><strong>3</strong></td>
											<td width='25' align='center'><strong>4</strong></td>
											<td width='25' align='center'><strong>5</strong></td>
											<td width='25' align='center'><strong>6</strong></td>
											<td width='25' align='center'><strong>R2</strong></td>
											<td width='25' align='center'><strong>US PF</strong></td>
											<td width='25' align='center'><strong>US P</strong></td>
											<td width='25' align='center'><strong>US T</strong></td>
											<td width='25' align='center'><strong>NA</strong></td>
										</tr>
										$MapelA
										$MapelB
										$MapelC1
										$MapelC2
										$MapelC3
										$MapelM
										$MapelG
										<tr>
											<td align='center' width='15'></td>
											<td width='35%' align='center'>Rata-Rata</td>
											<td width='25' align='center'><strong>$R21</strong></td>
											<td width='25' align='center'><strong>$R22</strong></td>
											<td width='25' align='center'><strong>$R23</strong></td>
											<td width='25' align='center'><strong>$R24</strong></td>
											<td width='25' align='center'><strong>$R25</strong></td>
											<td width='25' align='center'><strong>$R26</strong></td>
											<td width='25' align='center'><strong>$RTR23</strong></td>
											<td width='25' align='center'><strong>$RtUSFortofolio</strong></td>
											<td width='25' align='center'><strong>$RtUSPraktek</strong></td>
											<td width='25' align='center'><strong>$RtUSTeori</strong></td>
											<td width='25' align='center'><strong>$RNSKLH</strong></td>
										</tr>
									</table>
									<table style='margin: 0 auto;width:100%;border-collapse:collapse;font:12px Times New Roman;'>
										<tr><td><strong>*) </strong><em>Nilai di atas hasil pembulatan</em> </td></tr>
									</table>
								</td>
								<td width='25'>&nbsp;</td>
							</tr>
						</table>
						<!-- TITI MANGSA DAN NILAI LAIN -->					
						<table style='margin: 0 auto;width:100%;border-collapse:collapse;font:12px Times New Roman;'>
							<tr>
								<td width='25'>&nbsp;</td>
								<td>
									<table style='margin: 0 auto;width:100%;border-collapse:collapse;font:12px Times New Roman;'>
										<tr>
											<td width='200' valign='top'>
												$DtPrakerin<br>
												Penilaian Siswa Lainnya:
												<table>
												<tr>
													<td>1.</td>
													<td width='150'>Agama dan Akhlak Mulia</td>
													<td>$NilAkhlak</td>
												</tr>
												<tr>
													<td>2.</td>
													<td>Estetika</td>
													<td>$NilEstetika</td>
												</tr>
												<tr>
													<td>3.</td>
													<td>Kewarganegaraan</td>
													<td>$NilKewarganegaraan</td>
												</tr>
												<tr>
													<td>4.</td>
													<td>Jasmani dan Kesehatan</td>
													<td>$NilJasmaniDanKesehatan</td>
												</tr>
												</table>
											</td>
											$Titimangsana
										</tr>
									</table><br><br>
								</td>
								<td width='25'>&nbsp;</td>
							</tr>
						</table>
						<table style='margin: 0 auto;width:100%;border-collapse:collapse;font:11px Times New Roman;'>
							<tr>
								<td width='25'>&nbsp;</td>
								<td>Ket : US PF (Ujian Sekolah Portofolio), US P (Ujian Sekolah Praktek), US T (Ujian Sekolah Teori), NA (Nilai Akhir) </td>
								<td width='25'>&nbsp;</td>
							</tr>
						</table>
					</div>
				</td>
				<td width='250'>&nbsp;</td>
			</tr>
			</table>			
			");
		}
		echo IsiPanel($Show);
	break;

	case "updatenis":
		$nis=isset($_GET['nis'])?$_GET['nis']:"";
		mysql_query("update app_pilih_cetak_trans set nis='$nis' where id_pil='$IDna'");
		echo ns("Milih","parent.location='?page=$page'","Siswa dengan nis $nis");
	break;	
}
echo '</div>';
include("inc/footer.php");
include("inc/scripts.php");
//"))
?>