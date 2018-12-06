<div class="col-md-12">
	<h4>Agregar Subcategoría</h4>
	<hr/>
	<form  method="post" class="row">
		<?php
		if (isset($_POST["publicar"])) {
			if ($_POST["nombre"] != '' && $_POST["categoria"] != '') {
				$subcategoria = isset($_POST["nombre"]) ? $_POST["nombre"] : '';
				$categoria = isset($_POST["categoria"]) ? $_POST["categoria"] : '';
				$idConn = Conectarse_Mysqli();
				$sql =
				"INSERT INTO `subcategorias`(`nombre_subcategoria`,`categoria_subcategoria`)
				VALUES ('$subcategoria','$categoria')";
				$resultado = mysqli_query($idConn,$sql);
				header("location:index.php?op=verSubcategoria");
			} else {
				echo "<span class='error'>Lo sentimos, todos los datos deben ser completados para subir la categoría.</span>";
			}
		}
		?>
		<label class="col-md-6">
			Subcategoria:<br/>
			<input type="text" name="nombre" placeholder="Subcategoría" class="form-control" value="<?php echo isset($_POST["nombre"]) ? $_POST["nombre"] : ''  ?>" />
		</label>
		<label class="col-md-6">
			Categoria:<br/>
			<select type="text" name="categoria" class="form-control" >
				<option></option>
				<?php Categoria_Read_Option(); ?>
			</select>
		</label>
		<div class="col-md-6">
			<input type="submit" class="btn btn-success" name="publicar" value="CREAR SUBCATEGORIA"/>
		</div>
	</form>
</div>