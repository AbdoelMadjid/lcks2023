$(document).ready(function() {

		// ==================================================SISWA
		var chart;
		var legend;

	
		// grafik Jenis Guru

		var chart = AmCharts.makeChart("grafik_pilihan_mpk", {
			"theme": "light",
			"type": "serial",
			"dataLoader": {
				"url": "pages/grafik_pilih_mpk.php",
				"format": "json"
			},
			"startDuration": 1,
			"graphs": [{
				"balloonText": "Paslon [[category]] (01): <b>[[value]]</b>",
				"fillAlphas": 0.9,
				"lineAlpha": 0.2,
				"title": "PASLON 01",
				"type": "column",
				"valueField": "Pil01",
				"labelText": "[[value]]",
				"labelPosition": "top"
			}, {
				"balloonText": "Paslon [[category]] (02): <b>[[value]]</b>",
				"fillAlphas": 0.9,
				"lineAlpha": 0.2,
				"title": "PASLON 02",
				"type": "column",
				"valueField": "Pil02",
				"labelText": "[[value]]",
				"labelPosition": "top"
			}, {
				"balloonText": "Palson [[category]] (03): <b>[[value]]</b>",
				"fillAlphas": 0.9,
				"lineAlpha": 0.2,
				"title": "PASLON 03",
				"type": "column",
				"valueField": "Pil03",
				"labelText": "[[value]]",
				"labelPosition": "top"
			}, {
				"balloonText": "ABSTAIN [[category]] (04): <b>[[value]]</b>",
				"fillAlphas": 0.9,
				"lineAlpha": 0.2,
				"title": "ABSTAIN",
				"type": "column",
				"valueField": "Pil04",
				"labelText": "[[value]]",
				"labelPosition": "top"
			}, {
				"balloonText": "TOTAL [[category]] (Suara): <b>[[value]]</b>",
				"fillAlphas": 0.9,
				"lineAlpha": 0.2,
				"title": "Total Suara",
				"type": "column",
				"valueField": "totsuara",
				"labelText": "[[value]]",
				"labelPosition": "top"
			}],
			"plotAreaFillAlphas": 0.1,
			"depth3D": 60,
			"angle": 30,
			"categoryField": "pilihan",
			"categoryAxis": {
				"gridPosition": "start"
			},
			"export": {
				"enabled": true
			 }
		});



})