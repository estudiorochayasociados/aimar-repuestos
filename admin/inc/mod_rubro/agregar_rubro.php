<div class="col-md-12">
	<h4>Agregar Categoría</h4>
	<hr/>
	<form  method="post" class="row">
		<?php
		if (isset($_POST["publicar"])) {
			if ($_POST["nombre"] != '') {
				$rubros = isset($_POST["nombre"]) ? $_POST["nombre"] : '';
				$codigo = isset($_POST["codigo"]) ? $_POST["codigo"] : '';
				$peso = isset($_POST["peso"]) ? $_POST["peso"] : '';
				$idConn = Conectarse_Mysqli();
				$sql = "INSERT INTO `rubros` (`titulo_rubros`,`cod_rubros`,`peso_rubros`) VALUES ('$rubros','$codigo','$peso')";
				$resultado = mysqli_query($idConn,$sql);
				header("location:index.php?op=verRubro");				
			} else {
				echo "<span class='error'>Lo sentimos, todos los datos deben ser completados para subir la categoría.</span>";
			}
		}
		?>
		<label class="col-md-3">Código:<br/>
			<input type="text" name="codigo" placeholder="Código" value="<?php echo isset($_POST["codigo"]) ? $_POST["codigo"] : ''  ?>" class="form-control" />
		</label>
		<label class="col-md-3">Rubro:<br/>
			<input type="text" name="nombre" placeholder="Rubro" value="<?php echo isset($_POST["nombre"]) ? $_POST["nombre"] : ''  ?>" class="form-control" />
		</label>
		<label class="col-md-3">Peso:<br/>
			<input type="text" name="peso" placeholder="Peso" value="<?php echo isset($_POST["peso"]) ? $_POST["peso"] : ''  ?>" class="form-control" />
		</label>
		<label class="col-md-3"><br/>
			<input type="submit" class="btn btn-success" name="publicar" value="Crear Rubro"/>
		</label>
	</form>
</div>