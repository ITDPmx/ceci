
(function() {

	var _$body= null,
	_$js_recover = null,
	_$js_recover_form = null,
	_$js_recover_submit = null,
	_$js_recover_success = null,
	_$js_recover_error = null,
	_$js_recover_email_error = null,
	_recoverData = null;

	/**
	 * Init events for Home page (Slider)
	 */
	
	
	var _initEvents = function(){
		var recover = initAnalytics();
		/**
		 * If completed singup
		 */
		_$js_recover_submit.on('click', function(e) {
			e.preventDefault();
			if (_$js_recover_form.parsley().validate()) {
				_recoverData = _$js_recover_form.serialize();
				
				
				var promise = $.ajax({
					method: 'POST',
					data: _recoverData,
					url: "/recovery"
				});
				
				promise.then(function(data){
					if(data.success === true){
						_$js_recover.fadeOut(900);
						_$js_recover_success.fadeIn('slow', function(){
							_$body.animate({scrollTop: '0px'}, 700);
						});
					}
				}, function(error){
					if(error.responseJSON.error === "email"){
						_$js_recover_email_error.slideDown();
					}
					else {
						_$js_recover_error.slideDown();
					}
				});
			}
			recover.clickRecoverButton();
			
		});

	};

	/**
	 * Assign values to variables
	 */
	_$body = $('body, html');
	_$js_recover = $('.js-recover');
	_$js_recover_form = $('.js-recover-form');
	_$js_recover_submit = $('.js-recover-submit');
	_$js_recover_success = $('.js-recover-success');
	_$js_recover_error = $('.js-recover-error');
	_$js_recover_email_error = $('.js-recover-email-error');
	

	_initEvents();
})(jQuery);