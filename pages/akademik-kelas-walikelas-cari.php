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
$q=$_GET["q"];
?>
<div class='form-group'>
	<label class='control-label col-md-4'>Singkatan</label>
        <?php   
			$QSetPK = mysql_query("select * from ak_paketkeahlian where kode_pk='$q'");
			$HSetPK = mysql_fetch_array($QSetPK);
			$Singkatan = $HSetPK['singkatan'];
        ?>
        <div class='col-sm-1'>
			<input type='text' name='txtSingkat' class='input-sm input-mini form-control' value='<?php echo "$HSetPK[singkatan]";?>' readonly='readonly'/>
		</div>
</div>