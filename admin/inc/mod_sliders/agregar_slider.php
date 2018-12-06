<?php
$random = rand(0, 10000000);
if (isset($_POST["agregar"])) {
	if ($_POST["titulo"] != '') { 

		$imgInicio = "";
		$destinoImg = "";
		$prefijo = substr(md5(uniqid(rand())), 0, 6);
		$imgInicio = $_FILES["img"]["tmp_name"];
		$tucadena = $_FILES["img"]["name"];
		$partes = explode(".", $tucadena);
		$dominio = $partes[1];

		if ($dominio != '') {
			$destinoImg = "archivos/slider/" . $prefijo . "." . $dominio;
			$destinoFinal = "../archivos/slider/" . $prefijo . "." . $dominio;
			move_uploaded_file($imgInicio, $destinoFinal);
			chmod($destinoFinal, 0777);
			$destinoRecortado = "../archivos/slider/recortadas/a_" . $prefijo . "." . $dominio;
			$destinoRecortadoFinal = "archivos/slider/recortadas/a_" . $prefijo . "." . $dominio;
            //Saber tamaño
			$tamano = getimagesize($destinoFinal);
			$tamano1 = explode(" ", $tamano[3]);
			$anchoImagen = explode("=", $tamano1[0]);
			$anchoFinal = str_replace('"', "", trim($anchoImagen[1]));
			if ($anchoFinal >= 1920) {
				@EscalarImagen("1920", "0", $destinoFinal, $destinoRecortado, "90");
			} else {
				@EscalarImagen($anchoFinal, "0", $destinoFinal, $destinoRecortado, "90");
			}
			unlink($destinoFinal);
		} else {
			$destinoRecortadoFinal = '';
		} 

		$titulo = $_POST["titulo"];
		$subtitulo = $_POST["subtitulo"];
		$link = $_POST["link"];
		$tipo = $_POST["tipo"];
		
		$sql = "
		INSERT INTO `sliderbase`
		(`TituloSlider`,`SubtituloSlider`, `ImgSlider`,`LinkSlider`,`TipoSlider`, `FechaSlider`) 			
		VALUES 
		('$titulo','$subtitulo','$destinoRecortadoFinal', '$link', '$tipo', NOW())";
		$link = Conectarse();
		$r = mysqli_query($link,$sql);

		header("location:index.php?op=verSlider");
	} else {
		echo "<br/><center><span class='col-md-11 button' style='background:#872F30'>* Todos los datos son obligatorios</span></center>";
	}
}
?>

<div class="col-lg-12">
	<h4>Slider</h4>
	<hr/>
	<form method="post" enctype="multipart/form-data">

		<label class="col-md-6">Título:
			<br/>
			<input type="text" name="titulo" value="<?php echo (isset($_POST['titulo']) ? $_POST['titulo'] : '') ?>" class="form-control" size="50">
		</label>
		<label class="col-md-6">Subtítulo:
			<br/>
			<input type="text" name="subtitulo" value="<?php echo (isset($_POST['subtitulo']) ? $_POST['subtitulo'] : '') ?>" class="form-control" size="50">
		</label>
		<label class="col-md-6">Tipo Slider:
			<br/>
			<select name="tipo" class="form-control">
				<option value="inicio">inicio</option> 
				<option value="marcas">marcas</option> 
			</select>
		</label>
		<label class="col-md-6">Link:
			<br/>
			<div class="form-group">
				<label class="sr-only" for="exampleInputAmount">Link:</label>
				<div class="input-group">
					<div class="input-group-addon">http://aimarrepuestos.com.ar/</div>
					<input type="text" class="form-control" id="exampleInputAmount" name="link"  value="<?php echo (isset($_POST['link']) ? $_POST['link'] : '') ?>"  >						
				</div>
			</div>
		</label>
		<div class="clearfix"></div>
		<label class="col-md-12">Imagen:
			<input type="file" name="img" class="form-control" />
		</label>
		<div class="clearfix"></div>
		<br/>
		<div class="col-md-4">
			<input type="submit" class="btn btn-primary" name="agregar" value="Crear Slider" />
		</div>
	</form>
</div>
