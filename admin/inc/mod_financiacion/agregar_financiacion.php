<?php
$random = substr(md5(uniqid(rand())), 0, 10);
$codigo = $random;
$area = "bancos";

if (isset($_POST["agregar"])) {
	$titulo = isset($_POST["titulo"]) ? $_POST["titulo"] : '';
	$desarrollo = isset($_POST["desarrollo"]) ? $_POST["desarrollo"] : ''; 
	$count = '';

	foreach ($_FILES['files']['name'] as $f => $name) {     
		$imgInicio = $_FILES["files"]["tmp_name"][$f];
		$tucadena = $_FILES["files"]["name"][$f];
		$partes = explode(".", $tucadena);
		$dom = (count($partes) - 1);
		$dominio = $partes[$dom];
		$prefijo = rand(0, 10000000);

		if ($dominio != '') {
			$destinoImg = "archivos/".$area."/" . $prefijo . "." . $dominio;
			$destinoFinal = "../archivos/".$area."/" . $prefijo . "." . $dominio;
			move_uploaded_file($imgInicio, $destinoFinal);
			chmod($destinoFinal, 0777);	
			$destinoRecortado = "../archivos/".$area."/recortadas/a_" . $prefijo . "." . $dominio;
			$destinoRecortadoFinal = "archivos/".$area."/recortadas/a_" . $prefijo . "." . $dominio;
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
		$sql = "INSERT INTO `imagenes`(`ruta`, `codigo`, `area`) VALUES ('$destinoRecortadoFinal','$codigo','$area')";
		$link = Conectarse();
		$r = mysql_query($sql, $link);
	}

	$sql2 = "
	INSERT INTO `financiacion`
	(`banco_financiacion`, `desarrollo_financiacion`, `cod_financiacion`)
	VALUES 
	('$titulo','$desarrollo','$codigo')";
	$link2= Conectarse();
	$r2 = mysql_query($sql2, $link2);

	header("location:index.php?op=verFinanciacion");
} 
?>

<div class="col-md-12 ">
	<h4>Financiación</h4>
	<hr/>
	<form method="post" enctype="multipart/form-data" onsubmit="showLoading()">
		<label class="col-md-8">Banco:<br/>
			<input type="text" name="titulo" value="" required class="form-control" size="50">
		</label> 		
		<div class="clearfix"></div>
		<label class="col-md-12">Desarrollo:<br/>
			<textarea name="desarrollo" class="form-control"  style="height:300px;display:block"></textarea>
			<script>
			CKEDITOR.replace('desarrollo');
			</script> 
		</label>		 
		<div class="clearfix"></div>
		<br/>
		<label class="col-md-7">Imágenes:<br/>
			<input type="file" id="file" name="files[]" accept="image/*" />
		</label>	
		<div class="clearfix"></div>
		        <label class="col-lg-12"><br/>
            <input type="submit" class="btn btn-primary" name="agregar" value="Agregar Financiación" />
        </label>				
	</form>
</div>
