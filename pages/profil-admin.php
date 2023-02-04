<?php
require_once("inc/init.php");
require_once("inc/config.ui.php");
$page_title = "Profil";
$page_css[] = "your_style.css";
include("inc/header.php");
$page_nav["profil"]["active"] = true;
include("inc/nav.php");
echo "<div id='main' role='main'>";
$breadcrumbs["Administrator"] = "";
include("inc/ribbon.php");	
$sub=(isset($_GET['sub']))?$_GET['sub']:"";
switch($sub){
	case "tampil":default:



		echo IsiPanel($ConstructionApp,"#KetInformasi");
		echo $KetInformasi;
		$tandamodal="#KetInformasi";
	break;
}
echo "</div>";
include("inc/footer.php");
include("inc/scripts.php");
?>