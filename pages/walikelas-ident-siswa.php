<?php
require_once("inc/init.php");
require_once("inc/config.ui.php");
$page_title = "Identitas Siswa";
$page_css[] = "your_style.css";
include("inc/header.php");
$page_nav["walikelas"]["sub"]["identsiswa"]["active"] = true;
include("inc/nav.php");
echo "<div id='main' role='main'>";
$breadcrumbs["Wali Kelas"] = "";
include("inc/ribbon.php");	
$sub=(isset($_GET['sub']))?$_GET['sub']:"";
switch($sub)
{
	case "tampil":default:
		$Sis=" and ak_kelas.id_kls='$IDna' ";
		$MassaKBM="Tahun Pelajaran $TahunAjarAktif Semester $SemesterAktif";
		$Pilihkelas=$IDna;
		
		$Q=mysql_query("
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
			siswa_biodata.kode_paket=ak_paketkeahlian.kode_pk $Sis 
			order by siswa_biodata.nis");
		
		$no=1;	
		while($Hasil=mysql_fetch_array($Q)){
			NgambilData("select * from siswa_ortu where nis={$Hasil['nis']}");
			$NamaKelas=$Hasil['nama_kelas'];
			$TampilData.="
			<tr>
				<td class='text-center'>$no.</td>
				<td>{$Hasil['nis']}</td>
				<td><a href='?page=$page&amp;sub=edit&amp;NIS={$Hasil['nis']}'>{$Hasil['nm_siswa']}</a></td>
				<td>{$Hasil['tempat_lahir']}, ".Tanggal($Hasil['tanggal_lahir'])."</td>
				<td>{$Hasil['jenis_kelamin']}</td>
				<td>$nm_ayah</td>
				<td>$nm_ibu</td>
			</tr>";
			$no++;
		}

		$jmldata=mysql_num_rows($Q);	
		if($jmldata>0){
			$Show.="
			<div class='btn-group pull-right'>
				<button class='btn btn-default dropdown-toggle' data-toggle='dropdown' style='margin-top:-10px;'>
					 <span class='hidden-xs'>Cetak dan Download </span><span class='caret'></span>
				</button>
				<ul class='dropdown-menu'>
					<li> <a href=\"javascript:;\" onClick=\"window.open('./pages/formatbiodatasiswa.docx')\"><i class='fa fa-download'></i> Format Profil Siswa</a></li>
					<li> <a href=\"javascript:;\" onClick=\"window.open('./pages/excel/ekspor-data-master.php?eksporex=siswa-biodata-walikelas&idna=$Pilihkelas')\"><i class='fa fa-download'></i> Download Daftar Siswa</a></li>
					<li> <a href='?page=$page&sub=cekprofil&idna=$Pilihkelas'><i class='fa fa-check'></i> Cek Profil Siswa</a></li>
					<li> <a href='?page=$page&sub=usersiswa&idna=$Pilihkelas'><i class='fa fa-key'></i> Username Siswa</a></li>
					<li> <a href='?page=$page&sub=dapodiksiswa&idna=$Pilihkelas'><i class='fa fa-cubes'></i> Dapodik Siswa</a></li>
				</ul>
			</div>";
			$Show.=JudulKolom("Siswa Kelas $NamaKelas","user-circle");
			$Show.="<p class='text-danger' style='margin-top:-15px;'>$MassaKBM</p>
			<div class='well no-padding'>
			<table id='dt_basic' class='table table-striped table-bordered table-hover table-condensed' width='100%'>
				<thead>
					<tr>
						<th class='text-center' data-class='expand'>No.</th>
						<th class='text-center' data-hide='phone'>NIS</th>
						<th class='text-center'>Nama Siswa</th>
						<th class='text-center' data-hide='phone,tablet'>TTL</th>
						<th class='text-center' data-hide='phone,tablet'>Jenis Kelamin</th>
						<th class='text-center' data-hide='phone,tablet'>Nama Ayah</th>
						<th class='text-center' data-hide='phone,tablet'>Nama Ibu</th>
					</tr>
				</thead>
				<tbody>
				$TampilData
				</tbody>
			</table>
			</div>";
		}
		else 
		{
			$Show.="<p class='text-center'><img src='img/aa.png' width='100' height='231' border='0' alt=''></p><h1 class='text-center'><small class='text-danger slideInRight fast animated'><strong>$MassaKBM</strong> </small><br><small>Data Siswa belum ada, silakan hubungi Administrator.</small> </h1>";
		}
		
		$tandamodal="#WKIdentSiswa";
		echo $WKIdentSiswa;
		echo IsiPanel($Show);
	break;

	case "edit":

	$NIS=isset($_GET['NIS'])?$_GET['NIS']:""; 
		$IsiForm.="<script>function hitAlamatOrtu(){Blok=document.frmsiswa.txtAlBlok.value;Nomor=document.frmsiswa.txtAlNo.value;RT=document.frmsiswa.txtAlRT.value;RW=document.frmsiswa.txtAlRW.value;Desa=document.frmsiswa.txtAlDesa.value;Kec=document.frmsiswa.txtAlKec.value;Kab=document.frmsiswa.txtAlKab.value;KPos=document.frmsiswa.txtAlKPos.value;document.frmsiswa.txtAlBlokOT.value=Blok;document.frmsiswa.txtAlNoOT.value=Nomor;document.frmsiswa.txtAlRTOT.value=RT;document.frmsiswa.txtAlRWOT.value=RW;document.frmsiswa.txtAlDesaOT.value=Desa;document.frmsiswa.txtAlKecOT.value=Kec;document.frmsiswa.txtAlKabOT.value=Kab;document.frmsiswa.txtAlKPosOT.value=KPos;}
		function hitAlamatWali(){Blok=document.frmsiswa.txtAlBlok.value;Nomor=document.frmsiswa.txtAlNo.value;RT=document.frmsiswa.txtAlRT.value;RW=document.frmsiswa.txtAlRW.value;Desa=document.frmsiswa.txtAlDesa.value;Kec=document.frmsiswa.txtAlKec.value;Kab=document.frmsiswa.txtAlKab.value;KPos=document.frmsiswa.txtAlKPos.value;document.frmsiswa.txtAlBlokW.value=Blok;document.frmsiswa.txtAlNoW.value=Nomor;document.frmsiswa.txtAlRTW.value=RT;document.frmsiswa.txtAlRWW.value=RW;document.frmsiswa.txtAlDesaW.value=Desa;document.frmsiswa.txtAlKecW.value=Kec;document.frmsiswa.txtAlKabW.value=Kab;document.frmsiswa.txtAlKPosW.value=KPos;}</script>";
		$QBio=mysql_query("select * from siswa_biodata where nis='$NIS'");
		$HBio=mysql_fetch_array($QBio);
		$QSisAl=mysql_query("select * from siswa_alamat where nis='$NIS'");
		$HSisAl=mysql_fetch_array($QSisAl);
		$QOrtu=mysql_query("select * from siswa_ortu where nis='$NIS'");
		$HOrtu=mysql_fetch_array($QOrtu);
		$QOrtuAl=mysql_query("select * from siswa_alamat_ortu where nis='$NIS'");
		$HOrtuAl=mysql_fetch_array($QOrtuAl);
		$QWali=mysql_query("select * from siswa_wali where nis='$NIS'");
		$HWali=mysql_fetch_array($QWali);
		$QWaliAl=mysql_query("select * from siswa_alamat_wali where nis='$NIS'");
		$HWaliAl=mysql_fetch_array($QWaliAl);
		$BioSiswa.='<fieldset>';
		$BioSiswa.=JudulKolom("Biodata Siswa","");
		$BioSiswa.='<br>';
		$BioSiswa.=FormIF("horizontal","NIS","txtNIS",$HBio['nis'],'4','readonly=readonly');
		$BioSiswa.=FormIF("horizontal","NISN","txtNISN",$HBio['nisn'],'4',"");
		$BioSiswa.=FormCR("horizontal",'Tahun Masuk','txtTahunMasuk',$HBio['tahunmasuk'],$Ref->TahunMasuk,'4',"");
		$BioSiswa.=FormCF("horizontal",'Paket Keahlian','txtKodePK','select * from ak_paketkeahlian','kode_pk',$HBio['kode_paket'],'nama_paket','6',"");
		$BioSiswa.=FormIF("horizontal","Nama Lengkap","txtNama",htmlentities($HBio['nm_siswa'],ENT_QUOTES),'8',"");
		$BioSiswa.=FormIF("horizontal","Tempat Lahir","txtTmpLahir",$HBio['tempat_lahir'],'6',"");
		$BioSiswa.=IsiTgl('Tanggal Lahir','txtTglLahir','txtBlnLahir','txtThnLahir',$HBio['tanggal_lahir'],1990);
		$BioSiswa.=FormCR("horizontal",'Jenis Kelamin','txtJenKel',$HBio['jenis_kelamin'],$Ref->Gender,'4',"");
		$BioSiswa.=FormCR("horizontal",'Agama','txtAgama',$HBio['agama'],$Ref->Agama,'4',"");
		$BioSiswa.=FormCR("horizontal",'Status dalam Keluarga','txtStatKel',$HBio['status_dalam_kel'],$Ref->StatKel,'4',"");
		$BioSiswa.=FormCR("horizontal",'Anak Ke','txtAnakKe',$HBio['anak_ke'],$Ref->Semester,'4',"");
		$BioSiswa.=FormIF("horizontal","Telepon","txtTelp",$HBio['telepon_siswa'],'5',"");
		$BioSiswa.=FormIF("horizontal","Sekolah Asal SMP/MTs","txtSekolAsal",$HBio['sekolah_asal'],'6',"");
		$BioSiswa.=FormCR("horizontal",'Di Terima di kelas','txtDiterimaKls',$HBio['diterima_kelas'],$Ref->TingkatKls,'4',"");
		$BioSiswa.=IsiTgl('Tanggal Diterima','txtTglDiterima','txtBlnDiterima','txtThnDiterima',$HBio['diterima_tanggal'],2013);
		$BioSiswa.=FormCR("horizontal",'Asal Siswa','txtAsalSiswa',$HBio['asalsiswa'],$Ref->AsalSiswa,'5',"");
		$BioSiswa.=FormIF("horizontal","Alasan Pindahan","txtKetPindah",$HBio['keteranganpindah'],'8',"");
		$BioSiswa.='</fieldset>';
		$AlSiswa.='<fieldset>';
		$AlSiswa.=JudulKolom("Alamat Siswa","");
		$AlSiswa.='<br>';
		$AlSiswa.=FormIF("horizontal","Blok/Dusun","txtAlBlok",$HSisAl['blok'],'4',"");
		$AlSiswa.=FormIF("horizontal","Nomor","txtAlNo",$HSisAl['norumah'],'3',"");
		$AlSiswa.=FormIF("horizontal","RT","txtAlRT",$HSisAl['rt'],'3',"");
		$AlSiswa.=FormIF("horizontal","RW","txtAlRW",$HSisAl['rw'],'3',"");
		$AlSiswa.=FormIF("horizontal","Desa","txtAlDesa",$HSisAl['desa'],'6',"");
		$AlSiswa.=FormIF("horizontal","Kecamatan","txtAlKec",$HSisAl['kec'],'6',"");
		$AlSiswa.=FormIF("horizontal","Kabupaten","txtAlKab",$HSisAl['kab'],'6',"");
		$AlSiswa.=FormIF("horizontal","Kode Pos","txtAlKPos",$HSisAl['kodepos'],'3',"");
		$AlSiswa.='</fieldset>';
		$BioOrtu.='<fieldset>';
		$BioOrtu.=JudulKolom("Biodata Orang Tua","");
		$BioOrtu.='<br>';
		$BioOrtu.=FormIF("horizontal","Nama Ayah","txtNmAyah",htmlentities($HOrtu['nm_ayah'],ENT_QUOTES),'7',"");
		$BioOrtu.=FormIF("horizontal","Nama Ibu","txtNmIbu",htmlentities($HOrtu['nm_ibu'],ENT_QUOTES),'7',"");
		$BioOrtu.=FormCR("horizontal",'Pekerjaan Ayah','txtKerjaAyah',$HOrtu['pekerjaan_ayah'],$Ref->Pekerjaan,'4',"");
		$BioOrtu.=FormCR("horizontal",'Pekerjaan IBU','txtKerjaIbu',$HOrtu['pekerjaan_ibu'],$Ref->Pekerjaan,'4',"");
		$BioOrtu.=FormIF("horizontal","Telepon","txtTelpOT",$HOrtu['telepon_ortu'],'4',"");
		$BioOrtu.='</fieldset>';
		$AlOrtu.='<fieldset>';
		$AlOrtu.=JudulKolom("Alamat Orang Tua","");
		$AlOrtu.='<br>';
		$AlOrtu.="<p><strong><i class='ace-icon fa fa-check'></i>Perhatikan!</strong> Alamat sama dengan siswa? &nbsp;&nbsp;&nbsp;<input class='btn btn-minier btn-info' type='button' value='&nbsp;&nbsp;Ya&nbsp;&nbsp;' onclick='hitAlamatOrtu()'></p>";
		$AlOrtu.='<br>';
		$AlOrtu.=FormIF("horizontal","Blok/Dusun","txtAlBlokOT",$HOrtuAl['blok'],'4',"");
		$AlOrtu.=FormIF("horizontal","Nomor","txtAlNoOT",$HOrtuAl['norumah'],'3',"");
		$AlOrtu.=FormIF("horizontal","RT","txtAlRTOT",$HOrtuAl['rt'],'3',"");
		$AlOrtu.=FormIF("horizontal","RW","txtAlRWOT",$HOrtuAl['rw'],'3',"");
		$AlOrtu.=FormIF("horizontal","Desa","txtAlDesaOT",$HOrtuAl['desa'],'6',"");
		$AlOrtu.=FormIF("horizontal","Kecamatan","txtAlKecOT",$HOrtuAl['kec'],'6',"");
		$AlOrtu.=FormIF("horizontal","Kabupaten","txtAlKabOT",$HOrtuAl['kab'],'6',"");
		$AlOrtu.=FormIF("horizontal","Kode Pos","txtAlKPosOT",$HOrtuAl['kodepos'],'3',"");
		$AlOrtu.='</fieldset>';
		$BioWali.='<fieldset>';
		$BioWali.=JudulKolom("Biodata Wali Murid","");
		$BioWali.='<br>';
		$BioWali.=FormIF("horizontal","Nama Wali","txtNmWali",htmlentities($HWali['nm_wali'],ENT_QUOTES),'6',"");
		$BioWali.=FormCR("horizontal",'Pekerjaan Wali','txtKerjaWali',$HWali['pekerjaan_wali'],$Ref->Pekerjaan,'4',"");
		$BioWali.=FormIF("horizontal","Telepon","txtTelpW",$HWali['telepon_wali'],'4',"");
		$BioWali.='</fieldset>';
		$AlWali.='<fieldset>';
		$AlWali.=JudulKolom("Alamat Wali Murid","");
		$AlWali.='<br>';
		$AlWali.="<p><strong><i class='ace-icon fa fa-check'></i>Perhatikan!</strong>Alamat sama dengan siswa? &nbsp;&nbsp;&nbsp;<input class='btn btn-minier btn-info' type='button' value='&nbsp;&nbsp;Ya&nbsp;&nbsp;' onclick='hitAlamatWali()'></p>";
		$AlWali.='<br>';
		$AlWali.=FormIF("horizontal","Blok/Dusun","txtAlBlokW",$HWaliAl['blok'],'4',"");
		$AlWali.=FormIF("horizontal","Nomor","txtAlNoW",$HWaliAl['norumah'],'3',"");
		$AlWali.=FormIF("horizontal","RT","txtAlRTW",$HWaliAl['rt'],'3',"");
		$AlWali.=FormIF("horizontal","RW","txtAlRWW",$HWaliAl['rw'],'3',"");
		$AlWali.=FormIF("horizontal","Desa","txtAlDesaW",$HWaliAl['desa'],'6',"");
		$AlWali.=FormIF("horizontal","Kecamatan","txtAlKecW",$HWaliAl['kec'],'6',"");
		$AlWali.=FormIF("horizontal","Kabupaten","txtAlKabW",$HWaliAl['kab'],'6',"");
		$AlWali.=FormIF("horizontal","Kode Pos","txtAlKPosW",$HWaliAl['kodepos'],'3',"");
		$AlWali.='</fieldset>';
		$IsiForm.=DuaKolomD(6,KolomPanel($BioSiswa).KolomPanel($AlSiswa),6,KolomPanel($BioOrtu).KolomPanel($AlOrtu).KolomPanel($BioWali).KolomPanel($AlWali));
		$IsiForm.="<input type='hidden' name='txtPhoto'>";
		$IsiForm.='<div class="form-actions">'.ButtonSimpan().'</div>';

		$Show.=ButtonKembali2("?page=$page","style=margin-top:-10px;");
		$Show.=JudulKolom("Edit Identitas Siswa ","pencil");

		$Show.=FormAing($IsiForm,"?page=$page&amp;sub=nyimpen","frmsiswa");

		$tandamodal="#WKEditIdentSiswa";
		$Show.=$WKEditIdentSiswa;
		echo IsiPanel($Show);
	break;

	case "nyimpen":
		//simpan ke tabel siswa_biodata
		$txtNIS=addslashes($_POST['txtNIS']);
		$txtNISN=addslashes($_POST['txtNISN']);
		$txtTahunMasuk=addslashes($_POST['txtTahunMasuk']);
		$txtKodePK=addslashes($_POST['txtKodePK']);
		$txtNama=addslashes($_POST['txtNama']);
		$txtTmpLahir=addslashes($_POST['txtTmpLahir']);
		$txtTglLahir=addslashes($_POST['txtTglLahir']);
		$txtBlnLahir=addslashes($_POST['txtBlnLahir']);
		$txtThnLahir=addslashes($_POST['txtThnLahir']);
		$txtJenKel=addslashes($_POST['txtJenKel']);
		$txtAgama=addslashes($_POST['txtAgama']);
		$txtStatKel=addslashes($_POST['txtStatKel']);
		$txtAnakKe=addslashes($_POST['txtAnakKe']);
		$txtTelp=addslashes($_POST['txtTelp']);
		$txtSekolAsal=addslashes($_POST['txtSekolAsal']);
		$txtDiterimaKls=addslashes($_POST['txtDiterimaKls']);
		$txtTglDiterima=addslashes($_POST['txtTglDiterima']);
		$txtBlnDiterima=addslashes($_POST['txtBlnDiterima']);
		$txtThnDiterima=addslashes($_POST['txtThnDiterima']);
		$txtAsalSiswa=addslashes($_POST['txtAsalSiswa']);
		$txtKetPindah=addslashes($_POST['txtKetPindah']);
		$txtPhoto=addslashes($_POST['txtPhoto']);
		//Simpan ke tabel siswa_alamat
		$txtAlBlok=addslashes($_POST['txtAlBlok']);
		$txtAlNo=addslashes($_POST['txtAlNo']);
		$txtAlRT=addslashes($_POST['txtAlRT']);
		$txtAlRW=addslashes($_POST['txtAlRW']);
		$txtAlDesa=addslashes($_POST['txtAlDesa']);
		$txtAlKec=addslashes($_POST['txtAlKec']);
		$txtAlKab=addslashes($_POST['txtAlKab']);
		$txtAlKPos=addslashes($_POST['txtAlKPos']);
		//simpan ke tabel siswa_ortu
		$txtNmAyah=addslashes($_POST['txtNmAyah']);
		$txtNmIbu=addslashes($_POST['txtNmIbu']);
		$txtKerjaAyah=addslashes($_POST['txtKerjaAyah']);
		$txtKerjaIbu=addslashes($_POST['txtKerjaIbu']);
		$txtTelpOT=addslashes($_POST['txtTelpOT']);
		//simpan ke tabel siswa_ortu_alamat
		$txtAlBlokOT=addslashes($_POST['txtAlBlokOT']);
		$txtAlNoOT=addslashes($_POST['txtAlNoOT']);
		$txtAlRTOT=addslashes($_POST['txtAlRTOT']);
		$txtAlRWOT=addslashes($_POST['txtAlRWOT']);
		$txtAlDesaOT=addslashes($_POST['txtAlDesaOT']);
		$txtAlKecOT=addslashes($_POST['txtAlKecOT']);
		$txtAlKabOT=addslashes($_POST['txtAlKabOT']);
		$txtAlKPosOT=addslashes($_POST['txtAlKPosOT']);
		//simpan ke tabel siswa_Wali
		$txtNmWali=addslashes($_POST['txtNmWali']);
		$txtKerjaWali=addslashes($_POST['txtKerjaWali']);
		$txtTelpW=addslashes($_POST['txtTelpW']);
		//simpan ke tabel siswa_ortu_alamat
		$txtAlBlokW=addslashes($_POST['txtAlBlokW']);
		$txtAlNoW=addslashes($_POST['txtAlNoW']);
		$txtAlRTW=addslashes($_POST['txtAlRTW']);
		$txtAlRWW=addslashes($_POST['txtAlRWW']);
		$txtAlDesaW=addslashes($_POST['txtAlDesaW']);
		$txtAlKecW=addslashes($_POST['txtAlKecW']);
		$txtAlKabW=addslashes($_POST['txtAlKabW']);
		$txtAlKPosW=addslashes($_POST['txtAlKPosW']);
		$TglLahirSiswa=trim($_POST['txtThnLahir'])."-".trim($_POST['txtBlnLahir'])."-".trim($_POST['txtTglLahir']);
		$TglDiTerima=trim($_POST['txtThnDiterima'])."-".trim($_POST['txtBlnDiterima'])."-".trim($_POST['txtTglDiterima']);
		mysql_query("UPDATE siswa_biodata SET nisn='$txtNISN',tahunmasuk='$txtTahunMasuk',kode_paket='$txtKodePK',nm_siswa='$txtNama',tempat_lahir='$txtTmpLahir',tanggal_lahir='$TglLahirSiswa',jenis_kelamin='$txtJenKel',agama='$txtAgama',status_dalam_kel='$txtStatKel',anak_ke='$txtAnakKe',telepon_siswa='$txtTelp',sekolah_asal='$txtSekolAsal',diterima_kelas='$txtDiterimaKls',diterima_tanggal='$TglDiTerima',asalsiswa='$txtAsalSiswa',keteranganpindah='$txtKetPindah',foto='$txtPhoto' WHERE nis='".$_POST['txtNIS']."'");
		mysql_query("UPDATE app_user_siswa SET nm_siswa='$txtNama' where nis='".$_POST['txtNIS']."'");

		$QBioSis=mysql_query("select * from siswa_alamat where nis='".trim($_POST['txtNIS'])."'");
		$HBioSis=mysql_fetch_array($QBioSis);
		if(mysql_num_rows($QBioSis)>=1){
			mysql_query("UPDATE siswa_alamat SET  blok='$txtAlBlok',norumah='$txtAlNo',rt='$txtAlRT',rw='$txtAlRW',desa='$txtAlDesa',kec='$txtAlKec',kab='$txtAlKab',kodepos='$txtAlKPos' where nis='".$_POST['txtNIS']."'");
		}
		else{
			mysql_query("INSERT INTO siswa_alamat VALUES ('$txtNIS','$txtAlBlok','$txtAlNo','$txtAlRT','$txtAlRW','$txtAlDesa','$txtAlKec','$txtAlKab','$txtAlKPos')");
		}
		if(trim($_POST['txtNmAyah'])==""){ } 
		else{
			$QBioOT=mysql_query("select * from siswa_ortu where nis='".trim($_POST['txtNIS'])."'");
			$HBioOT=mysql_fetch_array($QBioOT);
			$QAlOT=mysql_query("select * from siswa_alamat_ortu where nis='".trim($_POST['txtNIS'])."'");
			$HAlOT=mysql_fetch_array($QAlOT);
			if(mysql_num_rows($QBioOT)>=1){ 
				mysql_query("UPDATE siswa_ortu SET nm_ayah='$txtNmAyah',nm_ibu='$txtNmIbu',pekerjaan_ayah='$txtKerjaAyah',pekerjaan_ibu='$txtKerjaIbu',telepon_ortu='$txtTelpOT' where nis='".$_POST['txtNIS']."'");
			}
			else{
				mysql_query("INSERT INTO siswa_ortu VALUES ('$txtNIS','$txtNmAyah','$txtNmIbu','$txtKerjaAyah','$txtKerjaIbu','$txtTelpOT')");
			}
			if(mysql_num_rows($QAlOT)>=1){
				mysql_query("UPDATE siswa_alamat_ortu SET  blok='$txtAlBlokOT',norumah='$txtAlNoOT',rt='$txtAlRTOT',rw='$txtAlRWOT',desa='$txtAlDesaOT',kec='$txtAlKecOT',kab='$txtAlKabOT',kodepos='$txtAlKPosOT' where nis='".$_POST['txtNIS']."'");
			}
			else{
				mysql_query("INSERT INTO siswa_alamat_ortu VALUES ('$txtNIS','$txtAlBlokOT','$txtAlNoOT','$txtAlRTOT','$txtAlRWOT','$txtAlDesaOT','$txtAlKecOT','$txtAlKabOT','$txtAlKPosOT')");
			}
		}
		if(trim($_POST['txtNmWali'])==""){ } 
		else{
			$QBioW=mysql_query("select * from siswa_wali where nis='".trim($_POST['txtNIS'])."'");
			$HBioW=mysql_fetch_array($QBioW);
			$QAlW=mysql_query("select * from siswa_alamat_wali where nis='".trim($_POST['txtNIS'])."'");
			$HAlW=mysql_fetch_array($QAlW);
			if(mysql_num_rows($QBioW)>=1){ 
				mysql_query("UPDATE siswa_wali SET nm_wali='$txtNmWali',pekerjaan_wali='$txtKerjaWali',telepon_wali='$txtTelpW' where nis='".$_POST['txtNIS']."'");
			}
			else{
				mysql_query("INSERT INTO siswa_wali VALUES ('$txtNIS','$txtNmWali','$txtKerjaWali','$txtTelpW')");
			}
			
			if(mysql_num_rows($QAlW)>=1){
				mysql_query("UPDATE siswa_alamat_wali SET  blok='$txtAlBlokW',norumah='$txtAlNoW',rt='$txtAlRTW',rw='$txtAlRWW',desa='$txtAlDesaW',kec='$txtAlKecW',kab='$txtAlKabW',kodepos='$txtAlKPosW' where nis='".$_POST['txtNIS']."'");
			}
			else{
				mysql_query("INSERT INTO siswa_alamat_wali VALUES ('$txtNIS','$txtAlBlokW','$txtAlNoW','$txtAlRTW','$txtAlRWW','$txtAlDesaW','$txtAlKecW','$txtAlKabW','$txtAlKPosW')");
			}
		}
		echo ns("Ngedit","parent.location='?page=$page'","Siswa bernama <span class='txt-color-orangeDark'><strong>$txtNama </strong></span>");
	break;

	case "usersiswa":
		$idna=isset($_GET['idna'])?$_GET['idna']:""; 

		$Q=mysql_query("
		select ak_kelas.id_kls,
		ak_kelas.nama_kelas,
		ak_kelas.tahunajaran,
		siswa_biodata.nis,
		siswa_biodata.nisn,
		siswa_biodata.nm_siswa 
		from ak_kelas,siswa_biodata,ak_perkelas,ak_paketkeahlian 
		where 
		ak_kelas.nama_kelas=ak_perkelas.nm_kelas and 
		ak_kelas.tahunajaran=ak_perkelas.tahunajaran and 
		ak_perkelas.nis=siswa_biodata.nis and 
		siswa_biodata.kode_paket=ak_paketkeahlian.kode_pk and 
		ak_kelas.id_kls='$idna' 
		order by siswa_biodata.nis");
		
		$no=1;	
		while($Hasil=mysql_fetch_array($Q)){
			$NamaKelas=$Hasil['nama_kelas'];

			$QPass=mysql_query("Select * from app_user_siswa where nis='{$Hasil['nis']}'");
			$HPass=mysql_fetch_array($QPass);

			$TampilData.="
			<tr style='border-color:black;'>
				<td align='center'>$no.</td>
				<td align='center'>{$Hasil['nisn']}</td>
				<td align='center'>{$Hasil['nis']}</td>
				<td style='padding-left:15px;'>{$HPass['ket']}</td>
				<td style='padding-left:15px;'>{$Hasil['nm_siswa']}</td>
			</tr>";
			$no++;
		}

		$jmldata=mysql_num_rows($Q);	
		if($jmldata>0){
			$Show.=ButtonKembali2("?page=$page","style='margin-top:-10px;margin-left:10px;'");
			$Show.="<a href='javascript:void(0);' class='btn btn-primary btn-sm pull-right' onclick=\"printContent('Cetak')\" style='margin-top:-10px;'>Cetak</a>";
			$Show.=JudulKolom("Siswa Kelas $NamaKelas","user-circle");
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
			$Show.="
			<div id='Cetak' style='@page {size: A4;}'>
				DAFTAR USERNAME SISWA <BR>
				KELAS $NamaKelas<br><br>
				<table style='margin: 0 auto;width:100%;border-collapse:collapse;font:12px Times New Roman;background: transparent;'border='1'>
					<tr style='border-color:black;'>
						<td align='center'>No.</td>
						<td align='center'>NISN</td>
						<td align='center'>Username</td>
						<td align='center'>Password</td>
						<td align='center'>Nama Siswa</td>
					</tr>
					$TampilData
				</table>
				<br>
				<em><strong>Keterangan :</strong></em>
				<br>
				1. Silakan untuk mengganti password setelah masuk pertama kali<br>
				2. Mohon untuk tidak memberikan password kepada orang lain. 
			</div>
			";
		}
		else 
		{
			$Show.="<p class='text-center'><img src='img/aa.png' width='100' height='231' border='0' alt=''></p><h1 class='text-center'><small class='text-danger slideInRight fast animated'><strong>$MassaKBM</strong> </small><br><small>Data Siswa belum ada, silakan hubungi Administrator.</small> </h1>";
		}
		
		echo IsiPanel($Show);
	break;

	case "cekprofil":
		$idna=isset($_GET['idna'])?$_GET['idna']:""; 
		$Q=mysql_query("select ak_kelas.id_kls,ak_kelas.nama_kelas,ak_kelas.tahunajaran,siswa_biodata.* from ak_kelas,siswa_biodata,ak_perkelas,ak_paketkeahlian where ak_kelas.nama_kelas=ak_perkelas.nm_kelas and ak_kelas.tahunajaran=ak_perkelas.tahunajaran and ak_perkelas.nis=siswa_biodata.nis and siswa_biodata.kode_paket=ak_paketkeahlian.kode_pk and ak_kelas.id_kls='$idna' order by siswa_biodata.nm_siswa");

		$no=1;	
		while($Hasil=mysql_fetch_array($Q)){
			NgambilData("select * from siswa_ortu where nis={$Hasil['nis']}");
			$NamaKelas=$Hasil['nama_kelas'];

			$sqlalamat = mysql_query("SELECT * FROM siswa_alamat where nis='".$Hasil['nis']."'");
			$dalamat = mysql_fetch_assoc($sqlalamat);
			$sqlpk = mysql_query("SELECT * FROM ak_paketkeahlian where kode_pk='".$Hasil['kode_paket']."'");
			$sqlortu = mysql_query("SELECT * FROM siswa_ortu where nis='".$Hasil['nis']."'");
			$dortu = mysql_fetch_assoc($sqlortu);

			$dpk = mysql_fetch_assoc($sqlpk);
			$tgllahir=" ".TglLengkap($Hasil['tanggal_lahir']);
			
			if($dalamat['rt']=="" || $dalamat['rw']=="" || $dalamat['desa']=="" || $dalamat['kec']==""){
				$alamatsis='';
			}
			else{
				$alamatsis='RT '.$dalamat['rt'].' RW '.$dalamat['rw'].' <br>Desa '.$dalamat['desa'].' <br>Kecamatan '.$dalamat['kec'].' <br>Kabupaten '.$dalamat['kab'].' <br>Kode Pos '.$dalamat['kodepos'];
			}

			$telp_siswa=" ".$Hasil['telepon_siswa'];

			$NISN=" ".$Hasil['nisn'];
			if($Hasil['tanggal_lahir']=="0000-00-00")
			{
				$IsiTglLahir="";
			}
			else{
				$IsiTglLahir=$Hasil['tanggal_lahir'];
			}

			$TampilData.="
			<tr>
				<td class='text-center' valign='top' width='50'>$no.</td>
				<td>
					<table height='25'>
						<tr>
							<td width='175'>NIS</td>
							<td width='25'>:</td>
							<td>{$Hasil['nis']}</td>
						</tr>
						<tr>
							<td>NISN</td>
							<td>:</td>
							<td>{$Hasil['nisn']}</td>
						</tr>
						<tr>
							<td>Tahun Masuk</td>
							<td>:</td>
							<td>{$Hasil['tahunmasuk']}</td>
						</tr>
						<tr>
							<td>Paket Keahlian</td>
							<td>:</td>
							<td>{$Hasil['kode_paket']}</td>
						</tr>
						<tr>
							<td>Nama Siswa</td>
							<td>:</td>
							<td><strong>{$Hasil['nm_siswa']}</strong></td>
						</tr>
						<tr>
							<td>Tempat dan Tanggal Lahir</td>
							<td>:</td>
							<td>{$Hasil['tempat_lahir']}, ".Tanggal($Hasil[tanggal_lahir])."</td>
						</tr>
						<tr>
							<td>Jenis Kelamin</td>
							<td>:</td>
							<td>{$Hasil['jenis_kelamin']}</td>
						</tr>
						<tr>
							<td>Agama</td>
							<td>:</td>
							<td>{$Hasil['agama']}</td>
						</tr>
						<tr>
							<td>Status Dalam Keluarga</td>
							<td>:</td>
							<td>{$Hasil['status_dalam_kel']}</td>
						</tr>
						<tr>
							<td>Anak Ke</td>
							<td>:</td>
							<td>{$Hasil['anak_ke']}</td>
						</tr>
						<tr>
							<td>Nomor Telepon/HP</td>
							<td>:</td>
							<td>{$Hasil['telepon_siswa']}</td>
						</tr>
						<tr>
							<td>Sekolah Asal</td>
							<td>:</td>
							<td>{$Hasil['sekolah_asal']}</td>
						</tr>
						<tr>
							<td>Di terima ak_kelas</td>
							<td>:</td>
							<td>{$Hasil['diterima_kelas']}</td>
						</tr>
						<tr>
							<td>Tanggal Diterima</td>
							<td>:</td>
							<td>".Tanggal($Hasil['diterima_tanggal'])."</td>
						</tr>
						<tr>
							<td>Asal Siswa</td>
							<td>:</td>
							<td>{$Hasil['asalsiswa']}</td>
						</tr>
						<tr>
							<td valign='top'>Alamat Siswa</td>
							<td valign='top'>:</td>
							<td>$alamatsis</td>
						</tr>
					</table>
				</td>
				<td width='25'>&nbsp;</td>
				<td valign='top'>
					<table height='25'>
						<tr>
							<td width='150'>Nama Ayah</td>
							<td width='25'>:</td>
							<td>{$dortu['nm_ayah']}</td>
						</tr>
						<tr>
							<td>Nama Ibu</td>
							<td>:</td>
							<td>{$dortu['nm_ibu']}</td>
						</tr>
						<tr>
							<td>Pekerjaan Ayah</td>
							<td>:</td>
							<td>{$dortu['pekerjaan_ayah']}</td>
						</tr>
						<tr>
							<td>Pekerjaan Ibu</td>
							<td>:</td>
							<td>{$dortu['pekerjaan_ibu']}</td>
						</tr>
						<tr>
							<td>Telepon Orang Tua</td>
							<td>:</td>
							<td>{$dortu['telepon_ortu']}</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td class='text-center' valign='top' height='25' colspan='4'><hr></td>
			</tr>";
			$no++;
		}
		$Show.=ButtonKembali2("?page=$page","style=margin-top:-10px;");
		$Show.=JudulKolom("Identitas Siswa $NamaKelas","address-book-o");

		$Show.="
		<table>$TampilData</table>
		";
		
		echo IsiPanel($Show);
	break;

	case "dapodiksiswa":
		$idna=isset($_GET['idna'])?$_GET['idna']:""; 

		$MenuPilihan.="
		<div class='btn-group pull-right'>
			<button class='btn btn-default dropdown-toggle' data-toggle='dropdown' style='margin-top:-10px;margin-right:10px;'>
				 <span class='hidden-xs'>Cek Data </span><span class='caret'></span>
			</button>
			<ul class='dropdown-menu'>
				<li> <a href='?page=$page&sub=dapodiksiswa&idna=$idna'><i class='fa fa-bank'></i> Alamat</a></li>
				<li> <a href='?page=$page&sub=dapodiksiswa&idna=$idna&cekdata=ayahibu'><i class='fa fa-user-circle'></i> Ayah Ibu</a></li>
				<li> <a href='?page=$page&sub=dapodiksiswa&idna=$idna&cekdata=ortuwali'><i class='fa fa-user-circle'></i> Wali</a></li>
				<li> <a href='?page=$page&sub=dapodiksiswa&idna=$idna&cekdata=regperiodiksiswa'><i class='fa fa-address-book-o'></i> Registrasi Periodik</a></li>
			</ul>
		</div>";

		$Q=mysql_query("select 
		ak_kelas.id_kls,
		ak_kelas.tingkat,
		ak_kelas.nama_kelas,
		ak_kelas.kode_pk,
		ak_kelas.tahunajaran,
		dapodik_siswa.nis,
		dapodik_siswa.nama_siswa,
		dapodik_siswa.tempatlahir, 
		dapodik_siswa.tanggallahir,
		dapodik_siswa.tanggallahir,
		dapodik_siswa.jk 
		from 
		ak_kelas,
		dapodik_siswa,
		ak_perkelas
		where 
		ak_kelas.nama_kelas=ak_perkelas.nm_kelas and 
		ak_kelas.tahunajaran=ak_perkelas.tahunajaran and 
		ak_perkelas.nis=dapodik_siswa.nis and 
		ak_kelas.id_kls='$idna' 
		order by ak_kelas.nama_kelas,dapodik_siswa.nama_siswa");

		$cekdata=(isset($_GET['cekdata']))?$_GET['cekdata']:"";

		if($cekdata==""){
			//Tampil data siswa
			
			$no=1;	
			while($Hasil=mysql_fetch_array($Q)){
				NgambilData("select * from dapodik_siswa where nis={$Hasil['nis']}");
				$NamaKelas=$Hasil['nama_kelas'];

				if($noregaktalahir==""){$tnoregaktalahir="";}else{$tnoregaktalahir="<i class='fa fa-check-square-o text-danger'></i>";}
				if($alamat==""){$talamat="";}else{$talamat="<i class='fa fa-check-square-o text-danger'></i>";}
				if($norumah==""){$tnorumah="";}else{$tnorumah="<i class='fa fa-check-square-o text-danger'></i>";}
				if($rt==""){$trt="";}else{$trt="<i class='fa fa-check-square-o text-danger'></i>";}
				if($rw==""){$trw="";}else{$trw="<i class='fa fa-check-square-o text-danger'></i>";}
				if($dusun==""){$tdusun="";}else{$tdusun="<i class='fa fa-check-square-o text-danger'></i>";}
				if($desa==""){$tdesa="";}else{$tdesa="<i class='fa fa-check-square-o text-danger'></i>";}
				if($kec==""){$tkec="";}else{$tkec="<i class='fa fa-check-square-o text-danger'></i>";}
				if($kab==""){$tkab="";}else{$tkab="<i class='fa fa-check-square-o text-danger'></i>";}
				if($kodepos==""){$tkodepos="";}else{$tkodepos="<i class='fa fa-check-square-o text-danger'></i>";}

				$TampilDataAlamat.="
				<tr>
					<td class='text-center'>$no.</td>
					<td>{$Hasil['nama_siswa']}</td>
					<td>$tnoregaktalahir</td>
					<td>$talamat</td>
					<td>$tnorumah</td>
					<td>$trt</td>
					<td>$trw</td>
					<td>$tdusun</td>
					<td>$tdesa</td>
					<td>$tkec</td>
					<td>$tkab</td>
					<td>$tkodepos</td>
				</tr>";
				$no++;
			}

			$jmldata=mysql_num_rows($Q);	
			if($jmldata>0){
				$DtSiswa.=ButtonKembali("?page=$page");
				$DtSiswa.=$MenuPilihan;
				$DtSiswa.=JudulKolom(" $NamaKelas - Cek Alamat Siswa ","user-circle");
				$DtSiswa.="
					<table id='dt_basic' class='table table-striped table-bordered table-hover table-condensed' width='100%'>
						<thead>
							<tr>
								<th class='text-center' data-class='expand'>No.</th>
								<th class='text-center'>Nama Siswa</th>
								<th class='text-center' data-hide='phone'>Reg Akta Lahir</th>
								<th class='text-center' data-hide='phone'>Alamat</th>
								<th class='text-center' data-hide='phone'>No. Rmh</th>
								<th class='text-center' data-hide='phone'>RT</th>
								<th class='text-center' data-hide='phone'>RW</th>
								<th class='text-center' data-hide='phone'>Dusun</th>
								<th class='text-center' data-hide='phone'>Desa</th>
								<th class='text-center' data-hide='phone'>Kec</th>
								<th class='text-center' data-hide='phone'>Kab</th>
								<th class='text-center' data-hide='phone'>Kode Pos</th>
							</tr>
						</thead>
						<tbody>
							$TampilDataAlamat
						</tbody>
					</table>
				";
			}
			else 
			{
				$DtSiswa.="<p class='text-center'><img src='img/aa.png' width='100' height='231' border='0' alt=''></p><h1 class='text-center'><small class='text-danger slideInRight fast animated'><strong>$MassaKBM</strong> </small><br><small>Data Siswa belum ada, silakan hubungi Administrator.</small> </h1>";
			}

		}else if($cekdata=="ayahibu"){

			//Tampil data siswa
						
			$no=1;	
			while($Hasil=mysql_fetch_array($Q)){
				NgambilData("select * from dapodik_ortu where nis={$Hasil['nis']}");
				$NamaKelas=$Hasil['nama_kelas'];

				if($nm_ayah==""){$dnm_ayah="";}else{$dnm_ayah="<i class='fa fa-check-square-o text-danger'></i>";}
				if($nik_ayah==""){$dnik_ayah="";}else{$dnik_ayah="<i class='fa fa-check-square-o text-danger'></i>";}
				if($tahunlahir_ayah==""){$dtahunlahir_ayah="";}else{$dtahunlahir_ayah="<i class='fa fa-check-square-o text-danger'></i>";}
				if($pendidikan_ayah==""){$dpendidikan_ayah="";}else{$dpendidikan_ayah="<i class='fa fa-check-square-o text-danger'></i>";}
				if($pekerjaan_ayah==""){$dpekerjaan_ayah="";}else{$dpekerjaan_ayah="<i class='fa fa-check-square-o text-danger'></i>";}
				if($penghasilan_ayah==""){$dpenghasilan_ayah="";}else{$dpenghasilan_ayah="<i class='fa fa-check-square-o text-danger'></i>";}
				if($berkebutuhankhusus_ayah==""){$dberkebutuhankhusus_ayah="";}else{$dberkebutuhankhusus_ayah="<i class='fa fa-check-square-o text-danger'></i>";}

				if($nm_ibu==""){$dnm_ibu="";}else{$dnm_ibu="<i class='fa fa-check-square-o text-danger'></i>";}
				if($nik_ibu==""){$dnik_ibu="";}else{$dnik_ibu="<i class='fa fa-check-square-o text-danger'></i>";}
				if($tahunlahir_ibu==""){$dtahunlahir_ibu="";}else{$dtahunlahir_ibu="<i class='fa fa-check-square-o text-danger'></i>";}
				if($pendidikan_ibu==""){$dpendidikan_ibu="";}else{$dpendidikan_ibu="<i class='fa fa-check-square-o text-danger'></i>";}
				if($pekerjaan_ibu==""){$dpekerjaan_ibu="";}else{$dpekerjaan_ibu="<i class='fa fa-check-square-o text-danger'></i>";}
				if($penghasilan_ibu==""){$dpenghasilan_ibu="";}else{$dpenghasilan_ibu="<i class='fa fa-check-square-o text-danger'></i>";}
				if($berkebutuhankhusus_ibu==""){$dberkebutuhankhusus_ibu="";}else{$dberkebutuhankhusus_ibu="<i class='fa fa-check-square-o text-danger'></i>";}

				$TampilDataOrtu.="
				<tr>
					<td class='text-center'>$no.</td>
					<td>{$Hasil['nama_siswa']}</td>
					<td>$dnm_ayah</td>
					<td>$dnik_ayah</td>
					<td>$dtahunlahir_ayah</td>
					<td>$dpendidikan_ayah</td>
					<td>$dpekerjaan_ayah</td>
					<td>$dpenghasilan_ayah</td>
					<td>$dberkebutuhankhusus_ayah</td>
					<td>$dnm_ibu</td>
					<td>$dnik_ibu</td>
					<td>$dtahunlahir_ibu</td>
					<td>$dpendidikan_ibu</td>
					<td>$dpekerjaan_ibu</td>
					<td>$dpenghasilan_ibu</td>
					<td>$dberkebutuhankhusus_ibu</td>
				</tr>";
				$no++;
			}

			$jmldata=mysql_num_rows($Q);	
			if($jmldata>0){
				$DtSiswa.=ButtonKembali("?page=$page");
				$DtSiswa.=$MenuPilihan;
				$DtSiswa.=JudulKolom(" $NamaKelas - Cek Ayah Ibu Kandung","user-circle");
				$DtSiswa.="
					<code>Keterangan : L = Lahir, D = Pendidikan, K = Pekerjaan, H = Penghasilan, BK = Berkebutuhan Khusus;</code><br>
					<table id='dt_basic' class='table table-striped table-bordered table-hover table-condensed' width='100%'>
						<thead>
							<tr>
								<th class='text-center' data-class='expand'>No.</th>
								<th class='text-center'>Nama Siswa</th>
								<th class='text-center' data-hide='phone'>Nama Ayah</th>
								<th class='text-center' data-hide='phone'>NIK</th>
								<th class='text-center' data-hide='phone'>L</th>
								<th class='text-center' data-hide='phone'>D</th>
								<th class='text-center' data-hide='phone'>K</th>
								<th class='text-center' data-hide='phone'>H</th>
								<th class='text-center' data-hide='phone'>BK</th>
								<th class='text-center' data-hide='phone'>Nama Ibu</th>
								<th class='text-center' data-hide='phone'>NIK</th>
								<th class='text-center' data-hide='phone'>L</th>
								<th class='text-center' data-hide='phone'>D</th>
								<th class='text-center' data-hide='phone'>K</th>
								<th class='text-center' data-hide='phone'>H</th>
								<th class='text-center' data-hide='phone'>BK</th>
							</tr>
						</thead>
						<tbody>
							$TampilDataOrtu
						</tbody>
					</table>
				";
			}
			else 
			{
				$DtSiswa.="<p class='text-center'><img src='img/aa.png' width='100' height='231' border='0' alt=''></p><h1 class='text-center'><small class='text-danger slideInRight fast animated'><strong>$MassaKBM</strong> </small><br><small>Data Siswa belum ada, silakan hubungi Administrator.</small> </h1>";
			}


		}
		else if($cekdata=="ortuwali"){

			//Tampil data siswa
						
			$no=1;	
			while($Hasil=mysql_fetch_array($Q)){
				NgambilData("select * from dapodik_ortu where nis={$Hasil['nis']}");
				$NamaKelas=$Hasil['nama_kelas'];

				if($nm_wali==""){$dnm_wali="";}else{$dnm_wali="<i class='fa fa-check-square-o text-danger'></i>";}
				if($nik_wali==""){$dnik_wali="";}else{$dnik_wali="<i class='fa fa-check-square-o text-danger'></i>";}
				if($tahunlahir_wali==""){$dtahunlahir_wali="";}else{$dtahunlahir_wali="<i class='fa fa-check-square-o text-danger'></i>";}
				if($pendidikan_wali==""){$dpendidikan_wali="";}else{$dpendidikan_wali="<i class='fa fa-check-square-o text-danger'></i>";}
				if($pekerjaan_wali==""){$dpekerjaan_wali="";}else{$dpekerjaan_wali="<i class='fa fa-check-square-o text-danger'></i>";}
				if($penghasilan_wali==""){$dpenghasilan_wali="";}else{$dpenghasilan_wali="<i class='fa fa-check-square-o text-danger'></i>";}
				if($berkebutuhankhusus_wali==""){$dberkebutuhankhusus_wali="";}else{$dberkebutuhankhusus_wali="<i class='fa fa-check-square-o text-danger'></i>";}


				$TampilDataOrtu.="
				<tr>
					<td class='text-center'>$no.</td>
					<td>{$Hasil['nama_siswa']}</td>
					<td>$dnm_wali</td>
					<td>$dnik_wali</td>
					<td>$dtahunlahir_wali</td>
					<td>$dpendidikan_wali</td>
					<td>$dpekerjaan_wali</td>
					<td>$dpenghasilan_wali</td>
				</tr>";
				$no++;
			}

			$jmldata=mysql_num_rows($Q);	
			if($jmldata>0){
				$DtSiswa.=ButtonKembali("?page=$page");
				$DtSiswa.=$MenuPilihan;
				$DtSiswa.=JudulKolom("$NamaKelas - Cek Wali Siswa","user-circle");
				$DtSiswa.="
					<code>Keterangan : L = Lahir, D = Pendidikan, K = Pekerjaan, H = Penghasilan, BK = Berkebutuhan Khusus;</code><br>

					<table id='dt_basic' class='table table-striped table-bordered table-hover table-condensed' width='100%'>
						<thead>
							<tr>
								<th class='text-center' data-class='expand'>No.</th>
								<th class='text-center'>Nama Siswa</th>
								<th class='text-center' data-hide='phone'>Nama Wali</th>
								<th class='text-center' data-hide='phone'>NIK</th>
								<th class='text-center' data-hide='phone'>L</th>
								<th class='text-center' data-hide='phone'>D</th>
								<th class='text-center' data-hide='phone'>K</th>
								<th class='text-center' data-hide='phone'>H</th>
							</tr>
						</thead>
						<tbody>
							$TampilDataOrtu
						</tbody>
					</table>
				";
			}
			else 
			{
				$DtSiswa.="<p class='text-center'><img src='img/aa.png' width='100' height='231' border='0' alt=''></p><h1 class='text-center'><small class='text-danger slideInRight fast animated'><strong>$MassaKBM</strong> </small><br><small>Data Siswa belum ada, silakan hubungi Administrator.</small> </h1>";
			}


		}
		else if($cekdata=="regperiodiksiswa"){

			//Tampil data siswa
						
			$no=1;	
			while($Hasil=mysql_fetch_array($Q)){
				$NamaKelas=$Hasil['nama_kelas'];

				NgambilData("select * from dapodik_registrasi where nis={$Hasil['nis']}");

				if($sekolahasal==""){$dsekolahasal="";}else{$dsekolahasal="<i class='fa fa-check-square-o text-danger'></i>";}
				if($nomorpesertaun=="0-00-00-00-000-000-0"){$dnomorpesertaun="";}else{$dnomorpesertaun="<i class='fa fa-check-square-o text-danger'></i>";}
				if($noseriijazah==""){$dnoseriijazah="";}else{$dnoseriijazah="<i class='fa fa-check-square-o text-danger'></i>";}
				if($noskhun==""){$dnoskhun="";}else{$dnoskhun="<i class='fa fa-check-square-o text-danger'></i>";}


				NgambilData("select * from dapodik_periodik where nis={$Hasil['nis']}");

				if($tinggibadan==""){$dtinggibadan="";}else{$dtinggibadan="<i class='fa fa-check-square-o text-danger'></i>";}
				if($beratbadan==""){$dberatbadan="";}else{$dberatbadan="<i class='fa fa-check-square-o text-danger'></i>";}
				if($jarakdlmkm==""){$djarakdlmkm="";}else{$djarakdlmkm="<i class='fa fa-check-square-o text-danger'></i>";}
				if($jamtempuh==""){$djamtempuh="";}else{$djamtempuh="<i class='fa fa-check-square-o text-danger'></i>";}
				if($menittempuh==""){$dmenittempuh="";}else{$dmenittempuh="<i class='fa fa-check-square-o text-danger'></i>";}
				if($saudarakandung==""){$dsaudarakandung="";}else{$dsaudarakandung="<i class='fa fa-check-square-o text-danger'></i>";}


				$TampilDataReg.="
				<tr>
					<td class='text-center'>$no.</td>
					<td>{$Hasil['nama_siswa']}</td>
					<td>$dsekolahasal</td>
					<td>$dnomorpesertaun</td>
					<td>$dnoseriijazah</td>
					<td>$dnoskhun</td>
					<td>$dtinggibadan</td>
					<td>$dberatbadan</td>
					<td>$djarakdlmkm</td>
					<td>$djamtempuh</td>
					<td>$dmenittempuh</td>
					<td>$dsaudarakandung</td>

				</tr>";
				$no++;
			}

			$jmldata=mysql_num_rows($Q);	
			if($jmldata>0){
				$DtSiswa.=ButtonKembali("?page=$page");
				$DtSiswa.=$MenuPilihan;
				$DtSiswa.=JudulKolom("$NamaKelas - Cek Registrasi dan Periodik","user-circle");
				$DtSiswa.="
					<table id='dt_basic' class='table table-striped table-bordered table-hover table-condensed' width='100%'>
						<thead>
							<tr>
								<th class='text-center' data-class='expand'>No.</th>
								<th class='text-center'>Nama Siswa</th>
								<th class='text-center' data-hide='phone'>Sklh Asal</th>
								<th class='text-center' data-hide='phone'>UN</th>
								<th class='text-center' data-hide='phone'>Ijazah</th>
								<th class='text-center' data-hide='phone'>SKHUN</th>
								<th class='text-center' data-hide='phone'>TB</th>
								<th class='text-center' data-hide='phone'>BB</th>
								<th class='text-center' data-hide='phone'>JKM</th>
								<th class='text-center' data-hide='phone'>Jam</th>
								<th class='text-center' data-hide='phone'>Menit</th>
								<th class='text-center' data-hide='phone'>SKandung</th>
							</tr>
						</thead>
						<tbody>
							$TampilDataReg
						</tbody>
					</table>
				";
			}
			else 
			{
				$DtSiswa.="<p class='text-center'><img src='img/aa.png' width='100' height='231' border='0' alt=''></p><h1 class='text-center'><small class='text-danger slideInRight fast animated'><strong>$MassaKBM</strong> </small><br><small>Data Siswa belum ada, silakan hubungi Administrator.</small> </h1>";
			}


		}

		//$Show.=ButtonKembali("?page=$page");
		//$Show.=JudulKolom("Cek Dapodik Siswa $NamaKelas","check-square");

		$Show.="$DtSiswa";
		
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
<script src="<?php echo ASSETS_URL; ?>/js/plugin/jquery-form/jquery-form.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
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