<?php

//initilize the page
require_once("inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

/*---------------- PHP Custom Scripts ---------

YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
E.G. $page_title = "Custom Title" */

$page_title = "Blank Page";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav["template"]["sub"]["graphs"]["sub"]["sparklines"]["active"] = true;
include("inc/nav.php");

?>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main">
	<?php
		//configure ribbon (breadcrumbs) array("name"=>"url"), leave url empty if no url
		//$breadcrumbs["New Crumb"] => "http://url.com"
		$breadcrumbs["Misc"] = "";
		include("inc/ribbon.php");
	?>

	<!-- MAIN CONTENT -->
	<div id="content">


		<div class="row">
			<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
				<h1 class="page-title txt-color-blueDark">
					<i class="fa fa-bar-chart-o fa-fw "></i> 
						Graph 
					<span>> 
						Inline Charts
					</span>
				</h1>
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
		
		<!-- row -->
		<div class="row">
			
			<div class="col-sm-12">
				
				<div class="well">
					
					<h1>JQuery <span class="semi-bold">Sparklines</span> <small>Modified for easier usage</small></h1>
					<p>Sparklines are light weight, easy to use, inline charts. We have modified sparklines so you can use it with just <code>data-*</code> values, without the use of javascript</p>
					<br>
					<div class="row">
						<div class="col-sm-6">
							<ul>
								<li>
									Inline Graphs &nbsp;
									<span class="sparkline" data-sparkline-type="line" data-sparkline-width="50px" data-sparkline-height="18px">90,30,60,40,60,70,50,40,70,60,90,50</span>&nbsp;
									also change width, height, and color &nbsp;
									<span class="sparkline txt-color-green" data-sparkline-type="line" data-sparkline-width="80px" data-fill-color="transparent" data-sparkline-spotradius="3" data-sparkline-height="15px">4,1,5,7,9,9,8,7,6,6,4,7,8,4,3,2,2,5,6,7</span>
									<p class="note">
										&lt;span data-sparkline-type="line" data-sparkline-width="50px" data-sparkline-height="18px"&gt;90,30,60,...&lt;/span&gt;
									</p>
								</li>
								<li>
									Compose inline charts
									<span class="sparkline display-inline" data-sparkline-type="compositeline" data-sparkline-barcolor="#aafaaf" data-sparkline-linecolor="#ed1c24" data-sparkline-height="15px" data-sparkline-line-val="[6,4,7,8,4,3,2,2,5,6,7,4,1,5,7,9,9,8,7,6]" data-sparkline-bar-val="[4,1,5,7,9,9,8,7,6,6,4,7,8,4,3,2,2,5,6,7]"></span> 
									and Composite Bar charts&nbsp;
									<span class="sparkline display-inline" data-sparkline-type="compositebar" data-sparkline-height="15px" data-sparkline-color-bottom="#57889C" data-sparkline-barcolor="#aafaaf" data-sparkline-line-width="1.5" data-sparkline-linecolor="#ed1c24" data-sparkline-line-val="[6,4,7,8,4,3,2,2,5,6,7,4,1,5,7,9,9,8,7,6]" data-sparkline-bar-val="[4,1,5,7,9,9,8,7,6,6,4,7,8,4]"></span> 
									<p class="note">
										&lt;span data-sparkline-type="compositeline" data-sparkline-height="15px" data-sparkline-line-val="[9,8,7...]" data-sparkline-bar-val="[4,1,5...]"&gt;&lt;/span&gt;
									</p>
		
								</li>
								<li>
									Discrete bars &nbsp;&nbsp; <span class="sparkline txt-color-blue" data-sparkline-type="discrete" data-sparkline-height="18px" data-sparkline-width="30">4,6,7,7,4,3,2,1,4,4</span> &nbsp; 
									and with threshhold  &nbsp; 
									<span class="sparkline txt-color-blue" data-sparkline-type="discrete" data-sparkline-height="18px" data-sparkline-width="30" data-sparkline-threshold="4">4,6,7,7,4,3,2,1,4,4</span> 
									<p class="note">
										&lt;span data-sparkline-type="discrete" data-sparkline-height="18px" data-sparkline-width="30" data-sparkline-threshold="4"&gt;4,6,7,...&lt;/span&gt;
									</p> 
								</li>
							</ul>
							
							
						</div>
						<div class="col-sm-6">
							<ul>
								<li>
									Nifty Bar Charts &nbsp;&nbsp; 
									<span class="sparkline txt-color-blue" data-sparkline-type="bar" data-sparkline-width="50px" data-sparkline-barwidth="3" data-sparkline-height="15px">50,40,70,60,90,50</span> &nbsp; 
									with negatives and thicker bars &nbsp; 
									<span class="sparkline txt-color-blue" data-sparkline-type="bar" data-sparkline-width="50px" data-sparkline-barwidth="5" data-sparkline-height="18px">5,6,7,2,0,-4,-2,4</span> and stacked bars &nbsp; 
									<span class="sparkline txt-color-blue" data-sparkline-type="bar" data-sparkline-width="50px" data-sparkline-barwidth="5" data-sparkline-height="15px">1:3, 5:3, 2:7,9:1,5:6</span>
									<p class="note">
										&lt;span data-sparkline-type="bar" data-sparkline-width="50px" data-sparkline-bar data-sparkline-height="15px"&gt;50,40,70,...&lt;/span&gt;
									</p>
								</li>
								<li>
									Box plots&nbsp; 
									<span class="sparkline display-inline" data-sparkline-type="bullet" data-sparkline-height="14px" data-sparkline-bulletrange-color='["#CCD7DB", "#92A2A8", "#57889C"]' data-sparkline-performance-color="#A4CBDB" data-sparkline-bullet-color="#143644">10,12,12,9,7</span> 
									&nbsp; and bullet plots &nbsp; 
									<span class="sparkline display-inline" data-sparkline-type="box" data-sparkline-height="14px">4,27,34,52,54,59,61,68,78,82,85,87,91,93,100</span> 
									
									
									 
									<p class="note">
										&lt;span data-sparkline-type="compositebar" data-sparkline-line-width="1.5" data-sparkline-line-val="[6,4,7...]" data-sparkline-bar-val="[4,1,5...]"&gt;&lt;/span&gt;
									</p>
								</li>
								<li>
									Pie Charts &nbsp; <span class="sparkline display-inline" data-sparkline-type="pie" data-sparkline-offset="90" data-sparkline-piesize="18px">3,5,2</span> 
									<p class="note">
										&lt;span data-sparkline-type="pie" data-sparkline-offset="90" data-sparkline-piesize="18px"&gt;3,5,2&lt;/span&gt;
									</p>
								</li>
							</ul>
						</div>
					</div>
					
					<div class="row">
						<h2 class="row-seperator-header"><small>Examples below are done <strong>without</strong> any javascript!</small></h2>
						<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
							<div class="well well-sm well-light">
								<h4 class="txt-color-blue">Pie <span class="semi-bold">Chart</span> <a href="javascript:void(0);" class="pull-right"><i class="fa fa-refresh"></i></a></h4>
								<br>
								<div class="text-center">
									<div class="sparkline txt-color-blue display-inline" 
									data-sparkline-type="pie" 
									data-sparkline-offset="90" 
									data-sparkline-piesize="75px">3,5,2</div>
									<div class="sparkline txt-color-blue display-inline" 
									data-sparkline-type="pie" 
									data-sparkline-offset="90" 
									data-sparkline-piesize="75px">30,20,15,35</div>
								</div>
		
							</div>
						</div>
						<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
							<div class="well well-sm well-light padding-10">
								<h4 class="txt-color-green">Composite <span class="semi-bold">Chart</span> <a href="javascript:void(0);" class="pull-right txt-color-green"><i class="fa fa-refresh"></i></a></h4>
								<br>
								<div class="sparkline" 
								data-sparkline-type="compositeline" 
								data-sparkline-spotradius-top="5" 
								data-sparkline-color-top="#3a6965" 
								data-sparkline-line-width-top="3" 
								data-sparkline-color-bottom="#2b5c59" 
								data-sparkline-spot-color="#2b5c59" 
								data-sparkline-minspot-color-top="#97bfbf" 
								data-sparkline-maxspot-color-top="#c2cccc" 
								data-sparkline-highlightline-color-top="#cce8e4" 
								data-sparkline-highlightspot-color-top="#9dbdb9" 
								data-sparkline-width="96%" 
								data-sparkline-height="78px" 
								data-sparkline-line-val="[6,4,7,8,4,3,2,2,5,6,7,4,1,5,7,9,9,8,7,6]" 
								data-sparkline-bar-val="[4,1,5,7,9,9,8,7,6,6,4,7,8,4,3,2,2,5,6,7]">
								</div> 	
							</div>
						</div>
						<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
							<div class="well well-sm well-light">
								<h4 class="txt-color-blueLight">Bar <span class="semi-bold">Chart</span> <a href="javascript:void(0);" class="pull-right txt-color-blueLight"><i class="fa fa-refresh"></i></a></h4>
								<br>
								<div class="sparkline txt-color-blueLight text-center" 
								data-sparkline-type="bar" 
								data-sparkline-width="96%" 
								data-sparkline-barwidth="11" 
								data-sparkline-barspacing = "5" 
								data-sparkline-height="80px">
									4,3,5,7,9,9,8,7,6,6,4,7,8,4
								</div>
							</div>
						</div>
						<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
							<div class="well well-sm well-light">
								<h4 class="txt-color-blueLight">Bar <span class="semi-bold">Stacked Chart</span> <a href="javascript:void(0);" class="pull-right txt-color-blueLight"><i class="fa fa-refresh"></i></a></h4>
								<br>
								<div class="sparkline txt-color-blue text-center" 
								data-sparkline-type="bar" 
								data-sparkline-width="96%" 
								data-sparkline-barwidth="11" 
								data-sparkline-barspacing = "5" 
								data-sparkline-barstacked-color='["#92A2A8", "#4493B1"]' 
								data-sparkline-height="80px">4:5,3:4,5:7,6:3,4:6,6:5,8:2,4:3,6:4,6:2,4:4,7:2,8:5,4:2</div>
							</div>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
							<div class="well padding-10">
								<h4 class="txt-color-blue">Composite Line with fills <a href="javascript:void(0);" class="pull-right txt-color-white"><i class="fa fa-refresh"></i></a></h4>
								<br>
								<div class="sparkline txt-color-darken" 
								data-sparkline-line-val="[3,2,3,4,3,2,4,2,3]" 
								data-sparkline-bar-val="[5,3,3,1,5,3,2,2,3]" 
								data-sparkline-type="compositeline" 
								data-sparkline-line-width="1" 
								data-sparkline-width="100%" 
								data-sparkline-height="180px" 
								data-sparkline-fillcolor-top="rgba(87, 136, 156, 0.30)" 
								data-sparkline-fillcolor-bottom="rgba(0, 141, 214, 0.10)" 
								data-sparkline-color-top="#fff" 
								data-sparkline-color-bottom="#fff" 
								data-sparkline-spotradius-top="4" 
								data-data-sparkline-bar-val-spots-top="[5,3,3,1,4,3,2,2,3]" 
								data-sparkline-bar-val-spots-bottom="[3,2,3,4,3,2,4,1,3]" 
								data-sparkline-minspot-color-top="#d1dade" 
								data-sparkline-minspot-color-bottom="#167db2"
								data-sparkline-maxspot-color-top="#d1dade" 
								data-sparkline-maxspot-color-bottom="#167db2" 
								data-sparkline-highlightspot-color-top="#d1dade" 
								data-sparkline-highlightspot-color-bottom="#8fcded" 
								data-sparkline-highlightline-color-top="#bec6ca" 
								data-sparkline-highlightline-color-bottom="#bec6ca"
								>
									4,3,3,1,4,3,2,2,3
								</div>
							</div>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
							<div class="well padding-10">
								<h4 class="txt-color-teal">Line chart variation <a href="javascript:void(0);" class="pull-right txt-color-white"><i class="fa fa-refresh"></i></a></h4>
								<br>	
								<div class="sparkline" 
								data-sparkline-type="line" 
								data-fill-color="#e6f6f5" 
								data-sparkline-line-color="#0aa699" 
								data-sparkline-spotradius="5" 
								data-sparkline-width="100%" 
								data-sparkline-height="180px">6,4,3,5,2,4,6,4,3,3,4,5,4,3,2,4,5,</div> 
								<h4 class="air air-top-right padding-10 font-xl txt-color-teal">+ 39.<small class="ultra-light txt-color-teal">57 <i class="fa fa-caret-up fa-lg"></i></small></h4>
								<h5 class="air air-bottom-left padding-10 font-md text-danger">-12.<small class="ultra-light text-danger">45 <i class="fa fa-caret-down fa-lg"></i></small></h5>
							</div>
							
						</div>
					</div>
					
				</div>
		
			</div>

		</div>
		
		<!-- end row -->
		
		<!-- row -->
		
		<div class="row">
		
		
		</div>
		
		<!-- end row -->



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
<script src="<?php echo ASSETS_URL; ?>/js/plugin/YOURJS.js"></script>-->

<script>

	$(document).ready(function() {
		/* DO NOT REMOVE : GLOBAL FUNCTIONS!
		 *
		 * pageSetUp(); WILL CALL THE FOLLOWING FUNCTIONS
		 *
		 * // activate tooltips
		 * $("[rel=tooltip]").tooltip();
		 *
		 * // activate popovers
		 * $("[rel=popover]").popover();
		 *
		 * // activate popovers with hover states
		 * $("[rel=popover-hover]").popover({ trigger: "hover" });
		 *
		 * // activate inline charts
		 * runAllCharts();
		 *
		 * // setup widgets
		 * setup_widgets_desktop();
		 *
		 * // run form elements
		 * runAllForms();
		 *
		 ********************************
		 *
		 * pageSetUp() is needed whenever you load a page.
		 * It initializes and checks for all basic elements of the page
		 * and makes rendering easier.
		 *
		 */
		
		 pageSetUp();
		 
		/*
		 * ALL PAGE RELATED SCRIPTS CAN GO BELOW HERE
		 * eg alert("my home function");
		 * 
		 * var pagefunction = function() {
		 *   ...
		 * }
		 * loadScript("js/plugin/_PLUGIN_NAME_.js", pagefunction);
		 * 
		 * TO LOAD A SCRIPT:
		 * var pagefunction = function (){ 
		 *  loadScript(".../plugin.js", run_after_loaded);	
		 * }
		 * 
		 * OR
		 * 
		 * loadScript(".../plugin.js", run_after_loaded);
		 */
	})

</script>

<?php 
	//include footer
	include("inc/google-analytics.php"); 
?>