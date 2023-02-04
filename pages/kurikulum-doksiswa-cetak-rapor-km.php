<?php
require_once("inc/init.php");
require_once("inc/config.ui.php");
$page_title = "Cetak Rapor";
$page_css[] = "your_style.css";
include("inc/header.php");
$page_nav["kurikulum"]["sub"]["dokumensiswa"]["sub"]["cetakrapor"]["active"] = true;
include("inc/nav.php");
echo "<div id='main' role='main'>";
$breadcrumbs["Kurikulum / Dokumen Siswa"] = "";
include("inc/ribbon.php");	
$sub=(isset($_GET['sub']))?$_GET['sub']:"";
switch($sub)
{
	case "tampil":default:
//===================================================================================================================[STYLE AND JAVA]
		$TampilCetak.="
		<script>
		function printContent(el){
			var restorepage=document.body.innerHTML;
			var printcontent=document.getElementById(el).innerHTML;
			document.body.innerHTML=printcontent;
			window.print();
			document.body.innerHTML=restorepage;
		}
		</script>";
		$TampilCetak.='
		<script src="js/plugin/jsbarcode/JsBarcode.all.min.js"></script>
		<script>
			Number.prototype.zeroPadding = function(){
				var ret = "" + this.valueOf();
				return ret.length == 1 ? "0" + ret : ret;
			};
		</script>';
		$semesterna=isset($_GET['semesterna'])?$_GET['semesterna']:"";
		$Milih1.=$_GET['semesterna']=="nomerhiji"?"selected":"";
		$Milih2.=$_GET['semesterna']=="nomerdua"?"selected":"";
		$Milih3.=$_GET['semesterna']=="nomertilu"?"selected":"";
		$Milih4.=$_GET['semesterna']=="nomeropat"?"selected":"";
		$Milih5.=$_GET['semesterna']=="nomerlema"?"selected":"";
		$Milih6.=$_GET['semesterna']=="nomergenep"?"selected":"";
		
		if($semesterna==""){
			$wk=" and wk_kelas_ttm.ganjilgenap='Ganjil' and ak_kelas.id_kls='$PilKelas1' ";
			$ws=" and ak_kelas.id_kls='$PilKelas1' ";
			$P1="$PilTA1";
			$P2="Ganjil";
		}else if($semesterna=="nomerhiji"){
			$wk=" and wk_kelas_ttm.ganjilgenap='Ganjil' and ak_kelas.id_kls='$PilKelas1' ";
			$ws=" and ak_kelas.id_kls='$PilKelas1' ";
			$P1="$PilTA1";
			$P2="Ganjil";
		}else 
		if($semesterna=="nomerdua"){
			$wk=" and wk_kelas_ttm.ganjilgenap='Genap' and ak_kelas.id_kls='$PilKelas1' ";
			$ws=" and ak_kelas.id_kls='$PilKelas1' ";
			$P1="$PilTA1";
			$P2="Genap";
		}else if($semesterna=="nomertilu"){
			$wk=" and wk_kelas_ttm.ganjilgenap='Ganjil' and ak_kelas.id_kls='$PilKelas2' ";
			$ws=" and ak_kelas.id_kls='$PilKelas2' ";
			$P1="$PilTA2";
			$P2="Ganjil";
		}else if($semesterna=="nomeropat"){
			$wk=" and wk_kelas_ttm.ganjilgenap='Genap' and ak_kelas.id_kls='$PilKelas2' ";
			$ws=" and ak_kelas.id_kls='$PilKelas2' ";
			$P1="$PilTA2";
			$P2="Genap";
		}else if($semesterna=="nomerlema"){
			$wk=" and wk_kelas_ttm.ganjilgenap='Ganjil' and ak_kelas.id_kls='$PilKelas3' ";
			$ws=" and ak_kelas.id_kls='$PilKelas3' ";
			$P1="$PilTA3";
			$P2="Ganjil";
		}else if($semesterna=="nomergenep"){
			$wk=" and wk_kelas_ttm.ganjilgenap='Genap' and ak_kelas.id_kls='$PilKelas3' ";
			$ws=" and ak_kelas.id_kls='$PilKelas3' ";
			$P1="$PilTA3";
			$P2="Genap";
		}
//=================================================================================================================[KUMPLIN DATABASE]
		$nis=isset($_GET['nis'])?$_GET['nis']:"";
		if(!empty($_GET['nis'])){$nisnya=" and siswa_biodata.nis='$nis' ";}
		$DLogoCover=mysql_query("select * from app_lembaga");
		$HLogoCover=mysql_fetch_array($DLogoCover);
		if($HLogoCover['status']=="Negeri")
			{
				$LogoCover .= "<img src='img/tutwurihandayani.png' width='161' height='160' border='0' alt=''>";
			}
			else
			{
				$LogoCover .= "<img src='img/favicon/".$HLogoCover['logo_sekolah']."' width='161' height='160' border='0' alt=''>";
			}
		$WK=mysql_query("
			select 
			ak_kelas.kode_kelas,
			ak_kelas.tahunajaran,
			ak_kelas.kode_pk,
			ak_kelas.tahunmasuk,
			ak_kelas.tingkat,
			ak_kelas.nama_kelas,
			ak_kelas.id_guru,
			ak_paketkeahlian.nama_paket,
			app_user_guru.nama_lengkap,
			app_user_guru.gelardepan,
			app_user_guru.gelarbelakang,
			app_user_guru.nip 
			from 
			ak_kelas,
			ak_paketkeahlian,
			app_user_guru 
			where 
			ak_kelas.kode_pk=ak_paketkeahlian.kode_pk and 
			ak_kelas.id_guru=app_user_guru.id_guru $ws");
		$HWK=mysql_fetch_array($WK);
		$QSis=mysql_query("
			select 
			ak_kelas.id_kls,
			ak_kelas.nama_kelas,
			ak_kelas.tahunajaran,
			siswa_biodata.nis,
			siswa_biodata.nm_siswa,
			siswa_biodata.tempat_lahir,
			siswa_biodata.tanggal_lahir 
			from 
			ak_kelas,
			siswa_biodata,
			ak_perkelas,
			ak_paketkeahlian
			where 
			ak_kelas.nama_kelas=ak_perkelas.nm_kelas and 
			ak_kelas.tahunajaran=ak_perkelas.tahunajaran and
			ak_perkelas.nis=siswa_biodata.nis and 
			siswa_biodata.kode_paket=ak_paketkeahlian.kode_pk $ws $nisnya order by siswa_biodata.nis");
		$HSisD=mysql_fetch_array($QSis);
		$QSiswa=mysql_query("
			select 
			siswa_biodata.nis,
			siswa_biodata.nm_siswa 
			from 
			ak_kelas,
			siswa_biodata,
			ak_perkelas
			where 
			ak_kelas.nama_kelas=ak_perkelas.nm_kelas and 
			ak_kelas.tahunajaran=ak_perkelas.tahunajaran and
			ak_perkelas.nis=siswa_biodata.nis $ws order by siswa_biodata.nis");		
		
		while ($HSis=mysql_fetch_array($QSiswa)){
			$Sel=$HSis['nis']==$_GET['nis']?"selected":"";
			$PilihSiswa.="<option $Sel value={$HSis['nis']}>{$HSis['nm_siswa']}</option>";}

		$QPKeh=mysql_query("SELECT 
			ak_kelas.id_kls,
			ak_kelas.kode_pk,
			ak_bidangkeahlian.nama_bidang,
			ak_programkeahlian.nama_program,
			ak_paketkeahlian.nama_paket,
			ak_paketkeahlian.singkatan 
			FROM 
			ak_kelas,
			ak_paketkeahlian, 
			ak_programkeahlian, 
			ak_bidangkeahlian 
			WHERE 
			ak_kelas.kode_pk=ak_paketkeahlian.kode_pk and 
			ak_bidangkeahlian.kode_bidang=ak_programkeahlian.kode_bidang AND 
			ak_programkeahlian.kode_program=ak_paketkeahlian.kode_program AND 
			ak_programkeahlian.kode_bidang=ak_paketkeahlian.kode_bidang $ws");
		$HPKeh=mysql_fetch_array($QPKeh);
		$IS=mysql_query("select * from app_lembaga");
		$HIS=mysql_fetch_array($IS);
		$BioSis=mysql_query("select * from siswa_biodata where nis='$nis'");
		$HBioSis=mysql_fetch_array($BioSis);
		$BioSisAl=mysql_query("select * from siswa_alamat where nis='$nis'");
		$HBioSisAl=mysql_fetch_array($BioSisAl);
		$JSiswaAl=mysql_num_rows($BioSisAl);
		$Ortu=mysql_query("select * from siswa_ortu where nis='$nis'");
		$HOrtu=mysql_fetch_array($Ortu);
		$OrtuAl=mysql_query("select * from siswa_alamat_ortu where nis='$nis'");
		$HOrtuAl=mysql_fetch_array($OrtuAl);
		$JOrtuAl=mysql_num_rows($OrtuAl);
		$Wali=mysql_query("select * from siswa_wali where nis='$nis'");
		$HWali=mysql_fetch_array($Wali);
		$WaliAl=mysql_query("select * from siswa_alamat_wali where nis='$nis'");
		$HWaliAl=mysql_fetch_array($WaliAl);
		$JWaliAl=mysql_num_rows($WaliAl);
		
		$thnditerima=substr($HBioSis['diterima_tanggal'],0,4);
		$Qkp=mysql_query("select * from ak_kepsek where taawal='$thnditerima' and smstr='Ganjil'");
		$Hkp=mysql_fetch_array($Qkp);
		$NamaKepsek=$Hkp['nama'];
		$NIPKepsek=$Hkp['nip'];
		$QKSGenap=mysql_query("select * from ak_kepsek where thnajaran='$P1' and smstr='Genap'");
		$HKSGenap=mysql_fetch_array($QKSGenap);
		$NamaKepsekG=$HKSGenap['nama'];
		$NIPKepsekG=$HKSGenap['nip'];
//============================================================================================================================[COVER]
		$JsBarcode .="<form name='formtgl'>
		<input type='hidden' name='thn' value='{$HIS['nm_sekolah']}'>
		<input type='hidden' name='bln' value='{$HBioSis['nis']}'>
		<input type='hidden' name='tgl' value='{$HBioSis['nm_siswa']}'>
		</form>
		";
		$JsBarcode .="
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
			height:40,
			fontSize:20
		});
		</script>";
		$cover.="
		<div id='cetak-cover' style='@page {size: A4;}'>
			<div class='table-responsive'>
			<table style='margin: 0 auto;width:100%;border-collapse:collapse;font:12px Times New Roman;'>
				<tr><td>$JsBarcode</td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td style='font-size:22px;text-align:center;'><strong>LAPORAN CAPAIAN KOMPETENSI SISWA</strong></th></tr>
				<tr><td style='font-size:22px;text-align:center;'><strong>SEKOLAH MENENGAH KEJURUAN</strong></td></tr>
				<tr><td style='font-size:22px;text-align:center;'><strong>( SMK )</strong></td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td style='font-size:16px;'>
					<table align='center'>
					<tr>
						<td>Bidang Keahlian</td>
						<td width='5%' align='center'>:</td>
						<td>{$HPKeh['nama_bidang']}</td>
					</tr>
					<tr>
						<td>Program Keahlian</td>
						<td width='5%' align='center'>:</td>
						<td>{$HPKeh['nama_program']}</td>
					</tr>
					<tr>
						<td>Paket Keahlian</td>
						<td width='5%' align='center'>:</td>
						<td>{$HPKeh['nama_paket']}</td>
					</tr>
					<tr>
						<td>Nama Sekolah</td>
						<td width='5%' align='center'>:</td>
						<td>{$HIS['nm_sekolah']}</td>
					</tr>
					<tr>
						<td valign='top'>Alamat Sekolah</td>
						<td width='5%' align='center' valign='top'>:</td>
						<td>{$HIS['alamat']} Desa/Kelurahan {$HIS['kelurahan']}<br>Kode Pos : {$HIS['kd_pos']} Telp. {$HIS['telepon']}</td>
					</tr>
					</table>				
				</td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td align=center>".$LogoCover."</td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td style='font-size:16px;text-align:center;'>Nama Siswa</td></tr>
				<tr><td style='font-size:18px;text-align:center;'><strong>{$HBioSis['nm_siswa']}</strong></td></tr>
				<tr><td style='font-size:16px;text-align:center;'>NIS : {$HBioSis['nis']}</td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td style='font-size:16px;text-align:center;'><strong>KEMENTRIAN PENDIDIKAN DAN KEBUDAYAAN</strong></td></tr>
				<tr><td style='font-size:16px;text-align:center;'><strong>REPUBLIK INDONESIA</strong></td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td>&nbsp;</td></tr>
			</table>
			</div>
		</div>";
//===================================================================================================================[PROFIL SEKOLAH]
		$IdentSekolah.="
		<div id='cetak-sekolah' style='@page {size: A4;}'>
			<img style=' position: absolute; padding: 250px 2px 15px -250px; margin-left:180px;margin-top:215px;' src='img/logosmktrans.png' border='0' alt=''>
			<div class='table-responsive'>
			<table style='margin: 0 auto;width:100%;border-collapse:collapse;font:16px Times New Roman;'>
				<tr><td class='text-center'>&nbsp;</td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td style='font-size:18px;text-align:center;'><strong>RAPOR SISWA</strong></td></tr>
				<tr><td style='font-size:18px;text-align:center;'><strong>SEKOLAH MENENGAH KEJURUAN</strong></td></tr>
				<tr><td style='font-size:18px;text-align:center;'><strong>( SMK )</strong></td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td align='center' width='50%'>
					<table align='center'>
					<tr>
						<td width='200'>Nama Sekolah</td>
						<td width='25'>:</td>
						<td>{$HIS['nm_sekolah']}</td>
					</tr>
					<tr><td colspan='3'>&nbsp;</td></tr>
					<tr>
						<td>NPSN</td>
						<td>:</td>
						<td>{$HIS['nisn']}</td>
					</tr>
					<tr><td colspan='3'>&nbsp;</td></tr>
					<tr>
						<td>NIS/NSS/NDS</td>
						<td>:</td>
						<td>{$HIS['nss']}</td>
					</tr>
					<tr><td colspan='3'>&nbsp;</td></tr>
					<tr>
						<td valign='top'>Alamat Sekolah</td>
						<td valign='top'>:</td>
						<td valign='top'>{$HIS['alamat']}</td>
					</tr>
					<tr><td colspan='3'>&nbsp;</td></tr>
					<tr>
						<td valign='top'></td>
						<td valign='top'></td>
						<td valign='top'>Kode Pos : {$HIS['kd_pos']} Telp. {$HIS['telepon']}</td>
					</tr>
					<tr><td colspan='3'>&nbsp;</td></tr>
					<tr>
						<td>Kelurahan</td>
						<td>:</td>
						<td>{$HIS['kelurahan']}</td>
					</tr>
					<tr><td colspan='3'>&nbsp;</td></tr>
					<tr>
						<td>Kecamatan</td>
						<td>:</td>
						<td>{$HIS['kecamatan']}</td>
					</tr>
					<tr><td colspan='3'>&nbsp;</td></tr>
					<tr>
						<td>Kota/Kabupaten</td>
						<td>:</td>
						<td>{$HIS['kab_kota']}</td>
					</tr>
					<tr><td colspan='3'>&nbsp;</td></tr>
					<tr>
						<td>Provinsi</td>
						<td>:</td>
						<td>{$HIS['propinsi']}</td>
					</tr>
					<tr><td colspan='3'>&nbsp;</td></tr>
					<tr>
						<td>Web Site</td>
						<td>:</td>
						<td>{$HIS['website']}</td>
					</tr>
					<tr><td colspan='3'>&nbsp;</td></tr>
					<tr>
						<td>Email</td>
						<td>:</td>
						<td>{$HIS['email']}</td>
					</tr>
					<tr><td colspan='3'>&nbsp;</td></tr>
					</table>
				</td></tr>
			</table>
			</div>
		</div>";
//=====================================================================================================================[PROFIL SISWA]
		if($HBioSis['anak_ke']==""){
			$anakke.="<td style='padding:4px 8px;'>&nbsp;</td>";
		}
		else{
			$anakke.="<td style='padding:4px 8px;'>{$HBioSis['anak_ke']} (".terbilang($HBioSis['anak_ke']).")</td>";
		}
		if($JSiswaAl==0){$alamatsiswa.="<td>&nbsp;</td>";
		}else{
			$alamatsiswa.="
			<td style='padding:4px 8px;'>Blok/Dusun {$HBioSisAl['blok']} RT/RW {$HBioSisAl['rt']}/{$HBioSisAl['rw']} <br> 
				Desa {$HBioSisAl['desa']} Kecamatan {$HBioSisAl['kec']}  <br>
				Kabupaten {$HBioSisAl['kab']} Kode Pos {$HBioSisAl['kodepos']} 
			</td>";
		}
		if($JOrtuAl==0){$alamatortu.="<td>&nbsp;</td>";
		}else{
			$alamatortu.="
			<td style='padding:4px 8px;'>Blok/Dusun {$HOrtuAl['blok']} RT/RW {$HOrtuAl['rt']}/{$HOrtuAl['rw']} <br> 
				Desa {$HOrtuAl['desa']} Kecamatan {$HOrtuAl['kec']}  <br>
				Kabupaten {$HOrtuAl['kab']} Kode Pos {$HOrtuAl['kodepos']} 
			</td>";
		}
		if($JWaliAl==0){$alamatwali.="<td>&nbsp;</td>";
		}else{
			$alamatwali.="
				<td style='padding:4px 8px;'>Blok/Dusun {$HWaliAl['blok']} RT/RW {$HWaliAl['rt']}/{$HWaliAl['rw']} <br> 
					Desa {$HWaliAl['desa']} Kecamatan {$HWaliAl['kec']}  <br>
					Kabupaten {$HWaliAl['kab']} Kode Pos {$HWaliAl['kodepos']} 
				</td>";
		}
		$QTTMa=mysql_query("select * from wk_kelas_ttm where kd_kls='".$HWK['kode_kelas']."' and ganjilgenap='{$P2}'");
		$HTTMa=mysql_fetch_array($QTTMa);
		$JHTMa=mysql_num_rows($QTTMa);
		$IdentSiswa="
		<div id='cetak-identsiswa'>
			<img style=' position: absolute; padding: 250px 2px 15px -250px; margin-left:180px;margin-top:215px;' src='img/logosmktrans.png' border='0' alt=''>
			<div class='table-responsive'>
			<table style='margin: 0 auto;width:100%;border-collapse:collapse;font:14px Times New Roman;'>
				<tr><td>&nbsp;</td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td style='font-size:18px;text-align:center;'><strong>KETERANGAN TENTANG DIRI SISWA</strong></td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td align='center' width='50%'>
					<table width:'500'>
					<tr>
						<td width='35' style='padding:4px 8px;'>1.</td>
						<td width='200' style='padding:4px 8px;'>Nama Siswa Lengkap</td>
						<td width='25' style='padding:4px 8px;'>:</td>
						<td style='padding:4px 8px;'>{$HBioSis['nm_siswa']}</td>
					</tr>
					<tr>
						<td style='padding:4px 8px;'>2.</td>
						<td style='padding:4px 8px;'>Nomor Induk/NISN</td>
						<td style='padding:4px 8px;'>:</td>
						<td style='padding:4px 8px;'>{$HBioSis['nis']}/{$HBioSis['nisn']}</td>
					</tr>
					<tr>
						<td style='padding:4px 8px;'>3.</td>
						<td style='padding:4px 8px;'>Tempat ,Tanggal Lahir</td>
						<td style='padding:4px 8px;'>:</td>
						<td style='padding:4px 8px;'>{$HBioSis['tempat_lahir']}, ".TglLengkap($HBioSis['tanggal_lahir'])."</td>
					</tr>
					<tr>
						<td style='padding:4px 8px;'>4.</td>
						<td style='padding:4px 8px;'>Jenis Kelamin</td>
						<td style='padding:4px 8px;'>:</td>
						<td style='padding:4px 8px;'>{$HBioSis['jenis_kelamin']}</td>
					</tr>
					<tr>
						<td style='padding:4px 8px;'>5.</td>
						<td style='padding:4px 8px;'>Agama</td>
						<td style='padding:4px 8px;'>:</td>
						<td style='padding:4px 8px;'>{$HBioSis['agama']}</td>
					</tr>
					<tr>
						<td style='padding:4px 8px;'>6.</td>
						<td style='padding:4px 8px;'>Status dalam Keluarga</td>
						<td style='padding:4px 8px;'>:</td>
						<td style='padding:4px 8px;'>{$HBioSis['status_dalam_kel']}</td>
					</tr>
					<tr>
						<td style='padding:4px 8px;'>7.</td>
						<td style='padding:4px 8px;'>Anak ke</td>
						<td style='padding:4px 8px;'>:</td>
						$anakke
					</tr>
					<tr>
						<td valign='top' style='padding:4px 8px;'>8.</td>
						<td valign='top' style='padding:4px 8px;'>Alamat Siswa</td>
						<td valign='top' style='padding:4px 8px;'>:</td>
						$alamatsiswa
					</tr>
					<tr>
						<td style='padding:4px 8px;'>9.</td>
						<td style='padding:4px 8px;'>Nomor Telepon Rumah</td>
						<td style='padding:4px 8px;'>:</td>
						<td style='padding:4px 8px;'>{$HBioSis['telepon_siswa']}</td>
					</tr>
					<tr>
						<td style='padding:4px 8px;'>10.</td>
						<td style='padding:4px 8px;'>Sekolah Asal</td>
						<td style='padding:4px 8px;'>:</td>
						<td style='padding:4px 8px;'>{$HBioSis['sekolah_asal']}</td>
					</tr>
					<tr>
						<td style='padding:4px 8px;'>11.</td>
						<td style='padding:4px 8px;'>Diterima di sekolah ini</td>
						<td style='padding:4px 8px;'>:</td>
						<td style='padding:4px 8px;'></td>
					</tr>
					<tr>
						<td style='padding:4px 8px;'></td>
						<td style='padding:4px 8px;'>Di kelas</td>
						<td style='padding:4px 8px;'>:</td>
						<td style='padding:4px 8px;'>{$HBioSis['diterima_kelas']}</td>
					</tr>
					<tr>
						<td style='padding:4px 8px;'></td>
						<td style='padding:4px 8px;'>Pada Tanggal</td>
						<td style='padding:4px 8px;'>:</td>
						<td style='padding:4px 8px;'>".TglLengkap($HBioSis['diterima_tanggal'])."</td>
					</tr>
					<tr>
						<td style='padding:4px 8px;'>12.</td>
						<td style='padding:4px 8px;'>Nama Orang Tua</td>
						<td style='padding:4px 8px;'>:</td>
						<td style='padding:4px 8px;'></td>
					</tr>
					<tr>
						<td style='padding:4px 8px;'></td>
						<td style='padding:4px 8px;'>a. Ayah</td>
						<td style='padding:4px 8px;'>:</td>
						<td style='padding:4px 8px;'>{$HOrtu['nm_ayah']}</td>
					</tr>
					<tr>
						<td style='padding:4px 8px;'></td>
						<td style='padding:4px 8px;'>a. Ibu</td>
						<td style='padding:4px 8px;'>:</td>
						<td style='padding:4px 8px;'>{$HOrtu['nm_ibu']}</td>
					</tr>
					<tr>
						<td valign='top' style='padding:4px 8px;'>13.</td>
						<td valign='top' style='padding:4px 8px;'>Alamat Orang Tua</td>
						<td valign='top' style='padding:4px 8px;'>:</td>
						$alamatortu
					</tr>
					<tr>
						<td style='padding:4px 8px;'></td>
						<td style='padding:4px 8px;'>Telepon Orang Tua</td>
						<td style='padding:4px 8px;'>:</td>
						<td style='padding:4px 8px;'>{$HOrtu['telepon_ortu']}</td>
					</tr>
					<tr>
						<td style='padding:4px 8px;'>14.</td>
						<td style='padding:4px 8px;'>Pekerjaan Orang Tua</td>
						<td style='padding:4px 8px;'>:</td>
						<td style='padding:4px 8px;'></td>
					</tr>
					<tr>
						<td style='padding:4px 8px;'></td>
						<td style='padding:4px 8px;'>a. Ayah</td>
						<td style='padding:4px 8px;'>:</td>
						<td style='padding:4px 8px;'>{$HOrtu['pekerjaan_ayah']}</td>
					</tr>
					<tr>
						<td style='padding:4px 8px;'></td>
						<td style='padding:4px 8px;'>a. Ibu</td>
						<td style='padding:4px 8px;'>:</td>
						<td style='padding:4px 8px;'>{$HOrtu['pekerjaan_ibu']}</td>
					</tr>
					<tr>
						<td style='padding:4px 8px;'>15.</td>
						<td style='padding:4px 8px;'>Nama Wali Siswa</td>
						<td style='padding:4px 8px;'>:</td>
						<td style='padding:4px 8px;'></td>
					</tr>
					<tr>
						<td valign='top' style='padding:4px 8px;'>16.</td>
						<td valign='top' style='padding:4px 8px;'>Alamat Wali Siswa</td>
						<td valign='top' style='padding:4px 8px;'>:</td>
						$alamatwali
					</tr>
					<tr>
						<td style='padding:4px 8px;'>17.</td>
						<td style='padding:4px 8px;'>Pekerjaan Wali Siswa</td>
						<td style='padding:4px 8px;'>:</td>
						<td style='padding:4px 8px;'></td>
					</tr>
					<tr><td colspan='4'>&nbsp;</td></tr>
					<tr>
						<td style='padding:4px 8px;'></td>
						<td style='padding:4px 8px;'></td>
						<td style='padding:4px 8px;'></td>
						<td style='padding:4px 8px;'>
							".$HTTMa['alamat'].", ".TglLengkap($HBioSis['diterima_tanggal'])."<br>
							Kepala Sekolah, 
							<!-- <p>&nbsp;</p> --><br><img src='img/ttdkepsek/nanabaru.png' style='position: relative;z-index: 1;top: 0px;' width='162' height='87' border='0' alt=''><br>
							<!-- <p>&nbsp;</p> -->
							<strong><!-- <p style='position: absolute;top: 20px;z-index: 2;'> -->$NamaKepsek<!-- </p> --></strong><br>
							NIP. $NIPKepsek
						</td>
					</tr>
					</table>
				</td></tr>
			</table>
			</div>
		</div>";
//=================================================================================================================[HALAMAN PETUNJUK]
		$Petunjuk="
		<div id='cetak-petunjuk'>
			<img style=' position: absolute; padding: 250px 2px 15px -250px; margin-left:180px;margin-top:215px;' src='img/logosmktrans.png' border='0' alt=''>
			<div class='table-responsive'>
			<table style='margin: 0 auto;width:100%;border-collapse:collapse;font:14px Times New Roman;'>
				<tr><td>&nbsp;</td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td style='font-size:18px;text-align:center;'><strong>PETUNJUK PENGISIAN</strong></td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td align='center' width='50%'>
					<table align='center' width='80%'>
						<tr>
							<td>
								<table>
								<tr>
									<td valign='top' style='padding:3px 6px;'>1.</td><td align='justify' style='padding:3px 6px;'>Rapor merupakan ringkasan hasil penilaian terhadap seluruh aktivitas pembelajaran yang dilakukan siswa dalam kurun waktu tertentu;</td>
								</tr>
								<tr>
									<td valign='top' style='padding:3px 6px;'>2.</td><td align='justify' style='padding:3px 6px;'>Rapor dipergunakan selama siswa yang bersangkutan mengikuti seluruh program pembelajaran di Sekolah Menengah Kejuruan tersebut;</td>
								</tr>
								<tr>
									<td valign='top' style='padding:3px 6px;'>3.</td><td align='justify' style='padding:3px 6px;'>Identitas Sekolah diisi dengan data yang sesuai dengan keberadaan Sekolah Menengah Kejuruan;</td>
								</tr>
								<tr>
									<td valign='top' style='padding:3px 6px;'>4.</td><td align='justify' style='padding:3px 6px;'>Keterangan tentang diri Siswa diisi lengkap;</td>
								</tr>
								<tr>
									<td valign='top' style='padding:3px 6px;'>5.</td><td align='justify' style='padding:3px 6px;'>Rapor harus dilengkapi dengan pas foto berwarna (3 x 4) dan pengisiannya dilakukan oleh Wali Kelas;</td>
								</tr>
								<tr>
									<td valign='top' style='padding:3px 6px;'>6.</td><td align='justify' style='padding:3px 6px;'>Deskripsi sikap spiritual diambil dari hasil observasi terutama pada mata pelajaran Pendidikan Agama dan Budi pekerti, dan PPKn;</td>
								</tr>
								<tr>
									<td valign='top' style='padding:3px 6px;'>7.</td><td align='justify' style='padding:3px 6px;'>Deskripsi sikap sosial diambil dari hasil observasi pada semua mata pelajaran;</td>
								</tr>
								<tr>
									<td valign='top' style='padding:3px 6px;'>8.</td><td align='justify' style='padding:3px 6px;'>Deskripsi pada kompetensi sikap ditulis dengan kalimat positif untuk aspek yang sangat baik atau Cukup baik;</td>
								</tr>
								<tr>
									<td valign='top' style='padding:3px 6px;'>9.</td><td align='justify' style='padding:3px 6px;'>Capaian siswa dalam kompetensi pengetahuan dan kompetensi keterampilan ditulis dalam bentuk angka, predikat dan deskripsi untuk masing-masing mata pelajaran;</td>
								</tr>
								<tr>
									<td valign='top' style='padding:3px 6px;'>10.</td><td align='justify' style='padding:3px 6px;'>Predikat ditulis dalam bentuk huruf sesuai kriteria;</td>
								</tr>
								<tr>
									<td valign='top' style='padding:3px 6px;'>11.</td><td align='justify' style='padding:3px 6px;'>Kolom KB (Ketuntasan Belajar) merupakan acuan bagi kriteria kenaikan kelas sehingga wali kelas wajib menerangkan konsekuensi ketuntasan belajar tersebut kepada orang tua/wali;</td>
								</tr>
								<tr>
									<td valign='top' style='padding:3px 6px;'>12.</td><td align='justify' style='padding:3px 6px;'>Deskripsi pada kompetensi pengetahuan dan kompetensi keterampilan ditulis dengan kalimat positif sesuai capaian tertinggi dan terendah yang diperoleh siswa. Apabila capaian kompetensi dasar yang diperoleh dalam muatan pelajaran itu sama, kolom deskripsi ditulis berdasarkan capaian yang diperoleh;</td>
								</tr>
								<tr>
									<td valign='top' style='padding:3px 6px;'>13.</td><td align='justify' style='padding:3px 6px;'>Laporan Praktik Kerja Lapangan diisi berdasarkan kegiatan praktik kerja yang diikuti oleh siswa di industri/perusahaan mitra;</td>
								</tr>
								<tr>
									<td valign='top' style='padding:3px 6px;'>14.</td><td align='justify' style='padding:3px 6px;'>Laporan Ekstrakurikuler diisi berdasarkan kegiatan ekstrakurikuler yang diikuti oleh siswa;</td>
								</tr>
								<tr>
									<td valign='top' style='padding:3px 6px;'>15.</td><td align='justify' style='padding:3px 6px;'>Saran-saran wali kelas diisi berdasarkan kegiatan yang perlu mendapatkan perhatian siswa;</td>
								</tr>
								<tr>
									<td valign='top' style='padding:3px 6px;'>16.</td><td align='justify' style='padding:3px 6px;'>Prestasi diisi dengan prestasi yang dicapai oleh siswa dalam bidang akademik dan non akademik;</td>
								</tr>
								<tr>
									<td valign='top' style='padding:3px 6px;'>17.</td><td align='justify' style='padding:3px 6px;'>Ketidakhadiran diisi dengan data akumulasi ketidakhadiran siswa karena sakit, izin, atau tanpa keterangan selama satu semester.</td>
								</tr>
								<tr>
									<td valign='top' style='padding:3px 6px;'>18.</td><td align='justify' style='padding:3px 6px;'>Tanggapan orang tua/wali adalah tanggapan atas pencapaian hasil belajar siswa;</td>
								</tr>
								<tr>
									<td valign='top' style='padding:3px 6px;'>19.</td><td align='justify' style='padding:3px 6px;'>Keterangan pindah keluar sekolah diisi dengan alasan kepindahan. Sedangkan pindah masuk diisi dengan sekolah asal.</td>
								</tr>
								<tr>
									<td valign='top' style='padding:3px 6px;'>21.</td><td align='justify' style='padding:3px 6px;'>Predikat capaian kompetensi :</td>
								</tr>
								<tr>
									<td valign='top' style='padding:3px 6px;'></td><td align='justify' style='padding:3px 6px;'>Sangat Baik (A) : 86 - 100</td>
								</tr>
								<tr>
									<td valign='top' style='padding:3px 6px;'></td><td align='justify' style='padding:3px 6px;'>Baik (B) : 71 - 85</td>
								</tr>
								<tr>
									<td valign='top' style='padding:3px 6px;'></td><td align='justify' style='padding:3px 6px;'>Cukup (C) : 56 - 70</td>
								</tr>
								<tr>
									<td valign='top' style='padding:3px 6px;'></td><td align='justify' style='padding:3px 6px;'>Kurang (D) : 0 - 55</td>
								</tr>
							</table>
							</td>
						</tr>
					</table>
				</td></tr>
			</table>
			</div>
		</div>";

//===========================================================================================================[NILAI RAPORT HALAMAN 1]
	//====================================================================================================================[DATA AWAL]
		$QMP="
		select 
		ak_kelas.id_kls,
		ak_kelas.kode_kelas,
		wk_kelas_ttm.semester,
		wk_kelas_ttm.ganjilgenap,
		ak_matapelajaran.kode_mapel,
		ak_matapelajaran.nama_mapel,
		ak_matapelajaran.kelompok,
		ak_matapelajaran.semester1,
		ak_matapelajaran.semester2,
		ak_matapelajaran.semester3,
		ak_matapelajaran.semester4,
		ak_matapelajaran.semester5,
		ak_matapelajaran.semester6 
		from 
		ak_kelas,
		wk_kelas_ttm,
		ak_matapelajaran 
		where 
		ak_kelas.kode_kelas=wk_kelas_ttm.kd_kls and
		ak_kelas.kode_pk=ak_matapelajaran.kode_pk $wk ";
		
		$HQMP=mysql_fetch_array(mysql_query($QMP));
		$SemesterWK=$HQMP['semester']; 
		if($HQMP['semester']==1){$mapelsmtr=" and semester1='1' ";}else 
		if($HQMP['semester']==2){$mapelsmtr=" and semester2='1' ";}else 
		if($HQMP['semester']==3){$mapelsmtr=" and semester3='1' ";}else 
		if($HQMP['semester']==4){$mapelsmtr=" and semester4='1' ";}else 
		if($HQMP['semester']==5){$mapelsmtr=" and semester5='1' ";}else 
		if($HQMP['semester']==6){$mapelsmtr=" and semester6='1' ";}
	//=============================================================================================================[NILAI KELOMPOK A]
		$QMP_A=mysql_query("$QMP and ak_matapelajaran.kelompok='A' $mapelsmtr order by ak_matapelajaran.kode_mapel");
		$jmlMPA=mysql_num_rows($QMP_A);
		$NoMPA=1;
		
		while($HMP_A=mysql_fetch_array($QMP_A)){
			$QGMPA=mysql_query("
				select gmp_ngajar.*,
				app_user_guru.id_guru,
				app_user_guru.nama_lengkap,
				app_user_guru.gelardepan,
				app_user_guru.gelarbelakang 
				from 
				gmp_ngajar,
				app_user_guru 
				where 
				gmp_ngajar.kd_guru=app_user_guru.id_guru and 
				gmp_ngajar.kd_mapel='".$HMP_A['kode_mapel']."' and 
				gmp_ngajar.kd_kelas='".$HMP_A['kode_kelas']."' and 
				gmp_ngajar.thnajaran='$P1' and gmp_ngajar.ganjilgenap='$P2'");
			$HGMPA=mysql_fetch_array($QGMPA);
			if($HGMPA['gelarbelakang']==""){$koma="";}else{$koma=",";}
			$NamaPengajarA=$HGMPA['gelardepan']." ".$HGMPA['nama_lengkap'].$koma." ".$HGMPA['gelarbelakang'];

			if($HMP_A['nama_mapel']=="Pendidikan Agama dan Budi Pekerti" and $HBioSis['agama']!="Islam"){
				$NamaPengajarAA="-";
				$NamaMapelna="Pendidikan Agama ".$HBioSis['agama']. " dan Budi Pekerti";
			}else if ($HMP_A['nama_mapel']=="Pendidikan Agama dan Budi Pekerti"){
				$NamaPengajarAA=$NamaPengajarA;
				$NamaMapelna="Pendidikan Agama ".$HBioSis['agama']. " dan Budi Pekerti";
			}else {
				$NamaPengajarAA=$NamaPengajarA;
				$NamaMapelna=$HMP_A['nama_mapel'];
			}
			
			$TotalKBPA=$TotalKBPA+$HGMPA["kkmpeng"];
			
			$QNPA=mysql_query("select * from n_p_kikd where kd_ngajar='".$HGMPA['id_ngajar']."' and nis=$nis");
			$HNPA=mysql_fetch_array($QNPA);

			$QNPUTSUASA=mysql_query("select * from n_utsuas where kd_ngajar='".$HGMPA['id_ngajar']."' and nis=$nis");
			$HNPUTSUASA=mysql_fetch_array($QNPUTSUASA);
			$NAPA=round(($HNPA['kikd_p']+$HNPUTSUASA['uts']+$HNPUTSUASA['uas'])/3);
			$PredNPA=predikat($NAPA);
		
			$TotalPA=$TotalPA+(round(($HNPA['kikd_p']+$HNPUTSUASA['uts']+$HNPUTSUASA['uas'])/3));
			
			$NMaxTPA=NilaiMaximalTP("select * from n_p_kikd where kd_ngajar='".$HGMPA['id_ngajar']."' and nis='$nis'");
			$JmlTPA=JmlDt("SELECT * FROM gmp_km_tp WHERE kode_ngajar='".$HGMPA['id_ngajar']."'");
			$TmTPA=TmplNilTP("select * from n_p_kikd where kd_ngajar='".$HGMPA['id_ngajar']."' and nis='$nis'",$JmlTPA);
			$QNPADeskA=deskripsiKM($NMaxTPA);

			if($NAPA<$HGMPA['kkmpeng']){$MerahP="<td style='text-align:center;padding:4px 8px;font-size:12px;background:#ffcc99;color:black;font-weight:bold;'>{$NAPA}</td>";}else{$MerahP="<td style='text-align:center;padding:4px 8px;font-size:12px;'>{$NAPA}</td>";}
			
			$TMP_A.="
			<tr>
				<td style='text-align:center;padding:4px 8px;font-size:12px;' align='center'>$NoMPA.</td>
				<td style='padding:4px 8px;font-size:12px;'>{$NamaMapelna}<br>$NamaPengajarAA</td>
				$MerahP
				<td style='padding:4px 8px;font-size:12px;'>Dari jumlah tujuan pembelajaran sebanyak $JmlTPA, ketercapaian pembelajaran dalam kategori $QNPADeskA karena mendapatkan angka maksimal sebesar $NMaxTPA </td>
			</tr>
			";
			$NoMPA++;
		}
	//=============================================================================================================[NILAI KELOMPOK B]
		$QMP_B=mysql_query("$QMP and ak_matapelajaran.kelompok='B' $mapelsmtr order by ak_matapelajaran.kode_mapel");
		$jmlMPB=mysql_num_rows($QMP_B);
		$NoMPB=$jmlMPA+1;
		
		while($HMP_B=mysql_fetch_array($QMP_B)){
			$QGMPB=mysql_query("select gmp_ngajar.*,app_user_guru.id_guru,app_user_guru.nama_lengkap,app_user_guru.gelardepan,app_user_guru.gelarbelakang from gmp_ngajar,app_user_guru where gmp_ngajar.kd_guru=app_user_guru.id_guru and gmp_ngajar.kd_mapel='".$HMP_B['kode_mapel']."' and gmp_ngajar.kd_kelas='".$HMP_B['kode_kelas']."' and gmp_ngajar.thnajaran='$P1' and gmp_ngajar.ganjilgenap='$P2'");
			$HGMPB=mysql_fetch_array($QGMPB);
			if($HGMPB['gelarbelakang']==""){$koma="";}else{$koma=",";}
			$NamaPengajarB=$HGMPB['gelardepan']." ".$HGMPB['nama_lengkap'].$koma." ".$HGMPB['gelarbelakang'];
			
			$TotalKBPB=$TotalKBPB+$HGMPB["kkmpeng"];
			
			$QNPB=mysql_query("select * from n_p_kikd where kd_ngajar='".$HGMPB['id_ngajar']."' and nis=$nis");
			$HNPB=mysql_fetch_array($QNPB);

			$QNPUTSUASB=mysql_query("select * from n_utsuas where kd_ngajar='".$HGMPB['id_ngajar']."' and nis=$nis");
			$HNPUTSUASB=mysql_fetch_array($QNPUTSUASB);
			$NAPB=round(($HNPB['kikd_p']+$HNPUTSUASB['uts']+$HNPUTSUASB['uas'])/3);
			$PredNPB=predikat($NAPB);

			$TotalPB=$TotalPB+(round(($HNPB['kikd_p']+$HNPUTSUASB['uts']+$HNPUTSUASB['uas'])/3));
			
			$NMaxTPB=NilaiMaximalTP("select * from n_p_kikd where kd_ngajar='".$HGMPB['id_ngajar']."' and nis='$nis'");
			$JmlTPB=JmlDt("SELECT * FROM gmp_km_tp WHERE kode_ngajar='".$HGMPB['id_ngajar']."'");
			$TmTPB=TmplNilTP("select * from n_p_kikd where kd_ngajar='".$HGMPB['id_ngajar']."' and nis='$nis'",$JmlTPB);
			$QNPADeskB=deskripsiKM($NMaxTPB);

			if($NAPB<$HGMPB['kkmpeng']){$MerahP="<td style='text-align:center;padding:4px 8px;font-size:12px;background:#ffcc99;color:black;font-weight:bold;'>{$NAPB}</td>";}else{$MerahP="<td style='text-align:center;padding:4px 8px;font-size:12px;'>{$NAPB}</td>";}
			
			$TMP_B.="
			<tr>
				<td style='text-align:center;padding:4px 8px;font-size:12px;' align='center'>$NoMPB.</td>
				<td style='padding:4px 8px;font-size:12px;'>{$HMP_B['nama_mapel']}<br>$NamaPengajarB</td>
				$MerahP
				<td style='padding:4px 8px;font-size:12px;'>Dari jumlah tujuan pembelajaran sebanyak $JmlTPB, ketercapaian pembelajaran dalam kategori $QNPADeskB karena mendapatkan angka maksimal sebesar $NMaxTPB </td>
			</tr>
			";
			$NoMPB++;
		}
	
	//==============================================================================================================[NILAI RATA-RATA]

		$TotMapel=$jmlMPA+$jmlMPB;
		$RerataKBP=round(($TotalKBPA+$TotalKBPB)/$TotMapel);
		$RerataKBK=round(($TotalKBKA+$TotalKBKB)/$TotMapel);
		$RerataP=round(($TotalPA+$TotalPB)/$TotMapel);

		$RerataNAZ=round(($TotalNAA+$TotalNAB+$TotalNAC1+$TotalNAC2+$TotalNAC3+$TotalNAM)/$TotMapel);
		$PredNA= Predikat($RerataNAZ); 
		$PredP=Predikat($RerataP);
		$PredK=Predikat($RerataK);
	//==========================================================================================================[TAMPILAN DI BROWSER]

	$dtSiswana = "
	<table align='center' width='90%' style='margin: 0 auto;width:90%;border-collapse:collapse;font:12px Times New Roman;'>
		<tr>
			<td valign='top'>
				<table>
				<tr>
					<td style='padding: 2px 0px;'>Nama Siswa</td>
					<td style='padding: 2px 0px;'>:</td>
					<td style='padding: 2px 0px;'><strong>{$HBioSis['nm_siswa']}</strong></td>
				</tr>
				<tr>
					<td style='padding: 2px 0px;'>NIS / NISN</td>
					<td style='padding: 2px 0px;'>:</td>
					<td style='padding: 2px 0px;'>{$HBioSis['nis']} / {$HBioSis['nisn']}</td>
				</tr>
				<tr>
					<td width='125' style='padding: 2px 0px;'>Nama Sekolah</td>
					<td width='20' style='padding: 2px 0px;'>:</td>
					<td style='padding: 2px 0px;'>{$HIS['nm_sekolah']}</td>
				</tr>
				<tr>
					<td style='padding: 2px 0px;'>Alamat</td>
					<td style='padding: 2px 0px;'>:</td>
					<td style='padding: 2px 0px;'>{$HIS['alamat']} {$HIS['kelurahan']}</td>
				</tr>
				</table>
			</td>
			<td valign='top'>
				<table>
				<tr>
					<td width='125' style='padding: 2px 0px;'>Kelas</td>
					<td width='20' style='padding: 2px 0px;'>:</td>
					<td style='padding: 2px 0px;'>{$HSisD['nama_kelas']}</td>
				</tr>
				<tr>
					<td style='padding: 2px 0px;'>Semester</td>
					<td style='padding: 2px 0px;'>:</td>
					<td style='padding: 2px 0px;'>$P2</td>
				</tr>
				<tr>
					<td style='padding: 2px 0px;'>Tahun Ajaran</td>
					<td style='padding: 2px 0px;'>:</td>
					<td style='padding: 2px 0px;'>{$HSisD['tahunajaran']}</td>
				</tr>
				</table>
			</td>
		</tr>
		<tr><td colspan='2'><hr></td></tr>
	</table>
	";
	
		$Hal1="
		<div id='cetak-hal1'>
			<img style=' position: absolute; padding: 250px 2px 15px -250px; margin-left:180px;margin-top:215px;' src='img/logosmktrans.png' border='0' alt=''>
			<div class='table-responsive'>			
				$dtSiswana 
				<table style='margin: 0 auto;width:100%;border-collapse:collapse;font:12px Times New Roman;'>
					<tr>
						<td align='center' style='margin: 0 auto;width:100%;border-collapse:collapse;font:18px Times New Roman;'><p><strong>LAPORAN HASIL BELAJAR</p></strong></td>
					</tr>
					<tr>
						<td align='center'>
							<table width='100%' rules='all' border='1' style='border-color:#000;'>
							<tr>
								<th style='text-align:center;padding:4px 8px;'><strong>No.</th>
								<th style='text-align:center;padding:4px 8px;' width='250'>Mata Pelajaran</th>
								<th style='text-align:center;padding:4px 8px;'>Nilai Akhir</th>
								<th style='text-align:center;padding:4px 8px;'>Capaian Kompetensi</th>
							</tr>
							<tr>
								<td colspan='10' style='padding:4px 8px;font-size:14px;'>
									<strong>A. Kelompok Mata Pelajaran Umum</strong>
								</td>
							</tr>
							
							$TMP_A
							
							<tr>
								<td colspan='10' style='padding:4px 8px;font-size:14px;'>
									<strong>B. Kelompok Mata Pelajaran Kejuruan</strong>
								</td>
							</tr>
							
							$TMP_B

							</table>
						</td>
					</tr>
					<!-- <tr><td height='100%'>&nbsp;</td></tr> -->
				</table>
			</div>
		</div>";

//=================================================================================================================[RAPORT HALAMAN 2]

		$Hal2.="
		<div id='cetak-hal2'>
			<img style=' position: absolute; padding: 250px 2px 15px -250px; margin-left:180px;margin-top:215px;' src='img/logosmktrans.png' border='0' alt=''>
			<img style=' position: absolute; padding: 250px 2px 15px -250px; margin-left:180px;margin-top:215px;' src='img/logosmktrans.png' border='0' alt=''>
			$dtSiswana";
	//=======================================================================================================[PRAKTEK KERJA LAPANGAN]
		$pkl=mysql_query("select * from wk_prakerin where nis=$nis");
		$jmlpkl=mysql_num_rows($pkl);
		if($jmlpkl>0){
			$Hpkl=mysql_fetch_array($pkl);
			$SmstrPrakerin = $Hpkl['semester'];
			if($SmstrPrakerin==3 || $SmstrPrakerin==5){$Smsterna="Ganjil";}else 
				if($SmstrPrakerin==4 || $SmstrPrakerin==6){$Smsterna="Genap";}
			if($Hpkl['tahunajaran']==$P1 && $Smsterna==$P2){
				$dpkl.="
				<tr>
					<td style='padding:4px 8px;' valign='top' align='center'>1.</td>
					<td style='padding:4px 8px;' valign='top'>{$Hpkl['perusahaan']}</td>
					<td style='padding:4px 8px;' valign='top'>{$Hpkl['lokasi']}</td>
					<td style='padding:4px 8px;' valign='top'>{$Hpkl['bln_awal']} s.d. {$Hpkl['bln_akhir']}</td>
					<td style='padding:4px 8px;'>{$Hpkl['ket']}, dengan nilai {$Hpkl['nilai']} (".terbilang($Hpkl['nilai']).")</td>
				</tr>";
			}
			else
			{
				$dpkl.="
				<tr>
					<td style='padding:4px 8px;' valign='top' align='center'>1.</td>
					<td style='padding:4px 8px;' valign='top'></td>
					<td style='padding:4px 8px;' valign='top'></td>
					<td style='padding:4px 8px;' valign='top'></td>
					<td style='padding:4px 8px;'></td>
				</tr>";
			}
		}
		else
		{
			$dpkl.="
			<tr>
				<td style='padding:4px 8px;' valign='top' align='center'>1.</td>
				<td style='padding:4px 8px;' valign='top'></td>
				<td style='padding:4px 8px;' valign='top'></td>
				<td style='padding:4px 8px;' valign='top'></td>
				<td style='padding:4px 8px;'></td>
			</tr>";
		}			
		$Hal2.="
			<table style='margin: 0 auto;width:100%;border-collapse:collapse;font:12px Times New Roman;'>
				<tr><td align='center' width='50%'>
					<table align='center' width='90%'>
						<tr>
							<td>
								<p><strong>Praktik Kerja Lapangan</strong></p>
								<table width='100%' rules='all' border='1' style='border-color:#000;'>
								<tr>
									<th width='7%' style='text-align:center;padding:4px 8px;'><strong>No.</th>
									<th style='text-align:center;padding:4px 8px;'>Mitra DU/DI</th>
									<th style='text-align:center;padding:4px 8px;'>Lokasi</th>
									<th style='text-align:center;padding:4px 8px;'>Lamanya (Bulan)</th>
									<th width='25%' style='text-align:center;padding:4px 8px;'>Keterangan</strong></th>
								</tr>
								$dpkl
								</table>
							</td>
						</tr>
					</table>
				</td></tr>
			</table>";
	//=======================================================================================================[ESKUL]
		$Esk=mysql_query("select * from wk_eskul_siswa where tahunajaran='$P1' and semester='$P2' and nis=$nis");
		$HEsk=mysql_fetch_array($Esk);
		if($HEsk['wajib']==""){
		$DEskul.="
		<tr>
			<td style='padding:4px 8px;' valign='top' align='center'>1.</td>
			<td style='padding:4px 8px;' valign='top'></td>
			<td style='padding:4px 8px;' valign='top'></td>
		</tr>
		<tr>
			<td style='padding:4px 8px;' valign='top' align='center'>2.</td>
			<td style='padding:4px 8px;' valign='top'></td>
			<td style='padding:4px 8px;' valign='top'></td>
		</tr>";}
		else{
		$DEskul.="
		<tr>
			<td style='padding:4px 8px;' valign='top' align='center'>1.</td>
			<td style='padding:4px 8px;' valign='top'>{$HEsk['wajib']}</td>
			<td style='padding:4px 8px;' valign='top'>{$HEsk['wajib_desk']}</td>
		</tr>";}
		if($HEsk['pil1']==""){}else{
		$DEskul.="
		<tr>
			<td style='padding:4px 8px;' valign='top' align='center'>2.</td>
			<td style='padding:4px 8px;' valign='top'>{$HEsk['pil1']}</td>
			<td style='padding:4px 8px;' valign='top'>{$HEsk['pil1_desk']}</td>
		</tr>";}
		if($HEsk['pil2']==""){}else{
		$DEskul.="
		<tr>
			<td style='padding:4px 8px;' valign='top' align='center'>3.</td>
			<td style='padding:4px 8px;' valign='top'>{$HEsk['pil2']}</td>
			<td style='padding:4px 8px;' valign='top'>{$HEsk['pil2_desk']}</td>
		</tr>";}
		if($HEsk['pil3']==""){}else{
		$DEskul.="
		<tr>
			<td style='padding:4px 8px;' valign='top' align='center'>4.</td>
			<td style='padding:4px 8px;' valign='top'>{$HEsk['pil3']}</td>
			<td style='padding:4px 8px;' valign='top'>{$HEsk['pil3_desk']}</td>
		</tr>";}
		if($HEsk['pil4']==""){}else{
		$DEskul.="
		<tr>
			<td style='padding:4px 8px;' valign='top' align='center'>5.</td>
			<td style='padding:4px 8px;' valign='top'>{$HEsk['pil4']}</td>
			<td style='padding:4px 8px;' valign='top'>{$HEsk['pil4_desk']}</td>
		</tr>";}		
		$Hal2.="			
			<table style='margin: 0 auto;width:100%;border-collapse:collapse;font:12px Times New Roman;'>
				<tr><td align='center' width='50%'>
					<table align='center' width='90%'>
						<tr>
							<td>
								<p><strong>Ekstrakurikuler</strong></p>
								<table width='100%' rules='all' border='1' style='border-color:#000;'>
								<tr>
									<th width='7%' style='text-align:center;padding:4px 8px;'><strong>No.</th>
									<th width='30%' style='text-align:center;padding:4px 8px;'>Kegiatan Ekstrakurikuler</th>
									<th style='text-align:center;padding:4px 8px;'>Keterangan</strong></th>
								</tr>
								$DEskul
								</table>
							</td>
						</tr>
					</table>
				</td></tr>
			</table>";
	//=====================================================================================================================[PRESTASI]
		$PresSiswa=mysql_query("select * from wk_prestasi_siswa where tahunajaran='$P1' and semester='$P2' and nis=$nis");
		$JmlPrestasi=mysql_num_rows($PresSiswa);
		$NoPres=1;
		if($JmlPrestasi>0){
			while($HPres=mysql_fetch_array($PresSiswa))
			{
				$DPrestasi.="
				<tr>
					<td style='padding:4px 8px;' valign='top' align='center'>$NoPres.</td>
					<td style='padding:4px 8px;' valign='top'>{$HPres['jenis']}</td>
					<td style='padding:4px 8px;' valign='top'><strong>{$HPres['nama_lomba']} tingkat {$HPres['tingkat']}</strong> sebagai <strong>Juara {$HPres['juarake']}</strong> Pada tanggal <strong>".TglLengkap($HPres['tanggal'])."</strong>  di <strong>{$HPres['tempat']}</strong></td>
				</tr>";
				$NoPres++;
			}
		}
		else
		{
			$DPrestasi.="
			<tr>
				<td style='padding:4px 8px;' valign='top' align='center'>1.</td>
				<td style='padding:4px 8px;' valign='top'></td>
				<td style='padding:4px 8px;' valign='top'></td>
			</tr>
			<tr>
				<td style='padding:4px 8px;' valign='top' align='center'>2.</td>
				<td style='padding:4px 8px;' valign='top'></td>
				<td style='padding:4px 8px;' valign='top'></td>
			</tr>";
		}

		$Hal2.="			
			<table style='margin: 0 auto;width:100%;border-collapse:collapse;font:12px Times New Roman;'>
				<tr><td align='center' width='50%'>
					<table align='center' width='90%'>
						<tr>
							<td>
								<p><strong>Prestasi</strong></p>
								<table width='100%' rules='all' border='1' style='border-color:#000;'>
								<tr>
									<th width='7%' style='text-align:center;padding:4px 8px;'><strong>No.</th>
									<th width='30%' style='text-align:center;padding:4px 8px;'>Jenis Prestasi</th>
									<th style='text-align:center;padding:4px 8px;'>Keterangan</strong></th>
								</tr>
								$DPrestasi
								</table>
							</td>
						</tr>
					</table>
				</td></tr>
			</table>";
	//===============================================================================================================[KETIDAKHADIRAN]
		$Absensi=mysql_query("select * from wk_absensi where tahunajaran='$P1' and semester='$P2' and nis=$nis");
		$HAbsensi=mysql_fetch_array($Absensi);
		if($HAbsensi['sakit']==0){$absensakit.="-";}else{$absensakit.=$HAbsensi['sakit'] ." hari";}
		if($HAbsensi['izin']==0){$absenizin.="-";}else{$absenizin.=$HAbsensi['izin'] ." hari";}
		if($HAbsensi['alfa']==0){$absenalfa.="-";}else{$absenalfa.=$HAbsensi['alfa'] ." hari";}
		if($HAbsensi['jmlabsen']==0){$jmlabseni.="-";}else{$jmlabseni.=$HAbsensi['jmlabsen'] ." hari";}
		$Hal2.="			
			<table style='margin: 0 auto;width:90%;border-collapse:collapse;font:12px Times New Roman;'>
				<tr>
					<td>
						<p><strong>Ketidakhadiran</strong></p>
						<table style='width:85%;border-collapse:collapse;' border='1'>
							<tr>
								<td style='text-align:center;padding:4px 8px;'>1.</td>
								<td style='padding:4px 8px;'>Sakit</td>
								<td style='text-align:center;padding:4px 8px;'>$absensakit</td>
							</tr>
							<tr>
								<td style='text-align:center;padding:4px 8px;'>2.</td>
								<td style='padding:4px 8px;'>Izin</td>
								<td style='text-align:center;padding:4px 8px;'>$absenizin</td>
							</tr>
							<tr>
								<td style='text-align:center;padding:4px 8px;'>3.</td>
								<td style='padding:4px 8px;'>Alfa</td>
								<td style='text-align:center;padding:4px 8px;'>$absenalfa</td>
							</tr>
							<tr>
								<td style='text-align:center;padding:4px 8px;' colspan='2' align='center'><strong>Jumlah</strong></td>
								<td style='text-align:center;padding:4px 8px;'><strong>$jmlabseni</strong></td>
							</tr>
						</table>
					</td>
					<td>
						<p><strong>Catatan Wali Kelas</strong></p>
						<table style='width:100%;margin: 0 auto;padding: 5px 10px;border-collapse:collapse;border: 1px solid #000;'>
						<tr>
							<td height='100' valign='top' style='padding: 5px 10px;'>
								<p>{$Hcatwk['catatan']}</p>
							</td>
						</tr>
						</table>

					</td>
				</tr>
			</table>";
		if($HWK['tingkat']=="X"){
			$Kenaikan.="Naik ke tingkat XI (Sebelas)";
			$TidakNaek.="Tidak Naik ke tingkat XI (Sebelas)";
		}
		else if($HWK['tingkat']=="XI"){
			$Kenaikan.="Naik ke tingkat XII (Dua Belas)";
			$TidakNaek.="Tidak Naik ke tingkat XII (Dua Belas)";
		}
		else if($HWK['tingkat']=="XII"){
			$Kenaikan.="Lulus setelah mengikuti Ujian Akhir";
			$TidakNaek.="Tidak Lulus setelah mengikuti Ujian Akhir";
		}
		
		if($P2=="Genap"){
			$NaekTeu=JmlDt("select * from wk_tidaknaik where nis='$nis'");
			if($NaekTeu==0){
				$SemesterGenap.="
				Keputusan : <br>
				Berdasarkan hasil yang dicapai pada semester Genap dan Ganjil Tahun Pelajaran $P1, peserta didik ditetapkan <br>
				<strong>$Kenaikan</strong><br>
				<p>&nbsp;</p>";
			}
			else{
				$SemesterGenap.="
				Keputusan : <br>
				Berdasarkan hasil yang dicapai pada semester Genap dan Ganjil Tahun Pelajaran $P1, peserta didik ditetapkan <br>
				<strong>$TidakNaek</strong><br>
				<p>&nbsp;</p>";
			}
			$ttKepsek.="
			<table width='100%'>
			<tr>
				<td width='35%'>&nbsp;</td>
				<td>
					<p>&nbsp;</p>
					Mengetahui :<br>
					Kepala Sekolah, 
					<br>
					<div><!-- <img src='img/ttdkepsek/nanabaru.png' border='0' height='95' width='225' style=' position: absolute; padding: 0px 2px 15px -250px; margin-left: -40px;margin-top:-15px;'> --></div>
					<br><br><br><br>
					<strong>$NamaKepsekG</strong><br>
					NIP. $NIPKepsekG
					<p>&nbsp;</p>										
				</td>
				<td></td>
			</tr>
			</table>";
		}
		else{
			$SemesterGenap.="";
			$ttKepsek.="";
		}
		$catwk=mysql_query("select * from wk_cat_walikelas where tahunajaran='$P1' and semester='$P2' and nis=$nis");
		$Hcatwk=mysql_fetch_array($catwk);
		$QTTM=mysql_query("select * from wk_kelas_ttm where kd_kls='".$HWK['kode_kelas']."' and ganjilgenap='{$P2}'");
		$HTTM=mysql_fetch_array($QTTM);
		$JHTM=mysql_num_rows($QTTM);
		if($HWK['gelarbelakang']==""){$koma="";}else{$koma=",";}
		$NIPWK="NIP. ".$HWK['nip'];
		$NamaWK=$HWK['gelardepan']." ".$HWK['nama_lengkap'].$koma." ".$HWK['gelarbelakang'];
		$Hal2.="
			<table style='margin: 0 auto;width:100%;border-collapse:collapse;font:12px Times New Roman;'>
				<tr><td align='center' width='50%'>
					<table align='center' width='90%'>
						<tr>
							<td>
								<p><strong>Tanggapan Orang Tua/Wali Siswa</strong></p>
								<table style='width:100%;margin: 0 auto;padding: 5px 10px;border-collapse:collapse;border: 1px solid #000;'>
								<tr>
									<td height='40' valign='top' style='padding: 5px 10px;'>
										<p>&nbsp;</p>
									</td>
								</tr>
								</table><br>
								$SemesterGenap
								<table width='100%'>
								<tr>
									<td width='45%' valign='top'>
										<table width='100%'>
										<tr>
											<td width='5%'>&nbsp;</td>
											<td>Mengetahui :<br>Orang Tua / Wali
											<p>&nbsp;</p>
											<p>&nbsp;</p>
											___________________________________
											</td>
										</tr>
										</table>
									</td>
									<td width='10%'>&nbsp;</td>
									<td valign='top' width='55%'>
										<table width='100%'>
										<tr>
											<td>
											{$HTTM['alamat']}, ".Tanggal($HTTM['ttm'])."<br>
											Wali Kelas, 
											<p>&nbsp;</p>
											<p>&nbsp;</p>
											<strong>$NamaWK</strong><br>
											$NIPWK
										</td>
										</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td colspan='3'>{$ttKepsek}</td>
								</tr>
								</table>
							</td>
						</tr>
					</table>
				</td></tr>
			</table>		
		</div>";


//===================================================================================================================[KELUAR SEKOLAH]
		$KeluarSekolah="
		<div id='cetak-keluar'>
			<img style=' position: absolute; padding: 250px 2px 15px -250px; margin-left:180px;margin-top:215px;' src='img/logosmktrans.png' border='0' alt=''>
			<div class='table-responsive'>
			<table style='margin: 0 auto;width:100%;border-collapse:collapse;font:12px Times New Roman;'>
				<tr><td>&nbsp;</td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td style='font-size:18px;text-align:center;'><strong>KETERANGAN PINDAH SEKOLAH</strong></td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td align='center' width='50%'>
					<table align='center' width='90%'>
						<tr>
							<td>
								<p>Nama Siswa : <strong>{$HBioSis['nm_siswa']}</strong></p>
								<table width='100%' rules='all' border='1' style='border-color:#000;'>
								<tr>
									<th colspan='4' style='text-align:center;padding:4px 8px;'>KELUAR</th>
								</tr>
								<tr>
									<th width='100' style='text-align:center;padding:4px 8px;'><strong>Tanggal</th>
									<th style='text-align:center;padding:4px 8px;'>Kelas yang di tinggal</th>
									<th style='text-align:center;padding:4px 8px;'>Sebab-sebab Keluar atau Permintaan (tertulis)</th>
									<th width='25%' style='text-align:center;padding:4px 8px;'>Tanda Tangan Kepala Sekolah, Stempel Sekolah, dan Tanda Tangan Orang Tua/Wali</strong></th>
								</tr>
								<tr>
									<td style='padding:4px 8px;'></td>
									<td style='padding:4px 8px;'></td>
									<td style='padding:4px 8px;'></td>
									<td style='padding:4px 8px;'>
										.............................., ............................<br>
										Kepala Sekolah, 
										<p>&nbsp;</p>
										<p>&nbsp;</p>
										.............................................................<br>
										NIP. ....................................................
										<hr>
										Orang Tua / Wali, 
										<p>&nbsp;</p>
										<p>&nbsp;</p>
										.............................................................<br>
									</td>
								</tr>
								<tr>
									<td style='padding:4px 8px;'></td>
									<td style='padding:4px 8px;'></td>
									<td style='padding:4px 8px;'></td>
									<td style='padding:4px 8px;'>
										.............................., ............................<br>
										Kepala Sekolah, 
										<p>&nbsp;</p>
										<p>&nbsp;</p>
										.............................................................<br>
										NIP. ....................................................
										<hr>
										Orang Tua / Wali, 
										<p>&nbsp;</p>
										<p>&nbsp;</p>
										.............................................................<br>
									</td>
								</tr>
								<tr>
									<td style='padding:4px 8px;'></td>
									<td style='padding:4px 8px;'></td>
									<td style='padding:4px 8px;'></td>
									<td style='padding:4px 8px;'>
										.............................., ............................<br>
										Kepala Sekolah, 
										<p>&nbsp;</p>
										<p>&nbsp;</p>
										.............................................................<br>
										NIP. ....................................................
										<hr>
										Orang Tua / Wali, 
										<p>&nbsp;</p>
										<p>&nbsp;</p>
										.............................................................<br>
									</td>
								</tr>
								</table>
							</td>
						</tr>
					</table>
				</td></tr>
			</table>
			</div>
		</div>";
//====================================================================================================================[MASUK SEKOLAH]
		$MasukSekolah="
		<div id='cetak-masuk'>
			<img style=' position: absolute; padding: 250px 2px 15px -250px; margin-left:180px;margin-top:215px;' src='img/logosmktrans.png' border='0' alt=''>
			<div class='table-responsive'>
			<table style='margin: 0 auto;width:100%;border-collapse:collapse;font:12px Times New Roman;'>
				<tr><td>&nbsp;</td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td style='font-size:18px;text-align:center;'><strong>KETERANGAN PINDAH SEKOLAH</strong></td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td align='center' width='50%'>
					<table align='center' width='90%'>
						<tr>
							<td>
								<p>Nama Siswa : <strong>{$HBioSis['nm_siswa']}</strong></p>
								<table width='100%' rules='all' border='1' style='border-color:#000;'>
								<tr>
									<th style='text-align:center;padding:4px 8px;'><strong>NO.</th> 
									<th colspan='3' style='text-align:center;padding:4px 8px;'>MASUK</strong></th>
								</tr>
								<tr>
									<td style='text-align:center;padding:4px 8px;'>1.</td>
									<td width='25%' style='padding:4px 8px;'>Nama Siswa</td>
									<td width='45%' style='padding:4px 8px;'></td>
									<td rowspan='7' style='padding:4px 8px;' valign='top'>
										.............................., ............................<br>
										Kepala Sekolah, 
										<p>&nbsp;</p>
										<p>&nbsp;</p>
										.............................................................<br>
										NIP. ....................................................
									</td>
								</tr>
								<tr>
									<td style='text-align:center;padding:4px 8px;'>2.</td>
									<td style='padding:4px 8px;'>Nomor Induk</td>
									<td style='padding:4px 8px;'></td>
								</tr>
								<tr>
									<td style='text-align:center;padding:4px 8px;'>3.</td>
									<td style='padding:4px 8px;'>Nama Sekolah</td>
									<td style='padding:4px 8px;'></td>
								</tr>
								<tr>
									<td style='text-align:center;padding:4px 8px;'>4.</td>
									<td style='padding:4px 8px;'>Masuk di Sekolah ini</td>
									<td style='padding:4px 8px;'></td>
								</tr>
								<tr>
									<td style='text-align:center;padding:4px 8px;'></td>
									<td style='padding:4px 8px;'>a. Tanggal</td>
									<td style='padding:4px 8px;'></td>
								</tr>
								<tr>
									<td style='text-align:center;padding:4px 8px;'></td>
									<td style='padding:4px 8px;'>b. Di Kelas</td>
									<td style='padding:4px 8px;'></td>
								</tr>
								<tr>
									<td style='text-align:center;padding:4px 8px;'>5.</td>
									<td style='padding:4px 8px;'>Tahun Pelajaran</td>
									<td style='padding:4px 8px;'></td>
								</tr>
								<tr>
									<td style='text-align:center;padding:4px 8px;'>1.</td>
									<td style='padding:4px 8px;'>Nama Siswa</td>
									<td style='padding:4px 8px;'></td>
									<td rowspan='7' style='padding:4px 8px;' valign='top'>
										.............................., ............................<br>
										Kepala Sekolah, 
										<p>&nbsp;</p>
										<p>&nbsp;</p>
										.............................................................<br>
										NIP. ....................................................
									</td>
								</tr>
								<tr>
									<td style='text-align:center;padding:4px 8px;'>2.</td>
									<td style='padding:4px 8px;'>Nomor Induk</td>
									<td style='padding:4px 8px;'></td>
								</tr>
								<tr>
									<td style='text-align:center;padding:4px 8px;'>3.</td>
									<td style='padding:4px 8px;'>Nama Sekolah</td>
									<td style='padding:4px 8px;'></td>
								</tr>
								<tr>
									<td style='text-align:center;padding:4px 8px;'>4.</td>
									<td style='padding:4px 8px;'>Masuk di Sekolah ini</td>
									<td style='padding:4px 8px;'></td>
								</tr>
								<tr>
									<td style='text-align:center;padding:4px 8px;'></td>
									<td style='padding:4px 8px;'>a. Tanggal</td>
									<td style='padding:4px 8px;'></td>
								</tr>
								<tr>
									<td style='text-align:center;padding:4px 8px;'></td>
									<td style='padding:4px 8px;'>b. Di Kelas</td>
									<td style='padding:4px 8px;'></td>
								</tr>
								<tr>
									<td style='text-align:center;padding:4px 8px;'>5.</td>
									<td style='padding:4px 8px;'>Tahun Pelajaran</td>
									<td style='padding:4px 8px;'></td>
								</tr>
								<tr>
									<td style='text-align:center;padding:4px 8px;'>1.</td>
									<td style='padding:4px 8px;'>Nama Siswa</td>
									<td style='padding:4px 8px;'></td>
									<td rowspan='7' style='padding:4px 8px;' valign='top'>
										.............................., ............................<br>
										Kepala Sekolah, 
										<p>&nbsp;</p>
										<p>&nbsp;</p>
										.............................................................<br>
										NIP. ....................................................
									</td>
								</tr>
								<tr>
									<td style='text-align:center;padding:4px 8px;'>2.</td>
									<td style='padding:4px 8px;'>Nomor Induk</td>
									<td style='padding:4px 8px;'></td>
								</tr>
								<tr>
									<td style='text-align:center;padding:4px 8px;'>3.</td>
									<td style='padding:4px 8px;'>Nama Sekolah</td>
									<td style='padding:4px 8px;'></td>
								</tr>
								<tr>
									<td style='text-align:center;padding:4px 8px;'>4.</td>
									<td style='padding:4px 8px;'>Masuk di Sekolah ini</td>
									<td style='padding:4px 8px;'></td>
								</tr>
								<tr>
									<td style='text-align:center;padding:4px 8px;'></td>
									<td style='padding:4px 8px;'>a. Tanggal</td>
									<td style='padding:4px 8px;'></td>
								</tr>
								<tr>
									<td style='text-align:center;padding:4px 8px;'></td>
									<td style='padding:4px 8px;'>b. Di Kelas</td>
									<td style='padding:4px 8px;'></td>
								</tr>
								<tr>
									<td style='text-align:center;padding:4px 8px;'>5.</td>
									<td style='padding:4px 8px;'>Tahun Pelajaran</td>
									<td style='padding:4px 8px;'></td>
								</tr>
								<tr>
									<td style='text-align:center;padding:4px 8px;'>1.</td>
									<td style='padding:4px 8px;'>Nama Siswa</td>
									<td style='padding:4px 8px;'></td>
									<td rowspan='7' style='padding:4px 8px;' valign='top'>
										.............................., ............................<br>
										Kepala Sekolah, 
										<p>&nbsp;</p>
										<p>&nbsp;</p>
										.............................................................<br>
										NIP. ....................................................
									</td>
								</tr>
								<tr>
									<td style='text-align:center;padding:4px 8px;'>2.</td>
									<td style='padding:4px 8px;'>Nomor Induk</td>
									<td style='padding:4px 8px;'></td>
								</tr>
								<tr>
									<td style='text-align:center;padding:4px 8px;'>3.</td>
									<td style='padding:4px 8px;'>Nama Sekolah</td>
									<td style='padding:4px 8px;'></td>
								</tr>
								<tr>
									<td style='text-align:center;padding:4px 8px;'>4.</td>
									<td style='padding:4px 8px;'>Masuk di Sekolah ini</td>
									<td style='padding:4px 8px;'></td>
								</tr>
								<tr>
									<td style='text-align:center;padding:4px 8px;'></td>
									<td style='padding:4px 8px;'>a. Tanggal</td>
									<td style='padding:4px 8px;'></td>
								</tr>
								<tr>
									<td style='text-align:center;padding:4px 8px;'></td>
									<td style='padding:4px 8px;'>b. Di Kelas</td>
									<td style='padding:4px 8px;'></td>
								</tr>
								<tr>
									<td style='text-align:center;padding:4px 8px;'>5.</td>
									<td style='padding:4px 8px;'>Tahun Pelajaran</td>
									<td style='padding:4px 8px;'></td>
								</tr>
								</table>
							</td>
						</tr>
					</table>
				</td></tr>
			</table>
			</div>
		</div>";
//=================================================================================================================[CATATAN PRESTASI]
		$PIntra=mysql_query("select * from wk_prestasi_siswa where nis=$nis and jenis='Intrakurikuler'");
		$JmlPIntra=mysql_num_rows($PIntra);
		if($JmlPIntra>0){
			while($HPIntra=mysql_fetch_array($PIntra))
			{
				$DPIntra.="
						<li><strong>{$HPIntra['nama_lomba']} tingkat {$HPIntra['tingkat']}</strong> Pada tanggal <strong>".TglLengkap($HPIntra['tanggal'])."</strong> sebagai <strong>Juara {$HPIntra['juarake']}</strong> di <strong>{$HPIntra['tempat']}</strong></li>";
			}
		}
		else
		{
			$DPIntra.="<li><li><li><li><li>";
		}
		$PEkstra=mysql_query("select * from wk_prestasi_siswa where nis=$nis and jenis='Ekstrakurikuler'");
		$JmlPEkstra=mysql_num_rows($PEkstra);
		if($JmlPEkstra>0){
			while($HPEkstra=mysql_fetch_array($PEkstra))
			{
				$DPEkstra.="
						<li><strong>{$HPEkstra['nama_lomba']} tingkat {$HPEkstra['tingkat']}</strong> Pada tanggal <strong>".TglLengkap($HPEkstra['tanggal'])."</strong> sebagai <strong>Juara {$HPEkstra['juarake']}</strong> di <strong>{$HPEkstra['tempat']}</strong></li>";
			}
		}
		else
		{
			$DPEkstra.="<li><li><li><li><li>";
		}
		$Prestasi= "
		<div id='cetak-prestasi'>
			<img style=' position: absolute; padding: 250px 2px 15px -250px; margin-left:180px;margin-top:215px;' src='img/logosmktrans.png' border='0' alt=''>
			<table style='margin: 0 auto;width:100%;border-collapse:collapse;font:12px Times New Roman;'>
				<tr><td>&nbsp;</td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td style='font-size:18px;text-align:center;'><strong>CATATAN PRESTASI YANG PERNAH DI CAPAI</strong></td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td align='center' width='50%'>
					<table align='center' width='90%'>
						<tr>
							<td>
								<table>
									<tr>
										<td width='45%'>Nama Siswa</td>
										<td width='5%'>=</td>
										<td>{$HBioSis['nm_siswa']}</td>
									</tr>
									<tr>
										<td>Nomor Induk/NISN</td>
										<td>=</td>
										<td>{$HBioSis['nis']} / {$HBioSis['nisn']}</td>
									</tr>
									<tr>
										<td>Nama Sekolah</td>
										<td>=</td>
										<td>{$HIS['nm_sekolah']}</td>
									</tr>
								</table>			
								<p>&nbsp;</p>
								<table width='100%' rules='all' border='1' style='border-color:#000;'>
								<tr>
									<th width='5%' style='text-align:center;padding:4px 8px;'>NO.</th>
									<th width='35%' style='text-align:center;padding:4px 8px;'>PRESTASI YANG PERNAH DI CAPAI</th>
									<th style='text-align:center;padding:4px 8px;'>KETERANGAN</th>
								</tr>
								<tr>
									<td style='text-align:center;padding:4px 8px;' valign='top'>1.</td>
									<td style='padding:4px 8px;' valign='top'>INTRA KURIKULER</td>
									<td style='padding:4px 8px;'><ol>$DPIntra</ol></td>
								</tr>
								<tr>
									<td style='text-align:center;padding:4px 8px;' valign='top'>2.</td>
									<td style='padding:4px 8px;' valign='top'>EKSTRA KURIKULER</td>
									<td style='padding:4px 8px;'><ol>$DPEkstra</ol></td>
								</tr>
								<tr>
									<td style='text-align:center;' valign='top'>3.</td>
									<td style='padding:4px 8px;' valign='top'>CATATAN KHUSUS LAINNYA</td>
									<td style='padding:4px 8px;'>
										<ol>
											<li>
											<li>
											<li>
											<li>
											<li>
										</ol>
									</td>
								</tr>
								</table>
							</td>
						</tr>
					</table>
				</td></tr>
			</table>
		</div>";
//===================================================================================================================[TAMPILAN CETAK]
		
		global $Ref;
		$isispasi = array("normal","1","1.6","2","10px","80%","120%");
		for($i=0;$i<count($isispasi);$i++)
		{
			$Sel = $isispasi[$i]==$PilJarakDes?"selected":"";
			$PilihSpasi .= "<option $Sel value={$isispasi[$i]}>{$isispasi[$i]}</option>";
		}
		$CariSiswa.="
		<form action='?page=$page&amp;sub=tampil' method='post' name='FrmNyariData' class='form-horizontal' role='form'>
			<div class='form-group'>
				<label class='col-sm-4 control-label'>Nama Siswa</label>
				<div class='col-sm-5'>
					<select name=\"txtNIS\" class='input-sm form-control' onchange=\"document.location.href='?page=$page&nis='+document.FrmNyariData.txtNIS.value+'&semesterna='+document.FrmNyariData.txtGG.value\">
						<option value=''>Pilih Nama Siswa</option>
						$PilihSiswa
					</select>
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-4 control-label'>Semester</label>
				<div class='col-sm-4'>
					<select name=\"txtGG\" class='input-sm form-control' onchange=\"document.location.href='?page=$page&nis='+document.FrmNyariData.txtNIS.value+'&semesterna='+document.FrmNyariData.txtGG.value\">
						<option value=''>Pilih Semester</option>
						<option $Milih1 value='nomerhiji'>Semester I</option>
						<option $Milih2 value='nomerdua'>Semester II</option>
						<option $Milih3 value='nomertilu'>Semester III</option>
						<option $Milih4 value='nomeropat'>Semester IV</option>
						<option $Milih5 value='nomerlema'>Semester V</option>
						<option $Milih6 value='nomergenep'>Semester VI</option>
					</select>
				</div>
			</div>
		</form>";
		if($semesterna=="nomerhiji"){
			$PilihNyetak .= "
			<div class='col-xs-12 col-md-6'>
				<div class='jarviswidget' id='wid-id-19' data-widget-colorbutton='false' data-widget-colorbutton='false' data-widget-editbutton='false' data-widget-togglebutton='false' data-widget-fullscreenbutton='false' data-widget-deletebutton='false' data-widget-custombutton='false'>
					<header><span class='widget-icon'> <i class='fa fa-file-text-o'></i> </span><h2>Pilih Halaman Cetak</h2>
						<div class='widget-toolbar'>
							<button class='btn btn-default text-color-blue btn-md' data-toggle='modal' data-target='#WKProsesCetakRapor'>
								<i class='fa fa-question'></i>
							</button>
						</div>							
					</header>
					<div>
						<div class='jarviswidget-editbox'></div>
						<div class='widget-body no-padding'>
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
								function NyetakRapor() {
									var cbCover=document.getElementById (\"cbCover\");
									var cbIdentSkol=document.getElementById (\"cbIdentSkol\");
									var cbIdentSis=document.getElementById (\"cbIdentSis\");
									var cbPetunjuk=document.getElementById (\"cbPetunjuk\");
									var cbHal1=document.getElementById (\"cbHal1\");
									var cbHal2=document.getElementById (\"cbHal2\");
									var acbCover=cbCover.checked;
									var acbIdentSkol=cbIdentSkol.checked;
									var acbIdentSis=cbIdentSis.checked;
									var acbPetunjuk=cbPetunjuk.checked;
									var acbHal1=cbHal1.checked;
									var acbHal2=cbHal2.checked;
									//acbCover=(acbCover)? printContent('cetak-cover') : \"not checked\";
									if(acbCover=(acbCover)){printContent('cetak-cover');}
									if(acbIdentSkol=(acbIdentSkol)){printContent('cetak-sekolah');}
									if(acbIdentSis=(acbIdentSis)){printContent('cetak-identsiswa');}
									if(acbPetunjuk=(acbPetunjuk)){printContent('cetak-petunjuk');}
									if(acbHal1=(acbHal1)){printContent('cetak-hal1');}
									if(acbHal2=(acbHal2)){printContent('cetak-hal2');}
									document.getElementById(\"gantihalaman\").style.pageBreakInside=\"avoid\";
								}
								function savetopdf()
								{
									alert('Masih dalam pengembangan. Next time.....');
									parent.location='index.php?page=$page';
								
								}
								function GetCheckedState () {
									var input=document.getElementById (\"myInput\");
									var isChecked=input.checked;
									isChecked=(isChecked)? \"checked\" : \"not checked\";
									alert (\"The checkBox is \" + isChecked);
								}
							</script>
							<form method='post' action='index.php?page=$page&nis=$nis&semesterna=$semesterna' name='CtkRapor' class='smart-form'>
								<fieldset>
									<section>
										<div class='row'>
											<div class='col col-6'>
												<label class='checkbox'>
													<input type='checkbox' name='cbCover' id='cbCover'>
													<i></i>Cover</label>
												<label class='checkbox'>
													<input type='checkbox' name='cbIdentSkol' id='cbIdentSkol'>
													<i></i>Profil Sekolah</label>
												<label class='checkbox'>
													<input type='checkbox' name='cbIdentSis' id='cbIdentSis'>
													<i></i>Profil Siswa</label>
												<label class='checkbox'>
													<input type='checkbox' name='cbPetunjuk' id='cbPetunjuk'>
													<i></i>Petunjuk</label>
											</div>
											<div class='col col-6'>
												<label class='checkbox'>
													<input type='checkbox' name='cbHal1' id='cbHal1'>
													<i></i>1. Laporan Hasil Belajar</label>
												<label class='checkbox'>
													<input type='checkbox' name='cbHal2' id='cbHal2'>
													<i></i>2. Lain-lain</label>
											</div>
										</div>
									</section>
								</fieldset>
								<footer>
								<div class='row'>
									<div class='col col-4'>
									<label class='checkbox'><input type='checkbox' onclick='checkUncheckAll(this)'><i></i>Pilih Semua</label>
									</div>
									<div class='col col-4 pull-right'>
									<button class='btn btn-primary btn-sm' type='submit button' name='btnCetak' onclick='NyetakRapor()'>Cetak Rapor</button>
									</div>
									</div>
								</footer>
							</form>
						</div>
					</div>
				</div>
			</div>";
		}
		else if($semesterna=="nomergenep"){
			$PilihNyetak .= "
			<div class='col-xs-12 col-md-6'>
				<div class='jarviswidget' id='wid-id-19' data-widget-colorbutton='false' data-widget-colorbutton='false' data-widget-editbutton='false' data-widget-togglebutton='false' data-widget-fullscreenbutton='false' data-widget-deletebutton='false' data-widget-custombutton='false'>
					<header><span class='widget-icon'> <i class='fa fa-file-text-o'></i> </span><h2>Pilih Halaman Cetak</h2>
						<div class='widget-toolbar'>
							<button class='btn btn-default text-color-blue btn-md' data-toggle='modal' data-target='#WKProsesCetakRapor'>
								<i class='fa fa-question'></i>
							</button>
						</div>							
					</header>
					<div>
						<div class='jarviswidget-editbox'></div>
						<div class='widget-body no-padding'>
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
								function NyetakRapor() {
									var cbHal1=document.getElementById (\"cbHal1\");
									var cbHal2=document.getElementById (\"cbHal2\");
									var cbKeluar=document.getElementById (\"cbKeluar\");
									var cbMasuk=document.getElementById (\"cbMasuk\");
									var cbPrestasi=document.getElementById (\"cbPrestasi\");
									var acbHal1=cbHal1.checked;
									var acbHal2=cbHal2.checked;
									var acbKeluar=cbKeluar.checked;
									var acbMasuk=cbMasuk.checked;
									var acbPrestasi=cbPrestasi.checked;
									//acbCover=(acbCover)? printContent('cetak-cover') : \"not checked\";
									if(acbHal1=(acbHal1)){printContent('cetak-hal1');}
									if(acbHal2=(acbHal2)){printContent('cetak-hal2');}
									if(acbKeluar=(acbKeluar)){printContent('cetak-keluar');}
									if(acbMasuk=(acbMasuk)){printContent('cetak-masuk');}
									if(acbPrestasi=(acbPrestasi)){printContent('cetak-prestasi');}
									document.getElementById(\"gantihalaman\").style.pageBreakInside=\"avoid\";
								}
								function savetopdf()
								{
									alert('Masih dalam pengembangan. Next time.....');
									parent.location='index.php?page=$page';
								
								}
								function GetCheckedState () {
									var input=document.getElementById (\"myInput\");
									var isChecked=input.checked;
									isChecked=(isChecked)? \"checked\" : \"not checked\";
									alert (\"The checkBox is \" + isChecked);
								}
							</script>
							<form method='post' action='index.php?page=$page&nis=$nis&semesterna=$semesterna' name='CtkRapor' class='smart-form'>
								<fieldset>
									<section>
										<div class='row'>
											<div class='col col-6'>
												<label class='checkbox'>
													<input type='checkbox' name='cbHal1' id='cbHal1'>
													<i></i>1. Laporan Hasil Belajar</label>
												<label class='checkbox'>
													<input type='checkbox' name='cbHal2' id='cbHal2'>
													<i></i>2. Lain-lain</label>
											</div>
											<div class='col col-6'>
												<label class='checkbox'>
													<input type='checkbox' name='cbKeluar' id='cbKeluar'>
													<i></i>Pindah Keluar</label>
												<label class='checkbox'>
													<input type='checkbox' name='cbMasuk' id='cbMasuk'>
													<i></i>Pindah Masuk</label>
												<label class='checkbox'>
													<input type='checkbox' name='cbPrestasi' id='cbPrestasi'>
													<i></i>Prestasi Siswa</label>
											</div>
										</div>
									</section>
								</fieldset>
								<footer>
								<div class='row'>
									<div class='col col-4'>
									<label class='checkbox'><input type='checkbox' onclick='checkUncheckAll(this)'><i></i>Pilih Semua</label>
									</div>
									<div class='col col-4 pull-right'>
									<button class='btn btn-primary btn-sm' type='submit button' name='btnCetak' onclick='NyetakRapor()'>Cetak Rapor</button>
									</div>
									</div>
								</footer>
							</form>
						</div>
					</div>
				</div>
			</div>";
		}else if($semesterna=="nomerdua" || $semesterna=="nomertilu" || $semesterna=="nomerlema" || $semesterna=="nomeropat"){
			$PilihNyetak .= "
			<div class='col-xs-12 col-md-6'>
				<div class='jarviswidget' id='wid-id-19' data-widget-colorbutton='false' data-widget-colorbutton='false' data-widget-editbutton='false' data-widget-togglebutton='false' data-widget-fullscreenbutton='false' data-widget-deletebutton='false' data-widget-custombutton='false'>
					<header><span class='widget-icon'> <i class='fa fa-file-text-o'></i> </span><h2>Pilih Halaman Cetak</h2>
						<div class='widget-toolbar'>
							<button class='btn btn-default text-color-blue btn-md' data-toggle='modal' data-target='#WKProsesCetakRapor'>
								<i class='fa fa-question'></i>
							</button>
						</div>							
					</header>
					<div>
						<div class='jarviswidget-editbox'></div>
						<div class='widget-body no-padding'>
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
								function NyetakRapor() {
									var cbHal1=document.getElementById (\"cbHal1\");
									var cbHal2=document.getElementById (\"cbHal2\");
									var acbHal1=cbHal1.checked;
									var acbHal2=cbHal2.checked;
									//acbCover=(acbCover)? printContent('cetak-cover') : \"not checked\";
									if(acbHal1=(acbHal1)){printContent('cetak-hal1');}
									if(acbHal2=(acbHal2)){printContent('cetak-hal2');}
									document.getElementById(\"gantihalaman\").style.pageBreakInside=\"avoid\";
								}
								function savetopdf()
								{
									alert('Masih dalam pengembangan. Next time.....');
									parent.location='index.php?page=$page';
								
								}
								function GetCheckedState () {
									var input=document.getElementById (\"myInput\");
									var isChecked=input.checked;
									isChecked=(isChecked)? \"checked\" : \"not checked\";
									alert (\"The checkBox is \" + isChecked);
								}
							</script>
							<form method='post' action='index.php?page=$page&nis=$nis&semesterna=$semesterna' name='CtkRapor' class='smart-form'>
								<fieldset>
									<section>
										<div class='row'>
											<div class='col col-12'>
												<label class='checkbox'>
													<input type='checkbox' name='cbHal1' id='cbHal1'>
													<i></i>1. Laporan Hasil Belajar</label>
												<label class='checkbox'>
													<input type='checkbox' name='cbHal2' id='cbHal2'>
													<i></i>2. Lain-lain</label>
											</div>
										</div>
									</section>
								</fieldset>
								<footer>
								<div class='row'>
									<div class='col col-4'>
									<label class='checkbox'><input type='checkbox' onclick='checkUncheckAll(this)'><i></i>Pilih Semua</label>
									</div>
									<div class='col col-4 pull-right'>
									<button class='btn btn-primary btn-sm' type='submit button' name='btnCetak' onclick='NyetakRapor()'>Cetak Rapor</button>
									</div>
									</div>
								</footer>
							</form>
						</div>
					</div>
				</div>
			</div>";
		} else 
		{
			$PilihNyetak .= "
			<div class='col-xs-12 col-md-6'>
				<div class='jarviswidget' id='wid-id-19' data-widget-colorbutton='false' data-widget-colorbutton='false' data-widget-editbutton='false' data-widget-togglebutton='false' data-widget-fullscreenbutton='false' data-widget-deletebutton='false' data-widget-custombutton='false'>
					<header><span class='widget-icon'> <i class='fa fa-file-text-o'></i> </span><h2>Pilih Halaman Cetak</h2>
						<div class='widget-toolbar'>
							<button class='btn btn-default text-color-blue btn-md' data-toggle='modal' data-target='#WKProsesCetakRapor'>
								<i class='fa fa-question'></i>
							</button>
						</div>							
					</header>
					<div>
						<div class='jarviswidget-editbox'></div>
						<div class='widget-body no-padding'><br><br>
							<center>
								<span class='bigger-150'>
									<i class='txt-color-red fa fa-exclamation-triangle fa-4x'></i> <br>
									<h1>
										<small class='text-danger slideInRight fast animated'>
											<strong>Silakan Pilih Nama Siswa dan semester terlebih dahulu!<br> Jika sudah dipilih akan ada pilihan halaman cetak.</strong>
										</small>
									</h1>
								</span>
							</center>	<br><br>						
						</div>
					</div>
				</div>
			</div>";
		}
		$Cetak.="
		<section id='widget-grid' class=''>
			<div class='row'>
				<div class='col-xs-12 col-md-6'>
					<div class='jarviswidget' id='wid-id-18' data-widget-colorbutton='false' data-widget-colorbutton='false' data-widget-editbutton='false' data-widget-togglebutton='false' data-widget-fullscreenbutton='false' data-widget-deletebutton='false' data-widget-custombutton='false'>
						<header><span class='widget-icon'> <i class='fa fa-search'></i> </span><h2>Pilih Nama Siswa dan Semester</h2>
							<div class='widget-toolbar'>
								<button class='btn btn-default text-color-blue btn-md' data-toggle='modal' data-target='#WKCetakRapor'>
									<i class='fa fa-question'></i>
								</button>
							</div>
						</header>
						<div>
							<div class='jarviswidget-editbox'></div>
							<div class='widget-body'><br>".$CariSiswa."</div>
						</div>
					</div>
				</div>
				$PilihNyetak
			</div>
		</section>";
		echo $WKCetakRapor;
		echo $WKProsesCetakRapor;
		//$Cetak.=DuaKolomSama($CariSiswa,$PilihHalaman);
//================================================================================================================[TAMPIL DI BROWSER]
		if($nis==""){
			$ErrorManing="
				<center>
					<span class='bigger-150'>
						<i class='txt-color-red fa fa-exclamation-triangle fa-4x'></i> <br>
						<h1>
							<small class='text-danger slideInRight fast animated'>
								<strong>Silakan Pilih Nama Siswa <br>di bagian tag Cetak!</strong>
							</small>
						</h1>
					</span>
					<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
				</center>";
			$TampilCover=$ErrorManing;
			$TampilIdentSekolah=$ErrorManing;
			$TampilIdentSiswa=$ErrorManing;
			$TampilPetunjuk=$ErrorManing;
			$TampilHal1=$ErrorManing;
			$TampilHal2=$ErrorManing;
			$TampilKeluarSekolah=$ErrorManing;
			$TampilMasukSekolah=$ErrorManing;
			$TampilPrestasi=$ErrorManing;
		}
		else{
			$TampilCover=$cover;
			$TampilIdentSekolah=$IdentSekolah;
			$TampilIdentSiswa=$IdentSiswa;
			$TampilPetunjuk=$Petunjuk;
			$TampilHal1=$Hal1;
			$TampilHal2=$Hal2;
			$TampilKeluarSekolah=$KeluarSekolah;
			$TampilMasukSekolah=$MasukSekolah;
			$TampilPrestasi=$Prestasi;
		}
		$Raport.="
		<ul id='myTab' class='nav nav-tabs bordered'>
			<li class='active'><a data-toggle='tab' href='#cetak'><i class='txt-color-red fa fa-print font-lg'></i> <span class='hidden-mobile'>Cetak</span></a></li>
			<li class='dropdown'><a data-toggle='dropdown' class='dropdown-toggle' href='#'><i class='txt-color-red fa fa-book font-lg'></i> <span class='hidden-mobile'>Cover </span>&nbsp;<i class='ace-icon fa fa-caret-down bigger-110 width-auto'></i></a>
				<ul class='dropdown-menu dropdown-info'>
					<li><a data-toggle='tab' href='#cover'><i class='txt-color-red fa fa-circle font-xs'></i>&nbsp;&nbsp;Cover</a></li>
					<li><a data-toggle='tab' href='#idensekolah'><i class='txt-color-red fa fa-circle font-xs'></i>&nbsp;&nbsp;Profil Sekolah</a></li>
					<li><a data-toggle='tab' href='#idensiswa'><i class='txt-color-red fa fa-circle font-xs'></i>&nbsp;&nbsp;Profil Siswa</a></li>
					<li><a data-toggle='tab' href='#petunjuk'><i class='txt-color-red fa fa-circle font-xs'></i>&nbsp;&nbsp;Petunjuk</a></li>
				</ul>
			</li>
			<li class='dropdown'><a data-toggle='dropdown' class='dropdown-toggle' href='#'><i class='txt-color-red fa fa-mortar-board font-lg'></i> <span class='hidden-mobile'>Rapor </span>&nbsp;<i class='ace-icon fa fa-caret-down bigger-110 width-auto'></i></a>
				<ul class='dropdown-menu dropdown-info'>
					<li><a data-toggle='tab' href='#halaman1'>1. Lap. Hasil Belajar</a></li>
					<li><a data-toggle='tab' href='#halaman2'>2. Lain-lain </a></li>
				</ul>
			</li>
			<li class='dropdown'><a data-toggle='dropdown' class='dropdown-toggle' href='#'><i class='txt-color-red fa fa-exchange  font-lg'></i> <span class='hidden-mobile'>Pindah </span>&nbsp;<i class='ace-icon fa fa-caret-down bigger-110 width-auto'></i></a>
				<ul class='dropdown-menu dropdown-info'>
					<li><a data-toggle='tab' href='#keluar'><i class='txt-color-red fa fa-mail-forward'></i> Keluar</a></li>
					<li><a data-toggle='tab' href='#masuk'><i class='txt-color-red fa fa-mail-reply'></i> Masuk</a></li>
				</ul>
			</li>
			<li><a data-toggle='tab' href='#prestasi'><i class='txt-color-red fa fa-trophy font-lg'></i> <span class='hidden-mobile'>Prestasi</span></a></li>
			<!-- <li><a data-toggle='tab' href='#ranking'><i class='txt-color-red fa fa-cubes font-lg'></i> <span class='hidden-mobile'>Ranking</span></a></li> -->
		</ul>
		<div id='myTabContent' class='tab-content padding-10'>
			<div id='cetak' class='tab-pane fade in active'>$Cetak</div>
			<div id='cover' class='tab-pane fade'>$TampilCover</div>
			<div id='idensekolah' class='tab-pane fade'>$TampilIdentSekolah</div>
			<div id='idensiswa' class='tab-pane fade'>$TampilIdentSiswa</div>
			<div id='petunjuk' class='tab-pane fade'>$TampilPetunjuk</div>
			<div id='halaman1' class='tab-pane fade'>$TampilHal1</div>
			<div id='halaman2' class='tab-pane fade'>$TampilHal2</div>
			<div id='keluar' class='tab-pane fade'>$TampilKeluarSekolah</div>
			<div id='masuk' class='tab-pane fade'>$TampilMasukSekolah</div>
			<div id='prestasi' class='tab-pane fade'>$TampilPrestasi</div>
			<!-- <div id='ranking' class='tab-pane fade'>$Ranking</div> -->
		</div>
		";
		$ShowAdmin.=nt("informasi","Tahun Ajaran <strong>$PilTA1</strong> Kelas <strong>$NamaPilKelas1</strong><br>Tahun Ajaran <strong>$PilTA2</strong> Kelas <strong>$NamaPilKelas2</strong><br>Tahun Ajaran <strong>$PilTA3</strong> Kelas <strong>$NamaPilKelas3</strong><br>
		","Data Terpilih");
		$ShowAdmin.="<a href='?page=kurikulum-doksiswa-cetak-rapor' class='btn btn-default btn-sm pull-right' style='margin-top:7px;margin-right:10px;'>Halaman Awal</a>";
		$TampilCetak.='
		<div id="content">
			<section id="widget-grid" class="">
				<div class="row">
					<div class="col-xs-12 col-sm-12">
						<div class="well no-padding">'.$ShowAdmin.$Raport.'</div>
					</div>
				</div>
			</section>
		</div>';
		echo $TampilCetak;
	break;
	case "updatejarak":
		$jarakna=isset($_GET['jarakna'])?$_GET['jarakna']:"";
		$nis=isset($_GET['nis'])?$_GET['nis']:"";
		$semesterna=isset($_GET['semesterna'])?$_GET['semesterna']:"";
		mysql_query("update app_pilih_cetak_rapor set spasi='$jarakna' where id_pil='$IDna'");
		echo '<div id="preloader"><div id="cssload"></div></div>';
		echo InfoSimpan("Pilihan Data Sudah Disimpan","parent.location='?page=$page&nis=$nis&semesterna=$semesterna'");
	break;
}
//====================================================================================================================[BAGIAN HANDAP]
echo '</div>';
include("inc/footer.php");
include("inc/scripts.php");
//"))
?>