<div class="columns">

	<h4>Cursos</h4>
	<hr/>
	<table>
		<thead>
			<th>Id</th>
			<th width="90%">Título</th>
			<th width="10%">Ajustes</th>
		</thead>
		<tbody>
			<?php
			Cursos_Read();
			?>
		</tbody>
	</table>
</div>

<?php
if (isset($_GET["borrar"])) {
	$sql = "DELETE FROM cursos WHERE IdCursos = " . $_GET['borrar'];
	$link = Conectarse();
	$r = mysql_query($sql, $link);
	header("location: index.php?op=verCursos");
}

if (isset($_GET["es"]) && isset($_GET["estado"])) {
	Actualizar_Estado($_GET["es"], $_GET["estado"]);
	header("location: index.php?op=verCursos");
}
?>