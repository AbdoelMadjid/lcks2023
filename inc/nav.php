<aside id="left-panel">
	<div class="login-info">
		<span> 
			<a href="javascript:void(0);" id="show-shortcut" data-action="toggleShortcut">
				<span><i class="fa fa-user-circle fa-lg online"></i>&nbsp;&nbsp;
					<?php echo $NamaPengguna; ?>
				</span>
				<?php echo $TmplShortcut2; ?>
			</a>
		</span>
	</div>
	<nav>
		<?php
			$ui = new SmartUI();
			$ui->create_nav($page_nav)->print_html();
		?>
	</nav>
	<span class="minifyme" data-action="minifyMenu"> <i class="fa fa-arrow-circle-left hit"></i> </span>
</aside>
<div id="preloader"><div id="cssload"></div></div>