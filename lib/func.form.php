<?php
/* 12/6/2016 --> Sabtu, 28 Januari 2017 13.10.40 --> 07/01/2023 18:42
Design and Programming By. Abdul Madjid, S.Pd., M.Pd.
SMK Negeri 1 Kadipaten
Pin 520543F3 HP. 0812-3000-0420
https://twitter.com/AbdoelMadjid 
https://www.facebook.com/abdulmadjid.mpd
*/
//eval(base64_decode("

function iSubmit($N,$L){
	return "<input class='btn btn-info btn-sm' type='submit' name='$N' id='$N' value='$L'>";
}

function bSubmit($N,$L){
	return "<button class='btn btn-info btn-sm' type='submit button' name='$N' id='$N'>$L</button>";
}

function ButtonKembali($link){
	return "<a href='$link' class='btn btn-default btn-sm pull-right' style='margin-top:5px;'><i class='fa fa-reply'></i> <span class='hidden-xs'>Kembali</span></a>";
}

function ButtonKembali2($link,$margin){
	return "<a href='$link' class='btn btn-default btn-sm pull-right' $margin><i class='fa fa-reply'></i> <span class='hidden-xs'>Kembali</span></a>";
}
// form comblo dari database
function FormCF($Pilih,$labelna,$name,$tabelna,$s1,$s2,$s3,$lebar,$param){
	$Q=mysql_query("$tabelna");
	while($H=mysql_fetch_array($Q)){
		$sel=$H[$s1]==$s2?"selected":"";
		$Dt.="<option $sel value='$H[$s1]'>$H[$s3]</option>";
	}
	if($Pilih=="inline"){
		return "
		<div class='form-group'>
			<label class='sr-only'>$labelna</label>
			<select name=\"$name\" class='input-sm form-control' $param>
			<option value=''>Pilih $labelna</option>
			$Dt
			</select> 
		</div>";
	}
	else if($Pilih=="horizontal")
	{
		return "
		<div class='form-group'>
			<label class='control-label col-md-4'>$labelna</label>
			<div class='col-sm-$lebar'>
				<select class='input-sm form-control required' name=\"$name\"  id=\"$name\" $param>
					<option value=''><em>Pilih $labelna</em></option>
					$Dt
				</select>
			</div>
		</div>";
	}
	else if($Pilih=="smart"){
		return "
		<section>
			<label label col col-$lebar>$labelna</label>
			<label class='select'>
				<select class='input-$lebar form-control required' name=\"$name\"  id=\"$name\" $param>
					<option value=''>Pilih $labelna</option>
					$Dt
				</select> <i></i> </label>
		</section>
		";
	}
	else if($Pilih=="smart2"){
		return "
		<section class='col col-$lebar'>
			<label class='select'>
				<select name=\"$name\" class='input-sm form-control' $param>
				<option value=''>Pilih $labelna</option>
				$Dt
			</select>  <i></i> </label>
		</section>";		
	}	
}

// form combo dari referensi
function FormCR($Pilih,$labelna,$name,$value='',$arrList='',$lebar,$param){
	global $Ref;
	$isi = $value;
	for($i=0;$i<count($arrList);$i++)
	{
		$Sel = $isi==$arrList[$i]?" selected ":"";
		$Dt .= "<option $Sel value=\"{$arrList[$i]}\">{$arrList[$i]}</option>";
	}
	if($Pilih=="inline"){
		return "
		<div class='form-group'>
			<label class='sr-only'>$labelna</label>
			<select name=\"$name\" class='input-sm form-control' $param>
				<option value=''>Pilih $labelna</option>
				$Dt
			</select>
		</div>";
	}
	else if($Pilih=="horizontal"){
		return "
		<div class='form-group'>
			<label class='control-label col-md-4'>$labelna</label>
			<div class='col-sm-$lebar'>
				<select class='input-sm form-control required' name=\"$name\"  id=\"$name\" $param>
					<option value=''>Pilih $labelna</option>
					$Dt
				</select>
			</div>
		</div>";
	}
	else if($Pilih=="smart"){
		return "
		<section>
			<label class='label'>$labelna</label>
			<label class='select'>
				<select class='input-$lebar form-control required' name=\"$name\"  id=\"$name\" $param>
					<option value=''>Pilih $labelna</option>
					$Dt
				</select> <i></i> </label>
		</section>
		";
	}
	else if($Pilih=="smart2"){
		return "
		<section class='col col-$lebar'>
			<label class='select'>
				<select name=\"$name\" class='input-sm form-control' $param>
				<option value=''>Pilih $labelna</option>
				$Dt
			</select>  <i></i> </label>
		</section>";	
	}
}

// form input

function FormIF($Pilih,$labelna,$namana,$fieldna,$lebar,$param) 
{
	if($Pilih=="inline"){
		return "
		<label class='label col col-4'>$labelna</label>
		<section class='col col-$lebar'>
			<label class='input'>
				<input type='text' name='$namana' value='$fieldna' $param>
			</label>
		</section>";
	}
	else if($Pilih=="horizontal"){
		return "
		<div class='form-group'>
			<label class='control-label col-md-4'>$labelna</label>
			<div class='col-sm-$lebar'>
				<input class='input-sm  form-control' name='$namana' value='$fieldna' type='text' $param>
			</div>
		</div>";
	}
	else if($Pilih=="smart"){
		return "
		<section>
			<label class='label'>$labelna</label>
			<label class='input'>
				<input class='input-sm  form-control' placeholder='$labelna' name='$namana' value='$fieldna' type='text' $param>
			</label>
		</section>";
	}
	else if($Pilih=="smart2"){
		return "
		<section class='col col-$lebar'>
			<label class='input'>
				<input class='form-control' placeholder='$labelna' type='text' name='$namana' value='$fieldna' $param> 
			</label>
		</section>";		
	}	
}

function FormTextAreaDB($labelna="",$namana="",$fieldna="",$lebar="",$param="")
{
	return "
	<div class='form-group'>
		<label class='control-label col-md-4'>$labelna</label>
		<div class='col-md-$lebar'>
			<textarea rows='10' class='form-control' name='$namana' $param>$fieldna</textarea>
		</div>
	</div>";
}

function FormRBDB($labelna="",$namana="",$fieldna="",$idFor1="",$idFor2="")
{
	if($fieldna==1){$pilih1.="checked";}else{$pilih1.="";}
	if($fieldna==0){$pilih2.="checked";}else{$pilih2.="";}

	return "
	<style>
		.radio-toolbar input[type='radio'] {
			display:none;
		}

		.radio-toolbar label {
			display:inline-block;
			background-color:#ddd;
			padding:4px 11px;
			font-family:Arial;
			font-size:14px;
		}

		.radio-toolbar input[type='radio']:checked + label {
			background-color:#ff6600;
			color:#ffffff;
		}
	</style>
	<label class='control-label col-md-4'>$labelna</label>
	<div class='col-sm-5'>
		<div class='radio-toolbar'>
			<input type='radio' id='$idFor1' name='$namana' value='1' $pilih1>
			<label for='$idFor1'>Ada</label>

			<input type='radio' id='$idFor2' name='$namana' value='0' $pilih2>
			<label for='$idFor2'>Tidak</label>
		</div>
	</div>";
}

function FormRBDBNY($labelna="",$namana="",$fieldna="",$idFor1="",$idFor2="")
{
	if($fieldna=="Y"){$pilih1.="checked";}else{$pilih1.="";}
	if($fieldna=="N"){$pilih2.="checked";}else{$pilih2.="";}

	return "
	<style>
		.radio-toolbar input[type='radio'] {
			display:none;
		}

		.radio-toolbar label {
			display:inline-block;
			background-color:#ddd;
			padding:4px 11px;
			font-family:Arial;
			font-size:14px;
		}

		.radio-toolbar input[type='radio']:checked + label {
			background-color:#ff6600;
			color:#ffffff;
		}
	</style>
	<div class='form-group'>
	<label class='control-label col-md-4'>$labelna</label>
	<div class='col-sm-5'>
		<div class='radio-toolbar'>
			<input type='radio' id='$idFor1' name='$namana' value='Y' $pilih1>
			<label for='$idFor1'>AKTIF</label>

			<input type='radio' id='$idFor2' name='$namana' value='N' $pilih2>
			<label for='$idFor2'>TIDAK</label>
		</div>
	</div>
	</div>";
}

function FormCB($labelna="",$namana="",$param="")
{
	return "
	<div class='checkbox'>
		<label>
			<input type='checkbox' class='ace' name='$namana' id='$namana' $param />
			<i></i>$labelna
		</label>
	</div>";
}

function FormCBSikapE($nomor="",$labelna="",$namana="",$fieldna="",$idFor1="",$idFor2="")
{
	if($fieldna==1){$pilih1.="checked";}else{$pilih1.="";}
	if($fieldna==2){$pilih2.="checked";}else{$pilih2.="";}
	return "
	<style>
		.radio-toolbar input[type='radio'] {
			display:none;
		}

		.radio-toolbar label {
			display:inline-block;
			background-color:#ddd;
			padding:4px 11px;
			font-family:Arial;
			font-size:14px;
		}

		.radio-toolbar input[type='radio']:checked + label {
			background-color:#ff6600;
			color:#ffffff;
		}
	</style>
	<table>
	<tr>
		<td width='25' valign='top'>$nomor</td>
		<td><label>$labelna</label></td>
	</tr>
	<tr>
		<td></td>
		<td>
			<div class='radio-toolbar'>
				<input type='radio' id='$idFor1' name='$namana' value='1' $pilih1>
				<label for='$idFor1'>Selalu</label>

				<input type='radio' id='$idFor2' name='$namana' value='2' $pilih2>
				<label for='$idFor2'>Kadang-Kadang</label>
			</div>
		</td>
	</tr>
	</table>";
}

function FormAing($Eusina="",$Aksi="",$Nama="",$param=""){
	$FormAing ="<form action='$Aksi' method='post' name='$Nama' id='$Nama' class='form-horizontal' role='form' $param>$Eusina</form>";
	return $FormAing;
}

function FormData($labelna="",$isiData="",$lebar="")
{
	return "
	<div class='form-group>
		<label class='col-md-4 control-label'>$labelna</label>
		<div class='col-sm-8'>
			<input class='form-control' value='$isiData'>
		</div>
	</div>";
}
function FormInfo($labelna="",$isiData="")
{
	return "
	<div class='form-group>
		<label>$labelna</label>
		<span class='form-control'>$isiData</span>
	</div>";
}
function FormInfoSmart($labelna="",$isiData="")
{
	return "
	<section>
		<label class='label'>$labelna</label>
		<label class='input state-disabled'>
			<input type='text' class='input-sm' disabled='disabled' value='$isiData'>
		</label>
	</section>";
}
function FormInfoTabel($labelna="",$isiData="",$jarak="")
{
	return "
		</tr>
			<td style='padding:$jarak 8px;' valign='top' width='30%'>$labelna</td>
			<td style='padding:$jarak 8px;' width='5%' valign='top'>:</td>
			<td style='padding:$jarak 8px;' valign='top'><strong>$isiData</strong></td>
		</tr>";

}

function LinkButtonBlock($Link="",$JenisBtn="",$Iconnya="",$Kalimatnya=""){
	return "<a href='$Link' class='btn btn-sm btn-block btn-$JenisBtn'><i class='fa fa-$Iconnya font-md'></i> $Kalimatnya</a>";
}

function ButtonSimpanName($namana="",$labelna=""){
	return "<input class='btn btn-info btn-sm' type='submit' name='$namana' id='$namana' value='$labelna'>";
}

function ButtonSimpanNameOther($namana="",$labelna=""){
	return "<input class='btn btn-danger btn-sm' type='submit' name='$namana' id='$namana' value='$labelna'>";
}

function ButtonSimpan(){
	return "<button class='btn btn-info btn-sm' type='submit button' name='btnSave'>Simpan</button>";
}

function ButtonSimpanHapus(){
	return "
	<button class='btn btn-info btn-sm' type='submit button' name='btnSave'>Simpan</button>
	<button class='btn btn-danger btn-sm' type='submit button' name='btnHapus'>Hapus</button>";
}

function AksiDB($JmlLI="",$arrListLink="",$arrListTitle="",$arrListClass="",$arrListIcon="") 
{
	for($i=0;$i<$JmlLI;$i++)
		{
			$IconLinkSee .= "
				<a class='$arrListClass[$i]' href='$arrListLink[$i]' title='$arrListTitle[$i]'><i class='fa fa-$arrListIcon[$i] font-md'></i></a>&nbsp;&nbsp;";
		}
	return "<div class='action-buttons'>$IconLinkSee</div>";	
}

function AksiEditDel($kode="") //================================================================[AKSI EDIT DAN HAPUS]
{
	global $page;
	return "
	<script>
	function confirmDelete(delUrl) {
		if (confirm('Apakah yakin akan di hapus')) {
			document.location = delUrl;
		}
	}
	</script>
	<div class='action-buttons'>
		<a class='red' href='?page=$page&amp;sub=edit&amp;$kode' target='_self'><i class='fa fa-pencil-square-o font-lg'></i></a>  
		<a class='red' href=\"javascript:confirmDelete('?page=$page&amp;sub=hapus&amp;$kode')\" target='_self'><i class='fa fa-trash-o font-lg'></i></a>
	</div>";
}

function AksiHapus($kode="") //================================================================[AKSI EDIT DAN HAPUS]
{
	global $page;
	return "
	<script>
	function checkDelete(delUrl) {
		swal({
			title: \"Are you sure?\",
			text: \"You will not be able to recover this imaginary file!\",
			type: \"warning\", showCancelButton: true,
			confirmButtonColor: \"#DD6B55\",
			confirmButtonText: \"Yes Delete it!\",
			closeOnConfirm: false
		},
		function () {
			document.location = delUrl;
			swal(\"Deleted!\", \"Your imaginary file has been deleted.\", \"success\");
		});
	}
	</script>
	<div class='action-buttons'>
		<a class='red' href=\"javascript:checkDelete('?page=$page&amp;sub=hapus&amp;$kode')\" target='_self'><i class='txt-color-red fa fa-trash-o font-lg'></i></a>
	</div>";
}

function AksiSingle($iconna="",$titlena="",$linkna="") //==============================================[AKSI SINGLE]
{
	return "
	<div class='action-buttons'>
		<a class='red' href='$linkna' target='_self'><i class='fa fa-$iconna font-lg'></i> $titlena</a>
	</div>";	
}


//");
?>