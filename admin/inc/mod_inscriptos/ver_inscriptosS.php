<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<i class="fa fa-briefcase fa-fw"></i> SOCIOS INSCRIPTOS
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-lg-12">
						<div class="table-responsive">
							<table class="table table-bordered table-hover table-striped">
								<thead>
									<th>Fecha de Inscripción</th>
									<th>Socio</th>
									<th>Nombre</th>
									<th class="hidden-xs">Cargo/Puesto</th>
									<th class="hidden-xs">Email</th>
									<th></th>
								</thead>
								<tbody>
									<?php
									Inscriptos_Read("");
									?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>	

<?php
if (isset($_GET["upd"])) {	
	$sql = "UPDATE `inscriptos_socios` SET `estado_inscriptosocio` = ".$_GET["upd"]." WHERE `id_inscriptosocio` = ".$_GET["borrar"] ;
	$link = Conectarse();
	$r = mysql_query($sql, $link);
	header("location: index.php?op=verInscriptosS");
}
?>

<?php
if (isset($_GET["elim"])) {	
	$sql = "DELETE FROM `inscriptos_socios` WHERE `id_inscriptosocio` = ".$_GET["elim"] ;
	$link = Conectarse();
	$r = mysql_query($sql, $link);
	header("location: index.php?op=verInscriptosS");
}
?>

