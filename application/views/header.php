<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
	<title>Ciudad Equitativa, Ciudad Inclusiva (CECI)</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<meta property="og:url" content="http://ceci.itdp.mx"/>
	<meta property="og:type" content="website" />
	<meta property="og:title" content="Ciudad Equitativa, Ciudad Inclusiva" />
	<meta property="og:description" content="Ciudad Equitativa, Ciudad Inclusiva (CECI) es una plataforma creada con el objetivo de fortalecer y ampliar capacidades técnicas de las administraciones locales para la planeación, gestión y ejecución de proyectos de movilidad urbana sustentable desde una perspectiva que integre los criterios de equidad, accesibilidad, seguridad y sostenibilidad. Todo ello para dar cumplimiento a los objetivos del Programa Nacional de Desarrollo Urbano 2014 – 2018 (PNDU). También es una guía para grupos y organizaciones ciudadanas que busquen impulsar proyectos de movilidad urbana.">
	<meta property="og:image" content="http://ceci.itdp.mx/assets/images/social/og_600x315.jpg" />
	<meta property="og:site_name" content="CECI MX"/>
	<meta name="keywords" content="movilidad sustentable, ciudad equitativa, ciudad inclusiva, derecho a la ciudad, movilidad urbana sustentable  "/>
	<meta name="description" content="Ciudad Equitativa, Ciudad Inclusiva (CECI) es una plataforma creada con el objetivo de fortalecer y ampliar capacidades técnicas de las administraciones locales para la planeación, gestión y ejecución de proyectos de movilidad urbana sustentable desde una perspectiva que integre los criterios de equidad, accesibilidad, seguridad y sostenibilidad. Todo ello para dar cumplimiento a los objetivos del Programa Nacional de Desarrollo Urbano 2014 – 2018 (PNDU). También es una guía para grupos y organizaciones ciudadanas que busquen impulsar proyectos de movilidad urbana.">
	<meta http-equiv="content-type" content="text/html;charset=utf-8">
	<meta http-equiv="cache-control" content="max-age=0" />
	<meta http-equiv="cache-control" content="no-cache" />
	<meta http-equiv="expires" content="0" />
	<meta http-equiv="pragma" content="no-cache" />
	<meta name="twitter:card" content="summary" />
	<meta name="twitter:site" content="@itdpmx" />
	<meta name="twitter:title" content="Ciudad Equitativa, Ciudad Inclusiva" />
	<meta name="twitter:description" content="Ciudad Equitativa, Ciudad Inclusiva (CECI) es una plataforma creada con el objetivo de fortalecer y ampliar capacidades técnicas de las administraciones locales para la planeación, gestión y ejecución de proyectos de movilidad urbana sustentable desde una perspectiva que integre los criterios de equidad, accesibilidad, seguridad y sostenibilidad. Todo ello para dar cumplimiento a los objetivos del Programa Nacional de Desarrollo Urbano 2014 – 2018 (PNDU). También es una guía para grupos y organizaciones ciudadanas que busquen impulsar proyectos de movilidad urbana. http://goo.gl/q3BaMU" />
	<meta name="twitter:image" content="http://ceci.itdp.mx/assets/images/social/ceci_twitter.jpg" />
	<meta name="twitter:url" content="http://ceci.itdp.mx/">
	<link href="<?php echo base_url() . "assets/";?>css/ceci.css" rel="stylesheet" type="text/css" />
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,700italic' rel='stylesheet' type='text/css' />
	<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/pure-min.css" />
	<!--  -->
	<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/grids-responsive-min.css" />
	<!--[if lte IE 8]>
	    <link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/grids-responsive-old-ie-min.css">
	<![endif]-->
	
	<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
	<link rel="shortcut icon" href="<?php echo base_url() . "assets/";?>images/favicon.ico" type="image/x-icon">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.1/jquery.min.js"></script>

</head>
<body>
<nav class="m-home-menu-desktop">
	<div class="container pos-relative">
		<div class="m-home-menu-desktop__logo">
			<a href="<?php echo base_url();?>" class="js-logo" data-hash="inicio">
				<img class="pure-img js-logo" src="<?php echo base_url() . "assets/"?>images/navigation/logo_ceci_w.png" alt="">
			</a>
		</div>
		<ul class="m-home-menu-desktop__list" id="navigation">
			<li class="m-home-menu-desktop__list-item js-home-parent-navigation js-init"><a href="<?php echo base_url();?>" class="bold">Inicio</a></li>
			<li class="m-home-menu-desktop__list-item js-home-parent-navigation js-login"><a href="<?php echo base_url(); ?>#acerca" data-hash="acerca" class="bold js-home-desktop-navigation-item">¿Qué es?</a></li>
			<li class="m-home-menu-desktop__list-item js-home-parent-navigation js-login"><a href="<?php echo base_url(); ?>#vision" data-hash="vision" class="bold js-home-desktop-navigation-item">Visión</a></li>
			<li class="m-home-menu-desktop__list-item js-home-parent-navigation js-login"><a href="<?php echo base_url(); ?>#emus" data-hash="emus" class="bold js-home-desktop-navigation-item">EMUS</a></li>
			
			<?php if($this->session->userdata('id_usuario') === NULL) { ?>
			<li class="m-home-menu-desktop__list-item js-registration-button"><a href="<?php echo base_url(); ?>login" class="m-home-menu-desktop__list-item__button pure-button bold js-signup-header">Acceso</a></li>
			<?php } else { ?>
			
			<li class="m-home-menu-desktop__list-item js-home-parent-navigation"><a href="<?php echo base_url(); ?>biblioteca" data-hash="biblioteca" class="bold">Biblioteca</a></li>
			<li class="m-home-menu-desktop__list-item js-home-parent-navigation"><a href="<?php echo base_url(); ?>capacitacion" data-hash="capacitacion" class="bold">Capacitación</a></li>
			<li class="m-training-menu-desktop__list-item js-home-parent-training pos-relative">
				<a class="js-open-submenu">
					<img src="<?php echo base_url() . "assets/"?>/images/navigation/user.png" width="25" alt="" class="m-training-menu-desktop__list-item__image"><?php echo $this->session->userdata('email') ?>
				</a>
				<ul class="m-training-menu-desktop__list-submenu js-submenu">
					<li class="m-training-menu-desktop__list-submenu__item">
						<a href="<?php echo base_url()?>dashboard" class="">
							<img src="<?php echo base_url() . "assets/"?>/images/navigation/progress.png" width="25" alt="" class="m-training-menu-desktop__list-item__image"> Mi Perfil
						</a>
					</li>
					<li class="m-training-menu-desktop__list-submenu__item">
						<a href="<?php echo base_url()?>logout" class="js-logout">
							<img src="<?php echo base_url() . "assets/"?>/images/navigation/logout.png" width="25" alt="" class="m-training-menu-desktop__list-item__image">Cerrar Sesión
						</a>
					</li>
				</ul>
			</li>
			<?php } ?>

		</ul>
	</div>
</nav>
<button class="m-menu-button hamburger hamburger--collapse js-home-hamburger" type="button" aria-controls="navigation">
  <span class="hamburger-box">
    <span class="hamburger-inner"></span>
  </span>
</button>
<aside class="m-home-menu-mobile js-home-menu-mobile">
	<nav class="m-home-menu-mobile__container js-home-menu-mobile-container">
		<div class="m-home-menu-mobile__logo">
			<a href="">
				<img class="pure-img" src="<?php echo base_url() . "assets/"?>images/navigation/logo_ceci_w.png" alt="">
			</a>
		</div>
		<div class="m-home-menu-mobile__list-container">
			<ul class="m-home-menu-mobile__list" id="navigation">
				<li class="m-home-menu-mobile__list-item js-home-mobile-navigation-item js-init"><a href="<?php echo base_url()?>" data-hash="inicio" class="bold">Inicio</a></li>
				<li class="m-home-menu-mobile__list-item js-home-mobile-navigation-item js-login"><a href="<?php echo base_url()?>#acerca" data-hash="acerca" class="bold">¿Qué es?</a></li>
				<li class="m-home-menu-mobile__list-item js-home-mobile-navigation-item js-login"><a href="<?php echo base_url()?>#vision" data-hash="vision" class="bold">Visión</a></li>
				<li class="m-home-menu-mobile__list-item js-home-mobile-navigation-item js-login"><a href="<?php echo base_url()?>#emus" data-hash="emus" class="bold ">EMUS</a></li>
				<?php if($this->session->userdata('id_usuario') === NULL) { ?>
				<li class="m-home-menu-desktop__list-item button_container js-logged"><a href="<?php echo base_url(); ?>login" class="m-home-menu-mobile__list-item__button pure-button bold" data-hash="login">Acceso</a></li>
				<?php } else { ?>
				<li class="m-home-menu-mobile__list-item js-home-mobile-navigation-item"><a href="<?php echo base_url(); ?>biblioteca" data-hash="biblioteca" class="bold">Biblioteca</a></li>
				<li class="m-home-menu-mobile__list-item js-home-mobile-navigation-item"><a href="<?php echo base_url(); ?>capacitacion" data-hash="capacitacion" class="bold">Capacitación</a></li>
				<li class="m-home-menu-mobile__list-item">
					<a href="<?php echo base_url()?>dashboard" class="bold" data-hash="dashboard">Mi Perfil</a>
				</li>
				<li class="m-home-menu-mobile__list-item">
					<a href="<?php echo base_url()?>logout" class="bold js-logout" data-hash="logout">Cerrar Sesión</a>
				</li>
				<?php } ?>
			</ul>
		</div>
	</nav>
</aside>
<!--[if lt IE 7]>
	<p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->

<!-- Add your site or application content here -->
