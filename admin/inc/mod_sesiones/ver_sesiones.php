<div class="columns">

	<h4>Sesiones de Coaching</h4>
	<hr/>
	<table>
		<thead>
			<th  width="100">Solicitado</th>
			<th width="400">Nombre</th>
			<th width="220">Email</th>
			<th width="120">Teléfono</th>
			<th width="200">Fecha de Sesión</th>
			<th width="100"></th>
		</thead>
		<tbody>
			<?php
			Sesiones_Read();
			?>
		</tbody>
	</table>
</div>

<?php
if (isset($_GET["borrar"])) {
	$sql = "DELETE FROM contacto WHERE IdContacto = ".$_GET['borrar'];
	$link = Conectarse();
	$r = mysql_query($sql, $link);
	header("location: index.php?op=verContacto");
}
?>