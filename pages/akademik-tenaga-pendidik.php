<?php
require_once("inc/init.php");
require_once("inc/config.ui.php");
$page_title = "Tenaga Pendidik";
$page_css[] = "your_style.css";
include("inc/header.php");
$page_nav["akademik"]["sub"]["tenagapendidik"]["active"] = true;
include("inc/nav.php");
echo "<div id='main' role='main'>";
$breadcrumbs["Akademik"] = "";
include("inc/ribbon.php");	
$sub=(isset($_GET['sub']))?$_GET['sub']:"";
switch($sub)
{
	case "tampil":default:

		$gaktif=isset($_GET['gaktif'])?$_GET['gaktif']:"";
		$jengur=isset($_GET['jengur'])?$_GET['jengur']:"";
		$jk=isset($_GET['jk'])?$_GET['jk']:"";
		
		$FormPilih.="
		<form action='?page=$page' method='post' name='frmPilih' class='form-inline' role='form'>
			<div class='row'>
				<div class='col-sm-12 col-md-8'>
					<div class='form-group'>Pililh Data &nbsp;&nbsp;</div>";
					$FormPilih.=FormCR("inline",'Keaktifan','txtAktif',$gaktif,$Ref->AktifGuru,'',"onchange=\"document.location.href='?page=$page&gaktif='+document.frmPilih.txtAktif.value\"");
					if(!empty($_GET['gaktif'])){
						$FormPilih.=FormCF("inline","Jenig Guru","txtJengur","select jenisguru from app_user_guru where jenisguru group by jenisguru","jenisguru",$jengur,"jenisguru","","onchange=\"document.location.href='?page=$page&gaktif='+document.frmPilih.txtAktif.value+'&jengur='+document.frmPilih.txtJengur.value\"");
					}
					if(!empty($_GET['jengur'])){
						$FormPilih.=FormCF("inline","Jenis kelamin","txtJenKel","select jk from app_user_guru group by jk","jk",$jk,"jk","","onchange=\"document.location.href='?page=$page&gaktif='+document.frmPilih.txtAktif.value+'&jengur='+document.frmPilih.txtJengur.value+'&jk='+document.frmPilih.txtJenKel.value\"");
					}
		$FormPilih.="
				</div>
				<div class='col-sm-12 col-md-4'>
				<!-- <button type='button' id='tambahptk' title='Tambah PTK' class='btn btn-info btn-sm pull-right' data-toggle='modal' data-target='#TambahPTK'><i class='fa fa-plus'></i> Tambah PTK</button> -->
				</div>
			</div>
		</form>";

		if($_GET['gaktif']=="Semua"){$wh="";} 
		else if(!empty($_GET['gaktif'])){$wh=" where aktif='$gaktif' ";} 
		else{$wh=" where aktif='Aktif' ";}

		if($_GET['gaktif']=="Semua" && !empty($_GET['jengur'])){$wh=" where jenisguru='$jengur' ";}
		else if(!empty($_GET['gaktif']) && !empty($_GET['jengur'])){$wh=" where aktif='$gaktif' and jenisguru='$jengur' ";}

		if($_GET['gaktif']=="Semua" && !empty($_GET['jengur']) && !empty($_GET['jk'])){$wh=" where jenisguru='$jengur' and jk='$jk'";}
		else if(!empty($_GET['gaktif']) && !empty($_GET['jengur']) && !empty($_GET['jk'])){$wh=" where aktif='$gaktif' and jenisguru='$jengur' and jk='$jk'";}

		$Q="SELECT * from app_user_guru $wh";
		$no=1;
		$Query=mysql_query("$Q order by nama_lengkap");
		while($Hasil=mysql_fetch_array($Query)){
			$QBioGuru=mysql_query("select * from app_user_guru inner join app_user_guru_bio on app_user_guru.id_guru=app_user_guru_bio.id_guru where app_user_guru.id_guru='$Hasil[id_guru]'");
			$HBioGuru=mysql_fetch_array($QBioGuru);

			if($Hasil['aktif']=="Aktif"){
				$PTKAktif="<i class='txt-color-blue fa fa-check font-lg'></i>";}
			else{
				$PTKAktif="<i class='txt-color-red fa fa-close font-lg'></i>";}
			
			$TampilData.="
			<tr>
				<td class='text-center'>$no.</td>
				<td>{$PTKAktif}</td>
				<td>{$Hasil['nama_lengkap']}</td>
				<td>{$Hasil['nip']}</td>
				<td>{$Hasil['jk']}</td>
				<td align='center' width='100'>
					<a data-toggle='modal' href='?page=$page&amp;aksi=edit&amp;Kode={$Hasil['id_guru']}'><i class='txt-color-blue fa fa-edit font-lg'></i></a></td>
			</tr>";
			$no++;
		}

		$jmldata=mysql_num_rows($Query);
		if($jmldata>0){
			if(!empty($_GET['jengur'])){
				$Infona.="<span class='label bg-color-redLight'>Jenis Guru <strong>{$jengur}</strong></span> ";
			}
			if(!empty($_GET['jk'])){
				$Infona.="<span class='label bg-color-redLight'>Jenis Kelamin <strong>{$jk}</strong></span> ";
			}
			if(!empty($_GET['gaktif'])){
				$Infona.="<span class='label bg-color-redLight'>Status Guru<strong>{$gaktif}</strong></span> ";
			}

			$Show.=KolomPanel($FormPilih);

			$Show.="$Infona <span class='label bg-color-redLight'>Total <b>$jmldata (".terbilang($jmldata).")</b> orang </span><br><br>";
			$ListPTK.="
			<div class='well no-padding'>
				<table id='dt_basic' class='table table-striped table-bordered table-condensed' width='100%'>
					<thead>
						<tr>
							<th class='text-center' data-class='expand'>No.</th>
							<th class='text-center'>Aktif</th>
							<th class='text-center'>Nama Lengkap</th>
							<th class='text-center' data-hide='phone,tablet'>NIP</th>
							<th class='text-center' data-hide='phone,tablet'>JK</th>
							<th class='text-center'>Aksi</th>
						</tr>
					</thead>
					<tbody>$TampilData</tbody>
				</table>
			</div>";
			
			$Show.=FormModalEdit(
				"sedang",
				"NgeditGuru", 
				"<i class='fa fa-edit'></i> Edit Data PTK",
				"?page=$page&sub=simpanedit",
				"form-horizontal",
				"bodyNgeditGuru",
				"ngeditptk",
				"Simpan");

			$TambahPTK.=JudulKolom('Tambah PTK','plus');	
			$TambahPTK.="<p>Menambah Tenaga Pendidik bisa melalui impor Tenaga Pendidik ke MYSQL di Menu <a href='?page=tools-impor-datamaster&sub=ngapload&aksi=ptk' class='label bg-color-blue'>Tools <i class='fa fa-angle-double-right fa-fw'></i> Impor <i class='fa fa-angle-double-right fa-fw'></i> Tenaga Pendidik</a></p><hr>";
			$TambahPTK.=$PesanError;
			$TambahPTK.="<form action='?page=$page&sub=simpantambah' method='post' name='frmTmbhGuru' class='form-horizontal' role='form'>";
			$TambahPTK.='<fieldset>';
			$TambahPTK.='<input type="hidden" name="txtWLogin">';
			$TambahPTK.='<input type="hidden" name="txtWLogout">';
			$TambahPTK.='<input type="hidden" name="txtJmlLogin">';
			$TambahPTK.='<input type="hidden" name="txtPhoto">';
			$TambahPTK.=FormIF("horizontal","NIP", "txtNIP","",'5',"");
			$TambahPTK.=FormIF("horizontal","Gelar Depan", "txtGelarDepan","",'4',"");
			$TambahPTK.=FormIF("horizontal","Nama Lengkap", "txtNama","",'8',"");
			$TambahPTK.=FormIF("horizontal","Gelar Belakang", "txtGelarBelakang","",'4',"");
			$TambahPTK.=FormIF("horizontal","User ID", "txtUserID","",'6',"");
			$TambahPTK.=FormIF("horizontal","Password ", "txtKataKunci","",'6',"");
			$TambahPTK.=FormCR("horizontal",'Level User','txtHak',$hak,$Ref->LevelUserGuru,'4',"");
			$TambahPTK.=FormCR("horizontal",'Jenis Kelamin','txtJenKel',$jk,$Ref->Gender,'4',"");
			$TambahPTK.=FormCR("horizontal",'Jenis Guru','txtJenisGuru',$jenisguru,$Ref->JenisGuru,'4',"");
			$TambahPTK.=FormCR("horizontal",'Aktif','txtAktif',$aktif,$Ref->Aktif,'4',"");
			$TambahPTK.=FormIF("horizontal","Keterangan", "txtKeterangan","",'8',"");
			$TambahPTK.='</fieldset>';
			$TambahPTK.='<div class="form-actions">'.iSubmit("BtnTambah","Simpan").'</div>';
			$TambahPTK.='</form>';

			$Show.=FormModalAksi(
				"TambahPTK",
				"Tambah Data PTK",
				"<form action='?page=$page&sub=simpantambah' method='post' name='frmTmbhGuru' class='form-horizontal' role='form'>$TambahPTK",
				"nambahptk",
				"Simpan");

				$Kode=isset($_GET['Kode'])?$_GET['Kode']:""; 
				NgambilData("SELECT * FROM app_user_guru WHERE id_guru='$Kode'");

			$EditPTK.="<a data-toggle='modal' href='#DetailGuru' id='$id_guru' class='tmpldetailguru btn btn-default pull-right' style='margin-top:-10px;'>Detail PTK</a>";
			$EditPTK.=JudulKolom('Edit PTK','pencil-square-o');
			$EditPTK.="<form action='?page=$page&sub=simpanedit' method='post' name='frmEditGuru' class='form-horizontal' role='form'>";
			$EditPTK.='<fieldset>';
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
			$EditPTK.='</fieldset>';
			$EditPTK.='<div class="form-actions">';
			$EditPTK.=iSubmit("EditPTK","Simpan")." <a href='?page=$page' class='btn btn-danger btn-sm'>Batal</a>";
			$EditPTK.='</div>';
			$EditPTK.='</form>';


			$aksi=isset($_GET['aksi'])?$_GET['aksi']:"";

			if($aksi==""){
				$ined=$TambahPTK;}
			else if($aksi=="edit"){
				$ined=$EditPTK;}
			
			$Show.=FormModalDetail("DetailGuru","Detail PTK","bodyDetailGuru");
			
			$Show.=DuaKolomD(7,$ListPTK,5,KolomPanel($ined));

		}
		else{
			$Show.=KolomPanel($FormPilih);
			$Show.=nt("informasi","Data Tenaga Pendidik belum ada. <br>Silakan tambah Tenaga Pendidik. atau klik tombol di bawah ini untuk impor Tenaga Pendidik<br><a href='?page=tools-excel-ptk' class='btn btn-info btn-sm'>Impor Tenaga Pendidik</a>");
		}

		echo $DataPTK;
		$tandamodal="#DataPTK";
		echo MyWidget('fa-user-o',"Daftar Tenaga Pendidik","",$Show);
	break;

	case "simpantambah":
		$message=array();
		if(trim($_POST['txtNIP'])==""){$message[]="NIP tidak boleh kosong !";}
		if(trim($_POST['txtGelarDepan'])==""){$message[]="Gelar Depan tidak boleh kosong !";}
		if(trim($_POST['txtNama'])==""){$message[]="Nama Guru tidak boleh kosong !";}
		if(trim($_POST['txtGelarBelakang'])==""){$message[]="Gelar Belakang tidak boleh kosong !";}
		if(trim($_POST['txtUserID'])==""){$message[]="User ID tidak boleh kosong !";}
		if(trim($_POST['txtKataKunci'])==""){$message[]="Password tidak boleh kosong !";}
		if(trim($_POST['txtHak'])==""){$message[]="Level User harus di PILIH !";}
		if(trim($_POST['txtJenKel'])==""){$message[]="Jenis Kelamin harus di PILIH !";}
		if(trim($_POST['txtJenisGuru'])==""){$message[]="Jenis Guru harus di PILIH !";}
		if(!count($message)==0){
			$Num=0;
			foreach($message as $indeks=>$pesan_tampil){
				$Num++;
				$Pesannya.="$Num. $pesan_tampil<br>";
			}
			echo Peringatan("$Pesannya","parent.location='?page=$page'");
		}
		else{
			$kd_guru=buatKode("user_guru","guru");
			$txtNIP=addslashes($_POST['txtNIP']);
			$txtGelarDepan=addslashes($_POST['txtGelarDepan']);
			$txtNama=addslashes($_POST['txtNama']);
			$txtGelarBelakang=addslashes($_POST['txtGelarBelakang']);
			$txtUserID=addslashes($_POST['txtUserID']);
			$txtKataKunci=addslashes($_POST['txtKataKunci']);
			$txtHak=addslashes($_POST['txtHak']);
			$txtJenKel=addslashes($_POST['txtJenKel']);
			$txtJenisGuru=addslashes($_POST['txtJenisGuru']);
			$txtAktif=addslashes($_POST['txtAktif']);
			$txtKeterangan=addslashes($_POST['txtKeterangan']);
			$txtWLogin=addslashes($_POST['txtWLogin']);
			$txtWLogout=addslashes($_POST['txtWLogout']);
			$txtJmlLogin=addslashes($_POST['txtJmlLogin']);
			$txtPhoto=addslashes($_POST['txtPhoto']);
			mysql_query("INSERT INTO app_user_guru VALUES ( '$kd_guru','$txtNIP','$txtGelarDepan','".htmlentities($txtNama,ENT_QUOTES)."','$txtGelarBelakang','$txtUserID',md5('$txtKataKunci'), '$txtHak','$txtJenKel','$txtJenisGuru','$txtKataKunci','$txtWLogin','$txtWLogout','$txtJmlLogin','$txtPhoto','$txtAktif','$txtKeterangan')");
			echo ns("Nambah","parent.location='?page=$page'","<span class='text-primary'><strong>$txtNama </strong></span>");
		}
	break;

	case "simpanedit":
		$txtKodes=addslashes($_POST['txtKodes']);
		$txtNIP=addslashes($_POST['txtNIP']);
		$txtGelarDepan=addslashes($_POST['txtGelarDepan']);
		$txtNama=addslashes($_POST['txtNama']);
		$txtGelarBelakang=addslashes($_POST['txtGelarBelakang']);
		$txtUserID=addslashes($_POST['txtUserID']);
		$txtKataKunci=addslashes($_POST['txtKataKunci']);
		$txtHak=addslashes($_POST['txtHak']);
		$txtJenKel=addslashes($_POST['txtJenKel']);
		$txtJenisGuru=addslashes($_POST['txtJenisGuru']);
		$txtWLogin=addslashes($_POST['txtWLogin']);
		$txtWLogout=addslashes($_POST['txtWLogout']);
		$txtJmlLogin=addslashes($_POST['txtJmlLogin']);
		$txtAKtif=addslashes($_POST['txtAKtif']);
		$txtKeterangan=addslashes($_POST['txtKeterangan']);
		mysql_query("UPDATE app_user_guru SET nip='$txtNIP', gelardepan='$txtGelarDepan',nama_lengkap='$txtNama',gelarbelakang='$txtGelarBelakang', userid='$txtUserID', katakunci=md5('$txtKataKunci'), hak='$txtHak', jk='$txtJenKel', jenisguru='$txtJenisGuru',ket='$txtKataKunci',waktu_login='$txtWLogin',waktu_logout='$txtWLogout',kunjung='$txtJmlLogin',photo='',aktif='$txtAKtif',keterangan='$txtKeterangan' WHERE id_guru='$txtKodes'");
		echo ns("Ngedit","parent.location='?page=$page'","Guru");
	break;

	case "hapus":
		mysql_query("DELETE FROM app_user_guru WHERE id_guru='".$_GET['Kode']."'");
		echo ns("Hapus","parent.location='?page=$page'","Guru");
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

	$('.tmpldetailguru').click(function(){
		var id = $(this).attr("id");
		$.ajax({
			url: 'lib/app_modal.php?md=DetailProfilPTK',
			method: 'post',
			data: {id:id},
			success:function(data){
				$('#bodyDetailGuru').html(data);
				$('#DetailGuru').modal("show");
			}
		});
	});

	$('.tmplngeditguru').click(function(){
		var id = $(this).attr("id");
		$.ajax({
			url: 'lib/app_modal.php?md=EditDataPTK',
			method: 'post',
			data: {id:id},
			success:function(data){
				$('#bodyNgeditGuru').html(data);
				$('#NgeditGuru').modal("show");
			}
		});
	});
})
</script>