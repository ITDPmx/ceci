(function() {

	var _$body_html = null;
	var _this = null;
	var _get_results = null;
	var logos = null;
	var _infraestructura = null;
	var _$js_infraestructura = null;
	var _infraestructuraName = null;
	var _$js_estado = null;
	var _$js_municipio = null;
	var _$js_input_preliminares = null;
	var _$js_input_pavimentos = null;
	var _$js_input_banquetas = null;
	var _$js_input_alcantarillado = null;
	var _$js_input_sen_obra = null;
	var _$js_input_sen_horizontal = null;
	var _$js_input_sen_vertical = null;
	var _$js_input_dispositivos = null;
	var _$js_input_mobiliario = null;
	var _$js_input_subtotal_obra = null;
	var _$js_subtotal = null;
	var _$js_input_proy_ejecutivo = null;
	var _$js_input_sup_obra = null;
	var _$js_input_impuesto_millar = null;
	var _$js_input_iva = null;
	var _$js_input_total = null;
	var _$js_kilometros = null;
	var _$js_arroyo = null;
	var _$js_carilles = null;
	var _$js_postes = null;
	var _$js_intersecciones = null;
	var _$js_inter_infra = null;
	var _$js_km_ampliacion = null;
	var _$js_mt_ampliacion = null;
	var _$js_inter_semaforizadas = null;
	var _$js_biciestacionamientos = null;
	var _$js_proy_ejecutivo = null;
	var _$js_sup_obra = null;
	var _$js_impuesto_millar = null;
	var _$js_both_text = null;
	var _porcentajeIngresos = null;
	var _porcentajeIngresos1000 = null;
	var _porcentajeEgresos = null;
	var _porcentajeEgresos1000 = null;
	var _inputData = null;
	var _chartDataEgresos = null;
	var _chartDataIngresos = null;
	var _chartEgrEst = null;
	var _$js_summary_csv = null;
	var _desglose = null;
	var _$js_summary_charts = null;
	var _place = null;
	var _$js_change_data = null;

	/**
	 * [initEvents Init click events]
	 */
	var initEvents = function(){
		var summary = initAnalytics();
		if (sessionStorage.getItem('result')) {
			_get_results = JSON.parse(sessionStorage.getItem('result'));
			_place = JSON.parse(sessionStorage.getItem('place'));
			_infraestructura = _resolveNameInfra(_get_results.results.options.infraestructura);

			if (_get_results.results.egresos.estatales !== false && _get_results.results.egresos.municipales !== false && _get_results.results.egresos.porcentajes !== false && _get_results.results.egresos.porcentajes1000 !== false) {
				_createChartEgresos(_get_results.results.egresos);
			}
			else {
				var chartResponse = [
					'<div class="container">',
						'<h3 class="color-gray">Comparativa</h3>',
						'<hr>',
						'<h3 class="color-gray align-center">No hay gráficas que mostrar</h3>',
					'</div>'
				].join('');
				_$js_summary_charts.empty().append(chartResponse);
			}
			
			
			if (_get_results.results.ingresos.estatales !== false && _get_results.results.ingresos.municipales !== false && _get_results.results.ingresos.porcentajes !== false && _get_results.results.ingresos.porcentajes1000 !== false) {
				_createChartIngresos(_get_results.results.ingresos);
			}
			else {
				var chartResponse = [
					'<div class="container">',
						'<h3 class="color-gray">Comparativa</h3>',
						'<hr>',
						'<h3 class="color-gray align-center">No hay gráficas que mostrar</h3>',
					'</div>'
				].join('');
				_$js_summary_charts.empty().append(chartResponse);
			}

			_desglose = _get_results.results.calculadora;
			
			if (_place.estado) {
				_$js_estado.empty().text(_place.estado);
			}
			
			if (_place.municipio !== "") {
				_$js_municipio.empty().text(_place.municipio);
			}

			
			_inputData(_get_results.results.options);
			_resumeCosts(_get_results.results.calculadora);
			_$js_infraestructura.empty().text(_infraestructura);
			_$js_summary_csv.removeAttr("href").attr("href", _get_results.results.csv_file);
		}
		else {
			window.location.href="/";
		}

		function _resolveNameInfra(name) {
			if (name === "CC") {
				return "Ciclovia por elemento de Confinamiento";
			}
			else if (name === "CCE"){
				return "Ciclovia por cordón de estacionamiento";
			}
			else if (name === "BB"){
				return "Carril compartido ciclista con transporte público";
			}
			else if (name === "CICA"){
				return "Ciclocarril";
			}
			else {
				return "Sin nombre";
			}
		}
		
		function _inputData(input) {
			_$js_kilometros.empty().text(input.A);
			_$js_arroyo.empty().text(input.B);
			_$js_carilles.empty().text(input.D);
			_$js_postes.empty().text(input.E);
			_$js_intersecciones.empty().text(input.F);
			_$js_inter_infra.empty().text(input.G);
			_$js_km_ampliacion.empty().text(input.H);
			_$js_mt_ampliacion.empty().text(input.I);
			_$js_inter_semaforizadas.empty().text(input.J);
			_$js_biciestacionamientos.empty().text(input.K);
			_$js_proy_ejecutivo.empty().text(input.L);
			_$js_sup_obra.empty().text(input.M);
			_$js_impuesto_millar.empty().text(input.N);
		}

		function _resumeCosts(cost) {
			_$js_input_preliminares.empty().text(numeral(cost.subtotal_preliminares).format('$0,0.00'));
			_$js_input_pavimentos.empty().text(numeral(cost.subtotal_pavimentos).format('$0,0.00'));
			_$js_input_banquetas.empty().text(numeral(cost.subtotal_banquetas_guarniciones).format('$0,0.00'));
			_$js_input_alcantarillado.empty().text(numeral(cost.subtotal_alcantarillado).format('$0,0.00'));
			_$js_input_sen_obra.empty().text(numeral(cost.subtotal_senalizacion_obra).format('$0,0.00'));
			_$js_input_sen_horizontal.empty().text(numeral(cost.subtotal_senalizacion_horizontal).format('$0,0.00'));
			_$js_input_sen_vertical.empty().text(numeral(cost.subtotal_senalizacion_vertical).format('$0,0.00'));
			_$js_input_dispositivos.empty().text(numeral(cost.subtotal_dispositivos_transito).format('$0,0.00'));
			_$js_input_mobiliario.empty().text(numeral(cost.subtotal_mobiliario).format('$0,0.00'));
			_$js_input_subtotal_obra.empty().text(numeral(cost.subtotal_acumulado).format('$0,0.00'));
			_$js_subtotal.empty().text(numeral(cost.total).format('$0,0.00'));
			_$js_input_proy_ejecutivo.empty().text(numeral(cost.proyecto_ejecutivo).format('$0,0.00'));
			_$js_input_sup_obra.empty().text(numeral(cost.costo_supervision).format('$0,0.00'));
			_$js_input_impuesto_millar.empty().text(numeral(cost.impuesto_al_millar).format('$0,0.00'));
			_$js_input_iva.empty().text(numeral(cost.iva).format('$0,0.00'));
			_$js_input_total.empty().text(numeral(cost.gran_total).format('$0,0.00'));
		}
		
		function _createChartEgresos(items) {
			_porcentajeEgresos = items.porcentajes;
			_porcentajeEgresos1000 = items.porcentajes1000;

			delete _porcentajeEgresos.cveestado;
			delete _porcentajeEgresos.nomestado;
			delete _porcentajeEgresos1000.cveestado;
			delete _porcentajeEgresos1000.nomestado;

			_chartEgrEst = AmCharts.makeChart("Egresos", {
				"type": "serial",
				"theme": "light",
				'rotate': true,
				"legend": {
						"autoMargins": false,
						"fontSize": 16,
						"borderAlpha": 0.2,
						"equalWidths": true,
						"horizontalGap": 10,
						"marginBottom": 20,
						"marginTop": 40,
						"markerSize": 10,
						"useGraphSettings": true,
						"valueAlign": "left",
						"valueWidth": 0
				},
				"colors":["#5D5D5D","#838383","#A8A8A8","#49337A","#614E8D", "#7A6A9E", "#3C9233", "#5DA955", "#7EBD77", "#B2773F", "#CE9A68", "#E7BB92"],
				"dataProvider": [
					{
						"titulo": "Egresos Promedio",
						"em4": _porcentajeEgresos.em4,
						"em7": _porcentajeEgresos.em7,
						"em10": _porcentajeEgresos.em10,
						"em13": _porcentajeEgresos.em13,
						"em16": _porcentajeEgresos.em16,
						"em19": _porcentajeEgresos.em19,
						"em22": _porcentajeEgresos.em22,
						"em25": _porcentajeEgresos.em25,
						"em28": _porcentajeEgresos.em28,
						"em31": _porcentajeEgresos.em31
					},
					{
						"titulo": "Egresos cada 1000 hab.",
						"em4": _porcentajeEgresos1000.em5,
						"em7": _porcentajeEgresos1000.em8,
						"em10": _porcentajeEgresos1000.em11,
						"em13": _porcentajeEgresos1000.em14,
						"em16": _porcentajeEgresos1000.em17,
						"em19": _porcentajeEgresos1000.em20,
						"em22": _porcentajeEgresos1000.em23,
						"em25": _porcentajeEgresos1000.em26,
						"em28": _porcentajeEgresos1000.em29,
						"em31": _porcentajeEgresos1000.em32
				}],
				"valueAxes": [{
					"id": "ValueAxis-1",
					"position": "top",
					"axisAlpha": 0,
					"stackType": "100%",
					"gridAlpha": 0,
					"labelsEnabled": true,
					"title": "Egresos",
					"titleFontSize": 18,
					"gridThickness" : 5
				}],
				"graphs": [{
					"balloonText": "[[title]], [[category]]<br><span style='font-size:14px;'><b>([[percents]]%)</b></span>",
					"fillAlphas": 0.9,
					"fillColorsField": "color",
					"fontSize": 11,
					"labelText": "[[percents]]%",
					"lineAlpha": 0.5,
					"title": "Impuestos",
					"type": "column",
					"valueField": "em4"
				}, {
					"balloonText": "[[title]], [[category]]<br><span style='font-size:14px;'><b>([[percents]]%)</b></span>",
					"fillAlphas": 0.9,
					"fillColorsField": "#000000",
					"fontSize": 11,
					"labelText": "[[percents]]%",
					"lineAlpha": 0.5,
					"title": "Cuotas y Aportaciones de Seguridad Social",
					"type": "column",
					"valueField": "em7"
				}, {
					"balloonText": "[[title]], [[category]]<br><span style='font-size:14px;'><b>([[percents]]%)</b></span>",
					"fillAlphas": 0.9,
					"fillColorsField": "color",
					"fontSize": 11,
					"labelText": "[[percents]]%",
					"lineAlpha": 0.5,
					"title": "Contribuciones de Mejoras",
					"type": "column",
					"valueField": "em10"
				}, {
					"balloonText": "[[title]], [[category]]<br><span style='font-size:14px;'><b>([[percents]]%)</b></span>",
					"fillAlphas": 0.9,
					"fillColorsField": "color",
					"fontSize": 11,
					"labelText": "[[percents]]%",
					"lineAlpha": 0.5,
					"title": "Derechos",
					"type": "column",
					"valueField": "em13"
				}, {
					"balloonText": "[[title]], [[category]]<br><span style='font-size:14px;'><b>([[percents]]%)</b></span>",
					"fillAlphas": 0.9,
					"fillColorsField": "color",
					"fontSize": 11,
					"labelText": "[[percents]]%",
					"lineAlpha": 0.5,
					"title": "Productos",
					"type": "column",
					"valueField": "em16"
				}, {
					"balloonText": "[[title]], [[category]]<br><span style='font-size:14px;'><b>([[percents]]%)</b></span>",
					"fillAlphas": 0.9,
					"fillColorsField": "color",
					"fontSize": 11,
					"labelText": "[[percents]]%",
					"lineAlpha": 0.5,
					"title": "Aprovechamientos",
					"type": "column",
					"valueField": "em19"
				}, {
					"balloonText": "[[title]], [[category]]<br><span style='font-size:14px;'><b>([[percents]]%)</b></span>",
					"fillAlphas": 0.9,
					"fillColorsField": "color",
					"fontSize": 11,
					"labelText": "[[percents]]%",
					"lineAlpha": 0.5,
					"title": "Participaciones federales",
					"type": "column",
					"valueField": "em22"
				}, {
					"balloonText": "[[title]], [[category]]<br><span style='font-size:14px;'><b>([[percents]]%)</b></span>",
					"fillAlphas": 0.9,
					"fillColorsField": "color",
					"fontSize": 11,
					"labelText": "[[percents]]%",
					"lineAlpha": 0.5,
					"title": "Aportaciones federales y estatales",
					"type": "column",
					"valueField": "em25"
				}, {
					"balloonText": "[[title]], [[category]]<br><span style='font-size:14px;'><b>([[percents]]%)</b></span>",
					"fillAlphas": 0.9,
					"fillColorsField": "color",
					"fontSize": 11,
					"labelText": "[[percents]]%",
					"lineAlpha": 0.5,
					"title": "Otros ingresos",
					"type": "column",
					"valueField": "em28"
				}, {
					"balloonText": "[[title]], [[category]]<br><span style='font-size:14px;'><b>([[percents]]%)</b></span>",
					"fillAlphas": 0.9,
					"fillColorsField": "color",
					"fontSize": 11,
					"labelText": "[[percents]]%",
					"lineAlpha": 0.5,
					"title": "Financiamiento",
					"type": "column",
					"valueField": "em31"
				}],
				"marginTop": 30,
				"marginRight": 40,
				"marginLeft": 100,
				"marginBottom": 40,
				"autoMargins": false,
				"categoryField": "titulo",
				"categoryAxis": {
					"gridPosition": "start",
					"position": "left",
					"axisAlpha": 0,
					"gridAlpha": 0,
					"ignoreAxisWidth": true,
					"autoWrap": true
				}
			});
		}
		
		function _createChartIngresos(items) {
			_porcentajeIngresos = items.porcentajes;
			_porcentajeIngresos1000 = items.porcentajes1000;
			delete _porcentajeIngresos.cveestado;
			delete _porcentajeIngresos.nomestado;
			delete _porcentajeIngresos1000.cveestado;
			delete _porcentajeIngresos1000.nomestado;

			_chartIngrEst = AmCharts.makeChart("Ingresos", {
				"type": "serial",
				"theme": "light",
				'rotate': true,
				"legend": {
						"autoMargins": false,
						"fontSize": 16,
						"borderAlpha": 0.2,
						"equalWidths": true,
						"horizontalGap": 10,
						"markerSize": 10,
						"marginBottom": 20,
						"marginTop": 40,
						"useGraphSettings": true,
						"valueAlign": "left",
						"valueWidth": 0
				},
				"colors":["#5D5D5D","#838383","#A8A8A8","#49337A","#614E8D", "#7A6A9E", "#3C9233", "#5DA955", "#7EBD77", "#B2773F", "#CE9A68", "#E7BB92"],
				"dataProvider": [{
						"titulo": "Ingresos Promedio",
						"im5": _porcentajeIngresos.im5,
						"im8": _porcentajeIngresos.im8,
						"im11": _porcentajeIngresos.im11,
						"im14": _porcentajeIngresos.im14,
						"im17": _porcentajeIngresos.im17,
						"im20": _porcentajeIngresos.im20,
						"im23": _porcentajeIngresos.im23,
						"im26": _porcentajeIngresos.im26,
						"im29": _porcentajeIngresos.im29,
						"im32": _porcentajeIngresos.im32,
						"im35": _porcentajeIngresos.im35
					}, {
						"titulo": "Ingresos cada 1000 hab.",
						"im5": _porcentajeIngresos1000.im6,
						"im8": _porcentajeIngresos1000.im9,
						"im11": _porcentajeIngresos1000.im12,
						"im14": _porcentajeIngresos1000.im15,
						"im17": _porcentajeIngresos1000.im18,
						"im20": _porcentajeIngresos1000.im21,
						"im23": _porcentajeIngresos1000.im24,
						"im26": _porcentajeIngresos1000.im27,
						"im29": _porcentajeIngresos1000.im30,
						"im32": _porcentajeIngresos1000.im33,
						"im35": _porcentajeIngresos1000.im36
				}],
				"valueAxes": [{
					"id": "ValueAxis-1",
					"position": "top",
					"axisAlpha": 0,
					"stackType": "100%",
					"gridAlpha": 0,
					"labelsEnabled": true,
					"title": "Ingresos",
					"titleFontSize": 18,
					"gridThickness" : 5
				}],
				"graphs": [{
					"balloonText": "[[title]], [[category]]<br><span style='font-size:14px;'><b>([[percents]]%)</b></span>",
					"fillAlphas": 0.9,
					"fillColorsField": "color",
					"fontSize": 11,
					"labelText": "[[percents]]%",
					"lineAlpha": 0.5,
					"title": "Impuestos",
					"type": "column",
					"valueField": "im5"
				}, {
					"balloonText": "[[title]], [[category]]<br><span style='font-size:14px;'><b>([[percents]]%)</b></span>",
					"fillAlphas": 0.9,
					"fillColorsField": "color",
					"fontSize": 11,
					"labelText": "[[percents]]%",
					"lineAlpha": 0.5,
					"title": "Cuotas y Aportaciones de Seguridad Social",
					"type": "column",
					"valueField": "im8"
				}, {
					"balloonText": "[[title]], [[category]]<br><span style='font-size:14px;'><b>([[percents]]%)</b></span>",
					"fillAlphas": 0.9,
					"fillColorsField": "color",
					"fontSize": 11,
					"labelText": "[[percents]]%",
					"lineAlpha": 0.5,
					"title": "Contribuciones de Mejoras",
					"type": "column",
					"valueField": "im11"
				}, {
					"balloonText": "[[title]], [[category]]<br><span style='font-size:14px;'><b>([[percents]]%)</b></span>",
					"fillAlphas": 0.9,
					"fillColorsField": "color",
					"fontSize": 11,
					"labelText": "[[percents]]%",
					"lineAlpha": 0.5,
					"title": "Derechos",
					"type": "column",
					"valueField": "im14"
				}, {
					"balloonText": "[[title]], [[category]]<br><span style='font-size:14px;'><b>([[percents]]%)</b></span>",
					"fillAlphas": 0.9,
					"fillColorsField": "color",
					"fontSize": 11,
					"labelText": "[[percents]]%",
					"lineAlpha": 0.5,
					"title": "Productos",
					"type": "column",
					"valueField": "im17"
				}, {
					"balloonText": "[[title]], [[category]]<br><span style='font-size:14px;'><b>([[percents]]%)</b></span>",
					"fillAlphas": 0.9,
					"fillColorsField": "color",
					"fontSize": 11,
					"labelText": "[[percents]]%",
					"lineAlpha": 0.5,
					"title": "Aprovechamientos",
					"type": "column",
					"valueField": "im20"
				}, {
					"balloonText": "[[title]], [[category]]<br><span style='font-size:14px;'><b>([[percents]]%)</b></span>",
					"fillAlphas": 0.9,
					"fillColorsField": "color",
					"fontSize": 11,
					"labelText": "[[percents]]%",
					"lineAlpha": 0.5,
					"title": "Participaciones federales",
					"type": "column",
					"valueField": "im23"
				}, {
					"balloonText": "[[title]], [[category]]<br><span style='font-size:14px;'><b>([[percents]]%)</b></span>",
					"fillAlphas": 0.9,
					"fillColorsField": "color",
					"fontSize": 11,
					"labelText": "[[percents]]%",
					"lineAlpha": 0.5,
					"title": "Aportaciones federales y estatales",
					"type": "column",
					"valueField": "im26"
				}, {
					"balloonText": "[[title]], [[category]]<br><span style='font-size:14px;'><b>([[percents]]%)</b></span>",
					"fillAlphas": 0.9,
					"fillColorsField": "color",
					"fontSize": 11,
					"labelText": "[[percents]]%",
					"lineAlpha": 0.5,
					"title": "Otros ingresos",
					"type": "column",
					"valueField": "im29"
				}, {
					"balloonText": "[[title]], [[category]]<br><span style='font-size:14px;'><b>([[percents]]%)</b></span>",
					"fillAlphas": 0.9,
					"fillColorsField": "color",
					"fontSize": 11,
					"labelText": "[[percents]]%",
					"lineAlpha": 0.5,
					"title": "Financiamiento",
					"type": "column",
					"valueField": "im32"
				}, {
					"balloonText": "[[title]], [[category]]<br><span style='font-size:14px;'><b>([[percents]]%)</b></span>",
					"fillAlphas": 0.9,
					"fillColorsField": "color",
					"fontSize": 11,
					"labelText": "[[percents]]%",
					"lineAlpha": 0.5,
					"title": "Disponibilidad inicial",
					"type": "column",
					"valueField": "im35"
				}],
				"marginTop": 30,
				"marginRight": 40,
				"marginLeft": 100,
				"marginBottom": 40,
				"autoMargins": false,
				"categoryField": "titulo",
				"categoryAxis": {
					"gridPosition": "start",
					"position": "left",
					"axisAlpha": 0,
					"gridAlpha": 0,
					"ignoreAxisWidth": true,
					"autoWrap": true
				}
			});
		}
		
		_$js_summary_csv.on('click', function(){
			summary.clickDownloadCsv();
		});
		
		_$js_change_data.on('click', function(){
			summary.clickChangeData();
		});

	};

	_$body_html = $("body, html");
	_$js_infraestructura = $('.js-infraestructura');
	_$js_estado = $('.js-estado');
	_$js_municipio = $('.js-municipio');
	_$js_input_preliminares = $('.js-input-preliminares');
	_$js_input_pavimentos = $('.js-input-pavimentos');
	_$js_input_banquetas = $('.js-input-banquetas');
	_$js_input_alcantarillado = $('.js-input-alcantarillado');
	_$js_input_sen_obra = $('.js-input-sen-obra');
	_$js_input_sen_horizontal = $('.js-input-sen-horizontal');
	_$js_input_sen_vertical = $('.js-input-sen-vertical');
	_$js_input_dispositivos = $('.js-input-dispositivos');
	_$js_input_mobiliario = $('.js-input-mobiliario');
	_$js_input_subtotal_obra = $('.js-input-subtotal-obra');
	_$js_input_proy_ejecutivo = $('.js-input-proy-ejecutivo');
	_$js_input_sup_obra = $('.js-input-sup-obra');
	_$js_input_impuesto_millar = $('.js-input-impuesto-millar');
	_$js_input_iva = $('.js-input-iva');
	_$js_input_total = $('.js-input-total');
	_$js_subtotal = $('.js-subtotal');
	_$js_kilometros = $('.js-kilometros');
	_$js_arroyo = $('.js-arroyo');
	_$js_carilles = $('.js-carilles');
	_$js_postes = $('.js-postes');
	_$js_intersecciones = $('.js-intersecciones');
	_$js_inter_infra = $('.js-inter-infra');
	_$js_km_ampliacion = $('.js-km-ampliacion');
	_$js_mt_ampliacion = $('.js-mt-ampliacion');
	_$js_inter_semaforizadas = $('.js-inter-semaforizadas');
	_$js_biciestacionamientos = $('.js-biciestacionamientos');
	_$js_proy_ejecutivo = $('.js-proy-ejecutivo');
	_$js_sup_obra = $('.js-sup-obra');
	_$js_impuesto_millar = $('.js-impuesto-millar');
	_$js_summary_csv = $('.js-summary-csv');
	_$js_summary_charts = $('.js-summary-charts');
	_$js_change_data = $('.js-change-data');

	initEvents();

})(jQuery);