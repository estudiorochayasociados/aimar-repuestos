<?php
include ("dal/sms_data.php");
$prefijo = substr(md5(uniqid(rand())), 0, 10);

if (isset($_POST["agregar"])) {
	if ($_POST["titulo"] != '') {
		$titulo = $_POST["titulo"];
		$usuario = $_SESSION['usuario']['nombre_usuario'];

		$imgInicio = "";
		$destinoImg = "";
		$imgInicio = $_FILES["csv"]["tmp_name"];
		$tucadena = $_FILES["csv"]["name"];
		$partes = explode(".", $tucadena);
		$dominio = $partes[1];
		$mimes = array('text/csv', 'application/vnd.ms-excel');
		
		if(in_array($_FILES['csv']['type'],$mimes)){
			if ($dominio != '') {
				$destinoImg = "archivos/csv/" . $prefijo . "." . $dominio;
				$destinoFinal = "../archivos/csv/" . $prefijo . "." . $dominio;
				move_uploaded_file($imgInicio, $destinoFinal);
				chmod($destinoImg, 0777);
			} else {
				$destinoImg = $img;
			}
			$sql = "
			INSERT INTO `archivos_sms`
			(`UsuarioArchivo`, `TituloArchivo`, `TxtArchivo`,`ArchivoArchivo`,`FechaArchivo`) 
			VALUES 
			('$usuario','$titulo','$prefijo','$destinoImg',NOW())";
			$link = ConSms();
			$r = mysql_query($sql, $link);
	
			header("location:index.php?op=agregarMensajes&archivo=$prefijo");
		} else {
		echo "<br/><center><span class='large-11 button' style='background:#872F30'>* No es un archivo CSV delimitado por comas.</span></center>";
		}
	} else {
		echo "<br/><center><span class='large-11 button' style='background:#872F30'>* Todos los datos son obligatorios</span></center>";
	}
}
?>

<div class="large-12 columns">
	<h4>Agregar base de usuarios</h4>
	<hr/>
	<form method="post" enctype="multipart/form-data">
		<div class="row" >
			<center>
			<label class="large-4 "><b>Título</b>:
				<br/><br/>
				<input type="text" name="titulo" style="text-align: center;">
			</label>		
			<label class="large-6 "><b>Archivo csv</b> (<a href="../archivos/csv/usuarios.csv" target="_blank">descargar ejemplo</a>):<br/><br/>
				<input type="file" name="csv" style="width:150px;text-align: center;color:#fff;" />
			</label>
			<div class="clearfix">&zwnj;</div>
			<label>
				<input type="submit" class="button center" name="agregar" value="Subir Base" style="margin-right:20px;"/>
			</label>
			</center>
		</div>
	</form>
</div>
