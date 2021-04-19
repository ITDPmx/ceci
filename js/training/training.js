(function() {

	var _$window = null,
	_$js_training_modality_selected = null,
	_$js_modality = null,
	_$js_description = null,
	_$js_poster_video = null,
	_$js_poster_welcome = null,
	_$js_video = null,
	_$js_bienvenida_video = null,
	_$js_mp4 = null,
	_$js_webm = null,
	_$js_ogv = null,
	_$js_bienvenida_mp4 = null,
	_$js_bienvenida_webm = null,
	_$js_bienvenida_ogv = null,
	_$js_guide = null,
	_$js_calculator = null,
	_$js_finance = null,
	_id_modality = null,
	_enabled_image = null,
	_disabled_image = null,
	_duration_video = null,
	_current_progress_video = null,
	_save_progress = null,
	_$js_test = null,
	_$js_intent_fail = null,
	_$js_intent_link = null,
	_$js_change_modality = null,
	_$js_content_modality = null,
	_$js_image_selected = null,
	_$js_ready_test = null,
	_$animation_element = null,
	_countIntents = null,
	_$js_intents = null,
	_id = null,
	_this = null,
	_played_flag = null,
	_$js_content_test = null,
	_$js_dashboard_user = null;

	/**
	 * Init events for Home page (Slider)
	 */
	
	var _initSlider = function(){
		var training = initAnalytics();
		
		function readCookie(name) {
			var nameEQ = name + "=";
			var ca = document.cookie.split(';');
			for(var i=0;i < ca.length;i++) {
				var c = ca[i];
				while (c.charAt(0) ===' ') c = c.substring(1,c.length);
				if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length,c.length);
			}
			return null;
		}
		

		_played_flag = readCookie('played');
		_$js_bienvenida_mp4.attr("src", "../assets/videos/bienvenida_emus.mp4");
		_$js_bienvenida_webm.attr("src", "./assets/videos/bienvenida_emus.webm");
		_$js_bienvenida_ogv.attr("src", "./assets/videos/bienvenida_emus.ogv");
		_$js_poster_welcome.attr("poster", "./assets/images/training/welcome_intro.jpg");
		loadWelcome();
		
		
		function loadWelcome() {
			if (!_played_flag) {
				_played_once = true;
				document.cookie = 'played = true';
				_$js_bienvenida_video[0].play();
			}
			else {
				_played_once = false;
				_$js_bienvenida_video[0].pause();
			}
		}

		_$window.on('scroll rezise', check_if_in_view);
		_$window.trigger('scroll');
		
		function check_if_in_view(){
			var window_height = _$window.height();
			var window_top_position = _$window.scrollTop();
			var window_bottom_position = (window_top_position + window_height);

			$.each(_$animation_element, function() {
				var $element = $(this);
				var element_height = $element.outerHeight();
				var element_top_position = $element.offset().top;
				var element_bottom_position = (element_top_position + element_height);

				//check to see if this current container is within viewport
				if ((element_bottom_position >= window_top_position) &&
						(element_top_position <= window_bottom_position)) {
						setTimeout(function(){
							$element.addClass('shake-to-view');
						}, 1500);
				}
			});
		}
		
		/**
		 * [Select modality]
		 */
		_$js_training_modality_selected.on('click', function(){
			_id = $(this).data().id;
			_id_modality = $(this).data().modality;
			_enabled_image = $(this).data().image;
			_this = $(this).context.children[0];
			_$js_image_selected.removeClass('is-modality-active');
			$(_this).addClass('is-modality-active');
			
			setTimeout(function(){
				$('body, html').animate({
					scrollTop: $('#training-modality-selected').offset().top -25
				}, 800);
			}, 100);
			
			/**
			 * [Disabled previous image modality]
			 */
			if ($(_this).has('selected') && $(_this).parent().data() !== undefined){
				$(_this).removeClass('selected');
				// _disabled_image = $(_this).parent().data().image;
				_$js_modality.removeClass(function (index, css){
					return (css.match (/\bcolor-\S+/g) || []).join(' ');
				});
				_$js_guide.removeClass(function (index, css){
					return (css.match (/\bcolor-\S+/g) || []).join(' ');
				});
				_$js_intent_link.removeClass(function (index, css){
					return (css.match (/\bcolor-\S+/g) || []).join(' ');
				});
				_$js_calculator.removeClass(function (index, css){
					return (css.match (/\bcolor-\S+/g) || []).join(' ');
				});
				_$js_ready_test.removeClass(function (index, css){
					return (css.match (/\bcolor-\S+/g) || []).join(' ');
				});
				_$js_finance.removeClass(function (index, css){
					return (css.match (/\bcolor-\S+/g) || []).join(' ');
				});
			}

			/**
			 * [Enabled current image modality]
			 */
			$(_this).addClass('selected');
			$(_this).attr("src", "./assets/images/emus/"+_enabled_image+".png");
			_$js_content_modality.css("opacity",0);

			/**
			 * [Check if test it's done]
			 */
			$.ajax({
				url: "/validateTest/"+ _id,
				method: "GET",
				cache: false,
				dataType: "json",
				contentType: "application/json"
			})
			.then(function(data){
				if (data.data) {
					if (data.data.calificacion >= 80) {
						_$js_ready_test.empty().html("<b>¡Felicidades!</b> <br> Has aprobado el test de esta modalidad");
						_$js_intent_link.removeAttr("href").css("display", "none");
					}
					else {
						_$js_ready_test.empty().text("¡Prueba tus conocimientos!");
						_$js_intent_link.css("display", "inline-block");
					}
					
				}
				else {
					_$js_ready_test.empty().text("¡Prueba tus conocimientos!");
					_$js_intent_link.css("display", "inline-block");
				}
			});

			/**
			 * [Get data from current modality]
			 */
			$.getJSON({
				url: "./assets/training/"+_id_modality+".json",
				method: "GET",
				cache: false,
				dataType: "json",
				contentType: "application/json",
			})
			.then(function (data){
				
				_videoProgress(data.id_video);
				_$js_content_modality.css("display","block").animate({"opacity":1}, 500);
				
				_$js_modality.html(data.modality).addClass(data.class);
				_$js_description.html(data.description);
				_$js_poster_video.attr("poster", data.video_foreground);
				_$js_video.attr("data-id", data.id_video);
				_$js_mp4.attr("src", data.video.mp4);
				_$js_webm.attr("src", data.video.webm);
				_$js_ogv.attr("src", data.video.ogv);
				_$js_guide.attr({
					"href": data.guide,
					"data-id": data.id_guide
				}).addClass(data.class);

				_$js_intent_link.attr("href", data.url_test).addClass(data.class);

				if(data.calculator === undefined || data.calculator === "") {
					_$js_calculator.css("display", "none");
					_$js_calculator.removeAttr("href");
				}
				else{
					_$js_calculator.css("display", "inline-block").attr("href", data.calculator).addClass(data.class);
				}
				_$js_finance.attr("href", data.finance).addClass(data.class);
				_$js_ready_test.addClass(data.class);
				
			});
			
			training.clickModalityTraining(_id_modality);
			
		});
		
		_$js_guide.on('click', function(e){
			_this = $(this).data().id;
			var guideName = $(this)[0].pathname.split('/assets/downloads/')[1].split('.pdf')[0];
			$.ajax({
				type: 'POST',
				url: "/home/contadorGuias",
				data :{
					'id_guia': _this
				}
			});
			training.clickDownloadModalityGuide(guideName);
			
		});
		var _videoProgress = function(id){
			_id_video = id;
			var currentProgress = setInterval(function(){
					_duration_video = _$js_video.find('video').get(0).duration;
					_current_progress_video = _$js_video.find('video').get(0).currentTime;
					_current_progress_video = Math.round( (_current_progress_video / _duration_video) * 100);
					if (_current_progress_video === 100) {
						_sendVideo(_id_video);
					}
				},500);
			
			var _sendVideo = function(id){
				clearInterval(currentProgress);
				$.ajax({
					type: 'POST',
					url:"/home/contadorVideos",
					data :{
						'id_video': id
					}
				});
			};
		};
		
		_$js_dashboard_user.on('click', function() {
			training.clickProfile();
		});
		
		_$js_intent_link.on('click', function(){
			var testName = $(this)[0].pathname.split('/cuestionario/')[1];
			training.clickModalityTest(testName);
		});
		

	};
	

	/**
	 * Assign values to variables
	 */
	_$window = $(window);
	_$js_training_modality_selected = $('.js-training-modality-selected');
	_$id_training_modality_selected = $('#training-modality-selected');
	_$js_modality = $('.js-modality');
	_$js_description = $('.js-description');
	_$js_poster_video = $('.js-poster-video');
	_$js_poster_welcome = $('.js-poster-welcome');
	_$js_video = $('.js-video');
	_$js_bienvenida_video = $('#bienvenida-video');
	_$js_mp4 = $('video#video:nth-child(1)');
	_$js_webm = $('video#video:nth-child(2)');
	_$js_ogv = $('video#video:nth-child(3)');
	_$js_bienvenida_mp4 = $('video#bienvenida-video:nth-child(1)');
	_$js_bienvenida_webm = $('video#bienvenida-video:nth-child(2)');
	_$js_bienvenida_ogv = $('video#bienvenida-video:nth-child(3)');
	_$js_guide = $('.js-guide');
	_$js_calculator = $('.js-calculator');
	_$js_finance = $('.js-finance');
	_$js_test = $('.js-test');
	_$js_intent_link = $('.js-intent-link');
	_$js_intent_fail = $('.js-intent-fail');
	_$js_change_modality = $('.js-change-modality');
	_$js_content_modality = $('.js-content-modality');
	_$js_image_selected = $('.js-image-selected');
	_$js_ready_test = $('.js-ready-test');
	_$js_intents = $('.js-intents');
	_$animation_element = $('.js-animation-element');
	_$js_content_test = $('.js-content-test');
	_$js_dashboard_user = $('.js-dashboard-user');

	_initSlider();

})(jQuery);