(function() {

	var _$body_html = null;
	var _$document = null;
	var _$window = null;
	var _$js_m_ceci = null;
	var _$js_home_hamburger = null;
	var _$js_home_hamburger_inner = null;
	var _$js_home_menu_mobile = null;
	var _$js_home_desktop_navigation_item = null;
	var _$js_home_mobile_navigation_item = null;
	var _$js_home_parent_training = null;
	var _$js_home_parent_navigation = null;
	var _hash = null;
	var _this = null;
	var _scrollPosition = null;
	var _screenWidth = null;
	var _$js_open_submenu = null;
	var _$js_submenu = null;
	var _current_url = null;
	var _$js_logo = null;
	var _hash_url = null;
	var _$js_logged = null;
	var _$js_logged_start = null;
	var _$js_login = null;
	var _$js_init = null;
	var _$js_home_menu_mobile_container = null;
	var _$js_logout = null;
	var _analyticItem = null;
	var _$js_logo = null;
	var _$js_signup_header = null;
	/**
	 * [initEvents Init click events]
	 */
	var initEvents = function(){
		var navigation = initAnalytics();

		_current_url = window.location.pathname;
		if (_current_url === "/") {
			_$js_home_parent_navigation.addClass('is-white');
			_$js_home_parent_training.addClass('is-white');
			_$js_logged_start.css("display", "none");
			_$js_init.css("display", "none");
			_$js_login.css("display", "inline-block");
			_$js_open_submenu.find('img').css("display","inline-block");
			_$js_home_mobile_navigation_item.css("display", "block");
			$('.js-submenu').find('img').css("display","inline-block");
			_$js_logo.attr("src", "/assets/images/navigation/logo_ceci_w.png");
		}

		else if (_current_url === "/login" || _current_url === "/recuperar-password") {
			_$js_home_parent_navigation.addClass('is-white');
			_$js_home_parent_training.addClass('is-white');
			_$js_logged_start.css("display", "none");
			_$js_init.css("display", "inline-block");
			_$js_login.css("display", "none");
			_$js_open_submenu.find('img').css("display","inline-block");
			_$js_home_mobile_navigation_item.css("display", "block");
			$('.js-submenu').find('img').css("display","inline-block");
			_$js_logo.attr("src", "/assets/images/navigation/logo_ceci_w.png");
		}

		else {
			_$js_home_parent_navigation.addClass('is-gray');
			_$js_home_parent_training.addClass('is-gray');
			_$js_login.css("display", "none");
			_$js_open_submenu.find('img').css("display","inline-block");
			_$js_home_mobile_navigation_item.css("display", "block");
			$('.js-submenu').find('img').css("display","inline-block");
			_$js_logo.attr("src", "/assets/images/navigation/logo_ceci_g.png");
		}

		/**
		 * [HOME NAVIGATION]
		 */
		if (!isMobile.phone) {
			_scrollPosition = _$document.scrollTop();
			
			/**
			 * [Detec scrollTop to show or hide menu button]
			 */
			_screenWidth = _$document.on('scroll', function(e){
				e.preventDefault();
				if (_screenWidth.scrollTop() > 127){
					_positiveTranslate(_$js_home_hamburger);
				}
				else{
					_negativeTranslate(_$js_home_hamburger);
					_$js_home_hamburger.removeClass('is-active');
					_$js_home_menu_mobile.removeClass('is-opened');
				}
			});

			/**
			 * [Detect scroll position]
			 */
			if(_scrollPosition > 127) {
				_positiveTranslate(_$js_home_hamburger);
			}
		}
		
		_$js_logo.on('click', function(e){
			//_analyticItem = _this.context.getAttribute('data-hash');
			navigation.clickLogoCeci();
		});
		
		_$js_signup_header.on('click', function() {
			navigation.clickSignupMenu();
		});
		
		
		/**
		 * [Open menu]
		 */
		_$js_home_hamburger.on('click', function(e){
			e.preventDefault();
			_this = $(this);
			_$js_home_menu_mobile.toggleClass('is-menu-visible');
			_this.toggleClass('is-active');
			$('body').toggleClass("body-overflow");
		});
		
		/**
		 * [Click outside menu to close it]
		 */
		_$js_home_menu_mobile.on('click', function(){
			_this = $(this);
			_this.removeClass('is-menu-visible');
			_$js_home_hamburger.removeClass('is-active');
			$('body').removeClass("body-overflow");
		});
		
		/**
		 * [Stop propagation when click any element inside navigation]
		 */
		_$js_home_menu_mobile_container.on('click', function(e){
			e.stopPropagation();
		});

		/**
		 * [Click on the item menu (desktop)]
		 */
		_$js_home_desktop_navigation_item.on('click', function(e){
			e.preventDefault();
			_this = $(this);
			_hash = $(this).context.hash;
			_analyticItem = _this.context.getAttribute('data-hash');
			_$js_home_parent_navigation.removeClass('is-scroll');
			_this.parent().addClass('is-scroll');
			_$js_home_hamburger.removeClass('is-active');
			$('body').removeClass("body-overflow");
			_scrollToHash(_hash);
			navigation.clickNavigationMenu(_analyticItem);
			
		});
		
		/**
		 * [Click on the item menu (mobile)]
		 */
		_$js_home_mobile_navigation_item.on('click', function(e){
			_this = $(this);
			_hash = $(this).context.hash;
			_analyticItem = _this.context.getAttribute('data-hash');
			_$js_home_hamburger.removeClass('is-active');
			_$js_home_menu_mobile.removeClass('is-menu-visible');
			$('body').removeClass("body-overflow");
			_scrollToHash(_hash);
			navigation.clickNavigationMenu(_analyticItem);
			e.preventDefault();
		});
		
		/**
		 * [Click to open submenu]
		 */
		_$js_open_submenu.on('click', function(e){
			e.preventDefault();
			_$js_submenu.slideToggle();
		});
		
		_$js_logout.on('click', function(){
			sessionStorage.removeItem('played');
		});

	};

	/**
	 * [_menuScrolled Show button menu when scrollTop > 127px]
	 */
	var _positiveTranslate = function(js_element){
		js_element.css({
			"-webkit-transform": "translate(0%, 0%) matrix(1, 0, 0, 1, 0, 0)",
			"-moz-transform": "translate(0%, 0%) matrix(1, 0, 0, 1, 0, 0)",
			"-o-transform": "translate(0%, 0%) matrix(1, 0, 0, 1, 0, 0)",
			"-ms-transform": "translate(0%, 0%) matrix(1, 0, 0, 1, 0, 0)",
			"transform": "translate(0%, 0%) matrix(1, 0, 0, 1, 0, 0)",
			"-webkit-transition": "all 0.25s cubic-bezier(0.46, 0.03, 0.52, 0.96)",
			"-moz-transition": "all 0.25s cubic-bezier(0.46, 0.03, 0.52, 0.96)",
			"-o-transition": "all 0.25s cubic-bezier(0.46, 0.03, 0.52, 0.96)",
			"-ms-transition": "all 0.25s cubic-bezier(0.46, 0.03, 0.52, 0.96)",
			"transition:": "all 0.25s cubic-bezier(0.46, 0.03, 0.52, 0.96)"
		});
	};

	/**
	 * [_menuNotScrolled Hide button menu when scrollTop < 127px]
	 */
	var _negativeTranslate = function(js_element){
		js_element.css({
			"-webkit-transform": "translate(100%, 0%) matrix(1, 0, 0, 1, 0, 0)",
			"-moz-transform": "translate(100%, 0%) matrix(1, 0, 0, 1, 0, 0)",
			"-o-transform": "translate(100%, 0%) matrix(1, 0, 0, 1, 0, 0)",
			"-ms-transform": "translate(100%, 0%) matrix(1, 0, 0, 1, 0, 0)",
			"transform": "translate(100%, 0%) matrix(1, 0, 0, 1, 0, 0)",
			"-webkit-transition": "all 0.25s cubic-bezier(0.46, 0.03, 0.52, 0.96)",
			"-moz-transition": "all 0.25s cubic-bezier(0.46, 0.03, 0.52, 0.96)",
			"-o-transition": "all 0.25s cubic-bezier(0.46, 0.03, 0.52, 0.96)",
			"-ms-transition": "all 0.25s cubic-bezier(0.46, 0.03, 0.52, 0.96)",
			"transition:": "all 0.25s cubic-bezier(0.46, 0.03, 0.52, 0.96)"
		});
	};
	
	var _scrollToHash = function(hash) {
		$("body, html").animate({
			scrollTop: $(hash).offset().top - 0
		}, 800);
	};

	_$body_html = $("body, html");
	_$document = $(document);
	_$window = $(window);
	_$js_home_hamburger = $(".js-home-hamburger");
	_$js_home_hamburger_inner = $(".hamburger-inner");
	_$js_home_menu_mobile =$('.js-home-menu-mobile');
	_$js_m_ceci = $('.js-m-ceci');
	_$js_home_parent_navigation = $(".js-home-parent-navigation");
	_$js_home_desktop_navigation_item = $(".js-home-desktop-navigation-item");
	_$js_home_mobile_navigation_item = $(".js-home-mobile-navigation-item");
	_$js_open_submenu = $('.js-open-submenu');
	_$js_submenu = $('.js-submenu');
	_$js_logo = $('.js-logo');
	_$js_logged = $('.js-logged');
	_$js_logged_start = $('.js-logged-start');
	_$js_login = $('.js-login');
	_$js_init = $('.js-init');
	_$js_home_parent_training = $('.js-home-parent-training');
	_$js_home_menu_mobile_container = $('.js-home-menu-mobile-container');
	_$js_logout = $('.js-logout');
	_$js_logo = $('.js-logo');
	_$js_signup_header = $('.js-signup-header');
	
	
	var hashLocation = false;
	if (location.hash) {
			hashLocation = window.location.hash;
			setTimeout(function() {
					hashLocation = window.location.hash;
			}, 1); // Execute at two moments for browser compatibility reasons
	}

	// If we have a hash location do stuff
	if (hashLocation) {

		setTimeout(function() {
			// Check hashLocation suffix
			if( hashLocation.indexOf('_hash') < 0 ) {
				hashLocation = hashLocation + "_hash";
			}
			_scrollToHash(hashLocation);

		}, 100);

	}
	
	initEvents();

})(jQuery);