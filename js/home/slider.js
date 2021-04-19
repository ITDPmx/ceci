(function() {
	$(function() {
		var _$js_home_slider = null,
		_$js_home_slider_container = null,
		_$js_slide = null,
		_screenHeight = null,
		_$window = null;

		/**
		 * Init events for Home page (Slider)
		 */
		
		var _initSlider = function(){

			_$js_home_slider.on('init', function(){
				$(this).css("opacity", 1);
			});

			_$js_home_slider.slick({
				arrows:false,
				autoplay: true,
				autoplaySpeed: 6000,
				dots:true,
				infinite: false,
				slidesToScroll: 1,
				slidesToShow: 1
			});

		};

		/**
		 * Assign values to variables
		 */
		_$window = $(window);
		_screenHeight = $(window).height();
		
		_$js_home_slider_container = $('.js-home-slider-container');
		_$js_home_slider = $('.js-home-slider');
		_$js_slide = $('.js-slide');
		_$js_slide.css("height", _screenHeight+"px");
		
		/**
		 * Set height to slider, from device height
		 */
		_$window.on('resize', function(e){
			e.preventDefault();
			_screenHeight = $(window).height();

			_$js_home_slider_container.css("height", _screenHeight+"px");
			_$js_home_slider.css("height", _screenHeight+"px");
			_$js_slide.css("height", _screenHeight+"px");
		});

		_initSlider();
	});
})(jQuery);