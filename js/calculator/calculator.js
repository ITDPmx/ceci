(function() {

	var _$body_html = null;
	var _this = null;
	var _$js_tipo_ciclovia = null;
	var _previousProject = null;
	var _currentInfrastructure = null;
	var _typeProject = null;
	var _cicloviaId = null;
	var _imgProject = null;
	var _$js_selected_infra = null;
	var _$js_estado = null;
	var _$js_municipio = null;
	var _estadoSeleccionado = null;
	var _municipioSeleccionado = null;
	var _estado = null;
	var _municipio = null;
	var _estadoId = null;
	var _$js_costo = null;
	var _$js_calculator_form = null;
	var _$js_twitter = null;
	var xhr = null;
	var serialize = null;
	var obj1 = null;
	var _$js_novalid_form = null;
	var _place = {};
	var _result = null;

	/**
	 * [initEvents Init click events]
	 */
	var initEvents = function(){
		var getCost = initAnalytics();
		_result = JSON.parse(sessionStorage.getItem('result'));
		if (_result) {
			toggleFunction(_result.results.options.infraestructura);
			$('input[name="infraestructura"][value="'+_result.results.options.infraestructura+'"]').attr('checked', true);
			$('input[name="A"]').val(_result.results.options.A);
			$('input[name="B"]').val(_result.results.options.B);
			$('input[name="D"]').val(_result.results.options.D);
			$('input[name="E"]').val(_result.results.options.E);
			$('input[name="F"]').val(_result.results.options.F);
			$('input[name="G"]').val(_result.results.options.G);
			$('input[name="H"]').val(_result.results.options.H);
			$('input[name="I"]').val(_result.results.options.I);
			$('input[name="J"]').val(_result.results.options.J);
			$('input[name="K"]').val(_result.results.options.K);
			$('input[name="L"][value="'+_result.results.options.L+'"]').attr('checked', true);
			$('input[name="M"][value="'+_result.results.options.M+'"]').attr('checked', true);
			$('input[name="N"][value="'+_result.results.options.N+'"]').attr('checked', true);
		}

		_estadoSeleccionado = $("#estado").selectize({
			onChange: function(value) {
				_place.estado = this.$control[0].textContent;
				_place.estadoId = value;
				
				if (!sessionStorage.getItem('place')) {
					sessionStorage.setItem('place', JSON.stringify(_place));
				}
				
				//if (!value.length) return;
				_municipio.disable();
				_municipio.clearOptions();
				_municipio.load(function(callback) {
					xhr && xhr.abort();
					xhr = $.ajax({
						url: './assets/municipios/'+value+'.json',
						success: function(results) {
							_municipio.enable();
							callback(results);
						},
						error: function() {
							callback();
						}
					});
				});
			}
			
		});

		_municipioSeleccionado = $('#municipio').selectize({
			valueField: 'id',
			labelField: 'text',
			searchField: ['text'],
			onChange: function(value) {
				_place.municipio = this.$control[0].textContent;
				_place.municipioId = value;
				sessionStorage.setItem('place', JSON.stringify(_place));
			}
		});
		
		
		_estado = _estadoSeleccionado[0].selectize;
		_municipio = _municipioSeleccionado[0].selectize;
		
		if (sessionStorage.getItem('place')) {
			var id = JSON.parse(sessionStorage.getItem('place'));
			_estado.setValue(id.estadoId);
		}
		
		_municipio.disable();

		_$js_tipo_ciclovia.on('change', function(e){
			e.preventDefault();
			_this = this.getAttribute('value');
			previousProject = _imgProject;
			currentInfrastructure = $('#' + _this);

			if(previousProject){
				!currentInfrastructure ? [currentInfrastructure.removeClass('is-infra-active'), _$js_selected_infra.removeClass('is-infra-selected')] : [previousProject.removeClass('is-infra-active'), _$js_selected_infra.removeClass('is-infra-selected')];
			}

			typeProject = _this;
			toggleFunction(typeProject);
		});
		
		_$js_costo.on('click', function(e){
			e.preventDefault();
			if (_$js_calculator_form.parsley().validate()) {
				
				serialize = _$js_calculator_form.serializeObject();
				obj1 = {"C": "null"};
				function merge_options(obj1,serialize){
					var obj_final = {};
					for (var attrname in obj1) { obj_final[attrname] = obj1[attrname]; }
					for (var attrname in serialize) { obj_final[attrname] = serialize[attrname]; }
					return obj_final;
				}

				serialize = merge_options(obj1, serialize);
				serialize = JSON.stringify(serialize);

				_submitLogin(serialize);
			}
			else {
				setTimeout(function(){
					_$js_novalid_form.slideUp('slow');
				}, 3000);
				_$js_novalid_form.slideDown('slow');
			}
			getCost.clickGetCost();
			
		});
		
		

		function toggleFunction(typeProject){
			_imgProject = $('#'+ typeProject);
			_imgProject.addClass('is-infra-active');
			_imgProject.parent().parent().siblings().addClass('is-infra-selected');
			//sessionStorage.setItem('currentInfrastructure',_imgProject[0].id);
		}

		function _submitLogin (data) {
			var submitPromise = $.ajax({
				url: '/api/index.php/estimate',
				type: 'POST', 
				data : data,
				crossDomain: true
			});
			
			submitPromise.then(function(result){
				var resultPromise = JSON.stringify(result);
				sessionStorage.setItem('result', resultPromise);
				window.location.href = "/resumen";
			}, function(error){
				console.log(error);
			});
		}
		
		$.fn.serializeObject = function(){
		 var o = {};
		 var a = this.serializeArray();
		 $.each(a, function() {
			 if (o[this.name]) {
				if (!o[this.name].push) {
					o[this.name] = [o[this.name]];
				}
				o[this.name].push(this.value || '');
			 }
			 else {
					o[this.name] = this.value || '';
			 }
		 });
		 return o;
		};
		
		_$js_twitter.on('click', function(){
			_this = this.getAttribute('data-twitter');
			getCost.clickTwitterAuthor(_this);
		});
		
	};


	_$body_html = $("body, html");
	_$js_tipo_ciclovia = $(".js-tipo-ciclovia");
	_$js_selected_infra = $(".js-selected-infra");
	_$js_estado = $("#estado");
	_$js_municipio = $("#municipio");
	_$js_costo = $(".js-costo");
	_$js_calculator_form = $(".js-calculator-form");
	_$js_novalid_form = $(".js-novalid-form");
	_$js_twitter = $('.js-twitter');

	initEvents();

})(jQuery);