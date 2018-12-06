<?php
$random = rand(0, 10000000);
if (isset($_POST["agregar"])) {
	if ($_POST["titulo"] != '') {
		$titulo = $_POST["titulo"];
		$precio = $_POST["precio"];
		$moneda = $_POST["moneda"];
		$descripcion = $_POST["descripcion"];
		$categorias = $_POST["tipo"];

		$imgInicio = "";
		$destinoImg = "";
		$prefijo = substr(md5(uniqid(rand())), 0, 6);
		$imgInicio = $_FILES["img"]["tmp_name"];
		$tucadena = $_FILES["img"]["name"];
		$partes = explode(".", $tucadena);
		$dominio = $partes[1];

		if ($dominio != '') {
			$destinoImg = "archivos/repuestos/" . $prefijo . "." . $dominio;
			$destinoFinal = "../archivos/repuestos/" . $prefijo . "." . $dominio;
			move_uploaded_file($imgInicio, $destinoFinal);
			chmod($destinoFinal, 0777);
			$destinoRecortado = "../archivos/repuestos/recortadas/a_" . $prefijo . "." . $dominio;
			$destinoRecortadoFinal = "archivos/repuestos/recortadas/a_" . $prefijo . "." . $dominio;
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
		} else {
			$destinoRecortadoFinal = '';
		} 

		$sql = "
		INSERT INTO `portfolio`
		( `nombre_portfolio`, `descripcion_portfolio`, `categoria_portfolio`, `imagen1_portfolio` , `moneda_portfolio`,`precio_portfolio`, `fecha_portfolio`) 
		VALUES 
		('$titulo','$descripcion','$categorias','$destinoRecortadoFinal', '$moneda', '$precio' , NOW())";
		$link = Conectarse();
		$r = mysql_query($sql, $link);

		header("location:index.php?op=verPortfolio");
	} else {
		echo "<br/><center><span class='large-11 button' style='background:#872F30'>* Todos los datos son obligatorios</span></center>";
	}
}
?>

<div class="col-lg-12	">
	<h4>Agregar a Repuestos</h4>
	<hr/>
	<form method="post" enctype="multipart/form-data">
		<div class="row" >
			<label class="col-lg-4">Título:
				<br/>
				<input type="text" name="titulo" class="form-control" value="<?php echo (isset($_POST['titulo']) ? $_POST['titulo'] : '') ?>" required>
			</label>
			<label class="col-lg-3">Categoría Repuestos:
				<select name="tipo" class="form-control">
					<option value="" disabled selected>-- categorías --</option>
					<option value="1">Nutrición</option>
					<option value="2">Conservación de Forrajes</option>
					<option value="3">Efluentes</option>
				</select>				
			</label>
			<div class="clearfix"></div>
			<label class="col-md-2">Moneda:
				<select name="moneda" class="form-control">
					<option value="" disabled selected>-- moneda --</option>
					<option value="ARS">ARS</option>
					<option value="USD">USD</option>
				</select>				
			</label>
			<label class="col-md-4">Precio:
				<div class="input-group">
					<div class="input-group-addon">$</div>
					<input type="text" class="form-control" name="precio">					
				</div>		
			</label>
			<div class="clearfix"></div>			 
			<label class="col-md-12 col-lg-7">Desarrollo:
				<br/>
				<textarea name="descripcion" class="form-control"    style="height:300px;display:block"><?php echo (isset($_POST['descripcion']) ? $_POST['descripcion'] : '') ?></textarea>
				<script>
					CKEDITOR.replace('descripcion');
				</script> 
			</label>
			<div class="clearfix">
				<br/>
			</div>
			<br>
			<label class="col-lg-7">Imagen:
				<br/>
				<input type="file" name="img" class="form-control"/>
			</label>				 
			<div class="clearfix">
				<br/>
			</div>
			<br>
			<label class="col-lg-7">
				<input type="submit" class="btn btn-primary" name="agregar" value="Subir Repuesto" />
			</label>
		</div>
	</form>
</div>
