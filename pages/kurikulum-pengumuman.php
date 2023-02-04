<?php
require_once("inc/init.php");
require_once("inc/config.ui.php");
$page_title = "Pengumuman";
$page_css[] = "your_style.css";
include("inc/header.php");
$page_nav["kurikulum"]["sub"]["pengumuman"]["active"] = true;
include("inc/nav.php");
echo "<div id='main' role='main'>";
$breadcrumbs["Kurikulum"] = "";
include("inc/ribbon.php");	
$sub=(isset($_GET['sub']))?$_GET['sub']:"";
switch($sub)
{
	case "tampil":default:
		$QVK=mysql_query("select * from kur_informasi order by thnajaran desc");
		$no=1;
		while($isi=mysql_fetch_array($QVK)){
			if($isi['aktif']=="Y") {
				$tandana="<a href='?page=$page&sub=prosesinfo&nonaktifkan={$isi[id]}' alt='Aktifkan'><i class='fa fa-check-square-o font-lg'></i></a>";
			}
			else{
				$tandana="<a href='?page=$page&sub=prosesinfo&aktifkan={$isi[id]}' alt='Aktifkan'><i class='txt-color-red fa fa-square-o font-lg'></i></a>";
			}

			$TmpVK.="
			<tr>
				<td class='text-center'>$no.</td>
				<td>$tandana </td>
				<td width=75>".$isi["thnajaran"]."</td>
				<td>".$isi["info"]."</td>
				<td class='text-center' width=75>
					<a href='?page=$page&idna={$isi['id']}'><i class='txt-color-blue fa fa-pencil-square-o font-lg'></i></a> <a href='?page=$page&amp;sub=hapus&amp;dvk={$isi['id']}' data-action='hapusvk' data-hapusvk-msg=\"Apakah Anda yakin akan mengapus <strong class='text-primary'> Pengumuman/Informasi Tahun {$isi['thnajaran']}</strong> ?\"><i class='txt-color-red fa fa-trash-o font-lg'></i></a>
				</td>
			</tr>";
			$no++;
		}
		$JmlVK=mysql_num_rows($QVK);
		if($JmlVK==0) {$DataVer.=nt("informasi","Data Pengumuman belum di tambahkan");}
		else{
			$DataVer.=JudulKolom("List Pengumuman","th-list");
			$DataVer.="
			<div class='well no-padding' style='margin:-15px -15px -15px -15px;'>
				<table id='dt_basic' class='table table-striped table-bordered table-condensed' width='100%'>					
					<thead>
						<tr>
							<th class='text-center' data-class='expand'>No.</th>
							<th class='text-center'>Aktif</th>
							<th class='text-center' colspan='2'>Informasi</th>
							<th class='text-center' data-hide='phone,tablet'>Aksi</th>
						</tr>
					</thead>
					<tbody>$TmpVK</tbody>
				</table>
			</div>";
		}
		
		$IsiForm2.='
		<fieldset>
			<div class="textarea-div">
				<div class="typearea">
					<textarea placeholder="Tulis informasi di sini..." id="textarea-expand" name="txtInfo" class="custom-scroll"></textarea>
				</div>
			</div>
			<span class="textarea-controls pull"><span class="pull-right">'.iSubmit("SimpanInfo","Simpan").'</span></span>
		<fieldset>';
		$TambahVK.=Label("<i class='txt-color-red fa fa-plus'></i> Tambah Informasi");
		$TambahVK.=FormAing($IsiForm2,"?page=$page&sub=prosesinfo","FrmTambahInfo");

		if(isset($_POST['EditInfor'])){
			$txtId=addslashes($_POST['txtId']);
			$txtInfo=addslashes($_POST['txtInfo']);
			$txtAktif=addslashes($_POST['txtAktif']);
			$sqlSave="UPDATE kur_informasi SET info='$txtInfo', aktif='$txtAktif' WHERE id='$txtId'";
			$qrySave=mysql_query($sqlSave);
			if($qrySave){
				echo ns("Ngedit","parent.location='?page=$page'","");
			}
		}	

		$InfoEdit=isset($_GET['idna'])?$_GET['idna']:""; 
		
		NgambilData("SELECT * FROM kur_informasi where id='$InfoEdit'");
		$IsiForm.=JudulKolom('Edit Informasi','edit');
		$IsiForm.="<form action='?page=$page' method='post' name='FrmEdit' class='form-horizontal' role='form'>";
		$IsiForm.='<fieldset>';
		$IsiForm.=FormIF("horizontal",'Id Info','txtId',$id,'2','readonly=readonly');
		$IsiForm.=FormIF("horizontal",'Tahun Ajaran','txtthnajar',$thnajaran,'4','readonly=readonly');
		$IsiForm.=FormTextAreaDB('Informasi','txtInfo',$info,'6');
		$IsiForm.=FormRBDBNY("Aktif","txtAktif",$aktif,"radio1","radio2");
		$IsiForm.='</fieldset>';
		$IsiForm.='<div class="form-actions">';
		$IsiForm.=iSubmit("EditInfor","Simpan")." <a href='?page=$page'class='btn btn-danger btn-sm'>Batal</a>";
		$IsiForm.='</div>';
		$IsiForm.='</form>';

		
		if($InfoEdit==""){$ined=$TambahVK;}else{$ined=$IsiForm;}
		$Tampilkan.=DuaKolomD(7,KolomPanel($DataVer),5,KolomPanel($ined));
		echo $KetInformasi;
		$tandamodal="#KetInformasi";
		echo MyWidget('fa-bullhorn',$page_title,"",$Tampilkan);
	break;
	
	case "prosesinfo":
		if(isset($_GET['nonaktifkan'])) {		
			$Ngaktifkeun=isset($_GET['nonaktifkan'])?$_GET['nonaktifkan']:""; 		
			$sqlSave="UPDATE kur_informasi SET aktif='N' WHERE id='$Ngaktifkeun'";
			$qrySave=mysql_query($sqlSave);
			if($qrySave){echo ns("NonAktif","parent.location='?page=$page'","");}
		}
		if(isset($_GET['aktifkan'])) {		
			$Ngaktifkeun=isset($_GET['aktifkan'])?$_GET['aktifkan']:""; 
			$sqlSave="UPDATE kur_informasi SET aktif='Y' WHERE id='$Ngaktifkeun'";
			$qrySave=mysql_query($sqlSave);
			if($qrySave){echo ns("Aktif","parent.location='?page=$page'","");}
		}
		if(isset($_POST['SimpanInfo'])){
			$message=array();
			if(trim($_POST['txtInfo'])==""){$message[]="Isian Informasi belum di isi!";}
			if(!count($message)==0){
				$Num=0;
				foreach($message as $indeks=>$pesan_tampil){
					$Num++;
					$Pesannya.="$Num. $pesan_tampil<br>";
				} 
				echo Peringatan("$Pesannya","parent.location='?page=$page'");
			}
			else{
				$txtInfo=addslashes($_POST['txtInfo']);
				$sqlSave="INSERT INTO kur_informasi VALUES ('','$TahunAjarAktif','$txtInfo','Y')";
				$qrySave=mysql_query($sqlSave);
				if($qrySave){echo ns("Nambah","parent.location='?page=$page'","");}
			}
		}	
	break;

	case "hapus":
		if(empty($_GET['dvk'])){echo "<b>Data yang dihapus tidak ada</b>";}
		else{
			$sqlDelete="DELETE FROM kur_informasi WHERE id='".$_GET['dvk']."'";
			$qryDelete=mysql_query($sqlDelete) or die ("Eror hapus data".mysql_error());
			if($qryDelete){echo ns("Hapus","parent.location='?page=$page'","");}
		}
	break;
}
echo "</div>";
include("inc/footer.php");
include("inc/scripts.php"); 
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
		"hapusvk":function(a){
			function b(){
				window.location=a.attr("href")
			}
			$.SmartMessageBox(
				{
					"title":"<h1 style='margin-top:-5px;'><i class='fa fa-fw fa-question-circle bounce animated text-primary'></i><small class='text-primary'><strong> Konfirmasi</strong></small></h1>",
					"content":a.data("hapusvk-msg"),
					"buttons":"[No][Yes]"
				},function(a){
					"Yes"==a&&($.root_.addClass("animated fadeOutUp"),setTimeout(b,1e3))
					}
		)}
	}

	$.root_.on("click",'[data-action="hapusvk"]',function(b){var c=$(this);a.hapusvk(c),b.preventDefault(),c=null});

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
});
</script>