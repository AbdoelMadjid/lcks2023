<?php
/* 12/6/2016 --> Sabtu, 28 Januari 2017 13.10.40 --> 07/01/2023 18:42
Design and Programming By. Abdul Madjid, S.Pd., M.Pd.
SMK Negeri 1 Kadipaten
Pin 520543F3 HP. 0812-3000-0420
https://twitter.com/AbdoelMadjid 
https://www.facebook.com/abdulmadjid.mpd
*/
//eval(base64_decode("

function DetailData($Label,$IsiLabel){
	return "
	<div class='row' style='margin-bottom:5px;'>
		<div class='col-xs-12 col-sm-2 col-md-4'>$Label</div>
		<div class='col-xs-12 col-sm-4 col-md-8'><strong class='text-danger'>$IsiLabel</strong></div>
	</div>";
}

function backup_db($table = '*') {
  $result = null;
  $tables = array();

  // check table yang akan di backup
  if ($table == '*') {
   $sql = 'SHOW TABLES';
   $rs = mysql_query($sql) or die ($sql);

   while ($row = mysql_fetch_array($rs)) {
    $name = $row[0];

    array_push($tables, $name);
   }
  } else {
   $tables = is_array($table) ? $table : explode(',', $table);
  }

  // loop table
  foreach ($tables as $table) {
   // create table
   $sql = 'SHOW CREATE TABLE '.$table;
   $rs = mysql_query($sql);
   $row = mysql_fetch_array($rs);
   $create_table = $row[1];

   // show data table
   $sql = 'SELECT * FROM '.$table;
   $rs = mysql_query($sql);

   // set field per table
   $fields = mysql_num_fields($rs);

   // create comment table
   $result .= 'DROP TABLE IF EXISTS '.$table.";\n";
   $result .= $create_table.";\n\n";

   // loop field per table
   for ($i=0; $i<$fields; $i++) {

    // loop data table
    while($row = mysql_fetch_array($rs)) {
     $result .= 'INSERT INTO '.$table.' VALUES (';

     // loop value field per table
     for ($j=0; $j<$fields; $j++) {
      $row[$j] = addslashes($row[$j]);
      $row[$j] = preg_replace('/\n/i','\\n',$row[$j]);

      if (isset($row[$j])) {
       $result .= '"'.$row[$j].'"';
      } else {
       $result .= 'NULL';
      }

      $result .= $j < ($fields - 1) ? ', ' : '';
     }

     $result .= ");\n";
    }
   }
   $result .= "\n\n\n";
  }

  $folderbackup="db_backup/";
  // simpan file sql
  $handle = fopen($folderbackup.'db-'.time().'-'.md5(implode(',', $tables)).'.sql', 'w+');
  fwrite($handle, $result);
  fclose($handle);
 }

 // -------------- RESIZE FUNCTION -------------
// Function for resizing any jpg, gif, or png image files
function ak_img_resize($target, $newcopy, $w, $h, $ext) {
    list($w_orig, $h_orig) = getimagesize($target);
    $scale_ratio = $w_orig / $h_orig;
    if (($w / $h) > $scale_ratio) {
           $w = $h * $scale_ratio;
    } else {
           $h = $w / $scale_ratio;
    }
    $img = "";
    $ext = strtolower($ext);
    if ($ext == "gif"){ 
    $img = imagecreatefromgif($target);
    } else if($ext =="png"){ 
    $img = imagecreatefrompng($target);
    } else { 
    $img = imagecreatefromjpeg($target);
    }
    $tci = imagecreatetruecolor($w, $h);
    // imagecopyresampled(dst_img, src_img, dst_x, dst_y, src_x, src_y, dst_w, dst_h, src_w, src_h)
    imagecopyresampled($tci, $img, 0, 0, 0, 0, $w, $h, $w_orig, $h_orig);
    if ($ext == "gif"){ 
        imagegif($tci, $newcopy);
    } else if($ext =="png"){ 
        imagepng($tci, $newcopy);
    } else { 
        imagejpeg($tci, $newcopy, 84);
    }
}
// ------------- THUMBNAIL (CROP) FUNCTION -------------
// Function for creating a true thumbnail cropping from any jpg, gif, or png image files
function ak_img_thumb($target, $newcopy, $w, $h, $ext) {
    list($w_orig, $h_orig) = getimagesize($target);
    $src_x = ($w_orig / 2) - ($w / 2);
    $src_y = ($h_orig / 2) - ($h / 2);
    $ext = strtolower($ext);
    $img = "";
    if ($ext == "gif"){ 
    $img = imagecreatefromgif($target);
    } else if($ext =="png"){ 
    $img = imagecreatefrompng($target);
    } else { 
    $img = imagecreatefromjpeg($target);
    }
    $tci = imagecreatetruecolor($w, $h);
    imagecopyresampled($tci, $img, 0, 0, $src_x, $src_y, $w, $h, $w, $h);
    if ($ext == "gif"){ 
        imagegif($tci, $newcopy);
    } else if($ext =="png"){ 
        imagepng($tci, $newcopy);
    } else { 
        imagejpeg($tci, $newcopy, 84);
    }
}

function daftar_file($dir) { 
	if(is_dir($dir)) { 
		if($handle = opendir($dir)) { //tampilkan semua file dalam folder kecuali 
			while(($file = readdir($handle)) !== false) { 
			$Lihat.='<a target="_blank" href="'.$dir.$file.'">'.$file.'</a><br>'."\n"; } 
			closedir($handle); 
		} 
	}
	return $Lihat;
}

function info_client_ip_getenv() {
     $ipaddress = '';
     if (getenv('HTTP_CLIENT_IP'))
         $ipaddress = getenv('HTTP_CLIENT_IP');
     else if(getenv('HTTP_X_FORWARDED_FOR'))
         $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
     else if(getenv('HTTP_X_FORWARDED'))
         $ipaddress = getenv('HTTP_X_FORWARDED');
     else if(getenv('HTTP_FORWARDED_FOR'))
         $ipaddress = getenv('HTTP_FORWARDED_FOR');
     else if(getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
     else if(getenv('REMOTE_ADDR'))
         $ipaddress = getenv('REMOTE_ADDR');
     else
         $ipaddress = 'UNKNOWN';

     return $ipaddress; 
}

/* 
 * -------------------------------------------------------
 * getGeoIP.freegeoip.net
 * -------------------------------------------------------
 * @Version: 1.0.0
 * @Author:  FireDart
 * @Link:    http://www.firedartstudios.com/
 * @GitHub:  https://github.com/FireDart/snippets/PHP/GeoIP/
 * @License: The MIT License (MIT)
 * 
 * Used to get geo information from a selected ip using the 
 * freegeoip.net service, up to 10,000 queries an hour.
 * 
 * -------------------------------------------------------
 * Requirements
 * -------------------------------------------------------
 * PHP 5.3.0+
 * 
 * -------------------------------------------------------
 * Usage
 * -------------------------------------------------------
 * Basic / Detect IP
 * getGeoIP();
 * 
 * Input IP to check
 * getGeoIP("aaa.bbb.ccc.ddd", false);
 * 
 */
/* 
 * getGeoIP
 * 
 * Returns GEO info about an IP address from 
 * FreeGeoIP.net, allows 10,000 queries per hour.
 * 
 * @param str     $ip        IP to check leave blank to get REMOTE_ADDR
 * @param boolean $jsonArray Return JSON as array?
 * @return (obj|booealn) If info can be return use obj, otherwise report false.
 */
function getGeoIP($ip = null, $jsonArray = false) {
	try {
		// If no IP is provided use the current users IP
		if($ip == null) {
			$ip   = filter_input(INPUT_SERVER, 'REMOTE_ADDR');
		}
		// If the IP is equal to 127.0.0.1 (IPv4) or ::1 (IPv6) then cancel, won't work on localhost
		if($ip == "127.0.0.1" || $ip == "::1") {
			throw new Exception('You are on a local sever, this script won\'t work right.');
		}
		// Make sure IP provided is valid
		if(!filter_var($ip, FILTER_VALIDATE_IP)) {
			throw new Exception('Invalid IP address "' . $ip . '".');
		}
		if(!is_bool($jsonArray)) {
			throw new Exception('The second parameter must be a boolean - true (return array) or false (return JSON object); default is false.');
		}
		// Fetch JSON data with the IP provided
		$url  = "http://freegeoip.net/json/" . $ip;
		// Return the contents, supress errors because we will check in a bit
		$json = @file_get_contents($url);
		// Did we manage to get data?
		if($json === false) {
			return false;
		}
		// Decode JSON
		$json = json_decode($json, $jsonArray);
		// If an error happens we can assume the JSON is bad or invalid IP
		if($json === null) {
			// Return false
			return false;
		} else {
			// Otherwise return JSON data
			return $json;
		}
	} catch(Exception $e) {
		return $e->getMessage();
	}
}


//");
?>