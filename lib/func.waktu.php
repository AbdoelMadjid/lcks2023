<?php
/* 12/6/2016 --> Sabtu, 28 Januari 2017 13.10.40 --> 07/01/2023 18:42
Design and Programming By. Abdul Madjid, S.Pd., M.Pd.
SMK Negeri 1 Kadipaten
Pin 520543F3 HP. 0812-3000-0420
https://twitter.com/AbdoelMadjid 
https://www.facebook.com/abdulmadjid.mpd
*/
//eval(base64_decode("

function nyapadulur(){
	date_default_timezone_set("Asia/Jakarta");

	$waktu=gmdate("H:i",time()+7*3600);
	$t=explode(":",$waktu); 
	$jam=$t[0]; 
	$menit=$t[1];
	if ($jam >= 00 and $jam < 10 ){ 
	if ($menit >00 and $menit<60){ 
		$ucapan="Selamat Pagi"; 
	} 
	}else if ($jam >= 10 and $jam < 15 ){ 
	if ($menit >00 and $menit<60){ 
		$ucapan="Selamat Siang"; 
	} 
	}else if ($jam >= 15 and $jam < 18 ){ 
	if ($menit >00 and $menit<60){ 
		$ucapan="Selamat Sore"; 
	} 
	}else if ($jam >= 18 and $jam <= 24 ){ 
	if ($menit >00 and $menit<60){ 
		$ucapan="Selamat Malam"; 
	} 
	}else { 
		$ucapan="Error";
	}
	return $ucapan;
}

// PENANGGALAN ========================================================== 

function Tanggal($tgl="")
{
	global $NamaBulan;
	if(!empty($tgl) and substr($tgl,0,4)!="0000")
	{
		return intval(substr($tgl,8,2))." ".$NamaBulan[intval((substr($tgl,5,2)*1))-1]." ".substr($tgl,0,4);
	}
	else
	{
		return " ";
	}
}

function TglLengkap($tgl=""){
	global $Ref;
	if(!empty($tgl) and substr($tgl,0,4)!="0000")
	{
		$cHr = @$Ref->NamaHari[date("w",mktime(0,0,0,substr($tgl,5,2),substr($tgl,8,2),substr($tgl,0,4)))];
		return substr($tgl,8,2)." ".@$Ref->NamaBulan[(substr($tgl,5,2)*1)-1]." ".substr($tgl,0,4);
	}
	else {return " ";}
}


function HariTglLengkap($tgl=""){
	global $Ref;

	$day = date('D', strtotime($tgl));
	$dayList = array(
		'Sun' => 'Minggu',
		'Mon' => 'Senin',
		'Tue' => 'Selasa',
		'Wed' => 'Rabu',
		'Thu' => 'Kamis',
		'Fri' => 'Jumat',
		'Sat' => 'Sabtu'
	);

	if(!empty($tgl) and substr($tgl,0,4)!="0000")
	{
		$cHr = @$Ref->NamaHari[date("w",mktime(0,0,0,substr($tgl,5,2),substr($tgl,8,2),substr($tgl,0,4)))];
		return $dayList[$day].", ".substr($tgl,8,2)." ".@$Ref->NamaBulan[(substr($tgl,5,2)*1)-1]." ".substr($tgl,0,4);
	}
	else {return " ";}
}

function TgldanWaktu($tgl=""){
	global $Ref;
	if(!empty($tgl) and substr($tgl,0,4)!="0000")
	{
		$cHr = @$Ref->NamaHari[date("w",mktime(0,0,0,substr($tgl,5,2),substr($tgl,8,2),substr($tgl,0,4)))];
		return "<span class='text-info'>".substr($tgl,8,2)." ".@$Ref->NamaBulan[(substr($tgl,5,2)*1)-1]." ".substr($tgl,0,4)."</span> <span class='text-danger'>[".substr($tgl,11,8)."]</span>";
	}
	else {return " ";}
}

function AmbilHari($tgl=""){
	$day = date('D', strtotime($tgl));
	$dayList = array(
		'Sun' => 'Minggu',
		'Mon' => 'Senin',
		'Tue' => 'Selasa',
		'Wed' => 'Rabu',
		'Thu' => 'Kamis',
		'Fri' => 'Jumat',
		'Sat' => 'Sabtu'
	);
	return $dayList[$day];
}

function AmbilWaktu($tgl=""){
	global $Ref;
	if(!empty($tgl) and substr($tgl,0,4)!="0000")
	{
		$cHr = @$Ref->NamaHari[date("w",mktime(0,0,0,substr($tgl,5,2),substr($tgl,8,2),substr($tgl,0,4)))];
		return substr($tgl,11,8);
	}
	else {return " ";}
}

function makeInt($angka){
	if($angka<-0.0000001){return ceil($angka-0.0000001);}else{return floor($angka+0.0000001); }
}

function hijriyah(){
	$array_bulan=array("Muharram","Safar","Rabiul Awwal","Rabiul Akhir","Jumadil Awwal","Jumadil Akhir","Rajab","Sya'ban","Ramadhan","Syawal","Zulqaidah","Zulhijjah");
	$date=date("j");
	$month=date("n");
	$year=date("Y");
	if(($year>1582)||(($year=="1582") && ($month > 10))||(($year=="1582") && ($month=="10")&&($date >14)))
	{
		$jd=makeInt((1461*($year+4800+makeInt(($month-14)/12)))/4)+makeInt((367*($month-2-12*(makeInt(($month-14)/12))))/12)-makeInt((3*(makeInt(($year+4900+makeInt(($month-14)/12))/100)))/4)+$date-32075;
	}
	else
	{
		$jd=367*$year-makeInt((7*($year+5001+makeInt(($month-9)/7)))/4)+makeInt((275*$month)/9)+$date+1729777;
	}
	$wd=$jd%7;
	$l=$jd-1948440+10632;
	$n=makeInt(($l-1)/10631);
	$l=$l-10631*$n+354;
	$z=(makeInt((10985-$l)/5316))*(makeInt((50*$l)/17719))+(makeInt($l/5670))*(makeInt((43*$l)/15238));
	$l=$l-(makeInt((30-$z)/15))*(makeInt((17719*$z)/50))-(makeInt($z/16))*(makeInt((15238*$z)/43))+29;
	$m=makeInt((24*$l)/709);
	$d=$l-makeInt((709*$m)/24);
	$y=30*$n+$z-30;
	$g=$m-1;
	$final="$d $array_bulan[$g] $y H";
	return $final;
} 

function IsiTgl($labelna="",$tglX="Tgl",$bln="Bln",$thn="Thn",$Nilai="",$thnawal){
	global $NamaBulan;
	if(!empty($Nilai) and substr($Nilai,0,4)!="0000")
		{
			$th = explode("-",$Nilai);
			$nTgl = $th[2];//substr($Nilai,8,2);
			$nBln = $th[1];//substr($Nilai,5,2);
			$nThn = $th[0];//substr($Nilai,0,4);
		}
	else
		{
			$nTgl = "";
			$nBln = "";
			$nThn = "";
		}
	$TglOps = "";
	for ($i=101;$i<=131;$i++)
		{
		   $x = substr($i,1,2);
		   $x1 = $x;// < "10" ? "0".$x:$x;
		   $Sel = $x1==$nTgl?" selected ":"";
		   $x = $x*1;
		   $TglOps .="<option $Sel value='$x1'>$x</option>";
		}
	$TxtTgl = "<select class='input-sm' name='$tglX'><option value=''>Tgl.</option>$TglOps</select>";
	$BlnOps = "";
	for ($i=101;$i<=112;$i++)
		{
		   $x = substr($i,1,2);
		   $x1 = $x;// < "10" ? "0".$x:$x;
		   $Sel = $x1==$nBln?" selected ":"";
		   $x = $x*1;
		   $BlnOps .="<option $Sel value='$x1'>{$NamaBulan[$x-1]}</option>";
		}
	$TxtBln = "<select class='input-sm' name='$bln'><option value=''>Bulan</option>$BlnOps</select>";
	$ThnOps = "";
	for ($i=$thnawal;$i<=date('Y');$i++)
		{
		   $Sel = $i==$nThn?" selected ":"";
		   $ThnOps .="<option $Sel value='$i'>$i</option>";
		}
	$TxtThn = "<select class='input-sm' name='$thn'><option value=''>Thn.</option>$ThnOps</select>";
		$Txt = "
		<div class='form-group'>
			<label class='control-label col-md-4'> $labelna </label>
			<div class='col-sm-8'>$TxtTgl $TxtBln $TxtThn</div>
		</div>";
		return $Txt;
}

function IsiTgl2($labelna="",$tglX="Tgl",$bln="Bln",$thn="Thn",$Nilai=""){
	global $NamaBulan;
	if(!empty($Nilai) and substr($Nilai,0,4)!="0000")
		{
			$th = explode("-",$Nilai);
			$nTgl = $th[2];//substr($Nilai,8,2);
			$nBln = $th[1];//substr($Nilai,5,2);
			$nThn = $th[0];//substr($Nilai,0,4);
		}
	else
		{
			$nTgl = "";
			$nBln = "";
			$nThn = "";
		}
	$TglOps = "";
	for ($i=101;$i<=131;$i++)
		{
		   $x = substr($i,1,2);
		   $x1 = $x;// < "10" ? "0".$x:$x;
		   $Sel = $x1==$nTgl?" selected ":"";
		   $x = $x*1;
		   $TglOps .="<option $Sel value='$x1'>$x</option>";
		}
	$TxtTgl = "<select class='input-sm' name='$tglX'><option value=''>Tgl.</option>$TglOps</select>";
	$BlnOps = "";
	for ($i=101;$i<=112;$i++)
		{
		   $x = substr($i,1,2);
		   $x1 = $x;// < "10" ? "0".$x:$x;
		   $Sel = $x1==$nBln?" selected ":"";
		   $x = $x*1;
		   $BlnOps .="<option $Sel value='$x1'>{$NamaBulan[$x-1]}</option>";
		}
	$TxtBln = "<select class='input-sm' name='$bln'><option value=''>Bulan</option>$BlnOps</select>";
	$ThnOps = "";
	for ($i=2013;$i<=date('Y');$i++)
		{
		   $Sel = $i==$nThn?" selected ":"";
		   $ThnOps .="<option $Sel value='$i'>$i</option>";
		}
	$TxtThn = "<select class='input-sm' name='$thn'><option value=''>Thn.</option>$ThnOps</select>";
		$Txt = "
		<div class='form-group'>
			<label class='control-label col-md-4'> $labelna </label>
			<div class='col-sm-8'>$TxtTgl $TxtBln $TxtThn</div>
		</div>";
		return $Txt;
}

function NgesiTgl($labelna="",$tglX="Tgl",$bln="Bln",$thn="Thn",$Nilai=""){
	global $NamaBulan;
	if(!empty($Nilai) and substr($Nilai,0,4)!="0000")
		{
			$th = explode("-",$Nilai);
			$nTgl = $th[2];//substr($Nilai,8,2);
			$nBln = $th[1];//substr($Nilai,5,2);
			$nThn = $th[0];//substr($Nilai,0,4);
		}
	else
		{
			$nTgl = "";
			$nBln = "";
			$nThn = "";
		}
	$TglOps = "";
	for ($i=101;$i<=131;$i++)
		{
		   $x = substr($i,1,2);
		   $x1 = $x;// < "10" ? "0".$x:$x;
		   $Sel = $x1==$nTgl?" selected ":"";
		   $x = $x*1;
		   $TglOps .="<option $Sel value='$x1'>$x</option>";
		}
	$TxtTgl = "<select class='input-sm' name='$tglX'><option value=''>Tgl.</option>$TglOps</select>";
	$BlnOps = "";
	for ($i=101;$i<=112;$i++)
		{
		   $x = substr($i,1,2);
		   $x1 = $x;// < "10" ? "0".$x:$x;
		   $Sel = $x1==$nBln?" selected ":"";
		   $x = $x*1;
		   $BlnOps .="<option $Sel value='$x1'>{$NamaBulan[$x-1]}</option>";
		}
	$TxtBln = "<select class='input-sm' name='$bln'><option value=''>Bulan</option>$BlnOps</select>";
	$ThnOps = "";
	for ($i=1990;$i<=date('Y');$i++)
		{
		   $Sel = $i==$nThn?" selected ":"";
		   $ThnOps .="<option $Sel value='$i'>$i</option>";
		}
	$TxtThn = "<select class='input-sm' name='$thn'><option value=''>Thn.</option>$ThnOps</select>";
		$Txt = "
		<div class='form-group'>
			<label class='control-label col-md-4'> $labelna </label>
			<div class='col-sm-8'>$TxtTgl $TxtBln $TxtThn</div>
		</div>";
		return $Txt;
}

function PilihTgl($labelna="",$tglX="Tgl",$bln="Bln",$thn="Thn",$Nilai=""){
	global $NamaBulan;
	if(!empty($Nilai) and substr($Nilai,0,4)!="0000")
		{
			$th = explode("-",$Nilai);
			$nTgl = $th[2];//substr($Nilai,8,2);
			$nBln = $th[1];//substr($Nilai,5,2);
			$nThn = $th[0];//substr($Nilai,0,4);
		}
	else
		{
			$nTgl = "";
			$nBln = "";
			$nThn = "";
		}
	$TglOps = "";
	for ($i=101;$i<=131;$i++)
		{
		   $x = substr($i,1,2);
		   $x1 = $x;// < "10" ? "0".$x:$x;
		   $Sel = $x1==$nTgl?" selected ":"";
		   $x = $x*1;
		   $TglOps .="<option $Sel value='$x1'>$x</option>";
		}
	$TxtTgl = "<select class='input-sm' name='$tglX'><option value=''>Tgl.</option>$TglOps</select>";
	$BlnOps = "";
	for ($i=101;$i<=112;$i++)
		{
		   $x = substr($i,1,2);
		   $x1 = $x;// < "10" ? "0".$x:$x;
		   $Sel = $x1==$nBln?" selected ":"";
		   $x = $x*1;
		   $BlnOps .="<option $Sel value='$x1'>{$NamaBulan[$x-1]}</option>";
		}
	$TxtBln = "<select class='input-sm' name='$bln'><option value=''>Bulan</option>$BlnOps</select>";
	$ThnOps = "";
	for ($i=(date('Y')-100);$i<=date('Y');$i++)
		{
		   $Sel = $i==$nThn?" selected ":"";
		   $ThnOps .="<option $Sel value='$i'>$i</option>";
		}
	$TxtThn = "<select class='input-sm' name='$thn'><option value=''>Thn.</option>$ThnOps</select>";
		$Txt = "
		<div class='form-group'>
			<label class='control-label col-md-4'> $labelna </label>
			<div class='col-sm-8'>$TxtTgl $TxtBln $TxtThn</div>
		</div>";
		return $Txt;
}

function IsiTglHariIni($labelna="",$tglX="Tgl",$bln="Bln",$thn="Thn",$Nilai=""){
	global $NamaBulan;
	if(!empty($Nilai) and substr($Nilai,0,4)!="0000")
		{
			$th = explode("-",$Nilai);
			$nTgl = $th[2];//substr($Nilai,8,2);
			$nBln = $th[1];//substr($Nilai,5,2);
			$nThn = $th[0];//substr($Nilai,0,4);
		}
	else
		{
			$nTgl = date('d');
			$nBln = date('m');
			$nThn = date('Y');
		}
	$TglOps = "";
	for ($i=101;$i<=131;$i++)
		{
		   $x = substr($i,1,2);
		   $x1 = $x;// < "10" ? "0".$x:$x;
		   $Sel = $x1==$nTgl?" selected ":"";
		   $x = $x*1;
		   $TglOps .="<option $Sel value='$x1'>$x</option>";
		}
	$TxtTgl = "<select class='input-sm' name='$tglX'><option value=''>Tgl.</option>$TglOps</select>";
	$BlnOps = "";
	for ($i=101;$i<=112;$i++)
		{
		   $x = substr($i,1,2);
		   $x1 = $x;// < "10" ? "0".$x:$x;
		   $Sel = $x1==$nBln?" selected ":"";
		   $x = $x*1;
		   $BlnOps .="<option $Sel value='$x1'>{$NamaBulan[$x-1]}</option>";
		}
	$TxtBln = "<select class='input-sm' name='$bln'><option value=''>Bulan</option>$BlnOps</select>";
	$ThnOps = "";
	for ($i=2013;$i<=date('Y');$i++)
		{
		   $Sel = $i==$nThn?" selected ":"";
		   $ThnOps .="<option $Sel value='$i'>$i</option>";
		}
	$TxtThn = "<select class='input-sm' name='$thn'><option value=''>Thn.</option>$ThnOps</select>";
		$Txt = "
		<div class='form-group'>
			<label class='control-label col-md-4'> $labelna </label>
			<div class='col-sm-8'>$TxtTgl $TxtBln $TxtThn</div>
		</div>";
		return $Txt;
}

function timeline($created_time){
	date_default_timezone_set('Asia/Jakarta'); //Ganti dengan zona waktu negara
	$str = strtotime($created_time); // Rubah menjadi time dari parameter
	$today = strtotime(date('Y-m-d H:i:s')); //Waktu saat ini
	// Mengambil rentang waktu dalam menut...
	$time_differnce = $today-$str;
	// Kalkulasi rentang waktu tahun...
	$years = 60*60*24*365;
	// Kalkulasi rentang waktu bulan...
	$months = 60*60*24*30;
	// Kalkulasi rentang waktu hari...
	$days = 60*60*24;
	// Kalkulasi rentang waktu jam...
	$hours = 60*60;
	// Kalkulasi rentang waktu menit...
	$minutes = 60;
	if(intval($time_differnce/$years) > 1){
		return intval($time_differnce/$years)." tahun yang lalu";
	}
	else if(intval($time_differnce/$years) > 0){
		return intval($time_differnce/$years)." tahun yang lalu";
	}
	else if(intval($time_differnce/$months) > 1){
		return intval($time_differnce/$months)." bulan yang lalu";
	}
	else if(intval(($time_differnce/$months)) > 0){
		return intval(($time_differnce/$months))." bulan yang lalu";
	}
	else if(intval(($time_differnce/$days)) > 1){
		return intval(($time_differnce/$days))." hari yang lalu";
	}
	else if (intval(($time_differnce/$days)) > 0){
		return intval(($time_differnce/$days))." hari yang lalu";
	}
	else if (intval(($time_differnce/$hours)) > 1){
		return intval(($time_differnce/$hours))." jam yang lalu";
	}
	else if (intval(($time_differnce/$hours)) > 0){
		return intval(($time_differnce/$hours))." jam yang lalu";
	}
	else if (intval(($time_differnce/$minutes)) > 1){
		return intval(($time_differnce/$minutes))." menit yang lalu";
	}
	else if (intval(($time_differnce/$minutes)) > 0){
		return intval(($time_differnce/$minutes))." menit yang lalu";
	}
	else if (intval(($time_differnce)) > 1){
		return intval(($time_differnce))." detik yang lalu";
	}
	else{
		return "Baru saja";
	}
}

function hitung_umur($tanggal_lahir){
    list($year,$month,$day) = explode("-",$tanggal_lahir);
    $year_diff  = date("Y") - $year;
    $month_diff = date("m") - $month;
    $day_diff   = date("d") - $day;
    if ($month_diff < 0) $year_diff--;
        elseif (($month_diff==0) && ($day_diff < 0)) $year_diff--;
    return $year_diff;
}

function time_since($original){
  date_default_timezone_set('Asia/Jakarta');
  $chunks = array(
      array(60 * 60 * 24 * 365, 'tahun'),
      array(60 * 60 * 24 * 30, 'bulan'),
      array(60 * 60 * 24 * 7, 'minggu'),
      array(60 * 60 * 24, 'hari'),
      array(60 * 60, 'jam'),
      array(60, 'menit'),
  );
 
  $today = time();
  $since = $today - $original;
 
  if ($since > 604800)
  {
    $print = date("M jS", $original);
    if ($since > 31536000)
    {
      $print .= ", " . date("Y", $original);
    }
    return $print;
  }
 
  for ($i = 0, $j = count($chunks); $i < $j; $i++)
  {
    $seconds = $chunks[$i][0];
    $name = $chunks[$i][1];
 
    if (($count = floor($since / $seconds)) != 0)
      break;
  }
 
  $print = ($count == 1) ? '1 ' . $name : "$count {$name}";
  return $print . ' yang lalu';
}
?>