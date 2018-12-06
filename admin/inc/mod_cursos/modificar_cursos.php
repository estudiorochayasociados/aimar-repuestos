<?php
$id = isset($_GET['id']) ? $_GET['id'] : '';

if ($id != '') {
	$data = Cursos_TraerPorId($id);
	$img = isset($data["ImgCursos"]) ? $data["ImgCursos"] : '';
	$pdf = isset($data["ProgramaCursos"]) ? $data["ProgramaCursos"] : '';
}

if (isset($_POST['agregar'])) {
	if ($_POST["titulo"] != '' && $_POST["desarrollo"] != '') {

		/**** IMG ***/
		$imgInicio = "";
		$destinoImg = "";
		$prefijo = substr(md5(uniqid(rand())), 0, 15);
		$imgInicio = $_FILES["img"]["tmp_name"];
		$tucadena = $_FILES["img"]["name"];
		$partes = explode(".", $tucadena);
		$dominio = $partes[1];

		if ($dominio != '') {
			$destinoImg = "archivos/cursos/img/" . $prefijo . "." . $dominio;
			$destinoFinal = "../archivos/cursos/img/" . $prefijo . "." . $dominio;
			move_uploaded_file($imgInicio, $destinoFinal);
			chmod($destinoImg, 0777);
		} else {
			$destinoImg = $img;
		}
		/**** FIN IMG ***/

		/**** PDF ***/
		
		$imgInicio1 = "";
		$destinoImg1 = "";
		$prefijo1 = substr(md5(uniqid(rand())), 0, 15);
		$imgInicio1 = $_FILES["programa"]["tmp_name"];
		$tucadena1 = $_FILES["programa"]["name"];
		$partes1 = explode(".", $tucadena1);
		$dominio1 = $partes1[1];

		if ($tucadena1 != '') {
			$destinoImg1 = "archivos/cursos/programas/" . $prefijo1 . "." . $dominio1;
			$destinoFinal1 = "../archivos/cursos/programas/" . $prefijo1 . "." . $dominio1;
			move_uploaded_file($imgInicio1, $destinoFinal1);
			chmod($destinoImg1, 0777);
		} else {
			$destinoImg1 = $pdf;
		}
		/**** FIN PDF ***/

		$titulo = $_POST["titulo"];
		$desarrollo = $_POST["desarrollo"];
		$socio = $_POST["socio"];
		$lugar = $_POST["lugar"];
		$horarios = $_POST["horarios"];
		$inicio = $_POST["inicio"];

		$sql = "
			UPDATE `cursos` SET 
			`TituloCursos`= '$titulo',
			`DesarrolloCursos`= '$desarrollo',
			`InicioCursos`= '$inicio',
			`HorarioCursos`= '$horarios',
			`LugarCursos`= '$lugar',
			`SocioCursos`= '$socio',
			`ImgCursos`= '$destinoImg',
			`ProgramaCursos`= '$destinoImg1'
			WHERE `IdCursos`= $id";
		$link = Conectarse();
		$r = mysql_query($sql, $link);

		header("location:index.php?op=verCursos");
	}
}
?>

<div class="columns">

	<h4>Modificar Curso &rarr; <?php echo $data["TituloCursos"] ?></h4>
	<hr/>
	<form method="post" enctype="multipart/form-data">
		<label class="large-9 column">Título:
			<br/>
			<input type="text" name="titulo" value="<?php echo $data["TituloCursos"] ?>">
		</label>
		<label class="large-3 column">¿Con quién?:
			<br/>
			<select name="socio">
				<option value="<?php echo $data["SocioCursos"] ?>"> Elegido &rarr; <?php echo $data["SocioCursos"] ?> </option>
				<option value="UNIVERSIDAD DE BELGRANO">UNIVERSIDAD DE BELGRANO</option>
				<option value="UNIVERSIDAD ESEADE">UNIVERSIDAD ESEADE</option>
				<option value="CENTRO GENESIN">CENTRO GENESIN</option>
				<option value="ESTUDIO ROCHA">ESTUDIO ROCHA</option>
			</select> </label>
		<div class="clearfix"></div>
		<label class="large-3 column">Fecha de Inicio:
			<br/>
			<input type="date" name="inicio" value="<?php echo $data["InicioCursos"] ?>"/>
		</label>
		<label class="large-5 column">Lugar:
			<br/>
			<input type="text" name="lugar" value="<?php echo $data["LugarCursos"] ?>" />
		</label>
		<label class="large-4 column">Horarios:
			<br/>
			<input type="text" name="horarios"  value="<?php echo $data["HorarioCursos"] ?>" />
		</label>
		<div class="clearfix"></div>
		<label class="large-12 column">Desarrollo:
			<br/>
			<textarea name="desarrollo" style="height:300px;display:block"><?php echo $data["DesarrolloCursos"] ?></textarea>
			<script>
				CKEDITOR.replace('desarrollo');
			</script> </label>
		<div class="clearfix">
			<br/>
		</div>
		<div class="large-4 column">
			<?php if($img === '') {
			?><br/>
		Imagen
		<br/>
			<label class="">
				<input type="file" name="img" />
			</label>
			<?php }else { ?>
			<br/>
			Imagen
			<br/>
			<br/>
			<img src="../<?php echo $img ?>" width="100%" />
			<br/>
			<label class="">
				<p>
					&rarr; Cambiar
				</p>
				<input type="file" name="img" style="display:none"/>
				<div class="clearfix"></div> </label>
			<?php } ?>
		</div>
		<?php if($pdf === '') {
		?><br/>
		Programa
		<br/>
		<label class="large-8 column">
			<input type="file" name="programa" />
		</label>
		<?php }else { ?>
		<br/>
		Programa
		<br/>
		<br/>
		<a href="../<?php echo $pdf ?>" class="button" target="_blank">Ver Programa</a>
		<br/>
		<label class="large-8 column">
			<p>
				&rarr; Cambiar
			</p>
			<input type="file" name="programa" id="programa" style="display:none"/>
			<div class="clearfix"></div> </label>
		<?php } ?>

		<label>
			<div class="clearfix">
				<br/>
			</div>
			<input type="submit" class="button right" name="agregar" value="Modificar Curso" />
		</label>
	</form>
</div>
