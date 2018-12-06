<?php
$id = isset($_GET['id']) ? $_GET['id'] : '';

if ($id != '') {
	$data = Slider_TraerPorId($id);
	$titulo = isset($data["TituloSlider"]) ? $data["TituloSlider"] : '';
	$link = isset($data["LinkSlider"]) ? $data["LinkSlider"] : '';
	$tipo = isset($data["TipoSlider"]) ? $data["TipoSlider"] : '';
	$img = isset($data["ImgSlider"]) ? $data["ImgSlider"] : '';
}

if (isset($_POST['agregar'])) {
	if(!empty($_FILES["img"]["tmp_name"])) {
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
	} else {
		$destinoRecortadoFinal = $img;
	}

	$titulo = $_POST["titulo"];
	$subtitulo = $_POST["subtitulo"];
	$link = $_POST["link"];
	$tipo = $_POST["tipo"];

	$sql = "
	UPDATE `sliderbase` 
	SET 			
	`TituloSlider`= '$titulo',
	`SubtituloSlider`='$subtitulo',
	`ImgSlider`='$destinoRecortadoFinal',
	`TipoSlider`='$tipo',
	`LinkSlider`='$link'
	WHERE `IdSlider`= '$id'";
	$link = Conectarse();
	$r = mysqli_query($link,$sql);

	header("location:index.php?op=verSlider");
}
?>

<div class="col-lg-12">
	<h4>Modificar &rarr; <?php echo $data["TituloSlider"]; ?></h4>
	<hr/>
	<form method="post" enctype="multipart/form-data">
		<label class="col-md-6">Título:
			<br/>
			<input type="text" name="titulo" value="<?php echo (isset($data['TituloSlider']) ? $data['TituloSlider'] : '') ?>" class="form-control" size="50">
		</label>
		<label class="col-md-6">Subtítulo:
			<br/>
			<input type="text" name="subtitulo" value="<?php echo (isset($data['SubtituloSlider']) ? $data['SubtituloSlider'] : '') ?>" class="form-control" size="50">
		</label>
		<label class="col-md-6">Tipo Slider:
			<br/>
			<select name="tipo" class="form-control">
				<option <?php if($data["TipoSlider"] == "inicio") { echo "selected"; } ?> value="inicio">inicio</option>
				<option <?php if($data["TipoSlider"] == "marcas") { echo "selected"; } ?> value="marcas">marcas</option>
			</select>
		</label>
		<label class="col-md-6">Link:
			<br/>
			<div class="form-group">
				<label class="sr-only" for="exampleInputAmount">Link:</label>
				<div class="input-group">
					<div class="input-group-addon">http://aimarrepuestos.com.ar/</div>
					<input type="text" class="form-control" id="exampleInputAmount" name="link"  value="<?php echo (isset($data['LinkSlider']) ? $data['LinkSlider'] : '') ?>"  >						
				</div>
			</div>
		</label>
		<div class="clearfix"></div>
		<div class="col-lg-12">
			<label> <?php if($img === '') {
				?>
				<input type="file" name="img" class="form-control" size="50" />
				<?php }else { ?>
				<div style="width:300px;overflow: hidden">
					<br/>
					<label>Imagen
						<br/>
						<br/>
						<img src="../<?php echo $img ?>" width="100%"; ></label>
						<br/>
						<p onclick="">
							&rarr; Cambiar
						</p>
					</div>
					<div id="imgDiv" style="display:none">
						<input type="file" name="img" id="img2" class="form-control"/>
					</div> <?php } ?></label>
					<div class="clearfix"></div>
					<label>			
						<input type="submit" class="btn btn-primary" name="agregar" value="Modificar Slide" />
					</label>
				</div>
			</form>
		</div>
