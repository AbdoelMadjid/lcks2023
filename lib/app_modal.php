<?php
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING | E_DEPRECATED));
session_start();

include "config.php";

$md= isset($_GET['md'])?$_GET['md']:""; 

if($md=="DetailKBM"){
	if($_POST['id']){
		$id = $_POST['id'];
		NgambilData("
		SELECT * FROM 
		gmp_ngajar, 
		ak_kelas, 
		app_user_guru, 
		ak_paketkeahlian, 
		ak_matapelajaran 
		WHERE 
		gmp_ngajar.kd_kelas=ak_kelas.kode_kelas AND 
		gmp_ngajar.kd_guru=app_user_guru.id_guru AND 
		gmp_ngajar.kd_pk=ak_paketkeahlian.kode_pk AND 
		gmp_ngajar.kd_mapel=ak_matapelajaran.kode_mapel AND 
		gmp_ngajar.id_ngajar='$id'");
		$KodePaket=$kode_pk." (".$nama_paket.")";
		$MaPel=$kode_mapel." (".$nama_mapel.")";
		$Kodekelas=$kode_kelas." (".$nama_kelas.")";
		$Semester=$semester." (".$ganjilgenap.")";
		$KKmPeng=$kkmpeng." (".terbilang($kkmpeng).")";
		$KKMKet=$kkmket." (".terbilang($kkmket).")";

		$TampilData.=DetailData("Nama Pengajar","$nama_lengkap");
		$TampilData.=DetailData("Tahun Ajaran","$thnajaran");
		$TampilData.=DetailData("Semester","$Semester");
		$TampilData.=DetailData("Paket Keahlian","$KodePaket");
		$TampilData.=DetailData("Kelas","$Kodekelas");
		$TampilData.=DetailData("Jenis Mapel","$jenismapel");
		$TampilData.=DetailData("Mata Pelajaran","$MaPel");
		$TampilData.=DetailData("KKM Pengetahuan","$KKmPeng");
		$TampilData.=DetailData("KKM Keterampilan","$KKMKet");

		echo KolomPanel($TampilData);
	}
}
else if($md=="DaftarSiswa"){

	if($_POST['id']){
		$id = $_POST['id'];
		$QLgrDok=mysql_query("
		select 
		ak_kelas.kode_kelas,
		ak_kelas.tahunajaran,
		ak_perkelas.nis,
		siswa_biodata.nm_siswa, 
		ak_kelas.nama_kelas
		from ak_kelas
		inner join ak_perkelas on ak_kelas.nama_kelas=ak_perkelas.nm_kelas and 
		ak_kelas.tahunajaran=ak_perkelas.tahunajaran
		inner join siswa_biodata on ak_perkelas.nis=siswa_biodata.nis
		where ak_kelas.kode_kelas='$id'");
		
		$NoDok=1;
		while($HDok=mysql_fetch_array($QLgrDok))
		{
			$NamaKelas=$HDok['nama_kelas'];
			$TDok.="
				<tr>
					<td align='center'>$NoDok</td>
					<td align='center' width='85'>".$HDok['nis']."</td>
					<td style='padding-left:10px;'>".$HDok['nm_siswa']."</td>
				</tr>";
			$NoDok++;
		}

		echo "
			<table style='margin: 0 auto; width:100%;border-collapse:collapse;font:16px Arial;'>
				<tr>
					<td align='center'><font size='4'><strong>DAFTAR SISWA KELAS ".$NamaKelas."</strong></font></td>
				</tr>
			</table><br>
			<table style='margin: 0 auto; width:100%;border-collapse:collapse;font:12px Arial;border-color:black;' border='1'>
				<thead>
					<tr bgcolor='#cccccc'>
						<th width='30' height='20'><center>No.</center></th>
						<th><center>NIS</center></th>
						<th><center>Nama Siswa</center></th>
					</tr>
				</thead>
				<tbody>$TDok</tbody>
			</table>
		";
	}

}
else if($md=="EditKasek"){

	if($_POST['id']){
		$id = $_POST['id'];
			NgambilData("select * from ak_kepsek where id_kepsek='$id'");
			$IsiForm.='<fieldset>';
			$IsiForm.=FormIF("horizontal","Nama Kepala Sekolah", "txtNamaKepsek",$nama,"6","");
			$IsiForm.=FormIF("horizontal","NIP", "txtNIP",$nip,"4","");
			$IsiForm.=FormCF("horizontal",'Tahun Ajaran','txtThnAjar','select * from ak_tahunajaran order by id_thnajar asc','tahunajaran',$thnajaran,'tahunajaran',"3","");
			$IsiForm.=FormCF("horizontal",'Semester','txtSmstr','select * from ak_semester','ganjilgenap',$smstr,'ganjilgenap',"3","");
			$IsiForm.='</fieldset>';
		echo $IsiForm;
	}
}
else if($md=="DetailProfilPTK"){

	if($_POST['id']){
		$id = $_POST['id'];
		NgambilData("SELECT * FROM app_user_guru where id_guru='$id'");
		
		if($gelarbelakang==""){$koma="";}else{$koma=",";}
		$NamaPTK=$gelardepan." ".ucwords(strtolower($nama_lengkap)).$koma." ".$gelarbelakang;
		
		$TampilData.=DetailData("ID","$id");
		$TampilData.=DetailData("NIP","$nip");
		$TampilData.=DetailData("Nama Lengkap","$NamaPTK");

		NgambilData("SELECT * FROM app_user_guru_bio where id_guru='$id'");
		
		$adadusun=empty($dusun)?"":"Dusun $dusun";
		$adajln=empty($jalan)?"":"Jalan $jalan";
		$adano=empty($norumah)?"":"Nomor $norumah";
		$adart=empty($rt)?"":"RT $rt";
		$adarw=empty($rw)?"":"RW $rw";
		$adadesa=empty($desa)?"":"Desa $desa";
		$adakec=empty($kec)?"":"Kesamatan $kec";
		$adakab=empty($kab)?"":"Kabupaten $kab";
		$adakpos=empty($kodepos)?"":"Kode Pos $kodepos";
		
		$tgllahir=empty($tempat_lahir) && empty($tanggal_lahir)?"":"$tempat_lahir, ".TglLengkap($tanggal_lahir)."";

		$alamat="$adadusun $adajln $adano $adart $adarw $adadesa $adakec $adakab $adakpos";

		$TampilData.=DetailData("Tempat Tanggal Lahir","$tgllahir");
		$TampilData.=DetailData("Agama","$agama");
		$TampilData.=DetailData("Email","$email");
		$TampilData.=DetailData("No. HP","$hp");
		$TampilData.=DetailData("Pin BB","$pinbb");
		$TampilData.=DetailData("Alamat","$alamat");
		$TampilData.=DetailData("Motto Hidup","$motto");

		echo KolomPanel($TampilData);
	}
}
else if($md=="EditDataPTK"){
	if($_POST['id']){
		$id = $_POST['id'];

		NgambilData("SELECT * FROM app_user_guru WHERE id_guru='$id'");

		//$EditPTK.=JudulKolom('Edit PTK','pencil-square-o');
		$EditPTK.=FormIF("horizontal","ID Guru", "txtKodes",$id_guru,'3','readonly=readonly');
		$EditPTK.=FormIF("horizontal","NIP","txtNIP",$nip,'5',"");
		$EditPTK.=FormIF("horizontal","Gelar Depan","txtGelarDepan",$gelardepan,'4',"");
		$EditPTK.=FormIF("horizontal","Nama","txtNama",htmlentities($nama_lengkap,ENT_QUOTES),'8',"");
		$EditPTK.=FormIF("horizontal","Gelar Belakang","txtGelarBelakang",$gelarbelakang,'4',"");
		$EditPTK.=FormIF("horizontal","User ID","txtUserID",$userid,'6','readonly=readonly');
		$EditPTK.=FormIF("horizontal","Password","txtKataKunci",$ket,'6',"");
		$EditPTK.=FormCR("horizontal",'Level User','txtHak',$hak,$Ref->LevelUserGuru,'5',"");
		$EditPTK.=FormCR("horizontal",'Jenis Kelamin','txtJenKel',$jk,$Ref->Gender,'4',"");
		$EditPTK.=FormCR("horizontal",'Jenis Guru','txtJenisGuru',$jenisguru,$Ref->JenisGuru,'4',"");
		$EditPTK.=FormIF("horizontal","Waktu Login", "txtWLogin",$waktu_login,'5','readonly=readonly');
		$EditPTK.=FormIF("horizontal","Waktu Logout", "txtWLogout",$waktu_logout,'5','readonly=readonly');
		$EditPTK.=FormIF("horizontal","Jumlah Login", "txtJmlLogin",$kunjung,'3','readonly=readonly');
		$EditPTK.=FormCR("horizontal",'Keaktifan','txtAKtif',$aktif,$Ref->Aktif,'5',"");
		$EditPTK.=FormIF("horizontal","Keterangan", "txtKeterangan",$keterangan,'8',"");
		
		echo KolomPanel($EditPTK);
	}

}
else if($md=="DataKBM"){

	if($_POST['id']){
		$id = $_POST['id'];		
		NgambilData("
		select 
		gmp_ngajar.id_ngajar,
		gmp_ngajar.thnajaran,
		gmp_ngajar.kd_mapel,
		gmp_ngajar.kd_guru,
		gmp_ngajar.kd_kelas,
		app_user_guru.id_guru,
		app_user_guru.nama_lengkap,
		ak_paketkeahlian.kode_pk,
		ak_paketkeahlian.nama_paket,
		ak_matapelajaran.kode_mapel,
		ak_matapelajaran.nama_mapel,
		ak_matapelajaran.jenismapel,
		ak_kelas.kode_kelas,
		ak_kelas.nama_kelas,
		gmp_ngajar.semester,
		gmp_ngajar.ganjilgenap,
		gmp_ngajar.kkmpeng,
		gmp_ngajar.kkmket
		from gmp_ngajar
		inner join ak_kelas on gmp_ngajar.kd_kelas=ak_kelas.kode_kelas
		inner join app_user_guru on gmp_ngajar.kd_guru=app_user_guru.id_guru
		inner join ak_paketkeahlian on gmp_ngajar.kd_pk=ak_paketkeahlian.kode_pk
		inner join ak_matapelajaran on gmp_ngajar.kd_mapel=ak_matapelajaran.kode_mapel
		where gmp_ngajar.id_ngajar='$id'");

		$QJSiswa=mysql_query("select * from ak_perkelas where tahunajaran='{$thnajaran}' and nm_kelas='$nama_kelas'");
		$HJSiswa=mysql_num_rows($QJSiswa);

		//====[PERSENTASE SIKAP SPRITUAL]
		$XDataNDSSpr=mysql_query("select * from n_sikap where kd_ngajar='$id' and spritual!='0'");
		$XjmlNDSSpr=mysql_num_rows($XDataNDSSpr);
		$DataNDSSpr=mysql_query("select * from n_sikap where kd_ngajar='$id' and spritual='0'");
		$jmlNDSSpr=mysql_num_rows($DataNDSSpr);
		if($jmlNDSSpr>0){
			$SudahSSpr=($HJSiswa-$jmlNDSSpr);
			$PersenSSpr=($SudahSSpr*100)/$HJSiswa;
		}
		else {
			$DataNDSSpra=mysql_query("select * from n_sikap where kd_ngajar='$id'");
			$jmlNDSSpra=mysql_num_rows($DataNDSSpra);
			if($jmlNDSSpra>0){$PersenSSpr="100";}else{$PersenSSpr="0";}
		}
		
		//====[PERSENTASE SIKAP SOSIAL]
		$XDataNDSSos=mysql_query("select * from n_sikap where kd_ngajar='$id' and sosial!='0'");
		$XjmlNDSSos=mysql_num_rows($XDataNDSSos);
		$DataNDSSos=mysql_query("select * from n_sikap where kd_ngajar='$id' and sosial='0'");
		$jmlNDSSos=mysql_num_rows($DataNDSSos);
		if($jmlNDSSos>0){
			$SudahSSos=($HJSiswa-$jmlNDSSos);
			$PersenSSos=($SudahSSos*100)/$HJSiswa;
		}
		else
		{
			$DataNDSSprb=mysql_query("select * from n_sikap where kd_ngajar='$id'");
			$jmlNDSSprb=mysql_num_rows($DataNDSSprb);
			if($jmlNDSSprb>0){$PersenSSos="100";}else{$PersenSSos="0";}
		}
		
		//====[PERSENTASE NILAI PENGETAHUAN]	
		$XDataNDP=mysql_query("select * from n_p_kikd where kd_ngajar='$id' and kikd_p!='0'");
		$XjmlNDP=mysql_num_rows($XDataNDP);
		$DataNDP=mysql_query("select * from n_p_kikd where kd_ngajar='$id' and kikd_p='0'");
		$jmlNDP=mysql_num_rows($DataNDP);
		if($jmlNDP>0){
			$SudahP=($HJSiswa-$jmlNDP);
			$PersenP=($SudahP*100)/$HJSiswa;
		}
		else
		{
			$DataNDPa=mysql_query("select * from n_p_kikd where kd_ngajar='$id'");
			$jmlNDPa=mysql_num_rows($DataNDPa);
			if($jmlNDPa>0){$PersenP="100";}else{$PersenP="0";}
		}
		
		//====[PERSENTASE NILAI KETERAMPILAN]
		$XDataNDK=mysql_query("select * from n_k_kikd where kd_ngajar='$id' and kikd_k!='0'");
		$XjmlNDK=mysql_num_rows($XDataNDK);
		$DataNDK=mysql_query("select * from n_k_kikd where kd_ngajar='$id' and kikd_k='0'");
		$jmlNDK=mysql_num_rows($DataNDK);
		if($jmlNDK>0){
			$SudahK=($HJSiswa-$jmlNDK);
			$PersenK=($SudahK*100)/$HJSiswa;
		}
		else
		{
			$DataNDKa=mysql_query("select * from n_k_kikd where kd_ngajar='$id'");
			$jmlNDKa=mysql_num_rows($DataNDKa);
			if($jmlNDKa>0){$PersenK="100";}else{$PersenK="0";}
		}
		
		//====[PERSENTASE NILAI UTS UAS]
		$XDataNDUTS=mysql_query("select * from n_utsuas where kd_ngajar='$id' and uts!='0'");
		$XjmlNDUTS=mysql_num_rows($XDataNDUTS);
		$DataNDUTS=mysql_query("select * from n_utsuas where kd_ngajar='$id' and uts='0'");
		$jmlNDUTS=mysql_num_rows($DataNDUTS);
		if($jmlNDUTS>0){
			$SudahUTS=($HJSiswa-$jmlNDUTS);
			$PersenUTS=($SudahUTS*100)/$HJSiswa;
		}
		else
		{
			$DataNDUTSa=mysql_query("select * from n_utsuas where kd_ngajar='$id'");
			$jmlNDUTSa=mysql_num_rows($DataNDUTSa);
			if($jmlNDUTSa>0){$PersenUTS="100";}else{$PersenUTS="0";}
		}
		$XDataNDUAS=mysql_query("select * from n_utsuas where kd_ngajar='$id' and uas!='0'");
		$XjmlNDUAS=mysql_num_rows($XDataNDUAS);
		$DataNDUAS=mysql_query("select * from n_utsuas where kd_ngajar='$id' and uas='0'");
		$jmlNDUAS=mysql_num_rows($DataNDUAS);
		if($jmlNDUAS>0){
			$SudahUAS=($HJSiswa-$jmlNDUAS);
			$PersenUAS=($SudahUAS*100)/$HJSiswa;
		}
		else
		{
			$DataNDUASa=mysql_query("select * from n_utsuas where kd_ngajar='$id'");
			$jmlNDUASa=mysql_num_rows($DataNDUASa);
			if($jmlNDUASa>0){$PersenUAS="100";}else{$PersenUAS="0";}
		}

		$ProfilKBM.=JudulKolom("Profil KBM","user");		
		$ProfilKBM.=DetailData("Nama Guru",$nama_lengkap);
		$ProfilKBM.=DetailData("Tahun Ajaran",$thnajaran);
		$ProfilKBM.=DetailData("Semester",$ganjilgenap);
		$ProfilKBM.=DetailData("Mata Pelajaran",$nama_mapel);
		$ProfilKBM.=DetailData("Kelas",$nama_kelas);
		$ProfilKBM.=DetailData("KKM K3",$kkmpeng." (".Terbilang($kkmpeng).")");
		$ProfilKBM.=DetailData("KKM K4",$kkmket. " (".Terbilang($kkmket).")");
		$ProfilKBM.=DetailData("Jumlah Siswa",$HJSiswa." (".Terbilang($HJSiswa).")");


		$HasilUpload.=JudulKolom("Hasil Upload Nilai","upload");
		$HasilUpload.=DetailData("<em>Nilai Spritual</em>","[$XjmlNDSSpr] ".round($PersenSSpr)."% (".Terbilang(round($PersenSSpr))." Persen)");
		$HasilUpload.=DetailData("<em>Nilai Sosial</em>","[$XjmlNDSSos] ".round($PersenSSos)."% (".Terbilang(round($PersenSSos))." Persen)");
		$HasilUpload.=DetailData("<em>Nilai Pengetahuan</em>","[$XjmlNDP] ".round($PersenP)."% (".Terbilang(round($PersenP))." Persen)");
		$HasilUpload.=DetailData("<em>Nilai Keterampilan</em>","[$XjmlNDK] ".round($PersenK)."% (".Terbilang(round($PersenK))." Persen)");
		$HasilUpload.=DetailData("<em>Nilai UTS</em>","[$XjmlNDUTS] ".round($PersenUTS)."% (".Terbilang(round($PersenUTS))." Persen)");
		$HasilUpload.=DetailData("<em>Nilai UAS</em>","[$XjmlNDUAS] ".round($PersenUAS)."% (".Terbilang(round($PersenUAS))." Persen)");

		echo $PilKBMTA;
		echo KolomPanel($ProfilKBM);
		echo KolomPanel($HasilUpload);
	}
}
else if($md=="AbsenEdit"){
	if($_POST['id']){
		$id = $_POST['id'];

		$QAB=mysql_query("select * from wk_absensi where id_absensi='$id'");
		$HAB=mysql_fetch_array($QAB);

		NgambilData("select nis,nm_siswa from siswa_biodata where nis='".$HAB['nis']."'");
		$Ngedit.="<input type='hidden' name='txtThnAjaran' value='".$HAB['tahunajaran']."'>";
		$Ngedit.="<input type='hidden' name='txtSmstr' value='".$HAB['semester']."'>";
		$Ngedit.="<input type='hidden' name='txtIdKelas' value='".$HAB['id_kelas']."'>";
		$Ngedit.="<input type='hidden' name='txtKDA' value='".$HAB['id_absensi']."'>";
		$Ngedit.=FormIF("horizontal","NIS","txtNIS",$nis,'4','readonly=readonly');
		$Ngedit.=FormIF("horizontal","Nama Siswa","txNMSiswa",$nm_siswa,'8','readonly=readonly');
		$Ngedit.=FormCR("horizontal",'Sakit','txtSakit',$HAB['sakit'],$Ref->JmlAbsen,'3',"");
		$Ngedit.=FormCR("horizontal",'Izin','txtIzin',$HAB['izin'],$Ref->JmlAbsen,'3',"");
		$Ngedit.=FormCR("horizontal",'Alfa','txtAlfa',$HAB['alfa'],$Ref->JmlAbsen,'3',"");
		echo $Ngedit;
	}
}else if($md=="EskulTambah"){
	if($_POST['id']){
		$id = $_POST['id'];

		NgambilData("select nis,nm_siswa from siswa_biodata where nis=$id");
		$DtEskulSis.="<strong class='text-danger align-center'>$nis <br>$nm_siswa</strong>";
		$Nambah1.="<input type='hidden' name='txtThnAjaran' value='".$TahunAjarAktif."'>";
		$Nambah1.="<input type='hidden' name='txtSmstr' value='".$SemesterAktif."'>";
		$Nambah1.="<input type='hidden' name='txtNIS' value='".$nis."'>";
		$Nambah1.="<input type='hidden' name='txNMSiswa' value='".$nm_siswa."'>";
		
		$Nambah2.=Label('Wajib');
		$Nambah2.=FormCF("horizontal",'Wajib','txtWajib',"select * from wk_eskul_data where jenis_eskul='Wajib'",'nama_eskul',$wajib,'nama_eskul','8',"");
		$Nambah2.=FormCR("horizontal",'Predikat','txtPWajib',$wajib_n,$Ref->NilaiEskul,'8',"");
		
		$Nambah3.=Label('Pilihan 1');
		$Nambah3.=FormCF("horizontal",'Pilihan 1','txtPil1',"select * from wk_eskul_data where jenis_eskul!='Wajib'",'nama_eskul',$pil1,'nama_eskul','8',"");
		$Nambah3.=FormCR("horizontal",'Predikat','txtPPil1',$pil1_n,$Ref->NilaiEskul,'8',"");
		
		$Nambah4.=Label('Pilihan 2');
		$Nambah4.=FormCF("horizontal",'Pilihan 2','txtPil2',"select * from wk_eskul_data where jenis_eskul!='Wajib'",'nama_eskul',$pil2,'nama_eskul','8',"");
		$Nambah4.=FormCR("horizontal",'Predikat','txtPPil2',$pil2_n,$Ref->NilaiEskul,'8',"");
		
		$Nambah5.=Label('Pilihan 3');
		$Nambah5.=FormCF("horizontal",'Pilihan 3','txtPil3',"select * from wk_eskul_data where jenis_eskul!='Wajib'",'nama_eskul',$pil3,'nama_eskul','8',"");
		$Nambah5.=FormCR("horizontal",'Predikat','txtPPil3',$pil3_n,$Ref->NilaiEskul,'8',"");
		
		$Nambah6.=Label('Pilihan 4');		
		$Nambah6.=FormCF("horizontal",'Pilihan 4','txtPil4',"select * from wk_eskul_data where jenis_eskul!='Wajib'",'nama_eskul',$pil4,'nama_eskul','8',"");
		$Nambah6.=FormCR("horizontal",'Predikat','txtPPil4',$pil4_n,$Ref->NilaiEskul,'8',"");
		
		echo $Nambah1;
		echo TigaKolomSama(KolomPanel($DtEskulSis).$Nambah2,$Nambah3.$Nambah4,$Nambah5.$Nambah6);
	}
}
else if($md=="EskulEdit"){
	if($_POST['id']){
		$id = $_POST['id'];
		
		NgambilData("select wk_eskul_siswa.*,siswa_biodata.nis,siswa_biodata.nm_siswa from wk_eskul_siswa,siswa_biodata where wk_eskul_siswa.nis=siswa_biodata.nis and wk_eskul_siswa.tahunajaran='$TahunAjarAktif' and wk_eskul_siswa.semester='$SemesterAktif' and wk_eskul_siswa.id_ekstra='$id'");
		$DtEskulSis.="<strong class='text-danger align-center'>$nis <br>$nm_siswa</strong>";
		$Ngedit1.="<input type='hidden' name='txtIdEkstra' value='$id'>";
		$Ngedit1.="<input type='hidden' name='txtThnAjaran' value='$TahunAjarAktif'>";
		$Ngedit1.="<input type='hidden' name='txtSmstr' value='$SemesterAktif'>";
		$Ngedit1.="<input type='hidden' name='txtNIS' value='$nis'>";
		$Ngedit1.="<input type='hidden' name='txNMSiswa' value='$nm_siswa'>";

		$Ngedit2.=Label('Wajib');
		$Ngedit2.=FormCF("horizontal",'Wajib','txtWajib','select * from wk_eskul_data','nama_eskul',$wajib,'nama_eskul','8',"");
		$Ngedit2.=FormCR("horizontal",'Predikat','txtPWajib',$wajib_n,$Ref->NilaiEskul,'8',"");
		
		$Ngedit3.=Label('Pilihan 1');
		$Ngedit3.=FormCF("horizontal",'Pilihan 1','txtPil1','select * from wk_eskul_data','nama_eskul',$pil1,'nama_eskul','8',"");
		$Ngedit3.=FormCR("horizontal",'Predikat','txtPPil1',$pil1_n,$Ref->NilaiEskul,'8',"");
		
		$Ngedit4.=Label('Pilihan 2');
		$Ngedit4.=FormCF("horizontal",'Pilihan 2','txtPil2','select * from wk_eskul_data','nama_eskul',$pil2,'nama_eskul','8',"");
		$Ngedit4.=FormCR("horizontal",'Predikat','txtPPil2',$pil2_n,$Ref->NilaiEskul,'8',"");
		
		$Ngedit5.=Label('Pilihan 3');
		$Ngedit5.=FormCF("horizontal",'Pilihan 3','txtPil3','select * from wk_eskul_data','nama_eskul',$pil3,'nama_eskul','8',"");
		$Ngedit5.=FormCR("horizontal",'Predikat','txtPPil3',$pil3_n,$Ref->NilaiEskul,'8',"");
		
		$Ngedit6.=Label('Pilihan 4');		
		$Ngedit6.=FormCF("horizontal",'Pilihan 4','txtPil4','select * from wk_eskul_data','nama_eskul',$pil4,'nama_eskul','8',"");
		$Ngedit6.=FormCR("horizontal",'Predikat','txtPPil4',$pil4_n,$Ref->NilaiEskul,'8',"");
		
		echo $Ngedit1;
		echo TigaKolomSama(KolomPanel($DtEskulSis).$Ngedit2,$Ngedit3.$Ngedit4,$Ngedit5.$Ngedit6);
	}

}
else if($md=="PrestasiTambah"){
	if($_POST['id']){
		$id = $_POST['id'];

		NgambilData("select nis,nm_siswa from siswa_biodata where nis=$id");
		$NgisiPres.="<input type='hidden' name='txtThnAjaran' value='".$TahunAjarAktif."'>";
		$NgisiPres.="<input type='hidden' name='txtSmstr' value='".$SemesterAktif."'>";
		$NgisiPres.=FormIF("horizontal","NIS","txtNIS",$nis,'4','readonly=readonly');
		$NgisiPres.=FormIF("horizontal","Nama Siswa","txNMSiswa",$nm_siswa,'8','readonly=readonly');
		$NgisiPres.=FormCR("horizontal",'Jenis','txtJenis',$jenis,$Ref->JenisPrestasi,'4',"");
		$NgisiPres.=FormCR("horizontal",'Tingkat Kejuaraan','txtTingkat',$tingkat,$Ref->TkPrestasi,'4',"");
		$NgisiPres.=FormCR("horizontal",'Juara Ke-','txtJuaraKe',$juarake,$Ref->JuaraKe,'4',"");
		$NgisiPres.=FormIF("horizontal","Nama Lomba","txtNamaLomba","",'8',"");		
		$NgisiPres.=IsiTgl('Tanggal Lomba','txtTglLomba','txtBlnLomba','txtThnLomba',"",2013);
		$NgisiPres.=FormIF("horizontal","Tempat Lomba","txtTmptLomba","",'8',"");	
		echo $NgisiPres;
	}
}
else if($md=="PrestasiEdit"){
	if($_POST['id']){
		$id = $_POST['id'];

		NgambilData("
			select 
			wk_prestasi_siswa.*, 
			siswa_biodata.nis,
			siswa_biodata.nm_siswa 
			from 
			wk_prestasi_siswa,
			siswa_biodata 
			where 
			wk_prestasi_siswa.nis=siswa_biodata.nis and 
			wk_prestasi_siswa.tahunajaran='$TahunAjarAktif' and 
			wk_prestasi_siswa.semester='$SemesterAktif' and 
			wk_prestasi_siswa.id_pres='$id'");

		$Ngedit.="<input type='hidden' name='txtThnAjaran' value='".$TahunAjarAktif."'>";
		$Ngedit.="<input type='hidden' name='txtSmstr' value='".$SemesterAktif."'>";
		$Ngedit.="<input type='hidden' name='txtIDPres' value='".$id_pres."'>";
		$Ngedit.=FormIF("horizontal","NIS","txtNIS",$nis,'4','readonly=readonly');
		$Ngedit.=FormIF("horizontal","Nama Siswa","txNMSiswa",$nm_siswa,'8','readonly=readonly');
		$Ngedit.=FormCR("horizontal",'Jenis','txtJenis',$jenis,$Ref->JenisPrestasi,'4',"");
		$Ngedit.=FormCR("horizontal",'Tingkat Kejuaraan','txtTingkat',$tingkat,$Ref->TkPrestasi,'4',"");
		$Ngedit.=FormCR("horizontal",'Juara Ke-','txtJuaraKe',$juarake,$Ref->JuaraKe,'4',"");
		$Ngedit.=FormIF("horizontal","Nama Lomba","txtNamaLomba",$nama_lomba,'8',"");		
		$Ngedit.=IsiTgl('Tanggal Lomba','txtTglLomba','txtBlnLomba','txtThnLomba',$tanggal,2013);
		$Ngedit.=FormIF("horizontal","Tempat Lomba","txtTmptLomba",$tempat,'8',"");	
		echo $Ngedit;
	}
}
else if($md=="PrakerinTambah"){
	if($_POST['id']){
		$id = $_POST['id'];

		NgambilData("select nis,nm_siswa from siswa_biodata where nis=$id");
		$NgisiPKL.=FormIF("horizontal","NIS","txtNIS",$nis,'4','readonly=readonly');
		$NgisiPKL.=FormIF("horizontal","Nama Siswa","txNMSiswa",$nm_siswa,'8','readonly=readonly');
		$NgisiPKL.=FormIF("horizontal","Nama Perusahaan","txtNmPerus",$perusahaan,'8',"");
		$NgisiPKL.=FormIF("horizontal","Alamat Perusahaan","txtAlPerus",$lokasi,'8',"");
		$NgisiPKL.=FormCR("horizontal",'Mulai','txtBlnMulai',$blnakhir,$Ref->NamaBulan,'4',"");
		$NgisiPKL.=FormCR("horizontal",'Akhir','txtBlnAkhir',$blnakhir,$Ref->NamaBulan,'4',"");
		$NgisiPKL.=FormCF("horizontal",'Tahun Ajaran','txtThnAjar','select * from ak_tahunajaran','tahunajaran',$tahunajaran,'tahunajaran','4',"");
		$NgisiPKL.=FormCR("horizontal",'Semester','txtSemester',$smstr,$Ref->Semester,'4',"");
		$NgisiPKL.=FormIF("horizontal","Nilai","txtNilpkl","",$nilai,'4',"");
		echo $NgisiPKL;
	}
}
else if($md=="PrakerinEdit"){
	if($_POST['id']){
		$id = $_POST['id'];
		
		$QPKL=mysql_query("select * from wk_prakerin where id_pkl='$id'");
		$HPKL=mysql_fetch_array($QPKL);
		NgambilData("select nis,nm_siswa from siswa_biodata where nis='".$HPKL['nis']."'");	
		//$Ngedit.=FormIF("Kode PKL","txtKodPKL",$HPKL['id_pkl'],'4','readonly=readonly');
		$Ngedit.="<input type='hidden' name='txtKodPKL' value='".$id."'>";
		$Ngedit.=FormIF("horizontal","NIS","txtNIS",$nis,'4','readonly=readonly');
		$Ngedit.=FormIF("horizontal","Nama Siswa","txNMSiswa",$nm_siswa,'8','readonly=readonly');
		$Ngedit.=FormIF("horizontal","Nama Perusahaan","txtNmPerus",$HPKL['perusahaan'],'8',"");
		$Ngedit.=FormIF("horizontal","Alamat Perusahaan","txtAlPerus",$HPKL['lokasi'],'8',"");
		$Ngedit.=FormCR("horizontal",'Mulai','txtBlnMulai',$HPKL['bln_awal'],$Ref->NamaBulan,'4',"");
		$Ngedit.=FormCR("horizontal",'Akhir','txtBlnAkhir',$HPKL['bln_akhir'],$Ref->NamaBulan,'4',"");
		$Ngedit.=FormCF("horizontal",'Tahun Ajaran','txtThnAjar','select * from ak_tahunajaran','tahunajaran',$HPKL['tahunajaran'],'tahunajaran','4',"");
		$Ngedit.=FormCR("horizontal",'Semester','txtSemester',$HPKL['semester'],$Ref->Semester,'4',"");
		$Ngedit.=FormIF("horizontal","Nilai","txtNilpkl",$HPKL['nilai'],'4',"");
		echo $Ngedit;
	}
}
else if($md=="CatatanWkEdit"){
	if($_POST['id']){
		$id = $_POST['id'];

		NgambilData("select wk_catatan.*, siswa_biodata.nis,siswa_biodata.nm_siswa from wk_catatan,siswa_biodata 
		where wk_catatan.nis=siswa_biodata.nis and wk_catatan.tahunajaran='$TahunAjarAktif' and 
		wk_catatan.semester='$SemesterAktif' and wk_catatan.id_cat='$id'");

		$EditCatatan.="<input type='hidden' name='txtThnAjaran' value='".$TahunAjarAktif."'>";
		$EditCatatan.="<input type='hidden' name='txtSmstr' value='".$SemesterAktif."'>";
		$EditCatatan.="<input type='hidden' name='txtIDCat' value='".$id."'>";
		//$EditCatatan.=FormTextDB("ID DB","txtIDCat",$id,'6','readonly=readonly');
		$EditCatatan.=FormIF("horizontal","NIS","txtNIS",$nis,'4','readonly=readonly');
		$EditCatatan.=FormIF("horizontal","Nama Siswa","txNMSiswa",$nm_siswa,'8','readonly=readonly');
		$EditCatatan.=FormIF("horizontal","Catatan","txtCatatan",$catatan,'8',"");		
		echo $EditCatatan;

	}

}
else if($md=="CatatanWkTambah"){
	if($_POST['id']){
		$id = $_POST['id'];
	
		NgambilData("select nis,nm_siswa from siswa_biodata where nis=$id");
		$NgisiCatatan.="<input type='hidden' name='txtThnAjaran' value='".$TahunAjarAktif."'>";
		$NgisiCatatan.="<input type='hidden' name='txtSmstr' value='".$SemesterAktif."'>";
		$NgisiCatatan.=FormIF("horizontal","NIS","txtNIS",$nis,'4','readonly=readonly');
		$NgisiCatatan.=FormIF("horizontal","Nama Siswa","txNMSiswa",$nm_siswa,'6','readonly=readonly');
		$NgisiCatatan.=FormIF("horizontal","Catatan","txtCatatan","",'8',"");
		echo $NgisiCatatan;
	}
}
else if($md=="RegPeriode"){

		$Registras.=JudulKolom("Registrasi","user");		
		$Registras.="
		<table class='table table-bordered'>
			<thead>
				<tr>
					<th class='text-center' width='150'>NAMA KOLOM</th>
					<th class='text-center'>KETERANGAN</th>
				</tr>
			</thead>
			<tbody>
			<tr>
				<td>Sekolah Asal</td>
				<td>Nama sekolah peserta didik sebelumnya. Untuk peserta didik baru, isikan nama sekolah pada jenjang sebelumnya. Sedangkan bagi peserta didik mutasi/pindahan, diisi dengan nama sekolah sebelum pindah <br>contoh : <code>SMP Negeri 1 Kadipaten</code></td>
			</tr>
			<tr>
				<td>Nomor Peserta UN SMP/MTs</td>
				<td>Nomor peserta ujian saat peserta didik masih di jenjang sebelumnya. Formatnya adalah x-xx-xx-xx-xxx-xxxx (20 digit). Untuk Peserta Didik WNA, diisi dengan Luar Negeri.<br>contoh : <code>2-16-02-25-502-051-6</code></td>
			</tr>
			<tr>
				<td>Nomor Seri Ijazah</td>
				<td>Nomor seri ijazah peserta didik pada jenjang sebelumnya <br>contoh : <code>DN-02 DI/06 0281663</code></td>
			</tr>
			<tr>
				<td>Nomor Seri SKHUN</td>
				<td>Nomor seri SKHUN/SHUN peserta didik pada jenjang sebelumnya (jika memiliki). <br>contoh : <code>DN-02 D 0575500</code></td>
			</tr>	
			</tbody>
		</table>
		";

		$Period.=JudulKolom("Periodik","user");		
		$Period.="
		<table class='table table-bordered'>
			<thead>
				<tr>
					<th class='text-center' width='150'>NAMA KOLOM</th>
					<th class='text-center'>KETERANGAN</th>
				</tr>
			</thead>
			<tbody>
			<tr>
				<td>Tinggi Badan</td>
				<td>Isi dengan tinggi badan</td>
			</tr>
			<tr>
				<td>Berat Badan</td>
				<td>Isi dengan berat badan</td>
			</tr>
			<tr>
				<td>Jarak Rumah dalam Kilometer</td>
				<td>Apabila jarak rumah peserta didik ke sekolah lebih dari 1 km, isikan dengan angka jarak yang sebenarnya pada kolom ini dalam satuan kilometer. Diisi dengan bilangan bulat (bukan pecahan)</td>
			</tr>
			<tr>
				<td>Jam Tempuh dan Menit Tempuh</td>
				<td>Lama tempuh peserta didik ke sekolah. Misalnya, peserta didik memerlukan waktu tempuh 1 jam 15 menit, maka Jam Tempuh diisi 1 sedangkan Menit Tempuh diisi 15. Apabila memerlukan waktu 25 menit, maka Jam Tempuh diisi 0 sedangkan Menit Tempuh diisi 25 </td>
			</tr>
			<tr>
				<td>Jumlah Saudara Kandung</td>
				<td>Jumlah saudara kandung yang dimiliki peserta didik. Jumlah saudara kandung dihitung tanpa menyertakan peserta didik, dengan rumus jumlah kakak ditambah jumlah adik. Isikan 0 apabila anak tunggal.</td>
			</tr>			
			</tbody>
		</table>
		";

		echo KolomPanel($Registras);
		echo KolomPanel($Period);
}
else if($md=="OrtuDapodik"){

		$AyaKandung.=JudulKolom("Ayah Kandung dan Ibu Kandung","user");		
		$AyaKandung.="
		<table class='table table-bordered'>
			<thead>
				<tr>
					<th class='text-center' width='150'>ITEM</th>
					<th class='text-center'>KETERANGAN</th>
				</tr>
			</thead>
			<tbody>
			<tr>
				<td>Nama Ayah/Ibu Kandung </td>
				<td>Nama ayah/ibu kandung peserta didik sesuai dokumen resmi yang berlaku. Hindari penggunaan gelar akademik atau sosial (seperti Alm., Dr., Drs., S.Pd, dan H.)</td>
			</tr>
			<tr>
				<td>NIK</td>
				<td>Nomor Induk Kependudukan yang tercantum pada Kartu Keluarga atau KTP ayah/ibu kandung peserta didik</td>
			</tr>
			<tr>
				<td>Tahun Lahir</td>
				<td>Tahun lahir ayah/ibu kandung peserta didik</td>
			</tr>
			<tr>
				<td>Pendidikan</td>
				<td>Pendidikan terakhir ayah/ibu kandung peserta didik</td>
			</tr>
			<tr>
				<td>Pekerjaan</td>
				<td>Pekerjaan utama ayah/ibu kandung peserta didik. Pilih Meninggal Dunia apabila ayah/ibu kandung peserta didik telah meninggal dunia</td>
			</tr>
			<tr>
				<td>Penghasilan Bulanan</td>
				<td>Rentang penghasilan ayah/ibu kandung peserta didik. Kosongkan kolom ini apabila ayah/ibu kandung peserta didik telah meninggal dunia atau tidak bekerja</td>
			</tr>
			<tr>
				<td>Bekebutuhan Khusus</td>
				<td>Kebutuhan khusus yang disandang oleh ayah/ibu peserta didik. Dapat dipilih lebih dari satu</td>
			</tr>			
			</tbody>
		</table>
		";
		$WaliSiswa.=JudulKolom("Wali Siswa","user");		
		$WaliSiswa.="
		<table class='table table-bordered'>
			<thead>
				<tr>
					<th class='text-center' width='150'>ITEM</th>
					<th class='text-center'>KETERANGAN</th>
				</tr>
			</thead>
			<tbody>
			<tr>
				<td>Wali Siswa</td>
				<td>Isi dengan Wali Siswa. <code>Jika ada wali</code> <br> Isian sesuai dengan petunuk Ayah dan Ibu Kandung</td>
			</tr>
			</tbody>
		</table>
		";
		echo KolomPanel($AyaKandung);
		echo KolomPanel($WaliSiswa);
}
else if($md=="DapodikSiswa"){

		$PetunjukDapSiswa.="
		<code>Berikut beberapa kolom isian yang harus di perhatikan!.</code><hr>
		<table class='table table-bordered'>
			<thead>
				<tr>
					<th class='text-center' width='150'>ITEM</th>
					<th class='text-center'>KETERANGAN</th>
				</tr>
			</thead>
			<tbody>
			<tr>
				<td>Nama</td>
				<td>Nama peserta didik sesuai dokumen resmi yang berlaku <code>(Akta atau Ijazah Jenjang sebelumnya )</code></td>
			</tr>
			<tr>
				<td>NIK</td>
				<td>Nomor Induk Kependudukan yang tercantum pada Kartu Keluarga, Kartu Identitas Anak, atau KTP (jika sudah memiliki) bagi WNI. <code>NIK memiliki format 16 digit angka. Contoh: 6112090906021104</code></td>
			</tr>
			<tr>
				<td>No. Registrasi Akta Lahir</td>
				<td>Nomor registrasi Akta Kelahiran. Nomor registrasi yang dimaksud umumnya tercantum pada bagian tengah atas lembar kutipan akta kelahiran</td>
			</tr>
			<tr>
				<td>Alamat Jalan</td>
				<td>Jalur tempat tinggal peserta didik, terdiri atas gang, kompleks, blok, nomor rumah, dan sebagainya selain informasi yang diminta oleh kolom-kolom yang lain pada bagian ini. Sebagai contoh, peserta didik tinggal di sebuah kompleks perumahan Griya Adam yang berada pada Jalan Kemanggisan, dengan nomor rumah 4-C, di lingkungan RT 005 dan RW 011, Dusun Cempaka, Desa Salatiga. Maka dapat diisi dengan Jl. Kemanggisan, Komp. Griya Adam, No. 4-C</td>
			</tr>
			<tr>
				<td>Nomor KKS</td>
				<td>Nomor Kartu Keluarga Sejahtera (jika memiliki). Nomor yang dimaksud adalah 6 digit kode yang tertera pada sisi belakang kiri atas kartu (di bawah lambang Garuda Pancasila). Peserta didik dinyatakan sebagai anggota KKS apabila tercantum di dalam kartu keluarga dengan kepala keluarga pemegang KKS. Sebagai contoh, peserta didik tercantum pada KK dengan kepala keluarganya adalah kakek. Apabila kakek peserta didik tersebut pemegang KKS, maka nomor KKS milik kakek peserta didik yang bersangkutan dapat diisikan pada kolom ini</td>
			</tr>
			<tr>
				<td>KPS</td>
				<td>Status peserta didik sebagai penerima manfaat KPS (Kartu Perlindungan Sosial)/PKH (Program Keluarga Harapan). Peserta didik dinyatakan sebagai penerima KPS/PKH apabila tercantum di dalam kartu keluarga dengan kepala keluarga pemegang KPS/PKH. Sebagai contoh, peserta didik tercantum pada KK dengan kepala keluarganya adalah kakek. Apabila kakek peserta didik tersebut pemegang KPS/PKH, maka peserta didik yang bersangkutan dinyatakan penerima KPS/PKH</td>
			</tr>
			<tr>
				<td>Nomor KIP</td>
				<td>Nomor KIP milik peserta didik apabila sebelumnya telah dipilih sebagai penerima KIP. Nomor yang dimaksud adalah 6 digit kode yang tertera pada sisi belakang kanan atas kartu (di bawah lambang toga)</td>
			</tr>

			<tr>
				<td>Lintang dan Bujur</td>
				<td>Menentukan Lintang dan Bujur rumah peserta didik. Silakan cek dengan aplikasi android untuk menentukan lintang dan bujur dengan mengaktifkan GPRS atau memakai google map. Silakan untuk di cek ketika berada di rumah sendiri. Jika salah perbaiki</td>
			</tr>
			</tbody>
		</table>
		";

		echo KolomPanel($PetunjukDapSiswa);
}
else if($md=="DetailProfilDapodik"){
	if($_POST['id']){
		$id = $_POST['id'];
		NgambilData("select * from dapodik_siswa where nis='{$id}'");

		$ProfilSiswa.=JudulKolom("Biodata Siswa","");
		$ProfilSiswa.=DetailData("NIS","$nis");
		$ProfilSiswa.=DetailData("NISN","$nisn");
		$ProfilSiswa.=DetailData("Nama Siswa","$nama_siswa");
		$ProfilSiswa.=DetailData("Jenis Kelamin","$jk");
		$ProfilSiswa.=DetailData("Warga Negara","$warganegara");
		$ProfilSiswa.=DetailData("NIK","$nik");
		$ProfilSiswa.=DetailData("TTL","$tempatlahir / $tanggallahir");
		$ProfilSiswa.=DetailData("Noreg Akta Lahir","$noregaktalahir");
		$ProfilSiswa.=DetailData("Anak Ke","$anakkeberapa");
		$ProfilSiswa.=DetailData("Berkebutuhan","$kebutuhankhusus");
		$ProfilSiswa.=DetailData("Agama","$agama");

		$ProfilAlamat.=JudulKolom("Alamat Siswa","");
		$ProfilAlamat.=DetailData("Alamat","$alamat");
		$ProfilAlamat.=DetailData("Nomor Rumah","$norumah");
		$ProfilAlamat.=DetailData("RT / RW","$rt / $rw");
		$ProfilAlamat.=DetailData("Dusun","$dusun");
		$ProfilAlamat.=DetailData("Desa","$desa");
		$ProfilAlamat.=DetailData("Kecamatan","$kec");
		$ProfilAlamat.=DetailData("Kabupaten","$kab");
		$ProfilAlamat.=DetailData("Kode Pos","$kodepos");
		$ProfilAlamat.=DetailData("Lintang","$lintang");
		$ProfilAlamat.=DetailData("Bujur","$bujur");
		$ProfilAlamat.=DetailData("Jenis Tinggal","$jenistinggal");
		$ProfilAlamat.=DetailData("Moda Trans","$modatarns");


		$KartuSiswa.=JudulKolom("Kartu Siswa","");
		$KartuSiswa.=DetailData("No. KKS","$nokks");
		$KartuSiswa.=DetailData("Penerima KPS","$penerimakps");
		$KartuSiswa.=DetailData("No. KPS","$nokps");
		$KartuSiswa.=DetailData("Penerima KIP","$penerimakip");
		$KartuSiswa.=DetailData("No. KIP","$nokip");
		$KartuSiswa.=DetailData("Nama Di KIP","$namadikip");
		$KartuSiswa.=DetailData("Bank","$bank");
		$KartuSiswa.=DetailData("No. Rek","$norekbank");
		$KartuSiswa.=DetailData("Atas Nama","$rekatasnama");

		$ProfilKontak.=JudulKolom("Kontak Siswa","");
		$ProfilKontak.=DetailData("Telepon","$telepon");
		$ProfilKontak.=DetailData("HP","$hp");
		$ProfilKontak.=DetailData("Email","$email");

		NgambilData("select * from dapodik_ortu where nis='{$id}'");

		$OrtuAyah.=JudulKolom("Ayah Kandung","");
		$OrtuAyah.=DetailData("Nama","$nm_ayah");
		$OrtuAyah.=DetailData("NIK","$nik_ayah");
		$OrtuAyah.=DetailData("Tahun Lahir","$tahunlahir_ayah");
		$OrtuAyah.=DetailData("Pendidikan","$pendidikan_ayah");
		$OrtuAyah.=DetailData("Pekerjaan","$pekerjaan_ayah");
		$OrtuAyah.=DetailData("Penghasilan","$penghasilan_ayah");
		$OrtuAyah.=DetailData("Berkebutuhan","$berkebutuhankhusus_ayah");

		$OrtuIbu.=JudulKolom("Ibu Kandung","");
		$OrtuIbu.=DetailData("Nama","$nm_ibu");
		$OrtuIbu.=DetailData("NIK","$nik_ibu");
		$OrtuIbu.=DetailData("Tahun Lahir","$tahunlahir_ibu");
		$OrtuIbu.=DetailData("Pendidikan","$pendidikan_ibu");
		$OrtuIbu.=DetailData("Pekerjaan","$pekerjaan_ibu");
		$OrtuIbu.=DetailData("Penghasilan","$penghasilan_ibu");
		$OrtuIbu.=DetailData("Berkebutuhan","$berkebutuhankhusus_ibu");

		$OrtuWali.=JudulKolom("Wali Siswa","");
		$OrtuWali.=DetailData("Nama","$nm_wali");
		$OrtuWali.=DetailData("NIK","$nik_wali");
		$OrtuWali.=DetailData("Tahun Lahir","$tahunlahir_wali");
		$OrtuWali.=DetailData("Pendidikan","$pendidikan_wali");
		$OrtuWali.=DetailData("Pekerjaan","$pekerjaan_wali");
		$OrtuWali.=DetailData("Penghasilan","$penghasilan_wali");

		NgambilData("select * from dapodik_registrasi where nis='{$id}'");

		$RegistrasiSiswa.=JudulKolom("Registrasi Siswa","");
		$RegistrasiSiswa.=DetailData("Sekolah Asal","$sekolahasal");
		$RegistrasiSiswa.=DetailData("No. Peserta UN","$nomorpesertaun");
		$RegistrasiSiswa.=DetailData("No. Seri Ijazah","$noseriijazah");
		$RegistrasiSiswa.=DetailData("No. Seri SKHUN","$noskhun");


		NgambilData("select * from dapodik_periodik where nis='{$id}'");
		$PeriodikSiswa.=JudulKolom("Periodik Siswa","");
		$PeriodikSiswa.=DetailData("TB / BB","$tinggibadan / $beratbadan");
		$PeriodikSiswa.=DetailData("Jarak Rumah","$jarakdlmkm");
		$PeriodikSiswa.=DetailData("Jam Menit","$jamtempuh / $menittempuh");
		$PeriodikSiswa.=DetailData("Jml Sdr Kandung","$saudarakandung");

		//echo KolomPanel($ProfilSiswa);
		//echo KolomPanel($ProfilAlamat);
		//echo KolomPanel($ProfilKontak);

		echo DuaKolom(
			6,
			KolomPanel($ProfilSiswa).
			KolomPanel($ProfilAlamat).
			KolomPanel($ProfilKontak).
			KolomPanel($KartuSiswa),
			6,
			KolomPanel($OrtuAyah).
			KolomPanel($OrtuIbu).
			KolomPanel($OrtuWali).
			KolomPanel($RegistrasiSiswa).
			KolomPanel($PeriodikSiswa)
		);
	}
}
else if($md=="IbuEdit"){
	if($_POST['id']){
		$id = $_POST['id'];
		
		NgambilData("select * from dapodik_ortu where nis='$id'");

		$QSis=mysql_query("select * from dapodik_siswa where nis='$id'");
		$HSis=mysql_fetch_array($QSis);
		
		$IbuKandung.='<fieldset>';
		$IbuKandung.="<input type='hidden' name='NIS' value='$id'>";
		$IbuKandung.=FormIF("horizontal","Nama Siswa","txtSiswa",htmlentities($HSis['nama_siswa'],ENT_QUOTES),'8',"readonly=readonly");
		$IbuKandung.=FormIF("horizontal","Nama Ibu Kandung","txtNamaIbu",$nm_ibu,'8',"");
		$IbuKandung.=FormIF("horizontal","NIK","txtNIKIbu",htmlentities($nik_ibu,ENT_QUOTES),'8',"Maxlength='16'");
		$IbuKandung.=FormIF("horizontal","Tahun Lahir","txtTLIbu",$tahunlahir_ibu,'4',"Maxlength='4'");
		$IbuKandung.=FormCF("horizontal",'Pendidikan','txtPendIbu','select * from ref_pendidikan','nama',$pendidikan_ibu,'nama','6',"");
		$IbuKandung.=FormCF("horizontal",'Pekerjaan','txtKerjaIbu','select * from ref_pekerjaan','nama',$pekerjaan_ibu,'nama','6',"");
		$IbuKandung.=FormCF("horizontal",'Penghasilan','txtHasilIbu','select * from ref_penghasilan','nama',$penghasilan_ibu,'nama','6',"");
		$IbuKandung.=FormCF("horizontal",'Berkebutuhan Khusus','txtButuhKhususIbu','ref_kebutuhankhusus','nama',$berkebutuhankhusus_ibu,'nama','6',"");
		$IbuKandung.='</fieldset>';
		
		Echo $IbuKandung;		
	}

}
else if($md=="AyahEdit"){
	if($_POST['id']){
		$id = $_POST['id'];
		
		NgambilData("select * from dapodik_ortu where nis='$id'");

		$QSis=mysql_query("select * from dapodik_siswa where nis='$id'");
		$HSis=mysql_fetch_array($QSis);
		
		$AyahKandung.='<fieldset>';
		$AyahKandung.="<input type='hidden' name='NIS' value='$id'>";
		$AyahKandung.=FormIF("horizontal","Nama Siswa","txtSiswa",htmlentities($HSis['nama_siswa'],ENT_QUOTES),'8',"readonly=readonly");
		$AyahKandung.=FormIF("horizontal","Nama Ayah Kandung","txtNamaAyah",$nm_ayah,'8',"");
		$AyahKandung.=FormIF("horizontal","NIK","txtNIKAyah",$nik_ayah,'8',"Maxlength='16'","");
		$AyahKandung.=FormIF("horizontal","Tahun Lahir","txtTLAyah",$tahunlahir_ayah,'4',"Maxlength='4'");
		$AyahKandung.=FormCF("horizontal",'Pendidikan','txtPendAyah','select * from ref_pendidikan',$pendidikan_ayah,'nama','nama','6',"");
		$AyahKandung.=FormCF("horizontal",'Pekerjaan','txtKerjaAyah','select * from ref_pekerjaan',$pekerjaan_ayah,'nama','nama','6',"");
		$AyahKandung.=FormCF("horizontal",'Penghasilan','txtHasilAyah','select * from ref_penghasilan',$penghasilan_ayah,'nama','nama','6',"");
		$AyahKandung.=FormCF("horizontal",'Berkebutuhan Khusus','txtButuhKhususAyah','select * from ref_kebutuhankhusus','nama',$berkebutuhankhusus_ayah,'nama','6',"");
		$AyahKandung.='</fieldset>';
		
		Echo $AyahKandung;		
	}
}
else if($md=="RegistrasiEdit"){
	if($_POST['id']){
		$id = $_POST['id'];
		
		NgambilData("select * from dapodik_registrasi where nis='$id'");

		$QSis=mysql_query("select * from dapodik_siswa where nis='$id'");
		$HSis=mysql_fetch_array($QSis);
		
		$Registrasi.='<fieldset>';
		$Registrasi.="<input type='hidden' name='NIS' value='$id'>";
		$Registrasi.=FormIF("horizontal","Nama Siswa","txtSiswa",htmlentities($HSis['nama_siswa'],ENT_QUOTES),'8',"readonly=readonly");
		$Registrasi.=FormIF("horizontal","Sekolah Asal SMP/Mts","txtSekolahAsal",htmlentities($sekolahasal,ENT_QUOTES),'8',"");
		$Registrasi.=FormIF("horizontal","Nomor Peserta UN SMP/MTs","txtNoSertaUN",$nomorpesertaun,'8',"Maxlength='20'");
		$Registrasi.=FormIF("horizontal","Nomor Seri Ijazah","txtNoSeriIjazah",$noseriijazah,'6',"");
		$Registrasi.=FormIF("horizontal","Nomor Seri SKHUN","txtNoSKHUN",$noskhun,'6',"");
		$Registrasi.='</fieldset>';
		
		Echo $Registrasi;		
	}
}
else if($md=="PeriodikEdit"){
	if($_POST['id']){
		$id = $_POST['id'];
		
		NgambilData("select * from dapodik_periodik where nis='$id'");

		$QSis=mysql_query("select * from dapodik_siswa where nis='$id'");
		$HSis=mysql_fetch_array($QSis);
		
		$DtPeriodik.='<fieldset>';
		$DtPeriodik.="<input type='hidden' name='NIS' value='$id'>";
		$DtPeriodik.=FormIF("horizontal","Nama Siswa","txtSiswa",htmlentities($HSis['nama_siswa'],ENT_QUOTES),'8',"readonly=readonly");
		$DtPeriodik.=FormIF("horizontal","Tinggi Badan","txtTB",$tinggibadan,'4',"Maxlength='3'","");
		$DtPeriodik.=FormIF("horizontal","Berat Badan","txtBB",$beratbadan,'4',"Maxlength='2'","");
		$DtPeriodik.=FormIF("horizontal","Jarak Rumah dalam Kilometer","txtJarakRumah",$jarakdlmkm,'4',"Maxlength='2'");
		$DtPeriodik.=FormIF("horizontal","Jam Tempuh","txtJamTempuh",$jamtempuh,'4',"Maxlength='2'","");
		$DtPeriodik.=FormIF("horizontal","Menit Tempuh","txtMenitTempuh",$menittempuh,'4',"Maxlength='2'","");
		$DtPeriodik.=FormCR("horizontal",'Jumlah Saudara Kandung','txtJmlSaudara',$saudarakandung,$Ref->Angka,'3',"Maxlength='1'");
		$DtPeriodik.='</fieldset>';
		
		Echo $DtPeriodik;		
	}
}
else if($md=="KartuEdit"){
	if($_POST['id']){
		$id = $_POST['id'];
		
		NgambilData("select * from dapodik_siswa where nis='$id'");	
		$KartuSiswa.='<fieldset>';
		$KartuSiswa.="<input type='hidden' name='NIS' value='$id'>";
		$KartuSiswa.=FormIF("horizontal","Nama Siswa","txtSiswa",htmlentities($nama_siswa,ENT_QUOTES),'8',"readonly=readonly");
		$KartuSiswa.=FormIF("horizontal","Nomor KKS","txtNoKKS",$nokks,'5',"");
		$KartuSiswa.=FormCR("horizontal",'Penerima KPS','txtPenerimaKPS',$penerimakps,$Ref->YaTidak,'3',"");
		$KartuSiswa.=FormIF("horizontal","Nomor KPS","txtNoKPS",$nokps,'5',"");
		$KartuSiswa.=FormCR("horizontal",'Penerima KIP','txtPenerimaKIP',$penerimakip,$Ref->YaTidak,'3',"");
		$KartuSiswa.=FormIF("horizontal","Nomor KIP","txtNoKIP",$nokip,'5',"");
		$KartuSiswa.=FormIF("horizontal","Nama di KIP","txtNamaKIP",$namadikip,'5',"");
		$KartuSiswa.=FormIF("horizontal","Nama Bank","txtNamaBank",$bank,'5',"");
		$KartuSiswa.=FormIF("horizontal","No. Rekening","txtNoRek",$norekbank,'5',"");
		$KartuSiswa.=FormIF("horizontal","Rekening Atas Nama","txtNamaRek",$rekatasnama,'5',"");
		$KartuSiswa.='</fieldset>';

		Echo $KartuSiswa;		
	}
}
else if($md=="KontakEdit"){
	if($_POST['id']){
		$id = $_POST['id'];
		
		NgambilData("select * from dapodik_siswa where nis='$id'");	
		$KontakSiswa.='<fieldset>';
		$KontakSiswa.="<input type='hidden' name='NIS' value='$id'>";
		$KontakSiswa.=FormIF("horizontal","Nama Siswa","txtSiswa",htmlentities($nama_siswa,ENT_QUOTES),'8',"readonly=readonly");
		$KontakSiswa.=FormIF("horizontal","Telepon","txtTelepon",$telepon,'4',"");
		$KontakSiswa.=FormIF("horizontal","HP/Mobile","txtHP",$hp,'4',"");
		$KontakSiswa.=FormIF("horizontal","Email","txtEmail",$email,'8',"");
		$KontakSiswa.=FormIF("horizontal","Lintang","txtLintang",$lintang,'3',"");
		$KontakSiswa.=FormIF("horizontal","Bujur","txtBujur",$bujur,'3',"");
		$KontakSiswa.='</fieldset>';

		Echo $KontakSiswa;		
	}
}
else if($md=="TransEdit"){
	if($_POST['id']){
		$id = $_POST['id'];
		
		NgambilData("select * from dapodik_siswa where nis='$id'");	
		$AlamatSiswa.='<fieldset>';
		$AlamatSiswa.="<input type='hidden' name='NIS' value='$id'>";
		$AlamatSiswa.=FormIF("horizontal","Nama Siswa","txtSiswa",htmlentities($nama_siswa,ENT_QUOTES),'8',"readonly=readonly");
		$AlamatSiswa.=FormCF("horizontal",'Tempat Tinggal','txtTTinggal','select * from ref_tempattinggal',$jenistinggal,'nama','nama','5',"");
		$AlamatSiswa.=FormCF("horizontal",'Moda Transportasi','txtModaTrans','select * from ref_transportasi','nama',$modatarns,'nama','8',"");
		$AlamatSiswa.='</fieldset>';

		Echo $AlamatSiswa;		
	}
}
else if($md=="AlamatEdit"){
	if($_POST['id']){
		$id = $_POST['id'];
		
		NgambilData("select * from dapodik_siswa where nis='$id'");	
		$AlamatSiswa.='<fieldset>';
		$AlamatSiswa.="<input type='hidden' name='NIS' value='$id'>";
		$AlamatSiswa.=FormIF("horizontal","Nama Siswa","txtSiswa",htmlentities($nama_siswa,ENT_QUOTES),'8',"readonly=readonly");
		$AlamatSiswa.=FormIF("horizontal","Alamat Jalan","txtAlamat",$alamat,'8',"");
		$AlamatSiswa.=FormIF("horizontal","Nomor Rumah","txtNoRumah",$norumah,'2',"");
		$AlamatSiswa.=FormIF("horizontal","RT","txtRT",$rt,'2',"");
		$AlamatSiswa.=FormIF("horizontal","RW","txtRW",$rw,'2',"");
		$AlamatSiswa.=FormIF("horizontal","Dusun","txtDusun",$dusun,'5',"");
		$AlamatSiswa.=FormIF("horizontal","Desa","txtDesa",$desa,'5',"");
		$AlamatSiswa.=FormIF("horizontal","Kecamatan","txtKec",$kec,'5',"");
		$AlamatSiswa.=FormIF("horizontal","Kabupaten","txtKab",$kab,'5',"");
		$AlamatSiswa.=FormIF("horizontal","Kode Pos","txtKodePos",$kodepos,'3',"");
		$AlamatSiswa.='</fieldset>';

		Echo $AlamatSiswa;		
	}
}
else if($md=="BioEdit"){
	if($_POST['id']){
		$id = $_POST['id'];
		
		NgambilData("select * from dapodik_siswa where nis='$id'");	
		$BioSiswa.='<fieldset>';
		$BioSiswa.=FormIF("horizontal","NIS","NIS",$nis,'3',"readonly=readonly");
		$BioSiswa.=FormIF("horizontal","NISN","txtNISN",$nisn,'3',"");
		$BioSiswa.=FormIF("horizontal","Nama Siswa","txtNamaSiswa",htmlentities($nama_siswa,ENT_QUOTES),'8',"");
		$BioSiswa.=FormCR("horizontal",'Jenis Kelamin','txtJenKel',$jk,$Ref->Jenkel,'2',"");
		$BioSiswa.=FormIF("horizontal","Warga Negara","txtWargaNegara",$warganegara,'3',"");
		$BioSiswa.=FormIF("horizontal","NIK","txtNIK",$nik,'4',"Maxlength='16'","");
		$BioSiswa.=FormIF("horizontal","Tempat Lahir","txtTmpLahir",$tempatlahir,'4',"");
		$BioSiswa.=IsiTgl('Tanggal Lahir','txtTglLahir','txtBlnLahir','txtThnLahir',$tanggallahir,1990);
		$BioSiswa.=FormIF("horizontal","No Register Akta Lahir","txtNoRegAkta",$noregaktalahir,'4',"");
		$BioSiswa.=FormCR("horizontal",'Anak Ke','txtAnakKe',$anakkeberapa,$Ref->Angka,'2',"");
		$BioSiswa.=FormCF("horizontal",'Berkebutuhan Khusus','txtButuhKhusus','select * from ref_kebutuhankhusus','nama',$kebutuhankhusus,'nama','4',"");
		$BioSiswa.=FormCF("horizontal",'Agama','txtAgama','select * from ref_agama','nama',$agama,'nama','4',"");
		$BioSiswa.='</fieldset>';

		Echo $BioSiswa;		
	}
}
?>