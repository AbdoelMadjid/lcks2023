<?php
require_once("inc/init.php");
require_once("inc/config.ui.php");
$page_title = "Peserta Didik";
$page_css[] = "your_style.css";
include("inc/header.php");
$page_nav["akademik"]["sub"]["pesertadidik"]["active"] = true;
include("inc/nav.php");
echo "<div id='main' role='main'>";
$breadcrumbs["Akademik"] = "Perkelas";
include("inc/ribbon.php");	
$sub=(isset($_GET['sub']))?$_GET['sub']:"";
switch($sub)
{
	case "tampil":default:
		$tamasuk=isset($_GET['tamasuk'])?$_GET['tamasuk']:"";
		$kd_pk=isset($_GET['kd_pk'])?$_GET['kd_pk']:"";

		$FormPilih.="
		<form action='?page=$page' method='post' name='frmPilih' class='form-inline' role='form'>
			<div class='row'>
				<div class='col-sm-12 col-md-8'>
					<div class='form-group'>Pililh Data &nbsp;&nbsp;</div>";		
						$FormPilih.=FormCF("inline","Tahun Masuk","txtTMasuk","select * from siswa_biodata where tahunmasuk group by tahunmasuk","tahunmasuk",$tamasuk,"tahunmasuk","","onchange=\"document.location.href='?page=$page&tamasuk='+document.frmPilih.txtTMasuk.value\"");
						if(!empty($_GET['tamasuk'])){
							$FormPilih.=FormCF("inline","Paket Keahlian","txtPK","select ak_paketkeahlian.kode_pk,ak_paketkeahlian.nama_paket from ak_paketkeahlian inner join siswa_biodata on ak_paketkeahlian.kode_pk=siswa_biodata.kode_paket where siswa_biodata.tahunmasuk='$tamasuk' group by siswa_biodata.kode_paket","kode_pk",$kd_pk,"nama_paket","","onchange=\"document.location.href='?page=$page&tamasuk='+document.frmPilih.txtTMasuk.value+'&kd_pk='+document.frmPilih.txtPK.value\"");
						}
		$FormPilih.="
				</div>
				<div class='col-sm-12 col-md-4'>
				<a href='?page=$page&sub=tambah' title='Tambah Peserta Didik' style='margin-left:10px;' class='btn btn-info btn-sm pull-right'><i class='fa fa-plus'></i> Tambah Peserta Didik</a> 
				<a href='?page=akademik-peserta-didik-perkelas' title='Siswa Perkelas' class='btn btn-info btn-sm pull-right'><i class='fa fa-users'></i> Siswa Per Kelas</a>
				</div>
			</div>
		</form>";

		if(!empty($_GET['tamasuk'])){$wh=" and siswa_biodata.tahunmasuk='$tamasuk' ";}else{$wh="  and siswa_biodata.tahunmasuk='0'  ";} 
		if(!empty($_GET['kd_pk'])){$wh=" and siswa_biodata.kode_paket='$kd_pk' ";}
		if(!empty($_GET['tamasuk']) && !empty($_GET['kd_pk'])){$wh=" and siswa_biodata.kode_paket='$kd_pk' and siswa_biodata.tahunmasuk='$tamasuk' ";}

		$Q="select siswa_biodata.nis,siswa_biodata.nm_siswa,siswa_biodata.tahunmasuk,siswa_biodata.kode_paket,ak_paketkeahlian.nama_paket,ak_paketkeahlian.singkatan from siswa_biodata, ak_paketkeahlian where siswa_biodata.kode_paket=ak_paketkeahlian.kode_pk $wh";
		$no=1;
		$Query=mysql_query("$Q order by siswa_biodata.kode_paket,siswa_biodata.tahunmasuk,siswa_biodata.nis asc");
		while($Hasil=mysql_fetch_array($Query)){
			$NamaPK=$Hasil['nama_paket'];
			$QPass=mysql_query("Select * from app_user_siswa where nis='{$Hasil['nis']}'");
			$HPass=mysql_fetch_array($QPass);

			$QKlsX=mysql_query("Select * from ak_perkelas where tk='X' and nis='{$Hasil['nis']}'");
			$HKlsX=mysql_fetch_array($QKlsX);

			$QKlsXI=mysql_query("Select * from ak_perkelas where tk='XI' and nis='{$Hasil['nis']}'");
			$HKlsXI=mysql_fetch_array($QKlsXI);

			$QKlsXII=mysql_query("Select * from ak_perkelas where tk='XII' and nis='{$Hasil['nis']}'");
			$HKlsXII=mysql_fetch_array($QKlsXII);

			$TampilData.="
			<tr>
				<td class='text-center'>$no.</td>
				<td>{$Hasil['nis']}</td>
				<td><a href='?page=$page&sub=edit&tamasuk=$tamasuk&kd_pk=$kd_pk&NIS={$Hasil['nis']}'>{$Hasil['nm_siswa']}</a></td>
				<td>{$Hasil['tahunmasuk']}</td>
				<td>{$HKlsX['tahunajaran']}<br><code>{$HKlsX['nm_kelas']}</code></td>
				<td>{$HKlsXI['tahunajaran']}<br><code>{$HKlsXI['nm_kelas']}</code></td>
				<td>{$HKlsXII['tahunajaran']}<br><code>{$HKlsXII['nm_kelas']}</code></td>
				<td>{$Hasil['kode_paket']} - {$Hasil['singkatan']}</td>
				<td>{$HPass['ket']}</td>
				<td class='text-center'><a href='?page=$page&sub=hapus&NIS={$Hasil['nis']}' data-action='hapussiswa' data-hapussiswa-msg=\"Apakah Anda yakin akan mengapus siswa bernama <strong class='txt-color-orangeDark'>{$Hasil['nm_siswa']}</strong>\"><i class='txt-color-red fa fa-trash-o font-lg'></i></a></td>
			</tr>";
			$no++;
		}
		$jmldata=mysql_num_rows($Query);
		if($jmldata>0){
			if(!empty($_GET['tamasuk'])){$Infona.="<span class='label bg-color-redLight'>Tahun Masuk {$tamasuk}</span> ";}
			if(!empty($_GET['kd_pk'])){$Infona.="<span class='label bg-color-redLight'>Paket Keahlian {$NamaPK}</span>";}
			if($tamasuk=="" || $kd_pk==""){
				$GnrUserSiswa.="";}else{$GnrUserSiswa.="<a href='?page=$page&sub=generateusersiswa&kdpk=$kd_pk&thnmasuk=$tamasuk' title='Generate User Siswa' class='pull-right'><i class='fa fa-print fa-border'></i> Generate User Siswa</a>  <a href='?page=$page&sub=hapususersiswa&kdpk=$kd_pk&thnmasuk=$tamasuk' title='Hapus User Siswa' class='pull-right'><i class='fa fa-trash fa-border'></i> Hapus User Siswa</a>";}
				
			$Show.=KolomPanel($FormPilih);
			
			$Show.="<h6 class='txt-color-red'>MOHON DIPERHATIKAN !!</h6> <small>Jika SISWA di hapus, maka akan menghapus seluruh data yang berkaitan dengan SISWA yang di HAPUS.<br>PASTIKAN TIDAK ADA DATA yang berkaitan dengan SISWA</small><hr>";
			$Show.="$Infona <span class='label bg-color-redLight'>Total <em>$jmldata (".terbilang($jmldata).")</em> orang</span><br>$GnrUserSiswa<br><br>";
			$Show.="
			<div class='well no-padding'>
				<table id='dt_basic' class='table table-striped table-bordered table-hover table-condensed' width='100%'>
					<thead>
						<tr>
							<th class='text-center' data-class='expand'>No.</th>
							<th class='text-center' data-hide='phone'>NIS</th>
							<th>Nama Siswa</th>
							<th class='text-center' data-hide='phone'>Masuk</th>
							<th class='text-center' data-hide='phone'>X</th>
							<th class='text-center' data-hide='phone'>XI</th>
							<th class='text-center' data-hide='phone'>XII</th>
							<th class='text-center' data-hide='phone'>Paket Keahlian</th>
							<th class='text-center' data-hide='phone'>Password</th>
							<th class='text-center'>Hapus</th>
						</tr>
					</thead>
					<tbody>$TampilData</tbody>
				</table>
			</div>";
		}
		else{			
			$Show.=KolomPanel($FormPilih);
			$Show.=KolomPanel("<h1 class='text-center text-danger'><strong><i class='fa fa-exclamation-triangle fa-lg'></i></h1><h4 class='text-center text-info'>Pilih Tahun Masuk!!</strong></h4>");
		}
		$tandamodal="#DataPD";
		echo $DataPD;
		echo MyWidget('fa-meh-o',"Daftar Peserta Didik","",$Show);
	break;

	case "tambah":
		$IsiForm.="<script>function hitAlamatOrtu(){Blok=document.frmsiswa.txtAlBlok.value;Nomor=document.frmsiswa.txtAlNo.value;RT=document.frmsiswa.txtAlRT.value;RW=document.frmsiswa.txtAlRW.value;Desa=document.frmsiswa.txtAlDesa.value;Kec=document.frmsiswa.txtAlKec.value;Kab=document.frmsiswa.txtAlKab.value;KPos=document.frmsiswa.txtAlKPos.value;document.frmsiswa.txtAlBlokOT.value=Blok;document.frmsiswa.txtAlNoOT.value=Nomor;document.frmsiswa.txtAlRTOT.value=RT;document.frmsiswa.txtAlRWOT.value=RW;document.frmsiswa.txtAlDesaOT.value=Desa;document.frmsiswa.txtAlKecOT.value=Kec;document.frmsiswa.txtAlKabOT.value=Kab;document.frmsiswa.txtAlKPosOT.value=KPos;}
		function hitAlamatWali(){Blok=document.frmsiswa.txtAlBlok.value;Nomor=document.frmsiswa.txtAlNo.value;RT=document.frmsiswa.txtAlRT.value;RW=document.frmsiswa.txtAlRW.value;Desa=document.frmsiswa.txtAlDesa.value;Kec=document.frmsiswa.txtAlKec.value;Kab=document.frmsiswa.txtAlKab.value;KPos=document.frmsiswa.txtAlKPos.value;document.frmsiswa.txtAlBlokW.value=Blok;document.frmsiswa.txtAlNoW.value=Nomor;document.frmsiswa.txtAlRTW.value=RT;document.frmsiswa.txtAlRWW.value=RW;document.frmsiswa.txtAlDesaW.value=Desa;document.frmsiswa.txtAlKecW.value=Kec;document.frmsiswa.txtAlKabW.value=Kab;document.frmsiswa.txtAlKPosW.value=KPos;}</script>";
		$BioSiswa.='<fieldset>';
		$BioSiswa.=JudulKolom("Biodata Siswa","");
		$BioSiswa.='<br>';
		$BioSiswa.=FormIF("horizontal","NIS","txtNIS","",'4',"");
		$BioSiswa.=FormIF("horizontal","NISN","txtNISN","",'4',"");
		$BioSiswa.=FormCR("horizontal",'Tahun Masuk','txtTahunMasuk',$tahunmasuk,$Ref->TahunMasuk,'4',"");
		$BioSiswa.=FormCF("horizontal",'Paket Keahlian','txtKodePK','select * from ak_paketkeahlian','kode_pk',$kode_pk,'nama_paket','6',"");
		$BioSiswa.=FormIF("horizontal","Nama","txtNama","",'8',"");
		$BioSiswa.=FormIF("horizontal","Tempat Lahir","txtTmpLahir","",'6',"");
		$BioSiswa.=IsiTgl('Tanggal Lahir','txtTglLahir','txtBlnLahir','txtThnLahir',"",1990);
		$BioSiswa.=FormCR("horizontal",'Jenis Kelamin','txtJenKel',$jenis_kelamin,$Ref->Gender,'4',"");
		$BioSiswa.=FormCR("horizontal",'Agama','txtAgama',$agama,$Ref->Agama,'4',"");
		$BioSiswa.=FormCR("horizontal",'Status dalam Keluarga','txtStatKel',$status_dalam_kel,$Ref->StatKel,'4',"");
		$BioSiswa.=FormCR("horizontal",'Anak Ke','txtAnakKe',$anak_ke,$Ref->Semester,'4',"");
		$BioSiswa.=FormIF("horizontal","Telepon","txtTelp","",'5',"");
		$BioSiswa.=FormIF("horizontal","Sekolah Asal SMP/MTs","txtSekolAsal","",'6',"");
		$BioSiswa.=FormCR("horizontal",'Di Terima di kelas','txtDiterimaKls',$diterima_kelas,$Ref->TingkatKls,'4',"");
		$BioSiswa.=IsiTgl('Tanggal Diterima','txtTglDiterima','txtBlnDiterima','txtThnDiterima',"",2013);
		$BioSiswa.=FormCR("horizontal",'Asal Siswa','txtAsalSiswa',$asalsiswa,$Ref->AsalSiswa,'5',"");
		$BioSiswa.=FormIF("horizontal","Alasan Pindahan","txtKetPindah","",'8',"");
		$BioSiswa.='</fieldset>';
		$AlSiswa.='<fieldset>';
		$AlSiswa.=JudulKolom("Alamat Siswa","");
		$AlSiswa.='<br>';
		$AlSiswa.=FormIF("horizontal","Blok/Dusun","txtAlBlok","",'4',"");
		$AlSiswa.=FormIF("horizontal","Nomor","txtAlNo","",'3',"");
		$AlSiswa.=FormIF("horizontal","RT","txtAlRT","",'3',"");
		$AlSiswa.=FormIF("horizontal","RW","txtAlRW","",'3',"");
		$AlSiswa.=FormIF("horizontal","Desa","txtAlDesa","",'6',"");
		$AlSiswa.=FormIF("horizontal","Kecamatan","txtAlKec","",'6',"");
		$AlSiswa.=FormIF("horizontal","Kabupaten","txtAlKab","",'6',"");
		$AlSiswa.=FormIF("horizontal","Kode Pos","txtAlKPos","",'3',"");
		$AlSiswa.='</fieldset>';
		$BioOrtu.='<fieldset>';
		$BioOrtu.=JudulKolom("Biodata Orang Tua","");
		$BioOrtu.='<br>';
		$BioOrtu.=FormIF("horizontal","Nama Ayah","txtNmAyah","",'7',"");
		$BioOrtu.=FormIF("horizontal","Nama Ibu","txtNmIbu","",'7',"");
		$BioOrtu.=FormCR("horizontal",'Pekerjaan Ayah','txtKerjaAyah',$pekerjaan_ayah,$Ref->Pekerjaan,'4',"");
		$BioOrtu.=FormCR("horizontal",'Pekerjaan IBU','txtKerjaIbu',$pekerjaan_ibu,$Ref->Pekerjaan,'4',"");
		$BioOrtu.=FormIF("horizontal","Telepon","txtTelpOT","",'4',"");
		$BioOrtu.='</fieldset>';
		$AlOrtu.='<fieldset>';
		$AlOrtu.=JudulKolom("Alamat Orang Tua","");
		$AlOrtu.='<br>';
		$AlOrtu.="<p><strong><i class='ace-icon fa fa-check'></i>Perhatikan!</strong>Alamat sama dengan siswa? &nbsp;&nbsp;&nbsp;<input class='btn btn-minier btn-info' type='button' value='&nbsp;&nbsp;Ya&nbsp;&nbsp;' onclick='hitAlamatOrtu()'></p>";
		$AlOrtu.='<br>';
		$AlOrtu.=FormIF("horizontal","Blok/Dusun","txtAlBlokOT","",'4',"");
		$AlOrtu.=FormIF("horizontal","Nomor","txtAlNoOT","",'3',"");
		$AlOrtu.=FormIF("horizontal","RT","txtAlRTOT","",'3',"");
		$AlOrtu.=FormIF("horizontal","RW","txtAlRWOT","",'3',"");
		$AlOrtu.=FormIF("horizontal","Desa","txtAlDesaOT","",'6',"");
		$AlOrtu.=FormIF("horizontal","Kecamatan","txtAlKecOT","",'6',"");
		$AlOrtu.=FormIF("horizontal","Kabupaten","txtAlKabOT","",'6',"");
		$AlOrtu.=FormIF("horizontal","Kode Pos","txtAlKPosOT","",'3',"");
		$AlOrtu.='</fieldset>';
		$BioWali.='<fieldset>';
		$BioWali.=JudulKolom("Biodata Wali Murid","");
		$BioWali.='<br>';
		$BioWali.=FormIF("horizontal","Nama Wali","txtNmWali","",'6',"");
		$BioWali.=FormCR("horizontal",'Pekerjaan Wali','txtKerjaWali',$pekerjaan_wali,$Ref->Pekerjaan,'4',"");
		$BioWali.=FormIF("horizontal","Telepon","txtTelpW","",'4',"");
		$BioWali.='</fieldset>';
		$AlWali.='<fieldset>';
		$AlWali.=JudulKolom("Alamat Wali Murid","");
		$AlWali.='<br>';
		$AlWali.="<p><strong><i class='ace-icon fa fa-check'></i>Perhatikan!</strong>Alamat sama dengan siswa? &nbsp;&nbsp;&nbsp;<input class='btn btn-minier btn-info' type='button' value='&nbsp;&nbsp;Ya&nbsp;&nbsp;' onclick='hitAlamatWali()'></p>";		
		$AlWali.='<br>';
		$AlWali.=FormIF("horizontal","Blok/Dusun","txtAlBlokW","",'4',"");
		$AlWali.=FormIF("horizontal","Nomor","txtAlNoW","",'3',"");
		$AlWali.=FormIF("horizontal","RT","txtAlRTW","",'3',"");
		$AlWali.=FormIF("horizontal","RW","txtAlRWW","",'3',"");
		$AlWali.=FormIF("horizontal","Desa","txtAlDesaW","",'6',"");
		$AlWali.=FormIF("horizontal","Kecamatan","txtAlKecW","",'6',"");
		$AlWali.=FormIF("horizontal","Kabupaten","txtAlKabW","",'6',"");
		$AlWali.=FormIF("horizontal","Kode Pos","txtAlKPosW","",'3',"");
		$AlWali.='</fieldset>';
		$IsiForm.=DuaKolomD(6,KolomPanel($BioSiswa).KolomPanel($AlSiswa),6,KolomPanel($BioOrtu).KolomPanel($AlOrtu).KolomPanel($BioWali).KolomPanel($AlWali));
		$IsiForm.="<input type='hidden' name='txtPhoto'>";
		$IsiForm.='<div class="form-actions">'.ButtonSimpan().'</div>';

		$Show.="<p>Menambah Peserta Didik bisa melalui impor Peserta Didik ke MYSQL di Menu <a href='?page=tools-excel-siswa' class='label bg-color-blue'>Tools <i class='fa fa-angle-double-right fa-fw'></i> Impor <i class='fa fa-angle-double-right fa-fw'></i> Peserta Didik</a></p>";
		$Show.=FormAing($IsiForm,"?page=$page&amp;sub=simpantambah","frmsiswa","");
		$tandamodal="#TambahPD";
		echo $TambahPD;
		echo MyWidget('fa-plus',"Tambah Peserta Didik",array(ButtonKembali("?page=$page&tamasuk=$tamasuk&kd_pk=$kd_pk")),$Show);
	break;

	case "simpantambah":
		$message=array();
		NgambilData("select * from siswa_biodata where nis='".trim($_POST['txtNIS'])."'");
		if(trim($_POST['txtNIS'])==$nis){$message[]="NIS sudah ada atas nama $nm_siswa!!";}
		if(trim($_POST['txtNIS'])==""){$message[]="NIS tidak boleh kosong !";}
		if(trim($_POST['txtNama'])==""){$message[]="Nama Siswa tidak boleh kosong !";}
		if(!count($message)==0){
			$Num=0;
			foreach($message as $indeks=>$pesan_tampil){
				$Num++;
				$Pesannya.="$Num. $pesan_tampil<br>";
			}
			echo Peringatan("$Pesannya","?page=$page&amp;sub=tambah");
		} 
		else{
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
			$txtAlBlok=addslashes($_POST['txtAlBlok']);
			$txtAlNo=addslashes($_POST['txtAlNo']);
			$txtAlRT=addslashes($_POST['txtAlRT']);
			$txtAlRW=addslashes($_POST['txtAlRW']);
			$txtAlDesa=addslashes($_POST['txtAlDesa']);
			$txtAlKec=addslashes($_POST['txtAlKec']);
			$txtAlKab=addslashes($_POST['txtAlKab']);
			$txtAlKPos=addslashes($_POST['txtAlKPos']);
			$txtNmAyah=addslashes($_POST['txtNmAyah']);
			$txtNmIbu=addslashes($_POST['txtNmIbu']);
			$txtKerjaAyah=addslashes($_POST['txtKerjaAyah']);
			$txtKerjaIbu=addslashes($_POST['txtKerjaIbu']);
			$txtTelpOT=addslashes($_POST['txtTelpOT']);
			$txtAlBlokOT=addslashes($_POST['txtAlBlokOT']);
			$txtAlNoOT=addslashes($_POST['txtAlNoOT']);
			$txtAlRTOT=addslashes($_POST['txtAlRTOT']);
			$txtAlRWOT=addslashes($_POST['txtAlRWOT']);
			$txtAlDesaOT=addslashes($_POST['txtAlDesaOT']);
			$txtAlKecOT=addslashes($_POST['txtAlKecOT']);
			$txtAlKabOT=addslashes($_POST['txtAlKabOT']);
			$txtAlKPosOT=addslashes($_POST['txtAlKPosOT']);
			$txtNmWali=addslashes($_POST['txtNmWali']);
			$txtKerjaWali=addslashes($_POST['txtKerjaWali']);
			$txtTelpW=addslashes($_POST['txtTelpW']);
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
			mysql_query("INSERT INTO siswa_biodata VALUES('$txtNIS','$txtNISN','$txtTahunMasuk','$txtKodePK','".htmlentities($txtNama,ENT_QUOTES)."','$txtTmpLahir','$TglLahirSiswa','$txtJenKel','$txtAgama','$txtStatKel','$txtAnakKe','$txtTelp','$txtSekolAsal','$txtDiterimaKls','$TglDiTerima','$txtAsalSiswa','$txtKetPindah','$txtPhoto')");
			//mysql_query("INSERT INTO user_siswa VALUES ('$txtNIS','".htmlentities($txtNama,ENT_QUOTES)."','$txtNIS',md5('$txtNIS'),'Siswa','$txtNIS')");
			mysql_query("INSERT INTO siswa_alamat VALUES ('$txtNIS','$txtAlBlok','$txtAlNo','$txtAlRT','$txtAlRW', '$txtAlDesa','$txtAlKec','$txtAlKab','$txtAlKPos')");
			if(trim($_POST['txtNmAyah'])=="") { }
			else{
				mysql_query("INSERT INTO siswa_ortu VALUES ('$txtNIS','".htmlentities($txtNmAyah,ENT_QUOTES)."','".htmlentities($txtNmIbu,ENT_QUOTES)."','$txtKerjaAyah','$txtKerjaIbu','$txtTelpOT')");
				mysql_query("INSERT INTO siswa_alamat_ortu VALUES ('$txtNIS','$txtAlBlokOT','$txtAlNoOT','$txtAlRTOT','$txtAlRWOT', '$txtAlDesaOT','$txtAlKecOT','$txtAlKabOT','$txtAlKPosOT')");
			}			
			if(trim($_POST['txtNmWali'])=="") { } 
			else{
				mysql_query("INSERT INTO siswa_wali VALUES ('$txtNIS','".htmlentities($txtNmWali,ENT_QUOTES)."','$txtKerjaWali','$txtTelpW')");
				mysql_query("INSERT INTO siswa_alamat_wali VALUES ('$txtNIS','$txtAlBlokW','$txtAlNoW','$txtAlRTW','$txtAlRWW', '$txtAlDesaW','$txtAlKecW','$txtAlKabW','$txtAlKPosW')");
			}
			echo ns("Nambah","parent.location='?page=$page'","Siswa bernama <span class='txt-color-orangeDark'><strong>$txtNama </strong></span>");
		}
	break;

	case "edit":
		$tamasuk=isset($_GET['tamasuk'])?$_GET['tamasuk']:"";
		$kd_pk=isset($_GET['kd_pk'])?$_GET['kd_pk']:"";
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
		$Show.=ButtonKembali("?page=$page&tamasuk=$tamasuk&kd_pk=$kd_pk");
		$Show.=JudulKolom("Edit Peserta Didik","edit");
		$Show.=FormAing($IsiForm,"?page=$page&amp;sub=simpanedit","frmsiswa");
		$tandamodal="#EditPD";
		echo $EditPD;
		echo MyWidget('fa-pencil-square-o',"Edit Peserta Didik",array(ButtonKembali("?page=$page&tamasuk=$tamasuk&kd_pk=$kd_pk")),$Show);
	break;

	case "simpanedit":
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
		mysql_query("UPDATE siswa_biodata SET nisn='$txtNISN',tahunmasuk='$txtTahunMasuk',kode_paket='$txtKodePK',nm_siswa='".htmlentities($txtNama,ENT_QUOTES)."',tempat_lahir='$txtTmpLahir',tanggal_lahir='$TglLahirSiswa',jenis_kelamin='$txtJenKel',agama='$txtAgama',status_dalam_kel='$txtStatKel',anak_ke='$txtAnakKe',telepon_siswa='$txtTelp',sekolah_asal='$txtSekolAsal',diterima_kelas='$txtDiterimaKls',diterima_tanggal='$TglDiTerima',asalsiswa='$txtAsalSiswa',keteranganpindah='$txtKetPindah',foto='$txtPhoto' WHERE nis='".$_POST['txtNIS']."'");
		mysql_query("UPDATE app_user_siswa SET nm_siswa='".htmlentities($txtNama,ENT_QUOTES)."' where nis='".$_POST['txtNIS']."'");
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
				mysql_query("UPDATE siswa_ortu SET nm_ayah='".htmlentities($txtNmAyah,ENT_QUOTES)."',nm_ibu='".htmlentities($txtNmIbu,ENT_QUOTES)."',pekerjaan_ayah='$txtKerjaAyah',pekerjaan_ibu='$txtKerjaIbu',telepon_ortu='$txtTelpOT' where nis='".$_POST['txtNIS']."'");
			}
			else{
				mysql_query("INSERT INTO siswa_ortu VALUES ('$txtNIS','".htmlentities($txtNmAyah,ENT_QUOTES)."','".htmlentities($txtNmIbu,ENT_QUOTES)."','$txtKerjaAyah','$txtKerjaIbu','$txtTelpOT')");
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
			$QBioW=mysql_query("select * from siswa_ortu where nis='".trim($_POST['txtNIS'])."'");
			$HBioW=mysql_fetch_array($QBioW);
			$QAlW=mysql_query("select * from siswa_alamat_ortu where nis='".trim($_POST['txtNIS'])."'");
			$HAlW=mysql_fetch_array($QAlW);
			if(mysql_num_rows($QBioW)>=1){ 
				mysql_query("UPDATE siswa_ortu SET nm_ayah='".htmlentities($txtNmAyah,ENT_QUOTES)."',nm_ibu='".htmlentities($txtNmIbu,ENT_QUOTES)."',pekerjaan_ayah='$txtKerjaAyah',pekerjaan_ibu='$txtKerjaIbu',telepon_ortu='$txtTelpOT' where nis='".$_POST['txtNIS']."'");
			}
			else{
				mysql_query("INSERT INTO siswa_wali VALUES ('$txtNIS','".htmlentities($txtNmWali,ENT_QUOTES)."','$txtKerjaWali','$txtTelpW')");
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

	case "hapus":
		if(empty($_GET['NIS'])){echo "<b>Data yang dihapus tidak ada</b>";}
		else {
			$QUserSiswa=mysql_query("DELETE FROM app_user_siswa WHERE nis='".$_GET['NIS']."'");
			$QBioSiswa=mysql_query("DELETE FROM siswa_biodata WHERE nis='".$_GET['NIS']."'");
			$QBioSiswaAlamat=mysql_query("DELETE FROM siswa_alamat WHERE nis='".$_GET['NIS']."'");
			$QBioSiswaOrtu=mysql_query("DELETE FROM siswa_ortu WHERE nis='".$_GET['NIS']."'");
			$QBioSiswaWali=mysql_query("DELETE FROM siswa_wali WHERE nis='".$_GET['NIS']."'");
			$QBioSiswaOrtuAlamat=mysql_query("DELETE FROM siswa_ortu_alamat WHERE nis='".$_GET['NIS']."'");
			$QBioSiswaWaliAlamat=mysql_query("DELETE FROM siswa_wali_alamat WHERE nis='".$_GET['NIS']."'");	
			echo ns("Hapus","parent.location='?page=$page'","Siswa bernama <span class='txt-color-orangeDark'><strong>$txtNama </strong></span>");
		}
	break;

	case "generateusersiswa":
		$kdpk=(isset($_GET['kdpk']))?$_GET['kdpk']:"";
		$thnmasuk=(isset($_GET['thnmasuk']))?$_GET['thnmasuk']:"";

		$QCheck=JmlDt("select * from app_user_siswa where kode_pk='$kdpk' and thnmasuk='$thnmasuk'");
		if($QCheck>0){
			echo '<div id="preloader"><div id="cssload"></div></div>';
			echo Peringatan("User Siswa SUDAH DI GENERATE. Silakan pilih yang lain","parent.location='?page=$page&tamasuk=$thnmasuk&kd_pk=$kdpk'");
		}
		else
		{
			$QSiswa=mysql_query("select * from siswa_biodata where kode_paket='$kdpk' and tahunmasuk='$thnmasuk'");
			while($DSiswa=mysql_fetch_array($QSiswa)){
				$acakpassword=genRndString();
				$Nisna=$DSiswa['nis'];
				mysql_query("INSERT INTO app_user_siswa VALUES ('$Nisna','$kdpk','$thnmasuk','$Nisna',md5('$acakpassword'),'Siswa','$acakpassword','0000-00-00 00:00:00','0000-00-00 00:00:00','0')");
			}

			echo '<div id="preloader"><div id="cssload"></div></div>';
			echo ns("Nambah","parent.location='?page=$page&tamasuk=$thnmasuk&kd_pk=$kdpk'","Generate User Siswa");
		}
	break;

	case "hapususersiswa":
		$kdpk=(isset($_GET['kdpk']))?$_GET['kdpk']:"";
		$thnmasuk=(isset($_GET['thnmasuk']))?$_GET['thnmasuk']:"";

		mysql_query("DELETE FROM app_user_siswa WHERE kode_pk='".$_GET['kdpk']."' and thnmasuk='".$_GET['thnmasuk']."'");
		echo '<div id="preloader"><div id="cssload"></div></div>';
		echo ns("Hapus","parent.location='?page=$page&tamasuk=$thnmasuk&kd_pk=$kdpk'","User Siswa");
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
		"hapussiswa":function(a){
			function b(){
				window.location=a.attr("href")
			}
			$.SmartMessageBox(
				{
					"title":"<i class='fa fa-question-circle txt-color-orangeDark'></i> <span class='txt-color-red'><strong>Konfirmasi Hapus</strong></span> ",
					"content":a.data("hapussiswa-msg"),
					"buttons":"[No][Yes]"
				},function(a){
					"Yes"==a&&($.root_.addClass("animated fadeOutUp"),setTimeout(b,1e3))
					}
		)}
	}
	$.root_.on("click",'[data-action="hapussiswa"]',function(b){var c=$(this);a.hapussiswa(c),b.preventDefault(),c=null});
	
	
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