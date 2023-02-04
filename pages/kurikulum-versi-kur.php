<?php
require_once("inc/init.php");
require_once("inc/config.ui.php");
$page_title = "Versi Kurikulum";
$page_css[] = "your_style.css";
include("inc/header.php");
$page_nav["kurikulum"]["sub"]["versikurikulum"]["active"] = true;
include("inc/nav.php");
echo "<div id='main' role='main'>";
$breadcrumbs["Kurikulum"] = "";
include("inc/ribbon.php");	
$sub=(isset($_GET['sub']))?$_GET['sub']:"";
switch($sub)
{
	case "tampil":default:
		$QVK=mysql_query("select * from kur_versikurikulum");
		$no=1;
		while($isi=mysql_fetch_array($QVK)){
			$TmpVK.="
			<tr>
				<td class='text-center'>$no.</td>
				<td>".$isi["tahunversi"]."</a></td>
				<td>".$isi["permen"]."</td>
				<td class='text-center'>
					<a href='?page=$page&dvk={$isi['id']}'><i class='txt-color-blue fa fa-pencil-square-o font-lg'></i></a>
				</td>
				<td class='text-center'>
					<a href='?page=$page&amp;sub=hapus&amp;dvk={$isi['id']}' data-action='hapusvk' data-hapusvk-msg=\"Apakah Anda yakin akan mengapus <strong class='text-primary'> Versi Kurikulum Tahun {$isi['tahunversi']}</strong> ?\"><i class='txt-color-red fa fa-trash-o font-lg'></i></a>
				</td>
			</tr>";
			$no++;
		}
		$JmlVK=mysql_num_rows($QVK);
		if($JmlVK==0)
		{  
			$DataVer.=nt("informasi","Data Versi Kurikulum belum di tambahkan");
		}
		else{
			$DataVer.=JudulKolom("List Versi Kurikulum","th-list");
			$DataVer.="
			<div class='well no-padding' style='margin:-15px -15px -15px -15px;'>
				<table class='table'>
					<tr bgcolor='#f5f5f5'>
						<td class='text-center'>No.</td>
						<td class='text-center'>Tahun Versi</td>
						<td class='text-center'>Peraturan</td>
						<td class='text-center' colspan=2>Aksi</td>
					</tr>
				$TmpVK
				</table>
			</div>";
		}
		
		$TambahVK.=JudulKolom("Tambah","plus");
		$TambahVK.="<form action='?page=$page&sub=simpantambah' method='post' name='frmAdAdmin' class='form-horizontal' role='form'>";
		$TambahVK.='<fieldset>';
		$TambahVK.=FormIF("horizontal","Tahun Versi", "txtThnVersi",$thnVersi,'4','');
		$TambahVK.=FormIF("horizontal","Peraturan", "txtPeraturan",$peraturan,'6','');
		$TambahVK.='</fieldset>';
		$TambahVK.='<div class="form-actions">';
		$TambahVK.=iSubmit("SaveDtVK","Simpan");
		$TambahVK.='</div>';
		$TambahVK.="</form>";

		$dvkna=isset($_GET['dvk'])?$_GET['dvk']:"";
		NgambilData("select * from kur_versikurikulum where id='$dvkna'");
		$EditVK.=JudulKolom("Edit","edit");
		$EditVK.="<form action='?page=$page&sub=simpanedit' method='post' name='frmadd' class='form-horizontal' role='form'>";
		$EditVK.='<fieldset>';
		$EditVK.=FormIF("horizontal","ID", "txtID",$id,'4','readonly=readonly');
		$EditVK.=FormIF("horizontal","Tahun Versi", "txtThnVersi",$tahunversi,'2','');
		$EditVK.=FormIF("horizontal","Peraturan", "txtPeraturan",$permen,'8','');
		$EditVK.='</fieldset>';
		$EditVK.='<div class="form-actions">';
		$EditVK.=iSubmit("EditDtVK","Simpan")." <a href='?page=$page' class='btn btn-danger btn-sm'>Batal</a>";
		$EditVK.='</div>';
		$EditVK.="</form>";
		
		if($dvkna==""){$ined=$TambahVK;}else{$ined=$EditVK;}
		$Tampilkan.=DuaKolomSama($DataVer,$ined);
		
		echo $KetVersiKurikulum;
		$tandamodal="#KetVersiKurikulum";
		echo MyWidget('fa-folder-open',$page_title,$Tombolna,$Tampilkan);		
	break;
	case "simpantambah":
		$message=array();
		if(trim($_POST['txtThnVersi'])==""){$message[]="Tahun Versi tidak boleh kosong !";}
		if(trim($_POST['txtPeraturan'])==""){$message[]="Peraturan tidak boleh kosong !";}
		if(!count($message)==0){
			$Num=0;
			foreach($message as $indeks=>$pesan_tampil){
				$Num++;
				$Pesannya.="$Num. $pesan_tampil<br>";
			} 
			echo Peringatan("$Pesannya","parent.location='?page=$page'");
		}
		else{
			$kd_ver=buatKode("ku_versikurikulum","verku_");
			$txtThnVersi=addslashes($_POST['txtThnVersi']);
			$txtPeraturan=addslashes($_POST['txtPeraturan']);
			$sqlSave="INSERT INTO kur_versikurikulum VALUES('$kd_ver','$txtThnVersi','$txtPeraturan')";
			$qrySave=mysql_query($sqlSave);
			if($qrySave){
				echo ns("Nambah","parent.location='?page=$page'","Versi Kurikulum");
			}
		}
	break;
	case "simpanedit":
		$txtID=addslashes($_POST['txtID']);
		$txtThnVersi=addslashes($_POST['txtThnVersi']);
		$txtPeraturan=addslashes($_POST['txtPeraturan']);
		$sqlSave="UPDATE kur_versikurikulum SET tahunversi='$txtThnVersi',permen='$txtPeraturan' WHERE id='$txtID'";
		$qrySave=mysql_query($sqlSave);
		if($qrySave){
			echo ns("Ngedit","parent.location='?page=$page'","Versi Kurikulum");
		}
	break;
	case "hapus":
		if(empty($_GET['dvk'])){echo "<b>Data yang dihapus tidak ada</b>";}
		else{
			$sqlDelete="DELETE FROM kur_versikurikulum WHERE id='".$_GET['dvk']."'";
			$qryDelete=mysql_query($sqlDelete) or die ("Eror hapus data".mysql_error());
			if($qryDelete){echo ns("Hapus","parent.location='?page=$page'","Versi Kurikulum");}
		}
	break;
}
echo "</div>";
include("inc/footer.php");
include("inc/scripts.php"); 
?>

<script>
	$(document).ready(function() {
		 pageSetUp();
	})
</script>

<?php 
include("inc/google-analytics.php"); 
?>