
		
			<!-- Content Wrapper. Contains page content -->
			<div class="content-wrapper">
				<!-- Content Header (Page header) -->
				<section class="content-header">
					<h1>
					  Admin
					  <small>Control panel</small>
					</h1>
				</section>

				<!-- Main content -->
				<section class="content">
					<!-- Small boxes (Stat box) -->
					<div class="row">
						<div class="col-lg-4 col-md-4 col-xs-12">
							<div class="small-box" style="background: #26376f;color: rgba(255,255,255,0.75);">
								<div class="inner">
									<h3><?php echo $conteoUsuarios->total; ?></h3>
									<p>Usuarios Registrados</p>
								</div>
								<div class="icon" style="color: rgba(255,255,255,0.75);">
									<i class="ion ion-person-add"></i>
								</div>
								<a href="<?php echo base_url();?>dashboard/usuarios" class="small-box-footer">Más info <i class="fa fa-arrow-circle-right"></i></a>
							</div>
						</div>
						<div class="col-lg-4 col-md-4 col-xs-12">
							<div class="small-box" style="background: #ff2b6d;color: rgba(255,255,255,0.75);">
								<div class="inner">
									<h3><?php echo $contadorGuias->total; ?></h3>
									<p>Documentos Descargados</p>
								</div>
								<div class="icon" style="color: rgba(255,255,255,0.75);">
									<i class="fa fa-cloud-download"></i>
								</div>
								<a href="<?php echo base_url();?>dashboard/guias" class="small-box-footer">Más info <i class="fa fa-arrow-circle-right"></i></a>
							</div>
						</div>
						<div class="col-lg-4 col-md-4 col-xs-12">
							<div class="small-box " style="background: #1A334E;color: rgba(255,255,255,0.75);">
								<div class="inner">
									<h3><?php echo $conteoReproducciones->total; ?></h3>
									<p>Reproducciones de Video</p>
								</div>
								<div class="icon" style="color: rgba(255,255,255,0.75);">
									<i class="fa fa-play-circle-o"></i>
								</div>
								<a href="<?php echo base_url();?>dashboard/videos" class="small-box-footer">Más info <i class="fa fa-arrow-circle-right"></i></a>
							</div>
						</div>
					</div>

					<div class="row">
						<section class="col-lg-6 connectedSortable">
							<div class="box box-warning" style="border-color: #60ace3;">
								<div class="box-header with-border">
									<h3 class="box-title">Usuarios por ciudad</h3>
									<div class="box-tools pull-right">
										<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
										<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
									</div>
								</div>
								<div class="box-body">
									<div class="chart">
										<canvas id="barCharCiudades" style="height:230px"></canvas>
									</div>
								</div><!-- /.box-body -->
							</div><!-- /.box -->
						</section>

						<section class="col-lg-6 connectedSortable">
							<!-- Custom tabs (Charts with tabs)-->
							<div class="box box-warning" style="border-color: #60ace3;">
								<div class="box-header with-border">
									<h3 class="box-title">Usuarios por sector</h3>
									<div class="box-tools pull-right">
										<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
										<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
									</div>
								</div>
								<div class="box-body">
									<div class="chart">
										<canvas id="barCharSectores" style="height:230px"></canvas>
									</div>
								</div><!-- /.box-body -->
							</div><!-- /.box -->
						</section>
					</div>

				<script src="https://code.jquery.com/jquery-2.2.2.min.js" integrity="sha256-36cp2Co+/62rEAAYHLmRCPIych47CvdM+uTBJwSzWjI=" crossorigin="anonymous"></script>
				<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.min.js"></script>
				<script type="text/javascript">
					$(function () {
						var ctx = document.getElementById("barCharCiudades").getContext("2d");
						
						var ciudades = new Array();
						var totales = new Array();

						<?php foreach ($usuariosPorEstado as $key => $value) { ?>
							 ciudades.push("<?php echo $value->ciudad; ?>");
							 totales.push("<?php echo $value->total; ?>");
						<?php } ?>
						
						var data = {
							labels: ciudades,
							datasets: [{
								label: "Usuarios por estado",
								fillColor: "#202d5c",
								strokeColor: "rgba(220,220,220,0.1)",
								highlightFill: "#455A64",
								highlightStroke: "rgba(220,220,220,1)",
								data: totales
							}]
						};

						var myBarChart = new Chart(ctx).Bar(data);

						
					});

					$(function () {
						var ctx = document.getElementById("barCharSectores").getContext("2d");
						var dataArray = new Array();

						<?php foreach ($usuariosPorSector as $key => $value) { ?>
							dataArray.push({
								value: <?php echo $value->total; ?>,
								color: getColor(<?php echo $key; ?>),
								highlight: getHighlight(<?php echo $key; ?>),
								label: "<?php echo $value->sector; ?>"	
							});
						<?php }?>
						
						function getColor(key) {
							if(key==0) {
								return "#182848";
							} else if(key==1) {
								return "#46BFBD";
							} else if(key==2) {
								return "#FDB45C";
							}
						}
						
						function getHighlight(key) {
							if(key==0) {
								return "#455A64";
							} else if(key==1) {
								return "#5AD3D1";
							} else if(key==2) {
								return "#FFC870";
							}
						}
						
						var data = dataArray;
						var myPieChart = new Chart(ctx).Pie(data);
					});

					$(function () {
						var sectorSelect = $(".js-example-basic-single").select2({
							placeholder: "Selecciona un Correo",
							allowClear: true
						});

						sectorSelect.change(function (e) {
							$.ajax({
								type: 'get',
								url: "<?php echo base_url(); ?>avanceUsuario/" + $(".js-example-basic-single").val(),
								success: function(data) {
									if(data.avanceUsuarios[1][0] != undefined) {
										drawTable(data);
										obtenerPorcentaje(data.avanceUsuarios);

									}
								}
							});

          function drawTable(data) {
            var html = "";
            html += "<tr>";
              html += "<td>Videos</td>";
              html += "<td>" + getValue(data.avanceUsuarios[1][0].video) +"<span class='label label-default js-label' style='display: block;width: 40px;margin: 0 auto;font-size: 14px;'>4%</span></td>";
              html += "<td>" + getValue(data.avanceUsuarios[2][0].video) +"<span class='label label-default js-label' style='display: block;width: 40px;margin: 0 auto;font-size: 14px;'>4%</span></td>";
              html += "<td>" + getValue(data.avanceUsuarios[3][0].video) +"<span class='label label-default js-label' style='display: block;width: 40px;margin: 0 auto;font-size: 14px;'>4%</span></td>";
              html += "<td>" + getValue(data.avanceUsuarios[4][0].video) +"<span class='label label-default js-label' style='display: block;width: 40px;margin: 0 auto;font-size: 14px;'>4%</span></td>";
              html += "<td>" + getValue(data.avanceUsuarios[5][0].video) +"<span class='label label-default js-label' style='display: block;width: 40px;margin: 0 auto;font-size: 14px;'>4%</span></td>";
            html += "</tr>";

            html += "<tr>";
              html += "<td>Guias</td>";
              html += "<td>" + getValue(data.avanceUsuarios[1][0].guia) +"<span class='label label-default js-label' style='display: block;width: 40px;margin: 0 auto;font-size: 14px;'>6%</span></td>";
              html += "<td>" + getValue(data.avanceUsuarios[2][0].guia) +"<span class='label label-default js-label' style='display: block;width: 40px;margin: 0 auto;font-size: 14px;'>6%</span></td>";
              html += "<td>" + getValue(data.avanceUsuarios[3][0].guia) +"<span class='label label-default js-label' style='display: block;width: 40px;margin: 0 auto;font-size: 14px;'>6%</span></td>";
              html += "<td>" + getValue(data.avanceUsuarios[4][0].guia) +"<span class='label label-default js-label' style='display: block;width: 40px;margin: 0 auto;font-size: 14px;'>6%</span></td>";
              html += "<td>" + getValue(data.avanceUsuarios[5][0].guia) +"<span class='label label-default js-label' style='display: block;width: 40px;margin: 0 auto;font-size: 14px;'>6%</span></td>";
            html += "</tr>";

            html += "<tr>";
              html += "<td>Evaluaciones</td>";
              html += "<td>" + getValue(data.avanceUsuarios[1][0].examen) +"<span class='label label-default js-label' style='display: block;width: 40px;margin: 0 auto;font-size: 14px;'>10%</span></td>";
              html += "<td>" + getValue(data.avanceUsuarios[2][0].examen) +"<span class='label label-default js-label' style='display: block;width: 40px;margin: 0 auto;font-size: 14px;'>10%</span></td>";
              html += "<td>" + getValue(data.avanceUsuarios[3][0].examen) +"<span class='label label-default js-label' style='display: block;width: 40px;margin: 0 auto;font-size: 14px;'>10%</span></td>";
              html += "<td>" + getValue(data.avanceUsuarios[4][0].examen) +"<span class='label label-default js-label' style='display: block;width: 40px;margin: 0 auto;font-size: 14px;'>10%</span></td>";
              html += "<td>" + getValue(data.avanceUsuarios[5][0].examen) +"<span class='label label-default js-label' style='display: block;width: 40px;margin: 0 auto;font-size: 14px;'>10%</span></td>";
            html += "</tr>";

            $("#tableAvanceUsuarios > tbody").html(html);
          }

							function obtenerPorcentaje(data){
								var sumaTotal =0;
								for(var value in data){
									var porcentaje = 0;
									if (data[value][0].guia !=null) {porcentaje = porcentaje + 6;}
									if (data[value][0].video !=null) {porcentaje = porcentaje + 4;}
									if (data[value][0].calificacion !=null) { porcentaje = porcentaje + ((data[value][0].calificacion * 10) / 100) ;}
									sumaTotal = sumaTotal + porcentaje;
								}
								$("#porcentaje").html("El porcentaje de usuario es: " + sumaTotal + "%");
							}

							function getValue(value) {
								if(value == null) {
									return "<i class='fa fa-times' style='font-size: 25px;color: #ff8080;''></i>";
								}
								else {
									return "<i class='fa fa-check' style='font-size: 25px;color: green;''></i>";
								}
							}
						});
					});
				</script>
						</section><!-- right col -->
					</div><!-- /.row (main row) -->

				</section><!-- /.content -->
			</div><!-- /.content-wrapper --> 


<?php
function getModalidad($idModalidad) {
	switch ($idModalidad) {
		case 1:
			return "Calles Completas";
		break;
		case 2:
			return "Sistemas Integrados de Transporte";
		break;
		case 3:
			return "Desarrollo Orientado al Transporte";
		break;
		case 4:
			return "Gestión de la Demanda";
		break;
		case 5:
			return "Distribución Urbana de Mercancias";
		break;
		default:
			return "";
		break;
	}
}
