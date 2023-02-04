<?php
$QFiturMessages = "SELECT * FROM app_fitur where nama_fitur='messages' and tampilkan='Y'";  
$JFiturMessages = JmlDt($QFiturMessages);
if($JFiturMessages>=1){
	$TmplMessages='
		<!-- Note: The activity badge color changes when clicked and resets the number to 0
		Suggestion: You may want to set a flag when this happens to tick off all checked messages / notifications -->
		<span id="activity" class="activity-dropdown"> <i class="fa fa-user"></i> <b class="badge"> 21 </b> </span>

		<!-- AJAX-DROPDOWN : control this dropdown height, look and feel from the LESS variable file -->
		<div class="ajax-dropdown">

			<!-- the ID links are fetched via AJAX to the ajax container "ajax-notifications" -->
			<div class="btn-group btn-group-justified" data-toggle="buttons">
				<label class="btn btn-default">
					<input type="radio" name="activity" id="<?php echo APP_URL; ?>/ajax/notify/mail.php">
					Msgs (14) </label>
				<label class="btn btn-default">
					<input type="radio" name="activity" id="<?php echo APP_URL; ?>/ajax/notify/notifications.php">
					notify (3) </label>
				<label class="btn btn-default">
					<input type="radio" name="activity" id="<?php echo APP_URL; ?>/ajax/notify/tasks.php">
					Tasks (4) </label>
			</div>

			<!-- notification content -->
			<div class="ajax-notifications custom-scroll">

				<div class="alert alert-transparent">
					<h4>Click a button to show messages here</h4>
					This blank page message helps protect your privacy, or you can show the first message here automatically.
				</div>

				<i class="fa fa-lock fa-4x fa-border"></i>

			</div>
			<!-- end notification content -->

			<!-- footer: refresh area -->
			<span> Last updated on: 12/12/2013 9:43AM
				<button type="button" data-loading-text="<i class=\'fa fa-refresh fa-spin\'></i> Loading..." class="btn btn-xs btn-default pull-right">
					<i class="fa fa-refresh"></i>
				</button> </span>
			<!-- end footer -->

		</div>
		<!-- END AJAX-DROPDOWN -->
	';
}else {$TmplMessages="";}

$QFiturTrans = "SELECT * FROM app_fitur where nama_fitur='translate' and tampilkan='Y'";  
$JFiturTrans = JmlDt($QFiturTrans);
if($JFiturTrans>=1){
	$TTranslate='
		<ul class="header-dropdown-list hidden-xs">
			<li>
				<a href="#" class="dropdown-toggle" data-toggle="dropdown"> 
					<img src="<?php echo ASSETS_URL; ?>/img/blank.gif" class="flag flag-us" alt="United States"> <span> English (US) </span> <i class="fa fa-angle-down"></i> </a>
				<ul class="dropdown-menu pull-right">
					<li class="active">
						<a href="javascript:void(0);"><img src="<?php echo ASSETS_URL; ?>/img/blank.gif" class="flag flag-us" alt="United States"> English (US)</a>
					</li>
					<li>
						<a href="javascript:void(0);"><img src="<?php echo ASSETS_URL; ?>/img/blank.gif" class="flag flag-id" alt="Indonesia"> Indonesia</a>
					</li>	
				</ul>
			</li>
		</ul>

	';
}else {$TTranslate="";}

$QFiturVC = "SELECT * FROM app_fitur where nama_fitur='voice_command' and tampilkan='Y'";  
$JFiturVC = JmlDt($QFiturVC);
if($JFiturVC>=1){
	$TVC='
		<div id="speech-btn" class="btn-header transparent pull-right hidden-sm hidden-xs">
			<div> 
				<a href="javascript:void(0)" title="Voice Command" data-action="voiceCommand"><i class="fa fa-microphone"></i></a> 
				<div class="popover bottom"><div class="arrow"></div>
					<div class="popover-content">
						<h4 class="vc-title">Voice command activated <br><small>Please speak clearly into the mic</small></h4>
						<h4 class="vc-title-error text-center">
							<i class="fa fa-microphone-slash"></i> Voice command failed
							<br><small class="txt-color-red">Must <strong>"Allow"</strong> Microphone</small>
							<br><small class="txt-color-red">Must have <strong>Internet Connection</strong></small>
						</h4>
						<a href="javascript:void(0);" class="btn btn-success" onclick="commands.help()">See Commands</a> 
						<a href="javascript:void(0);" class="btn bg-color-purple txt-color-white" onclick="$(\'#speech-btn .popover\').fadeOut(50);">Close Popup</a> 
					</div>
				</div>
			</div>
		</div>
	';
}else {$TVC="";}

$QFiturSearch = "SELECT * FROM app_fitur where nama_fitur='search' and tampilkan='Y'";  
$JFiturSearch = JmlDt($QFiturSearch);
if($JFiturSearch>=1){
	$TSearch='
		<!-- search mobile button (this is hidden till mobile view port) -->
		<div id="search-mobile" class="btn-header transparent pull-right">
			<span> <a href="javascript:void(0)" title="Search"><i class="fa fa-search"></i></a> </span>
		</div>
		<!-- end search mobile button -->

		<!-- input: search field -->
		<form action="<?php echo APP_URL; ?>?page=search" class="header-search pull-right">
			<input type="text" name="param" placeholder="Find reports and more" id="search-fld">
			<button type="submit">
				<i class="fa fa-search"></i>
			</button>
			<a href="javascript:void(0);" id="cancel-search-js" title="Cancel Search"><i class="fa fa-times"></i></a>
		</form>
		<!-- end input: search field -->
	';
}else {$TSearch="";}

$QFiturFS = "SELECT * FROM app_fitur where nama_fitur='full_screen' and tampilkan='Y'";  
$JFiturFS = JmlDt($QFiturFS);
if($JFiturFS>=1){
	$TFS='
		<div id="fullscreen" class="btn-header transparent pull-right">
			<span> <a href="javascript:void(0);" title="Full Screen" data-action="launchFullscreen"><i class="fa fa-arrows-alt"></i></a> </span>
		</div>
	';
}else {$TFS="";}

$QFiturShortcut = "SELECT * FROM app_fitur where nama_fitur='shortcut' and tampilkan='Y'";  
$JFiturShortcut = JmlDt($QFiturShortcut);
if($JFiturShortcut>=1){
	$TmplShortcut='
		<div id="shortcut">
			<ul>
				<li>
					<a href="<?php echo APP_URL; ?>?page=inbox" class="jarvismetro-tile big-cubes bg-color-blue"> <span class="iconbox"> <i class="fa fa-envelope fa-4x"></i> <span>Mail <span class="label pull-right bg-color-darken">14</span></span> </span> </a>
				</li>
				<li>
					<a href="<?php echo APP_URL; ?>?page=calendar" class="jarvismetro-tile big-cubes bg-color-orangeDark"> <span class="iconbox"> <i class="fa fa-calendar fa-4x"></i> <span>Calendar</span> </span> </a>
				</li>
				<li>
					<a href="<?php echo APP_URL; ?>?page=gmap-xml" class="jarvismetro-tile big-cubes bg-color-purple"> <span class="iconbox"> <i class="fa fa-map-marker fa-4x"></i> <span>Maps</span> </span> </a>
				</li>
				<li>
					<a href="<?php echo APP_URL; ?>?page=invoice" class="jarvismetro-tile big-cubes bg-color-blueDark"> <span class="iconbox"> <i class="fa fa-book fa-4x"></i> <span>Invoice <span class="label pull-right bg-color-darken">99</span></span> </span> </a>
				</li>
				<li>
					<a href="<?php echo APP_URL; ?>?page=gallery" class="jarvismetro-tile big-cubes bg-color-greenLight"> <span class="iconbox"> <i class="fa fa-picture-o fa-4x"></i> <span>Gallery </span> </span> </a>
				</li>
				<li>
					<a href="<?php echo APP_URL; ?>?page=profile" class="jarvismetro-tile big-cubes selected bg-color-pinkDark"> <span class="iconbox"> <i class="fa fa-user fa-4x"></i> <span>My Profile </span> </span> </a>
				</li>
			</ul>
		</div>
	';
	$TmplShortcut2='<i class="fa fa-angle-down"></i>';
}