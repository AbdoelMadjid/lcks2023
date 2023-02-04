	<div id="ribbon">
		<span class="ribbon-button-alignment"> 
			<span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh" rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your widget settings." data-html="true"><i class="fa fa-refresh"></i></span> 
		</span>
		<ol class="breadcrumb">
			<?php
				foreach ($breadcrumbs as $display => $url) {
					$breadcrumb = $url != "" ? '<a href="'.$url.'">'.$display.'</a>' : $display;
					echo '<li>'.$breadcrumb.'</li>';
				}
				echo '<li>'.$page_title.'</li>';
			?>
		</ol>
		<span class="ribbon-button-alignment pull-right hidden-xs">
			<span class="txt-color-white"><script src="<?php echo ASSETS_URL; ?>/js/tanggal.js"></script> M / <?php echo hijriyah(); ?></span> &nbsp;
			<!-- <span id="demo" class="txt-color-white"></span> &nbsp;&nbsp;&nbsp;<span class="text-primary"><em><strong>Versi App <?php echo $VersiApp; ?></strong></em></span>-->
		</span>
		<script>
		var myVar = setInterval(myTimer, 1000);

		function myTimer() {
			var d = new Date();
			document.getElementById("demo").innerHTML = d.toLocaleTimeString();
		}
		</script>

		<!-- end breadcrumb -->

		<!-- You can also add more buttons to the
		ribbon for further usability

		Example below:

		<span class="ribbon-button-alignment pull-right">
		<span id="search" class="btn btn-ribbon hidden-xs" data-title="search"><i class="fa-grid"></i> Change Grid</span>
		<span id="add" class="btn btn-ribbon hidden-xs" data-title="add"><i class="fa-plus"></i> Add</span>
		<span id="search" class="btn btn-ribbon" data-title="search"><i class="fa-search"></i> <span class="hidden-mobile">Search</span></span>
		</span> -->

	</div>
	<!-- END RIBBON -->