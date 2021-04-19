(function() {

	var _this = null,
	_$window = null,
	_screenHeight = null,
	_$js_landing_section = null;
	_$js_signup_landing = null;
	
	 var initEvents = function(){
	 	var landing = initAnalytics();
	 	
	 	_$js_signup_landing.on('click', function(){
	 		landing.clickSignupLanding();
	 	});
	// 	_$js_landing_section = $(".js-landing-section");
	// 	_$window = $(window);
	// 	_screenHeight = $(window).innerHeight();

	// 	if (!isMobile.phone || !isMobile.tablet) {
	// 		_$js_landing_section.css("height", _screenHeight + "px");
	// 	}
	 };

	
	/*_$window.on('resize', function(e){
		console.log(e.target);
		_screenHeight = $(window).height();
		_$js_landing_section.css("height", _screenHeight + "px");
		//_$window.scrollTo(0, 0);
	})
	*/
	_$js_signup_landing = $('.js-signup-landing');

	initEvents();

})(jQuery);