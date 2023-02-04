<?php
require_once("inc/init.php");
require_once("inc/config.ui.php");
$page_title = "Paket Keahlian";
$page_css[] = "your_style.css";
include("inc/header.php");
$page_nav["akademik"]["sub"]["paketkeahlian"]["active"] = true;
include("inc/nav.php");
echo "<div id='main' role='main'>";
$breadcrumbs["Akademik"] = "";
include("inc/ribbon.php");	
$sub=(isset($_GET['sub']))?$_GET['sub']:"";
switch($sub)
{
	case "tampil":default:
		$Q=mysql_query("SELECT * FROM ak_paketkeahlian,ak_programkeahlian,ak_bidangkeahlian WHERE ak_bidangkeahlian.kode_bidang=ak_programkeahlian.kode_bidang AND ak_programkeahlian.kode_program=ak_paketkeahlian.kode_program AND ak_programkeahlian.kode_bidang=ak_paketkeahlian.kode_bidang order by id asc");
		$no=1;
		while($Hasil=mysql_fetch_array($Q)){
			$DataPaket="";
			$TampilData.="
			<tr>
				<td class='text-center'>$no.</td>
				<td><strong>(".$Hasil['kode_program'].")</strong> ". $Hasil['nama_program']."</td>
				<td><strong>(".$Hasil['kode_bidang'].")</strong> ".$Hasil['nama_bidang']."</td>
				<td>".$Hasil['kode_pk']."</td>
				<td><a href='?page=$page&Kode={$Hasil['id']}'>".$Hasil['nama_paket']."</a></td>
				<td>".$Hasil['singkatan']."</td>
			</tr>";
			$no++;
		}
		$jmldata=mysql_num_rows($Q);
		if($jmldata>0){
			$ListPK.=JudulKolom("Daftar Paket Keahlian","list");
			$ListPK.="
			<div class='well no-padding' style='margin:-15px -15px -15px -15px;'>
				<table id='dt_basic' class='table table-striped table-bordered table-hover table-condensed' width='100%'>
					<thead>
						<tr>
							<th class='text-center' data-class='expand'>No.</th>
							<th class='text-center' data-hide='phone,tablet'>Program Keahlian</th>
							<th class='text-center' data-hide='phone,tablet'>Bidang Keahlian</th>
							<th class='text-center' data-hide='phone,tablet'>Kode Paket</th>
							<th class='text-center' >Paket Keahlian</th>
							<th class='text-center' data-hide='phone,tablet'>Singkatan</th>
						</tr>
					</thead>
					<tbody>$TampilData</tbody>
				</table>
			</div>";
		}
		else{
			$ListPK.=nt("peringatan","Data Peket Keahlian masih kosong","");
		}

		// Form Tambah Paket Keahlian
		$IsiFormTambah.="<script src='".ASSETS_URL."/js/myjs/ak-paket-keahlian.js'></script>";
		$IsiFormTambah.=JudulKolom("Tambah Paket Keahlian","plus");
		$IsiFormTambah.="<form action='?page=$page&sub=simpantambah' method='post' name='frmTambahPK' class='form-horizontal' role='form'>";
		$IsiFormTambah.='<fieldset>';
		$IsiFormTambah.=FormIF("horizontal","Kode Paket","txtKodePaket","",'2',"");
		$IsiFormTambah.=FormCF("horizontal",'Bidang Keahlian','txtBidang','select * from ak_bidangkeahlian group by kode_bidang','kode_bidang',$kode_bidang,'nama_bidang','6','onchange=TampilProgAhli(this.value)');
		$IsiFormTambah.="<div id='txtHint'></div>";
		$IsiFormTambah.=FormIF("horizontal","Paket Keahlian","txtNamaPaket","",'5',"");
		$IsiFormTambah.=FormIF("horizontal","Singkatan","txtSingkatan","",'2',"");
		$IsiFormTambah.='</fieldset>';
		$IsiFormTambah.='</fieldset>';
		$IsiFormTambah.='<div class="form-actions">';
		$IsiFormTambah.=iSubmit("TambahPK","Simpan");
		$IsiFormTambah.='</div>';
		$IsiFormTambah.="</form>";

		// Form Edit Paket Keahlian
		$KodeEdit=isset($_GET['Kode'])?$_GET['Kode']:""; 
		NgambilData("SELECT * FROM ak_paketkeahlian, ak_programkeahlian, ak_bidangkeahlian WHERE ak_bidangkeahlian.kode_bidang=ak_programkeahlian.kode_bidang AND ak_programkeahlian.kode_program=ak_paketkeahlian.kode_program AND ak_programkeahlian.kode_bidang=ak_paketkeahlian.kode_bidang AND ak_paketkeahlian.id='$KodeEdit'");
		$IsiFormEdit.=JudulKolom("Edit Paket Keahlian","pencil-square-o");
		$IsiFormEdit.="<form action='?page=$page&sub=simpanedit' method='post' name='frmEditPK' class='form-horizontal' role='form'>";
		$IsiFormEdit.='<fieldset>';
		$IsiFormEdit.="<input type='hidden' class='form-control' name='txtKode' value='$id' size='60' maxlength='60'/>";
		$IsiFormEdit.=FormIF("horizontal","Kode Paket","txtKodePaket",$kode_pk,'2',"");
		$IsiFormEdit.=FormCF("horizontal",'Bidang Keahlian','txtBidang','select * from ak_bidangkeahlian','kode_bidang',$kode_bidang,'nama_bidang','6',"");
		$IsiFormEdit.=FormCF("horizontal",'Program Keahlian','txtProgram','select * from ak_programkeahlian','kode_program',$kode_program,'nama_program','6',"");
		$IsiFormEdit.=FormIF("horizontal","Paket Keahlian","txtNamaPaket",$nama_paket,'8',"");
		$IsiFormEdit.=FormIF("horizontal","Singkatan","txtSingkatan",$singkatan,'2',"");
		$IsiFormEdit.='</fieldset>';
		$IsiFormEdit.='<div class="form-actions">';
		$IsiFormEdit.=iSubmit("EditPK","Simpan")." <a href='?page=$page' class='btn btn-danger btn-sm'>Batal</a>";
		$IsiFormEdit.='</div>';
		$IsiFormEdit.="</form>";

		if($KodeEdit==""){$ined=$IsiFormTambah;}else{$ined=$IsiFormEdit;}

		$Show=DuaKolomD(7,KolomPanel($ListPK),5,KolomPanel($ined));

		$tandamodal="#DataPK";
		echo $DataPK;
		echo MyWidget('fa-sitemap',$page_title,"",$Show);
	break;

	case "simpantambah":
		$message=array();
		NgambilData("select * from ak_paketkeahlian where kode_pk='".trim($_POST['txtKodePaket'])."'");
		if(trim($_POST['txtKodePaket'])==$kode_pk) {$message[]="Kode Paket Keahlian sudah ada!"; }
		if(trim($_POST['txtKodePaket'])=="") {$message[]="Kode Paket Keahlian tidak boleh kosong !"; }
		if(trim($_POST['txtNamaPaket'])=="") {$message[]="Nama Paket Keahlian tidak boleh kosong !"; }
		if(trim($_POST['txtSingkatan'])=="") {$message[]="Singkatan Paket Keahlian tidak boleh kosong !"; }
		if(!count($message)==0){
			$Num=0;
			foreach($message as $indeks=>$pesan_tampil){
				$Num++;
				$Pesannya.="&nbsp;&nbsp;$Num. $pesan_tampil<br>";
			}
			echo Peringatan("$Pesannya","parent.location='?page=$page'");
		}
		else{
			$txtKodePaket=addslashes($_POST['txtKodePaket']);
			$txtBidang=addslashes($_POST['txtBidang']);
			$txtProgram=addslashes($_POST['txtProgram']);
			$txtNamaPaket=addslashes($_POST['txtNamaPaket']);
			$txtSingkatan=addslashes($_POST['txtSingkatan']);
			mysql_query("INSERT INTO ak_paketkeahlian VALUES ('','$txtKodePaket','$txtBidang','$txtProgram','$txtNamaPaket','$txtSingkatan')");
			echo ns("Nambah","parent.location='?page=$page'","Paket Kaehlian");
		}
	break;

	case "simpanedit":
		$txtKode=addslashes($_POST['txtKode']);
		$txtKodePaket=addslashes($_POST['txtKodePaket']);
		$txtBidang=addslashes($_POST['txtBidang']);
		$txtProgram=addslashes($_POST['txtProgram']);
		$txtNamaPaket=addslashes($_POST['txtNamaPaket']);
		$txtSingkatan=addslashes($_POST['txtSingkatan']);
		mysql_query("UPDATE ak_paketkeahlian SET kode_pk='$txtKodePaket', kode_bidang='$txtBidang', kode_program='$txtProgram', nama_paket='$txtNamaPaket', singkatan='$txtSingkatan' WHERE id='".$_POST['txtKode']."'");
		echo ns("Ngedit","parent.location='?page=$page'","Paket Keahlian");
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

})
</script>