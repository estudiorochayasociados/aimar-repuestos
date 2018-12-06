<?php
$id = isset($_GET['id']) ? $_GET['id'] : '';

$area = "albums";


if ($id != '') {
	$data = Albums_TraerPorId($id);	
	$cod = $data["cod_album"];
	$imagen = Imagenes_TraerPorId($data["cod_album"]);
	$imagenes = explode("-",$imagen);
	$count = '';
}

if (isset($_POST['agregar'])) {
 	$titulo = $_POST['titulo'];
 	$categoria = $_POST["categoria"];
 	$fecha = $_POST['fecha']; 
	$descripcion = $_POST['descripcion'];
 
	foreach ($_FILES['files']['name'] as $f => $name) {     
		if(!empty($_FILES["files"]["tmp_name"][$f])) {
			$imgInicio = $_FILES["files"]["tmp_name"][$f];
			$tucadena = $_FILES["files"]["name"][$f];
			$partes = explode(".", $tucadena);
			$dom = (count($partes) - 1);
			$dominio = $partes[$dom];
			$prefijo = rand(0, 10000000);

			if ($dominio != '') {
				$destinoImg = "archivos/albums/" . $prefijo . "." . $dominio;
				$destinoFinal = "../archivos/albums/" . $prefijo . "." . $dominio;
				move_uploaded_file($imgInicio, $destinoFinal);
				chmod($destinoFinal, 0777);	
				$destinoRecortado = "../archivos/albums/recortadas/a_" . $prefijo . "." . $dominio;
				$destinoRecortadoFinal = "archivos/albums/recortadas/a_" . $prefijo . "." . $dominio;

				$tamano = getimagesize($destinoFinal);
				$tamano1 = explode(" ", $tamano[3]);
				$anchoImagen = explode("=", $tamano1[0]);
				$anchoFinal = str_replace('"', "", trim($anchoImagen[1]));
				if ($anchoFinal >= 900) {
					@EscalarImagen("900", "0", $destinoFinal, $destinoRecortado, "70");
				} else {
					@EscalarImagen($anchoFinal, "0", $destinoFinal, $destinoRecortado, "70");
				}
				unlink($destinoFinal);
			}	 

			$count++;  

		$sql = "INSERT INTO `imagenes`(`ruta`, `codigo`, `area`) VALUES ('$destinoRecortadoFinal','$cod', '$area')";
			$link = Conectarse();
			$r = mysql_query($sql, $link);
		}
	}

	$sql2 = "

	UPDATE `album` 
	SET 
	`titulo_album`= '$titulo',
	`descripcion_album`= '$descripcion',
	`categoria_album`= '$categoria',
	`fecha_album`= '$fecha'
	WHERE 
	`id_album`= '$id'
	";
	$link2 = Conectarse();
	$r2 = mysql_query($sql2, $link2);

	header("location: index.php?op=modificarAlbums&id=$id");
}
?>
<div class="col-md-12">
	<hr/>
	<form method="post" enctype="multipart/form-data" onsubmit="showLoading()">
		<div class="row" >
			<div class="row" >
				<label class="col-md-6"><b>Título:</b>
					<br/>
					<input type="text" name="titulo" class="form-control" value="<?php echo (isset($data['titulo_album']) ? $data['titulo_album'] : '') ?>" required>
				</label>
				<label class="col-lg-3"><b>Categoría:</b>
					<select name="categoria" class="form-control">
						<option value="" disabled  >-- categorías --</option>
						<option value="1" <?php if(isset($data['categoria_album']) && $data["categoria_album"] == 1) { echo "selected"; } ?>>Internacional</option>
						<option value="2" <?php if(isset($data['categoria_album']) && $data["categoria_album"] == 2) { echo "selected"; } ?>>Nacional</option>
					</select>				
				</label>  

				<label class="col-md-3"><b>Fecha del Viaje:</b>
					<br/>
					<input type="date" name="fecha" class="form-control" value="<?php echo (isset($data['fecha_album']) ? $data['fecha_album'] : '') ?>" required>
				</label>
				<div class="clearfix"></div>
				<label class="col-md-12"><b>Descripción:</b>
					<br/>
					<textarea name="descripcion" class="form-control"    style="height:300px;display:block"><?php echo (isset($data['descripcion_album']) ? $data['descripcion_album'] : '') ?></textarea>
					<script>
					CKEDITOR.replace('descripcion');
					</script>
					<div class="clearfix">
						<br/>
					</div>
					<br>
				</label> 
				<div class="clearfix"></div>
				<div class="col-md-12"><br/>
					<div class="row">
						<?php 
						$countImagen = (count($imagenes))-1;
						for ($i = 0;$i < $countImagen;$i++) {
							echo '<div class="col-md-2 col-xs-3" style="margin-bottom:65px;"><img src="../'.$imagenes[$i].'" style="height:200px;overflow:hidden" class="thumbnail img-responsive">
							<a class="btn-primary btn btn-block" href="index.php?op=modificarAlbums&id='.$id.'&borrar='.$imagenes[$i].'">BORRAR IMAGEN</a></div>';
						} 
						?>
					</div>
				</div>
				<label class="col-md-12"> 
					Imágenes:<br/><br/>
					<input type="file" id="file" name="files[]" multiple="multiple" accept="image/*" />
				</label>				 
				<div class="clearfix">				
					<div class="clearfix"></div><br/>
					<label class="col-md-12">
						<input type="submit" class="btn btn-primary " name="agregar" value="Modificar Album" />
					</label>
				</div>
			</div>
		</form>
	</div>

	<?php

	$borrar = isset($_GET["borrar"]) ? $_GET["borrar"] : '';

	if ($borrar != '') {
		unlink("../".$borrar);
		$sql = "DELETE FROM `imagenes` WHERE `ruta` = '$borrar'";
		$link = Conectarse();
		$r = mysql_query($sql, $link);
		header("location: index.php?op=modificarAlbums&id=$id");
	}

	?>




