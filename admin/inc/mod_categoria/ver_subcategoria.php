<div class="col-md-12">
	<h3>Subcategorías</h3>
	<hr/>
	<table class="table  table-bordered table-hovered table-striped" width="100%">
		<thead>
			<th>Id</th>
			<th>Subcategoría</th>
			<th>Categoría</th>
 			<th>Ajustes</th>
		</thead>
		<tbody>
			<?php
			Subcategoria_Read('');
			
			$borrar = isset($_GET["borrar"]) ? $_GET["borrar"] : '';
			
			if ($borrar != '') {
				$sql = "DELETE FROM `subcategorias` WHERE `id_subcategoria` = '$borrar'";
				$link = Conectarse_Mysqli();
				$r = mysqli_query($link,$sql);
				header("location:index.php?op=verSubcategoria");
			}
			?>
		</tbody>
	</table>
</div>
