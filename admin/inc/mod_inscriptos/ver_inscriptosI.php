<?php
if (isset($_GET["upd"])) {
	$sql = "UPDATE `inscriptos_usuarios` SET `estado_inscripto` = " . $_GET["upd"] . " WHERE `id_inscripto` = " . $_GET["borrar"];
	$link = Conectarse();
	$r = mysql_query($sql, $link);
	header("location: index.php?op=verInscriptosI");
}

if (isset($_GET["elim"])) {
	$sql = "DELETE FROM `inscriptos_socios` WHERE `id_inscriptosocio` = " . $_GET["elim"];
	$link = Conectarse();
	$r = mysql_query($sql, $link);
	header("location: index.php?op=verInscriptosI");
}

if (isset($_GET["email"]) && isset($_GET["archivo"])) {
	$asunto = "Te reenviamos tu invitación a la charla de Massaccesi y Pipino";
	$archivo = $_GET["archivo"];
	$email = $_GET["email"];
	$mensaje = "
Te estamos pasando nuevamente tu invitación para el evento de Mario Massaccesi y Ricardo Pipino.
<br>Recorda que necesitas tener la entrada para poder ingresar a la charla.
<br/>Imprimila haciendo <a href='http://127.0.0.1/Acorca/Massaccesi/" . $archivo . "'>click aquí</a>.
";

	Enviar_User($asunto, $mensaje, $email);
	header("location: index.php?op=verInscriptosI");
}
?>

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<i class="fa fa-briefcase fa-fw"></i> USUARIOS INSCRIPTOS
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-lg-12">
						<div class="table-responsive">
							<table class="table table-bordered table-hover table-striped">
								<thead>
									<th>Fecha de Inscripción</th>
									<th>Nombre</th>
									<th>Empresa</th>
									<th class="hidden-xs" >Teléfono</th>
									<th>Celular</th>
									<th class="hidden-xs">Email</th>
									<th class="hidden-xs">Localidad</th>
									<th class="hidden-xs" >Provincia</th>
									<th></th>
								</thead>
								<tbody>
									<?php
									Usuarios_Inscriptos_Read("");
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
