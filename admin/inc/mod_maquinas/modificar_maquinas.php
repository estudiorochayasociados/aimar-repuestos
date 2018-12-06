<?php
$id = isset($_GET['id']) ? $_GET['id'] : '';

if ($id != '') {
	$data = Reconstruidos_TraerPorId($id);	
	$imagen = Imagenes_TraerPorId($data["cod_portfolio"]);
	$imagenes = explode("-",$imagen);
	$count = '';
}

if (isset($_POST['agregar'])) {

	$titulo = $_POST['titulo'];
	$tipo = $_POST["tipo"];
	$categoria = $_POST["categoria"];
	$traslado = $_POST['traslado'];
	$fecha = $_POST['fecha'];
	$moneda = $_POST['moneda'];
	$alertas = $_POST['alertas'];
	$noches = $_POST['noches'];
	$precio = $_POST['precio'];
	$stock = $_POST['stock'];
	$financiado = $_POST['financiado'];
	$descripcion = $_POST['descripcion'];
	$aereos = $_POST['aereos'];
	$hoteles = $_POST['hoteles'];
	$itinerario = $_POST['itinerario'];

	foreach ($_FILES['files']['name'] as $f => $name) {     
		if(!empty($_FILES["files"]["tmp_name"][$f])) {
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
	}

	$sql2 = "

	UPDATE `maquinas` 
	SET 
	`nombre_portfolio`= '$titulo',
	`descripcion_portfolio`= '$descripcion',
	`categoria_portfolio`= '$categoria',
	`tipo_portfolio`= '$tipo',
	`aereos_portfolio`= '$aereos',
	`hoteles_portfolio`= '$hoteles',
	`traslado_portfolio`= '$traslado',
	`tiempo_portfolio`= '$fecha',
	`noches_portfolio`= '$noches',
	`moneda_portfolio`= '$moneda',
	`financiado_portfolio`= '$financiado',
	`precio_portfolio`= '$precio',
	`stock_portfolio`= '$stock',
	`itinerario_portfolio`= '$itinerario',
	`alertas_portfolio`= '$alertas'
	WHERE 
	`id_portfolio`= '$id'
	";
	$link2 = Conectarse();
	$r2 = mysql_query($sql2, $link2);

	header("location: index.php?op=modificarPaquetes&id=$id");
}
?>
<div class="col-md-12">
	Modificar Paquetes
	<hr/>
	<form method="post" enctype="multipart/form-data" onsubmit="showLoading()">
		<div class="row" > 
			<label class="col-md-6"><b>Título:</b>
				<br/>
				<input type="text" name="titulo" class="form-control" value="<?php echo (isset($data['nombre_portfolio']) ? $data['nombre_portfolio'] : '') ?>" required>
			</label>
			<label class="col-lg-3"><b>Categoría:</b>
				<select name="categoria" class="form-control">
					<option value="" disabled  >-- categorías --</option>
					<option value="1" <?php if(isset($data['categoria_portfolio']) && $data["categoria_portfolio"] == 1) { echo "selected"; } ?>>Internacional</option>
					<option value="2" <?php if(isset($data['categoria_portfolio']) && $data["categoria_portfolio"] == 2) { echo "selected"; } ?>>Nacional</option>
					<option value="3" <?php if(isset($data['categoria_portfolio']) && $data["categoria_portfolio"] == 3) { echo "selected"; } ?>>Escapadas</option>
				</select>				
			</label>
			<label class="col-lg-3"><b>Tipo:</b>
				<select name="tipo" class="form-control">
					<option value="" disabled  >-- categorías --</option>
					<option value="1" <?php if(isset($data['tipo_portfolio']) && $data["tipo_portfolio"] == 1) { echo "selected"; } ?>> Bus</option>
					<option value="2" <?php if(isset($data['tipo_portfolio']) && $data["tipo_portfolio"] == 2) { echo "selected"; } ?>>Aéreo</option>					
				</select>				
			</label>
			<div class="clearfix"></div>			
			<label class="col-md-4"><b>Traslado:</b>
				<br/>
				<input type="text" name="traslado" class="form-control" value="<?php echo (isset($data['traslado_portfolio']) ? $data['traslado_portfolio'] : '') ?>" required>
			</label>
			<label class="col-md-4"><b>Fecha del Viaje:</b>
				<br/>
				<input type="text" name="fecha" class="form-control" value="<?php echo (isset($data['tiempo_portfolio']) ? $data['tiempo_portfolio'] : '') ?>" required>
			</label>
			<label class="col-md-4"><b>Noches/Días:</b>
				<br/>
				<input type="text" name="noches" class="form-control" value="<?php echo (isset($data['noches_portfolio']) ? $data['noches_portfolio'] : '') ?>" required>
			</label>			
			<div class="clearfix"></div>
			<label class="col-md-1"><b>Moneda:</b>
				<br/>
				<select name="moneda" class="form-control">
					<option value="" disabled >-- categorías --</option>
					<option value="1" <?php if(isset($data['financiado_portfolio']) && $data["financiado_portfolio"] == 1) { echo "selected"; } ?>>ARS</option>
					<option value="2" <?php if(isset($data['financiado_portfolio']) && $data["financiado_portfolio"] == 2) { echo "selected"; } ?>>USD</option>					
				</select>	
			</label>
			<label class="col-md-2"><b>Precio Final:</b><br/>
				<div class="form-group">
					<label class="sr-only" for="exampleInputAmount">Precio Final:</label>
					<div class="input-group">
						<div class="input-group-addon">$</div>
						<input type="text" class="form-control" id="exampleInputAmount" name="precio"  value="<?php echo (isset($data['precio_portfolio']) ? $data['precio_portfolio'] : '') ?>" required>
						<div class="input-group-addon">.00</div>
					</div>
				</div>
			</label>
			<label class="col-md-3"><b>Financiado (cuotas):</b>
				<br/>
				<input type="text" name="financiado" class="form-control" value="<?php echo (isset($data['financiado_portfolio']) ? $data['financiado_portfolio'] : '') ?>" required>
			</label>
			<label class="col-md-2"><b>Stock (cuotas):</b>
				<br/>
				<input type="number" min="1" name="stock" class="form-control" value="<?php echo (isset($data['stock_portfolio']) ? $data['stock_portfolio'] : '') ?>" required>
			</label>		
			<label class="col-md-4"><b>Texto Promocional:</b>
				<select name="alertas" class="form-control">
					<option value="" disabled >-- categorías --</option>
					<option <?php if(isset($data['alertas_portfolio']) && $data["alertas_portfolio"] == "Vacio") { echo "selected"; } ?> value="">Vacio</option>
					<option <?php if(isset($data['alertas_portfolio']) && $data["alertas_portfolio"] == "2 x 1") { echo "selected"; } ?> value="2 x 1">2 x 1</option>
					<option <?php if(isset($data['alertas_portfolio']) && $data["alertas_portfolio"] == "¿Te lo vas a perder?") { echo "selected"; } ?> value="¿Te lo vas a perder?">¿Te lo vas a perder?</option>					
					<option <?php if(isset($data['alertas_portfolio']) && $data["alertas_portfolio"] == "25% off") { echo "selected"; } ?> value="25% off">25% off</option>					
					<option <?php if(isset($data['alertas_portfolio']) && $data["alertas_portfolio"] == "20% off") { echo "selected"; } ?> value="20% off">20% off</option>					
					<option <?php if(isset($data['alertas_portfolio']) && $data["alertas_portfolio"] == "15% off") { echo "selected"; } ?> value="15% off">15% off</option>					
					<option <?php if(isset($data['alertas_portfolio']) && $data["alertas_portfolio"] == "10% off") { echo "selected"; } ?> value="10% off">10% off</option>					
					<option <?php if(isset($data['alertas_portfolio']) && $data["alertas_portfolio"] == "5% off") { echo "selected"; } ?> value="5% off">5% off</option>									
					<option <?php if(isset($data['alertas_portfolio']) && $data["alertas_portfolio"] == "Últimos Lugares") { echo "selected"; } ?> value="Últimos Lugares">Últimos Lugares</option>									
					<option <?php if(isset($data['alertas_portfolio']) && $data["alertas_portfolio"] == "Precio promocional") { echo "selected"; } ?> value="Precio Promocional">Precio promocional</option>									
					<option <?php if(isset($data['alertas_portfolio']) && $data["alertas_portfolio"] == "Liquidación") { echo "selected"; } ?> value="Liquidación">Liquidación</option>									
				</select>
			</label>		
			<div class="clearfix"></div>
			<label class="col-md-6"><b>Descripción:</b>
				<br/>
				<textarea name="descripcion" class="form-control"    style="height:300px;display:block"><?php echo (isset($data['descripcion_portfolio']) ? $data['descripcion_portfolio'] : '') ?></textarea>
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
				<textarea name="itinerario" class="form-control"    style="height:300px;display:block"><?php echo (isset($data['itinerario_portfolio']) ? $data['itinerario_portfolio'] : '') ?></textarea>
				<script>
				CKEDITOR.replace('itinerario');
				</script>
				<div class="clearfix">
				</div>
			</label>
			<div class="clearfix"></div>
			<label class="col-md-6"><b>Hoteles:</b>
				<br/>
				<textarea name="hoteles" class="form-control" style="height:300px;display:block"><?php if($data['hoteles_portfolio'] == '') { echo '<h1>Hoteles</h1><table border="1" class="table table-striped table-bordered table-hover tablaAereo" width="100%">	<thead>		<tr>			<th>Lugar</th>			<th>Hotel</th>			<th>Estrellas</th>			<th>Link</th>		</tr>	</thead>	<tbody>		<tr>			<td> </td>			<td> </td>			<td> </td>			<td> </td>		</tr>		<tr>			<td> </td>			<td> </td>			<td></td>			<td> </td>		</tr>	</tbody></table>'; } else { echo $data["hoteles_portfolio"]; } ?></textarea>
				<script>
				CKEDITOR.replace('hoteles');
				</script> 
				<br>
			</label>
			<label class="col-md-6"><b>Aéreos / Bus:</b>
				<br/>
				<textarea name="aereos" class="form-control" style="height:300px;display:block">
					<?php if($data['aereos_portfolio'] == '') { echo '<h1>Ida</h1><table border="1" class="table table-striped table-bordered table-hover tablaAereo" width="100%">	<thead>		<tr>			<th>Vuelo</th>			<th>Aerol&iacute;nea</th>			<th>Salida</th>			<th>Llegada</th>		</tr>	</thead>	<tbody>		<tr>			<td>&nbsp;</td>			<td>&nbsp;</td>			<td>&nbsp;</td>			<td> </td>		</tr>		<tr>			<td>&nbsp;</td>			<td>&nbsp;</td>			<td>&nbsp;</td>			<td>&nbsp;</td>		</tr>	</tbody></table><p>&nbsp;</p><h1>Regreso</h1><table border="1" class="table table-striped table-bordered table-hover tablaAereo" width="100%">	<thead>		<tr>			<th>Vuelo</th>			<th>Aerol&iacute;nea</th>			<th>Salida</th>			<th>Llegada</th>		</tr>	</thead>	<tbody>		<tr>			<td>&nbsp;</td>			<td>&nbsp;</td>			<td>&nbsp;</td>			<td> </td>		</tr>		<tr>			<td>&nbsp;</td>			<td>&nbsp;</td>			<td>&nbsp;</td>			<td>&nbsp;</td>		</tr>	</tbody></table><p>&nbsp;</p>'; } else { echo $data["aereos_portfolio"]; } ?></textarea>
					<script>
					CKEDITOR.replace('aereos');
					</script> 
					<br>
				</label>
				<div class="clearfix"></div>
				<div class="col-md-12"><br/>
					<div class="row">
						<?php 
						$countImagen = (count($imagenes))-1;
						for ($i = 0;$i < $countImagen;$i++) {
							echo '<div class="col-md-2 col-xs-3" style="margin-bottom:65px;height:200px;"><img src="../'.$imagenes[$i].'" width="100%" class="thumbnail img-responsive">
							<a class="btn-primary btn btn-block" href="index.php?op=modificarPaquetes&id='.$id.'&borrar='.$imagenes[$i].'">BORRAR IMAGEN</a></div>';
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
						<input type="submit" class="btn btn-primary " name="agregar" value="Modificar Paquete" />
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
		header("location: index.php?op=modificarPaquetes&id=$id");
	}

	?>




