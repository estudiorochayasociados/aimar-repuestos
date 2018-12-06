<?php
$error = 0;
$query = '';
$con = Conectarse();

$headerTabla = "<thead><th>rubro</th><th>codigo_infocor</th><th>codigo_para_web</th><th>equivalencias</th><th>descripcion</th><th>posicion</th><th>diametro</th><th>altura</th><th>diametro_agujero_copa</th><th>cantidad_de_agujeros_agujeros</th><th>espesor</th><th>largo</th><th>cantidad_de_salidas</th><th>medida_de_rosca</th><th>lado</th><th>sistema</th><th>observaciones</th><th>variable 1</th><th>variable 2</th><th>variable 3</th><th>variable 4</th><th>variable 5</th><th>variable 6</th><th>variable 7</th><th>precio</th><th>stock</th></thead>";
$maximoColumnas = "Z";	
?>
<div class="col-md-12">
	<form action="index.php?op=importarProductos" method="post" enctype="multipart/form-data">
		<h3>Importar productos de Excel a la Web (<a href="uploads/modelo.xls" target="_blank">descargar modelo</a>)</h3>
		<hr/>
		<div class="row">
			<div class="col-md-6">
				<input type="file" name="uploadFile" class="form-control" value="" /><br/>
			</div>
			<div class="col-md-6">
				<input type="submit" name="submit" value="Ver archivo de Excel"  class='btn  btn-info' />
			</div>
		</div>
	</form>
	<?php
	if(isset($_POST['submit'])) {
		if(isset($_FILES['uploadFile']['name']) && $_FILES['uploadFile']['name'] != "") {
			$allowedExtensions = array("xls","xlsx");
			$ext = pathinfo($_FILES['uploadFile']['name'], PATHINFO_EXTENSION);
			if(in_array($ext, $allowedExtensions)) {
				$file_size = $_FILES['uploadFile']['size'] / 1024;
				$file = "uploads/".$_FILES['uploadFile']['name'];
				$isUploaded = copy($_FILES['uploadFile']['tmp_name'], $file);
				if($isUploaded) {
					include("Classes/PHPExcel/IOFactory.php");
					try {
						$objPHPExcel = PHPExcel_IOFactory::load($file);
					} catch (Exception $e) {
						die('Error loading file "' . pathinfo($file, PATHINFO_BASENAME). '": ' . $e->getMessage());
					}		
					$sheet = $objPHPExcel->getSheet(0);
					$total_rows = $sheet->getHighestRow();
					$highest_column = $sheet->getHighestColumn();			
					if($highest_column != $maximoColumnas) {
						echo 'Error en el formato del excel, hay más de las 3 columnas permitidas';
						$error = 1;
					}	

					if($error == 0) {
						echo "<form method='post'><input type='submit' class='btn  btn-success' name='subir' value='Ya lo revisé solo queda guardar'></form>";
					} else  {
						echo "hay algun error para poder subir";
					}		

					echo "<hr/>Total de Productos: ".$total_rows;

					echo '<h4>Datos traídos del excel:</h4>';
					echo '<table cellpadding="5" cellspacing="1"   class=" table table-hover table-bordered table-responsive">';
					echo $headerTabla;
					$query = "INSERT INTO `productos` (`rubro`, `codigo_infocor`, `codigo_para_web`, `equivalencias`, `descripcion`, `posicion`, `diametro`, `altura`, `diametro_agujero_copa`, `cantidad_de_agujeros_agujeros`, `espesor`, `largo`, `cantidad_de_salidas`, `medida_de_rosca`, `lado`, `sistema`, `observaciones`, `variable1`, `variable2`, `varaible3`, `variable4`, `variable5`, `variable6`, `variable7`,`precio`,`stock`) VALUES ";
					$i=0;
 					for($row =0; $row <= $total_rows+1; $row++) {									 
						$single_row = $sheet->rangeToArray('A' . $row . ':' . $highest_column . $row, NULL, TRUE, FALSE);
						$single_row[0][24] = number_format($single_row[0][24],2,'.','');
						if ($single_row[0][0] != '' ) {
							echo "<tr>";									
							$query .= "(";						
							foreach($single_row[0] as $key=>$value) {
								echo "<td>".$value."</td>";
								$query .= "'".mysqli_real_escape_string($con, trim($value))."',";
								//if($key == $columnaImagen) { $query .= "'archivos/productos/".mysqli_real_escape_string($con, trim($value)).".jpg',"; }
								//if($key == $columnaDescripcion) { $query .= "'".mysqli_real_escape_string($con, trim($value))."',"; }									
							}

							$query = substr($query, 0, -1);
							$query .= "),";
							echo "</tr>";
							$i++;
						}
					}
					$query = substr($query, 0, -1);
					echo '</table>';
					unlink($file);		
					$_SESSION["query"] = $query;			
				} else {
					echo '<span class="alert alert-danger">Archivo no subido</span>';
				}					 
			} else {
				echo '<span class="alert alert-danger">El tipo de archivo no es aceptado</span>';
			}
		} else {
			echo '<span class="alert alert-danger">Seleccionar primero el archivo a subir.</span>';
		}
	}


	if(isset($_POST["subir"])) {
		if(!empty($_SESSION["query"])) {
			mysqli_query($con, "truncate productos");
			mysqli_query($con, $_SESSION["query"]);
			if(mysqli_affected_rows($con) > 0) {
				echo '<span class="alert alert-success">Base de dato actualizada!</span>';
			} else {
				echo '<span class="alert alert-danger">No se pudo subir la base de datos.</span>';
			}
		}
	}
	?>
</div>