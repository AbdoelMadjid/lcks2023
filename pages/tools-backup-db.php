<?php
require_once("inc/init.php");
require_once("inc/config.ui.php");
$page_title = "Backup DB";
$page_css[] = "your_style.css";
include("inc/header.php");
$page_nav["tools"]["sub"]["backupdb"]["active"] = true;
include("inc/nav.php");
echo "<div id='main' role='main'>";
$breadcrumbs["Tools"] = "";
include("inc/ribbon.php");	
$sub=(isset($_GET['sub']))?$_GET['sub']:"";
switch($sub)
{
	case "tampil":default:
		$sql = 'SHOW TABLES';
		$rs = mysql_query($sql) or die ($sql);
		if (isset($_POST['backup'])) {
			backup_db($_POST['table']);
			echo ns("Ngunduh","parent.location='?page=$page'","Database");
		}
		$Tampilkan.="
		<script type=\"text/javascript\">
		window.onload = function() {
			_('all-table', 'id').addEventListener('click', function(e) {
				var checked = _('all-table', 'id').checked,
				tables = _('table', 'class');
				for(var i=0; i<tables.length; i++) {
					if (checked) {
						tables[i].checked = true;
					} else {
						tables[i].checked = false;
					}
				}
			});
		}
		function _(element, type) {
		var e = type == 'id' ? document.getElementById(element) : document.getElementsByClassName(element);
		return e;
		}
		</script>";
		$Tampilkan.='
		<div class="row">	
		<div class="col-sm-12">
		<div class="who clearfix padding-10"><h4 class="txt-color-blue">Daftar <em><strong>Tabel DB</strong></em></h4></div>';
			while ($row = mysql_fetch_array($rs)) { 
				$DtTabel.='
				<div id="row">
					<div class="col col-2">
						<label class="checkbox">
						<input type="checkbox" name="table[]" class="table" value="'.$row[0].'" /><i></i>'.$row[0].'</label>
					</div>
				</div>';
			} 
			$Tampilkan.="
			<form method='POST' class='smart-form'>
			<hr>
			<fieldset>$DtTabel</fieldset><br>
				<hr class='padding-10'><span class='txt-color-red'><em><strong>* pilih table yang akan anda backup</strong></em></span>
			<div class='form-actions'>
				<button type='submit' class='btn btn-success btn-sm' name='backup'>Proses</button>
				<label class='checkbox pull-left'>
					<input type='checkbox' id='all-table' /> <i></i><b>Semua table</b>
				</label><br>
			</div>
			</form>
		</div>
		</div>";
		echo $InfoBackupDB;
		$tandamodal="#InfoBackupDB";
		//echo IsiPanel($Tampilkan,"#InfoBackupDB");
		echo MyWidget('fa-database',$page_title." <i class='ultra-light'>LCKS</i>",$Tombolna,$Tampilkan);		
	break;
}
echo '</div>';
include("inc/footer.php");
include("inc/scripts.php");
//"))
?>