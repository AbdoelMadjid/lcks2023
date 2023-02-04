<?php 
include '../lib/config.php'; 
$page = (isset($_POST['page']))? $_POST['page'] : 1;
$limit = 6; 
$limit_start = ($page - 1) * $limit;
$no = $limit_start + 1;
$QDtGuruT = $konak->query("SELECT * FROM app_user_guru where aktif='Y' LIMIT ".$limit_start.",".$limit);  
while($TDtGuruT = $QDtGuruT->fetch(PDO::FETCH_OBJ)) {
	if($TDtGuruT->jk=="Perempuan"){$Jk="female-big6.png";}else{$Jk="male-big6.png";}
	echo "
	<div class='user' title='".$TDtGuruT->nama_lengkap."'>
		<img src='".ASSETS_URL."/img/avatars/$Jk'><a href='javascript:void(0);'>".$TDtGuruT->nama_lengkap."</a>
		<div class='email'>Login : ".$TDtGuruT->kunjung."</div>
	</div>";
}

$QDtGuruT2 = $konak->query("SELECT * FROM app_user_guru where aktif='Y'");  
$total_records = $QDtGuruT2->rowCount();
$jumlah_page = ceil($total_records / $limit);
$jumlah_number = 1; //jumlah halaman ke kanan dan kiri dari halaman yang aktif
$start_number = ($page > $jumlah_number)? $page - $jumlah_number : 1;
$end_number = ($page < ($jumlah_page - $jumlah_number))? $page + $jumlah_number : $jumlah_page;

echo "<div class='text-center'>
<table class='table'><tr><td><ul class='pagination pagination-sm' style='margin-top:-5px;'>";
if($page == 1){
	echo '<li class="disabled"><a class="page-link" href="#">First</a></li>';
	echo '<li class="disabled"><a class="page-link" href="#"><span aria-hidden="true">&laquo;</span></a></li>';
} else {
	$link_prev = ($page > 1)? $page - 1 : 1;
	echo '<li class="halaman" id="1"><a class="page-link" href="#">First</a></li>';
	echo '<li class="halaman" id="'.$link_prev.'"><a class="page-link" href="#"><span aria-hidden="true">&laquo;</span></a></li>';
}

for($i = $start_number; $i <= $end_number; $i++){
	$link_active = ($page == $i)? ' active' : '';
	echo '<li class="halaman '.$link_active.'" id="'.$i.'"><a class="page-link" href="#">'.$i.'</a></li>';
}

if($page == $jumlah_page){
	echo '<li class="disabled"><a class="page-link" href="#"><span aria-hidden="true">&raquo;</span></a></li>';
	echo '<li class="disabled"><a class="page-link" href="#">Last</a></li>';
} else {
	$link_next = ($page < $jumlah_page)? $page + 1 : $jumlah_page;
	echo '<li class="halaman" id="'.$link_next.'"><a class="page-link" href="#"><span aria-hidden="true">&raquo;</span></a></li>';
	echo '<li class="halaman" id="'.$jumlah_page.'"><a class="page-link" href="#">Last</a></li>';
}

echo "</ul></td></tr></table></div>";

?>