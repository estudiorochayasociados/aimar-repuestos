<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<?php $data = Promociones_TraerPorId($_GET["promo"]); ?>
				<i class="fa fa-user fa-fw"></i> Suscripciones de &rarr; <b><?php echo $data["TituloPromociones"] ?> </b>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-lg-12">
						<div class="table-responsive">
							<table class="table table-bordered table-hover table-striped">
								<thead>
									<th>Fecha</th>
									<th>Nombre</th>
									<th>Email</th>
									<th>Teléfono</th>
									<th>Dirección</th>
									<th></th>									
								</thead>
								<tbody>
									<?php
									if (isset($_GET["promo"])) {
										Suscriptos_Read($_GET['promo']);
									}
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
if (isset($_GET["borrar"]) && isset($_GET["upd"])) {
	$sql = "UPDATE `contacto` SET `EstadoContacto` = " . $_GET["upd"] . " WHERE `IdContacto` = " . $_GET["borrar"];
	$link = Conectarse();
	$r = mysql_query($sql, $link);
	header("location: index.php?op=verSuscriptos&promo=" . $_GET['promo']);
}

if (isset($_GET["borrar"]) && !isset($_GET["upd"])) {
	$sql = "DELETE FROM cursos WHERE IdCursos = " . $_GET['borrar'];
	$link = Conectarse();
	$r = mysql_query($sql, $link);
	header("location: index.php?op=verSuscriptos&promo=" . $_GET['promo']);
}
?>