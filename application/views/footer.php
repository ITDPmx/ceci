	<div class="m-logos js-calculator-logos align-center">
		<div class="container">
			<div class="m-logos__custom color-gray">
				<div class="pure-g">
					<div class="pure-u-1 pure-u-sm-8-24"></div>
					<div class="pure-u-1 pure-u-sm-8-24">
						<div class="m-logos__container">
							<a href="https://www.civitaconsult.com/" target="_blank" rel="external" class="js-footer-logo" data-logo="logo_civita">
								<img src="../assets/images/logos/logo_civita.png" class="m-logos__image m-logos__image-width" alt="Logo Civita" width="150" height="75">
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="m-logos js-general-logos align-center">
		<div class="container">
			<div class="m-logos__custom color-gray">
				<div class="pure-g">
					<div class="pure-u-1 pure-u-sm-1-24 pure-u-md-3-24"></div>
					<div class="pure-u-1 pure-u-sm-11-24 pure-u-md-9-24">
						<div class="m-logos__container">
							<a href="http://mexico.itdp.org/" target="_blank" rel="external" class="js-footer-logo" data-logo="logo_sedatu">
								<img src="../assets/images/logos/logo_sedatu.png" class="m-logos__image m-logos__image-width" alt="Logo SEDATU" width="150" height="75">
							</a>
						</div>
					</div>
					<div class="pure-u-1 pure-u-sm-11-24 pure-u-md-9-24">
						<div class="m-logos__container">
							<a href="http://www.gob.mx/sedatu" target="_blank" rel="external" class="js-footer-logo" data-logo="logo_itdp_mexico">
								<img src="../assets/images/logos/logo_itdp_mexico.png" class="m-logos__image" alt="Logo ITDP" width="150" height="70">
							</a>
						</div>
					</div>
					<div class="pure-u-1 pure-u-sm-1-24 pure-u-md-3-24"></div>
				</div>
			</div>
			<div class="m-logos__support color-gray">
			<h2 class="align-center normal">Con el apoyo de</h2>
				<div class="pure-g">
					<div class="pure-u-1 pure-u-sm-1-24 pure-u-md-3-24"></div>
					<div class="pure-u-1 pure-u-sm-11-24 pure-u-md-9-24">
						<div class="m-logos__container">
							<a href="https://www.gov.uk/government/world/organisations/british-embassy-mexico-city" target="_blank" rel="external" class="js-footer-logo" data-logo="logo_embajada_britanica">
								<img src="../assets/images/logos/logo_embajada_britanica.png" class="m-logos__image" alt="Logo Embajada Británica" width="150" height="95">
							</a>
						</div>
					</div>
					<div class="pure-u-1 pure-u-sm-11-24 pure-u-md-9-24">
						<div class="m-logos__container">
							<a href="http://www.larci.org/" target="_blank" rel="external" class="js-footer-logo" data-logo="logo_larci">
								<img src="../assets/images/logos/logo_larci.png" class="m-logos__image m-logos__image-width" alt="Logo Larci" width="150" height="75">
							</a>
						</div>
					</div>
					<div class="pure-u-1 pure-u-sm-1-24 pure-u-md-3-24"></div>
				</div>
			</div>
		</div>
	</div>
	<script src="<?php echo base_url() . "assets/"?>js/isMobile.js" defer></script>
	<script src="<?php echo base_url() . "assets/"?>js/slick.js" defer></script>
	<script src="<?php echo base_url() . "assets/"?>js/parsley.js" defer></script>
	<script src="<?php echo base_url() . "assets/"?>js/selectize.js" defer></script>
	<script src="<?php echo base_url() . "assets/"?>js/Canvas2Image.js" defer></script>	
	
	<script src="<?php echo base_url() . "assets/"?>js/amcharts.js" defer></script>
	<script src="<?php echo base_url() . "assets/"?>js/amexport_combined.js" defer></script>

	<script src="<?php echo base_url() . "assets/"?>js/serial.js" defer></script>
	<script src="<?php echo base_url() . "assets/"?>js/light.js" defer></script>
	<script src="<?php echo base_url() . "assets/"?>js/responsive.js" defer></script>
	<script src="<?php echo base_url() . "assets/"?>js/numeral.min.js" defer></script>
	
	<script src="<?php echo base_url() . "assets/"?>js/header/navigation.js" defer></script>
	<script src="<?php echo base_url() . "assets/"?>js/footer/footer.js" defer></script>
	<script src="<?php echo base_url() . "assets/"?>js/home/landing-sections.js" defer></script>
	<script src="<?php echo base_url() . "assets/"?>js/home/slider.js" defer></script>
	<script src="<?php echo base_url() . "assets/"?>js/login/login.js" defer></script>
	<script src="<?php echo base_url() . "assets/"?>js/recover/recover.js" defer></script>
	<script src="<?php echo base_url() . "assets/"?>js/analytics/analytics.js"></script>
	
	<?php if ($this->uri->segment(1) == "resumen") { ?>
		<script src="<?php echo base_url() . "assets/"?>js/summary/summary.js" defer></script>
	<?php } ?>
	
	<?php if ($this->uri->segment(1) == "capacitacion") { ?>
		<script src="<?php echo base_url() . "assets/"?>js/training/training.js" defer></script>
	<?php } ?>
	
	<?php if ($this->uri->segment(1) == "calculadora") { ?>
		<script src="<?php echo base_url() . "assets/"?>js/calculator/calculator.js" defer></script>
	<?php } ?>
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/js/select2.min.js" defer></script>
	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

	  ga('create', 'UA-78870114-2', 'auto');
	  ga('send', 'pageview');

	</script>
</body>
</html>
