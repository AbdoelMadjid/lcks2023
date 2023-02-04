<?php
require_once("inc/init.php");
require_once("inc/config.ui.php");
$page_title = "Mata Pelajaran";
$page_css[] = "your_style.css";
include("inc/header.php");
$page_nav["akademik"]["sub"]["matapelajaran"]["active"] = true;
include("inc/nav.php");
echo "<div id='main' role='main'>";
$breadcrumbs["Akademik"] = "";
include("inc/ribbon.php");	
$sub=(isset($_GET['sub']))?$_GET['sub']:"";
switch($sub)
{
	case "tampil":default:
		$kd_pk=isset($_GET['kd_pk'])?$_GET['kd_pk']:"";
		$kelmp=isset($_GET['kelmp'])?$_GET['kelmp']:"";

		$FormPilih.="
		<form action='?page=$page' method='post' name='frmPilih' class='form-inline' role='form'>
			<div class='row'>
				<div class='col-sm-12 col-md-8'>
					<div class='form-group'>Pililh Data &nbsp;&nbsp;</div>";
					$FormPilih.=FormCF("inline","Paket Keahlian","txtPK","select * from ak_paketkeahlian","kode_pk",$kd_pk,"nama_paket","","onchange=\"document.location.href='?page=$page&kd_pk='+document.frmPilih.txtPK.value\"");
					$FormPilih.=FormCF("inline","Kel MP","txtKelMP","select * from ak_matapelajaran where kelompok group by kelompok","kelompok",$kelmp,"kelompok","","onchange=\"document.location.href='?page=$page&kd_pk='+document.frmPilih.txtPK.value+'&kelmp='+document.frmPilih.txtKelMP.value\"");
		$FormPilih.="
				</div>
				<div class='col-sm-12 col-md-4'><a href='?page=$page&sub=tambah' title='Tambah Mapel' class='btn btn-info btn-sm pull-right'><i class='fa fa-plus'></i>Tambah Mapel</a>
				</div>
			</div>
		</form>";

		if(!empty($_GET['kd_pk'])){
			$wh=" and ak_matapelajaran.kode_pk='$kd_pk' ";
		}
		if(!empty($_GET['kelmp'])){
			$wh=" and ak_matapelajaran.kelompok='$kelmp' ";
		}
		if(!empty($_GET['kd_pk']) && !empty($_GET['kelmp'])){
			$wh=" and ak_matapelajaran.kode_pk='$kd_pk' and ak_matapelajaran.kelompok='$kelmp' ";
		}
		$Q="SELECT * FROM ak_matapelajaran,ak_paketkeahlian WHERE ak_paketkeahlian.kode_pk=ak_matapelajaran.kode_pk $wh ";
		
		$no=1;
		
		$Query=mysql_query("$Q order by id_mapel asc");
		
		while($Hasil=mysql_fetch_array($Query)){
			$idmapel=$Hasil['id_mapel'];
			
			if($Hasil['semester1']==1){
				$Check1="<a href='?page=$page&sub=mapelno1&kelmp=$kelmp&kd_pk=$kd_pk&idmp=$idmapel&smstrna=1' data-action='mapelyesno' data-mapelyesno-msg=\"Apakah Anda yakin akan merubah semester pada mata pelajaran <strong class='txt-color-orangeDark'>{$Hasil['kode_mapel']} - {$Hasil['nama_mapel']}</strong>\"><i class='fa fa-check-circle font-md'></i></a>";
			}
			else{
				$Check1="<a href='?page=$page&sub=mapelyes1&kelmp=$kelmp&kd_pk=$kd_pk&idmp=$idmapel&smstrna=1' data-action='mapelyesno' data-mapelyesno-msg=\"Apakah Anda yakin akan merubah semester pada mata pelajaran <strong class='txt-color-orangeDark'>{$Hasil['kode_mapel']} - {$Hasil['nama_mapel']}</strong>\"><i class='txt-color-blue fa fa-circle font-md'></i></a>";
			}			
			
			if($Hasil['semester2']==1){
				$Check2="<a href='?page=$page&sub=mapelno2&kelmp=$kelmp&kd_pk=$kd_pk&idmp=$idmapel&smstrna=2' data-action='mapelyesno' data-mapelyesno-msg=\"Apakah Anda yakin akan merubah semester pada mata pelajaran <strong class='txt-color-orangeDark'>{$Hasil['kode_mapel']} - {$Hasil['nama_mapel']}</strong>\"><i class='fa fa-check-circle font-md'></i></a>";
			}
			else{
				$Check2="<a href='?page=$page&sub=mapelyes2&kelmp=$kelmp&kd_pk=$kd_pk&idmp=$idmapel&smstrna=2' data-action='mapelyesno' data-mapelyesno-msg=\"Apakah Anda yakin akan merubah semester pada mata pelajaran <strong class='txt-color-orangeDark'>{$Hasil['kode_mapel']} - {$Hasil['nama_mapel']}</strong>\"><i class='txt-color-blue fa fa-circle font-md'></i></a>";
			}			
			
			if($Hasil['semester3']==1){
				$Check3="<a href='?page=$page&sub=mapelno3&kelmp=$kelmp&kd_pk=$kd_pk&idmp=$idmapel&smstrna=3' data-action='mapelyesno' data-mapelyesno-msg=\"Apakah Anda yakin akan merubah semester pada mata pelajaran <strong class='txt-color-orangeDark'>{$Hasil['kode_mapel']} - {$Hasil['nama_mapel']}</strong>\"><i class='fa fa-check-circle font-md'></i></a>";
			}
			else{
				$Check3="<a href='?page=$page&sub=mapelyes3&kelmp=$kelmp&kd_pk=$kd_pk&idmp=$idmapel&smstrna=3' data-action='mapelyesno' data-mapelyesno-msg=\"Apakah Anda yakin akan merubah semester pada mata pelajaran <strong class='txt-color-orangeDark'>{$Hasil['kode_mapel']} - {$Hasil['nama_mapel']}</strong>\"><i class='txt-color-blue fa fa-circle font-md'></i></a>";
			}		
			
			if($Hasil['semester4']==1){
				$Check4="<a href='?page=$page&sub=mapelno4&kelmp=$kelmp&kd_pk=$kd_pk&idmp=$idmapel&smstrna=4' data-action='mapelyesno' data-mapelyesno-msg=\"Apakah Anda yakin akan merubah semester pada mata pelajaran <strong class='txt-color-orangeDark'>{$Hasil['kode_mapel']} - {$Hasil['nama_mapel']}</strong>\"><i class='fa fa-check-circle font-md'></i></a>";}
			else{
				$Check4="<a href='?page=$page&sub=mapelyes4&kelmp=$kelmp&kd_pk=$kd_pk&idmp=$idmapel&smstrna=4' data-action='mapelyesno' data-mapelyesno-msg=\"Apakah Anda yakin akan merubah semester pada mata pelajaran <strong class='txt-color-orangeDark'>{$Hasil['kode_mapel']} - {$Hasil['nama_mapel']}</strong>\"><i class='txt-color-blue fa fa-circle font-md'></i></a>";
			}
			
			if($Hasil['semester5']==1){
				$Check5="<a href='?page=$page&sub=mapelno5&kelmp=$kelmp&kd_pk=$kd_pk&idmp=$idmapel&smstrna=5' data-action='mapelyesno' data-mapelyesno-msg=\"Apakah Anda yakin akan merubah semester pada mata pelajaran <strong class='txt-color-orangeDark'>{$Hasil['kode_mapel']} - {$Hasil['nama_mapel']}</strong>\"><i class='fa fa-check-circle font-md'></i></a>";
			}
			else{
				$Check5="<a href='?page=$page&sub=mapelyes5&kelmp=$kelmp&kd_pk=$kd_pk&idmp=$idmapel&smstrna=5' data-action='mapelyesno' data-mapelyesno-msg=\"Apakah Anda yakin akan merubah semester pada mata pelajaran <strong class='txt-color-orangeDark'>{$Hasil['kode_mapel']} - {$Hasil['nama_mapel']}</strong>\"><i class='txt-color-blue fa fa-circle font-md'></i></a>";
			}
			
			if($Hasil['semester6']==1){
				$Check6="<a href='?page=$page&sub=mapelno6&kelmp=$kelmp&kd_pk=$kd_pk&idmp=$idmapel&smstrna=6' data-action='mapelyesno' data-mapelyesno-msg=\"Apakah Anda yakin akan merubah semester pada mata pelajaran <strong class='txt-color-orangeDark'>{$Hasil['kode_mapel']} - {$Hasil['nama_mapel']}</strong>\"><i class='fa fa-check-circle font-md'></i></a>";
			}
			else{
				$Check6="<a href='?page=$page&sub=mapelyes6&kelmp=$kelmp&kd_pk=$kd_pk&idmp=$idmapel&smstrna=6' data-action='mapelyesno' data-mapelyesno-msg=\"Apakah Anda yakin akan merubah semester pada mata pelajaran <strong class='txt-color-orangeDark'>{$Hasil['kode_mapel']} - {$Hasil['nama_mapel']}</strong>\"><i class='txt-color-blue fa fa-circle font-md'></i></a>";
			}
			
			$NamaPaket=$Hasil['nama_paket'];
			
			$TampilData.="
			<tr>
				<td class='text-center'>$no.</td>
				<td>{$Hasil['kode_mapel']}</td>
				<td>{$Hasil['nama_paket']}</td>
				<td><a href='?page=$page&amp;sub=edit&amp;Kode={$Hasil['id_mapel']}'>{$Hasil['nama_mapel']}</a></td>
				<td>$Check1</td>
				<td>$Check2</td>
				<td>$Check3</td>
				<td>$Check4</td>
				<td>$Check5</td>
				<td>$Check6</td>
			</tr>";
			$no++;
		}
		
		$jmldata=mysql_num_rows($Query);
		
		if($jmldata>0){
			if(!empty($_GET['kd_pk'])){
				$Infona.="<span class='label bg-color-redLight'>Paket Keahlian <strong>{$NamaPaket}</strong></span> ";
			}
			
			if(!empty($_GET['kelmp'])){
				$Infona.="<span class='label bg-color-redLight'>Kelompok <strong>{$kelmp}</strong></span> ";
			}
			
			$Show.=KolomPanel($FormPilih);	
			
			$Show.="$Infona <span class='label bg-color-redLight'>Total <b>$jmldata (".terbilang($jmldata).")</b> Mata Pelajaran</span><br><br>";
			
			$Show.="
			<div class='well no-padding'>
				<table id='dt_basic' class='table table-striped table-bordered table-hover table-condensed' width='100%'>
					<thead>
						<tr>
							<th class='text-center' data-class='expand'>No.</th>
							<th class='text-center' data-hide='phone,tablet'>Kode Mapel</th>
							<th class='text-center' data-hide='phone,tablet'>Paket Keahlian</th>
							<th class='text-center'>Mata Pelajaran</th>
							<th class='text-center' data-hide='phone,tablet'>S1</th>
							<th class='text-center' data-hide='phone,tablet'>S2</th>
							<th class='text-center' data-hide='phone,tablet'>S3</th>
							<th class='text-center' data-hide='phone,tablet'>S4</th>
							<th class='text-center' data-hide='phone,tablet'>S5</th>
							<th class='text-center' data-hide='phone,tablet'>S6</th>
						</tr>
					</thead>
					<tbody>$TampilData</tbody>
				</table>
			</div>";
		}
		else{
			$Show.=KolomPanel($FormPilih);
			$Show.=nt("informasi","<br>Silakan tambah mata pelajaran. atau klik tombol di bawah ini untuk impor Mata Pelajaran<br><a href='?page=tools-impor-datamaster&sub=ngapload&aksi=mapel' class='btn btn-info btn-sm'>Impor Mata Pelajaran</a>","Mata Pelajaran");		
		}	
		$tandamodal="#DataMP";
		echo $DataMP;
		echo MyWidget('fa-book',"Daftar Mata Pelajaran","",$Show);
	break;
	case "tambah":	
		$Show.="
		<script>
		function hitKodeKelas(){
			KodeKD=document.FrmTambahMP.txtKodePK.value;Kelompok=document.FrmTambahMP.txtKelompok.value;NoUrutmapel=document.FrmTambahMP.txtIUrutMP.value;KelMapel=Kelompok+NoUrutmapel;KodeMapel=KodeKD+'-'+Kelompok+NoUrutmapel;document.FrmTambahMP.txtKelMapel.value=KelMapel;document.FrmTambahMP.txtKodeMapel.value=KodeMapel;
		}
		</script>";
		$IdentMP.=FOrmIF("horizontal","Kode Mata Pelajaran", "txtKodeMapel","",'3','readonly=readonly');
		$IdentMP.=FormCF("horizontal",'Paket Keahlian','txtKodePK','select * from ak_paketkeahlian','kode_pk',$kode_pk,'nama_paket','6','onchange=hitKodeKelas(this.value)');
		$IdentMP.=FormCR("horizontal",'Kelompok','txtKelompok',$kelompok,$Ref->KelMapel,'3','onchange=hitKodeKelas(this.value)');
		$IdentMP.=FormCR("horizontal",'No. Urut Mapel dalam Kelompok','txtIUrutMP',$urut_mp,$Ref->Angka,'4','onchange=hitKodeKelas(this.value)');
		$IdentMP.=FormIF("horizontal","Kelompok Mata Pelajaran", "txtKelMapel","",'2','readonly=readonly');
		$IdentMP.=FormIF("horizontal","Mata Pelajaran", "txtMapel","",'8',"");
		$IdentMP.=FormIF("horizontal","Jenis Mata Pelajaran", "txtJenisMapel","",'2',"");
		$AdaTidak.=FormRBDB("Semester 1","txtSmstr1",$semester1,"radio1","radio2");
		$AdaTidak.=FormRBDB("Semester 2","txtSmstr2",$semester2,"radio3","radio4");		
		$AdaTidak.=FormRBDB("Semester 3","txtSmstr3",$semester3,"radio5","radio6");
		$AdaTidak.=FormRBDB("Semester 4","txtSmstr4",$semester4,"radio7","radio8");
		$AdaTidak.=FormRBDB("Semester 5","txtSmstr5",$semester5,"radio9","radio10");
		$AdaTidak.=FormRBDB("Semester 6","txtSmstr6",$semester6,"radio11","radio12");
		$IsiForm.='<fieldset>';
		$IsiForm.=DuaKolomSama(JudulDalam("Profil Mata Pelajaran","pencil-square-o").$IdentMP,JudulDalam("Ada pada Semester","check-square-o").$AdaTidak);
		$IsiForm.='</fieldset>';
		$IsiForm.='<div class="form-actions">'.ButtonSimpan().'</div>';
		
		$Show.="<p>Menambah Mata Pelajaran bisa melalui impor Mata Pelajaran ke MYSQL di Menu <a href='?page=tools-impor-datamaster&sub=ngapload&aksi=mapel' class='label bg-color-blue'>Tools <i class='fa fa-angle-double-right fa-fw'></i> Impor <i class='fa fa-angle-double-right fa-fw'></i> Mata Pelajaran</a></p><hr>";

		$Show.=FormAing($IsiForm,"?page=$page&amp;sub=simpantambah","FrmTambahMP","");
		$tandamodal="#TambahMP";
		echo $TambahMP;
		echo MyWidget('fa-plus',"Tambah Mata Pelajaran",array(ButtonKembali("?page=$page")),$Show);
	break;
	case "simpantambah":
		$message=array();
		$KodeMapelna.=trim($_POST['txtKodePK']).'-'.trim($_POST['txtKelompok']).trim($_POST['txtIUrutMP']);
		NgambilData("select * from ak_matapelajaran where kode_mapel='$KodeMapelna'");
		if($KodeMapelna==$kode_mapel){$message[]="Kode Mata Pelajaran sudah ada!";}
		if(trim($_POST['txtIUrutMP'])==""){$message[]="Nomor Urut Kelompok Mapel tidak boleh kosong !";}
		if(trim($_POST['txtMapel'])==""){$message[]="Mata Pelajaran tidak boleh kosong !";}
		if(trim($_POST['txtJenisMapel'])==""){$message[]="Jenis Mata Pelajaran tidak boleh kosong !";}
		if(!count($message)==0){
			$Num=0;
			foreach($message as $indeks=>$pesan_tampil){
				$Num++;
				$Pesannya.="$Num. $pesan_tampil<br>";
			}
			echo Peringatan("$Pesannya","parent.location='?page=$page&sub=tambah'");
		}
		else{
			$txtKodeMapel=addslashes($_POST['txtKodeMapel']);
			$txtKodePK=addslashes($_POST['txtKodePK']);
			$txtKelompok=addslashes($_POST['txtKelompok']);
			$txtIUrutMP=addslashes($_POST['txtIUrutMP']);
			$txtKelMapel=addslashes($_POST['txtKelMapel']);
			$txtMapel=addslashes($_POST['txtMapel']);
			$txtJenisMapel=addslashes($_POST['txtJenisMapel']);
			$txtSmstr1=addslashes($_POST['txtSmstr1']);
			$txtSmstr2=addslashes($_POST['txtSmstr2']);
			$txtSmstr3=addslashes($_POST['txtSmstr3']);
			$txtSmstr4=addslashes($_POST['txtSmstr4']);
			$txtSmstr5=addslashes($_POST['txtSmstr5']);
			$txtSmstr6=addslashes($_POST['txtSmstr6']);
			mysql_query("INSERT INTO ak_matapelajaran VALUES ('','$txtKodeMapel','$txtKodePK','$txtKelompok','$txtIUrutMP', '$txtKelMapel','$txtMapel','$txtJenisMapel','$txtSmstr1','$txtSmstr2','$txtSmstr3','$txtSmstr4','$txtSmstr5','$txtSmstr6')");
			echo ns("Nambah","parent.location='?page=$page'","Mata Pelajaran <span class='txt-color-orangeDark'><strong>$txtMapel</strong></span>");
		}
	break;
	case "edit":
		$KodeEdit= isset($_GET['Kode'])?$_GET['Kode']:""; 
		NgambilData("SELECT * FROM ak_matapelajaran, ak_paketkeahlian WHERE ak_matapelajaran.kode_pk=ak_paketkeahlian.kode_pk AND ak_matapelajaran.id_mapel='$KodeEdit'");
		$IdentMP.="<input type='hidden' name='txtKode' value='$id_mapel'>";
		$IdentMP.=FormIF("horizontal","Kode Mata Pelajaran", "txtKodeMP",$kode_mapel,'3','readonly=readonly');
		$IdentMP.=FormCF("horizontal",'Paket Keahlian','txtKodePK','select * from paketkeahlian','kode_pk',$kode_pk,'nama_paket','6',"");
		$IdentMP.=FormCR("horizontal",'Kelompok','txtKelompok',$kelompok,$Ref->KelMapel,'3',"");
		$IdentMP.=FormCR("horizontal",'No. Urut Mapel','txtIUrutMP',$urut_mp,$Ref->Angka,'2',"");
		$IdentMP.=FormIF("horizontal","Kelompok Mapel", "txtKelMapel",$kelmapel,'2',"");
		$IdentMP.=FormIF("horizontal","Mata Pelajaran", "txtMapel",$nama_mapel,'8',"");
		$IdentMP.=FormIF("horizontal","Jenis Mapel", "txtJenisMapel",$jenismapel,'2',"");
		$AdaTidak.=FormRBDB("Semester 1","txtSmstr1",$semester1,"radio1","radio2");
		$AdaTidak.=FormRBDB("Semester 2","txtSmstr2",$semester2,"radio3","radio4");		
		$AdaTidak.=FormRBDB("Semester 3","txtSmstr3",$semester3,"radio5","radio6");
		$AdaTidak.=FormRBDB("Semester 4","txtSmstr4",$semester4,"radio7","radio8");
		$AdaTidak.=FormRBDB("Semester 5","txtSmstr5",$semester5,"radio9","radio10");
		$AdaTidak.=FormRBDB("Semester 6","txtSmstr6",$semester6,"radio11","radio12");
		$IsiForm.='<fieldset>';
		$IsiForm.=DuaKolomSama("<h1><i class='fa fa-fw fa-pencil-square-o bounceIn animated text-danger'></i><small class='text-danger slideInRight fast animated'><strong>  Profil Mata Pelajaran</strong></small></h1><hr>".$IdentMP,"<h1><i class='fa fa-fw fa-check-square-o bounceIn animated text-danger'></i><small class='text-danger slideInRight fast animated'><strong>  Ada/Tidak Ada Mata Pelajaran Per Semester</strong></small></h1><hr>".$AdaTidak);
		$IsiForm.='</fieldset>';
		$IsiForm.='<div class="form-actions">'.ButtonSimpan().'</div>';

		$Show.=FormAing($IsiForm,"?page=$page&amp;sub=simpanedit","FrmEditMP","");
		$tandamodal="#EditMP";
		echo $EditMP;
		echo MyWidget('fa-pencil-square-o',"Edit Mata Pelajaran",array(ButtonKembali("?page=$page")),$Show);
	break;
	
	case "simpanedit":
		$txtKode=addslashes($_POST['txtKode']);
		$txtKodePK=addslashes($_POST['txtKodePK']);
		$txtKelompok=addslashes($_POST['txtKelompok']);
		$txtIUrutMP=addslashes($_POST['txtIUrutMP']);
		$txtKelMapel=addslashes($_POST['txtKelMapel']);
		$txtMapel=addslashes($_POST['txtMapel']);
		$txtJenisMapel=addslashes($_POST['txtJenisMapel']);
		$txtSmstr1=addslashes($_POST['txtSmstr1']);
		$txtSmstr2=addslashes($_POST['txtSmstr2']);
		$txtSmstr3=addslashes($_POST['txtSmstr3']);
		$txtSmstr4=addslashes($_POST['txtSmstr4']);
		$txtSmstr5=addslashes($_POST['txtSmstr5']);
		$txtSmstr6=addslashes($_POST['txtSmstr6']);
		$KodeMapel.=$txtKodePK.'-'.$txtKelompok.$txtIUrutMP;
		mysql_query("UPDATE ak_matapelajaran SET kode_mapel='$KodeMapel', kode_pk='$txtKodePK ', kelompok='$txtKelompok', urut_mp='$txtIUrutMP', kelmapel='$txtKelMapel',nama_mapel='$txtMapel',jenismapel='$txtJenisMapel',semester1='$txtSmstr1',semester2='$txtSmstr2',semester3='$txtSmstr3',semester4='$txtSmstr4',semester5='$txtSmstr5',semester6='$txtSmstr6' WHERE id_mapel='$txtKode'");
		echo '<div id="preloader"><div id="cssload"></div></div>';
		echo ns("Ngedit","parent.location='?page=$page'","Mata Pelajaran <span class='txt-color-orangeDark'><strong>$txtMapel</strong></span>");
	break;
	
	case "mapelno1":
		$kd_pk= isset($_GET['kd_pk'])?$_GET['kd_pk']:"";
		$kelmp= isset($_GET['kelmp'])?$_GET['kelmp']:"";
		$idmp=isset($_GET['idmp'])?$_GET['idmp']:""; 
		$smstrna=isset($_GET['smstrna'])?$_GET['smstrna']:""; 		
		mysql_query("update ak_matapelajaran set semester1='0' where id_mapel='$idmp'");
		echo "<script>parent.location='?page=$page&kelmp=$kelmp&kd_pk=$kd_pk'</script>";
	break;
	case "mapelno2":
		$kd_pk= isset($_GET['kd_pk'])?$_GET['kd_pk']:"";
		$kelmp= isset($_GET['kelmp'])?$_GET['kelmp']:"";
		$idmp=isset($_GET['idmp'])?$_GET['idmp']:""; 
		$smstrna=isset($_GET['smstrna'])?$_GET['smstrna']:""; 
		mysql_query("update ak_matapelajaran set semester2='0' where id_mapel='$idmp'");
		echo "<script>parent.location='?page=$page&kelmp=$kelmp&kd_pk=$kd_pk'</script>";
	break;
	case "mapelno3":
		$kd_pk= isset($_GET['kd_pk'])?$_GET['kd_pk']:"";
		$kelmp= isset($_GET['kelmp'])?$_GET['kelmp']:"";
		$idmp=isset($_GET['idmp'])?$_GET['idmp']:""; 
		$smstrna=isset($_GET['smstrna'])?$_GET['smstrna']:""; 
		mysql_query("update ak_matapelajaran set semester3='0' where id_mapel='$idmp'");
		echo "<script>parent.location='?page=$page&kelmp=$kelmp&kd_pk=$kd_pk'</script>";
	break;
	case "mapelno4":
		$kd_pk= isset($_GET['kd_pk'])?$_GET['kd_pk']:"";
		$kelmp= isset($_GET['kelmp'])?$_GET['kelmp']:"";
		$idmp=isset($_GET['idmp'])?$_GET['idmp']:""; 
		$smstrna=isset($_GET['smstrna'])?$_GET['smstrna']:""; 
		mysql_query("update ak_matapelajaran set semester4='0' where id_mapel='$idmp'");
		echo "<script>parent.location='?page=$page&kelmp=$kelmp&kd_pk=$kd_pk'</script>";
	break;
	case "mapelno5":
		$kd_pk= isset($_GET['kd_pk'])?$_GET['kd_pk']:"";
		$kelmp= isset($_GET['kelmp'])?$_GET['kelmp']:"";
		$idmp=isset($_GET['idmp'])?$_GET['idmp']:""; 
		$smstrna=isset($_GET['smstrna'])?$_GET['smstrna']:""; 
		mysql_query("update ak_matapelajaran set semester5='0' where id_mapel='$idmp'");
		echo "<script>parent.location='?page=$page&kelmp=$kelmp&kd_pk=$kd_pk'</script>";
	break;
	case "mapelno6":
		$kd_pk= isset($_GET['kd_pk'])?$_GET['kd_pk']:"";
		$kelmp= isset($_GET['kelmp'])?$_GET['kelmp']:"";
		$idmp=isset($_GET['idmp'])?$_GET['idmp']:""; 
		$smstrna=isset($_GET['smstrna'])?$_GET['smstrna']:""; 
		mysql_query("update ak_matapelajaran set semester6='0' where id_mapel='$idmp'");
		echo "<script>parent.location='?page=$page&kelmp=$kelmp&kd_pk=$kd_pk'</script>";
	break;
	case "mapelyes1":
		$kd_pk= isset($_GET['kd_pk'])?$_GET['kd_pk']:"";
		$kelmp= isset($_GET['kelmp'])?$_GET['kelmp']:"";
		$idmp=isset($_GET['idmp'])?$_GET['idmp']:""; 
		$smstrna=isset($_GET['smstrna'])?$_GET['smstrna']:""; 		
		mysql_query("update ak_matapelajaran set semester1='1' where id_mapel='$idmp'");
		echo "<script>parent.location='?page=$page&kelmp=$kelmp&kd_pk=$kd_pk'</script>";
	break;
	case "mapelyes2":
		$kd_pk= isset($_GET['kd_pk'])?$_GET['kd_pk']:"";
		$kelmp= isset($_GET['kelmp'])?$_GET['kelmp']:"";
		$idmp=isset($_GET['idmp'])?$_GET['idmp']:""; 
		$smstrna=isset($_GET['smstrna'])?$_GET['smstrna']:""; 
		mysql_query("update ak_matapelajaran set semester2='1' where id_mapel='$idmp'");
		echo "<script>parent.location='?page=$page&kelmp=$kelmp&kd_pk=$kd_pk'</script>";
	break;
	case "mapelyes3":
		$kd_pk= isset($_GET['kd_pk'])?$_GET['kd_pk']:"";
		$kelmp= isset($_GET['kelmp'])?$_GET['kelmp']:"";
		$idmp=isset($_GET['idmp'])?$_GET['idmp']:""; 
		$smstrna=isset($_GET['smstrna'])?$_GET['smstrna']:""; 
		mysql_query("update ak_matapelajaran set semester3='1' where id_mapel='$idmp'");
		echo "<script>parent.location='?page=$page&kelmp=$kelmp&kd_pk=$kd_pk'</script>";
	break;
	case "mapelyes4":
		$kd_pk= isset($_GET['kd_pk'])?$_GET['kd_pk']:"";
		$kelmp= isset($_GET['kelmp'])?$_GET['kelmp']:"";
		$idmp=isset($_GET['idmp'])?$_GET['idmp']:""; 
		$smstrna=isset($_GET['smstrna'])?$_GET['smstrna']:""; 
		mysql_query("update ak_matapelajaran set semester4='1' where id_mapel='$idmp'");
		echo "<script>parent.location='?page=$page&kelmp=$kelmp&kd_pk=$kd_pk'</script>";
	break;
	case "mapelyes5":
		$kd_pk= isset($_GET['kd_pk'])?$_GET['kd_pk']:"";
		$kelmp= isset($_GET['kelmp'])?$_GET['kelmp']:"";
		$idmp=isset($_GET['idmp'])?$_GET['idmp']:""; 
		$smstrna=isset($_GET['smstrna'])?$_GET['smstrna']:""; 
		mysql_query("update ak_matapelajaran set semester5='1' where id_mapel='$idmp'");
		echo "<script>parent.location='?page=$page&kelmp=$kelmp&kd_pk=$kd_pk'</script>";
	break;
	case "mapelyes6":
		$kd_pk= isset($_GET['kd_pk'])?$_GET['kd_pk']:"";
		$kelmp= isset($_GET['kelmp'])?$_GET['kelmp']:"";	
		$idmp=isset($_GET['idmp'])?$_GET['idmp']:""; 
		$smstrna=isset($_GET['smstrna'])?$_GET['smstrna']:""; 
		mysql_query("update ak_matapelajaran set semester6='1' where id_mapel='$idmp'");
		echo "<script>parent.location='?page=$page&kelmp=$kelmp&kd_pk=$kd_pk'</script>";
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
	var x={
		"mapelyesno":function(x){
			function y(){
				window.location=x.attr("href")
			}
			$.SmartMessageBox(
				{
					"title":"<i class='fa fa-question-circle txt-color-white'></i> <span class='txt-color-red'><strong>Konfirmasi </strong></span> ",
					"content":x.data("mapelyesno-msg"),
					"buttons":"[No][Yes]"
				},function(x){
					"Yes"==x&&($.root_.addClass("animated fadeOutUp"),setTimeout(y,1e3))
					}
		)}
	}
	$.root_.on("click",'[data-action="mapelyesno"]',function(y){var z=$(this);x.mapelyesno(z),y.preventDefault(),z=null});

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