<div class="m-login-signup">
	<div class="m-login-signup__container">
		<div class="container">
			<div class="pure-g">
				<div class="pure-u-1 pure-u-sm-24-24 pure-u-md-11-24">
					<div class="m-login-signup__signup color-gray js-signup">
						<h2 class="align-center">Registro</h2>
						<p class="m-paragraph align-center">¿No tienes una cuenta?</p>
						<div class="align-center">
							<img src="./assets/images/login/signup.png" alt="" width="45" class="align-center">
						</div>
						<form action="<?php echo base_url() . "home/add";?>" method="post" class="pure-form m-login-signup__form js-signup-form">
							<div class="pure-u-1 pure-u-sm-24-24">
								<fieldset class="m-fieldset">
									<input type="text" name="nombre" placeholder="Nombre Completo" class="m-input" data-parsley-required data-parsley-error-message="Campo requerido" required />
								</fieldset>
							</div>
							<div class="pure-u-1 pure-u-sm-24-24">
								<fieldset class="m-fieldset m-estado pos-relative">
									<select class="m-select" name="estado" data-parsley-required data-parsley-error-message="Campo requerido">
										<option value="" disabled selected>Estado</option>
										<option value="1">Aguascalientes</option>
										<option value="2">Baja California</option>
										<option value="3">Baja California Sur</option>
										<option value="4">Campeche</option>
										<option value="5">Chiapas</option>
										<option value="6">Chihuahua</option>
										<option value="7">Ciudad de México </option>
										<option value="8">Coahuila de Zaragoza</option>
										<option value="9">Colima</option>
										<option value="10">Durango</option>
										<option value="11">Guanajuato</option>
										<option value="12">Guerrero</option>
										<option value="13">Hidalgo</option>
										<option value="14">Jalisco</option>
										<option value="15">México</option>
										<option value="16">Michoacán de Ocampo</option>
										<option value="17">Morelos</option>
										<option value="18">Nayarit</option>
										<option value="19">Nuevo León</option>
										<option value="20">Oaxaca</option>
										<option value="21">Puebla</option>
										<option value="22">Querétaro de Arteaga</option>
										<option value="23">Quintana Roo</option>
										<option value="24">San Luis Potosí</option>
										<option value="25">Sinaloa</option>
										<option value="26">Sonora</option>
										<option value="27">Tabasco</option>
										<option value="28">Tamaulipas</option>
										<option value="29">Tlaxcala</option>
										<option value="30">Veracruz de Ignacio de la Llave</option>
										<option value="31">Yucatán</option>
										<option value="32">Zacatecas</option>
									</select>
								</fieldset>
							</div>
							<div class="pure-u-1 pure-u-sm-24-24">
								<fieldset class="m-fieldset">
									<input type="text" name="ciudad" placeholder="Ciudad" class="m-input" data-parsley-required data-parsley-error-message="Campo requerido" autocomplete="off" required />
								</fieldset>
							</div>
							<div class="pure-u-1 pure-u-sm-24-24">
								<fieldset class="m-fieldset m-sector pos-relative">
									<select class="m-select js-select-sector" name="sector" data-parsley-required data-parsley-error-message="Campo requerido"> 
										<option value="" disabled selected>Sector</option>
										<option value="Gobierno Estatal">Gobierno Estatal</option>
										<option value="Gobierno Federal">Gobierno Federal</option>
										<option value="Gobierno Municipal">Gobierno Municipal</option>
										<option value="Sociedad Civil">Sociedad Civil</option>
										<option value="Otro">Otro</option>
									</select> 
								</fieldset>
							</div>
							<div class="dependency-field js-dependency-field">
								<fieldset class="m-fieldset">
									<input type="text" name="dependencia" class="m-input js-dependency-name" data-parsley-error-message="Campo requerido" autocomplete="off"/>
								</fieldset>
							</div>
							<div class="pure-u-1 pure-u-sm-24-24">
								<fieldset class="m-fieldset">
									<input  type="email" name="email" placeholder="Correo electronico" clasS="m-input" data-parsley-type="email" data-parsley-error-message="No es un email válido" autocomplete="off" required/>
									<input  type="hidden" name="status" value="activo" required/>
								</fieldset>
							</div>
							<div class="signup-error js-signup-error">
								<span class="semibold">Hubo un error al crear la cuenta, intenta nuevamente</span>
							</div>
							<div class="signup-error js-signup-email-error">
								<span class="semibold">El correo ya existe</span>
							</div>
							<div class="pure-g">
								<div class="pure-u-1 pure-u-sm-24-24 align-center">
									<button id="oculta" type="submit" class="m-emus__get-button pure-button is-large js-signup-submit">Registrarme</button>
								</div>
							</div>
						</form>
					</div>
					<div class="m-login-signup__success color-gray js-signup-success">
						<h2 class="align-center">Registro exitoso</h2>
						<div class="align-center">
							<img src="./assets/images/login/success.png" alt="" width="45" class="align-center">
						</div>
						<p class="m-paragraph align-center">Revisa tu bandeja de entrada o la bandeja de spam, hemos enviado a tu correo los accesos para CECI</p>
					</div>
				</div>
				<div class="pure-u-1 pure-u-sm-0-24 pure-u-md-2-24"></div>
				<div class="pure-u-1 pure-u-sm-24-24 pure-u-md-11-24">
					<div class="m-login-signup__signin color-gray">
						<h2 class="align-center">Login</h2>
						<p class="m-paragraph align-center">Inicia sesión en CECI</p>
						<div class="align-center">
							<img src="./assets/images/login/signin.png" alt="" width="45" class="align-center">
						</div>
						<form role="form" action ="<?php echo base_url() . "home/loginUsuarios";?>" method= "POST" class="pure-form m-login-signup__form js-login-form">
							<fieldset class="m-fieldset">
								<input class="m-input" type="text" name="email" placeholder="email" data-parsley-type="email" data-parsley-error-message="No es un email válido" autocomplete="off" required/>
							</fieldset>
							<fieldset class="m-fieldset">
								<input class="m-input" type="password" name="password" placeholder="contraseña" data-parsley-error-message="La contraseña es requerida" autocomplete="off" required/>
							</fieldset>
							<div class="login-error js-login-error">
								<span class="semibold">Datos incorrectos o no existe el usuario</span>
							</div>
							<div class="pure-g">
								<div class="pure-u-1 pure-u-sm-24-24 align-center">
									<button value="Login" id="btn_login" name="btn_login" type="submit" class="pure-button m-emus__get-button is-large js-login-submit" >Iniciar Sesión</button>
								</div>
							</div>
						</form>
						<a href="<?php echo base_url()?>recuperar-password" class="align-left color-purple3 js-recover-password">¿Olvidaste tu contraseña?</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
