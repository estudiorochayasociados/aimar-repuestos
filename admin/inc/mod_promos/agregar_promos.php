<?php
$random = rand(0, 10000000);
if (isset($_POST["agregar"])) {
	if ($_POST["titulo"] != '' && $_POST["tipo"] != '') {
		$imgInicio = "";
		$destinoImg = "";
		$prefijo = substr(md5(uniqid(rand())), 0, 6);
		$imgInicio = $_FILES["img"]["tmp_name"];
		$tucadena = $_FILES["img"]["name"];
		$partes = explode(".", $tucadena);
		$dominio = $partes[1];

		if ($dominio != '') {
			$destinoImg = "archivos/promociones/" . $prefijo . "." . $dominio;
			$destinoFinal = "../archivos/promociones/" . $prefijo . "." . $dominio;
			move_uploaded_file($imgInicio, $destinoFinal);
			chmod($destinoImg, 0777);
		} else {
			$destinoImg = $img;
		}

		$titulo = isset($_POST["titulo"]) ? $_POST["titulo"]  : '';
		$tipo = isset($_POST["tipo"]) ? $_POST["tipo"]  : '';
		$precio = isset($_POST["precio"]) ? $_POST["precio"]  : '';
		$formas = isset($_POST["formas"]) ? $_POST["formas"]  : '';
		$descripcion = isset($_POST["descripcion"]) ? $_POST["descripcion"]  : '';
		
		$sql = "
			INSERT INTO `promociones`
			(`TituloPromociones`, `ImgPromociones`, `TipoPromociones`, `TextoPromociones`, `PrecioPromociones`, `PagosPromociones`, `FechaPromociones`) 		
			VALUES 
			('$titulo','$destinoImg','$tipo', '$descripcion', '$precio', '$formas', NOW())";
		$link = Conectarse();
		$r = mysql_query($sql, $link);

		header("location:index.php?op=verPromos");
	} else {
		echo "<br/><center><span class='large-11 button' style='background:#872F30'>* Todos los datos son obligatorios</span></center>";
	}
}
?>

<div class="col-lg-12">
	<h4>Promociones</h4>
	<hr/>
	<form method="post" enctype="multipart/form-data" onsubmit="loadingShow()">
		<label class="col-lg-6">Título:
			<br/>
			<input type="text" name="titulo" value="" class="form-control" size="50">
		</label>
		<div class="clearfix"></div>	
		<label class="col-lg-3"> Tipo de Servicio:
			<select name="tipo" class="form-control">
				<option disabled selected >Elegir</option>
				<option value="Dibox">Dibox</option>
				<option value="Cable">Cable</option>
				<option value="Internet Soon">Internet Soon</option>
				<option value="Telefonía IP">Telefonía IP</option>
				<option value="Internet Rural">Internet Rural</option>
				<option value="Celulares Corporativos">Celulares Corporativos</option>
				<option value="Seguridad">Seguridad</option>				
			</select> 
		</label>
		<div class="clearfix"></div>
		<label class="col-lg-6">Formas de Pago:
			<div class="clearfix"></div>
			<textarea name="formas" class="form-control"></textarea>
		</label>
		<div class="clearfix"></div>
		<label class="col-lg-6">Descripción de la Promoción:
			<div class="clearfix"></div>
			<textarea name="descripcion" class="form-control" style="height: 150px"></textarea>
		</label>
		<div class="clearfix"></div>
		<label class="col-lg-6">Imagen:
			<input type="file" name="img" class="form-control" />
		</label>
		<div class="clearfix"></div>
		<br/>
		<label class="col-lg-6">
			<input type="submit" class="btn btn-primary" name="agregar" value="Crear Promoción" />
		</label>
	</form>
</div>
