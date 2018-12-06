<?php
$random = "albums_".substr(md5(uniqid(rand())), 0, 10);
$cod = $random;
$area = "albums";

if (isset($_POST["agregar"])) {

	$titulo = $_POST['titulo'];
	$categorias = $_POST["categoria"]; 
	$fecha = $_POST["fecha"]; 
	$descripcion = $_POST['descripcion'];

	$count = '';


	foreach ($_FILES['files']['name'] as $f => $name) {     
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
            //Saber tamaño
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


	$sql2 = "
	INSERT INTO `album`
	(`titulo_album`, `categoria_album`, `descripcion_album`, `fecha_album`, `cod_album`) 	
	VALUES 
	('$titulo','$categorias','$descripcion', '$fecha', '$cod')";

	$link2= Conectarse();
	$r2 = mysql_query($sql2, $link2);

	//header("location:index.php?op=verAlbums");
} 
?>

<div class="col-md-12	">
	<h4>Agregar a Albums de Viaje</h4>
	<hr/>
	<form method="post" enctype="multipart/form-data" onsubmit="showLoading()">
		<div class="row" >
			<label class="col-md-4"><b>Título:</b>
				<br/>
				<input type="text" name="titulo" class="form-control" value="<?php echo (isset($_POST['titulo']) ? $_POST['titulo'] : '') ?>" required>
			</label>
			<label class="col-lg-3"><b>Categoría:</b>
				<select name="categoria" class="form-control">
					<option value="" disabled  >-- categorías --</option>
					<option value="1" <?php if(isset($_POST['categoria']) && $_POST["categoria"] == 1) { echo "selected"; } ?>>Internacional</option>
					<option value="2" <?php if(isset($_POST['categoria']) && $_POST["categoria"] == 2) { echo "selected"; } ?>>Nacional</option>
				</select>				
			</label> 
			<label class="col-md-3"><b>Fecha del Viaje:</b>
				<br/>
				<input type="date" name="fecha" class="form-control" value="<?php echo (isset($_POST['fecha']) ? $_POST['fecha'] : '') ?>" required>
			</label>
			<div class="clearfix"></div>			
			<label class="col-md-12"><b>Descripción:</b>
				<br/>
				<textarea name="descripcion" class="form-control" style="height:300px;display:block"><?php echo (isset($_POST['descripcion']) ? $_POST['descripcion'] : '') ?></textarea>
				<script>
				CKEDITOR.replace('descripcion');
				</script>
				<div class="clearfix">
					<br/>
				</div>
				<br>
			</label> 
			<div class="clearfix"></div>			
			<label class="col-md-12"><b>Imágenes:</b>
				<br/>
				<input type="file" id="file" name="files[]" multiple="multiple" accept="image/*" />
			</label>				 
			<div class="clearfix">
				<br/>
			</div>
			<br>
			<div class="col-md-12"> 
				<input type="submit" class="btn btn-primary" name="agregar" value="Subir Album" />
			</div>
		</div>
	</form>
</div>
