<?php
require_once("inc/init.php");
require_once("inc/config.ui.php");
$page_title = "Sikap dan Leger";
$page_css[] = "your_style.css";
include("inc/header.php");
$page_nav["bpbk"]["active"] = true;
include("inc/nav.php");
echo "<div id='main' role='main'>";
$breadcrumbs["BP/BK"] = "";
include("inc/ribbon.php");	
//== MENU ADMINISTRASI UJIAN
	if($_GET['sub']=="sikapsiswa" || $_GET['sub']=="datasikap" || $_GET['sub']=="editsikap" || $_GET['sub']=="ngisisikap"){$bnt0="info";}else{$bnt0="default";}
	if($_GET['sub']=="legernilai"){$bnt1="info";}else{$bnt1="default";}

	$Menu.=JudulKolom("Menu Pilihan","th");
	$Menu.="	
	<a href='?page=$page&sub=sikapsiswa' class='btn btn-$bnt0 btn-sm btn-block'>Sikap Siswa</a> 
	<a href='?page=$page&sub=legernilai' class='btn btn-$bnt1 btn-sm btn-block'>Leger Nilai</a>";
	if($_GET['sub']==""){
		$Menu.="";
	}
	else{
		$Menu.="<a href='?page=$page' class='btn btn-default btn-sm btn-block'>Kembali</a>";	
	}

$sub=(isset($_GET['sub']))?$_GET['sub']:"";
switch($sub)
{
//tampilan awal
	case "tampil":default:

		$QTA=mysql_query("select * from ak_tahunajaran order by id_thnajar asc");
		while ($HTA=mysql_fetch_array($QTA)){
			$Sel=$HTA['tahunajaran']==$PilTA?"selected":"";
			$InputTA.="<option $Sel value={$HTA['tahunajaran']}>{$HTA['tahunajaran']}</option>";
		}

		$QTS=mysql_query("select * from ak_semester");
		while ($HTS=mysql_fetch_array($QTS)){
			$Sel=$HTS['ganjilgenap']==$PilSmstr?"selected":"";
			$InputTS.="<option $Sel value={$HTS['ganjilgenap']}>{$HTS['ganjilgenap']}</option>";
		}

		$PilihKBM.="
		<form action='?page=$page' method='post' name='frmTmbhPil' id='frmTmbhPil' role='form' class='smart-form' style='margin-top:-10px;'>
			<fieldset>
				<div class='row'>
					<section class='col col-4'></section>
					<section class='col col-2'>
						<label class='select'>
							<select name=\"txtThnAjar\" class='input-sm form-control' onchange=\"document.location.href='?page=$page&sub=simpanthnajar&thnajar='+document.frmTmbhPil.txtThnAjar.value\">
								<option value='' selected='' disabled=''>Tahun Ajaran</option>
								$InputTA
							</select> <i></i> </label>
					</section>
					<section class='col col-2'>
						<label class='select'>
							<select name=\"txtGG\" class='input-sm form-control' onchange=\"document.location.href='?page=$page&sub=simpansmstr&smstr='+document.frmTmbhPil.txtGG.value\">
								<option value='' selected='' disabled=''>Semester</option>
								$InputTS
							</select> <i></i> </label>
					</section>
					<section class='col col-4'></section>
				</div>
			</fieldset>
		</form>";

		$HalKanan.=KolomPanel("
		<br><br>
			<div class='text-center'>
				<a href='' class='btn btn-danger btn-circle btn-xl'><i class='fa fa-handshake-o fa-2x'></i></a>
				<br><br>
				<h1>
					<span class='text-danger slideInRight fast animated'>
						<strong> BP DAN BK </strong>
					</span>
				</h1>
				<h1>
					<span class='semi-bold'>LCKS</span> <i class='ultra-light'>SMK</i> <span class='hidden-mobile'>(Kurikulum 2013)</span> <sup class='badge bg-color-red bounceIn animated'>$VersiApp</sup> 
					<br> 
					<small class='text-danger slideInRight fast animated'>
						<strong><span class='hidden-mobile'>Aplikasi</span> Laporan Capaian Kompetensi Siswa</strong>
					</small>
				</h1>
			</div>
			<br>
			<span class='timeline-seperator text-center'> 
				<span>
					<small class='text-danger slideInRight fast animated'>
						<strong class='font-lg'>
							<i class='fa fa-angle-double-left'></i>
							<i class='fa fa-angle-double-left'></i>
							<i class='fa fa-angle-double-left'></i>
							<i class='fa fa-angle-double-right'></i>
							PILIH KBM 
							<i class='fa fa-angle-double-left'></i>
							<i class='fa fa-angle-double-right'></i>
							<i class='fa fa-angle-double-right'></i>
							<i class='fa fa-angle-double-right'></i> 
						</strong>
					</small>
				</span>
			</span>
			<br>
			$PilihKBM
		");
		$Show.=DuaKolomD(2,KolomPanel($Menu),10,$HalKanan);
		echo IsiPanel($Show);
	break;

	case "sikapsiswa":	
		
		$Q="SELECT * FROM ak_kelas,ak_paketkeahlian,app_user_guru WHERE ak_kelas.kode_pk=ak_paketkeahlian.kode_pk AND ak_kelas.id_guru=app_user_guru.id_guru and tahunajaran='$PilTA'";

		$no=1;
		$Query=mysql_query("$Q  order by id_kls asc");
		while($Hasil=mysql_fetch_array($Query)){
			$QJSiswa=mysql_query("select * from ak_perkelas where tahunajaran='".$PilTA."' and nm_kelas='{$Hasil['nama_kelas']}'");
			$HJSiswa=mysql_num_rows($QJSiswa);
			$QSikap=mysql_query("select * from n_bpbk where idkls='{$Hasil['id_kls']}' and tahunajaran='$PilTA' and semester='$PilSmstr'");
			$JSikap=mysql_num_rows($QSikap);

			if($JSikap<$HJSiswa){
				$Warna="txt-color-red";
				$iconrev="red";
			}
			else{
				$Warna="";
				$iconrev="blue";
			}

			if($JSikap>0){
				$Aksi="
				<a href='?page=$page&sub=datasikap&idkls={$Hasil['id_kls']}'><i class='fa fa-eye fa-border txt-color-$iconrev'></i></a>&nbsp;&nbsp;&nbsp;
				<a href='?page=$page&sub=hapussikap&idkls={$Hasil['id_kls']}' data-action='hapus' data-hapus-msg=\"Apakah Anda yakin akan mengapus data sikap untuk kelas <strong class='text-primary'>{$Hasil['nama_kelas']}</strong>\"><i class='fa fa-trash-o fa-border txt-color-red'></i></a>";
			}
			else{
				$Aksi="<a href='?page=$page&sub=ngisisikap&idkls={$Hasil['id_kls']}' class='btn btn-success btn-block btn-xs'>Sikap</a>";
			}

			$TampilData.="
			<tr>
				<td class='text-center'>$no.</td>
				<td>{$Hasil['nama_kelas']}</td>
				<td>{$Hasil['nama_lengkap']}</td>
				<td>{$HJSiswa} / <span class='$Warna'>{$JSikap}</span></td>
				<td>$Aksi</td>
			</tr>";
			$no++;
		}

		$jmldata=mysql_num_rows($Query);
		if($jmldata>0){
			$Show.=JudulKolom("Sikap Siswa","handshake-o");
			$Show.="<p>Tahun Ajaran <strong>$PilTA</strong> <span class='hidden-lg'><br></span> Semester <strong>$PilSmstr</strong> <span class='hidden-lg'><br></span> Total <strong>$jmldata (".terbilang($jmldata).") kelas</strong></p><br>";
			$Show.="
			<div class='well no-padding'>
				<table id='dt_basic' class='table table-striped table-bordered table-hover table-condensed' width='100%'>
					<thead>
						<tr>
							<th class='text-center' data-class='expand'>No.</th>
							<th class='text-center'>Kelas</th>
							<th class='text-center' data-hide='phone'>Wali Kelas</th>
							<th class='text-center' data-hide='phone'>Jml</th>
							<th class='text-center'>Aksi</th>
						</tr>
					</thead>
					<tbody>$TampilData</tbody>
				</table>
			</div>";
		}
		else{
			$Show.=nt("informasi","Data Kelas belum ada");		
		}

		$tandamodal="#SikapSiswa";
		echo $SikapSiswa;
		echo IsiPanel(DuaKolomD(2,KolomPanel($Menu),10,$Show));
	break;

	case "hapussikap":
		mysql_query("DELETE FROM n_bpbk WHERE idkls='".$_GET['idkls']."'");
		echo ns("Hapus","parent.location='?page=$page&sub=sikapsiswa'","sikap siswa");
	break;

	case "datasikap":
		$idkls=isset($_GET['idkls'])?$_GET['idkls']:"";
		$QSis=mysql_query("
		select 
		ak_kelas.id_kls,
		ak_kelas.nama_kelas,
		ak_kelas.tahunajaran,
		siswa_biodata.nis,
		siswa_biodata.nm_siswa,
		siswa_biodata.jenis_kelamin 
		from ak_kelas,
		siswa_biodata,
		ak_perkelas 
		where 
		ak_kelas.nama_kelas=ak_perkelas.nm_kelas and 
		ak_kelas.tahunajaran=ak_perkelas.tahunajaran and 
		ak_perkelas.nis=siswa_biodata.nis and 
		ak_kelas.id_kls='$idkls' 
		order by siswa_biodata.nis");
		$no=1;
		while($HasilSis=mysql_fetch_array($QSis)){	
			if($HasilSis['jenis_kelamin']=="Laki-laki"){$jksiswa="L";}
			else if($HasilSis['jenis_kelamin']=="Perempuan"){$jksiswa="P";}
			else{$jksiswa="";};
			$nmkelas=$HasilSis['nama_kelas'];
			$nisnya=$HasilSis['nis'];
			$QSikap=mysql_query("select * from n_bpbk where nis='$nisnya' and tahunajaran='$PilTA' and semester='$PilSmstr'");
			$HSikap=mysql_fetch_array($QSikap);
			$JSikap=mysql_num_rows($QSikap);
			if($JSikap>=1){
				if($HSikap['sp1']==1){$SSP11="menjalankan ibadah sesuai dengan agamanya, ";}else{$SSP21="ibadah sesuai dengan agamanya, ";}
				if($HSikap['sp2']==1){$SSP12="berdoa sebelum dan sesudah melakukan kegiatan, ";}else{$SSP22="kegiatan berdoa sebelum dan sesudah melakukan kegiatan, ";}
				if($HSikap['sp3']==1){$SSP13="memberi salam pada saat awal dan akhir kegiatan, ";}else{$SSP23="sikap memberi salam pada saat awal dan akhir kegiatan, ";}
				if($HSikap['sp4']==1){$SSP14="bersyukur atas nikmat dan karunia Tuhan Yang Maha Esa, ";}else{$SSP24="rasa syukur atas nikmat dan karunia Tuhan Yang Maha Esa, ";}
				if($HSikap['sp5']==1){$SSP15="menysukuri kemampuan manusia dalam mengendalikan diri, ";}else{$SSP25="rasa syukur atas kemampuan manusia dalam mengendalikan diri, ";}
				if($HSikap['sp6']==1){$SSP16="bersyukur ketika berhasil mengerjekan sesuatu, ";}else{$SSP26="rasa syukur ketika berhasil mengerjekan sesuatu, ";}
				if($HSikap['sp7']==1){$SSP17="berserah diri (tawakal) kepada Tuhan setelah berikhtiar atau melakukan usaha, ";}else{$SSP27="tawakal kepada Tuhan setelah berikhtiar atau melakukan usaha, ";}
				if($HSikap['sp8']==1){$SSP18="menjaga lingkungan hidup di sekitar sekolah, ";}else{$SSP28="kegiatan menjaga lingkungan hidup di sekitar sekolah, ";}
				if($HSikap['sp9']==1){$SSP19="memelihara hubungan baik dengan sesama umat Ciptaan Tuhan Yang Maha Esa, ";}else{$SSP29="sikap memelihara hubungan baik dengan sesama umat Ciptaan Tuhan Yang Maha Esa, ";}
				if($HSikap['sp10']==1){$SSP110="bersukur kepada Tuhan yang Mahaa Esa sebagai bangsa Indonesia, ";}else{$SSP210="rasa syukur kepada Tuhan yang Mahaa Esa sebagai bangsa Indonesia, ";}
				if($HSikap['sp11']==1){$SSP111="menghormati orang lain yang menjalankan ibadah sesuai dengan agamanya, ";}else{$SSP211="rasa hormat kepada orang lain yang menjalankan ibadah sesuai dengan agamanya, ";}
				$SSp1="<strong>Selalu</strong> ".$SSP11.$SSP12.$SSP13.$SSP14.$SSP15.$SSP16.$SSP17.$SSP18.$SSP19.$SSP110.$SSP111;
				$SSp2="<strong class='txt-color-red'>namun masih perlu meningkatkan</strong> ".$SSP21.$SSP22.$SSP23.$SSP24.$SSP25.$SSP26.$SSP27.$SSP28.$SSP29.$SSP210.$SSP211;
				$SSp3="<strong class='txt-color-red'>Sangat perlu meningkatkan</strong> ".$SSP21.$SSP22.$SSP23.$SSP24.$SSP25.$SSP26.$SSP27.$SSP28.$SSP29.$SSP210.$SSP211;
				if($HSikap['so1']==1){$DSSo11="jujur, ";}else{$DSSo21="jujur, ";}
				if($HSikap['so2']==1){$DSSo12="disiplin, ";}else{$DSSo22="disiplin, ";}
				if($HSikap['so3']==1){$DSSo13="tanggung jawab, ";}else{$DSSo23="tanggung jawab, ";}
				if($HSikap['so4']==1){$DSSo14="toleransi, ";}else{$DSSo24="toleransi, ";}
				if($HSikap['so5']==1){$DSSo15="gotong royong, ";}else{$DSSo25="gotong royong, ";}
				if($HSikap['so6']==1){$DSSo16="sopan santun, ";}else{$DSSo26="sopan santun, ";}
				if($HSikap['so7']==1){$DSSo17="percaya diri ";}else{$DSSo27="percaya diri, ";}
				$SSo1="<strong>Memiliki sikap</strong> ".$DSSo11.$DSSo12.$DSSo13.$DSSo14.$DSSo15.$DSSo16.$DSSo17;
				$SSo2="<strong class='txt-color-red'>namun masih perlu meningkatkan sikap</strong> ".$DSSo21.$DSSo22.$DSSo23.$DSSo24.$DSSo25.$DSSo26.$DSSo27;
				$SSo3="<strong class='txt-color-red'>Sangat perlu meningkatkan sikap</strong> ".$DSSo21.$DSSo22.$DSSo23.$DSSo24.$DSSo25.$DSSo26.$DSSo27;
				$Aksi=AksiSingle("pencil-square-o","","?page=$page&amp;sub=editsikap&amp;nis={$HasilSis['nis']}&amp;idklsna=$idkls");
				if($HSikap['jmlsp']==11){
					$SpriS=$SSp1;
					$SpriK="";
				}
				else if($HSikap['jmlsp']==22){
					$SpriS="";
					$SpriK=$SSp3;
				}
				else{
					$SpriS=$SSp1;
					$SpriK=$SSp2;
				}
				if($HSikap['jmlso']==7){
					$SosS=$SSo1;
					$SosK="";
				}
				elseif($HSikap['jmlso']==14){
					$SosS="";
					$SosK=$SSo3;
				}
				else{
					$SosS=$SSo1;
					$SosK=$SSo2;
				}
			}
			else{
				$Aksi=AksiSingle("plus-square-o","","?page=$page&amp;sub=tambah&amp;nis={$HasilSis['nis']}&amp;idklsna=$idkls");
				$SpriS="";
				$SpriK="";
				$SosS="";
				$SosK="";
			}
			$TampilData.="
			<tr>
				<td class='text-center'>$no.</td>
				<td>{$HasilSis['nis']}</td>
				<td>{$HasilSis['nm_siswa']}</td>
				<td>$jksiswa</td>
				<td>$SpriS $SpriK</td>
				<td>$SosS $SosK</td>
				<td>$Aksi</td>
			</tr>";
			$no++;
		}
		$jmldataSiswa=mysql_num_rows($QSis);
		if($jmldataSiswa>0){
			$Show.=ButtonKembali2("?page=$page&sub=sikapsiswa","style='margin-top:-8px;'");
			$Show.=JudulKolom("Data Sikap Siswa","user");

			$Show.="<p>Tahun Ajaran <strong>$PilTA</strong> Semester <strong>$PilSmstr</strong> Kelas <strong>$nmkelas</strong> Total <strong>$jmldataSiswa (".terbilang($jmldataSiswa).")</strong> orang</p>
			<div class='well no-padding'>
				<table id='dt_basic' class='table table-striped table-bordered table-hover table-condensed' width='100%'>
					<thead>
						<tr>
							<th class='text-center' data-class='expand'>No.</th>
							<th class='text-center' data-hide='phone'>NIS</th>
							<th class='text-center'>Nama Siswa</th>
							<th class='text-center' data-hide='phone'>JK</th>
							<th class='text-center' width='30%' data-hide='phone'>Sikap Spritual</th>
							<th class='text-center' width='30%' data-hide='phone'>Sikap Sosial</th>
							<th class='text-center'>Aksi</th>
						</tr>
					</thead>
					<tbody>$TampilData</tbody>
				</table>
			</div>";
		}
		else{
			$Show.=nt("informasi","Data Siswa belum ada");
		}
		echo IsiPanel(DuaKolomD(2,KolomPanel($Menu),10,$Show));
	break;

	case "editsikap":
		$nis=isset($_GET['nis'])?$_GET['nis']:""; 
		$idklsna=isset($_GET['idklsna'])?$_GET['idklsna']:"";
		NgambilData("select nis,nm_siswa from siswa_biodata where nis=$nis");
		$QSikap=mysql_query("select * from n_bpbk where nis='$nis' and tahunajaran='$PilTA' and semester='$PilSmstr'");
		$HSikap=mysql_fetch_array($QSikap);

		$DtSiswa.=JudulKolom("Identitas Siswa","");
		$DtSiswa.=FormIF("horizontal","Id Sikap","txtKDSikap",$HSikap['id_bpbk'],'5','readonly=readonly');
		$DtSiswa.=FormIF("horizontal","NIS","txtNIS",$nis,'4','readonly=readonly');
		$DtSiswa.=FormIF("horizontal","Nama Siswa","txNMSiswa",$nm_siswa,'8','readonly=readonly');
		$DtSiswa.="<input type='hidden' name='thnajaran' value='$PilTA'>";
		$DtSiswa.="<input type='hidden' name='smstr' value='$PilSmstr'>";

		$Spritual.=JudulKolom("Sikap Spritual","");
		$Spritual.=FormCBSikapE("1.","Menjalankan ibadah sesuai dengan agamanya","spri1",$HSikap['sp1'],"radio1","radio2");
		$Spritual.=FormCBSikapE("2.","Berdoa sebelum dan sesudah melakukan kegiatan","spri2",$HSikap['sp2'],"radio3","radio4");
		$Spritual.=FormCBSikapE("3.","Memberi salam pada saat awal dan akhir kegiatan","spri3",$HSikap['sp3'],"radio5","radio6");
		$Spritual.=FormCBSikapE("4.","Bersyukur atas nikmat dan karunia Tuhan Yang Maha Esa","spri4",$HSikap['sp4'],"radio7","radio8");
		$Spritual.=FormCBSikapE("5.","Menysukuri kemampuan manusia dalam mengendalikan diri","spri5",$HSikap['sp5'],"radio9","radio10");
		$Spritual.=FormCBSikapE("6.","Bersyukur ketika berhasil mengerjekan sesuatu","spri6",$HSikap['sp6'],"radio11","radio12");
		$Spritual.=FormCBSikapE("7.","Berserah diri (tawakal) kepada Tuhan setelah berikhtiar atau melakukan usaha","spri7",$HSikap['sp7'],"radio13","radio14");
		$Spritual.=FormCBSikapE("8.","Menjaga lingkungan hidup di sekitar sekolah","spri8",$HSikap['sp8'],"radio15","radio16");
		$Spritual.=FormCBSikapE("9.","Memelihara Hubungan baik dengan sesama umat Ciptaan Tuhan Yang Maha Esa","spri9",$HSikap['sp9'],"radio17","radio18");
		$Spritual.=FormCBSikapE("10.","Bersukur kepada Tuhan yang Mahaa Esa sebagai bangsa Indonesia","spri10",$HSikap['sp10'],"radio19","radio20");
		$Spritual.=FormCBSikapE("11.","menghormati orang lain yang menjalankan ibadah sesuai dengan agamanya","spri11",$HSikap['sp11'],"radio21","radio22");
		
		$Sosial.=JudulKolom("Sikap Sosial","");
		$Sosial.=FormCBSikapE("1.","Sikap Jujur","jujur",$HSikap['so1'],"radio23","radio24");
		$Sosial.=FormCBSikapE("2.","Sikap Disiplin","disiplin",$HSikap['so2'],"radio25","radio26");
		$Sosial.=FormCBSikapE("3.","Sikap Tanggung Jawab","tanggungjawab",$HSikap['so3'],"radio27","radio28");
		$Sosial.=FormCBSikapE("4.","Sikap Toleransi","toleransi",$HSikap['so4'],"radio29","radio30");
		$Sosial.=FormCBSikapE("5.","Sikap Gotong Royong","gotongroyong",$HSikap['so5'],"radio31","radio32");
		$Sosial.=FormCBSikapE("6.","Sikap Sopan Santun","sopansantun",$HSikap['so6'],"radio33","radio34");
		$Sosial.=FormCBSikapE("7.","Sikap percayadiri","percayadiri",$HSikap['so7'],"radio35","radio36");

		$Show.=ButtonKembali2("?page=$page&sub=datasikap&idkls=$idklsna","style='margin-top:-8px;'");
		$Show.=JudulKolom("<strong>Edit Nilai Sikap</strong> <i>$nm_siswa</i>","pencil-square-o");
		$Show.="<form action='?page=$page&amp;sub=simpanedit&idkls={$HSikap['idkls']}' method='post' name='frmEdit' class='form-horizontal' role='form'>";
		$Show.='<fieldset>';
		$Show.=KolomPanel($DtSiswa);
		$Show.='</fieldset>';
		$Show.='<fieldset>';
		$Show.=DuaKolomSama($Spritual,$Sosial);
		$Show.='</fieldset>';
		$Show.='<div class="form-actions">'.bSubmit("BtnEdit","Simpan").'</div>';
		$Show.='</form>';

		echo IsiPanel(DuaKolomD(2,KolomPanel($Menu),10,$Show));
	break;

	case "simpanedit":
		$idklsna=isset($_GET['idkls'])?$_GET['idkls']:"";
		$txtKDSikap=addslashes($_POST['txtKDSikap']);
		$txtNIS=addslashes($_POST['txtNIS']);
		$thnajaran=addslashes($_POST['thnajaran']);
		$smstr=addslashes($_POST['smstr']);
		$spri1=addslashes($_POST['spri1']);
		$spri2=addslashes($_POST['spri2']);
		$spri3=addslashes($_POST['spri3']);
		$spri4=addslashes($_POST['spri4']);
		$spri5=addslashes($_POST['spri5']);
		$spri6=addslashes($_POST['spri6']);
		$spri7=addslashes($_POST['spri7']);
		$spri8=addslashes($_POST['spri8']);
		$spri9=addslashes($_POST['spri9']);
		$spri10=addslashes($_POST['spri10']);
		$spri11=addslashes($_POST['spri11']);
		$jujur=addslashes($_POST['jujur']);
		$disiplin=addslashes($_POST['disiplin']);
		$tanggungjawab=addslashes($_POST['tanggungjawab']);
		$toleransi=addslashes($_POST['toleransi']);
		$gotongroyong=addslashes($_POST['gotongroyong']);
		$sopansantun=addslashes($_POST['sopansantun']);
		$percayadiri=addslashes($_POST['percayadiri']);
		$jmlspri=$spri1+$spri2+$spri3+$spri4+$spri5+$spri6+$spri7+$spri8+$spri9+$spri10+$spri11;
		$jmlso=$jujur+$disiplin+$tanggungjawab+$toleransi+$gotongroyong+$sopansantun+$percayadiri;
		mysql_query("
		update n_bpbk set nis='$txtNIS',tahunajaran='$thnajaran',semester='$smstr',sp1='$spri1',sp2='$spri2',sp3='$spri3',sp4='$spri4',sp5='$spri5',sp6='$spri6',
		sp7='$spri7',sp8='$spri8',sp9='$spri9',sp10='$spri10',sp11='$spri11',so1='$jujur',so2='$disiplin',so3='$tanggungjawab',so4='$toleransi',
		so5='$gotongroyong',so6='$sopansantun',so7='$percayadiri',jmlsp='$jmlspri',jmlso='$jmlso' where id_bpbk='$txtKDSikap'");
		echo '<div id="preloader"><div id="cssload"></div></div>';
		echo ns("Ngedit","parent.location='?page=$page&sub=datasikap&idkls=$idklsna'","sikap siswa");
	break;

	case "ngisisikap":
		$idkls=isset($_GET['idkls'])?$_GET['idkls']:"";
		$QSis=mysql_query("
		select 
		ak_kelas.id_kls,
		ak_kelas.nama_kelas,
		ak_kelas.tahunajaran,
		siswa_biodata.nis,
		siswa_biodata.nm_siswa,
		siswa_biodata.jenis_kelamin 
		from ak_kelas,
		siswa_biodata,
		ak_perkelas 
		where 
		ak_kelas.nama_kelas=ak_perkelas.nm_kelas and 
		ak_kelas.tahunajaran=ak_perkelas.tahunajaran and 
		ak_perkelas.nis=siswa_biodata.nis and 
		ak_kelas.id_kls='$idkls' 
		order by siswa_biodata.nis");
		$no=1;
		while($HasilSis=mysql_fetch_array($QSis)){	
			if($HasilSis['jenis_kelamin']=="Laki-laki"){$jksiswa="L";}
			else if($HasilSis['jenis_kelamin']=="Perempuan"){$jksiswa="P";}
			else{$jksiswa="";};
			$nmkelas=$HasilSis['nama_kelas'];
			$nisnya=$HasilSis['nis'];
			$TampilData.="
			<tr>
				<td class='text-center'>$no.</td>
				<td>
					<table class='table'>
					<tr bgcolor='#f5f5f5'>
						<td width='50'>{$HasilSis['nis']}</td>
						<td width='150'>{$HasilSis['nm_siswa']}</td>
						<td>$jksiswa</td>
					</tr>
					</table>
					<input class='form-control input-sm' type='hidden' value='".$idkls."' name='txtIDKLS[$i]'>
					<input class='form-control input-sm' type='hidden' value='".$HasilSis['nis']."' name='txtNIS[$i]'>
					<input class='form-control input-sm' type='hidden' value='".$PilTA."' name='txtTA[$i]'>
					<input class='form-control input-sm' type='hidden' value='".$PilSmstr."' name='txtSemester[$i]'>
					<table class='table'>
					<tr>
						<td>
						<div class='row'>
							<div class='col col-7'>
								<h4>Sikap Spritual</h4><br>
								<ol style='margin-left:25px;'>
								<li><label class='checkbox'><input type='checkbox' name='sp1[$i]' value='1'><i></i>Menjalankan ibadah sesuai dengan agamanya</label>
								<li><label class='checkbox'><input type='checkbox' name='sp2[$i]' value='1'><i></i>Berdoa sebelum dan sesudah melakukan kegiatan</label>
								<li><label class='checkbox'><input type='checkbox' name='sp3[$i]' value='1'><i></i>Memberi salam pada saat awal dan akhir kegiatan</label>
								<li><label class='checkbox'><input type='checkbox' name='sp4[$i]' value='1'><i></i>Bersyukur atas nikmat dan karunia Tuhan Yang Maha Esa</label>
								<li><label class='checkbox'><input type='checkbox' name='sp5[$i]' value='1'><i></i>Menysukuri kemampuan manusia dalam mengendalikan diri</label>
								<li><label class='checkbox'><input type='checkbox' name='sp6[$i]' value='1'><i></i>Bersyukur ketika berhasil mengerjekan sesuatu</label>
								<li><label class='checkbox'><input type='checkbox' name='sp7[$i]' value='1'><i></i>Berserah diri (tawakal) kepada Tuhan setelah berikhtiar atau melakukan usaha</label>
								<li><label class='checkbox'><input type='checkbox' name='sp8[$i]' value='1'><i></i>Menjaga lingkungan hidup di sekitar sekolah</label>
								<li><label class='checkbox'><input type='checkbox' name='sp9[$i]' value='1'><i></i>Memelihara Hubungan baik dengan sesama umat Ciptaan Tuhan Yang Maha Esa</label>
								<li><label class='checkbox'><input type='checkbox' name='sp10[$i]' value='1'><i></i>Bersukur kepada Tuhan yang Mahaa Esa sebagai bangsa Indonesia</label>
								<li><label class='checkbox'><input type='checkbox' name='sp11[$i]' value='1'><i></i>Menghormati orang lain yang menjalankan ibadah sesuai dengan agamanya</label>
								</ol>
							</div>
							<div class='col col-5'><br>
								<h4>Sikap Sosial</h4><br>
								<ol style='margin-left:25px;'>
								<li> <label class='checkbox'><input type='checkbox' name='so1[$i]' value='1'><i></i>Sikap Jujur</label>
								<li> <label class='checkbox'><input type='checkbox' name='so2[$i]' value='1'><i></i>Sikap Disiplin</label>
								<li> <label class='checkbox'><input type='checkbox' name='so3[$i]' value='1'><i></i>Sikap Tanggung Jawab</label>
								<li> <label class='checkbox'><input type='checkbox' name='so4[$i]' value='1'><i></i>Sikap Toleransi</label>
								<li> <label class='checkbox'><input type='checkbox' name='so5[$i]' value='1'><i></i>Sikap Gotong Royong</label>
								<li> <label class='checkbox'><input type='checkbox' name='so6[$i]' value='1'><i></i>Sikap Sopan Santun</label>
								<li> <label class='checkbox'><input type='checkbox' name='so7[$i]' value='1'><i></i>Sikap percayadiri</label>
								</ol>
							</div>
						</div>
						</td>
					</tr>
					</table>
				</td>
			</tr>";
			$no++;
		}
		$jmldataSiswa=mysql_num_rows($QSis);
		if($jmldataSiswa>0){
			$Show.=ButtonKembali2("?page=$page&sub=sikapsiswa","style='margin-top:-8px;'");
			$Show.=JudulKolom("Isi Sikap Siswa","plus");
			$Show.="<p>Tahun Ajaran <strong>$PilTA</strong> Semester <strong>$PilSmstr</strong> Kelas <strong>$nmkelas</strong> Total <strong>$jmldataSiswa (".terbilang($jmldataSiswa).")</strong> orang</p>";
			$Show.="
			<script> 
			function checkUncheckAll(theElement) 
			{
				var theForm=theElement.form, z=0;
				for(z=0; z<theForm.length;z++)
				{
					if(theForm[z].type == 'checkbox' && theForm[z].name != 'checkall')
					{
						theForm[z].checked=theElement.checked;
					}
				}
			}
			</script>
			<form action='?page=$page&sub=simpansemuasikap' method='post' class='smart-form'>
			<input class='btn btn-info btn-sm pull-right' type='submit' name='btnSave' id='btnSave' value='Simpan'> 
			<span class='pull-right'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> 
			<span class='pull-right'>".FormCB("Pilih Semua","checkbox",'onclick="checkUncheckAll(this)";')."</span>
			<br><br><br><br>
			<div class='well no-padding'>
				<table class='table table-forum'>
					<tr bgcolor='#f5f5f5'>
						<td>No.</td>
						<td>Sikap Siswa</td>
					</tr>
					$TampilData
				</table><div style='margin:25px 25px;padding-bottom:10px;border-top:dashed 1px;border-color:#f5f5f5;'>".FormCB("Pilih Semua","checkbox",'onclick="checkUncheckAll(this)";')."</div>
			</div>
			<div class='form-actions'><input class='btn btn-info btn-sm' type='submit' name='btnSave' id='btnSave' value='Simpan'></div>
			</form>";
		}
		else{
			$Show.=ButtonKembali2("?page=$page&sub=sikapsiswa","style='margin-top:-8px;'");
			$Show.=JudulKolom("Isi Sikap Siswa","plus");
			$Show.=nt("informasi","Data Siswa belum ada, silakan hubungi bagian Master Administrasi");
		}

		echo IsiPanel(DuaKolomD(2,KolomPanel($Menu),10,$Show));
	break;

	case "simpansemuasikap":
		foreach($_POST['txtIDKLS'] as $i => $txtIDKLS){
			$txtNIS=$_POST['txtNIS'][$i];
			$txtTA=$_POST['txtTA'][$i];
			$txtSemester=$_POST['txtSemester'][$i];
			$sp1=$_POST['sp1'][$i];
			$sp2=$_POST['sp2'][$i];
			$sp3=$_POST['sp3'][$i];
			$sp4=$_POST['sp4'][$i];
			$sp5=$_POST['sp5'][$i];
			$sp6=$_POST['sp6'][$i];
			$sp7=$_POST['sp7'][$i];
			$sp8=$_POST['sp8'][$i];
			$sp9=$_POST['sp9'][$i];
			$sp10=$_POST['sp10'][$i];
			$sp11=$_POST['sp11'][$i];
			$so1=$_POST['so1'][$i];
			$so2=$_POST['so2'][$i];
			$so3=$_POST['so3'][$i];
			$so4=$_POST['so4'][$i];
			$so5=$_POST['so5'][$i];
			$so6=$_POST['so6'][$i];
			$so7=$_POST['so7'][$i];
			//$kd_bpbk=buatKode("bpbk","bpbk_");
			$jmlsp=$sp1+$sp2+$sp3+$sp4+$sp5+$sp6+$sp7+$sp8+$sp9+$sp10+$sp11;
			$jmlso=$so1+$so2+$so3+$so4+$so5+$so6+$so7;
			mysql_query("INSERT INTO n_bpbk VALUES ('','$txtIDKLS','$txtNIS','$txtTA','$txtSemester','$sp1','$sp2','$sp3','$sp4','$sp5','$sp6','$sp7','$sp8','$sp9','$sp10','$sp11','$so1','$so3','$so3','$so4','$so5','$so6','$so7','$jmlsp','$jmlso')");		
			echo ns("Nambah","parent.location='?page=$page&sub=sikapsiswa'","sikap siswa");
		}
	break;

	case "legernilai":
		$Show.=nt("informasi","Nilai leger Kurikulum Merdeka kelas 10 belum di setting");
		$Q="SELECT * FROM ak_kelas,ak_paketkeahlian,app_user_guru WHERE ak_kelas.kode_pk=ak_paketkeahlian.kode_pk AND ak_kelas.id_guru=app_user_guru.id_guru and tahunajaran='$PilTA'";
		$no=1;
		$Query=mysql_query("$Q  order by id_kls asc");
		while($Hasil=mysql_fetch_array($Query)){
			$CekKBMMapel=JmlDt("select * from leger_nilai_mapel where id_kls='".$Hasil["kode_kelas"]."' and thnajaran='".$PilTA."' and semester='".$PilSmstr."'");
			
			if($CekKBMMapel>0)
			{
				if($PilTA=="2022-2023" && $Hasil["tingkat"]=="X"){
					$TmbDownloagLeger="<a href=\"javascript:void(0);\" onClick=\"window.open('./pages/excel/ekspor-nilai.php?eksporex=leger-nilai-kurikulum-km&kls={$Hasil['kode_kelas']}&thnajaran=$PilTA&gg=$PilSmstr')\"><i class='fa fa-graduation-cap'></i> Leger Siswa</a>";
				}
				else {
					$TmbDownloagLeger="<a href=\"javascript:void(0);\" onClick=\"window.open('./pages/excel/ekspor-nilai.php?eksporex=leger-nilai-kurikulum&kls={$Hasil['kode_kelas']}&thnajaran=$PilTA&gg=$PilSmstr')\"><i class='fa fa-graduation-cap'></i> Leger Siswa</a>";
				}
			}
			else
			{
				$TmbDownloagLeger="";
			}

			$QJSiswa=mysql_query("select * from ak_perkelas where tahunajaran='".$PilTA."' and nm_kelas='{$Hasil['nama_kelas']}'");
			$HJSiswa=mysql_num_rows($QJSiswa);
			$TampilData.="
			<tr>
				<td class='text-center'>$no.</td>
				<td>{$Hasil['nama_kelas']}</td>
				<td>{$Hasil['nama_lengkap']}</td>
				<td>{$HJSiswa}</td>
				<td>$TmbDownloagLeger</td>
			</tr>";
			$no++;
		}
		$jmldata=mysql_num_rows($Query);
		if($jmldata>0){
			$Show.=JudulKolom("Leger Nilai","address-book");
			$Show.="<p>Tahun Ajaran <strong>$PilTA</strong> <span class='hidden-lg'><br></span> Semester <strong>$PilSmstr</strong> <span class='hidden-lg'><br></span> Total <strong>$jmldata (".terbilang($jmldata).") kelas</strong></p>";
			$Show.="
			<div class='well no-padding'>
				<table id='dt_basic' class='table table-striped table-bordered table-hover table-condensed' width='100%'>
					<thead>
						<tr>
							<th class='text-center' data-class='expand'>No.</th>
							<th class='text-center'>Kelas</th>
							<th class='text-center' data-hide='phone'>Wali Kelas</th>
							<th class='text-center' data-hide='phone'>Jml Siswa</th>
							<th class='text-center'>Aksi</th>
						</tr>
					</thead>
					<tbody>$TampilData</tbody>
				</table>
			</div>";
		}
		else{
			$Show.=nt("informasi","Data Kelas belum ada");		
		}
		
		echo $KetLegerNilai;
		$tandamodal="#KetLegerNilai";
		echo IsiPanel(DuaKolomD(2,KolomPanel($Menu),10,$Show));
	break;

	case "simpanthnajar":
		$thnajar=isset($_GET['thnajar'])?$_GET['thnajar']:"";
		$JmlData=JmlDt("select * from app_pilih_data where id_pil='$IDna'");

		if($JmlData==0){
			mysql_query("insert into app_pilih_data values ('$IDna','$thnajar','','','','','','','','','')");
		}else {
			mysql_query("update app_pilih_data set tahunajaran='$thnajar' where id_pil='$IDna'");
		}
		echo ns("Milih","parent.location='?page=$page'","tahun masuk $taunmasuk");
	break;

	case "simpansmstr":
		$smstr=isset($_GET['smstr'])?$_GET['smstr']:"";
		mysql_query("update app_pilih_data set semester='$smstr' where id_pil='$IDna'");
		echo ns("Milih","parent.location='?page=$page'","semester $smstr");
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
<script src="<?php echo ASSETS_URL; ?>/js/plugin/jquery-form/jquery-form.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	var a={
		"hapus":function(a){
			function b(){
				window.location=a.attr("href")
			}
			$.SmartMessageBox(
				{
					"title":"<h1 style='margin-top:-5px;'><i class='fa fa-fw fa-question-circle bounce animated text-primary'></i><small class='text-primary'><strong> Konfirmasi</strong></small></h1>",
					"content":a.data("hapus-msg"),
					"buttons":"[No][Yes]"
				},function(a){
					"Yes"==a&&($.root_.addClass("animated fadeOutUp"),setTimeout(b,1e3))
					}
		)}
	}

	$.root_.on("click",'[data-action="hapus"]',function(b){var c=$(this);a.hapus(c),b.preventDefault(),c=null});

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
})
</script>