<?php
require_once("inc/init.php");
require_once("inc/config.ui.php");
$page_title = "Perkelas";
$page_css[] = "your_style.css";
include("inc/header.php");
$page_nav["kurikulum"]["sub"]["datakbm"]["sub"]["perkelas"]["active"] = true;
include("inc/nav.php");
echo "<div id='main' role='main'>";
$breadcrumbs["Kurikulum / Proses KBM"] = "";
include("inc/ribbon.php");	
$sub = (isset($_GET['sub']))? $_GET['sub'] : "";
switch ($sub)
{
	case "tampil":default:

		$AdaPilihangak=JmlDt("select tahunajaran,kode_kelas from ak_kelas where tahunajaran='$PilTA' and kode_kelas='$PilKdKls'");
		$SudahGenerate=JmlDt("select thnajaran,semester,id_kls from leger_nilai_mapel where thnajaran='$PilTA' and semester='$PilSmstr' and id_kls='$PilKdKls'");
// FORM ADMIN NYARI DATA
		
		$NyariData.="<h6 class='text-danger'><i class='fa fa-search'></i> <strong>Pilih Data</strong></h6>
		<hr class='simple'>";
		$NyariData.="
		<form action='?page=$page' method='post' name='frmaing' class='smart-form' role='form'>
			<fieldset>";
		$NyariData.=FormCF("smart","Tahun Pelajaran","txtThnAjar","select * from ak_tahunajaran order by id_thnajar asc","tahunajaran",$PilTA,"tahunajaran","4","onchange=\"document.location.href='?page=$page&amp;sub=updateta&thnajar='+document.frmaing.txtThnAjar.value\"");
		if(!empty($PilTA)){		
			$NyariData.=FormCF("smart","Semester","txtGG","select * from ak_semester","ganjilgenap",$PilSmstr,"ganjilgenap","4","onchange=\"document.location.href='?page=$page&amp;sub=updategg&gg='+document.frmaing.txtGG.value\"");
		}
		if(!empty($PilSmstr)){
			$NyariData.=FormCR("smart",'Jarak Cetak','txtTinggi',$PilTingC,$Ref->TinggiCetak,'4',"onchange=\"document.location.href='?page=$page&amp;sub=updatetinggi&tinggi='+document.frmaing.txtTinggi.value\"");
		}
		$NyariData.="				
			</fieldset>
		</form>";


		if($AdaPilihangak>0 && $SudahGenerate>0){
			$NyariData.="
			<h6 class='text-danger'><i class='fa fa-print'></i> <strong>Cetak Data</strong></h6><hr class='simple'>
			<a href='javascript:void(0);' class='btn btn-default btn-sm btn-block' onclick=\"printContent('cetakDataPengajar')\">Data KBM</a> 
			<a href='javascript:void(0);' class='btn btn-default btn-sm btn-block' onclick=\"printContent('cetakAbsensiMapel')\">Absensi Mata Pelajaran</a>
			<a href='javascript:void(0);' class='btn btn-default btn-sm btn-block' onclick=\"printContent('cetakK3')\">Leger Pengetahuan</a> 
			<a href='javascript:void(0);' class='btn btn-default btn-sm btn-block' onclick=\"printContent('cetakK4')\">Leger Keterampilan</a> 
			<a href='javascript:void(0);' class='btn btn-default btn-sm btn-block' onclick=\"printContent('cetakNA')\">Leger Nilai Akhir</a>
			<a href='javascript:void(0);' class='btn btn-default btn-sm btn-block' onclick=\"printContent('cetakAbsensi')\">Absensi Wali Kelas</a>
			<a href='javascript:void(0);' class='btn btn-default btn-sm btn-block' onclick=\"printContent('cetakRanking')\">Peringkat Kelas</a>
			<a href='javascript:void(0);' class='btn btn-default btn-sm btn-block' onclick=\"printContent('cetakDok')\">Penerimaan Rapor</a>";
		}
		else
		{
			$NyariData.="";
		}

// IDENTITAS DAN DATABASE
		
		$QProfil=mysql_query("select * from app_lembaga");
		$HProfil=mysql_fetch_array($QProfil);

		$QWK=mysql_query("
			select 
			ak_kelas.id_guru,
			app_user_guru.nip,
			app_user_guru.nama_lengkap,
			app_user_guru.gelardepan,
			app_user_guru.gelarbelakang,
			ak_kelas.nama_kelas 
			from ak_kelas,app_user_guru 
			where ak_kelas.id_guru=app_user_guru.id_guru and 
			ak_kelas.kode_kelas='$PilKdKls' and 
			ak_kelas.tahunajaran='$PilTA'");

		$HWK=mysql_fetch_array($QWK);
		if($HWK['gelarbelakang']==""){$koma="";}else{$koma=",";}
		$NIPWK="NIP. ".$HWK['nip'];
		$NamaWK=$HWK['gelardepan']." ".$HWK['nama_lengkap'].$koma." ".$HWK['gelarbelakang'];
		$Kalasname=$HWK['nama_kelas'];

		$Titimangsa=$HProfil['kecamatan'];
		$Tgl=TglLengkap($tglSekarang=date('Y-m-d'));

		$QKS=mysql_query("select * from ak_kepsek where thnajaran='$PilTA' and smstr='$PilSmstr'");
		$HKS=mysql_fetch_array($QKS);
		$NamaKepsek=$HKS['nama'];
		$NIPKepsek=$HKS['nip'];

		$IdentKelas="
		<table style='margin: 0 auto; width:100%;border-collapse:collapse;font:14px Arial;'>
		<tr>
			<td width='100'>Tahun Ajaran</td>
			<td width='5'>:</td>
			<td>$PilTA</td>
		</tr>
		<tr>
			<td>Semester</td>
			<td>:</td>
			<td>$PilSmstr</td>
		</tr>
		<tr>
			<td>Kelas</td>
			<td>:</td>
			<td>$Kalasname [$PilKdKls]</td>
		</tr>
		</table>";

		$KepsekWaliKelas="
		<table style='margin: 0 auto;width:100%;border-collapse:collapse;font:14px Arial;'>
			<tr>
				<td width='50'>&nbsp;</td>
				<td width='300'><br><br>
					Mengetahui : <br>
					Kepala Sekolah, <br><br><br><br><br>
					<strong>$NamaKepsek</strong><br>
					NIP. $NIPKepsek</td>
				<td width='400'>&nbsp;</td>
				<td width='300'><br><br>
					$Titimangsa, <!-- $Tgl --><br>
					Wali Kelas, <br><br><br><br><br>
					<strong>$NamaWK</strong><br>
					$NIPWK</td>
				<td width='40'>&nbsp;</td>
			</tr>
		</table>";

		$KepsekWaliKelas2="
		<table style='margin: 0 auto;width:100%;border-collapse:collapse;font:14px Arial;'>
			<tr>
				<td width='50'>&nbsp;</td>
				<td width='400'><br><br>
					Mengetahui : <br>
					Kepala Sekolah, <br><br><br><br><br>
					<strong>$NamaKepsek</strong><br>
					NIP. $NIPKepsek</td>
				<td width='500'>&nbsp;</td>
				<td width='400'><br><br>
					$Titimangsa, <!-- $Tgl --><br>
					Wali Kelas, <br><br><br><br><br>
					<strong>$NamaWK</strong><br>
					$NIPWK</td>
				<td width='40'>&nbsp;</td>
			</tr>
		</table>";		

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
		gmp_ngajar.kd_kelas='$PilKdKls' and 
		gmp_ngajar.thnajaran='$PilTA' and
		gmp_ngajar.ganjilgenap='$PilSmstr' 
		order by gmp_ngajar.kd_kelas,gmp_ngajar.kd_mapel asc");
		$JmlMP=mysql_num_rows($Q);

// TAB GENERATE 

		$QKelas=mysql_query("select * from ak_kelas where tahunajaran='$PilTA' order by tingkat,kode_kelas");
		$JKelas=mysql_num_rows($QKelas);

		$no=1;
		while($HKelas=mysql_fetch_array($QKelas))
		{		
			$KdPK=$HKelas['kode_pk'];

			$QJmlKBM=JmlDt("select * from gmp_ngajar where kd_kelas='{$HKelas['kode_kelas']}'and thnajaran='$PilTA' and ganjilgenap='$PilSmstr'");
			ngambildata("select * from app_user_guru where id_guru='{$HKelas['id_guru']}'");

			if($HKelas['tingkat']=="X"){$warnana="#339900";$warnatmbl='success';}
			else if($HKelas['tingkat']=="XI"){$warnana="blue";$warnatmbl='primary';}
			else if($HKelas['tingkat']=="XII"){$warnana="red";$warnatmbl='danger';}




			$JmlSiswa=JmlDt("select * from ak_perkelas where nm_kelas='{$HKelas['nama_kelas']}'and tahunajaran='$PilTA'");

			// cek data leger

			$CekKBMMapel=JmlDt("select * from leger_nilai_mapel where id_kls='".$HKelas["kode_kelas"]."' and thnajaran='$PilTA' and semester='$PilSmstr'");

			if($CekKBMMapel>0)
			{
				$TmbKBM="<a href='?page=$page&sub=hapus_kd_ngajar&thnajaran=$PilTA&gg=$PilSmstr&tk=".$HKelas["tingkat"]."&kls=".$HKelas["kode_kelas"]."'  class='btn btn-default btn-xs btn-block'><i class='fa fa-trash'></i></a> ";
			}
			else
			{
				$TmbKBM="<a href='?page=$page&sub=simpan_kd_ngajar&thnajaran=$PilTA&tk=".$HKelas["tingkat"]."&gg=$PilSmstr&kls=".$HKelas["kode_kelas"]."' class='btn btn-default btn-xs btn-block'><i class='fa fa-floppy-o'></i></a> ";
			}

			if($PilKdKls==$HKelas["kode_kelas"]){
				$terpilih="<button type='button' class='btn btn-default btn-xs btn-block'><i class='fa fa-check'></i></button>";
				$bcol="#cccccc";
			}
			else {
				if($CekKBMMapel>0){
					$terpilih="<a href='?page=$page&sub=updatedatakbm&tingkat=".$HKelas["tingkat"]."&kelas=".$HKelas["kode_kelas"]."' class='btn btn-$warnatmbl btn-xs btn-block'><i class='fa fa-close'></i></a>";
					$bcol="";	
				}
				else {
					$terpilih="";
					$bcol="";					
				}
			}			
			// cek data peringkat

			$CekPeringkat=JmlDt("select * from n_rank where id_kls='".$HKelas["kode_kelas"]."' and thnajaran='$PilTA' and semester='$PilSmstr'");

			$CekLeger=JmlDt("select * from leger_nilai_k3 where id_kls='".$HKelas["kode_kelas"]."' and thnajaran='$PilTA' and ganjilgenap='$PilSmstr'");

			if($CekPeringkat>0 || $CekLeger>0)
			{
				$TmbDownload="
				<div class='btn-group'>
					<button class='btn btn-$warnatmbl btn-xs btn-block dropdown-toggle' data-toggle='dropdown'>
						Download Berkas <span class='caret'></span>
					</button>
					<ul class='dropdown-menu'>
						<li>
							<a href=\"javascript:void(0);\" onClick=\"window.open('./pages/excel/ekspor-nilai.php?eksporex=leger-nilai-kurikulum&kls={$HKelas['kode_kelas']}&thnajaran=$PilTA&gg=$PilSmstr')\"><i class='fa fa-graduation-cap'></i> Leger Siswa</a>
						</li>
						<li>
							<a href=\"javascript:void(0);\" onClick=\"window.open('./pages/excel/ekspor-nilai.php?eksporex=rangking-kelas&kls={$HKelas['kode_kelas']}&thnajaran=$PilTA&gg=$PilSmstr')\"><i class='fa fa-bar-chart'></i> Peringkat Kelas</a>
						</li>
						<li>
							<a href=\"javascript:void(0);\" onClick=\"window.open('./pages/excel/ekspor-nilai.php?eksporex=absensi-kelas&kls={$HKelas['kode_kelas']}&thnajaran=$PilTA&gg=$PilSmstr')\"><i class='fa fa-calendar'></i> Absensi Kelas</a>
						</li>
					</ul>
				</div>";
			}
			else
			{
				$TmbDownload="<a href='javascript:void(0);' title='Data masih Kosong' class='btn btn-default btn-xs btn-block'><i class='fa fa-close txt-color-red'></i></a>";
			}
			
			// tampilkan data
			if($HKelas['tingkat']=="X" && $PilSmstr=="Ganjil"){$Smstr=1;}else
			if($HKelas['tingkat']=="X" && $PilSmstr=="Genap"){$Smstr=2;}else
			if($HKelas['tingkat']=="XI" && $PilSmstr=="Ganjil"){$Smstr=3;}else
			if($HKelas['tingkat']=="XI" && $PilSmstr=="Genap"){$Smstr=4;}else
			if($HKelas['tingkat']=="XII" && $PilSmstr=="Ganjil"){$Smstr=5;}else
			if($HKelas['tingkat']=="XII" && $PilSmstr=="Genap"){$Smstr=6;}

			$Data.="
			<tr bgcolor='$bcol'>
				<td class='text-center'>$no.</td>
				<td>
					<button type='button' class='view_data btn btn-$warnatmbl btn-xs btn-block' data-toggle='modal' id='".$HKelas["kode_kelas"]."' data-target='#myModal'>".$HKelas["nama_kelas"]."</button>
				</td>
				<td>$JmlSiswa</td>
				<td>$QJmlKBM</td>
				<td>$nama_lengkap</td>
				<td>$TmbKBM</td>
				<td width=100>$TmbDownload</td>
				<td><a href=\"javascript:void(0);\" onClick=\"window.open('./pages/excel/ekspor-data-master.php?eksporex=format-walikelas&kls={$HKelas['id_kls']}&thnajaran=$PilTA&gg=$PilSmstr')\" title=' Download Format Wali Kelas' class='btn btn-xs btn-$warnatmbl btn-block'>".$HKelas["nama_kelas"]."</a></td>
				<td><a href='?page=$page&sub=inputkbm&thnajaran=$PilTA&kdpk=$KdPK&tingkat={$HKelas['tingkat']}&gg=$Smstr&id_kls={$HKelas['kode_kelas']}' class='btn btn-$warnatmbl btn-xs btn-block'><i class='fa fa-graduation-cap'></i></a></td>
				<td>$terpilih</td>
			</tr>";
			$no++;
		}

		if($JKelas==0) {
			$generate="<div class='panel panel-default'><div class='panel-body'><br><br><br><h1 class='text-center text-danger'><strong><i class='fa fa-exclamation-triangle fa-3x'></i></h1><h4 class='text-center text-info'>Data Belum Ada!! <br> Silakan pilih Tahun Ajaran </strong></h4><br><br><br><br><br></div></div>";
		}else if($PilSmstr==""){
			$generate="<div class='panel panel-default'><div class='panel-body'><br><br><br><h1 class='text-center text-danger'><strong><i class='fa fa-exclamation-triangle fa-3x'></i></h1><h4 class='text-center text-info'>Data Belum Ada!! <br> Silakan pilih Semester</strong></h4><br><br><br><br><br></div></div>";
		}
		else
		{
			$generate.=nt("informasi","Untuk kolom <em><b>download berkas</b></em> masih proses scripting");

			if($AdaPilihangak>0 && $SudahGenerate>0){
				$generate.=KolomPanel("Kode Kelas : $PilKdKls");
			}
			else
			{
				$generate.="";
			}

			$generate.="
			<div class='well no-padding'>
			<table id='dt_basic' class='table table-striped table-bordered table-hover table-condensed' width='100%'>
				<thead>
					<tr>
						<th class='text-center' data-class='expand'>No.</th>
						<th class='text-center'>Kelas</th>
						<th class='text-center' data-hide='phone,tablet'>Siswa</th>
						<th class='text-center' data-hide='phone,tablet'>MP</th>
						<th class='text-center'>Nama Wali Kelas</th>
						<th class='text-center' data-hide='phone,tablet'>GNR</th>
						<th class='text-center' data-hide='phone,tablet'>Download</th>
						<th class='text-center' data-hide='phone,tablet'>Format Wk</th>
						<th class='text-center' data-hide='phone,tablet'>KBM</th>
						<th class='text-center'>Pilih</th>
					</tr>
				</thead>
				<tbody>$Data</tbody>
			</table>
			</div>";
		}

// TAB DATA PENGAJAR
		
		$noKBM=1;
		while($HNgajar=mysql_fetch_array($Q))
		{
			$NamaKelas=$HNgajar['nama_kelas'];
			$KodeKelas=$HKBMPerKls['kd_kelas'];
			$KodeNgajar=$HNgajar['id_ngajar'];
			$KodeMapel=$HNgajar['kode_mapel'];
			$KKMPeng=$HNgajar['kkmpeng'];
			$KKMKet=$HNgajar['kkmket'];

			$KDSna=JmlDt("select kode_ngajar,kode_ranah from gmp_kikd where kode_ngajar='$KodeNgajar' and kode_ranah='KDS'");
			$KDPna=JmlDt("select kode_ngajar,kode_ranah from gmp_kikd where kode_ngajar='$KodeNgajar' and kode_ranah='KDP'");
			$KDKna=JmlDt("select kode_ngajar,kode_ranah from gmp_kikd where kode_ngajar='$KodeNgajar' and kode_ranah='KDK'");

			$ShowPengajar.="
			<tr>
				<td align='center' height='".$PilTingC."'>$noKBM.</td>
				<td align='center'>$KodeNgajar</td>
				<td style='padding-left:10px;'>{$HNgajar['nama_lengkap']}</td>
				<td style='padding-left:10px;'>{$HNgajar['nama_mapel']}</td>
				<td align='center'>$KKMPeng</td>
				<td align='center'>$KKMKet</td>
				<td align='center'>$KDPna</td>
				<td align='center'>$KDKna</td>
			</tr>";
			$noKBM++;
		}

		$DataPengajar.="
		<div id='cetakDataPengajar'>
		<table style='margin: 0 auto; width:100%;border-collapse:collapse;font:12px Arial;'>
			<tr><td align='center'><font size='4'><strong>DATA PENGAJAR DAN MATA PELAJARAN</strong></font></td></tr>
		</table><br>
		$IdentKelas<br>
		<table style='margin: 0 auto; width:100%;border-collapse:collapse;font:12px Arial;border-color:black;' border='1'>
			<thead>
				<tr bgcolor='#cccccc'>
					<th width='30' height='20'>No.</th>
					<th width='125'>Kode KBM</th>
					<th>Nama Guru</th>
					<th>Mata Pelajaran</th>
					<th>KKM P</th>
					<th>KKM K</th>
					<th>KD P</th>
					<th>KD K</th>
				</tr>
			</thead>
			<tbody>$ShowPengajar</tbody>
		</table>
		$KepsekWaliKelas2
		</div>";

// TAB ABSENSI GURU MAPEL

		$QA=mysql_query("
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
		gmp_ngajar.kd_kelas='$PilKdKls' and 
		gmp_ngajar.thnajaran='$PilTA' and
		gmp_ngajar.ganjilgenap='$PilSmstr' 
		order by gmp_ngajar.kd_kelas,gmp_ngajar.kd_mapel asc");

		$noAbsen=1;
		while($HAbsen=mysql_fetch_array($QA))
		{
			$IDNgajar2=$HAbsen['id_ngajar'];
			$QSakit=mysql_query("select sum(absensi) as jmlsakit from gmp_absensi where absensi='Sakit' and kd_ngajar='$IDNgajar2'");
			$DSakit=mysql_fetch_array($QSakit);
			$TotalSakit=$TotalSakit+$DSakit['jmlsakit'];
			$QIzin=mysql_query("select sum(absensi) as jmlizin from gmp_absensi where absensi='Izin' and kd_ngajar='$IDNgajar2'");
			$DIzin=mysql_fetch_array($QIzin);
			$TotalIzin=$TotalIzin+$DIzin['jmlizin'];
			$QAlfa=mysql_query("select sum(absensi) as jmlAlfa from gmp_absensi where absensi='Alfa' and kd_ngajar='$IDNgajar2'");
			$DAlfa=mysql_fetch_array($QAlfa);
			$TotalAlfa=$TotalAlfa+$DAlfa['jmlAlfa'];
			$TotAbsensi = $DSakit['jmlsakit']+$DIzin['jmlizin']+$DAlfa['jmlAlfa'];
			$TotalSeluruhAbsensi=$TotalSeluruhAbsensi+$TotAbsensi;

			$ShowAbsen.="
			<tr>
				<td align='center' height='".$PilTingC."'>$noAbsen.</td>
				<td align='center'>{$HAbsen['id_ngajar']}</td>
				<td style='padding-left:10px;'>{$HAbsen['nama_lengkap']}</td>
				<td style='padding-left:10px;'>{$HAbsen['nama_mapel']}</td>
				<td align='center'>{$DSakit['jmlsakit']}</td>
				<td align='center'>{$DIzin['jmlizin']}</td>
				<td align='center'>{$DAlfa['jmlAlfa']}</td>
				<td align='center'>{$TotAbsensi}</td>
			</tr>";
			$noAbsen++;
		}
		$AbsensiMapel.="
		<div id='cetakAbsensiMapel'>	
			<table style='margin: 0 auto; width:100%;border-collapse:collapse;font:16px Arial;'>
				<tr>
					<td align='center'><font size='4'><strong>ABSENSI GURU MATA PELAJARAN</strong></font></td>
				</tr>
			</table><br>
			$IdentKelas<br>
			
			<table style='margin: 0 auto; width:100%;border-collapse:collapse;font:12px Arial;border-color:black;' border='1'>
				<thead>
					<tr bgcolor='#cccccc'>
						<th width='30' height='20'>No.</th>
						<th width='125'>Kode KBM</th>
						<th>Nama Guru</th>
						<th>Mata Pelajaran</th>
						<th>Sakit</th>
						<th>Izin</th>
						<th>Alfa</th>
						<th>Total</th>
					</tr>
				</thead>
				<tbody>
					$ShowAbsen
					<tr bgcolor='#cccccc'>
						<td colspan='4' align='center'>Total</td>
						<td align='center'>$TotalSakit</td>
						<td align='center'>$TotalIzin</td>
						<td align='center'>$TotalAlfa</td>
						<td align='center'>$TotalSeluruhAbsensi</td>
					</tr>				
				</tbody>
			</table>
			
			$KepsekWaliKelas
		</div>";

// TAB LEGER K3

		$QLgr=mysql_query("
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
		where ak_kelas.kode_kelas='$PilKdKls'");
		
		$NoNLP=1;
		while($HLNP=mysql_fetch_array($QLgr))
		{
			$QNSP=mysql_query("select * from leger_nilai_k3 where id_kls='$PilKdKls' and thnajaran='$PilTA' and ganjilgenap='$PilSmstr' and nis='".$HLNP['nis']."'");
			$HNSP=mysql_fetch_array($QNSP);

			$QNgajarP=mysql_query("
				select 
				leger_nilai_mapel.* 
				from leger_nilai_k3 
				inner join leger_nilai_mapel on leger_nilai_mapel.thnajaran=leger_nilai_k3.thnajaran and 
				leger_nilai_mapel.semester=leger_nilai_k3.ganjilgenap and 
				leger_nilai_mapel.id_kls=leger_nilai_k3.id_kls 
				where leger_nilai_mapel.id_kls='$PilKdKls' and leger_nilai_k3.nis='".$HLNP['nis']."'");
			$HKKMP=mysql_fetch_array($QNgajarP);

			$LNilP.="
				<tr>
					<td align='center' height='".$PilTingC."'>$NoNLP</td>
					<td align='center' width=85>".$HLNP['nis']."</td>
					<td style='padding-left:10px;'>".$HLNP['nm_siswa']."</td>";
					for ($i=1; $i<($JmlMP+1); $i++)
					{	
						if($HNSP['nilai'.$i]<$HKKMP['KKMP'.$i]){
							$warna="red";
							$warnahuruf="white";
							$tebal="<strong>".$HNSP['nilai'.$i]."</strong>";
						}
						else{
							$warna="";
							$warnahuruf="";
							$tebal="".$HNSP['nilai'.$i]."";
						}
						
						$LNilP.= "<td width='30' align='center' bgcolor='".$warna."'><font color='$warnahuruf'>$tebal</font></td>";
						
					}
			$LNilP.="</tr>";
			$NoNLP++;
		}

		for($i=1;$i<=$JmlMP;$i++){
			$JudulM="<th colspan='$JmlMP'>Nomor Urut Mapel, KKM, Nilai</th>";
			$thnyaP.="<th>$i</th>";
			$DataKKMP.="<th>".$HKKMP['KKMP'.$i]."</th>";
		}

		if($PilTK=="X" && $PilTA=="2022-2023"){ // KELAS X KURIKULUM MERDEKA

		}
		else {
			$LegerK3.="
			<div id='cetakK3'>
			<table style='margin: 0 auto; width:100%;border-collapse:collapse;font:16px Arial;'>
				<tr><td align='center'><font size='4'><strong>LEGER PENGETAHUAN (K3)</strong></font></td></tr>
			</table><br>
			$IdentKelas<br>
			<table style='margin: 0 auto; width:100%;border-collapse:collapse;font:12px Arial;border-color:black;' border='1'>
				<thead>
					<tr bgcolor='#cccccc'>
						<th rowspan='3'>No.</th>
						<th rowspan='3'>NIS</th>
						<th rowspan='3'>Nama Siswa</th>
						$JudulM
					</tr>
					<tr bgcolor='#cccccc'>$thnyaP</tr>
					<tr bgcolor='#cccccc'>$DataKKMP</tr>
				</thead>
				<tbody>$LNilP</tbody>
			</table>
			$KepsekWaliKelas
			</div>";
		}

// TAB LEGER K4

		$QLgrK=mysql_query("
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
			where ak_kelas.kode_kelas='$PilKdKls'");

		$NoNLK=1;
		while($HLNK=mysql_fetch_array($QLgrK))
		{
			$QNSK=mysql_query("select * from leger_nilai_k4 where id_kls='$PilKdKls' and thnajaran='$PilTA' and ganjilgenap='$PilSmstr' and nis='".$HLNK['nis']."'");
			$HNSK=mysql_fetch_array($QNSK);

			$QNgajarK=mysql_query("
				select 
				leger_nilai_mapel.* 
				from leger_nilai_k4 
				inner join leger_nilai_mapel on leger_nilai_mapel.thnajaran=leger_nilai_k4.thnajaran and 
				leger_nilai_mapel.semester=leger_nilai_k4.ganjilgenap and leger_nilai_mapel.id_kls=leger_nilai_k4.id_kls 
				where leger_nilai_mapel.id_kls='$PilKdKls' and leger_nilai_k4.nis='".$HLNK['nis']."'");
			$HKKMK=mysql_fetch_array($QNgajarK);

			$LNilK.="
				<tr>
					<td align='center' height='".$PilTingC."'>$NoNLK</td>
					<td align='center' width=85>".$HLNK['nis']."</td>
					<td style='padding-left:10px;'>".$HLNK['nm_siswa']."</td>";		
					for ($i=1; $i<($JmlMP+1); $i++)
					{	
						if($HNSK['nilai'.$i]<$HKKMK['KKMK'.$i]){
							$warna="red";
							$warnahuruf="white";
							$tebal="<strong>".$HNSK['nilai'.$i]."</strong>";
						}
						else{
							$warna="";
							$warnahuruf="";
							$tebal="".$HNSK['nilai'.$i]."";
						}
						
						$LNilK.= "<td width='30' align='center' bgcolor='".$warna."'><font color='$warnahuruf'>$tebal</font></td>";
						
					}
			$LNilK.="</tr>";
			$NoNLK++;
		}

		for($i=1;$i<=$JmlMP;$i++){
			$JudulMK="<th colspan='$JmlMP'>Nomor Urut Mapel, KKM, Nilai</th>";
			$thnyaK.="<th>$i</th>";
			$DataKKMK.="<th>".$HKKMK['KKMK'.$i]."</th>";
		}

		if($PilTK=="X" && $PilTA=="2022-2023"){ // KELAS X KURIKULUM MERDEKA

		}
		else {
			$LegerK4.="
			<div id='cetakK4'>
			<table style='margin: 0 auto; width:100%;border-collapse:collapse;font:16px Arial;'>
				<tr><td align='center'><font size='4'><strong>LEGER KETERAMPILAN (K4)</strong></font></td></tr>
			</table><br>
			$IdentKelas<br>
			<table style='margin: 0 auto; width:100%;border-collapse:collapse;font:12px Arial;border-color:black;' border='1'>
				<thead>
					<tr bgcolor='#cccccc'>
						<th rowspan='3'>No.</th>
						<th rowspan='3'>NIS</th>
						<th rowspan='3'>Nama Siswa</th>
						$JudulMK
					</tr>
					<tr bgcolor='#cccccc'>$thnyaK</tr>
					<tr bgcolor='#cccccc'>$DataKKMK</tr>
				</thead>
				<tbody>$LNilK</tbody>
			</table>
			$KepsekWaliKelas
			</div>";			
		}

// TAB LEGER NA
		$QLgrNA=mysql_query("
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
			where ak_kelas.kode_kelas='$PilKdKls'");

		$NoNLNA=1;
		while($HLNNA=mysql_fetch_array($QLgrNA))
		{
			$QNSPNA=mysql_query("select * from leger_nilai_k3 where id_kls='$PilKdKls' and thnajaran='$PilTA' and ganjilgenap='$PilSmstr' and nis='".$HLNNA['nis']."'");
			$HNSPNA=mysql_fetch_array($QNSPNA);
	
			$QNSKNA=mysql_query("select * from leger_nilai_k4 where id_kls='$PilKdKls' and thnajaran='$PilTA' and ganjilgenap='$PilSmstr' and nis='".$HLNNA['nis']."'");
			$HNSKNA=mysql_fetch_array($QNSKNA);

			if($PilTK=="X" && $PilTA=="2022-2023"){ // KELAS X KURIKULUM MERDEKA
				$LNilNA.="
					<tr>
						<td align='center' height='".$PilTingC."'>$NoNLNA</td>
						<td align='center' width=85>".$HLNNA['nis']."</td>
						<td style='padding-left:10px;'>".$HLNNA['nm_siswa']."</td>";
						for ($i=1; $i<($JmlMP+1); $i++)
						{	
							$NAna=round(($HNSPNA['nilai'.$i]),0);
							$LNilNA.= "<td width='30' align='center'>".$NAna."</td>";
						}
				$LNilNA.="</tr>";
				$NoNLNA++;
			}
			else{
				$LNilNA.="
					<tr>
						<td align='center' height='".$PilTingC."'>$NoNLNA</td>
						<td align='center' width=85>".$HLNNA['nis']."</td>
						<td style='padding-left:10px;'>".$HLNNA['nm_siswa']."</td>";
						for ($i=1; $i<($JmlMP+1); $i++)
						{	
							$NAna=round(($HNSPNA['nilai'.$i]+$HNSKNA['nilai'.$i])/2,0);
							$LNilNA.= "<td width='30' align='center'>".$NAna."</td>";
						}
				$LNilNA.="</tr>";
				$NoNLNA++;
				
			}			

		}

		for($i=1;$i<=$JmlMP;$i++){
			$JudulNA="<th colspan='$JmlMP'>Nomor Urut Mapel, Nilai</th>";
			$thnyaNA.="<th>$i</th>";
		}

		$LegerNA.="
		<div id='cetakNA'>
		<table style='margin: 0 auto; width:100%;border-collapse:collapse;font:16px Arial;'>
			<tr><td align='center'><font size='4'><strong>LEGER NILAI AKHIR (NA)</strong></font></td></tr>
		</table><br>
		$IdentKelas<br>		
		<table style='margin: 0 auto; width:100%;border-collapse:collapse;font:12px Arial;border-color:black;' border='1'>
			<thead>
				<tr bgcolor='#cccccc'>
					<th rowspan='2'>No.</th>
					<th rowspan='2'>NIS</th>
					<th rowspan='2'>Nama Siswa</th>
					$JudulNA
				</tr>
				<tr bgcolor='#cccccc'>
					$thnyaNA
				</tr>
			</thead>
			<tbody>$LNilNA</tbody>
		</table>
		$KepsekWaliKelas
		</div>";
				
// TAB DETAIL NILAI
		/*
		$QN=mysql_query("
		SELECT 
		ngajar.id_ngajar,
		ngajar.thnajaran,
		ngajar.jenismapel,
		ngajar.semester,
		ngajar.kkmpeng,
		ngajar.kkmket,
		user_guru.nama_lengkap,
		matapelajaran.nama_mapel,
		kelas.nama_kelas 
		FROM 
		ngajar,
		user_guru,
		matapelajaran,
		kelas 
		WHERE 
		ngajar.kd_guru=user_guru.id_guru AND 
		ngajar.kd_mapel=matapelajaran.kode_mapel AND 
		ngajar.kd_kelas=kelas.kode_kelas and 
		ngajar.kd_kelas='$PilKelas' and 
		ngajar.thnajaran='$PilTA' and
		ngajar.ganjilgenap='$PilSemester' 
		order by ngajar.kd_kelas,ngajar.kd_mapel asc");
		$noNil=1;
		while($HNilai=mysql_fetch_array($QN))
		{
			$IDNgajar=$HNilai['id_ngajar'];
			$QSpri_4=mysql_query("select count(n_sikap.spritual) as NSSpri from n_sikap,ngajar where n_sikap.kd_ngajar=ngajar.id_ngajar and n_sikap.kd_ngajar='$IDNgajar' and n_sikap.spritual=4");
			$HSpri_4=mysql_fetch_array($QSpri_4);
			$QSpri_3=mysql_query("select count(n_sikap.spritual) as NSSpri from n_sikap,ngajar where n_sikap.kd_ngajar=ngajar.id_ngajar and n_sikap.kd_ngajar='$IDNgajar' and n_sikap.spritual=3");
			$HSpri_3=mysql_fetch_array($QSpri_3);
			$QSpri_2=mysql_query("select count(n_sikap.spritual) as NSSpri from n_sikap,ngajar where n_sikap.kd_ngajar=ngajar.id_ngajar and n_sikap.kd_ngajar='$IDNgajar' and n_sikap.spritual=2");
			$HSpri_2=mysql_fetch_array($QSpri_2);
			$QSpri_1=mysql_query("select count(n_sikap.spritual) as NSSpri from n_sikap,ngajar where n_sikap.kd_ngajar=ngajar.id_ngajar and n_sikap.kd_ngajar='$IDNgajar' and n_sikap.spritual=1");
			$HSpri_1=mysql_fetch_array($QSpri_1);
			$QSos_4=mysql_query("select count(n_sikap.sosial) as NSSos from n_sikap,ngajar where n_sikap.kd_ngajar=ngajar.id_ngajar and n_sikap.kd_ngajar='$IDNgajar' and n_sikap.sosial=4");
			$HSos_4=mysql_fetch_array($QSos_4);
			$QSos_3=mysql_query("select count(n_sikap.sosial) as NSSos from n_sikap,ngajar where n_sikap.kd_ngajar=ngajar.id_ngajar and n_sikap.kd_ngajar='$IDNgajar' and n_sikap.sosial=3");
			$HSos_3=mysql_fetch_array($QSos_3);
			$QSos_2=mysql_query("select count(n_sikap.sosial) as NSSos from n_sikap,ngajar where n_sikap.kd_ngajar=ngajar.id_ngajar and n_sikap.kd_ngajar='$IDNgajar' and n_sikap.sosial=2");
			$HSos_2=mysql_fetch_array($QSos_2);
			$QSos_1=mysql_query("select count(n_sikap.sosial) as NSSos from n_sikap,ngajar where n_sikap.kd_ngajar=ngajar.id_ngajar and n_sikap.kd_ngajar='$IDNgajar' and n_sikap.sosial=1");
			$HSos_1=mysql_fetch_array($QSos_1);
			$QPeng_A=mysql_query("select count(n_p_kikd.kikd_p) as NKIKDp from n_p_kikd,ngajar where n_p_kikd.kd_ngajar=ngajar.id_ngajar and n_p_kikd.kd_ngajar='$IDNgajar' and n_p_kikd.kikd_p>=86 and n_p_kikd.kikd_p<=100");
			$HPeng_A=mysql_fetch_array($QPeng_A);
			$QPeng_B=mysql_query("select count(n_p_kikd.kikd_p) as NKIKDp from n_p_kikd,ngajar where n_p_kikd.kd_ngajar=ngajar.id_ngajar and n_p_kikd.kd_ngajar='$IDNgajar' and n_p_kikd.kikd_p>=71 and n_p_kikd.kikd_p<=85");
			$HPeng_B=mysql_fetch_array($QPeng_B);
			$QPeng_C=mysql_query("select count(n_p_kikd.kikd_p) as NKIKDp from n_p_kikd,ngajar where n_p_kikd.kd_ngajar=ngajar.id_ngajar and n_p_kikd.kd_ngajar='$IDNgajar' and n_p_kikd.kikd_p>=56 and n_p_kikd.kikd_p<=70");
			$HPeng_C=mysql_fetch_array($QPeng_C);
			$QPeng_D=mysql_query("select count(n_p_kikd.kikd_p) as NKIKDp from n_p_kikd,ngajar where n_p_kikd.kd_ngajar=ngajar.id_ngajar and n_p_kikd.kd_ngajar='$IDNgajar' and n_p_kikd.kikd_p>=1 and n_p_kikd.kikd_p<=55");
			$HPeng_D=mysql_fetch_array($QPeng_D);
			$QKet_A=mysql_query("select count(n_k_kikd.kikd_k) as NKIKDk from n_k_kikd,ngajar where n_k_kikd.kd_ngajar=ngajar.id_ngajar and n_k_kikd.kd_ngajar='$IDNgajar' and n_k_kikd.kikd_k>=86 and n_k_kikd.kikd_k<=100");
			$HKet_A=mysql_fetch_array($QKet_A);
			$QKet_B=mysql_query("select count(n_k_kikd.kikd_k) as NKIKDk from n_k_kikd,ngajar where n_k_kikd.kd_ngajar=ngajar.id_ngajar and n_k_kikd.kd_ngajar='$IDNgajar' and n_k_kikd.kikd_k>=71 and n_k_kikd.kikd_k<=85");
			$HKet_B=mysql_fetch_array($QKet_B);
			$QKet_C=mysql_query("select count(n_k_kikd.kikd_k) as NKIKDk from n_k_kikd,ngajar where n_k_kikd.kd_ngajar=ngajar.id_ngajar and n_k_kikd.kd_ngajar='$IDNgajar' and n_k_kikd.kikd_k>=56 and n_k_kikd.kikd_k<=70");
			$HKet_C=mysql_fetch_array($QKet_C);
			$QKet_D=mysql_query("select count(n_k_kikd.kikd_k) as NKIKDk from n_k_kikd,ngajar where n_k_kikd.kd_ngajar=ngajar.id_ngajar and n_k_kikd.kd_ngajar='$IDNgajar' and n_k_kikd.kikd_k>=1 and n_k_kikd.kikd_k<=55");
			$HKet_D=mysql_fetch_array($QKet_D);
			$QUts_A=mysql_query("select count(n_utsuas.uts) as NUTS from n_utsuas,ngajar where n_utsuas.kd_ngajar=ngajar.id_ngajar and n_utsuas.kd_ngajar='$IDNgajar' and n_utsuas.uts>=86 and n_utsuas.uts<=100");
			$HUts_A=mysql_fetch_array($QUts_A);
			$QUts_B=mysql_query("select count(n_utsuas.uts) as NUTS from n_utsuas,ngajar where n_utsuas.kd_ngajar=ngajar.id_ngajar and n_utsuas.kd_ngajar='$IDNgajar' and n_utsuas.uts>=71 and n_utsuas.uts<=85");
			$HUts_B=mysql_fetch_array($QUts_B);
			$QUts_C=mysql_query("select count(n_utsuas.uts) as NUTS from n_utsuas,ngajar where n_utsuas.kd_ngajar=ngajar.id_ngajar and n_utsuas.kd_ngajar='$IDNgajar' and n_utsuas.uts>=56 and n_utsuas.uts<=70");
			$HUts_C=mysql_fetch_array($QUts_C);
			$QUts_D=mysql_query("select count(n_utsuas.uts) as NUTS from n_utsuas,ngajar where n_utsuas.kd_ngajar=ngajar.id_ngajar and n_utsuas.kd_ngajar='$IDNgajar' and n_utsuas.uts>=1 and n_utsuas.uts<=55");
			$HUts_D=mysql_fetch_array($QUts_D);
			$QUas_A=mysql_query("select count(n_utsuas.uas) as NUAS from n_utsuas,ngajar where n_utsuas.kd_ngajar=ngajar.id_ngajar and n_utsuas.kd_ngajar='$IDNgajar' and n_utsuas.uas>=86 and n_utsuas.uas<=100");
			$HUas_A=mysql_fetch_array($QUas_A);
			$QUas_B=mysql_query("select count(n_utsuas.uas) as NUAS from n_utsuas,ngajar where n_utsuas.kd_ngajar=ngajar.id_ngajar and n_utsuas.kd_ngajar='$IDNgajar' and n_utsuas.uas>=71 and n_utsuas.uas<=85");
			$HUas_B=mysql_fetch_array($QUas_B);
			$QUas_C=mysql_query("select count(n_utsuas.uas) as NUAS from n_utsuas,ngajar where n_utsuas.kd_ngajar=ngajar.id_ngajar and n_utsuas.kd_ngajar='$IDNgajar' and n_utsuas.uas>=56 and n_utsuas.uas<=70");
			$HUas_C=mysql_fetch_array($QUas_C);
			$QUas_D=mysql_query("select count(n_utsuas.uas) as NUAS from n_utsuas,ngajar where n_utsuas.kd_ngajar=ngajar.id_ngajar and n_utsuas.kd_ngajar='$IDNgajar' and n_utsuas.uas>=1 and n_utsuas.uas<=55");
			$HUas_D=mysql_fetch_array($QUas_D);
			$ShowNilai.="
			<tr>
				<td class='text-center'>$noNil.</td>
				<td>{$HNilai['nama_lengkap']}<BR>{$HNilai['nama_mapel']}</td>
				<td class='text-center' bgcolor='#ffffcc'>{$HSpri_4['NSSpri']}</td>
				<td class='text-center' bgcolor='#ffffcc'>{$HSpri_3['NSSpri']}</td>
				<td class='text-center' bgcolor='#ffffcc'>{$HSpri_2['NSSpri']}</td>
				<td class='text-center' bgcolor='#ffffcc'>{$HSpri_1['NSSpri']}</td>
				<td class='text-center' bgcolor='#ffffb0'>{$HSos_4['NSSos']}</td>
				<td class='text-center' bgcolor='#ffffb0'>{$HSos_3['NSSos']}</td>
				<td class='text-center' bgcolor='#ffffb0'>{$HSos_2['NSSos']}</td>
				<td class='text-center' bgcolor='#ffffb0'>{$HSos_1['NSSos']}</td>
				<td class='text-center' bgcolor='#ffffcc'>{$HPeng_A['NKIKDp']}</td>
				<td class='text-center' bgcolor='#ffffcc'>{$HPeng_B['NKIKDp']}</td>
				<td class='text-center' bgcolor='#ffffcc'>{$HPeng_C['NKIKDp']}</td>
				<td class='text-center' bgcolor='#ffffcc'>{$HPeng_D['NKIKDp']}</td>
				<td class='text-center' bgcolor='#ffffb0'>{$HUts_A['NUTS']}</td>
				<td class='text-center' bgcolor='#ffffb0'>{$HUts_B['NUTS']}</td>
				<td class='text-center' bgcolor='#ffffb0'>{$HUts_C['NUTS']}</td>
				<td class='text-center' bgcolor='#ffffb0'>{$HUts_D['NUTS']}</td>
				<td class='text-center' bgcolor='#ffffcc'>{$HUas_A['NUAS']}</td>
				<td class='text-center' bgcolor='#ffffcc'>{$HUas_B['NUAS']}</td>
				<td class='text-center' bgcolor='#ffffcc'>{$HUas_C['NUAS']}</td>
				<td class='text-center' bgcolor='#ffffcc'>{$HUas_D['NUAS']}</td>
				<td class='text-center' bgcolor='#ffffb0'>{$HKet_A['NKIKDk']}</td>
				<td class='text-center' bgcolor='#ffffb0'>{$HKet_B['NKIKDk']}</td>
				<td class='text-center' bgcolor='#ffffb0'>{$HKet_C['NKIKDk']}</td>
				<td class='text-center' bgcolor='#ffffb0'>{$HKet_D['NKIKDk']}</td>
			</tr>";
			$noNil++;
		}
		$DetailNilai.="
		<div class='who clearfix'><h4><strong>B.</strong> <span class='txt-color-red'><strong>Perolehan Nilai</strong></span></h4></div><hr class='simple'>
		<div class='table-responsive'>
		<table class='table table-striped table-bordered table-hover table-condensed' width='100%'>
			<thead>
				<tr>
					<th class='text-center' rowspan='2'>No.</th>
					<th class='text-center' rowspan='2'>Mata Pelajaran</th>
					<th class='text-center' colspan='4' bgcolor='#ffffcc'>SPRITUAL</th>
					<th class='text-center' colspan='4' bgcolor='#ffffb0'>SOSIAL</th>
					<th class='text-center' colspan='4' bgcolor='#ffffcc'>PENGETAHUAN</th>
					<th class='text-center' colspan='4' bgcolor='#ffffb0'>UTS</th>
					<th class='text-center' colspan='4' bgcolor='#ffffcc'>UAS</th>
					<th class='text-center' colspan='4' bgcolor='#ffffb0'>KETERAMPILAN</th>
				</tr>
				<tr>
					<th class='text-center' bgcolor='#ffffcc'>4</th>
					<th class='text-center' bgcolor='#ffffcc'>3</th>
					<th class='text-center' bgcolor='#ffffcc'>2</th>
					<th class='text-center' bgcolor='#ffffcc'>1</th>
					<th class='text-center' bgcolor='#ffffb0'>4</th>
					<th class='text-center' bgcolor='#ffffb0'>3</th>
					<th class='text-center' bgcolor='#ffffb0'>2</th>
					<th class='text-center' bgcolor='#ffffb0'>1</th>
					<th class='text-center' bgcolor='#ffffcc'>A</th>
					<th class='text-center' bgcolor='#ffffcc'>B</th>
					<th class='text-center' bgcolor='#ffffcc'>C</th>
					<th class='text-center' bgcolor='#ffffcc'>D</th>
					<th class='text-center' bgcolor='#ffffb0'>A</th>
					<th class='text-center' bgcolor='#ffffb0'>B</th>
					<th class='text-center' bgcolor='#ffffb0'>C</th>
					<th class='text-center' bgcolor='#ffffb0'>D</th>
					<th class='text-center' bgcolor='#ffffcc'>A</th>
					<th class='text-center' bgcolor='#ffffcc'>B</th>
					<th class='text-center' bgcolor='#ffffcc'>C</th>
					<th class='text-center' bgcolor='#ffffcc'>D</th>
					<th class='text-center' bgcolor='#ffffb0'>A</th>
					<th class='text-center' bgcolor='#ffffb0'>B</th>
					<th class='text-center' bgcolor='#ffffb0'>C</th>
					<th class='text-center' bgcolor='#ffffb0'>D</th>
				</tr>
			</thead>
			<tbody>$ShowNilai</tbody>
		</table>
		</div>";
		*/

// TAB ABSENSI WALI KELAS 
	
		$QAbsensi=mysql_query("
			select 
			wk_absensi.*,
			ak_kelas.id_kls,
			ak_kelas.kode_kelas,
			ak_kelas.nama_kelas 
			from 
			wk_absensi 
			inner join ak_kelas on wk_absensi.id_kelas=ak_kelas.id_kls 
			where 
			ak_kelas.kode_kelas='$PilKdKls' and 
			wk_absensi.tahunajaran='$PilTA' and 
			wk_absensi.semester='$PilSmstr' order by wk_absensi.jmlabsen desc");
		$JmlData=mysql_num_rows($QAbsensi);

		$no=1;
		while($Hasil=mysql_fetch_array($QAbsensi)){
			$QSis=mysql_query("select nis,nm_siswa from siswa_biodata where nis='{$Hasil['nis']}'");
			$HSis=mysql_fetch_array($QSis);
			$JSakit=$JSakit+$Hasil['sakit'];
			$JIzin=$JIzin+$Hasil['izin'];
			$JAlfa=$JAlfa+$Hasil['alfa'];
			$JTotal=$JTotal+$Hasil['jmlabsen'];
			$NamaKelas=$Hasil['nama_kelas'];
			$DataAbsen.="
			<tr>
				<td align='center' height='".$PilTingC."'>$no</td>
				<td align='center'>{$Hasil['nis']}</td>
				<td style='padding-left:10px;'>{$HSis['nm_siswa']}</td>
				<td align='center'>".$Hasil['sakit']."</td>
				<td align='center'>".$Hasil['izin']."</td>
				<td align='center'>".$Hasil['alfa']."</td>
				<td align='center'>".$Hasil['jmlabsen']."</td>
			</tr>";
			$no++;
		}
		
		if($JmlData>0){
			$AbsensiWk.="
			<div id='cetakAbsensi'>	
				<table style='margin: 0 auto; width:100%;border-collapse:collapse;font:16px Arial;'>
					<tr><td align='center'><font size='4'><strong>ABSENSI KELAS</strong></font></td></tr>
				</table><br>
				$IdentKelas<br>
				<table style='margin: 0 auto; width:100%;border-collapse:collapse;font:12px Arial;border-color:black;' border='1'>
				<thead>
					<tr bgcolor='#cccccc'>
						<th width='30' height='20'>No.</th>
						<th width='85'>NIS</th>
						<th>Nama Siswa</th>
						<th>Sakit</th>
						<th>Izin</th>
						<th>Alfa</th>
						<th>Total</th>
					</tr>
				</thead>
				<tbody>
					$DataAbsen
					<tr bgcolor='#cccccc'>
						<td colspan='3' align='center'>Total</td>
						<td align='center'>$JSakit</td>
						<td align='center'>$JIzin</td>
						<td align='center'>$JAlfa</td>
						<td align='center'>$JTotal</td>
					</tr>
				<tbody>
				</table>
				$KepsekWaliKelas2
			</div>";
		}
		else
		{
			$AbsensiWk.=nt("informasi","Data Absensi Belum Ada, Wali Kelas belum mengisi Absensi Kelas");
		}

// TAB RANKING KELAS

		$QRank=mysql_query("
			select 
			n_rank.*,
			ak_kelas.id_kls,
			ak_kelas.kode_kelas,
			ak_kelas.nama_kelas,
			ak_kelas.tingkat 
			from 
			n_rank inner join ak_kelas on n_rank.id_kls=ak_kelas.kode_kelas 
			where 
			ak_kelas.kode_kelas='$PilKdKls' and 
			n_rank.thnajaran='$PilTA' and 
			n_rank.semester='$PilSmstr' order by na desc");
		$JmlDataRank=mysql_num_rows($QRank);
		$jmlDataKosong=JmlDt("select * from n_rank where na<'50,00' and id_kls='$PilKdKls' and thnajaran='$PilTA' and semester='$PilSmstr'");
		$TotalJml=($JmlDataRank-$jmlDataKosong);

		$noRank=1;
		while($HasilRank=mysql_fetch_array($QRank)){
			$QSisRank=mysql_query("select nis,nm_siswa from siswa_biodata where nis='{$HasilRank['nis']}'");
			$HSisRank=mysql_fetch_array($QSisRank);
			$RNAP=$RNAP+$HasilRank['nap'];
			$RNAK=$RNAK+$HasilRank['nak'];
			$RNA=$RNA+$HasilRank['na'];
			$NamaKelasRank=$HasilRank['nama_kelas'];
			$NamaTKRank=$HasilRank['tingkat'];
			$DataRank.="
			<tr>
				<td align='center' height='".$PilTingC."'>$noRank</td>
				<td align='center'>{$HasilRank['nis']}</td>
				<td style='padding-left:10px;'>{$HSisRank['nm_siswa']}</td>
				<td align='center'>{$HasilRank['nap']}</td>
				<td align='center'>{$HasilRank['nak']}</td>
				<td align='center'>{$HasilRank['na']}</td>
			</tr>";
			$noRank++;
		}
		$RNilKlsP=round(($RNAP/$TotalJml),2);
		$RNilKlsK=round(($RNAK/$TotalJml),2);
		$RNilKlsNA=round(($RNA/$TotalJml),2);

		if($JmlDataRank>0){

			if($NamaTKRank=="X"){
				$JdlKolom="
					<th>NA TP</th>
					<th>NA UTSUAS</th>
				";
			} 
			else {
				$JdlKolom="
					<th>NA K3</th>
					<th>NA K4</th>
				";

			}


			$Rangking.="
			<div id='cetakRanking'>
				<table style='margin: 0 auto; width:100%;border-collapse:collapse;font:16px Arial;'>
					<tr><td align='center'><font size='4'><strong>PERINGKAT KELAS</strong></font></td></tr>
				</table><br>
				$IdentKelas<br>
				<table style='margin: 0 auto; width:100%;border-collapse:collapse;font:12px Arial;border-color:black;' border='1'>
				<thead>
					<tr bgcolor='#cccccc'>
						<th width='30' height='20'>No.</th>
						<th width='85'>NIS</th>
						<th>Nama Siswa</th>
						$JdlKolom
						<th>R2</th>
					</tr>
				</thead>
				<tbody>
					$DataRank
					<tr bgcolor='#cccccc'>
						<td align='center' colspan=3>Rata-Rata Kelas $JmlDataRank - $jmlDataKosong = $TotalJml</td>
						<td align='center'>$RNilKlsP</td>
						<td align='center'>$RNilKlsK</td>
						<td align='center'>$RNilKlsNA</td>
					</tr>
				<tbody>
				</table>
				$KepsekWaliKelas2
			</div>";
		}
		else
		{
			$Rangking.=nt("informasi","Data Peringkat Belum Ada");
		}

// TAB CETAK DOKUMEN TERIMA LAPOR

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
			where ak_kelas.kode_kelas='$PilKdKls'");
		
		$NoDok=1;
		while($HDok=mysql_fetch_array($QLgrDok))
		{
			if($NoDok % 2 == 0){$tengah="<center>$NoDok</center>";}else{$tengah=$NoDok;}
			$TDok.="
				<tr>
					<td align='center' height='".$PilTingC."'>$NoDok</td>
					<td align='center' width='85'>".$HDok['nis']."</td>
					<td style='padding-left:10px;'>".$HDok['nm_siswa']."</td>
					<td></td>
					<td style='padding-left:10px;'>$tengah</td>
				</tr>";
			$NoDok++;
		}

		$CetakDokumen.="
		<div id='cetakDok'>
			<table style='margin: 0 auto; width:100%;border-collapse:collapse;font:16px Arial;'>
				<tr>
					<td align='center'><font size='4'><strong>DAFTAR PENERIMAAN LAPOR</strong></font></td>
				</tr>
			</table><br>
			$IdentKelas<br>
			<table style='margin: 0 auto; width:100%;border-collapse:collapse;font:12px Arial;border-color:black;' border='1'>
				<thead>
					<tr bgcolor='#cccccc'>
						<th width='30' height='20'>No.</th>
						<th>NIS</th>
						<th>Nama Siswa</th>
						<th>Tanggal Pengambilan</th>
						<th>Tanda Tangan</th>
					</tr>
				</thead>
				<tbody>$TDok</tbody>
			</table>
			$KepsekWaliKelas2
		</div>";

// Tampilkan di browser	

		if($AdaPilihangak>0 && $SudahGenerate>0){
			$Tampilkanul="
			<li class='dropdown'><a data-toggle='dropdown' class='dropdown-toggle' href='#'> <i class='txt-color-red fa fa-lg fa-search'></i> <span class='hidden-mobile'>Preview Cetak</span>&nbsp;<i class='ace-icon fa fa-caret-down bigger-110 width-auto'></i></a>
				<ul class='dropdown-menu dropdown-info'>
				<li><a data-toggle='tab' href='#datapengajar'>1. KBM</a></li>
				<li><a data-toggle='tab' href='#absensimapel'>2. Absensi Mata Pelajaran</a></li>
				<li><a data-toggle='tab' href='#leger'>3. Leger Siswa</a></li>
				<li><a data-toggle='tab' href='#absensiwk'>4. Absensi Kelas</a></li>
				<li><a data-toggle='tab' href='#rangking'>5. Peringkat Kelas</a></li>
				<li><a data-toggle='tab' href='#dokumen'>6. Dokumen Terima Lapor</a></li>
				</ul>
			</li>";
		}
		else
		{
			$Tampilkanul="";
		}

		$Tampilkeun.="
		<script>
		function printContent(el){
			var restorepage=document.body.innerHTML;
			var printcontent=document.getElementById(el).innerHTML;
			document.body.innerHTML=printcontent;
			window.print();
			document.body.innerHTML=restorepage;
		}
		</script>
		<ul id='myTab' class='nav nav-tabs bordered'>
			<li class='active'><a data-toggle='tab' href='#generate' title='Generate Leger'> <i class='fa fa-lg fa-book txt-color-red'></i> <span class='hidden-mobile hidden-tablet'>Generate</span></a></li>
				$Tampilkanul
		</ul>
		<div id='myTabContent' class='tab-content padding-10'>
			<div class='tab-pane fade in active' id='generate'>".DuaKolomD(2,$NyariData,10,$generate)."</div>
			<div class='tab-pane fade' id='datapengajar'>$DataPengajar</div>
			<div class='tab-pane fade' id='leger'>$LegerK3 $LegerK4 $LegerNA</div>
			<div class='tab-pane fade' id='absensimapel'>$AbsensiMapel</div>			
			<div class='tab-pane fade' id='absensiwk'>$AbsensiWk</div>
			<div class='tab-pane fade' id='rangking'>$Rangking</div>			
			<div class='tab-pane fade' id='dokumen'>$CetakDokumen</div>
		</div>";

		$TampilCetak.='
		<div id="content">
			<section id="widget-grid" class="">
				<div class="row">
					<div class="col-xs-12 col-sm-12">
						<div class="well no-padding">'.$Tampilkeun.'</div>
					</div>
				</div>
			</section>
		</div>';

		//$Show.=DuaKolom(2,$NyariData,10,$Tampilkeun);
		//$Show.=$CheckDataKBM;
		echo FormModalDetail("myModal","Data siswa","data_siswa212");

		echo $TampilCetak;
	break;

	case "inputkbm":

		$thnajaran=(isset($_GET['thnajaran']))?$_GET['thnajaran']:"";
		$gg=isset($_GET['gg'])?$_GET['gg']:""; 
		$tingkat=isset($_GET['tingkat'])?$_GET['tingkat']:""; 
		$kdpk=isset($_GET['kdpk'])?$_GET['kdpk']:""; 
		$id_kls=isset($_GET['id_kls'])?$_GET['id_kls']:"";


		$QTA=mysql_query("select * from ak_tahunajaran order by id_thnajar asc");
		while ($HTA=mysql_fetch_array($QTA)){
			$Sel=$HTA['tahunajaran']==$PilTA?"selected":"";
			$InputTA.="<option $Sel value={$HTA['tahunajaran']}>{$HTA['tahunajaran']}</option>";
		}

		$QPK=mysql_query("
			select * from 
			ak_paketkeahlian,ak_kelas 
			where 
			ak_paketkeahlian.kode_pk=ak_kelas.kode_pk and 
			ak_kelas.tahunajaran='$PilTA' group by ak_kelas.kode_pk");
		while ($HPK=mysql_fetch_array($QPK)){
			$Sel=$HPK['kode_pk']==$_GET['kdpk']?"selected":"";
			$DtPK.="<option $Sel value={$HPK['kode_pk']}>{$HPK['nama_paket']}</option>";
		}

		$QTnk=mysql_query("select * from ak_kelas where tahunajaran='$thnajaran' and tingkat='$tingkat' group by tingkat");
		while ($HTnk=mysql_fetch_array($QTnk)){
			$Sel=$HTnk['tingkat']==$_GET['tingkat']?"selected":"";
			$DtTingkat.="<option $Sel value={$HTnk['tingkat']}>{$HTnk['tingkat']}</option>";
		}

		for($i=0;$i<count($Ref->TingkatKls);$i++)
		{
			$Sel = $Ref->TingkatKls[$i]==$_GET['tingkat']?" selected ":"";
			$TkKelas .= "<option $Sel value=\"{$Ref->TingkatKls[$i]}\">{$Ref->TingkatKls[$i]}</option>";
		}

		if($tingkat=="X"){
			for($x=0;$x<count($Ref->SmstX);$x++)
			{
				$Sel = $Ref->SmstX[$x]==$_GET['gg']?" selected ":"";
				$InputTS .= "<option $Sel value=\"{$Ref->SmstX[$x]}\">{$Ref->SmstX[$x]}</option>";
			}
		}
		else if($tingkat=="XI"){
			for($x=0;$x<count($Ref->SmstXI);$x++)
			{
				$Sel = $Ref->SmstXI[$x]==$_GET['gg']?" selected ":"";
				$InputTS .= "<option $Sel value=\"{$Ref->SmstXI[$x]}\">{$Ref->SmstXI[$x]}</option>";
			}		
		}
		else if($tingkat=="XII"){
			for($x=0;$x<count($Ref->SmstXII);$x++)
			{
				$Sel = $Ref->SmstXII[$x]==$_GET['gg']?" selected ":"";
				$InputTS .= "<option $Sel value=\"{$Ref->SmstXII[$x]}\">{$Ref->SmstXII[$x]}</option>";
			}
		}

		$QKls=mysql_query("select * from ak_kelas where tahunajaran='$thnajaran' and tingkat='$tingkat' and kode_pk='$kdpk' order by kode_kelas,tingkat,kode_pk desc");
		while ($HKls=mysql_fetch_array($QKls)){
			$Sel=$HKls['kode_kelas']==$_GET['id_kls']?"selected":"";
			$DataKelas.="<option $Sel value={$HKls['kode_kelas']}>{$HKls['nama_kelas']}</option>";
		}

		$Show.="
		<form action='?page=$page' method='post' name='frmaing' class='form-inline' role='form'>
			<div class='row'>
				<div class='col-sm-12 col-md-12'>
					<div class='form-group'>
						<select name=\"txtThnAjar\" class='input-sm form-control' disabled='disabled'>
							<option value=''>Pilih</option>
							$InputTA
						</select>
					</div>
					<div class='form-group'>
						<select name=\"txtPK\"  class='input-sm form-control' disabled='disabled'>
							<option value=''>Pilih</option>
							$DtPK
						</select>
					</div>
					<div class='form-group'>
						<select name=\"txtTingkat\"  class='input-sm form-control' disabled='disabled'>
							<option value=''>Pilih</option>
							$TkKelas
						</select>
					</div>
					<div class='form-group'>
						<select name=\"txtSemester\"  class='input-sm form-control'  disabled='disabled'>
							<option value=''>Pilih</option>
							$InputTS
						</select>
					</div>
					<div class='form-group'>
						<select name=\"txtIdKls\"  class='input-sm form-control' disabled='disabled'>
							<option value=''>Pilih</option>
							$DataKelas
						</select>
					</div>
				</div>
			</div>
		</form><hr>";

		$Q=mysql_query("
		select 
		ak_kelas.kode_kelas,
		ak_kelas.tahunajaran,
		ak_kelas.tingkat,
		ak_kelas.kode_pk,
		ak_matapelajaran.kode_mapel,
		ak_matapelajaran.nama_mapel,
		ak_matapelajaran.jenismapel,
		ak_matapelajaran.semester1,
		ak_matapelajaran.semester2,
		ak_matapelajaran.semester3,
		ak_matapelajaran.semester4,
		ak_matapelajaran.semester5,
		ak_matapelajaran.semester6
		from ak_kelas
		inner join ak_matapelajaran on ak_kelas.kode_pk=ak_matapelajaran.kode_pk
		where 
		ak_kelas.tahunajaran='$thnajaran' and 
		ak_kelas.tingkat='$tingkat' and 
		ak_kelas.kode_kelas='$id_kls' and 
		ak_matapelajaran.kode_pk='$kdpk' and ak_matapelajaran.semester$gg='1'");
		
		for($i=75;$i<=95;$i++){$IsiKKM.="<option value ='$i'>$i</option>";}

		$QPTK=mysql_query("select id_guru,nama_lengkap,aktif from app_user_guru where aktif='Aktif' order by nama_lengkap");
		while ($HPTK=mysql_fetch_array($QPTK)){
			$DtGuru2.="<option value={$HPTK['id_guru']}>{$HPTK['nama_lengkap']}</option>";
		}

		if($gg=="1"){$GanGen.="Ganjil";}else if($gg=="2"){$GanGen.="Genap";}
		else if($gg=="3"){$GanGen.="Ganjil";}else if($gg=="4"){$GanGen.="Genap";}
		else if($gg=="5"){$GanGen.="Ganjil";}else if($gg=="6"){$GanGen.="Genap";}
		
		$i=1;
		while($Hasil=mysql_fetch_array($Q)){

			if($PilSemester=="Genap"){
				/*
				$QDtNgajar=mysql_query("select 
				ngajar.id_ngajar,
				ngajar.kkmpeng,
				ngajar.kkmket, 
				ngajar.ganjilgenap, 
				user_guru.nama_lengkap,
				user_guru.id_guru,
				matapelajaran.kode_mapel,
				matapelajaran.nama_mapel
				from ngajar 
				inner join user_guru on ngajar.kd_guru=user_guru.id_guru
				inner join matapelajaran on ngajar.kd_mapel=matapelajaran.kode_mapel
				where ngajar.thnajaran='$thnajaran' and ngajar.kd_pk='$kdpk' and ngajar.kd_kelas='$id_kls' and ngajar.ganjilgenap='Ganjil' and matapelajaran.kode_mapel='{$Hasil['kode_mapel']}'");
				*/

				$QDtNgajar=mysql_query("select id_guru,nama_lengkap,aktif from app_user_guru where aktif='Aktif' order by nama_lengkap");
				while ($HPTK=mysql_fetch_array($QDtNgajar)){
					$Sel=$HPTK['kode_mapel']==$Hasil['kode_mapel']?"selected":"";
					$DtGuru.="<option $Sel value={$HPTK['id_guru']}>{$HPTK['nama_lengkap']}</option>";
					//$DtGuru.="<option value={$HPTK['id_guru']}>{$HPTK['nama_lengkap']}</option>";
				}
			}else
			{
					$DtGuru=$DtGuru2;
			}

			$ShowNPData.="
			<tr>
				<td class='text-center'>$i.</td>
				<td>{$Hasil['nama_mapel']}</td>
				<td class='text-center'>
					<input class='form-control input-sm' type='hidden' value='".$thnajaran."' name='txtThnAjar[$i]'>
					<div class='form-group'>
						<div class='col-sm-12'>
							<select name='txtIDGuru[$i]' class='input-sm form-control'>
								<option value=''>-----------------------[ Pilih Nama Guru ]-----------------------</option>
								$DtGuru
							</select>
						</div>
					</div>
					<input class='form-control input-sm' type='hidden' value='".$kdpk."' name='txtKodePK[$i]'>
					<input class='form-control input-sm' type='hidden' value='".$Hasil['kode_mapel']."' name='txtKodeMapel[$i]'>
					<input class='form-control input-sm' type='hidden' value='".$Hasil['jenismapel']."' name='txtJenisMapel[$i]'>
					<input class='form-control input-sm' type='hidden' value='".$id_kls."' name='txtKodeKls[$i]'>
					<input class='form-control input-sm' type='hidden' value='".$gg."' name='txtSmster[$i]'>
					<input class='form-control input-sm' type='hidden' value='".$GanGen."' name='TxtGG[$i]'>
				</td>
				<td><select name='TxtKKMP[$i]' class='form-control input-sm'>".$IsiKKM."</select></td>
				<td><select name='TxtKKMK[$i]' class='form-control input-sm'>".$IsiKKM."</select></td>
			</tr>";
			$i++;
		}
		
		$QDtNgajar=mysql_query("
			select 
			gmp_ngajar.id_ngajar,
			gmp_ngajar.kkmpeng,
			gmp_ngajar.kkmket, 
			gmp_ngajar.ganjilgenap, 
			app_user_guru.nama_lengkap,
			ak_matapelajaran.kode_mapel,
			ak_matapelajaran.nama_mapel
			from gmp_ngajar 
			inner join app_user_guru on gmp_ngajar.kd_guru=app_user_guru.id_guru
			inner join ak_matapelajaran on gmp_ngajar.kd_mapel=ak_matapelajaran.kode_mapel
			where 
			gmp_ngajar.thnajaran='$thnajaran' and 
			gmp_ngajar.kd_pk='$kdpk' and 
			gmp_ngajar.kd_kelas='$id_kls' and 
			gmp_ngajar.ganjilgenap='$PilSmstr' 
			order by ak_matapelajaran.kode_mapel");
		$a=1;
		while($HNgajar=mysql_fetch_array($QDtNgajar)){
			$ShowNPData2.="
			<tr>
				<td>$a.</td>
				<td>{$HNgajar['id_ngajar']}</td>
				<td>{$HNgajar['nama_mapel']}</td>
				<td>{$HNgajar['nama_lengkap']}</td>
				<td>{$HNgajar['kkmpeng']}</td>
				<td>{$HNgajar['kkmket']}</td>
			</tr>";

			$a++;
		}

		$JmlData=mysql_num_rows($Q);
		if($JmlData>0){
			$DataNgajar=JmlDt("select * from gmp_ngajar where thnajaran='$thnajaran' and kd_pk='$kdpk' and kd_kelas='$id_kls' and semester='$gg'");	
			if($DataNgajar>0){
				$Show.=nt("informasi","Data KBM sudah di tambahkan");
				$Show.="<div class='well no-padding'>
				<table id='dt_basic' class='table table-striped table-bordered table-hover table-condensed' width='100%'>
					<thead>
						<tr>
							<th class='text-center' data-class='expand'>No.</th>
							<th class='text-center' data-hide='phone'>Kode Ngajar</th>
							<th class='text-center'>Mata Pelajaran</th>
							<th class='text-center' data-hide='phone'>Nama Pengajar</th>
							<th class='text-center' data-hide='phone'>KKM K3</th>
							<th class='text-center' data-hide='phone'>KKM K4</th>
						</tr>
					</thead>
					<tbody>$ShowNPData2</tbody>
				</table>
				</div>";
			}
			else {
				$Show.="		
				<form action='?page=$page&sub=nyimpenkbm' method='post' name='FrmKBMna' id='FrmKBMna' role='form'>
				<table id='simple-table' class='table table-striped table-bordered table-hover'>
					<thead>
						<tr>
							<th class='text-center'>No.</th>
							<th class='text-center'>Mata Pelajaran</th>
							<th class='text-center'>Nama Pengajar</th>
							<th class='text-center'>KKM K3</th>
							<th class='text-center'>KKM K4</th>
						</tr>
					</thead>
					<tbody>$ShowNPData</tbody>
				</table>
				<div class='form-actions'>".iSubmit("SaveTambah","Simpan")."</div></form>";
			}
		}

		echo MyWidget('fa-plus',"Tambah Data Ngajar",array(ButtonKembali("?page=$page")),$Show);
	break;

	case "nyimpenkbm":
			foreach($_POST['txtThnAjar'] as $i => $txtThnAjar){
				//$txtThnAjar=$_POST['txtThnAjar'][$i];
				$txtIDGuru=$_POST['txtIDGuru'][$i];
				$txtKodePK=$_POST['txtKodePK'][$i];
				$txtKodeMapel=$_POST['txtKodeMapel'][$i];
				$txtJenisMapel=$_POST['txtJenisMapel'][$i];
				$txtKodeKls=$_POST['txtKodeKls'][$i];
				$txtSmster=$_POST['txtSmster'][$i];
				$TxtGG=$_POST['TxtGG'][$i];
				$TxtKKMP=$_POST['TxtKKMP'][$i];
				$TxtKKMK=$_POST['TxtKKMK'][$i];
				$kd_KBM=buatKode("gmp_ngajar","kbm_");
				mysql_query("INSERT INTO gmp_ngajar VALUES ('$kd_KBM','$txtThnAjar','$txtIDGuru','$txtKodePK','$txtKodeMapel','$txtJenisMapel','$txtKodeKls','$txtSmster','$TxtGG','$TxtKKMP','$TxtKKMK')");
				echo ns("Nambah","parent.location='?page=$page'","KBM Kelas $txtKodeKls");
			}	
	/*	}	*/
	break;

	case "simpan_kd_ngajar":
		$kelas=(isset($_GET['kls']))?$_GET['kls']:"";
		$thnajaran=(isset($_GET['thnajaran']))?$_GET['thnajaran']:"";
		$gg=(isset($_GET['gg']))?$_GET['gg']:"";
		$tingkat=(isset($_GET['tk']))?$_GET['tk']:"";

		$Q=mysql_query("select * from gmp_ngajar where kd_kelas='$kelas' and thnajaran='$thnajaran' and ganjilgenap='$gg' order by kd_mapel");
		$JmMP=mysql_num_rows($Q);

		mysql_query("INSERT INTO leger_nilai_mapel VALUES ('','$kelas','$thnajaran','$gg',
		'','','','',
		'','','','',
		'','','','',
		'','','','',
		'','','','',
		'','','','',
		'','','','',
		'','','','',
		'','','','',
		'','','','',
		'','','','',
		'','','','',
		'','','','',
		'','','','',
		'','','','',
		'','','','',
		'','','','',
		'','','','',
		'','','','',
		'','','','',
		'','','','')");

		$noKBM=1;			
		while($HNgajar=mysql_fetch_array($Q))
		{	
			mysql_query("
				UPDATE leger_nilai_mapel 
				SET 
				kd_mapel$noKBM='{$HNgajar['kd_mapel']}',
				kd_ngajar$noKBM='{$HNgajar['id_ngajar']}',
				KKMP$noKBM='{$HNgajar['kkmpeng']}',
				KKMK$noKBM='{$HNgajar['kkmket']}' 
				WHERE 
				id_kls='$kelas' and 
				thnajaran='$thnajaran' and 
				semester='$gg'");
			$noKBM++;
		}
		echo ns("Ngedit","parent.location='?page=$page&sub=simpan_nilai_leger&thnajaran=$thnajaran&tk=$tingkat&gg=$gg&kls=$kelas'","Leger Mapel Kelas $kelas");
	break;

	case "simpan_kd_ngajar_single":
		$kelas=(isset($_GET['kls']))?$_GET['kls']:"";
		$thnajaran=(isset($_GET['thnajaran']))?$_GET['thnajaran']:"";
		$gg=(isset($_GET['gg']))?$_GET['gg']:"";
		$tingkat=(isset($_GET['tk']))?$_GET['tk']:"";

		$Q=mysql_query("select * from gmp_ngajar where kd_kelas='$kelas' and thnajaran='$thnajaran' and ganjilgenap='$gg' order by kd_mapel");
		$JmMP=mysql_num_rows($Q);

		$CQLgr=mysql_query("select * from leger_nilai_mapel where id_kls='$kelas' and thnajaran='$thnajaran' and semester='$gg' order by kd_mapel");
		$JmLgr=mysql_num_rows($CQLgr);

		if($JmLgr>0){
			echo TampilPeringatan("MOHON PERHATIAN","Data Leger untuk kelas <span class='txt-color-orangeDark'><strong>$kelas </strong></span> sudah ada.","parent.location='?page=$page&sub=simpan_nilai_leger&thnajaran=$thnajaran&tk=$tingkat&gg=$gg&kls=$kelas'");

		}else
		{
			mysql_query("INSERT INTO leger_nilai_mapel VALUES ('','$kelas','$thnajaran','$gg',
			'','','','',
			'','','','',
			'','','','',
			'','','','',
			'','','','',
			'','','','',
			'','','','',
			'','','','',
			'','','','',
			'','','','',
			'','','','',
			'','','','',
			'','','','',
			'','','','',
			'','','','',
			'','','','',
			'','','','',
			'','','','',
			'','','','',
			'','','','',
			'','','','')");

			$noKBM=1;			
			while($HNgajar=mysql_fetch_array($Q))
			{	
				mysql_query("
					UPDATE leger_nilai_mapel 
					SET 
					kd_mapel$noKBM='{$HNgajar['kd_mapel']}',
					kd_ngajar$noKBM='{$HNgajar['id_ngajar']}',
					KKMP$noKBM='{$HNgajar['kkmpeng']}',
					KKMK$noKBM='{$HNgajar['kkmket']}' 
					WHERE 
					id_kls='$kelas' and 
					thnajaran='$thnajaran' and 
					semester='$gg'");
				$noKBM++;
			}
			
			echo '<div id="preloader"><div id="cssload"></div></div>';
			echo ns("Ngedit","parent.location='?page=$page'","Leger Siswa $kelas");
		}
	break;

	case "hapus_kd_ngajar":
		$kelas=(isset($_GET['kls']))?$_GET['kls']:"";
		$thnajaran=(isset($_GET['thnajaran']))?$_GET['thnajaran']:"";
		$gg=(isset($_GET['gg']))?$_GET['gg']:"";
		$tingkat=(isset($_GET['tk']))?$_GET['tk']:"";
		mysql_query("DELETE FROM leger_nilai_mapel where id_kls='$kelas' and thnajaran='$thnajaran' and semester='$gg'");
		echo ns("Hapus","parent.location='?page=$page&sub=hapus_nilai_leger&thnajaran=$thnajaran&tk=$tingkat&gg=$gg&kls=$kelas'","Daftar Ngajar Kelas $kelas");
	break;

	case "simpan_nilai_leger":
		$thnajaran=(isset($_GET['thnajaran']))?$_GET['thnajaran']:"";
		$tingkat=(isset($_GET['tk']))?$_GET['tk']:"";
		$gg=(isset($_GET['gg']))?$_GET['gg']:"";
		$kelas=(isset($_GET['kls']))?$_GET['kls']:"";

		$Q=mysql_query("SELECT * FROM gmp_ngajar WHERE kd_kelas='$kelas' and thnajaran='$thnajaran' and ganjilgenap='$gg' order by kd_mapel");
		$JmlMP=mysql_num_rows($Q);

		$QLgr=mysql_query("
			select 
			ak_kelas.kode_kelas,
			ak_kelas.tahunajaran,
			ak_perkelas.nis 
			from ak_kelas 
			inner join ak_perkelas on ak_kelas.nama_kelas=ak_perkelas.nm_kelas and 
			ak_kelas.tahunajaran=ak_perkelas.tahunajaran 
			where ak_kelas.kode_kelas='$kelas'");
		$NoNL=1;
		while($HLN=mysql_fetch_array($QLgr))
		{
			$nisna=$HLN['nis'];

			if($tingkat=='X' && $gg=='Ganjil'){$gangen='1';}else
			if($tingkat=='X' && $gg=='Genap'){$gangen='2';}else
			if($tingkat=='XI' && $gg=='Ganjil'){$gangen='3';}else
			if($tingkat=='XI' && $gg=='Genap'){$gangen='4';}else
			if($tingkat=='XII' && $gg=='Ganjil'){$gangen='5';}else
			if($tingkat=='XII' && $gg=='Genap'){$gangen='6';}
					
			$QDL=mysql_query("select * from leger_nilai_mapel where id_kls='$kelas' and thnajaran='$thnajaran' and semester='$gg'");
			$HDL=mysql_fetch_array($QDL);

			$kbmna=array(
			$HDL['kd_ngajar1'],
			$HDL['kd_ngajar2'],
			$HDL['kd_ngajar3'],
			$HDL['kd_ngajar4'],
			$HDL['kd_ngajar5'],
			$HDL['kd_ngajar6'],
			$HDL['kd_ngajar7'],
			$HDL['kd_ngajar8'],
			$HDL['kd_ngajar9'],
			$HDL['kd_ngajar10'],
			$HDL['kd_ngajar11'],
			$HDL['kd_ngajar12'],
			$HDL['kd_ngajar13'],
			$HDL['kd_ngajar14'],
			$HDL['kd_ngajar15'],
			$HDL['kd_ngajar16'],
			$HDL['kd_ngajar17'],
			$HDL['kd_ngajar18'],
			$HDL['kd_ngajar19'],
			$HDL['kd_ngajar20'],
			$HDL['kd_ngajar21']);

			
			$P1=nilaik3(0);
			$P2=nilaik3(1);
			$P3=nilaik3(2);
			$P4=nilaik3(3);
			$P5=nilaik3(4);
			$P6=nilaik3(5);
			$P7=nilaik3(6);
			$P8=nilaik3(7);
			$P9=nilaik3(8);
			$P10=nilaik3(9);
			$P11=nilaik3(10);
			$P12=nilaik3(11);
			$P13=nilaik3(12);
			$P14=nilaik3(13);
			$P15=nilaik3(14);
			$P16=nilaik3(15);
			$P17=nilaik3(16);
			$P18=nilaik3(17);
			$P19=nilaik3(18);
			$P20=nilaik3(19);
			$P21=nilaik3(20);

			$NAP=(
			$P1+
			$P2+
			$P3+
			$P4+
			$P5+
			$P6+
			$P7+
			$P8+
			$P9+
			$P10+
			$P11+
			$P12+
			$P13+
			$P14+
			$P15+
			$P16+
			$P17+
			$P18+
			$P19+
			$P20+
			$P21)/$JmlMP;

			mysql_query("INSERT INTO leger_nilai_k3 VALUES	('',
			'$nisna',
			'$thnajaran',
			'$tingkat',
			'$gangen',
			'$gg',
			'$kelas',
			'".$kbmna[0]."','".$P1."',
			'".$kbmna[1]."','".$P2."',
			'".$kbmna[2]."','".$P3."',
			'".$kbmna[3]."','".$P4."',
			'".$kbmna[4]."','".$P5."',
			'".$kbmna[5]."','".$P6."',
			'".$kbmna[6]."','".$P7."',
			'".$kbmna[7]."','".$P8."',
			'".$kbmna[8]."','".$P9."',
			'".$kbmna[9]."','".$P10."',
			'".$kbmna[10]."','".$P11."',
			'".$kbmna[11]."','".$P12."',
			'".$kbmna[12]."','".$P13."',
			'".$kbmna[13]."','".$P14."',
			'".$kbmna[14]."','".$P15."',
			'".$kbmna[15]."','".$P16."',
			'".$kbmna[16]."','".$P17."',
			'".$kbmna[17]."','".$P18."',
			'".$kbmna[18]."','".$P19."',
			'".$kbmna[19]."','".$P20."',
			'".$kbmna[20]."','".$P21."',
			'".$NAP."'
			)");

			$K1=nilaik4(0);
			$K2=nilaik4(1);
			$K3=nilaik4(2);
			$K4=nilaik4(3);
			$K5=nilaik4(4);
			$K6=nilaik4(5);
			$K7=nilaik4(6);
			$K8=nilaik4(7);
			$K9=nilaik4(8);
			$K10=nilaik4(9);
			$K11=nilaik4(10);
			$K12=nilaik4(11);
			$K13=nilaik4(12);
			$K14=nilaik4(13);
			$K15=nilaik4(14);
			$K16=nilaik4(15);
			$K17=nilaik4(16);
			$K18=nilaik4(17);
			$K19=nilaik4(18);
			$K20=nilaik4(19);
			$K21=nilaik4(20);

			$NAK=(
			$K1+
			$K2+
			$K3+
			$K4+
			$K5+
			$K6+
			$K7+
			$K8+
			$K9+
			$K10+
			$K11+
			$K12+
			$K13+
			$K14+
			$K15+
			$K16+
			$K17+
			$K18+
			$K19+
			$K20+
			$K21)/$JmlMP;

			mysql_query("INSERT INTO leger_nilai_k4 VALUES	('',
			'$nisna',
			'$thnajaran',
			'$tingkat',
			'$gangen',
			'$gg',
			'$kelas',
			'".$kbmna[0]."','".$K1."',
			'".$kbmna[1]."','".$K2."',
			'".$kbmna[2]."','".$K3."',
			'".$kbmna[3]."','".$K4."',
			'".$kbmna[4]."','".$K5."',
			'".$kbmna[5]."','".$K6."',
			'".$kbmna[6]."','".$K7."',
			'".$kbmna[7]."','".$K8."',
			'".$kbmna[8]."','".$K9."',
			'".$kbmna[9]."','".$K10."',
			'".$kbmna[10]."','".$K11."',
			'".$kbmna[11]."','".$K12."',
			'".$kbmna[12]."','".$K13."',
			'".$kbmna[13]."','".$K14."',
			'".$kbmna[14]."','".$K15."',
			'".$kbmna[15]."','".$K16."',
			'".$kbmna[16]."','".$K17."',
			'".$kbmna[17]."','".$K18."',
			'".$kbmna[18]."','".$K19."',
			'".$kbmna[19]."','".$K20."',
			'".$kbmna[20]."','".$K21."',
			'".$NAK."'
			)");
			

			//Nilai UTS
			$UTS1=nilaiuts(0);
			$UTS2=nilaiuts(1);
			$UTS3=nilaiuts(2);
			$UTS4=nilaiuts(3);
			$UTS5=nilaiuts(4);
			$UTS6=nilaiuts(5);
			$UTS7=nilaiuts(6);
			$UTS8=nilaiuts(7);
			$UTS9=nilaiuts(8);
			$UTS10=nilaiuts(9);
			$UTS11=nilaiuts(10);
			$UTS12=nilaiuts(11);
			$UTS13=nilaiuts(12);
			$UTS14=nilaiuts(13);
			$UTS15=nilaiuts(14);
			$UTS16=nilaiuts(15);
			$UTS17=nilaiuts(16);
			$UTS18=nilaiuts(17);
			$UTS19=nilaiuts(18);
			$UTS20=nilaiuts(19);
			$UTS21=nilaiuts(20);

			$NAUTS=(
			$UTS1+
			$UTS2+
			$UTS3+
			$UTS4+
			$UTS5+
			$UTS6+
			$UTS7+
			$UTS8+
			$UTS9+
			$UTS10+
			$UTS11+
			$UTS12+
			$UTS13+
			$UTS14+
			$UTS15+
			$UTS16+
			$UTS17+
			$UTS18+
			$UTS19+
			$UTS20+
			$UTS21)/$JmlMP;

			mysql_query("INSERT INTO leger_nilai_uts VALUES	('',
			'$nisna',
			'$thnajaran',
			'$tingkat',
			'$gangen',
			'$gg',
			'$kelas',
			'".$kbmna[0]."','".$UTS1."',
			'".$kbmna[1]."','".$UTS2."',
			'".$kbmna[2]."','".$UTS3."',
			'".$kbmna[3]."','".$UTS4."',
			'".$kbmna[4]."','".$UTS5."',
			'".$kbmna[5]."','".$UTS6."',
			'".$kbmna[6]."','".$UTS7."',
			'".$kbmna[7]."','".$UTS8."',
			'".$kbmna[8]."','".$UTS9."',
			'".$kbmna[9]."','".$UTS10."',
			'".$kbmna[10]."','".$UTS11."',
			'".$kbmna[11]."','".$UTS12."',
			'".$kbmna[12]."','".$UTS13."',
			'".$kbmna[13]."','".$UTS14."',
			'".$kbmna[14]."','".$UTS15."',
			'".$kbmna[15]."','".$UTS16."',
			'".$kbmna[16]."','".$UTS17."',
			'".$kbmna[17]."','".$UTS18."',
			'".$kbmna[18]."','".$UTS19."',
			'".$kbmna[19]."','".$UTS20."',
			'".$kbmna[20]."','".$UTS21."',
			'".$NAUTS."'
			)");


			//Nilai UAS
			$UAS1=nilaiuas(0);
			$UAS2=nilaiuas(1);
			$UAS3=nilaiuas(2);
			$UAS4=nilaiuas(3);
			$UAS5=nilaiuas(4);
			$UAS6=nilaiuas(5);
			$UAS7=nilaiuas(6);
			$UAS8=nilaiuas(7);
			$UAS9=nilaiuas(8);
			$UAS10=nilaiuas(9);
			$UAS11=nilaiuas(10);
			$UAS12=nilaiuas(11);
			$UAS13=nilaiuas(12);
			$UAS14=nilaiuas(13);
			$UAS15=nilaiuas(14);
			$UAS16=nilaiuas(15);
			$UAS17=nilaiuas(16);
			$UAS18=nilaiuas(17);
			$UAS19=nilaiuas(18);
			$UAS20=nilaiuas(19);
			$UAS21=nilaiuas(20);

			$NAUTS=(
			$UAS1+
			$UAS2+
			$UAS3+
			$UAS4+
			$UAS5+
			$UAS6+
			$UAS7+
			$UAS8+
			$UAS9+
			$UAS10+
			$UAS11+
			$UAS12+
			$UAS13+
			$UAS14+
			$UAS15+
			$UAS16+
			$UAS17+
			$UAS18+
			$UAS19+
			$UAS20+
			$UAS21)/$JmlMP;

			mysql_query("INSERT INTO leger_nilai_uas VALUES	('',
			'$nisna',
			'$thnajaran',
			'$tingkat',
			'$gangen',
			'$gg',
			'$kelas',
			'".$kbmna[0]."','".$UAS1."',
			'".$kbmna[1]."','".$UAS2."',
			'".$kbmna[2]."','".$UAS3."',
			'".$kbmna[3]."','".$UAS4."',
			'".$kbmna[4]."','".$UAS5."',
			'".$kbmna[5]."','".$UAS6."',
			'".$kbmna[6]."','".$UAS7."',
			'".$kbmna[7]."','".$UAS8."',
			'".$kbmna[8]."','".$UAS9."',
			'".$kbmna[9]."','".$UAS10."',
			'".$kbmna[10]."','".$UAS11."',
			'".$kbmna[11]."','".$UAS12."',
			'".$kbmna[12]."','".$UAS13."',
			'".$kbmna[13]."','".$UAS14."',
			'".$kbmna[14]."','".$UAS15."',
			'".$kbmna[15]."','".$UAS16."',
			'".$kbmna[16]."','".$UAS17."',
			'".$kbmna[17]."','".$UAS18."',
			'".$kbmna[18]."','".$UAS19."',
			'".$kbmna[19]."','".$UAS20."',
			'".$kbmna[20]."','".$UAS21."',
			'".$NAUTS."'
			)");

			$NoNL++;
		}
		echo ns("Nambah","parent.location='?page=$page&sub=simpanranking&thnajaran=$thnajaran&tk=$tingkat&gg=$gg&kls=$kelas&jmlmp=$JmlMP'","Data Leger kelas $kelas");
	break;

	case "hapus_nilai_leger":
		$kelas=(isset($_GET['kls']))?$_GET['kls']:"";
		$thnajaran=(isset($_GET['thnajaran']))?$_GET['thnajaran']:"";
		$gg=(isset($_GET['gg']))?$_GET['gg']:"";
		$tingkat=(isset($_GET['tk']))?$_GET['tk']:"";

		mysql_query("DELETE FROM leger_nilai_k3 where id_kls='$kelas' and thnajaran='$thnajaran' and ganjilgenap='$gg'");
		mysql_query("DELETE FROM leger_nilai_k4 where id_kls='$kelas' and thnajaran='$thnajaran' and ganjilgenap='$gg'");
		mysql_query("DELETE FROM leger_nilai_uts where id_kls='$kelas' and thnajaran='$thnajaran' and ganjilgenap='$gg'");
		mysql_query("DELETE FROM leger_nilai_uas where id_kls='$kelas' and thnajaran='$thnajaran' and ganjilgenap='$gg'");

		echo ns("Hapus","parent.location='?page=$page&sub=hapusranking&thnajaran=$thnajaran&tk=$tingkat&gg=$gg&kls=$kelas'","Nilai Leger Kelas $kelas");
	break;

	case "simpanranking":
		$thnajaran=(isset($_GET['thnajaran']))?$_GET['thnajaran']:"";
		$tingkat=(isset($_GET['tk']))?$_GET['tk']:"";
		$gg=(isset($_GET['gg']))?$_GET['gg']:"";
		$kelas=(isset($_GET['kls']))?$_GET['kls']:"";
		$JmlMP=(isset($_GET['jmlmp']))?$_GET['jmlmp']:"";

		$Q="
		select 
		ak_kelas.id_kls,
		ak_kelas.kode_kelas,
		ak_kelas.nama_kelas,
		ak_kelas.tahunajaran,
		siswa_biodata.nis,
		siswa_biodata.nm_siswa 
		from 
		ak_kelas,siswa_biodata,ak_perkelas,ak_paketkeahlian 
		where 
		ak_kelas.nama_kelas=ak_perkelas.nm_kelas and 
		ak_kelas.tahunajaran=ak_perkelas.tahunajaran and 
		ak_perkelas.nis=siswa_biodata.nis and 
		siswa_biodata.kode_paket=ak_paketkeahlian.kode_pk and 
		ak_kelas.kode_kelas='$kelas' ";
		
		$no=1;
		$Query=mysql_query("$Q order by siswa_biodata.nis");
		$JmlData=mysql_num_rows($Query);
		while($Hasil=mysql_fetch_array($Query)){
			$NamaKelas=$Hasil['nama_kelas'];

			$QNPKIKD=mysql_query("select nis,
			((nilai1+nilai2+nilai3+nilai4+nilai5+nilai6+nilai7+nilai8+nilai9+nilai10+nilai11+nilai12+nilai13+nilai14+nilai15+nilai16+nilai17+nilai18+nilai19+nilai20+nilai21)/".$JmlMP.") as rerata from leger_nilai_k3 where id_kls='$kelas' and thnajaran='$thnajaran' and ganjilgenap='$gg' and nis='".$Hasil['nis']."'");			
			$DNPKIKD=mysql_fetch_array($QNPKIKD);

			$QNKKIKD=mysql_query("select nis,
			((nilai1+nilai2+nilai3+nilai4+nilai5+nilai6+nilai7+nilai8+nilai9+nilai10+nilai11+nilai12+nilai13+nilai14+nilai15+nilai16+nilai17+nilai18+nilai19+nilai20+nilai21)/".$JmlMP.") as rerata from leger_nilai_k4 where id_kls='$kelas' and thnajaran='$thnajaran' and ganjilgenap='$gg' and nis='".$Hasil['nis']."'");
			$DNKKIKD=mysql_fetch_array($QNKKIKD);

			$QNUTS=mysql_query("select nis,
			((nilai1+nilai2+nilai3+nilai4+nilai5+nilai6+nilai7+nilai8+nilai9+nilai10+nilai11+nilai12+nilai13+nilai14+nilai15+nilai16+nilai17+nilai18+nilai19+nilai20+nilai21)/".$JmlMP.") as rerata from leger_nilai_uts where id_kls='$kelas' and thnajaran='$thnajaran' and ganjilgenap='$gg' and nis='".$Hasil['nis']."'");
			$DNUTS=mysql_fetch_array($QNUTS);

			$QNUAS=mysql_query("select nis,
			((nilai1+nilai2+nilai3+nilai4+nilai5+nilai6+nilai7+nilai8+nilai9+nilai10+nilai11+nilai12+nilai13+nilai14+nilai15+nilai16+nilai17+nilai18+nilai19+nilai20+nilai21)/".$JmlMP.") as rerata from leger_nilai_uas where id_kls='$kelas' and thnajaran='$thnajaran' and ganjilgenap='$gg' and nis='".$Hasil['nis']."'");
			$DNUAS=mysql_fetch_array($QNUAS);

			$RTUTSUAS=round((($DNUTS['rerata']+$DNUAS['rerata'])/2),2);


			if($tingkat=="X"){
				$NR=round((($DNPKIKD['rerata']+$DNUTS['rerata']+$DNUAS['rerata'])/3),2);

				mysql_query("INSERT INTO n_rank VALUES ('','$kelas','$thnajaran','$gg','{$Hasil['nis']}','{$DNPKIKD['rerata']}','{$RTUTSUAS}','$NR')");
			}
			else{
				$NR=round((($DNPKIKD['rerata']+$DNKKIKD['rerata'])/2),2);
				mysql_query("INSERT INTO n_rank VALUES ('','$kelas','$thnajaran','$gg','{$Hasil['nis']}','{$DNPKIKD['rerata']}','{$DNKKIKD['rerata']}','$NR')");
			}

			$no++;
		}
		echo ns("Nambah","parent.location='?page=$page'","Peringkat Siswa $kelas");
	break;

	case "hapusranking":
		$kelas=(isset($_GET['kls']))?$_GET['kls']:"";
		$thnajaran=(isset($_GET['thnajaran']))?$_GET['thnajaran']:"";
		$gg=(isset($_GET['gg']))?$_GET['gg']:"";
		$tingkat=(isset($_GET['tk']))?$_GET['tk']:"";
		mysql_query("DELETE FROM n_rank where id_kls='$kelas' and thnajaran='$thnajaran' and semester='$gg'");
		echo ns("Hapus","parent.location='?page=$page'","Rangking Kelas $kelas");
	break;

	case "updateta":
		$thnajar=isset($_GET['thnajar'])?$_GET['thnajar']:"";
		$JmlData=JmlDt("select * from app_pilih_data where id_pil='$IDna'");

		if($JmlData==0){
			mysql_query("insert into app_pilih_data values ('$IDna','$thnajar','','','','','','','','','')");
		}else {
			mysql_query("update app_pilih_data set tahunajaran='$thnajar' where id_pil='$IDna'");
		}
		echo ns("Milih","parent.location='?page=$page'","Tahun Ajaran $thnajar");
	break;

	case "updategg":
		$gg=isset($_GET['gg'])?$_GET['gg']:"";
		mysql_query("update app_pilih_data set semester='$gg' where id_pil='$IDna'");
		echo ns("Milih","parent.location='?page=$page'","Semester $gg");		
	break;

	case "updatedatakbm":
		$kelas=(isset($_GET['kelas']))?$_GET['kelas']:"";
		$tingkat=(isset($_GET['tingkat']))?$_GET['tingkat']:"";
		mysql_query("update app_pilih_data set kd_kelas='$kelas',tingkat='$tingkat' where id_pil='$IDna'");
		echo ns("Milih","parent.location='?page=$page'","Tingkat $tingkat dan kelas $kelas");	
	break;

	case "updatetinggi":
		$tinggi=isset($_GET['tinggi'])?$_GET['tinggi']:""; 
		mysql_query("update app_pilih_data set tinggi='$tinggi' where id_pil='$IDna'");
		echo ns("Milih","parent.location='?page=$page'","Tinggi Cetak $tinggi");	
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

		$('.view_data').click(function(){
			var id = $(this).attr("id");
			$.ajax({
				url: 'lib/app_modal.php?md=DaftarSiswa',
				method: 'post',
				data: {id:id},
				success:function(data){	
					$('#data_siswa212').html(data);
					$('#myModal').modal("show");
				}
			});
		});


})
</script>