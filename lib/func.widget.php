<?php
/* 12/6/2016 --> Sabtu, 28 Januari 2017 13.10.40 --> 07/01/2023 18:42
Design and Programming By. Abdul Madjid, S.Pd., M.Pd.
SMK Negeri 1 Kadipaten
Pin 520543F3 HP. 0812-3000-0420
https://twitter.com/AbdoelMadjid 
https://www.facebook.com/abdulmadjid.mpd
*/
//eval(base64_decode("

function MyWidget($Iconna,$Judulna,$ArrToolbar,$IsiKonten){
	$Tampil.="
		<div id='content'>
				<section id='widget-grid' class=''>
					<div class='row'>
						<article class='col-xs-12'>";
	$ui = new SmartUI;
	$ui->start_track();
	$widget = $ui->create_widget();
	$widget->options(array("editbutton" => false,"colorbutton" => false,"editbutton" => false,"togglebutton" => false,
		"deletebutton" => false,"fullscreenbutton" => false,"custombutton" => false,"collapsed" => false,
		"sortable" => false,"refreshbutton" => true))
		->header(array("icon" => $Iconna,"title" => "<h2>$Judulna</h2>","toolbar" => $ArrToolbar))
		->body('content', $IsiKonten);

	$Tampil.= $widget->color('redLight')->print_html(true);

	$Tampil.="</article>
			</div>
		</section>
	</div>";

	return $Tampil;
}

function IsiPanel($Isi){
	return "
	<div id='content'>
		<section id='widget-grid' class=''>
			<div class='row'>
				<article class='col-sm-12 col-md-12 col-lg-12'>
					<div class='panel panel-default'>
						<div class='panel-body'>
							$Isi
						</div>
					</div>
				</article>
			</div>
		</section>
	</div>";
}

function KolomPanel($Isi){
	return "
	<div class='panel panel-default'>
		<div class='panel-body'>$Isi</div>
	</div>";
}

function DuaKolomD($L1="",$a="",$L2="",$b=""){ 
	return "
	<div class='row'>
		<div class='col-xs-12 col-sm-$L1 col-md-$L1'>$a</div>
		<div class='col-xs-12 col-sm-$L2 col-md-$L2'>$b</div>
	</div>";
}

function DuaKolom($a="",$b=""){ 
	return "
	<div class='row'>
		<div class='col-xs-12 col-sm-6 col-md-6'>$a</div>
		<div class='col-xs-12 col-sm-6 col-md-6'>$b</div>
	</div>";
}

function DuaKolomSama($a,$b){
	return "
	<div class='row'>
		<div class='col-xs-12 col-sm-6 col-md-6'><div class='panel panel-default'><div class='panel-body'><div class='text'>$a</div></div></div></div>
		<div class='col-xs-12 col-sm-6 col-md-6'><div class='panel panel-default'><div class='panel-body'><div class='text'>$b</div></div></div></div>
	</div>";
}

function EmpatKolomSama($a,$b,$c,$d){
	return "
	<div class='row padding-10'>
		<div class='col-xs-12 col-sm-3 col-md-3'>$a</div>
		<div class='col-xs-12 col-sm-3 col-md-3'>$b</div>
		<div class='col-xs-12 col-sm-3 col-md-3'>$c</div>
		<div class='col-xs-12 col-sm-3 col-md-3'>$d</div>
	</div>";
}

function TigaKolomSama($a,$b,$c){
	return "
	<div class='row padding-10'>
		<div class='col-xs-12 col-sm-4 col-md-4'>$a</div>
		<div class='col-xs-12 col-sm-4 col-md-4'>$b</div>
		<div class='col-xs-12 col-sm-4 col-md-4'>$c</div>
	</div>";
}

function KotakWell($i,$param){
	//param xs, sm
	return "
	<div class='well $param'>$i</div>";
}

// ----------------------------------------------------------------------------------- heading dan attribut

function JudulKolom($a,$i){
	return "
	<h6 style='margin-top:0px;margin-bottom:5px;'><i class='fa fa-$i text-danger'></i> <span class='text-primary'><strong>$a</strong></span></h6>
	<hr style='margin-left:-15px;margin-right:-15px;margin-top:10px;margin-bottom:25px;'>";
}

function JudulDalam($a,$i){
	return "<h6 style='margin-top:0px;margin-bottom:5px;'><i class='fa fa-$i text-danger'></i> <span class='text-danger'><strong>$a</strong></span></h6>
	<hr style='margin-left:-15px;margin-right:-15px;margin-top:10px;margin-bottom:25px;'>";
}

function Label($a){
	return "
	<h6 style='margin-top:0px;margin-bottom:5px;'><span class='text-primary'><strong>$a</strong></span></h6>
	<hr style='margin-top:10px;margin-bottom:15px;' class='simple'>";
}

function LabelGaris($Kalimat){
	return "<div class='social-or-login center'><span class='font-lg'>$Kalimat</span></div><div class='space space-8'></div>";
}

function GarisSimple(){
	return "<hr class='simple'>";
}

function JarakBaris($Jarak){
	return "<div class='space space-$Jarak'></div>";
}


function TombolSelect($judulna,$iconna,$tabel,$kolom,$get,$linkna){

	$QGA=mysql_query($tabel);
	while ($HGA=mysql_fetch_array($QGA)){
		$Sel=$HGA[$kolom]==$_GET[$get]?"selected":"";
		$CariGA.="<option $Sel value='$HGA[$kolom]'>{$HGA[$kolom]}</option>";
		$InputlistGA.="<li><a href='$linkna&$get=$HGA[$kolom]'>$HGA[$kolom]</a></li>";
	}

	return "
	<div class='btn-group'>
		<button class='btn dropdown-toggle btn-xs btn-default' data-toggle='dropdown'>
			<i class='fa fa-$iconna'></i> <span class='hidden-xs'>$judulna </span> <i class='fa fa-caret-down'></i>
		</button>
		<ul class='dropdown-menu pull-right'>$InputlistGA</ul>
	</div>";
}

//)";
?>
