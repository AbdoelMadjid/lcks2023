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
		$thnajar=isset($_GET['thnajar'])?$_GET['thnajar']:"";
		$nkls=isset($_GET['nmkelas'])?$_GET['nmkelas']:"";
		if(!empty($_GET['thnajar'])){$wh="$thnajar";}

		$FormPilih.="
		<form action='?page=$page' method='post' name='frmPilih' class='form-inline' role='form'>
			<div class='row'>
				<div class='col-sm-12 col-md-8'>
					<div class='form-group'>Pililh Data &nbsp;&nbsp;</div>";		
						$FormPilih.=FormCF("inline","Tahun Ajar","txtTA","select * from ak_tahunajaran","tahunajaran",$thnajar,"tahunajaran","","onchange=\"document.location.href='?page=$page&thnajar='+document.frmPilih.txtTA.value\"");
		$FormPilih.="
				</div>
				<div class='col-sm-12 col-md-4'>
					<div class='btn-group pull-right'>
						<button class='btn btn-info dropdown-toggle' data-toggle='dropdown'>
							<i class='fa fa-list'></i> Menu<span class='caret'></span>
						</button>
						<ul class='dropdown-menu'>
							<li><a href='?page=$page&sub=bagikelasbaru'>Siswa Baru</a></li>
							<li><a href='?page=$page&sub=bagikelaslama'>Siswa Lama</a></li>
						</ul>
					</div>
				</div>
			</div>
		</form>";

		
		$Show.=KolomPanel($FormPilih);

		$QD="select ak_perkelas.*,siswa_biodata.nm_siswa,siswa_biodata.tahunmasuk from ak_perkelas,siswa_biodata where ak_perkelas.nis=siswa_biodata.nis and ak_perkelas.tahunajaran='$wh'";
		$JmlQD=mysql_num_rows(mysql_query($QD));

		$QKls=mysql_query("select * from ak_kelas where tahunajaran='$wh' order by kode_pk,nama_kelas");
		$noX=1;
		$noXI=1;
		$noXII=1;
		while($HQKls=mysql_fetch_array($QKls)){
			$JmlKelasX=mysql_num_rows(mysql_query("$QD and nm_kelas='$HQKls[nama_kelas]' and tk='X'"));
			$TotKelasX=mysql_num_rows(mysql_query("$QD and tk='X'"));
			if($JmlKelasX==0){$JmlSiswaX.="";}
			else{
				$JmlSiswaX.="
				<tr>
					<td class='text-center'>$noX.</td>
					<td class='text-center'><a href='?page=$page&thnajar=$thnajar&nmkelas={$HQKls['nama_kelas']}'>{$HQKls['nama_kelas']} </a></td>
					<td class='text-center'><strong>$JmlKelasX</strong></td>
				</tr>";
				$noX++;
			}

			$JmlKelasXI=mysql_num_rows(mysql_query("$QD and nm_kelas='$HQKls[nama_kelas]' and tk='XI'"));
			$TotKelasXI=mysql_num_rows(mysql_query("$QD and tk='XI'"));
			if($JmlKelasXI==0){$JmlSiswaXI.="";}
			else{
				$JmlSiswaXI.="
				<tr>
					<td class='text-center'>$noXI.</td>
					<td class='text-center'><a href='?page=$page&thnajar=$thnajar&nmkelas={$HQKls['nama_kelas']}'>{$HQKls['nama_kelas']} </a></td>
					<td class='text-center'><strong>$JmlKelasXI</strong></td>
				</tr>";
				$noXI++;
			}

			$JmlKelasXII=mysql_num_rows(mysql_query("$QD and nm_kelas='$HQKls[nama_kelas]' and tk='XII'"));
			$TotKelasXII=mysql_num_rows(mysql_query("$QD and tk='XII'"));
			if($JmlKelasXII==0){$JmlSiswaXII.="";}
			else{
				$JmlSiswaXII.="
				<tr>
					<td class='text-center'>$noXII.</td>
					<td class='text-center'><a href='?page=$page&thnajar=$thnajar&nmkelas={$HQKls['nama_kelas']}'>{$HQKls['nama_kelas']}</a></td>
					<td class='text-center'><strong>$JmlKelasXII</strong></td>
				</tr>";
				$noXII++;
			}
		}

		$nmkelas=isset($_GET['nmkelas'])?$_GET['nmkelas']:"";
		$nmtingkat=isset($_GET['nmtingkat'])?$_GET['nmtingkat']:"";

		if(isset($_GET['nmkelas'])){
			$PilKls="select ak_perkelas.*,siswa_biodata.nm_siswa,siswa_biodata.tahunmasuk from ak_perkelas,siswa_biodata where ak_perkelas.nis=siswa_biodata.nis and ak_perkelas.tahunajaran='$thnajar' and nm_kelas='$nmkelas' order by siswa_biodata.nm_siswa,ak_perkelas.nm_kelas,ak_perkelas.nis asc";
			$Petunjuk.=nt("peringatan","Silakan cek daftar siswa di bagian bawah daftar kelas");
			$tdowndata.="<a href=\"javascript:;\" onClick=\"window.open('./pages/excel/excel-siswa-userpass.php?thnajar=$thnajar&nmkelas=$nmkelas')\" class='btn btn-danger btn-xs'>Download Data Kelas $nmkelas</a> <br><br>";
		}
		else{$PilKls="";}

		if(isset($_GET['nmtingkat'])){
			$PilTingkat="select ak_perkelas.*,siswa_biodata.nm_siswa,siswa_biodata.tahunmasuk from ak_perkelas,siswa_biodata where ak_perkelas.nis=siswa_biodata.nis and ak_perkelas.tahunajaran='$thnajar' and tk='$nmtingkat' order by siswa_biodata.nm_siswa,ak_perkelas.kode_pk,ak_perkelas.nm_kelas,ak_perkelas.nis asc";
			$Petunjuk.=nt("peringatan","Silakan cek daftar siswa di bagian bawah daftar kelas");
			$tdowndata.="<a href=\"javascript:;\" onClick=\"window.open('./pages/excel/excel-siswa-pertingkat.php?thnajar=$thnajar&nmtingkat=$nmtingkat')\" class='btn btn-danger btn-xs'>Download Data Tingkat $nmtingkat</a> <br><br>";
		}
		else{$PilTingkat="";}


		$Show.=$Petunjuk;
		if($JmlQD==0){
			$InfoData="<p class='well text-center'> <strong>Data Perkelas Tahun Ajaran $thnajar <br>Masih Kosong </strong></p>";
		}
		else{
			$InfoData="<p class='well text-center'> <strong>Data Perkelas Tahun Ajaran $thnajar <br>$JmlQD siswa </strong></p>";
		}
		If($thnajar==""){
			$InfoData="<p class='well text-center'> <strong>Silakan !!!<br>Pilih Tahun Ajaran</strong></p>";
		} 

		$Show.=DuaKolomD(6,"<p class='well'>Menambah Peserta Didik Per Kelas bisa melalui menu pilihan di sudut kanan atas atau klik link <a href='?page=tools-excel-perkelas' >Impor Siswa Per Kelas</a> untuk impor Per Kelas ke MYSQL </p>",6,$InfoData);

		$Show.="
		<div class='row'>
			<div class='col-xs-12 col-sm-4 widget-container-col'>
				<div class='widget-box transparent'>
					<div class='widget-header'>
						<h5 class='widget-title red'><h1><i class='fa fa-fw fa-user bounceIn animated text-danger'></i><small class='text-danger slideInRight fast animated'><strong> Tingkat X</strong></small></h1><hr></h5>
						<div class='widget-toolbar'>Total : <strong>$TotKelasX</strong> orang</div>
					</div>
					<div class='well'>
						<div class='widget-main'>
							<table id='simple-table' class='table table-striped table-bordered table-hover'>
								<tr>
									<th class='text-center'>No</th>
									<th class='text-center'>Kelas</th>
									<th class='text-center'>Jumlah</th>
								</tr>
								$JmlSiswaX
								<tr>
									<td class='text-center' colspan='2'><a href='?page=$page&thnajar=$thnajar&nmtingkat=X'><strong>Total Tingkat X</strong></a></td>
									<td bgcolor='#cccccc' class='text-center'><strong>$TotKelasX</strong></td>
								</tr>
							</table>
						</div>
					</div>
				</div>
			</div>
			<div class='col-xs-12 col-sm-4 widget-container-col'>
				<div class='widget-box transparent'>
					<div class='widget-header'>
						<h5 class='widget-title red'><h1><i class='fa fa-fw fa-user bounceIn animated text-danger'></i><small class='text-danger slideInRight fast animated'><strong> Tingkat XI</strong></small></h1><hr></h5>
						<div class='widget-toolbar'>Total : <strong>$TotKelasXI</strong> orang</div>
					</div>
					<div class='well'>
						<div class='widget-main'>
							<table id='simple-table' class='table table-striped table-bordered table-hover'>
								<tr>
									<th class='text-center'>No</th>
									<th class='text-center'>Kelas</th>
									<th class='text-center'>Jumlah</th>
								</tr>
								$JmlSiswaXI
								<tr>
									<td class='text-center' colspan='2'><a href='?page=$page&thnajar=$thnajar&nmtingkat=XI'><strong>Total Tingkat XI</strong></a></td>
									<td bgcolor='#cccccc' class='text-center'><strong>$TotKelasXI</strong></td>
								</tr>
							</table>
						</div>
					</div>
				</div>
			</div>
			<div class='col-xs-12 col-sm-4 widget-container-col'>
				<div class='widget-box transparent'>
					<div class='widget-header'>
						<h5 class='widget-title red'><h1><i class='fa fa-fw fa-user bounceIn animated text-danger'></i><small class='text-danger slideInRight fast animated'><strong> Tingkat XII</strong></small></h1><hr></h5>
						<div class='widget-toolbar'>Total : <strong>$TotKelasXII</strong> orang</div>
					</div>
					<div class='well'>
						<div class='widget-main'>
							<table id='simple-table' class='table table-striped table-bordered table-hover'>
								<tr>
									<th>No</th>
									<th>Kelas</th>
									<th>Jumlah</th>
								</tr>
								$JmlSiswaXII
								<tr>
									<td class='text-center' colspan='2'><a href='?page=$page&thnajar=$thnajar&nmtingkat=XII'><strong>Total Tingkat XII</strong></a></td>
									<td bgcolor='#cccccc' class='text-center'><strong>$TotKelasXII</strong></td>
								</tr>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>";

		if(isset($_GET['nmkelas'])){$Q=mysql_query($PilKls);}else{$Q=mysql_query($PilTingkat);}
		$no=1;
		while($Hasil=mysql_fetch_array($Q)){
			$QCekDtSiswa=mysql_query("select * from siswa_biodata where nis='{$Hasil['nis']}'");
			$HCekDtSiswa=mysql_fetch_array($QCekDtSiswa);

			if($HCekDtSiswa['tempat_lahir']=="" && $HCekDtSiswa['tanggal_lahir']=="0000-00-00"){$HCek="<i class='fa fa-close text-danger fa-2x'></i>";}else{$HCek="<i class='fa fa-check'></i>";}

			$TampilData.="
			<tr>
				<td class='text-center'>$no.</td>
				<td>{$Hasil['tahunajaran']}</td>
				<td>{$Hasil['tk']}</td>
				<td><a href='?page=$page&amp;sub=pindahkelas&amp;thnajaran=$thnajar&amp;NIS={$Hasil['nis']}'>{$Hasil['nm_kelas']}</a></td>
				<td>{$Hasil['kode_pk']}</td>
				<td>{$Hasil['nis']}</td>
				<td>{$Hasil['nm_siswa']}</td>
				<td>{$Hasil['tahunmasuk']}</td>
				<td>$HCek</td>
				<td><label class='checkbox'><input type='checkbox' id='cekbox' name='cekbox[]' value='{$Hasil['kd_perkelas']}'><i></i></label></td>
			</tr>";
			$no++;
		}

		$jmldata=mysql_num_rows($Q);
		if($jmldata>0){

			$Show.=nt("informasi","Total Siswa $nmkelas : $jmldata orang<ul><li>Untuk merubah kelas atau pindah kelas, silakan klik nama kelas</li></ul>");
			//$Show.="<a href=\"javascript:;\" onClick=\"window.open('./pages/excel/excel-siswa-pertingkat.php?thnajar=$thnajar&nmtingkat=$nmtingkat')\" class='btn btn-danger btn-xs'>Download Data Tingkat $nmtingkat</a> <br><br>";
			$Show.=$tdowndata;
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

			<!-- <a href=\"javascript:;\" onClick=\"window.open('./pages/excel/excel-siswa-perkelas.php?thnajar=$thnajar&nmkelas=$nkls')\" class='btn btn-danger btn-xs'>Download Absensi</a> 			
			<a href=\"javascript:;\" onClick=\"window.open('./pages/excel/excel-siswa-biodata-perkelas.php?thnajar=$thnajar&nmkelas=$nkls')\" class='btn btn-danger btn-xs'>Download Biodata</a>  
			<br><br>-->
			<form action='?page=$page&sub=hapusbanyak' method='post' class='form-horizontal'>
			<div class='well no-padding'>
			<table id='dt_basic' class='table table-striped table-bordered table-hover' width='100%'>
				<thead>
					<tr>
						<th class='text-center' data-class='expand'>No.</th>
						<th class='text-center' data-hide='phone'>Tahun Ajaran</th>
						<th class='text-center' data-hide='phone'>Tingkat</th>
						<th class='text-center' data-hide='phone'>Kelas</th>
						<th class='text-center' data-hide='phone'>Kode PK</th>
						<th class='text-center' data-hide='phone'>NIS</th>
						<th class='text-center'>Nama Siswa</th>
						<th class='text-center' data-hide='phone'>Tahun Masuk</th>
						<th class='text-center' data-hide='phone'>Cek Profil</th>
						<th class='text-center' data-hide='phone'>Pilih</th>
					</tr>
				</thead>
				<tbody>$TampilData</tbody>
			</table>
			</div>
			".FormCB("Pilih Semua","checkbox","onclick='checkUncheckAll(this)'")."
			<div class='form-actions'><input type='submit' value='Hapus' name='submit' class='btn btn-sm btn-danger'></div>
			</form>";
		}
		else{
			
			$Show.="<code>Untuk menampilkan siswa perkelas, Silakan klik Kelas di Atas</code>";
		}

		$tandamodal="#DtPKelas";
		echo $DtPKelas;
		echo MyWidget('fa-users',"Daftar Siswa Per Kelas",array(ButtonKembali("?page=akademik-peserta-didik")),$Show);
	break;

	case "hapusbanyak":
		$cekbox = $_POST['cekbox'];
		if ($cekbox) {
			foreach ($cekbox as $value) {
				mysql_query("DELETE FROM ak_perkelas WHERE kd_perkelas='$value'");
				echo $value;
				echo ",";
			}
			echo ns("Hapus","parent.location='?page=$page'","Siswa perkelas");
		}  else {
			echo Peringatan("Anda belum memilih data","parent.location='?page=$page'");
		}
	break;
//=================================================================================================
// DISTRIBUSIKAN SISWA BARU KELAS BARU
//=================================================================================================
	case "bagikelasbaru":
		
		if(isset($_POST['btnNyari'])){
			$nmsiswa=addslashes($_POST['nmsiswa']);
			$ws=" and nm_siswa like '%$_POST[nmsiswa]%'";
		}

		$Q="SELECT nis, nm_siswa,tahunmasuk,kode_paket FROM siswa_biodata WHERE nis not in (SELECT nis FROM perkelas) $ws";
		$no=1;
		$Query=mysql_query("$Q order by nis asc");
		while($Hasil=mysql_fetch_array($Query)){
			$TampilData.="
			<tr>
				<td class='text-center'>$no.</td>
				<td>{$Hasil['nis']}</td>
				<td>{$Hasil['nm_siswa']}</td>
				<td>{$Hasil['tahunmasuk']}</td>
				<td>{$Hasil['kode_paket']}</td>
				<td><a href='?page=ak-siswa-perkelas&sub=simpankelas&nis={$Hasil['nis']}'><i class='ace-icon fa fa-random fa-2x'></i></a></td>
			</tr>";
			$no++;
		}
		$jmldata=mysql_num_rows($Query);
		if($jmldata>0){

			$Show.=nt("informasi","Pembagian kelas <strong>Bagi Siswa Baru</strong>, yang belum memiliki kelas sebelumnya");
			$Show.="
			<div class='well no-padding'>
			<table id='dt_basic' class='table table-striped table-bordered table-hover table-condensed' width='100%'>
				<thead>
					<tr>
						<th class='text-center' data-class='expand'>No.</th>
						<th class='text-center' data-hide='phone'>NIS</th>
						<th class='text-center'>Nama Siswa</th>
						<th class='text-center' data-hide='phone'>Tahun Masuk</th>
						<th class='text-center' data-hide='phone'>Paket Keahlian</th>
						<th class='text-center' data-hide='phone'>Kelas Baru</th>
					</tr>
				</thead>
				<tbody>$TampilData</tbody>
			</table>
			</div>";
		}
		else{
			$Show.=nt("informasi","Siswa Baru tidak ada");
		}

		echo $KelasBaruUntukSiswaBaru;
		echo MyWidget('fa-arrow-up',"Kelas Baru",array(ButtonKembali("?page=$page")),$Show);
	break;
//=================================================================================================
// SIMPAN KELAS BARU
//=================================================================================================
	case "simpankelas":

		$nis=isset($_GET['nis'])?$_GET['nis']:"";
		NgambilData("select nis,nm_siswa,kode_paket from siswa_biodata where nis=$nis");
		$QKls=mysql_query("select * from ak_kelas where tahunajaran='$TahunAjarAktif' and kode_pk='$kode_paket'");

		while($HQKls=mysql_fetch_array($QKls)){
			$DKelas.="<option value ='{$HQKls['nama_kelas']}'>{$HQKls['nama_kelas']}</option>";
		}
		$PilihKelas ="
		<div class='form-group'>
			<label class='control-label col-md-4'>Kelas</label>
			<div class='col-sm-4'>
				<select name='txtKelas' class='input-sm input-small form-control'>
					<option value=''>Pilih</option>
					$DKelas
				</select>
			</div>
		</div>";

		$Show.=GarisSimple();
		$IsiForm.='<fieldset>';
		$IsiForm.="<script src='".ASSETS_URL."/js/ak-siswa-perkelas.js'></script>";	
		$IsiForm.="<input type='hidden' name='txtThnAjaran' value='$TahunAjarAktif'>";
		$IsiForm.="<input type='hidden' name='txtTKKelas' value='X'>";
		$IsiForm.=FormIF("horizontal","NIS","txtNIS",$nis,'4','readonly=readonly');
		$IsiForm.=FormIF("horizontal","Nama Siswa","txNMSiswa",$nm_siswa,'6','readonly=readonly');
		$IsiForm.=FormIF("horizontal","Kode Paket","txKDPaket",$kode_paket,'3','readonly=readonly');
		$IsiForm.=FormCR("horizontal",'Tingkat','txtTKKelas',$nm_kelas,$Ref->TingkatKls,'4','onchange=LihatKelas(this.value)');
		$IsiForm.="<div id='txtHint'></div>";
		$IsiForm.='</fieldset>';
		$IsiForm.='<div class="form-actions">'.ButtonSimpan().'</div>';
		$Show.=FormAing($IsiForm,"?page=$page&sub=prosessimpankelas","formSimpan","");

		$Show.=$SimpanKelasBaru;
		echo IsiPanel($Show,"users","Masuk Kelas Peserta Didik baru","?page=$page","share","Kembali","#SimpanKelasBaru");
	break;
	
	case "prosessimpankelas":
		//$kd_perkelas=buatKode("perkelas","kls");
		$txtThnAjaran=addslashes($_POST['txtThnAjaran']);
		$txtTKKelas=addslashes($_POST['txtTKKelas']);
		$txtKelas=addslashes($_POST['txtKelas']);
		$txKDPaket=addslashes($_POST['txKDPaket']);
		$txtNIS=addslashes($_POST['txtNIS']);
		mysql_query("INSERT INTO perkelas VALUES ('','$txtThnAjaran','$txtTKKelas','$txtKelas','$txKDPaket','$txtNIS')");
		echo ns("Nambah","parent.location='?page=$page&sub=bagikelasbaru'","Kelas Baru");
	break;
//=================================================================================================
// DISTRIBUSIKAN SISWA LAMA NAIK KELAS
//=================================================================================================
	case "bagikelaslama":
		$thnajaran=(isset($_GET['thnajaran']))?$_GET['thnajaran']:"";
		$tingkat=isset($_GET['tingkat'])?$_GET['tingkat']:""; 
		$id_kls=isset($_GET['id_kls'])?$_GET['id_kls']:""; 

	//===========================================================================================================[FORM  NYARI DATA]

		if($thnajaran==""){$InfoPilih="pilih <strong><span class='text-danger'>Tahun Ajaran!</span></strong>";}
		else if($tingkat==""){$InfoPilih="pilih <strong><span class='text-danger'>Tingkat Kelas!</span></strong>";}
		else if($id_kls==""){$InfoPilih="pilih <strong><span class='text-danger'>Kelas</strong>!</span>";}

		$FormPilih.="
			<form action='?page=$page' method='post' name='frmPilih' class='form-inline' role='form'>
				<div class='row'>
					<div class='col-sm-12 col-md-12'>
						<div class='form-group'>Pililh Data &nbsp;&nbsp;</div>".
						FormCF("inline","Tahun Ajaran","txtTa","select * from ak_tahunajaran order by id_thnajar asc","tahunajaran",$PilTA,"tahunajaran","","onchange=\"document.location.href='?page=$page&sub=updatepilta&pilthaj='+document.frmPilih.txtTa.value\"").
						FormCF("inline","Paket Keahlian","txtPk","SELECT ak_kelas.id_kls,ak_kelas.tahunajaran,ak_paketkeahlian.kode_pk,ak_paketkeahlian.nama_paket,ak_paketkeahlian.singkatan FROM ak_kelas INNER JOIN ak_paketkeahlian ON ak_kelas.kode_pk=ak_paketkeahlian.kode_pk  WHERE ak_kelas.tahunajaran='$PilTA' GROUP BY ak_paketkeahlian.nama_paket ORDER BY ak_paketkeahlian.kode_pk","kode_pk",$PilPK,"nama_paket","","onchange=\"document.location.href='?page=$page&sub=updatepilPK&pk='+document.frmPilih.txtPk.value\"").
						FormCF("inline","Tingkat","txtTingkat","select * from ak_kelas where tahunajaran='$PilTA' and kode_pk='$PilPK' group by tingkat","tingkat",$PilTK,"tingkat","","onchange=\"document.location.href='?page=$page&sub=updatepiltingkat&piltingkat='+document.frmPilih.txtTingkat.value\"").
						FormCF("inline","Kelas","txtKelas","select * from ak_kelas where tahunajaran='$PilTA' and tingkat='$PilTK' and kode_pk='$PilPK' order by kode_kelas,tingkat,kode_pk desc","id_kls",$PilKls,"nama_kelas","","onchange=\"document.location.href='?page=$page&sub=updatepilkelas&pilkelas='+document.frmPilih.txtKelas.value\"")."
					</div>
				</div>
			</form>";
		$Show.=KolomPanel($FormPilih);

		if(!empty($PilTA) && !empty($PilTingkat) && !empty($PilKelas) ){
			$QKlsNa=mysql_query("select nama_kelas from ak_kelas where id_kls='".$PilKelas."'");
			$HKlsNa=mysql_fetch_array($QKlsNa);
			$wkls="
			SELECT siswa_biodata.nis,siswa_biodata.nm_siswa,ak_perkelas.kode_pk,ak_perkelas.nm_kelas,ak_perkelas.tahunajaran, ak_kelas.tingkat,ak_kelas.nama_singkat,ak_kelas.pararel 
			FROM siswa_biodata,ak_perkelas,ak_kelas 
			WHERE siswa_biodata.nis=ak_perkelas.nis and ak_perkelas.nm_kelas=ak_kelas.nama_kelas and ak_perkelas.tahunajaran!='$TAktif' and ak_perkelas.nm_kelas='{$HKlsNa['nama_kelas']}' and ak_perkelas.tahunajaran='".$PilTA."' and 
			kelas.tahunajaran='".$PilTA."'";
			$InfiCari="Kelas {$HKlsNa['nama_kelas']} pada tahun ajaran ".$PilTA;
		}

		$no=1;
		$Query=mysql_query("$wkls order by siswa_biodata.tahunmasuk,siswa_biodata.kode_paket,ak_perkelas.nm_kelas,siswa_biodata.nis,siswa_biodata.nm_siswa asc");
		while($Hasil=mysql_fetch_array($Query)){
			if($Hasil['tingkat']=='X'){$Tkna="XI";}else if($Hasil['tingkat']=='XI'){$Tkna="XII";}else{$Tkna="AL";}
			if($Tkn=="AL"){$KelasBaru="Alumni";}else{$KelasBaru="$Tkna $Hasil[nama_singkat] $Hasil[pararel]";}
			$DSis.="<div class='col-sm-6'>";
			$DSis.="<div class='col-xs-12'>";
			$DSis.="<div class='panel panel-default'>";
			$DSis.="<div class='panel-body'><div class='badge bg-color-red'>$no</div>";
			$DSis.="<input type='hidden' name='txtThnAjaran[$i]' value='$TAktif'>";
			$DSis.="<input type='hidden' name='txtTKKelas[$i]' value='$Tkna'>";
			$DSis.="<input type='hidden' name='txtSingkat[$i]' value='{$Hasil['nama_singkat']}'>";
			$DSis.="<input type='hidden' name='txtPararel[$i]' value='{$Hasil['pararel']}'>";
			$DSis.=FormIF("horizontal","NIS","txtNIS[$i]","{$Hasil['nis']}","3","readonly=readonly");
			$DSis.=FormIF("horizontal","Nama Siswa","txtNMSiswa[$i]","{$Hasil['nm_siswa']}",'8','readonly=readonly');
			$DSis.=FormIF("horizontal","Kode Paket","txKDPaket[$i]","{$Hasil['kode_pk']}",'2','readonly=readonly');
			$DSis.=FormIF("horizontal","<strong class='red'>Naik ke kelas</strong>","txtKelas[$i]","$KelasBaru",'3','readonly=readonly');
			$DSis.="</div>";
			$DSis.="</div>";
			$DSis.="</div>";
			$DSis.="</div>";
			$no++;
		}

		$jmldata=mysql_num_rows($Query);
		if($jmldata>0){
			$AdaKelas=mysql_num_rows(mysql_query("select * from ak_perkelas where tahunajaran='$TahunAjarAktif' and nm_kelas='$KelasBaru'"));
			if($AdaKelas>0){
				$Show.=nt("informasi","Kelas <strong>{$HKlsNa['nama_kelas']}</strong> sudah <strong>NAIK KELAS</strong> ke kelas <strong>$KelasBaru</strong> silakan pilih kelas lain.");
			}
			else{
				$Show.=nt("informasi",$InfiCari,"Data Terpilih");
				$Show.="<form action='?page=$page&amp;sub=naikkelas' method='post' name='frmadd' class='form-horizontal' role='form'>";
				$Show.="<div class='row'>$DSis</div>";
				$Show.='<div class="form-actions">'.ButtonSimpan().'</div>';
				$Show.="</form>";				
			}
		}
		else{
			$Show.=nt("informasi","Kelas belum terpilih. Silakan $InfoPilih.");
		}

		echo $NaikKelasSiswaLama;
		echo MyWidget('fa-arrow-up',"<strong>Naik Kelas</strong> <i>Peserta Didik Lama</i>",array(ButtonKembali("?page=$page")),$Show);
	break;

	case "naikkelas";		
		foreach($_POST['txtNIS'] as $i => $txtNIS){
			//$kd_perkelas=buatKode("perkelas","kls");
			$txtThnAjaran=addslashes($_POST['txtThnAjaran'][$i]);
			$txtTKKelas=addslashes($_POST['txtTKKelas'][$i]);
			$txtKelas=addslashes($_POST['txtKelas'][$i]);
			$txKDPaket=addslashes($_POST['txKDPaket'][$i]);
			$txtNIS=addslashes($_POST['txtNIS'][$i]);
			mysql_query("INSERT INTO ak_perkelas VALUES ('','$txtThnAjaran','$txtTKKelas','$txtKelas','$txKDPaket','$txtNIS')");
			echo '<div id="preloader"><div id="cssload"></div></div>';
			echo ns("Nambah","parent.location='?page=$page&sub=bagikelaslama'","Siswa Naik Kelas");
		}
	break;

	case "pindahkelas";
		$NIS=isset($_GET['NIS'])?$_GET['NIS']:"";
		$thnajaran=isset($_GET['thnajaran'])?$_GET['thnajaran']:"";
		$QPerKelas=mysql_query("select * from ak_perkelas where tahunajaran='".$thnajaran."' and nis='".$NIS."'");
		$HPerKelas=mysql_fetch_array($QPerKelas);
		NgambilData("select nis,nm_siswa,kode_paket from siswa_biodata where nis='".$NIS."'");
		$Show.=GarisSimple();
		$IsiForm.='<fieldset>';
		$IsiForm.="<script src='".ASSETS_URL."/js/ak-pindah-kelas.js'></script>";
		$IsiForm.="<input type='hidden' name='txtThnAjaran' value='$thnajaran'>";
		$IsiForm.=FormIF("horizontal","ID","txtID",$HPerKelas['kd_perkelas'],'4','readonly=readonly');
		$IsiForm.=FormIF("horizontal","NIS","txtNIS",$nis,'4','readonly=readonly');
		$IsiForm.=FormIF("horizontal","Nama Siswa","txNMSiswa",$nm_siswa,'6','readonly=readonly');
		$IsiForm.=FormCF("horizontal",'Paket Keahlian','txtKodePK','select * from paketkeahlian','kode_pk',$kode_pk,'nama_paket','4','onchange=LihatKelas(this.value)');
		$IsiForm.="<div id='txtHint'></div>";
		$IsiForm.=FormIF("horizontal","Tingkat","txTingkat",$HPerKelas['tk'],'2','readonly=readonly');
		$IsiForm.='</fieldset>';
		$IsiForm.='<div class="form-actions">'.ButtonSimpanName("SaveUpdate","Simpan").'</div>';
		$Show.=FormAing($IsiForm,"?page=$page&sub=simpanpindahkelas","formSimpan","");
		$Show.=$SiswaPindahKelas;
		echo IsiPanel($Show,"pencil-square-o","Pindah Kelas","?page=$page","share","Kembali","#SiswaPindahKelas");
	break;
	
	case "simpanpindahkelas":
		$txtID=addslashes($_POST['txtID']);
		$txtThnAjaran=addslashes($_POST['txtThnAjaran']);
		$txTingkat=addslashes($_POST['txTingkat']);
		$txtKelas=addslashes($_POST['txtKelas']);
		$txtKodePK=addslashes($_POST['txtKodePK']);
		$txtNIS=addslashes($_POST['txtNIS']);
		mysql_query("UPDATE perkelas SET tahunajaran='$txtThnAjaran', tk='$txTingkat', nm_kelas='$txtKelas', kode_pk='$txtKodePK', nis='$txtNIS' WHERE kd_perkelas='$txtID'");
		echo '<div id="preloader"><div id="cssload"></div></div>';
		echo ns("Ngedit","parent.location='?page=$page&sub=pindahkelas'","NIS <span class='txt-color-orangeDark'><strong>$txtNIS</strong></span> yang di pindah kelaskankan");
	break;

	case "updatepilta":
		$pilthaj=isset($_GET['pilthaj'])?$_GET['pilthaj']:"";
		$JmlData=JmlDt("select * from app_pilih_data where id_pil='$IDna'");
		if($JmlData==0){
			mysql_query("insert into app_pilih_data values ('$IDna','2','$pilthaj','4','5','6','7','8','9','10','11','12','13','14')");
		}else {
			mysql_query("update app_pilih_data set tahunajaran='$pilthaj' where id_pil='$IDna'");
		}
		echo "<meta http-equiv='refresh' content='0; url=?page=$page&sub=bagikelaslama'>";
	break;

	case "updatepilsmstr":
		$pilsmstr=isset($_GET['pilsmstr'])?$_GET['pilsmstr']:"";
		$JmlData=JmlDt("select * from app_pilih_data where id_pil='$IDna'");
		if($JmlData==0){
			mysql_query("insert into app_pilih_data values ('$IDna','2','3','$pilsmstr','5','6','7','8','9','10','11','12','13','14')");
		}else {
			mysql_query("update app_pilih_data set semester='$pilsmstr' where id_pil='$IDna'");
		}
		echo "<meta http-equiv='refresh' content='0; url=?page=$page&sub=bagikelaslama'>";
	break;

	case "updatepilPK":
		$pk=isset($_GET['pk'])?$_GET['pk']:"";
		$JmlData=JmlDt("select * from app_pilih_data where id_pil='$IDna'");
		if($JmlData==0){
			mysql_query("insert into app_pilih_data values ('$IDna','2','3','4','5','6','7','8','$pk','10','11','12','13','14')");
		}else {
			mysql_query("update app_pilih_data set id_pk='$pk' where id_pil='$IDna'");
		}
		echo "<meta http-equiv='refresh' content='0; url=?page=$page&sub=bagikelaslama'>";
	break;

	case "updatepiltingkat":
		$piltingkat=isset($_GET['piltingkat'])?$_GET['piltingkat']:"";
		$JmlData=JmlDt("select * from app_pilih_data where id_pil='$IDna'");
		if($JmlData==0){
			mysql_query("insert into app_pilih_data values ('$IDna','2','3','4','5','6','7','8','9','$piltingkat','11','12','13','14')");
		}else {
			mysql_query("update app_pilih_data set tingkat='$piltingkat' where id_pil='$IDna'");
		}		
		echo "<meta http-equiv='refresh' content='0; url=?page=$page&sub=bagikelaslama'>";
	break;

	case "updatepilkelas":
		$pilkelas=isset($_GET['pilkelas'])?$_GET['pilkelas']:"";
		$JmlData=JmlDt("select * from app_pilih_data where id_pil='$IDna'");
		if($JmlData==0){
			mysql_query("insert into app_pilih_data values ('$IDna','2','3','4','5','6','7','8','9','10','$pilkelas','12','13','14')");
		}else {
			mysql_query("update app_pilih_data set id_kelas='$pilkelas' where id_pil='$IDna'");
		}		
		echo "<meta http-equiv='refresh' content='0; url=?page=$page&sub=bagikelaslama'>";
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