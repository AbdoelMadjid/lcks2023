<?php 
/* 07/07/2017 
Design and Programming By. Abdul Madjid, S.Pd., M.Pd.
SMK Negeri 1 Kadipaten
Pin 520543F3 HP. 0812-3000-0420
https://twitter.com/AbdoelMadjid 
https://www.facebook.com/abdulmadjid.mpd
*/
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING | E_DEPRECATED));
include "../lib/config.php";
session_start();
if($jmp=$_GET["jmp"]){
	?>
	<div class='form-group'>
		<label class='control-label col-md-4'>Mata Pelajaran</label>
		<div class='col-sm-4'>
			<select name="txtMP" class='form-control input-sm' onchange='LihatJenis(this.value)'>    
			<?php   
			$QJmapel = mysql_query("SELECT * FROM ak_matapelajaran where kode_pk='$jmp'" );
			?>
			<option value ="">Pilih</option>
			<?php
			while ($HMpl = mysql_fetch_array($QJmapel)){
			?>
			<option value ="<?php echo"$HMpl[nama_mapel]";?>"><?php echo"$HMpl[nama_mapel]";?></option>
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
		<label class='control-label col-md-4'>Jenis Mapel</label>
		<div class='col-sm-2'>
			<select name="txtJenisMapel" class='form-control input-sm'>    
			<?php  
			$QJmpl = mysql_query("SELECT * FROM ak_matapelajaran where nama_mapel='$mpnya'");
			while ($JMapel = mysql_fetch_array($QJmpl)){
			?>
			<option value ="<?php echo"$JMapel[jenismapel]";?>"><?php echo"$JMapel[jenismapel]";?></option>
			<?php
			}
			?>
			</select>
		</div>
	</div>
	<div class='form-group'>
		<label class='control-label col-md-4'>Kelompok</label>
		<div class='col-sm-2'>
			<select name="txtKelompok" class='form-control input-sm'>    
			<?php  
			$QKelMP = mysql_query("SELECT * FROM ak_matapelajaran where nama_mapel='$mpnya'");
			while ($KelMP = mysql_fetch_array($QKelMP)){
			?>
			<option value ="<?php echo"$KelMP[kelmapel]";?>"><?php echo"$KelMP[kelmapel]";?></option>
			<?php
			}
			?>
			</select>
		</div>
	</div>
<?php
}
?>
