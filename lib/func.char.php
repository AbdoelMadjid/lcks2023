<?php
/* 12/6/2016 --> Sabtu, 28 Januari 2017 13.10.40 --> 07/01/2023 18:42
Design and Programming By. Abdul Madjid, S.Pd., M.Pd.
SMK Negeri 1 Kadipaten
Pin 520543F3 HP. 0812-3000-0420
https://twitter.com/AbdoelMadjid 
https://www.facebook.com/abdulmadjid.mpd
*/
//eval(base64_decode("

// ANGKA TERBILANG ===========================================
function kekatasite($x){
	$x=abs($x);$angka=array("","satu","dua","tiga","empat","lima","enam","tujuh","delapan","sembilan","sepuluh","sebelas");$temp="";
	if($x<12){$temp=" ".$angka[$x];}else if($x<20){$temp=kekatasite($x-10)." belas";}else if($x<100){$temp=kekatasite($x/10)." puluh". kekatasite($x%10);}else if($x<200){$temp=" seratus" . kekatasite($x-100);}else if($x<1000){$temp=kekatasite($x/100) . " ratus" . kekatasite($x%100);}else if($x<2000){$temp=" seribu" . kekatasite($x-1000);}else if($x<1000000){$temp=kekatasite($x/1000) . " ribu" . kekatasite($x%1000);}else if($x<1000000000){$temp=kekatasite($x/1000000) . " juta" . kekatasite($x%1000000);}else if($x<1000000000000){$temp=kekatasite($x/1000000000) . " milyar" . kekatasite(fmod($x,1000000000));}else if($x<1000000000000000){$temp=kekatasite($x/1000000000000) . " trilyun" . kekatasite(fmod($x,1000000000000));}return $temp;
}
function terbilang($x, $style=4)
{
	if($x<0){$hasil="minus ". trim(kekatasite($x));}else{$hasil=trim(kekatasite($x));}
	switch ($style){case 1:$hasil=strtoupper($hasil);break;case 2:$hasil=strtolower($hasil);break;case 3:$hasil=ucwords($hasil);break;default:$hasil=ucfirst($hasil);break;}
	return $hasil;
}

function buatKode($tabel="", $inisial="")
{
	$struktur=mysql_query("SELECT * FROM $tabel");
	$field=mysql_field_name($struktur,0);
	$panjang=mysql_field_len($struktur,0);

	$qry=mysql_query("SELECT MAX(".$field.") FROM ".$tabel);
	$row=mysql_fetch_array($qry); 
	if($row[0]==""){
		$angka=0;
	}
	else{
		$angka=substr($row[0],strlen($inisial));
	}
	$angka++;
	$angka=strval($angka); 
	$tmp="";
	for($i=1; $i<=($panjang-strlen($inisial)-strlen($angka)); $i++){
		$tmp=$tmp."0";
	}
	return $inisial.$tmp.$angka;
}

function genRndString($length = 5, $chars = 'SMKNEGERISATUKADIPATEN'){
    if($length > 0)
    {
        $len_chars = (strlen($chars) - 1);
        $the_chars = $chars{rand(0, $len_chars)};
        for ($i = 1; $i < $length; $i = strlen($the_chars))
        {
            $r = $chars{rand(0, $len_chars)};
            if ($r != $the_chars{$i - 1}) $the_chars .=  $r;
        }

        return $the_chars;
    }
}

function bCrypt($pass,$cost){
	$chars='./ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'; 
	// Build the beginning of the salt
	$salt=sprintf('$2a$%02d$',$cost);
	// Seed the random generator
	mt_srand();
	// Generate a random salt
	for($i=0;$i<22;$i++) $salt.=$chars[mt_rand(0,63)];
	// return the hash
    return crypt($pass,$salt);
}

function encrypt_decrypt($action, $string){
	$output = false;
	$encrypt_method = "AES-256-CBC";
	$secret_key = "Laa ilaaha illallah";
	$secret_iv = "muhammadur rasulullah";
	// hash
	$key = hash('sha256', $secret_key);
	// iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a
	// warning
	$iv = substr(hash('sha256', $secret_iv), 0, 16);
	if ($action == 'encrypt')
	{
		$output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
		$output = base64_encode($output);
	}
	else{
		if ($action == 'decrypt')
		{
			$output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
		}
	}
	return $output;
}


function grafikAing($isi,$leg,$wr) //================================================================[GRAFIK]
{   
	$z=0;
	$max=0;
	foreach($isi as $v)
	{
		if($v>$z){$max = $v;}
		$z = $v;
	}
	if($max < 80){$tg = 1;}
	if($max < 70){$tg = 2;}
	if($max < 60){$tg = 2;}
	if($max < 50){$tg = 3;}
	if($max < 40){$tg = 3;}
	if($max < 30){$tg = 3;}
	if($max < 20){$tg = 5;}
	if($max < 10){$tg = 10;}
	if($max < 5){$tg = 20;}

	if($max > 79){$tg = 0.5;}
	if($max > 200){$tg = 0.5;}
	if($max > 300){$tg = 0.25;}

	if(count($isi) < 10){$wd = 20;}else{$wd=15;}

	$Hasil = "<table id='simple-table' class='table table-striped table-bordered table-hover'>";
	$y = 0;
	for($x=0;$x<count($isi);$x++)
		{	$y++;
			if($isi[$x] > 0)
				{$tinggi = $isi[$x]*$tg;}
			else
				{$tinggi=1;}
			$Hasil .= "<tr><td class='text-right'>$leg[$x]</td><td>
			<img src='assets/images/graph/poll-$y.gif' height=$wd width=$tinggi noborder> &nbsp;&nbsp;<span class='badge badge-inverse'>$isi[$x]</span>
	</td>";
		}
	$Hasil .= "</table>";
	return $Hasil;
}

function TampilKIKD($ranah="",$judul="")
{
	Global $kbm;
	$DKDK=mysql_query("select * from ak_kikd,gmp_kikd where ak_kikd.id_kikd=gmp_kikd.kode_kikd and gmp_kikd.kode_ngajar='$kbm' and gmp_kikd.kode_ranah='$ranah' order by ak_kikd.no_kikd");
	$noKDK=1;
	while($HKDK=mysql_fetch_array($DKDK)){
		$KDK.="
		<tr>
			<td class='text-center'>$noKDK.</td>
			<td class='text-center'>".$HKDK['no_kikd']."</td>
			<td>".$HKDK['isikikd']."</td>
		</tr>";
		$noKDK++;
	}
		
	$TampilKIKD.="
	<table class='table'>
			<tr>
				<th class='text-center' width='10%'>No.</th>
				<th class='text-center' width='25%'>No. KIKD</th>
				<th class='text-center'>$judul</th>
			</tr>
		<tbody>$KDK</tbody>
	</table>";
	return $TampilKIKD;
}

function nilaik3($nilai)
{
	global $HLN,$kbmna;
	$QP=mysql_query("
	select (n_p_kikd.kikd_p + n_utsuas.uts + n_utsuas.uas)/3 as rerata from n_p_kikd,n_utsuas 
	where n_p_kikd.kd_ngajar='".$kbmna[$nilai]."' and n_p_kikd.nis='".$HLN['nis']."' and
	n_utsuas.kd_ngajar='".$kbmna[$nilai]."' and n_utsuas.nis='".$HLN['nis']."'");
	$HP=mysql_fetch_array($QP);
	$P=round($HP['rerata'],0);
	return $P;
}

function nilaik4($nilai)
{
	global $HLN,$kbmna;
	$QK=mysql_query("select kikd_k from n_k_kikd where kd_ngajar='".$kbmna[$nilai]."' and nis='".$HLN['nis']."'");
	$HK=mysql_fetch_array($QK);
	$Tmpl=$HK['kikd_k'];
	return $Tmpl;
}

function nilaiuts($nilai)
{
	global $HLN,$kbmna;
	$QK=mysql_query("select uts from n_utsuas where kd_ngajar='".$kbmna[$nilai]."' and nis='".$HLN['nis']."'");
	$HK=mysql_fetch_array($QK);
	$Tmpl=$HK['uts'];
	return $Tmpl;
}

function nilaiuas($nilai)
{
	global $HLN,$kbmna;
	$QK=mysql_query("select uas from n_utsuas where kd_ngajar='".$kbmna[$nilai]."' and nis='".$HLN['nis']."'");
	$HK=mysql_fetch_array($QK);
	$Tmpl=$HK['uas'];
	return $Tmpl;
}

//============================================================================= [ PENILAIAN DESKRIPSI DAN PERDIKAT ]

function predikat($naon)
{
	if($naon>=86 && $naon<=100){$hasil="A";}else
	if($naon>=71 && $naon<=85){$hasil="B";}else
	if($naon>=56 && $naon<=70){$hasil="C";}else
	if($naon>=0 && $naon<=55){$hasil="D";}
	return $hasil;
}
function deskripsi($naon)
{
	if($naon>=86 && $naon<=100){$hasil="Sangat Baik";}else
	if($naon>=71 && $naon<=85){$hasil="Baik";}else
	if($naon>=56 && $naon<=70){$hasil="Cukup";}else
	if($naon>=1 && $naon<=55){$hasil="Kurang";}else
	if($naon=0){$hasil="";}
	return $hasil;
}

function daftardeskripsi($naon="")
{
	///====================== TAMPILKAN DESKRIPSI 
	$Q=mysql_query($naon);
	$row=mysql_fetch_row($Q);
	if($row[3]=="Sangat Baik"){$SB1="$row[18]";}else{$SB1="";}
	if($row[4]=="Sangat Baik"){$SB2="$row[19]";}else{$SB2="";}
	if($row[5]=="Sangat Baik"){$SB3="$row[20]";}else{$SB3="";}
	if($row[6]=="Sangat Baik"){$SB4="$row[21]";}else{$SB4="";}
	if($row[7]=="Sangat Baik"){$SB5="$row[22]";}else{$SB5="";}
	if($row[8]=="Sangat Baik"){$SB6="$row[23]";}else{$SB6="";}
	if($row[9]=="Sangat Baik"){$SB7="$row[24]";}else{$SB7="";}
	if($row[10]=="Sangat Baik"){$SB8="$row[25]";}else{$SB8="";}
	if($row[11]=="Sangat Baik"){$SB9="$row[26]";}else{$SB9="";}
	if($row[12]=="Sangat Baik"){$SB10="$row[27]";}else{$SB10="";}
	if($row[13]=="Sangat Baik"){$SB11="$row[28]";}else{$SB11="";}
	if($row[14]=="Sangat Baik"){$SB12="$row[29]";}else{$SB12="";}
	if($row[15]=="Sangat Baik"){$SB13="$row[30]";}else{$SB13="";}
	if($row[16]=="Sangat Baik"){$SB14="$row[31]";}else{$SB14="";}
	if($row[17]=="Sangat Baik"){$SB15="$row[32]";}else{$SB15="";}

	if($row[3]!="Sangat Baik" && $row[4]!="Sangat Baik" && $row[5]!="Sangat Baik" && $row[6]!="Sangat Baik" && $row[7]!="Sangat Baik" && $row[8]!="Sangat Baik" && $row[9]!="Sangat Baik" && $row[10]!="Sangat Baik" && $row[11]!="Sangat Baik" && $row[12]!="Sangat Baik" && $row[13]!="Sangat Baik" && $row[14]!="Sangat Baik" && $row[15]!="Sangat Baik" && $row[16]!="Sangat Baik" && $row[17]!="Sangat Baik")
	{$SB="";}else{$SB="<strong>Tuntas dengan sangat baik</strong> pada ";}

	if($row[3]=="Baik"){$B1="$row[18]";}else{$B1="";}
	if($row[4]=="Baik"){$B2="$row[19]";}else{$B2="";}
	if($row[5]=="Baik"){$B3="$row[20]";}else{$B3="";}
	if($row[6]=="Baik"){$B4="$row[21]";}else{$B4="";}
	if($row[7]=="Baik"){$B5="$row[22]";}else{$B5="";}
	if($row[8]=="Baik"){$B6="$row[23]";}else{$B6="";}
	if($row[9]=="Baik"){$B7="$row[24]";}else{$B7="";}
	if($row[10]=="Baik"){$B8="$row[25]";}else{$B8="";}
	if($row[11]=="Baik"){$B9="$row[26]";}else{$B9="";}
	if($row[12]=="Baik"){$B10="$row[27]";}else{$B10="";}
	if($row[13]=="Baik"){$B11="$row[28]";}else{$B11="";}
	if($row[14]=="Baik"){$B12="$row[29]";}else{$B12="";}
	if($row[15]=="Baik"){$B13="$row[30]";}else{$B13="";}
	if($row[16]=="Baik"){$B14="$row[31]";}else{$B14="";}
	if($row[17]=="Baik"){$B15="$row[32]";}else{$B15="";}

	if($row[3]!="Baik" && $row[4]!="Baik" && $row[5]!="Baik" && $row[6]!="Baik" && $row[7]!="Baik" && $row[8]!="Baik" && $row[9]!="Baik" && $row[10]!="Baik" && $row[11]!="Baik" && $row[12]!="Baik" && $row[13]!="Baik" && $row[14]!="Baik" && $row[15]!="Baik" && $row[16]!="Baik" && $row[17]!="Baik")
	{$B="";}else{$B="<strong>Tuntas dengan baik</strong> pada ";}
		
	if($row[3]=="Cukup"){$C1="$row[18]";}else{$C1="";}
	if($row[4]=="Cukup"){$C2="$row[19]";}else{$C2="";}
	if($row[5]=="Cukup"){$C3="$row[20]";}else{$C3="";}
	if($row[6]=="Cukup"){$C4="$row[21]";}else{$C4="";}
	if($row[7]=="Cukup"){$C5="$row[22]";}else{$C5="";}
	if($row[8]=="Cukup"){$C6="$row[23]";}else{$C6="";}
	if($row[9]=="Cukup"){$C7="$row[24]";}else{$C7="";}
	if($row[10]=="Cukup"){$C8="$row[25]";}else{$C8="";}
	if($row[11]=="Cukup"){$C9="$row[26]";}else{$C9="";}
	if($row[12]=="Cukup"){$C10="$row[27]";}else{$C10="";}
	if($row[13]=="Cukup"){$C11="$row[28]";}else{$C11="";}
	if($row[14]=="Cukup"){$C12="$row[29]";}else{$C12="";}
	if($row[15]=="Cukup"){$C13="$row[30]";}else{$C13="";}
	if($row[16]=="Cukup"){$C14="$row[31]";}else{$C14="";}
	if($row[17]=="Cukup"){$C15="$row[32]";}else{$C15="";}

	if($row[3]!="Cukup" && $row[4]!="Cukup" && $row[5]!="Cukup" && $row[6]!="Cukup" && $row[7]!="Cukup" && $row[8]!="Cukup" && $row[9]!="Cukup" && $row[10]!="Cukup" && $row[11]!="Cukup" && $row[12]!="Cukup" && $row[13]!="Cukup" && $row[14]!="Cukup" && $row[15]!="Cukup" && $row[16]!="Cukup" && $row[17]!="Cukup")
	{$C="";}else{$C="<strong>Tuntas dengan cukup baik</strong> pada ";}

	if($row[3]=="Kurang"){$K1="$row[18]";}else{$K1="";}
	if($row[4]=="Kurang"){$K2="$row[19]";}else{$K2="";}
	if($row[5]=="Kurang"){$K3="$row[20]";}else{$K3="";}
	if($row[6]=="Kurang"){$K4="$row[21]";}else{$K4="";}
	if($row[7]=="Kurang"){$K5="$row[22]";}else{$K5="";}
	if($row[8]=="Kurang"){$K6="$row[23]";}else{$K6="";}
	if($row[9]=="Kurang"){$K7="$row[24]";}else{$K7="";}
	if($row[10]=="Kurang"){$K8="$row[25]";}else{$K8="";}
	if($row[11]=="Kurang"){$K9="$row[26]";}else{$K9="";}
	if($row[12]=="Kurang"){$K10="$row[27]";}else{$K10="";}
	if($row[13]=="Kurang"){$K11="$row[28]";}else{$K11="";}
	if($row[14]=="Kurang"){$K12="$row[29]";}else{$K12="";}
	if($row[15]=="Kurang"){$K13="$row[30]";}else{$K13="";}
	if($row[16]=="Kurang"){$K14="$row[31]";}else{$K14="";}
	if($row[17]=="Kurang"){$K15="$row[32]";}else{$K15="";}

	if($row[3]!="Kurang" && $row[4]!="Kurang" && $row[5]!="Kurang" && $row[6]!="Kurang" && $row[7]!="Kurang" && $row[8]!="Kurang" && $row[9]!="Kurang" && $row[10]!="Kurang" && $row[11]!="Kurang" && $row[12]!="Kurang" && $row[13]!="Kurang" && $row[14]!="Kurang" && $row[15]!="Kurang" && $row[16]!="Kurang" && $row[17]!="Kurang")
	{$K="";}else{$K="<strong>Namun belum tuntas </strong> pada ";}

	
	$DesSB="$SB $SB1 $SB2 $SB3 $SB4 $SB5 $SB6 $SB7 $SB8 $SB9 $SB10 $SB11 $SB12 $SB13 $SB14 $SB15"; 
	$DesB="$B $B1 $B2 $B3 $B4 $B5 $B6 $B7 $B8 $B9 $B10 $B11 $B12 $B13 $B14 $B15 "; 
	$DesC="$C $C1 $C2 $C3 $C4 $C5 $C6 $C7 $C8 $C9 $C10 $C11 $C12 $C13 $C14 $C15 "; 
	$DesK="$K $K1 $K2 $K3 $K4 $K5 $K6 $K7 $K8 $K9 $K10 $K11 $K12 $K13 $K14 $K15 "; 
	

	if($row[3]!="Sangat Baik" && $row[4]!="Sangat Baik" && $row[5]!="Sangat Baik" && $row[6]!="Sangat Baik" && $row[7]!="Sangat Baik" && $row[8]!="Sangat Baik" && $row[9]!="Sangat Baik" && $row[10]!="Sangat Baik" && $row[11]!="Sangat Baik" && $row[12]!="Sangat Baik" && $row[13]!="Sangat Baik" && $row[14]!="Sangat Baik" && $row[15]!="Sangat Baik" && $row[16]!="Sangat Baik" && $row[17]!="Sangat Baik")
	{
		$Tampilkan="$DesB $DesC $DesK";
	}
	else
	if($row[3]!="Kurang" && $row[4]!="Kurang" && $row[5]!="Kurang" && $row[6]!="Kurang" && $row[7]!="Kurang" && $row[8]!="Kurang" && $row[9]!="Kurang" && $row[10]!="Kurang" && $row[11]!="Kurang" && $row[12]!="Kurang" && $row[13]!="Kurang" && $row[14]!="Kurang" && $row[15]!="Kurang" && $row[16]!="Kurang" && $row[17]!="Kurang")		
	{
		$Tampilkan="$DesSB $DesC";
	}
	else{
		$Tampilkan="$DesSB $DesK";
	}

	/*
	*/

	//$Tampilkan="$DesSB $DesB $DesC $DesK";
	
	return $Tampilkan;
}	

function LieurMeutakeunDeskripsi($naon1="",$naon2="")
{
	///====================== TAMPILKAN DESKRIPSI 

	//identifikasi deskripsi dari nilai 
	$QNilaiKDP=mysql_query($naon1);
	$HNilKDP=mysql_fetch_row($QNilaiKDP);
	$PredikatKDP_1=deskripsi($HNilKDP[3]);
	$PredikatKDP_2=deskripsi($HNilKDP[4]);
	$PredikatKDP_3=deskripsi($HNilKDP[5]);
	$PredikatKDP_4=deskripsi($HNilKDP[6]);
	$PredikatKDP_5=deskripsi($HNilKDP[7]);
	$PredikatKDP_6=deskripsi($HNilKDP[8]);
	$PredikatKDP_7=deskripsi($HNilKDP[9]);
	$PredikatKDP_8=deskripsi($HNilKDP[10]);
	$PredikatKDP_9=deskripsi($HNilKDP[11]);
	$PredikatKDP_10=deskripsi($HNilKDP[12]);
	$PredikatKDP_11=deskripsi($HNilKDP[13]);
	$PredikatKDP_12=deskripsi($HNilKDP[14]);
	$PredikatKDP_13=deskripsi($HNilKDP[15]);
	$PredikatKDP_14=deskripsi($HNilKDP[16]);
	$PredikatKDP_15=deskripsi($HNilKDP[17]);

	$QKDMapelP=mysql_query($naon2);
	$RPeng=mysql_fetch_row($QKDMapelP);$DesKDP_id_1="(KD No. $RPeng[12]) $RPeng[13]";
	$RPeng=mysql_fetch_row($QKDMapelP);$DesKDP_id_2="(KD No. $RPeng[12]) $RPeng[13]";
	$RPeng=mysql_fetch_row($QKDMapelP);$DesKDP_id_3="(KD No. $RPeng[12]) $RPeng[13]";
	$RPeng=mysql_fetch_row($QKDMapelP);$DesKDP_id_4="(KD No. $RPeng[12]) $RPeng[13]";
	$RPeng=mysql_fetch_row($QKDMapelP);$DesKDP_id_5="(KD No. $RPeng[12]) $RPeng[13]";
	$RPeng=mysql_fetch_row($QKDMapelP);$DesKDP_id_6="(KD No. $RPeng[12]) $RPeng[13]";
	$RPeng=mysql_fetch_row($QKDMapelP);$DesKDP_id_7="(KD No. $RPeng[12]) $RPeng[13]";
	$RPeng=mysql_fetch_row($QKDMapelP);$DesKDP_id_8="(KD No. $RPeng[12]) $RPeng[13]";
	$RPeng=mysql_fetch_row($QKDMapelP);$DesKDP_id_9="(KD No. $RPeng[12]) $RPeng[13]";
	$RPeng=mysql_fetch_row($QKDMapelP);$DesKDP_id_10="(KD No. $RPeng[12]) $RPeng[13]";
	$RPeng=mysql_fetch_row($QKDMapelP);$DesKDP_id_11="(KD No. $RPeng[12]) $RPeng[13]";
	$RPeng=mysql_fetch_row($QKDMapelP);$DesKDP_id_12="(KD No. $RPeng[12]) $RPeng[13]";
	$RPeng=mysql_fetch_row($QKDMapelP);$DesKDP_id_13="(KD No. $RPeng[12]) $RPeng[13]";
	$RPeng=mysql_fetch_row($QKDMapelP);$DesKDP_id_14="(KD No. $RPeng[12]) $RPeng[13]";
	$RPeng=mysql_fetch_row($QKDMapelP);$DesKDP_id_15="(KD No. $RPeng[12]) $RPeng[13]";


	if($PredikatKDP_1=="Sangat Baik"){$SB1="$DesKDP_id_1";}else{$SB1="";}
	if($PredikatKDP_2=="Sangat Baik"){$SB2="$DesKDP_id_2";}else{$SB2="";}
	if($PredikatKDP_3=="Sangat Baik"){$SB3="$DesKDP_id_3";}else{$SB3="";}
	if($PredikatKDP_4=="Sangat Baik"){$SB4="$DesKDP_id_4";}else{$SB4="";}
	if($PredikatKDP_5=="Sangat Baik"){$SB5="$DesKDP_id_5";}else{$SB5="";}
	if($PredikatKDP_6=="Sangat Baik"){$SB6="$DesKDP_id_6";}else{$SB6="";}
	if($PredikatKDP_7=="Sangat Baik"){$SB7="$DesKDP_id_7";}else{$SB7="";}
	if($PredikatKDP_8=="Sangat Baik"){$SB8="$DesKDP_id_8";}else{$SB8="";}
	if($PredikatKDP_9=="Sangat Baik"){$SB9="$DesKDP_id_9";}else{$SB9="";}
	if($PredikatKDP_10=="Sangat Baik"){$SB10="$DesKDP_id_10";}else{$SB10="";}
	if($PredikatKDP_11=="Sangat Baik"){$SB11="$DesKDP_id_11";}else{$SB11="";}
	if($PredikatKDP_12=="Sangat Baik"){$SB12="$DesKDP_id_12";}else{$SB12="";}
	if($PredikatKDP_13=="Sangat Baik"){$SB13="$DesKDP_id_13";}else{$SB13="";}
	if($PredikatKDP_14=="Sangat Baik"){$SB14="$DesKDP_id_14";}else{$SB14="";}
	if($PredikatKDP_15=="Sangat Baik"){$SB15="$DesKDP_id_15";}else{$SB15="";}

	if($PredikatKDP_1!="Sangat Baik" && $PredikatKDP_2!="Sangat Baik" && $PredikatKDP_3!="Sangat Baik" && $PredikatKDP_4!="Sangat Baik" && $PredikatKDP_5!="Sangat Baik" && $PredikatKDP_6!="Sangat Baik" && $PredikatKDP_7!="Sangat Baik" && $PredikatKDP_8!="Sangat Baik" && $PredikatKDP_9!="Sangat Baik" && $PredikatKDP_10!="Sangat Baik" && $PredikatKDP_11!="Sangat Baik" && $PredikatKDP_12!="Sangat Baik" && $PredikatKDP_13!="Sangat Baik" && $PredikatKDP_14!="Sangat Baik" && $PredikatKDP_15!="Sangat Baik")
	{$SB="";}else{$SB="<strong>Tuntas dengan sangat baik</strong> pada ";}

	if($PredikatKDP_1=="Baik"){$B1="$DesKDP_id_1";}else{$B1="";}
	if($PredikatKDP_2=="Baik"){$B2="$DesKDP_id_2";}else{$B2="";}
	if($PredikatKDP_3=="Baik"){$B3="$DesKDP_id_3";}else{$B3="";}
	if($PredikatKDP_4=="Baik"){$B4="$DesKDP_id_4";}else{$B4="";}
	if($PredikatKDP_5=="Baik"){$B5="$DesKDP_id_5";}else{$B5="";}
	if($PredikatKDP_6=="Baik"){$B6="$DesKDP_id_6";}else{$B6="";}
	if($PredikatKDP_7=="Baik"){$B7="$DesKDP_id_7";}else{$B7="";}
	if($PredikatKDP_8=="Baik"){$B8="$DesKDP_id_8";}else{$B8="";}
	if($PredikatKDP_9=="Baik"){$B9="$DesKDP_id_9";}else{$B9="";}
	if($PredikatKDP_10=="Baik"){$B10="$DesKDP_id_10";}else{$B10="";}
	if($PredikatKDP_11=="Baik"){$B11="$DesKDP_id_11";}else{$B11="";}
	if($PredikatKDP_12=="Baik"){$B12="$DesKDP_id_12";}else{$B12="";}
	if($PredikatKDP_13=="Baik"){$B13="$DesKDP_id_13";}else{$B13="";}
	if($PredikatKDP_14=="Baik"){$B14="$DesKDP_id_14";}else{$B14="";}
	if($PredikatKDP_15=="Baik"){$B15="$DesKDP_id_15";}else{$B15="";}

	if($PredikatKDP_1!="Baik" && $PredikatKDP_2!="Baik" && $PredikatKDP_3!="Baik" && $PredikatKDP_4!="Baik" && $PredikatKDP_5!="Baik" && $PredikatKDP_6!="Baik" && $PredikatKDP_7!="Baik" && $PredikatKDP_8!="Baik" && $PredikatKDP_9!="Baik" && $PredikatKDP_10!="Baik" && $PredikatKDP_11!="Baik" && $PredikatKDP_12!="Baik" && $PredikatKDP_13!="Baik" && $PredikatKDP_14!="Baik" && $PredikatKDP_15!="Baik")
	{$B="";}else{$B="<strong>Tuntas dengan baik</strong> pada ";}
		
	if($PredikatKDP_1=="Cukup"){$C1="$DesKDP_id_1";}else{$C1="";}
	if($PredikatKDP_2=="Cukup"){$C2="$DesKDP_id_2";}else{$C2="";}
	if($PredikatKDP_3=="Cukup"){$C3="$DesKDP_id_3";}else{$C3="";}
	if($PredikatKDP_4=="Cukup"){$C4="$DesKDP_id_4";}else{$C4="";}
	if($PredikatKDP_5=="Cukup"){$C5="$DesKDP_id_5";}else{$C5="";}
	if($PredikatKDP_6=="Cukup"){$C6="$DesKDP_id_6";}else{$C6="";}
	if($PredikatKDP_7=="Cukup"){$C7="$DesKDP_id_7";}else{$C7="";}
	if($PredikatKDP_8=="Cukup"){$C8="$DesKDP_id_8";}else{$C8="";}
	if($PredikatKDP_9=="Cukup"){$C9="$DesKDP_id_9";}else{$C9="";}
	if($PredikatKDP_10=="Cukup"){$C10="$DesKDP_id_10";}else{$C10="";}
	if($PredikatKDP_11=="Cukup"){$C11="$DesKDP_id_11";}else{$C11="";}
	if($PredikatKDP_12=="Cukup"){$C12="$DesKDP_id_12";}else{$C12="";}
	if($PredikatKDP_13=="Cukup"){$C13="$DesKDP_id_13";}else{$C13="";}
	if($PredikatKDP_14=="Cukup"){$C14="$DesKDP_id_14";}else{$C14="";}
	if($PredikatKDP_15=="Cukup"){$C15="$DesKDP_id_15";}else{$C15="";}

	if($PredikatKDP_1!="Cukup" && $PredikatKDP_2!="Cukup" && $PredikatKDP_3!="Cukup" && $PredikatKDP_4!="Cukup" && $PredikatKDP_5!="Cukup" && $PredikatKDP_6!="Cukup" && $PredikatKDP_7!="Cukup" && $PredikatKDP_8!="Cukup" && $PredikatKDP_9!="Cukup" && $PredikatKDP_10!="Cukup" && $PredikatKDP_11!="Cukup" && $PredikatKDP_12!="Cukup" && $PredikatKDP_13!="Cukup" && $PredikatKDP_14!="Cukup" && $PredikatKDP_15!="Cukup")
	{$C="";}else{$C="<strong>Tuntas dengan cukup </strong> pada ";}

	if($PredikatKDP_1=="Kurang"){$K1="$DesKDP_id_1";}else{$K1="";}
	if($PredikatKDP_2=="Kurang"){$K2="$DesKDP_id_2";}else{$K2="";}
	if($PredikatKDP_3=="Kurang"){$K3="$DesKDP_id_3";}else{$K3="";}
	if($PredikatKDP_4=="Kurang"){$K4="$DesKDP_id_4";}else{$K4="";}
	if($PredikatKDP_5=="Kurang"){$K5="$DesKDP_id_5";}else{$K5="";}
	if($PredikatKDP_6=="Kurang"){$K6="$DesKDP_id_6";}else{$K6="";}
	if($PredikatKDP_7=="Kurang"){$K7="$DesKDP_id_7";}else{$K7="";}
	if($PredikatKDP_8=="Kurang"){$K8="$DesKDP_id_8";}else{$K8="";}
	if($PredikatKDP_9=="Kurang"){$K9="$DesKDP_id_9";}else{$K9="";}
	if($PredikatKDP_10=="Kurang"){$K10="$DesKDP_id_10";}else{$K10="";}
	if($PredikatKDP_11=="Kurang"){$K11="$DesKDP_id_11";}else{$K11="";}
	if($PredikatKDP_12=="Kurang"){$K12="$DesKDP_id_12";}else{$K12="";}
	if($PredikatKDP_13=="Kurang"){$K13="$DesKDP_id_13";}else{$K13="";}
	if($PredikatKDP_14=="Kurang"){$K14="$DesKDP_id_14";}else{$K14="";}
	if($PredikatKDP_15=="Kurang"){$K15="$DesKDP_id_15";}else{$K15="";}

	if($PredikatKDP_1!="Kurang" && $PredikatKDP_2!="Kurang" && $PredikatKDP_3!="Kurang" && $PredikatKDP_4!="Kurang" && $PredikatKDP_5!="Kurang" && $PredikatKDP_6!="Kurang" && $PredikatKDP_7!="Kurang" && $PredikatKDP_8!="Kurang" && $PredikatKDP_9!="Kurang" && $PredikatKDP_10!="Kurang" && $PredikatKDP_11!="Kurang" && $PredikatKDP_12!="Kurang" && $PredikatKDP_13!="Kurang" && $PredikatKDP_14!="Kurang" && $PredikatKDP_15!="Kurang")
	{$K="";}else{$K="<strong>Namun belum tuntas</strong> pada ";}


	$DesSB="$SB $SB1 $SB2 $SB3 $SB4 $SB5 $SB6 $SB7 $SB8 $SB9 $SB10 $SB11 $SB12 $SB13 $SB14 $SB15"; 
	$DesB="$B $B1 $B2 $B3 $B4 $B5 $B6 $B7 $B8 $B9 $B10 $B11 $B12 $B13 $B14 $B15 "; 
	$DesC="$C $C1 $C2 $C3 $C4 $C5 $C6 $C7 $C8 $C9 $C10 $C11 $C12 $C13 $C14 $C15 "; 
	$DesK="$K $K1 $K2 $K3 $K4 $K5 $K6 $K7 $K8 $K9 $K10 $K11 $K12 $K13 $K14 $K15 "; 
	$Tampilkan="$DesSB $DesB $DesC $DesK";

	/*

	if($PredikatKDP_1!="Sangat Baik" && $PredikatKDP_2!="Sangat Baik" && $PredikatKDP_3!="Sangat Baik" && $PredikatKDP_4!="Sangat Baik" && $PredikatKDP_5!="Sangat Baik" && $PredikatKDP_6!="Sangat Baik" && $PredikatKDP_7!="Sangat Baik" && $PredikatKDP_8!="Sangat Baik" && $PredikatKDP_9!="Sangat Baik" && $PredikatKDP_10!="Sangat Baik" && $PredikatKDP_11!="Sangat Baik" && $PredikatKDP_12!="Sangat Baik" && $PredikatKDP_13!="Sangat Baik" && $PredikatKDP_14!="Sangat Baik" && $PredikatKDP_15!="Sangat Baik")
	{
		$Tampilkan="$DesB $DesC $DesK";
	}
	else
	if($PredikatKDP_1!="Kurang" && $PredikatKDP_2!="Kurang" && $PredikatKDP_3!="Kurang" && $PredikatKDP_4!="Kurang" && $PredikatKDP_5!="Kurang" && $PredikatKDP_6!="Kurang" && $PredikatKDP_7!="Kurang" && $PredikatKDP_8!="Kurang" && $PredikatKDP_9!="Kurang" && $PredikatKDP_10!="Kurang" && $PredikatKDP_11!="Kurang" && $PredikatKDP_12!="Kurang" && $PredikatKDP_13!="Kurang" && $PredikatKDP_14!="Kurang" && $PredikatKDP_15!="Kurang")		
	{
		$Tampilkan="$DesSB $DesC";
	}
	else{
		$Tampilkan="$DesSB $DesK";
	}
	*/
	

	return $Tampilkan;
}	


function deskripsiKM($naon)
{
	if($naon>=95 && $naon<=100){$hasil="sudah bisa menunjukkan penguasaan yang sangat baik";}else
	if($naon>=85 && $naon<=94){$hasil="sudah bisa menunjukkan penguasaan yang baik";}else
	if($naon>=75 && $naon<=84){$hasil="sudah cukup bisa menunjukkan penguasaan materi";}else
	if($naon>=1 && $naon<=74){$hasil="masih kurang bisa menunjukkan penguasaan materi";}else
	if($naon=0){$hasil="";}
	return $hasil;
}

function TmplNilTP($naon1="",$Jml)
{
	$QNilaiKDP=mysql_query($naon1);
	$HNilKDP=mysql_fetch_row($QNilaiKDP);

	for ($x = 3; $x <= ($Jml+2); $x++) {
	  $Nilai.=deskripsiKM($HNilKDP[$x]);
	}
	
	return $Nilai;
}


function DesTP($naon1="",$Jml)
{
	$QNilaiKDP=mysql_query($naon1);
	$HNilKDP=mysql_fetch_row($QNilaiKDP);

	for ($x = 3; $x <= ($Jml+2); $x++) {
	  $TeuingLieur.=deskripsiKM($HNilKDP[$x])."<br>";
	}
	return $TeuingLieur;
}

function IsiTP($naon1="",$Jml,$IsiTP)
{
	$QNilaiKDP=mysql_query($naon1);
	$HNilKDP=mysql_fetch_row($QNilaiKDP);

	for ($x = 3; $x <= ($Jml+2); $x++) {
	  $TeuingLieur.=deskripsiKM($HNilKDP[$x])." ".$HNilKDP[$IsiTP]."<br>";
	}
	return $TeuingLieur;
}


function NilaiMaximalTP($naon1="")
{
	$QNilaiKDP=mysql_query($naon1);
	$HNilKDP=mysql_fetch_row($QNilaiKDP);
	
	$NilaiTP_1=$HNilKDP[3];
	$NilaiTP_2=$HNilKDP[4];
	$NilaiTP_3=$HNilKDP[5];
	$NilaiTP_4=$HNilKDP[6];
	$NilaiTP_5=$HNilKDP[7];
	$NilaiTP_6=$HNilKDP[8];
	$NilaiTP_7=$HNilKDP[9];
	$NilaiTP_8=$HNilKDP[10];
	$NilaiTP_9=$HNilKDP[11];
	$NilaiTP_10=$HNilKDP[12];
	$NilaiTP_11=$HNilKDP[13];
	$NilaiTP_12=$HNilKDP[14];
	$NilaiTP_13=$HNilKDP[15];
	$NilaiTP_14=$HNilKDP[16];
	$NilaiTP_15=$HNilKDP[17];

	$NilaiMaxTP=max($HNilKDP[3],$HNilKDP[4],$HNilKDP[5],$HNilKDP[6],$HNilKDP[7],$HNilKDP[8],$HNilKDP[9],$HNilKDP[10],$HNilKDP[11],$HNilKDP[12],$HNilKDP[13],$HNilKDP[14],$HNilKDP[15],$HNilKDP[16],$HNilKDP[17]);
	return $NilaiMaxTP;
}

function NilaiMinimalTP($naon1="")
{
	$QNilaiKDP=mysql_query($naon1);
	$HNilKDP=mysql_fetch_row($QNilaiKDP);
	
	$NilaiTP_1=$HNilKDP[3];
	$NilaiTP_2=$HNilKDP[4];
	$NilaiTP_3=$HNilKDP[5];
	$NilaiTP_4=$HNilKDP[6];
	$NilaiTP_5=$HNilKDP[7];
	$NilaiTP_6=$HNilKDP[8];
	$NilaiTP_7=$HNilKDP[9];
	$NilaiTP_8=$HNilKDP[10];
	$NilaiTP_9=$HNilKDP[11];
	$NilaiTP_10=$HNilKDP[12];
	$NilaiTP_11=$HNilKDP[13];
	$NilaiTP_12=$HNilKDP[14];
	$NilaiTP_13=$HNilKDP[15];
	$NilaiTP_14=$HNilKDP[16];
	$NilaiTP_15=$HNilKDP[17];

	$NilaiMinTP=min($HNilKDP[3],$HNilKDP[4],$HNilKDP[5],$HNilKDP[6],$HNilKDP[7],$HNilKDP[8],$HNilKDP[9],$HNilKDP[10],$HNilKDP[11],$HNilKDP[12],$HNilKDP[13],$HNilKDP[14],$HNilKDP[15],$HNilKDP[16],$HNilKDP[17]);
	return $NilaiMinTP;
}

function LieurMeutakeunDeskripsiKM($naon1="",$naon2="")
{
	///====================== TAMPILKAN DESKRIPSI 

	//identifikasi deskripsi dari nilai 
	$QNilaiKDP=mysql_query($naon1);
	$HNilKDP=mysql_fetch_row($QNilaiKDP);


	$PredikatKDP_1=deskripsiKM($HNilKDP[3]);
	$PredikatKDP_2=deskripsiKM($HNilKDP[4]);
	$PredikatKDP_3=deskripsiKM($HNilKDP[5]);
	$PredikatKDP_4=deskripsiKM($HNilKDP[6]);
	$PredikatKDP_5=deskripsiKM($HNilKDP[7]);
	$PredikatKDP_6=deskripsiKM($HNilKDP[8]);
	$PredikatKDP_7=deskripsiKM($HNilKDP[9]);
	$PredikatKDP_8=deskripsiKM($HNilKDP[10]);
	$PredikatKDP_9=deskripsiKM($HNilKDP[11]);
	$PredikatKDP_10=deskripsiKM($HNilKDP[12]);
	$PredikatKDP_11=deskripsiKM($HNilKDP[13]);
	$PredikatKDP_12=deskripsiKM($HNilKDP[14]);
	$PredikatKDP_13=deskripsiKM($HNilKDP[15]);
	$PredikatKDP_14=deskripsiKM($HNilKDP[16]);
	$PredikatKDP_15=deskripsiKM($HNilKDP[17]);
	
	$QKDMapelP=mysql_query($naon2);
	$RPeng=mysql_fetch_row($QKDMapelP);$DesKDP_id_1="($RPeng[12]) $RPeng[13]";
	$RPeng=mysql_fetch_row($QKDMapelP);$DesKDP_id_2="($RPeng[12]) $RPeng[13]";
	$RPeng=mysql_fetch_row($QKDMapelP);$DesKDP_id_3="($RPeng[12]) $RPeng[13]";
	$RPeng=mysql_fetch_row($QKDMapelP);$DesKDP_id_4="($RPeng[12]) $RPeng[13]";
	$RPeng=mysql_fetch_row($QKDMapelP);$DesKDP_id_5="($RPeng[12]) $RPeng[13]";
	$RPeng=mysql_fetch_row($QKDMapelP);$DesKDP_id_6="($RPeng[12]) $RPeng[13]";
	$RPeng=mysql_fetch_row($QKDMapelP);$DesKDP_id_7="($RPeng[12]) $RPeng[13]";
	$RPeng=mysql_fetch_row($QKDMapelP);$DesKDP_id_8="($RPeng[12]) $RPeng[13]";
	$RPeng=mysql_fetch_row($QKDMapelP);$DesKDP_id_9="($RPeng[12]) $RPeng[13]";
	$RPeng=mysql_fetch_row($QKDMapelP);$DesKDP_id_10="($RPeng[12]) $RPeng[13]";
	$RPeng=mysql_fetch_row($QKDMapelP);$DesKDP_id_11="($RPeng[12]) $RPeng[13]";
	$RPeng=mysql_fetch_row($QKDMapelP);$DesKDP_id_12="($RPeng[12]) $RPeng[13]";
	$RPeng=mysql_fetch_row($QKDMapelP);$DesKDP_id_13="($RPeng[12]) $RPeng[13]";
	$RPeng=mysql_fetch_row($QKDMapelP);$DesKDP_id_14="($RPeng[12]) $RPeng[13]";
	$RPeng=mysql_fetch_row($QKDMapelP);$DesKDP_id_15="($RPeng[12]) $RPeng[13]";


	if($PredikatKDP_1=="Sangat Baik"){$SB1="$DesKDP_id_1";}else{$SB1="";}
	if($PredikatKDP_2=="Sangat Baik"){$SB2="$DesKDP_id_2";}else{$SB2="";}
	if($PredikatKDP_3=="Sangat Baik"){$SB3="$DesKDP_id_3";}else{$SB3="";}
	if($PredikatKDP_4=="Sangat Baik"){$SB4="$DesKDP_id_4";}else{$SB4="";}
	if($PredikatKDP_5=="Sangat Baik"){$SB5="$DesKDP_id_5";}else{$SB5="";}
	if($PredikatKDP_6=="Sangat Baik"){$SB6="$DesKDP_id_6";}else{$SB6="";}
	if($PredikatKDP_7=="Sangat Baik"){$SB7="$DesKDP_id_7";}else{$SB7="";}
	if($PredikatKDP_8=="Sangat Baik"){$SB8="$DesKDP_id_8";}else{$SB8="";}
	if($PredikatKDP_9=="Sangat Baik"){$SB9="$DesKDP_id_9";}else{$SB9="";}
	if($PredikatKDP_10=="Sangat Baik"){$SB10="$DesKDP_id_10";}else{$SB10="";}
	if($PredikatKDP_11=="Sangat Baik"){$SB11="$DesKDP_id_11";}else{$SB11="";}
	if($PredikatKDP_12=="Sangat Baik"){$SB12="$DesKDP_id_12";}else{$SB12="";}
	if($PredikatKDP_13=="Sangat Baik"){$SB13="$DesKDP_id_13";}else{$SB13="";}
	if($PredikatKDP_14=="Sangat Baik"){$SB14="$DesKDP_id_14";}else{$SB14="";}
	if($PredikatKDP_15=="Sangat Baik"){$SB15="$DesKDP_id_15";}else{$SB15="";}

	if($PredikatKDP_1!="Sangat Baik" && $PredikatKDP_2!="Sangat Baik" && $PredikatKDP_3!="Sangat Baik" && $PredikatKDP_4!="Sangat Baik" && $PredikatKDP_5!="Sangat Baik" && $PredikatKDP_6!="Sangat Baik" && $PredikatKDP_7!="Sangat Baik" && $PredikatKDP_8!="Sangat Baik" && $PredikatKDP_9!="Sangat Baik" && $PredikatKDP_10!="Sangat Baik" && $PredikatKDP_11!="Sangat Baik" && $PredikatKDP_12!="Sangat Baik" && $PredikatKDP_13!="Sangat Baik" && $PredikatKDP_14!="Sangat Baik" && $PredikatKDP_15!="Sangat Baik")
	{$SB="";}else{$SB="<strong>Menunjukkan penguasaan yang sangat baik</strong> pada ";}

	if($PredikatKDP_1=="Baik"){$B1="$DesKDP_id_1";}else{$B1="";}
	if($PredikatKDP_2=="Baik"){$B2="$DesKDP_id_2";}else{$B2="";}
	if($PredikatKDP_3=="Baik"){$B3="$DesKDP_id_3";}else{$B3="";}
	if($PredikatKDP_4=="Baik"){$B4="$DesKDP_id_4";}else{$B4="";}
	if($PredikatKDP_5=="Baik"){$B5="$DesKDP_id_5";}else{$B5="";}
	if($PredikatKDP_6=="Baik"){$B6="$DesKDP_id_6";}else{$B6="";}
	if($PredikatKDP_7=="Baik"){$B7="$DesKDP_id_7";}else{$B7="";}
	if($PredikatKDP_8=="Baik"){$B8="$DesKDP_id_8";}else{$B8="";}
	if($PredikatKDP_9=="Baik"){$B9="$DesKDP_id_9";}else{$B9="";}
	if($PredikatKDP_10=="Baik"){$B10="$DesKDP_id_10";}else{$B10="";}
	if($PredikatKDP_11=="Baik"){$B11="$DesKDP_id_11";}else{$B11="";}
	if($PredikatKDP_12=="Baik"){$B12="$DesKDP_id_12";}else{$B12="";}
	if($PredikatKDP_13=="Baik"){$B13="$DesKDP_id_13";}else{$B13="";}
	if($PredikatKDP_14=="Baik"){$B14="$DesKDP_id_14";}else{$B14="";}
	if($PredikatKDP_15=="Baik"){$B15="$DesKDP_id_15";}else{$B15="";}

	if($PredikatKDP_1!="Baik" && $PredikatKDP_2!="Baik" && $PredikatKDP_3!="Baik" && $PredikatKDP_4!="Baik" && $PredikatKDP_5!="Baik" && $PredikatKDP_6!="Baik" && $PredikatKDP_7!="Baik" && $PredikatKDP_8!="Baik" && $PredikatKDP_9!="Baik" && $PredikatKDP_10!="Baik" && $PredikatKDP_11!="Baik" && $PredikatKDP_12!="Baik" && $PredikatKDP_13!="Baik" && $PredikatKDP_14!="Baik" && $PredikatKDP_15!="Baik")
	{$B="";}else{$B="<strong>Menunjukkan penguasaan yang baik</strong> pada ";}
		
	if($PredikatKDP_1=="Cukup"){$C1="$DesKDP_id_1";}else{$C1="";}
	if($PredikatKDP_2=="Cukup"){$C2="$DesKDP_id_2";}else{$C2="";}
	if($PredikatKDP_3=="Cukup"){$C3="$DesKDP_id_3";}else{$C3="";}
	if($PredikatKDP_4=="Cukup"){$C4="$DesKDP_id_4";}else{$C4="";}
	if($PredikatKDP_5=="Cukup"){$C5="$DesKDP_id_5";}else{$C5="";}
	if($PredikatKDP_6=="Cukup"){$C6="$DesKDP_id_6";}else{$C6="";}
	if($PredikatKDP_7=="Cukup"){$C7="$DesKDP_id_7";}else{$C7="";}
	if($PredikatKDP_8=="Cukup"){$C8="$DesKDP_id_8";}else{$C8="";}
	if($PredikatKDP_9=="Cukup"){$C9="$DesKDP_id_9";}else{$C9="";}
	if($PredikatKDP_10=="Cukup"){$C10="$DesKDP_id_10";}else{$C10="";}
	if($PredikatKDP_11=="Cukup"){$C11="$DesKDP_id_11";}else{$C11="";}
	if($PredikatKDP_12=="Cukup"){$C12="$DesKDP_id_12";}else{$C12="";}
	if($PredikatKDP_13=="Cukup"){$C13="$DesKDP_id_13";}else{$C13="";}
	if($PredikatKDP_14=="Cukup"){$C14="$DesKDP_id_14";}else{$C14="";}
	if($PredikatKDP_15=="Cukup"){$C15="$DesKDP_id_15";}else{$C15="";}

	if($PredikatKDP_1!="Cukup" && $PredikatKDP_2!="Cukup" && $PredikatKDP_3!="Cukup" && $PredikatKDP_4!="Cukup" && $PredikatKDP_5!="Cukup" && $PredikatKDP_6!="Cukup" && $PredikatKDP_7!="Cukup" && $PredikatKDP_8!="Cukup" && $PredikatKDP_9!="Cukup" && $PredikatKDP_10!="Cukup" && $PredikatKDP_11!="Cukup" && $PredikatKDP_12!="Cukup" && $PredikatKDP_13!="Cukup" && $PredikatKDP_14!="Cukup" && $PredikatKDP_15!="Cukup")
	{$C="";}else{$C="<strong>Menunjukkan penguasaan yang cukup </strong> pada ";}

	if($PredikatKDP_1=="Kurang"){$K1="$DesKDP_id_1";}else{$K1="";}
	if($PredikatKDP_2=="Kurang"){$K2="$DesKDP_id_2";}else{$K2="";}
	if($PredikatKDP_3=="Kurang"){$K3="$DesKDP_id_3";}else{$K3="";}
	if($PredikatKDP_4=="Kurang"){$K4="$DesKDP_id_4";}else{$K4="";}
	if($PredikatKDP_5=="Kurang"){$K5="$DesKDP_id_5";}else{$K5="";}
	if($PredikatKDP_6=="Kurang"){$K6="$DesKDP_id_6";}else{$K6="";}
	if($PredikatKDP_7=="Kurang"){$K7="$DesKDP_id_7";}else{$K7="";}
	if($PredikatKDP_8=="Kurang"){$K8="$DesKDP_id_8";}else{$K8="";}
	if($PredikatKDP_9=="Kurang"){$K9="$DesKDP_id_9";}else{$K9="";}
	if($PredikatKDP_10=="Kurang"){$K10="$DesKDP_id_10";}else{$K10="";}
	if($PredikatKDP_11=="Kurang"){$K11="$DesKDP_id_11";}else{$K11="";}
	if($PredikatKDP_12=="Kurang"){$K12="$DesKDP_id_12";}else{$K12="";}
	if($PredikatKDP_13=="Kurang"){$K13="$DesKDP_id_13";}else{$K13="";}
	if($PredikatKDP_14=="Kurang"){$K14="$DesKDP_id_14";}else{$K14="";}
	if($PredikatKDP_15=="Kurang"){$K15="$DesKDP_id_15";}else{$K15="";}

	if($PredikatKDP_1!="Kurang" && $PredikatKDP_2!="Kurang" && $PredikatKDP_3!="Kurang" && $PredikatKDP_4!="Kurang" && $PredikatKDP_5!="Kurang" && $PredikatKDP_6!="Kurang" && $PredikatKDP_7!="Kurang" && $PredikatKDP_8!="Kurang" && $PredikatKDP_9!="Kurang" && $PredikatKDP_10!="Kurang" && $PredikatKDP_11!="Kurang" && $PredikatKDP_12!="Kurang" && $PredikatKDP_13!="Kurang" && $PredikatKDP_14!="Kurang" && $PredikatKDP_15!="Kurang")
	{$K="";}else{$K="<strong>Namun belum menunjukkan penguasaan </strong> pada ";}


	$DesSB="$SB $SB1 $SB2 $SB3 $SB4 $SB5 $SB6 $SB7 $SB8 $SB9 $SB10 $SB11 $SB12 $SB13 $SB14 $SB15"; 
	$DesB="$B $B1 $B2 $B3 $B4 $B5 $B6 $B7 $B8 $B9 $B10 $B11 $B12 $B13 $B14 $B15 "; 
	$DesC="$C $C1 $C2 $C3 $C4 $C5 $C6 $C7 $C8 $C9 $C10 $C11 $C12 $C13 $C14 $C15 "; 
	$DesK="$K $K1 $K2 $K3 $K4 $K5 $K6 $K7 $K8 $K9 $K10 $K11 $K12 $K13 $K14 $K15 "; 
	

	$NilaiMaksimal=NilaiMaximalTP($naon1);

	if($HNilKDP[3]>0){$Nilai1.=$HNilKDP[3];}else{$Nilai1.="";}
	if($HNilKDP[4]>0){$Nilai2.=$HNilKDP[4];}else{$Nilai2.="";}
	if($HNilKDP[5]>0){$Nilai3.=$HNilKDP[5];}else{$Nilai3.="";}
	if($HNilKDP[6]>0){$Nilai4.=$HNilKDP[6];}else{$Nilai4.="";}
	if($HNilKDP[7]>0){$Nilai5.=$HNilKDP[7];}else{$Nilai5.="";}
	if($HNilKDP[8]>0){$Nilai6.=$HNilKDP[8];}else{$Nilai6.="";}
	if($HNilKDP[9]>0){$Nilai7.=$HNilKDP[9];}else{$Nilai6.="";}
	if($HNilKDP[10]>0){$Nilai8.=$HNilKDP[10];}else{$Nilai8.="";}
	if($HNilKDP[11]>0){$Nilai9.=$HNilKDP[11];}else{$Nilai9.="";}
	if($HNilKDP[12]>0){$Nilai10.=$HNilKDP[12];}else{$Nilai10.="";}
	if($HNilKDP[13]>0){$Nilai11.=$HNilKDP[13];}else{$Nilai11.="";}
	if($HNilKDP[14]>0){$Nilai12.=$HNilKDP[14];}else{$Nilai12.="";}
	if($HNilKDP[15]>0){$Nilai13.=$HNilKDP[15];}else{$Nilai13.="";}
	if($HNilKDP[16]>0){$Nilai14.=$HNilKDP[16];}else{$Nilai14.="";}
	if($HNilKDP[17]>0){$Nilai15.=$HNilKDP[17];}else{$Nilai15.="";}

	$Tampilkan=

	//$Tampilkan=$Nilai1.$Nilai3.$Nilai4.$Nilai5.$Nilai6.$Nilai7.$Nilai8.$Nilai9.$Nilai10.$Nilai11.$Nilai12.$Nilai13.$Nilai14.$Nilai15;

	$NilaiMaxTP=max($HNilKDP[3],$HNilKDP[4],$HNilKDP[5],$HNilKDP[6],$HNilKDP[7],$HNilKDP[8],$HNilKDP[9],$HNilKDP[10],$HNilKDP[11],$HNilKDP[12],$HNilKDP[13],$HNilKDP[14],$HNilKDP[15],$HNilKDP[16],$HNilKDP[17]);	
	
	
	
	//$Tampilkan=$NilaiMaksimal;



	//$Tampilkan="$DesSB $DesB $DesC $DesK";

	
	/*
	if($PredikatKDP_1!="Sangat Baik" && $PredikatKDP_2!="Sangat Baik" && $PredikatKDP_3!="Sangat Baik" && $PredikatKDP_4!="Sangat Baik" && $PredikatKDP_5!="Sangat Baik" && $PredikatKDP_6!="Sangat Baik" && $PredikatKDP_7!="Sangat Baik" && $PredikatKDP_8!="Sangat Baik" && $PredikatKDP_9!="Sangat Baik" && $PredikatKDP_10!="Sangat Baik" && $PredikatKDP_11!="Sangat Baik" && $PredikatKDP_12!="Sangat Baik" && $PredikatKDP_13!="Sangat Baik" && $PredikatKDP_14!="Sangat Baik" && $PredikatKDP_15!="Sangat Baik")
	{
		$Tampilkan="$DesB $DesC $DesK";
	}
	else
	if($PredikatKDP_1!="Kurang" && $PredikatKDP_2!="Kurang" && $PredikatKDP_3!="Kurang" && $PredikatKDP_4!="Kurang" && $PredikatKDP_5!="Kurang" && $PredikatKDP_6!="Kurang" && $PredikatKDP_7!="Kurang" && $PredikatKDP_8!="Kurang" && $PredikatKDP_9!="Kurang" && $PredikatKDP_10!="Kurang" && $PredikatKDP_11!="Kurang" && $PredikatKDP_12!="Kurang" && $PredikatKDP_13!="Kurang" && $PredikatKDP_14!="Kurang" && $PredikatKDP_15!="Kurang")		
	{
		$Tampilkan="$DesSB $DesC";
	}
	else{
		$Tampilkan="$DesSB $DesK";
	}
	
	*/

	return $Tampilkan;
}
?>
