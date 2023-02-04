<?php

//initilize the page
require_once("inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

/*---------------- PHP Custom Scripts ---------

YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
E.G. $page_title = "Custom Title" */

$page_title = "Invoice";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav["template"]["sub"]["misc"]["sub"]["invoice"]["active"] = true;
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

		<!-- widget grid -->
		<section id="widget-grid" class="">
		
			<!-- row -->
			<div class="row">
		
				<!-- NEW WIDGET START -->
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
		
										<div class="col-sm-4">
		
											<div class="input-group">
												<input class="form-control" type="text" placeholder="Type invoice number or date...">
												<div class="input-group-btn">
													<button class="btn btn-default" type="button">
														<i class="fa fa-search"></i> Search
													</button>
												</div>
											</div>
										</div>
		
										<div class="col-sm-8 text-align-right">
		
											<div class="btn-group">
												<a href="javascript:void(0)" class="btn btn-sm btn-primary"> <i class="fa fa-edit"></i> Edit </a>
											</div>
		
											<div class="btn-group">
												<a href="javascript:void(0)" class="btn btn-sm btn-success"> <i class="fa fa-plus"></i> Create New </a>
											</div>
		
										</div>
		
									</div>
		
								</div>
		
								<div class="padding-10">
									<br>
									<div class="pull-left">
										<img src="<?php echo ASSETS_URL; ?>/img/logo-blacknwhite.png" width="150" height="32" alt="invoice icon">
		
										<address>
											<br>
											<strong>SmartAdmin, Inc.</strong>
											<br>
											231 Ajax Rd,
											<br>
											Detroit MI - 48212, USA
											<br>
											<abbr title="Phone">P:</abbr> (123) 456-7890
										</address>
									</div>
									<div class="pull-right">
										<h1 class="font-400">invoice</h1>
									</div>
									<div class="clearfix"></div>
									<br>
									<br>
									<div class="row">
										<div class="col-sm-9">
											<h4 class="semi-bold">Rogers, Inc.</h4>
											<address>
												<strong>Mr. Simon Hedger</strong>
												<br>
												342 Mirlington Road,
												<br>
												Calfornia, CA 431464
												<br>
												<abbr title="Phone">P:</abbr> (467) 143-4317
											</address>
										</div>
										<div class="col-sm-3">
											<div>
												<div>
													<strong>INVOICE NO :</strong>
													<span class="pull-right"> #AA-454-4113-00 </span>
												</div>
		
											</div>
											<div>
												<div class="font-md">
													<strong>INVOICE DATE :</strong>
													<span class="pull-right"> <i class="fa fa-calendar"></i> 15/02/13 </span>
												</div>
		
											</div>
											<br>
											<div class="well well-sm  bg-color-darken txt-color-white no-border">
												<div class="fa-lg">
													Total Due :
													<span class="pull-right"> 4,972 USD** </span>
												</div>
		
											</div>
											<br>
											<br>
										</div>
									</div>
									<table class="table table-hover">
										<thead>
											<tr>
												<th class="text-center">QTY</th>
												<th>ITEM</th>
												<th>DESCRIPTION</th>
												<th>PRICE</th>
												<th>SUBTOTAL</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td class="text-center"><strong>1</strong></td>
												<td><a href="javascript:void(0);">Print and Web Logo Design</a></td>
												<td>Perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium totam rem aperiam xplicabo.</td>
												<td>$1,300.00</td>
		
												<td>$1,300.00</td>
											</tr>
											<tr>
												<td class="text-center"><strong>1</strong></td>
												<td><a href="javascript:void(0);">SEO Management</a></td>
												<td>Sit voluptatem accusantium doloremque laudantium inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</td>
												<td>$1,400.00</td>
												<td>$1,400.00</td>
											</tr>
											<tr>
												<td class="text-center"><strong>1</strong></td>
												<td><a href="javascript:void(0);">Backend Support and Upgrade</a></td>
												<td>Inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</td>
												<td>$1,700.00</td>
												<td>$1,700.00</td>
											</tr>
											<tr>
												<td colspan="4">Total</td>
												<td><strong>$4,400.00</strong></td>
											</tr>
											<tr>
												<td colspan="4">HST/GST</td>
												<td><strong>13%</strong></td>
											</tr>
										</tbody>
									</table>
		
									<div class="invoice-footer">
		
										<div class="row">
		
											<div class="col-sm-7">
												<div class="payment-methods">
													<h5>Payment Methods</h5>
													<img src="<?php echo ASSETS_URL; ?>/img/invoice/paypal.png" width="64" height="64" alt="paypal">
													<img src="<?php echo ASSETS_URL; ?>/img/invoice/americanexpress.png" width="64" height="64" alt="american express">
													<img src="<?php echo ASSETS_URL; ?>/img/invoice/mastercard.png" width="64" height="64" alt="mastercard">
													<img src="<?php echo ASSETS_URL; ?>/img/invoice/visa.png" width="64" height="64" alt="visa">
												</div>
											</div>
											<div class="col-sm-5">
												<div class="invoice-sum-total pull-right">
													<h3><strong>Total: <span class="text-success">$4,972 USD</span></strong></h3>
												</div>
											</div>
		
										</div>
										
										<div class="row">
											<div class="col-sm-12">
												<p class="note">**To avoid any excess penalty charges, please make payments within 30 days of the due date. There will be a 2% interest charge per month on all late invoices.</p>
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

	$(document).ready(function() {
		// PAGE RELATED SCRIPTS
	})

</script>

<?php 
	//include footer
	include("inc/google-analytics.php"); 
?>