var initAnalytics = function(){
	return {
		clickNavigationMenu: function(navigationItem){
			ga('send', 'event', 'Menu Navegacion', 'Click', 'menu_' + navigationItem);
		},
		clickSignupMenu: function(){
			ga('send', 'event', 'Signup', 'Click', 'signup_header');
		},
		clickSignupLanding: function(){
			ga('send', 'event', 'Signup', 'Click', 'signup_landing');
		},
		clickRegisterSignup: function(){
			ga('send', 'event', 'Registro', 'Click', 'signup_boton');
		},
		clickLogin: function(){
			ga('send', 'event', 'Login', 'Click', 'login_boton');
		},
		clickRecoverLink: function(){
			ga('send', 'event', 'Recuperar Password', 'Click', 'recuperar_link');
		},
		clickRecoverButton: function(){
			ga('send', 'event', 'Recuperar Password', 'Click', 'recuperar_button');
		},
		clickGetCost: function(){
			ga('send', 'event', 'Calculadora', 'Click', 'obtener_costo');
		},
		clickTwitter: function(authorName){
			ga('send', 'event', 'Twitter', 'Click', authorName);
		},
		clickLogoCeci: function(){
			ga('send', 'event', 'Logo', 'Click', 'click_logo_ceci');
		},
		clickLogoFooter: function(nombreLogo){
			ga('send', 'event', 'Logo', 'Click', nombreLogo);
		},
		clickDownloadCsv: function(){
			ga('send', 'event', 'Resumen Csv', 'Click', 'resumen_detallado_boton');
		},
		clickChangeData: function(){
			ga('send', 'event', 'Cambiar Datos', 'Click', 'cambiar_datos_boton');
		},
		clickProfile: function(){
			ga('send', 'event', 'Perfil', 'Click', 'perfil_capacitacion_link');
		},
		clickModalityTraining: function(modalityName){
			ga('send', 'event', 'Modalidad', 'Click', 'capacitacion_' + modalityName);
		},
		clickDownloadModalityGuide: function(guideName){
			ga('send', 'event', 'Guia', 'Descarga', 'guia_' + guideName);
		},
		clickModalityTest: function(testName){
			ga('send', 'event', 'Test', 'Click', 'cuestionario_' + testName);
		},
		
		// PageView
		rootPage: function(){
			ga('send', 'pageview', 'http://ceci.itdp.mx/');
		},
		loginPage: function(){
			ga('send', 'pageview', 'http://ceci.itdp.mx/login');
		},
		recoverPage: function(){
			ga('send', 'pageview', 'http://ceci.itdp.mx/recuperar-password');
		},
		trainingPage: function(){
			ga('send', 'pageview', 'http://ceci.itdp.mx/capacitacion');
		},
		libraryPage: function(){
			ga('send', 'pageview', 'http://ceci.itdp.mx/biblioteca');
		},
		financePage: function(){
			ga('send', 'pageview', 'http://ceci.itdp.mx/financiamiento');
		},
		dashboardPage: function(){
			ga('send', 'pageview', 'http://ceci.itdp.mx/dashboard');
		}
		
	}
}