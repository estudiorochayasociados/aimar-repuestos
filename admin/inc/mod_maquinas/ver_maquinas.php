<div class="col-lg-12">
	<h4>Paquetes de Viajes</h4>
	<hr/>
	<table class="table  table-bordered table-striped">
		<thead>
			<th>Id</th>
			<th width="60%">Título</th>
			<th>Categoría</th>
			<th>Inicio</th>
			<th>Ajustes</th>
		</thead>
		<tbody>
			<?php
			Maquinas_Read();
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
				$sql = "DELETE FROM `maquinas` WHERE `cod_portfolio` = '$borrar'";
				$r = mysql_query($sql, $link);
				$r2 = mysql_query($sqlImagen, $link);
				header("location: index.php?op=verPaquetes");
			}

			if (isset($_GET["upd"]) && isset($_GET["id"])) {
				$sql = "UPDATE `maquinas` SET `destacado_portfolio` = ". $_GET["upd"] . " WHERE `id_portfolio` = " . $_GET["id"];
				$link = Conectarse();
				$r = mysql_query($sql, $link);
				header("location: index.php?op=verPaquetes");
			}
			?>
		</tbody>
	</table>
</div>

