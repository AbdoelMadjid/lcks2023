<?php
require_once("inc/init.php");
require_once("inc/config.ui.php");
$page_title = "Perangkat Ujian";
$page_css[] = "your_style.css";
include("inc/header.php");
$page_nav["kurikulum"]["sub"]["perangkatujian"]["active"] = true;
include("inc/nav.php");
echo "<div id='main' role='main'>";
$breadcrumbs["Kurikulum"] = "";
include("inc/ribbon.php");	
$sub=(isset($_GET['sub']))?$_GET['sub']:"";
switch($sub){
	case "tampil":default:



		echo $CukupJelas;
		$tandamodal="#CukupJelas";
		echo MyWidget('fa-address-book-o',$page_title,"",$ConstructionApp);		
	break;
}
echo "</div>";
include("inc/footer.php");
include("inc/scripts.php"); 
?>