(function() {

	var _$js_signup_success = null,
	_$body= null,
	_$js_signup_form = null,
	_$js_login_form = null,
	_$js_signup_submit = null,
	_$js_login_submit = null,
	_$js_signup= null,
	_$js_select_sector = null,
	_$js_dependency_field = null,
	_$js_dependency_name = null,
	_$js_login_error = null,
	_$js_signup_error = null,
	_$js_signup_email_error = null,
	_$js_recover_password = null,
	_selected_sector = null,
	_loginData = null,
	_signUpData = null;

	/**
	 * Init events for Home page (Slider)
	 */
	
	var _initEvents = function(){
		var login = initAnalytics();

		//_$body.animate({scrollTop: '0px'}, 700);

		_$js_select_sector.change(function(e){
			e.preventDefault();
			_selected_sector = $(this).val();
			if (_selected_sector !== "Gobierno Estatal") {
				_$js_dependency_field.slideDown('slow');
				_$js_dependency_name.attr('required', true);
				_$js_dependency_name.attr('placeholder', "Nombre de " + _selected_sector);
			}
			else {
				_$js_dependency_name.removeAttr('required');
				_$js_dependency_name.removeAttr('placeholder');
				_$js_dependency_field.slideUp('slow');
			}
		});

		/**
		 * If completed singup
		 */
		_$js_signup_submit.on('click', function(e) {
			e.preventDefault();
			if (_$js_signup_form.parsley().validate()) {
				_signupData = _$js_signup_form.serialize();
				
				var promise = $.ajax({
					method: 'POST',
					data: _signupData,
					url: "/home/add"
				});
				
				promise.done(function(data){
					if(data.success === true){
						_$js_signup.fadeOut(900);
						_$js_signup_success.fadeIn('slow', function(){
							_$body.animate({scrollTop: '0px'}, 700);
						});
					}
				});
				promise.fail(function(error){
					if(error.responseJSON.error === false){
						_$js_signup_error.slideDown();
					}
					if(error.responseJSON.error === "email"){
						_$js_signup_email_error.slideDown();
					}
				});
			}
			login.clickRegisterSignup();
			
		});
		
		
		_$js_login_submit.on('click', function(e) {
			e.preventDefault();
			if (_$js_login_form.parsley().validate()) {
				_loginData = _$js_login_form.serialize();
				
				var promise = $.ajax({
					method: 'POST',
					data: _loginData,
					url: "/home/loginUsuarios"
				});
				
				promise.done(function(data){
					if (data.code === 200) {
						if (sessionStorage.getItem('result')) {
							sessionStorage.removeItem('result');
						}
						
						if (sessionStorage.getItem('place')) {
							sessionStorage.removeItem('place');
						}
						
						if(data.role === "user"){
							window.location.href = "/capacitacion";
						}
						if(data.role === "admin"){
							window.location.href = "/dashboard";
						}
					}
				});
				
				promise.fail(function(fail){
					if(fail.responseJSON.code === 400) {
						_$js_login_error.slideDown();
						sessionStorage.removeItem('result');
					}
				});
			}
			login.clickLogin();
		});
		
		_$js_recover_password.on('click', function(e){
			login.clickRecoverLink();
		});

	};

	/**
	 * Assign values to variables
	 */
	_$body = $('body, html');
	_$js_signup_form = $('.js-signup-form');
	_$js_login_form = $('.js-login-form');
	_$js_signup_submit = $('.js-signup-submit');
	_$js_login_submit = $('.js-login-submit');
	_$js_signup = $('.js-signup');
	_$js_signup_success = $('.js-signup-success');
	_$js_select_sector = $('.js-select-sector');
	_$js_dependency_field = $('.js-dependency-field');
	_$js_dependency_name = $('.js-dependency-name');
	_$js_login_error = $('.js-login-error');
	_$js_signup_error = $('.js-signup-error');
	_$js_signup_email_error = $('.js-signup-email-error');
	_$js_recover_password = $('.js-recover-password');

	_initEvents();
})(jQuery);