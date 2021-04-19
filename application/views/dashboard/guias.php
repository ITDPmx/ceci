
		
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

					<div class="row">
						<section class="col-xs-12 col-md-6 col-lg-6 connectedSortable">
							<div class="box box-info" style="border-color: #ff2b6d;">
								<div class="box-header">
									<h3 class="box-title">Descargas de guías por modalidad</h3>
								</div>
								<!-- /.box-header -->
								<div class="box-body table-responsive no-padding">
									<table class="table table-hover">
										<tbody>
											<tr>
												<th style="width: 20px">#</th>
												<th>Modalidad</th>
												<th style="width: 60px; text-align:center;">Total</th>
											</tr>
											<?php
												$sum =0; 
												foreach($descargas as $key => $row) {
													$sum += $row->total;
												}
											?>
											<?php foreach($descargas as $key => $row){ ?>
											<tr>
												<td><?php echo $key+1;?></td>
												<td>
													<?php echo getModalidad($row->id_guia); ?>
													<div class="progress progress-xs">
														<div class="progress-bar progress-bar-info" style="width: <?php echo $row->total*100/$sum; ?>%; background:#ff2b6d;"></div>
													</div>
												</td>
												<td style="text-align:center;"><span class="badge" style="background:#ff2b6d;font-size: 16px;"><?php echo $row->total; ?></span></td>
											</tr>
											<?php } ?>
										</tbody>
									</table>
								</div>
								<!-- /.box-body -->
							</div>
						</section>

						<section class="col-xs-12 col-md-6 col-lg-6 connectedSortable">
							<div class="box box-info" style="border-color: #ff2b6d;">
								<div class="box-header">
									<h3 class="box-title">Descargas de guías por usuario</h3>
								</div>
								<!-- /.box-header -->
								<div class="box-body table-responsive no-padding">
									<table class="table table-hover">
										<thead>
											<tr>
												<th style="width: 10px">#</th>
												<th>Usuario</th>
												<th style="text-align:center;">CC</th>
												<th style="text-align:center;">SIT</th>
												<th style="text-align:center;">DOT</th>
												<th style="text-align:center;">GD</th>
												<th style="text-align:center;">DUM</th>
											</tr>
										</thead>
										<tbody>
											<?php foreach($descargasUsuarios as $key => $row){ ?>
												<tr>
													<td><?php echo $row->id_usuario;?></td>
													<td><?php echo $row->email;?></td>
													<td style="text-align:center;"><span class="badge bg-aqua" style="font-size:18px;background:#ff2b6d !important;"><?php echo $row->mod1; ?></span></td>
													<td style="text-align:center;"><span class="badge bg-aqua" style="font-size:18px;background:#ff2b6d !important;"><?php echo $row->mod2; ?></span></td>
													<td style="text-align:center;"><span class="badge bg-aqua" style="font-size:18px;background:#ff2b6d !important;"><?php echo $row->mod3; ?></span></td>
													<td style="text-align:center;"><span class="badge bg-aqua" style="font-size:18px;background:#ff2b6d !important;"><?php echo $row->mod4; ?></span></td>
													<td style="text-align:center;"><span class="badge bg-aqua" style="font-size:18px;background:#ff2b6d !important;"><?php echo $row->mod5; ?></span></td>
												</tr>
											<?php } ?>
										</tbody>
									</table>
								</div>
								<!-- /.box-body -->
							</div>
						</section>
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
