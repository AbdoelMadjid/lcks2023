<?php
/* 12/6/2016 --> Sabtu, 28 Januari 2017 13.10.40 --> 07/01/2023 18:42
Design and Programming By. Abdul Madjid, S.Pd., M.Pd.
SMK Negeri 1 Kadipaten
Pin 520543F3 HP. 0812-3000-0420
https://twitter.com/AbdoelMadjid 
https://www.facebook.com/abdulmadjid.mpd
*/
//eval(base64_decode("
require_once("inc/init.php");
require_once("inc/config.ui.php");
$page_title = "Profil";
$page_css[] = "your_style.css";
include("inc/header.php");
$page_nav["profil"]["active"] = true;
include("inc/nav.php");
echo "<div id='main' role='main'>";
$breadcrumbs["Master"] = "";
include("inc/ribbon.php");
$sub=(isset($_GET['sub']))?$_GET['sub']:"";
switch($sub)
{
	case "tampil":default:
		
		$QUsr = mysql_query("SELECT * FROM app_users order by id_user");  
		$JUsers = JmlDt("SELECT * FROM app_users order by id_user");
		
		$no=1;	
		while ($HUsr=mysql_fetch_array($QUsr)) {
			$TmpDataUsers.="
				<tr>
					<td class='text-center'>$no.</td>
					<td>".$HUsr['nama_lengkap']."</td>
					<td>".$HUsr['userid']."</td>
					<td>".$HUsr['hak']."</td>
					<td><a href='?page=$page&aksi=editadmin&adm=".$HUsr['id_user']."'><i class='txt-color-red fa fa-edit font-lg'></i></a>&nbsp;&nbsp;
						<a href='?page=$page&sub=hapus&adm=".$HUsr['id_user']."' data-action='hapusadm' data-hapusadm-msg=\"Apakah Anda yakin akan mengapus <strong class='text-primary'>".$HUsr['nama_lengkap']."</strong> sebagai ".$HUsr['hak']."\"><i class='txt-color-red fa fa-trash-o font-lg'></i></a>								
					</td>
				</tr>";
			$no++;
		}

		if($JUsers>0){
			$DataUsers.=JudulKolom('Daftar Pengguna','list');
			$DataUsers.="
			<div class='well no-padding' style='margin:-15px -15px -15px -15px;'>
				<table id='dt_basic' class='table table-striped table-bordered table-condensed' width='100%'>
					<thead>
						<tr>
							<th class='text-center' data-class='expand'>No.</th>
							<th>Nama Lengkap</th>
							<th data-hide='phone,tablet'>User ID</th>
							<th data-hide='phone,tablet'>Hak</th>
							<th>Aksi</th>
						</tr>
					<thead>
					<tbody>$TmpDataUsers</tbody>
				</table>
			</div>";
		}
		else{
			$DataUsers.=JudulKolom('Daftar Pengguna','list');
			$DataUsers.=nt("informasi","Data Pengguna belum di tambahkan","");
		}

	// FORM TAMBAH PENGGUNA
		$TambahUsers.=JudulKolom('Tambah Pengguna','plus');
		$TambahUsers.="<form action='?page=$page&sub=simpantambah' method='post' name='frmAdAdmin' class='form-horizontal' role='form'>";
		$TambahUsers.='<fieldset>';
		$TambahUsers.=FormIF("horizontal","Nama Lengkap", "txtNama","",'6','');
		$TambahUsers.=FormCR("horizontal",'Jenis Kelamin','txtJenKel',"",$Ref->Gender,'4','');		
		$TambahUsers.=FormIF("horizontal","User ID", "txtUserID","",'4','');
		$TambahUsers.=FormIF("horizontal","Password", "txtPassword","",'4','');
		$TambahUsers.=FormCR("horizontal",'Hak','txtHak',"",$Ref->LevelAdmin,'4','');		
		$TambahUsers.='</fieldset>';
		$TambahUsers.='<div class="form-actions">';
		$TambahUsers.=iSubmit("BtnTambahUsers","Simpan");
		$TambahUsers.='</div>';
		$TambahUsers.="</form>";		

	//FORM EDIT PENGGUNA
		$adm=(isset($_GET['adm']))?$_GET['adm']:"";
		NgambilData("select * from app_users where id_user='$adm'");
		
		$EditUsers.=JudulKolom('Edit Administrator','pencil-square-o');
		$EditUsers.="<form action='?page=$page&sub=simpaneditadmin' method='post' name='frmadd' class='form-horizontal' role='form'>";
		$EditUsers.='<fieldset>';
		$EditUsers.=FormIF("horizontal","ID User", "txtID",$id_user,'3','readonly=readonly');
		$EditUsers.=FormIF("horizontal","Nama Lengkap", "txtNama",$nama_lengkap,'6','');
		$EditUsers.=FormCR("horizontal",'Jenis Kelamin','txtJenKel',$jk,$Ref->Gender,'3','');		
		$EditUsers.=FormIF("horizontal","User ID", "txtUserID",$userid,'4','');
		$EditUsers.=FormIF("horizontal","Password", "txtPassword",$ket,'4','');
		$EditUsers.=FormCR("horizontal",'Hak','txtHak',$hak,$Ref->LevelAdmin,'4','');		/**/
		$EditUsers.='</fieldset>';
		$EditUsers.='<div class="form-actions">';
		$EditUsers.=iSubmit("BtnEditAdmin","Simpan")." <a href='?page=$page' class='btn btn-danger btn-sm'>Batal</a>";
		$EditUsers.='</div>';
		$EditUsers.="</form>";

		$aksi=isset($_GET['aksi'])?$_GET['aksi']:"";
		if($aksi==""){
			$Show=$TambahUsers;
		}
		else if($aksi=="editadmin"){
			$Show=$EditUsers;
		}

		$Tampilkan=DuaKolom(KolomPanel($DataUsers),KolomPanel($Show));
		echo $CukupJelas;
		$tandamodal="#CukupJelas";
		echo MyWidget('fa-user-circle-o',$page_title." <i class='ultra-light'>Pengguna</i>","",$Tampilkan);
	break;

	case "simpantambah":
		$message=array();
		if(trim($_POST['txtNama'])==""){$message[]="Nama tidak boleh kosong !";}
		if(trim($_POST['txtJenKel'])==""){$message[]="Jenis Kelamih belum dipilih !";}
		if(trim($_POST['txtUserID'])==""){$message[]="User ID tidak boleh kosong !";}
		if(trim($_POST['txtPassword'])==""){$message[]="Password tidak boleh kosong !";}
		if(trim($_POST['txtHak'])==""){$message[]="Hak tidak boleh kosong !";}
		if(!count($message)==0){
			$Num=0;
			foreach($message as $indeks=>$pesan_tampil){
				$Num++;
				$Pesannya.="$Num. $pesan_tampil<br>";
			} 
			echo Peringatan("$Pesannya","parent.location='?page=$page'");
		}
		else{
			$kd_admin=buatKode("app_users","adm_");
			$txtNama=addslashes($_POST['txtNama']);
			$txtJenKel=addslashes($_POST['txtJenKel']);
			$txtUserID=addslashes($_POST['txtUserID']);
			$txtPassword=addslashes($_POST['txtPassword']);
			$txtHak=addslashes($_POST['txtHak']);
			$sqlSave="INSERT INTO app_users VALUES('$kd_admin','$txtNama','$txtUserID',md5('$txtPassword'),'$txtHak','$txtPassword','$txtJenKel','0000-00-00 00:00:00','0000-00-00 00:00:00','0')";
			$qrySave=mysql_query($sqlSave);
			if($qrySave){
				echo ns("Nambah","parent.location='?page=$page'","User");
			}
		}
	break;

	case "simpaneditadmin":
		$txtID=addslashes($_POST['txtID']);
		$txtNama=addslashes($_POST['txtNama']);
		$txtJenKel=addslashes($_POST['txtJenKel']);
		$txtUserID=addslashes($_POST['txtUserID']);
		$txtPassword=addslashes($_POST['txtPassword']);
		$txtHak=addslashes($_POST['txtHak']);
		$sqlSave="UPDATE app_users SET nama_lengkap='$txtNama',userid='$txtUserID',katakunci=md5('$txtPassword'), hak='$txtHak',ket='$txtPassword',jk='$txtJenKel' WHERE id_user='$txtID'";
		$qrySave=mysql_query($sqlSave);
		if($qrySave){
			echo ns("Ngedit","parent.location='?page=$page'","Username <strong>$txtUserID</strong>");
		}
	break;
	case "hapus":
		if(empty($_GET['adm'])){echo "<b>Data yang dihapus tidak ada</b>";}
		else{
			mysql_query("DELETE FROM pilih_belakang_ijazah WHERE id_pil='".$_GET['adm']."'");
			mysql_query("DELETE FROM pilih_cetak WHERE id_pil='".$_GET['adm']."'");
			mysql_query("DELETE FROM pilih_kbm WHERE id_pil='".$_GET['adm']."'");
			mysql_query("DELETE FROM pilih_kbm_guru WHERE id_pil='".$_GET['adm']."'");
			mysql_query("DELETE FROM pilih_kbm_kurikulum WHERE id_pil='".$_GET['adm']."'");
			mysql_query("DELETE FROM pilih_kelas WHERE id_pil='".$_GET['adm']."'");
			mysql_query("DELETE FROM pilih_trans WHERE id_pil='".$_GET['adm']."'");
			mysql_query("DELETE FROM pilih_ujian WHERE id_pil='".$_GET['adm']."'");
			$sqlDelete="DELETE FROM app_users WHERE id_user='".$_GET['adm']."'";
			$qryDelete=mysql_query($sqlDelete) or die ("Eror hapus data".mysql_error());
			if($qryDelete){
				echo ns("Hapus","parent.location='?page=$page'","User");
			}
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
	var a={
		"hapusadm":function(a){
			function b(){
				window.location=a.attr("href")
			}
			$.SmartMessageBox(
				{
					"title":"<h1 style='margin-top:-5px;'><i class='fa fa-fw fa-question-circle bounce animated text-primary'></i><small class='text-primary'><strong> Konfirmasi</strong></small></h1>",
					"content":a.data("hapusadm-msg"),
					"buttons":"[No][Yes]"
				},function(a){
					"Yes"==a&&($.root_.addClass("animated fadeOutUp"),setTimeout(b,1e3))
					}
		)}
	}
	$.root_.on("click",'[data-action="hapusadm"]',function(b){var c=$(this);a.hapusadm(c),b.preventDefault(),c=null});

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