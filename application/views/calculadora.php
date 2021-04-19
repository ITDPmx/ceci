<div class="m-calculator">
	<div class="container">
		<h2 class="align-center color-gray">Calculadora</h2>
		<div class="pure-g">
			<div class="pure-u-1 pure-u-sm-1-24 pure-u-md-2-24"></div>
			<div class="pure-u-1 pure-u-sm-22-24 pure-u-md-20-24">
				<div class="m-calculator__form">
					<form action="" class="js-calculator-form" >
						<div class="m-calculator__form-section">
							<h3 class="color-purple3">Sección 1 - Ubicación del proyecto</h3>
							<p class="color-purple2">Escoge tu Estado y Municipio</p>
							<div class="pure-g">
								<div class="pure-u-1 pure-u-sm-0-24 pure-u-md-0-24 pure-u-lg-5-24"></div>
								<div class="pure-u-1 pure-u-sm-12-24 pure-u-md-12-24 pure-u-lg-7-24">
									<div class="m-calculator__estado">
										<select class="js-estado" name="estado" id="estado" data-placeholder="Seleccione un estado" data-parsley-required data-parsley-error-message="Seleccione un estado">
											<option value="">Seleccione un estado</option>
											<option value="1">Aguascalientes</option> 
											<option value="2">Baja California</option> 
											<option value="3">Baja California Sur</option>  
											<option value="4">Campeche</option> 
											<option value="7">Chiapas</option> 
											<option value="8">Chihuahua</option> 
											<option value="5">Coahuila</option> 
											<option value="6">Colima</option> 
											<option value="9">Ciudad de México</option>
											<option value="10">Durango</option> 
											<option value="11">Guanajuato</option> 
											<option value="12">Guerrero</option> 
											<option value="13">Hidalgo</option> 
											<option value="14">Jalisco</option> 
											<option value="15">México</option> 
											<option value="16">Michoacán</option> 
											<option value="17">Morelos</option> 
											<option value="18">Nayarit</option> 
											<option value="19">Nuevo León</option>  
											<option value="20">Oaxaca</option> 
											<option value="21">Puebla</option> 
											<option value="22">Querétaro</option> 
											<option value="23">Quintana Roo</option>  
											<option value="24">San Luis Potosí</option>
											<option value="25">Sinaloa</option> 
											<option value="26">Sonora</option> 
											<option value="27">Tabasco</option> 
											<option value="28">Tamaulipas</option> 
											<option value="29">Tlaxcala</option> 
											<option value="30">Veracruz</option> 
											<option value="31">Yucatán</option> 
											<option value="32">Zacatecas</option> 
										</select>
									</div>
								</div>
								<div class="pure-u-1 pure-u-sm-12-24 pure-u-md-12-24 pure-u-lg-7-24">
									<div class="m-calculator__municipio">
										<select class="js-municipio" name="municipio" id="municipio" data-parsley-required data-parsley-error-message="Seleccione un municipio">
											<option value="">Seleccione un municipio</option>
										</select>
									</div>
								</div>
							</div>
						</div>
						<div class="m-calculator__form-section">
							<h3 class="color-purple3">Sección 1 - Tipo de infraestructura ciclista</h3>
							<p class="color-purple4">¿Qué infraestructura ciclista te gustaría implementar en la vía?</p>
							<div class="pure-g">
								<div class="pure-u-1 pure-u-sm-12-24 pure-u-md-12-24 pure-u-lg-6-24">
									<div class="m-calculator__image">
										<input type="radio" id="ciclovia_confinamiento" name="infraestructura" value="CC" class="radio js-tipo-ciclovia" data-parsley-required data-parsley-error-message="Seleccione una ciclovía" data-parsley-multiple="ciclovia" >
										<article>
											<figcaption class="js-selected-infra">Ciclovía por elemento de confinamiento</figcaption>
											<figure>
												<label for="ciclovia_confinamiento">
												<img src="<?php echo base_url() . "assets/"?>images/calculator/ciclovia_confinamiento.jpg" style="width: 100%;" id="CC">
												</label>
											</figure>
										</article>
									</div>
								</div>
								<div class="pure-u-1 pure-u-sm-12-24 pure-u-md-12-24 pure-u-lg-6-24">
									<div class="m-calculator__image">
										<input type="radio" id="ciclovia_cordon" name="infraestructura" value="CCE" class="radio js-tipo-ciclovia" data-parsley-required data-parsley-error-message="Seleccione una ciclovía" data-parsley-multiple="ciclovia">
										<article>
											<figcaption class="js-selected-infra">Ciclovía por cordón de estacionamiento</figcaption>
											<figure>
												<label for="ciclovia_cordon">
												<img src="<?php echo base_url() . "assets/"?>images/calculator/ciclovia_estacionamiento.jpg" style="width: 100%;" id="CCE">
												</label>
											</figure>
										</article>
									</div>
								</div>
								<div class="pure-u-1 pure-u-sm-12-24 pure-u-md-12-24 pure-u-lg-6-24">
									<div class="m-calculator__image">
									<input type="radio" id="ciclovia_compartida" name="infraestructura" value="BB" class="radio js-tipo-ciclovia" data-parsley-required data-parsley-error-message="Seleccione una ciclovía" data-parsley-multiple="ciclovia">
										<article>
											<figcaption class="js-selected-infra">Carril compartido ciclista con transporte público</figcaption>
											<figure>
												<label for="ciclovia_compartida">
												<img src="<?php echo base_url() . "assets/"?>images/calculator/carril_compartido_tp.jpg" style="width: 100%;" id="BB">
												</label>
											</figure>
										</article>
									</div>
								</div>
								<div class="pure-u-1 pure-u-sm-12-24 pure-u-md-12-24 pure-u-lg-6-24">
									<div class="m-calculator__image">
										<input type="radio" id="ciclocarril" name="infraestructura" value="CICA" class="radio js-tipo-ciclovia" data-parsley-required data-parsley-error-message="Seleccione una ciclovía" data-parsley-multiple="ciclovia">
										<article>
											<figcaption class="js-selected-infra">Ciclocarril</figcaption>
											<figure>
												<label for="ciclocarril">
												<img src="<?php echo base_url() . "assets/"?>images/calculator/ciclocarril.jpg" style="width: 100%;" id="CICA">
												</label>
											</figure>
										</article>
									</div>
								</div>
							</div>
						</div>
						<hr>
						<div class="m-calculator__form-section">
							<h3 class="color-purple3">Sección 2 - Características básicas del proyecto</h3>
							<div class="m-calculator__form-section__field">
								<div class="pure-g">
									<div class="pure-u-1 pure-u-sm-1-24 pure-u-md-1-24 pure-u-lg-3-24"></div>
									<div class="pure-u-1 pure-u-sm-14-24 pure-u-md-14-24 pure-u-lg-12-24">
										<label>Número de kilómetros del proyecto</label>
									</div>
									<div class="pure-u-1 pure-u-sm-8-24 pure-u-md-8-24 pure-u-lg-6-24">
										<fieldset class="m-fieldset">
											<input type="number" class="m-input m-input--in-calculator" placeholder="kilómetros" name="A" data-parsley-range="[1,500]" step="0.01" data-parsley-error-message="Número no válido" data-parsley-required autocomplete="off"/>
										</fieldset>
									</div>
									<div class="pure-u-1 pure-u-sm-1-24 pure-u-md-1-24 pure-u-lg-3-24"></div>
								</div>
							</div>
							<div class="m-calculator__form-section__field">
								<div class="pure-g">
									<div class="pure-u-1 pure-u-sm-1-24 pure-u-md-1-24 pure-u-lg-3-24"></div>
									<div class="pure-u-1 pure-u-sm-14-24 pure-u-md-14-24 pure-u-lg-12-24">
										<label>Ancho del arroyo vehicular en metros</label>
										<small>Nota: El ancho se refiere a toda la sección de la vialidad, o en su caso la sección que será intervenida.</small>
									</div>
									<div class="pure-u-1 pure-u-sm-8-24 pure-u-md-8-24 pure-u-lg-6-24">
										<fieldset class="m-fieldset">
											<input type="number" class="m-input m-input--in-calculator" placeholder="metros" name="B" data-parsley-type="digits" data-parsley-required data-parsley-range="[1,50]" step="0.01" data-parsley-error-message="Número no válido" autocomplete="off"/>
										</fieldset>
									</div>
									<div class="pure-u-1 pure-u-sm-1-24 pure-u-md-1-24 pure-u-lg-3-24"></div>
								</div>
							</div>
							<div class="m-calculator__form-section__field">
								<div class="pure-g">
									<div class="pure-u-1 pure-u-sm-1-24 pure-u-md-1-24 pure-u-lg-3-24"></div>
									<div class="pure-u-1 pure-u-sm-14-24 pure-u-md-14-24 pure-u-lg-12-24">
										<label>Número de carriles de circulación efectivos en el proyecto</label>
									</div>
									<div class="pure-u-1 pure-u-sm-8-24 pure-u-md-8-24 pure-u-lg-6-24">
										<fieldset class="m-fieldset">
											<input type="number" class="m-input m-input--in-calculator" placeholder="carriles" name="D" data-parsley-type="digits" data-parsley-required data-parsley-range="[1,20]" data-parsley-error-message="Número no válido" autocomplete="off"/>
										</fieldset>
									</div>
									<div class="pure-u-1 pure-u-sm-1-24 pure-u-md-1-24 pure-u-lg-3-24"></div>
								</div>
							</div>
						</div>
						<hr>
						<div class="m-calculator__form-section">
							<h3 class="color-purple3">Sección 3 - Infraestructura peatonal accesible</h3>
							<div class="m-calculator__form-section__field">
								<div class="pure-g">
									<div class="pure-u-1 pure-u-sm-1-24 pure-u-md-1-24 pure-u-lg-3-24"></div>
									<div class="pure-u-1 pure-u-sm-14-24 pure-u-md-14-24 pure-u-lg-12-24">
										<label>Aproximadamente, ¿cuántos postes se removerán por kilómetro?</label>
									</div>
									<div class="pure-u-1 pure-u-sm-8-24 pure-u-md-8-24 pure-u-lg-6-24">
										<fieldset class="m-fieldset">
											<input type="number" class="m-input m-input--in-calculator" placeholder="postes" name="E" data-parsley-type="digits" data-parsley-required data-parsley-range="[0,50]" data-parsley-error-message="Número no válido" autocomplete="off"/>
										</fieldset>
									</div>
									<div class="pure-u-1 pure-u-sm-1-24 pure-u-md-1-24 pure-u-lg-3-24"></div>
								</div>
							</div>
							<div class="m-calculator__form-section__field">
								<div class="pure-g">
									<div class="pure-u-1 pure-u-sm-1-24 pure-u-md-1-24 pure-u-lg-3-24"></div>
									<div class="pure-u-1 pure-u-sm-14-24 pure-u-md-14-24 pure-u-lg-12-24">
										<label>¿Cuántas intersecciones contempla el proyecto?</label>
										<small>Nota: Una calle completa debe considerar la implementación de infraestructura peatonal con criterios de accesibilidad universal, la cual varía de acuerdo a la tipología de la infraestructura.</small>
									</div>
									<div class="pure-u-1 pure-u-sm-8-24 pure-u-md-8-24 pure-u-lg-6-24">
										<fieldset class="m-fieldset">
											<input type="number" class="m-input m-input--in-calculator" placeholder="intersecciones" required name="F" data-parsley-type="digits" data-parsley-required data-parsley-range="[1,100]" data-parsley-error-message="Número no válido" autocomplete="off"/>
										</fieldset>
									</div>
									<div class="pure-u-1 pure-u-sm-1-24 pure-u-md-1-24 pure-u-lg-3-24"></div>
								</div>
							</div>
							<div class="m-calculator__form-section__field">
								<div class="pure-g">
									<div class="pure-u-1 pure-u-sm-1-24 pure-u-md-1-24 pure-u-lg-3-24"></div>
									<div class="pure-u-1 pure-u-sm-14-24 pure-u-md-14-24 pure-u-lg-12-24">
										<label>¿Cuántas intersecciones serán intervenidas con infraestructura accesible?</label>
										<small>Nota: La extensión de banqueta contempla rampas e instalación de bolardos. Cada intersección está compuesta de 4 extensiones de banqueta. Ver diagrama.</small>
									</div>
									<div class="pure-u-1 pure-u-sm-8-24 pure-u-md-8-24 pure-u-lg-6-24">
										<fieldset class="m-fieldset">
											<input type="number" class="m-input m-input--in-calculator" placeholder="intersecciones intervenidas" name="G" data-parsley-type="digits" data-parsley-required data-parsley-range="[0,100]" data-parsley-error-message="Número no válido" autocomplete="off"/>
										</fieldset>
									</div>
									<div class="pure-u-1 pure-u-sm-1-24 pure-u-md-1-24 pure-u-lg-3-24"></div>
								</div>
							</div>
							<div class="m-calculator__form-section__field">
								<div class="pure-g">
									<div class="pure-u-1 pure-u-sm-1-24 pure-u-md-1-24 pure-u-lg-3-24"></div>
									<div class="pure-u-1 pure-u-sm-14-24 pure-u-md-14-24 pure-u-lg-12-24">
										<label>¿Cuantos kilómeros del proyecto contemplan ampliación de banquetas? Suma ambos lados de la vía.</label>
									</div>
									<div class="pure-u-1 pure-u-sm-8-24 pure-u-md-8-24 pure-u-lg-6-24">
										<fieldset class="m-fieldset">
											<input type="number" class="m-input m-input--in-calculator" placeholder="km ampliación banqueta" name="H" data-parsley-type="digits" data-parsley-required data-parsley-range="[0,100]" step="0.01" data-parsley-error-message="Número no válido" autocomplete="off"/>
										</fieldset>
									</div>
									<div class="pure-u-1 pure-u-sm-1-24 pure-u-md-1-24 pure-u-lg-3-24"></div>
								</div>
							</div>
							<div class="m-calculator__form-section__field">
								<div class="pure-g">
									<div class="pure-u-1 pure-u-sm-1-24 pure-u-md-1-24 pure-u-lg-3-24"></div>
									<div class="pure-u-1 pure-u-sm-14-24 pure-u-md-14-24 pure-u-lg-12-24">
										<label>¿Cuántos metros se ampliará la banqueta? Suma ambos lados de la vía</label>
										<small>Nota: Si tu presupuesto es limitado, te recomendamos incluir al menos infraestructura accesible en las intersecciones.</small>
									</div>
									<div class="pure-u-1 pure-u-sm-8-24 pure-u-md-8-24 pure-u-lg-6-24">
										<fieldset class="m-fieldset">
											<input type="number" class="m-input m-input--in-calculator" placeholder="mt. ampliación banqueta" required name="I" data-parsley-type="digits" data-parsley-required data-parsley-range="[0,20]" step="0.01" data-parsley-error-message="Número no válido" autocomplete="off"/>
										</fieldset>
									</div>
									<div class="pure-u-1 pure-u-sm-1-24 pure-u-md-1-24 pure-u-lg-3-24"></div>
								</div>
							</div>
						</div>
						<hr>
						<div class="m-calculator__form-section">
							<h3 class="color-purple3">Sección 4 - Semaforización</h3>
							<div class="m-calculator__form-section__field">
								<div class="pure-g">
									<div class="pure-u-1 pure-u-sm-1-24 pure-u-md-1-24 pure-u-lg-3-24"></div>
									<div class="pure-u-1 pure-u-sm-14-24 pure-u-md-14-24 pure-u-lg-12-24">
										<label>Número de intersecciones semaforizadas en el proyecto</label>
									</div>
									<div class="pure-u-1 pure-u-sm-8-24 pure-u-md-8-24 pure-u-lg-6-24">
										<fieldset class="m-fieldset">
											<input type="number" class="m-input m-input--in-calculator" placeholder="intersecciones semaforizadas" name="J" data-parsley-type="digits" data-parsley-required data-parsley-range="[0, 100]" data-parsley-error-message="Número no válido" autocomplete="off"/>
										</fieldset>
									</div>
									<div class="pure-u-1 pure-u-sm-1-24 pure-u-md-1-24 pure-u-lg-3-24"></div>
								</div>
							</div>
						</div>
						<hr>
						<div class="m-calculator__form-section">
							<h3 class="color-purple3">Sección 5 - Mobiliario urbano</h3>
							<div class="m-calculator__form-section__field">
								<div class="pure-g">
									<div class="pure-u-1 pure-u-sm-1-24 pure-u-md-1-24 pure-u-lg-3-24"></div>
									<div class="pure-u-1 pure-u-sm-14-24 pure-u-md-14-24 pure-u-lg-12-24">
										<label>¿Cuántos biciestacionamientos se contemplan en el proyecto?</label>
										<small>Nota: Recuerda que este tipo de mobiliario urbano incentiva que más personas utilicen la bicicleta como medio de transporte al otorgarles un espacio donde resguardar su vehículo. Sugerimos colocar 4 muebles cada 3 cuadras.</small>
									</div>
									<div class="pure-u-1 pure-u-sm-8-24 pure-u-md-8-24 pure-u-lg-6-24">
										<fieldset class="m-fieldset">
											<input type="number" class="m-input m-input--in-calculator" placeholder="biciestacionamientos" name="K" data-parsley-type="digits" data-parsley-required data-parsley-range="[0, 200]" data-parsley-error-message="Número no válido" autocomplete="off"/>
										</fieldset>
									</div>
									<div class="pure-u-1 pure-u-sm-1-24 pure-u-md-1-24 pure-u-lg-3-24"></div>
								</div>
							</div>
						</div>
						<hr>
						<div class="m-calculator__form-section">
							<h3 class="color-purple3">Sección 6 - Otros costos</h3>
							<div class="m-calculator__form-section__field">
								<div class="pure-g">
									<div class="pure-u-1 pure-u-sm-1-24 pure-u-md-1-24 pure-u-lg-3-24"></div>
									<div class="pure-u-1 pure-u-sm-14-24 pure-u-md-14-24 pure-u-lg-12-24">
										<label>¿Deseas agregar el costo del Proyecto Ejecutivo?</label>
										<small>Nota: Este costo equivale al 5% del costo total del proyecto.</small>
									</div>
									<div class="pure-u-1 pure-u-sm-8-24 pure-u-md-8-24 pure-u-lg-6-24">
										<fieldset class="m-fieldset">
										  <div class="m-radio m-radio--in-calculator">
										    <input id="proyecto_si" type="radio" class="m-radio__input" name="L" value="si" data-parsley-required data-parsley-error-message="Campo requerido" data-parsley-multiple="costo_pe">
										    <label for="proyecto_si" class="m-radio__input-label"><span></span>Si</label>
										  </div>
										  <div class="m-radio m-radio--in-calculator">
										    <input id="proyecto_no" type="radio" class="m-radio__input" name="L" value="no" data-parsley-required data-parsley-error-message="Campo requerido" data-parsley-multiple="costo_pe">
										    <label for="proyecto_no" class="m-radio__input-label"><span></span>No</label>
										  </div>
										</fieldset>
									</div>
									<div class="pure-u-1 pure-u-sm-1-24 pure-u-md-1-24 pure-u-lg-3-24"></div>
								</div>
							</div>
							<div class="m-calculator__form-section__field">
								<div class="pure-g">
									<div class="pure-u-1 pure-u-sm-1-24 pure-u-md-1-24 pure-u-lg-3-24"></div>
									<div class="pure-u-1 pure-u-sm-14-24 pure-u-md-14-24 pure-u-lg-12-24">
										<label>¿Deseas agregar el costo de Supervisión de Obra?</label>
										<small>Nota: Este costo equivale al 2% del costo total del proyecto.</small>
									</div>
									<div class="pure-u-1 pure-u-sm-8-24 pure-u-md-8-24 pure-u-lg-6-24">
										<fieldset class="m-fieldset">
										  <div class="m-radio m-radio--in-calculator">
										    <input id="supervision_si" type="radio" class="m-radio__input" name="M" value="si" data-parsley-required data-parsley-error-message="Campo requerido" data-parsley-multiple="costo_so">
										    <label for="supervision_si" class="m-radio__input-label"><span></span>Si</label>
										  </div>
										  <div class="m-radio m-radio--in-calculator">
										    <input id="supervision_no" type="radio" class="m-radio__input" name="M" value="no" data-parsley-required data-parsley-error-message="Campo requerido" data-parsley-multiple="costo_so">
										    <label for="supervision_no" class="m-radio__input-label"><span></span>No</label>
										  </div>
										</fieldset>
									</div>
									<div class="pure-u-1 pure-u-sm-1-24 pure-u-md-1-24 pure-u-lg-3-24"></div>
								</div>
							</div>
							<div class="m-calculator__form-section__field">
								<div class="pure-g">
									<div class="pure-u-1 pure-u-sm-1-24 pure-u-md-1-24 pure-u-lg-3-24"></div>
									<div class="pure-u-1 pure-u-sm-14-24 pure-u-md-14-24 pure-u-lg-12-24">
										<label>¿Deseas agregar la Retención 5 al millar?</label>
										<small>Nota: Con base en el art. 191 de la Ley Federal de Derechos: Por el servicio de vigilancia, inspección y control que las leyes de la materia encomiendan a la Secretaría de la Función Pública, los contratistas con quienes se celebren contratos de obra pública y de servicios relacionados con la misma, pagarán un derecho equivalente al cinco al millar sobre el importe de cada una de las estimaciones de trabajo. Las oficinas pagadoras de las dependencias de la administración pública federal centralizada y paraestatal, al hacer el pago de las estimaciones de obra, retendrán el importe del derecho a que se refiere el párrafo anterior.  En aquellos casos en que las Entidades Federativas hayan celebrado Convenio de Colaboración Administrativa en esta materia con la Federación, los ingresos que se obtengan por el cobro del derecho antes señalado, se destinarán a la Entidad Federativa que los recaude, para la operación, conservación, mantenimiento e inversión necesarios para la prestación de los servicios a que se refiere este artículo, en los términos que señale dicho convenio y conforme a los lineamientos específicos que emita para tal efecto la Secretaría de la Función Pública. Los ingresos que se obtengan por la recaudación de este derecho, que no estén destinados a las Entidades Federativas en términos del párrafo anterior, se destinarán a la Secretaría de la Función Pública, para el fortalecimiento del servicio de inspección, vigilancia y control a que se refiere este artículo.</small>
									</div>
									<div class="pure-u-1 pure-u-sm-8-24 pure-u-md-8-24 pure-u-lg-6-24">
										<fieldset class="m-fieldset">
										  <div class="m-radio m-radio--in-calculator">
										    <input id="retencion_si" type="radio" class="m-radio__input" name="N" value="si" data-parsley-required data-parsley-error-message="Campo requerido" data-parsley-multiple="retencion">
										    <label for="retencion_si" class="m-radio__input-label"><span></span>Si</label>
										  </div>
										  <div class="m-radio m-radio--in-calculator">
										    <input id="retencion_no" type="radio" class="m-radio__input" name="N" value="no" data-parsley-required data-parsley-error-message="Campo requerido" data-parsley-multiple="retencion">
										    <label for="retencion_no" class="m-radio__input-label"><span></span>No</label>
										  </div>
										</fieldset>
									</div>
									<div class="pure-u-1 pure-u-sm-1-24 pure-u-md-1-24 pure-u-lg-3-24"></div>
								</div>
							</div>
						</div>
						<hr>
						<div class="align-center">
						<h3 class="color-blue bold">¡Atención!</h3>
						<small class="m-calculator__form-note normal color-blue">Los precios unitarios utilizados para el cálculo en la presente herramienta son paramétricos y pueden presentar variaciones dependiendo la región del país. ​</small>
							<a href="" class="pure-button m-emus__get-button m-training-content__test-link is-larger js-costo color-purple2">Obtener Costo</a>
						</div>
						<div class="align-center m-calculator__form-novalid js-novalid-form">
							<p>Hay campos sin llenar o no válidos</p>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="m-author">
	<div class="m-author__sliders js-author-slide">
		<div class="m-author__sliders-slide">
			<h3 class="align-center color-purple3">Autoras</h3>
			<div class="pure-g align-center">
				<div class="pure-u-1 pure-u-sm-0-24 pure-u-md-0-24 pure-u-lg-5-24"></div>
				<div class="pure-u-1 pure-u-sm-12-24 pure-u-md-12-24 pure-u-lg-7-24">
					<a href="https://twitter.com/YazAPie" class="m-author__twitter js-twitter" data-twitter="YazAPie" target="_blank">
						<h4 class="color-gray normal">Yazmín Viramontes</h4>
						<img src="../assets/images/calculator/twitter.png" alt="" width="30" class="align-center">
					</a>
				</div>
				<div class="pure-u-1 pure-u-sm-12-24 pure-u-md-12-24 pure-u-lg-7-24">
					<a href="https://twitter.com/bikennia" class="m-author__twitter js-twitter" data-twitter="bikennia" target="_blank">
						<h4 class="color-gray normal">Kennia Aguirre</h3>
						<img src="../assets/images/calculator/twitter.png" alt="" width="30" class="align-center">
					</a>
				</div>
			</div>
		</div>
		<div class="m-author__sliders-slide">
			<h3 class="align-center color-purple3">Colaboradores</h3>
			<div class="pure-g align-center">
				<div class="pure-u-1 pure-u-sm-0-24 pure-u-md-0-24 pure-u-lg-5-24"></div>
				<div class="pure-u-1 pure-u-sm-12-24 pure-u-md-12-24 pure-u-lg-7-24">
					<a href="https://twitter.com/alexdom07" class="m-author__twitter js-twitter" data-twitter="alexdom07" target="_blank">
						<h4 class="color-gray normal">Alejandro Domínguez</h4>
						<img src="../assets/images/calculator/twitter.png" alt="" width="30" class="align-center">
					</a>
				</div>
				<div class="pure-u-1 pure-u-sm-12-24 pure-u-md-12-24 pure-u-lg-7-24">
					<a href="https://twitter.com/saberlegion" class="m-author__twitter js-twitter" data-twitter="saberlegion" target="_blank">
						<h4 class="color-gray normal">Jonathan González</h4>
						<img src="../assets/images/calculator/twitter.png" alt="" width="30" class="align-center">
					</a>
				</div>
			</div>
		</div>
	</div>
</div>
<h3 class="align-center color-purple3">Asesor</h3>


