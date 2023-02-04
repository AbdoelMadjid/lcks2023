<?php

//initilize the page
require_once("inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

/*---------------- PHP Custom Scripts ---------

YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
E.G. $page_title = "Custom Title" */

$page_title = "Buttons";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav["template"]["sub"]["ui_elements"]["sub"]["buttons"]["active"] = true;
include("inc/nav.php");

?>
<!-- ==========================CONTENT STARTS HERE ========================== -->

<!-- MAIN PANEL -->
<div id="main" role="main">
	<?php
		//configure ribbon (breadcrumbs) array("name"=>"url"), leave url empty if no url
		//$breadcrumbs["New Crumb"] => "http://url.com"
		$breadcrumbs["UI Elements"] = "";
		include("inc/ribbon.php");
	?>

	<!-- MAIN CONTENT -->
	<div id="content">

		<div class="row">
			<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
				<h1 class="page-title txt-color-blueDark"><i class="fa fa-desktop fa-fw "></i> UI Elements <span>>
					Buttons </span></h1>
			</div>
			<div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">
				<ul id="sparks" class="">
					<li class="sparks-info">
						<h5> My Income <span class="txt-color-blue">$47,171</span></h5>
						<div class="sparkline txt-color-blue hidden-mobile hidden-md hidden-sm">
							1300, 1877, 2500, 2577, 2000, 2100, 3000, 2700, 3631, 2471, 2700, 3631, 2471
						</div>
					</li>
					<li class="sparks-info">
						<h5> Site Traffic <span class="txt-color-purple"><i class="fa fa-arrow-circle-up" data-rel="bootstrap-tooltip" title="Increased"></i>&nbsp;45%</span></h5>
						<div class="sparkline txt-color-purple hidden-mobile hidden-md hidden-sm">
							110,150,300,130,400,240,220,310,220,300, 270, 210
						</div>
					</li>
					<li class="sparks-info">
						<h5> Site Orders <span class="txt-color-greenDark"><i class="fa fa-shopping-cart"></i>&nbsp;2447</span></h5>
						<div class="sparkline txt-color-greenDark hidden-mobile hidden-md hidden-sm">
							110,150,300,130,400,240,220,310,220,300, 270, 210
						</div>
					</li>
				</ul>
			</div>
		</div>

		<!-- widget grid -->
		<section id="widget-grid" class="">

			<!-- row -->

			<div class="row">

				<!-- NEW WIDGET START -->
				<article class="col-sm-12">

					<!-- Widget ID (each widget will need unique ID)-->
					<div class="jarviswidget well" id="wid-id-0a" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-custombutton="false" data-widget-sortable="false">
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
							<span class="widget-icon"> <i class="fa fa-hand-o-up"></i> </span>
							<h2>Buttons at a glance </h2>

						</header>

						<!-- widget div-->
						<div>

							<!-- widget edit box -->
							<div class="jarviswidget-editbox">
								<!-- This area used as dropdown edit box -->

							</div>
							<!-- end widget edit box -->

							<!-- widget content -->
							<div class="widget-body">
								<h1>Buttons at a glance...</h1>
								<p>
									See how aspects of the Bootstrap button system look and feel like at a glance.
								</p>
								<div class="table-responsive">
									<table class="table table-bordered">
										<thead>
											<tr>
												<th>Button</th>
												<th>btn-lg Button</th>
												<th>Small Button</th>
												<th>Small Mini</th>
												<th>Disabled Button</th>
												<th>Button with Icon</th>
												<th>Split Button</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td><a class="btn btn-default" href="javascript:void(0);">Default</a></td>
												<td><a class="btn btn-default btn-lg" href="javascript:void(0);">Default</a></td>
												<td><a class="btn btn-default btn-sm" href="javascript:void(0);">Default</a></td>
												<td><a class="btn btn-default btn-xs" href="javascript:void(0);">Default</a></td>
												<td><a class="btn btn-default disabled" href="javascript:void(0);">Default</a></td>
												<td><a class="btn btn-default" href="javascript:void(0);"><i class="fa fa-cog"></i> Default</a></td>
												<td>
												<div class="btn-group">
													<a class="btn btn-default" href="javascript:void(0);">Default</a>
													<a class="btn btn-default dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);"><span class="caret"></span></a>
													<ul class="dropdown-menu">
														<li>
															<a href="javascript:void(0);">Action</a>
														</li>
														<li>
															<a href="javascript:void(0);">Another action</a>
														</li>
														<li>
															<a href="javascript:void(0);">Something else here</a>
														</li>
														<li class="divider"></li>
														<li>
															<a href="javascript:void(0);">Separated link</a>
														</li>
													</ul>
												</div><!-- /btn-group --></td>
											</tr>
											<tr>
												<td><a class="btn btn-primary" href="javascript:void(0);">Primary</a></td>
												<td><a class="btn btn-primary btn-lg" href="javascript:void(0);">Primary</a></td>
												<td><a class="btn btn-primary btn-sm" href="javascript:void(0);">Primary</a></td>
												<td><a class="btn btn-primary btn-xs" href="javascript:void(0);">Primary</a></td>
												<td><a class="btn btn-primary disabled" href="javascript:void(0);">Primary</a></td>
												<td><a class="btn btn-primary" href="javascript:void(0);"><i class="fa fa-shopping-cart"></i> Primary</a></td>
												<td>
												<div class="btn-group">
													<a class="btn btn-primary" href="javascript:void(0);">Primary</a>
													<a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);"><span class="caret"></span></a>
													<ul class="dropdown-menu">
														<li>
															<a href="javascript:void(0);">Action</a>
														</li>
														<li>
															<a href="javascript:void(0);">Another action</a>
														</li>
														<li>
															<a href="javascript:void(0);">Something else here</a>
														</li>
														<li class="divider"></li>
														<li>
															<a href="javascript:void(0);">Separated link</a>
														</li>
													</ul>
												</div><!-- /btn-group --></td>
											</tr>
											<tr>
												<td><a class="btn btn-info" href="javascript:void(0);">Info</a></td>
												<td><a class="btn btn-info btn-lg" href="javascript:void(0);">Info</a></td>
												<td><a class="btn btn-info btn-sm" href="javascript:void(0);">Info</a></td>
												<td><a class="btn btn-info btn-xs" href="javascript:void(0);">Info</a></td>
												<td><a class="btn btn-info disabled" href="javascript:void(0);">Info</a></td>
												<td><a class="btn btn-info" href="javascript:void(0);"><i class="fa fa-exclamation-sign"></i> Info</a></td>
												<td>
												<div class="btn-group">
													<a class="btn btn-info" href="javascript:void(0);">Info</a>
													<a class="btn btn-info dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);"><span class="caret"></span></a>
													<ul class="dropdown-menu">
														<li>
															<a href="javascript:void(0);">Action</a>
														</li>
														<li>
															<a href="javascript:void(0);">Another action</a>
														</li>
														<li>
															<a href="javascript:void(0);">Something else here</a>
														</li>
														<li class="divider"></li>
														<li>
															<a href="javascript:void(0);">Separated link</a>
														</li>
													</ul>
												</div><!-- /btn-group --></td>
											</tr>
											<tr>
												<td><a class="btn btn-success" href="javascript:void(0);">Success</a></td>
												<td><a class="btn btn-success btn-lg" href="javascript:void(0);">Success</a></td>
												<td><a class="btn btn-success btn-sm" href="javascript:void(0);">Success</a></td>
												<td><a class="btn btn-success btn-xs" href="javascript:void(0);">Success</a></td>
												<td><a class="btn btn-success disabled" href="javascript:void(0);">Success</a></td>
												<td><a class="btn btn-success" href="javascript:void(0);"><i class="fa fa-check"></i> Success</a></td>
												<td>
												<div class="btn-group">
													<a class="btn btn-success" href="javascript:void(0);">Success</a>
													<a class="btn btn-success dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);"><span class="caret"></span></a>
													<ul class="dropdown-menu">
														<li>
															<a href="javascript:void(0);">Action</a>
														</li>
														<li>
															<a href="javascript:void(0);">Another action</a>
														</li>
														<li>
															<a href="javascript:void(0);">Something else here</a>
														</li>
														<li class="divider"></li>
														<li>
															<a href="javascript:void(0);">Separated link</a>
														</li>
													</ul>
												</div><!-- /btn-group --></td>
											</tr>
											<tr>
												<td><a class="btn btn-warning" href="javascript:void(0);">Warning</a></td>
												<td><a class="btn btn-warning btn-lg" href="javascript:void(0);">Warning</a></td>
												<td><a class="btn btn-warning btn-sm" href="javascript:void(0);">Warning</a></td>
												<td><a class="btn btn-warning btn-xs" href="javascript:void(0);">Warning</a></td>
												<td><a class="btn btn-warning disabled" href="javascript:void(0);">Warning</a></td>
												<td><a class="btn btn-warning" href="javascript:void(0);"><i class="fa fa-warning-sign"></i> Warning</a></td>
												<td>
												<div class="btn-group">
													<a class="btn btn-warning" href="javascript:void(0);">Warning</a>
													<a class="btn btn-warning dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);"><span class="caret"></span></a>
													<ul class="dropdown-menu">
														<li>
															<a href="javascript:void(0);">Action</a>
														</li>
														<li>
															<a href="javascript:void(0);">Another action</a>
														</li>
														<li>
															<a href="javascript:void(0);">Something else here</a>
														</li>
														<li class="divider"></li>
														<li>
															<a href="javascript:void(0);">Separated link</a>
														</li>
													</ul>
												</div><!-- /btn-group --></td>
											</tr>
											<tr>
												<td><a class="btn btn-danger" href="javascript:void(0);">Danger</a></td>
												<td><a class="btn btn-danger btn-lg" href="javascript:void(0);">Danger</a></td>
												<td><a class="btn btn-danger btn-sm" href="javascript:void(0);">Danger</a></td>
												<td><a class="btn btn-danger btn-xs" href="javascript:void(0);">Danger</a></td>
												<td><a class="btn btn-danger disabled" href="javascript:void(0);">Danger</a></td>
												<td><a class="btn btn-danger" href="javascript:void(0);"><i class="fa fa-remove"></i> Danger</a></td>
												<td>
												<div class="btn-group">
													<a class="btn btn-danger" href="javascript:void(0);">Danger</a>
													<a class="btn btn-danger dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);"><span class="caret"></span></a>
													<ul class="dropdown-menu">
														<li>
															<a href="javascript:void(0);">Action</a>
														</li>
														<li>
															<a href="javascript:void(0);">Another action</a>
														</li>
														<li>
															<a href="javascript:void(0);">Something else here</a>
														</li>
														<li class="divider"></li>
														<li>
															<a href="javascript:void(0);">Separated link</a>
														</li>
													</ul>
												</div><!-- /btn-group --></td>
											</tr>
										</tbody>
									</table>
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

			<!-- row -->
			<div class="row">

				<!-- NEW WIDGET START -->
				<article class="col-sm-12 col-md-12 col-lg-6">

					<!-- Widget ID (each widget will need unique ID)-->
					<div class="jarviswidget" id="wid-id-0" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-custombutton="false" data-widget-sortable="false">
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
							<span class="widget-icon"> <i class="fa fa-hand-o-up"></i> </span>
							<h2>Basic Buttons</h2>

						</header>

						<!-- widget div-->
						<div>

							<!-- widget edit box -->
							<div class="jarviswidget-editbox">
								<!-- This area used as dropdown edit box -->

							</div>
							<!-- end widget edit box -->

							<!-- widget content -->
							<div class="widget-body">
								<p class="alert alert-info">
									The icons below are the most basic ones, without any icons or additional css applied to it
								</p>

								<p>
									Buttons come in 6 different default color sets
									<code>
										.btn .btn-*
									</code>
									<code>
										.btn-default, .btn-primary, .btn-success... etc
									</code>
								</p>
								<a href="javascript:void(0);" class="btn btn-default">Default</a>
								<a href="javascript:void(0);" class="btn btn-primary">Primary</a>
								<a href="javascript:void(0);" class="btn btn-success">Success</a>
								<a href="javascript:void(0);" class="btn btn-info">Info</a>
								<a href="javascript:void(0);" class="btn btn-warning">Warning</a>
								<a href="javascript:void(0);" class="btn btn-danger">Danger</a>
								<a href="javascript:void(0);" class="btn btn-default disabled">Disabled</a>
								<a href="javascript:void(0);" class="btn btn-link">Link</a>

							</div>
							<!-- end widget content -->

						</div>
						<!-- end widget div -->

					</div>
					<!-- end widget -->

					<!-- Widget ID (each widget will need unique ID)-->
					<div class="jarviswidget" id="wid-id-2" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-custombutton="false" data-widget-sortable="false">
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
							<span class="widget-icon"> <i class="fa fa-hand-o-up"></i> </span>
							<h2>Button Sizes </h2>

						</header>

						<!-- widget div-->
						<div>

							<!-- widget edit box -->
							<div class="jarviswidget-editbox">
								<!-- This area used as dropdown edit box -->

							</div>
							<!-- end widget edit box -->

							<!-- widget content -->
							<div class="widget-body">
								<p>
									Large buttons to attract call to action
									<code>
										.btn .btn-lg
									</code>
								</p>
								<a href="javascript:void(0);" class="btn btn-primary btn-lg">Large button</a>&nbsp;<a href="javascript:void(0);" class="btn btn-default btn-lg">Large button</a>
								<hr class="simple">

								<p>
									The Default button
									<code>
										.btn .btn-default
									</code>
								</p>
								<a href="javascript:void(0);" class="btn btn-primary">Default button</a>&nbsp;<a href="javascript:void(0);" class="btn btn-default">Default button</a>
								<hr class="simple">

								<p>
									Small button for elegance
									<code>
										.btn .btn-sm
									</code>
								</p>
								<a href="javascript:void(0);" class="btn btn-primary btn-sm">Small button</a>&nbsp;<a href="javascript:void(0);" class="btn btn-default btn-sm">Small button</a>
								<hr class="simple">

								<p>
									Extra small button for added info
									<code>
										.btn .btn-xs
									</code>
								</p>
								<a href="javascript:void(0);" class="btn btn-primary btn-xs">Mini button</a>&nbsp;<a href="javascript:void(0);" class="btn btn-default btn-xs">Mini button</a>

							</div>
							<!-- end widget content -->

						</div>
						<!-- end widget div -->

					</div>
					<!-- end widget -->

					<!-- Widget ID (each widget will need unique ID)-->
					<div class="jarviswidget" id="wid-id-4" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-custombutton="false" data-widget-sortable="false">
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
							<span class="widget-icon"> <i class="fa fa-hand-o-up"></i> </span>
							<h2>Circle Buttons </h2>

						</header>

						<!-- widget div-->
						<div>

							<!-- widget edit box -->
							<div class="jarviswidget-editbox">
								<!-- This area used as dropdown edit box -->

							</div>
							<!-- end widget edit box -->

							<!-- widget content -->
							<div class="widget-body">

								<p>
									Extra Large round buttons
									<code>
										.btn-circle .btn-xl
									</code>
								</p>
								<ul class="demo-btns">
									<li>
										<a href="javascript:void(0);" class="btn btn-primary btn-circle btn-xl"><i class="glyphicon glyphicon-list"></i></a>
									</li>
									<li>
										<a href="javascript:void(0);" class="btn btn-default btn-circle btn-xl"><i class="glyphicon glyphicon-ok"></i></a>
									</li>
								</ul>

								<p>
									Large round buttons
									<code>
										.btn-circle .btn-lg
									</code>
								</p>
								<ul class="demo-btns">
									<li>
										<a href="javascript:void(0);" class="btn btn-primary btn-circle btn-lg"><i class="glyphicon glyphicon-list"></i></a>
									</li>
									<li>
										<a href="javascript:void(0);" class="btn btn-default btn-circle btn-lg"><i class="glyphicon glyphicon-ok"></i></a>
									</li>
								</ul>

								<p>
									Default round buttons
									<code>
										.btn-circle
									</code>
								</p>
								<ul class="demo-btns">
									<li>
										<a href="javascript:void(0);" class="btn btn-primary btn-circle"><i class="glyphicon glyphicon-list"></i></a>
									</li>
									<li>
										<a href="javascript:void(0);" class="btn btn-default btn-circle"><i class="glyphicon glyphicon-ok"></i></a>
									</li>
								</ul>

							</div>
							<!-- end widget content -->

						</div>
						<!-- end widget div -->

					</div>
					<!-- end widget -->

					<!-- Widget ID (each widget will need unique ID)-->
					<div class="jarviswidget" id="wid-id-6" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-custombutton="false" data-widget-sortable="false">
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
							<span class="widget-icon"> <i class="fa fa-hand-o-up"></i> </span>
							<h2>Drop Down buttons </h2>

						</header>

						<!-- widget div-->
						<div>

							<!-- widget edit box -->
							<div class="jarviswidget-editbox">
								<!-- This area used as dropdown edit box -->

							</div>
							<!-- end widget edit box -->

							<!-- widget content -->
							<div class="widget-body">

								<p>
									Button group with dropup/dropdown toggle
									<code>
										.btn-group
									</code>
								</p>

								<div class="btn-group">
									<button class="btn btn-primary">
										Drop Down
									</button>
									<button class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
										<span class="caret"></span>
									</button>
									<ul class="dropdown-menu">
										<li>
											<a href="javascript:void(0);">Action</a>
										</li>
										<li>
											<a href="javascript:void(0);">Another action</a>
										</li>
										<li>
											<a href="javascript:void(0);">Something else here</a>
										</li>
										<li class="divider"></li>
										<li>
											<a href="javascript:void(0);">Separated link</a>
										</li>
									</ul>
								</div>
								<div class="btn-group dropup">
									<button class="btn btn-default">
										Drop Up
									</button>
									<button class="btn btn-default dropdown-toggle" data-toggle="dropdown">
										<span class="caret"></span>
									</button>
									<ul class="dropdown-menu">
										<li>
											<a href="javascript:void(0);">Action</a>
										</li>
										<li>
											<a href="javascript:void(0);">Another action</a>
										</li>
										<li>
											<a href="javascript:void(0);">Something else here</a>
										</li>
										<li class="divider"></li>
										<li>
											<a href="javascript:void(0);">Separated link</a>
										</li>
									</ul>
								</div>

								<hr class="simple">

								<p>
									Default button dropdowns
									<code>
										.dropdown-toggle
									</code>
								</p>

								<div class="btn-group">
									<button class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
										Action <span class="caret"></span>
									</button>
									<ul class="dropdown-menu">
										<li>
											<a href="javascript:void(0);">Action</a>
										</li>
										<li>
											<a href="javascript:void(0);">Another action</a>
										</li>
										<li>
											<a href="javascript:void(0);">Something else here</a>
										</li>
										<li class="divider"></li>
										<li>
											<a href="javascript:void(0);">Separated link</a>
										</li>
									</ul>
								</div>
								<div class="btn-group">
									<button class="btn btn-default dropdown-toggle" data-toggle="dropdown">
										Action <span class="caret"></span>
									</button>
									<ul class="dropdown-menu">
										<li>
											<a href="javascript:void(0);">Action</a>
										</li>
										<li>
											<a href="javascript:void(0);">Another action</a>
										</li>
										<li>
											<a href="javascript:void(0);">Something else here</a>
										</li>
										<li class="divider"></li>
										<li>
											<a href="javascript:void(0);">Separated link</a>
										</li>
									</ul>
								</div>
								<hr class="simple">
								<p>
									Smaller button dropdowns
									<code>
										.btn-sm .dropdown-toggle
									</code>
								</p>
								<div class="btn-group">
									<button class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
										Action <span class="caret"></span>
									</button>
									<ul class="dropdown-menu">
										<li>
											<a href="javascript:void(0);">Action</a>
										</li>
										<li>
											<a href="javascript:void(0);">Another action</a>
										</li>
										<li>
											<a href="javascript:void(0);">Something else here</a>
										</li>
										<li class="divider"></li>
										<li>
											<a href="javascript:void(0);">Separated link</a>
										</li>
									</ul>
								</div>
								<div class="btn-group">
									<button class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
										Action <span class="caret"></span>
									</button>
									<ul class="dropdown-menu">
										<li>
											<a href="javascript:void(0);">Action</a>
										</li>
										<li>
											<a href="javascript:void(0);">Another action</a>
										</li>
										<li>
											<a href="javascript:void(0);">Something else here</a>
										</li>
										<li class="divider"></li>
										<li>
											<a href="javascript:void(0);">Separated link</a>
										</li>
									</ul>
								</div>
								<hr class="simple">

								<p>
									Extra small button dropdowns
									<code>
										.btn-xs .dropdown-toggle
									</code>
								</p>
								<div class="btn-group">
									<button class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown">
										Action <span class="caret"></span>
									</button>
									<ul class="dropdown-menu">
										<li>
											<a href="javascript:void(0);">Action</a>
										</li>
										<li>
											<a href="javascript:void(0);">Another action</a>
										</li>
										<li>
											<a href="javascript:void(0);">Something else here</a>
										</li>
										<li class="divider"></li>
										<li>
											<a href="javascript:void(0);">Separated link</a>
										</li>
									</ul>
								</div>
								<div class="btn-group">
									<button class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
										Action <span class="caret"></span>
									</button>
									<ul class="dropdown-menu">
										<li>
											<a href="javascript:void(0);">Action</a>
										</li>
										<li>
											<a href="javascript:void(0);">Another action</a>
										</li>
										<li>
											<a href="javascript:void(0);">Something else here</a>
										</li>
										<li class="divider"></li>
										<li>
											<a href="javascript:void(0);">Separated link</a>
										</li>
									</ul>
								</div>

								<hr class="simple">
								<h3>Multiple Level Dropdown <small><span class="label label-warning">New!</span></small></h3>
								<p>
									Custom created Multiple Level dropdown that works with ease! Simply use the class
									<code>
										.dropdown-menu .multi-level
									</code>
								</p>
								<div class="dropdown">
									<a id="dLabel" role="button" data-toggle="dropdown" class="btn btn-primary" data-target="#" href="javascript:void(0);"> Multi Level <span class="caret"></span> </a>
									<ul class="dropdown-menu multi-level" role="menu">
										<li>
											<a href="javascript:void(0);">Some action</a>
										</li>
										<li>
											<a href="javascript:void(0);">Some other action</a>
										</li>
										<li class="divider"></li>
										<li class="dropdown-submenu">
											<a tabindex="-1" href="javascript:void(0);">Hover me for more options</a>
											<ul class="dropdown-menu">
												<li>
													<a tabindex="-1" href="javascript:void(0);">Second level</a>
												</li>
												<li class="dropdown-submenu">
													<a href="javascript:void(0);">Even More..</a>
													<ul class="dropdown-menu">
														<li>
															<a href="javascript:void(0);">3rd level</a>
														</li>
														<li>
															<a href="javascript:void(0);">3rd level</a>
														</li>
													</ul>
												</li>
												<li>
													<a href="javascript:void(0);">Second level</a>
												</li>
												<li>
													<a href="javascript:void(0);">Second level</a>
												</li>
											</ul>
										</li>
									</ul>
								</div>

							</div>
							<!-- end widget content -->

						</div>
						<!-- end widget div -->

					</div>
					<!-- end widget -->

					<!-- Widget ID (each widget will need unique ID)-->
					<div class="jarviswidget" id="wid-id-8" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-custombutton="false" data-widget-sortable="false">
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
							<span class="widget-icon"> <i class="fa fa-hand-o-up"></i> </span>
							<h2>Button Groups </h2>

						</header>

						<!-- widget div-->
						<div>

							<!-- widget edit box -->
							<div class="jarviswidget-editbox">
								<!-- This area used as dropdown edit box -->

							</div>
							<!-- end widget edit box -->

							<!-- widget content -->
							<div class="widget-body">

								<p>
									Group a series of buttons together on a single line with the button group. Wrap a series of buttons with
									<code>
										.btn
									</code>
									in
									<code>
										.btn-group
									</code>
									.
								</p>

								<div class="row">
									<div class="col-md-12">
										<table class="table table-bordered">
											<thead>
												<tr>
													<th style="width:25%">Horizontal Group</th>
													<th style="width:25%">With Icons</th>
													<th style="width:50%">Multiple Button Groups</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>
													<div class="btn-group">
														<button type="button" class="btn btn-default">
															Left
														</button>
														<button type="button" class="btn btn-default">
															Middle
														</button>
														<button type="button" class="btn btn-default">
															Right
														</button>
													</div></td>
													<td>
													<div class="btn-group">
														<button type="button" class="btn btn-default">
															<i class="fa fa-align-left"></i>
														</button>
														<button type="button" class="btn btn-default">
															<i class="fa fa-align-center"></i>
														</button>
														<button type="button" class="btn btn-default">
															<i class="fa fa-align-right"></i>
														</button>
														<button type="button" class="btn btn-default">
															<i class="fa fa-align-justify"></i>
														</button>
													</div></td>
													<td>
													<div class="btn-toolbar">
														<div class="btn-group">
															<button type="button" class="btn btn-default">
																1
															</button>
															<button type="button" class="btn btn-default">
																2
															</button>
															<button type="button" class="btn btn-default">
																3
															</button>
															<button type="button" class="btn btn-default">
																4
															</button>
														</div>
														<div class="btn-group">
															<button type="button" class="btn btn-default">
																5
															</button>
															<button type="button" class="btn btn-default">
																6
															</button>
															<button type="button" class="btn btn-default">
																7
															</button>
														</div>
														<div class="btn-group">
															<button type="button" class="btn btn-default">
																8
															</button>
														</div>
													</div></td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>

								<hr class="simple">
								<p>
									Make a set of buttons appear vertically stacked rather than horizontally by putting it in
									<code>
										.btn-group-vertical
									</code>
									.
								</p>

								<div class="row">
									<div class="col-md-12">
										<table class="table table-bordered">
											<thead>
												<tr>
													<th style="width:25%">Vertical Group</th>
													<th style="width:25%">With Dropdown</th>
													<th style="width:25%">With Icons</th>
													<th style="width:25%">Multiple Button Groups</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>
													<div class="btn-group-vertical">
														<button type="button" class="btn btn-default">
															Top
														</button>
														<button type="button" class="btn btn-default">
															Middle
														</button>
														<button type="button" class="btn btn-default">
															Bottom
														</button>
													</div></td>
													<td>
													<div class="btn-group-vertical">
														<button type="button" class="btn btn-primary">
															Button 1
														</button>
														<button type="button" class="btn btn-primary">
															Button 2
														</button>
														<button type="button" class="btn btn-primary">
															Button 3
														</button>
														<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
															Dropdown
															<i class="fa fa-caret-down"></i>
														</button>
														<ul class="dropdown-menu">
															<li>
																<a href="javascript:void(0);">Dropdown link</a>
															</li>
															<li>
																<a href="javascript:void(0);">Dropdown link</a>
															</li>
														</ul>
													</div></td>
													<td>
													<div class="btn btn-group-vertical">
														<a class="btn btn-default" href="javascript:void(0);"><i class="fa fa-align-left"></i></a>
														<a class="btn btn-default" href="javascript:void(0);"><i class="fa fa-align-center"></i></a>
														<a class="btn btn-default" href="javascript:void(0);"><i class="fa fa-align-right"></i></a>
														<a class="btn btn-default" href="javascript:void(0);"><i class="fa fa-align-justify"></i></a>
													</div></td>
													<td>
													<div class="btn-toolbar">
														<div class="btn-group-vertical">
															<button type="button" class="btn btn-primary">
																Page 1
															</button>
															<button type="button" class="btn btn-primary">
																Page 2
															</button>
															<button type="button" class="btn btn-primary">
																Page 3
															</button>
															<button type="button" class="btn btn-primary">
																Page 4
															</button>
														</div>

													</div></td>
												</tr>
											</tbody>
										</table>
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

				<!-- NEW WIDGET START -->
				<article class="col-sm-12 col-md-12 col-lg-6">

					<!-- Widget ID (each widget will need unique ID)-->
					<div class="jarviswidget" id="wid-id-1" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-custombutton="false" data-widget-sortable="false">
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
							<span class="widget-icon"> <i class="fa fa-hand-o-up"></i> </span>
							<h2> Mix and match colors </h2>

						</header>

						<!-- widget div-->
						<div>

							<!-- widget edit box -->
							<div class="jarviswidget-editbox">
								<!-- This area used as dropdown edit box -->

							</div>
							<!-- end widget edit box -->

							<!-- widget content -->
							<div class="widget-body">

								<p class="alert alert-info">
									Custom buttons with core CSS elements. Mix and match existing classes to come up with unique style buttons.
									<strong>For example:</strong>
									<code>
										.btn .bg-color-blueLight .txt-color-white
									</code>

								</p>

								<ul class="demo-btns">
									<li>
										<a href="javascript:void(0);" class="btn bg-color-blueLight txt-color-white">.bg-color-blueLight</a>
									</li>
									<li>
										<a href="javascript:void(0);" class="btn bg-color-blue txt-color-white">.bg-color-blue</a>
									</li>
									<li>
										<a href="javascript:void(0);" class="btn bg-color-teal txt-color-white">.bg-color-teal</a>
									</li>
									<li>
										<a href="javascript:void(0);" class="btn bg-color-blueDark txt-color-white">.bg-color-blueDark</a>
									</li>
									<li>
										<a href="javascript:void(0);" class="btn bg-color-green txt-color-white">.bg-color-green</a>
									</li>
									<li>
										<a href="javascript:void(0);" class="btn bg-color-greenDark txt-color-white">.bg-color-greenDark</a>
									</li>
									<li>
										<a href="javascript:void(0);" class="btn bg-color-greenLight txt-color-white">.bg-color-greenLight</a>
									</li>
									<li>
										<a href="javascript:void(0);" class="btn bg-color-purple txt-color-white">.bg-color-purple</a>
									</li>
									<li>
										<a href="javascript:void(0);" class="btn bg-color-magenta txt-color-white">.bg-color-magenta</a>
									</li>
									<li>
										<a href="javascript:void(0);" class="btn bg-color-pink txt-color-white">.bg-color-pink</a>
									</li>
									<li>
										<a href="javascript:void(0);" class="btn bg-color-pinkDark txt-color-white">.bg-color-pinkDark</a>
									</li>
									<li>
										<a href="javascript:void(0);" class="btn bg-color-yellow txt-color-white">.bg-color-yellow</a>
									</li>
									<li>
										<a href="javascript:void(0);" class="btn bg-color-orange txt-color-white">.bg-color-orange</a>
									</li>
									<li>
										<a href="javascript:void(0);" class="btn bg-color-red txt-color-white">.bg-color-red</a>
									</li>
									<li>
										<a href="javascript:void(0);" class="btn bg-color-redLight txt-color-white">.bg-color-redLight</a>
									</li>
									<li>
										<a href="javascript:void(0);" class="btn btn-default txt-color-dark">.btn-default</a>
									</li>
								</ul>

							</div>
							<!-- end widget content -->

						</div>
						<!-- end widget div -->

					</div>
					<!-- end widget -->

					<!-- Widget ID (each widget will need unique ID)-->
					<div class="jarviswidget" id="wid-id-3" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-custombutton="false" data-widget-sortable="false">
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
							<span class="widget-icon"> <i class="fa fa-hand-o-up"></i> </span>
							<h2> Mix and match colors </h2>

						</header>

						<!-- widget div-->
						<div>

							<!-- widget edit box -->
							<div class="jarviswidget-editbox">
								<!-- This area used as dropdown edit box -->

							</div>
							<!-- end widget edit box -->

							<!-- widget content -->
							<div class="widget-body">

								<p class="alert alert-info">
									Custom text colors can also be applied
									<strong>For example:</strong>
									<code>
										.txt-color-red
									</code>

								</p>

								<ul class="demo-btns">
									<li>
										<a href="javascript:void(0);" class="btn btn-default txt-color-blueLight"><i class="fa fa-gear fa-lg"></i></a>
									</li>
									<li>
										<a href="javascript:void(0);" class="btn btn-default txt-color-blue"><i class="fa fa-gear fa-lg"></i></a>
									</li>
									<li>
										<a href="javascript:void(0);" class="btn btn-default txt-color-teal"><i class="fa fa-gear fa-lg"></i></a>
									</li>
									<li>
										<a href="javascript:void(0);" class="btn btn-default txt-color-blueDark"><i class="fa fa-gear fa-lg"></i></a>
									</li>
									<li>
										<a href="javascript:void(0);" class="btn btn-default txt-color-green"><i class="fa fa-gear fa-lg"></i></a>
									</li>
									<li>
										<a href="javascript:void(0);" class="btn btn-default txt-color-greenDark"><i class="fa fa-gear fa-lg"></i></a>
									</li>
									<li>
										<a href="javascript:void(0);" class="btn btn-default txt-color-greenLight"><i class="fa fa-gear fa-lg"></i></a>
									</li>
									<li>
										<a href="javascript:void(0);" class="btn btn-default txt-color-purple"><i class="fa fa-gear fa-lg"></i></a>
									</li>
									<li>
										<a href="javascript:void(0);" class="btn btn-default txt-color-magenta"><i class="fa fa-gear fa-lg"></i></a>
									</li>
									<li>
										<a href="javascript:void(0);" class="btn btn-default txt-color-pink"><i class="fa fa-gear fa-lg"></i></a>
									</li>
									<li>
										<a href="javascript:void(0);" class="btn btn-default txt-color-pinkDark"><i class="fa fa-gear fa-lg"></i></a>
									</li>
									<li>
										<a href="javascript:void(0);" class="btn btn-default txt-color-yellow"><i class="fa fa-gear fa-lg"></i></a>
									</li>
									<li>
										<a href="javascript:void(0);" class="btn btn-default txt-color-orange"><i class="fa fa-gear fa-lg"></i></a>
									</li>
									<li>
										<a href="javascript:void(0);" class="btn btn-default txt-color-red"><i class="fa fa-gear fa-lg"></i></a>
									</li>

								</ul>

								<hr class="simple">
								<p>
									Mix and match color with backgrounds
									<code>
										.btn .bg-color-blueLight .txt-color-magenta
									</code>
								</p>
								<ul class="demo-btns">
									<li>
										<a href="javascript:void(0);" class="btn bg-color-blueLight txt-color-magenta"><i class="fa fa-gear fa-lg"></i></a>
									</li>
									<li>
										<a href="javascript:void(0);" class="btn bg-color-blueDark txt-color-teal"><i class="fa fa-gear fa-3x"></i></a>
									</li>
									<li>
										<a href="javascript:void(0);" class="btn bg-color-red txt-color-white"><i class="fa fa-gear fa-4x fa-spin"></i></a>
									</li>
								</ul>

							</div>
							<!-- end widget content -->

						</div>
						<!-- end widget div -->

					</div>
					<!-- end widget -->

					<!-- Widget ID (each widget will need unique ID)-->
					<div class="jarviswidget" id="wid-id-5" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-custombutton="false" data-widget-sortable="false">
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
							<span class="widget-icon"> <i class="fa fa-hand-o-up"></i> </span>
							<h2>Button with icons </h2>

						</header>

						<!-- widget div-->
						<div>

							<!-- widget edit box -->
							<div class="jarviswidget-editbox">
								<!-- This area used as dropdown edit box -->

							</div>
							<!-- end widget edit box -->

							<!-- widget content -->
							<div class="widget-body">

								<p>
									Default buttons have a single line of text with or without one or two icons aligned left or right.
								</p>
								<ul class="demo-btns">
									<li>
										<a href="javascript:void(0);" class="btn btn-primary"><i class="fa fa-gear"></i> Icon Left</a>
									</li>
									<li>
										<a href="javascript:void(0);" class="btn btn-success"><i class="fa fa-gear"></i> Both Sides <i class="fa fa-gear"></i></a>
									</li>
									<li>
										<a href="javascript:void(0);" class="btn btn-danger">Icon Right <i class="fa fa-gear"></i></a>
									</li>
								</ul>
								<ul class="demo-btns">
									<li>
										<a href="javascript:void(0);" class="btn btn-default"><i class="fa fa-gear"></i> Icon Left</a>
									</li>
									<li>
										<a href="javascript:void(0);" class="btn btn-default"><i class="fa fa-gear"></i> Both Sides <i class="fa fa-gear"></i></a>
									</li>
									<li>
										<a href="javascript:void(0);" class="btn btn-default">Icon Right <i class="fa fa-gear"></i></a>
									</li>
								</ul>

								<hr class="simple">

								<ul class="demo-btns">
									<li>

										<div class="btn-group">
											<button class="btn bg-color-blueDark txt-color-white">
												<i class="fa fa-gear"></i> Drop Down
											</button>
											<button class="btn btn-primary dropdown-toggle">
												<span class="caret"></span>
											</button>
										</div>

									</li>
									<li>

										<div class="btn-group">
											<button class="btn bg-color-blueDark txt-color-white">
												<i class="fa fa-gear"></i> Drop Down <i class="fa fa-gear"></i>
											</button>
											<button class="btn btn-success dropdown-toggle">
												<span class="caret"></span>
											</button>
										</div>

									</li>
									<li>

										<div class="btn-group">
											<button class="btn bg-color-blueDark txt-color-white">
												Drop Down <i class="fa fa-gear"></i>
											</button>
											<button class="btn btn-danger dropdown-toggle">
												<span class="caret"></span>
											</button>
										</div>

									</li>
								</ul>

								<ul class="demo-btns">
									<li>

										<div class="btn-group">
											<button class="btn btn-default">
												<i class="fa fa-gear"></i> Drop Down
											</button>
											<button class="btn btn-default dropdown-toggle">
												<span class="caret"></span>
											</button>
										</div>

									</li>
									<li>

										<div class="btn-group">
											<button class="btn btn-default">
												<i class="fa fa-gear"></i> Drop Down <i class="fa fa-gear"></i>
											</button>
											<button class="btn btn-default dropdown-toggle">
												<span class="caret"></span>
											</button>
										</div>

									</li>
									<li>

										<div class="btn-group">
											<button class="btn btn-default">
												Drop Down <i class="fa fa-gear"></i>
											</button>
											<button class="btn btn-default dropdown-toggle">
												<span class="caret"></span>
											</button>
										</div>

									</li>
								</ul>

								<hr class="simple">

								<ul class="demo-btns">

									<li>
										<a href="javascript:void(0);" class="btn btn-primary btn-xs"><i class="fa fa-gear"></i></a>
									</li>
									<li>
										<a href="javascript:void(0);" class="btn btn-default btn-sm"><i class="fa fa-gear fa-lg"></i></a>
									</li>
									<li>
										<a href="javascript:void(0);" class="btn btn-primary"><i class="fa fa-gear fa-lg"></i></a>
									</li>
									<li>
										<a href="javascript:void(0);" class="btn btn-primary btn-lg"><i class="fa fa-gear fa-lg"></i></a>
									</li>

								</ul>

								<ul class="demo-btns">

									<li>
										<a href="javascript:void(0);" class="btn btn-primary btn-xs"><i class="fa fa-gear"></i> <i class="fa fa-caret-down"></i></a>
									</li>
									<li>
										<a href="javascript:void(0);" class="btn btn-default btn-sm"><i class="fa fa-gear fa-lg"></i> <i class="fa fa-caret-down"></i></a>
									</li>
									<li>
										<a href="javascript:void(0);" class="btn btn-primary"><i class="fa fa-gear fa-lg"></i> <i class="fa fa-caret-down"></i></a>
									</li>
									<li>
										<a href="javascript:void(0);" class="btn btn-primary btn-lg"><i class="fa fa-gear fa-lg"></i> <i class="fa fa-caret-down"></i></a>
									</li>

								</ul>

							</div>
							<!-- end widget content -->

						</div>
						<!-- end widget div -->

					</div>
					<!-- end widget -->

					<!-- Widget ID (each widget will need unique ID)-->
					<div class="jarviswidget" id="wid-id-7" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-custombutton="false" data-widget-sortable="false">
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
							<span class="widget-icon"> <i class="fa fa-hand-o-up"></i> </span>
							<h2>Label Buttons </h2>

						</header>

						<!-- widget div-->
						<div>

							<!-- widget edit box -->
							<div class="jarviswidget-editbox">
								<!-- This area used as dropdown edit box -->

							</div>
							<!-- end widget edit box -->

							<!-- widget content -->
							<div class="widget-body">

								<ul class="demo-btns">
									<li>
										<a href="javascript:void(0);" class="btn btn-labeled btn-success"> <span class="btn-label"><i class="glyphicon glyphicon-ok"></i></span>Success </a>
									</li>
									<li>
										<a href="javascript:void(0);" class="btn btn-labeled btn-danger"> <span class="btn-label"><i class="glyphicon glyphicon-remove"></i></span>Cancel </a>
									</li>
									<li>
										<a href="javascript:void(0);" class="btn btn-labeled btn-warning"> <span class="btn-label"><i class="glyphicon glyphicon-bookmark"></i></span>Bookmark </a>
									</li>
									<li>
										<a href="javascript:void(0);" class="btn btn-labeled btn-primary"> <span class="btn-label"><i class="glyphicon glyphicon-camera"></i></span>Camera </a>
									</li>
									<li>
										<a href="javascript:void(0);" class="btn btn-labeled btn-default"> <span class="btn-label"><i class="glyphicon glyphicon-chevron-left"></i></span>Left </a>
									</li>
									<li>
										<a href="javascript:void(0);" class="btn btn-labeled btn-default"> <span class="btn-label"><i class="glyphicon glyphicon-chevron-right"></i></span> Right </a>
									</li>
									<li>
										<a href="javascript:void(0);" class="btn btn-labeled btn-success"> <span class="btn-label"><i class="glyphicon glyphicon-thumbs-up"></i></span>Thumbs
										Up </a>
									</li>
									<li>
										<a href="javascript:void(0);" class="btn btn-labeled btn-danger"> <span class="btn-label"><i class="glyphicon glyphicon-thumbs-down"></i></span>Thumbs
										Down </a>
									</li>
									<li>
										<a href="javascript:void(0);" class="btn btn-labeled btn-info"> <span class="btn-label"><i class="glyphicon glyphicon-refresh"></i></span>Refresh </a>
									</li>
									<li>
										<a href="javascript:void(0);" class="btn btn-labeled btn-danger"> <span class="btn-label"><i class="glyphicon glyphicon-trash"></i></span>Trash </a>
									</li>
									<li>
										<a class="btn btn-success btn-labeled" href="javascript:void(0);"> <span class="btn-label"><i class="glyphicon glyphicon-info-sign"></i></span>Info Web </a>
									</li>

								</ul>
								<pre>
&lt;button type="button" class="btn btn-labeled btn-success">
&lt;span class="btn-label">
&lt;i class="glyphicon glyphicon-ok">&lt;/i>
&lt;/>Success
&lt;/button>
</pre>
								


							</div>
							<!-- end widget content -->

						</div>
						<!-- end widget div -->

					</div>
					<!-- end widget -->

					<!-- Widget ID (each widget will need unique ID)-->
					<div class="jarviswidget" id="wid-id-9" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-custombutton="false" data-widget-sortable="false">
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
							<span class="widget-icon"> <i class="fa fa-hand-o-up"></i> </span>
							<h2>Block Buttons </h2>

						</header>

						<!-- widget div-->
						<div>

							<!-- widget edit box -->
							<div class="jarviswidget-editbox">
								<!-- This area used as dropdown edit box -->

							</div>
							<!-- end widget edit box -->

							<!-- widget content -->
							<div class="widget-body">
								<p>
									Block buttons
									<code>
										.btn .btn-block
									</code>
								</p>

								<div class="well">
									<button type="button" class="btn btn-primary btn-lg btn-block">
										Block level button
									</button>
									<button type="button" class="btn btn-default btn-sm btn-block">
										Block level small button
									</button>
									<button type="button" class="btn btn-default btn-xs btn-block">
										Block level extra small button
									</button>
								</div>

								<hr class="simple">

								<p>
									Block group buttons
									<code>
										.btn-group .btn-group-justified
									</code>
								</p>

								<div class="well">

									<div class="btn-group btn-group-justified">
										<a href="javascript:void(0);" class="btn btn-default">Left</a>
										<a href="javascript:void(0);" class="btn btn-default">Middle</a>
										<a href="javascript:void(0);" class="btn btn-default">Right</a>
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

			<!-- row -->
			<div class="row">

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

	$(document).ready(function() {
		// PAGE RELATED SCRIPTS
	})

</script>

<?php 
	//include footer
	include("inc/google-analytics.php"); 
?>