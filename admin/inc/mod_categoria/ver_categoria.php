<div class="col-md-12">
	<h3>Categorías</h3>
	<hr/>
	<table class="table  table-bordered table-hovered table-striped" width="100%">
		<thead>
			<th>Id</th>
			<th>Categoría</th>
			<th>Rubros</th>
			<th>Filtro</th>
 			<th>Ajustes</th>
		</thead>
		<tbody>
			<?php
			Categoria_Read('');
			
			$borrar = isset($_GET["borrar"]) ? $_GET["borrar"] : '';
			
			if ($borrar != '') {
				$sql = "DELETE FROM `categorias` WHERE `id_categoria` = '$borrar'";
				$link = Conectarse_Mysqli();
				$r = mysqli_query($link,$sql);
				header("location: index.php?op=verCategoria");
			}
			?>
		</tbody>
	</table>
</div>
