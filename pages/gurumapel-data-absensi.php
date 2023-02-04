<?php
require_once("inc/init.php");
require_once("inc/config.ui.php");
$page_title = "Absensi Guru Mapel";
$page_css[] = "your_style.css";
include("inc/header.php");
$page_nav["kbm"]["sub"]["absensimapel"]["active"] = true;
include("inc/nav.php");
echo "<div id='main' role='main'>";
$breadcrumbs["Proses KBM"] = "";
include("inc/ribbon.php");	
$sub=(isset($_GET['sub']))?$_GET['sub']:"";
switch($sub)
{
//-------------------------------------------------------------- tampilan awal
	case "tampil":default:
		$Q="
			SELECT 
			gmp_ngajar.id_ngajar,
			gmp_ngajar.kd_guru,
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
			gmp_ngajar.kd_guru=app_user_guru.id_guru and 
			gmp_ngajar.kd_mapel=ak_matapelajaran.kode_mapel and 
			gmp_ngajar.kd_kelas=ak_kelas.kode_kelas and 
			gmp_ngajar.kd_guru='$IDna' and 
			gmp_ngajar.thnajaran='$TahunAjarAktif' and 
			gmp_ngajar.ganjilgenap='$SemesterAktif'";
			$smstr=$SemesterAktif;
	//==========================[tampilkan data absensi]
		$no=1;
		$Query=mysql_query("$Q order by gmp_ngajar.kd_kelas,gmp_ngajar.kd_mapel asc");
		
		while($Hasil=mysql_fetch_array($Query)){
			$NamaGuru=$Hasil['nama_lengkap'];
			$NamaKelas=$Hasil['nama_kelas'];
			$Id_ngajar=$Hasil['id_ngajar'];
			$kdguru=$Hasil['kd_guru'];
			$thajar=$Hasil['thnajaran'];
			$smester=$Hasil['semester'];
			$QSakit=mysql_query("select * from gmp_absensi where kd_ngajar='$Id_ngajar' and absensi='Sakit'");
			$DSakit=mysql_num_rows($QSakit);
			$TotalSakit=$TotalSakit+$DSakit;
			$QIzin=mysql_query("select * from gmp_absensi where kd_ngajar='$Id_ngajar' and absensi='Izin'");
			$DIzin=mysql_num_rows($QIzin);
			$TotalIzin=$TotalIzin+$DIzin;
			
			$QAlfa=mysql_query("select * from gmp_absensi where kd_ngajar='$Id_ngajar' and absensi='Alfa'");
			$DAlfa=mysql_num_rows($QAlfa);
			$TotalAlfa=$TotalAlfa+$DAlfa;
			
			$TotAbsensi = $DSakit+$DIzin+$DAlfa;
			$TotalSeluruhAbsensi=$TotalSeluruhAbsensi+$TotAbsensi;
			
			$TampilData.="
			<tr>
				<td class='text-center'>$no.</td>
				<td>{$Hasil['nama_lengkap']}<br><span class='txt-color-red'>{$Hasil['nama_mapel']}</span></td>
				<td>{$Hasil['nama_kelas']}</td>
				<td>{$DSakit}</td>
				<td>{$DIzin}</td>
				<td>{$DAlfa}</td>
				<td>$TotAbsensi</td>
				<td>
					<a href='?page=$page&sub=dafabsensiswa&kbm={$Hasil['id_ngajar']}' title='Ngabsen' class='btn btn-default btn-sm btn-block'>Isi Absen</a>
				</td>
				<td>
					<a href=\"javascript:;\" onClick=\"window.open('./pages/excel/ekspor-data-master.php?eksporex=format-absen&kbm={$Hasil['id_ngajar']}')\" class='btn btn-default btn-sm btn-block'>Download</a>
				</td>
				<td>
					<a href='?page=$page&sub=upload_absen&guru=$kdguru&thnajaran=$thajar&gg=$smester&kbm=$Id_ngajar' title='Upload' class='btn btn-default btn-sm btn-block'>Upload</a>
				</td>
				<td>
					<a href='?page=$page&sub=rekapitulasi&guru=$kdguru&thnajaran=$thajar&gg=$smester&kbm=$Id_ngajar' title='Upload' class='btn btn-default btn-sm btn-block'>Rekap</a>
				</td>
			</tr>";
			$no++;
		}
		
		$jmldata=mysql_num_rows($Query);
		if($jmldata>0){
			
			$StatistikAbsensi="
			<div class='well no-padding'>
				<table class='table'>
					<tr bgcolor='#f5f5f5'>
						<td>No</td>
						<td>Absensi</td>
						<td>Jumlah</td>
						<td>Terbilang</td>
					</tr>
					<tr>
						<td>1.</td>
						<td>Sakit</td>
						<td>$TotalSakit</td>
						<td>".terbilang($TotalSakit)."</td>
					</tr>
					<tr>
						<td>2.</td>
						<td>Izin</td>
						<td>$TotalIzin</td>
						<td>".terbilang($TotalIzin)."</td>
					</tr>
					<tr>
						<td>3.</td>
						<td>Alfa</td>
						<td>$TotalAlfa</td>
						<td>".terbilang($TotalAlfa)."</td>
					</tr>
					<tr>
						<td colspan='2' align='center'><strong>Total Seluruhnya</strong></td>
						<td>$TotalSeluruhAbsensi</td>
						<td>".terbilang($TotalSeluruhAbsensi)."</td>
					</tr>
				</table>
			</div>";
			$Gr.="		
			<table class='highchart' data-graph-container-before='1' data-graph-type='area' style='display:none' data-graph-legend-disabled='1' data-graph-height='198' data-graph-datalabels-enabled='1' data-graph-datalabels-align='top' data-graph-datalabels-color='blue'>
				<thead>
					<tr>                                  
						<th>Absensi</th>
						<th>Jumlah</th>
					</tr>
				 </thead>
				 <tbody>
					<tr>
						<td>Sakit</td>
						<td>$TotalSakit</td>
					</tr>
					<tr>
						<td>Izin</td>
						<td>$TotalIzin</td>
					</tr>
					<tr>
						<td>Alfa</td>
						<td>$TotalAlfa</td>
					</tr>
				</tbody>
			</table>";
			$Show.="";
			
			$Show.=DuaKolomSama(JudulDalam("Statistik Absensi","bar-chart").$StatistikAbsensi.'',JudulDalam("Grafik Absensi","bar-chart").$Gr);
			
			$Show.="
			<div class='well no-padding'>
				<table id='dt_basic' class='table table-striped table-bordered table-hover table-condensed' width='100%'>
					<thead>
						<tr>
							<th class='text-center' data-class='expand'>No. </th>
							<th class='text-center'>Guru dan Mata Pelajaran</th>
							<th class='text-center' data-hide='phone,tablet'>Kelas</th>
							<th class='text-center' data-hide='phone,tablet'>Sakit</th>
							<th class='text-center' data-hide='phone,tablet'>Izin</th>
							<th class='text-center' data-hide='phone,tablet'>Alpa</th>
							<th class='text-center' data-hide='phone,tablet'>Total</th>
							<th class='text-center' width='50'>Absen</th>
							<th class='text-center' data-hide='phone,tablet' width='50'>Format</th>
							<th class='text-center' data-hide='phone,tablet' width='50'>Upload</th>
							<th class='text-center' data-hide='phone,tablet' width='50'>Rekap</th>
						</tr>
					</thead>
					<tbody>$TampilData</tbody>
				</table>
			</div>";
		}
		else{
			$Show.=KolomPanel('
			<p class="text-center"><img src="img/aa.png" width="100" height="231" border="0" alt=""></p><h1 class="text-center"><small class="text-danger slideInRight fast animated"><strong>Data KBM Belum Ditambahkan, Absensi Masih Kosong!</strong></small></h1>');
		}

		$tandamodal="#Ngabsen";
		echo $Ngabsen;
		echo IsiPanel($Show);
	break;
//-------------------------------------------------------------- daftar absensi per ak_kelas
	case "dafabsensiswa":
		$kbm=isset($_GET['kbm'])?$_GET['kbm']:""; 
		$Q="
		select gmp_ngajar.id_ngajar,
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
		from gmp_ngajar
		inner join ak_perkelas on gmp_ngajar.thnajaran=ak_perkelas.tahunajaran 
		inner join ak_kelas on gmp_ngajar.kd_kelas=ak_kelas.kode_kelas and ak_kelas.nama_kelas=ak_perkelas.nm_kelas
		inner join app_user_guru on gmp_ngajar.kd_guru=app_user_guru.id_guru
		inner join ak_matapelajaran on gmp_ngajar.kd_mapel=ak_matapelajaran.kode_mapel
		inner join siswa_biodata on ak_perkelas.nis=siswa_biodata.nis
		where gmp_ngajar.id_ngajar='$kbm'";	
		$no=1;
		$Query=mysql_query("$Q order by siswa_biodata.nm_siswa,ak_perkelas.nis asc");
		$jmlSiswa=mysql_num_rows($Query);
		while($Hasil=mysql_fetch_array($Query)){
			$Matapel=$Hasil['nama_mapel'];
			$Kls=$Hasil['nama_kelas'];
			$GuruNgajar=$Hasil['nama_lengkap'];
			$ThnAjaran=$Hasil['thnajaran'];
			$Smstr=$Hasil['semester']." (".$Hasil['ganjilgenap'].")";
			$NISna=$Hasil['nis'];
			//tampilkan absensi ========================================== query
			$QSakit=mysql_query("select * from gmp_absensi where kd_ngajar='$kbm' and nis='$NISna' and absensi='Sakit'");
			$QIzin=mysql_query("select * from gmp_absensi where kd_ngajar='$kbm' and nis='$NISna' and absensi='Izin'");
			$QAlfa=mysql_query("select * from gmp_absensi where kd_ngajar='$kbm' and nis='$NISna' and absensi='Alfa'");
			
			//tampilkan absensi ========================================== jumlah
			$JmlSakit=mysql_num_rows($QSakit);
			$JmlIzin=mysql_num_rows($QIzin);
			$JmlAlfa=mysql_num_rows($QAlfa);
			
			//tampilkan absensi ========================================== warna
			if($JmlSakit>0){$Sakit="<strong class='red'>$JmlSakit</strong>";}else{$Sakit="";}
			if($JmlIzin>0){$Izin="<strong class='red'>$JmlIzin</strong>";}else{$Izin="";}
			if($JmlAlfa>0){$Alfa="<strong class='red'>$JmlAlfa</strong>";}else{$Alfa="";}
			
			//tampilkan absensi ========================================== total
			$TotAbsen=$JmlSakit+$JmlIzin+$JmlAlfa;
			if($TotAbsen>0){$JmlAbsen="<strong class='red'>$TotAbsen</strong>";}else{$JmlAbsen="";}		
			$TSakit = $TSakit+$JmlSakit;
			$TIzin = $TIzin+$JmlIzin;
			$TAlfa = $TAlfa+$JmlAlfa;
			$TAbsensi = $TAbsensi+$TotAbsen;
			
			$TampilData.="
			<tr>
				<td class='text-center'>$no</td>
				<td class='text-center'>{$Hasil['nis']}</td>
				<td>{$Hasil['nm_siswa']}</td>
				<td>$Sakit</td>
				<td>$Izin</td>
				<td>$Alfa</td>
				<td>$JmlAbsen</td>
				<td class='text-center'>
				<a href='?page=$page&sub=isiabsen&kbm={$Hasil['id_ngajar']}&nis={$Hasil['nis']}'><i class='fa fa-pencil-square fa-2x'></i></a></td>
			</tr>";
			$no++;
		}
		$jmldata=mysql_num_rows($Query);
		if($jmldata>0){
			$Show.=ButtonKembali2("?page=$page","style='margin-top:-10px;'");
			$Show.=JudulKolom("Proses Absensi","calendar");
			$ProfilKBM.=JudulDalam("Profil KBM","");
			$ProfilKBM.=DetailData("Tahun Ajaran",$ThnAjaran);
			$ProfilKBM.=DetailData("Semester",$Smstr);
			$ProfilKBM.=DetailData("Kelas",$Kls);
			$ProfilKBM.=DetailData("Total Siswa",$jmldata);
			$ProfilKBM.=DetailData("Mata Pelajaran",$Matapel);
			$ProfilKBM.=DetailData("Guru Pengajar",$GuruNgajar);
			//$GrafikAbsensi.=JudulDalam("Grafik Absensi");
			//$GrafikAbsensi.='<div id="donut-graph" class="chart no-padding"></div>';
			//$GrafikAbsensi.='<div id="non-date-graph" class="chart no-padding"></div>';
			//$GrafikAbsensi.='<div id="garfikabsenkelas" class="chart"></div>';
			
			$GrafikAbsensi.="<br>Izin <strong>".$TIzin." (".terbilang($TIzin).")</strong>";			
			$GrafikAbsensi.="<br>Sakit <strong>".$TSakit." (".terbilang($TSakit).")</strong>";			
			$GrafikAbsensi.="<br>Alfa <strong>".$TAlfa." (".terbilang($TAlfa).")</strong>";			
			$GrafikAbsensi.="<br>Total Absensi <strong>".$TAbsensi." (".terbilang($TAbsensi).")</strong>";			
			$Show.="
			<form name='dtabsensi'>
			<input type='hidden' name='sakit' value='$TSakit'>
			<input type='hidden' name='izin' value='$TIzin'>
			<input type='hidden' name='alfa' value='$TAlfa'>
			</form>";
			$Gr.=JudulDalam("Grafik Absensi","");
			$Gr.="
			<table class='highchart' data-graph-container-before='1' data-graph-type='pie' style='display:none' data-graph-height='168' data-graph-datalabels-enabled='1' data-graph-datalabels-color='red'>
				<thead>
					<tr>                                  
						<th>Absensi</th>
						<th>Jumlah</th>
					</tr>
				 </thead>
				 <tbody>
					<tr>
						<td>Sakit</td>
						<td data-graph-name='Sakit ( $TSakit )'>$TSakit</td>
					</tr>
					<tr>
						<td>Izin</td>
						<td data-graph-name='Izin ( $TIzin )'>$TIzin</td>
					</tr>
					<tr>
						<td>Alfa</td>
						<td data-graph-name='Alfa ( $TAlfa )'>$TAlfa</td>
					</tr>
				</tbody>
			</table>";
			$Show.="";
			$Show.=DuaKolomSama($ProfilKBM,$Gr);
			$Show.="
			<div class='well no-padding'>
			<table id='dt_basic' class='table table-striped table-bordered table-hover table-condensed' width='100%'>
				<thead>
					<tr>
						<th class='text-center' data-class='expand'>No.</th>
						<th class='text-center' data-hide='phone,tablet'>NIS</th>
						<th class='text-center'>Nama Siswa</th>
						<th class='text-center' data-hide='phone,tablet'>Sakit</th>
						<th class='text-center' data-hide='phone,tablet'>Izin</th>
						<th class='text-center' data-hide='phone,tablet'>Alfa</th>
						<th class='text-center' data-hide='phone,tablet'>Total</th>
						<th class='text-center'>Absensi</th>
					</tr>
				</thead>
				<tbody>				
					$TampilData						
				</tbody>
			</table>
			</div>";
		}
		else{
			$Show.=ButtonKembali2("?page=$page","style='margin-top:-10px;'");
			$Show.=JudulKolom("Daftar Absensi","calendar");
			$Show.=nt("informasi","Data Siswa belum ada, silakan hubungi Administrator.");
		}
		$tandamodal="#NgabsenMapel";
		echo $NgabsenMapel;
		echo IsiPanel($Show);
	break;
//-------------------------------------------------------------- isi absensi per siswa
	case "isiabsen":
		$kbm=isset($_GET['kbm'])?$_GET['kbm']:""; 
		$nis=isset($_GET['nis'])?$_GET['nis']:""; 
		$Q=mysql_query("
		select 
		gmp_ngajar.id_ngajar,
		gmp_ngajar.thnajaran,
		gmp_ngajar.semester,
		ak_kelas.nama_kelas,
		gmp_ngajar.kd_mapel,
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
		where gmp_ngajar.id_ngajar='$kbm' and ak_perkelas.nis='$nis'");
		$Hasil=mysql_fetch_array($Q);
		
		$DtKBM.=JudulDalam("Identitas KBM","");
		$DtKBM.="<table>";
		$DtKBM.=FormInfoTabel("ID KBM",$Hasil['id_ngajar'],"0px");
		$DtKBM.=FormInfoTabel("Tahun Ajaran",$Hasil['thnajaran'],"0px");
		$DtKBM.=FormInfoTabel("Semester",$Hasil['semester'],"0px");
		$DtKBM.="<tr><td colspan='3'>&nbsp;</td></tr>";
		$DtKBM.=FormInfoTabel("Kode Mapel",$Hasil['kd_mapel'],"0px");
		$DtKBM.=FormInfoTabel("Nama Mapel",$Hasil['nama_mapel'],"0px");
		$DtKBM.="<tr><td colspan='3'>&nbsp;</td></tr>";
		$DtKBM.=FormInfoTabel("Kelas",$Hasil['nama_kelas'],"0px");
		$DtKBM.=FormInfoTabel("Nama Siswa",$Hasil['nm_siswa'],"0px");
		$DtKBM.=FormInfoTabel("NIS",$Hasil['nis'],"0px");
		$DtKBM.="</table>";	
		
		$QDAbsensi=mysql_query("select * from gmp_absensi where kd_ngajar='$kbm' and nis='$nis'");
		
		$NoDAbsensi=1;
		while($HDAbsensi=mysql_fetch_array($QDAbsensi))
		{
			$TampilDetailAbsensi .="
			<tr>
				<td>$NoDAbsensi.</td>
				<td>{$HDAbsensi['absensi']}</td>
				<td>".TglLengkap($HDAbsensi['tgl'])."</td>
				<td>{$HDAbsensi['keterangan']}</td>
				<td><a href='?page=$page&sub=ngahapusabsensi&id_absensi={$HDAbsensi['id_absen']}&nis={$HDAbsensi['nis']}&kbm=$kbm' data-action='hapusabsensi' data-hapusabsensi-msg=\"Apakah Anda yakin akan mengapus absensi dari id absensi <strong class='text-primary'>{$HDAbsensi['id_absen']}</strong> dan NIS <strong class='text-primary'>{$HDAbsensi['nis']}</strong>\"><i class='fa fa-trash-o fa-2x txt-color-red'></i></a></td>
			</tr>";
			$NoDAbsensi++;
		}
		$jmldt=mysql_num_rows($QDAbsensi);
		if($jmldt>0){
			$DtKBM.="
			<hr>
			<table class='table well no-padding'>
				<tr bgcolor='f5f5f5'>
					<td>No.</td>
					<td>Absensi</td>
					<td>Tanggal</td>
					<td>Keterangan</td>
					<td>Hapus</td>
				</tr>
				$TampilDetailAbsensi
			</table>";
		}
		$InputAbsen.=JudulDalam("Input Absensi","");
		$InputAbsen.="<form action='?page=$page&sub=simpanisiabsen' method='post' name='frmNgabsen' class='form-horizontal' role='form'>";
		$InputAbsen.='<fieldset>';
		$InputAbsen.="<input type='hidden' name='txtKBM' value='".$Hasil['id_ngajar']."'>";
		$InputAbsen.="<input type='hidden' name='txtNIS' value='".$Hasil['nis']."'>";
		$InputAbsen.=FormCR("horizontal",'Absensi','txtAbsensi',$absensi,$Ref->Absensi,'4',"");
		$InputAbsen.=FormIF("horizontal","Alasan","txtAlasan",$keterangan,'5',"");
		$InputAbsen.=IsiTglHariIni('Tanggal Absensi','txtTgl','txtBln','txtThn',"",2013);
		$InputAbsen.='</fieldset>';
		$InputAbsen.='<div class="form-actions">'.ButtonSimpan().'</div>';
		$InputAbsen.='</form>';

		$Show.=ButtonKembali2("?page=$page&sub=dafabsensiswa&kbm=$kbm","style='margin-top:-10px;'");
		$Show.=JudulKolom("Proses Input Absen Per Siswa","");
		$Show.=DuakolomSama($DtKBM,$InputAbsen);
		
		$tandamodal="#IsiAbsenMapel";
		echo $IsiAbsenMapel;
		echo IsiPanel($Show);
	break;
//-------------------------------------------------------------- simpan ngabsen siswa
	case "simpanisiabsen":
		$txtKBM=addslashes($_POST['txtKBM']);
		$txtNIS=addslashes($_POST['txtNIS']);
		
		$message=array();
		if(trim($_POST['txtAbsensi'])==""){$message[]="Absensi harus diisi !";}
		if(!count($message)==0){$Num=0;
			foreach($message as $indeks=>$pesan_tampil){$Num++;$Pesannya.="$Num. $pesan_tampil<br>";}
			echo Peringatan($Pesannya,"parent.location='?page=$page&sub=isiabsen&kbm=$txtKBM&nis=$txtNIS'");
		}
		else{
			$kd_absen=buatKode("gmp_absensi","abs_");
			$txtKBM=addslashes($_POST['txtKBM']);
			$txtNIS=addslashes($_POST['txtNIS']);
			$txtAbsensi=addslashes($_POST['txtAbsensi']);
			$txtTgl=addslashes($_POST['txtTgl']);
			$txtBln=addslashes($_POST['txtBln']);
			$txtThn=addslashes($_POST['txtThn']);
			$txtAlasan=addslashes($_POST['txtAlasan']);
			$TglAbsen=$txtThn."-".$txtBln."-".$txtTgl;
			NgambilData("select * from siswa_biodata where nis='$txtNIS'");
			mysql_query("INSERT INTO gmp_absensi VALUES ('$kd_absen','$txtKBM','$txtNIS','$txtAbsensi','$TglAbsen','$txtAlasan')");
			echo ns("Nambah","parent.location='?page=$page&sub=isiabsen&kbm=$txtKBM&nis=$txtNIS'","Absensi <strong class='text-primary'>$nm_siswa </strong>");
		}
	break;
//-------------------------------------------------------------- hapus ngabsen siswa
	case "ngahapusabsensi":
		$kbm=isset($_GET['kbm'])?$_GET['kbm']:"";
		$nis=isset($_GET['nis'])?$_GET['nis']:"";
		mysql_query("DELETE FROM gmp_absensi WHERE id_absen='".$_GET['id_absensi']."'");
		NgambilData("select * from siswa_biodata where nis='$nis'");
		echo ns("Hapus","parent.location='?page=$page&sub=isiabsen&kbm=$kbm&nis=$nis'","Absensi <strong class='text-primary'>$nm_siswa </strong>");
	break;
//-------------------------------------------------------------- upload absen 
	case "upload_absen":
		$kbm=isset($_GET['kbm'])?$_GET['kbm']:"";
		$guru=isset($_GET['guru'])?$_GET['guru']:"";
		$thnajaran=isset($_GET['thnajaran'])?$_GET['thnajaran']:"";
		$gg=isset($_GET['gg'])?$_GET['gg']:"";
		$Q=mysql_query("select 
		gmp_ngajar.id_ngajar,
		gmp_ngajar.thnajaran,
		gmp_ngajar.semester,
		ak_kelas.nama_kelas,
		ak_matapelajaran.nama_mapel,
		app_user_guru.nama_lengkap
		from gmp_ngajar
		inner join ak_kelas on gmp_ngajar.kd_kelas=ak_kelas.kode_kelas
		inner join app_user_guru on gmp_ngajar.kd_guru=app_user_guru.id_guru
		inner join ak_matapelajaran on gmp_ngajar.kd_mapel=ak_matapelajaran.kode_mapel
		where gmp_ngajar.id_ngajar='$kbm'");
		$H=mysql_fetch_array($Q);
		$id_guru=$H['id_guru'];
		$Show.="
		<script type=\"text/javascript\">
			function validateForm()
			{
				function hasExtension(inputID, exts) {
					var fileName = document.getElementById(inputID).value;
					return (new RegExp('(' + exts.join('|').replace(/\./g, '\\.') + ')$')).test(fileName);
				}
		 
				if(!hasExtension('filepegawaiall', ['.xls'])){
					alert(\"Hanya file XLS (Excel 2003) yang diijinkan.\");
					return false;
				}
			}
		</script>";
		
		$Keterangan.=nt("informasi","
		ID KBM <strong>{$H['id_ngajar']}</strong><br>Tahun Ajaran <strong>{$H['thnajaran']}</strong><br>Semester <strong>{$H['semester']}</strong><br>Kelas <strong>{$H['nama_kelas']}</strong><br>Mata Pelajaran <strong>{$H['nama_mapel']}</strong>","KBM");
	
		$UloadAbsen.=JudulDalam("Absensi Mata Pelajaran","");
		$UloadAbsen.="
		<form name='myForm' id='myForm' onSubmit='return validateForm()' action='?page=$page&sub=simpanupload&guru=$guru&thnajaran=$thnajaran&gg=$gg&kbm=$kbm' method='post' enctype='multipart/form-data' class='smart-form'>
			<fieldset>
				<section>
					<label class='label'>Pilih File</label>
					<div class='input input-file'>
						<span class='button'>
						<input type='file' id='id-input-file-absen' name='absen' onchange='this.parentNode.nextSibling.value = this.value'>Browse</span><input type='text' placeholder='Include some files' readonly=''>
					</div>
				</section>
				<span class='help-block'>* file yang bisa di import adalah .xls (Excel 2003-2007).</span>
			</fieldset>
			<div class='form-actions center'>
				<button type='button submit' name='submit' class='btn btn-sm btn-success'>
					Submit
					<i class='ace-icon fa fa-arrow-right icon-on-right bigger-110'></i>
				</button>
			</div>
		</form>";
		
		$Show.=ButtonKembali2("?page=$page","style='margin-top:-10px;'");
		$Show.=JudulKolom("Proses Upload Nilai","");
		$Show.=DuaKolomD(6,$Keterangan,6,KolomPanel($UloadAbsen));

		echo IsiPanel($Show);
	break;
//-------------------------------------------------------------- simpan upload
	case "simpanupload":
		$kbm=isset($_GET['kbm'])?$_GET['kbm']:"";
		$guru=isset($_GET['guru'])?$_GET['guru']:"";
		$thnajaran=isset($_GET['thnajaran'])?$_GET['thnajaran']:"";
		$gg=isset($_GET['gg'])?$_GET['gg']:"";
		require_once "pages/excel_reader.php"; 
		$data = new Spreadsheet_Excel_Reader($_FILES['absen']['tmp_name']);
		$Absen = $data->rowcount($sheet_index=4);
		for ($i=3; $i<=$Absen; $i++) {
			$txtNo = $data->val($i,1,4);
			$txtNIS = $data->val($i,2,4);
			$txtNSis = $data->val($i,3,4);
			$txtNsi = $data->val($i,4,4);
			$txtNTgl = $data->val($i,5,4);
			$txtNBln = $data->val($i,6,4);
			$txtNThn = $data->val($i,7,4);
			$txtNKet = $data->val($i,8,4);
			if($txtNTgl<10){$TglA="0".$txtNTgl;}else{$TglA=$txtNTgl;}
			if($txtNBln<10){$BlnA="0".$txtNBln;}else{$BlnA=$txtNBln;}
			$IsiTgl=$txtNThn."-".$BlnA."-".$TglA;
			
			$kd_absensi=buatKode("gmp_absensi","abs_");
			if($txtNIS==""){}else{
			mysql_query("INSERT INTO gmp_absensi VALUES ('$kd_absensi','$kbm','$txtNIS','$txtNsi','$IsiTgl','$txtNKet')");
			}
		}
		echo ns("Ngimpor","parent.location='?page=$page&kbm=$kbm'","$kbm");
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
<script src="<?php echo ASSETS_URL; ?>/js/plugin/morris/raphael.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/morris/morris.min.js"></script>
<!-- Flot Chart Plugin: Flot Engine, Flot Resizer, Flot Tooltip -->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/flot/jquery.flot.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/flot/jquery.flot.pie.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/highchartTable/highcharts.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/highchartTable/jquery.highchartTable.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	var a={
		"hapusabsensi":function(a){
			function b(){
				window.location=a.attr("href")
			}
			$.SmartMessageBox(
				{
					"title":"<h1 style='margin-top:-5px;'><i class='fa fa-fw fa-question-circle bounce animated text-primary'></i><small class='text-primary'><strong> Konfirmasi</strong></small></h1>",
					"content":a.data("hapusabsensi-msg"),
					"buttons":"[No][Yes]"
				},function(a){
					"Yes"==a&&($.root_.addClass("animated fadeOutUp"),setTimeout(b,1e3))
					}
		)}
	}
	$.root_.on("click",'[data-action="hapusabsensi"]',function(b){var c=$(this);a.hapusabsensi(c),b.preventDefault(),c=null});
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
			/* end pie chart */
		$('table.highchart').highchartTable();
		
})
</script>