(function() {

	var _current_url = null;
	var _$js_footer_logo = null;

	/**
	 * [initEvents Init click events]
	 */
	var initEvents = function(){

		var footer = initAnalytics();
		
		$('.js-author-slide').on('init', function(){
			$('.m-author').fadeIn('slow');
		});
		$('.js-author-slide').slick({
			dots: true,
		  infinite: true,
		  arrows: true,
		  autoplay: true,
		  fade:true,
		  autoplaySpeed: 5000,
		});

		_current_url = window.location.pathname;
		if (_current_url === "/calculadora") {
			$('.js-general-logos').css('opacity', 0).remove();
			$('.js-calculator-logos').css('opacity', 1).append();
		}
		else if(_current_url === "/login" || _current_url === "/recuperar-password"){
			$('.js-general-logos').css('opacity', 0).remove();
			$('.js-calculator-logos').css('opacity', 0).remove();
		}
		else {
			$('.js-general-logos').css('opacity', 1).append();
			$('.js-calculator-logos').css('opacity', 0).remove();
		}
		
		_$js_footer_logo.on('click', function(){
			var logoName = this.getAttribute('data-logo');
			footer.clickLogoFooter(logoName);
		});
		
	};

	_$js_footer_logo = $('.js-footer-logo');

	initEvents();

})(jQuery);
