<?php

//initilize the page
require_once("inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

/*---------------- PHP Custom Scripts ---------

YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
E.G. $page_title = "Custom Title" */

$page_title = "jQuery UI";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav["template"]["sub"]["ui_elements"]["sub"]["jquery_ui"]["active"] = true;
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
		<h1 class="page-title txt-color-blueDark"><i class="fa fa-desktop fa-fw "></i> 
			UI Elements 
			<span>>
			JQuery UI
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

	<div class="col-sm-6 col-md-6 col-lg-6">

		<div class="well well-sm well-light">
			<h3>Dialogue</h3>
			<a href="#" id="dialog_link" class="btn btn-info"> Open Dialog </a>
			&nbsp;
			<a href="#" id="modal_link" class="btn bg-color-purple txt-color-white"> Open Modal Dialog </a>
		</div>

		<div class="well well-sm well-light">
			<h3>Jquery Tabs
			<br>
			<small>Simple Tabs</small></h3>

			<div id="tabs">
				<ul>
					<li>
						<a href="#tabs-a">First</a>
					</li>
					<li>
						<a href="#tabs-b">Second</a>
					</li>
					<li>
						<a href="#tabs-c">Third</a>
					</li>
				</ul>
				<div id="tabs-a">
					<p>
						Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
					</p>
				</div>
				<div id="tabs-b">
					<p>
						Phasellus mattis tincidunt nibh. Cras orci urna, blandit id, pretium vel, aliquet ornare, felis. Maecenas scelerisque sem non nisl. Fusce sed lorem in enim dictum bibendum.
					</p>
				</div>
				<div id="tabs-c">
					<p>
						Nam dui erat, auctor a, dignissim quis, sollicitudin eu, felis. Pellentesque nisi urna, interdum eget, sagittis et, consequat vestibulum, lacus. Mauris porttitor ullamcorper augue.
					</p>
				</div>
			</div>

			<hr class="simple">
			<h3>Dynamic Tabs
			<br>
			<small>Click button to add another tab</small></h3>

			<p>
				<button id="add_tab" class="btn btn-primary">
					Add Tab
				</button>
			</p>

			<div id="tabs2">
				<ul>
					<li>
						<a href="#tabs-1">Nunc tincidunt</a>
					</li>
				</ul>
				<div id="tabs-1">
					<p>
						Proin elit arcu, rutrum commodo, vehicula tempus, commodo a, risus. Curabitur nec arcu. Donec sollicitudin mi sit amet mauris. Nam elementum quam ullamcorper ante. Etiam aliquet massa et lorem. Mauris dapibus lacus auctor risus. Aenean tempor ullamcorper leo. Vivamus sed magna quis ligula eleifend adipiscing. Duis orci. Aliquam sodales tortor vitae ipsum. Aliquam nulla. Duis aliquam molestie erat. Ut et mauris vel pede varius sollicitudin. Sed ut dolor nec orci tincidunt interdum. Phasellus ipsum. Nunc tristique tempus lectus.
					</p>
				</div>
			</div>

			<!-- Demo -->
			<div id="addtab" title="<div class='widget-header'><h4><i class='fa fa-plus'></i> Add another tab</h4></div>">

				<form>

					<fieldset>
						<input name="authenticity_token" type="hidden">
						<div class="form-group">
							<label>Tab Title</label>
							<input class="form-control" id="tab_title" value="" placeholder="Text field" type="text">
						</div>

						<div class="form-group">
							<label>Content</label>
							<textarea class="form-control" name="tab_content" id="tab_content" placeholder="Tab Content" rows="3"></textarea>
						</div>

					</fieldset>

				</form>

			</div>

		</div>

		<div class="well well-sm well-light">
			<h3>Slider
			<br>
			<small>Horizontal Slider with tooltip</small></h3>


			<input type="text" class="slider slider-primary" id="g1" value="" 
					data-slider-max="500" 
					data-slider-value="185" 
					data-slider-selection = "before" 
					data-slider-handle="round">

			<input type="text" class="slider slider-success" id="g2" value="" 
					data-slider-max="1000" 
					data-slider-step="1" 
					data-slider-value="[150,760]" 
					data-slider-handle="squar">

			
					<h3>Usage <small>Its so simple...</small> </h3>
				<pre>
<code><strong>&lt;input class="slider slider-primary" data-slider-min="10" ..  /></strong></code>

data-slider-min="10"       <span class="text-muted"> // slider min value</span>
data-slider-max="500"      <span class="text-muted"> // slider max value</span>
data-slider-value="315"    <span class="text-muted"> // handler position on slider</span>
data-slider-handle="round" <span class="text-muted"> // round or square</span> </pre>

			
		</div>

		<div class="well well-sm well-light">
			<h3>Spinner</h3>

			<div class="row">

				<div class="col-sm-6 col-md-6 col-lg-6">

					<div class="form-group">
						<label>Spinner Right</label>
						<input class="form-control"  id="spinner-decimal" name="spinner-decimal" value="7.99">
					</div>

				</div>

				<div class="col-sm-6 col-md-6 col-lg-6">

					<div class="form-group">
						<label>Spinner Left</label>
						<input class="form-control spinner-left"  id="spinner" name="spinner" value="1" type="text">
					</div>

				</div>

			</div>

		</div>

	</div>

	<div class="col-sm-6 col-md-6 col-lg-6">

		<div class="well well-sm well-light">

			<h3>Menu <br> <small>Easy Menu List</small></h3>

			<ul id="menu">
				<li>
					<a href="javascript:void(0);" class="ui-state-disabled">Aberdeen (disabled)</a>
				</li>
				<li>
					<a href="javascript:void(0);">Ada</a>
				</li>
				<li>
					<a href="javascript:void(0);">Adamsville</a>
				</li>
				<li>
					<a href="javascript:void(0);">Addyston</a>
				</li>
				<li>
					<a href="javascript:void(0);">Delphi</a>
					<ul>
						<li>
							<a href="javascript:void(0);">Ada</a>
						</li>
						<li>
							<a href="javascript:void(0);">Saarland</a>
						</li>
						<li>
							<a href="javascript:void(0);">Salzburg</a>
						</li>
					</ul>
				</li>
				<li>
					<a href="javascript:void(0);">Saarland</a>
				</li>
				<li>
					<a href="javascript:void(0);">Salzburg</a>
					<ul>
						<li>
							<a href="javascript:void(0);">Delphi</a>
							<ul>
								<li>
									<a href="javascript:void(0);" class="ui-state-disabled">Ada</a>
								</li>
								<li>
									<a href="javascript:void(0);">Saarland</a>
								</li>
								<li>
									<a href="javascript:void(0);">Salzburg</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="?Delphi">Delphi</a>
							<ul>
								<li>
									<a href="javascript:void(0);">Ada</a>
								</li>
								<li>
									<a href="javascript:void(0);">Saarland</a>
								</li>
								<li>
									<a href="javascript:void(0);">Salzburg</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="javascript:void(0);">Perch</a>
						</li>
					</ul>
				</li>
			</ul>

		</div>


		<div class="well well-sm well-light">
			<h3>Auto Complete
			<br>
			<small>Type something to reveal autocompelete tags</small></h3>

			<input class="form-control" placeholder="Type something..." type="text"
			data-autocomplete='[
			"ActionScript",
			"AppleScript",
			"Asp",
			"BASIC",
			"C",
			"C++",
			"Clojure",
			"COBOL",
			"ColdFusion",
			"Erlang",
			"Fortran",
			"Groovy",
			"Haskell",
			"Java",
			"JavaScript",
			"Lisp",
			"Perl",
			"PHP",
			"Python",
			"Ruby",
			"Scala",
			"Scheme"]'>

			<p class="note">
				Usage: data-autocomplete= ' ["this", "message", "bold", "text"] '
			</p>

			<h3>Auto Complete Ajax
			<br>
			<small>Fetches data from JSON url</small></h3>

			<input class="form-control" placeholder="City..." type="text" id="city">
			<div id="log" class="font-xs margin-top-10 text-danger"></div>

		</div>

		<div class="well well-sm well-light">
			<h3>Accordion
			<br>
			<small>With fontawesome icons</small></h3>
			<div id="accordion">
				<div>
					<h4>First</h4>
					<div class="padding-10">
						Proin elit arcu, rutrum commodo, vehicula tempus, commodo a, risus. Curabitur nec arcu. Donec sollicitudin mi sit amet mauris.
						Nam elementum quam ullamcorper ante. Etiam aliquet massa et lorem. Mauris dapibus lacus auctor risus. Aenean tempor ullamcorper leo.
						Vivamus sed magna quis ligula eleifend adipiscing. Duis orci. Aliquam sodales tortor vitae ipsum. Aliquam nulla. Duis aliquam molestie erat.
						Ut et mauris vel pede varius sollicitudin. Sed ut dolor nec orci tincidunt interdum. Phasellus ipsum. Nunc tristique tempus lectus.
					</div>
				</div>

				<div>
					<h4>Second</h4>
					<div class="padding-10">
						Proin elit arcu, rutrum commodo, vehicula tempus, commodo a, risus. Curabitur nec arcu. Donec sollicitudin mi sit amet mauris.
						Nam elementum quam ullamcorper ante. Etiam aliquet massa et lorem. Mauris dapibus lacus auctor risus. Aenean tempor ullamcorper leo.
						Vivamus sed magna quis ligula eleifend adipiscing. Duis orci. Aliquam sodales tortor vitae ipsum. Aliquam nulla. Duis aliquam molestie erat.
						Ut et mauris vel pede varius sollicitudin. Sed ut dolor nec orci tincidunt interdum. Phasellus ipsum. Nunc tristique tempus lectus.
					</div>
				</div>
				<div>
					<h4>Third</h4>
					<div class="padding-10">
						Proin elit arcu, rutrum commodo, vehicula tempus, commodo a, risus. Curabitur nec arcu. Donec sollicitudin mi sit amet mauris.
						Nam elementum quam ullamcorper ante. Etiam aliquet massa et lorem. Mauris dapibus lacus auctor risus. Aenean tempor ullamcorper leo.
						Vivamus sed magna quis ligula eleifend adipiscing. Duis orci. Aliquam sodales tortor vitae ipsum. Aliquam nulla. Duis aliquam molestie erat.
						Ut et mauris vel pede varius sollicitudin. Sed ut dolor nec orci tincidunt interdum. Phasellus ipsum. Nunc tristique tempus lectus.
					</div>
				</div>
			</div>

		</div>
		
		<div class="well well-sm well-light">
			<h3>Progress Bar
			<br>
			<small>Default progress bar.</small></h3>
			
			<div id="progressbar"></div>
		</div>
	
	</div>

</div>

<!-- end row -->

<!-- ui-dialog -->
<div id="dialog_simple" title="Dialog Simple Title">
	<p>
		Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
	</p>
</div>

<div id="dialog-message" title="Dialog Simple Title">
	<p>
		This is the default dialog which is useful for displaying information. The dialog window can be moved, resized and closed with the 'x' icon.
	</p>

	<div class="hr hr-12 hr-double"></div>

	
		Currently using
		<b>36% of your storage space</b>
		<div class="progress progress-striped active no-margin">
			<div class="progress-bar progress-primary" role="progressbar" style="width: 36%"></div>
		</div>
	
</div><!-- #dialog-message -->

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

	<script type="text/javascript">
		
		$(document).ready(function() {
			
			// menu
			$("#menu").menu();
		
			/*
			 * AUTO COMPLETE AJAX
			 */
		
			function log(message) {
				$("<div>").text(message).prependTo("#log");
				$("#log").scrollTop(0);
			}
		
			$("#city").autocomplete({
				source : function(request, response) {
					$.ajax({
						url : "http://ws.geonames.org/searchJSON",
						dataType : "jsonp",
						data : {
							featureClass : "P",
							style : "full",
							maxRows : 12,
							name_startsWith : request.term
						},
						success : function(data) {
							response($.map(data.geonames, function(item) {
								return {
									label : item.name + (item.adminName1 ? ", " + item.adminName1 : "") + ", " + item.countryName,
									value : item.name
								}
							}));
						}
					});
				},
				minLength : 2,
				select : function(event, ui) {
					log(ui.item ? "Selected: " + ui.item.label : "Nothing selected, input was " + this.value);
				}
			});
		
			/*
			 * Spinners
			 */
			$("#spinner").spinner();
			$("#spinner-decimal").spinner({
				step : 0.01,
				numberFormat : "n"
			});
		
			$("#spinner-currency").spinner({
				min : 5,
				max : 2500,
				step : 25,
				start : 1000,
				numberFormat : "C"
			});
		
			/*
			 * CONVERT DIALOG TITLE TO HTML
			 * REF: http://stackoverflow.com/questions/14488774/using-html-in-a-dialogs-title-in-jquery-ui-1-10
			 */
			$.widget("ui.dialog", $.extend({}, $.ui.dialog.prototype, {
				_title : function(title) {
					if (!this.options.title) {
						title.html("&#160;");
					} else {
						title.html(this.options.title);
					}
				}
			}));
		
		
			/*
			* DIALOG SIMPLE
			*/
		
			// Dialog click
			$('#dialog_link').click(function() {
				$('#dialog_simple').dialog('open');
				return false;
		
			});
		
			$('#dialog_simple').dialog({
				autoOpen : false,
				width : 600,
				resizable : false,
				modal : true,
				title : "<div class='widget-header'><h4><i class='fa fa-warning'></i> Empty the recycle bin?</h4></div>",
				buttons : [{
					html : "<i class='fa fa-trash-o'></i>&nbsp; Delete all items",
					"class" : "btn btn-danger",
					click : function() {
						$(this).dialog("close");
					}
				}, {
					html : "<i class='fa fa-times'></i>&nbsp; Cancel",
					"class" : "btn btn-default",
					click : function() {
						$(this).dialog("close");
					}
				}]
			});
		
			/*
			* DIALOG HEADER ICON
			*/
		
			// Modal Link
			$('#modal_link').click(function() {
				$('#dialog-message').dialog('open');
				return false;
			});
		
			$("#dialog-message").dialog({
				autoOpen : false,
				modal : true,
				title : "<div class='widget-header'><h4><i class='icon-ok'></i> jQuery UI Dialog</h4></div>",
				buttons : [{
					html : "Cancel",
					"class" : "btn btn-default",
					click : function() {
						$(this).dialog("close");
					}
				}, {
					html : "<i class='fa fa-check'></i>&nbsp; OK",
					"class" : "btn btn-primary",
					click : function() {
						$(this).dialog("close");
					}
				}]
		
			});
		
			/*
			 * Remove focus from buttons
			 */
			$('.ui-dialog :button').blur();
		
			/*
			 * Just Tabs
			 */
		
			$('#tabs').tabs();
		
			/*
			 *  Simple tabs adding and removing
			 */
		
			$('#tabs2').tabs();
		
			// Dynamic tabs
			var tabTitle = $("#tab_title"), tabContent = $("#tab_content"), tabTemplate = "<li style='position:relative;'> <span class='air air-top-left delete-tab' style='top:7px; left:7px;'><button class='btn btn-xs font-xs btn-default hover-transparent'><i class='fa fa-times'></i></button></span></span><a href='#{href}'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; #{label}</a></li>", tabCounter = 2;
		
			var tabs = $("#tabs2").tabs();
		
			// modal dialog init: custom buttons and a "close" callback reseting the form inside
			var dialog = $("#addtab").dialog({
				autoOpen : false,
				width : 600,
				resizable : false,
				modal : true,
				buttons : [{
					html : "<i class='fa fa-times'></i>&nbsp; Cancel",
					"class" : "btn btn-default",
					click : function() {
						$(this).dialog("close");
		
					}
				}, {
		
					html : "<i class='fa fa-plus'></i>&nbsp; Add",
					"class" : "btn btn-danger",
					click : function() {
						addTab();
						$(this).dialog("close");
					}
				}]
			});
		
			// addTab form: calls addTab function on submit and closes the dialog
			var form = dialog.find("form").submit(function(event) {
				addTab();
				dialog.dialog("close");
				event.preventDefault();
			});
		
			// actual addTab function: adds new tab using the input from the form above
			function addTab() {
				var label = tabTitle.val() || "Tab " + tabCounter, id = "tabs-" + tabCounter, li = $(tabTemplate.replace(/#\{href\}/g, "#" + id).replace(/#\{label\}/g, label)), tabContentHtml = tabContent.val() || "Tab " + tabCounter + " content.";
		
				tabs.find(".ui-tabs-nav").append(li);
				tabs.append("<div id='" + id + "'><p>" + tabContentHtml + "</p></div>");
				tabs.tabs("refresh");
				tabCounter++;
		
				// clear fields
				$("#tab_title").val("");
				$("#tab_content").val("");
			}
		
			// addTab button: just opens the dialog
			$("#add_tab").button().click(function() {
				dialog.dialog("open");
			});
		
			// close icon: removing the tab on click
			$("#tabs2").on("click", 'span.delete-tab', function() {
		
				var panelId = $(this).closest("li").remove().attr("aria-controls");
				$("#" + panelId).remove();
				tabs.tabs("refresh");
			});
		
			/*
			* ACCORDION
			*/
			//jquery accordion
			
		     var accordionIcons = {
		         header: "fa fa-plus",    // custom icon class
		         activeHeader: "fa fa-minus" // custom icon class
		     };
		     
			$("#accordion").accordion({
				autoHeight : false,
				heightStyle : "content",
				collapsible : true,
				animate : 300,
				icons: accordionIcons,
				header : "h4",
			})
		
			/*
			 * PROGRESS BAR
			 */
			$("#progressbar").progressbar({
		     	value: 25,
		     	create: function( event, ui ) {
		     		$(this).removeClass("ui-corner-all").addClass('progress').find(">:first-child").removeClass("ui-corner-left").addClass('progress-bar progress-bar-success');
				}
			});			

		})

	</script>

<?php 
	//include footer
	include("inc/google-analytics.php"); 
?>