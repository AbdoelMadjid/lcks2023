<?php
require_once("inc/init.php");
require_once("inc/config.ui.php");
$page_title = "Data Dapoik";
$page_css[] = "your_style.css";
include("inc/header.php");
$page_nav["kurikulum"]["sub"]["dapodik"]["active"] = true;
include("inc/nav.php");
echo "<div id='main' role='main'>";
$breadcrumbs["Kurikulum"] = "";
include("inc/ribbon.php");	
$sub=(isset($_GET['sub']))?$_GET['sub']:"";
switch($sub){
	case "tampil":default:



		echo $CukupJelas;
		$tandamodal="#CukupJelas";
		echo MyWidget('fa-cubes',$page_title,"",$ConstructionApp);	
	break;
}
echo "</div>";
include("inc/footer.php");
include("inc/scripts.php");
?>