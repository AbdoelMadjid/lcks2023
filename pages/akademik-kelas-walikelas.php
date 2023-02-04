<?php
require_once("inc/init.php");
require_once("inc/config.ui.php");
$page_title = "Kelas";
$page_css[] = "your_style.css";
include("inc/header.php");
$page_nav["akademik"]["sub"]["kelas"]["active"] = true;
include("inc/nav.php");
echo "<div id='main' role='main'>";
$breadcrumbs["Akademik"] = "";
include("inc/ribbon.php");	
$sub=(isset($_GET['sub']))?$_GET['sub']:"";
switch($sub)
{
	case "tampil":default:
		$thnajar=isset($_GET['thnajar'])?$_GET['thnajar']:"";

		$FormPilih.="
		<form action='?page=$page' method='post' name='frmPilih' class='form-inline' role='form'>
			<div class='row'>
				<div class='col-sm-12 col-md-8'>
					<div class='form-group'>Pililh Data &nbsp;&nbsp;</div>";		
						$FormPilih.=FormCF("inline","Tahun Ajar","txtTA","select * from ak_tahunajaran","tahunajaran",$thnajar,"tahunajaran","","onchange=\"document.location.href='?page=$page&thnajar='+document.frmPilih.txtTA.value\"");
		$FormPilih.="
					</div>
				<div class='col-sm-12 col-md-4'>
				<a href='?page=$page&sub=tambah' title='Tambah Kelas' class='btn btn-info btn-sm pull-right'><i class='fa fa-plus'></i> Tambah Kelas</a>
				</div>
			</div>
		</form>";

		if(!empty($_GET['thnajar'])){
			$wh=" and tahunajaran='$thnajar' ";
		}
		else{
			$wh=" and tahunajaran='$TahunAjarAktif' ";
			$thnajar="$TahunAjarAktif";
		} 
		
		if($thnajar=="Semua"){
			$wh="";
			$thnajar="Semua";
		}
		
		$Q="SELECT * FROM ak_kelas,ak_paketkeahlian,app_user_guru WHERE ak_kelas.kode_pk=ak_paketkeahlian.kode_pk AND ak_kelas.id_guru=app_user_guru.id_guru $wh ";
		
		$no=1;
		$Query=mysql_query("$Q  order by ak_kelas.id_kls, ak_kelas.tingkat asc");
		while($Hasil=mysql_fetch_array($Query)){
			NgambilData("select * from app_user_walikelas where id_walikelas='{$Hasil['id_kls']}'");			

			$TampilData.="
			<tr>
				<td class='text-center'>$no.</td>
				<td><a href='?page=$page&amp;sub=edit&amp;Kode={$Hasil['id_kls']}'>{$Hasil['kode_kelas']}</a></td>
				<td>{$Hasil['tahunajaran']}</td>
				<td>{$Hasil['nama_paket']}</td>
				<td>{$Hasil['nama_kelas']}</td>							
				<td><strong class='txt-color-red'>{$Hasil['id_guru']}</strong> - {$Hasil['nama_lengkap']}</td>
				<td>{$userid}</td>
				<td>{$kuncina}</td>
			</tr>";
			$no++;
		}
		
		$jmldata=mysql_num_rows($Query);
		
		if($jmldata>0){
			
			$Show.=KolomPanel($FormPilih);
			$Show.="<span class='label bg-color-redLight'>Tahun Ajaran $thnajar</span> <span class='label bg-color-redLight'>Total <em>$jmldata (".terbilang($jmldata).")</em> Kelas</span><br><br>";
			$Show.="
			<div class='well no-padding'>
				<table id='dt_basic' class='table table-striped table-bordered table-hover table-condensed' width='100%'>
					<thead>
						<tr>
							<th class='text-center' data-class='expand'>No.</th>
							<th class='text-center'>Kode Kelas</th>
							<th class='text-center' data-hide='phone'>Tahun Ajaran</th>
							<th class='text-center' data-hide='phone'>Paket Keahlian</th>
							<th class='text-center' data-hide='phone'>Kelas</th>
							<th class='text-center' data-hide='phone'>Wali Kelas</th>
							<th class='text-center' data-hide='phone'>Username</th>
							<th class='text-center' data-hide='phone'>Password</th>
						</tr>
					</thead>
					<tbody>$TampilData</tbody>
				</table>
			</div>";
		}
		else{
			$Show.=KolomPanel($FormPilih);
			$Show.=KolomPanel("<h1 class='text-center text-danger'><strong><i class='fa fa-exclamation-triangle fa-lg'></i></h1> <h4 class='text-center text-info'>Data Kelas Thn Ajaran $thnajar <br>Masih Kosong</strong></h4>");
		}

		$tandamodal="#DataKelas";
		echo $DataKelas;
		echo MyWidget('fa-list',"Kelas Tahun Ajar $thnajar","",$Show);
	break;

	case "tambah":
		$IsiForm.="<fieldset><script src='".ASSETS_URL."/js/myjs/ak-kelas-walikelas.js'></script>";
		$IsiForm.=FormIF("horizontal","Kode Kelas", "txtKodeKls","",'3','readonly=readonly');
		$IsiForm.=FormIF("horizontal","Kelas", "txtNamaKls","",'1','readonly=readonly');
		$IsiForm.=FormCF("horizontal",'Tahun Ajaran','txtThnAjar','select * from ak_tahunajaran','tahunajaran',$TahunAjarAktif,'tahunajaran','2',"");
		$IsiForm.=FormCF("horizontal",'Paket Keahlian','txtKodePK','select * from ak_paketkeahlian','kode_pk',$kode_pk,'nama_paket','3','onchange=showCD(this.value)');
		$IsiForm.=FormCR("horizontal",'Tahun Masuk','txtThnMasuk',$tahunmasuk,$Ref->TahunMasuk,'2','onchange=hitKodeKelas(this.value)');
		$IsiForm.=FormCR("horizontal",'Tingkat','txtTingkat',$tingkat,$Ref->TingkatKls,'2','onchange=hitKodeKelas(this.value)');
		$IsiForm.=FormCR("horizontal",'Pararel','txtPararel',$pararel,$Ref->Angka,'2','onchange=hitKodeKelas(this.value)');
		$IsiForm.=FormCF("horizontal",'Wali Kelas','txtIDGuru',"select * from app_user_guru where aktif='Aktif' order by nama_lengkap",'id_guru',$id_guru,'nama_lengkap','4',"");
		$IsiForm.=FormIF("horizontal","Username WK", "txtUserWK","",'2','readonly=readonly');
		$IsiForm.=FormIF("horizontal","Password WK", "txtPassWK","",'2','readonly=readonly');
		$IsiForm.="<div id='txtHint'></div></fieldset><div class='form-actions'>".ButtonSimpan()."</div>";

		$Show.=FormAing($IsiForm,"?page=$page&amp;sub=simpantambah","frmTmbhKelas","");
		$tandamodal="#DataKelas";
		echo $DataKelas;
		echo MyWidget('fa-plus',"Tambah Kelas",array(ButtonKembali("?page=$page")),$Show);
	break;

	case "simpantambah":
		$message=array();
		$QSetKodekls=mysql_query("select * from ak_kelas where kode_kelas='".trim($_POST['txtKodeKls'])."'");
		$HSetKodekls=mysql_fetch_array($QSetKodekls);
		if(trim($_POST['txtKodeKls'])==$HSetKodekls['kode_kelas']){$message[]="Kode Kelas ".trim($_POST['txtKodeKls'])." sudah ada!";}
		if(trim($_POST['txtKodeKls'])==""){$message[]="Kode Kelas tidak boleh kosong !";}
		if(trim($_POST['txtIDGuru'])==""){$message[]="Nama Pengajar tidak boleh kosong !";}
		$gurunaSql="SELECT * FROM ak_kelas WHERE tahunajaran='".trim($_POST['txtThnAjar'])."' AND id_guru='".trim($_POST['txtIDGuru'])."'";
		$gurunaQry=mysql_query($gurunaSql) or die ("Query Salah : ".mysql_error());
		if(mysql_num_rows($gurunaQry)>=1){
			$gurunaData=mysql_fetch_array($gurunaQry);
			if($gurunaData['id_guru']==trim($_POST['txtIDGuru']) and $gurunaData['tahunajaran']==trim($_POST['txtThnAjar'])){
				$message[]="Guru dengan kode \"".trim($_POST['txtIDGuru'])."\" sudah ada!";
			}
		}
		if(!count($message)==0){
			$Num=0;
			foreach($message as $indeks=>$pesan_tampil){
				$Num++;
				$Pesannya.="$Num. $pesan_tampil<br>";
			}
			echo Peringatan("$Pesannya","parent.location='?page=$page&sub=tambah'");
		}
		else{
			$kd_kls=buatKode("ak_kelas","kls");
			$txtKodeKls=addslashes($_POST['txtKodeKls']);
			$txtThnAjar=addslashes($_POST['txtThnAjar']);
			$txtKodePK=addslashes($_POST['txtKodePK']);
			$txtThnMasuk=addslashes($_POST['txtThnMasuk']);
			$txtTingkat=addslashes($_POST['txtTingkat']);
			$txtSingkat=addslashes($_POST['txtSingkat']);
			$txtPararel=addslashes($_POST['txtPararel']);
			$txtNamaKls=addslashes($_POST['txtNamaKls']);
			$txtIDGuru=addslashes($_POST['txtIDGuru']);
			$txtUserWK=addslashes($_POST['txtUserWK']);
			$txtPassWK=addslashes($_POST['txtPassWK']);
			mysql_query("INSERT INTO ak_kelas VALUES ('$kd_kls','$txtKodeKls','$txtThnAjar','$txtKodePK','$txtThnMasuk','$txtTingkat', '$txtSingkat','$txtPararel','$txtNamaKls','$txtIDGuru')");
			$TASingkat=substr($txtThnAjar,2,2).substr($txtThnAjar,7,2);
			NgambilData("SELECT * FROM ak_user_guru WHERE id_guru='".mysql_escape_string($txtIDGuru)."'");
			mysql_query("INSERT INTO ak_user_walikelas VALUES ('$kd_kls','$txtThnAjar','$txtKodeKls','$txtIDGuru','$nama_lengkap','$TASingkat$txtUserWK',md5('$txtPassWK'),'Wali Kelas','$txtPassWK','','','')");
			echo ns("Nambah","parent.location='?page=$page'","Kelas <strong class='text-primary'>$txtNamaKls</strong>");
		}
	break;

	case "edit":
		$KodeEdit=isset($_GET['Kode'])?$_GET['Kode']:"";
		NgambilData("SELECT * FROM ak_kelas,ak_paketkeahlian,app_user_guru WHERE ak_kelas.kode_pk=ak_paketkeahlian.kode_pk AND ak_kelas.id_guru=app_user_guru.id_guru AND ak_kelas.id_kls='".mysql_escape_string($KodeEdit)."'");
		$IsiForm.='<fieldset>';
		$IsiForm.=FormIF("horizontal","ID Kelas", "txtKode",$id_kls,'2','readonly=readonly');
		$IsiForm.=FormIF("horizontal","Kode Kelas", "txtKodeKls",$kode_kelas,'2','readonly=readonly');
		$IsiForm.=FormIF("horizontal","Kelas", "txtNamaKls",$nama_kelas,'1','readonly=readonly');
		$IsiForm.=FormCF("horizontal",'Tahun Ajaran','txtThnAjar','select * from ak_tahunajaran','tahunajaran',$tahunajaran,'tahunajaran','2','readonly=readonly');
		$IsiForm.=FormCF("horizontal",'Paket Keahlian','txtKodePK','select * from ak_paketkeahlian','kode_pk',$kode_pk,'nama_paket','3','readonly=readonly');
		$IsiForm.=FormCR("horizontal",'Tahun Masuk','txtThnMasuk',$tahunmasuk,$Ref->TahunMasuk,'2','readonly=readonly');
		$IsiForm.=FormCR("horizontal",'Tingkat','txtTingkat',$tingkat,$Ref->TingkatKls,'1','readonly=readonly');
		$IsiForm.=FormCF("horizontal",'Singkatan','txtSingkat','select * from ak_paketkeahlian','singkatan',$nama_singkat,'singkatan','2','readonly=readonly');
		$IsiForm.=FormCR("horizontal",'Pararel','txtPararel',$pararel,$Ref->Angka,'1','readonly=readonly');
		$IsiForm.=FormCF("horizontal",'Wali Kelas','txtIDGuru','select * from app_user_guru','id_guru',$id_guru,'nama_lengkap','4',"");
		$IsiForm.='</fieldset>';
		$IsiForm.='<div class="form-actions">'.ButtonSimpan().'</div>';

		$Show.=FormAing($IsiForm,"?page=$page&amp;sub=simpanedit","frmEditKelas","");
		$tandamodal="#EditKelas";
		echo $EditKelas;
		echo MyWidget('fa-pencil-square-o',"Edit Kelas",array(ButtonKembali("?page=$page")),$Show);
	break;

	case "simpanedit":
		$message=array();
		$gurunaSql="SELECT * FROM ak_kelas WHERE tahunajaran='".trim($_POST['txtThnAjar'])."' AND id_guru='".trim($_POST['txtIDGuru'])."'";
		$gurunaQry=mysql_query($gurunaSql) or die ("Query Salah : ".mysql_error());
		if(mysql_num_rows($gurunaQry)>=1){
			$gurunaData=mysql_fetch_array($gurunaQry);
			if($gurunaData['id_guru']==trim($_POST['txtIDGuru']) and $gurunaData['tahunajaran']==trim($_POST['txtThnAjar'])){
				$message[]="Guru dengan kode \"".trim($_POST['txtIDGuru'])."\" sudah ada!";
			}
		}
		if(!count($message)==0){
			$Num=0;
			foreach($message as $indeks=>$pesan_tampil){
				$Num++;
				$Pesannya.="$Num. $pesan_tampil<br>";
			}
			echo Peringatan($Pesannya,"parent.location='?page=$page&sub=edit'");
		}
		else{
			$txtKode=addslashes($_POST['txtKode']);
			$txtKodeKls=addslashes($_POST['txtKodeKls']);
			$txtNamaKls=addslashes($_POST['txtNamaKls']);
			$txtThnAjar=addslashes($_POST['txtThnAjar']);
			$txtKodePK=addslashes($_POST['txtKodePK']);
			$txtThnMasuk=addslashes($_POST['txtThnMasuk']);
			$txtTingkat=addslashes($_POST['txtTingkat']);
			$txtSingkat=addslashes($_POST['txtSingkat']);
			$txtPararel=addslashes($_POST['txtPararel']);
			$txtIDGuru=addslashes($_POST['txtIDGuru']);
			mysql_query("UPDATE ak_kelas SET id_guru='$txtIDGuru' WHERE id_kls='".trim($_POST['txtKode'])."'");
			NgambilData("SELECT * FROM app_user_guru WHERE id_guru='".trim($_POST['txtIDGuru'])."'");
			mysql_query("UPDATE app_user_walikelas SET id_guru='$txtIDGuru', nama_wk='$nama_lengkap' WHERE id_walikelas='".trim($_POST['txtKode'])."'");
			echo ns("Ngedit","parent.location='?page=$page'","Kelas <strong class='text-primary'>$txtNamaKls</strong>");
		}
	break;

	case "hapus":
		if(empty($_GET['Kode'])){echo "<b>Data yang dihapus tidak ada</b>";}
		else{
			mysql_query("DELETE FROM ak_kelas WHERE id_kls='".$_GET['Kode']."'");
			mysql_query("DELETE FROM app_user_walikelas WHERE id_walikelas='".$_GET['Kode']."'");
			echo ns("Hapus","parent.location='?page=$page'","Kelas dan Wali Kelas dengan ID <strong class='text-primary'>".$_GET['Kode']."</strong>");
		}
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