<?php
$id = isset($_GET['id']) ? $_GET['id'] : '';

if ($id != '') {
	$data = Promociones_TraerPorId($id);
	$titulo = isset($data["TituloPromociones"]) ? $data["TituloPromociones"] : '';
	$descripcion = isset($data["TextoPromociones"]) ? $data["TextoPromociones"] : '';
	$tipo = isset($data["TipoPromociones"]) ? $data["TipoPromociones"] : '';
	$formas = isset($data["PagosPromociones"]) ? $data["PagosPromociones"] : '';
	$img = isset($data["ImgPromociones"]) ? $data["ImgPromociones"] : '';
}

if (isset($_POST['agregar'])) {
	if ($_POST["titulo"] != '' && $_POST["tipo"] != '') {

		$titulo = isset($_POST["titulo"]) ? $_POST["titulo"]  : '';
		$tipo = isset($_POST["tipo"]) ? $_POST["tipo"]  : '';		
		$formas = isset($_POST["formas"]) ? $_POST["formas"]  : '';
		$descripcion = isset($_POST["descripcion"]) ? $_POST["descripcion"]  : '';

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


		$sql = "
			UPDATE `promociones` 
			SET 			
			`TituloPromociones`= '$titulo',
			`TipoPromociones`='$tipo',
			`ImgPromociones`='$destinoImg',
			`TextoPromociones`='$descripcion',
			`PagosPromociones`='$formas'
			WHERE `IdPromociones`= $id";
		$link = Conectarse();
		$r = mysql_query($sql, $link);

		header("location:index.php?op=verPromos");
	}
}
?>

<div class="col-lg-12">
	<h4>Promociones &rarr; <?php echo $data["TituloPromociones"]; ?></h4>
	<hr/>
	<form method="post" enctype="multipart/form-data" onsubmit="loadingShow()">
			<label class="col-lg-6">Título:
			<br/>
			<input type="text" name="titulo" value="<?php echo $titulo ?>" class="form-control" size="50">
		</label>
		<div class="clearfix"></div>	
		<label class="col-lg-3"> Tipo de Servicio:
			<select name="tipo" class="form-control">
				<option selected  value="<?php echo $tipo ?>"> Elegido  &rarr; <?php echo $tipo ?></option>				
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
			<textarea name="formas" class="form-control"><?php echo $formas ?></textarea>
		</label>
		<div class="clearfix"></div>
		<label class="col-lg-6">Descripción de la Promoción:
			<div class="clearfix"></div>
			<textarea name="descripcion" class="form-control" style="height: 150px"><?php echo $descripcion ?></textarea>
		</label>
				<div class="clearfix"></div>

		<label class="col-lg-6"> <?php if($img === '') {
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
			<br/>
		<label class="col-lg-6">		
			<input type="submit" class="btn btn-primary" name="agregar" value="Modificar Promoción" />
		</label>
</form>
</div>
