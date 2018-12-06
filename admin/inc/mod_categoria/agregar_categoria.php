<div class="col-md-12">
	<h4>Agregar Categoría</h4>
	<hr/>
	<form  method="post" class="row">
		<?php
		if (isset($_POST["publicar"])) {
			if ($_POST["nombre"] != '') {
				$categoria = isset($_POST["nombre"]) ? $_POST["nombre"] : '';
				$rubro = isset($_POST["rubro"]) ? $_POST["rubro"] : '';
				$filtro = implode(",", $_POST["filtros"]);
				$idConn = Conectarse_Mysqli();
				$sql =
				"INSERT INTO `categorias`(`nombre_categoria`,`rubro_categoria`,`filtro_categoria`)
				VALUES ('$categoria','$rubro','$filtro')";
				$resultado = mysqli_query($idConn,$sql);
				header("location:index.php?op=verCategoria");
			} else {
				echo "<span class='error'>Lo sentimos, todos los datos deben ser completados para subir la categoría.</span>";
			}
		}
		?>
		<div class="clearfix"></div>
		<label class="col-md-4">Categoría:
			<input type="text" name="nombre" placeholder="Categoría" value="<?php echo isset($_POST["nombre"]) ? $_POST["nombre"] : ''  ?>" class="form-control" />
		</label>
		<div class="clearfix"></div>
		<label class="col-md-4">Rubro (separados por coma):
			<input type="text" name="rubro" placeholder="Rubros" value="<?php echo isset($_POST["rubro"]) ? $_POST["rubro"] : ''  ?>" class="form-control" />
		</label>
		<div class="clearfix"></div>
		<label class="col-md-4">Filtro:<br/>
			<label><input type="checkbox" name="filtros[]" value="marca" > MARCA</label><br>
			<label><input type="checkbox" name="filtros[]" value="modelo" > MODELO</label><br>
			<label><input type="checkbox" name="filtros[]" value="codigo" > CODIGO</label><br>
			<label><input type="checkbox" name="filtros[]" value="diametro" > DIAMETRO</label><br>
			<label><input type="checkbox" name="filtros[]" value="largo" > LARGO</label><br>
			<label><input type="checkbox" name="filtros[]" value="rosca" > ROSCA</label><br>
		</label>
		<div class="clearfix"></div>
		<div class="col-md-4">
			<input type="submit" class="btn btn-success" name="publicar" value="CREAR CATEGORIA"/>
		</div>
	</form>
</div>