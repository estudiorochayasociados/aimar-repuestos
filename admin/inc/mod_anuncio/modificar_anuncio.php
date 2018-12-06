<div class="large-12 column">
	<br/><br/>
	<h3>Modificar anuncio</h3>
	<hr/>
	<?php
	$id = isset($_GET["id"]) ? $_GET["id"] : '';
	$data = Agencias_TraerPorId($id);	
	?>
	<center id="loading" class="loading" style="display: none">
	<div class='clearfix'>
		&zwnj;
	</div><img src='../img/loader.gif' />
	<br>
	<p style="color:#2980B9">Subiendo imagen de publcidad y datos</p>
	<div class='clearfix'>
		&zwnj;
	</div>
</center> 
	<form method="post" enctype="multipart/form-data" autocomplete="off" onsubmit="loadingShow()">

		<br/>
		<?php
		if (isset($_POST["publicar"])) {
			if ($_POST["nombre"] != '' && $_POST["tel"] != '' && $_POST["direccion"] != '' && $_POST["provincia"] != '' && $_POST["localidad"] != '' && $_FILES["img"] != '') {

				$img = $data["logo_agencia"];
				$nombre = $_POST["nombre"];
				$tel = $_POST["tel"];
				$direccion = $_POST["direccion"];
				$provincia = $_POST["provincia"];
				$localidad = $_POST["localidad"];

				if ($_FILES["img"]["name"] != '') {
					$imgInicio = "";
					$destinoImg = "";
					$prefijo = substr(md5(uniqid(rand())), 0, 6);
					$imgInicio = $_FILES["img"]["tmp_name"];
					$tucadena = $_FILES["img"]["name"];
					$partes = explode(".", $tucadena);
					$dominio = $partes[1];
					if ($dominio != '') {
						$destinoFinal = "../archivos/agencias/" . $prefijo . "." . $dominio;
						$destinoImg = "archivos/agencias/" . $prefijo . "." . $dominio;
						move_uploaded_file($imgInicio, $destinoFinal);
						chmod($destinoFinal, 0777);
					}
				} else {
					$destinoImg = $img;
				}

				$sql = "
					UPDATE `agencias` 
					SET 			
					`nombre_agencia`= '$nombre',
					`tel_agencia`='$tel',
					`direccion_agencia`='$direccion',
					`localidad_agencia`='$localidad',
					`provincia_agencia`='$provincia',	
						
					`logo_agencia`='$destinoImg'								
					WHERE `id_agencia`= $id";
				$link = Conectarse();
				$r = mysql_query($sql, $link);

				echo "<script>location.reload();</script>";

			} else {
				echo "<span class='error'>Lo sentimos, todos los datos deben ser completados para publicar el anuncio.</span>";
			}
		}
		?>
		<input type="text" name="nombre" placeholder="Nombre de Agencia" value="<?php echo isset($data["nombre_agencia"]) ? $data["nombre_agencia"] : ''  ?>" />
		<input type="text" disabled value="<?php echo $data["email_agencia"]; ?> " />
		<input type="text" name="tel" placeholder="Teléfono de contacto" value="<?php echo isset($data["tel_agencia"]) ? $data["tel_agencia"] : ''  ?>" class="left" style="width:49%" onkeypress="return onlyNumbersDano(event)"/>
		<input type="text" name="direccion" placeholder="Dirección de Agencia" value="<?php echo isset($data["direccion_agencia"]) ? $data["direccion_agencia"] : ''  ?>" class="right" style="width:49%" />
		<select type="text" name="provincia" id="provincia" class="left" style="width:49%"/>
		<?php if(isset($data["provincia_agencia"])) {
echo "<option value=".$data["provincia_agencia"].">".$data["provincia_agencia"]."</option>";
} else {
		?>
		<option value="" disabled selected>Provincia de tu agencia</option><?php } ?>
		<?php Provincias_Read_Front(); ?>
		</select>
		<select type="text" name="localidad"  id="localidades" class="right" style="width:49%"/>
		<?php if(isset($data["localidad_agencia"])) { ?>
		<option value="<?php echo $data["localidad_agencia"] ?>"><?php echo $data["localidad_agencia"] ?></option>
<?php } else { ?>
		<option value="" disabled selected>Localidad de tu agencia</option><?php } ?>
		</select>

		<div class="clearfix">
			&zwnj;
		</div>
		<div class="clearfix">
			&zwnj;
		</div>
				<span class='error' id="imgError" style="display: none"></span>

		<label class="">
			<?php if($data["logo_agencia"] === '') {
			?>
			<input type="file" name="img" onchange="checkFile(this)" />
			<?php }else { ?>
			<div style="width:200px;overflow: hidden;">
				<br/>
				<label>Imágen
					<br/>
					<br/>
					<img src="../<?php echo $data["logo_agencia"] ?>" width="100%"; ></label>
				<br/>
				<p onclick="" class="botonCustomDes">
					&rarr; Cambiar
				</p>
			</div>
			<div id="imgDiv" style=";display:none">
				<input type="file" name="img" id="img2" onchange="checkFile(this)"/>
			</div>
			<?php } ?></label>

		<br/>
		<br/>
		<button onclick="window.history.back()" class="button left" style="background: #333">VOLVER</button>
		<input type="submit" class="button right" name="publicar" id="botonPubli" value="MODIFICAR ANUNCIO"/>
	</form>
</div>

