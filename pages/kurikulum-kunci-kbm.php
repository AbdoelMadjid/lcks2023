<?php
require_once("inc/init.php");
require_once("inc/config.ui.php");
$page_title = "Kunci KBM";
$page_css[] = "your_style.css";
include("inc/header.php");
$page_nav["kurikulum"]["sub"]["kuncikbm"]["active"] = true;
include("inc/nav.php");
echo "<div id='main' role='main'>";
$breadcrumbs["Kurikulum"] = "";
include("inc/ribbon.php");	
$sub=(isset($_GET['sub']))?$_GET['sub']:"";
switch($sub)
{
	case "tampil":default:
		if(isset($_POST['btnSave'])){
			$txtThnAjar=addslashes($_POST['txtThnAjar']);
			$txtGG=addslashes($_POST['txtGG']);
			mysql_query("INSERT INTO kur_kunci_kbm VALUES ('','$txtThnAjar','$txtGG','Y')");
			echo '<div id="preloader"><div id="cssload"></div></div>';
			echo ns("Nambah","parent.location='?page=$page'","Kunci KBM");
		}
		if(isset($_POST['btnBukaKunci'])){
			$txtThnAjar=addslashes($_POST['txtThnAjar']);
			$txtGG=addslashes($_POST['txtGG']);
			mysql_query("UPDATE kur_kunci_kbm SET kunci='N' WHERE tahunajaran='$txtThnAjar' and semester='$txtGG'");
			echo '<div id="preloader"><div id="cssload"></div></div>';
			echo ns("MukaKonci","parent.location='?page=$page'","KBM Tahun Pelajaran $txtThnAjar Semester $txtGG");
		}
		if(isset($_POST['btnKunci'])){
			$txtThnAjar=addslashes($_POST['txtThnAjar']);
			$txtGG=addslashes($_POST['txtGG']);
			mysql_query("UPDATE kur_kunci_kbm SET kunci='Y' WHERE tahunajaran='$txtThnAjar' and semester='$txtGG'");
			echo '<div id="preloader"><div id="cssload"></div></div>';
			echo ns("Ngonci","parent.location='?page=$page'","KBM Tahun Pelajaran $txtThnAjar Semester $txtGG");
		}
		
		$thnajaran=(isset($_GET['thnajaran']))?$_GET['thnajaran']:"";
		$gg=(isset($_GET['gg']))?$_GET['gg']:"";
		
		$QC=mysql_query("SELECT * FROM kur_kunci_kbm where tahunajaran='$thnajaran' and semester='$gg'");
		$HC=mysql_fetch_array($QC);
		
		if($HC['kunci']=="Y"){
			$TmblKunci="<div class='form-actions'><button type='submit button' class='btn btn-sm btn-info' name='btnBukaKunci'><i class='fa fa-unlock'></i> Buka Kunci</button></div>";}
		else if($HC['kunci']=="N"){
			$TmblKunci="<div class='form-actions'><button type='submit button' class='btn btn-sm btn-info' name='btnKunci'><i class='fa fa-lock'></i> Kunci</button></div>";}
		else if($thnajaran==""){
			$TmblKunci="<hr><span class='text-danger pull-right'><i class='fa fa-exclamation-triangle text-danger'></i> Pilih Tahun Pelajaran</span>";}
		else if($gg==""){
			$TmblKunci="<hr><span class='text-danger pull-right'><i class='fa fa-exclamation-triangle text-danger'></i> Pilih Semester</span>";}
		else{
			$TmblKunci="<div class='form-actions'><button type='submit button' class='btn btn-sm btn-info' name='btnSave'><i class='fa fa-save'></i> Simpan</button></div>";}
		
	
		$KunciKBM.=JudulKolom('Pilih Data','search');
		$KunciKBM.="
		<form action='?page=$page' method='post' name='FrmKunciKBM' class='form-horizontal' role='form'>
		<fieldset>";
		$KunciKBM.=FormCF("horizontal","Tahun Ajaran","txtThnAjar","select * from ak_tahunajaran order by id_thnajar asc","tahunajaran",$_GET['thnajaran'],"tahunajaran","4","onchange=\"document.location.href='?page=$page&thnajaran='+document.FrmKunciKBM.txtThnAjar.value\"");
		$KunciKBM.=FormCF("horizontal","Semester","txtGG","select * from ak_semester","ganjilgenap",$_GET['gg'],"ganjilgenap","4","onchange=\"document.location.href='?page=$page&thnajaran='+document.FrmKunciKBM.txtThnAjar.value+'&gg='+document.FrmKunciKBM.txtGG.value\"");
		$KunciKBM.="
		</fieldset>
		$TmblKunci
		</form>";

		$Q=mysql_query("SELECT * FROM kur_kunci_kbm order by tahunajaran desc");
		$no=1;
		while($Hasil=mysql_fetch_array($Q)){
			if($Hasil['kunci']=="Y"){$tandana="<i class='fa fa-lock fa-lg text-danger'></i>";}
			else{$tandana="<i class='fa fa-unlock fa-lg text-info'></i>";}		
			$TampilData.="
			<tr>
				<td class='hidden-480 text-center'>$no.</td>
				<td class='text-center'>{$Hasil['tahunajaran']}</td>
				<td class='text-center'>{$Hasil['semester']}</td>
				<td class='text-center'>$tandana</td>
			</tr>";
			$no++;
		}

		$DQKUNCI=mysql_num_rows($Q);
		if($DQKUNCI>0){
			$TampilKunci.=JudulKolom('Data Kuncian KBM','lock');
			$TampilKunci.="
			<p class='info' style='margin-top:-15px;'><span class='label bg-color-darken txt-color-white'>Info !</span> <span class='hidden-lg'><br></span><code>Silakan lakukan proses penguncian pada form di <span class='hidden-lg'>bawah</span> <span class='hidden-xs'>samping </span></code></p>

			<div class='well no-padding' style='margin-left:-15px;margin-right:-15px;margin-bottom:-15px;'>
				<table id='dt_basic' class='table table-striped table-bordered table-condensed' width='100%'>					
					<thead>
						<tr>
							<th class='text-center' data-class='expand'>No.</th>
							<th class='text-center'>Tahun Ajaran</th>
							<th class='text-center' data-hide='phone,tablet'>Semester</th>
							<th class='text-center' data-hide='phone,tablet'>Kunci</th>
						</tr>
					</thead>
					<tbody>$TampilData</tbody>
				</table>
			</div>";
		}
		else {
			$TampilKunci.=JudulKolom('Data Kuncian KBM','key');
			$TampilKunci.=nt("peringatan","Data Kunci KBM belum di buat");
		}

		$Tampilkan=DuaKolom(KolomPanel($TampilKunci),KolomPanel($KunciKBM));

		echo $NgunciDataNilai;
		$tandamodal="#NgunciDataNilai";
		echo MyWidget('fa-key',$page_title,"",$Tampilkan);
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
		"hapus":function(a){
			function b(){
				window.location=a.attr("href")
			}
			$.SmartMessageBox(
				{
					"title":"<i class='fa fa-question-circle txt-color-blue'></i> <span class='txt-color-white'><strong>Konfirmasi Hapus</strong></span>",
					"content":a.data("hapus-msg"),
					"buttons":"[No][Yes]"
				},function(a){
					"Yes"==a&&($.root_.addClass("animated fadeOutUp"),setTimeout(b,1e3))
					}
		)}
	}

	$.root_.on("click",'[data-action="hapus"]',function(b){var c=$(this);a.hapus(c),b.preventDefault(),c=null});

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
			url: 'pages/modal.php?md=DetailProfilPTK',
			method: 'post',
			data: {id:id},
			success:function(data){
				$('#bodyDetailGuru').html(data);
				$('#DetailGuru').modal("show");
			}
		});
	});
})
</script>