<?php
/* 12/6/2016 --> Sabtu, 28 Januari 2017 13.10.40 --> 07/01/2023 18:42
Design and Programming By. Abdul Madjid, S.Pd., M.Pd.
SMK Negeri 1 Kadipaten
Pin 520543F3 HP. 0812-3000-0420
https://twitter.com/AbdoelMadjid 
https://www.facebook.com/abdulmadjid.mpd
*/
//CONFIGURATION for SmartAdmin UI
//ribbon breadcrumbs config
//array("Display Name" => "URL");
/*$breadcrumbs = array(
	"Home" => APP_URL
);
*/
//eval(base64_decode("
$page_nav_master = array(
	"beranda" => array(
		"title" => "Beranda",
		"icon" => "fa-home",
		"url" => APP_URL
	),
	"profil" => array(
		"title" => "Profil Master",
		"icon" => "fa-user-circle-o",
		"url" => APP_URL."?page=profil-master"
	),
	"tools" => array(
		"title" => "Tools",
		"icon" => "fa-gears",
		"sub" => array(
			"opsiaplikasi" => array(
				"title" => "Opsi Aplikasi",
				"icon" => "fa-fire",
				"url" => APP_URL.'?page=tools-opsi-aplikasi'
			),
			"ngimpordata" => array(
				"title" => "Impor Data Master",
				"icon" => "fa-upload",
				"url" => APP_URL.'?page=tools-impor-datamaster'
			),
			"ekspordata" => array(
				'title' => 'Ekspor Data Master',
				'icon' => 'fa-download',
				'url' => APP_URL.'?page=tools-ekspor-datamaster'
			),
			"backupdb" => array(
				"title" => "Backup Database",
				"icon" => "fa-database",
				"url" => APP_URL.'?page=tools-backup-db'
			),
			"datalog" => array(
				"title" => "Data Login",
				"icon" => "fa-sign-in",
				"url" => APP_URL.'?page=tools-data-log'
			)
		)
	),
	"kurikulum" => array(
		"title" => "Kurikulum",
		"icon" => "fa-credit-card",
		"sub" => array(
			"versikurikulum" => array(
				"title" => "Versi Kurikulum",
				"icon" => "fa-folder-open",
				"url" => APP_URL.'?page=kurikulum-versi-kur'
			),
			"pengumuman" => array(
				"title" => "Pengumuman",
				"icon" => "fa-bullhorn",
				"url" => APP_URL.'?page=kurikulum-pengumuman'
			),
			"kuncikbm" => array(
				"title" => "Kunci Data KBM",
				"icon" => "fa-key",
				"url" => APP_URL.'?page=kurikulum-kunci-kbm'
			),
			"perangkatujian" => array(
				"title" => "Perangkat Ujian",
				"icon" => "fa-address-book-o",
				"url" => APP_URL."?page=kurikulum-perangkat-ujian"
			),
			"dokumenguru" => array(
				"title" => "Dokumen Guru",
				"icon" => "fa-book",
				'sub' => array(
					"absensikelas" => array(
						"title" => "Absensi",
						"icon" => "fa-calendar",
						"url" => APP_URL."?page=kurikulum-dokguru-absensi-kelas"
					),			
					"arsipnilai" => array(
						"title" => "Arsip KBM & Nilai",
						"icon" => "fa-map-o",
						"url" => APP_URL."?page=kurikulum-dokguru-arsip-nilai"
					)
				)
			),
			"dokumensiswa" => array(
				"title" => "Dokumen Siswa",
				"icon" => "fa-book",
				'sub' => array(
					"cetakrapor" => array(
						"title" => "Cetak Rapor",
						"icon" => "fa-print",
						"url" => APP_URL."?page=kurikulum-doksiswa-cetak-rapor"
					),
					"transkrip" => array(
						'title' => 'Transkrip Nilai',
						'icon' => 'fa-drivers-license-o',
						"url" => APP_URL."?page=kurikulum-doksiswa-cetak-transkrip"
					)
				)			
			),
			"datakbm" => array(
				"title" => "Proses KBM",
				"icon" => "fa-book",
				'sub' => array(
					"perkelas" => array(
						"title" => "Per Kelas",
						"icon" => "fa-building",
						"url" => APP_URL."?page=kurikulum-datakbm-perkelas"
					),
					"perguru" => array(
						"title" => "Per Guru",
						"icon" => "fa-book",
						"url" => APP_URL."?page=kurikulum-datakbm-perguru"
					),
					"remedial" => array(
						"title" => "Remedial",
						"icon" => "fa-retweet",
						"url" => APP_URL."?page=kurikulum-remedial"
					)
				)			
			),
			"dapodik" => array(
				"title" => "Data Dapodik",
				"icon" => "fa-cubes",
				"url" => APP_URL.'?page=kurikulum-data-dapodik'
			)
		)
	),
	"akademik" => array(
		"title" => "Akademik",
		"icon" => "fa-briefcase",
		"sub" => array(
			"identsekolah" => array(
				"title" => "Identitas Sekolah",
				"icon" => "fa-university",
				"url" => APP_URL."?page=akademik-identitas-sekolah"
			),
			"tenagapendidik" => array(
				"title" => "Tenaga Pendidik",
				"icon" => "fa-user",
				"url" => APP_URL."?page=akademik-tenaga-pendidik"
			),
			"paketkeahlian" => array(
				"title" => "Paket Keahlian",
				"icon" => "fa-sitemap",
				"url" => APP_URL."?page=akademik-paket-keahlian"
			),
			"matapelajaran" => array(
				"title" => "Mata Pelajaran",
				"icon" => "fa-book",
				"url" => APP_URL."?page=akademik-mata-pelajaran"
			),
			"kikd" => array(
				"title" => "KI KD",
				"icon" => "fa-list",
				"url" => APP_URL."?page=akademik-ki-kd"
			),
			"kelas" => array(
				"title" => "Kelas & Wali Kelas",
				"icon" => "fa-building-o",
				"url" => APP_URL."?page=akademik-kelas-walikelas"
			),
			"pesertadidik" => array(
				"title" => "Peserta Didik",
				"icon" => "fa-meh-o",
				"url" => APP_URL."?page=akademik-peserta-didik"
			)
		)
	),
    "bpbk" => array(
		"title" => "BP / BK",
		"url" => APP_URL."?page=bpbk-sikap-leger",
		"icon" => "fa-user-plus"
	),
    "about" => array(
		"title" => "About",
		"url" => APP_URL."?page=about",
		"icon" => "fa-question-circle txt-color-blue"
	),
	"template" => array(
		"title" => "Template",
		"icon" => "fa-cube txt-color-blue",
		"sub" => array(
			"dashboard" => array(
				"title" => "Dashboard",
				"icon" => "fa-building-o",
				"sub" => array(
					"analytics" => array(
						"title" => "Analytics Dashboard",
						"icon" => "fa-bar-chart",
						"url" => APP_URL."?page=dashboard-analytics"
					),
					"marketing" => array(
						"title" => "Marketing Dashboard",
						"icon" => "fa-coffee",
						"url" => APP_URL."?page=dashboard-marketing"
					),
					"social" => array(
						"title" => "Social Wall",
						"icon" => "fa-meh-o",
						"url" => APP_URL."?page=dashboard-social"
					)
				)
			),
			"smartui" => array(
				"title" => "Smart UI",
				"icon" => "fa-code",
				"sub" => array(
					"general" => array(
						'title' => 'General Elements',
						'icon' => 'fa-folder-open',
						'sub' => array(
							'alert' => array(
								'title' => 'Alerts',
								'url' => APP_URL."?page=smartui-alert"
							),
							'progress' => array(
								'title' => 'Progress',
								'url' => APP_URL."?page=smartui-progress"
							)
						)
					),
					"carousel" => array(
						"title" => "Carousel",
						"url" => APP_URL."?page=smartui-carousel"
					),
					"tab" => array(
						"title" => "Tab",
						"url" => APP_URL."?page=smartui-tab"
					),
					"accordion" => array(
						"title" => "Accordion",
						"url" => APP_URL."?page=smartui-accordion"
					),
					"widget" => array(
						'title' => "Widget",
						'url' => APP_URL."?page=smartui-widget"
					),
					"datatable" => array(
						"title" => "DataTable",
						"url" => APP_URL."?page=smartui-datatable"
					),
					"button" => array(
						"title" => "Button",
						"url" => APP_URL."?page=smartui-button"
					),
					'smartform' => array(
						'title' => 'Smart Form',
						'url' => APP_URL."?page=smartui-form"
					)
				)
			),
			"smartint" => array(
				"title" => "SmartAdmin Intel",
				"icon" => "fa-cube txt-color-blue",
				"sub" => array(
					"layouts" => array(
						"title" => "App Layouts",
						"icon" => "fa-gear",
						"url" => APP_URL."?page=layouts"
					),
					"skins" => array(
						"title" => "Prebuilt Skins",
						"icon" => "fa-picture-o",
						"url" => APP_URL."?page=skins"
					),
					"applayout" => array(
						"title" => "App Settings",
						"icon" => "fa-cube",
						"url" => APP_URL."?page=applayout"
					)
				)
			),
			"outlook" => array(
				"title" => "Outlook",
				"icon" => "fa-inbox",
				"url" => APP_URL."?page=inbox",
				"label_htm" => '<span class="badge pull-right inbox-badge margin-right-13">14</span>'
			),
			"graphs" => array(
				"title" => "Graphs",
				"icon" => "fa-bar-chart-o",
				"sub" => array(
					"flot" => array(
						"title" => "Flot Chart",
						"url" => APP_URL."?page=flot"
					),
					"morris" => array(
						"title" => "Morris Charts",
						"url" => APP_URL."?page=morris"
					),
					"sparklines" => array(
						"title" => "Sparklines",
						"url" => APP_URL."?page=sparkline-charts"
					),
					"easypie" => array(
						"title" => "EasyPieCharts",
						"url" => APP_URL."?page=easypie-charts"
					),
					"dygraphs" => array(
						"title" => "Dygraphs",
						"url" => APP_URL."?page=dygraphs",
					),
					"chartjs" => array(
						"title" => "Chart.js",
						"url" => APP_URL."?page=chartjs"
					),
					"highchart" => array(
						"title" => "HighchartTable",
						"url" => APP_URL."?page=hchartable",
						"label_htm" => ' <span class="badge pull-right inbox-badge bg-color-yellow">new</span>'
					)
				)
			),
			"tables" => array(
				"title" => "Tables",
				"icon" => "fa-table",
				"sub" => array(
					"normal" => array(
						"title" => "Normal Tables",
						"url" => APP_URL."?page=table"
					),
					"data" => array(
						"title" => "Data Tables",
						"url" => APP_URL."?page=datatables",
						"label_htm" => ' <span class="badge inbox-badge bg-color-greenLight">responsive</span>'
					),
					"jqgrid" => array(
						"title" => "Jquery Grid",
						"url" => APP_URL."?page=jqgrid"
					)
				)
			),
			"forms" => array(
				"title" => "Forms",
				"icon" => "fa-pencil-square-o",
				"sub" => array(
					"smart_elements" => array(
						"title" => "Smart Form Elements",
						"url" => APP_URL."?page=form-elements"
					),
					"smart_layout" => array(
						"title" => "Smart Form Layouts",
						"url" => APP_URL."?page=form-templates"
					),
					"smart_validation" => array(
						"title" => "Smart Form Validation",
						"url" => APP_URL."?page=validation"
					),
					"bootstrap_forms" => array(
						"title" => "Bootstrap Form Elements",
						"url" => APP_URL."?page=bootstrap-forms"
					),
					"form_plugins" => array(
						"title" => "Form Plugins",
						"url" => APP_URL."?page=plugins"
					),
					"wizards" => array(
						"title" => "Wizards",
						"url" => APP_URL."?page=wizard"
					),
					"bootstrap_editors" => array(
						"title" => "Bootstrap Editors",
						"url" => APP_URL."?page=other-editors"
					),
					"dropzone" => array(
						"title" => "Dropzone",
						"url" => APP_URL."?page=dropzone"
					),
					"imagecrop" => array(
						"title" => "Image Cropping",
						"url" => APP_URL."?page=image-editor"
					),
					"ck_editor" => array(
						"title" => "CK Editor",
						"url" => APP_URL."?page=ckeditor"
					)
				)
			),
			"ui_elements" => array(
				"title" => "UI Elements",
				"icon" => "fa-desktop",
				"sub" => array(
					"general" => array(
						"title" => "General Elements",
						"url" => APP_URL."?page=general-elements"
					),
					"buttons" => array(
						"title" => "Buttons",
						"url" => APP_URL."?page=buttons"
					),
					"icons" => array(
						"title" => "Icons",
						"sub" => array(
							"fa" => array(
								"title" => "Font Awesome",
								"icon" => "fa-plane",
								"url" => APP_URL."?page=fa"
							),
							"glyph" => array(
								"title" => "Glyph Icons",
								"icon" => "fa-plane",
								"url" => APP_URL."?page=glyph"
							),
							"flags" => array(
								"title" => "Flags",
								"icon" => "fa-flag",
								"url" => APP_URL."?page=flags"
							)
						)
					),
					"grid" => array(
						"title" => "Grid",
						"url" => APP_URL."?page=grid"
					),
					"tree_view" => array(
						"title" => "Tree View",
						"url" => APP_URL."?page=treeview"
					),
					"nestable_lists" => array(
						"title" => "Nestable Lists",
						"url" => APP_URL."?page=nestable-list"
					),
					"jquery_ui" => array(
						"title" => "jQuery UI",
						"url" => APP_URL."?page=jqui"
					),
					"typo" => array(
						"title" => "Typography",
						"url" => APP_URL."?page=typography"
					),
					"nav6" => array(
						"title" => "Six Level Menu",
						"sub" => array(
							"second_lvl" => array(
								"title" => "Item #2",
								"icon" => "fa-folder-open",
								"sub" => array(
									"third_lvl" => array(
										"title" => "Sub #2.1",
										"icon" => "fa-folder-open",
										"sub" => array(
											"file" => array(
												"title" => "Item #2.1.1",
												"icon" => "fa-file-text"
											),
											"fourth_lvl" => array(
												"title" => "Expand",
												"icon" => "fa-plus",
												"sub" => array(
													"file" => array(
														"title" => "File",
														"icon" => "fa-file-text"
													),
													"fifth_lvl" => array(
														"title" => "Delete",
														"icon" => "fa-trash-o"
													)
												)
											)
										)
									)
								)
							),
							"folder" => array(
								"title" => "Item #3",
								"icon" => "fa-folder-open",
								"sub" => array(
									"third_lvl" => array(
										"title" => "Sub #3.1",
										"icon" => "fa-folder-open",
										"sub" => array(
											"file1" => array(
												"title" => "File",
												"icon" => "fa-file-text"
											),
											"file2" => array(
												"title" => "File",
												"icon" => "fa-file-text"
											)
										)
									)
								)
							),
							"disabled" => array(
								"title" => "Item #4 (disabled)",
								"class" => "inactive",
								"icon" => "fa-folder-open"
							)
						)
					),
				)
			),
			"widgets" => array(
				"title" => "Widgets",
				"url" => APP_URL."?page=widgets",
				"icon" => "fa-list-alt"
			),
			"cool" => array(
				"title" => "Cool Features!",
				"icon" => "fa-cloud",
				"icon_badge" => "3",
				"sub" => array(
					"cal" => array(
						"title" => "Calendar",
						"url" => APP_URL."?page=calendar",
						"icon" => "fa-calendar"
					),
					"gmap_skins" => array(
						"title" => "GMap Skins",
						"url" => APP_URL."?page=gmap-xml",
						"icon" => "fa-map-marker",
						"label_htm" => '<span class="badge bg-color-greenLight pull-right inbox-badge">9</span>'
					)
				)

			),
			"views" => array(
				"title" => "App Views",
				"icon" => "fa-puzzle-piece",
				"sub" => array(
					"projects" => array(
						"title" => "Projects",
						"icon" => "fa fa-file-text-o",
						"url" => APP_URL."?page=projects"
					),
					"blog" => array(
						"title" => "Blog",
						"icon" => "fa fa-paragraph",
						"url" => APP_URL."?page=blog"
					),
					"gallery" => array(
						"title" => "Gallery",
						"icon" => "fa fa-picture-o",
						"url" => APP_URL."?page=gallery"
					),
					"forum" => array(
						"title" => "Forum Layout",
						"icon" => "fa fa-comments",
						"sub" => array(
							"general" => array(
								"title" => "General View",
								"url" => APP_URL."?page=forum"
							),
							"topic" => array(
								"title" => "Topic View",
								"url" => APP_URL."?page=forum-topic"
							),
							"post" => array(
								"title" => "Post View",
								"url" => APP_URL."?page=forum-post"
							),
						)
					),
					"profile" => array(
						"title" => "Profile",
						"icon" => "fa fa-group",
						"url" => APP_URL."?page=profile"
					),
					"timeline" => array(
						"title" => "Timeline",
						"icon" => "fa fa-clock-o",
						"url" => APP_URL."?page=timeline"
					),
					"search" => array(
						"title" => "Search Page",
						"icon" => "fa fa-search",
						"url" => APP_URL."?page=search"
					),
				)
			),
			"ecommerce" => array(
				"title" => "E-Commerce",
				"icon" => "fa-shopping-cart",
				"sub" => array(
					"orders" => array(
						"title" => "Orders",
						"url" => APP_URL."?page=orders"
					),
					"prod-view" => array(
						"title" => "Products View",
						"url" => APP_URL."?page=products-view"
					),
					"prod-detail" => array(
						"title" => "Products Detail",
						"url" => APP_URL."?page=products-detail"
					)
				)
			),
			"misc" => array(
				"title" => "Miscellaneous",
				"icon" => "fa-windows",
				"sub" => array(
					"pricing_tables" => array(
						"title" => "Pricing Tables",
						"url" => APP_URL."?page=pricing-table"
					),
					"invoice" => array(
						"title" => "Invoice",
						"url" => APP_URL."?page=invoice"
					),
					"login" => array(
						"title" => "Login",
						"url" => APP_URL."?page=login"
					),
					"register" => array(
						"title" => "Register",
						"url" => APP_URL."?page=register"
					),
					"forgot" => array(
						"title" => "Forgot Password",
						"url" => APP_URL."?page=forgotpassword"
					),
					"lock" => array(
						"title" => "Locked Screen",
						"url" => APP_URL."?page=lock"
					),
					"err_404" => array(
						"title" => "Error 404",
						"url" => APP_URL."?page=error404"
					),
					"err_500" => array(
						"title" => "Error 500",
						"url" => APP_URL."?page=error500"
					),
					"blank" => array(
						"title" => "Blank Page",
						"url" => APP_URL."?page=blank_"
					)
				)
			),
			"smartchat" => array(
				"title" => "Smart Chat API <sup>beta</sup>",
				"icon" => "fa fa-lg fa-fw fa-comment-o",
				"icon_badge" => array(
					'content' => '!',
					'class' => 'bg-color-pink flash animated'
				),
				"li_class" => array("chat-users", "top-menu-invisible"),
				"sub" => '
					<div class="display-users">
						<input class="form-control chat-user-filter" placeholder="Filter" type="text">
						
						<a href="#" class="usr" 
							data-chat-id="cha1" 
							data-chat-fname="Sadi" 
							data-chat-lname="Orlaf" 
							data-chat-status="busy" 
							data-chat-alertmsg="Sadi Orlaf is in a meeting. Please do not disturb!" 
							data-chat-alertshow="true" 
							data-rel="popover-hover" 
							data-placement="right" 
							data-html="true" 
							data-content="
								<div class=\'usr-card\'>
									<img src=\'img/avatars/5.png\' alt=\'Sadi Orlaf\'>
									<div class=\'usr-card-content\'>
										<h3>Sadi Orlaf</h3>
										<p>Marketing Executive</p>
									</div>
								</div>
							"> 
							<i></i>Sadi Orlaf
						</a>
					
						<a href="#" class="usr" 
							data-chat-id="cha2" 
							data-chat-fname="Jessica" 
							data-chat-lname="Dolof" 
							data-chat-status="online" 
							data-chat-alertmsg="" 
							data-chat-alertshow="false" 
							data-rel="popover-hover" 
							data-placement="right" 
							data-html="true" 
							data-content="
								<div class=\'usr-card\'>
									<img src=\'img/avatars/1.png\' alt=\'Jessica Dolof\'>
									<div class=\'usr-card-content\'>
										<h3>Jessica Dolof</h3>
										<p>Sales Administrator</p>
									</div>
								</div>
							"> 
							<i></i>Jessica Dolof
						</a>
				
						<a href="#" class="usr" 
							data-chat-id="cha3" 
							data-chat-fname="Zekarburg" 
							data-chat-lname="Almandalie" 
							data-chat-status="online" 
							data-rel="popover-hover" 
							data-placement="right" 
							data-html="true" 
							data-content="
								<div class=\'usr-card\'>
									<img src=\'img/avatars/3.png\' alt=\'Zekarburg Almandalie\'>
									<div class=\'usr-card-content\'>
										<h3>Zekarburg Almandalie</h3>
										<p>Sales Admin</p>
									</div>
								</div>
							"> 
							<i></i>Zekarburg Almandalie
						</a>
						
						<a href="#" class="usr" 
							data-chat-id="cha4" 
							data-chat-fname="Barley" 
							data-chat-lname="Krazurkth" 
							data-chat-status="away" 
							data-rel="popover-hover" 
							data-placement="right" 
							data-html="true" 
							data-content="
								<div class=\'usr-card\'>
									<img src=\'img/avatars/4.png\' alt=\'Barley Krazurkth\'>
									<div class=\'usr-card-content\'>
										<h3>Barley Krazurkth</h3>
										<p>Sales Director</p>
									</div>
								</div>
							"> 
							<i></i>Barley Krazurkth
						</a>
					
						<a href="#" class="usr offline" 
							data-chat-id="cha5" 
							data-chat-fname="Farhana" 
							data-chat-lname="Amrin" 
							data-chat-status="incognito" 
							data-rel="popover-hover" 
							data-placement="right" 
							data-html="true" 
							data-content="
								<div class=\'usr-card\'>
									<img src=\'img/avatars/female.png\' alt=\'Farhana Amrin\'>
									<div class=\'usr-card-content\'>
										<h3>Farhana Amrin</h3>
										<p>Support Admin <small><i class=\'fa fa-music\'></i> Playing Beethoven Classics</small></p>
									</div>
								</div>
							"> 
							<i></i>Farhana Amrin (offline)
						</a>
				
						<a href="#" class="usr offline" 
							data-chat-id="cha6" 
							data-chat-fname="Lezley" 
							data-chat-lname="Jacob" 
							data-chat-status="incognito" 
							data-rel="popover-hover" 
							data-placement="right" 
							data-html="true" 
							data-content="
								<div class=\'usr-card\'>
									<img src=\'img/avatars/male.png\' alt=\'Lezley Jacob\'>
									<div class=\'usr-card-content\'>
										<h3>Lezley Jacob</h3>
										<p>Sales Director</p>
									</div>
								</div>
							"> 
							<i></i>Lezley Jacob (offline)
						</a>

						<a href="ajax/chat.php" class="btn btn-xs btn-default btn-block sa-chat-learnmore-btn">About the API</a>
					</div>'
			)
		)
	)
);

$page_nav_admin = array(
	"beranda" => array(
		"title" => "Beranda",
		"icon" => "fa-home",
		"url" => APP_URL
	),
	"profil" => array(
		"title" => "Profil Admin",
		"icon" => "fa-home",
		"url" => APP_URL."?page=profil-admin"
	),
	"kurikulum" => array(
		"title" => "Kurikulum",
		"icon" => "fa-credit-card",
		"sub" => array(
			"versikurikulum" => array(
				"title" => "Versi Kurikulum",
				"icon" => "fa-folder-open",
				"url" => APP_URL.'?page=kurikulum-versi-kur'
			),
			"pengumuman" => array(
				"title" => "Pengumuman",
				"icon" => "fa-bullhorn",
				"url" => APP_URL.'?page=kurikulum-pengumuman'
			),
			"kuncikbm" => array(
				"title" => "Kunci Data KBM",
				"icon" => "fa-key",
				"url" => APP_URL.'?page=kurikulum-kunci-kbm'
			),
			"perangkatujian" => array(
				"title" => "Perangkat Ujian",
				"icon" => "fa-address-book-o",
				"url" => APP_URL."?page=kurikulum-perangkat-ujian"
			),
			"dokumenguru" => array(
				"title" => "Dokumen Guru",
				"icon" => "fa-book",
				'sub' => array(
					"absensikelas" => array(
						"title" => "Absensi",
						"icon" => "fa-calendar",
						"url" => APP_URL."?page=kurikulum-dokguru-absensi-kelas"
					)
				)
			),
			"dokumensiswa" => array(
				"title" => "Dokumen Siswa",
				"icon" => "fa-book",
				'sub' => array(
					"cetakrapor" => array(
						"title" => "Cetak Rapor",
						"icon" => "fa-print",
						"url" => APP_URL."?page=kurikulum-doksiswa-cetak-rapor"
					),
					"transkrip" => array(
						'title' => 'Transkrip Nilai',
						'icon' => 'fa-drivers-license-o',
						"url" => APP_URL."?page=kurikulum-doksiswa-cetak-transkrip"
					)
				)			
			),
			"datakbm" => array(
				"title" => "Proses KBM",
				"icon" => "fa-book",
				'sub' => array(
					"perkelas" => array(
						"title" => "Per Kelas",
						"icon" => "fa-building",
						"url" => APP_URL."?page=kurikulum-datakbm-perkelas"
					),
					"perguru" => array(
						"title" => "Per Guru",
						"icon" => "fa-user",
						"url" => APP_URL."?page=kurikulum-datakbm-perguru"
					),
					"remedial" => array(
						"title" => "Remedial",
						"icon" => "fa-retweet",
						"url" => APP_URL."?page=kurikulum-remedial"
					)
				)			
			),
			"dapodik" => array(
				"title" => "Data Dapodik",
				"icon" => "fa-cubes",
				"url" => APP_URL.'?page=kurikulum-data-dapodik'
			)
		)
	),
    "about" => array(
		"title" => "About",
		"url" => APP_URL."/?page=about",
		"icon" => "fa-question-circle"
	)
);

$page_nav_guru = array(
	"beranda" => array(
		"title" => "Beranda",
		"icon" => "fa-home",
		"url" => APP_URL
	),
	"profil" => array(
		"title" => "Profil Guru",
		"icon" => "fa-home",
		"url" => APP_URL."?page=profil-guru"
	),
	"kbm" => array(
		"title" => "Proses KBM",
		"icon" => "fa-graduation-cap",
		"sub" => array(
			"datakbm" => array(
				"title" => "Data KBM",
				"icon" => "fa-briefcase",
				"url" => APP_URL."?page=gurumapel-data-kbm"
			),
			"kompetensidasar" => array(
				"title" => "Kompetensi Dasar",
				"icon" => "fa-list",
				"url" => APP_URL."?page=gurumapel-data-kikd"
			),
			"penilaian" => array(
				"title" => "Penilaian",
				"icon" => "fa-pencil-square-o",
				"url" => APP_URL."?page=gurumapel-data-penilaian"
			),
			"absensimapel" => array(
				"title" => "Absensi",
				"icon" => "fa-calendar",
				"url" => APP_URL."?page=gurumapel-data-absensi"
			),			
			"ajuanremed" => array(
				"title" => "Ajuan Remedial",
				"icon" => "fa-external-link",
				"url" => APP_URL."?page=gurumapel-ajuan-remedial"
			),			
			"arsipnilai" => array(
				"title" => "Arsip KBM & Nilai",
				"icon" => "fa-map-o",
				"url" => APP_URL."?page=gurumapel-arsip-nilai"
			)

		)
	),
    "about" => array(
		"title" => "About",
		"url" => APP_URL."/?page=about",
		"icon" => "fa-question-circle"
	)
);

$page_nav_walikelas = array(
	"beranda" => array(
		"title" => "Beranda",
		"icon" => "fa-home",
		"url" => APP_URL
	),
	"profil" => array(
		"title" => "Profil Wali Kelas",
		"icon" => "fa-home",
		"url" => APP_URL."?page=profil-walikelas"
	),	
	"walikelas" => array(
		"title" => "Wali Kelas",
		"icon" => "fa-address-book",
		"sub" => array(
			"datakelas" => array(
				"title" => "Data Kelas",
				"icon" => "fa-building-o",
				"url" => APP_URL."?page=walikelas-data-kelas"
			),
			"identsiswa" => array(
				"title" => "Identitas Siswa",
				"icon" => "fa-user-circle",
				"url" => APP_URL."?page=walikelas-ident-siswa"
			),
			"absensisiswa" => array(
				"title" => "Absensi Siswa",
				"icon" => "fa-calendar",
				"url" => APP_URL."?page=walikelas-absensi-siswa"
			),
			"eskul" => array(
				"title" => "Kegiatan Eskul",
				"icon" => "fa-futbol-o",
				"url" => APP_URL."?page=walikelas-kegiatan-eskul"
			),
			"prestasi" => array(
				"title" => "Prestasi Siswa",
				"icon" => "fa-trophy",
				"url" => APP_URL."?page=walikelas-prestasi-siswa"
			),
			"prakerin" => array(
				"title" => "Praktek Kerja",
				"icon" => "fa-institution",
				"url" => APP_URL."?page=walikelas-prakerin-siswa"
			),
			"catatan" => array(
				"title" => "Catatan Wali Kelas",
				"icon" => "fa-commenting",
				"url" => APP_URL."?page=walikelas-catatan-wk"
			),
			"peringkat" => array(
				"title" => "Peringkat Kelas",
				"icon" => "fa-list",
				"url" => APP_URL."?page=walikelas-peringkat-kelas"
			),
			"tidaknaik" => array(
				"title" => "Siswa Tidak Naik",
				"icon" => "fa-arrow-circle-down",
				"url" => APP_URL."?page=walikelas-tidak-naik"
			)
		)
	),
    "about" => array(
		"title" => "About",
		"url" => APP_URL."/?page=about",
		"icon" => "fa-question-circle"
	)
);

$page_nav_bpbk = array(
	"beranda" => array(
		"title" => "Beranda",
		"icon" => "fa-home",
		"url" => APP_URL
	),
	"profil" => array(
		"title" => "Profil BPBK",
		"icon" => "fa-home",
		"url" => APP_URL."?page=profil-bpbk"
	),
    "bpbk" => array(
		"title" => "BP / BK",
		"url" => APP_URL."?page=bpbk-sikap-leger",
		"icon" => "fa-user-plus"
	),
    "about" => array(
		"title" => "About",
		"url" => APP_URL."/?page=about",
		"icon" => "fa-question-circle"
	)
);

$page_nav_siswa = array(
	"beranda" => array(
		"title" => "Beranda",
		"icon" => "fa-home",
		"url" => APP_URL
	),
	"profil" => array(
		"title" => "Profil Siswa",
		"icon" => "fa-home",
		"url" => APP_URL."?page=profil-siswa"
	),
    "about" => array(
		"title" => "About",
		"url" => APP_URL."/?page=about",
		"icon" => "fa-question-circle"
	)
);

if ($_SESSION['SMART_MASTER']=="Master"){
	$page_nav = $page_nav_master;
}
else if ($_SESSION['SMART_ADMIN']=="Admin"){
	$page_nav = $page_nav_admin;
}
else if ($_SESSION['SMART_BPBK']=="BpBK"){
	$page_nav = $page_nav_bpbk;
}
else if ($_SESSION['SMART_GURU']=="Guru"){
	$page_nav = $page_nav_guru; 
} 
else if ($_SESSION['SMART_WALIKELAS']=="Wali Kelas"){
	$page_nav = $page_nav_walikelas; 
}
else if ($_SESSION['SMART_SISWA']=="Siswa"){
	$page_nav = $page_nav_siswa;
}

//configuration variables
$page_title = "";
$page_css = array();
$no_main_header = false; //set true for lock.php and login.php
$page_body_prop = array(); //optional properties for <body>
$page_html_prop = array(); //optional properties for <html>
?>