<?php
require_once("inc/init.php");
require_once("inc/config.ui.php");
$page_title = "Kompetesi Dasar Mapel";
$page_css[] = "your_style.css";
include("inc/header.php");
$page_nav["kbm"]["sub"]["kompetensidasar"]["active"] = true;
include("inc/nav.php");
echo "<div id='main' role='main'>";
$breadcrumbs["Proses KBM"] = "";
include("inc/ribbon.php");	
$sub=(isset($_GET['sub']))?$_GET['sub']:"";
switch($sub)
{ 
//===============[tampilan awal]
	case "tampil":default:
		
		$Q="select 
		gmp_ngajar.id_ngajar,
		gmp_ngajar.thnajaran,
		app_user_guru.nama_lengkap,
		ak_matapelajaran.nama_mapel,
		ak_kelas.kode_kelas,
		ak_kelas.nama_kelas,
		ak_kelas.tingkat,
		gmp_ngajar.jenismapel,
		gmp_ngajar.semester,
		gmp_ngajar.kkmpeng,
		gmp_ngajar.kkmket
		from gmp_ngajar 
		inner join app_user_guru on gmp_ngajar.kd_guru=app_user_guru.id_guru
		inner join ak_matapelajaran on gmp_ngajar.kd_mapel=ak_matapelajaran.kode_mapel
		inner join ak_kelas on gmp_ngajar.kd_kelas = ak_kelas.kode_kelas
		where gmp_ngajar.kd_guru='$IDna' and 
		gmp_ngajar.thnajaran='$TahunAjarAktif' and 
		gmp_ngajar.ganjilgenap='$SemesterAktif'";
		$ThnAjar="$TahunAjarAktif";
		$Smstr="$SemesterAktif";
		$MassaKBM="Tahun Ajaran $TahunAjarAktif Semester $SemesterAktif";
		
		$no=1;
		$Query=mysql_query("$Q order by gmp_ngajar.kd_mapel,ak_kelas.nama_kelas");
		while($Hasil=mysql_fetch_array($Query)){	
			
			$NamaGuru=$Hasil['nama_lengkap'];
			$NamaKelas=$Hasil['nama_kelas'];
			$IDNgajarna=$Hasil['id_ngajar'];
			$QDKomp=mysql_query("select kode_ngajar from gmp_kikd where kode_ngajar='$IDNgajarna'");
			$HDKomp=mysql_num_rows($QDKomp);
			if($HDKomp>0){
				$AdaTidakKD="<a href='?page=$page&sub=cekkikd&Kode={$Hasil['id_ngajar']}'><i class='fa fa-search fa-border fa-lg'></i></a>";
			}
			else{		

				$AdaTidakKD="<a href='?page=$page&sub=pilihkd&Kode={$Hasil['id_ngajar']}'><i class='fa fa-plus fa-border text-danger fa-lg'></i></a>";
			}
			$QDK="select 
			gmp_kikd.id_dk,
			ak_kikd.kode_ranah,
			ak_kikd.no_kikd,
			ak_kikd.isikikd,
			ak_matapelajaran.nama_mapel,
			ak_kelas.nama_kelas,
			ak_kelas.tingkat,
			app_user_guru.nama_lengkap
			from gmp_kikd
			inner join ak_kikd on gmp_kikd.kode_kikd=ak_kikd.id_kikd
			inner join gmp_ngajar on gmp_kikd.kode_ngajar=gmp_ngajar.id_ngajar 
			inner join ak_matapelajaran on gmp_ngajar.kd_mapel=ak_matapelajaran.kode_mapel
			inner join app_user_guru on gmp_ngajar.kd_guru=app_user_guru.id_guru
			inner join ak_kelas on gmp_ngajar.kd_kelas=ak_kelas.kode_kelas
			where gmp_kikd.kode_ngajar='$IDNgajarna'";
			$JDKS=JmlDt("$QDK and ak_kikd.kode_ranah='KDS'");
			$JDKP=JmlDt("$QDK and ak_kikd.kode_ranah='KDP'");
			$JDKK=JmlDt("$QDK and ak_kikd.kode_ranah='KDK'");

			$TampilData.="
			<tr>
				<td class='text-center'>$no.</td>
				<td>{$Hasil['nama_lengkap']}<br><span class='text-danger'>{$Hasil['nama_mapel']}</span></td>
				<td>{$Hasil['nama_kelas']}</td>
				<td><code>{$Hasil['kkmpeng']} {$Hasil['kkmket']}</code></td>
				<td><code>[$JDKS] [$JDKP] [$JDKK]</code></td>
				<td width='65' class='text-center'>$AdaTidakKD</td>
			</tr>";
			$no++;
		}


		$jmldata=mysql_num_rows($Query);
		if($jmldata>0){
			$Show.=Label($MassaKBM);
			$Show.="
			<div class='hidden-lg'><p><code>Silakan salin kikd di form bagaian bawah</code></p><hr></div>
			<div class='well no-padding'>
				<table id='dt_basic' class='table table-striped table-bordered table-hover table-condensed' width='100%'>
					<thead>
						<tr>
							<th class='text-center' data-class='expand'>No. </th>
							<th class='text-center'>Guru dan Mata Pelajaran</th>
							<th class='text-center' data-hide='phone,tablet'>Kelas</th>
							<th class='text-center' data-hide='phone,tablet'>KKM</th>
							<th class='text-center' data-hide='phone,tablet'>JML KIKD</th>
							<th class='text-center'>KIKD</th>
						</tr>
					</thead>
					<tbody>$TampilData</tbody>
				</table>
			</div>";
		}
		else{
			$Show.='<p class="text-center"><img src="img/aa.png" width="100" height="231" border="0" alt=""></p><h1 class="text-center"><small class="text-danger slideInRight fast animated"><strong>Data KBM Belum Ditambahkan, KI KD belum ada!</strong></small></h1>';
		}

		/// Salin kikd
		$QKBM1=mysql_query("$Q order by gmp_ngajar.kd_mapel,ak_kelas.nama_kelas");
		while($HKBM1=mysql_fetch_array($QKBM1)){
			$KDSna=JmlDt("select kode_ngajar,kode_ranah from gmp_kikd where kode_ngajar='".$HKBM1['id_ngajar']."' and kode_ranah='KDS'");
			$KDPna=JmlDt("select kode_ngajar,kode_ranah from gmp_kikd where kode_ngajar='".$HKBM1['id_ngajar']."' and kode_ranah='KDP'");
			$KDKna=JmlDt("select kode_ngajar,kode_ranah from gmp_kikd where kode_ngajar='".$HKBM1['id_ngajar']."' and kode_ranah='KDK'");
			
			if($KDSna==0 || $KDPna==0 || $KDKna==0){
				$BelumAda="[BELUM]";
			}
			else{
				$BelumAda="[ADA]";
			}

			$DtKelas1.="<option value={$HKBM1['id_ngajar']}>{$HKBM1['nama_kelas']} {$HKBM1['nama_mapel']} $BelumAda</option>";
		}
		
		$QKBM2=mysql_query("$Q order by gmp_ngajar.kd_mapel,ak_kelas.nama_kelas");
		
		while($HKBM2=mysql_fetch_array($QKBM2)){
			
			$KDSna=JmlDt("select kode_ngajar,kode_ranah from gmp_kikd where kode_ngajar='".$HKBM2['id_ngajar']."' and kode_ranah='KDS'");
			$KDPna=JmlDt("select kode_ngajar,kode_ranah from gmp_kikd where kode_ngajar='".$HKBM2['id_ngajar']."' and kode_ranah='KDP'");
			$KDKna=JmlDt("select kode_ngajar,kode_ranah from gmp_kikd where kode_ngajar='".$HKBM2['id_ngajar']."' and kode_ranah='KDK'");
			
			if($KDSna==0 || $KDPna==0 || $KDKna==0){
				$BelumAda="[BELUM]";
			}
			else{
				$BelumAda="[ADA]";
			}
			
			$DtKelas2.="<option value={$HKBM2['id_ngajar']}>{$HKBM2['nama_kelas']} {$HKBM2['nama_mapel']} $BelumAda</option>";
		}
		
		$SalinKIKD.=JudulKolom("Salin KIKD","exchange");
		$SalinKIKD.="
		<form action='?page=$page&sub=simpansalinkikd' method='post' name='FrmSalin' id='FrmSalin'  class='smart-form' role='form'>
			<fieldset>
				<section>
				<label class='label'>Pilih Kelas</label>
				<label class='select'>
					<select name='txtKBM1' class='input-sm form-control'>
					<option value=''>Pilih</option>
					$DtKelas1
					</select> <i></i> </label>
				</section>
				<section>
				<label class='label'>Pilih Kelas</label>
				<label class='select'>
					<select name='txtKBM2' class='input-sm form-control'>
					<option value=''>Pilih</option>
					$DtKelas2
					</select> <i></i> </label>
				</section>
			</fieldset>
			<div class='form-actions'>
				<input type='reset' class='btn btn-sm btn-danger' value='Kosongkan' style='margin-right:10px;'>". 
				bSubmit("BtnSalin","Salin KIKD")."
			</div>
		</form>";

		$Tampilkan=DuaKolomD(9,$Show,3,"<span class='hidden-lg'><hr class='special'></span>".KolomPanel($SalinKIKD));
		
		$tandamodal="#DataKIKDMapel";
		echo $DataKIKDMapel;
		echo MyWidget('fa-list',"KIKD Mata Pelajaran $NamaGuru","",$Tampilkan);
	break;
//===============[Simpan hasil salin KIKD]
	case "simpansalinkikd":

		$Q="select 
		gmp_ngajar.id_ngajar,
		gmp_ngajar.kd_kelas,
		gmp_ngajar.thnajaran,
		gmp_ngajar.semester,
		ak_kelas.nama_kelas,
		ak_kelas.tingkat,
		gmp_ngajar.kd_mapel,
		ak_matapelajaran.nama_mapel
		from gmp_ngajar 
		inner join app_user_guru on gmp_ngajar.kd_guru=app_user_guru.id_guru
		inner join ak_matapelajaran on gmp_ngajar.kd_mapel=ak_matapelajaran.kode_mapel
		inner join ak_kelas on gmp_ngajar.kd_kelas = ak_kelas.kode_kelas
		where gmp_ngajar.kd_guru='$IDna' and 
		gmp_ngajar.thnajaran='$TahunAjarAktif' and 
		gmp_ngajar.ganjilgenap='$SemesterAktif'";

		$message=array();
		$JmlKIKD=JmlDt("select * from gmp_kikd where kode_ngajar='".$_POST['txtKBM1']."'");
		$JmlKIKD2=JmlDt("select * from gmp_kikd where kode_ngajar='".$_POST['txtKBM2']."'");
		$JmlKIKD3=JmlDt("select * from gmp_kikd where kode_ngajar='".$_POST['txtKBM3']."'");
			
		$QKBMPil1=mysql_query("$Q and gmp_ngajar.id_ngajar='".$_POST['txtKBM1']."'");
		$HKBMPil1=mysql_fetch_array($QKBMPil1);
		$KelasPil1=$HKBMPil1['nama_kelas'];
		$TingkatPil1=$HKBMPil1['tingkat'];
		$NamaMapelPil1=$HKBMPil1['nama_mapel'];
		
		$QKBMPil2=mysql_query("$Q and gmp_ngajar.id_ngajar='".$_POST['txtKBM2']."'");
		$HKBMPil2=mysql_fetch_array($QKBMPil2);
		$KelasPil2=$HKBMPil2['nama_kelas'];
		$TingkatPil2=$HKBMPil2['tingkat'];
		$NamaMapelPil2=$HKBMPil2['nama_mapel'];
		
		
		if(trim($_POST['txtKBM1'])==""){$message[]="Mata Pelajaran yang akan disalin belum di pilih !";}
		if(trim($_POST['txtKBM2'])==""){$message[]="Mata Pelajaran tujuan di salin belum dipilih !";}
		if($JmlKIKD==0){$message[]="Mata Pelajaran belum memiliki KIKD !";}
		if($JmlKIKD2>=1){$message[]="Mata Pelajaran sudah memiliki KIKD !";}
		if($KelasPil1==$KelasPil2){$message[]="Kelas tidak boleh sama!";}
		if($NamaMapelPil1!=$NamaMapelPil2){$message[]="Mata Pelajaran harus sama!";}
		if($TingkatPil1!=$TingkatPil2){$message[]="Tingkat harus sama!";}
		if(!count($message)==0){
			$Num=0;
			foreach($message as $indeks=>$pesan_tampil){
				$Num++;
				$Pesannya.="$Num. $pesan_tampil<br>";
			} 
			echo Peringatan("$Pesannya","parent.location='?page=$page'");
		}
		else{
			$txtKBM1=addslashes($_POST['txtKBM1']);
			$txtKBM2=addslashes($_POST['txtKBM2']);

			$QKIKD=mysql_query("select * from gmp_kikd where kode_ngajar='$txtKBM1'");
			$i=1;
			while($HKIKD=mysql_fetch_array($QKIKD)){
				$kd_KIKD=buatKode("gmp_kikd","kikd_");
				mysql_query("INSERT INTO gmp_kikd VALUES ('$kd_KIKD','{$HKIKD['kode_ranah']}','{$HKIKD['kode_kikd']}','$txtKBM2','{$HKIKD['thnajar']}','{$HKIKD['smstr']}')");
				$i++;
			}
			echo ns("Salin","parent.location='?page=$page'","KIKD dengan Kode Ngajar <strong>$txtKBM1</strong>");
		}
	break;

//===============[Pilih KIKD]
	case "pilihkd":
		$KodeEdit=isset($_GET['Kode'])?$_GET['Kode']:""; 

		$QKD="
		select gmp_ngajar.id_ngajar,gmp_ngajar.thnajaran,gmp_ngajar.semester,gmp_ngajar.ganjilgenap,ak_kelas.nama_kelas,
		ak_kikd.nama_mapel,ak_kikd.id_kikd,ak_kikd.no_kikd,ak_kikd.isikikd from gmp_ngajar
		inner join ak_matapelajaran on gmp_ngajar.kd_mapel=ak_matapelajaran.kode_mapel 
		inner join ak_kikd on ak_matapelajaran.kelmapel=ak_kikd.kelompok and ak_matapelajaran.jenismapel=ak_kikd.jenismapel
		inner join ak_kelas on gmp_ngajar.kd_kelas=ak_kelas.kode_kelas and ak_kelas.tingkat=ak_kikd.tingkat
		where gmp_ngajar.id_ngajar='$KodeEdit'";
		$QKiKd=mysql_query($QKD);	
		$HKiKd=mysql_fetch_array($QKiKd);	
		//====================================[tampil Kompetensi Dasar Sikap]
		$QKDS=mysql_query($QKD." and ak_kikd.kode_ranah='KDS' order by ak_kikd.id_kikd");	
		$JKDS=mysql_num_rows($QKDS);
		$i=1;		
		while($HKDS=mysql_fetch_array($QKDS)){
			$IDNgajarna=$HKDS['id_ngajar'];
			$IDKIKD=$HKDS['id_kikd'];
			$NamaMapel=$HKDS['nama_mapel'];
			$Kelasna=$HKDS['nama_kelas'];
			$KDS.="
			<tr>
				<td>{$HKDS['no_kikd']}</td>
				<td>{$HKDS['isikikd']}</td>
				<td class='text-center'>
					<label class='checkbox'><input type='checkbox' checked name='txtKIKD[$i]'><i></i></label>
					<input type='hidden' name='txtKDRanah[$i]' value='KDS'>
					<input type='hidden' name='txtIDKIKD[$i]' value='".$HKDS['id_kikd']."'>
					<input type='hidden' name='txtKDNgajar[$i]' value='".$HKDS['id_ngajar']."'>
					<input type='hidden' name='txtTAjar[$i]' value='".$HKDS['thnajaran']."'>
					<input type='hidden' name='txtSmstr[$i]' value='".$HKDS['semester']."'>
				</td>
			</tr>";
			$i++;
		}
		$ShowKDS.="
		<fieldset>
			<table class='table'>
				<tr>
					<th width='35'>No.</th>
					<th class='text-center'>KI KD SIKAP</th>
					<th width='10%'>Pilih</th>
				</tr>
				$KDS
			</table>
		</fieldset>";
		//====================================[tampil Kompetensi Dasar Pengetahuan]
		$QKDP=mysql_query($QKD." and ak_kikd.kode_ranah='KDP' order by ak_kikd.id_kikd");
		$JKDP=mysql_num_rows($QKDP);
		$i=$JKDS+1;
		while($HKDP=mysql_fetch_array($QKDP)){
			$KDP.="
			<tr>
				<td>{$HKDP['no_kikd']}</td>
				<td>{$HKDP['isikikd']}</td>
				<td class='text-center'>
					<label class='checkbox'><input type='checkbox' name='txtKIKD[$i]'><i></i></label>
					<input type='hidden' name='txtKDRanah[$i]' value='KDP'>
					<input type='hidden' name='txtIDKIKD[$i]' value='".$HKDP['id_kikd']."'>
					<input type='hidden' name='txtKDNgajar[$i]' value='".$HKDP['id_ngajar']."'>
					<input type='hidden' name='txtTAjar[$i]' value='".$HKDP['thnajaran']."'>
					<input type='hidden' name='txtSmstr[$i]' value='".$HKDP['semester']."'>
				</td>
			</tr>";
			$i++;
		}
		$ShowKDP.="
		<fieldset>
			<table class='table'>
				<tr>
					<th width='35'>No.</th>
					<th class='text-center'>KI KD PENGETAHUAN</th>
					<th width='10%'>Pilih</th>
				</tr>
				$KDP
			</table>
		</fieldset>";
		//====================================[tampil Kompetensi Dasar Keterampilan]
		$QKDK=mysql_query($QKD." and ak_kikd.kode_ranah='KDK' order by ak_kikd.id_kikd");
		$JKDK=mysql_num_rows($QKDK);
		$i=$JKDS+$JKDP+1;
		while($HKDK=mysql_fetch_array($QKDK)){
			$KDK.="
			<tr>
				<td>{$HKDK['no_kikd']}</td>
				<td>{$HKDK['isikikd']}</td>
				<td class='text-center'>
					<label class='checkbox'><input type='checkbox' name='txtKIKD[$i]'><i></i></label>
					<input type='hidden' name='txtKDRanah[$i]' value='KDK'>
					<input type='hidden' name='txtIDKIKD[$i]' value='".$HKDK['id_kikd']."'>
					<input type='hidden' name='txtKDNgajar[$i]' value='".$HKDK['id_ngajar']."'>
					<input type='hidden' name='txtTAjar[$i]' value='".$HKDK['thnajaran']."'>
					<input type='hidden' name='txtSmstr[$i]' value='".$HKDK['semester']."'>
				</td>
			</tr>";
			$i++;
		}
		$ShowKDK.="
		<fieldset>
			<table class='table'>
				<tr>
					<th width='35'>No.</th>
					<th class='text-center'>KI KD KETERAMPILAN</th>
					<th width='10%'>Pilih</th>
				</tr>
				$KDK
			</table>
		</fieldset>";
		//====================================[tampilkan di browser]
		$ShowInfo.=FormInfoTabel("Mata Pelajaran",$NamaMapel,"1px");
		$ShowInfo.=FormInfoTabel("Kelas",$Kelasna,"1px");
		$Show.=ButtonKembali2("?page=$page","style='margin-top:-10px;'");
		$Show.=JudulKolom("Pilih KIKD","");
		$Show.=KotakWell("
		<dl class='dl-horizontal' style='margin-bottom:0px;'>
		  <dt>Tahun Pelajaran : </dt><dd>{$HKiKd['thnajaran']}</dd>
		  <dt>Semester : </dt><dd>{$HKiKd['semester']} ({$HKiKd['ganjilgenap']})</dd>
		  <dt>Mata Pelajaran : </dt><dd>$NamaMapel</dd>
		  <dt>Kelas : </dt><dd>$Kelasna</dd>
		</dl>","");
		$Show.="<form action='?page=$page&sub=savekikd' method='post' name='FrmUTSUAS' id='FrmUTSUAS' role='form' class='smart-form'>";
		$Show.=TigaKolomSama($ShowKDS,$ShowKDP,$ShowKDK);
		$Show.="<div class='form-actions'>".bSubmit("SaveTambah","Simpan")."</div>";
		$Show.="</form>";
		
		echo IsiPanel($Show);
		echo $PilihKIKDMapel;
		$tandamodal="#PilihKIKDMapel";
	break;

//===============[Simpan KIKD]
	case "savekikd":
		foreach($_POST['txtKIKD'] as $i => $txtKIKD){
			$txtKDRanah=$_POST['txtKDRanah'][$i];
			$txtIDKIKD=$_POST['txtIDKIKD'][$i];
			$txtKDNgajar=$_POST['txtKDNgajar'][$i];
			$txtTAjar=$_POST['txtTAjar'][$i];
			$txtSmstr=$_POST['txtSmstr'][$i];
			$kd_KIKD=buatKode("gmp_kikd","kikd_");
			mysql_query("INSERT INTO gmp_kikd VALUES ('$kd_KIKD','$txtKDRanah','$txtIDKIKD','$txtKDNgajar','$txtTAjar','$txtSmstr')");
			echo ns("Milih","parent.location='?page=$page'","KIKD dengan Kode Ngajar <strong>$txtKDNgajar</strong>");
		}
	break;

//===============[Check KIKD]
	case "cekkikd":
		$KodeEdit= isset($_GET['Kode'])?$_GET['Kode']:"";
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
			$ShowInfo.=KotakWell("
			<dl class='dl-horizontal' style='margin-bottom:0px;'>
			  <dt>Tahun Pelajaran : </dt><dd>$TA</dd>
			  <dt>Semester : </dt><dd>$SMST</dd>
			  <dt>Mata Pelajaran : </dt><dd> $NamaMapel</dd>
			  <dt>Kelas : </dt><dd>$Kelasna</dd>
			  <dt>Pengampu : </dt><dd>$NamaGuru</dd>
			</dl>","");
		}
	//==================KD SIKAP 
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
		
		if($JmlDataS>0){
			$ShowSikap.="<table class='table'>$TampilDataKDS</table>";
		}
		else{
			$ShowSikap.=nt("informasi","KIKD Sikap belum ada");
		}
		
	//==================KD PENGETAHUAN
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
		if($JmlDataP>0){
			$ShowPengetahuan.="<table class='table'>$TampilDataKDP</table>";
		}
		else{
			$ShowPengetahuan.=nt("informasi","KIKD Pengetahuan belum ada");}
	//==================KD KETERAMPILAN
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
		if($JmlDataK>0){
			$ShowKet.="<table class='table'>$TampilDataKDK</table>";
		}
		else{
			$ShowKet.=nt("informasi","KIKD Keterampilan belum ada");
		}
			
		$jmlNP=JmlDt("select * from n_p_kikd where kd_ngajar='$KodeEdit'");
		$jmlNK=JmlDt("select * from n_k_kikd where kd_ngajar='$KodeEdit'");
		if($jmlNP>0 || $jmlNK>0){
			if($_SESSION['SES_MASTER']=="Master"){
				$ActionKIKD="
				<div class='form-actions'>
					<a href='?page=$page&sub=hapusKIKD&kbm=$KodeEdit' data-action='delkikd' data-delkikd-msg=\"Apakah Anda yakin akan mengapus semua KIKD dengan Kode Ngajar <strong>$KodeEdit</strong>?\" class='btn btn-danger btn-sm'>Hapus</a>
				</div>";
				$Infona="Anda sudah Mengisi Nilai Pengetahuan (K3) atau Nilai Keterampilan (K4)<br> Jika ingin merubah data KIKD silakan hapus nilai Pengetahuan atau Nilai Keterampilan terlebih dahulu.";
			}
			else{
				$ActionKIKD="";
				$Infona="Anda sudah Mengisi Nilai Pengetahuan (K3) atau Nilai Keterampilan (K4)<br> Jika ingin merubah data KIKD silakan hapus nilai Pengetahuan atau Nilai Keterampilan terlebih dahulu.";
			}
		}
		else{
			$ActionKIKD.="
			<div class='form-actions'>
				<a href='?page=$page&sub=hapusKIKD&kbm=$KodeEdit' data-action='delkikd' data-delkikd-msg=\"Apakah Anda yakin akan mengapus semua KIKD Kode Ngajar <strong>$KodeEdit</strong>?\" class='btn btn-danger btn-sm'>Hapus</a>
			</div>";
			$Infona="Untuk merubah Pilihan KIKD silakan klik <strong>TOMBOL HAPUS</strong> dibagian bawah terlebih dahulu, kemudian ulangi pilih KIKD.";
		}
		if($jmlNP>0){
			$HpsDP="<a href='?page=$page&sub=hapusNP&kbm=$KodeEdit' data-action='hpsdp' data-hpsdp-msg=\"Apakah Anda yakin akan mengapus Nilai KIKD Pengetahuan Kode Ngajar <strong>$KodeEdit</strong>?\" class='btn btn-danger btn-sm pull-right' style='margin-top:-7px;margin-right:-15px;'>Hapus Nilai Pengetahuan</a>";
		}
		
		if($jmlNK>0){
			$HpsDK="<a href='?page=$page&sub=hapusNK&kbm=$KodeEdit' data-action='hpsdk' data-hpsdk-msg=\"Apakah Anda yakin akan mengapus Nilai KIKD Keterampilan Kode Ngajar <strong>$KodeEdit</strong>?\" class='btn btn-danger btn-sm pull-right' style='margin-top:-7px;margin-right:-15px;'>Hapus Nilai Keterampilan</a>";
		}
		
		$Show.=ButtonKembali2("?page=$page","style='margin-top:-8px;'");
		$Show.=JudulKolom("Detail KIKD Terpilih","");
		$Show.=$ShowInfo;
		$Show.=nt("peringatan",$Infona);
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
							<li>".$HpsDP."</li>
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
							<li>".$HpsDK."</li>
						</ul>
					</div>
				</div>
			</div>
		</div>";
		$Show.=$ActionKIKD;
		$tandamodal="#CekKIKDMapel";
		echo $CekKIKDMapel;
		echo IsiPanel($Show);
	break;

//===============[Hapus KIKD]
	case "hapusKIKD":
		$kbm=isset($_GET['kbm'])?$_GET['kbm']:"";
		mysql_query("DELETE FROM gmp_kikd WHERE kode_ngajar='$kbm'");
		echo ns("Hapus","parent.location='?page=$page'","KIKD <strong'>".$_GET['kbm']."</strong>");
	break;
//===============[Hapus Nilai Pengetahuan]
	case "hapusNP":
		$kbm=isset($_GET['kbm'])?$_GET['kbm']:"";
		mysql_query("DELETE FROM n_p_kikd WHERE kd_ngajar='$kbm'");
		echo ns("Hapus","parent.location='?page=$page&sub=cekkikd&Kode=$kbm'","KBM <strong>".$_GET['kbm']."</strong>");
	break;
//===============[Hapus Nilai Keterampilan]
	case "hapusNK":
		$kbm=isset($_GET['kbm'])?$_GET['kbm']:"";
		mysql_query("DELETE FROM n_k_kikd WHERE kd_ngajar='$kbm'");
		echo ns("Hapus","parent.location='?page=$page&sub=cekkikd&Kode=$kbm'","KBM <strong>".$_GET['kbm']." </strong>");
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
	var a={
		"delkikd":function(a){
			function b(){
				window.location=a.attr("href")
			}
			$.SmartMessageBox(
				{
					"title":"<h1 style='margin-top:-5px;'><i class='fa fa-fw fa-question-circle bounce animated text-primary'></i><small class='text-primary'><strong> Konfirmasi</strong></small></h1>",
					"content":a.data("delkikd-msg"),
					"buttons":"[No][Yes]"
				},function(a){
					"Yes"==a&&($.root_.addClass("animated fadeOutUp"),setTimeout(b,1e3))
					}
		)}
	}
	$.root_.on("click",'[data-action="delkikd"]',function(b){var c=$(this);a.delkikd(c),b.preventDefault(),c=null});
	var d={
		"hpsdp":function(d){
			function e(){
				window.location=d.attr("href")
			}
			$.SmartMessageBox(
				{
					"title":"<h1 style='margin-top:-5px;'><i class='fa fa-fw fa-question-circle bounce animated text-primary'></i><small class='text-primary'><strong> Konfirmasi</strong></small></h1>",
					"content":d.data("hpsdp-msg"),
					"buttons":"[No][Yes]"
				},function(d){
					"Yes"==d&&($.root_.addClass("animated fadeOutUp"),setTimeout(e,1e3))
					}
		)}
	}
	$.root_.on("click",'[data-action="hpsdp"]',function(e){var f=$(this);d.hpsdp(f),e.preventDefault(),f=null});
	var g={
		"hpsdk":function(g){
			function h(){
				window.location=g.attr("href")
			}
			$.SmartMessageBox(
				{
					"title":"<h1 style='margin-top:-5px;'><i class='fa fa-fw fa-question-circle bounce animated text-primary'></i><small class='text-primary'><strong> Konfirmasi</strong></small></h1>",
					"content":g.data("hpsdk-msg"),
					"buttons":"[No][Yes]"
				},function(g){
					"Yes"==g&&($.root_.addClass("animated fadeOutUp"),setTimeout(h,1e3))
					}
		)}
	}
	$.root_.on("click",'[data-action="hpsdk"]',function(h){var i=$(this);g.hpsdk(i),h.preventDefault(),i=null});
	var j={
		"hapuskikd":function(j){
			function k(){
				window.location=j.attr("href")
			}
			$.SmartMessageBox(
				{
					"title":"<h1 style='margin-top:-5px;'><i class='fa fa-fw fa-question-circle bounce animated text-primary'></i><small class='text-primary'><strong> Konfirmasi</strong></small></h1>",
					"content":j.data("hapuskikd-msg"),
					"buttons":"[No][Yes]"
				},function(j){
					"Yes"==j&&($.root_.addClass("animated fadeOutUp"),setTimeout(k,1e3))
					}
		)}
	}
	$.root_.on("click",'[data-action="hapuskikd"]',function(k){var l=$(this);j.hapuskikd(l),k.preventDefault(),l=null});
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
