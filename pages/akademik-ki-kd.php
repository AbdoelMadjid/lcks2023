<?php
require_once("inc/init.php");
require_once("inc/config.ui.php");
$page_title = "KI KD";
$page_css[] = "your_style.css";
include("inc/header.php");
$page_nav["akademik"]["sub"]["kikd"]["active"] = true;
include("inc/nav.php");
echo "<div id='main' role='main'>";
$breadcrumbs["Akademik"] = "";
include("inc/ribbon.php");	
$sub=(isset($_GET['sub']))?$_GET['sub']:"";
switch($sub)
{
	case "tampil":default:
		$jenismapel=(isset($_GET['jenismapel']))?$_GET['jenismapel']:"";
		$mapel=(isset($_GET['mapel']))?$_GET['mapel']:"";
		$tingkat=(isset($_GET['tingkat']))?$_GET['tingkat']:"";

		$FormPilih.="
		<form action='?page=$page' method='post' name='frmPilih' class='form-inline' role='form'>
			<div class='row'>
				<div class='col-sm-12 col-md-8'>
					<div class='form-group'>Pililh Data &nbsp;&nbsp;</div>";
					$FormPilih.=FormCF("inline","Kelompok","txtJMapel","select * from ak_matapelajaran group by jenismapel","jenismapel",$jenismapel,"jenismapel","","onchange=\"document.location.href='?page=$page&jenismapel='+document.frmPilih.txtJMapel.value\"");
					if(!empty($_GET['jenismapel'])){
						$FormPilih.=FormCF("inline","Mata Pelajaran","txtMapel","select * from ak_kikd where jenismapel='".$_GET['jenismapel']."' group by nama_mapel","kelompok",$mapel,"nama_mapel","","onchange=\"document.location.href='?page=$page&jenismapel='+document.frmPilih.txtJMapel.value+'&mapel='+document.frmPilih.txtMapel.value\"");
					}
					if(!empty($_GET['mapel'])){
						$FormPilih.=FormCF("inline","Tingkat","txtTingk","select * from ak_kikd where kelompok='".$_GET['mapel']."' group by tingkat","tingkat",$tingkat,"tingkat","","onchange=\"document.location.href='?page=$page&jenismapel='+document.frmPilih.txtJMapel.value+'&mapel='+document.frmPilih.txtMapel.value+'&tingkat='+document.frmPilih.txtTingk.value\"");
					}
		$FormPilih.="
				</div>
				<div class='col-sm-12 col-md-4'>
				<a href='?page=$page&sub=tambah' title='Tambah KIKD' class='btn btn-info btn-sm pull-right'><i class='fa fa-plus'></i> Tambah KIKD</a>
				</div>
			</div>
		</form>";


		if(!empty($_GET['jenismapel']) && !empty($_GET['mapel']) && !empty($_GET['tingkat'])){
			$wh=" where jenismapel='$jenismapel' and kelompok='$mapel' and tingkat='$tingkat'";
		}
		else{
			$wh=" where jenismapel='0' and kelompok='0' and tingkat='0'";
		}	
		
		$Q="select * from ak_kikd $wh";
		$no=1;
		$Query=mysql_query("$Q order by id_kikd,no_kikd asc");
		while($Hasil=mysql_fetch_array($Query)){
			$NamaMapel=$Hasil['nama_mapel'];
			$TampilData.="
			<tr>
				<td class='text-center'>$no.</td>
				<td><label class='checkbox'><input type='checkbox' id='cekbox' name='cekbox[]' value='{$Hasil['id_kikd']}'><i></i></label></td>
				<td>{$Hasil['kode_ranah']}</td>
				<td>{$Hasil['no_kikd']}</td>
				<td>{$Hasil['isikikd']}</td>
				<td><a href='?page=$page&sub=edit&jenismapel=$jenismapel&mapel=$mapel&tingkat=$tingkat&Kode={$Hasil['id_kikd']}'><i class='font-lg fa fa-pencil-square-o'></i></a></td>
			</tr>";
			$no++;
		}
		$jmldata=mysql_num_rows($Query);
		if($jmldata>0){
			if(!empty($_GET['jenismapel'])){$Infona1.="<span class='label bg-color-redLight'>Kelompok {$jenismapel}</span>";}
			if(!empty($_GET['mapel'])){$Infona2.="<span class='label bg-color-redLight'>{$NamaMapel}</span>";}
			if(!empty($_GET['tingkat'])){$Infona3.="<span class='label bg-color-redLight'>Tingkat {$tingkat}</span>";}

			$Show.=KolomPanel($FormPilih);

			$Show.="$Infona1 $Infona2 $Infona3 <span class='label bg-color-redLight'>Total <em>$jmldata (".terbilang($jmldata).")</em> Data KIKD</span><br><br>";
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
			<form action='?page=$page&sub=hapusbanyak' method='post' class='form-horizontal'>		
			<div class='well no-padding'>
				<table id='dt_basic' class='table table-striped table-bordered table-hover table-condensed' width='100%'>
					<thead>
						<tr>
							<th class='text-center' data-class='expand'>No.</th>
							<th class='text-center'>Pilih</th>
							<th width='75'>Ranah</th>
							<th width='75'>No. KIKD</th>
							<th data-hide='phone,tablet'>Isi KIKD</th>
							<th class='text-center' width='75'>Edit</th>
						</tr>
					</thead>
					<tbody>$TampilData</tbody>
				</table>
			</div>
				".FormCB("Pilih Semua","checkbox",'onclick="checkUncheckAll(this)";')."
				<div class='form-actions'><input type='submit' value='Hapus' name='submit' class='btn btn-sm btn-danger'></div></form>";
		}
		else{
			$QCekKIKD=mysql_query("select * from ak_kikd");
			if(mysql_num_rows($QCekKIKD)==0){
				$Show.=nt("peringatan","KIKD belum ada. <br>Silakan tambah KIKD. atau klik tombol di bawah ini untuk impor KIKD<br><a href='?page=tools-excel-kikd' class='btn btn-info btn-sm'>Impor KI KD</a>","");
			}
			else{
				$Show.=KolomPanel($FormPilih);

				$Query=mysql_query("select * from ak_kikd where jenismapel='$jenismapel' and kelompok='$mapel'");
				$HQ=mysql_fetch_array($Query);
				if(!empty($_GET['jenismapel'])){$Infona1.="<span class='label bg-color-redLight'>Kelompok {$jenismapel}</span>";}
				if(!empty($_GET['mapel'])){$Infona2.="<span class='label bg-color-redLight'>{$HQ['nama_mapel']}</span>";}
				if(!empty($_GET['tingkat'])){$Infona3.="<span class='label bg-color-redLight'>Tingkat {$tingkat}</span>";}
				if($jenismapel==""){
					$DtKosong="<h1 class='text-center text-danger'><strong><i class='fa fa-exclamation-triangle fa-lg'></i></h1><h4 class='text-center text-info'>Pilih Kelompok Mata Pelajaran !!</strong></h4>";
				}
				else if($mapel==""){
					$DtKosong="<h1 class='text-center text-danger'><strong><i class='fa fa-exclamation-triangle fa-lg'></i></h1><h4 class='text-center text-info'>Pilih Nama Mata Pelajaran !!</strong></h4>";
				}
				else if($tingkat==""){
					$DtKosong="<h1 class='text-center text-danger'><strong><i class='fa fa-exclamation-triangle fa-lg'></i></h1><h4 class='text-center text-info'>Pilih Tingkat !!</strong></h4>";
				}
				else{
					$DtKosong="<h1 class='text-center text-danger'><strong><i class='fa fa-exclamation-triangle fa-lg'></i></h1><h4 class='text-center text-info'>Data Kosong !!</strong></h4>";
				}
				
				if(!empty($_GET['jenismapel']) || !empty($_GET['mapel']) || !empty($_GET['tingkat'])){
					$Show.="$Infona1 $Infona2 $Infona3 <br><br>";
				}

				$Show.=KolomPanel($DtKosong);
			}
		}
		$tandamodal="#DataKIKD";
		echo $DataKIKD;
		echo MyWidget('fa-list',"Daftar KIKD","",$Show);
	break;
	case "edit":
		$KodeEdit= isset($_GET['Kode'])?$_GET['Kode']:"";
		$jenismapel=(isset($_GET['jenismapel']))?$_GET['jenismapel']:"";
		$mapel=(isset($_GET['mapel']))?$_GET['mapel']:"";
		$tingkat=(isset($_GET['tingkat']))?$_GET['tingkat']:"";
		NgambilData("SELECT * FROM ak_kikd WHERE id_kikd='$KodeEdit'");
		$IsiForm.='<fieldset>';
		$IsiForm.=FormIF("horizontal","ID KIKD", "txtKode",$id_kikd,'3','readonly=readonly');
		$IsiForm.=FormIF("horizontal","Jenis Mata Pelajaran", "txtJenMP",$jenismapel,'3','readonly=readonly');
		$IsiForm.=FormIF("horizontal","Kelompok", "txtKelompok",$kelompok,'2','readonly=readonly');
		$IsiForm.=FormIF("horizontal","Mata Pelajaran", "txtMP",$nama_mapel,'4','readonly=readonly');
		$IsiForm.=FormCR("horizontal",'Tingkat','txtTingkat',$tingkat,$Ref->TingkatKls,'3',"");
		$IsiForm.=FormCR("horizontal",'Kode Ranah','txtKranah',$kode_ranah,$Ref->KodeRanah,'3',"");
		$IsiForm.=FormIF("horizontal","No. KIKD", "txtNoKIKD",$no_kikd,'2',"");
		$IsiForm.=FormTextAreaDB("Isi KIKD", "txtisikikd",$isikikd,'8',"");
		$IsiForm.='</fieldset>';
		$IsiForm.='<div class="form-actions">';
		$IsiForm.=ButtonSimpan();
		$IsiForm.='</div>';

		$Show.=FormAing($IsiForm,"?page=$page&amp;sub=simpanedit","FrmEditMP","");
		$tandamodal="#EditKIKD";
		echo $EditKIKD;
		echo MyWidget('fa-pencil-square-o',"Edit KIKD",array(ButtonKembali("?page=$page")),$Show);
	break;
	case "simpanedit":
		$txtKode=addslashes($_POST['txtKode']);
		$txtJenMP=addslashes($_POST['txtJenMP']);
		$txtKelompok=addslashes($_POST['txtKelompok']);
		$txtMP=addslashes($_POST['txtMP']);
		$txtTingkat=addslashes($_POST['txtTingkat']);
		$txtKranah=addslashes($_POST['txtKranah']);
		$txtNoKIKD=addslashes($_POST['txtNoKIKD']);
		$txtisikikd=addslashes($_POST['txtisikikd']);
		mysql_query("UPDATE ak_kikd SET jenismapel='$txtJenMP', kelompok='$txtKelompok', nama_mapel='$txtMP', tingkat='$txtTingkat',kode_ranah='$txtKranah',no_kikd='$txtNoKIKD',isikikd='$txtisikikd' WHERE id_kikd='$txtKode'");
		echo ns("Ngedit","parent.location='?page=$page'","KIKD <strong class='text-primary'>$txtMP</strong>");
	break;
	case "tambah":
		$IsiForm.='<fieldset>';
		$IsiForm.="<script src='".ASSETS_URL."/js/myjs/ak-ki-kd-tambah.js'></script>";
		$IsiForm.=FormCF("horizontal",'Paket Keahlian','txtKodePK','select * from ak_paketkeahlian','kode_pk',$kode_pk,'nama_paket','4','onchange=LihatMapel(this.value)');
		$IsiForm.="<div id='txtHint'></div>";
		$IsiForm.="<div id='txtHint1'></div>";
		$IsiForm.=FormCR("horizontal",'Tingkat','txtTingkat',$tingkat,$Ref->TingkatKls,'3',"");
		$IsiForm.=FormCR("horizontal",'Kode Ranah','txtKranah',$kode_ranah,$Ref->KodeRanah,'3',"");
		$IsiForm.=FormIF("horizontal","No. KIKD", "txtNoKIKD",$no_kikd,'2',"");
		$IsiForm.=FormTextAreaDB("Isi KIKD", "txtisikikd",$isikikd,'8',"");
		$IsiForm.='</fieldset>';
		$IsiForm.='<div class="form-actions">';
		$IsiForm.=ButtonSimpan();
		$IsiForm.='</div>';

		$Show.="Menambah KIKD bisa melalui impor KIKD ke MYSQL di Menu <a href='?page=tools-excel-kikd' class='label bg-color-blue'>Tools <i class='fa fa-angle-double-right fa-fw'></i> Impor <i class='fa fa-angle-double-right fa-fw'></i> KIKD</a><hr>";
		$Show.=FormAing($IsiForm,"?page=$page&amp;sub=simpantambah","FrmEditMP","");
		$tandamodal="#TambahKIKD";
		echo $TambahKIKD;
		echo MyWidget('fa-plus',"Tambah KIKD",array(ButtonKembali("?page=$page")),$Show);
	break;
	case "simpantambah":
		$txtKode=buatKode("ak_kikd","kikd_");
		$txtJenisMapel=addslashes($_POST['txtJenisMapel']);
		$txtKelompok=addslashes($_POST['txtKelompok']);
		$txtMP=addslashes($_POST['txtMP']);
		$txtTingkat=addslashes($_POST['txtTingkat']);
		$txtKranah=addslashes($_POST['txtKranah']);
		$txtNoKIKD=addslashes($_POST['txtNoKIKD']);
		$txtisikikd=addslashes($_POST['txtisikikd']);
		mysql_query("INSERT INTO ak_kikd VALUES ('$txtKode','$txtJenisMapel','$txtKelompok','$txtMP','$txtTingkat','$txtKranah','$txtNoKIKD','$txtisikikd')");
		echo ns("Nambah","parent.location='?page=$page'","KIKD <strong class='text-primary'>$txtMP</strong>");
	break;
	case "hapusbanyak":
		$cekbox = $_POST['cekbox'];
		if ($cekbox) {
			foreach ($cekbox as $value) {
				mysql_query("DELETE FROM ak_kikd WHERE id_kikd = '$value'");
				echo $value;
				echo ",";
			}
			echo '<div id="preloader"><div id="cssload"></div></div>';
			echo ns("Hapus","parent.location='?page=$page'","KIKD");
		}  else {
			echo '<div id="preloader"><div id="cssload"></div></div>';
			echo ns("BelumMilih","parent.location='?page=$page'","KIKD");
		}
	break;
}
echo '</div>';
include("inc/scripts.php"); 
include("inc/footer.php");
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