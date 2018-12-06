<div class="clear">
	&zwnj;
</div>
<div class="clear">
	&zwnj;
</div>
<div class="large-12 columns">
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
		<h3>PUBLICAR ANUNCIO</h3>
		<br/>
		<?php
		if (isset($_POST["publicar"])) {
			if ($_POST["nombre"] != '' && $_POST["tel"] != '' && $_POST["direccion"] != '' && $_POST["provincia"] != '' && $_POST["localidad"] != '' && $_POST["tipo"] != '' && $_FILES["img"] != '') {

				$cod = substr(md5(uniqid(rand())), 0, 20);
				$imgInicio = "";
				$destinoImg = "";
				$prefijo = substr(md5(uniqid(rand())), 0, 6);
				$imgInicio = $_FILES["img"]["tmp_name"];
				$tucadena = $_FILES["img"]["name"];
				$partes = explode(".", $tucadena);
				$dominio = $partes[1];
				$destinoFinal = "../archivos/agencias/" . $prefijo . "." . $dominio;
				$destinoImg = "archivos/agencias/" . $prefijo . "." . $dominio;
				move_uploaded_file($imgInicio, $destinoFinal);
				chmod($destinoFinal, 0777);
				Insertar_Agencia($_POST["nombre"], $_POST["tel"], $_POST["direccion"], $_POST["email"], $_POST["provincia"], $_POST["localidad"], $destinoImg, $_POST["tipo"], $cod);
			} else {
				echo "<span class='error'>Lo sentimos, todos los datos deben ser completados para publicar el anuncio.</span>";
			}
		}
		?>
		<input type="text" name="nombre" placeholder="Nombre de Agencia" value="<?php echo isset($_POST["nombre"]) ? $_POST["nombre"] : ''  ?>" style="width:49%" class="left"/>
		<input type="text" name="email" placeholder="Email de Agencia" value="<?php echo isset($_POST["email"]) ? $_POST["email"] : ''  ?>" style="width:49%" class="right"/>
		<input type="text" name="tel" placeholder="Teléfono de contacto" value="<?php echo isset($_POST["tel"]) ? $_POST["tel"] : ''  ?>" class="left" style="width:49%" onkeypress="return onlyNumbersDano(event)"/>
		<input type="text" name="direccion" placeholder="Dirección de Agencia" value="<?php echo isset($_POST["direccion"]) ? $_POST["direccion"] : ''  ?>" class="right" style="width:49%" />
		<select type="text" name="provincia" id="provincia" class="left" style="width:49%"/>
		<?php if(isset($_POST["provincia"])) {
echo "<option value=".$_POST["provincia"].">".$_POST["provincia"]."</option>";
} else {
		?>
		<option value="" disabled selected>Provincia de tu agencia</option><?php } ?>
		<?php Provincias_Read_Front(); ?>
		</select>
		<select type="text" name="localidad"  id="localidades" class="right" style="width:49%"/>
		<?php if(isset($_POST["localidad"])) {
echo "<option value=".$_POST["localidad"].">".$_POST["localidad"]."</option>";
} else {
		?>
		<option value="" disabled selected>Localidad de tu agencia</option><?php } ?>
		</select>

		<div class="clearfix">
			&zwnj;
		</div>
		<select name="tipo">
			<option value="1">Simple</option>
			<option value="2">Medio</option>
			<option value="3">Alto</option>
		</select>
		<div class="clearfix">
			&zwnj;
		</div>
		<span class='error' id="imgError" style="display: none"></span>
		<input type="file" name="img" class="input" onchange="checkFile(this)">		


		<br/>
		<br/>

		<a href="index.php" class="button left" style="background:#333">VOLVER</a>
		<input type="submit" class="button right" name="publicar" id="botonPubli" value="PUBLICAR MI AGENCIA"/>
	</form>
</div>
