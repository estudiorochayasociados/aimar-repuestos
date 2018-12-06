<?php 


$random = "paq_".substr(md5(uniqid(rand())), 0, 10);
$cod = $random;
$area = "paquetes";

if (isset($_POST["agregar"])) {

	$titulo = $_POST['titulo'];
	$tipo = $_POST["tipo"];
	$categorias = $_POST["categoria"];
	$traslado = $_POST['traslado'];
	$fecha = $_POST['fecha'];
	$moneda = $_POST['moneda'];
	$alertas = $_POST['alertas'];
	$noches = $_POST['noches'];
	$precio = $_POST['precio'];
	$stock = $_POST['stock'];
	$financiado = $_POST['financiado'];
	$descripcion = $_POST['descripcion'];
	$hoteles = $_POST['hoteles'];
	$aereos = $_POST['aereos'];
	$itinerario = $_POST['itinerario'];

	$count = '';
 
	foreach ($_FILES['files']['name'] as $f => $name) {     
		$imgInicio = $_FILES["files"]["tmp_name"][$f];
		$tucadena = $_FILES["files"]["name"][$f];
		$partes = explode(".", $tucadena);
		$dom = (count($partes) - 1);
		$dominio = $partes[$dom];
		$prefijo = rand(0, 10000000);

		if ($dominio != '') {
 			$destinoImg = "archivos/paquetes/" . $prefijo . "." . $dominio;
			$destinoFinal = "../archivos/paquetes/" . $prefijo . "." . $dominio;
			move_uploaded_file($imgInicio, $destinoFinal);
			chmod($destinoFinal, 0777);	
			$destinoRecortado = "../archivos/paquetes/recortadas/a_" . $prefijo . "." . $dominio;
			$destinoRecortadoFinal = "archivos/paquetes/recortadas/a_" . $prefijo . "." . $dominio;
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
		$sql = "INSERT INTO `imagenes`(`ruta`, `codigo`) VALUES ('$destinoRecortadoFinal','$cod')";
		$link = Conectarse();
		$r = mysql_query($sql, $link);
	}


	$sql2 = "
	INSERT INTO `maquinas`
	(`nombre_portfolio`, `descripcion_portfolio`, `categoria_portfolio`, `tipo_portfolio`, `traslado_portfolio`, `hoteles_portfolio`, `aereos_portfolio`, `tiempo_portfolio`, `noches_portfolio`, `moneda_portfolio`, `financiado_portfolio`, `precio_portfolio`, `stock_portfolio`,  `itinerario_portfolio`, `alertas_portfolio`, `cod_portfolio`, `fecha_portfolio`) 
	VALUES 
	('$titulo','$descripcion','$categorias', '$tipo', '$traslado', '$hoteles', '$aereos','$fecha','$noches','$moneda','$financiado','$precio','$stock','$itinerario','$alertas', '$cod',  NOW())";
	$link2= Conectarse();
	$r2 = mysql_query($sql2, $link2);

	 header("location:index.php?op=verPaquetes");
} 
?>

<div class="col-md-12	">
	<h4>Agregar a Paquete de Viaje</h4>
	<hr/>
	<form method="post" enctype="multipart/form-data" onsubmit="showLoading()">
		<div class="row" >
			<label class="col-md-6"><b>Título:</b>
				<br/>
				<input type="text" name="titulo" class="form-control" value="<?php echo (isset($_POST['titulo']) ? $_POST['titulo'] : '') ?>" required>
			</label>
			<label class="col-lg-3"><b>Categoría:</b>
				<select name="categoria" class="form-control">
					<option value="" disabled  >-- categorías --</option>
					<option value="1" <?php if(isset($_POST['categoria']) && $_POST["categoria"] == 1) { echo "selected"; } ?>>Internacional</option>
					<option value="2" <?php if(isset($_POST['categoria']) && $_POST["categoria"] == 2) { echo "selected"; } ?>>Nacional</option>
					<option value="3" <?php if(isset($_POST['categoria']) && $_POST["categoria"] == 3) { echo "selected"; } ?>>Escapadas</option>
				</select>				
			</label>
			<label class="col-lg-3"><b>Tipo:</b>
				<select name="tipo" class="form-control">
					<option value="" disabled  >-- categorías --</option>
					<option value="1" <?php if(isset($_POST['tipo']) && $_POST["tipo"] == 1) { echo "selected"; } ?>> Bus</option>
					<option value="2" <?php if(isset($_POST['tipo']) && $_POST["tipo"] == 2) { echo "selected"; } ?>>Aéreo</option>					
				</select>				
			</label>
			<div class="clearfix"></div>			
			<label class="col-md-4"><b>Traslado:</b>
				<br/>
				<input type="text" name="traslado" class="form-control" value="<?php echo (isset($_POST['traslado']) ? $_POST['traslado'] : '') ?>" required>
			</label>
			<label class="col-md-4"><b>Fecha del Viaje:</b>
				<br/>
				<input type="text" name="fecha" class="form-control" value="<?php echo (isset($_POST['fecha']) ? $_POST['fecha'] : '') ?>" required>
			</label>
			<label class="col-md-4"><b>Noches/Días:</b>
				<br/>
				<input type="text" name="noches" class="form-control" value="<?php echo (isset($_POST['noches']) ? $_POST['noches'] : '') ?>" required>
			</label>			
			<div class="clearfix"></div>
			<label class="col-md-1"><b>Moneda:</b>
				<br/>
				<select name="moneda" class="form-control">
					<option value="" disabled >-- categorías --</option>
					<option value="1" <?php if(isset($_POST['financiado']) && $_POST["financiado"] == 1) { echo "selected"; } ?>>ARS</option>
					<option value="2" <?php if(isset($_POST['financiado']) && $_POST["financiado"] == 2) { echo "selected"; } ?>>USD</option>					
				</select>	
			</label>
			<label class="col-md-2"><b>Precio Final:</b><br/>
				<div class="form-group">
					<label class="sr-only" for="exampleInputAmount">Precio Final:</label>
					<div class="input-group">
						<div class="input-group-addon">$</div>
						<input type="text" class="form-control" id="exampleInputAmount" name="precio"  value="<?php echo (isset($_POST['precio']) ? $_POST['precio'] : '') ?>" required>
						<div class="input-group-addon">.00</div>
					</div>
				</div>
			</label>
			<label class="col-md-3"><b>Financiado (cuotas):</b>
				<br/>
				<input type="text" name="financiado" class="form-control" value="<?php echo (isset($_POST['financiado']) ? $_POST['financiado'] : '') ?>" required>
			</label>	
			<label class="col-md-2"><b>Stock (cuotas):</b>
				<br/>
				<input type="number" min="1" name="stock" class="form-control" value="<?php echo (isset($_POST['stock']) ? $_POST['stock'] : '') ?>" required>
			</label>	
			<label class="col-md-4"><b>Texto Promocional:</b>
				<select name="alertas" class="form-control">
					<option value="" disabled >-- categorías --</option>
					<option <?php if(isset($_POST['alertas']) && $_POST["alertas"] == "Vacio") { echo "selected"; } ?> value="">Vacio</option>
					<option <?php if(isset($_POST['alertas']) && $_POST["alertas"] == "2 x 1") { echo "selected"; } ?> value="2 x 1">2 x 1</option>
					<option <?php if(isset($_POST['alertas']) && $_POST["alertas"] == "¿Te lo vas a perder?") { echo "selected"; } ?> value="¿Te lo vas a perder?">¿Te lo vas a perder?</option>					
					<option <?php if(isset($_POST['alertas']) && $_POST["alertas"] == "25% off") { echo "selected"; } ?> value="25% off">25% off</option>					
					<option <?php if(isset($_POST['alertas']) && $_POST["alertas"] == "20% off") { echo "selected"; } ?> value="20% off">20% off</option>					
					<option <?php if(isset($_POST['alertas']) && $_POST["alertas"] == "15% off") { echo "selected"; } ?> value="15% off">15% off</option>					
					<option <?php if(isset($_POST['alertas']) && $_POST["alertas"] == "10% off") { echo "selected"; } ?> value="10% off">10% off</option>					
					<option <?php if(isset($_POST['alertas']) && $_POST["alertas"] == "5% off") { echo "selected"; } ?> value="5% off">5% off</option>									
					<option <?php if(isset($_POST['alertas']) && $_POST["alertas"] == "Últimos Lugares") { echo "selected"; } ?> value="Últimos Lugares">Últimos Lugares</option>									
					<option <?php if(isset($_POST['alertas']) && $_POST["alertas"] == "Precio promocional") { echo "selected"; } ?> value="Precio Promocional">Precio promocional</option>									
					<option <?php if(isset($_POST['alertas']) && $_POST["alertas"] == "Liquidación") { echo "selected"; } ?> value="Liquidación">Liquidación</option>									
				</select>
			</label>		
			<div class="clearfix"></div>
			<label class="col-md-6"><b>Descripción:</b>
				<br/>
				<textarea name="descripcion" class="form-control"    style="height:300px;display:block"><?php echo (isset($_POST['descripcion']) ? $_POST['descripcion'] : '') ?></textarea>
				<script>
				CKEDITOR.replace('descripcion');
				</script>
				<div class="clearfix">
					<br/>
				</div>
				<br>
			</label>
			<label class="col-md-6"><b>Itinerario:</b>
				<br/>
				<textarea name="itinerario" class="form-control"    style="height:300px;display:block"><?php echo (isset($_POST['itinerario']) ? $_POST['itinerario'] : '') ?></textarea>
				<script>
				CKEDITOR.replace('itinerario');
				</script> 
			</label>
			<div class="clearfix"></div>
			<label class="col-md-6 "><b>Hoteles:</b>
				<br/>
				<textarea name="hoteles" class="form-control" style="height:300px;display:block"><?php echo (isset($_POST['hoteles']) ? $_POST['hoteles'] : '<h1>Hoteles</h1><table border="1" class="table table-striped table-bordered table-hover tablaAereo" width="100%"><thead><tr><th>Lugar</th><th>Hotel</th><th>Estrellas</th><th>Link</th></tr></thead><tbody><tr><td>Córdoba</td><td>Hotel</td><td>5 *</td><td>Web del Hotel</td></tr><tr><td>Córdoba</td><td>Hotel</td><td>5 *</td><td>Web del Hotel</td></tr></tbody></table><p>&nbsp;</p>') ?></textarea>
				<script>
				CKEDITOR.replace('hoteles');
				</script> 
				<br>
			</label>
			<label class="col-md-6 "><b>Aéreos / Bus:</b>
				<br/>
				<textarea name="aereos" class="form-control" style="height:300px;display:block"><?php echo (isset($_POST['aereos']) ? $_POST['aereos'] : '<h1>Ida</h1><table border="1" class="table table-striped table-bordered table-hover tablaAereo" width="100%">	<thead><tr><th>Vuelo</th><th>Aerol&iacute;nea</th><th>Salida</th><th>Llegada</th></tr>	</thead>	<tbody><tr><td>0ka3</td><td><p>Lan</p><p>Argentina</p></td><td><p>14/07/2016 10:35hs</p><p>Aeropuerto de Santiago</p></td><td><p>14/07/2016 10:35hs</p><p>Aeropuerto de Santiago &nbsp; &nbsp;</p></td></tr><tr><td>0ka3</td><td><p>Lan</p><p>Argentina</p></td><td><p style="line-height: 20.8px;">14/07/2016 10:35hs&nbsp;</p><p style="line-height: 20.8px;">Aeropuerto de Santiago</p></td><td><p style="line-height: 20.8px;">14/07/2016 10:35hs&nbsp;</p><p style="line-height: 20.8px;">Aeropuerto de Santiago</p></td></tr>	</tbody></table><p>&nbsp;</p><h1>Regreso</h1><table border="1" class="table table-striped table-bordered table-hover tablaAereo" width="100%">	<thead><tr><th>Vuelo</th><th>Aerol&iacute;nea</th><th>Salida</th><th>Llegada</th></tr>	</thead>	<tbody><tr><td>0ka3</td><td><p>Lan</p><p>Argentina</p></td><td><p>14/07/2016 10:35hs</p><p>Aeropuerto de Santiago</p></td><td><p>14/07/2016 10:35hs</p><p>Aeropuerto de Santiago &nbsp; &nbsp;</p></td></tr><tr><td>0ka3</td><td><p>Lan</p><p>Argentina</p></td><td><p style="line-height: 20.8px;">14/07/2016 10:35hs&nbsp;</p><p style="line-height: 20.8px;">Aeropuerto de Santiago</p></td><td><p style="line-height: 20.8px;">14/07/2016 10:35hs&nbsp;</p><p style="line-height: 20.8px;">Aeropuerto de Santiago</p></td></tr>	</tbody></table><p>&nbsp;</p>') ?></textarea>
				<script>
				CKEDITOR.replace('aereos');
				</script> 
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
				<input type="submit" class="btn btn-primary" name="agregar" value="Subir Paquete" />
			</div>
		</div>
	</form>
</div>
