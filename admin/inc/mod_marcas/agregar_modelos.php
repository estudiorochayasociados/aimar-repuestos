<div class="col-md-12">
	<h4>Agregar Modelos</h4>
	<hr/>
	<form  method="post" class="row">
		<?php
	$id = isset($_GET["id"]) ? $_GET["id"] : '';
	if (isset($_POST["publicar"])) {
		if ($_POST["nombre"] != '' && $_POST["categoria"] != '') {
			$subcategoria = isset($_POST["nombre"]) ? $_POST["nombre"] : '';
			$categoria = isset($_POST["categoria"]) ? $_POST["categoria"] : '';
			$idConn = Conectarse_Mysqli();
			$sql = "INSERT INTO `modelos_autos` (`modelo_marcas`,`marca_marcas`) VALUES ('$subcategoria','$categoria')";
			$resultado = mysqli_query($idConn, $sql);
			header("location:index.php?op=verSubcategoria");
		} else {
			echo "<span class='error'>Lo sentimos, todos los datos deben ser completados para subir la categoría.</span>";
		}
	}
	?>
		<label class="col-md-6">
			Modelo:<br/>
			<input type="text" name="modelo" class="form-control" value="<?php echo isset($_POST["modelo"]) ? $_POST["modelo"] : '' ?>" />
		</label>
		<label class="col-md-6">
			Marca:<br/>
			<select type="text" name="marca" class="form-control" >
				<option></option>
				<?php Traer_Marcas_Admin($id); ?>
			</select>
		</label>
		<div class="col-md-6">
			<input type="submit" class="btn btn-success" name="publicar" value="CREAR Modelo"/>
		</div>
	</form>
</div>