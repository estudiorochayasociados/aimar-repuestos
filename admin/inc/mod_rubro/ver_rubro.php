<div class="col-md-12">
	<h3>Rubros</h3>
	<hr/>
	<table class="table  table-bordered table-hovered table-striped" width="100%">
		<thead>
			<th>Id</th>
			<th>Rubro</th>
 			<th>Ajustes</th>
		</thead>
		<tbody>
			<?php
			Rubros_Read('');
			
			$borrar = isset($_GET["borrar"]) ? $_GET["borrar"] : '';
			
			if ($borrar != '') {
				$sql = "DELETE FROM `rubros` WHERE `id_rubros` = '$borrar'";
				$link = Conectarse_Mysqli();
				$r = mysqli_query($link,$sql);
				header("location: index.php?op=verRubro");
			}
			?>
		</tbody>
	</table>
</div>
