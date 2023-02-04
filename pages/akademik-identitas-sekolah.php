<?php
require_once("inc/init.php");
require_once("inc/config.ui.php");
$page_title = "Identitas Sekolah";
$page_css[] = "your_style.css";
include("inc/header.php");
$page_nav["akademik"]["sub"]["identsekolah"]["active"] = true;
include("inc/nav.php");
echo "<div id='main' role='main'>";
$breadcrumbs["Akademik"] = "";
include("inc/ribbon.php");
	if($_GET['sub']==""){$bnt0="info";} else if($_GET['sub']=="profil"){$bnt0="info";}else{$bnt0="default";}
	if($_GET['sub']=="kepsek"){$bnt1="info";}else{$bnt1="default";}
	if($_GET['sub']=="tahunajar"){$bnt2="info";}else{$bnt2="default";}

	$Menu.=JudulKolom("Menu Pilihan","th");
	$Menu.="	
	<a href='?page=$page&sub=profil' class='btn btn-$bnt0 btn-sm btn-block'>Profil Sekolah</a> 
	<a href='?page=$page&sub=kepsek' class='btn btn-$bnt1 btn-sm btn-block'>Kepala Sekolah</a>
	<a href='?page=$page&sub=tahunajar' class='btn btn-$bnt2 btn-sm btn-block'>Tahun Ajaran</a>	
	";

$sub=(isset($_GET['sub']))?$_GET['sub']:"";
switch($sub)
{
	case "profil":default:

		NgambilData("select * from app_lembaga");

		$Infod.=FormInfoTabel("Status",$status,"");
		$Infod.=FormInfoTabel("Nama Sekolah",$nm_sekolah,"");
		$Infod.=FormInfoTabel("NPSN",$nisn,"");
		$Infod.=FormInfoTabel("NSS",$nss,"");
		$Infod.=FormInfoTabel("Alamat",$alamat,"");
		$Infod.=FormInfoTabel("Kode Pos",$kd_pos,"");
		$Infod.=FormInfoTabel("Telepon",$telepon,"");
		$Infod.=FormInfoTabel("Kelurahan",$kelurahan,"");
		$Infod.=FormInfoTabel("Kecamatan",$kecamatan,"");
		$Infod.=FormInfoTabel("Kabupaten",$kab_kota,"");
		$Infod.=FormInfoTabel("Propinsi",$propinsi,"");
		$Infod.=FormInfoTabel("Website",$website,"");
		$Infod.=FormInfoTabel("Email",$email,"");

		$ProfilSekolah.='<button rel="tooltip" data-placement="left" data-original-title="Edit Data Sekolah" class="btn btn-sm btn-default pull-right" style="margin-top:-10px;" data-toggle="modal" data-target="#EditSakola"><i class="fa fa-pencil"></i> <span class="hidden-xs hidden-mobile">Edit Data</span></button>';
		$ProfilSekolah.=JudulKolom('Identitas Sekolah',"university");
		$ProfilSekolah.='<table>'.$Infod.'</table>';

		//editsakola
		NgambilData("select * from app_lembaga where kd_sekolah='sch01'");
		$NgeditSakola1.=FormCR("smart","Status Sekolah", "txtStatus",$status,$Ref->StatusSekolah,"","");
		$NgeditSakola1.=FormIF("smart","Nama Sekolah", "txtNamaSekolah",$nm_sekolah,"","");
		$NgeditSakola1.=FormIF("smart","NPSN", "txtNISN",$nisn,"","");
		$NgeditSakola1.=FormIF("smart","NSS", "txtNSS",$nss,"","");
		$NgeditSakola3.=FormIF("smart","Nama Kepala Sekolah", "txtNamaKepsek",$nm_kepsek,"","");
		$NgeditSakola3.=FormIF("smart","NIP Kepala Sekolah", "txtNIPKepsek",$nip_kepsek,"","");
		$NgeditSakola2.=FormIF("smart","Alamat", "txtAlamat",$alamat,"","");
		$NgeditSakola2.=FormIF("smart","Kode Pos", "txtKodePos",$kd_pos,"","");
		$NgeditSakola2.=FormIF("smart","Telepon", "txtTelepon",$telepon,"","");
		$NgeditSakola2.=FormIF("smart","Kelurahan", "txtKelurahan",$kelurahan,"","");
		$NgeditSakola2.=FormIF("smart","Kecamatan", "txtKecamatan",$kecamatan,"","");
		$NgeditSakola4.=FormIF("smart","Kabupaten", "txtKabupaten",$kab_kota,"","");
		$NgeditSakola4.=FormIF("smart","Propinsi", "txtPropinsi",$propinsi,"","");
		$NgeditSakola4.=FormIF("smart","Website", "txtWebsite",$website,"","");
		$NgeditSakola4.=FormIF("smart","Email", "txtEmail",$email,"","");

		$TampilKolom.="<div class='row'>";
		$TampilKolom.="<div class='col col-6 padding-10'>";
		$TampilKolom.=Label("Profil Sekolah");
		$TampilKolom.=$NgeditSakola1;
		$TampilKolom.="</div>";
		$TampilKolom.="<div class='col col-6 padding-10'>";
		$TampilKolom.=Label("Profil Kepala Sekolah");
		$TampilKolom.=$NgeditSakola3;
		$TampilKolom.="</div>";
		$TampilKolom.="</div>";
		$TampilKolom.="<div class='row'>";
		$TampilKolom.="<div class='col col-12 col-md-12 padding-10'>";
		$TampilKolom.=Label("Alamat Sekolah");
		$TampilKolom.="</div>";
		$TampilKolom.="<div class='col col-6 padding-10'>";
		$TampilKolom.=$NgeditSakola2;
		$TampilKolom.="</div>";
		$TampilKolom.="<div class='col col-6 padding-10'>";
		$TampilKolom.=$NgeditSakola4;
		$TampilKolom.="</div>";
		$TampilKolom.="</div>";

		echo FormModalAksi(
		"EditSakola",
		"Edit Profil Sekolah",
		"<form method='post' action='?page=$page&sub=simpanedit' class='smart-form'>$TampilKolom",
		"ngeditsakola",
		"Simpan");

		$LogoSekolah.='<button type="button" id="uploadphoto" rel="tooltip" data-placement="left" data-original-title="Uploag Logo Sekolah" style="margin-top:-10px;" class="btn btn-default btn-sm pull-right" data-toggle="modal" data-target="#UploadPhoto"><i class="fa fa-camera"></i> <span class="hidden-mobile hidden-xs">Edit Logo</span></button>';
		$LogoSekolah.=JudulKolom('Logo Sekolah',"camera");
		$LogoSekolah.='<center><img src="img/'.$Gambar3.'" alt="" style="max-width:200px; width:100%;"></center>';
		
		//Upload Photo
		echo FormModalAksi(
		"UploadPhoto",
		"Upload Logo Sekolah",
		"<form enctype='multipart/form-data' method='post' action='?page=$page&sub=ngapload_photo' class='smart-form'>
		<input type='hidden' name='NamaFile' value='logo'>
		<section>
			<label class='label'>File input</label>
			<div class='input input-file'>
				<span class='button'><input type='file' id='file' name='uploaded_file' onchange='this.parentNode.nextSibling.value = this.value'>Browse</span><input type='text' placeholder='Pilih file photo' readonly=''>
			</div>
		</section>
		<span class='txt-color-red'>* Gunakan format gambar .JPG</span>",
		"ngapluadphoto",
		"Upload");

		$Show.=DuaKolomD("2",KolomPanel($Menu),"10",DuaKolom(KolomPanel($ProfilSekolah),KolomPanel($LogoSekolah)));

		echo $CukupJelas;
		$tandamodal="#CukupJelas";
		echo MyWidget('fa-university',"Profil Sekolah","",$Show);
	break;

	case "kepsek":
		$QKepsek=mysql_query("select * from ak_kepsek order by id_kepsek");	
		$i=1;
		while($HKepsek=mysql_fetch_array($QKepsek)){
			if($HKepsek['thnajaran']==$TahunAjarAktif && $HKepsek['smstr']==$SemesterAktif){
				$akepsek="<center><i class='fa fa-check-square-o fa-2x text-danger'></i></center>";
			}
			else{
				$akepsek="<center><i class='fa fa-times-rectangle-o fa-2x'></i></center>";
			}
			
			$DKepsek.="
			<tr>
				<td>$i.</td>
				<td>{$HKepsek['thnajaran']}</td>
				<td>{$HKepsek['smstr']}</td>
				<td><a data-toggle='modal' href='#EditKepsek' id='{$HKepsek['id_kepsek']}' class='tmpleditkepsek'>{$HKepsek['nama']}</a></td>
				<td>{$HKepsek['nip']}</td>												
				<td>$akepsek</td>
			</tr>";
			$i++;
		}

		$Kepsek.='<button type="button" id="tambahkepsek" rel="tooltip" data-placement="left" data-original-title="Tambah Kepsek" style="margin-top:-10px;" class="btn btn-default btn-sm pull-right" data-toggle="modal" data-target="#TambahKepsek"><i class="fa fa-plus"></i> <span class="hidden-mobile hidden-xs">Tambah</span></button>';
		$Kepsek.=JudulKolom("Daftar Kepala Sekolah","");
		$Kepsek.="
		<div class='well no-padding' style='margin:-15px -15px -15px -15px;'>
			<table id='dt_basic' class='table table-striped table-bordered table-condensed' width='100%'>					
				<thead>
					<tr>
						<th class='text-center' data-class='expand'>No.</th>
						<th class='text-center' data-hide='phone,tablet'>Thn Ajaran</th>
						<th class='text-center' data-hide='phone,tablet'>Semester</th>
						<th class='text-center'>Nama Lengkap</th>
						<th class='text-center'>NIP</th>
						<th class='text-center' data-hide='phone,tablet'>Aktif</th>
					</tr>
				</thead>
				<tbody>".$DKepsek."</tbody>
			</table>
		</div>";


		//Tambah Kepsek
		$TmbhKepsek.=FormIF("horizontal","Nama Kepala Sekolah", "txtNamaKepsek",$nama,"6","");
		$TmbhKepsek.=FormIF("horizontal","NIP", "txtNIP",$nip,"6","");
		$TmbhKepsek.=FormCF("horizontal",'Tahun Ajaran','txtThnAjar','select * from ak_tahunajaran order by id_thnajar asc','tahunajaran',$thnajaran,'tahunajaran',"4","");
		$TmbhKepsek.=FormCF("horizontal",'Semester','txtSmstr','select * from ak_semester','ganjilgenap',$smstr,'ganjilgenap',"4","");
		
		// Modal Tambah Kepsek
		echo FormModalAksi(
		"TambahKepsek",
		"Tambah Data Kepala Sekolah",
		"<form method='post' action='?page=$page&sub=simpantambahkepsek' class='form-horizontal'>$TmbhKepsek",
		"nambahkepsek",
		"Simpan");

		// Modal Edit Kepsek
		echo FormModalEdit(
		"sedang",
		"EditKepsek", 
		"Edit Kepala Sekolah",
		"?page=$page&sub=simpaneditkepsek",
		"form-horizontal",
		"bodykepsek",
		"ngeditkepsek",
		"Simpan");

		$Show.=DuaKolomD("2",KolomPanel($Menu),"10",KolomPanel($Kepsek));

		echo $CukupJelas;
		$tandamodal="#CukupJelas";
		echo MyWidget('fa-user-o',"Kepala Sekolah",$Tombolna,$Show);
	break;

	case "tahunajar":
		// Simpan Pilih Tahun Ajaran
		if(isset($_GET['aktifkan'])) {
			$sqlSave=mysql_query("UPDATE ak_tahunajaran SET aktif='N' WHERE aktif='Y'");
			$Ngaktifkeun=isset($_GET['aktifkan'])?$_GET['aktifkan']:""; 
			$sqlSave="UPDATE ak_tahunajaran SET aktif='Y' WHERE id_thnajar='$Ngaktifkeun'";
			$qrySave=mysql_query($sqlSave);
			if($qrySave){
				echo ns("Milih","parent.location='?page=$page&sub=tahunajar'","<strong>tahun ajaran</strong>");
			}
		}
		// Simpan Pilih Semester
		if(isset($_GET['aktifsemester'])) {
			$sqlSave=mysql_query("UPDATE ak_semester SET aktif='N' WHERE aktif='Y'");
			$NgaktifkeunS=isset($_GET['aktifsemester'])?$_GET['aktifsemester']:""; 
			$sqlSave="UPDATE ak_semester SET aktif='Y' WHERE id_smstr='$NgaktifkeunS'";
			$qrySave=mysql_query($sqlSave);
			if($qrySave){
				echo ns("Milih","parent.location='?page=$page&sub=tahunajar'","<strong>semester</strong>");
			}
		}
		//Tampilkan Semester dan tanda terpilih
		$QS=mysql_query("SELECT * FROM ak_semester");
		while($HS=mysql_fetch_array($QS)){
			if($HS['aktif']=="Y"){
				$tandanaS="<i class='fa fa-check-square-o fa-2x text-danger'></i>";
			}
			else{
				$tandanaS="
				<a href='?page=$page&sub=tahunajar&aktifsemester={$HS['id_smstr']}' alt='Aktifkan'>
					<span class='green'><i class='fa fa-square-o fa-2x'></i></span>
				</a>";
			}
			$TampilS.="<td class='text-center'>$tandanaS</td>";
		}
		//Tampilkan Tahun Ajaran dan tanda terpilih
		$Q=mysql_query("SELECT * FROM ak_tahunajaran order by id_thnajar asc");
		$no=1;
		while($Hasil=mysql_fetch_array($Q)){
			if($Hasil['aktif']=="Y") {
				$tandana="<i class='fa fa-check-square-o fa-2x text-danger'></i>";
				$tandaSmstr=$TampilS;
			}
			else{
				$tandana="
				<a href='?page=$page&sub=tahunajar&aktifkan={$Hasil['id_thnajar']}' alt='Aktifkan'>
				<span class='green'><i class='fa fa-square-o fa-2x'></i></span>
				</a>";
				$tandaSmstr="<td class='text-center'></td><td class='text-center'></td>";
			}
			$TampilData.="
			<tr>
				<td class='hidden-480 text-center'>$no.</td>
				<td class='text-center'>{$Hasil['tahunajaran']}</td>
				<td class='text-center'>$tandana</td>
				$tandaSmstr
			</tr>";
			$no++;
		}
		// Tampilkan tabel Tahun ajaran dan Semester
		$PilihTA.="
		<table class='table no-padding'>
			<tr>
				<th class='text-center'>No.</th>
				<th class='text-center'>Tahun Ajaran</th>
				<th class='text-center'>Aktif</th>
				<th class='text-center'>Ganjil</th>
				<th class='text-center'>Genap</th>
			</tr>
			$TampilData
		</table>";
		//Proses Simpan Tahun Ajaran
		if(isset($_POST['btnSave'])){
			$message=array();
			if(trim($_POST['txtThanAjar'])==""){$message[]="Tahun Ajaran tidak boleh kosong !";}
			if(trim($_POST['txtAktifTA'])==""){$message[]="Keaktifan tidak boleh kosong !";}
			if(!count($message)==0){
				$Num=0;
				foreach($message as $indeks=>$pesan_tampil){
					$Num++;
					$Pesannya.="$Num. $pesan_tampil<br>";
				}
				echo Peringatan("$Pesannya","parent.location='?page=$page&sub=tahunajar'");
			}
			else{
				$txtThanAjar=addslashes($_POST['txtThanAjar']);
				$txtAktifTA=addslashes($_POST['txtAktifTA']);	
				$sqlSave="INSERT INTO ak_tahunajaran VALUES ('','$txtThanAjar','$txtAktifTA')";
				$qrySave=mysql_query($sqlSave);
				if($qrySave){
					echo ns("Nambah","parent.location='?page=$page&sub=tahunajar&'","<span class='text-primary'><strong>Tahun Ajaran</strong></span>");
				}
			}
		}
		// Form Tambah Tahun Ajaran dan Semester
		$IsiForm.=$PesanError;
		$IsiForm.='<fieldset>';
		$IsiForm.=FormIF("horizontal","Tahun Ajaran","txtThanAjar","",'4',"");
		$IsiForm.=FormCR("horizontal",'Aktif','txtAktifTA',$aktif,$Ref->YesOrNo,'4',"");
		$IsiForm.='</fieldset>';
		$IsiForm.='<div class="form-actions">';
		$IsiForm.='<button type="submit button" class="btn btn-sm btn-info" name="btnSave">Simpan</button>';
		$IsiForm.='</div>';
		$TambahTA.=FormAing($IsiForm,"?page=$page&sub=tahunajar","FrmTambahTA","");
		
		$TahunAjarTampil.=DuaKolomSama(JudulKolom("Pilih Tahun Ajaran dan Semester","calendar").$PilihTA,JudulKolom("Tambah Tahun Ajaran","plus").$TambahTA);

		$Show.=DuaKolomD("2",KolomPanel($Menu),"10",$TahunAjarTampil);
		
		echo $DataTA;
		$tandamodal="#DataTA";
		echo MyWidget('fa-calendar'," Tahun Ajaran ".$TahunAjarAktif." Semester ".$SemesterAktif,"",$Show);
	break;

	case "ngapload_photo":
		if(isset($_POST['ngapluadphoto'])){
			// Access the $_FILES global variable for this specific file being uploaded
			// and create local PHP variables from the $_FILES array of information
			$fileName = $_FILES["uploaded_file"]["name"]; // The file name
			$fileTmpLoc = $_FILES["uploaded_file"]["tmp_name"]; // File in the PHP tmp folder
			$fileType = $_FILES["uploaded_file"]["type"]; // The type of file it is
			$fileSize = $_FILES["uploaded_file"]["size"]; // File size in bytes
			$fileErrorMsg = $_FILES["uploaded_file"]["error"]; // 0 for false... and 1 for true
			$kaboom = explode(".", $fileName); // Split file name into an array using the dot
			$fileExt = end($kaboom); // Now target the last array element to get the file extension
			//$fileName = $fileName.".".$fileExt;
			// START PHP Image Upload Error Handling --------------------------------------------------
			if (!$fileTmpLoc) { // if file not chosen
				echo ns("Salah","parent.location='?page=$page'","ERROR: Please browse for a file before clicking the upload button.");
				exit();
			} else if($fileSize > 5242880) { // if file size is larger than 5 Megabytes
				echo ns("Salah","parent.location='?page=$page'","ERROR: Your file was larger than 5 Megabytes in size.");
				unlink($fileTmpLoc); // Remove the uploaded file from the PHP temp folder
				exit();
			} else if (!preg_match("/.(jpg)$/i", $fileName) ) {
				 // This condition is only if you wish to allow uploading of specific file types    
				 echo ns("Salah","parent.location='?page=$page'","ERROR: Your image was not .jpg.");
				 unlink($fileTmpLoc); // Remove the uploaded file from the PHP temp folder
				 exit();
			} else if ($fileErrorMsg == 1) { // if file upload error key is equal to 1
				echo ns("Salah","parent.location='?page=$page'","ERROR: An error occured while processing the file. Try again.");
				exit();
			}
			// END PHP Image Upload Error Handling ---------------------------------
			// Place it into your "uploads" folder mow using the move_uploaded_file() function
			$moveResult = move_uploaded_file($fileTmpLoc, "img/favicon/$fileName");
			// Check to make sure the move result is true before continuing
			if ($moveResult != true) {
				echo ns("Salah","parent.location='?page=$page'","ERROR: File not uploaded. Try again.");
				unlink($fileTmpLoc); // Remove the uploaded file from the PHP temp folder
				exit();
			}
			unlink($fileTmpLoc); // Remove the uploaded file from the PHP temp folder
			// ---------- Include Adams Universal Image Resizing Function --------
			include_once("lib/fungsi.inc.php");
			$target_file = "img/favicon/$fileName";
			$resized_file = "img/favicon/resized_$fileName";
			$wmax = 200;
			$hmax = 200;
			ak_img_resize($target_file, $resized_file, $wmax, $hmax, $fileExt);
			// ----------- End Adams Universal Image Resizing Function ----------
			// ------ Start Adams Universal Image Thumbnail(Crop) Function ------
			/*
			$target_file = "img/photo/resized_$fileName";
			$thumbnail = "img/photo/thumba_$fileName";
			$wthumb = 50;
			$hthumb = 50;
			ak_img_thumb($target_file, $thumbnail, $wthumb, $hthumb, $fileExt);
			*/
			$target_file = "img/favicon/resized_$fileName";
			$resized_file = "img/favicon/thumb_$fileName";
			$wmax = 50;
			$hmax = 50;
			ak_img_resize($target_file, $resized_file, $wmax, $hmax, $fileExt);
			// ------- End Adams Universal Image Thumbnail(Crop) Function -------	
			$sqlSave="UPDATE app_lembaga SET logo_sekolah='$fileName' WHERE kd_sekolah='sch01'";
			$qrySave=mysql_query($sqlSave);
			echo ns("Ngapload","parent.location='?page=$page'","Photo");
		}
	break;

	case "simpanedit":
		$txtKodes=addslashes($_POST['txtKodes']);
		$txtStatus=addslashes($_POST['txtStatus']);
		$txtNamaSekolah=addslashes($_POST['txtNamaSekolah']);
		$txtNISN=addslashes($_POST['txtNISN']);
		$txtNSS=addslashes($_POST['txtNSS']);
		$txtAlamat=addslashes($_POST['txtAlamat']);
		$txtKodePos=addslashes($_POST['txtKodePos']);
		$txtTelepon=addslashes($_POST['txtTelepon']);
		$txtKelurahan=addslashes($_POST['txtKelurahan']);
		$txtKecamatan=addslashes($_POST['txtKecamatan']);
		$txtKabupaten=addslashes($_POST['txtKabupaten']);
		$txtPropinsi=addslashes($_POST['txtPropinsi']);
		$txtWebsite=addslashes($_POST['txtWebsite']);
		$txtEmail=addslashes($_POST['txtEmail']);
		$txtNamaKepsek=addslashes($_POST['txtNamaKepsek']);
		$txtNIPKepsek=addslashes($_POST['txtNIPKepsek']);
		$email=$_POST['txtEmail'];	
		if (preg_match("/^[^@]+@[a-zA-Z0-9._-]+\.[a-zA-Z]+$/",$email)) $a="";
		else  die ("<body onload=\"alert('Email yang dimasukan tidak valid');window.history.back()\">");
		$sqlSave="UPDATE profil SET status='$txtStatus',nm_sekolah='$txtNamaSekolah',nisn='$txtNISN',nss='$txtNSS',alamat='$txtAlamat', kd_pos='$txtKodePos',telepon='$txtTelepon',kelurahan='$txtKelurahan', kecamatan='$txtKecamatan',kab_kota='$txtKabupaten',propinsi='$txtPropinsi',website='$txtWebsite',email='$txtEmail', nm_kepsek= '$txtNamaKepsek', nip_kepsek='$txtNIPKepsek' WHERE kd_sekolah='sch01'";
		$qrySave=mysql_query($sqlSave);
		if($qrySave){
			echo ns("Ngedit","parent.location='?page=$page'","Data Sekolah");
		}
	break;

	case "simpaneditkepsek":
		$txtIDKepsek=addslashes($_POST['txtIDKepsek']);
		$txtNamaKepsek=addslashes($_POST['txtNamaKepsek']);
		$txtNIP=addslashes($_POST['txtNIP']);
		$txtThnAjar=addslashes($_POST['txtThnAjar']);
		$txtSmstr=addslashes($_POST['txtSmstr']);
		$txtTAAwal=substr($txtThnAjar,0,4);
		$txtTAAkhir=substr($txtThnAjar,5);
		mysql_query("UPDATE kepsek SET nama='$txtNamaKepsek',nip='$txtNIP',thnajaran='$txtThnAjar',taawal='$txtTAAwal',taakhir='$txtTAAkhir',smstr='$txtSmstr' WHERE id_kepsek='$txtIDKepsek'");
		echo ns("Ngedit","parent.location='?page=$page'","Kepala Sekolah");
	break;

	case "simpantambahkepsek":
		$message=array();
		if(trim($_POST['txtNamaKepsek'])==""){$message[]="Nama Kepala Sekolah belum di isi!";}
		if(trim($_POST['txtNIP'])==""){$message[]="NIP Kepala Sekolah belum di isi!";}
		if(trim($_POST['txtThnAjar'])==""){$message[]="Tahun Ajaran belum di pilih!";}
		if(trim($_POST['txtSmstr'])==""){$message[]="Semester belum di pilih!";}

		if(!count($message)==0){
			$Num=0;
			foreach($message as $indeks=>$pesan_tampil){
				$Num++;
				$Pesannya.="$Num. $pesan_tampil<br>";
			} 
			echo Peringatan("$Pesannya","parent.location='?page=$page'");
		}
		else{
			$txtNamaKepsek=addslashes($_POST['txtNamaKepsek']);
			$txtNIP=addslashes($_POST['txtNIP']);
			$txtThnAjar=addslashes($_POST['txtThnAjar']);
			$txtSmstr=addslashes($_POST['txtSmstr']);
			$TAAwal=substr($txtThnAjar,0,4);
			$TAAkhir=substr($txtThnAjar,5);
			mysql_query("INSERT INTO ak_kepsek VALUES ('','$txtNamaKepsek','$txtNIP','$txtThnAjar','$TAAwal','$TAAkhir','$txtSmstr')");
			echo ns("Nambah","parent.location='?page=$page'","Kepala Sekolah");
		}
	break;
}
echo "</div>";
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
	// Modal Edit Kepsek
	$('.tmpleditkepsek').click(function(){
		var id = $(this).attr("id");
		$.ajax({
			url: 'lib/app_modal.php?md=EditKasek',
			method: 'post',
			data: {id:id},
			success:function(data){
				$('#bodykepsek').html(data);
				$('#EditKepsek').modal("show");
			}
		});
	});
	
	// Tabel
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

	$('#datatable_tabletools').dataTable({
		
		// Tabletools options: 
		//   https://datatables.net/extensions/tabletools/button_options
		"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-6 hidden-xs'T>r>"+
				"t"+
				"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>",
        "oTableTools": {
        	 "aButtons": [
             "copy",
             "csv",
             "xls",
                {
                    "sExtends": "pdf",
                    "sTitle": "SmartAdmin_PDF",
                    "sPdfMessage": "SmartAdmin PDF Export",
                    "sPdfSize": "letter"
                },
             	{
                	"sExtends": "print",
                	"sMessage": "Generated by SmartAdmin <i>(press Esc to close)</i>"
            	}
             ],
            "sSwfPath": "js/plugin/datatables/swf/copy_csv_xls_pdf.swf"
        },
		"autoWidth" : true,
		"preDrawCallback" : function() {
			// Initialize the responsive datatables helper once.
			if (!responsiveHelper_datatable_tabletools) {
				responsiveHelper_datatable_tabletools = new ResponsiveDatatablesHelper($('#datatable_tabletools'), breakpointDefinition);
			}
		},
		"rowCallback" : function(nRow) {
			responsiveHelper_datatable_tabletools.createExpandIcon(nRow);
		},
		"drawCallback" : function(oSettings) {
			responsiveHelper_datatable_tabletools.respond();
		}
	});

})
</script>