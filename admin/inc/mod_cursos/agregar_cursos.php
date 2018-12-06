<?php
$random = rand(0, 10000000);
if (isset($_POST["agregar"])) {
	if ($_POST["titulo"] != '' && $_POST["desarrollo"]) {
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

		if ($dominio1 != '') {
			$destinoImg1 = "archivos/cursos/programas/" . $prefijo1 . "." . $dominio1;
			$destinoFinal1 = "../archivos/cursos/programas/" . $prefijo1 . "." . $dominio1;
			move_uploaded_file($imgInicio1, $destinoFinal1);
			chmod($destinoImg1, 0777);
		} else {
			$destinoImg1 = $img1;
		}
		/**** FIN PDF ***/ 
				

		$titulo = $_POST["titulo"];
		$desarrollo = $_POST["desarrollo"];
		$socio = $_POST["socio"];
		$lugar = $_POST["lugar"];
		$horarios = $_POST["horarios"];
		$inicio = $_POST["inicio"];
		
		$sql = "
			INSERT INTO `cursos`
			(`TituloCursos`, `DesarrolloCursos`, `InicioCursos`, `HorarioCursos`, `LugarCursos`, `ImgCursos`, `ProgramaCursos`, `SocioCursos`) 			
			VALUES 
			('$titulo','$desarrollo','$inicio', '$horarios', '$lugar', '$destinoImg', '$destinoImg1', '$socio')";
		$link = Conectarse();
		$r = mysql_query($sql, $link);

		header("location:index.php?op=verCursos");
	} else {
		echo "<br/><center><span class='large-11 button' style='background:#872F30'>* Todos los datos son obligatorios</span></center>";
	}
}
?>

<div class="columns">

	<h4>Agregar Curso</h4>
	<hr/>
	<form method="post" enctype="multipart/form-data">
		<label class="large-9 column">Título:
			<br/>
			<input type="text" name="titulo" value="">
		</label>
		<label class="large-3 column">¿Con quién?:
			<br/>
			<select name="socio">
				<option value="UNIVERSIDAD UB">UB</option>
				<option value="UNIVERSIDAD ESEADE">ESEADE</option>
				<option value="CENTRO GENESIN">CENTRO GENESIN</option>
				<option value="ESTUDIO ROCHA">ESTUDIO ROCHA</option>
			</select>
		</label>
		<div class="clearfix"></div>
		<label class="large-3 column">Fecha de Inicio:
			<br/>
			<input type="date" name="inicio" />
		</label>
		<label class="large-5 column">Lugar:
			<br/>
			<input type="text" name="lugar" />
		</label>
		<label class="large-4 column">Horarios:
			<br/>
			<input type="text" name="horarios" />
		</label>
		<div class="clearfix"></div>
		<label class="large-12 column">Desarrollo:
			<br/>
			<textarea name="desarrollo" style="height:300px;display:block"></textarea>
			<script>
				CKEDITOR.replace('desarrollo');
			</script> </label>
		<div class="clearfix"><br/></div>		
		<label class="large-6 column">Imagen:
			<br/><hr/>
			<input type="file" name="img" />
		</label>
		<label class="large-6 column">Programa (solo pdf):
			<br/><hr/>
			<input type="file" name="programa" />
		</label>
		<div class="clearfix"><br/></div>
		
		<label class="columns">
			<input type="submit" class="button right" name="agregar" value="Crear Curso" />
		</label>
	</form>
</div>