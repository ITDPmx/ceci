<div class="m-login-signup">
	<div class="m-login-signup__container">
		<div class="container">
			<div class="pure-g">
				<div class="pure-u-1 pure-u-sm-6-24 pure-u-md-7-24 pure-u-lg-8-24"></div>
				<div class="pure-u-1 pure-u-sm-13-24 pure-u-md-12-24 pure-u-lg-9-24">
					<div class="m-login-signup__signup color-gray js-recover">
						<h2 class="align-center">Recuperar contraseña</h2>
						<div class="align-center">
							<img src="./assets/images/login/signup.png" alt="" width="45" class="align-center">
						</div>
						<form action="<?php echo base_url() . "recovery";?>" method="post" class="pure-form m-login-signup__form js-recover-form">

							<div class="pure-u-1 pure-u-sm-24-24">
								<fieldset class="m-fieldset">
									<input  type="email" name="email" autocomplete="off" placeholder="Correo electronico" class="m-input" data-parsley-type="email" data-parsley-error-message="No es un email válido" required/>
									<input  type="hidden" name="status" value="activo" required/>
								</fieldset>
							</div>
							<div class="signup-error js-recover-error">
								<span class="semibold">Hubo un error al enviar las credenciales, intenta nuevamente</span>
							</div>
							<div class="signup-error js-recover-email-error">
								<span class="semibold">El correo no existe</span>
							</div>
							<div class="pure-g">
								<div class="pure-u-1 pure-u-sm-24-24 align-center">
									<button id="oculta" type="submit" class="m-emus__get-button pure-button is-large js-recover-submit">Recuperar</button>
								</div>
							</div>
						</form>
					</div>
					<div class="m-login-signup__success color-gray js-recover-success">
						<h2 class="align-center">Correo enviado</h2>
						<div class="align-center">
							<img src="./assets/images/login/success.png" alt="" width="45" class="align-center">
						</div>
						<p class="m-paragraph align-center">Revisa tu bandeja de entrada o la bandeja de spam, hemos enviado a tu correo los accesos para CECI</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
