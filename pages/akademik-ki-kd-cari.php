<?php 
/* 07/07/2017 
Design and Programming By. Abdul Madjid, S.Pd., M.Pd.
SMK Negeri 1 Kadipaten
Pin 520543F3 HP. 0812-3000-0420
https://twitter.com/AbdoelMadjid 
https://www.facebook.com/abdulmadjid.mpd
*/
//eval(base64_decode("
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING | E_DEPRECATED));
include "../lib/config.php";
session_start();
if($jmp=$_GET["jmp"]){
	?>
	<div class='form-group'>
		<label class='control-label col-md-4'>Mata Pelajaran</label>
		<div class='col-sm-8'>
			<select name="txtMataPelajaran" class='form-control input-sm' onchange='LihatTingkat(this.value)'>    
			<?php   
			$Qmapel = mysql_query("SELECT * FROM ak_kikd where jenismapel='$jmp' group by nama_mapel");
			?>
			<option value ="">Pilih</option>
			<?php
			while ($mapel = mysql_fetch_array($Qmapel)){
			?>
			<option value ="<?php echo"$mapel[nama_mapel]";?>"><?php echo"$mapel[nama_mapel]";?></option>
			<?php
			}
			?>
			</select>
		</div>
	</div>
<?php
}
	else if($mpnya=$_GET["mpnya"])
{
?>
	<div class='form-group'>
		<label class='control-label col-md-4'>Tingkat</label>
		<div class='col-sm-8'>
			<select name="txtTingkat" class='form-control input-sm' onchange='LihatRanah(this.value)'>    
			<?php   
			$QTingkat = mysql_query("SELECT * FROM ak_kikd where nama_mapel='$mpnya' group by tingkat");
			?>
			<option value ="">Pilih</option>
			<?php
			while ($tkna = mysql_fetch_array($QTingkat)){
			?>
			<option value ="<?php echo"$tkna[tingkat]";?>"><?php echo"$tkna[tingkat]";?></option>
			<?php
			}
			?>
			</select>
		</div>
	</div>
<?php
}
	else if($tknya=$_GET["tknya"])
{
?>
	<div class='form-group'>
		<label class='control-label col-md-4'>Kode Ranah</label>
		<div class='col-sm-8'>
			<select name="txtKRanah" class='form-control input-sm'>    
			<?php   
			$QKRanah = mysql_query("SELECT * FROM ak_kikd where tingkat='$tknya' group by kode_ranah");
			?>
			<option value ="">Pilih</option>
			<?php
			while ($KR = mysql_fetch_array($QKRanah)){
			?>
			<option value ="<?php echo"$KR[kode_ranah]";?>"><?php echo"$KR[kode_ranah]";?></option>
			<?php
			}
			?>
			</select>
		</div>
	</div>
<?php
}
//"))
?>