<div class="col-lg-12">
	<h4>Albums de Viajes</h4>
	<hr/>
	<table class="table  table-bordered table-striped">
		<thead>
			<th>Id</th>
			<th width="60%">Título</th>
			<th>Categoría</th>
 			<th>Ajustes</th>
		</thead>
		<tbody>
			<?php
			Albums_Read();
			$borrar = isset($_GET["borrar"]) ? $_GET["borrar"] : '';

			if ($borrar != '') {
				$link = Conectarse();

				$imagen = Imagenes_TraerPorId($borrar);
				$imagenes = explode("-",$imagen);
				$countImagen = (count($imagenes))-1;
				
				for ($i = 0;$i < $countImagen;$i++) {
					unlink("../".$imagenes[$i]);
				} 
				$sqlImagen = "DELETE FROM `imagenes` WHERE `codigo` = '$borrar'";
				$sql = "DELETE FROM `album` WHERE `cod_album` = '$borrar'";
				$r = mysql_query($sql, $link);
				$r2 = mysql_query($sqlImagen, $link);
				header("location: index.php?op=verAlbums");
			}
			?>
		</tbody>
	</table>
</div>

