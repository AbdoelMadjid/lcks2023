<?php
/* 12/6/2016 --> Sabtu, 28 Januari 2017 13.10.40 --> 07/01/2023 18:42
Design and Programming By. Abdul Madjid, S.Pd., M.Pd.
SMK Negeri 1 Kadipaten
Pin 520543F3 HP. 0812-3000-0420
https://twitter.com/AbdoelMadjid 
https://www.facebook.com/abdulmadjid.mpd
*/
//eval(base64_decode("

function NgambilData($query="")
{
	$Query = mysql_query($query);
	$Hasil=mysql_fetch_array($Query);
	$Query1 = mysql_query($query);
	while ($Field=mysql_fetch_field($Query1))
	{
		$NmField = $Field->name;
		global $$NmField;
		$$NmField = $Hasil[$NmField]!='0'?$Hasil[$NmField]:"";
	}
}
function JmlDt($Q="")
{
	$Query=mysql_query($Q);
	$Hasil=mysql_num_rows($Query);
	return $Hasil;
}

class Database {
 
//bikin properties
    private $sql;
    private $query;
    private $data;
    private $count;
 
//    perintah query
    function query($sql) {
        
        $this->sql = $sql;
        $this->query = mysql_query($this->sql) or die(mysql_error());
        
    }
    
//    ambil hasil query
    function getData() {
        
        if (empty($this->query)) {
            echo 'query belum ada'; exit();
        } else {
            return $this->data = mysql_fetch_object($this->query);
        }
        
    }
    
//    hitung jumlah data hasil query
    function countData() {
        
        if (empty($this->query)) {
            echo 'query belum ada'; exit();
        } else {
            return $this->count = mysql_num_rows($this->query);
        }
        
    }
    
}

//");
?>