<div class="col-lg-12">
	<h4>Promociones</h4>
	<div style="float:right">
		Iconografía
				<a href="#" id="tooltip" alt="Activado, pasar a desactivado" title="Activado, pasar a desactivado"><i class="glyphicon glyphicon-ok-circle" style="width: 20px"></i></a>
				<a href="#" id="tooltip3" alt="Desactivado, pasar a activado" title="Desactivado, pasar a activado"><i class="glyphicon glyphicon-ban-circle" style="width: 20px"></i></a>
				<a href="#" id="tooltip1" alt="Modificar" title="Modificar"><i class="glyphicon glyphicon-cog" style="width: 20px"></i></a>
				<a href="#" id="tooltip2" alt="Borrar" title="Borrar"><i class="glyphicon glyphicon-trash" style="width: 20px"></i></a>
			</div>
	<hr/>
	<table class="table  table-bordered table-striped">
		<thead>
			<th>Id</th>
			<th width="60%">Título</th>
			<th width="40%">Tipo</th>
			<th>Visibilidad</th>
			<th>Ajustes</th>
		</thead>
		<tbody>
			<?php
			Promociones_Read();
			?>
		</tbody>
	</table>
</div>

<?php
if (isset($_GET["upd"]) && isset($_GET["borrar"])) {
	$sql = "UPDATE `promociones` SET `EstadoPromociones` = ". $_GET["upd"] . " WHERE `IdPromociones` = " . $_GET["borrar"];
	$link = Conectarse();
	$r = mysql_query($sql, $link);
	header("location: index.php?op=verPromos");
}

if (isset($_GET["borrar"]) && !isset($_GET["upd"]) ) {
	$sql = "DELETE FROM `promociones` WHERE `IdPromociones` =" . $_GET["borrar"];
	$link = Conectarse();
	$r = mysql_query($sql, $link);
	header("location: index.php?op=verPromos");
}
?>