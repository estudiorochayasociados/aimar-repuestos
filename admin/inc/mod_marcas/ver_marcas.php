<div class="col-md-12">
	<h3>Marcas</h3>
	<hr/>
	<table class="table  table-bordered table-hovered table-striped" width="100%">
		<thead>
 			<th>Marcas</th> 
 			<th> </th>
		</thead>
		<tbody>
			<?php
		Marcas_Read('');

		$borrar = isset($_GET["borrar"]) ? $_GET["borrar"] : '';

		if ($borrar != '') {
			$sql = "DELETE FROM `marcas_autos` WHERE `id_marcas` = '$borrar'";
			$sqlModelos = "DELETE FROM `modelos_autos` WHERE `marca_autos` = '$borrar'";
			$link = Conectarse_Mysqli();
			$r = mysqli_query($link, $sql);
			$r = mysqli_query($link, $sqlModelos);
			header("location: index.php?op=verMarcas");
		}
		?>
		</tbody>
	</table>
</div>
