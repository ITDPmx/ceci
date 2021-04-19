
		
			<!-- Content Wrapper. Contains page content -->
			<div class="content-wrapper">
				<!-- Content Header (Page header) -->
				<section class="content-header">
					<h1>DashboardADMIN<small>Control panel</small></h1>
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
					<hr>						
					<div class="row">			

						<!-- right col (We are only adding the ID to make the widgets sortable)-->

						<section class="col-lg-12 connectedSortable">
							<div class="box box-warning" style="border-color:#26376f;">
		            <div class="box-header with-border">
		              <h3 class="box-title">Usuarios </h3>
		              <a class="btn btn-flat btn-primary" href="<?php echo base_url(); ?>exportar" title="Descargar usuarios" download style="float:right;"><i class="fa fa-download" style="margin-right: 15px;"></i>Descargar usuarios</a>
		            </div>
		            <!-- /.box-header -->
		            <div class="box-body table-responsive no-padding">
		              <table class="table table-hover">
		                <tbody>
			                <tr>
				                <th>Nombre</th>
				                <th>Estado</th>
				                <th>Ciudad</th>
				                <th>Sector</th>
				                <th>Dependencia</th>
				                <th>Email</th>
			                </tr>
			                <?php foreach($usuariosLista as $row){ ?>
			                	<tr>
			                		<td><?php echo $row->nombre; ?></td>
			                		<td><?php echo $row->estado; ?></td>
			                		<td><?php echo $row->ciudad; ?></td>
			                		<td><?php echo $row->sector; ?></td>
			                		<td><?php echo $row->dependencia; ?></td>
			                		<td><?php echo $row->email; ?></td>
			                	</tr>
			                <?php }; ?>
		              </tbody></table>
		            </div>
		          </div>
		        </section>
						</div>
						<div class="row">
							<section class="col-lg-12 connectedSortable">
								<div class="box box-warning" style="border-color:#26376f;">
			            <div class="box-header with-border">
			              <h3 class="box-title">Progreso por Usuario</h3>
			              <select class="js-example-basic-single">
								<option selected disabled>Selecciona un usuario</option>
								<?php foreach($usuariosLista as $row){ ?>
									<option value="<?php echo $row->id_usuario;?>"><?php echo $row->email; ?></option>
								<?php }; ?>
			              </select>
			            </div>
			            <div class="box-body table-responsive no-padding">
			            	<table class="table table-hover" id="tableAvanceUsuarios">
			            		<thead>
									<tr>
										<th style="text-align: center;">Herramientas</th>
										<th style="text-align: center;">Calles completas</th>
										<th style="text-align: center;">Sistema integrado de transporte</th>
										<th style="text-align: center;">Desarrollo orientado al transporte</th>
										<th style="text-align: center;">Gestion de la movilidad</th>
										<th style="text-align: center;">Distribucion urbana de mercancias</th>	
									</tr>
								</thead>
								<tbody style="text-align:center;">
			            <tr>
										<td colspan="6">Selecciona un usuario</td>
			            </tr>
			           </tbody>
			            	</table>
			            </div>
			           </div>
							</section>
						</div>
						<div class="row">
						  <div class="col-xs-12">
						    <div class="clearfix">
						      <h2 class="pull-left">Progreso del Usuario</h2>
						      <h2 class="pull-right" id="porcentaje"></h2>
						    </div>
							<div class="progress">
								<div class="progress-bar progress-bar-warning" style="background:#1A334E;" id="porcentaje_bar"></div>
							</div>
						   </div>
						</div>
						
				<script src="https://code.jquery.com/jquery-2.2.2.min.js" integrity="sha256-36cp2Co+/62rEAAYHLmRCPIych47CvdM+uTBJwSzWjI=" crossorigin="anonymous"></script>
				<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.min.js"></script>
				<script type="text/javascript">

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
              html += "<td>" + getValue(data.avanceUsuarios[1][0].calificacion) +"<span class='label label-default js-label' style='display: block;width: 40px;margin: 0 auto;font-size: 14px;'>10%</span></td>";
              html += "<td>" + getValue(data.avanceUsuarios[2][0].calificacion) +"<span class='label label-default js-label' style='display: block;width: 40px;margin: 0 auto;font-size: 14px;'>10%</span></td>";
              html += "<td>" + getValue(data.avanceUsuarios[3][0].calificacion) +"<span class='label label-default js-label' style='display: block;width: 40px;margin: 0 auto;font-size: 14px;'>10%</span></td>";
              html += "<td>" + getValue(data.avanceUsuarios[4][0].calificacion) +"<span class='label label-default js-label' style='display: block;width: 40px;margin: 0 auto;font-size: 14px;'>10%</span></td>";
              html += "<td>" + getValue(data.avanceUsuarios[5][0].calificacion) +"<span class='label label-default js-label' style='display: block;width: 40px;margin: 0 auto;font-size: 14px;'>10%</span></td>";
            html += "</tr>";

            $("#tableAvanceUsuarios > tbody").html(html);
          }

							function getValue(value) {
								if(value == null) {
									return "<i class='fa fa-times' style='font-size: 25px;color: #ff8080;''></i>";
								} else {
									return "<i class='fa fa-check' style='font-size: 25px;color: green;''></i>";
								}
							}


							function getValueEval(value) {
								console.log(value);
								if(value == null) {
									return "<i class='fa fa-times' style='font-size: 25px;color: #ff8080;''></i>";
								} else {
									if(value >= 80) {
										return "<i class='fa fa-check' style='font-size: 25px;color: green;''></i>";
									} else {
										return "<i class='fa fa-times' style='font-size: 25px;color: #ff8080;''></i>";
									}
								}
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
								$("#porcentaje").html(sumaTotal +"%");
								$("#porcentaje_bar").css("width", sumaTotal);
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
