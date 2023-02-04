<?php 
/* 12/6/2016
Design and Programming By. Abdul Madjid, S.Pd., M.Pd.
SMK Negeri 1 Kadipaten
Pin 520543F3 HP. 0812-3000-0420
https://twitter.com/AbdoelMadjid 
https://www.facebook.com/abdulmadjid.mpd
*/
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING | E_DEPRECATED));
require_once 'koneksi.php';

$formatuploadex=(isset($_GET['formatuploadex']))?$_GET['formatuploadex']:"";
switch($formatuploadex)
{

	case "format-guru":
		header("Content-type: application/vnd-ms-excel");
		header("Content-Disposition: attachment; filename=format-guru.xls");
		echo "

		<table border='1'>
			<thead>
				<tr bgcolor='#cccccc'>
					<th class='text-center'>NO.</th>
					<th class='text-center'>NIP</th>
					<th class='text-center'>GELAR DEPAN</th>
					<th class='text-center'>NAMA TENAGA PENDIDIK</th>
					<th class='text-center'>GELAR BELAKANG</th>
					<th class='text-center'>USER ID</th>
					<th class='text-center'>KATA KUNCI</th>
					<th class='text-center'>HAK</th>
					<th class='text-center'>JENIS KELAMIN</th>
					<th class='text-center'>JENIS GURU</th>
				</tr>
			</thead>
			<tbody>";
				for($x=1;$x<=100;$x++){
					echo "
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>";
				}
		echo "
			</tbody>
		</table>";
	break;

	case "format-kikd":
		header("Content-type: application/vnd-ms-excel");
		header("Content-Disposition: attachment; filename=format-kikd.xls");
		echo "

		<table border='1'>
			<thead>
				<tr bgcolor='#cccccc'>
					<th class='text-center'>JENIS MAPEL</th>
					<th class='text-center'>KELOMPOK</th>
					<th class='text-center'>NAMA MAPEL</th>
					<th class='text-center'>TINGKAT</th>
					<th class='text-center'>KODE RANAH</th>
					<th class='text-center'>NO KIKD</th>
					<th class='text-center'>ISI KIKD</th>
				</tr>
			</thead>
			<tbody>";
				for($x=1;$x<=100;$x++){
					echo "
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>";
				}
		echo "
			</tbody>
		</table>";
	break;

	case "format-mapel":
		header("Content-type: application/vnd-ms-excel");
		header("Content-Disposition: attachment; filename=format-mapel.xls");
		echo "

		<table border='1'>
			<thead>
				<tr bgcolor='#cccccc'>
					<th class='text-center'>NO</th>
					<th class='text-center'>KODE PK</th>
					<th class='text-center'>KELOMPOK</th>
					<th class='text-center'>NO URUT MP</th>
					<th class='text-center'>NAMA MAPEL</th>
					<th class='text-center'>JENIS MAPEL</th>
					<th class='text-center'>SEMESTER 1</th>
					<th class='text-center'>SEMESTER 2</th>
					<th class='text-center'>SEMESTER 3</th>
					<th class='text-center'>SEMESTER 4</th>
					<th class='text-center'>SEMESTER 5</th>
					<th class='text-center'>SEMESTER 6</th>
				</tr>
			</thead>
			<tbody>";
				for($x=1;$x<=100;$x++){
					echo "
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>";
				}
			echo "
						</tbody>
					</table>
			";
	break;

	case "format-perkelas":
		header("Content-type: application/vnd-ms-excel");
		header("Content-Disposition: attachment; filename=format-perkelas.xls");
		echo "

		<table border='1'>
			<thead>
				<tr bgcolor='#cccccc'>
					<th class='text-center'>TAHUN AJARAN</th>
					<th class='text-center'>TINGKAT</th>
					<th class='text-center'>NAMA KELAS</th>
					<th class='text-center'>KODE PK</th>
					<th class='text-center'>NIS</th>
					<th class='text-center'>NAMA SISWA</th>
				</tr>
			</thead>
			<tbody>";
			
				for($x=1;$x<=100;$x++){
					echo "
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>";
				}
	echo "
			</tbody>
		</table>";
	
	break;

	case "format-siswa":
		header("Content-type: application/vnd-ms-excel");
		header("Content-Disposition: attachment; filename=format-siswa.xls");
		echo "

		<table border='1'>
			<thead>
				<tr bgcolor='#cccccc'>
					<th class='text-center'>NIS</th>
					<th class='text-center'>NISN</th>
					<th class='text-center'>THN MASUK</th>
					<th class='text-center'>KODE PK</th>
					<th class='text-center'>NAMA LENGKAP</th>
					<th class='text-center'>TEMPAT LAHIR</th>
					<th class='text-center'>TANGGAL LAHIR (YYYY-MM-DD)</th>
				</tr>
			</thead>
			<tbody>
			";
				for($x=1;$x<=100;$x++){
					echo "
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>";
				}
			echo "
			</tbody>
		</table>
	";
	break;
}
?>