<?php
defined("DB_HOST") ? null : define("DB_HOST", "127.0.0.1");
defined("DB_USER") ? null : define("DB_USER", "root");
defined("DB_PASSWORD") ? null : define("DB_PASSWORD", "");
defined("DB_NAME") ? null : define("DB_NAME", "db_smart");

mysql_connect(DB_HOST,DB_USER,DB_PASSWORD);
mysql_select_db(DB_NAME);

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

function cellColor($cells,$color){
    global $objPHPExcel;

    $objPHPExcel->getActiveSheet()->getStyle($cells)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
}

function cellColor1($cells,$color){
    global $objPHPExcelk1k2;

    $objPHPExcelk1k2->getActiveSheet()->getStyle($cells)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
}

function cellColor2($cells,$color){
    global $objPHPExcelk3;

    $objPHPExcelk3->getActiveSheet()->getStyle($cells)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
}

function cellColor3($cells,$color){
    global $objPHPExcelk4;

    $objPHPExcelk4->getActiveSheet()->getStyle($cells)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
}

function cellColor4($cells,$color){
    global $objPHPExcelutsuas;

    $objPHPExcelutsuas->getActiveSheet()->getStyle($cells)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
}

$Ref->NamaHari		= array("Minggu","Senin","Selasa","Rabu","Kamis","Jum'at","Sabtu");
$Ref->NamaBulan		= array("Januari","Pebruari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","Nopember","Desember");

function TglLengkap($tgl="")
{
	global $Ref;
	if(!empty($tgl) and substr($tgl,0,4)!="0000")
	{
		$cHr = @$Ref->NamaHari[date("w",mktime(0,0,0,substr($tgl,5,2),substr($tgl,8,2),substr($tgl,0,4)))];
		return substr($tgl,8,2)." ".@$Ref->NamaBulan[(substr($tgl,5,2)*1)-1]." ".substr($tgl,0,4);
	}
	else {return " ";}
}
?>