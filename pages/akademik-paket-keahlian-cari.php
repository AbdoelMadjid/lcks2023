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
$pg=$_GET["pg"];
?>
<div class='form-group'>
	<label class='control-label col-md-4'>Program Keahlian</label>
	<div class='col-sm-8'>
		<select name="txtProgram" class='input-xlarge form-control'>    
        <?php   
        $qprogram = mysql_query("SELECT * FROM ak_programkeahlian where kode_bidang LIKE '%$pg%' group by kode_program");
        ?>
        <option value ="">Pilih</option>
        <?php
        while ($program = mysql_fetch_array($qprogram)){
        ?>
        <option value ="<?php echo"$program[kode_program]";?>"><?php echo"$program[nama_program]";?></option>
        <?php
        }
        ?>
		</select>
	</div>
</div>