$(document).ready(function() {

		// ==================================================SISWA
		var chart;
		var legend;

		// grafik Jenis Kelamin Guru

		var chart = AmCharts.makeChart( "grafik_jeniskelamin_guru", {
			"type": "pie",
			"theme": "light",
			"dataLoader": {
				"url": "pages/grafik_guru_jk.php",
				"format": "json"
			},
			"valueField": "jenkel",
			"titleField": "jk",
			"outlineAlpha": 0.4,
			"depth3D": 15,
			"balloonText": "[[title]]<br><span style=\'font-size:14px\'><b>[[value]]</b> ([[percents]]%)</span>",
			"angle": 60,
			"export": {
			"enabled": true
			}
		});
		
		// grafik Jenis Guru

		var chart = AmCharts.makeChart("grafik_jenis_guru", {
			"theme": "light",
			"type": "serial",
			"dataLoader": {
				"url": "pages/grafik_guru_jg.php",
				"format": "json"
			},
			"startDuration": 1,
			"graphs": [{
				"balloonText": "Jenis Guru [[category]] (Laki-laki): <b>[[value]]</b>",
				"fillAlphas": 0.9,
				"lineAlpha": 0.2,
				"title": "Laki-laki",
				"type": "column",
				"valueField": "Laki",
				"labelText": "[[value]]",
				"labelPosition": "top"
			}, {
				"balloonText": "Jenis Guru [[category]] (Perempuan): <b>[[value]]</b>",
				"fillAlphas": 0.9,
				"lineAlpha": 0.2,
				"title": "Perempuan",
				"type": "column",
				"valueField": "Prmpn",
				"labelText": "[[value]]",
				"labelPosition": "top"
			}, {
				"balloonText": "Jenis Guru [[category]] (Total): <b>[[value]]</b>",
				"fillAlphas": 0.9,
				"lineAlpha": 0.2,
				"title": "Total",
				"type": "column",
				"valueField": "jmlperjenis",
				"labelText": "[[value]]",
				"labelPosition": "top"
			}],
			"plotAreaFillAlphas": 0.1,
			"depth3D": 60,
			"angle": 30,
			"categoryField": "jenisguru",
			"categoryAxis": {
				"gridPosition": "start"
			},
			"export": {
				"enabled": true
			 }
		});

		// grafik Usis Guru
		var zu1=parseInt(document.dtjsongrafik.u1.value);
		var zu2=parseInt(document.dtjsongrafik.u2.value);
		var zu3=parseInt(document.dtjsongrafik.u3.value);
		var zu4=parseInt(document.dtjsongrafik.u4.value);
		var zu5=parseInt(document.dtjsongrafik.u5.value);


		var chart = AmCharts.makeChart("grafik_usia_guru", {
			"type": "pie",
			"theme": "light",
			"innerRadius": "20%",
			"gradientRatio": [-0.4, -0.4, -0.4, -0.4, -0.4, -0.4, 0, 0.1, 0.2, 0.1, 0, -0.2, -0.5],
			"dataProvider": [{
				"usiaptk": ">=20",
				"jmlusiaptk": zu1
			}, {
				"usiaptk": "21-30",
				"jmlusiaptk": zu2
			}, {
				"usiaptk": "31-40",
				"jmlusiaptk": zu3
			}, {
				"usiaptk": "41-50",
				"jmlusiaptk": zu4
			}, {
				"usiaptk": ">50",
				"jmlusiaptk": zu5
			}],
			"balloonText": "[[title]]<br><span style='font-size:14px'><b>[[jmlusiaptk]]</b> ([[percents]]%)</span>",
			"valueField": "jmlusiaptk",
			"titleField": "usiaptk",
			"balloon": {
				"drop": true,
				"adjustBorderColor": false,
				"color": "#FFFFFF",
				"fontSize": 16
			},
			"export": {
				"enabled": true
			}
		})

		// ==================================================SISWA

		var chart = AmCharts.makeChart( "grafik_jk_siswa", {
			"type": "pie",
			"theme": "light",
			"dataLoader": {
				"url": "pages/grafik_siswa_perjk.php",
				"format": "json"
			},
			"valueField": "jk",
			"titleField": "jenis_kelamin",
			"outlineAlpha": 0.4,
			"depth3D": 15,
			"balloonText": "[[title]]<br><span style=\'font-size:14px\'><b>[[value]]</b> ([[percents]]%)</span>",
			"angle": 60,
			"export": {
			"enabled": true
			}
		});
		

		var chartPD;

		// grafik Jenis Kelamin Siswa
		/*
		var xlk=parseInt(document.dtjsongrafik.lk.value);
		var xpr=parseInt(document.dtjsongrafik.pr.value);

		var chartJKSis = [
			{
				"jenkelsis": "L",
				"jmljk": xlk
			},
			{
				"jenkelsis": "P",
				"jmljk": xpr
			}
		];
		AmCharts.ready(function () {
			chartPD = new AmCharts.AmPieChart();
			chartPD.dataProvider = chartJKSis;
			chartPD.titleField = "jenkelsis";
			chartPD.valueField = "jmljk";
			chartPD.outlineColor = "#FFFFFF";
			chartPD.outlineAlpha = 0.8;
			chartPD.outlineThickness = 2;
			chartPD.balloonText = "[[title]]<br><span style='font-size:14px'><b>[[jmljk]]</b> ([[percents]]%)</span>";
			chartPD.depth3D = 15;
			chartPD.angle = 60;
			chartPD.write("grafik_jeniskelamin_siswa");
		});
*/
		// grafik Usia Siswa
		var xus1=parseInt(document.dtjsongrafik.usis1.value);
		var xus2=parseInt(document.dtjsongrafik.usis2.value);
		var xus3=parseInt(document.dtjsongrafik.usis3.value);
		var xus4=parseInt(document.dtjsongrafik.usis4.value);
		var xus5=parseInt(document.dtjsongrafik.usis5.value);
		var xus6=parseInt(document.dtjsongrafik.usis6.value);
		var xus7=parseInt(document.dtjsongrafik.usis7.value);

		var chartUPD = [
			{
				"usiapd": ">=10",
				"jmlusiapd": xus1
			},
			{
				"usiapd": "10-11",
				"jmlusiapd": xus2
			},
			{
				"usiapd": "12-13",
				"jmlusiapd": xus3
			},
			{
				"usiapd": "14-15",
				"jmlusiapd": xus4
			},
			{
				"usiapd": "16-17",
				"jmlusiapd": xus5
			},
			{
				"usiapd": "18-19",
				"jmlusiapd": xus6
			},
			{
				"usiapd": ">19",
				"jmlusiapd": xus7
			}
		];
		AmCharts.ready(function () {
			chartPD = new AmCharts.AmPieChart();
			chartPD.dataProvider = chartUPD;
			chartPD.titleField = "usiapd";
			chartPD.valueField = "jmlusiapd";
			chartPD.sequencedAnimation = true;
			chartPD.startEffect = "elastic";
			chartPD.innerRadius = "30%";
			chartPD.startDuration = 2;
			chartPD.labelRadius = 15;
			chartPD.balloonText = "[[title]]<br><span style='font-size:14px'><b>[[jmlusiapd]]</b> ([[percents]]%)</span>";
			chartPD.depth3D = 10;
			chartPD.angle = 15;
			chartPD.write("grafik_usia_siswa");
		});

		// grafik Siswa tingkat
		var chart = AmCharts.makeChart("grafik_tingkat_siswa", {
			"theme": "light",
			"type": "serial",
			"startDuration": 2,
			"dataLoader": {
				"url": "pages/grafik_siswa_pertingkat.php",
				"format": "json"
			},
			"valueAxes": [{
				"position": "left",
				"axisAlpha":0,
				"gridAlpha":0
			}],
			"graphs": [{
				"balloonText": "[[category]] [[title]] : <b>[[value]]</b>",
				"colorField": "color",
				"fillAlphas": 0.85,
				"lineAlpha": 0.1,
				"type": "column",
				"topRadius":1,
				"title": "Laki-laki",
				"valueField": "Laki"
			},{
				"balloonText": "[[category]] [[title]] : <b>[[value]]</b>",
				"colorField": "color",
				"fillAlphas": 0.85,
				"lineAlpha": 0.1,
				"type": "column",
				"topRadius":1,
				"title": "Perempuan",
				"valueField": "Prmpn"
			}],
			"depth3D": 40,
			"angle": 30,
			"chartCursor": {
				"categoryBalloonEnabled": false,
				"cursorAlpha": 0,
				"zoomable": false
			},
			"categoryField": "tk",
			"categoryAxis": {
				"gridPosition": "start",
				"axisAlpha":0,
				"gridAlpha":0

			},
			"export": {
				"enabled": true
			 }

		}, 0);


		// grafik Siswa paket keahlian

             AmCharts.makeChart("grafik_pk_siswa", {
                type: "serial",
                theme: "light",
                "dataLoader": {
				"url": "pages/grafik_siswa_perpk.php",
				"format": "json"
				},
                categoryField: "kode_pk",
                startDuration: 1,
                rotate: true,

                categoryAxis: {
                    gridPosition: "start"
                },
                graphs: [{
                    type: "column",
                    title: "Total",
                    valueField: "jmljkpk",
					fillColors: "#ffcc00",
					fillAlphas: 0.9,
					lineColor: "#fff",
					lineAlpha: 0.7,
                    balloonText: "<span style='font-size:13px;'>[[title]] in [[category]]:<b>[[value]]</b></span>"
                },{
                    type: "line",
                    title: "Laki-Laki",
                    valueField: "Laki",
					bulletBorderAlpha: 1,
					bulletColor: "red",
					bulletSize: 5,
					hideBulletsCount: 50,
					lineThickness: 2,
					lineColor: "#f38b8b",
                    bullet: "round",
                    balloonText: "<span style='font-size:13px;'>[[title]] in [[category]]:<b>[[value]]</b></span>"
                },{
                    type: "line",
                    title: "Perempuan",
                    valueField: "Prmpn",
					bulletBorderAlpha: 1,
					bulletColor: "blue",
					bulletSize: 5,
					hideBulletsCount: 50,
					lineThickness: 2,
					lineColor: "#8ac6f2",
                    bullet: "round",
                    balloonText: "<span style='font-size:13px;'>[[title]] in [[category]]:<b>[[value]]</b></span>"
                }],
                legend: {
                    useGraphSettings: true
                },

                creditsPosition:"top-right"

            });

		// grafik Siswa PerKelas

             AmCharts.makeChart("grafik_perkelas_siswa", {
                type: "serial",
                theme: "light",
                "dataLoader": {
				"url": "pages/grafik_siswa_perkelas.php",
				"format": "json"
				},
                categoryField: "nm_kelas",
                startDuration: 1,
                rotate: true,

                categoryAxis: {
                    gridPosition: "start"
                },
                graphs: [{
                    type: "column",
                    title: "Kelas",
                    valueField: "jmlkls",
					fillColors: "#1ac4b3",
					fillAlphas: 0.9,
					lineColor: "#fff",
					lineAlpha: 0.7,
                    balloonText: "<span style='font-size:13px;'>[[title]] in [[category]]:<b>[[value]]</b></span>"
                },{
                    type: "line",
                    title: "Laki-Laki",
                    valueField: "Laki",
					bulletBorderAlpha: 1,
					bulletColor: "red",
					bulletSize: 5,
					hideBulletsCount: 50,
					lineThickness: 2,
					lineColor: "#f38b8b",
                    bullet: "round",
                    balloonText: "<span style='font-size:13px;'>[[title]] in [[category]]:<b>[[value]]</b></span>"
                },{
                    type: "line",
                    title: "Perempuan",
                    valueField: "Prmpn",
					bulletBorderAlpha: 1,
					bulletColor: "blue",
					bulletSize: 5,
					hideBulletsCount: 50,
					lineThickness: 2,
					lineColor: "#8ac6f2",
                    bullet: "round",
                    balloonText: "<span style='font-size:13px;'>[[title]] in [[category]]:<b>[[value]]</b></span>"
                }],
                legend: {
                    useGraphSettings: true
                },

                creditsPosition:"top-right"

            });


		// grafik Absensi
             AmCharts.makeChart("grafik_absensi", {
                type: "serial",
                theme: "light",
                "dataLoader": {
				"url": "pages/grafik_absensi.php",
				"format": "json"
				},
                categoryField: "nama_kelas",
                startDuration: 1,
                rotate: true,

                categoryAxis: {
                    gridPosition: "start"
                },
                valueAxes: [{
                    position: "top",
                    title: "Jumlah Absensi Per Kelas",
                    minorGridEnabled: true
                }],
                graphs: [{
                    type: "column",
                    title: "Kelas",
                    valueField: "jabsenkls",
					fillColors: "#cc3300",
					fillAlphas: 0.9,
					lineColor: "#fff",
					lineAlpha: 0.7,
                    balloonText: "<span style='font-size:13px;'>[[title]] in [[category]]:<b>[[value]]</b></span>"
                },{
                    type: "line",
                    title: "Sakit",
                    valueField: "Sakit",
					bulletBorderAlpha: 1,
					bulletColor: "yellow",
					bulletSize: 5,
					hideBulletsCount: 50,
					lineThickness: 2,
					lineColor: "#0000ff",
                    bullet: "round",
                    balloonText: "<span style='font-size:13px;'>[[title]] in [[category]]:<b>[[value]]</b></span>"
                },{
                    type: "line",
                    title: "Izin",
                    valueField: "Izin",
					bulletBorderAlpha: 1,
					bulletColor: "yellow",
					bulletSize: 5,
					hideBulletsCount: 50,
					lineThickness: 2,
					lineColor: "#0000ff",
                    bullet: "round",
                    balloonText: "<span style='font-size:13px;'>[[title]] in [[category]]:<b>[[value]]</b></span>"
                },{
                    type: "line",
                    title: "Alfa",
                    valueField: "Alfa",
					bulletBorderAlpha: 1,
					bulletColor: "yellow",
					bulletSize: 5,
					hideBulletsCount: 50,
					lineThickness: 2,
					lineColor: "#0000ff",
                    bullet: "round",
                    balloonText: "<span style='font-size:13px;'>[[title]] in [[category]]:<b>[[value]]</b></span>"
                }],
                legend: {
                    useGraphSettings: true
                },

                creditsPosition:"top-right"

            });


		// grafik UTSUAS
             AmCharts.makeChart("grafik_utsuas", {
                type: "serial",
                theme: "light",
                "dataLoader": {
				"url": "pages/grafik_nilai_utsuas.php",
				"format": "json"
				},
                categoryField: "kd_kelas",
                startDuration: 1,
                rotate: true,

                categoryAxis: {
                    gridPosition: "start"
                },
                valueAxes: [{
                    position: "top",
                    title: "Rata-Rata Nilai UTS dan UAS Per Kelas",
                    minorGridEnabled: true
                }],
                graphs: [{
                    type: "line",
                    title: "UTS",
                    valueField: "n_uts",
					bulletBorderAlpha: 1,
					bulletColor: "black",
					bulletSize: 5,
					hideBulletsCount: 50,
					lineThickness: 2,
					lineColor: "blue",
                    bullet: "round",
                    balloonText: "<span style='font-size:13px;'>[[title]] in [[category]]:<b>[[value]]</b></span>"
                },{
                    type: "line",
                    title: "UAS",
                    valueField: "n_uas",
					bulletBorderAlpha: 1,
					bulletColor: "black",
					bulletSize: 5,
					hideBulletsCount: 50,
					lineThickness: 2,
					lineColor: "red",
                    bullet: "round",
                    balloonText: "<span style='font-size:13px;'>[[title]] in [[category]]:<b>[[value]]</b></span>"
                }],
                legend: {
                    useGraphSettings: true
                },

                creditsPosition:"top-right"

            });

		// grafik Pengetahuan
             AmCharts.makeChart("grafik_pengetahuan", {
                type: "serial",
                theme: "light",
                "dataLoader": {
				"url": "pages/grafik_nilai_kikd_p.php",
				"format": "json"
				},
                categoryField: "kd_kelas",
                startDuration: 1,
                rotate: true,

                categoryAxis: {
                    gridPosition: "start"
                },
                valueAxes: [{
                    position: "top",
                    title: "Rata-Rata Nilai KIKD Pengetahuan Per Kelas",
                    minorGridEnabled: true
                }],
                graphs: [{
                    type: "line",
                    title: "KIKD Pengetahuan",
                    valueField: "npkikd",
					bulletBorderAlpha: 1,
					bulletColor: "black",
					bulletSize: 5,
					hideBulletsCount: 50,
					lineThickness: 2,
					lineColor: "red",
                    bullet: "round",
                    balloonText: "<span style='font-size:13px;'>[[title]] in [[category]]:<b>[[value]]</b></span>"
                }],
                legend: {
                    useGraphSettings: true
                },

                creditsPosition:"top-right"

            });

		// grafik Keterampilan
             AmCharts.makeChart("grafik_keterampilan", {
                type: "serial",
                theme: "light",
                "dataLoader": {
				"url": "pages/grafik_nilai_kikd_k.php",
				"format": "json"
				},
                categoryField: "kd_kelas",
                startDuration: 1,
                rotate: true,

                categoryAxis: {
                    gridPosition: "start"
                },
                valueAxes: [{
                    position: "top",
                    title: "Rata-Rata Nilai KIKD Keterampilan Per Kelas",
                    minorGridEnabled: true
                }],
                graphs: [{
                    type: "line",
                    title: "KIKD Keterampilan",
                    valueField: "nkkikd",
					bulletBorderAlpha: 1,
					bulletColor: "black",
					bulletSize: 5,
					hideBulletsCount: 50,
					lineThickness: 2,
					lineColor: "blue",
                    bullet: "round",
                    balloonText: "<span style='font-size:13px;'>[[title]] in [[category]]:<b>[[value]]</b></span>"
                }],
                legend: {
                    useGraphSettings: true
                },

                creditsPosition:"top-right"

            });

		// grafik TOTAL NILAI
             AmCharts.makeChart("grafik_nilai_akhir", {
                type: "serial",
                theme: "light",
                "dataLoader": {
				"url": "pages/grafik_nilai_akhir.php",
				"format": "json"
				},
                categoryField: "Kelas",
                startDuration: 1,
                rotate: true,

                categoryAxis: {
                    gridPosition: "start"
                },
                valueAxes: [{
                    position: "top",
                    title: "Rata-Rata Nilai Akhir Per Kelas",
                    minorGridEnabled: true
                }],
                graphs: [{
                    type: "line",
                    title: "Nilai Pengetahuan",
                    valueField: "NAPeng",
					bulletBorderAlpha: 1,
					bulletColor: "black",
					bulletSize: 5,
					hideBulletsCount: 50,
					lineThickness: 2,
					lineColor: "blue",
                    bullet: "round",
                    balloonText: "<span style='font-size:13px;'>[[title]] in [[category]]:<b>[[value]]</b></span>"
                },{
                    type: "line",
                    title: "Nilai Keterampilan",
                    valueField: "NAKet",
					bulletBorderAlpha: 1,
					bulletColor: "black",
					bulletSize: 5,
					hideBulletsCount: 50,
					lineThickness: 2,
					lineColor: "red",
                    bullet: "round",
                    balloonText: "<span style='font-size:13px;'>[[title]] in [[category]]:<b>[[value]]</b></span>"
                },{
                    type: "line",
                    title: "Nilai Akhir",
                    valueField: "NAkhir",
					bulletBorderAlpha: 1,
					bulletColor: "black",
					bulletSize: 5,
					hideBulletsCount: 50,
					lineThickness: 2,
					lineColor: "yellow",
                    bullet: "round",
                    balloonText: "<span style='font-size:13px;'>[[title]] in [[category]]:<b>[[value]]</b></span>"
                }],
                legend: {
                    useGraphSettings: true
                },

                creditsPosition:"top-right"

            });

		// grafik Sosial
             AmCharts.makeChart("grafik_sosial", {
                type: "serial",
                theme: "light",
                "dataLoader": {
				"url": "pages/grafik_nilai_sosial.php",
				"format": "json"
				},
                categoryField: "kd_kelas",
                startDuration: 1,
                rotate: true,

                categoryAxis: {
                    gridPosition: "start"
                },
                valueAxes: [{
                    position: "top",
                    title: "Jumlah Nilai Sikap Sosial Per Kelas",
                    minorGridEnabled: true
                }],
                graphs: [{
                    type: "line",
                    title: "Nilai 4",
                    valueField: "nss4",
					bulletBorderAlpha: 1,
					bulletColor: "black",
					bulletSize: 5,
					hideBulletsCount: 50,
					lineThickness: 2,
					lineColor: "green",
                    bullet: "round",
                    balloonText: "<span style='font-size:13px;'>[[title]] in [[category]]:<b>[[value]]</b></span>"
                },{
                    type: "line",
                    title: "Nilai 3",
                    valueField: "nss3",
					bulletBorderAlpha: 1,
					bulletColor: "black",
					bulletSize: 5,
					hideBulletsCount: 50,
					lineThickness: 2,
					lineColor: "yellow",
                    bullet: "round",
                    balloonText: "<span style='font-size:13px;'>[[title]] in [[category]]:<b>[[value]]</b></span>"
                },{
                    type: "line",
                    title: "Nilai 2",
                    valueField: "nss2",
					bulletBorderAlpha: 1,
					bulletColor: "black",
					bulletSize: 5,
					hideBulletsCount: 50,
					lineThickness: 2,
					lineColor: "black",
                    bullet: "round",
                    balloonText: "<span style='font-size:13px;'>[[title]] in [[category]]:<b>[[value]]</b></span>"
                },{
                    type: "line",
                    title: "Nilai 1",
                    valueField: "nss1",
					bulletBorderAlpha: 1,
					bulletColor: "black",
					bulletSize: 5,
					hideBulletsCount: 50,
					lineThickness: 2,
					lineColor: "black",
                    bullet: "round",
                    balloonText: "<span style='font-size:13px;'>[[title]] in [[category]]:<b>[[value]]</b></span>"
                },{
                    type: "line",
                    title: "Nilai 0",
                    valueField: "nss0",
					bulletBorderAlpha: 1,
					bulletColor: "black",
					bulletSize: 5,
					hideBulletsCount: 50,
					lineThickness: 2,
					lineColor: "black",
                    bullet: "round",
                    balloonText: "<span style='font-size:13px;'>[[title]] in [[category]]:<b>[[value]]</b></span>"
                }],
                legend: {
                    useGraphSettings: true
                },

                creditsPosition:"top-right"

            });

		// grafik Spritual
             AmCharts.makeChart("grafik_spritual", {
                type: "serial",
                theme: "light",
                "dataLoader": {
				"url": "pages/grafik_nilai_spritual.php",
				"format": "json"
				},
                categoryField: "kd_kelas",
                startDuration: 1,
                rotate: true,

                categoryAxis: {
                    gridPosition: "start"
                },
                valueAxes: [{
                    position: "top",
                    title: "Jumlah Nilai Sikap Spritual Per Kelas",
                    minorGridEnabled: true
                }],
                graphs: [{
                    type: "line",
                    title: "Nilai 4",
                    valueField: "nsp4",
					bulletBorderAlpha: 1,
					bulletColor: "black",
					bulletSize: 5,
					hideBulletsCount: 50,
					lineThickness: 2,
					lineColor: "green",
                    bullet: "round",
                    balloonText: "<span style='font-size:13px;'>[[title]] in [[category]]:<b>[[value]]</b></span>"
                },{
                    type: "line",
                    title: "Nilai 3",
                    valueField: "nsp3",
					bulletBorderAlpha: 1,
					bulletColor: "black",
					bulletSize: 5,
					hideBulletsCount: 50,
					lineThickness: 2,
					lineColor: "yellow",
                    bullet: "round",
                    balloonText: "<span style='font-size:13px;'>[[title]] in [[category]]:<b>[[value]]</b></span>"
                },{
                    type: "line",
                    title: "Nilai 2",
                    valueField: "nsp2",
					bulletBorderAlpha: 1,
					bulletColor: "black",
					bulletSize: 5,
					hideBulletsCount: 50,
					lineThickness: 2,
					lineColor: "black",
                    bullet: "round",
                    balloonText: "<span style='font-size:13px;'>[[title]] in [[category]]:<b>[[value]]</b></span>"
                },{
                    type: "line",
                    title: "Nilai 1",
                    valueField: "nsp1",
					bulletBorderAlpha: 1,
					bulletColor: "black",
					bulletSize: 5,
					hideBulletsCount: 50,
					lineThickness: 2,
					lineColor: "black",
                    bullet: "round",
                    balloonText: "<span style='font-size:13px;'>[[title]] in [[category]]:<b>[[value]]</b></span>"
                },{
                    type: "line",
                    title: "Nilai 0",
                    valueField: "nsp0",
					bulletBorderAlpha: 1,
					bulletColor: "black",
					bulletSize: 5,
					hideBulletsCount: 50,
					lineThickness: 2,
					lineColor: "black",
                    bullet: "round",
                    balloonText: "<span style='font-size:13px;'>[[title]] in [[category]]:<b>[[value]]</b></span>"
                }],
                legend: {
                    useGraphSettings: true
                },

                creditsPosition:"top-right"

            });

		// grafik nilai pengetahuan per tahun ajaran

             AmCharts.makeChart("grafik_n_perta", {
                type: "serial",
                theme: "light",
                "dataLoader": {
				"url": "pages/grafik_nilai_ta.php",
				"format": "json"
				},
                categoryField: "TAjar",
                startDuration: 1,
                rotate: true,

                categoryAxis: {
                    gridPosition: "start"
                },
                valueAxes: [{
                    position: "top",
                    title: "Data Rata-rata Nilai Per Tahun Ajaran",
                    minorGridEnabled: true
                }],
                graphs: [{
                    type: "column",
                    title: "Nilai Akhir",
                    valueField: "NA",
					fillColors: "#cc3300",
					fillAlphas: 0.9,
					lineColor: "#fff",
					lineAlpha: 0.7,
                    balloonText: "<span style='font-size:13px;'>[[title]] <br>[[category]]:<br><b>[[value]]</b></span>"
                },{
                    type: "line",
                    title: "Nilai K3",
                    valueField: "NAP",
					bulletBorderAlpha: 1,
					bulletColor: "black",
					bulletSize: 5,
					hideBulletsCount: 50,
					lineThickness: 2,
					lineColor: "black",
                    bullet: "round",
                    balloonText: "<span style='font-size:13px;'>[[title]] in [[category]]:<b>[[value]]</b></span>"
                },{
                    type: "line",
                    title: "Nilai UTS",
                    valueField: "NUTS",
					bulletBorderAlpha: 1,
					bulletColor: "black",
					bulletSize: 5,
					hideBulletsCount: 50,
					lineThickness: 2,
					lineColor: "black",
                    bullet: "round",
                    balloonText: "<span style='font-size:13px;'>[[title]] in [[category]]:<b>[[value]]</b></span>"
                },{
                    type: "line",
                    title: "Nilai UAS",
                    valueField: "NUAS",
					bulletBorderAlpha: 1,
					bulletColor: "black",
					bulletSize: 5,
					hideBulletsCount: 50,
					lineThickness: 2,
					lineColor: "black",
                    bullet: "round",
                    balloonText: "<span style='font-size:13px;'>[[title]] in [[category]]:<b>[[value]]</b></span>"
                },{
                    type: "line",
                    title: "Nilai K4",
                    valueField: "NAK",
					bulletBorderAlpha: 1,
					bulletColor: "black",
					bulletSize: 5,
					hideBulletsCount: 50,
					lineThickness: 2,
					lineColor: "black",
                    bullet: "round",
                    balloonText: "<span style='font-size:13px;'>[[title]] in [[category]]:<b>[[value]]</b></span>"
                }],
                legend: {
                    useGraphSettings: true
                },

                creditsPosition:"top-right"

            });


			AmCharts.makeChart("grafik_n_perta_a", {
				"theme": "light",
				"type": "serial",
				"legend": {
					"useGraphSettings": true,
					"markerSize":12,
					"valueWidth":0,
					"verticalGap":0
				},
                "dataLoader": {
				"url": "pages/grafik_nilai_ta.php",
				"format": "json"
				},
				"valueAxes": [{
					"title": "Nilai"
				}],
				"graphs": [{
					"balloonText": "Pengetahuan [[category]]:[[value]]",
					"fillAlphas": 1,
					"lineAlpha": 0.2,
					"title": "Pengetahuan",
					"type": "column",
					"color": "#000000",
					"labelText": "[[title]] : [[value]]",
					"labelPosition": "middle",
					"valueField": "NAP"
				},{
					"balloonText": "UTS [[category]]:[[value]]",
					"fillAlphas": 1,
					"lineAlpha": 0.2,
					"title": "UTS",
					"type": "column",
					"color": "#000000",
					"labelText": "[[title]] : [[value]]",
					"labelPosition": "middle",
					"valueField": "NUTS"
				},{
					"balloonText": "UAS [[category]]:[[value]]",
					"fillAlphas": 1,
					"lineAlpha": 0.2,
					"title": "UAS",
					"type": "column",
					"color": "#000000",
					"labelText": "[[title]] : [[value]]",
					"labelPosition": "middle",
					"valueField": "NUAS"
				},{
					"balloonText": "Keterampilan [[category]]:[[value]]",
					"fillAlphas": 1,
					"lineAlpha": 0.2,
					"title": "Keterampilan",
					"type": "column",
					"color": "#000000",
					"labelText": "[[title]] : [[value]]",
					"labelPosition": "middle",
					"valueField": "NAK"
				},{
					"balloonText": "Nilai Akhir [[category]]:[[value]]",
					"fillAlphas": 1,
					"lineAlpha": 0.2,
					"title": "Nilai Akhir",
					"type": "column",
					"color": "#000000",
					"labelText": "[[title]] : [[value]]",
					"labelPosition": "middle",
					"valueField": "NA"
				}],
				"depth3D": 20,
				"angle": 30,
				"rotate": true,
				"categoryField": "TAjar",
				"categoryAxis": {
					"gridPosition": "start",
					"fillAlpha": 0.05,
					"position": "right"
				},
				"export": {
					"enabled": true
				 }
			});


})