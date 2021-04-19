<section class="m-resumen" id="summaryPdf">
	<section class="m-resumen__page align-center" id="summaryTitle">
		<div class="container">
			<h2 class="color-purple1">Resumen</h2>
			<h3 class="color-purple3 normal">Presupuesto de Obra</h3>
		</div>
	</section>
	<section class="m-resumen__proyecto" id="summaryProject">
		<div class="container">
			<h3 class="color-purple3">Proyecto</h3>
			<hr>
			<div class="pure-g">
				<div class="pure-u-1 pure-u-sm-4-24"></div>
				<div class="pure-u-1 pure-u-sm-20-24">
					<div class="m-resumen__title">
						<h3 class="m-resumen__title-infraestructura js-infraestructura"></h3>
						<span class="m-resumen__title-estado js-estado"></span>-<span class="m-resumen__title-municipio js-municipio"></span>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section class="m-resumen__costos" id="summaryCost">
		<div class="container">
			<h3 class="color-purple3">Resumen de Costos</h3>
			<hr>
			<div class="pure-g">
				<div class="pure-u-1 pure-u-sm-3-24 pure-u-md-4-24 pure-u-lg-6-24"></div>
				<div class="pure-u-1 pure-u-sm-18-24 pure-u-md-16-24 pure-u-lg-12-24">
					<div class="m-resumen__costos-table">
						<table>
							<tbody>
								<tr>
									<td class="m-resumen__costos__concepto normal">Preliminares</td>
									<td class="m-resumen__costos__costo js-input-preliminares"></td>
								</tr>
								<tr>
									<td class="m-resumen__costos__concepto normal">Pavimentos</td>
									<td class="m-resumen__costos__costo js-input-pavimentos"></td>
								</tr>
								<tr>
									<td class="m-resumen__costos__concepto normal">Banquetas y guarniciones</td>
									<td class="m-resumen__costos__costo js-input-banquetas"></td>
								</tr>
								<tr>
									<td class="m-resumen__costos__concepto normal">Alcantarillado</td>
									<td class="m-resumen__costos__costo js-input-alcantarillado"></td>
								</tr>
								<tr>
									<td class="m-resumen__costos__concepto normal">Señalización de Obra</td>
									<td class="m-resumen__costos__costo js-input-sen-obra"></td>
								</tr>
								<tr>
									<td class="m-resumen__costos__concepto normal">Señalización Horizontal</td>
									<td class="m-resumen__costos__costo js-input-sen-horizontal"></td>
								</tr>
								<tr>
									<td class="m-resumen__costos__concepto normal">Señalización Vertical</td>
									<td class="m-resumen__costos__costo js-input-sen-vertical"></td>
								</tr>
								<tr>
									<td class="m-resumen__costos__concepto normal">Dispositivos de Control de Tránsito</td>
									<td class="m-resumen__costos__costo js-input-dispositivos"></td>
								</tr>
								<tr>
									<td class="m-resumen__costos__concepto normal">Mobiliario</td>
									<td class="m-resumen__costos__costo js-input-mobiliario"></td>
								</tr>
								<tr>
									<td class="m-resumen__costos__concepto-total normal">Subtotal de Obra</td>
									<td class="m-resumen__costos__costo-total js-input-subtotal-obra"></td>
								</tr>
								<tr>
									<td class="m-resumen__costos__concepto-total normal">I.V.A.</td>
									<td class="m-resumen__costos__costo-total js-input-iva"></td>
								</tr>
								<tr>
									<td class="m-resumen__costos__concepto-total normal">Subtotal</td>
									<td class="m-resumen__costos__costo-total js-subtotal"></td>
								</tr>
							</tbody>
						</table>
						<h3 class="color-gray normal">Costos Adicionales</h3>
						<table class="m-resumen__costos-adicionales">
							<tbody>
								<tr>
									<td class="m-resumen__costos__concepto-total normal">Proyecto Ejecutivo</td>
									<td class="m-resumen__costos__costo-total js-input-proy-ejecutivo"></td>
								</tr>
								<tr>
									<td class="m-resumen__costos__concepto-total normal">Supervisión de Obra</td>
									<td class="m-resumen__costos__costo-total js-input-sup-obra"></td>
								</tr>
								<tr>
									<td class="m-resumen__costos__concepto-total normal">Impuesto del cinco al millar</td>
									<td class="m-resumen__costos__costo-total js-input-impuesto-millar"></td>
								</tr>
								<tr>
									<td class="m-resumen__costos__concepto-total bold">TOTAL</td>
									<td class="m-resumen__costos__costo-total js-input-total"></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="pure-u-1 pure-u-sm-3-24 pure-u-md-4-24 pure-u-lg-6-24"></div>
			</div>
			<br>
			<div class="align-center">
				<a download class="pure-button m-button bg-purple3 color-white js-summary-csv">Descargar resumen detallado</a>
			</div>
		</div>
	</section>
	<section class="m-resumen__datos" id="summaryData" style="outline-color: transparent; outline:0 !important;">
		<div class="container" style="outline-color: transparent; outline:0 !important;">
			<h3 class="color-purple3">Datos ingresados</h3>
			<hr>
			<div class="pure-g">
				<div class="pure-u-1 pure-u-sm-3-24 pure-u-md-4-24 pure-u-lg-6-24"></div>
				<div class="pure-u-1 pure-u-sm-18-24 pure-u-md-16-24 pure-u-lg-12-24">
					<div class="m-resumen__datos-table">
						<table>
							<tbody>
								<tr>
									<td class="m-resumen__datos-pregunta normal">Kilómetros del proyecto</td>
									<td class="m-resumen__datos-respuesta normal js-kilometros"></td>
								</tr>
								<tr>
									<td class="m-resumen__datos-pregunta normal">Ancho del arroyo vehicular</td>
									<td class="m-resumen__datos-respuesta normal js-arroyo"></td>
								</tr>
								<tr>
									<td class="m-resumen__datos-pregunta normal">Carriles de circulación efectivos</td>
									<td class="m-resumen__datos-respuesta normal js-carilles"></td>
								</tr>
								<tr>
									<td class="m-resumen__datos-pregunta normal">Postes a remover por kilómetro</td>
									<td class="m-resumen__datos-respuesta normal js-postes"></td>
								</tr>
								<tr>
									<td class="m-resumen__datos-pregunta normal">Intersecciones</td>
									<td class="m-resumen__datos-respuesta normal js-intersecciones"></td>
								</tr>
								<tr>
									<td class="m-resumen__datos-pregunta normal">Intersecciones con infraestructura accesible</td>
									<td class="m-resumen__datos-respuesta normal js-inter-infra"></td>
								</tr>
								<tr>
									<td class="m-resumen__datos-pregunta normal">Kilómeros de ampliación de banquetas</td>
									<td class="m-resumen__datos-respuesta normal js-km-ampliacion"></td>
								</tr>
								<tr>
									<td class="m-resumen__datos-pregunta normal">Ampliación de banqueta</td>
									<td class="m-resumen__datos-respuesta normal js-mt-ampliacion"></td>
								</tr>
								<tr>
									<td class="m-resumen__datos-pregunta normal">Intersecciones semaforizadas</td>
									<td class="m-resumen__datos-respuesta normal js-inter-semaforizadas"></td>
								</tr>
								<tr>
									<td class="m-resumen__datos-pregunta normal">Biciestacionamientos</td>
									<td class="m-resumen__datos-respuesta normal js-biciestacionamientos"></td>
								</tr>
								<tr>
									<td class="m-resumen__datos-pregunta normal">¿Costo de Proyecto Ejecutivo?</td>
									<td class="m-resumen__datos-respuesta normal js-proy-ejecutivo"></td>
								</tr>
								<tr>
									<td class="m-resumen__datos-pregunta normal">¿Costo de Supervisión de Obra?</td>
									<td class="m-resumen__datos-respuesta normal js-sup-obra"></td>
								</tr>
								<tr>
									<td class="m-resumen__datos-pregunta normal">¿Impuesto del cinco al millar?</td>
									<td class="m-resumen__datos-respuesta normal js-impuesto-millar"></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="pure-u-1 pure-u-sm-3-24 pure-u-md-4-24 pure-u-lg-6-24"></div>
			</div>
			<br>
			<div class="align-center">
				<a href="/calculadora" class="pure-button m-button bg-purple3 color-white js-change-data">Cambiar Datos</a>
			</div>
		</div>
	</section>
	<section class="m-resumen__graficas js-summary-charts" id="summaryCharts">
		<div class="container">
			<h3 class="color-purple3">Comparativa</h3>
			<hr>
			<div class="pure-g">
				<div class="pure-u-1">
					<div class="m-resumen__graficas-egresos js-chart-egresos" id="Egresos"></div>
				</div>
			</div>
			<div class="pure-g">
				<div class="pure-u-1">
					<div class="m-resumen__graficas-ingresos js-chart-ingresos" id="Ingresos"></div>
				</div>
			</div>
		</div>
	</section>
</section>
<div class="m-author">
	<div class="m-author__sliders js-author-slide">
		<div class="m-author__sliders-slide">
			<h3 class="align-center color-purple3">Autoras</h3>
			<div class="pure-g align-center">
				<div class="pure-u-1 pure-u-sm-0-24 pure-u-md-0-24 pure-u-lg-5-24"></div>
				<div class="pure-u-1 pure-u-sm-12-24 pure-u-md-12-24 pure-u-lg-7-24">
					<a href="https://twitter.com/YazAPie" class="m-author__twitter" target="_blank">
						<h4 class="color-gray normal">Yazmín Viramontes</h4>
						<img src="../assets/images/calculator/twitter.png" alt="" width="30" class="align-center">
					</a>
				</div>
				<div class="pure-u-1 pure-u-sm-12-24 pure-u-md-12-24 pure-u-lg-7-24">
					<a href="https://twitter.com/bikennia" class="m-author__twitter" target="_blank">
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
					<a href="https://twitter.com/alexdom07" class="m-author__twitter" target="_blank">
						<h4 class="color-gray normal">Alejandro Domínguez</h4>
						<img src="../assets/images/calculator/twitter.png" alt="" width="30" class="align-center">
					</a>
				</div>
				<div class="pure-u-1 pure-u-sm-12-24 pure-u-md-12-24 pure-u-lg-7-24">
					<a href="https://twitter.com/saberlegion" class="m-author__twitter" target="_blank">
						<h4 class="color-gray normal">Jonathan González</h4>
						<img src="../assets/images/calculator/twitter.png" alt="" width="30" class="align-center">
					</a>
				</div>
			</div>
		</div>
	</div>
</div>