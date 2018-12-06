<div class="col-md-12">
	<h4>Agregar Marcas</h4>
	<hr/>
	<form  method="post" class="row">
		<?php
	if (isset($_POST["publicar"])) {
		if ($_POST["marca"] != '') {
			$marca = isset($_POST["marca"]) ? $_POST["marca"] : '';
			$idConn = Conectarse_Mysqli();
			$sql =
				"INSERT INTO `marcas_autos`(`marca_marcas`) VALUES ('$marca')";
			$resultado = mysqli_query($idConn, $sql);
			header("location:index.php?op=verMarcas");
		} else {
			echo "<span class='error'>Lo sentimos, todos los datos deben ser completados para subir la marcas.</span>";
		}
	}
	?>
		<div class="clearfix"></div>
		<label class="col-md-4">Marcas:
			<input type="text" name="marca" placeholder="Marcas" value="<?php echo isset($_POST["marca"]) ? $_POST["marca"] : '' ?>" class="form-control" />
		</label> 
		<div class="col-md-4">
			<input type="submit" class="btn btn-success" name="publicar" value="CREAR MARCAS"/>
		</div>
	</form>
</div>