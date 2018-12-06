<?php
$id = isset($_GET['id']) ? $_GET['id'] : '';

if ($id != '') {
	$data = Portfolio_TraerPorId($id);
	$titulo = isset($data["nombre_portfolio"]) ? $data["nombre_portfolio"] : '';
	$precio = isset($data["precio_portfolio"]) ? $data["precio_portfolio"] : '';;
	$moneda = isset($data["moneda_portfolio"]) ? $data["moneda_portfolio"] : '';;
	$categoria = isset($data["categoria_portfolio"]) ? $data["categoria_portfolio"] : '';
	$img = isset($data["imagen1_portfolio"]) ? $data["imagen1_portfolio"] : '';
}

if (isset($_POST['agregar'])) {
	if ($_POST["titulo"] != '') {
		$titulo = $_POST["titulo"];
		$categorias = $_POST["tipo"];
		$descripcion = $_POST["descripcion"];
		$precio = $_POST["precio"];
		$moneda = $_POST["moneda"];

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
			$destinoRecortadoFinal = $img;
		}

		$sql = "
		UPDATE `portfolio` 
		SET 			
		`nombre_portfolio`= '$titulo',
		`descripcion_portfolio`= '$descripcion',
		`categoria_portfolio`= '$categorias',						
		`precio_portfolio`= '$precio',						
		`moneda_portfolio`= '$moneda',						
		`imagen1_portfolio`='$destinoRecortadoFinal'
		WHERE `id_portfolio`= $id";
		$link = Conectarse();
		$r = mysql_query($sql, $link);

		header("location:index.php?op=verPortfolio");
	}
}
?>
<div class="col-lg-12">
	<hr/>
	<form method="post" enctype="multipart/form-data">
		<div class="row" >
			<label class="col-lg-4">Título:
				<br/>
				<input type="text" name="titulo" class="form-control" value="<?php echo $data["nombre_portfolio"]; ?>" required>
			</label>
			<label class="col-lg-3">Categoría Repuestos:
				<select name="tipo" class="form-control">
					<option value="" disabled selected>-- categorías --</option>
					<option value="1" <?php if($categoria == 1){ echo "selected"; } ?>>Nutrición</option>
					<option value="2" <?php if($categoria == 2){ echo "selected"; } ?>>Conservación de Forrajes</option>
					<option value="3" <?php if($categoria == 3){ echo "selected"; } ?>>Efluentes</option>
				</select>				
			</label>
			<div class="clearfix"></div>
			<label class="col-md-2">Moneda:
				<select name="moneda" class="form-control">
					<option value="" disabled selected>-- moneda --</option>
					<option value="ARS" <?php if($moneda == "ARS"){ echo "selected"; } ?>>ARS</option>
					<option value="USD" <?php if($moneda == "USD"){ echo "selected"; } ?> >USD</option>
				</select>				
			</label>
			<label class="col-md-4">Precio:
				<div class="input-group">
					<div class="input-group-addon">$</div>
					<input type="text" class="form-control" name="precio" value="<?php echo (isset($data["precio_portfolio"]) ? $data["precio_portfolio"] : '' ); ?>">					
				</div>		
			</label>
			<div class="clearfix"></div><br/>
			<label class="col-md-12 col-lg-7">Desarrollo:
				<br/>
				<textarea name="descripcion" class="form-control"  style="height:300px;display:block">
					<?php echo (isset($data['descripcion_portfolio']) ? $data['descripcion_portfolio'] : '') ?>
				</textarea>
				<script>
					CKEDITOR.replace('descripcion');
				</script> 
			</label>
			<div class="clearfix"></div>
			<label class="col-lg-7" style=" margin-bottom: 20px">
				<?php if($img === '') {
					?>Imagen 1
					<br/>
					<input type="file" name="img" />
					<?php }else { ?>
					<div style="height:100%;overflow: hidden">
						<br/>
						<label>Imagen 1
							<br/>
							<img src="../<?php echo $img ?>" style="max-height:160px" ></label>
							<br/>
							<p onclick="">
								&rarr; Cambiar
							</p>
						</div>
						<div id="imgDiv" style="display:none">Imagen 1
							<br/>
							<br/>
							<input type="file" name="img" id="img2" />
						</div>
						<?php } ?>
					</label>							
					<div class="clearfix"></div>
					<label class="col-md-12">
						<input type="submit" class="btn btn-primary " name="agregar" value="Modificar Repuesto" />
					</label>
				</div>
			</div>
		</form>
	</div>
