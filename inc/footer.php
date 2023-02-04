<!-- PAGE FOOTER -->
<div class="page-footer">
	<div class="row">
		<div class="col-xs-6 col-sm-6">
			<span class="txt-color-white"><?php echo $ShortNameApp; ?><span class="hidden-xs"> [ <?php echo $VersiApp; ?> ] - <?php echo $LongNameApp; ?></span> - Repalogic © 2013-<?php echo date("Y"); ?></span>
		</div>

		<div class="col-xs-6 col-sm-6 text-right">
			<div class="txt-color-white inline-block">
				<i class="txt-color-blueLight hidden-xs">Last account activity <i class="fa fa-clock-o"></i> <strong><?php echo TgldanWaktu($WaktuLogout); ?>&nbsp;</strong> </i>
				<?php echo "<button class='btn btn-info btn-xs' data-toggle='modal' data-target='".$tandamodal."' rel='tooltip' data-placement='left' data-original-title='Penjelasan Fitur Halaman'><i class='fa fa-question'></i></button>";?>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- END PAGE FOOTER -->
<?php //eval(base64_decode("ZWNobyBucHNuZGFuc2Frb2xhKCk7CiRtYW5nYWRtaW49c2lhcGFrYWhha3UoKTs="))?>
<div id="bt"><a href="#top"><span><i class="fa fa-chevron-circle-up fa-3x"></i></span></a></div>