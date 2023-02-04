<?php
require_once("inc/init.php");
require_once("inc/config.ui.php");
$page_title = "Dashboard";
$page_css[] = "your_style.css";
include("inc/header.php");
$page_nav["beranda"]["active"] = true;
include("inc/nav.php");
echo '<div id="main" role="main">';
//$breadcrumbs["Misc"] = "";
include("inc/ribbon.php");
?>
	<div id="content">
		<div class="row">
			<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
				<h1><span class="semi-bold"><?php echo nyapadulur() ?></span> <i class="ultra-light"><small class="text-info slideInRight fast animated"> [ <?php echo $LevelUser; ?> ]</small></i> <br>
						<small class="text-danger slideInRight fast animated"><strong><?php echo $NamaPengguna; ?></strong></small></h1>
			</div>
			<div class="col-xs-12 col-sm-5 col-md-5 col-lg-8 hidden-xs hidden-sm">
				<ul id="sparks">
					<li class="sparks-info"><h5> Jumlah Login <span class="txt-color-blue"><?php echo $JmlLogin; ?></span></h5></li>
					<li class="sparks-info"><h5> Waktu Login <span class="txt-color-blue"><?php echo TglLengkap($WaktuLogin); ?></span></h5></li>
					<li class="sparks-info"><h5> ID Login <span class="txt-color-blue"><?php echo AmbilWaktu($WaktuLogin); ?></span></h5></li>
				</ul>
			</div>
		</div>
		<section id="widget-grid" class="">
			<div class="row">
				<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		
					<!-- Widget ID (each widget will need unique ID)-->
					<div class="jarviswidget well jarviswidget-color-darken" id="wid-id-0" data-widget-sortable="false" data-widget-deletebutton="false" data-widget-editbutton="false" data-widget-colorbutton="false">
						<!-- widget options:
						usage: <div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false">
		
						data-widget-colorbutton="false"
						data-widget-editbutton="false"
						data-widget-togglebutton="false"
						data-widget-deletebutton="false"
						data-widget-fullscreenbutton="false"
						data-widget-custombutton="false"
						data-widget-collapsed="true"
						data-widget-sortable="false"
		
						-->
						<header>
							<span class="widget-icon"> <i class="fa fa-barcode"></i> </span>
							<h2>Item #44761 </h2>
		
						</header>
		
						<!-- widget div-->
						<div>
		
							<!-- widget edit box -->
							<div class="jarviswidget-editbox">
								<!-- This area used as dropdown edit box -->
		
							</div>
							<!-- end widget edit box -->
		
							<!-- widget content -->
							<div class="widget-body no-padding">
		
								<div class="widget-body-toolbar">
		
									<div class="row">
										<span class='hidden-xs hidden-sm'>
										<div class="col-sm-4">
											<h6 style='margin-top:5px;margin-bottom:5px;'><i class='fa fa-home text-danger'></i> <span class='text-primary'><strong>Statistik</strong></span></h6>
										</div>
										</span>
										<div class="col-sm-8 text-align-right">
		
											<div class="btn-group">
												<a href="javascript:void(0)" class="btn btn-sm btn-primary"> <i class="fa fa-edit"></i> <span class='hidden-xs hidden-sm'>Edit </span></a>
											</div>
											<div class="btn-group">
												<a href="javascript:void(0)" class="btn btn-sm btn-success"> <i class="fa fa-plus"></i> <span class='hidden-xs hidden-sm'>Create New </span></a>
											</div>		
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-12">
											<div class="well well-sm">
												<div class="row">
													<div class="col-sm-12 col-md-12 col-lg-6">
															<div class="row">
																<div class="col-sm-12">
																	<div class="padding-10">
																		<ul class="nav nav-tabs tabs-pull-right">
																			<li>
																				<a href="#a1" data-toggle="tab">Recent Articles</a>
																			</li>
																			<li class="active">
																				<a href="#a2" data-toggle="tab">Data Guru</a>
																			</li>
																			<li class="pull-left">
																				<span class="margin-top-10 display-inline"><i class="fa fa-rss text-success"></i> Activity</span>
																			</li>
																		</ul>
								
																		<div class="tab-content padding-top-10">
																			<div class="tab-pane fade" id="a1">
																				<div class="row">
																					<div class="col-xs-2 col-sm-1">
																						<time datetime="2014-09-20" class="icon">
																							<strong>Jan</strong>
																							<span>10</span>
																						</time>
																					</div>
																					<div class="col-xs-10 col-sm-11">
																						<h6 class="no-margin"><a href="javascript:void(0);">Allice in Wonderland</a></h6>
																						<p>
																							Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi Nam eget dui.
																							Etiam rhoncus. Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero,
																							sit amet adipiscing sem neque sed ipsum. Nam quam nunc, blandit vel.
																						</p>
																					</div>
																					<div class="col-sm-12">
																						<hr>
																					</div>
																					<div class="col-xs-2 col-sm-1">
																						<time datetime="2014-09-20" class="icon">
																							<strong>Jan</strong>
																							<span>10</span>
																						</time>
																					</div>
																					<div class="col-xs-10 col-sm-11">
																						<h6 class="no-margin"><a href="javascript:void(0);">World Report</a></h6>
																						<p>
																							Morning our be dry. Life also third land after first beginning to evening cattle created let subdue you'll winged don't Face firmament.
																							You winged you're was Fruit divided signs lights i living cattle yielding over light life life sea, so deep.
																							Abundantly given years bring were after. Greater you're meat beast creeping behold he unto She'd doesn't. Replenish brought kind gathering Meat.
																						</p>
																					</div>
								
																					<div class="col-sm-12">
								
																						<br>
								
																					</div>
								
																				</div>
								
																			</div>
																			<div class="tab-pane fade in active" id="a2">
					<?php
					// Cek apakah terdapat data page pada URL
					$pg = (isset($_GET['pg']))? $_GET['pg'] : 1;
					
					$limit = 15; // Jumlah data per halamannya
					
					// Untuk menentukan dari data ke berapa yang akan ditampilkan pada tabel yang ada di database
					$limit_start = ($pg - 1) * $limit;
					
					// Buat query untuk menampilkan data siswa sesuai limit yang ditentukan
					//$QDtGuruT = mysqli_query($connect, "SELECT * FROM app_user_guru where aktif='Y' LIMIT ".$limit_start.",".$limit);
					$QDtGuruT = $konak->query("SELECT * FROM app_user_guru where aktif='Y' LIMIT ".$limit_start.",".$limit);  
					
					$noG = $limit_start + 1; // Untuk penomoran tabel
					while($TDtGuruT = $QDtGuruT->fetch(PDO::FETCH_OBJ)) {
						if($TDtGuruT->jk=="Perempuan"){$Jk="female.png";}else{$Jk="male.png";}
						?>
						<div class="user" title="<?php echo $TDtGuruT->nama_lengkap; ?>">
							<img src="<?php echo ASSETS_URL; ?>/img/avatars/<?php echo $Jk; ?>"><a href="javascript:void(0);" onclick="tampilkan()" id="nmguru"><?php echo $TDtGuruT->nama_lengkap; ?></a>
							<div class="email">Login : <?php echo $TDtGuruT->kunjung; ?></div>
						</div>
					<?php
						$noG++;
					}
					?>
																				<div class="text-center">
																					<ul class="pagination pagination-sm">
					<?php
					if($pg == 1){ // Jika page adalah page ke 1, maka disable link PREV
					?>
						<li class="disabled"><a href="#">First</a></li>
						<li class="disabled"><a href="#">&laquo;</a></li>
					<?php
					}else{ // Jika page bukan page ke 1
						$link_prev = ($pg > 1)? $pg - 1 : 1;
					?>
						<li><a href="index.php?pg=1">First</a></li>
						<li><a href="index.php?pg=<?php echo $link_prev; ?>">&laquo;</a></li>
					<?php
					}
					?>
					
					<!-- LINK NUMBER -->
					<?php
					// Buat query untuk menghitung semua jumlah data
					$QDtGuruT2 = $konak->query("SELECT * FROM app_user_guru where aktif='Y'");  
					$get_jumlah = $QDtGuruT2->rowCount();
					
					$jumlah_page = ceil($get_jumlah/$limit); // Hitung jumlah halamannya
					$jumlah_number = 3; // Tentukan jumlah link number sebelum dan sesudah page yang aktif
					$start_number = ($pg > $jumlah_number)? $pg - $jumlah_number : 1; // Untuk awal link number
					$end_number = ($pg < ($jumlah_page - $jumlah_number))? $pg + $jumlah_number : $jumlah_page; // Untuk akhir link number
					
					for($i = $start_number; $i <= $end_number; $i++){
						$link_active = ($pg == $i)? ' class="active"' : '';
					?>
						<li<?php echo $link_active; ?>><a href="index.php?pg=<?php echo $i; ?>"><?php echo $i; ?></a></li>
					<?php
					}
					?>
					
					<!-- LINK NEXT AND LAST -->
					<?php
					// Jika page sama dengan jumlah page, maka disable link NEXT nya
					// Artinya page tersebut adalah page terakhir 
					if($pg == $jumlah_page){ // Jika page terakhir
					?>
						<li class="disabled"><a href="#">&raquo;</a></li>
						<li class="disabled"><a href="#">Last</a></li>
					<?php
					}else{ // Jika Bukan page terakhir
						$link_next = ($pg < $jumlah_page)? $pg + 1 : $jumlah_page;
					?>
						<li><a href="index.php?pg=<?php echo $link_next; ?>">&raquo;</a></li>
						<li><a href="index.php?pg=<?php echo $jumlah_page; ?>">Last</a></li>
					<?php
					}
					?>

																					</ul>
																				</div>
																								
																				
								
																			</div><!-- end tab -->
																		</div>
								
																	</div>
								
																</div>
								
															</div>
															<!-- end row -->
														<form method="post" class="well padding-bottom-10" onsubmit="return false;">
															<fieldset>
																<legend>Kirim Pesan</legend>
																<div class="form-group">
																	<label class="col-md-2 control-label" for="select-1">Penerima</label>
																	<div class="col-md-10">
																		<select class="form-control" name='TxtPenerima' id="select-1">
																			<option value=''>Pilih Penerima</option>

																		<?php 
																		// jalankan query
																			$QDtGuru = $konak->query("SELECT * FROM app_user_guru where aktif='Y' order by nama_lengkap");  
																			$JDtGuru = $QDtGuru->rowCount();
																			while($TDtGuru = $QDtGuru->fetch(PDO::FETCH_OBJ)) {
																				 echo "<option value='$TDtGuru->id_guru'>$TDtGuru->nama_lengkap</option>";
																			}
																		?>
																		</select> 
									
																	</div>
																</div>
															</fieldset>
															<hr>
															<textarea rows="4" class="form-control" placeholder="What are you thinking?" name='TxtPesan'></textarea>
															<div class="margin-top-10">
																<button type="submit" class="btn btn-sm btn-primary pull-right">
																	Kirim Pesan
																</button>
																<a href="javascript:void(0);" class="btn btn-link profile-link-btn" rel="tooltip" data-placement="bottom" title="Add Location"><i class="fa fa-location-arrow"></i></a>
																<a href="javascript:void(0);" class="btn btn-link profile-link-btn" rel="tooltip" data-placement="bottom" title="Add Voice"><i class="fa fa-microphone"></i></a>
																<a href="javascript:void(0);" class="btn btn-link profile-link-btn" rel="tooltip" data-placement="bottom" title="Add Photo"><i class="fa fa-camera"></i></a>
																<a href="javascript:void(0);" class="btn btn-link profile-link-btn" rel="tooltip" data-placement="bottom" title="Add File"><i class="fa fa-file"></i></a>
															</div>
														</form>		
													</div>
													<div class="col-sm-12 col-md-12 col-lg-6">
								

								
														<span class="timeline-seperator text-center"> <span>10:30PM January 1st, 2013</span>
															<div class="btn-group pull-right">
																<a href="javascript:void(0);" data-toggle="dropdown" class="btn btn-default btn-xs dropdown-toggle"><span class="caret single"></span></a>
																<ul class="dropdown-menu text-left">
																	<li>
																		<a href="javascript:void(0);">Hide this post</a>
																	</li>
																	<li>
																		<a href="javascript:void(0);">Hide future posts from this user</a>
																	</li>
																	<li>
																		<a href="javascript:void(0);">Mark as spam</a>
																	</li>
																</ul>
															</div> </span>
														<div class="chat-body no-padding profile-message">
															<ul>
																<li class="message">
																	<img src="<?php echo ASSETS_URL; ?>/img/avatars/sunny.png" class="online">
																	<span class="message-text"> <a href="javascript:void(0);" class="username">John Doe <small class="text-muted pull-right ultra-light"> 2 Minutes ago </small></a> Can't divide were divide fish forth fish to. Was can't form the, living life grass darkness very
																		image let unto fowl isn't in blessed fill life yielding above all moved </span>
																	<ul class="list-inline font-xs">
																		<li>
																			<a href="javascript:void(0);" class="text-info"><i class="fa fa-reply"></i> Reply</a>
																		</li>
																		<li>
																			<a href="javascript:void(0);" class="text-danger"><i class="fa fa-thumbs-up"></i> Like</a>
																		</li>
																		<li>
																			<a href="javascript:void(0);" class="text-muted">Show All Comments (14)</a>
																		</li>
																		<li>
																			<a href="javascript:void(0);" class="text-primary">Edit</a>
																		</li>
																		<li>
																			<a href="javascript:void(0);" class="text-danger">Delete</a>
																		</li>
																	</ul>
																</li>
																<li class="message message-reply">
																	<img src="<?php echo ASSETS_URL; ?>/img/avatars/3.png" class="online">
																	<span class="message-text"> <a href="javascript:void(0);" class="username">Serman Syla</a> Haha! Yeah I know what you mean. Thanks for the file Sadi! <i class="fa fa-smile-o txt-color-orange"></i> </span>
								
																	<ul class="list-inline font-xs">
																		<li>
																			<a href="javascript:void(0);" class="text-muted">1 minute ago </a>
																		</li>
																		<li>
																			<a href="javascript:void(0);" class="text-danger"><i class="fa fa-thumbs-up"></i> Like</a>
																		</li>
																	</ul>
								
																</li>
																<li class="message message-reply">
																	<img src="<?php echo ASSETS_URL; ?>/img/avatars/4.png" class="online">
																	<span class="message-text"> <a href="javascript:void(0);" class="username">Sadi Orlaf </a> Haha! Yeah I know what you mean. Thanks for the file Sadi! <i class="fa fa-smile-o txt-color-orange"></i> </span>
								
																	<ul class="list-inline font-xs">
																		<li>
																			<a href="javascript:void(0);" class="text-muted">a moment ago </a>
																		</li>
																		<li>
																			<a href="javascript:void(0);" class="text-danger"><i class="fa fa-thumbs-up"></i> Like</a>
																		</li>
																	</ul>
																	<input class="form-control input-xs" placeholder="Type and enter" type="text">
																</li>
															</ul>
								
														</div>
								
														<span class="timeline-seperator text-center"> <span>11:30PM November 27th, 2013</span>
															<div class="btn-group pull-right">
																<a href="javascript:void(0);" data-toggle="dropdown" class="btn btn-default btn-xs dropdown-toggle"><span class="caret single"></span></a>
																<ul class="dropdown-menu text-left">
																	<li>
																		<a href="javascript:void(0);">Hide this post</a>
																	</li>
																	<li>
																		<a href="javascript:void(0);">Hide future posts from this user</a>
																	</li>
																	<li>
																		<a href="javascript:void(0);">Mark as spam</a>
																	</li>
																</ul>
															</div> </span>
														<div class="chat-body no-padding profile-message">
															<ul>
																<li class="message">
																	<img src="<?php echo ASSETS_URL; ?>/img/avatars/1.png" class="online">
																	<span class="message-text"> <a href="javascript:void(0);" class="username">John Doe <small class="text-muted pull-right ultra-light"> 2 Minutes ago </small></a> Can't divide were divide fish forth fish to. Was can't form the, living life grass darkness very image let unto fowl isn't in blessed fill life yielding above all moved </span>
																	<ul class="list-inline font-xs">
																		<li>
																			<a href="javascript:void(0);" class="text-info"><i class="fa fa-reply"></i> Reply</a>
																		</li>
																		<li>
																			<a href="javascript:void(0);" class="text-danger"><i class="fa fa-thumbs-up"></i> Like</a>
																		</li>
																		<li>
																			<a href="javascript:void(0);" class="text-muted">Show All Comments (14)</a>
																		</li>
																		<li>
																			<a href="javascript:void(0);" class="text-primary">Hide</a>
																		</li>
																	</ul>
																</li>
																<li class="message message-reply">
																	<img src="<?php echo ASSETS_URL; ?>/img/avatars/3.png" class="online">
																	<span class="message-text"> <a href="javascript:void(0);" class="username">Serman Syla</a> Haha! Yeah I know what you mean. Thanks for the file Sadi! <i class="fa fa-smile-o txt-color-orange"></i> </span>
								
																	<ul class="list-inline font-xs">
																		<li>
																			<a href="javascript:void(0);" class="text-muted">1 minute ago </a>
																		</li>
																		<li>
																			<a href="javascript:void(0);" class="text-danger"><i class="fa fa-thumbs-up"></i> Like</a>
																		</li>
																	</ul>
								
																</li>
																<li class="message message-reply">
																	<img src="<?php echo ASSETS_URL; ?>/img/avatars/4.png" class="online">
																	<span class="message-text"> <a href="javascript:void(0);" class="username">Sadi Orlaf </a> Haha! Yeah I know what you mean. Thanks for the file Sadi! <i class="fa fa-smile-o txt-color-orange"></i> </span>
								
																	<ul class="list-inline font-xs">
																		<li>
																			<a href="javascript:void(0);" class="text-muted">a moment ago </a>
																		</li>
																		<li>
																			<a href="javascript:void(0);" class="text-danger"><i class="fa fa-thumbs-up"></i> Like</a>
																		</li>
																	</ul>
								
																</li>
																<li class="message message-reply">
																	<img src="<?php echo ASSETS_URL; ?>/img/avatars/4.png" class="online">
																	<span class="message-text"> <a href="javascript:void(0);" class="username">Sadi Orlaf </a> Haha! Yeah I know what you mean. Thanks for the file Sadi! <i class="fa fa-smile-o txt-color-orange"></i> </span>
								
																	<ul class="list-inline font-xs">
																		<li>
																			<a href="javascript:void(0);" class="text-muted">a moment ago </a>
																		</li>
																		<li>
																			<a href="javascript:void(0);" class="text-danger"><i class="fa fa-thumbs-up"></i> Like</a>
																		</li>
																	</ul>
								
																</li>
																<li>
																	<div class="input-group wall-comment-reply">
																		<input id="btn-input" type="text" class="form-control" placeholder="Type your message here...">
																		<span class="input-group-btn">
																			<button class="btn btn-primary" id="btn-chat">
																				<i class="fa fa-reply"></i> Reply
																			</button> </span>
																	</div>
																</li>
															</ul>
								
														</div>
								
								
													</div>
												</div>
								
											</div>
								
								
									</div>
								
								</div>
		
							</div>
							<!-- end widget content -->
		
						</div>
						<!-- end widget div -->
		
					</div>
					<!-- end widget -->
		
				</article>
				<!-- WIDGET END -->
		
			</div>
		
			<!-- end row -->
		
		</section>
		<!-- end widget grid -->

	</div>
	<!-- END MAIN CONTENT -->

</div>
<!-- END MAIN PANEL -->
<!-- ==========================CONTENT ENDS HERE ========================== -->

<!-- PAGE FOOTER -->
<?php
	// include page footer
	include("inc/footer.php");
?>
<!-- END PAGE FOOTER -->

<?php 
	//include required scripts
	include("inc/scripts.php"); 
?>

<!-- PAGE RELATED PLUGIN(S) 
<script src="..."></script>-->

<script>

function tampilkan(){
 
  var pilih=document.getElementById("nmguru");
  var p_kontainer=document.getElementById("container");

}

</script>

<?php 
	//include footer
	include("inc/google-analytics.php"); 
?>